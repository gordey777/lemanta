<?php
    // макет списка записей
    require_once(dirname(__FILE__) . '/../.ref-models/List.php');



    // =======================================================================
    /**
    *  Клиентский модуль поиска
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientSearch extends ListREFModel {

        protected $default_title = 'Поиск';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Поиск';
        protected $settings_model = 'search';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'products';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'search';

        // целевая переменная в шаблоне
        protected $template_var = 'search_products';

        // допустимые режимы сортировки
        protected $sort_modes = array( SORT_PRODUCTS_MODE_AS_IS       => 'как расставлены',
                                       SORT_PRODUCTS_MODE_BY_NAME     => 'по названию',
                                       SORT_PRODUCTS_MODE_BY_PRICE    => 'по цене',
                                       SORT_PRODUCTS_MODE_BY_PCODE    => 'по коду',
                                       SORT_PRODUCTS_MODE_BY_BROWSED  => 'по просмотрам',
                                       SORT_PRODUCTS_MODE_BY_RATING   => 'по рейтингу',
                                       SORT_PRODUCTS_MODE_BY_BRAND    => 'по брендам',
                                       SORT_PRODUCTS_MODE_BY_CATEGORY => 'по категориям' );

        // параметры поиска
        protected $params = null;



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
            $settings = array('sort_method'       => SORT_PRODUCTS_MODE_BY_NAME,
                              'sort_descending'   => 0,
                              'sort_laconical'    => 0,
                              'main_title'        => 'Поиск',
                              'main_path'         => 'Поиск',
                              'main_keywords'     => 'поиск',
                              'main_description'  => 'Страница поиска товаров в нашем магазине.',
                              'show_all_disabled' => 1);
            parent::checkModuleSettings($settings);
        }



        // ===================================================================
        /**
        *  Признак что существуют параметры поиска
        *
        *  @access  protected
        *  @return  boolean         TRUE если существуют
        */
        // ===================================================================

        protected function hasSearchParams () {
            return isset($this->params->keyword) && isset($this->params->tag)
                   && isset($this->params->BASE_cost_from) && isset($this->params->BASE_cost_to)
                   && ($this->params->keyword != '' || $this->params->tag != ''
                   || $this->params->BASE_cost_from > 0 || $this->params->BASE_cost_to > 0);
        }



        // ===================================================================
        /**
        *  Признак что поиск недопустим для истории поиска
        *
        *  @access  protected
        *  @return  boolean         TRUE если недопустим
        */
        // ===================================================================

        protected function nonHistoricSearch () {
            return !$this->hasSearchParams()
                   || $this->params->tag == ''
                   && (strpos(strtolower($this->params->keyword), SEARCH_PRODUCTS_COMMAND_CREATED_DATE) !== FALSE
                   || strpos(strtolower($this->params->keyword), SEARCH_PRODUCTS_COMMAND_MODIFIED_DATE) !== FALSE);
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

            // если нет параметров поиска
            if (!$this->hasSearchParams()) return FALSE;

            // иначе дополняем фильтр
            $filter->type = TYPE_PRODUCTS_ANY;
            $filter->discount = isset($this->cms->user->discount) ? $this->cms->user->discount : 0;
            $filter->price_id = isset($this->cms->user->price_id) ? $this->cms->user->price_id : 0;
            if ($this->params->keyword != '') {
                $filter->search = array($this->params->keyword);
                $filter->search_type = $this->params->search_type;
            }
            if ($this->params->tag != '') {
                if (!isset($filter->search)) $filter->search = array();
                $filter->search[] = SEARCH_PRODUCTS_COMMAND_TAG_KEYWORDS . $this->params->tag;
                $filter->search_type = $this->params->search_type;
            }
            if ($this->params->BASE_cost_from > 0) $filter->search_cost_from = $this->params->BASE_cost_from;
            if ($this->params->BASE_cost_to > 0) $filter->search_cost_to = $this->params->BASE_cost_to;
            $filter->deleted = 0;
            return TRUE;
        }



        // ===================================================================
        /**
        *  Дополнение данных какой-либо информацией
        *
        *  @access  protected
        *  @param   mixed   $data   указатель на данные
        *  @return  void
        */
        // ===================================================================

        protected function complementData ( & $data ) {

            // если есть параметры поиска
            if ($this->hasSearchParams()) {

                // если товары найдены
                if (!empty($this->items)) {
                    if (!$this->nonHistoricSearch()) {

                        // регистрируем в истории поиска
                        $this->search->registerRequest($this->search->historyDBFile(),
                                                       $this->params->keyword,
                                                       $this->params->search_type,
                                                       $this->params->tag,
                                                       $this->params->cost_from,
                                                       $this->params->cost_to);

                        // если найден всего один товар
                        if (count($this->items) == 1) {
                            foreach ($this->items as & $item) {

                                // забываем параметры поиска (иначе выход на поиск будет сбрасывать на товар)
                                $this->resetOldParams();

                                // редирект на страницу товара
                                $url = 'http://' . $this->cms->root_url . '/' . $item->url_path . $item->url;
                                $this->security->redirectToPage($url);
                            }
                        }
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Сброс старых (хранимых в памяти) параметров поиска
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function resetCostParams () {
            $this->session->delete('search_cost_from');
            $this->session->delete('search_cost_to');
        }

        protected function resetOldParams () {
            $this->session->delete('search_keyword');
            $this->session->delete('search_type');
            $this->session->delete('search_tag');
            $this->resetCostParams();
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

            // если в запросе указано забыть старые параметры
            if ($this->request->getRequestAsBoolean('reset_old')) $this->resetOldParams();

            // извлекаем параметры поиска
            $this->params = new stdClass;
            $this->params->keyword = $this->search->queryKeyword();
            $this->params->search_type = $this->search->querySearchType();
            $this->params->tag = $this->search->queryTag();
            $this->params->cost_from = $this->search->queryCostFrom();
            $this->params->cost_to = $this->search->queryCostTo();

            // переставляем неверные границы цены
            $this->search->checkCostValues($this->params->cost_from, $this->params->cost_to);

            // вычисляем границы цены в базовой валюте
            $this->params->BASE_cost_from = 0;
            $this->params->BASE_cost_to = 0;
            $this->search->computeBaseCostValues($this->params->cost_from,
                                                 $this->params->cost_to,
                                                 $this->params->BASE_cost_from,
                                                 $this->params->BASE_cost_to);

            // запоминаем в сеансе (для селекции без формы при листании результатов)
            $this->session->set('search_keyword', $this->params->keyword);
            $this->session->set('search_type', $this->params->search_type);
            $this->session->set('search_tag', $this->params->tag);
            if ($this->request->getRequestAsBoolean('cost_forget')) {
                $this->resetCostParams();
            } else {
                $this->session->set('search_cost_from', $this->params->cost_from);
                $this->session->set('search_cost_to', $this->params->cost_to);
            }

            // готовим заголовок страницы
            $title = 'Поиск' . ($this->params->tag != '' ? ' по тегу "' . htmlspecialchars($this->params->tag, ENT_QUOTES) . '"' . ($this->params->keyword != '' ? ', где' : '') : '')
                             . ($this->params->keyword != '' ? ' "' . htmlspecialchars($this->params->keyword, ENT_QUOTES) . '"' : '')
                             . ($this->params->BASE_cost_from > 0 || $this->params->BASE_cost_to > 0 ? ' с ценой' : '')
                             . ($this->params->BASE_cost_from > 0 ? ' от ' . htmlspecialchars($this->params->cost_from, ENT_QUOTES) : '')
                             . ($this->params->BASE_cost_to > 0 ? ' до ' . htmlspecialchars($this->params->cost_to, ENT_QUOTES) : '')
                             . ($this->params->BASE_cost_from > 0 || $this->params->BASE_cost_to > 0 ? ' ' . htmlspecialchars($this->cms->currency->sign, ENT_QUOTES) : '');

            if ($this->nonHistoricSearch()) {
                if (strpos(strtolower($this->params->keyword), SEARCH_PRODUCTS_COMMAND_CREATED_DATE) !== FALSE) {
                    $title = 'Отбор по дате добавления';
                } else if (strpos(strtolower($this->params->keyword), SEARCH_PRODUCTS_COMMAND_MODIFIED_DATE) !== FALSE) {
                    $title = 'Отбор по дате изменения';
                }
                $this->params->keyword = '';
            }
            $this->title = $title;

            // передаем данные в шаблонизатор
            $this->smartyAssignByRef('search_title', $title);
                $this->cms->refillPageTitleVar($this->title);
            $this->cms->smarty->assignByRef('keyword', $this->params->keyword);
            $this->cms->smarty->assignByRef('search_type', $this->params->search_type);
            $this->cms->smarty->assignByRef('tag', $this->params->tag);
            $this->cms->smarty->assignByRef('cost_from', $this->params->cost_from);
            $this->cms->smarty->assignByRef('cost_to', $this->params->cost_to);

            parent::process($params);
        }
    }



    return;
?>