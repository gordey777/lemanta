<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);



    class Setup extends Basic {



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
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
            $this->prepare();
        }



        function prepare () {

            global $files_host_suffix;

            $this->error_msg = '';
            if (isset($_POST['site_name'])) {
                if (!isset($_POST['token']) || ($_POST['token'] !== $_SESSION['token'])) {
                    header('Location: http://' . $this->root_url . '/admin/');
                    exit;
                }

                $this->update_setting_in_database('site_name');
                $this->update_setting_in_database('company_name');
                $this->update_setting_in_database('admin_email');
                $this->update_setting_in_database('notify_from_email');
                $this->update_setting_in_database('main_section');
                $this->update_setting_in_database('mainpage_no_articles');
                $this->update_setting_in_database('mainpage_sortform_enabled', isset($_POST['mainpage_sortform_enabled']) && $_POST['mainpage_sortform_enabled'] ? 1 : 0);
                $this->update_setting_in_database('catalog_menu_mode');
                $this->update_setting_in_database('catalog_menu_noempty');
                $this->update_setting_in_database('catalog_menu_nocount');
                $this->update_setting_in_database('catalog_menu_adminedit');
                $this->update_setting_in_database('counters');
                $this->update_setting_in_database('technical_works_enabled', isset($_POST['technical_works_enabled']) && $_POST['technical_works_enabled'] ? 1 : 0);
                $this->update_setting_in_database('technical_works_html');
                $this->update_setting_in_database('technical_works_date');
                $this->update_setting_in_database('technical_works_time');
                $this->update_setting_in_database('productpage_block_columns');
                $this->update_setting_in_database('productpage_no_mores');
                $this->update_setting_in_database('productpage_mores_excludeme');
                $this->update_setting_in_database('productpage_mores_spacefill');
                $this->update_setting_in_database('productpage_mores_count');
                $this->update_setting_in_database('productpage_mores_caption');
                $this->update_setting_in_database('productpage_no_hits');
                $this->update_setting_in_database('productpage_hits_excludeme');
                $this->update_setting_in_database('productpage_hits_spacefill');
                $this->update_setting_in_database('productpage_hits_count');
                $this->update_setting_in_database('productpage_hits_caption');
                $this->update_setting_in_database('productpage_no_newests');
                $this->update_setting_in_database('productpage_newests_excludeme');
                $this->update_setting_in_database('productpage_newests_spacefill');
                $this->update_setting_in_database('productpage_newests_count');
                $this->update_setting_in_database('productpage_newests_caption');
                $this->update_setting_in_database('productpage_no_actionals');
                $this->update_setting_in_database('productpage_actionals_excludeme');
                $this->update_setting_in_database('productpage_actionals_spacefill');
                $this->update_setting_in_database('productpage_actionals_count');
                $this->update_setting_in_database('productpage_actionals_caption');
                $this->update_setting_in_database('productpage_no_awaiteds');
                $this->update_setting_in_database('productpage_awaiteds_excludeme');
                $this->update_setting_in_database('productpage_awaiteds_spacefill');
                $this->update_setting_in_database('productpage_awaiteds_count');
                $this->update_setting_in_database('productpage_awaiteds_caption');
                $this->update_setting_in_database('productpage_no_ordereds');
                $this->update_setting_in_database('productpage_ordereds_excludeme');
                $this->update_setting_in_database('productpage_ordereds_spacefill');
                $this->update_setting_in_database('productpage_ordereds_count');
                $this->update_setting_in_database('productpage_ordereds_caption');
                $this->update_setting_in_database('productpage_no_commenteds');
                $this->update_setting_in_database('productpage_commenteds_excludeme');
                $this->update_setting_in_database('productpage_commenteds_spacefill');
                $this->update_setting_in_database('productpage_commenteds_count');
                $this->update_setting_in_database('productpage_commenteds_caption');
                $this->update_setting_in_database('images_caching_enabled', isset($_POST['images_caching_enabled']) && $_POST['images_caching_enabled'] ? 1 : 0);
                $this->update_setting_in_database('images_caching_for_localhost_enabled', isset($_POST['images_caching_for_localhost_enabled']) && $_POST['images_caching_for_localhost_enabled'] ? 1 : 0);
                $this->update_setting_in_database('images_caching_lifetime');
                $this->update_setting_in_database('images_caching_filelimit');
                $this->update_setting_in_database('images_caching_timelimit');
                $this->update_setting_in_database('images_caching_ip_resolves');
                $this->update_setting_in_database('product_adimage_effect');
                $this->update_setting_in_database('prepath_images_template_used');
                $this->update_setting_in_database('livehelp_siteheart_id');

                $this->update_setting_in_database('sort_form_enabled', isset($_POST['sort_form_enabled']) && $_POST['sort_form_enabled'] ? 1 : 0);
                $this->update_setting_in_database('sort_form_default_method');
                $this->update_setting_in_database('sort_form_default_descending', isset($_POST['sort_form_default_descending']) && $_POST['sort_form_default_descending'] ? 1 : 0);
                if (isset($_SESSION['by_field_sort'])) unset($_SESSION['by_field_sort']);
                if (isset($_SESSION['descending_sort'])) unset($_SESSION['descending_sort']);

                $this->update_setting_in_database('meta_autofill', isset($_POST['meta_autofill']) && $_POST['meta_autofill'] ? 1 : 0);
                $this->update_setting_in_database('deliveries_wysiwyg_disabled', isset($_POST['deliveries_wysiwyg_disabled']) && $_POST['deliveries_wysiwyg_disabled'] ? 1 : 0);
                $this->update_setting_in_database('deliveries_wysiwyg_disabled_mode');
                $this->update_setting_in_database('delivery_sort_method');
                $this->update_setting_in_database('delivery_conflict_method');
                $this->update_setting_in_database('quickorder_sort_method');
                $this->update_setting_in_database('quickorder_title_text');
                $this->update_setting_in_database('quickorder_info_text');
                $this->update_setting_in_database('quickorder_show_info');
                $this->update_setting_in_database('quickorder_label_name');
                $this->update_setting_in_database('quickorder_show_name');
                $this->update_setting_in_database('quickorder_label_name2');
                $this->update_setting_in_database('quickorder_show_name2');
                $this->update_setting_in_database('quickorder_label_name3');
                $this->update_setting_in_database('quickorder_show_name3');
                $this->update_setting_in_database('quickorder_label_email');
                $this->update_setting_in_database('quickorder_show_email');
                $this->update_setting_in_database('quickorder_label_email2');
                $this->update_setting_in_database('quickorder_show_email2');
                $this->update_setting_in_database('quickorder_label_phone');
                $this->update_setting_in_database('quickorder_show_phone');
                $this->update_setting_in_database('quickorder_label_phone2');
                $this->update_setting_in_database('quickorder_show_phone2');
                $this->update_setting_in_database('quickorder_label_address');
                $this->update_setting_in_database('quickorder_show_address');
                $this->update_setting_in_database('quickorder_label_address_2');
                $this->update_setting_in_database('quickorder_show_address_2');
                $this->update_setting_in_database('quickorder_label_address_3');
                $this->update_setting_in_database('quickorder_show_address_3');
                $this->update_setting_in_database('quickorder_label_address_4');
                $this->update_setting_in_database('quickorder_show_address_4');
                $this->update_setting_in_database('quickorder_label_address_5');
                $this->update_setting_in_database('quickorder_show_address_5');
                $this->update_setting_in_database('quickorder_label_address_6');
                $this->update_setting_in_database('quickorder_show_address_6');
                $this->update_setting_in_database('quickorder_label_address_7');
                $this->update_setting_in_database('quickorder_show_address_7');
                $this->update_setting_in_database('quickorder_label_address_8');
                $this->update_setting_in_database('quickorder_show_address_8');
                $this->update_setting_in_database('quickorder_label_address_9');
                $this->update_setting_in_database('quickorder_show_address_9');
                $this->update_setting_in_database('quickorder_label_address_10');
                $this->update_setting_in_database('quickorder_show_address_10');
                $this->update_setting_in_database('quickorder_label_address2');
                $this->update_setting_in_database('quickorder_show_address2');
                $this->update_setting_in_database('quickorder_label_address2_2');
                $this->update_setting_in_database('quickorder_show_address2_2');
                $this->update_setting_in_database('quickorder_label_address2_3');
                $this->update_setting_in_database('quickorder_show_address2_3');
                $this->update_setting_in_database('quickorder_label_address2_4');
                $this->update_setting_in_database('quickorder_show_address2_4');
                $this->update_setting_in_database('quickorder_label_address2_5');
                $this->update_setting_in_database('quickorder_show_address2_5');
                $this->update_setting_in_database('quickorder_label_address2_6');
                $this->update_setting_in_database('quickorder_show_address2_6');
                $this->update_setting_in_database('quickorder_label_address2_7');
                $this->update_setting_in_database('quickorder_show_address2_7');
                $this->update_setting_in_database('quickorder_label_address2_8');
                $this->update_setting_in_database('quickorder_show_address2_8');
                $this->update_setting_in_database('quickorder_label_address2_9');
                $this->update_setting_in_database('quickorder_show_address2_9');
                $this->update_setting_in_database('quickorder_label_address2_10');
                $this->update_setting_in_database('quickorder_show_address2_10');
                $this->update_setting_in_database('quickorder_label_to_date');
                $this->update_setting_in_database('quickorder_show_to_date');
                $this->update_setting_in_database('quickorder_to_date_editable', isset($_POST['quickorder_to_date_editable']) && $_POST['quickorder_to_date_editable'] ? 1 : 0);
                $this->update_setting_in_database('quickorder_label_to_time');
                $this->update_setting_in_database('quickorder_show_to_time');
                $this->update_setting_in_database('quickorder_to_time_editable', isset($_POST['quickorder_to_time_editable']) && $_POST['quickorder_to_time_editable'] ? 1 : 0);
                $this->update_setting_in_database('quickorder_label_comment');
                $this->update_setting_in_database('quickorder_show_comment');
                $this->update_setting_in_database('quickorder_label_delivery');
                $this->update_setting_in_database('quickorder_show_delivery');
                $this->update_setting_in_database('quickorder_header_category');
                $this->update_setting_in_database('quickorder_header_name');
                $this->update_setting_in_database('quickorder_header_quantity');
                $this->update_setting_in_database('quickorder_header_sum');
                $this->update_setting_in_database('quickorder_submit_text');
                $this->update_setting_in_database('quickorder_captcha_protecting', isset($_POST['quickorder_captcha_protecting']) && $_POST['quickorder_captcha_protecting'] ? 1 : 0);
                $this->update_setting_in_database('cart_enable_reservation', isset($_POST['cart_enable_reservation']) && $_POST['cart_enable_reservation'] ? 1 : 0);
                $this->update_setting_in_database('cart_reservation_text');
                $this->update_setting_in_database('cart_open_method');
                $this->update_setting_in_database('cart_title_text');
                $this->update_setting_in_database('cart_info_text');
                $this->update_setting_in_database('cart_show_info');
                $this->update_setting_in_database('cart_header_number');
                $this->update_setting_in_database('cart_header_name');
                $this->update_setting_in_database('cart_header_quantity');
                $this->update_setting_in_database('cart_header_price');
                $this->update_setting_in_database('cart_header_sum');
                $this->update_setting_in_database('cart_contacts_maximize', isset($_POST['cart_contacts_maximize']) && $_POST['cart_contacts_maximize'] ? 1 : 0);
                $this->update_setting_in_database('cart_deliveries_maximize', isset($_POST['cart_deliveries_maximize']) && $_POST['cart_deliveries_maximize'] ? 1 : 0);
                $this->update_setting_in_database('cart_submit_text');
                $this->update_setting_in_database('cart_captcha_protecting', isset($_POST['cart_captcha_protecting']) && $_POST['cart_captcha_protecting'] ? 1 : 0);
                $this->update_setting_in_database('cart_auto_registration', isset($_POST['cart_auto_registration']) && $_POST['cart_auto_registration'] ? 1 : 0);
                $this->update_setting_in_database('cart_auto_registration_msg');
                $this->update_setting_in_database('delete_goods_ancient', isset($_POST['delete_goods_ancient']) && $_POST['delete_goods_ancient'] ? 1 : 0);
                $this->update_setting_in_database('delete_goods_ancientQ0_lifetime');
                $this->update_setting_in_database('delete_goods_ancientS0_lifetime');
                $this->update_setting_in_database('product_category_show', isset($_POST['product_category_show']) && $_POST['product_category_show'] ? 1 : 0);
                $this->update_setting_in_database('product_brand_show', isset($_POST['product_brand_show']) && $_POST['product_brand_show'] ? 1 : 0);

                $this->update_setting_in_database('vkontakte_publish_enabled', isset($_POST['vkontakte_publish_enabled']) && $_POST['vkontakte_publish_enabled'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_publish_selected_only', isset($_POST['vkontakte_publish_selected_only']) && $_POST['vkontakte_publish_selected_only'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_publish_javascript', isset($_POST['vkontakte_publish_javascript']) && $_POST['vkontakte_publish_javascript'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_publish_label');
                $this->update_setting_in_database('vkontakte_wishlist_enabled', isset($_POST['vkontakte_wishlist_enabled']) && $_POST['vkontakte_wishlist_enabled'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_wishlist_selected_only', isset($_POST['vkontakte_wishlist_selected_only']) && $_POST['vkontakte_wishlist_selected_only'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_wishlist_testmode', isset($_POST['vkontakte_wishlist_testmode']) && $_POST['vkontakte_wishlist_testmode'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_wishlist_delivery_cost');
                $this->update_setting_in_database('vkontakte_wishlist_cost_increase');
                $this->update_setting_in_database('vkontakte_wishlist_label');
                $this->update_setting_in_database('vkontakte_wishlist_label_right');
                $this->update_setting_in_database('vkontakte_wishlist_merchantid');
                if (!isset($_POST['vkontakte_wishlist_secret']) || (trim($_POST['vkontakte_wishlist_secret']) == '') || (trim(str_replace('*', '', $_POST['vkontakte_wishlist_secret'])) != '')) $this->update_setting_in_database('vkontakte_wishlist_secret', isset($_POST['vkontakte_wishlist_secret']) ? str_replace('*', '', $_POST['vkontakte_wishlist_secret']) : '');

                $this->update_setting_in_database('vkontakte_payment_enabled', isset($_POST['vkontakte_payment_enabled']) && $_POST['vkontakte_payment_enabled'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_payment_testmode', isset($_POST['vkontakte_payment_testmode']) && $_POST['vkontakte_payment_testmode'] ? 1 : 0);
                $this->update_setting_in_database('vkontakte_payment_cost_increase');
                $this->update_setting_in_database('vkontakte_payment_result_url');
                $this->update_setting_in_database('vkontakte_payment_fail_url');
                $this->update_setting_in_database('vkontakte_payment_label');
                $this->update_setting_in_database('vkontakte_payment_label_right');
                $this->update_setting_in_database('vkontakte_payment_merchantid');
                if (!isset($_POST['vkontakte_payment_secret']) || (trim($_POST['vkontakte_payment_secret']) == '') || (trim(str_replace('*', '', $_POST['vkontakte_payment_secret'])) != '')) $this->update_setting_in_database('vkontakte_payment_secret', isset($_POST['vkontakte_payment_secret']) ? str_replace('*', '', $_POST['vkontakte_payment_secret']) : '');


                $filename = ROOT_FOLDER_REFERENCE . trim(str_replace('*', $files_host_suffix, TECHNICAL_WORKS_INFO_FILENAME));
                if (isset($_POST['technical_works_enabled']) && $_POST['technical_works_enabled']) {
                    if ($this->config->demo) {
                        if ($this->error_msg != '') $this->error_msg .= '<br><br>';
                        $this->error_msg .= 'У вас нет прав на вывешивание сообщения о технических работах на сайте.';
                        $this->update_setting_in_database('technical_works_enabled', 0);
                    } else {
                        $date = ''; if (isset($_POST['technical_works_date'])) $date = trim($_POST['technical_works_date']);
                        $time = ''; if (isset($_POST['technical_works_time'])) $time = trim($_POST['technical_works_time']);
                        $template_filename = ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html/technical.works.tpl';
                        if (file_exists($template_filename)) {
                            $this->smarty->assign('date', $date);
                            $this->smarty->assign('time', $time);
                            $html = $this->smarty->fetch('file:[client]technical.works.tpl');
                        } else {
                            $html = '';
                            if (isset($_POST['technical_works_html'])) {
                                $html = trim($_POST['technical_works_html']);
                                $html = str_replace('{$date}', $date, $html);
                                $html = str_replace('{$time}', $time, $html);
                            }
                        }
                        $handle = @ fopen($filename, 'wb');
                        if ($handle !== FALSE) {
                            @ flock($handle, LOCK_EX);
                            @ fwrite($handle, $html);
                            @ fclose($handle);
                            @ chmod($filename, 0666);
                        } else {
                            if ($this->error_msg != '') $this->error_msg .= '<br><br>';
                            if (file_exists($filename)) {
                                $this->error_msg .= 'Не удалось перезаписать файл вывески о технических работах <code>' . $filename . '</code>.<br>Проверьте права доступа к файлу.';
                                $this->update_setting_in_database('technical_works_enabled', 1);
                            } else {
                                $this->error_msg .= 'Не удалось создать файл вывески о технических работах <code>' . $filename . '</code>.<br>Проверьте права доступа к папке, где производится создание файла.';
                                $this->update_setting_in_database('technical_works_enabled', 0);
                            }
                        }
                    }
                } else {
                    if (file_exists($filename)) {
                        if (@ !unlink($filename)) {
                            if ($this->error_msg != '') $this->error_msg .= '<br><br>';
                            $this->error_msg .= 'Не удалось удалить файл вывески о технических работах <code>' . $filename . '</code>.<br>Проверьте права доступа к этому файлу.';
                            $this->update_setting_in_database('technical_works_enabled', 1);
                        }
                    }
                }

                if ($this->settings->vkontakte_payment_result_url != '') {
                    if (((strtolower(substr(trim($this->settings->vkontakte_payment_result_url), 0, 7)) != 'http://') || (strlen(trim($this->settings->vkontakte_payment_result_url)) < 8))
                    && ((strtolower(substr(trim($this->settings->vkontakte_payment_result_url), 0, 8)) != 'https://') || (strlen(trim($this->settings->vkontakte_payment_result_url)) < 9))) {
                        if ($this->error_msg != '') $this->error_msg .= '<br><br>';
                        $this->error_msg .= 'Неправильно указан URL страницы успешного завершения оплаты ВКонтакте.';
                    }
                }

                if ($this->settings->vkontakte_payment_fail_url != '') {
                    if (((strtolower(substr(trim($this->settings->vkontakte_payment_fail_url), 0, 7)) != 'http://') || (strlen(trim($this->settings->vkontakte_payment_fail_url)) < 8))
                    && ((strtolower(substr(trim($this->settings->vkontakte_payment_fail_url), 0, 8)) != 'https://') || (strlen(trim($this->settings->vkontakte_payment_fail_url)) < 9))) {
                        if ($this->error_msg != '') $this->error_msg .= '<br><br>';
                        $this->error_msg .= 'Неправильно указан URL страницы неудачного завершения оплаты ВКонтакте.';
                    }
                }

                if ($this->error_msg == '') {
                    header('Location: index.php?section=Setup');
                }
            }
        }



        function update_setting_in_database($setting_name, $value = NULL) {
            if (is_null($value)) {
                $value = '';
                if (isset($_POST[$setting_name])) $value = trim($_POST[$setting_name]);
            }
            $query = 'SELECT `value` '
                   . 'FROM `settings` '
                   . 'WHERE `name` = \'' . $this->db->query_value($setting_name) . '\' '
                   . 'LIMIT 1;';
            $this->db->query($query);
            $row = $this->db->result();
            if (isset($row->value)) {
                if ($row->value != $value) {
                    $query = 'UPDATE `settings` '
                           . 'SET `value` = \'' . $this->db->query_value($value) . '\' '
                           . 'WHERE `name` = \'' . $this->db->query_value($setting_name) . '\';';
                    $this->db->query($query);
                    $this->settings->$setting_name = $value;
                }
            } else {
                $query = 'INSERT INTO `settings` (`name`, '
                                               . '`value`) '
                       . 'VALUES (\'' . $this->db->query_value($setting_name) . '\', '
                               . '\'' . $this->db->query_value($value) . '\');';
                $this->db->query($query);
                $this->settings->$setting_name = $value;
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

            global $files_host_suffix;

            $dates = array();
            $monthes = array(1 => ' января ',
                             2 => ' февраля ',
                             3 => ' марта ',
                             4 => ' апреля ',
                             5 => ' мая ',
                             6 => ' июня ',
                             7 => ' июля ',
                             8 => ' августа ',
                             9 => ' сентября ',
                             10 => ' октября ',
                             11 => ' ноября ',
                             12 => ' декабря ');
            $time = time();
            $index = 0;
            while ($index < 365) {
                $string = date('j', $time) . $monthes[date('n', $time)] . date('Y', $time);
                $index++;
                $dates[] = $string;
                $time = $time + 24 * 3600;
            }
            $this->smarty->assignByRef('dates', $dates);

            $this->title = 'Настройки сайта';

            $query = 'SELECT * '
                   . 'FROM `sections` '
                   . 'WHERE `menu_id` IS NOT NULL '
                   . 'ORDER BY `name` ASC;';
            $this->db->query($query);
            $sections = $this->db->results();

            $this->smarty->assign('technical_works_filename', trim(str_replace('*', $files_host_suffix, TECHNICAL_WORKS_INFO_FILENAME)));
            $this->smarty->assignByRef('Settings', $this->settings);
            $this->smarty->assignByRef('Sections', $sections);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('Error', $this->error_msg);

            $this->body = $this->smarty->fetch('admin_setup.htm');
            return TRUE;
        }
    }



    return;
?>