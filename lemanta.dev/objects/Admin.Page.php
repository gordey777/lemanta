<?php
    // =======================================================================
    /**
    *  Модуль страницы админпанели,
    *  Админ модуль листания страниц,
    *  Админ модуль главной страницы,
    *  Модуль страницы клиентской стороны
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // какой файл является шаблоном страницы клиентской стороны (указываем без расширения)
    define('CLIENT_PAGESNAVIGATION_CLASS_TEMPLATE_FILE', 'navigation.htm');

    // сколько заказов показывать на главной в админпанели,
    // сколько переписки показывать на главной в админпанели,
    // сколько товаров показывать на главной в админпанели,
    // сколько отзывов о товарах показывать на главной в админпанели,
    // сколько статей показывать на главной в админпанели,
    // сколько комментариев к статьям показывать на главной в админпанели,
    // сколько новостей показывать на главной в админпанели,
    // сколько комментариев к новостям показывать на главной в админпанели
    define('ADMIN_MAINPAGE_ORDERS_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_FEEDBACK_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_PRODUCTS_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_COMMENTS_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_ARTICLES_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_ACOMMENTS_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_NEWS_MAXCOUNT', 8);
    define('ADMIN_MAINPAGE_NCOMMENTS_MAXCOUNT', 8);

    // начало текста в заголовке всякой страницы админпанели
    define('ADMIN_PAGE_TITLE_PREFIX', '');

    // предельное количество элементов в списке страниц, просмотренных в текущем сеансе
    define('RECENT_PAGES_LIST_MAXSIZE', 30);



    // =======================================================================
    /**
    *  Модуль страницы админпанели
    *
    *  Это основной модуль, с которого начинается загрузка всякой страницы
    *  (или модуля) в админпанели. Поддерживает подключение сторонних модулей.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AdminPage extends Basic {

        // имя файла шаблона или массив имен файлов
        protected $template = array('index.tpl',
                                    'admin_page.htm');

        // разрешено ли использовать сторонние модули (их файлы Admin.Класс.php или Класс.admin.php
        // размещают в папке http://сайт/константа_FOLDERNAME_FOR_ENGINE_OBJECTS/класс/
        protected $extensible = TRUE;

        // какие модули считать модулями ядра системы (для каждого такого модуля указывается в каком PHP-файле он описан)
        private $modules = array('mainpage'          => FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT,
                                 'feedback'          => FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT,
                                 'comments'          => FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT,
                                 'acomments'         => FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT,
                                 'ncomments'         => FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT,
                                 'callme'            => FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT,
                                 'sections'          => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'section'           => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'news'              => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'newsline'          => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'newsitem'          => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'articles'          => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'article'           => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'files'             => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'file'              => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'menus'             => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'menu'              => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'modules'           => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'module'            => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'products'          => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'product'           => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'productskits'      => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'productskit'       => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'ordersphases'      => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'ordersphase'       => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'paymentshistory'   => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'creditprograms'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'creditprogram'     => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'deliveries'        => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'delivery'          => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'deliverymethods'   => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'deliverymethod'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'deliveriestypes'   => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'deliveriestype'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'shippingsterms'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'shippingsterm'     => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'currencies'        => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'currency'          => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'payments'          => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'payment'           => 'Admin.Payment.php',
                                 'paymentmethods'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'paymentmethod'     => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'users'             => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'user'              => 'Admin.User.php',
                                 'countries'         => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'country'           => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'regions'           => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'region'            => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'towns'             => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'town'              => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schools'           => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'school'            => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolstypes'      => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolstype'       => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolslessons'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolslesson'     => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolsclasses'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolsclass'      => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolslearners'   => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'schoolslearner'    => FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT,
                                 'categories'        => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'category'          => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'brands'            => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'brand'             => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'properties'        => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'property'          => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'stocks'            => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'stock'             => FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT,
                                 'groups'            => 'Admin.Groups.php',
                                 'group'             => 'Admin.Group.php',
                                 'banneds'           => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'banned'            => FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT,
                                 'imports'           => 'Admin.Imports.php',
                                 'import'            => 'Admin.Imports.php',
                                 'export'            => 'Admin.Export.php',
                                 'mailer'            => 'Admin.Mailer.php',
                                 'themes'            => 'Admin.Themes.php',
                                 'templates'         => 'Admin.Images.php',
                                 'styles'            => 'Admin.Styles.php',
                                 'images'            => 'Admin.Images.php',
                                 'banners'           => 'Admin.Images.php',
                                 'backup'            => FILENAME_FOR_ENGINE_ADMIN_BACKUP_OBJECT,
                                 'redirects'         => FILENAME_FOR_ENGINE_ADMIN_BACKUP_OBJECT,
                                 'setup'             => 'Admin.Setup.php');

        // текущий модуль
        protected $module = null;
        protected $users = null;
        protected $stocks = null;



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
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process () {

            // читаем входной параметр SECTION - какой модуль указано использовать
            $this->add_param(REQUEST_PARAM_NAME_SECTION);
            $this->module = $this->param(REQUEST_PARAM_NAME_SECTION);
            $this->module = str_replace('\\', '', $this->module);
            $this->module = str_replace('/', '', $this->module);
            $this->module = str_replace(':', '', $this->module);
            $this->module = trim($this->module);

            // если это сторонний модуль и их не разрешено использовать, заменяем на MainPage
            if ($this->module == '') $this->module = 'MainPage';
            if (!$this->extensible && !array_key_exists(strtolower($this->module), $this->modules)) $this->module = 'MainPage';

            // если у текущего админа нет прав доступа
            $rights = FALSE;
            $login = $this->security->currentAdminLogin();
            $passes = $this->security->checkAdminRights($login, $this->module, $rights);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_RIGHTS, $rights);
            if (!$passes) {
                $this->module = null;
                $this->title = 'Недостаточно прав доступа к странице';
                $this->error_msg = 'Ваших административных прав недостаточно для доступа к этой странице!';
                $this->body = '<br><div class="error">' . $this->error_msg . '</div><br>';
                $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
                return;
            }

            // пробуем подключить указанный модуль
            while ($this->module != '') {
                $index = strtolower($this->module);
                $passes = 1;
                do {
                    switch ($passes) {

                        // на 2 проходе ищем модуль в папке модуля (как Admin.Модуль.php)
                        case 2:
                            $subpath = $index . '/';
                            $file = 'Admin.' . $this->module . '.php';
                            break;

                        // на 3 проходе ищем модуль в папке модуля (как Модуль.admin.php)
                        case 3:
                            $subpath = $index . '/';
                            $file = $this->module . '.admin.php';
                            break;

                        // на 1 проходе ищем модуль в ядре системы (как Admin.Модуль.php)
                        default:
                            $subpath = '';
                            $file = 'Admin.' . $this->module . '.php';
                            if (isset($this->modules[$index])) $file = $this->modules[$index];
                    }

                    $path = ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/';
                    if (is_readable($path . $subpath . $file) && is_file($path . $subpath . $file)) {

                        // определяем ссылку на папку объектов из папки модуля
                        if ($subpath != '') define('ENGINE_OBJECTS_FOLDER_REFERENCE', '../');

                        // подключаем файл модуля
                        include_once($path . $subpath . $file);
                        break 2;
                    }
                    $passes++;
                } while ($passes <= 3);

                // модуль не найден, заменяем на MainPage
                if ($index == 'mainpage') break;
                $this->module = 'MainPage';
            }

            // если подключенный модуль был неким произвольным кодом, забываем о модуле и выходим
            if (!class_exists($this->module)) {
                $this->module = null;
                return;
            }

            // создаем модуль
            $this->module = new $this->module($this);
        }



        // ===================================================================
        /**
        *  Упреждающее наполнение основных шаблонизируемых переменных
        *
        *  @access  protected
        *  @param   array   $list       список (массив) имен переменных
        *  @return  void
        */
        // ===================================================================

        protected function preassign ( $list = null ) {

            // читаем входной параметр SECT - в каком товарном разделе магазина находимся
            $this->now_in_section = intval($this->param('sect', 'sect'));
            $this->now_in_section = max(1, $this->now_in_section);

            // сохраняем эти данные в сеансе и шаблонизаторе Smarty
            $this->session->set('sect', $this->now_in_section);
            $this->smarty->assign('now_in_section', $this->now_in_section);

            // читаем список категорий текущего раздела магазина (в том числе потерянные ветви) и передаем в шаблонизатор
            if (is_array($list) && in_array('categories', $list)) {
                $params = new stdClass;
                $params->mode = GET_CATEGORIES_MODE_WITH_MISSING_BRANCHES;
                $params->sort = SORT_CATEGORIES_MODE_AS_IS;
                $params->section = $this->now_in_section;
                $this->db->categories->get($this->categories_tree, $params, $this->categories);  // вызов метода fix_categories_records не требуется
                $this->smarty->assignByRef('categories', $this->categories_tree);
                $this->smarty->assignByRef('categories_list', $this->categories);
            }

            // читаем список брендов текущего раздела магазина (в том числе потерянные ветви) и передаем в шаблонизатор
            if (is_array($list) && in_array('all_brands', $list)) {
                $params = new stdClass;
                $params->mode = GET_BRANDS_MODE_WITH_MISSING_BRANCHES;
                $params->sort = SORT_BRANDS_MODE_AS_IS;
                $params->section = $this->now_in_section;
                $this->db->brands->get($this->brands_tree, $params, $this->brands);  // вызов метода fix_brands_records не требуется
                $this->smarty->assignByRef('all_brands', $this->brands_tree);
                $this->smarty->assignByRef('brands_list', $this->brands);
            }

            // читаем список клиентов и передаем в шаблонизатор
            if (is_array($list) && in_array('all_users', $list)) {
                $params = new stdClass;
                $params->sort = SORT_USERS_MODE_BY_NAME;
                $this->db->users->get($this->users, $params);  // вызов метода unpackRecords не требуется
                $this->smarty->assignByRef('all_users', $this->users);
                $this->smarty->assignByRef('users_list', $this->users);
            }

            // читаем список меню сайта и передаем в шаблонизатор
            if (is_array($list) && in_array('menus', $list)) {
                $params = new stdClass;
                $params->sort = SORT_MENUS_MODE_BY_NAME;
                $this->db->get_menus($this->menus, $params);
                $this->db->fix_menus_records($this->menus);
                $this->smarty->assignByRef('menus', $this->menus);
            }

            // читаем список складов и передаем в шаблонизатор
            if (is_array($list) && in_array('stocks', $list)) {
                $params = new stdClass;
                $params->sort = SORT_STOCKS_MODE_BY_NAME;
                $this->db->stocks->get($this->stocks, $params);
                $this->db->stocks->unpackRecords($this->stocks);
                $this->smarty->assignByRef('stocks', $this->stocks);
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

            // обрабатываем входные параметры
            $this->process();

            // если модуль не был неким произвольным кодом
            if (!is_null($this->module)) {

                // наполняем основные шаблонизируемые переменные "по просьбе" модуля
                $list = null;
                if (isset($this->module->preassignable) && is_array($this->module->preassignable)) $list = & $this->module->preassignable;
                $this->preassign($list);

                // создаем контент модуля
                $this->module->fetch();

                // передаем части контента модуля в вышестоящий (это текущий, то есть модуль страницы)
                $this->title = & $this->module->title;
                $this->keywords = & $this->module->keywords;
                $this->description = & $this->module->description;
                $this->body = & $this->module->body;
                $this->bgsound = & $this->module->bgsound;

                // если модуль требовал рисовать его без внешнего оформления страницы, выходим
                if (!empty($this->module->single)) return FALSE;
            }

            // если во входных параметрах была заявка на прорисовку модуля без перезагрузки страницы, выходим
            if (!empty($this->quick_content)) return FALSE;

            // передаем шаблонизатору части контента
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_TITLE, $this->title);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_KEYWORDS, $this->keywords);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_DESCRIPTION, $this->description);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_CONTENT, $this->body);
            $this->smarty->assignByRef(SMARTY_VAR_ADMIN_BGSOUND, $this->bgsound);

            // создаем контент страницы
            $this->fetchAdminTemplate();
            return TRUE;
        }
    }



    // =========================================================================
    // Класс PagesNavigation (админ модуль листания страниц)
    // =========================================================================

    class PagesNavigation extends Basic {

        // имя файла шаблона или массив имен файлов
        protected $template = array('navigation.htm',
                                    'admin_pages_navigation.htm');

        // конструктор класса ====================================================

        public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
        }

        // создание контента модуля ==============================================

        public function make ($pages_num, $items_count = 0) {

            // берем индексный номер текущей страницы
            if ($pages_num <= 1) $pages_num = 0;
            $page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            if ($page >= $pages_num) $page = $pages_num - 1;
            if ($page < 0) $page = 0;

            // создаем массив адресов страниц
            $pages = array();
            $section = $this->param(REQUEST_PARAM_NAME_SECTION);
            for ($i = 0; $i < $pages_num; $i++) {
                $url = 'http://' . $this->root_url . '/' . $this->admin_folder . '/index.php'
                     . $this->form_get(array(REQUEST_PARAM_NAME_SECTION => $section,
                                             REQUEST_PARAM_NAME_PAGE => $i));
                $pages[$i] = $url;
            }

            // если видны кнопки Вперед / Назад, передаем их в шаблонизатор
            if ($page > 0) $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_PREVIOUS_PAGE, $pages[$page - 1]);
            if ($page < $pages_num - 1) $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_NEXT_PAGE, $pages[$page + 1]);

            // вычисляем количество элементов на странице
            $items_per_page = $pages_num > 0 ? round($items_count / $pages_num) : (isset($this->items_per_page) ? intval($this->items_per_page) : 1);
            if ($items_per_page < 1) $items_per_page = 1;

            // передаем необходимые данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_PAGES, $pages);
            $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CURRENT_PAGE, $page);
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $items_per_page);
            $this->smarty->assignByRef(SMARTY_VAR_TOTAL_ITEMS, $items_count);
            $this->fetchAdminTemplate();
        }
    }



    // =======================================================================
    /**
    *  Админ модуль главной страницы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class MainPage extends Basic {

        // имя файла шаблона или массив имен файлов
        protected $template = array('mainpage/mainpage.htm',
                                    'admin_main_page.htm');

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
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
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

            // читаем список новых заказов
            $params = new stdClass;
            $params->sort = SORT_ORDERS_MODE_BY_DATE;
            $params->sort_direction = SORT_DIRECTION_DESCENDING;
            $params->status = ORDER_STATUS_NEW;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_ORDERS_MAXCOUNT;
            $this->db->orders->get($last_orders, $params);
            $this->db->orders->unpackRecords($last_orders);

            // добавляем в записи заказов оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->orders->operable($last_orders, $params);

            // читаем список недавней переписки
            $query = 'SELECT * '
                   . 'FROM ' . DATABASE_FEEDBACK_TABLENAME . ' '
                   . 'WHERE new = 1 '
                   . 'ORDER BY date DESC, '
                            . 'feedback_id DESC '
                   . 'LIMIT ' . ADMIN_MAINPAGE_FEEDBACK_MAXCOUNT . ';';
            $this->db->query($query);
            $last_feedback = $this->db->results();

            // добавляем в записи переписки оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->feedback->operable($last_feedback, $params);

            // читаем список недавно измененных товаров в текущем разделе магазина
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_BY_MODIFIED;
            $params->sort_direction = SORT_DIRECTION_DESCENDING;
            $params->type = TYPE_PRODUCTS_ANY;
            $params->discount = 0;
            $params->section = $this->now_in_section;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_PRODUCTS_MAXCOUNT;
            $this->db->products->get($last_products, $params);
            $this->db->products->unpackRecords($last_products);

            // добавляем в записи товаров оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->products->operable($last_products, $params);

            // читаем список недавних отзывов о товарах (просим вернуть плоский список)
            $params = new stdClass;
            $params->reverse = 1;
            $params->flatlist = 1;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_COMMENTS_MAXCOUNT;
            $this->db->get_comments($last_comments, $params);

            // добавляем в записи отзывов о товарах оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->operable_comments($last_comments, $params);

            // читаем список недавних статей
            $params = new stdClass;
            $params->sort = SORT_ARTICLES_MODE_BY_CREATED;
            $params->sort_direction = SORT_DIRECTION_DESCENDING;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_ARTICLES_MAXCOUNT;
            $this->db->get_articles($last_articles, $params);
            $this->db->fix_articles_records($last_articles);

            // добавляем в записи статей оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->operable_articles($last_articles, $params);

            // читаем список недавних комментариев к статьям (просим вернуть плоский список)
            $params = new stdClass;
            $params->reverse = 1;
            $params->flatlist = 1;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_ACOMMENTS_MAXCOUNT;
            $this->db->get_acomments($last_acomments, $params);

            // добавляем в записи комментариев к статьям оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->operable_acomments($last_acomments, $params);

            // читаем список недавних новостей
            $last_news = null;
            $params = new stdClass;
            $params->sort = SORT_NEWS_MODE_BY_CREATED;
            $params->sort_direction = SORT_DIRECTION_DESCENDING;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_NEWS_MAXCOUNT;
            $this->db->news->get($last_news, $params);
            $this->db->news->unpackRecords($last_news);

            // добавляем в записи новостей оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->news->operable($last_news, $params);

            // читаем список недавних комментариев к новостям (просим вернуть плоский список)
            $params = new stdClass;
            $params->reverse = 1;
            $params->flatlist = 1;
            $params->start = 0;
            $params->maxcount = ADMIN_MAINPAGE_NCOMMENTS_MAXCOUNT;
            $this->db->get_ncomments($last_ncomments, $params);

            // добавляем в записи комментариев к новостям оперативные ссылки админпанели
            $params = new stdClass;
            $params->token = $this->token;
            $this->db->operable_ncomments($last_ncomments, $params);

            // устанавливаем заголовок страницы
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Главная страница';

            // передаем необходимые данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_LAST_ORDERS, $last_orders);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_FEEDBACK, $last_feedback);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_PRODUCTS, $last_products);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_COMMENTS, $last_comments);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_ARTICLES, $last_articles);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_ACOMMENTS, $last_acomments);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_NEWS, $last_news);
            $this->smarty->assignByRef(SMARTY_VAR_LAST_NCOMMENTS, $last_ncomments);

            // создаем контент модуля
            $this->fetchAdminTemplate();
            return TRUE;
        }
    }



    // =========================================================================
    // Класс ClientPagesNavigation (модуль листания страниц клиентской стороны)
    // =========================================================================

    class ClientPagesNavigation extends PagesNavigation {



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

            // конструируем объект
            Basic::__construct($parent, BASIC_START_FOR_CLIENT_MODE);
        }



        // создание контента модуля ==============================================

        public function make ( $pages_num, $items_count = 0 ) {

            // открываем трассировку этого метода
            $this->db->open_tracing_method('CLIENT_PAGES_NAVIGATION fetch');

            $pages_num = intval(ceil($pages_num));
            if ($pages_num > 1) {
                $page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
                if ($page >= $pages_num) $page = $pages_num - 1;

                for ($i = 0; $i < $pages_num; $i++) {
                    $url = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI']) : '';

                    $url = parse_url($url);
                    if (isset($url['path'])) {
                        $param = '/' . REQUEST_PARAM_NAME_PAGE . '_';
                        $url['path'] = preg_replace('!(.*)' . $param . '[0-9]+$!i', '$1', $url['path']);
                        $url['path'] .= $param . $i;
                        $url['query'] = isset($url['query']) ? '?' . $url['query'] : '';
                        $url['fragment'] = isset($url['fragment']) ? '#' . $url['fragment'] : '';
                        $url = $url['path'] . $url['query'] . $url['fragment'];
                    } else {
                        $url = '';
                    }
                    $pages[$i] = $url;
                }

                if ($page > 0) $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_PREVIOUS_PAGE, $pages[$page - 1]);
                if ($page < $pages_num - 1) $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_NEXT_PAGE, $pages[$page + 1]);

                $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_PAGES, $pages);
                $this->smarty->assign(SMARTY_VAR_NAVIGATOR_CURRENT_PAGE, $page);
                $this->body = $this->smarty->fetch(CLIENT_PAGESNAVIGATION_CLASS_TEMPLATE_FILE);
            }

            // закрываем трассировку этого метода
            $this->db->close_tracing_method();
        }
    }



    return;
?>