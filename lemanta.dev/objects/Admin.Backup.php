<?php
  // Impera CMS: админ модуль резервных копий,
  //             админ модуль редиректов страниц.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once("pclzip/pclzip.lib.php");

  // какой файл является шаблоном модуля резервных копий,
  // какой файл является шаблоном модуля редиректов страниц
  define("ADMIN_BACKUP_CLASS_TEMPLATE_FILE", "admin_backup.htm");
  define("ADMIN_REDIRECTS_CLASS_TEMPLATE_FILE", "admin_redirects.htm");

  // имя файла дампа таблиц базы данных
  define('ADMIN_BACKUP_CLASS_DATABASE_DUMP_FILE1', 'impera_database_dump.sql');

  // имя файла дампа таблиц базы данных (если переходят с другого движка)
  // TODO: устарело, вынести в модуль миграции
  define('ADMIN_BACKUP_CLASS_DATABASE_DUMP_FILE2', 'simpla.sql');

  // транзитная переменная "массив игнорируемых путей при запаковке"
  $backup_ignored_paths = array();

  // контрольная функция пред запаковки файла ================================

  function myPreAddCallBack ($event, &$header) {

    // ссылаемся на глобальные переменные
    global $backup_ignored_paths;

    // берем имя запаковываемого файла
    $result = 0;
    $filename = isset($header["filename"]) ? strtolower(trim($header["filename"])) : "";
    if ($filename != "") {

      // проверяем, что его не запретили паковать
      $result = 1;
      if (is_array($backup_ignored_paths) && !empty($backup_ignored_paths)) {
        foreach ($backup_ignored_paths as &$item) {
          if (!is_string($item)) $item = "";
          $item = strtolower(trim($item));
          if ($item != "") {
            $result = (strpos($filename, $item) === 0) ? 0 : 1;
            if ($result == 0) break;
          }
        }
      }
    }

    // возвращаем ПОЗВОЛИТЬ / ИГНОРИРОВАТЬ
    return $result;
  }

  // контрольная функция пост распаковки файла ===============================

  function myPostExtractCallBack ($event, &$header) {

    // какой результат распаковки?
    if (isset($header["status"])) {
      $status = strtolower(trim($header["status"]));
      switch ($status) {

        // если успешная распаковка
        case "ok":
          $file = isset($header["filename"]) ? trim($header["filename"]) : "";
          if ($file != "") {

            // устанавливаем типичные права доступа
            $path_info = pathinfo($file);
            $ext = isset($path_info["extension"]) ? $path_info["extension"] : "";
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

        // если ошибка
        case "write_protected":
        case "write_error":
        case "error":
        case "path_creation_fail":
          break;
      }
    }

    // возвращаем ПОЗВОЛИТЬ
    return 1;
  }



  // =========================================================================
  // Класс Backup (админ модуль резервных копий)
  // =========================================================================

  class Backup extends Basic {



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
    }



    // обработка входных параметров и команд =================================

    protected function process () {

      // ссылаемся на глобальные переменные
      global $backup_ignored_paths;

      // определяем имена папок
      $backup_folder = "backups" . $this->settings->files_host_suffix;
      $temp_folder = "temp";
      $files_folder = $this->settings->products_files_folder_prefix . "files";

      // пока нет отмены перенаправления на страницу возврата
      $cancel = FALSE;

      // читаем входной параметр ITEMID - имя оперируемого файла,
      // параметр FROM - на какую страницу вернуться после операции,
      // параметр ACTION - какую команду требовали сделать
      $filename = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

      // если действительно передали имя оперируемого файла
      // или это команда "Создать резервную копию"
      // или это команда "Загрузить резервную копию"
      if (($filename != "") || ($act == ACTION_REQUEST_PARAM_VALUE_CREATE) || ($act == ACTION_REQUEST_PARAM_VALUE_DOWNLOAD)) {

        // какую команду требовали сделать во входном параметре ACTION?
        switch ($act) {

          // если команду "Удалить резервную копию"
          case ACTION_REQUEST_PARAM_VALUE_DELETE:

            // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
            $this->check_token();

            if ($this->config->demo) {
              $cancel = $this->push_error("В демо версии запрещено совершать удаление резервных копий.");
            } else {

              // удаляем файл
              $filename = $backup_folder . "/" . $this->hdd->safeFilename($filename);
              if (pathinfo($filename, PATHINFO_EXTENSION) != "zip") {
                $cancel = $this->push_error("Необходимо указать архивный файл в формате ZIP.");
              } else {
                if (!is_writable($filename)) {
                  $cancel = $this->push_error("Текущие атрибуты этого файла не позволяют удалить его.");
                } else {
                  unlink($filename);
                  $filename = substr($filename, 0, -3) . "txt";
                  if (file_exists($filename)) unlink($filename);
                }
              }
            }
            break;

          // если команду "Создать резервную копию"
          case ACTION_REQUEST_PARAM_VALUE_CREATE:

            // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
            $this->check_token();

            if ($this->config->demo) {
              $cancel = $this->push_error("В демо версии запрещено создавать резервные копии.");
            } else {

              // проверяем возможность запаковки
              if (!is_writable($backup_folder)) {
                $cancel = $this->push_error("Текущие атрибуты папки http://" . $this->root_url . "/" . $this->admin_folder . "/" . $backup_folder . " не позволяют запись в нее.");
              } else {
                if (!is_writable($temp_folder)) {
                  $cancel = $this->push_error("Текущие атрибуты временной папки http://" . $this->root_url . "/" . $this->admin_folder . "/" . $temp_folder . " не позволяют запись в нее.");
                } else {

                  // разрешаем выполнить скрипт до конца (не обращать внимание на возможный разрыв соединения с пользователем),
                  // снимаем ограничение на время выполнения скрипта
                  @ignore_user_abort(TRUE);
                  @set_time_limit(0);

                  // ставим на сайте вывеску "Обновление информации"
                  $this->putup_UPDATING_WORKS_INFO(TRUE);

                  // делаем дамп таблиц базы данных
                  $filename = $backup_folder . "/backup_" . date("Y_m_d_G-i-s") . ".zip";
                  $dump = $temp_folder . "/" . ADMIN_BACKUP_CLASS_DATABASE_DUMP_FILE1;
                  @$this->db->mysqldump($dump);

                  // задаем список неупаковываемых путей
                  $backup_ignored_paths = array("../" . $this->admin_folder . "/" . $backup_folder . "/");

                  // начинаем создание резервной копии
                  $zip = new PclZip($filename);

                  // упаковываем папку с картинками
                  $result = $zip->create("../" . $files_folder, PCLZIP_OPT_REMOVE_PATH, "../", PCLZIP_CB_PRE_ADD, "myPreAddCallBack");
                  if ($result == 0) {
                    $cancel = $this->push_error("Не удалось запаковать ". $zip->errorInfo(TRUE));
                    if (file_exists($filename)) unlink($filename);
                  } else {

                    // упаковываем дамп таблиц базы данных
                    $result = $zip->add($dump, PCLZIP_OPT_REMOVE_PATH, $temp_folder . "/");
                    if ($result == 0) {
                      $cancel = $this->push_error("Не удалось запаковать файл копии базы данных " . $zip->errorInfo(TRUE));
                      if (file_exists($filename)) unlink($filename);
                    } else {

                      // добавляем описание резервной копии
                      $filename = substr($filename, 0, -3) . "txt";
                      $description = trim($this->param(REQUEST_PARAM_NAME_DESCRIPTION));
                      $description = $this->text->stripTags($description);
                      file_put_contents($filename, $description);
                    }
                  }

                  // удаляем дамп таблиц базы данных
                  if (file_exists($dump)) unlink($dump);

                  // снимаем вывеску "Обновление информации"
                  $this->putup_UPDATING_WORKS_INFO(FALSE);
                }
              }
            }
            break;

          // если команду "Восстановить резервную копию"
          case ACTION_REQUEST_PARAM_VALUE_RESTORE:

            // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
            $this->check_token();

            // проверяем возможность распаковки
            $filename = $this->hdd->safeFilename($filename);
            $ignore_files = isset($_REQUEST["ignore_files"]) && is_array($_REQUEST["ignore_files"]) && isset($_REQUEST["ignore_files"][$filename]) ? ($_REQUEST["ignore_files"][$filename] == 1) : FALSE;
            $ignore_database = isset($_REQUEST["ignore_database"]) && is_array($_REQUEST["ignore_database"]) && isset($_REQUEST["ignore_database"][$filename]) ? ($_REQUEST["ignore_database"][$filename] == 1) : FALSE;
            $archive = $backup_folder . "/" . $filename;
            if (!is_readable($archive)) {
              $cancel = $this->push_error("Файл резервной копии не найден или его текущие атрибуты не позволяют открывать файл.");
            } else {
              if (!is_writable($temp_folder)) {
                $cancel = $this->push_error("Текущие атрибуты временной папки http://" . $this->root_url . "/" . $this->admin_folder . "/" . $temp_folder . " не позволяют запись в нее.");
              } else {
                if (!$ignore_files && !is_writable("../" . $files_folder)) {
                  $cancel = $this->push_error("Текущие атрибуты папки http://" . $this->root_url . "/" . $files_folder . " не позволяют запись в нее.");
                } else {

                  // проверяем что нужно пропускать
                  if ($ignore_files && $ignore_database) {
                    $cancel = $this->push_error("При таком выборе нет данных для восстановления.");
                  } else {

                    // разрешаем выполнить скрипт до конца (не обращать внимание на возможный разрыв соединения с пользователем),
                    // снимаем ограничение на время выполнения скрипта
                    @ignore_user_abort(TRUE);
                    @set_time_limit(0);

                    // ставим на сайте вывеску "Обновление информации"
                    $this->putup_UPDATING_WORKS_INFO(TRUE);

                    // начинаем распаковку резервной копии
                    $zip = new PclZip($archive);

                    // распаковываем папку с картинками
                    if (!$ignore_files) $this->clean_dir("../" . $files_folder);
                    if (!$ignore_files && !$zip->extract(PCLZIP_OPT_PATH, "../",
                                                         PCLZIP_OPT_BY_PREG, "'^" . preg_replace("'([^a-z0-9_\s\-/])'i", "\\\$1", $files_folder) . "/'",
                                                         PCLZIP_CB_POST_EXTRACT, "myPostExtractCallBack")) {
                      $cancel = $this->push_error("Не удалось распаковать " . $zip->errorInfo(TRUE));
                    } else {

                      // распаковываем дамп таблиц базы данных
                      if (!$ignore_database) {
                        $dump = ADMIN_BACKUP_CLASS_DATABASE_DUMP_FILE1;
                        if (!$zip->extract(PCLZIP_OPT_PATH, $temp_folder . "/",
                                           PCLZIP_OPT_BY_NAME, $dump,
                                           PCLZIP_OPT_REMOVE_ALL_PATH)) {
                          $dump = ADMIN_BACKUP_CLASS_DATABASE_DUMP_FILE2;
                          if (!$zip->extract(PCLZIP_OPT_PATH, $temp_folder . "/",
                                             PCLZIP_OPT_BY_NAME, $dump,
                                             PCLZIP_OPT_REMOVE_ALL_PATH)) {
                            $cancel = $this->push_error("Не удалось распаковать файл копии базы данных.");
                          }
                        }

                        // если нет ошибок
                        if (!$cancel) {
                          $dump = $temp_folder . "/" . $dump;
                          if (!is_readable($dump)) {
                            $cancel = $this->push_error("Не удалось прочитать файл http://" . $this->root_url . "/" . $this->admin_folder . "/" . $dump);
                          } else {

                            // восстанавливаем базу данных
                            @$this->db->mysqlrestore($dump);
                          }

                          // удаляем дамп таблиц базы данных
                          if (file_exists($dump)) unlink($dump);
                        }
                      }
                    }

                    if (!$cancel) $this->info_msg = "Затребованные данные из резервной копии " . $filename . " восстановлены.";

                    // очищаем папки скомпилированного шаблона клиентской стороны и админпанели
                    $this->smarty->clearCompiledFolder(TRUE);
                    $this->smarty->clearCompiledFolder(FALSE);

                    // снимаем вывеску "Обновление информации"
                    $this->putup_UPDATING_WORKS_INFO(FALSE);
                  }
                }
              }
            }
            break;

          // если команду "Загрузить резервную копию"
          case ACTION_REQUEST_PARAM_VALUE_DOWNLOAD:

            // если загружают резервную копию
            if (isset($_FILES["backup"])) {

              // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
              $this->check_token();

              if ($this->config->demo) {
                $cancel = $this->push_error("В демо версии запрещено совершать загрузку своих резервных копий.");
              } else {

                // пробуем принять файл
                $filename = isset($_FILES["backup"]["name"]) ? $_FILES["backup"]["name"] : "";
                $filename = $this->hdd->safeFilename($filename);
                if (isset($_FILES["backup"]["tmp_name"]) && ($_FILES["backup"]["tmp_name"] != "") && (!isset($_FILES["backup"]["error"]) || ($_FILES["backup"]["error"] == UPLOAD_ERR_OK))) {
                  if (pathinfo($filename, PATHINFO_EXTENSION) != "zip") {
                    $cancel = $this->push_error("Недопустимый тип загружаемой резервной копии. Принимаются только архивные файлы в формате ZIP.");
                  } else {
                    $filename = $backup_folder . "/" . $filename;
                    if (!move_uploaded_file($_FILES["backup"]["tmp_name"], $filename)) {
                      $cancel = $this->push_error("Не удалось загрузить файл.");
                    } else {

                      // добавляем описание резервной копии
                      $filename = substr($filename, 0, -3) . "txt";
                      $description = rtrim($this->param(REQUEST_PARAM_NAME_DESCRIPTION));
                      $description = $this->text->stripTags($description);
                      file_put_contents($filename, $description);
                    }
                  }

                // иначе была ошибка при передаче файла
                } else {
                  switch ($_FILES["backup"]["error"]) {
                    case UPLOAD_ERR_INI_SIZE:
                      $cancel = $this->push_error("Размер принятого файла \"" . $filename . "\" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.");
                      break;
                    case UPLOAD_ERR_FORM_SIZE:
                      $cancel = $this->push_error("Размер загружаемого файла \"" . $filename . "\" превышает максимально допустимое значение" . (isset($_POST["MAX_FILE_SIZE"]) ? " " . trim($_POST["MAX_FILE_SIZE"]) . " байт" : "") . ".");
                      break;
                    case UPLOAD_ERR_PARTIAL:
                      $cancel = $this->push_error("Загрузка файла \"" . $filename . "\" прервалась и он был получен не весь.");
                      break;
                    case UPLOAD_ERR_NO_FILE:
                      $cancel = $this->push_error("Не получен файл \"" . $filename . "\".");
                      break;
                    default:
                      $cancel = $this->push_error("Произошла неизвестная ошибка при попытке загрузить файл \"" . $filename . "\".");
                  }
                }
              }
            } else {
              $cancel = $this->push_error("Не указан загружаемый файл.");
            }
            break;
        }
      }

      // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
      if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
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
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Резервные копии";

      // получаем список резервных копий (по порядку их размещения на сайте)
      $backups = array();
      $files = glob("backups" . $this->settings->files_host_suffix . "/*.zip", GLOB_NOSORT);
      if (!empty($files)) {

        // добавляем в элементы списка оперативные ссылки админпанели
        foreach ($files as &$item) {
          $file = basename($item);
          $record = new stdClass;
          $record->file = $file;
          $record->size = filesize($item);
          $record->date = date("Y-m-d H:i:s", filectime($item));
          $item = substr($item, 0, -3) . "txt";
          if (file_exists($item)) {
            $record->description = file_get_contents($item);
            if ($record->description !== FALSE) {
              $record->description = $this->text->stripTags($record->description);
              $record->description = str_replace("\r\n", "<br>", $record->description);
            }
          }
          $record->delete_get = $this->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_DELETE,
                                                      REQUEST_PARAM_NAME_ITEMID => $file,
                                                      REQUEST_PARAM_NAME_TOKEN => $this->token));
          $record->restore_get = $this->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_RESTORE,
                                                       REQUEST_PARAM_NAME_ITEMID => $file,
                                                       REQUEST_PARAM_NAME_TOKEN => $this->token));
          $backups[] = $record;
        }

        // переворачиваем список резервных копий (недавно размещавшиеся наверх)
        $backups = array_reverse($backups);
      }

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $backups);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_BACKUP_CLASS_TEMPLATE_FILE);
    }
  }



  // =========================================================================
  // Класс Redirects (админ модуль редиректов страниц)
  // =========================================================================

  class Redirects extends Basic {



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
    }



    // обработка входных параметров и команд =================================

    protected function process () {

      // если получены данные об изменениях
      if (isset($_POST[REQUEST_PARAM_NAME_POST]) && $_POST[REQUEST_PARAM_NAME_POST]
      && isset($_POST["lines"]) && is_array($_POST["lines"])) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        if ($this->config->demo) {
          return $this->push_error("В демо версии запрещено редактировать редиректы страниц.");
        }

        // если удалось создать / перезаписать файл редиректов
        $file = str_replace("*", $this->settings->files_host_suffix, FILENAME_FOR_REDIRECTS_INFO);
        if ($handle = @fopen(ROOT_FOLDER_REFERENCE . $file, "wb")) {
          flock($handle, LOCK_EX);

          // цикл по измененным записям
          $count = 0;
          foreach ($_POST["lines"] as &$line) {

            // если использование записи не отменено
            if (isset($line["used"]) && $line["used"]) {
              $record = array();

              // если запись не пустая
              $record[field_REDIRECT_FROM_URL] = isset($line["url"]) ? trim($line["url"]) : "";
              if ($record[field_REDIRECT_FROM_URL] != "") {

                // если это строка редиректа
                $record[field_REDIRECT_TYPE] = isset($line["type"]) ? intval($line["type"]) : null;
                if (!is_null($record[field_REDIRECT_TYPE])) {

                  // готовим запись
                  $record[field_REDIRECT_ENABLED] = isset($line["enabled"]) && $line["enabled"] ? 1 : 0;
                  $record[field_REDIRECT_REMOVE_QUERYPARAMS] = isset($line["unquery"]) && $line["unquery"] ? 1 : 0;
                  $record[field_REDIRECT_USE_REGEXP] = isset($line["regexp"]) && $line["regexp"] ? 1 : 0;
                  $record[field_REDIRECT_TO_URL] = isset($line["to_url"]) ? trim($line["to_url"]) : "";
                  switch ($record[field_REDIRECT_TYPE]) {
                    case 403:
                    case 404:
                    case 410:
                      break;
                    case 301:
                    default:
                      $record[field_REDIRECT_TYPE] = 301;
                  }
                  ksort($record, SORT_NUMERIC);
                  $record = implode(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, $record) . "\r\n";

                // иначе это строка раздела (комментария)
                } else {
                  $record = $record[field_REDIRECT_FROM_URL] . "\r\n";
                }

                // добавляем строку в файл редиректов (не более предельного количества)
                fwrite($handle, $record, strlen($record));
                $count++;
                if ($count >= REDIRECT_RECORDS_MAXCOUNT) break;
              }
            }
          }

          // закрываем файл
          fclose($handle);
          $this->push_info("Записи о редиректах страниц в количестве " . $count . " строк успешно сохранены в файле " . $file . ".");

          // установить странице фоновый звук УСПЕХ
          $this->success_bgsound();

        // иначе не удалось создать файл
        } else {
          return $this->push_error("Не удалось создать / перезаписать файл " . $file . ", где хранятся сведения о редиректах страниц.");
        }
      }
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
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Редиректы страниц";

      // получить записи о редиректах для текущего магазина
      globalCheckRedirects("", $this->settings->files_host_suffix, $items);

      // передаем нужные данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_REDIRECTS_CLASS_TEMPLATE_FILE);
    }
  }



  return;
?>