<?php
    // =======================================================================
    /**
    *  Админ модуль синхронизации 1С (протокол CommerceML)
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемой таблицы записей
    require_once(dirname(__FILE__) . '/../.ref-models/AdminTable.php');

    // текст заголовка страницы модуля
    define('COMMERCEML_PAGE_TITLE', 'Настройки синхронизации 1С');

    // имя файла шаблона модуля
    define('COMMERCEML_TEMPLATE_FILENAME', 'commerceml/commerceml.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('COMMERCEML_MODULELINK_POINTER', 'CommerceML');
    define('COMMERCEML_MODULETAB_TEXT', '1с');
    define('COMMERCEML_MODULEMENU_PATH', 'Товары / Товары / Настройки синхронизации 1С');



    // =======================================================================
    /**
    *  Админ модуль синхронизации 1С
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CommerceML extends AdminSetupREFModel {

        // имя папки для выгрузки временных файлов (относительно папки этого модуля)
        protected $upload_folder = '.CommerceML_temporary';

        // имя файла шаблона
        protected $template = COMMERCEML_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Проверка что запрос страницы поступил из 1С
        *
        *  @access  public
        *  @return  boolean         TRUE если это запрос из 1С
        */
        // ===================================================================

        public function isRequester1C () {
            return $this->request->getServerAsSentence('type') != ''
                && $this->request->getServerAsSentence('HTTP_REFERER') == '';
        }



        // ===================================================================
        /**
        *  Добавление сведений в историю синхронизаций
        *
        *  @access  public
        *  @param   string  $msg    новое сообщение
        *  @return  void
        */
        // ===================================================================

        public function addHistory ( $msg ) {
            $msg = trim(preg_replace('/[<>]+/', ' ', $msg));
            if ($msg != '') {
                $field = 'cml_history';
                $history = trim($this->settings->get($field, ''));
                if ($history != '') $history = "\r\n\r\n" . $history;
                $history = date('d-m-Y H:i:s')
                         . ' - ip: ' . $this->security->getVisitorIp()
                         . ' - ' . $msg . $history;
                $this->cms->db->settings->save($field, $history, 'Синхронизация 1С - история');
            }
        }



        // ===================================================================
        /**
        *  Проверка что IP-адрес обратившегося входит в список разрешенных
        *
        *  @access  public
        *  @return  boolean         TRUE если IP-адрес разрешен
        */
        // ===================================================================

        public function isValidClientIP () {
            $ip = strtolower($this->security->getVisitorIp());
            $ips = $this->settings->get('cml_ips', '');
            $ips = explode(',', $ips);
            $state = TRUE;
            if (!empty($ips)) {
                foreach ($ips as $value) {
                    $value = trim($value);
                    if ($value != '') {
                        $value = strtolower($value);
                        $state = $ip == $value || substr($ip, 0, strlen($value)) == $value;
                        if ($state) return TRUE;
                    }
                }
            }
            return $state;
        }



        // ===================================================================
        /**
        *  Преобразование значения в строковое значение
        *
        *  @access  public
        *  @param   mixed   $value          исходное значение
        *  @param   boolean $reduce_spaces  TRUE если сократить избыточные пробелы
        *  @return  string                  значение
        */
        // ===================================================================

        public function valueAsString ( $value, $reduce_spaces = TRUE ) {
            try {
                $value = trim($value);
                if ($reduce_spaces) {
                    $value = preg_replace('/[ \t]+/', ' ', $value);
                }
            } catch (Exception $e) {
                $value = '';
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Преобразование значения в действительное число
        *
        *  @access  public
        *  @param   mixed   $value      исходное значение
        *  @param   float   $min        минимальное возможное
        *  @param   float   $max        максимальное возможное
        *  @return  float               значение
        */
        // ===================================================================

        public function valueAsFloat ( $value, $min = null, $max = null ) {
            try {
                $value = floatval(str_replace(',', '.', trim($value)));
            } catch (Exception $e) {
                $value = floatval(0);
            }
            if (!is_null($min)) $value = max($value, $min);
            if (!is_null($max)) $value = min($value, $max);
            return $value;
        }



        // ===================================================================
        /**
        *  Преобразование значения в целочисленное
        *
        *  @access  public
        *  @param   mixed   $value      исходное значение
        *  @param   integer $min        минимальное возможное
        *  @param   integer $max        максимальное возможное
        *  @return  integer             значение
        */
        // ===================================================================

        public function valueAsInteger ( $value, $min = null, $max = null ) {
            try {
                $value = intval(trim($value));
            } catch (Exception $e) {
                $value = 0;
            }
            if (!is_null($min)) $value = max($value, $min);
            if (!is_null($max)) $value = min($value, $max);
            return $value;
        }



        // ===================================================================
        /**
        *  Преобразование значения в натуральное число (расширенный ряд)
        *
        *  @access  public
        *  @param   mixed   $value      исходное значение
        *  @param   integer $min        минимальное возможное
        *  @param   integer $max        максимальное возможное
        *  @return  integer             значение
        */
        // ===================================================================

        public function valueAsNatural ( $value, $min = null, $max = null ) {
            try {
                $value = intval(trim($value));
                if ($value < 0) $value = 0;
            } catch (Exception $e) {
                $value = 0;
            }
            if (!is_null($min)) $value = max($value, $min);
            if (!is_null($max)) $value = min($value, $max);
            return $value;
        }



        // ===================================================================
        /**
        *  Преобразование значения в приоритетную скидку
        *
        *  @access  public
        *  @param   mixed   $value      исходное значение
        *  @return  float               значение
        */
        // ===================================================================

        public function valueAsDiscount ( $value ) {
            try {
                $value = floatval(str_replace(',', '.', trim($value)));
                if ($value < 0) $value = -1;
                if ($value > 100) $value = 100;
            } catch (Exception $e) {
                $value = floatval(-1);
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Преобразование значения в флаговое состояние (1 или 0)
        *
        *  @access  public
        *  @param   mixed   $value      исходное значение
        *  @return  integer             значение
        */
        // ===================================================================

        public function valueAsFlag ( $value ) {
            try {
                $value = strtolower(trim($value));
                $value = $value === '0' || $value === 'false' || $value === '' ? 0 : 1;
            } catch (Exception $e) {
                $value = 0;
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Сохранение полученных во время редактирования настроек сайта
        *
        *  @access  protected
        *  @param   string  $upload_folder      относительное имя папки сохранения ожидаемых файлов (будет возвращено сюда)
        *                                       пустая строка = не ждем таких
        *  @param   string  $upload_watermark   имя ожидаемого файла водяного знака (будет возвращено сюда)
        *                                       пустая строка = не ждем такой файл
        *  @return  void
        */
        // ===================================================================

        protected function processSetupSave ( & $upload_folder = '', & $upload_watermark = '' ) {

            // если это не запрос из 1С
            if (!$this->isRequester1C()) {

                // разрешено или нет
                $field = 'cml_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешена или нет');

                // хранить файлы прежних синхронизаций
                $field = 'cml_store_old_files';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - хранить ли файлы прежних синхронизаций');

                // допустимые ip-адреса
                $field = 'cml_ips';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - допустимые IP-адреса');

                // разрешение импорта категорий
                $field = 'cml_categories_import_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешен ли импорт категорий');

                // разрешение импорта товаров
                $field = 'cml_products_import_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешен ли импорт товаров');

                // разрешение импорта вариантов
                $field = 'cml_variants_import_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешен ли импорт вариантов товара');

                // разрешение импорта свойств товаров
                $field = 'cml_properties_import_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешен ли импорт свойств товара');

                // разрешение импорта заказов
                $field = 'cml_orders_import_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешен ли импорт заказов');

                // разрешение экспорта заказов
                $field = 'cml_orders_export_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - разрешен ли экспорт заказов');

                // узел корневой категории
                $field = 'cml_category_node';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - узел корневой категории');

                    // синхронизационный ИД
                    $field = 'cml_category_id';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к синхронизационному ИД');

                    // мета заголовок
                    $field = 'cml_category_meta_title';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к мета заголовку');

                    // мета ключевые слова
                    $field = 'cml_category_meta_keywords';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к мета ключевым словам');

                    // мета описание
                    $field = 'cml_category_meta_description';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к мета описанию');

                    // теги
                    $field = 'cml_category_tags';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к тегам');

                    // название категории
                    $field = 'cml_category_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к названию категории');

                    // название в единственном числе
                    $field = 'cml_category_single_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к названию в единственном числе');

                    // название в конфигураторе
                    $field = 'cml_category_configurator_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к названию в конфигураторе комплектов');

                    // описание
                    $field = 'cml_category_description';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к описанию');

                    // seo текст
                    $field = 'cml_category_seo_description';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к SEO тексту');

                    // имя субдомена
                    $field = 'cml_category_subdomain';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к имени субдомена');

                    // субдомен разрешен
                    $field = 'cml_category_subdomain_enabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Субдомен разрешен"');

                    // контент субдомена
                    $field = 'cml_category_subdomain_html';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к контенту субдомена');

                    // картинка
                    $field = 'cml_category_image';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к списку картинок');

                    // название картинки
                    $field = 'cml_category_image_alt';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к списку названий картинок');

                    // описание картинки
                    $field = 'cml_category_image_text';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к списку описаний картинок');

                    // разрешена картинка
                    $field = 'cml_category_image_view';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к списку признаков "Показывать картинку в слайдере"');

                    // вес в списке
                    $field = 'cml_category_order_num';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к позиции категории среди прочих в своей ветке');

                    // шаблоном
                    $field = 'cml_category_template';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к названию шаблона, которым отображается страница категории');

                    // число просмотров
                    $field = 'cml_category_browsed';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к числу просмотров страницы');

                    // url
                    $field = 'cml_category_url';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к адресу страницы');

                    // особый url
                    $field = 'cml_category_url_special';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Особый URL"');

                    // яндекс.маркет
                    $field = 'cml_category_ymarket';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Разрешен экспорт в Яндекс.Маркет"');

                    // вконтакте
                    $field = 'cml_category_vkontakte';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Разрешен экспорт ВКонтакте"');

                    // разрешена к показу
                    $field = 'cml_category_enabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Разрешена к показу на сайте"');

                    // выделена визуально
                    $field = 'cml_category_highlighted';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Выделена визуально на клиентской стороне сайта"');

                    // имеет свой блок
                    $field = 'cml_category_own_block';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Имеет свой блок на главной странице сайта"');

                    // информативная страница
                    $field = 'cml_category_informative';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Является информативной страницей (без списка товаров)"');

                    // скрыта от неавторизованных
                    $field = 'cml_category_hidden';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Скрыта от неавторизованных посетителей"');

                    // не для rss
                    $field = 'cml_category_rss_disabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Запрещен экспорт в RSS"');

                    // не для информеров
                    $field = 'cml_category_export_disabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Запрещен экспорт в информеры для трансляции на партнерских сайтах"');

                    // в прайсах
                    $field = 'cml_category_in_prices';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к признаку "Выводить в прайс лист"');

                    // плагины
                    $field = 'cml_category_objects';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к списку плагинов, динамически подключаемых на страницу категории');

                    // узел подкатегории
                    $field = 'cml_category_subitem';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки категорий - путь к узлу подкатегории');

                // узел свойства номенклатуры
                $field = 'cml_property_node';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - узел свойства номенклатуры');

                // узел свойства номенклатуры (еще один возможный вид)
                $field = 'cml_property_node2';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - узел свойства номенклатуры (еще один возможный вид)');

                    // синхронизационный ИД
                    $field = 'cml_property_id';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к синхронизационному ИД');

                    // название группы
                    $field = 'cml_property_group';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к названию группы');

                    // название свойства
                    $field = 'cml_property_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к названию свойства');

                    // разрешено на странице товара
                    $field = 'cml_property_in_product';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к признаку "Разрешено на странице товара"');

                    // разрешено в фильтре
                    $field = 'cml_property_in_filter';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к признаку "Разрешено в фильтре характеристик"');

                    // разрешено на странице сравнения
                    $field = 'cml_property_in_compare';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к признаку "Разрешено на странице сравнения"');

                    // разрешено к показу
                    $field = 'cml_property_enabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к признаку "Разрешено к показу на сайте"');

                    // вес в списке
                    $field = 'cml_property_order_num';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки свойств - путь к позиции свойства среди прочих в списке');

                // узел товара
                $field = 'cml_product_node';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - узел товара');

                    // синхронизационный ИД
                    $field = 'cml_product_id';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к синхронизационному ИД');

                    // ИД категории
                    $field = 'cml_product_category';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к ИД категории');

                    // код производителя (vendorCode)
                    $field = 'cml_product_pcode';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к буквенному коду производителя');

                    // штрих код
                    $field = 'cml_product_barcode';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к штрих коду');

                    // мета заголовок
                    $field = 'cml_product_meta_title';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к мета заголовку');

                    // мета ключевые слова
                    $field = 'cml_product_meta_keywords';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к мета ключевым словам');

                    // мета описание
                    $field = 'cml_product_meta_description';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к мета описанию');

                    // теги
                    $field = 'cml_product_tags';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к тегам');

                    // название товара
                    $field = 'cml_product_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к названию товара');

                    // описание
                    $field = 'cml_product_description';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к описанию');

                    // полное описание
                    $field = 'cml_product_body';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к полному описанию');

                    // seo текст
                    $field = 'cml_product_seo_description';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к SEO тексту');

                    // видео материалы
                    $field = 'cml_product_video';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к видео материалам');

                    // имя субдомена
                    $field = 'cml_product_subdomain';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к имени субдомена');

                    // субдомен разрешен
                    $field = 'cml_product_subdomain_enabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Субдомен разрешен"');

                    // контент субдомена
                    $field = 'cml_product_subdomain_html';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к контенту субдомена');

                    // картинка
                    $field = 'cml_product_image';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку картинок');

                    // название картинки
                    $field = 'cml_product_image_alt';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку названий картинок');

                    // описание картинки
                    $field = 'cml_product_image_text';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку описаний картинок');

                    // разрешена картинка
                    $field = 'cml_product_image_view';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку признаков "Показывать картинку в слайдере"');

                    // файл
                    $field = 'cml_product_file';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку файлов');

                    // название файла
                    $field = 'cml_product_file_alt';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку названий файлов');

                    // описание файла
                    $field = 'cml_product_file_text';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку описаний файлов');

                    // цифровой файл
                    $field = 'cml_product_download';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к файлу цифрового товара');

                    // гарантия
                    $field = 'cml_product_guarantee';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к сроку гарантии');

                    // ожидаемая дата поступления
                    $field = 'cml_product_coming';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к ожидаемой дате поступления в продажу');

                    // узел свойства
                    $field = 'cml_product_property';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к узлу свойства');

                    // название свойства
                    $field = 'cml_product_property_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к названию свойства');

                    // значение свойства
                    $field = 'cml_product_property_value';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к значению свойства');

                    // вес в списке
                    $field = 'cml_product_order_num';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к позиции товара среди прочих в своей категории');

                    // шаблоном
                    $field = 'cml_product_template';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к названию шаблона, которым отображается страница товара');

                    // число просмотров
                    $field = 'cml_product_browsed';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к числу просмотров страницы');

                    // url
                    $field = 'cml_product_url';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к адресу страницы');

                    // особый url
                    $field = 'cml_product_url_special';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Особый URL"');

                    // хит продаж
                    $field = 'cml_product_hit';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Хит продаж"');

                    // новинка
                    $field = 'cml_product_newest';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Новинка"');

                    // акционный
                    $field = 'cml_product_actional';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Акционный"');

                    // скоро в продаже
                    $field = 'cml_product_awaited';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Скоро в продаже"');

                    // яндекс.маркет
                    $field = 'cml_product_ymarket';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Разрешен экспорт в Яндекс.Маркет"');

                    // вконтакте
                    $field = 'cml_product_vkontakte';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Разрешен экспорт ВКонтакте"');

                    // разрешен к показу
                    $field = 'cml_product_enabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Разрешен к показу на сайте"');

                    // выделен визуально
                    $field = 'cml_product_highlighted';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Выделен визуально на клиентской стороне сайта"');

                    // обсуждаемый
                    $field = 'cml_product_commented';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Разрешен к обсуждению"');

                    // скрыт от неавторизованных
                    $field = 'cml_product_hidden';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Скрыт от неавторизованных посетителей"');

                    // не для rss
                    $field = 'cml_product_rss_disabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Запрещен экспорт в RSS"');

                    // не для информеров
                    $field = 'cml_product_export_disabled';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Запрещен экспорт в информеры для трансляции на партнерских сайтах"');

                    // не в кредит
                    $field = 'cml_product_non_creditable';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Запрещен к продаже в кредит"');

                    // снят с производства
                    $field = 'cml_product_non_usable';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Является выставочным экспонатом"');

                    // в прайсах
                    $field = 'cml_product_in_prices';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к признаку "Выводить в прайс лист"');

                    // плагины
                    $field = 'cml_product_objects';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки товаров - путь к списку плагинов, динамически подключаемых на страницу товара');

                // узел варианта товара
                $field = 'cml_variant_node';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - узел варианта товара');

                    // синхронизационный ИД
                    $field = 'cml_variant_id';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к синхронизационному ИД');

                    // артикул
                    $field = 'cml_variant_sku';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к артикулу');

                    // название варианта
                    $field = 'cml_variant_name';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к названию варианта');

                    // количество на складе
                    $field = 'cml_variant_stock';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к количеству на складе');

                    // вес в списке
                    $field = 'cml_variant_position';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к позиции в списке вариантов');

                    // приоритетная скидка
                    $field = 'cml_variant_discount';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к приоритетной скидке');

                    // валюта цен
                    $field = 'cml_variant_currency';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к валюте цен');

                    // цены по группам
                    for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                        $field = 'cml_variant_price' . (($i > 1) ? $i : '');
                        $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к цене для ценовой группы ' . $i);
                    }

                    // старая цена
                    $field = 'cml_variant_old_price';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к старой цене');

                    // акционная цена
                    $field = 'cml_variant_temp_price';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к акционной цене');

                    // дата начала акционной цены
                    $field = 'cml_variant_temp_price_start';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к дате начала акционной цены');

                    // дата конца акционной цены
                    $field = 'cml_variant_temp_price_date';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к дате конца акционной цены');

                    // число участников акционной цены
                    $field = 'cml_variant_temp_price_members';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к числу необходимых участников акционной цены');

                    // число привлеченных участников акционной цены
                    $field = 'cml_variant_temp_price_invited';
                    $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - правила обработки вариантов товара - путь к числу уже привлеченных участников акционной цены');
 
                // сохранять в истории добавления
                $field = 'cml_history_adds_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - история - сохранять ли данные о новых записях');
 
                // сохранять в истории изменения
                $field = 'cml_history_changes_enabled';
                $this->cms->db->settings->saveFromPost($field, 'Синхронизация 1С - история - сохранять ли данные об изменившихся записях');
            }

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
        }



        // ===================================================================
        /**
        *  Запуск сеанса синхронизации
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function startSynchronization () {

            // разрешаем выполнить скрипт до конца (не обращать внимание на возможный разрыв соединения с пользователем),
            // снимаем ограничение на время выполнения скрипта
            @ ignore_user_abort(TRUE);
            @ set_time_limit(0);

            // готовим входные параметры
            $marker = $this->session->getSessionId('DefaultCMLSession');
            $controller = $this->request->getRequest('controller', $marker);
            $type = $this->text->lowerCase($this->request->getRequest('type', ''));
            $mode = $this->text->lowerCase($this->request->getRequest('mode', ''));
            $file = $this->request->getRequest('filename', '');

            // берем папку для выгрузки временных файлов
            $folder = $this->hdd->getDirname(__FILE__) . $this->getUploadFolder();
            $folder = $this->hdd->closeSlash($folder);

            $CRLF = "\r\n";
            $LF = "\n";

            // какой тип информации синхронизируем?
            $type = trim($type);
            switch ($type) {

                // если каталог товаров
                case 'catalog':

                    // какой режим подключения?
                    $mode = trim($mode);
                    switch ($mode) {

                        // если авторизация
                        case 'checkauth':
                            $this->onCatalogCheckauth($marker, $folder);
                            break;

                        // если инициализация
                        case 'init':
                            $this->onCatalogInit($marker, $controller, $folder);
                            break;

                        // если передача файла
                        case 'file':
                            $this->onCatalogFile($marker, $controller, $folder, $file);
                            break;

                        // если разрешение импорта
                        case 'import':
                            $this->onCatalogImport($marker, $controller, $folder, $file);
                            break;

                        // иначе неизвестный режим подключения
                        default:

                            //  если существует метод для такого события
                            $method = $this->asMethodName($mode);
                            if ($method != '') {
                                $method = 'onCatalog' . $method;
                                if ($this->hasMethod($this, $method)) {
                                    $this->$method($marker, $controller, $folder, $file);
                                    break;
                                }
                            }

                            // иначе НЕУДАЧА
                            $answer = 'failure' . $LF;
                            echo $answer;

                            $this->addHistory('неизвестный режим каталога ' . $method . $CRLF
                                            . '- ответ: ' . str_replace($LF, ' ', $answer));
                    }
                    break;

                // если заказы
                case 'sale':

                    // какой режим подключения?
                    $mode = trim($mode);
                    switch ($mode) {

                        // если авторизация
                        case 'checkauth':
                            $this->onSaleCheckauth($marker, $folder);
                            break;

                        // если инициализация
                        case 'init':
                            $this->onSaleInit($marker, $controller, $folder);
                            break;

                        // если передача файла
                        case 'file':
                            $this->onSaleFile($marker, $controller, $folder, $file);
                            break;

                        // если разрешение импорта
                        case 'import':
                            $this->onSaleImport($marker, $controller, $folder, $file);
                            break;

                        // если запрос выгрузки изменений
                        case 'query':
                            $this->onSaleQuery($marker, $controller);
                            break;

                        // если успешное окончание
                        case 'success':
                            $this->onSaleSuccess($marker, $controller, $folder, $file);
                            break;

                        // иначе неизвестный режим подключения
                        default:

                            //  если существует метод для такого события
                            $method = $this->asMethodName($mode);
                            if ($method != '') {
                                $method = 'onSale' . $method;
                                if ($this->hasMethod($this, $method)) {
                                    $this->$method($marker, $controller, $folder, $file);
                                    break;
                                }
                            }

                            // иначе НЕУДАЧА
                            $answer = 'failure' . $LF;
                            echo $answer;

                            $this->addHistory('неизвестный режим заказов ' . $method . $CRLF
                                            . '- ответ: ' . str_replace($LF, ' ', $answer));
                    }
                    break;

                // иначе неизвестный тип
                default:

                    //  если существует метод для такого события
                    $type = $this->asMethodName($type);
                    if ($type != '') {
                        $method = $this->asMethodName($mode);
                        if ($method != '') {
                            $method = 'on' . $type . $method;
                            if ($this->hasMethod($this, $method)) {
                                $this->$method($marker, $controller, $folder, $file);
                                break;
                            }
                        }
                    }

                    // иначе НЕУДАЧА
                    $answer = 'failure' . $LF;
                    echo $answer;

                    $this->addHistory('неизвестный тип запроса ' . $type . $CRLF
                                    . '- ответ: ' . str_replace($LF, ' ', $answer));
            }
        }



        // ===================================================================
        /**
        *  Событие Catalog -> Checkauth (авторизация при синхронизации товаров)
        *
        *  @access  protected
        *  @param   string  $marker     контрольный маркер соединения
        *  @param   string  $folder     папка для выгрузки временных файлов
        *  @return  void
        */
        // ===================================================================

        protected function onCatalogCheckauth ( $marker, $folder ) {

            // отвечаем УСПЕШНО + НАЗНАЧАЕМ КОНТРОЛЬНЫЙ МАРКЕР НА ВСЕ СОЕДИНЕНИЕ
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = 'success' . $LF
                    . 'controller' . $LF
                    . $marker;
            echo $answer;

            $this->addHistory('Catalog Checkauth' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer) . $CRLF
                            . $CRLF
                            . '============================================================');
        }



        // ===================================================================
        /**
        *  Событие Catalog -> Init (инициализация перед синхронизацией товаров)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @return  void
        */
        // ===================================================================

        protected function onCatalogInit ( $marker, $controller, $folder ) {

            // отвечаем НЕ РАБОТАЕМ С ZIP-АРХИВОМ + ПЕРЕДАВАТЬ ФАЙЛЫ ЧАСТЯМИ ПО 64 КБАЙТ
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = 'zip=no' . $LF
                    . 'file_limit=65536' . $LF;
            echo $answer;

            $this->addHistory('Catalog Init (' . $controller . ')' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer));
        }



        // ===================================================================
        /**
        *  Событие Catalog -> File (передача части файла перед синхронизацией товаров)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @param   string  $file           имя файла
        *  @return  void
        */
        // ===================================================================

        protected function onCatalogFile ( $marker, $controller, $folder, $file ) {

            // формируем полное имя файла
            $url = $folder . $this->hdd->safeFilename($marker . '_')
                           . $this->hdd->safeFilename($file);

            // если контрольный маркер совпадает
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = '';
            if ($controller == $marker) {

                // если папка для выгрузки создана или доступна
                if ($this->hdd->createFolder($folder, TRUE, TRUE)) {

                    // добавляем в файл переданную часть
                    if ($this->hdd->appendRawPostToFile($url)) {
                        $answer = 'success' . $LF;
                    }
                }
            }

            // иначе НЕУДАЧА
            if ($answer == '') $answer = 'failure' . $LF;

            echo $answer;

            $this->addHistory('Catalog File (' . $file . ')' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer));
        }



        // ===================================================================
        /**
        *  Событие Catalog -> Import (разрешение синхронизации товаров)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @param   string  $file           имя файла
        *  @return  void
        */
        // ===================================================================

        protected function onCatalogImport ( $marker, $controller, $folder, $file ) {

            // формируем полное имя файла
            $url = $folder . $this->hdd->safeFilename($marker . '_')
                           . $this->hdd->safeFilename($file);

            // если контрольный маркер совпадает
            $CRLF = "\r\n";
            $LF = "\n";
            if ($controller == $marker) {

                $this->addHistory('Catalog Import (' . $file . ') - старт doCatalogImport');

                // обрабатываем принятый файл
                $this->doCatalogImport($url, $file);

            // иначе НЕУДАЧА
            } else {
                $answer = 'failure' . $LF;
                echo $answer;

                $this->addHistory('Catalog Import (' . $file . ')' . $CRLF
                                . '- ответ: ' . str_replace($LF, ' ', $answer));
            }

            // удаляем обработанный файл
            if (!$this->settings->get('cml_store_old_files')) {
                $this->hdd->deleteFile($url);
            } else {
                $url2 = $folder . date('YmdHis') . rand(0, 9) . '_'
                                . $this->hdd->safeFilename($marker . '_')
                                . $this->hdd->safeFilename($file);
                $this->hdd->renameFile($url, $url2);
            }
        }



        // ===================================================================
        /**
        *  Событие Sale -> Checkauth (авторизация при синхронизации заказов)
        *
        *  @access  protected
        *  @param   string  $marker     контрольный маркер соединения
        *  @param   string  $folder     папка для выгрузки временных файлов
        *  @return  void
        */
        // ===================================================================

        protected function onSaleCheckauth ( $marker, $folder ) {

            // отвечаем УСПЕШНО + НАЗНАЧАЕМ КОНТРОЛЬНЫЙ МАРКЕР НА ВСЕ СОЕДИНЕНИЕ
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = 'success' . $LF
                    . 'controller' . $LF
                    . $marker;
            echo $answer;

            $this->addHistory('Sale Checkauth' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer) . $CRLF
                            . $CRLF
                            . '============================================================');
        }



        // ===================================================================
        /**
        *  Событие Sale -> Init (инициализация перед синхронизацией заказов)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @return  void
        */
        // ===================================================================

        protected function onSaleInit ( $marker, $controller, $folder ) {

            // отвечаем НЕ РАБОТАЕМ С ZIP-АРХИВОМ + ПЕРЕДАВАТЬ ФАЙЛЫ ЧАСТЯМИ ПО 64 КБАЙТ
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = 'zip=no' . $LF
                    . 'file_limit=65536' . $LF;
            echo $answer;

            $this->addHistory('Sale Init (' . $controller . ')' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer));
        }



        // ===================================================================
        /**
        *  Событие Sale -> File (передача части файла перед синхронизацией заказов)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @param   string  $file           имя файла
        *  @return  void
        */
        // ===================================================================

        protected function onSaleFile ( $marker, $controller, $folder, $file ) {

            // формируем полное имя файла
            $url = $folder . $this->hdd->safeFilename($marker . '_')
                           . $this->hdd->safeFilename($file);

            // если контрольный маркер совпадает
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = '';
            if ($controller == $marker) {

                // если папка для выгрузки создана или доступна
                if ($this->hdd->createFolder($folder, TRUE, TRUE)) {

                    // добавляем в файл переданную часть
                    if ($this->hdd->appendRawPostToFile($url)) {
                        $answer = 'success' . $LF;
                    }
                }
            }

            // иначе НЕУДАЧА
            if ($answer == '') $answer = 'failure' . $LF;

            echo $answer;

            $this->addHistory('Sale File (' . $file . ')' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer));
        }



        // ===================================================================
        /**
        *  Событие Sale -> Import (разрешение синхронизации заказов)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @param   string  $file           имя файла
        *  @return  void
        */
        // ===================================================================

        protected function onSaleImport ( $marker, $controller, $folder, $file ) {

            // формируем полное имя файла
            $url = $folder . $this->hdd->safeFilename($marker . '_')
                           . $this->hdd->safeFilename($file);

            // если контрольный маркер совпадает
            $CRLF = "\r\n";
            $LF = "\n";
            if ($controller == $marker) {

                $this->addHistory('Sale Import (' . $file . ') - старт doSaleImport');

                // обрабатываем принятый файл
                $this->doSaleImport($url, $file);

            // иначе НЕУДАЧА
            } else {
                $answer = 'failure' . $LF;
                echo $answer;

                $this->addHistory('Sale Import (' . $file . ')' . $CRLF
                                . '- ответ: ' . str_replace($LF, ' ', $answer));
            }

            // удаляем обработанный файл
            if (!$this->settings->get('cml_store_old_files')) {
                $this->hdd->deleteFile($url);
            } else {
                $url2 = $folder . date('YmdHis') . rand(0, 9) . '_'
                                . $this->hdd->safeFilename($marker . '_')
                                . $this->hdd->safeFilename($file);
                $this->hdd->renameFile($url, $url2);
            }
        }



        // ===================================================================
        /**
        *  Событие Sale -> Query (запрос выгрузки изменений в заказах)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @return  void
        */
        // ===================================================================

        protected function onSaleQuery ( $marker, $controller ) {

            // если контрольный маркер совпадает
            if ($controller == $marker) {

                $this->addHistory('Sale Query (' . $controller . ') - старт doSaleQuery');

                // выгружаем изменившиеся заказы
                $this->doSaleQuery();
            }
        }



        // ===================================================================
        /**
        *  Событие Sale -> Success (успешное окончание синхронизации заказов)
        *
        *  @access  protected
        *  @param   string  $marker         контрольный маркер соединения
        *  @param   string  $controller     маркер, сообщенный в запросе соединения
        *  @param   string  $folder         папка для выгрузки временных файлов
        *  @param   string  $file           имя файла
        *  @return  void
        */
        // ===================================================================

        protected function onSaleSuccess ( $marker, $controller, $folder, $file ) {
            $CRLF = "\r\n";
            $this->addHistory('Sale Success (' . $controller . ')' . $CRLF
                            . '- ответ: пустая строка');
        }



        // ===================================================================
        /**
        *  Выполнение синхронизации товаров
        *
        *  Метод вызывается из события Catalog -> Import, когда удостоверились,
        *  что соединение валидно.
        *
        *  @access  protected
        *  @param   string  $file       полное имя обрабатываемого файла
        *  @param   string  $filename   исходное имя файла
        *  @return  void
        */
        // ===================================================================

        protected function doCatalogImport ( $file, $filename ) {

            $CRLF = "\r\n";
            $LF = "\n";
            $count = 0;
            $data = new stdClass;
                $data->total_categories = 0;
                $data->changed_categories = 0;
                $data->added_categories = 0;
                $data->error_categories = 0;
                $data->info_categories = '';

                $data->total_properties = 0;
                $data->changed_properties = 0;
                $data->added_properties = 0;
                $data->error_properties = 0;
                $data->info_properties = '';

                $data->total_products = 0;
                $data->changed_products = 0;
                $data->added_products = 0;
                $data->error_products = 0;
                $data->info_products = '';

                $data->total_variants = 0;
                $data->changed_variants = 0;
                $data->added_variants = 0;
                $data->error_variants = 0;
                $data->info_variants = '';

            switch (strtolower($filename)) {

                // если категории, товары, свойства
                case 'import.xml':
                    $cats_ok = $this->settings->get('cml_categories_import_enabled');
                    $prods_ok = $this->settings->get('cml_products_import_enabled');
                    $props_ok = $this->settings->get('cml_properties_import_enabled');

                    // категории
                    if ($cats_ok || $prods_ok || $props_ok) {
                        $count = $this->xml->scanFileNodes($file,
                                                           $this->settings->get('cml_category_node', ''),
                                                           TRUE,
                                                           array($this, 'importCategory'),
                                                           $data);

                        // очищаем кеш-таблицы категорий
                        if ($data->changed_categories != 0 || $data->added_categories != 0) {
                            $this->cms->db->reset_categories_caches();

                            // очищаем кеш-таблицы товаров
                            $this->cms->db->products->resetCaches();
                        }
                    }

                    // свойства
                    if ($prods_ok || $props_ok) {
                        $this->xml->scanFileNodes($file,
                                                  $this->settings->get('cml_property_node', ''),
                                                  TRUE,
                                                  array($this, 'importProperty'),
                                                  $data);

                        // может свойства заданы в других узлах?
                        if ($data->total_properties == 0) {
                            $this->xml->scanFileNodes($file,
                                                      $this->settings->get('cml_property_node2', ''),
                                                      TRUE,
                                                      array($this, 'importProperty'),
                                                      $data);
                        }

                        // очищаем кеш-таблицы свойств
                        if ($data->changed_properties != 0 || $data->added_properties != 0) {
                            $this->cms->db->reset_properties_caches();
                        }
                    }

                    // товары
                    if ($prods_ok || $props_ok) {
                        $this->xml->scanFileNodes($file,
                                                  $this->settings->get('cml_product_node', ''),
                                                  TRUE,
                                                  array($this, 'importProduct'),
                                                  $data);

                        // очищаем кеш-таблицы товаров
                        if ($data->changed_products != 0 || $data->added_products != 0) {
                            $this->cms->db->products->resetCaches();
                        }
                    }

                    // ответ
                    $answer = 'success' . $LF;
                    echo $answer;

                    $this->addHistory('doCatalogImport(' . $filename . ')' . $CRLF
                                    . '- ответ: ' . str_replace($LF, ' ', $answer) . $CRLF
                                    . $CRLF
                                    . '- считано ' . $count . ' корневых категорий (с вложенными всего ' . $data->total_categories . ' шт.)' . $CRLF
                                    . ($cats_ok ? '- пропущено ' . $data->error_categories . ' из-за ошибок обработки' . $CRLF
                                                . '- обновлено ' . $data->changed_categories . ' существовавших категорий' . $CRLF
                                                . '- добавлено ' . $data->added_categories . ' новых категорий' . $CRLF
                                                . ($data->info_categories != '' ? $CRLF . trim($data->info_categories) . $CRLF : '')
                                                : '- не обрабатывались согласно настройкам' . $CRLF)
                                    . $CRLF
                                    . '- считано ' . $data->total_properties . ' свойств' . $CRLF
                                    . ($props_ok ? '- пропущено ' . $data->error_properties . ' из-за ошибок обработки' . $CRLF
                                                 . '- обновлено ' . $data->changed_properties . ' существовавших свойств' . $CRLF
                                                 . '- добавлено ' . $data->added_properties . ' новых свойств' . $CRLF
                                                 . ($data->info_properties != '' ? $CRLF . trim($data->info_properties) . $CRLF : '')
                                                 : '- не обрабатывались согласно настройкам' . $CRLF)
                                    . $CRLF
                                    . '- считано ' . $data->total_products . ' товаров' . $CRLF
                                    . ($prods_ok ? '- пропущено ' . $data->error_products . ' из-за ошибок обработки' . $CRLF
                                                 . '- обновлено ' . $data->changed_products . ' существовавших товаров' . $CRLF
                                                 . '- добавлено ' . $data->added_products . ' новых товаров' . $CRLF
                                                 . ($data->info_products != '' ? $CRLF . trim($data->info_products) : '')
                                                 : '- не обрабатывались согласно настройкам'));
                    break;

                // если варианты товаров
                case 'offers.xml':
                    $prods_ok = $this->settings->get('cml_variants_import_enabled');

                    // варианты
                    if ($prods_ok) {
                        $this->xml->scanFileNodes($file,
                                                  $this->settings->get('cml_variant_node', ''),
                                                  TRUE,
                                                  array($this, 'importVariant'),
                                                  $data);

                        // очищаем кеш-таблицы товаров
                        if ($data->changed_variants != 0 || $data->added_variants != 0) {
                            $this->cms->db->products->resetCaches();
                        }
                    }

                    // ответ
                    $answer = 'success' . $LF;
                    echo $answer;

                    $this->addHistory('doCatalogImport(' . $filename . ')' . $CRLF
                                    . '- ответ: ' . str_replace($LF, ' ', $answer) . $CRLF
                                    . $CRLF
                                    . '- считано ' . $data->total_variants . ' вариантов товара' . $CRLF
                                    . ($prods_ok ? '- пропущено ' . $data->error_variants . ' из-за ошибок обработки' . $CRLF
                                                 . '- обновлено ' . $data->changed_variants . ' существовавших вариантов' . $CRLF
                                                 . '- добавлено ' . $data->added_variants . ' новых вариантов' . $CRLF
                                                 . ($data->info_variants != '' ? $CRLF . trim($data->info_variants) : '')
                                                 : '- не обрабатывались согласно настройкам'));
                    break;

                // иначе неизвестный файл
                default:
                    $answer = 'failure' . $LF;
                    echo $answer;

                    $this->addHistory('doCatalogImport(' . $filename . ')' . $CRLF
                                    . '- ответ: ' . str_replace($LF, ' ', $answer));
            }
        }



        // ===================================================================
        /**
        *  Выполнение синхронизации заказов
        *
        *  Метод вызывается из события Sale -> Import, когда удостоверились,
        *  что соединение валидно.
        *
        *  @access  protected
        *  @param   string  $file       полное имя обрабатываемого файла
        *  @param   string  $filename   исходное имя файла
        *  @return  void
        */
        // ===================================================================

        protected function doSaleImport ( $file, $filename ) {
            $CRLF = "\r\n";
            $LF = "\n";
            $answer = 'success' . $LF;
            echo $answer;

            $this->addHistory('doSaleImport(' . $filename . ')' . $CRLF
                            . '- ответ: ' . str_replace($LF, ' ', $answer));
        }



        // ===================================================================
        /**
        *  Выполнение запроса выгрузки изменившихся заказов
        *
        *  Метод вызывается из события Sale -> Query, когда удостоверились,
        *  что соединение валидно.
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function doSaleQuery ( ) {

            // ответ будет в формате UTF-8
            @ header('Content-type: text/xml; charset=UTF-8');

            // отправляем BOM (маркер начала, так как ответ содержит русскоязычные символы)
            echo "\xEF\xBB\xBF";

            // отправляем ответ
            $CRLF = "\r\n";
            echo '<?xml version="1.0" encoding="utf-8" ?>' . $CRLF
               . '    <КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date('Y-m-d')  . '">' . $CRLF
               . '    </КоммерческаяИнформация>' . $CRLF;

            $this->addHistory('doSaleQuery()' . $CRLF
                            . '- ответ: xml с заказами');
        }



        // ===================================================================
        /**
        *  Импорт категории
        *
        *  Метод вызывается (последовательно для каждой категории) из
        *  метода doCatalogImport во время импорта файла import.xml.
        *
        *  @access  public
        *  @param   string  $xml            XML-ветка сведений о категории
        *  @param   mixed   $data           внешние данные
        *                                       ->total_categories = счетчик записей
        *                                       ->changed_categories = счетчик изменившихся записей
        *                                       ->added_categories = счетчик новых записей
        *                                       ->error_categories = счетчик ошибок
        *                                       ->info_categories = подробности
        *  @param   integer $parent_cid     ИД родительской категории
        *  @param   string  $parent_url     URL родительской категории (например "computers/notebooks/",
        *                                   клеится в новых категориях, когда не задан URL)
        *  @param   string  $parent_path    строка пути категории (например "Компьютеры / Ноутбуки /",
        *                                   используется при информировании о новых категориях)
        *  @return  void
        */
        // ===================================================================

        public function importCategory ( $xml, & $data, $parent_cid = 0, $parent_url = '', $parent_path = '' ) {
            $CRLF = "\r\n";
            $site = strtolower($this->cms->site_url);
            $site_len = strlen($site);

            if (!is_object($data)) $data = new stdClass;
            if (!isset($data->total_categories)) $data->total_categories = 0;
            if (!isset($data->changed_categories)) $data->changed_categories = 0;
            if (!isset($data->added_categories)) $data->added_categories = 0;
            if (!isset($data->error_categories)) $data->error_categories = 0;
            if (!isset($data->info_categories)) $data->info_categories = '';
            $data->total_categories++;

            // импорт реальный или виртуальный (для сбора ИДов категорий)
            $actual = $this->settings->get('cml_categories_import_enabled');

            // синхронизационный ИД категории
            $param = $this->settings->get('cml_category_id', '');
            $id = $this->xml->getSimpleXMLElementNode($xml, $param);
            $cid = explode('#', $id, 2);
            $cid = isset($cid[0]) ? trim($cid[0]) : '';
            if ($cid == '') {
                if ($actual) {
                    $data->error_categories++;
                    $data->info_categories .= 'Недоступен ИД категории [' . $id . ']' . $CRLF;
                }
            } else {
                $id = $cid;

                // извлекаем старую категорию по синхро ИД
                $query = 'SELECT * '
                       . 'FROM `' . DATABASE_CATEGORIES_TABLENAME . '` '
                       . 'WHERE `sync_id` = \'' .  $this->cms->db->query_value($cid) . '\' '
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $old = $this->cms->db->fetch_object($result);
                $this->cms->db->free_result($result);
                $cid = isset($old->category_id) ? $old->category_id : 0;

                // если нет, тогда может по ИД
                if (empty($cid)) {
                    if (preg_replace('/[^0-9]/', '', $id) == $id) {
                        $query = 'SELECT * '
                               . 'FROM `' . DATABASE_CATEGORIES_TABLENAME . '` '
                               . 'WHERE `category_id` = \'' .  $this->cms->db->query_value($id) . '\' '
                                     . 'AND `sync_id` = \'\' '
                               . 'LIMIT 1;';
                        $result = $this->cms->db->query($query);
                        $old = $this->cms->db->fetch_object($result);
                        $this->cms->db->free_result($result);
                        $cid = isset($old->category_id) ? $old->category_id : 0;
                    }
                }

                // готовим новую категорию
                $category = new stdClass;

                // название
                $param = $this->settings->get('cml_category_name', '');
                if ($param != '') {
                    $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                    if ($v !== FALSE) {
                        $v = $this->valueAsString($v);
                        if ($v == '') $v = 'Без названия!';
                        $category->name = $v;
                    }
                }

                // если старую не извлекли, тогда может по названию и родителю
                if (empty($cid)) {
                    if (isset($category->name)) {
                        $query = 'SELECT * '
                               . 'FROM `' . DATABASE_CATEGORIES_TABLENAME . '` '
                               . 'WHERE `parent` = \'' . $this->cms->db->query_value($parent_cid) . '\' '
                                     . 'AND `sync_id` = \'\' '
                                     . 'AND TRIM(REPLACE(`name`, \'  \', \' \')) = \'' .  $this->cms->db->query_value($category->name) . '\' '
                               . 'LIMIT 1;';
                        $result = $this->cms->db->query($query);
                        $old = $this->cms->db->fetch_object($result);
                        $this->cms->db->free_result($result);
                        $cid = isset($old->category_id) ? $old->category_id : 0;
                    }
                }

                // ожидаемое название
                $name = isset($category->name) ? $category->name
                                               : (isset($old->name) ? trim($old->name) : '');
                if ($name == '') $name = 'Без названия!';

                // если это не виртуальный импорт категорий
                if ($actual) {

                    // url
                    $param = $this->settings->get('cml_category_url', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) {
                            $v = $this->valueAsString($v);
                            if (strtolower(substr($v, 0, $site_len)) == $site) $v = substr($v, $site_len);
                            if (strtolower(substr($v, 0, 8)) == 'catalog/') $v = substr($v, 8);
                            if ($v != '') $category->url = $v;
                        }
                    }

                    // особый url
                    $param = $this->settings->get('cml_category_url_special', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->url_special = $this->valueAsFlag($v);
                    }

                    // мета заголовок
                    $param = $this->settings->get('cml_category_meta_title', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->meta_title = $this->valueAsString($v);
                    }

                    // мета ключевые слова
                    $param = $this->settings->get('cml_category_meta_keywords', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->meta_keywords = $this->valueAsString($v);
                    }

                    // мета описание
                    $param = $this->settings->get('cml_category_meta_description', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->meta_description = $this->valueAsString($v);
                    }

                    // теги
                    $param = $this->settings->get('cml_category_tags', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->tags = $this->valueAsString($v);
                    }

                    // название в единственном числе
                    $param = $this->settings->get('cml_category_single_name', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->single_name = $this->valueAsString($v);
                    }

                    // название в конфигураторе
                    $param = $this->settings->get('cml_category_configurator_name', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->configurator_name = $this->valueAsString($v);
                    }

                    // описание
                    $param = $this->settings->get('cml_category_description', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->description = $this->valueAsString($v);
                    }

                    // seo текст
                    $param = $this->settings->get('cml_category_seo_description', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->seo_description = $this->valueAsString($v);
                    }

                    // субдомен
                    $param = $this->settings->get('cml_category_subdomain', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->subdomain = $this->valueAsString($v);
                    }

                    // субдомен разрешен
                    $param = $this->settings->get('cml_category_subdomain_enabled', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->subdomain_enabled = $this->valueAsFlag($v);
                    }

                    // контент субдомена
                    $param = $this->settings->get('cml_category_subdomain_html', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->subdomain_html = $this->valueAsString($v);
                    }

                    // картинка = cml_category_image
                    // название = cml_category_image_alt
                    // описание = cml_category_image_text
                    // в слайдере = cml_category_image_view

                    // позиция в списке
                    $param = $this->settings->get('cml_category_order_num', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->order_num = $this->valueAsInteger($v);
                    }

                    // шаблоном
                    $param = $this->settings->get('cml_category_template', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->template = $this->valueAsString($v);
                    }

                    // число просмотров
                    $param = $this->settings->get('cml_category_browsed', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->browsed = $this->valueAsNatural($v);
                    }

                    // яндекс.маркет (признак 32-битный по биту на канал)
                    $param = $this->settings->get('cml_category_ymarket', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->ymarket = $this->valueAsString($v);
                    }

                    // вконтакте
                    $param = $this->settings->get('cml_category_vkontakte', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->vkontakte = $this->valueAsFlag($v);
                    }

                    // разрешена к показу
                    $param = $this->settings->get('cml_category_enabled', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->enabled = $this->valueAsFlag($v);
                    }

                    // выделена визуально
                    $param = $this->settings->get('cml_category_highlighted', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->highlighted = $this->valueAsFlag($v);
                    }

                    // имеет свой блок
                    $param = $this->settings->get('cml_category_own_block', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->own_block = $this->valueAsFlag($v);
                    }

                    // информативная
                    $param = $this->settings->get('cml_category_informative', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->informative = $this->valueAsFlag($v);
                    }

                    // скрыта от неавторизованных
                    $param = $this->settings->get('cml_category_hidden', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->hidden = $this->valueAsFlag($v);
                    }

                    // не для rss
                    $param = $this->settings->get('cml_category_rss_disabled', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->rss_disabled = $this->valueAsFlag($v);
                    }

                    // не для информеров
                    $param = $this->settings->get('cml_category_export_disabled', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->export_disabled = $this->valueAsFlag($v);
                    }

                    // в прайсах (признак 8-битный по биту на прайс)
                    $param = $this->settings->get('cml_category_in_prices', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->in_prices = $this->valueAsNatural($v, 0, 255);
                    }

                    // плагины
                    $param = $this->settings->get('cml_category_objects', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $category->objects = $this->valueAsString($v);
                    }

                    // ИДы категории
                    $category->sync_id = $id;
                    $category->parent = $parent_cid;
                    if (empty($cid)) {
                        $category->created = time();
                    } else {
                        $category->category_id = $cid;
                    }

                    // никаких технических полей
                    $category->indifferent_caches = TRUE;

                    // обновляем только при наличии изменений
                    $fields = '';
                    $ok = empty($cid);
                    if (!$ok) {
                        foreach ($old as $i => $v) {
                            $v = isset($category->$i) && $category->$i != $v;
                            if ($v) $fields .= ', ' . $i;
                            $ok = $ok || $v;
                        }
                    }
                    if ($ok) {
                        if (empty($cid)) {
                            if (isset($category->name)) {
                                if (!isset($category->meta_title)) $category->meta_title = $category->name;
                                if (!isset($category->meta_description)) $category->meta_description = $category->name;
                                if (!isset($category->url)) {
                                    $v = $this->text->translitText($category->name, 'ru');
                                    $v = preg_replace('/[^a-z0-9\.]+/i', '-', $v);
                                    $v = trim($v, '-');
                                    if ($v != '') $category->url = $parent_url . $v;
                                }
                            } else {
                                $category->name = 'Без названия!';
                            }
                        } else {
                            $category->modified = time();
                        }
                        $cid = $this->cms->db->categories->update($category);
                        if (empty($cid)) {
                            $data->error_categories++;
                            $data->info_categories .= 'Не удалось создать категорию [sync_id = ' . $id . ']' . $CRLF;
                        } else {
                            if (is_object($old)) {
                                $data->changed_categories++;
                                if ($this->settings->get('cml_history_changes_enabled')) {
                                    $data->info_categories .= 'изменено [' . $parent_path . $name . '] в полях [' . ltrim($fields, ', ') . ']' . $CRLF;
                                }
                            } else {
                                $data->added_categories++;
                                if ($this->settings->get('cml_history_adds_enabled')) {
                                    $data->info_categories .= '+ категория [' . $parent_path . $name . ']' . $CRLF;
                                }
                            }
                        }
                    }
                }

                // запоминаем ИД категории
                if (!empty($cid)) {
                    $param = 'cml_categories';
                    if (!isset($_SESSION[$param]) || !is_array($_SESSION[$param])) $_SESSION[$param] = array();
                    $_SESSION[$param][$id] = $cid;

                    // подкатегории
                    $param = $this->settings->get('cml_category_subitem', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE, FALSE);
                        if ($v !== FALSE) {
                            $url = isset($category->url) ? $category->url
                                                         : (isset($old->url) ? $old->url
                                                                             : '');
                            $url = str_replace('\\', '/', $url);
                            $url = preg_replace('!^[a-z]+://[^/]+/(catalog/)?!i', '', trim($url));
                            $url = preg_replace('!\?.*$!', '', $url);
                            $url = preg_replace('!#.*$!', '', $url);
                            $url = preg_replace('/[\s_\-]+/', '-', $url);
                            $url = trim($url, '/-.');
                            if ($url == '') $url = $cid;
                            $url .= '/';

                            $path = $parent_path . $name . ' / ';

                            foreach ($v as $sub) {
                                $this->importCategory($sub, $data, $cid, $url, $path);
                            }
                        }
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Импорт свойства номенклатуры
        *
        *  Метод вызывается (последовательно для каждого свойства номенклатуры) из
        *  метода doCatalogImport во время импорта файла import.xml.
        *
        *  @access  public
        *  @param   string  $xml            XML-ветка сведений о свойстве
        *  @param   mixed   $data           внешние данные
        *                                       ->total_properties = счетчик записей
        *                                       ->changed_properties = счетчик изменившихся записей
        *                                       ->added_properties = счетчик новых записей
        *                                       ->error_properties = счетчик ошибок
        *                                       ->info_properties = подробности
        *  @return  void
        */
        // ===================================================================

        public function importProperty ( $xml, & $data ) {
            $CRLF = "\r\n";

            if (!is_object($data)) $data = new stdClass;
            if (!isset($data->total_properties)) $data->total_properties = 0;
            if (!isset($data->changed_properties)) $data->changed_properties = 0;
            if (!isset($data->added_properties)) $data->added_properties = 0;
            if (!isset($data->error_properties)) $data->error_properties = 0;
            if (!isset($data->info_properties)) $data->info_properties = '';
            $data->total_properties++;

            // импорт реальный или виртуальный (для сбора ИДов свойств)
            $actual = $this->settings->get('cml_properties_import_enabled');

            // синхронизационный ИД свойства
            $param = $this->settings->get('cml_property_id', '');
            $id = $this->xml->getSimpleXMLElementNode($xml, $param);
            $pid = explode('#', $id, 2);
            $pid = isset($pid[0]) ? trim($pid[0]) : '';
            if ($pid == '') {
                if ($actual) {
                    $data->error_properties++;
                    $data->info_properties .= 'Недоступен ИД свойства [' . $id . ']' . $CRLF;
                }
            } else {
                $id = $pid;

                // готовим новое свойство
                $property = new stdClass;

                // группа
                $param = $this->settings->get('cml_property_group', '');
                if ($param != '') {
                    $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                    if ($v !== FALSE) $property->group = $this->valueAsString($v);
                }

                // название
                $param = $this->settings->get('cml_property_name', '');
                if ($param != '') {
                    $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                    if ($v !== FALSE) {
                        $v = $this->valueAsString($v);
                        if ($v == '') $v = 'Без названия!';
                        $property->name = $v;
                    }
                }

                // если свойство указывает на бренд
                if (isset($property->name) && $property->name == 'Производитель'
                && (!isset($property->group) || $property->group == '')) {

                    // запоминаем ИД бренда
                    $param = 'cml_brands';
                    if (!isset($_SESSION[$param]) || !is_array($_SESSION[$param])) $_SESSION[$param] = array();
                    $_SESSION[$param][$id] = $pid;
                } else {

                    // извлекаем старое свойство по синхро ИД
                    $query = 'SELECT * '
                           . 'FROM `' . DATABASE_PROPERTIES_TABLENAME . '` '
                           . 'WHERE `sync_id` = \'' .  $this->cms->db->query_value($pid) . '\' '
                           . 'LIMIT 1;';
                    $result = $this->cms->db->query($query);
                    $old = $this->cms->db->fetch_object($result);
                    $this->cms->db->free_result($result);
                    $pid = isset($old->property_id) ? $old->property_id : 0;

                    // если нет, тогда может по ИД
                    if (empty($pid)) {
                        if (preg_replace('/[^0-9]/', '', $id) == $id) {
                            $query = 'SELECT * '
                                   . 'FROM `' . DATABASE_PROPERTIES_TABLENAME . '` '
                                   . 'WHERE `property_id` = \'' .  $this->cms->db->query_value($id) . '\' '
                                         . 'AND `sync_id` = \'\' '
                                   . 'LIMIT 1;';
                            $result = $this->cms->db->query($query);
                            $old = $this->cms->db->fetch_object($result);
                            $this->cms->db->free_result($result);
                            $pid = isset($old->property_id) ? $old->property_id : 0;
                        }
                    }

                    // если старое не извлекли, тогда может по группе и названию
                    if (empty($pid)) {
                        if (isset($property->name)) {
                            $query = 'SELECT * '
                                   . 'FROM `' . DATABASE_PROPERTIES_TABLENAME . '` '
                                   . 'WHERE `sync_id` = \'\' '
                                         . 'AND TRIM(REPLACE(`name`, \'  \', \' \')) = \'' .  $this->cms->db->query_value($property->name) . '\' '
                                         . 'AND TRIM(REPLACE(`group`, \'  \', \' \')) = \'' .  (isset($property->group) ? $this->cms->db->query_value($property->group) : '') . '\' '
                                   . 'LIMIT 1;';
                            $result = $this->cms->db->query($query);
                            $old = $this->cms->db->fetch_object($result);
                            $this->cms->db->free_result($result);
                            $pid = isset($old->property_id) ? $old->property_id : 0;
                        }
                    }

                    // ожидаемое название
                    $name = isset($property->name) ? $property->name
                                                   : (isset($old->name) ? trim($old->name) : '');
                    if ($name == '') $name = 'Без названия!';

                    // если это не виртуальный импорт свойств
                    if ($actual) {

                        // разрешено в товаре
                        $param = $this->settings->get('cml_property_in_product', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $property->in_product = $this->valueAsFlag($v);
                        }

                        // разрешено в фильтре
                        $param = $this->settings->get('cml_property_in_filter', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $property->in_filter = $this->valueAsFlag($v);
                        }

                        // разрешено в сравнении
                        $param = $this->settings->get('cml_property_in_compare', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $property->in_compare = $this->valueAsFlag($v);
                        }

                        // разрешено к показу
                        $param = $this->settings->get('cml_property_enabled', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $property->enabled = $this->valueAsFlag($v);
                        }

                        // позиция в списке
                        $param = $this->settings->get('cml_property_order_num', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $property->order_num = $this->valueAsInteger($v);
                        }

                        // ИДы свойства
                        $property->sync_id = $id;
                        if (empty($pid)) {
                            $property->created = time();
                        } else {
                            $property->property_id = $pid;
                        }

                        // никаких технических полей
                        if (isset($property->options)) unset($property->options);
                        if (isset($property->categories)) unset($property->categories);
                        if (isset($property->brands)) unset($property->brands);
                        $property->indifferent_caches = TRUE;

                        // обновляем только при наличии изменений
                        $fields = '';
                        $ok = empty($pid);
                        if (!$ok) {
                            foreach ($old as $i => $v) {
                                $v = isset($property->$i) && $property->$i != $v;
                                if ($v) $fields .= ', ' . $i;
                                $ok = $ok || $v;
                            }
                        }
                        if ($ok) {
                            if (empty($pid)) {
                                if (!isset($property->name)) {
                                    $property->name = 'Без названия!';
                                }
                            } else {
                                $property->modified = time();
                            }
                            $pid = $this->cms->db->update_property($property);
                            if (empty($pid)) {
                                $data->error_properties++;
                                $data->info_properties .= 'Не удалось создать свойство [sync_id = ' . $id . ']' . $CRLF;
                            } else {
                                if (is_object($old)) {
                                    $data->changed_properties++;
                                    if ($this->settings->get('cml_history_changes_enabled')) {
                                        $data->info_properties .= 'изменено [' . $name . '] в полях [' . ltrim($fields, ', ') . ']' . $CRLF;
                                    }
                                } else {
                                    $data->added_properties++;
                                    if ($this->settings->get('cml_history_adds_enabled')) {
                                        $data->info_properties .= '+ свойство [' . $name . ']' . $CRLF;
                                    }
                                }
                            }
                        }
                    }

                    // запоминаем ИД свойства
                    if (!empty($pid)) {
                        $param = 'cml_properties';
                        if (!isset($_SESSION[$param]) || !is_array($_SESSION[$param])) $_SESSION[$param] = array();
                        $_SESSION[$param][$id] = $pid;
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Импорт товара
        *
        *  Метод вызывается (последовательно для каждого товара) из
        *  метода doCatalogImport во время импорта файла import.xml.
        *
        *  @access  public
        *  @param   string  $xml            XML-ветка сведений о товаре
        *  @param   mixed   $data           внешние данные
        *                                       ->total_products = счетчик записей
        *                                       ->changed_products = счетчик изменившихся записей
        *                                       ->added_products = счетчик новых записей
        *                                       ->error_products = счетчик ошибок
        *                                       ->info_products = подробности
        *  @return  void
        */
        // ===================================================================

        public function importProduct ( $xml, & $data ) {
            $CRLF = "\r\n";
            $site = strtolower($this->cms->site_url);
            $site_len = strlen($site);

            if (!is_object($data)) $data = new stdClass;
            if (!isset($data->total_products)) $data->total_products = 0;
            if (!isset($data->changed_products)) $data->changed_products = 0;
            if (!isset($data->added_products)) $data->added_products = 0;
            if (!isset($data->error_products)) $data->error_products = 0;
            if (!isset($data->info_products)) $data->info_products = '';
            $data->total_products++;

            // импорт реальный или виртуальный (для сбора свойств)
            $actual = $this->settings->get('cml_products_import_enabled');

            // синхронизационные ИД товара и варианта
            $param = $this->settings->get('cml_product_id', '');
            $id = $this->xml->getSimpleXMLElementNode($xml, $param);
            $vid = explode('#', $id, 3);
            $pid = isset($vid[0]) ? trim($vid[0]) : '';
            if ($pid == '') {
                if ($actual) {
                    $data->error_products++;
                    $data->info_products .= 'Недоступен ИД товара [' . $id . ']' . $CRLF;
                }
            } else {
                $id = $pid;
                $vid = isset($vid[1]) ? trim($vid[1]) : '';

                // ИД категории
                $cid = FALSE;
                $v = FALSE;
                $param = $this->settings->get('cml_product_category', '');
                if ($param != '') {
                    $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                    if ($v !== FALSE) {
                        $v = $this->valueAsString($v);
                        $param = 'cml_categories';
                        $cid = isset($_SESSION[$param][$v]) ? $_SESSION[$param][$v] : FALSE;
                    }
                }
                if ($v === FALSE || empty($cid)) {
                    if ($actual) {
                        $data->error_products++;
                        if ($v === FALSE) {
                            $data->info_products .= 'Товар [' . $id . '] вне категорий' . $CRLF;
                        } else {
                            $data->info_products .= 'Товар [' . $id . '] из несуществующей категории [' . $v . ']' . $CRLF;
                        }
                    }
                } else {

                    // извлекаем старый товар по синхро ИД
                    $query = 'SELECT * '
                           . 'FROM `' . DATABASE_PRODUCTS_TABLENAME . '` '
                           . 'WHERE `sync_id` = \'' .  $this->cms->db->query_value($pid) . '\' '
                           . 'LIMIT 1;';
                    $result = $this->cms->db->query($query);
                    $old = $this->cms->db->fetch_object($result);
                    $this->cms->db->free_result($result);
                    $pid = isset($old->product_id) ? $old->product_id : 0;

                    // если нет, тогда может по ИД
                    if (empty($pid)) {
                        if (preg_replace('/[^0-9]/', '', $id) == $id) {
                            $query = 'SELECT * '
                                   . 'FROM `' . DATABASE_PRODUCTS_TABLENAME . '` '
                                   . 'WHERE `product_id` = \'' .  $this->cms->db->query_value($id) . '\' '
                                         . 'AND `sync_id` = \'\' '
                                   . 'LIMIT 1;';
                            $result = $this->cms->db->query($query);
                            $old = $this->cms->db->fetch_object($result);
                            $this->cms->db->free_result($result);
                            $pid = isset($old->product_id) ? $old->product_id : 0;
                        }
                    }

                    // готовим новый товар
                    $product = new stdClass;

                    // название
                    $param = $this->settings->get('cml_product_name', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) {
                            $v = $this->valueAsString($v);
                            if ($v == '') $v = 'Без названия!';
                            $product->model = $v;
                        }
                    }

                    // если старый не извлекли, тогда может по названию и родителю
                    if (empty($pid)) {
                        if (isset($product->model)) {
                            $query = 'SELECT * '
                                   . 'FROM `' . DATABASE_PRODUCTS_TABLENAME . '` '
                                   . 'WHERE `category_id` = \'' . $this->cms->db->query_value($cid) . '\' '
                                         . 'AND `sync_id` = \'\' '
                                         . 'AND TRIM(REPLACE(`model`, \'  \', \' \')) = \'' .  $this->cms->db->query_value($product->model) . '\' '
                                   . 'LIMIT 1;';
                            $result = $this->cms->db->query($query);
                            $old = $this->cms->db->fetch_object($result);
                            $this->cms->db->free_result($result);
                            $pid = isset($old->product_id) ? $old->product_id : 0;
                        }
                    }

                    // ожидаемое название
                    $name = isset($product->model) ? $product->model
                                                   : (isset($old->model) ? trim($old->model) : '');
                    if ($name == '') $name = 'Без названия!';

                    // если это не виртуальный импорт товаров
                    if ($actual) {

                        // url
                        $param = $this->settings->get('cml_product_url', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) {
                                $v = $this->valueAsString($v);
                                if (strtolower(substr($v, 0, $site_len)) == $site) $v = substr($v, $site_len);
                                if (strtolower(substr($v, 0, 9)) == 'products/') $v = substr($v, 9);
                                if ($v != '') $product->url = $v;
                            }
                        }

                        // особый url
                        $param = $this->settings->get('cml_product_url_special', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->url_special = $this->valueAsFlag($v);
                        }

                        // код производителя
                        $param = $this->settings->get('cml_product_pcode', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->pcode = $this->valueAsString($v);
                        }

                        // штрих код
                        $param = $this->settings->get('cml_product_barcode', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->barcode = $this->valueAsString($v);
                        }

                        // мета заголовок
                        $param = $this->settings->get('cml_product_meta_title', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->meta_title = $this->valueAsString($v);
                        }

                        // мета ключевые слова
                        $param = $this->settings->get('cml_product_meta_keywords', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->meta_keywords = $this->valueAsString($v);
                        }

                        // мета описание
                        $param = $this->settings->get('cml_product_meta_description', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->meta_description = $this->valueAsString($v);
                        }

                        // теги
                        $param = $this->settings->get('cml_product_tags', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->tags = $this->valueAsString($v);
                        }

                        // описание
                        $param = $this->settings->get('cml_product_description', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->description = $this->valueAsString($v);
                        }

                        // полное описание
                        $param = $this->settings->get('cml_product_body', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->body = $this->valueAsString($v);
                        }

                        // seo текст
                        $param = $this->settings->get('cml_product_seo_description', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->seo_description = $this->valueAsString($v);
                        }

                        // видео материалы
                        $param = $this->settings->get('cml_product_video', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->video = $this->valueAsString($v);
                        }

                        // субдомен
                        $param = $this->settings->get('cml_product_subdomain', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->subdomain = $this->valueAsString($v);
                        }

                        // субдомен разрешен
                        $param = $this->settings->get('cml_product_subdomain_enabled', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->subdomain_enabled = $this->valueAsFlag($v);
                        }

                        // контент субдомена
                        $param = $this->settings->get('cml_product_subdomain_html', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->subdomain_html = $this->valueAsString($v);
                        }

                        // картинка = cml_product_image
                        // название = cml_product_image_alt
                        // описание = cml_product_image_text
                        // в слайдере = cml_product_image_view

                        // файл = cml_product_file
                        // название = cml_product_file_alt
                        // описание = cml_product_file_text

                        // цифровой товар
                        $param = $this->settings->get('cml_product_download', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) {
                                $v = $this->valueAsString($v);
                                if (strtolower(substr($v, 0, $site_len)) == $site) $v = substr($v, $site_len);
                                if (strtolower(substr($v, 0, 16)) == 'files/downloads/') $v = substr($v, 16);
                                if ($v != '') $product->download = $v;
                            }
                        }

                        // гарантия
                        $param = $this->settings->get('cml_product_guarantee', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->guarantee = $this->valueAsString($v);
                        }

                        // ожидаемая дата поступления
                        $param = $this->settings->get('cml_product_coming', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->coming = $this->valueAsString($v);
                        }

                        // свойство = cml_product_property
                        // название = cml_product_property_name
                        // значение = cml_product_property_value

                        // позиция в списке
                        $param = $this->settings->get('cml_product_order_num', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->order_num = $this->valueAsInteger($v);
                        }

                        // шаблоном
                        $param = $this->settings->get('cml_product_template', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->template = $this->valueAsString($v);
                        }

                        // число просмотров
                        $param = $this->settings->get('cml_product_browsed', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->browsed = $this->valueAsNatural($v);
                        }

                        // хит продаж
                        $param = $this->settings->get('cml_product_hit', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->hit = $this->valueAsFlag($v);
                        }

                        // новинка
                        $param = $this->settings->get('cml_product_newest', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->newest = $this->valueAsFlag($v);
                        }

                        // акционный
                        $param = $this->settings->get('cml_product_actional', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->actional = $this->valueAsFlag($v);
                        }

                        // скоро в продаже
                        $param = $this->settings->get('cml_product_awaited', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->awaited = $this->valueAsFlag($v);
                        }

                        // яндекс.маркет (признак 32-битный по биту на канал)
                        $param = $this->settings->get('cml_product_ymarket', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->ymarket = $this->valueAsString($v);
                        }

                        // вконтакте
                        $param = $this->settings->get('cml_product_vkontakte', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->vkontakte = $this->valueAsFlag($v);
                        }

                        // разрешен к показу
                        $param = $this->settings->get('cml_product_enabled', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->enabled = $this->valueAsFlag($v);
                        }

                        // выделен визуально
                        $param = $this->settings->get('cml_product_highlighted', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->highlighted = $this->valueAsFlag($v);
                        }

                        // разрешен к обсуждению
                        $param = $this->settings->get('cml_product_commented', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->commented = $this->valueAsFlag($v);
                        }

                        // скрыт от неавторизованных
                        $param = $this->settings->get('cml_product_hidden', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->hidden = $this->valueAsFlag($v);
                        }

                        // не для rss
                        $param = $this->settings->get('cml_product_rss_disabled', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->rss_disabled = $this->valueAsFlag($v);
                        }

                        // не для информеров
                        $param = $this->settings->get('cml_product_export_disabled', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->export_disabled = $this->valueAsFlag($v);
                        }

                        // не в кредит
                        $param = $this->settings->get('cml_product_non_creditable', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->non_creditable = $this->valueAsFlag($v);
                        }

                        // экспонат
                        $param = $this->settings->get('cml_product_non_usable', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->non_usable = $this->valueAsFlag($v);
                        }

                        // в прайсах (признак 8-битный по биту на прайс)
                        $param = $this->settings->get('cml_product_in_prices', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->in_prices = $this->valueAsNatural($v, 0, 255);
                        }

                        // плагины
                        $param = $this->settings->get('cml_product_objects', '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) $product->objects = $this->valueAsString($v);
                        }

                        // ИДы товара
                        $product->sync_id = $id;
                        $product->category_id = $cid;
                        if (empty($pid)) {
                            $product->created = time();
                        } else {
                            $product->product_id = $pid;
                        }

                        // никаких технических полей
                        if (isset($product->variants)) unset($product->variants);
                        if (isset($product->categories)) unset($product->categories);
                        if (isset($product->related)) unset($product->related);
                        if (isset($product->properties)) unset($product->properties);
                        $product->indifferent_caches = TRUE;

                        // обновляем только при наличии изменений
                        $fields = '';
                        $ok = empty($pid);
                        if (!$ok) {
                            foreach ($old as $i => $v) {
                                $v = isset($product->$i) && $product->$i != $v;
                                if ($v) $fields .= ', ' . $i;
                                $ok = $ok || $v;
                            }
                        }
                        if ($ok) {
                            if (empty($pid)) {
                                if (isset($product->model)) {
                                    if (!isset($product->meta_title)) $product->meta_title = $product->model;
                                    if (!isset($product->meta_description)) $product->meta_description = $product->model;
                                    if (!isset($product->url)) {
                                        $v = $this->text->translitText($product->model, 'ru');
                                        $v = preg_replace('/[^a-z0-9\.]+/i', '-', $v);
                                        $v = trim($v, '-');
                                        if ($v != '') $product->url = $v . '-c' . $cid . '-' . rand(1, 100000);
                                    }
                                } else {
                                    $product->model = 'Без названия!';
                                }
                            } else {
                                $product->modified = time();
                            }
                            $pid = $this->cms->db->products->update($product);
                            if (empty($pid)) {
                                $data->error_products++;
                                $data->info_products .= 'Не удалось создать товар [sync_id = ' . $id . ']' . $CRLF;
                            } else {
                                if (is_object($old)) {
                                    $data->changed_products++;
                                    if ($this->settings->get('cml_history_changes_enabled')) {
                                        $data->info_products .= 'изменено [' . $name . '] в полях [' . ltrim($fields, ', ') . ']' . $CRLF;
                                    }
                                } else {
                                    $data->added_products++;
                                    if ($this->settings->get('cml_history_adds_enabled')) {
                                        $data->info_products .= '+ товар [' . $name . ']' . $CRLF;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Импорт варианта товара
        *
        *  Метод вызывается (последовательно для каждого варианта товара) из
        *  метода doCatalogImport во время импорта файла offers.xml.
        *
        *  @access  public
        *  @param   string  $xml        XML-ветка сведений о варианте товара
        *  @param   mixed   $data       внешние данные
        *                                   ->total_variants = счетчик записей
        *                                   ->changed_variants = счетчик изменившихся записей
        *                                   ->added_variants = счетчик новых записей
        *                                   ->error_variants = счетчик ошибок
        *                                   ->info_variants = подробности
        *  @return  void
        */
        // ===================================================================

        public function importVariant ( $xml, & $data ) {
            $CRLF = "\r\n";

            if (!is_object($data)) $data = new stdClass;
            if (!isset($data->total_variants)) $data->total_variants = 0;
            if (!isset($data->changed_variants)) $data->changed_variants = 0;
            if (!isset($data->added_variants)) $data->added_variants = 0;
            if (!isset($data->error_variants)) $data->error_variants = 0;
            if (!isset($data->info_variants)) $data->info_variants = '';
            $data->total_variants++;

            // синхронизационные ИД товара и варианта
            $param = $this->settings->get('cml_variant_id', '');
            $id = $this->xml->getSimpleXMLElementNode($xml, $param);
            $vid = explode('#', $id, 3);
            $pid = isset($vid[0]) ? trim($vid[0]) : '';
            if ($pid == '') {
                $data->error_variants++;
                $data->info_variants .= 'Недоступен ИД товара [' . $id . ']' . $CRLF;
            } else {
                $id = $pid;
                $vid = isset($vid[1]) ? trim($vid[1]) : $pid;

                // извлекаем ИД товара по синхро ИД
                $query = 'SELECT `product_id` AS `id`, '
                              . '`model` '
                       . 'FROM `' . DATABASE_PRODUCTS_TABLENAME . '` '
                       . 'WHERE `sync_id` = \'' .  $this->cms->db->query_value($pid) . '\' '
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $pid = $this->cms->db->fetch_assoc($result);
                $this->cms->db->free_result($result);
                $pname = isset($pid['model']) ? trim($pid['model']) : '';
                $pid = isset($pid['id']) ? $pid['id'] : 0;

                // если нет, тогда может по ИД
                if (empty($pid)) {
                    if (preg_replace('/[^0-9]/', '', $id) == $id) {
                        $query = 'SELECT `product_id` AS `id`, '
                                      . '`model` '
                               . 'FROM `' . DATABASE_PRODUCTS_TABLENAME . '` '
                               . 'WHERE `product_id` = \'' .  $this->cms->db->query_value($id) . '\' '
                                     . 'AND `sync_id` = \'\' '
                               . 'LIMIT 1;';
                        $result = $this->cms->db->query($query);
                        $pid = $this->cms->db->fetch_assoc($result);
                        $this->cms->db->free_result($result);
                        $pname = isset($pid['model']) ? trim($pid['model']) : '';
                        $pid = isset($pid['id']) ? $pid['id'] : 0;
                    }
                }

                if (empty($pid)) {
                    $data->error_variants++;
                    $data->info_variants .= 'Не найден товар [sync_id = ' . $id . ']' . $CRLF;
                } else {

                    // извлекаем старый вариант по синхро ИД
                    $query = 'SELECT * '
                           . 'FROM `' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '` '
                           . 'WHERE `product_id` = \'' . $this->cms->db->query_value($pid) . '\' '
                                 . 'AND `sync_id` = \'' . $this->cms->db->query_value($vid) . '\' '
                           . 'LIMIT 1;';
                    $result = $this->cms->db->query($query);
                    $old = $this->cms->db->fetch_object($result);
                    $this->cms->db->free_result($result);

                    // если нет, тогда может без синхро ИД
                    if (empty($old) && $vid != '') {
                        $query = 'SELECT * '
                               . 'FROM `' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '` '
                               . 'WHERE `product_id` = \'' . $this->cms->db->query_value($pid) . '\' '
                                     . 'AND `sync_id` = \'\' '
                               . 'LIMIT 1;';
                        $result = $this->cms->db->query($query);
                        $old = $this->cms->db->fetch_object($result);
                        $this->cms->db->free_result($result);
                    }

                    // готовим новый вариант
                    $variant = new stdClass;

                    // название варианта
                    $param = $this->settings->get('cml_variant_name', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->name = $this->valueAsString($v);
                    }

                    // ожидаемое название
                    $name = isset($variant->name) ? $variant->name
                                                  : (isset($old->name) ? trim($old->name) : '');
                    if ($name == '') $name = 'Без названия!';

                    // артикул
                    $param = $this->settings->get('cml_variant_sku', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->sku = $this->valueAsString($v);
                    }

                    // количество на складе
                    $param = $this->settings->get('cml_variant_stock', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->stock = $this->valueAsInteger($v);
                    }

                    // вес в списке
                    $param = $this->settings->get('cml_variant_position', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->position = $this->valueAsInteger($v);
                    }

                    // приоритетная скидка
                    $param = $this->settings->get('cml_variant_discount', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) {
                            $v = $this->valueAsDiscount($v);
                            $v = round($v, 2);
                            $variant->priority_discount = $v;
                        }
                    }

                    // цена по группам
                    for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                        $param = $this->settings->get('cml_variant_price' . (($i > 1) ? $i : ''), '');
                        if ($param != '') {
                            $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                            if ($v !== FALSE) {
                                $param = 'price' . (($i > 1) ? $i : '');
                                $v = $this->valueAsFloat($v, 0);
                                $v = round($v, 2);
                                $variant->$param = $v;
                            }
                        }
                    }

                    // старая цена
                    $param = $this->settings->get('cml_variant_old_price', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) {
                            $v = $this->valueAsFloat($v, 0);
                            $v = round($v, 2);
                            $variant->old_price = $v;
                        }
                    }

                    // акционная цена
                    $param = $this->settings->get('cml_variant_temp_price', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) {
                            $v = $this->valueAsFloat($v, 0);
                            $v = round($v, 2);
                            $variant->temp_price = $v;
                        }
                    }

                    // дата начала акционной цены
                    $param = $this->settings->get('cml_variant_temp_price_start', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->temp_price_start = $this->valueAsString($v);
                    }

                    // дата конца акционной цены
                    $param = $this->settings->get('cml_variant_temp_price_date', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->temp_price_date = $this->valueAsString($v);
                    }

                    // число необходимых участников акционной цены
                    $param = $this->settings->get('cml_variant_temp_price_members', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->temp_price_members = $this->valueAsNatural($v);
                    }

                    // число привлеченных участников акционной цены
                    $param = $this->settings->get('cml_variant_temp_price_invited', '');
                    if ($param != '') {
                        $v = $this->xml->getSimpleXMLElementNode($xml, $param, FALSE);
                        if ($v !== FALSE) $variant->temp_price_invited = $this->valueAsNatural($v);
                    }

                    // ИДы варианта
                    $variant->sync_id = $vid;
                    $variant->product_id = $pid;
                    if (is_object($old)) {
                        $variant->variant_id = $old->variant_id;
                    } else {
                        $variant->created = time();
                    }

                    // если замечены поля цен
                    $ok = FALSE;
                    for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                        $field = 'price' . (($i > 1) ? $i : '');
                        if (isset($variant->$field)) {
                            $ok = TRUE;
                            break;
                        }
                    }
                    if ($ok || isset($variant->old_price) || isset($variant->temp_price)) {

                        // валюта
                        $param = $this->settings->get('cml_variant_currency', '');
                        $sign = $this->xml->getSimpleXMLElementNode($xml, $param);
                        $sign = $this->valueAsString($sign);
                        if ($sign != '') {

                            // берем незапрещенную валюту по коду
                            $params = new stdClass;
                            $params->enabled = 1;
                            $params->deleted = 0;
                            $params->code = $sign;
                            $currency = null;
                            $this->cms->db->get_currency($currency, $params);

                            // или по надписи
                            if (empty($currency)) {
                                $params = new stdClass;
                                $params->enabled = 1;
                                $params->deleted = 0;
                                $params->sign = $sign;
                                $this->cms->db->get_currency($currency, $params);
                            }

                            // конвертируем цены в базовую валюту
                            if (!empty($currency)) {
                                $rate = $this->currency->rate($currency);
                                if ($rate != 0) {
                                    for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                                        $field = 'price' . (($i > 1) ? $i : '');
                                        if (isset($variant->$field)) $variant->$field = round($variant->$field * $rate, 2);
                                    }
                                    if (isset($variant->temp_price)) $variant->temp_price = round($variant->temp_price * $rate, 2);
                                    if (isset($variant->old_price)) $variant->old_price = round($variant->old_price * $rate, 2);
                                }
                            }
                        }
                    }

                    // никаких технических полей
                    if (isset($variant->previous_price)) unset($variant->previous_price);
                    if (isset($variant->previous_temp_price)) unset($variant->previous_temp_price);
                    if (isset($variant->previous_stock)) unset($variant->previous_stock);
                    $variant->indifferent_caches = TRUE;

                    // обновляем только при наличии изменений
                    $fields = '';
                    $ok = !is_object($old);
                    if (!$ok) {
                        foreach ($old as $i => $v) {
                            if (isset($variant->$i)) {
                                if (is_float($variant->$i)) {
                                    $v = $this->valueAsFloat($v);
                                    $v = round($v, 2);
                                }
                                $v = $variant->$i != $v;
                                if ($v) $fields .= ', ' . $i;
                                $ok = $ok || $v;
                            }
                        }
                    }
                    if ($ok) {
                        if (is_object($old)) {
                            $variant->modified = time();
                        }
                        $vid = $this->cms->db->products->update_variant($variant);
                        if (empty($vid)) {
                            $data->error_variants++;
                            $data->info_variants .= 'Не удалось создать вариант [sync_id = ' . $id . ']' . $CRLF;
                        } else {
                            if (is_object($old)) {
                                $data->changed_variants++;
                                if ($this->settings->get('cml_history_changes_enabled')) {
                                    $data->info_variants .= 'изменено [' . $name . '] товара [' . $pname . '] в полях [' . ltrim($fields, ', ') . ']' . $CRLF;
                                }
                            } else {
                                $data->added_variants++;
                                if ($this->settings->get('cml_history_adds_enabled')) {
                                    $data->info_variants .= '+ вариант [' . $name . '] товара [' . $pname . ']' . $CRLF;
                                }
                            }
                        }
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

            // если это запрос из 1С
            if ($this->isRequester1C()) {

                // выполняем синхронизацию
                if ($this->settings->get('cml_enabled')) {
                    if ($this->isValidClientIP()) {
                        $this->startSynchronization();
                    } else {
                        $LF = "\n";
                        echo 'failure' . $LF;

                        $this->addHistory('отказано в доступе');
                    }
                }
                exit;
            }

            // проверяем доступность шаблона
            if (!$this->checkTemplate(COMMERCEML_PAGE_TITLE)) return TRUE;

            // передаем в шаблонизатор имя папки выгрузки временных файлов
            $this->cms->smarty->assignByRef('upload_folder', $this->upload_folder);

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>