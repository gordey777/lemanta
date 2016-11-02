<?php
    // =======================================================================
    /**
    *  Стартовая точка клиентской стороны
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // выключаем информирование о любой ошибке (клиенту не нужно видеть технические подробности возможных ошибок), если запущено не на локальном компьютере
    if (isset($_SERVER['HTTP_HOST'])
    && (strtolower($_SERVER['HTTP_HOST']) == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1')) {
        error_reporting(E_ALL & ~E_STRICT);
    } else {
        error_reporting(0);
    }

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_GET['_SERVER']) || isset($_GET['_ENV']) || isset($_GET['_COOKIE'])
    || isset($_GET['_GET']) || isset($_GET['_POST']) || isset($_GET['_REQUEST'])
    || isset($_GET['_FILES']) || isset($_GET['_SESSION']) || isset($_GET['GLOBALS'])) exit;

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_POST['_SERVER']) || isset($_POST['_ENV']) || isset($_POST['_COOKIE'])
    || isset($_POST['_GET']) || isset($_POST['_POST']) || isset($_POST['_REQUEST'])
    || isset($_POST['_FILES']) || isset($_POST['_SESSION']) || isset($_POST['GLOBALS'])) exit;

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_COOKIE['_SERVER']) || isset($_COOKIE['_ENV']) || isset($_COOKIE['_COOKIE'])
    || isset($_COOKIE['_GET']) || isset($_COOKIE['_POST']) || isset($_COOKIE['_REQUEST'])
    || isset($_COOKIE['_FILES']) || isset($_COOKIE['_SESSION']) || isset($_COOKIE['GLOBALS'])) exit;

    // если попытались вызвать страницу с подменой предопределенных переменных, выйти
    if (isset($_FILES['_SERVER']) || isset($_FILES['_ENV']) || isset($_FILES['_COOKIE'])
    || isset($_FILES['_GET']) || isset($_FILES['_POST']) || isset($_FILES['_REQUEST'])
    || isset($_FILES['_FILES']) || isset($_FILES['_SESSION']) || isset($_FILES['GLOBALS'])) exit;

    // определяем начальные константы:
    //   ссылка на корень сайта из текущей папки,
    //   имя папки с файлами модулей,
    //   имя файла с константами
    define('ROOT_FOLDER_REFERENCE', '');
    define('FOLDERNAME_FOR_ENGINE_OBJECTS', 'objects');
    define('FILENAME_FOR_ENGINE_DEFINITION_OBJECT', 'Definition.php');

    // количество секунд в минуте и часе
    if (!defined('SECONDS_IN_MINUTE')) define('SECONDS_IN_MINUTE', 60);
    if (!defined('SECONDS_IN_HOUR')) define('SECONDS_IN_HOUR', 60 * SECONDS_IN_MINUTE);

    // подключаем инспектор распределенных атак "Отказ в обслуживании"
    $inspector = null;
    define('DDOS_INSPECTOR_SCRIPTNAME', 'AIMatrix_DDoS_inspector.php');
    if (file_exists(ROOT_FOLDER_REFERENCE . DDOS_INSPECTOR_SCRIPTNAME)) {

        // декларируем, что инспектор будет подчиненным объектом (не будет выводить форму верификации посетителя)
        define('DDOS_INSPECTOR_AS_SUBJECT', TRUE);

        // подключаем скрипт инспектора
        require_once(ROOT_FOLDER_REFERENCE . DDOS_INSPECTOR_SCRIPTNAME);

        // создаем объект инспектора (в параметрах указываем выделить 1Мбайт общей памяти под слежение за IP-адресами)
        $inspector = new DDoS_inspector(1);

        // если запуск инспектора не запрещен
        $params = isset($_SERVER['INSPECTOR_STATE']) ? trim($_SERVER['INSPECTOR_STATE']) : '';
        if ($params == '') $params = isset($_ENV['INSPECTOR_STATE']) ? trim($_ENV['INSPECTOR_STATE']) : '';
        if ($params == '') $params = function_exists('getenv') ? trim(getenv('INSPECTOR_STATE')) : '';
        if ($params == '') $params = function_exists('apache_getenv') ? trim(apache_getenv('INSPECTOR_STATE')) : '';
        if ($params != '') {

            $_SERVER['INSPECTOR_STATE'] = $params;
            if (strtolower($params) == 'on') {

                // если текущий IP-адрес не принадлежит поисковому роботу
                $params = isset($_SERVER['USER_NATURE']) ? trim($_SERVER['USER_NATURE']) : '';
                if ($params == '') $params = isset($_ENV['USER_NATURE']) ? trim($_ENV['USER_NATURE']) : '';
                if ($params == '') $params = function_exists('getenv') ? trim(getenv('USER_NATURE')) : '';
                if ($params == '') $params = function_exists('apache_getenv') ? trim(apache_getenv('USER_NATURE')) : '';
                if ($params == '' || strtolower($params) != 'spider') {

                    // запускаем инспектор для текущего IP-адреса
                    $inspector->start();

                    // если текущий IP-адрес заблокирован, выводим информационную страницу инспектора и завершаем работу
                    if ($inspector->blocked) {
                        echo $inspector->blocked_page;
                        exit;
                    }
                }
            }
        }
    }

    // загружаем файл констант
    require_once(dirname(__FILE__) . '/objects/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // проверяем требование редиректа
    $filename = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI']) : '';
    if ($filename != '') globalCheckRedirects($filename, $files_host_suffix);

    // если браузер сообщает, что может работать со сжатыми страницами
    if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {

        // включаем максимальное сжатие страниц (кроме защитного кода, robots.txt)
        // при передаче в браузер (это нужно делать до запуска сеанса)
        if (function_exists('zlib_get_coding_type')
        && (!isset($_GET['module']) || $_GET['module'] != 'Captcha' && $_GET['module'] != 'Robots')) {
            if (!ini_get('zlib.output_compression')) {
                @ ini_set('zlib.output_compression', 'On');
                @ ini_set('zlib.output_compression_level', 9);
            }

            $params = zlib_get_coding_type();
            if (is_string($params) && (trim($params) != '')) {
                @ header('Content-Encoding: ' . $params);
                @ header('Vary: Accept-Encoding');
            }
        }
    }

    // выставляем настройки сеанса:
    //   время жизни отправленных в браузер cookie определяет браузер
    //   данные в запущенном сеансе хранить не более получаса
    @ ini_set('session.cookie_lifetime', 0);
    @ ini_set('session.gc_maxlifetime', 30 * SECONDS_IN_MINUTE);

    // запускаем сеанс (если был загружен инспектор атак и его запуск не запрещен, сеанс запускаем
    // соответствующим методом инспектора для устранения атак на разрастание числа сеансовых файлов)
    if (isset($inspector) && isset($_SERVER['INSPECTOR_STATE']) && $_SERVER['INSPECTOR_STATE'] == 'on') {
        $inspector->start_session($inspector->ip);
    } else {
        session_start();
    }

    // если в корне сайта лежит файл о профилактических работах, выводим его и останавливаемся
    $filename = trim(str_replace('*', $files_host_suffix, UPDATING_WORKS_INFO_FILENAME));
    $filename = str_replace(':', '', $filename);
    $filename = str_replace('/', '', $filename);
    $filename = str_replace('\\', '', $filename);
    $filename = str_replace(' ', '', $filename);
    if (file_exists(ROOT_FOLDER_REFERENCE . $filename)) {
        readfile(ROOT_FOLDER_REFERENCE . $filename);
        exit;
    }

    // если сайт просматривает не админ и в корне сайта лежит файл о технических работах, выводим его и останавливаемся
    if (!isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) || $_SESSION[SESSION_PARAM_NAME_ADMIN] != 'admin') {
        $filename = trim(str_replace('*', $files_host_suffix, TECHNICAL_WORKS_INFO_FILENAME));
        $filename = str_replace(':', '', $filename);
        $filename = str_replace('/', '', $filename);
        $filename = str_replace('\\', '', $filename);
        $filename = str_replace(' ', '', $filename);
        if (file_exists(ROOT_FOLDER_REFERENCE . $filename)) {
            readfile(ROOT_FOLDER_REFERENCE . $filename);
            exit;
        }
    }

    // имя переменной сеанса для хранения защитных кодов пользователя
    define('USER_CAPTCHA_CODES', 'user_captcha_codes');

    // если это страница защитного кода
    if (isset($_GET['module']) && $_GET['module'] == 'Captcha') {

        // если доступен инспектор атак и есть данные о сайте, на котором расположен защитный код
        if (isset($inspector) && isset($_SERVER['HTTP_HOST'])) {
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['HTTP_HOST'];
            if (strpos('://', $referer) === FALSE) $referer = $_SERVER['HTTP_HOST'];

            // если защитный код расположен на странице этого же сайта (то есть
            // не даем выводить код бесцельно или с чужих страниц, так как всякий
            // его вывод связан с изменениями в сеансе именно этого сайта)
            $referer = str_replace('\\', '/', $referer);
            $referer = explode('://', $referer, 2);
            $referer = isset($referer[1]) ? trim($referer[1]) : '';
            $referer = explode('/', $referer, 2);
            $referer = isset($referer[0]) ? strtolower(trim($referer[0])) : '';
            $host = str_replace('\\', '/', $_SERVER['HTTP_HOST']);
            $host = explode('://', $host, 2);
            $host = isset($host[1]) ? trim($host[1]) : '';
            $host = explode('/', $host, 2);
            $host = isset($host[0]) ? strtolower(trim($host[0])) : '';
            if ($referer == $host) {

                // отдаем в браузер картинку защитного кода
                $params = new stdClass;
                $params->length = 5;                        // число символов в коде
                $params->any_chars = FALSE;                 // использовать только цифры (не подмешивать буквы A-Z)
                $params->any_register = FALSE;              // буквы только в верхнем регистре (опция актуальна лишь при подмешивании букв)
                $params->session_var = USER_CAPTCHA_CODES;  // имя переменной сеанса, хранящей сгенерированный код
                $params->session_var_array = TRUE;          // переменная сеанса хранит несколько кодов
                $inspector->show_captcha($params);
            }
        }
        exit;
    }

    // загружаем модуль страницы
    require_once(dirname(__FILE__) . '/objects/.def-models/ClientPage.php');

    // если зафиксирован приход по реферальной ссылке, запоминаем идентификатор партнера и с какой страницы пришли
    $affiliate_id = null;
    $affiliate_by_link = '';
    if (isset($_GET[REQUEST_PARAM_NAME_AFFILIATE]) && trim($_GET[REQUEST_PARAM_NAME_AFFILIATE]) != '') {
        $affiliate_id = trim($_GET[REQUEST_PARAM_NAME_AFFILIATE]);
        if (isset($_SERVER['HTTP_REFERER'])) $affiliate_by_link = trim($_SERVER['HTTP_REFERER']);
    } else {
        if (isset($_COOKIE[COOKIE_PARAM_NAME_AFFILIATE]) && trim($_COOKIE[COOKIE_PARAM_NAME_AFFILIATE]) != '') {
            $affiliate_id = trim($_COOKIE[COOKIE_PARAM_NAME_AFFILIATE]);
        }
    }
    if (function_exists('setcookie')) {
        if (!is_null($affiliate_id)) setcookie(COOKIE_PARAM_NAME_AFFILIATE,
                                               $affiliate_id,
                                               time() + 365 * 24 * SECONDS_IN_HOUR,
                                               '/');
    }

    // создаем объект страницы
    $page = new ClientPage();

        $page->memcache->checkAdminActions();
        $page->htmcache->checkAdminActions();

        // если страница выгодная и есть в кеше, выводим
        $page->db->open_tracing_method('HTMCACHE get');
            $html = FALSE;
            if (!$page->htmcache->isUnprofitablePage() && $page->htmcache->get($html) && is_string($html)) {
                $page->db->open_tracing_method('HTMCACHE echo');
                    echo $html;
                $page->db->close_tracing_method();
            } else {

                // визуализируем контент страницы
                $page->fetch();

                // выводим страницу в браузер
                $page->db->open_tracing_method('CLIENTPAGE fetch [echo]');
                    echo $page->body;

                    // если страница выгодная, кешируем
                    if (!$page->htmcache->isUnprofitablePage()) {
                        $page->db->open_tracing_method('HTMCACHE set');
                            $page->htmcache->set($page->body);
                        $page->db->close_tracing_method();
                    }
                $page->db->close_tracing_method();
            }
        $page->db->close_tracing_method();

        // TODO: переделать (должно быть ANY-моделью)
        //
        // если находимся не на странице импорта и не на странице файла robots.txt, обслуживаем варианты импорта по расписанию
        // $module = $page->request->getGetAsSentence('module');
        // if ($module != 'Import' && $module != 'Robots') {
        //     $page->db->open_tracing_method('CLIENTPAGE fetch [autoImport]');
        //         require_once(dirname(__FILE__) . '/objects/Admin.Imports.php');
        //         $import = new Imports($parent = null);
        //         $import->auto_import();
        //     $page->db->close_tracing_method();
        // }

        // отключаемся от базы данных
        $page->db->disconnect();

    // закрываем дерево трассировки методов
    $page->db->close_tracing_method();

    // показываем панель трассировки методов
    $page->db->tracing_methods_panel();
    exit;
?>