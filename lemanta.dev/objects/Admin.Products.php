<?php
  // Impera CMS: админ модуль списка товаров,
  //             админ модуль страницы товара,
  //             админ модуль списка комплектов товаров,
  //             админ модуль страницы комплекта товаров,
  //             админ модуль списка стадий заказа,
  //             админ модуль страницы стадии заказа,
  //             админ модуль истории платежей,
  //             админ модуль списка кредитных программ,
  //             админ модуль страницы кредитной программы,
  //             админ модуль списка способов доставки,
  //             админ модуль страницы способа доставки,
  //             админ модуль списка типов доставки,
  //             админ модуль страницы типа доставки,
  //             админ модуль списка сроков отправки,
  //             админ модуль страницы срока отправки,
  //             админ модуль списка валют,
  //             админ модуль страницы валюты,
  //             админ модуль списка способов оплаты,
  //             админ модуль страницы способа оплаты,
  //             админ модуль списка пользователей,
  //             админ модуль страницы пользователя,
  //             админ модуль списка стран,
  //             админ модуль страницы страны,
  //             админ модуль списка областей,
  //             админ модуль страницы области,
  //             админ модуль списка городов,
  //             админ модуль страницы города,
  //             админ модуль списка учебных заведений,
  //             админ модуль страницы учебного заведения,
  //             админ модуль списка типов учебных заведений,
  //             админ модуль страницы типа учебного заведения,
  //             админ модуль списка предметов учебных заведений,
  //             админ модуль страницы предмета учебного заведения,
  //             админ модуль списка классов учебных заведений,
  //             админ модуль страницы класса учебного заведения,
  //             админ модуль списка учащихся,
  //             админ модуль страницы учащегося.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined('ROOT_FOLDER_REFERENCE')) return;
  if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
  if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT);



    // подключаем константы модуля товаров (TODO: исправить на актуальное, когда константы будут разбросаны из свалочного Products по своим модулям)
    impera_ConstantsRequire('Products');



  // =========================================================================
  // Класс Products (админ модуль списка товаров)
  // =========================================================================

  class Products extends Basic {

    // имя файла шаблона или массив имен файлов
    protected $template = array('products/products.htm',
                                'admin_products.htm');

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_PRODUCTS_TABLENAME;
    public $dbtable_field = 'product_id';

    // рекомендуемая страница возврата после операции,
    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $result_page = '';
    public $upload_folder = ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_PRODUCTS_ON_PAGE_IN_ADMIN;

    // оперируемая запись
    protected $item = null;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('categories',
                                  'all_brands',
                                  'all_users',
                                  'menus',
                                  'stocks');



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений для товаров
        $this->upload_folder = $this->settings->products_files_folder_prefix . $this->upload_folder;
    }

    // обработка соответствующих модулю настроек сайта =======================

    protected function process_setup () {

      // если получены данные об изменениях соответствующих настроек сайта
      if (isset($_POST[REQUEST_PARAM_NAME_SETUP])) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        // с какой базой данных работаем?
        switch ($this->dbtable) {

          // если страны
          case 'countries':
            $name = 'countries_files_folder_prefix';
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace('/', ' ', $value);
              $value = str_replace('\\', ' ', $value);
              $value = str_replace(':', ' ', $value);
              while (strpos($value, '  ') !== FALSE) $value = str_replace('  ', ' ', $value);
              $value = str_replace(' ', '_', trim($value));
              $this->db->settings->save($name, $value, 'Страны - изображения - префикс папки с файлами изображений');
            $name = 'countries_images_quality';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, 'Страны - изображения - качество');
            $name = 'countries_images_width';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, 'Страны - изображения - предельная ширина');
            $name = 'countries_images_height';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, 'Страны - изображения - предельная высота');
            $name = 'countries_thumbnail_width';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, 'Страны - миниатюры - предельная ширина');
            $name = 'countries_thumbnail_height';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, 'Страны - миниатюры - предельная высота');
            $name = 'countries_watermark_transparency';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, 'Страны - водяной знак - процент видимости на картинке');
            $this->db->settings->saveFromPost('countries_images_exactly',        'Страны - изображения - подгонять ли размеры картинок, меньших предельных размеров');
            $this->db->settings->saveFromPost('countries_watermark_enabled',     'Страны - водяной знак - разрешено ли накладывать на картинку');
            $this->db->settings->saveFromPost('countries_watermark_location',    'Страны - водяной знак - расположение');
            $this->db->settings->saveFromPost('countries_wysiwyg_disabled',      'Страны - редактирование - запрещен ли визуальный редактор');
            $this->db->settings->saveFromPost('countries_wysiwyg_disabled_mode', 'Страны - редактирование - режим обработки текста при отключенном визуальном редакторе');
            $this->db->settings->saveFromPost('countries_meta_autofill',         'Страны - редактирование - заполнять ли пустые поля мета информации автоматически');
            $this->db->settings->saveFromPost('countries_sort_method',           'Страны - отображение - способ сортировки на стороне клиента');
            $this->db->settings->saveFromPost('countries_main_title',            'Страны - отображение - оглавление списка на стороне клиента');
            $this->db->settings->saveFromPost('countries_main_path',             'Страны - отображение - путевое название списка в навигаторе на стороне клиента');
            $this->db->settings->saveFromPost('countries_main_keywords',         'Страны - отображение - ключевые мета слова списка на стороне клиента');
            $this->db->settings->saveFromPost('countries_main_description',      'Страны - отображение - мета описание списка на стороне клиента');
            $name = 'countries_num';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM) $value = SETTINGS_MINIMAL_ITEMS_NUM;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM) $value = SETTINGS_MAXIMAL_ITEMS_NUM;
              $this->db->settings->save($name, $value, 'Страны - отображение - число записей в списке на стороне клиента');
            $name = 'countries_num_admin';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
              $this->db->settings->save($name, $value, 'Страны - отображение - число записей на странице админпанели');
            $upload_folder = $this->settings->countries_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = COUNTRIES_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если способы доставки
          case 'delivery_methods':
            $this->db->settings->saveFromPost('deliveries_wysiwyg_disabled',      'Способы доставки - редактирование - запрещен ли визуальный редактор');
            $this->db->settings->saveFromPost('deliveries_wysiwyg_disabled_mode', 'Способы доставки - редактирование - режим обработки текста при отключенном визуальном редакторе');
            $this->db->settings->saveFromPost('deliveries_sort_method',           'Способы доставки - отображение - способ сортировки на стороне клиента');
            $name = 'deliveries_num_admin';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
              $this->db->settings->save($name, $value, 'Способы доставки - отображение - число записей на странице админпанели');

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если типы доставки
          case 'deliveries_types':
            break;

          // если сроки отправки
          case 'shippings_terms':
            break;

          // если валюты
          case 'currencies':
            break;

          // если способы оплаты
          case 'payment_methods':
            $this->db->settings->saveFromPost('payments_wysiwyg_disabled',      'Способы оплаты - редактирование - запрещен ли визуальный редактор');
            $this->db->settings->saveFromPost('payments_wysiwyg_disabled_mode', 'Способы оплаты - редактирование - режим обработки текста при отключенном визуальном редакторе');
            $this->db->settings->saveFromPost('payments_sort_method',           'Способы оплаты - отображение - способ сортировки на стороне клиента');
            $name = 'payments_num_admin';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
              $this->db->settings->save($name, $value, 'Способы оплаты - отображение - число записей на странице админпанели');

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если заказы
          case DATABASE_ORDERS_TABLENAME:
            $rate_to = isset($this->currency->rate_to) && ($this->currency->rate_to != 0) ? abs($this->currency->rate_to) : 1;
            $rate_from = isset($this->currency->rate_from) && ($this->currency->rate_from != 0) ? abs($this->currency->rate_from) : 1;

            $name = 'orders_minimal_sum';
              $value = isset($_POST[$name]) ? round($this->number->floatValue($_POST[$name]), 2) : 0;
              if ($value < 0) $value = 0;
              if ($value > 100000000) $value = 100000000;
              $value = round($value * $rate_to / $rate_from, 2);
              $this->db->settings->save($name, $value, 'Заказы - разное - минимальная сумма заказа');
            $this->db->settings->saveFromPost('orders_edit_mode',  'Заказы - разное - режим редактирования списка товаров');

            $name = 'orders_attach_receipt';
              $value = (isset($_POST[$name]) && ($_POST[$name] == 1)) ? 1 : 0;
              $this->db->settings->save($name, $value, 'Заказы - разное - прикреплять ли в уведомление покупателю квитанцию на оплату через банк');

            $name = 'orders_non_touch_quantity';
              $value = (isset($_POST[$name]) && ($_POST[$name] == 1)) ? 1 : 0;
              $this->db->settings->save($name, $value, 'Заказы - разное - виртуальное списание товара (не менять его количество на складе)');

            $name = 'orders_deficit_enabled';
              $value = (isset($_POST[$name]) && ($_POST[$name] == 1)) ? 1 : 0;
              $this->db->settings->save($name, $value, 'Заказы - разное - разрешено ли оформлять заказ с товаром, когда на складе есть только часть');

            $name = 'orders_auto_export';
                $value = isset($_POST[$name]) && $_POST[$name] ? 1 : 0;
                $this->db->settings->save($name, $value, 'Заказы - экспорт - включен ли авто экспорт новых заказов');

                $enabled = $value;

            $name = 'orders_auto_export_format';
                $value = isset($_POST[$name]) && $_POST[$name] ? strtolower(trim($_POST[$name])) : '';
                if ($value != 'xml') $value = 'xml';
                $this->db->settings->save($name, $value, 'Заказы - экспорт - формат авто экспорта');

                $format = $value;

            $name = 'orders_auto_export_file';
                $prev = $this->hdd->safeFilename($this->settings->$name);

                $value = isset($_POST[$name]) && $_POST[$name] ? $this->hdd->safeFilename($_POST[$name]) : '';
                $this->db->settings->save($name, $value, 'Заказы - экспорт - имя файла авто экспорта');

                // гарантируем присутствие папки
                $path = ROOT_FOLDER_REFERENCE . 'export';
                $this->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_ANY_NONEXECUTED);

                // если имя файла изменилось
                if ($prev != $value) {
                    // если файл появляется
                    if ($value != '') {
                        $file = $path . '/' . $value;
                        if (is_file($file)) @ unlink($file);
                        // создаем файл
                        if ($enabled) {
                            switch ($format) {
                                case 'xml':
                                    $this->db->orders->xml->exportFile($file, '');
                                    break;
                            }
                        }
                    }
                    // если был старый файл
                    if ($prev != '') {
                        $prev = $path . '/' . $prev;
                        if (is_file($prev)) @ unlink($prev);
                    }
                }

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если стадии заказа
          case DATABASE_ORDERS_PHASES_TABLENAME:
            break;

          // если кредитные программы
          case DATABASE_CREDIT_PROGRAMS_TABLENAME:
            break;

          // если товары
          case DATABASE_PRODUCTS_TABLENAME:
            $name = 'products_files_folder_prefix';
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace('/', ' ', $value);
              $value = str_replace('\\', ' ', $value);
              $value = str_replace(':', ' ', $value);
              while (strpos($value, '  ') !== FALSE) $value = str_replace('  ', ' ', $value);
              $value = str_replace(' ', '_', trim($value));
              $this->db->settings->save($name, $value, 'Товары - изображения - префикс папки с файлами изображений');
            $name = 'products_images_quality';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, 'Товары - изображения - качество');
            $name = 'products_images_width';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, 'Товары - изображения - предельная ширина');
            $name = 'products_images_height';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, 'Товары - изображения - предельная высота');
            $name = 'products_thumbnail_width';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, 'Товары - миниатюры - предельная ширина');
            $name = 'products_thumbnail_height';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, 'Товары - миниатюры - предельная высота');
            $name = 'products_watermark_transparency';
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, 'Товары - водяной знак - процент видимости на картинке');
            $this->db->settings->saveFromPost('products_images_exactly',         'Товары - изображения - подгонять ли размеры картинок, меньших предельных размеров');
            $this->db->settings->saveFromPost('products_watermark_enabled',      'Товары - водяной знак - разрешено ли накладывать на картинку');
            $this->db->settings->saveFromPost('products_watermark_location',     'Товары - водяной знак - расположение');
            $this->db->settings->saveFromPost('products_wysiwyg_disabled',       'Товары - редактирование - запрещен ли визуальный редактор');
            $this->db->settings->saveFromPost('products_wysiwyg_disabled_mode',  'Товары - редактирование - режим обработки текста при отключенном визуальном редакторе');
            $this->db->settings->saveFromPost('products_meta_autofill',          'Товары - редактирование - заполнять ли пустые поля мета информации автоматически');
            $this->db->settings->saveFromPost('products_sort_method',            'Товары - отображение - способ сортировки на стороне клиента');
            $this->db->settings->saveFromPost('products_sort_direction',         'Товары - отображение - направление сортировки на стороне клиента');
            $this->db->settings->saveFromPost('products_sort_laconical',         'Товары - отображение - лаконичность сортировки на стороне клиента');
            $this->db->settings->saveFromPost('products_hit_title',              "Товары - отображение - оглавление списка \"Хиты продаж\" на стороне клиента");
            $this->db->settings->saveFromPost("products_hit_path",               "Товары - отображение - путевое название списка \"Хиты продаж\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("products_hit_keywords",           "Товары - отображение - ключевые слова списка \"Хиты продаж\"");
            $this->db->settings->saveFromPost("products_hit_description",        "Товары - отображение - мета описание списка \"Хиты продаж\"");
            $this->db->settings->saveFromPost("products_hit_maxcount",           "Товары - отображение - длина списка \"Хиты продаж\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_main_hit_enabled",       "Товары - отображение - виден ли список \"Хиты продаж\" на главной странице");
            $this->db->settings->saveFromPost("products_hit_enabled",            "Товары - отображение - виден ли список \"Хиты продаж\" на странице товара");
            $this->db->settings->saveFromPost("products_hit_random",             "Товары - отображение - перемешать ли случайно список \"Хиты продаж\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_newest_title",           "Товары - отображение - оглавление списка \"Новые поступления\" на стороне клиента");
            $this->db->settings->saveFromPost("products_newest_path",            "Товары - отображение - путевое название списка \"Новые поступления\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("products_newest_keywords",        "Товары - отображение - ключевые слова списка \"Новые поступления\"");
            $this->db->settings->saveFromPost("products_newest_description",     "Товары - отображение - мета описание списка \"Новые поступления\"");
            $this->db->settings->saveFromPost("products_newest_maxcount",        "Товары - отображение - длина списка \"Новые поступления\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_main_newest_enabled",    "Товары - отображение - виден ли список \"Новые поступления\" на главной странице");
            $this->db->settings->saveFromPost("products_newest_enabled",         "Товары - отображение - виден ли список \"Новые поступления\" на странице товара");
            $this->db->settings->saveFromPost("products_newest_random",          "Товары - отображение - перемешать ли случайно список \"Новые поступления\", когда выводится в виде блока");
            $name = 'products_newest_days';
                $value = isset($_POST[$name]) ? intval($_POST[$name]) : 0;
                $value = max(0, $value);
                $this->db->settings->save($name, $value, 'Товары - отображение - число последних дней, добавленные товары которых подмешивать в список новинок');
            $this->db->settings->saveFromPost("products_actional_title",         "Товары - отображение - оглавление списка \"Акционные\" на стороне клиента");
            $this->db->settings->saveFromPost("products_actional_path",          "Товары - отображение - путевое название списка \"Акционные\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("products_actional_keywords",      "Товары - отображение - ключевые слова списка \"Акционные\"");
            $this->db->settings->saveFromPost("products_actional_description",   "Товары - отображение - мета описание списка \"Акционные\"");
            $this->db->settings->saveFromPost("products_actional_maxcount",      "Товары - отображение - длина списка \"Акционные\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_main_actional_enabled",  "Товары - отображение - виден ли список \"Акционные\" на главной странице");
            $this->db->settings->saveFromPost("products_actional_enabled",       "Товары - отображение - виден ли список \"Акционные\" на странице товара");
            $this->db->settings->saveFromPost("products_actional_random",        "Товары - отображение - перемешать ли случайно список \"Акционные\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_awaited_title",          "Товары - отображение - оглавление списка \"Скоро в продаже\" на стороне клиента");
            $this->db->settings->saveFromPost("products_awaited_path",           "Товары - отображение - путевое название списка \"Скоро в продаже\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("products_awaited_keywords",       "Товары - отображение - ключевые слова списка \"Скоро в продаже\"");
            $this->db->settings->saveFromPost("products_awaited_description",    "Товары - отображение - мета описание списка \"Скоро в продаже\"");
            $this->db->settings->saveFromPost("products_awaited_maxcount",       "Товары - отображение - длина списка \"Скоро в продаже\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_main_awaited_enabled",   "Товары - отображение - виден ли список \"Скоро в продаже\" на главной странице");
            $this->db->settings->saveFromPost("products_awaited_enabled",        "Товары - отображение - виден ли список \"Скоро в продаже\" на странице товара");
            $this->db->settings->saveFromPost("products_awaited_random",         "Товары - отображение - перемешать ли случайно список \"Скоро в продаже\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_ordered_title",          "Товары - отображение - оглавление списка \"Недавно покупали\" на стороне клиента");
            $this->db->settings->saveFromPost("products_ordered_path",           "Товары - отображение - путевое название списка \"Недавно покупали\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("products_ordered_keywords",       "Товары - отображение - ключевые слова списка \"Недавно покупали\"");
            $this->db->settings->saveFromPost("products_ordered_description",    "Товары - отображение - мета описание списка \"Недавно покупали\"");
            $this->db->settings->saveFromPost("products_ordered_maxcount",       "Товары - отображение - длина списка \"Недавно покупали\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_main_ordered_enabled",   "Товары - отображение - виден ли список \"Недавно покупали\" на главной странице");
            $this->db->settings->saveFromPost("products_ordered_enabled",        "Товары - отображение - виден ли список \"Недавно покупали\" на странице товара");
            $this->db->settings->saveFromPost("products_ordered_random",         "Товары - отображение - перемешать ли случайно список \"Недавно покупали\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_commented_title",        "Товары - отображение - оглавление списка \"Недавно обсуждали\" на стороне клиента");
            $this->db->settings->saveFromPost("products_commented_path",         "Товары - отображение - путевое название списка \"Недавно обсуждали\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("products_commented_keywords",     "Товары - отображение - ключевые слова списка \"Недавно обсуждали\"");
            $this->db->settings->saveFromPost("products_commented_description",  "Товары - отображение - мета описание списка \"Недавно обсуждали\"");
            $this->db->settings->saveFromPost("products_commented_maxcount",     "Товары - отображение - длина списка \"Недавно обсуждали\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_main_commented_enabled", "Товары - отображение - виден ли список \"Недавно обсуждали\" на главной странице");
            $this->db->settings->saveFromPost("products_commented_enabled",      "Товары - отображение - виден ли список \"Недавно обсуждали\" на странице товара");
            $this->db->settings->saveFromPost("products_commented_random",       "Товары - отображение - перемешать ли случайно список \"Недавно обсуждали\", когда выводится в виде блока");
            $this->db->settings->saveFromPost("products_comments_title",         "Товары - отзывы - заголовок блока отзывов на товар");
            $name = "products_comment_next_time";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_COMMENTS_NEXTTIME;
              if ($value < SETTINGS_MINIMAL_COMMENTS_NEXTTIME) $value = SETTINGS_MINIMAL_COMMENTS_NEXTTIME;
              if ($value > SETTINGS_MAXIMAL_COMMENTS_NEXTTIME) $value = SETTINGS_MAXIMAL_COMMENTS_NEXTTIME;
              $this->db->settings->save($name, $value, "Товары - отзывы - антиспам пауза между отзывами");
            $name = "products_comment_moderation";
              $value = (isset($_POST[$name]) && ($_POST[$name] == 1)) ? 1 : 0;
              $this->db->settings->save($name, $value, "Товары - отзывы - включить ли модерацию отзывов");
            $name = "products_num";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_PRODUCTS_NUM;
              if ($value < SETTINGS_MINIMAL_PRODUCTS_NUM) $value = SETTINGS_MINIMAL_PRODUCTS_NUM;
              if ($value > SETTINGS_MAXIMAL_PRODUCTS_NUM) $value = SETTINGS_MAXIMAL_PRODUCTS_NUM;
              $this->db->settings->save($name, $value, "Товары - отображение - число записей в списке на стороне клиента");
            $name = "products_num_admin";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_PRODUCTS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_PRODUCTS_NUM_ADMIN) $value = SETTINGS_MINIMAL_PRODUCTS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_PRODUCTS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_PRODUCTS_NUM_ADMIN;
              $this->db->settings->save($name, $value, "Товары - отображение - число записей на странице админпанели");
            $upload_folder = $this->settings->products_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = PRODUCTS_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если комплекты товаров
          case "products_kits":
            $this->db->settings->saveFromPost("productskits_wysiwyg_disabled",      "Комплекты товаров - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("productskits_wysiwyg_disabled_mode", "Комплекты товаров - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("productskits_meta_autofill",         "Комплекты товаров - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("productskits_sort_method",           "Комплекты товаров - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("productskits_title",                 "Комплекты товаров - отображение - оглавление списка \"Комплекты товаров\" на стороне клиента");
            $this->db->settings->saveFromPost("productskits_path",                  "Комплекты товаров - отображение - путевое название списка \"Комплекты товаров\" в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("productskits_keywords",              "Комплекты товаров - отображение - ключевые слова списка \"Комплекты товаров\"");
            $this->db->settings->saveFromPost("productskits_description",           "Комплекты товаров - отображение - мета описание списка \"Комплекты товаров\"");
            $name = "productskits_num";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_PRODUCTS_NUM;
              if ($value < SETTINGS_MINIMAL_PRODUCTS_NUM) $value = SETTINGS_MINIMAL_PRODUCTS_NUM;
              if ($value > SETTINGS_MAXIMAL_PRODUCTS_NUM) $value = SETTINGS_MAXIMAL_PRODUCTS_NUM;
              $this->db->settings->save($name, $value, "Комплекты товаров - отображение - число записей в списке на стороне клиента");
            $name = "productskits_num_admin";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_PRODUCTS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_PRODUCTS_NUM_ADMIN) $value = SETTINGS_MINIMAL_PRODUCTS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_PRODUCTS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_PRODUCTS_NUM_ADMIN;
              $this->db->settings->save($name, $value, "Комплекты товаров - отображение - число записей на странице админпанели");

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если области
          case "regions":
            $name = "regions_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Области - изображения - префикс папки с файлами изображений");
            $name = "regions_images_quality";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, "Области - изображения - качество");
            $name = "regions_images_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, "Области - изображения - предельная ширина");
            $name = "regions_images_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, "Области - изображения - предельная высота");
            $name = "regions_thumbnail_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, "Области - миниатюры - предельная ширина");
            $name = "regions_thumbnail_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, "Области - миниатюры - предельная высота");
            $name = "regions_watermark_transparency";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, "Области - водяной знак - процент видимости на картинке");
            $this->db->settings->saveFromPost("regions_images_exactly",        "Области - изображения - подгонять ли размеры картинок, меньших предельных размеров");
            $this->db->settings->saveFromPost("regions_watermark_enabled",     "Области - водяной знак - разрешено ли накладывать на картинку");
            $this->db->settings->saveFromPost("regions_watermark_location",    "Области - водяной знак - расположение");
            $this->db->settings->saveFromPost("regions_wysiwyg_disabled",      "Области - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("regions_wysiwyg_disabled_mode", "Области - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("regions_meta_autofill",         "Области - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("regions_sort_method",           "Области - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("regions_main_title",            "Области - отображение - оглавление списка на стороне клиента");
            $this->db->settings->saveFromPost("regions_main_path",             "Области - отображение - путевое название списка в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("regions_main_keywords",         "Области - отображение - ключевые мета слова списка на стороне клиента");
            $this->db->settings->saveFromPost("regions_main_description",      "Области - отображение - мета описание списка на стороне клиента");
            $name = "regions_num";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM) $value = SETTINGS_MINIMAL_ITEMS_NUM;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM) $value = SETTINGS_MAXIMAL_ITEMS_NUM;
              $this->db->settings->save($name, $value, "Области - отображение - число записей в списке на стороне клиента");
            $name = "regions_num_admin";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
              $this->db->settings->save($name, $value, "Области - отображение - число записей на странице админпанели");
            $upload_folder = $this->settings->regions_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = REGIONS_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если учебные заведения
          case "schools":
            $name = "schools_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Учебные заведения - изображения - префикс папки с файлами изображений");
            $name = "schools_images_quality";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, "Учебные заведения - изображения - качество");
            $name = "schools_images_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, "Учебные заведения - изображения - предельная ширина");
            $name = "schools_images_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, "Учебные заведения - изображения - предельная высота");
            $name = "schools_thumbnail_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, "Учебные заведения - миниатюры - предельная ширина");
            $name = "schools_thumbnail_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, "Учебные заведения - миниатюры - предельная высота");
            $name = "schools_watermark_transparency";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, "Учебные заведения - водяной знак - процент видимости на картинке");
            $this->db->settings->saveFromPost("schools_images_exactly",        "Учебные заведения - изображения - подгонять ли размеры картинок, меньших предельных размеров");
            $this->db->settings->saveFromPost("schools_watermark_enabled",     "Учебные заведения - водяной знак - разрешено ли накладывать на картинку");
            $this->db->settings->saveFromPost("schools_watermark_location",    "Учебные заведения - водяной знак - расположение");
            $this->db->settings->saveFromPost("schools_wysiwyg_disabled",      "Учебные заведения - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("schools_wysiwyg_disabled_mode", "Учебные заведения - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("schools_meta_autofill",         "Учебные заведения - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("schools_sort_method",           "Учебные заведения - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("schools_main_title",            "Учебные заведения - отображение - оглавление списка на стороне клиента");
            $this->db->settings->saveFromPost("schools_main_path",             "Учебные заведения - отображение - путевое название списка в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("schools_main_keywords",         "Учебные заведения - отображение - ключевые мета слова списка на стороне клиента");
            $this->db->settings->saveFromPost("schools_main_description",      "Учебные заведения - отображение - мета описание списка на стороне клиента");
            $name = "schools_num";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM) $value = SETTINGS_MINIMAL_ITEMS_NUM;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM) $value = SETTINGS_MAXIMAL_ITEMS_NUM;
              $this->db->settings->save($name, $value, "Учебные заведения - отображение - число записей в списке на стороне клиента");
            $name = "schools_num_admin";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
              $this->db->settings->save($name, $value, "Учебные заведения - отображение - число записей на странице админпанели");
            $upload_folder = $this->settings->schools_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = SCHOOLS_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;

          // если типы учебных заведений
          case "schools_types":
            break;

          // если предметы учебных заведений
          case "schools_lessons":
            break;

          // если классы учебных заведений
          case "schools_classes":
            break;

          // если города
          case "towns":
            $name = "towns_files_folder_prefix";
              $value = isset($_POST[$name]) ? trim($_POST[$name]) : SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
              $value = str_replace("/", " ", $value);
              $value = str_replace("\\", " ", $value);
              $value = str_replace(":", " ", $value);
              while (strpos($value, "  ") !== FALSE) $value = str_replace("  ", " ", $value);
              $value = str_replace(" ", "_", trim($value));
              $this->db->settings->save($name, $value, "Города - изображения - префикс папки с файлами изображений");
            $name = "towns_images_quality";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_QUALITY;
              if ($value < SETTINGS_MINIMAL_IMAGES_QUALITY) $value = SETTINGS_MINIMAL_IMAGES_QUALITY;
              if ($value > SETTINGS_MAXIMAL_IMAGES_QUALITY) $value = SETTINGS_MAXIMAL_IMAGES_QUALITY;
              $this->db->settings->save($name, $value, "Города - изображения - качество");
            $name = "towns_images_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_WIDTH;
              if ($value < SETTINGS_MINIMAL_IMAGES_WIDTH) $value = SETTINGS_MINIMAL_IMAGES_WIDTH;
              if ($value > SETTINGS_MAXIMAL_IMAGES_WIDTH) $value = SETTINGS_MAXIMAL_IMAGES_WIDTH;
              $this->db->settings->save($name, $value, "Города - изображения - предельная ширина");
            $name = "towns_images_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_IMAGES_HEIGHT;
              if ($value < SETTINGS_MINIMAL_IMAGES_HEIGHT) $value = SETTINGS_MINIMAL_IMAGES_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_IMAGES_HEIGHT) $value = SETTINGS_MAXIMAL_IMAGES_HEIGHT;
              $this->db->settings->save($name, $value, "Города - изображения - предельная высота");
            $name = "towns_thumbnail_width";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MINIMAL_THUMBNAIL_WIDTH;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_WIDTH) $value = SETTINGS_MAXIMAL_THUMBNAIL_WIDTH;
              $this->db->settings->save($name, $value, "Города - миниатюры - предельная ширина");
            $name = "towns_thumbnail_height";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
              if ($value < SETTINGS_MINIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MINIMAL_THUMBNAIL_HEIGHT;
              if ($value > SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT) $value = SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT;
              $this->db->settings->save($name, $value, "Города - миниатюры - предельная высота");
            $name = "towns_watermark_transparency";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
              if ($value < SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
              if ($value > SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY) $value = SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY;
              $this->db->settings->save($name, $value, "Города - водяной знак - процент видимости на картинке");
            $this->db->settings->saveFromPost("towns_images_exactly",        "Города - изображения - подгонять ли размеры картинок, меньших предельных размеров");
            $this->db->settings->saveFromPost("towns_watermark_enabled",     "Города - водяной знак - разрешено ли накладывать на картинку");
            $this->db->settings->saveFromPost("towns_watermark_location",    "Города - водяной знак - расположение");
            $this->db->settings->saveFromPost("towns_wysiwyg_disabled",      "Города - редактирование - запрещен ли визуальный редактор");
            $this->db->settings->saveFromPost("towns_wysiwyg_disabled_mode", "Города - редактирование - режим обработки текста при отключенном визуальном редакторе");
            $this->db->settings->saveFromPost("towns_meta_autofill",         "Города - редактирование - заполнять ли пустые поля мета информации автоматически");
            $this->db->settings->saveFromPost("towns_sort_method",           "Города - отображение - способ сортировки на стороне клиента");
            $this->db->settings->saveFromPost("towns_main_title",            "Города - отображение - оглавление списка на стороне клиента");
            $this->db->settings->saveFromPost("towns_main_path",             "Города - отображение - путевое название списка в навигаторе на стороне клиента");
            $this->db->settings->saveFromPost("towns_main_keywords",         "Города - отображение - ключевые мета слова списка на стороне клиента");
            $this->db->settings->saveFromPost("towns_main_description",      "Города - отображение - мета описание списка на стороне клиента");
            $name = "towns_num";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM) $value = SETTINGS_MINIMAL_ITEMS_NUM;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM) $value = SETTINGS_MAXIMAL_ITEMS_NUM;
              $this->db->settings->save($name, $value, "Города - отображение - число записей в списке на стороне клиента");
            $name = "towns_num_admin";
              $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
              if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
              if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
              $this->db->settings->save($name, $value, "Города - отображение - число записей на странице админпанели");
            $upload_folder = $this->settings->towns_files_folder_prefix . ADMIN_IMAGES_FOLDER_REFERENCE;
            $upload_url = TOWNS_CLASS_WATERMARK_FILENAME;

            // очищаем соответствующие кеш-таблицы
            $this->resetCaches();
            break;
        }

        // может пытались загрузить изображение водяного знака?
        if (isset($upload_url)) $this->editor->processWatermark($upload_folder, $upload_url);
      }
    }

    // обработка входных параметров и команд =================================

    protected function process (&$defaults = '') {

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

      // если команда не задана, но есть пометки удаляемых изображений, считаем что была команда "Удалить изображение"
      if (!empty($id) && ($act == '')) {
        if (isset($_POST['imagedelete'][$id]) && is_array($_POST['imagedelete'][$id])) {
          foreach ($_POST['imagedelete'][$id] as $index => $item) {
            if ($item == 1) {
              $act = ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE;
              break;
            }
          }
        }
      }

      // если получена команда дислокатора
      if ((isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE]) && is_array($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE]))
      || (isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE_FILTER]) && is_array($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE_FILTER]))) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        // берем сведения дислокатора
        $id = null;
        $ids = isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE]) ? $_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE] : null;
        if (is_null($ids)) $ids = isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE_FILTER]) ? $_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE_FILTER] : null;
        if (!is_null($ids)) foreach ($ids as $id => $to) break;
        if (is_null($id)) {
          $cancel = $this->push_error('Не получены данные переноса записей!');
        } else {

          // берем сведения куда перенести записи
          if (!isset($_POST[REQUEST_PARAM_NAME_DISLOCATE_TO]) || !is_array($_POST[REQUEST_PARAM_NAME_DISLOCATE_TO]) || !isset($_POST[REQUEST_PARAM_NAME_DISLOCATE_TO][$id])) {
            $cancel = $this->push_error('Не получены сведения куда переносить записи!');
          } else {
            $to = trim($_POST[REQUEST_PARAM_NAME_DISLOCATE_TO][$id]);
            if (!is_numeric($to)) {
              $cancel = $this->push_error('Вы не выбрали куда переносить записи!');
            } else {

              // берем сведения какие записи перенести
              $id = isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE]) ? (isset($_POST[REQUEST_PARAM_NAME_DISLOCATE_ID]) && is_array($_POST[REQUEST_PARAM_NAME_DISLOCATE_ID]) && isset($_POST[REQUEST_PARAM_NAME_DISLOCATE_ID][$id]) && (trim($_POST[REQUEST_PARAM_NAME_DISLOCATE_ID][$id]) != '') ? trim($_POST[REQUEST_PARAM_NAME_DISLOCATE_ID][$id]) : null) : '';
              if (is_null($id)) {
                $cancel = $this->push_error('Не получены сведения какие записи переносить!');
              } else {

                // создаем пустой массив для запросов
                $query = array();

                // переносим записи
                if ($id == '') {
                  $cancel = $this->push_error('К сожалению, такой тип переноса пока не поддерживается в этой версии системы!');
                } else {

                  switch ($this->dbtable) {
                    case DATABASE_USERS_TABLENAME:
                      $query[] = 'UPDATE ' . $this->dbtable . ' '
                               . 'SET group_id = \'' . $this->db->query_value($to) . '\' '
                               . 'WHERE group_id = \'' . $this->db->query_value($id) . '\';';
                      break;
                  }

                }

                // если получен набор запросов,
                //   делаем все запросы операции,
                //   если для команды не снято отслеживание изменений в базе данных, делаем его оценкой затронутых записей
                if (!empty($query)) {
                  foreach ($query as &$command) $this->db->query($command);
                  if ($watching) $this->changed = $this->changed || ($this->db->affected_rows() > 0);
                }
              }
            }
          }
        }
      }

      // если действительно передали идентификатор оперируемой записи или это команда "Удалить помеченные записи"
      if (!empty($id) || ($act == ACTION_REQUEST_PARAM_VALUE_MASSDELETE)) {

        // создаем пустой массив для запросов
        $query = array();

        // какую команду требовали сделать во входном параметре ACTION?
        switch ($act) {

          // если команду "Разрешить / запретить показ записи" (она не для таблиц deliveries_types, shippings_terms, orders, orders_phases, schools_* базы данных)
          case ACTION_REQUEST_PARAM_VALUE_ENABLED:
            if (($this->dbtable != 'deliveries_types')
            && ($this->dbtable != 'shippings_terms')
            && ($this->dbtable != DATABASE_ORDERS_TABLENAME)
            && ($this->dbtable != DATABASE_ORDERS_PHASES_TABLENAME)
            && ($this->dbtable != 'schools_types')
            && ($this->dbtable != 'schools_lessons')
            && ($this->dbtable != 'schools_classes')) {
              $this->action_enabled($id, $query);
            }
            break;

          // если команду "Выделить / НеВыделять визуально"
          case ACTION_REQUEST_PARAM_VALUE_HIGHLIGHTED:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
              case 'products_kits':
                $this->action_highlighted($id, $query);
                break;
            }
            break;

          // если команду "Разрешить / запретить комментирование"
          case ACTION_REQUEST_PARAM_VALUE_COMMENTED:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
              case 'products_kits':
                $this->action_commented($id, $query);
                break;
            }
            break;

          // если команду "Скрыть / открыть для незарегистрированных пользователей"
          case ACTION_REQUEST_PARAM_VALUE_HIDDEN:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
              case 'products_kits':
                $this->action_hidden($id, $query);
                break;
            }
            break;

          // если команду "Разрешить / запретить собственный субдомен"
          case ACTION_REQUEST_PARAM_VALUE_DOMAINED:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
              case 'products_kits':
                $this->action_domained($id, $query);
                break;
            }
            break;

          // если команду "Считать / не считать хитом продаж"
          case ACTION_REQUEST_PARAM_VALUE_HIT:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
                $query[] = 'UPDATE ' . $this->dbtable . ' '
                         . 'SET hit = 1 - hit '
                         . 'WHERE ' . $this->dbtable_field . ' = \'' . $this->db->query_value($id) . '\';';
                break;
            }
            break;

          // если команду "Считать / не считать новинкой"
          case ACTION_REQUEST_PARAM_VALUE_NEWEST:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET newest = 1 - newest "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;
            }
            break;

          // если команду "Считать / не считать акционным"
          case ACTION_REQUEST_PARAM_VALUE_ACTIONAL:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET actional = 1 - actional "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;
            }
            break;

          // если команду "Считать / не считать ожидаемым скоро в продаже"
          case ACTION_REQUEST_PARAM_VALUE_AWAITED:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET awaited = 1 - awaited "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;
            }
            break;

          // если команду "Считать по умолчанию для клиентской стороны"
          case ACTION_REQUEST_PARAM_VALUE_DEFAULT:
            switch ($this->dbtable) {
                case 'currencies':
                    $query[] = 'UPDATE `' . $this->dbtable . '` '
                             . 'SET `def` = 0;';
                    $query[] = 'UPDATE `' . $this->dbtable . '` '
                             . 'SET `def` = 1 '
                             . 'WHERE `' . $this->dbtable_field . '` = "' . $this->db->query_value($id) . '";';
                    break;
            }
            break;

          // если команду "Считать по умолчанию для админпанели"
          case ACTION_REQUEST_PARAM_VALUE_DEFAULTA:
            switch ($this->dbtable) {
                case 'currencies':
                    $query[] = 'UPDATE `' . $this->dbtable . '` '
                             . 'SET `defa` = 0;';
                    $query[] = 'UPDATE `' . $this->dbtable . '` '
                             . 'SET `defa` = 1 '
                             . 'WHERE `' . $this->dbtable_field . '` = "' . $this->db->query_value($id) . '";';
                    break;
            }
            break;

          // если команду "Считать базовой"
          case ACTION_REQUEST_PARAM_VALUE_MAIN:
            switch ($this->dbtable) {
                case 'currencies':

                    // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                    $this->check_token();

                    // пересчитываем цены, если принят разрешающий параметр
                    if ($this->param('recalculate')) {
                        $from = $this->main_currency;
                        if (empty($from)) {
                            $from = new stdClass;
                            $from->rate_from = 1;
                            $from->rate_to = 1;
                        }
                        $this->db->query('SELECT * '
                                       . 'FROM `' . $this->dbtable . '` '
                                       . 'WHERE `' . $this->dbtable_field . '` = "' . $this->db->query_value($id) . '" '
                                       . 'LIMIT 1;');
                        $to = $this->db->result();
                        if (empty($to)) {
                            $to = new stdClass;
                            $to->rate_from = 1;
                            $to->rate_to = 1;
                        }
                        $coef = $this->number->safeFloatValueString($to->rate_from / $to->rate_to);
                        $this->db->query('UPDATE `products_variants` '
                                       . 'SET `price` = `price` * ' . $coef . ', '
                                           . '`temp_price` = `temp_price` * ' . $coef . ', '
                                           . '`old_price` = `old_price` * ' . $coef . ';');
                        $this->db->query('UPDATE `delivery_methods` '
                                       . 'SET `price` = `price` * ' . $coef . ';');
                        $this->db->query('UPDATE `orders` '
                                       . 'SET `delivery_price` = `delivery_price` * ' . $coef . ';');
                        $this->db->query('UPDATE `orders_products` '
                                       . 'SET `price` = `price` * ' . $coef . ';');
                        $this->db->query('UPDATE `' . $this->dbtable . '` '
                                       . 'SET `rate_from` = `rate_from` / ' . $this->number->safeFloatValueString($to->rate_from) . ', '
                                           . '`rate_to` = `rate_to` / ' . $this->number->safeFloatValueString($from->rate_to) . ';');
                    }

                    $this->db->query('UPDATE `' . $this->dbtable . '` '
                                   . 'SET `main` = 0;');
                    $this->db->query('UPDATE `' . $this->dbtable . '` '
                                   . 'SET `main` = 1 '
                                   . 'WHERE `' . $this->dbtable_field . '` = "' . $this->db->query_value($id) . '";');

                    // признаем наличие изменений в базе данных
                    $this->changed = TRUE;
                    // для этой команды отслеживать изменения в базе данных уже не нужно
                    $watching = FALSE;
                    // команда уже не требует выполнять запросы
                    $query = array();
                    break;
            }
            break;



          // если команду "Считать / не считать разрешенным в Яндекс.Маркет"
          case ACTION_REQUEST_PARAM_VALUE_YMARKET:
              switch ($this->dbtable) {
                  case DATABASE_PRODUCTS_TABLENAME:
                      $query[] = 'UPDATE `' . $this->dbtable . '` '
                               . 'SET `ymarket` = `ymarket` ^ 1 '
                               . 'WHERE `' . $this->dbtable_field . '` = \'' . $this->db->query_value($id) . '\';';
                      break;
                  case 'products_kits':
                      $query[] = 'UPDATE `' . $this->dbtable . '` '
                               . 'SET `ymarket` = 1 - `ymarket` '
                               . 'WHERE `' . $this->dbtable_field . '` = \'' . $this->db->query_value($id) . '\';';
                      break;
                  case 'currencies':
                      $query[] = 'UPDATE `' . $this->dbtable . '` '
                               . 'SET `ymarket` = 0;';
                      $query[] = 'UPDATE `' . $this->dbtable . '` '
                               . 'SET `ymarket` = 1 '
                               . 'WHERE `' . $this->dbtable_field . '` = \'' . $this->db->query_value($id) . '\';';
                      break;
              }
              break;



          // если команду "Считать / не считать разрешенным в ВКонтакте"
          case ACTION_REQUEST_PARAM_VALUE_VKONTAKTE:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:
              case "products_kits":
                $query[] = "UPDATE " . $this->dbtable . " "
                         . "SET vkontakte = 1 - vkontakte "
                         . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
                break;
            }
            break;

          // если команду "Считать заказ новым" (она для таблицы orders базы данных)
          case ACTION_REQUEST_PARAM_VALUE_COMING:
            if ($this->dbtable == DATABASE_ORDERS_TABLENAME) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET status = '" . $this->db->query_value(ORDER_STATUS_NEW) . "' "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Считать заказ находящимся в обработке" (она для таблицы orders базы данных)
          case ACTION_REQUEST_PARAM_VALUE_PROCESSING:
            if ($this->dbtable == DATABASE_ORDERS_TABLENAME) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET status = '" . $this->db->query_value(ORDER_STATUS_PROCESS) . "' "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Считать заказ выполненным" (она для таблицы orders базы данных)
          case ACTION_REQUEST_PARAM_VALUE_DONE:
            if ($this->dbtable == DATABASE_ORDERS_TABLENAME) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET status = '" . $this->db->query_value(ORDER_STATUS_DONE) . "' "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Считать заказ аннулированным" (она для таблицы orders базы данных)
          case ACTION_REQUEST_PARAM_VALUE_CANCELED:
            if ($this->dbtable == DATABASE_ORDERS_TABLENAME) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET status = '" . $this->db->query_value(ORDER_STATUS_CANCEL) . "' "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Считать заказ оплаченным" (она для таблицы orders базы данных)
          case ACTION_REQUEST_PARAM_VALUE_PAYMENT:
            if ($this->dbtable == DATABASE_ORDERS_TABLENAME) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET payment_status = 1 - payment_status "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Поднять выше" (она не для таблиц deliveries_types, shippings_terms, orders, orders_phases, users и schools_* базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVEUP:
            if (($this->dbtable != "deliveries_types")
            && ($this->dbtable != "shippings_terms")
            && ($this->dbtable != DATABASE_ORDERS_TABLENAME)
            && ($this->dbtable != DATABASE_ORDERS_PHASES_TABLENAME)
            && ($this->dbtable != "schools_types")
            && ($this->dbtable != "schools_lessons")
            && ($this->dbtable != "schools_classes")
            && ($this->dbtable != DATABASE_USERS_TABLENAME)) {
              switch ($this->dbtable) {
                case "countries":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "delivery_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case 'currencies':
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "payment_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "regions":
                  $order_num_suffix = "";
                  $branch_field = "country_id";
                  break;
                case "schools":
                  $order_num_suffix = "";
                  $branch_field = "town_id";
                  break;
                case "towns":
                  $order_num_suffix = "";
                  $branch_field = "region_id";
                  break;
                case DATABASE_CREDIT_PROGRAMS_TABLENAME:
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "products_kits":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case DATABASE_PRODUCTS_TABLENAME:
                  // распознаем выбранный тип товаров, даем порядковому полю соответствующий суффикс и отменяем контроль веток
                  switch ($this->recognize_type($defaults)) {
                    case TYPE_PRODUCTS_HIT:
                      $order_num_suffix = "hit";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_NEWEST:
                      $order_num_suffix = "newest";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_ACTIONAL:
                      $order_num_suffix = "actional";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_AWAITED:
                      $order_num_suffix = "awaited";
                      $branch_field = "";
                      break;
                    default:
                      // иначе оставляем основное порядковое поле и ставим контроль перемещений по веткам категорий
                      $order_num_suffix = "";
                      $branch_field = "category_id";
                  }
                  break;
                default:
                  $order_num_suffix = "";
                  $branch_field = "";
              }
              // передвигаем запись
              $this->action_move_up($id, $query, $branch_field, $order_num_suffix);
            }
            break;

          // если команду "Опустить ниже" (она не для таблиц deliveries_types, shippings_terms, orders, orders_phases, users и schools_* базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVEDOWN:
            if (($this->dbtable != "deliveries_types")
            && ($this->dbtable != "shippings_terms")
            && ($this->dbtable != DATABASE_ORDERS_TABLENAME)
            && ($this->dbtable != DATABASE_ORDERS_PHASES_TABLENAME)
            && ($this->dbtable != "schools_types")
            && ($this->dbtable != "schools_lessons")
            && ($this->dbtable != "schools_classes")
            && ($this->dbtable != DATABASE_USERS_TABLENAME)) {
              switch ($this->dbtable) {
                case "countries":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "delivery_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case 'currencies':
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "payment_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "regions":
                  $order_num_suffix = "";
                  $branch_field = "country_id";
                  break;
                case "schools":
                  $order_num_suffix = "";
                  $branch_field = "town_id";
                  break;
                case "towns":
                  $order_num_suffix = "";
                  $branch_field = "region_id";
                  break;
                case DATABASE_CREDIT_PROGRAMS_TABLENAME:
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "products_kits":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case DATABASE_PRODUCTS_TABLENAME:
                  // распознаем выбранный тип товаров, даем порядковому полю соответствующий суффикс и отменяем контроль веток
                  switch ($this->recognize_type($defaults)) {
                    case TYPE_PRODUCTS_HIT:
                      $order_num_suffix = "hit";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_NEWEST:
                      $order_num_suffix = "newest";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_ACTIONAL:
                      $order_num_suffix = "actional";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_AWAITED:
                      $order_num_suffix = "awaited";
                      $branch_field = "";
                      break;
                    default:
                      // иначе оставляем основное порядковое поле и ставим контроль перемещений по веткам категорий
                      $order_num_suffix = "";
                      $branch_field = "category_id";
                  }
                  break;
                default:
                  $order_num_suffix = "";
                  $branch_field = "";
              }
              // передвигаем запись
              $this->action_move_down($id, $query, $branch_field, $order_num_suffix);
            }
            break;

          // если команду "Поставить первым" (она не для таблиц deliveries_types, shippings_terms, orders, orders_phases, users и schools_* базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVEFIRST:
            if (($this->dbtable != "deliveries_types")
            && ($this->dbtable != "shippings_terms")
            && ($this->dbtable != DATABASE_ORDERS_TABLENAME)
            && ($this->dbtable != DATABASE_ORDERS_PHASES_TABLENAME)
            && ($this->dbtable != "schools_types")
            && ($this->dbtable != "schools_lessons")
            && ($this->dbtable != "schools_classes")
            && ($this->dbtable != DATABASE_USERS_TABLENAME)) {
              switch ($this->dbtable) {
                case "countries":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "delivery_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case 'currencies':
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "payment_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "regions":
                  $order_num_suffix = "";
                  $branch_field = "country_id";
                  break;
                case "schools":
                  $order_num_suffix = "";
                  $branch_field = "town_id";
                  break;
                case "towns":
                  $order_num_suffix = "";
                  $branch_field = "region_id";
                  break;
                case DATABASE_CREDIT_PROGRAMS_TABLENAME:
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "products_kits":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case DATABASE_PRODUCTS_TABLENAME:
                  // распознаем выбранный тип товаров, даем порядковому полю соответствующий суффикс и отменяем контроль веток
                  switch ($this->recognize_type($defaults)) {
                    case TYPE_PRODUCTS_HIT:
                      $order_num_suffix = "hit";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_NEWEST:
                      $order_num_suffix = "newest";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_ACTIONAL:
                      $order_num_suffix = "actional";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_AWAITED:
                      $order_num_suffix = "awaited";
                      $branch_field = "";
                      break;
                    default:
                      // иначе оставляем основное порядковое поле и ставим контроль перемещений по веткам категорий
                      $order_num_suffix = "";
                      $branch_field = "category_id";
                  }
                  break;
                default:
                  $order_num_suffix = "";
                  $branch_field = "";
              }
              // передвигаем запись
              $this->action_move_first($id, $query, $branch_field, $order_num_suffix);
            }
            break;

          // если команду "Поставить последним" (она не для таблиц deliveries_types, shippings_terms, orders, orders_phases, users и schools_* базы данных)
          case ACTION_REQUEST_PARAM_VALUE_MOVELAST:
            if (($this->dbtable != "deliveries_types")
            && ($this->dbtable != "shippings_terms")
            && ($this->dbtable != DATABASE_ORDERS_TABLENAME)
            && ($this->dbtable != DATABASE_ORDERS_PHASES_TABLENAME)
            && ($this->dbtable != "schools_types")
            && ($this->dbtable != "schools_lessons")
            && ($this->dbtable != "schools_classes")
            && ($this->dbtable != DATABASE_USERS_TABLENAME)) {
              switch ($this->dbtable) {
                case "countries":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "delivery_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case 'currencies':
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "payment_methods":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "regions":
                  $order_num_suffix = "";
                  $branch_field = "country_id";
                  break;
                case "schools":
                  $order_num_suffix = "";
                  $branch_field = "town_id";
                  break;
                case "towns":
                  $order_num_suffix = "";
                  $branch_field = "region_id";
                  break;
                case DATABASE_CREDIT_PROGRAMS_TABLENAME:
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case "products_kits":
                  $order_num_suffix = "";
                  $branch_field = "";
                  break;
                case DATABASE_PRODUCTS_TABLENAME:
                  // распознаем выбранный тип товаров, даем порядковому полю соответствующий суффикс и отменяем контроль веток
                  switch ($this->recognize_type($defaults)) {
                    case TYPE_PRODUCTS_HIT:
                      $order_num_suffix = "hit";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_NEWEST:
                      $order_num_suffix = "newest";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_ACTIONAL:
                      $order_num_suffix = "actional";
                      $branch_field = "";
                      break;
                    case TYPE_PRODUCTS_AWAITED:
                      $order_num_suffix = "awaited";
                      $branch_field = "";
                      break;
                    default:
                      // иначе оставляем основное порядковое поле и ставим контроль перемещений по веткам категорий
                      $order_num_suffix = "";
                      $branch_field = "category_id";
                  }
                  break;
                default:
                  $order_num_suffix = "";
                  $branch_field = "";
              }
              // передвигаем запись
              $this->action_move_last($id, $query, $branch_field, $order_num_suffix);
            }
            break;

          // если команду "Удалить помеченные записи"
          case ACTION_REQUEST_PARAM_VALUE_MASSDELETE:
            switch ($this->dbtable) {
              case "countries":
              case "delivery_methods":
              case "deliveries_types":
              case "shippings_terms":
              case 'currencies':
              case "payment_methods":
              case DATABASE_ORDERS_TABLENAME:
              case DATABASE_ORDERS_PHASES_TABLENAME:
              case DATABASE_CREDIT_PROGRAMS_TABLENAME:
              case DATABASE_PRODUCTS_TABLENAME:
              case "products_kits":
              case "regions":
              case "schools":
              case "schools_types":
              case "schools_lessons":
              case "schools_classes":
              case "towns":
              case DATABASE_USERS_TABLENAME:
              case 'coupons':
                  // создаем массив идентификаторов удаляемых элементов
                  $items = array();
                  if (isset($_POST[REQUEST_PARAM_NAME_DELETEIDS]) && is_array($_POST[REQUEST_PARAM_NAME_DELETEIDS])) {
                      foreach ($_POST[REQUEST_PARAM_NAME_DELETEIDS] as $item) $items[$item] = '\'' . $this->db->query_value($item) . '\'';
                  }
                  break;
            }
            // здесь не прерываем case, чтобы попасть в следующий case

          // если команду "Удалить запись"
          case ACTION_REQUEST_PARAM_VALUE_DELETE:
            switch ($this->dbtable) {
              case 'coupons':

                  // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                  $this->check_token();

                  // если не существует массив идентификаторов удаляемых элементов (то есть
                  // попали сюда не из верхнего case), создаем этот массив и передаем в него идентификатор оперируемой записи
                  if (!isset($items)) {
                      $items = array();
                      if (!empty($id)) $items[$id] = '\'' . $this->db->query_value($id) . '\'';
                  }

                  // если есть что удалять
                  if (!empty($items)) {

                      // удаляем записи (помечаем удаленными)
                      $ids = implode(',', $items);
                      $query = 'UPDATE `' . $this->dbtable . '` '
                             . 'SET `deleted` = 1 '
                             . 'WHERE `' . $this->dbtable_field . '` IN (' . $ids . ');';
                      $this->db->query($query);

                      // выясняем наличие изменений в базе данных
                      $this->changed = $this->db->affected_rows() > 0;
                      // для этой команды отслеживать изменения в базе данных уже не нужно
                      $watching = FALSE;
                      // команда уже не требует выполнять запросы
                      $query = array();
                  }
                  break;

              case "countries":
              case "deliveries_types":
              case "shippings_terms":
              case DATABASE_ORDERS_PHASES_TABLENAME:
              case DATABASE_CREDIT_PROGRAMS_TABLENAME:
              case "regions":
              case "schools":
              case "schools_types":
              case "schools_lessons":
              case "schools_classes":
              case "towns":
              case DATABASE_USERS_TABLENAME:
              case "products_kits":

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если не существует массив идентификаторов удаляемых элементов (то есть
                // попали сюда не из верхнего case), создаем этот массив и передаем в него идентификатор оперируемой записи
                if (!isset($items)) {
                  $items = array();
                  if (!empty($id)) $items[$id] = "'" . $this->db->query_value($id) . "'";
                }

                // если есть что удалять
                if (!empty($items)) {

                  // удаляем записи
                  $ids = implode(",", $items);
                  $query = "DELETE FROM " . $this->dbtable . " "
                         . "WHERE " . $this->dbtable_field . " IN (" . $ids . ");";
                  $this->db->query($query);

                  // выясняем наличие изменений в базе данных
                  $this->changed = $this->db->affected_rows() > 0;
                  // для этой команды отслеживать изменения в базе данных уже не нужно
                  $watching = FALSE;
                  // команда уже не требует выполнять запросы
                  $query = array();
                }
                break;
              case 'currencies':

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если не существует массив идентификаторов удаляемых элементов (то есть
                // попали сюда не из верхнего case), создаем этот массив и передаем в него идентификатор оперируемой записи
                if (!isset($items)) {
                  $items = array();
                  if (!empty($id)) $items[$id] = "'" . $this->db->query_value($id) . "'";
                }

                // если есть что удалять
                if (!empty($items)) {

                  // удаляем записи
                  $ids = implode(",", $items);
                  $query = "DELETE FROM " . $this->dbtable . " "
                         . "WHERE " . $this->dbtable_field . " IN (" . $ids . ") "
                               . "AND main != 1;";
                  $this->db->query($query);

                  // выясняем наличие изменений в базе данных
                  $this->changed = $this->db->affected_rows() > 0;
                  // для этой команды отслеживать изменения в базе данных уже не нужно
                  $watching = FALSE;
                  // команда уже не требует выполнять запросы
                  $query = array();
                }
                break;
              case "delivery_methods":
              case "payment_methods":

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если не существует массив идентификаторов удаляемых элементов (то есть
                // попали сюда не из верхнего case), создаем этот массив и передаем в него идентификатор оперируемой записи
                if (!isset($items)) {
                  $items = array();
                  if (!empty($id)) $items[$id] = "'" . $this->db->query_value($id) . "'";
                }

                // если есть что удалять
                if (!empty($items)) {

                  // удаляем записи
                  $ids = implode(",", $items);
                  $query = "DELETE " . $this->dbtable . ", "
                                 . "delivery_payment "
                         . "FROM " . $this->dbtable . " "
                         . "LEFT JOIN delivery_payment "
                                   . "ON delivery_payment." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "WHERE " . $this->dbtable . "." . $this->dbtable_field . " IN (" . $ids . ");";
                  $this->db->query($query);

                  // выясняем наличие изменений в базе данных
                  $this->changed = $this->db->affected_rows() > 0;
                  // для этой команды отслеживать изменения в базе данных уже не нужно
                  $watching = FALSE;
                  // команда уже не требует выполнять запросы
                  $query = array();
                }
                break;
              case DATABASE_ORDERS_TABLENAME:

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если не существует массив идентификаторов удаляемых элементов (то есть
                // попали сюда не из верхнего case), создаем этот массив и передаем в него идентификатор оперируемой записи
                if (!isset($items)) {
                  $items = array();
                  if (!empty($id)) $items[$id] = "'" . $this->db->query_value($id) . "'";
                }

                // если есть что удалять
                if (!empty($items)) {

                  // среди удаляемых неоплаченных выбираем все позиции не "Под заказ" с проведенным списанием со склада
                  $ids = implode(",", $items);
                  $query = "SELECT " . $this->dbtable . "_products.product_id, "
                                     . $this->dbtable . "_products.variant_id, "
                                     . $this->dbtable . "_products.quantity "
                         . "FROM " . $this->dbtable . "_products "
                         . "LEFT JOIN " . $this->dbtable . " "
                                   . "ON " . $this->dbtable . "." . $this->dbtable_field . " = " . $this->dbtable . "_products." . $this->dbtable_field . " "
                         . "WHERE " . $this->dbtable . "_products." . $this->dbtable_field . " IN (" . $ids . ") "
                                . "AND " . $this->dbtable . "_products.quantity > 0 "
                                . "AND " . $this->dbtable . ".written_off = 1 "
                                . "AND " . $this->dbtable . ".payment_status = 0;";
                  $this->db->query($query);
                  $items = $this->db->results();

                  // удаляем записи (только неоплаченные)
                  $query = "DELETE " . $this->dbtable . ", "
                                     . $this->dbtable . "_products "
                         . "FROM " . $this->dbtable . " "
                         . "LEFT JOIN " . $this->dbtable . "_products "
                                   . "ON " . $this->dbtable . "_products." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "WHERE " . $this->dbtable . "." . $this->dbtable_field . " IN (" . $ids . ") "
                                . "AND " . $this->dbtable . ".payment_status = 0;";
                  $this->db->query($query);

                  // выясняем наличие изменений в базе данных
                  $this->changed = $this->db->affected_rows() > 0;

                  // если изменения произошли (записи удалены) и были позиции,
                  // требующие отмены списания со склада, делаем отмену
                  if ($this->changed && !empty($items)) {
                      if (!$this->settings->orders_non_touch_quantity) {
                          foreach ($items as $item) {
                              $query = "UPDATE products_variants "
                                     . "SET stock = stock + " . intval($item->quantity) . " "
                                     . "WHERE variant_id = '" . $this->db->query_value($item->variant_id) . "';";
                              $this->db->query($query);
                          }
                      }
                  }

                  // для этой команды отслеживать изменения в базе данных уже не нужно
                  $watching = FALSE;
                  // команда уже не требует выполнять запросы
                  $query = array();
                }
                break;
              case DATABASE_PRODUCTS_TABLENAME:

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если не существует массив идентификаторов удаляемых элементов (то есть
                // попали сюда не из верхнего case), создаем этот массив и передаем в него идентификатор оперируемой записи
                if (!isset($items)) {
                  $items = array();
                  if (!empty($id)) $items[$id] = "'" . $this->db->query_value($id) . "'";
                }

                // если есть что удалять
                if (!empty($items)) {

                  // удаляем вторичные части записей
                  foreach ($items as $index => $item) {
// TODO: здесь нужно будет вставить удаление картинок товара
                  }
                  // удаляем записи
                  $query = "DELETE " . $this->dbtable . ", "
                                     . $this->dbtable . "_comments, "
                                     . $this->dbtable . "_categories, "
                                     . $this->dbtable . "_variants, "
                                     . "related_" . $this->dbtable . ", "
                                     . DATABASE_PROPERTIES_VALUES_TABLENAME . " "
                         . "FROM " . $this->dbtable . " "
                         . "LEFT JOIN " . $this->dbtable . "_comments "
                                   . "ON " . $this->dbtable . "_comments." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "LEFT JOIN " . $this->dbtable . "_categories "
                                   . "ON " . $this->dbtable . "_categories." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "LEFT JOIN " . $this->dbtable . "_variants "
                                   . "ON " . $this->dbtable . "_variants." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "LEFT JOIN related_" . $this->dbtable . " "
                                   . "ON related_" . $this->dbtable . "." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                                      . "OR related_" . $this->dbtable . ".related_sku = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "LEFT JOIN " . DATABASE_PROPERTIES_VALUES_TABLENAME . " "
                                   . "ON " . DATABASE_PROPERTIES_VALUES_TABLENAME . "." . $this->dbtable_field . " = " . $this->dbtable . "." . $this->dbtable_field . " "
                         . "WHERE " . $this->dbtable . "." . $this->dbtable_field . " IN (" . implode(",", $items) . ");";
                  $this->db->query($query);

                  // выясняем наличие изменений в базе данных
                  $this->changed = $this->db->affected_rows() > 0;
                  // для этой команды отслеживать изменения в базе данных уже не нужно
                  $watching = FALSE;
                  // команда уже не требует выполнять запросы
                  $query = array();
                }
                break;
            }
            break;

          // если команду "Удалить изображение" (она не для следующих таблиц базы данных)
          case ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE:
            if (($this->dbtable != "delivery_methods")
            && ($this->dbtable != "deliveries_types")
            && ($this->dbtable != "shippings_terms")
            && ($this->dbtable != "payment_methods")
            && ($this->dbtable != 'currencies')
            && ($this->dbtable != DATABASE_ORDERS_TABLENAME)
            && ($this->dbtable != DATABASE_ORDERS_PHASES_TABLENAME)
            && ($this->dbtable != DATABASE_CREDIT_PROGRAMS_TABLENAME)
            && ($this->dbtable != "schools_types")
            && ($this->dbtable != "schools_lessons")
            && ($this->dbtable != "schools_classes")
            && ($this->dbtable != "products_kits")) {

              // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
              // удаляем заказанные изображения
              $this->check_token();
              $this->action_delete_image($id, $query);
            }
            break;

          // если команду "Удалить файл"
          case ACTION_REQUEST_PARAM_VALUE_DELETEFILE:
            switch ($this->dbtable) {
              case DATABASE_PRODUCTS_TABLENAME:

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
                // удаляем заказанные файлы
                $this->check_token();
                $this->action_delete_file($id, $query);
                break;
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
          if (empty($result_page) && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
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

      // если получены данные об изменениях и нет признака отмены постинга
      if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST]) && (!isset($_POST[REQUEST_PARAM_NAME_IGNORE_POST]) || ($_POST[REQUEST_PARAM_NAME_IGNORE_POST] != 1))) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        // цикл по измененным записям
        foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {

          // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
          // или добрались до сведений единственно изменяемой записи
          if (!isset($_POST[REQUEST_PARAM_NAME_POST_THISONE]) || isset($_POST[REQUEST_PARAM_NAME_POST_THISONE][$id])) {
            $item_cancel = FALSE;
            $value = $this->dbtable_field;



            // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
            $blank_item = new stdClass;
            $this->item = new stdClass;



            // для какой таблицы базы данных предназначена запись?
            switch ($this->dbtable) {
              case "countries":
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поля url (адрес страницы записи)
                $this->editor->processUrl($this->item, $id, $item_cancel);
                // поле meta_title (мета заголовок)
                if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
                // поле meta_keywords (мета ключевые слова)
                if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
                // поле meta_description (мета описание)
                if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле seo_description (SEO текст)
                $this->editor->processSeoDescription($this->item, $id, $item_cancel);
                // поле phone_code (телефонный код)
                if (isset($_POST["phone_code"][$id])) $this->item->phone_code = trim($_POST["phone_code"][$id]);
                // поля images, images_alts, images_texts, images_view (изображения)
                $this->editor->processImages($this->item, $id, $item_cancel);
                // поле tags (теги)
                if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле browsed (количество просмотров)
                if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "delivery_methods":
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле require_address (требует ли ввода адреса доставки)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["require_address"][$id])) $this->item->require_address = isset($_POST["require_address"][$id]) ? (($_POST["require_address"][$id] == 1) ? 1 : 0) : 0;
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поля price, free_from, discount (цена)
                $this->editor->processPrice($this->item, $id, $item_cancel);
                // поле undelivery_category_ids (идентификаторы необслуживаемых категорий)
                $this->editor->processCategories($this->item, $id, $item_cancel);
                // поле payments_ids (идентификаторы способов оплаты)
                $this->editor->processPayments($this->item, $id, $item_cancel);
                // поле types_ids (идентификаторы типов доставки)
                $this->editor->processTypes($this->item, $id, $item_cancel);
                // поле tracking_url (адрес страницы отслеживания посылки)
                if (isset($_POST["tracking_url"][$id])) $this->item->tracking_url = trim($_POST["tracking_url"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "deliveries_types":
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                break;
              case "shippings_terms":
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                break;
              case 'currencies':
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле main (базовая)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["main"][$id])) $this->item->main = isset($_POST["main"][$id]) ? (($_POST["main"][$id] == 1) ? 1 : 0) : 0;
                // поле def (для клиента)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["def"][$id])) $this->item->def = isset($_POST["def"][$id]) ? (($_POST["def"][$id] == 1) ? 1 : 0) : 0;
                // поле defa (для админа)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["defa"][$id])) $this->item->defa = isset($_POST["defa"][$id]) ? (($_POST["defa"][$id] == 1) ? 1 : 0) : 0;
                // поле ymarket (для Яндекс.Маркет)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["ymarket"][$id])) $this->item->ymarket = isset($_POST["ymarket"][$id]) ? (($_POST["ymarket"][$id] == 1) ? 1 : 0) : 0;
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле sign (надпись)
                $this->process_sign($this->item, $id, $item_cancel);
                // поле code (ISO код)
                $this->process_iso_code($this->item, $id, $item_cancel);
                // поля rate_from, rate_to (курс)
                $this->process_rate_from_to($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "payment_methods":
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле currency_id (идентификатор валюты)
                if (isset($_POST["currency_id"][$id])) $this->item->currency_id = trim($_POST["currency_id"][$id]);
                // поле module (название используемого модуля)
                if (isset($_POST["module"][$id])) $this->item->module = trim($_POST["module"][$id]);
                // поле params (параметры платежного механизма)
                if (isset($_POST["params"][$id])) $this->item->params = @serialize($_POST["params"][$id]);
                // поле deliveries_ids (идентификаторы способов доставки)
                $this->editor->processDeliveries($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "regions":
                // поле country_id (идентификатор страны - это поле нужно обработать до поля "название")
                $this->editor->processCountryId($this->item, $id, $item_cancel);
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поля url (адрес страницы записи)
                $this->editor->processUrl($this->item, $id, $item_cancel);
                // поле meta_title (мета заголовок)
                if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
                // поле meta_keywords (мета ключевые слова)
                if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
                // поле meta_description (мета описание)
                if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле seo_description (SEO текст)
                $this->editor->processSeoDescription($this->item, $id, $item_cancel);
                // поле phone_code (телефонный код)
                if (isset($_POST["phone_code"][$id])) $this->item->phone_code = trim($_POST["phone_code"][$id]);
                // поля images, images_alts, images_texts, images_view (изображения)
                $this->editor->processImages($this->item, $id, $item_cancel);
                // поле tags (теги)
                if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле browsed (количество просмотров)
                if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "towns":
                // поле country_id (идентификатор страны - это поле нужно обработать до поля "название")
                $this->editor->processCountryId($this->item, $id, $item_cancel);
                // поле region_id (идентификатор области - это поле нужно обработать до поля "название")
                $this->editor->processRegionId($this->item, $id, $item_cancel);
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поля url (адрес страницы записи)
                $this->editor->processUrl($this->item, $id, $item_cancel);
                // поле meta_title (мета заголовок)
                if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
                // поле meta_keywords (мета ключевые слова)
                if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
                // поле meta_description (мета описание)
                if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле seo_description (SEO текст)
                $this->editor->processSeoDescription($this->item, $id, $item_cancel);
                // поле phone_code (телефонный код)
                if (isset($_POST["phone_code"][$id])) $this->item->phone_code = trim($_POST["phone_code"][$id]);
                // поле post_code (почтовый индекс)
                if (isset($_POST["post_code"][$id])) $this->item->post_code = trim($_POST["post_code"][$id]);
                // поля images, images_alts, images_texts, images_view (изображения)
                $this->editor->processImages($this->item, $id, $item_cancel);
                // поле tags (теги)
                if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле browsed (количество просмотров)
                if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "schools":
                // поле country_id (идентификатор страны - это поле нужно обработать до поля "название")
                $this->editor->processCountryId($this->item, $id, $item_cancel);
                // поле region_id (идентификатор области - это поле нужно обработать до поля "название")
                $this->editor->processRegionId($this->item, $id, $item_cancel);
                // поле town_id (идентификатор города - это поле нужно обработать до поля "название")
                $this->editor->processTownId($this->item, $id, $item_cancel);
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поля url (адрес страницы записи)
                $this->editor->processUrl($this->item, $id, $item_cancel);
                // поле meta_title (мета заголовок)
                if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
                // поле meta_keywords (мета ключевые слова)
                if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
                // поле meta_description (мета описание)
                if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле seo_description (SEO текст)
                $this->editor->processSeoDescription($this->item, $id, $item_cancel);
                // поле type_id (идентификатор типа заведения)
                $this->editor->processType($this->item, $id, $item_cancel);
                // поле phone (телефоны)
                if (isset($_POST["phone"][$id])) $this->item->phone = trim($_POST["phone"][$id]);
                // поле mobile (мобильные телефоны)
                if (isset($_POST["mobile"][$id])) $this->item->mobile = trim($_POST["mobile"][$id]);
                // поле director (директор)
                if (isset($_POST["director"][$id])) $this->item->director = trim($_POST["director"][$id]);
                // поле email (емейл)
                if (isset($_POST["email"][$id])) $this->item->email = trim($_POST["email"][$id]);
                // поле lessons_ids (идентификаторы предметов)
                $this->editor->processLessons($this->item, $id, $item_cancel);
                // поле classes_ids (идентификаторы классов)
                $this->editor->processClasses($this->item, $id, $item_cancel);
                // поля ringb, ringe (время начала и конца звонков)
                $this->editor->processRings($this->item, $id, $item_cancel);
                // поля collective1, collective2, collective3, collective4 (коллектив)
                $this->editor->processCollective($this->item, $id, $item_cancel);
                // поле address (адрес)
                if (isset($_POST["address"][$id])) $this->item->address = trim($_POST["address"][$id]);
                // поля images, images_alts, images_texts, images_view (изображения)
                $this->editor->processImages($this->item, $id, $item_cancel);
                // поле tags (теги)
                if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле browsed (количество просмотров)
                if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case "schools_types":
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                break;
              case "schools_lessons":
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                break;
              case "schools_classes":
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле lessons_ids (идентификаторы предметов)
                $this->editor->processLessons($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                break;
              case 'users':
                // поле country_id (идентификатор страны - это поле нужно обработать до поля "данные о человеке")
                $this->editor->processCountryId($this->item, $id, $item_cancel);
                // поле region_id (идентификатор области - это поле нужно обработать до поля "данные о человеке")
                $this->editor->processRegionId($this->item, $id, $item_cancel);
                // поле town_id (идентификатор города - это поле нужно обработать до поля "данные о человеке")
                $this->editor->processTownId($this->item, $id, $item_cancel);
                // поле school_id (идентификатор учебного заведения - это поле нужно обработать до поля "данные о человеке")
                $this->editor->processSchoolId($this->item, $id, $item_cancel);
                // поле class_id (идентификатор класса учебного заведения - это поле нужно обработать до поля "данные о человеке")
                $this->editor->processClassId($this->item, $id, $item_cancel);
                // поле grades (оценки)
                $this->process_grades($this->item, $id, $item_cancel);
                // поля name, phone, email, address, icq, skype (данные о человеке)
                $this->editor->processPersonInfo($this->item, $id, $item_cancel);
                if (!$item_cancel && (!isset($this->item->name) || ($this->item->name == "")) && (!isset($this->item->name2) || ($this->item->name2 == "")) && (!isset($this->item->name3) || ($this->item->name3 == ""))) {
                  $item_cancel = $this->push_error("Не указано ФИО учащегося.");
                }
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле subdomain (имя субдомена)
                $this->editor->processSubdomain($this->item, $id, $item_cancel);
                // поле subdomain_enabled (разрешен ли собственный субдомен)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["subdomain_enabled"][$id])) $this->item->subdomain_enabled = isset($_POST["subdomain_enabled"][$id]) ? (($_POST["subdomain_enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле subdomain_html (текст страницы собственного субдомена)
                $this->editor->processSubdomainHtml($this->item, $id, $item_cancel);
                // поле template (имя шаблона)
                $this->editor->processTemplate($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле used_dnevnik (используется в СМС дневнике)
                $this->item->used_dnevnik = 1;
                break;
              case 'orders':
                // поле user_id (идентификатор пользователя)
                if (isset($_POST["user_id"][$id])) $this->item->user_id = trim($_POST["user_id"][$id]);
                // поле country_id (идентификатор страны)
                if (isset($_POST["country_id"][$id])) $this->item->country_id = trim($_POST["country_id"][$id]);
                // поле region_id (идентификатор области)
                if (isset($_POST["region_id"][$id])) $this->item->region_id = trim($_POST["region_id"][$id]);
                // поле town_id (идентификатор города)
                if (isset($_POST["town_id"][$id])) $this->item->town_id = trim($_POST["town_id"][$id]);
                // поле delivery_method_id (идентификатор способа доставки)
                if (isset($_POST["delivery_method_id"][$id])) $this->item->delivery_method_id = trim($_POST["delivery_method_id"][$id]);
                // поле delivery_type (тип доставки)
                if (isset($_POST["delivery_type"][$id])) $this->item->delivery_type = trim($_POST["delivery_type"][$id]);
                // поле delivery_tracking (код отслеживания груза)
                if (isset($_POST["delivery_tracking"][$id])) $this->item->delivery_tracking = trim($_POST["delivery_tracking"][$id]);
                // поле payment_method_id (идентификатор способа оплаты)
                if (isset($_POST["payment_method_id"][$id])) $this->item->payment_method_id = trim($_POST["payment_method_id"][$id]);
                // поле payment_status (состояние оплаты)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["payment_status"][$id])) $this->item->payment_status = isset($_POST["payment_status"][$id]) ? (($_POST["payment_status"][$id] == 1) ? 1 : 0) : 0;
                // поле payment_date (дата оплаты)
                if (isset($_POST["payment_date"][$id])) {
                  $this->item->payment_date = $this->date->fixDate($_POST["payment_date"][$id]);
                } elseif (isset($_POST["payment_date_date"][$id])) {
                  $this->item->payment_date = trim($_POST["payment_date_date"][$id]) . (isset($_POST["payment_date_time"][$id]) ? " " . trim($_POST["payment_date_time"][$id]) : "");
                  $this->item->payment_date = $this->date->fixDate($this->item->payment_date);
                }
                // поле payment_details (детали платежа)
                if (isset($_POST["payment_details"][$id])) $this->item->payment_details = trim($_POST["payment_details"][$id]);
                // поле written_off (признак списания со склада)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["written_off"][$id])) $this->item->written_off = isset($_POST["written_off"][$id]) ? (($_POST["written_off"][$id] == 1) ? 1 : 0) : 0;
                // поле status (состояние заказа)
                if (isset($_POST["status"][$id])) $this->item->status = trim($_POST["status"][$id]);
                // поле state (стадия состояние заказа)
                if (isset($_POST["state"][$id])) $this->item->state = trim($_POST["state"][$id]);
                // поле comment_status (комментарий администратора)
                if (isset($_POST["comment_status"][$id])) $this->item->comment_status = trim($_POST["comment_status"][$id]);
                // поле date (дата создания)
                if (isset($_POST["date"][$id])) {
                  $this->item->date = $this->date->fixDate($_POST["date"][$id]);
                } elseif (isset($_POST["date_date"][$id])) {
                  $this->item->date = trim($_POST["date_date"][$id]) . (isset($_POST["date_time"][$id]) ? " " . trim($_POST["date_time"][$id]) : "");
                  $this->item->date = $this->date->fixDate($this->item->date);
                }
                // поле affiliate_id (идентификатор партнера)
                if (isset($_POST["affiliate_id"][$id])) $this->item->affiliate_id = trim($_POST["affiliate_id"][$id]);
                // поле code (код заказа)
                if (isset($_POST["code"][$id])) $this->item->code = trim($_POST["code"][$id]);
                // поля name, phone, email, address, icq, skype (данные о человеке)
                $this->editor->processPersonInfo($this->item, $id, $item_cancel);
                // поле comment (комментарий покупателя)
                if (isset($_POST["comment"][$id])) $this->item->comment = trim($_POST["comment"][$id]);
                // поле to_date (желаемая дата доставки)
                if (isset($_POST["to_date"][$id])) $this->item->to_date = trim($_POST["to_date"][$id]);
                // поле to_time (желаемое время доставки)
                if (isset($_POST["to_time"][$id])) $this->item->to_time = trim($_POST["to_time"][$id]);
                // поле ip (IP-адрес)
                $this->editor->processIp($this->item, $id, $item_cancel);
                // поле hidden (скрыт ли от чужих)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["hidden"][$id])) $this->item->hidden = isset($_POST["hidden"][$id]) ? (($_POST["hidden"][$id] == 1) ? 1 : 0) : 0;
                // поля элементов заказа
                $this->editor->processOrderItems($this->item, $id, $item_cancel);
                break;
              case 'orders_phases':
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле deleted (удалена ли запись)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["deleted"][$id])) $this->item->deleted = isset($_POST["deleted"][$id]) ? (($_POST["deleted"][$id] == 1) ? 1 : 0) : 0;
                break;
              case 'credit_programs':
                // поле name (название)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле term (срок кредитования)
                if (isset($_POST["term"][$id])) {
                  $this->item->term = intval($_POST["term"][$id]);
                  if ($this->item->term < 1) $this->item->term = 1;
                }
                // поле percent (процентная ставка)
                if (isset($_POST["percent"][$id])) {
                  $this->item->percent = $this->number->floatValue($_POST["percent"][$id]);
                  if ($this->item->percent <= 0) $this->item->percent = 1;
                }
                // поле description (описание)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поля минимальной / максимальной суммы заказа
                $this->process_mini_maxi($this->item, $id, $item_cancel);
                // поле form_fields (запрашиваемые поля)
                $this->process_form_fields($this->item, $id, $item_cancel);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле deleted (удалена ли запись)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["deleted"][$id])) $this->item->deleted = isset($_POST["deleted"][$id]) ? (($_POST["deleted"][$id] == 1) ? 1 : 0) : 0;
                // поле order_num (позиция элемента среди других)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
              case 'products':
                // поле menu_id (идентификатор меню)
                if (isset($_POST["menu_id"][$id])) $this->item->menu_id = trim($_POST["menu_id"][$id]);
                // поле category_id (идентификатор категории - это поле нужно обработать до поля "название товара")
                $this->editor->processCategoryId($this->item, $id, $item_cancel);
                $this->editor->processCategories($this->item, $id, $item_cancel);
                // поле brand_id (идентификатор бренда - это поле нужно обработать до поля "название товара")
                if (isset($_POST["brand_id"][$id])) $this->item->brand_id = trim($_POST["brand_id"][$id]);
                // поле section (к какому разделу сайта принадлежит - это поле нужно обработать до поля "название товара")
                if (isset($_POST["section_field"][$id])) $this->item->section = trim($_POST["section_field"][$id]);
                // поле user_id (идентификатор пользователя)
                if (isset($_POST["user_id"][$id])) $this->item->user_id = trim($_POST["user_id"][$id]);
                // поле shippings_term_id (идентификатор срока доставки)
                if (isset($_POST["shippings_term_id"][$id])) $this->item->shippings_term_id = trim($_POST["shippings_term_id"][$id]);
                // поле objects (перечень подключаемых модулей через запятую)
                $this->editor->processObjects($this->item, $id, $item_cancel);
                // поле hit (считать ли хитом продаж)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["hit"][$id])) $this->item->hit = isset($_POST["hit"][$id]) ? (($_POST["hit"][$id] == 1) ? 1 : 0) : 0;
                // поле newest (считать ли новинкой)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["newest"][$id])) $this->item->newest = isset($_POST["newest"][$id]) ? (($_POST["newest"][$id] == 1) ? 1 : 0) : 0;
                // поле actional (считать ли акционным)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["actional"][$id])) $this->item->actional = isset($_POST["actional"][$id]) ? (($_POST["actional"][$id] == 1) ? 1 : 0) : 0;
                // поле awaited (считать ли ожидаемым скоро в продаже)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["awaited"][$id])) $this->item->awaited = isset($_POST["awaited"][$id]) ? (($_POST["awaited"][$id] == 1) ? 1 : 0) : 0;
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
                // поле vkontakte (разрешить ли экспорт в ВКонтакте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["vkontakte"][$id])) $this->item->vkontakte = isset($_POST["vkontakte"][$id]) ? (($_POST["vkontakte"][$id] == 1) ? 1 : 0) : 0;
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле highlighted (выделена ли визуально)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["highlighted"][$id])) $this->item->highlighted = isset($_POST["highlighted"][$id]) ? (($_POST["highlighted"][$id] == 1) ? 1 : 0) : 0;
                // поле commented (разрешено ли комментировать)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["commented"][$id])) $this->item->commented = isset($_POST["commented"][$id]) ? (($_POST["commented"][$id] == 1) ? 1 : 0) : 0;
                // поле hidden (скрыта ли от незарегистрированных пользователей)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["hidden"][$id])) $this->item->hidden = isset($_POST["hidden"][$id]) ? (($_POST["hidden"][$id] == 1) ? 1 : 0) : 0;
                // поле rss_disabled (запрещена ли демонстрация в RSS)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["rss_disabled"][$id])) $this->item->rss_disabled = isset($_POST["rss_disabled"][$id]) ? (($_POST["rss_disabled"][$id] == 1) ? 1 : 0) : 0;
                // поле export_disabled (запрещена ли демонстрация в информерах)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["export_disabled"][$id])) $this->item->export_disabled = isset($_POST["export_disabled"][$id]) ? (($_POST["export_disabled"][$id] == 1) ? 1 : 0) : 0;
                // поле non_creditable (запрещена ли продажа в кредит)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["non_creditable"][$id])) $this->item->non_creditable = isset($_POST["non_creditable"][$id]) ? (($_POST["non_creditable"][$id] == 1) ? 1 : 0) : 0;
                // поле non_usable (признак товара не для продажи)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["non_usable"][$id])) $this->item->non_usable = isset($_POST["non_usable"][$id]) ? (($_POST["non_usable"][$id] == 1) ? 1 : 0) : 0;
                // поле in_prices (в каких прайсах используется)
                $this->editor->processInPrices($this->item, $id, $item_cancel);
                // поля url, url_special (адрес страницы записи)
                $this->editor->processUrl($this->item, $id, $item_cancel);
                // поле canonical_id (идентификатор канонического товара)
                if (isset($_POST['canonical_id'][$id])) $this->item->canonical_id = trim($_POST['canonical_id'][$id]);
                // поле meta_title (мета заголовок)
                if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
                // поле meta_keywords (мета ключевые слова)
                if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
                // поле meta_description (мета описание)
                if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
                // поле model (название товара)
                $this->editor->processModel($this->item, $id, $item_cancel);
                // поле description (краткий текст)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле body (полный текст)
                $this->editor->processBody($this->item, $id, $item_cancel);
                // поле seo_description (SEO текст)
                $this->editor->processSeoDescription($this->item, $id, $item_cancel);
                // поля вариантов товара
                $this->editor->processVariants($this->item, $id, $item_cancel);
                // поле связанных товаров
                if (isset($_POST["related"][$id])) $this->item->related = trim($_POST["related"][$id]);
                // поле аксессуаров
                if (isset($_POST['accessory_pids'][$id])) $this->item->accessory_pids = $this->optimize_ids_string($_POST['accessory_pids'][$id]);
                // поле похожих категорий
                if (isset($_POST['related_cids'][$id])) $this->item->related_cids = $this->optimize_ids_string($_POST['related_cids'][$id]);
                // поле похожих брендов
                if (isset($_POST['related_bids'][$id])) $this->item->related_bids = $this->optimize_ids_string($_POST['related_bids'][$id]);
                // поле свойств товара
                $this->process_properties($this->item, $id, $item_cancel);
                // поле guarantee (гарантия)
                if (isset($_POST["guarantee"][$id])) $this->item->guarantee = trim($_POST["guarantee"][$id]);
                // поле pcode (буквенный код товара)
                if (isset($_POST["pcode"][$id])) $this->item->pcode = trim($_POST["pcode"][$id]);
                // поле barcode (штрих код товара)
                if (isset($_POST["barcode"][$id])) $this->item->barcode = trim($_POST["barcode"][$id]);
                // поле video (список видео или html-контент видео)
                if (isset($_POST["video"][$id])) $this->item->video = trim($_POST["video"][$id]);
                // поле article_ids (список идентификаторов связанных статей)
                $this->editor->processArticleIds($this->item, $id, $item_cancel);
                // поле news_ids (список идентификаторов связанных новостей)
                $this->editor->processNewsIds($this->item, $id, $item_cancel);
                // поле subdomain (имя субдомена)
                $this->editor->processSubdomain($this->item, $id, $item_cancel);
                // поле subdomain_enabled (разрешен ли собственный субдомен)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["subdomain_enabled"][$id])) $this->item->subdomain_enabled = isset($_POST["subdomain_enabled"][$id]) ? (($_POST["subdomain_enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле subdomain_html (текст страницы собственного субдомена)
                $this->editor->processSubdomainHtml($this->item, $id, $item_cancel);
                // поле template (имя шаблона)
                $this->editor->processTemplate($this->item, $id, $item_cancel);
                // поля images, images_alts, images_texts, images_view (изображения)
                $this->editor->processImages($this->item, $id, $item_cancel);
                // поля files, files_alts, files_texts (файлы)
                $this->editor->processFiles($this->item, $id, $item_cancel);
                // поле coming (дата ожидания в продаже)
                if (isset($_POST["coming"][$id])) $this->item->coming = $this->date->fixDate($_POST["coming"][$id]);
                // поле tags (теги)
                if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле browsed (количество просмотров)
                if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
                // поля rating, votes (рейтинг)
                $this->editor->processRating($this->item, $id, $item_cancel);
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                // поле order_num_hit (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num_hit"][$id])) $this->item->order_num_hit = trim($_POST["order_num_hit"][$id]);
                // поле order_num_newest (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num_newest"][$id])) $this->item->order_num_newest = trim($_POST["order_num_newest"][$id]);
                // поле order_num_actional (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num_actional"][$id])) $this->item->order_num_actional = trim($_POST["order_num_actional"][$id]);
                // поле order_num_awaited (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num_awaited"][$id])) $this->item->order_num_awaited = trim($_POST["order_num_awaited"][$id]);
                break;
              case "products_kits":
                // поле ymarket (разрешить ли экспорт в Яндекс.Маркет)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["ymarket"][$id])) $this->item->ymarket = isset($_POST["ymarket"][$id]) ? (($_POST["ymarket"][$id] == 1) ? 1 : 0) : 0;
                // поле vkontakte (разрешить ли экспорт в ВКонтакте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["vkontakte"][$id])) $this->item->vkontakte = isset($_POST["vkontakte"][$id]) ? (($_POST["vkontakte"][$id] == 1) ? 1 : 0) : 0;
                // поле enabled (разрешена ли к показу на сайте)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["enabled"][$id])) $this->item->enabled = isset($_POST["enabled"][$id]) ? (($_POST["enabled"][$id] == 1) ? 1 : 0) : 0;
                // поле highlighted (выделена ли визуально)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["highlighted"][$id])) $this->item->highlighted = isset($_POST["highlighted"][$id]) ? (($_POST["highlighted"][$id] == 1) ? 1 : 0) : 0;
                // поле commented (разрешено ли комментировать)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["commented"][$id])) $this->item->commented = isset($_POST["commented"][$id]) ? (($_POST["commented"][$id] == 1) ? 1 : 0) : 0;
                // поле hidden (скрыта ли от незарегистрированных пользователей)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["hidden"][$id])) $this->item->hidden = isset($_POST["hidden"][$id]) ? (($_POST["hidden"][$id] == 1) ? 1 : 0) : 0;
                // поле rss_disabled (запрещена ли демонстрация в RSS)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["rss_disabled"][$id])) $this->item->rss_disabled = isset($_POST["rss_disabled"][$id]) ? (($_POST["rss_disabled"][$id] == 1) ? 1 : 0) : 0;
                // поле export_disabled (запрещена ли демонстрация в информерах)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["export_disabled"][$id])) $this->item->export_disabled = isset($_POST["export_disabled"][$id]) ? (($_POST["export_disabled"][$id] == 1) ? 1 : 0) : 0;
                // поле non_creditable (запрещена ли продажа в кредит)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["non_creditable"][$id])) $this->item->non_creditable = isset($_POST["non_creditable"][$id]) ? (($_POST["non_creditable"][$id] == 1) ? 1 : 0) : 0;
                // поле in_prices (в каких прайсах используется)
                $this->editor->processInPrices($this->item, $id, $item_cancel);
                // поля url, url_special (адрес страницы записи)
                $this->editor->processUrl($this->item, $id, $item_cancel);
                // поле meta_title (мета заголовок)
                if (isset($_POST["meta_title"][$id])) $this->item->meta_title = trim($_POST["meta_title"][$id]);
                // поле meta_keywords (мета ключевые слова)
                if (isset($_POST["meta_keywords"][$id])) $this->item->meta_keywords = trim($_POST["meta_keywords"][$id]);
                // поле meta_description (мета описание)
                if (isset($_POST["meta_description"][$id])) $this->item->meta_description = trim($_POST["meta_description"][$id]);
                // поле name (название комплекта товаров)
                $this->editor->processName($this->item, $id, $item_cancel);
                // поле description (краткий текст)
                $this->editor->processDescription($this->item, $id, $item_cancel);
                // поле body (полный текст)
                $this->editor->processBody($this->item, $id, $item_cancel);
                // поле seo_description (SEO текст)
                $this->editor->processSeoDescription($this->item, $id, $item_cancel);
                // поля элементов комплекта
                $this->editor->processKitItems($this->item, $id, $item_cancel);
                // поле tags (теги)
                if (isset($_POST["tags"][$id])) $this->item->tags = trim($_POST["tags"][$id]);
                // поле created (дата создания)
                if (isset($_POST["created"][$id])) $this->item->created = $this->date->fixDate($_POST["created"][$id]);
                // поле modified (дата изменения)
                if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI]) || ($_POST[REQUEST_PARAM_NAME_POST_MINI] != 1) || isset($_POST["modified"][$id])) $this->item->modified = isset($_POST["modified"][$id]) ? $this->date->fixDate($_POST["modified"][$id]) : time();
                // поле browsed (количество просмотров)
                if (isset($_POST["browsed"][$id])) $this->item->browsed = trim($_POST["browsed"][$id]);
                // поле order_num (позиция элемента среди равных в ветви)
                if (isset($_POST["order_num"][$id])) $this->item->order_num = trim($_POST["order_num"][$id]);
                break;
            }



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

              // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
              $this->item->indifferent_caches = TRUE;
              $changed = $this->update($this->item) != '';
              $this->changed = $changed || $this->changed;

              // если запись обновлена и требовали уведомить участников
              $inform_user = isset($_POST['inform_user'][$id]) && ($_POST['inform_user'][$id] == 1);
              $inform_user_sms = isset($_POST['inform_user_sms'][$id]) && ($_POST['inform_user_sms'][$id] == 1);
              $inform_admin = isset($_POST['inform_admin'][$id]) && ($_POST['inform_admin'][$id] == 1);
              $inform_admin_sms = isset($_POST['inform_admin_sms'][$id]) && ($_POST['inform_admin_sms'][$id] == 1);
              $inform_testing = isset($_POST['inform_testing'][$id]) && ($_POST['inform_testing'][$id] == 1);
              if ($changed && ($inform_user || $inform_user_sms || $inform_admin || $inform_admin_sms)) $this->inform($this->item,
                                                                                                                      $inform_user,
                                                                                                                      $inform_user_sms,
                                                                                                                      $inform_admin,
                                                                                                                      $inform_admin_sms,
                                                                                                                      $inform_testing);

              // если страница возврата не указана, используем рекомендуемую страницу
              if (empty($result_page) && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
            }

            $cancel = $cancel || $item_cancel;
          }
        }
      }

      // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
      return $cancel;
    }



    // ===================================================================
    /**
    *  Оптимизация строки идентификаторов через запятую
    *
    *  @access  public
    *  @param   string  $ids        строка идентификаторов
    *  @return  string              оптимизированная строка
    */
    // ===================================================================

    public function optimize_ids_string ( $ids ) {
        $result = array();
        $ids = trim($ids);
        $ids = explode(',', $ids);
        foreach ($ids as & $id) {
            $id = @ intval($id);
            if (!empty($id)) $result[$id] = $id;
        }
        return implode(',', $result);
    }



    // обработка изменения поля PROPERTIES записи ============================

    private function process_properties (&$item, $id, &$cancel) {
      if (isset($_POST['properties'][$id])) $item->properties = $_POST['properties'][$id];
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->products->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {

      // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
      $this->db->products->resetCaches();
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
    }

    // сбор параметров html-формы ============================================

    protected function collect_inputs (&$inputs, &$params, &$defaults) {
      $inputs = array();
      $params = new stdClass;

      // собираем параметры сортировки (метод)
      $params->sort = $this->recognize_sort($defaults);
      $inputs[REQUEST_PARAM_NAME_SORT] = $params->sort;

      // собираем параметры сортировки (направление)
      $params->sort_direction = $this->recognize_sort_direction($defaults);
      $inputs[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;

      // собираем параметры сортировки (лаконичный режим)
      $params->sort_laconical = $this->recognize_sort_laconical($defaults);
      $inputs[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;

      // собираем параметры селекции (тип)
      $params->type = $this->recognize_type($defaults);
      $inputs[REQUEST_PARAM_NAME_TYPE] = $params->type;

      // собираем параметры отображения (режим)
      $params->view_mode = $this->recognize_view_mode($defaults);
      $inputs[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;

      // собираем параметры фильтра (ручной запуск)
      $params->filter_manually = $this->recognize_filter_manually($defaults);
      $inputs[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;

      // собираем параметры фильтра (страна)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_COUNTRY])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_COUNTRY]);
        if ($value != '') $params->country_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $value;
      }

      // собираем параметры фильтра (область)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_REGION])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_REGION]);
        if ($value != '') $params->region_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_REGION] = $value;
      }

      // собираем параметры фильтра (город)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_TOWN])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_TOWN]);
        if ($value != '') $params->town_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_TOWN] = $value;
      }

      // собираем параметры фильтра (учебное заведение)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SCHOOL])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SCHOOL]);
        if ($value != '') $params->school_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SCHOOL] = $value;
      }

      // собираем параметры фильтра (класс учебного заведения)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CLASS])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CLASS]);
        if ($value != '') $params->class_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_CLASS] = $value;
      }

      // собираем параметры фильтра (предмет учебного заведения)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_LESSON])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_LESSON]);
        if ($value != '') $params->lesson_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_LESSON] = $value;
      }

      // собираем параметры фильтра (день)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DAY])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DAY]);
        if ($value != '') $params->day = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_DAY] = $value;
      }

      // собираем параметры фильтра (месяц)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MONTH])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MONTH]);
        if ($value != '') $params->month = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_MONTH] = $value;
      }

      // собираем параметры фильтра (год)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_YEAR])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_YEAR]);
        if ($value != '') $params->year = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_YEAR] = $value;
      }

      // собираем параметры фильтра (категория)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY]);
        if ($value != '') $params->category_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $value;
      }

      // собираем параметры фильтра (бренд)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND]);
        if ($value != '') $params->brand_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_BRAND] = $value;
      }

      // собираем параметры фильтра (склад)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_STOCK])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_STOCK]);
        if ($value != '') $params->stock_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_STOCK] = $value;
      }

      // собираем параметры фильтра (админ)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER]);
        if ($value != '') $params->user_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_USER] = $value;
      }

      // собираем параметры фильтра (партнер)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PARTNER])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PARTNER]);
        if ($value != '') $params->affiliate_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_PARTNER] = $value;
      }

      // собираем параметры фильтра (группа)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_GROUP])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_GROUP]);
        if ($value != '') $params->group_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_GROUP] = $value;
      }

      // собираем параметры фильтра (ценовая группа)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PRICEGROUP])) {
          $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PRICEGROUP]);
          if ($value != '') $params->price_id = $value;
          $inputs[REQUEST_PARAM_NAME_FILTER_PRICEGROUP] = $value;
      }

      // собираем параметры фильтра (раздел)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION]);
        if ($value != '') $params->section = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SECTION] = $value;
      }

      // собираем параметры фильтра (меню)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU]);
        if ($value != '') $params->menu_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_MENU] = $value;
      }

      // собираем параметры фильтра (хит продаж)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIT])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIT]);
        if ($value != '') $params->hit = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_HIT] = $value;
      }

      // собираем параметры фильтра (новинка)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWEST])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWEST]);
        if ($value != '') $params->newest = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NEWEST] = $value;
      }

      // собираем параметры фильтра (акционный)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ACTIONAL])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ACTIONAL]);
        if ($value != '') $params->actional = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_ACTIONAL] = $value;
      }

      // собираем параметры фильтра (скоро в продаже)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_AWAITED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_AWAITED]);
        if ($value != '') $params->awaited = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_AWAITED] = $value;
      }

      // собираем параметры фильтра (экспорт Яндекс.Маркет)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_YMARKET])) {
          $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_YMARKET]);
          if ($value != '') $params->ymarket = $value;
          $inputs[REQUEST_PARAM_NAME_FILTER_YMARKET] = $value;
      }

      // собираем параметры фильтра (экспорт ВКонтакте)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_VKONTAKTE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_VKONTAKTE]);
        if ($value != '') $params->vkontakte = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_VKONTAKTE] = $value;
      }

      // собираем параметры фильтра (завершена)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DONE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DONE]);
        if ($value != '') $params->done = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_DONE] = $value;
      }

      // собираем параметры фильтра (разрешена)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED]);
        if ($value != '') $params->enabled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_ENABLED] = $value;
      }

      // собираем параметры фильтра (удалена)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELETED])) {
          $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELETED]);
          if ($value != '') $params->deleted = $value;
          $inputs[REQUEST_PARAM_NAME_FILTER_DELETED] = $value;
      }

      // собираем параметры фильтра (скрыта от чужих)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN]);
        if ($value != '') $params->hidden = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $value;
      }

      // собираем параметры фильтра (обсуждаема)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_COMMENTED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_COMMENTED]);
        if ($value != '') $params->commented = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $value;
      }

      // собираем параметры фильтра (не для rss)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS]);
        if ($value != '') $params->rss_disabled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $value;
      }

      // собираем параметры фильтра (не для экспорта)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT]);
        if ($value != '') $params->export_disabled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $value;
      }

      // собираем параметры фильтра (не для кредита)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE]);
        if ($value != '') $params->non_creditable = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE] = $value;
      }

      // собираем параметры фильтра (не для продажи)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONUSABLE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONUSABLE]);
        if ($value != '') $params->non_usable = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NONUSABLE] = $value;
      }

      // собираем параметры фильтра (с картинками)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED]);
        if ($value != '') $params->imaged = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_IMAGED] = $value;
      }

      // собираем параметры фильтра (с файлами)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_FILED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_FILED]);
        if ($value != '') $params->filed = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_FILED] = $value;
      }

      // собираем параметры фильтра (с SEO текстом)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED]);
        if ($value != '') $params->SEOed = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SEOED] = $value;
      }

      // собираем параметры фильтра (с особым url)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL]);
        if ($value != '') $params->url_special = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $value;
      }

      // собираем параметры фильтра (с модулями)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED]);
        if ($value != '') $params->objected = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $value;
      }

      // собираем параметры фильтра (имеет субдомен)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DOMAINED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DOMAINED]);
        if ($value != '') $params->domained = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_DOMAINED] = $value;
      }

      // собираем параметры фильтра (имеет связанные статьи)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ARTICLED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ARTICLED]);
        if ($value != '') $params->articled = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_ARTICLED] = $value;
      }

      // собираем параметры фильтра (имеет связанные новости)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWSED])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWSED]);
        if ($value != '') $params->newsed = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_NEWSED] = $value;
      }

      // собираем параметры фильтра (искомая строка)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCH])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCH]);
        if ($value != '') $params->search = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SEARCH] = $value;
      }

      // собираем параметры фильтра (искомая цена от)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM]);
        if ($this->number->floatValue($value) != 0) $params->search_cost_from = $this->number->floatValue($value) * $this->currency->rate_to / $this->currency->rate_from;
        $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM] = $value;
      }

      // собираем параметры фильтра (искомая цена до)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO]);
        if ($this->number->floatValue($value) != 0) $params->search_cost_to = $this->number->floatValue($value) * $this->currency->rate_to / $this->currency->rate_from;
        $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO] = $value;
      }

      // собираем параметры фильтра (искомая дата от)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM]);
        if ($value != '') {
          $value = $this->date->fixDate($value);
          if (is_int($value)) $value = date('Y-m-d', $value);
          $value = substr($value, 0, 10);
          if ($value == '0000-00-00') $value = '';
          if ($value != '') $params->search_date_from = $value;
        }
        $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM] = $value;
      }

      // собираем параметры фильтра (искомая дата до)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO]);
        if ($value != '') {
          $value = $this->date->fixDate($value);
          if (is_int($value)) $value = date('Y-m-d', $value);
          $value = substr($value, 0, 10);
          if ($value == '0000-00-00') $value = '';
          if ($value != '') $params->search_date_to = $value;
        }
        $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO] = $value;
      }

      // собираем параметры фильтра (способ доставки)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELIVERY])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELIVERY]);
        if ($value != '') $params->delivery_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_DELIVERY] = $value;
      }

      // собираем параметры фильтра (способ оплаты)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYMENT])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYMENT]);
        if ($value != '') $params->payment_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_PAYMENT] = $value;
      }

      // собираем параметры фильтра (состояние оплаты)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYSTATUS])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYSTATUS]);
        if ($value != '') $params->payment_status = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_PAYSTATUS] = $value;
      }

      // собираем параметры фильтра (оформляемые в кредит)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CREDITABLE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CREDITABLE]);
        if ($value != '') $params->creditable = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_CREDITABLE] = $value;
      }

      // собираем параметры фильтра (реферал)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_AFFILIATE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_AFFILIATE]);
        if ($value != '') $params->affiliate_id = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_AFFILIATE] = $value;
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->products_num_admin) && !empty($this->settings->products_num_admin)) {
        $this->items_per_page = intval($this->settings->products_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = PRODUCTS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_PRODUCTS_MODE_AS_IS;
      $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
      $defaults->sort_laconical = 1;
      $defaults->type = TYPE_PRODUCTS_ANY;
      $defaults->view_mode = VIEW_MODE_STANDARD;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Товары';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // если в фильтре была выбрана категория или бренд и доступны их данные, передаем данные в фильтр
      // чтения товаров вместо идентификаторов (чтобы читать товары всей выбранной ветки)
      if (isset($params->category_id)) {
        if (isset($this->categories[$params->category_id])) $params->category = &$this->categories[$params->category_id];
      }
      if (isset($params->brand_id)) {
        if (isset($this->brands[$params->brand_id])) $params->brand = &$this->brands[$params->brand_id];
      }

      // читаем список товаров на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->products->get($items, $params);
      $this->db->products->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->type)) $this->params[REQUEST_PARAM_NAME_TYPE] = $params->type;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->category_id)) $this->params[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $params->category_id;
      if (isset($params->brand_id)) $this->params[REQUEST_PARAM_NAME_FILTER_BRAND] = $params->brand_id;
      if (isset($params->stock_id)) $this->params[REQUEST_PARAM_NAME_FILTER_STOCK] = $params->stock_id;
      if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
      if (isset($params->menu_id)) $this->params[REQUEST_PARAM_NAME_FILTER_MENU] = $params->menu_id;
      if (isset($params->section)) $this->params[REQUEST_PARAM_NAME_FILTER_SECTION] = $params->section;
      if (isset($params->hit)) $this->params[REQUEST_PARAM_NAME_FILTER_HIT] = $params->hit;
      if (isset($params->newest)) $this->params[REQUEST_PARAM_NAME_FILTER_NEWEST] = $params->newest;
      if (isset($params->actional)) $this->params[REQUEST_PARAM_NAME_FILTER_ACTIONAL] = $params->actional;
      if (isset($params->awaited)) $this->params[REQUEST_PARAM_NAME_FILTER_AWAITED] = $params->awaited;
      if (isset($params->ymarket)) $this->params[REQUEST_PARAM_NAME_FILTER_YMARKET] = $params->ymarket;
      if (isset($params->vkontakte)) $this->params[REQUEST_PARAM_NAME_FILTER_VKONTAKTE] = $params->vkontakte;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      if (isset($params->commented)) $this->params[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $params->commented;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->filed)) $this->params[REQUEST_PARAM_NAME_FILTER_FILED] = $params->filed;
      if (isset($params->objected)) $this->params[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $params->objected;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      if (isset($params->url_special)) $this->params[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $params->url_special;
      if (isset($params->rss_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $params->rss_disabled;
      if (isset($params->export_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $params->export_disabled;
      if (isset($params->non_creditable)) $this->params[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE] = $params->non_creditable;
      if (isset($params->non_usable)) $this->params[REQUEST_PARAM_NAME_FILTER_NONUSABLE] = $params->non_usable;
      if (isset($params->domained)) $this->params[REQUEST_PARAM_NAME_FILTER_DOMAINED] = $params->domained;
      if (isset($params->articled)) $this->params[REQUEST_PARAM_NAME_FILTER_ARTICLED] = $params->articled;
      if (isset($params->newsed)) $this->params[REQUEST_PARAM_NAME_FILTER_NEWSED] = $params->newsed;
      if (isset($params->search)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCH] = $params->search;
      if (isset($params->search_cost_from)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM];
      if (isset($params->search_cost_to)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO];
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи товаров оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->products->operable($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->fetchAdminTemplate();
    }
  }



  // =========================================================================
  // Класс Product (админ модуль страницы товара)
  // =========================================================================

  class Product extends Products {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_PRODUCT_CLASS_RESULT_PAGE;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('categories',
                                  'all_brands',
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
      // если нет данных товара или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый товар';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $params->with_related = 1;
        $this->db->products->one($this->item, $params);
      }

      // если данные товара получены,
      //   меняем заголовок страницы,
      //   выправляем текст товара согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование товара "' . (isset($this->item->model) ? $this->item->model : '') . '"';
        if ($this->settings->products_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->products_wysiwyg_disabled_mode);
          if (isset($this->item->body)) $this->item->body = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->body, $this->settings->products_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->products_wysiwyg_disabled_mode);
        }
        // преобразуем поле in_prices (в каких прайсах используется) в массив
        if (isset($this->item->in_prices)) {
          $n = array();
          for ($i = 0; $i <= 7; $i++) $n[] = ($this->item->in_prices >> $i) & 1;
          $this->item->in_prices = $n;
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->products->unpack($this->item);
        // определяем есть ли вторичные прикрепления к категориям
        if (isset($this->item->categories)) {
          array_shift($this->item->categories);
          if (!empty($this->item->categories)) $this->item->use_categories = 1;
        }
        // если это команда "Создать копию", деидентифицируем товар и его варианты
        if (trim($this->param(REQUEST_PARAM_NAME_ACTION)) == ACTION_REQUEST_PARAM_VALUE_COPY) {
          $this->item->product_id = 0;
          $this->item->model = '[Копия] ' . $this->item->model;
          $this->item->url = '';
          if (!isset($this->item->variants)) $this->item->variants = array();
          foreach ($this->item->variants as & $variant) {
            $variant->variant_id = 0;
            $variant->product_id = 0;
            $variant->sku = '';
            $variant->virtual = 1;
          }
        }
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->category_id = $this->param(REQUEST_PARAM_NAME_CATEGORY_ID);
        $this->item->brand_id = $this->param(REQUEST_PARAM_NAME_BRAND_ID);
        $this->item->enabled = 1;
        $this->item->hidden = 0;
        $this->item->browsed = 0;
        $this->item->url_special = 0;
        $this->item->in_prices = array(1, 1, 1, 1, 1, 1, 1, 1);
        $this->item->variants = array();
          $variant = new stdClass;
          $variant->priority_discount = -1;
          $this->item->variants[] = $variant;
        $this->item->section = 1;
      }

      // читаем и передаем в шаблонизатор список сроков отправки
      $params = new stdClass;
      $params->sort = SORT_SHIPPINGSTERMS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_shippings_terms($terms, $params);
      $this->db->fix_shippings_terms_records($terms);
      $this->smarty->assignByRef(SMARTY_VAR_TERMS, $terms);

      // читаем и передаем в шаблонизатор список статей (в режиме минимума информации)
      $params = new stdClass;
      $params->sort = SORT_ARTICLES_MODE_BY_HEADER;
      $params->minimum_info = 1;
      $this->db->get_articles($articles, $params);
      $this->smarty->assignByRef('all_articles', $articles);

      // читаем и передаем в шаблонизатор список новостей (в режиме минимума информации)
      $news = null;
      $params = new stdClass;
      $params->sort = SORT_NEWS_MODE_BY_HEADER;
      $params->minimum_info = 1;
      $this->db->news->get($news, $params);
      $this->smarty->assignByRef(SMARTY_VAR_NEWS, $news);

      // берем упорядоченный по названию список свойств товаров (непустых и разрешенных)
      $params = new stdClass;
      $params->sort =  SORT_PROPERTIES_MODE_BY_NAME;
      $params->optioned = 1;
      $params->enabled = 1;
      $this->db->get_properties($properties, $params);
      $this->db->fix_properties_records($properties);

      // вносим в список значения свойств этого товара и передаем в шаблонизатор
      if (!empty($properties) && isset($this->item->product_id)) {
        foreach ($properties as &$property) {
          $query = 'SELECT ' . DATABASE_PROPERTIES_VALUES_TABLENAME . '.value '
                 . 'FROM ' . DATABASE_PROPERTIES_VALUES_TABLENAME . ' '
                 . 'WHERE ' . DATABASE_PROPERTIES_VALUES_TABLENAME . '.product_id = \'' . $this->db->query_value($this->item->product_id) . '\' '
                       . 'AND ' . DATABASE_PROPERTIES_VALUES_TABLENAME . '.property_id = \'' . $this->db->query_value($property->property_id) . '\' '
                 . 'ORDER BY order_num ASC;';
          $this->db->query($query);
          $values = $this->db->results();
          if (!empty($values)) {
            foreach ($values as &$value) $value = $value->value;
          }
          $property->value = $values;
        }
      }
      $this->smarty->assign(SMARTY_VAR_PRODUCT_PROPERTIES, $properties);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_PRODUCT_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс ProductsKits (админ модуль списка комплектов товаров)
  // =========================================================================

  class ProductsKits extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'products_kits';
    public $dbtable_field = 'kit_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_PRODUCTSKITS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

        // приказываем объекту базы данных обновить/добавить указанную запись
        return $this->db->products_kits->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->productskits_num_admin) && !empty($this->settings->productskits_num_admin)) {
        $this->items_per_page = intval($this->settings->productskits_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = PRODUCTSKITS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_PRODUCTSKITS_MODE_AS_IS;
      $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_STANDARD;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Комплекты товаров';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список комплектов товаров на текущей странице согласно параметрам фильтра и сортировки
      $items = null;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->products_kits->get($items, $params);
      $this->db->products_kits->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->ymarket)) $this->params[REQUEST_PARAM_NAME_FILTER_YMARKET] = $params->ymarket;
      if (isset($params->vkontakte)) $this->params[REQUEST_PARAM_NAME_FILTER_VKONTAKTE] = $params->vkontakte;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->hidden)) $this->params[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $params->hidden;
      if (isset($params->commented)) $this->params[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $params->commented;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      if (isset($params->url_special)) $this->params[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $params->url_special;
      if (isset($params->rss_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $params->rss_disabled;
      if (isset($params->export_disabled)) $this->params[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $params->export_disabled;
      if (isset($params->non_creditable)) $this->params[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE] = $params->non_creditable;
      if (isset($params->search)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCH] = $params->search;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи комплектов товаров оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->products_kits->operable($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_PRODUCTSKITS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс ProductsKit (админ модуль страницы комплекта товаров)
  // =========================================================================

  class ProductsKit extends ProductsKits {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_PRODUCTSKIT_CLASS_RESULT_PAGE;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('categories');



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
      // если нет данных комплекта товаров или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый комплект товаров';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->products_kits->one($this->item, $params);
      }

      // если данные комплекта товаров получены,
      //   меняем заголовок страницы,
      //   выправляем текст комплекта товаров согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование комплекта товаров "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        if ($this->settings->productskits_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->productskits_wysiwyg_disabled_mode);
          if (isset($this->item->body)) $this->item->body = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->body, $this->settings->productskits_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->productskits_wysiwyg_disabled_mode);
        }
        // преобразуем поле in_prices (в каких прайсах используется) в массив
        if (isset($this->item->in_prices)) {
          $n = array();
          for ($i = 0; $i <= 7; $i++) $n[] = ($this->item->in_prices >> $i) & 1;
          $this->item->in_prices = $n;
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->products_kits->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->hidden = 0;
        $this->item->browsed = 0;
        $this->item->url_special = 0;
        $this->item->in_prices = array(1, 1, 1, 1, 1, 1, 1, 1);
        $this->item->products = array();
      }

      // дополняем список категорий товарами (со степенью полноты записей как для конфигуратора / быстрого заказа)
      $params = new stdClass;
      $params->completeness = GET_PRODUCTS_COMPLETENESS_FOR_EDITORDER;
      $params->sort = SORT_PRODUCTS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $params->sort_laconical = 1;
      $params->enabled = 1;
      $this->db->productize_categories($this->categories_tree, $this->categories, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_CATALOG, $this->categories_tree);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_PRODUCTSKIT_CLASS_TEMPLATE_FILE);

      // удаляем из записей категорий списки товаров (освобождаем место в памяти)
      $this->db->unproductize_categories($this->categories);
    }
  }



  // =========================================================================
  // Класс OrdersPhases (админ модуль списка стадий заказа)
  // =========================================================================

  class OrdersPhases extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_ORDERS_PHASES_TABLENAME;
    public $dbtable_field = 'phase_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_ORDERSPHASES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_orders_phase($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->ordersphases_num_admin) && !empty($this->settings->ordersphases_num_admin)) {
        $this->items_per_page = intval($this->settings->ordersphases_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = ORDERSPHASES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_ORDERSPHASES_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Стадии заказа';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список стадий заказа на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_orders_phases($items, $params);
      $this->db->fix_orders_phases_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи стадий заказа оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_orders_phases($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_ORDERSPHASES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс OrdersPhase (админ модуль страницы стадии заказа)
  // =========================================================================

  class OrdersPhase extends OrdersPhases {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_ORDERSPHASE_CLASS_RESULT_PAGE;



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
      // если нет данных стадии заказа или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новая стадия заказа';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_orders_phase($this->item, $params);
      }

      // если данные стадии заказа получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование стадии заказа "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_orders_phases_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_ORDERSPHASE_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс PaymentsHistory (админ модуль истории платежей)
  // =========================================================================

  class PaymentsHistory extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_ORDERS_TABLENAME;
    public $dbtable_field = 'order_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_PAYMENTSHISTORY_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('all_users');



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // ничего не делаем (этот класс не имеет такого метода)
      return FALSE;
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->paymentshistory_num_admin) && !empty($this->settings->paymentshistory_num_admin)) {
        $this->items_per_page = intval($this->settings->paymentshistory_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = PAYMENTSHISTORY_SESSION_PARAM_NAME;
      $defaults->sort = SORT_ORDERS_MODE_BY_PAYMENT_DATE;
      $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
      $defaults->sort_laconical = 0;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // устанавливаем заголовок страницы
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'История платежей';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // этот модуль использует другие переменные фильтра даты
      if (isset($params->search_date_from) && !isset($params->search_paydate_from)) {
        $params->search_paydate_from = $params->search_date_from;
        unset($params->search_date_from);
      }
      if (isset($params->search_date_to) && !isset($params->search_paydate_to)) {
        $params->search_paydate_to = $params->search_date_to;
        unset($params->search_date_to);
      }

      // читаем список ОПЛАЧЕННЫХ заказов на текущей странице согласно параметрам фильтра и сортировки
      $params->payment_status = 1;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->orders->get($items, $params);
      $this->db->orders->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
      if (isset($params->payment_id)) $this->params[REQUEST_PARAM_NAME_FILTER_PAYMENT] = $params->payment_id;
      if (isset($params->search_paydate_from)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM];
      if (isset($params->search_paydate_to)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO];
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи заказов оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->orders->operable($items, $params);

      // читаем список разрешенных способов оплаты
      $payments = null;
      $params = new stdClass;
      $params->sort = SORT_PAYMENTS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $params->enabled = 1;
      $this->db->payments->get($payments, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_PAYMENTS, $payments);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_PAYMENTSHISTORY_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс CreditPrograms (админ модуль списка кредитных программ)
  // =========================================================================

  class CreditPrograms extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_CREDIT_PROGRAMS_TABLENAME;
    public $dbtable_field = 'credit_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_CREDITPROGRAMS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обработка изменения полей MINIMAL_SUM, MAXIMAL_SUM записи =============

    protected function process_mini_maxi (&$item, $id, &$cancel) {
      $rate_to = isset($this->currency->rate_to) && ($this->currency->rate_to != 0) ? abs($this->currency->rate_to) : 1;
      $rate_from = isset($this->currency->rate_from) && ($this->currency->rate_from != 0) ? abs($this->currency->rate_from) : 1;

      // если есть данные о минимальной сумме
      if (isset($_POST['minimal_sum'][$id])) {
        $value = $this->number->floatValue($_POST['minimal_sum'][$id]) * $rate_to / $rate_from;
        if ($value < 0) $value = 0;
        $item->minimal_sum = $value;
      }

      // если есть данные о максимальной сумме
      if (isset($_POST['maximal_sum'][$id])) {
        $value = $this->number->floatValue($_POST['maximal_sum'][$id]) * $rate_to / $rate_from;
        if ($value < 0) $value = 0;
        $item->maximal_sum = $value;
      }

      // если нужно обменять суммы
      if (isset($item->minimal_sum) && isset($item->maximal_sum)
      && ($item->minimal_sum > $item->maximal_sum) && ($item->maximal_sum > 0)) {
        $value = $item->minimal_sum;
        $item->minimal_sum = $item->maximal_sum;
        $item->maximal_sum = $value;
      }
    }

    // обработка изменения поля FORM_FIELDS записи ===========================

    protected function process_form_fields (&$item, $id, &$cancel) {
      if (isset($_POST['form_fields'][$id])) {
        switch ($this->dbtable) {
          case DATABASE_CREDIT_PROGRAMS_TABLENAME:
            $fields = is_array($_POST['form_fields'][$id]) ? $_POST['form_fields'][$id] : array();
            $item->form_fields = array();
            $ok = FALSE;
            foreach ($fields as $index => &$field) {
              if (isset($_POST['form_fields_used'][$id][$index])) {
                if (is_string($field)) {
                  $field = trim($field);
                } elseif (is_array($field)) {
                  if (isset($field['field']) && isset($field['type'])) {
                    $field = array('field'    => trim($field['field']),
                                   'type'     => intval($field['type']),
                                   'required' => isset($field['required']) && $field['required']);
                    if ($field['field'] != '') {
                      $ok = TRUE;
                    } else {
                      $field = null;
                    }
                  } else {
                    $field = null;
                  }
                }
                if (is_string($field) && ($field != '')
                || is_array($field) && !empty($field)) $item->form_fields[] = $field;
              }
            }
            if (empty($item->form_fields) || !$ok) $cancel = $this->push_error('Не указано ни одного поля, запрашиваемого у пользователя по такой кредитной программе.');
            break;
        }
      }
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->credit_programs->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->creditprograms_num_admin) && !empty($this->settings->creditprograms_num_admin)) {
        $this->items_per_page = intval($this->settings->creditprograms_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = CREDITPROGRAMS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_CREDITPROGRAMS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Кредитные программы';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список кредитных программ на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->credit_programs->get($items, $params);
      $this->db->credit_programs->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи кредитных программ оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->credit_programs->operable($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_CREDITPROGRAMS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс CreditProgram (админ модуль страницы кредитной программы)
  // =========================================================================

  class CreditProgram extends CreditPrograms {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_CREDITPROGRAM_CLASS_RESULT_PAGE;



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
      // если нет данных кредитной программы или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новая кредитная программа';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->credit_programs->one($this->item, $params);
      }

      // если данные кредитной программы получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование кредитной программы "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->credit_programs->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
        $this->item->enabled = 1;
        $this->item->deleted = 0;
        $this->item->form_fields = $this->db->credit_programs->defaultFormFields();
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_CREDITPROGRAM_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Deliveries (админ модуль списка способов доставки)
  // =========================================================================

  class Deliveries extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'delivery_methods';
    public $dbtable_field = 'delivery_method_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_DELIVERIES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('categories');



    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_delivery($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->deliveries_num_admin) && !empty($this->settings->deliveries_num_admin)) {
        $this->items_per_page = intval($this->settings->deliveries_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = DELIVERIES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_DELIVERIES_MODE_AS_IS;
      $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_STANDARD;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Способы доставки';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список способов доставки на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_deliveries($items, $params);
      $this->db->fix_deliveries_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи способов доставки оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_deliveries($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_DELIVERIES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Delivery (админ модуль страницы способа доставки)
  // =========================================================================

  class Delivery extends Deliveries {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_DELIVERY_CLASS_RESULT_PAGE;



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
      // если нет данных способа доставки или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый способ доставки';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_delivery($this->item, $params);
      }

      // если данные способа доставки получены,
      //   меняем заголовок страницы,
      //   выправляем текст страны согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование способа доставки "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        if ($this->settings->deliveries_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->deliveries_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_deliveries_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->discount = -1;
        $this->item->undelivery_category_ids = array();
        $this->item->types_ids = array();
        $this->item->payments_ids = array();
      }

      // читаем список типов доставки
      $params = new stdClass;
      $params->sort = SORT_DELIVERIESTYPES_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_deliveries_types($types, $params);
      $this->db->fix_deliveries_types_records($types);

      // читаем список способов оплаты
      $query = 'SELECT payment_methods.*, '
                   . '(delivery_payment.delivery_method_id IS NOT NULL) AS enabled '
             . 'FROM payment_methods '
             . 'LEFT JOIN delivery_payment '
                       . 'ON payment_methods.payment_method_id = delivery_payment.payment_method_id '
                          . 'AND delivery_payment.delivery_method_id = \'' . $this->db->query_value($id) . '\';';
      $this->db->query($query);
      $payments = $this->db->results();

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_PAYMENTS, $payments);
      $this->smarty->assignByRef(SMARTY_VAR_TYPES, $types);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_DELIVERY_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс DeliveriesTypes (админ модуль списка типов доставки)
  // =========================================================================

  class DeliveriesTypes extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'deliveries_types';
    public $dbtable_field = 'type_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_DELIVERIESTYPES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_deliveries_type($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->deliveriestypes_num_admin) && !empty($this->settings->deliveriestypes_num_admin)) {
        $this->items_per_page = intval($this->settings->deliveriestypes_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = DELIVERIESTYPES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_DELIVERIESTYPES_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Типы доставки';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список типов доставки на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_deliveries_types($items, $params);
      $this->db->fix_deliveries_types_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи типов доставки оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_deliveries_types($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_DELIVERIESTYPES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс DeliveriesType (админ модуль страницы типа доставки)
  // =========================================================================

  class DeliveriesType extends DeliveriesTypes {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_DELIVERIESTYPE_CLASS_RESULT_PAGE;



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
      // если нет данных типа доставки или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый тип доставки';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_deliveries_type($this->item, $params);
      }

      // если данные типа доставки получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование типа доставки "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_deliveries_types_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_DELIVERIESTYPE_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс ShippingsTerms (админ модуль списка сроков отправки)
  // =========================================================================

  class ShippingsTerms extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'shippings_terms';
    public $dbtable_field = 'term_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_SHIPPINGSTERMS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_shippings_term($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->shippingsterms_num_admin) && !empty($this->settings->shippingsterms_num_admin)) {
        $this->items_per_page = intval($this->settings->shippingsterms_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = SHIPPINGSTERMS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_SHIPPINGSTERMS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Сроки отправки';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список сроков отправки на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_shippings_terms($items, $params);
      $this->db->fix_shippings_terms_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи сроков отправки оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_shippings_terms($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SHIPPINGSTERMS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс ShippingsTerm (админ модуль страницы срока отправки)
  // =========================================================================

  class ShippingsTerm extends ShippingsTerms {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SHIPPINGSTERM_CLASS_RESULT_PAGE;



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
      // если нет данных срока отправки или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый срок отправки';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_shippings_term($this->item, $params);
      }

      // если данные срока отправки получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование срока отправки "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_shippings_terms_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SHIPPINGSTERM_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Currencies (админ модуль списка валют)
  // =========================================================================

  class Currencies extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'currencies';
    public $dbtable_field = 'currency_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_CURRENCIES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обработка изменения поля CODE записи ==================================

    protected function process_iso_code (&$item, $id, &$cancel) {

      // если есть данные о ISO коде
      if (isset($_POST['code'][$id])) {
        $value = trim($_POST['code'][$id]);
        if ($value == '') {
          $cancel = $this->push_error('Не указан код ISO.');
        } else {
          $item->code = $value;
        }
      }
    }

    // обработка изменения поля SIGN записи ==================================

    protected function process_sign (&$item, $id, &$cancel) {

      // если есть данные о знаке валюты
      if (isset($_POST['sign'][$id])) {
        $value = trim($_POST['sign'][$id]);
        if ($value == '') {
          $cancel = $this->push_error('Не указан знак (надпись) валюты.');
        } else {
          $item->sign = $value;
        }
      }
    }

    // обработка изменения полей RATE_FROM, RATE_TO записи ===================

    protected function process_rate_from_to (&$item, $id, &$cancel) {

      // если есть данные о курсе
      if (isset($_POST['rate_from'][$id])) {
        $value = round($this->number->floatValue($_POST['rate_from'][$id]), 4);
        if ($value <= 0) {
          $cancel = $this->push_error('Курс должен быть больше нуля.');
        } else {
          $item->rate_from = $value;
        }
      }

      // если есть данные об обратном курсе
      if (isset($_POST['rate_to'][$id])) {
        $value = round($this->number->floatValue($_POST['rate_to'][$id]), 4);
        if ($value <= 0) {
          $cancel = $this->push_error('Обратный курс должен быть больше нуля.');
        } else {
          $item->rate_to = $value;
        }
      }
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_currency($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {

      // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
      $this->db->reset_currencies_caches();
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->currencies_num_admin) && !empty($this->settings->currencies_num_admin)) {
        $this->items_per_page = intval($this->settings->currencies_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = CURRENCIES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_CURRENCIES_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 0;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Валюты сайта';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список валют на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_currencies($items, $params);
      $this->db->fix_currencies_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи валют оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_currencies($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_CURRENCIES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Currency (админ модуль страницы валюты)
  // =========================================================================

  class Currency extends Currencies {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_CURRENCY_CLASS_RESULT_PAGE;



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
      // если нет данных валюты или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новая валюта';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_currency($this->item, $params);
      }

      // если данные валюты получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование валюты "' . (isset($this->item->name) ? $this->item->name : '') . '"';
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_currencies_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
        $this->item->enabled = 1;
        $this->item->main = 0;
        $this->item->def = 0;
        $this->item->defa = 0;
        $this->item->ymarket = 0;
        $this->item->rate_from = 1;
        $this->item->rate_to = 1;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_CURRENCY_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Payments (админ модуль списка способов оплаты)
  // =========================================================================

  class Payments extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_PAYMENT_METHODS_TABLENAME;
    public $dbtable_field = 'payment_method_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_PAYMENTS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

        // приказываем объекту базы данных обновить/добавить указанную запись
        return $this->db->payments->update($item);
    }



    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->payments_num_admin) && !empty($this->settings->payments_num_admin)) {
        $this->items_per_page = intval($this->settings->payments_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = PAYMENTS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_PAYMENTS_MODE_AS_IS;
      $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_STANDARD;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Способы оплаты';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список способов доставки на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $items = null;
      $count = $this->db->payments->get($items, $params);
      $this->db->payments->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи способов оплаты оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->payments->operable($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_PAYMENTS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Users (админ модуль списка пользователей)
  // =========================================================================

  class Users extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_USERS_TABLENAME;
    public $dbtable_field = 'user_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_USERS_ON_PAGE_IN_ADMIN;

    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array('all_users');



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

        // приказываем объекту базы данных обновить/добавить указанную запись
        return $this->db->users->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {

        // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
        $this->db->users->resetCaches();
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->users_num_admin) && !empty($this->settings->users_num_admin)) {
        $this->items_per_page = intval($this->settings->users_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = USERS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_USERS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_FULL;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Зарегистрированные пользователи';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список пользователей на текущей странице согласно параметрам фильтра и сортировки
      $items = null;
      $params->used_shop = 1;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->users->get($items, $params);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->group_id)) $this->params[REQUEST_PARAM_NAME_FILTER_GROUP] = $params->group_id;
      if (isset($params->affiliate_id)) $this->params[REQUEST_PARAM_NAME_FILTER_PARTNER] = $params->affiliate_id;
      if (isset($params->country_id)) $this->params[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $params->country_id;
      if (isset($params->region_id)) $this->params[REQUEST_PARAM_NAME_FILTER_REGION] = $params->region_id;
      if (isset($params->town_id)) $this->params[REQUEST_PARAM_NAME_FILTER_TOWN] = $params->town_id;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи учащихся оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->users->operable($items, $params);

      // читаем дерево городов
      $this->db->get_towns_tree($towns);

      // читаем группы пользователей
      $this->db->get_groups_array($groups, GET_GROUPS_MODE_FOR_AUTHORIZED);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_TOWNS, $towns);
      $this->smarty->assignByRef(SMARTY_VAR_GROUPS, $groups);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_USERS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс User (админ модуль страницы пользователя)
  // =========================================================================

  class User2 extends Users {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_USER_CLASS_RESULT_PAGE;



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
      // если нет данных пользователя или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый пользователь';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
          $params = new stdClass;
          $params->id = $id;
          $this->db->users->one($this->item, $params);
      }

      // если данные пользователя получены,
      //   меняем заголовок страницы,
      //   выправляем текст заведения согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование пользователя ' . (isset($this->item->name) ? $this->db->users->compoundUserName($this->item) : '');
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->users->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->used_shop = 1;
        $this->item->used_dnevnik = 0;
        $this->item->used_social = 1;
      }

      // читаем дерево городов (только непустые ветви)
      $this->db->get_towns_tree($towns, TRUE);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_TOWNS, $towns);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_USER_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Countries (админ модуль списка стран)
  // =========================================================================

  class Countries extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'countries';
    public $dbtable_field = 'country_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_COUNTRIES_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_COUNTRIES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->countries_files_folder_prefix . $this->upload_folder;
    }

    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

        // приказываем объекту базы данных обновить/добавить указанную запись
        return $this->db->countries->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->countries_num_admin) && !empty($this->settings->countries_num_admin)) {
        $this->items_per_page = intval($this->settings->countries_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = COUNTRIES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_COUNTRIES_MODE_AS_IS;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Страны';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список стран на текущей странице согласно параметрам фильтра и сортировки
      $items = null;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->countries->get($items, $params);
      $this->db->countries->unpackRecords($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи стран оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->countries->operable($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_COUNTRIES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Country (админ модуль страницы страны)
  // =========================================================================

  class Country extends Countries {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_COUNTRY_CLASS_RESULT_PAGE;



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
      // если нет данных страны или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новая страна';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->countries->one($this->item, $params);
      }

      // если данные страны получены,
      //   меняем заголовок страницы,
      //   выправляем текст страны согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование страны ' . (isset($this->item->name) ? $this->item->name : '');
        if ($this->settings->countries_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->countries_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->countries_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->countries->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->browsed = 0;
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_COUNTRY_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Regions (админ модуль списка областей)
  // =========================================================================

  class Regions extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'regions';
    public $dbtable_field = 'region_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_REGIONS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_REGIONS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->regions_files_folder_prefix . $this->upload_folder;
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_region($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->regions_num_admin) && !empty($this->settings->regions_num_admin)) {
        $this->items_per_page = intval($this->settings->regions_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = REGIONS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_REGIONS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Области';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список областей на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_regions($items, $params);
      $this->db->fix_regions_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->country_id)) $this->params[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $params->country_id;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи областей оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_regions($items, $params);

      // читаем дерево стран
      $countries = null;
      $this->db->countries->getTree($countries);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_COUNTRIES, $countries);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_REGIONS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Region (админ модуль страницы области)
  // =========================================================================

  class Region extends Regions {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_REGION_CLASS_RESULT_PAGE;



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
      // если нет данных области или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новая область';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_region($this->item, $params);
      }

      // если данные области получены,
      //   меняем заголовок страницы,
      //   выправляем текст области согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование области ' . (isset($this->item->name) ? $this->item->name : '');
        if ($this->settings->regions_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->regions_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->regions_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_regions_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->browsed = 0;
      }

      // читаем дерево стран
      $countries = null;
      $this->db->countries->getTree($countries);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_COUNTRIES, $countries);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_REGION_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Towns (админ модуль списка городов)
  // =========================================================================

  class Towns extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'towns';
    public $dbtable_field = 'town_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_TOWNS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_TOWNS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->towns_files_folder_prefix . $this->upload_folder;
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_town($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->towns_num_admin) && !empty($this->settings->towns_num_admin)) {
        $this->items_per_page = intval($this->settings->towns_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = TOWNS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_TOWNS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Города';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список городов на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_towns($items, $params);
      $this->db->fix_towns_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->country_id)) $this->params[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $params->country_id;
      if (isset($params->region_id)) $this->params[REQUEST_PARAM_NAME_FILTER_REGION] = $params->region_id;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи городов оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_towns($items, $params);

      // читаем дерево областей
      $this->db->get_regions_tree($regions);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_REGIONS, $regions);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_TOWNS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Town (админ модуль страницы города)
  // =========================================================================

  class Town extends Towns {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_TOWN_CLASS_RESULT_PAGE;



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
      // если нет данных города или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый город';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_town($this->item, $params);
      }

      // если данные города получены,
      //   меняем заголовок страницы,
      //   выправляем текст города согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование города ' . (isset($this->item->name) ? $this->item->name : '');
        if ($this->settings->towns_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->towns_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->towns_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_towns_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->browsed = 0;
      }

      // читаем дерево областей (только непустые ветви)
      $this->db->get_regions_tree($regions, TRUE);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_REGIONS, $regions);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_TOWN_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Schools (админ модуль списка учебных заведений)
  // =========================================================================

  class Schools extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'schools';
    public $dbtable_field = 'school_id';

    // в какую папку выгружать изображения,
    // сколько записей размещать на странице
    public $upload_folder = ADMIN_SCHOOLS_CLASS_UPLOAD_FOLDER;
    protected $items_per_page = DEFAULT_VALUE_FOR_SCHOOLS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // добавляем префикс папки изображений
        $this->upload_folder = $this->settings->schools_files_folder_prefix . $this->upload_folder;
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_school($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->schools_num_admin) && !empty($this->settings->schools_num_admin)) {
        $this->items_per_page = intval($this->settings->schools_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = SCHOOLS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_SCHOOLS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Учебные заведения';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список учебных заведений на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_schools($items, $params);
      $this->db->fix_schools_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->country_id)) $this->params[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $params->country_id;
      if (isset($params->region_id)) $this->params[REQUEST_PARAM_NAME_FILTER_REGION] = $params->region_id;
      if (isset($params->town_id)) $this->params[REQUEST_PARAM_NAME_FILTER_TOWN] = $params->town_id;
      if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
      if (isset($params->imaged)) $this->params[REQUEST_PARAM_NAME_FILTER_IMAGED] = $params->imaged;
      if (isset($params->SEOed)) $this->params[REQUEST_PARAM_NAME_FILTER_SEOED] = $params->SEOed;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи учебных заведений оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_schools($items, $params);

      // читаем дерево городов
      $this->db->get_towns_tree($towns);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_TOWNS, $towns);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс School (админ модуль страницы учебного заведения)
  // =========================================================================

  class School extends Schools {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SCHOOL_CLASS_RESULT_PAGE;



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
      // если нет данных учебного заведения или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новое учебное заведение';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_school($this->item, $params);
      }

      // если данные учебного заведения получены,
      //   меняем заголовок страницы,
      //   выправляем текст заведения согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование учебного заведения ' . (isset($this->item->name) ? $this->item->name : '');
        if ($this->settings->schools_wysiwyg_disabled == 1) {
          if (isset($this->item->description)) $this->item->description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->description, $this->settings->schools_wysiwyg_disabled_mode);
          if (isset($this->item->seo_description)) $this->item->seo_description = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->seo_description, $this->settings->schools_wysiwyg_disabled_mode);
          if (isset($this->item->collective1)) $this->item->collective1 = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->collective1, $this->settings->schools_wysiwyg_disabled_mode);
          if (isset($this->item->collective2)) $this->item->collective2 = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->collective2, $this->settings->schools_wysiwyg_disabled_mode);
          if (isset($this->item->collective3)) $this->item->collective3 = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->collective3, $this->settings->schools_wysiwyg_disabled_mode);
          if (isset($this->item->collective4)) $this->item->collective4 = $this->db->fix_HTML_text_for_simple_TEXTAREA_object($this->item->collective4, $this->settings->schools_wysiwyg_disabled_mode);
        }
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_schools_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->browsed = 0;
        $this->item->lessons_ids = array();
        $this->item->classes_ids = array();
      }

      // читаем дерево городов (только непустые ветви)
      $this->db->get_towns_tree($towns, TRUE);

      // читаем список типов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSTYPES_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_types($types, $params);
      $this->db->fix_schools_types_records($types);

      // читаем список предметов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSLESSONS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_lessons($lessons, $params);
      $this->db->fix_schools_lessons_records($lessons);

      // читаем список классов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSCLASSES_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_classes($classes, $params);
      $this->db->fix_schools_classes_records($classes);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_TOWNS, $towns);
      $this->smarty->assignByRef(SMARTY_VAR_TYPES, $types);
      $this->smarty->assignByRef(SMARTY_VAR_LESSONS, $lessons);
      $this->smarty->assignByRef(SMARTY_VAR_CLASSES, $classes);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOL_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsTypes (админ модуль списка типов учебных заведений)
  // =========================================================================

  class SchoolsTypes extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'schools_types';
    public $dbtable_field = 'type_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_SCHOOLSTYPES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_schools_type($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->schoolstypes_num_admin) && !empty($this->settings->schoolstypes_num_admin)) {
        $this->items_per_page = intval($this->settings->schoolstypes_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = SCHOOLSTYPES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_SCHOOLSTYPES_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Типы учебных заведений';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список типов учебных заведений на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_schools_types($items, $params);
      $this->db->fix_schools_types_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи типов учебных заведений оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_schools_types($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSTYPES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsType (админ модуль страницы типа учебного заведения)
  // =========================================================================

  class SchoolsType extends SchoolsTypes {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SCHOOLSTYPE_CLASS_RESULT_PAGE;



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
      // если нет данных типа учебного заведения или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый тип учебного заведения';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_schools_type($this->item, $params);
      }

      // если данные типа учебного заведения получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование типа учебного заведения ' . (isset($this->item->name) ? $this->item->name : '');
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_schools_types_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSTYPE_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsLessons (админ модуль списка предметов учебных заведений)
  // =========================================================================

  class SchoolsLessons extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'schools_lessons';
    public $dbtable_field = 'lesson_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_SCHOOLSLESSONS_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_schools_lesson($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->schoolslessons_num_admin) && !empty($this->settings->schoolslessons_num_admin)) {
        $this->items_per_page = intval($this->settings->schoolslessons_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = SCHOOLSLESSONS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_SCHOOLSLESSONS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Предметы учебных заведений';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список предметов учебных заведений на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_schools_lessons($items, $params);
      $this->db->fix_schools_lessons_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи предметов учебных заведений оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_schools_lessons($items, $params);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSLESSONS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsLesson (админ модуль страницы типа учебного заведения)
  // =========================================================================

  class SchoolsLesson extends SchoolsLessons {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SCHOOLSLESSON_CLASS_RESULT_PAGE;



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
      // если нет данных предмета учебного заведения или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый предмет учебного заведения';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_schools_lesson($this->item, $params);
      }

      // если данные предмета учебного заведения получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование предмета учебного заведения ' . (isset($this->item->name) ? $this->item->name : '');
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_schools_lessons_record($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->name = '';
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSLESSON_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsClasses (админ модуль списка классов учебных заведений)
  // =========================================================================

  class SchoolsClasses extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = 'schools_classes';
    public $dbtable_field = 'class_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_SCHOOLSCLASSES_ON_PAGE_IN_ADMIN;



    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_schools_class($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->schoolsclasses_num_admin) && !empty($this->settings->schoolsclasses_num_admin)) {
        $this->items_per_page = intval($this->settings->schoolsclasses_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = SCHOOLSCLASSES_SESSION_PARAM_NAME;
      $defaults->sort = SORT_SCHOOLSCLASSES_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Классы учебных заведений';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $this->collect_inputs($inputs, $params, $defaults);

      // читаем список классов учебных заведений на текущей странице согласно параметрам фильтра и сортировки
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->get_schools_classes($items, $params);
      $this->db->fix_schools_classes_records($items);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи классов учебных заведений оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_schools_classes($items, $params);

      // читаем список предметов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSLESSONS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_lessons($lessons, $params);
      $this->db->fix_schools_lessons_records($lessons);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_LESSONS, $lessons);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSCLASSES_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsClass (админ модуль страницы класса учебного заведения)
  // =========================================================================

  class SchoolsClass extends SchoolsClasses {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SCHOOLSCLASS_CLASS_RESULT_PAGE;



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
      // если нет данных класса учебного заведения или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый класс учебного заведения';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
        $params = new stdClass;
        $params->id = $id;
        $this->db->get_schools_class($this->item, $params);
      }

      // если данные класса учебного заведения получены,
      //   меняем заголовок страницы,
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование класса учебного заведения ' . (isset($this->item->name) ? $this->item->name : '');
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->fix_schools_classes_record($this->item);
        // проверяем формат важных полей
        if (!isset($this->item->lessons_ids)) $this->item->lessons_ids = array();
        if (is_string($this->item->lessons_ids)) $this->item->lessons_ids = explode(',', $this->item->lessons_ids);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->lessons_ids = array();
      }

      // читаем список предметов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSLESSONS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_lessons($lessons, $params);
      $this->db->fix_schools_lessons_records($lessons);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_LESSONS, $lessons);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSCLASS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsLearners (админ модуль списка учащихся)
  // =========================================================================

  class SchoolsLearners extends Products {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    public $dbtable = DATABASE_USERS_TABLENAME;
    public $dbtable_field = 'user_id';

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_SCHOOLSLEARNERS_ON_PAGE_IN_ADMIN;

    // список упреждающего наполнения шаблонизируемых переменных
    public $preassignable = array();



    // конструктор класса ====================================================

    public function __construct ( & $parent, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }

    // обновление записи в базе данных =======================================

    protected function update ( & $item ) {

        // приказываем объекту базы данных обновить/добавить указанную запись
        return $this->db->users->update($item);
    }

    // очистка соответствующих кеш-таблиц ====================================

    protected function resetCaches () {

        // приказываем объекту базы данных безусловно очистить нужные кеш-таблицы
        $this->db->users->resetCaches();
    }

    // уведомление участников об изменениях в записи =========================

    protected function inform (&$item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE) {
    }

    // обработка изменения поля GRADES записи ================================

    protected function process_grades (&$item, $id, &$cancel) {

      // если получены данные об оценках
      if (isset($_POST['grades'][$id])) {

        // читаем данные о пользователе
        $user = null;
        $params = new stdClass;
        $params->id = $id;
        $this->db->users->one($user, $params);

        // берем оценки пользователя
        $item->grades = isset($user->grades) ? $user->grades : array();

        if (is_array($_POST['grades'][$id])) {

          // перебираем предметы
          foreach ($_POST['grades'][$id] as $lesson_id => &$lesson) {
            $lesson_id = intval($lesson_id);
            if (!empty($lesson_id) && is_array($lesson)) {
              if (!isset($item->grades[$lesson_id])) $item->grades[$lesson_id] = array();

              // перебираем года
              foreach ($lesson as $year_id => &$year) {
                $year_id = intval($year_id);
                if (($year_id >= 1900) && ($year_id <= 2100) && is_array($year)) {
                  if (!isset($item->grades[$lesson_id][$year_id])) $item->grades[$lesson_id][$year_id] = array();

                  // перебираем месяцы
                  foreach ($year as $month_id => &$month) {
                    $month_id = intval($month_id);
                    if (($month_id >= 1) && ($month_id <= 12) && is_array($month)) {
                      if (!isset($item->grades[$lesson_id][$year_id][$month_id])) $item->grades[$lesson_id][$year_id][$month_id] = array();

                      // перебираем дни
                      foreach ($month as $day_id => &$day) {
                        $day_id = intval($day_id);
                        if (($day_id >= 1) && ($day_id <= 31)) {
                          $item->grades[$lesson_id][$year_id][$month_id][$day_id] = is_string($day) ? trim($day) : '';
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }

        // упаковываем сведения об оценках
        $item->grades = @serialize($item->grades);
      }
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

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (isset($this->settings->schoolslearners_num_admin) && !empty($this->settings->schoolslearners_num_admin)) {
        $this->items_per_page = intval($this->settings->schoolslearners_num_admin);
      }
      if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
      if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = SCHOOLSLEARNERS_SESSION_PARAM_NAME;
      $defaults->sort = SORT_USERS_MODE_BY_NAME;
      $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
      $defaults->sort_laconical = 1;
      $defaults->view_mode = VIEW_MODE_COMPACT;
      $defaults->filter_manually = 0;

      // обрабатываем соответствующие модулю настройки сайта,
      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process_setup();
      $this->process($defaults);
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Учащиеся';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, $defaults);

      // если еще не выбран месяц и год, взять текущие
      if (!isset($inputs[REQUEST_PARAM_NAME_FILTER_MONTH])) $inputs[REQUEST_PARAM_NAME_FILTER_MONTH] = date('n', time());
      if (!isset($inputs[REQUEST_PARAM_NAME_FILTER_YEAR])) $inputs[REQUEST_PARAM_NAME_FILTER_YEAR] = date('Y', time());

      // вычисляем количество дней в выбранном месяце
      $time = mktime(0, 0, 0, $inputs[REQUEST_PARAM_NAME_FILTER_MONTH], 1, $inputs[REQUEST_PARAM_NAME_FILTER_YEAR]);
      $inputs[REQUEST_PARAM_NAME_FILTER_DAY] = date('t', $time);
      $inputs['week_day'] = date('w', $time);

      // читаем список учащихся на текущей странице согласно параметрам фильтра и сортировки
      $items = null;
      $params->used_dnevnik = 1;
      $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->users->get($items, $params);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->country_id)) $this->params[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $params->country_id;
      if (isset($params->region_id)) $this->params[REQUEST_PARAM_NAME_FILTER_REGION] = $params->region_id;
      if (isset($params->town_id)) $this->params[REQUEST_PARAM_NAME_FILTER_TOWN] = $params->town_id;
      if (isset($params->school_id)) $this->params[REQUEST_PARAM_NAME_FILTER_SCHOOL] = $params->school_id;
      if (isset($params->class_id)) $this->params[REQUEST_PARAM_NAME_FILTER_CLASS] = $params->class_id;
      if (isset($params->lesson_id)) $this->params[REQUEST_PARAM_NAME_FILTER_LESSON] = $params->lesson_id;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи учащихся оперативные ссылки админпанели
      $params->token = $this->token;
      $params->list_module = 'SchoolsLearners';
      $params->edit_module = 'SchoolsLearner';
      $this->db->users->operable($items, $params);

      // читаем дерево школ
      $this->db->get_schools_tree($schools);

      // читаем список предметов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSLESSONS_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_lessons($lessons, $params);
      $this->db->fix_schools_lessons_records($lessons);

      // читаем список классов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSCLASSES_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_classes($classes, $params);
      $this->db->fix_schools_classes_records($classes);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_SCHOOLS, $schools);
      $this->smarty->assignByRef(SMARTY_VAR_LESSONS, $lessons);
      $this->smarty->assignByRef(SMARTY_VAR_CLASSES, $classes);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSLEARNERS_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс SchoolsLearner (админ модуль страницы учащегося)
  // =========================================================================

  class SchoolsLearner extends SchoolsLearners {

    // рекомендуемая страница возврата после операции
    public $result_page = ADMIN_SCHOOLSLEARNER_CLASS_RESULT_PAGE;



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
      // если нет данных учащегося или они изменились,
      //   читаем их из базы данных
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый учащийся';
      if ((empty($this->item) || $this->changed) && !empty($id)) {
          $params = new stdClass;
          $params->id = $id;
          $this->db->users->one($this->item, $params);
      }

      // если данные учащегося получены,
      //   меняем заголовок страницы,
      //   выправляем текст заведения согласно настройкам сайта
      if (!empty($this->item)) {
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование учащегося ' . (isset($this->item->name) ? $this->db->users->compoundUserName($this->item) : '');
        // если данные получены не из базы данных
        if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->users->unpack($this->item);
      } else {
        // инициируем важные поля новой записи
        $this->item = new stdClass;
        $this->item->enabled = 1;
        $this->item->used_shop = 0;
        $this->item->used_dnevnik = 1;
        $this->item->used_social = 1;
      }

      // читаем дерево школ (только непустые ветви)
      $this->db->get_schools_tree($schools, TRUE);

      // читаем список классов учебных заведений
      $params = new stdClass;
      $params->sort = SORT_SCHOOLSCLASSES_MODE_BY_NAME;
      $params->sort_direction = SORT_DIRECTION_ASCENDING;
      $this->db->get_schools_classes($classes, $params);
      $this->db->fix_schools_classes_records($classes);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
      $this->smarty->assignByRef(SMARTY_VAR_SCHOOLS, $schools);
      $this->smarty->assignByRef(SMARTY_VAR_CLASSES, $classes);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_SCHOOLSLEARNER_CLASS_TEMPLATE_FILE);

      return TRUE;
    }
  }



  return;
?>