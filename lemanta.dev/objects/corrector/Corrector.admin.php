<?php
    // =======================================================================
    /**
    *  Админ модуль корректора полей
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
    define('CORRECTOR_PAGE_TITLE', 'Корректор полей');

    // имя файла шаблона модуля
    define('CORRECTOR_TEMPLATE_FILENAME', 'corrector/corrector.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('CORRECTOR_MODULELINK_POINTER', 'Corrector');
    define('CORRECTOR_MODULETAB_TEXT', 'корректор');
    define('CORRECTOR_MODULEMENU_PATH', 'Товары / Корректор полей');



    // =======================================================================
    /**
    *  Админ модуль корректора полей
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Corrector extends AdminTableREFModel {

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = DATABASE_PRODUCTS_TABLENAME;
        protected $id_field = 'product_id';

        // имя модели базы данных
        protected $dbmodel = 'products';

        // имя файла шаблона
        protected $template = CORRECTOR_TEMPLATE_FILENAME;



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

            // собираем параметры фильтра (процент надбавки к цене)
            $field = 'increment';
            if (isset($_REQUEST[$field])) {
                $value = trim($_REQUEST[$field]);
                if ($value != '') $params->$field = $value;
                $inputs[$field] = $value;
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
                $product_id = $this->id_field;
                $query = 'SELECT `' . $product_id . '`, '     // ид товара
                              . '`' . $category_id . '` '     // ид категории
                       . 'FROM `' . $this->dbtable . '`;';
                $result = $this->cms->db->query($query);

                // перебираем результат
                if (!empty($result)) {
                    while ($row = $this->cms->db->fetch_object($result)) {
                        if (!empty($row->$product_id)) {

                            // если указан родитель
                            $parent = intval($row->$category_id);
                            if (!empty($parent)) {

                                // если родитель еще не встречался
                                if (!isset($categories[$parent])) {
                                    $categories[$parent] = new stdClass;
                                    $categories[$parent]->filled = TRUE;
                                    $categories[$parent]->subitems = array();
                                }

                                // сообщаем родителям о наличии товаров
                                if (!isset($categories[$parent]->products)) {
                                    $i = $parent;
                                    while (!empty($i) && !$categories[$i]->filled) {
                                        $categories[$i]->filled = TRUE;
                                        $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                                    }
                                    $categories[$parent]->products = TRUE;
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

                // извлекаем надбавку к цене
                $field = 'increment';
                $increment = isset($_POST[$field]) ? $this->number->floatValue($_POST[$field]) : 0;
                $increment = max($increment, -100);
                $increment = $increment / 100;

                // цикл по измененным записям
                foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if (!isset($_POST[REQUEST_PARAM_NAME_POST_THISONE]) || isset($_POST[REQUEST_PARAM_NAME_POST_THISONE][$id])) {
                        if (!empty($id)) {
                            if ($increment != 0) {
                                $query = 'UPDATE `' . $this->dbtable . '`, '
                                              . '`' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '` '
                                       . 'SET `' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '`.`price` = `' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '`.`price` + `' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '`.`price` * ' . $this->cms->db->query_value($increment) . ' '
                                       . 'WHERE `' . $this->dbtable . '`.`category_id` = ' . $this->cms->db->query_value($id) . ' '
                                             . 'AND `' . $this->dbtable . '`.`' . $this->id_field . '` = `' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '`.`' . $this->id_field . '`;';
                                $this->cms->db->query($query);

                                $this->memcache->clear();
                            }
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
            if (!$this->checkTemplate(CORRECTOR_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>