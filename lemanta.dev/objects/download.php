<?php
    // Impera CMS: модуль загрузки продаваемых файлов.
    // Copyright AIMatrix, 2011.
    // http://aimatrix.itak.info

    // выключаем информирование о любой ошибке (клиенту не нужно видеть технические подробности возможных ошибок), если запущено не на локальном компьютере
    if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] == 'localhost')) {
        error_reporting(E_ALL & ~E_STRICT);
    } else {
        error_reporting(0);
    }

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_GET["_SERVER"]) || isset($_GET["_ENV"]) || isset($_GET["_COOKIE"])
  || isset($_GET["_GET"]) || isset($_GET["_POST"]) || isset($_GET["_REQUEST"])
  || isset($_GET["_FILES"]) || isset($_GET["_SESSION"]) || isset($_GET["GLOBALS"])) exit;

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_POST["_SERVER"]) || isset($_POST["_ENV"]) || isset($_POST["_COOKIE"])
  || isset($_POST["_GET"]) || isset($_POST["_POST"]) || isset($_POST["_REQUEST"])
  || isset($_POST["_FILES"]) || isset($_POST["_SESSION"]) || isset($_POST["GLOBALS"])) exit;

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_COOKIE["_SERVER"]) || isset($_COOKIE["_ENV"]) || isset($_COOKIE["_COOKIE"])
  || isset($_COOKIE["_GET"]) || isset($_COOKIE["_POST"]) || isset($_COOKIE["_REQUEST"])
  || isset($_COOKIE["_FILES"]) || isset($_COOKIE["_SESSION"]) || isset($_COOKIE["GLOBALS"])) exit;

  // если попытались вызвать страницу с подменой предопределенных переменных, выйти
  if (isset($_FILES["_SERVER"]) || isset($_FILES["_ENV"]) || isset($_FILES["_COOKIE"])
  || isset($_FILES["_GET"]) || isset($_FILES["_POST"]) || isset($_FILES["_REQUEST"])
  || isset($_FILES["_FILES"]) || isset($_FILES["_SESSION"]) || isset($_FILES["GLOBALS"])) exit;

  // определяем начальные константы:
  //   ссылка на корень сайта из текущей папки,
  //   имя папки с файлами модулей,
  //   имя файла с константами
  if (!defined("ROOT_FOLDER_REFERENCE")) define("ROOT_FOLDER_REFERENCE", "../");
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) define("FOLDERNAME_FOR_ENGINE_OBJECTS", "objects");
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) define("FILENAME_FOR_ENGINE_DEFINITION_OBJECT", "Definition.php");

  // загружаем файл констант
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

  // если в корне сайта лежит файл о профилактических работах, выводим его и останавливаемся
  $filename = trim(str_replace("*", $files_host_suffix, UPDATING_WORKS_INFO_FILENAME));
  $filename = str_replace(":", "", $filename);
  $filename = str_replace("/", "", $filename);
  $filename = str_replace("\\", "", $filename);
  $filename = str_replace(" ", "", $filename);
  if (file_exists(ROOT_FOLDER_REFERENCE . $filename)) {
    readfile(ROOT_FOLDER_REFERENCE . $filename);
    exit;
  }

  // если сайт просматривает не админ и в корне сайта лежит файл о технических работах, выводим его и останавливаемся
  if (!isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) || ($_SESSION[SESSION_PARAM_NAME_ADMIN] != "admin")) {
    $filename = trim(str_replace("*", $files_host_suffix, TECHNICAL_WORKS_INFO_FILENAME));
    $filename = str_replace(":", "", $filename);
    $filename = str_replace("/", "", $filename);
    $filename = str_replace("\\", "", $filename);
    $filename = str_replace(" ", "", $filename);
    if (file_exists(ROOT_FOLDER_REFERENCE . $filename)) {
      readfile(ROOT_FOLDER_REFERENCE . $filename);
      exit;
    }
  }

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ORDER_OBJECT);

  // =========================================================================
  // Класс Download (модуль загрузки продаваемых файлов)
  // =========================================================================

  class Download extends Basic {

    // срок жизни ссылок на файлы
    private $expire_days = DOWNLOAD_LINKS_LIFETIME;

    // обработка входных параметров ==========================================

    public function process () {

      // если в параметрах запроса есть данные о заказе и скачиваемом файле
      if (isset($_GET['order_code'])) {
        $order_code = trim($_GET['order_code']);
        if (isset($_GET['file'])) {
          $file = $this->hdd->safeFilename($_GET['file']);

          // ищем такой файл
          $filename = $this->settings->products_files_folder_prefix . "files/downloads/" . $file;
          $result = file_exists(ROOT_FOLDER_REFERENCE . $filename);
          if ($result) {
            $filename = ROOT_FOLDER_REFERENCE . $filename;
          } else {
            $result = file_exists($filename);
          }

          // если файл найден, проверяем его продажу и актуальность ссылки
          if ($result) {
            $query = "SELECT COUNT(*) AS count "
                   . "FROM " . DATABASE_ORDERS_TABLENAME . ", "
                        . DATABASE_PRODUCTS_TABLENAME . ", "
                        . "orders_products "
                   . "WHERE " . DATABASE_ORDERS_TABLENAME . ".code = '" . $this->db->query_value($order_code) . "' "
                         . "AND " . DATABASE_PRODUCTS_TABLENAME . ".download = '" . $this->db->query_value($file) . "' "
                         . "AND " . DATABASE_ORDERS_TABLENAME . ".payment_status = 1 "
                         . "AND " . DATABASE_ORDERS_TABLENAME . ".order_id = orders_products.order_id "
                         . "AND " . DATABASE_PRODUCTS_TABLENAME . ".product_id = orders_products.product_id "
                         . "AND DATEDIFF(now(), " . DATABASE_ORDERS_TABLENAME . ".payment_date) < " . @intval($this->expire_days) . ";";
            $this->db->query($query);
            $result = $this->db->result();

            // если проверка пройдена, даем скачать файл
            if ($result->count > 0) {
              header("Content-Type: application/force-download");
              header("Content-Type: application/octet-stream");
              header("Content-Type: application/download");
              header("Content-Description: File Transfer");
              header("Content-Length: " . @filesize($filename) . ";");
              header("Content-Disposition: attachment; filename=\"" . $file . "\"");
              @readfile($filename);
              exit;
            }
          }
        }
      }

      // иначе в параметрах запроса нет данных о заказе и скачиваемом файле
      header("HTTP/1.0 404 Not found");
      exit;
    }
  }



    // =========================================================================
    // Внеклассовая часть программного кода
    // =========================================================================

    $download = new Download();
    @ $download->process();
    exit;
?>