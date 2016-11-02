<?php
    // =======================================================================
    /**
    *  Админ модуль редактирования стилевых файлов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет списка редактируемых файлов
    require_once(dirname(__FILE__) . '/../.ref-models/AdminFiles.php');

    // текст заголовка страницы модуля
    define('STYLES_PAGE_TITLE', 'Файлы стилей');

    // имя файла шаблона модуля
    define('STYLES_TEMPLATE_FILENAME', 'styles/styles.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('STYLES_MODULELINK_POINTER', 'Styles');
    define('STYLES_MODULETAB_TEXT', 'стили');
    define('STYLES_MODULEMENU_PATH', 'Дизайн / Файлы шаблона');



    // =======================================================================
    /**
    *  Админ модуль редактирования стилевых файлов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Styles extends AdminFilesREFModel {

        // признак "работает ли модуль как редактор файлов"
        protected $as_file_editor = TRUE;

        // допустимые расширения файлов
        protected $files_extensions = array('css');

        // имя модели базы данных
        protected $dbmodel = 'styles';

        // имя файла шаблона
        protected $template = STYLES_TEMPLATE_FILENAME;

        // перечень имен разрешенных команд редактирования записей
        protected $my_actions = array(ACTION_REQUEST_PARAM_VALUE_EDIT,
                                      ACTION_REQUEST_PARAM_VALUE_EDIT_ALL,
                                      ACTION_REQUEST_PARAM_VALUE_COPY,
                                      ACTION_REQUEST_PARAM_VALUE_DELETE,
                                      ACTION_REQUEST_PARAM_VALUE_CREATE,
                                      ACTION_REQUEST_PARAM_VALUE_DOWNLOAD);



        // ===================================================================
        /**
        *  Подготовительные действия
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepare () {

            // устанавливаем путь к файлам
            $this->files_path = ROOT_FOLDER_REFERENCE
                              . 'design/'
                              . $this->hdd->safeFilename($this->cms->dynamic_theme)
                              . '/css';

            // если такой папки нет, создаем ее (создаем файл псевдозаписи папки)
            if (!file_exists($this->files_path) || !is_dir($this->files_path)) {
                $this->createFolderRecord($this->files_path);
            }
        }



        // ===================================================================
        /**
        *  Получение псевдозаписи файла
        *
        *  @access  protected
        *  @param   string  $file   имя файла
        *  @param   object  $data   контент записи (будет помещен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function getFileRecord ( $file, & $data = null ) {

            // читаем содержимое файла
            if (!is_object($data)) $data = new stdClass;
            $data->content = '';
            if (file_exists($file) && is_file($file)) {
                $data->content = @ file_get_contents($file);
                if (!is_string($data->content)) $data->content = '';
                $data->content = rtrim($data->content);
            }

            // заголовок файла
            $data->title = '';
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
            if (!$this->checkTemplate(STYLES_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>