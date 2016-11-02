<?php
    // =======================================================================
    /**
    *  Админ модуль настроек memcache и htmcache
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/../.ref-models/AdminSetup.php');

    // текст заголовка страницы модуля
    define('CACHESETUP_PAGE_TITLE', 'Настройки MemCache и HtmCache');

    // имя файла шаблона модуля
    define('CACHESETUP_TEMPLATE_FILENAME', 'cache_setup/cache_setup.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('CACHESETUP_MODULELINK_POINTER', 'CacheSetup');
    define('CACHESETUP_MODULETAB_TEXT', 'htm-кеш');
    define('CACHESETUP_MODULEMENU_PATH', 'Утилиты / Починка / Очистка кешей / Настройки MemCache и HtmCache');



    // =======================================================================
    /**
    *  Админ модуль настроек memcache и htmcache
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CacheSetup extends AdminSetupREFModel {

        // имя модели базы данных
        protected $dbmodel = 'cachesetup';

        // имя файла шаблона
        protected $template = CACHESETUP_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Сохранение полученных во время редактирования настроек сайта
        *
        *  @access  protected
        *  @param   string  $upload_folder      относительное имя папки сохранения ожидаемых файлов (будет возвращено сюда)
        *                                       пустая строка = не ждем таких
        *  @param   string  $upload_watermark   имя ожидаемого файла водяного знака (будет возвращено сюда)
        *                                       пустая строка = не ждем такой файл
        *  @return  void
        */
        // ===================================================================

        protected function processSetupSave ( & $upload_folder = '', & $upload_watermark = '' ) {

            // разрешен ли htmcache
            $field = 'htmcache_enabled';
            $this->cms->db->settings->saveFromPost($field, 'Кеш - разрешен ли HtmCache');

            // сжимать ли htmcache
            $field = 'htmcache_gzip';
            $this->cms->db->settings->saveFromPost($field, 'Кеш - упаковывать ли файлы HtmCache');

            // срок жизни htmcache
            $field = 'htmcache_lifetime';
                $value = isset($_POST[$field]) &&  intval($_POST[$field]) > 0 ? intval($_POST[$field]) : 900;
                $this->cms->db->settings->save($field, $value, 'Кеш - срок жизни файлов HtmCache');

            // разрешен ли memcache
            $field = 'memcache_enabled';
            $this->cms->db->settings->saveFromPost($field, 'Кеш - разрешен ли MemCache');

            // срок жизни memcache
            $field = 'memcache_lifetime';
                $value = isset($_POST[$field]) &&  intval($_POST[$field]) > 0 ? intval($_POST[$field]) : 900;
                $this->cms->db->settings->save($field, $value, 'Кеш - срок жизни файлов MemCache');

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
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
            if (!$this->checkTemplate(CACHESETUP_PAGE_TITLE)) return TRUE;

            // если запостили форму старта команд
            if ($this->request->isPostedStart()) {
                $this->checkToken();
                $this->htmcache->checkAdminActions();
                $this->memcache->checkAdminActions();
            }

            // передаем в шаблонизатор признак поддержки memcache
            $this->cms->smarty->assign('memcache_supported', $this->memcache->isSupported());

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>