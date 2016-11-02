<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Специальные страницы: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SectionsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'sections';
        public $id_field = 'section_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'module_id',        // ИД модуля
                'user_id',          // ИД пользователя
                'enabled',          // разрешена
                'hidden',           // скрыта
                'menu_id',          // ИД меню
                'name',             // название (для пункта меню)
                'header',           // название (заголовок)
                'url',              // адрес
                'url_special',      // особый адрес
                'tags',             // теги
                'meta_title',       // мета заголовок
                'meta_keywords',    // мета ключевые слова
                'meta_description', // мета описание
                'body',             // описание
                'seo_description',  // seo текст
                'browsed',          // просмотры
                'order_num',        // вес
                'template',         // шаблон
                'objects',          // плагины
                'images',           // фото
                'images_alts',      // надписи фото
                'images_texts',     // описания фото
                'images_view',      // слайдинг-признаки
                'created',          // создано
                'modified'          // изменено
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'Sections';
        protected $operables_card = 'Section';
        protected $operables = array('move_up', 'move_down', 'move_first', 'move_last',
                                     'delete', 'edit',
                                     'enable', 'hidden');



        // =======================================================================
        // Выбрать из базы данных записи о специальных страницах согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->ids] = идентификаторы специальных страниц (перечисленные через запятую)
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->menu_id] = идентификатор меню
        //   [$params->module_id] = идентификатор модуля
        //   [$params->objected] = с подгружаемыми модулями
        //   [$params->browsed] = просмотренные
        //   [$params->SEOed] = с SEO текстом
        //   [$params->url_special] = с особым url
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' get');

            $items = array();
            $where = '';
            $order = '';
            $limit = '';

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_SECTIONS_MODE_BY_HEADER:
                        $order = '`' . $dbtable . '`.`header` ASC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;
                    case SORT_SECTIONS_MODE_BY_DATE:
                    case SORT_SECTIONS_MODE_BY_CREATED:
                        $order = '`' . $dbtable . '`.`created` DESC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;
                    case SORT_SECTIONS_MODE_BY_MODIFIED:
                        $order = '`' . $dbtable . '`.`modified` DESC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;
                    case SORT_SECTIONS_MODE_BY_BROWSED:
                        $order = '`browsed` DESC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;
                    case SORT_SECTIONS_MODE_BY_URL:
                        $order = '`' . $dbtable . '`.`url` ASC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                    case SORT_SECTIONS_MODE_BY_OBJECTS:
                        $order = '`' . $dbtable . '`.`objects` DESC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;
                    case SORT_SECTIONS_MODE_BY_MODULE:
                        $order = '`module` ASC, '
                               . '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;
                    case SORT_SECTIONS_MODE_BY_MENU:
                    case SORT_SECTIONS_MODE_AS_IS:
                    default:
                        $order = '`menu` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN (\'' . str_replace(',', '\',\'', $this->cms->db->query_value($params->ids)) . '\') ';
            if (isset($params->user_id)) $where .= 'AND `' . $dbtable . '`.`user_id` = \'' . $this->cms->db->query_value($params->user_id) . '\' ';
            if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
            if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = \'' . $this->cms->db->query_value($params->hidden) . '\' ';
            if (isset($params->imaged)) $where .= 'AND TRIM(REPLACE(`' . $dbtable . '`.`images`, \'' . $this->cms->db->query_value(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER) . '\', \'\')) != \'\' ';
            if (isset($params->menu_id)) $where .= 'AND `' . $dbtable . '`.`menu_id` = \'' . $this->cms->db->query_value($params->menu_id) . '\' ';
            if (isset($params->module_id)) $where .= 'AND `' . $dbtable . '`.`module_id` = \'' . $this->cms->db->query_value($params->module_id) . '\' ';
            if (isset($params->objected)) $where .= 'AND TRIM(`' . $dbtable . '`.`objects`) != \'\' ';
            if (isset($params->browsed)) $where .= 'AND ABS(`' . $dbtable . '`.`browsed`) != 0 ';
            if (isset($params->SEOed)) $where .= 'AND TRIM(`' . $dbtable . '`.`seo_description`) != \'\' ';
            if (isset($params->url_special)) $where .= 'AND `' . $dbtable . '`.`url_special` = \'' . $this->cms->db->query_value($params->url_special) . '\' ';
            if ($where != '') $where = 'WHERE 1 ' . $where;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $dbtable . '`.*, '
                                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                                              . '`menu`.`name` AS `menu`, '
                                              . '`modules`.`name` AS `module` '
                   . 'FROM `' . $dbtable . '` '
                   . 'LEFT JOIN `menu` ON `menu`.`menu_id` = `' . $dbtable . '`.`menu_id` '
                   . 'LEFT JOIN `modules` ON `modules`.`module_id` = `' . $dbtable . '`.`module_id` '
                   . $where
                   . $order
                   . $limit . ';';
            $result = $this->cms->db->query($query);
            $items = $this->cms->db->results();

            // берем полное количество подобных записей
            $result2 = $this->cms->db->query('SELECT FOUND_ROWS() AS `count`;');
            $count = $this->cms->db->result();
            $count = isset($count->count) ? $count->count : 0;

            // освобождаем память от запроса
            $this->cms->db->free_result($result);
            $this->cms->db->free_result($result2);

            // возвращаем количество записей
            $this->cms->db->close_tracing_method();
            return $count;
        }



        // =======================================================================
        // Взять из базы данных запись о специальной странице, указанной в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название специальной страницы в меню
        //   [$params->header] = заголовок специальной страницы
        //   [$params->class] = класс модуля
        //   [$params->menu_id] = идентификатор меню
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->module_id] = идентификатор модуля
        //   [$params->url] = адрес страницы записи
        //   [$params->url_special] = с особым url
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        // =======================================================================

        public function one ( & $item, $params = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' one');

            $item = null;
            $where = '';

            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = \'' . $this->cms->db->query_value($params->id) . '\' ';
            if (isset($params->name)) $where .= 'AND `' . $dbtable . '`.`name` = \'' . $this->cms->db->query_value($params->name) . '\' ';
            if (isset($params->header)) $where .= 'AND `' . $dbtable . '`.`header` = \'' . $this->cms->db->query_value($params->header) . '\' ';
            if (isset($params->url)) $where .= 'AND `' . $dbtable . '`.`url` = \'' . $this->cms->db->query_value($params->url) . '\' ';
            if (isset($params->class)) $where .= 'AND `modules`.`class` = \'' . $this->cms->db->query_value($params->class) . '\' ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` != \'' . $this->cms->db->query_value($params->exclude_id) . '\' ';
                if (isset($params->menu_id)) $where .= 'AND `' . $dbtable . '`.`menu_id` = \'' . $this->cms->db->query_value($params->menu_id) . '\' ';
                if (isset($params->user_id)) $where .= 'AND `' . $dbtable . '`.`user_id` = \'' . $this->cms->db->query_value($params->user_id) . '\' ';
                if (isset($params->module_id)) $where .= 'AND `' . $dbtable . '`.`module_id` = \'' . $this->cms->db->query_value($params->module_id) . '\' ';
                if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = \'' . $this->cms->db->query_value($params->enabled) . '\' ';
                if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = \'' . $this->cms->db->query_value($params->hidden) . '\' ';
                if (isset($params->url_special)) $where .= 'AND `' . $dbtable . '`.`url_special` = \'' . $this->cms->db->query_value($params->url_special) . '\' ';
                $where = 'WHERE 1 ' . $where;

                // делаем запрос
                $query = 'SELECT `' . $dbtable . '`.*, '
                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                              . '`modules`.`class`, '
                              . '`modules`.`name` AS `module` '
                       . 'FROM `' . $dbtable . '` '
                       . 'LEFT JOIN `modules` ON `modules`.`module_id` = `' . $dbtable . '`.`module_id` '
                       . $where
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $item = $this->cms->db->result();

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // поправляем поля записи
                if (!empty($item)) $this->unpack($item);
            }
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Распаковка полей записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   object  $params     объект параметров
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {
            parent::unpack($item, $params);
            $this->unpackName($item);
            $this->unpackBody($item);
            $this->unpackUrl($item, 'sections');
            $this->unpackImages($item);
        }
    }



    return;
?>