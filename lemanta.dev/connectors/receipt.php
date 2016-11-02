<?php
  // Impera CMS: модуль оплаты по квитанции через банк.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

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

  // подключаем класс динамической генерации PDF-документов
  require_once("tcpdf/tcpdf.php");

  // вывод текстового поля ===================================================

  // определяем функцию, только если она не существует
  if (!function_exists("receipt_document_text_field")) {

    function receipt_document_text_field (&$pdf, $x, $y, $width, $text, $undertext) {
      $pdf->SetXY($x, $y);
      $pdf->SetLineStyle(array("dash" => 0));
      $pdf->SetFontSize(9);
      $pdf->Write(5, $text);
      $pdf->Line($x + 1, $y + 5, $x + $width, $y + 5);
      $pdf->SetXY($x, $y + 4);
      $pdf->SetFontSize(7);
      $pdf->Write(5, $undertext);
    }

  }

  // отрисовка квитанции на оплату ===========================================

  // определяем функцию, только если она не существует
  if (!function_exists("draw_receipt_document")) {

    function draw_receipt_document (&$pdf) {

      // обрабатываем входные параметры
      $order_id = isset($_POST["order_id"]) ? trim(stripslashes($_POST["order_id"])) : "";

      $recipient = isset($_POST["recipient"]) ? trim(stripslashes($_POST["recipient"])) : "";
      $recipient_label = isset($_POST["recipient_label"]) ? trim(stripslashes($_POST["recipient_label"])) : "(наименование получателя платежа)";

      $inn = isset($_POST["inn"]) ? trim(stripslashes($_POST["inn"])) : "";
      $inn_label = isset($_POST["inn_label"]) ? trim(stripslashes($_POST["inn_label"])) : "(ИНН получателя платежа)";

      $account = isset($_POST["account"]) ? trim(stripslashes($_POST["account"])) : "";
      $account_label = isset($_POST["account_label"]) ? trim(stripslashes($_POST["account_label"])) : "(номер счета получателя платежа)";

      $bank = isset($_POST["bank"]) ? trim(stripslashes($_POST["bank"])) : "";
      $bank_label = isset($_POST["bank_label"]) ? trim(stripslashes($_POST["bank_label"])) : "(наименование банка получателя платежа)";

      $bik = isset($_POST["bik"]) ? trim(stripslashes($_POST["bik"])) : "";
      $bik_label = isset($_POST["bik_label"]) ? trim(stripslashes($_POST["bik_label"])) : "БИК";

      $correspondent_account = isset($_POST["correspondent_account"]) ? trim(stripslashes($_POST["correspondent_account"])) : "";
      $correspondent_account_label = isset($_POST["correspondent_account_label"]) ? trim(stripslashes($_POST["correspondent_account_label"])) : "(номер кор./сч. банка получателя платежа)";

      $purpose = isset($_POST["purpose"]) ? trim(stripslashes($_POST["purpose"])) : "";
      $purpose_label = isset($_POST["purpose_label"]) ? trim(stripslashes($_POST["purpose_label"])) : "(наименование платежа)";
      if ($purpose == "") $purpose = "Оплата заказа №" . $order_id;

      $payer_inn = isset($_POST["payer_inn"]) ? trim(stripslashes($_POST["payer_inn"])) : "";
      $payer_inn_label = isset($_POST["payer_inn_label"]) ? trim(stripslashes($_POST["payer_inn_label"])) : "(номер лицевого счета (код) плательщика)";

      $payer_name = isset($_POST["payer_name"]) ? trim(stripslashes($_POST["payer_name"])) : "";
      $payer_name_label = isset($_POST["payer_name_label"]) ? trim(stripslashes($_POST["payer_name_label"])) : "Ф.И.О. плательщика";

      $payer_address = isset($_POST["payer_address"]) ? trim(stripslashes($_POST["payer_address"])) : "";
      $payer_address_label = isset($_POST["payer_address_label"]) ? trim(stripslashes($_POST["payer_address_label"])) : "Адрес плательщика";

      $banknote = isset($_POST["banknote"]) ? trim(stripslashes($_POST["banknote"])) : "";
      $pence = isset($_POST["pence"]) ? trim(stripslashes($_POST["pence"])) : "";
      $amount = isset($_POST["amount"]) ? str_replace(",", ".", trim(stripslashes($_POST["amount"]))) : "";

      // устанавливаем свойства документа
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->setPageOrientation("P");

      // устанавливаем шрифт для всего документа
      $pdf->SetTextColor(0, 0, 0);

      // добавляем страницу
      $pdf->AddPage();
      $pdf->SetDisplayMode("real");
      $pdf->SetFontSize(8);

      // размеры квитанции
      $width = 190;
      $height = 75;
      // ширина служебного поля
      $field_width = 80;

      // первая рамка
      $x = 10;
      $y = 10;
      $pdf->SetLineStyle(array("dash" => 2));
      $pdf->SetXY($x, $y);
      $pdf->Cell($width, $height, "", 1, 0, "C", 0);
      $pdf->SetXY($field_width + $x - 40, $y + 5);
      $pdf->Write(5, "Извещение" . PHP_EOL);
      $pdf->SetXY($x + 10, $height + $y - 10);
      $pdf->Write(5, "Кассир" . PHP_EOL);
      $pdf->SetXY($field_width, $y);
      $pdf->Cell($width - $field_width, $height, "", "L", 0, "C", 0);

      // получатель
      $x = $field_width;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 110, $recipient, $recipient_label);

      // код получателя
      $y += 8;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 35, $inn, $inn_label);

      // счет получателя
      $x += 50;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 60, $account, $account_label);

      // банк получателя
      $x -= 50;
      $y += 9;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 110, $bank, $bank_label);

      // код банка получателя
      $y += 12;
      $pdf->SetXY($x + 2, $y);
      $pdf->SetFontSize(9);
      $pdf->Write(5, $bik_label);
      receipt_document_text_field($pdf, $x + 10, $y, 25, $bik, "");

      // корреспондентский счет
      $x += 45;
      receipt_document_text_field($pdf, $x + 7, $y, 60, $correspondent_account, $correspondent_account_label);

      // назначение платежа
      $x -= 45;
      $y += 8;
      receipt_document_text_field($pdf, $x + 2, $y, 53, $purpose, $purpose_label);

      // код плательщика
      $x += 55;
      receipt_document_text_field($pdf, $x + 2, $y, 55, $payer_inn, $payer_inn_label);

      // плательщик
      $x -= 55;
      $y += 9;
      $pdf->SetXY($x + 2, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, $payer_name_label);
      receipt_document_text_field($pdf, $x + 35, $y - 1, 77, $payer_name, "");

      // адрес плательщика
      $y += 5;
      $pdf->SetXY($x + 2, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, $payer_address_label);
      receipt_document_text_field($pdf, $x + 35, $y - 1, 77, $payer_address, "");

      // сумма платежа
      $y += 5;
      $pdf->SetXY($x + 64, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, "Сумма платежа:  ");
      $pdf->Write(5, floor($amount) . " " . $banknote . " " . round(($amount * 100 - floor($amount) * 100)) . " " . $pence);

      // итого
      $y += 5;
      $pdf->SetXY($x + 76, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, " Итого:  ");
      $pdf->SetFontSize(9);
      $pdf->Write(5, floor($amount) . " " . $banknote . " " . round(($amount * 100 - floor($amount) * 100)) . " " . $pence);
      $pdf->SetFontSize(8);

      // подпись плательщика
      receipt_document_text_field($pdf, $x + 2, $y, 30, "", "(подпись плательщика)");

      // вторая рамка
      $x = 10;
      $y = $height + 10;
      $pdf->SetLineStyle(array("dash" => 2));
      $pdf->SetXY($x, $y);
      $pdf->Cell($width, $height, "", "LBR", 0, "C", 0);
      $pdf->SetFontSize(8);
      $pdf->SetXY($field_width + $x - 40, $y + 5);
      $pdf->Write(5, "Квитанция" . PHP_EOL);
      $pdf->SetXY($x + 10, $height + $y - 10);
      $pdf->Write(5, "Кассир" . PHP_EOL);
      $pdf->SetXY($field_width, $y);
      $pdf->Cell($width - $field_width, $height, "", "L", 0, "C", 0);

      // получатель
      $x = $field_width;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 110, $recipient, $recipient_label);

      // код получателя
      $y += 8;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 35, $inn, $inn_label);

      // счет получателя
      $x += 50;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 60, $account, $account_label);

      // банк получателя
      $x -= 50;
      $y += 9;
      receipt_document_text_field($pdf, $x + 2, $y + 3, 110, $bank, $bank_label);

      // код банка получателя
      $y += 12;
      $pdf->SetXY($x + 2, $y);
      $pdf->SetFontSize(9);
      $pdf->Write(5, $bik_label);
      receipt_document_text_field($pdf, $x + 10, $y, 25, $bik, "");

      // корреспондентский счет
      $x += 45;
      receipt_document_text_field($pdf, $x + 7, $y, 60, $correspondent_account, $correspondent_account_label);

      // назначение платежа
      $x -= 45;
      $y += 8;
      receipt_document_text_field($pdf, $x + 2, $y, 53, $purpose, $purpose_label);

      // код плательщика
      $x += 55;
      receipt_document_text_field($pdf, $x + 2, $y, 55, $payer_inn, $payer_inn_label);

      // плательщик
      $x -= 55;
      $y += 9;
      $pdf->SetXY($x + 2, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, $payer_name_label);
      receipt_document_text_field($pdf, $x + 35, $y - 1, 77, $payer_name, "");

      // адрес плательщика
      $y += 5;
      $pdf->SetXY($x + 2, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, $payer_address_label);
      receipt_document_text_field($pdf, $x + 35, $y - 1, 77, $payer_address, "");

      // сумма платежа
      $y += 5;
      $pdf->SetXY($x + 64, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, "Сумма платежа:  ");
      $pdf->Write(5, floor($amount) . " " . $banknote . " " . round(($amount * 100 - floor($amount) * 100)) . " " . $pence);

      // итого
      $y += 5;
      $pdf->SetXY($x + 76, $y);
      $pdf->SetFontSize(8);
      $pdf->Write(5, " Итого:  ");
      $pdf->SetFontSize(9);
      $pdf->Write(5, floor($amount) . " " . $banknote . " " . round(($amount * 100 - floor($amount) * 100)) . " " . $pence);
      $pdf->SetFontSize(8);

      // подпись плательщика
      receipt_document_text_field($pdf, $x + 2, $y, 30, "", "(подпись плательщика)");
    }

  }

  // если существует старый объект PDF-документа, уничтожаем
  if (isset($pdf)) unset($pdf);

  // создаем новый объект PDF-документа
  $pdf = new TCPDF();
  $pdf->setPDFVersion("1.6");
  $pdf->SetFont("dejavusanscondensed", "", 8);

  // отрисовываем квитанцию на оплату
  draw_receipt_document($pdf);

  // как просили вывести результат?
  $temp = new stdClass;
  $temp->filename = isset($_POST["receipt_filename"]) ? trim(stripslashes($_POST["receipt_filename"])) . ".pdf" : "receipt.pdf";
  $temp->destination = isset($_POST["output"]) ? strtolower(trim($_POST["output"])) : "";
  switch ($temp->destination) {

    // если записать в файл
    case "file":
      $pdf->Output($temp->filename, "F");
      break;

    // если скачиваемым файлом
    case "download":
      $pdf->Output($temp->filename, "D");
      break;

    // если возвратить бинарной строкой
    case "string":
      return $pdf->Output($temp->filename, "S");
      break;

    // если передать в поток
    case "stream":
    default:
      $pdf->Output($temp->filename, "I");
  }

  // уничтожаем объект PDF-документа
  unset($pdf);
  return;
?>
