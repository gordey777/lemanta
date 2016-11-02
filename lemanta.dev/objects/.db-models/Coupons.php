<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Купоны: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CouponsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_COUPONS_TABLENAME;
        public $id_field = 'coupon_id';



        // ===================================================================
        /**
        *  Выбор записей из базы данных
        *
        *  @access  public
        *  @param   array   $items      массив прочитанных записей (будет помещен в эту переменную)
        *  @param   object  $params     объект параметров
        *                               [$params->sort] = способ сортировки записей
        *                               [$params->sort_direction] = направление сортировки
        *                               [$params->sort_laconical] = признак лаконичного режима сортировки
        *                               [$params->search] = искомый текст
        *                               [$params->search_date_from] = искомая дата от
        *                               [$params->search_date_to] = искомая дата до
        *                               [$params->ids] = идентификаторы записей (перечисленные через запятую)
        *                               [$params->group_id] = идентификатор группы скидок
        *                               [$params->price_id] = идентификатор ценовой группы
        *                               [$params->affiliate_id] = идентификатор партнера
        *                               [$params->user_id] = идентификатор пользователя
        *                               [$params->valid] = признак "действующий"
        *                               [$params->done] = признак "погашен"
        *                               [$params->enabled] = признак "разрешена" запись
        *                               [$params->deleted] = признак "удалена" запись
        *                               [$params->start] = начиная с такой позиции
        *                               [$params->maxcount] = не более такого количества
        *  @return  void
        */
        // ===================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get');

            $items = array();
            $where = '';
            $order = '';

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {

                    // по названию купона
                    case SORT_COUPONS_MODE_BY_NAME:
                        $order = '`' . $this->dbtable . '`.`name` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`name`) != \'\' ';
                        break;

                    // по контрольному коду купона
                    case SORT_COUPONS_MODE_BY_CODE:
                        $order = '`' . $this->dbtable . '`.`code` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`code`) != \'\' ';
                        break;

                    // по остатку разов использования
                    case SORT_COUPONS_MODE_BY_COUNT:
                        $order = '`' . $this->dbtable . '`.`count` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`count` > 0 ';
                        break;

                    // по разовой скидке
                    case SORT_COUPONS_MODE_BY_DISCOUNT:
                        $order = '`' . $this->dbtable . '`.`discount` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`discount` > 0 ';
                        break;

                    // по назначаемой группе скидок
                    case SORT_COUPONS_MODE_BY_GROUP:
                        $order = '`group_name` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`group_id` != 0 ';
                        break;

                    // по назначаемой ценовой группе
                    case SORT_COUPONS_MODE_BY_PRICE:
                        $order = '`' . $this->dbtable . '`.`price_id` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`price_id` != 0 ';
                        break;

                    // по назначаемому партнеру
                    case SORT_COUPONS_MODE_BY_AFFILIATE:
                        $order = '`affiliate_name` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`affiliate_id` != 0 ';
                        break;

                    // по погасившему пользователю
                    case SORT_COUPONS_MODE_BY_USER:
                        $order = '`user_name` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`user_id` != 0 ';
                        break;

                    // по погасившему заказу
                    case SORT_COUPONS_MODE_BY_ORDER:
                        $order = '`' . $this->dbtable . '`.`order_id` ' . $direction . ' ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`order_id` != 0 ';
                        break;

                    // по сроку действия
                    case SORT_COUPONS_MODE_BY_EXPIRED:
                        $order = '`expired` ' . $direction . ' ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`created` <= NOW() '
                                                . 'AND FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) >= NOW() ';
                        break;

                    // по дате изменения
                    case SORT_COUPONS_MODE_BY_MODIFIED:
                        $order = '`' . $this->dbtable . '`.`modified` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`modified` IS NOT NULL '
                                                . 'AND `' . $this->dbtable . '`.`modified` != \'0000-00-00 00:00:00\' '
                                                . 'AND `' . $this->dbtable . '`.`modified` != `' . $this->dbtable . '`.`created` ';
                        break;

                    // по дате создания
                    case SORT_COUPONS_MODE_BY_CREATED:
                        $order = '`' . $this->dbtable . '`.`created` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`created` IS NOT NULL '
                                                . 'AND `' . $this->dbtable . '`.`created` != \'0000-00-00 00:00:00\' ';
                        break;

                    // по емейлу
                    case SORT_COUPONS_MODE_BY_EMAIL:
                        $order = '`' . $this->dbtable . '`.`email` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`email`) != \'\' ';
                        break;

                    // по емейлу
                    case SORT_COUPONS_MODE_BY_PHONE:
                        $order = '`' . $this->dbtable . '`.`phone` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`phone`) != \'\' ';
                        break;

                    // по печатным формам
                    case SORT_COUPONS_MODE_BY_PRINTER:
                        $order = '`' . $this->dbtable . '`.`printer` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`code` ASC ';
                        break;

                    // как добавлялись
                    case SORT_COUPONS_MODE_AS_IS:
                        $order = '`' . $this->dbtable . '`.`created` ' . $direction . ' ';
                        break;

                    // иначе (по контрольному коду)
                    default:
                        $order = '`' . $this->dbtable . '`.`code` ASC ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->group_id)) $where .= 'AND `' . $this->dbtable . '`.`group_id` = \'' . $this->cms->db->query_value($params->group_id) . '\' ';
            if (isset($params->price_id)) $where .= 'AND `' . $this->dbtable . '`.`price_id` = \'' . $this->cms->db->query_value($params->price_id) . '\' ';
            if (isset($params->affiliate_id)) $where .= 'AND `' . $this->dbtable . '`.`affiliate_id` = \'' . $this->cms->db->query_value($params->affiliate_id) . '\' ';
            if (isset($params->user_id)) $where .= 'AND `' . $this->dbtable . '`.`user_id` = \'' . $this->cms->db->query_value($params->user_id) . '\' ';
            if (isset($params->valid)) {
                if ($params->valid) {
                    $where .= 'AND `' . $this->dbtable . '`.`count` > 0 '
                            . 'AND `' . $this->dbtable . '`.`created` <= NOW() '
                            . 'AND FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) >= NOW() ';
                } else {
                    $where .= 'AND ( `' . $this->dbtable . '`.`count` <= 0 '
                            . 'OR `' . $this->dbtable . '`.`created` > NOW() '
                            . 'OR FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) < NOW()) ';
                }
            }
            if (isset($params->done)) $where .= 'AND `' . $this->dbtable . '`.`discharged` ' . ($params->done ? '!=' : '=') . ' \'0000-00-00 00:00:00\' ';
            if (isset($params->enabled)) $where .= 'AND `' . $this->dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
            $where = 'WHERE `' . $this->dbtable . '`.`deleted` = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;



            // фильтруем по искомой дате
            if (isset($params->search_date_from)) $where .= 'AND `' . $this->dbtable . '`.`created` >= \'' . $this->cms->db->query_value($params->search_date_from) . ' 00:00:00\' ';
            if (isset($params->search_date_to)) $where .= 'AND `' . $this->dbtable . '`.`created` <= \'' . $this->cms->db->query_value($params->search_date_to) . ' 23:59:59\' ';



            // фильтруем по искомому тексту
            if (isset($params->search) && ($params->search != '')) {
                $keywords = preg_split('/[\s\t\r\n]+/', trim($params->search), 4);
                foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 2) {
                        $command = strtolower(trim(substr($keyword, 0, 6)));
                        switch ($command) {
                            case SEARCH_COUPONS_COMMAND_DISCOUNT:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND ROUND(`' . $this->dbtable . '`.`discount` * 100) = ROUND(\'' . $this->cms->db->query_value($keyword) . '\' * 100) ';
                                break;
                            case SEARCH_COUPONS_COMMAND_GROUP_DISCOUNT:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`group_id` != 0 '
                                                            . 'AND ROUND(CASE WHEN `' . DATABASE_GROUPS_TABLENAME . '`.`discount` IS NOT NULL '
                                                                           . 'THEN `' . DATABASE_GROUPS_TABLENAME . '`.`discount` '
                                                                           . 'ELSE 0 '
                                                                           . 'END * 100) = ROUND(\'' . $this->cms->db->query_value($keyword) . '\' * 100) ';
                                break;
                            case SEARCH_COUPONS_COMMAND_MODIFIED_DATE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`modified`, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_CREATED_DATE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`created`, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_EXPIRED_DATE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_DISCHARGED_DATE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`discharged`, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_AFFILIATE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`affiliate_id` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_USER:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`user_id` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_GROUP:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`group_id` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_PRICE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`price_id` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_ORDER:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`order_id` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_PRINTER:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`printer` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_EMAIL:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`email` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            case SEARCH_COUPONS_COMMAND_PHONE:
                                $keyword = trim(substr($keyword, 6));
                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`phone` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                break;
                            default:
                                $keyword = $this->cms->db->query_value($keyword);
                                $where .= 'AND (`' . $this->dbtable . '`.code = \'' . $keyword . '\' '
                                          . 'OR `' . $this->dbtable . '`.name LIKE \'%' . $keyword . '%\') ';
                        }
                    }
                }
            }



            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);



            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $this->dbtable . '`.*, '
                                              . '`' . DATABASE_GROUPS_TABLENAME . '`.`name` AS `group_name`, '
                                              . '`' . DATABASE_GROUPS_TABLENAME . '`.`discount` AS `group_discount`, '
                                              . '`u1`.`name` AS `affiliate_name`, '
                                              . 'CASE WHEN TRIM(`u1`.`email`) != \'\' '
                                                   . 'THEN TRIM(`u1`.`email`) '
                                                   . 'ELSE TRIM(`u1`.`email2`) '
                                                   . 'END AS `affiliate_email`, '
                                              . 'CASE WHEN TRIM(`u1`.`phone`) != \'\' '
                                                   . 'THEN TRIM(`u1`.`phone`) '
                                                   . 'ELSE TRIM(`u1`.`phone2`) '
                                                   . 'END AS `affiliate_phone`, '
                                              . '`u2`.`name` AS `user_name`, '
                                              . 'CASE WHEN `' . $this->dbtable . '`.`count` > 0 '
                                                    . 'AND `' . $this->dbtable . '`.`created` <= NOW() '
                                                    . 'AND FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) >= NOW() '
                                                   . 'THEN 1 '
                                                   . 'ELSE 0 '
                                                   . 'END AS `valid`, '
                                              . 'DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' .  $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%Y-%m-%d %H:%i:%s\') AS `expired`, '
                                              . 'DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' .  $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%Y-%m-%d\') AS `expired_date`, '
                                              . 'DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' .  $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%H:%i:%s\') AS `expired_time` '
                   . 'FROM `' . $this->dbtable . '` '
                   . 'LEFT JOIN `' . DATABASE_GROUPS_TABLENAME . '` '
                                   . 'ON `' . DATABASE_GROUPS_TABLENAME . '`.`group_id` = `' . $this->dbtable . '`.`group_id` '
                                   . 'AND `' . DATABASE_GROUPS_TABLENAME . '`.`authorized` = 1 '
                                   . 'AND `' . DATABASE_GROUPS_TABLENAME . '`.`enabled` = 1 '
                                   . 'AND `' . DATABASE_GROUPS_TABLENAME . '`.`deleted` = 0 '
                   . 'LEFT JOIN `' . DATABASE_USERS_TABLENAME . '` AS `u1` '
                                   . 'ON `u1`.`user_id` = `' . $this->dbtable . '`.`affiliate_id` '
                                   . 'AND `u1`.`enabled` = 1 '
                                   . 'AND `u1`.`deleted` = 0 '
                   . 'LEFT JOIN `' . DATABASE_USERS_TABLENAME . '` AS `u2` '
                                   . 'ON `u2`.`user_id` = `' . $this->dbtable . '`.`user_id` '
                                   . 'AND `u2`.`enabled` = 1 '
                                   . 'AND `u2`.`deleted` = 0 '
                   . $where
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



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем количество записей
            return $count;
        }



        // ===================================================================
        /**
        *  Получение из базы данных записи, указанной в параметрах
        *
        *  @access  public
        *  @param   object  $item       прочитанная запись (будет помещена в эту переменную)
        *  @param   object  $params     объект параметров
        *                               [$params->id] = идентификатор записи
        *                               [$params->exclude_id] = кроме идентификатора записи
        *                               [$params->name] = название
        *                               [$params->code] = контрольный код
        *                               [$params->valid] = признак "действующий"
        *                               [$params->done] = признак "погашен"
        *                               [$params->enabled] = признак "разрешена" запись
        *                               [$params->deleted] = признак "удалена" запись
        *  @return  void
        */
        // ===================================================================

        public function one ( & $item, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' one');



            $item = null;
            $where = '';



            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` = \'' . $this->cms->db->query_value($params->id) . '\' ';
            if (isset($params->name)) $where .= 'AND `' . $this->dbtable . '`.`name` = \'' . $this->cms->db->query_value($params->name) . '\' ';
            if (isset($params->code)) $where .= 'AND `' . $this->dbtable . '`.`code` = \'' . $this->cms->db->query_value($params->code) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->valid)) {
                    if ($params->valid) {
                        $where .= 'AND `' . $this->dbtable . '`.`count` > 0 '
                                . 'AND `' . $this->dbtable . '`.`created` <= NOW() '
                                . 'AND FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) >= NOW() ';
                    } else {
                        $where .= 'AND ( `' . $this->dbtable . '`.`count` <= 0 '
                                . 'OR `' . $this->dbtable . '`.`created` > NOW() '
                                . 'OR FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) < NOW()) ';
                    }
                }
                if (isset($params->done)) $where .= 'AND `' . $this->dbtable . '`.`discharged` ' . ($params->done ? '!=' : '=') . ' \'0000-00-00 00:00:00\' ';
                if (isset($params->enabled)) $where .= 'AND `' . $this->dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
                $where = 'WHERE `' . $this->dbtable . '`.`deleted` = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;



                // делаем запрос
                $query = 'SELECT `' . $this->dbtable . '`.*, '
                              . '`' . DATABASE_GROUPS_TABLENAME . '`.`name` AS `group_name`, '
                              . '`' . DATABASE_GROUPS_TABLENAME . '`.`discount` AS `group_discount`, '
                              . '`u1`.`name` AS `affiliate_name`, '
                              . 'CASE WHEN TRIM(`u1`.`email`) != \'\' '
                                   . 'THEN TRIM(`u1`.`email`) '
                                   . 'ELSE TRIM(`u1`.`email2`) '
                                   . 'END AS `affiliate_email`, '
                              . 'CASE WHEN TRIM(`u1`.`phone`) != \'\' '
                                   . 'THEN TRIM(`u1`.`phone`) '
                                   . 'ELSE TRIM(`u1`.`phone2`) '
                                   . 'END AS `affiliate_phone`, '
                              . '`u2`.`name` AS `user_name`, '
                              . 'CASE WHEN `' . $this->dbtable . '`.`count` > 0 '
                                    . 'AND `' . $this->dbtable . '`.`created` <= NOW() '
                                    . 'AND FROM_UNIXTIME(UNIX_TIMESTAMP(`' . $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`) >= NOW() '
                                   . 'THEN 1 '
                                   . 'ELSE 0 '
                                   . 'END AS `valid`, '
                              . 'DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' .  $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%Y-%m-%d %H:%i:%s\') AS `expired`, '
                              . 'DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' .  $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%Y-%m-%d\') AS `expired_date`, '
                              . 'DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(`' .  $this->dbtable . '`.`created`) + `' . $this->dbtable . '`.`lifetime`), \'%H:%i:%s\') AS `expired_time` '
                       . 'FROM `' . $this->dbtable . '` '
                       . 'LEFT JOIN `' . DATABASE_GROUPS_TABLENAME . '` '
                                       . 'ON `' . DATABASE_GROUPS_TABLENAME . '`.`group_id` = `' . $this->dbtable . '`.`group_id` '
                                       . 'AND `' . DATABASE_GROUPS_TABLENAME . '`.`authorized` = 1 '
                                       . 'AND `' . DATABASE_GROUPS_TABLENAME . '`.`enabled` = 1 '
                                       . 'AND `' . DATABASE_GROUPS_TABLENAME . '`.`deleted` = 0 '
                       . 'LEFT JOIN `' . DATABASE_USERS_TABLENAME . '` AS `u1` '
                                       . 'ON `u1`.`user_id` = `' . $this->dbtable . '`.`affiliate_id` '
                                       . 'AND `u1`.`enabled` = 1 '
                                       . 'AND `u1`.`deleted` = 0 '
                       . 'LEFT JOIN `' . DATABASE_USERS_TABLENAME . '` AS `u2` '
                                       . 'ON `u2`.`user_id` = `' . $this->dbtable . '`.`user_id` '
                                       . 'AND `u2`.`enabled` = 1 '
                                       . 'AND `u2`.`deleted` = 0 '
                       . $where
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $item = $this->cms->db->result();



                // освобождаем память от запроса
                $this->cms->db->free_result($result);



                // поправляем поля записи
                if (!empty($item)) $this->unpack($item);
            }



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Добавление в записи оперативных ссылок админпанели
        *
        *  @access  public
        *  @param   array   $items      массив записей
        *  @param   object  $params     объект параметров
        *                               $params->token = аутентификатор операции
        *                               [$params->sort] = способ сортировки записей
        *  @return  void
        */
        // ===================================================================

        public function operable ( & $items, $params ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' operable');



            if (!empty($items) && isset($params->token)) {
                $id = $this->id_field;
                foreach ($items as & $item) {
                    if (isset($item->$id)) {

                        // собираем параметры
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'Coupons',
                                         REQUEST_PARAM_NAME_ITEMID => $item->$id,
                                         REQUEST_PARAM_NAME_TOKEN => $params->token);
                        if (isset($params->sort)) $options[REQUEST_PARAM_NAME_SORT] = $params->sort;



                        // создаем ссылку "разрешена"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "создать копию"
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Coupon';
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COPY;
                        $item->copy_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Coupon';
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
                $fields = array();
                $values = array();
                $this->prepareField($item, $this->id_field, 'integer',  $fields, $values);
                $this->prepareField($item, 'name',          'string',   $fields, $values);
                $this->prepareField($item, 'code',          'string',   $fields, $values);
                $this->prepareField($item, 'printer',       'integer',  $fields, $values);
                $this->prepareField($item, 'count',         'integer',  $fields, $values);
                $this->prepareField($item, 'discount',      'positive', $fields, $values);
                $this->prepareField($item, 'group_id',      'integer',  $fields, $values);
                $this->prepareField($item, 'price_id',      'integer',  $fields, $values);
                $this->prepareField($item, 'affiliate_id',  'integer',  $fields, $values);
                $this->prepareField($item, 'user_id',       'integer',  $fields, $values);
                $this->prepareField($item, 'order_id',      'integer',  $fields, $values);
                $this->prepareField($item, 'enabled',       'boolean',  $fields, $values);
                $this->prepareField($item, 'deleted',       'boolean',  $fields, $values);
                $this->prepareField($item, 'lifetime',      'integer',  $fields, $values);
                $this->prepareField($item, 'discharged',    'date',     $fields, $values);
                $this->prepareField($item, 'email',         'string',   $fields, $values);
                $this->prepareField($item, 'phone',         'string',   $fields, $values);
                $this->prepareField($item, 'created',       'date',     $fields, $values);
                $this->prepareField($item, 'modified',      'date',     $fields, $values);

                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, $this->dbtable, $this->id_field, $fields, $values);

                // если выполнено
                if (!empty($id)) {

                    // проверяем необходимость очистить кеш-таблицы кредитных программ
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
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {

            // поправляем строковые поля
            if (isset($item->name)) $this->cms->db->fix_textfield_as_product_name($item->name);

            // поправляем адресующие поля
            $id = $this->id_field;
            if (isset($item->$id)) $item->$id = intval($item->$id);

            // поправляем поле имени партнера
            if (isset($item->affiliate_name) && ($item->affiliate_name != '')) {
                $user = new stdClass;
                $user->name = $item->affiliate_name;
                $this->unpackUserName($user);
                $item->affiliate_name = $user->compound_name;
            }

            // поправляем поле имени погасившего пользователя
            if (isset($item->user_name) && ($item->user_name != '')) {
                $user = new stdClass;
                $user->name = $item->user_name;
                $this->unpackUserName($user);
                $item->user_name = $user->compound_name;
            }
        }



        // ===================================================================
        /**
        *  Проверка и поправка таблицы в базе данных
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function check () {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' check');



            // проверяем наличие таблицы, при отсутствии создаем
            $columns = $this->cms->db->get_dbtable_fields($this->dbtable);
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $this->dbtable . '` (`' . $this->id_field . '` BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');



            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$this->id_field])) {
                $query[] = 'ADD `' . $this->id_field . '` BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE `' . $this->dbtable . '` SET `' . $this->id_field . '` = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (`' . $this->id_field . '`)';
                $query[] = 'CHANGE `' . $this->id_field . '` `' . $this->id_field . '` BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор купона\'';
            } else {



                // купон
                $name = $this->id_field;
                $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор купона\'';
            }



            // название
            $name = 'name';
            $type = 'VARCHAR(' . DATABASE_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название купона\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // код
            $name = 'code';
            $type = 'VARCHAR(32)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Контрольный код\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // номер печатной формы
            $name = 'printer';
            $type = 'INT(11) UNSIGNED';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'1\' NOT NULL COMMENT \'Номер печатной формы\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // остаток разов использования
            $name = 'count';
            $type = 'INT(11) UNSIGNED';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'1\' NOT NULL COMMENT \'Остаток разов использования\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // разовая скидка
            $name = 'discount';
            $type = 'FLOAT(' . DATABASE_FIELDSIZE_PERCENT . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Процент разовой скидки\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД группы скидок
            $name = 'group_id';
            $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор назначаемой группы скидок\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД ценовой группы
            $name = 'price_id';
            $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор назначаемой ценовой группы\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД партнера
            $name = 'affiliate_id';
            $type = 'BIGINT(' . DATABASE_USERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор назначаемого партнера\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД погасившего пользователя
            $name = 'user_id';
            $type = 'BIGINT(' . DATABASE_USERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор погасившего пользователя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД погасившего заказа
            $name = 'order_id';
            $type = 'BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор погасившего заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // разрешена
            $name = 'enabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'1\' NOT NULL COMMENT \'Признак Запись разрешена\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // удалена
            $name = 'deleted';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Запись удалена\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // срок действия
            $name = 'lifetime';
            $type = 'INT(' . DATABASE_FIELDSIZE_LIFETIME . ') UNSIGNED';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Срок действия в секундах\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // погашено
            $name = 'discharged';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата погашения\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // емейл
            $name = 'email';
            $type = 'VARCHAR(64)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Емейл для уведомлений по активности\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // телефон
            $name = 'phone';
            $type = 'VARCHAR(64)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Телефон для SMS-уведомлений по активности\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // создано
            $name = 'created';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата создания записи\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // изменено
            $name = 'modified';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата изменения записи\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // выполняем сформированные запросы
            foreach ($query as & $command) {
                if (trim($command) != '') {
                    if (substr($command, 0, 1) == '>') {
                        $command = trim(substr($command, 1));
                        if ($command != '') $command .= ';';
                    } else {
                        $command = 'ALTER TABLE `' . $this->dbtable . '` ' . $command . ';';
                    }
                    if ($command != '') $this->cms->db->query($command);
                }
            }
            foreach ($subquery as & $command) {
                if (trim($command) != '') $this->cms->db->query($command);
            }



            // если таблица не существовала, проверяем наличие минимально необходимых записей
            if (empty($columns)) $this->setup($this->dbtable, $this->id_field, 1);



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }
    }



    return;
?>