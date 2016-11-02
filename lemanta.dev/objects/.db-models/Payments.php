<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Способы оплаты: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PaymentsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_PAYMENT_METHODS_TABLENAME;
        public $id_field = 'payment_method_id';



        // =======================================================================
        // Взять из базы данных записи, указанные в параметрах:
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->ids] = идентификаторы способов (перечисленные через запятую)
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
            $limit = '';

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_PAYMENTS_MODE_BY_NAME:
                        $order = '`' . $this->dbtable . '`.`name` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`name`) != \'\' ';
                        break;
                    case SORT_PAYMENTS_MODE_BY_CURRENCY:
                        $order = '`currency` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`currencies`.`name`) != \'\' ';
                        break;
                    case SORT_PAYMENTS_MODE_BY_CREATED:
                        $order = '`' . $this->dbtable . '`.`created` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`created` IS NOT NULL ';
                        break;
                    case SORT_PAYMENTS_MODE_BY_MODIFIED:
                        $order = '`' . $this->dbtable . '`.`modified` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC, '
                               . '`' . $this->dbtable . '`.`order_num` DESC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`modified` IS NOT NULL '
                                                . 'AND `' . $this->dbtable . '`.`modified` != `' . $this->dbtable . '`.`created` ';
                        break;
                    case SORT_PAYMENTS_MODE_AS_IS:
                    default:
                        $order = '`' . $this->dbtable . '`.`order_num` DESC, '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                }
                $order = 'ORDER BY ' . $order;
            }



            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->enabled)) $where .= 'AND `' . $this->dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
            if ($where != '') $where = 'WHERE `' . $this->dbtable . '`.`deleted` = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;



            // формируем параметр LIMIT запроса
            if (isset($params->start) || isset($params->maxcount)) {
                $limit = 'LIMIT ';
                if (isset($params->start)) {
                    $params->start = intval($params->start);
                    if ($params->start >= 0) $limit .= $params->start . ', ';
                }
                if (isset($params->maxcount)) {
                    $params->maxcount = intval($params->maxcount);
                    if ($params->maxcount >= 0) $limit .= $params->maxcount;
                }
            }



            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $this->dbtable . '`.*, '
                                              . '`currencies`.`name` AS `currency`, '
                                              . '`currencies`.`rate_from` AS `rate_from`, '
                                              . '`currencies`.`rate_to` AS `rate_to`, '
                                              . '`currencies`.`sign` AS `sign` '
                   . 'FROM `' . $this->dbtable . '` '
                   . 'LEFT JOIN `currencies` ON `currencies`.`currency_id` = `' . $this->dbtable . '`.`currency_id` '
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



        // =======================================================================
        // Взять из базы данных запись, указанную в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->deleted] = признак "удалена" запись
        //   [$params->name] = название способа
        // =======================================================================

        public function one ( & $item, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' one');



            $item = null;
            $where = '';



            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` = \'' . $this->cms->db->query_value($params->id) . '\' ';
            if (isset($params->name)) $where .= 'AND `' . $this->dbtable . '`.`name` = \'' . $this->cms->db->query_value($params->name) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->enabled)) $where .= 'AND `' . $this->dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
                $where = 'WHERE `' . $this->dbtable . '`.`deleted` = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;



                // делаем запрос
                $query = 'SELECT `' . $this->dbtable . '`.*, '
                              . '`currencies`.`name` AS `currency`, '
                              . '`currencies`.`rate_from` AS `rate_from`, '
                              . '`currencies`.`rate_to` AS `rate_to`, '
                              . '`currencies`.`sign` AS `sign` '
                       . 'FROM `' . $this->dbtable . '` '
                       . 'LEFT JOIN `currencies` ON `currencies`.`currency_id` = `' . $this->dbtable . '`.`currency_id` '
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
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'Payments',
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



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "разрешена"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Payment';
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
                $this->prepareField($item, $this->id_field, 'integer', $fields, $values);
                $this->prepareField($item, 'name',          'string',  $fields, $values);
                $this->prepareField($item, 'module',        'string',  $fields, $values);
                $this->prepareField($item, 'description',   'string',  $fields, $values);
                $this->prepareField($item, 'currency_id',   'integer', $fields, $values);
                $this->prepareField($item, 'params',        'string',  $fields, $values);
                $this->prepareField($item, 'enabled',       'boolean', $fields, $values);
                $this->prepareField($item, 'deleted',       'boolean', $fields, $values);
                $this->prepareField($item, 'created',       'date',    $fields, $values);
                $this->prepareField($item, 'modified',      'date',    $fields, $values);
                $this->prepareField($item, 'order_num',     'integer', $fields, $values);

                // обновляем / добавляем запись
                $id = $this->cms->db->update_record($item, $this->dbtable, $this->id_field, $fields, $values);

                // если выполнено
                if (!empty($id)) {

                    // если существуют способы доставки
                    if (isset($item->deliveries_ids)) {

                        // удаляем прежние записи о способах доставки
                        $query = 'DELETE FROM `delivery_payment` '
                               . 'WHERE `' . $this->id_field . '` = \'' . $this->cms->db->query_value($id) . '\';';
                        $this->cms->db->query($query);

                        // добавляем новые записи
                        if (is_string($item->deliveries_ids)) $item->deliveries_ids = explode(',', $item->deliveries_ids);
                        foreach ($item->deliveries_ids as & $row) {
                            $row = intval($row);
                            if (!empty($row)) {
                                $query = 'INSERT INTO `delivery_payment` (`delivery_method_id`, '
                                                                       . '`' . $this->id_field . '`) '
                                       . 'VALUES (\'' . $this->cms->db->query_value($row) . '\', '
                                               . '\'' . $this->cms->db->query_value($id) . '\');';
                                $this->cms->db->query($query);
                            }
                        }
                    }

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
            if (isset($item->description)) $this->cms->db->fix_textfield_as_product_description($item->description);



            // поправляем адресующие поля
            $id = $this->id_field;
            if (isset($item->$id)) {
                $item->$id = intval($item->$id);



                // читаем способы доставки
                if (!isset($item->delivery_methods)) {
                    $query = 'SELECT * '
                           . 'FROM `delivery_methods`, '
                                . '`delivery_payment` '
                           . 'WHERE `delivery_methods`.`delivery_method_id` = `delivery_payment`.`delivery_method_id` '
                                 . 'AND `delivery_payment`.`' . $this->id_field . '` = \'' . $this->cms->db->query_value($item->$id) . '\' '
                           . 'ORDER BY `delivery_methods`.`name`;';
                    $result = $this->cms->db->query($query);
                    $item->delivery_methods = $this->cms->db->results();



                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);
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
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $this->dbtable . '` (`' . $this->id_field . '` BIGINT(' . DATABASE_PAYMENTS_FIELDSIZE_ID . ') NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');



            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$this->id_field])) {
                $query[] = 'ADD `' . $this->id_field . '` BIGINT(' . DATABASE_PAYMENTS_FIELDSIZE_ID . ') NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE `' . $this->dbtable . '` SET `' . $this->id_field . '` = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (`' . $this->id_field . '`)';
                $query[] = 'CHANGE `' . $this->id_field . '` `' . $this->id_field . '` BIGINT(' . DATABASE_PAYMENTS_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор способа оплаты\'';
            } else {



                // способ оплаты
                $name = $this->id_field;
                $type = 'BIGINT(' . DATABASE_PAYMENTS_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор способа оплаты\'';
            }



            // название
            $name = 'name';
            $type = 'VARCHAR(' . DATABASE_PAYMENTS_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // модуль
            $name = 'module';
            $type = 'VARCHAR(' . DATABASE_PAYMENTS_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название платежного модуля\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // описание
            $name = 'description';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Описание\'';



            // ИД валюты
            $name = 'currency_id';
            $type = 'BIGINT(' . DATABASE_CURRENCIES_FIELDSIZE_ID . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Идентификатор валюты\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // описание
            $name = 'params';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Параметры платежного механизма\'';



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



            // создан
            $name = 'created';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата создания записи\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // исправлен
            $name = 'modified';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата изменения записи\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // вес
            $name = 'order_num';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') {
                $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Вес записи среди прочих\'';
                $subquery[] = 'UPDATE `' . $this->dbtable . '` '
                            . 'SET `' . $name . '` = `' . $this->id_field . '` '
                            . 'WHERE `' . $name . '` = 0 OR `' . $name . '` IS NULL;';
            }
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