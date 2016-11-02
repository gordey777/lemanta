<?php
    // =======================================================================
    /**
    *  @package     Impera CMS
    *  @file        RBK Money payment module
    *  @version     1.0
    *  @author      AIMatrix, Ukraine
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru/
    */
    // =======================================================================

    // подключаем подложку платежного модуля (легальный запуск)
    $legalStart = TRUE;
    require_once(dirname(__FILE__) . '/Substrate.php');



    // =======================================================================
    /**
    *  Модуль оплаты через платежную систему RBK Money
    */
    // =======================================================================

    class RBKmoney extends PaymentModuleSubstrate {

        // меточное имя модуля
        protected $marker = 'RBKmoney';



        // ===================================================================
        /**
        *  Обработка входных параметров
        *
        *  @access  public
        *  @return  string      результат
        */
        // ===================================================================

        public function process () {

            // извлекаем статус платежа
            //     3 = принят в обработку
            //     5 = выполнен
            $status = $this->getPostParam('paymentStatus', 'chars', '');
            if (($status != 3) && ($status != 5)) return '';

            // извлекаем входные параметры
            $shopid = $this->getPostParam('eshopId', 'chars', '');              // ИД мерчанта
            $shopAccount = $this->getPostParam('eshopAccount', 'chars', '');    // номер счета мерчанта
            $orderDescr = $this->getPostParam('serviceName', 'chars', '');      // описание заказа
            $currency = $this->getPostParam('recipientCurrency', 'chars', '');  // валюта платежа
            $userName = $this->getPostParam('userName', 'chars', '');           // имя покупателя
            $userEmail = $this->getPostParam('userEmail', 'chars', '');         // емейл покупателя
            $paymentData = $this->getPostParam('paymentData', 'chars', '');     // дата платежа

            // начинаем оплату
            $status =  $this->startPayment('orderId',         'Ошибка: Не указан идентификатор оплачиваемого заказа!',
                                                              'Ошибка: Оплачиваемый заказ не найден!',
                                                              'Спасибо! Ваш заказ оплачен.',

                                           // ИД способа оплаты
                                           'userField_1',     'Ошибка: Не указан идентификатор способа оплаты!',
                                                              'Ошибка: Неизвестный способ оплаты или он отключен!',
                                                              'Ошибка: У способа оплаты отсутствуют или не те параметры!',

                                           // контрольная подпись
                                           'hash',            'Ошибка: Недостаточно входных параметров!',

                                           // сумма оплаты
                                           'recipientAmount', 'Ошибка: Недостаточно входных параметров!',
                                                              'Ошибка: Неверная сумма оплаты!',

                                           // секретный ключ (из параметров способа оплаты)
                                           'secret_key',      'Ошибка: У способа оплаты нарушена структура параметров!');
            if (is_string($status)) return $status;

            // проверяем ИД мерчанта
            $merchant = $this->getObjectField($this->method->params, 'merchant_id', 'chars', '');
            if ($merchant != $shopid) return 'Ошибка: Неправильный номер магазина!';

            // проверяем контрольную подпись
            $sign = $shopId . '::'
                  . $this->id . '::'
                  . $orderDescr . '::'
                  . $shopAccount . '::'
                  . $this->sum . '::'
                  . $currency . '::'
                  . $status . '::'
                  . $userName . '::'
                  . $userEmail . '::'
                  . $paymentData . '::'
                  . $this->secret;
            $sign = strtoupper(md5($sign));
            if ($sign != $this->sign) return 'Ошибка: Контрольная подпись неправильная!';

            // проверяем наличие товаров
            $status = $this->checkOrderProducts($this->order);
            if (is_string($status)) return $status;

            // завершаем оплату
            if ($status == 5) {
                $this->finalizePayment($this->order, $this->pay_id, $this->marker);
            }

            // по протоколу требуется возвратить строку OK, если все правильно
            return "OK\n";
        }
    }



    // =======================================================================
    /**
    *  Внеклассовая часть программного кода
    */
    // =======================================================================

    $module = new RBKmoney();
    echo $module->process();
    exit;
?>