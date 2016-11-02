<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Склады: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class StocksDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'stocks';
        public $id_field = 'stock_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                'name',             // название
                'enabled',          // разрешено
                'visible',          // видно пользователям
                'highlighted',      // выделено визуально
                'hidden',           // скрыто от неавторизованных

                // считать расходным
                'enable_debit'      => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Считать расходным"'),
                // считать приходным
                'enable_credit'     => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Считать приходным"'),

                'url',              // адрес
                'url_special',      // особый адрес
                'meta_title',       // мета заголовок
                'meta_keywords',    // мета ключевые слова
                'meta_description', // мета описание
                'annotation',       // описание
                'description',      // полное описание
                'seo_description',  // seo текст
                'image',            // главное фото
                'images',           // фото
                'images_alts',      // надписи фото
                'images_texts',     // описания фото
                'images_view',      // слайдинг-признаки
                'tags',             // теги
                'template',         // шаблон
                'browsed',          // просмотры
                'order_num',        // вес
                'created',          // создано
                'modified',         // изменено
                'objects'           // плагины
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'Stocks';
        protected $operables_card = 'Stock';
        protected $operables = array('move_up', 'move_down', 'move_first', 'move_last',
                                     'delete', 'edit',
                                     'enable', 'highlight', 'hidden', 'visible', 'enable_debit', 'enable_credit');



        // =======================================================================
        // Выбрать из базы данных записи о складах согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->ids] = идентификаторы складов (перечисленные через запятую)
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->visible] = признак "видима пользователям"
        //   [$params->enable_debit] = признак "считать расходным"
        //   [$params->enable_credit] = признак "считать приходным"
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->objected] = с подгружаемыми модулями
        //   [$params->browsed] = просмотренные
        //   [$params->SEOed] = с SEO текстом
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

                    // по названию
                    case SORT_STOCKS_MODE_BY_NAME:
                        $order = '`' . $dbtable . '`.`name` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;

                    // по дате создания
                    case SORT_STOCKS_MODE_BY_CREATED:
                        $order = '`' . $dbtable . '`.`created` DESC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;

                    // по дате изменения
                    case SORT_STOCKS_MODE_BY_MODIFIED:
                        $order = '`' . $dbtable . '`.`modified` DESC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;

                    // по количеству просмотров
                    case SORT_STOCKS_MODE_BY_BROWSED:
                        $order = '`browsed` DESC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;

                    // по адресу страницы
                    case SORT_STOCKS_MODE_BY_URL:
                        $order = '`' . $dbtable . '`.`url` ASC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;

                    // по плагинам
                    case SORT_STOCKS_MODE_BY_OBJECTS:
                        $order = '`' . $dbtable . '`.`objects` DESC, '
                               . '`' . $dbtable . '`.`order_num` DESC ';
                        break;

                    // как расставлены
                    case SORT_STOCKS_MODE_AS_IS:
                    default:
                        $order = '`' . $dbtable . '`.`order_num` DESC ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN ("' . str_replace(',', '","', $this->cms->db->query_value($params->ids)) . '") ';
            if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
            if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
            if (isset($params->visible)) $where .= 'AND `' . $dbtable . '`.`visible` = "' . $this->cms->db->query_value($params->visible) . '" ';
            if (isset($params->enable_debit)) $where .= 'AND `' . $dbtable . '`.`enable_debit` = "' . $this->cms->db->query_value($params->enable_debit) . '" ';
            if (isset($params->enable_credit)) $where .= 'AND `' . $dbtable . '`.`enable_credit` = "' . $this->cms->db->query_value($params->enable_credit) . '" ';
            if (isset($params->imaged)) $where .= 'AND (TRIM(REPLACE(`' . $dbtable . '`.`images`, "|", "")) != "" OR TRIM(`' . $dbtable . '`.`image`) != "") ';
            if (isset($params->objected)) $where .= 'AND TRIM(`' . $dbtable . '`.`objects`) != "" ';
            if (isset($params->browsed)) $where .= 'AND `' . $dbtable . '`.`browsed` != 0 ';
            if (isset($params->SEOed)) $where .= 'AND TRIM(`' . $dbtable . '`.`seo_description`) != "" ';
            if ($where != '') $where = 'WHERE 1 ' . $where;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $dbtable . '`.*, '
                                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed` '
                   . 'FROM `' . $dbtable . '` '
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
        // Взять из базы данных запись о складе, указанном в параметрах:
        //   $item = результат будет помещен в эту переменную
        //   [$params->id] = идентификатор записи
        //   [$params->exclude_id] = кроме идентификатора записи
        //   [$params->name] = название склада
        //   [$params->url] = адрес страницы записи
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->hidden] = признак "скрыта от чужих"
        //   [$params->visible] = признак "видима пользователям"
        //   [$params->enable_debit] = признак "считать расходным"
        //   [$params->enable_credit] = признак "считать приходным"
        // =======================================================================

        public function one ( & $item, $params = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' one');

            $item = null;
            $where = '';

            // фильтруем по запрошенным параметрам
            if (isset($params->id) && !empty($params->id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = "' . $this->cms->db->query_value($params->id) . '" ';
            if (isset($params->name)) $where .= 'AND `' . $dbtable . '`.`name` = "' . $this->cms->db->query_value($params->name) . '" ';
            if (isset($params->url)) $where .= 'AND `' . $dbtable . '`.`url` = "' . $this->cms->db->query_value($params->url) . '" ';
            if ($where != '') {
                if (isset($params->exclude_id)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` != "' . $this->cms->db->query_value($params->exclude_id) . '" ';
                if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
                if (isset($params->hidden)) $where .= 'AND `' . $dbtable . '`.`hidden` = "' . $this->cms->db->query_value($params->hidden) . '" ';
                if (isset($params->visible)) $where .= 'AND `' . $dbtable . '`.`visible` = "' . $this->cms->db->query_value($params->visible) . '" ';
                if (isset($params->enable_debit)) $where .= 'AND `' . $dbtable . '`.`enable_debit` = "' . $this->cms->db->query_value($params->enable_debit) . '" ';
                if (isset($params->enable_credit)) $where .= 'AND `' . $dbtable . '`.`enable_credit` = "' . $this->cms->db->query_value($params->enable_credit) . '" ';
                $where = 'WHERE 1 ' . $where;

                // делаем запрос
                $query = 'SELECT `' . $dbtable . '`.*, '
                              . 'ABS(`' . $dbtable . '`.`browsed`) AS `browsed` '
                       . 'FROM `' . $dbtable . '` '
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
            $this->unpackUrl($item, 'stocks');
            $this->unpackImages($item);
        }
    }



    return;
?>