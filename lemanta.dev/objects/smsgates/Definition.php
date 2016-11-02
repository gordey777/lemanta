<?php
    // =======================================================================
    /**
    *  Константы модуля SMS-шлюзов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================



    // какой файл является шаблоном модуля SMS-шлюзов,
    // какой файл является шаблоном модуля SMS-шлюза BusinessLife.com.ua,
    // какой файл является шаблоном модуля SMS-шлюза AlphaSMS.com.ua,
    // какой файл является шаблоном модуля SMS-шлюза RFSMS.ru,
    // какой файл является шаблоном модуля SMS-шлюза AtomPark ePochta SMS
    // какой файл является шаблоном модуля SMS-шлюза TurboSMS.ua
    define('ADMIN_SMSGATES_CLASS_TEMPLATE_FILE', 'sms_gates/sms_gates.htm');
    define('ADMIN_SMSGATE_BUSINESSLIFECOMUA_CLASS_TEMPLATE_FILE', 'sms_gates/gate_BusinessLifeComUA.htm');
    define('ADMIN_SMSGATE_ALPHASMSCOMUA_CLASS_TEMPLATE_FILE', 'sms_gates/gate_AlphaSmsComUA.htm');
    define('ADMIN_SMSGATE_RFSMSRU_CLASS_TEMPLATE_FILE', 'sms_gates/gate_RFSmsRU.htm');
    define('ADMIN_SMSGATE_EPOCHTASMS_CLASS_TEMPLATE_FILE', 'sms_gates/gate_ePochtaSMS.htm');
    define('ADMIN_SMSGATE_TURBOSMSUA_CLASS_TEMPLATE_FILE', 'sms_gates/gate_TurboSmsUA.htm');



    // какой файл является шаблоном SMS-уведомления пользователя о заказе,
    // какой файл является шаблоном SMS-уведомления пользователя об оплате заказа,
    // какой файл является шаблоном SMS-уведомления пользователя о изменении в заказе,
    // какой файл является шаблоном SMS-уведомления администратора о заказе,
    // какой файл является шаблоном SMS-уведомления администратора об оплате заказа,
    // какой файл является шаблоном SMS-уведомления об активности по купону
    define('SMS_ORDER_TO_USER_TEMPLATE_FILE', 'sms_order_to_user.htm');
    define('SMS_ORDER_PAYMENT_TO_USER_TEMPLATE_FILE', 'sms_order_payment_to_user.htm');
    define('SMS_ORDER_CHANGE_TO_USER_TEMPLATE_FILE', 'sms_order_change_to_user.htm');
    define('SMS_ORDER_TO_ADMIN_TEMPLATE_FILE', 'sms_order_to_admin.htm');
    define('SMS_ORDER_PAYMENT_TO_ADMIN_TEMPLATE_FILE', 'sms_order_payment_to_admin.htm');
    define('SMS_COUPON_ACTIVITY_TEMPLATE_FILE', 'sms_coupon_activity.htm');



    // минимальный размер номера телефона,
    // максимальный размер номера телефона
    if (!defined('PHONE_NUMBER_MINIMAL_SIZE')) define('PHONE_NUMBER_MINIMAL_SIZE', 9);
    if (!defined('PHONE_NUMBER_MAXIMAL_SIZE')) define('PHONE_NUMBER_MAXIMAL_SIZE', 15);



    // псевдоним телефонного номера администратора
    define('ADMIN_PHONE_PSEUDONYM', 'administrator');



    return;
?>