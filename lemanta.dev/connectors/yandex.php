<?php
    // =======================================================================
    /**
    *  @package     Impera CMS
    *  @file        Yandex.Money payment module
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
    *  Модуль оплаты через платежную систему Yandex.Money
    */
    // =======================================================================

    class YandexMoney extends PaymentModuleSubstrate {

        // меточное имя модуля
        protected $marker = 'Yandex';



        // ===================================================================
        /**
        *  Обработка входных параметров
        *
        *  @access  public
        *  @return  string      результат
        */
        // ===================================================================

        public function process () {

            // извлекаем тип оплаты
            //     p2p-incoming = с кошелька
            //     card-incoming = с карты
            $type = $this->getPostParam('notification_type', 'chars', '');
            if ($type != 'p2p-incoming' && $type != 'card-incoming') $this->security->stop('Ошибка: Неизвестный тип оплаты!', 400);

            // извлекаем магазинную метку платежа
            $label = $this->getPostParam('label', 'chars', '');

                // добавляем в пост ИД заказа и способа оплаты
                $ids = explode('|', $label, 2);
                $this->addPostParam('order_id', $ids[0]);
                $this->addPostParam('payment_id', isset($ids[1]) ? $ids[1] : 0);

            // начинаем оплату
            $status =  $this->startPayment('order_id',        'Ошибка: Не указан идентификатор оплачиваемого заказа!',
                                                              'Ошибка: Оплачиваемый заказ не найден!',
                                                              'Спасибо! Ваш заказ оплачен.',

                                           // ИД способа оплаты
                                           'payment_id',      'Ошибка: Не указан идентификатор способа оплаты!',
                                                              'Ошибка: Неизвестный способ оплаты или он отключен!',
                                                              'Ошибка: У способа оплаты отсутствуют или не те параметры!',

                                           // контрольная подпись
                                           'sha1_hash',       'Ошибка: Недостаточно входных параметров!',

                                           // сумма оплаты
                                           'amount',          'Ошибка: Недостаточно входных параметров!',
                                                              'Ошибка: Неверная сумма оплаты!',

                                           // секретный ключ (из параметров способа оплаты)
                                           'secret_key',      'Ошибка: У способа оплаты нарушена структура параметров!');
            if (is_string($status)) $this->security->stop($status, 400);

            // извлекаем входные параметры
            $operation_id = $this->getPostParam('operation_id', 'chars', '');    // ИД операции в истории счета получателя
            $currency = $this->getPostParam('currency', 'chars', '');            // валюта платежа (код 643)
            $datetime = $this->getPostParam('datetime', 'chars', '');            // дата и время платежа
            $sender = $this->getPostParam('sender', 'chars', '');                // номер счета плательщика
            $codepro = $this->getPostParam('codepro', 'chars', '');              // true если перевод защищен кодом протекции

            // проверяем контрольную подпись
            $sign = $type . '&'
                  . $operation_id . '&'
                  . $this->sum . '&'
                  . $currency . '&'
                  . $datetime . '&'
                  . $sender . '&'
                  . $codepro . '&'
                  . $this->secret . '&'
                  . $label;
            $sign = $this->text->upperCase(sha1($sign));
            if ($sign != $this->sign) $this->security->stop('Ошибка: Контрольная подпись неправильная!', 400);

            // проверяем наличие товаров
            $status = $this->checkOrderProducts($this->order);
            if (is_string($status)) $this->security->stop($status, 400);

            // завершаем оплату
            $this->finalizePayment($this->order, $this->pay_id, $this->marker);

            // по протоколу требуется возвратить код 200 OK, если все правильно
            $this->security->stop('OK', 200);
        }
    }



    // =======================================================================
    /**
    *  Внеклассовая часть программного кода
    */
    // =======================================================================

    $module = new YandexMoney();
    echo $module->process();
    exit;
?>