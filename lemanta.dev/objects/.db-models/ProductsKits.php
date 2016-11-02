<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Комплекты товаров: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ProductsKitsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = array('products_kits',
                                'products_kits_items');
        public $id_field = array('kit_id',
                                 'kititem_id');

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'name',             // название
                'enabled',          // разрешена
                'hidden',           // скрыта
                'highlighted',      // выделена
                'commented',        // обсуждаема
                'ymarket',          // Яндекс.Маркет
                'vkontakte',        // ВКонтакте
                'rss_disabled',     // не для rss
                'export_disabled',  // не для информеров
                'non_creditable',   // не в кредит
                'non_usable',       // не для продажи
                'in_prices',        // в каких прайсах
                'url',              // адрес
                'url_special',      // особый адрес
                'meta_title',       // мета заголовок
                'meta_keywords',    // мета ключевые слова
                'meta_description', // мета описание
                'description',      // аннотация
                'body',             // описание
                'seo_description',  // seo текст
                'tags',             // теги
                'template',         // шаблон
                'browsed',          // просмотры
                'order_num',        // вес
                'created',          // создано
                'modified'          // изменено
            ),
            array(
                'kit_id',           // ИД комплекта
                'product_id',       // ИД товара
                'variant_id',       // ИД варианта товара
                'quantity',         // количество
                'discount',         // скидка
                'position'          // позиция
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'ProductsKits';
        protected $operables_card = 'ProductsKit';
        protected $operables = array('move_up', 'move_down', 'move_first', 'move_last',
                                     'delete', 'edit',
                                     'enable', 'highlight', 'hidden', 'commented',
                                     'ymarket', 'vkontakte');



        // =======================================================================
        // Выбрать из базы данных записи о комплектах товаров:
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->ids] = идентификаторы комплектов (перечисленные через запятую)
        //   [$params->product_id] = идентификатор товара
        //   [$params->variant_id] = идентификатор варианта товара
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->commented] = признак "разрешено обсуждение"
        //   [$params->ymarket] = признак "экспорт Яндекс.Маркет"
        //   [$params->vkontakte] = признак "экспорт ВКонтакте"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        //   [$params->non_creditable] = признак "не для кредита"
        //   [$params->in_price1] = признак "в прайсе 1"
        //   [$params->in_price2] = признак "в прайсе 2"
        //   [$params->in_price3] = признак "в прайсе 3"
        //   [$params->in_price4] = признак "в прайсе 4"
        //   [$params->in_price5] = признак "в прайсе 5"
        //   [$params->in_price6] = признак "в прайсе 6"
        //   [$params->in_price7] = признак "в прайсе 7"
        //   [$params->in_price8] = признак "в прайсе 8"
        //   [$params->browsed] = просмотренные
        //   [$params->SEOed] = с SEO текстом
        //   [$params->url_special] = с особым url
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' get');
            $dbtable2 = $this->getDBTable(TRUE);

            $items = array();
            $where = '';
            $having = '';
            $order = '';
            $limit = '';

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {

                    // по названию комплекта
                    case SORT_PRODUCTSKITS_MODE_BY_NAME:
                        $order = '`' . $dbtable . '`.`name` ' . $direction . ', '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`name`) != "" ';
                        break;

                    // по количеству товаров
                    case SORT_PRODUCTSKITS_MODE_BY_QUANTITY:
                        $order = '`total_quantity` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $having .= 'AND SUM(ABS(`' . $dbtable2 . '`.`quantity`)) > 1 ';
                        break;

                    // по числу товарных позиций
                    case SORT_PRODUCTSKITS_MODE_BY_ROWCOUNT:
                        $order = '`total_rows` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $having .= 'AND COUNT(`' . $dbtable2 . '`.`' . $idfield . '`) > 1 ';
                        break;

                    // по дате создания
                    case SORT_PRODUCTSKITS_MODE_BY_CREATED:
                        $order = '`' . $dbtable . '`.`created` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`created` IS NOT NULL ';
                        break;

                    // по дате изменения
                    case SORT_PRODUCTSKITS_MODE_BY_MODIFIED:
                        $order = '`' . $dbtable . '`.`modified` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`modified` IS NOT NULL '
                                                . 'AND `' . $dbtable . '`.`modified` != `' . $dbtable . '`.`created` ';
                        break;

                    // по числу просмотров
                    case SORT_PRODUCTSKITS_MODE_BY_BROWSED:
                        $order = '`browsed` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND ABS(`' . $dbtable . '`.`browsed`) > 0 ';
                        break;

                    // по адресу страницы
                    case SORT_PRODUCTSKITS_MODE_BY_URL:
                        $order = '`' . $dbtable . '`.`url` ' . $direction;
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`url`) != "" ';
                        break;

                    // как расставлены
                    case SORT_PRODUCTSKITS_MODE_AS_IS:
                    default:
                        $order = '`' . $dbtable . '`.`order_num` DESC, '
                               . '`' . $dbtable . '`.`name` ASC ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN ("' . str_replace(',', '","', $this->cms->db->query_value($params->ids)) . '") ';
            if (isset($params->product_id)) $where .= 'AND `' . $dbtable2 . '`.`product_id` = "' . $this->cms->db->query_value($params->product_id) . '" ';
            if (isset($params->variant_id)) $where .= 'AND `' . $dbtable2 . '`.`variant_id` = "' . $this->cms->db->query_value($params->variant_id) . '" ';
            if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
            if (isset($params->highlighted)) $where .= 'AND `' . $dbtable . '`.`highlighted` = "' . $this->cms->db->query_value($params->highlighted) . '" ';
            if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
            if (isset($params->commented)) $where .= 'AND `' . $dbtable . '`.`commented` = "' . $this->cms->db->query_value($params->commented) . '" ';
            if (isset($params->ymarket)) $where .= 'AND `' . $dbtable . '`.`ymarket` = "' . $this->cms->db->query_value($params->ymarket) . '" ';
            if (isset($params->vkontakte)) $where .= 'AND `' . $dbtable . '`.`vkontakte` = "' . $this->cms->db->query_value($params->vkontakte) . '" ';
            if (isset($params->rss_disabled)) $where .= 'AND `' . $dbtable . '`.`rss_disabled` = "' . $this->cms->db->query_value($params->rss_disabled) . '" ';
            if (isset($params->export_disabled)) $where .= 'AND `' . $dbtable . '`.`export_disabled` = "' . $this->cms->db->query_value($params->export_disabled) . '" ';
            if (isset($params->non_creditable)) $where .= 'AND `' . $dbtable . '`.`non_creditable` = "' . $this->cms->db->query_value($params->non_creditable) . '" ';
            if (isset($params->browsed)) $where .= 'AND ABS(`' . $dbtable . '`.`browsed`) != 0 ';
            if (isset($params->SEOed)) $where .= 'AND TRIM(`' . $dbtable . '`.`seo_description`) != "" ';
            if (isset($params->url_special)) $where .= 'AND `' . $dbtable . '`.`url_special` = "' . $this->cms->db->query_value($params->url_special) . '" ';
            if (isset($params->in_price1)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 1) != 0 ';
            if (isset($params->in_price2)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 2) != 0 ';
            if (isset($params->in_price3)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 4) != 0 ';
            if (isset($params->in_price4)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 8) != 0 ';
            if (isset($params->in_price5)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 16) != 0 ';
            if (isset($params->in_price6)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 32) != 0 ';
            if (isset($params->in_price7)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 64) != 0 ';
            if (isset($params->in_price8)) $where .= 'AND (`' . $dbtable . '`.`in_prices` & 128) != 0 ';
            if ($where != '') $where = 'WHERE 1 ' . $where;
            if ($having != '') $having = 'HAVING 1 ' . $having;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $dbtable . '`.*, '
                                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                                              . 'SUM(ABS(`' . $dbtable2 . '`.`quantity`)) AS `total_quantity`, '
                                              . 'COUNT(`' . $dbtable2 . '`.`' . $idfield . '`) AS `total_rows` '
                   . 'FROM `' . $dbtable . '` '
                   . 'LEFT JOIN `' . $dbtable2 . '` ON `' . $dbtable2 . '`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` '
                   . $where
                   . 'GROUP BY `' . $dbtable . '`.`' . $idfield . '` '
                   . $having
                   . $order
                   . $limit . ';';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();

            // берем полное количество подобных записей
            $result2 = $this->cms->db->query('SELECT FOUND_ROWS() AS `count`;');
            $count = $this->cms->db->result();
            $count = isset($count->count) ? $count->count : 0;

            // освобождаем память от запроса
            $this->cms->db->free_result($result);
            $this->cms->db->free_result($result2);

            // возвращаем количество записей
            $this->cms->db->close_tracing_method();
            return $count;
        }



        // =======================================================================
        // Взять из базы данных запись о комплекте товаров, указанном в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название комплекта
        //   [$params->url] = адрес страницы записи
        //   [$params->url_special] = с особым url
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        //   [$params->non_creditable] = признак "не для кредита"
        //   [$params->discount] = величина скидки клиента
        // =======================================================================

        public function one ( & $item, $params = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' one');
            $dbtable2 = $this->getDBTable(TRUE);

            $item = null;
            $where = '';
            $discount = isset($params->discount) ? $this->cms->db->fix_discount($params->discount) : 0;

            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = "' . $this->cms->db->query_value($params->id) . '" ';
            if (isset($params->name)) $where .= 'AND `' . $dbtable . '`.`name` = "' . $this->cms->db->query_value($params->name) . '" ';
            if (isset($params->url)) $where .= 'AND `' . $dbtable . '`.`url` = "' . $this->cms->db->query_value($params->url) . '" ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` != "' . $this->cms->db->query_value($params->exclude_id) . '" ';
                if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
                if (isset($params->highlighted)) $where .= 'AND `' . $dbtable . '`.`highlighted` = "' . $this->cms->db->query_value($params->highlighted) . '" ';
                if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
                if (isset($params->rss_disabled)) $where .= 'AND `' . $dbtable . '`.`rss_disabled` = "' . $this->cms->db->query_value($params->rss_disabled) . '" ';
                if (isset($params->export_disabled)) $where .= 'AND `' . $dbtable . '`.`export_disabled` = "' . $this->cms->db->query_value($params->export_disabled) . '" ';
                if (isset($params->non_creditable)) $where .= 'AND `' . $dbtable . '`.`non_creditable` = "' . $this->cms->db->query_value($params->non_creditable) . '" ';
                if (isset($params->url_special)) $where .= 'AND `' . $dbtable . '`.`url_special` = "' . $this->cms->db->query_value($params->url_special) . '" ';
                $where = 'WHERE 1 ' . $where;

                // делаем запрос
                $query = 'SELECT `' . $dbtable . '`.*, '
                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                              . 'SUM(ABS(`' . $dbtable2 . '`.`quantity`)) AS `total_quantity`, '
                              . 'COUNT(`' . $dbtable2 . '`.`' . $idfield . '`) AS `total_rows` '
                       . 'FROM `' . $dbtable . '` '
                       . 'LEFT JOIN `' . $dbtable2 . '` ON `' . $dbtable2 . '`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` '
                       . $where
                       . 'GROUP BY `' . $dbtable . '`.`' . $idfield . '` '
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $item = $this->cms->db->result();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // поправляем поля записи
                if (!empty($item)) $this->unpack($item, $discount);
            }
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Обновление данных, связанных с записью
        *
        *  @access  protected
        *  @param   integer $id     идентификатор изменившейся записи
        *  @param   object  $item   объект записи (содержит изменившиеся поля):
        *                               ->products = список товаров
        *  @return  void
        */
        // ===================================================================

        protected function updateRest ( $id, & $item ) {

            // если существуют элементы комплекта
            if (isset($item->products)) {
                $idfield = $this->getIDField();
                $dbtable2 = $this->getDBTable(TRUE);
                $idfield2 = $this->getIDField(TRUE);
                $ids = array();

                // добавляем/обновляем записи элементов
                if (is_array($item->products) && !empty($item->products)) {
                    foreach ($item->products as & $row) {
                        if (empty($row->$idfield)) $row->$idfield = $id;
                        $i = $this->update($row, TRUE);
                        if (!empty($i)) $ids[$i] = $i;
                    }
                }

                // удаляем записи неиспользующихся более элементов
                $ids = implode(',', $ids);
                $query = 'DELETE FROM `' . $dbtable2 . '` '
                       . 'WHERE `' . $idfield . '` = \'' . $this->cms->db->query_value($id) . '\''
                              . (!empty($ids) ? ' AND `' . $idfield2 . '` NOT IN (' . $ids . ')' : '') . ';';
                $this->cms->db->query($query);
            }
        }



        // ===================================================================
        /**
        *  Распаковка полей записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   object  $params     объект параметров = ВЕЛИЧИНА СКИДКИ
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {
            parent::unpack($item);
            $this->unpackName($item);
            $this->unpackBody($item);
            $this->unpackUrl($item, 'kits');

            $id = $this->getIDField();
            if (!empty($item->$id)) {
                $dbtable2 = $this->getDBTable(TRUE);

                // поправляем поля счетчиков
                if (!isset($item->kit_comments_count)) $item->kit_comments_count = 0;
                if (!isset($item->comment_last_date)) $item->comment_last_date = '';

                // читаем в запись товары комплекта
                if (!isset($item->products)) {
                    $item->total_price = 0;
                    $item->final_price = 0;
                    $item->final_discount = 0;
                    $item->products = array();
                    $discount = $this->cms->db->fix_discount(is_numeric($params) ? $params : 0);
                    $price_id = isset($this->cms->user->price_id) ? $this->cms->user->price_id : 0;
                    $query = 'SELECT `products`.*, '
                                  . '`products_variants`.*, '
                                  . $this->cms->db->products->variantRealPriceField($price_id) . ' AS `real_price`, '
                                  . $this->cms->db->products->variantDiscountPriceField($price_id,
                                                                                        $discount,
                                                                                        '`' . $dbtable2 . '`.`discount`') . ' AS `discount_price`, '
                                  . '`products_variants`.`name` AS `variant_name`, '
                                  . '`categories`.`single_name` AS `category`, '
                                  . '`brands`.`name` AS `brand`, '
                                  . '`' . $dbtable2 . '`.* '
                           . 'FROM `' . $dbtable2 . '` '
                           . 'LEFT JOIN `products` ON `products`.`product_id` = `' . $dbtable2 . '`.`product_id` '
                           . 'LEFT JOIN `products_variants` ON `products_variants`.`product_id` = `' . $dbtable2 . '`.`product_id` '
                                                        . 'AND `products_variants`.`variant_id` = `' . $dbtable2 . '`.`variant_id` '
                           . 'LEFT JOIN `categories` ON `categories`.`category_id` = `products`.`category_id` '
                           . 'LEFT JOIN `brands` ON `brands`.`brand_id` = `products`.`brand_id` '
                           . 'WHERE `' . $dbtable2 . '`.`' . $id . '` = "' . $this->cms->db->query_value($item->$id) . '" '
                                 . 'AND `products`.`product_id` IS NOT NULL '
                                 . 'AND `products_variants`.`variant_id` IS NOT NULL '
                           . 'ORDER BY `' . $dbtable2 . '`.`position` ASC;';
                    $result = $this->cms->db->query($query);
                    if ($result !== FALSE) {
                        // извлекаем товары, подсчитываем итоги
                        while ($row = $this->cms->db->fetch_object($result)) {
                            $row->final_discount = $row->real_price > $row->discount_price ? 100 * (1 - $row->discount_price / $row->real_price) : 0;
                            $item->products[] = $row;
                            $item->total_price = $item->total_price + $row->real_price * $row->quantity;
                            $item->final_price = $item->final_price + $row->discount_price * $row->quantity;
                        }
                        // итоговая скидка
                        if ($item->total_price > $item->final_price) {
                            $item->final_discount = 100 * (1 - $item->final_price / $item->total_price);
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // поправляем поля записей о товарах
                    $params = new stdClass;
                    $params->discount = $discount;
                    $params->price_id = $price_id;
                    $this->cms->db->products->unpackRecords($item->products, $params);
                }
            }
        }
    }



    return;
?>