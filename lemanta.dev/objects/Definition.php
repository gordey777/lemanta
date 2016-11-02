<?php
    // Impera CMS: файл констант,
    //             загрузчик конфигурации,
    //             контроллер редиректов.
    // Copyright AIMatrix, 2012.
    // http://imperacms.ru

    if (!defined('ROOT_FOLDER_REFERENCE')) define('ROOT_FOLDER_REFERENCE', '');
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) define('FOLDERNAME_FOR_ENGINE_OBJECTS', 'objects');
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) define('FILENAME_FOR_ENGINE_DEFINITION_OBJECT', 'Definition.php');

    // номер версии Impera CMS (формат: по 2 цифры года, месяца и дня последнего обновления)
    define('IMPERA_CMS_CURRENT_VERSION', '150524');
    define('IMPERA_CMS_CURRENT_MMVERSION', '2.1.5');

    // количество секунд в минуте, часе, сутках
    if (!defined('SECONDS_IN_MINUTE')) define('SECONDS_IN_MINUTE', 60);
    if (!defined('SECONDS_IN_HOUR')) define('SECONDS_IN_HOUR', 60 * SECONDS_IN_MINUTE);
    if (!defined('SECONDS_IN_DAY')) define('SECONDS_IN_DAY', 24 * SECONDS_IN_HOUR);

    // максимальное количество типов цен
    define('PRICE_TYPES_MAXCOUNT', 10);

    // максимальный размер названия типа цены
    define('PRICE_TYPE_MAXSIZE', 40);

    // по умолчанию админпанель располагается в такой папке,
    // название динамического параметра для администратора
    define('FOLDERNAME_FOR_ADMIN_PANEL', 'admin');
    if (!defined('SESSION_PARAM_NAME_ADMIN')) define('SESSION_PARAM_NAME_ADMIN', 'admin');

    // имена файлов модулей ядра CMS (для файлов Config и SEO_handler звездочка обозначает место подстановки домена магазина)
    define('FILENAME_FOR_ENGINE_DATABASE_OBJECT', 'Database.php');
    define('FILENAME_FOR_ENGINE_BASIC_OBJECT', 'Basic.php');
    define('FILENAME_FOR_ENGINE_ARTICLES_OBJECT', 'Articles.php');
    define('FILENAME_FOR_ENGINE_ACCOUNT_OBJECT', 'Account.php');
    define('FILENAME_FOR_ENGINE_LOGIN_OBJECT', 'Login.php');
    define('FILENAME_FOR_ENGINE_FEEDBACK_OBJECT', 'Feedback.php');
    define('FILENAME_FOR_ENGINE_COMPARE_OBJECT', 'Compare.php');
    define('FILENAME_FOR_ENGINE_ORDER_OBJECT', 'Order.php');
    define('FILENAME_FOR_ENGINE_REGISTRATION_OBJECT', 'Registration.php');
    define('FILENAME_FOR_ENGINE_SITEMAP_OBJECT', 'Sitemap.php');
    define('FILENAME_FOR_ENGINE_STATICPAGECORE_OBJECT', 'StaticPage.core.php');
    define('FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT', 'Admin.Page.php');
    define('FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT', 'Admin.Articles.php');
    define('FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT', 'Admin.Categories.php');
    define('FILENAME_FOR_ENGINE_ADMIN_BACKUP_OBJECT', 'Admin.Backup.php');
    define('FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT', 'Admin.Posts.php');
    define('FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT', 'Admin.Products.php');
    define('FILENAME_FOR_ENGINE_CONFIG_OBJECT', 'Config*.php');



    // имя файла сведений о редиректах (звездочка обозначает место подстановки домена магазина)
    define('FILENAME_FOR_REDIRECTS_INFO', 'redirects*.txt');

    // значение паузы между приемом сообщений запроса связи "Позвоните мне" от одного источника
    define('POST_NEXT_CALLME_LIFETIME', 3600);

    // значение паузы между приемом заявок подключения к уведомлению от одного источника
    define('POST_NEXT_NOTIFYME_LIFETIME', 60);

    // значение паузы между приемом мгновенных заказов от одного источника
    define('POST_NEXT_FULMINANTORDER_LIFETIME', 30);

    define('EXTERNAL_IMAGES_CACHING_LIFETIME', intval(7 * 1440 * SECONDS_IN_MINUTE));
    define('EXTERNAL_IMAGES_CACHING_FILELIMIT', 5);
    define('EXTERNAL_IMAGES_CACHING_TIMELIMIT', 5);

    // имена файлов о технических и профилактических работах (звездочка обозначает место подстановки домена магазина)
    define('TECHNICAL_WORKS_INFO_FILENAME', '---technical-works-now*.htm');
    define('UPDATING_WORKS_INFO_FILENAME', '---updating-works-now*.htm');

    define('MAILER_TEMPLATES_FILENAME_PATTERN', 'mailer.template*.txt');
    define('MAILER_TEMPLATES_MAX_COUNT', 200);
    define('MAILER_MAILLISTS_FILENAME_PATTERN', 'mailer.maillist*.txt');
    define('MAILER_MAILLISTS_MAX_COUNT', 200);

    define('CONFIG_PAGES_IN_CATALOG', FALSE);

    // шаблоны валидации емейла, телефона, номера ICQ и Skype-имени
    define('EMAIL_CHECKING_PATTERN', '/^[a-z0-9_\+\-]+(\.[a-z0-9_\+\-]+)*@[a-z0-9\-]+(\.[a-z0-9\-]+)*\.[a-z]{2,6}$/i');
    define('PHONE_CHECKING_PATTERN', '/^\+?[0-9\-\(\)\s]+?[0-9]+$/s');
    define('ICQ_CHECKING_PATTERN', '/^[0-9]{5,15}$/');
    define('SKYPE_CHECKING_PATTERN', '/^[a-z0-9_\-]+(\.[a-z0-9_\-]+)*$/i');

    // ISO коды валют
    define('WORLD_CURRENCY_CODES', 'AED, AFN, ALL, AMD, ANG, AOA, ARS, AUD, AWG, AZN, BAM, BBD, BDT, BGN, BHD, BIF, BMD, BND, BOB, BRL, BSD, BTN, BWP, BYR, BZD, CAD, CDF, CHF, CLP, CNY, COP, CRC, RSD, CUP, CVE, CYP, CZK, DJF, DKK, DOP, DZD, EEK, EGP, ERN, ETB, EUR, FJD, FKP, GBP, GEL, GHC, GIP, GMD, GNF, GTQ, GYD, HKD, HNL, HRK, HTG, HUF, IDR, ILS, INR, IQD, IRR, ISK, JMD, JOD, JPY, KES, KGS, KHR, KMF, KPW, KRW, KWD, KYD, KZT, LAK, LBP, LKR, LRD, LSL, LTL, LVL, LYD, MAD, MDL, MGA, MKD, MMK, MNT, MOP, MRO, MTL, MUR, MVR, MWK, MXN, MYR, MZN, NAD, NGN, NIO, NOK, NPR, NZD, OMR, PAB, PEN, PGK, PHP, PKR, PLN, PYG, QAR, RON, RUB, RUR, RWF, SAR, SBD, SCR, SDG, SEK, SGD, SHP, SIT, SKK, SLL, SOS, SRD, STD, SYP, SZL, THB, TJS, TMM, TMT, TND, TOP, TRY, TTD, TWD, TZS, UAH, UGX, USD, UYI, UZS, VEB, VND, VUV, WST, XAF, XAG, XAU, XBA, XBB, XBC, XBD, XCD, XDR, XFO, XFU, XOF, XPD, XPF, XPT, XTS, XXX, YER, YUM, ZAR, ZMK, ZWD');

    // стандартные количества элементов в блочных списках
    define('DEFAULT_VALUE_FOR_PRODUCTS_HIT_COUNT', 8);
    define('DEFAULT_VALUE_FOR_PRODUCTS_NEWEST_COUNT', 6);
    define('DEFAULT_VALUE_FOR_PRODUCTS_ACTIONAL_COUNT', 4);
    define('DEFAULT_VALUE_FOR_PRODUCTS_AWAITED_COUNT', 2);
    define('DEFAULT_VALUE_FOR_PRODUCTS_ORDERED_COUNT', 4);
    define('DEFAULT_VALUE_FOR_PRODUCTS_COMMENTED_COUNT', 4);
    define('DEFAULT_VALUE_FOR_ARTICLES_COUNT', 6);
    define('DEFAULT_VALUE_FOR_NEWS_COUNT', 6);
    define('DEFAULT_VALUE_FOR_PRODUCTS_IN_COMPARE', 4);

    define('DEFAULT_VALUE_FOR_SEARCH_PRODUCTS_MAX_COUNT', 50);

    // стандартные количества товаров в списках на главной странице при отсутствии листания страниц
    define('DEFAULT_VALUE_FOR_CATALOG_PRODUCTS_MAX_COUNT', 30);



    // количества элементов на страницах админпанели
    define('DEFAULT_VALUE_FOR_ARTICLES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_NEWS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SECTIONS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_FILES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_MENUS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_MODULES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_IMPORTS_ON_PAGE_IN_ADMIN', 25);
    define('DEFAULT_VALUE_FOR_PRODUCTS_ON_PAGE_IN_ADMIN', 25);
    define('DEFAULT_VALUE_FOR_PRODUCTSKITS_ON_PAGE_IN_ADMIN', 25);
    define('DEFAULT_VALUE_FOR_PROPERTIES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_STOCKS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_ORDERS_ON_PAGE_IN_ADMIN', 25);
    define('DEFAULT_VALUE_FOR_ORDERSPHASES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_PAYMENTSHISTORY_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_CREDITPROGRAMS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_COUNTRIES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_REGIONS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_TOWNS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SCHOOLS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SCHOOLSTYPES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SCHOOLSLESSONS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SCHOOLSCLASSES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SCHOOLSLEARNERS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_DELIVERIES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_DELIVERIESTYPES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_SHIPPINGSTERMS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_PAYMENTS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_CURRENCIES_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_USERS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_GROUPS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_BANNEDS_ON_PAGE_IN_ADMIN', 50);
    define('DEFAULT_VALUE_FOR_COMMENTS_ON_PAGE_IN_ADMIN', 10);
    define('DEFAULT_VALUE_FOR_ARTICLESCOMMENTS_ON_PAGE_IN_ADMIN', 10);
    define('DEFAULT_VALUE_FOR_NEWSCOMMENTS_ON_PAGE_IN_ADMIN', 10);
    define('DEFAULT_VALUE_FOR_FEEDBACK_ON_PAGE_IN_ADMIN', 10);
    define('DEFAULT_VALUE_FOR_CALLME_ON_PAGE_IN_ADMIN', 25);
    define('DEFAULT_VALUE_FOR_SEARCHES_ON_PAGE_IN_ADMIN', 25);



    // количества элементов на страницах клиентской стороны
    define('DEFAULT_VALUE_FOR_PRODUCTS_ON_PAGE_IN_CLIENT', 20);
    define('DEFAULT_VALUE_FOR_ARTICLES_ON_PAGE_IN_CLIENT', 16);
    define('DEFAULT_VALUE_FOR_NEWS_ON_PAGE_IN_CLIENT', 16);
    define('DEFAULT_VALUE_FOR_ARTICLESCOMMENTS_ON_PAGE_IN_CLIENT', 8);
    define('DEFAULT_VALUE_FOR_NEWSCOMMENTS_ON_PAGE_IN_CLIENT', 8);
    define('DEFAULT_VALUE_FOR_FILES_ON_PAGE_IN_CLIENT', 16);
    define('DEFAULT_VALUE_FOR_STOCKS_ON_PAGE_IN_CLIENT', 16);

    // предельные значения количества элементов на странице
    define('ITEMS_PER_PAGE_MINIMAL_VALUE', 1);
    define('ITEMS_PER_PAGE_MAXIMAL_VALUE', 1000);

    define('REAL_RECOMPUTING_CATEGORY_PRODUCTS_COUNT', TRUE);
    define('FAST_RECOMPUTING_CATEGORY_PRODUCTS_COUNT', FALSE);
    define('REAL_RECOMPUTING_PRODUCT_ORDERS_COUNT', TRUE);
    define('FAST_RECOMPUTING_PRODUCT_ORDERS_COUNT', FALSE);

    define('GET_PRODUCT_VARIANT_AS_FULL_PRODUCT', '*');
    define('GET_PRODUCT_VARIANT_AS_PRODUCT', TRUE);
    define('GET_PRODUCT_VARIANT_AS_VARIANT', FALSE);
    define('GET_PRODUCT_VARIANT_MODE_VARIANT_OR_PRODUCT', TRUE);
    define('GET_PRODUCT_VARIANT_MODE_VARIANT_ONLY', FALSE);
    define('IGNORE_SHOP_SECTION_CONTROL', 0);

    define('WITH_SORTING_PRODUCTS_FLAG', TRUE);
    define('DONT_SORTING_PRODUCTS_FLAG', FALSE);
    define('ONLY_HITS_PRODUCTS_FLAG', 1);
    define('ONLY_ORDERED_PRODUCTS_FLAG', 254);
    define('HITS_OR_ORDERED_PRODUCTS_FLAG', 255);

    define('INIT_CONFIGURATOR_ITEMS_AS_PREDEFINED', TRUE);
    define('INIT_CONFIGURATOR_ITEMS_AS_CATALOGED', FALSE);

    define('DOWNLOAD_LINKS_LIFETIME', 7);

    define('DELIVERY_SORT_MODE_AS_IS', 0);
    define('DELIVERY_SORT_MODE_BY_NAME', DELIVERY_SORT_MODE_AS_IS + 1);
    define('DELIVERY_SORT_MODE_BY_PRICE', DELIVERY_SORT_MODE_BY_NAME + 1);

    define('DELIVERY_CONFLICT_MODE_IGNORE', 0);
    define('DELIVERY_CONFLICT_MODE_DISABLED_FOR_ALL', DELIVERY_CONFLICT_MODE_IGNORE + 1);
    define('DELIVERY_CONFLICT_MODE_DISABLED_FOR_ANY', DELIVERY_CONFLICT_MODE_DISABLED_FOR_ALL + 1);

    define('QUICKORDER_SORT_MODE_AS_IS', 0);
    define('QUICKORDER_SORT_MODE_BY_NAME', QUICKORDER_SORT_MODE_AS_IS + 1);

    // значения состояний заказа
    define('ORDER_STATUS_NEW', 0);
    define('ORDER_STATUS_PROCESS', ORDER_STATUS_NEW + 1);
    define('ORDER_STATUS_DONE', ORDER_STATUS_PROCESS + 1);
    define('ORDER_STATUS_CANCEL', ORDER_STATUS_DONE + 1);

    // значения режимов редактирования заказов
    define('EDIT_ORDER_MODE_NOTHING', 0);
    define('EDIT_ORDER_MODE_NEW_ONLY', EDIT_ORDER_MODE_NOTHING + 1);
    define('EDIT_ORDER_MODE_NEW_PROCESS', EDIT_ORDER_MODE_NEW_ONLY + 1);
    define('EDIT_ORDER_MODE_NEW_PROCESS_DONE', EDIT_ORDER_MODE_NEW_PROCESS + 1);
    define('EDIT_ORDER_MODE_NEW_PROCESS_DONE_CANCEL', EDIT_ORDER_MODE_NEW_PROCESS_DONE + 1);

    // значения расположения водяного знака на картинке
    define('IMAGES_WATERMARK_LOCATION_LEFTTOP', 0);
    define('IMAGES_WATERMARK_LOCATION_CENTERTOP', IMAGES_WATERMARK_LOCATION_LEFTTOP + 1);
    define('IMAGES_WATERMARK_LOCATION_RIGHTTOP', IMAGES_WATERMARK_LOCATION_CENTERTOP + 1);
    define('IMAGES_WATERMARK_LOCATION_LEFTCENTER', IMAGES_WATERMARK_LOCATION_RIGHTTOP + 1);
    define('IMAGES_WATERMARK_LOCATION_CENTER', IMAGES_WATERMARK_LOCATION_LEFTCENTER + 1);
    define('IMAGES_WATERMARK_LOCATION_RIGHTCENTER', IMAGES_WATERMARK_LOCATION_CENTER + 1);
    define('IMAGES_WATERMARK_LOCATION_LEFTBOTTOM', IMAGES_WATERMARK_LOCATION_RIGHTCENTER + 1);
    define('IMAGES_WATERMARK_LOCATION_CENTERBOTTOM', IMAGES_WATERMARK_LOCATION_LEFTBOTTOM + 1);
    define('IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM', IMAGES_WATERMARK_LOCATION_CENTERBOTTOM + 1);

    define('CATALOG_MENU_MODE_VERTICAL_LIST', 0);
    define('CATALOG_MENU_MODE_VERTICAL_MENU', CATALOG_MENU_MODE_VERTICAL_LIST + 1);
    define('CATALOG_MENU_MODE_HORIZONTAL_MENU', CATALOG_MENU_MODE_VERTICAL_MENU + 1);



    // значения операции перед импортом данных
    define('BEFORE_IMPORT_OPERATION_NO_ACTION', 0);
    define('BEFORE_IMPORT_OPERATION_ZERO_QUANTITY', BEFORE_IMPORT_OPERATION_NO_ACTION + 1);
    define('BEFORE_IMPORT_OPERATION_DELETE_PRODUCTS', BEFORE_IMPORT_OPERATION_ZERO_QUANTITY + 1);
    define('BEFORE_IMPORT_OPERATION_HIDE_PRODUCTS', BEFORE_IMPORT_OPERATION_DELETE_PRODUCTS + 1);



    // значения некоторых настроек сайта по умолчанию
    define('SETTINGS_DEFAULT_FILES_FOLDER_PREFIX', '');

    define('SETTINGS_DEFAULT_IMAGES_QUALITY', 90);
    define('SETTINGS_MINIMAL_IMAGES_QUALITY', 10);
    define('SETTINGS_MAXIMAL_IMAGES_QUALITY', 100);

    define('SETTINGS_DEFAULT_IMAGES_WIDTH', 800);
    define('SETTINGS_MINIMAL_IMAGES_WIDTH', 16);
    define('SETTINGS_MAXIMAL_IMAGES_WIDTH', 4096);
    define('SETTINGS_DEFAULT_IMAGES_HEIGHT', 600);
    define('SETTINGS_MINIMAL_IMAGES_HEIGHT', 16);
    define('SETTINGS_MAXIMAL_IMAGES_HEIGHT', 3072);

    define('SETTINGS_DEFAULT_THUMBNAIL_WIDTH', 160);
    define('SETTINGS_MINIMAL_THUMBNAIL_WIDTH', 16);
    define('SETTINGS_MAXIMAL_THUMBNAIL_WIDTH', 640);
    define('SETTINGS_DEFAULT_THUMBNAIL_HEIGHT', 120);
    define('SETTINGS_MINIMAL_THUMBNAIL_HEIGHT', 16);
    define('SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT', 480);

    define('SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY', 50);
    define('SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY', 1);
    define('SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY', 100);

    define('SETTINGS_DEFAULT_COMMENTS_NEXTTIME', 30);
    define('SETTINGS_MINIMAL_COMMENTS_NEXTTIME', 0);
    define('SETTINGS_MAXIMAL_COMMENTS_NEXTTIME', 3600);

    define('SETTINGS_DEFAULT_SEARCHES_NEXTTIME', 30);
    define('SETTINGS_MINIMAL_SEARCHES_NEXTTIME', 0);
    define('SETTINGS_MAXIMAL_SEARCHES_NEXTTIME', 3600);

    define('SETTINGS_DEFAULT_PRODUCTS_NUM', DEFAULT_VALUE_FOR_PRODUCTS_ON_PAGE_IN_CLIENT);
    define('SETTINGS_MINIMAL_PRODUCTS_NUM', ITEMS_PER_PAGE_MINIMAL_VALUE);
    define('SETTINGS_MAXIMAL_PRODUCTS_NUM', ITEMS_PER_PAGE_MAXIMAL_VALUE);

    define('SETTINGS_DEFAULT_PRODUCTS_NUM_ADMIN', DEFAULT_VALUE_FOR_PRODUCTS_ON_PAGE_IN_ADMIN);
    define('SETTINGS_MINIMAL_PRODUCTS_NUM_ADMIN', ITEMS_PER_PAGE_MINIMAL_VALUE);
    define('SETTINGS_MAXIMAL_PRODUCTS_NUM_ADMIN', ITEMS_PER_PAGE_MAXIMAL_VALUE);

    define('SETTINGS_DEFAULT_ITEMS_NUM', 2 * 3 * 4);
    define('SETTINGS_MINIMAL_ITEMS_NUM', ITEMS_PER_PAGE_MINIMAL_VALUE);
    define('SETTINGS_MAXIMAL_ITEMS_NUM', ITEMS_PER_PAGE_MAXIMAL_VALUE);

    define('SETTINGS_DEFAULT_ITEMS_NUM_ADMIN', 50);
    define('SETTINGS_MINIMAL_ITEMS_NUM_ADMIN', ITEMS_PER_PAGE_MINIMAL_VALUE);
    define('SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN', ITEMS_PER_PAGE_MAXIMAL_VALUE);

    define('ADMIN_IMAGES_FOLDER_REFERENCE', 'images/');
    // максимально допустимые для загрузки на сайт размеры файлов изображений
    define('IMAGE_UPLOAD_MAXIMAL_FILESIZE', 8 * 1024 * 1024);
    define('WATERMARK_UPLOAD_MAXIMAL_FILESIZE', 512 * 1024);

    // максимально допустимый для загрузки на сайт размер файла для страницы медиа файла
    define('FILE_UPLOAD_MAXIMAL_FILESIZE', 1024 * 1024 * 1024);

    // максимально допустимый для загрузки на сайт размер файла импорта данных
    define('IMPORT_UPLOAD_MAXIMAL_FILESIZE', 96 * 1024 * 1024);

    // максимально допустимый для загрузки на сайт размер файла резервной копии
    define('BACKUP_UPLOAD_MAXIMAL_FILESIZE', 512 * 1024 * 1024);

    // максимально допустимый для загрузки на сайт размер файла архива фотографий
    define('ZIP_IMAGES_UPLOAD_MAXIMAL_FILESIZE', 128 * 1024 * 1024);

    // максимально допустимый для загрузки на сайт размер файла архива шаблонов
    define('ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE', 6 * 1024 * 1024);



    // имена переменных в шаблонизаторе:
    // конфигурация сайта
    define('SMARTY_VAR_CONFIG', 'config');
    define('SMARTY_VAR_ADMIN_CONFIG', 'Config');

    // настройки сайта
    define('SMARTY_VAR_SETTINGS', 'settings');
    define('SMARTY_VAR_ADMIN_SETTINGS', 'Settings');

    // содержимое тега title (для админпанели)
    define('SMARTY_VAR_ADMIN_TITLE', 'Title');

    // содержимое тега keywords (для админпанели)
    define('SMARTY_VAR_ADMIN_KEYWORDS', 'Keywords');

    // содержимое тега description (для админпанели)
    define('SMARTY_VAR_ADMIN_DESCRIPTION', 'Description');

    // основной контент страницы (для админпанели)
    define('SMARTY_VAR_ADMIN_CONTENT', 'Body');

    // имя файла фонового звука страницы (для админпанели)
    define('SMARTY_VAR_ADMIN_BGSOUND', 'BGsound');

    // список новых заказов
    define('SMARTY_VAR_LAST_ORDERS', 'last_orders');

    // список недавней переписки
    define('SMARTY_VAR_LAST_FEEDBACK', 'last_feedback');

    // список недавно измененных товаров
    define('SMARTY_VAR_LAST_PRODUCTS', 'last_products');

    // список недавних отзывов о товарах
    define('SMARTY_VAR_LAST_COMMENTS', 'last_comments');

    // список недавних статей
    define('SMARTY_VAR_LAST_ARTICLES', 'last_articles');

    // список недавних комментариев к статьям
    define('SMARTY_VAR_LAST_ACOMMENTS', 'last_acomments');

    // список недавних новостей
    define('SMARTY_VAR_LAST_NEWS', 'last_news');

    // список недавних комментариев к новостям
    define('SMARTY_VAR_LAST_NCOMMENTS', 'last_ncomments');

    // список записей (для админпанели)
    define('SMARTY_VAR_ADMIN_ITEMS', 'Items');

    // запись (для админпанели)
    define('SMARTY_VAR_ADMIN_ITEM', 'Item');

    // список записей
    define('SMARTY_VAR_ITEMS', 'items');

    // запись
    define('SMARTY_VAR_ITEM', 'item');

    // заголовок основного контента страницы
    define('SMARTY_VAR_CONTENT_TITLE', 'content_title');

    // путевое название основного контента страницы в навигаторе
    define('SMARTY_VAR_CONTENT_PATH', 'content_path');

    // текущий вариант списка товаров
    define('SMARTY_VAR_CATALOG_MODE', 'catalog_mode');

    // список хитов продаж
    define('SMARTY_VAR_HIT_PRODUCTS', 'hit_products');

    // список новых поступлений товаров
    define('SMARTY_VAR_NEW_PRODUCTS', 'new_products');

    // список новинок
    define('SMARTY_VAR_NEWEST_PRODUCTS', 'newest_products');

    // список акционных товаров
    define('SMARTY_VAR_ACTIONAL_PRODUCTS', 'actional_products');

    // список ожидаемых товаров
    define('SMARTY_VAR_AWAITED_PRODUCTS', 'awaited_products');

    // список недавно покупавшихся товаров
    define('SMARTY_VAR_ORDERED_PRODUCTS', 'ordered_products');

    // список обсуждаемых товаров
    define('SMARTY_VAR_COMMENTED_PRODUCTS', 'commented_products');

    // товар
    define('SMARTY_VAR_PRODUCT', 'product');

    // список комментариев товара
    define('SMARTY_VAR_PRODUCT_COMMENTS', 'comments');

    // следующий товар
    define('SMARTY_VAR_NEXT_PRODUCT', 'next_product');

    // предшествующий товар
    define('SMARTY_VAR_PREVIOUS_PRODUCT', 'prev_product');

    // список зарегистрированных модулей (для админпанели)
    define('SMARTY_VAR_ADMIN_MODULES', 'Modules');

    // список зарегистрированных модулей
    define('SMARTY_VAR_MODULES', 'modules');

    // url предыдущей страницы
    define('SMARTY_VAR_NAVIGATOR_PREVIOUS_PAGE', 'PrevPageUrl');

    // url следующей страницы
    define('SMARTY_VAR_NAVIGATOR_NEXT_PAGE', 'NextPageUrl');

    // номер текущей страницы
    define('SMARTY_VAR_NAVIGATOR_CURRENT_PAGE', 'CurrentPage');

    // номер текущей страницы
    define('SMARTY_VAR_NAVIGATOR_ON_PAGE', 'page');

    // количество листаемых страниц
    define('SMARTY_VAR_NAVIGATOR_TOTAL_PAGES', 'total_pages');

    // список url листаемых страниц
    define('SMARTY_VAR_NAVIGATOR_PAGES', 'Pages');

    // контент листания страниц
    define('SMARTY_VAR_NAVIGATOR_CONTENT', 'PagesNavigation');

    // количество элементов на странице
    define('SMARTY_VAR_ITEMS_PER_PAGE', 'CurrentPageMaxsize');

    // количество элементов на всех страницах
    define('SMARTY_VAR_TOTAL_ITEMS', 'total_items');

    // категория
    define('SMARTY_VAR_CATEGORY', 'category');

    // бренды в категории
    define('SMARTY_VAR_CATEGORY_BRANDS', 'brands');

    // свойства товара
    define('SMARTY_VAR_PRODUCT_PROPERTIES', 'properties');

    // бренд
    define('SMARTY_VAR_BRAND', 'brand');

    // весь каталог товаров
    define('SMARTY_VAR_CATALOG', 'catalog');

    // номер прайс-листа
    define('SMARTY_VAR_PRICELIST_NUMBER', 'price_number');

    // список новостей категории
    define('SMARTY_VAR_CATEGORY_NEWS', 'news_for_category');

    // список новостей товара
    define('SMARTY_VAR_PRODUCT_NEWS', 'news_for_product');

    // список новостей
    define('SMARTY_VAR_NEWS', 'all_news');

    // новость
    define('SMARTY_VAR_NEWSITEM', 'news_item');

    // список статей категории
    define('SMARTY_VAR_CATEGORY_ARTICLES', 'articles_for_category');

    // список статей товара
    define('SMARTY_VAR_PRODUCT_ARTICLES', 'articles_for_product');

    // список групп клиентов
    define('SMARTY_VAR_GROUPS', 'groups');

    // группа клиентов
    define('SMARTY_VAR_GROUP', 'group');

    // склад
    define('SMARTY_VAR_STOCK', 'stock');

    // список стран
    define('SMARTY_VAR_COUNTRIES', 'countries');

    // список областей
    define('SMARTY_VAR_REGIONS', 'regions');

    // список городов
    define('SMARTY_VAR_TOWNS', 'towns');

    // список учебных заведений
    define('SMARTY_VAR_SCHOOLS', 'schools');

    // список типов чего-либо
    define('SMARTY_VAR_TYPES', 'types');

    // список классов учебного заведения
    define('SMARTY_VAR_CLASSES', 'classes');

    // список предметов учебного заведения
    define('SMARTY_VAR_LESSONS', 'lessons');

    // список стадий заказа
    define('SMARTY_VAR_ORDERS_PHASES', 'orders_phases');

    // список способов доставки
    define('SMARTY_VAR_DELIVERIES', 'deliveries');

    // список типов доставки
    define('SMARTY_VAR_DELIVERIES_TYPES', 'deliveries_types');

    // список сроков отправки
    define('SMARTY_VAR_TERMS', 'terms');

    // список способов оплаты
    define('SMARTY_VAR_PAYMENTS', 'payments');

    // список способов оплаты
    define('SMARTY_VAR_PAYMENT_METHODS', 'payment_methods');

    // запись о заказе
    define('SMARTY_VAR_ORDER', 'order');

    // сообщение об ошибке (для админпанели)
    define('SMARTY_VAR_ADMIN_ERROR', 'Error');

    // сообщение об ошибке
    define('SMARTY_VAR_ERROR', 'error');

    // информационное сообщение
    define('SMARTY_VAR_MESSAGE', 'message');

    // элемент для почтового сообщения
    define('SMARTY_VAR_EMAIL_POST', 'post');

    // целевой объект почтового сообщения
    define('SMARTY_VAR_EMAIL_POST_OBJECT', 'post_object');

    // значения некоторых элементов html-формы
    define('SMARTY_VAR_FORM_INPUTS_VALUES', 'inputs');

    // страница возврата после операции
    define('SMARTY_VAR_FROM_PAGE', 'from_page');

    // емейл
    define('SMARTY_VAR_EMAIL', 'email');

    // url корневой папки клиентской стороны сайта
    define('SMARTY_VAR_SITE_URL', 'site');

    // url папки шаблона (дизайна) клиентской стороны сайта
    define('SMARTY_VAR_THEME_URL', 'theme');

    // список шаблонов (дизайнов) клиентской стороны сайта
    define('SMARTY_VAR_THEMES', 'themes');

    // имя текущего (выбранного пользователем) шаблона
    define('SMARTY_VAR_CURRENT_THEME', 'current_theme');

    // имя дефолтного (предложенного администратором) шаблона
    define('SMARTY_VAR_DEFAULT_THEME', 'default_theme');

    // массив имен (строчными буквами) разрешенных администратору модулей
    define('SMARTY_VAR_ADMIN_RIGHTS', 'admin_rights');



    // html-фрагменты сообщений о контенте
    define('CONTENT_MESSAGE_NO_MODULE', "<div class=\"box\">\r\n"
                                      . "    <div class=\"noitems\">\r\n"
                                      . "        Нет такой страницы на сайте или в его настройках отключен модуль (класса *), обслуживающий подобный тип страниц!\r\n"
                                      . "    </div>\r\n"
                                      . '</div>');
    define('CONTENT_MESSAGE_NO_PAGE', "<div class=\"box\">\r\n"
                                    . "    <div class=\"noitems\">\r\n"
                                    . "        Нет такой страницы на сайте! Проверьте, правильно ли задан ее адрес.\r\n"
                                    . "    </div>\r\n"
                                    . '</div>');



    // =======================================================================
    /**
    *  Единоразовая подгрузка констант класса
    *
    *  @access  public
    *  @param   string  $class      имя класса
    *  @return  void
    */
    // =======================================================================

    function impera_ConstantsRequire ( $class ) {
        $class = preg_replace('/[^a-z0-9]/i', '', $class);
        if ($class != '') {
            $class = strtolower($class);
            require_once(ROOT_FOLDER_REFERENCE
                       . FOLDERNAME_FOR_ENGINE_OBJECTS . '/'
                       . $class . '/'
                       . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
        }
    }



    // =======================================================================
    /**
    *  Единоразовая подгрузка класса
    *
    *  @access  public
    *  @param   string  $class              имя класса
    *  @param   boolean $administrative     TRUE если для админпанели (иначе клиентский)
    *  @return  void
    */
    // =======================================================================

    function impera_ClassRequire ( $class, $administrative = FALSE ) {
        $class = preg_replace('/[^a-z0-9]/i', '', $class);
        if (($class != '') && !class_exists(($administrative ? '' : 'Client') . $class)) {
            $folder = strtolower($class);
            require_once(ROOT_FOLDER_REFERENCE
                       . FOLDERNAME_FOR_ENGINE_OBJECTS . '/'
                       . $folder . '/'
                       . $class . ($administrative ? '.admin' : '') . '.php');
        }
    }



    // =======================================================================
    /**
    *  Получение признака "это имя ресурса"
    *
    *  @access  public
    *  @param   mixed   $name       имя файла ресурса или объект ресурса
    *  @param   string  $prefix     префикс типа ресурса в имени файла
    *  @return  boolean             TRUE если распознано как имя
    */
    // =======================================================================

    function impera_IsResourceName ( $name, $prefix = '' ) {
        $prefix = trim($prefix);
        $length = strlen($prefix);
        $value = strtolower($prefix);
        $field = 'impera_resource_filename';
        return is_string($name)
               && (strtolower(substr(trim($name), 0, $length)) == $value)
            || is_object($name)
               && isset($name->$field)
               && (is_string($name->$field) || is_object($name->$field) && is_a($name, 'SimpleXMLElement'))
               && (strtolower(substr(trim($name->$field), 0, $length)) == $value);
    }



    // =======================================================================
    /**
    *  Получение имени ресурса
    *
    *  @access  public
    *  @param   mixed   $name       имя файла ресурса или объект ресурса
    *  @param   string  $prefix     префикс типа ресурса в имени файла
    *  @param   boolean $no_prefix  TRUE если удалить префикс ресурса из результата
    *  @param   string  $ext        обязательное расширение в имени файла
    *  @return  string              имя ресурса
    */
    // =======================================================================

    function impera_GetResourceName ( $name, $prefix = '', $no_prefix = TRUE, $ext = '' ) {

        // извлекаем имя
        $field = 'impera_resource_filename';
        if (is_string($name)) $result = trim($name);
        elseif (is_object($name)
               && isset($name->$field)
               && (is_string($name->$field) || is_object($name->$field)
                                            && is_a($name, 'SimpleXMLElement'))) $result = trim($name->$field);
        else $result = '';



        // удалим префикс имени
        $prefix = trim($prefix);
        $length = strlen($prefix);
        if ($length > 0) {
            $value = strtolower($prefix);
            if (strtolower(substr($result, 0, $length)) == $value) $result = trim(substr($result, $length));
        }



        // обезопасим путь к файлу
        $result = str_replace('\\', '/', $result);
        $result = preg_replace('~[^a-z0-9\-_/\.\s]~i', '', $result);
        $result = preg_replace('~[\s\t\r\n\.]*/[\s\t\r\n]*~', '/', $result);
        $result = preg_replace('~/+~', '/', $result);
        $result = rtrim(trim($result, '/'), ". \t\r\n");



        // проверяем наличие расширения имени файла
        $ext = trim($ext);
        $length = strlen($ext);
        if ($length > 0) {
            $value = strtolower($ext);
            if (strtolower(substr($result, -$length)) != $value) $result .= $value;
        }



        // если не просили удалить префикс имени, восстановим
        if (!$no_prefix) $result = $prefix . $result;



        // возвращаем имя
        return $result;
    }



    // =======================================================================
    /**
    *  Загрузка в свойства объекта XML ресурсов
    *
    *  @access  public
    *  @param   object  $owner      обрабатываемый объект
    *  @return  void
    */
    // =======================================================================

    function impera_LoadXmlResources ( & $owner ) {

        // если функция невыполнима
        if (!is_object($owner)) return;
        if (!function_exists('simplexml_load_file')) return;

        $prefix = 'xml:';
        $ext = '.xml';
        $empty = '<' . '?xml version=\'1.0\'?' . '><document></document>';
        $field = 'impera_resource_filename';



        // перебираем свойства (типа строка) с XML именами
        foreach ($owner as $key => & $value) {
            if (is_string($value) && impera_IsResourceName($value, $prefix)) {
                $ok = FALSE;
                $path = ROOT_FOLDER_REFERENCE;
                $file = impera_GetResourceName($value, $prefix, TRUE, $ext);



                // пробуем загрузить XML (создать объект SimpleXMLElement)
                if (is_readable($path . $file) && is_file($path . $file)) {
                    try {
                        $owner->$key = @ simplexml_load_file($path . $file);
                        $ok = is_object($owner->$key);
                    } catch (Exception $e) { }
                }



                // иначе это будет пустой объект SimpleXMLElement
                if (!$ok) {
                    try {
                        $owner->$key = @ new SimpleXMLElement($empty);
                        $ok = is_object($owner->$key);
                    } catch (Exception $e) { }



                    // иначе пустой объект stdClass
                    if (!$ok) {
                        $owner->$key = new stdClass;
                        $ok = TRUE;
                    }
                }



                // в объекте запоминаем XML имя
                if ($ok) $owner->{$key}->$field = $prefix . $file;
            }
        }
    }



    // ====================== TODO: удалить этот блок позже (пока оставлен для совместимости с частями старой версии движка)
    if (!function_exists('impera_LoadConfiguration')) {

        // =========================================================================
        // Загрузить конфигурацию с учетом множества магазинов на одном движке:
        //   $suffix = файловый суффикс магазина будет помещен в эту переменную
        //             (используется в личных файлах магазина при едином движке)
        //   $subdomain = массив относительного субдоменного пути будет помещен в эту переменную
        // =========================================================================

        function globalLoadConfiguration (&$suffix = '', &$subdomain = array()) {

            // если имеются данные о домене
            $suffix = '';
            $subdomain = array();
            if (isset($_SERVER['HTTP_HOST'])) {
                $suffix = strtolower($_SERVER['HTTP_HOST']);

                // обезопасим домен как файловый суффикс
                $suffix = str_replace(':', '.', $suffix);
                $suffix = str_replace('\\', '', $suffix);
                $suffix = str_replace('/', '', $suffix);
                $suffix = str_replace("\r", '', $suffix);
                $suffix = str_replace("\n", '', $suffix);
                $suffix = str_replace("\t", '', $suffix);
                $suffix = str_replace(' ', '', $suffix);
                $suffix = trim($suffix, '. ');

                // идем от нижнего уровня домена к верхнему
                while ($suffix != '') {

                    // если для такого домена есть конфигурационный файл, загружаем и прерываемся
                    $file = str_replace('*', '_' . $suffix, FILENAME_FOR_ENGINE_CONFIG_OBJECT);
                    if (file_exists(ROOT_FOLDER_REFERENCE . $file)) {
                        @require_once(ROOT_FOLDER_REFERENCE . $file);
                        $suffix = '_' . $suffix;
                        $subdomain = array(implode('.', $subdomain));
                        break;
                    }

                    // если есть уровень выше и находимся ниже второго
                    $suffix = explode('.', $suffix, 3);
                    if (isset($suffix[2])) {
                        $value = trim($suffix[0]);
                        if ($value != '') {

                            // передаем уровень в субдоменный путь (кроме нижайших www[.www[...]])
                            $subdomain[] = $value;
                            if ($subdomain[0] == 'www') $subdomain = array();
                        }
                    }

                    // выходим на уровень выше
                    $value = isset($suffix[1]) ? trim($suffix[1]) : '';
                    $value2 = isset($suffix[2]) ? trim($suffix[2]) : '';
                    $suffix = $value . (($value2 != '') ? (($value != '') ? '.' : '') . $value2 : '');
                    while (substr($suffix, 0, 1) == '.') $suffix = trim(substr($suffix, 1));
                }
            }

            // если не нашли конфигурацию для домена, загружаем конфигурацию основного магазина
            if ($suffix == '') @require_once(ROOT_FOLDER_REFERENCE . 'Config.class.php');
        }

        // загрузить конфигурацию магазина
        globalLoadConfiguration($files_host_suffix, $brand_subdomain);

    }
    // ====================== удалить этот блок позже (конец блока)



    // ====================== TODO: удалить этот блок позже (пока оставлен для совместимости с частями старой версии движка)
    if (!function_exists('impera_CheckRedirects')) {

        // разделители записей и полей записи в однострочной нотации
        define('IN_ONE_TEXT_LINE_RECORDS_DELIMITER', '[]');
        define('IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER', '|');

        // индексы полей записи о редиректе:
        // .. разрешена ли запись
        // .. отбросить ли параметры запроса в адресе страницы
        // .. использовать ли регулярные выражения в анализе адреса страницы
        // .. старый адрес страницы
        // .. новый адрес страницы
        // .. тип редиректа (301, 403, 404, 410)
        // количество полей в записи
        define('field_REDIRECT_ENABLED', 0);
        define('field_REDIRECT_REMOVE_QUERYPARAMS', field_REDIRECT_ENABLED + 1);
        define('field_REDIRECT_USE_REGEXP', field_REDIRECT_REMOVE_QUERYPARAMS + 1);
        define('field_REDIRECT_FROM_URL', field_REDIRECT_USE_REGEXP + 1);
        define('field_REDIRECT_TO_URL', field_REDIRECT_FROM_URL + 1);
        define('field_REDIRECT_TYPE', field_REDIRECT_TO_URL + 1);
        define('fieldcount_REDIRECT', field_REDIRECT_TYPE + 1);

        // предельное количество записей о редиректах
        define('REDIRECT_RECORDS_MAXCOUNT', 5000);

        // =========================================================================
        // Проверить и выполнить требование редиректа с одной страницы на другую:
        //   $url = адрес проверяемой страницы (или пустая строка для получения массива редиректов)
        //   $suffix = файловый суффикс магазина
        //   $redirects = сюда будет возвращен массив сведений о редиректах
        // =========================================================================

        function globalCheckRedirects ($url, $suffix = '', &$redirects = null) {

            // обезопасим файловый суффикс
            $suffix = strtolower(trim($suffix));
            $suffix = str_replace(':', '.', $suffix);
            $suffix = str_replace('\\', '', $suffix);
            $suffix = str_replace('/', '', $suffix);
            $suffix = str_replace("\r", '', $suffix);
            $suffix = str_replace("\n", '', $suffix);
            $suffix = str_replace("\t", '', $suffix);
            $suffix = str_replace(' ', '', $suffix);
            while (substr($suffix, 0, 1) == '.') $suffix = trim(substr($suffix, 1));
            while (substr($suffix, -1) == '.') $suffix = trim(substr($suffix, 0, -1));

            // если для такого домена есть файл сведений о редиректах
            $url = trim($url);
            $unquery_url = explode('?', $url, 2);
            $unquery_url = isset($unquery_url[0]) ? trim($unquery_url[0]) : $url;
            $redirects = array();
            $file = str_replace('*', $suffix, FILENAME_FOR_REDIRECTS_INFO);
            if (file_exists(ROOT_FOLDER_REFERENCE . $file)
            && is_readable(ROOT_FOLDER_REFERENCE . $file)) {

              // открываем файл сведений о редиректах
              if ($handle = fopen(ROOT_FOLDER_REFERENCE . $file, 'rb')) {
                flock($handle, LOCK_EX);

                // перебираем редиректы
                $count = 0;
                while (!feof($handle)) {
                  $record = fgets($handle, 65536);
                  if ($record === FALSE) break;
                  $record = trim($record);

                  // если это не пустая строка
                  if ($record != '') {
                    $temp = explode(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, $record);

                    // если это точно запись о редиректе и задан адрес проверяемой страницы
                    if (count($temp) == fieldcount_REDIRECT) {
                      $record = $temp;
                      $record[field_REDIRECT_ENABLED] = $record[field_REDIRECT_ENABLED] == TRUE;
                      $record[field_REDIRECT_REMOVE_QUERYPARAMS] = $record[field_REDIRECT_REMOVE_QUERYPARAMS] == TRUE;
                      $record[field_REDIRECT_USE_REGEXP] = $record[field_REDIRECT_USE_REGEXP] == TRUE;
                      $record[field_REDIRECT_FROM_URL] = trim($record[field_REDIRECT_FROM_URL]);
                      $record[field_REDIRECT_TO_URL] = trim($record[field_REDIRECT_TO_URL]);
                      $record[field_REDIRECT_TYPE] = intval($record[field_REDIRECT_TYPE]);
                      if ($url != '') {

                        $redir301 = ($record[field_REDIRECT_TYPE] != 403)
                                 && ($record[field_REDIRECT_TYPE] != 404)
                                 && ($record[field_REDIRECT_TYPE] != 410);

                        // если запись разрешена и неошибочна
                        if ($record[field_REDIRECT_ENABLED]
                        && ($record[field_REDIRECT_FROM_URL] != '')
                        && (!$redir301
                        || ($record[field_REDIRECT_TO_URL] != '')
                        && ($record[field_REDIRECT_FROM_URL] != $record[field_REDIRECT_TO_URL]))) {

                          // если запись подходит
                          $string = $record[field_REDIRECT_REMOVE_QUERYPARAMS] ? $unquery_url : $url;
                          if (($string != '')
                          && ($record[field_REDIRECT_USE_REGEXP] && @preg_match($record[field_REDIRECT_FROM_URL], $string)
                          || !$record[field_REDIRECT_USE_REGEXP] && ($record[field_REDIRECT_FROM_URL] == $string))) {

                            // если новый адрес отличается от старого
                            $temp = $redir301
                                    ? ($record[field_REDIRECT_USE_REGEXP]
                                       ? @preg_replace($record[field_REDIRECT_FROM_URL], $record[field_REDIRECT_TO_URL], $string)
                                       : $record[field_REDIRECT_TO_URL])
                                    : '';
                            if ($temp != $string) {

                              // делаем редирект
                              switch ($record[field_REDIRECT_TYPE]) {
                                // сообщаем, что этому пользователю запрещен доступ к такой странице
                                case 403:
                                  header('HTTP/1.1 403 Forbidden');
                                  break;
                                // сообщаем, что не нашли такую страницу
                                case 404:
                                  header('HTTP/1.1 404 Not Found');
                                  break;
                                // сообщаем, что документ раньше был по такому адресу, но удален и теперь недоступен
                                case 410:
                                  header('HTTP/1.1 410 Gone');
                                  break;
                                // сообщаем, что запрошенный документ был окончательно перенесен на новый адрес
                                case 301:
                                default:
                                  $url = $temp;
                                  $protocol = str_replace('\\', '/', strtolower(substr($url, 0, 6)));
                                  if ($protocol != 'http:/' && $protocol != 'https:') $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
                                  header('HTTP/1.1 301 Moved Permanently');
                                  header('Location: ' . $url);
                              }
                            }
                            exit;
                          }
                        }
                      }
                    }

                    // добавляем редирект / комментарий в массив (не более предельного количества)
                    $redirects[] = $record;
                    $count++;
                    if ($count >= REDIRECT_RECORDS_MAXCOUNT) break;
                  }
                }

                // закрываем файл
                fclose($handle);
              }
            }
        }

    }
    // ====================== удалить этот блок позже (конец блока)



    return;
?>