<?php
    // =======================================================================
    /**
    *  @package     Impera CMS
    *  @file        Substrate for payment modules
    *  @version     1.3
    *  @author      AIMatrix, Ukraine
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru/
    */
    // =======================================================================

    // выключаем информирование об ошибках
    error_reporting(0);

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_GET['_SERVER']) || isset($_GET['_ENV']) || isset($_GET['_COOKIE'])
    || isset($_GET['_GET']) || isset($_GET['_POST']) || isset($_GET['_REQUEST'])
    || isset($_GET['_FILES']) || isset($_GET['_SESSION']) || isset($_GET['GLOBALS'])) exit;

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_POST['_SERVER']) || isset($_POST['_ENV']) || isset($_POST['_COOKIE'])
    || isset($_POST['_GET']) || isset($_POST['_POST']) || isset($_POST['_REQUEST'])
    || isset($_POST['_FILES']) || isset($_POST['_SESSION']) || isset($_POST['GLOBALS'])) exit;

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_COOKIE['_SERVER']) || isset($_COOKIE['_ENV']) || isset($_COOKIE['_COOKIE'])
    || isset($_COOKIE['_GET']) || isset($_COOKIE['_POST']) || isset($_COOKIE['_REQUEST'])
    || isset($_COOKIE['_FILES']) || isset($_COOKIE['_SESSION']) || isset($_COOKIE['GLOBALS'])) exit;

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_FILES['_SERVER']) || isset($_FILES['_ENV']) || isset($_FILES['_COOKIE'])
    || isset($_FILES['_GET']) || isset($_FILES['_POST']) || isset($_FILES['_REQUEST'])
    || isset($_FILES['_FILES']) || isset($_FILES['_SESSION']) || isset($_FILES['GLOBALS'])) exit;

    // блокируем нелегальный запуск файла
    if (!isset($legalStart) || !$legalStart) exit;
    unset($legalStart);

    // выходим в корень сайта
    chdir('../');

    // подключаем необходимые классы
    require_once('objects/Definition.php');
    require_once('objects/Basic.php');



    // =======================================================================
    /**
    *  Подложка платежного модуля
    */
    // =======================================================================

    class PaymentModuleSubstrate extends Basic {

        // меточное имя модуля
        protected $marker = '';

        // вспомогательные поля
        protected $id = 0;
        protected $order = null;
        protected $pay_id = 0;
        protected $method = null;
        protected $sign = '';
        protected $sum = '';
        protected $secret = '';



        // ===================================================================
        /**
        *  Проверка что поле объекта (допустим также массив) является массивом
        *
        *  @access  public
        *  @param   object  $object     объект (или массив)
        *  @param   string  $field      имя поля
        *  @param   boolean $nonempty   TRUE если проверить на непустоту
        *  @return  boolean             TRUE если точно массив
        */
        // ===================================================================

        public function fieldMustbeArray ( & $object, $field, $nonempty = FALSE ) {
            if (is_object($object)) {
                if (!isset($object->$field) || !is_array($object->$field)) return FALSE;
                return !$nonempty || !empty($object->$field);
            } elseif (is_array($object)) {
                if (!isset($object[$field]) || !is_array($object[$field])) return FALSE;
                return !$nonempty || !empty($object[$field]);
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка что переменная является объектом или массивом
        *
        *  @access  public
        *  @param   mxied   $var        переменная
        *  @param   boolean $nonempty   TRUE если проверить на непустоту
        *  @return  boolean             TRUE если точно объект или массив
        */
        // ===================================================================

        public function mustbeObjectOrArray ( & $var, $nonempty = FALSE ) {
            return (is_object($var) || is_array($var)) && (!$nonempty || !empty($var));
        }



        // ===================================================================
        /**
        *  Извлечение значения из POST-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   string  $type       тип (string, text, words,
        *                                    boolean, flag,
        *                                    float, positive, percent,
        *                                    integer, natural,
        *                                    chars)
        *  @param   mixed   $default    значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getPostParam ( $param, $type = 'chars', $default = null ) {
            if (!isset($_POST)) return $default;
            return $this->getObjectField($_POST, $param, $type, $default);
        }



        // ===================================================================
        /**
        *  Добавление POST-параметра
        *
        *  @access  protected
        *  @param   string  $param      имя параметра
        *  @param   mixed   $value      значение
        *  @return  void
        */
        // ===================================================================

        protected function addPostParam ( $param, $value ) {
            if (!isset($_POST) || !is_array($_POST)) $_POST = array();
            $_POST[$param] = $value;
        }



        // ===================================================================
        /**
        *  Извлечение значения из поля объекта (допустим также массив)
        *
        *  @access  public
        *  @param   object  $object     объект (или массив)
        *  @param   string  $param      имя поля
        *  @param   string  $type       тип (string, text, words,
        *                                    boolean, flag,
        *                                    float, positive, percent,
        *                                    integer, natural,
        *                                    chars)
        *  @param   mixed   $default    значение по умолчанию
        *  @return  mixed               значение поля
        */
        // ===================================================================

        public function getObjectField ( & $object, $field, $type = 'chars', $default = null ) {

            // запоминаем ссылку на поле объекта (или элемент массива)
            if (is_array($object) && isset($object[$field])) {
                $src = & $object[$field];
            } elseif (is_object($object) && isset($object->$field)) {
                $src = & $object->$field;
            } else {
                $src = null;
            }

            // какой тип хотят получить в результате?
            $type = trim($this->text->lowerCase($type));
            switch ($type) {

                // если булевое значение
                case 'boolean':
                    if (is_null($default)) $default = FALSE;
                    return !is_null($src) ? ($src == TRUE) : $default;

                // если целочисленное булевое значение (1 или 0)
                case 'flag':
                    if (is_null($default)) $default = 0;
                    return !is_null($src) ? ($src == 1 ? 1 : 0) : $default;

                // если целое число
                case 'integer':
                    if (is_null($default)) $default = 0;
                    return !is_null($src) ? @ intval($src) : $default;

                // если натуральное число (расширенный ряд)
                case 'natural':
                    if (is_null($default)) $default = 0;
                    return !is_null($src) ? max(@ intval($src), 0) : $default;

                // если дробное число
                case 'float':
                    if (is_null($default)) $default = 0;
                    return !is_null($src) ? @ $this->number->floatValue($src) : $default;

                // если положительное дробное число
                case 'positive':
                    if (is_null($default)) $default = 0;
                    return !is_null($src) ? max(@ $this->number->floatValue($src), 0) : $default;

                // если проценты (дробное число от 0 до 100)
                case 'percent':
                    if (is_null($default)) $default = 0;
                    return !is_null($src) ? max(min(@ $this->number->floatValue($src), 100), 0) : $default;

                // если текст (без тегов HTML-разметки и пробелов с концов)
                case 'text':
                    if (is_null($default)) $default = '';
                    return !is_null($src) ? trim(@ $this->text->stripTags($src)) : $default;

                // если набор слов (текст без тегов HTML-разметки, переносов строк и сокращением избыточных пробелов)
                case 'words':
                    if (is_null($default)) $default = '';
                    return !is_null($src) ? @ $this->text->stripTags($src, TRUE) : $default;

                // если строка (без пробелов с концов)
                case 'string':
                    if (is_null($default)) $default = '';
                    return !is_null($src) ? @ trim($src) : $default;

                // если набор символов (необработанный параметр как он поступил в запросе)
                case 'chars':
                default:
                    if (is_null($default)) $default = '';
                    return !is_null($src) ? $src : $default;
            }
        }



        // ===================================================================
        /**
        *  Чтение необходимого заказа
        *
        *  @access  public
        *  @param   integer $id     идентификатор заказа
        *  @return  mixed           запись о заказе
        *                           или TRUE если заказ уже оплачен
        *                           или FALSE если заказа нет
        */
        // ===================================================================

        public function getRequestedOrder ( $id ) {

            // читаем необходимый заказ
            $filter = new stdClass;
            $filter->id = $id;
            $order = null;
            $this->db->orders->one($order, $filter);

            // такого заказа нет?
            if (!$this->mustbeObjectOrArray($order, TRUE)) return FALSE;

            // может он уже оплачен?
            $status = $this->getObjectField($order, 'payment_status', 'flag');
            if ($status) return TRUE;

            // иначе возвращаем запись о заказе
            return $order;
        }



        // ===================================================================
        /**
        *  Чтение необходимого способа оплаты
        *
        *  @access  public
        *  @param   integer $id     идентификатор способа оплаты
        *  @return  mixed           запись о способе оплаты
        *                           или TRUE если у способа оплаты нет или не те параметры
        *                           или FALSE если способа оплаты нет
        */
        // ===================================================================

        public function getRequestedMethod ( $id ) {

            // читаем необходимый способ оплаты
            $method = null;
            $filter = new stdClass;
            $filter->id = $id;
            $filter->enabled = 1;
            $this->db->payments->one($method, $filter);

            // такого способа оплаты нет?
            if (!$this->mustbeObjectOrArray($method, TRUE)) return FALSE;

            // может не те параметры?
            $name = $this->getObjectField($method, 'module', 'words');
            if ($this->text->lowerCase($name) != $this->text->lowerCase($this->marker)) return TRUE;

            // может не имеет параметров?
            $params = FALSE;
            if (isset($method->params)) {
                if ($this->mustbeObjectOrArray($method->params)) {
                    $params = $method->params;
                } elseif (is_string($method->params)) {
                    try {
                        $params = unserialize($method->params);
                        if (!$this->mustbeObjectOrArray($params)) $params = FALSE;
                    } catch (Exception $e) {
                        $params = FALSE;
                    }
                }
            }
            if ($params === FALSE) return TRUE;

            // иначе возвращаем запись о способе оплаты
            $method->params = & $params;
            return $method;
        }



        // ===================================================================
        /**
        *  Проверка что сумма заказа совпадает с заявленной
        *
        *  @access  public
        *  @param   object  $order      запись о заказе
        *  @param   object  $method     запись о способе оплаты
        *  @param   string  $sum        заявленная сумма
        *  @return  boolean             TRUE если сумма совпадает
        */
        // ===================================================================

        public function checkOrderSum ( & $order, & $method, $sum ) {
            $total = $this->getObjectField($order, 'total_amount', 'float');

            $rate_from = $this->getObjectField($method, 'rate_from', 'float');
            $rate_to = $this->getObjectField($method, 'rate_to', 'float', 1);
            if ($rate_to == 0) $rate_to = 1;

            $total = round($total * $rate_from / $rate_to, 2);
            $sum = round($this->number->floatValue($sum), 2);
            return $total == $sum && $sum > 0;
        }



        // ===================================================================
        /**
        *  Проверка наличия товаров заказа
        *
        *  @access  public
        *  @param   object  $order      запись о заказе
        *  @return  mixed               TRUE если проверка успешная
        *                               ОПИСАНИЕ ОШИБКИ если неудачно
        */
        // ===================================================================

        public function checkOrderProducts ( & $order ) {

            // проверяем наличие товаров
            if ($this->fieldMustbeArray($order, 'products', TRUE)) {
                foreach ($order->products as & $product) {
                    if ($this->mustbeObjectOrArray($product, TRUE)) {

                        // находим вариант товара
                        $pid = $this->getObjectField($product, 'product_id', 'integer');
                        $vid = $this->getObjectField($product, 'variant_id', 'integer');

                        $query = 'SELECT * '
                               . 'FROM `products_variants` '
                               . 'WHERE `product_id` = \'' . $this->db->query_value($pid) . '\' '
                                     . 'AND `variant_id` = \'' . $this->db->query_value($vid) . '\' '
                               . 'LIMIT 1';
                        $this->db->query($query);
                        $variant = $this->db->result();

                        // может варианта нет?
                        $name = $this->getObjectField($product, 'product_name', 'words');
                        if (!$this->mustbeObjectOrArray($variant, TRUE)) {
                            return 'Ошибка: Недоступны данные о товаре "' . htmlspecialchars($name, ENT_NOQUOTES) . '"!';
                        }

                        // может недостаточно в наличии
                        $quantity = $this->getObjectField($product, 'quantity', 'integer');
                        $stock = $this->getObjectField($variant, 'stock', 'integer');

                        if ($quantity > 0 && $quantity > $stock
                        && ($stock > 0 && !$this->request->settings->getAsBoolean('orders_deficit_enabled')
                        || $stock == 0 && !$this->request->settings->getAsBoolean('cart_enable_reservation'))) {
                            $vname = $this->getObjectField($variant, 'name', 'words');
                            return 'На складе нет достаточного количества товара "' . htmlspecialchars(trim($name . ' ' . $vname), ENT_NOQUOTES) . '".';
                        }
                    }
                }
            }

            // возвращаем ПРОВЕРЕНО УСПЕШНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Списание товаров заказа
        *
        *  @access  public
        *  @param   object  $order      запись о заказе
        *  @return  void
        */
        // ===================================================================

        public function amortizeOrderProducts ( & $order ) {

            // если еще не было сделано списание товара
            $status = $this->getObjectField($order, 'written_off', 'flag');
            if (!$status) {

                // если в настройках отключено виртуальное списывание
                if (!$this->request->settings->getAsBoolean('orders_non_touch_quantity')) {

                    // списываем товары
                    if ($this->fieldMustbeArray($order, 'products', TRUE)) {
                        foreach ($order->products as & $product) {
                            if ($this->mustbeObjectOrArray($product, TRUE)) {

                                $pid = $this->getObjectField($product, 'product_id', 'integer');
                                $vid = $this->getObjectField($product, 'variant_id', 'integer');
                                $quantity = $this->getObjectField($product, 'quantity', 'natural');

                                $query = 'UPDATE `products_variants` '
                                       . 'SET `stock` = CASE WHEN `stock` >= \'' . $this->db->query_value($quantity) . '\' '
                                                          . 'THEN `stock` - \'' . $this->db->query_value($quantity) . '\' '
                                                          . 'ELSE CASE WHEN `stock` >= 0 '
                                                                    . 'THEN 0 '
                                                                    . 'ELSE `stock` '
                                                                    . 'END '
                                                          . 'END '
                                       . 'WHERE `product_id` = \'' . $this->db->query_value($pid) . '\' '
                                             . 'AND `variant_id` = \'' . $this->db->query_value($vid) . '\' '
                                       . 'LIMIT 1';
                                $this->db->query($query);
                            }
                        }
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Установка в заказе признака оплаты и списания товаров
        *
        *  @access  public
        *  @param   integer $id         идентификатор заказа
        *  @param   integer $pay_id     идентификатор способа оплаты
        *  @return  void
        */
        // ===================================================================

        public function setOrderPayment ( $id, $pay_id ) {

            // формируем детали платежа
            $details = $_POST;
            foreach ($details as & $detail) $detail = $this->text->stripTags($detail);
            try {
                $details = var_export($details, TRUE);
                if (!is_string($details)) $details = '';
            } catch (Exception $e) {
                $details = '';
            }

            // ставим признак оплаты и списания товаров
            $query = 'UPDATE `orders` '
                   . 'SET `payment_status` = 1, '
                       . '`payment_date` = NOW(), '
                       . '`payment_method_id` = \'' . $this->db->query_value($pay_id) . '\', '
                       . '`payment_details` = \'' . $this->db->query_value($details) . '\', '
                       . '`written_off` = 1 '
                   . 'WHERE `order_id` = \'' . $this->db->query_value($id) . '\' '
                   . 'LIMIT 1';
            $this->db->query($query);
        }



        // ===================================================================
        /**
        *  Информирование об оплате заказа
        *
        *  @access  public
        *  @param   integer $id     идентификатор заказа
        *  @param   string  $name   имя платежного механизма
        *  @return  void
        */
        // ===================================================================

        public function informAboutOrderPayment ( $id, $name ) {

            // читываем необходимый заказ
            $order = & $this->getRequestedOrder($id);
            if (!$this->mustbeObjectOrArray($order, TRUE)) return;

            // уведомляем покупателя и администратора
            $this->smarty->assign('payway_name', $name);
            $this->inform_about_order($order,
                                      'Оплачен заказ №' . $id . ' на сайте ' . $this->root_url . ' (через ' . $name . ')',
                                      'Принята оплата заказа №' . $id . ' на сайте ' . $this->root_url,
                                      INFORM_ABOUT_ORDER_ACTION_PAYMENT);
        }



        // ===================================================================
        /**
        *  Начальные шаги оплаты заказа
        *
        *  @access  public
        *  @param   string  $id_param       имя POST-параметра ИД заказа
        *  @param   string  $id_msg1        сообщение о неудаче с заказом (нет ИД)
        *  @param   string  $id_msg2        сообщение о неудаче с заказом (нет заказа)
        *  @param   string  $id_msg3        сообщение о неудаче с заказом (уже оплачен)
        *  @param   string  $pay_id_param   имя POST-параметра ИД способа оплаты
        *  @param   string  $pay_id_msg1    сообщение о неудаче со способом (нет ИД)
        *  @param   string  $pay_id_msg2    сообщение о неудаче со способом (нет способа)
        *  @param   string  $pay_id_msg3    сообщение о неудаче со способом (нет параметров)
        *  @param   string  $sign_param     имя POST-параметра подписи
        *  @param   string  $sign_msg       сообщение о неудаче с подписью (нет подписи)
        *  @param   string  $sum_param      имя POST-параметра суммы
        *  @param   string  $sum_msg1       сообщение о неудаче с суммой (нет суммы)
        *  @param   string  $sum_msg2       сообщение о неудаче с суммой (неверная)
        *  @param   string  $secret_param   имя ПлатежныйМетод-параметра секретного слова
        *  @param   string  $secret_msg     сообщение о неудаче с секретом (нет секрета)
        *  @return  mixed                   TRUE если выполнено успешно
        *                                   ОПИСАНИЕ ОШИБКИ если неудачно
        */
        // ===================================================================

        public function startPayment ( $id_param,     $id_msg1, $id_msg2, $id_msg3,
                                       $pay_id_param, $pay_id_msg1, $pay_id_msg2, $pay_id_msg3,
                                       $sign_param,   $sign_msg,
                                       $sum_param,    $sum_msg1, $sum_msg2,
                                       $secret_param, $secret_msg ) {

            // извлекаем необходимый способ оплаты
            $result = $this->retrieveMethod($pay_id_param, $pay_id_msg1, $pay_id_msg2, $pay_id_msg3);
            if (is_string($result)) return $result;

            // извлекаем необходимый заказ
            $result = $this->retrieveOrder($id_param, $id_msg1, $id_msg2, $id_msg3);
            if (is_string($result)) return $result;

            // извлекаем контрольную подпись
            $result = $this->retrieveSignature($sign_param, $sign_msg);
            if (is_string($result)) return $result;

            // извлекаем сумму платежа
            $result = $this->retrieveOrderSum($sum_param, $sum_msg1, $sum_msg2);
            if (is_string($result)) return $result;

            // получаем секретный ключ
            $this->secret = $this->getObjectField($this->method->params, $secret_param, 'chars', FALSE);
            if ($this->secret === FALSE) return $secret_msg;

            // возвращаем НАЧАТО УСПЕШНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Извлечение способа оплаты на основе входных параметров
        *
        *  @access  public
        *  @param   string  $param      имя POST-параметра ИД способа оплаты
        *  @param   string  $msg1       сообщение о неудаче со способом (нет ИД)
        *  @param   string  $msg2       сообщение о неудаче со способом (нет способа)
        *  @param   string  $msg3       сообщение о неудаче со способом (нет параметров)
        *  @return  mixed               TRUE если выполнено успешно
        *                               ОПИСАНИЕ ОШИБКИ если неудачно
        */
        // ===================================================================

        public function retrieveMethod ( $param, $msg1, $msg2, $msg3 ) {

            // получаем идентификатор способа оплаты
            $this->pay_id = $this->getPostParam($param, 'integer');
            if ($this->pay_id == 0) return $msg1;

            // читаем необходимый способ оплаты
            $this->method = & $this->getRequestedMethod($this->pay_id);
            if ($this->method === FALSE) return $msg2;
            if ($this->method === TRUE) return $msg3;

            // возвращаем ИЗВЛЕЧЕНО УСПЕШНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Извлечение заказа на основе входных параметров
        *
        *  @access  public
        *  @param   string  $param      имя POST-параметра ИД заказа
        *  @param   string  $msg1       сообщение о неудаче с заказом (нет ИД)
        *  @param   string  $msg2       сообщение о неудаче с заказом (нет заказа)
        *  @param   string  $msg3       сообщение о неудаче с заказом (уже оплачен)
        *  @return  mixed               TRUE если выполнено успешно
        *                               ОПИСАНИЕ ОШИБКИ если неудачно
        */
        // ===================================================================

        public function retrieveOrder ( $param, $msg1, $msg2, $msg3 ) {

            // получаем идентификатор заказа
            $this->id = $this->getPostParam($param, 'integer');
            if ($this->id == 0) return $msg1;

            // читаем необходимый заказ
            $this->order = & $this->getRequestedOrder($this->id);
            if ($this->order === FALSE) return $msg2;
            if ($this->order === TRUE) return $msg3;

            // возвращаем ИЗВЛЕЧЕНО УСПЕШНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Извлечение суммы заказа на основе входных параметров
        *
        *  Метод должен вызываться после того, как извлечен заказ и метод оплаты.
        *
        *  @access  public
        *  @param   string  $param      имя POST-параметра суммы
        *  @param   string  $msg1       сообщение о неудаче с суммой (нет суммы)
        *  @param   string  $msg2       сообщение о неудаче с суммой (неверная)
        *  @return  mixed               TRUE если выполнено успешно
        *                               ОПИСАНИЕ ОШИБКИ если неудачно
        */
        // ===================================================================

        public function retrieveOrderSum ( $param, $msg1, $msg2 ) {

            // получаем сумму платежа
            $this->sum = $this->getPostParam($param, 'chars', FALSE);
            if ($this->sum === FALSE) return $msg1;

            // проверяем сумму оплаты
            if (!$this->checkOrderSum($this->order, $this->method, $this->sum)) return $msg2;

            // возвращаем ИЗВЛЕЧЕНО УСПЕШНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Извлечение контрольной подписи на основе входных параметров
        *
        *  @access  public
        *  @param   string  $param      имя POST-параметра подписи
        *  @param   string  $msg        сообщение о неудаче с подписью (нет подписи)
        *  @return  mixed               TRUE если выполнено успешно
        *                               ОПИСАНИЕ ОШИБКИ если неудачно
        */
        // ===================================================================

        public function retrieveSignature ( $param, $msg ) {

            // получаем контрольную подпись
            $this->sign = $this->getPostParam($param, 'chars', FALSE);
            if ($this->sign === FALSE) return $msg;
            $this->sign = $this->text->upperCase($this->sign);

            // возвращаем ИЗВЛЕЧЕНО УСПЕШНО
            return TRUE;
        }



        // ===================================================================
        /**
        *  Завершающие шаги оплаты заказа
        *
        *  @access  public
        *  @param   object  $order      запись о заказе
        *  @param   integer $pay_id     идентификатор способа оплаты
        *  @param   string  $name       имя платежного механизма
        *  @return  void
        */
        // ===================================================================

        public function finalizePayment ( & $order, $pay_id, $name ) {

            // списываем товары заказа
            if (!$this->mustbeObjectOrArray($order, TRUE)) return;
            $this->amortizeOrderProducts($order);

            // ставим в заказе признак оплаты и списания товаров
            $id = $this->getObjectField($order, 'order_id', 'integer');
            $this->setOrderPayment($id, $pay_id);

            // уведомляем покупателя и администратора
            $this->informAboutOrderPayment($id, $name);
        }



        // ===================================================================
        /**
        *  Обработка входных параметров
        *
        *  @access  public
        *  @return  string      результат
        */
        // ===================================================================

        public function process () {
            return '';
        }

    }



    return;
?>