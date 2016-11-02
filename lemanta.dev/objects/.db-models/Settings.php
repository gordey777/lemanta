<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Настройки сайта: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SettingsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'settings';
        public $id_field = 'setting_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'name',         // имя

                // категория
                'category'      => array('type' => 'VARCHAR(128)',
                                         'params' => 'DEFAULT "" NOT NULL COMMENT "Категория настройки"'),
                // описание
                'description'   => array('type' => 'VARCHAR(512)',
                                         'params' => 'DEFAULT "" NOT NULL COMMENT "Описание настройки"'),
                // значение
                'value'         => array('type' => 'TEXT',
                                         'params' => 'DEFAULT "" NOT NULL COMMENT "Значение настройки"',
                                         'index' => FALSE)
            )
        );



        // =======================================================================
        // Выбрать из базы данных записи о настройках:
        //   $items = результат будет помещен в эту переменную
        //   [$params->mode] = режим возврата результата
        //   [$params->sort] = способ сортировки записей
        //   [$params->name_prefix] = префикс имени настроек
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

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_SETTINGS_MODE_BY_NAME:
                        $order = 'ORDER BY `' . $dbtable . '`.`name` ASC ';
                        break;
                    case SORT_SETTINGS_MODE_BY_DESCRIPTION:
                        $order = 'ORDER BY `' . $dbtable . '`.`description` ASC ';
                        break;
                    case SORT_SETTINGS_MODE_BY_CATEGORY:
                        $order = 'ORDER BY `' . $dbtable . '`.`category` ASC, '
                                        . '`' . $dbtable . '`.`name` ASC';
                        break;
                    case SORT_SETTINGS_MODE_AS_IS:
                    default:
                }
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->name_prefix) && trim($params->name_prefix) != '') $where .= 'AND LEFT(TRIM(`' . $dbtable . '`.`name`), ' . strlen($this->cms->db->query_value($params->name_prefix)) . ') = "' . $this->cms->db->query_value($params->name_prefix) . '" ';
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

            // если результат не просили вернуть в форме настроек, то берем его как простой список
            if (!isset($params->mode) || $params->mode !== GET_SETTINGS_MODE_AS_SETTINGS) {

                // поправляем поля записей
                if (!empty($result)) {
                    while ($item = $this->cms->db->fetch_object($result)) {
                        $this->unpack($item);
                        $items[$item->$idfield] = $item;
                    }
                }

            // иначе результат нужно возвратить в форме настроек (объект->имя_настройки = значение настройки)
            } else {
                $items = null;
                $settings = $this->cms->db->results();
                foreach ($settings as & $setting) {
                    $this->unpack($setting);
                    $name = trim($setting->name);
                    if ($name != '') {
                        if (is_null($items)) $items = new stdClass;
                        $items->$name = trim($setting->value);
                    }
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



        // =======================================================================
        // Передать настройку в базу данных:
        //   $name = имя настройки
        //   $value = значение настройки
        //   [$description] = описание настройки
        //   [$category] = категория настройки
        // =======================================================================

        public function save ( $name, $value, $description = null, $category = null ) {
            $dbtable = $this->getDBTable();

            // берем данные настройки
            $name = trim($name);
            if ($name != '') {
                if (!is_null($description)) $description = preg_replace('/[ \r\n\t\s]+/u', ' ', trim($description));
                if (!is_null($category)) {
                    $category = str_replace('\\', '/', $category);
                    $category = str_replace('/', ' / ', $category);
                    $category = preg_replace('/[ \r\n\t\s]+/u', ' ', $category);
                    $category = trim($category);
                }

                // делаем запрос поиска настройки
                $query = 'SELECT `value` '
                       . 'FROM `' . $dbtable . '` '
                       . 'WHERE `name` = "' . $this->cms->db->query_value($name) . '" '
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $row = $this->cms->db->result();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // если такая настройка уже есть
                if (isset($row->value)) {
                    if ($row->value != $value) {
                        $query = 'UPDATE `' . $dbtable . '` '
                               . 'SET `value` = "' . $this->cms->db->query_value($value) . '" '
                                    . (!is_null($description) ? ', `description` = "' . $this->cms->db->query_value($description) . '" ' : '')
                                    . (!is_null($category) ? ', `category` = "' . $this->cms->db->query_value($category) . '" ' : '')
                               . 'WHERE `name` = "' . $this->cms->db->query_value($name) . '";';
                        $this->cms->db->query($query);
                    }

                // иначе такой настройки еще нет
                } else {
                    $query = 'INSERT INTO `' . $dbtable . '` (`name`, '
                                                           . (!is_null($description) ? '`description`, ' : '')
                                                           . (!is_null($category) ? '`category`, ' : '')
                                                           . '`value`) '
                           . 'VALUES ("' . $this->cms->db->query_value($name) . '", '
                                   . (!is_null($description) ? '"' . $this->cms->db->query_value($description) . '", ' : '')
                                   . (!is_null($category) ? '"' . $this->cms->db->query_value($category) . '", ' : '')
                                   . '"' . $this->cms->db->query_value($value) . '");';
                    $this->cms->db->query($query);
                }

                // копируем настройку движку в прочитанные
                $this->cms->settings->$name = $value;
            }
        }



        // =======================================================================
        // Передать настройку из $_POST[$name] в базу данных:
        //   $name = имя настройки
        //   [$description] = описание настройки
        //   [$category] = категория настройки
        // =======================================================================

        public function saveFromPost ( $name, $description = null, $category = null ) {
            $name = trim($name);
            if ($name != '') {
                $value = trim($this->request->getPost($name, ''));
                $this->save($name, $value, $description, $category);
            }
        }
    }



    return;
?>