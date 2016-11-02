<?php
    // макет справочника клиентской стороны
    require_once(dirname(__FILE__) . '/../.ref-models/BasicClientModel.php');



    // =======================================================================
    /**
    *  Клиентский модуль RSS
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientRss extends BasicClientREFModel {

        // признак "Модуль сам рисует свою страницу целиком"
        public $single = TRUE;

        // признак "Настройки вынесены в отдельную модель"
        protected $settings_external = TRUE;



        // ===================================================================
        /**
        *  Получение значения настройки как экранированного простого текста
        *
        *  @access  public
        *  @param   string  $name   имя настройки
        *  @return  string          значение
        */
        // ===================================================================

        public function escapeSetting ( $name ) {
            $value = $this->request->settings->getAsPlainText($name);
            return $this->text->escape($value);
        }



        // ===================================================================
        /**
        *  Создание стандартного MySQL-запроса элементов RSS
        *
        *  -------------------------------------------------------------------
        *  
        *  Запрос учитывает, что извлекаемая запись может быть разрешена/запрещена
        *  к показу на сайте, открыта/скрыта от неавторизованных (получатель RSS
        *  признается не находящимся на сайте), разрешена/запрещена к показу
        *  в RSS. Аналогично учитываются такие же состояния у ближайших
        *  родителей (категория и/или бренд) записи.
        *  
        *  -------------------------------------------------------------------
        *
        *  @access  protected
        *  @param   string  $dbtable    имя таблицы
        *  @param   string  $prefix     префикс URL
        *  @param   boolean $category   TRUE если нужно название категории
        *  @param   boolean $brand      TRUE если нужно название бренда
        *  @param   string  $name       имя поля названия
        *  @param   string  $info       имя поля описания
        *  @param   string  $date       имя поля даты
        *  @param   integer $count      число извлекаемых элементов
        *  @param   boolean $abstract   TRUE если может не иметь родителя
        *  @return  string              текст запроса
        */
        // ===================================================================

        protected function buildQuery ( $dbtable, $prefix, $category, $brand, $name, $info, $date, $count, $abstract = FALSE ) {
            return 'SELECT `' . $dbtable . '`.`' . $name . '` AS `name`, '
                        . '`' . $dbtable . '`.`url`, '
                        . 'CASE WHEN `' . $dbtable . '`.`url_special` = 1 '
                             . 'THEN "" '
                             . 'ELSE "' . $prefix . '" '
                             . 'END AS `url_path`, '
                        . '`' . $dbtable . '`.`' . $info . '` AS `info`, '
                        . ($category ? '`categories`.`single_name` AS `category`, ' : '')
                        . ($brand ? '`brands`.`name` AS `brand`, ' : '')
                        . '`' . $dbtable . '`.`' . $date . '`, '
                        . 'DATE_FORMAT(`' . $dbtable . '`.`' . $date . '`, "%a, %d %b %Y %H:%i:%s +0200") AS `date` '
                 . 'FROM `' . $dbtable . '` '
                 . 'LEFT JOIN `categories` ON `categories`.`category_id` = `' . $dbtable . '`.`category_id` '
                 . 'LEFT JOIN `brands` ON `brands`.`brand_id` = `' . $dbtable . '`.`brand_id` '
                 . 'WHERE `' . $dbtable . '`.`enabled` = 1 '
                        . 'AND `' . $dbtable . '`.`hidden` = 0 '
                        . 'AND `' . $dbtable . '`.`rss_disabled` = 0 '
                        . ($abstract ? 'AND (`categories`.`enabled` IS NULL OR `categories`.`enabled` = 1) '
                                     . 'AND (`categories`.`hidden` IS NULL OR `categories`.`hidden` = 0) '
                                     . 'AND (`categories`.`rss_disabled` IS NULL OR `categories`.`rss_disabled` = 0) '
                                     : 'AND `categories`.`enabled` = 1 '
                                     . 'AND `categories`.`hidden` = 0 '
                                     . 'AND `categories`.`rss_disabled` = 0 ')
                        . 'AND (`brands`.`enabled` IS NULL OR `brands`.`enabled` = 1) '
                        . 'AND (`brands`.`hidden` IS NULL OR `brands`.`hidden` = 0) '
                        . 'AND (`brands`.`rss_disabled` IS NULL OR `brands`.`rss_disabled` = 0) '
                 . 'ORDER BY `' . $dbtable . '`.`' . $date . '` DESC '
                 . 'LIMIT ' . $count . ';';
        }



        // ===================================================================
        /**
        *  Создание MySQL-запроса для элементов RSS типа комментарии
        *
        *  -------------------------------------------------------------------
        *  
        *  Запрос учитывает, что извлекаемая запись может быть разрешена/запрещена
        *  к показу на сайте. Это же состояние учтено в связанной с ней записи,
        *  и дополнительно, что связанная запись может быть открыта/скрыта от
        *  неавторизованных (получатель RSS признается не находящимся на сайте),
        *  разрешена/запрещена к показу в RSS. Аналогично учитываются такие же
        *  состояния у ближайших родителей (категория и/или бренд) связанной записи.
        *  
        *  -------------------------------------------------------------------
        *
        *  @access  protected
        *  @param   string  $dbtable    имя таблицы
        *  @param   string  $dbtable2   имя связанной таблицы
        *  @param   string  $idfield2   имя поля идентификатора связанной таблицы
        *  @param   string  $prefix     префикс URL
        *  @param   string  $name       имя поля названия в связанной таблице
        *  @param   integer $count      число извлекаемых элементов
        *  @param   boolean $abstract   TRUE если связанная запись может не иметь родителя
        *  @return  string              текст запроса
        */
        // ===================================================================

        protected function buildCommentsQuery ( $dbtable, $dbtable2, $idfield2, $prefix, $name, $count, $abstract = FALSE ) {
            return 'SELECT `' . $dbtable2 . '`.`' . $name . '` AS `name`, '
                        . '`' . $dbtable2 . '`.`url`, '
                        . 'CASE WHEN `' . $dbtable2 . '`.`url_special` = 1 '
                             . 'THEN "" '
                             . 'ELSE "' . $prefix . '" '
                             . 'END AS `url_path`, '
                        . '`' . $dbtable . '`.`comment_id` AS `id`, '
                        . '`' . $dbtable . '`.`comment` AS `info`, '
                        . '`' . $dbtable . '`.`name` AS `category`, '
                        . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%d.%m.%Y %H:%i") AS `brand`, '
                        . '`' . $dbtable . '`.`date` AS `sorter`, '
                        . 'DATE_FORMAT(`' . $dbtable . '`.`date`, "%a, %d %b %Y %H:%i:%s +0200") AS `date` '
                 . 'FROM `' . $dbtable . '` '
                 . 'LEFT JOIN `' . $dbtable2 . '` ON `' . $dbtable2 . '`.`' . $idfield2 . '` = `' . $dbtable . '`.`' . $idfield2 . '` '
                 . 'LEFT JOIN `categories` ON `categories`.`category_id` = `' . $dbtable2 . '`.`category_id` '
                 . 'LEFT JOIN `brands` ON `brands`.`brand_id` = `' . $dbtable2 . '`.`brand_id` '
                 . 'WHERE `' . $dbtable . '`.`enabled` = 1 '
                        . 'AND `' . $dbtable2 . '`.`enabled` = 1 '
                        . 'AND `' . $dbtable2 . '`.`hidden` = 0 '
                        . 'AND `' . $dbtable2 . '`.`rss_disabled` = 0 '
                        . ($abstract ? 'AND (`categories`.`enabled` IS NULL OR `categories`.`enabled` = 1) '
                                     . 'AND (`categories`.`hidden` IS NULL OR `categories`.`hidden` = 0) '
                                     . 'AND (`categories`.`rss_disabled` IS NULL OR `categories`.`rss_disabled` = 0) '
                                     : 'AND `categories`.`enabled` = 1 '
                                     . 'AND `categories`.`hidden` = 0 '
                                     . 'AND `categories`.`rss_disabled` = 0 ')
                        . 'AND (`brands`.`enabled` IS NULL OR `brands`.`enabled` = 1) '
                        . 'AND (`brands`.`hidden` IS NULL OR `brands`.`hidden` = 0) '
                        . 'AND (`brands`.`rss_disabled` IS NULL OR `brands`.`rss_disabled` = 0) '
                 . 'ORDER BY `sorter` DESC '
                 . 'LIMIT ' . $count . ';';
        }



        // ===================================================================
        /**
        *  Обработка MySQL-запроса элементов RSS
        *
        *  @access  protected
        *  @param   string  $query      текст запроса
        *  @param   string  $type       название типа элементов
        *  @param   string  $tags       список разрешенных тегов
        *  @param   boolean $light      TRUE если не выводить описание элемента
        *  @param   boolean $asComment  TRUE если поле описания обрабатывать как комментарий
        *  @param   integer $maxsize    максимальный размер комментария, после чего выводить ...
        *  @return  string              тело ответа
        */
        // ===================================================================

        protected function processQuery ( $query, $type, $tags, $light, $asComment = FALSE, $maxsize = 512 ) {
            $body = '';
            $this->cms->db->query($query);
            $items = $this->cms->db->results();
            if (!empty($items)) {

                $root = 'http://' . $this->cms->root_url . '/';
                $crlf = "\r\n";
                foreach ($items as & $item) {

                    // поле Тип + [категория] + [бренд] + Название
                    $name = ltrim($type . ' | ', ' |')
                          . ltrim($this->getProperty($item, 'category') . ' | ', ' |')
                          . ltrim($this->getProperty($item, 'brand') . ' | ', ' |')
                          . $this->getProperty($item, 'name');
                        $name = $this->text->stripTags($name, TRUE);
                        $name = $this->text->escape($name);

                    // поле URL страницы
                    $uri = $this->getProperty($item, 'url_path') . $this->getProperty($item, 'url');
                    $hash = '';

                    // поле Описание
                    $info = '';
                    if ($asComment) {
                        $hash = trim($this->getProperty($item, 'id'));
                        if ($hash != '') $hash = '#comment-' . strtolower(md5($hash));
                        if ($maxsize > 0) {
                            $info = $this->getProperty($item, 'info');
                            $info = $this->text->asHtmlComment($info, $maxsize);
                        }
                    } else {
                        if (!$light) {
                            $info = strip_tags($this->getProperty($item, 'info'), $tags);
                        }
                    }
                    $info = $this->xml->cdataText($info);

                    // добавляем RSS-элемент
                    $body .= '        <item>' . $crlf
                           . '            <title>' . $name . '</title>' . $crlf
                           . '            <guid isPermaLink="true">' . $this->text->escape($root . $uri . $hash) . '</guid>' . $crlf
                           . '            <link>' . $this->text->escape($root . $uri . $hash) . '</link>' . $crlf
                           . '            <description>' . $info . '</description>' . $crlf
                           . '            <category>' . $type . '</category>' . $crlf
                           . '            <pubDate>' . $this->getProperty($item, 'date') . '</pubDate>' . $crlf
                           . '        </item>' . $crlf;
                }
            }
            return $body;
        }



        // ===================================================================
        /**
        *  Получение конкретной настройки "Список разрешенных тегов"
        *
        *  @access  protected
        *  @param   string  $name   имя настройки
        *  @return  string          строка с тегами
        */
        // ===================================================================

        protected function getEnabledTags ( $name ) {
            $tags = $this->request->settings->getAsSentence($name);
            $tags = $this->text->lowerCase($tags);
            $tags = trim(preg_replace('/[^a-z0-9]+/u', ' ', $tags));
            if ($tags != '') $tags = '<' . str_replace(' ', '><', $tags) . '>';
            return $tags;
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

            // может это режим "информер"?
            // TODO: информер надо вынести в отдельный модуль
            $mode = $this->request->getRequestAsSentence('mode');
            if ($this->text->lowerCase($mode) == 'informer') return $this->fetchInformer($parent);

            $prefix = $this->getSettingsPrefix();

            // серверные заголовки (учитываем, что это может быть диагностический вызов)
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            if ($this->request->existsRequest('diagnostic') && $this->security->existsAdmin()) {
                header('Content-Type: text/plain; charset=UTF-8');
            } else {
                header('Content-Type: text/xml; charset=UTF-8');
                header('Content-disposition: inline; filename="news.rss"');
                header('Content-Transfer-Encoding: binary');
            }

            // шапка RSS
            $crlf = "\r\n";
            $body = '<?xml version="1.0" encoding="utf-8" ?>' . $crlf
                  . '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">' . $crlf
                  . '    <channel>' . $crlf
                  . '        <title>' . $this->escapeSetting($prefix . 'title_text') . '</title>' . $crlf
                  . '        <link>' . $this->text->escape('http://' . $this->cms->root_url) . '</link>' . $crlf
                  . '        <description>' . $this->escapeSetting($prefix . 'description_text') . '</description>' . $crlf
                  . '        <language>' . $this->escapeSetting($prefix . 'language') . '</language>' . $crlf
                  . '        <copyright>' . $this->escapeSetting($prefix . 'copyright_text') . '</copyright>' . $crlf
                  . '        <generator>Impera CMS</generator>' . $crlf
                  . '        <ttl>' . $this->request->settings->getAsNatural($prefix . 'lifetime') . '</ttl>' . $crlf;

            // товары
            $count = $this->request->settings->getAsInteger($prefix . 'products_count');
            if ($count > 0) {
                $query = $this->buildQuery('products',      // имя таблицы
                                           'products/',     // префикс URL
                                           $this->request->settings->getAsBoolean('product_category_show'),
                                           $this->request->settings->getAsBoolean('product_brand_show'),
                                           'model',         // имя поля названия
                                           'description',   // имя поля описания
                                           $this->request->settings->getAsBoolean($prefix . 'products_modified_analize') ? 'modified' : 'created',
                                           $count,          // число извлекаемых записей
                                           FALSE);          // TRUE если может не иметь родителя

                $body .= $this->processQuery($query,        // текст запроса
                                             $this->request->settings->getAsPlainText($prefix . 'products_type'),
                                             $this->getEnabledTags($prefix . 'products_enabled_tags'),
                                             $this->request->settings->getAsBoolean($prefix . 'products_without_announce'));
            }

            // новости
            $count = $this->request->settings->getAsInteger($prefix . 'news_count');
            if ($count > 0) {
                $query = $this->buildQuery('news',          // имя таблицы
                                           'news/',         // префикс URL
                                           TRUE,            // TRUE если показать имя прикрепленной категории
                                           TRUE,            // TRUE если показать имя прикрепленного бренда
                                           'header',        // имя поля названия
                                           'annotation',    // имя поля описания
                                           $this->request->settings->getAsBoolean($prefix . 'news_modified_analize') ? 'modified' : 'created',
                                           $count,          // число извлекаемых записей
                                           TRUE);           // TRUE если может не иметь родителя

                $body .= $this->processQuery($query,        // текст запроса
                                             $this->request->settings->getAsPlainText($prefix . 'news_type'),
                                             $this->getEnabledTags($prefix . 'news_enabled_tags'),
                                             $this->request->settings->getAsBoolean($prefix . 'news_without_announce'));
            }

            // статьи
            $count = $this->request->settings->getAsInteger($prefix . 'articles_count');
            if ($count > 0) {
                $query = $this->buildQuery('articles',      // имя таблицы
                                           'articles/',     // префикс URL
                                           TRUE,            // TRUE если показать имя прикрепленной категории
                                           TRUE,            // TRUE если показать имя прикрепленного бренда
                                           'header',        // имя поля названия
                                           'annotation',    // имя поля описания
                                           $this->request->settings->getAsBoolean($prefix . 'articles_modified_analize') ? 'modified' : 'created',
                                           $count,          // число извлекаемых записей
                                           TRUE);           // TRUE если может не иметь родителя

                $body .= $this->processQuery($query,        // текст запроса
                                             $this->request->settings->getAsPlainText($prefix . 'articles_type'),
                                             $this->getEnabledTags($prefix . 'articles_enabled_tags'),
                                             $this->request->settings->getAsBoolean($prefix . 'articles_without_announce'));
            }

            // отзывы о товарах
            $count = $this->request->settings->getAsInteger($prefix . 'comments_count');
            if ($count > 0) {
                $query = $this->buildCommentsQuery('products_comments',    // имя таблицы
                                                   'products',             // имя связанной таблицы
                                                   'product_id',           // имя поля идентификатора связанной таблицы
                                                   'products/',            // префикс URL
                                                   'model',                // имя поля названия в связанной таблице
                                                   $count,                 // число извлекаемых записей
                                                   FALSE);                 // TRUE если связанная запись может не иметь родителя

                $body .= $this->processQuery($query,                       // текст запроса
                                             $this->request->settings->getAsPlainText($prefix . 'comments_type'),
                                             '',                           // разрешенные теги в комментариях
                                             FALSE,                        // TRUE если не выводить описание элемента
                                             TRUE,                         // TRUE если поле описания обрабатывать как комментарий
                                             $this->request->settings->getAsInteger($prefix . 'comments_maxsize'));
            }

            // комментарии новостей
            $count = $this->request->settings->getAsInteger($prefix . 'ncomments_count');
            if ($count > 0) {
                $query = $this->buildCommentsQuery('news_comments',    // имя таблицы
                                                   'news',             // имя связанной таблицы
                                                   'news_id',          // имя поля идентификатора связанной таблицы
                                                   'news/',            // префикс URL
                                                   'header',           // имя поля названия в связанной таблице
                                                   $count,             // число извлекаемых записей
                                                   TRUE);              // TRUE если связанная запись может не иметь родителя

                $body .= $this->processQuery($query,                   // текст запроса
                                             $this->request->settings->getAsPlainText($prefix . 'ncomments_type'),
                                             '',                       // разрешенные теги в комментариях
                                             FALSE,                    // TRUE если не выводить описание элемента
                                             TRUE,                     // TRUE если поле описания обрабатывать как комментарий
                                             $this->request->settings->getAsInteger($prefix . 'ncomments_maxsize'));
            }

            // комментарии статей
            $count = $this->request->settings->getAsInteger($prefix . 'acomments_count');
            if ($count > 0) {
                $query = $this->buildCommentsQuery('articles_comments',    // имя таблицы
                                                   'articles',             // имя связанной таблицы
                                                   'article_id',           // имя поля идентификатора связанной таблицы
                                                   'articles/',            // префикс URL
                                                   'header',               // имя поля названия в связанной таблице
                                                   $count,                 // число извлекаемых записей
                                                   TRUE);                  // TRUE если связанная запись может не иметь родителя

                $body .= $this->processQuery($query,                       // текст запроса
                                             $this->request->settings->getAsPlainText($prefix . 'acomments_type'),
                                             '',                           // разрешенные теги в комментариях
                                             FALSE,                        // TRUE если не выводить описание элемента
                                             TRUE,                         // TRUE если поле описания обрабатывать как комментарий
                                             $this->request->settings->getAsInteger($prefix . 'acomments_maxsize'));
            }

            // окончание RSS
            $body .= '    </channel>' . $crlf
                   . '</rss>' . $crlf;

            // отправляем в браузер
            $this->security->stop($body, 200);
        }



        // ===================================================================
        /**
        *  Визуализация информера
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetchInformer ( & $parent = null ) {
            // TODO: информер надо вынести в отдельный модуль
            @ header('Content-Type: application/x-javascript');
            $this->body = '';
            return TRUE;
            // $informer_num = 1;
            // if (isset($_REQUEST["num"]) == TRUE) $informer_num = @intval($_REQUEST["num"]);
            // if ($informer_num < 1) $informer_num = 1;
            // $params = new stdClass;
            // $params->destination = GET_PRODUCTS_DESTINATION_FOR_EXPORT;
            // $products = & ClientProduct::get_new_products($products = null, $params);
            // $this->smarty->assign("new_products", $products);
            // $products = & ClientProduct::get_ordered_products($products = null, $params);
            // $this->smarty->assign("ordered_products", $products);
            // $products = & ClientProduct::get_commented_products($products = null, $params);
            // $this->smarty->assign("commented_products", $products);
            // $products = & ClientProduct::get_hit_products($products = null, $params);
            // $this->smarty->assign("hit_products", $products);
            // $products = & ClientProduct::get_newest_products($products = null, $params);
            // $this->smarty->assign("newest_products", $products);
            // $products = & ClientProduct::get_actional_products($products = null, $params);
            // $this->smarty->assign("actional_products", $products);
            // $products = & ClientProduct::get_awaited_products($products = null, $params);
            // $this->smarty->assign("awaited_products", $products);
            // $this->smarty->assign("informer_number", $informer_num);
            // $this->smarty->assign("informer_maxcount", GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT);
            // return $this->smarty->fetchByTemplate($this, 'informer' . $informer_num, 'informer');
        }
    }



    return;
?>