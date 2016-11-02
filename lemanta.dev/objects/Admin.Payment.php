<?php
    // =======================================================================
    /**
    *  Админ модуль редактирования способа оплаты
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // имя файла шаблона для данного модуля
    define('ADMIN_PAYMENT_METHOD_CLASS_TEMPLATE_FILE', 'admin_payment.htm');

    // какая страница возврата рекомендуется для модуля страницы способа оплаты
    define('ADMIN_PAYMENT_METHOD_CLASS_RESULT_PAGE', 'index.php?section=Payments');

    // TODO: выделить базовую обертку работы со списком записей



    // =======================================================================
    /**
    *  Админ модуль редактирования способа оплаты
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Payment {

        // объект движка
        public $cms = null;

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = DATABASE_PAYMENT_METHODS_TABLENAME;
        protected $id_field = 'payment_method_id';

        // имя модели базы данных
        protected $dbmodel = 'payments';

        // рекомендуемая страница возврата после операции
        protected $result_page = ADMIN_PAYMENT_METHOD_CLASS_RESULT_PAGE;

        // в какую папку выгружать изображения
        protected $upload_folder = '';

        // оперируемая запись
        protected $item = null;

        // признак "Запись изменена (отредактирована)"
        public $changed = FALSE;

        // заголовок страницы, мета описание, мета ключевые слова
        public $title = '';
        public $description = '';
        public $keywords = '';

        // отрисованный контент страницы
        public $body = '';

        // url файла фонового звука страницы
        public $bgsound = '';

        // текст информационного сообщения
        public $info_msg = '';

        // текст сообщения об ошибке
        public $error_msg = '';

        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array();

        // имя файла шаблона
        protected $template = ADMIN_PAYMENT_METHOD_CLASS_TEMPLATE_FILE;

        // признак "Модуль рисовать без внешнего оформления страницы"
        public $single = FALSE;



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $cms        объект вышестоящего движка
        *  @param   object  $owner      объект владельца модуля
        *  @param   string  $gender     родовое имя (класс главенствующего модуля)
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $cms, & $owner = null, $gender = '' ) {

            // запоминаем выход на объект движка
            $this->cms = & $cms;

            // подготовительные действия
            $this->prepare();
        }



        // ===================================================================
        /**
        *  Подготовительные действия
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepare () {
        }



        // ===================================================================
        /**
        *  Добавление текста ошибки в общее сообщение об ошибке
        *
        *  @access  protected
        *  @param   string  $text     текст ошибки
        *  @param   string  $divider  разделитель сообщений
        *  @return  boolean           всегда TRUE (псевдо сигнализатор ошибки)
        */
        // ===================================================================

        protected function pushError ( $text, $divider = '<br><br>' ) {
            if ($this->error_msg != '') $this->error_msg .= $divider;
            $this->error_msg .= trim($text);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Добавление текста в общее информационное сообщение
        *
        *  @access  protected
        *  @param   string  $text     текст
        *  @param   string  $divider  разделитель сообщений
        *  @return  boolean           всегда TRUE (псевдо сигнализатор сообщения)
        */
        // ===================================================================

        protected function pushInfo ( $text, $divider = '<br><br>' ) {
            if ($this->info_msg != '') $this->info_msg .= $divider;
            $this->info_msg .= trim($text);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Выправление значения поля с датой
        *
        *  @access  public
        *  @param   mixed   $date       дата в Integer или String
        *  @return  mixed               дата в Integer или строке NNNN-NN-NN NN:NN:NN
        */
        // ===================================================================

        public function fixDateValue ( $date ) {

            if (strval(intval($date)) == trim($date)) return intval($date);

            $date = trim(substr(trim($date), 0, 19));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/', $date)) return $date;

            $date = trim(substr($date, 0, 16));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}/', $date)) return $date . ':00';

            $date = trim(substr($date, 0, 13));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}/', $date)) return $date . ':00:00';

            $date = trim(substr($date, 0, 10));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $date)) return $date . ' 00:00:00';

            return '0000-00-00 00:00:00';
        }



        // ===================================================================
        /**
        *  Проверка token-аутентичности
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function checkToken () {

            // если токен запроса не совпадает с токеном сеанса
            $param = REQUEST_PARAM_NAME_TOKEN;
            if (!isset($_REQUEST[$param]) || ($_REQUEST[$param] == '')
            || !isset($_SESSION[$param]) || ($_SESSION[$param] == '')
            || ($_REQUEST[$param] !== $_SESSION[$param])) {

                // перенаправить на главную
                $this->cms->security->redirectToPage('http://' . $this->cms->root_url . '/' . $this->cms->hdd->safeFilename($this->cms->admin_folder));
            }
        }



        // ===================================================================
        /**
        *  Очистка соответствующих кеш-таблиц
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function resetCaches () {

            // безусловно очищаем нужные кеш-таблицы
            $model = $this->dbmodel;
            $this->cms->db->$model->resetCaches();
        }



        // ===================================================================
        /**
        *  Обновление записи в базе данных
        *
        *  @access  protected
        *  @param   object  $item       объект записи (обновляемые поля)
        *  @return  integer             ИД обновленной / добавленной записи
        */
        // ===================================================================

        protected function updateRecord ( & $item ) {

            // обновляем / добавляем указанную запись
            $model = $this->dbmodel;
            return $this->cms->db->$model->update($item);
        }



        // ===================================================================
        /**
        *  Уведомление участников об изменениях в записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   boolean $user       TRUE если уведомить пользователя по емейлу
        *  @param   boolean $user_sms   TRUE если уведомить пользователя по SMS
        *  @param   boolean $admin      TRUE если уведомить админа по емейлу
        *  @param   boolean $admin_sms  TRUE если уведомить админа по SMS
        *  @param   boolean $testing    TRUE если тестировать уведомление
        *  @return  void
        */
        // ===================================================================


        protected function informMembers ( & $item,
                                           $user = FALSE,
                                           $user_sms = FALSE,
                                           $admin = FALSE,
                                           $admin_sms = FALSE,
                                           $testing = FALSE ) {
        }



        // ===================================================================
        /**
        *  Обработка редактирования настроек сайта, принадлежащих данному модулю
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function processSetup () {

            // если получены данные об изменениях соответствующих настроек сайта
            if (isset($_POST[REQUEST_PARAM_NAME_SETUP])) {

                // проверяем token-аутентичность вызова модуля
                // (неаутентичных перенаправит на главную)
                $this->checkToken();

                // сохраняем настройки
                $this->cms->db->settings->saveFromPost('payments_wysiwyg_disabled',      'Способы оплаты - редактирование - запрещен ли визуальный редактор');
                $this->cms->db->settings->saveFromPost('payments_wysiwyg_disabled_mode', 'Способы оплаты - редактирование - режим обработки текста при отключенном визуальном редакторе');
                $this->cms->db->settings->saveFromPost('payments_sort_method',           'Способы оплаты - отображение - способ сортировки на стороне клиента');
                $name = 'payments_num_admin';
                    $value = isset($_POST[$name]) ? intval($_POST[$name]) : SETTINGS_DEFAULT_ITEMS_NUM_ADMIN;
                    if ($value < SETTINGS_MINIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MINIMAL_ITEMS_NUM_ADMIN;
                    if ($value > SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN) $value = SETTINGS_MAXIMAL_ITEMS_NUM_ADMIN;
                    $this->cms->db->settings->save($name, $value, 'Способы оплаты - отображение - число записей на странице админпанели');

                // очищаем соответствующие кеш-таблицы
                $this->resetCaches();

                // может пытались загрузить изображение водяного знака?
                if (isset($upload_url) && isset($upload_folder)) {
                    $this->processWatermark($upload_folder, $upload_url);
                }
            }
        }



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
                switch ($act) {

                    // если команду "Разрешить / запретить показ записи"
                    case ACTION_REQUEST_PARAM_VALUE_ENABLED:
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
                        // здесь не прерываем case, чтобы попасть в следующий case

                    // если команду "Удалить запись"
                    case ACTION_REQUEST_PARAM_VALUE_DELETE:
                        break;

                    // если команду "Удалить изображение"
                    case ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE:
                        break;

                    // если команду "Удалить файл"
                    case ACTION_REQUEST_PARAM_VALUE_DELETEFILE:
                        break;
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
            if (!$cancel && !empty($result_page)) $this->cms->security->redirectToPage($result_page);
        }



        // ===================================================================
        /**
        *  Обработка редактирования записи
        *
        *  @access  protected
        *  @param   string  $result_page    страница возврата из операции
        *  @return  void
        */
        // ===================================================================

        protected function processRecordEdit ( & $result_page = '' ) {

            // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
            $cancel = FALSE;

            // если получены данные об изменениях и нет признака отмены постинга
            if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST])
            && (!isset($_POST[REQUEST_PARAM_NAME_IGNORE_POST]) || !$_POST[REQUEST_PARAM_NAME_IGNORE_POST])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->checkToken();

                // цикл по измененным записям
                foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if (!isset($_POST[REQUEST_PARAM_NAME_POST_THISONE]) || isset($_POST[REQUEST_PARAM_NAME_POST_THISONE][$id])) {
                        $item_cancel = FALSE;
                        $value = $this->id_field;

                        // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
                        $blank_item = new stdClass;
                        $this->item = new stdClass;

                        // поле enabled (разрешена ли к показу на сайте)
                        if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI])
                        || !$_POST[REQUEST_PARAM_NAME_POST_MINI]
                        || isset($_POST['enabled'][$id])) {
                            $this->item->enabled = isset($_POST['enabled'][$id]) ? (($_POST['enabled'][$id] == 1) ? 1 : 0) : 0;
                        }

                        // поле name (название)
                        $this->processFieldName($this->item, $id, $item_cancel);

                        // поле description (описание)
                        $this->processFieldDescription($this->item, $id, $item_cancel);

                        // поле currency_id (идентификатор валюты)
                        if (isset($_POST['currency_id'][$id])) $this->item->currency_id = trim($_POST['currency_id'][$id]);

                        // поле module (название используемого модуля)
                        $module = '';
                        if (isset($_POST['module'][$id])) {
                            $module = trim($_POST['module'][$id]);
                            $this->item->module = $module;
                        }

                        // поле params (параметры платежного механизма)
                        if (isset($_POST['params'][$id])) {
                            $this->item->params = '';
                            if (($module != '') && isset($_POST['params'][$id][$module])) {
                                try {
                                    $this->item->params = @ serialize($_POST['params'][$id][$module]);
                                } catch (Exception $e) {
                                    $this->item->params = '';
                                }
                                if (!is_string($this->item->params)) $this->item->params = '';
                            }
                        }

                        // поле deliveries_ids (идентификаторы способов доставки)
                        $this->processFieldDeliveries($this->item, $id, $item_cancel);

                        // поле created (дата создания)
                        if (isset($_POST['created'][$id])) $this->item->created = $this->fixDateValue($_POST['created'][$id]);

                        // поле modified (дата изменения)
                        if (!isset($_POST[REQUEST_PARAM_NAME_POST_MINI])
                        || !$_POST[REQUEST_PARAM_NAME_POST_MINI]
                        || isset($_POST['modified'][$id])) {
                            $this->item->modified = isset($_POST['modified'][$id]) ? $this->fixDateValue($_POST['modified'][$id]) : time();
                        }

                        // поле order_num (позиция элемента среди равных в ветви)
                        if (isset($_POST['order_num'][$id])) $this->item->order_num = trim($_POST['order_num'][$id]);

                        // поле идентификатора записи
                        if (!empty($this->item) && ($this->item != $blank_item)) {
                            if (!empty($id)) {
                                // это не добавление новой записи, поэтому устанавливаем идентификатор записи
                                $this->item->$value = $id;
                            } else {
                                // если не передано значение даты создания для новой записи, ставим ее равной текущей дате
                                if (!isset($this->item->created)) $this->item->created = time();
                            }
                        }

                        // если ошибок нет (не включился признак отмены)
                        if (!$item_cancel && !empty($this->item) && ($this->item != $blank_item)) {

                            // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
                            $this->item->indifferent_caches = TRUE;
                            $changed = $this->updateRecord($this->item) != '';
                            $this->changed = $changed || $this->changed;

                            // если запись обновлена и требовали уведомить участников
                            $inform_user = isset($_POST['inform_user'][$id]) && $_POST['inform_user'][$id];
                            $inform_user_sms = isset($_POST['inform_user_sms'][$id]) && $_POST['inform_user_sms'][$id];
                            $inform_admin = isset($_POST['inform_admin'][$id]) && $_POST['inform_admin'][$id];
                            $inform_admin_sms = isset($_POST['inform_admin_sms'][$id]) && $_POST['inform_admin_sms'][$id];
                            $inform_testing = isset($_POST['inform_testing'][$id]) && $_POST['inform_testing'][$id];
                            if ($changed && ($inform_user || $inform_user_sms || $inform_admin || $inform_admin_sms)) {
                                $this->informMembers($this->item,
                                                     $inform_user,
                                                     $inform_user_sms,
                                                     $inform_admin,
                                                     $inform_admin_sms,
                                                     $inform_testing);
                            }

                            // если страница возврата не указана, используем рекомендуемую страницу
                            if (($result_page == '') && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
                        }

                        $cancel = $cancel || $item_cancel;
                    }
                }
            }

            // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
            return $cancel;
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
            $model = $this->dbmodel;

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->cms->param(REQUEST_PARAM_NAME_ITEMID));

            // устанавливаем заголовок страницы,
            // если нет данных записи или они изменились,
            //   читаем их из базы данных
            $title = ADMIN_PAGE_TITLE_PREFIX . $title1;
            if ((empty($record) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
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
            $name = isset($record->name) ? trim($record->name) : '';
            return $name != '' ? $name : 'Без названия!';
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
            $record->name = '';
            $record->module = '';
            $record->description = '';
            $record->params = '';
            $record->currency_id = 0;
            $record->enabled = 1;
            $record->deleted = 0;
            $record->modified = '0000-00-00 00:00:00';
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
            $record->name = '[Копия] ' . $this->getRecordName($record);
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

            // наполняем переменные и передаем в шаблонизатор
            $this->fillVariables();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);
        }



        // ===================================================================
        /**
        *  Наполнение переменных и передача в шаблонизатор
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function fillVariables () {

            // контролируем состояние записи
            $this->title = $this->controlRecordState($this->item,
                                                     'Новый способ оплаты',
                                                     'Редактирование способа "',
                                                     'Редактирование копии способа "');

            // проверяем распакованность поля params (параметры платежного механизма)
            if (isset($this->item->params) && is_string($this->item->params)
            && ($this->item->params != '')) {
                try {
                    $this->item->params = @ unserialize($this->item->params);
                } catch (Exception $e) {
                    $this->item->params = '';
                }
            }

            // читаем список неудаленных и незапрещенных валют
            $currencies = null;
            $params = new stdClass;
            $params->sort = SORT_CURRENCIES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->enabled = 1;
            $params->deleted = 0;
            $this->cms->db->get_currencies($currencies, $params);
            $this->cms->db->fix_currencies_records($currencies);

            // читаем список неудаленных и незапрещенных способов доставки
            $methods = null;
            $params = new stdClass;
            $params->sort = SORT_DELIVERIES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->enabled = 1;
            $params->deleted = 0;
            $this->cms->db->get_deliveries($methods, $params);
            $this->cms->db->fix_deliveries_records($methods);

            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->cms->smarty->assignByRef('Currencies', $currencies);
            $this->cms->smarty->assignByRef(SMARTY_VAR_DELIVERIES, $methods);
        }



        // ===================================================================
        /**
        *  Обработка загрузки файла водяного знака
        *
        *  @access  protected
        *  @param   string  $folder     в какую папку (относительно корня админпанели)
        *  @param   string  $filename   имя файла
        *  @return  void
        */
        // ===================================================================

        protected function processWatermark ( $folder, $filename ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('MOD ' . strtoupper($this->dbmodel) . ' processWatermark');

            $file = FALSE;
            if (isset($_FILES['watermark_filename'])) $file = & $_FILES['watermark_filename'];

            if (isset($file['name']) && ($file['name'] != '') && (($file['tmp_name'] != '') || isset($file['error']))) {

                // пробуем разобрать, что загрузили
                $url = trim($file['name']);
                if (preg_match('/^.+\.png$/i', $url)) {
                    if (($file['tmp_name'] != '') && (!isset($file['error']) || ($file['error'] == UPLOAD_ERR_OK))) {

                        // создаем папку для изображений, если ее нет (приказываем защитить папку файлом index.html)
                        $this->cms->smart_create_folder($folder, FOLDER_GUARD_MODE_VIA_INDEX);

                        // переносим в папку загруженное изображение
                        if (!move_uploaded_file($file['tmp_name'], $folder . $filename)) {
                            $this->pushError('Не удалось загрузить файл изображения '
                                           . 'водяного знака в "http://' . $this->cms->root_url
                                           . '/' . $this->cms->hdd->safeFilename($this->cms->admin_folder)
                                           . '/' . $folder . $filename . '".');
                        }

                    } else {
                        switch ($file['error']) {
                            case UPLOAD_ERR_INI_SIZE:
                                $this->pushError('Размер принятого файла "' . $url . '" превысил '
                                               . 'максимально допустимый размер, который задан '
                                               . 'директивой upload_max_filesize конфигурационного '
                                               . 'файла php.ini.');
                                break;
                            case UPLOAD_ERR_FORM_SIZE:
                                $this->pushError('Размер загружаемого файла "' . $url . '" превышает '
                                               . 'максимально допустимое значение'
                                               . (isset($_POST['MAX_FILE_SIZE']) ? ' ' . trim($_POST['MAX_FILE_SIZE']) . ' байт' : '') . '.');
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $this->pushError('Загрузка файла "' . $url . '" прервалась и он был получен не весь.');
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $this->pushError('Не получен файл "' . $url . '".');
                                break;
                            default:
                                $this->pushError('Произошла неизвестная ошибка при попытке загрузить '
                                               . 'файл изображения водяного знака "' . $url . '".');
                        }
                    }

                } else {
                    $this->pushError('Файл изображения водяного знака "' . $url . '" должен быть png файлом.');
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Обработка изменения поля NAME записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processFieldName ( & $item, $id, & $cancel = FALSE ) {
            if (isset($_POST['name'][$id])) {
                $item->name = trim($_POST['name'][$id]);
                if ($item->name == '') {
                    $cancel = $this->pushError('Не указано название способа оплаты.');
                } else {
                    $row = null;
                    $params = new stdClass;
                    if (!empty($id)) $params->exclude_id = $id;
                    $params->name = $item->name;

                    $model = $this->dbmodel;
                    $this->cms->db->$model->one($row, $params);

                    if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием способа оплаты.');
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля DESCRIPTION записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processFieldDescription ( & $item, $id, & $cancel = FALSE ) {
            if (isset($_POST['description'][$id])) {
                $item->description = trim($_POST['description'][$id]);

                $model = $this->dbmodel;
                $field = $model . '_wysiwyg_disabled';
                if (isset($this->cms->settings->$field) && $this->cms->settings->$field) {
                    $field = $model . '_wysiwyg_disabled_mode';
                    $field = isset($this->cms->settings->$field) ? $this->cms->settings->$field : FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
                    $item->description = $this->cm->db->fix_simple_TEXTAREA_text_for_HTML($item->description, $field);
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля DELIVERIES записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processFieldDeliveries ( & $item, $id, & $cancel = FALSE ) {
            if (isset($_POST['deliveries'][$id])) {
                $ids = array();
                if (is_array($_POST['deliveries'][$id])) {
                    foreach ($_POST['deliveries'][$id] as $id => $value) {
                        $id = intval($id);
                        if (!empty($id) && (!isset($item->delivery_id) || ($id != $item->delivery_id))) $ids[$id] = $id;
                    }
                    sort($ids, SORT_NUMERIC);
                }
                $item->deliveries_ids = $ids;
            }
        }
    }



    return;
?>