<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Бренды: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class BrandsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'brands';
        public $id_field = 'brand_id';



        // =======================================================================
        // Подсчитать количество товаров в ветвях записей:
        //   $items = массив записей
        //   [$params->section] = раздел магазина
        //   [$params->enabled] = признак "разрешенный товар"
        // =======================================================================

        private function compute_products ( & $items, & $params = null ) {

            // пока количество товаров неизвестно
            $total = 0;

            // цикл по заполненным записям ветвей
            if (!empty($items)) {
                foreach ($items as & $item) {
                    if (!empty($item)) {

                        // если в этой ветке количество товаров еще не подсчитано
                        if (!isset($item->products_count)) {

                            // если основной запрос (чтение структуры веток) не содержал подсчета личных товаров ветки
                            if (!isset($item->my_products_count)) {

                                // если в ветку уже были прочитаны товары, берем их количество
                                if (isset($item->products)) {
                                    $count = count($item->products);
                                } else {

                                    // иначе в ветку не читались товары, придется делать запрос их количества
                                    $count = 0;
                                    if (isset($item->brand_id)) {

                                        // подсчитываем только разрешенные товары (если задано) этой ветви из такого раздела магазина (если задан)
                                        $query = 'SELECT COUNT(`enabled`) AS `count` '
                                               . 'FROM `products` '
                                               . 'WHERE `' . $this->id_field . '` = "' . $this->cms->db->query_value($item->brand_id) . '" '
                                                     . (isset($params->enabled) ? 'AND `enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ' : '')
                                                     . (isset($params->section) ? 'AND `section` = "' . $this->cms->db->query_value($params->section) . '" ' : '')
                                                     . ';';
                                        $result = $this->cms->db->query($query);

                                        // берем возвращенное количество
                                        if (!empty($result)) {
                                            $row = $this->cms->db->fetch_object($result);
                                            if (isset($row->count)) $count = $row->count;

                                            // освобождаем память от запроса
                                            $this->cms->db->free_result($result);
                                        }
                                    }
                                }
                            } else {

                                // иначе количество личных товаров ветки уже известно
                                $count = $item->my_products_count;
                            }

                            // если у ветки есть вложенные ветки, делаем рекурсивный вызов и приплюсовываем к итогу
                            if (!empty($item->subbrands)) {
                                $count += $this->compute_products($item->subbrands, $params);
                            }

                            // заносим итог в соответствующее поле ветки
                            $item->products_count = $count;
                        } else {

                            // иначе количество товаров в этой ветке уже подсчитано ранее
                            $count = $item->products_count;
                        }

                        // добавляем к суммарному итогу (в ветке + во вложенных ветках)
                        $total += $count;
                    }
                }
            }

            // возвращаем суммарное количество товаров в ветке
            return $total;
        }



        // =======================================================================
        // Подсчитать количество записей в ветвях записей:
        //   $items = массив записей
        // =======================================================================

        private function compute ( & $items ) {

            // пока количество записей неизвестно
            $total = 0;

            // цикл по заполненным записям ветвей
            if (!empty($items)) {
                foreach ($items as & $item) {
                    if (!empty($item)) {

                        // добавляем узел ветки к суммарному итогу
                        $total++;

                        // если у ветки есть вложенные ветки, делаем рекурсивный вызов и приплюсовываем к итогу
                        if (!empty($item->subbrands)) {
                            $total += $this->compute($item->subbrands);
                        }
                    }
                }
            }

            // возвращаем суммарное количество записей в ветке
            return $total;
        }



        // =======================================================================
        // Проверить, находится ли запись внутри ветки записей:
        //   $branch = запись
        //   $id = идентификатор искомой записи
        // =======================================================================

        private function in_branch ( & $branch, $id ) {

            $result = FALSE;
            if (!empty($branch->subbrands)) {
                foreach ($branch->subbrands as & $item) {
                    $result = $item->brand_id == $id;
                    if (!$result) $result = $this->in_branch($item, $id);
                    if ($result) break;
                }
            }
            return $result;
        }



        // =======================================================================
        // Взять из базы данных записи, указанные в параметрах:
        //   $items = результат будет помещен в эту переменную
        //   [$items_list] = результат в виде плоского списка будет помещен в эту переменную
        //   [$params->mode] = режим возврата результата
        //   [$params->sort] = способ сортировки записей
        //   [$params->ids] = идентификаторы записей (перечисленные через запятую)
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->section] = раздел магазина
        //   [$params->enabled] = признак "разрешена" запись:
        //                            0 = запрещенная
        //                            1 = разрешенная
        //                            * = в любом состоянии (эквивалентно отсутствию параметра)
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->informative] = признак "информативная страница"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        //   [$params->domained] = признак "имеет субдомен"
        //   [$params->subdomain_enabled] = признак "субдомен разрешен"
        //   [$params->template] = имя шаблона отображения страницы
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->menu_id] = идентификатор меню
        //   [$params->objected] = с подгружаемыми модулями
        //   [$params->browsed] = просмотренные
        //   [$params->SEOed] = с SEO текстом
        //   [$params->url_special] = с особым url
        //   [$params->in_price1] = используемая в прайсе 1
        //   [$params->in_price2] = используемая в прайсе 2
        //   [$params->in_price3] = используемая в прайсе 3
        //   [$params->in_price4] = используемая в прайсе 4
        //   [$params->in_price5] = используемая в прайсе 5
        //   [$params->in_price6] = используемая в прайсе 6
        //   [$params->in_price7] = используемая в прайсе 7
        //   [$params->in_price8] = используемая в прайсе 8
        // =======================================================================

        public function get ( & $items, $params = null, & $items_list = null ) {
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get');

                $where = '';
                $order = '';

                // сортируем указанным способом
                if (isset($params->sort)) {
                    switch ($params->sort) {
                        case SORT_BRANDS_MODE_BY_NAME:
                            $order = '`' . $this->dbtable . '`.`name` ASC, '
                                   . '`' . $this->dbtable . '`.`order_num` DESC ';
                            break;
                        case SORT_BRANDS_MODE_BY_BROWSED:
                            $order = '`' . $this->dbtable . '`.`browsed` DESC, '
                                   . '`' . $this->dbtable . '`.`order_num` DESC ';
                            break;
                        case SORT_BRANDS_MODE_BY_URL:
                            $order = '`' . $this->dbtable . '`.`url` ASC, '
                                   . '`' . $this->dbtable . '`.`order_num` DESC ';
                            break;
                        case SORT_BRANDS_MODE_BY_MENU:
                            $order = '`menu` DESC, '
                                   . '`' . $this->dbtable . '`.`order_num` DESC ';
                            break;
                        case SORT_BRANDS_MODE_BY_OBJECTS:
                            $order = '`' . $this->dbtable . '`.`objects` DESC, '
                                   . '`' . $this->dbtable . '`.`order_num` DESC ';
                            break;
                        case SORT_BRANDS_MODE_AS_IS:
                        default:
                            $order = '`' . $this->dbtable . '`.`parent` ASC, '
                                   . '`' . $this->dbtable . '`.`order_num` DESC ';
                    }
                    $order = 'ORDER BY ' . $order;
                }

                // фильтруем по запрошенным параметрам
                if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN ("' . str_replace(',', '","', $this->cms->db->query_value($params->ids)) . '") ';
                if (isset($params->user_id)) $where .= 'AND `' . $this->dbtable . '`.`user_id` = "' . $this->cms->db->query_value($params->user_id) . '" ';
                if (isset($params->section)) $where .= 'AND `' . $this->dbtable . '`.`section` = "' . $this->cms->db->query_value($params->section) . '" ';
                if (isset($params->enabled) && $params->enabled != '*') {
                    $where .= 'AND `' . $this->dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
                }
                if (isset($params->highlighted)) $where .= 'AND `' . $this->dbtable . '`.`highlighted` = "' . $this->cms->db->query_value($params->highlighted) . '" ';
                if (isset($params->hidden)) $where .= 'AND `' . $this->dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
                if (isset($params->informative)) $where .= 'AND `' . $this->dbtable . '`.`informative` = "' . $this->cms->db->query_value($params->informative) . '" ';
                if (isset($params->rss_disabled)) $where .= 'AND `' . $this->dbtable . '`.`rss_disabled` = "' . $this->cms->db->query_value($params->rss_disabled) . '" ';
                if (isset($params->export_disabled)) $where .= 'AND `' . $this->dbtable . '`.`export_disabled` = "' . $this->cms->db->query_value($params->export_disabled) . '" ';
                if (isset($params->domained)) $where .= 'AND TRIM(`' . $this->dbtable . '`.`subdomain`) != "" AND `' . $this->dbtable . '`.`subdomain_enabled` = 1 ';
                if (isset($params->subdomain_enabled)) $where .= 'AND `' . $this->dbtable . '`.`subdomain_enabled` = "' . $this->cms->db->query_value($params->subdomain_enabled) . '" ';
                if (isset($params->template)) $where .= 'AND `' . $this->dbtable . '`.`template` = "' . $this->cms->db->query_value($params->template) . '" ';
                if (isset($params->imaged)) $where .= 'AND (TRIM(REPLACE(`' . $this->dbtable . '`.`.images`, "' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '", "")) != "" OR TRIM(`' . $this->dbtable . '`.`image`) != "") ';
                if (isset($params->menu_id)) $where .= 'AND `' . $this->dbtable . '`.`menu_id` = "' . $this->cms->db->query_value($params->menu_id) . '" ';
                if (isset($params->objected)) $where .= 'AND TRIM(`' . $this->dbtable . '`.`objects`) != "" ';
                if (isset($params->browsed)) $where .= 'AND `' . $this->dbtable . '`.`browsed` != 0 ';
                if (isset($params->SEOed)) $where .= 'AND TRIM(`' . $this->dbtable . '`.`seo_description`) != "" ';
                if (isset($params->url_special)) $where .= 'AND `' . $this->dbtable . '`.`url_special` = "' . $this->cms->db->query_value($params->url_special) . '" ';
                if (isset($params->in_price1)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 1) != 0 ';
                if (isset($params->in_price2)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 2) != 0 ';
                if (isset($params->in_price3)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 4) != 0 ';
                if (isset($params->in_price4)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 8) != 0 ';
                if (isset($params->in_price5)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 16) != 0 ';
                if (isset($params->in_price6)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 32) != 0 ';
                if (isset($params->in_price7)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 64) != 0 ';
                if (isset($params->in_price8)) $where .= 'AND (`' . $this->dbtable . '`.`in_prices` & 128) != 0 ';
                if ($where != '') $where = 'WHERE 1 ' . $where;

                // формируем SELECT (без вступительного слова)
                $select = '`' . $this->dbtable . '`.*, '
                        . '`' . DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME . '`.`name` AS `user_name`, '
                        . '`' . DATABASE_CACHE_MENUS_SHORTVERSION_TABLENAME . '`.`name` AS `menu`, '
                        . 'COUNT(DISTINCT `' . DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME . '`.`product_id`) AS `my_products_count` '
                 . 'FROM `' . $this->dbtable . '` '
                 . 'LEFT JOIN `' . DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME . '` '
                           . 'ON `' . DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME . '`.`user_id` = `' . $this->dbtable . '`.`user_id` '
                 . 'LEFT JOIN `' . DATABASE_CACHE_MENUS_SHORTVERSION_TABLENAME . '` '
                           . 'ON `' . DATABASE_CACHE_MENUS_SHORTVERSION_TABLENAME . '`.`menu_id` = `' . $this->dbtable . '`.`menu_id` '
                 . 'LEFT JOIN `' . DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME . '` '
                           . 'ON `' . DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME . '`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` '
                 . $where
                 . 'GROUP BY `' . $this->dbtable . '`.`' . $this->id_field . '` '
                 . $order;

                // если не удается взять из memcache
                $hash = $this->dbtable . '-' . strtolower(md5($select));
                $this->cms->db->open_tracing_method('DB MEMCACHE get [' . $hash . ']');
                    $state = $this->memcache->get($hash, $items_list);
                $this->cms->db->close_tracing_method();

                if (!$state) {
                    $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get [checkQuery]');

                        $items_list = array();

                        // кешируем усеченную в размерах таблицу пользователей (Users ShortVersion)
                        $this->cms->db->users->cachingShortVersion();

                        // кешируем усеченную в размерах таблицу меню (Menus ShortVersion)
                        $this->cms->db->caching_menus_sv();

                        // кешируем усеченную в размерах таблицу товаров (CategoriesBrands Products ShortVersion)
                        $this->cms->db->products->caching_CatsBrandsProducts_short($params);

                        // формируем список объявлений индексов
                        $indexes = '';

                        // кешируем результаты запроса (с возвратом результирующих записей в $items)
                        if ($this->cms->db->caching_SELECT($select,
                                                           $this->dbtable . ', '
                                                             . DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME . ', '
                                                             . DATABASE_CACHE_MENUS_SHORTVERSION_TABLENAME . ', '
                                                             . DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME,
                                                           $indexes,
                                                           DATABASE_CACHE_BRANDS_TABLENAME,
                                                           DATABASE_CACHE_BRANDS_LIFETIME,
                                                           FALSE,    // запрещаем в памяти, так как таблица содержит неподдерживаемые в памяти BLOB/TEXT колонки
                                                           TRUE,
                                                           $items)) {

                            // поправляем поля записей
                            if (!empty($items)) {
                                foreach ($items as & $item) {
// TODO: change this later
                                    $this->cms->db->fix_brands_record($item);
                                    $items_list[$item->brand_id] = $item;
                                }
                            }

                        // иначе не удалось кешировать, нужно выполнить запрос напрямую
                        } else {
                            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get [doQuery]');

                                // делаем запрос
                                $query = 'SELECT ' . $select . ';';
                                $result = $this->cms->db->query($query);

                                // поправляем поля записей
                                if (!empty($result)) {
                                    while ($item = $this->cms->db->fetch_object($result)) {
// TODO: change this later
                                        $this->cms->db->fix_brands_record($item);
                                        $items_list[$item->brand_id] = $item;
                                    }

                                    // освобождаем память от запроса
                                    $this->cms->db->free_result($result);
                                }

                            $this->cms->db->close_tracing_method();
                        }

                        // кешируем в memcache
                        $this->cms->db->open_tracing_method('DB MEMCACHE set [' . $hash . ']');
                            $this->memcache->set($hash, $items_list);
                        $this->cms->db->close_tracing_method();

                    $this->cms->db->close_tracing_method();

                // иначе удалось взять из memcache, убеждаемся что это массив
                } else {
                    if (!is_array($items_list)) $items_list = array();
                }

                // строим в переменной $items дерево брендов
                $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get [createTree]');
                    $items = array();
                    $used = array();
                    do {
                        $stop_via_empty = TRUE;
                        $stop_via_trash = TRUE;
                        foreach ($items_list as & $item) {
                            $id = $item->brand_id;
                            if (empty($item->parents)) $item->parents[] = 0;
                            foreach ($item->parents as $parent) {
                                if ($parent != $id) {
                                    if ($parent == 0) {
                                        if (!isset($used[$id])) {
                                            $path = new stdClass;
                                            $path->name = $item->name;
                                            $path->brand_id = $id;
                                            $path->url = $item->url;
                                            $path->url_path = isset($item->url_special) && $item->url_special ? '' : 'brands/';
                                            $item->path[0] = $path;
                                            $items[$id] = & $item;
                                            $used[$id] = & $items[$id];
                                            $stop_via_trash = FALSE;
                                        }
                                    } else {
                                        if (isset($used[$parent])) {
                                            if (!isset($used[$parent]->subbrands[$id])
                                            && !$this->in_branch($item, $parent)) {
                                                $path = new stdClass;
                                                $path->name = $item->name;
                                                $path->brand_id = $id;
                                                $path->url = $item->url;
                                                $path->url_path = isset($item->url_special) && $item->url_special ? '' : 'brands/';
                                                $item->path = $used[$parent]->path;
                                                $item->path[] = $path;
                                                $used[$parent]->subbrands[$id] = & $item;
                                                $stop_via_trash = FALSE;
                                                if (!isset($used[$id])) $used[$id] = & $used[$parent]->subbrands[$id];
                                            }
                                        } else {
                                            $stop_via_empty = FALSE;
                                        }
                                    }
                                }
                            }
                        }
                    } while (!$stop_via_empty && !$stop_via_trash);
                $this->cms->db->close_tracing_method();

                // заполняем в элементах массивы subcats_ids (идентификаторы брендов)
                $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get [fillSubcatsIds]');
                    $used = array_reverse($used, TRUE);
                    foreach ($used as & $item) {
                        $used[$item->brand_id]->subcats_ids[] = $item->brand_id;
                        foreach ($item->parents as $parent) {
                            if ($parent != 0) {
                                if (isset($used[$parent]->subcats_ids)) {
                                    $used[$parent]->subcats_ids = array_merge($used[$parent]->subcats_ids, $item->subcats_ids);
                                } else {
                                    if (!isset($item->subcats_ids)) $item->subcats_ids = array();
                                    $used[$parent]->subcats_ids = $item->subcats_ids;
                                }
                            }
                        }
                    }
                $this->cms->db->close_tracing_method();

                $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get [computing]');

                    // подсчитываем количество товаров в ветвях брендов
                    $params->enabled = 1;
                    $this->compute_products($items, $params);

                    // подсчитываем количество прочитанных брендов
                    $count = $this->compute($items);

                $this->cms->db->close_tracing_method();

            // возвращаем количество прочитанных брендов
            $this->cms->db->close_tracing_method();
            return $count;
        }



        // =======================================================================
        // Обновить/добавить запись о бренде в базе данных:
        //   $item = запись (обычно содержащая только изменившиеся поля),
        //           лишние (не относящиеся к таблице) поля в записи игнорируются,
        //           запись добавляется, если не имеет поля идентификатора записи
        // =======================================================================

        public function update ( & $item ) {
            $this->cms->db->open_tracing_method('DB BRANDS update');

            $id = '';
            if (!empty($item)) {

                // готовим изменившиеся поля
                $fields = array(); $values = array();
                if (isset($item->brand_id))          {$fields[] = 'brand_id';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->brand_id)) . '"';}
                if (isset($item->sync_id))           {$fields[] = "sync_id";           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->sync_id)) . '"';}
                if (isset($item->parent))            {$fields[] = 'parent';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->parent)) . '"';}
                if (isset($item->parents))           {$fields[] = 'parents';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->parents)) . '"';}
                if (isset($item->menu_id))           {$fields[] = 'menu_id';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->menu_id)) . '"';}
                if (isset($item->objects))           {$fields[] = 'objects';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->objects)) . '"';}
                if (isset($item->user_id))           {$fields[] = 'user_id';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->user_id)) . '"';}
                if (isset($item->enabled))           {$fields[] = 'enabled';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->enabled)) . '"';}
                if (isset($item->highlighted))       {$fields[] = 'highlighted';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->highlighted)) . '"';}
                if (isset($item->informative))       {$fields[] = 'informative';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->informative)) . '"';}
                if (isset($item->hidden))            {$fields[] = 'hidden';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->hidden)) . '"';}
                if (isset($item->rss_disabled))      {$fields[] = 'rss_disabled';      $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->rss_disabled)) . '"';}
                if (isset($item->export_disabled))   {$fields[] = 'export_disabled';   $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->export_disabled)) . '"';}
                if (isset($item->url))               {$fields[] = 'url';               $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->url)) . '"';}
                if (isset($item->url_special))       {$fields[] = 'url_special';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->url_special)) . '"';}
                if (isset($item->meta_title))        {$fields[] = 'meta_title';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->meta_title)) . '"';}
                if (isset($item->meta_keywords))     {$fields[] = 'meta_keywords';     $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->meta_keywords)) . '"';}
                if (isset($item->meta_description))  {$fields[] = 'meta_description';  $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->meta_description)) . '"';}
                if (isset($item->name))              {$fields[] = 'name';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->name)) . '"';}
                if (isset($item->description))       {$fields[] = 'description';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->description)) . '"';}
                if (isset($item->seo_description))   {$fields[] = 'seo_description';   $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->seo_description)) . '"';}
                if (isset($item->subdomain))         {$fields[] = 'subdomain';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->subdomain)) . '"';}
                if (isset($item->subdomain_enabled)) {$fields[] = 'subdomain_enabled'; $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->subdomain_enabled)) . '"';}
                if (isset($item->subdomain_html))    {$fields[] = 'subdomain_html';    $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->subdomain_html)) . '"';}
                if (isset($item->template))          {$fields[] = 'template';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->template)) . '"';}
                if (isset($item->image))             {$fields[] = 'image';             $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->image)) . '"';}
                if (isset($item->images))            {$fields[] = 'images';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images)) . '"';}
                if (isset($item->images_alts))       {$fields[] = 'images_alts';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images_alts)) . '"';}
                if (isset($item->images_texts))      {$fields[] = 'images_texts';      $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images_texts)) . '"';}
                if (isset($item->images_view))       {$fields[] = 'images_view';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images_view)) . '"';}
                if (isset($item->tags))              {$fields[] = 'tags';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->tags)) . '"';}
                if (isset($item->browsed))           {$fields[] = 'browsed';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_natural($item->browsed)) . '"';}
                if (isset($item->order_num))         {$fields[] = 'order_num';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_num)) . '"';}
                if (isset($item->section))           {$fields[] = 'section';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->section)) . '"';}

                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, 'brands', 'brand_id', $fields, $values);

                // если выполнено
                if (!empty($id)) {

                    // проверяем необходимость очистить кеш-таблицы брендов
                    $this->cms->db->reset_brands_caches($item);
                }
            }

            // возвращаем идентификатор обновленной / добавленной записи
            $this->cms->db->close_tracing_method();
            return $id;
        }
    }



    return;
?>