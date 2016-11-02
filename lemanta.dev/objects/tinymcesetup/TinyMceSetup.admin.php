<?php
    // =======================================================================
    /**
    *  Админ модуль настроек визуального редактора Tiny MCE
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/../.ref-models/AdminSetup.php');

    // текст заголовка страницы модуля
    define('TINYMCESETUP_PAGE_TITLE', 'Настройки визуального редактора Tiny MCE');

    // имя файла шаблона модуля
    define('TINYMCESETUP_TEMPLATE_FILENAME', 'tiny_mce_setup/tiny_mce_setup.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('TINYMCESETUP_MODULELINK_POINTER', 'TinyMceSetup');
    define('TINYMCESETUP_MODULETAB_TEXT', 'редактор');
    define('TINYMCESETUP_MODULEMENU_PATH', 'Настройки / Мои магазины / Визуальный редактор');



    // =======================================================================
    /**
    *  Админ модуль настроек визуального редактора Tiny MCE
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class TinyMceSetup extends AdminSetupREFModel {

        // имя модели базы данных
        protected $dbmodel = 'tiny_mce_setup';

        // имя файла шаблона
        protected $template = TINYMCESETUP_TEMPLATE_FILENAME;



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

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->cms->param(REQUEST_PARAM_NAME_ITEMID));

            // обрабатываем нужную запись
            for ($i = 1; $i <= 2; $i++) {
                if ($id == $i) {
                    $info = $i == 1 ? 'для аннотаций' : 'для полного текста';

                    // подключаемые плагины
                    $field = 'tinymce' . $i . '_plugins';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - подключаемые плагины');

                    // допустимые теги
                    $field = 'tinymce' . $i . '_valid_tags';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - допустимые теги');

                    // допустимые теги (дополнительно)
                    $field = 'tinymce' . $i . '_extended_valid_tags';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - допустимые теги (дополнительно)');

                    // строка 1 кнопок панели инструментов
                    $field = 'tinymce' . $i . '_buttons1';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - строка 1 кнопок панели инструментов');

                    // строка 2 кнопок панели инструментов
                    $field = 'tinymce' . $i . '_buttons2';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - строка 2 кнопок панели инструментов');

                    // строка 3 кнопок панели инструментов
                    $field = 'tinymce' . $i . '_buttons3';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - строка 3 кнопок панели инструментов');

                    // строка 4 кнопок панели инструментов
                    $field = 'tinymce' . $i . '_buttons4';
                        $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
                        $value = preg_replace('/[ \s\t\r\n]/', '', $value);
                        $this->cms->db->settings->save($field, $value, 'Настройки Tiny MCE - ' . $info . ' - строка 4 кнопок панели инструментов');

                    // кнопки снизу редактора
                    $field = 'tinymce' . $i . '_buttons_bottom';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - кнопки снизу редактора');

                    // кнопки выровнять направо
                    $field = 'tinymce' . $i . '_buttons_rightalign';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - кнопки выровнять направо');

                    // показывать строку состояния
                    $field = 'tinymce' . $i . '_statusbar';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - показывать строку состояния');

                    // использовать родной CSS редактора
                    $field = 'tinymce' . $i . '_native_css';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - использовать родной CSS редактора');

                    // авто очистка при вставке
                    $field = 'tinymce' . $i . '_cleanup_paste';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - авто очистка при вставке');

                    // форматировать разметку
                    $field = 'tinymce' . $i . '_source_formatting';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - форматировать разметку');

                    // конвертировать URL
                    $field = 'tinymce' . $i . '_convert_urls';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - конвертировать URL');

                    // делать URL относительными
                    $field = 'tinymce' . $i . '_relative_urls';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - делать URL относительными');

                    // удалять яваскрипты
                    $field = 'tinymce' . $i . '_remove_script_host';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - удалять яваскрипты');

                    // валидация CSS
                    $field = 'tinymce' . $i . '_verify_css_classes';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - валидация CSS');

                    // валидация HTML
                    $field = 'tinymce' . $i . '_verify_html';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - валидация HTML');

                    // удалять разрывы строк
                    $field = 'tinymce' . $i . '_remove_linebreaks';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - удалять разрывы строк');

                    // подавлять избыточные BR
                    $field = 'tinymce' . $i . '_remove_redundant_brs';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - подавлять избыточные BR');

                    // заменить переводы строк на BR
                    $field = 'tinymce' . $i . '_convert_newlines_to_brs';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - заменить переводы строк на BR');

                    // новые строки с помощью BR
                    $field = 'tinymce' . $i . '_force_br_newlines';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - новые строки с помощью BR');

                    // новые строки с помощью P
                    $field = 'tinymce' . $i . '_force_p_newlines';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - новые строки с помощью P');

                    // исправлять списки
                    $field = 'tinymce' . $i . '_fix_list_elements';
                    $this->cms->db->settings->saveFromPost($field, 'Настройки Tiny MCE - ' . $info . ' - исправлять списки');
                }
            }

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(TINYMCESETUP_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>