<?php
    // макет редактируемой таблицы записей
    require_once(dirname(__FILE__) . '/../.ref-models/AdminTable.php');



    // =======================================================================
    /**
    *  Админ модуль мониторинга цен
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PriceMonitoring extends AdminTableREFModel {

        // заголовок страницы
        public $title = 'Мониторинг цен';

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = 'products';
        protected $id_field = 'product_id';

        // имя модели базы данных
        protected $dbmodel = 'products';

        // имя файла шаблона
        protected $template = 'price_monitoring/price_monitoring.htm';



        // ===================================================================
        /**
        *  Список целевых сайтов
        *
        *  @access  protected
        *  @return  array               массив целей, формат:
        *                                   'target_name' => 'Название сайта'
        */
        // ===================================================================

        protected function monitoringTargets () {
            return array( 'rozetka' => 'Rozetka.ua',
                          'hotline' => 'Hotline.ua',
                          'priceua' => 'Price.ua' );
        }



        // ===================================================================
        /**
        *  Проверка существования базовой валюты с таким кодом
        *
        *  @access  protected
        *  @param   string  $code       код валюты (например USD, UAH, RUR)
        *  @return  boolean             TRUE если существует
        *                               FALSE если нет
        */
        // ===================================================================

        protected function existsBaseCurrency ( $code ) {
            return isset($this->baseCurrency) && $this->currency->checkCode($this->baseCurrency, $code);
        }



        // ===================================================================
        /**
        *  Подготовка базовой валюты (установка свойства baseCurrency)
        *
        *  @access  protected
        *  @param   string  $code       код валюты (например USD, UAH, RUR)
        *  @return  boolean             TRUE если подготовлена
        *                               FALSE если нет такой валюты
        */
        // ===================================================================

        protected function prepareBaseCurrency ( $code ) {
            if (!$this->existsBaseCurrency($code)) {
                $this->baseCurrency = $this->currency->getByCode($code);
                if (empty($this->baseCurrency)) return FALSE;
            }
            return TRUE;
        }



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
            $field = 'filter_category';
            if ($this->request->existsRequest($field)) {
                $value = $this->request->getRequestAsSentence($field);
                if ($value != '') $params->category_id = $value;
                $inputs[$field] = $value;
            }

            // собираем параметры фильтра (товар)
            $field = 'filter_product';
            if ($this->request->existsRequest($field)) {
                $value = $this->request->getRequestAsSentence($field);
                if ($value != '') $params->product_id = $value;
                $inputs[$field] = $value;
            }

            // собираем параметры фильтра (целевой сайт)
            $field = 'filter_target';
            if ($this->request->existsRequest($field)) {
                $value = $this->request->getRequestAsSentence($field);
                if ($value != '') $params->monitoring_target = $value;
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
            $this->cms->smarty->assignByRef('inputs', $inputs);

            // передаем в шаблонизатор список целевых сайтов
            $targets = $this->monitoringTargets();
            $this->cms->smarty->assignByRef('targets', $targets);

            // фильтры
            $filter_category = isset($params->category_id) ? intval($params->category_id) : FALSE;
            $filter_product = isset($params->product_id) ? intval($params->product_id) : FALSE;

            // читаем записи категорий
            $category_id = 'category_id';
            $dbtable = 'categories';
            $query = 'SELECT `' . $category_id . '`, '    // ид категории
                          . '`parent`, '                  // ид родительской категории
                          . '`name`, '                    // название категории
                          . '`url`, '                     // url (относительный)
                          . '`url_special`, '             // признак особого URL
                          . '`enabled` '                  // разрешена или нет
                   . 'FROM `' . $dbtable . '` '
                   . 'ORDER BY `name` ASC;';
            $result = $this->cms->db->query($query);

            // читаем записи мониторинга категорий (пока их считаем не актуальными)
            $items = array();
            if (!empty($result)) {
                $this->cms->db->monitoring->check();
                $monitoring_id = 'monitoringId';
                $monitors = array();

                // только при условии, что такой сайт находится в списке целевых
                $site = isset($params->monitoring_target) ? trim($params->monitoring_target) : '';
                if ($site != '' && isset($targets[$site])) {
                    $query = 'SELECT `' . $monitoring_id . '`, '
                                  . '`scanable`, '
                                  . '`lifetime`, '
                                  . '`lasttime`, '
                                  . '`ourId`, '
                                  . '`ourType`, '
                                  . '`theirUrl`, '
                                  . '`theirName`, '
                                  . '`theirPrice` '
                           . 'FROM `monitoring` '
                           . 'WHERE `target` = "' . $this->cms->db->query_value($site) . '" '
                                 . 'AND `ourType` = "category" '
                           . 'ORDER BY `ourId` ASC;';
                    $result2 = $this->cms->db->query($query);
                    if (!empty($result2)) {
                        while ($row = $this->cms->db->fetch_object($result2)) {
                            $me = intval($row->ourId);
                            if (!empty($me)) {
                                $row->actual = FALSE;
                                $monitors[$me] = $row;
                            }
                        }
                        $this->cms->db->free_result($result2);
                    }
                }

                // перебираем результат чтения категорий
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

                        // параметры монитора
                        if (isset($monitors[$me])) {
                            $monitors[$me]->actual = TRUE;
                            foreach ($monitors[$me] as $i => & $v) $row->$i = $v;
                        } else {
                            $row->ourId = $me;
                            $row->ourType = 'category';
                            $row->scanable = 1;
                            $row->lifetime = 0;
                        }

                        // технические поля (при фильтре товара категорию пометим выбранной в переборе товаров)
                        $row->filled = FALSE;
                        $row->selected = $filter_product === FALSE
                                      && $filter_category !== FALSE
                                      && ($me == $filter_category || $filter_category == 0 && $parent == 0);

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
                                $categories[$parent]->ourId = $parent;
                                $categories[$parent]->ourType = 'category';
                                $categories[$parent]->scanable = 1;
                                $categories[$parent]->lifetime = 0;
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

                // чистим базу мониторинга от неактуальных записей
                if (!empty($monitors)) {
                    $ids = array();
                    foreach ($monitors as & $v) if (empty($v->actual)) $ids[] = $v->$monitoring_id;
                    unset($monitors);
                    if (!empty($ids)) $this->cms->db->query('DELETE FROM `monitoring` '
                                                          . 'WHERE `' . $monitoring_id . '` IN (' . implode(',', $ids) . ');');
                }

                // читаем записи товаров
                $product_id = 'product_id';
                $dbtable2 = 'products';
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

                // читаем записи мониторинга товаров (пока их считаем не актуальными)
                if (!empty($result)) {
                    $monitors = array();
                    if ($site != '' && isset($targets[$site])) {
                        $query = 'SELECT `' . $monitoring_id . '`, '
                                      . '`scanable`, '
                                      . '`lifetime`, '
                                      . '`lasttime`, '
                                      . '`ourId`, '
                                      . '`ourType`, '
                                      . '`theirUrl`, '
                                      . '`theirName`, '
                                      . '`theirPrice` '
                               . 'FROM `monitoring` '
                               . 'WHERE `target` = "' . $this->cms->db->query_value($site) . '" '
                                     . 'AND `ourType` = "product" '
                               . 'ORDER BY `ourId` ASC;';
                        $result2 = $this->cms->db->query($query);
                        if (!empty($result2)) {
                            while ($row = $this->cms->db->fetch_object($result2)) {
                                $me = intval($row->ourId);
                                if (!empty($me)) {
                                    $row->actual = FALSE;
                                    $monitors[$me] = $row;
                                }
                            }
                            $this->cms->db->free_result($result2);
                        }
                    }

                    // перебираем результат чтения товаров
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
                                    $categories[$parent]->ourId = $parent;
                                    $categories[$parent]->ourType = 'category';
                                    $categories[$parent]->scanable = 1;
                                    $categories[$parent]->lifetime = 0;
                                    $categories[$parent]->filled = TRUE;
                                    $categories[$parent]->subitems = array();
                                }

                                // распаковываем поля записи
                                $row->model = trim($row->model);
                                if ($row->model == '') $row->model = 'Без названия, ИД = ' . $me;

                                $row->url = trim($row->url);
                                if ($row->url == '') $row->url = $me;
                                $row->url_path = $row->url_special ? '' : 'products/';

                                // параметры монитора
                                if (isset($monitors[$me])) {
                                    $monitors[$me]->actual = TRUE;
                                    foreach ($monitors[$me] as $i => & $v) $row->$i = $v;
                                } else {
                                    $row->ourId = $me;
                                    $row->ourType = 'product';
                                    $row->scanable = 1;
                                    $row->theirPrice = null;
                                }

                                // если нет фильтра товара или это именно тот товар
                                if ($filter_product === FALSE || $me == $filter_product) {
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

                                    // при фильтре товара поиечаем категорию выбранной
                                    if ($filter_product !== FALSE) $categories[$parent]->selected = TRUE;
                                }
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // чистим базу мониторинга от неактуальных записей
                    if (!empty($monitors)) {
                        $ids = array();
                        foreach ($monitors as & $v) if (empty($v->actual)) $ids[] = $v->$monitoring_id;
                        unset($monitors);
                        if (!empty($ids)) $this->cms->db->query('DELETE FROM `monitoring` '
                                                              . 'WHERE `' . $monitoring_id . '` IN (' . implode(',', $ids) . ');');
                    }

                    // читаем записи вариантов товара
                    $variant_id = 'variant_id';
                    $dbtable4 = 'products_variants';
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
                            $categories[$i]->selected = $filter_product !== FALSE
                                                     || $filter_category !== FALSE
                                                     && ($i == $filter_category || $filter_category == 0);
                            $categories[$i]->ourId = $i;
                            $categories[$i]->ourType = 'category';
                            $categories[$i]->scanable = 0;
                            $categories[$i]->lifetime = 0;
                            $items[$i] = & $categories[$i];
                        }
                        if (!empty($v->selected)) {
                            $i = $v->parent;
                            while (!empty($i) && !$categories[$i]->selected) {
                                // 1 = выбрана ее ветвь (так как TRUE выделено для случая "именно она выбрана")
                                $categories[$i]->selected = 1;
                                $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                            }
                        }
                    }
                }
            }

            $this->monitorRecords($items, $params);

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
            if ($this->request->isPostedList()) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->checkToken();

                $rate = $this->currency->rate();
                $blank_item = new stdClass;

                $site = $this->request->getPostAsSentence('filter_target');
                $targets = $this->monitoringTargets();

                $errorMessages = array();
                $errorMessage = '';

                // цикл по измененным записям
                foreach ($_POST['post'] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if ($this->request->isPostedThisOne($id)) {
                        if (!empty($id)) {

                            // если был включен флажок "сохранять цены"
                            if ($this->request->getPostAsBoolean('save_prices')) {
                                // кроме записей о категориях (их id постили с префиксом c)
                                if (substr($id, 0, 1) != 'c') {
                                    $item_cancel = FALSE;
                                    $this->item = new stdClass;

                                    // цена (первая группа)
                                    $field = 'price';
                                    $value = $this->request->getPostRecordFieldAsFloat($field, $id, FALSE);
                                    if ($value !== FALSE) {
                                        $value = max($value, 0);
                                        $this->item->$field = $value * $rate;
                                    }

                                    // если ошибок нет (не включился признак отмены)
                                    if (!$item_cancel && !empty($this->item) && $this->item != $blank_item) {
                                        $this->item->variant_id = $id;

                                        // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
                                        $this->item->indifferent_caches = TRUE;
                                        $changed = $this->cms->db->products->update_variant($this->item) != '';
                                        $this->changed = $changed || $this->changed;

                                        // если страница возврата не указана, используем рекомендуемую страницу
                                        if ($result_page == '' && !$this->request->existsPost('post_as_accept')) $result_page = trim($this->result_page);
                                    }

                                    $cancel = $cancel || $item_cancel;
                                }
                            }

                            // если был включен флажок "сохранять параметры мониторинга"
                            if ($this->request->getPostAsBoolean('save_params')) {

                                // целевой сайт (обязателен, без него не обрабатываем запись)
                                if ($site != '' && isset($targets[$site])) {
                                    $item_cancel = FALSE;
                                    $item = new stdClass;
                                    $item->target = $site;

                                    // идентификатор нашего элемента (обязателен, без него не обрабатываем запись)
                                    $field = 'ourId';
                                    $value = $this->request->getPostRecordFieldAsInteger($field, $id);
                                    if (!empty($value)) {
                                        $item->$field = $value;

                                        // тип нашего элемента
                                        $item->ourType = substr($id, 0, 1) == 'c' ? 'category' : 'product';

                                        // признак "разрешен к мониторингу"
                                        $field = 'scanable';
                                        $item->$field = $this->request->getPostRecordFieldAsBoolean($field, $id) ? 1 : 0;

                                        // срок обновления
                                        $field = 'lifetime';
                                        $item->$field = $this->request->getPostRecordFieldAsInteger($field, $id);

                                        // штамп времени последнего обновления
                                        $field = 'lasttime';
                                        $value = $this->request->getPostRecordFieldAsInteger($field, $id, FALSE);
                                        if ($value !== FALSE) $item->$field = $value;

                                        // адрес сканируемой страницы
                                        $field = 'theirUrl';
                                        $value = $this->request->getPostRecordField($field, $id, FALSE);
                                        if ($value !== FALSE) {
                                            $item->$field = $value;
                                            if ($value != '' && !preg_match('!^https?://[^/\\\\]+!ui', $value)) {
                                                $errorMessages[$id] = 'Неправильный адрес сканируемой страницы: ' . $value . '! Должен быть указан в форме http://example.com/url-path.';
                                                $errorMessage = 'Имеются ошибки в заполнении адреса сканируемых страниц.';
                                            }
                                        }

                                        // название сканируемой страницы
                                        $field = 'theirName';
                                        $value = $this->request->getPostRecordField($field, $id, FALSE);
                                        if ($value !== FALSE) $item->$field = $value;

                                        // цена сканируемой страницы
                                        $field = 'theirPrice';
                                        $value = $this->request->getPostRecordFieldAsFloat($field, $id, FALSE);
                                        if ($value !== FALSE) {
                                            $value = max($value, 0);
                                            $item->$field = $value * $rate;
                                        }

                                        // если ошибок нет (не включился признак отмены)
                                        if (!$item_cancel && !empty($item) && $item != $blank_item) {

                                            // идентификатор записи (если не новая)
                                            $field = 'monitoringId';
                                            $value = $this->request->getPostRecordFieldAsInteger($field, $id);
                                            if (!empty($value)) $item->$field = $value;

                                            // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
                                            $item->indifferent_caches = TRUE;
                                            $changed = $this->cms->db->monitoring->update($item) != '';
                                            $this->changed = $changed || $this->changed;

                                            // если страница возврата не указана, используем рекомендуемую страницу
                                            if ($result_page == '' && !$this->request->existsPost('post_as_accept')) $result_page = trim($this->result_page);
                                        }

                                        $cancel = $cancel || $item_cancel;
                                    }
                                } else {
                                    $errorMessage = 'Не указан целевой сайт или он не входит в список разрешенных, поэтому сохранение параметров мониторинга отклонено.';
                                }
                            }
                        }
                    }
                }

                if (!empty($errorMessage)) {
                    $cancel = $this->pushError($errorMessage);
                    $this->cms->smarty->assignByRef('errorMessages', $errorMessages);
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
            if (!$this->checkTemplate()) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }



        // ===================================================================
        /**
        *  Мониторинг записей таблицы
        *
        *  @access  protected
        *  @param   array   $items      массив записей
        *  @param   object  $params     параметры фильтра (будут возвращены в эту переменную)
        *                                   monitoring_target = целевой сайт
        *  @return  void
        */
        // ===================================================================

        protected function monitorRecords ( & $items, & $params ) {
            if (!empty($items)) {
                $site = isset($params->monitoring_target) ? trim($params->monitoring_target) : '';
                $targets = $this->monitoringTargets();
                $error = $site == '' ? 'Не указан параметр filter_target (целевой сайт)!'
                                     : (isset($targets[$site]) ? '' : 'Целевой сайт не входит в список разрешенных!');
                $changes = 0;

                // если мониторить товар заново
                if ($this->request->existsRequest('scan_product')) {
                    if (!empty($error)) return $this->pushError($error);
                    $method = 'monitorScanProduct_' . $this->asClassName($site);
                    if (!$this->hasMethod($this, $method)) return $this->pushError('В модуле мониторинга отсутствует метод ' . $this->text->escape($method) . ', выполняющий подобную операцию!');
                    if (!$this->prepareBaseCurrency('USD')) return $this->pushError('Выбранный целевой сайт мониторится в валюте USD, которой нет в списке валют вашего сайта!');
                    $this->$method($items, $changes);

                // если мониторить все заново
                } elseif ($this->request->existsRequest('scan')) {
                    if (!empty($error)) return $this->pushError($error);
                    $method = 'monitorScan_' . $this->asClassName($site);
                    if (!$this->hasMethod($this, $method)) return $this->pushError('В модуле мониторинга отсутствует метод ' . $this->text->escape($method) . ', выполняющий подобную операцию!');
                    if (!$this->prepareBaseCurrency('USD')) return $this->pushError('Выбранный целевой сайт мониторится в валюте USD, которой нет в списке валют вашего сайта!');
                    $this->$method($items, $changes);

                // если мониторить устаревшие
                } elseif ($this->request->existsRequest('scan_old')) {
                    if (!empty($error)) return $this->pushError($error);
                    $method = 'monitorScan_' . $this->asClassName($site);
                    if (!$this->hasMethod($this, $method)) return $this->pushError('В модуле мониторинга отсутствует метод ' . $this->text->escape($method) . ', выполняющий подобную операцию!');
                    if (!$this->prepareBaseCurrency('USD')) return $this->pushError('Выбранный целевой сайт мониторится в валюте USD, которой нет в списке валют вашего сайта!');
                    $this->$method($items, $changes, FALSE);

                // если найти все URL заново
                } elseif ($this->request->existsRequest('scan_url')) {
                    if (!empty($error)) return $this->pushError($error);
                    $method = 'monitorScanUrl_' . $this->asClassName($site);
                    if (!$this->hasMethod($this, $method)) return $this->pushError('В модуле мониторинга отсутствует метод ' . $this->text->escape($method) . ', выполняющий подобную операцию!');
                    $this->prepareBaseCurrency('USD');
                    $this->$method($items, $changes);

                // если найти недостающие URL
                } elseif ($this->request->existsRequest('scan_url_empty')) {
                    if (!empty($error)) return $this->pushError($error);
                    $method = 'monitorScanUrl_' . $this->asClassName($site);
                    if (!$this->hasMethod($this, $method)) return $this->pushError('В модуле мониторинга отсутствует метод ' . $this->text->escape($method) . ', выполняющий подобную операцию!');
                    $this->prepareBaseCurrency('USD');
                    $this->$method($items, $changes, FALSE);
                }

                // если хоть одна запись изменилась
                if (!empty($changes)) {
                    $this->pushInfo('Синхронизировано ' . $changes . ' записей, но результаты синхронизации ещё не сохранены.');
                    $this->cms->smarty->assign('setSaveParamsFlag', TRUE);
                }
            }
        }



        // ===================================================================
        /**
        *  Сканирование страниц на Розетке
        *
        *  @access  protected
        *  @param   array   $items      массив записей
        *  @param   integer $changes    число изменившихся записей (будет возвращено в эту переменную)
        *  @param   boolean $all        TRUE если все заново
        *                               FALSE если только устаревшие
        *  @param   array   $params     внутренние параметры:
        *                                   'selected' = TRUE если категория точно выбрана
        *                                                FALSE если пока не знаем (может быть ее ветви)
        *  @return  boolean             TRUE если выполнено успешно
        *                               FALSE если была критическая ошибка
        */
        // ===================================================================

        protected function monitorScan_Rozetka ( & $items, & $changes, $all = TRUE, $params = array() ) {
            if (!empty($items)) {
                if (!isset($params['lifetime'])) $params['lifetime'] = 3600;
                $now = time();
                foreach ($items as & $item) {
                    if (!empty($item->filled)) {
                        if (!empty($item->scanable)) {
                            if (!empty($params['selected']) || !empty($item->selected)) {
                                $me = $params;
                                $me['selected'] = !empty($me['selected']) || !empty($item->selected) && $item->selected === TRUE;
                                if (!empty($item->lifetime)) $me['lifetime'] = $item->lifetime;
                                if ($me['selected']) {
                                    if (!empty($item->products)) {
                                        foreach ($item->products as & $product) {
                                            if (!empty($product->theirUrl) && !empty($product->scanable)) {
                                                $lifetime = !empty($product->lifetime) ? $product->lifetime : $me['lifetime'];
                                                if ($all || empty($product->lasttime) || $now < $product->lasttime || $now > $product->lasttime + $lifetime) {
                                                    if (!$this->scanUrl_Rozetka($product, $changes)) return FALSE;
                                                }
                                            }
                                        }
                                    }
                                }
                                if (!empty($item->subitems)) {
                                    if (!$this->monitorScan_Rozetka($item->subitems, $changes, $all, $me)) return FALSE;
                                }
                            }
                        }
                    }
                }
            }
            return TRUE;
        }



        // ===================================================================
        /**
        *  Сканирование URL-ов на Розетке
        *
        *  @access  protected
        *  @param   array   $items      массив записей
        *  @param   integer $changes    число изменившихся записей (будет возвращено в эту переменную)
        *  @param   boolean $all        TRUE если все заново
        *                               FALSE если только недостающие
        *  @param   array   $params     внутренние параметры:
        *                                   'selected' = TRUE если категория точно выбрана
        *                                                FALSE если пока не знаем (может быть ее ветви)
        *  @return  boolean             TRUE если выполнено успешно
        *                               FALSE если была критическая ошибка
        */
        // ===================================================================

        protected function monitorScanUrl_Rozetka ( & $items, & $changes, $all = TRUE, $params = array() ) {
            if (!empty($items)) {
                foreach ($items as & $item) {
                    if (!empty($item->filled)) {
                        if (!empty($item->scanable)) {
                            if (!empty($params['selected']) || !empty($item->selected)) {
                                $me = $params;
                                $me['selected'] = !empty($me['selected']) || !empty($item->selected) && $item->selected === TRUE;
                                if ($me['selected']) {
                                    if (!empty($item->products)) {
                                        foreach ($item->products as & $product) {
                                            if (!empty($product->scanable)) {
                                                if ($all || empty($product->theirUrl)) {
                                                    if (!$this->findUrl_Rozetka($product, $changes)) return FALSE;
                                                }
                                            }
                                        }
                                    }
                                }
                                if (!empty($item->subitems)) {
                                    if (!$this->monitorScanUrl_Rozetka($item->subitems, $changes, $all, $me)) return FALSE;
                                }
                            }
                        }
                    }
                }
            }
            return TRUE;
        }



        // ===================================================================
        /**
        *  Сканирование конкретной страницы на Розетке
        *
        *  @access  protected
        *  @param   object  $item       запись о товаре
        *  @param   integer $changes    число изменившихся записей (+1 возвратить сюда, если запись изменена)
        *  @return  boolean             TRUE если выполнено успешно
        *                               FALSE если была критическая ошибка
        */
        // ===================================================================

        protected function scanUrl_Rozetka ( & $item, & $changes = 0 ) {
            $error = '';

            // инициализируем сеанс Client URL
            $handle = @ curl_init();
            if ($handle === FALSE) {
                $error = 'Не удается инициализировать новый сеанс Client URL!';
                $item->error = $error;
            } else {

                // загружаем страницу
                try {
                    $url = $item->theirUrl;
                    @ curl_setopt($handle, CURLOPT_URL, $url);
                        @ curl_setopt($handle, CURLOPT_REFERER, 'http://rozetka.com.ua/');
                        @ curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
                        @ curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                            'Host: ' . preg_replace('!^[a-z]+://([^/\\\\]+)([/\\\\].*)$!ui', '$1', $url),
                            'Connection: keep-alive',
                            'User-Agent: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36',
                            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                            'Accept-Encoding: none',
                            'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4'
                        ));
                    @ curl_setopt($handle, CURLOPT_COOKIE, 'device_type=computer; holder=1; href=' . rawurlencode($url) . ';');
                    @ curl_setopt($handle, CURLOPT_HEADER, 1);
                    @ curl_setopt($handle, CURLOPT_RETURNTRANSFER , 1);
                    /* @ curl_setopt($handle, CURLOPT_FOLLOWLOCATION , 1); */
                    @ curl_setopt($handle, CURLOPT_TIMEOUT, 10);

                    $data = @ curl_exec($handle);
                    if (curl_errno($handle)) {
                        $item->error = 'Не удалось загрузить страницу по адресу ' . $url . '!<br /><br />'
                                     . 'Причина: ' . htmlspecialchars(curl_error($handle), ENT_QUOTES);
                    } else {

                        // переводы строк одним символом
                        $data = str_replace("\n", strpos($data, "\r") !== FALSE ? '' : "\r", $data);

                        // перечисляем контрольные ответные заголовки
                        $check = array('HTTP/1.1 200 OK' => TRUE,
                                       'Content-Type: text/html; charset=utf-8' => TRUE);

                        // извлекаем серверные заголовки, если есть
                        $packed = FALSE;
                        $line = FALSE;
                         while (preg_match('/^.*?\r/', $data, $line)) {
                            $line = isset($line[0]) ? $line[0] : '';
                            $size = strlen($line);
                            $line = trim($line);
                            if (substr($line, 0, 1) == '<') break;
                            $data = substr($data, $size);
                            if ($line == '') break;
                            if ($line == 'Content-Encoding: gzip') $packed = TRUE;
                            elseif ($line == 'Content-Encoding: deflate') $packed = 1;
                            if (isset($check[$line])) unset($check[$line]);
                        }

                        // если что-то не совпадает с контрольными заголовками
                        if (!empty($check)) {
                            $item->error = 'Ответные заголовки не совпадают с ожидаемыми! Не найдены:';
                            foreach ($check as $key => $line) $item->error .= '<br />' . $key;
                            $item->error .= '.';
                        } else {

                            // если ответная страница упакована
                            if ($packed) {
                                try {
                                    if (function_exists('gzdecode')) {
                                        $data = @ gzdecode($data);
                                    } elseif (function_exists('gzuncompress')) {
                                        $data = @ gzuncompress($data, 1000000);
                                    } elseif (function_exists('gzinflate')) {
                                        $data = @ gzinflate($data, 1000000);
                                    }
                                    if (!is_string($data)) $data = FALSE;
                                } catch (Exception $e) {
                                    $data = FALSE;
                                }
                            }

                            // пробуем распарсить данные страницы
                            if (is_string($data)) {
                                try {
                                    $check = mb_strpos($this->text->lowerCase($data), 'datalayer.push({"pagetype":"productpage",');
                                    if ($check !== FALSE) {
                                        $data = $this->text->substr($data, $check + 15);
                                        $check = mb_strpos($data, '});');
                                        if ($check !== FALSE) $data = $this->text->substr($data, 0, $check + 1);
                                        else $data = '';
                                    } else $data = '';

                                    // пробуем распарсить JSON-данные
                                    if ($data != '') {
                                        $data = @ json_decode($data, TRUE);
                                        if (is_array($data)) {
                                            if (!isset($data['productAvailability']) || $data['productAvailability'] != 'available') {
                                                $item->error = 'Нет в наличии!';
                                            } else {

                                                // берем их сведения
                                                if (isset($data['productPrice'])) {
                                                    $changes++;
                                                    $item->theirChanged = TRUE;
                                                        $rate = $this->currency->rate($this->baseCurrency);
                                                        $item->theirPrice = $this->number->floatValue($data['productPrice']) * $rate;
                                                    $item->lasttime = time();
                                                } else {
                                                    $item->error = 'В ответе нет данных о цене!';
                                                }
                                            }
                                        } else {
                                            $item->error = 'Ответ сайта представлен иным образом, чем ожидалось!';
                                        }
                                    } else {
                                        $item->error = 'На странице не найдена структура данных о товаре!';
                                    }
                                } catch (Exception $e) {
                                    $item->error = 'Ошибка парсинга JSON-данных!';
                                }
                            } else {
                                $item->error = 'Не удалось распаковать ответную страницу сайта, которая имеет сжатый формат!';
                            }
                        }
                    }
                } catch (Exception $e) {
                    $error = 'Сбой сеанса Client URL!';
                    $item->error = $error;
                }

                // закрываем сеанс
                @ curl_close($handle);
            }

            // возвращаем УСПЕХ / ОШИБКА
            if ($error != '') {
                $this->pushError($error);
                return FALSE;
            }
            return TRUE;
        }



        // ===================================================================
        /**
        *  Поиск конкретного URL на Розетке
        *
        *  @access  protected
        *  @param   object  $item       запись о товаре
        *  @param   integer $changes    число изменившихся записей (+1 возвратить сюда, если запись изменена)
        *  @return  boolean             TRUE если выполнено успешно
        *                               FALSE если была критическая ошибка
        */
        // ===================================================================

        protected function findUrl_Rozetka ( & $item, & $changes = 0 ) {
            $error = '';

            // инициализируем сеанс Client URL
            $handle = @ curl_init();
            if ($handle === FALSE) {
                $error = 'Не удается инициализировать новый сеанс Client URL!';
                $item->error = $error;
            } else {

                // загружаем страницу
                try {
                    $url = 'http://rozetka.com.ua/cgi-bin/search-form.php';
                    @ curl_setopt($handle, CURLOPT_URL, $url);
                        @ curl_setopt($handle, CURLOPT_REFERER, 'http://rozetka.com.ua/');
                        @ curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
                        @ curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                            'Host: rozetka.com.ua',
                            'Connection: keep-alive',
                            'Origin: http://rozetka.com.ua',
                            'ajaxAction: http://rozetka.com.ua/search/',
                            'User-Agent: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36',
                            'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
                            'Accept: text/javascript, text/html, application/xml, text/xml, */*',
                            'X-Requested-With: XMLHttpRequest',
                            'Referer: http://rozetka.com.ua/',
                            'Accept-Encoding: none',
                            'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4'
                        ));
                    @ curl_setopt($handle, CURLOPT_POST, 1);
                        @ curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query(array( 'text' => $item->model,
                                                                                           'suggest' => 1 )));
                    @ curl_setopt($handle, CURLOPT_COOKIE, 'device_type=computer; href=http%3A%2F%2Frozetka.com.ua%2F;');
                    @ curl_setopt($handle, CURLOPT_HEADER, 1);
                    @ curl_setopt($handle, CURLOPT_RETURNTRANSFER , 1);
                    @ curl_setopt($handle, CURLOPT_TIMEOUT, 10);

                    $data = @ curl_exec($handle);
                    if (curl_errno($handle)) {
                        $item->error = 'Не удалось загрузить страницу по адресу ' . $url . '!<br /><br />'
                                     . 'Причина: ' . htmlspecialchars(curl_error($handle), ENT_QUOTES);
                    } else {

                        // переводы строк одним символом
                        $data = str_replace("\n", strpos($data, "\r") !== FALSE ? '' : "\r", $data);

                        // перечисляем контрольные ответные заголовки
                        $check = array('HTTP/1.1 200 OK' => TRUE,
                                       'Content-Type: application/json' => TRUE);

                        // извлекаем серверные заголовки, если есть
                        $line = FALSE;
                         while (preg_match('/^.*?\r/', $data, $line)) {
                            $line = isset($line[0]) ? $line[0] : '';
                            $size = strlen($line);
                            $line = trim($line);
                            if (substr($line, 0, 1) == '<') break;
                            $data = substr($data, $size);
                            if ($line == '') break;
                            if (isset($check[$line])) unset($check[$line]);
                        }

                        // если что-то не совпадает с контрольными заголовками
                        if (!empty($check)) {
                            $item->error = 'Ответные заголовки не совпадают с ожидаемыми! Не найдены:';
                            foreach ($check as $key => $line) $item->error .= '<br />' . $key;
                            $item->error .= '.';
                        } else {

                            // пробуем распарсить JSON-данные
                            try {
                                $data = @ json_decode($data, TRUE);
                                if (is_array($data)) {
                                    if (!empty($data['content']['count']) && !empty($data['content']['records']) && is_array($data['content']['records'])) {
                                        $data = reset($data['content']['records']);
                                        if (!isset($data['sell_status']) || $data['sell_status'] != 'available') {
                                            $item->error = 'Нет в наличии!';
                                        } else {

                                            // берем их сведения - название товара
                                            $changes++;
                                            $item->theirChanged = TRUE;
                                            $item->theirName = isset($data['title']) && is_string($data['title']) ? trim($data['title']) : '';

                                            // берем их сведения - цена (только если у нас есть валюта USD)
                                            if ($this->existsBaseCurrency('USD')) {
                                                if (isset($data['price_usd_clear']) && !isset($item->theirPrice)) {
                                                    $rate = $this->currency->rate($this->baseCurrency);
                                                    $item->theirPrice = $this->number->floatValue($data['price_usd_clear']) * $rate;
                                                }
                                            }

                                            // берем их сведения - url страницы
                                            if (isset($data['href'])) {
                                                $line = is_string($data['href']) ? trim($data['href']) : '';
                                                if ($line != '') {
                                                    $item->theirUrl = $line;
                                                } else {
                                                    $item->error = 'В ответе адрес страницы равен пустой строке!';
                                                }
                                            } else {
                                                $item->error = 'В ответе нет данных об адресе страницы!';
                                            }
                                        }
                                    } else {
                                        $item->error = 'Товар не найден!';
                                    }
                                } else {
                                    $item->error = 'Ответ сайта представлен иным образом, чем ожидалось!';
                                }
                            } catch (Exception $e) {
                                $item->error = 'Ошибка парсинга JSON-данных!';
                            }
                        }
                    }
                } catch (Exception $e) {
                    $error = 'Сбой сеанса Client URL!';
                    $item->error = $error;
                }

                // закрываем сеанс
                @ curl_close($handle);
            }

            // возвращаем УСПЕХ / ОШИБКА
            if ($error != '') {
                $this->pushError($error);
                return FALSE;
            }
            return TRUE;
        }
    }



    return;
?>