<?php
  // Impera CMS: инспектор распределенных атак "Отказ в обслуживании".
  // Copyright AIMatrix, 2013.
  // http://imperacms.ru

  // определяем константу "Тип использования инспектора" (по умолчанию как самостоятельный объект)
  if (!defined("DDOS_INSPECTOR_AS_SUBJECT")) define("DDOS_INSPECTOR_AS_SUBJECT", FALSE);

  // если инспектор не является подчиненным объектом
  if (!DDOS_INSPECTOR_AS_SUBJECT) {
    // полностью блокируем вывод сообщений об ошибках
    error_reporting(0);
  }

  // версия инспектора атак,
  // название инспектора атак
  define('DDOS_INSPECTOR_VERSION', '130319');
  define('DDOS_INSPECTOR_NAME', 'AIMatrix DDoS inspector');

  // длительность позитивной неактивности (в секундах),
  // длительность интервала слежения за активностью (в секундах),
  // опасное число запросов за секунду активности,
  // опасное число запросов в период верификации (это удвоенное реальное число, запрос формы верификации порождает запрос картинки защитного кода)
  define("DDOS_INACTIVE_GOODTIME", 15 * 60);
  define("DDOS_ACTIVITY_FRAMETIME", 3 * 60);
  define("DDOS_ACTIVITY_RISKCOUNT", 15);
  define("DDOS_VERIFY_RISKCOUNT", 10);

  // время действия блокировки по IP (в секундах),
  // время действия пропуска по IP (в секундах)
  define("DDOS_IP_LOCK_LIFETIME", 15 * 60);
  define("DDOS_IP_PASS_LIFETIME", 10 * 24 * 60 * 60);

  // имя файла защитного кода (файл виртуальный),
  // количество символов в защитном коде,
  // имя переменной сеанса для хранения значения защитного кода
  define("DDOS_VERIFY_CAPTCHA_FILE", "ddos_verify_captcha.jpg");
  define("DDOS_VERIFY_CAPTCHA_LENGTH", 4);
  define("DDOS_VERIFY_CAPTCHA_SESSION", "ddos_verify_captcha");

  // предельное число хранимых значений в многослойной переменной сеанса
  define("DDOS_SESSION_VAR_MAXSIZE", 32);

  // маркер отправки формы верификации
  define("DDOS_VERIFY_POST_MARKER", "ddos_verify_submit");

  // имена параметров формы верификации
  define("DDOS_VERIFY_POSTPARAM_URL", "ddos_verify_url");
  define("DDOS_VERIFY_POSTPARAM_CODE", "ddos_verify_code");

  // индексы полей данных
  define("DDOS_DATA_FIELD_FIRSTTIME", 0);
  define("DDOS_DATA_FIELD_LASTTIME", DDOS_DATA_FIELD_FIRSTTIME + 1);
  define("DDOS_DATA_FIELD_FIRSTCOUNT", DDOS_DATA_FIELD_LASTTIME + 1);
  define("DDOS_DATA_FIELD_LASTCOUNT", DDOS_DATA_FIELD_FIRSTCOUNT + 1);
  define("DDOS_DATA_FIELD_ATTEMPTS", DDOS_DATA_FIELD_LASTCOUNT + 1);

  // шаблоны регулярных выражений по умолчанию для доменов поисковых роботов (перечисляем через запятую)
  define("DDOS_SPIDER_DOMAIN_PATTERNS", "(.+\.)?aport\.ru,
                                         (.+\.)?googlebot\.com,
                                         (.+\.)?mail\.ru,
                                         (.+\.)?meta\.ua,
                                         (.+\.)?search\.msn\.com,
                                         (.+\.)?rambler\.ru,
                                         (.+\.)?rol\.ru,
                                         (.+\.)?crawl\.yahoo\.net,
                                         (.+\.)?yandex\.ru");

  // шаблоны регулярных выражений по умолчанию для единственно обслуживаемых хостов (перечисляем через запятую)
  // (используется когда нужно пропускать лишь определенные хосты, остальных блокировать)
  define("DDOS_SERVE_HOST_PATTERNS", "");

  // признак по умолчанию "скрипт работает на сервере с кодировкой UTF8"
  define("DDOS_INSPECTOR_SITE_UTF8_ENCODING", TRUE);

  // данные по умолчанию о SMTP-сервере (для информирования админа по емейлу)
  define("DDOS_INFORM_SERVER_ADDRESS", "smtp.rambler.ru");  // адрес почтового сервера
  define("DDOS_INFORM_SERVER_PORT", 587);                   // порт сервера
  define("DDOS_INFORM_SERVER_LOGIN", "");                   // логин от ящика; на бесплатных сервисах им, как правило, является емейл
  define("DDOS_INFORM_SERVER_PASSWORD", "");                // пароль от ящика
  define("DDOS_INFORM_SERVER_EMAIL", "");                   // почтовый адрес ящика (емейл)

  // признак по умолчанию "информировать ли администратора о наказанных",
  // признак по умолчанию "информировать ли администратора о новых верифицировавшихся",
  // признак по умолчанию "информировать ли администратора о поисковых роботах",
  // признак по умолчанию "информировать ли администратора о впервые зашедших"
  define("DDOS_INFORM_ABOUT_BADS", TRUE);
  define("DDOS_INFORM_ABOUT_CLIENTS", TRUE);
  define("DDOS_INFORM_ABOUT_SPIDERS", TRUE);
  define("DDOS_INFORM_ABOUT_FIRSTS", TRUE);

  // список по умолчанию емейлов администратора по наказанным (перечисляем через запятую),
  // список по умолчанию емейлов администратора по верифицировавшимся (перечисляем через запятую),
  // список по умолчанию емейлов администратора по поисковым роботам (перечисляем через запятую),
  // список по умолчанию емейлов администратора по впервые зашедшим (перечисляем через запятую)
  define("DDOS_INFORM_ADMIN_EMAILS_FOR_BADS", "");
  define("DDOS_INFORM_ADMIN_EMAILS_FOR_CLIENTS", "");
  define("DDOS_INFORM_ADMIN_EMAILS_FOR_SPIDERS", "");
  define("DDOS_INFORM_ADMIN_EMAILS_FOR_FIRSTS", "");

  // =========================================================================
  // Класс DDoS_inspector (инспектор распределенных атак "Отказ в обслуживании")
  //
  // Может работать как самостоятельный объект, верифицируя посетителя через
  // собственную форму, или как подчиненный объект, лишь регистрирующий визит
  // заданного IP-адреса. В последнем случае начальствующий скрипт должен
  // определить константу DDOS_INSPECTOR_AS_SUBJECT равную TRUE перед
  // подключением класса DDoS_inspector и последовательно использовать его
  // метод start() для каждого из необходимых IP.
  //
  // -------------------------------------------------------------------------
  //
  // Список общедоступных методов целевого назначения:
  //
  //   $object = new DDoS_inspector ($memsize = 1)
  //                 Конструктор.
  //
  //   $object->start($for_ip = "")
  //            Запуск инспектора атак. Пустой параметр $for_ip означает IP-адрес
  //            текущего посетителя, зафиксированного в момент создания объекта инспектора атак.
  //
  // -------------------------------------------------------------------------
  //
  // Список общедоступных методов, допустимых к нецелевому использованию:
  //
  //   $string = $object->change_extension ($filename, $new_extension)
  //                      Смена расширения имени файла.
  //
  //   $string = $object->server_host ()
  //                      Получение имени хоста сервера (сайта).
  //
  //   $string = $object->visitor_host ($ip = "", $named_only = FALSE)
  //                      Получение имени хоста посетителя. Поддерживаются запросы в DNS.
  //                      Пустой параметр $ip означает IP-адрес текущего посетителя,
  //                      зафиксированного в момент создания объекта инспектора атак.
  //
  //   $string = $object->show_captcha ($params = null)
  //                      Вывод в браузер картинки защитного кода. Значение кода сохраняется
  //                      в указанной в параметрах метода переменной сеанса и также передается
  //                      на выход метода.
  //
  //   $boolean = $object->smtp_mail ($server, $port, $login, $password, $from, $to, $subject, $body)
  //                       Отправка письма по SMTP. Значения $subject и $body должны быть
  //                       только в кодировке Windows-1251. Значение $to может быть как строкой емейла
  //                       получателя, так и массивом строк емейлов. На выход метода возвращается
  //                       булевой признак - выполнена или нет отправка.
  //
  //   $object->start_session ($sid = "")
  //            Запуск сеанса. Пустой параметр $sid означает оставить текущий идентификатор сеанса.
  //
  //   $object->put_in_session ($varname, $value, $stacked = FALSE)
  //            Передача значения в переменную сеанса. Поддерживаются многослойные (стековые)
  //            переменные, способные содержать в себе до DDOS_SESSION_VAR_MAXSIZE значений
  //            (актуально для защитных кодов).
  //
  //   $boolean = $object->cut_from_session ($varname, $value)
  //              Вырезание (удаление) значения из многослойной переменной сеанса с передачей
  //              на выход метода булевого признака - было или нет такое значение в переменной.
  //
  // =========================================================================

  class DDoS_inspector {

    // признак "Заблокирован ли текущий IP-адрес"
    public $blocked = FALSE;

    // содержимое HTM-страницы для заблокированного IP
    public $blocked_page = "";

    // список наблюдаемых в последнее время IP-адресов
    private $ips;

    // список новых IP-адресов поисковых роботов (в формате регулярных выражений)
    private $spider_ips = array();

    // список новых верифицировавшихся IP-адресов (в формате регулярных выражений)
    private $client_ips = array();

    // список новых прощаемых IP-адресов (в формате регулярных выражений)
    private $pardon_ips = array();

    // список новых наказываемых IP-адресов (в формате регулярных выражений),
    // список причин новых наказываемых IP-адресов
    private $strafe_ips = array();
    private $strafe_ips_info = array();

    // список новых игнорируемых IP-адресов
    private $ignore_ips = array();

    // список новых впервые зашедших IP-адресов (в обычном формате, не в форме регулярных выражений)
    private $first_ips = array();

    // текущее время
    private $time = 0;

    // текущий IP-адрес (полный, 4 его части, информация о его активности)
    public $ip = "0.0.0.0";
    public $ip1 = 0;
    public $ip2 = 0;
    public $ip3 = 0;
    public $ip4 = 0;
    private $ip_info = null;

    // шаблоны регулярных выражений для доменов поисковых роботов (перечисляем через запятую)
    public $spider_patterns = DDOS_SPIDER_DOMAIN_PATTERNS;

    // шаблоны регулярных выражений для единственно обслуживаемых хостов (перечисляем через запятую)
    public $serve_host_patterns = DDOS_SERVE_HOST_PATTERNS;

    // путь хранилища данных (для работы с общей памятью),
    // имя хранилища данных (для работы с общей памятью),
    // объем выделяемой общей памяти (в байтах)
    public $memory_path = __FILE__;
    public $memory_name = "A";
    private $memory_size = 1048576;

    // файл хранилища данных (для отсутствия работы с общей памятью)
    public $memory_file = "DDoS_inspector_memory.txt";

    // файл шрифта (для картинки защитного кода)
    public $font_file = "DDoS_inspector_font.ttf";

    // список емейлов администратора по наказанным (перечисляем через запятую),
    // список емейлов администратора по верифицировавшимся (перечисляем через запятую),
    // список емейлов администратора по поисковым роботам (перечисляем через запятую),
    // список емейлов администратора по впервые зашедшим (перечисляем через запятую)
    public $admin_emails_for_bads = DDOS_INFORM_ADMIN_EMAILS_FOR_BADS;
    public $admin_emails_for_clients = DDOS_INFORM_ADMIN_EMAILS_FOR_CLIENTS;
    public $admin_emails_for_spiders = DDOS_INFORM_ADMIN_EMAILS_FOR_SPIDERS;
    public $admin_emails_for_firsts = DDOS_INFORM_ADMIN_EMAILS_FOR_FIRSTS;

    // адрес почтового сервера,
    // порт сервера,
    // логин от ящика,
    // пароль от ящика,
    // почтовый адрес ящика (емейл)
    public $inform_server = DDOS_INFORM_SERVER_ADDRESS;
    public $inform_port = DDOS_INFORM_SERVER_PORT;
    public $inform_login = DDOS_INFORM_SERVER_LOGIN;
    public $inform_password = DDOS_INFORM_SERVER_PASSWORD;
    public $inform_email = DDOS_INFORM_SERVER_EMAIL;

    // признаки о чем информировать администратора
    public $inform_about_bads = DDOS_INFORM_ABOUT_BADS;
    public $inform_about_clients = DDOS_INFORM_ABOUT_CLIENTS;
    public $inform_about_spiders = DDOS_INFORM_ABOUT_SPIDERS;
    public $inform_about_firsts = DDOS_INFORM_ABOUT_FIRSTS;

    // признак "скрипт работает на сервере с кодировкой UTF8"
    public $utf8_site = DDOS_INSPECTOR_SITE_UTF8_ENCODING;

    // конструктор класса ====================================================

    public function DDoS_inspector ($memsize = 1) {

      // вычисляем размер выделенной общей памяти под наблюдаемые в последнее время IP-адреса
      if ($memsize < 0) $memsize = 0;
      if ($memsize > 16) $memsize = 16;
      $this->memory_size = intval(intval($memsize) * 1024 * 1024);

      // инициализируем свойства объекта
      $this->init();
      $this->memory_file = $this->change_extension(__FILE__, "txt");
      $this->font_file = $this->change_extension(__FILE__, "ttf");

      // готовим содержимое HTM-страницы для заблокированного IP
      $this->prepare_block_message();
    }

    // смена расширения имени файла ==========================================

    public function change_extension ($filename, $new_extension) {
      $filename = trim($filename);
      $new_extension = trim($new_extension);
      $item = pathinfo($filename);
      if (isset($item["extension"]) && ($item["extension"] != "")) {
        $filename = substr($filename, 0, -strlen($item["extension"])) . $new_extension;
      } else {
        if ($new_extension != "") $filename .= "." . $new_extension;
      }
      return $filename;
    }

    // инциализация свойств объекта ==========================================

    private function init ($for_ip = "") {

      // берем текущее время
      $this->time = time();

      // берем IP-адрес пользователя
      $this->ip = trim($for_ip);
      if ($this->ip == "") {
        $this->ip = isset($_SERVER["REMOTE_ADDR"]) ? trim($_SERVER["REMOTE_ADDR"]) : "";

        // если сервер сайта выступает в качестве прокси по отношению к оконечному веб серверу сайта
        // (например Apache после nginx)
        $server_ip = isset($_SERVER["SERVER_ADDR"]) ? trim($_SERVER["SERVER_ADDR"]) : "";
        if ($server_ip == $this->ip) {

          // берем ретранслированный IP-адрес (с точки зрения безопасности
          // нет абсолютного доверия к такому адресу, так как нет однозначного
          // подтверждения, что был ретранслирован прокси-сервером, а не подделан)
          $this->ip = "";
          if (($this->ip == "") && isset($_SERVER["HTTP_X_FORWARDED_FOR"])) $this->ip = trim($_SERVER["HTTP_X_FORWARDED_FOR"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_X_FORWARDED"])) $this->ip = trim($_SERVER["HTTP_X_FORWARDED"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_FORWARDED_FOR"])) $this->ip = trim($_SERVER["HTTP_FORWARDED_FOR"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_FORWARDED"])) $this->ip = trim($_SERVER["HTTP_FORWARDED"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_X_COMING_FROM"])) $this->ip = trim($_SERVER["HTTP_X_COMING_FROM"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_COMING_FROM"])) $this->ip = trim($_SERVER["HTTP_COMING_FROM"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_X_REAL_IP"])) $this->ip = trim($_SERVER["HTTP_X_REAL_IP"]);
          if (($this->ip == "") && isset($_SERVER["HTTP_CLIENT_IP"])) $this->ip = trim($_SERVER["HTTP_CLIENT_IP"]);
        }

        // если прокси не ретранслировал адрес, считаем равным адресу сервера
        if ($this->ip == "") $this->ip = $server_ip;
      }

      // раскладываем на части IP-адрес
      $this->ip = explode(".", $this->ip, 4);
      $this->ip1 = isset($this->ip[0]) ? abs(intval($this->ip[0])) % 256 : 0;
      $this->ip2 = isset($this->ip[1]) ? abs(intval($this->ip[1])) % 256 : 0;
      $this->ip3 = isset($this->ip[2]) ? abs(intval($this->ip[2])) % 256 : 0;
      $this->ip4 = isset($this->ip[3]) ? abs(intval($this->ip[3])) % 256 : 0;
      $this->ip = implode(".", $this->ip);

      // пока списка наблюдаемых IP-адресов нет,
      // пока новых IP-адресов поисковых роботов нет,
      // пока новых верифицировавшихся IP-адресов нет,
      // пока новых прощаемых IP-адресов нет,
      // пока новых наказываемых IP-адресов нет
      // пока причин новых наказываемых IP-адресов нет,
      // пока новых игнорируемых IP-адресов нет
      // пока новых впервые зашедших IP-адресов нет
      $this->ips = array();
      $this->spider_ips = array();
      $this->client_ips = array();
      $this->pardon_ips = array();
      $this->strafe_ips = array();
      $this->strafe_ips_info = array();
      $this->ignore_ips = array();
      $this->first_ips = array();

      // пока ставим признак "Текущий IP не заблокирован"
      $this->blocked = FALSE;
    }

    // получение имени хоста сервера (сайта) =================================

    public function server_host () {
      return isset($_SERVER["HTTP_HOST"]) ? trim($_SERVER["HTTP_HOST"]) : "";
    }

    // получение имени хоста посетителя ======================================

    public function visitor_host ($ip = "", $named_only = FALSE) {
      if ($ip == "") $ip = $this->ip;

      // возможно имя хоста уже было получено веб сервером
      $host = (($ip == $this->ip) && isset($_SERVER["REMOTE_HOST"])) ? trim($_SERVER["REMOTE_HOST"]) : "";
      if ($host == "") {

        // если можем использовать более быстрый способ
        if (function_exists("dns_get_record")) {
          $host = implode(".", array_reverse(explode(".", $ip))) . ".in-addr.arpa";
          $host = @ dns_get_record($host, DNS_PTR);
          $host = isset($host[0]["target"]) ? trim($host[0]["target"]) : $ip;

        // иначе придется использовать обычный способ
        } else {
          $host = @ gethostbyaddr($ip);
        }

        // для исключения задержек при возможном повторном вызове считаем, будто имя хоста уже получено веб сервером
        if ($ip == $this->ip) $_SERVER["REMOTE_HOST"] = $host;
      }

      // если просили вернуть строго имя хоста
      if ($named_only && ($host == $ip)) $host = "";
      return $host;
    }

    // проверка IP-адреса на принадлежность к поисковому роботу ==============

    private function check_spider () {
      $result = FALSE;

      // если поддерживаются сетевые функции
      if (function_exists("gethostbyaddr")) {

        // если такой IP в последнее время не встречался
        if (!isset($this->ips[$this->ip1][$this->ip2][$this->ip3][$this->ip4])) {

          // получаем имя подключившегося хоста
          $host = $this->visitor_host($this->ip, TRUE);

          // если имеется имя хоста, проверяем его по доменам поисковых роботов
          if ($host != "") {
            $items = explode(",", $this->spider_patterns);
            foreach ($items as &$item) {
              if (preg_match("'^" . $item . "$'i", $host)) {
                $result = TRUE;
                break;
              }
            }
          }
        }
      }

      // возвращаем результат ДА / НЕТ
      return $result;
    }

    // проверка IP-адреса на принадлежность к обслуживаемым хостам ===========

    private function check_serve_host () {
      $result = TRUE;

      // если заданы шаблоны единственно обслуживаемых хостов
      if ($this->serve_host_patterns != "") {
        $result = FALSE;

        // получаем имя подключившегося хоста
        $host = $this->visitor_host($this->ip, TRUE);
        if ($host != "") {

          // проверяем хост по обслуживаемым хостам
          $items = explode(",", $this->serve_host_patterns);
          foreach ($items as &$item) {
            if (preg_match("'^" . $item . "$'i", $host)) {
              $result = TRUE;
              break;
            }
          }
        }
      }

      // возвращаем результат ДА / НЕТ
      return $result;
    }

    // обработка списка IP-адресов ===========================================

    private function process_ips () {

      // если это визит поискового робота
      $serve = TRUE;
      $spider = $this->check_spider();
      if ($spider) {

        // этот IP-адрес поискового робота
        $this->spider_ips[] = $this->ip1 . "\." . $this->ip2 . "\." . $this->ip3 . "\." . $this->ip4;

        // просим робота вернуться через несколько секунд (чтобы не индексировалась форма верификации, пока пишется пропуск роботу)
        $pause = 5;
        header("HTTP/1.0 503 Service Unavailable");
        header("Status: 503 Service Unavailable");
        header("Retry-After: " . $pause);
        echo "<html>\r\n"
           . "  <head>\r\n"
           . "    <meta http-equiv=\"Refresh\" content=\"" . $pause . "\">\r\n"
           . "  </head>\r\n"
           . "  <body>\r\n"
           . "    Please try later.\r\n"
           . "  </body>\r\n"
           . "</html>\r\n";

      // иначе это визит не поискового робота
      } else {

        // если это визит необслуживаемого хоста, игнорируем его
        $serve = $this->check_serve_host();
        if (!$serve) {
          $this->ignore_ips[] = str_replace(".", "\.", $this->ip);
          $this->blocked = TRUE;
          // готовим содержимое HTM-страницы для игнорируемого IP
          $this->prepare_ignore_message();
          // если инспектор самостоятельный объект, выводим сообщение
          if (!DDOS_INSPECTOR_AS_SUBJECT) echo $this->blocked_page;

        // иначе это визит обслуживаемого хоста
        } else {

          // +1 попытка верификации, если инспектор самостоятельный объект
          $attempt = !DDOS_INSPECTOR_AS_SUBJECT ? 1 : 0;

          // начинаем регистрацию текущего IP-адреса
          if (!isset($this->ips[$this->ip1])) $this->ips[$this->ip1] = array();
          if (!isset($this->ips[$this->ip1][$this->ip2])) $this->ips[$this->ip1][$this->ip2] = array();
          if (!isset($this->ips[$this->ip1][$this->ip2][$this->ip3])) $this->ips[$this->ip1][$this->ip2][$this->ip3] = array();
          // если IP-адреса нет в списке наблюдаемых в последнее время
          if (!isset($this->ips[$this->ip1][$this->ip2][$this->ip3][$this->ip4])) {
            $this->ip_info = array(DDOS_DATA_FIELD_FIRSTTIME => $this->time - 1,
                                   DDOS_DATA_FIELD_LASTTIME => $this->time,
                                   DDOS_DATA_FIELD_FIRSTCOUNT => 0,
                                   DDOS_DATA_FIELD_LASTCOUNT => 1,
                                   DDOS_DATA_FIELD_ATTEMPTS => $attempt);
            $this->ips[$this->ip1][$this->ip2][$this->ip3][$this->ip4] = $this->ip_info;
            // если это впервые зашедший IP-адрес
            $params = isset($_SERVER["USER_NATURE"]) ? trim($_SERVER["USER_NATURE"]) : FALSE;
            if (($params === FALSE) || ($params == "")) $params = isset($_ENV["USER_NATURE"]) ? trim($_ENV["USER_NATURE"]) : FALSE;
            if (($params === FALSE) || ($params == "")) $params = function_exists("getenv") ? trim(getenv("USER_NATURE")) : FALSE;
            if (($params === FALSE) || ($params == "")) $params = function_exists("apache_getenv") ? trim(apache_getenv("USER_NATURE")) : FALSE;
            if (($params === FALSE) || ($params == "")) $this->first_ips[] = $this->ip;

          // иначе IP-адрес есть в списке наблюдаемых в последнее время
          } else {
            $a4 = &$this->ips[$this->ip1][$this->ip2][$this->ip3][$this->ip4];
            // вычисляем усредненную активность в секунду на прежнем интервале
            $interval = abs($a4[DDOS_DATA_FIELD_LASTTIME] - $a4[DDOS_DATA_FIELD_FIRSTTIME]);
            $difference = abs($a4[DDOS_DATA_FIELD_LASTCOUNT] - $a4[DDOS_DATA_FIELD_FIRSTCOUNT]);
            $mean = $difference / $interval;
            // вычисляем продвижение интервала
            $interval += abs($this->time - $a4[DDOS_DATA_FIELD_LASTTIME]);
            if ($interval > DDOS_ACTIVITY_FRAMETIME) {
              $difference = $interval - DDOS_ACTIVITY_FRAMETIME;
              $a4[DDOS_DATA_FIELD_FIRSTTIME] += $difference;
              $a4[DDOS_DATA_FIELD_FIRSTCOUNT] = intval($a4[DDOS_DATA_FIELD_FIRSTCOUNT] + $difference * $mean);
              if ($a4[DDOS_DATA_FIELD_FIRSTCOUNT] > $a4[DDOS_DATA_FIELD_LASTCOUNT]) $a4[DDOS_DATA_FIELD_FIRSTCOUNT] = $a4[DDOS_DATA_FIELD_LASTCOUNT];
              $interval = DDOS_ACTIVITY_FRAMETIME;
            }
            // вычисляем усредненную активность на текущем интервале
            $a4[DDOS_DATA_FIELD_ATTEMPTS] += $attempt;
            $a4[DDOS_DATA_FIELD_LASTCOUNT]++;
            $a4[DDOS_DATA_FIELD_LASTTIME] = $this->time;
            $difference = abs($a4[DDOS_DATA_FIELD_LASTCOUNT] - $a4[DDOS_DATA_FIELD_FIRSTCOUNT]);
            $mean = $difference / $interval;
            // если замечена чрезмерная активность, наказываем этот IP-адрес
            if (($mean > DDOS_ACTIVITY_RISKCOUNT) || ($a4[DDOS_DATA_FIELD_ATTEMPTS] > DDOS_VERIFY_RISKCOUNT)) {
              $this->strafe_ips[] = $this->ip1 . "\." . $this->ip2 . "\." . $this->ip3 . "\." . $this->ip4;
              // создаем описание причины наказания (маркер причины и описание)
              $reason_marker = "";
              $reason = "";
              if ($a4[DDOS_DATA_FIELD_ATTEMPTS] > DDOS_VERIFY_RISKCOUNT) {
                $reason_marker .= "[ошибается] ";
                $reason .= "Множество неверных вводов защитного кода или автоматические обращения к страницам сайта.\r\n";
              }
              if ($mean > DDOS_ACTIVITY_RISKCOUNT) {
                $reason_marker .= "[перегружает] ";
                $reason .= "Создание " . $difference . " запросов страниц на интервале времени " . $interval  . " секунд (около " . round($mean) . " запросов в секунду).";
              }
              $this->strafe_ips_info[$this->ip] = $reason_marker . $reason;
              $this->blocked = TRUE;
            }
            $this->ip_info = $a4;
          }

          // готовим содержимое HTM-страницы для заблокированного IP
          $this->prepare_block_message();
        }
      }

      // чистим список от длительно неактивных IP
      $backtime = $this->time - DDOS_INACTIVE_GOODTIME;
      foreach ($this->ips as $n1 => &$a1) {
        foreach ($a1 as $n2 => &$a2) {
          foreach ($a2 as $n3 => &$a3) {
            foreach ($a3 as $n4 => &$a4) {
              // если последнее время не проявлял активность, прощаем этот IP-адрес (если вдруг был заблокирован)
              if ($backtime > $a4[DDOS_DATA_FIELD_LASTTIME]) {
                unset($a3[$n4]);
                $this->pardon_ips[] = $n1 . "\." . $n2 . "\." . $n3 . "\." . $n4;
              }
            }
            if (empty($a3)) unset($a2[$n3]);
          }
          if (empty($a2)) unset($a1[$n2]);
        }
        if (empty($a1)) unset($this->ips[$n1]);
      }
      if (empty($this->ips)) $this->ips = array();

      // если это визит поискового робота или необслуживаемого хоста, выходим
      if ($spider || !$serve) return;

      // если инспектор самостоятельный объект, выводим форму верификации
      if (!DDOS_INSPECTOR_AS_SUBJECT) $this->show_form();
    }

    // обновление сведений в файле .htaccess =================================

    private function update_htaccess () {

      // открываем файл .htaccess
      $file = dirname(__FILE__);
      $file = (($file != ".") ? $file . "/" : "") . ".htaccess";
      if ($id = @fopen($file, "rb+")) {

        // запираем доступ к файлу
        @flock($id, LOCK_EX);

        // инициализируем переменные слежения
        $changed = FALSE;
        $ignore_added = FALSE;
        $bad_added = FALSE;
        $client_added = FALSE;
        $spider_added = FALSE;

        // инициализируем расчетные переменные
        $bad_backtime = $this->time - DDOS_IP_LOCK_LIFETIME;
        $client_backtime = $this->time - DDOS_IP_PASS_LIFETIME;

        // инициализируем списки для информирования админа
        $bad_inform = array();
        $client_inform = array();
        $spider_inform = array();
        $first_inform = array();

        // обрабатываем файл построчно
        $htaccess = array();
        while (!@feof($id)) {
          $line = @fgets($id, 65536);
          if ($line === FALSE) break;

          // если нашли точку добавления новых IP, добавляем правила для них
          if (preg_match("'^\s*#\s*ddos\s+inspector\s+(bad|client|spider)\s+ips\s+list\s+'is", $line, $matches)) {
            $htaccess[] = rtrim($line);
            switch (strtolower($matches[1])) {
              case "bad":
                if (!$ignore_added && !empty($this->ignore_ips)) {
                  foreach ($this->ignore_ips as &$ip) {
                    $bad_ip = str_replace("\.", ".", $ip);
                    $host = $this->visitor_host($bad_ip, TRUE);
                    $date = date("d.m.Y H:i:s", $this->time);
                    $htaccess[] = "SetEnvIf REMOTE_ADDR ^" . $ip . " USER_NATURE=ignore  # " . $this->time . " # " . $date . " # " . $host;
                  }
                  $ignore_added = TRUE;
                }
                if (!$bad_added && !empty($this->strafe_ips)) {
                  foreach ($this->strafe_ips as &$ip) {
                    if (!in_array($ip, $this->ignore_ips)) {
                      $bad_ip = str_replace("\.", ".", $ip);
                      $host = $this->visitor_host($bad_ip, TRUE);
                      $date = date("d.m.Y H:i:s", $this->time);
                      $htaccess[] = "SetEnvIf REMOTE_ADDR ^" . $ip . " USER_NATURE=bad  # " . $this->time . " # " . $date . " # " . $host;
                      $reason = isset($this->strafe_ips_info[$bad_ip]) ? trim($this->strafe_ips_info[$bad_ip]) : "";
                      $bad_inform[] = array($bad_ip, $date, $host, $reason);
                    }
                  }
                  $bad_added = TRUE;
                }
                break;
              case "client":
                if (!$client_added && !empty($this->client_ips)) {
                  foreach ($this->client_ips as &$ip) {
                    if (!in_array($ip, $this->ignore_ips)) {
                      $client_ip = str_replace("\.", ".", $ip);
                      $host = $this->visitor_host($client_ip, TRUE);
                      $date = date("d.m.Y H:i:s", $this->time);
                      $htaccess[] = "SetEnvIf REMOTE_ADDR ^" . $ip . " USER_NATURE=client  # " . $this->time . " # " . $date . " # " . $host;
                      $client_inform[] = array($client_ip, $date, $host);
                    }
                  }
                  $client_added = TRUE;
                }
                break;
              case "spider":
                if (!$spider_added && !empty($this->spider_ips)) {
                  foreach ($this->spider_ips as &$ip) {
                    $spider_ip = str_replace("\.", ".", $ip);
                    $host = $this->visitor_host($spider_ip, TRUE);
                    $date = date("d.m.Y H:i:s", $this->time);
                    $htaccess[] = "SetEnvIf REMOTE_ADDR ^" . $ip . " USER_NATURE=spider  # " . $host . " # " . $date;
                    $spider_inform[] = array($spider_ip, $date, $host);
                  }
                  $spider_added = TRUE;
                }
                break;
            }

          // иначе если нашли строку с правилом для IP, проверяем ее актуальность
          } elseif (preg_match("'^\s*setenvif(?:nocase)?\s+remote_addr\s+([\^]?([^\^\s\$]+)[\$]?)\s+user_nature\s*=\s*(ignore|bad|client|spider)\s+(?:#\s*(.+?)\s+)?$'is", $line, $matches)) {
            switch (strtolower($matches[3])) {
              case "ignore":
                // если это не дублирующаяся строка
                if (!in_array($matches[2], $this->ignore_ips)) {
                  $lasttime = isset($matches[4]) ? explode(" ", $matches[4], 2) : array();
                  $lasttime = isset($lasttime[0]) && !empty($lasttime[0]) ? intval($lasttime[0]) : $this->time;
                  // если время наказания не истекло, оставляем строку в файле
                  if ($lasttime >= $bad_backtime) {
                    $htaccess[] = rtrim($line);
                    // предотвращаем дубли
                    $this->ignore_ips[] = $matches[2];
                  } else {
                    $changed = TRUE;
                  }
                } else {
                  $changed = TRUE;
                }
                break;
              case "bad":
                // если это не дублирующаяся строка и IP не в списке игнорируемых и не в списке прощенных
                if (!in_array($matches[2], $this->strafe_ips) && !in_array($matches[2], $this->ignore_ips) && !in_array($matches[2], $this->pardon_ips)) {
                  $lasttime = isset($matches[4]) ? explode(" ", $matches[4], 2) : array();
                  $lasttime = isset($lasttime[0]) && !empty($lasttime[0]) ? intval($lasttime[0]) : $this->time;
                  // если время наказания не истекло, оставляем строку в файле
                  if ($lasttime >= $bad_backtime) {
                    $htaccess[] = rtrim($line);
                    // предотвращаем дубли
                    $this->strafe_ips[] = $matches[2];
                  } else {
                    $changed = TRUE;
                  }
                } else {
                  $changed = TRUE;
                }
                break;
              case "client":
                // если это не дублирующаяся строка и IP не в списке игнорируемых и не в списке наказанных
                if (!in_array($matches[2], $this->client_ips) && !in_array($matches[2], $this->ignore_ips) && !in_array($matches[2], $this->strafe_ips)) {
                  $lasttime = isset($matches[4]) ? explode(" ", $matches[4], 2) : array();
                  $lasttime = isset($lasttime[0]) && !empty($lasttime[0]) ? intval($lasttime[0]) : $this->time;
                  // если время доверия не истекло, оставляем строку в файле
                  if ($lasttime >= $client_backtime) {
                    $htaccess[] = rtrim($line);
                    // предотвращаем дубли
                    $this->client_ips[] = $matches[2];
                  } else {
                    $changed = TRUE;
                  }
                } else {
                  $changed = TRUE;
                }
                break;
              case "spider":
                // если это не дублирующаяся строка
                if (!in_array($matches[2], $this->spider_ips)) {
                  // оставляем строку в файле
                  $htaccess[] = rtrim($line);
                  // предотвращаем дубли
                  $this->spider_ips[] = $matches[2];
                } else {
                  $changed = TRUE;
                }
                break;
            }

          // иначе это иная строка файла, оставляем ее
          } else {
            $htaccess[] = rtrim($line);
          }
        }

        // если произошли изменения, передаем их в файл
        if ($changed || $bad_added || $client_added || $spider_added) {
          $htaccess = implode("\r\n", $htaccess) . "\r\n";
          @fseek($id, 0);
          $size = strlen($htaccess);
          @fwrite($id, $htaccess, $size);
          @ftruncate($id, $size);
        }

        // закрываем файл
        @fclose($id);

        // информируем администратора по емейлу
        if (!empty($this->first_ips)) {
          foreach ($this->first_ips as &$ip) {
            $host = $this->visitor_host($ip, TRUE);
            $date = date("d.m.Y H:i:s", $this->time);
            $first_inform[] = array($ip, $date, $host);
          }
        }
        $this->inform_admin($bad_inform, $client_inform, $spider_inform, $first_inform);
      }
    }

    // информирование администратора по емейлу ===============================

    private function inform_admin (&$bads, &$clients, &$spiders, &$firsts) {

      // если заполнены данные о SMTP-сервере
      if (($this->inform_server != "") && ($this->inform_port != "")
      && ($this->inform_login != "") && ($this->inform_password != "") && ($this->inform_email != "")) {

        // берем имя хоста сайта
        $site = $this->server_host();

        // получаем список емейлов администратора по наказанным
        $emails = explode(",", $this->admin_emails_for_bads);
        foreach ($emails as $i => &$email) {
          $email = strtolower(trim($email));
          if ($email == "") unset($emails[$i]);
        }

        // если разрешено информировать о наказанных и не пустой список емейлов администратора
        if ($this->inform_about_bads && !empty($emails)) {
          // просматриваем список наказанных
          foreach ($bads as &$item) {
            $ip = $item[0];
            $host = isset($item[2]) ? $item[2] : "";
            $reason = isset($item[3]) ? $item[3] : "";
            // отделяем маркер от описания причины наказания
            $reason_marker = "";
            while (($p = strpos($reason, "]")) !== FALSE) {
              $reason_marker .= substr($reason, 0, $p + 1) . " ";
              $reason = trim(substr($reason, $p + 1));
            }
            // формируем части сообщения
            $subject = "Блокировка " . $reason_marker . " на " . $site . (($host != "") ? " с хоста " . $host : "") . " (ip " . $ip . ")";
            $body = "<p style=\"font-family: Verdana, Tahoma, Arial; font-size: 10pt;\">"
                    . "На сайте <b>" . $site . "</b> заблокирован на " . intval(DDOS_IP_LOCK_LIFETIME / 60) . " минут следующий посетитель:\r\n\r\n"
                    . (($reason != "") ? "причина блокировки: " . $reason . "\r\n\r\n" : "")
                    . (($host != "") ? "его хост: <b>" . $host . "</b>\r\n\r\n" : "")
                    . "ip-адрес: <b>" . $ip . "</b>\r\n"
                    . "дата: " . $item[1] . "\r\n"
                  . "</p>";
            // если нужна кодировка в windows-1251
            if ($this->utf8_site && function_exists("iconv")) {
              $subject = iconv("UTF-8", "Windows-1251//IGNORE", $subject);
              $body = iconv("UTF-8", "Windows-1251//IGNORE", $body);
            }
            // отправляем письмо
            $this->smtp_mail($this->inform_server,
                             $this->inform_port,
                             $this->inform_login,
                             $this->inform_password,
                             $this->inform_email,
                             $emails,
                             $subject,
                             $body);
          }
        }

        // получаем список емейлов администратора по верифицировавшимся
        $emails = explode(",", $this->admin_emails_for_clients);
        foreach ($emails as $i => &$email) {
          $email = strtolower(trim($email));
          if ($email == "") unset($emails[$i]);
        }

        // если разрешено информировать о новых верифицированных посетителях и не пустой список емейлов администратора
        if ($this->inform_about_clients && !empty($emails)) {
          // просматриваем список верифицированных посетителей
          foreach ($clients as &$item) {
            $ip = $item[0];
            $host = isset($item[2]) ? $item[2] : "";
            $subject = "Новый верифицировавшийся посетитель на " . $site . (($host != "") ? " с хоста " . $host : "") . " (ip " . $ip . ")";
            $body = "<p style=\"font-family: Verdana, Tahoma, Arial; font-size: 10pt;\">"
                    . "На сайте <b>" . $site . "</b> зафиксирован визит нового (или давно не появлявшегося) посетителя:\r\n\r\n"
                    . (($host != "") ? "его хост: <b>" . $host . "</b>\r\n\r\n" : "")
                    . "ip-адрес: <b>" . $ip . "</b>\r\n"
                    . "дата: " . $item[1] . "\r\n"
                  . "</p>";
            // если нужна кодировка в windows-1251
            if ($this->utf8_site && function_exists("iconv")) {
              $subject = iconv("UTF-8", "Windows-1251//IGNORE", $subject);
              $body = iconv("UTF-8", "Windows-1251//IGNORE", $body);
            }
            // отправляем письмо
            $this->smtp_mail($this->inform_server,
                             $this->inform_port,
                             $this->inform_login,
                             $this->inform_password,
                             $this->inform_email,
                             $emails,
                             $subject,
                             $body);
          }
        }

        // получаем список емейлов администратора по поисковым роботам
        $emails = explode(",", $this->admin_emails_for_spiders);
        foreach ($emails as $i => &$email) {
          $email = strtolower(trim($email));
          if ($email == "") unset($emails[$i]);
        }

        // если разрешено информировать о поисковых роботах и не пустой список емейлов администратора
        if ($this->inform_about_spiders && !empty($emails)) {
          // просматриваем список поисковых роботов
          foreach ($spiders as &$item) {
            $ip = $item[0];
            $host = isset($item[2]) ? $item[2] : "";
            $subject = "Визит поисковика на " . $site . (($host != "") ? " с хоста " . $host : "") . " (ip " . $ip . ")";
            $body = "<p style=\"font-family: Verdana, Tahoma, Arial; font-size: 10pt;\">"
                    . "На сайте <b>" . $site . "</b> зафиксирован визит поискового робота:\r\n\r\n"
                    . (($host != "") ? "его хост: <b>" . $host . "</b>\r\n\r\n" : "")
                    . "ip-адрес: <b>" . $ip . "</b>\r\n"
                    . "дата: " . $item[1] . "\r\n"
                  . "</p>";
            // если нужна кодировка в windows-1251
            if ($this->utf8_site && function_exists("iconv")) {
              $subject = iconv("UTF-8", "Windows-1251//IGNORE", $subject);
              $body = iconv("UTF-8", "Windows-1251//IGNORE", $body);
            }
            // отправляем письмо
            $this->smtp_mail($this->inform_server,
                             $this->inform_port,
                             $this->inform_login,
                             $this->inform_password,
                             $this->inform_email,
                             $emails,
                             $subject,
                             $body);
          }
        }

        // получаем список емейлов администратора по впервые зашедшим
        $emails = explode(",", $this->admin_emails_for_firsts);
        foreach ($emails as $i => &$email) {
          $email = strtolower(trim($email));
          if ($email == "") unset($emails[$i]);
        }

        // если разрешено информировать о впервые зашедших и не пустой список емейлов администратора
        if ($this->inform_about_firsts && !empty($emails)) {
          // просматриваем список впервые зашедших
          foreach ($firsts as &$item) {
            $ip = $item[0];
            $host = isset($item[2]) ? $item[2] : "";
            $subject = "Начальный заход на " . $site . (($host != "") ? " с хоста " . $host : "") . " (ip " . $ip . ")";
            $body = "<p style=\"font-family: Verdana, Tahoma, Arial; font-size: 10pt;\">"
                    . "На сайте <b>" . $site . "</b> зафиксирован начальный заход еще не верифицированного посетителя:\r\n\r\n"
                    . (($host != "") ? "его хост: <b>" . $host . "</b>\r\n\r\n" : "")
                    . "ip-адрес: <b>" . $ip . "</b>\r\n"
                    . "дата: " . $item[1] . "\r\n"
                  . "</p>";
            // если нужна кодировка в windows-1251
            if ($this->utf8_site && function_exists("iconv")) {
              $subject = iconv("UTF-8", "Windows-1251//IGNORE", $subject);
              $body = iconv("UTF-8", "Windows-1251//IGNORE", $body);
            }
            // отправляем письмо
            $this->smtp_mail($this->inform_server,
                             $this->inform_port,
                             $this->inform_login,
                             $this->inform_password,
                             $this->inform_email,
                             $emails,
                             $subject,
                             $body);
          }
        }
      }
    }

    // запуск инспектора атак ================================================

    public function start ($for_ip = "") {

      // инциализируем свойства объекта
      $this->init($for_ip);

      // убираем из шаблонов единственно обслуживаемых хостов пустые элементы
      if ($this->serve_host_patterns != "") {
        $items = explode(",", $this->serve_host_patterns);
        foreach ($items as $index => &$item) {
          $item = trim($item);
          if ($item == "") unset($items[$index]);
        }
        $this->serve_host_patterns = implode(",", $items);
      }

      // убираем из шаблонов доменов поисковых роботов пустые элементы
      if ($this->spider_patterns != "") {
        $items = explode(",", $this->spider_patterns);
        foreach ($items as $index => &$item) {
          $item = trim($item);
          if ($item == "") unset($items[$index]);
        }
        $this->spider_patterns = implode(",", $items);
      }

      // выставляем признак "операция еще не выполнена"
      $success = FALSE;

      // если поддерживаются функции работы с общей памятью и пожелали ее использовать (было указано выделить место под нее)
      if (function_exists("ftok") && function_exists("sem_get") && function_exists("sem_acquire") && function_exists("sem_release")
      && function_exists("shm_attach") && function_exists("shm_get_var") && function_exists("shm_put_var") && ($this->memory_size != 0)) {

        // получаем ключ межпроцессной связи
        $id = ftok($this->memory_path, $this->memory_name);
        if ($id != -1) {

          // получаем однопроцессный семафор и запираем доступ к нему
          $sid = sem_get($id, 1);
          if ($sid) sem_acquire($sid);

          // открываем сегмент общей памяти
          $id = shm_attach($id, $this->memory_size, 0666);
          if ($id !== FALSE) {

            // извлекаем из общей памяти список IP (он хранится в переменной 1)
            $var_num = 1;
            $this->ips = shm_get_var($id, $var_num);
            if ($this->ips === FALSE) $this->ips = array();

            // обрабатываем список IP-адресов, регистрируя текущий визит
            $this->process_ips();

            // сохраняем обновленный список IP в общей памяти
            shm_put_var($id, $var_num, $this->ips);

            // выставляем признак "операция выполнена с применением общей памяти"
            $success = TRUE;
          }

          // отпираем доступ к семафору
          if ($sid) sem_release($sid);
        }
      }

      // если операция не выполнена (нет поддержки общей памяти или происходит ошибка), придется работать с файлом
      if (!$success) {

        // открываем файл (запоминаем признак $new_file для сборок PHP, не опознающих EOF в новом файле)
        if ($new_file = !($id = @fopen($this->memory_file, "rb+"))) $id = fopen($this->memory_file, "wb");
        if ($id) {

          // запираем доступ к файлу
          flock($id, LOCK_EX);

          // извлекаем из файла список IP
          $this->ips = "";
          if (!$new_file) while (!feof($id)) $this->ips .= fread($id, 65536);
          $this->ips = @unserialize($this->ips);
          if (!is_array($this->ips)) $this->ips = array();

          // обрабатываем список IP-адресов, регистрируя текущий визит
          $this->process_ips();

          // сохраняем обновленный список IP в файле
          $this->ips = serialize($this->ips);
          $size = strlen($this->ips);
          fseek($id, 0);
          fwrite($id, $this->ips, $size);
          ftruncate($id, $size);
          fclose($id);
        }
      }

      // очищаем ненужное свойство,
      // обновляем сведения в файле .htaccess
      $this->ips = array();
      $this->update_htaccess();

      // останавливаем инспектор
      $this->stop();
    }

    // остановка инспектора атак =============================================

    private function stop () {

      // очищаем ненужные свойства
      $this->ips = array();
      $this->spider_ips = array();
      $this->client_ips = array();
      $this->pardon_ips = array();
      $this->strafe_ips = array();
      $this->strafe_ips_info = array();
      $this->ignore_ips = array();
      $this->first_ips = array();
    }

    // вывод формы верификации ===============================================

    private function show_form () {

      // берем имя домена сайта
      $host = $this->server_host();

      // если получен постинг формы верификации
      if (isset($_POST[DDOS_VERIFY_POST_MARKER])) {

        // вспоминаем запрошенный url
        $url = isset($_POST[DDOS_VERIFY_POSTPARAM_URL]) ? trim($_POST[DDOS_VERIFY_POSTPARAM_URL]) : "/";

        // если введенный защитный код доставлен
        if (isset($_POST[DDOS_VERIFY_POSTPARAM_CODE])) {

          // запускаем сеанс (в качестве id сеанса берем IP посетителя)
          @$this->start_session($this->ip);

          // если код был в сеансе
          if ($this->cut_from_session(DDOS_VERIFY_CAPTCHA_SESSION, $_POST[DDOS_VERIFY_POSTPARAM_CODE])) {

            // этот IP-адрес верифицировался
            $this->client_ips[] = $this->ip1 . "\." . $this->ip2 . "\." . $this->ip3 . "\." . $this->ip4;

            // сбрасываем счетчик попыток обращения к форме верификации
            $this->ips[$this->ip1][$this->ip2][$this->ip3][$this->ip4][DDOS_DATA_FIELD_ATTEMPTS] = 0;

            // инициируем редирект посетителя на запрошенный url
            header("Location: http://" . $host . $url);
            return;

          // иначе защитный код неверный
          } else {
            $error = "Вы ввели неверный защитный код с картинки. Попробуйте еще раз.<br><br>Важно! Множество неверных попыток приведет к блокировке ваших действий.";
          }

        // иначе введеннный защитный код отсутствует
        } else {
          $error = "Вы не ввели защитный код с картинки. Попробуйте еще раз.<br><br>Важно! Множество неверных попыток приведет к блокировке ваших действий.";
        }

      // иначе это первоначальное открытие формы
      } else {

        // запоминаем с какого url было направление на верификацию
        $url = isset($_SERVER["REDIRECT_URL"]) ? trim($_SERVER["REDIRECT_URL"]) : "/";

        // если это направление с картинки внутри формы верификации
        if (substr($url, -strlen(DDOS_VERIFY_CAPTCHA_FILE)) == DDOS_VERIFY_CAPTCHA_FILE) {

          // отдаем в браузер картинку защитного кода
          $params = null;
          $params->length = DDOS_VERIFY_CAPTCHA_LENGTH;        // число символов в коде
          $params->any_chars = FALSE;                          // использовать только цифры (не подмешивать буквы A-Z)
          $params->any_register = FALSE;                       // буквы только в верхнем регистре (опция актуальна лишь при подмешивании букв)
          $params->session_var = DDOS_VERIFY_CAPTCHA_SESSION;  // имя переменной сеанса, хранящей сгенерированный код
          $params->session_var_array = FALSE;                  // переменная сеанса хранит только последний код (из одинаковых страниц принимаем данные лишь от последней)
          $params->session_id = $this->ip;                     // id сеанса ставим равным IP посетителя (для устранения атак на разрастание числа сеансовых файлов)
          $this->show_captcha($params);
          return;
        }
      }

      // выводим форму верификации
      if (intval((DDOS_VERIFY_RISKCOUNT - $this->ip_info[DDOS_DATA_FIELD_ATTEMPTS] + 1) / 2) > 0) {
        echo "<html>\r\n"
           . "  <head>\r\n"
           . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . ($this->utf8_site ? "UTF-8" : "Windows-1251") . "\">\r\n"
           . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
           . "    <title>Инспектор визитов на сайт " . $host . "</title>\r\n"
           . "  </head>\r\n"
           . "  <style>\r\n"
           . "    * {border: #C0C0C0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt; margin: 0px; padding: 0px; text-indent: 0px;}\r\n"
           . "    html, body, p, b, span {border: 0px solid; text-align: center;}\r\n"
           . "    span {font-size: 8pt;}\r\n"
           . "    img {height: 20px; vertical-align: top; width: 75px;}\r\n"
           . "    center {border: 0px solid;}\r\n"
           . "  </style>\r\n"
           . "  <body>\r\n"
           . "    <center>\r\n"
           . "      <form method=\"post\" style=\"background-color: #FFFFFF; margin: 75px 0px; padding: 0px; width: 350px;\" onsubmit=\"javascript: if (document.getElementById('" . DDOS_VERIFY_POSTPARAM_CODE . "').value != '') return true; alert('Вы не ввели защитный код с картинки!'); return false;\">\r\n"
           . "        <p style=\"background-color: #F0F0F0; margin: 4px 4px 0px 4px; padding: 15px;\">\r\n"
           . "          <b>Сайт " . $host . "</b><br><br>\r\n"
           . "          С вашего текущего интернет адреса еще (или давно) не было визитов на этот сайт.<br><br>\r\n"
           . "          Пожалуйста, подтвердите ниже, что вы зашли сюда не по ошибке.<br><br>\r\n"
           . "          <span style=\"color: #B0B0B0;\">Мера единоразовая, служит ограничению нецелевых визитов на сайт.</span><br><br>\r\n"
           . "          <span>\r\n"
           . "            код с картинки:\r\n"
           . "            <input id=\"" . DDOS_VERIFY_POSTPARAM_CODE . "\" maxlength=\"4\" name=\"" . DDOS_VERIFY_POSTPARAM_CODE . "\" size=\"4\" style=\"height: 22px;\" type=\"text\" value=\"\" title=\"Введите сюда код с расположенной правее картинки\"> &nbsp;\r\n"
           . "            <img border=\"0\" hspace=\"0\" src=\"" . DDOS_VERIFY_CAPTCHA_FILE . "\" vspace=\"0\">\r\n"
           . "          </span><br><br>\r\n"
           . "          <input name=\"" . DDOS_VERIFY_POSTPARAM_URL . "\" type=\"hidden\" value=\"" . htmlspecialchars($url, ENT_QUOTES) . "\">\r\n"
           . "          <input name=\"" . DDOS_VERIFY_POST_MARKER . "\" type=\"submit\" value=\"&nbsp;&nbsp;&nbsp;Я посетитель&nbsp;&nbsp;&nbsp;\" style=\"background-color: #E0E0E0; font-size: 8pt; font-weight: bold; height: 25px;\"><br><br>\r\n"
           . "          <span style=\"color: #B0B0B0;\">У вас есть попыток: " . intval((DDOS_VERIFY_RISKCOUNT - $this->ip_info[DDOS_DATA_FIELD_ATTEMPTS] + 1) / 2) . ".<br>Обновление или перезагрузка страницы приравнивается к попытке.</span>\r\n"
           . (isset($error) ? "          <br><br><span style=\"color: #FF0000;\">" . $error . "</span>\r\n" : "")
           . "        </p>\r\n"
           . "        <p style=\"background-color: #F0F0F0; color: #D0D0D0; font-size: 7pt; margin: 0px 4px 4px 4px; padding: 3px; text-align: right;\">\r\n"
           . "          " . DDOS_INSPECTOR_NAME . " v." . DDOS_INSPECTOR_VERSION . "\r\n"
           . "        </p>\r\n"
           . "      </form>\r\n"
           . "    </center>\r\n"
           . "  </body>\r\n"
           . "</html>\r\n";
      } else {

        // готовим содержимое HTM-страницы для заблокированного IP
        $this->prepare_block_message();
        // выводим сообщение
        echo $this->blocked_page;
      }
    }

    // подготовка сообщения "Ваш адрес не входит в обслуживаемые" ============

    private function prepare_ignore_message () {

      // создаем содержимое HTM-страницы для игнорируемого IP
      $host = $this->server_host();
      $this->blocked_page = "<html>\r\n"
                          . "  <head>\r\n"
                          . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . ($this->utf8_site ? "UTF-8" : "Windows-1251") . "\">\r\n"
                          . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
                          . "    <title>Инспектор визитов на сайт " . $host . "</title>\r\n"
                          . "  </head>\r\n"
                          . "  <style>\r\n"
                          . "    * {border: #E0C0C0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt; margin: 0px; padding: 0px; text-indent: 0px;}\r\n"
                          . "    html, body, p, b {border: 0px solid; text-align: center;}\r\n"
                          . "    center {border: 0px solid;}\r\n"
                          . "  </style>\r\n"
                          . "  <body>\r\n"
                          . "    <center>\r\n"
                          . "      <div style=\"background-color: #FFFFFF; margin: 75px 0px; padding: 0px; width: 350px;\">\r\n"
                          . "        <p style=\"background-color: #FFF0F0; margin: 4px 4px 0px 4px; padding: 15px;\">\r\n"
                          . "          <b>Сайт " . $host . "</b><br><br>\r\n"
                          . "          Сейчас на сайте включен режим пропуска лишь определенных адресов. Ваш текущий интернет адрес не принадлежит таким, поэтому был заблокирован как минимум на " . intval(DDOS_IP_LOCK_LIFETIME / 60) . " минут для исключения лишней нагрузки на сайт. Как только указанный режим будет отключен, Вы сможете свободно пройти на сайт.<br><br>\r\n"
                          . "        </p>\r\n"
                          . "        <p style=\"background-color: #FFF0F0; color: #E0D0D0; font-size: 7pt; margin: 0px 4px 4px 4px; padding: 3px; text-align: right;\">\r\n"
                          . "          " . DDOS_INSPECTOR_NAME . " v." . DDOS_INSPECTOR_VERSION . "\r\n"
                          . "        </p>\r\n"
                          . "      </div>\r\n"
                          . "    </center>\r\n"
                          . "  </body>\r\n"
                          . "</html>\r\n";
    }

    // подготовка сообщения "Ваш адрес заблокирован" =========================

    private function prepare_block_message () {

      // создаем содержимое HTM-страницы для заблокированного IP
      $host = $this->server_host();
      $this->blocked_page = "<html>\r\n"
                          . "  <head>\r\n"
                          . "    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=" . ($this->utf8_site ? "UTF-8" : "Windows-1251") . "\">\r\n"
                          . "    <meta http-equiv=\"Content-Language\" content=\"ru\">\r\n"
                          . "    <title>Инспектор визитов на сайт " . $host . "</title>\r\n"
                          . "  </head>\r\n"
                          . "  <style>\r\n"
                          . "    * {border: #E0C0C0 1px solid; color: #000000; font-family: Verdana, Tahoma, Arial; font-size: 10pt; margin: 0px; padding: 0px; text-indent: 0px;}\r\n"
                          . "    html, body, p, b {border: 0px solid; text-align: center;}\r\n"
                          . "    center {border: 0px solid;}\r\n"
                          . "  </style>\r\n"
                          . "  <body>\r\n"
                          . "    <center>\r\n"
                          . "      <div style=\"background-color: #FFFFFF; margin: 75px 0px; padding: 0px; width: 350px;\">\r\n"
                          . "        <p style=\"background-color: #FFF0F0; margin: 4px 4px 0px 4px; padding: 15px;\">\r\n"
                          . "          <b>Сайт " . $host . "</b><br><br>\r\n"
                          . "          Ваш текущий интернет адрес был заблокирован как минимум на " . intval(DDOS_IP_LOCK_LIFETIME / 60) . " минут за активность, значительно отличную от типичного поведения посетителей сайта.<br><br>\r\n"
                          . "        </p>\r\n"
                          . "        <p style=\"background-color: #FFF0F0; color: #E0D0D0; font-size: 7pt; margin: 0px 4px 4px 4px; padding: 3px; text-align: right;\">\r\n"
                          . "          " . DDOS_INSPECTOR_NAME . " v." . DDOS_INSPECTOR_VERSION . "\r\n"
                          . "        </p>\r\n"
                          . "      </div>\r\n"
                          . "    </center>\r\n"
                          . "  </body>\r\n"
                          . "</html>\r\n";
    }

    // вывод картинки защитного кода =========================================

    public function show_captcha ($params = null) {

      // так как отдаваемый контент этим методом не является текстовым (а картинкой),
      // перед всеми важными командами стоит @ для блокировки вывода сообщений об ошибках,
      // чтобы их вывод не вынудил браузер не отобразить картинку
      $result = "";

      // если поддерживаются функции работы с графикой
      if (function_exists("imagecreatetruecolor") && function_exists("imagecolorallocate")
      && function_exists("imagefilledrectangle") && function_exists("imagettftext")
      && function_exists("imagejpeg") && function_exists("imagedestroy")) {

        $length = isset($params->length) ? intval($params->length) : DDOS_VERIFY_CAPTCHA_LENGTH;
        if ($length < 1) $length = 1;

        // создаем изображение с белым фоном
        $width = 100;
        $height = 30;
        $id = @imagecreatetruecolor($width, $height);
        if ($id) {
          $color = @imagecolorallocate($id, 255, 255, 255);
          if ($color) @imagefilledrectangle($id, 0, 0, $width - 1, $height - 1, $color);

          // рисуем символы защитного кода
          $fontsize = intval(round($height * 0.7));
          $y = $height - intval(($height - $fontsize) / 2);
          $x = intval(round($width * 0.1));
          $charsize = intval(($width - $x * 2) / $length);
          $charlimit = isset($params->any_chars) && $params->any_chars ? 35 : 9;
          while ($length > 0) {
            $symbol = rand(0, $charlimit);
            if ($symbol > 9) $symbol = chr($symbol - 10  + (!isset($params->any_register) || !$params->any_register || rand(0, 1) ? 65 : 97));
            $result .= $symbol;
            $r = rand(0, 192);
            $g = rand(0, 192);
            $b = rand(0, 192);
            $rotation = rand(-22, 22);
            $color = @imagecolorallocate($id, $r, $g, $b);
            if ($color) @imagettftext($id, $fontsize + rand(-5, 5), $rotation, $x, $y + rand(-2, 2), $color, $this->font_file, $symbol);
            $x += $charsize;
            $length--;
          }

          // если указана хранящая переменная сеанса
          if (isset($params->session_var) && !empty($params->session_var)) {
            // запускаем сеанс
            @$this->start_session(isset($params->session_id) ? $params->session_id : "");
            // запоминаем код в сеансе
            @$this->put_in_session($params->session_var, $result, isset($params->session_var_array) && $params->session_var_array);
          }

          // отправляем изображение в браузер
          @header("Content-type: image/jpeg");
          @imagejpeg($id);
          @imagedestroy($id);
        }
      }

      // возвращаем защитный код в текстовом виде
      return $result;
    }

    // чтение ответа SMTP ====================================================

    private function smtp_answer (&$handle, $code) {

      // разрешаем не более 5 неудачных попыток чтения (пустых строк)
      $attempts = 5;

      // построчно читаем ответ сервера, если в начале строки найден искомый код[+пробел], возвращаем УСПЕШНО
      $size = strlen($code) + 1;
      while (($line = @fgets($handle, 65536)) !== FALSE) {
        $line = trim($line);
        if ($line == "") {
          $attempts--;
          if ($attempts == 0) break;
        } elseif (trim(substr($line, 0, $size)) == $code) return TRUE;
      }

      // иначе возвращаем НЕУДАЧА (сервер возвратил другой код или недоступен ответ)
      return FALSE;
    }

    // отправка письма по SMTP ===============================================

    public function smtp_mail ($server, $port, $login, $password, $from, $to, $subject, $body) {

      // ставим таймаут не более секунды (снимаем тормоза при недоступности сервера)
      $timeout = 1;

      // начинаем отправку
      $result = FALSE;
      if ($handle = @fsockopen($server, $port, $en, $es, $timeout)) {
        if ($this->smtp_answer($handle, "220")) {

          // приветствуем
          @fputs($handle, "HELO " . $server . "\r\n");
          if ($this->smtp_answer($handle, "250")) {

            // авторизуемся
            @fputs($handle, "AUTH LOGIN\r\n");
            if ($this->smtp_answer($handle, "334")) {
              @fputs($handle, base64_encode($login) . "\r\n");
              if ($this->smtp_answer($handle, "334")) {
                @fputs($handle, base64_encode($password) . "\r\n");
                if ($this->smtp_answer($handle, "235")) {

                  // от кого шлем
                  @fputs($handle, "MAIL FROM: <" . $from . ">\r\n");
                  if ($this->smtp_answer($handle, "250")) {

                    // кому шлем
                    if (!is_array($to)) $to = array($to);
                    $success = FALSE;
                    foreach ($to as &$email) {
                      @fputs($handle, "RCPT TO: <" . $email . ">\r\n");
                      $success = $this->smtp_answer($handle, "250");
                      if (!$success) break;
                    }
                    if ($success) {

                      // что шлем
                      @fputs($handle, "DATA\r\n");
                      if ($this->smtp_answer($handle, "354")) {
                        $body = "Date: " . date("D, d M Y H:i:s") . " UT\r\n"
                              . "Subject: =?Windows-1251?B?" . base64_encode($subject) . "=?=\r\n"
                              . "Return-Path: <" . $from . ">\r\n"
                              . "Reply-To: <" . $from . ">\r\n"
                              . "MIME-Version: 1.0\r\n"
                              . "From: <" . $from . ">\r\n"
                              . "To: <" . implode(">, <", $to) . ">\r\n"
                              . "X-Priority: 3\r\n"
                              . "Content-Transfer-Encoding: 8bit\r\n"
                              . "Content-Type: text/html; charset=\"Windows-1251\"\r\n\r\n"
                              . str_replace("\r\n", " <br>\r\n", trim($body)) . "\r\n";
                        @fputs($handle, $body . "\r\n.\r\n");
                        $result = $this->smtp_answer($handle, "250");
                      }
                    }
                  }
                }
              }
            }

            // прощаемся
            @fputs($handle, "QUIT\r\n");
          }
        }

        // закрываем связь с сервером
        @fclose($handle);
      }

      // возвращаем СДЕЛАНО / НЕТ
      return $result;
    }

    // запуск сеанса =========================================================

    public function start_session ($sid = "") {
      $sid = preg_replace("'[^a-z0-9]'i", "", $sid);
      if ($sid != "") session_id($sid);
      session_start();
    }

    // передача значения в переменную сеанса =================================

    public function put_in_session ($varname, $value, $stacked = FALSE) {

      // если переменную сеанса приказано считать многослойной, то есть в ней позволено хранить несколько значений
      if ($stacked && isset($_SESSION[$varname])) {
        $values = explode(",", trim($_SESSION[$varname]));
        foreach ($values as $i => &$v) {
          $v = trim($v);
          if (($v == "") || ($v == $value)) unset($values[$i]);
        }

        // если история значений заполнена, выбрасываем самое старое значение многослойной переменной
        if (count($values) >= DDOS_SESSION_VAR_MAXSIZE) array_shift($values);
        $values[] = $value;

        // запоминаем значения в сеансе
        $_SESSION[$varname] = implode(",", $values);

      // иначе пока это однослойная переменная, запоминаем значение в сеансе
      } else {
        $_SESSION[$varname] = $value;
      }
    }

    // вырезание значения из многослойной переменной сеанса ==================

    public function cut_from_session ($varname, $value) {
      $result = FALSE;

      // если такая переменная сеанса есть
      if (isset($_SESSION[$varname]) && ($value != "")) {
        $values = explode(",", trim($_SESSION[$varname]));
        foreach ($values as $i => &$v) {
          $v = trim($v);
          if ($v == $value) {
            unset($values[$i]);
            $result = TRUE;
          }
        }

        // запоминаем оставшиеся значения в сеансе
        if ($result) $_SESSION[$varname] = implode(",", $values);
      }

      // возвращаем БЫЛО / НЕТ
      return $result;
    }
  }

  // =========================================================================
  // Внеклассовая часть программного кода
  // =========================================================================

  // если инспектор отключен легально, выйти
  $params = isset($_SERVER["INSPECTOR_STATE"]) ? trim($_SERVER["INSPECTOR_STATE"]) : FALSE;
  if (($params === FALSE) || ($params == "")) $params = isset($_ENV["INSPECTOR_STATE"]) ? trim($_ENV["INSPECTOR_STATE"]) : FALSE;
  if (($params === FALSE) || ($params == "")) $params = function_exists("getenv") ? trim(getenv("INSPECTOR_STATE")) : FALSE;
  if (($params === FALSE) || ($params == "")) $params = function_exists("apache_getenv") ? trim(apache_getenv("INSPECTOR_STATE")) : FALSE;
  if (($params !== FALSE) && ($params != "")) $_SERVER["INSPECTOR_STATE"] = $params;
  if ((($params === FALSE) || ($params == "") || (strtolower($params) != "on"))
  && !isset($_GET["_SERVER"]) && !isset($_GET["_ENV"]) && !isset($_GET["_COOKIE"])
  && !isset($_GET["_GET"]) && !isset($_GET["_POST"]) && !isset($_GET["_REQUEST"])
  && !isset($_GET["_FILES"]) && !isset($_GET["_SESSION"]) && !isset($_GET["GLOBALS"])
  && !isset($_POST["_SERVER"]) && !isset($_POST["_ENV"]) && !isset($_POST["_COOKIE"])
  && !isset($_POST["_GET"]) && !isset($_POST["_POST"]) && !isset($_POST["_REQUEST"])
  && !isset($_POST["_FILES"]) && !isset($_POST["_SESSION"]) && !isset($_POST["GLOBALS"])
  && !isset($_COOKIE["_SERVER"]) && !isset($_COOKIE["_ENV"]) && !isset($_COOKIE["_COOKIE"])
  && !isset($_COOKIE["_GET"]) && !isset($_COOKIE["_POST"]) && !isset($_COOKIE["_REQUEST"])
  && !isset($_COOKIE["_FILES"]) && !isset($_COOKIE["_SESSION"]) && !isset($_COOKIE["GLOBALS"])
  && !isset($_FILES["_SERVER"]) && !isset($_FILES["_ENV"]) && !isset($_FILES["_COOKIE"])
  && !isset($_FILES["_GET"]) && !isset($_FILES["_POST"]) && !isset($_FILES["_REQUEST"])
  && !isset($_FILES["_FILES"]) && !isset($_FILES["_SESSION"]) && !isset($_FILES["GLOBALS"])) return;

  // если инспектор самостоятельный объект, запускаем его
  if (!DDOS_INSPECTOR_AS_SUBJECT) {
    $ddos = new DDoS_inspector();
    $ddos->start();
  }

  // выходим из модуля
  return;
?>
