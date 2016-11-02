<?php
    // =======================================================================
    /**
    *  Админ модуль PHP info (информация о PHP)
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // текст заголовка страницы модуля
    define('PHPINFO_PAGE_TITLE', 'Информация о PHP');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('PHPINFO_TEMPLATE_FILENAME', 'phpinfo/phpinfo.htm');
    define('PHPINFO_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                   . PHPINFO_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // сообщение о блокировке в демо режиме
    define('PHPINFO_DEMOMODE_MSG', 'В демо версии информация о PHP дается в ограниченном виде с сокрытием путей и емейлов. '
                                 . 'На вашем сайте информация будет выведена в полном виде: сведения о системе, '
                                 . 'веб сервере, подключенные модули, переменные окружения и тому подобное.');

    // имена переменных в шаблонизаторе
    define('PHPINFO_SMARTYVAR_DATA', 'data');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('PHPINFO_MODULELINK_POINTER', 'PHPinfo');
    define('PHPINFO_MODULETAB_TEXT', 'php info');
    define('PHPINFO_MODULEMENU_PATH', 'Утилиты / Мониторинг / Информация о PHP');



    // =======================================================================
    /**
    *  Админ модуль PHP info (информация о PHP)
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PHPinfo extends Basic {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
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

            // устанавливаем заголовок страницы
            $this->title = ADMIN_PAGE_TITLE_PREFIX . PHPINFO_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = PHPINFO_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . PHPINFO_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->admin_folder);
            $path .= '/design/' . $this->hdd->safeFilename($this->settings->admin_theme) . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return;

            // обрабатываем входные параметры
            $this->process();

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process () {

            // предполагаем дать полные сведения о PHP
            $what = INFO_ALL;

            // если находимся в демо режиме
            if ($this->config->demo) {
                $this->push_info(PHPINFO_DEMOMODE_MSG);

                // будем давать усеченные сведения о PHP
                $what = INFO_CONFIGURATION;
            }

            // берем сведения о PHP
            $data = '';
            if (@ob_start()) {
                phpinfo($what);
                $data = @ob_get_clean();

                // извлекаем контент
                $data = preg_replace('|^.*?<body[^>]*>(.+?)</body>.*$|is', '$1', $data);

                // если находимся в демо режиме, удаляем серверные пути и емейлы
                if ($this->config->demo) {
                    $data = preg_replace('~/(usr|var|home)/([a-z0-9\-\._]+/)*[a-z0-9\-\._]+~is', '/something', $data);
                    $data = preg_replace('~[a-z0-9\-\._]+@[a-z0-9\-\._]+~is', 'some@thing', $data);
                }
            }

            // передаем в шаблонизатор контент файла
            $this->smarty->assignByRef(PHPINFO_SMARTYVAR_DATA, $data);

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // передаем в шаблонизатор информационное сообщение
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        }
    }



    return;
?>