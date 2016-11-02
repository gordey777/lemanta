<?php
    // макет списка записей
    require_once(dirname(__FILE__) . '/../.ref-models/List.php');



    // =======================================================================
    /**
    *  Клиентский модуль списка товаров
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientProducts extends ListREFModel {

        protected $default_title = 'Товары';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Товары';
        protected $settings_model = 'products';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'products';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'products';

        // целевая переменная в шаблоне
        protected $template_var = 'products';

        // допустимые режимы сортировки
        protected $sort_modes = array( SORT_PRODUCTS_MODE_AS_IS                => 'как расставлены',
                                       SORT_PRODUCTS_MODE_BY_NAME              => 'по названию',
                                       SORT_PRODUCTS_MODE_BY_PRICE             => 'по цене',
                                       SORT_PRODUCTS_MODE_BY_QUANTITY          => 'по количеству',
                                       SORT_PRODUCTS_MODE_BY_PCODE             => 'по коду',
                                       SORT_PRODUCTS_MODE_BY_BROWSED           => 'по просмотрам',
                                       SORT_PRODUCTS_MODE_BY_RATING            => 'по рейтингу',
                                       SORT_PRODUCTS_MODE_BY_BRAND             => 'по брендам',
                                       SORT_PRODUCTS_MODE_BY_CATEGORY          => 'по категориям',
                                       SORT_PRODUCTS_MODE_BY_CREATED           => 'по дате добавления',
                                       SORT_PRODUCTS_MODE_BY_COMMENTS          => 'по числу отзывов',
                                       SORT_PRODUCTS_MODE_BY_VARIANTSCOUNT     => 'по числу вариантов',
                                       SORT_PRODUCTS_MODE_BY_ACTION_START_DATE => 'по дате акции',
                                       SORT_PRODUCTS_MODE_BY_ACTION_END_DATE   => 'по дате конца акции' );



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
            $settings = array('sort_method'       => SORT_PRODUCTS_MODE_AS_IS,
                              'sort_descending'   => 0,
                              'sort_laconical'    => 0,
                              'main_title'        => 'Товары',
                              'main_path'         => 'Товары',
                              'main_keywords'     => 'товары',
                              'main_description'  => 'Список товаров, предлагаемых нашим магазином.',
                              'show_all_disabled' => 0);
            parent::checkModuleSettings($settings);
        }



        // ===================================================================
        /**
        *  Извлечение записей согласно фильтра
        *
        *  -------------------------------------------------------------------
        *
        *  @access  protected
        *  @param   mixed   $data       указатель на данные
        *  @param   object  $filter     указатель на фильтр
        *  @return  integer             число записей
        */
        // ===================================================================

        protected function getRecords ( & $data, & $filter ) {
            $dbmodel = $this->getDBModel();

            // TODO: может фильтр шаблона должен сообщать, нужна ли ему актуализация свойств?
            //       иначе бесплезно напрягаем сайт на простых фильтрах шаблона или шаблонах без фильтра

            // просим вернуть также массив идентификаторов ВСЕХ товаров, проходящих фильтр
            $filter->info_ids = TRUE;
            $ids = array();

            // берем список свойств товаров (непустых, разрешенных и используемых в фильтре, а также в такой категории/бренде)
            $params = new stdClass;
            $params->sort = $this->settings->getAsInteger('properties_sort_method');
            $params->optioned = 1;
            $params->enabled = 1;
            $params->in_filter = 1;
            if (!empty($this->category)) $params->category_id = $this->category->category_id;
            // если это чисто страница бренда (то есть не категория -> бренд)
            if (!empty($this->brand) && empty($this->category)) $params->brand_id = $this->brand->brand_id;
            $properties = null;
            $this->cms->db->get_properties($properties, $params);
            $this->cms->db->fix_properties_records($properties);

            // передаем в шаблонизатор список свойств товаров в этой категории/бренде
            if (!empty($properties)) {
                $prop_filter = array();
                foreach ($properties as & $property) $this->cms->add_param($property->property_id);
                foreach ($properties as & $property) {
                    $property->clear_url = $this->cms->form_get(array($property->property_id => ''));
                    foreach ($property->options as $index => $option) {
                        $property->options[$index] = new stdClass;
                        $property->options[$index]->value = $option;
                        $property->options[$index]->url = $this->cms->form_get(array($property->property_id => $option));

                        // пока это значение свойства считаем неактуальным (актуализируем позже)
                        $property->options[$index]->actual = FALSE;

                        // еще не знаем сколько товаров найдется по такому свойству
                        $property->options[$index]->count = 0;
                    }
                    $value = $this->cms->param($property->property_id);
                    if (!empty($value)) $prop_filter[$property->property_id] = $value;
                }
                $this->smartyAssignByRef('properties', $properties);
                $this->smartyAssign('filter_params', $this->cms->form_get());
                $filter->properties = & $prop_filter;
            }

            // читаем список названий вариантов товаров в выбранной категории/бренде и передаем в шаблонизатор
            $params = new stdClass;
            $params->category = & $this->category;
            $params->brand = & $this->brand;
            $params->enabled = 1;
            if (!$this->existsUser()) $params->hidden = 0;
            $variants = null;
            $this->cms->db->$dbmodel->variants_names($variants, $params);
            $this->smartyAssignByRef('variants', $variants);

            $count = $this->cms->db->$dbmodel->get($data, $filter, $ids);
            $this->cms->db->$dbmodel->unpackRecords($data, $filter);

            // TODO: см. выше
            //
            // пометим актуальные записи свойств согласно списка ИД товаров, прошедших фильтр
            $this->cms->db->actualize_properties($properties, $ids);

            return $count;
        }



        // ===================================================================
        /**
        *  Поиск записи в списке по адресу страницы
        *
        *  @access  protected
        *  @param   array   $list       массив записей
        *  @param   string  $url        адрес
        *  @param   string  $idfield    имя поля идентификатора записи
        *  @return  mxied               искомый объект
        *                               NULL если не найден
        */
        // ===================================================================

        protected function findByUrl ( & $list, $url, $idfield ) {
            if (!empty($list) && is_array($list)) {
                foreach ($list as & $item) {
                    if ($item->url == $url) return $item;
                }

                // может адрес равен ИД записи?
                if (is_numeric($url) && !empty($url)) {
                    foreach ($list as & $item) {
                        if (trim($item->url) == '' && $item->$idfield == $url) return $item;
                    }
                }
            }
            return null;
        }



        // ===================================================================
        /**
        *  Дополнение фильтра записей
        *
        *  @access  protected
        *  @param   object  $filter     указатель на фильтр
        *  @return  boolean             TRUE если продолжать
        *                               FALSE если отменить чтение записей
        */
        // ===================================================================

        protected function complementFilter ( & $filter ) {
            if (!is_object($filter)) return FALSE;
            $bad = FALSE;

            // если категория не найдена, но есть в параметрах запроса, тогда стоп
            if (empty($this->category)) {
                $url = $this->request->getRequestAsSentence('category');
                if ($url != '') $bad = TRUE;
            }

            // если бренд не найден, но есть в параметрах запроса
            if (empty($this->brand)) {
                $url = $this->request->getRequestAsSentence('brand');
                if ($url != '') {
                    if (empty($this->cms->brands)) {
                        $params = new stdClass;
                        $params->url = $url;
                        $params->enabled = 1;
                        if (!$this->existsUser()) $params->hidden = 0;
                        $this->cms->db->get_brand($this->brand, $params);
                    } else {
                        $this->brand = $this->findByUrl($this->cms->brands, $url, 'brand_id');
                    }
                    $bad = $bad || empty($this->brand);
                }
            }

            // передаем данные категории/бренда в шаблонизатор
            $this->smarty->assignByRef('category', $this->category);
            $this->smarty->assignByRef('brand', $this->brand);

            // категория или бренд могут иметь признак "информативная страница", тогда не читаем товары
            if ($bad) return FALSE;
            if (!empty($this->category->informative) || !empty($this->brand->informative)) return FALSE;

            $filter_params = '';

            // берем параметры поиска по диапазону цен
            $cost_from = $this->search->queryCostFrom();
            $cost_to = $this->search->queryCostTo();
            $this->search->checkCostValues($cost_from, $cost_to);
            $BASE_cost_from = 0;
            $BASE_cost_to = 0;
            $this->search->computeBaseCostValues($cost_from, $cost_to, $BASE_cost_from, $BASE_cost_to);
            if ($this->request->getRequestAsBoolean('cost_forget')) {
                $this->session->delete('search_cost_from');
                $this->session->delete('search_cost_to');
            } else {
                $this->session->set('search_cost_from', $cost_from);
                $this->session->set('search_cost_to', $cost_to);
            }
            $cost_from = htmlspecialchars($cost_from);
            $cost_to = htmlspecialchars($cost_to);
            $this->smartyAssignByRef('cost_from', $cost_from);
            $this->smartyAssignByRef('cost_to', $cost_to);

            // дополняем фильтр записей
            $filter->type = TYPE_PRODUCTS_ANY;
            $filter->discount = isset($this->cms->user->discount) ? $this->cms->user->discount : 0;
            $filter->price_id = isset($this->cms->user->price_id) ? $this->cms->user->price_id : 0;
            if ($BASE_cost_from != 0) $filter->search_cost_from = $BASE_cost_from;
            if ($BASE_cost_to != 0) $filter->search_cost_to = $BASE_cost_to;
            $filter->category = & $this->category;
            $filter->brand = & $this->brand;

            // разбираем флаги фильтра по товарным брендам
            if ($this->request->isRequestArray('filter_brand')) {
                $filter->filter_brands = array();
                foreach ($_REQUEST['filter_brand'] as $index => $value) {
                    $index = intval($index);
                    $filter->filter_brands[$index] = $index;
                    $this->cms->add_param('filter_brand[' . $index . ']', 1);
                }
                $filter_params = TRUE;
            }
                // разбираем флаги фильтра по товарным вариантам
                if ($this->request->isRequestArray('filter_variant')) {
                    $filter->filter_variants = array();
                    foreach ($_REQUEST['filter_variant'] as $index => $value) {
                        $index = $this->text->stripTags($index, TRUE);
                        $value = $this->text->lowerCase($index);
                        $filter->filter_variants[$value] = $index;
                        $index = str_replace('&', '', str_replace('[', '', str_replace(']', '', $index)));
                        $this->cms->add_param('filter_variant[' . $index . ']', 1);
                    }
                    $filter_params = TRUE;
                }
                    // разбираем флаги фильтра по товарным свойствам
                    if ($this->request->isRequestArray('filter_property')) {
                        $filter->filter_properties = array();
                        foreach ($_REQUEST['filter_property'] as $index => $values) {
                            if (is_array($values) && !empty($values)) {
                                $index = intval($index);
                                $filter->filter_properties[$index] = array();
                                foreach ($values as $i => $value) {
                                    $i = $this->text->stripTags($i, TRUE);
                                    $value = $this->text->lowerCase($i);
                                    $filter->filter_properties[$index][$value] = $i;
                                    $i = str_replace('&', '', str_replace('[', '', str_replace(']', '', $i)));
                                    $this->cms->add_param('filter_property[' . $index . '][' . $i . ']', 1);
                                }
                            }
                        }
                        $filter_params = TRUE;
                    }
            if (!is_string($filter_params)) $filter_params = $this->cms->form_get();
            $this->smartyAssignByRef('filter_params', $filter_params);

            return TRUE;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров
        *
        *  @access  protected
        *  @param   mixed   $params     некие параметры
        *  @return  void
        */
        // ===================================================================

        protected function process ( $params = null ) {

            // догружаем данные страницы, если нет
            $count = $this->checkRefuel($this->items);

            // дополняем данные связанной информацией
            if (!$this->checkNoData($this->items)) {
                $this->complementData($this->items);
            }

            // создаем навигатор страниц
            $this->smartyAssignByRef('items_count', $count);
            if ($this->hasPageNumbering()) {
                $this->setPagesNavigation($count);
            } else {
                $this->smartyAssign('PagesNavigation', '');
                $this->smartyAssign('CurrentPageMaxsize', 0);
                $this->smartyAssign('CurrentPage', 0);
            }

            // передаем данные в мета информацию страницы
            if (!empty($this->section)) $this->setMetaInformation($this->section);
            else if (!empty($this->brand)) $this->setMetaInformation($this->brand);
            else $this->setMetaInformation($this->category);

            // регистрация +1 просмотра
            if (!empty($this->section)) $this->registerBrowsed($this->section);
            else {
                if (!empty($this->category)) $this->registerBrowsed($this->category, FALSE, 'categories');
                if (!empty($this->brand)) $this->registerBrowsed($this->brand, FALSE, 'brands');
            }

            // передаем данные в шаблонизатор
            $this->assignModuleVars($this->items);
            if (empty($this->section) && empty($this->brand) && empty($this->category)) $this->cms->refillPageTypicalVars($this);
        }



        // ===================================================================
        /**
        *  Подготовка поля category текущего объекта
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepareCategoryField () {

            // если категория еще не найдена (категории на особых URL отыскивает ClientPage), но есть в параметрах запроса
            if (!isset($this->category) || empty($this->category)) {
                $url = $this->request->getRequestAsSentence('category');
                if ($url != '') {
                    if (empty($this->cms->categories)) {
                        if (!isset($this->category)) $this->category = null;
                        $filter = new stdClass;
                        $filter->url = $url;
                        $filter->enabled = 1;
                        if (!$this->existsUser()) $filter->hidden = 0;
                        $this->cms->db->get_category($this->category, $filter);
                    } else {
                        $this->category = $this->findByUrl($this->cms->categories, $url, 'category_id');
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Получение имени файла landing page
        *
        *  @access  public
        *  @return  string          относительный путь и имя файла
        *                           пустая строка если нет таких данных или не заданы
        */
        // ===================================================================

        public function getLandingPageTemplate () {

            // может доступно под специальной страницей?
            $landing = parent::getLandingPageTemplate();
            if (!empty($landing)) return $landing;

            // тогда под страницей категории?
            if (!isset($this->category) || !isset($this->category->template) || !is_string($this->category->template)) return '';
            return trim($this->category->template);
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
            $this->prepareCategoryField();
            return parent::fetch($parent);
        }
    }



    return;
?>