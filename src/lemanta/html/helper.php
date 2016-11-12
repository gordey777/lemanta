<?php /* ==========================================================================
                                                                                  |
    Скрипт: Хелпер шаблона.                                                       |
    ----------------------------------------------------------------------------  |
                                                                                  |
    Служит цели снабдить шаблон какими-либо дополнительными шаблонизационными     |
    функциями или переопределить дефолтные функции. Сейчас содержит студийный     |
    набор функций, назначение которых в предельном упрощении кода верстки в       |
    файлах шаблона.                                                               |
                                                                                  |
    ----------------------------------------------------------------------------  |
    Impera CMS - лёгкий и быстрый скрипт сайта с потрясающими возможностями.      |
    Мы создаём мощные решения с минимальным кодом и высокой скоростью загрузки.   |
                                                                                  |
================================================================================ */

    /* ============================================================================
    |                                                                             |
    |   Загрузка расширения хелпера (коммерческие модули), если есть.             |
    |                                                                             |
    ============================================================================ */

    $file = dirname(__FILE__) . '/mod-helper.php';
    if (file_exists($file)) require_once($file);
    if (!class_exists('TemplateEmulatorMods')) {
        class TemplateEmulatorMods {
            protected function setSmartyPlugins ( & $cms ) { }
        }
    }

    /* ============================================================================
    |                                                                             |
    |   Теперь сам хелпер.                                                        |
    |                                                                             |
    ============================================================================ */

    class TemplateEmulator extends TemplateEmulatorMods {
        protected $cms = null;

        /* ========================================================================
        |                                                                         |
        |    Указываем, для каких из предопределенных переменных шаблона (типа    |
        |    категорий, брендов, недавно просмотренных страниц и тому подобное)   |
        |    мы желаем отменить упреждающее наполнение, чтобы не расходовать      |
        |    бесцельно ресурсы сайта на извлечение тех данных, которые мы вообще  |
        |    не используем в этом шаблоне сайта.                                  |
        |                                                                         |
        ======================================================================== */

        public $not_preassignable = array(
            // '*',                 // вообще отклонить наполнение

            // 'categories',        // отклонить наполнение категорий
            'all_brands',           // отклонить наполнение брендов
            'menus',                // отклонить наполнение менюшек
            'news',                 // отклонить наполнение анонсового списка новостей
            'articles',             // отклонить наполнение анонсового списка статей
            // 'cart_products',     // отклонить наполнение товаров корзины
            'defer_products',       // отклонить наполнение отложенных товаров
            'banners',              // отклонить наполнение баннеров
            'recent_articles',      // отклонить наполнение недавно посещенных статей
            'recent_news',          // отклонить наполнение недавно посещенных новостей
            'recent_categories',    // отклонить наполнение недавно посещенных категорий
            'recent_brands',        // отклонить наполнение недавно посещенных брендов
            // 'recent_products',   // отклонить наполнение недавно посещенных товаров
            'search_history',       // отклонить наполнение истории поиска

            'dummy'                 // фиктивная строка (для безопасного комментирования предыдущих)
        );

        /* ========================================================================
        |                                                                         |
        |  SEO-шные исправления.                                                  |
        |  ---------------------------------------------------------------------  |
        |                                                                         |
        |  Чтобы не напрягать базу каждый раз, выполняются разово, когда          |
        |  потребуется. Для этого комментируем первый return и обновляем в        |
        |  браузере страницу сайта (F5).                                          |
        |                                                                         |
        |  ---------------------------------------------------------------------  |
        |  После такого разового выполнения следует раскомментировать return,     |
        |  чтобы эти исправления более не срабатывали.                            |
        |                                                                         |
        ======================================================================== */

        private function seoFixes () {
            return;

            // очищаем мета ключевые слова
            if (FALSE) {
                $this->cms->db->query('UPDATE `sections` SET `meta_keywords` = "";');
                $this->cms->db->query('UPDATE `articles` SET `meta_keywords` = "";');
                $this->cms->db->query('UPDATE `news` SET `meta_keywords` = "";');
                $this->cms->db->query('UPDATE `categories` SET `meta_keywords` = "";');
                $this->cms->db->query('UPDATE `brands` SET `meta_keywords` = "";');
                $this->cms->db->query('UPDATE `products` SET `meta_keywords` = "";');
            }

            // урлы в нижний регистр, подчеркивания заменить дефисами
            $this->cms->db->query('UPDATE `sections` SET `url` = LCASE(REPLACE(`url`, "_", "-"));');
            $this->cms->db->query('UPDATE `articles` SET `url` = LCASE(REPLACE(`url`, "_", "-"));');
            $this->cms->db->query('UPDATE `news` SET `url` = LCASE(REPLACE(`url`, "_", "-"));');
            $this->cms->db->query('UPDATE `categories` SET `url` = LCASE(REPLACE(`url`, "_", "-"));');
            $this->cms->db->query('UPDATE `brands` SET `url` = LCASE(REPLACE(`url`, "_", "-"));');
            $this->cms->db->query('UPDATE `products` SET `url` = LCASE(REPLACE(`url`, "_", "-"));');
        }

        /* ========================================================================
        |                                                                         |
        |  Регистрация наших шаблонизационных функций.                            |
        |                                                                         |
        ======================================================================== */

        protected function setSmartyPlugins ( & $cms ) {

            // -------------------------------------------------------------------------------------------------
            // SEO-шные фиксы (чтобы не напрягать базу каждый раз, выполняются разово, а потом закомментируются)
            // -------------------------------------------------------------------------------------------------
            //
            //     Все урлы в нижнем регистре, подчеркивания заменить на дефисы
            //
            // $cms->db->query('UPDATE sections SET url = LCASE(REPLACE(url, "_", "-"));');
            // $cms->db->query('UPDATE articles SET url = LCASE(REPLACE(url, "_", "-"));');
            // $cms->db->query('UPDATE news SET url = LCASE(REPLACE(url, "_", "-"));');
            // $cms->db->query('UPDATE categories SET url = LCASE(REPLACE(url, "_", "-"));');
            // $cms->db->query('UPDATE brands SET url = LCASE(REPLACE(url, "_", "-"));');
            // $cms->db->query('UPDATE products SET url = LCASE(REPLACE(url, "_", "-"));');
            // -------------------------------------------------------------------------------------------------

            parent::setSmartyPlugins($cms);
            $items = array('version',              // вывести номер версии движка
                           'versionYMD',           // вывести ДАТА-номер версии
                           'implantJS',            // имплантировать содержимое JS-скрипта
                           'implantCSS',           // имплантировать содержимое CSS
                           'header302',            // отправить серверный заголовок 302 Moved Temporarily
                           'header200',            // отправить серверный заголовок 200 OK
                           'headerLastModified',   // отправить серверный заголовок Last-Modified
                           'headerExpires',        // отправить серверный заголовок Expires
                           'metaDescription',      // вывести мета описание страницы
                           'metaKeywords',         // вывести мета ключевые слова страницы
                           'siteName',             // вывести название сайта
                           'configParam',          // вывести конфигурационный параметр
                           'configCommaList',      // получить конфиг параметр как массив строк
                           'itemTitle',            // вывести мета тайтл записи
                           'phone',                // вывести телефон, указанный в конфиге сайта
                           'email',                // вывести емейл, указанный в конфиге
                           'telegramm',            // вывести Telegramm-номер, указанный в конфиге
                           'skype',                // вывести скайп, указанный в конфиге
                           'icq',                  // вывести ICQ, указанный в конфиге
                           'facebook',             // вывести адрес страницы Facebook из конфига
                           'vkontakte',            // вывести адрес страницы ВКонтакте из конфига
                           'twitter',              // вывести адрес страницы Twitter из конфига
                           'google',               // вывести адрес страницы Google+ из конфига
                           'instagram',            // вывести адрес страницы Instagram из конфига
                           'linkedin',             // вывести адрес страницы LinkedIn из конфига
                           'pinterest',            // вывести адрес страницы Pinterest из конфига
                           'year',                 // вывести текущий год
                           'counters',             // вывести коды счетчиков
                           'titleSearch',          // вывести заголовок страницы поиска
                           'pagination',           // вывести пагинацию страниц
                           'centralTemplate',      // признать файл шаблона не самостоятельной страницей
                           'getLastPageUrl',       // вывести URL последней страницы списка
                           'stopPage',             // остановить рендеринг страницы с отправкой желаемого ответа
                           'categories');          // извлечь дерево категорий/брендов
            foreach ($items as $name) {
                $cms->smarty->registerPlugin('function', $name, array($this, $name));
            }
            $cms->smarty->assignByRef('emulator', $this);
        }

        /* ========================================================================
        |                                                                         |
        |  Обработчики наших функций.                                             |
        |                                                                         |
        ======================================================================== */

        public function version ( $params = null, & $smarty = null ) {
            $value = $this->getConst('IMPERA_CMS_CURRENT_MMVERSION');
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function versionYMD ( $params = null, & $smarty = null ) {
            $value = $this->getConst('IMPERA_CMS_CURRENT_VERSION');
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function implantJS ( $params = null, & $smarty = null ) {
            $value = $this->getVar('text', $smarty);
            $value = $this->mustbeString($value);
            $value = $this->removeComments($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function implantCSS ( $params = null, & $smarty = null ) {
            $value = $this->getVar('text', $smarty);
            $value = $this->mustbeString($value);
            $value = $this->removeComments($value);
            $value = preg_replace('!([;:,\{\}\(~>])\s!u', '$1', $value);
            $value = preg_replace('!\s([\{\}\)~>])!u', '$1', $value);
            $value = preg_replace('!;\}!u', '}', $value);
            $url = trim($this->cms->theme_url);
            $value = preg_replace('!(url ?\( ?["\']?)../!u', '$1' . $url, $value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function header302 ( $params = null, & $smarty = null ) {
            ob_clean();
            $site = trim($this->cms->site_url);
            $url = $this->paramAsSentence('url', $params);
            if ($url == '') {
                $url = $site;
            } else if (!preg_match('/^https?:/i', $url)) {
                $url = $site . ltrim($url, '/\\ ');
            }
            /* @ header('HTTP/1.1 302 Found', TRUE, 302); */
            @ header('HTTP/1.0 302 Moved Temporarily', TRUE, 302);
            @ header('Location: ' . $url);
            $this->cms->security->stop();
            return '';
        }

        public function header200 ( $params = null, & $smarty = null ) {
            @ header('HTTP/1.1 200 OK', TRUE, 200);
            return '';
        }

        public function headerLastModified ( $params = null, & $smarty = null ) {
            $hours = $this->paramAsInteger('plus', $params);
            $time = time() + $hours * 3600;
            @ header('Last-Modified: ' . date('r', $time), TRUE);
            return '';
        }

        public function headerExpires ( $params = null, & $smarty = null ) {
            $hours = $this->paramAsNaturalExtended('plus', $params, 1);
            $time = time() + $hours * 3600;
            @ header('Expires: ' . date('r', $time), TRUE);
            @ header('Cache-Control: public', TRUE);
            @ header('Pragma: public', TRUE);
            return '';
        }

        public function metaDescription ( $params = null, & $smarty = null ) {
            $value = $this->getVar('description', $smarty);
            $value = $this->mustbeString($value);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function metaKeywords ( $params = null, & $smarty = null ) {
            $value = $this->getVar('keywords', $smarty);
            $value = $this->mustbeString($value);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function siteName ( $params = null, & $smarty = null ) {
            $value = $this->cms->any->settings->getAsSentence('site_name');
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function configParam ( $params = null, & $smarty = null ) {
            $param = $this->paramAsString('name', $params);
            $value = $this->getConfig($param);
            if ($value == '') $value = $this->paramAsString('def', $params);
            return $this->assignVar($params, $value, $smarty);
        }

        public function configCommaList ( $params = null, & $smarty = null ) {
            $param = $this->paramAsString('name', $params);
            $value = $this->getConfig($param);
            $items = explode(',', $value);
            $value = array();
            foreach ($items as $item) {
                $item = trim($item);
                if ($item != '') $value[] = $item;
            }
            if (empty($value)) $value = $this->paramAsArray('def', $params);
            return $this->assignVar($params, $value, $smarty);
        }

        public function itemTitle ( $params = null, & $smarty = null ) {
            /* $names = array('meta_title', 'model', 'header', 'name'); */
            $names = array('model', 'header', 'name', 'meta_title');
            $value = $this->retrieveItemField($names, $params, $smarty);
            return $this->assignVar($params, $value, $smarty);
        }

        public function phone ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('phone', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function email ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('email', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function telegramm ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('telegramm', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function skype ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('skype', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function icq ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('icq', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function facebook ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('facebook', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function vkontakte ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('vkontakte', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function twitter ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('twitter', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function google ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('google', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function instagram ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('instagram', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function linkedin ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('linkedin', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function pinterest ( $params = null, & $smarty = null ) {
            $value = $this->getConfigNumerated('pinterest', $params);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function year ( $params = null, & $smarty = null ) {
            $value = date('Y', time());
            return $this->assignVar($params, $value, $smarty);
        }

        public function counters ( $params = null, & $smarty = null ) {
            $value = $this->cms->any->settings->get('counters', '');
            return $this->assignVar($params, $value, $smarty);
        }

        public function titleSearch ( $params = null, & $smarty = null ) {
            $value = $this->getVar('search_title', $smarty);
            $value = $this->mustbeString($value);
            $value = $this->asAttribute($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function pagination ( $params = null, & $smarty = null ) {
            $value = $this->getVar('PagesNavigation', $smarty);
            $value = $this->mustbeString($value);
            return $this->assignVar($params, $value, $smarty);
        }

        public function centralTemplate ( $params = null, & $smarty = null ) {
            $this->cms->quick_content = FALSE;
            return '';
        }

        public function getLastPageUrl ( $params = null, & $smarty = null ) {
            $site = trim($this->cms->site_url);
            $value = $this->paramAsString('from', $params);
            if (empty($value)) {
                $value = $site;
            } else {
                $pattern = '!^https?:[/\\\\]+!i';
                if (!preg_match($pattern, $value)) {
                    $site = explode('/', $site);
                    while (count($site) > 3) array_pop($site);
                    $site = implode('/', $site);
                    $value = $site . '/' . ltrim($value, '/\\ ');
                }
                try {
                    $data = @ file_get_contents($value . '?ajax=1&getlastpage=1');
                    if (is_string($data)) {
                        if (preg_match($pattern, $data)) $value = $data;
                    }
                } catch (Exception $e) { }
            }
            return $this->assignVar($params, $value, $smarty);
        }

        public function stopPage ( $params = null, & $smarty = null ) {
            $value = $this->paramAsString('msg', $params);
            ob_clean();
            $this->cms->security->stop($value, 200);
        }

        public function categories ( $params = null, & $smarty = null ) {
            $counters = $this->paramAsBoolean('counters', $params, TRUE);
            $ids = $this->paramAsBoolean('ids', $params);
            $sort = $this->paramAsBoolean('sort', $params, TRUE);

            $name = $this->paramAsSentence('table', $params);
            switch ($this->cms->text->lowerCase($name)) {
                case 'brands':
                    $idfield = 'brand_id';
                    $dbtable = 'brands';
                    $subfield = 'subbrands';
                    $active = isset($this->cms->brand)
                           && isset($this->cms->brand->$idfield) ? $this->cms->brand->$idfield : 0;
                    break;
                case 'categories':
                default:
                    $idfield = 'category_id';
                    $dbtable = 'categories';
                    $subfield = 'subcategories';
                    $active = isset($this->cms->category)
                           && isset($this->cms->category->$idfield) ? $this->cms->category->$idfield : 0;
            }

            $active = $this->paramAsInteger('active', $params, $active);

            $query = 'SELECT * '
                   . 'FROM `' . $dbtable . '` '
                   . 'ORDER BY ' . ($sort ? '' : '`order_num` DESC, ')
                                 . '`name` ASC;';
            $result = $this->cms->db->query($query);

            $items = array();
            if (!empty($result)) {
                $hidden = !$this->existsUser();
                $categories = array();
                while ($row = $this->cms->db->fetch_object($result)) {
                    $me = intval($row->$idfield);
                    if (!empty($me)) {
                        $i = explode(',',  $row->parents);
                        array_unshift($i, $row->parent);

                        $parent = array();
                        foreach ($i as $id) {
                            if (trim($id) == '') continue;
                            $id = intval($id);
                            if ($id == $me) $id = 0;
                            $parent[$id] = $id;
                        }
                        sort($parent, SORT_NUMERIC);

                        // $parent = intval($row->parent);
                        // if ($parent == $me) $parent = 0;

                        $row->name = trim($row->name);
                        if ($row->name == '') $row->name = 'Без названия, ИД = ' . $me;
                        if (!empty($row->enabled) && (!$hidden || empty($row->hidden))) {
                            $this->cms->db->fix_categories_record($row);
                        } else {
                            $i = new stdClass;
                            $i->$idfield = $row->$idfield;
                            $i->parent = $row->parent;
                            $i->name = $row->name;
                            $i->url = $row->url;
                            $i->url_special = $row->url_special;
                            $i->enabled = FALSE;
                            $row = $i;
                        }

                        $row->filled = FALSE;
                        if ($counters) {
                            $row->products_count = 0;
                            $row->my_products_count = 0;
                        }
                        $row->active = $me == $active;

                        if (!isset($categories[$me])) {
                            $row->$subfield = array();
                            $categories[$me] = $row;
                        } elseif (!isset($categories[$me]->$idfield)) {
                            foreach ($row as $i => & $v) $categories[$me]->$i = $v;
                        }

                        if (!empty($parent)) {
                            foreach ($parent as $i) {
                                if (!isset($categories[$i])) {
                                    $categories[$i] = new stdClass;
                                    $categories[$i]->enabled = TRUE;
                                    if ($counters) {
                                        $categories[$i]->products_count = 0;
                                        $categories[$i]->my_products_count = 0;
                                    }
                                    $categories[$i]->filled = FALSE;
                                    $categories[$i]->$subfield = array();
                                }
                                $ptr = & $categories[$i]->$subfield;
                                if (!isset($ptr[$me])) $ptr[$me] = & $categories[$me];
                            }
                        }
                    }
                }
                $this->cms->db->free_result($result);

                if ($ids) {
                    $query = 'SET group_concat_max_len = 131072;';
                    $this->cms->db->query($query);
                }
                $query = 'SELECT `' . $idfield . '` '
                              . ($counters ? ', COUNT(`' . $idfield . '`) AS `count` ' : '')
                              . ($ids ? ', GROUP_CONCAT(DISTINCT `product_id` ORDER BY `product_id` SEPARATOR ",") AS `ids` ' : '')
                       . 'FROM `products` '
                       . 'WHERE `enabled` = 1 AND `' . $idfield . '` != 0 ' . ($hidden ? 'AND `hidden` = 0 ' : '')
                       . 'GROUP BY `' . $idfield . '`;';
                $result = $this->cms->db->query($query);

                if (!empty($result)) {
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $parent = intval($row->$idfield);
                        if (!empty($parent)) {
                            if (!isset($categories[$parent])) {
                                $categories[$parent] = new stdClass;
                                $categories[$parent]->enabled = TRUE;
                                $categories[$parent]->filled = TRUE;
                                $categories[$parent]->$subfield = array();
                            }

                            if (!isset($categories[$parent]->products)) {
                                if ($counters) {
                                    $categories[$parent]->products_count = $row->count;
                                    $categories[$parent]->my_products_count = $row->count;
                                }
                                $categories[$parent]->products = $ids ? $row->ids : '';
                                if ($counters) {
                                    $categories[$parent]->filled = TRUE;
                                    $i = $parent;
                                    while (($i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0) != 0) {
                                        $categories[$i]->products_count += $row->count;
                                        $categories[$i]->filled = TRUE;
                                    }
                                } else {
                                    $i = $parent;
                                    while (!empty($i) && !$categories[$i]->filled) {
                                        $categories[$i]->filled = TRUE;
                                        $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                                    }
                                }
                            }
                        }
                    }
                    $this->cms->db->free_result($result);
                }

                $any = $this->paramAsBoolean('any', $params);
                foreach ($categories as $i => & $v) {
                    if (!empty($v->enabled) && ($any || !empty($v->filled) || !empty($v->informative))) {
                        if (isset($v->$idfield) && empty($v->parent)) {
                            $items[$i] = & $categories[$i];
                        } elseif (!empty($i) && !isset($v->$idfield)) {
                            $categories[$i]->$idfield = $i;
                            $categories[$i]->parent = 0;
                            $categories[$i]->enabled = TRUE;
                            $categories[$i]->name = 'Несуществующая (выпавшая) запись, ИД = ' . $i;
                            $categories[$i]->url = $i;
                            $categories[$i]->url_special = FALSE;
                            $categories[$i]->active = $i == $active;
                            $categories[$i]->bad = TRUE;
                            $items[$i] = & $categories[$i];
                        }
                        if (empty($v->active) && !empty($v->$subfield)) {
                            foreach ($v->$subfield as $i) {
                                if (!empty($i->active)) {
                                    $v->active = TRUE;
                                    break;
                                }
                            }
                        }
                        if (!empty($v->active)) {
                            $i = $v->parent;
                            while (!empty($i) && !$categories[$i]->active) {
                                $categories[$i]->active = TRUE;
                                $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                            }
                        }
                    }
                }
            }
            return $this->assignVar($params, $items, $smarty);
        }

        /* ========================================================================
        |                                                                         |
        |  Функции объекта $emulator.                                             |
        |                                                                         |
        ======================================================================== */

        public function checkNoPage () {
            return $this->getConst('CONTENT_MESSAGE_NO_PAGE') === $this->getVar('content');
        }

        public function checkNoModule () {
            $v = $this->getConst('CONTENT_MESSAGE_NO_MODULE');
                $v = preg_replace('/([~#:\+\[\]\{\}\(\)\?\.\$\^\|\\\\])/u', '\\\\$1', $v);
                $v = preg_replace('/\*/u', '[a-z0-9_]+', $v);
            return preg_match('~^' . $v . '$~iu', $this->getVar('content')) > 0;
        }

        public function existsModule ( $file ) {
            $file = $this->cms->hdd->safeFilename($file);
            if (empty($file)) return FALSE;
            $ext = explode('.', $file);
            if (count($ext) < 2) return FALSE;
            $ext = array_pop($ext);
            $ext = $this->cms->text->lowerCase($ext);
            if (!in_array($ext, array('tpl', 'htm', 'html', 'xml', 'css', 'js', 'txt'))) return FALSE;
            return $this->cms->hdd->isReadableFile(dirname(__FILE__) . '/' . $file);
        }

        public function existsUser () {
            return isset($this->cms->user->user_id) && !empty($this->cms->user->user_id);
        }

        /* ========================================================================
        |                                                                         |
        |  Системные методы.                                                      |
        |                                                                         |
        ======================================================================== */

        public function __construct ( & $cms ) {
            $this->cms = & $cms;

            $test = $this->cms->request->getServerAsSentence('REQUEST_URI');
            $uri = preg_replace('![/\\\\]+!u', '/', $test);
            if ($test != $uri) {
                @ header('HTTP/1.1 301 Moved Permanently');
                @ header('Location: ' . $uri);
                $this->cms->security->stop();
            }

            $field = 'page';
            $valueR = $this->cms->request->getRequestAsInteger($field);
            if ($valueR > 0) {
                $valueG = $this->cms->request->getGetAsInteger($field);
                    if ($valueG > 0) $_GET[$field] = $valueG - 1;
                $valueP = $this->cms->request->getPostAsInteger($field);
                    if ($valueP > 0) $_POST[$field] = $valueP - 1;
                $_REQUEST[$field] = $valueR - 1;
            }

            $this->seoFixes();
            $this->setSmartyPlugins($cms);
        }

        private function getConst ( $name, $def = '' ) {
            return defined($name) ? constant($name) : $def;
        }

        private function getVar ( $name, & $smarty = null, $def = null ) {
            if (!is_null($smarty)) {
                $value = $smarty->getTemplateVars($name);
                if (!is_null($value)) return $value;
            }
            $value = $this->cms->smarty->getTemplateVars($name);
            if (!is_null($value)) return $value;
            return $def;
        }

            private function maybeIfEmpty ( & $value, & $params ) {
                if ($value == '') {
                    $value = $this->paramAsIs('ifempty', $params);
                    $value = $this->mustbeString($value);
                }
            }

            private function retrieveFrom ( & $params, $def = '' ) {
                return $this->paramAsSentence('from', $params, $def);
            }

        private function getField ( $name, & $var, $def = null ) {
            if (is_object($var)) return isset($var->$name) ? $var->$name : $def;
            return is_array($var) && isset($var[$name]) ? $var[$name] : $def;
        }

            private function retrieveField ( $name, & $item, & $params ) {
                if (empty($name)) return '';
                if (is_string($name)) $name = array($name);
                if (!is_array($name)) return '';
                $def = TRUE;
                foreach ($name as $field) {
                    $value = $this->getField($field, $item);
                    if (!is_null($value)) $def = FALSE;
                    $value = $this->mustbeString($value);
                    $value = trim($value);
                    if ($value != '') break;
                }
                if ($def) {
                    $value = $this->paramAsIs('def', $params);
                    $value = $this->mustbeString($value);
                }
                $this->maybeIfEmpty($value, $params);
                return $this->proposeAttribute($value, $params);
            }

            private function retrieveItemField ( $names, & $params, & $smarty ) {
                $varname = $this->retrieveFrom($params, 'item');
                $value = $this->getVar($varname, $smarty);
                return $this->retrieveField($names, $value, $params);
            }

        private function getConfig ( $name, $def = '' ) {
            return isset($this->cms->config->$name) ? trim($this->cms->config->$name) : $def;
        }

        private function getConfigNumerated ( $name, & $params ) {
            $num = $this->paramAsNatural('num', $params);
            $value = $this->getConfig($name . $num);
            if ($value == '' && $num == 1) $value = $this->getConfig($name);
            return $value;
        }

        private function existsParamAsString ( $name, & $params, $mustbe = '' ) {
            $state = !empty($params[$name]) && is_string($params[$name]);
            if ($state && $mustbe != '') $state = $params[$name] == $mustbe;
            return $state;
        }

        private function paramAsIs ( $name, & $params, $def = null ) {
            return isset($params[$name]) ? $params[$name] : $def;
        }

            private function paramAsBoolean ( $name, & $params, $def = FALSE ) {
                return isset($params[$name]) ? $params[$name] == TRUE : $def;
            }

            private function paramAsString ( $name, & $params, $def = '' ) {
                return isset($params[$name]) ? trim($params[$name]) : $def;
            }

                private function paramAsSentence ( $name, & $params, $def = '' ) {
                    $def = $this->paramAsString($name, $params, $def);
                    return $this->cms->request->getAsSentence($def);
                }

            private function paramAsInteger ( $name, & $params, $def = 0 ) {
                return isset($params[$name]) ? intval($params[$name]) : $def;
            }

            private function paramAsNatural ( $name, & $params, $def = 1 ) {
                $value = isset($params[$name]) ? intval($params[$name]) : $def;
                return max(1, $value);
            }

            private function paramAsNaturalExtended ( $name, & $params, $def = 0 ) {
                return isset($params[$name]) ? max(0, intval($params[$name])) : $def;
            }

            private function paramAsArray ( $name, & $params, $def = array() ) {
                return isset($params[$name]) && is_array($params[$name]) ? $params[$name] : $def;
            }

        private function asAttribute ( & $value ) {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

            private function proposeAttribute ( & $value, & $params ) {
                return $this->paramAsBoolean('safe', $params, TRUE) ? $this->asAttribute($value)
                                                                    : $value;
            }

        private function mustbeString ( & $value, $def = '' ) {
            return is_string($value) ? $value : $def;
        }

        private function removeComments ( & $value ) {
            $value = preg_replace('!/\*.+?\*/!su', ' ', $value);
            return preg_replace('!\s+!u', ' ', $value);
        }

        private function assignVar ( & $params, & $value, & $smarty, $defname = '' ) {
            if (!is_object($smarty)) return $value;
            $varname = $this->existsParamAsString('var', $params)
                           ? trim($params['var'])
                           : ($this->existsParamAsString('assign', $params)
                               ? trim($params['assign'])
                               : ($this->existsParamAsString('result', $params)
                                   ? trim($params['result'])
                                   : trim($defname)));
            if (empty($varname)) return $value;
            $smarty->assignByRef($varname, $value);
            if ($this->existsParamAsString('scope', $params, 'global')) {
                $this->cms->smarty->assignByRef($varname, $value);
            }
            return '';
        }
    }

    return;
?>