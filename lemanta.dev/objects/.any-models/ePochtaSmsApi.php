<?php
    // =======================================================================
    /**
    *  Клиентская часть Atomic ePochta SMS API
    *
    *  Реализация под частный случай (Atompark.com):
    *      - наличие родительского объекта, в свойствах которого все настройки:
    *            $this->parent->protocol - протокол
    *            $this->parent->server - сервер
    *            $this->parent->port - порт
    *            $this->parent->login - логин
    *            $this->parent->sender - имя отправителя
    *            $this->parent->timeout - величина таймаута
    *            $this->parent->error_msg - описание ошибки
    *      - упрощенные названия исполняющих методов:
    *            open($passwd) - подключение к серверу
    *            close() - отключение
    *            send($to, $msg, $utf, $flash, $wap) - отправка сообщения
    *            balance() - чтение баланса счета
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ePochtaSmsApiANYModel {

        // родительский объект
        protected $parent = null;

        // пароль
        protected $password;



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

            // запоминаем родительский объект
            $this->parent = & $parent;
        }



        // ===================================================================
        /**
        *  Подключение к серверу
        *
        *  @access  public
        *  @param   string  $password   пароль
        *  @return  boolean             всегда TRUE (связь якобы установлена)
        */
        // ===================================================================

        public function open ( $password ) {

            // запоминаем пароль (в этом API нет постоянного соединения с сервером)
            $this->password = $password;



            // возвращаем результат ВЫПОЛНЕНО
            $this->parent->error_msg = '';
            return TRUE;
        }



        // ===================================================================
        /**
        *  Отключение от сервера
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function close () {
        }



        // ===================================================================
        /**
        *  Отправка сообщения
        *
        *  @access  public
        *  @param   string  $recipient  номер получателя
        *  @param   string  $message    текст сообщения
        *  @param   boolean $utf        (неиспользуемый параметр, служит для синхронизации
        *                               числа параметров метода send объектов взаимодействия со шлюзом)
        *  @param   boolean $flash      (неиспользуемый параметр, служит для синхронизации
        *                               числа параметров метода send объектов взаимодействия со шлюзом)
        *  @param   string  $wap        (неиспользуемый параметр, служит для синхронизации
        *                               числа параметров метода send объектов взаимодействия со шлюзом)
        *  @return  boolean             TRUE если отправлено,
        *                               иначе описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        public function send ($recipient, $message, $utf = FALSE, $flash = FALSE, $wap = '') {

            // если нет родительского объекта, выходим
            if (!isset($this->parent)) return FALSE;
            $this->parent->error_msg = '';



            // выполняем команду отправки
            $xml = "    <message>\r\n"
                 . '        <sender>' . $this->safe_xml_param($this->parent->sender) . "</sender>\r\n"
                 . '        <text>' . $this->safe_xml_param($message) . "</text>\r\n"
                 . "    </message>\r\n"
                 . "    <numbers>\r\n"
                 . '        <number>' . $this->safe_xml_param($recipient) . "</number>\r\n"
                 . "    </numbers>\r\n";
            $result = $this->execute('send', $xml);



            // возвращаем результат ВЫПОЛНЕНО / НЕТ
            if (!isset($result['status'])) {
                if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                $this->parent->error_msg .= 'Получен ответ сервера в неизвестном формате!';
                return FALSE;
            } elseif ($result['status'] < 0) {
                switch ($result['status']) {
                    case -1:
                        if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                        $this->parent->error_msg .= 'Неправильный логин и/или пароль!';
                        break;
                    case -2:
                        if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                        $this->parent->error_msg .= 'Неправильный формат XML!';
                        break;
                    case -3:
                        if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                        $this->parent->error_msg .= 'Недостаточно кредитов в аккаунте пользователя!';
                        break;
                    case -4:
                        return TRUE;
                    case -1000000000:
                        if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                        $this->parent->error_msg .= isset($result['error']) ? $this->parent->text->stripTags($result['error'], TRUE) : 'Неизвестная ошибка!';
                        break;
                    default:
                        if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                        $this->parent->error_msg .= 'Неизвестный код ошибки!';
                }
                return FALSE;
            }
            return TRUE;
        }



        // ===================================================================
        /**
        *  Чтение баланса счета
        *
        *  @access  public
        *  @return  mixed               баланс или FALSE при ошибке,
        *                               описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        public function balance () {

            // если нет родительского объекта, выходим
            if (!isset($this->parent)) return FALSE;
            $this->parent->error_msg = '';



            // выполняем команду чтения баланса
            $result = (trim($this->parent->login) != '') && ($this->password != '')
                      ? $this->execute('balance')
                      : FALSE;



            // возвращаем результат БАЛАНС / НЕ УДАЛОСЬ
            if (!isset($result['status'])
            || !is_array($result['status']) && ($result['status'] != 0)
            || is_array($result['status']) && ($this->get_field($result, 'status') != 0)) return FALSE;
            $result = $this->get_field($result, 'credits');
            return ($result !== FALSE) ? $this->parent->text->stripTags($result, TRUE) : FALSE;
        }



        // ===================================================================
        /**
        *  Выполнение команды
        *
        *  @access  protected
        *  @param   string  $command    имя команды
        *  @param   string  $params     дополнительные параметры (обернуты по формату XML)
        *  @return  mixed               ответ сервера
        */
        // ===================================================================

        protected function execute ( $command, $params = '' ) {

            // берем url сервера (устанавливаем переменные $protocol + $server)
            $protocol = explode(':', $this->parent->protocol, 2);
            $protocol = strtolower(trim($protocol[0])) . '://';
            $server = str_replace('\\', '/', $this->parent->server);
            $server = explode('://', $server, 2);
            $server = isset($server[1]) ? strtolower(trim($server[1])) : strtolower(trim($server[0]));



            // вставляем в url порт
            $port = trim($this->parent->port);
            if ($port != '') {
                $server = explode('/', $server);
                $server[0] = explode(':', $server[0], 2);
                $server[0] = $server[0][0] . ':' . $port;
                $server = implode('/', $server);
            }



            // проверяем, чтобы url сервера оканчивался слешем
            if (substr($server, -1) != '/') $server .= '/';



            // формируем XML-контент запроса
            $xml = "<?xml version='1.0' encoding='UTF-8'?>\r\n"
                 . "<SMS>\r\n"
                 . "    <operations>\r\n"
                 . '        <operation>' . $this->safe_xml_param(strtoupper($command)) . "</operation>\r\n"
                 . "    </operations>\r\n"
                 . "    <authentification>\r\n"
                 . '        <username>' . $this->safe_xml_param($this->parent->login) . "</username>\r\n"
                 . '        <password>' . $this->safe_xml_param($this->password) . "</password>\r\n"
                 . "    </authentification>\r\n"
                 . $params
                 . "</SMS>\r\n";



            // если поддерживается библиотека CURL (Client URL)
            if (function_exists('curl_init') && function_exists('curl_setopt')
            && function_exists('curl_exec') && function_exists('curl_close')) {
                $command = $protocol . $server;



                // отправляем запрос с помощью библиотеки CURL
                $handle = @ curl_init($command);
                @ curl_setopt($handle, CURLOPT_URL, $command);
                @ curl_setopt($handle, CURLOPT_FAILONERROR, TRUE);
                @ curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                @ curl_setopt($handle, CURLOPT_TIMEOUT, 10);
                @ curl_setopt($handle, CURLOPT_POST, 1);
                @ curl_setopt($handle, CURLOPT_POSTFIELDS, $xml);
                @ curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
                @ curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
                $result = @ curl_exec($handle);
                @ curl_close($handle);



                // возвращаем результат
                $result = $this->XMLToArray($result);
                if (!isset($result['status'])) {
                    $code = $this->get_field($result, 'status');
                    if ($code !== FALSE) $result['status'] = $code;
                }
                return $result;



            // иначе возвращаем сообщение об ошибке
            } else {
                return array('status' => -1000000000, 'error' => 'Сайтом не поддерживается работа с библиотекой CURL!');
            }
        }



        // ===================================================================
        /**
        *  Обезопасить текст для XML
        *
        *  @access  protected
        *  @param   string  $text       текст
        *  @return  string              безопасный текст
        */
        // ===================================================================

        protected function safe_xml_param ( $text ) {
            return str_replace('<', '&lt;', str_replace('>', '&gt;', $text));
        }



        // ===================================================================
        /**
        *  Извлечение поля из ответа сервера
        *
        *  @access  protected
        *  @param   array   $responce   массив ответа
        *  @param   string  $key        индекс поля в массиве
        *  @return  mixed               поле или FALSE
        */
        // ===================================================================

        protected function get_field ( $responce, $key ) {
            if (isset($responce[$key], $responce[$key][0], $responce[$key][0][0])) return $responce[$key][0][0];
            return FALSE;
        }



        // ===================================================================
        /**
        *  Преобразование XML-ответа в массив
        *
        *  @access  protected
        *  @param   string  $xml        текст xml
        *  @return  array               массив
        */
        // ===================================================================

        protected function XMLToArray ( $xml ) {

            if (!strlen(trim($xml))) {
                return array('status' => -1000000000, 'error' => 'Не удалось получить ответ сервера!');
            }

            if (!function_exists('simplexml_load_string')) {
                return array('status' => -1000000000, 'error' => 'Сайтом не поддерживается функция simplexml_load_string!');
            }

            $xml = @ simplexml_load_string($xml);
            $return = array();
            foreach ($xml->children() as $child) {
                $return[$child->getName()][] = $this->makeAssoc((array)$child);
            }

            return $return;
        }



        // ===================================================================
        /**
        *  Преобразование в ассоциативный массив
        *
        *  @access  protected
        *  @param   array   $array      массив
        *  @return  mixed               ассоциативный массив или строка (если на входе был не массив)
        */
        // ===================================================================

        protected function makeAssoc ( $array ) {
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    if (is_object($value)) {
                        $newValue = array();
                        foreach ($value->children() as $child) {
                            $newValue[] = (string)$child;
                        }
                        $array[$key] = $newValue;
                    }
                }
            } else {
                $array = (string)$array;
            }
            return $array;
        }
    }



    return;
?>