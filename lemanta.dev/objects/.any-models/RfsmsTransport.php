<?php
    // =======================================================================
    /**
    *  Клиентская часть транспорта RFSMS
    *
    *  Реализация под частный случай (RFsms.ru):
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

    class RfsmsTransportANYModel {

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

            // запоминаем пароль (в этом транспорте нет постоянного соединения с сервером)
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
            $params = array('source' => $this->parent->sender);
            $xml = '    <to number=\'' . htmlspecialchars($recipient, ENT_QUOTES) . '\'>' . $this->safe_xml_param($message) . "</to>\r\n";
            $result = $this->execute('send', $params, $xml);



            // возвращаем результат ВЫПОЛНЕНО / НЕТ
            if (isset($result['error']) && ($result['error'] != '')) {
                if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                $this->parent->error_msg .= $this->parent->text->stripTags($result['error'], TRUE);
                return FALSE;
            } elseif (!isset($result['code'])) {
                if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                $this->parent->error_msg .= 'Получен ответ сервера в неизвестном формате!';
                return FALSE;
            } elseif ($this->get_field($result, 'code') != 1) {
                $result = $this->get_field($result, 'descr');
                if ($result !== FALSE) {
                    if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                    $this->parent->error_msg .= $this->parent->text->stripTags($result, TRUE);
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
            if (isset($result['error']) && ($result['error'] != '')) return FALSE;
            $result = $this->get_field($result, 'account');
            return ($result !== FALSE) ? $this->parent->text->stripTags($result, TRUE) : FALSE;
        }



        // ===================================================================
        /**
        *  Выполнение команды
        *
        *  @access  protected
        *  @param   string  $command    имя команды
        *  @param   array   $params     дополнительные параметры
        *  @param   string  $xml_more   дополнительные параметры (обернуты по формату XML)
        *  @return  mixed               ответ сервера
        */
        // ===================================================================

        protected function execute ( $command, $params = array(), $xml_more = '' ) {

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
                 . "<data>\r\n"
                 . '    <login>' . $this->safe_xml_param($this->parent->login) . "</login>\r\n"
                 . '    <password>' . $this->safe_xml_param($this->password) . "</password>\r\n";
            if (is_array($params)) {
                foreach ($params as $key => $value) {
                  $xml .= '    <' . $this->safe_xml_param($key) . '>' . $this->safe_xml_param($value) . '</' . $this->safe_xml_param($key) . ">\r\n";
                }
            }
            $xml .= $xml_more
                 . "</data>\r\n";



            // если поддерживается библиотека CURL (Client URL)
            if (function_exists('curl_init') && function_exists('curl_setopt')
            && function_exists('curl_exec') && function_exists('curl_close')) {
                $command = $protocol . $server . $command . ((strtolower($protocol) == 'https://') ? '.xml' : '.php');



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
                return $this->XMLToArray($result);



            // иначе возвращаем сообщение об ошибке
            } else {
                return array('code' => 0, 'error' => 'Сайтом не поддерживается работа с библиотекой CURL!');
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
                return array('code' => 0, 'error' => 'Не удалось получить ответ сервера!');
            }

            if (!function_exists('simplexml_load_string')) {
                return array('code' => 0, 'error' => 'Сайтом не поддерживается функция simplexml_load_string!');
            }

            $xml = @ simplexml_load_string($xml);
            $return = array();
            foreach ($xml->children() as $child) {
                $return[$child->getName()][] = $this->makeAssoc((array)$child);
            }
            $this->convertArrayCharset($return);

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



        // ===================================================================
        /**
        *  Преобразование кодировки массива
        *
        *  @access  protected
        *  @param   array   $array      массив (изменения будут произведены в этой переменной)
        *  @return  void
        */
        // ===================================================================

        protected function convertArrayCharset ( & $array ) {
            foreach ($array as $key => $value) {
                if (is_array($value)) $this->convertArrayCharset($array[$key]);
                else $array[$key] = $this->getAnswerString($value);
            }
        }



        // ===================================================================
        /**
        *  Получение строки ответа в кодировке UTF-8
        *
        *  @access  protected
        *  @param   string  $value      строка
        *  @return  string              строка в кодировке UTF-8
        */
        // ===================================================================

        protected function getAnswerString ( $value ) {
            if ((trim($this->parent->charset) != '') && (strtolower($this->parent->charset) != 'utf-8')) {
                if (function_exists('iconv')) return @ iconv($this->parent->charset, 'UTF-8//IGNORE', $value);
            }
            return $value;
        }
    }



    return;
?>