<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);



    class ClientCompare extends Basic {

        public $max_products = DEFAULT_VALUE_FOR_PRODUCTS_IN_COMPARE;
        public $module_name = 'AIMatrix Compare module';



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent         объект владельца
        *  @param   integer $start_mode     режим запуска
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

            // конструируем объект
            parent::__construct($parent);

            if (!isset($_SESSION['compared_products']) || !is_array($_SESSION['compared_products'])) {
                $_SESSION['compared_products'] = array();
            }



            // если это добавление товара в сравнение
            $url = $this->request->getGetAsSentence('url');
            if ($url != '') {
                if (!isset($_SESSION['compared_products'][$url])) {
                    $_SESSION['compared_products'][$url] = $url;
                    if (count($_SESSION['compared_products']) > $this->max_products) {
                        array_shift($_SESSION['compared_products']);
                    }
                }
                if (!$this->quick_content) $this->security->redirectToPage('http://' . $this->root_url . '/compare');
            }



            // если это удаление товара из сравнения
            $url = $this->request->getGetAsSentence('remove_url');
            if ($url != '') {
                if (isset($_SESSION['compared_products'][$url])) {
                    unset($_SESSION['compared_products'][$url]);
                }
                $this->security->redirectToPage('http://' . $this->root_url . '/compare');
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

            $properties = array();
            $items = array();
            if (isset($_SESSION['compared_products']) && is_array($_SESSION['compared_products'])) {
                foreach($_SESSION['compared_products'] as $url) {

                    // читаем данные о незапрещенном и видимом товаре с таким url в текущем разделе магазина
                    $params = new stdClass;
                    $params->url = $url;
                    $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
                    if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
                    $params->enabled = 1;
                    if (!isset($this->user->user_id)) $params->hidden = 0;
                    $params->section = $this->now_in_section;
                    $this->db->products->one($item, $params);

                    if (!empty($item)) {
                        $items[] = $item;
                        foreach ($item->properties as $property) {
                            if (isset($property->in_compare) && $property->in_compare) {
                                $properties[$property->name][$item->product_id] = & $property->value;
                            }
                        }
                    }
                }
            }



            $this->title = 'Сравнение товаров';
            $this->smarty->assignByRef('products', $items);
            $this->smarty->assignByRef('properties', $properties);
            $this->smarty->assign('compare_max_products', $this->max_products);
            $this->smarty->assign('compare_microinfo', $this->get_compare_microinfo_content());
            $this->smarty->assign('compare_module_name', $this->module_name);



            if ($this->quick_content) {
                $template_name = 'page.quick_compare.tpl';
                if (!@file_exists('design/' . $this->dynamic_theme . '/html/' . $template_name)) $template_name = 'page.compare.tpl';
            } else {
                $template_name = 'page.compare.tpl';
            }
            if (!@file_exists('design/' . $this->dynamic_theme . '/html/' . $template_name)) $template_name = 'compare.tpl';
            $this->body = $this->smarty->fetch($template_name);

            return TRUE;
        }
    }



    return;
?>