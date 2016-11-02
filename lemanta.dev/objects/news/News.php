<?php
    // макет списка записей
    require_once(dirname(__FILE__) . '/../.ref-models/List.php');



    // =======================================================================
    /**
    *  Клиентский модуль списка новостей
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientNews extends ListREFModel {

        protected $default_title = 'Новости';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Новости';
        protected $settings_model = 'news';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'news';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'news';

        // целевая переменная в шаблоне
        protected $template_var = 'all_news';

        // допустимые режимы сортировки
        protected $sort_modes = array( SORT_NEWS_MODE_AS_IS      => 'как расставлены',
                                       SORT_NEWS_MODE_BY_HEADER  => 'по названию',
                                       SORT_NEWS_MODE_BY_BROWSED => 'по просмотрам',
                                       SORT_NEWS_MODE_BY_DATE    => 'по дате',
                                       SORT_NEWS_MODE_BY_RATING  => 'по рейтингу' );



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
            $settings = array('sort_method'       => SORT_NEWS_MODE_BY_DATE,
                              'sort_descending'   => 1,
                              'sort_laconical'    => 0,
                              'main_title'        => 'Новости',
                              'main_path'         => 'Новости',
                              'main_keywords'     => 'новости, новость',
                              'main_description'  => 'Список новостей нашего магазина.',
                              'show_all_disabled' => 0);
            parent::checkModuleSettings($settings);
        }



        // ===================================================================
        /**
        *  Дополнение данных какой-либо информацией
        *
        *  @access  protected
        *  @param   mixed   $data   указатель на данные
        *  @return  void
        */
        // ===================================================================

        protected function complementData ( & $data ) {

            // читаем количество комментариев у каждой записи
            if (!empty($data) && is_array($data)) {
                $dbmodel = $this->getDBModel();
                $idfield = $this->cms->db->$dbmodel->getIDField();

                $dummy = null;
                $filter = new stdClass;
                $filter->enabled = 1;
                $filter->start = 0;
                $filter->maxcount = 0;
                foreach ($data as & $item) {
                    $item->comments_count = 0;
                    $filter->$idfield = $item->$idfield;
                    $this->cms->db->get_ncomments($dummy, $filter, $item->comments_count);
                }
            }
        }
    }



    return;
?>