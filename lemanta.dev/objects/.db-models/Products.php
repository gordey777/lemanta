<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Товары: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ProductsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'products';
        public $id_field = 'product_id';



        // ===================================================================
        /**
        *  Очистка базы данных от товаров
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function clear () {

            // очищаем базу товаров
            $this->cms->db->query('TRUNCATE TABLE `' . $this->dbtable . '`;');

            // очищаем базу вариантов товаров
            $this->cms->db->query('TRUNCATE TABLE `products_variants`;');
        }



        // ===================================================================
        /**
        *  Скрытие всех товаров от показа на сайте
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function hide () {
            $this->cms->db->query('UPDATE `' . $this->dbtable . '` '
                                . 'SET `enabled` = 0;');
        }



        // ===================================================================
        /**
        *  Обнуление у товаров количество на складе
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function zero_quantity () {

            // обнуляем у товара количество (поле уже не используется! осталось в базе от старых версий)
            $query = 'UPDATE `' . $this->dbtable . '` '
                   . 'SET `quantity` = 0;';
            $this->cms->db->query($query);



            // обнуляем у вариантов товара количество на складе
            $query = 'UPDATE `products_variants` '
                   . 'SET `stock` = 0;';
            $this->cms->db->query($query);
        }



        // ===================================================================
        /**
        *  Создание WHERE-части запроса для добавления в запрос фильтра с инверсией действия
        *
        *  Признаком инверсии является отрицательное значение в поле фильтра.
        *
        *  @access  private
        *  @param   object  $params     объект параметров
        *  @param   string  $field      имя поля фильтра
        *  @return  string              созданная часть запроса
        */
        // ===================================================================

        private function and_filter_invertable ( & $params, $field ) {
            $result = '';
            if (isset($params->$field)) {
                $dbtable = '`' . $this->dbtable . '`';
                $value = $params->$field;
                switch ($field) {
                    case 'domained':
                        if ($value < 0) {
                            $op1 = 'NOT (';
                            $op2 = ')';
                        } else {
                            $op1 = '';
                            $op2 = '';
                        }
                        $result = 'AND ' . $op1 . 'TRIM(' . $dbtable . '.`subdomain`) != "" '
                                                . 'AND ' . $dbtable . '.`subdomain_enabled` = 1'
                                         . $op2 . ' ';
                        break;

                    case 'imaged':
                        $separator = $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER);
                        $op1 = $value < 0 ? 'NOT' : '';
                        $result = 'AND ' . $op1 . '(TRIM(REPLACE(' . $dbtable . '.`images`, "' . $separator . '", "")) != "" '
                                                 . 'OR TRIM(' . $dbtable . '.`large_image`) != "" '
                                                 . 'OR TRIM(' . $dbtable . '.`small_image`) != "") ';
                        break;

                    case 'filed':
                        $separator = $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER);
                        $op1 = $value < 0 ? '=' : '!=';
                        $result = 'AND TRIM(REPLACE(' . $dbtable . '.`files`, "' . $separator . '", "")) '
                                     . $op1
                                     . ' "" ';
                        break;

                    case 'articled':
                        if (!isset($name)) $name = 'article_ids';
                    case 'newsed':
                        if (!isset($name)) $name = 'news_ids';
                    case 'objected':
                        if (!isset($name)) $name = 'objects';
                    case 'SEOed':
                        if (!isset($name)) $name = 'seo_description';
                        $op1 = $value < 0 ? '=' : '!=';
                        $result = 'AND TRIM(' . $dbtable . '.`' . $name . '`) '
                                     . $op1
                                     . ' "" ';
                        break;

                    case 'browsed':
                        if (!isset($name)) $name = 'browsed';
                    case 'voted':
                        if (!isset($name)) $name = 'votes';
                        $op1 = $value < 0 ? '=' : '!=';
                        $result = 'AND ABS(' . $dbtable . '.`' . $name . '`) '
                                     . $op1
                                     . ' 0 ';
                        break;

                    case 'in_price1':
                        if (!isset($mask)) $mask = 1;
                    case 'in_price2':
                        if (!isset($mask)) $mask = 2;
                    case 'in_price3':
                        if (!isset($mask)) $mask = 4;
                    case 'in_price4':
                        if (!isset($mask)) $mask = 8;
                    case 'in_price5':
                        if (!isset($mask)) $mask = 16;
                    case 'in_price6':
                        if (!isset($mask)) $mask = 32;
                    case 'in_price7':
                        if (!isset($mask)) $mask = 64;
                    case 'in_price8':
                        if (!isset($mask)) $mask = 128;
                        $op1 = $value < 0 ? '=' : '!=';
                        if ($value < 0) {
                            $op1 = 'NOT (';
                            $op2 = ')';
                        } else {
                            $op1 = '';
                            $op2 = '';
                        }
                        $result = 'AND ' . $op1 . '(' . $dbtable . '.`in_prices` & ' . $mask . ') != 0 '
                                                . 'AND '
                                                . '(' . DATABASE_CATEGORIES_TABLENAME . '.`in_prices` & ' . $mask . ') != 0'
                                         . $op2 . ' ';
                        break;

                    default:
                        $op1 = $value < 0 ? '!=' : '=';
                        $result = 'AND ' . $dbtable . '.`' . $field . '` '
                                         . $op1
                                         . ' "' . $this->cms->db->query_value(abs($value)) . '" ';
                }
            }
            return $result;
        }



        // =======================================================================
        // Выбрать из базы данных записи о товарах согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->type] = тип селекции (хиты, новинки, акционные и т.п.)
        //   [$params->category] = запись о категории
        //   [$params->brand] = запись о бренде
        //   [$params->properties] = набор свойств товара
        //   [$params->filter_brands] = установленные флаги фильтра по товарным брендам
        //   [$params->search] = искомый текст (может быть массивом искомых текстов; объединяются по AND)
        //   [$params->search_type] = тип поиска (a1, std или пустая строка)
        //   [$params->search_cost_from] = искомая цена от
        //   [$params->search_cost_to] = искомая цена до
        //   [$params->search_amount_from] = искомое количество от
        //   [$params->search_amount_to] = искомое количество до
        //   [$params->search_date_from] = искомая дата от
        //   [$params->search_date_to] = искомая дата до
        //   [$params->ids] = идентификаторы товаров (перечисленные через запятую)
        //   [$params->category_id] = идентификатор категории
        //   [$params->category_ids] = идентификаторы категорий (перечисленные через запятую)
        //   [$params->brand_id] = идентификатор бренда
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->section] = раздел магазина
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->commented] = признак "разрешено обсуждение"
        //   [$params->hit] = признак "хит продаж"
        //   [$params->newest] = признак "новинка"
        //   [$params->actional] = признак "акционный"
        //   [$params->awaited] = признак "скоро в продаже"
        //   [$params->ymarket] = признак "экспорт Яндекс.Маркет"
        //   [$params->vkontakte] = признак "экспорт ВКонтакте"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        //   [$params->non_creditable] = признак "не для кредита"
        //   [$params->non_usable] = признак "не для продажи"
        //   [$params->domained] = признак "имеет субдомен"
        //   [$params->subdomain_enabled] = признак "субдомен разрешен"
        //   [$params->template] = имя шаблона отображения страницы
        //   [$params->in_price1] = признак "в прайсе 1"
        //   [$params->in_price2] = признак "в прайсе 2"
        //   [$params->in_price3] = признак "в прайсе 3"
        //   [$params->in_price4] = признак "в прайсе 4"
        //   [$params->in_price5] = признак "в прайсе 5"
        //   [$params->in_price6] = признак "в прайсе 6"
        //   [$params->in_price7] = признак "в прайсе 7"
        //   [$params->in_price8] = признак "в прайсе 8"
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->filed] = с загруженными файлами
        //   [$params->articled] = со связанными статьями
        //   [$params->newsed] = со связанными новостями
        //   [$params->menu_id] = идентификатор меню
        //   [$params->objected] = с подгружаемыми модулями
        //   [$params->browsed] = просмотренные
        //   [$params->voted] = с выставленными оценками
        //   [$params->SEOed] = с SEO текстом
        //   [$params->url_special] = с особым url
        //   [$params->completeness] = степень полноты выбираемых записей
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        //   [$params->randomcount] =  из уже выбранных записей столько выбрать случайно
        //   [$params->discount] = величина скидки клиента
        //   [$params->price_id] = идентификатор ценовой группы клиента
        //   [$params->info_ids] = признак "вернуть массив проходящих фильтр ИД товаров"
        //   [$item_ids] = массив ИД товаров будет помещен в эту переменную (если разрешено в параметрах)
        // =======================================================================

        public function get ( & $items, $params = null, & $item_ids = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get');

            $where = '';
            $discount = isset($params->discount) ? $this->cms->db->fix_discount($params->discount) : 0;

            $price_id = isset($params->price_id) ? intval($params->price_id) : 0;
            $variant_discount_price = 'MAX(' . $this->variantDiscountPriceField($price_id, $discount) . ') AS `variant_discount_price`';

            // инициализируем указатели что подключать в запрос
            $fields = array();
            $jpv_fields = array();
            $jpv_where = '';
            $join_brands = TRUE;
            $join_products_categories = FALSE;
            $join_orders_products = FALSE;
            $join_products_comments = FALSE;
            $join_users = FALSE;
            $join_menu = FALSE;
            $join_variants = FALSE;
            $join_orders_date = FALSE;
            $join_shippings_terms = FALSE;

            // фильтруем по искомой дате
            if (isset($params->search_date_from)) {
                if (!isset($params->type) || ($params->type != TYPE_PRODUCTS_NEWEST_MIXED)) {
                    $where .= 'AND `' . $this->dbtable . '`.`created` >= "' . $this->cms->db->query_value($params->search_date_from) . ' 00:00:00" ';
                }
            }
            if (isset($params->search_date_to)) $where .= 'AND `' . $this->dbtable . '`.`created` <= "' . $this->cms->db->query_value($params->search_date_to) . ' 23:59:59" ';

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (' . $this->cms->db->query_value($params->ids) . ') ';
            if (isset($params->category_id) && (!isset($params->category) || empty($params->category))) $where .= 'AND `' . $this->dbtable . '`.category_id = "' . $this->cms->db->query_value($params->category_id) . '" ';
            if (isset($params->category_ids) && !empty($params->category_ids) && (!isset($params->category) || empty($params->category))) {
                $join_products_categories = TRUE;
                $where .= 'AND (`' . $this->dbtable . '`.category_id IN (' . $this->cms->db->query_value($params->category_ids) . ') '
                             . 'OR ' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '.category_id IN (' . $this->cms->db->query_value($params->category_ids) . ')) ';
            }
            if (isset($params->brand_id) && (!isset($params->brand) || empty($params->brand))) $where .= 'AND `' . $this->dbtable . '`.brand_id = "' . $this->cms->db->query_value($params->brand_id) . '" ';
            if (isset($params->user_id)) $where .= 'AND `' . $this->dbtable . '`.user_id = "' . $this->cms->db->query_value($params->user_id) . '" ';
            if (isset($params->section)) $where .= 'AND `' . $this->dbtable . '`.section = "' . $this->cms->db->query_value($params->section) . '" ';
            $where .= $this->and_filter_invertable($params, 'enabled');
            $where .= $this->and_filter_invertable($params, 'highlighted');
            $where .= $this->and_filter_invertable($params, 'hidden');
            $where .= $this->and_filter_invertable($params, 'commented');
            $where .= $this->and_filter_invertable($params, 'hit');
            $where .= $this->and_filter_invertable($params, 'newest');
            $where .= $this->and_filter_invertable($params, 'actional');
            $where .= $this->and_filter_invertable($params, 'awaited');
            $where .= $this->and_filter_invertable($params, 'ymarket');
            $where .= $this->and_filter_invertable($params, 'vkontakte');
            $where .= $this->and_filter_invertable($params, 'rss_disabled');
            $where .= $this->and_filter_invertable($params, 'export_disabled');
            $where .= $this->and_filter_invertable($params, 'non_creditable');
            $where .= $this->and_filter_invertable($params, 'non_usable');
            $where .= $this->and_filter_invertable($params, 'domained');
            $where .= $this->and_filter_invertable($params, 'subdomain_enabled');
            if (isset($params->template)) $where .= 'AND `' . $this->dbtable . '`.template = "' . $this->cms->db->query_value($params->template) . '" ';
            $where .= $this->and_filter_invertable($params, 'imaged');
            $where .= $this->and_filter_invertable($params, 'filed');
            $where .= $this->and_filter_invertable($params, 'articled');
            $where .= $this->and_filter_invertable($params, 'newsed');
            if (isset($params->menu_id)) $where .= 'AND `' . $this->dbtable . '`.menu_id = "' . $this->cms->db->query_value($params->menu_id) . '" ';
            $where .= $this->and_filter_invertable($params, 'objected');
            $where .= $this->and_filter_invertable($params, 'browsed');
            $where .= $this->and_filter_invertable($params, 'voted');
            $where .= $this->and_filter_invertable($params, 'SEOed');
            $where .= $this->and_filter_invertable($params, 'url_special');
            $where .= $this->and_filter_invertable($params, 'in_price1');
            $where .= $this->and_filter_invertable($params, 'in_price2');
            $where .= $this->and_filter_invertable($params, 'in_price3');
            $where .= $this->and_filter_invertable($params, 'in_price4');
            $where .= $this->and_filter_invertable($params, 'in_price5');
            $where .= $this->and_filter_invertable($params, 'in_price6');
            $where .= $this->and_filter_invertable($params, 'in_price7');
            $where .= $this->and_filter_invertable($params, 'in_price8');



            // отбираем по флагам фильтра товарных брендов
            if (isset($params->filter_brands) && is_array($params->filter_brands) && !empty($params->filter_brands)) {
                foreach ($params->filter_brands as & $value) $value = intval($value);
                $where .= 'AND `' . $this->dbtable . '`.brand_id IN (' . $this->cms->db->query_value(implode(',', $params->filter_brands)) . ') ';
            }



            // отбираем по флагам фильтра товарных вариантов
            if (isset($params->filter_variants) && is_array($params->filter_variants) && !empty($params->filter_variants)) {
                $join_variants = TRUE;
                $jpv_fields['variant_name'] = 'name AS variant_name';
                if ($jpv_where == '') $jpv_where .= 'WHERE ';
                $count = count($params->filter_variants);
                if ($count > 1) $jpv_where .= '(';
                $index = $count;
                foreach ($params->filter_variants as & $value) {
                    $jpv_where .= 'name = "' . $this->cms->db->query_value($value) . '"';
                    if ($index > 1) $jpv_where .= ' OR ';
                    $index--;
                }
                if ($count > 1) $jpv_where .= ') ';
                $where .= 'AND jpv.variant_name IS NOT NULL ';
            }



            // отбираем по флагам фильтра товарных свойств
            if (isset($params->filter_properties) && is_array($params->filter_properties) && !empty($params->filter_properties)) {
                foreach ($params->filter_properties as $id => & $values) {
                    if (is_array($values) && !empty($values)) {
                        $id = intval($id);
                        $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (SELECT `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '`.`' . $this->id_field . '` '
                                                                                           . 'FROM `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '` '
                                                                                           . 'WHERE `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '`.`property_id` = "' . $this->cms->db->query_value($id) . '" AND ';
                        $count = count($values);
                        if ($count > 1) $where .= '(';
                        $index = $count;
                        foreach ($values as & $value) {
                            $where .= DATABASE_PROPERTIES_VALUES_TABLENAME . '.value = "' . $this->cms->db->query_value($value) . '"';
                            if ($index > 1) $where .= ' OR ';
                            $index--;
                        }
                        if ($count > 1) $where .= ')';
                        $where .= ') ';
                    }
                }
            }



            // фильтруем по категории
            if (!empty($params->category)) {
                if (!empty($params->category->subcats_ids) && is_array($params->category->subcats_ids)) {
                    $join_products_categories = TRUE;
                    $where .= 'AND (`' . $this->dbtable . '`.`category_id` IN (' . $this->cms->db->query_value(join($params->category->subcats_ids, ',')) . ') '
                                . 'OR `products_categories`.`category_id` IN (' . $this->cms->db->query_value(join($params->category->subcats_ids, ',')) . ')) ';
                } else {
                    if (!empty($params->category->products) && is_array($params->category->products)) {
                        $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (' . $this->cms->db->query_value(join(array_keys($params->category->products), ',')) . ') ';
                    } else {
                        $join_products_categories = TRUE;
                        $where .= 'AND (`' . $this->dbtable . '`.`category_id` = ' . $this->cms->db->query_value($params->category->category_id) . ' '
                                    . 'OR `products_categories`.`category_id` = ' . $this->cms->db->query_value($params->category->category_id) . ') ';
                    }
                }
            }



            // фильтруем по бренду
            if (!empty($params->brand)) {
                if (!empty($params->brand->subcats_ids) && is_array($params->brand->subcats_ids)) {
                    $join_brands = TRUE;
                    $where .= 'AND `' . $this->dbtable . '`.`brand_id` IN (' . $this->cms->db->query_value(join($params->brand->subcats_ids, ',')) . ') '
                            . 'AND `brands`.`brand_id` IN (' . $this->cms->db->query_value(join($params->brand->subcats_ids, ',')) . ') ';
                } else {
                    $where .= 'AND `' . $this->dbtable . '`.`brand_id` = "' . $this->cms->db->query_value($params->brand->brand_id) . '" ';
                }
            }



            // фильтруем по свойствам товара
            if (isset($params->properties) && !empty($params->properties)) {
                foreach ($params->properties as $id => $value) {
                    $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (SELECT `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '`.`' . $this->id_field . '` '
                                                                                       . 'FROM `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '` '
                                                                                       . 'WHERE `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '`.`value` = "' . $this->cms->db->query_value($value) . '" '
                                                                                                   . 'AND `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '`.`property_id` = "' . $this->cms->db->query_value($id) . '") ';
                }
            }



            // фильтруем по искомому тексту (может быть массивом искомых текстов; объединяются по AND)
            if (isset($params->search) && (is_string($params->search) && $params->search != ''
                                       || is_array($params->search) && !empty($params->search))) {

                // берем тип поиска
                $stype = '';
                if (!empty($params->search_type)) {
                    $stype = trim($params->search_type);
                    $stype = $this->text->lowerCase($stype);
                }

                // перебираем элементы искомых текстов
                if (is_string($params->search)) $params->search = array($params->search);
                foreach ($params->search as $search) {
                    $search = trim($search);
                    if ($search != '') {

                        // анализируем искомый текст в 2 прохода (1 проход - префиксные команды, 2 проход - отдельные слова)
                        for ($pass = 1; $pass <= 2; $pass++ ) {
                            if ($pass == 1) {
                                $keywords = array($search);
                            } else {
                                // в искомом тексте обрабатываем лишь 4 первых слова
                                $keywords = preg_split('/\s+/', $search, 4);
                            }

                            $found = FALSE;
                            foreach ($keywords as $keyword) {

                                // если слово более 2 букв
                                if (strlen($keyword) > 2) {

                                    // просто слова обрабатываем не на 1 проходе
                                    if ($pass != 1) {
                                        $keyword = $this->cms->db->query_value($keyword);
                                        switch ($stype) {
                                            case 'a1':
                                                $join_brands = TRUE;
                                                $where .= 'AND (`' . $this->dbtable . '`.`model` LIKE "%' . $keyword . '%" OR '
                                                             . '`' . $this->dbtable . '`.`pcode` LIKE "%' . $keyword . '%" OR '
                                                             . '`categories`.`name` LIKE "%' . $keyword . '%" OR '
                                                             . '`brands`.`name` LIKE "%' . $keyword . '%") ';
                                                break;
                                            case 'std':
                                            default:
                                                $join_brands = TRUE;
                                                $join_variants = TRUE;
                                                $jpv_fields['variant_name'] = 'name AS variant_name';
                                                $jpv_fields['sku'] = 'sku';
                                                $where .= 'AND (`' . $this->dbtable . '`.`model` LIKE "%' . $keyword . '%" OR '
                                                             . '`' . $this->dbtable . '`.`pcode` = "' . $keyword . '" OR '
                                                             . '`categories`.`name` = "' . $keyword . '" OR '
                                                             . '`brands`.`name` = "' . $keyword . '" OR '
                                                             . '`jpv`.`sku` = "' . $keyword . '" OR '
                                                             . '`jpv`.`variant_name` LIKE "%' . $keyword . '%") ';
                                        }
                                        $found = TRUE;
                                        continue;
                                    }

                                    // если есть префиксная команда поиска по дате модификации
                                    $command = strtolower(SEARCH_PRODUCTS_COMMAND_MODIFIED_DATE);
                                    $size = strlen($command);
                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                        $keyword = trim(substr($keyword, $size));
                                        if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`modified`, "%Y-%m-%d") = "' . $this->cms->db->query_value($keyword) . '" ';
                                        $found = TRUE;
                                    } else {

                                        // если есть префиксная команда поиска по дате создания
                                        $command = strtolower(SEARCH_PRODUCTS_COMMAND_CREATED_DATE);
                                        $size = strlen($command);
                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                            $keyword = trim(substr($keyword, $size));
                                            if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`created`, "%Y-%m-%d") = "' . $this->cms->db->query_value($keyword) . '" ';
                                            $found = TRUE;
                                        } else {

                                            // если есть префиксная команда поиска по имени шаблона
                                            $command = strtolower(SEARCH_PRODUCTS_COMMAND_TEMPLATE);
                                            $size = strlen($command);
                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                $keyword = trim(substr($keyword, $size));
                                                if ($keyword == '*') {
                                                    $where .= 'AND `' . $this->dbtable . '`.`template` != "" ';
                                                } else {
                                                    $where .= 'AND `' . $this->dbtable . '`.`template` = "' . $this->cms->db->query_value($keyword) . '" ';
                                                }
                                                $found = TRUE;
                                            } else {

                                                // если есть префиксная команда поиска по ИД товара
                                                $command = strtolower(SEARCH_PRODUCTS_COMMAND_PRODUCT_ID);
                                                $size = strlen($command);
                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                    $keyword = trim(substr($keyword, $size));
                                                    if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` = "' . $this->cms->db->query_value($keyword) . '" ';
                                                    $found = TRUE;
                                                } else {

                                                    // если есть префиксная команда поиска по буквенному коду товара
                                                    $command = strtolower(SEARCH_PRODUCTS_COMMAND_PRODUCT_CODE);
                                                    $size = strlen($command);
                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                        $keyword = trim(substr($keyword, $size));
                                                        if ($keyword == '*') {
                                                            $where .= 'AND `' . $this->dbtable . '`.`pcode` != "" ';
                                                        } else {
                                                            $where .= 'AND `' . $this->dbtable . '`.`pcode` = "' . $this->cms->db->query_value($keyword) . '" ';
                                                        }
                                                        $found = TRUE;
                                                    } else {

                                                        // если есть префиксная команда поиска по артикулу
                                                        $condition = $this->checkSearchCommand('sku', $keyword);
                                                        if ($condition !== FALSE) {
                                                            $join_variants = TRUE;
                                                            $jpv_fields['sku'] = 'sku';
                                                            $where .= 'AND `jpv`.`sku` ' . $condition . ' ';
                                                                if ($jpv_where == '') $jpv_where .= 'WHERE 1 ';
                                                                $jpv_where .= 'AND `sku` ' . $condition . ' ';
                                                            $found = TRUE;
                                                        } else {

                                                            // если есть префиксная команда поиска по бренду
                                                            $command = strtolower(SEARCH_PRODUCTS_COMMAND_BRAND);
                                                            $size = strlen($command);
                                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                $join_brands = TRUE;
                                                                $keyword = trim(substr($keyword, $size));
                                                                if ($keyword != '') {
                                                                    if ($keyword == '*') {
                                                                        $where .= 'AND `brands`.`name` != "" AND `brands`.`name` IS NOT NULL ';
                                                                    } else {
                                                                        $where .= 'AND `brands`.`name` = "' . $this->cms->db->query_value($keyword) . '" ';
                                                                    }
                                                                } else {
                                                                    $where .= 'AND (`brands`.`name` IS NULL OR `brands`.`name` = "") ';
                                                                }
                                                                $found = TRUE;
                                                            } else {

                                                                // если есть префиксная команда поиска по тегу
                                                                $command = strtolower(SEARCH_PRODUCTS_COMMAND_TAG);
                                                                $size = strlen($command);
                                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                    $keyword = preg_replace('/[ \t\r\n,_\-]/', '', substr($keyword, $size));
                                                                    if ($keyword != '') {
                                                                        $keyword = $this->cms->db->query_value($keyword);
                                                                        $where .= 'AND FIND_IN_SET(LCASE("' . $keyword . '"), TRIM(BOTH "," FROM LCASE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`tags`, "_", ""), "-", ""), " ", "")))) > 0 ';
                                                                    } else {
                                                                        $where .= 'AND REPLACE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`tags`, "_", ""), "-", ""), " ", ""), ",", "") = "" ';
                                                                    }
                                                                    $found = TRUE;
                                                                } else {

                                                                    // если есть префиксная команда поиска по тегу + мета ключевым словам
                                                                    $command = strtolower(SEARCH_PRODUCTS_COMMAND_TAG_KEYWORDS);
                                                                    $size = strlen($command);
                                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                        $keyword = preg_replace('/[ \t\r\n,_\-]/', '', substr($keyword, $size));
                                                                        if ($keyword != '') {
                                                                            $keyword = $this->cms->db->query_value($keyword);
                                                                            $where .= 'AND (FIND_IN_SET(LCASE("' . $keyword . '"), TRIM(BOTH "," FROM LCASE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`tags`, "_", ""), "-", ""), " ", "")))) > 0 '
                                                                                         . 'OR FIND_IN_SET(LCASE("' . $keyword . '"), TRIM(BOTH "," FROM LCASE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`meta_keywords`, "_", ""), "-", ""), " ", "")))) > 0) ';
                                                                        } else {
                                                                            $where .= 'AND REPLACE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`tags`, "_", ""), "-", ""), " ", ""), ",", "") = "" '
                                                                                    . 'AND REPLACE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`meta_keywords`, "_", ""), "-", ""), " ", ""), ",", "") = "" ';
                                                                        }
                                                                        $found = TRUE;
                                                                    } else {

                                                                        // если есть префиксная команда поиска по мета ключевым словам
                                                                        $command = strtolower(SEARCH_PRODUCTS_COMMAND_KEYWORDS);
                                                                        $size = strlen($command);
                                                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                            $keyword = preg_replace('/[ \t\r\n,_\-]/', '', substr($keyword, $size));
                                                                            if ($keyword != '') {
                                                                                $keyword = $this->cms->db->query_value($keyword);
                                                                                $where .= 'AND FIND_IN_SET(LCASE("' . $keyword . '"), TRIM(BOTH "," FROM LCASE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`meta_keywords`, "_", ""), "-", ""), " ", "")))) > 0 ';
                                                                            } else {
                                                                                $where .= 'AND REPLACE(REPLACE(REPLACE(REPLACE(`' . $this->dbtable . '`.`meta_keywords`, "_", ""), "-", ""), " ", ""), ",", "") = "" ';
                                                                            }
                                                                            $found = TRUE;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            // если на каком-то из проходов найдено поисковое условие, прекращаем обработку
                            if ($found) break;
                        }
                    }
                }
            }



            // фильтруем по искомой цене
            $search_cost_from = isset($params->search_cost_from) ? $this->number->floatValue($params->search_cost_from) : FALSE;
            $search_cost_to = isset($params->search_cost_to) ? $this->number->floatValue($params->search_cost_to) : FALSE;
            if (($search_cost_from !== FALSE) && ($search_cost_to !== FALSE)) {
                if ($search_cost_from > $search_cost_to) {
                    $swap = $search_cost_from;
                    $search_cost_from = $search_cost_to;
                    $search_cost_to = $swap;
                }
            }
            if ($search_cost_from === FALSE) $search_cost_from = 0;
            if ($search_cost_to === FALSE) $search_cost_to = 0;
            if ($search_cost_from != 0) {
                $join_variants = TRUE;
                $jpv_fields['variant_discount_price'] = $variant_discount_price;
                $where .= 'AND jpv.variant_discount_price >= ' . $this->cms->db->query_value($search_cost_from) . ' ';
            }
            if ($search_cost_to != 0) {
                $join_variants = TRUE;
                $jpv_fields['variant_discount_price'] = $variant_discount_price;
                $where .= 'AND jpv.variant_discount_price <= ' . $this->cms->db->query_value($search_cost_to) . ' ';
            }



            // фильтруем по искомому количеству
            $search_amount_from = isset($params->search_amount_from) ? intval($params->search_amount_from) : FALSE;
            $search_amount_to = isset($params->search_amount_to) ? intval($params->search_amount_to) : FALSE;
            if (($search_amount_from !== FALSE) && ($search_amount_to !== FALSE)) {
                if ($search_amount_from > $search_amount_to) {
                    $swap = $search_amount_from;
                    $search_amount_from = $search_amount_to;
                    $search_amount_to = $swap;
                }
            }
            if ($search_amount_from === FALSE) $search_amount_from = 0;
            if ($search_amount_to === FALSE) $search_amount_to = 0;
            if ($search_amount_from != 0) {
                $join_variants = TRUE;
                $jpv_fields['variant_quantity'] = 'MAX(stock) AS variant_quantity';
                $where .= 'AND (jpv.variant_quantity >= ' . $this->cms->db->query_value($search_amount_from) . ' '
                             . 'OR (`' . $this->dbtable . '`.quantity >= ' . $this->cms->db->query_value($search_amount_from) . ' AND jpv.variant_quantity IS NULL)) ';
            }
            if ($search_amount_to != 0) {
                $join_variants = TRUE;
                $jpv_fields['variant_quantity'] = 'MAX(stock) AS variant_quantity';
                $where .= 'AND (jpv.variant_quantity <= ' . $this->cms->db->query_value($search_amount_to) . ' '
                             . 'OR (`' . $this->dbtable . '`.quantity <= ' . $this->cms->db->query_value($search_amount_to) . ' AND jpv.variant_quantity IS NULL)) ';
            }



            // делаем селекцию указанного типа
            $suffix = '';
            if (isset($params->type)) {
                switch ($params->type) {
                    case TYPE_PRODUCTS_ORDERED:
                        $join_orders_products = TRUE;
                        $where .= 'AND `jop`.`product_orders_count` > 0 ';
                        break;
                    case TYPE_PRODUCTS_COMMENTED:
                        $join_products_comments = TRUE;
                        $where .= 'AND `jpc`.`product_comments_count` > 0 ';
                        break;
                    case TYPE_PRODUCTS_HIT:
                        $where .= 'AND `' . $this->dbtable . '`.`hit` = 1 ';
                        $suffix = '_hit';
                        break;
                    case TYPE_PRODUCTS_NEWEST:
                        $where .= 'AND `' . $this->dbtable . '`.`newest` = 1 ';
                        $suffix = '_newest';
                        break;
                    case TYPE_PRODUCTS_NEWEST_MIXED:
                        if (isset($params->search_date_from)) {
                            $where .= 'AND (`' . $this->dbtable . '`.`newest` = 1 '
                                         . 'OR `' . $this->dbtable . '`.`created` >= "' . $this->cms->db->query_value($params->search_date_from) . ' 00:00:00") ';
                        } else {
                            $where .= 'AND `' . $this->dbtable . '`.`newest` = 1 ';
                        }
                        $suffix = '_newest';
                        break;
                    case TYPE_PRODUCTS_ACTIONAL:
                        $join_variants = TRUE;
                        $jpv_fields['temp_price'] = 'temp_price';
                        $jpv_fields['temp_price_start'] = 'temp_price_start';
                        $jpv_fields['temp_price_date'] = 'temp_price_date';
                        $jpv_fields['temp_price_members'] = 'temp_price_members';
                        $jpv_fields['temp_price_invited'] = 'temp_price_invited';
                        $where .= 'AND (`' . $this->dbtable . '`.`actional` = 1 '
                                . 'OR `jpv`.`temp_price` != 0 AND (`jpv`.`temp_price_start` = "0000-00-00 00:00:00" OR `jpv`.`temp_price_start` <= NOW()) '
                                                           . 'AND (`jpv`.`temp_price_date` = "0000-00-00 00:00:00" OR `jpv`.`temp_price_date` >= NOW()) '
                                                           . 'AND `jpv`.`temp_price_members` <= `jpv`.`temp_price_invited`) ';
                        $suffix = '_actional';
                        break;
                    case TYPE_PRODUCTS_DISCOUNTED:
                        $join_variants = TRUE;
                        $jpv_fields['old_price'] = 'old_price';
                        $jpv_fields['priority_discount'] = 'priority_discount';
                        $jpv_fields['temp_price'] = 'temp_price';
                        $jpv_fields['temp_price_start'] = 'temp_price_start';
                        $jpv_fields['temp_price_date'] = 'temp_price_date';
                        $jpv_fields['temp_price_members'] = 'temp_price_members';
                        $jpv_fields['temp_price_invited'] = 'temp_price_invited';
                        $where .= 'AND (`jpv`.`old_price` != 0 '
                                . 'OR `jpv`.`priority_discount` > 0 AND `jpv`.`priority_discount` <= 100 '
                                . 'OR `jpv`.`temp_price` != 0 AND (`jpv`.`temp_price_start` = "0000-00-00 00:00:00" OR `jpv`.`temp_price_start` <= NOW()) '
                                                           . 'AND (`jpv`.`temp_price_date` = "0000-00-00 00:00:00" OR `jpv`.`temp_price_date` >= NOW()) '
                                                           . 'AND `jpv`.`temp_price_members` <= `jpv`.`temp_price_invited`) ';
                        break;
                    case TYPE_PRODUCTS_AWAITED:
                        $where .= 'AND `' . $this->dbtable . '`.`awaited` = 1 ';
                        $suffix = '_awaited';
                        break;
                    case TYPE_PRODUCTS_NONUSABLE:
                        $where .= 'AND `' . $this->dbtable . '`.`non_usable` = 1 ';
                        break;
                    case TYPE_PRODUCTS_DOMAINED:
                        $where .= 'AND TRIM(`' . $this->dbtable . '`.`subdomain`) != "" '
                                . 'AND `' . $this->dbtable . '`.`subdomain_enabled` = 1 ';
                        break;
                    case TYPE_PRODUCTS_TEMPLATED:
                        $where .= 'AND TRIM(`' . $this->dbtable . '`.`template`) != "" ';
                        break;
                    case TYPE_PRODUCTS_CANONIZED:
                        $where .= 'AND `' . $this->dbtable . '`.`canonical_id` != 0 ';
                        break;
                    case TYPE_PRODUCTS_ANY:
                        break;
                }
            }

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // сортируем указанным способом
            $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
            $order = $this->dbtable . '.order_num' . $suffix . ' ' . $direction;
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_PRODUCTS_MODE_BY_PRICE:
                        $join_variants = TRUE;
                        $fields['jpv.variant_discount_price'] = 'jpv.variant_discount_price';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $fields['discount_price'] = '0 AS discount_price';
                        $jpv_fields['variant_discount_price'] = $variant_discount_price;
                        $order = 'jpv.variant_discount_price ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_discount_price > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_PRICE_QUANTITY:
                        $join_variants = TRUE;
                        $fields['jpv.variant_discount_price'] = 'jpv.variant_discount_price';
                        $fields['jpv.variant_quantity'] = 'jpv.variant_quantity';
                        $fields[$this->dbtable . '.quantity'] = $this->dbtable . '.quantity';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $fields['discount_price'] = '0 AS discount_price';
                        $jpv_fields['variant_discount_price'] = $variant_discount_price;
                        $jpv_fields['variant_quantity'] = 'MAX(stock) AS variant_quantity';
                        $order = 'jpv.variant_discount_price ' . $direction . ', '
                               . 'jpv.variant_quantity ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_discount_price > 0 '
                                                . 'AND jpv.variant_quantity > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_OLDPRICE:
                        $join_variants = TRUE;
                        $fields['jpv.variant_old_price'] = 'jpv.variant_old_price';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $fields['old_price'] = 'ABS(`' . $this->dbtable . '`.old_price)';
                        $jpv_fields['variant_old_price'] = 'MAX(ABS(old_price)) AS variant_old_price';
                        $order = 'jpv.variant_old_price ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_old_price > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_TEMPPRICE:
                        $join_variants = TRUE;
                        $fields['jpv.variant_temp_price'] = 'jpv.variant_temp_price';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $fields['temp_price'] = 'ABS(`' . $this->dbtable . '`.temp_price)';
                        $jpv_fields['variant_temp_price'] = 'MAX(ABS(temp_price)) AS variant_temp_price';
                        $order = 'jpv.variant_temp_price ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_temp_price > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_ACTION_START_DATE:
                        $join_variants = TRUE;
                        $fields['jpv.variant_temp_price_start'] = 'jpv.variant_temp_price_start';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $jpv_fields['variant_temp_price_start'] = 'temp_price_start AS variant_temp_price_start';
                        $order = 'jpv.variant_temp_price_start ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_temp_price_start IS NOT NULL '
                                                . 'AND jpv.variant_temp_price_start <= NOW() ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_ACTION_END_DATE:
                        $join_variants = TRUE;
                        $fields['jpv.variant_temp_price_date'] = 'jpv.variant_temp_price_date';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $jpv_fields['variant_temp_price_date'] = 'temp_price_date AS variant_temp_price_date';
                        $order = 'jpv.variant_temp_price_date ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_temp_price_date IS NOT NULL '
                                                . 'AND jpv.variant_temp_price_date >= NOW() ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_PRIORITYDISCOUNT:
                        $join_variants = TRUE;
                        $fields['jpv.variant_priority_discount'] = 'jpv.variant_priority_discount';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $fields['priority_discount'] = $this->dbtable . '.priority_discount';
                        $jpv_fields['variant_priority_discount'] = 'MAX(priority_discount) AS variant_priority_discount';
                        $order = 'jpv.variant_priority_discount ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_priority_discount >= 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_QUANTITY:
                        $join_variants = TRUE;
                        $fields['jpv.variant_quantity'] = 'jpv.variant_quantity';
                        $fields[$this->dbtable . '.quantity'] = $this->dbtable . '.quantity';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $jpv_fields['variant_quantity'] = 'MAX(stock) AS variant_quantity';
                        $order = 'jpv.variant_quantity ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_quantity > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_QUANTITY_PRICE:
                        $join_variants = TRUE;
                        $fields['jpv.variant_quantity'] = 'jpv.variant_quantity';
                        $fields['jpv.variant_discount_price'] = 'jpv.variant_discount_price';
                        $fields[$this->dbtable . '.quantity'] = $this->dbtable . '.quantity';
                        $fields['discount_price'] = '0 AS discount_price';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $jpv_fields['variant_quantity'] = 'MAX(stock) AS variant_quantity';
                        $jpv_fields['variant_discount_price'] = $variant_discount_price;
                        $order = 'jpv.variant_quantity ' . $direction . ', '
                               . 'jpv.variant_discount_price ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.variant_quantity > 0 '
                                                . 'AND jpv.variant_discount_price > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_ORDERSCOUNT:
                        $join_orders_products = TRUE;
                        $fields['jop.product_orders_count'] = 'jop.product_orders_count';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'jop.product_orders_count ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jop.product_orders_count > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_ORDERSSUM:
                        $join_orders_products = TRUE;
                        $fields['jop.product_orders_sum'] = 'jop.product_orders_sum';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'jop.product_orders_sum ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jop.product_orders_sum > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_VARIANTSCOUNT:
                        $join_variants = TRUE;
                        $fields['jpv.product_variants_count'] = 'jpv.product_variants_count';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $jpv_fields['product_variants_count'] = 'COUNT(`' . $this->id_field . '`) AS product_variants_count';
                        $order = 'jpv.product_variants_count ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpv.product_variants_count > 1 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_NAME:
                        $fields[$this->dbtable . '.model'] = $this->dbtable . '.model';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = $this->dbtable . '.model ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.model) != "" ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_CATEGORY:
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'category_plural ' . $direction . ', '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . DATABASE_CATEGORIES_TABLENAME . '.name) != "" ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_BRAND:
                        $join_brands = TRUE;
                        $fields['brand'] = DATABASE_BRANDS_TABLENAME . '.name AS brand';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'brand ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . DATABASE_BRANDS_TABLENAME . '.name) != "" ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_CREATED:
                        $fields[$this->dbtable . '.created'] = $this->dbtable . '.created';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = $this->dbtable . '.created ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.created IS NOT NULL ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_MODIFIED:
                        $fields[$this->dbtable . '.modified'] = $this->dbtable . '.modified';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = $this->dbtable . '.modified ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.modified IS NOT NULL '
                                                . 'AND `' . $this->dbtable . '`.modified != `' . $this->dbtable . '`.created ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_ORDERED:
                        $join_orders_date = TRUE;
                        $fields['jopd.order_last_date'] = 'jopd.order_last_date';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'jopd.order_last_date ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jopd.order_last_date IS NOT NULL ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_COMMENTED:
                        $join_products_comments = TRUE;
                        $fields['jpc.comment_last_date'] = 'jpc.comment_last_date';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'jpc.comment_last_date ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpc.comment_last_date IS NOT NULL ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_COMMENTS:
                        $join_products_comments = TRUE;
                        $fields['jpc.product_comments_count'] = 'jpc.product_comments_count';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'jpc.product_comments_count ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND jpc.product_comments_count > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_BROWSED:
                        $fields['browsed'] = 'ABS(`' . $this->dbtable . '`.browsed) AS browsed';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'browsed ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND ABS(`' . $this->dbtable . '`.browsed) > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_VOTES:
                        $fields['votes'] = 'ABS(`' . $this->dbtable . '`.votes) AS votes';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'votes ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND ABS(`' . $this->dbtable . '`.votes) > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_RATING:
                        $fields['rating'] = 'ABS(`' . $this->dbtable . '`.rating) AS rating';
                        $fields['votes'] = 'ABS(`' . $this->dbtable . '`.votes) AS votes';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'rating / (votes + 1) ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND ABS(`' . $this->dbtable . '`.rating) / (ABS(`' . $this->dbtable . '`.votes) + 1) > 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_URL:
                        $fields[$this->dbtable . '.url'] = $this->dbtable . '.url';
                        $order = $this->dbtable . '.url ' . $direction;
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.url) != "" ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_MENU:
                        $join_menu = TRUE;
                        $fields['menu'] = DATABASE_MENUS_TABLENAME . '.name AS menu';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'menu ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . DATABASE_MENUS_TABLENAME . '.name) != "" ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_OBJECTS:
                        $fields[$this->dbtable . '.objects'] = $this->dbtable . '.objects';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = $this->dbtable . '.objects ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.objects) != "" ';



                    case SORT_PRODUCTS_MODE_BY_PCODE:
                        $fields[$this->dbtable . '.pcode'] = $this->dbtable . '.pcode';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = $this->dbtable . '.pcode ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.pcode) != "" ';
                        break;



                    case SORT_PRODUCTS_MODE_BY_USER:
                        $join_users = TRUE;
                        $fields['user_name'] = DATABASE_USERS_TABLENAME . '.name AS user_name';
                        $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = 'user_name ' . $direction . ', '
                               . 'category_plural ASC, '
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.user_id != 0 ';
                        break;



                    case SORT_PRODUCTS_MODE_AS_IS:
                        if ($suffix == '') $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                        $fields[$this->dbtable . '.order_num' . $suffix] = $this->dbtable . '.order_num' . $suffix;
                        $order = (($suffix == '') ? 'category_plural ASC, ' : '')
                               . '`' . $this->dbtable . '`.order_num' . $suffix . ' DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . DATABASE_CATEGORIES_TABLENAME . '.name) != "" ';
                        break;
                }
            }



            // в сортировку всегда добавляем сдвиг в конец списка всех товаров не для продажи
            $fields[$this->dbtable . '.non_usable'] = $this->dbtable . '.non_usable';
            $order = $this->dbtable . '.non_usable ASC' . ($order != '' ? ',' : '') . ' ' . $order;



            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);



            // анализируем заданную степень полноты выбираемых записей
            $completeness = isset($params->completeness) ? $params->completeness : GET_PRODUCTS_COMPLETENESS_FOR_CATALOG;
            switch ($completeness) {
                case GET_PRODUCTS_COMPLETENESS_FOR_CATALOGMAP:
                case GET_PRODUCTS_COMPLETENESS_FOR_SITEMAP:
                case GET_PRODUCTS_COMPLETENESS_FOR_EDITORDER:
                    $join_brands = TRUE;
                    $fields[$this->dbtable . '.' . $this->id_field] = $this->dbtable . '.' . $this->id_field;
                    $fields[$this->dbtable . '.category_id'] = $this->dbtable . '.category_id';
                    $fields[$this->dbtable . '.model'] = $this->dbtable . '.model';
                    $fields[$this->dbtable . '.pcode'] = $this->dbtable . '.pcode';
                    $fields[$this->dbtable . '.url'] = $this->dbtable . '.url';
                    $fields[$this->dbtable . '.url_special'] = $this->dbtable . '.url_special';
                    $fields['category'] = DATABASE_CATEGORIES_TABLENAME . '.single_name AS category';
                    $fields['brand'] = DATABASE_BRANDS_TABLENAME . '.name AS brand';
                    break;
                case GET_PRODUCTS_COMPLETENESS_FOR_CONFIGURATOR:
                case GET_PRODUCTS_COMPLETENESS_FOR_PRICES:
                    $fields[$this->dbtable . '.' . $this->id_field] = $this->dbtable . '.' . $this->id_field;
                    $fields[$this->dbtable . '.category_id'] = $this->dbtable . '.category_id';
                    $fields[$this->dbtable . '.model'] = $this->dbtable . '.model';
                    $fields[$this->dbtable . '.url'] = $this->dbtable . '.url';
                    $fields[$this->dbtable . '.url_special'] = $this->dbtable . '.url_special';
                    break;
                case GET_PRODUCTS_COMPLETENESS_FOR_CATALOG:
                default:
                    $join_brands = TRUE;
                    $join_orders_products = TRUE;
                    $join_products_comments = TRUE;
                    $join_users = TRUE;
                    $join_menu = TRUE;
                    $join_shippings_terms = TRUE;
                    $fields[$this->dbtable . '.*'] = $this->dbtable . '.*';
                    $fields['stock'] = $this->dbtable . '.quantity AS stock';
                    $fields['created_date'] = 'DATE_FORMAT(`' . $this->dbtable . '`.created, "%Y-%m-%d") AS created_date';
                    $fields['created_time'] = 'DATE_FORMAT(`' . $this->dbtable . '`.created, "%H:%i:%s") AS created_time';
                    $fields['modified_date'] = 'DATE_FORMAT(`' . $this->dbtable . '`.modified, "%Y-%m-%d") AS modified_date';
                    $fields['modified_time'] = 'DATE_FORMAT(`' . $this->dbtable . '`.modified, "%H:%i:%s") AS modified_time';
                    $fields['coming_date'] = 'DATE_FORMAT(`' . $this->dbtable . '`.coming, "%d-%m-%Y") AS coming_date';
                    $fields['coming_time'] = 'DATE_FORMAT(`' . $this->dbtable . '`.coming, "%H:%i:%s") AS coming_time';
                    $fields['coming_compare'] = 'DATE_FORMAT(`' . $this->dbtable . '`.coming, "%Y%m%d") AS coming_compare';
                    $fields['browsed'] = 'ABS(`' . $this->dbtable . '`.browsed) AS browsed';
                    $fields['rating'] = 'ABS(`' . $this->dbtable . '`.rating) AS rating';
                    $fields['votes'] = 'ABS(`' . $this->dbtable . '`.votes) AS votes';
                    $fields['jpc.product_comments_count'] = 'jpc.product_comments_count';
                    $fields['jpc.comment_last_date'] = 'jpc.comment_last_date';
                    $fields['jop.product_orders_count'] = 'jop.product_orders_count';
                    $fields['jop.product_orders_sum'] = 'jop.product_orders_sum';
                    $fields['category_plural'] = DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural';
                    $fields['category'] = DATABASE_CATEGORIES_TABLENAME . '.single_name AS category';
                    $fields['category_url'] = DATABASE_CATEGORIES_TABLENAME . '.url AS category_url';
                    $fields['category_url_special'] = DATABASE_CATEGORIES_TABLENAME . '.url_special AS category_url_special';
                    $fields['category_image'] = DATABASE_CATEGORIES_TABLENAME . '.image AS category_image';
                    $fields['brand'] = DATABASE_BRANDS_TABLENAME . '.name AS brand';
                    $fields['brand_url'] = DATABASE_BRANDS_TABLENAME . '.url AS brand_url';
                    $fields['brand_url_special'] = DATABASE_BRANDS_TABLENAME . '.url_special AS brand_url_special';
                    $fields['user_name'] = DATABASE_USERS_TABLENAME . '.name AS user_name';
                    $fields['menu'] = DATABASE_MENUS_TABLENAME . '.name AS menu';
                    $fields['shippings_term'] = 'shippings_terms.name AS shippings_term';
                    $fields['discount_price'] = 'CASE WHEN `' . $this->dbtable . '`.temp_price != 0 '
                                                   . 'THEN ABS(`' . $this->dbtable . '`.temp_price) '
                                                   . 'ELSE ABS(`' . $this->dbtable . '`.price) * ABS(100 - CASE WHEN (`' . $this->dbtable . '`.priority_discount >= 0 AND `' . $this->dbtable . '`.priority_discount <= 100) '
                                                                                                             . 'THEN `' . $this->dbtable . '`.priority_discount '
                                                                                                             . 'ELSE ' . $this->cms->db->query_value($discount) . ' '
                                                                                                             . 'END) / 100 '
                                                   . 'END AS discount_price';
            }



            // части ожидаемого запроса
            $expected_query_begin = 'SELECT SQL_CALC_FOUND_ROWS ' . implode(', ', $fields) . ' ';
            $expected_query_body = 'FROM `' . $this->dbtable . '` '
                                 . 'LEFT JOIN `categories` ON `categories`.`category_id` = `' . $this->dbtable . '`.`category_id` '
                                                       . 'AND `categories`.`section` = `' . $this->dbtable . '`.`section` '
                                 . ($join_brands ? 'LEFT JOIN `brands` ON `brands`.`brand_id` = `' . $this->dbtable . '`.`brand_id` '
                                                                   . 'AND `brands`.`section` = `' . $this->dbtable . '`.`section` ' : '')
                                 . ($join_products_categories ? 'LEFT JOIN `products_categories` ON `products_categories`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` ' : '')
                                 . ($join_orders_products ? 'LEFT JOIN `jop` ON `jop`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` ' : '')
                                 . ($join_products_comments ? 'LEFT JOIN `jpc` ON `jpc`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` ' : '')
                                 . ($join_users ? 'LEFT JOIN `users` ON `users`.`user_id` = `' . $this->dbtable . '`.`user_id` ' : '')
                                 . ($join_menu ? 'LEFT JOIN `menu` ON `menu`.`menu_id` = `' . $this->dbtable . '`.`menu_id` ' : '')
                                 . ($join_variants ? 'LEFT JOIN `jpv` ON `jpv`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` ' : '')
                                 . ($join_orders_date ? 'LEFT JOIN `jopd` ON `jopd`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` ' : '')
                                 . ($join_shippings_terms ? 'LEFT JOIN `shippings_terms` ON `shippings_terms`.`term_id` = `' . $this->dbtable . '`.`shippings_term_id` ' : '')
                                 . 'WHERE `categories`.`enabled` = 1 '
                                        . 'AND (`brands`.`enabled` IS NULL OR `brands`.`enabled` = 1) '
                                        . $where;
            $expected_query_final = 'GROUP BY `' . $this->dbtable . '`.`' . $this->id_field . '` '
                                  . 'ORDER BY ' . $order
                                  . $limit;



            // если не удается взять из memcache
            $hash = $this->dbtable . '-' . strtolower(md5($expected_query_begin . $expected_query_body . $expected_query_final));
            $this->cms->db->open_tracing_method('DB MEMCACHE get [' . $hash . ']');
                $cache = null;
                $state = $this->memcache->get($hash, $cache);
            $this->cms->db->close_tracing_method();

            if (!$state) {
                $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get [checkQuery]');

                    $item_ids = array();



                    // если будет подключаться таблица вариантов товаров, создаем ее как временную индексированную
                    // для скорости объединения таблиц в LEFT JOIN вместо безиндексного варианта LEFT JOIN (SELECT нечто)
                    if ($join_variants) {
                        $query = 'DROP TEMPORARY TABLE `jpv`;';    // удаляем, потому что $jpv_fields изменчивый и есть $jpv_where
                        $this->cms->db->query($query);
                        $query = 'CREATE TEMPORARY TABLE `jpv` (PRIMARY KEY (`' . $this->id_field . '`)) ENGINE = MEMORY '
                                                      . 'SELECT `' . $this->id_field . '`, '
                                                              . implode(', ', $jpv_fields) . ' '
                                                      . 'FROM `products_variants` '
                                                      . $jpv_where
                                                      . 'GROUP BY `' . $this->id_field . '`;';
                        $this->cms->db->query($query);
                    }



                    // если будет подключаться таблица товаров в заказах, создаем ее как временную индексированную
                    // (IF NOT EXISTS специально не используем, чтобы при повторных вызовах из-за ошибки не срабатывал SELECT)
                    if ($join_orders_products) {
                        $query = 'CREATE TEMPORARY TABLE `jop` (PRIMARY KEY (`' . $this->id_field . '`)) ENGINE = MEMORY '
                                                      . 'SELECT `' . $this->id_field . '`, '
                                                             . 'SUM(ABS(`quantity`)) AS `product_orders_count`, '
                                                             . 'SUM(ABS(`price`)) AS `product_orders_sum` '
                                                      . 'FROM `' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '` '
                                                      . 'GROUP BY `' . $this->id_field . '`;';
                        $this->cms->db->query($query);
                    }
                    if ($join_orders_date) {
                        $query = 'CREATE TEMPORARY TABLE `jopd` (PRIMARY KEY (`' . $this->id_field . '`)) ENGINE = MEMORY '
                                                      . 'SELECT `' . $this->id_field . '`, '
                                                             . 'DATE_FORMAT(`' . DATABASE_ORDERS_TABLENAME . '`.`date`, "%Y-%m-%d %H:%i:%s") AS `order_last_date` '
                                                      . 'FROM `' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '` '
                                                      . 'LEFT JOIN `' . DATABASE_ORDERS_TABLENAME . '` '
                                                                . 'ON `' . DATABASE_ORDERS_TABLENAME . '`.`order_id` = `' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '`.`order_id` '
                                                      . 'WHERE `' . DATABASE_ORDERS_TABLENAME . '`.`status` != "' . $this->cms->db->query_value(ORDER_STATUS_CANCEL) . '" '
                                                      . 'GROUP BY `' . $this->id_field . '` '
                                                      . 'ORDER BY `order_last_date` DESC;';
                        $this->cms->db->query($query);
                    }



                    // если будет подключаться таблица отзывов о товарах, создаем ее как временную индексированную
                    if ($join_products_comments) {
                        $query = 'CREATE TEMPORARY TABLE `jpc` (PRIMARY KEY (`' . $this->id_field . '`)) ENGINE = MEMORY '
                                                      . 'SELECT `' . $this->id_field . '`, '
                                                             . 'COUNT(`enabled`) AS `product_comments_count`, '
                                                             . 'DATE_FORMAT(`date`, "%Y-%m-%d %H:%i:%s") AS `comment_last_date` '
                                                      . 'FROM `' . DATABASE_PRODUCTS_COMMENTS_TABLENAME . '` '
                                                      . 'WHERE `enabled` = 1 '
                                                      . 'GROUP BY `' . $this->id_field . '` '
                                                      . 'ORDER BY `comment_last_date` DESC;';
                        $this->cms->db->query($query);
                    }



                    // определяем число прогонов запроса
                    $pass = isset($params->info_ids) && $params->info_ids ? 2 : 1;

                    // делаем прогоны запроса
                    while ($pass > 0) {

                        // какой это прогон?
                        switch ($pass) {

                            // если получение проходящих фильтр ИД товаров
                            case 2:
                                $query_begin = 'SELECT `' . $this->dbtable . '`.`' . $this->id_field . '` ';
                                $query_final = 'GROUP BY `' . $this->dbtable . '`.`' . $this->id_field . '` '
                                             . 'ORDER BY `' . $this->id_field . '` ASC';
                                break;

                            // если ожидаемый к исполнению
                            case 1:
                            default:
                                $query_begin = $expected_query_begin;
                                $query_final = $expected_query_final;
                        }

                        // делаем запрос
                        $query = $query_begin
                               . $expected_query_body
                               . $query_final . ';';
                        $result = $this->cms->db->query($query);

                        // какой это прогон?
                        switch ($pass) {

                            // если получение проходящих фильтр ИД товаров
                            case 2:

                                // заполняем возвращаемый массив идентификаторами товаров
                                if ($result !== FALSE) {
                                    while ($row = $this->cms->db->fetch_object($result)) {
                                        if (!empty($row->product_id)) $item_ids[] = $row->product_id;
                                    }
                                }

                                // освобождаем память от запроса
                                $this->cms->db->free_result($result);
                                break;

                            // если ожидаемый к исполнению
                            case 1:
                            default:
                                $items = $this->cms->db->results();
                        }

                        // +1 прогон запроса сделан
                        $pass--;
                    }



                    // если из выбранных заказано сколько-то выбрать случайно
                    if (isset($params->randomcount) && !empty($items)) {
                        shuffle($items);
                        if (count($items) > $params->randomcount) $items = array_slice($items, 0, $params->randomcount);
                    }



                    // берем полное количество подобных записей
                    $result2 = $this->cms->db->query('SELECT FOUND_ROWS() AS `count`;');
                    $count = $this->cms->db->result();
                    $count = isset($count->count) ? $count->count : 0;

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);
                    $this->cms->db->free_result($result2);



                    // кешируем в memcache
                    $this->cms->db->open_tracing_method('DB MEMCACHE set [' . $hash . ']');
                        $cache = array();
                        $cache['items'] = & $items;
                        $cache['ids'] = & $item_ids;
                        $cache['count'] = $count;
                        $this->memcache->set($hash, $cache);
                    $this->cms->db->close_tracing_method();

                $this->cms->db->close_tracing_method();

            // иначе удалось взять из memcache, убеждаемся что это массив
            } else {
                $items = array();
                    if (isset($cache['items'])) $items = $cache['items'];
                    if (!is_array($items)) $items = array();
                $item_ids = array();
                    if (isset($cache['ids'])) $item_ids = $cache['ids'];
                    if (!is_array($item_ids)) $item_ids = array();
                $count = 0;
                    if (isset($cache['count'])) $count = $cache['count'];
                    if (!is_integer($count)) $count = 0;
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем количество записей
            return $count;
        }



        // =======================================================================
        // Взять из базы данных запись о товаре, указанном в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->sync_id] = синхронизационный идентификатор записи
        //   [$params->variant_id] = идентификатор варианта товара
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->model] = название товара
        //   [$params->category_id] = идентификатор категории
        //   [$params->brand_id] = идентификатор бренда
        //   [$params->menu_id] = идентификатор меню
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->section] = раздел магазина
        //   [$params->url] = адрес страницы записи
        //   [$params->url_special] = с особым url
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->category_enabled] = признак "с разрешенной категорией и брендом"
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        //   [$params->non_creditable] = признак "не для кредита"
        //   [$params->non_usable] = признак "не для продажи"
        //   [$params->domained] = признак "имеет субдомен"
        //   [$params->subdomain] = имя субдомена
        //   [$params->subdomain_enabled] = признак "субдомен разрешен"
        //   [$params->discount] = величина скидки клиента
        //   [$params->price_id] = идентификатор ценовой группы клиента
        //   [$params->with_related] = признак чтения связанных товаров
        // =======================================================================

        public function one ( & $item, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' one');



            $item = null;
            $where = '';
            $discount = isset($params->discount) ? $this->cms->db->fix_discount($params->discount) : 0;



            // если не задан идентификатор товара, но задан идентификатор его варианта
            if (!isset($params->id) || empty($params->id)) {
                if (isset($params->variant_id) && !empty($params->variant_id)) {

                    // находим идентификатор такого товара
                    $query = 'SELECT `' . $this->id_field . '` '
                           . 'FROM `products_variants` '
                           . 'WHERE `variant_id` = "' . $this->cms->db->query_value($params->variant_id) . '" '
                           . 'LIMIT 1;';
                    $result = $this->cms->db->query($query);
                    $row = $this->cms->db->result();

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // если нашли, передаем идентификатор в параметры (будто метод вызвали уже с таким идентификатором)
                    if (isset($row->product_id)) $params->id = $row->product_id;
                }
            }



            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` = "' . $this->cms->db->query_value($params->id) . '" ';
            if (isset($params->sync_id) && !empty($params->sync_id)) $where .= 'AND `' . $this->dbtable . '`.`sync_id` = "' . $this->cms->db->query_value($params->sync_id) . '" ';
            if (isset($params->model)) $where .= 'AND `' . $this->dbtable . '`.model = "' . $this->cms->db->query_value($params->model) . '" ';
            if (isset($params->url)) $where .= 'AND `' . $this->dbtable . '`.url = "' . $this->cms->db->query_value($params->url) . '" ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` != "' . $this->cms->db->query_value($params->exclude_id) . '" ';
                if (isset($params->category_id)) $where .= 'AND `' . $this->dbtable . '`.category_id = "' . $this->cms->db->query_value($params->category_id) . '" ';
                if (isset($params->brand_id)) $where .= 'AND `' . $this->dbtable . '`.brand_id = "' . $this->cms->db->query_value($params->brand_id) . '" ';
                if (isset($params->menu_id)) $where .= 'AND `' . $this->dbtable . '`.menu_id = "' . $this->cms->db->query_value($params->menu_id) . '" ';
                if (isset($params->user_id)) $where .= 'AND `' . $this->dbtable . '`.user_id = "' . $this->cms->db->query_value($params->user_id) . '" ';
                if (isset($params->section)) $where .= 'AND `' . $this->dbtable . '`.section = "' . $this->cms->db->query_value($params->section) . '" ';
                if (isset($params->enabled)) $where .= 'AND `' . $this->dbtable . '`.enabled = "' . $this->cms->db->query_value($params->enabled) . '" ';
                if (isset($params->category_enabled)) {
                    $where .= 'AND ' . DATABASE_CATEGORIES_TABLENAME . '.enabled = "' . $this->cms->db->query_value($params->category_enabled) . '" ';
                    $where .= 'AND (' . DATABASE_BRANDS_TABLENAME . '.enabled IS ' . ($params->category_enabled ? 'NULL OR ' : 'NOT NULL AND ') . DATABASE_BRANDS_TABLENAME . '.enabled = "' . $this->cms->db->query_value($params->category_enabled) . '") ';
                }
                if (isset($params->highlighted)) $where .= 'AND `' . $this->dbtable . '`.highlighted = "' . $this->cms->db->query_value($params->highlighted) . '" ';
                if (isset($params->hidden)) $where .= 'AND `' . $this->dbtable . '`.hidden = "' . $this->cms->db->query_value($params->hidden) . '" ';
                if (isset($params->rss_disabled)) $where .= 'AND `' . $this->dbtable . '`.rss_disabled = "' . $this->cms->db->query_value($params->rss_disabled) . '" ';
                if (isset($params->export_disabled)) $where .= 'AND `' . $this->dbtable . '`.export_disabled = "' . $this->cms->db->query_value($params->export_disabled) . '" ';
                if (isset($params->non_creditable)) $where .= 'AND `' . $this->dbtable . '`.non_creditable = "' . $this->cms->db->query_value($params->non_creditable) . '" ';
                if (isset($params->non_usable)) $where .= 'AND `' . $this->dbtable . '`.non_usable = "' . $this->cms->db->query_value($params->non_usable) . '" ';
                if (isset($params->subdomain)) $where .= 'AND `' . $this->dbtable . '`.subdomain = "' . $this->cms->db->query_value($params->subdomain) . '" ';
                if (isset($params->subdomain_enabled)) $where .= 'AND `' . $this->dbtable . '`.sudbomain_enabled = "' . $this->cms->db->query_value($params->subdomain_enabled) . '" ';
                if (isset($params->domained)) $where .= 'AND TRIM(`' . $this->dbtable . '`.subdomain) != "" AND `' . $this->dbtable . '`.subdomain_enabled = 1 ';
                if (isset($params->url_special)) $where .= 'AND `' . $this->dbtable . '`.url_special = "' . $this->cms->db->query_value($params->url_special) . '" ';
                $where = 'WHERE 1 ' . $where;



                // делаем запрос
                $query = 'SELECT `' . $this->dbtable . '`.*, '
                              . 'CASE WHEN `' . $this->dbtable . '`.temp_price != 0 '
                                   . 'THEN ABS(`' . $this->dbtable . '`.temp_price) '
                                   . 'ELSE ABS(`' . $this->dbtable . '`.price) * ABS(100 - CASE WHEN (`' . $this->dbtable . '`.priority_discount >= 0 AND `' . $this->dbtable . '`.priority_discount <= 100) '
                                                                                             . 'THEN `' . $this->dbtable . '`.priority_discount '
                                                                                             . 'ELSE ' . $discount . ' '
                                                                                             . 'END) / 100 '
                                   . 'END AS discount_price, '
                              . '`' . $this->dbtable . '`.quantity AS stock, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.created, "%Y-%m-%d") AS created_date, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.created, "%H:%i:%s") AS created_time, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.modified, "%Y-%m-%d") AS modified_date, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.modified, "%H:%i:%s") AS modified_time, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.coming, "%d-%m-%Y") AS coming_date, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.coming, "%H:%i:%s") AS coming_time, '
                              . 'DATE_FORMAT(`' . $this->dbtable . '`.coming, "%Y%m%d") AS coming_compare, '
                              . 'ABS(`' . $this->dbtable . '`.browsed) AS browsed, '
                              . 'ABS(`' . $this->dbtable . '`.rating) AS rating, '
                              . 'ABS(`' . $this->dbtable . '`.votes) AS votes, '
                              . 'jpc.product_comments_count, '
                              . 'jpc.comment_last_date, '
                              . 'jop.product_orders_count, '
                              . 'jop.product_orders_sum, '
                              . DATABASE_CATEGORIES_TABLENAME . '.name AS category_plural, '
                              . DATABASE_CATEGORIES_TABLENAME . '.single_name AS category, '
                              . DATABASE_CATEGORIES_TABLENAME . '.url AS category_url, '
                              . DATABASE_CATEGORIES_TABLENAME . '.url_special AS category_url_special, '
                              . DATABASE_CATEGORIES_TABLENAME . '.image AS category_image, '
                              . DATABASE_BRANDS_TABLENAME . '.name AS brand, '
                              . DATABASE_BRANDS_TABLENAME . '.url AS brand_url, '
                              . DATABASE_BRANDS_TABLENAME . '.url_special AS brand_url_special, '
                              . DATABASE_USERS_TABLENAME . '.name AS user_name, '
                              . 'shippings_terms.name AS shippings_term '
                       . 'FROM `' . $this->dbtable . '` '
                       . 'LEFT JOIN ' . DATABASE_CATEGORIES_TABLENAME . ' '
                                 . 'ON ' . DATABASE_CATEGORIES_TABLENAME . '.category_id = `' . $this->dbtable . '`.category_id '
                                    . 'AND ' . DATABASE_CATEGORIES_TABLENAME . '.section = `' . $this->dbtable . '`.section '
                       . 'LEFT JOIN ' . DATABASE_BRANDS_TABLENAME . ' '
                                 . 'ON ' . DATABASE_BRANDS_TABLENAME . '.brand_id = `' . $this->dbtable . '`.brand_id '
                                    . 'AND ' . DATABASE_BRANDS_TABLENAME . '.section = `' . $this->dbtable . '`.section '
                       . 'LEFT JOIN ' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . ' '
                                 . 'ON ' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` '
                       . 'LEFT JOIN (SELECT `' . $this->id_field . '`, '
                                         . 'SUM(ABS(quantity)) AS product_orders_count, '
                                         . 'SUM(ABS(price)) AS product_orders_sum '
                                  . 'FROM ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . ' '
                                  . 'GROUP BY `' . $this->id_field . '`) AS jop '
                                                                         . 'ON jop.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` '
                       . 'LEFT JOIN (SELECT `' . $this->id_field . '`, '
                                         . 'COUNT(enabled) AS product_comments_count, '
                                         . 'date AS comment_last_date '
                                  . 'FROM ' . DATABASE_PRODUCTS_COMMENTS_TABLENAME . ' '
                                  . 'WHERE enabled = 1 '
                                  . 'GROUP BY `' . $this->id_field . '` '
                                  . 'ORDER BY date DESC) AS jpc '
                                                         . 'ON jpc.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` '
                       . 'LEFT JOIN ' . DATABASE_USERS_TABLENAME . ' '
                                 . 'ON ' . DATABASE_USERS_TABLENAME . '.user_id = `' . $this->dbtable . '`.user_id '
                       . 'LEFT JOIN shippings_terms '
                                 . 'ON shippings_terms.term_id = `' . $this->dbtable . '`.shippings_term_id '
                       . $where
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $item = $this->cms->db->result();



                // освобождаем память от запроса
                $this->cms->db->free_result($result);



                // читаем канонический товар
                if (!empty($item)) {
                    $item->canonical_model = '';
                    $item->canonical_url = '';
                    $item->canonical_url_special = FALSE;
                    if (!empty($item->canonical_id)) {
                        $query = 'SELECT `' . $this->dbtable . '`.`model`, '
                                      . '`' . $this->dbtable . '`.`url`, '
                                      . '`' . $this->dbtable . '`.`url_special` '
                               . 'FROM `' . $this->dbtable . '` '
                               . 'WHERE `' . $this->dbtable . '`.`product_id` = "' . $this->cms->db->query_value($item->canonical_id) . '" '
                               . 'LIMIT 1;';
                        $result = $this->cms->db->query($query);
                        $row = $this->cms->db->result();
                        $this->cms->db->free_result($result);
                        if (!empty($row)) {
                            $item->canonical_model = $row->model;
                            $item->canonical_url = $row->url;
                            $item->canonical_url_special = $row->url_special;
                        }
                    }

                    // поправляем поля записи
                    $this->unpack($item, $params);
                }
            }



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // =======================================================================
        // Кешировать усеченную в размерах таблицу товаров (CategoriesBrands Products ShortVersion):
        //   [$params->section] = раздел магазина
        // =======================================================================

        public function caching_CatsBrandsProducts_short ( $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' caching_CatsBrandsProducts_short');

            // формируем SELECT (без вступительного слова SELECT и закрывающего ;)
            $select = '`category_id`, '
                    . '`brand_id`, '
                    . '`' . $this->id_field . '` '
            . 'FROM `' . $this->dbtable . '` '
            . 'WHERE `enabled` = 1'
                  . (isset($params->section) ? ' AND `' . $this->dbtable . '`.`section` = "' . $this->cms->db->query_value($params->section) . '"' : '');

            // формируем список объявлений индексов
            $indexes = 'INDEX (`category_id`), '
                     . 'INDEX (`brand_id`), '
                     . 'INDEX (`' . $this->id_field . '`)';

            // кешируем результаты запроса (разрешаем в памяти, так как таблица небольшая и не содержит BLOB/TEXT колонок)
            $this->cms->db->caching_SELECT($select,
                                           $this->dbtable,
                                           $indexes,
                                           DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME,
                                           DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_LIFETIME,
                                           TRUE);

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Очистка кеш-таблицы и зависимых кешей
        *
        *  @access  public
        *  @param   object  $item       объект обрабатывавшейся записи (содержащей меняемые поля)
        *  @return  void
        */
        // ===================================================================

        public function resetCaches ( & $item = null ) {

            // если очистку кеша пока просят не делать
            if (!parent::resetCaches($item)) return;

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' resetCaches');

            // очищаем нужные кеш-таблицы
            $tables = DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME . ', '
                    . DATABASE_CACHE_CATEGORIES_TABLENAME . ', '
                    . DATABASE_CACHE_BRANDS_TABLENAME . ', '
                    . 'cache_pvnames';
            $this->cms->db->reset_dbtables($tables);

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // =======================================================================
        // Добавить в записи о товарах оперативные ссылки админпанели:
        //   $items = массив записей
        //   $params->token = аутентификатор операции
        //   [$params->sort] = способ сортировки записей
        // =======================================================================

        public function operable ( & $items, $params ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' operable');

            if (!empty($items) && isset($params->token)) {
                foreach ($items as & $item) {
                    if (isset($item->product_id)) {

                        // собираем параметры
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'Products',
                                         REQUEST_PARAM_NAME_ITEMID => $item->product_id,
                                         REQUEST_PARAM_NAME_TOKEN => $params->token);
                        if (isset($params->sort)) $options[REQUEST_PARAM_NAME_SORT] = $params->sort;



                        // создаем ссылку "поднять выше"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_MOVEUP;
                        $item->move_up_get = $this->cms->form_get($options);



                        // создаем ссылку "опустить ниже"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_MOVEDOWN;
                        $item->move_down_get = $this->cms->form_get($options);



                        // создаем ссылку "поставить первым"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_MOVEFIRST;
                        $item->move_first_get = $this->cms->form_get($options);



                        // создаем ссылку "поставить последним"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_MOVELAST;
                        $item->move_last_get = $this->cms->form_get($options);



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "разрешен"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);



                        // создаем ссылку "выделен"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_HIGHLIGHTED;
                        $item->highlight_get = $this->cms->form_get($options);



                        // создаем ссылку "скрыт от чужих"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_HIDDEN;
                        $item->hidden_get = $this->cms->form_get($options);



                        // создаем ссылку "обсуждаем"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COMMENTED;
                        $item->commented_get = $this->cms->form_get($options);



                        // создаем ссылку "имеет ли субдомен"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DOMAINED;
                        $item->domained_get = $this->cms->form_get($options);



                        // создаем ссылку "хит продаж"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_HIT;
                        $item->hit_get = $this->cms->form_get($options);



                        // создаем ссылку "новинка"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_NEWEST;
                        $item->newest_get = $this->cms->form_get($options);



                        // создаем ссылку "акционный"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ACTIONAL;
                        $item->actional_get = $this->cms->form_get($options);



                        // создаем ссылку "скоро в продаже"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_AWAITED;
                        $item->awaited_get = $this->cms->form_get($options);



                        // создаем ссылку "экспорт в Яндекс.Маркет"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_YMARKET;
                        $item->ymarket_get = $this->cms->form_get($options);



                        // создаем ссылку "экспорт ВКонтакте"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_VKONTAKTE;
                        $item->vkontakte_get = $this->cms->form_get($options);



                        // создаем ссылку "создать копию"
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Product';
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COPY;
                        $item->copy_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Product';
                        $item->edit_get = $this->cms->form_get($options);
                    }
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Обновление / добавление записи в базе данных
        *
        *  @access  public
        *  @param   object  $item   объект записи (содержит изменившиеся поля):
        *                               ->variants = массив записей об обновляемых вариантах
        *                               ->categories = массив записей о вторичных прикреплениях к категориям
        *                               ->related = список (через запятую) артикулов связанных товаров
        *                               ->properties = массив записей о свойствах товара
        *                               ->indifferent_caches = TRUE если не очищать кеши
        *  @param   mixed   $slave  FALSE если запись основной таблицы (по умолчанию FALSE)
        *                           TRUE если запись первой зависимой таблицы
        *                           ЧИСЛО если запись такой по счету таблицы
        *  @return  integer         идентификатор обработанной записи
        *                           пустая строка если ошибка
        */
        // ===================================================================

        public function update ( & $item, $slave = FALSE ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' update');

            $id = '';
            if (!empty($item)) {

                // готовим изменившиеся поля
                $fields = array(); $values = array();
                $id_field = $this->id_field;
                if (isset($item->$id_field))          {$fields[] = $id_field;            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->$id_field)) . '"';}
                if (isset($item->sync_id))            {$fields[] = 'sync_id';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->sync_id)) . '"';}
                if (isset($item->menu_id))            {$fields[] = 'menu_id';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->menu_id)) . '"';}
                if (isset($item->category_id))        {$fields[] = 'category_id';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->category_id)) . '"';}
                if (isset($item->brand_id))           {$fields[] = 'brand_id';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->brand_id)) . '"';}
                if (isset($item->user_id))            {$fields[] = 'user_id';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->user_id)) . '"';}
                if (isset($item->shippings_term_id))  {$fields[] = 'shippings_term_id';  $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->shippings_term_id)) . '"';}
                if (isset($item->objects))            {$fields[] = 'objects';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->objects)) . '"';}
                if (isset($item->hit))                {$fields[] = 'hit';                $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->hit)) . '"';}
                if (isset($item->newest))             {$fields[] = 'newest';             $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->newest)) . '"';}
                if (isset($item->actional))           {$fields[] = 'actional';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->actional)) . '"';}
                if (isset($item->awaited))            {$fields[] = 'awaited';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->awaited)) . '"';}
                if (isset($item->ymarket))            {$fields[] = 'ymarket';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->ymarket)) . '"';}
                if (isset($item->vkontakte))          {$fields[] = 'vkontakte';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->vkontakte)) . '"';}
                if (isset($item->enabled))            {$fields[] = 'enabled';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->enabled)) . '"';}
                if (isset($item->highlighted))        {$fields[] = 'highlighted';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->highlighted)) . '"';}
                if (isset($item->commented))          {$fields[] = 'commented';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->commented)) . '"';}
                if (isset($item->hidden))             {$fields[] = 'hidden';             $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->hidden)) . '"';}
                if (isset($item->rss_disabled))       {$fields[] = 'rss_disabled';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->rss_disabled)) . '"';}
                if (isset($item->export_disabled))    {$fields[] = 'export_disabled';    $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->export_disabled)) . '"';}
                if (isset($item->non_creditable))     {$fields[] = 'non_creditable';     $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->non_creditable)) . '"';}
                if (isset($item->non_usable))         {$fields[] = 'non_usable';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->non_usable)) . '"';}
                if (isset($item->in_prices))          {$fields[] = 'in_prices';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->in_prices)) . '"';}
                if (isset($item->url))                {$fields[] = 'url';                $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->url)) . '"';}
                if (isset($item->url_special))        {$fields[] = 'url_special';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->url_special)) . '"';}
                if (isset($item->canonical_id))       {$fields[] = 'canonical_id';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->canonical_id)) . '"';}
                if (isset($item->meta_title))         {$fields[] = 'meta_title';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->meta_title)) . '"';}
                if (isset($item->meta_keywords))      {$fields[] = 'meta_keywords';      $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->meta_keywords)) . '"';}
                if (isset($item->meta_description))   {$fields[] = 'meta_description';   $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->meta_description)) . '"';}
                if (isset($item->model))              {$fields[] = 'model';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->model)) . '"';}
                if (isset($item->description))        {$fields[] = 'description';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->description)) . '"';}
                if (isset($item->body))               {$fields[] = 'body';               $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->body)) . '"';}
                if (isset($item->seo_description))    {$fields[] = 'seo_description';    $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->seo_description)) . '"';}
                if (isset($item->download))           {$fields[] = 'download';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->download)) . '"';}
                if (isset($item->price))              {$fields[] = 'price';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->price)) . '"';}
                if (isset($item->temp_price))         {$fields[] = 'temp_price';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->temp_price)) . '"';}
                if (isset($item->old_price))          {$fields[] = 'old_price';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->old_price)) . '"';}
                if (isset($item->priority_discount))  {$fields[] = 'priority_discount';  $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->priority_discount)) . '"';}
                if (isset($item->guarantee))          {$fields[] = 'guarantee';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->guarantee)) . '"';}
                if (isset($item->quantity))           {$fields[] = 'quantity';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->quantity)) . '"';}
                if (isset($item->pcode))              {$fields[] = 'pcode';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->pcode)) . '"';}
                if (isset($item->barcode))            {$fields[] = 'barcode';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->barcode)) . '"';}
                if (isset($item->video))              {$fields[] = 'video';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->video)) . '"';}
                if (isset($item->article_ids))        {$fields[] = 'article_ids';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->article_ids)) . '"';}
                if (isset($item->news_ids))           {$fields[] = 'news_ids';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->news_ids)) . '"';}
                if (isset($item->accessory_pids))     {$fields[] = 'accessory_pids';     $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->accessory_pids)) . '"';}
                if (isset($item->related_pids))       {$fields[] = 'related_pids';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->related_pids)) . '"';}
                if (isset($item->related_cids))       {$fields[] = 'related_cids';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->related_cids)) . '"';}
                if (isset($item->related_bids))       {$fields[] = 'related_bids';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->related_bids)) . '"';}
                if (isset($item->subdomain))          {$fields[] = 'subdomain';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->subdomain)) . '"';}
                if (isset($item->subdomain_enabled))  {$fields[] = 'subdomain_enabled';  $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->subdomain_enabled)) . '"';}
                if (isset($item->subdomain_html))     {$fields[] = 'subdomain_html';     $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->subdomain_html)) . '"';}
                if (isset($item->template))           {$fields[] = 'template';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->template)) . '"';}
                if (isset($item->small_image))        {$fields[] = 'small_image';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->small_image)) . '"';}
                if (isset($item->large_image))        {$fields[] = 'large_image';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->large_image)) . '"';}
                if (isset($item->images))             {$fields[] = 'images';             $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images)) . '"';}
                if (isset($item->images_alts))        {$fields[] = 'images_alts';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images_alts)) . '"';}
                if (isset($item->images_texts))       {$fields[] = 'images_texts';       $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images_texts)) . '"';}
                if (isset($item->images_view))        {$fields[] = 'images_view';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->images_view)) . '"';}
                if (isset($item->files))              {$fields[] = 'files';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->files)) . '"';}
                if (isset($item->files_alts))         {$fields[] = 'files_alts';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->files_alts)) . '"';}
                if (isset($item->files_texts))        {$fields[] = 'files_texts';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->files_texts)) . '"';}
                if (isset($item->coming))             {$fields[] = 'coming';             $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_date($item->coming)) . '"';}
                if (isset($item->tags))               {$fields[] = 'tags';               $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->tags)) . '"';}
                if (isset($item->created))            {$fields[] = 'created';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_date($item->created)) . '"';}
                if (isset($item->modified))           {$fields[] = 'modified';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_date($item->modified)) . '"';}
                if (isset($item->browsed))            {$fields[] = 'browsed';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_natural($item->browsed)) . '"';}
                if (isset($item->rating))             {$fields[] = 'rating';             $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_positive($item->rating)) . '"';}
                if (isset($item->votes))              {$fields[] = 'votes';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_natural($item->votes)) . '"';}
                if (isset($item->order_num))          {$fields[] = 'order_num';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_num)) . '"';}
                if (isset($item->order_num_hit))      {$fields[] = 'order_num_hit';      $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_num_hit)) . '"';}
                if (isset($item->order_num_newest))   {$fields[] = 'order_num_newest';   $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_num_newest)) . '"';}
                if (isset($item->order_num_actional)) {$fields[] = 'order_num_actional'; $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_num_actional)) . '"';}
                if (isset($item->order_num_awaited))  {$fields[] = 'order_num_awaited';  $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_num_awaited)) . '"';}
                if (isset($item->section))            {$fields[] = 'section';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->section)) . '"';}

                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, $this->dbtable, $this->id_field, $fields, $values);

                // если выполнено
                if (!empty($id)) {

                    // если существуют варианты товара
                    if (isset($item->variants)) {
                        $id_filter = array();
                        // добавляем/обновляем записи вариантов
                        foreach ($item->variants as & $row) {
                            if (!isset($row->product_id) || empty($row->product_id)) $row->product_id = $id;
                            $row->variant_id = $this->update_variant($row);
                            if (!empty($row->variant_id)) $id_filter[$row->variant_id] = $row->variant_id;
                        }
                        // удаляем записи неиспользующихся более вариантов
                        $id_filter = implode(',', $id_filter);
                        $query = 'DELETE FROM `products_variants` '
                               . 'WHERE ' . ($id_filter != '' ? '`variant_id` NOT IN (' . $id_filter . ') AND ' : '')
                                          . '`' . $this->id_field . '` = "' . $this->cms->db->query_value($id) . '";';
                        $this->cms->db->query($query);
                    }

                    // если существуют вторичные прикрепления к категориям
                    if (isset($item->categories)) {
                        // удаляем прежние записи о прикреплениях
                        $query = 'DELETE FROM `' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '` '
                               . 'WHERE `' . $this->id_field . '` = "' . $this->cms->db->query_value($id) . '";';
                        $this->cms->db->query($query);
                        // добавляем новые записи о прикреплениях
                        foreach ($item->categories as & $row) {
                            $row = intval($row);
                            if (!empty($row)) {
                                $query = 'INSERT INTO `' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '` (`' . $this->id_field . '`, '
                                                                                                     . '`category_id`) '
                                       . 'VALUES ("' . $this->cms->db->query_value($id) . '", '
                                               . '"' . $this->cms->db->query_value($row) . '");';
                                $this->cms->db->query($query);
                            }
                        }
                    }

                    // если существуют связанные товары
                    if (isset($item->related)) {
                        // удаляем прежние записи о связях
                        $query = 'DELETE FROM `' . DATABASE_PRODUCTS_RELATED_TABLENAME . '` '
                               . 'WHERE `' . $this->id_field . '` = "' . $this->cms->db->query_value($id) . '";';
                        $this->cms->db->query($query);

                        // добавляем новые записи о связях
                        $items = explode(',', $item->related);
                        foreach ($items as & $sku) {
                            $sku = trim($sku);
                            if ($sku != '') {

                                // делаем запрос, есть ли товар с таким артикулом
                                $query = 'SELECT `' . $this->id_field . '` '
                                       . 'FROM `products_variants` '
                                       . 'WHERE `sku` = "' . $this->cms->db->query_value($sku) . '" '
                                       . 'LIMIT 1;';
                                $result = $this->cms->db->query($query);
                                $product = $this->cms->db->result();

                                // освобождаем память от запроса
                                $this->cms->db->free_result($result);

                                // если товар с таким артикулом найден, добавляем в связанные
                                if (!empty($product)) {
                                    $query = 'INSERT INTO `' . DATABASE_PRODUCTS_RELATED_TABLENAME . '` (`' . $this->id_field . '`, '
                                                                                                      . '`related_sku`) '
                                           . 'VALUES ("' . $this->cms->db->query_value($id) . '", '
                                                   . '"' . $this->cms->db->query_value($sku) . '");';
                                    $this->cms->db->query($query);
                                }
                            }
                        }
                    }

                    // если существуют свойства товара
                    if (isset($item->properties) && isset($item->category_id)) {
                        // удаляем прежние записи о свойствах
                        $query = 'DELETE FROM `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '` '
                               . 'WHERE `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '`.`' . $this->id_field . '` = "' . $this->cms->db->query_value($id) . '";';
                        $this->cms->db->query($query);
                        // берем список свойств товаров, используемых в такой категории
                        $params = new stdClass;
                        $params->category_id = $item->category_id;
                        $this->cms->db->get_properties($items, $params);
                        // добавляем новые записи о свойствах
                        foreach ($items as & $property) {
                            if (isset($item->properties[$property->property_id])) {
                                foreach ($item->properties[$property->property_id] as $index => $value) {
                                    $index = intval($index);
                                    $value = trim($value);
                                    if ($value != '') {
                                        $query = 'INSERT INTO `' . DATABASE_PROPERTIES_VALUES_TABLENAME . '` (`' . $this->id_field . '`, '
                                                                                                           . '`property_id`, '
                                                                                                           . '`order_num`, '
                                                                                                           . '`value`) '
                                             . 'VALUES ("' . $this->cms->db->query_value($id) . '", '
                                                     . '"' . $this->cms->db->query_value($property->property_id) . '", '
                                                     . '"' . $this->cms->db->query_value($index) . '", '
                                                     . '"' . $this->cms->db->query_value($value) . '");';
                                        $this->cms->db->query($query);
                                    }
                                }
                            }
                        }
                    }

                    // проверяем необходимость очистить кеш-таблицы товаров
                    $this->resetCaches($item);
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем идентификатор обновленной / добавленной записи
            return $id;
        }



        // ===================================================================
        /**
        *  Распаковка полей записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   object  $params     объект параметров
        *                               [$params->price_id] = идентификатор ценовой группы
        *                               [$params->discount] = величина скидки клиента
        *                               [$params->with_related] = признак чтения связанных товаров
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {

            $price_id = isset($params->price_id) ? intval($params->price_id) : 0;
            $discount = isset($params->discount) ? $this->cms->db->fix_discount($params->discount) : 0;
            $with_related = isset($params->with_related) ? $params->with_related : FALSE;

            // поправляем строковые поля
            if (isset($item->category_plural)) $this->cms->db->fix_textfield_as_product_name($item->category_plural);
            if (isset($item->category)) $this->cms->db->fix_textfield_as_product_name($item->category);
            if (isset($item->brand)) $this->cms->db->fix_textfield_as_product_name($item->brand);
            if (isset($item->model)) $this->cms->db->fix_textfield_as_product_name($item->model);
            if (isset($item->canonical_model)) $this->cms->db->fix_textfield_as_product_name($item->canonical_model);
            if (isset($item->description)) $this->cms->db->fix_textfield_as_product_description($item->description);
            if (isset($item->body)) $this->cms->db->fix_textfield_as_product_description($item->body);
            if (isset($item->seo_description)) $this->cms->db->fix_textfield_as_product_description($item->seo_description);

            // поправляем поля изображений
            if (isset($item->large_image) && empty($item->large_image) && isset($item->small_image)) $item->large_image = $item->small_image;
            $this->unpack_images($item);
            $path = $this->cms->settings->products_files_folder_prefix . 'files/products/';
            if (isset($item->images_thumbs)) {
                foreach ($item->images_thumbs as $index => & $thumb) {
                    if (!preg_match('|^[a-z]+://|i', $thumb)) {
                        if (!file_exists(ROOT_FOLDER_REFERENCE . $path . $thumb)) {
                            $thumb = str_replace('.' . THUMBNAIL_FILENAME_MARKER, '.', $thumb);
                            if ($index == 0) $item->small_image = $thumb;
                        }
                    }
                }
            }

            // моделируем поле fotos (дополнительные фотографии товара)
            $path = 'http://' . $this->cms->root_url . '/' . $path;
            $item->fotos = array();
            $id = 0;
            foreach ($item->images as $image) {
                if (!isset($item->large_image) || ($item->large_image != $image)) {
                    $foto = new stdClass;
                    $foto->foto_id = $id;
                    $foto->filename = $path . $image;
                    $item->fotos[$id] = $foto;
                    $id++;
                }
            }
            if (isset($item->small_image) && !empty($item->small_image) && !preg_match('|^[a-z]+://|i', $item->small_image)) $item->small_image = $path . $item->small_image;
            if (isset($item->large_image) && !empty($item->large_image) && !preg_match('|^[a-z]+://|i', $item->large_image)) $item->large_image = $path . $item->large_image;

            // поправляем поля файлов
            $this->unpack_files($item);

            // канонический товар
            if (isset($item->canonical_id) && !empty($item->canonical_id)) {
                if (isset($item->canonical_url) && trim($item->canonical_url) == '') $item->canonical_url = $item->canonical_id;
                $item->canonical_url_path = isset($item->canonical_url_special) && $item->canonical_url_special ? '' : 'products/';
            }

            // поправляем адресующие поля
            if (isset($item->product_id)) {
                $item->product_id = intval($item->product_id);
                $this->unpackUrl($item, 'products');
                $item->category_url_path = isset($item->category_url_special) && $item->category_url_special ? '' : 'catalog/';
                $item->brand_url_path = isset($item->brand_url_special) && $item->brand_url_special ? '' : 'brands/';

                // поправляем поле родительских категорий
                if (!isset($item->categories)) {
                    $item->categories = array();
                    if (isset($item->category_id)) $item->categories[$item->category_id] = $item->category_id;
                    $query = 'SELECT `category_id` '
                           . 'FROM `products_categories` '
                           . 'WHERE `' . $this->id_field . '` = "' . $this->cms->db->query_value($item->product_id) . '";';
                    $result = $this->cms->db->query($query);
                    $items = $this->cms->db->results();

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    foreach($items as & $row) {
                        $row = intval($row->category_id);
                        $item->categories[$row] = $row;
                    }
                }

                // поправляем поле имени администрирующего пользователя
                if (isset($item->user_name) && !empty($item->user_name)) {
                    $user = new stdClass;
                    $user->name = $item->user_name;
                    $this->unpackUserName($user);
                    $item->user_name = $user->compound_name;
                }

                // поправляем поля счетчиков
                if (!isset($item->product_comments_count)) $item->product_comments_count = 0;
                if (!isset($item->comment_last_date)) $item->comment_last_date = '';
                if (!isset($item->product_orders_count)) $item->product_orders_count = 0;
                if (!isset($item->product_orders_sum)) $item->product_orders_sum = 0;

        //        // кешируем картинки
        //        $recaching_timer = 0;
        //        $recaching_counter = 0;
        //        $recaching_mode = DONT_MAKE_IMAGE_RECACHING;
        //        if (isset($this->cms->settings->images_caching_timelimit) && ($recaching_timer <= $this->cms->settings->images_caching_timelimit)
        //        && isset($this->cms->settings->images_caching_filelimit) && ($recaching_counter <= $this->cms->settings->images_caching_filelimit)) {
        //          $recaching_mode = MAKE_IMAGE_RECACHING_IF_ENABLED;
        //        }
        //        $this->cms->db->fix_product_images_and_cache($item, 'small', $recaching_mode, $recaching_timer, $recaching_counter);
        //        if ($recaching_mode == MAKE_IMAGE_RECACHING_IF_ENABLED) {
        //          $recaching_mode = DONT_MAKE_IMAGE_RECACHING;
        //          if (isset($this->cms->settings->images_caching_timelimit) && ($recaching_timer <= $this->cms->settings->images_caching_timelimit)
        //          && isset($this->cms->settings->images_caching_filelimit) && ($recaching_counter <= $this->cms->settings->images_caching_filelimit)) {
        //            $recaching_mode = MAKE_IMAGE_RECACHING_IF_ENABLED;
        //          }
        //        }
        //        $this->cms->db->fix_product_images_and_cache($item, 'large', $recaching_mode, $recaching_timer, $recaching_counter);

                // заполнить запись вариантами товара
                $this->variants($item, $price_id, $discount);
                $this->cms->db->fill_products_properties_values_to_products_by_ids($item, $item->product_id, PRODUCTS_ARRAY_MODE_THIS_IS_ITEM);
                $this->cms->db->fill_products_wishlist_data($item, PRODUCTS_ARRAY_MODE_THIS_IS_ITEM);

                // поправляем поле списка связанных статей
                if (isset($item->article_ids) && is_string($item->article_ids)) {
                    $ids = explode(',', $item->article_ids);
                    $item->article_ids = array();
                    foreach ($ids as & $id) {
                        $id = intval($id);
                        if (!empty($id)) $item->article_ids[$id] = $id;
                    }
                }

                // поправляем поле списка связанных новостей
                if (isset($item->news_ids) && is_string($item->news_ids)) {
                    $ids = explode(',', $item->news_ids);
                    $item->news_ids = array();
                    foreach ($ids as & $id) {
                        $id = intval($id);
                        if (!empty($id)) $item->news_ids[$id] = $id;
                    }
                }

                // поправляем поле списка дополнительных товаров
                if (isset($item->accessory_pids) && is_string($item->accessory_pids)) {
                    $ids = explode(',', $item->accessory_pids);
                    $item->accessory_pids = array();
                    foreach ($ids as & $id) {
                        $id = intval($id);
                        if (!empty($id)) $item->accessory_pids[$id] = $id;
                    }
                }

                // поправляем поле списка похожих товаров
                if (isset($item->related_pids) && is_string($item->related_pids)) {
                    $ids = explode(',', $item->related_pids);
                    $item->related_pids = array();
                    foreach ($ids as & $id) {
                        $id = intval($id);
                        if (!empty($id)) $item->related_pids[$id] = $id;
                    }
                }

                // поправляем поле списка похожих категорий
                if (isset($item->related_cids) && is_string($item->related_cids)) {
                    $ids = explode(',', $item->related_cids);
                    $item->related_cids = array();
                    foreach ($ids as & $id) {
                        $id = intval($id);
                        if (!empty($id)) $item->related_cids[$id] = $id;
                    }
                }

                // поправляем поле списка похожих брендов
                if (isset($item->related_bids) && is_string($item->related_bids)) {
                    $ids = explode(',', $item->related_bids);
                    $item->related_bids = array();
                    foreach ($ids as & $id) {
                        $id = intval($id);
                        if (!empty($id)) $item->related_bids[$id] = $id;
                    }
                }

                // читаем связанные товары
                if ($with_related && !isset($item->related_products)) {
                    $item->related_products = array();

                    if (isset($item->related_pids) && is_array($item->related_pids) && !empty($item->related_pids)) {
                        foreach ($item->related_pids as $id) {
                            if (!empty($id)) {
                                $params = new stdClass;
                                $params->id = $id;
                                $params->discount = $discount;
                                $params->price_id = $price_id;
                                $params->enabled = 1;
                                if (!isset($this->cms->user->user_id)) $params->hidden = 0;
                                $params->section = $item->section;
                                $this->one($row, $params);
                                if (!empty($row)) $item->related_products[$row->product_id] = $row;
                            }
                        }
                    }

                    if (empty($item->related_products)) {
                        $query = 'SELECT `products_variants`.`' . $this->id_field . '`, '
                                      . '`products_variants`.`sku` '
                               . 'FROM `products_variants`, '
                                    . '`related_products` '
                               . 'WHERE `products_variants`.`sku` = `related_products`.`related_sku` '
                                     . 'AND `related_products`.`' . $this->id_field . '` = "' . $this->cms->db->query_value($item->product_id) . '";';
                        $result = $this->cms->db->query($query);
                        $items = $this->cms->db->results();

                        // освобождаем память от запроса
                        $this->cms->db->free_result($result);

                        foreach ($items as $row) {
                            $sku = $row->sku;
                            $params = new stdClass;
                            $params->id = $row->product_id;
                            $params->discount = $discount;
                            $params->price_id = $price_id;
                            $params->enabled = 1;
                            if (!isset($this->cms->user->user_id)) $params->hidden = 0;
                            $params->section = $item->section;
                            $this->one($row, $params);
                            if (!empty($row)) {
                                $row->related_sku = $sku;
                                $item->related_products[$row->product_id] = $row;
                            }
                        }
                    }
                }

                // читаем дополнительные товары (аксессуары)
                if ($with_related && !isset($item->accessory_products)) {
                    $item->accessory_products = array();

                    if (isset($item->accessory_pids) && is_array($item->accessory_pids) && !empty($item->accessory_pids)) {
                        foreach ($item->accessory_pids as $id) {
                            if (!empty($id)) {
                                $params = new stdClass;
                                $params->id = $id;
                                $params->discount = $discount;
                                $params->price_id = $price_id;
                                $params->enabled = 1;
                                if (!isset($this->cms->user->user_id)) $params->hidden = 0;
                                $params->section = $item->section;
                                $this->one($row, $params);
                                if (!empty($row)) $item->accessory_products[$row->product_id] = $row;
                            }
                        }
                    }
                }
            }
        }



        // =======================================================================
        // Превратить строки полей изображений записи о товаре в массивы:
        //   $item = запись (при отсутствии полей images, images_alts, images_texts, images_view они станут пустыми массивами)
        // =======================================================================

        public function unpack_images ( & $item ) {
            $this->cms->db->fix_articles_record_images($item);
        }



        // =======================================================================
        // Превратить строки полей файлов записи о товаре в массивы:
        //   $item = запись (при отсутствии полей files, files_alts, files_texts они станут пустыми массивами)
        // =======================================================================

        public function unpack_files ( & $item ) {
            $this->cms->db->fix_files_record_files($item);
        }



        // =======================================================================
        // Превратить массивы, находящиеся в полях изображений записи о товаре,
        // в строки, готовые для передачи в базу данных:
        //   $item = запись (при отсутствии полей images, images_alts, images_texts, images_view они появятся пустыми)
        // =======================================================================

        public function pack_images ( & $item ) {
            $this->cms->db->unfix_articles_record_images($item);
        }



        // =======================================================================
        // Превратить массивы, находящиеся в полях файлов записи о товаре,
        // в строки, готовые для передачи в базу данных:
        //   $item = запись (при отсутствии полей files, files_alts, files_texts они появятся пустыми)
        // =======================================================================

        public function pack_files ( & $item ) {
            $this->cms->db->unfix_files_record_files($item);
        }



        // ===================================================================
        /**
        *  Проверка и поправка таблицы в базе данных
        *
        *  Связанная с ней таблица products_fotos (из самых ранних версий) более
        *  не используется, и если она существует, то в записи с незаполненным
        *  новым полем images проверяемой таблицы переносятся соответствующие
        *  данные из поля filename неиспользуемой таблицы. После неиспользуемая
        *  таблица удаляется.
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function check () {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' check');

            // проверяем наличие таблицы, при отсутствии создаем
            $dbtable = $this->dbtable;
            $dbtable_field = $this->id_field;
            $columns = $this->cms->db->get_dbtable_fields($dbtable);
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $dbtable . '` (`' . $dbtable_field . '` BIGINT(20) NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');

            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$dbtable_field])) {
                $query[] = 'ADD `' . $dbtable_field . '` BIGINT(20) NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE `' . $dbtable . '` SET `' . $dbtable_field . '` = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (`' . $dbtable_field . '`)';
                $query[] = 'CHANGE `' . $dbtable_field . '` `' . $dbtable_field . '` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT "Идентификатор товара"';
            } else {

                // ИД товара
                $name = $dbtable_field;
                $type = 'BIGINT(20)';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT "Идентификатор товара"';
            }

            // синхронизационный ИД
            $name = 'sync_id';
            $type = 'VARCHAR(40)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Синхронизационный идентификатор"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД меню
            $name = 'menu_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор меню"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД категории
            $name = 'category_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор категории"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД бренда
            $name = 'brand_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор бренда"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД поставщика
            $name = 'user_id';
            $type = 'BIGINT(' . DATABASE_USERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор поставщика"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД срока отправки
            $name = 'shippings_term_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор срока отправки"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // подключаемые модули
            $name = 'objects';
            $type = 'VARCHAR(512)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень модулей, подключаемых на страницу товара"';

            // хит продаж
            $name = 'hit';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Признак Хит продаж"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // новинка
            $name = 'newest';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Признак Новинка"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // акционный
            $name = 'actional';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Признак Акционный"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // скоро в продаже
            $name = 'awaited';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Признак Скоро в продаже"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // Яндекс.Маркет
            $name = 'ymarket';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 1 NOT NULL COMMENT "Признак Экспорт в Яндекс.Маркет"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ВКонтакте
            $name = 'vkontakte';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 1 NOT NULL COMMENT "Признак Экспорт в ВКонтакте"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // разрешен
            $name = 'enabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 1 NOT NULL COMMENT "Разрешена ли запись к использованию"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // выделен
            $name = 'highlighted';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Выделена ли запись визуально"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // комментируют
            $name = 'commented';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 1 NOT NULL COMMENT "Разрешено ли оставлять отзывы о товаре"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // скрыт от чужих
            $name = 'hidden';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Скрыта ли запись от незарегистрированных пользователей"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // не для rss
            $name = 'rss_disabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Запрещен ли экспорт записи в RSS"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // не для информеров
            $name = 'export_disabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Запрещен ли экспорт записи в информеры для внешних сайтов"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // не для кредитов
            $name = 'non_creditable';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Запрещена ли продажа в кредит"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // не для продажи
            $name = 'non_usable';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Признак товара не для продажи"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // в каких прайсах
            $name = 'in_prices';
            $type = 'TINYINT(1) UNSIGNED';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 255 NOT NULL COMMENT "Битовые признаки В каких из 8 прайсов выводится запись"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // url
            $name = 'url';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Окончание адреса страницы записи"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE TRIM(' . $name . ') = "" OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // особый url
            $name = 'url_special';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Имеет ли запись особый адрес страницы"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД канонического товара
            $name = 'canonical_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор канонического товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // мета заголовок
            $name = 'meta_title';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Мета заголовок страницы"';

            // мета ключевые слова
            $name = 'meta_keywords';
            $type = 'VARCHAR(512)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Мета ключевые слова страницы"';

            // мета описание
            $name = 'meta_description';
            $type = 'VARCHAR(512)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Мета описание страницы"';

            // название
            $name = 'model';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Название товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // аннотация
            $name = 'description';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Аннотация"';

            // описание
            $name = 'body';
            $type = 'LONGTEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Полное описание"';

            // seo текст
            $name = 'seo_description';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "SEO текст"';

            // скачивание
            $name = 'download';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Скачиваемый файл"';

            // цена
            $name = 'price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Цена"';

            // акционная цена
            $name = 'temp_price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Акционная цена"';

            // старая цена
            $name = 'old_price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Старая цена"';

            // приоритетная скидка
            $name = 'priority_discount';
            $type = 'FLOAT(5,2)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT -1.00 NOT NULL COMMENT "Приоритетная скидка"';

            // гарантия
            $name = 'guarantee';
            $type = 'VARCHAR(64)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Срок гарантии"';

            // на складе
            $name = 'quantity';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Количество на складе"';

            // буквенный код
            $name = 'pcode';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Буквенный код товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // штрих код
            $name = 'barcode';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Штрих код товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // видео
            $name = 'video';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Видео материалы о товаре"';

            // ИДы связанных статей
            $name = 'article_ids';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Идентификаторы связанных статей"';

            // ИДы связанных новостей
            $name = 'news_ids';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Идентификаторы связанных новостей"';

            // ИДы дополнительных товаров (аксессуаров)
            $name = 'accessory_pids';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Идентификаторы дополнительных товаров (аксессуаров)"';

            // ИДы похожих товаров
            $name = 'related_pids';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Идентификаторы похожих товаров"';

            // ИДы похожихй категорий
            $name = 'related_cids';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Идентификаторы похожих категорий"';

            // ИДы похожих брендов
            $name = 'related_bids';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Идентификаторы похожих брендов"';

            // субдомен
            $name = 'subdomain';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Левая часть собственного субдомена товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // разрешение субдомена
            $name = 'subdomain_enabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 1 NOT NULL COMMENT "Разрешен ли собственный субдомен"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // контент субдомен
            $name = 'subdomain_html';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Приоритетный контент собственного субдомена"';

            // имя шаблона
            $name = 'template';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Шаблон, используемый для отображения страницы"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // миниатюра основного фото
            $name = 'small_image';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Миниатюра основного фото"';

            // основное фото
            $name = 'large_image';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Основное фото"';

            // все фото
            $name = 'images';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень всех фото товара"';

            // надписи фото
            $name = 'images_alts';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень надписей всех фото товара"';

            // описания фото
            $name = 'images_texts';
            $type = 'LONGTEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень описаний всех фото товара"';

            // слайдинг-признаки
            $name = 'images_view';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень слайдинг-признаков всех фото товара"';

            // все файлы
            $name = 'files';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень всех файлов товара"';

            // надписи файлов
            $name = 'files_alts';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень надписей всех файлов товара"';

            // описания файлов
            $name = 'files_texts';
            $type = 'LONGTEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Перечень описаний всех файлов товара"';

            // дата поступления в продажу
            $name = 'coming';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата ожидаемого поступления товара"';

            // теги
            $name = 'tags';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "" NOT NULL COMMENT "Теги записи"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // создан
            $name = 'created';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата создания записи"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // исправлен
            $name = 'modified';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата изменения записи"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // счетчик просмотров
            $name = 'browsed';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Количество просмотров страницы"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // рейтинг
            $name = 'rating';
            $type = 'FLOAT(12,2)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Рейтинг"';

            // число голосов
            $name = 'votes';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Количество голосов в рейтинге"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес в ветке
            $name = 'order_num';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Вес записи среди прочих в ветке"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес в хитах продаж
            $name = 'order_num_hit';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Вес записи среди прочих в блоке Хиты продаж"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес в новинках
            $name = 'order_num_newest';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Вес записи среди прочих в блоке Новинки"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес в акционных
            $name = 'order_num_actional';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Вес записи среди прочих в блоке Специальное предложение"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес в ожидаемых
            $name = 'order_num_awaited';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Вес записи среди прочих в блоке Скоро в продаже"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // раздел магазина
            $name = 'section';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 1 NOT NULL COMMENT "Идентификатор раздела магазина"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // выполняем сформированные запросы
            foreach ($query as & $command) {
                if (trim($command) != '') {
                    if (substr($command, 0, 1) == '>') {
                        $command = trim(substr($command, 1));
                        if ($command != '') $command .= ';';
                    } else {
                        $command = 'ALTER TABLE `' . $dbtable . '` ' . $command . ';';
                    }
                    if ($command != '') $this->cms->db->query($command);
                }
            }
            foreach ($subquery as & $command) {
                if (trim($command) != '') $this->cms->db->query($command);
            }

            // если существует неиспользуемая более таблица, делаем перенос ее значений
            $columns = $this->cms->db->get_dbtable_fields($dbtable . '_fotos');
            if (isset($columns[$dbtable_field]) && isset($columns['filename'])) {

                // расширяем объем доступной памяти до 128 Кбайт для GROUP_CONCAT (по умолчанию было бы 1024 байта)
                $query = 'SET group_concat_max_len = 131072;';
                $this->cms->db->query($query);

                // в строку собираем из неиспользуемой таблицы значения ее поля filename
                $query = 'SELECT ' . $dbtable_field . ', '
                              . 'GROUP_CONCAT(DISTINCT filename '
                                           . 'ORDER BY filename ASC '
                                           . 'SEPARATOR "' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '") AS images '
                        . 'FROM ' . $dbtable . '_fotos '
                        . 'GROUP BY ' . $dbtable_field . ';';
                $result = $this->cms->db->query($query);
                $items = $this->cms->db->results();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // передаем строки в новое предназначенное для этого поле images, если оно незаполнено
                if (!empty($items)) {
                    foreach ($items as & $item) {
                        $query = 'UPDATE ' . $dbtable . ' '
                               . 'SET images = "' . $this->cms->db->query_value($item->images) . '", '
                                   . 'images_alts = "", '
                                   . 'images_texts = "", '
                                   . 'images_view = "" '
                               . 'WHERE ' . $dbtable_field . ' = "' . $this->cms->db->query_value($item->$dbtable_field) . '" '
                                     . 'AND TRIM(images) = "";';
                        $this->cms->db->query($query);
                    }
                }

                // удаляем неиспользуемую таблицу
                $query = 'DROP TABLE ' . $dbtable . '_fotos;';
                $this->cms->db->query($query);
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // =======================================================================
        // Проверить и поправить (если нет, создать) таблицу дополнительных категорий товара в базе данных.
        // =======================================================================

        public function check_categories () {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' check_categories');

            // проверяем наличие таблицы, при отсутствии создаем
            $dbtable = DATABASE_PRODUCTS_CATEGORIES_TABLENAME;
            $dbtable_field = $this->id_field;
            $columns = $this->cms->db->get_dbtable_fields($dbtable);
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $dbtable . '` (`' . $dbtable_field . '` BIGINT(20) DEFAULT 0 NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8;');

            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$dbtable_field])) {
                $query[] = 'ADD ' . $dbtable_field . ' BIGINT(20) NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = 'CHANGE ' . $dbtable_field . ' ' . $dbtable_field . ' BIGINT(20) DEFAULT 0 NOT NULL COMMENT "Идентификатор товара"';
                $query[] = 'ADD INDEX (' . $dbtable_field . ')';
            } else {

                // товар
                $name = $dbtable_field;
                $type = 'BIGINT(20)';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор товара"';
                if (!$this->cms->db->check_key($columns, $name, TRUE)) $this->cms->db->add_key($query, $name, TRUE);
            }

            // категория
            $name = 'category_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор категории"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // выполняем сформированные запросы
            foreach ($query as & $command) {
                if (trim($command) != '') {
                    if (substr($command, 0, 1) == '>') {
                        $command = trim(substr($command, 1));
                        if ($command != '') $command .= ';';
                    } else {
                        $command = 'ALTER TABLE ' . $dbtable . ' ' . $command . ';';
                    }
                    if ($command != '') $this->cms->db->query($command);
                }
            }
            foreach ($subquery as & $command) {
                if (trim($command) != '') $this->cms->db->query($command);
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Получение MySQL-выражения для извлечения исходной цены варианта товара
        *
        *  @access  public
        *  @param   integer $price_id   идентификатор ценовой группы
        *  @return  string              MySQL-выражение
        */
        // ===================================================================

        public function variantRealPriceField ( $price_id ) {
            $number = $price_id > 0 ? $price_id + 1 : 0;
            if ($number > PRICE_TYPES_MAXCOUNT) $number = PRICE_TYPES_MAXCOUNT;

            // цена из колонки указанной группы (или из первой, если в нужной колонке цена нулевая)
            return $number == 0 ? '`products_variants`.`price`'
                                : 'CASE WHEN `products_variants`.`price' . $number . '` != 0 '
                                     . 'THEN `products_variants`.`price' . $number . '` '
                                     . 'ELSE `products_variants`.`price` '
                                     . 'END';
        }



        // ===================================================================
        /**
        *  Получение MySQL-выражения для извлечения цены варианта товара
        *  с учетом скидки
        *
        *  @access  public
        *  @param   integer $price_id           идентификатор ценовой группы
        *  @param   float   $discount           процент скидки покупателя
        *  @param   string  $discount_field     первостепенное поле скидки
        *  @return  string                      MySQL-выражение
        */
        // ===================================================================

        public function variantDiscountPriceField ( $price_id, $discount, $discount_field = '' ) {
            $result = $this->variantRealPriceField($price_id);

            // предполагаем, что к цене применится или приоритетная скидка или скидка покупателя
            $discount = 'CASE WHEN (`products_variants`.`priority_discount` >= 0 AND `products_variants`.`priority_discount` <= 100) '
                           . 'THEN `products_variants`.`priority_discount` '
                           . 'ELSE ' . $this->cms->db->query_value($discount) . ' '
                           . 'END';
                // однако если указано первостепенное поле скидки, оно еще главнее
                $overlap_actions = FALSE;
                if (is_string($discount_field)) {
                    $discount_field = trim($discount_field);
                    if (preg_match('/^(`?[a-z0-9_]+`?\.)*`?[a-z0-9_]+`?$/i', $discount_field)) {
                        $overlap_actions = TRUE;
                        $discount = 'CASE WHEN (' . $discount_field . ' >= 0 AND ' . $discount_field . ' <= 100) '
                                       . 'THEN ' . $discount_field . ' '
                                       . 'ELSE ' . $discount . ' '
                                       . 'END';
                    }
                }
            // теперь применяем скидку
            $result = 'ABS(' . $result . ') * ABS(100 - ' . $discount . ') / 100';

            // для всех ценовых групп (кроме первой) не действуют акционные цены
            if ($price_id > 0) return $result;

            // иначе акционные цены действуют (кроме случаев валидного первостепенного поля скидки)
            return 'CASE WHEN (`products_variants`.`temp_price` != 0 '
                            . ($overlap_actions ? 'AND (' . $discount_field . ' < 0 OR ' . $discount_field . ' > 100) ' : '')
                            . 'AND (`products_variants`.`temp_price_start` = "0000-00-00 00:00:00" OR `products_variants`.`temp_price_start` <= NOW()) '
                            . 'AND (`products_variants`.`temp_price_date` = "0000-00-00 00:00:00" OR `products_variants`.`temp_price_date` >= NOW()) '
                            . 'AND `products_variants`.`temp_price_members` <= `products_variants`.`temp_price_invited`) '
                      . 'THEN ABS(`products_variants`.`temp_price`) '
                      . 'ELSE ' . $result . ' '
                      . 'END';
        }



        // =======================================================================
        // Выбрать из базы данных записи о названиях вариантов товаров согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->category] = запись о категории
        //   [$params->brand] = запись о бренде
        //   [$params->section] = раздел магазина
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        // =======================================================================

        public function variants_names ( & $items, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' variants_names');

            $items = array();
            $where = '';

            // инициализируем указатели что подключать в запрос
            $join_brands = FALSE;
            $join_products_categories = FALSE;

            // фильтруем по категории
            if (isset($params->category) && !empty($params->category)) {
                if (isset($params->category->subcats_ids) && !empty($params->category->subcats_ids)) {
                    $join_products_categories = TRUE;
                    $where .= 'AND (`' . $this->dbtable . '`.`category_id` IN (' . $this->cms->db->query_value(join($params->category->subcats_ids, ',')) . ') '
                                . 'OR `' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '`.`category_id` IN (' . $this->cms->db->query_value(join($params->category->subcats_ids, ',')) . ')) ';
                } else {
                    if (isset($params->category->products) && is_array($params->category->products) && !empty($params->category->products)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (' . $this->cms->db->query_value(join(array_keys($params->category->products), ',')) . ') ';
                }
            }

            // фильтруем по бренду
            if (isset($params->brand) && !empty($params->brand)) {
                if (isset($params->brand->subcats_ids) && !empty($params->brand->subcats_ids)) {
                    $join_brands = TRUE;
                    $where .= 'AND `' . $this->dbtable . '`.`brand_id` IN (' . $this->cms->db->query_value(join($params->brand->subcats_ids, ',')) . ') '
                            . 'AND `' . DATABASE_BRANDS_TABLENAME . '`.`brand_id` IN (' . $this->cms->db->query_value(join($params->brand->subcats_ids, ',')) . ') ';
                } else {
                    $where .= 'AND `' . $this->dbtable . '`.`brand_id` = "' . $this->cms->db->query_value($params->brand->brand_id) . '" ';
                }
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->section)) $where .= 'AND `' . $this->dbtable . '`.`section` = "' . $this->cms->db->query_value($params->section) . '" ';
            if (isset($params->enabled)) $where .= 'AND `' . $this->dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
            if (isset($params->hidden)) $where .= 'AND `' . $this->dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';



            // создаем кеш-таблицу названий вариантов товаров
            // (IF NOT EXISTS специально не используем, чтобы не срабатывал SELECT, когда таблица существует)
            $query = 'CREATE TABLE `cache_pvnames` (INDEX (`' . $this->id_field . '`)) ENGINE = MEMORY '
                                 . 'SELECT `' . $this->id_field . '`, '
                                        . '`name` '
                                 . 'FROM `products_variants`;';
            $this->cms->db->query($query);



            // делаем запрос
            $query = 'SELECT `cache_pvnames`.`name` '
                   . 'FROM `' . $this->dbtable . '` '
                   . 'LEFT JOIN `' . DATABASE_CATEGORIES_TABLENAME . '` '
                             . 'ON `' . DATABASE_CATEGORIES_TABLENAME . '`.`category_id` = `' . $this->dbtable . '`.`category_id` '
                                . 'AND `' . DATABASE_CATEGORIES_TABLENAME . '`.`section` = `' . $this->dbtable . '`.`section` '
                   . ($join_brands ? 'LEFT JOIN `' . DATABASE_BRANDS_TABLENAME . '` '
                                             . 'ON `' . DATABASE_BRANDS_TABLENAME . '`.`brand_id` = `' . $this->dbtable . '`.`brand_id` '
                                                . 'AND `' . DATABASE_BRANDS_TABLENAME . '`.`section` = `' . $this->dbtable . '`.`section` ' : '')
                   . ($join_products_categories ? 'LEFT JOIN `' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '` '
                                                          . 'ON `' . DATABASE_PRODUCTS_CATEGORIES_TABLENAME . '`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` ' : '')
                   . 'LEFT JOIN `cache_pvnames` '
                             . 'ON `cache_pvnames`.`' . $this->id_field . '` = `' . $this->dbtable . '`.`' . $this->id_field . '` '
                   . 'WHERE `' . DATABASE_CATEGORIES_TABLENAME . '`.`enabled` = 1 '
                         . 'AND `cache_pvnames`.`name` IS NOT NULL '
                         . 'AND TRIM(`cache_pvnames`.`name`) != "" '
                          . $where
                   . 'GROUP BY `cache_pvnames`.`name` '
                   . 'ORDER BY `cache_pvnames`.`name` ASC';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();



            // освобождаем память от запроса
            $this->cms->db->free_result($result);



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем полное количество подобных записей
            return count($items);
        }



        // =======================================================================
        // Заполнить записи о товарах вариантами товаров:
        //   $items = записи о товарах
        //   [$price_id] = идентификатор ценовой группы
        //   [$discount] = величина скидки клиента
        // =======================================================================

        public function fill_variants ( & $items, $price_id = 0, $discount = 0 ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' fill_variants');



            // если есть записи о товарах
            if (!empty($items)) {
                $discount = $this->cms->db->fix_discount($discount);



                // создаем фильтр по идентификаторам товаров и очищаем записи от вариантов
                $temp = array();
                $ids = array();
                foreach ($items as & $item) {
                    $id = intval($item->product_id);
                    $ids[$id] = $id;
                    $item->variants = array();
                    $temp[$id] = & $item;
                }
                $ids = implode(',', $ids);



                // читаем варианты товаров
                $query = 'SELECT *, '
                              . $this->variantDiscountPriceField($price_id, $discount) . ' AS `discount_price`, '
                              . '`name` AS `variant_name` '
                       . 'FROM `products_variants` '
                       . 'WHERE `' . $this->id_field . '` IN (' . $ids . ') '
                       . 'ORDER BY `' . $this->id_field . '` ASC, '
                                . '`position` DESC;';
                $result = $this->cms->db->query($query);



                // заполняем варианты товаров (в конец каждого списка вариантов ставим отсутствующие на складе)
                if (!empty($result)) {
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $id = intval($row->product_id);
                        if ($row->stock > 0) {
                            array_unshift($temp[$id]->variants, $row);
                        } else {
                            $temp[$id]->variants[] = $row;
                        }
                    }
                }



                // освобождаем память от запроса
                $this->cms->db->free_result($result);



                // в записи с отсутствующими вариантами товаров добавляем обнуленный (наличие virtual сигнализирует об отсутствии записи в базе данных)
                foreach ($items as & $item) {
                    if (empty($item->variants)) {
                        $id = intval($item->product_id);
                        $row = new stdClass;
                        $row->virtual = 1;
                        $row->variant_id = $id;
                        $row->product_id = $id;
                        $row->sku = $id;
                        $row->name = '';
                        for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                            $field = 'price' . (($i > 1) ? $i : '');
                            $row->$field = 0;
                        }
                        $row->old_price = 0;
                        $row->temp_price = 0;
                        $row->temp_price_start = '0000-00-00 00:00:00';
                        $row->temp_price_date = '0000-00-00 00:00:00';
                        $row->temp_price_members = 0;
                        $row->temp_price_invited = 0;
                        $row->priority_discount = -1;
                        $row->stock = 0;
                        $row->position = 1;
                        $item->variants = array($row);
                    }
                }
            }



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // =======================================================================
        // Заполнить запись о товаре вариантами товара:
        //   $item = запись
        //   [$price_id] = идентификатор ценовой группы
        //   [$discount] = величина скидки клиента
        // =======================================================================

        public function variants ( & $item, $price_id = 0, $discount = 0 ) {

            // если запись непустая
            if (!empty($item) && isset($item->product_id)) {
                $discount = $this->cms->db->fix_discount($discount);

                // читаем варианты товара
                $query = 'SELECT *, '
                              . $this->variantDiscountPriceField($price_id, $discount) . ' AS `discount_price`, '
                              . '`name` AS `variant_name` '
                       . 'FROM `products_variants` '
                       . 'WHERE `' . $this->id_field . '` = "' . $this->cms->db->query_value($item->product_id) . '" '
                       . 'ORDER BY `position` ASC;';
                $result = $this->cms->db->query($query);
                $items = $this->cms->db->results();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // заполняем варианты товара
                $item->variants = array();
                if (!empty($items)) {
                    // сначала ставим в список присутствующие на складе
                    foreach ($items as & $row) {
                        if ($row->stock > 0) $item->variants[] = $row;
                    }
                    // в конец списка ставим отсутствующие на складе
                    foreach ($items as & $row) {
                        if ($row->stock <= 0) $item->variants[] = $row;
                    }
                }

                // если вариантов нет, добавляем обнуленный (наличие virtual сигнализирует об отсутствии записи в базе данных)
                if (empty($item->variants)) {
                    $row = new stdClass;
                    $row->virtual = 1;
                    $row->variant_id = $item->product_id;
                    $row->product_id = $item->product_id;
                    $row->sku = $item->product_id;
                    $row->name = '';
                    for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                        $field = 'price' . (($i > 1) ? $i : '');
                        $row->$field = 0;
                    }
                    $row->old_price = 0;
                    $row->temp_price = 0;
                    $row->temp_price_start = '0000-00-00 00:00:00';
                    $row->temp_price_date = '0000-00-00 00:00:00';
                    $row->temp_price_members = 0;
                    $row->temp_price_invited = 0;
                    $row->priority_discount = -1;
                    $row->stock = 0;
                    $row->position = 1;
                    $item->variants[] = $row;
                }
            }
        }



        // =======================================================================
        // Обновить/добавить запись о варианте товара в базе данных:
        //   $item = запись (обычно содержащая только изменившиеся поля),
        //           лишние (не относящиеся к таблице) поля в записи игнорируются,
        //           запись добавляется, если не имеет поля идентификатора записи
        // =======================================================================

        public function update_variant ( & $item ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' update_variant');

            $id = '';
            if (!empty($item)) {

                // готовим изменившиеся поля
                $fields = array(); $values = array();
                $id_field = $this->id_field;
                if (isset($item->variant_id))         {$fields[] = 'variant_id';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->variant_id)) . '"';}
                if (isset($item->$id_field))          {$fields[] = $id_field;            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->$id_field)) . '"';}
                if (isset($item->sync_id))            {$fields[] = 'sync_id';            $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->sync_id)) . '"';}
                if (isset($item->sku))                {$fields[] = 'sku';                $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->sku)) . '"';}
                if (isset($item->name))               {$fields[] = 'name';               $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_string($item->name)) . '"';}
                for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                    $field = 'price' . (($i > 1) ? $i : '');
                    if (isset($item->$field))         {$fields[] = $field;               $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->$field)) . '"';}
                }
                if (isset($item->temp_price))         {$fields[] = 'temp_price';         $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->temp_price)) . '"';}
                if (isset($item->temp_price_start))   {$fields[] = 'temp_price_start';   $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_date($item->temp_price_start)) . '"';}
                if (isset($item->temp_price_date))    {$fields[] = 'temp_price_date';    $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_date($item->temp_price_date)) . '"';}
                if (isset($item->temp_price_members)) {$fields[] = 'temp_price_members'; $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->temp_price_members)) . '"';}
                if (isset($item->temp_price_invited)) {$fields[] = 'temp_price_invited'; $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->temp_price_invited)) . '"';}
                if (isset($item->old_price))          {$fields[] = 'old_price';          $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->old_price)) . '"';}
                if (isset($item->currency_id))        {$fields[] = 'currency_id';        $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->currency_id)) . '"';}
                if (isset($item->priority_discount))  {$fields[] = 'priority_discount';  $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_float($item->priority_discount)) . '"';}
                if (isset($item->stock))              {$fields[] = 'stock';              $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->stock)) . '"';}
                if (isset($item->position))           {$fields[] = 'position';           $values[] = '"' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->position)) . '"';}

                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, 'products_variants', 'variant_id', $fields, $values);

                // если выполнено
                if (!empty($id)) {

                    // если запись обновлялась
                    if (isset($item->variant_id)) {
                        if (isset($item->product_id)) {
                            $product_id = $this->cms->db->value_as_integer($item->product_id);
                            $product = FALSE;

                            // если данные о товаре еще не читали или прочитали выше без ошибок
                            if (($product === FALSE) || !empty($product)) {

                                // если товар появился на складе
                                if (isset($item->stock) && isset($item->previous_stock)) {
                                    if (($this->cms->db->value_as_integer($item->previous_stock) <= 0) && ($this->cms->db->value_as_integer($item->stock) > 0)) {

                                        // если у родительского объекта задан метод уведомления о появлении товара
                                        if (isset($this->cms) && method_exists($this->cms, 'inform_about_product_exist')) {

                                            // читаем список разрешенных, невыполненных и верифицированных подписок на уведомление
                                            $params = new stdClass;
                                            $params->sort = SORT_NOTIFIES_MODE_BY_EMAIL;
                                            $params->sort_laconical = 1;
                                            $params->type = NOTIFY_TYPE_REQUEST_PARAM_VALUE_EXIST;
                                            $params->object_id = $product_id;
                                            $params->variant_id = $id;
                                            $params->enabled = 1;
                                            $params->done = 0;
                                            $params->remote_token = '';
                                            $this->cms->db->get_notifies($notifies, $params);
                                            if (!empty($notifies)) {

                                                // читаем данные о товаре, если не были прочитаны ранее
                                                if (empty($product)) {
                                                    $params = new stdClass;
                                                    $params->id = $product_id;
                                                    $params->enabled = 1;
                                                    $this->one($product, $params);
                                                }
                                                if (!empty($product)) {

                                                    // уведомляем подписавшихся пользователей
                                                    foreach ($notifies as & $notify) {
                                                        if ($this->cms->inform_about_product_exist($notify,
                                                                                                   $product,
                                                                                                   'Вы просили уведомить: появился нужный Вам товар на сайте ' . $this->cms->root_url)) {
                                                            // ставим в подписку метку "выполнено"
                                                            $temp = new stdClass;
                                                            $temp->notify_id = $notify->notify_id;
                                                            $temp->done = 1;
                                                            $this->cms->db->update_notify($temp);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            // если данные о товаре еще не читали или прочитали выше без ошибок
                            if (($product === FALSE) || !empty($product)) {

                                // если цена товара изменилась
                                if ((isset($item->price) && isset($item->previous_price) && ($this->cms->db->value_as_float($item->price) != $this->cms->db->value_as_float($item->previous_price)))
                                || (isset($item->temp_price) && isset($item->previous_temp_price) && ($this->cms->db->value_as_float($item->temp_price) != $this->cms->db->value_as_float($item->previous_temp_price)))) {

                                    // если у родительского объекта задан метод уведомления о смене цены товара
                                    if (isset($this->cms) && method_exists($this->cms, 'inform_about_product_reprice')) {

                                        // читаем список разрешенных, невыполненных и верифицированных подписок на уведомление
                                        $params = new stdClass;
                                        $params->sort = SORT_NOTIFIES_MODE_BY_EMAIL;
                                        $params->sort_laconical = 1;
                                        $params->type = NOTIFY_TYPE_REQUEST_PARAM_VALUE_PRODUCT;
                                        $params->object_id = $product_id;
                                        $params->variant_id = $id;
                                        $params->enabled = 1;
                                        $params->done = 0;
                                        $params->remote_token = '';
                                        $this->cms->db->get_notifies($notifies, $params);
                                        if (!empty($notifies)) {

                                            // читаем данные о товаре, если не были прочитаны ранее
                                            if (empty($product)) {
                                                $params = new stdClass;
                                                $params->id = $product_id;
                                                $params->enabled = 1;
                                                $this->one($product, $params);
                                            }
                                            if (!empty($product)) {

                                                // уведомляем подписавшихся пользователей
                                                foreach ($notifies as & $notify) {
                                                    if ($this->cms->inform_about_product_reprice($notify,
                                                                                                 $product,
                                                                                                 'Вы просили уведомить: изменилась цена нужного Вам товара на сайте ' . $this->cms->root_url)) {
                                                        // ставим в подписку метку "выполнено"
                                                        $temp = new stdClass;
                                                        $temp->notify_id = $notify->notify_id;
                                                        $temp->done = 1;
                                                        $this->cms->db->update_notify($temp);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем идентификатор обновленной / добавленной записи
            return $id;
        }



        // =======================================================================
        // Проверить и поправить (если нет, создать) таблицу вариантов товара в базе данных.
        // =======================================================================

        public function check_variants () {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' check_variants');

            // проверяем наличие таблицы, при отсутствии создаем
            $dbtable = 'products_variants';
            $dbtable_field = 'variant_id';
            $columns = $this->cms->db->get_dbtable_fields($dbtable);
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $dbtable . '` (`' . $dbtable_field . '` BIGINT(20) NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');

            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$dbtable_field])) {
                $query[] = 'ADD `' . $dbtable_field . '` BIGINT(20) NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE `' . $dbtable . '` SET `' . $dbtable_field . '` = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (`' . $dbtable_field . '`)';
                $query[] = 'CHANGE `' . $dbtable_field . '` `' . $dbtable_field . '` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT "Идентификатор варианта товара"';
            }

            // синхронизационный ИД
            $name = 'sync_id';
            $type = 'VARCHAR(40)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT "" NOT NULL COMMENT "Синхронизационный идентификатор"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // товар
            $name = $this->id_field;
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Идентификатор товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // артикул
            $name = 'sku';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT "" NOT NULL COMMENT "Артикул варианта товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // название
            $name = 'name';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT "" NOT NULL COMMENT "Название варианта товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // цена
            for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                $name = 'price' . (($i > 1) ? $i : '');
                $type = 'FLOAT(17,6)';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Цена ' . $i . ' варианта товара"';
                if ($i == 1) {
                    if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);
                }
            }

            // акционная цена
            $name = 'temp_price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Акционная цена варианта"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // дата начала действия акционной цены
            $name = 'temp_price_start';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата начала действия акционной цены"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // дата действия акционной цены
            $name = 'temp_price_date';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата действия акционной цены"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // требуемое число участников акционной цены
            $name = 'temp_price_members';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Требуемое число участников акционной цены"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // число привлеченных участников акционной цены
            $name = 'temp_price_invited';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Число привлеченных участников акционной цены"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // старая цена
            $name = 'old_price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0.00 NOT NULL COMMENT "Старая цена варианта"';

            // валюта
            $name = 'currency_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Валюта товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // приоритетная скидка
            $name = 'priority_discount';
            $type = 'FLOAT(5,2)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT -1.00 NOT NULL COMMENT "Приоритетная скидка на вариант товара"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // на складе
            $name = 'stock';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Количество на складе"';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес
            $name = 'position';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT 0 NOT NULL COMMENT "Вес варианта среди других"';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = ' . $dbtable_field . ' '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // выполняем сформированные запросы
            foreach ($query as & $command) {
                if (trim($command) != '') {
                    if (substr($command, 0, 1) == '>') {
                        $command = trim(substr($command, 1));
                        if ($command != '') $command .= ';';
                    } else {
                        $command = 'ALTER TABLE `' . $dbtable . '` ' . $command . ';';
                    }
                    if ($command != '') $this->cms->db->query($command);
                }
            }
            foreach ($subquery as & $command) {
                if (trim($command) != '') $this->cms->db->query($command);
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // =======================================================================
        // Проверить и поправить (если нет, создать) таблицу связанных товаров в базе данных.
        // =======================================================================

        public function check_related () {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' check_related');

            // проверяем наличие таблицы, при отсутствии создаем
            $dbtable = DATABASE_PRODUCTS_RELATED_TABLENAME;
            $dbtable_field = $this->id_field;
            $columns = $this->cms->db->get_dbtable_fields($dbtable);
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $dbtable . '` (`' . $dbtable_field . '` BIGINT(20) DEFAULT 0 NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8;');

            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$dbtable_field])) {
                $query[] = 'DROP PRIMARY KEY';
                $query[] = 'ADD PRIMARY KEY (`' . $dbtable_field . '`)';
            }
            if (!isset($columns['related_sku'])) {
                $query[] = 'ADD `related_sku` VARCHAR(256) DEFAULT "" NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = 'ADD PRIMARY KEY (`' . $dbtable_field . '`, `related_sku`)';
            }

            // выполняем сформированные запросы
            foreach ($query as & $command) {
                if (trim($command) != '') {
                    $command = 'ALTER TABLE `' . $dbtable . '` ' . $command . ';';
                    $this->cms->db->query($command);
                }
            }
            foreach ($subquery as & $command) {
                if (trim($command) != '') $this->cms->db->query($command);
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }
    }



    return;
?>