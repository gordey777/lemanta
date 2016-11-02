<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Новости: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class NewsDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'news';
        public $id_field = 'news_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'header',           // название (заголовок)
                'menu_id',          // ИД меню
                'category_id',      // ИД категории
                'brand_id',         // ИД бренда
                'user_id',          // ИД пользователя
                'enabled',          // разрешена
                'highlighted',      // выделена
                'listed',           // есть в анонсах
                'commented',        // обсуждаема
                'hidden',           // скрыта
                'rss_disabled',     // не для rss
                'export_disabled',  // не для информеров
                'url',              // адрес
                'url_special',      // особый адрес
                'meta_title',       // мета заголовок
                'meta_keywords',    // мета ключевые слова
                'meta_description', // мета описание
                'annotation',       // описание
                'body',             // полное описание
                'seo_description',  // seo текст
                'images',           // фото
                'images_alts',      // надписи фото
                'images_texts',     // описания фото
                'images_view',      // слайдинг-признаки
                'tags',             // теги
                'template',         // шаблон
                'browsed',          // просмотры
                'rating',           // рейтинг
                'votes',            // голосов в рейтинге
                'order_num',        // вес
                'date',             // опубликовано
                'created',          // создано
                'modified',         // изменено
                'objects',          // плагины
                'section'           // ИД отдела магазина
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'News';
        protected $operables_card = 'NewsItem';
        protected $operables = array('move_up', 'move_down', 'move_first', 'move_last',
                                     'delete', 'edit',
                                     'enable', 'highlight', 'hidden', 'commented', 'listed');



        // =======================================================================
        // Выбрать из базы данных записи о новостях согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->ids] = идентификаторы новостей (перечисленные через запятую)
        //   [$params->category_id] = идентификатор категории
        //   [$params->brand_id] = идентификатор бренда
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->section] = раздел магазина
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        //   [$params->listed] = признак "в анонсовых списках"
        //   [$params->commented] = признак "разрешено обсуждение"
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->menu_id] = идентификатор меню
        //   [$params->objected] = с подгружаемыми модулями
        //   [$params->browsed] = просмотренные
        //   [$params->voted] = с выставленными оценками
        //   [$params->SEOed] = с SEO текстом
        //   [$params->url_special] = с особым url
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        //   [$params->minimum_info] = признак режима минимума информации
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' get');

            $items = array();
            $where = '';
            $order = '';
            $limit = '';

            // определяем минимальный набор полей
            $fields = '`' . $dbtable . '`.`' . $idfield . '`, '
                    . '`' . $dbtable . '`.`header`, '
                    . '`' . $dbtable . '`.`url`, '
                    . '`' . $dbtable . '`.`url_special`';

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {

                    // по названию
                    case SORT_NEWS_MODE_BY_HEADER:
                        $order = '`' . $dbtable . '`.`header` ASC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по дате создания
                    case SORT_NEWS_MODE_BY_CREATED:
                        $order = '`' . $dbtable . '`.`created` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`created`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по дате изменения
                    case SORT_NEWS_MODE_BY_MODIFIED:
                        $order = '`' . $dbtable . '`.`modified` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`modified`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по дате публикации
                    case SORT_NEWS_MODE_BY_DATE:
                        $order = '`' . $dbtable . '`.`date` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`date`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по количеству просмотров
                    case SORT_NEWS_MODE_BY_BROWSED:
                        $order = '`browsed` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по адресу страницы
                    case SORT_NEWS_MODE_BY_URL:
                        $order = '`' . $dbtable . '`.`url` ASC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по меню
                    case SORT_NEWS_MODE_BY_MENU:
                        $order = '`menu` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `menu`.`name` AS `menu`, '
                                    . '`' . $dbtable . '`.`order_num`, '
                                    . '`categories`.`name` AS `category`';
                        break;

                    // по плагинам
                    case SORT_NEWS_MODE_BY_OBJECTS:
                        $order = '`' . $dbtable . '`.`objects` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`objects`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по количеству голосов
                    case SORT_NEWS_MODE_BY_VOTES:
                        $order = '`votes` DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', ABS(`' . $dbtable . '`.`votes`) AS `votes`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // по рейтингу
                    case SORT_NEWS_MODE_BY_RATING:
                        $order = '`rating` / (`votes` + 1) DESC, '
                               . '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', ABS(`' . $dbtable . '`.`rating`) AS `rating`, '
                                   . 'ABS(`' . $dbtable . '`.`votes`) AS `votes`, '
                                   . '`' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                        break;

                    // как расставлены
                    case SORT_NEWS_MODE_AS_IS:
                    default:
                        $order = '`category` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        $fields .= ', `' . $dbtable . '`.`order_num`, '
                                   . '`categories`.`name` AS `category`';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN ("' . str_replace(',', '","', $this->cms->db->query_value($params->ids)) . '") ';
            if (isset($params->category_id)) $where .= 'AND `' . $dbtable . '`.`category_id` = "' . $this->cms->db->query_value($params->category_id) . '" ';
            if (isset($params->brand_id)) $where .= 'AND `' . $dbtable . '`.`brand_id` = "' . $this->cms->db->query_value($params->brand_id) . '" ';
            if (isset($params->user_id)) $where .= 'AND `' . $dbtable . '`.`user_id` = "' . $this->cms->db->query_value($params->user_id) . '" ';
            if (isset($params->section)) $where .= 'AND `' . $dbtable . '`.`section` = "' . $this->cms->db->query_value($params->section) . '" ';
            if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
            if (isset($params->highlighted)) $where .= 'AND `' . $dbtable . '`.`highlighted` = "' . $this->cms->db->query_value($params->highlighted) . '" ';
            if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
            if (isset($params->rss_disabled)) $where .= 'AND `' . $dbtable . '`.`rss_disabled` = "' . $this->cms->db->query_value($params->rss_disabled) . '" ';
            if (isset($params->export_disabled)) $where .= 'AND `' . $dbtable . '`.`export_disabled` = "' . $this->cms->db->query_value($params->export_disabled) . '" ';
            if (isset($params->listed)) $where .= 'AND `' . $dbtable . '`.`listed` = "' . $this->cms->db->query_value($params->listed) . '" ';
            if (isset($params->commented)) $where .= 'AND `' . $dbtable . '`.`commented` = "' . $this->cms->db->query_value($params->commented) . '" ';
            if (isset($params->imaged)) $where .= 'AND TRIM(REPLACE(`' . $dbtable . '`.`images`, "|", "")) != "" ';
            if (isset($params->menu_id)) $where .= 'AND `' . $dbtable . '`.`menu_id` = "' . $this->cms->db->query_value($params->menu_id) . '" ';
            if (isset($params->objected)) $where .= 'AND TRIM(`' . $dbtable . '`.`objects`) != "" ';
            if (isset($params->browsed)) $where .= 'AND `' . $dbtable . '`.`browsed` != 0 ';
            if (isset($params->voted)) $where .= 'AND `' . $dbtable . '`.`votes` != 0 ';
            if (isset($params->SEOed)) $where .= 'AND TRIM(`' . $dbtable . '`.`seo_description`) != "" ';
            if (isset($params->url_special)) $where .= 'AND `' . $dbtable . '`.`url_special` = "' . $this->cms->db->query_value($params->url_special) . '" ';
            if ($where != '') $where = 'WHERE 1 ' . $where;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // если нет признака режима минимума информации, берем все поля
            if (!isset($params->minimum_info)) {
                $fields = '`' . $dbtable . '`.*, '
                        . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                        . 'ABS(`' . $dbtable . '`.`rating`) AS `rating`, '
                        . 'ABS(`' . $dbtable . '`.`votes`) AS `votes`, '
                        . '`categories`.`name` AS `category`, '
                        . '`categories`.`url` AS `category_url`, '
                        . '`categories`.`url_special` AS `category_url_special`, '
                        . '`brands`.`name` AS `brand`, '
                        . '`brands`.`url` AS `brand_url`, '
                        . '`brands`.`url_special` AS `brand_url_special`, '
                        . '`users`.`name` AS `user_name`, '
                        . '`menu`.`name` AS `menu`, '
                        . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%Y-%m-%d %H:%i") AS `date`, '
                        . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%Y-%m-%d") AS `date_date`, '
                        . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%H:%i") AS `date_time` ';
            }

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS ' . $fields . ' '
                   . 'FROM `' . $dbtable . '` '
                   . 'LEFT JOIN `categories` ON `categories`.`category_id` = `' . $dbtable . '`.`category_id` '
                   . 'LEFT JOIN `brands` ON `brands`.`brand_id` = `' . $dbtable . '`.`brand_id` '
                   . 'LEFT JOIN `users` ON `users`.`user_id` = `' . $dbtable . '`.`user_id` '
                   . 'LEFT JOIN `menu` ON `menu`.`menu_id` = `' . $dbtable . '`.`menu_id` '
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
        // Взять из базы данных запись о новости, указанной в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->header] = заголовок новости
        //   [$params->menu_id] = идентификатор меню
        //   [$params->user_id] = идентификатор пользователя
        //   [$params->section] = раздел магазина
        //   [$params->url] = адрес страницы записи
        //   [$params->url_special] = с особым url
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->highlighted] = признак "выделена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->rss_disabled] = признак "не для rss"
        //   [$params->export_disabled] = признак "не для экспорта"
        // =======================================================================

        public function one ( & $item, $params = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' one');

            $item = null;
            $where = '';

            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = "' . $this->cms->db->query_value($params->id) . '" ';
            if (isset($params->header)) $where .= 'AND `' . $dbtable . '`.`header` = "' . $this->cms->db->query_value($params->header) . '" ';
            if (isset($params->url)) $where .= 'AND `' . $dbtable . '`.`url` = "' . $this->cms->db->query_value($params->url) . '" ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` != "' . $this->cms->db->query_value($params->exclude_id) . '" ';
                if (isset($params->menu_id)) $where .= 'AND `' . $dbtable . '`.`menu_id` = "' . $this->cms->db->query_value($params->menu_id) . '" ';
                if (isset($params->user_id)) $where .= 'AND `' . $dbtable . '`.`user_id` = "' . $this->cms->db->query_value($params->user_id) . '" ';
                if (isset($params->section)) $where .= 'AND `' . $dbtable . '`.`section` = "' . $this->cms->db->query_value($params->section) . '" ';
                if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
                if (isset($params->highlighted)) $where .= 'AND `' . $dbtable . '`.`highlighted` = "' . $this->cms->db->query_value($params->highlighted) . '" ';
                if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
                if (isset($params->rss_disabled)) $where .= 'AND `' . $dbtable . '`.`rss_disabled` = "' . $this->cms->db->query_value($params->rss_disabled) . '" ';
                if (isset($params->export_disabled)) $where .= 'AND `' . $dbtable . '`.`export_disabled` = "' . $this->cms->db->query_value($params->export_disabled) . '" ';
                if (isset($params->url_special)) $where .= 'AND `' . $dbtable . '`.`url_special` = "' . $this->cms->db->query_value($params->url_special) . '" ';
                $where = 'WHERE 1 ' . $where;

                // делаем запрос
                $query = 'SELECT `' . $dbtable . '`.*, '
                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed`, '
                              . 'ABS(`' . $dbtable . '`.`rating`) AS `rating`, '
                              . 'ABS(`' . $dbtable . '`.`votes`) AS `votes`, '
                              . '`categories`.`name` AS `category`, '
                              . '`categories`.`url` AS `category_url`, '
                              . '`categories`.`url_special` AS `category_url_special`, '
                              . '`brands`.`name` AS `brand`, '
                              . '`brands`.`url` AS `brand_url`, '
                              . '`brands`.`url_special` AS `brand_url_special`, '
                              . '`users`.`name` AS `user_name`, '
                              . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%Y-%m-%d %H:%i") AS `date`, '
                              . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%Y-%m-%d") AS `date_date`, '
                              . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%H:%i") AS `date_time` '
                       . 'FROM `' . $dbtable . '` '
                       . 'LEFT JOIN `categories` ON `categories`.`category_id` = `' . $dbtable . '`.`category_id` '
                       . 'LEFT JOIN `brands` ON `brands`.`brand_id` = `' . $dbtable . '`.`brand_id` '
                       . 'LEFT JOIN `users` ON `users`.`user_id` = `' . $dbtable . '`.`user_id` '
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
        *  @param   object  $params     объект параметров = ВЕЛИЧИНА СКИДКИ
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {
            parent::unpack($item);
            $this->unpackName($item);
            $this->unpackBody($item);
            $this->unpackUrl($item, 'news');
            $this->unpackTreeUrl($item);
            $this->unpackImages($item);

            // поправляем поле имени администрирующего пользователя
            if (isset($item->user_name) && $item->user_name != '') {
                $user = new stdClass;
                $user->name = $item->user_name;
                $this->unpackUserName($user);
                $item->user_name = $user->compound_name;
            }
        }
    }



    return;
?>