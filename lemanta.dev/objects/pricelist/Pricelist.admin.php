<?php
    // =======================================================================
    /**
    *  Админ модуль таблицы товаров
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемой таблицы записей
    require_once(dirname(__FILE__) . '/../.ref-models/AdminTable.php');

    // текст заголовка страницы модуля
    define('PRICELIST_PAGE_TITLE', 'Таблица товаров');

    // имя файла шаблона модуля
    define('PRICELIST_TEMPLATE_FILENAME', 'pricelist/pricelist.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('PRICELIST_MODULELINK_POINTER', 'Pricelist');
    define('PRICELIST_MODULETAB_TEXT', 'прайс');
    define('PRICELIST_MODULEMENU_PATH', 'Товары / Таблица товаров');



    // =======================================================================
    /**
    *  Админ модуль таблицы товаров
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Pricelist extends AdminTableREFModel {

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = DATABASE_PRODUCTS_TABLENAME;
        protected $id_field = 'product_id';

        // имя модели базы данных
        protected $dbmodel = 'products';

        // имя файла шаблона
        protected $template = PRICELIST_TEMPLATE_FILENAME;

        // перечень имен разрешенных команд редактирования записей
        protected $my_actions = array(ACTION_REQUEST_PARAM_VALUE_MASSDELETE);



        // ===================================================================
        /**
        *  Чтение записей таблицы
        *
        *  @access  protected
        *  @param   mixed   $data       дополнительные сведения
        *  @return  array               массив записей
        */
        // ===================================================================

        protected function getRecords ( & $data = null ) {

            // читаем записи категорий
            $category_id = 'category_id';
            $dbtable = DATABASE_CATEGORIES_TABLENAME;
            $query = 'SELECT `' . $category_id . '`, '    // ид категории
                          . '`parent`, '                  // ид родительской категории
                          . '`name`, '                    // название категории
                          . '`url`, '                     // url (относительный)
                          . '`url_special`, '             // признак особого URL
                          . '`ymarket`, '                 // разрешен ли экспорт в Яндекс.Маркет (32 канала)
                          . '`vkontakte`, '               // разрешен ли экспорт ВКонтакте
                          . '`enabled`, '                 // разрешена или нет
                          . '`highlighted`, '             // подсвечена ли на клиентской стороне
                          . '`hidden`, '                  // скрыта ли от неавторизованных
                          . '`rss_disabled`, '            // запрещен ли экспорт в RSS
                          . '`export_disabled`, '         // запрещен ли экспорт во внешние информеры
                          . '`in_prices`, '               // в каких прайсах выводится (8 каналов)
                          . '`own_block`, '               // имеет ли свой блок на главной
                          . '`informative`, '             // является ли информативной страницей
                          . '`template`, '                // имя tpl-шаблона страницы категории
                          . '`order_num` '                // сортировочный вес режима "как расставлены"
                   . 'FROM `' . $dbtable . '` '
                   . 'ORDER BY `order_num` DESC;';
            $result = $this->cms->db->query($query);

            // перебираем результат
            $items = array();
            if (!empty($result)) {
                $ids = array();
                $categories = array();
                while ($row = $this->cms->db->fetch_object($result)) {
                    $me = intval($row->$category_id);
                    if (!empty($me)) {

                        // запоминаем уникальные ИДы категорий
                        $ids[$me] = $me;

                        // распаковываем поля записи
                        $row->name = trim($row->name);
                        if ($row->name == '') $row->name = 'Без названия, ИД = ' . $me;

                        $row->url = trim($row->url);
                        if ($row->url == '') $row->url = $me;
                        $row->url_path = $row->url_special ? '' : 'catalog/';

                        $row->template = trim($row->template);

                        $row->products = array();

                        // если такую еще не использовали
                        if (!isset($categories[$me])) {
                            $row->subitems = array();
                            $categories[$me] = $row;

                        // может когда-то ссылались на такую, копируем в ссылку поля записи
                        } elseif (!isset($categories[$me]->$category_id)) {
                            foreach ($row as $i => & $v) $categories[$me]->$i = $v;
                        }

                        // крепим в использованном к родителю
                        $parent = intval($row->parent);
                        if ($parent == $me) $parent = 0;
                        if (!empty($parent)) {
                            if (!isset($categories[$parent])) {
                                $categories[$parent] = new stdClass;
                                $categories[$parent]->subitems = array();
                            }
                            if (!isset($categories[$parent]->subitems[$me])) $categories[$parent]->subitems[$me] = & $categories[$me];
                        }
                    }
                }

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // читаем записи товаров
                $product_id = 'product_id';
                $brand_id = 'brand_id';
                $dbtable2 = DATABASE_PRODUCTS_TABLENAME;
                $query = 'SELECT `' . $product_id . '`, '     // ид товара
                              . '`' . $category_id . '`, '    // ид категории
                              . '`' . $brand_id . '`, '       // ид бренда
                              . '`canonical_id`, '            // ид канонического товара
                              . '`pcode`, '                   // буквенный код
                              . '`model`, '                   // название
                              . '`url`, '                     // url (относительный)
                              . '`url_special`, '             // признак особого URL
                              . '`hit`, '                     // признак "хит продаж"
                              . '`newest`, '                  // признак "новинка"
                              . '`actional`, '                // признак "акционный"
                              . '`awaited`, '                 // признак "скоро в продаже"
                              . '`ymarket`, '                 // разрешен ли экспорт в Яндекс.Маркет (32 канала)
                              . '`vkontakte`, '               // разрешен ли экспорт ВКонтакте
                              . '`enabled`, '                 // разрешен или нет
                              . '`highlighted`, '             // подсвечен ли на клиентской стороне
                              . '`hidden`, '                  // скрыт ли от неавторизованных
                              . '`rss_disabled`, '            // запрещен ли экспорт в RSS
                              . '`export_disabled`, '         // запрещен ли экспорт во внешние информеры
                              . '`in_prices`, '               // в каких прайсах выводится (8 каналов)
                              . '`commented`, '               // разрешен ли к обсуждению
                              . '`non_usable`, '              // запрещен ли к продаже
                              . '`non_creditable`, '          // запрещен ли к продаже в кредит
                              . '`template`, '                // имя tpl-шаблона страницы товара
                              . '`order_num` '                // сортировочный вес режима "как расставлены"
                       . 'FROM `' . $dbtable2 . '` '
                       . 'WHERE `' . $category_id . '` IN (' . implode(',', $ids) . ') '
                       . 'ORDER BY `order_num` DESC, '
                                . '`model` ASC;';
                $result = $this->cms->db->query($query);

                // перебираем результат
                if (!empty($result)) {
                    $ids = array();
                    $brand_ids = array();
                    $products = array();
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $me = intval($row->$product_id);
                        if (!empty($me)) {

                            // запоминаем уникальные ИДы товаров
                            $ids[$me] = $me;

                            // распаковываем поля записи
                            $row->model = trim($row->model);
                            if ($row->model == '') $row->model = 'Без названия, ИД = ' . $me;

                            $row->url = trim($row->url);
                            if ($row->url == '') $row->url = $me;
                            $row->url_path = $row->url_special ? '' : 'products/';

                                // если позже окажется, что базы брендов нет
                                $row->brand = empty($row->$brand_id) ? '' : 'Без названия, ИД = ' . $row->$brand_id;

                            $row->template = trim($row->template);

                            $row->variants = array();

                            // крепим к категории
                            $parent = intval($row->$category_id);
                            if (!empty($parent)) {
                                if (isset($categories[$parent])) {
                                    $products[$me] = $row;
                                    if (!isset($categories[$parent]->products)) $categories[$parent]->products = array();
                                    $categories[$parent]->products[$me] = & $products[$me];

                                    // запоминаем уникальные ИДы брендов
                                    $parent = intval($row->$brand_id);
                                    if (!empty($parent)) {
                                        $brand_ids[$parent] = $parent;
                                    }
                                }
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // читаем записи брендов
                    $dbtable3 = DATABASE_BRANDS_TABLENAME;
                    $query = 'SELECT `' . $brand_id . '`, '       // ид бренда
                                  . '`name`, '                    // название бренда
                                  . '`order_num` '                // сортировочный вес режима "как расставлены"
                           . 'FROM `' . $dbtable3 . '` '
                           . 'WHERE `' . $brand_id . '` IN (' . implode(',', $brand_ids) . ') '
                           . 'ORDER BY `order_num` DESC, '
                                    . '`name` ASC;';
                    $result = $this->cms->db->query($query);

                    // перебираем результат
                    if (!empty($result)) {
                        $brands = array();
                        while ($row = $this->cms->db->fetch_object($result)) {
                            $me = intval($row->$brand_id);
                            if (!empty($me)) {

                                // распаковываем поля записи
                                $row->name = trim($row->name);
                                if ($row->name == '') $row->name = 'Без названия, ИД = ' . $me;

                                // помещаем бренд в список
                                $brands[$me] = $row;
                            }
                        }

                        // крепим бренды к товарам
                        foreach ($products as $i => & $v) {
                            $me = intval($v->$brand_id);
                            if (!empty($me)) {
                                if (isset($brands[$me])) {
                                    $products[$i]->brand = $brands[$me]->name;
                                }
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // читаем записи вариантов товара
                    $variant_id = 'variant_id';
                    $dbtable4 = DATABASE_PRODUCTS_VARIANTS_TABLENAME;
                    $query = 'SELECT `' . $variant_id . '`, '     // ид варианта товара
                                  . '`' . $product_id . '`, '     // ид товара
                                  . '`sku`, '                     // артикул варианта
                                  . '`name`, '                    // название варианта
                                  . '`price`, '                   // цена варианта (основная ценовая группа)
                                  . '`temp_price`, '              // акционная цена варианта
                                  . '`old_price`, '               // старая цена варианта
                                  . '`priority_discount`, '       // приоритетная скидка варианта
                                  . '`stock`, '                   // количество на складе
                                  . '`position` '                 // сортировочный вес варианта
                           . 'FROM `' . $dbtable4 . '` '
                           . 'WHERE `' . $product_id . '` IN (' . implode(',', $ids) . ') '
                           . 'ORDER BY `' . $product_id . '` ASC, '
                                    . '`position` DESC;';
                    $result = $this->cms->db->query($query);

                    // перебираем результат
                    if (!empty($result)) {
                        while ($row = $this->cms->db->fetch_object($result)) {
                            $me = intval($row->$variant_id);
                            if (!empty($me)) {

                                // распаковываем поля записи
                                $row->name = trim($row->name);

                                // крепим к товару
                                $parent = intval($row->$product_id);
                                if (!empty($parent)) {
                                    if (isset($products[$parent])) {
                                        $products[$parent]->variants[] = $row;
                                    }
                                }
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);
                }

                // отбираем корневые категории и выпавшие (их признаем корневыми)
                foreach ($categories as $i => & $v) {
                    if (isset($v->$category_id) && empty($v->parent)) {
                        $items[$i] = & $categories[$i];
                    } elseif (!empty($i) && !isset($v->$category_id)) {
                        $categories[$i]->$category_id = $i;
                        $categories[$i]->parent = 0;
                        $categories[$i]->name = 'Выпавшая категория, ИД = ' . $i;
                        $categories[$i]->url = $i;
                        $categories[$i]->url_special = 0;
                        $categories[$i]->url_path = 'catalog/';
                        if (!isset($categories[$i]->products)) $categories[$i]->products = array();
                        $items[$i] = & $categories[$i];
                    }
                }
            }

            // возвращаем массив записей
            return $items;
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
            if (!$this->checkTemplate(PRICELIST_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>