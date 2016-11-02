<?php
    // =======================================================================
    /**
    *  Админ модуль SMS-шлюзов
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

    // подключаем константы модуля
    impera_ConstantsRequire('SmsGates');

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);



    // =======================================================================
    /**
    *  Админ модуль SMS-шлюзов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SmsGates extends Basic {

        // объекты шлюзов
        private $gates = null;



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

            // создаем шлюзы
            $this->gates = array();
            $this->gates[] = new BusinessLifeComUA($this);
            $this->gates[] = new AlphaSmsComUA($this);
            $this->gates[] = new RFSmsRU($this);
            $this->gates[] = new ePochtaSMS($this);
            $this->gates[] = new TurboSmsUA($this);

            // упорядочиваем шлюзы по их номерам
            usort($this->gates, array('SmsGates', 'sort'));
        }



        // ===================================================================
        /**
        *  Сортировка шлюзов по номерам (вспомогательный callback-метод)
        *
        *  @access  private
        *  @param   object  $gate1      объект шлюза 1
        *  @param   object  $gate2      объект шлюза 2
        *  @return  integer             -1, 0 или 1
        */
        // ===================================================================

        private function sort ( $gate1, $gate2 ) {

            if ($gate1->number == $gate2->number) return 0;
            return ($gate1->number > $gate2->number) ? 1 : -1;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  private
        *  @return  void
        */
        // ===================================================================

        private function process () {

            // перебираем шлюзы
            foreach ($this->gates as & $gate) {

                // обрабатываем входные параметры шлюза
                $gate->process();
            }
        }



        // ===================================================================
        /**
        *  Отправка SMS
        *
        *  @access  public
        *  @param   array   $items      массив рассылки (кому отправлять, какой текст)
        *  @return  void
        */
        // ===================================================================

        public function send ( & $items ) {

            // если есть элементы для отправки
            if (!empty($items)) {

                // перебираем шлюзы
                foreach ($this->gates as & $gate) {

                    // если шлюз разрешено использовать
                    if ($gate->enabled) {

                        // отправляем что получится через него
                        $gate->send($items);

                        // если все разослано, прерываемся
                        if (empty($items)) break;
                    }
                }
            }
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

            // если сайт просматривает не админ, выходим (не даем выполнять этот метод)
            if (!isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) || ($_SESSION[SESSION_PARAM_NAME_ADMIN] != 'admin')) return FALSE;

            // обрабатываем входные команды,
            // устанавливаем заголовок страницы
            $this->process();
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'SMS уведомления';

            // упорядочиваем шлюзы по их номерам
            usort($this->gates, array('SmsGates', 'sort'));

            // если во входных параметрах получен список номеров
            if (isset($_POST['send_all']) && isset($_POST['phone_all'])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // берем список номеров и отправляемый текст
                $phones = trim($_POST['phone_all']);
                $text = isset($_POST['text_all']) ? trim($_POST['text_all']) : '';

                // если список непустой и также получен текст сообщения
                if (($phones != '') && ($text != '')) {

                    // если сайт работает в режиме демо версии
                    if ($this->config->demo) {
                        $this->push_error('В демо версии запрещено отправлять SMS из блока массовой рассылки.');

                    // иначе сайт работает в стандартном режиме
                    } else {

                        // список номеров преобразуем в массив рассылки
                        $rows = str_replace("\n", "\r", $phones);
                        $rows = str_replace(',', "\r", $rows);
                        $rows = explode("\r", $rows);
                        $phones = array();
                        foreach ($rows as & $row) {
                            $item = new stdClass;
                            $item->original = $row;
                            $row = preg_replace('/\[[0-9]+\]/', '', $row);
                            $row = preg_replace('/[^0-9]/', '', $row);
                            if ($row != '') {
                                $item->phone = $row;
                                $item->text = & $text;
                                $phones[] = $item;
                            }
                        }

                        // делаем рассылку
                        $this->send($phones);

                        // не отправленные номера преобразуем назад в строку-список
                        $rows = $phones;
                        $phones = array();
                        foreach ($rows as & $row) $phones[] = $row->original;
                        if (empty($phones)) $text = '';
                        $phones = implode("\r\n", $phones);
                    }
                }

            // иначе во входных параметрах нет списка номеров
            } else {

                // массив отобранных номеров телефонов
                $phones = array();
                $text = '';

                // если во входных параметрах указано взять телефоны клиентов
                if (isset($_REQUEST['user_phones']) || isset($_REQUEST['all_phones'])) {

                    // читаем телефоны зарегистрированных пользователей
                    $query = 'SELECT name, '
                                  . 'phone, '
                                  . 'phone2 '
                           . 'FROM ' . DATABASE_USERS_TABLENAME . ' '
                           . 'WHERE enabled = 1 '
                               . 'AND (TRIM(phone) != \'\' OR TRIM(phone2) != \'\') '
                           . 'ORDER BY phone ASC, '
                                    . 'phone2 ASC;';
                    $this->db->query($query);
                    $rows = $this->db->results();

                    // передаем телефоны в массив отобранных номеров
                    if (!empty($rows)) {
                        foreach ($rows as & $row) {

                            // обрабатываем имя пользователя
                            $user = null;
                            $user->name = $row->name;
                            $this->db->users->unpackUserName($user);
                            $row->name = $user->compound_name;
                            $row->name = $this->text->stripTags(preg_replace('/[0-9,]/', ' ', $row->name), TRUE);
                            if ($row->name != '') $row->name = "\t" . $row->name;

                            // из телефонов пользователя берем только один
                            $row->phone = str_replace(';', ',', $row->phone);
                            $row->phone = explode(',', $row->phone);
                            $row->phone = $row->phone[0];
                            $index = preg_replace('/[^0-9]/', '', $row->phone);
                            if ((strlen($index) >= PHONE_NUMBER_MINIMAL_SIZE) && (strlen($index) <= PHONE_NUMBER_MAXIMAL_SIZE)) {
                                $phones[$index] = $index . $row->name;
                            } else {
                                $row->phone2 = str_replace(';', ',', $row->phone2);
                                $row->phone2 = explode(',', $row->phone2);
                                $row->phone2 = $row->phone2[0];
                                $index = preg_replace('/[^0-9]/', '', $row->phone2);
                                if ((strlen($index) >= PHONE_NUMBER_MINIMAL_SIZE) && (strlen($index) <= PHONE_NUMBER_MAXIMAL_SIZE)) {
                                    $phones[$index] = $index . $row->name;
                                }
                            }
                        }
                    }
                }

                // если во входных параметрах указано взять телефоны из заказов
                if (isset($_REQUEST['order_phones']) || isset($_REQUEST['all_phones'])) {

                    // читаем телефоны из заказов
                    $query = 'SELECT order_id, '
                                  . 'name, '
                                  . 'phone, '
                                  . 'phone2 '
                           . 'FROM ' . DATABASE_ORDERS_TABLENAME . ' '
                           . 'WHERE TRIM(phone) != \'\' OR TRIM(phone2) != \'\' '
                           . 'ORDER BY phone ASC, '
                                    . 'phone2 ASC;';
                    $this->db->query($query);
                    $rows = $this->db->results();

                    // передаем телефоны в массив отобранных номеров
                    if (!empty($rows)) {
                        foreach ($rows as & $row) {

                            // обрабатываем имя заказавшего
                            $user = null;
                            $user->name = $row->name;
                            $this->db->users->unpackUserName($user);
                            $row->name = $user->compound_name;
                            $row->name = $this->text->stripTags(preg_replace('/[0-9,]/', '', $row->name), TRUE);
                            if ($row->name != '') $row->name = ' ' . $row->name;
                            $row->name = "\tзаказ [" . intval($row->order_id) . ']' . $row->name;

                            // из телефонов заказа берем только один
                            $row->phone = str_replace(';', ',', $row->phone);
                            $row->phone = explode(',', $row->phone);
                            $row->phone = $row->phone[0];
                            $index = preg_replace('/[^0-9]/', '', $row->phone);
                            if ((strlen($index) >= PHONE_NUMBER_MINIMAL_SIZE) && (strlen($index) <= PHONE_NUMBER_MAXIMAL_SIZE)) {
                                $phones[$index] = $index . $row->name;
                            } else {
                                $row->phone2 = str_replace(';', ',', $row->phone2);
                                $row->phone2 = explode(',', $row->phone2);
                                $row->phone2 = $row->phone2[0];
                                $index = preg_replace('/[^0-9]/', '', $row->phone2);
                                if ((strlen($index) >= PHONE_NUMBER_MINIMAL_SIZE) && (strlen($index) <= PHONE_NUMBER_MAXIMAL_SIZE)) {
                                    $phones[$index] = $index . $row->name;
                                }
                            }
                        }
                    }
                }

                // преобразуем массив отобранных номеров в текст
                sort($phones, SORT_STRING);
                $phones = implode("\r\n", $phones);
            }

            // перебираем шлюзы
            $items = array();
            foreach ($this->gates as & $gate) {

                // берем контент каждого шлюза (для шаблонизатора)
                $gate->body = '';
                $gate->fetch();
                $items[] = $gate->body;
            }

            // передаем нужные данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef('phone_all', $phones);
            $this->smarty->assignByRef('text_all', $text);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = $this->smarty->fetch(ADMIN_SMSGATES_CLASS_TEMPLATE_FILE);
            return TRUE;
        }
    }



    // =======================================================================
    /**
    *  Каркас SMS-шлюза
    *
    *  Этот класс не используется напрямую, он является основой для всех
    *  поддерживаемых системой SMS-шлюзов.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SmsGate extends Basic {

        // маркер настроек шлюза в базе данных сайта
        protected $db_marker = '';

        // информационный маркер шлюза
        protected $info_marker = '';

        // имя отправителя
        public $sender = '';

        // протокол сервера шлюза,
        // адрес сервера шлюза,
        // порт сервера шлюза,
        // логин доступа к шлюзу,
        // пароль доступа к шлюзу,
        // уведомительный телефон администратора,
        // фильтр телефонных номеров,
        // символьная кодировка шлюза,
        // история шлюза,
        // порядковый номер шлюза,
        // признак "шлюз разрешено использовать",
        // признак "помещать в историю разъяснения ошибок",
        // таймаут связи со шлюзом
        public $protocol = '';
        public $server = '';
        public $port = '';
        public $login = '';
        protected $password = '';
        public $admin_phone = '';
        public $filter = '';
        public $charset = '';
        public $history = '';
        public $number = 1;
        public $enabled = FALSE;
        public $explained = TRUE;
        public $timeout = 1;

        // признак "модулем поддерживается чтение баланса счета"
        public $balance_exists = TRUE;

        // объект взаимодействия со шлюзом,
        // класс объекта взаимодействия
        protected $gate = null;
        protected $gate_class = '';

        // имя файла шаблона
        protected $template = '';



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

            // инициализируем настройки шлюза
            $this->init();

            // создаем объект взаимодействия со шлюзом
            $this->create_gate();
        }



        // ===================================================================
        /**
        *  Инициализация настроек шлюза
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function init () {

            // читаем по маркеру настройки шлюза из базы данных
            $filter = new stdClass;
            $filter->mode = GET_SETTINGS_MODE_AS_SETTINGS;
            $filter->sort = SORT_SETTINGS_MODE_BY_NAME;
            $filter->name_prefix = $this->db_marker;
            $this->db->settings->get($settings, $filter);

            // берем имя отправителя
            $field = $this->db_marker . 'sender';
            if (isset($settings->$field)) $this->sender = trim($settings->$field);

            // берем протокол сервера шлюза
            $field = $this->db_marker . 'protocol';
            if (isset($settings->$field)) $this->protocol = trim($settings->$field);

            // берем адрес сервера шлюза
            $field = $this->db_marker . 'server';
            if (isset($settings->$field)) $this->server = trim($settings->$field);

            // берем порт сервера шлюза
            $field = $this->db_marker . 'port';
            if (isset($settings->$field)) $this->port = trim($settings->$field);

            // берем логин доступа к шлюзу
            $field = $this->db_marker . 'login';
            if (isset($settings->$field)) $this->login = trim($settings->$field);

            // берем пароль доступа к шлюзу
            $field = $this->db_marker . 'password';
            if (isset($settings->$field)) $this->password = $settings->$field;

            // берем уведомительный телефон администратора
            $field = $this->db_marker . 'admin_phone';
            if (isset($settings->$field)) $this->admin_phone = $settings->$field;

            // берем фильтр телефонных номеров
            $field = $this->db_marker . 'filter';
            if (isset($settings->$field)) $this->filter = trim($settings->$field);

            // берем символьную кодировку шлюза
            $field = $this->db_marker . 'charset';
            if (isset($settings->$field)) $this->charset = trim($settings->$field);

            // берем историю шлюза
            $field = $this->db_marker . 'history';
            if (isset($settings->$field)) $this->history = trim($settings->$field);

            // берем порядковый номер шлюза
            $field = $this->db_marker . 'number';
            if (isset($settings->$field)) $this->number = intval($settings->$field);

            // берем признак "шлюз разрешено использовать"
            $field = $this->db_marker . 'enabled';
            if (isset($settings->$field)) $this->enabled = ($settings->$field == 1);

            // берем признак "помещать в историю разъяснения ошибок"
            $field = $this->db_marker . 'explained';
            if (isset($settings->$field)) $this->explained = ($settings->$field == 1);
        }



        // ===================================================================
        /**
        *  Создание объекта взаимодействия со шлюзом
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function create_gate () {

            // берем класс объекта взаимодействия
            $class = preg_replace('/[^a-z0-9]+/i', '', $this->gate_class);
            $class = preg_replace('/^[^a-z]+/i', '', $class);
            if ($class == '') return;

            // если класс отсутствует, пробуем подгрузить
            $file = $class;
            $class .= 'ANYModel';
            if (!class_exists($class)) {
                $file = dirname(__FILE__) . '/../.any-models/' . $file . '.php';
                if (!is_file($file) || !is_readable($file)) return;
                require_once($file);
                if (!class_exists($class)) return;
            }

            // создаем объект взаимодействия
            $this->gate = new $class($this);
        }



        // ===================================================================
        /**
        *  Отправка SMS
        *
        *  @access  public
        *  @param   array   $items      массив рассылки (кому отправлять, какой текст)
        *  @return  void
        */
        // ===================================================================

        public function send ( & $items ) {

            // если создан объект взаимодействия
            $result = FALSE;
            $this->error_msg = '';
            if (isset($this->gate)) {

                // если есть элементы для отправки
                if (is_array($items) && !empty($items)) {
                    $connected = FALSE;

                    // берем фильтр пропускаемых начал номеров
                    $filter = array();
                    $result = explode(',', $this->filter);
                    foreach ($result as $item) {
                        $item = preg_replace('/[^0-9]/', '', $item);
                        if ($item != '') $filter[] = $item;
                    }

                    // перебираем каждый элемент
                    $result = TRUE;
                    foreach ($items as $index => & $item) {

                        // выправляем номер телефона
                        $phones = array();
                        if (isset($item->phone)) {
                            $phones[] = $item->phone;
                            if ($item->phone == ADMIN_PHONE_PSEUDONYM) $phones = explode(',', $this->admin_phone);
                            foreach ($phones as $key => &$phone) {
                                $phone = $this->fix_phone($phone);
                                if ($phone == '') unset($phones[$key]);
                            }
                            $phones = array_values($phones);
                        }

                        // выправляем текст сообщения
                        $translit_from = isset($item->translit_from) ? trim($item->translit_from) : '';
                        $text = isset($item->text) ? $this->fix_sms_text($this->text->stripTags($item->text, TRUE), $translit_from) : '';

                        // если задан номер телефона и текст сообщения
                        foreach ($phones as $key => & $phone) {
                            $count = 1;
                            if (($phone != '') && ($text != '')) {

                                // если фильтр не задан или номер пропускается фильтром
                                if (!empty($filter)) {
                                    $count = count($filter);
                                    while ($count > 0) {
                                        $count--;
                                        if (substr($phone, 0, strlen($filter[$count])) == $filter[$count]) {
                                            $count++;
                                            break;
                                        }
                                    }
                                }
                                if ($count > 0) {

                                    // если еще не подключались к серверу, подключаемся
                                    if (!$connected) {
                                        $result = $this->gate->open($this->password);

                                        // если ошибка, заносим в историю, возвращаем в элемент непропущенные фильтром + небравшиеся телефоны,
                                        // прерываем все циклы (не грузим канал запросами к недоступному шлюзу)
                                        if (!$result) {
                                            $this->history = substr(date('Y-m-d H:i:s', time()) . " Ошибка: не удалось подключиться к серверу!\r\n\r\n" . $this->error_info() . $this->history, 0, 65536);
                                            $item->phone = implode(',', array_values($phones));
                                            break 2;
                                        }
                                        $connected = TRUE;
                                    }

                                    // если задана символьная кодировка шлюза
                                    if ($this->charset != '') {
                                        if (function_exists('iconv')) $text = @iconv('UTF-8', $this->charset  . '//IGNORE', $text);
                                    }

                                    // отправляем сообщение
                                    if ($text != '') {
                                        $result = $this->gate->send($phone, $text);

                                        // если ошибка, заносим в историю, возвращаем в элемент непропущенные фильтром + небравшиеся телефоны,
                                        // прерываем все циклы (не грузим канал запросами к шлюзу, когда неясна причина неудачи)
                                        if (!$result) {
                                            $this->history = substr(date('Y-m-d H:i:s', time()) . ' Ошибка: не удалось передать на ' . $phone . ' текст "' . $text . "\"!\r\n\r\n" . $this->error_info() . $this->history, 0, 65536);
                                            $item->phone = implode(',', array_values($phones));
                                            break 2;
                                        }

                                        // сохраняем сведения в истории шлюза
                                        $this->history = substr(date('Y-m-d H:i:s', time()) . ' ' . $phone . ' текст "' . $text . "\"!\r\n\r\n" . $this->history, 0, 65536);
                                    }
                                }
                            }

                            // удаляем телефон из списка (если телефон недействительный или прошел фильтр)
                            if ($count > 0) unset($phones[$key]);
                        }

                        // возвращаем в элемент непропущенные фильтром телефоны
                        $item->phone = implode(',', array_values($phones));

                        // удаляем элемент из списка (если нет непропущенных фильтром телефонов)
                        if ($item->phone == '') unset($items[$index]);
                    }

                    // отключаемся
                    if ($connected) $this->gate->close();

                    // сохраняем историю
                    $field = $this->db_marker . 'history';
                    $this->db->settings->save($field, $this->history, 'SMS шлюзы - история использования');

                // иначе нет элементов для отправки
                } else {
                    $this->error_msg = 'Не указаны сообщение(я) для отправки!';
                }

            // иначе не создан объект взаимодействия
            } else {
                $this->error_msg = 'Не создан объект взаимодействия с SMS-сервером!';
            }

            // возвращаем результат отправки
            return $result;
        }



        // ===================================================================
        /**
        *  Чтение баланса счета
        *
        *  @access  public
        *  @return  mixed           ответ SMS-сервера
        */
        // ===================================================================

        public function balance () {

            // если создан объект взаимодействия
            $result = FALSE;
            $this->error_msg = '';
            if (isset($this->gate)) {

                // подключаемся к серверу
                if ($this->gate->open($this->password)) {

                  // читаем баланс счета
                  $result = $this->gate->balance();
                  $this->gate->close();
                }

            // иначе не создан объект взаимодействия
            } else {
                $this->error_msg = 'Не создан объект взаимодействия с SMS-сервером!';
            }

            // возвращаем результат
            return $result;
        }



        // ===================================================================
        /**
        *  Получение строки описания последней ошибки для сохранения в истории
        *
        *  @access  public
        *  @param   string  $before     добавочный текст перед описание
        *  @param   string  $after      добавочный текст после описания
        *  @return  string              описание ошибки
        */
        // ===================================================================

        public function error_info ( $before = '        Описание ошибки: ', $after = "\r\n\r\n" ) {

            // если в настройках шлюза запрещено разъяснение ошибок в истории
            if (!$this->explained) return '';

            // иначе формируем строку описания ошибки
            $error = trim($this->error_msg);
            if ($error != '') $error = $before . $error . $after;
            return $error;
        }



        // ===================================================================
        /**
        *  Выправление номера телефона
        *
        *  @access  public
        *  @param   string  $phone      номер телефона
        *  @return  string              исправленный номер (одни цифры)
        */
        // ===================================================================

        public function fix_phone ( $phone ) {

            // возвращаем выправленный номер (одни цифры и не менее PHONE_NUMBER_MINIMAL_SIZE и не более PHONE_NUMBER_MAXIMAL_SIZE штук)
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if ((strlen($phone) < PHONE_NUMBER_MINIMAL_SIZE) || (strlen($phone) > PHONE_NUMBER_MAXIMAL_SIZE)) $phone = '';
            return $phone;
        }



        // ===================================================================
        /**
        *  Выправление текста сообщения
        *
        *  @access  public
        *  @param   string  $text           текст
        *  @param   string  $translit_from  метка исходного языка (например ru, например ua), если нужна транслитерация
        *  @return  string                  исправленный текст (транслитерированный, без дублей пробелов)
        */
        // ===================================================================

        public function fix_sms_text ( $text, $translit_from = '' ) {

            // убираем дублирующиеся и оконечные пробелы
            $text = trim($text);
            while (strpos($text, '  ') !== FALSE) $text = str_replace('  ', ' ', $text);

            // делаем транслитерацию
            $text = $this->get_translit($text, $translit_from);

            // возвращаем выправленный текст (без дублирующихся пробелов)
            return $text;
        }



        // ===================================================================
        /**
        *  Транслитерация сообщения
        *
        *  @access  public
        *  @param   string  $text       текст
        *  @param   string  $from       метка исходного языка (ru, ua)
        *  @return  string              транслитерированный текст
        */
        // ===================================================================

        public function get_translit ( $text, $from = '' ) {

            // с какого языка?
            $from = strtolower(trim($from));
            switch ($from) {

                // если с русского или украинского
                case 'ru':
                case 'ua':

                    // транслитерируем по типичной таблице символов
                    $charmap = array('а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'g',  'д' => 'd',  'е' => 'e',
                                     'є' => 'ye', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',  'і' => 'i',  'и' => 'i',
                                     'й' => 'j',  'к' => 'k',  'ї' => 'yi', 'л' => 'l',  'м' => 'm',  'н' => 'n',
                                     'о' => 'o',  'п' => 'p',  'р' => 'r',  'с' => 's',  'т' => 't',  'у' => 'u',
                                     'ф' => 'f',  'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
                                     'ь' => '\'', 'ы' => 'y',  'ъ' => '"',  'э' => 'e',  'ю' => 'yu', 'я' => 'ya',
                                     'А' => 'A',  'Б' => 'B',  'В' => 'V',  'Г' => 'G',  'Д' => 'D',  'Е' => 'E',
                                     'Є' => 'Ye', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',  'І' => 'I',  'И' => 'I',
                                     'Й' => 'J',  'К' => 'K',  'Ї' => 'Yi', 'Л' => 'L',  'М' => 'M',  'Н' => 'N',
                                     'О' => 'O',  'П' => 'P',  'Р' => 'R',  'С' => 'S',  'Т' => 'T',  'У' => 'U',
                                     'Ф' => 'F',  'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
                                     'Ь' => '\'', 'Ы' => 'Y',  'Ъ' => '"',  'Э' => 'E',  'Ю' => 'Yu', 'Я' => 'Ya');
                    $text = strtr($text, $charmap);

                    // транслитерируем другие возможно неучтенные символы
                    if (function_exists('iconv')) $text = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
                    break;
            }

            // возвращаем результат
            return $text;
        }



        // ===================================================================
        /**
        *  Получение редактируемых данных шлюза
        *
        *  @access  public
        *  @param   object  $item       объект записи шлюза (будет возвращен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function get_editable ( & $item ) {

            // берем редактируемые данные шлюза
            $item = new stdClass;
            $item->marker = $this->db_marker;
            $item->sender = $this->sender;
            $item->protocol = $this->protocol;
            $item->server = $this->server;
            $item->port = $this->port;
            $item->login = $this->login;
            $item->password = $this->password;
            $item->admin_phone = $this->admin_phone;
            $item->filter = $this->filter;
            $item->charset = $this->charset;
            $item->history = $this->history;
            $item->number = $this->number;
            $item->enabled = $this->enabled;
            $item->explained = $this->explained;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function process () {

            // если была нажата кнопка Сохранить
            $field = $this->db_marker . 'save';
            if (isset($_POST[$field])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // обрабатываем имя отправителя
                $field = $this->db_marker . 'sender';
                if (isset($_POST[$field])) {
                    $value = $this->text->stripTags($_POST[$field], TRUE);
                    $this->sender = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - альфа имя (название отправителя)');
                }

                // обрабатываем протокол сервера шлюза
                $field = $this->db_marker . 'protocol';
                if (isset($_POST[$field])) {
                    $value = strtolower(trim($_POST[$field]));
                    if (($value == 'http') || ($value == 'https')) {
                        $this->protocol = $value;
                        $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - протокол сервера');
                    }
                }

                // обрабатываем адрес сервера шлюза
                $field = $this->db_marker . 'server';
                if (isset($_POST[$field])) {
                    $value = trim($_POST[$field]);
                    $this->server = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - адрес сервера');
                }

                // обрабатываем порт сервера шлюза
                $field = $this->db_marker . 'port';
                if (isset($_POST[$field])) {
                    $value = trim($_POST[$field]);
                    $this->port = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - порт сервера');
                }

                // обрабатываем логин доступа к шлюзу
                $field = $this->db_marker . 'login';
                if (isset($_POST[$field])) {
                    $value = trim($_POST[$field]);
                    $this->login = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - логин доступа');
                }

                // обрабатываем пароль доступа к шлюзу
                $field = $this->db_marker . 'password';
                if (isset($_POST[$field])) {
                    $value = $_POST[$field];
                    $this->password = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - пароль доступа');
                }

                // обрабатываем уведомительный телефон администратора
                $field = $this->db_marker . 'admin_phone';
                if (isset($_POST[$field])) {
                    $value = trim($_POST[$field]);
                    $this->admin_phone = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - уведомительный телефон администратора');
                }

                // обрабатываем фильтр телефонных номеров
                $field = $this->db_marker . 'filter';
                if (isset($_POST[$field])) {
                    $value = trim($_POST[$field]);
                    $this->filter = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - фильтр телефонных номеров');
                }

                // обрабатываем символьную кодировку шлюза
                $field = $this->db_marker . 'charset';
                if (isset($_POST[$field])) {
                    $value = trim($_POST[$field]);
                    $this->charset = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - символьная кодировка шлюза');
                }

                // обрабатываем порядковый номер шлюза
                $field = $this->db_marker . 'number';
                if (isset($_POST[$field])) {
                    $value = intval($_POST[$field]);
                    $this->number = $value;
                    $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - порядковый номер шлюза');
                }

                // обрабатываем признак "шлюз разрешено использовать"
                $field = $this->db_marker . 'enabled';
                $value = isset($_POST[$field]) && ($_POST[$field] == 1) ? 1 : 0;
                $this->enabled = $value;
                $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - разрешено ли использовать шлюз');

                // обрабатываем признак "помещать в историю разъяснения ошибок"
                $field = $this->db_marker . 'explained';
                $value = isset($_POST[$field]) && ($_POST[$field] == 1) ? 1 : 0;
                $this->explained = $value;
                $this->db->settings->save($field, $value, 'SMS шлюзы - ' . $this->info_marker . ' - разрешено ли помещать разъяснения ошибок в историю шлюза');
            }

            // если была нажата кнопка Отправить
            $field = $this->db_marker . 'send';
            if (isset($_POST[$field])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если задан номер телефона получателя
                $field = $this->db_marker . 'phone';
                if (isset($_POST[$field])) {
                    $item = new stdClass;
                    $item->phone = trim($_POST[$field]);

                    // если задан текст сообщения
                    $field = $this->db_marker . 'text';
                    if (isset($_POST[$field])) {
                        $item->text = trim($_POST[$field]);

                        // отправляем сообщение
                        $items = array($item);
                        $this->send($items);
                    }
                }
            }
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

            // берем редактируемые данные шлюза
            $this->get_editable($item);

            // читаем баланс счета, если поддерживается модулем и модуль включен
            if ($this->balance_exists && $this->enabled) $item->balance = $this->balance();

            // передаем нужные данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $item);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = ($this->template != '') ? $this->smarty->fetch($this->template)
                                                  : '<!-- Не указано имя tpl-файла в модуле данного SMS-шлюза (' . htmlspecialchars($this->info_marker, ENT_NOQUOTES) . ') -->';
            return TRUE;
        }
    }



    // =======================================================================
    /**
    *  Модуль SMS-шлюза BusinessLife.com.ua
    *
    *  Работает по протоколу SMPP.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class BusinessLifeComUA extends SmsGate {

        // маркер настроек шлюза в базе данных
        protected $db_marker = 'sms_BusinessLifeComUA_';

        // информационный маркер шлюза
        protected $info_marker = 'BusinessLife.com.ua';

        // протокол сервера шлюза,
        // адрес сервера шлюза,
        // порт сервера шлюза,
        // символьная кодировка шлюза
        public $protocol = 'http';
        public $server = '212.58.160.139';
        public $port = '16001';
        public $charset = 'UTF-16BE';

        // чтение баланса счета не поддерживается
        public $balance_exists = FALSE;

        // класс объекта взаимодействия
        protected $gate_class = 'SmppClient';

        // имя файла шаблона
        protected $template = ADMIN_SMSGATE_BUSINESSLIFECOMUA_CLASS_TEMPLATE_FILE;
    }



    // =======================================================================
    /**
    *  Модуль SMS-шлюза AlphaSMS.com.ua
    *
    *  Работает на платформе SMSclub.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AlphaSmsComUA extends SmsGate {

        // маркер настроек шлюза в базе данных
        protected $db_marker = 'sms_AlphaSmsComUA_';

        // информационный маркер шлюза
        protected $info_marker = 'AlphaSMS.com.ua';

        // протокол сервера шлюза,
        // адрес сервера шлюза,
        // символьная кодировка шлюза
        public $protocol = 'https';
        public $server = 'alphasms.com.ua/api/http.php';
        public $charset = 'UTF-8';

        // класс объекта взаимодействия
        protected $gate_class = 'SmsClub';

        // имя файла шаблона
        protected $template = ADMIN_SMSGATE_ALPHASMSCOMUA_CLASS_TEMPLATE_FILE;
    }



    // =======================================================================
    /**
    *  Модуль SMS-шлюза RFSMS.ru
    *
    *  Работает на транспорте RFSMS.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class RFSmsRU extends SmsGate {

        // маркер настроек шлюза в базе данных
        protected $db_marker = 'sms_RFSmsRU_';

        // информационный маркер шлюза
        protected $info_marker = 'RFSMS.ru';

        // протокол сервера шлюза,
        // адрес сервера шлюза,
        // символьная кодировка шлюза
        public $protocol = 'https';
        public $server = 'transport.rfsms.ru';
        public $port = '7214';
        public $charset = 'UTF-8';

        // класс объекта взаимодействия
        protected $gate_class = 'RfsmsTransport';

        // имя файла шаблона
        protected $template = ADMIN_SMSGATE_RFSMSRU_CLASS_TEMPLATE_FILE;
    }



    // =======================================================================
    /**
    *  Модуль SMS-шлюза AtomPark ePochta SMS
    *
    *  Работает на Atomic ePochta SMS API.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ePochtaSMS extends SmsGate {

        // маркер настроек шлюза в базе данных
        protected $db_marker = 'sms_ePochtaSMS_';

        // информационный маркер шлюза
        protected $info_marker = 'ePochtaSMS';

        // протокол сервера шлюза,
        // адрес сервера шлюза,
        // символьная кодировка шлюза
        public $protocol = 'http';
        public $server = 'atompark.com/members/sms/xml';
        public $port = '';
        public $charset = 'UTF-8';

        // класс объекта взаимодействия
        protected $gate_class = 'ePochtaSmsApi';

        // имя файла шаблона
        protected $template = ADMIN_SMSGATE_EPOCHTASMS_CLASS_TEMPLATE_FILE;
    }



    // =======================================================================
    /**
    *  Модуль SMS-шлюза TurboSMS.ua
    *
    *  Работает по протоколу SOAP.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class TurboSmsUA extends SmsGate {

        // маркер настроек шлюза в базе данных
        protected $db_marker = 'sms_TurboSmsUA_';

        // информационный маркер шлюза
        protected $info_marker = 'TurboSMS.ua';

        // протокол сервера шлюза,
        // адрес сервера шлюза,
        // символьная кодировка шлюза
        public $protocol = 'http';
        public $server = 'turbosms.in.ua/api/wsdl.html';
        public $port = '';
        public $charset = 'UTF-8';

        // класс объекта взаимодействия
        protected $gate_class = 'SoapClient';

        // имя файла шаблона
        protected $template = ADMIN_SMSGATE_TURBOSMSUA_CLASS_TEMPLATE_FILE;
    }



    return;
?>