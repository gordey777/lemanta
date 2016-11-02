<?php
    // подложка макета справочника
    require_once(dirname(__FILE__) . '/BasicSubstrate.php');



    // =======================================================================
    /**
    *  Макет справочника клиентской стороны
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class BasicClientREFModel extends SubstrateREFModel {

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'undefined';
        // относительный путь и полное имя файла landing page
        protected $landing = '';

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $settings_category = 'Разное';
        protected $settings_model = '';

        // вынесены ли настройки в отдельную модель (Модуль.conf.php)
        protected $settings_external = FALSE;

        // список переменных, переданных модулем в шаблонизатор
        protected $assigned_vars = array();
        // удаляет ли свои шаблонизированные переменные после отрисовки шаблона
        protected $self_cleaning = TRUE;



        // ===================================================================
        /**
        *  Подготовительные действия
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepare () {

            // если настройки в отдельной модели, берем оттуда: категорию личных настроек и модель настроек модуля
            if (!empty($this->settings_external)) {
                $this->settings_category = $this->conf->category;
                $this->settings_model = $this->conf->model;
            }

            $this->checkModuleSettings();
        }



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

            // только для потомков
            if (is_subclass_of($this, 'BasicClientREFModel')) {

                // если настройки в отдельной модели, берем оттуда: массив настроек
                if (!empty($this->settings_external) && is_null($settings)) {
                    $settings = $this->conf->settings;
                }

                if (!empty($settings) && is_array($settings)) {
                    $prefix = $this->getSettingsPrefix();
                    $category = $this->getSettingsCategory();
                    foreach ($settings as $name => $info) {
                        if (is_string($name)) {
                            $name = trim($name);
                            if ($name != '') {
                                $name = $prefix . $name;
                                $value = $this->settings->get($name, null);
                                if (is_null($value)) {
                                    if (!is_array($info)) $info = array($info);
                                    if (isset($info[0])) {
                                        $description = isset($info[1]) ? preg_replace('/[ \t\r\n\s]+/u', ' ', trim($info[1])) : null;
                                        if (is_bool($info[0])) {
                                            $value = $info[0] ? 1 : 0;
                                        } elseif (is_float($info[0])) {
                                            $value = str_replace(',', '.', $info[0]);
                                        } else {
                                            $value = trim($info[0]);
                                        }
                                        $this->cms->db->settings->save($name, $value, $description, $category);
                                    }
                                }
                            }
                        }
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
            if (!isset($this->section) || !isset($this->section->template) || !is_string($this->section->template)) return '';
            return trim($this->section->template);
        }



        // ===================================================================
        /**
        *  Проверка доступности файла шаблона
        *
        *  @access  public
        *  @param   string  $title      титульный текст страницы
        *  @return  boolean             TRUE если доступен
        */
        // ===================================================================

        public function checkTemplate ( $title = '' ) {

            // устанавливаем заголовок страницы
            if ($title != '') $this->title = $title;

            // сообщение на случай отсутствия шаблона
            $this->body = CONTENT_MESSAGE_NO_PAGE;

            // известен ли текущий шаблон?
            $theme = $this->hdd->safeFilename($this->cms->dynamic_theme);
            if ($theme == '') return FALSE;

            // определяем наличие файла landing page
            $this->landing = '';
            $path = dirname(__FILE__) . '/../../design/' . $theme . '/html/';
            $landing = $this->getLandingPageTemplate();
            $file = $this->hdd->safeFilename($landing, FALSE);
            if ($file != '') {
                if ($this->hdd->isReadableFile($path . $file)) {
                    $this->landing = $landing;
                    return TRUE;
                }
            }

            // определяем наличие стандартного файла шаблона
            $items = is_array($this->template) ? $this->template : array($this->template);
            if (!empty($items)) {
                foreach ($items as $template) {
                    if (is_string($template)) {
                        $file = $this->hdd->safeFilename($template, FALSE);
                        if ($file != '') {
                            $file = $path . $file;
                            if ($this->hdd->isReadableFile($file . '.tpl')
                            || $this->hdd->isReadableFile($file . '.htm')) return TRUE;
                        }
                    }
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка наличия авторизованного пользователя
        *
        *  @access  public
        *  @return  boolean         TRUE если есть, FALSE если нет
        */
        // ===================================================================

        public function existsUser () {
            return isset($this->cms->user->user_id) && !empty($this->cms->user->user_id);
        }



        // ===================================================================
        /**
        *  Передача переменной в шаблонизатор
        *
        *  @access  public
        *  @param   string  $name   имя переменной
        *  @param   mixed   $value  значение переменной
        *  @return  void
        */
        // ===================================================================

        public function smartyAssign ( $name, $value ) {
            $this->registerAssignedVar($name);
            $this->cms->smarty->assign($name, $value);
        }



        // ===================================================================
        /**
        *  Передача переменной по ссылке в шаблонизатор
        *
        *  @access  public
        *  @param   string  $name   имя переменной
        *  @param   mixed   $ptr    указатель на переменную
        *  @return  void
        */
        // ===================================================================

        public function smartyAssignByRef ( $name, & $ptr ) {
            $this->registerAssignedVar($name);
            $this->cms->smarty->assignByRef($name, $ptr);
        }



        // ===================================================================
        /**
        *  Регистрация переменной, передаваемой модулем в шаблонизатор
        *
        *  @access  protected
        *  @param   string  $name   имя переменной
        *  @return  void
        */
        // ===================================================================

        protected function registerAssignedVar ( $name ) {
            if (!isset($this->assigned_vars) || !is_array($this->assigned_vars)) {
                $this->assigned_vars = array();
            }
            if (!is_string($name) || in_array($name, $this->assigned_vars, TRUE)) return;
            $this->assigned_vars[] = $name;
        }



        // ===================================================================
        /**
        *  Уничтожение переменных, переданных модулем в шаблонизатор
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function destroyAssignedVars () {
            if (!empty($this->assigned_vars) && is_array($this->assigned_vars)) {
                foreach ($this->assigned_vars as $var) {
                    if (is_string($var)) {
                        $this->cms->smarty->clearAssign($var);
                    }
                }
            }
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
        }



        // ===================================================================
        /**
        *  Визуализация данных (результирующего контента)
        *
        *  Создает в объекте информационные свойства для наследников:
        *      ->template_exists = TRUE если шаблон существует
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetch ( & $parent = null ) {

            // проверяем доступность шаблона
            $this->template_exists = $this->checkTemplate('Страница не найдена!');
            if (empty($this->template_exists)) return TRUE;

            // обрабатываем входные параметры
            $this->process();

            // создаем контент модуля
            $template = !empty($this->landing) ? $this->hdd->safeFilename($this->landing, FALSE) : '';
            if (!empty($template)) {
                $this->body = $this->cms->smarty->fetch($template);
            } else {
                $theme = $this->hdd->safeFilename($this->cms->dynamic_theme);
                if ($theme != '') {
                    $items = is_array($this->template) ? $this->template : array($this->template);
                    if (!empty($items)) {
                        $default = reset($items);
                        $path = dirname(__FILE__) . '/../../design/' . $theme . '/html/';
                        foreach ($items as $template) {
                            if (is_string($template)) {
                                $file = $this->hdd->safeFilename($template, FALSE);
                                if ($file != '') {
                                    $file = $path . $file;
                                    if ($this->hdd->isReadableFile($file . '.tpl')
                                    || $this->hdd->isReadableFile($file . '.htm')) {
                                        $default = FALSE;
                                        $this->cms->smarty->fetchByTemplate($this, $template);
                                        break;
                                    }
                                }
                            }
                        }
                        if (!empty($default) && is_string($default)) $this->cms->smarty->fetchByTemplate($this, $default);
                    }
                }
            }

            // уничтожаем шаблонизированные переменные модуля
            if (!empty($this->self_cleaning)) $this->destroyAssignedVars();
            return TRUE;
        }
    }



    return;
?>