<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;

    // модуль корзины
    require_once(dirname(__FILE__) . '/cart/Cart.php');

    // какой файл является шаблоном мгновенного заказа на клиентской стороне (указываем без расширения)
    define('CLIENT_FULMINANTORDER_CLASS_TEMPLATE_FILE', 'page.fulminant.order');



    // =======================================================================
    /**
    *  Модуль мгновенного заказа на клиентской стороне
    *
    *  Использование этого класса происходит в результате переназначения класса
    *  FulminantOrder на данный класс во время загрузки модуля мгновенного заказа.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientFulminantOrder extends ClientCart {

        // контент модуля выводится без внешнего оформления страницы
        public $single = TRUE;



        // ===================================================================
        /**
        *  Обработка постинга данных в модуль
        *
        *  @access  protected
        *  @return  boolean     TRUE если обнаружена ошибка
        */
        // ===================================================================

        protected function posting () {

            // ошибки здесь еще не было
            $cancel = FALSE;

            // если получены данные об изменениях
            if (isset($_POST['post_submit']) && ($_POST['post_submit'] != '')) {

                // проверям лимит времени на мгновенные заказы
                $param_name = 'fulminantorder_next_time';
                $time = time();
                if (isset($_SESSION[$param_name]) && ($_SESSION[$param_name] > $time)) {
                    $cancel = $this->push_error('У вас нет прав делать мгновенные заказы '
                                              . 'слишком часто! Попробуйте через '
                                              . @intval($_SESSION[$param_name] - $time) . ' секунд.');
                } else {

                    // если защитный код запрещен или введен правильно
                    if ($this->any->settings->getAsBoolean('fulminantorder_captcha_disabled')
                    || $this->security->checkCaptcha()) {

                        // передаем в шаблонизатор признак обновить картинку защитного кода
                        $this->smarty->assign('refresh_captcha', TRUE);

                        // если указан покупаемый товар (идентификатор варианта или товара, количество, выбранные свойства)
                        $id = intval($this->param(REQUEST_PARAM_NAME_VARIANT_ID));
                        if (empty($id)) $id = intval($this->param(REQUEST_PARAM_NAME_PRODUCT_ID));
                        if (!empty($id)) {

                            // находим такой товар
                            $item = null;
                            $params = new stdClass;
                            $params->variant_id = $id;
                            $params->enabled = 1;
                            $this->db->products->one($item, $params);
                            if (!empty($item)) {

                                // если товар доступен неавторизованным или это авторизованный пользователь
                                if (!$item->hidden || isset($this->user->user_id)) {

                                    // если товар доступен для продажи
                                    if (!$item->non_usable) {

                                        // освобождаем память от товара
                                        $item = null;

                                        $amount = intval($this->param(REQUEST_PARAM_NAME_AMOUNT));
                                        if ($amount == 0) $amount = 1;
                                        $properties = $this->param('props');

                                        // готовим параметры обработки сохранения заказа
                                        $params = new stdClass;

                                        // приказываем не проверять защитный код (его уже проверили здесь)
                                        $params->captcha_protecting = FALSE;

                                        // приказываем обязательны ли к заполнению ФИО, емейл/телефон, адрес доставки
                                        // согласно настройкам сайта для мгновенного заказа
                                        $params->show_name = $this->settings->fulminantorder_show_name
                                                             || $this->settings->fulminantorder_show_name2
                                                             || $this->settings->fulminantorder_show_name3;
                                        $params->show_contacts = $this->settings->fulminantorder_show_email
                                                                 || $this->settings->fulminantorder_show_email2
                                                                 || $this->settings->fulminantorder_show_phone
                                                                 || $this->settings->fulminantorder_show_phone2;
                                        $params->show_address = $this->settings->fulminantorder_show_address
                                                                || $this->settings->fulminantorder_show_address_2
                                                                || $this->settings->fulminantorder_show_address_3
                                                                || $this->settings->fulminantorder_show_address_4
                                                                || $this->settings->fulminantorder_show_address_5
                                                                || $this->settings->fulminantorder_show_address_9
                                                                || $this->settings->fulminantorder_show_address_10
                                                                || $this->settings->fulminantorder_show_address2
                                                                || $this->settings->fulminantorder_show_address2_2
                                                                || $this->settings->fulminantorder_show_address2_3
                                                                || $this->settings->fulminantorder_show_address2_4
                                                                || $this->settings->fulminantorder_show_address2_5
                                                                || $this->settings->fulminantorder_show_address2_9
                                                                || $this->settings->fulminantorder_show_address2_10;

                                        // сообщаем, что это не операция из корзины (не рисовать ее контент, не уничтожать ее переменные)
                                        $params->non_cart_operation = TRUE;

                                        // готовим массив указателей покупаемых товаров по формату, как хранится в сеансе для корзины
                                        $params->pointers = array(CART_PRODUCTS_SESSION_PARAM_NAME            => array($id => $amount),
                                                                  CART_PRODUCTS_PROPERTIES_SESSION_PARAM_NAME => array($id => $properties));

                                        // сохраняем заказ (с нашими параметрами обработки, в $order получим запись заказа)
                                        $this->save_order($params, $order);
                                        $cancel = $this->error_msg != '';

                                        // если нет ошибок
                                        if (!$cancel) {

                                            // информационное сообщение пользователю
                                            $this->push_info('Спасибо! Ваш заказ принят. Можете перейти на страницу '
                                                           . '<a href="' . htmlspecialchars($this->site_url, ENT_QUOTES)
                                                           . 'order/' . htmlspecialchars($order->code, ENT_QUOTES) . '">своего заказа</a> '
                                                           . 'или продолжить покупки.');

                                            // установить странице фоновый звук УСПЕХ
                                            $this->success_bgsound();

                                            // засекаем новый лимит времени на мгновенный заказ
                                            $_SESSION[$param_name] = time() + abs(intval(POST_NEXT_FULMINANTORDER_LIFETIME));
                                        }

                                    // иначе это товар не для продажи
                                    } else {
                                        $this->push_error('Такой товар имеет пометку "не для продажи", поэтому не может быть заказан.');
                                    }

                                // иначе это товар, скрытый от неавторизованных
                                } else {
                                    $cancel = $this->push_error('Такой товар недоступен для неавторизованных пользователей сайта.');
                                }

                            // иначе товар не найден
                            } else {
                                $cancel = $this->push_error('Такой товар не найден в базе магазина.');
                            }

                        // иначе не указан покупаемый товар
                        } else {
                            $cancel = $this->push_error('Не получены данные о покупаемом товаре.');
                        }

                    // иначе неправильно введен защитный код
                    } else {
                        $cancel = $this->push_error('Введите правильный защитный код с картинки.');
                    }
                }

            // иначе данные об изменениях не получены
            } else {
                $cancel = $this->push_error('Не получены данные о мгновенном заказе.');
            }

            // возвращаем в html-форму принятые от нее параметры
            $block_id = $this->param('post_block_id');
            $this->smarty->assignByRef('post_block_id', $block_id);

            // возвращаем была ли ошибка
            return $cancel;
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

            // устанавливаем мета информацию страницы
            $this->title = 'Мгновенный заказ';

            // передаем данные в шаблонизатор
            $this->smarty->assignByRef('quick_content', $this->single);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);

            // создаем контент модуля
            $this->smarty->fetchByTemplate($this, CLIENT_FULMINANTORDER_CLASS_TEMPLATE_FILE, 'fulminant.order');

            // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
            return TRUE;
        }
    }



    return;
?>