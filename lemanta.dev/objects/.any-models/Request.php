<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с параметрами запроса страницы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class RequestANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Извлечение строкового параметра, доступного по указателю, как
        *  печатного предложения (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   pointer $ptr    указатель
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           значение параметра
        */
        // ===================================================================

        public function getAsSentence ( & $ptr, $def = '' ) {
            if (!is_string($ptr) && !is_numeric($ptr) && !is_bool($ptr)) return $def;
            $def = preg_replace('/[ \r\n\t\s]+/u', ' ', $ptr);
            return trim($def);
        }



        // ===================================================================
        /**
        *  Извлечение строкового параметра, доступного по указателю, как
        *  списка через запятую, конвертированного в массив уникальных строк
        *
        *  @access  public
        *  @param   pointer $ptr    указатель
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           массив строк или значение по умолчанию
        */
        // ===================================================================

        public function getAsCommaList ( & $ptr, $def = array() ) {
            if (!is_string($ptr) && !is_numeric($ptr) && !is_bool($ptr)) return $def;
            $def = array();
            $string = preg_replace('/[ \r\n\t\s]+/u', ' ', $ptr);
            $string = trim($string);
            $string = explode(',', $string);
            foreach ($string as & $value) {
                $value = trim($value);
                if ($value != '') $def[$this->text->lowerCase($value)] = $value;
            }
            return $def;
        }



        // ===================================================================
        /**
        *  Извлечение array параметра, доступного по указателю, как массива
        *  уникальных идентификаторов
        *
        *  @access  public
        *  @param   pointer $ptr    указатель
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           массив идентификаторов или значение по умолчанию
        */
        // ===================================================================

        public function getAsIdsArray ( & $ptr, $def = array() ) {
            if (!is_array($ptr)) return $def;
            $def = array();
            if (!empty($ptr)) {
                foreach ($ptr as $value) {
                    if (is_string($value) || is_numeric($value)) {
                        $value = intval($value);
                        if (!empty($value)) $def[$value] = $value;
                    }
                }
            }
            return $def;
        }



        // ===================================================================
        /**
        *  Признак что GET-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isGetArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_GET[$param]) && is_array($_GET[$param])
                    && (!$non_empty || !empty($_GET[$param]));
            } else {
                return isset($_GET[$param][$id]) && is_array($_GET[$param][$id])
                    && (!$non_empty || !empty($_GET[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия GET-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsGet ( $param ) {
            return isset($_GET[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение GET-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getGet ( $param, $def = FALSE ) {
            return isset($_GET[$param]) ? $_GET[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение GET-параметра как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getGetAsSentence ( $param, $def = '' ) {
            if (!isset($_GET[$param])) return $def;
            return $this->getAsSentence($_GET[$param], $def);
        }



        // ===================================================================
        /**
        *  Извлечение GET-параметра как целого числа
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getGetAsInteger ( $param, $def = 0 ) {
            return isset($_GET[$param]) ? intval($_GET[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение GET-параметра как числа с плавающей запятой
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               число или значение по умолчанию
        */
        // ===================================================================

        public function getGetAsFloat ( $param, $def = 0.0 ) {
            return isset($_GET[$param]) ? $this->number->floatValue($_GET[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение GET-параметра как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getGetAsBoolean ( $param, $def = 0 ) {
            if (!isset($_GET[$param])) return $def;
            return $_GET[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Признак что POST-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isPostArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_POST[$param]) && is_array($_POST[$param])
                    && (!$non_empty || !empty($_POST[$param]));
            } else {
                return isset($_POST[$param][$id]) && is_array($_POST[$param][$id])
                    && (!$non_empty || !empty($_POST[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия POST-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsPost ( $param ) {
            return isset($_POST[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение POST-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getPost ( $param, $def = FALSE ) {
            return isset($_POST[$param]) ? $_POST[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение POST-параметра как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getPostAsSentence ( $param, $def = '' ) {
            if (!isset($_POST[$param])) return $def;
            return $this->getAsSentence($_POST[$param], $def);
        }



        // ===================================================================
        /**
        *  Извлечение POST-параметра как целого числа
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getPostAsInteger ( $param, $def = 0 ) {
            return isset($_POST[$param]) ? intval($_POST[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение POST-параметра как числа с плавающей запятой
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               число или значение по умолчанию
        */
        // ===================================================================

        public function getPostAsFloat ( $param, $def = 0.0 ) {
            return isset($_POST[$param]) ? $this->number->floatValue($_POST[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение POST-параметра как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getPostAsBoolean ( $param, $def = 0 ) {
            if (!isset($_POST[$param])) return $def;
            return $_POST[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Проверка наличия поля записи в POST
        *
        *  @access  public
        *  @param   string  $field      имя поля
        *  @param   integer $id         идентификатор записи
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsPostRecordField ( $field, $id ) {
            return isset($_POST[$field][$id]);
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как строки (анти трейлинг)
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           строка или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordField ( $field, $id, $def = '' ) {
            return isset($_POST[$field][$id]) ? trim($_POST[$field][$id]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           строка или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsSentence ( $field, $id, $def = '' ) {
            if (!isset($_POST[$field][$id])) return $def;
            return $this->getAsSentence($_POST[$field][$id], $def);
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как списка через запятую
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           массив строк или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsCommaList ( $field, $id, $def = array() ) {
            if (!isset($_POST[$field][$id])) return $def;
            return $this->getAsCommaList($_POST[$field][$id], $def);
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как списка идентификаторов
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           массив целых чисел или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsIdsArray ( $field, $id, $def = array() ) {
            if (!isset($_POST[$field][$id])) return $def;
            return $this->getAsIdsArray($_POST[$field][$id], $def);
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как целого числа
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           целое число или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsInteger ( $field, $id, $def = 0 ) {
            return isset($_POST[$field][$id]) ? intval($_POST[$field][$id]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как действительного числа
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           действительное число или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsFloat ( $field, $id, $def = 0 ) {
            return isset($_POST[$field][$id]) ? $this->number->floatValue($_POST[$field][$id]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как даты
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           строка YYYY-MM-DD HH:MM:SS или штамп времени
        *                           или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsDate ( $field, $id, $def = null ) {
            if (is_null($def)) $def = time();
            return isset($_POST[$field][$id]) ? $this->date->fixDate($_POST[$field][$id]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение из POST значения поля записи как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getPostRecordFieldAsBoolean ( $field, $id, $def = 0 ) {
            return isset($_POST[$field][$id]) ? ($_POST[$field][$id] ? 1 : 0) : $def;
        }



        // ===================================================================
        /**
        *  Признак что REQUEST-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isRequestArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_REQUEST[$param]) && is_array($_REQUEST[$param])
                    && (!$non_empty || !empty($_REQUEST[$param]));
            } else {
                return isset($_REQUEST[$param][$id]) && is_array($_REQUEST[$param][$id])
                    && (!$non_empty || !empty($_REQUEST[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия REQUEST-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsRequest ( $param ) {
            return isset($_REQUEST[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение REQUEST-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getRequest ( $param, $def = FALSE ) {
            return isset($_REQUEST[$param]) ? $_REQUEST[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение REQUEST-параметра как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getRequestAsSentence ( $param, $def = '' ) {
            if (!isset($_REQUEST[$param])) return $def;
            return $this->getAsSentence($_REQUEST[$param], $def);
        }



        // ===================================================================
        /**
        *  Извлечение REQUEST-параметра как целого числа
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getRequestAsInteger ( $param, $def = 0 ) {
            return isset($_REQUEST[$param]) ? intval($_REQUEST[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение REQUEST-параметра как числа с плавающей запятой
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               число или значение по умолчанию
        */
        // ===================================================================

        public function getRequestAsFloat ( $param, $def = 0.0 ) {
            return isset($_REQUEST[$param]) ? $this->number->floatValue($_REQUEST[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение REQUEST-параметра как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getRequestAsBoolean ( $param, $def = 0 ) {
            if (!isset($_REQUEST[$param])) return $def;
            return $_REQUEST[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Признак что COOKIE-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isCookieArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_COOKIE[$param]) && is_array($_COOKIE[$param])
                    && (!$non_empty || !empty($_COOKIE[$param]));
            } else {
                return isset($_COOKIE[$param][$id]) && is_array($_COOKIE[$param][$id])
                    && (!$non_empty || !empty($_COOKIE[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия COOKIE-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsCookie ( $param ) {
            return isset($_COOKIE[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение COOKIE-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getCookie ( $param, $def = FALSE ) {
            return isset($_COOKIE[$param]) ? $_COOKIE[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение COOKIE-параметра как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getCookieAsSentence ( $param, $def = '' ) {
            if (!isset($_COOKIE[$param])) return $def;
            return $this->getAsSentence($_COOKIE[$param], $def);
        }



        // ===================================================================
        /**
        *  Извлечение COOKIE-параметра как целого числа
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getCookieAsInteger ( $param, $def = 0 ) {
            return isset($_COOKIE[$param]) ? intval($_COOKIE[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение COOKIE-параметра как числа с плавающей запятой
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               число или значение по умолчанию
        */
        // ===================================================================

        public function getCookieAsFloat ( $param, $def = 0.0 ) {
            return isset($_COOKIE[$param]) ? $this->number->floatValue($_COOKIE[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение COOKIE-параметра как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getCookieAsBoolean ( $param, $def = 0 ) {
            if (!isset($_COOKIE[$param])) return $def;
            return $_COOKIE[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Признак что SESSION-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isSessionArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_SESSION[$param]) && is_array($_SESSION[$param])
                    && (!$non_empty || !empty($_SESSION[$param]));
            } else {
                return isset($_SESSION[$param][$id]) && is_array($_SESSION[$param][$id])
                    && (!$non_empty || !empty($_SESSION[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия SESSION-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsSession ( $param ) {
            return isset($_SESSION[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение SESSION-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getSession ( $param, $def = FALSE ) {
            return isset($_SESSION[$param]) ? $_SESSION[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение SESSION-параметра как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getSessionAsSentence ( $param, $def = '' ) {
            if (!isset($_SESSION[$param])) return $def;
            return $this->getAsSentence($_SESSION[$param], $def);
        }



        // ===================================================================
        /**
        *  Извлечение SESSION-параметра как целого числа
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getSessionAsInteger ( $param, $def = 0 ) {
            return isset($_SESSION[$param]) ? intval($_SESSION[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение SESSION-параметра как числа с плавающей запятой
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               число или значение по умолчанию
        */
        // ===================================================================

        public function getSessionAsFloat ( $param, $def = 0.0 ) {
            return isset($_SESSION[$param]) ? $this->number->floatValue($_SESSION[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение SESSION-параметра как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getSessionAsBoolean ( $param, $def = 0 ) {
            if (!isset($_SESSION[$param])) return $def;
            return $_SESSION[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Признак что SERVER-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isServerArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_SERVER[$param]) && is_array($_SERVER[$param])
                    && (!$non_empty || !empty($_SERVER[$param]));
            } else {
                return isset($_SERVER[$param][$id]) && is_array($_SERVER[$param][$id])
                    && (!$non_empty || !empty($_SERVER[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия SERVER-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsServer ( $param ) {
            return isset($_SERVER[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение SERVER-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getServer ( $param, $def = FALSE ) {
            return isset($_SERVER[$param]) ? $_SERVER[$param] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение SERVER-параметра как печатного предложения
        *  (анти трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getServerAsSentence ( $param, $def = '' ) {
            if (!isset($_SERVER[$param])) return $def;
            return $this->getAsSentence($_SERVER[$param], $def);
        }



        // ===================================================================
        /**
        *  Извлечение SERVER-параметра как целого числа
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               целое число или значение по умолчанию
        */
        // ===================================================================

        public function getServerAsInteger ( $param, $def = 0 ) {
            return isset($_SERVER[$param]) ? intval($_SERVER[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение SERVER-параметра как числа с плавающей запятой
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               число или значение по умолчанию
        */
        // ===================================================================

        public function getServerAsFloat ( $param, $def = 0.0 ) {
            return isset($_SERVER[$param]) ? $this->number->floatValue($_SERVER[$param]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение SERVER-параметра как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getServerAsBoolean ( $param, $def = 0 ) {
            if (!isset($_SERVER[$param])) return $def;
            return $_SERVER[$param] ? 1 : 0;
        }



        // ===================================================================
        /**
        *  Признак что FILES-параметр является массивом
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   boolean $non_empty  TRUE если должен быть непустым массивом
        *                               FALSE если может быть пустым
        *  @param   mixed   $id         ИДЕНТИФИКАТОР если рассматриваем конкретный элемент параметра
        *                               NULL если рассматриваем параметр как одноуровневый
        *  @return  boolean             TRUE если массив
        */
        // ===================================================================

        public function isFilesArray ( $param, $non_empty = TRUE, $id = null ) {
            if (is_null($id)) {
                return isset($_FILES[$param]) && is_array($_FILES[$param])
                    && (!$non_empty || !empty($_FILES[$param]));
            } else {
                return isset($_FILES[$param][$id]) && is_array($_FILES[$param][$id])
                    && (!$non_empty || !empty($_FILES[$param][$id]));
            }
        }



        // ===================================================================
        /**
        *  Проверка наличия FILES-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если есть
        */
        // ===================================================================

        public function existsFiles ( $param ) {
            return isset($_FILES[$param]);
        }



        // ===================================================================
        /**
        *  Извлечение FILES-параметра
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        public function getFiles ( $param, $def = FALSE ) {
            return isset($_FILES[$param]) ? $_FILES[$param] : $def;
        }



        // ===================================================================
        /**
        *  Проверка что запостили форму с данными
        *
        *  @access  public
        *  @return  boolean     TRUE если форма принята
        */
        // ===================================================================

        public function isPosted () {
            $field = 'post';
            return isset($_POST[$field]) && $_POST[$field];
        }



        // ===================================================================
        /**
        *  Проверка что запостили форму со списком данных
        *
        *  @access  public
        *  @return  boolean     TRUE если форма принята
        */
        // ===================================================================

        public function isPostedList () {
            $field = 'post';
            return isset($_POST[$field]) && is_array($_POST[$field]) && empty($_POST['ignore_post']);
        }



        // ===================================================================
        /**
        *  Признание элемента списка опубликованным
        *
        *  @access  public
        *  @param   integer $id     идентификатор элемента
        *  @return  boolean         TRUE если признано
        */
        // ===================================================================

        public function isPostedThisOne ( $id ) {
            $field = 'post_this_one';
            return !isset($_POST[$field]) || isset($_POST[$field][$id]);
        }



        // ===================================================================
        /**
        *  Проверка что запостили форму настроек
        *
        *  @access  public
        *  @return  boolean             TRUE если запостили
        */
        // ===================================================================

        public function isPostedSetup () {
            return isset($_POST['setup']);
        }



        // ===================================================================
        /**
        *  Проверка что запостили форму старта
        *
        *  @access  public
        *  @return  boolean             TRUE если запостили
        */
        // ===================================================================

        public function isPostedStart () {
            return isset($_POST['start']);
        }



        // ===================================================================
        /**
        *  Проверка что файл запостили
        *
        *  @access  public
        *  @param   string  $param      имя параметра
        *  @return  boolean             TRUE если файл запостили
        */
        // ===================================================================

        public function isPostedFile ( $param ) {
            $field = 'name';
            $field2 = 'tmp_name';
            return isset($_FILES[$param][$field]) && $_FILES[$param][$field] != ''
                && isset($_FILES[$param][$field2])
                && ($_FILES[$param][$field2] != '' || isset($_FILES[$param]['error']));
        }



        // ===================================================================
        /**
        *  Признание поля записи опубликованным
        *
        *  @access  public
        *  @param   string  $field  имя поля
        *  @param   integer $id     идентификатор записи
        *  @return  boolean         TRUE если признано
        */
        // ===================================================================

        public function isPostedRecordField ( $field, $id ) {
            $param = 'post_mini';
            return isset($_POST[$field][$id])
                   || !isset($_POST[$param]) || !$_POST[$param];
        }



        // ===================================================================
        /**
        *  Проверка что поле находится в списке обрабатываемых полей
        *
        *  @access  public
        *  @param   string  $name       имя искомого поля
        *  @param   array   $fields     массив обрабатываемых полей, формат элемента:
        *                                   'поле' ИЛИ
        *                                   'поле' => значение ИЛИ
        *                                   'поле' => array(значение, значение2, ...) ИЛИ
        *                                   array('поле' => значение, 'поле2', ...)
        *  @param   boolean $required   TRUE если обязательно (будет возвращено в эту переменную)
        *                               FALSE если не обязательно для заполнения
        *  @return  boolean             TRUE если находится
        */
        // ===================================================================

        public function existsInFields ( $name, $fields, & $required = FALSE ) {
            $required = FALSE;
            if (is_array($fields) && !empty($fields)) {
                foreach ($fields as $key => $values) {
                    if (is_string($key)) {
                        if ($key == $name) {
                            $required = TRUE;    // TODO: нужен реальный контроль обязательности
                            return TRUE;
                        }
                    } else if (is_string($values)) {
                        if ($values == $name) {
                            $required = TRUE;    // TODO: нужен реальный контроль обязательности
                            return TRUE;
                        }
                    } else if (is_array($values) && !empty($values)) {
                        foreach ($values as $key => $value) {
                            if (is_string($key)) {
                                if ($key == $name) {
                                    $required = TRUE;    // TODO: нужен реальный контроль обязательности
                                    return TRUE;
                                }
                            } else if (is_string($value)) {
                                if ($value == $name) {
                                    $required = TRUE;    // TODO: нужен реальный контроль обязательности
                                    return TRUE;
                                }
                            }
                        }
                    }
                }
            }
            return FALSE;
        }
    }



    return;
?>