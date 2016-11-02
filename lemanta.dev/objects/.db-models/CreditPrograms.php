<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Кредитные программы: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CreditProgramsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_CREDIT_PROGRAMS_TABLENAME;
        public $id_field = 'credit_id';



        // =======================================================================
        // Выбрать из базы данных записи о кредитных программах:
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->ids] = идентификаторы программ (перечисленные через запятую)
        //   [$params->term] = срок кредитования
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->deleted] = признак "удалена" запись
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

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
                    case SORT_CREDITPROGRAMS_MODE_BY_NAME:
                        $order = $this->dbtable . '.name ' . $direction . ', '
                               . $this->dbtable . '.order_num DESC ';
                        if ($laconical) $where .= 'AND TRIM(' . $this->dbtable . '.name) != \'\' ';
                        break;

                    case SORT_CREDITPROGRAMS_MODE_BY_TERM:
                        $order = $this->dbtable . '.term ' . $direction . ', '
                               . $this->dbtable . '.percent ' . $direction . ', '
                               . $this->dbtable . '.order_num DESC ';
                        if ($laconical) $where .= 'AND ' . $this->dbtable . '.term > 0 ';
                        break;

                    case SORT_CREDITPROGRAMS_MODE_BY_PERCENT:
                        $order = $this->dbtable . '.percent ' . $direction . ', '
                               . $this->dbtable . '.term ' . $direction . ', '
                               . $this->dbtable . '.order_num DESC ';
                        if ($laconical) $where .= 'AND ' . $this->dbtable . '.percent > 0 ';
                        break;

                    case SORT_CREDITPROGRAMS_MODE_BY_MODIFIED:
                        $order = $this->dbtable . '.modified ' . $direction . ', '
                               . $this->dbtable . '.name ASC, '
                               . $this->dbtable . '.order_num DESC ';
                        if ($laconical) $where .= 'AND ' . $this->dbtable . '.modified IS NOT NULL '
                                                    . 'AND ' . $this->dbtable . '.modified != ' . $this->dbtable . '.created ';
                        break;

                    case SORT_CREDITPROGRAMS_MODE_BY_CREATED:
                        $order = $this->dbtable . '.created ' . $direction . ', '
                               . $this->dbtable . '.name ASC, '
                               . $this->dbtable . '.order_num DESC ';
                        if ($laconical) $where .= 'AND ' . $this->dbtable . '.created IS NOT NULL ';
                        break;

                    case SORT_CREDITPROGRAMS_MODE_AS_IS:
                    default:
                        $order = $this->dbtable . '.order_num DESC, '
                               . $this->dbtable . '.name ASC ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->term)) $where .= 'AND ' . $this->dbtable . '.term = \'' . $this->cms->db->query_value($params->term) . '\' ';
            if (isset($params->enabled)) $where .= 'AND ' . $this->dbtable . '.enabled = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
            $where = 'WHERE ' . $this->dbtable . '.deleted = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS ' . $this->dbtable . '.* '
                   . 'FROM ' . $this->dbtable . ' '
                   . $where
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
        // Взять из базы данных запись о кредитной программе, указанной в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название программы
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->deleted] = признак "удалена" запись
        // =======================================================================

        public function one ( & $item, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' one');

            $item = null;
            $where = '';

            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' = \'' . $this->cms->db->query_value($params->id) . '\' ';
            if (isset($params->name)) $where .= 'AND ' . $this->dbtable . '.name = \'' . $this->cms->db->query_value($params->name) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->enabled)) $where .= 'AND ' . $this->dbtable . '.enabled = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
                $where = 'WHERE ' . $this->dbtable . '.deleted = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;

                // делаем запрос
                $query = 'SELECT ' . $this->dbtable . '.* '
                       . 'FROM ' . $this->dbtable . ' '
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



        // =======================================================================
        // Добавить в записи о кредитных программах оперативные ссылки админпанели:
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
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'CreditPrograms',
                                         REQUEST_PARAM_NAME_ITEMID => $item->$id,
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

                        // создаем ссылку "разрешена"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);

                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);

                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'CreditProgram';
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
                $this->prepareField($item, 'term',          'natural',  $fields, $values);
                $this->prepareField($item, 'percent',       'positive', $fields, $values);
                $this->prepareField($item, 'minimal_sum',   'positive', $fields, $values);
                $this->prepareField($item, 'maximal_sum',   'positive', $fields, $values);
                $this->prepareField($item, 'form_fields',   'string',   $fields, $values, $this->packedArray($item, 'form_fields', FALSE));
                $this->prepareField($item, 'description',   'string',   $fields, $values);
                $this->prepareField($item, 'enabled',       'boolean',  $fields, $values);
                $this->prepareField($item, 'deleted',       'boolean',  $fields, $values);
                $this->prepareField($item, 'created',       'date',     $fields, $values);
                $this->prepareField($item, 'modified',      'date',     $fields, $values);
                $this->prepareField($item, 'order_num',     'integer',  $fields, $values);

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

            // вычисляем множитель для месяца
            $item->term = isset($item->term) && ($item->term > 0) ? intval($item->term) : 1;
            $item->scale = (isset($item->percent) ? 100 + $item->percent : 100) / $item->term / 100;

            // поправляем поле запрашиваемых полей
            if (isset($item->form_fields) && is_string($item->form_fields)) {
                if (trim($item->form_fields) == '') {
                    $item->form_fields = array();
                } else {
                    $fields = @ unserialize($item->form_fields);
                    $item->form_fields = array();
                    if (is_array($fields)) {
                        foreach ($fields as & $field) {
                            if (is_string($field)) $field = trim($field);
                            if (is_array($field) && !empty($field)
                            || is_string($field) && ($field != '')) $item->form_fields[] = $field;
                        }
                    }
                }
            }
        }



        // =======================================================================
        // Возвратить в виде массива типичный набор запрашиваемых полей записи о кредитной программе
        // =======================================================================

        public function defaultFormFields () {
            $result = array();

            $result[] = array('field' => 'ФИО полностью',                 'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Дата рождения',                 'type' => FIELDTYPE_CREDITPROGRAMS_DATE,   'required' => TRUE);
            $result[] = array('field' => 'Идентификационный код (ИНН)',   'type' => FIELDTYPE_CREDITPROGRAMS_NUMBER, 'required' => TRUE);

            $result[] = 'Паспортные данные';
            $result[] = array('field' => 'Паспорт серия, номер',          'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Кем выдан',                     'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Когда выдан',                   'type' => FIELDTYPE_CREDITPROGRAMS_DATE,   'required' => TRUE);
            $result[] = array('field' => 'Адрес регистрации',             'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);

            $result[] = 'Адресные сведения';
            $result[] = array('field' => 'Адрес места проживания',        'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Почтовый индекс',               'type' => FIELDTYPE_CREDITPROGRAMS_NUMBER, 'required' => TRUE);
            $result[] = array('field' => 'Домашний телефон',              'type' => FIELDTYPE_CREDITPROGRAMS_PHONE,  'required' => FALSE);
            $result[] = array('field' => 'Мобильный телефон',             'type' => FIELDTYPE_CREDITPROGRAMS_PHONE,  'required' => TRUE);
            $result[] = array('field' => 'Электронная почта',             'type' => FIELDTYPE_CREDITPROGRAMS_EMAIL,  'required' => FALSE);

            $result[] = 'Образование и место работы';
            $result[] = array('field' => 'Образование',                         'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Какое учебное заведение заканчивали', 'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Место работы',                        'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Рабочий телефон',                     'type' => FIELDTYPE_CREDITPROGRAMS_PHONE,  'required' => TRUE);
            $result[] = array('field' => 'Адрес работы',                        'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Должность',                           'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);

            $result[] = 'Семейное положение';
            $result[] = array('field' => 'Семейное положение',                   'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => TRUE);
            $result[] = array('field' => 'Количество детей',                     'type' => FIELDTYPE_CREDITPROGRAMS_NUMBER, 'required' => TRUE);
            $result[] = array('field' => 'Возраст детей',                        'type' => FIELDTYPE_CREDITPROGRAMS_STRING, 'required' => FALSE);
            $result[] = array('field' => 'Количество людей, проживающих с Вами', 'type' => FIELDTYPE_CREDITPROGRAMS_NUMBER, 'required' => TRUE);
            $result[] = array('field' => 'Комментарий (не обязательно)',         'type' => FIELDTYPE_CREDITPROGRAMS_TEXT,   'required' => FALSE);

            $result[] = 'Приложения';
            $result[] = array('field' => 'Приложить скан копию паспорта',               'type' => FIELDTYPE_CREDITPROGRAMS_FILE,   'required' => TRUE);
            $result[] = array('field' => '..... скан копия паспорта (вторая страница)', 'type' => FIELDTYPE_CREDITPROGRAMS_FILE,   'required' => FALSE);
            $result[] = array('field' => '..... скан копия паспорта (прописка)',        'type' => FIELDTYPE_CREDITPROGRAMS_FILE,   'required' => FALSE);
            $result[] = array('field' => 'Приложить скан копию ИНН',                    'type' => FIELDTYPE_CREDITPROGRAMS_FILE,   'required' => TRUE);
            $result[] = array('field' => 'Приложить личную фотографию',                 'type' => FIELDTYPE_CREDITPROGRAMS_FILE,   'required' => TRUE);

            return $result;
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
            $records[] = array('name' => '3 месяца',   'term' => 3,  'percent' => 3.00,  'order_num' => 3);
            $records[] = array('name' => '6 месяцев',  'term' => 6,  'percent' => 9.00,  'order_num' => 2);
            $records[] = array('name' => '10 месяцев', 'term' => 10, 'percent' => 15.00, 'order_num' => 1);

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
                $value->term = $record['term'];
                $value->percent = $this->number->floatValue($record['percent']);
                $value->form_fields = $this->defaultFormFields();
                $value->order_num = $record['order_num'];
                $value->deleted = 0;
                $value->created = time();
                $this->update($value);
            }
            $this->cms->db->close_tracing_method();
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
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS ' . $this->dbtable . ' (' . $this->id_field . ' BIGINT(' . DATABASE_CREDIT_PROGRAMS_FIELDSIZE_ID . ') NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');

            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$this->id_field])) {
                $query[] = 'ADD ' . $this->id_field . ' BIGINT(' . DATABASE_CREDIT_PROGRAMS_FIELDSIZE_ID . ') NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE ' . $this->dbtable . ' SET ' . $this->id_field . ' = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (' . $this->id_field . ')';
                $query[] = 'CHANGE ' . $this->id_field . ' ' . $this->id_field . ' BIGINT(' . DATABASE_CREDIT_PROGRAMS_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор кредитной программы\'';
            } else {

                // кредитная программа
                $name = $this->id_field;
                $type = 'BIGINT(' . DATABASE_CREDIT_PROGRAMS_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор кредитной программы\'';
            }

            // название
            $name = 'name';
            $type = 'VARCHAR(' . DATABASE_CREDIT_PROGRAMS_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название кредитной программы\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // срок кредитования
            $name = 'term';
            $type = 'INT(11) UNSIGNED';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'12\' NOT NULL COMMENT \'Срок кредитования\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // процентная ставка
            $name = 'percent';
            $type = 'FLOAT(5,2)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'36.00\' NOT NULL COMMENT \'Процентная ставка\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // минимальная сумма
            $name = 'minimal_sum';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Минимальная сумма заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // максимальная сумма
            $name = 'maximal_sum';
            $type = 'FLOAT(17,6)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Максимальная сумма заказа\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // запрашиваемые поля
            $name = 'form_fields';
            $type = 'MEDIUMTEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Пакет запрашиваемых данных\'';

            // описание
            $name = 'description';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Описание кредитной программы\'';

            // разрешена
            $name = 'enabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'1\' NOT NULL COMMENT \'Признак Запись разрешена\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // удалена
            $name = 'deleted';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Запись удалена\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // создано
            $name = 'created';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата создания записи\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // изменено
            $name = 'modified';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата изменения записи\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // вес
            $name = 'order_num';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Вес записи среди прочих\'';
                $subquery[] = 'UPDATE ' . $this->dbtable . ' '
                            . 'SET ' . $name . ' = ' . $this->id_field . ' '
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
                        $command = 'ALTER TABLE ' . $this->dbtable . ' ' . $command . ';';
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