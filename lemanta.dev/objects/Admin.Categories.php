<?php
    // Impera CMS: админ модуль списка категорий,
    //             админ модуль страницы категории,
    //             админ модуль списка брендов,
    //             админ модуль страницы бренда,
    //             админ модуль списка свойств товаров,
    //             админ модуль страницы свойства товара,
    //             админ модуль списка складов,
    //             админ модуль страницы склада.
    // Copyright AIMatrix, 2011.
    // http://aimatrix.itak.info

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT);

    // какой файл является шаблоном модуля списка категорий,
    // какой файл является шаблоном модуля страницы категории,
    // какой файл является шаблоном модуля списка брендов,
    // какой файл является шаблоном модуля страницы бренда,
    // какой файл является шаблоном модуля списка свойств товаров,
    // какой файл является шаблоном модуля страницы свойства товара,
    // какой файл является шаблоном модуля списка складов,
    // какой файл является шаблоном модуля страницы склада
    define('ADMIN_CATEGORIES_CLASS_TEMPLATE_FILE', 'admin_categories.htm');
    define('ADMIN_CATEGORY_CLASS_TEMPLATE_FILE', 'admin_category.htm');
    define('ADMIN_BRANDS_CLASS_TEMPLATE_FILE', 'admin_brands.htm');
    define('ADMIN_BRAND_CLASS_TEMPLATE_FILE', 'admin_brand.htm');
    define('ADMIN_PROPERTIES_CLASS_TEMPLATE_FILE', 'admin_properties.htm');
    define('ADMIN_PROPERTY_CLASS_TEMPLATE_FILE', 'admin_property.htm');
    define('ADMIN_STOCKS_CLASS_TEMPLATE_FILE', 'admin_stocks.htm');
    define('ADMIN_STOCK_CLASS_TEMPLATE_FILE', 'admin_stock.htm');

    // какая страница возврата рекомендуется для модуля страницы категории,
    // какая страница возврата рекомендуется для модуля страницы бренда,
    // какая страница возврата рекомендуется для модуля страницы свойства товара,
    // какая страница возврата рекомендуется для модуля страницы склада
    define('ADMIN_CATEGORY_CLASS_RESULT_PAGE', 'index.php?section=Categories');
    define('ADMIN_BRAND_CLASS_RESULT_PAGE', 'index.php?section=Brands');
    define('ADMIN_PROPERTY_CLASS_RESULT_PAGE', 'index.php?section=Properties');
    define('ADMIN_STOCK_CLASS_RESULT_PAGE', 'index.php?section=Stocks');

    // какая папка содержит изображения для категорий (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для брендов (папку задаем относительно корневой папки сайта),
    // какая папка является принимающей файлы для свойств товаров (папку задаем относительно административной папки сайта),
    // какая папка содержит изображения для складов (папку задаем относительно корневой папки сайта)
    define('ADMIN_CATEGORIES_CLASS_UPLOAD_FOLDER', 'files/categories/');
    define('ADMIN_BRANDS_CLASS_UPLOAD_FOLDER', 'files/brands/');
    define('ADMIN_PROPERTIES_CLASS_UPLOAD_FOLDER', '');
    define('ADMIN_STOCKS_CLASS_UPLOAD_FOLDER', 'files/stocks/');

    // имя файла водяного знака для категорий,
    // имя файла водяного знака для брендов,
    // имя файла водяного знака для складов
    define('CATEGORIES_CLASS_WATERMARK_FILENAME', 'categories_watermark.png');
    define('BRANDS_CLASS_WATERMARK_FILENAME', 'brands_watermark.png');
    define('STOCKS_CLASS_WATERMARK_FILENAME', 'stocks_watermark.png');

    // названия динамических параметров
    define('CATEGORIES_SORT_SESSION_PARAM_NAME', 'admin_categories_sort_method');
    define('BRANDS_SORT_SESSION_PARAM_NAME', 'admin_brands_sort_method');
    define('PROPERTIES_SORT_SESSION_PARAM_NAME', 'admin_properties_sort_method');
    define('STOCKS_SORT_SESSION_PARAM_NAME', 'admin_stocks_sort_method');

    // предельный уровень восхода к корню ветвей для команды "Удалить пустые"
    define('DELETE_EMPTIES_OPERATION_MAX_LEVEL', 100);



    // =========================================================================
    // Класс Categories (админ модуль списка категорий)
    // =========================================================================

    class Categories extends Basic {

        // с какой таблицей базы данных работаем,
        // какое поле таблицы является идентификатором записей
        public $dbtable = DATABASE_CATEGORIES_TABLENAME;
        public $dbtable_field = 'category_id';



        // рекомендуемая страница возврата после операции,
        // в какую папку выгружать изображения
        public $result_page = '';
        public $upload_folder = ADMIN_CATEGORIES_CLASS_UPLOAD_FOLDER;



        // оперируемая запись
        protected $item = null;



        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('all_users',
                                      'menus');



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

            // добавляем префикс папки изображений
            $this->upload_folder = $this->settings->categories_files_folder_prefix . $this->upload_folder;
        }



        // обработка соответствующих модулю настроек сайта =======================

        protected function process_setup () {

          // если получены данные об изменениях соответствующих настроек сайта
          if (isset($_POST[REQUEST_PARAM_NAME_SETUP])) {

            // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
            $this->check_token();

            // с какой базой данных работаем?
            switch ($this->dbtable) {

              // если бренды
              case DATABASE_BRANDS_TABLENAME:
                $name = 'brands_files_folder_prefix';
                  $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
                  $value = str_replace('/', ' ', $value);
                  $value = str_replace('\\', ' ', $value);
                  $value = str_replace(':', ' ', $value);
                  while (strpos($value, '  ') !== FALSE) $value = str_replace('  ', ' ', $value);
                  $value = str_replace(' ', '_', trim($value));
                  $this->db->settings->save($name, $value, 'Бренды - изображения - префикс папки с файлами изображений');
                $name = 'brands_images_quality';
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
                  if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
                  $this->db->settings->save($name, $value, 'Бренды - изображения - качество');
                $name = 'brands_images_width';
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
                  if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
                  $this->db->settings->save($name, $value, 'Бренды - изображения - предельная ширина');
                $name = 'brands_images_height';
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
                  if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
                  $this->db->settings->save($name, $value, 'Бренды - изображения - предельная высота');
                $name = 'brands_thumbnail_width';
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
                  if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
                  if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
                  $this->db->settings->save($name, $value, 'Бренды - миниатюры - предельная ширина');
                $name = 'brands_thumbnail_height';
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
                  if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
                  if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
                  $this->db->settings->save($name, $value, 'Бренды - миниатюры - предельная высота');
                $name = 'brands_watermark_transparency';
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
                  if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
                  if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
                  $this->db->settings->save($name, $value, 'Бренды - водяной знак - процент видимости на картинке');
                $this->db->settings->saveFromPost('brands_images_exactly',        'Бренды - изображения - подгонять ли размеры картинок, меньших предельных размеров');
                $this->db->settings->saveFromPost('brands_watermark_enabled',     'Бренды - водяной знак - разрешено ли накладывать на картинку');
                $this->db->settings->saveFromPost('brands_watermark_location',    'Бренды - водяной знак - расположение');
                $this->db->settings->saveFromPost('brands_wysiwyg_disabled',      'Бренды - редактирование - запрещен ли визуальный редактор');
                $this->db->settings->saveFromPost('brands_wysiwyg_disabled_mode', 'Бренды - редактирование - режим обработки текста при отключенном визуальном редакторе');
                $this->db->settings->saveFromPost('brands_meta_autofill',         'Бренды - редактирование - заполнять ли пустые поля мета информации автоматически');
                $this->db->settings->saveFromPost('brands_sort_method',           'Бренды - отображение - способ сортировки на стороне клиента');
                $upload_folder = $this->settings->brands_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
                $upload_url = BRANDS_CLASS_WATERMARK_FILENAME;

                // очищаем соответствующие кеш-таблицы
                $this->resetCaches();
                break;

              // если категории
              case DATABASE_CATEGORIES_TABLENAME:
                $name = "categories_files_folder_prefix";
                  $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
                  $value = str_replace("/", " ", $value);
                  $value = str_replace("\\", " ", $value);
                  $value = str_replace(":", " ", $value);
                  while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
                  $value = str_replace(" ", "_", trim($value));
                  $this->db->settings->save($name, $value, "Категории - изображения - префикс папки с файлами изображений");
                $name = "categories_images_quality";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
                  if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
                  $this->db->settings->save($name, $value, "Категории - изображения - качество");
                $name = "categories_images_width";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
                  if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
                  $this->db->settings->save($name, $value, "Категории - изображения - предельная ширина");
                $name = "categories_images_height";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
                  if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
                  $this->db->settings->save($name, $value, "Категории - изображения - предельная высота");
                $name = "categories_thumbnail_width";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
                  if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
                  if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
                  $this->db->settings->save($name, $value, "Категории - миниатюры - предельная ширина");
                $name = "categories_thumbnail_height";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
                  if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
                  if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
                  $this->db->settings->save($name, $value, "Категории - миниатюры - предельная высота");
                $name = "categories_watermark_transparency";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
                  if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
                  if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
                  $this->db->settings->save($name, $value, "Категории - водяной знак - процент видимости на картинке");
                $this->db->settings->saveFromPost("categories_images_exactly",        "Категории - изображения - подгонять ли размеры картинок, меньших предельных размеров");
                $this->db->settings->saveFromPost("categories_watermark_enabled",     "Категории - водяной знак - разрешено ли накладывать на картинку");
                $this->db->settings->saveFromPost("categories_watermark_location",    "Категории - водяной знак - расположение");
                $this->db->settings->saveFromPost("categories_wysiwyg_disabled",      "Категории - редактирование - запрещен ли визуальный редактор");
                $this->db->settings->saveFromPost("categories_wysiwyg_disabled_mode", "Категории - редактирование - режим обработки текста при отключенном визуальном редакторе");
                $this->db->settings->saveFromPost("categories_meta_autofill",         "Категории - редактирование - заполнять ли пустые поля мета информации автоматически");
                $this->db->settings->saveFromPost("categories_sort_method",           "Категории - отображение - способ сортировки на стороне клиента");
                $upload_folder = $this->settings->categories_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
                $upload_url = CATEGORIES_CLASS_WATERMARK_FILENAME;

                // очищаем соответствующие кеш-таблицы
                $this->resetCaches();
                break;

              // если свойства товаров
              case "properties":
                break;

              // если склады
              case "stocks":
                $name = "stocks_files_folder_prefix";
                  $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
                  $value = str_replace("/", " ", $value);
                  $value = str_replace("\\", " ", $value);
                  $value = str_replace(":", " ", $value);
                  while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
                  $value = str_replace(" ", "_", trim($value));
                  $this->db->settings->save($name, $value, "Склады - изображения - префикс папки с файлами изображений");
                $name = "stocks_images_quality";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
                  if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
                  $this->db->settings->save($name, $value, "Склады - изображения - качество");
                $name = "stocks_images_width";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
                  if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
                  $this->db->settings->save($name, $value, "Склады - изображения - предельная ширина");
                $name = "stocks_images_height";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
                  if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
                  if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
                  $this->db->settings->save($name, $value, "Склады - изображения - предельная высота");
                $name = "stocks_thumbnail_width";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
                  if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
                  if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
                  $this->db->settings->save($name, $value, "Склады - миниатюры - предельная ширина");
                $name = "stocks_thumbnail_height";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
                  if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
                  if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
                  $this->db->settings->save($name, $value, "Склады - миниатюры - предельная высота");
                $name = "stocks_watermark_transparency";
                  $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
                  if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
                  if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
                  $this->db->settings->save($name, $value, "Склады - водяной знак - процент видимости на картинке");
                $this->db->settings->saveFromPost("stocks_images_exactly",        "Склады - изображения - подгонять ли размеры картинок, меньших предельных размеров");
                $this->db->settings->saveFromPost("stocks_watermark_enabled",     "Склады - водяной знак - разрешено ли накладывать на картинку");
                $this->db->settings->saveFromPost("stocks_watermark_location",    "Склады - водяной знак - расположение");
                $this->db->settings->saveFromPost("stocks_wysiwyg_disabled",      "Склады - редактирование - запрещен ли визуальный редактор");
                $this->db->settings->saveFromPost("stocks_wysiwyg_disabled_mode", "Склады - редактирование - режим обработки текста при отключенном визуальном редакторе");
                $this->db->settings->saveFromPost("stocks_meta_autofill",         "Склады - редактирование - заполнять ли пустые поля мета информации автоматически");
                $this->db->settings->saveFromPost("stocks_sort_method",           "Склады - отображение - способ сортировки на стороне клиента");
                $this->db->settings->saveFromPost("stocks_main_title",            "Склады - отображение - оглавление списка на стороне клиента");
                $this->db->settings->saveFromPost("stocks_main_path",             "Склады - отображение - путевое название списка в навигаторе на стороне клиента");
                $this->db->settings->saveFromPost("stocks_main_keywords",         "Склады - отображение - ключевые мета слова списка на стороне клиента");
                $this->db->settings->saveFromPost("stocks_main_description",      "Склады - отображение - мета описание списка на стороне клиента");
                $upload_folder = $this->settings->stocks_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
                $upload_url = STOCKS_CLASS_WATERMARK_FILENAME;

                // очищаем соответствующие кеш-таблицы
                $this->resetCaches();
                break;
            }

            // может пытались загрузить изображение водяного знака?
            if (isset($upload_url)) $this->editor->processWatermark($upload_folder, $upload_url);
          }
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
          $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
          $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
          $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

          // если действительно передали идентификатор оперируемой записи или это команда "Удалить пустые"
          if (!empty($id) || ($act == ACTION_REQUEST_PARAM_VALUE_DELETEEMPTIES)) {

            // создаем пустой массив для запросов
            $query = array();

            // какую команду требовали сделать во входном параметре ACTION?
            switch ($act) {

              // если команду "Разрешить / запретить показ записи"
              case ACTION_REQUEST_PARAM_VALUE_ENABLED:
                $this->action_enabled($id, $query);
                break;

              // если команду "Выделить / НеВыделять визуально"
              case ACTION_REQUEST_PARAM_VALUE_HIGHLIGHTED:
                $this->action_highlighted($id, $query);
                break;

              // если команду "Открыть / скрыть от незарегистрированных пользователей" (она не для таблицы properties базы данных)
              case ACTION_REQUEST_PARAM_VALUE_HIDDEN:
                if ($this->dbtable != "properties") {
                  $this->action_hidden($id, $query);
                }
                break;

              // если команду "Разрешить / запретить собственный субдомен" (она для таблиц brands или categories базы данных)
              case ACTION_REQUEST_PARAM_VALUE_DOMAINED:
                if (($this->dbtable == DATABASE_BRANDS_TABLENAME) || ($this->dbtable == DATABASE_CATEGORIES_TABLENAME)) {
                  $this->action_domained($id, $query);
                }
                break;

              // если команду "Считать / не считать информативной страницей" (она для таблиц brands или categories базы данных)
              case ACTION_REQUEST_PARAM_VALUE_INFORMATIVE:
                if (($this->dbtable == DATABASE_BRANDS_TABLENAME) || ($this->dbtable == DATABASE_CATEGORIES_TABLENAME)) {
                  $query[] = "UPDATE " . $this->dbtable . " "
                           . "SET informative = 1 - informative "
                           . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                }
                break;

              // если команду "Открыть / скрыть от всех пользователей" (она для таблицы stocks базы данных)
              case ACTION_REQUEST_PARAM_VALUE_VISIBLE:
                if ($this->dbtable == "stocks") {
                  $query[] = "UPDATE " . $this->dbtable . " "
                           . "SET visible = 1 - visible "
                           . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                }
                break;

              // если команду "Считать / не считать расходным" (она для таблицы stocks базы данных)
              case ACTION_REQUEST_PARAM_VALUE_ENABLEDEBIT:
                if ($this->dbtable == "stocks") {
                  $query[] = "UPDATE " . $this->dbtable . " "
                           . "SET enable_debit = 1 - enable_debit "
                           . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                }
                break;

              // если команду "Считать / не считать приходным" (она для таблицы stocks базы данных)
              case ACTION_REQUEST_PARAM_VALUE_ENABLECREDIT:
                if ($this->dbtable == "stocks") {
                  $query[] = "UPDATE " . $this->dbtable . " "
                           . "SET enable_credit = 1 - enable_credit "
                           . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                }
                break;



              // если команду "Считать / не считать разрешенным в Яндекс.Маркет"
              case ACTION_REQUEST_PARAM_VALUE_YMARKET:
                  switch ($this->dbtable) {
                      case DATABASE_CATEGORIES_TABLENAME:
                          $query[] = 'UPDATE `' . $this->dbtable . '` '
                                   . 'SET `ymarket` = `ymarket` ^ 1 '
                                   . 'WHERE `' . $this->dbtable_field . '` = \'' . $this->db->query_value($id) . '\';';
                          break;
                  }
                  break;



              // если команду "Поднять выше" (она не для таблицы properties базы данных)
              case ACTION_REQUEST_PARAM_VALUE_MOVEUP:
                if ($this->dbtable != "properties") {
                  $branch_field = ($this->dbtable != "stocks") ? "parent" : "";
                  $this->action_move_up($id, $query, $branch_field);
                }
                break;

              // если команду "Опустить ниже" (она не для таблицы properties базы данных)
              case ACTION_REQUEST_PARAM_VALUE_MOVEDOWN:
                if ($this->dbtable != "properties") {
                  $branch_field = ($this->dbtable != "stocks") ? "parent" : "";
                  $this->action_move_down($id, $query, $branch_field);
                }
                break;

              // если команду "Поставить первым" (она не для таблицы properties базы данных)
              case ACTION_REQUEST_PARAM_VALUE_MOVEFIRST:
                if ($this->dbtable != "properties") {
                  $branch_field = ($this->dbtable != "stocks") ? "parent" : "";
                  $this->action_move_first($id, $query, $branch_field);
                }
                break;

              // если команду "Поставить последним" (она не для таблицы properties базы данных)
              case ACTION_REQUEST_PARAM_VALUE_MOVELAST:
                if ($this->dbtable != "properties") {
                  $branch_field = ($this->dbtable != "stocks") ? "parent" : "";
                  $this->action_move_last($id, $query, $branch_field);
                }
                break;

              // если команду "Удалить запись"
              case ACTION_REQUEST_PARAM_VALUE_DELETE:
                switch ($this->dbtable) {
                  case DATABASE_BRANDS_TABLENAME:
                  case DATABASE_CATEGORIES_TABLENAME:

                    // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
                    // делаем запрос - не пустая ли запись,
                    //   если не пустая, сообщаем об ошибке,
                    // иначе даем запрос на удаление
                    $this->check_token();
                    $this->db->query("SELECT s1.name, "
                                          . "products.product_id, "
                                          . "articles.article_id, "
                                          . "news.news_id "
                                   . "FROM " . $this->dbtable . " s1 "
                                   . "LEFT JOIN products "
                                             . "ON products." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                                   . "LEFT JOIN articles "
                                             . "ON articles." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                                   . "LEFT JOIN news "
                                             . "ON news." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                                   . "LEFT JOIN " . $this->dbtable . " s2 "
                                             . "ON s2.parent = s1." . $this->dbtable_field . " "
                                   . "WHERE (products.product_id IS NOT NULL "
                                          . "OR articles.article_id IS NOT NULL "
                                          . "OR news.news_id IS NOT NULL "
                                          . "OR s2." . $this->dbtable_field . " IS NOT NULL) "
                                         . "AND s1." . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
                                   . "LIMIT 1;");
                    $items = $this->db->results();
                    if (!empty($items)) {
                      foreach ($items as &$item) {
                        $cancel = $this->push_error("Запись \"" . $item->name . "\" не может быть удалена, так как она содержит"
                                                  . (!empty($item->product_id) ? " товары" :
                                                    (!empty($item->article_id) ? " статьи" :
                                                    (!empty($item->news_id) ? " новости" : " вложенные элементы"))) . ".");
                        break;
                      }
                    } else {
                      $query[] = "DELETE s1 "
                                      . (($this->dbtable == DATABASE_CATEGORIES_TABLENAME) ?
                                          ", products_" . $this->dbtable . " " : "")
                               . "FROM " . $this->dbtable . " s1 "
                               . "LEFT JOIN products "
                                         . "ON products." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                               . "LEFT JOIN articles "
                                         . "ON articles." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                               . "LEFT JOIN news "
                                         . "ON news." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                               . "LEFT JOIN " . $this->dbtable . " s2 "
                                         . "ON s2.parent = s1." . $this->dbtable_field . " "
                               . (($this->dbtable == DATABASE_CATEGORIES_TABLENAME) ?
                                   "LEFT JOIN products_" . $this->dbtable . " "
                                           . "ON products_" . $this->dbtable . "." . $this->dbtable_field . " = s1." . $this->dbtable_field . " " : "")
                               . "WHERE products.product_id IS NULL "
                                     . "AND articles.article_id IS NULL "
                                     . "AND news.news_id IS NULL "
                                     . "AND s2." . $this->dbtable_field . " IS NULL "
                                     . "AND s1." . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                    }
                    break;
                  case "properties":
                    $this->action_delete($id, $query);
                    $query[] = "DELETE FROM " . $this->dbtable . "_values "
                             . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "'";
                    $query[] = "DELETE FROM " . $this->dbtable . "_categories "
                             . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "'";
                    break;
                  case "stocks":
                    $this->action_delete($id, $query);
                    break;
                }
                break;

              // если команду "Удалить пустые" (она для таблиц brands или categories базы данных)
              case ACTION_REQUEST_PARAM_VALUE_DELETEEMPTIES:
                if (($this->dbtable == DATABASE_BRANDS_TABLENAME) || ($this->dbtable == DATABASE_CATEGORIES_TABLENAME)) {

                  // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
                  // в цикле удаляем пустые записи, восходя от концов ветвей к корню не глубже заданного предела
                  $this->check_token();
                  $level = DELETE_EMPTIES_OPERATION_MAX_LEVEL;
                  do {
                    $query = "DELETE s1 "
                                  . (($this->dbtable == DATABASE_CATEGORIES_TABLENAME) ?
                                      ", products_" . $this->dbtable . " " : "")
                           . "FROM " . $this->dbtable . " s1 "
                           . "LEFT JOIN products "
                                     . "ON products." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                           . "LEFT JOIN articles "
                                     . "ON articles." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                           . "LEFT JOIN news "
                                     . "ON news." . $this->dbtable_field . " = s1." . $this->dbtable_field . " "
                           . "LEFT JOIN " . $this->dbtable . " s2 "
                                     . "ON s2.parent = s1." . $this->dbtable_field . " "
                           . (($this->dbtable == DATABASE_CATEGORIES_TABLENAME) ?
                               "LEFT JOIN products_" . $this->dbtable . " "
                                       . "ON products_" . $this->dbtable . "." . $this->dbtable_field . " = s1." . $this->dbtable_field . " " : "")
                           . "WHERE products.product_id IS NULL "
                                 . "AND articles.article_id IS NULL "
                                 . "AND news.news_id IS NULL "
                                 . "AND s2." . $this->dbtable_field . " IS NULL;";
                    $this->db->query($query);
                    $items = $this->db->affected_rows();
                    if ($items > 0) {
                      $this->changed = TRUE;
                      $level = $level - 1;
                    }
                  } while (($level > 0) && ($items > 1));

                  // для этой команды отслеживать изменения в базе данных уже не нужно,
                  // команда уже не требует выполнять запросы
                  $watching = FALSE;
                  $query = array();
                }
                break;

              // если команду "Удалить изображение" (она не для таблицы properties базы данных)
              case ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE:
                if ($this->dbtable != "properties") {

                  // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
                  // удаляем заказанные изображения
                  $this->check_token();
                  $this->action_delete_image($id, $query);
                }
                break;
            }

            // если получен набор запросов, то есть готовы выполнить операцию,
            //   проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
            //   делаем все запросы операции,
            //   если для команды не снято отслеживание изменений в базе данных, делаем его оценкой затронутых записей
            //   если страница возврата не указана, используем рекомендуемую страницу возврата
            if (!empty($query)) {
              $this->check_token();
              foreach ($query as &$command) $this->db->query($command);
              if ($watching) $this->changed = $this->changed || ($this->db->affected_rows() > 0);
              if (empty($result_page)) $result_page = trim($this->result_page);
            }
          }

          // обрабатываем редакторские изменения в записях (битовый OR использован для гарантии выполнения метода posting() независимо от настроек препроцессора)
          $cancel = $this->posting($result_page) | $cancel;

          // если произошли изменения в базе данных, очищаем соответствующие кеш-таблицы
          if ($this->changed) $this->resetCaches();

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

            // цикл по измененным записям
            foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {
              $item_cancel = FALSE;
              $value = $this->dbtable_field;



              // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
              $blank_item = new stdClass;
              $this->item = new stdClass;



              // для какой таблицы базы данных предназначена запись?
              switch ($this->dbtable) {
                  case DATABASE_CATEGORIES_TABLENAME:
                      // поле ymarket (разрешить ли экспорт в Яндекс.Маркет)
                      if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1)
                      || isset($_POST['ymarket'][$id])) {
                          $this->item->ymarket = 0;
                          if (isset($_POST['ymarket'][$id])) {
                              if (is_array($_POST['ymarket'][$id])) {
                                  for ($i = 1; $i <= 32; $i++) {
                                      if (isset($_POST['ymarket'][$id][$i])) {
                                          $v = $_POST['ymarket'][$id][$i] ? 1 : 0;
                                          $this->item->ymarket = $this->item->ymarket | $v << ($i - 1);
                                      }
                                  }
                              } else {
                                  if ($_POST['ymarket'][$id]) $this->item->ymarket = 1;
                              }
                          }
                      }
                      break;
              }



              // поле parent (идентификатор главной родительской ветки)
              if (isset($_POST["parent"][$id])) $this->item->parent = trim($_POST["parent"][$id]);
              // поле parents (идентификаторы остальных родительских веток)
              $this->process_parents($this->item, $id, $item_cancel);
              // поле menu_id (идентификатор меню)
              if (isset($_POST["menu_id"][$id])) $this->item->menu_id = trim($_POST["menu_id"][$id]);
              // поле user_id (идентификатор пользователя)
              if (isset($_POST["user_id"][$id])) $this->item->user_id = trim($_POST["user_id"][$id]);
              // поле objects (перечень подключаемых модулей через запятую)
              $this->editor->processObjects($this->item, $id, $item_cancel);
              // поле name (название)
              $this->editor->processName($this->item, $id, $item_cancel);
              // поле single_name (название в единственном числе)
              if (isset($_POST["single_name"][$id])) $this->item->single_name = trim($_POST["single_name"][$id]);
              // поле configurator_name (название в конфигураторе)
              if (isset($_POST["configurator_name"][$id])) $this->item->configurator_name = trim($_POST["configurator_name"][$id]);
              // поле meta_title (мета заголовок)
              if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
              // поле meta_keywords (мета ключевые слова)
              if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
              // поле meta_description (мета описание)
              if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
              // поле annotation (краткий текст)
              $this->editor->processAnnotation($this->item, $id, $item_cancel);
              // поле description (текст описания)
              $this->editor->processDescription($this->item, $id, $item_cancel);
              // поле seo_description (SEO текст)
              $this->editor->processSeoDescription($this->item, $id, $item_cancel);
              // поле enabled (разрешен ли к показу на сайте)
              $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
              // поле highlighted (выделен ли визуально)
              $this->item->highlighted = isset($_POST["highlighted"][$id]) ? (($_POST["highlighted"][$id] == 1) ? 1 : 0) : 0;
              // поле own_block (имеет ли свой блок в каталоге)
              $this->item->own_block = isset($_POST["own_block"][$id]) ? (($_POST["own_block"][$id] == 1) ? 1 : 0) : 0;
              // поле informative (считать ли информативной страницей)
              $this->item->informative = isset($_POST["informative"][$id]) ? (($_POST["informative"][$id] == 1) ? 1 : 0) : 0;
              // поле hidden (скрыт ли от незарегистрированных пользователей)
              $this->item->hidden = isset($_POST["hidden"][$id]) ? (($_POST["hidden"][$id] == 1) ? 1 : 0) : 0;
              // поле visible (видим ли пользователям)
              $this->item->visible = isset($_POST["visible"][$id]) ? (($_POST["visible"][$id] == 1) ? 1 : 0) : 0;
              // поле enable_debit (считать ли приходным)
              $this->item->enable_debit = isset($_POST["enable_debit"][$id]) ? (($_POST["enable_debit"][$id] == 1) ? 1 : 0) : 0;
              // поле enable_credit (считать ли расходным)
              $this->item->enable_credit = isset($_POST["enable_credit"][$id]) ? (($_POST["enable_credit"][$id] == 1) ? 1 : 0) : 0;
              // поле rss_disabled (запрещена ли демонстрация в RSS)
              $this->item->rss_disabled = isset($_POST["rss_disabled"][$id]) ? (($_POST["rss_disabled"][$id] == 1) ? 1 : 0) : 0;
              // поле export_disabled (запрещена ли демонстрация в информерах)
              $this->item->export_disabled = isset($_POST["export_disabled"][$id]) ? (($_POST["export_disabled"][$id] == 1) ? 1 : 0) : 0;
              // поле subdomain_enabled (разрешен ли собственный субдомен)
              $this->item->subdomain_enabled = isset($_POST["subdomain_enabled"][$id]) ? (($_POST["subdomain_enabled"][$id] == 1) ? 1 : 0) : 0;
              // поле subdomain (имя субдомена)
              $this->editor->processSubdomain($this->item, $id, $item_cancel);
              // поле subdomain_html (текст страницы собственного субдомена)
              $this->editor->processSubdomainHtml($this->item, $id, $item_cancel);
              // поле template (имя шаблона)
              $this->editor->processTemplate($this->item, $id, $item_cancel);
              // поле url, url_special (адрес страницы записи)
              $this->editor->processUrl($this->item, $id, $item_cancel);
              // поле tags (теги)
              if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
              // поле created (дата создания)
              if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
              // поле modified (дата изменения)
              $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
              // поле browsed (количество просмотров)
              if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
              // поле order_num (позиция элемента среди равных в ветви)
              if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
              // поле section (к какому разделу сайта принадлежит)
              if (isset($_POST["section_field"][$id])) $this->item->section = trim($_POST["section_field"][$id]);
              // поле in_prices (в каких прайсах используется)
              $this->editor->processInPrices($this->item, $id, $item_cancel);
              // поля image, images, images_alts, images_texts, images_view (изображения)
              $this->editor->processImages($this->item, $id, $item_cancel);



              // поле идентификатора записи
              if (!empty($this->item) && ($this->item != $blank_item)) {
                  if (!empty($id)) {
                      // это не добавление новой записи, поэтому устанавливаем идентификатор записи
                      $this->item->$value = $id;
                  } else {
                      // если не передано значение даты создания для новой записи, ставим ее равной текущей дате
                      if (!isset($this->item->created)) $this->item->created = time();
                  }
              }



              // если ошибок нет (не включился признак отмены)
              if (!$item_cancel && !empty($this->item) && ($this->item != $blank_item)) {
                // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы,
                // битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора)
                $this->item->indifferent_caches = TRUE;
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



        // обработка изменения поля PARENTS записи ===============================

        private function process_parents (&$item, $id, &$cancel) {
          if (isset($_POST["parents"][$id])) {
            $item->parents = array();
            // если указано, что точно имеет еще прикрепления кроме основного
            if (isset($_POST["use_parents"][$id]) && ($_POST["use_parents"][$id] == 1)) {
              // передаем в массив эти прикрепления, отбрасывая возможный дубль основного или корневого
              foreach ($_POST["parents"][$id] as $parent) {
                $parent = intval($parent);
                if (($parent != 0) && (!isset($item->parent) || ($parent != $item->parent))) {
                  $item->parents[$parent] = $parent;
                  // для html-формы запоминаем, что на самом деле найдены вторичные прикрепления
                  $item->use_parents = 1;
                }
              }
              sort($item->parents, SORT_NUMERIC);
            }
            // переводим массив прикреплений в текстовый вид (для записи в базу данных)
            $item->parents = implode(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, $item->parents);
          }
        }



        // обновление записи в базе данных =======================================

        protected function update ( & $item ) {

            // приказываем объекту базы данных обновить/добавить указанную запись
            return $this->db->categories->update($item);
        }



        // очистка соответствующих кеш-таблиц ====================================

        protected function resetCaches () {

            // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
            $this->db->reset_categories_caches();
        }



        // сбор параметров html-формы ============================================

        protected function collect_inputs (&$inputs, &$params, $default_sort, $session_param) {

          $inputs = array();
          $params = new stdClass;

          // собираем параметры сортировки
          $params->sort = $default_sort;
          if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT])) $_SESSION[$session_param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
          if (isset($_SESSION[$session_param])) $params->sort = intval($_SESSION[$session_param]);
          $inputs[REQUEST_PARAM_NAME_SORT] = $params->sort;



          // собираем параметры сортировки (глубина показа дерева категорий)
          if ($session_param == CATEGORIES_SORT_SESSION_PARAM_NAME) {
              $field = 'view_depth';
              $session_field = 'admin_categories_' . $field;
              $value = 2;
              if (isset($_REQUEST[$field])) {
                  $value = intval($_REQUEST[$field]);
                  $_SESSION[$session_field] = $value;
                  $_COOKIE[$session_field] = $value;
              } else {
                  if (!isset($_SESSION[$session_field]) && isset($_COOKIE[$session_field])) $_SESSION[$session_field] = $_COOKIE[$session_field];
              }
              if (isset($_SESSION[$session_field])) $value = intval($_SESSION[$session_field]);
              $value = max(1, $value);
              $params->$field = $value;
              $inputs[$field] = $value;
              @ setcookie($session_field, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
          }



          // собираем параметры фильтра (автор)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER]);
            if ($value != "") $params->user_id = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_USER] = $value;
          }

          // собираем параметры фильтра (раздел)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION]);
            if ($value != "") $params->section = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_SECTION] = $value;
          }

          // собираем параметры фильтра (разрешена)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED]);
            if ($value != "") $params->enabled = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_ENABLED] = $value;
          }

          // собираем параметры фильтра (скрыта от чужих)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN]);
            if ($value != "") $params->hidden = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $value;
          }

          // собираем параметры фильтра (видима пользователям)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_VISIBLE])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_VISIBLE]);
            if ($value != "") $params->visible = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_VISIBLE] = $value;
          }

          // собираем параметры фильтра (считать расходным)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLEDEBIT])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLEDEBIT]);
            if ($value != "") $params->enable_debit = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_ENABLEDEBIT] = $value;
          }

          // собираем параметры фильтра (считать приходным)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLECREDIT])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLECREDIT]);
            if ($value != "") $params->enable_credit = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_ENABLECREDIT] = $value;
          }

          // собираем параметры фильтра (информативная страница)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_INFORMATIVE])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_INFORMATIVE]);
            if ($value != "") $params->informative = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_INFORMATIVE] = $value;
          }

          // собираем параметры фильтра (имеет субдомен)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DOMAINED])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DOMAINED]);
            if ($value != "") $params->domained = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_DOMAINED] = $value;
          }

          // собираем параметры фильтра (с картинками)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED]);
            if ($value != "") $params->imaged = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_IMAGED] = $value;
          }

          // собираем параметры фильтра (меню)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU]);
            if ($value != "") $params->menu_id = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_MENU] = $value;
          }

          // собираем параметры фильтра (с модулями)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED]);
            if ($value != "") $params->objected = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $value;
          }

          // собираем параметры фильтра (с SEO текстом)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED]);
            if ($value != "") $params->SEOed = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_SEOED] = $value;
          }

          // собираем параметры фильтра (с особым url)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL]);
            if ($value != "") $params->url_special = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $value;
          }

          // собираем параметры фильтра (не для rss)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS]);
            if ($value != "") $params->rss_disabled = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $value;
          }

          // собираем параметры фильтра (не для экспорта)
          if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT])) {
            $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT]);
            if ($value != "") $params->export_disabled = $value;
            $inputs[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $value;
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

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды,
            // устанавливаем заголовок страницы
            $this->process_setup();
            $this->process();
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Категории товаров';

            // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $this->collect_inputs($inputs, $params, SORT_CATEGORIES_MODE_AS_IS, CATEGORIES_SORT_SESSION_PARAM_NAME);

            // читаем список категорий согласно параметрам фильтра и сортировки
            $params->mode = GET_CATEGORIES_MODE_WITH_MISSING_BRANCHES;
            $count = $this->db->categories->get($items, $params);  // вызов метода fix_categories_records не требуется

            // передаем в шаблонизатор количество прочитанных элементов
            $this->smarty->assignByRef(SMARTY_VAR_TOTAL_ITEMS, $count);

            // добавляем в записи категорий оперативные ссылки админпанели
            $params->token = $this->token;
            $this->db->operable_categories($items, $params);

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_CATEGORIES_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }




    // =========================================================================
    // Класс Category (админ модуль страницы категории)
    // =========================================================================

    class Category extends Categories {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_CATEGORY_CLASS_RESULT_PAGE;



        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('categories',
                                      'all_users',
                                      'menus');



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
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if (!empty($result_page)) {
                $this->result_page = $result_page;
                $this->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды
            $this->process_setup();
            $this->process();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

            // устанавливаем заголовок страницы,
            // если нет данных категории или они изменились,
            //   читаем их из базы данных
            $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новая категория";
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->get_category($this->item, $params);
            }

            // если данные категории получены,
            //   меняем заголовок страницы,
            //   выправляем текст описания категории согласно настройкам сайта
            if (!empty($this->item)) {
                $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование категории \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
                if ($this->settings->categories_wysiwyg_disabled == 1) {
                    if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->categories_wysiwyg_disabled_mode);
                    if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->categories_wysiwyg_disabled_mode);
                }
                // преобразуем поле in_prices (в каких прайсах используется) в массив
                if (isset($this->item->in_prices)) {
                    $n = array();
                    for ($i = 0; $i <= 7; $i++) $n[] = ($this->item->in_prices >> $i) & 1;
                    $this->item->in_prices = $n;
                }
                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_categories_record($this->item);
                // определяем есть ли вторичные прикрепления к категориям
                if (isset($this->item->parents)) {
                    array_shift($this->item->parents);
                    if (!empty($this->item->parents)) $this->item->use_parents = 1;
                }
            } else {
                // инициируем важные поля новой записи
                $this->item = new stdClass;
                $this->item->enabled = 1;
                $this->item->hidden = 0;
                $this->item->browsed = 0;
                $this->item->url_special = 0;
                $this->item->in_prices = array(1, 1, 1, 1, 1, 1, 1, 1);
                $this->item->section = 1;
            }

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_CATEGORY_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    // =========================================================================
    // Класс Brands (админ модуль списка брендов)
    // =========================================================================

    class Brands extends Categories {

        // с какой таблицей базы данных работаем,
        // какое поле таблицы является идентификатором записей
        public $dbtable = DATABASE_BRANDS_TABLENAME;
        public $dbtable_field = 'brand_id';



        // в какую папку выгружать изображения
        public $upload_folder = ADMIN_BRANDS_CLASS_UPLOAD_FOLDER;



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

            // добавляем префикс папки изображений
            $this->upload_folder = $this->settings->brands_files_folder_prefix . $this->upload_folder;
        }



        // обновление записи в базе данных =======================================

        protected function update ( & $item ) {

            // приказываем объекту базы данных обновить/добавить указанную запись
            return $this->db->brands->update($item);
        }



        // очистка соответствующих кеш-таблиц ====================================

        protected function resetCaches () {

            // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
            $this->db->reset_brands_caches();
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

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды,
            // устанавливаем заголовок страницы
            $this->process_setup();
            $this->process();
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Бренды';

            // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $this->collect_inputs($inputs, $params, SORT_BRANDS_MODE_AS_IS, BRANDS_SORT_SESSION_PARAM_NAME);

            // читаем список брендов согласно параметрам фильтра и сортировки
            $params->mode = GET_BRANDS_MODE_WITH_MISSING_BRANCHES;
            $count = $this->db->brands->get($items, $params);  // вызов метода fix_brands_records не требуется

            // передаем в шаблонизатор количество прочитанных элементов
            $this->smarty->assignByRef(SMARTY_VAR_TOTAL_ITEMS, $count);

            // добавляем в записи брендов оперативные ссылки админпанели
            $params->token = $this->token;
            $this->db->operable_brands($items, $params);

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
            $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_BRANDS_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    // =========================================================================
    // Класс Brand (админ модуль страницы бренда)
    // =========================================================================

    class Brand extends Brands {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_BRAND_CLASS_RESULT_PAGE;



        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('all_brands',
                                      'all_users',
                                      'menus');



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
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if (!empty($result_page)) {
                $this->result_page = $result_page;
                $this->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды
            $this->process_setup();
            $this->process();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

            // устанавливаем заголовок страницы,
            // если нет данных бренда или они изменились,
            //   читаем их из базы данных
            $this->title = ADMIN_PAGE_TITLE_PREFIX . "Новый бренд";
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->get_brand($this->item, $params);
            }

            // если данные бренда получены,
            //   меняем заголовок страницы,
            //   выправляем текст описания бренда согласно настройкам сайта
            if (!empty($this->item)) {
                $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование бренда \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
                if ($this->settings->brands_wysiwyg_disabled == 1) {
                    if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->brands_wysiwyg_disabled_mode);
                    if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->brands_wysiwyg_disabled_mode);
                }
                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_brands_record($this->item);
                // определяем есть ли вторичные прикрепления к брендам
                if (isset($this->item->parents)) {
                    array_shift($this->item->parents);
                    if (!empty($this->item->parents)) $this->item->use_parents = 1;
                }
            } else {
                // инициируем важные поля новой записи
                $this->item = new stdClass;
                $this->item->enabled = 1;
                $this->item->hidden = 0;
                $this->item->browsed = 0;
                $this->item->url_special = 0;
                $this->item->section = 1;
            }

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_BRAND_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    // =========================================================================
    // Класс Properties (админ модуль списка свойств товаров)
    // =========================================================================

    class Properties extends Basic {

        // с какой таблицей базы данных работаем,
        // какое поле таблицы является идентификатором записей
        public $dbtable = 'properties';
        public $dbtable_field = 'property_id';



        // рекомендуемая страница возврата после операции,
        // в какую папку выгружать файлы,
        // сколько записей размещать на странице
        public $result_page = '';
        public $upload_folder = ADMIN_PROPERTIES_CLASS_UPLOAD_FOLDER;
        protected $items_per_page = DEFAULT_VALUE_FOR_PROPERTIES_ON_PAGE_IN_ADMIN;



        // оперируемая запись
        protected $item = null;



        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('categories',
                                      'all_brands');



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

            // если получены данные об изменениях соответствующих настроек сайта
            if ($this->request->isPostedSetup()) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                $this->db->settings->saveFromPost('properties_sort_method', 'Свойств товаров - отображение - способ сортировки на стороне клиента');

                // очищаем соответствующие кеш-таблицы
                $this->resetCaches();
            }
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
          $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
          $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
          $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

          // если действительно передали идентификатор оперируемой записи
          if (!empty($id)) {

            // создаем пустой массив для запросов
            $query = array();

            // какую команду требовали сделать во входном параметре ACTION?
            switch ($act) {

              // если команду "Поднять выше"
              case ACTION_REQUEST_PARAM_VALUE_MOVEUP:
                  $this->action_move_up($id, $query);
                  break;

              // если команду "Опустить ниже"
              case ACTION_REQUEST_PARAM_VALUE_MOVEDOWN:
                  $this->action_move_down($id, $query);
                  break;

              // если команду "Поставить первым"
              case ACTION_REQUEST_PARAM_VALUE_MOVEFIRST:
                  $this->action_move_first($id, $query);
                  break;

              // если команду "Поставить последним"
              case ACTION_REQUEST_PARAM_VALUE_MOVELAST:
                  $this->action_move_last($id, $query);
                  break;

              // если команду "Удалить запись"
              case ACTION_REQUEST_PARAM_VALUE_DELETE:
                $this->action_delete($id, $query);
                $query[] = "DELETE FROM " . $this->dbtable . "_values "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "'";
                $query[] = "DELETE FROM " . $this->dbtable . "_categories "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "'";
                break;

              // если команду "Разрешить / запретить использование в товарах"
              case ACTION_REQUEST_PARAM_VALUE_INPRODUCT:
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET in_product = 1 - in_product "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;

              // если команду "Разрешить / запретить использование в фильтре"
              case ACTION_REQUEST_PARAM_VALUE_INFILTER:
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET in_filter = 1 - in_filter "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;

              // если команду "Разрешить / запретить использование в сравнении"
              case ACTION_REQUEST_PARAM_VALUE_INCOMPARE:
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET in_compare = 1 - in_compare "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;

              // если команду "Разрешить / запретить использование записи"
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
              foreach ($query as &$command) $this->db->query($command);
              if ($watching) $this->changed = $this->changed || ($this->db->affected_rows() > 0);
              if (empty($result_page)) $result_page = trim($this->result_page);
            }
          }

          // обрабатываем редакторские изменения в записях (битовый OR использован для гарантии выполнения метода posting() независимо от настроек препроцессора)
          $cancel = $this->posting($result_page) | $cancel;

          // если произошли изменения в базе данных, очищаем соответствующие кеш-таблицы
          if ($this->changed) $this->resetCaches();

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

            // цикл по измененным записям
            foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {
              $item_cancel = FALSE;
              $value = $this->dbtable_field;

              // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
              $this->item = null;
              // поле group (группа)
              if (isset($_POST['group'][$id])) $this->item->group = trim($_POST['group'][$id]);
              // поле name (название)
              $this->editor->processName($this->item, $id, $item_cancel);
              // поле in_product (разрешено ли использование в товарах)
              $this->item->in_product = isset($_POST['in_product'][$id]) ? (($_POST['in_product'][$id] == 1) ? 1 : 0) : 0;
              // поле in_filter (разрешено ли использование в фильтре)
              $this->item->in_filter = isset($_POST['in_filter'][$id]) ? (($_POST['in_filter'][$id] == 1) ? 1 : 0) : 0;
              // поле in_compare (разрешено ли использование в сравнении)
              $this->item->in_compare = isset($_POST['in_compare'][$id]) ? (($_POST['in_compare'][$id] == 1) ? 1 : 0) : 0;
              // поле enabled (разрешено ли использование записи)
              $this->item->enabled = isset($_POST['enabled'][$id]) ? (($_POST['enabled'][$id] == 1) ? 1 : 0) : 0;
              // поле options (варианты)
              $this->process_options($this->item, $id, $item_cancel);
              // поле categories (категории)
              $this->item->categories = isset($_POST['categories'][$id]) ? $_POST['categories'][$id] : array();
              // поле brands (бренды)
              $this->item->brands = isset($_POST['brands'][$id]) ? $_POST['brands'][$id] : array();
              // поле order_num (вес)
              if (isset($_POST['order_num'][$id])) $this->item->order_num = intval($_POST['order_num'][$id]);
              // поле идентификатора записи
              if (!empty($id) && !empty($this->item)) {
                // это не добавление новой записи, поэтому устанавливаем идентификатор записи
                $this->item->$value = $id;
              }
              // если ошибок нет (не включился признак отмены)
              if (!$item_cancel && !empty($this->item)) {
                // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы,
                // битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора)
                $this->item->indifferent_caches = TRUE;
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



        // обработка изменения поля OPTIONS записи ===============================

        private function process_options (&$item, $id, &$cancel) {
          if (isset($_POST["options"][$id])) {
            switch ($this->dbtable) {
              case "properties":
                $options = trim($_POST["options"][$id]);
                $options = str_replace("\t", " ", $options);
                $options = str_replace("\n", "\r", $options);
                $options = explode("\r", $options);
                $item->options = array();
                foreach ($options as &$option) {
                  $option = trim($option);
                  if (!empty($option)) $item->options[strtolower($option)] = $option;
                }
                if (empty($item->options)) $cancel = $this->push_error("Не указано ни одного возможного значения для такого свойства товара.");
                break;
            }
          }
        }



        // обновление записи в базе данных =======================================

        protected function update (&$item) {

            // приказываем объекту базы данных обновить/добавить указанную запись
            return $this->db->update_property($item);
        }



        // очистка соответствующих кеш-таблиц ====================================

        protected function resetCaches () {
        }



        // сбор параметров html-формы ============================================

        protected function collect_inputs (&$inputs, &$params, $default_sort, $session_param) {

            $inputs = array();
            $params = new stdClass;

            // собираем параметры сортировки
            $params->sort = $default_sort;
            if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT])) $_SESSION[$session_param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
            if (isset($_SESSION[$session_param])) $params->sort = intval($_SESSION[$session_param]);
            $inputs[REQUEST_PARAM_NAME_SORT] = $params->sort;

            // собираем параметры фильтра (категория)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY]);
                if ($value != "") $params->category_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $value;
            }

            // собираем параметры фильтра (бренд)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND]);
                if ($value != "") $params->brand_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_BRAND] = $value;
            }

            // собираем параметры фильтра (используется в товарах)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_INPRODUCT])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_INPRODUCT]);
                if ($value != "") $params->in_product = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_INPRODUCT] = $value;
            }

            // собираем параметры фильтра (используется в фильтре)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_INFILTER])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_INFILTER]);
                if ($value != "") $params->in_filter = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_INFILTER] = $value;
            }

            // собираем параметры фильтра (используется в сравнении)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_INCOMPARE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_INCOMPARE]);
                if ($value != "") $params->in_compare = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_INCOMPARE] = $value;
            }

            // собираем параметры фильтра (разрешен)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED]);
                if ($value != "") $params->enabled = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_ENABLED] = $value;
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

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды,
            // устанавливаем заголовок страницы
            $this->process_setup();
            $this->process();
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Свойства товаров';

            // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $this->collect_inputs($inputs, $params, SORT_PROPERTIES_MODE_BY_NAME, PROPERTIES_SORT_SESSION_PARAM_NAME);

            // читаем список свойств товаров на текущей странице согласно параметрам фильтра и сортировки
            $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            $params->start = $current_page * $this->items_per_page;
            $params->maxcount = $this->items_per_page;
            $count = $this->db->get_properties($items, $params);
            $this->db->fix_properties_records($items);

            // создаем контент листания страниц
            if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
            if (isset($params->category_id)) $this->params[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $params->category_id;
            if (isset($params->brand_id)) $this->params[REQUEST_PARAM_NAME_FILTER_BRAND] = $params->brand_id;
            if (isset($params->in_product)) $this->params[REQUEST_PARAM_NAME_FILTER_INPRODUCT] = $params->in_product;
            if (isset($params->in_filter)) $this->params[REQUEST_PARAM_NAME_FILTER_INFILTER] = $params->in_filter;
            if (isset($params->in_compare)) $this->params[REQUEST_PARAM_NAME_FILTER_INCOMPARE] = $params->in_compare;
            if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
            $pages_num = $count / $this->items_per_page;
            $navigator = new PagesNavigation($this);
            $navigator->make($pages_num, $count);

            // добавляем в записи свойств товаров оперативные ссылки админпанели
            $params->token = $this->token;
            $this->db->operable_properties($items, $params);

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_PROPERTIES_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    // =========================================================================
    // Класс Property (админ модуль страницы свойства товара)
    // =========================================================================

    class Property extends Properties {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_PROPERTY_CLASS_RESULT_PAGE;



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
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if (!empty($result_page)) {
                $this->result_page = $result_page;
                $this->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды
            $this->process_setup();
            $this->process();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

            // устанавливаем заголовок страницы,
            // если нет данных свойства товара или они изменились,
            //   читаем их из базы данных
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новое свойство товара';
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->get_property($this->item, $params);
            }

            // если данные свойства товара получены,
            //   меняем заголовок страницы,
            if (!empty($this->item)) {
                $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование свойства товара \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_properties_record($this->item);
            } else {
                // инициируем важные поля новой записи
                $this->item = new stdClass;
                $this->item->in_product = 1;
                $this->item->in_filter = 1;
                $this->item->in_compare = 0;
                $this->item->enabled = 1;
            }

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_PROPERTY_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    // =========================================================================
    // Класс Stocks (админ модуль списка складов)
    // =========================================================================

    class Stocks extends Categories {

        // с какой таблицей базы данных работаем,
        // какое поле таблицы является идентификатором записей
        public $dbtable = 'stocks';
        public $dbtable_field = 'stock_id';



        // в какую папку выгружать изображения,
        // сколько записей размещать на странице
        public $upload_folder = ADMIN_STOCKS_CLASS_UPLOAD_FOLDER;
        protected $items_per_page = DEFAULT_VALUE_FOR_STOCKS_ON_PAGE_IN_ADMIN;



        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array();



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

            // добавляем префикс папки изображений
            $this->upload_folder = $this->settings->stocks_files_folder_prefix . $this->upload_folder;
        }



        // обновление записи в базе данных =======================================

        protected function update ( & $item ) {

            // приказываем объекту базы данных обновить/добавить указанную запись
            return $this->db->stocks->update($item);
        }



        // очистка соответствующих кеш-таблиц ====================================

        protected function resetCaches () {
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

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды,
            // устанавливаем заголовок страницы
            $this->process_setup();
            $this->process();
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Склады';

            // читаем параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $inputs = null;
            $params = null;
            $this->collect_inputs($inputs, $params, SORT_STOCKS_MODE_BY_NAME, STOCKS_SORT_SESSION_PARAM_NAME);

            // читаем список складов на текущей странице согласно параметрам фильтра и сортировки
            $items = null;
            $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            $params->start = $current_page * $this->items_per_page;
            $params->maxcount = $this->items_per_page;
            $count = $this->db->stocks->get($items, $params);
            $this->db->stocks->unpackRecords($items);

            // создаем контент листания страниц
            if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
            if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
            if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
            if (isset($params->visible)) $this->params[REQUEST_PARAM_NAME_FILTER_VISIBLE] = $params->visible;
            if (isset($params->enable_debit)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLEDEBIT] = $params->enable_debit;
            if (isset($params->enable_credit)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLECREDIT] = $params->enable_credit;
            if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
            if (isset($params->objected)) $this->params[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $params->objected;
            if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
            $pages_num = $count / $this->items_per_page;
            $navigator = new PagesNavigation($this);
            $navigator->make($pages_num, $count);

            // добавляем в записи складов оперативные ссылки админпанели
            $params->token = $this->token;
            $this->db->stocks->operable($items, $params);

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_STOCKS_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    // =========================================================================
    // Класс Stock (админ модуль страницы склада)
    // =========================================================================

    class Stock extends Stocks {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_STOCK_CLASS_RESULT_PAGE;



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
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if (!empty($result_page)) {
                $this->result_page = $result_page;
                $this->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }

            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды
            $this->process_setup();
            $this->process();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

            // устанавливаем заголовок страницы,
            // если нет данных склада или они изменились,
            //   читаем их из базы данных
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый склад';
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->stocks->one($this->item, $params);
            }

            // если данные склада получены,
            //   меняем заголовок страницы,
            //   выправляем текст описания склада согласно настройкам сайта
            if (!empty($this->item)) {
                $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редактирование склада \"" . (isset($this->item->name) ? $this->item->name : "") . "\"";
                if ($this->settings->stocks_wysiwyg_disabled == 1) {
                    if (isset($this->item->annotation)) $this->item->annotation = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->annotation, $this->settings->stocks_wysiwyg_disabled_mode);
                    if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->stocks_wysiwyg_disabled_mode);
                    if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->stocks_wysiwyg_disabled_mode);
                }
                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->stocks->unpack($this->item);
            } else {
                // инициируем важные поля новой записи
                $this->item = new stdClass;
                $this->item->enabled = 1;
                $this->item->hidden = 0;
                $this->item->browsed = 0;
                $this->item->visible = 0;
                $this->item->enable_debit = 1;
                $this->item->enable_credit = 1;
            }

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_STOCK_CLASS_TEMPLATE_FILE);
        }
    }



    return;
?>