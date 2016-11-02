<?php
    // макет списка записей
    require_once(dirname(__FILE__) . '/../.ref-models/List.php');



    // =======================================================================
    /**
    *  Клиентский модуль списка стран
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientCountries extends ListREFModel {

        protected $default_title = 'Страны';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Страны';
        protected $settings_model = 'countries';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'countries';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'countries';

        // целевая переменная в шаблоне
        protected $template_var = 'countries';

        // допустимые режимы сортировки
        protected $sort_modes = array( SORT_COUNTRIES_MODE_AS_IS      => 'как расставлены',
                                       SORT_COUNTRIES_MODE_BY_NAME    => 'по названию',
                                       SORT_COUNTRIES_MODE_BY_BROWSED => 'по просмотрам' );



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
            $settings = array('sort_method'       => SORT_COUNTRIES_MODE_AS_IS,
                              'sort_descending'   => 0,
                              'sort_laconical'    => 0,
                              'main_title'        => 'Страны',
                              'main_path'         => 'Страны',
                              'main_keywords'     => 'страны, страна',
                              'main_description'  => 'Список стран, для которых работает наш магазин.',
                              'show_all_disabled' => 0);
            parent::checkModuleSettings($settings);
        }
    }



    return;
?>