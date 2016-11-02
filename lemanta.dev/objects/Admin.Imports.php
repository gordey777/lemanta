<?php
  // Impera CMS: админ модуль списка вариантов импортов,
  //             админ модуль страницы варианта импорта.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined('ROOT_FOLDER_REFERENCE')) return;
  if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
  if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

  require_once(ROOT_FOLDER_REFERENCE . 'objects/Definition.php');
  require_once(ROOT_FOLDER_REFERENCE . 'objects/Basic.php');
  require_once(ROOT_FOLDER_REFERENCE . 'admin/pclzip/pclzip.lib.php');

  // TODO: заменить позже, сейчас подключается только ради myExtractCallBack
  require_once(ROOT_FOLDER_REFERENCE . 'objects/Admin.Images.php');

  // какая страница возврата рекомендуется для модуля страницы варианта импорта
  define('ADMIN_IMPORT_CLASS_RESULT_PAGE', 'index.php?section=Imports');

  // какая папка является принимающей файлы для импорта (папку задаем относительно административной папки сайта),
  define('ADMIN_IMPORTS_CLASS_UPLOAD_FOLDER', '');

  // период невозможности использовать аварийно прервавшийся импорт
  define('IMPORT_CRASH_RESTORE_LIFETIME', 300);

  // предельное количество частей в дробных колонках импортируемых данных
  define('IMPORT_COLUMN_PARTS_MAXCOUNT', 256);

  // транзитный файл при импорте из удаленного источника
  define('IMPORT_TRANSIT_FILENAME', 'auto_import_content.txt');

  // значения режимов вызова импорта
  define('IMPORT_START_MODE_MANUALLY', 0);
  define('IMPORT_START_MODE_AUTOMATIC', IMPORT_START_MODE_MANUALLY + 1);
  define('IMPORT_START_MODE_REMOTE', IMPORT_START_MODE_AUTOMATIC + 1);

  // маркер непринипиальности к изменению значения в поле
  define('IMPORT_NOT_FUNDAMENTAL_COLUMN_MARKER', '~');

  // имена форматов импорта
  define('IMPORT_FORMAT_NAME_XLSHTML', 'xls html');
  define('IMPORT_FORMAT_NAME_CSV', 'csv');
  define('IMPORT_FORMAT_NAME_COMMERCEML', 'commerceml');

  // типы импортируемой информации через CommerceML
  define('IMPORT_COMMERCEML_TYPE_CATALOG', 'catalog');
  define('IMPORT_COMMERCEML_TYPE_SALE', 'sale');

  // режимы подключения к точке импорта через CommerceML
  define('IMPORT_COMMERCEML_MODE_AUTHORIZATION', 'checkauth');
  define('IMPORT_COMMERCEML_MODE_INITIALIZATION', 'init');
  define('IMPORT_COMMERCEML_MODE_FILEUPLOAD', 'file');
  define('IMPORT_COMMERCEML_MODE_STARTIMPORT', 'import');



  // =========================================================================
  // Класс Imports (админ модуль списка вариантов импорта)
  // =========================================================================

  class Imports extends Basic {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'imports';
    public $dbtable_field = 'import_id';

    // рекомендуемая страница возврата после операции,
    // в какую папку выгружать файлы,
    // сколько записей размещать на странице
    public $result_page = '';
    public $upload_folder = ADMIN_IMPORTS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_IMPORTS_ON_PAGE_IN_ADMIN;

    // оперируемая запись
    protected $item = null;

    // количественные результаты импорта
    protected $categories_added = 0;
    protected $brands_added = 0;
    protected $products_added = 0;
    protected $products_updated = 0;
    protected $products_skiped = 0;
    protected $products_deleted_ancientQ0 = 0;
    protected $products_deleted_ancientS0 = 0;
    protected $variants_added = 0;
    protected $variants_updated = 0;
    protected $variants_skiped = 0;
    protected $properties_added = 0;
    protected $statistic_data = null;

    // память свойств товаров (для накопления свойств в процессе импорта повторных строк товара)
    protected $properties_RAM = array();



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }



    // обработка соответствующих модулю настроек сайта =======================

    protected function process_setup () {
    }

    // обработка входных параметров и команд =================================

    protected function process () {

      // пока никаких изменений в базе данных нет,
      // по умолчанию все команды позволяют на последнем запросе отследить изменения в базе данных,
      // пока нет отмены перенаправления на страницу возврата
      $this->changed = FALSE;
      $watching = TRUE;
      $cancel = FALSE;

      // читаем входной параметр ITEMID - идентификатор оперируемой записи,
      // параметр FROM - на какую страницу вернуться после операции,
      // параметр ACTION - какую команду требовали сделать
      $id = trim($this->param('item_id'));
      $result_page = trim($this->param('from'));
      $act = trim($this->param('act'));

      // если действительно передали идентификатор оперируемой записи
      if (!empty($id)) {

        // создаем пустой массив для запросов
        $query = array();

        // какую команду требовали сделать во входном параметре ACTION?
        switch ($act) {

          // если команду "Удалить запись"
          case ACTION_REQUEST_PARAM_VALUE_DELETE:
            $this->action_delete($id, $query);
            break;

          // если команду "Разрешить / запретить использование варианта"
          case ACTION_REQUEST_PARAM_VALUE_ENABLED:
            $this->action_enabled($id, $query);
            break;

        }

        // если получен набор запросов, то есть готовы выполнить операцию,
        //   проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
        //   делаем все запросы операции,
        //   если для команды не снято отслеживание изменений в базе данных, делаем его оценкой затронутых записей
        //   если страница возврата не указана, используем рекомендуемую страницу возврата
        if (!empty($query)) {
          $this->check_token();
          if ($this->config->demo && $this->dbtable == 'imports') {
            $this->push_error('В демо версии запрещено модифицировать записи вариантов импорта.');
            return;
          }
          foreach ($query as &$command) $this->db->query($command);
          if ($watching) $this->changed = $this->changed || ($this->db->affected_rows() > 0);
          if (empty($result_page)) $result_page = trim($this->result_page);
        }
      }

      // обрабатываем редакторские изменения в записях (битовый OR использован для гарантии выполнения метода posting() независимо от настроек препроцессора)
      $cancel = $this->posting($result_page) | $cancel;

      // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
      if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
    }

    // обработка редактирования записей ======================================

    protected function posting (&$result_page) {

      // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
      $cancel = FALSE;

      // если получены данные об изменениях
      if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST])) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        if ($this->config->demo && $this->dbtable == 'imports') {
          return $this->push_error('В демо версии запрещено редактировать варианты импорта.');
        }

        // цикл по измененным записям
        foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {
          $item_cancel = FALSE;
          $value = $this->dbtable_field;

          // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
          $this->item = null;

          // для какой таблицы базы данных предназначена запись?
          switch ($this->dbtable) {
            case 'imports':
              // поле created (дата создания)
              if (isset($_POST['created'][$id])) $this->item->created = $this->date->fixDate($_POST['created'][$id]);
              // поле enabled (разрешено ли использование варианта)
              $this->item->enabled = isset($_POST['enabled'][$id]) ? (($_POST['enabled'][$id] == 1) ? 1 : 0) : 0;
              // поле name (название)
              $this->editor->processName($this->item, $id, $item_cancel);
              // полe url (адрес страницы интерфейса) - может быть незаполненным
              $this->editor->processUrl($this->item, $id, $item_cancel, TRUE);
              // поле password (пароль доступа к интерфейсу)
              if (isset($_POST['password'][$id])) $this->item->password = trim($_POST['password'][$id]);
              // поле filename (URL внешнего файла - это поле нужно обработать до поля automatic)
              $this->process_filename($this->item, $id, $item_cancel);
              // полe format (формат импортируемых данных)
              $this->process_format($this->item, $id, $item_cancel);
              // полe delimiter (символ деления строки данных на поля)
              $this->process_delimiter($this->item, $id, $item_cancel);
              // полe automatic (разрешен ли запуск по расписанию)
              $this->process_automatic($this->item, $id, $item_cancel);
              // поле lifetime (значение паузы между сеансами)
              if (isset($_POST['lifetime'][$id])) $this->item->lifetime = trim($_POST['lifetime'][$id]);
              // поле before_action (разрешено ли использование варианта)
              $this->item->before_action = isset($_POST['before_action'][$id]) ? trim($_POST['before_action'][$id]) : BEFORE_IMPORT_OPERATION_NO_ACTION;
              // поле marketing_update (перезапись маркетинговых полей)
              $this->item->marketing_update = isset($_POST['marketing_update'][$id]) ? (($_POST['marketing_update'][$id] == 1) ? 1 : 0) : 0;
              // поле financial_update (перезапись количественных полей)
              $this->item->financial_update = isset($_POST['financial_update'][$id]) ? (($_POST['financial_update'][$id] == 1) ? 1 : 0) : 0;
              // полe columns (поля)
              $this->process_columns($this->item, $id, $item_cancel);
              break;
          }

          // поле идентификатора записи
          if (!empty($id) && !empty($this->item)) {
            // это не добавление новой записи, поэтому устанавливаем идентификатор записи
            $this->item->$value = $id;
          } else {
            // если не передано значение даты для новой записи, ставим дату создания равной текущей дате
            if (!isset($this->item->created)) $this->item->created = time();
          }

          // если ошибок нет (не включился признак отмены)
          if (!$item_cancel && !empty($this->item)) {
            // обновляем запись в базе данных (битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора)
            $this->changed = ($this->update($this->item) != '') | $this->changed;
            // если страница возврата не указана, используем рекомендуемую страницу
            if (empty($result_page)) $result_page = trim($this->result_page);
          }

          $cancel = $cancel || $item_cancel;
        }
      }

      // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
      return $cancel;
    }

    // обработка изменения поля FORMAT записи ================================

    private function process_format (&$item, $id, &$cancel) {
      if (isset($_POST['format'][$id])) {
        switch ($this->dbtable) {
          case 'imports':
            $item->format = trim($_POST['format'][$id]);
            if ($item->format == '') $cancel = $this->push_error('Не задан формат импортируемых данных.');
            break;
        }
      }
    }

    // обработка изменения поля DELIMITER записи =============================

    private function process_delimiter (&$item, $id, &$cancel) {
      if (isset($_POST['delimiter'][$id])) {
        switch ($this->dbtable) {
          case 'imports':
            $item->delimiter = $_POST['delimiter'][$id];
            if ($item->delimiter == '') $cancel = $this->push_error('Не задан символ деления строки данных на поля.');
            break;
        }
      }
    }

    // обработка изменения поля FILENAME записи ==============================

    private function process_filename (&$item, $id, &$cancel) {
      if (isset($_POST['filename'][$id])) {
        $item->filename = trim($_POST['filename'][$id]);
        $item->filename = str_replace('\\', '/', $item->filename);
        if (!empty($item->filename) && !preg_match("'^http://[^/]+(/.*)?$'i", $item->filename)) $cancel = $this->push_error('URL внешнего файла должен содержать по крайней мере протокол и домен (например http://сайт/...).');
      }
    }

    // обработка изменения поля AUTOMATIC записи =============================

    private function process_automatic (&$item, $id, &$cancel) {
      switch ($this->dbtable) {
        case 'imports':
          $item->automatic = isset($_POST['automatic'][$id]) ? ($_POST['automatic'][$id] == 1 ? 1 : 0) : 0;
          if ($item->automatic == 1 && empty($item->filename)) $cancel = $this->push_error('При автоматическом запуске импорта необходимо указать URL внешнего файла, из которого будет произведен импорт данных.');
          break;
      }
    }

    // обработка изменения поля COLUMNS записи ===============================

    private function process_columns (&$item, $id, &$cancel) {
      if (isset($_POST['columns'][$id])) {
        switch ($this->dbtable) {
          case 'imports':
            $item->columns = $_POST['columns'][$id];
            $item->columns = str_replace("\r", ' ', $item->columns);
            $item->columns = str_replace("\n", ' ', $item->columns);
            $item->columns = str_replace("\t", ' ', $item->columns);
            while (strpos($item->columns, '  ') !== FALSE) $item->columns = str_replace('  ', ' ', $item->columns);
            $item->columns = trim($item->columns);
            if ($item->columns == '') $cancel = $this->push_error('Не указано мнемоническое описание порядка полей в импортируемых данных.');
            break;
        }
      }
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->imports->update($item);
    }



    // обработка данных о категории ==========================================

    private function process_category ( & $category = null, $section, & $url = '' ) {

        // если ветвь категории передана не массивом, раскладываем в массив
        if (!isset($category->value)) $category->value = array();
        if (!is_array($category->value)) {
            $category->value = preg_replace('![/|\\\\]!', '/', $category->value);
            $category->value = explode('/', $category->value);
        }

        // если ИД ветвь категории передана не массивом, раскладываем в массив
        if (!isset($category->id)) $category->id = array();
        if (!is_array($category->id)) {
            $category->id = preg_replace('![/|\\\\]!', '/', $category->id);
            $category->id = explode('/', $category->id);
        }

        // если СинхроИД ветвь категории передана не массивом, раскладываем в массив
        if (!isset($category->sync_id)) $category->sync_id = array();
        if (!is_array($category->sync_id)) {
            $category->sync_id = preg_replace('![/|\\\\]!', '/', $category->sync_id);
            $category->sync_id = explode('/', $category->sync_id);
        }

        // начнем поиск/добавление от корня дерева категорий
        $id = 0;
        $category->ids = array();
        $my_sync_ok = TRUE;
        $my_sync_id = '';

        // пока составной url категории не сформирован
        $url = '';

        // идем по звеньям ветви категории
        foreach ($category->value as $i => $name) {

            // удаляем из названия теги HTML-разметки, сокращаем цепочки избыточных пробелов
            $name = $this->text->stripTags($name, TRUE);

            // помним, что приоритетным является ИД звена
            $my_id = isset($category->id[$i]) ? intval($category->id[$i]) : 0;

            // может быть указан СинхроИД ?
            if ($my_sync_ok) {
                $value = isset($category->sync_id[$i]) ? trim($category->sync_id[$i]) : '';
                $my_sync_ok = $value != '';
                $my_sync_id = (($my_sync_id != '') ? '/' : '') . $value;
            }



            // если для звена указали ИД или СинхроИД или название
            if (!empty($my_id) || $my_sync_ok || ($name != '')) {

                // готовимся к поиску
                $params = new stdClass;

                // если задан ИД
                if (!empty($my_id)) {

                    // будем искать только по ИД категории
                    $params->id = $my_id;

                // иначе если задан СинхроИД
                } elseif ($my_sync_ok) {

                    // будем искать только по СинхроИД категории
                    $params->sync_id = $my_sync_id;

                // иначе не заданы ИД или СинхроИД
                } else {

                    // будем искать по названию или названию в единственном числе
                    $params->name = $name;
                    $params->single_name = $name;
                        // + которая привязана к такой родительской ветви
                        $params->parent = $id;
                        // + которая имеет такой код раздела магазина
                        $params->section = $section;
                }

                // пробуем найти запись
                $this->db->get_category($item, $params);



                // если такая категория не существует
                if (empty($item)) {

                    // готовим поля добавляемой записи
                    $item = new stdClass;
                        // название категории
                        $item->name = ($name != '') ? $name : 'Категория с id = ' . $my_id;
                        // ИД родительской ветви
                        $item->parent = $id;
                        // код раздела магазина
                        $item->section = $section;
                        // категория сразу разрешена на сайте
                        $item->enabled = 1;
                        // синхронизационный идентификатор
                        $item->sync_id = $my_sync_ok ? $my_sync_id : '';

                    // признак "пока не чистить кеш" (это не конечная операция)
                    $item->indifferent_caches = TRUE;

                    // если был указан ИД звена
                    if (!empty($my_id)) {

                        // признак "прошу обновить запись с таким ИД"
                        $item->category_id = $my_id;

                        // признак "ПРИКАЗЫВАЮ сделать именно вставку записи"
                        // (не обновление записи по ИД, то есть игнорировать признак "прошу обновить запись с таким ИД")
                        $item->do_insert_operation = TRUE;
                    }

                    // добавляем запись
                    $item->category_id = $this->db->categories->update($item);

                    // +1 категорию добавили
                    if (!empty($item->category_id)) $this->categories_added++;



                // иначе категория существует
                } else {

                    // если был указан ИД и отличающееся название звена или отличающийся СинхроИД
                    if (!empty($my_id) && (($name != '') && ($name != $item->name)
                                          || $my_sync_ok && ($my_sync_id != $item->sync_id))) {

                        // готовим обновляемые поля записи
                        $params = new stdClass;
                            // новое название категории
                            if (($name != '') && ($name != $item->name)) $params->name = $name;
                            // новый СинхроИД категории
                            if ($my_sync_ok && ($my_sync_id != $item->sync_id)) $params->sync_id = $my_sync_id;

                        // признак "прошу обновить запись с таким ИД"
                        $params->category_id = $item->category_id;

                        // признак "пока не чистить кеш" (это не конечная операция)
                        $params->indifferent_caches = TRUE;

                        // обновляем запись
                        $this->db->categories->update($params);
                    }
                }



                // если категория существует или добавлена
                if (isset($item->category_id) && !empty($item->category_id)) {

                    // далее поиск/добавление будем вести от этой категории
                    $id = $item->category_id;
                    $category->ids[] = $id;

                    // дополняем составной url транслитом названия текущего звена ветви
                    if ($url != '') $url .= '/';
                    $name = $this->hdd->safeFilename(preg_replace('![/\\\:\?#]!', ' ', $name), TRUE, 48);
                    $url .= ($name != '') ? $name : 'category' . $id;

                    // если у категории пустой url или равен идентификатору, меняем на человеко-понятный
                    if (!isset($item->url) || (trim($item->url) == '') || (trim($item->url) == $id)) {

                        // готовим обновляемые поля записи
                        $params = new stdClass;
                            // новый url категории
                            $params->url = $url;

                        // признак "прошу обновить запись с таким ИД"
                        $params->category_id = $id;

                        // признак "пока не чистить кеш" (это не конечная операция)
                        $params->indifferent_caches = TRUE;

                        // обновляем запись
                        $this->db->categories->update($params);
                    }
                }
            }
        }



        // возвращаем массив идентификаторов всех звеньев ветви категории
        return $category->ids;
    }



    // обработка данных о бренде =============================================

    private function process_brand ( & $brand = null, $section, & $url = '' ) {

        // если ветвь бренда передана не массивом, раскладываем в массив
        if (!isset($brand->value)) $brand->value = array();
        if (!is_array($brand->value)) {
            $brand->value = preg_replace('![/|\\\\]!', '/', $brand->value);
            $brand->value = explode('/', $brand->value);
        }

        // если ИД ветвь бренда передана не массивом, раскладываем в массив
        if (!isset($brand->id)) $brand->id = array();
        if (!is_array($brand->id)) {
            $brand->id = preg_replace('![/|\\\\]!', '/', $brand->id);
            $brand->id = explode('/', $brand->id);
        }

        // если СинхроИД ветвь бренда передана не массивом, раскладываем в массив
        if (!isset($brand->sync_id)) $brand->sync_id = array();
        if (!is_array($brand->sync_id)) {
            $brand->sync_id = preg_replace('![/|\\\\]!', '/', $brand->sync_id);
            $brand->sync_id = explode('/', $brand->sync_id);
        }

        // начнем поиск/добавление от корня дерева брендов
        $id = 0;
        $brand->ids = array();
        $my_sync_ok = TRUE;
        $my_sync_id = '';

        // пока составной url бренда не сформирован
        $url = '';

        // идем по звеньям ветви бренда
        foreach ($brand->value as $i => $name) {

            // удаляем из названия теги HTML-разметки, сокращаем цепочки избыточных пробелов
            $name = $this->text->stripTags($name, TRUE);

            // помним, что приоритетным является ИД звена
            $my_id = isset($brand->id[$i]) ? intval($brand->id[$i]) : 0;

            // может быть указан СинхроИД ?
            if ($my_sync_ok) {
                $value = isset($brand->sync_id[$i]) ? trim($brand->sync_id[$i]) : '';
                $my_sync_ok = $value != '';
                $my_sync_id = ($my_sync_id != '' ? '/' : '') . $value;
            }

            // если для звена указали ИД или СинхроИД или название
            if (!empty($my_id) || $my_sync_ok || $name != '') {

                // готовимся к поиску
                $params = new stdClass;

                // если задан ИД
                if (!empty($my_id)) {

                    // будем искать только по ИД бренда
                    $params->id = $my_id;

                // иначе если задан СинхроИД
                } elseif ($my_sync_ok) {

                    // будем искать только по СинхроИД бренда
                    $params->sync_id = $my_sync_id;

                // иначе не заданы ИД или СинхроИД
                } else {

                    // будем искать по названию
                    $params->name = $name;
                        // + который привязан к такой родительской ветви
                        $params->parent = $id;
                        // + который имеет такой код раздела магазина
                        $params->section = $section;
                }

                // пробуем найти запись
                $this->db->get_brand($item, $params);

                // если такой бренд не существует
                if (empty($item)) {

                    // готовим поля добавляемой записи
                    $item = new stdClass;
                        // название бренда
                        $item->name = ($name != '') ? $name : 'Бренд с id = ' . $my_id;
                        // ИД родительской ветви
                        $item->parent = $id;
                        // код раздела магазина
                        $item->section = $section;
                        // бренд сразу разрешен на сайте
                        $item->enabled = 1;
                        // синхронизационный идентификатор
                        $item->sync_id = $my_sync_ok ? $my_sync_id : '';

                    // признак "пока не чистить кеш" (это не конечная операция)
                    $item->indifferent_caches = TRUE;

                    // если был указан ИД звена
                    if (!empty($my_id)) {

                        // признак "прошу обновить запись с таким ИД"
                        $item->brand_id = $my_id;

                        // признак "ПРИКАЗЫВАЮ сделать именно вставку записи"
                        // (не обновление записи по ИД, то есть игнорировать признак "прошу обновить запись с таким ИД")
                        $item->do_insert_operation = TRUE;
                    }

                    // добавляем запись
                    $item->brand_id = $this->db->brands->update($item);

                    // +1 бренд добавили
                    if (!empty($item->brand_id)) $this->brands_added++;

                // иначе бренд существует
                } else {

                    // если был указан ИД и отличающееся название звена или отличающийся СинхроИД
                    if (!empty($my_id) && ($name != '' && $name != $item->name
                                          || $my_sync_ok && $my_sync_id != $item->sync_id)) {

                        // готовим обновляемые поля записи
                        $params = new stdClass;
                            // новое название бренда
                            if ($name != '' && $name != $item->name) $params->name = $name;
                            // новый СинхроИД бренда
                            if ($my_sync_ok && $my_sync_id != $item->sync_id) $params->sync_id = $my_sync_id;

                        // признак "прошу обновить запись с таким ИД"
                        $params->brand_id = $item->brand_id;

                        // признак "пока не чистить кеш" (это не конечная операция)
                        $params->indifferent_caches = TRUE;

                        // обновляем запись
                        $this->db->brands->update($params);
                    }
                }

                // если бренд существует или добавлен
                if (isset($item->brand_id) && !empty($item->brand_id)) {

                    // далее поиск/добавление будем вести от этого бренда
                    $id = $item->brand_id;
                    $brand->ids[] = $id;

                    // дополняем составной url транслитом названия текущего звена ветви
                    if ($url != '') $url .= '/';
                    $name = $this->hdd->safeFilename(preg_replace('![/\\\:\?#]!', ' ', $name), TRUE, 48);
                    $url .= $name != '' ? $name : 'brand' . $id;

                    // если у бренда пустой url или равен идентификатору, меняем на человеко-понятный
                    if (!isset($item->url) || trim($item->url) == '' || trim($item->url) == $id) {

                        // готовим обновляемые поля записи
                        $params = new stdClass;
                            // новый url бренда
                            $params->url = $url;

                        // признак "прошу обновить запись с таким ИД"
                        $params->brand_id = $id;

                        // признак "пока не чистить кеш" (это не конечная операция)
                        $params->indifferent_caches = TRUE;

                        // обновляем запись
                        $this->db->brands->update($params);
                    }
                }
            }
        }

        // возвращаем массив идентификаторов всех звеньев ветви бренда
        return $brand->ids;
    }



    // обработка данных о свойстве товара ====================================

    private function process_property ($name, $value, $category_ids, $brand_ids) {

      // пока идентификатор свойства не известен
      $id = 0;
      $value = trim($value);

      // пробуем найти запись такого свойства
      $params = new stdClass;
      $params->name = $name;
      $this->db->get_property($item, $params);

      // если такое свойство не существует, добавляем запись о нем
      if (empty($item)) {
        $item = new stdClass;
        $item->name = $name;
        $item->in_product = 1;
        $item->in_filter = 1;
        $item->in_compare = 1;
        $item->enabled = 1;
        $item->options = array();
          if ($value != '') $item->options[] = $value;
        $item->categories = array();
          if (!empty($category_ids)) {
            if (is_array($category_ids)) {
              foreach ($category_ids as $category_id) {
                $item->categories[$category_id] = $category_id;
              }
            } else {
              $item->categories[$category_ids] = $category_ids;
            }
          }
        $item->brands = array();
          if (!empty($brand_ids)) {
            if (is_array($brand_ids)) {
              foreach ($brand_ids as $brand_id) {
                $item->brands[$brand_id] = $brand_id;
              }
            } else {
              $item->brands[$brand_ids] = $brand_ids;
            }
          }
        $item->property_id = $this->db->update_property($item);
        $this->properties_added++;

      // иначе будем обновлять запись свойства
      } else {
        $changed = FALSE;

        // смотрим дополнения в списке возможных значений свойства
        if ($value != '') {
          $changed = TRUE;
          $test = strtolower($value);
          foreach ($item->options as &$option) {
            if (strtolower(trim($option)) == $test) {
              $changed = FALSE;
              break;
            }
          }
          if ($changed) $item->options[] = $value;
        }

        // смотрим дополнения в списке категорий
        if (!empty($category_ids)) {
          if (is_array($category_ids)) {
            foreach ($category_ids as $category_id) {
              if (!isset($item->categories[$category_id])) {
                $item->categories[$category_id] = $category_id;
                $changed = TRUE;
              }
            }
          } else {
            if (!isset($item->categories[$category_ids])) {
              $item->categories[$category_ids] = $category_ids;
              $changed = TRUE;
            }
          }
        }

        // смотрим дополнения в списке брендов
        if (!empty($brand_ids)) {
          if (is_array($brand_ids)) {
            foreach ($brand_ids as $brand_id) {
              if (!isset($item->brands[$brand_id])) {
                $item->brands[$brand_id] = $brand_id;
                $changed = TRUE;
              }
            }
          } else {
            if (!isset($item->brands[$brand_ids])) {
              $item->brands[$brand_ids] = $brand_ids;
              $changed = TRUE;
            }
          }
        }

        // если были изменения в записи, обновляем
        if ($changed) $this->db->update_property($item);
      }

      // если все прошло нормально, берем идентификатор свойства
      if (!empty($item->property_id)) $id = $item->property_id;

      // возвращаем идентификатор свойства
      return $id;
    }



    // извлечение и обработка данных о ветке категории / бренда ==============

    private function process_branch ( & $branch = null, $section, & $params = array(), $mnemonic = 'category', $separator = '/' ) {

        // готовим результирующую структуру
        $branch = new stdClass;
        $branch->id = '';
        $branch->sync_id = '';
        $branch->value = '';
        $branch->isset = FALSE;
        $branch->fundamental = TRUE;

        // корректируем параметр $mnemonic (мнемоника элемента)
        $mnemonic = strtolower(trim($mnemonic));
        switch ($mnemonic) {
            case 'category':
            case 'brand':
                break;
            default:
                $mnemonic = 'category';
        }

        // корректируем параметр $params (сведения о ячейках импортируемой строки)
        if (!is_array($params)) $params = array();

        // корректируем параметр $seperator (разделитель названий элементов ветви)
        if ($separator == '') $separator = '/';

        // читаем данные ветви (склеиваем $mnemonic, $mnemonic+2, $mnemonic+3 и так далее через символ $separator)
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
            $id = '';
            $sync_id = '';
            $value = '';

            // берем ИД элемента ветви
            $n = $mnemonic . 'id' . ($i > 1 ? $i : '');
            if (isset($params[$n])) {
                $branch->isset = TRUE;
                $branch->fundamental = $branch->fundamental && $params[$n]->fundamental;

                // заменяем теги пробелами и сокращаем повторяющиеся пробелы
                $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
                $id = $params[$n]->value;
            }

            // берем СинхроИД элемента ветви
            $n = $mnemonic . 'syncid' . ($i > 1 ? $i : '');
            if (isset($params[$n])) {
                $branch->isset = TRUE;
                $branch->fundamental = $branch->fundamental && $params[$n]->fundamental;

                // заменяем теги пробелами и сокращаем повторяющиеся пробелы
                $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
                $sync_id = $params[$n]->value;
            }

            // берем название элемента ветви
            $n = $mnemonic . ($i > 1 ? $i : '');
            if (isset($params[$n])) {
                $branch->isset = TRUE;
                $branch->fundamental = $branch->fundamental && $params[$n]->fundamental;

                // заменяем теги пробелами и сокращаем повторяющиеся пробелы
                $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
                $value = $params[$n]->value;
            }

            // если указан ИД или СинхроИД или название элемента ветви
            if (!empty($id) || $sync_id != '' || $value != '') {

                // раскладываем ИД, СинхроИД и название в массивы
                $id = preg_replace('![/|\\\\]!', $separator, $id);
                $id = explode($separator, $id);

                $sync_id = preg_replace('![/|\\\\]!', $separator, $sync_id);
                $sync_id = explode($separator, $sync_id);

                $value = preg_replace('![/|\\\\]!', $separator, $value);
                $value = explode($separator, $value);

                // синхронизируем количество ИД, СинхроИД и названий со стороны ИД
                foreach ($id as $n => & $v) {
                    $id[$n] = trim($id[$n]);

                    // если ИД задан
                    if (!empty($id[$n])) {

                        // если нет пары СинхроИД, создаем пару
                        if (!isset($sync_id[$n])) $sync_id[$n] = '';

                        // если нет пары Название, создаем пару
                        if (!isset($value[$n])) $value[$n] = '';

                    // иначе ИД пустой
                    } else {

                        // если нет пары СинхроИД или Название, удаляем ИД
                        if (!isset($sync_id[$n]) && !isset($value[$n])) {
                            unset($id[$n]);

                        // иначе если пара СинхроИД и Название пустая, удаляем всех
                        } elseif ((!isset($sync_id[$n]) || trim($sync_id[$n]) == '')
                                 && (!isset($value[$n]) || trim($value[$n]) == '')) {
                            unset($id[$n]);
                            if (isset($sync_id[$n])) unset($sync_id[$n]);
                            if (isset($value[$n])) unset($value[$n]);

                        // иначе соблюдаем взаимность пар
                        } else {
                            if (!isset($sync_id[$n])) $sync_id[$n] = '';
                            if (!isset($value[$n])) $value[$n] = '';
                        }
                    }
                }
                $id = array_values($id);
                $sync_id = array_values($sync_id);
                $value = array_values($value);

                // синхронизируем количество ИД, СинхроИД и названий со стороны СинхроИД
                foreach ($sync_id as $n => & $v) {
                    $sync_id[$n] = trim($sync_id[$n]);

                    // если СинхроИД задан
                    if ($sync_id[$n] != '') {

                        // если нет пары ИД, создаем пару
                        if (!isset($id[$n])) $id[$n] = '';

                        // если нет пары Название, создаем пару
                        if (!isset($value[$n])) $value[$n] = '';

                    // иначе СинхроИД пустой
                    } else {

                        // если нет пары ИД или Название, удаляем СинхроИД
                        if (!isset($id[$n]) && !isset($value[$n])) {
                            unset($sync_id[$n]);

                        // иначе если пара ИД и Название пустая, удаляем всех
                        } elseif ((!isset($id[$n]) || empty($id[$n]))
                                 && (!isset($value[$n]) || trim($value[$n]) == '')) {
                            if (isset($id[$n])) unset($id[$n]);
                            unset($sync_id[$n]);
                            if (isset($value[$n])) unset($value[$n]);

                        // иначе соблюдаем взаимность пар
                        } else {
                            if (!isset($id[$n])) $id[$n] = '';
                            if (!isset($value[$n])) $value[$n] = '';
                        }
                    }
                }
                $id = array_values($id);
                $sync_id = array_values($sync_id);
                $value = array_values($value);

                // синхронизируем количество ИД, СинхроИД и названий со стороны названий
                foreach ($value as $n => & $v) {
                    $value[$n] = trim($value[$n]);

                    // если название задано
                    if ($value[$n] != '') {

                        // если нет пары ИД, создаем пару
                        if (!isset($id[$n])) $id[$n] = '';

                        // если нет пары СинхроИД, создаем пару
                        if (!isset($sync_id[$n])) $sync_id[$n] = '';

                    // иначе название пустое
                    } else {

                        // если нет пары ИД или СинхроИД, удаляем название
                        if (!isset($id[$n]) && !isset($sync_id[$n])) {
                            unset($value[$n]);

                        // иначе если пара ИД и СинхроИД пустая, удаляем всех
                        } elseif ((!isset($id[$n]) || empty($id[$n]))
                                 && (!isset($sync_id[$n]) || trim($sync_id[$n]) == '')) {
                            if (isset($id[$n])) unset($id[$n]);
                            if (isset($sync_id[$n])) unset($sync_id[$n]);
                            unset($value[$n]);

                        // иначе соблюдаем взаимность пар
                        } else {
                            if (!isset($id[$n])) $id[$n] = '';
                            if (!isset($sync_id[$n])) $sync_id[$n] = '';
                        }
                    }
                }
                $id = array_values($id);
                $sync_id = array_values($sync_id);
                $value = array_values($value);

                // добавляем в общие ИД и название
                if (!empty($id) || !empty($sync_id) || !empty($value)) {
                    $branch->id .= ($branch->id != '' ? $separator : '') . implode($separator, $id);
                    $branch->sync_id .= ($branch->sync_id != '' ? $separator : '') . implode($separator, $sync_id);
                    $branch->value .= ($branch->value != '' ? $separator : '') . implode($separator, $value);
                }
            }
            $i++;
        }

        // добавляем/проверяем элемент ветви (виртуальный url элемента получим в $branch->url)
        switch ($mnemonic) {
            case 'brand':
                $branch->ids = $this->process_brand($branch, $section, $branch->url);
                break;
            case 'category':
            default:
                $branch->ids = $this->process_category($branch, $section, $branch->url);
        }

        // запоминаем ИД последнего элемента в ветви
        $branch->id = !empty($branch->ids) ? $branch->ids[count($branch->ids) - 1] : 0;
    }



        // ===================================================================
        /**
        *  Обработка сведений о файлах, прикрепленных в запись
        *
        *  @access  private
        *  @param   array   $params         массив прочитанных значений импортируемой строки
        *  @param   string  $mnemonic       мнемоника полей
        *  @param   boolean $need_alts      TRUE если нужны Alt-надписи
        *  @param   boolean $need_texts     TRUE если нужно описание
        *  @param   boolean $need_view      TRUE если нужны признаки показа в слайдере
        *  @return  object                  сведения
        */
        // ===================================================================

        private function process_attachments ( & $params,
                                               $mnemonic,
                                               $need_alts = TRUE,
                                               $need_texts = TRUE,
                                               $need_view = TRUE ) {

            // готовим структуру
            $data = new stdClass;
            $data->value = array();
            if ($need_alts)  $data->alts = array();
            if ($need_texts) $data->texts = array();
            if ($need_view)  $data->view = array();
            $data->isset = FALSE;
            $data->fundamental = TRUE;

            // читаем данные изображений товара
            $delimiter = IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER;
            $i = 1;
            while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
                $attachment = array();
                $alt = array();
                $text = '';
                $view = array(1);

                // извлекаем список URL прикрепленных файлов
                $n = $mnemonic . (($i > 1) ? $i : '');
                if (isset($params[$n]->value)) {
                    $data->isset = TRUE;
                    $data->fundamental = $data->fundamental && $params[$n]->fundamental;

                    // заменяем теги пробелами и сокращаем повторяющиеся пробелы
                    $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);

                    // раскладываем URL-и (перечисленные через запятую) в массив
                    if ($params[$n]->value != '') {
                        $attachment = trim(str_replace($delimiter, '', $params[$n]->value));
                        $attachment = explode(',', $attachment);
                    }
                }

                // если был перечислен хотя бы один URL
                if (is_array($attachment) && !empty($attachment)) {

                    // извлекаем список Alt-надписей для файлов
                    if ($need_alts) {
                        $n = $mnemonic . 'alt' . (($i > 1) ? $i : '');
                        if (isset($params[$n]->value)) {
                            $data->fundamental = $data->fundamental && $params[$n]->fundamental;

                            // заменяем теги пробелами и сокращаем повторяющиеся пробелы
                            $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);

                            // раскладываем надписи (перечисленные через запятую) в массив
                            if ($params[$n]->value != '') {
                                $alt = trim(str_replace($delimiter, '', $params[$n]->value));
                                $alt = explode(',', $alt);
                            }
                        }
                    }

                    // извлекаем общее описание для файлов
                    if ($need_texts) {
                        $n = $mnemonic . 'text' . (($i > 1) ? $i : '');
                        if (isset($params[$n]->value)) {
                            $data->fundamental = $data->fundamental && $params[$n]->fundamental;
                            $params[$n]->value = trim($params[$n]->value);
                            if ($params[$n]->value != '') {
                                $text = trim(str_replace($delimiter, '', $params[$n]->value));
                            }
                        }
                    }

                    // извлекаем список признаков (показа в слайдере) для файлов
                    if ($need_view) {
                        $n = $mnemonic . 'view' . (($i > 1) ? $i : '');
                        if (isset($params[$n]->value)) {
                            $data->fundamental = $data->fundamental && $params[$n]->fundamental;
                            $view = trim(str_replace($delimiter, '', $params[$n]->value));
                            $view = explode(',', $view);
                        }
                    }

                    // сохраняем каждый URL в сведениях
                    foreach ($attachment as $j => $url) {
                        $url = trim($url);
                        if (($url != '') && !in_array($url, $data->value)) {

                            // url
                            $data->value[] = $url;

                            // надпись
                            if ($need_alts) {
                                $n = count($alt) == 1 ? $alt[0] : (isset($alt[$j]) ? $alt[$j] : '');
                                $data->alts[] = trim($n);
                            }

                            // описание
                            if ($need_texts) {
                                $data->texts[] = $text;
                            }

                            // признак показа в слайдере
                            if ($need_view) {
                                $n = count($view) == 1 ? $view[0] : (isset($view[$j]) ? $view[$j] : 1);
                                $data->view[] = trim($n) == 1 ? 1 : 0;
                            }
                        }
                    }
                }
                $i++;
            }

            // сведения отдаем в виде строк с перечислением через символ |
            $data->value = implode($delimiter, $data->value);
            if (isset($data->alts))  $data->alts = implode($delimiter, $data->alts);
            if (isset($data->texts)) $data->texts = implode($delimiter, $data->texts);
            if (isset($data->view))  $data->view = implode($delimiter, $data->view);

            // возвращаем сведения
            return $data;
        }



    // обработка данных о товаре =============================================

    private function process_product ( $params ) {

        // читаем данные раздела магазина
        $section = isset($params['section']) ? intval($params['section']->value) : 1;
        $section = max(1, $section);

        // читаем идентификационные данные о товаре
        $pid = isset($params['productid']) ? $this->text->stripTags($params['productid']->value, TRUE) : '';
        $sku = isset($params['sku']) ? $this->text->stripTags($params['sku']->value, TRUE) : '';
        $model = isset($params['model']) ? $this->text->stripTags($params['model']->value, TRUE) : '';

        // читаем в $category данные ветви категории и обрабатываем
        $this->process_branch($category,
                              $section,
                              $params,
                              'category',
                              '/');

        // читаем в $brand данные ветви бренда и обрабатываем
        $this->process_branch($brand,
                              $section,
                              $params,
                              'brand',
                              '/');

        // если указан идентификатор или название товара, но не указана категория или бренд
        if ($pid != '' || $model != '') {
          if (!$category->isset || !$brand->isset) {

            // задаем фильтр записи товара
            if ($pid != '') {
              $where = DATABASE_PRODUCTS_TABLENAME . ".product_id = '" . $this->db->query_value($pid) . "' ";
            } else {
              $where = DATABASE_PRODUCTS_TABLENAME . ".model = '" . $this->db->query_value($model) . "' "
                               . "AND " . DATABASE_PRODUCTS_TABLENAME . ".section = '" . $this->db->query_value($section) . "' ";
              if (!empty($category->ids)) $where .= "AND " . DATABASE_PRODUCTS_TABLENAME . ".category_id = '" . $this->db->query_value($category->id) . "' ";
              if (!empty($brand->ids)) $where .= "AND " . DATABASE_PRODUCTS_TABLENAME . ".brand_id = '" . $this->db->query_value($brand->id) . "' ";
            }

            // извлекаем из базы сведения о категории и бренде товара
            $query = "SELECT " . DATABASE_PRODUCTS_TABLENAME . ".category_id, "
                               . DATABASE_CATEGORIES_TABLENAME . ".url AS category_url, "
                               . DATABASE_CATEGORIES_TABLENAME . ".parent AS category_parent, "
                               . DATABASE_PRODUCTS_TABLENAME . ".brand_id, "
                               . DATABASE_BRANDS_TABLENAME . ".url AS brand_url, "
                               . DATABASE_BRANDS_TABLENAME . ".parent AS brand_parent "
                   . "FROM " . DATABASE_PRODUCTS_TABLENAME . " "
                   . "LEFT JOIN " . DATABASE_CATEGORIES_TABLENAME . " "
                             . "ON " . DATABASE_PRODUCTS_TABLENAME . ".category_id = " . DATABASE_CATEGORIES_TABLENAME . ".category_id "
                   . "LEFT JOIN " . DATABASE_BRANDS_TABLENAME . " "
                             . "ON " . DATABASE_PRODUCTS_TABLENAME . ".brand_id = " . DATABASE_BRANDS_TABLENAME . ".brand_id "
                   . "WHERE " . $where
                   . "LIMIT 1;";
            $this->db->query($query);
            $found = $this->db->result();

            // если извлечено
            if (!empty($found)) {

              // если не была указана категория, пользуемся извлеченными сведениями
              if (!$category->isset && !empty($found->category_id)) {
                $category->url = !empty($found->category_url) ? trim($found->category_url) : "";
                $category->id = $found->category_id;
                $category->ids = array();

                // извлекаем массив идентификаторов всех звеньев ветви категории
                $temp = $found;
                while (!empty($found)) {

                  // вталкиваем звено в начало массива, так как извлекаем их от конца ветви к началу
                  array_unshift($category->ids, $found->category_id);

                  // если добрались верха или нашли закольцовку, прерываемся
                  if (empty($found->category_parent)
                  || in_array($found->category_parent, $category->ids)) break;

                  // извлекаем из базы сведения о вышестоящем звене
                  $query = "SELECT " . DATABASE_CATEGORIES_TABLENAME . ".category_id, "
                                     . DATABASE_CATEGORIES_TABLENAME . ".parent AS category_parent "
                         . "FROM " . DATABASE_CATEGORIES_TABLENAME . " "
                         . "WHERE " . DATABASE_CATEGORIES_TABLENAME . ".category_id = '" . $this->db->query_value($found->category_parent) . "' "
                         . "LIMIT 1;";
                  $this->db->query($query);
                  $found = $this->db->result();
                }
                $found = $temp;
              }

              // если не был указан бренд, пользуемся извлеченными сведениями
              if (!$brand->isset && !empty($found->brand_id)) {
                $brand->url = !empty($found->brand_url) ? trim($found->brand_url) : "";
                $brand->id = $found->brand_id;
                $brand->ids = array();

                // извлекаем массив идентификаторов всех звеньев ветви бренда
                $temp = $found;
                while (!empty($found)) {

                  // вталкиваем звено в начало массива, так как извлекаем их от конца ветви к началу
                  array_unshift($brand->ids, $found->brand_id);

                  // если добрались верха или нашли закольцовку, прерываемся
                  if (empty($found->brand_parent)
                  || in_array($found->brand_parent, $brand->ids)) break;

                  // извлекаем из базы сведения о вышестоящем звене
                  $query = "SELECT " . DATABASE_BRANDS_TABLENAME . ".brand_id, "
                                     . DATABASE_BRANDS_TABLENAME . ".parent AS brand_parent "
                         . "FROM " . DATABASE_BRANDS_TABLENAME . " "
                         . "WHERE " . DATABASE_BRANDS_TABLENAME . ".brand_id = '" . $this->db->query_value($found->brand_parent) . "' "
                         . "LIMIT 1;";
                  $this->db->query($query);
                  $found = $this->db->result();
                }
                $found = $temp;
              }
            }
          }
        }

        // читаем данные свойств товара, каждое имеет формат СВОЙСТВО[:ЗНАЧЕНИЕ] в propertyX
        // или СВОЙСТВО в propertyX и ЗНАЧЕНИЕ в propValueX и ПОРЯДКОВЫЙ НОМЕР в propOrderX
        $properties = array();
        $property = "";
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "property" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            // заменяем теги пробелами и сокращаем повторяющиеся пробелы
            $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
            if ($params[$n]->value != "") {
              $property = $params[$n]->value;
              $value = "";
              $pos = strpos($property, ":");
              if ($pos !== FALSE) {
                $value = trim(substr($property, $pos + 1));
                $property = trim(substr($property, 0, $pos));
              }
              if ($property != "") {
                // берем значение и порядковый номер
                $n = "propvalue" . (($i > 1) ? $i : "");
                $n = isset($params[$n]) ? $this->text->stripTags($params[$n]->value, TRUE) : "";
                if ($n != "") $value = $n;
                $n = "proporder" . (($i > 1) ? $i : "");
                $order = isset($params[$n]) ? intval($params[$n]->value) : 0;
                // добавляем/проверяем свойство товара
                $property_id = $this->process_property($property, $value, $category->ids, $brand->ids);
                if (($property_id != 0) && ($value != "")) $properties[$order . "_" . count($properties)] = array($property_id, $value);
              }
            }
          }
          $i++;
        }



        // читаем данные изображений товара
        $images = $this->process_attachments($params, 'images', TRUE, TRUE, TRUE);



        // читаем данные файлов товара (без view-признаков)
        $files = $this->process_attachments($params, 'files', TRUE, TRUE, FALSE);



        // цены варианта товара
        $price = array();
        for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
            $n = 'price' . (($i > 1) ? $i : '');
            $price[$i] = isset($params[$n]) ? str_replace(',', '.', $this->text->stripTags($params[$n]->value, TRUE)) : '';
        }



        // читаем данные товара
        if (isset($params["variant"])) $variant = $this->text->stripTags($params["variant"]->value, TRUE); else $variant = "";
        if (isset($params["oldprice"])) $old_price = str_replace(",", ".", $this->text->stripTags($params["oldprice"]->value, TRUE)); else $old_price = "";
        if (isset($params["tempprice"])) $temp_price = str_replace(",", ".", $this->text->stripTags($params["tempprice"]->value, TRUE)); else $temp_price = "";
        if (isset($params["discount"])) $discount = str_replace(",", ".", $this->text->stripTags($params["discount"]->value, TRUE)); else $discount = "";
        if (isset($params["quantity"])) $quantity = intval($params["quantity"]->value); else $quantity = 0;
        if (isset($params["guarantee"])) $guarantee = $this->text->stripTags($params["guarantee"]->value, TRUE); else $guarantee = "";
        if (isset($params["annotation"])) $description = trim($params["annotation"]->value); else $description = "";

        // описание (составное поле)
        $body = new stdClass;
        $body->value = "";
        $body->isset = FALSE;
        $body->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "description" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $body->isset = TRUE;
            $body->fundamental = $body->fundamental && $params[$n]->fundamental;
            $body->value = trim($body->value . " " . trim($params[$n]->value));
          }
          $i++;
        }
        $body->value = str_replace("`", "'", $body->value);

        // SEO текст (составное поле)
        $seo = new stdClass;
        $seo->value = "";
        $seo->isset = FALSE;
        $seo->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "seo" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $seo->isset = TRUE;
            $seo->fundamental = $seo->fundamental && $params[$n]->fundamental;
            $seo->value = trim($seo->value . " " . trim($params[$n]->value));
          }
          $i++;
        }
        $seo->value = str_replace("`", "'", $seo->value);

        // url товара
        $url = isset($params['url']) ? $this->hdd->safeFilename($params['url']->value, FALSE) : '';
        $url_special = isset($params["urlspecial"]) ? ((trim($params["urlspecial"]->value) != 1) ? 0 : 1) : 0;

        // мета заголовок
        $meta_title = isset($params["metatitle"]) ? $this->text->stripTags($params["metatitle"]->value, TRUE) : "";

        // ключевые слова (составное поле)
        $meta_keywords = new stdClass;
        $meta_keywords->value = "";
        $meta_keywords->isset = FALSE;
        $meta_keywords->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "metakeyword" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $meta_keywords->isset = TRUE;
            $meta_keywords->fundamental = $meta_keywords->fundamental && $params[$n]->fundamental;
            // заменяем теги пробелами и сокращаем повторяющиеся пробелы
            $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
            if ($params[$n]->value != "") {
              $meta_keywords->value .= (($meta_keywords->value != "") ? "," : "") . $params[$n]->value;
            }
          }
          $i++;
        }
        $meta_keywords->value = str_replace("`", "'", $meta_keywords->value);
        $meta_keywords->value = str_replace(" ,", ",", $meta_keywords->value);
        $meta_keywords->value = str_replace(", ", ",", $meta_keywords->value);
        while (strpos($meta_keywords->value, ",,") !== FALSE) $meta_keywords->value = str_replace(",,", ",", $meta_keywords->value);
        while (substr($meta_keywords->value, 0, 1) == ",") $meta_keywords->value = substr($meta_keywords->value, 1);
        while (substr($meta_keywords->value, -1) == ",") $meta_keywords->value = substr($meta_keywords->value, 0, -1);
        $meta_keywords->value = str_replace(",", ", ", $meta_keywords->value);

        // мета описание (составное поле)
        $meta_description = new stdClass;
        $meta_description->value = "";
        $meta_description->isset = FALSE;
        $meta_description->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "metadescription" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $meta_description->isset = TRUE;
            $meta_description->fundamental = $meta_description->fundamental && $params[$n]->fundamental;
            // заменяем теги пробелами и сокращаем повторяющиеся пробелы
            $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
            if ($params[$n]->value != "") {
              $meta_description->value .= (($meta_description->value != "") ? " " : "") . $params[$n]->value;
            }
          }
          $i++;
        }
        $meta_description->value = str_replace("`", "'", $meta_description->value);

        // признак Товар виден на сайте, Выделен визуально, Скрыт от чужих, Разрешен к обсуждению
        $enabled = isset($params["enabled"]) ? ((trim($params["enabled"]->value) != 1) ? 0 : 1) : 1;
        $highlighted = isset($params["highlighted"]) ? ((trim($params["highlighted"]->value) != 1) ? 0 : 1) : 0;
        $hidden = isset($params["hidden"]) ? ((trim($params["hidden"]->value) != 1) ? 0 : 1) : 0;
        $commented = isset($params["commented"]) ? ((trim($params["commented"]->value) != 1) ? 0 : 1) : 0;

        // признаки Хит, Новинка, Акционный, Скоро в продаже
        $hit = isset($params["hit"]) ? ((trim($params["hit"]->value) != 1) ? 0 : 1) : 0;
        $newest = isset($params["newest"]) ? ((trim($params["newest"]->value) != 1) ? 0 : 1) : 0;
        $actional = isset($params["actional"]) ? ((trim($params["actional"]->value) != 1) ? 0 : 1) : 0;
        $awaited = isset($params["awaited"]) ? ((trim($params["awaited"]->value) != 1) ? 0 : 1) : 0;

        // признаки Экспорт в Яндекс.Маркет, Экспорт ВКонтакте
        $ymarket = isset($params["ymarket"]) ? ((trim($params["ymarket"]->value) != 1) ? 0 : 1) : 1;
        $vkontakte = isset($params["vkontakte"]) ? ((trim($params["vkontakte"]->value) != 1) ? 0 : 1) : 1;

        // признаки Не для RSS, Не для информеров, Не продавать в кредит
        $rss_disabled = isset($params["rssdisabled"]) ? ((trim($params["rssdisabled"]->value) != 1) ? 0 : 1) : 0;
        $export_disabled = isset($params["informerdisabled"]) ? ((trim($params["informerdisabled"]->value) != 1) ? 0 : 1) : 0;
        $non_creditable = isset($params["noncreditable"]) ? ((trim($params["noncreditable"]->value) != 1) ? 0 : 1) : 0;

        if (isset($params["smallimage"])) $small_image = $this->text->stripTags($params["smallimage"]->value, TRUE); else $small_image = "";
        if (isset($params["largeimage"])) $large_image = $this->text->stripTags($params["largeimage"]->value, TRUE); else $large_image = "";

        // буквенный и штрихкод товара
        $pcode = isset($params["pcode"]) ? $this->text->stripTags($params["pcode"]->value, TRUE) : "";
        $barcode = isset($params["barcode"]) ? $this->text->stripTags($params["barcode"]->value, TRUE) : "";



        // идентификаторы дополнительных товаров (аксессуаров)
        $i = isset($params['accessoryproducts']) ? $this->text->stripTags($params['accessoryproducts']->value, TRUE) : '';
        $i = explode(',', $i);
        $accessory_pids = array();
        foreach ($i as $n) {
            $n = intval($n);
            if (!empty($n)) $accessory_pids[$n] = $n;
        }
        if (!empty($accessory_pids)) sort($accessory_pids, SORT_NUMERIC);
        $accessory_pids = implode(',', $accessory_pids);



        // идентификаторы похожих товаров
        $i = isset($params['relatedproducts']) ? $this->text->stripTags($params['relatedproducts']->value, TRUE) : '';
        $i = explode(',', $i);
        $related_pids = array();
        foreach ($i as $n) {
            $n = intval($n);
            if (!empty($n)) $related_pids[$n] = $n;
        }
        if (!empty($related_pids)) sort($related_pids, SORT_NUMERIC);
        $related_pids = implode(',', $related_pids);



        // идентификаторы похожих категорий
        $i = isset($params['relatedcategories']) ? $this->text->stripTags($params['relatedcategories']->value, TRUE) : '';
        $i = explode(',', $i);
        $related_cids = array();
        foreach ($i as $n) {
            $n = intval($n);
            if (!empty($n)) $related_cids[$n] = $n;
        }
        if (!empty($related_cids)) sort($related_cids, SORT_NUMERIC);
        $related_cids = implode(',', $related_cids);



        // идентификаторы похожих брендов
        $i = isset($params['relatedbrands']) ? $this->text->stripTags($params['relatedbrands']->value, TRUE) : '';
        $i = explode(',', $i);
        $related_bids = array();
        foreach ($i as $n) {
            $n = intval($n);
            if (!empty($n)) $related_bids[$n] = $n;
        }
        if (!empty($related_bids)) sort($related_bids, SORT_NUMERIC);
        $related_bids = implode(',', $related_bids);



        // видео файлы (составное поле)
        $video = new stdClass;
        $video->value = "";
        $video->isset = FALSE;
        $video->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "video" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $video->isset = TRUE;
            $video->fundamental = $video->fundamental && $params[$n]->fundamental;
            $params[$n]->value = trim($params[$n]->value);
            if ($params[$n]->value != "") {
              $video->value .= (($video->value != "") ? ", " : "") . $params[$n]->value;
            }
          }
          $i++;
        }

        // количество голосов, рейтинг, число просмотров
        $votes = isset($params["votes"]) ? $this->db->value_as_natural($params["votes"]->value) : 0;
        $rating = isset($params["rating"]) ? $this->db->value_as_positive($params["rating"]->value) : 0;
        $browsed = isset($params["browsed"]) ? $this->db->value_as_natural($params["browsed"]->value) : 0;

        // порядки (веса)
        $order_num = isset($params["order"]) ? $this->db->value_as_integer($params["order"]->value) : 0;
        $order_num_hit = isset($params["orderhit"]) ? $this->db->value_as_integer($params["orderhit"]->value) : 0;
        $order_num_newest = isset($params["ordernewest"]) ? $this->db->value_as_integer($params["ordernewest"]->value) : 0;
        $order_num_actional = isset($params["orderactional"]) ? $this->db->value_as_integer($params["orderactional"]->value) : 0;
        $order_num_awaited = isset($params["orderawaited"]) ? $this->db->value_as_integer($params["orderawaited"]->value) : 0;

        // субдомен, разрешение субдомена, контент субдомена (составное поле)
        $subdomain = isset($params["subdomain"]) ? $this->text->stripTags($params["subdomain"]->value, TRUE) : "";
        $subdomain = $this->fix_subdomain($subdomain);
        $subdomain_enabled = isset($params["subdomainenabled"]) ? ((trim($params["subdomainenabled"]->value) != 1) ? 0 : 1) : 0;
        $subdomain_html = new stdClass;
        $subdomain_html->value = "";
        $subdomain_html->isset = FALSE;
        $subdomain_html->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "subdomainhtml" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $subdomain_html->isset = TRUE;
            $subdomain_html->fundamental = $subdomain_html->fundamental && $params[$n]->fundamental;
            $subdomain_html->value = trim($subdomain_html->value . " " . trim($params[$n]->value));
          }
          $i++;
        }
        $subdomain_html->value = str_replace("`", "'", $subdomain_html->value);

        // теги (составное поле)
        $tags = new stdClass;
        $tags->value = "";
        $tags->isset = FALSE;
        $tags->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "tags" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $tags->isset = TRUE;
            $tags->fundamental = $tags->fundamental && $params[$n]->fundamental;
            // заменяем теги пробелами и сокращаем повторяющиеся пробелы
            $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
            if ($params[$n]->value != "") {
              $tags->value .= (($tags->value != "") ? "," : "") . $params[$n]->value;
            }
          }
          $i++;
        }
        $tags->value = str_replace("`", "'", $tags->value);
        $tags->value = str_replace(" ,", ",", $tags->value);
        $tags->value = str_replace(", ", ",", $tags->value);
        while (strpos($tags->value, ",,") !== FALSE) $tags->value = str_replace(",,", ",", $tags->value);
        while (substr($tags->value, 0, 1) == ",") $tags->value = substr($tags->value, 1);
        while (substr($tags->value, -1) == ",") $tags->value = substr($tags->value, 0, -1);
        $tags->value = str_replace(",", ", ", $tags->value);

        // модули (составное поле)
        $objects = new stdClass;
        $objects->value = "";
        $objects->isset = FALSE;
        $objects->fundamental = TRUE;
        $i = 1;
        while ($i <= IMPORT_COLUMN_PARTS_MAXCOUNT) {
          $n = "modules" . (($i > 1) ? $i : "");
          if (isset($params[$n])) {
            $objects->isset = TRUE;
            $objects->fundamental = $objects->fundamental && $params[$n]->fundamental;
            // заменяем теги пробелами и сокращаем повторяющиеся пробелы
            $params[$n]->value = $this->text->stripTags($params[$n]->value, TRUE);
            if ($params[$n]->value != "") {
              $objects->value .= (($objects->value != "") ? "," : "") . $params[$n]->value;
            }
          }
          $i++;
        }
        $objects->value = str_replace(" ,", ",", $objects->value);
        $objects->value = str_replace(", ", ",", $objects->value);
          // удаляем неверно (не по классу) названные модули
          $objects->value = "," . $objects->value . ",";
          while (strpos($objects->value, ",,") !== FALSE) $objects->value = str_replace(",,", ",", $objects->value);
          $objects->value = preg_replace("',[^a-z][^,]*,'i", ",", $objects->value);
          $objects->value = preg_replace("',[a-z0-9_]+?[^a-z0-9_,][^,]*,'i", ",", $objects->value);
        while (substr($objects->value, 0, 1) == ",") $objects->value = substr($objects->value, 1);
        while (substr($objects->value, -1) == ",") $objects->value = substr($objects->value, 0, -1);
        $objects->value = str_replace(",", ", ", $objects->value);

        // шаблон страницы
        $template = isset($params['template']) ? $this->hdd->safeFilename($params['template']->value, FALSE) : '';
        if (!preg_match("'.+\.(htm|tpl|php)$'i", $template)) $template = "";

        if (isset($params["comedate"])) $coming = $this->text->stripTags($params["comedate"]->value, TRUE); else $coming = "";
        if (isset($params["created"])) $created = $this->text->stripTags($params["created"]->value, TRUE); else $created = date("Y-m-d H:i:s", time());
        $modified = date("Y-m-d H:i:s", time());

        // если задан артикул, название или идентификатор товара
        if ($sku != '' || $model != '' || $pid != '') {
          $found = null;

          // если задан артикул, пробуем найти такой товар
          if ($sku != "") {
            $query = "SELECT product_id, "
                          . "variant_id "
                   . "FROM products_variants "
                   . "WHERE sku = '" . $this->db->query_value($sku) . "' "
                   . "LIMIT 1";
            $this->db->query($query);
            $found = $this->db->result();
          }

          // если товар не найден, пробуем найти по идентификатору или названию
          if (empty($found)) {
            if ($pid != "") {
              $where = DATABASE_PRODUCTS_TABLENAME . ".product_id = '" . $this->db->query_value($pid) . "' ";
            } else {
              $where = DATABASE_PRODUCTS_TABLENAME . ".model = '" . $this->db->query_value($model) . "' "
                               . "AND " . DATABASE_PRODUCTS_TABLENAME . ".section = '" . $this->db->query_value($section) . "' ";
              if (!empty($category->ids)) $where .= "AND " . DATABASE_PRODUCTS_TABLENAME . ".category_id = '" . $this->db->query_value($category->id) . "' ";
              if (!empty($brand->ids)) $where .= "AND " . DATABASE_PRODUCTS_TABLENAME . ".brand_id = '" . $this->db->query_value($brand->id) . "' ";
            }
            $join_condition = "";
            if ($variant != "") $join_condition = "AND products_variants.name = '" . $this->db->query_value($variant) . "' ";
            $query = "SELECT " . DATABASE_PRODUCTS_TABLENAME . ".*, "
                          . "products_variants.variant_id AS variant_id "
                   . "FROM " . DATABASE_PRODUCTS_TABLENAME . " "
                   . "LEFT JOIN products_variants "
                             . "ON " . DATABASE_PRODUCTS_TABLENAME . ".product_id = products_variants.product_id "
                             . $join_condition
                   . "WHERE " . $where
                   . "LIMIT 1;";
            $this->db->query($query);
            $found = $this->db->result();
          }

          // если товар не найден
          if (empty($found->product_id)) {
            $product_id = null;

            // если задано название товара, добавляем товар
            if ($model != "") {
              if ($pid != "") $this->db->query("SET IDENTITY_INSERT " . DATABASE_PRODUCTS_TABLENAME . " ON");
              $query = "INSERT INTO " . DATABASE_PRODUCTS_TABLENAME . " ("
                                      . (($pid != "") ? "product_id, " : "")
                                      . "section, "
                                      . "url, "
                                      . "url_special, "
                                      . "category_id, "
                                      . "brand_id, "
                                      . "model, "
                                      . 'price, '
                                      . 'old_price, '
                                      . 'temp_price, '
                                      . 'priority_discount, '
                                      . "votes, "
                                      . "rating, "
                                      . "browsed, "
                                      . "order_num, "
                                      . "order_num_hit, "
                                      . "order_num_newest, "
                                      . "order_num_actional, "
                                      . "order_num_awaited, "
                                      . "guarantee, "
                                      . "description, "
                                      . "body, "
                                      . "seo_description, "
                                      . "quantity, "
                                      . "enabled, "
                                      . "highlighted, "
                                      . "hidden, "
                                      . "commented, "
                                      . "hit, "
                                      . "newest, "
                                      . "actional, "
                                      . "awaited, "
                                      . "ymarket, "
                                      . "vkontakte, "
                                      . "rss_disabled, "
                                      . "export_disabled, "
                                      . "non_creditable, "
                                      . "meta_title, "
                                      . "meta_keywords, "
                                      . "meta_description, "
                                      . "subdomain, "
                                      . "subdomain_enabled, "
                                      . "subdomain_html, "
                                      . "tags, "
                                      . "objects, "
                                      . "template, "
                                      . "small_image, "
                                      . "large_image, "
                                      . "images, "
                                      . "images_alts, "
                                      . "images_texts, "
                                      . "images_view, "
                                      . "files, "
                                      . "files_alts, "
                                      . "files_texts, "
                                      . 'accessory_pids, '
                                      . 'related_pids, '
                                      . 'related_cids, '
                                      . 'related_bids, '
                                      . "pcode, "
                                      . "barcode, "
                                      . "video, "
                                      . "coming, "
                                      . "created, "
                                      . "modified) "
                     . "VALUES (" . (($pid != "") ? "'" . $this->db->query_value($pid) . "', " : "")
                             . "'" . $this->db->query_value($section) . "', "
                             . "'" . $this->db->query_value($url) . "', "
                             . "'" . $this->db->query_value($url_special) . "', "
                             . "'" . $this->db->query_value($category->id) . "', "
                             . "'" . $this->db->query_value($brand->id) . "', "
                             . "'" . $this->db->query_value($model) . "', "
                             . '\'' . $this->db->query_value($price[1]) . '\', '
                             . '\'' . $this->db->query_value($old_price) . '\', '
                             . '\'' . $this->db->query_value($temp_price) . '\', '
                             . '\'' . $this->db->query_value($discount) . '\', '
                             . "'" . $this->db->query_value($votes) . "', "
                             . "'" . $this->db->query_value($rating) . "', "
                             . "'" . $this->db->query_value($browsed) . "', "
                             . "'" . $this->db->query_value($order_num) . "', "
                             . "'" . $this->db->query_value($order_num_hit) . "', "
                             . "'" . $this->db->query_value($order_num_newest) . "', "
                             . "'" . $this->db->query_value($order_num_actional) . "', "
                             . "'" . $this->db->query_value($order_num_awaited) . "', "
                             . "'" . $this->db->query_value($guarantee) . "', "
                             . "'" . $this->db->query_value($description) . "', "
                             . "'" . $this->db->query_value($body->value) . "', "
                             . "'" . $this->db->query_value($seo->value) . "', "
                             . "'" . $this->db->query_value($quantity) . "', "
                             . "'" . $this->db->query_value($enabled) . "', "
                             . "'" . $this->db->query_value($highlighted) . "', "
                             . "'" . $this->db->query_value($hidden) . "', "
                             . "'" . $this->db->query_value($commented) . "', "
                             . "'" . $this->db->query_value($hit) . "', "
                             . "'" . $this->db->query_value($newest) . "', "
                             . "'" . $this->db->query_value($actional) . "', "
                             . "'" . $this->db->query_value($awaited) . "', "
                             . "'" . $this->db->query_value($ymarket) . "', "
                             . "'" . $this->db->query_value($vkontakte) . "', "
                             . "'" . $this->db->query_value($rss_disabled) . "', "
                             . "'" . $this->db->query_value($export_disabled) . "', "
                             . "'" . $this->db->query_value($non_creditable) . "', "
                             . "'" . $this->db->query_value($meta_title) . "', "
                             . "'" . $this->db->query_value($meta_keywords->value) . "', "
                             . "'" . $this->db->query_value($meta_description->value) . "', "
                             . "'" . $this->db->query_value($subdomain) . "', "
                             . "'" . $this->db->query_value($subdomain_enabled) . "', "
                             . "'" . $this->db->query_value($subdomain_html->value) . "', "
                             . "'" . $this->db->query_value($tags->value) . "', "
                             . "'" . $this->db->query_value($objects->value) . "', "
                             . "'" . $this->db->query_value($template) . "', "
                             . "'" . $this->db->query_value($small_image) . "', "
                             . "'" . $this->db->query_value($large_image) . "', "
                             . "'" . $this->db->query_value($images->value) . "', "
                             . "'" . $this->db->query_value($images->alts) . "', "
                             . "'" . $this->db->query_value($images->texts) . "', "
                             . "'" . $this->db->query_value($images->view) . "', "
                             . "'" . $this->db->query_value($files->value) . "', "
                             . "'" . $this->db->query_value($files->alts) . "', "
                             . "'" . $this->db->query_value($files->texts) . "', "
                             . '\'' . $this->db->query_value($accessory_pids) . '\', '
                             . '\'' . $this->db->query_value($related_pids) . '\', '
                             . '\'' . $this->db->query_value($related_cids) . '\', '
                             . '\'' . $this->db->query_value($related_bids) . '\', '
                             . "'" . $this->db->query_value($pcode) . "', "
                             . "'" . $this->db->query_value($barcode) . "', "
                             . "'" . $this->db->query_value($video->value) . "', "
                             . "'" . $this->db->query_value($coming) . "', "
                             . "'" . $this->db->query_value($created) . "', "
                             . "'" . $this->db->query_value($modified) . "')";
              if ($this->db->query($query)) {
                $product_id = $this->db->insert_id();
                if (!empty($product_id)) $this->products_added++;
              }
              if ($pid != "") $this->db->query("SET IDENTITY_INSERT " . DATABASE_PRODUCTS_TABLENAME . " OFF");

              // если товар добавлен и у него пустой url или равен идентификатору, меняем на человеко-понятный
              if (!empty($product_id) && (($url == "") || ($url == $product_id))) {
                $url = $category->url;
                if ($url != '') $url .= '/';
                $url .= $this->hdd->safeFilename(preg_replace('![/\\\\\:\?]!', ' ', $model), TRUE, 64) . '-' . $product_id;
                $query = new stdClass;
                $query->url = $url;
                $query->indifferent_caches = TRUE;
                $query->product_id = $product_id;
                $this->db->products->update($query);
              }
            }

          // иначе товар найден
          } else {
            $product_id = $found->product_id;

            // если нашли в базе товаров (не в базе вариантов), смотрим что изменилось,
            // ОБРАЩАЯ ВНИМАНИЕ на признак принципиальности к изменению значения в поле
            if (isset($found->model)) {
              $query_set = "";

              // если изменился раздел магазина
              if (isset($params["section"])
              && $params["section"]->fundamental
              && ($found->section != $section)) $query_set .= "section = '" . $this->db->query_value($section) . "', ";

              // если изменилась категория
              if ($category->isset
              && $category->fundamental
              && ($found->category_id != $category->id)) $query_set .= "category_id = '" . $this->db->query_value($category->id) . "', ";

              // если изменился бренд
              if ($brand->isset
              && $brand->fundamental
              && ($found->brand_id != $brand->id)) $query_set .= "brand_id = '" . $this->db->query_value($brand->id) . "', ";

              // если изменилось название товара
              if (isset($params["model"])
              && $params["model"]->fundamental
              && ($found->model != $model)) $query_set .= "model = '" . $this->db->query_value($model) . "', ";

              // если изменился срок гарантии
              if (isset($params["guarantee"])
              && $params["guarantee"]->fundamental
              && ($found->guarantee != $guarantee)) $query_set .= "guarantee = '" . $this->db->query_value($guarantee) . "', ";

              // если изменилась аннотация
              if (isset($params["annotation"])
              && $params["annotation"]->fundamental
              && ($found->description != $description)) $query_set .= "description = '" . $this->db->query_value($description) . "', ";

              // если изменилось описание
              if ($body->isset
              && $body->fundamental
              && ($found->body != $body->value)) $query_set .= "body = '" . $this->db->query_value($body->value) . "', ";

              // если изменился SEO текст
              if ($seo->isset
              && $seo->fundamental
              && ($found->seo_description != $seo->value)) $query_set .= "seo_description = '" . $this->db->query_value($seo->value) . "', ";

              // если изменился url страницы или в существующем товаре он пустой или равен идентификатору
              if (isset($params["url"])
              && $params["url"]->fundamental
              && (($found->url != $url) || ($found->url == "") || ($found->url == $product_id))) {

                // если новый url пустой или равен идентификатору, меняем на человеко-понятный
                if (($url == "") || ($url == $product_id)) {
                  $url = $category->url;
                  if ($url != '') $url .= '/';
                  $url .= $this->hdd->safeFilename(preg_replace('![/\\\\\:\?]!', ' ', $model), TRUE, 64) . '-' . $product_id;
                }

                // если url точно изменился
                if ($found->url != $url) $query_set .= "url = '" . $this->db->query_value($url) . "', ";
              }

              // если изменился признак Особый URL
              if (isset($params["urlspecial"])
              && $params["urlspecial"]->fundamental
              && ($found->url_special != $url_special)) $query_set .= "url_special = '" . $this->db->query_value($url_special) . "', ";

              // если изменился мета заголовок
              if (isset($params["metatitle"])
              && $params["metatitle"]->fundamental
              && ($found->meta_title != $meta_title)) $query_set .= "meta_title = '" . $this->db->query_value($meta_title) . "', ";

              // если изменились ключевые слова
              if ($meta_keywords->isset
              && $meta_keywords->fundamental
              && ($found->meta_keywords != $meta_keywords->value)) $query_set .= "meta_keywords = '" . $this->db->query_value($meta_keywords->value) . "', ";

              // если изменилось мета описание
              if ($meta_description->isset
              && $meta_description->fundamental
              && ($found->meta_description != $meta_description->value)) $query_set .= "meta_description = '" . $this->db->query_value($meta_description->value) . "', ";

              // если изменилось имя субдомена
              if (isset($params["sudomain"])
              && $params["sudomain"]->fundamental
              && ($found->sudomain != $sudomain)) $query_set .= "sudomain = '" . $this->db->query_value($sudomain) . "', ";

              // если изменилось разрешение субдомена
              if (isset($params["sudomainenabled"])
              && $params["sudomainenabled"]->fundamental
              && ($found->sudomain_enabled != $sudomain_enabled)) $query_set .= "sudomain_enabled = '" . $this->db->query_value($sudomain_enabled) . "', ";

              // если изменился контент субдомена
              if ($subdomain_html->isset
              && $subdomain_html->fundamental
              && ($found->subdomain_html != $subdomain_html->value)) $query_set .= "subdomain_html = '" . $this->db->query_value($subdomain_html->value) . "', ";

              // если изменились теги
              if ($tags->isset
              && $tags->fundamental
              && ($found->tags != $tags->value)) $query_set .= "tags = '" . $this->db->query_value($tags->value) . "', ";

              // если изменились модули
              if ($objects->isset
              && $objects->fundamental
              && ($found->objects != $objects->value)) $query_set .= "objects = '" . $this->db->query_value($objects->value) . "', ";

              // если изменился шаблон
              if (isset($params["template"])
              && $params["template"]->fundamental
              && ($found->template != $template)) $query_set .= "template = '" . $this->db->query_value($template) . "', ";

              // если изменился url миниатюры
              if (isset($params["smallimage"])
              && $params["smallimage"]->fundamental
              && ($found->small_image != $small_image)) $query_set .= "small_image = '" . $this->db->query_value($small_image) . "', ";

              // если изменился url фото
              if (isset($params["largeimage"])
              && $params["largeimage"]->fundamental
              && ($found->large_image != $large_image)) $query_set .= "large_image = '" . $this->db->query_value($large_image) . "', ";

              // если изменились фото
              if ($images->isset
              && $images->fundamental
              && (($found->images != $images->value)
              || ($found->images_alts != $images->alts)
              || ($found->images_texts != $images->texts)
              || ($found->images_view != $images->view))) {
                $query_set .= "images = '" . $this->db->query_value($images->value) . "', "
                            . "images_alts = '" . $this->db->query_value($images->alts) . "', "
                            . "images_texts = '" . $this->db->query_value($images->texts) . "', "
                            . "images_view = '" . $this->db->query_value($images->view) . "', ";
              }

              // если изменились дополнительные файлы
              if ($files->isset
              && $files->fundamental
              && (($found->files != $files->value)
              || ($found->files_alts != $files->alts)
              || ($found->files_texts != $files->texts))) {
                $query_set .= "files = '" . $this->db->query_value($files->value) . "', "
                            . "files_alts = '" . $this->db->query_value($files->alts) . "', "
                            . "files_texts = '" . $this->db->query_value($files->texts) . "', ";
              }



              // если изменились идентификаторы дополнительных товаров (аксессуаров)
              if (isset($params['accessoryproducts'])
              && $params['accessoryproducts']->fundamental
              && ($found->accessory_pids != $accessory_pids)) {
                  $i = explode(',', $found->accessory_pids);
                  $found->accessory_pids = array();
                  foreach ($i as $n) {
                      $n = intval($n);
                      if (!empty($n)) $found->accessory_pids[$n] = $n;
                  }
                  if (!empty($found->accessory_pids)) sort($found->accessory_pids, SORT_NUMERIC);
                  $found->accessory_pids = implode(',', $found->accessory_pids);
                  if ($found->accessory_pids != $accessory_pids) $query_set .= 'accessory_pids = \'' . $this->db->query_value($accessory_pids) . '\', ';
              }



              // если изменились идентификаторы похожих товаров
              if (isset($params['relatedproducts'])
              && $params['relatedproducts']->fundamental
              && ($found->related_pids != $related_pids)) {
                  $i = explode(',', $found->related_pids);
                  $found->related_pids = array();
                  foreach ($i as $n) {
                      $n = intval($n);
                      if (!empty($n)) $found->related_pids[$n] = $n;
                  }
                  if (!empty($found->related_pids)) sort($found->related_pids, SORT_NUMERIC);
                  $found->related_pids = implode(',', $found->related_pids);
                  if ($found->related_pids != $related_pids) $query_set .= 'related_pids = \'' . $this->db->query_value($related_pids) . '\', ';
              }



              // если изменились идентификаторы похожих категорий
              if (isset($params['relatedcategories'])
              && $params['relatedcategories']->fundamental
              && ($found->related_cids != $related_cids)) {
                  $i = explode(',', $found->related_cids);
                  $found->related_cids = array();
                  foreach ($i as $n) {
                      $n = intval($n);
                      if (!empty($n)) $found->related_cids[$n] = $n;
                  }
                  if (!empty($found->related_cids)) sort($found->related_cids, SORT_NUMERIC);
                  $found->related_cids = implode(',', $found->related_cids);
                  if ($found->related_cids != $related_cids) $query_set .= 'related_cids = \'' . $this->db->query_value($related_cids) . '\', ';
              }



              // если изменились идентификаторы похожих брендов
              if (isset($params['relatedbrands'])
              && $params['relatedbrands']->fundamental
              && ($found->related_bids != $related_bids)) {
                  $i = explode(',', $found->related_bids);
                  $found->related_bids = array();
                  foreach ($i as $n) {
                      $n = intval($n);
                      if (!empty($n)) $found->related_bids[$n] = $n;
                  }
                  if (!empty($found->related_bids)) sort($found->related_bids, SORT_NUMERIC);
                  $found->related_bids = implode(',', $found->related_bids);
                  if ($found->related_bids != $related_bids) $query_set .= 'related_bids = \'' . $this->db->query_value($related_bids) . '\', ';
              }



              // если изменился буквенный код товара
              if (isset($params["pcode"])
              && $params["pcode"]->fundamental
              && ($found->pcode != $pcode)) $query_set .= "pcode = '" . $this->db->query_value($pcode) . "', ";

              // если изменился штрихкод товара
              if (isset($params["barcode"])
              && $params["barcode"]->fundamental
              && ($found->barcode != $barcode)) $query_set .= "barcode = '" . $this->db->query_value($barcode) . "', ";

              // если изменились видео файлы
              if ($video->isset
              && $video->fundamental
              && ($found->video != $video->value)) $query_set .= "video = '" . $this->db->query_value($video->value) . "', ";

              // если изменилась дата ожидания товара
              if (isset($params["comedate"])
              && $params["comedate"]->fundamental
              && ($found->coming != $coming)) $query_set .= "coming = '" . $this->db->query_value($coming) . "', ";

              // если изменилось количество голосов
              if (isset($params["votes"])
              && $params["votes"]->fundamental
              && ($found->votes != $votes)) $query_set .= "votes = '" . $this->db->query_value($votes) . "', ";

              // если изменился рейтинг
              if (isset($params["rating"])
              && $params["rating"]->fundamental
              && ($found->rating != $rating)) $query_set .= "rating = '" . $this->db->query_value($rating) . "', ";

              // если изменилось число просмотров
              if (isset($params["browsed"])
              && $params["browsed"]->fundamental
              && ($found->browsed != $browsed)) $query_set .= "browsed = '" . $this->db->query_value($browsed) . "', ";

              // если изменились порядки (веса)
              if (isset($params["order"])
              && $params["order"]->fundamental
              && ($found->order_num != $order_num)) $query_set .= "order_num = '" . $this->db->query_value($order_num) . "', ";
              if (isset($params["orderhit"])
              && $params["orderhit"]->fundamental
              && ($found->order_num_hit != $order_num_hit)) $query_set .= "order_num_hit = '" . $this->db->query_value($order_num_hit) . "', ";
              if (isset($params["ordernewest"])
              && $params["ordernewest"]->fundamental
              && ($found->order_num_newest != $order_num_newest)) $query_set .= "order_num_newest = '" . $this->db->query_value($order_num_newest) . "', ";
              if (isset($params["orderactional"])
              && $params["orderactional"]->fundamental
              && ($found->order_num_actional != $order_num_actional)) $query_set .= "order_num_actional = '" . $this->db->query_value($order_num_actional) . "', ";
              if (isset($params["orderawaited"])
              && $params["orderawaited"]->fundamental
              && ($found->order_num_awaited != $order_num_awaited)) $query_set .= "order_num_awaited = '" . $this->db->query_value($order_num_awaited) . "', ";

              // если изменилась дата создания
              if (isset($params["created"])
              && $params["created"]->fundamental
              && ($found->created != $created)) $query_set .= "created = '" . $this->db->query_value($created) . "', ";

              // если в настройках варианта импорта задана перезапись маркетинговых полей
              if (isset($this->item->marketing_update) && ($this->item->marketing_update == 1)) {

                // если изменился признак Хит продаж
                if (isset($params["hit"])
                && $params["hit"]->fundamental
                && ($found->hit != $hit)) $query_set .= "hit = '" . $this->db->query_value($hit) . "', ";

                // если изменился признак Новинка
                if (isset($params["newest"])
                && $params["newest"]->fundamental
                && ($found->newest != $newest)) $query_set .= "newest = '" . $this->db->query_value($newest) . "', ";

                // если изменился признак Акционный
                if (isset($params["actional"])
                && $params["actional"]->fundamental
                && ($found->actional != $actional)) $query_set .= "actional = '" . $this->db->query_value($actional) . "', ";

                // если изменился признак Скоро в продаже
                if (isset($params["awaited"])
                && $params["awaited"]->fundamental
                && ($found->awaited != $awaited)) $query_set .= "awaited = '" . $this->db->query_value($awaited) . "', ";

                // если изменился признак Экспорт в Яндекс.Маркет
                if (isset($params["ymarket"])
                && $params["ymarket"]->fundamental
                && ($found->ymarket != $ymarket)) $query_set .= "ymarket = '" . $this->db->query_value($ymarket) . "', ";

                // если изменился признак Экспорт ВКонтакте
                if (isset($params["vkontakte"])
                && $params["vkontakte"]->fundamental
                && ($found->vkontakte != $vkontakte)) $query_set .= "vkontakte = '" . $this->db->query_value($vkontakte) . "', ";

                // если изменился признак Не для RSS
                if (isset($params["rssdisabled"])
                && $params["rssdisabled"]->fundamental
                && ($found->rss_disabled != $rss_disabled)) $query_set .= "rss_disabled = '" . $this->db->query_value($rss_disabled) . "', ";

                // если изменился признак Не для информеров
                if (isset($params["informerdisabled"])
                && $params["informerdisabled"]->fundamental
                && ($found->export_disabled != $export_disabled)) $query_set .= "export_disabled = '" . $this->db->query_value($export_disabled) . "', ";

                // если изменился признак Не продавать в кредит
                if (isset($params["noncreditable"])
                && $params["noncreditable"]->fundamental
                && ($found->non_creditable != $non_creditable)) $query_set .= "non_creditable = '" . $this->db->query_value($non_creditable) . "', ";

                // если изменился признак Выделен
                if (isset($params["highlighted"])
                && $params["highlighted"]->fundamental
                && ($found->highlighted != $highlighted)) $query_set .= "highlighted = '" . $this->db->query_value($highlighted) . "', ";

                // если изменился признак Скрыт от чужих
                if (isset($params["hidden"])
                && $params["hidden"]->fundamental
                && ($found->hidden != $hidden)) $query_set .= "hidden = '" . $this->db->query_value($hidden) . "', ";

                // если изменился признак Разрешен к обсуждению
                if (isset($params["commented"])
                && $params["commented"]->fundamental
                && ($found->commented != $commented)) $query_set .= "commented = '" . $this->db->query_value($commented) . "', ";

                // если изменился признак Разрешен
                if (isset($params["enabled"])
                && $params["enabled"]->fundamental
                && ($found->enabled != $enabled)) $query_set .= "enabled = '" . $this->db->query_value($enabled) . "', ";
              }



              // если в настройках варианта импорта задана перезапись количественных полей
              if (isset($this->item->financial_update) && ($this->item->financial_update == 1)) {

                  // если изменилось количество на складе
                  if (isset($params['quantity'])
                  && $params['quantity']->fundamental
                  && ($found->quantity != $quantity)) $query_set .= 'quantity = \'' . $this->db->query_value($quantity) . '\', ';



                  // если изменилась цена
                  for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                      $n = 'price' . (($i > 1) ? $i : '');
                      if (isset($params[$n])
                      && $params[$n]->fundamental
                      && isset($found->$n) && ($found->$n != $price[$i])) $query_set .= $n . ' = \'' . $this->db->query_value($price[$i]) . '\', ';
                  }



                  // если изменилась старая цена
                  if (isset($params['oldprice'])
                  && $params['oldprice']->fundamental
                  && ($found->old_price != $old_price)) $query_set .= 'old_price = \'' . $this->db->query_value($old_price) . '\', ';



                  // если изменилась акционная цена
                  if (isset($params['tempprice'])
                  && $params['tempprice']->fundamental
                  && ($found->temp_price != $temp_price)) $query_set .= 'temp_price = \'' . $this->db->query_value($temp_price) . '\', ';



                  // если изменилась приоритетная скидка
                  if (isset($params['discount'])
                  && $params['discount']->fundamental
                  && ($found->priority_discount != $discount)) $query_set .= 'priority_discount = \'' . $this->db->query_value($discount) . '\', ';
              }



              // если обнаружены изменения, обновляем запись
              if ($query_set != "") {
                $query_set .= "modified = '" . $this->db->query_value($modified) . "' ";
                $query = "UPDATE " . DATABASE_PRODUCTS_TABLENAME . " "
                       . "SET " . $query_set
                       . "WHERE product_id = '" . $this->db->query_value($product_id) . "'";
                if ($this->db->query($query)) $this->products_updated++;
              } else {
                $this->products_skiped++;
              }
            }
          }



          // если такой вариант не найден
          if (!isset($found->variant_id) || empty($found->variant_id)) {

              // если товар существует (добавлен / обновлен / не изменен)
              if (!empty($product_id)) {

                  // может есть товар, идентификатор варианта которого равен идентификатору товара?
                  $query = 'SELECT variant_id '
                         . 'FROM products_variants '
                         . 'WHERE variant_id = \'' . $this->db->query_value($product_id) . '\' '
                         . 'LIMIT 1';
                  $this->db->query($query);
                  $found = $this->db->result();

                  // цена
                  $price_fields = '';
                  $price_fields_values = '';
                  for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                      $price_fields .= 'price' . (($i > 1) ? $i : '') . ', ';
                      $price_fields_values .= '\'' . $this->db->query_value($price[$i]) . '\', ';
                  }

                  // добавляем вариант товара
                  if (!isset($found->variant_id) || empty($found->variant_id)) $this->db->query('SET IDENTITY_INSERT products_variants ON');
                  $query = 'INSERT INTO products_variants (product_id, '
                                                        . ((!isset($found->variant_id) || empty($found->variant_id)) ? 'variant_id, ' : '')
                                                        . 'sku, '
                                                        . 'name, '
                                                        . $price_fields
                                                        . 'old_price, '
                                                        . 'temp_price, '
                                                        . 'priority_discount, '
                                                        . 'stock) '
                         . 'VALUES (\'' . $this->db->query_value($product_id) . '\', '
                                 . ((!isset($found->variant_id) || empty($found->variant_id)) ? '\'' . $this->db->query_value($product_id) . '\', ' : '')
                                 . '\'' . $this->db->query_value($sku) . '\', '
                                 . '\'' . $this->db->query_value($variant) . '\', '
                                 . $price_fields_values
                                 . '\'' . $this->db->query_value($old_price) . '\', '
                                 . '\'' . $this->db->query_value($temp_price) . '\', '
                                 . '\'' . $this->db->query_value($discount) . '\', '
                                 . '\'' . $this->db->query_value($quantity) . '\')';
                  if ($this->db->query($query)) $this->variants_added++;
                  if (!isset($found->variant_id) || empty($found->variant_id)) $this->db->query('SET IDENTITY_INSERT products_variants OFF');
              }



          // иначе вариант найден
          } else {
              $variant_id = $found->variant_id;



              // смотрим что изменилось
              $query_set = '';
              if (isset($params['sku'])) $query_set .= 'sku = \'' . $this->db->query_value($sku) . '\', ';
              if (isset($params['variant'])) $query_set .= 'name = \'' . $this->db->query_value($variant) . '\', ';



              // если в настройках варианта импорта задана перезапись количественных полей
              if (isset($this->item->financial_update) && $this->item->financial_update) {

                  // цена
                  for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                      $n = 'price' . (($i > 1) ? $i : '');
                      if (isset($params[$n])
                      && $params[$n]->fundamental) $query_set .= $n . ' = \'' . $this->db->query_value($price[$i]) . '\', ';
                  }

                  if (isset($params['oldprice'])) $query_set .= 'old_price = \'' . $this->db->query_value($old_price) . '\', ';
                  if (isset($params['tempprice'])) $query_set .= 'temp_price = \'' . $this->db->query_value($temp_price) . '\', ';
                  if (isset($params['quantity'])) $query_set .= 'stock = \'' . $this->db->query_value($quantity) . '\', ';
                  if (isset($params['discount'])) $query_set .= 'priority_discount = \'' . $this->db->query_value($discount) . '\', ';
              }



              // если обнаружены изменения, обновляем запись
              if (!empty($query_set)) {
                  $query = 'UPDATE products_variants '
                         . 'SET ' . substr($query_set, 0, strlen($query_set) - 2) . ' '
                         . 'WHERE variant_id = \'' . $this->db->query_value($variant_id) . '\'';
                  if ($this->db->query($query)) $this->variants_updated++;
              } else {
                  $this->variants_skiped++;
              }
          }



          // если товар существует (добавлен / обновлен / не изменен)
          if (!empty($product_id)) {

            // если заданы значения свойств этого товара
            if (!empty($properties)) {

              // контролируем наличие ячейки в памяти свойств товаров
              if (!isset($this->properties_RAM[$product_id])
              || !is_array($this->properties_RAM[$product_id])) $this->properties_RAM[$product_id] = array();

              // добавляем в ячейку новые свойства товара
              $changed = FALSE;
              foreach ($properties as $i => $property) {
                $exist = FALSE;
                foreach ($this->properties_RAM[$product_id] as $n) {
                  if ($property == $n) {
                    $exist = TRUE;
                    break;
                  }
                }
                if (!$exist) {
                  $i = explode("_", $i);
                  $i = $i[0] . "_" . count($this->properties_RAM[$product_id]);
                  $this->properties_RAM[$product_id][$i] = $property;
                  $changed = TRUE;
                }
              }

              // если новые свойства были добавлены
              if ($changed) {

                // удаляем старые свойства
                $query = "DELETE FROM " . DATABASE_PROPERTIES_VALUES_TABLENAME . " "
                       . "WHERE " . DATABASE_PROPERTIES_VALUES_TABLENAME . ".product_id = '" . $this->db->query_value($product_id) . "';";
                $this->db->query($query);

                // сортируем свойства по заданному порядку
                $properties = $this->properties_RAM[$product_id];
                ksort($properties, SORT_STRING);
                $properties = array_reverse($properties);

                // добавляем накопленные свойства
                $order_num = 1;
                foreach ($properties as &$property) {
                  $query = "INSERT INTO " . DATABASE_PROPERTIES_VALUES_TABLENAME . " (product_id, "
                                                                                   . "property_id, "
                                                                                   . "order_num, "
                                                                                   . "value, "
                                                                                   . "price_plus, "
                                                                                   . "quantity_plus) "
                         . "VALUES ('" . $this->db->query_value($product_id) . "', "
                                 . "'" . $this->db->query_value($property[0]) . "', "
                                 . "'" . $this->db->query_value($order_num) . "', "
                                 . "'" . $this->db->query_value($property[1]) . "', "
                                 . "'', "
                                 . "'');";
                  $this->db->query($query);
                  $order_num++;
                }
              }
            }

            // возвращаем идентификатор товара
            return $product_id;
          }
        }

        // возвращаем ТОВАР НЕ ОБРАБОТАН
        return FALSE;
    }



        // подготовка поля COLUMNS ===============================================

        private function prepare_columns ( & $columns, & $changes, & $accepts, & $ignores, $utf8 = TRUE ) {

            // превращаем строку мнемонического описания полей в массив $columns, индексированный
            // названиями полей и содержащий их числовые индексы
            $temp = explode(',', $columns);
            $colcount = count($temp);

            $columns = array();
            $changes = array();
            $accepts = array();
            $ignores = array();
            $empty_num = 0;
            $i = 1;
            foreach ($temp as & $column) {
                $column = trim($column);
                $c_variants = array();
                $a_variants = array();
                $i_variants = array();

                // если для поля заданы дополнительные параметры: [+-команды] [варианты:замен]
                if (($p = strpos($column, '[')) !== FALSE) {
                    $params = substr($column, $p);
                    $column = trim(substr($column, 0, $p));

                    // извлекаем [+команды]
                    while (preg_match("'\[\+([^\]]*)\]'", $params, $matches, PREG_OFFSET_CAPTURE)) {
                        if (isset($matches[0][0]) && isset($matches[0][1])) $params = substr($params, 0, $matches[0][1]) . substr($params, $matches[0][1] + strlen($matches[0][0]));
                        $a_variants[] = isset($matches[1][0]) ? trim($matches[1][0]) : "";
                    }

                    // извлекаем [-команды]
                    while (preg_match("'\[\-([^\]]*)\]'", $params, $matches, PREG_OFFSET_CAPTURE)) {
                        if (isset($matches[0][0]) && isset($matches[0][1])) $params = substr($params, 0, $matches[0][1]) . substr($params, $matches[0][1] + strlen($matches[0][0]));
                        $i_variants[] = isset($matches[1][0]) ? trim($matches[1][0]) : "";
                    }

                    // извлекаем [варианты:замен]
                    while (preg_match("'\[([^:\]]*):([^\]]*)\]'", $params, $matches, PREG_OFFSET_CAPTURE)) {
                        if (isset($matches[0][0]) && isset($matches[0][1])) $params = substr($params, 0, $matches[0][1]) . substr($params, $matches[0][1] + strlen($matches[0][0]));
                        $matches[1] = isset($matches[1][0]) ? trim($matches[1][0]) : "";
                        $matches[2] = isset($matches[2][0]) ? trim($matches[2][0]) : "";
                        if (($matches[1] != "") || ($matches[2] != "")) {
                            $c_variants[] = $matches[1];
                            $c_variants[] = $matches[2];
                        }
                    }
                }

                // возможно поле задано со склейкой, то есть в формате мнемоника1+мнемоника2+...+мнемоникаN
                $column = strtolower($column);
                if ($column == 'null' || $column == 'null' . IMPORT_NOT_FUNDAMENTAL_COLUMN_MARKER) $column = 'skip';
                if ($column == 'skip' || $column == 'skip' . IMPORT_NOT_FUNDAMENTAL_COLUMN_MARKER) {
                    $empty_num++;
                    $column = 'skip' . ($empty_num > 1 ? $empty_num : '');
                }
                $column = explode('+', $column);

                // каждому полю присваиваем одинаковый индекс, +-команды и варианты замен
                foreach ($column as & $subcolumn) {
                    $subcolumn = trim($subcolumn);

                    // извлекаем маркер непринципиальности к изменению значения в поле
                    $fundamental = 1;
                    if (substr($subcolumn, -strlen(IMPORT_NOT_FUNDAMENTAL_COLUMN_MARKER)) == IMPORT_NOT_FUNDAMENTAL_COLUMN_MARKER) {
                        $fundamental = -1;
                        $subcolumn = trim(substr($subcolumn, 0, -strlen(IMPORT_NOT_FUNDAMENTAL_COLUMN_MARKER)));
                    }

                    // если перед маркерами действительно было задано имя поля
                    if ($subcolumn != '') {
                        if ($subcolumn == 'null') $subcolumn = 'skip';
                        $columns[$subcolumn] = $i * $fundamental;
                        $changes[$subcolumn] = array();
                        $accepts[$subcolumn] = array();
                        $ignores[$subcolumn] = array();

                        // если есть варианты замен, вносим их в массив $changes
                        if (!empty($c_variants)) {
                            $p = 0;
                            foreach ($c_variants as & $variant) {
                                $variant = trim($variant);
                                if ($p & 1) {
                                    $changes[$subcolumn][$value] = $variant;
                                } else {
                                    if (!$utf8) $variant = $this->text->convertCharset($variant, 'cp1251');
                                    $value = $this->text->lowerCase($variant);
                                    if ($value == '') $value = 'EMPTY';
                                }
                                $p++;
                            }
                        }

                        // если есть +команды, вносим их в массив $accepts
                        if (!empty($a_variants)) {
                            foreach ($a_variants as & $variant) {
                                $value = $utf8 ? $variant : $this->text->convertCharset($variant, 'cp1251');
                                $value = $this->text->lowerCase($value);
                                if ($value == '') $value = 'EMPTY';
                                $accepts[$subcolumn][$value] = $variant;
                            }
                        }

                        // если есть -команды, вносим их в массив $ignores
                        if (!empty($i_variants)) {
                            foreach ($i_variants as & $variant) {
                                $value = $utf8 ? $variant : $this->text->convertCharset($variant, 'cp1251');
                                $value = $this->text->lowerCase($value);
                                if ($value == '') $value = 'EMPTY';
                                $ignores[$subcolumn][$value] = $variant;
                            }
                        }
                    }
                }
                $i++;
            }

            // возвращаем сколько колонок ожидается в таблице импорта
            return $colcount;
        }



        // ===================================================================
        /**
        *  Выполнение действия перед началом импорта
        *
        *  @access  private
        *  @return  void
        */
        // ===================================================================

        private function prepare_before_action () {

            // если было указано действие перед началом импорта
            if (isset($this->item->before_action)) {

                // какое действие?
                switch ($this->item->before_action) {

                    // если обнулить у товаров их количество на складе
                    case BEFORE_IMPORT_OPERATION_ZERO_QUANTITY:
                        $this->db->products->zero_quantity();
                        break;



                    // если удалить товары из каталога
                    case BEFORE_IMPORT_OPERATION_DELETE_PRODUCTS:
                        $this->db->products->clear();
                        break;



                    // если скрыть все товары
                    case BEFORE_IMPORT_OPERATION_HIDE_PRODUCTS:
                        $this->db->products->hide();
                        break;
                }
            }
        }



    // подготовка и выполнение действия "После импорта (самоочистка каталога)" =====

    private function prepare_final_action () {

      // если в настройках сайта указана автоматическая очистка каталога от устаревших товаров
      if (isset($this->settings->delete_goods_ancient) && ($this->settings->delete_goods_ancient == 1)) {
        if (isset($this->settings->delete_goods_ancientQ0_lifetime)) {
          $this->products_deleted_ancientQ0 = $this->db->delete_products_by_ancient_zero_quantity($this->settings->delete_goods_ancientQ0_lifetime);
        }
        if (isset($this->settings->delete_goods_ancientS0_lifetime)) {
          $this->products_deleted_ancientS0 = $this->db->delete_products_by_ancient_zero_price($this->settings->delete_goods_ancientS0_lifetime);
        }
      }
    }



    // подготовка значений VALUES прочитанной строки данных импорта ==========

    private function prepare_values ( & $values, & $columns, & $changes, & $accepts, & $ignores, & $data, $utf8 = TRUE ) {

        // предполагаем допустимость обработки такой строки
        $result = 1;

        // подготовленные значения сохраним здесь
        $values = array();



        // перебираем поля
        foreach ($columns as $name => $index) {



            // извлекаем маркер (здесь он задан знаком числа) непринципиальности к изменению значения в поле
            $fundamental = $index > 0;
            $index = abs($index) - 1;



            // берем значение поля (заменяя непечатные символы пробелами)
            $value = isset($data[$index]) ? $data[$index] : '';
            if ($utf8) $value = iconv('UTF-8', 'Windows-1251//IGNORE', $value);
            $value = trim(preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f\xa0]/', ' ', $value));
            if ($utf8) $value = iconv('Windows-1251', 'UTF-8//IGNORE', $value);



            // если для этого поля есть +команды
            if (!empty($accepts[$name])) {

                // если задана команда "пустые" и значение поля пустое
                if (($value == '') && isset($accepts[$name]['EMPTY'])) {

                    // разрешаем обработку безусловно
                    $result = TRUE;



                // иначе если задана команда конкретно для такого значения поля
                } else {
                    $i = $utf8 ? $value : $this->text->convertCharset($value, 'cp1251');
                    $i = $this->text->lowerCase($i);
                    if (isset($accepts[$name][$i])) {

                        // разрешаем обработку безусловно
                        $result = TRUE;
                    }
                }
            }



            // если для этого поля есть -команды
            if (!empty($ignores[$name])) {

                // если задана команда "все остальные" или "пустые" и значение поля пустое
                if (isset($ignores[$name]['*']) || (($value == '') && isset($ignores[$name]['EMPTY']))) {

                    // отклоняем обработку, но только если не сработала +команда
                    if ($result !== TRUE) $result = FALSE;



                // иначе если задана команда конкретно для такого значения поля
                } else {
                    $i = $utf8 ? $value : $this->text->convertCharset($value, 'cp1251');
                    $i = $this->text->lowerCase($i);
                    if (isset($ignores[$name][$i])) {

                        // отклоняем обработку, но только если не сработала +команда
                        if ($result !== TRUE) $result = FALSE;
                    }
                }
            }



            // если для этого поля есть варианты замен
            if (!empty($changes[$name])) {
                if ($value == '') {
                    if (isset($changes[$name]['EMPTY'])) {
                        $value = $changes[$name]['EMPTY'];
                    } elseif (isset($changes[$name]['*'])) {
                        $value = $changes[$name]['*'];
                    }
                } else {
                    $i = $utf8 ? $value : $this->text->convertCharset($value, 'cp1251');
                    $i = $this->text->lowerCase($i);
                    if (isset($changes[$name][$i])) {
                        $value = $changes[$name][$i];
                    } elseif (isset($changes[$name]['*'])) {
                        $value = $changes[$name]['*'];
                    }
                }
            }



            // сохраняем подготовленное значение
            $record = new stdClass;
            $record->value = $value;
            $record->fundamental = $fundamental;
            $values[$name] = $record;
        }



        // возвращаем признак ОБРАБАТЫВАТЬ / ОТКЛОНИТЬ такую строку
        return ($result != FALSE);
    }



    // чтение строки данных из файла формата XLS (HTML) ======================

    private function fget_xls_html (&$handle, $length) {

      // берем содержимое контейнера <tr></tr>, учитывая возможную вложенность
      // других структур <tr></tr> в этот контейнер и построчную разбитость контейнера
      $content = "";
      $level = -1;
      while (!feof($handle)) {
        $line = fgets($handle, $length);
        if ($line === FALSE) break;
        while (preg_match("'</?tr[^>]*>'i", $line, $matches, PREG_OFFSET_CAPTURE)) {
          $size = $matches[0][1] + strlen($matches[0][0]);
          if (substr($matches[0][0], 0, 2) == "</") {
            if ($level > 0) {
              $level--;
              if ($level != 0) $matches[0][1] += strlen($matches[0][0]);
              $content .= substr($line, 0, $matches[0][1]);
              if ($level == 0) {
                fseek($handle, $size - strlen($line), SEEK_CUR);
                break 2;
              }
            }
          } else {
            if ($level < 0) $level = 0;
            if ($level != 0) $content .= substr($line, 0, $size);
            $level++;
          }
          $line = substr($line, $size);
        }
        if ($level > 0) $content .= $line;
      }

      // если контейнер <tr></tr> не найден или он не закрыт, выходим
      if ($level != 0) return FALSE;

      // помещаем в массив содержимое контейнеров <td></td>, учитывая возможную вложенность
      // других структур <td></td> в такие контейнеры
      $columns = array();
      while ($level == 0) {
        $line = "";
        $level = -1;
        while (preg_match("'</?td[^>]*>'i", $content, $matches, PREG_OFFSET_CAPTURE)) {
          $size = $matches[0][1] + strlen($matches[0][0]);
          if (substr($matches[0][0], 0, 2) == "</") {
            if ($level > 0) {
              $level--;
              if ($level != 0) $matches[0][1] += strlen($matches[0][0]);
              $line .= substr($content, 0, $matches[0][1]);
              if ($level == 0) {
                $content = substr($content, $size);
                $columns[] = trim($line);
                break;
              }
            }
          } else {
            if ($level < 0) $level = 0;
            if ($level != 0) $line .= substr($content, 0, $size);
            $level++;
          }
          $content = substr($content, $size);
        }
      }

      // возвращаем полученный массив
      return $columns;
    }

    // импорт данных из файла формата CSV ====================================

    private function import_csv ( $filename = '', & $master_handle = FALSE, $utf8 = TRUE, & $statistic = null ) {

        // готовим входные параметры
        $error = '';
        $filename = isset($this->item->filename) && $filename == '' ? trim($this->item->filename) : trim($filename);
        $columns = isset($this->item->columns) ? trim($this->item->columns) : '';
        $handle = $master_handle;

        if (!is_object($statistic)) $statistic = new stdClass;
        $statistic->empties = array();
        $statistic->skips = array();
        $statistic->bads = array();
        $statistic->ids = array();

        if ($filename != '') {
            if ($columns != '') {
                if (isset($this->item->delimiter) && $this->item->delimiter != '') {
                    if ($master_handle === FALSE) $handle = @ fopen($filename, 'rb');
                    if ($handle !== FALSE) {

                        // если файл открывался здесь (не был внешним), запираем его от всех пока делаем импорт
                        if ($master_handle === FALSE) @ flock($handle, LOCK_EX);

                        // проверить и поправить все таблицы в базе данных (приказываем сделать полную перепроверку)
                        $this->db->check_databases(TRUE);

                        // превращаем строку мнемонического описания полей в массив $columns, индексированный
                        // названиями полей и содержащий их числовые индексы
                        $colcount = $this->prepare_columns($columns, $changes, $accepts, $ignores, $utf8);

                        if (isset($columns['sku']) || isset($columns['category']) || isset($columns['brand']) || isset($columns['model']) || isset($columns['productid'])) {
                            $linenum = 1;

                            // проверить и выполнить действие "Перед началом импорта"
                            $this->prepare_before_action();

                            // построчно обрабатываем весь CSV-файл
                            while (($cols = @ fgetcsv($handle, 0, $this->item->delimiter)) !== FALSE) {
                                // если это была не пустая строка CSV-файла
                                $count = count($cols);
                                if ($count > 0 && !is_null($cols[0])) {
                                    // если число ячеек в строке правильное
                                    if ($count == $colcount) {
                                        // если подготовка прочитанных значений не указала на отклонение этой строки
                                        if ($this->prepare_values($values, $columns, $changes, $accepts, $ignores, $cols, $utf8)) {
                                            // добавить/проверить продукт/категорию/бренд
                                            $id = $this->process_product($values);
                                            if (!empty($id)) $statistic->ids[$linenum] = $id;
                                        } else {
                                            $statistic->skips[] = $linenum;
                                        }
                                    } else {
                                        $statistic->bads[$linenum] = $count;
                                    }
                                } else {
                                    $statistic->empties[] = $linenum;
                                }
                                $linenum++;
                            }

                            // проверить и выполнить действие "После импорта (самоочистка каталога)"
                            $this->prepare_final_action();

                        } else {
                            $result = 'Среди колонок импортируемого файла по крайней мере должна присутствовать категория (category), бренд (brand), название товара (model), его идентификатор (productid) или артикул (sku).';
                        }

                        // если файл открывался здесь (не был внешним), закрываем его
                        if ($master_handle === FALSE) @ fclose($handle);
                    } else {
                        $error = 'Не удается загрузить импортируемый файл "' . $filename . '".';
                    }
                } else {
                    $error = 'Не указан символ деления строки данных на поля.';
                }
            } else {
                $error = 'Не указано мнемоническое описание порядка полей в импортируемых данных.';
            }
        } else {
            $error = 'Не указан файл, из которого должен быть произведен импорт.';
        }

        // возвращаем сообщение об ошибке, если была
        return $error;
    }

    // импорт данных из файла формата XLS (HTML) =============================

    private function import_xls_html ( $filename = '', & $master_handle = FALSE, $utf8 = TRUE, & $statistic = null ) {

        // готовим входные параметры
        $error = '';
        $filename = isset($this->item->filename) && $filename == '' ? trim($this->item->filename) : trim($filename);
        $columns = isset($this->item->columns) ? trim($this->item->columns) : '';
        $handle = $master_handle;

        if (!is_object($statistic)) $statistic = new stdClass;
        $statistic->empties = array();
        $statistic->skips = array();
        $statistic->bads = array();
        $statistic->ids = array();

        if ($filename != '') {
            if ($columns != '') {
                if ($master_handle === FALSE) $handle = @ fopen($filename, 'rb');
                if ($handle !== FALSE) {

                    // если файл открывался здесь (не был внешним), запираем его от всех пока делаем импорт
                    if ($master_handle === FALSE) @ flock($handle, LOCK_EX);

                    // проверить и поправить все таблицы в базе данных (приказываем сделать полную перепроверку)
                    $this->db->check_databases(TRUE);

                    // превращаем строку мнемонического описания полей в массив $columns, индексированный
                    // названиями полей и содержащий их числовые индексы
                    $colcount = $this->prepare_columns($columns, $changes, $accepts, $ignores, $utf8);

                    if (isset($columns['sku']) || isset($columns['category']) || isset($columns['brand']) || isset($columns['model']) || isset($columns['productid'])) {
                        $linenum = 1;

                        // проверить и выполнить действие "Перед началом импорта"
                        $this->prepare_before_action();

                        // построчно обрабатываем весь XLS-файл
                        while (($cols = $this->fget_xls_html($handle, 2097152)) !== FALSE) {
                            // если это была не пустая строка XLS-файла
                            $count = count($cols);
                            if ($count > 0 && !is_null($cols[0])) {
                                // если число ячеек в строке правильное
                                if ($count == $colcount) {
                                    // если подготовка прочитанных значений не указала на отклонение этой строки
                                    if ($this->prepare_values($values, $columns, $changes, $accepts, $ignores, $cols, $utf8)) {
                                        // добавить/проверить продукт/категорию/бренд
                                        $id = $this->process_product($values);
                                        if (!empty($id)) $statistic->ids[$linenum] = $id;
                                    } else {
                                        $statistic->skips[] = $linenum;
                                    }
                                } else {
                                    $statistic->bads[$linenum] = $count;
                                }
                            } else {
                                $statistic->empties[] = $linenum;
                            }
                            $linenum++;
                        }

                        // проверить и выполнить действие "После импорта (самоочистка каталога)"
                        $this->prepare_final_action();

                    } else {
                        $result = 'Среди колонок импортируемого файла по крайней мере должна присутствовать категория (category), бренд (brand), название товара (model), его идентификатор (productid) или артикул (sku).';
                    }

                    // если файл открывался здесь (не был внешним), закрываем его
                    if ($master_handle === FALSE) @ fclose($handle);
                } else {
                    $error = 'Не удается загрузить импортируемый файл "' . $filename . '".';
                }
            } else {
                $error = 'Не указано мнемоническое описание порядка полей в импортируемых данных.';
            }
        } else {
            $error = 'Не указан файл, из которого должен быть произведен импорт.';
        }

        // возвращаем сообщение об ошибке, если была
        return $error;
    }



    // ===================================================================
    /**
    *  Импорт данных из файла
    *
    *  @access  private
    *  @param   string  $filename   имя файла
    *  @param   mixed   $statistic  статистика импорта (будет возвращена в эту переменную)
    *  @return  string              текст сообщения об ошибке, если была
    */
    // ===================================================================

    private function import_file ( $filename = '', & $statistic = null ) {

        // готовим входные параметры
        $error = '';
        $filename = isset($this->item->filename) && $filename == '' ? trim($this->item->filename) : trim($filename);
        $format = isset($this->item->format) ? strtolower(trim($this->item->format)) : '';
        $columns = isset($this->item->columns) ? trim($this->item->columns) : '';
        $delimiter = isset($this->item->delimiter) ? $this->item->delimiter : '';

        if ($filename != '') {
            if ($format != '') {
                if ($columns != '') {
                    if ($delimiter != '') {
                        $handle = @ fopen($filename, 'rb');
                        if ($handle !== FALSE) {
                            @ flock($handle, LOCK_EX);

                            // уточняем, содержимое файла (первые строки объемом до 65535 символов) в кодировке UTF-8?
                            $utf8 = '';
                            while (!feof($handle)) {
                                $line = fgets($handle, 65535);
                                if ($line === FALSE) break;
                                $utf8 .= $line;
                                if (strlen($utf8) >= 65535) break;
                            }
                            $utf8 = ($utf8 != iconv('Windows-1251', 'Windows-1251//IGNORE', $utf8)) ||
                                    ($utf8 == iconv('UTF-8', 'UTF-8//IGNORE', $utf8));

                            // возвращаемся к началу файла
                            @ fseek($handle, 0);

                            // какой формат данных в импортируемом файле?
                            switch ($format) {

                                // если формат CSV
                                case IMPORT_FORMAT_NAME_CSV:

                                    // если файл не в кодировке UTF-8, переключаем базу данных на кодировку Windows-1251
                                    if (!$utf8) $this->db->set_charset('cp1251');

                                    // делаем импорт
                                    $error = $this->import_csv($filename, $handle, $utf8, $statistic);

                                    // переключаем кодировку обратно на UTF-8
                                    if (!$utf8) $this->db->set_charset('utf8');
                                    break;

                                // если формат XLS (HTML)
                                case IMPORT_FORMAT_NAME_XLSHTML:

                                    // если файл не в кодировке UTF-8, переключаем базу данных на кодировку Windows-1251
                                    if (!$utf8) $this->db->set_charset('cp1251');

                                    // делаем импорт
                                    $error = $this->import_xls_html($filename, $handle, $utf8, $statistic);

                                    // переключаем кодировку обратно на UTF-8
                                    if (!$utf8) $this->db->set_charset('utf8');
                                    break;

                                // иначе формат файла неизвестный
                                default:
                                    $error = 'Такой формат (' . $format . ') импортируемого файла не поддерживается.';
                            }
                            @ fclose($handle);

                            // если нет ошибок, заполняем пропущенные поля таблиц базы данных
                            if ($error == '') {
                                $query = array();
                                $query[] = 'UPDATE `products` '
                                         . 'SET `order_num` = `product_id` '
                                         . 'WHERE `order_num` = 0 OR `order_num` IS NULL;';
                                $query[] = 'UPDATE `products` '
                                         . 'SET `order_num_hit` = `product_id` '
                                         . 'WHERE `order_num_hit` = 0 OR `order_num_hit` IS NULL;';
                                $query[] = 'UPDATE `products` '
                                         . 'SET `order_num_newest` = `product_id` '
                                         . 'WHERE `order_num_newest` = 0 OR `order_num_newest` IS NULL;';
                                $query[] = 'UPDATE `products` '
                                         . 'SET `order_num_actional` = `product_id` '
                                         . 'WHERE `order_num_actional` = 0 OR `order_num_actional` IS NULL;';
                                $query[] = 'UPDATE `products` '
                                         . 'SET `order_num_awaited` = `product_id` '
                                         . 'WHERE `order_num_awaited` = 0 OR `order_num_awaited` IS NULL;';
                                $query[] = 'UPDATE `products` '
                                         . 'SET `url` = `product_id` '
                                         . 'WHERE `url` = "" OR `url` IS NULL;';
                                $query[] = 'UPDATE `categories` '
                                         . 'SET `url` = `category_id` '
                                         . 'WHERE `url` = "" OR `url` IS NULL;';
                                $query[] = 'UPDATE `brands` '
                                         . 'SET `url` = `brand_id` '
                                         . 'WHERE `url` = "" OR `url` IS NULL;';
                                foreach ($query as & $command) $this->db->query($command);
                            }
                        } else {
                            $error = 'Не удается загрузить импортируемый файл "' . $filename . '".';
                        }
                    } else {
                        $error = 'Не указан символ деления строки данных на поля.';
                    }
                } else {
                    $error = 'Не указано мнемоническое описание порядка полей в импортируемых данных.';
                }
            } else {
                $error = 'Не указан формат импортируемого файла.';
            }
        } else {
            $error = 'Не указан файл, из которого должен быть произведен импорт.';
        }

        // возвращаем сообщение об ошибке, если была
        return $error;
    }



    // импорт данных =========================================================

    private function import ( $id, $mode = IMPORT_START_MODE_MANUALLY ) {

        // обнуляем количественные результаты импорта
        $this->categories_added = 0;
        $this->brands_added = 0;
        $this->products_added = 0;
        $this->products_updated = 0;
        $this->products_skiped = 0;
        $this->products_deleted_ancientQ0 = 0;
        $this->products_deleted_ancientS0 = 0;
        $this->variants_added = 0;
        $this->variants_updated = 0;
        $this->variants_skiped = 0;
        $this->properties_added = 0;
        $this->statistic_data = null;
        $error = '';

        // читаем из базы данных вариант импорта
        if (!empty($id)) {
            $params = new stdClass;
            $params->id = $id;
            $this->db->imports->one($this->item, $params);

            // проверяем, что вариант разрешен и в нем заданы нужные поля
            if (!empty($this->item)) {
                if (!empty($this->item->enabled)) {

                    // если вариант не занят (не выполняется в настоящий момент)
                    $now = time();
                    $start = strtotime($this->item->lastused) + IMPORT_CRASH_RESTORE_LIFETIME;
                    if ($this->item->busy != 1 || $now > $start) {

                        $filename = trim($this->item->filename);
                        $this->item->format = strtolower(trim($this->item->format));
                        $this->item->columns = trim($this->item->columns);
                        if ($this->item->format != '') {
                            if ($this->item->columns != '') {
                                if ($this->item->delimiter != '') {

                                    // если в варианте импорта не задан файл, ищем его в запросе
                                    if ($filename == '') {
                                        if (isset($_FILES['file']['tmp_name'][$id])) {
                                            $url = trim($_FILES['file']['name'][$id]);
                                            if (isset($_FILES['file']['error'][$id]) && $_FILES['file']['error'][$id] != UPLOAD_ERR_OK) {
                                                switch ($_FILES['file']['error'][$id]) {
                                                    case UPLOAD_ERR_INI_SIZE:
                                                        $error = 'Размер принятого файла "' . $url . '" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.';
                                                        break;
                                                    case UPLOAD_ERR_FORM_SIZE:
                                                        $error = 'Размер загружаемого файла "' . $url . '" превышает максимально допустимое значение' . (isset($_POST['MAX_FILE_SIZE']) ? ' ' . trim($_POST['MAX_FILE_SIZE']) . ' байт' : '') . '.';
                                                        break;
                                                    case UPLOAD_ERR_PARTIAL:
                                                        $error = 'Загрузка файла "' . $url . '" прервалась и он был получен не весь.';
                                                        break;
                                                    case UPLOAD_ERR_NO_FILE:
                                                        $error = 'Не получен файл "' . $url . '".';
                                                        break;
                                                    default:
                                                        $error = 'Произошла неизвестная ошибка при попытке загрузить файл изображения водяного знака "' . $url . '".';
                                                }
                                            } else {
                                                $filename = trim($_FILES['file']['tmp_name'][$id]);
                                                if (empty($filename)) $error = 'Для выбранного варианта импорта Вы не указали файл, из которого должен быть произведен импорт.';
                                            }
                                        } else {
                                            $error = 'В указанном варианте импорта не задан файл, из которого должен быть произведен импорт.';
                                        }

                                        // если файл принят успешно
                                        if ($error == '') {
                                            $tmp_name = getcwd() . '/' . rtrim($this->smarty->getCompileDir(), '/\\\\') . '/' . $id . '_' . date('dmYHis', $now) . '_' . IMPORT_TRANSIT_FILENAME;
                                            $tmp_folder = $tmp_name . '.temp';

                                            // если файл является ZIP-архивом
                                            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
                                            $cleaning = $ext == 'zip';
                                            if ($cleaning) {
                                                switch ($this->item->format) {
                                                    case IMPORT_FORMAT_NAME_XLSHTML:
                                                        $ext = 'xls';
                                                        break;
                                                    case IMPORT_FORMAT_NAME_CSV:
                                                    default:
                                                        $ext = 'csv';
                                                }
                                                $this->smart_create_folder($tmp_folder, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX, 0777, TRUE);
                                                $zip = new PclZip($filename);
                                                if (!$zip->extract(PCLZIP_OPT_PATH, $tmp_folder,
                                                                   PCLZIP_OPT_BY_PREG, "'\.(" . $ext . ")$'i",
                                                                   PCLZIP_OPT_REMOVE_ALL_PATH,
                                                                   PCLZIP_OPT_REPLACE_NEWER,
                                                                   PCLZIP_CB_PRE_EXTRACT, 'myExtractCallBack',
                                                                   PCLZIP_CB_POST_EXTRACT, 'myExtractCallBack')) {
                                                    $error = $zip->errorCode() != PCLZIP_ERR_NO_ERROR
                                                             ? 'Не удалось распаковать ' . $zip->errorInfo(TRUE)
                                                             : 'Архив не содержит файлов с расширением .' . $ext;
                                                } else {
                                                    if (file_exists($tmp_name)) @ unlink($tmp_name);
                                                    $tmp_name = @ glob($tmp_folder . '/*.' . $ext, GLOB_NOSORT);
                                                    $tmp_name = isset($tmp_name[0]) ? trim($tmp_name[0]) : '';
                                                    $filename = $tmp_name;
                                                    if ($tmp_name == '') $error = 'Архив не содержит файлов с расширением .' . $ext;
                                                }
                                            }

                                            // запоминаем, когда вариант импорта был использован (обязательно включаем признак BUSY - занято)
                                            if ($error == '') {
                                                $this->item->lastused = $now;
                                                $this->item->busy = 1;
                                                $this->db->imports->update($this->item);

                                                // вносим сообщение в историю импорта
                                                $start_time = time();
                                                $this->push_import_message('        начат процесс импорта из файла', $mode);

                                                // делаем импорт данных
                                                $error = $this->import_file($filename, $this->statistic_data);

                                                // вносим результат в историю импорта
                                                $end_time = time();
                                                $this->push_import_result($error, 'РЕЗУЛЬТАТ (заняло ' . abs($end_time - $start_time) . ' секунд)');

                                                // уничтожаем все кеш-таблицы
                                                $this->db->drop_caches();
                                            }

                                            if ($cleaning) {
                                                if (file_exists($tmp_folder)) {
                                                    $this->clean_dir($tmp_folder);
                                                    @ rmdir($tmp_folder);
                                                }
                                                if (file_exists($tmp_name)) @unlink($tmp_name);
                                            }
                                        }

                                    // иначе файл задан в варианте импорта
                                    } else {
                                        // запоминаем, когда вариант импорта был использован (обязательно включаем признак BUSY - занято)
                                        $this->item->lastused = $now;
                                        $this->item->busy = 1;
                                        $this->db->imports->update($this->item);

                                        // вносим сообщение в историю импорта
                                        $start_time = time();
                                        $this->push_import_message('        операция начата' . "\r\n"
                                                                 . '        попытка загрузки файла', $mode);

                                        // пробуем загрузить файл и сделать импорт данных
                                        $tmp_name = rtrim($this->smarty->getCompileDir(), '/\\\\') . '/' . $id . '_' . date('dmYHis', $now) . '_' . IMPORT_TRANSIT_FILENAME;
                                        $tmp_folder = $tmp_name . '.temp';
                                        if ($this->get_remote_file($filename, $tmp_name)) {
                                            if (file_exists($tmp_name) && ($size = @ filesize($tmp_name)) > 0) {

                                                // если файл является ZIP-архивом
                                                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                                if ($ext == 'zip') {

                                                    // берем расширение зависимо от выбранного формата импорта
                                                    switch ($this->item->format) {
                                                        case IMPORT_FORMAT_NAME_XLSHTML:
                                                            $ext = 'xls';
                                                            break;
                                                        case IMPORT_FORMAT_NAME_CSV:
                                                        default:
                                                            $ext = 'csv';
                                                    }

                                                    // вносим сообщение в историю импорта
                                                    $end_time = time();
                                                    $this->push_import_message('        файл загружен за ' . abs($end_time - $start_time) . ' секунд (размер ' . $size . ' байт)' . "\r\n"
                                                                             . '        начата распаковка ZIP-архива', 'Промежуточный результат');

                                                    // создаем временную папку для распаковки
                                                    $this->smart_create_folder($tmp_folder, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX, 0777, TRUE);

                                                    // начинаем распаковку архива
                                                    $next_start_time = $end_time;
                                                    $zip = new PclZip($tmp_name);
                                                    if (!$zip->extract(PCLZIP_OPT_PATH, $tmp_folder,
                                                                       PCLZIP_OPT_BY_PREG, "'\.(" . $ext . ")$'i",
                                                                       PCLZIP_OPT_REMOVE_ALL_PATH,
                                                                       PCLZIP_OPT_REPLACE_NEWER,
                                                                       PCLZIP_CB_PRE_EXTRACT, 'myExtractCallBack',
                                                                       PCLZIP_CB_POST_EXTRACT, 'myExtractCallBack')) {
                                                        $error = $zip->errorCode() != PCLZIP_ERR_NO_ERROR
                                                                 ? 'Не удалось распаковать ' . $zip->errorInfo(TRUE)
                                                                 : 'Архив не содержит файлов с расширением .' . $ext;

                                                    // если распаковано успешно
                                                    } else {

                                                        // вносим сообщение в историю импорта
                                                        $end_time = time();
                                                        $this->push_import_message('        архив распакован за ' . abs($end_time - $next_start_time) . ' секунд' . "\r\n"
                                                                                 . '        начат импорт ближайшего распакованного файла с расширением .' . $ext . ')', 'Промежуточный результат');

                                                        // удаляем скачанный архивный файл (более не нужен)
                                                        if (file_exists($tmp_name)) @ unlink($tmp_name);

                                                        // находим ближайший распакованный файл нужного расширения
                                                        $tmp_name = @ glob($tmp_folder . '/*.' . $ext, GLOB_NOSORT);
                                                        $tmp_name = isset($tmp_name[0]) ? trim($tmp_name[0]) : '';
                                                        if ($tmp_name == '') $error = 'Архив не содержит файлов с расширением .' . $ext;
                                                    }

                                                // иначе это не ZIP-архив
                                                } else {

                                                    // вносим сообщение в историю импорта
                                                    $end_time = time();
                                                    $this->push_import_message('        файл загружен за ' . abs($end_time - $start_time) . ' секунд (размер ' . $size . ' байт)' . "\r\n"
                                                                             . '        начат процесс импорта из файла', 'Промежуточный результат');
                                                }

                                                // если нет ошибок
                                                if ($error == '') {

                                                    // делаем импорт данных
                                                    $error = $this->import_file($tmp_name, $this->statistic_data);

                                                    // уничтожаем все кеш-таблицы
                                                    $this->db->drop_caches();
                                                }

                                                // удаляем временную папку и файл
                                                if (file_exists($tmp_folder)) {
                                                    $this->clean_dir($tmp_folder);
                                                    @ rmdir($tmp_folder);
                                                }
                                                if (file_exists($tmp_name)) @unlink($tmp_name);
                                            } else {
                                                $error = 'Не удалось сохранить содержимое файла "' . $filename . '" под именем "' . $tmp_name . '" или этот файл ничего не содержит.';
                                            }
                                        } else {
                                            $error = 'Не удалось принять содержимое файла "' . $filename . '".';
                                        }

                                        // вносим результат в историю импорта
                                        $end_time = time();
                                        $this->push_import_result($error, 'РЕЗУЛЬТАТ (все заняло ' . abs($end_time - $start_time) . ' секунд)');
                                    }
                                } else {
                                    $error = 'В указанном варианте импорта не задан символ деления строки данных на поля.';
                                }
                            } else {
                                $error = 'В указанном варианте импорта не задано мнемоническое описание порядка полей в импортируемых данных.';
                            }
                        } else {
                            $error = 'В указанном варианте импорта не задан формат импортируемого файла.';
                        }
                    } else {
                        $error = 'Указанный вариант импорта уже выполняется. Повторное использование разрешено лишь по его окончанию. '
                               . 'Если же импорт окажется аварийно прерванным (например сайт имеет большой таймаут запроса внешних файлов, '
                               . 'узкий канал скачивания файлов, малый и неизменяемый лимит времени исполнения скриптов), использование '
                               . 'этого варианта импорта будет возможно только после ' . date('H:i:s', $start) . '.';
                    }
                } else {
                    $error = 'Указанный вариант импорта не разрешен к использованию.';
                }
            } else {
                $error = 'Не найдено сведений об указанном варианте импорта.';
            }
        } else {
            $error = 'Не указан требуемый вариант импорта.';
        }

        // возвращаем сообщение об ошибке, если была
        return $error;
    }

    // чтение удаленно размещенного файла ====================================

    function get_remote_file ($url, $filename) {

      // пока считаем, что не выполнено
      $result = FALSE;

      // выделяем протокол из url
      $url = str_replace("\\", "/", $url);
      $url = str_replace("\r", " ", $url);
      $url = str_replace("\n", " ", $url);
      $url = str_replace("\t", " ", $url);
      $url = explode("://", $url, 2);
      $protocol = isset($url[0]) && isset($url[1]) ? strtolower(trim($url[0])) : "";
      $url = isset($url[1]) ? trim($url[1]) : trim($url[0]);

      // если протокол файла равен HTTP или HTTPS
      if (($protocol == "http") || ($protocol == "https")) {
        $protocol .= "://";

        // выделяем сервер из url
        $url = explode("/", $url, 2);
        $server = isset($url[0]) ? strtolower(trim($url[0])) : "";
        $url = "/" . (isset($url[1]) ? trim($url[1]) : "");

        // выделяем порт из $server
        $server = explode(":", $server, 2);
        $port = isset($server[1]) ? intval($server[1]) : (($protocol == "http://") ? 80 : 443);
        $server = isset($server[0]) ? strtolower(trim($server[0])) : "";
        if ($server != "") {

          // открываем соединение (с таймаутом 3 секунды)
          $timeout = 3;
          $handle = @fsockopen($protocol . $server, $port, $error_code, $error_msg, $timeout);
          if (!$handle) $handle = @fsockopen($server, $port, $error_code, $error_msg, $timeout);
          if ($handle) {

            // задаем таймаут для потока
            if (function_exists("stream_set_timeout")) @stream_set_timeout($handle, $timeout);

            // запрашиваем контент url
            $request = "GET " . $url . " HTTP/1.1\r\n"
                     . "Host: " . $server . "\r\n"
                     . "Connection: Close\r\n\r\n";
            @fwrite($handle, $request);

            // пропускаем заголовок (по стандарту он заканчивается пустой строкой)
            $line = FALSE;
            while (!@feof($handle)) {
              $line = @fgets($handle, 8192);
              if ($line === FALSE) break;
              $line = trim($line);
              if ($line == "") break;
            }

            // если стоим на начале url-контента
            if ($line === "") {

              // создаем принимающий файл
              if ($handle2 = @fopen($filename, "wb")) {
                @flock($handle2, LOCK_EX);
                $result = TRUE;

                // извлекаем контент поблочно, сохраняя в файл
                while (!@feof($handle)) {
                  $line = @fread($handle, 65536);
                  if ($line === FALSE) {
                    $result = FALSE;
                    break;
                  }
                  $size = strlen($line);
                  if ($size == 0) break;
                  @fwrite($handle2, $line, $size);
                }

                // закрываем принимающий файл
                @fclose($handle2);
              }
            }

            // закрываем соединение
            @fclose($handle);
          }
        }
      }

      // возвращаем ВЫПОЛНЕНО / НЕТ
      return $result;
    }

    // добавление сообщения импорта в историю ================================

    private function push_import_message ($message, $mode = IMPORT_START_MODE_MANUALLY) {

      // добавляем информацию в историю импорта
      $history = date("d.m.Y H:i:s - ", time());
      if (!is_string($mode)) {
        switch ($mode) {
          case IMPORT_START_MODE_AUTOMATIC:
            $history .= "(автоматический запуск)\r\n";
            break;
          case IMPORT_START_MODE_REMOTE:
            $history .= "(внешний вызов с IP-адреса " . $this->security->getVisitorIp() . ")\r\n";
            break;
          case IMPORT_START_MODE_MANUALLY:
          default:
            $history .= "(ручной запуск с IP-адреса " . $this->security->getVisitorIp() . ")\r\n";
        }
      } else {
        $history .= $mode . "\r\n";
      }
      $history .= $message;
      $this->item->history = $history . "\r\n\r\n" . $this->item->history;
      $this->item->history = trim(substr($this->item->history, 0, 65536));

      // обновляем запись в базе данных
      $this->db->imports->update($this->item);
    }

    // добавление результата импорта в историю ===============================

    private function push_import_result ($error, $mode = IMPORT_START_MODE_MANUALLY) {

      // отключаем признак BUSY - вариант импорта уже не занят
      $this->item->busy = 0;

      // добавляем информацию в историю импорта
      $history = date("d.m.Y H:i:s - ", time());
      if (!is_string($mode)) {
        switch ($mode) {
          case IMPORT_START_MODE_AUTOMATIC:
            $history .= "(автоматический запуск)\r\n";
            break;
          case IMPORT_START_MODE_REMOTE:
            $history .= "(внешний вызов с IP-адреса " . $this->security->getVisitorIp() . ")\r\n";
            break;
          case IMPORT_START_MODE_MANUALLY:
          default:
            $history .= "(ручной запуск с IP-адреса " . $this->security->getVisitorIp() . ")\r\n";
        }
      } else {
        $history .= $mode . "\r\n";
      }
      if ($error != "") {
        $history .= "        " . $error;
      } else {
        $history .= ((($this->products_added > 0) || ($this->products_updated > 0) || ($this->products_skiped > 0) || ($this->products_deleted_ancientQ0 > 0) || ($this->products_deleted_ancientS0 > 0)) ?
                    "        ТОВАРЫ\r\n" : "")
                  . (($this->products_added > 0) ?
                    "            добавлено = " . $this->products_added . "\r\n" : "")
                  . (($this->products_updated > 0) ?
                    "            обновлено = " . $this->products_updated . "\r\n" : "")
                  . (($this->products_skiped > 0) ?
                    "            неизменившихся = " . $this->products_skiped . "\r\n" : "")
                  . (($this->products_deleted_ancientQ0 > 0) ?
                    "            удалено устаревших (отсутствующих) = " . $this->products_deleted_ancientQ0 . "\r\n" : "")
                  . (($this->products_deleted_ancientS0 > 0) ?
                    "            удалено устаревших (обесцененных) = " . $this->products_deleted_ancientS0 . "\r\n" : "")
                  . ((($this->variants_added > 0) || ($this->variants_updated > 0) || ($this->variants_skiped > 0)) ?
                    "        ВАРИАНТЫ ТОВАРОВ\r\n" : "")
                  . (($this->variants_added > 0) ?
                    "            добавлено = " . $this->variants_added . "\r\n" : "")
                  . (($this->variants_updated > 0) ?
                    "            обновлено = " . $this->variants_updated . "\r\n" : "")
                  . (($this->variants_skiped > 0) ?
                    "            неизменившихся = " . $this->variants_skiped . "\r\n" : "")
                  . (($this->categories_added > 0) ?
                    "        КАТЕГОРИИ\r\n"
                  . "            добавлено = " . $this->categories_added . "\r\n" : "")
                  . (($this->brands_added > 0) ?
                    "        БРЕНДЫ\r\n"
                  . "            добавлено = " . $this->brands_added . "\r\n" : "")
                  . (($this->properties_added > 0) ?
                    "        СВОЙСТВА ТОВАРОВ\r\n"
                  . "            добавлено = " . $this->properties_added . "\r\n" : "");
      }
      $this->item->history = $history . "\r\n\r\n" . $this->item->history;
      $this->item->history = trim(substr($this->item->history, 0, 65536));

      // обновляем запись в базе данных
      $this->db->imports->update($this->item);
    }

    // обработка вариантов импорта по расписанию =============================

    public function auto_import () {

      // отключаем информирование о программных ошибках (автоимпорт работает без участия наблюдателя)
      // разрешаем выполнить скрипт до конца (не обращать внимание на возможный разрыв соединения с пользователем),
      // снимаем ограничение на время выполнения скрипта
      @error_reporting(0);
      @ignore_user_abort(TRUE);
      @set_time_limit(0);

      // читаем все записи вариантов импорта (не запрещенные, с автозапуском и заданным источником)
      $params = new stdClass;
      $params->automatic = 1;
      $params->enabled = 1;
      $params->filenamed = 1;
      $this->db->imports->get($items, $params);

      // перебираем каждую прочитанную запись
      $now = time();
      foreach ($items as &$item) {

        // вычисляем время автозапуска для текущей записи
        $start = strtotime($item->lastused) + $item->lifetime;

        // если время наступило (период ожидания истек)
        if ($now > $start) {

          // ставим на сайте вывеску "Обновление информации"
          $this->putup_UPDATING_WORKS_INFO(TRUE);

          // делаем импорт
          $this->import($item->import_id, IMPORT_START_MODE_AUTOMATIC);

          // снимаем вывеску "Обновление информации"
          $this->putup_UPDATING_WORKS_INFO(FALSE);
        }
      }
    }

    // обработка внешнего вызова варианта импорта ============================

    public function remote_import (&$item) {

      if (!empty($item)) {
        $this->item = &$item;

        // какой формат импорта?
        switch ($this->item->format) {
          case IMPORT_FORMAT_NAME_COMMERCEML:
            $this->import_commerceml();
            break;
          case IMPORT_FORMAT_NAME_XLSHTML:
            break;
          case IMPORT_FORMAT_NAME_CSV:
          default:
        }
      }
    }

    // импорт данных в формате CommerceML ====================================

    private function import_commerceml () {

      // готовим входные параметры
      $marker = $this->hdd->safeFilename($this->item->import_id . '_' . @session_id());
      $controller = isset($_REQUEST["controller"]) ? trim($_REQUEST["controller"]) : $marker;
      $type = isset($_REQUEST["type"]) ? strtolower(trim($_REQUEST["type"])) : "";
      $mode = isset($_REQUEST["mode"]) ? strtolower(trim($_REQUEST["mode"])) : "";
      $file = isset($_REQUEST["file"]) ? trim($_REQUEST["file"]) : "";
      $folder = $this->smarty->getCompileDir() . "/" . $marker . "_";

      // какой тип информации импортируется?
      switch ($type) {

        // если каталог товаров
        case IMPORT_COMMERCEML_TYPE_CATALOG:

          // какой режим подключения к точке импорта?
          switch ($mode) {

            // если авторизация
            case IMPORT_COMMERCEML_MODE_AUTHORIZATION:

              // отвечаем УСПЕШНО + КОНТРОЛЬНЫЙ МАРКЕР
              echo "success\n"
                 . "controller\n"
                 . $controller;
              exit;

            // если инициализация
            case IMPORT_COMMERCEML_MODE_INITIALIZATION:

              // отвечаем НЕ РАБОТАЕМ С ZIP-АРХИВОМ + ПЕРЕДАВАТЬ ФАЙЛЫ ЧАСТЯМИ ПО 64 КБАЙТ
              echo "zip=no\n"
                 . "file_limit=65536\n";
              exit;

            // если передача файла
            case IMPORT_COMMERCEML_MODE_FILEUPLOAD:

              // если контрольный маркер совпадает, добавляем в файл переданную часть
              $file = $folder . $this->hdd->safeFilename($file);
              if (($controller == $marker)
              && ($handle = @fopen($file, "ab"))) {
                @fwrite($handle, @file_get_contents("php://input"));
                @fclose($handle);
                echo "success\n";
              } else {
                echo "failure\n";
              }
              exit;

            // если разрешение импорта
            case IMPORT_COMMERCEML_MODE_STARTIMPORT:

              // если контрольный маркер совпадает, парсим XML в принятом файле
              $file = $folder . $this->hdd->safeFilename($file);
              if ($controller == $marker) {
                $xml = simplexml_load_file($file);

                // если есть список категорий / свойств
                if (isset($xml->Классификатор)) {
//                  commerceml_categories($xml->Классификатор);
//                  commerceml_properties($xml->Классификатор);
                }

                // если есть товары / варианты
//                if (isset($xml->Каталог)) commerceml_products($xml->Каталог);
//                if (isset($xml->ПакетПредложений)) commerceml_variants($xml->ПакетПредложений);

                echo "success\n";
              } else {
                echo "failure\n";
              }

              // удаляем обработанный файл
              if (file_exists($file)) @unlink($file);
              exit;

            // иначе неизвестный режим подключения
            default:
              echo "failure\n";
              exit;
          }
          break;

        // если заказы
        case IMPORT_COMMERCEML_TYPE_SALE:
          break;
      }
    }

    // сбор параметров html-формы ============================================

    protected function collect_inputs (&$inputs, &$params, $default_sort, $session_param) {

      $inputs = array();
      $params = new stdClass;

      // собираем параметры сортировки
      $params->sort = $default_sort;
      if (isset($_REQUEST['sort'])) $_SESSION[$session_param] = $_REQUEST['sort'];
      if (isset($_SESSION[$session_param])) $params->sort = intval($_SESSION[$session_param]);
      $inputs['sort'] = $params->sort;

      // собираем параметры фильтра (разрешен)
      if (isset($_REQUEST['filter_enabled'])) {
        $value = trim($_REQUEST['filter_enabled']);
        if ($value != "") $params->enabled = $value;
        $inputs['filter_enabled'] = $value;
      }

      // собираем параметры фильтра (автоматический запуск)
      if (isset($_REQUEST['filter_automatic'])) {
        $value = trim($_REQUEST['filter_automatic']);
        if ($value != "") $params->automatic = $value;
        $inputs['filter_automatic'] = $value;
      }

      // собираем параметры фильтра (поддерживающий интерфейс)
      if (isset($_REQUEST['filter_interfaced'])) {
        $value = trim($_REQUEST['filter_interfaced']);
        if ($value != "") $params->interfaced = $value;
        $inputs['filter_interfaced'] = $value;
      }

      // собираем параметры фильтра (аутентификатор операции)
      $inputs[REQUEST_PARAM_NAME_TOKEN] = $this->token;
    }



    // ===================================================================
    /**
    *  Визуализация данных (результирующего контента)
    *
    *  @access  public
    *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
    *  @return  boolean             TRUE если просят продолжать открытие страницы
    */
    // ===================================================================

    public function fetch ( & $parent = null ) {

        // читаем входной параметр ITEMID - идентификатор оперируемой записи,
        // параметр ACTION - какую команду требовали сделать
        $id = trim($this->param('item_id'));
        $act = trim($this->param('act'));

        // если передали идентификатор оперируемой записи и была команда "Импорт"
        if (!empty($id) && $act == 'import') {

            // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
            $this->check_token();

            if ($this->config->demo && $this->dbtable == 'imports') {
                $error = 'В демо версии запрещено запускать импорт вручную.';
            } else {

                // разрешаем выполнить скрипт до конца (не обращать внимание на возможный разрыв соединения с пользователем),
                // снимаем ограничение на время выполнения скрипта
                @ ignore_user_abort(TRUE);
                @ set_time_limit(0);

                // ставим на сайте вывеску "Обновление информации"
                $this->putup_UPDATING_WORKS_INFO(TRUE);

                // делаем импорт по сведениям из оперируемой записи (запись будет прочитана во время импорта)
                $error = $this->import($id, IMPORT_START_MODE_MANUALLY);

                // снимаем вывеску "Обновление информации"
                $this->putup_UPDATING_WORKS_INFO(FALSE);

                // если импорт прошел успешно (нет сообщения об ошибке)
                if (empty($error)) {
                    // устанавливаем заголовок страницы
                    $this->title = 'Импорт данных: вариант "' . trim($this->item->name) . '"';

                    // передаем нужные данные в шаблонизатор,
                    // создаем контент модуля
                    $this->smarty->assign('ProductsAdded', $this->products_added);
                    $this->smarty->assign('ProductsUpdated', $this->products_updated);
                    $this->smarty->assign('ProductsSkiped', $this->products_skiped);
                    $this->smarty->assign('ProductsDeletedAncientQ0', $this->products_deleted_ancientQ0);
                    $this->smarty->assign('ProductsDeletedAncientS0', $this->products_deleted_ancientS0);
                    $this->smarty->assign('VariantsAdded', $this->variants_added);
                    $this->smarty->assign('VariantsUpdated', $this->variants_updated);
                    $this->smarty->assign('VariantsSkiped', $this->variants_skiped);
                    $this->smarty->assign('CategoriesAdded', $this->categories_added);
                    $this->smarty->assign('BrandsAdded', $this->brands_added);
                    $this->smarty->assign('PropertiesAdded', $this->properties_added);
                    $this->smarty->assignByRef('StatisticData', $this->statistic_data);
                    $this->smarty->assignByRef('item', $this->item);
                    $this->smarty->assignByRef('message', $this->info_msg);
                    $this->smarty->assignByRef('error', $this->error_msg);
                    $this->body = $this->smarty->fetch('admin_imports_result.htm');
                    return TRUE;
                }
            }

            // иначе добавляем текст ошибки в общее сообщение
            $this->push_error($error);
        }

        // обрабатываем соответствующие модулю настройки сайта,
        // обрабатываем входные команды,
        // устанавливаем заголовок страницы
        $this->process_setup();
        $this->process();
        $this->title = 'Варианты импорта';

        // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
        $this->collect_inputs($inputs, $params, SORT_IMPORTS_MODE_BY_NAME, 'admin_imports_sort_method');

        // читаем список вариантов импорта на текущей странице согласно параметрам фильтра и сортировки
        $current_page = intval($this->param('page'));
        $params->start = $current_page * $this->items_per_page;
        $params->maxcount = $this->items_per_page;
        $count = $this->db->imports->get($items, $params);
        $this->db->imports->unpackRecords($items);

        // создаем контент листания страниц
        if (isset($params->sort)) $this->params['sort'] = $params->sort;
        if (isset($params->enabled)) $this->params['filter_enabled'] = $params->enabled;
        if (isset($params->automatic)) $this->params['filter_automatic'] = $params->automatic;
        if (isset($params->interfaced)) $this->params['filter_interfaced'] = $params->interfaced;
        $pages_num = $count / $this->items_per_page;
        $navigator = new PagesNavigation($this);
        $navigator->make($pages_num, $count);

        // добавляем в записи вариантов импорта оперативные ссылки админпанели
        $params->token = $this->token;
        $this->db->imports->operable($items, $params);

        // передаем нужные данные в шаблонизатор,
        // создаем контент модуля
        $this->smarty->assignByRef('items', $items);
        $this->smarty->assignByRef('inputs', $inputs);
        $this->smarty->assignByRef('PagesNavigation', $navigator->body);
        $this->smarty->assignByRef('CurrentPageMaxsize', $this->items_per_page);
        $this->smarty->assignByRef('message', $this->info_msg);
        $this->smarty->assignByRef('error', $this->error_msg);
        $this->body = $this->smarty->fetch('admin_imports.htm');

        return TRUE;
    }
  }



    // =========================================================================
    // Класс Import (админ модуль варианта импорта)
    // =========================================================================

    class Import extends Imports {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_IMPORT_CLASS_RESULT_PAGE;



        // ===================================================================
        /**
        *  Визуализация данных (результирующего контента)
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetch ( & $parent = null ) {

            // если в запросе есть параметр FROM (страница возврата из операции),
            // запоминаем его, передаем в шаблонизатор и убираем из запроса
            $result_page = trim($this->param('from'));
            if (!empty($result_page)) {
                $this->result_page = $result_page;
                $this->destroy_param('from');
                $this->smarty->assignByRef('from_page', $result_page);
            }

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды
            $this->process_setup();
            $this->process();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param('item_id'));

            // устанавливаем заголовок страницы,
            // если нет данных варианта импорта или они изменились,
            //   читаем их из базы данных
            $this->title = 'Новый вариант импорта';
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->imports->one($this->item, $params);
            }

            // если данные варианта импорта получены,
            //   меняем заголовок страницы,
            if (!empty($this->item)) {
                $this->title = 'Редактирование варианта импорта "' . (isset($this->item->name) ? $this->item->name : '') . '"';

                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->imports->unpack($this->item);
            } else {

                // инициируем важные поля новой записи
                $this->item = new stdClass;
                $this->item->enabled = 1;
                $this->item->delimiter = ';';
                $this->item->format = IMPORT_FORMAT_NAME_CSV;
                $this->item->automatic = 0;
                $this->item->lifetime = 24 * 3600;
                $this->item->before_action = BEFORE_IMPORT_OPERATION_NO_ACTION;
                $this->item->marketing_update = 0;
                $this->item->financial_update = 0;
                $this->item->created = date('Y-m-d H:i');

                // выдумываем пароль
                $this->item->password = $this->security->generatePassword(10);
            }

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef('item', $this->item);
            $this->smarty->assignByRef('message', $this->info_msg);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->body = $this->smarty->fetch('admin_import.htm');
            return TRUE;
        }
    }

    return;
?>