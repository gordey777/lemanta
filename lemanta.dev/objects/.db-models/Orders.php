<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Заказы: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class OrdersDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_ORDERS_TABLENAME;
        public $id_field = 'order_id';



        // =======================================================================
        // Выбрать из базы данных записи о заказах связи согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->type] = тип состояния заказа
        //   [$params->search] = искомый текст
        //   [$params->search_date_from] = искомая дата от
        //   [$params->search_date_to] = искомая дата до
        //   [$params->search_paydate_from] = искомая дата оплаты от
        //   [$params->search_paydate_to] = искомая дата оплаты до
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->delivery_id] = идентификатор способа доставки
        //   [$params->payment_id] = идентификатор способа оплаты
        //   [$params->payment_status] = состояние оплаты
        //   [$params->creditable] = оформленные в кредит
        //   [$params->status] = состояние заказа
        //   [$params->hidden] = признак "скрыт от чужих"
        //   [$params->affiliate_id] = идентификатор реферала
        //   [$params->ids] = идентификаторы заказов (перечисленные через запятую)
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get');

            $items = array();
            $where = '';
            $having = '';
            $order = '';

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // делаем селекцию указанного типа
            if (isset($params->type)) {
                switch ($params->type) {
                    case TYPE_ORDERS_COMING:
                        $where .= 'AND ' . $this->dbtable . '.status = \'' . $this->cms->db->query_value(ORDER_STATUS_NEW) . '\' ';
                        break;
                    case TYPE_ORDERS_PROCESSING:
                        $where .= 'AND ' . $this->dbtable . '.status = \'' . $this->cms->db->query_value(ORDER_STATUS_PROCESS) . '\' ';
                        break;
                    case TYPE_ORDERS_DONE:
                        $where .= 'AND ' . $this->dbtable . '.status = \'' . $this->cms->db->query_value(ORDER_STATUS_DONE) . '\' ';
                        break;
                    case TYPE_ORDERS_CANCELED:
                        $where .= 'AND ' . $this->dbtable . '.status = \'' . $this->cms->db->query_value(ORDER_STATUS_CANCEL) . '\' ';
                        break;
                    case TYPE_ORDERS_ANY:
                        break;
                }
            }

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_ORDERS_MODE_BY_NAME:
                        $order = $this->dbtable . '.name ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . $this->dbtable . '.name) != \'\' ';
                        break;
                    case SORT_ORDERS_MODE_BY_PHONE:
                        $order = 'CASE WHEN TRIM(' . $this->dbtable . '.phone) != \'\' '
                                    . 'THEN ' . $this->dbtable . '.phone '
                                    . 'ELSE ' . $this->dbtable . '.phone2 '
                                    . 'END ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND (TRIM(' . $this->dbtable . '.phone) != \'\' OR TRIM(' . $this->dbtable . '.phone2) != \'\') ';
                        break;
                    case SORT_ORDERS_MODE_BY_EMAIL:
                        $order = 'CASE WHEN TRIM(' . $this->dbtable . '.email) != \'\' '
                                    . 'THEN ' . $this->dbtable . '.email '
                                    . 'ELSE ' . $this->dbtable . '.email2 '
                                    . 'END ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND (TRIM(' . $this->dbtable . '.email) != \'\' OR TRIM(' . $this->dbtable . '.email2) != \'\') ';
                        break;
                    case SORT_ORDERS_MODE_BY_ICQ:
                        $order = 'CASE WHEN TRIM(' . $this->dbtable . '.icq) != \'\' '
                                    . 'THEN ' . $this->dbtable . '.icq '
                                    . 'ELSE ' . $this->dbtable . '.icq2 '
                                    . 'END ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND (TRIM(' . $this->dbtable . '.icq) != \'\' OR TRIM(' . $this->dbtable . '.icq2) != \'\') ';
                        break;
                    case SORT_ORDERS_MODE_BY_SKYPE:
                        $order = 'CASE WHEN TRIM(' . $this->dbtable . '.skype) != \'\' '
                                    . 'THEN ' . $this->dbtable . '.skype '
                                    . 'ELSE ' . $this->dbtable . '.skype2 '
                                    . 'END ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND (TRIM(' . $this->dbtable . '.skype) != \'\' OR TRIM(' . $this->dbtable . '.skype2) != \'\') ';
                        break;
                    case SORT_ORDERS_MODE_BY_IP:
                        $order = $this->dbtable . '.ip ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . $this->dbtable . '.ip) != \'\' ';
                        break;
                    case SORT_ORDERS_MODE_BY_PAYMENT_DATE:
                        $order = $this->dbtable . '.payment_date ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y\') != \'0000\' ';
                        break;
                    case SORT_ORDERS_MODE_BY_PAYMENT_NAME:
                        $order = 'payment_method ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND TRIM(payment_methods.name) != \'\' ';
                        break;
                    case SORT_ORDERS_MODE_BY_DELIVERY_NAME:
                        $order = 'delivery_method ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $where .= 'AND TRIM(delivery_methods.name) != \'\' ';
                        break;
                    case SORT_ORDERS_MODE_BY_SUM:
                        $order = 'total_amount ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $having .= 'AND SUM(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) + ' . $this->dbtable . '.delivery_price - ' . $this->dbtable . '.discount_sum > 0 ';
                        break;
                    case SORT_ORDERS_MODE_BY_QUANTITY:
                        $order = 'total_quantity ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $having .= 'AND SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) > 1 ';
                        break;
                    case SORT_ORDERS_MODE_BY_ROWCOUNT:
                        $order = 'total_rows ' . $direction . ', '
                               . $this->dbtable . '.date DESC ';
                        if ($laconical) $having .= 'AND COUNT(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ') > 1 ';
                        break;
                    case SORT_ORDERS_MODE_BY_DATE:
                    case SORT_ORDERS_MODE_AS_IS:
                    default:
                        $order = $this->dbtable . '.date ' . $direction . ' ';
                }
                $order = 'ORDER BY ' . $order;
            }



            // фильтруем по искомому тексту
            if (isset($params->search) && ($params->search != '')) {

                // анализируем искомый текст в 2 прохода (1 проход - префиксные команды, 2 проход - отдельные слова)
                for ($pass = 1; $pass <= 2; $pass++ ) {
                    if ($pass == 1) {
                        $keywords = array(trim($params->search));
                    } else {
                        // в искомом тексте обрабатываем лишь 4 первых слова
                        $keywords = preg_split('/\s+/', trim($params->search), 4);
                    }

                    $found = FALSE;
                    foreach ($keywords as $keyword) {

                        // если слово более 2 букв
                        if (strlen($keyword) > 2) {

                            // просто слова обрабатываем не на 1 проходе
                            if ($pass != 1) {
                                $keyword = $this->cms->db->query_value($keyword);
                                $where .= 'AND (' . $this->dbtable . '.' . $this->id_field . ' = \'' . $keyword . '\' '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.name, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $keyword . '\', \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.name, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                . 'LIKE \'%' . $keyword . '%\' '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.address, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $keyword . '\', \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.address, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                . 'LIKE \'%' . $keyword . '%\' '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.address2, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $keyword . '\', \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.address2, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                . 'LIKE \'%' . $keyword . '%\' '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.phone, \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $keyword . '\', \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                             . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.phone2, \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $keyword . '\', \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                             . 'OR LCASE(' . $this->dbtable . '.email) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(' . $this->dbtable . '.email2) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(' . $this->dbtable . '.icq) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(' . $this->dbtable . '.icq2) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(' . $this->dbtable . '.skype) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(' . $this->dbtable . '.skype2) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(' . $this->dbtable . '.code) = LCASE(\'' . $keyword . '\') '
                                             . 'OR LCASE(TRIM(LEFT(' . $this->dbtable . '.ip, ' . (strlen($keyword) + 1) . '))) = LCASE(\'' . $keyword . '\') '
                                             . 'OR ' . $this->dbtable . '.comment LIKE \'%' . $keyword . '%\') ';
                                $found = TRUE;
                                continue;
                            }

                            // если есть префиксная команда поиска по имени
                            $command = strtolower(SEARCH_ORDERS_COMMAND_NAME);
                            $size = strlen($command);
                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                $keyword = trim(substr($keyword, $size));
                                if ($keyword != '') $where .= 'AND LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.name, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $this->cms->db->query_value($keyword) . '\', \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) ';
                                $found = TRUE;
                            } else {

                                // если есть префиксная команда поиска по адресу
                                $command = strtolower(SEARCH_ORDERS_COMMAND_ADDRESS);
                                $size = strlen($command);
                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                    $keyword = trim(substr($keyword, $size));
                                    if ($keyword != '') $where .= 'AND (LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.address, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                                     . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $this->cms->db->query_value($keyword) . '\', \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                                     . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.address2, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\')) '
                                                                         . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $this->cms->db->query_value($keyword) . '\', \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\'), \' \', \'\'), \',\', \'\'), \'.\', \'\'), \'-\', \'\'), \'+\', \'\'), \'_\', \'\'), \'(\', \'\'), \')\', \'\'))) ';
                                    $found = TRUE;
                                } else {

                                    // если есть префиксная команда поиска по телефону
                                    $command = strtolower(SEARCH_ORDERS_COMMAND_PHONE);
                                    $size = strlen($command);
                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                        $keyword = trim(substr($keyword, $size));
                                        if ($keyword != '') $where .= 'AND (LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.phone, \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                                                         . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $this->cms->db->query_value($keyword) . '\', \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                                                         . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(' . $this->dbtable . '.phone2, \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\')) '
                                                                            . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(\'' . $this->cms->db->query_value($keyword) . '\', \'-\' , \'\'), \'+\', \'\'), \'(\', \'\'), \')\', \'\'), \' \', \'\'))) ';
                                        $found = TRUE;
                                    } else {

                                        // если есть префиксная команда поиска по емейлу
                                        $command = strtolower(SEARCH_ORDERS_COMMAND_EMAIL);
                                        $size = strlen($command);
                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                            $keyword = trim(substr($keyword, $size));
                                            if ($keyword != '') $where .= 'AND (LCASE(' . $this->dbtable . '.email) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\') OR LCASE(' . $this->dbtable . '.email2) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\')) ';
                                            $found = TRUE;
                                        } else {

                                            // если есть префиксная команда поиска по ICQ
                                            $command = strtolower(SEARCH_ORDERS_COMMAND_ICQ);
                                            $size = strlen($command);
                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                $keyword = trim(substr($keyword, $size));
                                                if ($keyword != '') $where .= 'AND (LCASE(' . $this->dbtable . '.icq) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\') OR LCASE(' . $this->dbtable . '.icq2) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\')) ';
                                                $found = TRUE;
                                            } else {

                                                // если есть префиксная команда поиска по скайпу
                                                $command = strtolower(SEARCH_ORDERS_COMMAND_SKYPE);
                                                $size = strlen($command);
                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                    $keyword = trim(substr($keyword, $size));
                                                    if ($keyword != '') $where .= 'AND (LCASE(' . $this->dbtable . '.skype) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\') OR LCASE(' . $this->dbtable . '.skype2) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\')) ';
                                                    $found = TRUE;
                                                } else {

                                                    // если есть префиксная команда поиска по IP-адресу
                                                    $command = strtolower(SEARCH_ORDERS_COMMAND_IP);
                                                    $size = strlen($command);
                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                        $keyword = trim(substr($keyword, $size));
                                                        if ($keyword != '') {
                                                          $keyword = $this->cms->db->query_value($keyword);
                                                          $where .= 'AND LCASE(TRIM(LEFT(' . $this->dbtable . '.ip, ' . (strlen($keyword) + 1) . '))) = LCASE(\'' . $keyword . '\') ';
                                                        }
                                                        $found = TRUE;
                                                    } else {

                                                        // если есть префиксная команда поиска по дате заказа
                                                        $command = strtolower(SEARCH_ORDERS_COMMAND_DATE);
                                                        $size = strlen($command);
                                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                                            $keyword = trim(substr($keyword, $size));
                                                            if ($keyword != '') $where .= 'AND DATE_FORMAT(' . $this->dbtable . '.date, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                            $found = TRUE;
                                                        } else {

                                                            // если есть префиксная команда поиска по дате платежа
                                                            $command = strtolower(SEARCH_ORDERS_COMMAND_PAYMENT_DATE);
                                                            $size = strlen($command);
                                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                $keyword = trim(substr($keyword, $size));
                                                                if ($keyword != '') $where .= 'AND DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                                $found = TRUE;
                                                            } else {

                                                                // если есть префиксная команда поиска по желаемой дате доставки
                                                                $command = strtolower(SEARCH_ORDERS_COMMAND_TODATE);
                                                                $size = strlen($command);
                                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                    $keyword = trim(substr($keyword, $size));
                                                                    if ($keyword != '') $where .= 'AND LCASE(' . $this->dbtable . '.to_date) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\') ';
                                                                    $found = TRUE;
                                                                } else {

                                                                    // если есть префиксная команда поиска по желаемому времени доставки
                                                                    $command = strtolower(SEARCH_ORDERS_COMMAND_TOTIME);
                                                                    $size = strlen($command);
                                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                        $keyword = trim(substr($keyword, $size));
                                                                        if ($keyword != '') $where .= 'AND LCASE(' . $this->dbtable . '.to_time) = LCASE(\'' . $this->cms->db->query_value($keyword) . '\') ';
                                                                        $found = TRUE;
                                                                    } else {

                                                                        // если есть префиксная команда поиска по идентификатору товара
                                                                        $command = strtolower(SEARCH_ORDERS_COMMAND_PRODUCT_ID);
                                                                        $size = strlen($command);
                                                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                            $keyword = trim(substr($keyword, $size));
                                                                            if ($keyword != '') $where .= 'AND ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.product_id = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                                            $found = TRUE;
                                                                        } else {

                                                                            // если есть префиксная команда поиска по идентификатору способа доставки
                                                                            $command = strtolower(SEARCH_ORDERS_COMMAND_DELIVERY_ID);
                                                                            $size = strlen($command);
                                                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                                $keyword = trim(substr($keyword, $size));
                                                                                if ($keyword != '') $where .= 'AND ' . $this->dbtable . '.delivery_method_id = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                                                $found = TRUE;
                                                                            } else {

                                                                                // если есть префиксная команда поиска по идентификатору способа доставки
                                                                                $command = strtolower(SEARCH_ORDERS_COMMAND_PAYMENT_ID);
                                                                                $size = strlen($command);
                                                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                                    $keyword = trim(substr($keyword, $size));
                                                                                    if ($keyword != '') $where .= 'AND ' . $this->dbtable . '.payment_method_id = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                                                    $found = TRUE;
                                                                                } else {

                                                                                    // если есть префиксная команда поиска по идентификатору пользователя
                                                                                    $command = strtolower(SEARCH_ORDERS_COMMAND_USER_ID);
                                                                                    $size = strlen($command);
                                                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                                        $keyword = trim(substr($keyword, $size));
                                                                                        if ($keyword != '') $where .= 'AND ' . $this->dbtable . '.user_id = \'' . $this->cms->db->query_value($keyword) . '\' ';
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
                                    }
                                }
                            }
                        }
                    }

                    // если на каком-то из проходов найдено поисковое условие, прекращаем обработку
                    if ($found) break;
                }
            }



            // фильтруем по искомой дате
            if (isset($params->search_date_from)) $where .= 'AND ' . $this->dbtable . '.date >= \'' . $this->cms->db->query_value($params->search_date_from) . ' 00:00:00\' ';
            if (isset($params->search_date_to)) $where .= 'AND ' . $this->dbtable . '.date <= \'' . $this->cms->db->query_value($params->search_date_to) . ' 23:59:59\' ';
            if (isset($params->search_paydate_from)) $where .= 'AND ' . $this->dbtable . '.payment_date >= \'' . $this->cms->db->query_value($params->search_paydate_from) . ' 00:00:00\' ';
            if (isset($params->search_paydate_to)) $where .= 'AND ' . $this->dbtable . '.payment_date <= \'' . $this->cms->db->query_value($params->search_paydate_to) . ' 23:59:59\' ';



            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' IN (' . $this->cms->db->query_value($params->ids) . ') ';
            if (isset($params->user_id)) $where .= 'AND ' . $this->dbtable . '.user_id = \'' . $this->cms->db->query_value($params->user_id) . '\' ';
            if (isset($params->delivery_id)) $where .= 'AND ' . $this->dbtable . '.delivery_method_id = \'' . $this->cms->db->query_value($params->delivery_id) . '\' ';
            if (isset($params->payment_id)) $where .= 'AND ' . $this->dbtable . '.payment_method_id = \'' . $this->cms->db->query_value($params->payment_id) . '\' ';
            if (isset($params->payment_status)) {
                if ($params->payment_status == 1) {
                    $where .= 'AND (' . $this->dbtable . '.payment_status = 1 OR DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d\') != \'0000-00-00\') ';
                } else {
                    $where .= 'AND ' . $this->dbtable . '.payment_status = \'' . $this->cms->db->query_value($params->payment_status) . '\' ';
                }
            }
            if (isset($params->creditable)) $where .= 'AND ' . $this->dbtable . '.credit_id != 0 AND TRIM(' . $this->dbtable . '.credit_details) != \'\' ';
            if (isset($params->status)) $where .= 'AND ' . $this->dbtable . '.status = \'' . $this->cms->db->query_value($params->status) . '\' ';
            if (isset($params->hidden)) $where .= 'AND ' . $this->dbtable . '.hidden = \'' . $this->cms->db->query_value($params->hidden) . '\' ';
            if (isset($params->affiliate_id)) $where .= 'AND ' . $this->dbtable . '.affiliate_id = \'' . $this->cms->db->query_value($params->affiliate_id) . '\' ';
            if ($where != '') $where = 'WHERE 1 ' . $where;
            if ($having != '') $having = 'HAVING 1 ' . $having;



            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);



            // делаем запрос для подсчета итоговых сумм и сохранения в переменных MySQL
            $query = 'SELECT @totals_total_amount := SUM(temp.total_amount) AS a1, '
                          . '@totals_amount := SUM(temp.amount) AS a2, '
                          . '@totals_discount_sum := SUM(temp.discount_sum) AS a3, '
                          . '@totals_delivery_price := SUM(temp.delivery_price) AS a4 '
                   . 'FROM (SELECT SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) + ' . $this->dbtable . '.delivery_price - ' . $this->dbtable . '.discount_sum AS total_amount, '
                                . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) - ' . $this->dbtable . '.discount_sum AS amount, '
                                 . $this->dbtable . '.discount_sum, '
                                 . $this->dbtable . '.delivery_price '
                         . 'FROM ' . $this->dbtable . ' '
                         . 'LEFT JOIN delivery_methods '
                                   . 'ON delivery_methods.delivery_method_id = ' . $this->dbtable . '.delivery_method_id '
                         . 'LEFT JOIN payment_methods '
                                   . 'ON payment_methods.payment_method_id = ' . $this->dbtable . '.payment_method_id '
                         . 'LEFT JOIN payment_methods AS desire_payment '
                                   . 'ON desire_payment.payment_method_id = ' . $this->dbtable . '.desire_payment_id '
                         . 'LEFT JOIN ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . ' '
                                   . 'ON ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ' = ' . $this->dbtable . '.' . $this->id_field . ' '
                         . 'LEFT JOIN ' . DATABASE_USERS_TABLENAME . ' '
                                   . 'ON ' . DATABASE_USERS_TABLENAME . '.user_id = ' . $this->dbtable . '.affiliate_id '
                         . $where
                         . 'GROUP BY ' . $this->dbtable . '.' . $this->id_field . ' '
                         . $having . ') as temp;';
            $this->cms->db->query($query);



            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS ' . $this->dbtable . '.*, '
                                              . 'DATE_FORMAT(' . $this->dbtable . '.date, \'%Y-%m-%d %H:%i:%s\') AS date, '
                                              . 'DATE_FORMAT(' . $this->dbtable . '.date, \'%Y-%m-%d\') AS date_date, '
                                              . 'DATE_FORMAT(' . $this->dbtable . '.date, \'%H:%i:%s\') AS date_time, '
                                              . 'DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d %H:%i:%s\') AS payment_date, '
                                              . 'DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d\') AS payment_date_date, '
                                              . 'DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%H:%i:%s\') AS payment_date_time, '
                                              . DATABASE_ORDERS_PHASES_TABLENAME . '.name AS orders_phase, '
                                              . 'delivery_methods.name AS delivery_method, '
                                              . 'delivery_methods.tracking_url AS delivery_tracking_url, '
                                              . 'payment_methods.name AS payment_method, '
                                              . 'desire_payment.name AS desire_payment, '
                                              . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.name AS credit_name, '
                                              . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.term AS credit_term, '
                                              . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.percent AS credit_percent, '
                                              . DATABASE_USERS_TABLENAME . '.name AS affiliate_name, '
                                              . '100 * ' . $this->dbtable . '.discount_sum / (SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) + ' . $this->dbtable . '.delivery_price + 0.0000001) AS discount, '
                                              . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) - ' . $this->dbtable . '.discount_sum AS amount, '
                                              . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) + ' . $this->dbtable . '.delivery_price - ' . $this->dbtable . '.discount_sum AS total_amount, '
                                              . '@totals_total_amount AS totals_total_amount, '
                                              . '@totals_amount AS totals_amount, '
                                              . '@totals_discount_sum AS totals_discount_sum, '
                                              . '@totals_delivery_price AS totals_delivery_price, '
                                              . $this->dbtable . '.discount_sum - SUM(ABS(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) - ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.price)) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) AS discount_sum, '
                                              . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) AS total_quantity, '
                                              . 'COUNT(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ') AS total_rows '
                   . 'FROM ' . $this->dbtable . ' '
                   . 'LEFT JOIN ' . DATABASE_ORDERS_PHASES_TABLENAME . ' '
                             . 'ON ' . DATABASE_ORDERS_PHASES_TABLENAME . '.phase_id = ' . $this->dbtable . '.state '
                                 . 'AND ' . DATABASE_ORDERS_PHASES_TABLENAME . '.deleted = 0 '
                   . 'LEFT JOIN delivery_methods '
                             . 'ON delivery_methods.delivery_method_id = ' . $this->dbtable . '.delivery_method_id '
                   . 'LEFT JOIN payment_methods '
                             . 'ON payment_methods.payment_method_id = ' . $this->dbtable . '.payment_method_id '
                   . 'LEFT JOIN payment_methods AS desire_payment '
                             . 'ON desire_payment.payment_method_id = ' . $this->dbtable . '.desire_payment_id '
                   . 'LEFT JOIN ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . ' '
                             . 'ON ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ' = ' . $this->dbtable . '.' . $this->id_field . ' '
                   . 'LEFT JOIN ' . DATABASE_CREDIT_PROGRAMS_TABLENAME . ' '
                             . 'ON ' . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.credit_id = ' . $this->dbtable . '.credit_id '
                   . 'LEFT JOIN ' . DATABASE_USERS_TABLENAME . ' '
                             . 'ON ' . DATABASE_USERS_TABLENAME . '.user_id = ' . $this->dbtable . '.affiliate_id '
                   . $where
                   . 'GROUP BY ' . $this->dbtable . '.' . $this->id_field . ' '
                   . $having
                   . $order
                   . $limit . ';';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();



            // берем полное количество подобных записей
            $result2 = $this->cms->db->query('SELECT FOUND_ROWS() AS count;');
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



        // =======================================================================
        // Взять из базы данных запись о заказе, указанном в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->delivery_id] = идентификатор способа доставки
        //   [$params->payment_id] = идентификатор способа оплаты
        //   [$params->payment_status] = состояние оплаты
        //   [$params->hidden] = признак "скрыт от чужих"
        //   [$params->affiliate_id] = идентификатор реферала
        //   [$params->code] = код (адрес страницы) заказа
        // =======================================================================

        public function one ( & $item, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' one');



            $item = null;
            $where = '';



            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' = \'' . $this->cms->db->query_value($params->id) . '\' ';
            if (isset($params->code)) $where .= 'AND ' . $this->dbtable . '.code = \'' . $this->cms->db->query_value($params->code) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->user_id)) $where .= 'AND ' . $this->dbtable . '.user_id = \'' . $this->cms->db->query_value($params->user_id) . '\' ';
                if (isset($params->delivery_id)) $where .= 'AND ' . $this->dbtable . '.delivery_method_id = \'' . $this->cms->db->query_value($params->delivery_id) . '\' ';
                if (isset($params->payment_id)) $where .= 'AND ' . $this->dbtable . '.payment_method_id = \'' . $this->cms->db->query_value($params->payment_id) . '\' ';
                if (isset($params->payment_status)) {
                    if ($params->payment_status == 1) {
                        $where .= 'AND (' . $this->dbtable . '.payment_status = 1 OR DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d\') != \'0000-00-00\') ';
                    } else {
                        $where .= 'AND ' . $this->dbtable . '.payment_status = \'' . $this->cms->db->query_value($params->payment_status) . '\' ';
                    }
                }
                if (isset($params->hidden)) $where .= 'AND ' . $this->dbtable . '.hidden = \'' . $this->cms->db->query_value($params->hidden) . '\' ';
                if (isset($params->affiliate_id)) $where .= 'AND ' . $this->dbtable . '.affiliate_id = \'' . $this->cms->db->query_value($params->affiliate_id) . '\' ';
                $where = 'WHERE 1 ' . $where;



                // делаем запрос
                $query = 'SELECT ' . $this->dbtable . '.*, '
                              . 'DATE_FORMAT(' . $this->dbtable . '.date, \'%Y-%m-%d %H:%i:%s\') AS date, '
                              . 'DATE_FORMAT(' . $this->dbtable . '.date, \'%Y-%m-%d\') AS date_date, '
                              . 'DATE_FORMAT(' . $this->dbtable . '.date, \'%H:%i:%s\') AS date_time, '
                              . 'DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d %H:%i:%s\') AS payment_date, '
                              . 'DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%Y-%m-%d\') AS payment_date_date, '
                              . 'DATE_FORMAT(' . $this->dbtable . '.payment_date, \'%H:%i:%s\') AS payment_date_time, '
                              . DATABASE_ORDERS_PHASES_TABLENAME . '.name AS orders_phase, '
                              . 'delivery_methods.name AS delivery_method, '
                              . 'delivery_methods.tracking_url AS delivery_tracking_url, '
                              . 'payment_methods.name AS payment_method, '
                              . 'desire_payment.name AS desire_payment, '
                              . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.name AS credit_name, '
                              . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.term AS credit_term, '
                              . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.percent AS credit_percent, '
                              . DATABASE_USERS_TABLENAME . '.name AS affiliate_name, '
                              . '100 * ' . $this->dbtable . '.discount_sum / (SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) + ' . $this->dbtable . '.delivery_price + 0.0000001) AS discount, '
                              . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) - ' . $this->dbtable . '.discount_sum AS amount, '
                              . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) + ' . $this->dbtable . '.delivery_price - ' . $this->dbtable . '.discount_sum AS total_amount, '
                              . $this->dbtable . '.discount_sum - SUM(ABS(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) - ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.price)) * ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) AS discount_sum, '
                              . 'SUM(ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.quantity)) AS total_quantity, '
                              . 'COUNT(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ') AS total_rows '
                     . 'FROM ' . $this->dbtable . ' '
                     . 'LEFT JOIN ' . DATABASE_ORDERS_PHASES_TABLENAME . ' '
                               . 'ON ' . DATABASE_ORDERS_PHASES_TABLENAME . '.phase_id = ' . $this->dbtable . '.state '
                                   . 'AND ' . DATABASE_ORDERS_PHASES_TABLENAME . '.deleted = 0 '
                     . 'LEFT JOIN delivery_methods '
                               . 'ON delivery_methods.delivery_method_id = ' . $this->dbtable . '.delivery_method_id '
                     . 'LEFT JOIN payment_methods '
                               . 'ON payment_methods.payment_method_id = ' . $this->dbtable . '.payment_method_id '
                     . 'LEFT JOIN payment_methods AS desire_payment '
                               . 'ON desire_payment.payment_method_id = ' . $this->dbtable . '.desire_payment_id '
                     . 'LEFT JOIN ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . ' '
                               . 'ON ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ' = ' . $this->dbtable . '.' . $this->id_field . ' '
                     . 'LEFT JOIN ' . DATABASE_CREDIT_PROGRAMS_TABLENAME . ' '
                               . 'ON ' . DATABASE_CREDIT_PROGRAMS_TABLENAME . '.credit_id = ' . $this->dbtable . '.credit_id '
                     . 'LEFT JOIN ' . DATABASE_USERS_TABLENAME . ' '
                               . 'ON ' . DATABASE_USERS_TABLENAME . '.user_id = ' . $this->dbtable . '.affiliate_id '
                     . $where
                     . 'GROUP BY ' . $this->dbtable . '.' . $this->id_field . ' '
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



        // =======================================================================
        // Добавить в записи о заказах оперативные ссылки админпанели:
        //   $items = массив записей
        //   $params->token = аутентификатор операции
        //   [$params->sort] = способ сортировки записей
        // =======================================================================

        public function operable ( & $items, $params ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' operable');



            if (!empty($items) && isset($params->token)) {
                $id = $this->id_field;
                foreach ($items as & $item) {
                    if (isset($item->$id)) {

                        // собираем параметры
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'Orders',
                                         REQUEST_PARAM_NAME_ITEMID => $item->$id,
                                         REQUEST_PARAM_NAME_TOKEN => $params->token);
                        if (isset($params->sort)) $options[REQUEST_PARAM_NAME_SORT] = $params->sort;



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "поступивший"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COMING;
                        $item->coming_get = $this->cms->form_get($options);



                        // создаем ссылку "в обработке"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_PROCESSING;
                        $item->processing_get = $this->cms->form_get($options);



                        // создаем ссылку "выполнено"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DONE;
                        $item->done_get = $this->cms->form_get($options);



                        // создаем ссылку "отменено"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_CANCELED;
                        $item->canceled_get = $this->cms->form_get($options);



                        // создаем ссылку "оплачено"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_PAYMENT;
                        $item->payment_get = $this->cms->form_get($options);



                        // создаем ссылку "создать копию"
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Order';
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COPY;
                        $item->copy_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Order';
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
                $fields = array(); $values = array();
                if (isset($item->user_id))            {$fields[] = 'user_id';            $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->user_id)) . '\'';}
                if (isset($item->delivery_method_id)) {$fields[] = 'delivery_method_id'; $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->delivery_method_id)) . '\'';}
                if (isset($item->delivery_price))     {$fields[] = 'delivery_price';     $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_float($item->delivery_price)) . '\'';}
                if (isset($item->delivery_type))      {$fields[] = 'delivery_type';      $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->delivery_type)) . '\'';}
                if (isset($item->delivery_tracking))  {$fields[] = 'delivery_tracking';  $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->delivery_tracking)) . '\'';}
                if (isset($item->discount_sum))       {$fields[] = 'discount_sum';       $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_float($item->discount_sum)) . '\'';}
                if (isset($item->desire_payment_id))  {$fields[] = 'desire_payment_id';  $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->desire_payment_id)) . '\'';}
                if (isset($item->payment_method_id))  {$fields[] = 'payment_method_id';  $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->payment_method_id)) . '\'';}
                if (isset($item->payment_status))     {$fields[] = 'payment_status';     $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->payment_status)) . '\'';}
                if (isset($item->payment_date))       {$fields[] = 'payment_date';       $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_date($item->payment_date)) . '\'';}
                if (isset($item->payment_details))    {$fields[] = 'payment_details';    $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->payment_details)) . '\'';}
                if (isset($item->credit_id))          {$fields[] = 'credit_id';          $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->credit_id)) . '\'';}
                if (isset($item->credit_details))     {$fields[] = 'credit_details';     $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($this->packedArray($item, 'credit_details'))) . '\'';}
                if (isset($item->written_off))        {$fields[] = 'written_off';        $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->written_off)) . '\'';}
                if (isset($item->hidden))             {$fields[] = 'hidden';             $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_boolean($item->hidden)) . '\'';}
                if (isset($item->status))             {$fields[] = 'status';             $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->status)) . '\'';}
                if (isset($item->state))              {$fields[] = 'state';              $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->state)) . '\'';}
                if (isset($item->comment_status))     {$fields[] = 'comment_status';     $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->comment_status)) . '\'';}
                if (isset($item->date))               {$fields[] = 'date';               $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_date($item->date)) . '\'';}
                if (isset($item->affiliate_id))       {$fields[] = 'affiliate_id';       $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->affiliate_id)) . '\'';}
                if (isset($item->coupon_id))          {$fields[] = 'coupon_id';          $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->coupon_id)) . '\'';}
                if (isset($item->code))               {$fields[] = 'code';               $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->code)) . '\'';}
                if (isset($item->name))               {$fields[] = 'name';               $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($this->packedUserName($item))) . '\'';}
                if (isset($item->country_id))         {$fields[] = 'country_id';         $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->country_id)) . '\'';}
                if (isset($item->region_id))          {$fields[] = 'region_id';          $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->region_id)) . '\'';}
                if (isset($item->town_id))            {$fields[] = 'town_id';            $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->town_id)) . '\'';}
                if (isset($item->address))            {$fields[] = 'address';            $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($this->packedUserAddress($item))) . '\'';}
                if (isset($item->address2))           {$fields[] = 'address2';           $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($this->packedUserAddress2($item))) . '\'';}
                if (isset($item->phone))              {$fields[] = 'phone';              $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->phone)) . '\'';}
                if (isset($item->phone2))             {$fields[] = 'phone2';             $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->phone2)) . '\'';}
                if (isset($item->email))              {$fields[] = 'email';              $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->email)) . '\'';}
                if (isset($item->email2))             {$fields[] = 'email2';             $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->email2)) . '\'';}
                if (isset($item->icq))                {$fields[] = 'icq';                $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->icq)) . '\'';}
                if (isset($item->icq2))               {$fields[] = 'icq2';               $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->icq2)) . '\'';}
                if (isset($item->skype))              {$fields[] = 'skype';              $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->skype)) . '\'';}
                if (isset($item->skype2))             {$fields[] = 'skype2';             $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->skype2)) . '\'';}
                if (isset($item->comment))            {$fields[] = 'comment';            $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->comment)) . '\'';}
                if (isset($item->to_date))            {$fields[] = 'to_date';            $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->to_date)) . '\'';}
                if (isset($item->to_time))            {$fields[] = 'to_time';            $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->to_time)) . '\'';}
                if (isset($item->ip))                 {$fields[] = 'ip';                 $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($this->packedIp($item))) . '\'';}



                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, $this->dbtable, $this->id_field, $fields, $values);



                // если запись обновлена
                if (!empty($id)) {

                    // если существуют элементы заказа
                    if (isset($item->products)) {
                        $id_filter = array();
                        // добавляем/обновляем записи элементов
                        $id_field = $this->id_field;
                        foreach ($item->products as &$row) {
                            if (!isset($row->$id_field) || empty($row->$id_field)) $row->$id_field = $id;
                            $row->orderitem_id = $this->update_product($row);
                            if (!empty($row->orderitem_id)) $id_filter[$row->orderitem_id] = $row->orderitem_id;
                        }
                        // удаляем записи неиспользующихся более элементов
                        $id_filter = implode(',', $id_filter);
                        $query = 'DELETE FROM ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . ' '
                               . 'WHERE '
                                     . (!empty($id_filter) ? 'orderitem_id NOT IN (' . $id_filter . ') AND ' : '')
                                     . $this->id_field . ' = \'' . $this->cms->db->query_value($id) . '\';';
                        $this->cms->db->query($query);
                    }
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
        *                               [$params->discount] = величина скидки клиента
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {

            // преобразовываем поле имени в набор полей (приказываем создать поля search_name для поисковых целей)
            $this->unpackUserName($item, TRUE);

            // преобразовываем поле адреса в набор полей (приказываем создать поля search_address для поисковых целей)
            $this->unpackUserAddress($item, '', TRUE);
            $this->unpackUserAddress($item, '2', TRUE);

            // читаем в запись товары комплекта
            $id = $this->id_field;
            if (isset($item->$id)) {
                $item->$id = intval($item->$id);
                $discount = $this->cms->db->fix_discount(isset($params->discount) ? $params->discount : 0);
                $price_id = isset($this->cms->user->price_id) ? $this->cms->user->price_id : 0;
                $query = 'SELECT ' . DATABASE_PRODUCTS_TABLENAME . '.*, '
                                   . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.*, '
                              . 'CASE WHEN ' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.temp_price != 0 '
                                   . 'THEN ABS(' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.temp_price) '
                                   . 'ELSE ABS(' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.price) * ABS(100 - CASE WHEN (' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.priority_discount >= 0 AND ' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.priority_discount <= 100) '
                                                                                                                 . 'THEN ' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.priority_discount '
                                                                                                                 . 'ELSE ' . $this->cms->db->query_value($discount) . ' '
                                                                                                                 . 'END) / 100 '
                                   . 'END AS discount_price, '
                              . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.name AS variant_name, '
                              . DATABASE_CATEGORIES_TABLENAME . '.single_name AS category, '
                              . DATABASE_BRANDS_TABLENAME . '.name AS brand, '
                              . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.*, '
                              . 'ABS(100 - 100 * CASE WHEN ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price != 0 '
                                                   . 'THEN ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.price) / ABS(' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.real_price) '
                                                   . 'ELSE 1 '
                                                   . 'END) AS discount '
                       . 'FROM ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . ' '
                       . 'LEFT JOIN ' . DATABASE_PRODUCTS_TABLENAME . ' '
                                 . 'ON ' . DATABASE_PRODUCTS_TABLENAME . '.product_id = ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.product_id '
                       . 'LEFT JOIN ' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . ' '
                                 . 'ON ' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.product_id = ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.product_id '
                                    . 'AND ' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '.variant_id = ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.variant_id '
                       . 'LEFT JOIN ' . DATABASE_CATEGORIES_TABLENAME . ' '
                                 . 'ON ' . DATABASE_CATEGORIES_TABLENAME . '.category_id = ' . DATABASE_PRODUCTS_TABLENAME . '.category_id '
                       . 'LEFT JOIN ' . DATABASE_BRANDS_TABLENAME . ' '
                                 . 'ON ' . DATABASE_BRANDS_TABLENAME . '.brand_id = ' . DATABASE_PRODUCTS_TABLENAME . '.brand_id '
                       . 'WHERE ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.' . $this->id_field . ' = \'' . $this->cms->db->query_value($item->$id) . '\' '
                       . 'ORDER BY ' . DATABASE_ORDERS_PRODUCTS_TABLENAME . '.position ASC;';
                $result = $this->cms->db->query($query);
                $item->products = $this->cms->db->results();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // поправляем поля записей о товарах
                $params = new stdClass;
                $params->price_id = $price_id;
                $params->discount = $discount;
                $this->cms->db->products->unpackRecords($item->products, $params);
            }

            // поправляем итоги
            if (isset($item->discount_sum)) {
                if ($item->discount_sum < 0) $item->discount_sum = 0;
            }
            if (isset($item->amount)) {
                if ($item->amount < 0) $item->amount = 0;
            }
            if (isset($item->total_amount)) {
                if ($item->total_amount < 0) $item->total_amount = 0;
            }

            // поправляем поле ip-адреса (разделяем на поля ip и host)
            $this->unpackIp($item);

            // поправляем поле имени партнера
            if (isset($item->affiliate_name) && !empty($item->affiliate_name)) {
                $user = null;
                $user->name = $item->affiliate_name;
                $this->unpackUserName($user);
                $item->affiliate_name = $user->compound_name;
            }

            // поправляем поля сведений о кредите
            if (isset($item->credit_id)) $item->credit_id = intval($item->credit_id);
            if (isset($item->credit_details) && is_string($item->credit_details)) {
                if (trim($item->credit_details) == '') {
                    $item->credit_details = array();
                } else {
                    $item->credit_details = @unserialize($item->credit_details);
                    if (!is_array($item->credit_details)) $item->credit_details = array();
                }
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
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS ' . $this->dbtable . ' (' . $this->id_field . ' BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ') NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');



            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$this->id_field])) {
                $query[] = 'ADD ' . $this->id_field . ' BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ') NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE ' . $this->dbtable . ' SET ' . $this->id_field . ' = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (' . $this->id_field . ')';
                $query[] = 'CHANGE ' . $this->id_field . ' ' . $this->id_field . ' BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор заказа\'';
            } else {



                // ИД заказа
                $name = $this->id_field;
                $type = 'BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор заказа\'';
            }



            // ИД покупателя
            $name = 'user_id';
            $type = 'BIGINT(' . DATABASE_USERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД способа доставки
            $name = 'delivery_method_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор способа доставки\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // цена доставки
            $name = 'delivery_price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Цена доставки\'';



            // ИД типа доставки
            $name = 'delivery_type';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор типа доставки\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // код отслеживания груза
            $name = 'delivery_tracking';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_DELIVERYTRACKING . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Код отслеживания груза\'';



            // сумма скидки
            $name = 'discount_sum';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Общая сумма скидки\'';



            // ИД желаемого способа оплаты
            $name = 'desire_payment_id';
            $type = 'BIGINT(' . DATABASE_PAYMENTS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор желаемого способа оплаты\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД способа оплаты
            $name = 'payment_method_id';
            $type = 'BIGINT(' . DATABASE_PAYMENTS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор способа оплаты\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // состояние оплаты
            $name = 'payment_status';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Состояние оплаты\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // дата оплаты
            $name = 'payment_date';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата оплаты\'';



            // детали платежа
            $name = 'payment_details';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Детали платежа\'';



            // ИД кредитной программы
            $name = 'credit_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор кредитной программы\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // детали кредита
            $name = 'credit_details';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Детали кредита\'';



            // признак списания
            $name = 'written_off';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Товар списан\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // скрыт от чужих
            $name = 'hidden';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Заказ скрыт от посторонних\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // состояние заказа
            $name = 'status';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Состояние заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // стадия состояния заказа
            $name = 'state';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Стадия состояния заказа\'';



            // комментарий админа к состоянию
            $name = 'comment_status';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_COMMENT . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Комментарий администратора к состоянию заказа\'';



            // дата оплаты
            $name = 'date';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД реферала
            $name = 'affiliate_id';
            $type = 'BIGINT(' . DATABASE_USERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор реферала\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД скидочного купона
            $name = 'coupon_id';
            $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор скидочного купона\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // код для url страницы заказа
            $name = 'code';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_CODE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Код для url страницы заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // имя покупателя
            $name = 'name';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Имя покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД страны
            $name = 'country_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор страны\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД области
            $name = 'region_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор области\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // ИД города
            $name = 'town_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор города\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // адрес 1
            $name = 'address';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_ADDRESS . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Адрес доставки\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // адрес 2
            $name = 'address2';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_ADDRESS . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Адрес 2 доставки\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // телефон 1
            $name = 'phone';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_PHONE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Телефон покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // телефон 2
            $name = 'phone2';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_PHONE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Телефон 2 покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // емейл 1
            $name = 'email';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_EMAIL . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Емейл покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // емейл 2
            $name = 'email2';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_EMAIL . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Емейл 2 покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // icq 1
            $name = 'icq';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_ICQ . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'ICQ номер покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // icq 2
            $name = 'icq2';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_ICQ . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'ICQ номер 2 покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // skype 1
            $name = 'skype';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_SKYPE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Skype имя покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // skype 2
            $name = 'skype2';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_SKYPE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Skype имя 2 покупателя\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // комментарий покупателя
            $name = 'comment';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_COMMENT . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Комментарий покупателя к заказу\'';



            // желаемая дата
            $name = 'to_date';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_TODATE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Желаемая дата доставки\'';



            // желаемое время
            $name = 'to_time';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_TOTIME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Желаемое время доставки\'';



            // IP покупателя
            $name = 'ip';
            $type = 'VARCHAR(' . DATABASE_ORDERS_FIELDSIZE_IP . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'IP-адрес сделавшего заказ\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // выполняем сформированные запросы
            foreach ($query as & $command) {
                if (trim($command) != '') {
                    if (substr($command, 0, 1) == '>') {
                        $command = trim(substr($command, 1));
                        if ($command != '') $command .= ';';
                    } else {
                        $command = 'ALTER TABLE ' . $this->dbtable . ' ' . $command . ';';
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
        // Обновить/добавить запись о товаре заказа в базе данных:
        //   $item = запись (обычно содержащая только изменившиеся поля),
        //           лишние (не относящиеся к таблице) поля в записи игнорируются,
        //           запись добавляется, если не имеет поля идентификатора записи
        // =======================================================================

        public function update_product ( & $item ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' update_product');



            $id = '';
            if (!empty($item)) {

                // готовим изменившиеся поля
                $fields = array(); $values = array();
                if (isset($item->order_id))        {$fields[] = $this->id_field;        $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->order_id)) . '\'';}
                if (isset($item->product_id))      {$fields[] = 'product_id';      $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->product_id)) . '\'';}
                if (isset($item->variant_id))      {$fields[] = 'variant_id';      $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->variant_id)) . '\'';}
                if (isset($item->product_name))    {$fields[] = 'product_name';    $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->product_name)) . '\'';}
                if (isset($item->variant_name))    {$fields[] = 'variant_name';    $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->variant_name)) . '\'';}
                if (isset($item->name_properties)) {$fields[] = 'name_properties'; $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_string($item->name_properties)) . '\'';}
                if (isset($item->price_id))        {$fields[] = 'price_id';        $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->price_id)) . '\'';}
                if (isset($item->price))           {$fields[] = 'price';           $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_float($item->price)) . '\'';}
                if (isset($item->real_price))      {$fields[] = 'real_price';      $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_float($item->real_price)) . '\'';}
                if (isset($item->quantity))        {$fields[] = 'quantity';        $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->quantity)) . '\'';}
                if (isset($item->position))        {$fields[] = 'position';        $values[] = '\'' . $this->cms->db->query_value($this->cms->db->value_as_integer($item->position)) . '\'';}



                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, DATABASE_ORDERS_PRODUCTS_TABLENAME, 'orderitem_id', $fields, $values);
            }



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем идентификатор обновленной / добавленной записи
            return $id;
        }



        // =======================================================================
        // Проверить и поправить (если нет, создать) таблицу товаров заказов в базе данных.
        // =======================================================================

        public function check_products () {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' check_products');

            // проверяем наличие таблицы, при отсутствии создаем
            $dbtable = DATABASE_ORDERS_PRODUCTS_TABLENAME;
            $dbtable_field = 'orderitem_id';
            $columns = $this->cms->db->get_dbtable_fields($dbtable);
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS ' . $dbtable . ' (' . $dbtable_field . ' BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ') NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');

            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$dbtable_field])) {
                $query[] = 'ADD ' . $dbtable_field . ' BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ') NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE ' . $dbtable . ' SET ' . $dbtable_field . ' = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (' . $dbtable_field . ')';
                $query[] = 'CHANGE ' . $dbtable_field . ' ' . $dbtable_field . ' BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор элемента заказа\'';

                // возможно это перестройка старой версии таблицы, нужно убедиться, что такой индекс не исчезнет
                $query[] = 'ADD INDEX (' . $this->id_field . ')';
            } else {

                // ИД элемента заказа
                $name = $dbtable_field;
                $type = 'BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор элемента заказа\'';
            }

            // ИД заказа
            $name = $this->id_field;
            $type = 'BIGINT(' . DATABASE_ORDERS_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД товара
            $name = 'product_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор товара\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // ИД варианта товара
            $name = 'variant_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор варианта товара\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // название товара
            $name = 'product_name';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название товара\'';

            // название варианта товара
            $name = 'variant_name';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название варианта товара\'';

            // названия свойств товара
            $name = 'name_properties';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Названия свойств товара\'';

            // ИД ценовой группы
            $name = 'price_id';
            $type = 'BIGINT(20)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор ценовой группы\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // цена со скидкой
            $name = 'price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Цена товара со скидкой\'';

            // исходная цена
            $name = 'real_price';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Исходная цена товара\'';
                $subquery[] = 'UPDATE ' . $dbtable . ' '
                            . 'SET ' . $name . ' = price '
                            . 'WHERE ' . $name . ' = 0 OR ' . $name . ' IS NULL;';
            }

            // количество
            $name = 'quantity';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Количество товара\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // положение в заказе
            $name = 'position';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Положение элемента в заказе\'';
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
    }



    return;
?>