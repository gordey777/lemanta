<?php
  // Impera CMS: модуль оплаты через платежную систему WebMoney.
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
  // Класс WebMoney (модуль оплаты через платежную систему WebMoney)
  // =========================================================================

  class WebMoney extends Basic {

    // обработка входных параметров ==========================================

    public function process () {

      // определяем это предварительный запрос или финальный
      $pre_request = isset($_POST["LMI_PREREQUEST"]) && ($_POST["LMI_PREREQUEST"] == 1) ? 1 : 0;

      // задаем информационные сообщения
      $success_message = "Спасибо! Ваш заказ оплачен.";
      $unknown_method_message = "Ошибка: Неизвестный способ оплаты!";
      $bad_signature_message = "Ошибка: Контрольная подпись неправильная!";
      $bad_merchant_purse_message = "Ошибка: Неверный кошелек продавца!";
      $bad_merchant_types_message = "Ошибка: Типы кошельков продавца и покупателя не совпадают!";
      $bad_sum_message = "Ошибка: Неверная сумма оплаты!";
      $no_orderid_message = "Ошибка: Не указан идентификатор оплачиваемого заказа!";
      $no_order_message = "Ошибка: Оплачиваемый заказ не найден!";
      $no_paydata_message = "Ошибка: У способа оплаты отсутствуют параметры!";

      // берем входные параметры
      $merchant_purse = isset($_POST["LMI_PAYEE_PURSE"]) ? trim($_POST["LMI_PAYEE_PURSE"]) : "";
      $amount = isset($_POST["LMI_PAYMENT_AMOUNT"]) ? $this->number->floatValue($_POST["LMI_PAYMENT_AMOUNT"]) : 0;
      $order_id = isset($_POST["LMI_PAYMENT_NO"]) ? trim($_POST["LMI_PAYMENT_NO"]) : "";
      $test_mode = isset($_POST["LMI_MODE"]) && ($_POST["LMI_MODE"] == 0) ? 0 : 1;
      $wm_order_id = isset($_POST["LMI_SYS_INVS_NO"]) ? trim($_POST["LMI_SYS_INVS_NO"]) : "";
      $wm_transaction_id = isset($_POST["LMI_SYS_TRANS_NO"]) ? trim($_POST["LMI_SYS_TRANS_NO"]) : "";
      $payer_purse = isset($_POST["LMI_PAYER_PURSE"]) ? trim($_POST["LMI_PAYER_PURSE"]) : "";
      $payer_wmid = isset($_POST["LMI_PAYER_WM"]) ? trim($_POST["LMI_PAYER_WM"]) : "";
      $paymer_number = isset($_POST["LMI_PAYMER_NUMBER"]) ? trim($_POST["LMI_PAYMER_NUMBER"]) : "";
      $paymer_email = isset($_POST["LMI_PAYMER_EMAIL"]) ? trim($_POST["LMI_PAYMER_EMAIL"]) : "";
      $mobile_keeper_phone = isset($_POST["LMI_TELEPAT_PHONENUMBER"]) ? trim($_POST["LMI_TELEPAT_PHONENUMBER"]) : "";
      $mobile_keeper_order_id = isset($_POST["LMI_TELEPAT_ORDERID"]) ? trim($_POST["LMI_TELEPAT_ORDERID"]) : "";
      $credit_days = isset($_POST["LMI_PAYMENT_CREDITDAYS"]) ? trim($_POST["LMI_PAYMENT_CREDITDAYS"]) : "";
      $hash = isset($_POST["LMI_HASH"]) ? trim($_POST["LMI_HASH"]) : "";
      $date = isset($_POST["LMI_SYS_TRANS_DATE"]) ? trim($_POST["LMI_SYS_TRANS_DATE"]) : "";
      $payment_method_id = isset($_POST["PAYMENT_METHOD_ID"]) ? trim($_POST["PAYMENT_METHOD_ID"]) : "";

      // читаем необходимый заказ
      if ($order_id == "") return $no_orderid_message;
      $params = new stdClass;
      $params->id = $order_id;
      $this->db->orders->one($order, $params);
      if (empty($order)) return $no_order_message;
      if ($order->payment_status == 1) return $success_message;

      // читаем данные способа оплаты
      $method = null;
      $params = new stdClass;
      $params->id = $payment_method_id;
      $params->enabled = 1;
      $this->db->payments->one($method, $params);
      if (empty($method)) return $unknown_method_message;

      // проверяем наличие параметров у способа оплаты
      $payment_params = isset($method->params) ? @unserialize($method->params) : FALSE;
      if ($payment_params === FALSE) return $no_paydata_message;

      // проверяем контрольную подпись, если это финальный запрос
      if ($pre_request == 0) {
        $sign = $merchant_purse
               . $amount
               . $order_id
               . $test_mode
               . $wm_order_id
               . $wm_transaction_id
               . $date
               . (isset($payment_params["wm_secret_key"]) ? $payment_params["wm_secret_key"] : "")
               . $payer_purse
               . $payer_wmid;
        $sign = strtoupper(md5($sign));
        if ($sign !== $hash) return $bad_signature_message;
      }

      // проверяем типы кошельков
      $merchant_type = strtoupper(substr($merchant_purse, 0, 1));
      $payer_type = strtoupper(substr($payer_purse, 0, 1));
      if ($merchant_type != $payer_type) return $bad_merchant_types_message;
      if (!isset($payment_params["wm_merchant_purse"]) || ($merchant_purse != $payment_params["wm_merchant_purse"])) return $bad_merchant_purse_message;

      // проверяем сумму оплаты
      $order_amount = round($order->total_amount * $method->rate_from / $method->rate_to, 2);
      if (($order_amount != $amount) || ($amount <= 0)) return $bad_sum_message;

      // проверяем наличие товаров
      foreach ($order->products as &$product) {
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

      // если это финальный запрос
      if ($pre_request == 0) {

        // ставим в заказе признак оплаты и списания товаров
        $params = $_POST;
        foreach ($params as &$param) $param = $this->text->stripTags($param);
        $query = "UPDATE " . DATABASE_ORDERS_TABLENAME . " "
               . "SET payment_status = 1, "
                   . "payment_date = NOW(), "
                   . "payment_method_id = '" . $this->db->query_value($payment_method_id) . "', "
                   . "payment_details = '" . $this->db->query_value(var_export($params, TRUE)) . "', "
                   . "written_off = 1 "
               . "WHERE order_id = '" . $this->db->query_value($order->order_id) . "' "
               . "LIMIT 1";
        $this->db->query($query);

        // если еще не было сделано списание товара, делаем
        if (!$order->written_off) {
            if (!$this->settings->orders_non_touch_quantity) {
                foreach ($order->products as & $product) {
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
        $params->id = $order->order_id;
        $this->db->orders->one($order, $params);

        // уведомляем покупателя и администратора
        $this->smarty->assign('payway_name', 'WebMoney');
        $this->inform_about_order($order,
                                  "Оплачен через WebMoney заказ №" . $order->order_id . " на сайте " . $this->root_url,
                                  "Принята оплата заказа №" . $order->order_id . " на сайте " . $this->root_url,
                                  INFORM_ABOUT_ORDER_ACTION_PAYMENT);
      }
      return "Yes";
    }
  }

  // =========================================================================
  // Внеклассовая часть программного кода
  // =========================================================================

  $webmoney = new WebMoney();
  echo @$webmoney->process();
  exit;
?>
