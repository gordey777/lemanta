<?php
    // подложка произвольной модели
    require_once(dirname(__FILE__) . '/BasicSubstrate.php');



    // =======================================================================
    /**
    *  Макет произвольной модели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class BasicANYModel extends SubstrateANYModel {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $cms        объект вышестоящего движка
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $cms ) {

            // проверяем доступность необходимых классов
            $this->checkRequiredClasses();

            // запоминаем выход на объект движка
            $this->cms = & $cms;

            // подготовительные действия
            $this->prepare();
        }



        // ===================================================================
        /**
        *  Проверка доступности необходимых классов
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function checkRequiredClasses () {
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
        *  Признак что функции модуля поддерживаются на уровне сервера
        *
        *  @access  public
        *  @return  boolean     TRUE если поддерживаются
        */
        // ===================================================================

        public function isSupported () {
            return TRUE;
        }



        // ===================================================================
        /**
        *  Признак что модуль уже запущен
        *
        *  @access  public
        *  @return  boolean     TRUE если запущен
        */
        // ===================================================================

        public function isStarted () {
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
            $class = preg_replace('/[^a-z0-9]+/u', ' ', $name);
            $class = preg_replace('/^[^a-z]+/u', '', $class);
            $class = ucwords(strtolower(rtrim($class)));
            $class = str_replace(' ', '', $class);
            if ($class == '') return null;

            // если класс не существует
            $suffix = 'ANYModel';
            if (!class_exists($class . $suffix)) {
                $file = dirname(__FILE__) . '/' . $class . '.php';
                if (!file_exists($file) || !is_readable($file)) {
                    echo 'В коде одного из ' . $suffix . '-классов (' . get_class($this) . ') '
                       . 'замечено обращение к несуществующему свойству. '
                       . 'Предполагая на его месте динамически подгружаемый '
                       . 'объект, не был найден файл ' . $class . '.php!';
                    exit;
                }
                require_once($file);
                if (!class_exists($class . $suffix)) {
                    echo 'В коде одного из ' . $suffix . '-классов (' . get_class($this) . ') '
                       . 'замечено обращение к несуществующему свойству. '
                       . 'Предполагая на его месте динамически подгружаемый '
                       . 'объект, был подключен файл ' . $class . '.php, '
                       . 'однако в нем не существует класс ' . $class . $suffix . '!';
                    exit;
                }
            }

            // проверяем возможность заимствовать, если модель не эксклюзивная
            $class .= $suffix;
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
    }



    return;
?>