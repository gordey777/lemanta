<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с текстовой базой данных
    *
    *  Такая база представляет собой текстовый файл (например расширения .tdb)
    *  со списком записей, где каждая располагается в отдельной строке по
    *  формату РазрешенаЛи|ИдЗаписи|ДатаСоздания|СериализацияПолей. Не
    *  удовлетворяющие формату строки или начинающиеся с комментария //
    *  (пробельные отступы перед ним допустимы), считаются посторонними и при
    *  обработке файла игнорируются.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2001, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class TextdbANYModel extends BasicANYModel {

        // общее число посторонних строк в начале последнего запроса
        public $remark_rows = 0;

        // общее число записей в начале последнего запроса
        public $total_rows = 0;

        // общее число записей последнего запроса
        public $found_rows = 0;

        // число внутрифреймовых записей последнего запроса
        public $affected_rows = 0;

        // число изменившихся записей последнего запроса
        public $changed_rows = 0;



        // ===================================================================
        /**
        *  Получение расширения имени файла базы данных
        *
        *  @access  public
        *  @return  string          расширение (в форме .ext)
        */
        // ===================================================================

        public function dbfileExtension () {
            return '.tdb';
        }



        // ===================================================================
        /**
        *  Получение маркера текущего времени
        *
        *  @access  public
        *  @return  string          маркер
        */
        // ===================================================================

        public function datetimeMarker () {
            return date('YmdHis', time());
        }



        // ===================================================================
        /**
        *  Преобразование html-текста в простой текст
        *
        *  @access  public
        *  @param   string  $text       текст
        *  @param   boolean $noCRLF     TRUE если переводы строк заменить пробелами
        *  @return  string              текст без разметки
        */
        // ===================================================================

        public function asPlainText ( $text, $noCRLF = TRUE ) {
            while (($new = preg_replace('~<[a-z/\?!][^>]*?>~i', ' ', $text)) != $text) $text = $new;
            while (($new = preg_replace('~<[a-z/\?!].*$~i', '', $text)) != $text) $text = $new;
            while (($new = preg_replace('/(--|\?)>/', ' ', $text)) != $text) $text = $new;
            $text = preg_replace($noCRLF ? '/[ \t\r\n\s]+/u' : '/[ \t]+/u', ' ', $text);
            return trim($text);
        }



        // ===================================================================
        /**
        *  Рассмотрение текста как URL
        *
        *  @access  public
        *  @param   string  $text       текст
        *  @return  string              URL или пустая строка, если это не URL
        */
        // ===================================================================

        public function asUrl ( $text ) {
            $text = $this->asPlainText($text);
            if (($pos = strpos($text, '#')) !== FALSE) $text = rtrim(substr($text, 0, $pos));
            if (!preg_match('!^([a-z]+:)?[/\\\\][^\s]+$!i', $text)) $text = '';
            return $text;
        }



        // ===================================================================
        /**
        *  Распаковка строкового представления записи
        *
        *  @access  public
        *  @param   string  $line   строковое представление
        *  @return  mixed           представление в виде массива или FALSE если это не запись
        */
        // ===================================================================

        public function unpack ( $line ) {
            try {
                if (!is_string($line)) return FALSE;
                $line = trim($line);
                if (substr($line, 0, 2) == '//') return FALSE;
                $line = explode('|', trim($line), 4);
                if (count($line) < 4) return FALSE;
                $enabled = $line[0] ? 1 : 0;
                $id = trim($line[1]);
                $created = trim($line[2]);
                $line = @ unserialize($line[3]);
                if (!is_array($line)) return FALSE;
                $line['id'] = $id;
                $line['enabled'] = $enabled;
                $line['created'] = $created;
                return $line;
            } catch (Exception $e) {
                return FALSE;
            }
        }



        // ===================================================================
        /**
        *  Упаковка массив-полевого представления записи
        *
        *  @access  public
        *  @param   array   $record     массив полей записи
        *  @return  mixed               строковое представление или FALSE если это не запись
        */
        // ===================================================================

        public function pack ( $record ) {
            try {
                if (!is_array($record) || empty($record)) return FALSE;
                $fields = array();
                foreach ($record as $key => & $value) {
                    switch ($key) {
                        case 'id':      $id = trim($value); break;
                        case 'enabled': $enabled = $value ? 1 : 0; break;
                        case 'created': $created = trim($value); break;
                        default: 
                            if (is_string($value)) {
                                $fields[$key] = trim($value);
                            } elseif (is_bool($value)) {
                                $fields[$key] = $value ? 1 : 0;
                            } elseif (is_float($value)) {
                                $fields[$key] = str_replace(',', '.', $value);
                            } elseif (is_null($value)) {
                                $fields[$key] = '';
                            } elseif (!is_resource($value)) {
                                $fields[$key] = $value;
                            }
                    }
                }
                if (empty($fields)) return FALSE;
                $fields = @ serialize($fields);
                if (!is_string($fields)) return FALSE;
                $record = array();
                $record[0] = isset($enabled) ? $enabled : 0;
                $record[1] = isset($id) && $id != '' ? $id : md5(uniqid(rand(), TRUE));
                $record[2] = isset($created) ? $created : $this->datetimeMarker();
                $record[3] = $fields;
                $record = implode('|', $record);
                $record = preg_replace('/[\x00-\x20]/', ' ', $record);
                return $record;
            } catch (Exception $e) {
                return FALSE;
            }
        }



        // ===================================================================
        /**
        *  Проверка записи на удовлетворение фильтра
        *
        *  @access  public
        *  @param   array   $record     запись (массив полей)
        *  @param   array   $filter     массив проверяемых полей
        *  @return  boolean             TRUE если подходит
        */
        // ===================================================================

        public function filter ( $record, $filter ) {
            try {
                if (!is_array($record)) return FALSE;
                if (!is_array($filter) || empty($filter)) return TRUE;
                foreach ($filter as $key => $value) {
                    if (!isset($record[$key])) return FALSE;
                    if ($record[$key] != $value) return FALSE;
                }
                return TRUE;
            } catch (Exception $e) {
                return FALSE;
            }
        }



        // ===================================================================
        /**
        *  Выправление имени базы до безопасного
        *
        *  @access  public
        *  @param   string  $dbname     имя базы
        *  @return  string              выправленное имя
        */
        // ===================================================================

        public function safeDbname ( $dbname ) {
            $dbname = str_replace('\\', '/', $dbname);
            $path = explode('/', $dbname);
            $dbname = '';
            foreach ($path as $folder) {
                $folder = rtrim(ltrim($folder), ". \r\n\t");
                $folder = $this->hdd->safeFilename($folder);
                if ($folder != '') {
                    if ($dbname != '') $dbname .= '/';
                    $dbname .= $folder;
                }
            }
            return $dbname;
        }



        // ===================================================================
        /**
        *  Проверка прав доступа администратора к модулю
        *
        *  @access  public
        *  @param   string  $module     имя проверяемого модуля
        *  @return  boolean             TRUE если имеет права
        */
        // ===================================================================

        public function checkAdminRights ( $module ) {
            $field = 'admin';
            return isset($_SESSION[$field]) && $_SESSION[$field] == 'admin';
        }



        // ===================================================================
        /**
        *  Сброс счетчиков статистики последнего запроса
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function resetCounters () {
            $this->remark_rows = 0;
            $this->total_rows = 0;
            $this->found_rows = 0;
            $this->affected_rows = 0;
            $this->changed_rows = 0;
        }



        // ===================================================================
        /**
        *  Проверка и создание базы данных
        *
        *  @access  public
        *  @param   array   $descriptor     описатель базы, содержит поля:
        *                                       dbname = имя базы
        *                                       folder = имя папки для файла базы
        *                                       hidden = TRUE если база размещена в http://сайт/admin
        *                                                FALSE если в папке http://сайт/files (по умолчанию FALSE)
        *                                       easy = TRUE если не проверять наличие файла базы
        *                                              FALSE если проверять наличие (по умолчанию FALSE)
        *  @return  boolean                 TRUE если база существует
        */
        // ===================================================================

        public function check ( $descriptor ) {

            $this->resetCounters();

            // превращаем имя базы в имя файла (с учетом доменного суффикса)
            $ok = FALSE;
            $dbname = isset($descriptor['dbname']) ? $descriptor['dbname'] : '';
            $dbname = $this->safeDbname($dbname);
            if ($dbname != '') {
                $dbname = $dbname . $this->settings->get('files_host_suffix', '') . $this->dbfileExtension();

                // обеспечиваем наличие папки для файла базы данных
                $folder = isset($descriptor['folder']) ? $descriptor['folder'] : '';
                $folder = $this->hdd->safeFilename($folder);
                if ($folder != '') {
                    $route = empty($descriptor['hidden']) ? 'files' : $this->hdd->safeFilename($this->cms->admin_folder);
                    $folder = ROOT_FOLDER_REFERENCE . $route . '/' . $folder . '/';
                    if ($ok = $this->hdd->createFolder($folder)) {

                        // могут быть и подпапки, нужно создать
                        $path = explode('/', $dbname);
                        array_pop($path);
                        $path = implode('/', $path);
                        if ($path == '' || $ok = $this->hdd->createFolder($folder . $path)) {

                            // создаем файл
                            if (empty($descriptor['easy'])) {
                                $dbname = $folder . $dbname;
                                if (!is_file($dbname)) {
                                    $handle = @ fopen($dbname, 'ab');
                                    if ($handle === FALSE) return FALSE;
                                    @ fclose($handle);
                                }
                            }
                        }
                    }
                }
            }
            return $ok;
        }



        // ===================================================================
        /**
        *  Извлечение записей базы данных
        *
        *  @access  public
        *  @param   array   $descriptor     описатель базы, содержит поля:
        *                                       dbname = имя базы
        *                                       folder = имя папки для файла базы
        *                                       hidden = TRUE если база размещена в http://сайт/admin
        *                                                FALSE если в папке http://сайт/files (по умолчанию FALSE)
        *  @param   array   $filter         настройки фильтра
        *  @param   integer $start          индекс первой извлекаемой записи
        *  @param   integer $count          число извлекаемых записей
        *  @return  array                   массив записей
        */
        // ===================================================================

        public function get ( $descriptor, $filter = array(), $start = 0, $count = 2000000000 ) {

            $this->resetCounters();

            // превращаем имя базы в имя файла (с учетом доменного суффикса)
            $items = array();
            $dbname = isset($descriptor['dbname']) ? $descriptor['dbname'] : '';
            $dbname = $this->safeDbname($dbname);
            if ($dbname != '') {
                $dbname = $dbname . $this->settings->get('files_host_suffix', '') . $this->dbfileExtension();

                // если файл базы данных открыт
                $folder = isset($descriptor['folder']) ? $descriptor['folder'] : '';
                $folder = $this->hdd->safeFilename($folder);
                if ($folder != '') {
                    $route = empty($descriptor['hidden']) ? 'files' : $this->hdd->safeFilename($this->cms->admin_folder);
                    $folder = ROOT_FOLDER_REFERENCE . $route . '/' . $folder . '/';
                    $dbname = $folder . $dbname;
                    if ($this->hdd->isReadableFile($dbname)) {
                        $handle = @ fopen($dbname, 'rb');
                        if ($handle !== FALSE) {

                            // извлекаем записи
                            @ flock($handle, LOCK_EX);
                            while (!feof($handle)) {
                                $line = @ fgets($handle, 8 * 1024 * 1024);
                                if ($line === FALSE) break;
                                $line = $this->unpack($line);
                                if (!empty($line)) {
                                    $this->total_rows++;
                                    if ($this->filter($line, $filter)) {
                                        $this->found_rows++;
                                        if ($start > 0) {
                                            $start--;
                                            continue;
                                        }
                                        if ($count > 0) {
                                            $this->affected_rows++;
                                            $items[] = $line;
                                            $count--;
                                        }
                                    }
                                } else {
                                    $this->remark_rows++;
                                }
                            }
                            @ fclose($handle);
                        }
                    }
                }
            }
            return $items;
        }



        // ===================================================================
        /**
        *  Добавление записи в базу данных
        *
        *  @access  public
        *  @param   array   $descriptor     маршрутизатор, содержит поля:
        *                                       dbname = имя базы
        *                                       folder = имя папки для файла базы
        *                                       columns = массив возможных имен полей записи
        *                                       hidden = TRUE если база размещена в http://сайт/admin
        *                                                FALSE если в папке http://сайт/files (по умолчанию FALSE)
        *  @param   array   $record         массив полей записи
        *  @return  boolean                 TRUE если добавлена
        */
        // ===================================================================

        public function add ( $descriptor, $record ) {

            // упаковываем поля записи
            $result = FALSE;
            $columns = isset($descriptor['columns']) ? $descriptor['columns'] : FALSE;
            if (!empty($columns) && is_array($columns)) {
                if (is_array($record)) {
                    foreach ($record as $key => $value) {
                        if (!in_array($key, $columns)) unset($record[$key]);
                    }
                    $record = $this->pack($record);
                    if (!empty($record)) {

                        // превращаем имя базы в имя файла (с учетом доменного суффикса)
                        $dbname = isset($descriptor['dbname']) ? $descriptor['dbname'] : '';
                        $dbname = $this->safeDbname($dbname);
                        if ($dbname != '') {
                            $dbname = $dbname . $this->settings->get('files_host_suffix', '') . $this->dbfileExtension();

                            // если файл базы данных открыт
                            $folder = isset($descriptor['folder']) ? $descriptor['folder'] : '';
                            $folder = $this->hdd->safeFilename($folder);
                            if ($folder != '') {
                                $route = empty($descriptor['hidden']) ? 'files' : $this->hdd->safeFilename($this->cms->admin_folder);
                                $folder = ROOT_FOLDER_REFERENCE . $route . '/' . $folder . '/';
                                $dbname = $folder . $dbname;
                                $handle = @ fopen($dbname, !is_file($dbname) ? 'ab' : 'rb+');
                                if ($handle !== FALSE) {

                                    // добавляем запись (в начало файла)
                                    @ flock($handle, LOCK_EX);
                                    $record .= "\r\n";
                                    $size = strlen($record);
                                    $offsetR = 0;
                                    $offsetW = 0;
                                    do {
                                        @ fseek($handle, $offsetR, SEEK_SET);
                                        $block = @ fread($handle, $size < 65536 ? 65536 : $size);
                                        @ fseek($handle, $offsetW, SEEK_SET);
                                        if ($size != @ fwrite($handle, $record, $size)) break;
                                        $offsetW += $size;
                                        $record = $block;
                                        $size = strlen($record);
                                        $offsetR += $size;
                                    } while (is_string($block) && $size != 0);
                                    @ fclose($handle);
                                    $result = TRUE;
                                }
                            }
                        }
                    }
                }
            }
            return $result;
        }



        // ===================================================================
        /**
        *  Обновление записи в базе данных
        *
        *  @access  public
        *  @param   array   $descriptor     маршрутизатор, содержит поля:
        *                                       dbname = имя базы
        *                                       folder = имя папки для файла базы
        *                                       columns = массив возможных имен полей записи
        *                                       hidden = TRUE если база размещена в http://сайт/admin
        *                                                FALSE если в папке http://сайт/files (по умолчанию FALSE)
        *  @param   array   $record         массив полей записи:
        *                                       id = идентификатор обновляемой записи
        *                                       ... = изменяемые поля
        *  @return  boolean                 TRUE если обновлена
        */
        // ===================================================================

        public function update ( $descriptor, $record ) {
            // пока метод не поддерживается
            return FALSE;
        }



        // ===================================================================
        /**
        *  Удаление записи из базы данных
        *
        *  @access  public
        *  @param   array   $descriptor     маршрутизатор, содержит поля:
        *                                       dbname = имя базы
        *                                       folder = имя папки для файла базы
        *                                       hidden = TRUE если база размещена в http://сайт/admin
        *                                                FALSE если в папке http://сайт/files (по умолчанию FALSE)
        *  @param   array   $record         массив полей записи:
        *                                       id = идентификатор удаляемой записи
        *  @return  boolean                 TRUE если обновлена
        */
        // ===================================================================

        public function delete ( $descriptor, $record ) {
            // пока метод не поддерживается
            return FALSE;
        }
    }



    return;
?>