<?php
    // =======================================================================
    /**
    *  Админ модуль заказов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем константы модуля
    impera_ConstantsRequire('Orders');

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // TODO: позже заменить подгрузкой базового справочника для отказа от накладного "class N extends Products"
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT);



    // =======================================================================
    /**
    *  Админ модуль заказов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Orders extends Products {

        // с какой таблицей базы данных работаем,
        // какое поле таблицы является идентификатором записей
        public $dbtable = DATABASE_ORDERS_TABLENAME;
        public $dbtable_field = 'order_id';

        // в какую папку выгружать изображения,
        // сколько записей размещать на странице
        public $upload_folder = ADMIN_ORDERS_CLASS_UPLOAD_FOLDER;
        protected $items_per_page = DEFAULT_VALUE_FOR_ORDERS_ON_PAGE_IN_ADMIN;

        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('all_users');



        // обновление записи в базе данных =======================================

        protected function update ( & $item ) {

            // приказываем объекту базы данных обновить/добавить указанную запись
            return $this->db->orders->update($item);
        }



        // очистка соответствующих кеш-таблиц ====================================

        protected function resetCaches () {
        }



        // уведомление участников об изменениях в записи =========================

        protected function inform (&$item,
                                   $inform_user = FALSE, $inform_user_sms = FALSE,
                                   $inform_admin = FALSE, $inform_admin_sms = FALSE,
                                   $testing = FALSE) {

            // если никого не требовали уведомлять
            if (!$inform_user && !$inform_user_sms && !$inform_admin && !$inform_admin_sms) return;



            // читаем данные о заказе из базы данных
            $params = new stdClass;
            $params->id = $item->order_id;
            $this->db->orders->one($order, $params);



            // если данные заказа получены, преобразуем даты в удобо читаемые
            if (!empty($order)) {
                $order->date = $this->date->readableDateTime($order->date);
                if (substr($order->payment_date, 0, 4) != '0000') {
                    $order->payment_date = $this->date->readableDateTime($order->payment_date);
                } else {
                    $order->payment_date = '';
                }
                $order->now = $this->date->readableDateTime();
            }



            // путь к шаблонам клиентской стороны и админпанели
            $client_tpl_path = ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html/';
            $admin_tpl_path = ROOT_FOLDER_REFERENCE . $this->admin_folder . '/design/' . $this->settings->admin_theme . '/html/';



            // тема уведомления пользователю
            $subject = 'Произошли изменения в Вашем заказе №' . (isset($order->order_id) ? $order->order_id : '') . ' на сайте ' . $this->root_url;



            // если требовали уведомить пользователя по емейлу
            if ($inform_user) {

                // если данные заказа получены
                if (!empty($order)) {

                    // уведомляем по емейлу
                    $email = isset($order->email) ? trim($order->email) : '';
                    if ($email == '') $email = isset($order->email2) ? trim($order->email2) : '';
                    if ($email != '') {
                        $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

                        // если не находим шаблон в клиентской части, берем из админпанели
                        $path = $client_tpl_path;
                        $template = EMAIL_ORDER_TO_USER_TEMPLATE_FILE;
                        if (!file_exists($client_tpl_path . $template)) $path = '';

                        // получаем тело письма
                        $path = ($path != '') ? 'file:[client]' : '';
                        $message = $this->smarty->fetch($path . $template);
                        if ($testing) {
                            echo $message;
                            exit;
                        }

                        // если в настройках сайта разрешено прикреплять в письмо квитанцию об оплате
                        $filename = '';
                        if (isset($this->settings->orders_attach_receipt) && ($this->settings->orders_attach_receipt == 1)) {

                            // если это еще не оплаченный заказ
                            if ($order->payment_status != 1) {

                              // читаем список разрешенных способов оплаты по квитанции через банк
                              $query = 'SELECT * '
                                     . 'FROM payment_methods '
                                     . 'WHERE enabled = 1 '
                                           . 'AND module = \'receipt\' '
                                     . 'ORDER BY payment_method_id ASC;';
                              $this->db->query($query);
                              $payment_methods = $this->db->results();

                              // находим нужный способ оплаты
                              foreach ($payment_methods as &$method) {
                                  if ($method->module == 'receipt') {

                                      // курс валюты (прямой)
                                      $rate = $this->any->currency->rate(null, TRUE);

                                      // получаем имя временного файла квитанции
                                      $filename = 'temp/receipt_' . $order->order_id;

                                      // формируем файл квитанции
                                      $prev_POST = $_POST;
                                      $_POST = unserialize($method->params);
                                      // параметр "сохранить квитанцию в файле"
                                      $_POST['output'] = 'file';
                                      $_POST['receipt_filename'] = $filename;
                                      $filename .= '.pdf';
                                      $_POST['order_id'] = $order->order_id;
                                      $_POST['payer_name'] = $order->compound_name;
                                      $_POST['amount'] = round($order->total_amount * $rate, 2);
                                      include(ROOT_FOLDER_REFERENCE . 'connectors/receipt.php');
                                      $_POST = $prev_POST;
                                      break;
                                  }
                                }
                            }
                        }

                        // отправляем письмо
                        $this->email($email, $subject, $message, '', $filename);

                    // иначе в заказе не указан емейл покупателя
                    } else {
                        if ($testing) {
                            echo 'В этом заказе не указан емейл покупателя, поэтому уведомление ему не может быть отправлено!';
                            exit;
                        }
                    }

                    // уведомляем по ICQ
                    $icq = isset($order->icq) ? trim($order->icq) : '';
                    if ($icq == '') $icq = isset($order->icq2) ? trim($order->icq2) : '';
                    if ($icq != '') {
                        $this->send_icq($icq, $subject);
                    }
                }
            }



            // если требовали уведомить пользователя по SMS
            if ($inform_user_sms) {

                // если данные заказа получены
                if (!empty($order)) {

                    // уведомляем по телефону
                    $phone = isset($order->phone) ? trim($order->phone) : '';
                    if ($phone == '') $phone = isset($order->phone2) ? trim($order->phone2) : '';
                    if ($phone != '') {

                        // передаем данные в шаблонизатор
                        $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

                        // если не находим шаблон в клиентской части, берем из админпанели
                        $path = $client_tpl_path;
                        $template = SMS_ORDER_CHANGE_TO_USER_TEMPLATE_FILE;
                        if (!file_exists($client_tpl_path . $template)) {
                            $path = '';
                            if (!file_exists($admin_tpl_path . $template)) $template = '';
                        }

                        // получаем тело SMS
                        if ($template != '') {
                            $path = ($path != '') ? 'file:[client]' : '';
                            $message = $this->smarty->fetch($path . $template);
                        } else {
                            $message = $subject;
                        }

                        // отправляем SMS
                        if ($testing) {
                            echo $message;
                            exit;
                        }
                        $this->send_sms($phone, $message);

                    // иначе в заказе не указан телефон покупателя
                    } else {
                        if ($testing) {
                            echo 'В этом заказе не указан телефон покупателя, поэтому уведомление ему не может быть отправлено!';
                            exit;
                        }
                    }
                }
            }



            // тема уведомления администратору
            $subject = 'Произведены изменения в заказе №' . (isset($order->order_id) ? $order->order_id : '') . ' на сайте ' . $this->root_url;



            // если требовали уведомить администратора по емейлу
            if ($inform_admin) {

                // если данные заказа получены
                if (!empty($order)) {

                    // уведомляем по емейлу
                    $email = isset($this->settings->admin_email) ? trim($this->settings->admin_email) : '';
                    if ($email != '') {
                        $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $order);

                        // если не находим шаблон в клиентской части, берем из админпанели
                        $path = $client_tpl_path;
                        $template = EMAIL_ORDER_TO_ADMIN_TEMPLATE_FILE;
                        if (!file_exists($client_tpl_path . $template)) $path = '';

                        // отправляем письмо
                        $path = ($path != '') ? 'file:[client]' : '';
                        $message = $this->smarty->fetch($path . $template);
                        if ($testing) {
                            echo $message;
                            exit;
                        }
                        $this->email($email, $subject, $message);

                    // иначе в настройках сайта не указан емейл администратора
                    } else {
                        if ($testing) {
                            echo 'В настройках сайта не указан емейл администратора, поэтому уведомление ему не может быть отправлено!';
                            exit;
                        }
                    }

                    // уведомляем по ICQ
                    $icq = isset($this->settings->admin_icq) ? trim($this->settings->admin_icq) : '';
                    if ($icq != '') {
                        $this->send_icq($icq, $subject);
                    }
                }
            }



            // если требовали уведомить администратора по SMS
            if ($inform_admin_sms) {

                // если данные заказа получены
                if (!empty($order)) {

                    // уведомляем по телефону
                    $phone = ADMIN_PHONE_PSEUDONYM;
                    if ($phone != '') {

                        // отправляем SMS
                        if ($testing) {
                            echo $subject;
                            exit;
                        }
                        $this->send_sms($phone, $subject);
                    }
                }
            }
        }



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

            // если в настройках сайта задано свое количество "сколько записей размещать на странице"
            if (isset($this->settings->orders_num_admin) && !empty($this->settings->orders_num_admin)) {
              $this->items_per_page = intval($this->settings->orders_num_admin);
            }
            if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
            if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;



            // задаем значения по умолчанию некоторых элементов html-формы
            $defaults = new stdClass;
            $defaults->param = ORDERS_SESSION_PARAM_NAME;
            $defaults->sort = SORT_ORDERS_MODE_AS_IS;
            $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
            $defaults->sort_laconical = 1;
            $defaults->type = TYPE_ORDERS_COMING;
            $defaults->view_mode = VIEW_MODE_FULL;
            $defaults->filter_manually = 0;



            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды,
            // устанавливаем заголовок страницы
            $this->process_setup();
            $this->process($defaults);
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Заказы';



            // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $this->collect_inputs($inputs, $params, $defaults);



            // читаем список заказов на текущей странице согласно параметрам фильтра и сортировки
            $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            $params->start = $current_page * $this->items_per_page;
            $params->maxcount = $this->items_per_page;
            $count = $this->db->orders->get($items, $params);
            $this->db->orders->unpackRecords($items);



            // создаем контент листания страниц
            if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
            if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
            if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
            if (isset($params->type)) $this->params[REQUEST_PARAM_NAME_TYPE] = $params->type;
            if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
            if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
            if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
            if (isset($params->delivery_id)) $this->params[REQUEST_PARAM_NAME_FILTER_DELIVERY] = $params->delivery_id;
            if (isset($params->payment_id)) $this->params[REQUEST_PARAM_NAME_FILTER_PAYMENT] = $params->payment_id;
            if (isset($params->payment_status)) $this->params[REQUEST_PARAM_NAME_FILTER_PAYSTATUS] = $params->payment_status;
            if (isset($params->creditable)) $this->params[REQUEST_PARAM_NAME_FILTER_CREDITABLE] = $params->creditable;
            if (isset($params->affiliate_id)) $this->params[REQUEST_PARAM_NAME_FILTER_AFFILIATE] = $params->affiliate_id;
            if (isset($params->search)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCH] = $params->search;
            if (isset($params->search_date_from)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM];
            if (isset($params->search_date_to)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO];
            $pages_num = $count / $this->items_per_page;
            $navigator = new PagesNavigation($this);
            $navigator->make($pages_num, $count);



            // добавляем в записи заказов оперативные ссылки админпанели
            $params->token = $this->token;
            $this->db->orders->operable($items, $params);



            // читаем список разрешенных способов доставки
            $params = new stdClass;
            $params->sort = SORT_DELIVERIES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->enabled = 1;
            $this->db->get_deliveries($deliveries, $params);



            // читаем список разрешенных способов оплаты
            $payments = null;
            $params = new stdClass;
            $params->sort = SORT_PAYMENTS_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->enabled = 1;
            $this->db->payments->get($payments, $params);



            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef(SMARTY_VAR_DELIVERIES, $deliveries);
            $this->smarty->assignByRef(SMARTY_VAR_PAYMENTS, $payments);
            $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_ORDERS_CLASS_TEMPLATE_FILE);

            return TRUE;
        }
    }



    return;
?>