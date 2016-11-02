<?php
    // макет статической страницы
    require_once(dirname(__FILE__) . '/StaticPage.php');



    // =======================================================================
    /**
    *  Макет списка записей
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ListREFModel extends StaticPageREFModel {

        protected $default_title = 'Список';

        // допустимые режимы сортировки
        protected $sort_modes = array(0 => 'как расставлены');



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
            $settings = array('files_folder_prefix'    => array('', 'Префикс папки прикрепленных файлов'),
                              'images_resizing'        => array(1, 'Обрабатывать ли изображения после загрузки'),
                              'images_quality'         => array(90, 'Качество послезагрузочной обработки изображений'),
                              'images_exactly'         => array(1, 'Приводить ли изображения к точным размерам после загрузки'),
                              'images_width'           => array(800, 'Максимальная ширина изображений после загрузки'),
                              'images_height'          => array(600, 'Максимальная высота изображений после загрузки'),
                              'thumbnail_resizing'     => array(1, 'Обрабатывать ли миниатюры после загрузки'),
                              'thumbnail_width'        => array(160, 'Максимальная ширина миниатюр после загрузки'),
                              'thumbnail_height'       => array(120, 'Максимальная высота миниатюр после загрузки'),
                              'watermark_enabled'      => array(0, 'Накладывать ли водяной знак после загрузки изображений'),
                              'watermark_transparency' => array(50, 'Процент прозрачности водяного знака'),
                              'watermark_location'     => array(IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM, 'Положение водяного знака'),
                              'wysiwyg_disabled'       => array(0, 'Запрещен ли визуальный редактор'),
                              'wysiwyg_disabled_mode'  => array(FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION, 'Режим пост обработки текста при запрещенном визуальном редакторе'),
                              'meta_autofill'          => array(1, 'Заполнять ли мета теги автоматически'),
                              'sort_method'            => array(isset($settings['sort_method']) ? $settings['sort_method'] : 1, 'Дефолтный способ сортировки записей в списке на клиентской стороне'),
                              'sort_descending'        => array(isset($settings['sort_descending']) ? $settings['sort_descending'] : 0, 'Противоположное направление сортировки записей в списке на клиентской стороне'),
                              'sort_laconical'         => array(isset($settings['sort_laconical']) ? $settings['sort_laconical'] : 0, 'Лаконичность сортировки записей (отсечение не имеющих смысла)'),
                              'main_title'             => array(isset($settings['main_title']) ? $settings['main_title'] : '', 'Дефолтный заголовок страницы'),
                              'main_path'              => array(isset($settings['main_path']) ? $settings['main_path'] : '', 'Название страницы в хлебных крошках'),
                              'main_keywords'          => array(isset($settings['main_keywords']) ? $settings['main_keywords'] : '', 'Дефолтный список ключевых слов страницы'),
                              'main_description'       => array(isset($settings['main_description']) ? $settings['main_description'] : '', 'Дефолтное мета описание страницы'),
                              'num'                    => array(2 * 3 * 4, 'Число записей в списке на странице клиентской стороны'),
                              'num_admin'              => array(50, 'Число записей в списке на странице админпанели'),
                              'show_all_disabled'      => array(isset($settings['show_all_disabled']) ? $settings['show_all_disabled'] : 0, 'Запрещен ли просмотр всех записей на одной странице клиентской стороны'));
            parent::checkModuleSettings($settings);
        }



        // ===================================================================
        /**
        *  Получение предельно возможного числа записей на странице
        *
        *  @access  public
        *  @return  integer     число записей
        */
        // ===================================================================

        public function getItemsPerPage () {

            // может пользователь хочет поменять на свое?
            $prefix = $this->getSettingsPrefix();
            $size = $this->request->getRequestAsInteger('page_size', FALSE);
            if ($size === FALSE || $size < 1) {

                // может хранится в сеансе?
                $size = $this->request->getSessionAsInteger($prefix . 'page_size', FALSE);
                if ($size === FALSE || $size < 1) {

                    // может есть в настройках?
                    $size = $this->settings->getAsInteger($prefix . 'num', FALSE);

                    // тогда по умолчанию
                    if ($size === FALSE || $size < 1) $size = 24;
                }

            // пользователь может выбрать только из определенного
            } else {
                switch ($size) {
                    case 2:
                    case 3:
                    case 4:
                    case 6:
                    case 8:
                    case 9:
                    case 12:
                    case 16:
                    case 24:
                    case 27:
                    case 120:
                        break;
                    default:
                        $size = max(1, intval($size / 5)) * 5;
                        if ($size > 150) $size = 150;
                }
                $this->session->set($prefix . 'page_size', $size);
            }
            return $size;
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
            if (empty($data) || !is_array($data)) {
                $data = null;
                $count = 0;

                // читаем список разрешенных и видимых клиенту записей на текущей странице
                $filter = new stdClass;
                $this->setFilterSortParams($filter);
                $filter->enabled = 1;
                if (!$this->existsUser()) $filter->hidden = 0;
                if ($this->hasPageNumbering()) {
                    $page = $this->getPageNumber();
                    $size = $this->getItemsPerPage();
                    $filter->start = $page * $size;
                    $filter->maxcount = $size;
                }
                if ($this->complementFilter($filter)) {
                    $count = $this->getRecords($data, $filter);
                }
                return $count;
            } else return count($data);
        }



        // ===================================================================
        /**
        *  Извлечение записей согласно фильтра
        *
        *  @access  protected
        *  @param   mixed   $data       указатель на данные
        *  @param   object  $filter     указатель на фильтр
        *  @return  integer             число записей
        */
        // ===================================================================

        protected function getRecords ( & $data, & $filter ) {
            $dbmodel = $this->getDBModel();
            $count = $this->cms->db->$dbmodel->get($data, $filter);
            $this->cms->db->$dbmodel->unpackRecords($data, $filter);
            return $count;
        }



        // ===================================================================
        /**
        *  Установка параметров сортировки в фильтре записей
        *
        *  @access  protected
        *  @param   object  $filter     указатель на фильтр
        *  @return  void
        */
        // ===================================================================

        protected function setFilterSortParams ( & $filter ) {
            $prefix = $this->getSettingsPrefix();

            // извлекаем способ сортировки из REQUEST-SESSION-SETTINGS
            $name = 'sort_method';
            $sort = $this->request->getRequestAsInteger($name, FALSE);
            if ($sort === FALSE || !isset($this->sort_modes[$sort])) {
                $sort = $this->session->getAsInteger($prefix . $name, FALSE);
                if ($sort === FALSE || !isset($this->sort_modes[$sort])) {
                    $sort = $this->settings->getAsInteger($prefix . $name);
                }
            }
            $filter->sort = $sort;
            $this->smartyAssignByRef($name, $sort);
            $this->session->set($prefix . $name, $sort);

            // извлекаем направление сортировки из REQUEST-SESSION-SETTINGS
            $name = 'sort_descending';
            $descending = $this->request->getRequestAsBoolean($name, FALSE);
            if ($descending === FALSE) {
                $descending = $this->session->getAsBoolean($prefix . $name, FALSE);
                if ($descending === FALSE) $descending = $this->settings->getAsBoolean($prefix . $name, 1);
            }
            $filter->sort_direction = $descending;
            $this->smartyAssignByRef($name, $descending);
            $this->session->set($prefix . $name, $descending);

            // извлекаем лаконичность сортировки из REQUEST-SESSION-SETTINGS
            $name = 'sort_laconical';
            $laconical = $this->request->getRequestAsBoolean($name, FALSE);
            if ($laconical === FALSE) {
                $laconical = $this->session->getAsBoolean($prefix . $name, FALSE);
                if ($laconical === FALSE) $laconical = $this->settings->getAsBoolean($prefix . $name, 1);
            }
            $filter->$name = $laconical;
            $this->smartyAssignByRef($name, $laconical);
            $this->session->set($prefix . $name, $laconical);
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
            return TRUE;
        }



        // ===================================================================
        /**
        *  Создание навигатора страниц
        *
        *  @access  protected
        *  @param   integer $count  число всех записей
        *  @return  void
        */
        // ===================================================================

        protected function setPagesNavigation ( $count ) {
            $this->smartyAssignByRef('sort_modes', $this->sort_modes);
            $size = $this->getItemsPerPage();
            $size = max(1, $size);
            $count = intval(ceil($count / $size));
            $this->smartyAssignByRef('CurrentPageMaxsize', $size);
            $current = $this->getPageNumber();
            $body = $this->paginator->make($count, $current, $this);
            $this->smartyAssignByRef('PagesNavigation', $body);
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

            // возможно есть в записи о специальной странице
            if (!empty($item)) {
                parent::setMetaInformation($item);
                return;
            }

            // иначе пробуем взять из настроек
            $prefix = $this->getSettingsPrefix();
            $title = $this->settings->getAsSentence($prefix . 'main_title');
            $keywords = $this->settings->getAsSentence($prefix . 'main_keywords');
            $description = $this->settings->getAsSentence($prefix . 'main_description');

            // иначе дефолты модуля
            $this->title = !empty($title) ? $title : $this->default_title;
            $this->keywords = !empty($keywords) ? $keywords : '';
            $this->description = !empty($description) ? $description : '';
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
            $this->setMetaInformation($this->section);

            // регистрация +1 просмотра
            $this->registerBrowsed($this->section);

            // передаем данные в шаблонизатор
            $this->assignModuleVars($this->items);
            if (empty($this->section)) $this->cms->refillPageTypicalVars($this);
        }
    }



    return;
?>