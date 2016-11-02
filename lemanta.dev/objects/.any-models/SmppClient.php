<?php
    // =======================================================================
    /**
    *  SMPP клиент
    *
    *  Реализация под частный случай (BusinessLife.com.ua):
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



    // идентификатор авторизационного пакета данных,
    // идентификатор информационного пакета данных,
    // идентификатор закрывающего пакета данных
    define('SMPP_AUTHORIZATION_DATAPACKET_ID', 2);
    define('SMPP_INFORMATION_DATAPACKET_ID', 4);
    define('SMPP_FINALIZATION_DATAPACKET_ID', 6);



    // значения состояний в ответах сервера
    define('SMPP_RESULT_STATUS_OK', 0);



    class SmppClientANYModel {



        // идентификатор сокета,
        // порядковый номер пакета данных,
        // способ кодирования данных
        protected $socket = FALSE;
        protected $seq = 0;
        protected $data_coding = 0;



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
                $this->socket = @ fsockopen($protocol . $server,
                                            $this->parent->port,
                                            $error_code,
                                            $this->parent->error_msg,
                                            $this->parent->timeout);
                if ($this->socket !== FALSE) {



                    // задаем таймаут для потока
                    if (function_exists('stream_set_timeout')) {
                        @ stream_set_timeout($this->socket, $this->parent->timeout);
                    }



                    // отправляем авторизационный пакет данных (строка, строка, строка, байт, байт, байт, строка)
                    $order = "%s\0"
                           . "%s\0"
                           . "%s\0"
                           . '%c'
                           . '%c'
                           . '%c'
                           . "%s\0";
                    $system_id = $this->parent->login;
                    $system_type = '';
                    $interface_version = 0x34;
                    $addr_ton = 5;
                    $addr_npi = 0;
                    $address_range = '';
                    $packet = sprintf($order, $system_id,
                                              $password,
                                              $system_type,
                                              $interface_version,
                                              $addr_ton,
                                              $addr_npi,
                                              $address_range);
                    $result = $this->send_packet(SMPP_AUTHORIZATION_DATAPACKET_ID, $packet);



                    // при успехе должен установиться элемент массива status
                    $result = isset($result['status']) && ($result['status'] == SMPP_RESULT_STATUS_OK);
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



                // отправляем закрывающий пакет данных
                $this->send_packet(SMPP_FINALIZATION_DATAPACKET_ID, '');



                // закрываем связь через сокет
                @ fclose($this->socket);
            }
        }



        // ===================================================================
        /**
        *  Отправка сообщения
        *
        *  @access  public
        *  @param   string  $recipient  номер получателя
        *  @param   string  $message    текст сообщения
        *  @param   boolean $utf        признак "в кодировке UTF"
        *  @param   boolean $flash      признак "в формате FLASH"
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



            // задаем способ кодирования данных
            $this->data_coding = 0;
            if ($utf) $this->data_coding = 0x08;
            if ($flash) $this->data_coding = $this->data_coding | 0x10;



            // вычисляем длину сообщения
            $size = strlen($message);
            if ($utf) $size += 20;



            // если уместится в одно короткое сообщение, отправляем его (в конец пакета добавляем команду подтверждения отправки)
            if ($size < 160) return $this->submit($recipient, $message, $this->charging_id(TRUE));



            // иначе делим сообщение на несколько коротких и отправляем одно за другим
            // (в конец последнего пакета добавляем команду подтверждения отправки)
            $sar_msg_ref_num = rand(1, 255);
            $sar_total_segments = ceil(strlen($message) / 130);
            for ($sar_segment_seqnum = 1; $sar_segment_seqnum <= $sar_total_segments; $sar_segment_seqnum++) {
                $part = substr($message, 0, 130);
                $message = substr($message, 130);
                $optional = pack('nnn', 0x020C, 2, $sar_msg_ref_num)
                          . pack('nnc', 0x020E, 1, $sar_total_segments)
                          . pack('nnc', 0x020F, 1, $sar_segment_seqnum)
                          . $this->charging_id($sar_segment_seqnum == $sar_total_segments);
                if (!$this->submit($recipient, $part, $optional)) return FALSE;
            }



            // возвращаем ОТПРАВЛЕНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Чтение баланса счета
        *
        *  @access  public
        *  @return  boolean             FALSE всегда (так как функция не поддерживается),
        *                               описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        public function balance () {

            // возвращаем НЕТ ДАННЫХ
            $this->parent->error_msg = 'Функция запроса баланса счета не поддерживается этим SMS-сервером!';
            return FALSE;
        }



        // ===================================================================
        /**
        *  Отправка короткого сообщения
        *
        *  @access  protected
        *  @param   string  $dest_addr  адрес назначения
        *  @param   string  $message    текст сообщения
        *  @param   string  $optional   опциональные сведения
        *  @return  boolean             TRUE если отправлено,
        *                               иначе описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        protected function submit ($dest_addr, $message, $optional = '') {

            // отправляем информационный пакет данных (строка, байт, байт, строка, байт, байт, строка, байт, байт, байт, строка, строка, байт, байт, байт, байт, байт, строка)
            $order = "%s\0"
                   . '%c'
                   . '%c'
                   . "%s\0"
                   . '%c'
                   . '%c'
                   . "%s\0"
                   . '%c'
                   . '%c'
                   . '%c'
                   . "%s\0"
                   . "%s\0"
                   . '%c'
                   . '%c'
                   . '%c'
                   . '%c'
                   . '%c'
                   . '%s';
            $service_type = '';
            $source_addr_ton = 5;
            $source_addr_npi = 0;
            $source_addr = $this->parent->sender;
            $dest_addr_ton = 1;
            $dest_addr_npi = 1;
            $esm_class = 0;
            $protocol_id = 0;
            $priority_flag = 0;
            $schedule_delivery_time = '';
            $validity_period = '';
            $registered_delivery = 0;
            $replace_if_present_flag = 0;
            $sm_default_msg_id = 0;
            $packet = sprintf($order, $service_type,
                                      $source_addr_ton,
                                      $source_addr_npi,
                                      $source_addr,
                                      $dest_addr_ton,
                                      $dest_addr_npi,
                                      $dest_addr,
                                      $esm_class,
                                      $protocol_id,
                                      $priority_flag,
                                      $schedule_delivery_time,
                                      $validity_period,
                                      $registered_delivery,
                                      $replace_if_present_flag,
                                      $this->data_coding,
                                      $sm_default_msg_id,
                                      strlen($message),
                                      $message)
                                    . $optional;
            $result = $this->send_packet(SMPP_INFORMATION_DATAPACKET_ID, $packet);



            // при успехе должен установиться элемент массива status
            $result = isset($result['status']) && ($result['status'] == SMPP_RESULT_STATUS_OK);



            // возвращаем результат ВЫПОЛНЕНО / НЕТ
            return $result;
        }



        // ===================================================================
        /**
        *  Отправка пакета данных
        *
        *  @access  protected
        *  @param   integer $id         идентификатор пакета
        *  @param   string  $packet     текст пакета
        *  @return  boolean             TRUE если отправлено,
        *                               иначе описание ошибки заносится в:
        *                                   $this->parent->error_msg
        */
        // ===================================================================

        protected function send_packet ( $id, $packet ) {

            // прикрепляем спереди к пакету 16-байтный заголовок и отправляем на сервер
            $this->seq += 1;
            $packet = pack('NNNN', strlen($packet) + 16, $id, 0, $this->seq) . $packet;
            @ fputs($this->socket, $packet);



            // читаем ответный пакет сервера (размера пакет + его содержимое)
            $result = FALSE;
            $packet = @ fread($this->socket, 4);
            if (($packet !== FALSE) && (strlen($packet) == 4)) {
                $size = unpack('Nlength', $packet);
                $size = $size['length'];
                $size -= 4;
                if ($size >= 12) {



                    // читаем содержимое пакета
                    $packet = @ fread($this->socket, $size);
                    if ($size == strlen($packet)) {
                        $result = unpack('Nid/Nstatus/Nseq', $packet);
                        if (!isset($result['status'])) {
                            $result = FALSE;
                        } elseif ($result['status'] != SMPP_RESULT_STATUS_OK) {
                            $this->parent->error_msg = 'SMS-сервер возвратил код состояния ' . intval($result['status']) . ' вместо ожидаемого кода ' . SMPP_RESULT_STATUS_OK . ' успешного выполнения!';
                        }
                    }
                }
            }



            // если не удалось прочитать ответ сервера
            if ($result === FALSE) $this->parent->error_msg = 'Связь с SMS-сервером была прервана!';



            // возвращаем результат МАССИВ / НЕ УДАЛОСЬ
            return $result;
        }



        // ===================================================================
        /**
        *  Генерация команды подтверждения отправки
        *
        *  @access  protected
        *  @param   boolean $state      TRUE если команда "Отправить", иначе команда "Пока не отправлять"
        *  @return  mixed               сформированная команда
        */
        // ===================================================================

        protected function charging_id ( $state ) {

            // команда + строка 1 или 0 (1 = отправить, 0 = пока не отправлять)
            return pack('n', 0x2010) . sprintf("%s\0", $state ? '1' : '0');
        }
    }



    return;
?>