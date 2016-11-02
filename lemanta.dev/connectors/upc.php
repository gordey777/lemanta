<?php
  // Impera CMS: модуль оплаты через Украинский процессинговый центр.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  // выключаем информирование о любой ошибке (клиенту не нужно видеть технические подробности возможных ошибок),
  // выходим в корень сайта
  error_reporting(0);
  chdir("../");

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_GET["_SERVER"]) || isset($_GET["_ENV"]) || isset($_GET["_COOKIE"])
  || isset($_GET["_GET"]) || isset($_GET["_POST"]) || isset($_GET["_REQUEST"])
  || isset($_GET["_FILES"]) || isset($_GET["_SESSION"]) || isset($_GET["GLOBALS"])) exit;

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_POST["_SERVER"]) || isset($_POST["_ENV"]) || isset($_POST["_COOKIE"])
  || isset($_POST["_GET"]) || isset($_POST["_POST"]) || isset($_POST["_REQUEST"])
  || isset($_POST["_FILES"]) || isset($_POST["_SESSION"]) || isset($_POST["GLOBALS"])) exit;

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_COOKIE["_SERVER"]) || isset($_COOKIE["_ENV"]) || isset($_COOKIE["_COOKIE"])
  || isset($_COOKIE["_GET"]) || isset($_COOKIE["_POST"]) || isset($_COOKIE["_REQUEST"])
  || isset($_COOKIE["_FILES"]) || isset($_COOKIE["_SESSION"]) || isset($_COOKIE["GLOBALS"])) exit;

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_FILES["_SERVER"]) || isset($_FILES["_ENV"]) || isset($_FILES["_COOKIE"])
  || isset($_FILES["_GET"]) || isset($_FILES["_POST"]) || isset($_FILES["_REQUEST"])
  || isset($_FILES["_FILES"]) || isset($_FILES["_SESSION"]) || isset($_FILES["GLOBALS"])) exit;

  // определяем начальные константы:
  //   ссылка на корень сайта из текущей папки,
  //   имя папки с файлами модулей,
  //   имя файла с константами
  define("ROOT_FOLDER_REFERENCE", "");
  define("FOLDERNAME_FOR_ENGINE_OBJECTS", "objects");
  define("FILENAME_FOR_ENGINE_DEFINITION_OBJECT", "Definition.php");

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT);

  // =========================================================================
  // Класс UPC (модуль оплаты через Украинский процессинговый центр)
  // =========================================================================

  class UPC extends Basic {

    // заказ
    public $order = null;

    // создание контента модуля ==============================================

    public function fetch ( & $parent = null ) {

        // этот метод ничего не выводит
        return '';
    }

    // обработка входных параметров ==========================================

    public function process () {

      // берем URL главной страницы
      $root_url = explode("/", $this->root_url);
      if (count($root_url) > 1) array_pop($root_url);
      $root_url = implode("/", $root_url);

      // запоминаем этот URL (вне класса он будет использован)
      $this->root_url = $root_url;

      // задаем информационные сообщения
      $success_message = "Спасибо! Ваш заказ уже оплачен.";
      $unknown_method_message = "Ошибка: Неизвестный способ оплаты!";
      $bad_signature_message = "Ошибка: Контрольная подпись неправильная!";
      $bad_merchant_message = "Ошибка: Неверный идентификатор мерчанта!";
      $bad_terminal_message = "Ошибка: Неверный идентификатор терминала!";
      $bad_sum_message = "Ошибка: Неверная сумма оплаты!";
      $no_orderid_message = "Ошибка: Не указан идентификатор оплачиваемого заказа!";
      $no_order_message = "Ошибка: Оплачиваемый заказ не найден!";
      $no_paydata_message = "Ошибка: У способа оплаты отсутствуют параметры!";

      // берем входные параметры
      $merchant = isset($_POST["MerchantID"]) ? trim($_POST["MerchantID"]) : "";
      $terminal = isset($_POST["TerminalID"]) ? trim($_POST["TerminalID"]) : "";
      $order_id = isset($_POST["OrderID"]) ? trim($_POST["OrderID"]) : "";
      $currency = isset($_POST["Currency"]) ? trim($_POST["Currency"]) : "";
      $payment_id = isset($_POST["SD"]) ? trim($_POST["SD"]) : "";
      $amount = isset($_POST["TotalAmount"]) ? intval($_POST["TotalAmount"]) : 0;
      $purchase_time = isset($_POST["PurchaseTime"]) ? trim($_POST["PurchaseTime"]) : "";
      $tran_code = isset($_POST["TranCode"]) ? $_POST["TranCode"] : "";
      $approval_code = isset($_POST["ApprovalCode"]) ? $_POST["ApprovalCode"] : "";
      $xid = isset($_POST["XID"]) ? $_POST["XID"] : "";
      $signature = isset($_POST["Signature"]) ? $_POST["Signature"] : "";

      // читаем данные способа оплаты
      $method = null;
      $params = new stdClass;
      $params->id = $payment_id;
      $params->enabled = 1;
      $this->db->payments->one($method, $params);
      if (empty($method)) return $unknown_method_message;

      // проверяем наличие параметров у способа оплаты
      $payment_params = isset($method->params) ? @unserialize($method->params) : FALSE;
      if ($payment_params === FALSE) return $no_paydata_message;

      // проверяем контрольную подпись
      $signature = base64_decode($signature);
      $data = $merchant . ";" . $terminal . ";" . $purchase_time . ";" . $order_id . ";" . $xid . ";" . $currency . ";" . $amount . ";" . $payment_id . ";" . $tran_code . ";" . $approval_code . ";";
      $key = isset($payment_params["ssl_cert_file"]) ? trim($payment_params["ssl_cert_file"]) : "";
      if (($key == "") || (!$handle = @fopen($key, "rb"))) return "Ошибка чтения файла ключа!";
      $key = @fread($handle, 16384);
      @fclose($handle);
      $key = openssl_get_publickey($key);
      $data = openssl_verify($data, $signature, $key);
      openssl_free_key($key);
      if ($data == 0) return $bad_signature_message;
      if ($data != 1) return "Ошибка проверки подписи!";

      // читаем необходимый заказ
      if ($order_id == "") return $no_orderid_message;
      $params = new stdClass;
      $params->id = $order_id;
      $this->db->orders->one($this->order, $params);
      if (empty($this->order)) return $no_order_message;
      if ($this->order->payment_status == 1) return $success_message;

      // проверяем мерчант
      if (!isset($payment_params["merchant_id"]) || ($merchant != $payment_params["merchant_id"])) return $bad_merchant_message;
      if (!isset($payment_params["terminal_id"]) || ($terminal != $payment_params["terminal_id"])) return $bad_terminal_message;
      if ($tran_code != "000") return "TranCode не равен \"000\"";

      // проверяем сумму оплаты
      $order_amount = intval(round($this->order->total_amount * $method->rate_from / $method->rate_to, 2) * 100);
      if (($order_amount != $amount) || ($amount <= 0)) return $bad_sum_message;

      // проверяем наличие товаров
      foreach ($this->order->products as &$product) {
        if (!empty($product)) {
          $query = "SELECT * "
                 . "FROM products_variants "
                 . "WHERE product_id = '" . $this->db->query_value($product->product_id) . "' "
                       . "AND variant_id = '" . $this->db->query_value($product->variant_id) . "' "
                 . "LIMIT 1";
          $this->db->query($query);
          $variant = $this->db->result();
          if (empty($variant)) return "Ошибка: Недоступны данные о товаре \"" . $product->product_name . "\"!";

          if (($product->quantity > 0) && ($product->quantity > $variant->stock)
          && (($variant->stock > 0) && !$this->settings->orders_deficit_enabled
          || ($variant->stock == 0) && !$this->settings->cart_enable_reservation)) {
              return 'На складе нет достаточного количества товара "' . trim($product->product_name . ' ' . $variant->name) . '".';
          }
        }
      }

      // ставим в заказе признак оплаты и списания товаров
      $params = $_POST;
      foreach ($params as &$param) $param = $this->text->stripTags($param);
      $query = "UPDATE " . DATABASE_ORDERS_TABLENAME . " "
             . "SET payment_status = 1, "
                 . "payment_date = NOW(), "
                 . "payment_method_id = '" . $this->db->query_value($payment_id) . "', "
                 . "payment_details = '" . $this->db->query_value(var_export($params, TRUE)) . "', "
                 . "written_off = 1 "
             . "WHERE order_id = '" . $this->db->query_value($this->order->order_id) . "' "
             . "LIMIT 1";
      $this->db->query($query);

        // если еще не было сделано списание товара, делаем
        if (!$this->order->written_off) {
            if (!$this->settings->orders_non_touch_quantity) {
                foreach ($this->order->products as & $product) {
                    $query = 'UPDATE products_variants '
                           . 'SET stock = CASE WHEN stock >= ' . abs(@intval($product->quantity)) . ' '
                                            . 'THEN stock - ' . abs(@intval($product->quantity)) . ' '
                                            . 'ELSE CASE WHEN stock >= 0 '
                                                      . 'THEN 0 '
                                                      . 'ELSE stock '
                                                      . 'END '
                                            . 'END '
                           . 'WHERE product_id = \'' . $this->db->query_value($product->product_id) . '\' '
                                 . 'AND variant_id = \'' . $this->db->query_value($product->variant_id) . '\' '
                           . 'LIMIT 1';
                    $this->db->query($query);
                }
            }
        }

      // перечитываем заказ
      $params = new stdClass;
      $params->id = $this->order->order_id;
      $this->db->orders->one($this->order, $params);

      // уведомляем покупателя и администратора
      $this->smarty->assign('payway_name', 'УкрПроцессЦентр');
      $this->inform_about_order($this->order,
                                "Оплачен через УкрПроцессЦентр заказ №" . $this->order->order_id . " на сайте " . $root_url,
                                "Принята оплата заказа №" . $this->order->order_id . " на сайте " . $root_url,
                                INFORM_ABOUT_ORDER_ACTION_PAYMENT);

      // возвращаем сообщение об успехе
      return "ok";
    }
  }

  // =========================================================================
  // Внеклассовая часть программного кода
  // =========================================================================

  $upc = new UPC();
  $result = @$upc->process();

  // если все прошло успешно
  if ($result == "ok") {
    $response = "approve";
    $result = "";

  // иначе была какая-то ошибка, готовим ответ "Отмена"
  } else {
    $response = "reverse";
  }

  // передаем ответ
  echo "MerchantID=" . (isset($_POST["MerchantID"]) ? $_POST["MerchantID"] : "") . "\r\n"
     . "TerminalID=" . (isset($_POST["TerminalID"]) ? $_POST["TerminalID"] : "") . "\r\n"
     . "OrderID=" . (isset($_POST["OrderID"]) ? $_POST["OrderID"] : "") . "\r\n"
     . "Currency=" . (isset($_POST["Currency"]) ? $_POST["Currency"] : "") . "\r\n"
     . "TotalAmount=" . (isset($_POST["TotalAmount"]) ? $_POST["TotalAmount"] : "") . "\r\n"
     . "XID=" . (isset($_POST["XID"]) ? $_POST["XID"] : "") . "\r\n"
     . "PurchaseTime=" . (isset($_POST["PurchaseTime"]) ? $_POST["PurchaseTime"] : "") . "\r\n"
     . "Response.action=" . $response . "\r\n"
     . "Response.reason=" . $result . "\r\n"
     . "Response.forwardUrl=http://" . $upc->root_url . (isset($upc->order->code) ? "/order/" . $upc->order->code : "");
  exit;
?>
