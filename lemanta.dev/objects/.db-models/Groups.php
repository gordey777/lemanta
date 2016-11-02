<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Группы скидок: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class GroupsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_GROUPS_TABLENAME;
        public $id_field = 'group_id';



        // =======================================================================
        // Взять из базы данных запись, указанную в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название группы
        //   [$params->authorized] = признак "групповая"
        //   [$params->auto_assign] = признак "автоназначаемая"
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
            if (isset($params->auto_assign)) $where .= 'AND ' . $this->dbtable . '.auto_assign = \'' . $this->cms->db->query_value($params->auto_assign) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->authorized)) $where .= 'AND ' . $this->dbtable . '.authorized = \'' . $this->cms->db->query_value($params->authorized) . '\' ';
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
        // Добавить в записи оперативные ссылки админпанели:
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
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'Groups',
                                         REQUEST_PARAM_NAME_ITEMID => $item->$id,
                                         REQUEST_PARAM_NAME_TOKEN => $params->token);
                        if (isset($params->sort)) $options[REQUEST_PARAM_NAME_SORT] = $params->sort;



                        // создаем ссылку "разрешена"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Group';
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
                $this->prepareField($item, $this->id_field,         'integer',  $fields, $values);
                $this->prepareField($item, 'name',                  'string',   $fields, $values);
                $this->prepareField($item, 'discount',              'positive', $fields, $values);
                $this->prepareField($item, 'from_sum',              'positive', $fields, $values);
                $this->prepareField($item, 'authorized',            'boolean',  $fields, $values);
                $this->prepareField($item, 'auto_assign',           'boolean',  $fields, $values);
                $this->prepareField($item, 'next_group_id',         'integer',  $fields, $values);
                $this->prepareField($item, 'next_group_sum',        'positive', $fields, $values);
                $this->prepareField($item, 'next_group_orders',     'natural',  $fields, $values);
                $this->prepareField($item, 'next_group_products',   'natural',  $fields, $values);
                $this->prepareField($item, 'next_group_condition',  'boolean',  $fields, $values);
                $this->prepareField($item, 'next_group_condition2', 'boolean',  $fields, $values);
                $this->prepareField($item, 'enabled',               'boolean',  $fields, $values);
                $this->prepareField($item, 'deleted',               'boolean',  $fields, $values);

                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, $this->dbtable, $this->id_field, $fields, $values);

                // если выполнено
                if (!empty($id)) {

                    // проверяем необходимость очистить кеш-таблицы
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
        *  Вычисление внегрупповой скидки по сумме заказа
        *
        *  @access  public
        *  @param   float   $sum        сумма заказа (незарегистрированного покупателя)
        *  @return  float               сумма скидки
        */
        // ===================================================================

        public function unauthorized_discount ( $sum ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' unauthorized_discount');



            $sum = abs($this->number->floatValue($sum));



            // делаем запрос
            $query = 'SELECT ' . $this->dbtable . '.discount '
                   . 'FROM ' . $this->dbtable . ' '
                   . 'WHERE ' . $this->dbtable . '.from_sum <= ' . $this->cms->db->query_value($sum) . ' '
                         . 'AND ' . $this->dbtable . '.authorized = 0 '
                   . 'ORDER BY ' . $this->dbtable . '.from_sum DESC, '
                                 . $this->dbtable . '.discount ASC, '
                                 . $this->dbtable . '.name ASC '
                   . 'LIMIT 1;';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();



            // освобождаем память от запроса
            $this->cms->db->free_result($result);



            // если есть записи о внегрупповых скидках, вычисляем скидку
            $result = 0;
            if (!empty($items)) {
                foreach ($items as & $item) {
                    if (isset($item->discount)) {
                        if (($item->discount > 0) && ($item->discount < 100)) {
                            $result = $sum * $this->number->floatValue($item->discount) / 100;
                        }
                        break;
                    }
                }
            }



            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();

            // возвращаем результат
            return $result;
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
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS ' . $this->dbtable . ' (' . $this->id_field . ' BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');



            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$this->id_field])) {
                $query[] = 'ADD ' . $this->id_field . ' BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE ' . $this->dbtable . ' SET ' . $this->id_field . ' = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (' . $this->id_field . ')';
                $query[] = 'CHANGE ' . $this->id_field . ' ' . $this->id_field . ' BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор группы\'';
            } else {



                // группа скидок
                $name = $this->id_field;
                $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор группы\'';
            }



            // название
            $name = 'name';
            $type = 'VARCHAR(' . DATABASE_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название группы скидок\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // скидка
            $name = 'discount';
            $type = 'FLOAT(' . DATABASE_FIELDSIZE_PERCENT . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Процент скидки\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // от суммы
            $name = 'from_sum';
            $type = 'FLOAT(' . DATABASE_FIELDSIZE_PRICE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'От какой суммы действует\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // групповая / внегрупповая
            $name = 'authorized';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'1\' NOT NULL COMMENT \'Признак Групповая или внегрупповая скидка\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // автоназначаемая
            $name = 'auto_assign';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Автоматически назначаемая зарегистрировавшемуся пользователю\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // следующая группа
            $name = 'next_group_id';
            $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор следующей группы\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // необходимая сумма
            $name = 'next_group_sum';
            $type = 'FLOAT(' . DATABASE_FIELDSIZE_PRICE . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0.00\' NOT NULL COMMENT \'Необходимая сумма заказов для перехода в следующую группу\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // необходимое количество заказов
            $name = 'next_group_orders';
            $type = 'INT(' . DATABASE_FIELDSIZE_QUANTITY . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Необходимое число заказов для перехода в следующую группу\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // необходимое количество товаров
            $name = 'next_group_products';
            $type = 'INT(' . DATABASE_FIELDSIZE_QUANTITY . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Необходимая число заказанных товаров для перехода в следующую группу\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // признак 1 соединения условий
            $name = 'next_group_condition';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'OR - AND признак соединения условий суммы и числа заказов\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // признак 2 соединения условий
            $name = 'next_group_condition2';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'OR - AND признак соединения условий числа заказов и товаров\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



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