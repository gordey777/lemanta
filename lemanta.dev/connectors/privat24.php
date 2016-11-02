<?php
  // Impera CMS: модуль оплаты через Privat24.
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
  // Класс Privat24 (модуль оплаты через Privat24)
  // =========================================================================

  class Privat24 extends Basic {

    // обработка входных параметров ==========================================

    public function process () {

      // берем URL выхода на главную страницу
      $root_url = explode("/", $this->root_url);
      if (count($root_url) > 1) array_pop($root_url);
      $root_url = implode("/", $root_url);
      $url = "http://" . $root_url . "/";

      // если это безинформационный возврат покупателя на финальную страницу
      if (!isset($_POST["payment"]) || !isset($_POST["signature"])) {

        // если есть сведения о коде (url) заказа
        if (isset($_REQUEST["order"]) && (trim($_REQUEST["order"]) != "")) {
          $url .= "order/" . trim(substr($this->text->stripTags($_REQUEST["order"], TRUE), 0, DATABASE_ORDERS_FIELDSIZE_CODE));
          return "В случае успешного принятия банком Вашего платежа произойдет соответствующее изменение статуса заказа на <a href=\"" . htmlspecialchars($url, ENT_QUOTES) . "\">его странице</a>.";
        }

        // иначе похоже нелегальный вызов, перенаправляем на главную страницу
        return "Эта страница не предназначена для прямого вызова посетителем сайта.";

      // иначе есть ответ от сервера платежной системы
      } else {

        // задаем информационные сообщения
        $unknown_method_message = "Ошибка: Неизвестный способ оплаты!";
        $unknown_status_message = "Ошибка: Неизвестный тип состояния платежа!";
        $bad_signature_message = "Ошибка: Контрольная подпись неправильная!";
        $bad_merchantid_message = "Ошибка: Неверный идентификатор мерчанта!";
        $bad_sum_message = "Ошибка: Неверная сумма оплаты!";
        $no_orderid_message = "Ошибка: Не указан идентификатор оплачиваемого заказа!";
        $no_order_message = "Ошибка: Оплачиваемый заказ не найден!";
        $no_paydata_message = "Ошибка: У способа оплаты отсутствуют параметры!";

        // смотрим, есть ли сведения о идентификаторе способа оплаты
        $payment_id = isset($_REQUEST["method"]) ? trim(substr($this->text->stripTags($_REQUEST["method"], TRUE), 0, DATABASE_PAYMENTS_FIELDSIZE_ID)) : "";
        if (empty($payment_id)) return $unknown_method_message;

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
        $data = $_POST["payment"];
        $sign = isset($payment_params["privat24_secret_key"]) ? $payment_params["privat24_secret_key"] : "";
        $sign = sha1(md5($data . $sign));
        if ($sign != $_POST["signature"]) return $bad_signature_message;

        // берем входные параметры
        parse_str($data, $params);
        $data = array();
        // сумма
        $data["amt"] = isset($params["amt"]) ? str_replace(",", ".", trim($params["amt"])) : "0";
        // валюта
        $data["ccy"] = isset($params["ccy"]) ? trim($params["ccy"]) : "";
        // описание
        $data["details"] = isset($params["details"]) ? trim($params["details"]) : "";
        $data["ext_details"] = isset($params["ext_details"]) ? trim($params["ext_details"]) : "";
        // источник оплаты
        $data["pay_way"] = isset($params["pay_way"]) ? trim($params["pay_way"]) : "";
        // идентификатор заказа
        $data["order"] = isset($params["order"]) ? trim($params["order"]) : "";
        // идентификатор мерчанта
        $data["merchant"] = isset($params["merchant"]) ? trim($params["merchant"]) : "";
        // статус транзакции
        $status = isset($params["state"]) ? trim($params["state"]) : "";
        // дата отправки платежа в проводку
        $data["date"] = isset($params["date"]) ? trim($params["date"]) : "";
        // идентификатор платежа в системе банка
        $data["ref"] = isset($params["ref"]) ? trim($params["ref"]) : "";
        // номер телефона плательщика
        $data["sender_phone"] = isset($params["sender_phone"]) ? trim($params["sender_phone"]) : "";

        // читаем необходимый заказ
        if ($data["order"] == "") return $no_orderid_message;
        $params = new stdClass;
        $params->id = $data["order"];
        $this->db->orders->one($order, $params);
        if (empty($order)) return $no_order_message;

        // еще задаем информационные сообщения
        $url .= "order/" . trim($order->code);
        $success_message = "Спасибо! Ваш заказ оплачен. Пройдите на <a href='" . htmlspecialchars($url, ENT_QUOTES) . "'>его страницу</a>.";
        $test_message = "Имитация оплаты заказа в тестовом режиме прошла успешно.";
        $failure_message = "Ваш платеж был отменен Вами или отклонен банком. Для выбора другого способа оплаты пройдите на <a href='" . htmlspecialchars($url, ENT_QUOTES) . "'>страницу заказа</a>.";

        // если заказ уже оплачен
        if ($order->payment_status == 1) return $success_message;

        // проверяем сумму оплаты
        $order_amount = round($order->total_amount * $method->rate_from / $method->rate_to, 2);
        if (($order_amount != $this->number->floatValue($data["amt"])) || ($this->number->floatValue($data["amt"]) <= 0)) return $bad_sum_message;

        // проверяем идентификатор мерчанта
        $id = isset($payment_params["privat24_merchant_id"]) ? trim($payment_params["privat24_merchant_id"]) : "";
        if ($data["merchant"] != $id) return $bad_merchantid_message;

        // проверяем состояние платежа
        $status = strtolower(trim($status));
        if ($status == "test") return $test_message;
        elseif ($status == "fail") return $failure_message;
        elseif ($status != "ok") return $unknown_status_message;

        // ставим в заказе признак оплаты и списания товаров
        foreach ($data as &$param) $param = $this->text->stripTags($param);
        $query = "UPDATE " . DATABASE_ORDERS_TABLENAME . " "
               . "SET payment_status = 1, "
                   . "payment_date = NOW(), "
                   . "payment_method_id = '" . $this->db->query_value($payment_id) . "', "
                   . "payment_details = '" . $this->db->query_value(var_export($data, TRUE)) . "', "
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
        $this->smarty->assign('payway_name', 'Приват24');
        $this->inform_about_order($order,
                                  "Оплачен через Приват24 заказ №" . $order->order_id . " на сайте " . $root_url,
                                  "Принята оплата заказа №" . $order->order_id . " на сайте " . $root_url,
                                  INFORM_ABOUT_ORDER_ACTION_PAYMENT);

        // возвращаем сообщение об успехе
        return $success_message;
      }
    }
  }

  // =========================================================================
  // Внеклассовая часть программного кода
  // =========================================================================

  $privat24 = new Privat24();
  $privat24 = @$privat24->process();

  // выводим контент страницы
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="ru">
    <title>Результат платежа Privat24</title>
  </head>
  <style>
    *             {border:           0px solid;
                   border-radius:    0px; -moz-border-radius: 0px; -webkit-border-radius: 0px;
                   box-shadow:       0px 0px 0px; -moz-box-shadow: 0px 0px 0px; -webkit-box-shadow: 0px 0px 0px;
                   font-family:      Verdana, Tahoma, Arial;
                   margin:           0px;
                   padding:          0px;
                   text-align:       left;
                   text-indent:      0px;}
    div           {background-color: #FFFFFF;
                   border:           #C0C0C0 1px solid;
                   box-shadow:       #E0E0E0 1px 2px 10px; -moz-box-shadow: #E0E0E0 1px 2px 10px; -webkit-box-shadow: #E0E0E0 1px 2px 10px;
                   color:            #000000;
                   font-size:        10pt;
                   margin:           75px auto;
                   padding:          0px;
                   width:            350px;}
    div div       {background-color: #F0F0F0;
                   border:           0px solid;
                   box-shadow:       0px 0px 0px; -moz-box-shadow: 0px 0px 0px; -webkit-box-shadow: 0px 0px 0px;
                   line-height:      20px;
                   margin:           4px;
                   padding:          15px;
                   width:            auto;}
    a             {color:            #0080FF;
                   font-weight:      bold;
                   text-decoration:  none;
                   white-space:      nowrap;}
    a:hover       {color:            #C00000;
                   text-decoration:  underline;}
    a.home        {color:            #0080FF;
                   font-size:        8pt;
                   font-weight:      normal;
                   text-decoration:  none;
                   white-space:      nowrap;}
  </style>
  <body>
    <div>
      <div>
        <b>Результат платежа Privat24</b>
        <br><br>
        <?php echo $privat24; ?>
        <br><br>
        <br><br>
        <a class="home" href="../">Перейти на главную</a>
        <br>
      </div>
    </div>
  </body>
</html>
<?php
  exit;
?>
