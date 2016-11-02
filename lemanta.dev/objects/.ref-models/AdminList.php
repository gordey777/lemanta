<?php
    // макет редактируемой таблицы записей
    require_once(dirname(__FILE__) . '/AdminTable.php');



    // =======================================================================
    /**
    *  Макет редактируемого списка админпанели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AdminListREFModel extends AdminTableREFModel {



        // ===================================================================
        /**
        *  Обработка команд редактирования записей
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  void
        */
        // ===================================================================

        protected function processRecordCommands ( & $defaults = '' ) {

            // пока никаких изменений в базе данных нет,
            // по умолчанию все команды позволяют на последнем запросе отследить изменения в базе данных,
            // пока нет отмены перенаправления на страницу возврата
            $this->changed = FALSE;
            $watching = TRUE;
            $cancel = FALSE;

            // читаем входной параметр ITEMID - идентификатор оперируемой записи,
            // параметр FROM - на какую страницу вернуться после операции,
            // параметр ACTION - какую команду требовали сделать
            $id = trim($this->cms->param(REQUEST_PARAM_NAME_ITEMID));
            $result_page = trim($this->cms->param(REQUEST_PARAM_NAME_FROM));
            $act = trim($this->cms->param(REQUEST_PARAM_NAME_ACTION));

            // если команда не задана, но есть пометки удаляемых изображений, считаем что была команда "Удалить изображение"
            if (!empty($id) && ($act == '')) {
                if (isset($_POST['imagedelete'][$id]) && is_array($_POST['imagedelete'][$id])) {
                    foreach ($_POST['imagedelete'][$id] as $index => $item) {
                        if ($item) {
                            $act = ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE;
                            break;
                        }
                    }
                }
            }

            // если получена команда дислокатора
            if ((isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE]) && is_array($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE]))
            || (isset($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE_FILTER]) && is_array($_POST[REQUEST_PARAM_NAME_POST_AS_DISLOCATE_FILTER]))) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->checkToken();

                // TODO: создать метод $cancel = dislocateRecords()
            }

            // если действительно передали идентификатор оперируемой записи или это команда "Удалить помеченные записи"
            if (!empty($id) || ($act == ACTION_REQUEST_PARAM_VALUE_MASSDELETE)) {

                // создаем пустой массив для запросов
                $query = array();

                // какую команду требовали сделать во входном параметре ACTION?
                if (is_array($this->my_actions) && in_array($act, $this->my_actions)) {
                    switch ($act) {

                        // если команду "Разрешить / запретить показ записи"
                        case ACTION_REQUEST_PARAM_VALUE_ENABLED:
                            $this->checkToken();
                            $this->actionEnabled($id, $query);
                            break;

                        // если команду "Выделить / НеВыделять визуально"
                        case ACTION_REQUEST_PARAM_VALUE_HIGHLIGHTED:
                            break;

                        // если команду "Разрешить / запретить комментирование"
                        case ACTION_REQUEST_PARAM_VALUE_COMMENTED:
                            break;

                        // если команду "Скрыть / открыть для незарегистрированных пользователей"
                        case ACTION_REQUEST_PARAM_VALUE_HIDDEN:
                            break;

                        // если команду "Разрешить / запретить собственный субдомен"
                        case ACTION_REQUEST_PARAM_VALUE_DOMAINED:
                            break;

                        // если команду "Считать / не считать хитом продаж"
                        case ACTION_REQUEST_PARAM_VALUE_HIT:
                            break;

                        // если команду "Считать / не считать новинкой"
                        case ACTION_REQUEST_PARAM_VALUE_NEWEST:
                            break;

                        // если команду "Считать / не считать акционным"
                        case ACTION_REQUEST_PARAM_VALUE_ACTIONAL:
                            break;

                        // если команду "Считать / не считать ожидаемым скоро в продаже"
                        case ACTION_REQUEST_PARAM_VALUE_AWAITED:
                            break;

                        // если команду "Считать по умолчанию для клиентской стороны"
                        case ACTION_REQUEST_PARAM_VALUE_DEFAULT:
                            break;

                        // если команду "Считать по умолчанию для админпанели"
                        case ACTION_REQUEST_PARAM_VALUE_DEFAULTA:
                            break;

                        // если команду "Считать базовой"
                        case ACTION_REQUEST_PARAM_VALUE_MAIN:
                            break;

                        // если команду "Считать / не считать разрешенным в Яндекс.Маркет"
                        case ACTION_REQUEST_PARAM_VALUE_YMARKET:
                            break;

                        // если команду "Считать / не считать разрешенным в ВКонтакте"
                        case ACTION_REQUEST_PARAM_VALUE_VKONTAKTE:
                            break;

                        // если команду "Считать заказ новым"
                        case ACTION_REQUEST_PARAM_VALUE_COMING:
                            break;

                        // если команду "Считать заказ находящимся в обработке"
                        case ACTION_REQUEST_PARAM_VALUE_PROCESSING:
                            break;

                        // если команду "Считать заказ выполненным"
                        case ACTION_REQUEST_PARAM_VALUE_DONE:
                            break;

                        // если команду "Считать заказ аннулированным"
                        case ACTION_REQUEST_PARAM_VALUE_CANCELED:
                            break;

                        // если команду "Считать заказ оплаченным"
                        case ACTION_REQUEST_PARAM_VALUE_PAYMENT:
                            break;

                        // если команду "Поднять выше"
                        case ACTION_REQUEST_PARAM_VALUE_MOVEUP:
                            break;

                        // если команду "Опустить ниже"
                        case ACTION_REQUEST_PARAM_VALUE_MOVEDOWN:
                            break;

                        // если команду "Поставить первым"
                        case ACTION_REQUEST_PARAM_VALUE_MOVEFIRST:
                            break;

                        // если команду "Поставить последним"
                        case ACTION_REQUEST_PARAM_VALUE_MOVELAST:
                            break;

                        // если команду "Удалить помеченные записи"
                        case ACTION_REQUEST_PARAM_VALUE_MASSDELETE:

                            // создаем массив идентификаторов удаляемых элементов
                            $items = array();
                            if (isset($_POST[REQUEST_PARAM_NAME_DELETEIDS]) && is_array($_POST[REQUEST_PARAM_NAME_DELETEIDS])) {
                                foreach ($_POST[REQUEST_PARAM_NAME_DELETEIDS] as $item) {
                                    $items[$item] = '\'' . $this->cms->db->query_value($item) . '\'';
                                }
                            }

                            // здесь не прерываем case, чтобы попасть в следующий case

                        // если команду "Удалить запись"
                        case ACTION_REQUEST_PARAM_VALUE_DELETE:
                            $this->checkToken();
                            if (!isset($items)) $items = null;
                            $watching = $this->actionDelete($id, $items, $query);
                            break;

                        // если команду "Удалить изображение"
                        case ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE:
                            break;

                        // если команду "Удалить файл"
                        case ACTION_REQUEST_PARAM_VALUE_DELETEFILE:
                            break;
                    }
                }

                // если получен набор запросов, то есть готовы выполнить операцию,
                //   проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
                //   делаем все запросы операции,
                //   если для команды не снято отслеживание изменений в базе данных, делаем его оценкой затронутых записей
                //   если страница возврата не указана, используем рекомендуемую страницу возврата
                if (!empty($query)) {
                    $this->checkToken();
                    foreach ($query as & $command) $this->cms->db->query($command);
                    if ($watching) $this->changed = $this->changed || ($this->cms->db->affected_rows() > 0);
                    if (($result_page == '') && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
                }
            }

            // обрабатываем редакторские изменения в записях
            $cancel = $this->processRecordEdit($result_page) | $cancel;

            // если произошли изменения в базе данных, очищаем соответствующие кеш-таблицы
            if ($this->changed) $this->resetCaches();

            // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
            if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
        }



        // ===================================================================
        /**
        *  Контроль состояния отредактированной записи
        *
        *  @access  protected
        *  @param   object  $record     объект записи
        *  @param   string  $title1     заголовок 1 (для новой записи)
        *  @param   string  $title2     заголовок 2 (для редактируемой записи)
        *  @param   string  $title3     заголовок 3 (для копии записи)
        *  @return  string              соответствующий случаю текст заголовка
        */
        // ===================================================================

        protected function controlRecordState ( & $record = null, $title1, $title2, $title3 ) {

            // имя модели базы данных
            $model = $this->getDBModel();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->cms->param(REQUEST_PARAM_NAME_ITEMID));

            // устанавливаем заголовок страницы,
            // если нет данных записи или они изменились,
            //   читаем их из базы данных
            $title = ADMIN_PAGE_TITLE_PREFIX . $title1;
            if ((empty($record) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $params->deleted = '*';
                $this->cms->db->$model->one($record, $params);
            }

            // если данные записи получены,
            //   меняем заголовок страницы
            if (!empty($record)) {
                $name = $this->getRecordName($record);
                $title = ADMIN_PAGE_TITLE_PREFIX . $title2 . $name . (substr($title2, -1) == '"' ? '"' : '');

                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) {
                    $this->cms->db->$model->unpack($record);
                }

                // если это команда "Создать копию", деидентифицируем запись
                if (trim($this->cms->param(REQUEST_PARAM_NAME_ACTION)) == ACTION_REQUEST_PARAM_VALUE_COPY) {
                    $title = ADMIN_PAGE_TITLE_PREFIX . $title3 . $name . (substr($title3, -1) == '"' ? '"' : '');
                    $this->unIdentifyRecord($record);
                }

            // иначе нет данных, инициируем важные поля новой записи
            } else {
                $this->initRecord($record);
            }

            // возвращаем текст заголовка
            return $title;
        }



        // ===================================================================
        /**
        *  Извлечение названия записи
        *
        *  @access  public
        *  @param   object  $record     объект записи
        *  @return  string              название
        */
        // ===================================================================

        public function getRecordName ( & $record = null ) {
            return 'Без названия!';
        }



        // ===================================================================
        /**
        *  Инициализация важных полей новой записи
        *
        *  @access  public
        *  @param   object  $record     объект записи
        *  @return  void
        */
        // ===================================================================

        public function initRecord ( & $record = null ) {
            if (!is_object($record)) $record = new stdClass;
        }



        // ===================================================================
        /**
        *  Деидентификация записи (подготовка для копии)
        *
        *  @access  public
        *  @param   object  $record     объект записи
        *  @return  void
        */
        // ===================================================================

        public function unIdentifyRecord ( & $record = null ) {
            $id = $this->id_field;
            $record->$id = 0;
        }



        // ===================================================================
        /**
        *  Создание значений по умолчанию некоторых элементов html-формы
        *
        *  @access  public
        *  @return  object              объект значений
        */
        // ===================================================================

        public function createDefaults () {
            $defaults = new stdClass;
            $defaults->param = 'admin_' . $this->getDBModel();
            $defaults->sort = 1;
            $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
            $defaults->sort_laconical = 1;
            $defaults->type = 0;
            $defaults->view_mode = VIEW_MODE_FULL;
            $defaults->filter_manually = 0;
            return $defaults;
        }



        // ===================================================================
        /**
        *  Уточнение выбранного вида сортировки
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  mixed                   уточненное значение
        */
        // ===================================================================

        protected function recognizeSort ( & $defaults = '' ) {

            // ставим значение по умолчанию для случая отсутствия параметра
            $result = isset($defaults->sort) ? $defaults->sort : '';

            // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
            if (isset($defaults->param)) {
                $param = $defaults->param . SORT_PARAM_PARTNAME;
                if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT])) {
                    $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
                    $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT];
                } else {
                    if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
                }

                // извлекаем параметр из сеанса
                if (isset($_SESSION[$param])) {
                    $value = trim($_SESSION[$param]);
                    if ($value != '') {
                        $result = $value;
                        @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }

            // возвращаем значение параметра
            return $result;
        }



        // ===================================================================
        /**
        *  Уточнение выбранного направления сортировки
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  mixed                   уточненное значение
        */
        // ===================================================================

        protected function recognizeSortDirection ( & $defaults = '' ) {

            // ставим значение по умолчанию для случая отсутствия параметра
            $result = isset($defaults->sort_direction) ? $defaults->sort_direction : SORT_DIRECTION_DESCENDING;

            // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
            if (isset($defaults->param)) {
                $param = $defaults->param . SORT_DIRECTION_PARAM_PARTNAME;
                if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT_DIRECTION])) {
                    $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_DIRECTION];
                    $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_DIRECTION];
                } else {
                    if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
                }

                // извлекаем параметр из сеанса
                if (isset($_SESSION[$param])) {
                    $value = trim($_SESSION[$param]);
                    if ($value != '') {
                        $result = $value;
                        @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }

            // возвращаем значение параметра
            return $result;
        }



        // ===================================================================
        /**
        *  Уточнение выбранной лаконичности сортировки
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  mixed                   уточненное значение
        */
        // ===================================================================

        protected function recognizeSortLaconical ( & $defaults = '' ) {

            // ставим значение по умолчанию для случая отсутствия параметра
            $result = isset($defaults->sort_laconical) ? $defaults->sort_laconical : 1;

            // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
            if (isset($defaults->param)) {
                $param = $defaults->param . SORT_LACONICAL_PARAM_PARTNAME;
                if (isset($_REQUEST[REQUEST_PARAM_NAME_SORT_LACONICAL])) {
                    $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_LACONICAL];
                    $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_SORT_LACONICAL];
                } else {
                    if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
                }

                // извлекаем параметр из сеанса
                if (isset($_SESSION[$param])) {
                    $value = trim($_SESSION[$param]);
                    if ($value != '') {
                        $result = $value;
                        @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }

            // возвращаем значение параметра
            return $result;
        }



        // ===================================================================
        /**
        *  Уточнение выбранного типа записей
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  mixed                   уточненное значение
        */
        // ===================================================================

        protected function recognizeType ( & $defaults = '' ) {

            // ставим значение по умолчанию для случая отсутствия параметра
            $result = isset($defaults->type) ? $defaults->type : '';

            // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
            if (isset($defaults->param)) {
                $param = $defaults->param . TYPE_PARAM_PARTNAME;
                if (isset($_REQUEST[REQUEST_PARAM_NAME_TYPE])) {
                    $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_TYPE];
                    $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_TYPE];
                } else {
                    if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
                }

                // извлекаем параметр из сеанса
                if (isset($_SESSION[$param])) {
                    $value = trim($_SESSION[$param]);
                    if ($value != '') {
                        $result = $value;
                        @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }

            // возвращаем значение параметра
            return $result;
        }



        // ===================================================================
        /**
        *  Уточнение выбранного режима отображения записей
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  mixed                   уточненное значение
        */
        // ===================================================================

        protected function recognizeViewMode ( & $defaults = '' ) {

            // ставим значение по умолчанию для случая отсутствия параметра
            $result = isset($defaults->view_mode) ? $defaults->view_mode : VIEW_MODE_STANDARD;

            // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
            if (isset($defaults->param)) {
                $param = $defaults->param . VIEW_MODE_PARAM_PARTNAME;
                if (isset($_REQUEST[REQUEST_PARAM_NAME_VIEW_MODE])) {
                    $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_VIEW_MODE];
                    $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_VIEW_MODE];
                } else {
                    if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
                }

                // извлекаем параметр из сеанса
                if (isset($_SESSION[$param])) {
                    $value = trim($_SESSION[$param]);
                    if ($value != '') {
                        $result = $value;
                        @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }

            // возвращаем значение параметра
            return $result;
        }



        // ===================================================================
        /**
        *  Уточнение выбранной автоматизации фильтра записей
        *
        *  @access  protected
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  mixed                   уточненное значение
        */
        // ===================================================================

        protected function recognizeFilterManually ( & $defaults = '' ) {

            // ставим значение по умолчанию для случая отсутствия параметра
            $result = isset($defaults->filter_manually) ? $defaults->filter_manually : 0;

            // если параметр пришел в запросе, или иначе если он есть в cookie и отсутствует в сеансе, сохраняем параметр в сеансе
            if (isset($defaults->param)) {
                $param = $defaults->param . FILTER_MANUALLY_PARAM_PARTNAME;
                if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MANUALLY])) {
                    $_COOKIE[$param] = $_REQUEST[REQUEST_PARAM_NAME_FILTER_MANUALLY];
                    $_SESSION[$param] = $_REQUEST[REQUEST_PARAM_NAME_FILTER_MANUALLY];
                } else {
                    if (!isset($_SESSION[$param]) && isset($_COOKIE[$param])) $_SESSION[$param] = $_COOKIE[$param];
                }

                // извлекаем параметр из сеанса
                if (isset($_SESSION[$param])) {
                    $value = trim($_SESSION[$param]);
                    if ($value != '') {
                        $result = $value;
                        @ setcookie($param, $value, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }

            // возвращаем значение параметра
            return $result;
        }



        // ===================================================================
        /**
        *  Сбор параметров html-формы
        *
        *  @access  protected
        *  @param   object  $inputs         настоящие значения некоторых элементов html-формы (будут возвращены в эту переменную)
        *  @param   object  $params         параметры фильтра (будут возвращены в эту переменную)
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  void
        */
        // ===================================================================

        protected function collectInputs ( & $inputs, & $params, & $defaults ) {
            parent::collectInputs($inputs, $params, $defaults);

            // собираем параметры сортировки (метод)
            $params->sort = $this->recognizeSort($defaults);
            $inputs[REQUEST_PARAM_NAME_SORT] = $params->sort;

            // собираем параметры сортировки (направление)
            $params->sort_direction = $this->recognizeSortDirection($defaults);
            $inputs[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;

            // собираем параметры сортировки (лаконичный режим)
            $params->sort_laconical = $this->recognizeSortLaconical($defaults);
            $inputs[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;

            // собираем параметры селекции (тип)
            $params->type = $this->recognizeType($defaults);
            $inputs[REQUEST_PARAM_NAME_TYPE] = $params->type;

            // собираем параметры отображения (режим)
            $params->view_mode = $this->recognizeViewMode($defaults);
            $inputs[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;

            // собираем параметры фильтра (ручной запуск)
            $params->filter_manually = $this->recognizeFilterManually($defaults);
            $inputs[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;

            // собираем параметры фильтра (страна)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_COUNTRY])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_COUNTRY]);
                if ($value != '') $params->country_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_COUNTRY] = $value;
            }

            // собираем параметры фильтра (область)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_REGION])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_REGION]);
                if ($value != '') $params->region_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_REGION] = $value;
            }

            // собираем параметры фильтра (город)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_TOWN])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_TOWN]);
                if ($value != '') $params->town_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_TOWN] = $value;
            }

            // собираем параметры фильтра (учебное заведение)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SCHOOL])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SCHOOL]);
                if ($value != '') $params->school_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_SCHOOL] = $value;
            }

            // собираем параметры фильтра (класс учебного заведения)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CLASS])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CLASS]);
                if ($value != '') $params->class_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_CLASS] = $value;
            }

            // собираем параметры фильтра (предмет учебного заведения)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_LESSON])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_LESSON]);
                if ($value != '') $params->lesson_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_LESSON] = $value;
            }

            // собираем параметры фильтра (день)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DAY])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DAY]);
                if ($value != '') $params->day = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_DAY] = $value;
            }

            // собираем параметры фильтра (месяц)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MONTH])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MONTH]);
                if ($value != '') $params->month = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_MONTH] = $value;
            }

            // собираем параметры фильтра (год)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_YEAR])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_YEAR]);
                if ($value != '') $params->year = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_YEAR] = $value;
            }

            // собираем параметры фильтра (категория)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY]);
                if ($value != '') $params->category_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $value;
            }

            // собираем параметры фильтра (бренд)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_BRAND]);
                if ($value != '') $params->brand_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_BRAND] = $value;
            }

            // собираем параметры фильтра (склад)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_STOCK])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_STOCK]);
                if ($value != '') $params->stock_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_STOCK] = $value;
            }

            // собираем параметры фильтра (админ)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_USER]);
                if ($value != '') $params->user_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_USER] = $value;
            }

            // собираем параметры фильтра (партнер)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PARTNER])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PARTNER]);
                if ($value != '') $params->affiliate_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_PARTNER] = $value;
            }

            // собираем параметры фильтра (группа)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_GROUP])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_GROUP]);
                if ($value != '') $params->group_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_GROUP] = $value;
            }

            // собираем параметры фильтра (ценовая группа)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PRICEGROUP])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PRICEGROUP]);
                if ($value != '') $params->price_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_PRICEGROUP] = $value;
            }

            // собираем параметры фильтра (раздел)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SECTION]);
                if ($value != '') $params->section = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_SECTION] = $value;
            }

            // собираем параметры фильтра (меню)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_MENU]);
                if ($value != '') $params->menu_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_MENU] = $value;
            }

            // собираем параметры фильтра (хит продаж)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIT])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIT]);
                if ($value != '') $params->hit = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_HIT] = $value;
            }

            // собираем параметры фильтра (новинка)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWEST])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWEST]);
                if ($value != '') $params->newest = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_NEWEST] = $value;
            }

            // собираем параметры фильтра (акционный)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ACTIONAL])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ACTIONAL]);
                if ($value != '') $params->actional = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_ACTIONAL] = $value;
            }

            // собираем параметры фильтра (скоро в продаже)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_AWAITED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_AWAITED]);
                if ($value != '') $params->awaited = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_AWAITED] = $value;
            }

            // собираем параметры фильтра (экспорт Яндекс.Маркет)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_YMARKET])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_YMARKET]);
                if ($value != '') $params->ymarket = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_YMARKET] = $value;
            }

            // собираем параметры фильтра (экспорт ВКонтакте)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_VKONTAKTE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_VKONTAKTE]);
                if ($value != '') $params->vkontakte = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_VKONTAKTE] = $value;
            }

            // собираем параметры фильтра (завершена)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DONE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DONE]);
                if ($value != '') $params->done = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_DONE] = $value;
            }

            // собираем параметры фильтра (разрешена)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ENABLED]);
                if ($value != '') $params->enabled = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_ENABLED] = $value;
            }

            // собираем параметры фильтра (удалена)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELETED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELETED]);
                if ($value != '') $params->deleted = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_DELETED] = $value;
            }

            // собираем параметры фильтра (скрыта от чужих)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_HIDDEN]);
                if ($value != '') $params->hidden = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_HIDDEN] = $value;
            }

            // собираем параметры фильтра (обсуждаема)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_COMMENTED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_COMMENTED]);
                if ($value != '') $params->commented = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_COMMENTED] = $value;
            }

            // собираем параметры фильтра (не для rss)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTRSS]);
                if ($value != '') $params->rss_disabled = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_NOTRSS] = $value;
            }

            // собираем параметры фильтра (не для экспорта)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NOTEXPORT]);
                if ($value != '') $params->export_disabled = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_NOTEXPORT] = $value;
            }

            // собираем параметры фильтра (не для кредита)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE]);
                if ($value != '') $params->non_creditable = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_NONCREDITABLE] = $value;
            }

            // собираем параметры фильтра (не для продажи)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONUSABLE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NONUSABLE]);
                if ($value != '') $params->non_usable = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_NONUSABLE] = $value;
            }

            // собираем параметры фильтра (с картинками)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_IMAGED]);
                if ($value != '') $params->imaged = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_IMAGED] = $value;
            }

            // собираем параметры фильтра (с файлами)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_FILED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_FILED]);
                if ($value != '') $params->filed = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_FILED] = $value;
            }

            // собираем параметры фильтра (с SEO текстом)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEOED]);
                if ($value != '') $params->SEOed = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_SEOED] = $value;
            }

            // собираем параметры фильтра (с особым url)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_URLSPECIAL]);
                if ($value != '') $params->url_special = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_URLSPECIAL] = $value;
            }

            // собираем параметры фильтра (с модулями)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_OBJECTED]);
                if ($value != '') $params->objected = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_OBJECTED] = $value;
            }

            // собираем параметры фильтра (имеет субдомен)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DOMAINED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DOMAINED]);
                if ($value != '') $params->domained = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_DOMAINED] = $value;
            }

            // собираем параметры фильтра (имеет связанные статьи)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_ARTICLED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_ARTICLED]);
                if ($value != '') $params->articled = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_ARTICLED] = $value;
            }

            // собираем параметры фильтра (имеет связанные новости)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWSED])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_NEWSED]);
                if ($value != '') $params->newsed = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_NEWSED] = $value;
            }

            // собираем параметры фильтра (искомая строка)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCH])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCH]);
                if ($value != '') $params->search = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_SEARCH] = $value;
            }

            // собираем параметры фильтра (искомая цена от)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM]);
                if ($this->number->floatValue($value) != 0) {
                    if (!isset($rate)) $rate = $this->currency->rate();
                    $params->search_cost_from = $this->number->floatValue($value) * $rate;
                }
                $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM] = $value;
            }

            // собираем параметры фильтра (искомая цена до)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO]);
                if ($this->number->floatValue($value) != 0) {
                    if (!isset($rate)) $rate = $this->currency->rate();
                    $params->search_cost_to = $this->number->floatValue($value) * $rate;
                }
                $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO] = $value;
            }

            // собираем параметры фильтра (искомая дата от)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM]);
                if ($value != '') {
                    $value = $this->fixDateValue($value);
                    if (is_int($value)) $value = date('Y-m-d', $value);
                    $value = substr($value, 0, 10);
                    if ($value == '0000-00-00') $value = '';
                    if ($value != '') $params->search_date_from = $value;
                }
                $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM] = $value;
            }

            // собираем параметры фильтра (искомая дата до)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO]);
                if ($value != '') {
                    $value = $this->fixDateValue($value);
                    if (is_int($value)) $value = date('Y-m-d', $value);
                    $value = substr($value, 0, 10);
                    if ($value == '0000-00-00') $value = '';
                    if ($value != '') $params->search_date_to = $value;
                }
                $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO] = $value;
            }

            // собираем параметры фильтра (способ доставки)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELIVERY])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DELIVERY]);
                if ($value != '') $params->delivery_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_DELIVERY] = $value;
            }

            // собираем параметры фильтра (способ оплаты)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYMENT])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYMENT]);
                if ($value != '') $params->payment_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_PAYMENT] = $value;
            }

            // собираем параметры фильтра (состояние оплаты)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYSTATUS])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_PAYSTATUS]);
                if ($value != '') $params->payment_status = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_PAYSTATUS] = $value;
            }

            // собираем параметры фильтра (оформляемые в кредит)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CREDITABLE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CREDITABLE]);
                if ($value != '') $params->creditable = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_CREDITABLE] = $value;
            }

            // собираем параметры фильтра (реферал)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_AFFILIATE])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_AFFILIATE]);
                if ($value != '') $params->affiliate_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_AFFILIATE] = $value;
            }
        }



        // ===================================================================
        /**
        *  Установка параметров для навигатора страниц
        *
        *  @access  public
        *  @param   object  $inputs         настоящие значения некоторых элементов html-формы
        *  @param   object  $params         собранные параметры фильтра
        *  @return  void
        */
        // ===================================================================

        public function setNavigatorParams ( & $inputs, & $params ) {
            if (isset($params->sort)) $this->cms->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
            if (isset($params->sort_direction)) $this->cms->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
            if (isset($params->sort_laconical)) $this->cms->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
            if (isset($params->type)) $this->cms->params[REQUEST_PARAM_NAME_TYPE] = $params->type;
            if (isset($params->view_mode)) $this->cms->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
            if (isset($params->filter_manually)) $this->cms->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
        }



        // ===================================================================
        /**
        *  Чтение записей таблицы
        *
        *  @access  protected
        *  @param   mixed   $data       дополнительные сведения
        *  @return  array               массив записей
        */
        // ===================================================================

        protected function getRecords ( & $data = null ) {

            // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $inputs = null;
            $params = null;
            $this->collectInputs($inputs, $params, $data);

            // читаем список записей на текущей странице согласно параметрам фильтра и сортировки
            $items = null;
            $current_page = intval($this->cms->param(REQUEST_PARAM_NAME_PAGE));
            $params->start = $current_page * $this->items_per_page;
            $params->maxcount = $this->items_per_page;
            $model = $this->getDBModel();
            $count = $this->cms->db->$model->get($items, $params);
            $this->cms->db->$model->unpackRecords($items);

            // создаем контент листания страниц
            $this->setNavigatorParams($inputs, $params);
            $pages_num = $count / $this->items_per_page;
            $navigator = new PagesNavigation($this->cms);
            $navigator->make($pages_num, $count);

            // добавляем в записи оперативные ссылки админпанели
            $params->token = $this->cms->token;
            $this->cms->db->$model->operable($items, $params);

            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->cms->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);

            // возвращаем список записей
            return $items;
        }



        // ===================================================================
        /**
        *  Визуализация данных (результирующего контента)
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetch ( & $parent = null ) {

            // если в настройках сайта задано свое количество "сколько записей размещать на странице"
            $model = $this->getDBModel();
            $field = $model . '_num_admin';
            if (isset($this->cms->settings->$field) && !empty($this->cms->settings->$field)) {
                $this->items_per_page = intval($this->cms->settings->$field);
            }
            if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
            if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

            // задаем значения по умолчанию некоторых элементов html-формы
            $defaults = & $this->createDefaults();

            // обрабатываем редактирование настроек модуля
            $this->processSetup();

            // обрабатываем команды редактирования записей
            $this->processRecordCommands($defaults);

            // читаем записи
            $this->items = & $this->getRecords($defaults);

            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEMS, $this->items);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);

            // наполняем другие переменные и передаем в шаблонизатор
            $this->fillVariables();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);

            // уничтожаем ненужные переменные в шаблонизаторе
            $this->destroyVariables();
            return TRUE;
        }



        // ===================================================================
        /**
        *  Визуализация данных (результирующего контента) для редактирования
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetchEdit ( & $parent = null ) {

            // если в запросе есть параметр FROM (страница возврата из операции),
            // запоминаем его, передаем в шаблонизатор и убираем из запроса
            $result_page = trim($this->cms->param(REQUEST_PARAM_NAME_FROM));
            if ($result_page != '') {
                $this->result_page = & $result_page;
                $this->cms->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->cms->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }

            // обрабатываем редактирование настроек модуля
            $this->processSetup();

            // обрабатываем команды редактирования записей
            $this->processRecordCommands();

            // наполняем другие переменные и передаем в шаблонизатор
            $this->fillVariables();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);

            // уничтожаем ненужные переменные в шаблонизаторе
            $this->destroyVariables();
            return TRUE;
        }



        // ===================================================================
        /**
        *  Уничтожение ненужных более переменных в шаблонизаторе
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function destroyVariables () {
            parent::destroyVariables();
                // переменную SMARTY_VAR_FORM_INPUTS_VALUES не уничтожаем, чтобы была доступна в admin_page.htm
            $this->cms->smarty->clearAssign(SMARTY_VAR_NAVIGATOR_CONTENT);
            $this->cms->smarty->clearAssign(SMARTY_VAR_ITEMS_PER_PAGE);
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_ENABLED
        *
        *  @access  protected
        *  @param   integer $id         идентификатор записи
        *  @param   array   $query      массив рекомендуемых MySQL-запросов (будет возвращен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function actionEnabled ( $id, & $query = array() ) {
            $query[] = 'UPDATE `' . $this->dbtable . '` '
                     . 'SET `enabled` = 1 - `enabled` '
                     . 'WHERE `' . $this->id_field . '` = \'' . $this->cms->db->query_value($id) . '\';';
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_DELETE
        *
        *  @access  protected
        *  @param   integer $id         идентификатор записи
        *  @param   array   $items      массив идентификаторов записей
        *  @param   array   $query      массив рекомендуемых MySQL-запросов (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если и дальше предполагается отслеживать изменения в базе данных
        */
        // ===================================================================

        protected function actionDelete ( $id, & $items = null, & $query = array() ) {

            // если не существует массив идентификаторов удаляемых элементов,
            // создаем этот массив и передаем в него идентификатор оперируемой записи
            if (!is_array($items)) {
                $items = array();
                if (!empty($id)) $items[$id] = '\'' . $this->cms->db->query_value($id) . '\'';
            }

            // если есть что удалять
            if (!empty($items)) {

                // удаляем записи (помечаем удаленными)
                $ids = implode(',', $items);
                $query = 'UPDATE `' . $this->dbtable . '` '
                       . 'SET `deleted` = 1 '
                       . 'WHERE `' . $this->id_field . '` IN (' . $ids . ');';
                $this->cms->db->query($query);

                // выясняем наличие изменений в базе данных
                $this->changed = $this->cms->db->affected_rows() > 0;
                // команда уже не требует выполнять запросы
                $query = array();

                // для этой команды отслеживать изменения в базе данных уже не нужно
                return FALSE;
            }

            // иначе предполагаем отслеживать изменения в базе данных
            return TRUE;
        }
    }



    return;
?>