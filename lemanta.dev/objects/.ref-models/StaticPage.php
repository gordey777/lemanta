<?php
    // макет справочника клиентской стороны
    require_once(dirname(__FILE__) . '/BasicClientModel.php');



    // =======================================================================
    /**
    *  Макет статической страницы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class StaticPageREFModel extends BasicClientREFModel {

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'static_page';

        // целевая переменная в шаблоне
        protected $template_var = 'page';

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'sections';



        // ===================================================================
        /**
        *  Признак что для модуля допустима нумерация страниц
        *
        *  @access  public
        *  @return  boolean         TRUE если допустима
        */
        // ===================================================================

        public function hasPageNumbering () {
            $prefix = $this->getSettingsPrefix();
            return $this->settings->getAsBoolean($prefix . 'show_all_disabled')
                || $this->request->getRequest('show_all') === FALSE;
        }



        // ===================================================================
        /**
        *  Получение номера текущей листаемой страницы
        *
        *  @access  public
        *  @param   boolean $as_index   TRUE если как индекс (от 0 и выше)
        *                               FALSE если как номер (от 1 и выше)
        *  @return  integer             номер
        */
        // ===================================================================

        public function getPageNumber ( $as_index = TRUE ) {
            $page = 0;
            if ($this->hasPageNumbering()) {
                $page = $this->request->getRequestAsInteger('page');
            }
            $as_index = $as_index ? 0 : 1;
            return max($as_index, $page);
        }



        // ===================================================================
        /**
        *  Проверка / дозагрузка данных страницы
        *
        *  @access  protected
        *  @param   mixed   $data   указатель на данные
        *  @return  integer         число записей
        */
        // ===================================================================

        protected function checkRefuel ( & $data ) {

            // если данных страницы нет (видимо модуль вызвали напрямую)
            $count = 1;
            if (empty($data)) {
                $count = 0;

                // берем url страницы
                $url = $this->request->getRequestAsSentence('url');
                if ($url != '') {

                    // читаем запись страницы
                    $filter = new stdClass;
                    $filter->url = $url;
                    $filter->enabled = 1;
                    if (!$this->existsUser()) $filter->hidden = 0;
                    if ($this->complementFilter($filter)) {
                        $dbmodel = $this->getDBModel();
                        $this->cms->db->$dbmodel->one($data, $filter);
                        if (!empty($data)) $count = 1;
                    }
                }
            }
            return $count;
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
            $filter->class = 'StaticPage';
            return TRUE;
        }



        // ===================================================================
        /**
        *  Отработка ситуации "нет данных"
        *
        *  @access  protected
        *  @param   mixed   $data   указатель на данные
        *  @return  boolean         TRUE если прекратить обработку страницы
        */
        // ===================================================================

        protected function checkNoData ( & $data ) {
            if (!empty($data)) return FALSE;
            $this->title = 'Страница не найдена!';
            $this->body = CONTENT_MESSAGE_NO_PAGE;
            $this->cms->headerError404();
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
        }



        // ===================================================================
        /**
        *  Передача мета информации
        *
        *  @access  protected
        *  @param   object  $item   объект данных
        *  @return  void
        */
        // ===================================================================

        protected function setMetaInformation ( & $item ) {
            if (!empty($item)) {
                $this->title = & $item->meta_title;
                $this->keywords = & $item->meta_keywords;
                $this->description = & $item->meta_description;
                $this->seo_description = & $item->seo_description;

                $names = array('model', 'header', 'name', 'meta_title');
                foreach ($names as $name) {
                    if (isset($item->$name) && is_string($item->$name)
                    && trim($item->$name) != '') {
                        $this->cms->refillPageTitleVar($item->$name);
                        break;
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Регистрация +1 просмотра
        *
        *  @access  protected
        *  @param   object  $item           объект данных
        *  @param   boolean $its_section    TRUE если это объект специальной страницы
        *  @param   string  $model          для какой модели (по умолчанию для текущей)
        *  @return  void
        */
        // ===================================================================

        protected function registerBrowsed ( & $item, $its_section = TRUE, $model = '' ) {

            // если только пришли на страницу (не в пагинации)
            if (isset($item->browsed)) {
                if ($this->getPageNumber() == 0) {
                    $dbmodel = $its_section ? 'sections' : trim($model);
                    if (empty($dbmodel)) $dbmodel = $this->getDBModel();
                    $idfield = $this->cms->db->$dbmodel->getIDField();

                    // запомнить +1 просмотр (указываем не очищать зависимые кеши)
                    $item->browsed++;
                    $record = new stdClass;
                    $record->$idfield = $item->$idfield;
                    $record->browsed = $item->browsed;
                    $record->indifferent_caches = TRUE;
                    $this->cms->db->$dbmodel->update($record);
                }
            }
        }



        // ===================================================================
        /**
        *  Передача переменных модуля в шаблонизатор
        *
        *  @access  protected
        *  @param   mixed   $data   указатель на данные
        *  @return  void
        */
        // ===================================================================

        protected function assignModuleVars ( & $data ) {
            $this->smartyAssignByRef($this->template_var, $data);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('message', $this->info_msg);
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
            $this->checkRefuel($this->section);
            if ($this->checkNoData($this->section)) return;

            // дополняем данные связанной информацией
            $this->complementData($this->section);

            // передаем данные в мета информацию страницы
            $this->setMetaInformation($this->section);

            // регистрация +1 просмотра
            $this->registerBrowsed($this->section);

            // передаем данные в шаблонизатор
            $this->assignModuleVars($this->section);
        }
    }



    return;
?>