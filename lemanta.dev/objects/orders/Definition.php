<?php
    // =======================================================================
    /**
    *  Константы модуля заказов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================



    // имя файла шаблона модуля заказов
    define('ADMIN_ORDERS_CLASS_TEMPLATE_FILE', 'admin_orders.htm');



    // имя файла шаблона уведомления пользователя о заказе,
    // имя файла шаблона уведомления пользователя об оплате заказа,
    // имя файла шаблона уведомления администратора о заказе,
    // имя файла шаблона уведомления администратора об оплате заказа
    define('EMAIL_ORDER_TO_USER_TEMPLATE_FILE', 'email_order_to_user.htm');
    define('EMAIL_ORDER_PAYMENT_TO_USER_TEMPLATE_FILE', 'email_order_payment_to_user.htm');
    define('EMAIL_ORDER_TO_ADMIN_TEMPLATE_FILE', 'email_order_to_admin.htm');
    define('EMAIL_ORDER_PAYMENT_TO_ADMIN_TEMPLATE_FILE', 'email_order_payment_to_admin.htm');



    // папка изображений для заказов (относительно корневой папки сайта)
    define('ADMIN_ORDERS_CLASS_UPLOAD_FOLDER', 'files/orders/');



    // имя сеансового параметра
    define('ORDERS_SESSION_PARAM_NAME', 'admin_orders');



    return;
?>