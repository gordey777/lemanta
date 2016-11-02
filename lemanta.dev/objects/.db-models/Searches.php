<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Поисковое сопровождение: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SearchesDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = DATABASE_SEARCHES_TABLENAME;
        public $id_field = 'search_id';



        // =======================================================================
        // Взять из базы данных записи, указанные в параметрах:
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->type] = тип состояния записи
        //   [$params->search] = искомый текст (может быть массивом искомых текстов; объединяются по AND)
        //   [$params->search_date_from] = искомая дата от (формат ГГГГ-ММ-ДД)
        //   [$params->search_date_to] = искомая дата до (формат ГГГГ-ММ-ДД)
        //   [$params->ids] = идентификаторы записей (перечисленные через запятую)
        //   [$params->enabled] = признак "разрешена" запись:
        //                            0 = запрещенная
        //                            1 = разрешенная
        //                            * = в любом состоянии (эквивалентно отсутствию параметра)
        //   [$params->deleted] = признак "удалена" запись:
        //                            0 = не удаленная (эквивалентно отсутствию параметра)
        //                            1 = удаленная
        //                            * = в любом состоянии
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

            // делаем селекцию указанного типа
            if (isset($params->type)) {
                switch ($params->type) {
                    case TYPE_SEARCHES_NEW:
                        $where .= 'AND REPLACE(REPLACE(`' . $this->dbtable . '`.`escort_url`, \' \', \'\'),  \'/\', \'\') = \'\' ';
                        break;
                    case TYPE_SEARCHES_ESCORTING:
                        $where .= 'AND REPLACE(REPLACE(`' . $this->dbtable . '`.`escort_url`, \' \', \'\'),  \'/\', \'\') != \'\' ';
                        break;
                    case TYPE_SEARCHES_ANY:
                        break;
                }
            }

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_SEARCHES_MODE_BY_NAME:
                        $order = '`' . $this->dbtable . '`.`name` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`browsed` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`name`) != \'\' ';
                        break;
                    case SORT_SEARCHES_MODE_BY_ESCORT_URL:
                        $order = '`' . $this->dbtable . '`.`escort_url` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND REPLACE(REPLACE(`' . $this->dbtable . '`.`escort_url`, \' \', \'\'),  \'/\', \'\') != \'\' ';
                        break;
                    case SORT_SEARCHES_MODE_BY_TARGET_URL:
                        $order = '`' . $this->dbtable . '`.`target_url` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`target_url`) != \'\' ';
                        break;
                    case SORT_SEARCHES_MODE_BY_REFERER:
                        $order = '`' . $this->dbtable . '`.`referer` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $this->dbtable . '`.`referer`) != \'\' ';
                        break;
                    case SORT_SEARCHES_MODE_BY_BROWSED:
                        $order = '`' . $this->dbtable . '`.`browsed` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`browsed` != 0 ';
                        break;
                    case SORT_SEARCHES_MODE_BY_CREATED:
                        $order = '`' . $this->dbtable . '`.`created` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`created` IS NOT NULL ';
                        break;
                    case SORT_SEARCHES_MODE_BY_MODIFIED:
                        $order = '`' . $this->dbtable . '`.`modified` ' . $direction . ', '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                        if ($laconical) $where .= 'AND `' . $this->dbtable . '`.`modified` IS NOT NULL '
                                                . 'AND `' . $this->dbtable . '`.`modified` != `' . $this->dbtable . '`.`created` ';
                        break;
                    case SORT_SEARCHES_MODE_AS_IS:
                    default:
                        $order = '`' . $this->dbtable . '`.`created` DESC, '
                               . '`' . $this->dbtable . '`.`name` ASC ';
                }
                $order = 'ORDER BY ' . $order;
            }



            // фильтруем по искомой дате
            if (isset($params->search_date_from)) $where .= 'AND `' . $this->dbtable . '`.created >= \'' . $this->cms->db->query_value($params->search_date_from) . ' 00:00:00\' ';
            if (isset($params->search_date_to)) $where .= 'AND `' . $this->dbtable . '`.created <= \'' . $this->cms->db->query_value($params->search_date_to) . ' 23:59:59\' ';



            // фильтруем по искомому тексту (может быть массивом искомых текстов; объединяются по AND)
            if (isset($params->search) && (is_string($params->search) && ($params->search != '')
                                       || is_array($params->search) && !empty($params->search))) {

                // перебираем элементы искомых текстов
                if (is_string($params->search)) $params->search = array($params->search);
                foreach ($params->search as $search) {
                    $search = trim($search);
                    if ($search != '') {

                        // анализируем искомый текст в 2 прохода (1 проход - префиксные команды, 2 проход - отдельные слова)
                        for ($pass = 1; $pass <= 2; $pass++ ) {
                            if ($pass == 1) {
                                $keywords = array($search);
                            } else {
                                // в искомом тексте обрабатываем лишь 4 первых слова
                                $keywords = preg_split('/\s+/', $search, 4);
                            }

                            $found = FALSE;
                            foreach ($keywords as $keyword) {

                                // если слово более 2 букв
                                if (strlen($keyword) > 2) {

                                    // просто слова обрабатываем не на 1 проходе
                                    if ($pass != 1) {
                                        $keyword = $this->cms->db->query_value($keyword);
                                        $where .= 'AND `' . $this->dbtable . '`.`name` LIKE \'%' . $keyword . '%\' ';
                                        $found = TRUE;
                                        continue;
                                    }

                                    // если есть префиксная команда поиска по дате модификации
                                    $command = strtolower(SEARCH_SEARCHES_COMMAND_MODIFIED_DATE);
                                    $size = strlen($command);
                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                        $keyword = trim(substr($keyword, $size));
                                        if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`modified`, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                        $found = TRUE;
                                    } else {

                                        // если есть префиксная команда поиска по дате создания
                                        $command = strtolower(SEARCH_SEARCHES_COMMAND_CREATED_DATE);
                                        $size = strlen($command);
                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                            $keyword = trim(substr($keyword, $size));
                                            if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $this->dbtable . '`.`created`, \'%Y-%m-%d\') = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                            $found = TRUE;
                                        } else {

                                            // если есть префиксная команда поиска по источнику трафика
                                            $command = strtolower(SEARCH_SEARCHES_COMMAND_REFERER);
                                            $size = strlen($command);
                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                $keyword = trim(substr($keyword, $size));
                                                if ($keyword == '*') {
                                                    $where .= 'AND `' . $this->dbtable . '`.`referer` != \'\' ';
                                                } else {
                                                    $where .= 'AND `' . $this->dbtable . '`.`referer` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                }
                                                $found = TRUE;
                                            } else {

                                                // если есть префиксная команда поиска по ИД записи
                                                $command = strtolower(SEARCH_SEARCHES_COMMAND_ID);
                                                $size = strlen($command);
                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                    $keyword = trim(substr($keyword, $size));
                                                    if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                    $found = TRUE;
                                                } else {

                                                    // если есть префиксная команда поиска по сопровождаемому URL
                                                    $command = strtolower(SEARCH_SEARCHES_COMMAND_ESCORT_URL);
                                                    $size = strlen($command);
                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                        $keyword = trim(substr($keyword, $size));
                                                        if ($keyword == '*') {
                                                            $where .= 'AND `' . $this->dbtable . '`.`escort_url` != \'\' ';
                                                        } else {
                                                            $where .= 'AND `' . $this->dbtable . '`.`escort_url` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                        }
                                                        $found = TRUE;
                                                    } else {

                                                        // если есть префиксная команда поиска по предлагавшемуся URL
                                                        $command = strtolower(SEARCH_SEARCHES_COMMAND_TARGET_URL);
                                                        $size = strlen($command);
                                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                                            $keyword = trim(substr($keyword, $size));
                                                            if ($keyword == '*') {
                                                                $where .= 'AND `' . $this->dbtable . '`.`target_url` != \'\' ';
                                                            } else {
                                                                $where .= 'AND `' . $this->dbtable . '`.`target_url` = \'' . $this->cms->db->query_value($keyword) . '\' ';
                                                            }
                                                            $found = TRUE;
                                                        } else {

                                                            // если есть префиксная команда поиска по поисковой фразе
                                                            $command = strtolower(SEARCH_SEARCHES_COMMAND_NAME);
                                                            $size = strlen($command);
                                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                $keyword = trim(substr($keyword, $size));
                                                                if ($keyword != '') $where .= 'AND `' . $this->dbtable . '`.`name` = \'' . $this->cms->db->query_value($keyword) . '\' ';
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

                            // если на каком-то из проходов найдено поисковое условие, прекращаем обработку
                            if ($found) break;
                        }
                    }
                }
            }



            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && ($params->ids != '')) $where .= 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->enabled) && ($params->enabled != '*')) {
                $where .= 'AND `' . $this->dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
            }
            if (isset($params->deleted) && ($params->deleted == '*')) {
                if ($where != '') $where = 'WHERE 1 ' . $where;
            } else {
                $where = 'WHERE `' . $this->dbtable . '`.`deleted` = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;
            }



            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);



            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $this->dbtable . '`.* '
                   . 'FROM `' . $this->dbtable . '` '
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
        //   [$params->escorted] = признак "с заданным сопровождаемым URL"
        //   [$params->enabled] = признак "разрешена" запись:
        //                            0 = запрещенная
        //                            1 = разрешенная
        //                            * = в любом состоянии (эквивалентно отсутствию параметра)
        //   [$params->deleted] = признак "удалена" запись:
        //                            0 = не удаленная (эквивалентно отсутствию параметра)
        //                            1 = удаленная
        //                            * = в любом состоянии
        //   [$params->name] = название (поисковая фраза)
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
                if (isset($params->enabled) && ($params->enabled != '*')) {
                    $where .= 'AND `' . $this->dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
                }
                if (isset($params->escorted)) $where .= 'AND REPLACE(REPLACE(`' . $this->dbtable . '`.`escort_url`, \' \', \'\'),  \'/\', \'\') != \'\' ';
                if (isset($params->deleted) && ($params->deleted == '*')) {
                    if ($where != '') $where = 'WHERE 1 ' . $where;
                } else {
                    $where = 'WHERE `' . $this->dbtable . '`.`deleted` = \'' . (isset($params->deleted) ? $this->cms->db->query_value($params->deleted) : 0) . '\' ' . $where;
                }



                // делаем запрос
                $query = 'SELECT `' . $this->dbtable . '`.* '
                       . 'FROM `' . $this->dbtable . '` '
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
                        $options = array(REQUEST_PARAM_NAME_SECTION => 'SearchEscorts',
                                         REQUEST_PARAM_NAME_ITEMID => $item->$id,
                                         REQUEST_PARAM_NAME_TOKEN => $params->token);
                        if (isset($params->sort)) $options[REQUEST_PARAM_NAME_SORT] = $params->sort;



                        // создаем ссылку "удалить"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                        $item->delete_get = $this->cms->form_get($options);



                        // создаем ссылку "разрешена"
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_ENABLED;
                        $item->enable_get = $this->cms->form_get($options);



                        // создаем ссылку "создать копию"
                        $options[REQUEST_PARAM_NAME_SECTION] = 'SearchEscort';
                        $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COPY;
                        $item->copy_get = $this->cms->form_get($options);



                        // создаем ссылку "редактировать"
                        unset($options[REQUEST_PARAM_NAME_ACTION]);
                        $options[REQUEST_PARAM_NAME_SECTION] = 'SearchEscort';
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
                $this->prepareField($item, 'escort_url',    'string',  $fields, $values);
                $this->prepareField($item, 'target_url',    'string',  $fields, $values);
                $this->prepareField($item, 'referer',       'string',  $fields, $values);
                $this->prepareField($item, 'browsed',       'natural', $fields, $values);
                $this->prepareField($item, 'enabled',       'boolean', $fields, $values);
                $this->prepareField($item, 'deleted',       'boolean', $fields, $values);
                $this->prepareField($item, 'created',       'date',    $fields, $values);
                $this->prepareField($item, 'modified',      'date',    $fields, $values);

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
            if (isset($item->name)) {
            }
            if (isset($item->escort_url)) {
                $item->escort_url = ltrim($item->escort_url, '\\ /');
            }
            if (isset($item->target_url)) {
                $item->target_url = ltrim($item->target_url, '\\ /');
            }



            // поправляем адресующие поля
            $id = $this->id_field;
            if (isset($item->$id)) {
                $item->$id = intval($item->$id);
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
                $query[] = 'CHANGE `' . $this->id_field . '` `' . $this->id_field . '` BIGINT(' . DATABASE_FIELDSIZE_ID . ') NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор поисковой фразы\'';
            } else {

                // ИД фразы
                $name = $this->id_field;
                $type = 'BIGINT(' . DATABASE_FIELDSIZE_ID . ')';
                if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' NOT NULL AUTO_INCREMENT COMMENT \'Идентификатор поисковой фразы\'';
            }

            // фраза
            $name = 'name';
            $type = 'VARCHAR(' . DATABASE_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Поисковая фраза\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // сопровождаемый url
            $name = 'escort_url';
            $type = 'VARCHAR(' . DATABASE_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Сопровождаемый URL\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // предлагавшийся url
            $name = 'target_url';
            $type = 'VARCHAR(' . DATABASE_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Предлагавшийся URL\'';
            if (!$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);

            // источник трафика
            $name = 'referer';
            $type = 'VARCHAR(' . DATABASE_FIELDSIZE_NAME . ')';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'\' NOT NULL COMMENT \'Источник трафика\'';
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

            // счетчик сопровождений
            $name = 'browsed';
            $type = 'INT(11) UNSIGNED';
            if (($command = $this->cms->db->check_field($columns, $name, $type)) != '') $query[] = $command . ' `' . $name . '` ' . $type . ' DEFAULT \'0\' NOT NULL COMMENT \'Счетчик сопровождений\'';
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



        // ===================================================================
        /**
        *  Стандартизация поля name
        *
        *  @access  public
        *  @param   string  $value      исходное значение
        *  @return  string              стандартизированное
        */
        // ===================================================================

        public function standardize_name ( $value ) {
            $value = preg_replace('/[^a-z0-9а-яё\(\)\[\]\+\-]/iu', ' ', $value);
            $value = preg_replace('/([\(\)\[\]\+\-])/', ' $1 ', $value);
            $value = preg_replace('/\s+/', ' ', $value);
            $value = trim($value);
            if (preg_replace('/[^a-z0-9а-яё]/iu', '', $value) == '') $value = '';
            return $value;
        }



        // ===================================================================
        /**
        *  Стандартизация поля escort_url
        *
        *  @access  public
        *  @param   string  $value      исходное значение
        *  @return  string              стандартизированное
        */
        // ===================================================================

        public function standardize_escort_url ( $value ) {
            $value = trim($value);
            $value = preg_replace('!^[a-z]+://[^/\\\\]+[/\\\\]!i', '', $value);
            $value = ltrim($value, '\\ /:');
            return $value;
        }



        // ===================================================================
        /**
        *  Стандартизация поля target_url
        *
        *  @access  public
        *  @param   string  $value      исходное значение
        *  @return  string              стандартизированное
        */
        // ===================================================================

        public function standardize_target_url ( $value ) {
            return $this->standardize_escort_url($value);
        }



        // ===================================================================
        /**
        *  Стандартизация поля referer
        *
        *  @access  public
        *  @param   string  $value      исходное значение
        *  @return  string              стандартизированное
        */
        // ===================================================================

        public function standardize_referer ( $value ) {
            $value = trim($value);
            $value = preg_replace('!^[a-z]+://!i', '', $value);
            $value = preg_replace('/^(www\.\s*)+/i', '', $value);
            return trim($value, '.');
        }



        // ===================================================================
        /**
        *  Обработка поискового визита
        *
        *  @access  public
        *  @param   string  $url    адрес страницы, с которой пришел визитер
        *  @return  string          адрес страницы, куда редиректить, или пустая строка
        */
        // ===================================================================

        public function visit ( $url ) {
            $result = '';

            // если поисковое сопровождение включено
            if (isset($this->cms->settings->searches_enabled) && $this->cms->settings->searches_enabled) {

                // если задан список отслеживаемых источников
                $me = isset($_SERVER['HTTP_HOST']) ? $this->standardize_referer($_SERVER['HTTP_HOST']) : '';
                if ($me != '') {
                    if (isset($this->cms->settings->searches_referers)) {
                        $sources = trim($this->cms->settings->searches_referers);
                        $sources = preg_replace('/[ \t]/', '', $sources);
                        $sources = @ preg_split('/[\r\n]+/', $sources);
                        if (is_array($sources) && !empty($sources)) {

                            // если адрес страницы верный и с каким-то набором параметров
                            if (preg_match('!^[a-z]+://[^/]+/!i', $url)) {
                                $data = @ parse_url($url);
                                $host = isset($data['host']) ? $this->standardize_referer($data['host']) : '';
                                $path = isset($data['path']) ? trim($data['path'], '/ ') : '';
                                if (strtolower($host) != strtolower($me)) {
                                    $query = '';
                                    if (isset($data['query'])) @ parse_str($data['query'], $query);
                                } else {
                                    $query = isset($_REQUEST) ? $_REQUEST : FALSE;
                                }
                                if (($host != '') && is_array($query) && !empty($query)) {

                                    // ищем параметр в списке источников
                                    $url = strtolower($host . '/' . $path);
                                    $me = strtolower($me);
                                    foreach ($sources as $item) {
                                        $item = explode(',', $item, 2);
                                        $key = isset($item[1]) ? $item[1] : '';
                                        if (($key != '') && isset($query[$key])) {
                                            $value = $this->standardize_name($query[$key]);
                                            if ($value != '') {
                                                $item = strtolower($item[0]);
                                                $item = str_replace('[site]', $me, $item);
                                                if (substr($url, 0, strlen($item)) == $item) {

                                                    // куда был приведен посетитель
                                                    $now_url = isset($_SERVER['REQUEST_URI']) ? strtolower(trim($_SERVER['REQUEST_URI'])) : '';

                                                    // ищем такую фразу в базе
                                                    $item = null;
                                                    $params = new stdClass;
                                                    $params->name = $value;
                                                    $this->one($item, $params);
                                                    if (!empty($item)) {

                                                        // если фраза разрешена, +1 раз был такой запрос
                                                        if ($item->enabled && !$item->deleted) {
                                                            $row = new stdClass;
                                                            $row->search_id = $item->search_id;
                                                            $row->browsed = $item->browsed + 1;
                                                            $this->update($row);

                                                            // определяем необходимость редиректа (если задан и мы еще не на той странице)
                                                            $url = $this->standardize_escort_url($item->escort_url);
                                                            if (($url != '') && ($url != '-')) {
                                                                $url = '/' . $url;
                                                                if (($now_url != '') && ($now_url != strtolower($url))) $result = 'http://' . $me . $url;
                                                            }
                                                        }

                                                    // иначе надо добавить фразу
                                                    } else {
                                                        $item = new stdClass;
                                                        $item->name = $value;
                                                        $item->escort_url = '';
                                                        $item->target_url = $this->standardize_target_url($now_url);
                                                        $item->referer = $host;
                                                        $item->enabled = 1;
                                                        $item->deleted = 0;
                                                        $item->browsed = 1;
                                                        $item->created = time();
                                                        $this->update($item);
                                                    }
                                                    break;
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

            // возвращаем URL редиректа (или пустая строка)
            return $result;
        }
    }



    return;
?>