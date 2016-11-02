<?php
    // =======================================================================
    /**
    *  Админ модуль ценовых групп
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

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // текст заголовка страницы модуля
    define('PRICEGROUPS_PAGE_TITLE', 'Ценовые группы');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('PRICEGROUPS_TEMPLATE_FILENAME', 'price_groups/price_groups.htm');
    define('PRICEGROUPS_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                        . PRICEGROUPS_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // имена переменных в шаблонизаторе
    define('PRICEGROUPS_SMARTYVAR_ITEMS', 'items');

    // имена переменных в форме ввода
    define('PRICEGROUPS_POSTVAR_NAME', 'name');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('PRICEGROUPS_MODULELINK_POINTER', 'PriceGroups');
    define('PRICEGROUPS_MODULETAB_TEXT', 'тип цен');
    define('PRICEGROUPS_MODULEMENU_PATH', 'Клиенты / Ценовые группы');



    // =======================================================================
    /**
    *  Админ модуль ценовых групп
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PriceGroups extends Basic {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
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

            // устанавливаем заголовок страницы
            $this->title = ADMIN_PAGE_TITLE_PREFIX . PRICEGROUPS_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = PRICEGROUPS_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . PRICEGROUPS_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->admin_folder);
            $path .= '/design/' . $this->hdd->safeFilename($this->settings->admin_theme) . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

            // обрабатываем входные параметры
            $this->process();

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process () {

            // если получены данные об изменениях
            if (isset($_POST[REQUEST_PARAM_NAME_POST]) && $_POST[REQUEST_PARAM_NAME_POST]) {
                if (isset($_POST[PRICEGROUPS_POSTVAR_NAME]) && is_array($_POST[PRICEGROUPS_POSTVAR_NAME])) {

                    // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                    $this->check_token();

                    // сохраняем записи
                    for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                        if (isset($_POST[PRICEGROUPS_POSTVAR_NAME][$i])) {
                            $field = 'price_type' . $i;
                            $value = substr(trim($_POST[PRICEGROUPS_POSTVAR_NAME][$i]), 0, PRICE_TYPE_MAXSIZE);
                            $this->db->settings->save($field, $value, 'Клиенты - Ценовые группы - название группы ' . $i);
                        }
                    }
                }
            }

            // читаем записи
            $items = array();
            for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                $field = 'price_type' . $i;
                $items[$i] = isset($this->settings->$field) ? substr(trim($this->settings->$field), 0, PRICE_TYPE_MAXSIZE) : '';
            }

            // передаем в шаблонизатор записи
            $this->smarty->assignByRef(PRICEGROUPS_SMARTYVAR_ITEMS, $items);

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // передаем в шаблонизатор информационное сообщение
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        }
    }



    return;
?>