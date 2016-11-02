<?php
    // =======================================================================
    /**
    *  Подложка макета справочника
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SubstrateREFModel {

        // объект движка
        public $cms = null;

        // оперируемая запись,
        // список прочитанных записей
        protected $item = null;
        protected $items = null;

        // заголовок страницы,
        // мета описание,
        // мета ключевые слова
        public $title = '';
        public $description = '';
        public $keywords = '';
        public $seo_description = '';

        // отрисованный контент страницы
        public $body = '';

        // url файла фонового звука страницы
        public $bgsound = '';

        // текст информационного сообщения
        public $info_msg = '';

        // текст сообщения об ошибке
        public $error_msg = '';

        // имя файла шаблона или массив имен файлов
        protected $template = 'undefined.tpl';

        // признак "Модуль рисовать без внешнего оформления страницы"
        public $single = FALSE;

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'undefined';



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $cms        объект вышестоящего движка
        *  @param   object  $owner      объект владельца модуля
        *  @param   string  $gender     родовое имя (класс главенствующего модуля)
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $cms, & $owner = null, $gender = '' ) {

            // запоминаем выход на объект движка
            $this->cms = & $cms;

            // подготовительные действия
            $this->prepare();
        }



        // ===================================================================
        /**
        *  Подготовительные действия
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepare () {
        }



        // ===================================================================
        /**
        *  Получение значения свойства объекта
        *
        *  @access  protected
        *  @param   object  $who    испытуемый объект
        *  @param   string  $name   имя свойства
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           значение
        */
        // ===================================================================

        protected function getProperty ( $who, $name, $def = '' ) {
            if (!isset($who->$name)) return $def;
            return $who->$name;
        }



        // ===================================================================
        /**
        *  Получение имени модели базы данных (если это массив имен, то первого имени)
        *
        *  @access  protected
        *  @return  string              имя модели
        */
        // ===================================================================

        protected function getDBModel () {
            $name = '';
            $field = 'dbmodel';
            if (isset($this->$field)) {
                if (is_string($this->$field)) {
                    $name = trim($this->$field);
                } elseif (is_array($this->$field) && !empty($this->$field)) {
                    $name = reset($this->$field);
                    $name = is_string($name) ? trim($name) : '';
                }
            }
            if ($name == '') $name = 'undefined';
            return $name;
        }



        // ===================================================================
        /**
        *  Получение имени категории личных настроек модуля
        *
        *  @access  protected
        *  @return  string              имя категории
        */
        // ===================================================================

        protected function getSettingsCategory () {
            $name = '';
            $field = 'settings_category';
            if (isset($this->$field)) {
                if (is_string($this->$field)) {
                    $name = str_replace('\\', '/', $this->$field);
                    $name = str_replace('/', ' / ', $name);
                    $name = preg_replace('/[ \r\n\t\s]+/', ' ', $name);
                }
            }
            return trim($name);
        }



        // ===================================================================
        /**
        *  Получение префикса настроек модуля
        *
        *  @access  public
        *  @return  string      префикс
        */
        // ===================================================================

        public function getSettingsPrefix () {
            $dbmodel = isset($this->settings_model) && is_string($this->settings_model) ? trim($this->settings_model) : '';
            if ($dbmodel == '') $dbmodel = $this->getDBModel();
            $dbmodel = $this->text->lowerCase($dbmodel);
            switch ($dbmodel) {
                case 'products_kits': return str_replace('_', '', $dbmodel) . '_';
                default: return $dbmodel . '_';
            }
        }



        // ===================================================================
        /**
        *  Добавление текста ошибки в общее сообщение об ошибке
        *
        *  @access  protected
        *  @param   string  $text     текст ошибки
        *  @param   string  $divider  разделитель сообщений
        *  @return  boolean           всегда TRUE (псевдо сигнализатор ошибки)
        */
        // ===================================================================

        protected function pushError ( $text, $divider = '<br><br>' ) {
            if ($this->error_msg != '') $this->error_msg .= $divider;
            $this->error_msg .= trim($text);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Добавление текста в общее информационное сообщение
        *
        *  @access  protected
        *  @param   string  $text     текст
        *  @param   string  $divider  разделитель сообщений
        *  @return  boolean           всегда TRUE (псевдо сигнализатор сообщения)
        */
        // ===================================================================

        protected function pushInfo ( $text, $divider = '<br><br>' ) {
            if ($this->info_msg != '') $this->info_msg .= $divider;
            $this->info_msg .= trim($text);
            return TRUE;
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
            return TRUE;
        }



        // ===================================================================
        /**
        *  Догрузчик объектов на место свойств
        *
        *  @access  public
        *  @param   string  $name   имя свойства
        *  @return  object          догруженный объект
        */
        // ===================================================================

        final public function __get ( $name ) {
            $this->$name = null;
            $class = preg_replace('/[^a-z0-9]+/', ' ', $name);
            $class = preg_replace('/^[^a-z]+/', '', $class);
            $class = ucwords(strtolower(rtrim($class)));
            $class = str_replace(' ', '', $class);
            if ($class == '') return null;

            // класс отдельных свойств имеет префикс родительского класса
            $me = get_class($this);
            $prefix = '';
            if ($class == 'Conf') $prefix = preg_replace('/^Client/', '', $me);

            // если класс не существует
            $suffix = '';
            if (!class_exists($prefix . $class . $suffix)) {
                $filename = '';
                $filesuffix = '';
                $path = '';
                $file = '';
                if ($class == 'Conf') {
                    $filename = $prefix;
                    $filesuffix = '.' . strtolower($class);
                    $path = strtolower($filename) . '/';
                } else {
                    $suffix = 'ANYModel';
                    if (!class_exists($prefix . $class . $suffix)) {
                        $filename = $class;
                        $path = '.any-models/';
                    }
                }
                if ($filename != '') {
                    $file = dirname(__FILE__) . '/../' . $path . $filename . $filesuffix . '.php';
                    $path = 'objects/' . $path;

                    // есть нужный файл?
                    if (!file_exists($file) || !is_readable($file)) {
                        echo 'В коде одного из REFModel-классов (' . $me . ') '
                           . 'замечено обращение к несуществующему свойству ' . htmlspecialchars($name, ENT_QUOTES) . '. '
                           . 'Предполагая на его месте динамически подгружаемый '
                           . 'объект, не был найден файл ' . $path . $filename . $filesuffix . '.php!';
                        exit;
                    }

                    // для повышения безопасности файл подключаем вне контекста этого метода
                    $this->requireOnce($file);

                    // появился нужный класс?
                    if (!class_exists($prefix . $class . $suffix)) {
                        echo 'В коде одного из REFModel-классов (' . $me . ') '
                           . 'замечено обращение к несуществующему свойству ' . htmlspecialchars($name, ENT_QUOTES) . '. '
                           . 'Предполагая на его месте динамически подгружаемый '
                           . 'объект, был подключен файл ' . $path . $filename . $filesuffix . '.php, однако '
                           . 'в нем не существует класс ' . $prefix . $class . $suffix . '!';
                        exit;
                    }
                }
            }

            // проверяем возможность заимствовать, если модель не эксклюзивная
            $class = $prefix . $class . $suffix;
            if (isset($this->cms->$name) && is_a($this->cms->$name, $class) && empty($this->cms->$name->owner_exclusive)) {
                $this->$name = & $this->cms->$name;
            } else {
                $object = new $class($this->cms);
                $object->owner = $this;
                if (!isset($object->owner_exclusive)) $object->owner_exclusive = FALSE;
                $this->$name = & $object;

                // не эксклюзивные модели даем в займ
                if (empty($object->owner_exclusive)) {
                    if (isset($this->cms) && is_object($this->cms) && !isset($this->cms->$name)) {
                        $this->cms->$name = null;
                        $this->cms->$name = & $object;
                    }
                }
            }
            return $this->$name;
        }



        // ===================================================================
        /**
        *  Подгрузка скрипта в контексте буферного метода (экранирование
        *  локальных переменных метода, которому необходимо подключение
        *  скрипта с непредсказуемой логикой поведения)
        *
        *  @access  protected
        *  @param   string  $file   имя файла
        *  @return  boolean         TRUE если выполнено
        */
        // ===================================================================

        final protected function requireOnce ( $file ) {
            try {
                require_once($file);
                return TRUE;
            } catch (Exception $e) {
                return FALSE;
            }
        }
    }



    return;
?>