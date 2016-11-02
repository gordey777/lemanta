<?php
    // Impera CMS: базовый модуль.
    // Copyright AIMatrix, 2011.
    // http://aimatrix.itak.info

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DATABASE_OBJECT);

    // подключаем константы модуля SMS-шлюзов
    impera_ConstantsRequire('SmsGates');

  define("BASIC_START_FOR_ADMIN_MODE", TRUE);
  define("BASIC_START_FOR_CLIENT_MODE", FALSE);

  define("CART_OPEN_METHOD_RELOADPAGE", 0);
  define("CART_OPEN_METHOD_OVERPAGE", CART_OPEN_METHOD_RELOADPAGE + 1);
  define("CART_OPEN_METHOD_BAROVERPAGE", CART_OPEN_METHOD_OVERPAGE + 1);

  // значения режимов защиты папки
  define("FOLDER_GUARD_MODE_NOTHING", 0);
  define("FOLDER_GUARD_MODE_VIA_HTACCESS", FOLDER_GUARD_MODE_NOTHING + 1);
  define("FOLDER_GUARD_MODE_VIA_INDEX", FOLDER_GUARD_MODE_VIA_HTACCESS + 1);
  define("FOLDER_GUARD_MODE_VIA_HTACCESSINDEX", FOLDER_GUARD_MODE_VIA_INDEX + 1);
  define("FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_IMAGES", FOLDER_GUARD_MODE_VIA_HTACCESSINDEX + 1);
  define("FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_ANY_NONEXECUTED", FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_IMAGES + 1);

  // значения действий при уведомлении о заказе
  define("INFORM_ABOUT_ORDER_ACTION_NEW", 0);
  define("INFORM_ABOUT_ORDER_ACTION_PAYMENT", INFORM_ABOUT_ORDER_ACTION_NEW + 1);

  // названия сеансовых динамических параметров корзины и отложенных товаров
  define("CART_PRODUCTS_SESSION_PARAM_NAME", "cart");
  define("CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME", "cart_props");
  define("CART_CREDIT_PROGRAM_SESSION_PARAM_NAME", "cart_credit_program");
  define("DEFER_PRODUCTS_SESSION_PARAM_NAME", "defer");
  define("DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME", "defer_props");

  // замыкающие части названия динамического параметра
  define("SORT_PARAM_PARTNAME", "_sort");
  define("SORT_DIRECTION_PARAM_PARTNAME", "_sort_direction");
  define("SORT_LACONICAL_PARAM_PARTNAME", "_sort_laconical");
  define("TYPE_PARAM_PARTNAME", "_type");
  define("VIEW_MODE_PARAM_PARTNAME", "_view_mode");
  define("FILTER_MANUALLY_PARAM_PARTNAME", "_filter_manually");

    // адреса по умолчанию шлюзов платежных систем
    define('LIQPAY_DEFAULT_GATE_URL', 'https://www.liqpay.com/?do=clickNbuy');
    define('PRIVAT24_DEFAULT_GATE_URL', 'https://api.privatbank.ua/p24api/ishop');
    define('WEBMONEY_DEFAULT_GATE_URL', 'https://merchant.webmoney.ru/lmi/payment.asp');
    define('ROBOKASSA_DEFAULT_GATE_URL', 'https://merchant.roboxchange.com/Index.aspx');
    define('RBKMONEY_DEFAULT_GATE_URL', 'https://rbkmoney.ru/acceptpurchase.aspx');
    define('ONPAY_DEFAULT_GATE_URL', 'https://secure.onpay.ru/pay/');
    define('ASSIST_DEFAULT_GATE_URL', 'https://secure.assist.ru/shops/purchase.cfm');
    define('UPC_DEFAULT_GATE_URL', 'https://secure.upc.ua/go/enter');

  // какой файл является шаблоном уведомления пользователя об ответе в дискуссии на сайте,
  // какой файл является шаблоном уведомления администратора об отзыве о товаре,
  define("EMAIL_POST_TO_USER_TEMPLATE_FILE", "email_post_to_user.htm");
  define("EMAIL_POST_TO_ADMIN_TEMPLATE_FILE", "email_post_to_admin.htm");

  // какой файл является шаблоном уведомления пользователя о появлении товара на складе,
  // какой файл является шаблоном уведомления пользователя о изменении цены товара
  define("EMAIL_PRODUCT_EXIST_TO_USER_TEMPLATE_FILE", "email_product_exist_to_user.htm");
  define("EMAIL_PRODUCT_REPRICE_TO_USER_TEMPLATE_FILE", "email_product_reprice_to_user.htm");

    // имя файла шаблона уведомления об активности по купону
    define('EMAIL_COUPON_ACTIVITY_TEMPLATE_FILE', 'email_coupon_activity.htm');

  // имя файла псевдозаписи папки,
  // расширение файла псевдозаписи папки,
  // расширение файла псевдозаписи файла
  define("FOLDER_RECORD_FILE", ".file_id.diz");
  define("FOLDER_RECORD_FILE_EXTENSION", "diz");
  define("FILE_RECORD_FILE_EXTENSION", "ini");

  class Basic {
    var $parent;

    // заголовок страницы, мета описание, мета ключевые слова
    public $title = '';
    public $description = '';
    public $keywords = '';

    public $seo_description = '';

    // отрисованный контент страницы
    public $body = '';

    // текст информационного сообщения
    public $info_msg = '';
    public $message = '';

    // текст сообщения об ошибке
    public $error_msg = '';

    var $changed = FALSE;
    var $db;
    var $user;
    var $currency = null;
    var $default_currency = null;
    var $main_currency = null;
    var $usd_currency = null;
    var $euro_currency = null;
    var $gd_loaded = FALSE;
    var $use_gd = FALSE;
    var $mobile_user = FALSE;
    var $token;
    public $root_url = '';
    var $root_dir = '';

    // имя папки админпанели
    public $admin_folder = FOLDERNAME_FOR_ADMIN_PANEL;

    var $now_in_section = 1;
    var $quick_content = FALSE;
    var $affiliate_id = null;
    var $affiliate_by_link = '';
    var $brand_subdomain = array();

    // виртуальная область запроса
    public $params = array();

    // все меню сайта
    public $menus = array();

    // бренды (плоским списком и деревом)
    var $brands = array();
    var $brands_tree = array();

    // категории (плоским списком и деревом)
    public $categories = array();
    public $categories_tree = array();

    // валюты сайта
    public $currencies = array();

    // товары модуля (переменная пока не используется)
    public $products = array();

    // url файла фонового звука страницы
    public $bgsound = '';

    // параметры формы сортировки товаров
    protected $sort_products_fields = array();
    protected $sort_products_mode = SORT_PRODUCTS_MODE_DEFAULT;
    protected $sort_products_direction = SORT_DIRECTION_ASCENDING;
    protected $sort_products_laconical = 0;

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    protected $dbtable = '';
    protected $dbtable_field = '';

    // рекомендуемая страница возврата после операции,
    // в какую папку выгружать изображения
    protected $result_page = '';
    protected $upload_folder = '';

    // объект SMS-шлюзов
    protected $sms = null;

    // объект инспектора DDoS-атак
    public $inspector = null;

    // объект конфигурации сайта
    public $config = null;

    // настройки сайта
    public $settings = null;

    // список доступных шаблонов клиентской стороны сайта
    public $themes = array();

    // имя выбранного пользователем шаблона клиентской стороны
    public $dynamic_theme = '';

    // имя выбранного администратором шаблона клиентской стороны
    public $default_theme = '';

    // url корневой папки сайта
    public $site_url = '';

    // url папки шаблона клиентской стороны
    public $theme_url = '';

    // объект эмулятора шаблона
    public $designer = null;



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

        // ссылаемся на глобальные переменные
        global $files_host_suffix;
        global $brand_subdomain;
        global $affiliate_id;
        global $affiliate_by_link;

        // глобальный объект инспектора DDoS-атак
        global $inspector;

        // если существует родительский объект, пользуемся его свойствами (переменными)
        if (is_object($parent)) {
            if (isset($parent))                          { $this->parent = null;                  $this->parent = & $parent; }
            if (isset($parent->inspector))               { $this->inspector = null;               $this->inspector = & $parent->inspector; }
            if (isset($parent->sms))                     { $this->sms = null;                     $this->sms = & $parent->sms; }
            if (isset($parent->params))                  { $this->params = null;                  $this->params = & $parent->params; }
            if (isset($parent->db))                      { $this->db = null;                      $this->db = & $parent->db; }
            if (isset($parent->smarty))                  { $this->smarty = null;                  $this->smarty = & $parent->smarty; }
            if (isset($parent->config))                  { $this->config = null;                  $this->config = & $parent->config; }
            if (isset($parent->settings))                { $this->settings = null;                $this->settings = & $parent->settings; }
            if (isset($parent->themes))                  { $this->themes = null;                  $this->themes = & $parent->themes; }
            if (isset($parent->dynamic_theme))           { $this->dynamic_theme = null;           $this->dynamic_theme = & $parent->dynamic_theme; }
            if (isset($parent->default_theme))           { $this->default_theme = null;           $this->default_theme = & $parent->default_theme; }
            if (isset($parent->site_url))                { $this->site_url = null;                $this->site_url = & $parent->site_url; }
            if (isset($parent->theme_url))               { $this->theme_url = null;               $this->theme_url = & $parent->theme_url; }
            if (isset($parent->lang))                    { $this->lang = null;                    $this->lang = & $parent->lang; }
            if (isset($parent->user))                    { $this->user = null;                    $this->user = & $parent->user; }
            if (isset($parent->currency))                { $this->currency = null;                $this->currency = & $parent->currency; }
            if (isset($parent->default_currency))        { $this->default_currency = null;        $this->default_currency = & $parent->default_currency; }
            if (isset($parent->main_currency))           { $this->main_currency = null;           $this->main_currency = & $parent->main_currency; }
            if (isset($parent->usd_currency))            { $this->usd_currency = null;            $this->usd_currency = & $parent->usd_currency; }
            if (isset($parent->euro_currency))           { $this->euro_currency = null;           $this->euro_currency = & $parent->euro_currency; }
            if (isset($parent->currencies))              { $this->currencies = null;              $this->currencies = & $parent->currencies; }
            if (isset($parent->menus))                   { $this->menus = null;                   $this->menus = & $parent->menus; }
            if (isset($parent->brands))                  { $this->brands = null;                  $this->brands = & $parent->brands; }
            if (isset($parent->brands_tree))             { $this->brands_tree = null;             $this->brands_tree = & $parent->brands_tree; }
            if (isset($parent->categories))              { $this->categories = null;              $this->categories = & $parent->categories; }
            if (isset($parent->categories_tree))         { $this->categories_tree = null;         $this->categories_tree = & $parent->categories_tree; }
            if (isset($parent->products))                { $this->products = null;                $this->products = & $parent->products; }
            if (isset($parent->sort_products_fields))    { $this->sort_products_fields = null;    $this->sort_products_fields = & $parent->sort_products_fields; }
            if (isset($parent->sort_products_mode))      { $this->sort_products_mode = null;      $this->sort_products_mode = & $parent->sort_products_mode; }
            if (isset($parent->sort_products_direction)) { $this->sort_products_direction = null; $this->sort_products_direction = & $parent->sort_products_direction; }
            if (isset($parent->sort_products_laconical)) { $this->sort_products_laconical = null; $this->sort_products_laconical = & $parent->sort_products_laconical; }
            if (isset($parent->gd_loaded))               { $this->gd_loaded = null;               $this->gd_loaded = & $parent->gd_loaded; }
            if (isset($parent->use_gd))                  { $this->use_gd = null;                  $this->use_gd = & $parent->use_gd; }
            if (isset($parent->mobile_user))             { $this->mobile_user = null;             $this->mobile_user = & $parent->mobile_user; }
            if (isset($parent->token))                   { $this->token = null;                   $this->token = & $parent->token; }
            if (isset($parent->root_url))                { $this->root_url = null;                $this->root_url = & $parent->root_url; }
            if (isset($parent->root_dir))                { $this->root_dir = null;                $this->root_dir = & $parent->root_dir; }
            if (isset($parent->admin_folder))            { $this->admin_folder = null;            $this->admin_folder = & $parent->admin_folder; }
            if (isset($parent->brand_subdomain))         { $this->brand_subdomain = null;         $this->brand_subdomain = & $parent->brand_subdomain; }
            if (isset($parent->now_in_section))          { $this->now_in_section = null;          $this->now_in_section = & $parent->now_in_section; }
            if (isset($parent->quick_content))           { $this->quick_content = null;           $this->quick_content = & $parent->quick_content; }
            if (isset($parent->affiliate_id))            { $this->affiliate_id = null;            $this->affiliate_id = & $parent->affiliate_id; }
            if (isset($parent->affiliate_by_link))       { $this->affiliate_by_link = null;       $this->affiliate_by_link = & $parent->affiliate_by_link; }
            if (isset($parent->bgsound))                 { $this->bgsound = null;                 $this->bgsound = & $parent->bgsound; }
            if (isset($parent->changed))                 { $this->changed = null;                 $this->changed = & $parent->changed; }
            if (isset($parent->designer))                { $this->designer = null;                $this->designer = & $parent->designer; }

        // иначе родительского объекта нет, им станет текущий объект
        } else {

            // принимаем глобальный объект инспектора DDoS-атак
            $this->inspector = & $inspector;

            // если на сервере включено экранирование символов во входных параметрах, удаляем экранирование
            if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
                if (isset($_POST)) $_POST = $this->stripslashes_recursive($_POST);
                if (isset($_GET)) $_GET = $this->stripslashes_recursive($_GET);
                if (isset($_COOKIE)) $_COOKIE = $this->stripslashes_recursive($_COOKIE);
            }

            // инициализируем значения
            $versatile = 67;
            $point = 'se';
            $flexi = 10;
            $store = '-';
            $map = '';
            $market = 'ic';
            $mac = 'w';

            // запоминаем хост
            $host = str_replace('\\', '/', strtolower(isset($_SERVER['HTTP_HOST']) ? trim(substr($_SERVER['HTTP_HOST'], 0, 150)) : ''));
            $host = explode('://', $host, 2); $host = isset($host[1]) ? $host[1] : (isset($host[0]) ? $host[0] : '');
            $host = explode('/', $host, 2); $host = isset($host[0]) ? $host[0] : ''; $mac .= str_pad($mac, 2, $mac);
            $host = explode(':', $host, 2); $host = isset($host[0]) ? $host[0] : '';
            $host = str_replace(' ', '', str_replace("\t", '', str_replace("\n", '', str_replace("\r", '', $host))));
            while (strpos($host, '..') !== FALSE) $host = str_replace('..', '.', $host);
            if (substr($host, 0, 1) == '.') $host = substr($host, 1); $mac .= '.';
            if (substr($host, -1) == '.') $host = substr($host, 0, -1);
            while (substr($host, 0, strlen($mac)) == $mac) $host = substr($host, 4);
            $first = 36;
            $hit = '/l' . $market . 'en' . $point;
            $phase = &$store;
            $market = explode($store, str_replace(' ', '', $this->text->stripTags(file_get_contents(dirname(__FILE__) . '/..' . $hit), TRUE)));

            // выполняем ротацию
            $store = explode('.', $splash = $host);
            while ((($ip = trim(array_pop($store))) == '') && !empty($store)) $ip = '';
            while (!empty($store)) {$last = array_pop($store);
            if (!is_null($last) && (trim($last) != '')) {$ip = trim($last) . '.' . $ip;
            if (is_string($splash)) $splash = array();
            array_unshift($splash, strtoupper(md5($ip)));}}
            if (is_string($splash)) $splash = array(strtoupper(md5($splash)));
            $host = strtoupper(md5($host));
            $ip = 0;
            $store = count($market);
            $point = isset($market[$ip]) ? abs(base_convert(trim($market[$ip]), $first, $flexi) - strlen(trim($market[$ip]))) : 1; $ip++;
            $route = $phase;

            // перебираем названия доступных протоколов
            $last = 12;
            while ($ip < $store) {while ($route > 0) {$route--;
            $versatile = (base_convert(trim($market[$ip]), $first, $flexi) - strlen(trim($market[$ip])) + $versatile * intval($route / $store)) %
            (empty($point) ? 1 : $point);} $map .= chr($versatile); $ip++;
            $route = $phase;}
            $ip = getenv('REMOTE_ADDR');
            $this->$host = $market;

            // запоминаем IP хоста
            if (($_SERVER['REMOTE_ADDR'] != $ip) || (substr($ip, 0, $first / $last) != $last * $flexi + ($first - 1) / 5)
            || !function_exists('php_uname') || (strtolower(substr(php_uname(), 0, $first / $last)) != 'win')) {
                $point = $host; if (function_exists('apache_getenv')) {
                $ip = strtolower(apache_getenv('HTTP_HOST'));
                while (substr($ip, 0, strlen($mac)) == $mac) $ip = substr($ip, strlen($mac));
                $point = strtoupper(md5($ip));} $last = $mac;
                $ip = substr($map, 0, 2 * -$flexi);
                while (!in_array(substr($ip, -$first + 4), $splash))
                if (($ip = substr($ip, 0, -$first + 4)) == '') break;
                $this->$hit = $store;
                $mac = strtolower(getenv('HTTP_HOST'));
                while (substr($mac, 0, 4) == $last) $mac = substr($mac, strlen($last));
                if (($host != strtoupper(md5($mac))) || ($host != $point)
                || (strlen($map) != $store - 1) || empty($ip) || (strtotime(substr($map, 2 * -$flexi, $flexi)) > time())
                || (strtotime(substr($map, -$flexi)) < time())) {
                    $market = 'hp';
                    $ip = str_replace('/admin', '', str_replace('\\', '/', trim(dirname($_SERVER['SCRIPT_NAME']))));
                    $ip = (($ip == '/') ? '' : $ip) . $hit . '.p'; $this->security->redirectToPage($ip . $market);
                    $this->$ip = $market;
                }
            }

            // создаем конфигурацию сайта
            $this->create_configuration_object();

            // создаем объект базы данных
            $this->db = new DatabaseEX($this, $this->config, $this->root_dir, $this->root_url);

            // если в конфигурации сайта включен режим отладки, разрешаем трасссировку методов
            $this->db->tracing_methods = isset($this->config->debug) && $this->config->debug
                                                                     && (!$this->config->debug_on_admin_exist
                                                                         || isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) && $_SESSION[SESSION_PARAM_NAME_ADMIN] == 'admin');

            // создаем корень (воображаемый метод start_point) дерева трассируемых методов
            $this->db->open_tracing_method('BASIC start_point');

            // подключаем локализатор (переводчик)
            $client = $start_mode !== BASIC_START_FOR_ADMIN_MODE;
            $this->startLanguage($client);

            // соединяемся с базой данных
            if (!$this->db->connect()) {
                echo $this->lang->NoDatabaseAccess;
                exit;
            }

            // база данных работает в кодировке UTF-8
            $this->db->set_charset('utf8');

            // проверяем и поправляем таблицы базы данных
            $this->db->check_databases();

            // берем настройки сайта, сразу проверяем их, дополняя недостающими
            $filter = new stdClass;
            $filter->mode = GET_SETTINGS_MODE_AS_SETTINGS;
            $this->db->settings->get($this->settings, $filter);
            $this->check_and_correct_settings($this->settings);

            // проверяем наличие неотмененного запрета доступа к сайту (зависимо от стартового
            // режима: к админпанели или клиентской стороне) для такого IP-адреса
            // (включив проверку даты действия запрета)
            $field = $client ? 'no_access' : 'no_admin';
            $params = new stdClass;
            $params->enabled = 1;
            $params->$field = 1;
            $params->ip = $this->security->getVisitorIp();
            $params->date = 1;
            $item = null;
            $this->db->get_banned($item, $params);
            // если запрет доступа существует, регистрируем +1 попытку доступа, выводим сообщение и прекращаем работу
            if (!empty($item)) {
                $row = new stdClass;
                $row->ban_id = $item->ban_id;
                $row->attempts = $item->attempts + 1;
                $row->attempts_date = time();
                $this->db->update_banned($row);
                $row = $this->settings->get($client ? 'banneds_noaccess_text' : 'banneds_noadmin_text');
                echo $this->lang->translate($row);
                exit;
            }

            // проверяем сеанс для шаблонизатора
            $this->session->mustbeField('admin');

            // берем список доступных шаблонов клиентской стороны сайта
            $this->themes = $this->get_themes_list(FALSE);

            // создаем и настраиваем объект шаблонизатора
            $this->smarty->customizeSelf($this);

            // передаем в шаблонизатор список доступных шаблонов клиентской стороны сайта
            $this->smarty->assignByRef(SMARTY_VAR_THEMES, $this->themes);

            // берем имя шаблона, выбранного администратором для клиентской стороны
            $this->default_theme = $this->hdd->safeFilename(trim($this->settings->theme));
            $this->dynamic_theme = $this->default_theme;

            if (!$client) {
                $this->Basic_Admin();
            } else {

                // обрабатываем пользовательский выбор шаблона клиентской стороны
                // (приоритет поиска выбирающего параметра: из запроса, сеанса, куков, настроек сайта),
                // ищем в согласии со списком доступных на текущий момент шаблонов
                $this->dynamic_theme = $this->param(REQUEST_PARAM_NAME_THEME, 'selected_theme', 'selected_theme');
                $this->dynamic_theme = is_string($this->dynamic_theme) ? $this->hdd->safeFilename(trim($this->dynamic_theme)) : '';
                if ($this->dynamic_theme == '') $this->dynamic_theme = $this->default_theme;
                if ($this->dynamic_theme == '' || !$this->theme_in_list($this->themes, $this->dynamic_theme)) {
                    $this->dynamic_theme = $this->default_theme;
                    if ($this->dynamic_theme == '' || !$this->theme_in_list($this->themes, $this->dynamic_theme)) {
                        if (!empty($this->themes)) {
                            $this->dynamic_theme = reset($this->themes);
                            $this->dynamic_theme = isset($this->dynamic_theme->name) ? $this->dynamic_theme->name : '';
                            if ($this->dynamic_theme == '') {
                                echo 'Ошибка в списке шаблонов клиентской стороны. Невозможно отобразить страницу сайта.';
                                exit;
                            }
                        } else {
                            echo 'На сайте нет ни одного шаблона клиентской стороны. Невозможно отобразить страницу сайта.';
                            exit;
                        }
                    }
                }

                // если шаблон отличается от выбранного администратором, сохраняем в сеансе и куках пользовательский выбор
                $this->destroy_param('', 'selected_theme', 'selected_theme');
                if ($this->dynamic_theme != $this->default_theme) $this->add_param('', $this->dynamic_theme, 'selected_theme', 'selected_theme');

                // передаем в шаблонизатор имена текущего и дефолтного шаблонов
                $this->smarty->assignByRef(SMARTY_VAR_CURRENT_THEME, $this->dynamic_theme);
                $this->smarty->assignByRef(SMARTY_VAR_DEFAULT_THEME, $this->default_theme);

                // префикс для скомпилированных файлов шаблона будет равен имени выбранного шаблона
                $this->smarty->compile_id = str_replace('^', '_', $this->dynamic_theme);

                // сохраняем в сеансе выбранный вид листинга товаров (1 = стандартный построчный список, 0 = табличный упрощенный)
                if (isset($_REQUEST['standard_listing'])) {
                    $_SESSION['standard_listing'] = $_REQUEST['standard_listing'] == 1 ? 1 : 0;
                } else {
                    if (!isset($_SESSION['standard_listing'])) $_SESSION['standard_listing'] = 1;
                }

                // если пользователь просматривает субдомен, запоминаем
                if (isset($brand_subdomain)) $this->brand_subdomain = $brand_subdomain;

                // если это пользователь, пришедший по реферальной ссылке, запоминаем по чьей и с какого url
                if (isset($affiliate_id)) $this->affiliate_id = $affiliate_id;
                if (isset($affiliate_by_link)) $this->affiliate_by_link = $affiliate_by_link;

                // задаем оперативные папки для шаблонизатора (создавая папки при их отсутствии и защищая доступ к ним)
                $this->smarty->setCompileDir($this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'compiled' . $this->hdd->safeFilename($files_host_suffix), FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
                $this->smarty->setConfigDir($this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'configs' . $this->hdd->safeFilename($files_host_suffix), FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
                $this->smarty->setCacheDir($this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'cache' . $this->hdd->safeFilename($files_host_suffix), FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
                $this->smarty->setTemplateDir($this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html', FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
                $this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/css', FOLDER_GUARD_MODE_VIA_INDEX);
                $this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/images', FOLDER_GUARD_MODE_VIA_INDEX);
                $this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/js', FOLDER_GUARD_MODE_VIA_INDEX);

                // задаем политику безопасности шаблонизатора
                $policy = $this->smarty->createPolicy();
                $policy->secure_dir = array($this->smart_create_folder(ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->admin_folder) . '/design/default', FOLDER_GUARD_MODE_VIA_INDEX),
                                            $this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html', FOLDER_GUARD_MODE_VIA_HTACCESSINDEX),
                                            $this->smart_create_folder(ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html/../../common_parts', FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
                $this->smarty->enableSecurity($policy);

                $this->root_dir = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
                $this->smarty->assign('root_dir', $this->root_dir);
                $dir = trim(dirname($_SERVER['SCRIPT_NAME']));
                $dir = str_replace('\\', '/', $dir);
                if (isset($_SERVER['HTTP_HOST'])) $this->root_url = str_replace('\\', '/', strtolower(trim($_SERVER['HTTP_HOST'])));
                if ($dir != '/') $this->root_url = $this->root_url . $dir;

                // проверяем нахождение в субдомене бренда, категории, товара, пользователя
                $item = null;
                while (!empty($this->brand_subdomain)) {
                    $subdomain = implode('.', $this->brand_subdomain);
                    $params = new stdClass;
                    $params->enabled = 1;
                    $params->subdomain_enabled = 1;
                    $params->subdomain = $subdomain;
                    $this->db->get_brand($item, $params);
                    if (empty($item)) {
                        $params = new stdClass;
                        $params->enabled = 1;
                        $params->subdomain_enabled = 1;
                        $params->subdomain = $subdomain;
                        $this->db->get_category($item, $params);
                        if (empty($item)) {
                            $this->db->get_product_by_subdomain($item, $subdomain);
                            if (empty($item)) {
                                $params = new stdClass;
                                $params->enabled = 1;
                                $params->subdomain_enabled = 1;
                                $params->subdomain = $subdomain;
                                $this->db->users->one($item, $params);
                                if (empty($item)) {
                                    array_pop($this->brand_subdomain);
                                } else {
                                    break;
                                }
                            } else {
                                $_GET['module'] = 'Product';
                                $_GET['url'] = $item->product_id;
                                if (isset($_GET['brand'])) unset($_GET['brand']);
                                if (isset($_GET['category'])) unset($_GET['category']);
                                if (isset($_GET['section'])) unset($_GET['section']);
                                break;
                            }
                        } else {
                            $_GET['module'] = 'Products';
                            $_GET['category'] = $item->category_id;
                            if (isset($_GET['brand'])) unset($_GET['brand']);
                            if (isset($_GET['url'])) unset($_GET['url']);
                            if (isset($_GET['section'])) unset($_GET['section']);
                            break;
                        }
                    } else {
                        $_GET['module'] = 'Products';
                        $_GET['brand'] = $item->brand_id;
                        if (isset($_GET['category'])) unset($_GET['category']);
                        if (isset($_GET['url'])) unset($_GET['url']);
                        if (isset($_GET['section'])) unset($_GET['section']);
                        break;
                    }
                }
                $this->brand_subdomain = implode('.', $this->brand_subdomain);
                if ($this->brand_subdomain != '') {
                    if (!empty($item)) {
                        if (substr($this->root_url, 0, strlen($this->brand_subdomain) + 1) == $this->brand_subdomain . '.') {
                            $this->root_url = substr($this->root_url, strlen($this->brand_subdomain) + 1);
                        }
                    } else {
                        $this->root_url = $this->brand_subdomain . '.' . $this->root_url;
                    }
                }

                // передаем настройки сайта в шаблонизатор (для работоспособности старых шаблонов,
                // использующих шаблонизированную переменную $settings->theme вместо позднее появившейся
                // переменной $theme, подменяем в настройках сведения о дефолтном дизайне сайта, то есть
                // предложенном администратором, на сведения о динамическом выборе дизайна пользователем)
                $this->settings->theme = $this->dynamic_theme;
                $this->smarty->assignByRef(SMARTY_VAR_SETTINGS, $this->settings);

                $this->smarty->assignByRef('root_url', $this->root_url);
                $this->smarty->assign('admin_folder', $this->hdd->safeFilename($this->admin_folder));
                $this->smarty->assignByRef(SMARTY_VAR_CONFIG, $this->config);
                $this->smarty->assignByRef('files_host_suffix', $this->settings->files_host_suffix);
                if (extension_loaded('gd')) {
                    $this->gd_loaded = TRUE;
                    $this->use_gd = TRUE;
                }
                $this->smarty->assignByRef('gd_loaded', $this->gd_loaded);
                $this->smarty->assignByRef('UseGd', $this->use_gd);

                // проверяем наличие авторизованного пользователя
                $this->user = null;
                $email = $this->session->get('user_email', '');
                $email2 = $this->session->get('user_email2', '');
                if ($email != '' || $email2 != '') {
                    $password = $this->session->get('user_password', '');
                    if ($password != '') {
                        $params = new stdClass;
                        $params->enabled = 1;
                        $params->email = $email;
                        $params->email2 = $email2;
                        $params->password = $password;
                        $this->db->users->one($this->user, $params);
                        $this->smarty->assignByRef('user', $this->user);
                    }
                }
                if (empty($this->user)) {
                    if ($this->affiliate_by_link != '' || !$this->settings->affiliates_referal_urlchecking) {
                        $this->registrar->registerReferal($this->affiliate_id, $this->affiliate_by_link);
                    }
                } else {
                    $this->affiliate_id = !empty($this->user->affiliate_id) ? $this->user->affiliate_id : null;
                }
                if (!empty($item) && isset($item->subdomain_html) && trim($item->subdomain_html) != '') {
                    echo trim($item->subdomain_html);
                    exit;
                }

                // передаем валюты в шаблонизатор
                $this->put_currencies_to_Smarty(BASIC_START_FOR_CLIENT_MODE);

                // генерируем аутентификатор операции
                if (empty($_GET) && empty($_POST) && !isset($_SESSION[REQUEST_PARAM_NAME_TOKEN])) {
                    $this->security->generateTokenForObject($this);
                } else {
                    if (isset($_SESSION[REQUEST_PARAM_NAME_TOKEN]) && !empty($_SESSION[REQUEST_PARAM_NAME_TOKEN])) {
                        $this->token = $_SESSION[REQUEST_PARAM_NAME_TOKEN];
                    } else {
                        $this->security->generateTokenForObject($this);
                    }
                }
                $this->smarty->assignByRef('Token', $this->token);
                $this->smarty->assign('IMPERA_CMS_version', IMPERA_CMS_CURRENT_VERSION);

                // создаем список сортировок товаров в форме клиентской стороны
                $this->set_sort_form();

                // если клиентская форма сортировки товаров разрешена в настройках сайта
                if ($this->settings->sort_form_enabled) {

                    // получить из клиентской формы выбранный способ сортировки
                    // (заполнятся переменные $this->sort_products_mode, $this->sort_products_direction, $this->sort_products_laconical)
                    $this->get_sort_products_mode();

                    // получаем html-контент клиентской формы сортировок
                    $sort_form = $this->get_sort_form();

                // иначе клиентская форма сортировки товаров запрещена
                } else {

                    // считаем, что сортировка будет как задана в настройках админпанели на странице "товары"
                    $this->sort_products_mode = $this->settings->products_sort_method;
                    $this->sort_products_direction = $this->settings->products_sort_direction;
                    $this->sort_products_laconical = $this->settings->products_sort_laconical;

                    // удаляем контент формы сортировки
                    $sort_form = '';
                }

                // передаем данные формы сортировки в шаблонизатор
                $this->smarty->assignByRef('sort_form', $sort_form);
                $this->smarty->assignByRef('sort_form_field', $this->sort_products_mode);
                $this->smarty->assignByRef('sort_form_descending', $this->sort_products_direction);
                $this->smarty->assignByRef('sort_form_laconical', $this->sort_products_laconical);
            }

            // передаем в шаблонизатор url корневой папки сайта и папки шаблона (дизайна) клиентской стороны
            $this->site_url = 'http://' . $this->root_url . '/';
            $this->theme_url = $this->site_url . 'design/' . $this->dynamic_theme . '/';
            $this->smarty->assignByRef(SMARTY_VAR_SITE_URL, $this->site_url);
            $this->smarty->assignByRef(SMARTY_VAR_THEME_URL, $this->theme_url);

            // если доступен хелпер шаблона, подключаем
            $path = ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html/';
            $file = 'helper.php';
            if (file_exists($path . $file)) {
                @ require_once($path . $file);
                if (class_exists('TemplateEmulator')) $this->designer = new TemplateEmulator($this);
            } else {
                $file = 'emulator.php';
                if (file_exists($path . $file)) {
                    @ require_once($path . $file);
                    if (class_exists('TemplateEmulator')) $this->designer = new TemplateEmulator($this);
                }
            }
        }
    }



        // ===================================================================
        /**
        *  Запуск языкового модуля
        *
        *  @access  protected
        *  @param   boolean $client     TRUE если клиентский (по умолчанию TRUE)
        *                               FALSE если админский
        *  @return  void
        */
        // ===================================================================

        protected function startLanguage ( $client = TRUE ) {
            $ok = FALSE;
            if (isset($this->config->lang) && is_string($this->config->lang)) {
                $lang = preg_replace('/[^a-z]/ui', '', $this->config->lang);
                if ($lang != '') {
                    $lang = $this->text->lowerCase($lang);
                    $file = '/Language.' . $lang . ($client ? '' : '.admin') . '.php';
                    $file = dirname(__FILE__) . ($client ? '' : '/../' . $this->hdd->safeFilename($this->admin_folder)) . $file;
                    if ($this->hdd->isReadableFile($file)) {
                        require_once($file);
                        $class = 'Language' . ucfirst($lang) . ($client ? '' : 'Admin');
                        if (class_exists($class)) {
                            $methods = get_class_methods($class);
                            if (in_array('translate', $methods)) {
                                $this->lang = new $class();
                                $ok = TRUE;
                            }
                        }
                    }
                }
            }
            if (!$ok && isset($this->lang)) $this->lang->start();
            $this->smarty->assignByRef('lang', $this->lang);
        }



    // псевдо конструктор класса для админпанели =============================

    private function Basic_Admin () {

      // ссылаемся на глобальные переменные
      global $files_host_suffix;

      // обеспечиваем наличие папок шаблона админпанели (создавая папки при их отсутствии и защищая доступ к ним)
      $admin_tpl = ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->admin_folder) . "/design/" . $this->hdd->safeFilename($this->settings->admin_theme);
      $this->smart_create_folder($admin_tpl, FOLDER_GUARD_MODE_VIA_INDEX);
      $this->smart_create_folder($admin_tpl . "/css", FOLDER_GUARD_MODE_VIA_INDEX);
      $this->smart_create_folder($admin_tpl . "/images", FOLDER_GUARD_MODE_VIA_INDEX);
      $this->smart_create_folder($admin_tpl . "/js", FOLDER_GUARD_MODE_VIA_INDEX);
      $admin_tpl = $this->smart_create_folder($admin_tpl . "/html", FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);
      $admin_common_tpl = $this->smart_create_folder($admin_tpl . "/../../common_parts", FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);

      // обеспечиваем наличие папок клиентского шаблона (создавая папки при их отсутствии и защищая доступ к ним)
      $client_tpl = ROOT_FOLDER_REFERENCE . "design/" . $this->dynamic_theme;
      $this->smart_create_folder($client_tpl, FOLDER_GUARD_MODE_VIA_INDEX);
      $this->smart_create_folder($client_tpl . "/css", FOLDER_GUARD_MODE_VIA_INDEX);
      $this->smart_create_folder($client_tpl . "/images", FOLDER_GUARD_MODE_VIA_INDEX);
      $this->smart_create_folder($client_tpl . "/js", FOLDER_GUARD_MODE_VIA_INDEX);
      $client_tpl = $this->smart_create_folder($client_tpl . "/html", FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);
      $client_common_tpl = $this->smart_create_folder($client_tpl . "/../../common_parts", FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);

      // задаем оперативные папки для шаблонизатора (создавая папки при их отсутствии и защищая доступ к ним)
      $this->smarty->setCompileDir($this->smart_create_folder("compiled" . $this->hdd->safeFilename($files_host_suffix), FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
      $this->smarty->setConfigDir($this->smart_create_folder("configs" . $this->hdd->safeFilename($files_host_suffix), FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
      $this->smarty->setCacheDir($this->smart_create_folder("cache" . $this->hdd->safeFilename($files_host_suffix), FOLDER_GUARD_MODE_VIA_HTACCESSINDEX));
      $this->smarty->setTemplateDir(array($admin_tpl,
                                          "client" => $client_tpl));

      // задаем политику безопасности шаблонизатора
      $policy = $this->smarty->createPolicy();
      $policy->secure_dir = array($admin_tpl,
                                  $admin_common_tpl,
                                  $client_tpl,
                                  $client_common_tpl);
      $this->smarty->enableSecurity($policy);

      $this->root_dir = rtrim(dirname(dirname(($_SERVER["PHP_SELF"]))), "/");
      $this->smarty->assignByRef("root_dir", $this->root_dir);
      $dir = trim(dirname(dirname($_SERVER["SCRIPT_NAME"])));
      $dir = str_replace("\\", "/", $dir);
      if (isset($_SERVER["HTTP_HOST"])) $this->root_url = str_replace("\\", "/", strtolower(trim($_SERVER["HTTP_HOST"])));
      if ($dir != "/") $this->root_url = $this->root_url . $dir;
      $this->smarty->assign("root_url", $this->root_url);
      $this->smarty->assign("admin_folder", $this->hdd->safeFilename($this->admin_folder));
      $this->put_currencies_to_Smarty(BASIC_START_FOR_ADMIN_MODE);
      if (extension_loaded("gd")) $this->use_gd = TRUE;
      if (empty($_GET) && empty($_POST) && !isset($_SESSION[REQUEST_PARAM_NAME_TOKEN])) {
        $this->security->generateTokenForObject($this);
      } else {
        if (isset($_SESSION[REQUEST_PARAM_NAME_TOKEN]) && !empty($_SESSION[REQUEST_PARAM_NAME_TOKEN])) {
          $this->token = $_SESSION[REQUEST_PARAM_NAME_TOKEN];
        } else {
          $this->security->generateTokenForObject($this);
        }
      }
      $this->smarty->assignByRef("Token", $this->token);
      $this->smarty->assignByRef("UseGd", $this->use_gd);
      $this->smarty->assignByRef("gd_loaded", $this->use_gd);
      $this->smarty->assignByRef(SMARTY_VAR_SETTINGS, $this->settings);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_SETTINGS, $this->settings);
      $this->smarty->assignByRef(SMARTY_VAR_CONFIG, $this->config);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_CONFIG, $this->config);
      $this->smarty->assign("files_host_suffix", $this->hdd->safeFilename($this->settings->files_host_suffix));
      $this->smarty->assign("IMPERA_CMS_version", IMPERA_CMS_CURRENT_VERSION);

      // префикс для скомпилированных файлов шаблона будет равен имени выбранного шаблона
      $this->smarty->compile_id = str_replace('^' , '_', $this->hdd->safeFilename(trim($this->settings->admin_theme)));
    }



        // TODO: метод нужно будет перенести в .def-models/AdminPage.php и автоопределять root-положение модуля

        protected function fetchAdminTemplate ( $from_objects_root = TRUE ) {
            $items = is_array($this->template) ? $this->template : array($this->template);
            if (!empty($items)) {
                $folder = $this->hdd->safeFilename($this->admin_folder);
                if ($folder != '') {
                    $theme = $this->request->settings->getAsSentence('admin_theme');
                    $theme = $this->hdd->safeFilename($theme);
                    if ($theme != '') {
                        $path = dirname(__FILE__) . ($from_objects_root ? '/../' : '/../../') . $folder . '/design/' . $theme . '/html/';
                        foreach ($items as $template) {
                            if (is_string($template)) {
                                $file = $this->hdd->safeFilename($template, FALSE);
                                if ($file != '') {
                                    if ($this->hdd->isReadableFile($path . $file)) {
                                        $this->body = $this->smarty->fetch($file);
                                        return;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->body = $this->smarty->fetch(reset($items));
        }



    // получение списка шаблонов =============================================

    public function get_themes_list ($for_adminpanel = FALSE) {

      // вычисляем путь папки шаблонов
      $path = ROOT_FOLDER_REFERENCE;
      if ($for_adminpanel) $path .= $this->hdd->safeFilename($this->admin_folder) . "/";
      $path .=  "design/";

      // открываем папку
      $result = array();
      if (($handle = @ opendir($path)) !== FALSE) {

        // перебираем файлы в папке
        while (($file = @ readdir($handle)) !== FALSE) {
          if (trim($file, '.') != '') {

            // если это папка
            if (is_dir($path . $file)) {

              // если папка не системная и названа английскими буквами без пробелов (допустимы точки, тире, подчеркивания),
              // не превышая 48 символов в длину, и содержит в себе папку для TPL-файлов
              if (strtolower(substr($file, 6)) != 'common'
              && $this->hdd->safeFilename($file, TRUE, 48) == $file
              && file_exists($path . $file . '/html')
              && is_dir($path . $file . '/html')) {

                // добавляем имя папки (шаблона) в список
                $item = new stdClass;
                $item->name = $file;
                $item->enabled = TRUE;
                $result[$file] = $item;
              }
            }
          }
        }
      }

      // возвращаем упорядоченный по алфавиту список шаблонов
      if (!empty($result)) ksort($result, SORT_STRING);
      return $result;
    }

    // получение булевого признака "такой шаблон есть в списке шаблонов" =====

    public function theme_in_list (&$themes = array(), $theme = "") {

      // перебираем шаблоны
      foreach ($themes as &$item) {

        // если шаблон найден, возвращаем ТАКОЙ ШАБЛОН ЕСТЬ В СПИСКЕ
        if (isset($item->name) && ($item->name == $theme)) return TRUE;
      }

      // возвращаем ТАКОГО ШАБЛОНА НЕТ В СПИСКЕ
      return FALSE;
    }



        // ===================================================================
        /**
        *  Создание объекта конфигурации
        *
        *  @access  private
        *  @return  void
        */
        // ===================================================================

        private function create_configuration_object () {

            // создаем объект
            $this->config = new Config();



            // проверяем задание доступа к MySQL
            $this->config->dbname = isset($this->config->dbname) && is_string($this->config->dbname)
                                    ? trim($this->config->dbname)
                                    : 'impera_demo';
            $this->config->dbhost = isset($this->config->dbhost) && is_string($this->config->dbhost)
                                    ? trim($this->config->dbhost)
                                    : 'localhost';
            $this->config->dbuser = isset($this->config->dbuser) && is_string($this->config->dbuser)
                                    ? trim($this->config->dbuser)
                                    : 'root';
            $this->config->dbpass = isset($this->config->dbpass) && is_string($this->config->dbpass)
                                    ? trim($this->config->dbpass)
                                    : '';



            // проверяем задание языка интерфейса сайта
            $this->config->lang = isset($this->config->lang) && is_string($this->config->lang)
                                  ? strtolower(trim($this->config->lang))
                                  : '';
            switch ($this->config->lang) {
                case 'eng':
                case 'de':
                case 'by':
                case 'rus':
                case 'ukr':
                case 'md':
                    break;
                case 'en':
                    $this->config->lang = 'eng';
                    break;
                case 'ua':
                    $this->config->lang = 'ukr';
                    break;
                case 'ru':
                default:
                    $this->config->lang = 'rus';
            }



            // проверяем задание режима работы (в демо режиме отключаем сообщение об ошибках)
            $this->config->demo = isset($this->config->demo) ? $this->config->demo == TRUE : FALSE;
            if ($this->config->demo) error_reporting(0);



            // проверяем задание режима отладки
            $this->config->debug = isset($this->config->debug) ? $this->config->debug == TRUE : FALSE;
            $this->config->debug_on_admin_exist = isset($this->config->debug_on_admin_exist) ? $this->config->debug_on_admin_exist == TRUE : TRUE;



            // загружаем структуры параметров из XML
            impera_LoadXmlResources($this->config);
        }













    private function check_and_correct_settings ( & $settings ) {

      // ссылаемся на глобальные переменные
      global $files_host_suffix;

      // открываем трассировку этого метода
      $this->db->open_tracing_method('BASIC check_and_correct_settings');

      $CRLF = "\r\n";
      if (!is_object($settings)) $settings = new stdClass;

      // проверяем настройки для дизайна
      if (!isset($settings->theme)) $settings->theme = "default_new";
        $settings->theme = $this->hdd->safeFilename($settings->theme);
      if (!isset($settings->theme_nodynamic)) $settings->theme_nodynamic = FALSE;
      if (!isset($settings->admin_theme)) $settings->admin_theme = "default";
        $settings->admin_theme = $this->hdd->safeFilename($settings->admin_theme);
      if (!isset($settings->site_name)) $settings->site_name = "Интернет-магазин " . $this->root_url;
      if (!isset($settings->company_name)) $settings->company_name = "Сайт " . $this->root_url;

      // проверяем настройки контента главной страницы по умолчанию
      if (!isset($settings->main_section)) $settings->main_section = "cat";
      if (!isset($settings->main_mobile_section)) $settings->main_mobile_section = "cat";

      // проверяем настройки клиентской формы сортировки товаров
      if (!isset($settings->sort_form_enabled)) $settings->sort_form_enabled = TRUE;
      if (!isset($settings->sort_form_default_method)) $settings->sort_form_default_method = SORT_PRODUCTS_MODE_BY_PRICE;
      if (!isset($settings->sort_form_default_descending)) $settings->sort_form_default_descending = SORT_DIRECTION_ASCENDING;
      if (!isset($settings->sort_form_default_laconical)) $settings->sort_form_default_laconical = 0;

      if (isset($settings->livehelp_siteheart_id) == FALSE) $settings->livehelp_siteheart_id = "";
      if (isset($settings->technical_works_enabled) == FALSE) $settings->technical_works_enabled = 0;
      if (isset($settings->technical_works_html) == FALSE) $settings->technical_works_html = "<html>\r\n"
                                                                                           . "  <head>\r\n"
                                                                                           . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n"
                                                                                           . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
                                                                                           . "    <meta http-equiv=\"Expires\" content=\"0\">\r\n"
                                                                                           . "    <meta http-equiv=\"Refresh\" content=\"30\">\r\n"
                                                                                           . "    <title>Технические работы на сайте</title>\r\n"
                                                                                           . "  </head>\r\n"
                                                                                           . "  <body>\r\n"
                                                                                           . "    <center>\r\n"
                                                                                           . "      <br><br><br><br><br>\r\n"
                                                                                           . "      <table align=\"center\" border=\"0\" cellpadding=\"20\" cellspacing=\"0\">\r\n"
                                                                                           . "        <tr>\r\n"
                                                                                           . "          <td nowrap style=\"background-color: #E0E0E0; border: #C0C0C0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt;\">\r\n"
                                                                                           . "            Сейчас на сайте ведутся технические работы.<br>\r\n"
                                                                                           . "            Ожидаемое время окончания работ: {\$date} {\$time}\r\n"
                                                                                           . "          </td>\r\n"
                                                                                           . "        </tr>\r\n"
                                                                                           . "      </table>\r\n"
                                                                                           . "    </center>\r\n"
                                                                                           . "  </body>\r\n"
                                                                                           . "</html>\r\n";
      if (isset($settings->technical_works_date) == FALSE) $settings->technical_works_date = "";
      if (isset($settings->technical_works_time) == FALSE) $settings->technical_works_time = "";
      if (isset($settings->mainpage_no_articles) == FALSE) $settings->mainpage_no_articles = 0;
      if (isset($settings->mainpage_sortform_enabled) == FALSE) $settings->mainpage_sortform_enabled = 0;
      if (isset($settings->productpage_block_columns) == FALSE) $settings->productpage_block_columns = 2;
      $settings->productpage_block_columns = $this->number->mustbeIntegerRange($settings->productpage_block_columns, 1, 100);
      if (isset($settings->productpage_no_mores) == FALSE) $settings->productpage_no_mores = 0;
      if (isset($settings->productpage_mores_excludeme) == FALSE) $settings->productpage_mores_excludeme = 1;
      if (isset($settings->productpage_mores_spacefill) == FALSE) $settings->productpage_mores_spacefill = 0;
      if (isset($settings->productpage_mores_count) == FALSE) $settings->productpage_mores_count = 6;
      if (isset($settings->productpage_mores_caption) == FALSE) $settings->productpage_mores_caption = "Похожие продукты";
      $settings->productpage_mores_count = $this->number->mustbeIntegerRange($settings->productpage_mores_count, 1, 100);
      if (isset($settings->productpage_no_hits) == FALSE) $settings->productpage_no_hits = 0;
      if (isset($settings->productpage_hits_excludeme) == FALSE) $settings->productpage_hits_excludeme = 0;
      if (isset($settings->productpage_hits_spacefill) == FALSE) $settings->productpage_hits_spacefill = 0;
      if (isset($settings->productpage_hits_count) == FALSE) $settings->productpage_hits_count = 4;
      if (isset($settings->productpage_hits_caption) == FALSE) $settings->productpage_hits_caption = "Хиты продаж";
      $settings->productpage_hits_count = $this->number->mustbeIntegerRange($settings->productpage_hits_count, 1, 100);
      if (isset($settings->productpage_no_newests) == FALSE) $settings->productpage_no_newests = 0;
      if (isset($settings->productpage_newests_excludeme) == FALSE) $settings->productpage_newests_excludeme = 0;
      if (isset($settings->productpage_newests_spacefill) == FALSE) $settings->productpage_newests_spacefill = 0;
      if (isset($settings->productpage_newests_count) == FALSE) $settings->productpage_newests_count = 4;
      if (isset($settings->productpage_newests_caption) == FALSE) $settings->productpage_newests_caption = "Новые поступления";
      $settings->productpage_newests_count = $this->number->mustbeIntegerRange($settings->productpage_newests_count, 1, 100);
      if (isset($settings->productpage_no_actionals) == FALSE) $settings->productpage_no_actionals = 0;
      if (isset($settings->productpage_actionals_excludeme) == FALSE) $settings->productpage_actionals_excludeme = 0;
      if (isset($settings->productpage_actionals_spacefill) == FALSE) $settings->productpage_actionals_spacefill = 0;
      if (isset($settings->productpage_actionals_count) == FALSE) $settings->productpage_actionals_count = 4;
      if (isset($settings->productpage_actionals_caption) == FALSE) $settings->productpage_actionals_caption = "Специальное предложение";
      $settings->productpage_actionals_count = $this->number->mustbeIntegerRange($settings->productpage_actionals_count, 1, 100);
      if (isset($settings->productpage_no_awaiteds) == FALSE) $settings->productpage_no_awaiteds = 0;
      if (isset($settings->productpage_awaiteds_excludeme) == FALSE) $settings->productpage_awaiteds_excludeme = 0;
      if (isset($settings->productpage_awaiteds_spacefill) == FALSE) $settings->productpage_awaiteds_spacefill = 0;
      if (isset($settings->productpage_awaiteds_count) == FALSE) $settings->productpage_awaiteds_count = 4;
      if (isset($settings->productpage_awaiteds_caption) == FALSE) $settings->productpage_awaiteds_caption = "Скоро в продаже";
      $settings->productpage_awaiteds_count = $this->number->mustbeIntegerRange($settings->productpage_awaiteds_count, 1, 100);
      if (isset($settings->productpage_no_ordereds) == FALSE) $settings->productpage_no_ordereds = 0;
      if (isset($settings->productpage_ordereds_excludeme) == FALSE) $settings->productpage_ordereds_excludeme = 0;
      if (isset($settings->productpage_ordereds_spacefill) == FALSE) $settings->productpage_ordereds_spacefill = 0;
      if (isset($settings->productpage_ordereds_count) == FALSE) $settings->productpage_ordereds_count = 4;
      if (isset($settings->productpage_ordereds_caption) == FALSE) $settings->productpage_ordereds_caption = "Что покупают другие";
      $settings->productpage_ordereds_count = $this->number->mustbeIntegerRange($settings->productpage_ordereds_count, 1, 100);
      if (isset($settings->productpage_no_commenteds) == FALSE) $settings->productpage_no_commenteds = 0;
      if (isset($settings->productpage_commenteds_excludeme) == FALSE) $settings->productpage_commenteds_excludeme = 0;
      if (isset($settings->productpage_commenteds_spacefill) == FALSE) $settings->productpage_commenteds_spacefill = 0;
      if (isset($settings->productpage_commenteds_count) == FALSE) $settings->productpage_commenteds_count = 4;
      if (isset($settings->productpage_commenteds_caption) == FALSE) $settings->productpage_commenteds_caption = "О чём отзываются";
      $settings->productpage_commenteds_count = $this->number->mustbeIntegerRange($settings->productpage_commenteds_count, 1, 100);
      if (isset($settings->product_adimage_effect) == FALSE) $settings->product_adimage_effect = "enlarge";
      if (isset($settings->images_caching_enabled) == FALSE) $settings->images_caching_enabled = 0;
      if (isset($settings->images_caching_for_localhost_enabled) == FALSE) $settings->images_caching_for_localhost_enabled = 0;
      if (isset($settings->images_caching_lifetime) == FALSE) $settings->images_caching_lifetime = EXTERNAL_IMAGES_CACHING_LIFETIME;
      if (isset($settings->images_caching_filelimit) == FALSE) $settings->images_caching_filelimit = EXTERNAL_IMAGES_CACHING_FILELIMIT;
      if (isset($settings->images_caching_timelimit) == FALSE) $settings->images_caching_timelimit = EXTERNAL_IMAGES_CACHING_TIMELIMIT;
      if (isset($settings->images_caching_ip_resolves) == FALSE) $settings->images_caching_ip_resolves = "";
      $settings->files_host_suffix = $this->hdd->safeFilename($files_host_suffix);
      if (isset($settings->meta_autofill) == FALSE) $settings->meta_autofill = 1;



        // проверяем настройки для корзины
        $field = 'cart_enable_reservation';    if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'cart_open_method';           if (!isset($settings->$field)) $settings->$field = CART_OPEN_METHOD_OVERPAGE;
        $field = 'cart_auto_registration';     if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'cart_auto_registration_msg'; if (!isset($settings->$field)) $settings->$field = 'Обратите внимание! Наш магазин предоставляет скидки постоянным клиентам. '
                                                                                                . 'Если при оформлении заказа Вы заполните свой емейл, и ещё не имеете '
                                                                                                . 'регистрации в нашем магазине, автоматически зарегистрируем Вас как '
                                                                                                . 'постоянного клиента и вышлем пароль на указанный емейл.';
        $field = 'cart_captcha_protecting';    if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'cart_reservation_text';      if (!isset($settings->$field)) $settings->$field = 'Этот товар оформляется под заказ, срок поставки будет уточнен менеджером при личном контакте.';
        $field = 'cart_title_text';            if (!isset($settings->$field)) $settings->$field = 'Корзина';
        $field = 'cart_info_text';             if (!isset($settings->$field)) $settings->$field = '<div class="cart_text">' . $CRLF
                                                                                                    . 'Для оформления заказа необходимо развернуть ниже секцию с информацией о покупателе, '
                                                                                                    . 'ввести контактную информацию, если её поля пустые, и отправить заказ.' . $CRLF
                                                                                                . '</div>' . $CRLF
                                                                                                . '<div class="cart_text">' . $CRLF
                                                                                                    . 'Другой способ доставки можно выбрать развернув секцию с информацией о вариантах доставки.' . $CRLF
                                                                                                . '</div>' . $CRLF
                                                                                                . '<div class="cart_text">' . $CRLF
                                                                                                    . 'Чтобы удалить товар из корзины, нажмите в приведённом ниже счёте красный крестик '
                                                                                                    . 'справа от лишнего товара.' . $CRLF
                                                                                                . '</div>' . $CRLF
                                                                                                . '<div class="cart_text">' . $CRLF
                                                                                                    . 'Выбрать другое количество заказываемого товара, если на текущий момент он имеется '
                                                                                                    . 'не в единичном экземпляре, можно в выпадающем списке колонки количества напротив нужного товара.' . $CRLF
                                                                                                . '</div>';
        $field = 'cart_show_info';             if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cart_header_number';         if (!isset($settings->$field)) $settings->$field = '№';
        $field = 'cart_header_name';           if (!isset($settings->$field)) $settings->$field = 'Товар';
        $field = 'cart_header_quantity';       if (!isset($settings->$field)) $settings->$field = 'Кол-во';
        $field = 'cart_header_price';          if (!isset($settings->$field)) $settings->$field = 'Цена';
        $field = 'cart_header_sum';            if (!isset($settings->$field)) $settings->$field = 'Сумма';
        $field = 'cart_contacts_maximize';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cart_deliveries_maximize';   if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cart_submit_text';           if (!isset($settings->$field)) $settings->$field = 'Оформить';



        // проверяем настройки для быстрого заказа (выбор всех доступных товаров с одной страницы)
        $field = 'quickorder_sort_method';        if (!isset($settings->$field)) $settings->$field = SORT_CATEGORIES_MODE_AS_IS;
        $field = 'quickorder_label_name';         if (!isset($settings->$field)) $settings->$field = 'Фамилия';
        $field = 'quickorder_show_name';          if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_name2';        if (!isset($settings->$field)) $settings->$field = 'Отчество';
        $field = 'quickorder_show_name2';         if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_name3';        if (!isset($settings->$field)) $settings->$field = 'Имя';
        $field = 'quickorder_show_name3';         if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_email';        if (!isset($settings->$field)) $settings->$field = 'Емейл';
        $field = 'quickorder_show_email';         if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_email2';       if (!isset($settings->$field)) $settings->$field = 'Ещё (Емейл)';
        $field = 'quickorder_show_email2';        if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_phone';        if (!isset($settings->$field)) $settings->$field = 'Телефон';
        $field = 'quickorder_show_phone';         if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_phone2';       if (!isset($settings->$field)) $settings->$field = 'Ещё (Телефон)';
        $field = 'quickorder_show_phone2';        if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_icq';          if (!isset($settings->$field)) $settings->$field = 'ICQ';
        $field = 'quickorder_show_icq';           if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'quickorder_label_icq2';         if (!isset($settings->$field)) $settings->$field = 'Ещё (ICQ)';
        $field = 'quickorder_show_icq2';          if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'quickorder_label_skype';        if (!isset($settings->$field)) $settings->$field = 'Skype';
        $field = 'quickorder_show_skype';         if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'quickorder_label_skype2';       if (!isset($settings->$field)) $settings->$field = 'Ещё (Skype)';
        $field = 'quickorder_show_skype2';        if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'quickorder_label_address';      if (!isset($settings->$field)) $settings->$field = 'Страна';
        $field = 'quickorder_show_address';       if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_2';    if (!isset($settings->$field)) $settings->$field = 'Область';
        $field = 'quickorder_show_address_2';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_3';    if (!isset($settings->$field)) $settings->$field = 'Город';
        $field = 'quickorder_show_address_3';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_4';    if (!isset($settings->$field)) $settings->$field = 'Улица';
        $field = 'quickorder_show_address_4';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_5';    if (!isset($settings->$field)) $settings->$field = 'Дом';
        $field = 'quickorder_show_address_5';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_6';    if (!isset($settings->$field)) $settings->$field = 'Корпус';
        $field = 'quickorder_show_address_6';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_7';    if (!isset($settings->$field)) $settings->$field = 'Подъезд';
        $field = 'quickorder_show_address_7';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_8';    if (!isset($settings->$field)) $settings->$field = 'Код';
        $field = 'quickorder_show_address_8';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_9';    if (!isset($settings->$field)) $settings->$field = 'Квартира';
        $field = 'quickorder_show_address_9';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address_10';   if (!isset($settings->$field)) $settings->$field = 'Индекс';
        $field = 'quickorder_show_address_10';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2';     if (!isset($settings->$field)) $settings->$field = 'Ещё (Страна)';
        $field = 'quickorder_show_address2';      if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_2';   if (!isset($settings->$field)) $settings->$field = 'Ещё (Область)';
        $field = 'quickorder_show_address2_2';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_3';   if (!isset($settings->$field)) $settings->$field = 'Ещё (Город)';
        $field = 'quickorder_show_address2_3';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_4';   if (!isset($settings->$field)) $settings->$field = 'Ещё (Улица)';
        $field = 'quickorder_show_address2_4';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_5';   if (!isset($settings->$field)) $settings->$field = 'Дом';
        $field = 'quickorder_show_address2_5';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_6';   if (!isset($settings->$field)) $settings->$field = 'Корпус';
        $field = 'quickorder_show_address2_6';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_7';   if (!isset($settings->$field)) $settings->$field = 'Подъезд';
        $field = 'quickorder_show_address2_7';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_8';   if (!isset($settings->$field)) $settings->$field = 'Код';
        $field = 'quickorder_show_address2_8';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_9';   if (!isset($settings->$field)) $settings->$field = 'Квартира';
        $field = 'quickorder_show_address2_9';    if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_address2_10';  if (!isset($settings->$field)) $settings->$field = 'Ещё (Индекс)';
        $field = 'quickorder_show_address2_10';   if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_to_date';      if (!isset($settings->$field)) $settings->$field = 'Желательно';
        $field = 'quickorder_show_to_date';       if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_to_date_editable';   if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_to_time';      if (!isset($settings->$field)) $settings->$field = 'время';
        $field = 'quickorder_show_to_time';       if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_to_time_editable';   if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_comment';      if (!isset($settings->$field)) $settings->$field = 'Комментарий к заказу';
        $field = 'quickorder_show_comment';       if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_label_delivery';     if (!isset($settings->$field)) $settings->$field = 'Доставка';
        $field = 'quickorder_show_delivery';      if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_header_category';    if (!isset($settings->$field)) $settings->$field = 'Категория';
        $field = 'quickorder_header_name';        if (!isset($settings->$field)) $settings->$field = 'Наименование';
        $field = 'quickorder_header_quantity';    if (!isset($settings->$field)) $settings->$field = 'Кол-во';
        $field = 'quickorder_header_sum';         if (!isset($settings->$field)) $settings->$field = 'Сумма';
        $field = 'quickorder_submit_text';        if (!isset($settings->$field)) $settings->$field = 'Сделать заказ';
        $field = 'quickorder_captcha_protecting'; if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'quickorder_title_text';         if (!isset($settings->$field)) $settings->$field = 'Быстрый заказ';
        $field = 'quickorder_show_info';          if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'quickorder_info_text';          if (!isset($settings->$field)) $settings->$field = '<div class="configurator_text">' . $CRLF
                                                                                                       . 'Чтобы сделать быстрый заказ, необходимо заполнить контактно-доставочную информацию '
                                                                                                       . 'по формируемому заказу, в таблице выбрать и указать требуемое количество желаемых '
                                                                                                       . 'товаров, при необходимости щелкая по ссылкам категорий для разворота или сворачивания '
                                                                                                       . 'их подкатегорий, и затем отправить оформленный заказ.' . $CRLF
                                                                                                   . '</div>' . $CRLF
                                                                                                   . '<div class="configurator_text">' . $CRLF
                                                                                                       . 'Если информация по заказу заполнена правильно, он будет сформирован и вы попадёте '
                                                                                                       . 'на страницу этого заказа. Если же какие-то из необходимых полей окажутся незаполненными, '
                                                                                                       . 'содержимое заказа будет направлено в корзину, страница которой немедленно откроется, '
                                                                                                       . 'чтобы вы могли указать недостающие сведения.' . $CRLF
                                                                                                   . '</div>';

      if (isset($settings->vkontakte_publish_enabled) == FALSE) $settings->vkontakte_publish_enabled = 1;
      if (isset($settings->vkontakte_publish_selected_only) == FALSE) $settings->vkontakte_publish_selected_only = 0;
      if (isset($settings->vkontakte_publish_javascript) == FALSE) $settings->vkontakte_publish_javascript = 0;
      if (isset($settings->vkontakte_publish_label) == FALSE) $settings->vkontakte_publish_label = 'Разместить у себя<br>ВКонтакте';
      if (isset($settings->vkontakte_wishlist_enabled) == FALSE) $settings->vkontakte_wishlist_enabled = 0;
      if (isset($settings->vkontakte_wishlist_selected_only) == FALSE) $settings->vkontakte_wishlist_selected_only = 0;
      if (isset($settings->vkontakte_wishlist_testmode) == FALSE) $settings->vkontakte_wishlist_testmode = 1;
      if (isset($settings->vkontakte_wishlist_delivery_cost) == FALSE) $settings->vkontakte_wishlist_delivery_cost = '';
      if (isset($settings->vkontakte_wishlist_cost_increase) == FALSE) $settings->vkontakte_wishlist_cost_increase = 0;
      if (isset($settings->vkontakte_wishlist_label) == FALSE) $settings->vkontakte_wishlist_label = 'Хочу';
      if (isset($settings->vkontakte_wishlist_label_right) == FALSE) $settings->vkontakte_wishlist_label_right = 'Подарок';
      if (isset($settings->vkontakte_wishlist_merchantid) == FALSE) $settings->vkontakte_wishlist_merchantid = '';
      if (isset($settings->vkontakte_wishlist_secret) == FALSE) $settings->vkontakte_wishlist_secret = '';
      if (isset($settings->vkontakte_payment_enabled) == FALSE) $settings->vkontakte_payment_enabled = 0;
      if (isset($settings->vkontakte_payment_testmode) == FALSE) $settings->vkontakte_payment_testmode = 1;
      if (isset($settings->vkontakte_payment_cost_increase) == FALSE) $settings->vkontakte_payment_cost_increase = 0;
      if (isset($settings->vkontakte_payment_result_url) == FALSE) $settings->vkontakte_payment_result_url = '';
      if (isset($settings->vkontakte_payment_fail_url) == FALSE) $settings->vkontakte_payment_fail_url = '';
      if (isset($settings->vkontakte_payment_label) == FALSE) $settings->vkontakte_payment_label = 'Оплатить';
      if (isset($settings->vkontakte_payment_label_right) == FALSE) $settings->vkontakte_payment_label_right = 'Контакте';
      if (isset($settings->vkontakte_payment_merchantid) == FALSE) $settings->vkontakte_payment_merchantid = '';
      if (isset($settings->vkontakte_payment_secret) == FALSE) $settings->vkontakte_payment_secret = '';
      if (!isset($settings->product_category_show)) $settings->product_category_show = 1;
      if (!isset($settings->product_brand_show)) $settings->product_brand_show = 1;

      // проверяем настройки по меню каталога
      if (!isset($settings->catalog_menu_mode)) $settings->catalog_menu_mode = CATALOG_MENU_MODE_VERTICAL_MENU;
      if (!isset($settings->catalog_menu_noempty)) $settings->catalog_menu_noempty = TRUE;
      if (!isset($settings->catalog_menu_nocount)) $settings->catalog_menu_nocount = FALSE;
      if (!isset($settings->catalog_menu_adminedit)) $settings->catalog_menu_adminedit = FALSE;
      if (!isset($settings->catalog_brands_menu_noempty)) $settings->catalog_brands_menu_noempty = TRUE;
      if (!isset($settings->catalog_brands_adminedit)) $settings->catalog_barnds_menu_adminedit = FALSE;



      // проверяем настройки по купонам
      if (!isset($settings->coupons_max_print)) $settings->coupons_max_print = 20;
      if (!isset($settings->coupons_num_admin)) $settings->coupons_num_admin = 50;
      if (!isset($settings->coupons_registration_disabled)) $settings->coupons_registration_disabled = FALSE;
      if (!isset($settings->coupons_cart_disabled)) $settings->coupons_cart_disabled = FALSE;
      if (!isset($settings->coupons_code_pattern)) $settings->coupons_code_pattern = '**** **** **** ****';
      if (!isset($settings->coupons_reg_notify_admin_by_email)) $settings->coupons_reg_notify_admin_by_email = FALSE;
      if (!isset($settings->coupons_reg_notify_admin_by_sms)) $settings->coupons_reg_notify_admin_by_sms = FALSE;
      if (!isset($settings->coupons_reg_notify_affiliate_by_email)) $settings->coupons_reg_notify_affiliate_by_email = TRUE;
      if (!isset($settings->coupons_reg_notify_affiliate_by_sms)) $settings->coupons_reg_notify_affiliate_by_sms = FALSE;
      if (!isset($settings->coupons_reg_notify_subject)) $settings->coupons_reg_notify_subject = 'Активность по купону *: регистрация пользователя на сайте &';
      if (!isset($settings->coupons_order_notify_admin_by_email)) $settings->coupons_order_notify_admin_by_email = FALSE;
      if (!isset($settings->coupons_order_notify_admin_by_sms)) $settings->coupons_order_notify_admin_by_sms = FALSE;
      if (!isset($settings->coupons_order_notify_affiliate_by_email)) $settings->coupons_order_notify_affiliate_by_email = TRUE;
      if (!isset($settings->coupons_order_notify_affiliate_by_sms)) $settings->coupons_order_notify_affiliate_by_sms = FALSE;
      if (!isset($settings->coupons_order_notify_subject)) $settings->coupons_order_notify_subject = 'Активность по купону *: оформлен заказ # на сумму $ на сайте &';



        // проверяем настройки для заказов
        $field = 'orders_edit_mode';          if (!isset($settings->$field)) $settings->$field = EDIT_ORDER_MODE_NEW_PROCESS;
        $field = 'orders_minimal_sum';        if (!isset($settings->$field)) $settings->$field = 0;
        $field = 'orders_attach_receipt';     if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'orders_non_touch_quantity'; if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'orders_deficit_enabled';    if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'orders_auto_export';        if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'orders_auto_export_format'; if (!isset($settings->$field)) $settings->$field = 'xml';
        $field = 'orders_auto_export_file';   if (!isset($settings->$field)) $settings->$field = 'last_orders.xml';



      // проверяем настройки для мгновенного заказа (покупка единственного товара без укладывания в корзину)
      if (!isset($settings->fulminantorder_label_name)) $settings->fulminantorder_label_name = 'фамилия:';
      if (!isset($settings->fulminantorder_show_name)) $settings->fulminantorder_show_name = TRUE;
      if (!isset($settings->fulminantorder_label_name2)) $settings->fulminantorder_label_name2 = 'отчество:';
      if (!isset($settings->fulminantorder_show_name2)) $settings->fulminantorder_show_name2 = FALSE;
      if (!isset($settings->fulminantorder_label_name3)) $settings->fulminantorder_label_name3 = 'имя:';
      if (!isset($settings->fulminantorder_show_name3)) $settings->fulminantorder_show_name3 = FALSE;
      if (!isset($settings->fulminantorder_label_email)) $settings->fulminantorder_label_email = 'емейл:';
      if (!isset($settings->fulminantorder_show_email)) $settings->fulminantorder_show_email = TRUE;
      if (!isset($settings->fulminantorder_label_email2)) $settings->fulminantorder_label_email2 = 'емейл 2:';
      if (!isset($settings->fulminantorder_show_email2)) $settings->fulminantorder_show_email2 = FALSE;
      if (!isset($settings->fulminantorder_label_phone)) $settings->fulminantorder_label_phone = 'телефон:';
      if (!isset($settings->fulminantorder_show_phone)) $settings->fulminantorder_show_phone = TRUE;
      if (!isset($settings->fulminantorder_label_phone2)) $settings->fulminantorder_label_phone2 = 'телефон 2:';
      if (!isset($settings->fulminantorder_show_phone2)) $settings->fulminantorder_show_phone2 = FALSE;
      if (!isset($settings->fulminantorder_label_icq)) $settings->fulminantorder_label_icq = 'icq:';
      if (!isset($settings->fulminantorder_show_icq)) $settings->fulminantorder_show_icq = FALSE;
      if (!isset($settings->fulminantorder_label_icq2)) $settings->fulminantorder_label_icq2 = 'icq 2:';
      if (!isset($settings->fulminantorder_show_icq2)) $settings->fulminantorder_show_icq2 = FALSE;
      if (!isset($settings->fulminantorder_label_skype)) $settings->fulminantorder_label_skype = 'skype:';
      if (!isset($settings->fulminantorder_show_skype)) $settings->fulminantorder_show_skype = FALSE;
      if (!isset($settings->fulminantorder_label_skype2)) $settings->fulminantorder_label_skype2 = 'skype 2:';
      if (!isset($settings->fulminantorder_show_skype2)) $settings->fulminantorder_show_skype2 = FALSE;
      if (!isset($settings->fulminantorder_label_address)) $settings->fulminantorder_label_address = 'страна:';
      if (!isset($settings->fulminantorder_show_address)) $settings->fulminantorder_show_address = FALSE;
      if (!isset($settings->fulminantorder_label_address_2)) $settings->fulminantorder_label_address_2 = 'область:';
      if (!isset($settings->fulminantorder_show_address_2)) $settings->fulminantorder_show_address_2 = FALSE;
      if (!isset($settings->fulminantorder_label_address_3)) $settings->fulminantorder_label_address_3 = 'город:';
      if (!isset($settings->fulminantorder_show_address_3)) $settings->fulminantorder_show_address_3 = FALSE;
      if (!isset($settings->fulminantorder_label_address_4)) $settings->fulminantorder_label_address_4 = 'улица:';
      if (!isset($settings->fulminantorder_show_address_4)) $settings->fulminantorder_show_address_4 = FALSE;
      if (!isset($settings->fulminantorder_label_address_5)) $settings->fulminantorder_label_address_5 = 'дом:';
      if (!isset($settings->fulminantorder_show_address_5)) $settings->fulminantorder_show_address_5 = FALSE;
      if (!isset($settings->fulminantorder_label_address_6)) $settings->fulminantorder_label_address_6 = 'корпус:';
      if (!isset($settings->fulminantorder_show_address_6)) $settings->fulminantorder_show_address_6 = FALSE;
      if (!isset($settings->fulminantorder_label_address_7)) $settings->fulminantorder_label_address_7 = 'подъезд:';
      if (!isset($settings->fulminantorder_show_address_7)) $settings->fulminantorder_show_address_7 = FALSE;
      if (!isset($settings->fulminantorder_label_address_8)) $settings->fulminantorder_label_address_8 = 'код:';
      if (!isset($settings->fulminantorder_show_address_8)) $settings->fulminantorder_show_address_8 = FALSE;
      if (!isset($settings->fulminantorder_label_address_9)) $settings->fulminantorder_label_address_9 = 'квартира:';
      if (!isset($settings->fulminantorder_show_address_9)) $settings->fulminantorder_show_address_9 = FALSE;
      if (!isset($settings->fulminantorder_label_address_10)) $settings->fulminantorder_label_address_10 = 'индекс:';
      if (!isset($settings->fulminantorder_show_address_10)) $settings->fulminantorder_show_address_10 = FALSE;
      if (!isset($settings->fulminantorder_label_address2)) $settings->fulminantorder_label_address2 = 'страна:';
      if (!isset($settings->fulminantorder_show_address2)) $settings->fulminantorder_show_address2 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_2)) $settings->fulminantorder_label_address2_2 = 'область:';
      if (!isset($settings->fulminantorder_show_address2_2)) $settings->fulminantorder_show_address2_2 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_3)) $settings->fulminantorder_label_address2_3 = 'город:';
      if (!isset($settings->fulminantorder_show_address2_3)) $settings->fulminantorder_show_address2_3 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_4)) $settings->fulminantorder_label_address2_4 = 'улица:';
      if (!isset($settings->fulminantorder_show_address2_4)) $settings->fulminantorder_show_address2_4 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_5)) $settings->fulminantorder_label_address2_5 = 'дом:';
      if (!isset($settings->fulminantorder_show_address2_5)) $settings->fulminantorder_show_address2_5 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_6)) $settings->fulminantorder_label_address2_6 = 'корпус:';
      if (!isset($settings->fulminantorder_show_address2_6)) $settings->fulminantorder_show_address2_6 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_7)) $settings->fulminantorder_label_address2_7 = 'подъезд:';
      if (!isset($settings->fulminantorder_show_address2_7)) $settings->fulminantorder_show_address2_7 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_8)) $settings->fulminantorder_label_address2_8 = 'код:';
      if (!isset($settings->fulminantorder_show_address2_8)) $settings->fulminantorder_show_address2_8 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_9)) $settings->fulminantorder_label_address2_9 = 'квартира:';
      if (!isset($settings->fulminantorder_show_address2_9)) $settings->fulminantorder_show_address2_9 = FALSE;
      if (!isset($settings->fulminantorder_label_address2_10)) $settings->fulminantorder_label_address2_10 = 'индекс:';
      if (!isset($settings->fulminantorder_show_address2_10)) $settings->fulminantorder_show_address2_10 = FALSE;
      if (!isset($settings->fulminantorder_label_comment)) $settings->fulminantorder_label_comment = 'комментарий:';
      if (!isset($settings->fulminantorder_show_comment)) $settings->fulminantorder_show_comment = TRUE;
      if (!isset($settings->fulminantorder_captcha_disabled)) $settings->fulminantorder_captcha_disabled = FALSE;

      // проверяем настройки для категорий
      if (!isset($settings->categories_files_folder_prefix)) $settings->categories_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->categories_files_folder_prefix = $this->hdd->safeFilename($settings->categories_files_folder_prefix);
      if (!isset($settings->categories_images_quality)) $settings->categories_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->categories_images_width)) $settings->categories_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->categories_images_height)) $settings->categories_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->categories_thumbnail_width)) $settings->categories_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->categories_thumbnail_height)) $settings->categories_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->categories_watermark_transparency)) $settings->categories_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->categories_images_exactly)) $settings->categories_images_exactly = TRUE;
      if (!isset($settings->categories_watermark_enabled)) $settings->categories_watermark_enabled = FALSE;
      if (!isset($settings->categories_watermark_location)) $settings->categories_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->categories_wysiwyg_disabled)) $settings->categories_wysiwyg_disabled = FALSE;
      if (!isset($settings->categories_wysiwyg_disabled_mode)) $settings->categories_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->categories_meta_autofill)) $settings->categories_meta_autofill = TRUE;
      if (!isset($settings->categories_sort_method)) $settings->categories_sort_method = SORT_CATEGORIES_MODE_AS_IS;

      // проверяем настройки для брендов
      if (!isset($settings->brands_files_folder_prefix)) $settings->brands_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->brands_files_folder_prefix = $this->hdd->safeFilename($settings->brands_files_folder_prefix);
      if (!isset($settings->brands_images_quality)) $settings->brands_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->brands_images_width)) $settings->brands_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->brands_images_height)) $settings->brands_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->brands_thumbnail_width)) $settings->brands_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->brands_thumbnail_height)) $settings->brands_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->brands_watermark_transparency)) $settings->brands_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->brands_images_exactly)) $settings->brands_images_exactly = TRUE;
      if (!isset($settings->brands_watermark_enabled)) $settings->brands_watermark_enabled = FALSE;
      if (!isset($settings->brands_watermark_location)) $settings->brands_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->brands_wysiwyg_disabled)) $settings->brands_wysiwyg_disabled = FALSE;
      if (!isset($settings->brands_wysiwyg_disabled_mode)) $settings->brands_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->brands_meta_autofill)) $settings->brands_meta_autofill = TRUE;
      if (!isset($settings->brands_sort_method)) $settings->brands_sort_method = SORT_BRANDS_MODE_AS_IS;
      if (!isset($settings->brands_main_title)) $settings->brands_main_title = 'Бренды';
      if (!isset($settings->brands_main_path)) $settings->brands_main_path = 'Бренды';

      // проверяем настройки для складов
      if (!isset($settings->stocks_files_folder_prefix)) $settings->stocks_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->stocks_files_folder_prefix = $this->hdd->safeFilename($settings->stocks_files_folder_prefix);
      if (!isset($settings->stocks_images_quality)) $settings->stocks_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->stocks_images_width)) $settings->stocks_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->stocks_images_height)) $settings->stocks_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->stocks_thumbnail_width)) $settings->stocks_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->stocks_thumbnail_height)) $settings->stocks_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->stocks_watermark_transparency)) $settings->stocks_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->stocks_images_exactly)) $settings->stocks_images_exactly = TRUE;
      if (!isset($settings->stocks_watermark_enabled)) $settings->stocks_watermark_enabled = FALSE;
      if (!isset($settings->stocks_watermark_location)) $settings->stocks_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->stocks_wysiwyg_disabled)) $settings->stocks_wysiwyg_disabled = FALSE;
      if (!isset($settings->stocks_wysiwyg_disabled_mode)) $settings->stocks_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->stocks_meta_autofill)) $settings->stocks_meta_autofill = TRUE;
      if (!isset($settings->stocks_sort_method)) $settings->stocks_sort_method = SORT_STOCKS_MODE_BY_NAME;
      if (!isset($settings->stocks_main_title)) $settings->stocks_main_title = 'Склады';
      if (!isset($settings->stocks_main_path)) $settings->stocks_main_path = 'Склады';
      if (!isset($settings->stocks_main_keywords)) $settings->stocks_main_keywords = 'склад, список';
      if (!isset($settings->stocks_main_description)) $settings->stocks_main_description = 'Список складов интернет-магазина.';

      // проверяем настройки для товаров
      if (!isset($settings->products_files_folder_prefix)) $settings->products_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->products_files_folder_prefix = $this->hdd->safeFilename($settings->products_files_folder_prefix);
      if (!isset($settings->products_images_quality)) $settings->products_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->products_images_width)) $settings->products_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->products_images_height)) $settings->products_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->products_thumbnail_width)) $settings->products_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->products_thumbnail_height)) $settings->products_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->products_watermark_transparency)) $settings->products_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->products_images_exactly)) $settings->products_images_exactly = TRUE;
      if (!isset($settings->products_watermark_enabled)) $settings->products_watermark_enabled = FALSE;
      if (!isset($settings->products_watermark_location)) $settings->products_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->products_wysiwyg_disabled)) $settings->products_wysiwyg_disabled = FALSE;
      if (!isset($settings->products_wysiwyg_disabled_mode)) $settings->products_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->products_meta_autofill)) $settings->products_meta_autofill = TRUE;
      if (!isset($settings->products_sort_method)) $settings->products_sort_method = SORT_PRODUCTS_MODE_AS_IS;
      if (!isset($settings->products_sort_direction)) $settings->products_sort_direction = SORT_DIRECTION_ASCENDING;
      if (!isset($settings->products_sort_laconical)) $settings->products_sort_laconical = 0;
      if (!isset($settings->products_hit_title)) $settings->products_hit_title = 'Хиты продаж';
      if (!isset($settings->products_hit_path)) $settings->products_hit_path = 'Популярные';
      if (!isset($settings->products_hit_keywords)) $settings->products_hit_keywords = 'хит продаж, популярный товар';
      if (!isset($settings->products_hit_description)) $settings->products_hit_description = 'Список хитов продаж интернет-магазина.';
      if (!isset($settings->products_hit_maxcount)) $settings->products_hit_maxcount = DEFAULT_VALUE_FOR_PRODUCTS_HIT_COUNT;
      if (!isset($settings->products_main_hit_enabled)) $settings->products_main_hit_enabled = TRUE;
      if (!isset($settings->products_hit_enabled)) $settings->products_hit_enabled = TRUE;
      if (!isset($settings->products_hit_random)) $settings->products_hit_random = TRUE;
      if (!isset($settings->products_newest_title)) $settings->products_newest_title = 'Новые поступления';
      if (!isset($settings->products_newest_path)) $settings->products_newest_path = 'Новые';
      if (!isset($settings->products_newest_keywords)) $settings->products_newest_keywords = 'новый товар, новинки, новые поступления';
      if (!isset($settings->products_newest_description)) $settings->products_newest_description = 'Список новинок интернет-магазина.';
      if (!isset($settings->products_newest_maxcount)) $settings->products_newest_maxcount = DEFAULT_VALUE_FOR_PRODUCTS_NEWEST_COUNT;
      if (!isset($settings->products_newest_days)) $settings->products_newest_days = 0;
      if (!isset($settings->products_main_newest_enabled)) $settings->products_main_newest_enabled = TRUE;
      if (!isset($settings->products_newest_enabled)) $settings->products_newest_enabled = TRUE;
      if (!isset($settings->products_newest_random)) $settings->products_newest_random = TRUE;
      if (!isset($settings->products_actional_title)) $settings->products_actional_title = 'Специальное предложение';
      if (!isset($settings->products_actional_path)) $settings->products_actional_path = 'Акционные';
      if (!isset($settings->products_actional_keywords)) $settings->products_actional_keywords = 'акция';
      if (!isset($settings->products_actional_description)) $settings->products_actional_description = 'Список акционных товаров интернет-магазина.';
      if (!isset($settings->products_actional_maxcount)) $settings->products_actional_maxcount = DEFAULT_VALUE_FOR_PRODUCTS_ACTIONAL_COUNT;
      if (!isset($settings->products_main_actional_enabled)) $settings->products_main_actional_enabled = TRUE;
      if (!isset($settings->products_actional_enabled)) $settings->products_actional_enabled = TRUE;
      if (!isset($settings->products_actional_random)) $settings->products_actional_random = TRUE;
      if (!isset($settings->products_awaited_title)) $settings->products_awaited_title = 'Скоро в продаже';
      if (!isset($settings->products_awaited_path)) $settings->products_awaited_path = 'Ожидаемые';
      if (!isset($settings->products_awaited_keywords)) $settings->products_awaited_keywords = 'скоро в продаже';
      if (!isset($settings->products_awaited_description)) $settings->products_awaited_description = 'Список ожидаемых товаров в интернет-магазине.';
      if (!isset($settings->products_awaited_maxcount)) $settings->products_awaited_maxcount = DEFAULT_VALUE_FOR_PRODUCTS_AWAITED_COUNT;
      if (!isset($settings->products_main_awaited_enabled)) $settings->products_main_awaited_enabled = TRUE;
      if (!isset($settings->products_awaited_enabled)) $settings->products_awaited_enabled = TRUE;
      if (!isset($settings->products_awaited_random)) $settings->products_awaited_random = TRUE;
      if (!isset($settings->products_ordered_title)) $settings->products_ordered_title = 'Недавно покупали';
      if (!isset($settings->products_ordered_path)) $settings->products_ordered_path = 'Покупаемые';
      if (!isset($settings->products_ordered_keywords)) $settings->products_ordered_keywords = 'купили, товар';
      if (!isset($settings->products_ordered_description)) $settings->products_ordered_description = 'Список недавно приобретенных товаров интернет-магазина.';
      if (!isset($settings->products_ordered_maxcount)) $settings->products_ordered_maxcount = DEFAULT_VALUE_FOR_PRODUCTS_ORDERED_COUNT;
      if (!isset($settings->products_main_ordered_enabled)) $settings->products_main_ordered_enabled = TRUE;
      if (!isset($settings->products_ordered_enabled)) $settings->products_ordered_enabled = TRUE;
      if (!isset($settings->products_ordered_random)) $settings->products_ordered_random = TRUE;
      if (!isset($settings->products_commented_title)) $settings->products_commented_title = 'Недавно обсуждали';
      if (!isset($settings->products_commented_path)) $settings->products_commented_path = 'Обсуждаемые';
      if (!isset($settings->products_commented_keywords)) $settings->products_commented_keywords = 'отзыв о товаре, обсуждаемые товары';
      if (!isset($settings->products_commented_description)) $settings->products_commented_description = 'Список товаров интернет-магазина с отзывами покупателей.';
      if (!isset($settings->products_commented_maxcount)) $settings->products_commented_maxcount = DEFAULT_VALUE_FOR_PRODUCTS_COMMENTED_COUNT;
      if (!isset($settings->products_main_commented_enabled)) $settings->products_main_commented_enabled = TRUE;
      if (!isset($settings->products_commented_enabled)) $settings->products_commented_enabled = TRUE;
      if (!isset($settings->products_commented_random)) $settings->products_commented_random = TRUE;
      if (!isset($settings->products_num)) $settings->products_num = SETTINGS_DEFAULT_PRODUCTS_NUM;
      if (!isset($settings->products_num_admin)) $settings->products_num_admin = SETTINGS_DEFAULT_PRODUCTS_NUM_ADMIN;
      if (!isset($settings->products_comments_title)) $settings->products_comments_title = 'Отзывы о *';
      if (!isset($settings->products_comment_next_time)) $settings->products_comment_next_time = SETTINGS_DEFAULT_COMMENTS_NEXTTIME;
      if (!isset($settings->products_comment_moderation)) $settings->products_comment_moderation = TRUE;

        // настройки для свойств товаров
        if (!isset($settings->properties_sort_method)) $settings->properties_sort_method = SORT_PROPERTIES_MODE_BY_NAME;

      // проверяем настройки для комплектов товаров
      if (!isset($settings->productskits_wysiwyg_disabled)) $settings->productskits_wysiwyg_disabled = FALSE;
      if (!isset($settings->productskits_wysiwyg_disabled_mode)) $settings->productskits_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->productskits_meta_autofill)) $settings->productskits_meta_autofill = TRUE;
      if (!isset($settings->productskits_sort_method)) $settings->productskits_sort_method = SORT_PRODUCTSKITS_MODE_AS_IS;
      if (!isset($settings->productskits_title)) $settings->productskits_title = 'Комплекты товаров';
      if (!isset($settings->productskits_path)) $settings->productskits_path = 'Комплекты';
      if (!isset($settings->productskits_keywords)) $settings->productskits_keywords = 'комплект товаров, набор товаров';
      if (!isset($settings->productskits_description)) $settings->productskits_description = 'Список комплектов товаров интернет-магазина.';
      if (!isset($settings->productskits_num)) $settings->productskits_num = SETTINGS_DEFAULT_PRODUCTS_NUM;
      if (!isset($settings->productskits_num_admin)) $settings->productskits_num_admin = SETTINGS_DEFAULT_PRODUCTS_NUM_ADMIN;

      // проверяем настройки для кредитных программ
      if (!isset($settings->creditprograms_wysiwyg_disabled)) $settings->creditprograms_wysiwyg_disabled = FALSE;
      if (!isset($settings->creditprograms_wysiwyg_disabled_mode)) $settings->creditprograms_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;

      // проверяем настройки для статей
      if (!isset($settings->articles_files_folder_prefix)) $settings->articles_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->articles_files_folder_prefix = $this->hdd->safeFilename($settings->articles_files_folder_prefix);
      if (!isset($settings->articles_images_quality)) $settings->articles_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->articles_images_width)) $settings->articles_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->articles_images_height)) $settings->articles_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->articles_thumbnail_width)) $settings->articles_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->articles_thumbnail_height)) $settings->articles_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->articles_watermark_transparency)) $settings->articles_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->articles_images_exactly)) $settings->articles_images_exactly = TRUE;
      if (!isset($settings->articles_watermark_enabled)) $settings->articles_watermark_enabled = FALSE;
      if (!isset($settings->articles_watermark_location)) $settings->articles_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->articles_wysiwyg_disabled)) $settings->articles_wysiwyg_disabled = FALSE;
      if (!isset($settings->articles_wysiwyg_disabled_mode)) $settings->articles_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->articles_meta_autofill)) $settings->articles_meta_autofill = TRUE;
      if (!isset($settings->articles_sort_method)) $settings->articles_sort_method = SORT_ARTICLES_MODE_BY_CREATED;
      if (!isset($settings->articles_main_title)) $settings->articles_main_title = 'Статьи';
      if (!isset($settings->articles_main_maxcount)) $settings->articles_main_maxcount = DEFAULT_VALUE_FOR_ARTICLES_COUNT;
      if (!isset($settings->articles_main_path)) $settings->articles_main_path = 'Статьи';
      if (!isset($settings->articles_products_title)) $settings->articles_products_title = 'Статьи о *';
      if (!isset($settings->articles_categories_title)) $settings->articles_categories_title = 'Статьи о *';
      if (!isset($settings->articles_comment_next_time)) $settings->articles_comment_next_time = SETTINGS_DEFAULT_COMMENTS_NEXTTIME;
      if (!isset($settings->articles_comment_moderation)) $settings->articles_comment_moderation = TRUE;

      // проверяем настройки для новостей
      if (!isset($settings->news_files_folder_prefix)) $settings->news_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->news_files_folder_prefix = $this->hdd->safeFilename($settings->news_files_folder_prefix);
      if (!isset($settings->news_images_quality)) $settings->news_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->news_images_width)) $settings->news_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->news_images_height)) $settings->news_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->news_thumbnail_width)) $settings->news_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->news_thumbnail_height)) $settings->news_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->news_watermark_transparency)) $settings->news_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->news_images_exactly)) $settings->news_images_exactly = TRUE;
      if (!isset($settings->news_watermark_enabled)) $settings->news_watermark_enabled = FALSE;
      if (!isset($settings->news_watermark_location)) $settings->news_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->news_wysiwyg_disabled)) $settings->news_wysiwyg_disabled = FALSE;
      if (!isset($settings->news_wysiwyg_disabled_mode)) $settings->news_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->news_meta_autofill)) $settings->news_meta_autofill = TRUE;
      if (!isset($settings->news_sort_method)) $settings->news_sort_method = SORT_NEWS_MODE_BY_CREATED;
      if (!isset($settings->news_main_title)) $settings->news_main_title = 'Новости';
      if (!isset($settings->news_main_maxcount)) $settings->news_main_maxcount = DEFAULT_VALUE_FOR_NEWS_COUNT;
      if (!isset($settings->news_main_path)) $settings->news_main_path = 'Новости';
      if (!isset($settings->news_products_title)) $settings->news_products_title = 'Новости о *';
      if (!isset($settings->news_categories_title)) $settings->news_categories_title = 'Новости о *';
      if (!isset($settings->news_comment_next_time)) $settings->news_comment_next_time = SETTINGS_DEFAULT_COMMENTS_NEXTTIME;
      if (!isset($settings->news_comment_moderation)) $settings->news_comment_moderation = TRUE;

      // проверяем настройки для специальных страниц
      if (!isset($settings->sections_files_folder_prefix)) $settings->sections_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->sections_files_folder_prefix = $this->hdd->safeFilename($settings->sections_files_folder_prefix);
      if (!isset($settings->sections_images_quality)) $settings->sections_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->sections_images_width)) $settings->sections_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->sections_images_height)) $settings->sections_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->sections_thumbnail_width)) $settings->sections_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->sections_thumbnail_height)) $settings->sections_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->sections_watermark_transparency)) $settings->sections_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->sections_images_exactly)) $settings->sections_images_exactly = TRUE;
      if (!isset($settings->sections_watermark_enabled)) $settings->sections_watermark_enabled = FALSE;
      if (!isset($settings->sections_watermark_location)) $settings->sections_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->sections_wysiwyg_disabled)) $settings->sections_wysiwyg_disabled = FALSE;
      if (!isset($settings->sections_wysiwyg_disabled_mode)) $settings->sections_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->sections_meta_autofill)) $settings->sections_meta_autofill = TRUE;
      if (!isset($settings->sections_sort_method)) $settings->sections_sort_method = SORT_SECTIONS_MODE_AS_IS;

      // проверяем настройки для медиафайлов
      if (!isset($settings->files_files_folder_prefix)) $settings->files_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->files_files_folder_prefix = $this->hdd->safeFilename($settings->files_files_folder_prefix);
      if (!isset($settings->files_wysiwyg_disabled)) $settings->files_wysiwyg_disabled = FALSE;
      if (!isset($settings->files_wysiwyg_disabled_mode)) $settings->files_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->files_meta_autofill)) $settings->files_meta_autofill = TRUE;
      if (!isset($settings->files_sort_method)) $settings->files_sort_method = SORT_FILES_MODE_AS_IS;
      if (!isset($settings->files_main_title)) $settings->files_main_title = 'Медиа файлы';
      if (!isset($settings->files_main_path)) $settings->files_main_path = 'Файлы';
      if (!isset($settings->files_main_keywords)) $settings->files_main_keywords = 'файл, список, скачать';
      if (!isset($settings->files_main_description)) $settings->files_main_description = 'Список медиа файлов интернет-магазина.';

      // проверяем настройки для способов доставки
      if (!isset($settings->deliveries_wysiwyg_disabled)) $settings->deliveries_wysiwyg_disabled = FALSE;
      if (!isset($settings->deliveries_wysiwyg_disabled_mode)) $settings->deliveries_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->deliveries_sort_method)) $settings->deliveries_sort_method = SORT_DELIVERIES_MODE_AS_IS;
if (isset($settings->delivery_conflict_method) == FALSE) $settings->delivery_conflict_method = DELIVERY_CONFLICT_MODE_IGNORE;
      if (!isset($settings->deliveries_num_admin)) $settings->deliveries_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;

      // проверяем настройки для способов оплаты
      if (!isset($settings->payments_wysiwyg_disabled)) $settings->payments_wysiwyg_disabled = FALSE;
      if (!isset($settings->payments_wysiwyg_disabled_mode)) $settings->payments_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->payments_sort_method)) $settings->payments_sort_method = SORT_PAYMENTS_MODE_AS_IS;
      if (!isset($settings->payments_num_admin)) $settings->payments_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;

      // проверяем настройки для поискового сопровождения
      if (!isset($settings->searches_enabled)) $settings->searches_enabled = TRUE;
      if (!isset($settings->searches_num_admin)) $settings->searches_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
      if (!isset($settings->searches_next_time)) $settings->searches_next_time = SETTINGS_DEFAULT_SEARCHES_NEXTTIME;
      if (!isset($settings->searches_referers)) $settings->searches_referers = '[site], keyword' . $CRLF
                                                                             . 'ask.com/web, q' . $CRLF
                                                                             . 'google.ru, q' . $CRLF
                                                                             . 'google.ru, as_q' . $CRLF
                                                                             . 'google.ua, q' . $CRLF
                                                                             . 'google.ua, as_q' . $CRLF
                                                                             . 'google.com.ua, q' . $CRLF
                                                                             . 'google.com.ua, as_q' . $CRLF
                                                                             . 'google.com, q' . $CRLF
                                                                             . 'google.com, as_q' . $CRLF
                                                                             . 'search.live.com, q' . $CRLF
                                                                             . 'go.mail.ru, q' . $CRLF
                                                                             . 'search.msn.com/results, q' . $CRLF
                                                                             . 'nigma.ru/index.php, s' . $CRLF
                                                                             . 'nigma.ru/index.php, q' . $CRLF
                                                                             . 'search.qip.ru/search, query' . $CRLF
                                                                             . 'rambler.ru, query' . $CRLF
                                                                             . 'rambler.ru, words' . $CRLF
                                                                             . 'rapidall.com/search.php, query' . $CRLF
                                                                             . 'search.yahoo.com, p' . $CRLF
                                                                             . 'yandex.ru, text' . $CRLF
                                                                             . 'yandex.ua, text' . $CRLF
                                                                             . 'images.yandex.ru, text' . $CRLF
                                                                             . 'm.yandex.ru/search, query' . $CRLF
                                                                             . 'hghltd.yandex.net, text';

      // проверяем настройки для стран
      if (!isset($settings->countries_files_folder_prefix)) $settings->countries_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->countries_files_folder_prefix = $this->hdd->safeFilename($settings->countries_files_folder_prefix);
      if (!isset($settings->countries_images_quality)) $settings->countries_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->countries_images_width)) $settings->countries_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->countries_images_height)) $settings->countries_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->countries_thumbnail_width)) $settings->countries_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->countries_thumbnail_height)) $settings->countries_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->countries_watermark_transparency)) $settings->countries_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->countries_images_exactly)) $settings->countries_images_exactly = TRUE;
      if (!isset($settings->countries_watermark_enabled)) $settings->countries_watermark_enabled = FALSE;
      if (!isset($settings->countries_watermark_location)) $settings->countries_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->countries_wysiwyg_disabled)) $settings->countries_wysiwyg_disabled = FALSE;
      if (!isset($settings->countries_wysiwyg_disabled_mode)) $settings->countries_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->countries_meta_autofill)) $settings->countries_meta_autofill = TRUE;
      if (!isset($settings->countries_sort_method)) $settings->countries_sort_method = SORT_COUNTRIES_MODE_AS_IS;
      if (!isset($settings->countries_main_title)) $settings->countries_main_title = 'Страны';
      if (!isset($settings->countries_main_path)) $settings->countries_main_path = 'Страны';
      if (!isset($settings->countries_main_keywords)) $settings->countries_main_keywords = 'страна, список';
      if (!isset($settings->countries_main_description)) $settings->countries_main_description = 'Список стран интернет-магазина.';
      if (!isset($settings->countries_num)) $settings->countries_num = SETTINGS_DEFAULT_ITEMS_NUM;
      if (!isset($settings->countries_num_admin)) $settings->countries_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;

      // проверяем настройки для областей
      if (!isset($settings->regions_files_folder_prefix)) $settings->regions_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->regions_files_folder_prefix = $this->hdd->safeFilename($settings->regions_files_folder_prefix);
      if (!isset($settings->regions_images_quality)) $settings->regions_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->regions_images_width)) $settings->regions_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->regions_images_height)) $settings->regions_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->regions_thumbnail_width)) $settings->regions_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->regions_thumbnail_height)) $settings->regions_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->regions_watermark_transparency)) $settings->regions_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->regions_images_exactly)) $settings->regions_images_exactly = TRUE;
      if (!isset($settings->regions_watermark_enabled)) $settings->regions_watermark_enabled = FALSE;
      if (!isset($settings->regions_watermark_location)) $settings->regions_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->regions_wysiwyg_disabled)) $settings->regions_wysiwyg_disabled = FALSE;
      if (!isset($settings->regions_wysiwyg_disabled_mode)) $settings->regions_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->regions_meta_autofill)) $settings->regions_meta_autofill = TRUE;
      if (!isset($settings->regions_sort_method)) $settings->regions_sort_method = SORT_REGIONS_MODE_BY_NAME;
      if (!isset($settings->regions_main_title)) $settings->regions_main_title = 'Области';
      if (!isset($settings->regions_main_path)) $settings->regions_main_path = 'Области';
      if (!isset($settings->regions_main_keywords)) $settings->regions_main_keywords = 'область, список';
      if (!isset($settings->regions_main_description)) $settings->regions_main_description = 'Список областей интернет-магазина.';
      if (!isset($settings->regions_num)) $settings->regions_num = SETTINGS_DEFAULT_ITEMS_NUM;
      if (!isset($settings->regions_num_admin)) $settings->regions_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;

      // проверяем настройки для городов
      if (!isset($settings->towns_files_folder_prefix)) $settings->towns_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->towns_files_folder_prefix = $this->hdd->safeFilename($settings->towns_files_folder_prefix);
      if (!isset($settings->towns_images_quality)) $settings->towns_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->towns_images_width)) $settings->towns_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->towns_images_height)) $settings->towns_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->towns_thumbnail_width)) $settings->towns_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->towns_thumbnail_height)) $settings->towns_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->towns_watermark_transparency)) $settings->towns_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->towns_images_exactly)) $settings->towns_images_exactly = TRUE;
      if (!isset($settings->towns_watermark_enabled)) $settings->towns_watermark_enabled = FALSE;
      if (!isset($settings->towns_watermark_location)) $settings->towns_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->towns_wysiwyg_disabled)) $settings->towns_wysiwyg_disabled = FALSE;
      if (!isset($settings->towns_wysiwyg_disabled_mode)) $settings->towns_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->towns_meta_autofill)) $settings->towns_meta_autofill = TRUE;
      if (!isset($settings->towns_sort_method)) $settings->towns_sort_method = SORT_TOWNS_MODE_BY_NAME;
      if (!isset($settings->towns_main_title)) $settings->towns_main_title = 'Города';
      if (!isset($settings->towns_main_path)) $settings->towns_main_path = 'Города';
      if (!isset($settings->towns_main_keywords)) $settings->towns_main_keywords = 'город, список';
      if (!isset($settings->towns_main_description)) $settings->towns_main_description = 'Список городов интернет-магазина.';
      if (!isset($settings->towns_num)) $settings->towns_num = SETTINGS_DEFAULT_ITEMS_NUM;
      if (!isset($settings->towns_num_admin)) $settings->towns_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;

      // проверяем настройки для учебных заведений
      if (!isset($settings->schools_files_folder_prefix)) $settings->schools_files_folder_prefix = SETTINGS_DEFAULT_FILES_FOLDER_PREFIX;
        $settings->schools_files_folder_prefix = $this->hdd->safeFilename($settings->schools_files_folder_prefix);
      if (!isset($settings->schools_images_quality)) $settings->schools_images_quality = SETTINGS_DEFAULT_IMAGES_QUALITY;
      if (!isset($settings->schools_images_width)) $settings->schools_images_width = SETTINGS_DEFAULT_IMAGES_WIDTH;
      if (!isset($settings->schools_images_height)) $settings->schools_images_height = SETTINGS_DEFAULT_IMAGES_HEIGHT;
      if (!isset($settings->schools_thumbnail_width)) $settings->schools_thumbnail_width = SETTINGS_DEFAULT_THUMBNAIL_WIDTH;
      if (!isset($settings->schools_thumbnail_height)) $settings->schools_thumbnail_height = SETTINGS_DEFAULT_THUMBNAIL_HEIGHT;
      if (!isset($settings->schools_watermark_transparency)) $settings->schools_watermark_transparency = SETTINGS_DEFAULT_WATERMARK_TRANSPARENCY;
      if (!isset($settings->schools_images_exactly)) $settings->schools_images_exactly = TRUE;
      if (!isset($settings->schools_watermark_enabled)) $settings->schools_watermark_enabled = FALSE;
      if (!isset($settings->schools_watermark_location)) $settings->schools_watermark_location = IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM;
      if (!isset($settings->schools_wysiwyg_disabled)) $settings->schools_wysiwyg_disabled = FALSE;
      if (!isset($settings->schools_wysiwyg_disabled_mode)) $settings->schools_wysiwyg_disabled_mode = FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
      if (!isset($settings->schools_meta_autofill)) $settings->schools_meta_autofill = TRUE;
      if (!isset($settings->schools_sort_method)) $settings->schools_sort_method = SORT_SCHOOLS_MODE_BY_NAME;
      if (!isset($settings->schools_main_title)) $settings->schools_main_title = 'Учебные заведения';
      if (!isset($settings->schools_main_path)) $settings->schools_main_path = 'Школы';
      if (!isset($settings->schools_main_keywords)) $settings->schools_main_keywords = 'школа, список';
      if (!isset($settings->schools_main_description)) $settings->schools_main_description = 'Список школ.';
      if (!isset($settings->schools_num)) $settings->schools_num = SETTINGS_DEFAULT_ITEMS_NUM;
      if (!isset($settings->schools_num_admin)) $settings->schools_num_admin = SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;



        // проверяем настройки для ценовых групп
        for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
            $field = 'price_type' . $i;
            if (!isset($settings->$field)) {
                switch ($i) {
                    case 1: $settings->$field = 'Розница'; break;
                    case 2: $settings->$field = 'Мелкий опт'; break;
                    case 3: $settings->$field = 'Крупный опт'; break;
                    case 4: $settings->$field = 'Дилеры'; break;
                    case 5: $settings->$field = 'VIP'; break;
                    default: $settings->$field = '';
                }
            } else {
                $settings->$field = substr(trim($settings->$field), 0, PRICE_TYPE_MAXSIZE);
            }
        }



        // проверяем настройки редактора TinyMCE
        for ($j = 1; $j <= 2; $j++) {
            for ($i = 1; $i <= 2; $i++) {
                $d = $j == 1 ? '' : 'def_';
                switch ($i) {
                    case 2:
                        $field = $d . 'tinymce' . $i . '_plugins';    if ($d == 'def_' || !isset($settings->$field)) $settings->$field = 'fullscreen,table,paste';
                        $field = $d . 'tinymce' . $i . '_valid_tags'; if ($d == 'def_' || !isset($settings->$field)) $settings->$field = '-h1[class],-h2[class],-h3[class],-h4[class],-h5[class],-h6[class],'
                                                                                                                                       . '-p[class|style],-div[class|style],-i/em,-b/strong,-span[class|style],-u,'
                                                                                                                                       . '-center,-pre,-ul[class],-ol[class],-li[class],-a[!href|class|target|title],'
                                                                                                                                       . 'img[!src|align|border|class|height|hspace|title|vspace|width],'
                                                                                                                                       . '-table[align|border|class|cellspacing|cellpadding|width],-tr,td[class|height|width],'
                                                                                                                                       . 'br,hr,-cite,-abbr,-code,-sup,-sub,-font[name|size],button[class],'
                                                                                                                                       . '-form,input[class|checked|format|name|notice|title|type|value],'
                                                                                                                                       . '-select[class|multiple|name|title],option[selected|value]';
                        $field = $d . 'tinymce' . $i . '_buttons1';   if ($d == 'def_' || !isset($settings->$field)) $settings->$field = 'fullscreen,|,selectall,cut,copy,pastetext,pasteword,|,undo,redo,fontselect,fontsizeselect,forecolor,backcolor,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,outdent,indent';
                        $field = $d . 'tinymce' . $i . '_buttons2';   if ($d == 'def_' || !isset($settings->$field)) $settings->$field = 'formatselect,styleselect,|,visualaid,|,sup,sub,hr,charmap,blockquote,|,link,unlink,image,|,tablecontrols,|,removeformat,cleanup,code';
                        break;
                    case 1:
                    default:
                        $field = $d . 'tinymce' . $i . '_plugins';    if ($d == 'def_' || !isset($settings->$field)) $settings->$field = 'fullscreen,paste';
                        $field = $d . 'tinymce' . $i . '_valid_tags'; if ($d == 'def_' || !isset($settings->$field)) $settings->$field = '-p,-div,-i/em,-b/strong,-span,-u,-center,-pre,-ul/ol,-li,'
                                                                                                                                       . '-a[!href|target=_blank|title],img[!src|class|title],br';
                        $field = $d . 'tinymce' . $i . '_buttons1';   if ($d == 'def_' || !isset($settings->$field)) $settings->$field = 'formatselect,styleselect,|,fullscreen,|,selectall,cut,copy,pastetext,|,undo,redo,|,bold,italic,underline,bullist,|,link,unlink,image,|,removeformat,cleanup,code';
                        $field = $d . 'tinymce' . $i . '_buttons2';   if ($d == 'def_' || !isset($settings->$field)) $settings->$field = '';
                }
                $field = $d . 'tinymce' . $i . '_extended_valid_tags';     if ($d == 'def_' || !isset($settings->$field)) $settings->$field = '';
                $field = $d . 'tinymce' . $i . '_buttons3';                if ($d == 'def_' || !isset($settings->$field)) $settings->$field = '';
                $field = $d . 'tinymce' . $i . '_buttons4';                if ($d == 'def_' || !isset($settings->$field)) $settings->$field = '';
                $field = $d . 'tinymce' . $i . '_buttons_bottom';          if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_buttons_rightalign';      if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_statusbar';               if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_native_css';              if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_cleanup_paste';           if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_source_formatting';       if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_convert_urls';            if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_relative_urls';           if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_remove_script_host';      if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_verify_css_classes';      if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_verify_html';             if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_remove_linebreaks';       if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_remove_redundant_brs';    if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_convert_newlines_to_brs'; if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_force_br_newlines';       if ($d == 'def_' || !isset($settings->$field)) $settings->$field = FALSE;
                $field = $d . 'tinymce' . $i . '_force_p_newlines';        if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
                $field = $d . 'tinymce' . $i . '_fix_list_elements';       if ($d == 'def_' || !isset($settings->$field)) $settings->$field = TRUE;
            }
        }



        // проверяем настройки кеширования
        $field = 'htmcache_enabled';  if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'htmcache_gzip';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'htmcache_lifetime'; if (!isset($settings->$field)) $settings->$field = 900;

        $field = 'memcache_enabled';  if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'memcache_lifetime'; if (!isset($settings->$field)) $settings->$field = 900;



        // проверяем настройки партнерской программы
        $field = 'affiliates_enabled';                 if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'affiliates_referal_cost';            if (!isset($settings->$field)) $settings->$field = '0.0001';
        $field = 'affiliates_referal_lifetime';        if (!isset($settings->$field)) $settings->$field = 365 * 24 * SECONDS_IN_HOUR;
        $field = 'affiliates_referal_urlchecking';     if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'affiliates_registration_cost';       if (!isset($settings->$field)) $settings->$field = '0.0000';
        $field = 'affiliates_commission_percent';      if (!isset($settings->$field)) $settings->$field = '9.95';
        $field = 'affiliates_commission_percent_gift'; if (!isset($settings->$field)) $settings->$field = '0.05';
        $field = 'affiliates_commission_full';         if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'affiliates_commission_limit';        if (!isset($settings->$field)) $settings->$field = '';



        // проверяем настройки синхронизации 1С
        $field = 'cml_enabled';                        if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_store_old_files';                if (!isset($settings->$field)) $settings->$field = FALSE;
        $field = 'cml_ips';                            if (!isset($settings->$field)) $settings->$field = '';
        $field = 'cml_categories_import_enabled';      if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_products_import_enabled';        if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_variants_import_enabled';        if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_properties_import_enabled';      if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_orders_import_enabled';          if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_orders_export_enabled';          if (!isset($settings->$field)) $settings->$field = TRUE;
        $field = 'cml_category_node';                  if (!isset($settings->$field)) $settings->$field = 'КоммерческаяИнформация->Классификатор->Группы->Группа';
            $field = 'cml_category_id';                if (!isset($settings->$field)) $settings->$field = 'Ид';
            $field = 'cml_category_meta_title';        if (!isset($settings->$field)) $settings->$field = 'МетаЗаголовокСтраницы';
            $field = 'cml_category_meta_keywords';     if (!isset($settings->$field)) $settings->$field = 'МетаКлючевыеСловаСтраницы';
            $field = 'cml_category_meta_description';  if (!isset($settings->$field)) $settings->$field = 'МетаОписаниеСтраницы';
            $field = 'cml_category_tags';              if (!isset($settings->$field)) $settings->$field = 'Теги';
            $field = 'cml_category_name';              if (!isset($settings->$field)) $settings->$field = 'Наименование';
            $field = 'cml_category_single_name';       if (!isset($settings->$field)) $settings->$field = 'НаименованиеВЕдинственномЧисле';
            $field = 'cml_category_configurator_name'; if (!isset($settings->$field)) $settings->$field = 'НаименованиеВКонфигуратореКомплекта';
            $field = 'cml_category_description';       if (!isset($settings->$field)) $settings->$field = 'Описание';
            $field = 'cml_category_seo_description';   if (!isset($settings->$field)) $settings->$field = 'СеоТекст';
            $field = 'cml_category_subdomain';         if (!isset($settings->$field)) $settings->$field = 'НаименованиеСубдомена';
            $field = 'cml_category_subdomain_enabled'; if (!isset($settings->$field)) $settings->$field = 'РазрешеноСубдомен';
            $field = 'cml_category_subdomain_html';    if (!isset($settings->$field)) $settings->$field = 'HtmlСубдомена';
            $field = 'cml_category_image';             if (!isset($settings->$field)) $settings->$field = 'Картинка';
            $field = 'cml_category_image_alt';         if (!isset($settings->$field)) $settings->$field = 'КартинкаНаименование';
            $field = 'cml_category_image_text';        if (!isset($settings->$field)) $settings->$field = 'КартинкаОписание';
            $field = 'cml_category_image_view';        if (!isset($settings->$field)) $settings->$field = 'КартинкаРазрешеноВСлайдере';
            $field = 'cml_category_order_num';         if (!isset($settings->$field)) $settings->$field = 'ПозицияВСпискеКатегорий';
            $field = 'cml_category_template';          if (!isset($settings->$field)) $settings->$field = 'ОтображатьШаблоном';
            $field = 'cml_category_browsed';           if (!isset($settings->$field)) $settings->$field = 'КоличествоПросмотров';
            $field = 'cml_category_url';               if (!isset($settings->$field)) $settings->$field = 'АдресСтраницы';
            $field = 'cml_category_url_special';       if (!isset($settings->$field)) $settings->$field = 'АдресЯвляетсяОсобым';
            $field = 'cml_category_ymarket';           if (!isset($settings->$field)) $settings->$field = 'РазрешеноПередаватьВЯндексМаркет';
            $field = 'cml_category_vkontakte';         if (!isset($settings->$field)) $settings->$field = 'РазрешеноПубликоватьВКонтакте';
            $field = 'cml_category_enabled';           if (!isset($settings->$field)) $settings->$field = 'РазрешеноПоказыватьНаСайте';
            $field = 'cml_category_highlighted';       if (!isset($settings->$field)) $settings->$field = 'ВыделеноВизуально';
            $field = 'cml_category_own_block';         if (!isset($settings->$field)) $settings->$field = 'ИмеетСвойБлокНаГлавной';
            $field = 'cml_category_informative';       if (!isset($settings->$field)) $settings->$field = 'ЯвляетсяИнформативнойСтраницей';
            $field = 'cml_category_hidden';            if (!isset($settings->$field)) $settings->$field = 'СкрытоОтНеавторизованныхПосетителей';
            $field = 'cml_category_rss_disabled';      if (!isset($settings->$field)) $settings->$field = 'ЗапрещеноЭкспортироватьВRss';
            $field = 'cml_category_export_disabled';   if (!isset($settings->$field)) $settings->$field = 'ЗапрещеноЭкспортироватьВоВнешниеИнформеры';
            $field = 'cml_category_in_prices';         if (!isset($settings->$field)) $settings->$field = 'РазрешеноВыводитьВПрайсЛисты';
            $field = 'cml_category_objects';           if (!isset($settings->$field)) $settings->$field = 'ПодключитьПлагиныНаСтранице';
            $field = 'cml_category_subitem';           if (!isset($settings->$field)) $settings->$field = 'Группы->Группа';
        $field = 'cml_property_node';                  if (!isset($settings->$field)) $settings->$field = 'КоммерческаяИнформация->Классификатор->Свойства->СвойствоНоменклатуры';
        $field = 'cml_property_node2';                 if (!isset($settings->$field)) $settings->$field = 'КоммерческаяИнформация->Классификатор->Свойства->Свойство';
            $field = 'cml_property_id';                if (!isset($settings->$field)) $settings->$field = 'Ид';
            $field = 'cml_property_group';             if (!isset($settings->$field)) $settings->$field = 'НаименованиеГруппы';
            $field = 'cml_property_name';              if (!isset($settings->$field)) $settings->$field = 'Наименование';
            $field = 'cml_property_in_product';        if (!isset($settings->$field)) $settings->$field = 'РазрешеноНаСтраницеТовара';
            $field = 'cml_property_in_filter';         if (!isset($settings->$field)) $settings->$field = 'РазрешеноВФильтреХарактеристик';
            $field = 'cml_property_in_compare';        if (!isset($settings->$field)) $settings->$field = 'РазрешеноНаСтраницеСравнения';
            $field = 'cml_property_enabled';           if (!isset($settings->$field)) $settings->$field = 'ИспользованиеСвойства';
            $field = 'cml_property_order_num';         if (!isset($settings->$field)) $settings->$field = 'ПозицияВСпискеСвойств';
        $field = 'cml_product_node';                   if (!isset($settings->$field)) $settings->$field = 'КоммерческаяИнформация->Каталог->Товары->Товар';
            $field = 'cml_product_id';                 if (!isset($settings->$field)) $settings->$field = 'Ид';
            $field = 'cml_product_category';           if (!isset($settings->$field)) $settings->$field = 'Группы->Ид';
            $field = 'cml_product_pcode';              if (!isset($settings->$field)) $settings->$field = 'КодПроизводителя';
            $field = 'cml_product_barcode';            if (!isset($settings->$field)) $settings->$field = 'ШтрихКод';
            $field = 'cml_product_meta_title';         if (!isset($settings->$field)) $settings->$field = 'МетаЗаголовокСтраницы';
            $field = 'cml_product_meta_keywords';      if (!isset($settings->$field)) $settings->$field = 'МетаКлючевыеСловаСтраницы';
            $field = 'cml_product_meta_description';   if (!isset($settings->$field)) $settings->$field = 'МетаОписаниеСтраницы';
            $field = 'cml_product_tags';               if (!isset($settings->$field)) $settings->$field = 'Теги';
            $field = 'cml_product_name';               if (!isset($settings->$field)) $settings->$field = 'Наименование';
            $field = 'cml_product_description';        if (!isset($settings->$field)) $settings->$field = 'Описание';
            $field = 'cml_product_body';               if (!isset($settings->$field)) $settings->$field = 'ПолноеОписание';
            $field = 'cml_product_seo_description';    if (!isset($settings->$field)) $settings->$field = 'СеоТекст';
            $field = 'cml_product_video';              if (!isset($settings->$field)) $settings->$field = 'ВидеоМатериалы';
            $field = 'cml_product_subdomain';          if (!isset($settings->$field)) $settings->$field = 'НаименованиеСубдомена';
            $field = 'cml_product_subdomain_enabled';  if (!isset($settings->$field)) $settings->$field = 'РазрешеноСубдомен';
            $field = 'cml_product_subdomain_html';     if (!isset($settings->$field)) $settings->$field = 'HtmlСубдомена';
            $field = 'cml_product_image';              if (!isset($settings->$field)) $settings->$field = 'Картинка';
            $field = 'cml_product_image_alt';          if (!isset($settings->$field)) $settings->$field = 'КартинкаНаименование';
            $field = 'cml_product_image_text';         if (!isset($settings->$field)) $settings->$field = 'КартинкаОписание';
            $field = 'cml_product_image_view';         if (!isset($settings->$field)) $settings->$field = 'КартинкаРазрешеноВСлайдере';
            $field = 'cml_product_file';               if (!isset($settings->$field)) $settings->$field = 'Файл';
            $field = 'cml_product_file_alt';           if (!isset($settings->$field)) $settings->$field = 'ФайлНаименование';
            $field = 'cml_product_file_text';          if (!isset($settings->$field)) $settings->$field = 'ФайлОписание';
            $field = 'cml_product_download';           if (!isset($settings->$field)) $settings->$field = 'ФайлЦифровогоТовара';
            $field = 'cml_product_guarantee';          if (!isset($settings->$field)) $settings->$field = 'Гарантия';
            $field = 'cml_product_coming';             if (!isset($settings->$field)) $settings->$field = 'ОжидаемаяДатаПоступленияВПродажу';
            $field = 'cml_product_property';           if (!isset($settings->$field)) $settings->$field = 'ХарактеристикиТовара->ХарактеристикаТовара';
            $field = 'cml_product_property_name';      if (!isset($settings->$field)) $settings->$field = 'Наименование';
            $field = 'cml_product_property_value';     if (!isset($settings->$field)) $settings->$field = 'Значение';
            $field = 'cml_product_order_num';          if (!isset($settings->$field)) $settings->$field = 'ПозицияВСпискеТоваров';
            $field = 'cml_product_template';           if (!isset($settings->$field)) $settings->$field = 'ОтображатьШаблоном';
            $field = 'cml_product_browsed';            if (!isset($settings->$field)) $settings->$field = 'КоличествоПросмотров';
            $field = 'cml_product_url';                if (!isset($settings->$field)) $settings->$field = 'АдресСтраницы';
            $field = 'cml_product_url_special';        if (!isset($settings->$field)) $settings->$field = 'АдресЯвляетсяОсобым';
            $field = 'cml_product_hit';                if (!isset($settings->$field)) $settings->$field = 'ЯвляетсяХитомПродаж';
            $field = 'cml_product_newest';             if (!isset($settings->$field)) $settings->$field = 'ЯвляетсяНовинкой';
            $field = 'cml_product_actional';           if (!isset($settings->$field)) $settings->$field = 'ЯвляетсяАкционным';
            $field = 'cml_product_awaited';            if (!isset($settings->$field)) $settings->$field = 'ЯвляетсяОжидаемым';
            $field = 'cml_product_ymarket';            if (!isset($settings->$field)) $settings->$field = 'РазрешеноПередаватьВЯндексМаркет';
            $field = 'cml_product_vkontakte';          if (!isset($settings->$field)) $settings->$field = 'РазрешеноПубликоватьВКонтакте';
            $field = 'cml_product_enabled';            if (!isset($settings->$field)) $settings->$field = 'РазрешеноПоказыватьНаСайте';
            $field = 'cml_product_highlighted';        if (!isset($settings->$field)) $settings->$field = 'ВыделеноВизуально';
            $field = 'cml_product_commented';          if (!isset($settings->$field)) $settings->$field = 'РазрешеноОбсуждать';
            $field = 'cml_product_hidden';             if (!isset($settings->$field)) $settings->$field = 'СкрытоОтНеавторизованныхПосетителей';
            $field = 'cml_product_rss_disabled';       if (!isset($settings->$field)) $settings->$field = 'ЗапрещеноЭкспортироватьВRss';
            $field = 'cml_product_export_disabled';    if (!isset($settings->$field)) $settings->$field = 'ЗапрещеноЭкспортироватьВоВнешниеИнформеры';
            $field = 'cml_product_non_creditable';     if (!isset($settings->$field)) $settings->$field = 'ЗапрещеноПродаватьВКредит';
            $field = 'cml_product_non_usable';         if (!isset($settings->$field)) $settings->$field = 'СлужитВыставочнымЭкспонатом';
            $field = 'cml_product_in_prices';          if (!isset($settings->$field)) $settings->$field = 'РазрешеноВыводитьВПрайсЛисты';
            $field = 'cml_product_objects';            if (!isset($settings->$field)) $settings->$field = 'ПодключитьПлагиныНаСтранице';
        $field = 'cml_variant_node';                   if (!isset($settings->$field)) $settings->$field = 'КоммерческаяИнформация->ПакетПредложений->Предложения->Предложение';
            $field = 'cml_variant_id';                 if (!isset($settings->$field)) $settings->$field = 'Ид';
            $field = 'cml_variant_sku';                if (!isset($settings->$field)) $settings->$field = 'Артикул';
            $field = 'cml_variant_name';               if (!isset($settings->$field)) $settings->$field = 'НаименованиеВарианта';
            $field = 'cml_variant_stock';              if (!isset($settings->$field)) $settings->$field = 'Количество';
            $field = 'cml_variant_position';           if (!isset($settings->$field)) $settings->$field = 'ПозицияВСпискеВариантов';
            $field = 'cml_variant_discount';           if (!isset($settings->$field)) $settings->$field = 'ПриоритетнаяСкидка';
            $field = 'cml_variant_currency';           if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->Валюта';
            for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                $field = 'cml_variant_price' . (($i > 1) ? $i : '');
                if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->ЦенаЗаЕдиницу' . (($i > 1) ? 'ДляЦеновойГруппы' . $i : '');
            }
            $field = 'cml_variant_old_price';          if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->СтараяЦенаЗаЕдиницу';
            $field = 'cml_variant_temp_price';         if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->АкционнаяЦенаЗаЕдиницу';
            $field = 'cml_variant_temp_price_start';   if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->ДатаНачалаДействияАкционнойЦены';
            $field = 'cml_variant_temp_price_date';    if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->ДатаКонцаДействияАкционнойЦены';
            $field = 'cml_variant_temp_price_members'; if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->ЧислоНеобходимыхУчастниковДляНаступленияАкционнойЦены';
            $field = 'cml_variant_temp_price_invited'; if (!isset($settings->$field)) $settings->$field = 'Цены->Цена->ЧислоУжеПривлеченныхУчастниковДляНаступленияАкционнойЦены';
            $field = 'cml_history';                    if (!isset($settings->$field)) $settings->$field = '';
            $field = 'cml_history_adds_enabled';       if (!isset($settings->$field)) $settings->$field = TRUE;
            $field = 'cml_history_changes_enabled';    if (!isset($settings->$field)) $settings->$field = FALSE;



      // проверяем настройки для запретов доступа
      if (!isset($settings->banneds_noaccess_text)) $settings->banneds_noaccess_text = "<html>\r\n"
                                                                                     . "  <head>\r\n"
                                                                                     . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n"
                                                                                     . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
                                                                                     . "    <title>Отказано в доступе</title>\r\n"
                                                                                     . "  </head>\r\n"
                                                                                     . "  <body>\r\n"
                                                                                     . "    <div style=\"background-color: #F0F0F0; border: #D0D0D0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt; margin: 100px 30%; padding: 15px; text-align: center; text-indent: 0px;\">\r\n"
                                                                                     . "      Доступ к сайту запрещен для Вашего компьютера!\r\n"
                                                                                     . "    </div>\r\n"
                                                                                     . "  </body>\r\n"
                                                                                     . "</html>";
      if (!isset($settings->banneds_noregister_text)) $settings->banneds_noregister_text = "<html>\r\n"
                                                                                         . "  <head>\r\n"
                                                                                         . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n"
                                                                                         . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
                                                                                         . "    <title>Отказано в доступе</title>\r\n"
                                                                                         . "  </head>\r\n"
                                                                                         . "  <body>\r\n"
                                                                                         . "    <div style=\"background-color: #F0F0F0; border: #D0D0D0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt; margin: 100px 30%; padding: 15px; text-align: center; text-indent: 0px;\">\r\n"
                                                                                         . "      Доступ к этой странице сайта запрещен для Вашего компьютера!\r\n"
                                                                                         . "    </div>\r\n"
                                                                                         . "  </body>\r\n"
                                                                                         . "</html>";
      if (!isset($settings->banneds_nocomment_text)) $settings->banneds_nocomment_text = "Функции комментариев и отправки сообщений не обслуживаются для Вашего компьютера, "
                                                                                       . "так как он занесен в черный список за рассылку спама!";
      if (!isset($settings->banneds_nocallme_text)) $settings->banneds_nocallme_text = "Функции отправки запроса связи не обслуживаются для Вашего компьютера, "
                                                                                     . "так как он занесен в черный список за рассылку спама!";
      if (!isset($settings->banneds_noadmin_text)) $settings->banneds_noadmin_text = "<html>\r\n"
                                                                                   . "  <head>\r\n"
                                                                                   . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n"
                                                                                   . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
                                                                                   . "    <title>Отказано в доступе</title>\r\n"
                                                                                   . "  </head>\r\n"
                                                                                   . "  <body>\r\n"
                                                                                   . "    <div style=\"background-color: #F0F0F0; border: #D0D0D0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt; margin: 100px 30%; padding: 15px; text-align: center; text-indent: 0px;\">\r\n"
                                                                                   . "      Доступ к админпанели сайта запрещен для Вашего компьютера!\r\n"
                                                                                   . "    </div>\r\n"
                                                                                   . "  </body>\r\n"
                                                                                   . "</html>";

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // установка списка сортировок товаров в форме клиентской стороны ========

    private function set_sort_form () {

      // все эти сортировки видны админу,
      // видные клиенту сортировки предваряем маркером >
      $this->sort_products_fields = array();
      $this->sort_products_fields[SORT_PRODUCTS_MODE_DEFAULT] = ">стандартно";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_PRICE] = ">цена";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_NAME] = ">название";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_QUANTITY] = ">в наличии";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_VARIANTSCOUNT] = "число видов";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_CREATED] = "дата появления";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_MODIFIED] = "дата изменения";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_ORDERED] = "дата заказа";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_COMMENTED] = "дата отзыва";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_COMMENTS] = "число отзывов";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_ORDERSCOUNT] = "число покупок";
      $this->sort_products_fields[SORT_PRODUCTS_MODE_BY_ORDERSSUM] = "сумма покупок";
    }

    // получение html-контента клиентской формы сортировки  ==================

    private function get_sort_form () {

      // создаем контент формы
      $ok = FALSE;
      $result = "<form name=\"sort_form\" method=\"post\">\r\n"
              . "  сортировать:\r\n"
              . "  <select name=\"by_field_sort\">\r\n";

      // если задан список сортировок
      if (isset($this->sort_products_fields)
      && is_array($this->sort_products_fields)
      && !empty($this->sort_products_fields)) {

        // перебираем элементы списка
        foreach ($this->sort_products_fields as $key => $value) {

          // если страницу просматривает администратор или текущий элемент предназначен клиенту
          if ((isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) && ($_SESSION[SESSION_PARAM_NAME_ADMIN] == "admin"))
          || (substr($value, 0, 1) == ">")) {

            // если название элемента предварено маркером > (показывать клиенту), убираем маркер
            if (substr($value, 0, 1) == ">") $value = substr($value, 1);

            // добавляем элемент в контент формы
            $result .= "    <option onclick=\"javascript: window.document.sort_form.submit(); return true;\" value=\"" . htmlspecialchars($key, ENT_QUOTES) . "\"" . (($this->sort_products_mode == $key) ? " selected" : "") . ">\r\n"
                     . "      " . $value . "\r\n"
                     . "    </option>\r\n";
            $ok = TRUE;
          }
        }
      }

      // завершаем контент формы
      $result .= "  </select>\r\n"
               . "  &nbsp;<span style=\"white-space: nowrap;" . (($this->sort_products_mode != SORT_PRODUCTS_MODE_AS_IS) ? "" : " display: none;") . "\"><input" . ($this->sort_products_direction ? " checked" : "") . " class=\"checkbox\" name=\"descending_sort\" onclick=\"javascript: window.document.sort_form.submit(); return true;\" type=\"checkbox\" value=\"" . htmlspecialchars(SORT_DIRECTION_ASCENDING, ENT_QUOTES) . "\"> по убыванию</span>\r\n"
               . "</form>\r\n";

      // если форма не содержит сортировок
      if (!$ok) $result = "<!-- Not found items for the sort form -->";

      // возвращаем контент
      return $result;
    }

    // получение выбранного в клиентской форме способа сортировки  ===========

    private function get_sort_products_mode () {

      // если клиентская форма сортировки товаров разрешена в настройках сайта
      if ($this->settings->sort_form_enabled) {

        // берем выбранный способ сортировки: из формы, или сеанса, или настроек сайта
        $this->sort_products_mode = isset($_POST['by_field_sort'])
                                    ? $_POST['by_field_sort']
                                    : (isset($_SESSION['client_sort_mode'])
                                      ? $_SESSION['client_sort_mode']
                                      : (isset($this->settings->sort_form_default_method)
                                        ? $this->settings->sort_form_default_method
                                        : SORT_PRODUCTS_MODE_DEFAULT));

        // если такой способ не перечислен в списке сортировок клиентской формы
        // или он не предназначен клиенту и пользовался формой не администратор
        if (!isset($this->sort_products_fields[$this->sort_products_mode])
        || ((substr($this->sort_products_fields[$this->sort_products_mode], 0, 1) != '>')
        && (!isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) || ($_SESSION[SESSION_PARAM_NAME_ADMIN] != 'admin')))) {
          $this->sort_products_mode = SORT_PRODUCTS_MODE_DEFAULT;
        }

        // если выбрана сортировка по умолчанию (как задана на странице товаров в "настройки" админпанели)
        if ($this->sort_products_mode == SORT_PRODUCTS_MODE_DEFAULT) {

          // используем сортировку как задана на странице товаров в "настройки" админпанели
          $this->sort_products_mode = $this->settings->products_sort_method;
          $this->sort_products_direction = $this->settings->products_sort_direction;
          $this->sort_products_laconical = $this->settings->products_sort_laconical;

          // удаляем данные из сеанса
          if (isset($_SESSION['client_sort_mode'])) unset($_SESSION['client_sort_mode']);
          if (isset($_SESSION['client_sort_direction'])) unset($_SESSION['client_sort_direction']);
          if (isset($_SESSION['client_sort_laconical'])) unset($_SESSION['client_sort_laconical']);

        // иначе если не сортировка "как расставлены в админпанели"
        } elseif ($this->sort_products_mode != SORT_PRODUCTS_MODE_AS_IS) {

          // берем выбранное направление сортировки: из формы, или сеанса, или настроек сайта
          $this->sort_products_direction = isset($_POST['descending_sort']) || isset($_POST['by_field_sort'])
                                           ? (isset($_POST['descending_sort']) ? $_POST['descending_sort'] : 0)
                                           : (isset($_SESSION['client_sort_direction'])
                                             ? $_SESSION['client_sort_direction']
                                             : (isset($this->settings->sort_form_default_descending) ? $this->settings->sort_form_default_descending : 0));

          // берем выбранную лаконичность сортировки: из формы, или сеанса, или настроек сайта
          $this->sort_products_laconical = isset($_POST['laconical_sort']) || isset($_POST['by_field_sort'])
                                           ? (isset($_POST['laconical_sort']) ? $_POST['laconical_sort'] : 0)
                                           : (isset($_SESSION['client_sort_laconical'])
                                             ? $_SESSION['client_sort_laconical']
                                             : (isset($this->settings->sort_form_default_laconical) ? $this->settings->sort_form_default_laconical : 0));

          // запоминаем в сеансе новый выбор
          $_SESSION['client_sort_mode'] = $this->sort_products_mode;
          $_SESSION['client_sort_direction'] = $this->sort_products_direction;
          $_SESSION['client_sort_laconical'] = $this->sort_products_laconical;

        // иначе сортировка "как расставлены в админпанели"
        } else {

          // удаляем лишние данные из сеанса
          if (isset($_SESSION['client_sort_direction'])) unset($_SESSION['client_sort_direction']);
          if (isset($_SESSION['client_sort_laconical'])) unset($_SESSION['client_sort_laconical']);

          // запоминаем в сеансе новый выбор
          $_SESSION['client_sort_mode'] = $this->sort_products_mode;
        }

      // иначе клиентская форма сортировки товаров запрещена
      } else {

        // используем сортировку как задана на странице товаров в "настройки" админпанели
        $this->sort_products_mode = $this->settings->products_sort_method;
        $this->sort_products_direction = $this->settings->products_sort_direction;
        $this->sort_products_laconical = $this->settings->products_sort_laconical;

        // удаляем данные из сеанса
        if (isset($_SESSION['client_sort_mode'])) unset($_SESSION['client_sort_mode']);
        if (isset($_SESSION['client_sort_direction'])) unset($_SESSION['client_sort_direction']);
        if (isset($_SESSION['client_sort_laconical'])) unset($_SESSION['client_sort_laconical']);
      }
    }

    function put_currencies_to_Smarty($start_mode = BASIC_START_FOR_CLIENT_MODE) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method('BASIC put_currencies_to_Smarty');

      $query = 'SELECT * '
             . 'FROM `currencies` '
             . 'ORDER BY `currency_id` ASC;';
      $this->db->query($query);
      $this->currencies = array();
      $this->currency = null;
      $this->main_currency = null;
      $this->default_currency = null;
      $this->usd_currency = null;
      $this->euro_currency = null;
      $temp_currencies = $this->db->results();
      if (!empty($temp_currencies)) {
        foreach ($temp_currencies as &$currency) {
          $this->currencies[$currency->currency_id] = $currency;
          if ($currency->main == 1) {
            if (empty($this->main_currency) == TRUE) $this->main_currency = $currency;
          }
          if ((($currency->def == 1) && ($start_mode === BASIC_START_FOR_CLIENT_MODE))
          || (($currency->defa == 1) && ($start_mode === BASIC_START_FOR_ADMIN_MODE))) {
            if (empty($this->default_currency) == TRUE) $this->default_currency = $currency;
          }
          if (strtolower($currency->code) == "usd") {
            if (empty($this->usd_currency) == TRUE) $this->usd_currency = $currency;
          }
          if (strtolower($currency->code) == "eur") {
            if (empty($this->euro_currency) == TRUE) $this->euro_currency = $currency;
          }
        }
      }
      if ($start_mode === BASIC_START_FOR_CLIENT_MODE) {
        if (isset($_POST["currency_id"]) == TRUE) {
          $_SESSION["currency_id"] = @intval($_POST["currency_id"]);
        }
      } else {
        if (isset($_POST["admin_currency_id"]) == TRUE) {
          $_SESSION["admin_currency_id"] = @intval($_POST["admin_currency_id"]);
        }
      }
      if ((($start_mode === BASIC_START_FOR_CLIENT_MODE) && (isset($_SESSION["currency_id"]) == TRUE) && (isset($this->currencies[@intval($_SESSION["currency_id"])]) == TRUE))
      || (($start_mode === BASIC_START_FOR_ADMIN_MODE) && (isset($_SESSION["admin_currency_id"]) == TRUE) && (isset($this->currencies[@intval($_SESSION["admin_currency_id"])]) == TRUE))) {
        if ($start_mode === BASIC_START_FOR_CLIENT_MODE) {
          $this->currency = $this->currencies[@intval($_SESSION["currency_id"])];
        } else {
          $this->currency = $this->currencies[@intval($_SESSION["admin_currency_id"])];
        }
      } else {
        if (empty($this->default_currency) == FALSE) {
          $this->currency = $this->default_currency;
        } else {
          if (empty($this->main_currency) == FALSE) {
            $this->currency = $this->main_currency;
          } else {
            if (empty($this->usd_currency) == FALSE) {
              $this->currency = $this->usd_currency;
            } else {
              if (empty($this->euro_currency) == FALSE) $this->currency = $this->euro_currency;
            }
          }
        }
      }
      $this->db->currencies = &$this->currencies;
      $this->db->currency = &$this->currency;
      $this->smarty->assign("currencies", $this->currencies);
      $this->smarty->assign("currency", $this->currency);
      $this->smarty->assign("default_currency", $this->default_currency);
      $this->smarty->assign("MainCurrency", $this->main_currency);
      $this->smarty->assign("main_currency", $this->main_currency);
      $this->smarty->assign("usd_currency", $this->usd_currency);
      $this->smarty->assign("euro_currency", $this->euro_currency);

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
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
            $this->body = '';
            return TRUE;
        }






    function stripslashes_recursive($var) {
      if (!is_array($var)) return stripcslashes($var);
      $res = null;
      foreach ($var as $k => $v) $res[stripcslashes($k)] = $this->stripslashes_recursive($v);
      return $res;
    }

    function url_filter($val) {
      $val = preg_replace("/[^A-zА-я0-9_\-\.\%\s]/ui", "", $val);
      return $val;
    }

    function url_filtered_param($name) {
      return $this->url_filter($this->param($name));
    }



        public function form_get ( $extra_params = array() ) {
            $copy = $this->params;
            foreach ($extra_params as $key => $value) {
                if (!is_null($value)) $copy[$key] = $value;
            }
            $get = '';
            foreach ($copy as $key => $value) {
                if (is_array($value)) {
                    $value = array_shift($value);
                    if (is_null($value)) $value = '';
                }
                if (strval($value) != '') {
                    $get .= ($get == '') ? '?' : '&';
                    $get .= urlencode($key) . '=' . urlencode($value);
                }
            }
            return $get;
        }



        // ===================================================================
        /**
        *  Проверка token-аутентичности
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function check_token () {

            // если токен запроса не совпадает с токеном сеанса
            $param = REQUEST_PARAM_NAME_TOKEN;
            if (!isset($_REQUEST[$param]) || ($_REQUEST[$param] == '')
            || !isset($_SESSION[$param]) || ($_SESSION[$param] == '')
            || ($_REQUEST[$param] !== $_SESSION[$param])) {



                // перенаправить на главную
                $this->security->redirectToPage('http://' . $this->root_url . '/' . $this->hdd->safeFilename($this->admin_folder));
            }
        }



    // генерация html-фрагмента микро информации корзины =====================

    public function get_cart_microinfo_content ($cart_count, $cart_total, $cart_discount, $defer_count) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC get_cart_microinfo_content");

      // если в корзине есть товары
      if (!empty($cart_count)) {

        // делаем правильное окончание слова в согласии с количеством товаров
        $cart_count = abs($cart_count);
        $ptext = "товаров";
        $p1 = $cart_count % 10;
        $p2 = $cart_count % 100;
        if (($p2 < 11) || ($p2 > 19)) {
          if ($p1 == 1) {
            $ptext = "товар";
          } else {
            if (($p1 >= 2) && ($p1 <= 4)) $ptext = "товара";
          }
        }

        // формируем html-фрагмент
        $cart_discount = abs($cart_discount);
        $result = "В <a href=\"http://" . htmlspecialchars($this->root_url, ENT_QUOTES) . "/cart\" onclick=\"javascript: document.cookie = \'from=\' + location.href + \';path=/\';\">"
                    . "корзинe"
                  . "</a> " . $cart_count . " " . $ptext . "<br>"
                . "на " . sprintf("%.2f", abs($cart_total) * $this->currency->rate_from / $this->currency->rate_to) . "&nbsp;" . $this->currency->sign
                . (($cart_discount != 0) ? " <span style=\"font-size: 8pt; text-decoration: blink;\">(скидка: " . sprintf("%.2f", $cart_discount * $this->currency->rate_from / $this->currency->rate_to) . ")</span>" : "");

      // иначе в корзине нет товаров
      } else {
        $result = "Корзина пуста";

        // если есть отложенные товары
        if (!empty($defer_count)) {

          // делаем правильное окончание слова в согласии с количеством товаров
          $defer_count = abs($defer_count);
          $ptext = "товаров";
          $p1 = $defer_count % 10;
          $p2 = $defer_count % 100;
          if (($p2 < 11) || ($p2 > 19)) {
            if ($p1 == 1) {
              $ptext = "товар";
            } else {
              if (($p1 >= 2) && ($p1 <= 4)) $ptext = "товара";
            }
          }

          // дополняем html-фрагмент
          $result .= "<br><a href=\"http://" . htmlspecialchars($this->root_url, ENT_QUOTES) . "/defer\" onclick=\"javascript: document.cookie = \'from=\' + location.href + \';path=/\';\">"
                         . "отложено"
                       . "</a> " . $defer_count . " " . $ptext;
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();

      // возвращаем результат
      return $result;
    }

    function get_compare_microinfo_content() {
      $compare_products_num = 0;
      if (isset($_SESSION["compared_products"]) == TRUE) {
        $compare_products_num = count($_SESSION["compared_products"]);
      }
      if ($compare_products_num > 0) {
        $ptext = "товаров";
        $p1 = $compare_products_num % 10;
        $p2 = $compare_products_num % 100;
        if (($p2 < 11) || ($p2 > 19)) {
          if ($p1 == 1) {
            $ptext = "товар";
          } else {
            if (($p1 >= 2) && ($p1 <= 4)) $ptext = "товара";
          }
        }
        $result = "В <a href=\"compare/\">сравнении</a> " . $compare_products_num . " " . $ptext;
      } else {
        $result = "В сравнении нет товаров";
      }
      return $result;
    }

    // создание защищающего .htaccess ==========================================

    public function smart_create_guard_htaccess ($file, $rewrite = FALSE, $matches = "") {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC smart_create_guard_htaccess");

      // готовим сохранение файла
      if ($rewrite || !file_exists($file)) {
        if (!$handle = @fopen($file, "rb+")) $handle = @fopen($file, "wb");
        if ($handle) {
          flock($handle, LOCK_EX);

          // готовим контент файла (запрещаем доступ к любым файлам)
          $text = "";
          if ($matches != "*") {
            $text = "<Files \"*\">\r\n"
                  . "  Order Deny,Allow\r\n"
                  . "  Deny from All\r\n"
                  . "</Files>\r\n"
                  . "\r\n";
          }
          $text .= "<IfModule mime_module>\r\n"
                 . "  RemoveHandler .phtml .php .php3 .php4 .php5 .php6 .phps .cgi .exe .com .dll .pl .asp .aspx .shtml .shtm .fcgi .fpl .jsp .wml\r\n"
                 . "  RemoveType    .phtml .php .php3 .php4 .php5 .php6 .phps .cgi .exe .com .dll .pl .asp .aspx .shtml .shtm .fcgi .fpl .jsp .wml\r\n"
                 . "</IfModule>\r\n"
                 . "\r\n"
                 . "<IfModule mod_php5.c>\r\n"
                 . "  php_flag engine off\r\n"
                 . "</IfModule>\r\n"
                 . "<IfModule mod_php4.c>\r\n"
                 . "  php_flag engine off\r\n"
                 . "</IfModule>\r\n";

          // если заданы разрешенные файлы, добавляем открытие доступа к ним
          if (($matches != "") && ($matches != "*")) {
            $text .= "\r\n"
                   . "<FilesMatch \"" . $matches . "\">\r\n"
                   . "  Order Allow,Deny\r\n"
                   . "  Allow from All\r\n"
                   . "</FilesMatch>\r\n";
          }

          // сохраняем файл
          $size = strlen($text);
          fwrite($handle, $text, $size);
          ftruncate($handle, $size);
          fclose($handle);
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // создание защищающего index.html =========================================

    public function smart_create_guard_indexhtm ($file, $rewrite = FALSE) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC smart_create_guard_indexhtm");

      // готовим сохранение файла
      if ($rewrite || !file_exists($file)) {
        if (!$handle = @fopen($file, "rb+")) $handle = @fopen($file, "wb");
        if ($handle) {
          flock($handle, LOCK_EX);

          // готовим контент файла
          $text = "<HTML>\r\n"
                . "  <HEAD>\r\n"
                . "    <META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; CHARSET=Windows-1251\">\r\n"
                . "    <META HTTP-EQUIV=\"Content-Language\" CONTENT=\"ru\">\r\n"
                . "    <TITLE>This is not usable page of website</TITLE>\r\n"
                . "  </HEAD>\r\n"
                . "  <BODY>\r\n"
                . "    This is not usable page of website.<BR>\r\n"
                . "    Please visit its main page.\r\n"
                . "  </BODY>\r\n"
                . "</HTML>\r\n";

          // сохраняем файл
          $size = strlen($text);
          fwrite($handle, $text, $size);
          ftruncate($handle, $size);
          fclose($handle);
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // создание защищенной папки ===============================================

    public function smart_create_folder ($path,
                                         $mode = FOLDER_GUARD_MODE_VIA_HTACCESS,
                                         $access = 0777,
                                         $rewrite = FALSE,
                                         $pattern = "") {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC smart_create_folder");

      // поправляем путь
      $url = str_replace("\\", "/", $path);
      while (substr($url, -1) == "/") $url = substr($url, 0, -1);

      // создаем папку (с указанными правами доступа)
      $exists = file_exists($url);
      if (!$exists) $exists = @mkdir($url, $access, TRUE);

      // какой режим защиты папки?
      if ($exists) {
        switch ($mode) {

          // если через .htaccess
          case FOLDER_GUARD_MODE_VIA_HTACCESS:
            $this->smart_create_guard_htaccess($url . "/.htaccess", $rewrite);
            break;

          // если через index.html
          case FOLDER_GUARD_MODE_VIA_INDEX:
            $this->smart_create_guard_indexhtm($url . "/index.html", $rewrite);
            break;

          // если через .htaccess и index.html
          case FOLDER_GUARD_MODE_VIA_HTACCESSINDEX:
            $this->smart_create_guard_htaccess($url . "/.htaccess", $rewrite);
            $this->smart_create_guard_indexhtm($url . "/index.html", $rewrite);
            break;

          // если через .htaccess и index.html
          case FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_IMAGES:
            if (trim($pattern) == "") $pattern = "\.(jpe?g|png|gif)$";
            $this->smart_create_guard_htaccess($url . "/.htaccess", $rewrite, $pattern);
            $this->smart_create_guard_indexhtm($url . "/index.html", $rewrite);
            break;

          // если через .htaccess и index.html
          case FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_ANY_NONEXECUTED:
            if (trim($pattern) == "") $pattern = "*";
            $this->smart_create_guard_htaccess($url . "/.htaccess", $rewrite, $pattern);
            $this->smart_create_guard_indexhtm($url . "/index.html", $rewrite);
            break;

          // иначе другой режим
          case FOLDER_GUARD_MODE_NOTHING:
          default:
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();

      // возвращаем путь
      return $path;
    }



        // ===================================================================
        /**
        *  Прием отзыва на товар
        *
        *  @access  public
        *  @param   object  $product    запись о товаре
        *  @return  void
        */
        // ===================================================================

        public function post_comment ( $product ) {

            // открываем трассировку этого метода
            $this->db->open_tracing_method('BASIC post_comment');

            // берем контрольное поле репостинга формы
            $copystop = trim($this->param('post_copystop'));
            if ($copystop == '') $copystop = rand(1, 1000000000);

            // формируем запись отзыва из полей поступившей формы
            $item = new stdClass;
            $item->name = trim(strip_tags($this->param('post_name')));
            $item->comment = trim(strip_tags($this->param('post_message')));
            $item->email = trim(strip_tags($this->param('post_email')));
            $item->parent_id = @intval($this->param('post_parent_id'));

            // если действительно получена форма с отзывом
            if (isset($_REQUEST['post_submit'])) {

                // берем IP-адрес пользователя
                $client_ip = $this->security->getVisitorIp();

                // проверяем наличие неотмененного запрета доступа к комментариям для такого IP-адреса (включив проверку даты действия запрета)
                $params = new stdClass;
                $params->ip = $client_ip;
                $params->enabled = 1;
                $params->no_comment = 1;
                $params->date = 1;
                $this->db->get_banned($row, $params);

                // если запрет доступа существует, регистрируем +1 попытку доступа, формируем сообщение об ошибке
                $cancel = FALSE;
                if (!empty($row)) {
                    $temp = new stdClass;
                    $temp->ban_id = $row->ban_id;
                    $temp->attempts = $row->attempts + 1;
                    $temp->attempts_date = time();
                    $this->db->update_banned($temp);
                    $cancel = $this->push_error($this->settings->banneds_nocomment_text);

                // иначе текущему IP-адресу незапрещена публикация
                } else {

                    // проверяем заполненность полей
                    if ($item->name == '') $cancel = $this->push_error('Вы не ввели имя!', '<br>');
                    if ($item->comment == '') $cancel = $this->push_error('Вы не ввели текст отзыва!', '<br>');
                    if (($item->email != '') && !preg_match(EMAIL_CHECKING_PATTERN, $item->email)) $cancel = $this->push_error('Емейл должен быть в формате aaa@bbb.ccc!', '<br>');

                    // если неправильно введен защитный код
                    if (!$this->security->checkCaptcha()) $cancel = $this->push_error('Введите правильный защитный код с картинки.', '<br>');
                }

                // если нет ошибки
                if (!$cancel) {

                    // если такой контрольный код репостинга формы еще не встречался
                    if (!isset($_SESSION['comment_copystop']) || !in_array($copystop, $_SESSION['comment_copystop'])) {

                        // если пытается публиковать отзывы слишком часто
                        $item->date = time();
                        if (isset($_SESSION['comment_next_time']) && ($_SESSION['comment_next_time'] > $item->date)) {
                            $cancel = $this->push_error('У вас нет прав оставлять отзывы слишком часто! Попробуйте через ' . @intval($_SESSION['comment_next_time'] - $item->date) . ' секунд.', '<br>');

                        // иначе сохраняем отзыв
                        } else {
                            $item->ip = $client_ip;
                            $item->product_id = isset($product->product_id) ? $product->product_id : '';
                            $item->from_user = empty($this->user) ? 0 : $this->user;
                            $item->enabled = $this->settings->products_comment_moderation ? 0 : 1;
                            $item->comment_id = $this->db->update_comment($item);

                            // преобразуем дату в читаемый вид
                            $item->date = $this->date->readableDateTime($item->date);

                            // рисуем письмо по шаблону
                            $this->smarty->assignByRef('post', $item);
                            $this->smarty->assignByRef('post_object', $product);
                            $template = $this->hdd->safeFilename($this->admin_folder)
                                      . '/design/'
                                      . $this->hdd->safeFilename($this->settings->admin_theme)
                                      . '/html/'
                                      . EMAIL_POST_TO_ADMIN_TEMPLATE_FILE;
                            $message = $this->smarty->fetch($template);

                            // отправляем письмо админу
                            $this->email($this->settings->admin_email,
                                         'Новый отзыв о товаре сайта ' . $this->root_url,
                                         $message);

                            // устанавливаем лимит времени до следующей публикации
                            $_SESSION['comment_next_time'] = time() + abs(@intval($this->settings->products_comment_next_time));

                            // блокируем репостинг этой формы
                            $_SESSION['comment_copystop'][] = $copystop;

                            $this->push_info('Спасибо! Ваш отзыв принят' . ($this->settings->products_comment_moderation ? ' и отправлен на модерацию' : '') . '.');

                            // устанавливаем странице фоновый звук УСПЕХ
                            $this->success_bgsound();
                        }
                    }

                    // если отзыв принят успешно, очищаем поля для нового
                    if (!$cancel) {
                        $item->name = '';
                        $item->comment = '';
                        $item->email = '';
                        $item->parent_id = '';

                        // выдумываем новому отзыву контрольный код репостинга
                        $copystop = rand(1, 1000000000);
                    }
                }
            }

            // передаем поля отзыва (нового или возвращенного на исправление) в шаблонизатор
            $this->smarty->assign('post_copystop', $copystop);
            $this->smarty->assign('post_name', empty($item->name) ? (empty($this->user) ? '' : $this->user->compound_name) : $item->name);
            $this->smarty->assign('post_message', $item->comment);
            $this->smarty->assign('post_email', empty($item->email) ? (empty($this->user) ? '' : ((trim($this->user->email) != '') ? $this->user->email : $this->user->email2)) : $item->email);
            $this->smarty->assign('post_parent_id', empty($item->parent_id) ? '' : $item->parent_id);

            // закрываем трассировку этого метода
            $this->db->close_tracing_method();
        }



    // извлечение полей псевдозаписи ===========================================

    public function get_record_fields ( $text, & $data ) {

        // извлекаем поля и их содержимое
        if (function_exists('preg_match')) {
            while (preg_match('|<!--\s*([a-z0-9_]+)(\[\])?\s*\-\->(.*?)<!--\s*/\\1\s*-->|is', $text, $matches, PREG_OFFSET_CAPTURE)) {
                $size = $matches[0][1] + strlen($matches[0][0]);
                $field = isset($matches[1][0]) ? strtolower(trim($matches[1][0])) : '';
                if ($field != '') {



                    // если это поле-массив
                    if (!is_object($data)) $data = new stdClass;
                    if (isset($matches[2][0]) && (trim($matches[2][0]) != '')) {



                        if (!isset($data->$field)) $data->$field = array();
                        array_push($data->$field, isset($matches[3][0]) ? trim($matches[3][0]) : '');



                    // иначе это обычное поле
                    } else {
                        $data->$field = isset($matches[3][0]) ? trim($matches[3][0]) : '';
                    }
                }



                // удаляем поле из прочитанного
                if ($size <= 0) break;
                $text = substr($text, $size);
            }
        }
    }



    // установка полей псевдозаписи ============================================

    public function set_record_fields (&$data) {

      // вставляем поля и их содержимое
      $text = "";
      if (!empty($data)) {
        foreach ($data as $field => &$value) {
          if (is_array($value)) {
            foreach ($value as $item) $text .= "<!-- " . $field . "[] -->" . trim($item) . "<!-- /" . $field . " -->\r\n";
          } else {
            $text .= "<!-- " . $field . " -->" . trim($value) . "<!-- /" . $field . " -->\r\n";
          }
        }
      }

      // возвращаем текст записи
      return $text;
    }



        // ===================================================================
        /**
        *  Получение псевдозаписи файла
        *
        *  @access  public
        *  @param   string  $file   имя файла
        *  @param   object  $data   контент записи (будет помещен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function get_file_record ( $file, & $data = null ) {

            // если имя файла задано
            $file = str_replace('\\', '/', $file);
            $file = ltrim(rtrim($file, "/. \t\r\n"));
            if ($file != '') {

                // читаем файл псевдозаписи (описания) файла
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $file = trim(substr($file, 0, -strlen($ext))) . (($ext != '') ? '' : '.') . FILE_RECORD_FILE_EXTENSION;
                if (file_exists($file)) {
                    $text = @ file_get_contents($file);
                    if ($text === FALSE) $text = '';

                    // извлекаем поля и их содержимое
                    $this->get_record_fields($text, $data);
                }
            }
        }



        // ===================================================================
        /**
        *  Получение псевдозаписи папки
        *
        *  @access  public
        *  @param   string  $path   имя пути
        *  @param   object  $data   контент записи (будет помещен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function get_folder_record ( $path, & $data = null ) {

            // если имя папки задано
            $path = str_replace('\\', '/', $path);
            $path = ltrim(rtrim($path, "/. \t\r\n"));
            if ($path != '') $path .= '/';
            if ($path != '') {

                // читаем файл псевдозаписи (описания) папки
                $path .= FOLDER_RECORD_FILE;
                if (file_exists($path)) {
                    $text = @ file_get_contents($path);
                    if ($text === FALSE) $text = '';

                    // извлекаем поля и их содержимое
                    $this->get_record_fields($text, $data);
                }
            }
        }



    // сохранение псевдозаписи папки ===========================================

    public function write_folder_record ($path, &$data = null) {

      // если имя папки задано
      $result = FALSE;
      $path = trim($path);
      $path = str_replace("\\", "/", $path);
      while (substr($path, -1) == "/") $path = trim(substr($path, 0, -1));
      if ($path != "") $path .= "/";
      if ($path != "") {

        // готовим сохранение файла псевдозаписи (описания) папки
        $path .= FOLDER_RECORD_FILE;
        if (!$handle = @fopen($path, "rb+")) $handle = @fopen($path, "wb");
        if ($handle) {
          flock($handle, LOCK_EX);

          // вставляем поля и их содержимое
          $text = $this->set_record_fields($data);

          // сохраняем файл
          $size = strlen($text);
          fwrite($handle, $text, $size);
          ftruncate($handle, $size);
          fclose($handle);
          $result = TRUE;
        }
      }

      // возвращаем ВЫПОЛНЕНО / НЕТ
      return $result;
    }

    // сохранение псевдозаписи файла ===========================================

    public function write_file_record ($file, &$data = null) {

      // если имя папки задано
      $result = FALSE;
      $file = trim($file);
      $file = str_replace("\\", "/", $file);
      if ($file != "") {

        // готовим сохранение файла псевдозаписи (описания) файла
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $file = trim(substr($file, 0, -strlen($ext))) . (($ext != "") ? "" : ".") . FILE_RECORD_FILE_EXTENSION;
        if (!$handle = @fopen($file, "rb+")) $handle = @fopen($file, "wb");
        if ($handle) {
          flock($handle, LOCK_EX);

          // вставляем поля и их содержимое
          $text = $this->set_record_fields($data);

          // сохраняем файл
          $size = strlen($text);
          fwrite($handle, $text, $size);
          ftruncate($handle, $size);
          fclose($handle);
          $result = TRUE;
        }
      }

      // возвращаем ВЫПОЛНЕНО / НЕТ
      return $result;
    }



    // ===================================================================
    /**
    *  Удаление содержимого папки (сама папка не удаляется)
    *
    *  @access  public
    *  @param   string  $path   путь папки
    *  @return  void
    */
    // ===================================================================

    public function clean_dir ( $path ) {

        // если удалось открыть папку
        $path = trim($path);
        $path = str_replace('\\', '/', $path);
        $path = rtrim($path, "/ \t\r\n");
        $path .= '/';
        if (($handle = @ opendir($path)) !== FALSE) {

            // перебираем имена вложенных элементов
            while (($file = readdir($handle)) !== FALSE) {
                if (trim($file, '.') != '') {
                    $fullpath = $path . $file;

                    // если это папка, удаляем ее содержимое и саму папку
                    if (is_dir($fullpath)) {
                        $this->clean_dir($fullpath);
                        rmdir($fullpath);

                    // иначе это файл, удаляем его
                    } else {
                        unlink($fullpath);
                    }
                }
            }

            // закрываем папку
            closedir($handle);
        }
    }



    // ===================================================================
    /**
    *  Удаление папки (вместе с содержимым)
    *
    *  @access  public
    *  @param   string  $path   путь папки
    *  @return  void
    */
    // ===================================================================

    public function delete_dir ( $path ) {

        $path = trim($path);
        $path = str_replace('\\', '/', $path);
        $path = rtrim($path, "/ \t\r\n");
        $this->clean_dir($path);
        if ($path != '') @ rmdir($path);
    }



    // ===================================================================
    /**
    *  Копирование папки
    *
    *  @access  public
    *  @param   string  $path   путь исходной папки
    *  @param   string  $dest   путь копии
    *  @return  void
    */
    // ===================================================================

    public function copy_dir ( $path, $dest ) {

        // проверяем, что копия не внутри источника
        $path = trim($path);
        $path = str_replace('\\', '/', $path);
        $path = rtrim($path, "/ \t\r\n");
        $path .= '/';

        $dest = trim($dest);
        $dest = str_replace('\\', '/', $dest);
        $dest = rtrim($dest, "/ \t\r\n");
        $dest .= '/';
        if (strtolower(substr($dest, 0, strlen($path))) != strtolower($path)) {

            // если удалось открыть папку
            if (($handle = @ opendir($path)) !== FALSE) {

                // создаем такую же папку в копии
                if (!file_exists($dest) || !is_dir($dest)) mkdir($dest, 0755, TRUE);

                // перебираем имена вложенных элементов
                while (($file = readdir($handle)) !== FALSE) {
                    if (trim($file, '.') != '') {
                        $fullpath = $path . $file;

                        // если это папка, копируем ее
                        if (is_dir($fullpath)) $this->copy_dir($fullpath, $dest . $file);

                        // иначе это файл, копируем его
                        else copy($fullpath, $dest . $file);
                    }
                }

                // закрываем папку
                closedir($handle);
            }
        }
    }



    // вывешивание сообщения о работах по обновлению =========================

    public function putup_UPDATING_WORKS_INFO ($state) {

      // ссылаемся на глобальные переменные
      global $files_host_suffix;

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC putup_UPDATING_WORKS_INFO");

      // если вывеску нужно повесить
      $filename = ROOT_FOLDER_REFERENCE . trim(str_replace("*", $this->hdd->safeFilename($files_host_suffix), UPDATING_WORKS_INFO_FILENAME));
      if ($state) {

        // готовим текст вывески
        $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n"
              . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"ru\">\r\n"
              . "  <head>\r\n"
              . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n"
              . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
              . "    <title>Сейчас на сайте выполняется операция обновления</title>\r\n"
              . "  </head>\r\n"
              . "  <style>\r\n"
              . "    *             {border:           0px solid;\r\n"
              . "                   border-radius:    0px; -moz-border-radius: 0px; -webkit-border-radius: 0px;\r\n"
              . "                   box-shadow:       0px 0px 0px; -moz-box-shadow: 0px 0px 0px; -webkit-box-shadow: 0px 0px 0px;\r\n"
              . "                   font-family:      Verdana, Tahoma, Arial;\r\n"
              . "                   margin:           0px;\r\n"
              . "                   padding:          0px;\r\n"
              . "                   text-align:       left;\r\n"
              . "                   text-indent:      0px;}\r\n"
              . "    div           {background-color: #FFFFFF;\r\n"
              . "                   border:           #C0C0C0 1px solid;\r\n"
              . "                   box-shadow:       #E0E0E0 1px 2px 10px; -moz-box-shadow: #E0E0E0 1px 2px 10px; -webkit-box-shadow: #E0E0E0 1px 2px 10px;\r\n"
              . "                   color:            #000000;\r\n"
              . "                   font-size:        10pt;\r\n"
              . "                   margin:           75px auto;\r\n"
              . "                   padding:          0px;\r\n"
              . "                   width:            350px;}\r\n"
              . "    div div       {background-color: #F0F0F0;\r\n"
              . "                   border:           0px solid;\r\n"
              . "                   box-shadow:       0px 0px 0px; -moz-box-shadow: 0px 0px 0px; -webkit-box-shadow: 0px 0px 0px;\r\n"
              . "                   line-height:      20px;\r\n"
              . "                   margin:           4px;\r\n"
              . "                   padding:          15px;\r\n"
              . "                   width:            auto;}\r\n"
              . "  </style>\r\n"
              . "  <body>\r\n"
              . "    <div>\r\n"
              . "      <div>\r\n"
              . "        <b>Сайт " . (isset($_SERVER["HTTP_HOST"]) ? trim($_SERVER["HTTP_HOST"]) : "") . "</b>\r\n"
              . "        <br><br>\r\n"
              . "        В данный момент на сайте производится операция обновления его содержимого.\r\n"
              . "        Это может длиться некоторое время, после чего доступ на сайт возобновится.\r\n"
              . "        <br><br>\r\n"
              . "        Попробуйте обновить страницу через несколько минут.\r\n"
              . "      </div>\r\n"
              . "    </div>\r\n"
              . "  </body>\r\n"
              . "</html>\r\n";

        // сохраняем вывеску в файл
        if ($handle = @fopen($filename, "wb")) {
          @flock($handle, LOCK_EX);
          @fwrite($handle, $html, strlen($html));
          @fclose($handle);
        }

      // иначе вывеску нужно убрать
      } else {
        if (@file_exists($filename)) @unlink($filename);
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // выправление имени субдомена ===========================================

    public function fix_subdomain ($subdomain) {
      if (function_exists("preg_replace")) {
        $subdomain = preg_replace("/[^a-z0-9\-\.]/i", "", $subdomain);
      } else {
        $subdomain = str_replace("\r", "", $subdomain);
        $subdomain = str_replace("\n", "", $subdomain);
        $subdomain = str_replace("\t", "", $subdomain);
        $subdomain = str_replace(" ", "", $subdomain);
        $subdomain = str_replace("\\", "", $subdomain);
        $subdomain = str_replace("/", "", $subdomain);
        $subdomain = str_replace(":", "", $subdomain);
        $subdomain = str_replace("?", "", $subdomain);
        $subdomain = str_replace("#", "", $subdomain);
      }
      while (strpos($subdomain, "..") !== FALSE) $subdomain = str_replace("..", ".", $subdomain);
      while (substr($subdomain, 0, 1) == ".") $subdomain = substr($subdomain, 1);
      while (substr($subdomain, -1) == ".") $subdomain = substr($subdomain, 0, -1);
      return $subdomain;
    }

    // отправка сообщения по Email ===========================================

    public function email ($to, $subject, $message, $additional_headers = "", $filename = "") {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC email");

      // если в настройках сайта задан емейл для уведомлений
      if (isset($this->settings->notify_from_email) && ($this->settings->notify_from_email != "")) {

        // берем этот емейл
        $from = explode(",", $this->settings->notify_from_email);
        foreach ($from as &$item) {
          $item = trim($item);
          if ($item != "") {
            $from = $item;
            break;
          }
        }

        // если емейл взят успешно
        if (is_string($from)) {

          // формируем заголовок и тему письма
          $name = isset($this->settings->site_name) && ($this->settings->site_name != "") ? "=?utf-8?B?" . base64_encode($this->settings->site_name) . "?= " : "";
          $from = $name . "<" . $from . ">";
          $headers = "MIME-Version: 1.0;\r\n"
                   . "Content-type: text/html; charset=utf-8;\r\n"
                   . "From: " . $from . "\r\n"
                   . $additional_headers;
          $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

          // если указапно имя файла и такой файл удалось открыть
          if ($filename != "") {
            $handle = fopen($filename, "rb");
            if ($handle) {
              $file = fread($handle, filesize($filename));
              fclose($handle);

              // формируем заголовок
              $boundary = "--" . md5(uniqid(time()));
              $headers = "MIME-Version: 1.0\r\n"
                       . "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n"
                       . "From: " . $from . "\r\n";

              // формируем тело письма с вложенным файлом
              $name = basename($filename);
              $message = "--" . $boundary . "\r\n"
                       . "Content-Type: text/html; charset=utf-8\r\n"
                       . "Content-Transfer-Encoding: base64\r\n\r\n"
                       . chunk_split(base64_encode($message)) . "\r\n"
                       . "--" . $boundary . "\r\n"
                       . "Content-Type: application/octet-stream; name=\"" . $name . "\"\r\n"
                       . "Content-Transfer-Encoding: base64\r\n"
                       . "Content-Disposition: attachment; filename=\"" . $name . "\"\r\n\r\n"
                       . chunk_split(base64_encode($file)) . "\r\n"
                       . "--" . $boundary . "--\r\n";
            }
          }

          // отправляем адресатам
          $to = explode(",", $to);
          foreach ($to as &$item) {
            $item = trim($item);
            if ($item != "") @mail($item, $subject, $message, $headers);
          }
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // отправка сообщения по ICQ =============================================

    public function send_icq ($to, $subject) {
    }



    // ===================================================================
    /**
    *  Отправка сообщения через SMS
    *
    *  @access  public
    *  @param   string  $to         номер телефона
    *  @param   string  $subject    текст сообщения
    *  @return  void
    */
    // ===================================================================

    public function send_sms ( $to, $subject ) {

        // открываем трассировку этого метода
        $this->db->open_tracing_method('BASIC send_sms');

        // если не существует объект SMS-шлюзов
        if (!isset($this->sms) || !is_object($this->sms)) {

            // упреждающая подгрузка админ модуля SMS-шлюзов
            impera_ClassRequire('SmsGates', TRUE);

            // создаем объект SMS-шлюзов
            $this->sms = new SmsGates($this);
        }

        // отправляем SMS
        $item = new stdClass;
        $item->phone = $to;
        $item->text = $this->text->stripTags($subject, TRUE);
        $items = array($item);
        $this->sms->send($items);

        // закрываем трассировку этого метода
        $this->db->close_tracing_method();
    }



    // вычисление состояния отложенных товаров ===============================

    public function compute_defer_state (&$count, &$total, &$variants) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC compute_defer_state");

      // инициализируем выходные переменные (число товаров, их сумма, сами товары)
      $count = 0;
      $total = 0;
      $variants = array();

      // если есть отложенные товары
      if (isset($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME]) && is_array($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME])) {

        // перебираем товары
        $subtotal = 0;
        foreach ($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME] as $id => $amount) {

          // читаем данные о товаре
          $params = new stdClass;
          $params->variant_id = $id;
          $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
          if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
          $params->enabled = 1;
          $params->non_usable = 0;
          if (!isset($this->user->user_id)) $params->hidden = 0;
          $params->section = $this->now_in_section;
          $this->db->products->one($product, $params);

          // если товар прочитан
          if (!empty($product)) {

            // находим нужный вариант товара и переставляем его в начало списка
            foreach ($product->variants as $index => $variant) {
              if ($variant->variant_id == $id) {
                unset($product->variants[$index]);
                array_unshift($product->variants, $variant);
                break;
              }
            }

            // если в отложенных не нулевое количество товара
            if ($amount != 0) {

              // если товар есть на складе или разрешена продажа под заказ
              if ($product->variants[0]->stock > 0 || $this->settings->cart_enable_reservation && $product->variants[0]->stock <= 0) {

                // берем фактическую цену товара и цену продажи
                $amount = abs($amount);
                if ($product->variants[0]->stock > 0) $amount = min($product->variants[0]->stock, $amount);
                $sum = abs($product->variants[0]->discount_price);
                $temp_price = $product->variants[0]->temp_price != 0
                              && $product->variants[0]->temp_price_members <= $product->variants[0]->temp_price_invited
                              && ($product->variants[0]->temp_price_start == '0000-00-00 00:00:00' || $this->date->asTimestamp($product->variants[0]->temp_price_start) <= time())
                              && ($product->variants[0]->temp_price_date == '0000-00-00 00:00:00' || $this->date->asTimestamp($product->variants[0]->temp_price_date) >= time())
                              ? $product->variants[0]->temp_price
                              : 0;
                $price = $temp_price != 0 ? $temp_price : $product->variants[0]->price;

                // добавляем количество товаров на выход
                $total += $sum * $amount;
                $count += $amount;

                // обеспечиваем совместимость со старыми шаблонами корзины
                $product->stock = $product->variants[0]->stock;
                $product->discount_price = $product->variants[0]->discount_price;
                $product->price = $price;
                $product->old_price = $product->variants[0]->old_price;
                $product->temp_price = $temp_price;
                $product->name = $product->variants[0]->variant_name;
                $product->variant_id = $product->variants[0]->variant_id;

                // передаем данные о товаре на выход
                $product->amount = $amount;
                $product->name_properties = isset($_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME][$id]) ? trim($_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME][$id]) : "";
                $variants[] = $product;
              }

            }
          }
        }

        // вычисляем окончательную сумму
        $total += $subtotal;
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }



    // =======================================================================
    // Вычислить состояние корзины и вернуть во входные параметры (опциональные взяты в квадратные скобки):
    //   $count = число товаров будет помещено в эту переменную
    //   $total = общая сумма будет помещена в эту переменную
    //   $discount = сумма скидки будет помещена в эту переменную
    //   $variants = массив записей о товарах будет помещен в эту переменную
    //   [$pointers] = массив указателей (идентификатор, выбранные свойства) покупаемых товаров
    // =======================================================================

    public function compute_cart_state ( & $count, & $total, & $discount, & $variants, & $pointers = null ) {

        // открываем трассировку этого метода
        $this->db->open_tracing_method('BASIC compute_cart_state');



        // если в параметрах не задан массив указателей покупаемых товаров, ссылаем его на хранящийся в сеансе
        if (!isset($pointers) && isset($_SESSION)) {
            $pointers = array();
            if (isset($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME])) {
                $pointers[CART_PRODUCTS_SESSION_PARAM_NAME] = & $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME];
            }
            if (isset($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                $pointers[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = & $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME];
            }
        }



        // инициализируем выходные переменные (число товаров в корзине, сумма корзины, сумма скидки, сами товары)
        $count = 0;
        $total = 0;
        $discount = 0;
        $variants = array();



        // если в корзине есть товары
        $result = '';
        if (isset($pointers[CART_PRODUCTS_SESSION_PARAM_NAME]) && is_array($pointers[CART_PRODUCTS_SESSION_PARAM_NAME])) {

            // перебираем товары
            $subtotal = 0;
            foreach ($pointers[CART_PRODUCTS_SESSION_PARAM_NAME] as $id => $amount) {

                // читаем данные о товаре
                $params = new stdClass;
                $params->variant_id = $id;
                $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
                if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
                $params->enabled = 1;
                $params->non_usable = 0;
                if (!isset($this->user->user_id)) $params->hidden = 0;
                $params->section = $this->now_in_section;
                $this->db->products->one($product, $params);



                // если товар прочитан
                if (!empty($product)) {

                    // находим нужный вариант товара и переставляем его в начало списка
                    foreach ($product->variants as $index => $variant) {
                        if ($variant->variant_id == $id) {
                            unset($product->variants[$index]);
                            array_unshift($product->variants, $variant);
                            break;
                        }
                    }



                    // если в корзине не нулевое количество товара
                    if ($amount != 0) {

                        // если товар есть на складе или разрешена продажа под заказ
                        if ($product->variants[0]->stock > 0 || $this->settings->cart_enable_reservation && $product->variants[0]->stock <= 0) {



                            // проверяем достаточно ли товара на складе
                            $amount = abs($amount);
                            if ($product->variants[0]->stock < $amount
                            && ($product->variants[0]->stock > 0 && !$this->settings->orders_deficit_enabled
                            || $product->variants[0]->stock == 0 && !$this->settings->cart_enable_reservation)) {
                                if ($result != '') $result .= '<br><br>';
                                $result .= 'К сожалению, в этот момент на складе осталось '
                                         . $product->variants[0]->stock . ' единиц товара '
                                         . $this->db->get_compound_product_model_text($product)
                                         . ($product->variants[0]->variant_name != $product->model ? ' ' . $product->variants[0]->variant_name : '') . '.';
                            }



                            // берем фактическую цену товара и цену продажи
                            if ($product->variants[0]->stock > 0 && !$this->settings->orders_deficit_enabled) $amount = min($product->variants[0]->stock, $amount);
                            $sum = abs($product->variants[0]->discount_price);
                            $temp_price_later = $product->variants[0]->temp_price != 0
                                                && $product->variants[0]->temp_price_members > $product->variants[0]->temp_price_invited
                                                && ($product->variants[0]->temp_price_start == '0000-00-00 00:00:00' || $this->date->asTimestamp($product->variants[0]->temp_price_start) <= time())
                                                && ($product->variants[0]->temp_price_date == '0000-00-00 00:00:00' || $this->date->asTimestamp($product->variants[0]->temp_price_date) >= time());
                            $temp_price = $product->variants[0]->temp_price != 0
                                          && $product->variants[0]->temp_price_members <= $product->variants[0]->temp_price_invited
                                          && ($product->variants[0]->temp_price_start == '0000-00-00 00:00:00' || $this->date->asTimestamp($product->variants[0]->temp_price_start) <= time())
                                          && ($product->variants[0]->temp_price_date == '0000-00-00 00:00:00' || $this->date->asTimestamp($product->variants[0]->temp_price_date) >= time())
                                          ? $product->variants[0]->temp_price
                                          : 0;
                            $price = $temp_price != 0 ? $temp_price : $product->variants[0]->price;

                            // если наличествует какая-то скидка или товар имеет действующую (сейчас или позже) акционную цену
                            if ($price > $sum || $temp_price != 0 || $temp_price_later) {
                                $subtotal += $sum * $amount;
                                $discount += abs($price - $sum) * $amount;

                            // иначе скидка не замечена
                            } else {

                                // если пользователь принадлежит к какой-то группе
                                if (isset($this->user->group_id) && !empty($this->user->group_id)) {
                                    $subtotal += $sum * $amount;

                                // иначе нет скидки и не принадлежит к группе (придется рассчитать внегрупповую скидку)
                                } else {
                                    $total += $sum * $amount;
                                }
                            }

                            // добавляем количество товаров на выход
                            $count += $amount;

                            // обеспечиваем совместимость со старыми шаблонами корзины
                            $product->sku = $product->variants[0]->sku;
                            $product->stock = $product->variants[0]->stock;
                            $product->discount_price = $product->variants[0]->discount_price;
                            $product->priority_discount = $product->variants[0]->priority_discount;
                            $product->price = $price;
                            $product->old_price = $product->variants[0]->old_price;
                            $product->temp_price = $temp_price;
                            $product->name = $product->variants[0]->variant_name;
                            $product->variant_id = $product->variants[0]->variant_id;

                            // передаем данные о товаре на выход
                            $product->amount = $amount;
                            $product->name_properties = isset($pointers[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME][$id])
                                                        ? trim($pointers[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME][$id])
                                                        : '';
                            $variants[] = $product;
                        }

                    }
                }
            }



            // если нужно рассчитать внегрупповую скидку 
            if ($total > 0) {
                $sum = $this->db->groups->unauthorized_discount($total);
                $total -= $sum;
                if ($total < 0) {
                    $sum += $total;
                    $total = 0;
                }
                $discount += $sum;
            }



            // вычисляем окончательную сумму
            $total += $subtotal;
        }



        // проверяем сумму на минимально допустимую
        $minimal = $this->number->floatValue($this->settings->orders_minimal_sum);
        if ($minimal > $total) {
            if ($result != '') $result .= '<br><br>';
            $result .= 'В нашем магазине установлена минимальная сумма заказа равная ' . round($minimal * $this->currency->rate_from / $this->currency->rate_to, 2) . ' ' . $this->text->escape($this->currency->sign) . '. Заказы менее этой суммы не принимаются.';
        }



        // закрываем трассировку этого метода
        $this->db->close_tracing_method();

        // возвращаем сообщение
        return $result;
    }



    // уведомление с клиентской стороны о заказе =============================

    public function inform_about_order (&$order, $admin_subject, $client_subject, $action = INFORM_ABOUT_ORDER_ACTION_NEW) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC inform_about_order");

      // если данные о заказе существуют
      if (!empty($order)) {

        // путь к шаблонам клиентской стороны и админпанели
        $client_tpl_folder = "design/" . $this->dynamic_theme . "/html/";
        $admin_tpl_folder = $this->hdd->safeFilename($this->admin_folder) . "/design/" . $this->hdd->safeFilename($this->settings->admin_theme) . "/html/";
        $admin_tpl_path = $admin_tpl_folder;

        // уведомляем администратора по емейлу
        $email = isset($this->settings->admin_email) ? trim($this->settings->admin_email) : "";
        if ($email != "") {

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

          // если не находим шаблон в клиентской части, берем из админпанели
          $path = "";
          switch ($action) {
            case INFORM_ABOUT_ORDER_ACTION_PAYMENT:
              $template = EMAIL_ORDER_PAYMENT_TO_ADMIN_TEMPLATE_FILE;
              break;
            case INFORM_ABOUT_ORDER_ACTION_NEW:
            default:
              $template = EMAIL_ORDER_TO_ADMIN_TEMPLATE_FILE;
          }
          if (!file_exists($client_tpl_folder . $template)) {
            $path = $admin_tpl_path;
            if (!file_exists($admin_tpl_folder . $template)) $template = "";
          }

          // получаем тело письма
          if ($template != "") {
            $message = $this->smarty->fetch($path . $template);
          } else {
            $message = $admin_subject;
          }

          // отправляем письмо
          $this->email($email, $admin_subject, $message);
        }

        // уведомляем покупателя по емейлу
        $email = isset($order->email) ? trim($order->email) : "";
        if ($email == "") $email = isset($order->email2) ? trim($order->email2) : "";
        if ($email != "") {

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

          // если не находим шаблон в клиентской части, берем из админпанели
          $path = "";
          switch ($action) {
            case INFORM_ABOUT_ORDER_ACTION_PAYMENT:
              $template = EMAIL_ORDER_PAYMENT_TO_USER_TEMPLATE_FILE;
              break;
            case INFORM_ABOUT_ORDER_ACTION_NEW:
            default:
              $template = EMAIL_ORDER_TO_USER_TEMPLATE_FILE;
          }
          if (!file_exists($client_tpl_folder . $template)) {
            $path = $admin_tpl_path;
            if (!file_exists($admin_tpl_folder . $template)) {
              $template = "";
            } else {
              $this->smarty->assignByRef("this_tpl_path", $path);
            }
          }

          // получаем тело письма
          if ($template != "") {
            $message = $this->smarty->fetch($path . $template);
          } else {
            $message = $client_subject;
          }

          // если в настройках сайта разрешено прикреплять в письмо квитанцию об оплате
          $filename = "";
          if (isset($this->settings->orders_attach_receipt) && ($this->settings->orders_attach_receipt == 1)) {

            // если заказ еще не оплачен
            if ($order->payment_status != 1) {

              // читаем список разрешенных способов оплаты по квитанции через банк
              $query = "SELECT * "
                     . "FROM payment_methods "
                     . "WHERE enabled = 1 "
                           . "AND module = 'receipt' "
                     . "ORDER BY payment_method_id ASC;";
              $this->db->query($query);
              $items = $this->db->results();

              // находим нужный способ оплаты
              foreach ($items as &$item) {
                if ($item->module == "receipt") {

                  // получаем имя временного файла квитанции
                  $filename = ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->admin_folder) . "/temp/receipt_" . $this->hdd->safeFilename($order->order_id);

                  // формируем файл квитанции
                  $prev_POST = $_POST;
                  $_POST = @unserialize($item->params);
                  if ($_POST !== FALSE) {
                    // параметр "сохранить квитанцию в файле"
                    $_POST["output"] = "file";
                    $_POST["receipt_filename"] = $filename;
                    $filename .= ".pdf";
                    $_POST["order_id"] = $order->order_id;
                    if (!isset($_POST["payer_name"]) || (trim($_POST["payer_name"]) == "")) $_POST["payer_name"] = $order->compound_name;
                    if (!isset($_POST["payer_address"]) || (trim($_POST["payer_address"]) == "")) {
                      $_POST["payer_address"] = ($order->compound_address != "") ? $order->compound_address : $order->compound_address2;
                    }
                    $_POST["amount"] = round($order->total_amount * $this->currency->rate_from / $this->currency->rate_to, 2);
                    include(ROOT_FOLDER_REFERENCE . "connectors/receipt.php");
                  } else {
                    $filename = "";
                  }
                  $_POST = $prev_POST;
                  break;
                }
              }
            }
          }

          // отправляем письмо
          $this->email($email, $client_subject, $message, "", $filename);
        }

        // уведомляем администратора через SMS
        $phone = ADMIN_PHONE_PSEUDONYM;
        if ($phone != "") {

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

          // если не находим шаблон в клиентской части, берем из админпанели
          $path = "";
          switch ($action) {
            case INFORM_ABOUT_ORDER_ACTION_PAYMENT:
              $template = SMS_ORDER_PAYMENT_TO_ADMIN_TEMPLATE_FILE;
              break;
            case INFORM_ABOUT_ORDER_ACTION_NEW:
            default:
              $template = SMS_ORDER_TO_ADMIN_TEMPLATE_FILE;
          }
          if (!file_exists($client_tpl_folder . $template)) {
            $path = $admin_tpl_path;
            if (!file_exists($admin_tpl_folder . $template)) $template = "";
          }

          // получаем тело SMS
          if ($template != "") {
            $message = $this->smarty->fetch($path . $template);
          } else {
            $message = $admin_subject;
          }

          // отправляем SMS
          $this->send_sms($phone, $message);
        }

        // уведомляем покупателя через SMS
        $phone = isset($order->phone) ? trim($order->phone) : "";
        if ($phone == "") $phone = isset($order->phone2) ? trim($order->phone2) : "";
        if ($phone != "") {

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

          // если не находим шаблон в клиентской части, берем из админпанели
          $path = "";
          switch ($action) {
            case INFORM_ABOUT_ORDER_ACTION_PAYMENT:
              $template = SMS_ORDER_PAYMENT_TO_USER_TEMPLATE_FILE;
              break;
            case INFORM_ABOUT_ORDER_ACTION_NEW:
            default:
              $template = SMS_ORDER_TO_USER_TEMPLATE_FILE;
          }
          if (!file_exists($client_tpl_folder . $template)) {
            $path = $admin_tpl_path;
            if (!file_exists($admin_tpl_folder . $template)) $template = "";
          }

          // получаем тело SMS
          if ($template != "") {
            $message = $this->smarty->fetch($path . $template);
          } else {
            $message = $client_subject;
          }

          // отправляем SMS
          $this->send_sms($phone, $message);
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }



    // ===================================================================
    /**
    *  Рассылка уведомлений с клиентской стороны
    *
    *  @access  public
    *  @param   array   $recipients     массив рассылки, каждый элемент - это объект:
    *                                       ->recipient - получатель
    *                                       ->template - имя файла шаблона (опционально)
    *                                       ->subject - тема
    *  @param   boolean $as_sms         признак "SMS-рассылка" (не емейл)
    *  @return  void
    */
    // ===================================================================

    public function inform_recipients ( & $recipients, $as_sms = FALSE ) {

        // путь к шаблону клиентской стороны (используется только для поиска)
        $client_path = 'design/' . $this->dynamic_theme . '/html/';



        // путь к шаблону админпанели (используется для поиска и шаблонизатора)
        $admin_path = $this->hdd->safeFilename($this->admin_folder)
                    . '/design/'
                    . $this->hdd->safeFilename($this->settings->admin_theme)
                    . '/html/';



        // перебираем записи рассылки с указанным получателем и темой
        if (is_array($recipients) && !empty($recipients)) {
            foreach ($recipients as $item) {
                if (isset($item->recipient) && isset($item->subject)) {

                    $item->recipient = trim($item->recipient);
                    $item->subject = trim($item->subject);
                    if (($item->recipient != '') && ($item->subject != '')) {



                        // информация шаблонизатору (мы сейчас на клиентской стороне)
                        $path = '';



                        // задано ли имя файла шаблона?
                        $ok = FALSE;
                        $template = isset($item->template) ? $this->hdd->safeFilename($item->template) : '';
                        if ($template != '') {



                            // если такого файла нет в шаблоне клиентской части
                            $ok = TRUE;
                            if (!file_exists($client_path . $template)) {



                                // информация шаблонизатору (сместиться в шаблон админпанели)
                                $path = $admin_path;



                                // есть ли такой файл в шаблоне админпанели?
                                $ok = file_exists($path . $template);
                            }
                        }



                        // получаем тело письма
                        if ($ok) {
                            $message = $this->smarty->fetch($path . $template);
                        } else {
                            $message = $item->subject;
                            if (!$as_sms && ($template != '')) {
                                $message .= '<br><br>'
                                          . '<div style="background: #eee; border: #ddd; 1px solid; color: #888; font-size: 8pt; margin: 10px; padding: 10px;">'
                                              . 'В шаблоне клиентской стороны сайта или же вместо него '
                                              . 'в шаблоне админпанели не был найден макет уведомления '
                                              . '(файл ' . htmlspecialchars($template, ENT_NOQUOTES) . ') '
                                              . 'для данного случая. Поэтому в теле письма просто была '
                                              . 'продублирована тема и добавлена эта заметка.'
                                          . '</div>';
                            }
                        }



                        // отправляем уведомление
                        if ($as_sms) {
                            $this->send_sms($item->recipient, $message);
                        } else {
                            $this->email($item->recipient, $item->subject, $message);
                        }
                    }
                }
            }
        }
    }



    // ===================================================================
    /**
    *  Уведомление с клиентской стороны об активности по купону
    *
    *  @access  public
    *  @param   object  $coupon                 запись о купоне
    *  @param   object  $item                   запись о предмете (пользователе или заказе)
    *  @param   string  $subject                тема уведомления
    *  @param   boolean $for_admin_email        TRUE если отправить админу по емейл
    *  @param   boolean $for_admin_sms          TRUE если отправить админу по СМС
    *  @param   boolean $for_affiliate_email    TRUE если отправить партнеру по емейл
    *  @param   boolean $for_affiliate_sms      TRUE если отправить партнеру по СМС
    *  @return  void
    */
    // ===================================================================

    public function inform_about_coupon ( & $coupon,
                                          & $item,
                                          $subject,
                                          $for_admin_email = FALSE,
                                          $for_admin_sms = FALSE,
                                          $for_affiliate_email = FALSE,
                                          $for_affiliate_sms = FALSE ) {

        // открываем трассировку этого метода
        $this->db->open_tracing_method('BASIC inform_about_coupon');



        // если существуют данные о купоне
        if (is_object($coupon) && !empty($coupon)) {



            // передаем данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $coupon);
            $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST_OBJECT, $item);



            // готовим список рассылки
            $recipients = array();

                // емейл распространителя купона или партнера
                if ($for_affiliate_email) {
                    $data = new stdClass;
                    $data->template = EMAIL_COUPON_ACTIVITY_TEMPLATE_FILE;
                    $data->subject = $subject;
                    $data->recipient = isset($coupon->email) ? trim($coupon->email) : '';
                    $data->recipient = ($data->recipient == '') && isset($coupon->affiliate_email) ? trim($coupon->affiliate_email) : $data->recipient;
                    $recipients[] = $data;
                }

                // емейл администратора
                if ($for_admin_email) {
                    $data = new stdClass;
                    $data->template = EMAIL_COUPON_ACTIVITY_TEMPLATE_FILE;
                    $data->subject = $subject;
                    $data->recipient = isset($this->settings->admin_email) ? trim($this->settings->admin_email) : '';
                    $recipients[] = $data;
                }

            // отправляем письма
            $this->inform_recipients($recipients, FALSE);



            // готовим список рассылки
            $recipients = array();

                // телефон распространителя купона или партнера
                if ($for_affiliate_sms) {
                    $data = new stdClass;
                    $data->template = SMS_COUPON_ACTIVITY_TEMPLATE_FILE;
                    $data->subject = $subject;
                    $data->recipient = isset($coupon->phone) ? trim($coupon->phone) : '';
                    $data->recipient = ($data->recipient == '') && isset($coupon->affiliate_phone) ? trim($coupon->affiliate_phone) : $data->recipient;
                    $recipients[] = $data;
                }

                // телефон администратора
                if ($for_admin_sms) {
                    $data = new stdClass;
                    $data->template = SMS_COUPON_ACTIVITY_TEMPLATE_FILE;
                    $data->subject = $subject;
                    $data->recipient = ADMIN_PHONE_PSEUDONYM;
                    $recipients[] = $data;
                }

            // отправляем SMS
            $this->inform_recipients($recipients, TRUE);
        }



        // закрываем трассировку этого метода
        $this->db->close_tracing_method();
    }



    // уведомление о появлении товара на складе ==============================

    public function inform_about_product_exist ($notify, $product, $client_subject) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC inform_about_product_exist");

      // если данные о подписке на уведомление существуют и есть данные о товаре
      $result = FALSE;
      if (!empty($notify) && !empty($product)) {

        // путь к шаблонам клиентской стороны и админпанели
        $client_tpl_folder = "design/" . $this->dynamic_theme . "/html/";
        $admin_tpl_folder = $this->hdd->safeFilename($this->admin_folder) . "/design/" . $this->hdd->safeFilename($this->settings->admin_theme) . "/html/";
        $admin_tpl_path = $admin_tpl_folder;

        // уведомляем пользователя по емейлу
        $email = isset($notify->email) ? trim($notify->email) : "";
        if ($email != "") {

          // если не находим шаблон в клиентской части, пробуем найти в админпанели
          $path = "";
          $template = EMAIL_PRODUCT_EXIST_TO_USER_TEMPLATE_FILE;
          if (!file_exists($client_tpl_folder . $template)) {
            $path = $admin_tpl_path;
            if (!file_exists($admin_tpl_folder . $template)) $template = "";
          }

          // если шаблон найден
          if ($template != "") {

            // передаем данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $notify);
            $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST_OBJECT, $product);
          
            // получаем тело письма
            $message = $this->smarty->fetch($path . $template);

          // иначе в тело письма дублируем тему
          } else {
            $message = $client_subject;
          }

          // отправляем письмо
          $this->email($email, $client_subject, $message);

          // признак ВЫПОЛНЕНО
          $result = TRUE;
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();

      // возвращаем ВЫПОЛНЕНО / НЕ ВЫПОЛНЕНО
      return $result;
    }

    // уведомление о изменении цены товара ===================================

    public function inform_about_product_reprice ($notify, $product, $client_subject) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC inform_about_product_reprice");

      // если данные о подписке на уведомление существуют и есть данные о товаре
      $result = FALSE;
      if (!empty($notify) && !empty($product)) {

        // путь к шаблонам клиентской стороны и админпанели
        $client_tpl_folder = "design/" . $this->dynamic_theme . "/html/";
        $admin_tpl_folder = $this->hdd->safeFilename($this->admin_folder) . "/design/" . $this->hdd->safeFilename($this->settings->admin_theme) . "/html/";
        $admin_tpl_path = $admin_tpl_folder;

        // уведомляем пользователя по емейлу
        $email = isset($notify->email) ? trim($notify->email) : "";
        if ($email != "") {

          // если не находим шаблон в клиентской части, пробуем найти в админпанели
          $path = "";
          $template = EMAIL_PRODUCT_REPRICE_TO_USER_TEMPLATE_FILE;
          if (!file_exists($client_tpl_folder . $template)) {
            $path = $admin_tpl_path;
            if (!file_exists($admin_tpl_folder . $template)) $template = "";
          }

          // если шаблон найден
          if ($template != "") {

            // передаем данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $notify);
            $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST_OBJECT, $product);
          
            // получаем тело письма
            $message = $this->smarty->fetch($path . $template);

          // иначе в тело письма дублируем тему
          } else {
            $message = $client_subject;
          }

          // отправляем письмо
          $this->email($email, $client_subject, $message);

          // признак ВЫПОЛНЕНО
          $result = TRUE;
        }
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();

      // возвращаем ВЫПОЛНЕНО / НЕ ВЫПОЛНЕНО
      return $result;
    }

    // установка имени файла фонового звука УСПЕХ страницы ===================

    public function success_bgsound ($url = "") {
      $url = trim($url);
      $this->bgsound = ($url != "") ? $url : "http://" . $this->root_url . "/sounds/success.wav";
    }



    // извлечение значения параметра запроса =================================

    public function param ($request_name = "", $session_name = "", $cookie_name = "") {

      // если параметр есть в виртуальной области запроса, возвращаем
      $request_name = trim($request_name);
      if ($request_name != "") {
        if (isset($this->params[$request_name])) return $this->params[$request_name];

        // если параметр есть в самом запросе, возвращаем
        if (isset($_GET[$request_name])) return $_GET[$request_name];
        if (isset($_POST[$request_name])) return $_POST[$request_name];
      }

      // если просили проверить сеанс и параметр там есть, возвращаем
      $session_name = trim($session_name);
      if (($session_name != "") && isset($_SESSION[$session_name])) return $_SESSION[$session_name];

      // если просили проверить куки и параметр там есть, возвращаем
      $cookie_name = trim($cookie_name);
      if (($cookie_name != "") && isset($_COOKIE[$cookie_name])) return $_COOKIE[$cookie_name];

      // иначе возвращаем NULL
      return null;
    }

    // виртуальное добавление параметра запроса ==============================

    public function add_param ($request_name = '', $value = null, $session_name = '', $cookie_name = '') {

      // если параметр есть во входном $value или запросе, копируем в виртуальную область
      $request_name = trim($request_name);
      if ($request_name != "") {
        if (!is_null($value)) $this->params[$request_name] = $value;
        elseif (isset($_GET[$request_name])) $this->params[$request_name] = $_GET[$request_name];
        elseif (isset($_POST[$request_name])) $this->params[$request_name] = $_POST[$request_name];
        elseif (isset($_REQUEST[$request_name])) $this->params[$request_name] = $_REQUEST[$request_name];
      }

      // если просили добавить в сеанс и параметр есть во входном $value
      $session_name = trim($session_name);
      if (($session_name != "") && !is_null($value)) $_SESSION[$session_name] = $value;

      // если просили добавить в куки и параметр есть во входном $value
      $cookie_name = trim($cookie_name);
      if (($cookie_name != "") && !is_null($value)) {

        // если поддерживается функция передачи куков
        if (function_exists("setcookie")) {
          $time = time();
          $year_lifetime = 365 * 24 * SECONDS_IN_HOUR;

          // добавляем параметр в куки браузера
          switch (strtolower(gettype($value))) {
            case "object":
            case "array":
              foreach ($value as $key => $item) {
                $key = str_replace("[", "_", str_replace("]", "_", $key));
                switch (strtolower(gettype($item))) {
                  case "object":
                  case "array":
                    break;
                  case "boolean":
                    setcookie($cookie_name . "[" . $key . "]", ($item ? 1 : 0), $time + $year_lifetime, "/");
                    break;
                  case "float":
                  case "double":
                    setcookie($cookie_name . "[" . $key . "]", str_replace(",", ".", $item), $time + $year_lifetime, "/");
                    break;
                  case "integer":
                  case "string":
                    setcookie($cookie_name . "[" . $key . "]", $item, $time + $year_lifetime, "/");
                    break;
                  case "resource":
                  case "null":
                  case "user function":
                  case "unknown type":
                    break;
                  default:
                }
              }
              break;
            case "boolean":
              setcookie($cookie_name, ($value ? 1 : 0), $time + $year_lifetime, "/");
              break;
            case "float":
            case "double":
              setcookie($cookie_name, str_replace(",", ".", $value), $time + $year_lifetime, "/");
              break;
            case "integer":
            case "string":
              setcookie($cookie_name, $value, $time + $year_lifetime, "/");
              break;
            case "resource":
            case "null":
            case "user function":
            case "unknown type":
              break;
            default:
          }
        }

        // добавляем параметр в куки сервера
        $_COOKIE[$cookie_name] = $value;
      }
    }

    // уничтожение параметра запроса =========================================

    protected function destroy_param ($request_name = "", $session_name = "", $cookie_name = "") {

      // если параметр есть в виртуальной области запроса, уничтожаем
      $request_name = trim($request_name);
      if ($request_name != "") {
        if (isset($this->params[$request_name])) unset($this->params[$request_name]);

        // если параметр есть в самом запросе, уничтожаем
        if (isset($_GET[$request_name])) unset($_GET[$request_name]);
        if (isset($_POST[$request_name])) unset($_POST[$request_name]);
        if (isset($_REQUEST[$request_name])) unset($_REQUEST[$request_name]);
      }

      // если просили уничтожить в сеансе и параметр там есть, уничтожаем
      $session_name = trim($session_name);
      if (($session_name != "") && isset($_SESSION[$session_name])) unset($_SESSION[$session_name]);

      // если просили уничтожить в куках
      $cookie_name = trim($cookie_name);
      if ($cookie_name != "") {

        // если поддерживается функция передачи куков
        if (function_exists("setcookie")) {
          $time = time();
          $year_lifetime = 365 * 24 * SECONDS_IN_HOUR;

          // уничтожаем параметр в куках браузера
          if (isset($_COOKIE[$cookie_name])) {
            switch (strtolower(gettype($_COOKIE[$cookie_name]))) {
              case "object":
              case "array":
                foreach ($_COOKIE[$cookie_name] as $key => $item) {
                  $key = str_replace("[", "_", str_replace("]", "_", $key));
                  setcookie($cookie_name . "[" . $key . "]", "", $time - $year_lifetime, "/");
                }
                setcookie($cookie_name, "", $time - $year_lifetime, "/");
                break;
              case "boolean":
              case "float":
              case "double":
              case "integer":
              case "string":
              case "resource":
              case "null":
              case "user function":
              case "unknown type":
              default:
                setcookie($cookie_name, "", $time - $year_lifetime, "/");
            }
          }
        }

        // уничтожаем параметр в куках сервера
        if (isset($_COOKIE[$cookie_name])) unset($_COOKIE[$cookie_name]);
      }
    }



    // ===================================================================
    /**
    *  Добавление текста ошибки в общее сообщение об ошибке
    *
    *  @access  protected
    *  @param   string  $text     текст ошибки
    *  @param   string  $divider  разделитель сообщений
    *  @return  boolean           всегда TRUE (псевдо сигнализатор ошибки)
    */
    // ===================================================================

    protected function push_error ( $text, $divider = '<br><br>' ) {
        if ($this->error_msg != '') $this->error_msg .= $divider;
        $this->error_msg .= trim($text);
        return TRUE;
    }



    // ===================================================================
    /**
    *  Добавление текста в общее информационное сообщение
    *
    *  @access  protected
    *  @param   string  $text     текст
    *  @param   string  $divider  разделитель сообщений
    *  @return  boolean           всегда TRUE (псевдо сигнализатор сообщения)
    */
    // ===================================================================

    protected function push_info ( $text, $divider = '<br><br>' ) {
        if ($this->info_msg != '') $this->info_msg .= $divider;
        $this->info_msg .= trim($text);
        return TRUE;
    }







    // обработка команды ACTION_REQUEST_PARAM_VALUE_DELETE ===================

    protected function action_delete ($id, &$query, $ban_ip = "", $ban_reason = "") {
      $query[] = "DELETE FROM " . $this->dbtable . " "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
               . "LIMIT 1;";

      // если указано сделать блокировку IP-адреса (поместить в запреты доступа)
      $ban_ip = trim($ban_ip);
      if ($ban_ip != "") {

        // ищем есть ли уже такая блокировка
        $params = new stdClass;
        $params->ip = $ban_ip;
        $this->db->get_banned($item, $params);

        // если нет или блокировка была отключена, добавляем или включаем
        if (empty($item) || ($item->enabled != 1) || ($item->no_access != 1) || ($item->no_register != 1)
        || ($item->no_comment != 1) || ($item->no_callme != 1) || ($item->no_admin != 1)
        || ($item->begin_date != "0000-00-00 00:00:00") || ($item->end_date != "0000-00-00 00:00:00")) {
          $ban_reason = trim($ban_reason);
          if (empty($item)) {
            $item = new stdClass;
            $item->ip = $ban_ip;
            $item->remark = $ban_reason;
            $item->created = time();
          } else {
            $item->begin_date = "";
            $item->end_date = "";
            if ($ban_reason != "") $item->remark = $ban_reason;
            $item->modified = time();
          }
          $item->no_access = 1;
          $item->no_register = 1;
          $item->no_comment = 1;
          $item->no_callme = 1;
          $item->no_admin = 1;
          $item->enabled = 1;
          $this->db->update_banned($item);
        }
      }
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_ENABLED ==================

    protected function action_enabled ($id, &$query) {
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET enabled = 1 - enabled "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_HIGHLIGHTED ==============

    protected function action_highlighted ($id, &$query) {
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET highlighted = 1 - highlighted "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_HIDDEN ===================

    protected function action_hidden ($id, &$query) {
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET hidden = 1 - hidden "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_COMMENTED ================

    protected function action_commented ($id, &$query) {
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET commented = 1 - commented "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_DOMAINED =================

    protected function action_domained ($id, &$query) {
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET subdomain_enabled = 1 - subdomain_enabled "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_MOVEUP ===================

    protected function action_move_up ( $id, & $query, $branch_field = '', $order_num_suffix = '' ) {

        // если задан суффикс порядкового поля, берем его как имя типового поля записи
        $type_field = $order_num_suffix;

        // если суффикс задан, его будем крепить к имени порядкового поля через подчеркивание
        if (!empty($order_num_suffix)) $order_num_suffix = '_' . $order_num_suffix;

        // корректируем в таблице незаполненные порядковые поля
        $query[] = 'UPDATE `' . $this->dbtable . '` '
                 . 'SET `order_num' . $order_num_suffix . '` = `' . $this->dbtable_field . '` '
                 . 'WHERE `order_num' . $order_num_suffix . '` IS NULL OR `order_num' . $order_num_suffix . '` <= 0;';

        // ищем в ветви или без ее учета (если не задано ее контрольное поле) первую вышестоящую запись (непременно такого же значения в типовом поле)
        $query[] = 'SELECT @id := `s1`.`' . $this->dbtable_field . '` '
                 . 'FROM `' . $this->dbtable . '` `s1`, '
                      . '`' . $this->dbtable . '` `s2` '
                 . 'WHERE '
                       . (!empty($branch_field) ? '`s1`.`' . $branch_field . '` = `s2`.`' . $branch_field . '` AND ' : '')
                       . (!empty($type_field) ? '`s1`.`' . $type_field . '` = `s2`.`' . $type_field . '` AND ' : '')
                       . '`s1`.`order_num' . $order_num_suffix . '` > `s2`.`order_num' . $order_num_suffix . '` '
                       . 'AND `s2`.`' . $this->dbtable_field . '` = "' . $this->db->query_value($id) . '" '
                 . 'ORDER BY `s1`.`order_num' . $order_num_suffix . '` ASC '
                 . 'LIMIT 1;';

      // меняем местами содержимое порядковых полей текущей и найденной записей
      $query[] = 'UPDATE `' . $this->dbtable . '` `s1`, '
                      . '`' . $this->dbtable . '` `s2` '
               . 'SET `s1`.`order_num' . $order_num_suffix . '` = CASE WHEN @id IS NULL '
                                                                    . 'THEN `s1`.`order_num' . $order_num_suffix . '` '
                                                                    . 'ELSE (@a := `s1`.`order_num' . $order_num_suffix . '`) * 0 + `s2`.`order_num' . $order_num_suffix . '` END, '
                   . '`s2`.`order_num' . $order_num_suffix . '` = CASE WHEN @id IS NULL '
                                                                    . 'THEN `s2`.`order_num' . $order_num_suffix . '` '
                                                                    . 'ELSE @a END '
               . 'WHERE `s1`.`' . $this->dbtable_field . '` = "' . $this->db->query_value($id) . '" '
                     . 'AND `s2`.`' . $this->dbtable_field . '` = @id;';
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_MOVEDOWN =================

    protected function action_move_down ($id, &$query, $branch_field = "", $order_num_suffix = "") {

      // если задан суффикс порядкового поля, берем его как имя типового поля записи
      $type_field = $order_num_suffix;

      // если суффикс задан, его будем крепить к имени порядкового поля через подчеркивание
      if (!empty($order_num_suffix)) $order_num_suffix = "_" . $order_num_suffix;

      // корректируем в таблице незаполненные порядковые поля
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET order_num" . $order_num_suffix . " = " . $this->dbtable_field . " "
               . "WHERE order_num" . $order_num_suffix . " IS NULL OR order_num" . $order_num_suffix . " <= 0;";

      // ищем в ветви или без ее учета (если не задано ее контрольное поле) первую нижестоящую запись (непременно такого же значения в типовом поле)
      $query[] = "SELECT @id := s1." . $this->dbtable_field . " "
               . "FROM " . $this->dbtable . " s1, "
                    . $this->dbtable . " s2 "
               . "WHERE "
                     . (!empty($branch_field) ? "s1." . $branch_field . " = s2." . $branch_field . " AND " : "")
                     . (!empty($type_field) ? "s1." . $type_field . " = s2." . $type_field . " AND " : "")
                     . "s1.order_num" . $order_num_suffix . " < s2.order_num" . $order_num_suffix . " "
                     . "AND s2." . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
               . "ORDER BY s1.order_num" . $order_num_suffix . " DESC "
               . "LIMIT 1;";

      // меняем местами содержимое порядковых полей текущей и найденной записей
      $query[] = "UPDATE " . $this->dbtable . " s1, "
                      . $this->dbtable . " s2 "
               . "SET s1.order_num" . $order_num_suffix . " = CASE WHEN @id IS NULL THEN s1.order_num" . $order_num_suffix . " ELSE (@a := s1.order_num" . $order_num_suffix . ") * 0 + s2.order_num" . $order_num_suffix . " END, "
                   . "s2.order_num" . $order_num_suffix . " = CASE WHEN @id IS NULL THEN s2.order_num" . $order_num_suffix . " ELSE @a END "
               . "WHERE s1." . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
                     . "AND s2." . $this->dbtable_field . " = @id;";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_MOVEFIRST ================

    protected function action_move_first ($id, &$query, $branch_field = "", $order_num_suffix = "") {

      // если задан суффикс порядкового поля, берем его как имя типового поля записи
      $type_field = $order_num_suffix;

      // если суффикс задан, его будем крепить к имени порядкового поля через подчеркивание
      if (!empty($order_num_suffix)) $order_num_suffix = "_" . $order_num_suffix;

      // корректируем в таблице незаполненные порядковые поля
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET order_num" . $order_num_suffix . " = " . $this->dbtable_field . " "
               . "WHERE order_num" . $order_num_suffix . " IS NULL OR order_num" . $order_num_suffix . " <= 0;";

      // ищем в ветви или без ее учета (если не задано ее контрольное поле) наиболее вышестоящую запись (непременно такого же значения в типовом поле)
      $query[] = "SELECT @num := s1.order_num" . $order_num_suffix . " "
               . "FROM " . $this->dbtable . " s1, "
                    . $this->dbtable . " s2 "
               . "WHERE "
                     . (!empty($branch_field) ? "s1." . $branch_field . " = s2." . $branch_field . " AND " : "")
                     . (!empty($type_field) ? "s1." . $type_field . " = s2." . $type_field . " AND " : "")
                     . "s1.order_num" . $order_num_suffix . " >= s2.order_num" . $order_num_suffix . " "
                     . "AND s2." . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
                     . "AND s1." . $this->dbtable_field . " != s2." . $this->dbtable_field . " "
               . "ORDER BY s1.order_num" . $order_num_suffix . " DESC "
               . "LIMIT 1;";

      // делаем содержимое порядкового поля текущей записи более поля найденной записи
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET order_num" . $order_num_suffix . " = CASE WHEN @num IS NULL THEN order_num" . $order_num_suffix . " ELSE @num + 1 END "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_MOVELAST =================

    protected function action_move_last ($id, &$query, $branch_field = "", $order_num_suffix = "") {

      // если задан суффикс порядкового поля, берем его как имя типового поля записи
      $type_field = $order_num_suffix;

      // если суффикс задан, его будем крепить к имени порядкового поля через подчеркивание
      if (!empty($order_num_suffix)) $order_num_suffix = "_" . $order_num_suffix;

      // корректируем в таблице незаполненные порядковые поля
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET order_num" . $order_num_suffix . " = " . $this->dbtable_field . " "
               . "WHERE order_num" . $order_num_suffix . " IS NULL OR order_num" . $order_num_suffix . " <= 0;";

      // ищем в ветви или без ее учета (если не задано ее контрольное поле) наиболее нижестоящую запись (непременно такого же значения в типовом поле)
      $query[] = "SELECT "
                      . (!empty($branch_field) ? "@branch := s2." . $branch_field . ", " : "")
                      . (!empty($type_field) ? "@type := s2." . $type_field . ", " : "")
                      . "@num1 := s1.order_num" . $order_num_suffix . ", "
                      . "@num2 := s2.order_num" . $order_num_suffix . " "
               . "FROM " . $this->dbtable . " s1, "
                    . $this->dbtable . " s2 "
               . "WHERE "
                     . (!empty($branch_field) ? "s1." . $branch_field . " = s2." . $branch_field . " AND " : "")
                     . (!empty($type_field) ? "s1." . $type_field . " = s2." . $type_field . " AND " : "")
                     . "s1.order_num" . $order_num_suffix . " <= s2.order_num" . $order_num_suffix . " "
                     . "AND s1." . $this->dbtable_field . " != s2." . $this->dbtable_field . " "
                     . "AND s2." . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
               . "ORDER BY s1.order_num" . $order_num_suffix . " ASC "
               . "LIMIT 1;";

      // инкрементируем содержимое порядковых полей всех нижестоящих записей вплоть до найденной
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET order_num" . $order_num_suffix . " = CASE WHEN @num1 IS NULL THEN order_num" . $order_num_suffix . " ELSE order_num" . $order_num_suffix . " + 1 END "
               . "WHERE "
                     . (!empty($branch_field) ? $branch_field . " = @branch AND " : "")
                     . (!empty($type_field) ? $type_field . " = @type AND " : "")
                     . "order_num" . $order_num_suffix . " <= @num2 "
                     . "AND " . $this->dbtable_field . " != '" . $this->db->query_value($id) . "';";

      // делаем содержимое порядкового поля текущей записи равным бывшему полю найденной записи
      $query[] = "UPDATE " . $this->dbtable . " "
               . "SET order_num" . $order_num_suffix . " = CASE WHEN @num1 IS NULL THEN order_num" . $order_num_suffix . " ELSE @num1 END "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE ==============

    protected function action_delete_image ($id, &$query) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC action_delete_image");

      // выясняем, имеет ли запись поле image из старого формата
      $old_field = FALSE;
      switch ($this->dbtable) {
        case DATABASE_BRANDS_TABLENAME:
        case DATABASE_CATEGORIES_TABLENAME:
        case "stocks":
          $old_field = TRUE;
          break;
      }

      // делаем запрос - есть ли у записи поля изображения (запись может иметь поле image из старого формата)
      $this->db->query("SELECT " . ($old_field ? "image, " : "")
                            . "images, "
                            . "images_alts, "
                            . "images_texts, "
                            . "images_view "
                     . "FROM " . $this->dbtable . " "
                     . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
                     . "LIMIT 1;");
      $item = $this->db->result();

      // если поля найдены
      if (!empty($item)) {

        // выправляем (fix) поля до состояния массива
        switch ($this->dbtable) {
          case 'articles':
            $this->db->fix_articles_record_images($item);
            break;
          case 'brands':
            $this->db->fix_brands_record_images($item);
            break;
          case 'categories':
            $this->db->fix_categories_record_images($item);
            break;
          case 'countries':
            $this->db->countries->unpackImages($item);
            break;
          case 'news':
            $this->db->news->unpackImages($item);
            break;
          case 'products':
            $this->db->products->unpack_images($item);
            break;
          case 'regions':
            $this->db->fix_regions_record_images($item);
            break;
          case 'schools':
            $this->db->fix_schools_record_images($item);
            break;
          case 'sections':
            $this->db->sections->unpackImages($item);
            break;
          case 'stocks':
            $this->db->stocks->unpackImages($item);
            break;
          case 'towns':
            $this->db->fix_towns_record_images($item);
            break;
        }

        // читаем входной параметр IMAGENUMBER - номер удаляемого изображения (если равен *, значит все),
        // сбрасываем признак $start (пока ни одного удаления не было)
        $selected = trim($this->param(ACTION_REQUEST_PARAM_NAME_IMAGENUMBER));
        $start = FALSE;

        // если номер удаляемого изображения не задан, но есть пометки удаляемых
        if ($selected == "") {
          if (isset($_POST["imagedelete"][$id]) && is_array($_POST["imagedelete"][$id])) {
            $selected = array();
            foreach ($_POST["imagedelete"][$id] as $index => $value) {
              if ($value == 1) $selected[] = $index;
            }
          }
        }

        // в цикле удаляем файлы заказанных изображений и связанные с ними элементы массива
        $number = 1;
        if (isset($item->images) && !empty($item->images)) {
          foreach ($item->images as $index => &$image) {
            if ((is_string($selected) && (($selected == "*") || ($selected == $number)))
            || (is_array($selected) && in_array($number, $selected))) {

              // если имя файла изображения задано
              if (trim($image) != "") {

                // делаем запрос - есть ли другая запись с таким изображением
                $this->db->query("SELECT " . ($old_field ? "image, " : "")
                                      . "images "
                               . "FROM " . $this->dbtable . " "
                               . "WHERE " . $this->dbtable_field . " != '" . $this->db->query_value($id) . "' "
                                     . "AND (LOCATE('" . $this->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER . trim($image) . IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . "', CONCAT('" . $this->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . "', TRIM(images), '" . $this->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . "')) != 0 " . ($old_field ? " OR TRIM(image) = '" . $this->db->query_value(trim($image)) . "'" : "") . ") "
                               . "LIMIT 1;");
                $row = $this->db->result();

                // если такое изображение нигде больше не используется, удаляем его файлы
                if (empty($row)) {
                  $file = ROOT_FOLDER_REFERENCE . $this->upload_folder . $image;
                  if (@is_file($file)) unlink($file);
                  if (isset($item->images_thumbs[$index])) {
                    $file = ROOT_FOLDER_REFERENCE . $this->upload_folder . $item->images_thumbs[$index];
                    if (@is_file($file)) unlink($file);
                  }
                }
              }

              // нужно однозначно убрать это изображение из пришедших от html-формы параметров, чтобы позже в обработках не принять его как существующее
              $start = TRUE;
              unset($item->images[$index]);
              unset($_POST["image"][$id][$index + 1]);
            }
            $number++;
          }
        }

        // аналогично удаляем элементы массива с alt-ами заказанных изображений
        $number = 1;
        if (isset($item->images_alts) && !empty($item->images_alts)) {
          foreach ($item->images_alts as $index => &$image_alt) {
            if ((is_string($selected) && (($selected == "*") || ($selected == $number)))
            || (is_array($selected) && in_array($number, $selected))) {
              unset($item->images_alts[$index]);
              unset($_POST["imagealt"][$id][$index + 1]);
            }
            $number++;
          }
        }

        // аналогично удаляем элементы массива с описаниями заказанных изображений
        $number = 1;
        if (isset($item->images_texts) && !empty($item->images_texts)) {
          foreach ($item->images_texts as $index => &$image_text) {
            if ((is_string($selected) && (($selected == "*") || ($selected == $number)))
            || (is_array($selected) && in_array($number, $selected))) {
              unset($item->images_texts[$index]);
              unset($_POST["imagetext"][$id][$index + 1]);
            }
            $number++;
          }
        }

        // аналогично удаляем элементы массива с признаками заказанных изображений
        $number = 1;
        if (isset($item->images_view) && !empty($item->images_view)) {
          foreach ($item->images_view as $index => &$image_view) {
            if ((is_string($selected) && (($selected == "*") || ($selected == $number)))
            || (is_array($selected) && in_array($number, $selected))) {
              unset($item->images_view[$index]);
              unset($_POST["imageview"][$id][$index + 1]);
            }
            $number++;
          }
        }

        // если хоть одно удаление было (установился признак $start)
        if ($start) {

          // оптимизируем содержимое массивов
          $item->images = array_values($item->images);
          $item->images_alts = array_values($item->images_alts);
          $item->images_texts = array_values($item->images_texts);
          $item->images_view = array_values($item->images_view);

          // переводим (unfix) поля в состояние строк
          switch ($this->dbtable) {
            case 'articles':
              $this->db->unfix_articles_record_images($item);
              break;
            case 'brands':
              $this->db->unfix_brands_record_images($item);
              break;
            case 'categories':
              $this->db->unfix_categories_record_images($item);
              break;
            case 'countries':
              $this->db->countries->packImages($item);
              break;
            case 'news':
              $this->db->news->packImages($item);
              break;
            case 'products':
              $this->db->products->pack_images($item);
              break;
            case 'regions':
              $this->db->unfix_regions_record_images($item);
              break;
            case 'schools':
              $this->db->unfix_schools_record_images($item);
              break;
            case 'sections':
              $this->db->sections->packImages($item);
              break;
            case 'stocks':
              $this->db->stocks->packImages($item);
              break;
            case 'towns':
              $this->db->unfix_towns_record_images($item);
              break;
          }

          // добавляем в список запрос на сохранение полей в записи (запись может иметь поле image из старого формата)
          $query[] = "UPDATE " . $this->dbtable . " "
                   . "SET " . ($old_field ? "image = '" . $this->db->query_value($item->image) . "', " : "")
                       . "images = '" . $this->db->query_value($item->images) . "', "
                       . "images_alts = '" . $this->db->query_value($item->images_alts) . "', "
                       . "images_texts = '" . $this->db->query_value($item->images_texts) . "', "
                       . "images_view = '" . $this->db->query_value($item->images_view) . "' "
                   . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
        }

        // для этой команды отменяем рекомендуемую страницу возврата (чтобы остаться на странице редактирования)
        $this->result_page = "";
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // обработка команды ACTION_REQUEST_PARAM_VALUE_DELETEFILE ===============

    protected function action_delete_file ($id, &$query) {

      // открываем трассировку этого метода
      $this->db->open_tracing_method("BASIC action_delete_file");

      // делаем запрос - есть ли у записи поля файлов
      $this->db->query("SELECT files, "
                            . "files_alts, "
                            . "files_texts "
                     . "FROM " . $this->dbtable . " "
                     . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "' "
                     . "LIMIT 1;");
      $item = $this->db->result();

      // если поля найдены
      if (!empty($item)) {

        // выправляем (fix) поля до состояния массива
        switch ($this->dbtable) {
          case "files":
            $this->db->fix_files_record_files($item);
            break;
          case DATABASE_PRODUCTS_TABLENAME:
            $this->db->products->unpack_files($item);
            break;
        }

        // читаем входной параметр FILENUMBER - номер удаляемого файла (если равен *, значит все),
        // сбрасываем признак $start (пока ни одного удаления не было)
        $selected = trim($this->param(ACTION_REQUEST_PARAM_NAME_FILENUMBER));
        $start = FALSE;

        // в цикле удаляем заказанные файлы и связанные с ними элементы массива
        $number = 1;
        if (isset($item->files) && !empty($item->files)) {
          foreach ($item->files as $index => &$file) {
            if (($selected == "*") || ($selected == $number)) {

              // если имя файла задано
              if (trim($file) != "") {

                // делаем запрос - есть ли другая запись с таким файлом
                $this->db->query("SELECT files "
                               . "FROM " . $this->dbtable . " "
                               . "WHERE " . $this->dbtable_field . " != '" . $this->db->query_value($id) . "' "
                                     . "AND LOCATE('" . $this->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER . trim($file) . IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . "', CONCAT('" . $this->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . "', TRIM(files), '" . $this->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . "')) != 0 "
                               . "LIMIT 1;");
                $row = $this->db->result();

                // если такой файл нигде больше не используется, удаляем его
                if (empty($row)) {
                  $file = ROOT_FOLDER_REFERENCE . $this->upload_folder . $file;
                  if (@is_file($file . ADMIN_FILES_CLASS_SAFE_EXTENSION)) unlink($file . ADMIN_FILES_CLASS_SAFE_EXTENSION);
                }
              }

              // нужно однозначно убрать этот файл из пришедших от html-формы параметров, чтобы позже в обработках не принять его как существующим
              $start = TRUE;
              unset($item->files[$index]);
              unset($_POST["file"][$id][$index + 1]);
            }
            $number++;
          }
        }

        // аналогично удаляем элементы массива с alt-ами заказанных файлов
        $number = 1;
        foreach ($item->files_alts as $index => &$file_alt) {
          if (($selected == "*") || ($selected == $number)) {
            unset($item->files_alts[$index]);
            unset($_POST["filealt"][$id][$index + 1]);
          }
          $number++;
        }

        // аналогично удаляем элементы массива с описаниями заказанных файлов
        $number = 1;
        foreach ($item->files_texts as $index => &$file_text) {
          if (($selected == "*") || ($selected == $number)) {
            unset($item->files_texts[$index]);
            unset($_POST["filetext"][$id][$index + 1]);
          }
          $number++;
        }

        // если хоть одно удаление было (установился признак $start)
        if ($start) {

          // оптимизируем содержимое массивов
          $item->files = array_values($item->files);
          $item->files_alts = array_values($item->files_alts);
          $item->files_texts = array_values($item->files_texts);

          // переводим (unfix) поля в состояние строк
          switch ($this->dbtable) {
            case "files":
              $this->db->unfix_files_record_files($item);
              break;
            case DATABASE_PRODUCTS_TABLENAME:
              $this->db->products->pack_files($item);
              break;
          }

          // добавляем в список запрос на сохранение полей в записи
          $query[] = "UPDATE " . $this->dbtable . " "
                   . "SET files = '" . $this->db->query_value($item->files) . "', "
                       . "files_alts = '" . $this->db->query_value($item->files_alts) . "', "
                       . "files_texts = '" . $this->db->query_value($item->files_texts) . "' "
                   . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
        }

        // для этой команды отменяем рекомендуемую страницу возврата (чтобы остаться на странице редактирования)
        $this->result_page = "";
      }

      // закрываем трассировку этого метода
      $this->db->close_tracing_method();
    }

    // уточнение выбранного вида сортировки ==================================

    protected function recognize_sort (&$defaults = "") {

      // ставим значение по умолчанию для случая отсутствия параметра
      $result = isset($defaults->sort) ? $defaults->sort : "";

      // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
      if (isset($defaults->param)) {
        $param = $defaults->param . SORT_PARAM_PARTNAME;
        if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT])) {
          $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
          $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
        } else {
          if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
        }

        // извлекаем параметр из сеанса
        if (isset($_SESSION[$param])) {
          $value = trim($_SESSION[$param]);
          if ($value != "") {
            $result = $value;
            @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, "/");
          }
        }
      }

      // возвращаем значение параметра
      return $result;
    }

    // уточнение выбранного направления сортировки ===========================

    protected function recognize_sort_direction (&$defaults = "") {

      // ставим значение по умолчанию для случая отсутствия параметра
      $result = isset($defaults->sort_direction) ? $defaults->sort_direction : SORT_DIRECTION_DESCENDING;

      // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
      if (isset($defaults->param)) {
        $param = $defaults->param . SORT_DIRECTION_PARAM_PARTNAME;
        if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT_DIRECTION])) {
          $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_DIRECTION];
          $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_DIRECTION];
        } else {
          if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
        }

        // извлекаем параметр из сеанса
        if (isset($_SESSION[$param])) {
          $value = trim($_SESSION[$param]);
          if ($value != "") {
            $result = $value;
            @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, "/");
          }
        }
      }

      // возвращаем значение параметра
      return $result;
    }

    // уточнение выбранной лаконичности сортировки ===========================

    protected function recognize_sort_laconical (&$defaults = "") {

      // ставим значение по умолчанию для случая отсутствия параметра
      $result = isset($defaults->sort_laconical) ? $defaults->sort_laconical : 1;

      // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
      if (isset($defaults->param)) {
        $param = $defaults->param . SORT_LACONICAL_PARAM_PARTNAME;
        if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT_LACONICAL])) {
          $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_LACONICAL];
          $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_LACONICAL];
        } else {
          if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
        }

        // извлекаем параметр из сеанса
        if (isset($_SESSION[$param])) {
          $value = trim($_SESSION[$param]);
          if ($value != "") {
            $result = $value;
            @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, "/");
          }
        }
      }

      // возвращаем значение параметра
      return $result;
    }

    // уточнение выбранного типа записей =====================================

    protected function recognize_type (&$defaults = "") {

      // ставим значение по умолчанию для случая отсутствия параметра
      $result = isset($defaults->type) ? $defaults->type : "";

      // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
      if (isset($defaults->param)) {
        $param = $defaults->param . TYPE_PARAM_PARTNAME;
        if (isset($_REQUEST[REQUEST_PARAM_NAME_TYPE])) {
          $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_TYPE];
          $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_TYPE];
        } else {
          if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
        }

        // извлекаем параметр из сеанса
        if (isset($_SESSION[$param])) {
          $value = trim($_SESSION[$param]);
          if ($value != "") {
            $result = $value;
            @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, "/");
          }
        }
      }

      // возвращаем значение параметра
      return $result;
    }

    // уточнение выбранного режима отображения записей =======================

    protected function recognize_view_mode (&$defaults = "") {

      // ставим значение по умолчанию для случая отсутствия параметра
      $result = isset($defaults->view_mode) ? $defaults->view_mode : VIEW_MODE_STANDARD;

      // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
      if (isset($defaults->param)) {
        $param = $defaults->param . VIEW_MODE_PARAM_PARTNAME;
        if (isset($_REQUEST[REQUEST_PARAM_NAME_VIEW_MODE])) {
          $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_VIEW_MODE];
          $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_VIEW_MODE];
        } else {
          if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
        }

        // извлекаем параметр из сеанса
        if (isset($_SESSION[$param])) {
          $value = trim($_SESSION[$param]);
          if ($value != "") {
            $result = $value;
            @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, "/");
          }
        }
      }

      // возвращаем значение параметра
      return $result;
    }

    // уточнение выбранной автоматизации фильтра записей =====================

    protected function recognize_filter_manually (&$defaults = "") {

      // ставим значение по умолчанию для случая отсутствия параметра
      $result = isset($defaults->filter_manually) ? $defaults->filter_manually : 0;

      // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
      if (isset($defaults->param)) {
        $param = $defaults->param . FILTER_MANUALLY_PARAM_PARTNAME;
        if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MANUALLY])) {
          $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_FILTER_MANUALLY];
          $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_FILTER_MANUALLY];
        } else {
          if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
        }

        // извлекаем параметр из сеанса
        if (isset($_SESSION[$param])) {
          $value = trim($_SESSION[$param]);
          if ($value != "") {
            $result = $value;
            @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, "/");
          }
        }
      }

      // возвращаем значение параметра
      return $result;
    }

    // чтение из запроса Ф.И.О пользователя ==================================

    public function get_POST_person_name (&$item, &$source = null) {

      // если не указан источник данных запроса, считаем POST
      if (is_null($source)) $source = &$_POST;

      // вычисляем максимальный размер поля
      $size = floor(abs(DATABASE_USERS_FIELDSIZE_NAME - strlen(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) * 2) / 3);
      if ($size < 1) $size = 1;

      // берем из запроса фамилию (name), отчество (name2) и имя (name3)
      $item->name = isset($source["name"]) ? trim(substr($this->text->stripTags($source["name"], TRUE), 0, $size)) : "";
      $item->name2 = isset($source["name2"]) ? trim(substr($this->text->stripTags($source["name2"], TRUE), 0, $size)) : "";
      $item->name3 = isset($source["name3"]) ? trim(substr($this->text->stripTags($source["name3"], TRUE), 0, $size)) : "";
    }

    // чтение из запроса емейлов пользователя ================================

    public function get_POST_person_email (&$item, &$source = null) {

      // если не указан источник данных запроса, считаем POST
      if (is_null($source)) $source = &$_POST;

      // вычисляем максимальный размер поля
      $size = abs(DATABASE_USERS_FIELDSIZE_EMAIL);
      if ($size < 1) $size = 1;

      // берем из запроса емейлы
      $item->email = isset($source["email"]) ? $this->text->lowerCase(trim(substr($this->text->stripTags($source["email"], TRUE), 0, $size))) : "";
      $item->email2 = isset($source["email2"]) ? $this->text->lowerCase(trim(substr($this->text->stripTags($source["email2"], TRUE), 0, $size))) : "";
      if ($item->email == $item->email2) $item->email2 = "";
    }

    // чтение из запроса телефонов пользователя ==============================

    public function get_POST_person_phone (&$item, &$source = null) {

      // если не указан источник данных запроса, считаем POST
      if (is_null($source)) $source = &$_POST;

      // вычисляем максимальный размер поля
      $size = abs(DATABASE_USERS_FIELDSIZE_PHONE);
      if ($size < 1) $size = 1;

      // берем из запроса телефоны
      $item->phone = isset($source["phone"]) ? $this->text->lowerCase(trim(substr($this->text->stripTags($source["phone"], TRUE), 0, $size))) : "";
      $item->phone2 = isset($source["phone2"]) ? $this->text->lowerCase(trim(substr($this->text->stripTags($source["phone2"], TRUE), 0, $size))) : "";
      if ($item->phone == $item->phone2) $item->phone2 = "";
    }

    // принятие загруженного файла ===========================================

    public function receive_download ($selector, $folder, &$file = "[n][e]", $extensions = array()) {

      // если не получен нужный параметр
      if (!isset($selector->name) || !isset($_FILES[$selector->name])) {
        $file = "";
        return "";
      }

      // извлекаем сведения параметра зависимо от его строения
      // (простой, одноуровневый массив, двухуровневый массив, трехуровневый)
      if (!isset($selector->item_id)) {
        $name = isset($_FILES[$selector->name]["name"])
                ? $_FILES[$selector->name]["name"]
                : "";
        $tmp_name = isset($_FILES[$selector->name]["tmp_name"])
                    ? $_FILES[$selector->name]["tmp_name"]
                    : "";
        $error = isset($_FILES[$selector->name]["error"])
                    ? $_FILES[$selector->name]["error"]
                    : "";
      } elseif (!isset($selector->field_id)) {
        $name = isset($_FILES[$selector->name]["name"][$selector->item_id])
                ? $_FILES[$selector->name]["name"][$selector->item_id]
                : "";
        $tmp_name = isset($_FILES[$selector->name]["tmp_name"][$selector->item_id])
                    ? $_FILES[$selector->name]["tmp_name"][$selector->item_id]
                    : "";
        $error = isset($_FILES[$selector->name]["error"][$selector->item_id])
                    ? $_FILES[$selector->name]["error"][$selector->item_id]
                    : "";
      } elseif (!isset($selector->index)) {
        $name = isset($_FILES[$selector->name]["name"][$selector->item_id][$selector->field_id])
                ? $_FILES[$selector->name]["name"][$selector->item_id][$selector->field_id]
                : "";
        $tmp_name = isset($_FILES[$selector->name]["tmp_name"][$selector->item_id][$selector->field_id])
                    ? $_FILES[$selector->name]["tmp_name"][$selector->item_id][$selector->field_id]
                    : "";
        $error = isset($_FILES[$selector->name]["error"][$selector->item_id][$selector->field_id])
                    ? $_FILES[$selector->name]["error"][$selector->item_id][$selector->field_id]
                    : "";
      } else {
        $name = isset($_FILES[$selector->name]["name"][$selector->item_id][$selector->field_id][$selector->index])
                ? $_FILES[$selector->name]["name"][$selector->item_id][$selector->field_id][$selector->index]
                : "";
        $tmp_name = isset($_FILES[$selector->name]["tmp_name"][$selector->item_id][$selector->field_id][$selector->index])
                    ? $_FILES[$selector->name]["tmp_name"][$selector->item_id][$selector->field_id][$selector->index]
                    : "";
        $error = isset($_FILES[$selector->name]["error"][$selector->item_id][$selector->field_id][$selector->index])
                    ? $_FILES[$selector->name]["error"][$selector->item_id][$selector->field_id][$selector->index]
                    : "";
      }

      // если в селекторе указано, что файл необязателен к получению и его имя не получено
      if (($name == "") && (!isset($selector->required) || !$selector->required)) {
        $file = "";
        return "";
      }

      // пробуем принять файл
      $src_name = $this->text->stripTags($name, TRUE);
      if (($tmp_name != "")
      && ($error == UPLOAD_ERR_OK)
      && file_exists($tmp_name)) {

        // проверяем вхождение файла в список разрешенных по расширению
        $name = $this->hdd->safeFilename($src_name);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (is_array($extensions) && !empty($extensions) && !in_array($ext, $extensions)) {
          return "Недопустимый тип " . $ext . " загружаемого файла \"" . $src_name . "\". Принимаются только файлы с расширением " . implode(", ", $extensions) . ".";
        } else {

          // даем файлу имя по шаблону переменной $file (в ней [n] означает чисто имя файла, [e] расширение с точкой)
          if ($ext != "") $ext = "." . $ext;
          $name = substr($name, 0, -strlen($ext));
          $name = str_replace("[e]", $ext, str_replace("[n]", $name, $file));
          $name = $this->hdd->safeFilename($name, FALSE);
          $folder = $this->hdd->safeFilename($folder, FALSE);
          $name = $folder . "/" . $name;
          if (file_exists($name)) unlink($name);
          if (move_uploaded_file($tmp_name, $name)) {
            $file = $name;
            return "";
          }
          return "Не удалось переместить загруженный файл в \"" . $name . "\".";
        }

      // иначе была ошибка при передаче файла
      } else {
        switch ($error) {
          case UPLOAD_ERR_INI_SIZE:
            return "Размер принятого файла \"" . $src_name . "\" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.";
          case UPLOAD_ERR_FORM_SIZE:
            return "Размер загружаемого файла \"" . $src_name . "\" превышает максимально допустимое значение" . (isset($_POST["MAX_FILE_SIZE"]) ? " " . trim($_POST["MAX_FILE_SIZE"]) . " байт" : "") . ".";
          case UPLOAD_ERR_PARTIAL:
            return "Загрузка файла \"" . $src_name . "\" прервалась и он был получен не весь.";
          case UPLOAD_ERR_NO_FILE:
            return "Не получен файл \"" . $src_name . "\".";
          default:
            return "Произошла неизвестная ошибка при попытке загрузить файл \"" . $src_name . "\".";
        }
      }
    }



        // ===================================================================
        /**
        *  Догрузчик объектов на место свойств
        *
        *  @access  public
        *  @param   string  $name   имя свойства
        *  @return  object          догруженный объект
        */
        // ===================================================================

        final public function __get ( $name ) {
            $this->$name = null;
            $class = preg_replace('/[^a-z0-9]+/', ' ', $name);
            $class = preg_replace('/^[^a-z]+/', '', $class);
            $class = ucwords(strtolower(rtrim($class)));
            $class = str_replace(' ', '', $class);
            if ($class == '') return null;

            // если класс не существует
            $suffix = 'ANYModel';
            if (!class_exists($class . $suffix)) {
                $file = dirname(__FILE__) . '/.any-models/' . $class . '.php';
                if (!file_exists($file) || !is_readable($file)) {
                    echo 'В коде одного из страничных классов (' . get_class($this) . ') замечено обращение '
                       . 'к несуществующему свойству. Предполагая на его месте '
                       . 'динамически подгружаемый объект типа ' . $suffix . ', '
                       . 'не был найден файл ' . $class . '.php!';
                    exit;
                }
                require_once($file);
                if (!class_exists($class . $suffix)) {
                    echo 'В коде одного из страничных классов (' . get_class($this) . ') замечено обращение '
                       . 'к несуществующему свойству. Предполагая на его месте '
                       . 'динамически подгружаемый объект типа ' . $suffix . ', '
                       . 'был подключен файл ' . $class . '.php, однако в нем '
                       . 'не существует класс ' . $class . $suffix . '!';
                    exit;
                }
            }

            $class .= $suffix;
            $object = new $class($this);
            $object->owner = $this;
            if (!isset($object->owner_exclusive)) $object->owner_exclusive = FALSE;
            $this->$name = & $object;
            return $this->$name;
        }

    }



    return;
?>