<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Страны: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CountriesDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'countries';
        public $id_field = 'country_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'name',             // название
                'enabled',          // разрешена
                'hidden',           // скрыта
                'highlighted',      // выделена
                'commented',        // обсуждаема
                'url',              // адрес
                'url_special',      // особый адрес
                'meta_title',       // мета заголовок
                'meta_keywords',    // мета ключевые слова
                'meta_description', // мета описание
                'description',      // описание
                'seo_description',  // seo текст

                // название
                'phone_code'        => array('type' => 'VARCHAR(16)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Телефонный код страны"'),

                'tags',             // теги
                'template',         // шаблон
                'images',           // фото
                'images_alts',      // надписи фото
                'images_texts',     // описания фото
                'images_view',      // слайдинг-признаки
                'browsed',          // просмотры
                'order_num',        // вес
                'created',          // создано
                'modified'          // изменено
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'Countries';
        protected $operables_card = 'Country';
        protected $operables = array('move_up', 'move_down', 'move_first', 'move_last',
                                     'delete', 'edit',
                                     'enable', 'highlight', 'hidden', 'commented');



        // =======================================================================
        // Выбрать из базы данных записи о странах:
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->ids] = идентификаторы стран (перечисленные через запятую)
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->browsed] = просмотренные
        //   [$params->SEOed] = с SEO текстом
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' get');

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

                    // по названию
                    case SORT_COUNTRIES_MODE_BY_NAME:
                        $order = '`' . $dbtable . '`.`name` ' . $direction . ', '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`name`) != "" ';
                        break;

                    // по адресу страницы
                    case SORT_COUNTRIES_MODE_BY_URL:
                        $order = '`' . $dbtable . '`.`url` ' . $direction;
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`url`) != "" ';
                        break;

                    // по числу просмотров
                    case SORT_COUNTRIES_MODE_BY_BROWSED:
                        $order = '`browsed` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND ABS(`' . $dbtable . '`.`browsed`) > 0 ';
                        break;

                    // по количеству областей
                    case SORT_COUNTRIES_MODE_BY_REGIONSCOUNT:
                        $order = '`regions_count` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $having .= 'AND COUNT(`regions`.`region_id`) > 0 ';
                        break;

                    // по количеству городов
                    case SORT_COUNTRIES_MODE_BY_TOWNSCOUNT:
                        $order = '`towns_count` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $having .= 'AND COUNT(`towns`.`town_id`) > 0 ';
                        break;

                    // по количеству пользователей
                    case SORT_COUNTRIES_MODE_BY_USERSCOUNT:
                        $order = '`users_count` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $having .= 'AND COUNT(`users`.`user_id`) > 0 ';
                        break;

                    // по количеству заказов
                    case SORT_COUNTRIES_MODE_BY_ORDERSCOUNT:
                        $order = '`orders_count` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $having .= 'AND COUNT(`orders`.`order_id`) > 0 ';
                        break;

                    // по дате создания
                    case SORT_COUNTRIES_MODE_BY_CREATED:
                        $order = '`' . $dbtable . '`.`created` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`created` IS NOT NULL ';
                        break;

                    // по дате изменения
                    case SORT_COUNTRIES_MODE_BY_MODIFIED:
                        $order = '`' . $dbtable . '`.`modified` ' . $direction . ', '
                               . '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`modified` IS NOT NULL '
                                                . 'AND `' . $dbtable . '`.`modified` != `' . $dbtable . '`.`created` ';
                        break;

                    // как расставлены
                    case SORT_COUNTRIES_MODE_AS_IS:
                    default:
                        $order = '`' . $dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`name`) != "" ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN ("' . str_replace(',', '","', $this->cms->db->query_value($params->ids)) . '") ';
            if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
            if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
            if (isset($params->imaged)) $where .= 'AND TRIM(REPLACE(`' . $dbtable . '`.`images`, "|", "")) != "" ';
            if (isset($params->browsed)) $where .= 'AND `' . $dbtable . '`.`browsed` != 0 ';
            if (isset($params->SEOed)) $where .= 'AND TRIM(`' . $dbtable . '`.`seo_description`) != "" ';
            if ($where != '') $where = 'WHERE 1 ' . $where;
            if ($having != '') $having = 'HAVING 1 ' . $having;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $dbtable . '`.*, '
                                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                                              . 'COUNT(DISTINCT `regions`.`region_id`) AS `regions_count`, '
                                              . 'COUNT(DISTINCT `towns`.`town_id`) AS `towns_count`, '
                                              . 'COUNT(DISTINCT `users`.`user_id`) AS `users_count`, '
                                              . 'COUNT(DISTINCT `orders`.`order_id`) AS `orders_count` '
                   . 'FROM `' . $dbtable . '` '
                   . 'LEFT JOIN `regions` ON `regions`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` AND `regions`.`enabled` = 1 '
                   . 'LEFT JOIN `towns` ON `towns`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` AND `towns`.`enabled` = 1 '
                   . 'LEFT JOIN `users` ON `users`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` AND `users`.`enabled` = 1 '
                   . 'LEFT JOIN `orders` ON `orders`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` '
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
        // Взять из базы данных запись о стране, указанной в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название страны
        //   [$params->region] = название области
        //   [$params->region_id] = идентификатор области
        //   [$params->town] = название города
        //   [$params->town_id] = идентификатор города
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->order_id] = идентификатор заказа
        //   [$params->url] = адрес страницы записи
        //   [$params->enabled] = признак "разрешена" запись
        // =======================================================================

        public function one ( & $item, $params = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' one');

            $item = null;
            $where = '';

            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = "' . $this->cms->db->query_value($params->id) . '" ';
            if (isset($params->name)) $where .= 'AND `' . $dbtable . '`.`name` = "' . $this->cms->db->query_value($params->name) . '" ';
            if (isset($params->region)) $where .= 'AND `regions`.`name` = "' . $this->cms->db->query_value($params->region) . '" ';
            if (isset($params->region_id)) $where .= 'AND `regions`.`region_id` = "' . $this->cms->db->query_value($params->region_id) . '" ';
            if (isset($params->town)) $where .= 'AND `towns`.`name` = "' . $this->cms->db->query_value($params->town) . '" ';
            if (isset($params->town_id)) $where .= 'AND `towns`.`town_id` = "' . $this->cms->db->query_value($params->town_id) . '" ';
            if (isset($params->user_id)) $where .= 'AND `users`.`user_id` = "' . $this->cms->db->query_value($params->user_id) . '" ';
            if (isset($params->order_id)) $where .= 'AND `orders`.`order_id` = "' . $this->cms->db->query_value($params->order_id) . '" ';
            if (isset($params->url)) $where .= 'AND `' . $dbtable . '`.`url` = "' . $this->cms->db->query_value($params->url) . '" ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` != "' . $this->cms->db->query_value($params->exclude_id) . '" ';
                if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
                $where = 'WHERE 1 ' . $where;

                // делаем запрос
                $query = 'SELECT `' . $dbtable . '`.*, '
                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                              . 'COUNT(DISTINCT `regions`.`region_id`) AS `regions_count`, '
                              . 'COUNT(DISTINCT `towns`.`town_id`) AS `towns_count`, '
                              . 'COUNT(DISTINCT `users`.`user_id`) AS `users_count`, '
                              . 'COUNT(DISTINCT `orders`.`order_id`) AS `orders_count` '
                       . 'FROM `' . $dbtable . '` '
                       . 'LEFT JOIN `regions` ON `regions`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` AND `regions`.`enabled` = 1 '
                       . 'LEFT JOIN `towns` ON `towns`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` AND `towns`.`enabled` = 1 '
                       . 'LEFT JOIN `users` ON `users`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` AND `users`.`enabled` = 1 '
                       . 'LEFT JOIN `orders` ON `orders`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` '
                       . $where
                       . 'GROUP BY `' . $dbtable . '`.`' . $idfield . '` '
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $item = $this->cms->db->result();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // поправляем поля записи
                if (!empty($item)) $this->unpack($item);
            }
            $this->cms->db->close_tracing_method();
        }



        // =======================================================================
        // Выбрать из базы данных дерево записей о странах:
        //   $items = результат будет помещен в эту переменную
        // =======================================================================

        public function getTree ( & $items ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' getTree');

            // делаем запрос
            $query = 'SELECT `' . $idfield . '` AS `id`, '
                          . '`name`, '
                          . '`url` '
                   . 'FROM `' . $dbtable . '` '
                   . 'WHERE `enabled` = 1 '
                         . 'AND TRIM(`name`) != "" '
                   . 'ORDER BY `name` ASC;';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();

            // освобождаем память от запроса
            $this->cms->db->free_result($result);

            $this->cms->db->close_tracing_method();
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
            $this->unpackUrl($item, 'countries');
            $this->unpackImages($item);
        }



        // ===================================================================
        /**
        *  Заполнение таблицы минимально необходимыми записями
        *
        *  @access  public
        *  @param   string  $dbtable    имя таблицы
        *  @param   string  $idfield    имя колонки идентификатора
        *  @param   integer $number     номер таблицы в списке таблиц модели
        *  @return  void
        */
        // ===================================================================

        public function setup ( $dbtable, $idfield, $number ) {
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' setup');

            // создаем перечень минимально необходимых записей
            $records = array();
            $records[] = array('name' => 'Англия',     'enabled' => 1, 'order_num' => 9992);
            $records[] = array('name' => 'Белоруссия', 'enabled' => 1, 'order_num' => 9998);
            $records[] = array('name' => 'Германия',   'enabled' => 1, 'order_num' => 9994);
            $records[] = array('name' => 'Израиль',    'enabled' => 1, 'order_num' => 9995);
            $records[] = array('name' => 'Китай',      'enabled' => 1, 'order_num' => 9991);
            $records[] = array('name' => 'Латвия',     'enabled' => 1, 'order_num' => 9996);
            $records[] = array('name' => 'Молдова',    'enabled' => 1, 'order_num' => 9997);
            $records[] = array('name' => 'Польша',     'enabled' => 1, 'order_num' => 9989);
            $records[] = array('name' => 'Россия',     'enabled' => 1, 'order_num' => 10000);
            $records[] = array('name' => 'США',        'enabled' => 1, 'order_num' => 9990);
            $records[] = array('name' => 'Украина',    'enabled' => 1, 'order_num' => 9999);
            $records[] = array('name' => 'Франция',    'enabled' => 1, 'order_num' => 9993);

            // читаем список имеющихся записей
            $query = 'SELECT `name` '
                   . 'FROM `' . $dbtable . '`;';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();

            // освобождаем память от запроса
            $this->cms->db->free_result($result);

            // готовим результат для циклического перебора
            if (!empty($items)) {
                foreach ($items as & $item) $item = $this->text->lowerCase(trim($item->name));
            } else {
                $items = array();
            }

            // просматриваем перечень необходимых записей
            foreach ($records as & $record) {
                $value = $this->text->lowerCase($record['name']);

                // перебираем имеющиеся записи и сравниваем с необходимой
                foreach ($items as & $item) {
                    if ($item == $value) continue 2;
                }

                // необходимая запись не найдена, добавляем ее
                $value = new stdClass;
                $value->name = $record['name'];
                $value->enabled = !empty($record['enabled']) ? 1 : 0;
                $value->order_num = isset($record['order_num']) ? intval($record['order_num']) : 0;
                $value->created = time();
                $this->update($value);
            }
            $this->cms->db->close_tracing_method();
        }
    }



    return;
?>