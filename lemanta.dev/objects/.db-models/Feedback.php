<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Обратная связь: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class FeedbackDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'feedback';
        public $id_field = 'feedback_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'parent_id',    // верхний пост
                'department',   // департамент
                'subject',      // тема
                'name',         // имя
                'email',        // емейл
                'phone',        // телефон
                'message',      // сообщение
                'new',          // новое
                'from_user',    // от пользователя
                'to_user',      // для пользователя
                'ip',           // ip-адрес
                'date'          // создано
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'Feedback';
        protected $operables_card = 'Feedback';
        protected $operables = array('delete', 'new', 'edit');



        // =======================================================================
        // $filter->find = искомый текст
        // $filter->id = ид сообщения
        // $filter->uid = ид пользователя-отправителя
        // $filter->uid2 = ид пользователя-получателя
        // $filter->email = емейл 1 пользователя
        // $filter->email2 = емейл 2 пользователя
        // $filter->operator = управляющий объект

        public function get ( & $feedback, $filter = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $operable = !empty($filter->operator) && $this->any->hasMethod($filter->operator, 'form_get');

            $feedback = array();
            $count = 0;
            $pass = 0;
            do {
                $key = trim(!empty($filter->find) ? preg_replace('/[ \t]+/', ' ', $filter->find) : '');
                $selector = '';
                $where = '';
                if (!empty($filter->id)) $selector .= 'AND `' . $idfield . '` = \'' . $this->cms->db->query_value($filter->id) . '\' ';
                if (!empty($filter->uid) || !empty($filter->uid2) || !empty($filter->email) || !empty($filter->email2)) {
                    $selector .= 'AND (';
                    if (!empty($filter->uid)) {
                        $selector .= '`from_user` = \'' . $this->cms->db->query_value($filter->uid) . '\' ';
                        if (!empty($filter->uid2) || !empty($filter->email) || !empty($filter->email2)) $selector .= 'OR ';
                    }
                    if (!empty($filter->uid2)) {
                        $selector .= '`to_user` = \'' . $this->cms->db->query_value($filter->uid2) . '\' ';
                        if (!empty($filter->email) || !empty($email2)) $selector .= 'OR ';
                    }
                    if (!empty($filter->email)) {
                        $selector .= '`email` = \'' . $this->cms->db->query_value($filter->email) . '\' ';
                        if (!empty($filter->email2)) $selector .= 'OR ';
                    }
                    if (!empty($filter->email2)) $selector .= '`email` = \'' . $this->cms->db->query_value($filter->email2) . '\' ';
                    $selector .= ') ';
                }
                if ($key != '') {
                    if ($pass > 0) {
                        $words = explode(' ', $key);
                    } else {
                        $words = array($key);
                        if (strpos($key, ' ') === FALSE) $pass++;
                    }
                    foreach ($words as $key) {
                        $key = $this->cms->db->query_value($key);
                        $command = substr($key, 0, 4);
                        switch (strtolower($command)) {
                        case 'cid:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `' . $idfield . '` = \'' . $key . '\' ';
                            break;
                        case 'oid:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `parent_id` = \'' . $key . '\' ';
                            break;
                        case 'uip:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `ip` = \'' . $key . '\' ';
                            break;
                        case 'pid:':
                        case 'uid:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND (`to_user` = \'' . $key . '\' '
                                                           . 'OR `from_user` = \'' . $key . '\') ';
                            break;
                        case 'sid:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `from_user` = \'' . $key . '\' ';
                            break;
                        case 'aid:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `to_user` = \'' . $key . '\' ';
                            break;
                        case 'dat:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `date` LIKE \'' . $key . '%\' ';
                            break;
                        case 'nam:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `name` LIKE \'%' . $key . '%\' ';
                            break;
                        case 'mai:':
                            $key = trim(substr($key, 4));
                            if ($key != '') $where .= 'AND `email` = \'' . $key . '\' ';
                            break;
                        default:
                            $where .= 'AND `message` LIKE \'%' . $key . '%\' ';
                        }
                    }
                }
                $query = 'SELECT *, '
                              . 'DATE_FORMAT(`date`, \'%Y.%m.%d %H:%i\') AS `date` '
                       . 'FROM `' . $dbtable . '` '
                       . (empty($where) && empty($selector) ? '' : 'WHERE 1 ' . $selector . $where)
                       . 'ORDER BY `date` ASC, '
                                . '`' . $idfield . '` ASC;';
                $result = $this->cms->db->query($query);
                if (!empty($result)) {
                    $temp = array();
                    while ($item = $this->cms->db->fetch_object($result)) {
                        $item->discussion = array();
                        if ($operable) {
                            $item->set_new_get = $filter->operator->form_get(array('section' => 'Feedback',
                                                                                   'act' => 'new',
                                                                                   'item_id' => $item->$idfield,
                                                                                   'token' => $filter->operator->token));
                            $item->delete_get = $filter->operator->form_get(array('section' => 'Feedback',
                                                                                  'act' => 'delete',
                                                                                  'item_id' => $item->$idfield,
                                                                                  'token' => $filter->operator->token));
                        }
                        $temp[$item->$idfield] = $item;
                    }
                    foreach ($temp as $key => $item) {
                        if (empty($item->parent_id) || !isset($temp[$item->parent_id])) {
                            $feedback[] = & $temp[$key];
                            $count++;
                        } else {
                            $temp[$item->parent_id]->discussion[$key] = & $temp[$key];
                        }
                    }
                    if ($operable) $feedback = array_reverse($feedback);
                }

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                $pass++;
            } while (empty($count) && $pass < 2 && !empty($where));
            return $count;
        }



        // =======================================================================

        public function getUserFeedback ( & $user, & $feedback ) {
            $feedback = null;
            if (!empty($user)) {
                $dbtable = $this->getDBTable();
                $query = 'SELECT *, '
                              . 'DATE_FORMAT(`date`, \'%Y-%m-%d %H:%i:%s\') AS `date`, '
                              . 'DATE_FORMAT(`date`, \'%Y-%m-%d\') AS `date_date`, '
                              . 'DATE_FORMAT(`date`, \'%H:%i:%s\') AS `date_time` '
                       . 'FROM `' . $dbtable . '` '
                       . 'WHERE `from_user` = \'' . $this->cms->db->query_value($user->user_id) . '\' '
                             . 'OR `to_user` = \'' . $this->cms->db->query_value($user->user_id) . '\' '
                             . ($user->email != '' ? 'OR `email` = \'' . $this->cms->db->query_value($user->email) . '\' ' : '')
                             . ($user->email2 != '' ? 'OR `email` = \'' . $this->cms->db->query_value($user->email2) . '\' ' : '')
                       . 'ORDER BY `date` DESC;';
                $result = $this->cms->db->query($query);
                $feedback = array();
                if (!empty($result)) {
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $feedback[] = $row;
                    }
                }

                // освобождаем память от запроса
                $this->cms->db->free_result($result);
            }
        }



        // ===================================================================
        /**
        *  Распаковка полей записей
        *
        *  @access  public
        *  @param   array   $items      массив записей
        *  @param   object  $params     объект параметров
        *  @return  void
        */
        // ===================================================================

        public function unpackRecords ( & $items, $params = null ) {
            $dbtable = $this->getDBTable();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' unpackRecords');

            if (!empty($items)) {
                foreach ($items as & $item) {
                    $this->unpack($item, $params);

                    // если есть вложенные элементы, поправляем поля в них
                    if (!empty($item->discussion)) $this->unpackRecords($item->discussion, $params);
                }
            }
            $this->cms->db->close_tracing_method();
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