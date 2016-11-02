<?php
    // макет списка записей
    require_once(dirname(__FILE__) . '/../.ref-models/List.php');



    // =======================================================================
    /**
    *  Клиентский модуль списка складов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientStocks extends ListREFModel {

        protected $default_title = 'Склады';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Склады';
        protected $settings_model = 'stocks';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'stocks';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'stocks';

        // целевая переменная в шаблоне
        protected $template_var = 'stocks';

        // допустимые режимы сортировки
        protected $sort_modes = array( SORT_STOCKS_MODE_AS_IS      => 'как расставлены',
                                       SORT_STOCKS_MODE_BY_NAME    => 'по названию',
                                       SORT_STOCKS_MODE_BY_BROWSED => 'по просмотрам' );



        // ===================================================================
        /**
        *  Проверка / создание личных настроек модуля
        *
        *  @access  public
        *  @param   string  $settings   массив настроек (формат элемента описан в BasicREFModelConf)
        *  @return  void
        */
        // ===================================================================

        public function checkModuleSettings ( $settings = null ) {
            $settings = array('sort_method'       => SORT_STOCKS_MODE_AS_IS,
                              'sort_descending'   => 1,
                              'sort_laconical'    => 0,
                              'main_title'        => 'Склады',
                              'main_path'         => 'Склады',
                              'main_keywords'     => 'склад',
                              'main_description'  => 'Список складов нашего магазина.',
                              'show_all_disabled' => 0);
            parent::checkModuleSettings($settings);
        }



        // ===================================================================
        /**
        *  Дополнение фильтра записей
        *
        *  @access  protected
        *  @param   object  $filter     указатель на фильтр
        *  @return  boolean             TRUE если продолжать
        *                               FALSE если отменить чтение записей
        */
        // ===================================================================

        protected function complementFilter ( & $filter ) {
            if (!is_object($filter)) return FALSE;
            $filter->visible = 1;
            return TRUE;
        }
    }



    return;
?>