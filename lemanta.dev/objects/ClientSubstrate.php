<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) exit;



    // базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);



    // =======================================================================
    /**
    *  Подложка модуля клиентской стороны
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientSubstrate extends Basic {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent         объект владельца
        *  @param   integer $start_mode     режим запуска
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

            // конструируем объект
            parent::__construct($parent);

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
    }



    return;
?>