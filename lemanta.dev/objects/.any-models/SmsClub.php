<?php
    // =======================================================================
    /**
    *  Клиентская часть платформы SMS club
    *
    *  Реализация под частный случай (AlphaSms.com.ua):
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

    class SmsClubANYModel {

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

            // запоминаем пароль (в этой платформе нет постоянного соединения с сервером)
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
        *  @param   boolean $flash      признак "в формате FLASH"
        *  @param   string  $wap        WAP параметры
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
            $params = array('from' => $this->parent->sender,
                            'to' => $recipient,
                            'message' => $message,
                            'ask_date' => date(DATE_ISO8601, time()),
                            'wap' => $wap,
                            'flash' => $flash,
                            'class_version' => '1.7');
            $result = $this->execute('send', $params);



            // возвращаем результат ВЫПОЛНЕНО / НЕТ
            if (isset($result['errors']) && is_array($result['errors']) && !empty($result['errors'])) {
                foreach ($result['errors'] as $item) {
                    if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                    $this->parent->error_msg .= $this->parent->text->stripTags($item, TRUE);
                }
            }
            return isset($result['id']);
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
            $result = (trim($this->parent->login) != '') && ($this->password != '') ? $this->execute('balance') : FALSE;



            // возвращаем результат БАЛАНС / НЕ УДАЛОСЬ
            if (isset($result['errors']) && is_array($result['errors']) && !empty($result['errors'])) {
                foreach ($result['errors'] as $item) {
                    if ($this->parent->error_msg != '') $this->parent->error_msg .= '<br><br>';
                    $this->parent->error_msg .= $this->parent->text->stripTags($item, TRUE);
                }
            }
            return isset($result['balance']) ? $this->parent->text->stripTags($result['balance'], TRUE) : FALSE;
        }



        // ===================================================================
        /**
        *  Выполнение команды
        *
        *  @access  protected
        *  @param   string  $command    имя команды
        *  @param   array   $params     параметры
        *  @return  mixed               ответ сервера
        */
        // ===================================================================

        protected function execute ( $command, $params = array() ) {

            // берем url сервера (устанавливаем переменные $protocol + $server)
            $protocol = explode(':', $this->parent->protocol, 2);
            $protocol = strtolower(trim($protocol[0])) . '://';
            $server = str_replace('\\', '/', $this->parent->server);
            $server = explode('://', $server, 2);
            $server = isset($server[1]) ? strtolower(trim($server[1])) : strtolower(trim($server[0]));



            // добавляем в параметры логин, пароль и команду
            $params['login'] = $this->parent->login;
            $params['password'] = $this->password;
            $params['command'] = $command;



            // формируем строку полей запроса
            $post = '';
            foreach ($params as $key => $value) {
                $value = base64_encode($value);
                $value = strtr($value, '+/=', '-_,');
                $post .= '&' . $key . '=' . $value;
            }



            // если указан протокол HTTP или не поддерживается библиотека CURL (Client URL)
            if ((strtolower($this->parent->protocol) == 'http')
            || !function_exists('curl_init') || !function_exists('curl_setopt')
            || !function_exists('curl_exec') || !function_exists('curl_close')) {



                // отправляем GET-запрос
                if ($post != '') $post = '?' . substr($post, 1);
                $result = @ file_get_contents($protocol . $server . $post);



            // иначе отправляем запрос с помощью библиотеки CURL
            } else {
                $handle = @ curl_init($protocol . $server);
                @ curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
                @ curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
                @ curl_setopt($handle, CURLOPT_POST, count($params));
                @ curl_setopt($handle, CURLOPT_POSTFIELDS, $post);
                @ curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
                @ curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
                $result = @ curl_exec($handle);
                @ curl_close($handle);
            }



            // возвращаем ответ сервера
            $result = strtr($result, '-_,', '+/=');
            $result = base64_decode($result);
            return @ unserialize($result);
        }
    }



    return;
?>