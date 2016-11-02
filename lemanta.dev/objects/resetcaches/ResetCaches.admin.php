<?php
    // =======================================================================
    /**
    *  Админ модуль очистки кешей
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
    define('RESETCACHES_PAGE_TITLE', 'Очистка кешей');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('RESETCACHES_TEMPLATE_FILENAME', 'reset_caches/reset_caches.htm');
    define('RESETCACHES_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                        . RESETCACHES_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // имена переменных в шаблонизаторе
    define('RESETCACHES_SMARTYVAR_RECHECK_DB', 'recheck_db');
    define('RESETCACHES_SMARTYVAR_CLEAR_DB', 'clear_db');
    define('RESETCACHES_SMARTYVAR_CLEAR_ADMIN_TPL', 'clear_admin_tpl');
    define('RESETCACHES_SMARTYVAR_CLEAR_CLIENT_TPL', 'clear_client_tpl');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('RESETCACHES_MODULELINK_POINTER', 'ResetCaches');
    define('RESETCACHES_MODULETAB_TEXT', 'кеши');
    define('RESETCACHES_MODULEMENU_PATH', 'Утилиты / Починка / Очистка кешей');



    // =======================================================================
    /**
    *  Админ модуль очистки кешей
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ResetCaches extends Basic {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
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
            $this->title = ADMIN_PAGE_TITLE_PREFIX . RESETCACHES_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = RESETCACHES_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . RESETCACHES_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->settings->admin_theme)
                  . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

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

            // если точно получен POST-запрос
            if ($this->request->isPosted()) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                $success = FALSE;

                // берем состояния флажков действий
                $recheck_db = $this->param(RESETCACHES_SMARTYVAR_RECHECK_DB) == TRUE;
                $clear_db = $this->param(RESETCACHES_SMARTYVAR_CLEAR_DB) == TRUE;
                $clear_admin = $this->param(RESETCACHES_SMARTYVAR_CLEAR_ADMIN_TPL) == TRUE;
                $clear_client = $this->param(RESETCACHES_SMARTYVAR_CLEAR_CLIENT_TPL) == TRUE;

                // если просили обеспечить перепроверку таблиц базы данных
                if ($recheck_db) {

                    // сбрасываем таймер рестартера контроля таблиц
                    $this->db->query('ALTER TABLE `' . DATABASE_MENUS_TABLENAME . '` CHANGE `restarter` `restarter` INT(11) NOT NULL DEFAULT \'0\' COMMENT \'Рестартер контроля таблиц\';');

                    // отчитываемся о сделанном в информационном сообщении
                    $this->push_info('Проверка структурного соответствия таблиц базы данных инициирована.');

                    // предполагаем воспроизвести фоновый звук УСПЕХ
                    $success = TRUE;
                }

                // если просили очистить кеши базы данных
                if ($clear_db) {

                    // удаляем кеш-таблицы
                    $this->db->query('DROP TABLE `' . DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME . '`;');
                    $this->db->query('DROP TABLE `' . DATABASE_CACHE_CATEGORIES_TABLENAME . '`;');
                    $this->db->query('DROP TABLE `' . DATABASE_CACHE_BRANDS_TABLENAME . '`;');
                    $this->db->query('DROP TABLE `' . DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME . '`;');
                    $this->db->query('DROP TABLE `' . DATABASE_CACHE_MENUS_SHORTVERSION_TABLENAME . '`;');
                    $this->db->query('DROP TABLE `cache_pvnames`;');

                    // отчитываемся о сделанном в информационном сообщении
                    $this->push_info('Кеши базы данных очищены.');

                    // предполагаем воспроизвести фоновый звук УСПЕХ
                    $success = TRUE;
                }

                // если просили очистить кеш шаблонов админпанели
                if ($clear_admin) {

                    // очищаем папкe скомпилированного шаблона админпанели
                    $this->smarty->clearCompiledFolder(TRUE);

                    // отчитываемся о сделанном в информационном сообщении
                    $this->push_info('Кеш шаблонов админпанели очищен.');

                    // предполагаем воспроизвести фоновый звук УСПЕХ
                    $success = TRUE;
                }

                // если просили очистить кеш шаблонов клиентской стороны
                if ($clear_client) {

                    // очищаем папкe скомпилированного шаблона клиентской стороны
                    $this->smarty->clearCompiledFolder(FALSE);

                    // отчитываемся о сделанном в информационном сообщении
                    $this->push_info('Кеш шаблонов клиентской стороны очищен.');

                    // предполагаем воспроизвести фоновый звук УСПЕХ
                    $success = TRUE;
                }

                // если в запросе не выбрано ни одно действие
                if (!$recheck_db && !$clear_db && !$clear_admin && !$clear_client) {
                    $this->push_error('Укажите, какое действие с кешами необходимо выполнить!');

                    // отказываемся от фонового звука УСПЕХ
                    $success = FALSE;
                }

                // если все удачно, устанавливаем странице фоновый звук УСПЕХ
                if ($success) $this->success_bgsound();
            }

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // передаем в шаблонизатор информационное сообщение
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        }
    }



    return;
?>