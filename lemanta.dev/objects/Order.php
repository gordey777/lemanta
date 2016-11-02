<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;

    // подложка модуля клиентской стороны
    require_once(ROOT_FOLDER_REFERENCE
               . FOLDERNAME_FOR_ENGINE_OBJECTS
               . '/ClientSubstrate.php');

    // какой файл является шаблоном заказа на клиентской стороне (указываем без расширения)
    define('CLIENT_ORDER_CLASS_TEMPLATE_FILE', 'page.order');



    // =======================================================================
    /**
    *  Модуль заказа на клиентской стороне
    *
    *  Использование этого класса происходит в результате переназначения класса
    *  Order на данный класс во время загрузки модуля заказа.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientOrder extends ClientSubstrate {

        // заголовок страницы
        public $title = 'Заказ';



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

            if (isset($_GET['vk'])) {
                $crlf = "\r\n";
                $this->body = '';
                switch (strtolower(trim($_GET['vk']))) {
                    case 'fail':
                        $this->body = $this->vk_fail_message(isset($_GET['code']) ? $_GET['code'] : 0);
                        break;
                    case 'process':
                        $this->body = $this->vk_success_answer(isset($_REQUEST['notification_type']) ? $_REQUEST['notification_type'] : '');
                        break;
                    case 'success':
                        $this->body = $this->vk_success_answer(isset($_REQUEST['notification_type']) ? $_REQUEST['notification_type'] : '');
                        break;
                }
                if (isset($_POST['from']) && ($_POST['from'] == 'popup')) {
                    $url = '';
                    if (isset($_POST['url']) && isset($_POST['custom_1'])) {
                        $url = trim($_POST['custom_1']);
                        if ($url != '') {
                            $order = $this->get_order_by_id($url);
                            if (isset($order->code)) {
                                $url = addslashes('http://' . $root_url . '/order/' . $order->code);
                            } else {
                                $url = '';
                            }
                        }
                        if ($url == '') $url = addslashes(trim($_POST['url']));
                        if ($url != '') $url = 'if (!opener.closed) opener.location = \'' . $url . '\'; ';
                    }
                    if ($this->body != '') {
                        $this->body .= '<br><br><a href="#" onclick="' . $url . 'window.close(); return false;">закрыть окно</a>';
                    } else {
                        $this->body = '<script language="JavaScript" type="text/javascript">' . $crlf
                                    . '    <!--' . $crlf
                                    . '    ' . $url . $crlf
                                    . '    window.close();' . $crlf
                                    . '    // -->' . $crlf
                                    . '</script>' . $crlf;
                    }
                }
                return $this->body;
            }



            // берем из входных параметров код (url) запрошенного заказа
            $code = $this->param('order_code');
            if ($code == '') $code = isset($_SESSION['order_code']) ? trim($_SESSION['order_code']) : '';
            if ($code == '') return;



            // читаем данные заказа
            $params = new stdClass;
            $params->code = $code;
            $this->db->orders->one($order, $params);
            if (empty($order)) return;



            $currency = null;
            foreach ($this->currencies as $item) {
                if (strtolower($item->code) == 'rur') {
                    $currency = $item;
                    break;
                }
            }
            $this->db->fill_order_vkontakte_payment_data($order, $currency);



            if (!empty($order->delivery_method_id)) {
                $query = 'SELECT `payment_methods`.*, '
                              . '`currencies`.`rate_from` AS `currency_rate_from`, '
                              . '`currencies`.`rate_to` AS `currency_rate_to`, '
                              . '`currencies`.`sign` AS `currency_sign`, '
                              . '`currencies`.`code` AS `currency_code` '
                       . 'FROM `payment_methods`, '
                            . '`delivery_payment`, '
                            . '`currencies` '
                       . 'WHERE `payment_methods`.`enabled` = 1 '
                             . 'AND `delivery_payment`.`payment_method_id` = `payment_methods`.`payment_method_id` '
                             . 'AND `delivery_payment`.`delivery_method_id` = \'' . $this->db->query_value($order->delivery_method_id) . '\' '
                             . 'AND `currencies`.`currency_id` = `payment_methods`.`currency_id` '
                       . 'ORDER BY `payment_methods`.`order_num` DESC, '
                                . '`payment_methods`.`name` ASC;';
            } else {
                $query = 'SELECT `payment_methods`.*, '
                              . '`currencies`.`rate_from` AS `currency_rate_from`, '
                              . '`currencies`.`rate_to` AS `currency_rate_to`, '
                              . '`currencies`.`sign` AS `currency_sign`, '
                              . '`currencies`.`code` AS `currency_code` '
                       . 'FROM `payment_methods`, '
                            . '`currencies` '
                       . 'WHERE `payment_methods`.`enabled` = 1 '
                             . 'AND `currencies`.`currency_id` = `payment_methods`.`currency_id` '
                       . 'ORDER BY `payment_methods`.`order_num` DESC, '
                                . '`payment_methods`.`name` ASC;';
            }
            $this->db->query($query);
            $methods = $this->db->results();



            // дополняем способы оплаты формами оплаты
            foreach ($methods as $k => $item) {
                $methods[$k]->amount = round($order->total_amount * $item->currency_rate_from / $item->currency_rate_to, 2);
                $methods[$k]->payment_button = $this->payment_button($item, $order);
            }



            // если просят задать желаемый способ оплаты
            if (isset($_POST['desire_payment_id'])) {
                $id = intval($_POST['desire_payment_id']);

                // ищем такой способ оплаты в списке
                foreach ($methods as $item) {

                    // если способ найден
                    if ($item->payment_method_id == $id) {

                        // передаем сведения в заказ
                        $order->desire_payment_id = $id;
                        $order->desire_payment = $item->name;

                        // обновляем сведения в базе данных
                        $query = 'UPDATE `' . DATABASE_ORDERS_TABLENAME . '` '
                               . 'SET `desire_payment_id` = \'' . $this->db->query_value($id) . '\' '
                               . 'WHERE `order_id` = \'' . $this->db->query_value($order->order_id) . '\' '
                               . 'LIMIT 1;';
                        $this->db->query($query);

                        // прерываем поиск
                        break;
                    }
                }
            }



            // если в заказе установлен желаемый способ оплаты, переставляем его наверх списка способов оплаты
            if (!empty($order->desire_payment_id)) {
                foreach ($methods as $k => $item) {
                    if ($item->payment_method_id == $order->desire_payment_id) {
                        array_unshift($methods, $item);
                        $k++;
                        unset($methods[$k]);
                        break;
                    }
                }
                $methods = array_values($methods);
            }

            // передаем данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_ORDER, $order);
            $this->smarty->assignByRef('PaymentMethods', $methods);

            // создаем контент модуля
            $this->smarty->fetchByTemplate($this, CLIENT_ORDER_CLASS_TEMPLATE_FILE, 'order');

            // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
            return TRUE;
        }



        // создание кнопки способа оплаты ========================================

        private function payment_button ( $method, $order ) {

            // url разных частей сайта
            $root_url = 'http://' . $this->root_url . '/';
            $order_url = $root_url . 'order/';
            $module_url = $root_url . 'connectors/';



            // определяем сумму
            $sum = str_replace(',', '.', round($method->amount, 2));



            // указываем описание платежа
            $id = trim($order->order_id);
            $description = 'Оплата заказа ' . $id;



            // определяем валюту
            $currency = trim(strtoupper($method->currency_code));



            // указываем финальный URL и URL ошибки
            $code = trim($order->code);
            $success_url = $order_url . $code;
            $fail_url = $order_url . $code;



            // дополнительные параметры (ИД способа оплаты)
            $payment_id = $method->payment_method_id;



            // какой класс модуля у способа оплаты?
            $crlf = "\r\n";
            $class = strtolower(trim($method->module));
            switch ($class) {

                // если LiqPAY
                case 'liqpay':

                    // проверяем валюту
                    if (($currency == 'USD') || ($currency == 'UAH')
                    || ($currency == 'RUR') || ($currency == 'EUR')) {

                        // извлекаем параметры способа оплаты
                        $params = @ unserialize($method->params);
                        $merchant = isset($params['liqpay_merchant_id']) ? trim($params['liqpay_merchant_id']) : '';

                        // указываем описание платежа (важно! LiqPAY не поддерживает кирилицу)
                        $description = 'Payment for order ' . $id;

                        // указываем финальный URL и верификационный URL (в оба обязательно нужно передать параметр method, параметр order только в первый)
                        $result_url = $module_url . $class . '.php?method=' . $payment_id . '&order=' . $code;
                        $server_url = $module_url . $class . '.php?method=' . $payment_id;

                        // готовим XML, разрешающий оплату с пластиковой карты, или внутреннего счета LiqPAY, или наличными
                        // в терминале самообслуживания (срок оплаты в терминале ставим равным 120 часов = 5 суток)
                        $xml = '<request>' . $crlf
                             . '    <version>1.2</version>' . $crlf
                             . '    <merchant_id>' . htmlspecialchars($merchant, ENT_QUOTES)                                  . '</merchant_id>' . $crlf
                             . '    <result_url>'  . htmlspecialchars(trim($this->text->stripTags($result_url, TRUE)), ENT_QUOTES) . '</result_url>' . $crlf
                             . '    <server_url>'  . htmlspecialchars(trim($this->text->stripTags($server_url, TRUE)), ENT_QUOTES) . '</server_url>' . $crlf
                             . '    <order_id>'    . htmlspecialchars($id, ENT_QUOTES)                                        . '</order_id>' . $crlf
                             . '    <amount>'      . $sum                                                                     . '</amount>' . $crlf
                             . '    <currency>'    . htmlspecialchars($currency, ENT_QUOTES)                                  . '</currency>' . $crlf
                             . '    <description>' . htmlspecialchars($description, ENT_QUOTES)                               . '</description>' . $crlf
                             . '    <pay_way>'     . (isset($params['liqpay_through_terminal'])
                                                      && $params['liqpay_through_terminal'] ? 'delayed' : 'card,liqpay')      . '</pay_way>' . $crlf
                             . (isset($params['liqpay_through_terminal'])
                                && $params['liqpay_through_terminal']
                                && isset($params['liqpay_exp_time'])
                                && (intval($params['liqpay_exp_time']) > 0) ?
                                   '    <exp_time>' . intval($params['liqpay_exp_time'])                                      . '</exp_time>' . $crlf : '')
                             . '</request>' . $crlf;

                        // упаковываем XML
                        $key = isset($params['liqpay_secret_key']) ? $params['liqpay_secret_key'] : '';
                        $signature = @ base64_encode(sha1($key . $xml . $key, 1));
                        $xml = @ base64_encode($xml);

                        // берем URL шлюза
                        $gate = isset($params['liqpay_gate_url']) ? trim($params['liqpay_gate_url']) : '';
                        if ($gate == '') $gate = LIQPAY_DEFAULT_GATE_URL;

                        // создаем форму с кнопкой (если задан мерчант)
                        if ($merchant != '') {
                            $button = '<form accept-charset="utf-8" action="' . htmlspecialchars($gate, ENT_QUOTES) . '" enctype="text/html" method="post">'
                                        . '<input type="hidden" name="operation_xml" value="' . $xml . '" />'
                                        . '<input type="hidden" name="signature" value="' . $signature . '" />'
                                        . '<input type="submit" value="Оплатить &#8594;" />'
                                    . '</form>';

                        // иначе создаем форму с кнопкой (на публичном ключе)
                        } else {

                            // берем URL шлюза
                            $gate = isset($params['liqpay_gate_url']) ? trim($params['liqpay_gate_url']) : '';
                            if ($gate == '') $gate = 'https://www.liqpay.com/api/pay';

                            $button = '<form action="' . htmlspecialchars($gate, ENT_QUOTES) . '" method="post">'
                                        . '<input type="hidden" name="public_key" value="' . htmlspecialchars($key, ENT_QUOTES) . '" />'
                                        . '<input type="hidden" name="amount" value="' . $sum . '" />'
                                        . '<input type="hidden" name="currency" value="' . htmlspecialchars($currency, ENT_QUOTES) . '" />'
                                        . '<input type="hidden" name="description" value="' . htmlspecialchars($description, ENT_QUOTES) . '" />'
                                        . '<input type="hidden" name="order_id" value="'    . htmlspecialchars($id, ENT_QUOTES) . '" />'
                                        . '<input type="hidden" name="server_url" value="'  . htmlspecialchars(trim($this->text->stripTags($result_url, TRUE)), ENT_QUOTES) . '" />'
                                        . '<input type="hidden" name="server_url" value="'  . htmlspecialchars(trim($this->text->stripTags($server_url, TRUE)), ENT_QUOTES) . '" />'
                                        . '<input type="hidden" name="type" value="buy" />'
                                        . '<input type="hidden" name="language" value="ru" />'
                                        . '<input type="submit" value="Оплатить &#8594;" />'
                                    . '</form>';
                        }

                    // иначе валюта способа оплаты не подходит
                    } else {
                        $button = 'Этот способ оплаты возможен только для валют: '
                                . 'USD - доллар, EUR - евро, RUR - российский рубль, '
                                . 'UAH - гривна. Однако в менеджерских настройках '
                                . 'способа оплаты почему-то указана иная валюта "'
                                . htmlspecialchars($currency, ENT_QUOTES) . '". '
                                . 'Пожалуйста, просим вас сообщить об этой ошибке '
                                . 'менеджерам нашего магазина через форму <a href="'
                                . htmlspecialchars($root_url, ENT_QUOTES)
                                . 'feedback">обратной связи</a>.';
                    }
                    break;



                // если Privat24
                case 'privat24':

                    // проверяем валюту
                    if (($currency == 'USD') || ($currency == 'UAH') || ($currency == 'EUR')) {

                        // извлекаем параметры способа оплаты
                        $params = @ unserialize($method->params);
                        $merchant = isset($params['privat24_merchant_id']) ? trim($params['privat24_merchant_id']) : '';

                        // указываем финальный URL и верификационный URL (в оба обязательно нужно передать параметр method, параметр order только в первый)
                        $result_url = $module_url . $class . '.php?method=' . $payment_id . '&order=' . $code;
                        $server_url = $module_url . $class . '.php?method=' . $payment_id;

                        // берем URL шлюза
                        $gate = isset($params['privat24_gate_url']) ? trim($params['privat24_gate_url']) : '';
                        if ($gate == '') $gate = PRIVAT24_DEFAULT_GATE_URL;

                        // создаем форму с кнопкой
                        $button = '<form action="' . htmlspecialchars($gate, ENT_QUOTES) . '" enctype="text/html" method="post">'
                                    . '<input type="hidden" name="order" value="' . htmlspecialchars($id, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="amt" value="' . $sum . '" />'

                                    . '<input type="hidden" name="ccy" value="' . htmlspecialchars($currency, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="merchant" value="' . htmlspecialchars($merchant, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="details" value="' . htmlspecialchars($description, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="return_url" value="' . htmlspecialchars(trim($this->text->stripTags($result_url, TRUE)), ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="server_url" value="' . htmlspecialchars(trim($this->text->stripTags($server_url, TRUE)), ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="ext_details" value="" />'
                                    . '<input type="hidden" name="pay_way" value="privat24" />'
                                    . '<input type="submit" value="Оплатить &#8594;" />'
                                . '</form>';

                    // иначе валюта способа оплаты не подходит
                    } else {
                        $button = 'Этот способ оплаты возможен только для валют: '
                                . 'USD - доллар, EUR - евро, UAH - гривна. Однако '
                                . 'в менеджерских настройках способа оплаты почему-то '
                                . 'указана иная валюта "' . htmlspecialchars($currency, ENT_QUOTES) . '". '
                                . 'Пожалуйста, просим вас сообщить об этой ошибке '
                                . 'менеджерам нашего магазина через форму <a href="'
                                . htmlspecialchars($root_url, ENT_QUOTES)
                                . 'feedback">обратной связи</a>.';
                    }
                    break;



                // если WebMoney
                case 'webmoney':

                    // извлекаем параметры способа оплаты
                    $params = @ unserialize($method->params);
                    $purse = isset($params['wm_merchant_purse']) ? trim($params['wm_merchant_purse']) : '';

                    // указываем финальный URL
                    $url = isset($params['success_url']) ? trim($params['success_url']) : '';
                    if ($url != '') $success_url = $url;

                    // указываем URL ошибки
                    $url = isset($params['fail_url']) ? trim($params['fail_url']) : '';
                    if ($url != '') $fail_url = $url;

                    // берем URL шлюза
                    $gate = isset($params['webmoney_gate_url']) ? trim($params['webmoney_gate_url']) : '';
                    if ($gate == '') $gate = WEBMONEY_DEFAULT_GATE_URL;

                    // создаем форму с кнопкой
                    $button = "<form accept-charset='cp1251' action='" . htmlspecialchars($gate, ENT_QUOTES) . "' method='post'>"
                                . "<input type='hidden' name='LMI_PAYEE_PURSE' value='" . htmlspecialchars($purse, ENT_QUOTES) . "' />"

                                . "<input type='hidden' name='LMI_PAYMENT_NO' value='" . htmlspecialchars($id, ENT_QUOTES) . "' />"
                                . "<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='" . $sum . "' />"

                                . "<input type='hidden' name='LMI_PAYMENT_DESC' value='" . htmlspecialchars($description, ENT_QUOTES) . "' />"

                                . "<input type='hidden' name='LMI_SUCCESS_URL' value='" . htmlspecialchars($success_url, ENT_QUOTES) . "' />"
                                . "<input type='hidden' name='LMI_FAIL_URL' value='" . htmlspecialchars($fail_url, ENT_QUOTES) . "' />"

                                . "<input type='hidden' name='PAYMENT_METHOD_ID' value='" . htmlspecialchars($payment_id, ENT_QUOTES) . "' />"

                                . "<input type='hidden' name='LMI_SIM_MODE' value='0' />"
                                . "<input type='submit' value='Оплатить &#8594;' />"
                            . "</form>";
                    break;



                // если Робокасса
                case 'robokassa':

                    // извлекаем параметры способа оплаты
                    $params = @ unserialize($method->params);
                    $login = isset($params['robokassa_login']) ? trim($params['robokassa_login']) : '';
                    $pass = isset($params['robokassa_password1']) ? $params['robokassa_password1'] : '';

                    // определяем валюту
                    $currency = 'PCR';

                    // определяем язык
                    $language = isset($params['robokassa_language']) ? trim($params['robokassa_language']) : '';

                    // вычисляем контрольную подпись
                    $crc  = md5($login . ':'
                              . $sum . ':'
                              . $id . ':'
                              . $pass . ':'
                              . 'Shp_item=' . $payment_id);

                    // берем URL шлюза
                    $gate = isset($params['gate_url']) ? trim($params['gate_url']) : '';
                    if ($gate == '') $gate = ROBOKASSA_DEFAULT_GATE_URL;

                    // создаем форму с кнопкой
                    $button = '<form accept-charset="cp1251" action="' . htmlspecialchars($gate, ENT_QUOTES) . '" method="post">'
                                . '<input type="hidden" name="MrchLogin" value="' . htmlspecialchars($login, ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="InvId" value="' . htmlspecialchars($id, ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="OutSum" value="' . $sum . '" />'

                                . '<input type="hidden" name="Desc" value="' . htmlspecialchars($description, ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="IncCurrLabel" value="' . htmlspecialchars($currency, ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="Culture" value="' . htmlspecialchars($language, ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="Shp_item" value="' . htmlspecialchars($payment_id, ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="SignatureValue" value="' . htmlspecialchars($crc, ENT_QUOTES) . '" />'
                                . '<input class="payment_button" type="submit" value="Оплатить &#8594;" />'
                            . '</form>';
                    break;



                // если RBK Money
                case 'rbkmoney':

                    // проверяем валюту
                    if (($currency == 'USD') || ($currency == 'UAH')
                    || ($currency == 'RUR') || ($currency == 'EUR')) {

                        // извлекаем параметры способа оплаты
                        $params = @ unserialize($method->params);
                        $merchant = isset($params['merchant_id']) ? trim($params['merchant_id']) : '';
                        $secret = isset($params['secret_key']) ? $params['secret_key'] : '';

                        // определяем сумму
                        $sum = str_replace('.', ',', $sum);

                        // определяем язык
                        $language = isset($params['language']) ? trim($params['language']) : '';
                        if ($language == '') $language = 'ru';

                        // указываем финальный URL
                        $url = isset($params['success_url']) ? trim($params['success_url']) : '';
                        if ($url != '') $success_url = $url;

                        // указываем URL ошибки
                        $url = isset($params['fail_url']) ? trim($params['fail_url']) : '';
                        if ($url != '') $fail_url = $url;

                        // берем URL шлюза
                        $gate = isset($params['gate_url']) ? trim($params['gate_url']) : '';
                        if ($gate == '') $gate = RBKMONEY_DEFAULT_GATE_URL;

                        // емейл пользователя
                        $email = trim($order->email);
                        if ($email == '') $email = trim($order->email2);

                        // вычисляем контрольную подпись
                        $crc  = strtolower(md5($merchant . '::'
                                             . $sum . '::'
                                             . $currency . '::'
                                             . $email . '::'
                                             . $description . '::'
                                             . $id . '::'
                                             . $payment_id . '::'
                                             . $secret));

                        // создаем форму с кнопкой
                        $button = '<form action="' . htmlspecialchars($gate, ENT_QUOTES) . '" method="post">'
                                    . '<input type="hidden" name="eshopId" value="' . htmlspecialchars($merchant, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="orderId" value="' . htmlspecialchars($id, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="recipientAmount" value="' . $sum . '" />'

                                    . '<input type="hidden" name="serviceName" value="' . htmlspecialchars($description, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="recipientCurrency" value="' . htmlspecialchars($currency, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="language" value="' . htmlspecialchars($language, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="successUrl" value="' . htmlspecialchars($success_url, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="failUrl" value="' . htmlspecialchars($fail_url, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="userField_1" value="' . htmlspecialchars($payment_id, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="user_email" value="' . htmlspecialchars($email, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="hash" value="' . htmlspecialchars($crc, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="version" value="2" />'
                                    . '<input class="payment_button" type="submit" value="Оплатить &#8594;" />'
                                . '</form>';

                    // иначе валюта способа оплаты не подходит
                    } else {
                        $button = 'Этот способ оплаты возможен только для валют: '
                                . 'USD - доллар, EUR - евро, RUR - российский рубль, '
                                . 'UAH - гривна. Однако в менеджерских настройках '
                                . 'способа оплаты почему-то указана иная валюта "'
                                . htmlspecialchars($currency, ENT_QUOTES) . '". '
                                . 'Пожалуйста, просим вас сообщить об этой ошибке '
                                . 'менеджерам нашего магазина через форму <a href="'
                                . htmlspecialchars($root_url, ENT_QUOTES)
                                . 'feedback">обратной связи</a>.';
                    }
                    break;



                // если Assist
                case 'assist':

                    // извлекаем параметры способа оплаты
                    $params = @ unserialize($method->params);
                    $shop_id = isset($params['assist_shop_id']) ? trim($params['assist_shop_id']) : '';
                    $delay = isset($params['assist_delay']) ? trim($params['assist_delay']) : '';

                    // определяем язык
                    $language = isset($params['assist_language']) ? trim($params['assist_language']) : '';

                    // указываем финальный URL
                    $url = isset($params['success_url']) ? trim($params['success_url']) : '';
                    if ($url != '') $success_url = $url;

                    // указываем URL ошибки
                    $url = isset($params['fail_url']) ? trim($params['fail_url']) : '';
                    if ($url != '') $fail_url = $url;

                    // берем URL шлюза
                    $gate = isset($params['gate_url']) ? trim($params['gate_url']) : '';
                    if ($gate == '') $gate = ASSIST_DEFAULT_GATE_URL;

                    $button = "<form accept-charset='cp1251' action='" . htmlspecialchars($gate, ENT_QUOTES) . "' method='post'>"
                            . "<input type='hidden' name='Shop_IDP' value='" . htmlspecialchars($shop_id, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='Order_IDP' value='" . htmlspecialchars($id, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='Subtotal_P' value='" . $sum . "'>"
                            . "<input type='hidden' name='Delay' value='" . htmlspecialchars($delay, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='Language' value='" . htmlspecialchars($language, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='URL_RETURN_OK' value='" . htmlspecialchars($success_url, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='URL_RETURN_NO' value='" . htmlspecialchars($fail_url, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='Currency' value='" . htmlspecialchars($currency, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='Comment' value='" . htmlspecialchars($description, ENT_QUOTES) . "'>"
                            . "<input type='hidden' name='CardPayment' value='" . intval(isset($params["assist_card_payments"]) ? $params["assist_card_payments"] : 0) . "'>"
                            . "<input type='hidden' name='WebMoneyPayment' value='" . intval($params["assist_webmoney_payments"]) . "'>"
                            . "<input type='hidden' name='PayCashPayment' value='" . intval($params["assist_paycash_payments"]) . "'>"
                            . "<input type='hidden' name='EPortPayment' value='" . intval(isset($params["assist_eport_payments"]) ? $params["assist_eport_payments"] : 0) . "'>"
                            . "<input type='hidden' name='EPBeelinePayment' value='" . intval($params["assist_epbeeline_payments"]) . "'>"
                            . "<input type='hidden' name='AssistIDCCPayment' value='" . intval($params["assist_assist_payments"]) . "'>"
                            . "<!--<input type='hidden' name='DemoResult' value='AS000'-->"
                            . "<input class='payment_button' type='submit' value='Оплатить &#8594;'>"
                            . "</form>";
                    break;



                // если Украинский процессинговый центр
                case 'upc':

                    // извлекаем параметры способа оплаты
                    if (function_exists('openssl_get_privatekey')) {
                        $params = @unserialize($method->params);
                        $merchant = isset($params['merchant_id']) ? trim($params['merchant_id']) : '';
                        $terminal = isset($params['terminal_id']) ? trim($params['terminal_id']) : '';
                        $locale = isset($params['locale']) ? trim($params['locale']) : '';

                        // определяем валюту
                        $currency = '980';

                        // определяем сумму
                        $sum = intval(round($method->amount, 2) * 100);

                        // получаем сигнатуру ключа
                        $purchase_time = date('ymdHisO');
                        $data = $merchant . ';' . $terminal . ';' . $purchase_time . ';' . $id . ';' . $currency . ';' . $sum . ';' . $payment_id . ';';
                        $key = isset($params['ssl_key_file']) ? trim($params['ssl_key_file']) : '';
                        if (($key == '') || (!$handle = @ fopen($key, 'rb'))) return 'Ошибка чтения файла ключа';
                        $key = @ fread($handle, 16384);
                        @ fclose($handle);
                        $key = openssl_get_privatekey($key);
                        openssl_sign($data, $signature, $key);
                        openssl_free_key($key);
                        $signature = @ base64_encode($signature);

                        // берем URL шлюза
                        $gate = isset($params['upc_gate_url']) ? trim($params['upc_gate_url']) : '';
                        if ($gate == '') $gate = UPC_DEFAULT_GATE_URL;

                        // создаем форму с кнопкой
                        $button = "<form action='" . htmlspecialchars($gate, ENT_QUOTES) . "' method='post'>"
                                  . "<input type='hidden' name='Version' value='1'>"
                                  . "<input type='hidden' name='MerchantID' value='" . htmlspecialchars($merchant, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='TerminalID' value='" . htmlspecialchars($terminal, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='TotalAmount' value='" . $sum . "'>"
                                  . "<input type='hidden' name='Currency' value='" . htmlspecialchars($currency, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='locale' value='" . htmlspecialchars($locale, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='OrderID' value='" . htmlspecialchars($id, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='SD' value='" . htmlspecialchars($payment_id, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='PurchaseTime' value='" . htmlspecialchars($purchase_time, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='PurchaseDesc' value='" . htmlspecialchars($description, ENT_QUOTES) . "'>"
                                  . "<input type='hidden' name='Signature' value='" . htmlspecialchars($signature, ENT_QUOTES) . "'>"
                                  . "<input type='submit' value='Оплатить &#8594;'>"
                                . "</form>";
                    } else {
                        $button = 'К сожалению, на сайте не установлен модуль open_ssl. Оплата таким способом невозможна.';
                    }
                    break;



                // если CyberPlat
                case 'cyberplat':
                    $params = @ unserialize($method->params);
                    $merchant_id = $params['merchant_id'];
                    $terminal_id = $params['terminal_id'];
                    $purchase_time = date('ymdHisO');
                    $currency = '980';
                    $sum = round($method->amount * 100);
                    $data = $merchant_id . ';' . $terminal_id . ';' . $purchase_time . ';' . $id . ';' . $currency . ';' . $sum . ';' . $payment_id . ';';
                    $button = "<form action='https://card.cyberplat.ru/cgi-bin/getform.cgi' method='post'>"
                            . "<input type='hidden' name='Version' value='1'>"
                            . "<input type='hidden' name='MerchantID' value='" . $merchant_id . "'>"
                            . "<input type='hidden' name='TerminalID' value='" . $terminal_id . "'>"
                            . "<input type='hidden' name='TotalAmount' value='" . $sum . "'>"
                            . "<input type='hidden' name='Currency' value='" . $currency . "'>"
                            . "<input type='hidden' name='locale' value='" . $params["locale"] . "'>"
                            . "<input type='hidden' name='OrderID' value='" . $id . "'>"
                            . "<input type='hidden' name='SD' value='" . $payment_id . "'>"
                            . "<input type='hidden' name='PurchaseTime' value='" . $purchase_time . "'>"
                            . "<input type='hidden' name='PurchaseDesc' value='" . $description . "'>"
                            . "<input type='hidden' name='Signature' value='" . $b64sign . "'>"
                            . "<input class='payment_button' type='submit' value='Оплатить &#8594;'>"
                            . "</form>";
                    break;



                // если формирование квитанции
                case 'receipt':

                    // извлекаем параметры способа оплаты
                    $params = @ unserialize($method->params);

                    // берем URL шлюза
                    $gate = isset($params['gate_url']) ? trim($params['gate_url']) : '';
                    if ($gate == '') $gate = $module_url . $class . '.php';

                    // создаем форму с кнопкой
                    $button = '<form action="' . htmlspecialchars($gate, ENT_QUOTES) . '" method="post">'
                                . '<input type="hidden" name="purpose" value="' . htmlspecialchars(isset($params['purpose']) ? $params['purpose'] : $description, ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="purpose_label" value="' . htmlspecialchars(isset($params['purpose_label']) ? $params['purpose_label'] : '', ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="payer_name" value="' . htmlspecialchars(isset($params['payer_name']) && (trim($params['payer_name']) != '') ? $params['payer_name'] : $order->compound_name, ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="payer_name_label" value="' . htmlspecialchars(isset($params['payer_name_label']) ? $params['payer_name_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="payer_inn" value="' . htmlspecialchars(isset($params['payer_inn']) ? $params['payer_inn'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="payer_inn_label" value="' . htmlspecialchars(isset($params['payer_inn_label']) ? $params['payer_inn_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="payer_address" value="' . htmlspecialchars(isset($params['payer_address']) && (trim($params['payer_address']) != '') ? $params['payer_address'] : (($order->compound_address != '') ? $order->compound_address : $order->compound_address2), ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="payer_address_label" value="' . htmlspecialchars(isset($params['payer_address_label']) ? $params['payer_address_label'] : '', ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="recipient" value="' . htmlspecialchars(isset($params['recipient']) ? $params['recipient'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="recipient_label" value="' . htmlspecialchars(isset($params['recipient_label']) ? $params['recipient_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="inn" value="' . htmlspecialchars(isset($params['inn']) ? $params['inn'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="inn_label" value="' . htmlspecialchars(isset($params['inn_label']) ? $params['inn_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="account" value="' . htmlspecialchars(isset($params['account']) ? $params['account'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="account_label" value="' . htmlspecialchars(isset($params['account_label']) ? $params['account_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="bank" value="' . htmlspecialchars(isset($params['bank']) ? $params['bank'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="bank_label" value="' . htmlspecialchars(isset($params['bank_label']) ? $params['bank_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="bik" value="' . htmlspecialchars(isset($params['bik']) ? $params['bik'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="bik_label" value="' . htmlspecialchars(isset($params['bik_label']) ? $params['bik_label'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="correspondent_account" value="' . htmlspecialchars(isset($params['correspondent_account']) ? $params['correspondent_account'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="correspondent_account_label" value="' . htmlspecialchars(isset($params['correspondent_account_label']) ? $params['correspondent_account_label'] : '', ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="banknote" value="' . htmlspecialchars(isset($params['banknote']) ? $params['banknote'] : '', ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="pence" value="' . htmlspecialchars(isset($params['pence']) ? $params['pence'] : '', ENT_QUOTES) . '" />'

                                . '<input type="hidden" name="order_id" value="' . htmlspecialchars($id, ENT_QUOTES) . '" />'
                                . '<input type="hidden" name="amount" value="' . $sum . '" />'
                                . '<input type="submit" value="Сформировать квитанцию &#8594;" />'
                            . '</form>';
                    break;



                // если с внутреннего счета
                case 'myaccount':

                    // извлекаем параметры способа оплаты
                    $params = @ unserialize($method->params);

                    // указываем финальный URL
                    $url = isset($params['success_url']) ? trim($params['success_url']) : '';
                    if ($url != '') $success_url = $url;

                    // указываем URL ошибки
                    $url = isset($params['fail_url']) ? trim($params['fail_url']) : '';
                    if ($url != '') $fail_url = $url;

                    // берем URL шлюза
                    $gate = isset($params['gate_url']) ? trim($params['gate_url']) : '';
                    if ($gate == '') $gate = $module_url . $class . '.php';

                    // если это не авторизованный пользователь
                    if (!isset($this->user->user_id) || empty($this->user->user_id)) {
                        $button = 'Для совершения оплаты таким способом вам необходимо '
                                . '<a href="' . htmlspecialchars($root_url, ENT_QUOTES) . 'login">авторизоваться</a> '
                                . 'на сайте, а также иметь на внутреннем счёте достаточную '
                                . 'сумму средств. Информация о состоянии внутреннего '
                                . 'счёта видна в личном кабинете пользователя.';

                    // иначе если на внутреннем счете недостаточно средств

                    // иначе создаем форму с кнопкой
                    } else {
                        $button = '<form action="' . htmlspecialchars($gate, ENT_QUOTES) . '" method="post">'
                                    . '<input type="hidden" name="order_id" value="' . htmlspecialchars($id, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="amount" value="' . $sum . '" />'

                                    . '<input type="hidden" name="success_url" value="' . htmlspecialchars($success_url, ENT_QUOTES) . '" />'
                                    . '<input type="hidden" name="fail_url" value="' . htmlspecialchars($fail_url, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="payment_id" value="' . htmlspecialchars($payment_id, ENT_QUOTES) . '" />'

                                    . '<input type="hidden" name="user_id" value="' . htmlspecialchars($this->user->user_id, ENT_QUOTES) . '" />'
                                    . '<input type="submit" value="Оплатить &#8594;" />'
                                . '</form>';
                    }
                    break;



                // иначе ручная обработка
                default:

                    // создаем форму с кнопкой
                    $button = '<form method="post">'
                                . '<input type="hidden" name="desire_payment_id" value="' . htmlspecialchars($payment_id, ENT_QUOTES) . '" />'
                                . '<input type="submit" value="Оплачу таким способом" />'
                            . '</form>';
            }

            // возвращаем результат (форма с кнопкой)
            return $button;
        }



        function get_order_by_id ( $order_id ) {
            $order_id = intval($order_id);
            $query = 'SELECT `' . DATABASE_ORDERS_TABLENAME . '`.*, '
                          . 'SUM(`orders_products`.`real_price` * ABS(`orders_products`.`quantity`)) + `' . DATABASE_ORDERS_TABLENAME . '`.`delivery_price` - `' . DATABASE_ORDERS_TABLENAME . '`.`discount_sum` AS `total_amount`, '
                          . 'DATE_FORMAT(`' . DATABASE_ORDERS_TABLENAME . '`.`date`, \'%d.%m.%Y %H:%i\') AS `date`, '
                          . 'DATE_FORMAT(`' . DATABASE_ORDERS_TABLENAME . '`.`payment_date`, \'%d.%m.%Y %H:%i\') AS `payment_date`, '
                          . '`delivery_methods`.`name` AS `delivery_method` '
                   . 'FROM `' . DATABASE_ORDERS_TABLENAME . '` '
                   . 'LEFT JOIN `orders_products` '
                             . 'ON `' . DATABASE_ORDERS_TABLENAME . '`.`order_id` = `orders_products`.`order_id` '
                   . 'LEFT JOIN `delivery_methods` '
                             . 'ON `' . DATABASE_ORDERS_TABLENAME . '`.`delivery_method_id` = `delivery_methods`.`delivery_method_id` '
                   . 'WHERE `' . DATABASE_ORDERS_TABLENAME . '`.`order_id` = \'' . $this->db->query_value($order_id) . '\' '
                   . 'GROUP BY `' . DATABASE_ORDERS_TABLENAME . '`.`order_id` '
                   . 'LIMIT 1;';
            $this->db->query($query);
            $order = $this->db->result();
            if ($order) {
                $this->db->orders->unpackUserName($order);
                $this->db->orders->unpackUserAddress($order);
                $this->db->orders->unpackUserAddress($order, '2');
                $query = 'SELECT `orders_products`.*, '
                              . '`products`.`url` AS `url`, '
                              . '`products`.`download` AS `download` '
                       . 'FROM `orders_products` '
                       . 'LEFT JOIN `products` '
                                 . 'ON `products`.`product_id` = `orders_products`.`product_id` '
                       . 'WHERE `orders_products`.`order_id` = \'' . $this->db->query_value($order_id) . '\';';
                $this->db->query($query);
                $order->products = $this->db->results();
            }
            return $order;
        }



        public function vk_fail_message ( $code ) {
            $result = '';
            $code = @ intval($code);
            switch ($code) {
                case 1:
                    $result = 'Ошибка системы обработки данных ВКонтакте.';
                    break;
                case 2:
                    $result = 'Временная ошибка базы данных ВКонтакте.';
                    break;
                case 10:
                    $result = 'Несовпадение вычисленной и переданной подписи.';
                    break;
                case 11:
                    $result = 'Параметры запроса не соответствуют спецификации, в запросе нет необходимых полей или другая ошибка целостности запроса.';
                    break;
                case 20:
                    $result = 'Одного из товаров, указанного в запросе, не существует в базе данных ВКонтакте.';
                    break;
                case 21:
                    $result = 'Покупателя не существует.';
                    break;
                case 22:
                    $result = 'В запросе указана некорректная сумма заказа.';
                    break;
                case 23:
                    $result = 'В запросе указан некорректный метод доставки.';
                    break;
                case 24:
                    $result = 'Одного из товаров, указанного в запросе, нет в наличии в базе данных ВКонтакте.';
                    break;
                case 1001:
                    $result = 'Не удалось разобрать ответ на уведомление (ответ не соответствует спецификации).';
                    break;
                case 1002:
                    $result = 'Неизвестная ошибка (код ' . $code . ').';
                    break;
                case 1003:
                    $result = 'В параметре merchant_id запроса передан идентификатор несуществующего магазина в системе ВКонтакте.';
                    break;
                case 1004:
                    $result = 'Попытка работать в рабочем (не тестовом) режиме для выключенного в системе ВКонтакте магазина (в запросе необходимо передавать параметр testmode: 1).';
                    break;
                case 1005:
                    $result = 'В параметре success_url запроса передан некорректный адрес.';
                    break;
                case 1006:
                    $result = 'В массиве позиций заказа items некорректное число позиций - 0 или больше 100.';
                    break;
                case 1007:
                    $result = 'В заказе присутствуют товары, требующие доставки (не цифровые), в то время как в настройках магазина в системе ВКонтакте выбран вариант "Нет" в графе "Варианты доставки:", а такой вариант возможен только для магазинов, продающих цифровые товары).';
                    break;
                case 1008:
                    $result = 'В заказе присутствуют товары, требующие доставки (не цифровые), в то время как в настройках магазина в системе ВКонтакте выбран вариант "Задать вручную" в графе "Варианты доставки:", однако не задано ни одного варианта ни для какой страны.';
                    break;
                default:
                    if (($code >= 100) && ($code <= 999)) {
                        $result = 'Ошибка с кодом ' . $code . ' (определена продавцом).';
                    } elseif (($code >= 1101) && ($code <= 1200)) {
                        $code = $code - 1100;
                        $result = 'Для позиции ' . $code . ' заказа передан некорректный идентификатор товара.';
                    } elseif (($code >= 1201) && ($code <= 1300)) {
                        $code = $code - 1200;
                        $result = 'Для позиции ' . $code . ' заказа передано некорректное название товара.';
                    } elseif (($code >= 1301) && ($code <= 1400)) {
                        $code = $code - 1300;
                        $result = 'Для позиции ' . $code . ' заказа передана некорректная валюта.';
                    } elseif (($code >= 1401) && ($code <= 1500)) {
                        $code = $code - 1400;
                        $result = 'Для позиции ' . $code . ' заказа передана некорректная цена.';
                    } elseif (($code >= 1501) && ($code <= 1600)) {
                        $code = $code - 1500;
                        $result = 'Для позиции ' . $code . ' заказа передано некорректное количество товаров.';
                    } else {
                        $result = 'Неопознанная ошибка с кодом ' . $code . '.';
                    }
            }
            if ($result != '') $result = '<b style="color: #c00;">Ошибка:</b> ' . $result;
            return $result;
        }



        public function vk_success_answer ( $type ) {
            $crlf = "\r\n";
            $type = strtolower(trim($type));
            switch ($type) {

                // проверка доступности товара
                case 'check-items-availability':
                case 'check-items-availability-test':
                    return '<?xml version="1.0" encoding="UTF-8" ?>' . $crlf
                         . '<items>' . $crlf
                         . '</items>' . $crlf;
                                //<item id="идентификатор товара" last="либо 1 либо не указывается">
                                //    <price currency="RUB">текущая стоимость единицы товара</price>
                                //    <quantity>доступное количество единиц товара</quantity>
                                //</item>

                // резервирование товара
                case 'item-reservation':
                case 'item-reservation-test':
                    return '<?xml version="1.0" encoding="UTF-8" ?>' . $crlf
                         . '<reservation-success />' . $crlf;

                // отмена резервирования товара
                case 'cancel-item-reservation':
                case 'cancel-item-reservation-test':
                    return '<?xml version="1.0" encoding="UTF-8" ?>' . $crlf
                         . '<reservation-cancelled />' . $crlf;

                // подсчет стоимости доставки
                case 'calculate-shipping-cost':
                case 'calculate-shipping-cost-test':
                    return '<?xml version="1.0" encoding="UTF-8" ?>' . $crlf
                         . '<shipping-methods>' . $crlf
                         . '</shipping-methods>' . $crlf;
                                //<flat-rate id="идентификатор варианта" name="имя варианта">
                                //    <price currency="RUB">стоимость доставки</price>
                                //</flat-rate>

                // изменение состояния заказа
                case 'order-state-change':
                case 'order-state-change-test':
                    return '<?xml version="1.0" encoding="UTF-8" ?>' . $crlf
                         . '<success>' . $crlf
                         . '    <order-id>' . (isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '') . '</order-id>' . $crlf
                         . '    <merchant-order-id>' . (isset($_REQUEST['custom_1']) ? $_REQUEST['custom_1'] : '') . '</merchant-order-id>' . $crlf
                         . '</success>' . $crlf;

                case '':
                    return '';

                // иначе неизвестный тип
                default:
                    return 'Undefined notification type [' . $type . ']';
            }
        }



    }



    return;
?>