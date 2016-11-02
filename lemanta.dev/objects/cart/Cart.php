<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;

    // подложка модуля клиентской стороны
    require_once(dirname(__FILE__) . '/../ClientSubstrate.php');

    // подключаем константы модуля товаров (TODO: исправить на актуальное, когда константы будут разбросаны из свалочного Products по своим модулям)
    impera_ConstantsRequire('Products');

    // подключаем константы модуля заказов
    impera_ConstantsRequire('Orders');

    require_once(dirname(__FILE__) . '/../product/Product.php');

    // какой файл является шаблоном корзины на клиентской стороне (указываем без расширения),
    // какой файл является шаблоном плашки "Товар добавлен в корзину" на клиентской стороне (указываем без расширения),
    // какой файл является шаблоном корзины как самостоятельной страницы на клиентской стороне (указываем без расширения)
    define('CART_CLASS_TEMPLATE_FILE', 'page.cart');
    define('CART_CLASS_QUICK_TEMPLATE_FILE', 'page.quick_cart');
    define('CART_CLASS_INDEPENDENT_TEMPLATE_FILE', 'cart_independent');

    // какой файл является шаблоном успешного принятия заказа на клиентской стороне
    define('ORDER_SUCCESS_TEMPLATE_FILE', 'order_success.tpl');

    define('CHECK_POST_PARAMETERS_FOR_CART', TRUE);
    define('DONT_CHECK_POST_PARAMETERS_FOR_CART', FALSE);

    // команда удаления из корзины
    define('CART_UPDATE_COMMAND_DELETE', FALSE);



    // =======================================================================
    /**
    *  Модуль корзины на клиентской стороне
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientCart extends ClientSubstrate {

        // предполагаем, контент модуля интегрируется во внешнее оформление страницы
        public $single = FALSE;

        // заголовок страницы
        public $title = 'Корзина';

        // основа шифровки пароля
        private $salt = 'imperacms';



        // ===================================================================
        /**
        *  Обработка постинга данных в модуль
        *
        *  @access  protected
        *  @return  boolean     TRUE если обнаружена ошибка
        */
        // ===================================================================

        protected function posting () {

            // запоминаем, для корзины это действие или для отложенных товаров
            $defer = isset($_GET[REQUEST_PARAM_NAME_CART_DEFER]) ? (($_GET[REQUEST_PARAM_NAME_CART_DEFER] == 1) ? 1 : 0)
                                                                 : (isset($_POST[REQUEST_PARAM_NAME_CART_DEFER]) && ($_POST[REQUEST_PARAM_NAME_CART_DEFER] == 1) ? 1 : 0);

            // если действие для корзины и пришли данные о выбранной кредитной программе
            if (!$defer && !empty($_GET[REQUEST_PARAM_NAME_CREDIT_ID])) {
                $_SESSION[CART_CREDIT_PROGRAM_SESSION_PARAM_NAME] = intval($_GET[REQUEST_PARAM_NAME_CREDIT_ID]);
            }

            // если приказано забыть прежнее содержимое корзины
            if (!empty($_POST[REQUEST_PARAM_NAME_CART_RECHANGE])) {

                // зависимо от направления забываем содержимое отложенных товаров или корзины
                if ($defer) {
                    $_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME] = array();
                    $_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = array();
                } else {
                    $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME] = array();
                    $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = array();
                }
            }

            // если указан удаляемый товар
            if ($id = intval($this->param(REQUEST_PARAM_NAME_DELETE_PRODUCT_ID))) {

                // зависимо от направления выбрасываем товар из отложенных или из корзины
                $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, $defer);
            }

            // если указан добавляемый / обновляемый товар, добавляем его в массив
            $id = intval($this->param(REQUEST_PARAM_NAME_VARIANT_ID));
            if (empty($id)) $id = intval($this->param(REQUEST_PARAM_NAME_PRODUCT_ID));
            if (!empty($id)) {
                $amount = intval($this->param(REQUEST_PARAM_NAME_AMOUNT));
                if ($amount == 0) $amount = 1;
                if (!isset($_POST[REQUEST_PARAM_NAME_AMOUNTS])) $_POST[REQUEST_PARAM_NAME_AMOUNTS] = array();
                if (!isset($_POST[REQUEST_PARAM_NAME_PROPERTIES])) $_POST[REQUEST_PARAM_NAME_PROPERTIES] = array();
                $_POST[REQUEST_PARAM_NAME_AMOUNTS][$id] = $amount;
                $_POST[REQUEST_PARAM_NAME_PROPERTIES][$id] = $this->param('props');
            }

            // если поступили товары из конфигуратора
            if (isset($_POST['configurate1']) && isset($_POST['configurate2'])) {
                foreach ($_POST['configurate1'] as $index => $id) {
                    $id = intval($id);
                    if (!empty($id)) {
                        if (isset($_POST['configurate2'][$index])) {
                            $amount = intval($_POST['configurate2'][$index]);
                            if ($amount == 0) $amount = 1;
                            if (!isset($_POST[REQUEST_PARAM_NAME_AMOUNTS])) $_POST[REQUEST_PARAM_NAME_AMOUNTS] = array();
                            if (!isset($_POST[REQUEST_PARAM_NAME_PROPERTIES])) $_POST[REQUEST_PARAM_NAME_PROPERTIES] = array();
                            $_POST[REQUEST_PARAM_NAME_AMOUNTS][$id] = $amount;
                            $_POST[REQUEST_PARAM_NAME_PROPERTIES][$id] = '';
                        }
                    }
                }
            }

            // если имеется массив данных о поступивших товарах
            if (isset($_POST[REQUEST_PARAM_NAME_AMOUNTS])) {

                // перебираем элементы массива
                foreach ($_POST[REQUEST_PARAM_NAME_AMOUNTS] as $id => $amount) {

                    // если точно задан товар и его количество
                    $id = intval(trim($id, '"\' '));
                    if (!empty($id)) {
                        $amount = intval($amount);
                        if ($amount != 0) {

                            // если такой товар существует и он для продажи
                            $product = ClientProduct::get_variant($id, GET_PRODUCT_VARIANT_AS_PRODUCT, GET_PRODUCT_VARIANT_MODE_VARIANT_OR_PRODUCT);
                            if (!empty($product) && !$product->non_usable && $product->enabled) {

                                // если в настройках сайта разрешена продажа под заказ или товар есть в наличии
                                if ($this->settings->cart_enable_reservation || ($product->stock > 0)) {

                                    // корректируем заказанное количество товара
                                    if ($product->stock > 0) {
                                        $amount = abs($amount);
                                        if (($amount > $product->stock) && !$this->settings->orders_deficit_enabled) {
                                            $this->push_error('Товар "' . $this->text->stripTags($product->model, TRUE)
                                                            . '" сейчас отсутствует в количестве ' . $amount . ' шт., поэтому '
                                                            . 'ваше количество было заменено на максимально возможное '
                                                            . 'в настоящий момент - это ' . $product->stock . ' шт.');
                                            $amount = min($product->stock, $amount);
                                        }
                                    } else {

                                        // в продаже под заказ количество делаем отрицательным
                                        if ($amount > 0) $amount = -$amount;
                                    }

                                    // добавляем товар в корзину или отложенные товары зависимо от направления
                                    $properties = isset($_POST[REQUEST_PARAM_NAME_PROPERTIES][$id]) ? trim($_POST[REQUEST_PARAM_NAME_PROPERTIES][$id]) : '';
                                    $this->update($id, $amount, $properties, FALSE, $defer);

                                    // удаляем такой товар из противоположного направления (корзины или отложенных товаров)
                                    $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, !$defer);

                                // иначе удаляем данные из корзины или из отложенных товаров зависимо от направления
                                } else {
                                    $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, $defer);

                                    $this->push_error('Товара "' . $this->text->stripTags($product->model, TRUE)
                                                    . '" нет в наличии, а в настройках сайта запрещена '
                                                    . 'продажа под заказ, поэтому добавление этого товара '
                                                    . 'в корзину невозможно.');
                                }

                            // иначе удаляем данные из корзины и отложенных товаров
                            } else {
                                $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, TRUE);
                                $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, FALSE);

                                if (isset($product->enabled) && !$product->enabled) {
                                    $this->push_error('Товара "' . $this->text->stripTags($product->model, TRUE)
                                                    . '" уже нет в базе магазина.');
                                } elseif (isset($product->non_usable) && $product->non_usable) {
                                    $this->push_error('Товар "' . $this->text->stripTags($product->model, TRUE)
                                                    . '" имеет пометку "не для продажи", поэтому '
                                                    . 'его добавление в корзину невозможно.');
                                }
                            }

                        // иначе удаляем данные из корзины и отложенных товаров
                        } else {
                            $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, TRUE);
                            $this->update($id, CART_UPDATE_COMMAND_DELETE, '', FALSE, FALSE);
                        }
                    }
                }
            }

            // запоминаем в браузере пользователя список отложенных товаров и товаров корзины
            $this->send_cart_cookie();
            $this->send_defer_cookie();
        }



        // запоминание списка товаров корзины в браузере пользователя ============

        private function send_cart_cookie () {

            // если поддерживается функция передачи cookie
            if (function_exists('setcookie')) {
                $time = time();
                $year_lifetime = 365 * 24 * SECONDS_IN_HOUR;

                // удаляем старые cookie
                if (isset($_COOKIE[CART_PRODUCTS_SESSION_PARAM_NAME])) {
                    if (is_array($_COOKIE[CART_PRODUCTS_SESSION_PARAM_NAME])) {
                        foreach ($_COOKIE[CART_PRODUCTS_SESSION_PARAM_NAME] as $key => $item) {
                            setcookie(CART_PRODUCTS_SESSION_PARAM_NAME . '[' . $key . ']', '', $time - $year_lifetime, '/');
                        }
                    } else {
                        setcookie(CART_PRODUCTS_SESSION_PARAM_NAME, '', $time - $year_lifetime, '/');
                    }
                }
                if (isset($_COOKIE[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                    if (is_array($_COOKIE[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                        foreach ($_COOKIE[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] as $key => $item) {
                            setcookie(CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME . '[' . $key . ']', '', $time - $year_lifetime, '/');
                        }
                    } else {
                        setcookie(CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME, '', $time - $year_lifetime, '/');
                    }
                }

                // добавляем новые cookie
                if (isset($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME]) && is_array($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME])) {
                    foreach ($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME] as $key => $item) {
                        setcookie(CART_PRODUCTS_SESSION_PARAM_NAME . '[' . $key . ']', $item, $time + $year_lifetime, '/');
                    }
                    if (isset($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME]) && is_array($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                        foreach ($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] as $key => $item) {
                            setcookie(CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME . '[' . $key . ']', $item, $time + $year_lifetime, '/');
                        }
                    }
                }
            }
        }



        // запоминание списка отложенных товаров в браузере пользователя =========

        private function send_defer_cookie () {

            // если поддерживается функция передачи cookie
            if (function_exists('setcookie')) {
                $time = time();
                $year_lifetime = 365 * 24 * SECONDS_IN_HOUR;

                // удаляем старые cookie
                if (isset($_COOKIE[DEFER_PRODUCTS_SESSION_PARAM_NAME])) {
                    if (is_array($_COOKIE[DEFER_PRODUCTS_SESSION_PARAM_NAME])) {
                        foreach ($_COOKIE[DEFER_PRODUCTS_SESSION_PARAM_NAME] as $key => $item) {
                            setcookie(DEFER_PRODUCTS_SESSION_PARAM_NAME . '[' . $key . ']', '', $time - $year_lifetime, '/');
                        }
                    } else {
                        setcookie(DEFER_PRODUCTS_SESSION_PARAM_NAME, '', $time - $year_lifetime, '/');
                    }
                }
                if (isset($_COOKIE[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                    if (is_array($_COOKIE[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                        foreach ($_COOKIE[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] as $key => $item) {
                            setcookie(DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME . '[' . $key . ']', '', $time - $year_lifetime, '/');
                        }
                    } else {
                        setcookie(DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME, '', $time - $year_lifetime, '/');
                    }
                }

                // добавляем новые cookie
                if (isset($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME]) && is_array($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME])) {
                    foreach ($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME] as $key => $item) {
                        setcookie(DEFER_PRODUCTS_SESSION_PARAM_NAME . '[' . $key . ']', $item, $time + $year_lifetime, '/');
                    }
                    if (isset($_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME]) && is_array($_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                        foreach ($_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] as $key => $item) {
                            setcookie(DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME . '[' . $key . ']', $item, $time + $year_lifetime, '/');
                        }
                    }
                }
            }
        }



        // обновление сведений корзины ===========================================

        private function update ( $id, $amount, $props = '', $add = FALSE, $defer ) {

            // зависимо от направления ссылаем переменные на сеансовые переменные корзины или отложенных товаров
            $products = null;
            $properties = null;
            if ($defer) {
                if (!isset($_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME])) $_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME] = array();
                if (!isset($_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) $_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = array();
                $products = & $_SESSION[DEFER_PRODUCTS_SESSION_PARAM_NAME];
                $properties = & $_SESSION[DEFER_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME];
            } else {
                if (!isset($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME])) $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME] = array();
                if (!isset($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = array();
                $products = & $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME];
                $properties = & $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME];
            }

            // если вместо количества передана команда Удалить
            if ($amount === CART_UPDATE_COMMAND_DELETE) {
                if (isset($products[$id])) unset($products[$id]);
                if (isset($properties[$id])) unset($properties[$id]);

            // иначе передано количество товара
            } else {

                // если приказано приплюсовать количество
                if ($add) {
                    if (!isset($products[$id]) || !is_numeric($products[$id])) $products[$id] = 0;
                    $products[$id] += intval($amount);

                // иначе приказано заместить количество
                } else {
                    $products[$id] = intval($amount);
                }

                // передаем описание свойств товара
                $properties[$id] = $props;
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

            // обрабатываем постинг данных
            $this->posting();

            // если была нажата кнопка "Сделать заказ"
            if (!empty($_POST[REQUEST_PARAM_NAME_SUBMIT_ORDER])) {

                // сохраняем заказ (в параметрах передаем, какие поля обязательны
                // согласно настройкам сайта для быстрого заказа / корзины)
                $params = new stdClass;
                $params->captcha_protecting = $this->settings->cart_captcha_protecting;
                $params->show_name = $this->settings->quickorder_show_name
                                     || $this->settings->quickorder_show_name2
                                     || $this->settings->quickorder_show_name3;
                $params->show_contacts = $this->settings->quickorder_show_email
                                         || $this->settings->quickorder_show_email2
                                         || $this->settings->quickorder_show_phone
                                         || $this->settings->quickorder_show_phone2;
                $params->show_address = $this->settings->quickorder_show_address
                                        || $this->settings->quickorder_show_address_2
                                        || $this->settings->quickorder_show_address_3
                                        || $this->settings->quickorder_show_address_4
                                        || $this->settings->quickorder_show_address_5
                                        || $this->settings->quickorder_show_address_9
                                        || $this->settings->quickorder_show_address_10
                                        || $this->settings->quickorder_show_address2
                                        || $this->settings->quickorder_show_address2_2
                                        || $this->settings->quickorder_show_address2_3
                                        || $this->settings->quickorder_show_address2_4
                                        || $this->settings->quickorder_show_address2_5
                                        || $this->settings->quickorder_show_address2_9
                                        || $this->settings->quickorder_show_address2_10;
                $this->save_order($params);

            // иначе это показ корзины
            } else {

                // если включена авто регистрация и нет авторизованного пользователя
                // TODO: убрать обращение к настройкам через request, когда корзина будет порождена от BasicMODModel
                if ($this->request->settings->get('cart_auto_registration')
                && empty($this->user->user_id)
                && ($msg = $this->request->settings->get('cart_auto_registration_msg', '')) != '') {

                    // готовим подсказку для пользователя
                    $this->push_info($msg);
                }

                // показываем корзину
                $this->show_cart();
            }

            // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
            return TRUE;
        }



        function pass_data_for_cart_template ( $check_POST = CHECK_POST_PARAMETERS_FOR_CART, $total_price, $products = null ) {

            $product_category_ids = array();
            if (isset($this->settings->delivery_conflict_method)
            && ($this->settings->delivery_conflict_method == DELIVERY_CONFLICT_MODE_DISABLED_FOR_ALL
            || $this->settings->delivery_conflict_method == DELIVERY_CONFLICT_MODE_DISABLED_FOR_ANY)) {
                if (!empty($products)) {
                    foreach ($products as $product) {
                        if (isset($product->category_id)) {
                            $category_id = @ intval($product->category_id);
                            $product_category_ids[$category_id] = $category_id;
                        }
                    }
                }
            }



            $sort_method = '`order_num` DESC ';
            if (isset($this->settings->delivery_sort_method)) {
                switch ($this->settings->delivery_sort_method) {
                    case DELIVERY_SORT_MODE_BY_NAME:
                        $sort_method = '`name` ASC ';
                        break;
                    case DELIVERY_SORT_MODE_BY_PRICE:
                        $sort_method = '`price` ASC ';
                        break;
                    case DELIVERY_SORT_MODE_AS_IS:
                    default:
                        $sort_method = '`order_num` DESC ';
                }
            }
            $query = 'SELECT * '
                   . 'FROM `delivery_methods` '
                   . 'WHERE `enabled` = 1 '
                   . 'ORDER BY ' . $sort_method . ';';
            $this->db->query($query);
            $delivery_methods = $this->db->results();



            if (!empty($delivery_methods)) {
                foreach ($delivery_methods as $k => $method) {
                    $cancel = FALSE;
                    if (!empty($product_category_ids)) {
                        if (isset($method->undelivery_category_ids) && trim($method->undelivery_category_ids) != '') {
                            $method->undelivery_category_ids = explode(',', trim($method->undelivery_category_ids));
                            $ids = array();
                            foreach ($method->undelivery_category_ids as $id) {
                                $id = @ intval($id);
                                $ids[$id] = $id;
                            }
                            foreach ($product_category_ids as $id) {
                                if (isset($ids[$id])) {
                                    if ($this->settings->delivery_conflict_method == DELIVERY_CONFLICT_MODE_DISABLED_FOR_ANY) {
                                        $cancel = TRUE;
                                        break;
                                    } else {
                                        if ($this->settings->delivery_conflict_method == DELIVERY_CONFLICT_MODE_DISABLED_FOR_ALL) $cancel = TRUE;
                                    }
                                } else {
                                    if ($this->settings->delivery_conflict_method == DELIVERY_CONFLICT_MODE_DISABLED_FOR_ALL) {
                                        $cancel = FALSE;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if (!$cancel) {
                        $delivery_methods[$k]->final_price = $method->price;
                        if ($method->free_from <= $total_price) $delivery_methods[$k]->final_price = 0;
                    } else {
                        unset($delivery_methods[$k]);
                    }
                }
                $delivery_methods = array_values($delivery_methods);
            }
            $this->smarty->assign('delivery_methods', $delivery_methods);



            $time = '';
            $date = '';
            if ($check_POST === CHECK_POST_PARAMETERS_FOR_CART && (isset($_POST[REQUEST_PARAM_NAME_CART_RECHANGE]) || isset($_POST[REQUEST_PARAM_NAME_SUBMIT_ORDER]))) {
                $this->smarty->assign('name', isset($_POST['name']) ? trim($_POST['name']) : '');
                $this->smarty->assign('name2', isset($_POST['name2']) ? trim($_POST['name2']) : '');
                $this->smarty->assign('name3', isset($_POST['name3']) ? trim($_POST['name3']) : '');
                $this->smarty->assign('email', isset($_POST['email']) ? trim($_POST['email']) : '');
                $this->smarty->assign('email2', isset($_POST['email2']) ? trim($_POST['email2']) : '');
                $this->smarty->assign('phone', isset($_POST['phone']) ? trim($_POST['phone']) : '');
                $this->smarty->assign('phone2', isset($_POST['phone2']) ? trim($_POST['phone2']) : '');
                $this->smarty->assign('address', isset($_POST['address']) ? trim($_POST['address']) : '');
                $this->smarty->assign('address_2', isset($_POST['address_2']) ? trim($_POST['address_2']) : '');
                $this->smarty->assign('address_3', isset($_POST['address_3']) ? trim($_POST['address_3']) : '');
                $this->smarty->assign('address_4', isset($_POST['address_4']) ? trim($_POST['address_4']) : '');
                $this->smarty->assign('address_5', isset($_POST['address_5']) ? trim($_POST['address_5']) : '');
                $this->smarty->assign('address_6', isset($_POST['address_6']) ? trim($_POST['address_6']) : '');
                $this->smarty->assign('address_7', isset($_POST['address_7']) ? trim($_POST['address_7']) : '');
                $this->smarty->assign('address_8', isset($_POST['address_8']) ? trim($_POST['address_8']) : '');
                $this->smarty->assign('address_9', isset($_POST['address_9']) ? trim($_POST['address_9']) : '');
                $this->smarty->assign('address_10', isset($_POST['address_10']) ? trim($_POST['address_10']) : '');
                $this->smarty->assign('address2', isset($_POST['address2']) ? trim($_POST['address2']) : '');
                $this->smarty->assign('address2_2', isset($_POST['address2_2']) ? trim($_POST['address2_2']) : '');
                $this->smarty->assign('address2_3', isset($_POST['address2_3']) ? trim($_POST['address2_3']) : '');
                $this->smarty->assign('address2_4', isset($_POST['address2_4']) ? trim($_POST['address2_4']) : '');
                $this->smarty->assign('address2_5', isset($_POST['address2_5']) ? trim($_POST['address2_5']) : '');
                $this->smarty->assign('address2_6', isset($_POST['address2_6']) ? trim($_POST['address2_6']) : '');
                $this->smarty->assign('address2_7', isset($_POST['address2_7']) ? trim($_POST['address2_7']) : '');
                $this->smarty->assign('address2_8', isset($_POST['address2_8']) ? trim($_POST['address2_8']) : '');
                $this->smarty->assign('address2_9', isset($_POST['address2_9']) ? trim($_POST['address2_9']) : '');
                $this->smarty->assign('address2_10', isset($_POST['address2_10']) ? trim($_POST['address2_10']) : '');
                $date = isset($_POST['to_date']) ? trim($_POST['to_date']) : '';
                $time = isset($_POST['to_time']) ? trim($_POST['to_time']) : '';
                $this->smarty->assign('date', $date);
                $this->smarty->assign('time', $time);
                $this->smarty->assign('comment', isset($_POST['comment']) ? trim($_POST['comment']) : '');
                $this->smarty->assign('delivery_method_id', isset($_POST['delivery_method_id']) ? trim($_POST['delivery_method_id']) : '');
                $this->smarty->assign('payment_method_id', isset($_POST['payment_method_id']) ? trim($_POST['payment_method_id']) : '');
            } else {



                // если есть авторизованный пользователь, берем в корзину его реквизиты
                if (!empty($this->user)) {
                    $this->db->orders->unpackUserName($this->user);
                    $this->smarty->assign('name', $this->user->name);
                    $this->smarty->assign('name2', $this->user->name2);
                    $this->smarty->assign('name3', $this->user->name3);
                    $this->smarty->assign('email', isset($this->user->email) ? trim($this->user->email) : '');
                    $this->smarty->assign('email2', isset($this->user->email2) ? trim($this->user->email2) : '');
                    $this->smarty->assign('phone', isset($this->user->phone) ? trim($this->user->phone) : '');
                    $this->smarty->assign('phone2', isset($this->user->phone2) ? trim($this->user->phone2) : '');
                    $this->db->orders->unpackUserAddress($this->user);
                    $this->smarty->assign('address', $this->user->address);
                    $this->smarty->assign('address_2', $this->user->address_2);
                    $this->smarty->assign('address_3', $this->user->address_3);
                    $this->smarty->assign('address_4', $this->user->address_4);
                    $this->smarty->assign('address_5', $this->user->address_5);
                    $this->smarty->assign('address_6', $this->user->address_6);
                    $this->smarty->assign('address_7', $this->user->address_7);
                    $this->smarty->assign('address_8', $this->user->address_8);
                    $this->smarty->assign('address_9', $this->user->address_9);
                    $this->smarty->assign('address_10', $this->user->address_10);
                    $this->db->orders->unpackUserAddress($this->user, '2');
                    $this->smarty->assign('address2', $this->user->address2);
                    $this->smarty->assign('address2_2', $this->user->address2_2);
                    $this->smarty->assign('address2_3', $this->user->address2_3);
                    $this->smarty->assign('address2_4', $this->user->address2_4);
                    $this->smarty->assign('address2_5', $this->user->address2_5);
                    $this->smarty->assign('address2_6', $this->user->address2_6);
                    $this->smarty->assign('address2_7', $this->user->address2_7);
                    $this->smarty->assign('address2_8', $this->user->address2_8);
                    $this->smarty->assign('address2_9', $this->user->address2_9);
                    $this->smarty->assign('address2_10', $this->user->address2_10);



                    // если не указан телефон или адрес, пробуем взять из последнего заказа пользователя
                    if (trim($this->user->phone) == '' && trim($this->user->phone2) == ''
                    || $this->db->orders->compoundUserAddress($this->user) == '' && $this->db->orders->compoundUserAddress($this->user, '2') == '') {
                        $query = 'SELECT * '
                               . 'FROM `' . DATABASE_ORDERS_TABLENAME . '` '
                               . 'WHERE `user_id` = \'' . $this->db->query_value($this->user->user_id) . '\' '
                               . 'ORDER BY `order_id` DESC '
                               . 'LIMIT 1;';
                        $this->db->query($query);
                        $last_order = $this->db->result();
                        if (trim($this->user->phone) == '' && trim($this->user->phone2) == '') {
                            $this->smarty->assign('phone', isset($last_order->phone) ? trim($last_order->phone) : '');
                            $this->smarty->assign('phone2', isset($last_order->phone2) ? trim($last_order->phone2) : '');
                        }
                        if ($this->db->orders->compoundUserAddress($this->user) == '' && $this->db->orders->compoundUserAddress($this->user, '2') == '') {
                            $this->db->orders->unpackUserAddress($last_order);
                            $this->smarty->assign('address', $last_order->address);
                            $this->smarty->assign('address_2', $last_order->address_2);
                            $this->smarty->assign('address_3', $last_order->address_3);
                            $this->smarty->assign('address_4', $last_order->address_4);
                            $this->smarty->assign('address_5', $last_order->address_5);
                            $this->smarty->assign('address_6', $last_order->address_6);
                            $this->smarty->assign('address_7', $last_order->address_7);
                            $this->smarty->assign('address_8', $last_order->address_8);
                            $this->smarty->assign('address_9', $last_order->address_9);
                            $this->smarty->assign('address_10', $last_order->address_10);
                            $this->db->orders->unpackUserAddress($last_order, '2');
                            $this->smarty->assign('address2', $last_order->address2);
                            $this->smarty->assign('address2_2', $last_order->address2_2);
                            $this->smarty->assign('address2_3', $last_order->address2_3);
                            $this->smarty->assign('address2_4', $last_order->address2_4);
                            $this->smarty->assign('address2_5', $last_order->address2_5);
                            $this->smarty->assign('address2_6', $last_order->address2_6);
                            $this->smarty->assign('address2_7', $last_order->address2_7);
                            $this->smarty->assign('address2_8', $last_order->address2_8);
                            $this->smarty->assign('address2_9', $last_order->address2_9);
                            $this->smarty->assign('address2_10', $last_order->address2_10);
                        }
                    }

                    // предпочтения (желаемые дату и время) тоже берем из последнего заказа
                    $date = isset($last_order->to_date) ? trim($last_order->to_date) : '';
                    $time = isset($last_order->to_time) ? trim($last_order->to_time) : '';
                    $this->smarty->assign('date', $date);
                    $this->smarty->assign('time', $time);
                }
            }



            $times = array();
            $dates = array();
            if (!$this->settings->quickorder_to_time_editable) {
                $times[] = array();
                $times[0]['value'] = 'на ваше усмотрение';
                $times[0]['checked'] = '';
                $index = 0;
                while ($index < 24) {
                    if ($index < 10) {
                        $string = 'после 0' . $index . ':00';
                    } else {
                        $string = 'после ' . $index . ':00';
                    }
                    $index = $index + 1;
                    $times[] = array();
                    $times[$index]['value'] = $string;
                    $times[$index]['checked'] = $string === $time ? '1' : '';
                }
            }
            if (!$this->settings->quickorder_to_date_editable) {
                $monthes = array(1 => ' января ', 2 => ' февраля ', 3 => ' марта ', 4 => ' апреля ', 5 => ' мая ', 6 => ' июня ', 7 => ' июля ', 8 => ' августа ', 9 => ' сентября ', 10 => ' октября ', 11 => ' ноября ', 12 => ' декабря ');
                $time = time();
                $dates[] = array();
                $dates[0]['value'] = 'на ваше усмотрение';
                $dates[0]['checked'] = '';
                $index = 0;
                while ($index < 31) {
                    $string = 'к ' . date('j', $time) . $monthes[date('n', $time)] . date('Y', $time);
                    $index = $index + 1;
                    $dates[] = array();
                    $dates[$index]['value'] = $string;
                    $dates[$index]['checked'] = $string === $date ? '1' : '';
                    $time = $time + 24 * 3600;
                }
            }
            $this->smarty->assign('times', $times);
            $this->smarty->assign('dates', $dates);
        }



        // отображение корзины ===================================================

        private function show_cart () {

            // вычисляем состояние отложенных товаров, при этом установятся переменные:
            //   $defer_count = число отложенных товаров
            //   $defer_total = сумма отложенных товаров
            //   $defer_products = список записей об отложенных товарах
            $this->compute_defer_state($defer_count, $defer_total, $defer_products);

            // вычисляем состояние корзины, при этом установятся переменные:
            //   $count = число товаров в корзине
            //   $total = сумма товаров корзины
            //   $discount = сумма скидки
            //   $products = список записей о товарах корзины
            $this->compute_cart_state($count, $total, $discount, $products);

            // получаем html-контент микро информации о корзине
            $info = $this->get_cart_microinfo_content($count, $total, $discount, $defer_count);

            // передаем в шаблонизатор данные для корзины
            $this->pass_data_for_cart_template(CHECK_POST_PARAMETERS_FOR_CART, $total, $products);
            $this->smarty->assignByRef('defer_total_price', $defer_total);
            $this->smarty->assignByRef('defer_products_num', $defer_count);
            $this->smarty->assignByRef('defer_products', $defer_products);
            $this->smarty->assignByRef('cart_total_price', $total);
            $this->smarty->assignByRef('cart_total_discount_sum', $discount);
            $this->smarty->assignByRef('cart_products_num', $count);
            $this->smarty->assignByRef('cart_products', $products);
            $this->smarty->assignByRef('cart_microinfo', $info);

            // определяем, какой шаблон корзины использовать
            $template = CART_CLASS_TEMPLATE_FILE;
            if ($this->quick_content) {
                if (isset($this->settings->cart_open_method) && ($this->settings->cart_open_method == CART_OPEN_METHOD_BAROVERPAGE)) {
                    $name = CART_CLASS_QUICK_TEMPLATE_FILE;
                    if (file_exists('design/' . $this->dynamic_theme . '/html/' . $name . '.tpl')) $template = $name;
                }
            } else {

                // если есть шаблон "корзина как самостоятельная страница", используем его
                $name = CART_CLASS_INDEPENDENT_TEMPLATE_FILE;
                if (file_exists('design/' . $this->dynamic_theme . '/html/' . $name . '.tpl')) {
                    $template = $name;

                    // отменяем отрисовку внешнего оформления страницы (оно уже есть в таком шаблоне)
                    $this->single = TRUE;
                }
            }

            // читаем список типов доставки
            $params = new stdClass;
            $params->sort = SORT_DELIVERIESTYPES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $this->db->get_deliveries_types($deliveries_types, $params);

            // читаем список разрешенных способов оплаты
            $payments = null;
            $params = new stdClass;
            $params->sort = SORT_PAYMENTS_MODE_AS_IS;
            $params->enabled = 1;
            $this->db->payments->get($payments, $params);

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_DELIVERIES_TYPES, $deliveries_types);
            $this->smarty->assignByRef(SMARTY_VAR_PAYMENT_METHODS, $payments);
            $this->smarty->assignByRef(SMARTY_VAR_PAYMENTS, $payments);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->fetchByTemplate($this, $template, 'cart');
        }



        // =======================================================================
        // Сохранить в базе данных заказ с обработкой согласно указанным параметрам (опциональные взяты в квадратные скобки):
        //   [$params->captcha_protecting] = булевой признак "проверить защитный код"
        //   [$params->show_name] = булевой признак "фамилия, или имя, или отчество обязательно к заполнению"
        //   [$params->show_contacts] = булевой признак "емейл или телефон обязателен к заполнению"
        //   [$params->show_address] = булевой признак "страна, или область, или город, или улица, или дом, или квартира, или индекс адреса доставки обязательно к заполнению"
        //   [$params->non_cart_operation] = булевой признак "операция не из корзины / быстрого заказа (не рисовать их контент, не уничтожать их переменные)"
        //   [$params->pointers] = массив указателей (идентификатор, выбранные свойства) покупаемых товаров (если задан, будет использован вместо хранящегося в сеансе для корзины)
        //   [$item] = запись заказа будет помещена в эту переменную
        //
        // Введенные покупателем данные в html-форму (все данные опциональные):
        //   $_POST['captcha'] = защитный код
        //   $_POST['name'] = фамилия
        //   $_POST['name2'] = отчество
        //   $_POST['name3'] = имя
        //   $_POST['email'] = емейл
        //   $_POST['email2'] = емейл 2 (дополнительный)
        //   $_POST['phone'] = телефон
        //   $_POST['phone2'] = телефон 2 (дополнительный)
        //   $_POST['icq'] = номер ICQ
        //   $_POST['icq2'] = номер ICQ 2 (дополнительный)
        //   $_POST['skype'] = Skype имя
        //   $_POST['skype2'] = Skype имя 2 (дополнительное)
        //   $_POST['country_id'] = идентификатор страны, выбранной из списка
        //   $_POST['region_id'] = идентификатор области, выбранной из списка
        //   $_POST['town_id'] = идентификатор города, выбранного из списка
        //   $_POST['address'] = адрес доставки - страна
        //   $_POST['address_2'] = адрес доставки - область
        //   $_POST['address_3'] = адрес доставки - город
        //   $_POST['address_4'] = адрес доставки - улица
        //   $_POST['address_5'] = адрес доставки - дом
        //   $_POST['address_6'] = адрес доставки - корпус
        //   $_POST['address_7'] = адрес доставки - подъезд
        //   $_POST['address_8'] = адрес доставки - код на двери подъезда
        //   $_POST['address_9'] = адрес доставки - квартира
        //   $_POST['address_10'] = адрес доставки - почтовый индекс
        //   $_POST['address2'] = адрес доставки 2 (дополнительный) - страна
        //   $_POST['address2_2'] = адрес доставки 2 (дополнительный) - область
        //   $_POST['address2_3'] = адрес доставки 2 (дополнительный) - город
        //   $_POST['address2_4'] = адрес доставки 2 (дополнительный) - улица
        //   $_POST['address2_5'] = адрес доставки 2 (дополнительный) - дом
        //   $_POST['address2_6'] = адрес доставки 2 (дополнительный) - корпус
        //   $_POST['address2_7'] = адрес доставки 2 (дополнительный) - подъезд
        //   $_POST['address2_8'] = адрес доставки 2 (дополнительный) - код на двери подъезда
        //   $_POST['address2_9'] = адрес доставки 2 (дополнительный) - квартира
        //   $_POST['address2_10'] = адрес доставки 2 (дополнительный) - почтовый индекс
        //   $_POST['delivery_method_id'] = идентификатор выбранного способа доставки
        //   $_POST['to_date'] = пожелание даты доставки
        //   $_POST['to_time'] = пожелание времени доставки
        //   $_POST['comment'] = комментарий к заказу
        //   $_POST['delivery_type'] = выбранный тип комплектации заказа
        //   $_POST['desire_payment_id'] = идентификатор желаемого способа оплаты
        //   $_POST['payment_method_id'] = идентификатор способа оплаты (если не указан желаемый способ оплаты)
        //   $_POST['hidden'] = булевой признак "хочет скрыть страницу заказа от чужих" (игнорируется для неавторизованных)
        //   $_POST['credit_fields'] = массив сведений о получателе кредита
        //   $_POST['coupon'] = код скидочного купона
        //
        // Другие используемые вспомогательные переменные и объекты:
        //   $this = ссылка на текущий объект (модуль)
        //   $this->smarty = ссылка на объект шаблонизатора
        //   $this->db = ссылка на объект базы данных
        //   $this->user = запись о текущем авторизованном пользователе
        //   $this->affiliate_id = идентификатор реферала (какому пользователю делать комиссионные отчисления с заказа)
        //   $this->settings->affiliates_commission_full = настройка сайта "делать комиссию и с цены доставки тоже"
        //   $this->gd_loaded = булевой признак "графическая библиотека подключена" (актуально для защитного кода)
        //   $this->root_url = безпротокольный (то есть без http://) адрес корня сайта
        //   $this->quick_content = булевой признак "модуль отрисовывается без внешнего оформления страницы"
        //   $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME] = массив идентификаторов товаров в козине
        //   $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = массив выбранных свойств товаров в корзине
        //
        // Изменяемые вспомогательные переменные (при операциях из корзины / быстрого заказа):
        //   $this->title = заголовок страницы (устанавливается в случае успеха)
        //   $this->body = контент страницы (устанавливается в случае успеха)
        //   $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME] = массив идентификаторов товаров в козине (уничтожается в случае успеха)
        //   $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = массив выбранных свойств товаров в корзине (уничтожается в случае успеха)
        //   $_SESSION['order_code'] = код сохраненного заказа (устанавливается в случае успеха)
        //
        // Изменяемые вспомогательные переменные (в любых операциях):
        //   $this->error_msg = описание ошибок
        // =======================================================================

        public function save_order ( $params = null, & $item = null ) {

            // пока ошибок нет
            $this->error_msg = '';
            $item = null;



            // путь к шаблону клиентской стороны
            $client_tpl_path = 'design/' . $this->dynamic_theme . '/html/';



            // если в параметрах не задан список покупаемых товаров, ссылаем его на хранящийся в сеансе
            if (!isset($params->pointers) && isset($_SESSION)) {
                $params->pointers = array();
                if (isset($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME])) {
                    $params->pointers[CART_PRODUCTS_SESSION_PARAM_NAME] = & $_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME];
                }
                if (isset($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) {
                    $params->pointers[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME] = & $_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME];
                }
            }



            // если в списке товаров нет данных о товарах, отображаем сообщение об ошибке
            if (!isset($params->pointers[CART_PRODUCTS_SESSION_PARAM_NAME]) || !is_array($params->pointers[CART_PRODUCTS_SESSION_PARAM_NAME])) {
                $this->push_error('В этом заказе отсутствует информация о товарах.');
                if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {
                    $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
                    $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
                    $this->show_cart();
                }
                return;
            }



            // проверяем наличие папки (создавая и защищая в случае отсутствия)
            $folder = $this->smart_create_folder(ROOT_FOLDER_REFERENCE . $this->settings->products_files_folder_prefix . ADMIN_CREDITPROGRAMS_CLASS_UPLOAD_FOLDER,
                                                 FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_ANY_NONEXECUTED,
                                                 0777,
                                                 TRUE);



            // берем сведения о получателе кредита (с передачей отобранного в шаблонизатор)
            $credit_fields = isset($_POST[REQUEST_PARAM_NAME_CREDIT_FIELDS]) && is_array($_POST[REQUEST_PARAM_NAME_CREDIT_FIELDS]) ? $_POST[REQUEST_PARAM_NAME_CREDIT_FIELDS] : array();
            $credit_uniqid = md5(uniqid(rand(), TRUE)) . '-';
            $credit_renames = array();
            if (!is_object($item)) $item = new stdClass;
            $item->credit_id = 0;
            if (!empty($credit_fields)) {
                foreach ($credit_fields as $id => & $data) {
                    $id = intval($id);
                    if (!empty($id) && !empty($data) && is_array($data)) {
                        $item->credit_details = array();
                        $iteration = 1;
                        foreach ($data as $field_id => & $field) {
                            if (isset($field['label'])) {
                                $row = array();
                                $row['label'] = $this->text->stripTags($field['label'], TRUE);
                                if (isset($field['type'])) {
                                    $row['type'] = intval($field['type']);
                                }
                                if (isset($field['required'])) {
                                    $row['required'] = ($field['required'] == 1) ? 1 : 0;
                                }
                                if (isset($field['value'])
                                || isset($row['type']) && ($row['type'] == FIELDTYPE_CREDITPROGRAMS_FILE)) {
                                    if (isset($field['value'])) $row['value'] = $this->text->stripTags($field['value'], TRUE);

                                    // если это файл, принимаем его
                                    if (isset($row['type']) && ($row['type'] == FIELDTYPE_CREDITPROGRAMS_FILE)) {
                                        $file = $credit_uniqid . $id . '-' . $field_id . '-[n][e]';
                                        $selector = new stdClass;
                                        $selector->name = REQUEST_PARAM_NAME_CREDIT_FIELDS;
                                        $selector->item_id = $id;
                                        $selector->field_id = $field_id;
                                        $selector->index = 'value';
                                        $selector->required = isset($row['required']) && $row['required'];
                                        $error = $this->receive_download($selector,
                                                                         $folder,
                                                                         $file,
                                                                         array('jpg', 'jpeg'));

                                        // если файл принят успешно, запоминаем в списке необходимых к переименованию
                                        if (($error == '') && ($file != '')) {
                                            $row['value'] = $file;
                                            $credit_renames[] = $file;

                                        // иначе если была ошибка
                                        } elseif ($error != '') {
                                            $this->push_error($error);
                                        }
                                    }

                                    if (isset($row['value'])) $item->credit_id = $id;
                                }
                                $item->credit_details[$iteration] = $row;
                            }
                            $iteration++;
                        }
                        if (!empty($item->credit_details)) break;
                    }
                }
            }
            if (empty($item->credit_id)) {
                $item->credit_details = '';
            } else {
                $credit_details = array($item->credit_id => & $item->credit_details);
                $this->smarty->assignByRef(REQUEST_PARAM_NAME_CREDIT_FIELDS, $credit_details);
            }

            // если в параметрах разрешена защита кодом и защитный код неверный
            if (!empty($params->captcha_protecting) && !$this->security->checkCaptcha()) $this->push_error('Введите число с картинки.');

            // берем фамилию (name), отчество (name2) и имя (name3) покупателя
            $item->name = isset($_POST['name']) ? $this->text->stripTags($_POST['name'], TRUE) : '';
            $item->name2 = isset($_POST['name2']) ? $this->text->stripTags($_POST['name2'], TRUE) : '';
            $item->name3 = isset($_POST['name3']) ? $this->text->stripTags($_POST['name3'], TRUE) : '';

            // если имени нет и это не оформление в кредит, но в параметрах указано запрашивать имя покупателя
            if (empty($item->credit_id)
            && ($item->name == '')
            && ($item->name2 == '')
            && ($item->name3 == '')
            && isset($params->show_name) && $params->show_name) {
                $this->push_error('Нужно обязательно ввести свое имя.');
            }

            // берем емейлы, телефоны, номера ICQ и Skype-имена покупателя
            $item->email = isset($_POST['email']) ? $this->text->stripTags($_POST['email'], TRUE) : '';
            $item->email2 = isset($_POST['email2']) ? $this->text->stripTags($_POST['email2'], TRUE) : '';
            $item->phone = isset($_POST['phone']) ? $this->text->stripTags($_POST['phone'], TRUE) : '';
            $item->phone2 = isset($_POST['phone2']) ? $this->text->stripTags($_POST['phone2'], TRUE) : '';
            $item->icq = isset($_POST['icq']) ? $this->text->stripTags($_POST['icq'], TRUE) : '';
            $item->icq2 = isset($_POST['icq2']) ? $this->text->stripTags($_POST['icq2'], TRUE) : '';
            $item->skype = isset($_POST['skype']) ? $this->text->stripTags($_POST['skype'], TRUE) : '';
            $item->skype2 = isset($_POST['skype2']) ? $this->text->stripTags($_POST['skype2'], TRUE) : '';

            // если емейла или телефона нет и это не оформление в кредит, но в параметрах указано запрашивать телефон или емейл
            if (empty($item->credit_id)
            && $item->email == ''
            && $item->email2 == ''
            && $item->phone == ''
            && $item->phone2 == ''
            && isset($params->show_contacts) && $params->show_contacts) {
                $this->push_error('Нужно обязательно ввести е-мейл или номер телефона.');
            }



            // проверяем валидность емейлов, телефонов, номеров ICQ и Skype-имен
            if ($item->email != '' && !preg_match(EMAIL_CHECKING_PATTERN, $item->email)
            || $item->email2 != '' && !preg_match(EMAIL_CHECKING_PATTERN, $item->email2)) {
                $this->push_error('Е-мейл должен быть в стандартном формате (например ivan@mail.ru).');
            }
            if ($item->phone != '' && !preg_match(PHONE_CHECKING_PATTERN, $item->phone)
            || $item->phone2 != '' && !preg_match(PHONE_CHECKING_PATTERN, $item->phone2)) {
                $this->push_error('Номер телефона должен быть в стандартном формате (например +7 912 123-45-678).');
            }
            if ($item->icq != '' && !preg_match(ICQ_CHECKING_PATTERN, $item->icq)
            || $item->icq2 != '' && !preg_match(ICQ_CHECKING_PATTERN, $item->icq2)) {
                $this->push_error('Номер ICQ должен быть в стандартном формате.');
            }
            if ($item->skype != '' && !preg_match(SKYPE_CHECKING_PATTERN, $item->skype)
            || $item->skype2 != '' && !preg_match(SKYPE_CHECKING_PATTERN, $item->skype2)) {
                $this->push_error('Skype-имя должно быть в стандартном формате.');
            }



            // берем идентификаторы страны, области, города (из запроса, если нет - из данных о пользователе)
            $item->country_id = isset($_POST['country_id']) ? intval($_POST['country_id']) : (isset($this->user->country_id) ? $this->user->country_id : 0);
            $item->region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : (isset($this->user->region_id) ? $this->user->region_id : 0);
            $item->town_id = isset($_POST['town_id']) ? intval($_POST['town_id']) : (isset($this->user->town_id) ? $this->user->town_id : 0);



            // берем адрес1 доставки
            $item->address = isset($_POST['address']) ? $this->text->stripTags($_POST['address'], TRUE) : ' ';
            $item->address_2 = isset($_POST['address_2']) ? $this->text->stripTags($_POST['address_2'], TRUE) : '';
            $item->address_3 = isset($_POST['address_3']) ? $this->text->stripTags($_POST['address_3'], TRUE) : '';
            $item->address_4 = isset($_POST['address_4']) ? $this->text->stripTags($_POST['address_4'], TRUE) : '';
            $item->address_5 = isset($_POST['address_5']) ? $this->text->stripTags($_POST['address_5'], TRUE) : '';
            $item->address_6 = isset($_POST['address_6']) ? $this->text->stripTags($_POST['address_6'], TRUE) : '';
            $item->address_7 = isset($_POST['address_7']) ? $this->text->stripTags($_POST['address_7'], TRUE) : '';
            $item->address_8 = isset($_POST['address_8']) ? $this->text->stripTags($_POST['address_8'], TRUE) : '';
            $item->address_9 = isset($_POST['address_9']) ? $this->text->stripTags($_POST['address_9'], TRUE) : '';
            $item->address_10 = isset($_POST['address_10']) ? $this->text->stripTags($_POST['address_10'], TRUE) : '';



            // берем адрес2 доставки
            $item->address2 = isset($_POST['address2']) ? $this->text->stripTags($_POST['address2'], TRUE) : '';
            $item->address2_2 = isset($_POST['address2_2']) ? $this->text->stripTags($_POST['address2_2'], TRUE) : '';
            $item->address2_3 = isset($_POST['address2_3']) ? $this->text->stripTags($_POST['address2_3'], TRUE) : '';
            $item->address2_4 = isset($_POST['address2_4']) ? $this->text->stripTags($_POST['address2_4'], TRUE) : '';
            $item->address2_5 = isset($_POST['address2_5']) ? $this->text->stripTags($_POST['address2_5'], TRUE) : '';
            $item->address2_6 = isset($_POST['address2_6']) ? $this->text->stripTags($_POST['address2_6'], TRUE) : '';
            $item->address2_7 = isset($_POST['address2_7']) ? $this->text->stripTags($_POST['address2_7'], TRUE) : '';
            $item->address2_8 = isset($_POST['address2_8']) ? $this->text->stripTags($_POST['address2_8'], TRUE) : '';
            $item->address2_9 = isset($_POST['address2_9']) ? $this->text->stripTags($_POST['address2_9'], TRUE) : '';
            $item->address2_10 = isset($_POST['address2_10']) ? $this->text->stripTags($_POST['address2_10'], TRUE) : '';



            // если был указан способ доставки
            $method = null;
            $require_address = TRUE;
            if (isset($_POST['delivery_method_id'])) {

                // читаем данные о нем
                $id = intval($_POST['delivery_method_id']);
                $query = 'SELECT * '
                       . 'FROM `delivery_methods` '
                       . 'WHERE `enabled` = 1 '
                             . 'AND `delivery_method_id` = \'' . $this->db->query_value($id) . '\' '
                       . 'LIMIT 1;';
                $this->db->query($query);
                $method = $this->db->result();

                // определяем, требует ли способ ввода адреса доставки
                if (!empty($method) && ($method->require_address != 1)) $require_address = FALSE;
            }



            // если адреса доставки нет и это не оформление в кредит, но в способе доставки и в параметрах указано запрашивать какие-то из его полей
            if (empty($item->credit_id)
            && $require_address
            && $item->address == ''
            && $item->address_2 == ''
            && $item->address_3 == ''
            && $item->address_4 == ''
            && $item->address_5 == ''
            && $item->address_9 == '' && $item->address_10 == ''
            && $item->address2 == ''
            && $item->address2_2 == ''
            && $item->address2_3 == ''
            && $item->address2_4 == ''
            && $item->address2_5 == ''
            && $item->address2_9 == ''
            && $item->address2_10 == ''
            && isset($params->show_address) && $params->show_address) {
                $this->push_error('Нужно обязательно ввести адрес доставки.');
            }



            // берем желаемые дату и время доставки
            $item->to_date = isset($_POST['to_date']) ? $this->text->stripTags($_POST['to_date'], TRUE) : '';
            $item->to_time = isset($_POST['to_time']) ? $this->text->stripTags($_POST['to_time'], TRUE) : '';



            // берем комментарий к заказу
            $item->comment = isset($_POST['comment']) ? $this->text->stripTags($_POST['comment'], TRUE) : '';



            // берем тип комплектации заказа
            if (isset($_POST['delivery_type'])) $item->delivery_type = intval($_POST['delivery_type']);



            // вычисляем состояние корзины, при этом установятся переменные:
            //   $count = число товаров в корзине
            //   $total = сумма товаров корзины
            //   $discount = сумма скидки
            //   $products = список записей о товарах корзины
            $error = $this->compute_cart_state($count, $total, $discount, $products, $params->pointers);



            // если при вычислении состояния получено сообщение об ошибке, добавляем к общему сообщению
            if ($error != '') $this->push_error($error);



            // если была хоть одна ошибка, отображаем сообщение об ошибках
            if ($this->error_msg != '') {
                $this->delete_credit_files($credit_renames);
                if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {
                    $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
                    $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
                    $this->show_cart();
                }
                return;
            }



            // если список записей о товарах пустой, отображаем сообщение об ошибке
            if (empty($products)) {
                $this->delete_credit_files($credit_renames);
                $this->push_error('К сожалению, товары, которые были указаны в заказе, уже отсутствуют в каталоге магазина.');
                if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {
                    $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
                    $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
                    $this->show_cart();
                }
                return;
            }



            // берем желаемый способ оплаты
            $item->desire_payment_id = isset($_POST['desire_payment_id']) ? intval($_POST['desire_payment_id']) : (isset($_POST['payment_method_id']) ? intval($_POST['payment_method_id']) : 0);



            // берем идентификатор пользователя
            $item->user_id = isset($this->user->user_id) ? intval($this->user->user_id) : 0;



            // берем признак "заказ скрыт от чужих", если известен идентификатор пользователя
            $item->hidden = isset($_POST['hidden']) && !empty($item->user_id) ? (($_POST['hidden'] == 1) ? 1 : 0) : 0;



            // берем IP-адрес оформлявшего заказ
            $item->ip = $this->security->getVisitorIp();
            $item->host = $this->security->getVisitorHost();



            // генерируем код (url) заказа
            $item->code = md5(uniqid(rand(), TRUE));



            // сохраняем заказ в базе данных
            $item->date = time();
            $item->status = ORDER_STATUS_NEW;
            $item->discount_sum = $discount;
            $item->order_id = $this->db->orders->update($item);



            // если заказ не удалось сохранить, отображаем сообщение об ошибке
            if (empty($item->order_id)) {
                $this->delete_credit_files($credit_renames);
                $this->push_error('Внутренняя ошибка при сохранении заказа.');
                if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {
                    $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
                    $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
                    $this->show_cart();
                }
                return;
            }



            // переименовываем транзитные файлы кредитного заказа и обновляем сведения в базе
            if (!empty($item->credit_id)) {
                if ($this->rename_credit_files($credit_uniqid,
                                               $item->order_id . '-' . $item->code . '-',
                                               $credit_renames,
                                               $item->credit_details)) {
                    $this->db->orders->update($item);
                }
            }



            // добавляем товары в заказ
            foreach ($products as & $variant) {
                $amount = isset($params->pointers[CART_PRODUCTS_SESSION_PARAM_NAME][$variant->variant_id])
                          ? intval($params->pointers[CART_PRODUCTS_SESSION_PARAM_NAME][$variant->variant_id])
                          : 1;
                $this->db->insert_variant_into_order($item->order_id, $variant, $amount);
            }



            // если данные о способе доставки получены, передаем их в заказ
            if (!empty($method)) {
                $price = ($method->free_from > $total) ? $method->price : 0;
                $query = 'UPDATE `' . DATABASE_ORDERS_TABLENAME . '` '
                       . 'SET `delivery_method_id` = \'' . $this->db->query_value($id) . '\', '
                           . '`delivery_price` = \'' . $this->db->query_value($price) . '\' '
                       . 'WHERE `order_id` = \'' . $this->db->query_value($item->order_id) . '\';';
                $this->db->query($query);

                // если в настройках сайта указано делать комиссионные отчисления в том числе и с цены доставки
                if ($this->settings->affiliates_commission_full) $total += $price;
            }



            // передаем данные о способе доставки в шаблонизатор
            $this->smarty->assignByRef('delivery_method', $method);



            // если включена авто регистрация и нет авторизованного пользователя и указан емейл
            // TODO: убрать обращение к настройкам через request, когда корзина будет порождена от BasicMODModel
            if ($this->request->settings->get('cart_auto_registration')
            && empty($item->user_id)
            && ($item->email != '' || $item->email2 != '')) {

                // пытаемся прочитать запись о пользователе с таким емейлом
                $user = null;
                if ($item->email != '') {
                    $filter = new stdClass;
                    $filter->email = $item->email;
                    $this->db->users->one($user, $filter);
                }

                // пытаемся прочитать запись о пользователе с таким емейлом2
                if (empty($user)) {
                    if ($item->email2 != '') {
                      $filter = new stdClass;
                      $filter->email = $item->email2;
                      $this->db->users->one($user, $filter);
                    }
                }

                // если такой пользователь не найден
                if (empty($user)) {

                    // регистрируем пользователя
                    $user = new stdClass;
                    $user->email = $item->email;
                    $user->email2 = $item->email2;

                    $user->name = $item->name;
                    $user->name2 = $item->name2;
                    $user->name3 = $item->name3;

                    $user->phone = $item->phone;
                    $user->phone2 = $item->phone2;

                    $user->icq = $item->icq;
                    $user->icq2 = $item->icq2;

                    $user->skype = $item->skype;
                    $user->skype2 = $item->skype2;

                    $user->address = trim($item->address);
                    $user->address_2 = $item->address_2;
                    $user->address_3 = $item->address_3;
                    $user->address_4 = $item->address_4;
                    $user->address_5 = $item->address_5;
                    $user->address_6 = $item->address_6;
                    $user->address_7 = $item->address_7;
                    $user->address_8 = $item->address_8;
                    $user->address_9 = $item->address_9;
                    $user->address_10 = $item->address_10;

                    $user->address2 = $item->address2;
                    $user->address2_2 = $item->address2_2;
                    $user->address2_3 = $item->address2_3;
                    $user->address2_4 = $item->address2_4;
                    $user->address2_5 = $item->address2_5;
                    $user->address2_6 = $item->address2_6;
                    $user->address2_7 = $item->address2_7;
                    $user->address2_8 = $item->address2_8;
                    $user->address2_9 = $item->address2_9;
                    $user->address2_10 = $item->address2_10;

                    // возможно есть группа скидок, автоматически назначаемая зарегистрировавшимся
                    $filter = new stdClass;
                    $filter->authorized = 1;
                    $filter->auto_assign = 1;
                    $group = null;
                    $this->db->groups->one($group, $filter);
                    if (!empty($group)) $user->group_id = $group->group_id;

                    $password = $this->security->generatePassword(10);

                    $user->password = md5($password . $this->salt);
                    $user->enabled = 1;
                    $user->used_shop = 1;
                    $user->created = time();
                    $user->user_id = $this->db->users->update($user);

                    // если пользователь зарегистрирован
                    if (!empty($user->user_id)) {

                        // обновляем в заказе
                        $item->user_id = $user->user_id;
                        $query = 'UPDATE `' . DATABASE_ORDERS_TABLENAME . '` '
                               . 'SET `user_id` = \'' . $this->db->query_value($item->user_id) . '\' '
                               . 'WHERE `order_id` = \'' . $this->db->query_value($item->order_id) . '\';';
                        $this->db->query($query);

                        // уведомляем пользователя о регистрации
                        $login = $user->email != '' ? $user->email : $user->email2;
                        $subject = 'Вы зарегистрированы на сайте ' . $this->root_url;
                        $template = 'email_auto_registration.tpl';
                        if (file_exists($client_tpl_path . $template)) {
                            $this->smarty->assignByRef('new_password', $password);
                            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $user);
                            $message = $this->smarty->fetch($template);
                        } else {
                            $message = 'На сайте: http://' . $this->root_url . '<br />'
                                     . 'Ваш логин: ' . $login . '<br />'
                                     . 'Ваш пароль: ' . $password;
                        }
                        $this->email($login, $subject, $message);
                    }
                }
            }



            // пробуем прочесть заказ из базы данных
            $filter = new stdClass;
            $filter->id = $item->order_id;
            $this->db->orders->one($item, $filter);
            if (empty($item)) {
                $this->push_error('Ошибка сохранения заказа.');
                if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {
                    $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
                    $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ERROR, $this->error_msg);
                    $this->show_cart();
                }
                return;
            }



            // добавляем заказ в файл экспорта, если разрешен автоэкспорт
            if ($this->settings->orders_auto_export) {
                $file = $this->hdd->safeFilename($this->settings->orders_auto_export_file);
                if ($file != '') {
                    $file = ROOT_FOLDER_REFERENCE
                          . 'export/'
                          . $file;
                    switch (strtolower($this->settings->orders_auto_export_format)) {
                        case 'xml':
                            $this->db->orders->xml->exportFile($file, $item, 'order');
                            break;
                    }
                }
            }



            // передаем запись о заказе в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_ORDER, $item);



            // читаем список разрешенных способов оплаты и передаем в шаблонизатор
            $payments = null;
            $filter = new stdClass;
            $filter->sort = SORT_PAYMENTS_MODE_AS_IS;
            $filter->enabled = 1;
            $this->db->payments->get($payments, $filter);
            $this->smarty->assignByRef(SMARTY_VAR_PAYMENT_METHODS, $payments);
            $this->smarty->assignByRef(SMARTY_VAR_PAYMENTS, $payments);



            // уведомляем покупателя и администратора
            $this->inform_about_order($item,
                                      'Оформлен заказ №' . $item->order_id . ' на сайте ' . $this->root_url,
                                      'Вы оформили заказ №' . $item->order_id . ' на сайте ' . $this->root_url);
                                                            


            // если был использован купон или это покупатель, зарегистрировавшийся по купону
            if (isset($coupon) && is_object($coupon) || isset($this->user->coupon_id) && !empty($this->user->coupon_id)) {



                // если сейчас купон не использовался, но это был покупатель, зарегистрировавшийся по купону, пробуем найти такой купон
                if (!isset($coupon) || !is_object($coupon)) {
                    $filter = new stdClass;
                    $filter->id = $this->user->coupon_id;
                    $filter->enabled = 1;
                    $filter->deleted = 0;
                    $this->db->coupons->one($coupon, $filter);
                }



                // если такой купон все еще существует, уведомляем распространителя купонов об активности по купону
                if (isset($coupon) && is_object($coupon)) {
                    $rate = $this->any->currency->rate(null, TRUE);
                    $subject = $this->any->settings->getAsSentence('coupons_order_notify_subject');
                    $subject = str_replace('$', round($item->total_amount * $rate, 2), $subject);
                    $subject = str_replace('#', $item->order_id, $subject);
                    $subject = str_replace('&', $this->root_url, $subject);
                    $subject = str_replace('*', $coupon->code, $subject);
                    $this->inform_about_coupon($coupon,
                                               $item,
                                               $subject,
                                               isset($this->settings->coupons_order_notify_admin_by_email) && $this->settings->coupons_order_notify_admin_by_email,
                                               isset($this->settings->coupons_order_notify_admin_by_sms) && $this->settings->coupons_order_notify_admin_by_sms,
                                               isset($this->settings->coupons_order_notify_affiliate_by_email) && $this->settings->coupons_order_notify_affiliate_by_email,
                                               isset($this->settings->coupons_order_notify_affiliate_by_sms) && $this->settings->coupons_order_notify_affiliate_by_sms);
                }
            }



            // если это операция корзины / быстрого заказа, удаляем содержимое корзины
            if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {
                if (isset($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME])) unset($_SESSION[CART_PRODUCTS_SESSION_PARAM_NAME]);
                if (isset($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME])) unset($_SESSION[CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME]);
                $this->send_cart_cookie();
            }



            // делаем комиссионные отчисления
            $this->registrar->registerCommission($this->affiliate_id, $item->order_id, $total, FALSE);



            // если это операция корзины / быстрого заказа
            if (!isset($params->non_cart_operation) || !$params->non_cart_operation) {

                // если это не вызов без перезагрузки страницы
                $_SESSION['order_code'] = $item->code;
                if (!$this->quick_content) {

                    // если в клиентской части есть шаблон сообщения о принятии заказа, выводим его
                    $template = ORDER_SUCCESS_TEMPLATE_FILE;
                    if (file_exists($client_tpl_path . $template)) {
                        $this->title = 'Заказ принят';
                        $this->smarty->assignByRef('code', $item->code);
                        $this->body = $this->smarty->fetch($template);

                    // иначе перенаправляем на страницу заказа
                    } else {
                        $this->security->redirectToPage('http://' . $this->root_url . '/order/' . $item->code);
                    }

                // иначе перенаправляем на страницу заказа из перезагруженного участка страницы
                } else {
                    $this->body = '<p>'
                                    . 'Перенаправление на страницу оформленного заказа...'
                                . "</p>\r\n"
                                . '<script language="JavaScript" type="text/javascript">'
                                    . 'location.replace(\'http://' . $this->root_url . '/order/' . $item->code . '\');'
                                . '</script>';
                    echo $this->body;
                    exit;
                }
            }
        }



        // =======================================================================
        // Удалить транзитные файлы кредитного заказа (загруженные пользователем в кредитных сведениях):
        //   $filelist = массив со списком файлов
        // =======================================================================

        private function delete_credit_files ( & $filelist ) {
            if (is_array($filelist) && !empty($filelist)) {
                foreach ($filelist as & $file) {
                    if (file_exists($file)) unlink($file);
                }
            }
        }



        // =======================================================================
        // Переименовать транзитные файлы кредитного заказа (загруженные пользователем в кредитных сведениях):
        //   $search = какой фрагмент в имени файла ищем
        //   $replacement = на что заменяем найденное
        //   $filelist = массив со списком файлов
        //   $details = массив с кредитными сведениями
        //   возврат = были изменения или нет
        // =======================================================================

        private function rename_credit_files ($search, $replacement, &$filelist, &$details) {

            // пока изменений нет
            $result = FALSE;

            // перебираем имена файлов
            if (is_array($filelist) && !empty($filelist)) {
                foreach ($filelist as & $file) {
                    if (file_exists($file)) {
                        $new = str_replace($search, $replacement, $file);

                        // если файл переименован
                        if ($file != $new) {
                            if (@rename($file, $new)) {

                                // запоминаем изменения в кредитных сведениях
                                if (is_array($details) && !empty($details)) {
                                    foreach ($details as &$row) {
                                        if (isset($row['type']) && ($row['type'] == FIELDTYPE_CREDITPROGRAMS_FILE)
                                        && isset($row['value']) && ($row['value'] == $file)) {
                                            $row['value'] = $new;
                                        }
                                    }
                                }

                                $file = $new;
                                $result = TRUE;
                            }
                        }
                    }
                }
            }

            // возвращаем ИЗМЕНЕНО / НЕТ
            return $result;
        }
    }



    return;
?>