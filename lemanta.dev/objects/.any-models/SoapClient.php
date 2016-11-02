<?php
    // =======================================================================
    /**
    *  SOAP клиент
    *
    *  Реализация под частный случай (TurboSMS.ua):
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



    class SoapClientANYModel {



        // объект клиента
        protected $client = null;



        // родительский объект
        protected $parent = null;



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
        *  @param   string  $password   пароль,
        *                               остальные параметры извлекаются из:
        *                                   $this->parent->protocol - протокол
        *                                   $this->parent->server - сервер
        *                                   $this->parent->port - порт
        *                                   $this->parent->login - логин
        *                                   $this->parent->timeout - величина таймаута
        *  @return  boolean             TRUE если связь установлена,
        *                               иначе описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        public function open ( $password ) {

            // устанавливаем связь через сокет
            $result = FALSE;
            if (isset($this->parent)) {
                $this->parent->error_msg = '';



                // берем url сервера (устанавливаем переменные $protocol + $server)
                $protocol = explode(':', $this->parent->protocol, 2);
                $protocol = strtolower(trim($protocol[0])) . '://';
                $server = str_replace('\\', '/', $this->parent->server);
                $server = explode('://', $server, 2);
                $server = isset($server[1]) ? strtolower(trim($server[1])) : strtolower(trim($server[0]));



                // открываем соединение
                if (class_exists('SoapClient')) {
                    try {
                        $this->client = @ new SoapClient($protocol . $server);
                    } catch (Exception $e) {
                        $this->client = null;
                        $this->parent->error_msg = $e->getMessage();
                    }



                    // если соединение установлено
                    if (!is_null($this->client)) {



                        // авторизуемся
                        $auth = array('login' => $this->parent->login,
                                      'password' => $password);
                        try {
                            $result = @ $this->client->Auth($auth);
                            if (!isset($result->AuthResult)) {
                                if (!is_object($result)) $result = new stdClass;
                                $result->AuthResult = 'Ответ авторизации не содержит поле AuthResult.';
                            }
                        } catch (Exception $e) {
                            $result = new stdClass;
                            $result->AuthResult = $e->getMessage();
                        }



                        // проверяем успех
                        switch ($result->AuthResult) {
                            case 'Вы успешно авторизировались':
                                $result = TRUE;
                                break;
                            case 'Не достаточно параметров для выполнения функции':
                                $this->parent->error_msg = 'В запрос авторизации не были переданы все необходимые параметры (непустой логин, непустой пароль).';
                                $result = FALSE;
                                break;
                            default:
                                $this->parent->error_msg = rtrim($result->AuthResult, ". \t\r\n") . '.';
                                $result = FALSE;
                        }
                    }



                // иначе PHP без поддержки SOAP
                } else {
                    $this->parent->error_msg = 'Отключена поддержка SOAP функций в PHP на сайте (смотрите параметр extension=soap.so (php_soap.dll для Win) в файле php.ini).';
                }
            }



            // возвращаем результат ВЫПОЛНЕНО / НЕТ
            return $result;
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

            // если есть родительский объект
            if (isset($this->parent)) {



                // уничтожаем клиент
                $this->client = null;
            }
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



            // отправляем
            $sms = array('sender' => $this->parent->sender,
                         'destination' => $recipient,
                         'text' => $message);
            if ($wap != '') $sms['wappush'] = $wap;
            try {
                $result = @ $this->client->SendSMS($sms);
                if (!isset($result->SendSMSResult->ResultArray[0])) {
                    if (!is_object($result)) $result = new stdClass;
                    if (!isset($result->SendSMSResult) || !is_object($result->SendSMSResult)) $result->SendSMSResult = new stdClass;
                    $result->SendSMSResult->ResultArray = array();
                    $result->SendSMSResult->ResultArray[0] = 'Ответ отправки SMS не содержит поле SendSMSResult-&gt;ResultArray[0].';
                }
            } catch (Exception $e) {
                $result = new stdClass;
                $result->SendSMSResult = new stdClass;
                $result->SendSMSResult->ResultArray = array();
                $result->SendSMSResult->ResultArray[0] = $e->getMessage();
            }



            // проверяем успех
            switch ($result->SendSMSResult->ResultArray[0]) {
                case 'Сообщения успешно отправлены':
                    $result = TRUE;
                    break;
                case 'Не достаточно параметров для выполнения функции':
                    $this->parent->error_msg = 'В отправку SMS не были переданы все необходимые параметры (непустое имя отправителя, непустой номер получателя, непустой текст).';
                    $result = FALSE;
                    break;
                default:
                    $this->parent->error_msg = rtrim($result->SendSMSResult->ResultArray[0], ". \t\r\n") . '.';
                    $result = FALSE;
            }



            // возвращаем ОТПРАВЛЕНО / НЕТ
            return $result;
        }



        // ===================================================================
        /**
        *  Чтение баланса счета
        *
        *  @access  public
        *  @return  boolean             баланс или FALSE при ошибке,
        *                               описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        public function balance () {

            // запрашиваем баланс
            try {
                $result = @ $this->client->GetCreditBalance();
                if (!isset($result->GetCreditBalanceResult)) {
                    if (!is_object($result)) $result = new stdClass;
                    $result->GetCreditBalanceResult = 'Ответ запроса баланса не содержит поле GetCreditBalanceResult.';
                }
            } catch (Exception $e) {
                $result = new stdClass;
                $result->GetCreditBalanceResult = $e->getMessage();
            }



            // возвращаем БАЛАНС / ОШИБКА
            $value = preg_replace('/[0-9,\.\-\s\t\r\n]/', '', $result->GetCreditBalanceResult);
            if ($value == '') return $result->GetCreditBalanceResult;

            $this->parent->error_msg = $result->GetCreditBalanceResult;
            return FALSE;
        }
    }



    return;
?>