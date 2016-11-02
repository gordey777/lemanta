<?php
    // =======================================================================
    /**
    *  Админ модуль файла robots.txt
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
    define('ROBOTS_PAGE_TITLE', 'Файл robots.txt');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('ROBOTS_TEMPLATE_FILENAME', 'robots/robots.htm');
    define('ROBOTS_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                  . ROBOTS_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // сообщение о блокировке в демо режиме
    define('ROBOTS_DEMOMODE_MSG', 'В демо версии отклоняются попытки сохранить изменения в этом файле.');

    // сообщение о недоступности файла для записи
    define('ROBOTS_NONWRITABLE_MSG', 'Файл * недоступен для записи.');

    // сообщение об ошибке при записи файла
    define('ROBOTS_BADWRITING_MSG', 'Не удалось сохранить файл *.');

    // сообщение об успехе
    define('ROBOTS_SUCCESS_MSG', 'Изменения успешно сохранены в файле.');

    // имена переменных в шаблонизаторе
    define('ROBOTS_SMARTYVAR_DATA', 'data');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('ROBOTS_MODULELINK_POINTER', 'Robots');
    define('ROBOTS_MODULETAB_TEXT', 'robots.txt');
    define('ROBOTS_MODULEMENU_PATH', 'Разное / SEO / Файл robots.txt');



    // =======================================================================
    /**
    *  Админ модуль файла robots.txt
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Robots extends Basic {



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
            $this->title = ADMIN_PAGE_TITLE_PREFIX . ROBOTS_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = ROBOTS_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . ROBOTS_NOTEMPLATE_MSG
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

            // с каким файлом работаем
            $path = ROOT_FOLDER_REFERENCE;
            $file = 'robots' . $this->settings->files_host_suffix . '.txt';

            // если точно получен POST-запрос
            $data = '';
            if (isset($_POST) && !empty($_POST)) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // берем из запроса отредактированный контент файла
                $data = $this->param(ROBOTS_SMARTYVAR_DATA);

                // блокируем главное действие модуля, если находимся в демо режиме
                if ($this->config->demo) {
                    $this->push_error(ROBOTS_DEMOMODE_MSG);
                } else {

                    // пробуем сохранить в файл
                    $ok = !file_exists($path . $file) || !is_file($path . $file) || is_writable($path . $file);
                    if ($ok) {

                        $ok = @ file_put_contents($path . $file, $data);
                        if ($ok === strlen($data)) {
                            $this->push_info(ROBOTS_SUCCESS_MSG);

                            // устанавливаем странице фоновый звук УСПЕХ
                            $this->success_bgsound();

                        // иначе не удалось записать файл, сообщаем об этом
                        } else {
                            $msg = str_replace('*', $file, ROBOTS_BADWRITING_MSG);
                            $this->push_error($msg);
                        }

                    // иначе файл недоступен для записи, сообщаем об этом
                    } else {
                        $msg = str_replace('*', $file, ROBOTS_NONWRITABLE_MSG);
                        $this->push_error($msg);
                    }
                }
            }

            // если нет ошибки (изменения сохранены или это первое открытие страницы), читаем контент файла
            if ($this->error_msg == '') {
                if (is_readable($path . $file) && is_file($path . $file)) {
                    $data = @ file_get_contents($path . $file);
                } else {

                    // если нет файла для этого магазина (среди нескольких на едином движке), читаем из файла основного магазина
                    if ($file != 'robots.txt') {
                        $file = 'robots.txt';
                        if (is_readable($path . $file) && is_file($path . $file)) {
                            $data = @ file_get_contents($path . $file);
                        }
                    }
                }
                if ($data === FALSE) $data = '';
            }

            // передаем в шаблонизатор контент файла
            $this->smarty->assignByRef(ROBOTS_SMARTYVAR_DATA, $data);

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // передаем в шаблонизатор информационное сообщение
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        }
    }



    return;
?>