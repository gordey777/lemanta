<?php
    // макет списка записей
    require_once(dirname(__FILE__) . '/../.ref-models/List.php');



    // =======================================================================
    /**
    *  Клиентский модуль списка комплектов товаров
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientProductsKits extends ListREFModel {

        protected $default_title = 'Комплекты товаров';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Комплекты товаров';
        protected $settings_model = 'productskits';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'products_kits';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'products_kits';

        // целевая переменная в шаблоне
        protected $template_var = 'kits';

        // допустимые режимы сортировки
        protected $sort_modes = array( SORT_PRODUCTSKITS_MODE_AS_IS       => 'как расставлены',
                                       SORT_PRODUCTSKITS_MODE_BY_NAME     => 'по названию',
                                       SORT_PRODUCTSKITS_MODE_BY_BROWSED  => 'по просмотрам',
                                       SORT_PRODUCTSKITS_MODE_BY_ROWCOUNT => 'по числу позиций',
                                       SORT_PRODUCTSKITS_MODE_BY_QUANTITY => 'по числу товаров' );



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
            $settings = array('sort_method'       => SORT_PRODUCTSKITS_MODE_AS_IS,
                              'sort_descending'   => 0,
                              'sort_laconical'    => 0,
                              'main_title'        => 'Комплекты товаров',
                              'main_path'         => 'Комплекты',
                              'main_keywords'     => 'комплекты товаров, комплект, набор товаров, набор',
                              'main_description'  => 'Список комплектов товаров, предлагаемых нашим магазином.',
                              'show_all_disabled' => 0);
            parent::checkModuleSettings($settings);
        }
    }



    return;
?>