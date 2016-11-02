<?php
    // =======================================================================
    /**
    *  Стартовая точка админпанели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================



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



    // уведомляем браузер о кодировке документа
    header('Content-Type: text/html; charset=UTF-8');



    // определяем начальные константы:
    //   ссылка на корень сайта из текущей папки,
    //   имя папки с файлами модулей,
    //   имя файла с константами
    define('ROOT_FOLDER_REFERENCE', '../');
    define('FOLDERNAME_FOR_ENGINE_OBJECTS', 'objects');
    define('FILENAME_FOR_ENGINE_DEFINITION_OBJECT', 'Definition.php');



    // количество секунд в минуте и часе
    if (!defined('SECONDS_IN_MINUTE')) define('SECONDS_IN_MINUTE', 60);
    if (!defined('SECONDS_IN_HOUR')) define('SECONDS_IN_HOUR', 60 * SECONDS_IN_MINUTE);



    // включаем информирование о любой ошибке (в админпанели лучше увидим баг сразу, чтобы принять меры)
    error_reporting(E_ALL & ~E_STRICT);



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
                // здесь пока ничего не делаем
            }
        }
    }



    // если браузер сообщает, что может работать со сжатыми страницами
    if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {

        // включаем максимальное сжатие страниц при передаче в браузер (это нужно делать до запуска сеанса)
        if (function_exists('zlib_get_coding_type')) {
            if (!ini_get('zlib.output_compression')) {
                @ ini_set('zlib.output_compression', 'On');
                @ ini_set('zlib.output_compression_level', 9);
            }

            $params = zlib_get_coding_type();
            if (is_string($params) && (trim($params) != '')) {
                header('Content-Encoding: ' . $params);
                header('Vary: Accept-Encoding');
            }
        }
    }



    // выставляем настройки сеанса:
    //   время жизни отправленных в браузер cookie определяет браузер
    //   данные в запущенном сеансе хранить не более 2 часов
    @ ini_set('session.cookie_lifetime', 0);
    @ ini_set('session.gc_maxlifetime', 2 * SECONDS_IN_HOUR);



    // запускаем сеанс,
    session_start();



    // загружаем файл констант
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);



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



    // загружаем модуль страницы админпанели
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT);



    // если в сеансе остался приказ Logout (выход из админпанели)
    if (isset($_SESSION['logout']) && $_SESSION['logout']) {



        // извлекаем зону авторизации
        $params = @ file_get_contents('.htaccess');
        if ($params === FALSE) $params = '';
        $realm = preg_replace('/^.*?authname[\s\t\r\n]+"([^"]+)".*$/is', '\\1', $params);
        if ($realm == $params) $realm = 'Impera CMS admin panel';



        // отправляем заголовки на запрос авторизации  
        header('WWW-Authenticate: Basic realm="' . $realm . '"');
        header('HTTP/1.0 401 Unauthorised');
        unset($_SESSION['logout']);



        // если откажется от ввода, перебрасываем на клиентскую сторону
        $params = isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI']) : '';
        $params = explode('#', $params);
        $params = isset($params[0]) ? trim($params[0]) : '';
        $params = explode('?', $params);
        $params = isset($params[0]) ? trim($params[0]) : '';
        $params = str_replace('\\', '/', $params);
        $params = rtrim($params, '/. ');
        if ($params != '') $params .= '/';
        $params = (isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : '') . $params;
        $params .= ROOT_FOLDER_REFERENCE;
        echo '<html>'
               . '<head>'
                   . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
                   . '<meta http-equiv="Content-Language" content="ru" />'
                   . '<title>Выход из админпанели</title>'
               . '</head>'
               . '<body>'
                   . 'Перенаправление на клиентскую сторону магазина...'
                   . '<script language="JavaScript" type="text/javascript">'
                       . 'window.location.replace(\'' . $params . '\');'
                   . '</script>'
               . '</body>'
           . '</html>';
        exit;
    }



    // если если сервер почему-то не сообщает параметры авторизовавшегося администратора
    if ((!isset($_SERVER['PHP_AUTH_USER']) || (trim($_SERVER['PHP_AUTH_USER']) == ''))
    && (!isset($_SERVER['REMOTE_USER']) || (trim($_SERVER['REMOTE_USER']) == ''))
    && (!isset($_SERVER['REDIRECT_REMOTE_USER']) || (trim($_SERVER['REDIRECT_REMOTE_USER']) == ''))) {
        echo '<html>'
               . '<head>'
                   . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
                   . '<meta http-equiv="Content-Language" content="ru" />'
                   . '<title>Неудовлетворительная настройка веб сервера</title>'
               . '</head>'
               . '<body>'
                   . 'Обслуживание страницы прервано по соображениям безопасности.<br /><br />'
                   . 'Обратитесь в службу технической поддержки хостинга за уточнением,<br />'
                   . 'почему веб сервер сконфигурирован так, что для URL (адреса страницы)<br />'
                   . 'такого же вида, как адрес текущей страницы, допускает исполнение<br />'
                   . 'скрипта в защищенной области, прежде чем администратор пройдет авторизацию.<br /><br />'
                   . 'Если же администратор действительно был авторизован к этому моменту,<br />'
                   . 'почему сервер для такого URL не сообщает скрипту логин авторизовавшегося.'
               . '</body>'
           . '</html>';
        exit;
    }



    // если во входном параметре ACTION есть приказ Logout (выход из админпанели)
    // или Relogin (войти заново), тогда перенаправить на корень сайта (или админпанели
    // в случае Relogin) и оставить приказ Logout в сеансе (чтобы избежать
    // несанкционированного доступа в админпанель откатом по истории страниц)
    if (isset($_REQUEST[REQUEST_PARAM_NAME_USER_ACTION])
    && (($_REQUEST[REQUEST_PARAM_NAME_USER_ACTION] == USERACTION_REQUEST_PARAM_VALUE_LOGOUT)
    || ($_REQUEST[REQUEST_PARAM_NAME_USER_ACTION] == USERACTION_REQUEST_PARAM_VALUE_RELOGIN))) {
        if ($_REQUEST[REQUEST_PARAM_NAME_USER_ACTION] == USERACTION_REQUEST_PARAM_VALUE_LOGOUT) {
            header('Location: ' . ROOT_FOLDER_REFERENCE);
        } else {
            header('Location: ./');
        }
        $_SESSION['logout'] = TRUE;
        unset($_SESSION[SESSION_PARAM_NAME_ADMIN]);
        exit;
    }



    // отправляем заголовки на отключение кеширования админпанели в браузере
    @header('Cache-Control: no-cache, must-revalidate');
    @header('Pragma: no-cache');



    // запоминаем в сеансе признак администратора
    $_SESSION[SESSION_PARAM_NAME_ADMIN] = 'admin';



    // создаем страницу админпанели и выводим в браузер
    $impera = new AdminPage();
    $impera->fetch();
    echo $impera->body;



    // отключаемся от базы данных
    $impera->db->disconnect();



    // закрываем дерево трассировки методов
    $impera->db->close_tracing_method();

    // показываем панель трассировки методов
    $impera->db->tracing_methods_panel();



    exit;
?>