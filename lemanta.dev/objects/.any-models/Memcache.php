<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Кеширование данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class MemcacheANYModel extends BasicANYModel {

        // признак "запущен ли memcache"
        protected $started = FALSE;

        // признак "принудительное обновление кеша для текущей страницы"
        protected $refresh_now = FALSE;

        // сервер, порт
        public $host = 'localhost';
        public $port = 11211;

        // объект кеша
        protected $cache = null;



        // ===================================================================
        /**
        *  Проверка доступности необходимых классов
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function checkRequiredClasses () {
            parent::checkRequiredClasses();
            $this->started = $this->isSupported();
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
            $list = array('memcache_connect',
                          'memcache_set',
                          'memcache_get',
                          'memcache_add',
                          'memcache_replace',
                          'memcache_delete',
                          'memcache_flush',
                          'memcache_get_extended_stats',
                          'memcache_get_stats',
                          'memcache_get_version',
                          'memcache_pconnect',
                          'memcache_set_compress_threshold',
                          'memcache_set_server_params',
                          'memcache_close');
            foreach ($list as $name) {
                if (!function_exists($name)) return FALSE;
            }
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
            return !empty($this->started) && $this->settings->get('memcache_enabled');
        }



        // ===================================================================
        /**
        *  Получение установленного срока жизни кеша
        *
        *  @access  public
        *  @return  integer     срок жизни (в секундах)
        */
        // ===================================================================

        public function getLifetime () {
            $lifetime = $this->settings->get('memcache_lifetime', 900);
            return max(1, intval($lifetime));
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
            parent::prepare();

            // подключаемся (постоянное соединение) к серверу memcache
            if ($this->isStarted()) {
                try {
                    $this->cache = memcache_pconnect($this->host, $this->port);
                } catch (Exception $e) { }
            }
        }



        // ===================================================================
        /**
        *  Получение маркера кешируемых переменных движка
        *
        *  @access  public
        *  @return  string              маркер
        */
        // ===================================================================

        public function cmsVarsMarker () {
            return 'ImperaCMS' . $this->cms->settings->files_host_suffix . '-';
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
            // здесь именно такая ппроверка, а не isStarted(),
            // чтобы выполнять очистку и при настройке "выключено"
            if (!empty($this->started)) {
                try {
                    if (!is_null($this->cache)) memcache_flush($this->cache);
                } catch (Exception $e) { }
            }
        }



        // ===================================================================
        /**
        *  Извлечение переменной из кеша
        *
        *  @access  public
        *  @param   string  $key        имя переменной
        *  @param   mixed   $var        переменная (будет возвращена сюда)
        *  @return  boolean             TRUE если извлечено
        */
        // ===================================================================

        public function get ( $key, & $var = FALSE ) {
            if (!$this->isStarted()) return FALSE;
            try {
                $key = $this->cmsVarsMarker() . $key;
                if (empty($this->refresh_now)) {
                    $var = memcache_get($this->cache, $key);
                    return $var !== FALSE;
                } else {
                    memcache_delete($this->cache, $key, 0);
                    return FALSE;
                }
            } catch (Exception $e) {
                return FALSE;
            }
        }



        // ===================================================================
        /**
        *  Сохранение переменной в кеше
        *
        *  @access  public
        *  @param   string  $key        имя переменной
        *  @param   mixed   $var        переменная
        *  @return  void
        */
        // ===================================================================

        public function set ( $key, & $var ) {
            if ($this->isStarted()) {
                try {
                    $key = $this->cmsVarsMarker() . $key;
                    memcache_set($this->cache, $key, $var, MEMCACHE_COMPRESSED, $this->getLifetime());
                } catch (Exception $e) { }
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
                $action = $this->request->getRequest('memcache');
                if (is_string($action)) {
                    switch (strtolower(trim($action))) {
                        case 'clear':
                            $this->clear();
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