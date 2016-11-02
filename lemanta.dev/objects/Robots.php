<?php
    // Impera CMS: модуль обработки файлов robots[_домен].txt на клиентской стороне.
    // Copyright AIMatrix, 2011.
    // http://aimatrix.itak.info

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;



    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);



    // минимальное содержимое файлов robots[_домен].txt
    define('CLIENT_ROBOTS_FILE_MINIMAL_CONTENT', "User-agent: *\r\n");



    // =========================================================================
    // Класс ClientRobots (модуль обработки файлов robots[_домен].txt на клиентской стороне)
    //
    // Использование этого класса происходит в результате переназначения класса
    // Robots на данный класс во время загрузки модуля обработки файлов robots[_домен].txt.
    // =========================================================================

    class ClientRobots extends Basic {



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

            // конструируем объект
            parent::__construct($parent);

            // проверяем наличие файла robots[_домен].txt (если нет, будет автоматически создан)
            $this->check_robots_file();
        }



        // проверка наличия файла robots[_домен].txt =============================

        private function check_robots_file () {

            // пытаемся найти файл robots[_домен].txt
            $filename = ROOT_FOLDER_REFERENCE . 'robots' . $this->settings->files_host_suffix . '.txt';
            if (@ !file_exists($filename)) {

                // если не найден, пробуем создать и записать в него минимальное содержимое
                if (!$handle = @ fopen($filename, 'wb')) {
                    @ flock($handle, LOCK_EX);
                    @ fwrite($handle, CLIENT_ROBOTS_FILE_MINIMAL_CONTENT);
                    @ fclose($handle);

                    // ставим файлу полные права доступа любому пользователю сервера
                    @ chmod($filename, 0666);
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

            // будем возвращать страницу как обычный текст
            header('Content-Type: text/plain');

            // если файл не найдется или не откроется, возвратим минимальное содержимое
            $this->body = CLIENT_ROBOTS_FILE_MINIMAL_CONTENT;

            // пытаемся открыть файл robots[_домен].txt, при отсутствии пробуем открыть robots.txt
            $filename = ROOT_FOLDER_REFERENCE . 'robots' . $this->settings->files_host_suffix . '.txt';
            if (!$handle = @ fopen($filename, 'rb')) $handle = @ fopen(ROOT_FOLDER_REFERENCE . 'robots.txt', 'rb');

            // если файл открыт, берем его содержимое
            if ($handle) {
                @ flock($handle, LOCK_EX);
                $this->body = '';
                while (@ !feof($handle)) {
                    $string = @ fgets($handle, 65536);
                    if ($string === FALSE) break;
                    $this->body .= rtrim($string) . "\r\n";
                }
                @ fclose($handle);
            }

            // выводим контент модуля,
            // останавливаемся (этот модуль самостоятельный)
            echo $this->body;
            exit;
        }
    }



    return;
?>