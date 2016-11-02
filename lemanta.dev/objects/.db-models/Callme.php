<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Обратный звонок: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CallmeDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'callme';
        public $id_field = 'callme_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'name',         // имя
                'phone',        // телефон
                'email',        // емейл
                'icq',          // icq
                'skype',        // скайп

                // причина
                'reason'        => array('type' => 'VARCHAR(8192)',
                                         'params' => 'DEFAULT "" NOT NULL COMMENT "Описание причины запроса"',
                                         'index' => FALSE),

                'ip',           // ip-адрес
                'done',         // выполнено
                'created'       // создано
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'CallMe';
        protected $operables_card = 'CallMe';
        protected $operables = array('delete', 'done');



        // =======================================================================
        // Выбрать из базы данных записи о запросах связи согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->search] = искомый текст
        //   [$params->ids] = идентификаторы запросов связи (перечисленные через запятую)
        //   [$params->done] = признак "выполнена" запись
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' get');

            $items = array();
            $where = '';
            $order = '';
            $limit = '';

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_CALLME_MODE_BY_NAME:
                        $order = '`' . $dbtable . '`.`name` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`name`) != \'\' ';
                        break;
                    case SORT_CALLME_MODE_BY_PHONE:
                        $order = '`' . $dbtable . '`.`phone` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`phone`) != \'\' ';
                        break;
                    case SORT_CALLME_MODE_BY_EMAIL:
                        $order = '`' . $dbtable . '`.`email` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`email`) != \'\' ';
                        break;
                    case SORT_CALLME_MODE_BY_ICQ:
                        $order = '`' . $dbtable . '`.`icq` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`icq`) != \'\' ';
                        break;
                    case SORT_CALLME_MODE_BY_SKYPE:
                        $order = '`' . $dbtable . '`.`skype` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`skype`) != \'\' ';
                        break;
                    case SORT_CALLME_MODE_BY_IP:
                        $order = '`' . $dbtable . '`.`ip` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`ip`) != \'\' ';
                        break;
                    case SORT_CALLME_MODE_BY_CREATED:
                    case SORT_CALLME_MODE_AS_IS:
                    default:
                        $order = '`' . $dbtable . '`.`created` ' . $direction . ' ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по искомому тексту
            if (isset($params->search) && $params->search != '') {

                // в искомом тексте обрабатываем лишь 4 первых слова
                $keywords = preg_split('/[ \t\r\n\s]+/', trim($params->search), 4);
                foreach ($keywords as $keyword) {

                    // если слово более 2 букв
                    if (strlen($keyword) > 2) {

                        // если есть префиксная команда поиска по имени
                        $command = strtolower(SEARCH_CALLME_COMMAND_NAME);
                        $size = strlen($command);
                        if ($command == strtolower(substr($keyword, 0, $size))) {
                            $keyword = trim(substr($keyword, $size));
                            if ($keyword != '') $where .= 'AND `' . $dbtable . '`.`name` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                        } else {

                            // если есть префиксная команда поиска по телефону
                            $command = strtolower(SEARCH_CALLME_COMMAND_PHONE);
                            $size = strlen($command);
                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                $keyword = trim(substr($keyword, $size));
                                if ($keyword != '') $where .= 'AND `' . $dbtable . '`.`phone` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                            } else {

                                // если есть префиксная команда поиска по емейлу
                                $command = strtolower(SEARCH_CALLME_COMMAND_EMAIL);
                                $size = strlen($command);
                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                    $keyword = trim(substr($keyword, $size));
                                    if ($keyword != '') $where .= 'AND `' . $dbtable . '`.`email` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                } else {

                                    // если есть префиксная команда поиска по ICQ
                                    $command = strtolower(SEARCH_CALLME_COMMAND_ICQ);
                                    $size = strlen($command);
                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                        $keyword = trim(substr($keyword, $size));
                                        if ($keyword != '') $where .= 'AND `' . $dbtable . '`.`icq` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                    } else {

                                        // если есть префиксная команда поиска по скайпу
                                        $command = strtolower(SEARCH_CALLME_COMMAND_SKYPE);
                                        $size = strlen($command);
                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                            $keyword = trim(substr($keyword, $size));
                                            if ($keyword != '') $where .= 'AND `' . $dbtable . '`.`skype` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                        } else {

                                            // если есть префиксная команда поиска по IP-адресу
                                            $command = strtolower(SEARCH_CALLME_COMMAND_IP);
                                            $size = strlen($command);
                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                $keyword = trim(substr($keyword, $size));
                                                if ($keyword != '') {
                                                    $keyword = $this->cms->db->query_value($keyword);
                                                    $where .= 'AND TRIM(LEFT(`' . $dbtable . '`.`ip`, ' . (strlen($keyword) + 1) . ')) = \'' . $keyword . '\' ';
                                                }
                                            } else {

                                                // если есть префиксная команда поиска по дате
                                                $command = strtolower(SEARCH_CALLME_COMMAND_DATE);
                                                $size = strlen($command);
                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                    $keyword = trim(substr($keyword, $size));
                                                    if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $dbtable . '`.`created`, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                } else {
                                                    // иначе это просто слово
                                                    $keyword = $this->cms->db->query_value($keyword);
                                                    $where .= 'AND (`' . $dbtable . '`.`name` = \'' . $keyword . '\' '
                                                                 . 'OR `' . $dbtable . '`.`phone` = \'' . $keyword . '\' '
                                                                 . 'OR `' . $dbtable . '`.`email` = \'' . $keyword . '\' '
                                                                 . 'OR `' . $dbtable . '`.`icq` = \'' . $keyword . '\' '
                                                                 . 'OR `' . $dbtable . '`.`skype` = \'' . $keyword . '\' '
                                                                 . 'OR TRIM(LEFT(`' . $dbtable . '`.`ip`, ' . (strlen($keyword) + 1) . ')) = \'' . $keyword . '\' '
                                                                 . 'OR `' . $dbtable . '`.`reason` LIKE \'%' . $keyword . '%\') ';
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

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->done)) $where .= 'AND `' . $dbtable . '`.`done` = \'' . $this->cms->db->query_value($params->done) . '\' ';
            if ($where != '') $where = 'WHERE 1 ' . $where;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $dbtable . '`.* '
                   . 'FROM `' . $dbtable . '` '
                   . $where
                   . $order
                   . $limit . ';';
            $result = $this->cms->db->query($query);

            // поправляем поля записей
            if (!empty($result)) {
                while ($item = $this->cms->db->fetch_object($result)) {
                    $this->unpack($item);
                    $items[$item->$idfield] = $item;
                }
            }

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
            parent::unpack($item, $params);

            // поправляем поле ip-адреса (разделяем на поля ip и host)
            $this->unpackIp($item);
        }
    }



    return;
?>