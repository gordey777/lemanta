<?php
    // =======================================================================
    /**
    *  Админ модуль редактирования заказа
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

    // подключаем класс заказов
    impera_ClassRequire('Orders', TRUE);

    // какой файл является шаблоном модуля страницы заказа
    define('ADMIN_ORDER_CLASS_TEMPLATE_FILE', 'admin_order.htm');

    // какая страница возврата рекомендуется для модуля страницы заказа
    define('ADMIN_ORDER_CLASS_RESULT_PAGE', 'index.php?section=Orders');



    // =======================================================================
    /**
    *  Админ модуль редактирования заказа
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Order extends Orders {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_ORDER_CLASS_RESULT_PAGE;

        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('categories',
                                      'all_users');



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

            // если в запросе есть параметр FROM (страница возврата из операции),
            // запоминаем его, передаем в шаблонизатор и убираем из запроса
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if (!empty($result_page)) {
                $this->result_page = $result_page;
                $this->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }



            // обрабатываем соответствующие модулю настройки сайта,
            // обрабатываем входные команды
            $this->process_setup();
            $this->process();



            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));



            // устанавливаем заголовок страницы,
            // если нет данных заказа или они изменились,
            //   читаем их из базы данных
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Новый заказ';
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->orders->one($this->item, $params);
            }



            // если данные заказа получены,
            //   меняем заголовок страницы
            if (!empty($this->item)) {
                $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование заказа №' . $this->item->order_id;



                // если данные получены не из базы данных
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->orders->unpack($this->item);



                // если это команда "Создать копию", деидентифицируем заказ и его товары
                if (trim($this->param(REQUEST_PARAM_NAME_ACTION)) == ACTION_REQUEST_PARAM_VALUE_COPY) {
                    $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Редактирование копии заказа №' . $this->item->order_id;
                    $this->item->order_id = 0;
                    $this->item->code = md5(uniqid('', TRUE));
                    if (!isset($this->item->products)) $this->item->products = array();
                    foreach ($this->item->products as & $product) {
                        if (!is_object($product)) $product = new stdClass;
                        $product->order_id = 0;
                        $product->virtual = 1;
                    }
                }



            // иначе нет данных, инициируем важные поля новой записи
            } else {
                if (!is_object($this->item)) $this->item = new stdClass;
                $this->item->hidden = 0;
                $this->item->code = md5(uniqid('', TRUE));
                $this->item->products = array();
                $this->item->ip = $this->security->getVisitorIp();
                $this->item->host = $this->security->getVisitorHost();
            }



            // читаем список неудаленных стадий заказа
            $params = new stdClass;
            $params->sort = SORT_ORDERSPHASES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->deleted = 0;
            $this->db->get_orders_phases($orders_phases, $params);



            // читаем список разрешенных способов доставки
            $params = new stdClass;
            $params->sort = SORT_DELIVERIES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->enabled = 1;
            $this->db->get_deliveries($deliveries, $params);



            // читаем список типов доставки
            $params = new stdClass;
            $params->sort = SORT_DELIVERIESTYPES_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $this->db->get_deliveries_types($deliveries_types, $params);



            // читаем список разрешенных способов оплаты
            $payments = null;
            $params = new stdClass;
            $params->sort = SORT_PAYMENTS_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->enabled = 1;
            $this->db->payments->get($payments, $params);



            // дополняем список категорий товарами (со степенью полноты записей как для конфигуратора / быстрого заказа)
            $params = new stdClass;
            $params->completeness = GET_PRODUCTS_COMPLETENESS_FOR_EDITORDER;
            $params->sort = SORT_PRODUCTS_MODE_BY_NAME;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->sort_laconical = 1;
            $params->enabled = 1;
            $this->db->productize_categories($this->categories_tree, $this->categories, $params);



            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->smarty->assignByRef(SMARTY_VAR_CATALOG, $this->categories_tree);
            $this->smarty->assignByRef(SMARTY_VAR_ORDERS_PHASES, $orders_phases);
            $this->smarty->assignByRef(SMARTY_VAR_DELIVERIES, $deliveries);
            $this->smarty->assignByRef(SMARTY_VAR_DELIVERIES_TYPES, $deliveries_types);
            $this->smarty->assignByRef(SMARTY_VAR_PAYMENTS, $payments);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->body = $this->smarty->fetch(ADMIN_ORDER_CLASS_TEMPLATE_FILE);



            // удаляем из записей категорий списки товаров (освобождаем место в памяти)
            $this->db->unproductize_categories($this->categories);

            return TRUE;
        }
    }



    return;
?>