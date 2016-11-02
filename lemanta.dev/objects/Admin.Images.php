<?php
  // Impera CMS: админ модуль картинок дизайна,
  //             админ модуль баннеров,
  //             админ модуль шаблонов дизайна.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ADMIN_PANEL . "/pclzip/pclzip.lib.php");

  // какой файл является шаблоном модуля картинок дизайна,
  // какой файл является шаблоном модуля баннеров,
  // какой файл является шаблоном модуля шаблонов дизайна
  define("ADMIN_IMAGES_CLASS_TEMPLATE_FILE", "admin_images.htm");
  define("ADMIN_BANNERS_CLASS_TEMPLATE_FILE", "admin_banners.htm");
  define("ADMIN_TEMPLATES_CLASS_TEMPLATE_FILE", "admin_templates.htm");

  // какая папка содержит изображения для баннеров (папку задаем относительно корневой папки сайта)
  define("ADMIN_BANNERS_CLASS_UPLOAD_FOLDER", "files/banners");



    // ====================== TODO: удалить этот блок позже (еще один дубль сейчас есть в objects/.ref-models/AdminFiles.php),
    // ======================       пока оставлен для совместимости с частями старой версии движка,
    // ======================       надо заменить на уже существующий this->text->translitText($text, $from)
    if (!function_exists('impera_TranslitFilename')) {

        // транслитерация имени файла ==============================================

        function impera_TranslitFilename ($file, $from = '') {

            // с какого языка?
            $from = strtolower(trim($from));
            switch ($from) {

                // если с русского или украинского
                case 'ru':
                case 'ua':

                    // транслитерируем по типичной таблице символов
                    $charmap = array('а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'g',  'д' => 'd',  'е' => 'e',
                                     'є' => 'ye', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',  'і' => 'i',  'и' => 'i',
                                     'й' => 'j',  'к' => 'k',  'ї' => 'yi', 'л' => 'l',  'м' => 'm',  'н' => 'n',
                                     'о' => 'o',  'п' => 'p',  'р' => 'r',  'с' => 's',  'т' => 't',  'у' => 'u',
                                     'ф' => 'f',  'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
                                     'ь' => '',   'ы' => 'y',  'ъ' => '',   'э' => 'e',  'ю' => 'yu', 'я' => 'ya',
                                     'А' => 'A',  'Б' => 'B',  'В' => 'V',  'Г' => 'G',  'Д' => 'D',  'Е' => 'E',
                                     'Є' => 'Ye', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',  'І' => 'I',  'И' => 'I',
                                     'Й' => 'J',  'К' => 'K',  'Ї' => 'Yi', 'Л' => 'L',  'М' => 'M',  'Н' => 'N',
                                     'О' => 'O',  'П' => 'P',  'Р' => 'R',  'С' => 'S',  'Т' => 'T',  'У' => 'U',
                                     'Ф' => 'F',  'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
                                     'Ь' => '',   'Ы' => 'Y',  'Ъ' => '',   'Э' => 'E',  'Ю' => 'Yu', 'Я' => 'Ya');
                    // дополняем таблицу кодировкой Windows-1251
                    if (function_exists('iconv')) {
                        $count = count($charmap);
                        foreach ($charmap as $char => &$change) {
                            $char = @ iconv('UTF-8', 'Windows-1251//IGNORE', $char);
                            if (($char !== FALSE) && ($char != '') && !isset($charmap[$char])) $charmap[$char] = &$change;
                            $count--;
                            if ($count == 0) break;
                        }
                    }
                    $file = strtr($file, $charmap);

                    // транслитерируем другие возможно неучтенные символы
                    if (function_exists('iconv')) $file = @ iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $file);
                    break;
            }

            // возвращаем результат
            return $file;
        }

    }
    // ====================== удалить этот блок позже (конец блока)



  // контрольная функция пре/пост распаковки файла ===========================

  function myExtractCallBack ($event, &$header) {

    // какое событие произошло?
    switch ($event) {

      // если пре распаковка
      case PCLZIP_CB_PRE_EXTRACT:

        // если путь файла в архиве содержит инъекцию, возвращаем ОТКЛОНИТЬ РАСПАКОВКУ
        $file = isset($header["stored_filename"]) ? trim($header["stored_filename"]) : "";
        $file = str_replace("\\", "/", $file);
        if (strpos($file, "./") !== FALSE) return 0;

        // выправляем имя файла (транслитерируем русские символы, заменяем пробелы дефисами, удаляем избыточные слеши)
        if (isset($header["filename"])) {
          $header["filename"] = impera_TranslitFilename($header["filename"], "ru");
          $header["filename"] = str_replace(" ", "-", $header["filename"]);
          $header["filename"] = str_replace("\\", "/", $header["filename"]);
          while (strpos($header["filename"], "//") !== FALSE) $header["filename"] = str_replace("//", "/", $header["filename"]);
        }
        break;

      // если пост распаковка
      case PCLZIP_CB_POST_EXTRACT:

        // какой результат распаковки?
        if (isset($header["status"])) {
          $status = strtolower(trim($header["status"]));
          switch ($status) {

            // если успешная распаковка
            case "ok":
              $file = isset($header["filename"]) ? trim($header["filename"]) : "";
              if ($file != "") {

                // устанавливаем типичные права доступа
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (is_dir($file)) {
                  @chmod($file, 0755);
                } else {
                  if ($ext == "php") {
                    @chmod($file, 0644);
                  } else {
                    @chmod($file, 0644);
                  }
                }
              }
              break;

            // если старая версия файла
            case "newer_exist":
              break;

            // если такой уже существует
            case "already_a_directory":
              break;

            // если отклоненный
            case "filtered":
            case "skipped":
              break;

            // если ошибка
            case "write_protected":
            case "write_protect":
            case "write_error":
            case "read_error":
            case "error":
            case "path_creation_fail":
            case "invalid_header":
            case "filename_to_long":
              break;
          }
        }
        break;
    }

    // возвращаем ПОЗВОЛИТЬ
    return 1;
  }



  // =========================================================================
  // Класс Images (админ модуль картинок дизайна)
  // =========================================================================

  class Images extends Basic {

    // путь к файлам
    public $files_path = '';

    // допустимые расширения файлов
    protected $files_extensions = array('jpg', 'jpeg', 'png', 'gif', 'ico');

    // запрещенные расширения папок
    protected $disabled_extensions = array("phtml", "php", "php3", "php4", "php5", "php6", "phps", "cgi", "exe", "com", "dll", "pl", "asp", "aspx", "shtml", "shtm", "fcgi", "fpl", "jsp", "htm", "html", "wml");



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // устанавливаем путь к файлам
        $this->files_path = ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/images';
    }



    // обработка входных параметров и команд =================================

    protected function process () {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      // читаем входной параметр ITEMID - имя оперируемого файла,
      // параметр FROM - на какую страницу вернуться после операции,
      // параметр ACTION - какую команду требовали сделать
      $filename = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

      // какую команду требовали сделать во входном параметре ACTION?
      switch ($act) {

        // если команду "Разрешить / запретить показ на сайте"
        case ACTION_REQUEST_PARAM_VALUE_ENABLED:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_enabled($filename);
          break;

        // если команду "Редактировать запись"
        case ACTION_REQUEST_PARAM_VALUE_EDIT:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_edit($filename);
          break;

        // если команду "Редактировать новую запись"
        case ACTION_REQUEST_PARAM_VALUE_EDIT_NEW:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_edit_new($filename);
          break;

        // если команду "Редактировать все записи"
        case ACTION_REQUEST_PARAM_VALUE_EDIT_ALL:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_edit_all($filename);
          break;

        // если команду "Удалить файл"
        case ACTION_REQUEST_PARAM_VALUE_DELETE:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_delete($filename);
          break;

        // если команду "Создать папку"
        case ACTION_REQUEST_PARAM_VALUE_CREATE:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_create($filename);
          break;

        // если команду "Загрузить файл"
        case ACTION_REQUEST_PARAM_VALUE_DOWNLOAD:

          // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
          $this->check_token();

          // выполняем команду
          $filename = $this->hdd->safeFilename($filename, FALSE);
          $cancel = $this->do_download($filename);
          break;

        // иначе команда неизвестна
        default:

          // считаем, что была выбрана такая папка
          $filename = $this->hdd->safeFilename($filename, FALSE);
      }

      // передаем в шаблонизатор выбранную папку
      while (($filename != "") && !is_dir($this->files_path . "/" . $filename)) $filename = $this->parent_node($filename);
      $this->smarty->assignByRef(SMARTY_VAR_ITEM, $filename);

      // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
      if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
    }

    // возврат имени родительского пути ========================================

    private function parent_node ($path) {

      // удаляем из имени пути последнюю ветку
      $path = str_replace("\\", "/", $path);
      $path = explode("/", $path);
      array_pop($path);
      return implode("/", $path);
    }

    // защита всех папок в пути ================================================

    private function guard_path ($path) {

        // поправляем путь
        $path = trim($path);
        $path = str_replace("\\", "/", $path);
        while (substr($path, -1) == "/") $path = trim(substr($path, 0, -1));
        if ($path != "") $path .= "/";

        // если удалось открыть папку
        if ($path != '' && ($handle = @opendir($path)) !== FALSE) {

          // создаем псевдозапись папки
          $this->folder_record($path);

          // перебираем имена вложенных элементов
          while (($file = readdir($handle)) !== FALSE) {
            if (trim($file, '.') != '') {
              $fullpath = $path . $file;

              // если это папка
              if (is_dir($fullpath)) {

                // создаем псевдозапись папки
                $this->folder_record($fullpath);

                // обрабатываем вложенные элементы
                $this->guard_path($fullpath);
              }
            }
          }

          // закрываем папку
          closedir($handle);
        }
    }

    // создание шаблона фильтра файлов по расширению ===========================

    protected function get_pattern ($with_record_files = TRUE) {

      // перебираем расширения файлов
      $pattern = "";
      if (is_array($this->files_extensions) && !empty($this->files_extensions)) {
        foreach ($this->files_extensions as $ext) {
          $ext = strtolower(trim($ext));
          if ($ext != "") {
            $ext = preg_replace("'[^a-z0-9_\-]'i", "", $ext);
            if ($ext != "") {
              if ($pattern != "") $pattern .= "|";
              $pattern .= $ext;
            }
          }
        }
      }

      // создаем шаблон
      if ($with_record_files && ($pattern != "")) $pattern .= "|";
      $pattern = "\.(" . $pattern
                        . ($with_record_files ? preg_replace("'[^a-z0-9_\-]'i", "", FILE_RECORD_FILE_EXTENSION) . "|" : "")
                        . ($with_record_files ? preg_replace("'[^a-z0-9_\-]'i", "", FOLDER_RECORD_FILE_EXTENSION) : "")
                 . ")$";

      // возвращаем шаблон
      return $pattern;
    }

    // проверка по имени файла является ли картинка миниатюрой =================

    protected function is_thumbnail ($file) {

      // возвращаем НЕТ (у этого класса нет миниатюр)
      return FALSE;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_ENABLED ===================

    protected function do_enabled ($filename) {

      // возвращаем НЕ ОТМЕНЯТЬ ПЕРЕНАПРАВЛЕНИЕ (у этого класса нет такой команды)
      return FALSE;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_EDIT ======================

    protected function do_edit ($filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      if ($this->config->demo) {
        $cancel = $this->push_error("В демо версии запрещено редактировать параметры файлов и папок.");
      } else {

        // проверяем возможность редактирования
        if (($filename != "") && !file_exists($this->files_path . "/" . $filename)) {
          $cancel = $this->push_error("Папка или файл " . $this->files_path . "/" . $filename . " не существует. Необходимо указать существующий файл или папку.");
        } else {

          // получаем отредактированные данные
          $request = array();
          if (isset($_POST)) {
            if (isset($_POST[REQUEST_PARAM_NAME_TITLE]) && is_array($_POST[REQUEST_PARAM_NAME_TITLE]) && isset($_POST[REQUEST_PARAM_NAME_TITLE][$filename])) {
              $request[REQUEST_PARAM_NAME_TITLE] = $_POST[REQUEST_PARAM_NAME_TITLE][$filename];
            }
            if (isset($_POST[REQUEST_PARAM_NAME_PRICE]) && is_array($_POST[REQUEST_PARAM_NAME_PRICE]) && isset($_POST[REQUEST_PARAM_NAME_PRICE][$filename])) {
              $request[REQUEST_PARAM_NAME_PRICE] = $_POST[REQUEST_PARAM_NAME_PRICE][$filename];
            }
            if (isset($_POST[REQUEST_PARAM_NAME_DESCRIPTION]) && is_array($_POST[REQUEST_PARAM_NAME_DESCRIPTION]) && isset($_POST[REQUEST_PARAM_NAME_DESCRIPTION][$filename])) {
              $request[REQUEST_PARAM_NAME_DESCRIPTION] = $_POST[REQUEST_PARAM_NAME_DESCRIPTION][$filename];
            }
            if (isset($_POST[REQUEST_PARAM_NAME_LINK]) && is_array($_POST[REQUEST_PARAM_NAME_LINK]) && isset($_POST[REQUEST_PARAM_NAME_LINK][$filename])) {
              $request[REQUEST_PARAM_NAME_LINK] = $_POST[REQUEST_PARAM_NAME_LINK][$filename];
            }
            if (isset($_POST[REQUEST_PARAM_NAME_ENABLED]) && is_array($_POST[REQUEST_PARAM_NAME_ENABLED]) && isset($_POST[REQUEST_PARAM_NAME_ENABLED][$filename])) {
              $request[REQUEST_PARAM_NAME_ENABLED] = $_POST[REQUEST_PARAM_NAME_ENABLED][$filename];
            }
          }

          // если это файл
          $url = $this->files_path . (($filename != "") ? "/" . $filename : "");
          if (is_file($url)) {

            // проверяем вхождение файла в список разрешенных по расширению
            if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
              $cancel = $this->push_error("К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.");
            } else {
              $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
              if (($ext == "") || !in_array($ext, $this->files_extensions)) {
                $cancel = $this->push_error("Необходимо указать файл следующего расширения: " . implode(", ", $this->files_extensions) . ".");
              } else {

                // проверяем что JPG/PNG/GIF-файл не является миниатюрой
                if ((($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) && $this->is_thumbnail($url)) {
                  $cancel = $this->push_error("Необходимо указать файл изображения, а не его миниатюру. Имя такого файла не содержит маркер " . THUMBNAIL_FILENAME_MARKER . " перед расширением файла.");
                } else {

                  // проверяем доступность файла для записи
                  if (!is_writable($url)) {
                    $cancel = $this->push_error("Текущие атрибуты файла " . $url . " не позволяют перезаписывать его параметры.");
                  } else {

                    // проверяем наличие данных
                    if (empty($request)) {
                      $cancel = $this->push_error("Не получены отредактированные данные.");
                    } else {

                      // записываем изменения в файл псевдозаписи файла
                      $this->file_record($url, $request);
                    }
                  }
                }
              }
            }

          // иначе это папка
          } else {
            if (!is_writable($url)) {
              $cancel = $this->push_error("Текущие атрибуты папки " . $url . " не позволяют перезаписывать ее параметры.");
            } else {

              // проверяем наличие данных
              if (empty($request)) {
                $cancel = $this->push_error("Не получены отредактированные данные.");
              } else {

                // записываем изменения в файл псевдозаписи папки
                $this->folder_record($url, $request);
              }
            }
          }
        }
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_EDIT_NEW ==================

    protected function do_edit_new ($filename) {

      // возвращаем НЕ ОТМЕНЯТЬ ПЕРЕНАПРАВЛЕНИЕ (у этого класса нет такой команды)
      return FALSE;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_EDIT_ALL ==================

    protected function do_edit_all ($filename) {

      // возвращаем НЕ ОТМЕНЯТЬ ПЕРЕНАПРАВЛЕНИЕ (у этого класса нет такой команды)
      return FALSE;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_DELETE ====================

    protected function do_delete ($filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      if ($this->config->demo) {
        $cancel = $this->push_error("В демо версии запрещено совершать удаление файлов и папок.");
      } else {

        // проверяем возможность удаления
        if (($filename != "") && !file_exists($this->files_path . "/" . $filename)) {
          $cancel = $this->push_error("Папка или файл " . $this->files_path . "/" . $filename . " не существует. Необходимо указать существующий файл или папку.");
        } else {

          // если это файл
          $url = $this->files_path . (($filename != "") ? "/" . $filename : "");
          if (is_file($url)) {

            // проверяем вхождение файла в список разрешенных по расширению
            if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
              $cancel = $this->push_error("К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.");
            } else {
              $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
              if (($ext == "") || !in_array($ext, $this->files_extensions)) {
                $cancel = $this->push_error("Необходимо указать файл следующего расширения: " . implode(", ", $this->files_extensions) . ".");
              } else {

                // проверяем что JPG/PNG/GIF-файл не является миниатюрой
                if ((($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) && $this->is_thumbnail($url)) {
                  $cancel = $this->push_error("Необходимо указать файл изображения, а не его миниатюру. Имя такого файла не содержит маркер " . THUMBNAIL_FILENAME_MARKER . " перед расширением файла.");
                } else {

                  // проверяем доступность файла для записи
                  if (!is_writable($url)) {
                    $cancel = $this->push_error("Текущие атрибуты файла " . $url . " не позволяют удалить его.");
                  } else {

                    // удаляем файл
                    $this->delete($url);
                  }
                }
              }
            }

          // иначе это папка
          } else {
            if (!is_writable($url)) {
              $cancel = $this->push_error("Текущие атрибуты папки " . $url . " не позволяют удалить ее.");
            } else {

              // удаляем папку
              $this->clean_dir($url);
              if (file_exists($url)) {
                if ($filename != "") {
                  rmdir($url);

                // иначе очищалась корневая папка, нужно создать ее файл псевдозаписи
                } else {
                  $this->folder_record($url);
                }
              }
            }
          }
        }
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_CREATE ====================

    protected function do_create (&$filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      if ($this->config->demo) {
        $cancel = $this->push_error("В демо версии запрещено создавать папки.");
      } else {

        // проверяем возможность создания
        $name = trim($this->param(REQUEST_PARAM_NAME_NAME));
        $name = $this->hdd->safeFilename($name);
        if ($name == "") {
          $cancel = $this->push_error("Необходимо указать имя создаваемой папки.");
        } else {

          // проверяем доступность папки для записи
          $url = $this->files_path . (($filename != "") ? "/" . $filename : "");
          if (!is_writable($url)) {
            $cancel = $this->push_error("Текущие атрибуты папки " . $url . " не позволяют запись в нее.");
          } else {
            $url .= "/" . $name;

            // проверяем не вхождение папки в список запрещенных по расширению
            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
            if (($ext != "") && is_array($this->disabled_extensions) && in_array($ext, $this->disabled_extensions)) {
              $cancel = $this->push_error("Запрещено создавать папки с расширением " . $ext . ".");
            } else {

              // создаем файл псевдозаписи папки
              $this->folder_record($url);
              $filename = (($filename != "") ? $filename . "/" : "") . $name;
            }
          }
        }
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_DOWNLOAD ==================

    protected function do_download ($filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      $data = null;
      if (isset($_FILES["image"])) {
        $data = &$_FILES["image"];
      } elseif (isset($_FILES["file"])) {
        $data = &$_FILES["file"];
      }

      // если загружают файл
      if (isset($data) && !empty($data)) {

        if ($this->config->demo) {
          $cancel = $this->push_error("В демо версии запрещено совершать загрузку своих файлов.");
        } else {

          // пробуем принять файл
          if (($filename != "") && !file_exists($this->files_path . "/" . $filename)) {
            $cancel = $this->push_error("Папка " . $filename . " не существует. Необходимо указать существующую.");
          } else {

            $name = isset($data["name"]) ? $data["name"] : "";
            $name = $this->hdd->safeFilename($name);
            if (isset($data["tmp_name"]) && ($data["tmp_name"] != "") && (!isset($data["error"]) || ($data["error"] == UPLOAD_ERR_OK))) {

              // проверяем вхождение файла в список разрешенных по расширению
              $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
              if (($ext == "") || (($ext != "zip") && (!is_array($this->files_extensions) || !in_array($ext, $this->files_extensions)))) {
                $cancel = $this->push_error("Недопустимый тип " . $ext . " загружаемого файла. Принимаются только файлы с расширением " . (is_array($this->files_extensions) && !empty($this->files_extensions) ? implode(", ", $this->files_extensions) : "НЕТ_ДАННЫХ") . " или ZIP-архивы.");
              } else {

                // проверяем что JPG/PNG/GIF-файл не является миниатюрой
                if ((($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) && $this->is_thumbnail($name)) {
                  $cancel = $this->push_error("Имя файла не должно быть таким, что предназначено для миниатюры изображения. Не используйте маркер " . THUMBNAIL_FILENAME_MARKER . " перед расширением файла.");
                } else {

                  // если это не архивный файл
                  if ($ext != "zip") {
                    $url = $this->files_path . (($filename != "") ? "/" . $filename : "") . "/" . $name;
                    if (!move_uploaded_file($data["tmp_name"], $url)) {
                      $cancel = $this->push_error("Не удалось загрузить файл.");
                    } else {

                      // создаем файл псевдозаписи файла
                      $this->file_record($url);
                    }

                  // иначе это архивный файл
                  } else {
                    $url = $this->files_path . (($filename != "") ? "/" . $filename : "") . "/";

                    // получаем шаблон фильтра файлов по расширению
                    $pattern = $this->get_pattern();

                    // начинаем распаковку архива
                    $zip = new PclZip($data["tmp_name"]);
                    if (!$zip->extract(PCLZIP_OPT_PATH, $url,
                                       PCLZIP_OPT_BY_PREG, "'" . $pattern . "'i",
                                       PCLZIP_OPT_REPLACE_NEWER,
                                       PCLZIP_CB_PRE_EXTRACT, "myExtractCallBack",
                                       PCLZIP_CB_POST_EXTRACT, "myExtractCallBack")) {
                      $cancel = $this->push_error("Не удалось распаковать " . $zip->errorInfo(TRUE));
                    }

                    // обрабатываем (защищаем) созданные папки
                    $this->guard_path($url);
                  }
                }
              }

            // иначе была ошибка при передаче файла
            } else {
              switch ($data["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                  $cancel = $this->push_error("Размер принятого файла \"" . $name . "\" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.");
                  break;
                case UPLOAD_ERR_FORM_SIZE:
                  $cancel = $this->push_error("Размер загружаемого файла \"" . $name . "\" превышает максимально допустимое значение" . (isset($_POST["MAX_FILE_SIZE"]) ? " " . trim($_POST["MAX_FILE_SIZE"]) . " байт" : "") . ".");
                  break;
                case UPLOAD_ERR_PARTIAL:
                  $cancel = $this->push_error("Загрузка файла \"" . $name . "\" прервалась и он был получен не весь.");
                  break;
                case UPLOAD_ERR_NO_FILE:
                  $cancel = $this->push_error("Не получен файл \"" . $name . "\".");
                  break;
                default:
                  $cancel = $this->push_error("Произошла неизвестная ошибка при попытке загрузить файл \"" . $name . "\".");
              }
            }
          }
        }
      } else {
        $cancel = $this->push_error("Не указан загружаемый файл.");
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // удаление файла ==========================================================

    protected function delete ($file) {

      // удаляем файл
      unlink($file);
    }

    // создание псевдозаписи папки =============================================

    protected function folder_record ($path, $request = null) {

      // получаем шаблон фильтра файлов по расширению (кроме файлов псевдозаписей)
      $pattern = $this->get_pattern(FALSE);

      // защищаем папку (с перезаписью защитных файлов)
      $this->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_IMAGES, 0755, TRUE, $pattern);
    }

    // создание псевдозаписи файла =============================================

    protected function file_record ($file, $request = null) {
    }

    // получение псевдозаписи файла ============================================

    protected function get_file ($file, &$data = null) {

      // берем псевдозапись файла
      $this->get_file_record($file, $data);
    }

    // получение псевдозаписи папки ============================================

    protected function get_folder ($file, &$data = null) {

      // берем псевдозапись папки
      $this->get_folder_record($file, $data);
    }

    // контрольная функция для usort списка файлов в папке =====================

    private function usort_compare ($a, $b) {

      // папки отправляем наверх списка
      if (isset($a->files) && !isset($b->files)) return -1;
      if (!isset($a->files) && isset($b->files)) return 1;

      // у кого позиция выше, отправляем наверх списка
      $av = isset($a->position) ? intval($a->position) : 0;
      $bv = isset($b->position) ? intval($b->position) : 0;
      if ($av > $bv) return -1;
      if ($av < $bv) return 1;

      // сортируем по алфавиту
      $av = isset($a->title) ? trim($a->title) : "";
        if ($av == "") $av = isset($a->filename) ? trim($a->filename) : "";
      $bv = isset($b->title) ? trim($b->title) : "";
        if ($bv == "") $bv = isset($b->filename) ? trim($b->filename) : "";
      return strcasecmp($av, $bv);
    }

    // получение списка файлов в папке =========================================

    public function get_files ($path, $url, &$files = array(), $maxlevel = 256, $level = 1) {

      // если не достигли предельного уровня вложенности
      $result = FALSE;
      if ($maxlevel > 256) $maxlevel = 256;
      if ($maxlevel < 1) $maxlevel = 1;
      if ($level < 1) $level = 1;
      if ($level <= $maxlevel) {

        // поправляем путь и url (относительный путь)
        $url = trim($url);
        $url = str_replace("\\", "/", $url);
        while (substr($url, -1) == "/") $url = trim(substr($url, 0, -1));
        if ($url != "") $url .= "/";

        $path = trim($path);
        $path = str_replace("\\", "/", $path);
        while (substr($path, -1) == "/") $path = trim(substr($path, 0, -1));
        if ($path != "") $path .= "/";

        // если удалось открыть папку
        $result = $path != '' && ($handle = @ opendir($path)) !== FALSE;
        if ($result) {

          // перебираем имена вложенных элементов
          while (($file = readdir($handle)) !== FALSE) {
            if (trim($file, '.') != '') {
              $fullpath = $path . $file;

              // готовим запись
              $item = null;

              // если это папка
              if (is_dir($fullpath)) {

                // берем псевдозапись папки
                $item = new stdClass;
                $this->get_folder($fullpath, $item);

                // дополняем запись информацией
                $item->path = $url;
                $item->filename = $file;
                $item->ctime = @ filectime($fullpath); $item->ctime = ($item->ctime !== FALSE) ? date("Y-m-d H:i:s", $item->ctime) : "0000-00-00 00:00:00";
                $item->mtime = @ filemtime($fullpath); $item->mtime = ($item->mtime !== FALSE) ? date("Y-m-d H:i:s", $item->mtime) : "0000-00-00 00:00:00";
                $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');
                $item->files = array();
                if ($level <= $maxlevel) {
                  $this->get_files($fullpath, $url . $file, $item->files, $maxlevel, $level + 1);
                }

              // иначе это файл
              } else {

                // проверяем вхождение файла в список разрешенных по расширению
                if (is_array($this->files_extensions) && !empty($this->files_extensions)) {
                  $ext = strtolower(pathinfo($fullpath, PATHINFO_EXTENSION));
                  if (($ext != "") && in_array($ext, $this->files_extensions)) {

                    // если это JPG/PNG/GIF-картинка
                    if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) {

                      // если не миниатюра
                      if (!$this->is_thumbnail($fullpath)) {

                        // берем псевдозапись файла
                        $item = new stdClass;
                        $this->get_file($fullpath, $item);

                        // дополняем запись информацией
                        $item->path = $url;
                        $item->filename = $file;
                        $item->extension = $ext;
                        $item->filesize = @filesize($fullpath); if ($item->filesize === FALSE) $item->filesize = 0;
                        $item->ctime = @filectime($fullpath); $item->ctime = ($item->ctime !== FALSE) ? date("Y-m-d H:i:s", $item->ctime) : "0000-00-00 00:00:00";
                        $item->mtime = @filemtime($fullpath); $item->mtime = ($item->mtime !== FALSE) ? date("Y-m-d H:i:s", $item->mtime) : "0000-00-00 00:00:00";
                        $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');

                        // если картинка распознается
                        if (list($width, $height) = @getimagesize($fullpath)) {

                          // дополняем запись информацией
                          $item->width = $width;
                          $item->height  = $height;
                        }
                      }

                    // иначе это не JPG/PNG/GIF-картинка
                    } else {

                      // берем псевдозапись файла
                      $item = new stdClass;
                      $this->get_file($fullpath, $item);

                      // дополняем запись информацией
                      $item->path = $url;
                      $item->filename = $file;
                      $item->extension = $ext;
                      $item->filesize = @filesize($fullpath); if ($item->filesize === FALSE) $item->filesize = 0;
                      $item->ctime = @filectime($fullpath); $item->ctime = ($item->ctime !== FALSE) ? date("Y-m-d H:i:s", $item->ctime) : "0000-00-00 00:00:00";
                      $item->mtime = @filemtime($fullpath); $item->mtime = ($item->mtime !== FALSE) ? date("Y-m-d H:i:s", $item->mtime) : "0000-00-00 00:00:00";
                      $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');
                    }
                  }
                }
              }

              // если запись есть, добавляем оперативные ссылки админпанели
              if (!empty($item)) {
                $item->enable_get = $this->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_ENABLED,
                                                          REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                          REQUEST_PARAM_NAME_TOKEN => $this->token));
                $item->delete_get = $this->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_DELETE,
                                                          REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                          REQUEST_PARAM_NAME_TOKEN => $this->token));
                $item->edit_get = $this->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_EDIT,
                                                        REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                        REQUEST_PARAM_NAME_TOKEN => $this->token));

                // добавляем запись в список
                $files[] = $item;
              }
            }
          }

          usort($files, array("Images", "usort_compare"));

          // закрываем папку
          closedir($handle);
        }
      }

      // возвращаем СДЕЛАНО / ОШИБКА
      return $result;
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

        // обрабатываем входные команды,
        // устанавливаем заголовок страницы
        $this->process();
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Файлы картинок';

        // читаем список картинок
        $files = array();
        if (!$this->get_files($this->files_path, '', $files)) {
            $this->push_error('Не удалось открыть папку с картинками ' . $this->files_path);
        }

        // передаем нужные данные в шаблонизатор,
        // создаем контент модуля
        $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $files);
        $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
        $this->body = $this->smarty->fetch(ADMIN_IMAGES_CLASS_TEMPLATE_FILE);

        return TRUE;
    }
  }



  // =========================================================================
  // Класс Banners (админ модуль баннеров)
  // =========================================================================

  class Banners extends Images {

    // допустимые расширения файлов
    protected $files_extensions = array("jpg", "jpeg", "png", "gif");



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // устанавливаем путь к картинкам
        $this->files_path = ROOT_FOLDER_REFERENCE . ADMIN_BANNERS_CLASS_UPLOAD_FOLDER;

        // если такой папки нет, создаем ее (создаем файл псевдозаписи папки)
        if (!file_exists($this->files_path)) $this->folder_record($this->files_path);
    }



    // проверка по имени файла является ли картинка миниатюрой =================

    protected function is_thumbnail ($file) {

      // возвращаем ЭТО МИНИАТЮРА / НЕТ
      $ext = pathinfo($file, PATHINFO_EXTENSION);
      $marker = strtolower(THUMBNAIL_FILENAME_MARKER . $ext);
      return strtolower(substr($file, 0, -strlen($marker))) == $marker;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_ENABLED ===================

    protected function do_enabled ($filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      if ($this->config->demo) {
        $cancel = $this->push_error("В демо версии запрещено менять свойства файлов и папок.");
      } else {

        // проверяем возможность переключения
        if (($filename != "") && !file_exists($this->files_path . "/" . $filename)) {
          $cancel = $this->push_error("Папка или файл " . $this->files_path . "/" . $filename . " не существует. Необходимо указать существующий файл или папку.");
        } else {

          // если это файл
          $url = $this->files_path . (($filename != "") ? "/" . $filename : "");
          if (is_file($url)) {

            // проверяем вхождение файла в список разрешенных по расширению
            if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
              $cancel = $this->push_error("К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.");
            } else {
              $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
              if (($ext == "") || !in_array($ext, $this->files_extensions)) {
                $cancel = $this->push_error("Необходимо указать файл следующего расширения: " . implode(", ", $this->files_extensions) . ".");
              } else {

                // проверяем что JPG/PNG/GIF-файл не является миниатюрой
                if ((($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) && $this->is_thumbnail($url)) {
                  $cancel = $this->push_error("Необходимо указать файл изображения, а не его миниатюру. Имя такого файла не содержит маркер " . THUMBNAIL_FILENAME_MARKER . " перед расширением файла.");
                } else {

                  // проверяем доступность файла для записи
                  if (!is_writable($url)) {
                    $cancel = $this->push_error("Текущие атрибуты файла " . $url . " не позволяют перезаписывать его свойства.");
                  } else {

                    // имитируем якобы был параметр enabled = !enabled
                    $request = array();
                    $request[REQUEST_PARAM_NAME_ENABLED] = "";

                    // записываем изменения в файл псевдозаписи файла
                    $this->file_record($url, $request);
                  }
                }
              }
            }

          // иначе это папка
          } else {
            if (!is_writable($url)) {
              $cancel = $this->push_error("Текущие атрибуты папки " . $url . " не позволяют перезаписывать ее свойства.");
            } else {

              // имитируем якобы был параметр enabled = !enabled
              $request = array();
              $request[REQUEST_PARAM_NAME_ENABLED] = "";

              // записываем изменения в файл псевдозаписи папки
              $this->folder_record($url, $request);
            }
          }
        }
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // удаление файла ==========================================================

    protected function delete ($file) {

      // удаляем файл
      unlink($file);

      // если у JPG/PNG/GIF-картинки есть миниатюра, удаляем ее
      $ext = pathinfo($file, PATHINFO_EXTENSION);
      $thubmnail = substr($file, 0, -strlen($ext)) . THUMBNAIL_FILENAME_MARKER . $ext;
      $ext = strtolower($ext);
      if ((($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif")) && file_exists($thubmnail)) unlink($thubmnail);

      // удаляем файл псевдозаписи
      $file = trim(substr($file, 0, -strlen($ext))) . (($ext != "") ? "" : ".") . FILE_RECORD_FILE_EXTENSION;
      if (file_exists($file)) unlink($file);
    }

    // создание псевдозаписи папки =============================================

    protected function folder_record ($path, $request = null) {

      // получаем шаблон фильтра файлов по расширению (кроме файлов псевдозаписей)
      $pattern = $this->get_pattern(FALSE);

      // защищаем папку (с перезаписью защитных файлов)
      $this->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX_FOR_IMAGES, 0755, TRUE, $pattern);

      // читаем файл псевдозаписи
      $item = new stdClass;
      $this->get_folder_record($path, $item);

      // если не указаны параметры запроса, берем их из переменной $_REQUEST
      if (is_null($request) && isset($_REQUEST)) $request = $_REQUEST;
      if (!is_array($request)) $request = array();

      // добавляем в псевдозапись изменения:
      // виртуальное название
      $changed = FALSE;
      if (!isset($item->title) || isset($request[REQUEST_PARAM_NAME_TITLE])) {
        $value = isset($request[REQUEST_PARAM_NAME_TITLE]) ? trim($request[REQUEST_PARAM_NAME_TITLE]) : "";
        if (!isset($item->title) || ($value != $item->title)) {
          $item->title = $value;
          $changed = TRUE;
        }
      }
      // описание
      if (!isset($item->description) || isset($request[REQUEST_PARAM_NAME_DESCRIPTION])) {
        $value = isset($request[REQUEST_PARAM_NAME_DESCRIPTION]) ? trim($request[REQUEST_PARAM_NAME_DESCRIPTION]) : "";
        if (!isset($item->description) || ($value != $item->description)) {
          $item->description = $value;
          $changed = TRUE;
        }
      }
      // разрешен или нет
      if (!isset($item->enabled) || isset($request[REQUEST_PARAM_NAME_ENABLED])) {
        if (!isset($item->enabled)) {
          $value = 1;
        } else {
          $value = isset($request[REQUEST_PARAM_NAME_ENABLED]) ? trim($request[REQUEST_PARAM_NAME_ENABLED]) : "";
          if ($value == "") {
            $value = ($item->enabled == 1) ? 0 : 1;
          } else {
            $value = ($value == 1) ? 1 : 0;
          }
        }
        if (!isset($item->enabled) || ($value != $item->enabled)) {
          $item->enabled = $value;
          $changed = TRUE;
        }
      }

      // если произошли изменения, сохраняем файл псевдозаписи
      if ($changed) $this->write_folder_record($path, $item);
    }

    // создание псевдозаписи файла =============================================

    protected function file_record ($file, $request = null) {

      // читаем файл псевдозаписи
      $item = new stdClass;
      $this->get_file_record($file, $item);

      // если не указаны параметры запроса, берем их из переменной $_REQUEST
      if (is_null($request) && isset($_REQUEST)) $request = $_REQUEST;
      if (!is_array($request)) $request = array();

      // добавляем в псевдозапись изменения:
      // виртуальное название
      $changed = FALSE;
      if (!isset($item->title) || isset($request[REQUEST_PARAM_NAME_TITLE])) {
        $value = isset($request[REQUEST_PARAM_NAME_TITLE]) ? trim($request[REQUEST_PARAM_NAME_TITLE]) : "";
        if (!isset($item->title) || ($value != $item->title)) {
          $item->title = $value;
          $changed = TRUE;
        }
      }
      // описание
      if (!isset($item->description) || isset($request[REQUEST_PARAM_NAME_DESCRIPTION])) {
        $value = isset($request[REQUEST_PARAM_NAME_DESCRIPTION]) ? trim($request[REQUEST_PARAM_NAME_DESCRIPTION]) : "";
        if (!isset($item->description) || ($value != $item->description)) {
          $item->description = $value;
          $changed = TRUE;
        }
      }
      // цена рекламируемого объекта
      if (!isset($item->price) || isset($request[REQUEST_PARAM_NAME_PRICE])) {
        $value = isset($request[REQUEST_PARAM_NAME_PRICE]) ? trim($request[REQUEST_PARAM_NAME_PRICE]) : "";
        if (!isset($item->price) || ($value != $item->price)) {
          $item->price = $value;
          $changed = TRUE;
        }
      }
      // по какой ссылке ведет
      if (!isset($item->link) || isset($request[REQUEST_PARAM_NAME_LINK])) {
        $value = isset($request[REQUEST_PARAM_NAME_LINK]) ? trim($request[REQUEST_PARAM_NAME_LINK]) : "";
        if (!isset($item->link) || ($value != $item->link)) {
          $item->link = $value;
          $changed = TRUE;
        }
      }
      // разрешен или нет
      if (!isset($item->enabled) || isset($request[REQUEST_PARAM_NAME_ENABLED])) {
        if (!isset($item->enabled)) {
          $value = 1;
        } else {
          $value = isset($request[REQUEST_PARAM_NAME_ENABLED]) ? trim($request[REQUEST_PARAM_NAME_ENABLED]) : "";
          if ($value == "") {
            $value = ($item->enabled == 1) ? 0 : 1;
          } else {
            $value = ($value == 1) ? 1 : 0;
          }
        }
        if (!isset($item->enabled) || ($value != $item->enabled)) {
          $item->enabled = $value;
          $changed = TRUE;
        }
      }

      // если произошли изменения, сохраняем файл псевдозаписи
      if ($changed) $this->write_file_record($file, $item);
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

        // обрабатываем входные команды,
        // устанавливаем заголовок страницы
        $this->process();
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Баннеры';

        // читаем список картинок
        $files = array();
        if (!$this->get_files($this->files_path, '', $files)) {
            $this->push_error('Не удалось открыть папку с баннерами ' . $this->files_path);
        }

        // передаем нужные данные в шаблонизатор,
        // создаем контент модуля
        $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $files);
        $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
        $this->body = $this->smarty->fetch(ADMIN_BANNERS_CLASS_TEMPLATE_FILE);

        return TRUE;
    }
  }



  // =========================================================================
  // Класс Templates (админ модуль шаблонов дизайна)
  // =========================================================================

  class Templates extends Images {

    // допустимые расширения файлов
    protected $files_extensions = array("tpl", "htm");



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

        // устанавливаем путь к файлам
        $this->files_path = ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html';

        // если такой папки нет, создаем ее (создаем файл псевдозаписи папки)
        if (!file_exists($this->files_path)) $this->folder_record($this->files_path);
    }



    // проверка по имени файла является ли картинка миниатюрой =================

    protected function is_thumbnail ($file) {

      // возвращаем НЕТ (у этого класса нет миниатюр)
      return FALSE;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_EDIT ======================

    protected function do_edit ($filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      if ($this->config->demo) {
        $cancel = $this->push_error("В демо версии запрещено редактировать файлы.");
      } else {

        // проверяем возможность редактирования
        if (($filename != "") && !file_exists($this->files_path . "/" . $filename)) {
          $cancel = $this->push_error("Файл " . $this->files_path . "/" . $filename . " не существует. Необходимо указать существующий файл.");
        } else {

          // получаем отредактированные данные
          $request = array();
          if (isset($_POST)) {
            if (isset($_POST[REQUEST_PARAM_NAME_CONTENT]) && is_array($_POST[REQUEST_PARAM_NAME_CONTENT]) && isset($_POST[REQUEST_PARAM_NAME_CONTENT][$filename])) {
              $request[REQUEST_PARAM_NAME_CONTENT] = is_string($_POST[REQUEST_PARAM_NAME_CONTENT][$filename]) ? rtrim($_POST[REQUEST_PARAM_NAME_CONTENT][$filename]) : "";
            }
          }

          // если это файл
          $url = $this->files_path . (($filename != "") ? "/" . $filename : "");
          if (is_file($url)) {

            // проверяем вхождение файла в список разрешенных по расширению
            if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
              $cancel = $this->push_error("К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.");
            } else {
              $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
              if (($ext == "") || !in_array($ext, $this->files_extensions)) {
                $cancel = $this->push_error("Необходимо указать файл следующего расширения: " . implode(", ", $this->files_extensions) . ".");
              } else {

                // проверяем доступность файла для записи
                if (!is_writable($url)) {
                  $cancel = $this->push_error("Текущие атрибуты файла " . $url . " не позволяют перезаписывать его.");
                } else {

                  // проверяем наличие данных
                  if (empty($request)) {
                    $cancel = $this->push_error("Не получены отредактированные данные.");
                  } else {

                    // записываем изменения в файл
                    if (!$handle = @fopen($url, "rb+")) $handle = @fopen($url, "wb");
                    if ($handle) {
                      flock($handle, LOCK_EX);
                      $request[REQUEST_PARAM_NAME_CONTENT] .= "\r\n";
                      $size = strlen($request[REQUEST_PARAM_NAME_CONTENT]);
                      fwrite($handle, $request[REQUEST_PARAM_NAME_CONTENT], $size);
                      ftruncate($handle, $size);
                      fclose($handle);
                    } else {
                      $cancel = $this->push_error("Не удалось открыть файл " . $url . " для записи.");
                    }
                  }
                }
              }
            }

          // иначе это папка
          } else {
            $cancel = $this->push_error("Это не файл " . $url . ". Необходимо указать файл.");
          }
        }
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // выполнение команды ACTION_REQUEST_PARAM_VALUE_EDIT_ALL ==================

    protected function do_edit_all ($filename) {

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      if ($this->config->demo) {
        $cancel = $this->push_error("В демо версии запрещено редактировать файлы.");
      } else {

        // проверяем возможность редактирования
        if (($filename != "") && !file_exists($this->files_path . "/" . $filename)) {
          $cancel = $this->push_error("Папка " . $this->files_path . "/" . $filename . " не существует. Необходимо указать существующую папку.");
        } else {

          // если это папка
          $url = $this->files_path . (($filename != "") ? "/" . $filename : "");
          if (is_dir($url)) {

            // проверяем наличие списка разрешенных по расширению файлов
            if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
              $cancel = $this->push_error("К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.");
            } else {

              // получаем отредактированные данные
              $request = array();
              if (isset($_POST)) {
                if (!isset($_POST[REQUEST_PARAM_NAME_CONTENT]) || !is_array($_POST[REQUEST_PARAM_NAME_CONTENT])) {
                  $cancel = $this->push_error("Не получены отредактированные данные.");
                } else {

                  // перебираем блоки данных
                  foreach ($_POST[REQUEST_PARAM_NAME_CONTENT] as $index => &$value) {
                    $name = substr($index, strlen($filename));
                    $name = $this->hdd->safeFilename($name);

                    // только если файл из этой же папки (остальные игнорируем)
                    if ($index == (($filename != "") ? $filename . "/" : "") . $name) {
                      $name = "/" . $name;

                      // проверяем вхождение файла в список разрешенных по расширению
                      $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                      if (($ext == "") || !in_array($ext, $this->files_extensions)) {
                        $cancel = $this->push_error("Файл " . $url . $name . " отклонен. Необходимо указать файл следующего расширения: " . implode(", ", $this->files_extensions) . ".");
                      } else {

                        // проверяем доступность файла для записи
                        if (!is_writable($url . $name)) {
                          $cancel = $this->push_error("Файл " . $url . $name . " отклонен. Его текущие атрибуты не позволяют перезапись файла.");
                        } else {

                          // считаем этот блок верным
                          if (!isset($request[$name])) $request[$name] = array();
                          $request[$name][REQUEST_PARAM_NAME_CONTENT] = is_string($value) ? rtrim($value) : "";
                        }
                      }
                    }
                  }
                }
              }

              // если имеются верные отредактированные данные
              if (!empty($request)) {

                // перебираем блоки данных
                foreach ($request as $name => &$value) {
                  if (isset($value[REQUEST_PARAM_NAME_CONTENT])) {

                    // записываем изменения в файл
                    if (!$handle = @fopen($url . $name, "rb+")) $handle = @fopen($url . $name, "wb");
                    if ($handle) {
                      flock($handle, LOCK_EX);
                      $value[REQUEST_PARAM_NAME_CONTENT] .= "\r\n";
                      $size = strlen($value[REQUEST_PARAM_NAME_CONTENT]);
                      fwrite($handle, $value[REQUEST_PARAM_NAME_CONTENT], $size);
                      ftruncate($handle, $size);
                      fclose($handle);
                    } else {
                      $cancel = $this->push_error("Не удалось открыть файл " . $url . $name . " для записи.");
                    }
                  }
                }
              }
            }

          // иначе это файл
          } else {
            $cancel = $this->push_error("Это не папка " . $url . ". Необходимо указать папку.");
          }
        }
      }

      // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
      return $cancel;
    }

    // удаление файла ==========================================================

    protected function delete ($file) {

      // удаляем файл
      unlink($file);
    }

    // создание псевдозаписи папки =============================================

    protected function folder_record ($path, $request = null) {

      // защищаем папку (с перезаписью защитных файлов)
      $this->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX, 0755, TRUE);
    }

    // создание псевдозаписи файла =============================================

    protected function file_record ($file, $request = null) {
    }

    // получение псевдозаписи файла ============================================

    protected function get_file ($file, &$data = null) {

      // читаем содержимое файла
      $data->content = "";
      if (file_exists($file)) {
        $data->content = file_get_contents($file);
        if ($data->content === FALSE) $data->content = "";
        $data->content = rtrim($data->content);
      }

      // берем заголовок файла
      $data->title = "";
      if (preg_match("'impera\scms:\s*(.+?)\.?\s*(\r|\n)'i", $data->content, $matches)) {
        $data->title = isset($matches[1]) ? trim($matches[1]) : "";
      } elseif (preg_match("'template\sname:\s*(.+?)\.?\s*(\r|\n)'i", $data->content, $matches)) {
        $data->title = isset($matches[1]) ? trim($matches[1]) : "";
      }

      // берем имена переменных
      $data->vars = array();
      $text = preg_replace("'\{\*.*?\*\}'is", "", $data->content);
      $text = preg_replace("'\{literal\}.*?\{/literal\}'is", "", $text);
      while (preg_match("'\{(.+?)\}'is", $text, $matches, PREG_OFFSET_CAPTURE) && isset($matches[0][0]) && isset($matches[0][1])) {
        $text = substr($text, $matches[0][1] + strlen($matches[0][0]));
        if (isset($matches[1][0])) {
          $line = $matches[1][0];
          while (preg_match("'\\\$[a-z][a-z0-9_]*((\.|->)[a-z][a-z0-9_]*)*'i", $line, $matches, PREG_OFFSET_CAPTURE) && isset($matches[0][0]) && isset($matches[0][1])) {
            $line = substr($line, $matches[0][1] + strlen($matches[0][0]));
            $matches = trim($matches[0][0]);
            $matches = trim(substr($matches, 1));
            if ($matches != "") $data->vars[strtolower($matches)] = $matches;
          }
        }
      }
      ksort($data->vars, SORT_STRING);
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

        // обрабатываем входные команды,
        // устанавливаем заголовок страницы
        $this->process();
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Файлы шаблона';


        if ($this->config->demo && (strtolower(substr($this->dynamic_theme, 0, 7)) != 'default')) {
            $this->push_error('В демо версии запрещен доступ к файлам других шаблонов, кроме начинающихся с default...');
        } else {

            // читаем список файлов
            $files = array();
            if (!$this->get_files($this->files_path, '', $files)) {
                $this->push_error('Не удалось открыть папку с файлами шаблона ' . $this->files_path);
            }
        }

        // передаем нужные данные в шаблонизатор,
        // создаем контент модуля
        $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $files);
        $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
        $this->body = $this->smarty->fetch(ADMIN_TEMPLATES_CLASS_TEMPLATE_FILE);

        return TRUE;
    }
  }



  return;
?>