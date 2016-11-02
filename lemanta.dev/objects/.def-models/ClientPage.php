<?php
    // базовый класс
    require_once(dirname(__FILE__) . '/../Basic.php');



    // ========== TODO: удалить позже (баннеры сделать ANY-моделью) =========
    // подключаем модули картинок, шаблонов, баннеров
    require_once(dirname(__FILE__) . '/../Admin.Images.php');



    // =======================================================================
    /**
    *  Модуль страницы клиентской стороны
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientPage extends Basic {

        // разрешено ли использовать незарегистрированные модули
        protected $extensible = FALSE;

        // текущая специальная страница,
        // текущая статья,
        // текущая новость,
        // текущая категория,
        // текущий бренд,
        // текущий товар
        public $section = null;
        public $article = null;
        public $news_item = null;
        public $category = null;
        public $brand = null;
        public $product = null;

        // сведения о корзине
        public $cart_products_num = 0;
        public $cart_total_price = 0;
        public $cart_total_discount_sum = 0;
        public $cart_variants = null;

        // сведения об отложенных
        public $defer_products_num = 0;
        public $defer_total_price = 0;
        public $defer_variants = null;

        // текущий модуль,
        // список пользователей,
        // список складов,
        protected $module = null;
        protected $users = null;
        protected $stocks = null;

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'page';



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
            Basic::__construct($parent);

            // если известно откуда пришли
            $url = $this->request->getServerAsSentence('HTTP_REFERER');
            if ($url != '') {

                // если сработало поисковое сопровождение
                $url = $this->db->searches->visit($url);
                if ($url != '') $this->security->redirectToPage($url);
            }
        }



        // ===================================================================
        /**
        *  Отправка заголовка ОШИБКА 404
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function headerError404 () {
            if ($this->request->getServer('REDIRECT_STATUS') == 401) return;
            if ($this->request->getServer('REDIRECT_REDIRECT_STATUS') == 401) return;
            if (function_exists('getenv')) {
                if (getenv('REDIRECT_STATUS') == 401) return;
                if (getenv('REDIRECT_REDIRECT_STATUS') == 401) return;
            }
            if (function_exists('apache_getenv')) {
                if (apache_getenv('REDIRECT_STATUS') == 401) return;
                if (apache_getenv('REDIRECT_REDIRECT_STATUS') == 401) return;
            }
            @ header('HTTP/1.0 404 Not Found');
        }



        // ===================================================================
        /**
        *  Установка незаполненной переменной "Заголовок" страницы
        *
        *  @access  public
        *  @param   string  $title  текст заголовка
        *  @return  void
        */
        // ===================================================================

        public function refillPageTitleVar ( $title ) {
            if (isset($this->title) && $this->title == ''
            && $title != '') $this->title = $title;
        }



        // ===================================================================
        /**
        *  Установка незаполненных типичных переменных страницы (заголовок,
        *  ключевые слова и т.п.)
        *
        *  @access  public
        *  @param   object  $module     объект модуля
        *  @return  void
        */
        // ===================================================================

        public function refillPageTypicalVars ( & $module ) {
            $fields = array('title' => array('title', 'meta_title'),
                            'keywords' => array('keywords', 'meta_keywords'),
                            'description' => array('description', 'meta_description'),
                            'seo_description',
                            'bgsound');
            foreach ($fields as $key => $field) {
                if (is_string($key)) {
                    if (is_array($field) && !empty($field)) {
                        foreach ($field as $name) {
                            if (is_string($name)
                            && isset($this->$key) && $this->$key == ''
                            && isset($module->$name) && $module->$name != '') {
                                $this->$key = $module->$name;
                            }
                        }
                    }
                } else if (is_string($field)) {
                    if (isset($this->$field) && $this->$field == ''
                    && isset($module->$field) && $module->$field != '') {
                        $this->$field = $module->$field;
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Передача типичных переменных страницы (заголовок, ключевые слова
        *  и т.п.) в шаблонизатор
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function assignPageTypicalVars () {
            $fields = array('title',
                            'keywords',
                            'description',
                            'seo_description',
                            'bgsound');
            foreach ($fields as $field) {
                if (is_string($field)) {
                    if (isset($this->$field)) {
                        $this->smarty->assignByRef($field, $this->$field);
                    }
                }
            }
        }



        // обработка входных параметров ==========================================

        protected function process () {
            $this->db->open_tracing_method('CLIENT_PAGE process');

            // запоминаем признак динамической отрисовки без перезагрузки страницы
            $this->quick_content = !empty($_REQUEST['quickcontent']) || !empty($_REQUEST['ajax']);
            $this->smarty->assignByRef('quick_content', $this->quick_content);
            $this->smarty->assignByRef('ajax', $this->quick_content);

            // читаем входной параметр SECT - в каком товарном разделе магазина находимся,
            // сохраняем эти данные в сеансе и шаблонизаторе Smarty
            $this->now_in_section = intval($this->param('sect', 'sect'));
            $this->now_in_section = max(1, $this->now_in_section);
            $this->session->set('sect', $this->now_in_section);
            $this->smarty->assign('now_in_section', $this->now_in_section);

            // получаем список исключений упреждающего наполнения шаблонизируемых переменных
            // (то есть если в эмуляторе шаблона объявили, какие переменные будут наполнять сами)
            $list = array();
            if (!empty($this->designer->not_preassignable) && is_array($this->designer->not_preassignable)) $list = & $this->designer->not_preassignable;

            // следующее выполняем только для перезагружаемых страниц
            // (то есть не читаем лишнее, если страница открывается вспомогательным блоком поверх основной)
            if (!$this->quick_content) {

                // читаем список незапрещенных и видимых пользователю категорий текущего раздела магазина и передаем в шаблонизатор
                if (!in_array('*', $list) && !in_array('categories', $list)) {
                    $params = new stdClass;
                    $params->sort = $this->settings->categories_sort_method;
                    $params->enabled = 1;
                    if (!isset($this->user->user_id)) $params->hidden = 0;
                    $params->section = $this->now_in_section;
                    $this->db->categories->get($this->categories_tree, $params, $this->categories);  // вызов метода fix_categories_records не требуется
                    $this->smarty->assignByRef('categories', $this->categories_tree);
                    $this->smarty->assignByRef('categories_list', $this->categories);
                }

                // читаем список незапрещенных и видимых пользователю брендов текущего раздела магазина и передаем в шаблонизатор
                if (!in_array('*', $list) && !in_array('all_brands', $list)) {
                    $params = new stdClass;
                    $params->sort = $this->settings->brands_sort_method;
                    $params->enabled = 1;
                    if (!isset($this->user->user_id)) $params->hidden = 0;
                    $params->section = $this->now_in_section;
                    $this->db->brands->get($this->brands_tree, $params, $this->brands);  // вызов метода fix_brands_records не требуется
                    $this->smarty->assignByRef('all_brands', $this->brands_tree);
                    $this->smarty->assignByRef('brands_list', $this->brands);
                }
            }

            // запоминаем величину скидки клиента
            $discount = isset($this->user->discount) ? $this->user->discount : 0;

            // следующее выполняем только для перезагружаемых страниц
            // (то есть не читаем лишнее, если страница открывается вспомогательным блоком поверх основной)
            if (!$this->quick_content) {

                // читаем список незапрещенных и видимых пользователю меню сайта и передаем его в шаблонизатор
                if (!in_array('*', $list) && !in_array('menus', $list)) {
                    $params = new stdClass;
                    $params->mode = GET_MENUS_MODE_INDEXED_BY_NAME;
                    $params->sort = SORT_MENUS_MODE_BY_NAME;
                    $params->enabled = 1;
                    if (!isset($this->user->user_id)) $params->hidden = 0;
                    $this->db->get_menus($this->menus, $params);
                    $this->db->fix_menus_records($this->menus);
                    foreach ($this->menus as & $menu) {
                        $this->db->menus->attachItems($menu);
                    }
                    $this->smarty->assignByRef('menus', $this->menus);
                }

                // читаем анонсовый список новостей и передаем его в шаблонизатор
                if (!in_array('*', $list) && !in_array('news', $list)) {
                    $news = null;
                    $params = new stdClass;
                    $params->sort = $this->settings->news_sort_method;
                    $params->enabled = 1;
                    if (!isset($this->user->user_id)) $params->hidden = 0;
                    $params->section = $this->now_in_section;
                    if ($this->request->getRequest('module') != 'News') {
                        $params->listed = 1;
                        $params->maxcount = $this->settings->news_main_maxcount > 0 ? $this->settings->news_main_maxcount : 0;
                    }
                    $this->db->news->get($news, $params);
                    $this->db->news->unpackRecords($news);
                    // читаем количество комментариев у новостей
                    if (!empty($news)) {
                        foreach ($news as $index => $item) {
                            $temp = null;
                            $params = new stdClass;
                            $params->news_id = $item->news_id;
                            $params->enabled = 1;
                            $params->start = 0;
                            $params->maxcount = 0;
                            $this->db->get_ncomments($temp, $params, $news[$index]->comments_count);
                        }
                    }
                    $this->smarty->assignByRef('news', $news);
                }

                // читаем анонсовый список статей и передаем его в шаблонизатор
                if (!in_array('*', $list) && !in_array('articles', $list)) {
                    $params = new stdClass;
                    $params->sort = $this->settings->articles_sort_method;
                    $params->enabled = 1;
                    if (!isset($this->user->user_id)) $params->hidden = 0;
                    $params->section = $this->now_in_section;
                    if ($this->request->getRequest('module') != 'Articles') {
                        $params->listed = 1;
                        $params->maxcount = $this->settings->articles_main_maxcount > 0 ? $this->settings->articles_main_maxcount : 0;
                    }
                    $this->db->get_articles($articles, $params);
                    $this->db->fix_articles_records($articles);
                    // читаем количество комментариев у статей
                    if (!empty($articles)) {
                        foreach ($articles as $index => $item) {
                            $temp = null;
                            $params = new stdClass;
                            $params->article_id = $item->article_id;
                            $params->enabled = 1;
                            $params->start = 0;
                            $params->maxcount = 0;
                            $this->db->get_acomments($temp, $params, $articles[$index]->comments_count);
                        }
                    }
                    $this->smarty->assignByRef('articles', $articles);
                }
            }

            // передаем в шаблонизатор данные корзины
            if (!in_array('*', $list) && !in_array('defer_products', $list)) {
                $this->compute_defer_state($this->defer_products_num, $this->defer_total_price, $this->defer_variants);
                $this->smarty->assignByRef('defer_total_price', $this->defer_total_price);
                $this->smarty->assignByRef('defer_products_num', $this->defer_products_num);
                $this->smarty->assignByRef('defer_products', $this->defer_variants);
            }
            if (!in_array('*', $list) && !in_array('cart_products', $list)) {
                $this->compute_cart_state($this->cart_products_num, $this->cart_total_price, $this->cart_total_discount_sum, $this->cart_variants);
                $this->smarty->assignByRef('cart_total_price', $this->cart_total_price);
                $this->smarty->assignByRef('cart_total_discount_sum', $this->cart_total_discount_sum);
                $this->smarty->assignByRef('cart_products_num', $this->cart_products_num);
                $this->smarty->assignByRef('cart_products', $this->cart_variants);
                $this->smarty->assign('cart_microinfo', $this->get_cart_microinfo_content($this->cart_products_num,
                                                                                          $this->cart_total_price,
                                                                                          $this->cart_total_discount_sum,
                                                                                          !in_array('defer_products', $list) ? $this->defer_products_num
                                                                                                                             : 0));
                $this->smarty->assign('compare_microinfo', $this->get_compare_microinfo_content());
            }

            // регистрируем сколько сейчас на сайте и передаем данные в шаблонизатор
            $now_on_site_registered = 0;
            $now_on_site = $this->registrar->onSiteNow(isset($this->user->user_id) ? $this->user->user_id : 0,
                                                       $now_on_site_registered);
            $this->smarty->assign('now_on_site', $now_on_site);
            $this->smarty->assign('now_on_site_registered', $now_on_site_registered);

            // ========== TODO: баннеры сделать ANY-моделью ==========
            // читаем список баннеров и передаем в шаблонизатор
            if (!in_array('*', $list) && !in_array('banners', $list)) {
                $banners = new Banners($this);
                $banners_images = array();
                $banners->get_files($banners->files_path, '', $banners_images);
                $this->smarty->assignByRef('banners', $banners_images);
            }

            // пробуем разобрать по входным параметрам, какой модуль надо использовать
            $module = $this->param('module');
            $special_url = $this->param('special_url');
            $section = $this->param('section');
            if ($special_url == '' && $section == '' && $module == '') {
                if ($this->mobile_user) {
                    $section = $this->settings->main_mobile_section;
                } else {
                    $section = $this->settings->main_section;
                }
            }
            $objects = array();
            if ($module == '' && ($special_url != '' || $section != '')) {
                $params = new stdClass;
                $params->url = $section != '' ? $section : $special_url;
                $params->url_special = $section != '' ? 0 : 1;
                $params->enabled = 1;
                if (!isset($this->user->user_id)) $params->hidden = 0;

                $this->db->sections->one($this->section, $params);
                if (empty($this->section) && $section == '') {

                    $params->discount = $discount;
                    if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
                    $params->with_related = 1;
                    $this->db->products->one($this->product, $params);
                    if (empty($this->product)) {

                        unset($params->discount);
                        if (isset($params->price_id)) unset($params->price_id);
                        unset($params->with_related);
                        $this->db->get_category($this->category, $params);
                        if (empty($this->category)) {

                            $this->db->get_brand($this->brand, $params);
                            if (empty($this->brand)) {

                                $this->db->get_article($this->article, $params);
                                if (empty($this->article)) {

                                    $this->db->news->one($this->news_item, $params);
                                    if (!empty($this->news_item)) {
                                        $_GET['url'] = $params->url;
                                        $module = 'NewsItem';
                                        // берем список подключаемых плагинов
                                        $objects = explode(',', $this->news_item->objects);
                                    }
                                } else {
                                    $_GET['url'] = $params->url;
                                    $module = 'Articles';
                                    // берем список подключаемых плагинов
                                    $objects = explode(',', $this->article->objects);
                                }
                            } else {
                                $_GET['brand'] = $params->url;
                                $module = 'Products';
                                // берем список подключаемых плагинов
                                $objects = explode(',', $this->brand->objects);
                            }
                        } else {

                            // не забываем, категория на особом URL должна быть связана с деревом
                            if (isset($this->categories) && is_array($this->categories)) {
                                $ok = FALSE;
                                foreach ($this->categories as & $cat) {
                                    if ($cat->url == $params->url) {
                                        $this->category = $cat;
                                        $ok = TRUE;
                                        break;
                                    }
                                }
                                if (!$ok && is_numeric($params->url) && !empty($params->url)) {
                                    foreach ($this->categories as & $cat) {
                                        if (trim($cat->url) == '' && $cat->category_id == $params->url) {
                                            $this->category = $cat;
                                            break;
                                        }
                                    }
                                }
                            }

                            $_GET['category'] = $params->url;
                            $module = 'Products';
                            // берем список подключаемых плагинов
                            $objects = explode(',', $this->category->objects);
                        }
                    } else {
                        $_GET['url'] = $params->url;
                        $module = 'Product';
                        // берем список подключаемых плагинов
                        $objects = explode(',', $this->product->objects);
                    }
                } elseif (!empty($this->section)) {
                    $_GET['section'] = $params->url;
                    $module = $this->section->class;
                    // берем список подключаемых плагинов
                    $objects = explode(',', $this->section->objects);
                    $this->smarty->assignByRef('section', $this->section);
                    $this->refillPageTypicalVars($this->section);
                }
            }

            // пробуем найти такой модуль
            if ($module != '') {
                $module = preg_replace('!/:\\\\!', '', $module);
                $module = trim($module);
                if ($module != '') {

                    // создаем контент на случай, если модуль не найдется или он запрещен
                    $this->body = str_replace('<', '&lt;', $module);
                    $this->body = str_replace('>', '&gt;', $this->body);
                    $this->body = str_replace('*', $this->body, CONTENT_MESSAGE_NO_MODULE);

                    // ищем модуль в списке зарегистрированных
                    $item = null;
                    $params = new stdClass;
                    $params->class = $module;
                    $params->enabled = 1;
                    $params->plugin = 0;
                    $this->db->get_module($item, $params);

                    // если не найден или это сторонний и их не разрешено использовать
                    if (empty($item) && !$this->extensible) {
                        $this->headerError404();
                        $this->db->close_tracing_method();
                        return;
                    }

                    // определяем имя файла модуля
                    $filename = isset($item->filename) ? trim($item->filename) : '';
                    $filename = preg_replace('!/:\\\\!', '', $filename);
                    $filename = trim($filename);
                    if ($filename == '') $filename = $module . '.php';
                }
            }

            // пробуем подключить модуль
            if ($module != '') {

                // вспоминаем (из браузера пользователя) список товаров корзины
                $field = CART_PRODUCTS_SESSION_PARAM_NAME;
                if ($this->session->restoreCartArrayFromCookie($field, CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME)) {

                    // повторно передаем в шаблонизатор данные корзины (товары)
                    if (!empty($_SESSION[$field])) {
                        if (!in_array('*', $list) && !in_array('cart_products', $list)) {
                            $this->compute_cart_state($this->cart_products_num, $this->cart_total_price, $this->cart_total_discount_sum, $this->cart_variants);
                            $this->smarty->assignByRef('cart_total_price', $this->cart_total_price);
                            $this->smarty->assignByRef('cart_total_discount_sum', $this->cart_total_discount_sum);
                            $this->smarty->assignByRef('cart_products_num', $this->cart_products_num);
                            $this->smarty->assignByRef('cart_products', $this->cart_variants);
                            $this->smarty->assign('cart_microinfo', $this->get_cart_microinfo_content($this->cart_products_num,
                                                                                                      $this->cart_total_price,
                                                                                                      $this->cart_total_discount_sum,
                                                                                                      !in_array('defer_products', $list) ? $this->defer_products_num
                                                                                                                                         : 0));
                        }
                    }
                }

                // вспоминаем (из браузера пользователя) список отложенных товаров
                $field = DEFER_PRODUCTS_SESSION_PARAM_NAME;
                if ($this->session->restoreCartArrayFromCookie($field, DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME)) {

                    // повторно передаем в шаблонизатор данные корзины (отложенные товары)
                    if (!empty($_SESSION[$field])) {
                        if (!in_array('*', $list) && !in_array('defer_products', $list)) {
                            $this->compute_defer_state($this->defer_products_num, $this->defer_total_price, $this->defer_variants);
                            $this->smarty->assignByRef('defer_total_price', $this->defer_total_price);
                            $this->smarty->assignByRef('defer_products_num', $this->defer_products_num);
                            $this->smarty->assignByRef('defer_products', $this->defer_variants);
                            if (!in_array('cart_products', $list)) {
                                $this->smarty->assign('cart_microinfo', $this->get_cart_microinfo_content($this->cart_products_num,
                                                                                                          $this->cart_total_price,
                                                                                                          $this->cart_total_discount_sum,
                                                                                                          $this->defer_products_num));
                            }
                        }
                    }
                }

                $index = $this->text->lowerCase($module);
                // ищем модуль в ядре системы
                $path = dirname(__FILE__) . '/../';
                if ($this->hdd->isReadableFile($path . $filename)) {
                    include_once($path . $filename);
                } else {
                    // иначе ищем модуль в папке модуля
                    $path .= $index . '/';
                    if ($this->hdd->isReadableFile($path . $filename)) {
                        // определяем ссылку на папку объектов из папки модуля
                        define('ENGINE_OBJECTS_FOLDER_REFERENCE', '../');
                        // подключаем файл модуля
                        include_once($path . $filename);
                    }
                }

                // если в подключенном модуле существует необходимый класс (модуль - не произвольный код), создаем модуль, передаем ему прочитанные данные
                if ($module != '') {
                    $class = 'Client' . $module;
                    if (class_exists($class)) {
                        $this->module = new $class($this);
                        if (!empty($this->module)) {
                            $this->body = '';
                            $this->module->section = null;   $this->module->section = & $this->section;
                            $this->module->article = null;   $this->module->article = & $this->article;
                            $this->module->news_item = null; $this->module->news_item = & $this->news_item;
                            $this->module->category = null;  $this->module->category = & $this->category;
                            $this->module->brand = null;     $this->module->brand = & $this->brand;
                            $this->module->product = null;   $this->module->product = & $this->product;
                        }
                    }
                }

                // в цикле подключаем заявленные плагины, если какой-то возвращает FALSE, берем его контент, удаляем текущий модуль и прерываем цикл
                foreach ($objects as $object) {
                    $object = preg_replace('!/:\\\\!', '', $object);
                    $object = trim($object);
                    if ($object != '') {
                        $item = null;
                        $params = new stdClass;
                        $params->class = $object;
                        $params->enabled = 1;
                        $params->plugin = 1;
                        $this->db->get_module($item, $params);
                        if (!empty($item) || $this->extensible) {
                            $filename = isset($item->filename) ? trim($item->filename) : '';
                            $filename = preg_replace('!/:\\\\!', '', $filename);
                            $filename = trim($filename);
                            if ($filename == '') $filename = $object . '.php';
                            // ищем плагин в ядре системы
                            $path = dirname(__FILE__) . '/../';
                            if ($this->hdd->isReadableFile($path . $filename)) {
                                include_once($path . $filename);
                            } else {
                                // иначе ищем плагин в папке плагина
                                $path .= $this->text->lowerCase($object) . '/';
                                if ($this->hdd->isReadableFile($path . $filename)) {
                                    // определяем ссылку на папку объектов из папки плагина
                                    if (!defined('ENGINE_OBJECTS_FOLDER_REFERENCE')) define('ENGINE_OBJECTS_FOLDER_REFERENCE', '../');
                                    // подключаем файл плагина
                                    include_once($path . $filename);
                                }
                            }
                            if ($object != '') {
                                $class = 'Client' . $object;
                                if (class_exists($class)) {
                                    $plugin = new $class($this);
                                    if (!empty($plugin)) {
                                        if ($plugin->fetch($this->module) === FALSE) {
                                            $this->body = & $plugin->body;
                                            $this->module = null;
                                            $this->headerError404();
                                            break;
                                        } else {
                                            $this->smarty->assignByRef('plugin_' . strtolower($object), $plugin->body);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // следующее выполняем только для перезагружаемых страниц
                // (то есть не читаем лишнее, если страница открывается вспомогательным блоком поверх основной)
                if (!$this->quick_content) {

                    // читаем список статей, просмотренных в текущем сеансе, и передаем в шаблонизатор
                    $field = 'recent_articles';
                    $this->session->restoreIdsArrayFromCookie($field);
                    if (!in_array('*', $list) && !in_array('recent_articles', $list)) {
                        $recent_articles = array();
                        if ($this->request->isSessionArray($field)) {
                            foreach ($_SESSION[$field] as $item) {
                                $params = new stdClass;
                                $params->enabled = 1;
                                if (!isset($this->user->user_id)) $params->hidden = 0;
                                $params->id = $item;
                                $this->db->get_article($item, $params);
                                if (!empty($item)) $recent_articles[] = $item;
                            }
                        }
                        $this->smarty->assignByRef('recent_articles', $recent_articles);
                    }

                    // читаем список новостей, просмотренных в текущем сеансе, и передаем в шаблонизатор
                    $field = 'recent_news';
                    $this->session->restoreIdsArrayFromCookie($field);
                    if (!in_array('*', $list) && !in_array('recent_news', $list)) {
                        $recent_news = array();
                        if ($this->request->isSessionArray($field)) {
                            foreach ($_SESSION[$field] as $item) {
                                $params = new stdClass;
                                $params->enabled = 1;
                                if (!isset($this->user->user_id)) $params->hidden = 0;
                                $params->id = $item;
                                $this->db->news->one($item, $params);
                                if (!empty($item)) $recent_news[] = $item;
                            }
                        }
                        $this->smarty->assignByRef('recent_news', $recent_news);
                    }

                    // читаем список категорий, просмотренных в текущем сеансе, и передаем в шаблонизатор
                    $field = 'recent_categories';
                    $this->session->restoreIdsArrayFromCookie($field);
                    if (!in_array('*', $list) && !in_array('recent_categories', $list)) {
                        $recent_categories = array();
                        if ($this->request->isSessionArray($field)) {
                            foreach ($_SESSION[$field] as $item) {
                                $params = new stdClass;
                                $params->enabled = 1;
                                if (!isset($this->user->user_id)) $params->hidden = 0;
                                $params->id = $item;
                                $this->db->get_category($item, $params);
                                if (!empty($item)) $recent_categories[] = $item;
                            }
                        }
                        $this->smarty->assignByRef('recent_categories', $recent_categories);
                    }

                    // читаем список брендов, просмотренных в текущем сеансе, и передаем в шаблонизатор
                    $field = 'recent_brands';
                    $this->session->restoreIdsArrayFromCookie($field);
                    if (!in_array('*', $list) && !in_array('recent_brands', $list)) {
                        $recent_brands = array();
                        if ($this->request->isSessionArray($field)) {
                            foreach ($_SESSION[$field] as $item) {
                                $params = new stdClass;
                                $params->enabled = 1;
                                if (!isset($this->user->user_id)) $params->hidden = 0;
                                $params->id = $item;
                                $this->db->get_brand($item, $params);
                                if (!empty($item)) $recent_brands[] = $item;
                            }
                        }
                        $this->smarty->assignByRef('recent_brands', $recent_brands);
                    }

                    // читаем список товаров, просмотренных в текущем сеансе, и передаем в шаблонизатор
                    $field = 'recent_products';
                    $this->session->restoreIdsArrayFromCookie($field);
                    if (!in_array('*', $list) && !in_array('recent_products', $list)) {
                        $recent_products = array();
                        if ($this->request->isSessionArray($field)) {
                            foreach ($_SESSION[$field] as $item) {
                                $params = new stdClass;
                                $params->id = $item;
                                $params->discount = $discount;
                                if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
                                $params->enabled = 1;
                                if (!isset($this->user->user_id)) $params->hidden = 0;
                                $params->section = $this->now_in_section;
                                $this->db->products->one($item, $params);
                                if (!empty($item)) $recent_products[] = $item;
                            }
                        }
                        $this->smarty->assignByRef('recent_products', $recent_products);
                    }
                }

                // читаем список незапрещенных кредитных программ и передаем в шаблонизатор
                if (!in_array('*', $list) && !in_array('credit_programs', $list)) {
                    $credits = null;
                    $params = new stdClass;
                    $params->sort = SORT_CREDITPROGRAMS_MODE_BY_TERM;
                    $params->sort_direction = SORT_DIRECTION_ASCENDING;
                    $params->sort_laconical = 1;
                    $params->enabled = 1;
                    $this->db->credit_programs->get($credits, $params);
                    $this->db->credit_programs->unpackRecords($credits);
                    $this->smarty->assignByRef('credit_programs', $credits);
                }

            // иначе модуль не был задан
            } else {
                $this->body = CONTENT_MESSAGE_NO_PAGE;
                $this->headerError404();
            }
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

            // открываем трассировку этого метода
            $this->db->open_tracing_method('CLIENT_PAGE fetch');

            // обрабатываем входные параметры
            $this->process();

            // получаем список исключений упреждающего наполнения шаблонизируемых переменных
            // (то есть если в эмуляторе шаблона объявили, какие переменные будут наполнять сами)
            $list = array();
            if (!empty($this->designer->not_preassignable) && is_array($this->designer->not_preassignable)) $list = & $this->designer->not_preassignable;

            // читаем историю поиска и передаем в шаблонизатор
            if (!in_array('*', $list) && !in_array('search_history', $list)) {
                $history = $this->history->getSearchHistory();
                $this->smarty->assignByRef('search_history', $history);
            }

            // передаем шаблонизатору части контента
            $this->assignPageTypicalVars();

            // если модуль не был неким произвольным кодом,
            //   создаем контент модуля,
            //   передаем части контента в модуль страницы,
            //   если модуль требовал рисовать его без внешнего оформления страницы, выходим
            if (!is_null($this->module)) {
                $this->module->fetch($this);
                $this->refillPageTypicalVars($this->module);
                $this->body = & $this->module->body;
                if (!empty($this->module->single)) {
                    $this->db->close_tracing_method();
                    return FALSE;
                }
            }

            // если во входных параметрах была заявка на прорисовку модуля без перезагрузки страницы, выходим
            if (!empty($this->quick_content)) {
                $this->db->close_tracing_method();
                return FALSE;
            }

            // передаем шаблонизатору части контента
            $this->smarty->assignByRef('content', $this->body);

            // создаем контент страницы
            $template = is_array($this->template) ? reset($this->template) : $this->template;
            $this->smarty->fetchByTemplate($this, $template, 'index');

            // закрываем трассировку этого метода
            $this->db->close_tracing_method();
            return TRUE;
        }
    }



    return;
?>