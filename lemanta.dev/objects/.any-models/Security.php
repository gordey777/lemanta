<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');

    // имя переменной сеанса для хранения защитных кодов пользователя
    if (!defined('USER_CAPTCHA_CODES')) define('USER_CAPTCHA_CODES', 'user_captcha_codes');



    // =======================================================================
    /**
    *  Контроль вторжения
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SecurityANYModel extends BasicANYModel {

        // IP-адрес визитера
        protected $visitor_ip = FALSE;

        // хост визитера
        protected $visitor_host = FALSE;



        // ===================================================================
        /**
        *  Признак замеченного подлога глобальных переменных
        *
        *  @access  public
        *  @return  boolean     TRUE если замечен подлог
        */
        // ===================================================================

        public function isFraud () {
            return isset($_GET) && (isset($_GET['_SERVER'])         || isset($_GET['_ENV'])           || isset($_GET['_COOKIE'])
                                || isset($_GET['_GET'])             || isset($_GET['_POST'])          || isset($_GET['_REQUEST'])
                                || isset($_GET['_FILES'])           || isset($_GET['_SESSION'])       || isset($_GET['GLOBALS'])
                                || isset($_GET['HTTP_SERVER_VARS']) || isset($_GET['HTTP_ENV_VARS'])  || isset($_GET['HTTP_COOKIE_VARS'])
                                || isset($_GET['HTTP_GET_VARS'])    || isset($_GET['HTTP_POST_VARS']) || isset($_GET['HTTP_POST_FILES'])
                                || isset($_GET['HTTP_SESSION_VARS']))

                || isset($_POST) && (isset($_POST['_SERVER'])         || isset($_POST['_ENV'])           || isset($_POST['_COOKIE'])
                                 || isset($_POST['_GET'])             || isset($_POST['_POST'])          || isset($_POST['_REQUEST'])
                                 || isset($_POST['_FILES'])           || isset($_POST['_SESSION'])       || isset($_POST['GLOBALS'])
                                 || isset($_POST['HTTP_SERVER_VARS']) || isset($_POST['HTTP_ENV_VARS'])  || isset($_POST['HTTP_COOKIE_VARS'])
                                 || isset($_POST['HTTP_GET_VARS'])    || isset($_POST['HTTP_POST_VARS']) || isset($_POST['HTTP_POST_FILES'])
                                 || isset($_POST['HTTP_SESSION_VARS']))

                || isset($_COOKIE) && (isset($_COOKIE['_SERVER'])         || isset($_COOKIE['_ENV'])           || isset($_COOKIE['_COOKIE'])
                                   || isset($_COOKIE['_GET'])             || isset($_COOKIE['_POST'])          || isset($_COOKIE['_REQUEST'])
                                   || isset($_COOKIE['_FILES'])           || isset($_COOKIE['_SESSION'])       || isset($_COOKIE['GLOBALS'])
                                   || isset($_COOKIE['HTTP_SERVER_VARS']) || isset($_COOKIE['HTTP_ENV_VARS'])  || isset($_COOKIE['HTTP_COOKIE_VARS'])
                                   || isset($_COOKIE['HTTP_GET_VARS'])    || isset($_COOKIE['HTTP_POST_VARS']) || isset($_COOKIE['HTTP_POST_FILES'])
                                   || isset($_COOKIE['HTTP_SESSION_VARS']))

                || isset($_FILES) && (isset($_FILES['_SERVER'])         || isset($_FILES['_ENV'])           || isset($_FILES['_COOKIE'])
                                  || isset($_FILES['_GET'])             || isset($_FILES['_POST'])          || isset($_FILES['_REQUEST'])
                                  || isset($_FILES['_FILES'])           || isset($_FILES['_SESSION'])       || isset($_FILES['GLOBALS'])
                                  || isset($_FILES['HTTP_SERVER_VARS']) || isset($_FILES['HTTP_ENV_VARS'])  || isset($_FILES['HTTP_COOKIE_VARS'])
                                  || isset($_FILES['HTTP_GET_VARS'])    || isset($_FILES['HTTP_POST_VARS']) || isset($_FILES['HTTP_POST_FILES'])
                                  || isset($_FILES['HTTP_SESSION_VARS']));
        }



        // ===================================================================
        /**
        *  Признак замеченного подлога сеанса
        *
        *  @access  public
        *  @return  boolean     TRUE если замечен подлог
        */
        // ===================================================================

        public function isFraudSession () {
            if (isset($_SESSION) && is_array($_SESSION)) {
                $field = 'session_owner_ip';
                if (isset($_SESSION[$field])) {
                    $ip = $this->getVisitorIp();
                    return is_string($_SESSION[$field]) ? $_SESSION[$field] != $ip
                                                        : (is_array($_SESSION[$field]) ? !in_array($ip, $_SESSION[$field])
                                                                                       : FALSE);
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Получение IP-адреса визитера
        *
        *  @access  public
        *  @return  string      IP-адрес (если через прокси, то в формате ip_прокси,ip_визитера)
        */
        // ===================================================================

        public function getVisitorIp () {

            if (isset($this->visitor_ip) && is_string($this->visitor_ip)) return $this->visitor_ip;

            // берем физический IP-адрес
            $ip = $this->request->getServerAsSentence('REMOTE_ADDR');

            // берем ретранслированный IP-адрес (не имеет доверия, так как может быть подделан)
            $maybe_ip = $this->request->getServerAsSentence('HTTP_X_FORWARDED_FOR');
            if ($maybe_ip == '') {
                $maybe_ip = $this->request->getServerAsSentence('HTTP_X_FORWARDED');
                if ($maybe_ip == '') {
                    $maybe_ip = $this->request->getServerAsSentence('HTTP_FORWARDED_FOR');
                    if ($maybe_ip == '') {
                        $maybe_ip = $this->request->getServerAsSentence('HTTP_FORWARDED');
                        if ($maybe_ip == '') {
                            $maybe_ip = $this->request->getServerAsSentence('HTTP_X_COMING_FROM');
                            if ($maybe_ip == '') {
                                $maybe_ip = $this->request->getServerAsSentence('HTTP_COMING_FROM');
                                if ($maybe_ip == '') {
                                    $field = '';
                                    $maybe_ip = $this->request->getServerAsSentence('HTTP_X_REAL_IP');
                                    if ($maybe_ip == '') {
                                        $maybe_ip = $this->request->getServerAsSentence('HTTP_CLIENT_IP');
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // если адрес якобы был ретранслирован
            if ($maybe_ip != '' && $maybe_ip != $ip) {

                // если ретранслировался сервером сайта
                $server_ip = $this->request->getServerAsSentence('SERVER_ADDR');
                if ($server_ip == $ip) {
                    $ip = $maybe_ip;

                // иначе где-то по пути до сервера
                } else {
                    $ip = $ip . ' ' . $maybe_ip;
                }
            }

            // убираем невозможные символы
            $ip = $this->text->lowerCase($ip);
            $ip = preg_replace('/[^a-z0-9\-\._:]+/', ',', $ip);
            $ip = trim($ip, ',');

            // возвращаем IP-адрес
            $this->visitor_ip = & $ip;
            return $ip;
        }



        // ===================================================================
        /**
        *  Получение хоста визитера
        *
        *  @access  public
        *  @return  string      хост
        */
        // ===================================================================

        public function getVisitorHost () {

            if (isset($this->visitor_host) && is_string($this->visitor_host)) return $this->visitor_host;

            // если существует инспектор DDoS-атак, берем имя хоста из него
            if (empty($this->cms->inspector)) return '';
            $ip = $this->cms->inspector->ip;
            $this->visitor_host = $this->cms->inspector->visitor_host($ip, TRUE);
        }



        // ===================================================================
        /**
        *  Генерация англо-букво-цифрового пароля указанной длины
        *
        *  @access  public
        *  @param   integer $length     длина пароля
        *  @return  string              сгенерированный пароль (например h5eUg7XKo3) 
        */
        // ===================================================================

        public function generatePassword ( $length = 10 ) {
            $result = '';
            while ($length > 0) {
                $v = rand(0, 10 + 26 * 2 - 1);
                if ($v < 10) $result .= $v;
                elseif ($v < 36) $result .= chr($v - 10 + ord('A'));
                else $result .= chr($v - 36 + ord('a'));
                $length--;
            }
            return $result;
        }



        // ===================================================================
        /**
        *  Генерация аутентификатора операции для объекта с сохранением копии в сеансе
        *
        *  @access  public
        *  @param   object  $object     объект
        *  @return  void
        */
        // ===================================================================

        public function generateTokenForObject ( $object ) {
            $object->token = md5(uniqid(rand(), TRUE));
            $_SESSION['token'] = $object->token;
        }



        // ===================================================================
        /**
        *  Генерация arp1-хеша пароля
        *
        *  @access  public
        *  @param   string  $passwd     пароль
        *  @param   mixed   $salt       ключ шифрования
        *                               FALSE = сгенерировать случайный
        *  @param   integer $size       размер случайного ключа (количество символов)
        *  @return  string              хеш
        */
        // ===================================================================

        public function apr1Hash ( $passwd, $salt = FALSE, $size = 8 ) {
            if ($salt === FALSE || !is_string($salt)) {
                $size = max(1, $size);
                $size = min($size, 8);
                $salt = str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789');
                $salt = substr($salt, 0, $size);
            }
            $len = strlen($passwd);
            $text = $passwd . '$apr1$' . $salt;
            $bin = pack('H32', md5($passwd . $salt . $passwd));
            for ($i = $len; $i > 0; $i -= 16) {
                $text .= substr($bin, 0, min(16, $i));
            }
            for ($i = $len; $i > 0; $i >>= 1) {
                $text .= ($i & 1) ? chr(0) : $passwd{0};
            }
            $bin = pack('H32', md5($text));
            for ($i = 0; $i < 1000; $i++) {
                $new = ($i & 1) ? $passwd : $bin;
                if ($i % 3) $new .= $salt;
                if ($i % 7) $new .= $passwd;
                $new .= ($i & 1) ? $bin : $passwd;
                $bin = pack('H32', md5($new));
            }
            $tmp = '';
            for ($i = 0; $i < 5; $i++) {
                $k = $i + 6;
                $j = $i + 12;
                if ($j == 16) $j = 5;
                $tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
            }
            $tmp = chr(0) . chr(0) . $bin[11] . $tmp;
            $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
                   'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
                   './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
            return '$apr1$' . $salt . '$' . $tmp;
        }



        // ===================================================================
        /**
        *  Перенаправление на другую страницу
        *
        *  @access  public
        *  @param   string  $url    адрес страницы
        *  @return  void
        */
        // ===================================================================

        public function redirectToPage ( $url ) {
            @ header('Location: ' . $url);
            exit;
        }



        // ===================================================================
        /**
        *  Признак нахождения в демо режиме
        *
        *  @access  public
        *  @return  boolean             TRUE если находимся в демо
        */
        // ===================================================================

        public function inDemoMode () {
            return isset($this->cms->config) && isset($this->cms->config->demo) && !empty($this->cms->config->demo);
        }



        // ===================================================================
        /**
        *  Получение относительного пути к файлу паролей администраторов
        *
        *  @access  public
        *  @return  string      путь и имя файла
        */
        // ===================================================================

        public function adminsFilename () {
            return ROOT_FOLDER_REFERENCE . $this->hdd->safeFilename($this->cms->admin_folder) . '/.passwd';
        }



        // ===================================================================
        /**
        *  Получение массива записей об администраторах
        *
        *  @access  public
        *  @param   string  $file       путь и имя файла паролей
        *  @param   string  $login      фильтр: только с таким логином
        *  @return  array               массив записей (индексирован логинами админов)
        */
        // ===================================================================

        public function getAdmins ( $file, $login = '' ) {
            $result = array();
            $file = trim($file);
            if ($this->hdd->isReadableFile($file)) {
                $handle = @ fopen($file, 'rb');
                if ($handle !== FALSE) {

                    // читаем файл построчно
                    @ flock($handle, LOCK_EX);
                    while (@ !feof($handle)) {
                        $string = @ fgets($handle, 65536);
                        if ($string === FALSE || !is_string($string)) break;
                        $string = trim($string);

                        // извлекаем логин
                        $string = explode(':', $string);
                        $record = new stdClass;
                        $record->login = trim($string[0]);

                        // применяем фильтр логинов
                        if ($record->login != '' && ($login == '' || $login == $record->login)) {

                            // извлекаем хеш пароля
                            $record->hash = isset($string[1]) ? trim($string[1]) : '';
                            if ($record->hash != '') {

                                // извлекаем имя админа
                                $record->name = isset($string[2]) ? trim($string[2]) : '';

                                // извлекаем права доступа
                                $record->rights = isset($string[3]) ? trim($string[3]) : '';

                                // добавляем запись в массив (из дублирующихся допустима только первая встреченная)
                                if (!isset($result[$record->login])) {
                                    $result[$record->login] = $record;
                                }
                            }
                        }
                    }
                    @ fclose($handle);
                }
            }
            return $result;
        }



        // ===================================================================
        /**
        *  Получение логина текущего администратора
        *  (действует только при условии вызова скрипта из защищенной области)
        *
        *  @access  public
        *  @return  string          логин (или пустая строка, если нет админа)
        */
        // ===================================================================

        public function currentAdminLogin () {
            $login = $this->request->getServerAsSentence('PHP_AUTH_USER');
            if ($login == '') $login = $this->request->getServerAsSentence('REMOTE_USER');
            if ($login == '') $login = $this->request->getServerAsSentence('REDIRECT_REMOTE_USER');
            return trim($login);
        }



        // ===================================================================
        /**
        *  Признак наличия авторизованного администратора
        *
        *  @access  public
        *  @param   boolean $simplify   TRUE если упрощенная проверка (для клиентской зоны сайта)
        *                               FALSE если проверка "есть админ и он сейчас в админзоне"
        *  @return  boolean             TRUE если есть админ
        */
        // ===================================================================

        public function existsAdmin ( $simplify = TRUE ) {
            return $this->request->getSession('admin') == 'admin' && ($simplify || $this->currentAdminLogin() != '');
        }



        // ===================================================================
        /**
        *  Проверка прав доступа администратора к модулю
        *
        *  @access  public
        *  @param   string  $login      логин админа
        *  @param   string  $module     название модуля
        *  @param   array   $rights     массив имен (строчными буквами) разрешенных модулей (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если доступ разрешен
        */
        // ===================================================================

        public function checkAdminRights ( $login, $module, & $rights ) {

            // если логин не указан, считаем что доступ запрещен
            $rights = array('');
            if (!is_string($login) || $login == '') return FALSE;

            // читаем запись о таком администраторе (фильтр по логину)
            $file = $this->adminsFilename();
            $items = $this->getAdmins($file, $login);

            // если такой логин неизвестен, считаем что доступ запрещен
            if (!isset($items[$login])) return FALSE;

            // если это супер администратор
            $rights = array();
            if ($items[$login]->rights == '') return TRUE;

            // проверяем наличие модуля в правах
            $rights = $this->text->lowerCase($items[$login]->rights);
            $rights = explode(',', $rights);
            foreach ($rights as & $right) $right = trim($right);
            $module = $this->text->lowerCase(trim($module));
            return in_array($module, $rights);
        }



        // ===================================================================
        /**
        *  Проверка ввода защитного кода
        *
        *  @access  public
        *  @return  boolean     TRUE если код правильный
        */
        // ===================================================================

        public function checkCaptcha () {
            return empty($this->cms->inspector)
                || isset($_POST['captcha'])
                && $this->cms->inspector->cut_from_session(USER_CAPTCHA_CODES, $_POST['captcha'])
                || !isset($_POST['captcha'])
                && isset($_POST['captcha_code'])
                && $this->cms->inspector->cut_from_session(USER_CAPTCHA_CODES, $_POST['captcha_code']);
        }



        // ===================================================================
        /**
        *  Остановка выполнения скрипта
        *
        *  @access  public
        *  @param   string  $message    текст сообщения (пустая строка = без сообщения)
        *  @param   integer $header     код HTTP состояния (по умолчанию нет)
        *  @return  void
        */
        // ===================================================================

        public function stop ( $message = '', $header = null ) {
            if (is_int($header)) {
                $protocol = $this->request->getServerAsSentence('SERVER_PROTOCOL');
                if ($protocol == '') $protocol = 'HTTP/1.1';
                switch ($header) {
                    case 200:
                        @ header($protocol . ' 200 OK', TRUE, 200);
                        break;
                    case 400:
                        @ header($protocol . ' 400 Bad Request', TRUE, 400);
                        break;
                    case 403:
                        @ header($protocol . ' 403 Forbidden', TRUE, 403);
                        break;
                    case 404:
                        @ header($protocol . ' 404 Not Found', TRUE, 404);
                        break;
                    case 410:
                        @ header($protocol . ' 410 Gone', TRUE, 410);
                        break;
                }
            }
            if ($message != '') echo $message;
            exit;
        }
    }



    return;
?>