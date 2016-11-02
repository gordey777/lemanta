<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с сеансом
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SessionANYModel extends BasicANYModel {

        // признак "запущен ли уже сеанс"
        protected $started = FALSE;



        // ===================================================================
        /**
        *  Извлечение параметра сеанса
        *
        *  @access  public
        *  @param   string  $param  имя параметра
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           значение параметра
        */
        // ===================================================================

        public function get ( $param, $def = FALSE ) {
            return isset($_SESSION[$param]) ? $_SESSION[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра сеанса как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param  имя параметра
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           значение параметра
        */
        // ===================================================================

        public function getAsSentence ( $param, $def = '' ) {
            if (!isset($_SESSION[$param])
            || !is_string($_SESSION[$param])
            && !is_numeric($_SESSION[$param])
            && !is_bool($_SESSION[$param])) return $def;
            $def = preg_replace('/[ \r\n\t\s]+/u', ' ', $_SESSION[$param]);
            return trim($def);
        }



        // ===================================================================
        /**
        *  Извлечение параметра сеанса как целого цисла
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getAsInteger ( $param, $def = 0 ) {
            return isset($_SESSION[$param]) ? intval($_SESSION[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра сеанса как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getAsBoolean ( $param, $def = 0 ) {
            if (!isset($_SESSION[$param])) return $def;
            return $_SESSION[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Установка параметра сеанса
        *
        *  @access  public
        *  @param   string  $param  имя параметра
        *  @param   mixed   $value  значение
        *  @return  void
        */
        // ===================================================================

        public function set ( $param, $value ) {
            $_SESSION[$param] = $value;
        }



        // ===================================================================
        /**
        *  Удаление параметра сеанса
        *
        *  @access  public
        *  @param   string  $param  имя параметра
        *  @return  void
        */
        // ===================================================================

        public function delete ( $param ) {
            if (isset($_SESSION[$param])) unset($_SESSION[$param]);
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
            $this->started = isset($_SESSION) && is_array($_SESSION);
        }



        // ===================================================================
        /**
        *  Признак что сеанс уже запущен
        *
        *  @access  public
        *  @return  boolean     TRUE если сеанс запущен
        */
        // ===================================================================

        public function isStarted () {
            return isset($this->started) && $this->started;
        }



        // ===================================================================
        /**
        *  Получение идентификатора запущенного сеанса
        *
        *  @access  public
        *  @param   string  $def    значение по умолчанию, если сеанс не запущен
        *  @return  string          идентификатор
        */
        // ===================================================================

        public function getSessionId ( $def = '' ) {
            if (!$this->isStarted()) return $def;
            $id = @ session_id();
            return $id != '' ? $id : $def;
        }



        // ===================================================================
        /**
        *  Запуск сеанса
        *
        *  Сеанс может быть обычным или персональным, то есть именованным
        *  по IP-адресу визитера. Персональные сеансы эффективны как средство
        *  снижения нагрузки на сервер (не плодятся файлы сеансов для разных
        *  окон браузера одного и того же визитера). Однако персональные
        *  сеансы непригодны для непрозрачных прокси, когда несколько
        *  визитеров заходят через один сетевой (прокси) компьютер и этот
        *  компьютер прячет локальные адреса визитеров.
        *
        *  @access  public
        *  @param   integer $lifetime   число минут хранения сеанса
        *  @param   boolean $personal   TRUE если персональный сеанс
        *  @return  void
        */
        // ===================================================================

        public function start ( $lifetime = 30, $personal = FALSE ) {

            if ($this->isStarted()) return;

            // выставляем настройки сеанса:
            //     время жизни отправленных в браузер cookie определяет браузер
            //     данные в запущенном сеансе хранить не более стольки минут
            $lifetime = max(1, intval($lifetime));
            @ ini_set('session.cookie_lifetime', 0);
            @ ini_set('session.gc_maxlifetime', $lifetime * 60);

            // запускаем сеанс
            if ($personal) {
                $ip = $this->security->getVisitorIp();
                session_id(md5($ip));
            }
            session_start();
            $this->started = TRUE;

            // создаем в сеансе элемент безопасности
            if (isset($_SESSION) && is_array($_SESSION)) {
                $field = 'session_owner_ip';
                if (!isset($_SESSION[$field])) {
                    if (!isset($ip)) $ip = $this->security->getVisitorIp();
                    $_SESSION[$field] = $ip;
                }
            }
        }



        // ===================================================================
        /**
        *  Обеспечение наличия поля в сеансе
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   mixed   $def    значение по умолчанию (если поле создается сейчас)
        *  @return  void
        */
        // ===================================================================

        public function mustbeField ( $field, $def = '' ) {
            if (!isset($_SESSION[$field])) $_SESSION[$field] = $def;
        }



        // ===================================================================
        /**
        *  Восстановление массива идентификаторов из COOKIE-параметра
        *
        *  @access  public
        *  @param   string  $param  имя параметра
        *  @param   boolean $if_no  TRUE если восстанавливать только при отсутствии
        *                           FALSE если восстанавливать в любом случае
        *  @return  boolean         TRUE если восстановлено именно из COOKIE
        */
        // ===================================================================

        public function restoreIdsArrayFromCookie ( $param, $if_no = TRUE ) {
            $changed = FALSE;
            if (!$if_no || !isset($_SESSION[$param]) || !is_array($_SESSION[$param])) {
                $_SESSION[$param] = array();
                if ($this->request->isCookieArray($param)) {
                    foreach ($_COOKIE[$param] as $id) {
                        if (is_string($id) || is_numeric($id)) {
                            $id = trim($id);
                            if (!empty($id)) {
                                $_SESSION[$param][] = $id;
                                $changed = TRUE;
                            }
                        }
                    }
                }
            }
            return $changed;
        }



        // ===================================================================
        /**
        *  Восстановление массива корзины из COOKIE-параметра
        *
        *  @access  public
        *  @param   string  $param  имя параметра (идентификаторы)
        *  @param   string  $param2 имя параметра (отобранные свойства)
        *  @param   boolean $if_no  TRUE если восстанавливать только при отсутствии
        *                           FALSE если восстанавливать в любом случае
        *  @return  boolean         TRUE если восстановлено именно из COOKIE
        */
        // ===================================================================

        public function restoreCartArrayFromCookie ( $param, $param2, $if_no = TRUE ) {
            $changed = FALSE;
            if (!$if_no || !isset($_SESSION[$param]) || !is_array($_SESSION[$param])) {
                $_SESSION[$param] = array();
                $_SESSION[$param2] = array();
                if ($this->request->isCookieArray($param)) {
                    foreach ($_COOKIE[$param] as $id => $count) {
                        if (is_string($id) || is_numeric($id)) {
                            $id = trim($id);
                            if (!empty($id)) {
                                if (is_string($count) || is_numeric($count)) {
                                    $count = trim($count);
                                    if (!empty($count)) {
                                        $_SESSION[$param][$id] = $count;
                                        $changed = TRUE;
                                    }
                                }
                            }
                        }
                    }
                    if ($changed) {
                        if ($this->request->isCookieArray($param2)) {
                            foreach ($_COOKIE[$param2] as $id => $props) {
                                if (is_string($id) || is_numeric($id)) {
                                    $id = trim($id);
                                    if (!empty($id)) {
                                        if (isset($_SESSION[$param][$id])) {
                                            if (is_string($props) || is_numeric($props)) {
                                                $_SESSION[$param2][$id] = trim($props);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $changed;
        }



        // ===================================================================
        /**
        *  Проверка наличия в сеансе контрольного кода репостинга формы
        *
        *  @access  public
        *  @param   string  $copystop   значение кода
        *  @param   string  $prefix     префикс имени поля сеанса
        *  @return  void
        */
        // ===================================================================

        public function checkCopystop ( $copystop, $prefix ) {
            $prefix = $prefix . 'copystop';
            return !isset($_SESSION[$prefix]) || !is_array($_SESSION[$prefix])
                || !in_array($copystop, $_SESSION[$prefix]);
        }



        // ===================================================================
        /**
        *  Сохранение контрольного кода репостинга формы в сеансе
        *
        *  @access  public
        *  @param   string  $copystop   значение кода
        *  @param   string  $prefix     префикс имени поля сеанса
        *  @return  void
        */
        // ===================================================================

        public function saveCopystop ( $copystop, $prefix ) {
            if (!$this->checkCopystop($copystop, $prefix)) return;
            $prefix = $prefix . 'copystop';
            if (!isset($_SESSION[$prefix]) || !is_array($_SESSION[$prefix])) {
                $_SESSION[$prefix] = array();
            }
            $_SESSION[$prefix][] = $copystop;
        }



        // ===================================================================
        /**
        *  Остановка сеанса
        *
        *  @access  public
        *  @param   boolean $destroy    TRUE если уничтожить навсегда
        *  @return  void
        */
        // ===================================================================

        public function stop ( $destroy = FALSE ) {
            if ($destroy) {
                $_SESSION = array();
                $name = session_name();
                if (isset($_COOKIE[$name])) {
                    $year = 365 * 24 * 60 * 60;
                    @ setcookie($name, '', time() - $year, '/');
                }
                session_destroy();
            }
            session_write_close();
            $this->started = FALSE;
        }
    }



    return;
?>