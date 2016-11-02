<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Варианты импорта: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ImportsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_IMPORTS_TABLENAME;
        public $id_field = 'import_id';



        // =======================================================================
        // Выбрать из базы данных записи о вариантах импорта согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->ids] = идентификаторы вариантов импорта (перечисленные через запятую)
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->automatic] = признак "автоматический запуск"
        //   [$params->interfaced] = признак "откликающийся на внешний вызов"
        //   [$params->filenamed] = признак "с заданным источником"
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' get');



            $items = array();
            $where = '';
            $order = '';



            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_IMPORTS_MODE_BY_NAME:
                        $order = $this->dbtable . '.name ASC, '
                               . $this->dbtable . '.created DESC ';
                        break;



                    case SORT_IMPORTS_MODE_BY_LASTUSED:
                        $order = $this->dbtable . '.lastused DESC, '
                               . $this->dbtable . '.name ASC ';
                        break;



                    case SORT_IMPORTS_MODE_BY_CREATED:
                    case SORT_IMPORTS_MODE_AS_IS:



                    default:
                        $order = $this->dbtable . '.created DESC ';
                }



                $order = 'ORDER BY ' . $order;
            }



            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->enabled)) $where .= 'AND ' . $this->dbtable . '.enabled = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
            if (isset($params->automatic)) $where .= 'AND ' . $this->dbtable . '.automatic = \'' . $this->cms->db->query_value($params->automatic) . '\' ';
            if (isset($params->interfaced)) $where .= 'AND TRIM(' . $this->dbtable . '.url) != \'\' ';
            if (isset($params->filenamed)) $where .= 'AND TRIM(' . $this->dbtable . '.filename) != \'\' ';
            if ($where != '') $where = 'WHERE 1 ' . $where;



            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);



            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS ' . $this->dbtable . '.*, '
                                              . 'ABS(' . $this->dbtable . '.lifetime) AS lifetime '
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
        // Взять из базы данных запись о варианте импорта, указанном в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название варианта импорта
        //   [$params->url] = адрес страницы записи
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->automatic] = признак "автоматический запуск"
        // =======================================================================

        public function one ( & $item, $params = null ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' one');



            $item = null;
            $where = '';



            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' = \'' . $this->cms->db->query_value($params->id) . '\' ';
            if (isset($params->name)) $where .= 'AND ' . $this->dbtable . '.name = \'' . $this->cms->db->query_value($params->name) . '\' ';
            if (isset($params->url)) $where .= 'AND ' . $this->dbtable . '.url = \'' . $this->cms->db->query_value($params->url) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND ' . $this->dbtable . '.' . $this->id_field . ' != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->enabled)) $where .= 'AND ' . $this->dbtable . '.enabled = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
                if (isset($params->automatic)) $where .= 'AND ' . $this->dbtable . '.automatic = \'' . $this->cms->db->query_value($params->automatic) . '\' ';
                $where = 'WHERE 1 ' . $where;



                // делаем запрос
                $query = 'SELECT ' . $this->dbtable . '.*, '
                              . 'ABS(' . $this->dbtable . '.lifetime) AS lifetime '
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
        // Добавить в записи о вариантах импорта оперативные ссылки админпанели:
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
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'Imports',
                                         REQUEST_PARAM_NAME_ITEMID => $item->$id,
                                         REQUEST_PARAM_NAME_TOKEN => $params->token);
                        if (isset($params->sort)) $options[REQUEST_PARAM_NAME_SORT] = $params->sort;



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "разрешен"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);



                        // создаем ссылку "старт импорта"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_IMPORT;
                        $item->import_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'Import';
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
                $this->prepareField($item, $this->id_field,    'integer', $fields, $values);
                $this->prepareField($item, 'name',             'string',  $fields, $values);
                $this->prepareField($item, 'delimiter',        'chars',   $fields, $values);
                $this->prepareField($item, 'format',           'string',  $fields, $values);
                $this->prepareField($item, 'columns',          'string',  $fields, $values);
                $this->prepareField($item, 'enabled',          'boolean', $fields, $values);
                $this->prepareField($item, 'url',              'string',  $fields, $values);
                $this->prepareField($item, 'password',         'string',  $fields, $values);
                $this->prepareField($item, 'automatic',        'boolean', $fields, $values);
                $this->prepareField($item, 'filename',         'string',  $fields, $values);
                $this->prepareField($item, 'lifetime',         'natural', $fields, $values);
                $this->prepareField($item, 'before_action',    'integer', $fields, $values);
                $this->prepareField($item, 'marketing_update', 'boolean', $fields, $values);
                $this->prepareField($item, 'financial_update', 'boolean', $fields, $values);
                $this->prepareField($item, 'history',          'string',  $fields, $values);
                $this->prepareField($item, 'created',          'date',    $fields, $values);
                $this->prepareField($item, 'lastused',         'date',    $fields, $values);
                $this->prepareField($item, 'busy',             'boolean', $fields, $values);

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



            // поправляем поля формата
            if (isset($item->format)) {
                $item->format = strtolower($item->format);
                $item->format = preg_replace('/[\s\t\r\n]+/', ' ', $item->format);
                $item->format = trim($item->format);
            }



            // поправляем поле мнемонического описания столбцов
            if (isset($item->columns)) {
                $item->columns = preg_replace('/[\s\t\r\n]+/', ' ', $item->columns);
                $item->columns = trim($item->columns);
            }



            // поправляем поле паузы между сеансами
            if (isset($item->lifetime)) {
                $seconds = $item->lifetime;
                $days = intval($seconds / 86400);
                $seconds = $seconds - $days * 86400;
                $hours = intval($seconds / 3600);
                $seconds = $seconds - $hours * 3600;
                $minutes = intval($seconds / 60);
                $seconds = $seconds - $minutes * 60;
                $item->lifetime_info = (($days != 0) ? $days . ' дней ' : '')
                                     . (($hours != 0) ? $hours . ' часов ' : '')
                                     . (($minutes != 0) ? $minutes . ' минут ' : '')
                                     . (($seconds != 0) ? $seconds . ' секунд' : '');
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
            if (empty($columns)) $this->cms->db->query('CREATE TABLE IF NOT EXISTS ' . $this->dbtable . ' (' . $this->id_field . ' BIGINT(20) NOT NULL) ENGINE = MyISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;');



            // проверяем наличие нужных столбцов, при отсутствии формируем соответствующие запросы
            $query = array();
            $subquery = array();
            if (!isset($columns[$this->id_field])) {
                $query[] = 'ADD ' . $this->id_field . ' BIGINT(20) NOT NULL';
                $query[] = 'DROP PRIMARY KEY';
                $query[] = '>SET @a := 0';
                $query[] = '>UPDATE ' . $this->dbtable . ' SET ' . $this->id_field . ' = @a := @a + 1';
                $query[] = 'ADD PRIMARY KEY (' . $this->id_field . ')';
                $query[] = 'CHANGE ' . $this->id_field . ' ' . $this->id_field . ' BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор варианта импорта\'';
            } else {



                // ИД варианта импорта
                $name = $this->id_field;
                $type = 'BIGINT(20)';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор варианта импорта\'';
            }



            // название варианта импорта
            $name = 'name';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Название варианта импорта\'';



            // символ разделения полей
            $name = 'delimiter';
            $type = 'VARCHAR(16)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Символ разделения полей\'';



            // формат импортируемой таблицы
            $name = 'format';
            $type = 'VARCHAR(16)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Формат импортируемой таблицы\'';



            // мнемонический перечень колонок
            $name = 'columns';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Мнемонический перечень колонок\'';



            // признак Разрешен к использованию
            $name = 'enabled';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'1\' NOT NULL COMMENT \'Признак Разрешен к использованию\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // url для запуска импорта извне
            $name = 'url';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'URL для запуска импорта извне\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // пароль для запуска импорта извне
            $name = 'password';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Пароль для запуска импорта извне\'';



            // признак Автостартуемый по расписанию
            $name = 'automatic';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Автостартуемый по расписанию\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);



            // url импортируемой таблицы
            $name = 'filename';
            $type = 'VARCHAR(256)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'URL импортируемой таблицы\'';



            // число секунд до следующего автостарта
            $name = 'lifetime';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'86400\' NOT NULL COMMENT \'Число секунд до следующего автостарта\'';



            // код действия перед началом импорта
            $name = 'before_action';
            $type = 'INT(11)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'' . BEFORE_IMPORT_OPERATION_NO_ACTION . '\' NOT NULL COMMENT \'Код действия перед началом импорта\'';



            // признак Перезаписывать маркетинговые поля товаров
            $name = 'marketing_update';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Перезаписывать маркетинговые поля товаров\'';



            // признак Перезаписывать количественные поля товаров
            $name = 'financial_update';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Признак Перезаписывать количественные поля товаров\'';



            // история импорта
            $name = 'history';
            $type = 'TEXT';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'История импорта\'';



            // дата создания записи
            $name = 'created';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата создания записи\'';



            // дата последнего использования
            $name = 'lastused';
            $type = 'DATETIME';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0000-00-00 00:00:00\' NOT NULL COMMENT \'Дата последнего использования\'';



            // динамический признак Этот вариант сейчас выполняется
            $name = 'busy';
            $type = 'TINYINT(1)';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' ' . $name . ' ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Динамический признак Этот вариант сейчас выполняется\'';



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
    }



    return;
?>