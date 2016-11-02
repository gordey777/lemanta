<?php
    // =======================================================================
    /**
    *  Админ модуль редактора цен
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемой таблицы записей
    require_once(dirname(__FILE__) . '/../.ref-models/AdminTable.php');

    // текст заголовка страницы модуля
    define('PRICEEDITOR_PAGE_TITLE', 'Редактор цен');

    // имя файла шаблона модуля
    define('PRICEEDITOR_TEMPLATE_FILENAME', 'price_editor/price_editor.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('PRICEEDITOR_MODULELINK_POINTER', 'PriceEditor');
    define('PRICEEDITOR_MODULETAB_TEXT', 'цены');
    define('PRICEEDITOR_MODULEMENU_PATH', 'Товары / Редактор цен');



    // =======================================================================
    /**
    *  Админ модуль редактора цен
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PriceEditor extends AdminTableREFModel {

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = DATABASE_PRODUCTS_TABLENAME;
        protected $id_field = 'product_id';

        // имя модели базы данных
        protected $dbmodel = 'products';

        // имя файла шаблона
        protected $template = PRICEEDITOR_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Сбор параметров html-формы
        *
        *  @access  protected
        *  @param   object  $inputs         настоящие значения некоторых элементов html-формы (будут возвращены в эту переменную)
        *  @param   object  $params         параметры фильтра (будут возвращены в эту переменную)
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  void
        */
        // ===================================================================

        protected function collectInputs ( & $inputs, & $params, & $defaults ) {
            parent::collectInputs($inputs, $params, $defaults);

            // собираем параметры фильтра (категория)
            if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY])) {
                $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_CATEGORY]);
                if ($value != '') $params->category_id = $value;
                $inputs[REQUEST_PARAM_NAME_FILTER_CATEGORY] = $value;
            }
        }



        // ===================================================================
        /**
        *  Чтение записей таблицы
        *
        *  @access  protected
        *  @param   mixed   $data       дополнительные сведения
        *  @return  array               массив записей
        */
        // ===================================================================

        protected function getRecords ( & $data = null ) {

            // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $inputs = null;
            $params = null;
            $this->collectInputs($inputs, $params, $data);

            // передаем значения элементов html-формы в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);

            $filter = isset($params->category_id) ? intval($params->category_id) : FALSE;

            // читаем записи категорий
            $category_id = 'category_id';
            $dbtable = DATABASE_CATEGORIES_TABLENAME;
            $query = 'SELECT `' . $category_id . '`, '    // ид категории
                          . '`parent`, '                  // ид родительской категории
                          . '`name`, '                    // название категории
                          . '`url`, '                     // url (относительный)
                          . '`url_special`, '             // признак особого URL
                          . '`enabled` '                  // разрешена или нет
                   . 'FROM `' . $dbtable . '` '
                   . 'ORDER BY `name` ASC;';
            $result = $this->cms->db->query($query);

            // перебираем результат
            $items = array();
            if (!empty($result)) {
                $categories = array();
                while ($row = $this->cms->db->fetch_object($result)) {
                    $me = intval($row->$category_id);
                    if (!empty($me)) {

                        // определяем ИД родителя
                        $parent = intval($row->parent);
                        if ($parent == $me) $parent = 0;

                        // распаковываем поля записи
                        $row->name = trim($row->name);
                        if ($row->name == '') $row->name = 'Без названия, ИД = ' . $me;

                        $row->url = trim($row->url);
                        if ($row->url == '') $row->url = $me;
                        $row->url_path = $row->url_special ? '' : 'catalog/';

                        // технические поля
                        $row->filled = FALSE;
                        $row->selected = $filter !== FALSE && ($me == $filter || $filter == 0 && $parent == 0);

                        // если такую еще не использовали
                        if (!isset($categories[$me])) {
                            $row->subitems = array();
                            $categories[$me] = $row;

                        // может когда-то ссылались на такую, копируем в ссылку поля записи
                        } elseif (!isset($categories[$me]->$category_id)) {
                            foreach ($row as $i => & $v) $categories[$me]->$i = $v;
                        }

                        // если указан родитель
                        if (!empty($parent)) {

                            // если родитель еще не встречался
                            if (!isset($categories[$parent])) {
                                $categories[$parent] = new stdClass;
                                $categories[$parent]->filled = FALSE;
                                $categories[$parent]->subitems = array();
                            }

                            // крепим к родителю
                            if (!isset($categories[$parent]->subitems[$me])) $categories[$parent]->subitems[$me] = & $categories[$me];
                        }
                    }
                }

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // читаем записи товаров
                $product_id = 'product_id';
                $dbtable2 = DATABASE_PRODUCTS_TABLENAME;
                $query = 'SELECT `' . $product_id . '`, '     // ид товара
                              . '`' . $category_id . '`, '    // ид категории
                              . '`pcode`, '                   // буквенный код
                              . '`model`, '                   // название
                              . '`url`, '                     // url (относительный)
                              . '`url_special`, '             // признак особого URL
                              . '`enabled` '                  // разрешен или нет
                       . 'FROM `' . $dbtable2 . '` '
                       . 'ORDER BY `model` ASC;';
                $result = $this->cms->db->query($query);

                // перебираем результат
                if (!empty($result)) {
                    $products = array();
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $me = intval($row->$product_id);
                        if (!empty($me)) {

                            // если указан родитель
                            $parent = intval($row->$category_id);
                            if (!empty($parent)) {

                                // если родитель еще не встречался
                                if (!isset($categories[$parent])) {
                                    $categories[$parent] = new stdClass;
                                    $categories[$parent]->filled = TRUE;
                                    $categories[$parent]->subitems = array();
                                }

                                // распаковываем поля записи
                                $row->model = trim($row->model);
                                if ($row->model == '') $row->model = 'Без названия, ИД = ' . $me;

                                $row->url = trim($row->url);
                                if ($row->url == '') $row->url = $me;
                                $row->url_path = $row->url_special ? '' : 'products/';

                                $row->variants = array();

                                // сообщаем родителям о наличии товаров
                                if (!isset($categories[$parent]->products)) {
                                    $i = $parent;
                                    while (!empty($i) && !$categories[$i]->filled) {
                                        $categories[$i]->filled = TRUE;
                                        $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                                    }
                                    $categories[$parent]->products = array();
                                }

                                // крепим к категории
                                $products[$me] = $row;
                                $categories[$parent]->products[$me] = & $products[$me];
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // читаем записи вариантов товара
                    $variant_id = 'variant_id';
                    $dbtable4 = DATABASE_PRODUCTS_VARIANTS_TABLENAME;
                    $query = 'SELECT `' . $variant_id . '`, '     // ид варианта товара
                                  . '`' . $product_id . '`, '     // ид товара
                                  . '`sku`, '                     // артикул варианта
                                  . '`name`, '                    // название варианта
                                  . '`price`, '                   // цена варианта (основная ценовая группа)
                                  . '`temp_price`, '              // акционная цена варианта
                                  . '`old_price`, '               // старая цена варианта
                                  . '`priority_discount`, '       // приоритетная скидка варианта
                                  . '`stock` '                    // количество на складе
                           . 'FROM `' . $dbtable4 . '` '
                           . 'ORDER BY `name` ASC;';
                    $result = $this->cms->db->query($query);

                    // перебираем результат
                    if (!empty($result)) {
                        while ($row = $this->cms->db->fetch_object($result)) {
                            $me = intval($row->$variant_id);
                            if (!empty($me)) {

                                // если есть родитель
                                $parent = intval($row->$product_id);
                                if (!empty($parent)) {
                                    if (isset($products[$parent])) {

                                        // крепим к товару
                                        $products[$parent]->variants[$me] = $row;
                                    }
                                }
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);
                }

                // отбираем корневые категории и выпавшие (их признаем корневыми)
                foreach ($categories as $i => & $v) {
                    if (!empty($v->filled)) {
                        if (isset($v->$category_id) && empty($v->parent)) {
                            $items[$i] = & $categories[$i];
                        } elseif (!empty($i) && !isset($v->$category_id)) {
                            $categories[$i]->$category_id = $i;
                            $categories[$i]->parent = 0;
                            $categories[$i]->enabled = 0;
                            $categories[$i]->name = 'Несуществующая (выпавшая) категория, ИД = ' . $i;
                            $categories[$i]->selected = $filter !== FALSE && ($i == $filter || $filter == 0);
                            $items[$i] = & $categories[$i];
                        }
                        if (!empty($v->selected)) {
                            $i = $v->parent;
                            while (!empty($i) && !$categories[$i]->selected) {
                                $categories[$i]->selected = 1;
                                $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                            }
                        }
                    }
                }
            }

            // возвращаем массив записей
            return $items;
        }



        // ===================================================================
        /**
        *  Обработка редактирования записи
        *
        *  @access  protected
        *  @param   string  $result_page    страница возврата из операции
        *  @return  boolean                 TRUE если замечена ошибка
        */
        // ===================================================================

        protected function processRecordEdit ( & $result_page = '' ) {

            // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
            $cancel = FALSE;

            // если получены данные об изменениях и нет признака отмены постинга
            if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST])
            && (!isset($_POST[REQUEST_PARAM_NAME_IGNORE_POST]) || !$_POST[REQUEST_PARAM_NAME_IGNORE_POST])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->checkToken();

                $rate = $this->currency->rate();

                // цикл по измененным записям
                foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if (!isset($_POST[REQUEST_PARAM_NAME_POST_THISONE]) || isset($_POST[REQUEST_PARAM_NAME_POST_THISONE][$id])) {
                        if (!empty($id)) {
                            $item_cancel = FALSE;
                            $blank_item = new stdClass;
                            $this->item = new stdClass;

                            // цена (первая группа)
                            $field = 'price';
                            if (isset($_POST[$field][$id])) {
                                $value = $this->number->floatValue($_POST[$field][$id]);
                                $value = max($value, 0);
                                $this->item->$field = $value * $rate;
                            }

                            // старая цена
                            $field = 'old_price';
                            if (isset($_POST[$field][$id])) {
                                $value = $this->number->floatValue($_POST[$field][$id]);
                                $value = max($value, 0);
                                $this->item->$field = $value * $rate;
                            }

                            // акционная цена
                            $field = 'temp_price';
                            if (isset($_POST[$field][$id])) {
                                $value = $this->number->floatValue($_POST[$field][$id]);
                                $value = max($value, 0);
                                $this->item->$field = $value * $rate;
                            }

                            // приоритетная скидка
                            $field = 'priority_discount';
                            if (isset($_POST[$field][$id])) {
                                $value = is_numeric($_POST[$field][$id]) ? $this->number->floatValue($_POST[$field][$id]) : -1;
                                $value = min($value, 100);
                                if ($value < 0) $value = -1;
                                $this->item->$field = $value;
                            }

                            // наличие на складе
                            $field = 'stock';
                            if (isset($_POST[$field][$id])) {
                                $this->item->$field = intval($_POST[$field][$id]);
                            }

                            // если ошибок нет (не включился признак отмены)
                            if (!$item_cancel && !empty($this->item) && $this->item != $blank_item) {
                                $this->item->variant_id = $id;

                                // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
                                $this->item->indifferent_caches = TRUE;
                                $changed = $this->cms->db->products->update_variant($this->item) != '';
                                $this->changed = $changed || $this->changed;

                                // если страница возврата не указана, используем рекомендуемую страницу
                                if ($result_page == '' && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
                            }

                            $cancel = $cancel || $item_cancel;
                        }
                    }
                }
            }

            // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
            return $cancel;
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(PRICEEDITOR_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>