<?php
    // =======================================================================
    /**
    *  Константы модуля товаров (TODO: расчистить это свалочное место для констант разных модулей, которые были раньше напиханы в файл модуля товаров)
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================



    // какой файл является шаблоном модуля страницы товара,
    // какой файл является шаблоном модуля списка комплектов товаров,
    // какой файл является шаблоном модуля страницы комплекта товаров,
    // какой файл является шаблоном модуля списка стадий заказов,
    // какой файл является шаблоном модуля страницы стадии заказа,
    // какой файл является шаблоном модуля истории платежей,
    // какой файл является шаблоном модуля списка кредитных программ,
    // какой файл является шаблоном модуля страницы кредитной программы,
    // какой файл является шаблоном модуля списка способов доставки,
    // какой файл является шаблоном модуля страницы способа доставки,
    // какой файл является шаблоном модуля списка типов доставки,
    // какой файл является шаблоном модуля страницы типа доставки,
    // какой файл является шаблоном модуля списка сроков отправки,
    // какой файл является шаблоном модуля страницы срока отправки,
    // какой файл является шаблоном модуля списка валют,
    // какой файл является шаблоном модуля страницы валюты,
    // какой файл является шаблоном модуля списка способов оплаты,
    // какой файл является шаблоном модуля страницы способа оплаты,
    // какой файл является шаблоном модуля списка пользователей,
    // какой файл является шаблоном модуля страницы пользователя,
    // какой файл является шаблоном модуля списка стран,
    // какой файл является шаблоном модуля страницы страны,
    // какой файл является шаблоном модуля списка областей,
    // какой файл является шаблоном модуля страницы области,
    // какой файл является шаблоном модуля списка городов,
    // какой файл является шаблоном модуля страницы города,
    // какой файл является шаблоном модуля списка учебных заведений,
    // какой файл является шаблоном модуля страницы учебного заведения,
    // какой файл является шаблоном модуля списка типов учебных заведений,
    // какой файл является шаблоном модуля страницы типа учебного заведения,
    // какой файл является шаблоном модуля списка предметов учебных заведений,
    // какой файл является шаблоном модуля страницы предмета учебного заведения,
    // какой файл является шаблоном модуля списка классов учебных заведений,
    // какой файл является шаблоном модуля страницы класса учебного заведения
    // какой файл является шаблоном модуля списка учащихся,
    // какой файл является шаблоном модуля страницы учащегося
    define('ADMIN_PRODUCT_CLASS_TEMPLATE_FILE', 'admin_product.htm');
    define('ADMIN_PRODUCTSKITS_CLASS_TEMPLATE_FILE', 'admin_products_kits.htm');
    define('ADMIN_PRODUCTSKIT_CLASS_TEMPLATE_FILE', 'admin_products_kit.htm');
    define('ADMIN_ORDERSPHASES_CLASS_TEMPLATE_FILE', 'admin_orders_phases.htm');
    define('ADMIN_ORDERSPHASE_CLASS_TEMPLATE_FILE', 'admin_orders_phase.htm');
    define('ADMIN_PAYMENTSHISTORY_CLASS_TEMPLATE_FILE', 'admin_payments_history.htm');
    define('ADMIN_CREDITPROGRAMS_CLASS_TEMPLATE_FILE', 'admin_credit_programs.htm');
    define('ADMIN_CREDITPROGRAM_CLASS_TEMPLATE_FILE', 'admin_credit_program.htm');
    define('ADMIN_DELIVERIES_CLASS_TEMPLATE_FILE', 'admin_deliveries.htm');
    define('ADMIN_DELIVERY_CLASS_TEMPLATE_FILE', 'admin_delivery.htm');
    define('ADMIN_DELIVERIESTYPES_CLASS_TEMPLATE_FILE', 'admin_deliveries_types.htm');
    define('ADMIN_DELIVERIESTYPE_CLASS_TEMPLATE_FILE', 'admin_deliveries_type.htm');
    define('ADMIN_SHIPPINGSTERMS_CLASS_TEMPLATE_FILE', 'admin_shippings_terms.htm');
    define('ADMIN_SHIPPINGSTERM_CLASS_TEMPLATE_FILE', 'admin_shippings_term.htm');
    define('ADMIN_CURRENCIES_CLASS_TEMPLATE_FILE', 'admin_currencies.htm');
    define('ADMIN_CURRENCY_CLASS_TEMPLATE_FILE', 'admin_currency.htm');
    define('ADMIN_PAYMENTS_CLASS_TEMPLATE_FILE', 'admin_payments.htm');
    define('ADMIN_PAYMENT_CLASS_TEMPLATE_FILE', 'admin_payment.htm');
    define('ADMIN_USERS_CLASS_TEMPLATE_FILE', 'admin_users.htm');
    define('ADMIN_USER_CLASS_TEMPLATE_FILE', 'admin_user.htm');
    define('ADMIN_COUNTRIES_CLASS_TEMPLATE_FILE', 'admin_countries.htm');
    define('ADMIN_COUNTRY_CLASS_TEMPLATE_FILE', 'admin_country.htm');
    define('ADMIN_REGIONS_CLASS_TEMPLATE_FILE', 'admin_regions.htm');
    define('ADMIN_REGION_CLASS_TEMPLATE_FILE', 'admin_region.htm');
    define('ADMIN_TOWNS_CLASS_TEMPLATE_FILE', 'admin_towns.htm');
    define('ADMIN_TOWN_CLASS_TEMPLATE_FILE', 'admin_town.htm');
    define('ADMIN_SCHOOLS_CLASS_TEMPLATE_FILE', 'admin_schools.htm');
    define('ADMIN_SCHOOL_CLASS_TEMPLATE_FILE', 'admin_school.htm');
    define('ADMIN_SCHOOLSTYPES_CLASS_TEMPLATE_FILE', 'admin_schools_types.htm');
    define('ADMIN_SCHOOLSTYPE_CLASS_TEMPLATE_FILE', 'admin_schools_type.htm');
    define('ADMIN_SCHOOLSLESSONS_CLASS_TEMPLATE_FILE', 'admin_schools_lessons.htm');
    define('ADMIN_SCHOOLSLESSON_CLASS_TEMPLATE_FILE', 'admin_schools_lesson.htm');
    define('ADMIN_SCHOOLSCLASSES_CLASS_TEMPLATE_FILE', 'admin_schools_classes.htm');
    define('ADMIN_SCHOOLSCLASS_CLASS_TEMPLATE_FILE', 'admin_schools_class.htm');
    define('ADMIN_SCHOOLSLEARNERS_CLASS_TEMPLATE_FILE', 'admin_schools_learners.htm');
    define('ADMIN_SCHOOLSLEARNER_CLASS_TEMPLATE_FILE', 'admin_schools_learner.htm');



    // какая страница возврата рекомендуется для модуля страницы товара,
    // какая страница возврата рекомендуется для модуля страницы комплекта товаров,
    // какая страница возврата рекомендуется для модуля страницы стадии заказа,
    // какая страница возврата рекомендуется для модуля страницы кредитной программы,
    // какая страница возврата рекомендуется для модуля страницы способа доставки,
    // какая страница возврата рекомендуется для модуля страницы типа доставки,
    // какая страница возврата рекомендуется для модуля страницы срока отправки,
    // какая страница возврата рекомендуется для модуля страницы валюты,
    // какая страница возврата рекомендуется для модуля страницы способа оплаты,
    // какая страница возврата рекомендуется для модуля страницы пользователя,
    // какая страница возврата рекомендуется для модуля страницы страны,
    // какая страница возврата рекомендуется для модуля страницы области,
    // какая страница возврата рекомендуется для модуля страницы города,
    // какая страница возврата рекомендуется для модуля страницы учебного заведения,
    // какая страница возврата рекомендуется для модуля страницы типа учебного заведения,
    // какая страница возврата рекомендуется для модуля страницы предмета учебного заведения,
    // какая страница возврата рекомендуется для модуля страницы класса учебного заведения,
    // какая страница возврата рекомендуется для модуля страницы учащегося
    define('ADMIN_PRODUCT_CLASS_RESULT_PAGE', 'index.php?section=Products');
    define('ADMIN_PRODUCTSKIT_CLASS_RESULT_PAGE', 'index.php?section=ProductsKits');
    define('ADMIN_ORDERSPHASE_CLASS_RESULT_PAGE', 'index.php?section=OrdersPhases');
    define('ADMIN_CREDITPROGRAM_CLASS_RESULT_PAGE', 'index.php?section=CreditPrograms');
    define('ADMIN_DELIVERY_CLASS_RESULT_PAGE', 'index.php?section=Deliveries');
    define('ADMIN_DELIVERIESTYPE_CLASS_RESULT_PAGE', 'index.php?section=DeliveriesTypes');
    define('ADMIN_SHIPPINGSTERM_CLASS_RESULT_PAGE', 'index.php?section=ShippingsTerms');
    define('ADMIN_CURRENCY_CLASS_RESULT_PAGE', 'index.php?section=Currencies');
    define('ADMIN_PAYMENT_CLASS_RESULT_PAGE', 'index.php?section=Payments');
    define('ADMIN_USER_CLASS_RESULT_PAGE', 'index.php?section=Users');
    define('ADMIN_COUNTRY_CLASS_RESULT_PAGE', 'index.php?section=Countries');
    define('ADMIN_REGION_CLASS_RESULT_PAGE', 'index.php?section=Regions');
    define('ADMIN_TOWN_CLASS_RESULT_PAGE', 'index.php?section=Towns');
    define('ADMIN_SCHOOL_CLASS_RESULT_PAGE', 'index.php?section=Schools');
    define('ADMIN_SCHOOLSTYPE_CLASS_RESULT_PAGE', 'index.php?section=SchoolsTypes');
    define('ADMIN_SCHOOLSLESSON_CLASS_RESULT_PAGE', 'index.php?section=SchoolsLessons');
    define('ADMIN_SCHOOLSCLASS_CLASS_RESULT_PAGE', 'index.php?section=SchoolsClasses');
    define('ADMIN_SCHOOLSLEARNER_CLASS_RESULT_PAGE', 'index.php?section=SchoolsLearners');



    // какая папка содержит изображения для товаров (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для кредитных программ (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для пользователей (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для стран (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для областей (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для городов (папку задаем относительно корневой папки сайта),
    // какая папка содержит изображения для учебных заведений (папку задаем относительно корневой папки сайта)
    define('ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER', 'files/products/');
    define('ADMIN_CREDITPROGRAMS_CLASS_UPLOAD_FOLDER', 'files/orders/');
    define('ADMIN_USERS_CLASS_UPLOAD_FOLDER', 'files/users/');
    define('ADMIN_COUNTRIES_CLASS_UPLOAD_FOLDER', 'files/countries/');
    define('ADMIN_REGIONS_CLASS_UPLOAD_FOLDER', 'files/regions/');
    define('ADMIN_TOWNS_CLASS_UPLOAD_FOLDER', 'files/towns/');
    define('ADMIN_SCHOOLS_CLASS_UPLOAD_FOLDER', 'files/schools/');



    // имя файла водяного знака для товаров,
    // имя файла водяного знака для пользователей,
    // имя файла водяного знака для стран,
    // имя файла водяного знака для областей,
    // имя файла водяного знака для городов,
    // имя файла водяного знака для учебных заведений
    define('PRODUCTS_CLASS_WATERMARK_FILENAME', 'products_watermark.png');
    define('USERS_CLASS_WATERMARK_FILENAME', 'users_watermark.png');
    define('COUNTRIES_CLASS_WATERMARK_FILENAME', 'countries_watermark.png');
    define('REGIONS_CLASS_WATERMARK_FILENAME', 'regions_watermark.png');
    define('SCHOOLS_CLASS_WATERMARK_FILENAME', 'schools_watermark.png');



    // названия динамических параметров
    define('PRODUCTS_SESSION_PARAM_NAME', 'admin_products');
    define('PRODUCTSKITS_SESSION_PARAM_NAME', 'admin_products_kits');
    define('ORDERSPHASES_SESSION_PARAM_NAME', 'admin_orders_phases');
    define('PAYMENTSHISTORY_SESSION_PARAM_NAME', 'admin_payments_history');
    define('CREDITPROGRAMS_SESSION_PARAM_NAME', 'admin_credit_programs');
    define('DELIVERIES_SESSION_PARAM_NAME', 'admin_deliveries');
    define('DELIVERIESTYPES_SESSION_PARAM_NAME', 'admin_deliveries_types');
    define('SHIPPINGSTERMS_SESSION_PARAM_NAME', 'admin_shippings_terms');
    define('CURRENCIES_SESSION_PARAM_NAME', 'admin_currencies');
    define('PAYMENTS_SESSION_PARAM_NAME', 'admin_payments');
    define('USERS_SESSION_PARAM_NAME', 'admin_users');
    define('COUNTRIES_SESSION_PARAM_NAME', 'admin_countries');
    define('REGIONS_SESSION_PARAM_NAME', 'admin_regions');
    define('TOWNS_SESSION_PARAM_NAME', 'admin_towns');
    define('SCHOOLS_SESSION_PARAM_NAME', 'admin_schools');
    define('SCHOOLSTYPES_SESSION_PARAM_NAME', 'admin_schools_types');
    define('SCHOOLSLESSONS_SESSION_PARAM_NAME', 'admin_schools_lessons');
    define('SCHOOLSCLASSES_SESSION_PARAM_NAME', 'admin_schools_classes');
    define('SCHOOLSLEARNERS_SESSION_PARAM_NAME', 'admin_schools_learners');



    return;
?>