<?php
    // =======================================================================
    /**
    *  Админ модуль редактирования поискового сопровождения
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================



    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;



    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);



    // подключаем класс заказов
    impera_ClassRequire('SearchEscorts', TRUE);



    // текст заголовка страницы модуля
    define('SEARCHESCORT_PAGE_TITLE', 'Редактирование поискового сопровождения');



    // имя файла шаблона модуля
    define('SEARCHESCORT_TEMPLATE_FILENAME', 'search_escorts/search_escort.htm');



    // какая страница возврата рекомендуется для модуля страницы способа оплаты
    define('SEARCHESCORT_RESULT_PAGE', 'index.php?section=SearchEscorts');



    // =======================================================================
    /**
    *  Админ модуль редактирования поискового сопровождения
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SearchEscort extends SearchEscorts {



        // рекомендуемая страница возврата после операции
        protected $result_page = SEARCHESCORT_RESULT_PAGE;



        // имя файла шаблона
        protected $template = SEARCHESCORT_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Наполнение переменных и передача в шаблонизатор
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function fillVariables () {

            // контролируем состояние записи
            $this->title = $this->controlRecordState($this->item,
                                                     'Новое поисковое сопровождение',
                                                     'Редактирование сопровождения "',
                                                     'Редактирование копии сопровождения "');



            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
        }



        // ===================================================================
        /**
        *  Уничтожение ненужных более переменных в шаблонизаторе
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function destroyVariables () {
            $this->cms->smarty->clearAssign(SMARTY_VAR_ITEM);
            $this->item = null;
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
            if (!$this->checkTemplate(SEARCHESCORT_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return $this->fetchEdit($parent);
        }
    }



    return;
?>