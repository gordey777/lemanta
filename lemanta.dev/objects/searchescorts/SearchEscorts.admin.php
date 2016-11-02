<?php
    // =======================================================================
    /**
    *  Админ модуль поискового сопровождения
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемого списка
    require_once(dirname(__FILE__) . '/../.ref-models/AdminList.php');

    // текст заголовка страницы модуля
    define('SEARCHESCORTS_PAGE_TITLE', 'Поисковое сопровождение');

    // имя файла шаблона модуля
    define('SEARCHESCORTS_TEMPLATE_FILENAME', 'search_escorts/search_escorts.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('SEARCHESCORTS_MODULELINK_POINTER', 'SearchEscorts');
    define('SEARCHESCORTS_MODULETAB_TEXT', 'поиски');
    define('SEARCHESCORTS_MODULEMENU_PATH', 'Разное / SEO / Поисковое сопровождение');



    // =======================================================================
    /**
    *  Админ модуль поискового сопровождения
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SearchEscorts extends AdminListREFModel {

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = DATABASE_SEARCHES_TABLENAME;
        protected $id_field = 'search_id';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'searches';

        // сколько записей размещать на странице
        protected $items_per_page = DEFAULT_VALUE_FOR_SEARCHES_ON_PAGE_IN_ADMIN;

        // имя файла шаблона
        protected $template = SEARCHESCORTS_TEMPLATE_FILENAME;

        // перечень имен разрешенных команд редактирования записей
        protected $my_actions = array(ACTION_REQUEST_PARAM_VALUE_ENABLED,
                                      ACTION_REQUEST_PARAM_VALUE_MASSDELETE,
                                      ACTION_REQUEST_PARAM_VALUE_DELETE);



        // ===================================================================
        /**
        *  Сохранение полученных во время редактирования настроек сайта
        *
        *  @access  protected
        *  @param   string  $upload_folder      относительное имя папки сохранения ожидаемых файлов (будет возвращено сюда)
        *                                       пустая строка = не ждем таких
        *  @param   string  $upload_watermark   имя ожидаемого файла водяного знака (будет возвращено сюда)
        *                                       пустая строка = не ждем такой файл
        *  @return  void
        */
        // ===================================================================

        protected function processSetupSave ( & $upload_folder = '', & $upload_watermark = '' ) {

            // включена ли функция
            $this->cms->db->settings->saveFromPost('searches_enabled', 'Поисковое сопровождение - отображение - включена ли функция');

            // список отслеживаемых источников
            $name = 'searches_referers';
                $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
                $value = preg_replace('/[ \t]*[\r\n]+[ \t]*/', "\r\n", $value);
                $value = preg_replace('/[ \t]+/', ' ', $value);
                $this->cms->db->settings->save($name, $value, 'Поисковое сопровождение - выполнение - список отслеживаемых источников трафика');

            // антиспам пауза
            $name = 'searches_next_time';
                $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_SEARCHES_NEXTTIME;
                $value = min($value, SETTINGS_MAXIMAL_SEARCHES_NEXTTIME);
                $value = max(SETTINGS_MINIMAL_SEARCHES_NEXTTIME, $value);
                $this->cms->db->settings->save($name, $value, 'Поисковое сопровождение - выполнение - антиспам пауза между запросами того же человека');

            // антиспам пауза для зомбо-сети
            $name = 'searches_next_time_zombie';
                $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_SEARCHES_NEXTTIME;
                $value = min($value, SETTINGS_MAXIMAL_SEARCHES_NEXTTIME);
                $value = max(SETTINGS_MINIMAL_SEARCHES_NEXTTIME, $value);
                $this->cms->db->settings->save($name, $value, 'Поисковое сопровождение - выполнение - антиспам пауза между запросами зомбо-сети');

            // число записей в списке админпанели
            $name = 'searches_num_admin';
                $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
                $value = min($value, SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN);
                $value = max(SETTINGS_MINIMAL_ITEMS_NUM_ADMIN, $value);
                $this->cms->db->settings->save($name, $value, 'Поисковое сопровождение - отображение - число записей на странице админпанели');

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
        }



        // ===================================================================
        /**
        *  Обработка редактирования полей записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processRecordEditFields ( & $item, $id, & $cancel = FALSE ) {

            $model = $this->getDBModel();

            // поле enabled (разрешена ли к показу на сайте)
            $field = 'enabled';
            if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI])
            || !$_POST[REQUEST_PARAM_NAME_POST_MINI]
            || isset($_POST[$field][$id])) {
                $value = isset($_POST[$field][$id]) ? ($_POST[$field][$id] ? 1 : 0) : 0;
                $this->item->$field = $value;
            }

            // поле name (поисковая фраза)
            $field = 'name';
            if (isset($_POST[$field][$id])) {
                $method = 'standardize_' . $field;
                $_POST[$field][$id] = $this->cms->db->$model->$method($_POST[$field][$id]);
            }
            $this->processFieldName($this->item, $id, $cancel,
                                    'Не указана поисковая фраза.',
                                    'Уже есть другая запись с аналогичной поисковой фразой.');

            // поле escort_url (сопровождаемый URL)
            $field = 'escort_url';
            if (isset($_POST[$field][$id])) {
                $method = 'standardize_' . $field;
                $this->item->$field = $this->cms->db->$model->$method($_POST[$field][$id]);
            }

            // поле target_url (предлагавшийся URL)
            $field = 'target_url';
            if (isset($_POST[$field][$id])) {
                $method = 'standardize_' . $field;
                $this->item->$field = $this->cms->db->$model->$method($_POST[$field][$id]);
            }

            // поле referer (источник трафика)
            $field = 'referer';
            if (isset($_POST[$field][$id])) {
                $method = 'standardize_' . $field;
                $this->item->$field = $this->cms->db->$model->$method($_POST[$field][$id]);
            }

            // поле browsed (количество просмотров)
            $field = 'browsed';
            if (isset($_POST[$field][$id])) {
                $value = trim($_POST[$field][$id]);
                $this->item->$field = $value;
            }

            // поле created (дата создания)
            $field = 'created';
            if (isset($_POST[$field][$id])) {
                $value = $this->fixDateValue($_POST[$field][$id]);
                $this->item->$field = $value;
            }

            // поле modified (дата изменения)
            $field = 'modified';
            if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI])
            || !$_POST[REQUEST_PARAM_NAME_POST_MINI]
            || isset($_POST[$field][$id])) {
                $value = isset($_POST[$field][$id]) ? $this->fixDateValue($_POST[$field][$id]) : time();
                $this->item->$field = $value;
            }

            // поле deleted (удалена ли запись)
            $field = 'deleted';
            if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI])
            || !$_POST[REQUEST_PARAM_NAME_POST_MINI]
            || isset($_POST[$field][$id])) {
                $value = isset($_POST[$field][$id]) ? ($_POST[$field][$id] ? 1 : 0) : 0;
                $this->item->$field = $value;
            }
        }



        // ===================================================================
        /**
        *  Извлечение названия записи
        *
        *  @access  public
        *  @param   object  $record     объект записи
        *  @return  string              название
        */
        // ===================================================================

        public function getRecordName ( & $record = null ) {
            $name = isset($record->name) ? trim($record->name) : '';
            return $name != '' ? $name : 'Без названия!';
        }



        // ===================================================================
        /**
        *  Инициализация важных полей новой записи
        *
        *  @access  public
        *  @param   object  $record     объект записи
        *  @return  void
        */
        // ===================================================================

        public function initRecord ( & $record = null ) {
            parent::initRecord($record);
            $record->name = '';
            $record->referer = '';
            $record->escort_url = '';
            $record->browsed = 0;
            $record->enabled = 1;
            $record->deleted = 0;
            $record->modified = '0000-00-00 00:00:00';
        }



        // ===================================================================
        /**
        *  Деидентификация записи (подготовка для копии)
        *
        *  @access  public
        *  @param   object  $record     объект записи
        *  @return  void
        */
        // ===================================================================

        public function unIdentifyRecord ( & $record = null ) {
            $id = $this->id_field;
            $record->$id = 0;
            $record->name = '[Копия] ' . $this->getRecordName($record);
        }



        // ===================================================================
        /**
        *  Создание значений по умолчанию некоторых элементов html-формы
        *
        *  @access  public
        *  @return  object              объект значений
        */
        // ===================================================================

        public function createDefaults () {
            $defaults = parent::createDefaults();
            $defaults->sort = SORT_SEARCHES_MODE_AS_IS;
            $defaults->type = TYPE_SEARCHES_ANY;
            return $defaults;
        }



        // ===================================================================
        /**
        *  Установка параметров для навигатора страниц
        *
        *  @access  public
        *  @param   object  $inputs         настоящие значения некоторых элементов html-формы
        *  @param   object  $params         собранные параметры фильтра
        *  @return  void
        */
        // ===================================================================

        public function setNavigatorParams ( & $inputs, & $params ) {
            parent::setNavigatorParams($inputs, $params);
            if (isset($params->deleted)) $this->cms->params[REQUEST_PARAM_NAME_FILTER_DELETED] = $params->deleted;
            if (isset($params->search)) $this->cms->params[REQUEST_PARAM_NAME_FILTER_SEARCH] = $params->search;
            if (isset($params->search_date_from)) $this->cms->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM];
            if (isset($params->search_date_to)) $this->cms->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO];
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(SEARCHESCORTS_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>