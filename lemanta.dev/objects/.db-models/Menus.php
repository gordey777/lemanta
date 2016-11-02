<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Меню: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class MenusDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'menu';
        public $id_field = 'menu_id';



        // ===================================================================
        /**
        *  Добавление в запись меню прикрепленных к нему записей
        *
        *  @access  public
        *  @param   object  $item       объект записи меню
        *  @param   string  $types      список через запятую прикрепляемых типов записей
        *                               (например 'articles, sections', по умолчанию все)
        *  @return  void
        */
        // ===================================================================

        public function attachItems ( & $item, $types = '' ) {
            $types = is_string($types) ? explode(',', $this->text->lowerCase($types)) : array();
            if (empty($types)) {
                $types = array('categories', 'brands', 'products', 'sections', 'files', 'articles', 'news');
            }
            foreach ($types as $type) {
                $type = trim($type);
                switch ($type) {

                    // если категории
                    case 'categories':
                        $item->categories = array();
                        if (!empty($this->cms->categories)) {
                            foreach ($this->cms->categories as & $category) {
                                if ($item->menu_id == $category->menu_id) $item->categories[$category->category_id] = & $category;
                            }
                        }
                        break;

                    // если бренды
                    case 'brands':
                        $item->brands = array();
                        if (!empty($this->cms->brands)) {
                            foreach ($this->cms->brands as & $brand) {
                                if ($item->menu_id == $brand->menu_id) $item->brands[$brand->brand_id] = & $brand;
                            }
                        }
                        break;

                    // если товары
                    case 'products':
                        $item->products = null;
                        $filter = new stdClass;
                        $filter->sort = $this->settings->getAsInteger('products_sort_method');
                        $filter->sort_direction = $this->settings->getAsBoolean('products_sort_direction');
                        $filter->sort_laconical = $this->settings->getAsBoolean('products_sort_laconical');
                        $filter->enabled = 1;
                        if (!isset($this->cms->user->user_id)) $filter->hidden = 0;
                        $filter->discount = isset($this->cms->user->discount) ? $this->cms->user->discount : 0;
                        $filter->price_id = isset($this->cms->user->price_id) ? $this->cms->user->price_id : 0;
                        $filter->menu_id = $item->menu_id;
                        $this->cms->db->products->get($item->products, $filter);
                        $this->cms->db->products->unpackRecords($item->products, $filter);
                        break;

                    // если специальные страницы
                    case 'sections':
                        $item->sections = null;
                        $filter = new stdClass;
                        $filter->sort = $this->settings->getAsInteger('sections_sort_method');
                        $filter->enabled = 1;
                        if (!isset($this->cms->user->user_id)) $filter->hidden = 0;
                        $filter->menu_id = $item->menu_id;
                        $this->cms->db->sections->get($item->sections, $filter);
                        $this->cms->db->sections->unpackRecords($item->sections);
                        break;

                    // если медиа файлы
                    case 'files':
                        $item->files = null;
                        $filter = new stdClass;
                        $filter->sort = $this->settings->getAsInteger('files_sort_method');
                        $filter->enabled = 1;
                        if (!isset($this->cms->user->user_id)) $filter->hidden = 0;
                        $filter->menu_id = $item->menu_id;
                        $this->cms->db->get_files($item->files, $filter);
                        $this->cms->db->fix_files_records($item->files);
                        break;

                    // если статьи
                    case 'articles':
                        $item->articles = null;
                        $filter = new stdClass;
                        $filter->sort = $this->settings->getAsInteger('articles_sort_method');
                        $filter->enabled = 1;
                        if (!isset($this->cms->user->user_id)) $filter->hidden = 0;
                        $filter->menu_id = $item->menu_id;
                        $filter->section = $this->cms->now_in_section;
                        $this->cms->db->get_articles($item->articles, $filter);
                        $this->cms->db->fix_articles_records($item->articles);
                        break;

                    // если новости
                    case 'news':
                        $item->news = null;
                        $filter = new stdClass;
                        $filter->sort = $this->settings->getAsInteger('news_sort_method');
                        $filter->enabled = 1;
                        if (!isset($this->cms->user->user_id)) $filter->hidden = 0;
                        $filter->menu_id = $item->menu_id;
                        $filter->section = $this->cms->now_in_section;
                        $this->cms->db->news->get($item->news, $filter);
                        $this->cms->db->news->unpackRecords($item->news);
                        break;
                }
            }
        }
    }



    return;
?>