<?php
    // =======================================================================
    /**
    *  Админ модуль обработки "Выпавшие записи"
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // текст заголовка страницы модуля
    define('FALLEN_PAGE_TITLE', 'Выпавшие записи базы данных');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('FALLEN_TEMPLATE_FILENAME', 'fallen/fallen.htm');
    define('FALLEN_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                   . FALLEN_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // имена переменных в шаблонизаторе
    define('FALLEN_SMARTYVAR_CATEGORIES', 'fallen_categories');
    define('FALLEN_SMARTYVAR_BRANDS', 'fallen_brands');
    define('FALLEN_SMARTYVAR_PRODUCTS', 'fallen_products');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('FALLEN_MODULELINK_POINTER', 'Fallen');
    define('FALLEN_MODULETAB_TEXT', 'выпавшие');
    define('FALLEN_MODULEMENU_PATH', 'Утилиты / Починка / Выпавшие записи');



    // =======================================================================
    /**
    *  Админ модуль обработки "Выпавшие записи"
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Fallen extends Basic {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
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

            // устанавливаем заголовок страницы
            $this->title = ADMIN_PAGE_TITLE_PREFIX . FALLEN_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = FALLEN_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . FALLEN_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->admin_folder);
            $path .= '/design/' . $this->hdd->safeFilename($this->settings->admin_theme) . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return;

            // обрабатываем входные параметры
            $this->process();

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Получение массива записей выпавших категорий / брендов
        *
        *  @access  protected
        *  @param   string  $id         имя поля идентификатора
        *  @param   string  $dbtable    имя таблицы
        *  @return  array               массив записей
        */
        // ===================================================================

        protected function fallen_cats ( $id = 'category_id', $dbtable = DATABASE_CATEGORIES_TABLENAME ) {

            // выполняем запрос
            $result = $this->db->query('SELECT ' . $id . ', '
                                            . 'parent, '
                                            . 'TRIM(name) AS name, '
                                            . 'url, '
                                            . 'url_special, '
                                            . 'CASE WHEN parent = 0 '
                                                 . 'THEN \'\' '
                                                 . 'ELSE TRIM(description) '
                                                 . 'END AS description, '
                                            . 'enabled, '
                                            . 'order_num '
                                     . 'FROM ' . $dbtable . ' '
                                     . 'ORDER BY order_num DESC;');

            // перебираем результат
            $items = array();
            if (!empty($result)) {
                $used = array();
                while ($row = $this->db->fetch_object($result)) {

                    // если такую еще не использовали
                    $me = intval($row->$id);
                    if (!empty($me)) {
                        if (!isset($used[$me])) {
                            $row->subitems = array();
                            $used[$me] = $row;
                        } elseif (!isset($used[$me]->$id)) {
                            foreach ($row as $i => & $v) $used[$me]->$i = $v;
                        }

                        // крепим в использованном к родителю
                        $parent = intval($row->parent);
                        if ($parent == $me) $parent = ' ';
                        if (!isset($used[$parent])) {
                            $used[$parent] = new stdClass;
                            $used[$parent]->subitems = array();
                        }
                        if (!isset($used[$parent]->subitems[$me])) $used[$parent]->subitems[$me] = & $used[$me];
                    }
                }

                // освобождаем память от запроса
                $this->db->free_result($result);

                // отбираем выпавшие
                foreach ($used as $i => & $v) {
                    if (!empty($i) && !isset($v->$id)) $items[$i] = & $used[$i];
                }
            }

            // возвращаем массив записей
            return $items;
        }



        // ===================================================================
        /**
        *  Получение массива записей выпавших товаров
        *
        *  @access  protected
        *  @param   string  $id         имя поля идентификатора
        *  @param   string  $dbtable    имя таблицы
        *  @return  array               массив записей
        */
        // ===================================================================

        protected function fallen_products ( $id = 'product_id', $dbtable = DATABASE_PRODUCTS_TABLENAME ) {

            // булевые признаки пропавших связей
            $no_category_indicator = $dbtable . '.category_id = 0 OR ' . DATABASE_CATEGORIES_TABLENAME . '.enabled IS NULL';
            $no_brand_indicator = $dbtable . '.brand_id != 0 AND ' . DATABASE_BRANDS_TABLENAME . '.enabled IS NULL';

            // выполняем запрос
            $result = $this->db->query('SELECT ' . $dbtable . '.' . $id . ', '
                                                 . $dbtable . '.category_id, '
                                                 . $dbtable . '.brand_id, '
                                                 . 'TRIM(' . $dbtable . '.model) AS model, '
                                                 . $no_category_indicator . ' AS no_category, '
                                                 . $no_brand_indicator . ' AS no_brand, '
                                                 . $dbtable . '.url, '
                                                 . $dbtable . '.url_special, '
                                                 . $dbtable . '.enabled, '
                                                 . $dbtable . '.order_num '
                                     . 'FROM ' . $dbtable . ' '
                                     . 'LEFT JOIN ' . DATABASE_CATEGORIES_TABLENAME . ' '
                                                    . 'ON ' . DATABASE_CATEGORIES_TABLENAME . '.category_id = ' . $dbtable . '.category_id '
                                     . 'LEFT JOIN ' . DATABASE_BRANDS_TABLENAME . ' '
                                                    . 'ON ' . DATABASE_BRANDS_TABLENAME . '.brand_id = ' . $dbtable . '.brand_id '
                                     . 'WHERE ' . $no_category_indicator . ' OR ' . $no_brand_indicator . ' '
                                     . 'ORDER BY ' . $dbtable . '.category_id ASC, '
                                                   . $dbtable . '.brand_id ASC, '
                                                   . $dbtable . '.order_num DESC;');

            // перебираем результат
            $items = array();
            if (!empty($result)) {
                while ($row = $this->db->fetch_object($result)) $items[] = $row;

                // освобождаем память от запроса
                $this->db->free_result($result);
            }

            // возвращаем массив записей
            return $items;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process () {

            // получаем список выпавших категорий
            $categories = & $this->fallen_cats('category_id', DATABASE_CATEGORIES_TABLENAME);

            // добавляем в записи административные ссылки
            $params = new stdClass;
            $params->token = $this->token;
            foreach ($categories as $i => & $v) $this->db->operable_categories($categories[$i]->subitems, $params);

            // получаем список выпавших брендов
            $brands = & $this->fallen_cats('brand_id', DATABASE_BRANDS_TABLENAME);

            // добавляем в записи административные ссылки
            foreach ($brands as $i => & $v) $this->db->operable_brands($brands[$i]->subitems, $params);

            // получаем список выпавших товаров
            $products = & $this->fallen_products('product_id', DATABASE_PRODUCTS_TABLENAME);

            // добавляем в записи административные ссылки
            $this->db->products->operable($products, $params);

            // передаем записи в шаблонизатор
            $this->smarty->assignByRef(FALLEN_SMARTYVAR_CATEGORIES, $categories);
            $this->smarty->assignByRef(FALLEN_SMARTYVAR_BRANDS, $brands);
            $this->smarty->assignByRef(FALLEN_SMARTYVAR_PRODUCTS, $products);

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // передаем в шаблонизатор информационное сообщение
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        }
    }



    return;
?>