<?php
    // =======================================================================
    /**
    *  Админ модуль "О программе"
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет справочника
    require_once(dirname(__FILE__) . '/../.ref-models/BasicModel.php');

    // текст заголовка страницы модуля
    define('ABOUT_PAGE_TITLE', 'О программе');

    // имя файла шаблона модуля
    define('ABOUT_TEMPLATE_FILENAME', 'about/about.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('ABOUT_MODULELINK_POINTER', 'About');
    define('ABOUT_MODULETAB_TEXT', 'о программе');
    define('ABOUT_MODULEMENU_PATH', 'На сайт / О программе');



    // =======================================================================
    /**
    *  Админ модуль "О программе"
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class About extends BasicREFModel {

        // имя файла шаблона
        protected $template = ABOUT_TEMPLATE_FILENAME;



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
            if (!$this->checkTemplate(ABOUT_PAGE_TITLE)) return TRUE;

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);
            return TRUE;
        }
    }



    return;
?>