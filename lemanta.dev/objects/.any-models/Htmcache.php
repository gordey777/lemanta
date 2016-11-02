<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Кеширование HTML-страниц
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class HtmcacheANYModel extends BasicANYModel {

        // признак "запущен ли Htmcache"
        protected $started = TRUE;

        // признак "принудительное обновление кеша для текущей страницы"
        protected $refresh_now = FALSE;



        // ===================================================================
        /**
        *  Признак что модуль уже запущен
        *
        *  @access  public
        *  @return  boolean     TRUE если запущен
        */
        // ===================================================================

        public function isStarted () {
            return !empty($this->started) && $this->settings->get('htmcache_enabled');
        }



        // ===================================================================
        /**
        *  Признак что включена упаковка файлов кеша
        *
        *  @access  public
        *  @return  boolean     TRUE если упаковка включена
        */
        // ===================================================================

        public function isGZipped () {
            return $this->settings->get('htmcache_gzip')
                   && (function_exists('gzencode') && function_exists('gzdecode')
                   || function_exists('gzcompress') && function_exists('gzuncompress')
                   || function_exists('gzdeflate') && function_exists('gzinflate'));
        }



        // ===================================================================
        /**
        *  Признак что страница невыгодная для кеширования (например является
        *  результатом постинга формы)
        *
        *  @access  public
        *  @return  boolean     TRUE если невыгодная
        */
        // ===================================================================

        public function isUnprofitablePage () {
            return !empty($_POST) || !empty($_FILES);
        }



        // ===================================================================
        /**
        *  Признак что срок жизни кеш-файла истек
        *
        *  @access  public
        *  @param   string  $file       путь и имя файла
        *  @param   integer $lifetime   конкретный срок жизни
        *                               NULL если взять срок жизни из настроек сайта
        *  @return  boolean             TRUE если истек
        */
        // ===================================================================

        public function isExpired ( $file, $lifetime = null ) {
            if (!is_file($file) || !is_readable($file)) return TRUE;
            $touch = @ filemtime($file);
            if ($touch === FALSE) return TRUE;
            $now = time();
            if (is_null($lifetime)) $lifetime = $this->getLifetime();
            return $now < $touch || $now > $touch + $lifetime;
        }



        // ===================================================================
        /**
        *  Парсинг параметров запроса страницы в массив
        *
        *  @access  public
        *  @param   string  $query  параметры
        *  @return  array           массив параметров
        */
        // ===================================================================

        public function parsePageQueryString ( $query ) {
            $result = @ parse_str($query);
            if (is_array($result)) return $result;

            $result = array();
            $query = @ explode('&', $query);
            if (is_array($query)) {
                foreach ($query as $item) {
                    $item = @ explode('=', $item, 2);
                    if (isset($item[0])) {
                        $item[0] = trim($item[0]);
                        if ($item[0] != '') {
                            $result[$item[0]] = isset($item[1]) ? $item[1] : '';
                        }
                    }
                }
            }
            return $result;
        }



        // ===================================================================
        /**
        *  Получение установленного срока жизни файлов
        *
        *  @access  public
        *  @return  integer     срок жизни (в секундах)
        */
        // ===================================================================

        public function getLifetime () {
            $lifetime = $this->settings->get('htmcache_lifetime', 900);
            return max(1, intval($lifetime));
        }



        // ===================================================================
        /**
        *  Получение пути корневой папки кеша
        *
        *  @access  public
        *  @return  string              путь (без завершающего слеша)
        */
        // ===================================================================

        public function getCacheRootPath () {
            $suffix = $this->settings->get('files_host_suffix', '');
            $suffix = $this->hdd->safeFilename($suffix);
            return ROOT_FOLDER_REFERENCE . 'cache' . $suffix;
        }



        // ===================================================================
        /**
        *  Получение пути соответствующей папки кеша
        *
        *  @access  public
        *  @param   string  $key        ключевое слово о типе страницы
        *  @param   boolean $create     TRUE если создать папки при отсутствии
        *  @return  string              путь (без завершающего слеша)
        */
        // ===================================================================

        public function getCachePath ( $key = '', $create = FALSE ) {

            // вычисляем путь, если просили - убеждаемся в наличии кеш-папок
            $path = $this->getCacheRootPath();
            if ($create) $this->cms->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);

            // и вложенная папка согласно типа страницы
            $key = $this->hdd->safeFilename($key);
            if ($key == '') {
                $key = strtolower($this->request->getGet('module', 'undefined'));
                $key = $this->hdd->safeFilename($key);
            }
            if ($key != '') {
                $path .= '/' . $key;
                if ($create) $this->cms->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);
            }

            return $path;
        }



        // ===================================================================
        /**
        *  Получение имени файла в кеше
        *
        *  @access  public
        *  @return  string              имя файла (начинается со слеша)
        */
        // ===================================================================

        public function getCacheFilename () {

            // берем GET-параметры
            $ignores = isset($this->cms->designer->htmcache_get_ignores)
                       && is_array($this->cms->designer->htmcache_get_ignores)
                       ? $this->cms->designer->htmcache_get_ignores
                       : array('_');
            $ignores = array_merge($ignores, array('htmcache', 'memcache'));
            if (isset($_SERVER['REQUEST_URI'])) {
                $get = '';
                if (isset($_SERVER['QUERY_STRING'])) {
                    $get = ltrim(rtrim($_SERVER['QUERY_STRING']), '?& ');
                    $get = $this->parsePageQueryString($get);
                    if (!in_array('*', $ignores) && is_array($get)) {
                        ksort($get, SORT_STRING);
                        foreach ($get as $index => $value) {
                            if (in_array($index, $ignores)) {
                                unset($get[$index]);
                            } else {
                                $get[$index] = $index . '=' . $value;
                            }
                        }
                        $get = implode('&', $get);
                    } else {
                        $get = '';
                    }
                }
                $value = trim($_SERVER['REQUEST_URI']);
                $value = explode('#', $value, 2); $value = $value[0];
                $value = explode('?', $value, 2); $value = $value[0];
                $get = $value . ($get != '' ? '?' . $get : '');
            } else {
                $get = isset($_GET) ? $_GET : '';
                if (is_array($get)) {
                    if (in_array('*', $ignores)) {
                        $get = '';
                    } else {
                        ksort($get, SORT_STRING);
                        foreach ($get as $index => $value) {
                            if (in_array($index, $ignores)) unset($get[$index]);
                        }
                    }
                }
                try {
                    $get = @ serialize($get);
                } catch (Exception $e) { }
                if (!is_string($get)) $get = '';
            }

            // берем COOKIE-параметры
            $cookie = isset($_COOKIE) ? $_COOKIE : '';
            if (is_array($cookie)) {
                $ignores = isset($this->cms->designer->htmcache_cookie_ignores)
                           && is_array($this->cms->designer->htmcache_cookie_ignores)
                           ? $this->cms->designer->htmcache_cookie_ignores
                           : array('PHPSESSID', '__utma', '__utmb', '__utmc', '__utmv', '__utmz');
                if (in_array('*', $ignores)) {
                    $cookie = '';
                } else {
                    ksort($cookie, SORT_STRING);
                    foreach ($cookie as $index => $value) {
                        if (in_array($index, $ignores)) unset($cookie[$index]);
                    }
                    if (empty($cookie)) $cookie = '';
                }
            }
            try {
                $cookie = @ serialize($cookie);
            } catch (Exception $e) { }
            if (!is_string($cookie)) $cookie = '';

            // формируем имя файла (пользователь, хеш параметров)
            $file = !empty($this->cms->user->user_id) ? 'user' . intval($this->cms->user->user_id) : 'passer-';
            $file = '/' . $file . strtolower(md5($get . $cookie)) . ($this->isGZipped() ? '.gz' : '.htm');

            return $file;
        }



        // ===================================================================
        /**
        *  Очистка кеша
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function clear () {
            $path = $this->getCacheRootPath();
            $this->cms->clean_dir($path);
            $this->cms->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);
        }



        // ===================================================================
        /**
        *  Оптимизация кеша (удаление истекших файлов)
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function optimize () {
            $path = $this->getCacheRootPath();
            $this->optimizeFolder($path);
        }



        // ===================================================================
        /**
        *  Удаление истекших htm-файлов папки
        *
        *  @access  private
        *  @param   string  $path   путь папки
        *  @return  void
        */
        // ===================================================================

        private function optimizeFolder ( $path ) {
            $path = trim($path);
            $path = str_replace('\\', '/', $path);
            $path = rtrim($path, "/ \t\r\n");
            $path .= '/';
            if (($handle = @ opendir($path)) !== FALSE) {
                while (($file = readdir($handle)) !== FALSE) {
                    if (trim($file, '.') != '') {
                        $fullpath = $path . $file;
                        if (is_dir($fullpath)) {
                            $this->optimizeFolder($fullpath);
                        } elseif (strtolower(substr($file, -4)) == '.htm'
                        || strtolower(substr($file, -3)) == '.gz') {
                            if ($this->isExpired($fullpath)) @ unlink($fullpath);
                        }
                    }
                }
                closedir($handle);
            }
        }



        // ===================================================================
        /**
        *  Извлечение страницы из кеша
        *
        *  @access  public
        *  @param   mixed   $html       контент страницы (будет возвращен сюда)
        *  @param   string  $key        ключевое слово о типе страницы
        *  @return  boolean             TRUE если извлечено
        */
        // ===================================================================

        public function get ( & $html = FALSE, $key = ''  ) {
            if (!$this->isStarted()) return FALSE;

            // получаем путь к кешу (и убеждаемся в наличии кеш-папок)
            $path = $this->getCachePath($key, TRUE);

            // получаем имя файла
            $file = $path . $this->getCacheFilename();

            // извлекаем страницу
            if (empty($this->refresh_now) && !$this->isExpired($file)) {
                if (($handle = @ fopen($file, 'rb')) !== FALSE) {
                    @ flock($handle, LOCK_EX);
                    $html = '';
                    while (!feof($handle)) $html .= @ fread($handle, 65536);
                    @ flock($handle, LOCK_UN);
                    @ fclose($handle);
                    if ($this->isGZipped()) {
                        try {
                            if (function_exists('gzencode') && function_exists('gzdecode')) {
                                $data = @ gzdecode($html);
                            } elseif (function_exists('gzcompress') && function_exists('gzuncompress')) {
                                $data = @ gzuncompress($html, 1000000);
                            } elseif (function_exists('gzdeflate') && function_exists('gzinflate')) {
                                $data = @ gzinflate($html, 1000000);
                            }
                            if (!is_string($data)) return FALSE;
                            $html = $data;
                        } catch (Exception $e) {
                            return FALSE;
                        }
                    }
                    return TRUE;
                }

            // иначе срок жизни страницы истек (или принудительно обновляется), удаляем из кеша
            } else {
                $this->hdd->deleteFile($file);
            }

            return FALSE;
        }



        // ===================================================================
        /**
        *  Сохранение страницы в кеше
        *
        *  @access  public
        *  @param   mixed   $html       контент страницы
        *  @param   string  $key        ключевое слово о типе страницы
        *  @return  void
        */
        // ===================================================================

        public function set ( & $html, $key = '' ) {
            if ($this->isStarted() && is_string($html)) {

                // получаем путь к кешу (и убеждаемся в наличии кеш-папок)
                $path = $this->getCachePath($key, TRUE);

                // получаем имя файла
                $file = $path . $this->getCacheFilename();

                // сохраняем страницу
                if ($this->hdd->isWritableFile($file)) {
                    if (($handle = @ fopen($file, 'wb')) !== FALSE) {
                        @ flock($handle, LOCK_EX);
                        @ ftruncate($handle, 0);
                        if ($this->isGZipped()) {
                            try {
                                $data = 'Нет доступных функций упаковки кешированных страниц!';
                                if (function_exists('gzencode') && function_exists('gzdecode')) {
                                    $data = @ gzencode($html, 9, FORCE_GZIP);
                                } elseif (function_exists('gzcompress') && function_exists('gzuncompress')) {
                                    $data = @ gzcompress($html, 9);
                                } elseif (function_exists('gzdeflate') && function_exists('gzinflate')) {
                                    $data = @ gzdeflate($html, 9);
                                }
                            } catch (Exception $e) {
                                $data = FALSE;
                            }
                            if ($data === FALSE) $data = 'Не удалось упаковать кешированную страницу!';
                            @ fwrite($handle, $data);
                        } else {
                            @ fwrite($handle, $html);
                        }
                        @ flock($handle, LOCK_UN);
                        @ fclose($handle);
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия в запросе страницы админских действий и выполнение
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function checkAdminActions () {
            if ($this->request->getSession('admin') == 'admin') {
                $action = $this->request->getRequest('htmcache');
                if (is_string($action)) {
                    switch (strtolower(trim($action))) {
                        case 'clear':
                            $this->clear();
                            break;
                        case 'optimize':
                            $this->optimize();
                            break;
                        case 'refresh':
                            $this->refresh_now = TRUE;
                            break;
                    }
                }
            }
        }
    }



    return;
?>