<?php
  // Impera CMS: модуль внешнего вызова варианта импорта.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  // так как модуль работает на внешний вызов, блокируем любые сообщения о программных ошибках
  error_reporting(0);

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/Admin.Imports.php');

  // =========================================================================
  // Класс ClientImport (модуль внешнего вызова варианта импорта)
  //
  // Использование этого класса происходит в результате переназначения класса
  // Import на данный класс во время загрузки модуля внешнего вызова импорта.
  // =========================================================================

  class ClientImport extends Basic {

    // создание контента модуля ==============================================

    public function fetch (&$parent = null) {

      // будем возвращать страницу как обычный текст
      header('Content-Type: text/plain');

      // читаем из входных параметров url варианта импорта
      $url = $this->request->getGetAsSentence('url');
      if (!empty($url)) {

        // читаем данные варианта импорта из базы данных
        $params = new stdClass;
        $params->url = $url;
        $params->enabled = 1;
        $this->db->imports->one($item, $params);

        // проверяем право вызова такого варианта импорта
        if (!empty($item)) {
          if (($item->password == "") || (isset($_REQUEST["password"]) && ($_REQUEST["password"] == $item->password))) {

            // если вариант не занят (не выполняется в настоящий момент)
            $now = time();
            $start = strtotime($item->lastused) + IMPORT_CRASH_RESTORE_LIFETIME;
            if (($item->busy != 1) || ($now > $start)) {

              $item->format = strtolower(trim($item->format));
              $item->columns = trim($item->columns);
              if (($item->format != "") && ($item->columns != "") && ($item->delimiter != "")) {
                
                // читаем из входных параметров признак запроса сведений о варианте импорта
                $info = $this->param(REQUEST_PARAM_NAME_IMPORT_INFO) == 1;
                if ($info) {
                  // сообщаем вызывающему сведения о варианте импорта
                  echo "INFO\r\n"
                     . "COLUMNS " . $item->columns . "\r\n"
                     . "FORMAT " . $item->format . "\r\n"
                     . "DELIMITER " . $item->delimiter;
                } else {

                  if (!$this->config->demo) {
                    if (isset($_REQUEST["lines"])) {
                      // делаем импорт
                      $import = new Imports($parent = null);
                      $import->remote_import($item);
                      // сообщаем вызывающему об успехе
                      echo "OK";
                    } else {
                      // сообщаем вызывающему об ошибке (нет данных для импорта)
                      echo "ERROR No array named \"lines\" in request";
                    }
                  } else {
                    // сообщаем вызывающему об ошибке (в демо версии вызов отклоняется)
                    echo "ERROR Demo mode";
                  }
                }

              } else {
                // сообщаем вызывающему об ошибке (в варианте импорта существуют неточности)
                echo "ERROR Technical problem";
              }
            } else {
              // сообщаем вызывающему об ошибке (вариант импорта сейчас занят)
              echo "ERROR Busy now. Try past " . date("Y-m-d H:i:s", $start);
            }
          } else {
            // сообщаем вызывающему об ошибке (неверный пароль доступа)
            echo "ERROR Bad authentication";
          }
        } else {
          // сообщаем вызывающему об ошибке (нет такой точки вызова или она запрещена)
          echo "ERROR No such URL";
        }
      } else {
        // сообщаем вызывающему об ошибке (не указан адрес точки вызова)
        echo "ERROR Please specify URL";
      }

      // останавливаемся (этот модуль самостоятельный)
      exit;
    }
  }



  return;
?>