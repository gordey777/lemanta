<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с файлами
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class HddANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Получение имени папки из полного имени файла
        *
        *  @access  public
        *  @param   string  $filename   имя файла
        *  @return  string              имя папки (завершенное /)
        */
        // ===================================================================

        public function getDirname ( $filename ) {
            $dir = dirname($filename);
            return $this->closeSlash($dir);
        }



        // ===================================================================
        /**
        *  Завершение имени папки слешем
        *
        *  @access  public
        *  @param   string  $folder     имя папки
        *  @return  string              имя папки (завершенное /)
        */
        // ===================================================================

        public function closeSlash ( $folder ) {
            return rtrim(ltrim($folder, " \t\r\n"), " \t\r\n/\\") . '/';
        }



        // ===================================================================
        /**
        *  Признак доступной для чтения папки
        *
        *  @access  public
        *  @param   string  $folder     имя папки
        *  @return  boolean             TRUE если доступна
        */
        // ===================================================================

        public function isReadableFolder ( $folder ) {
            return $folder != '' && is_dir($folder) && is_readable($folder);
        }



        // ===================================================================
        /**
        *  Признак доступной для записи папки
        *
        *  @access  public
        *  @param   string  $folder     имя папки
        *  @return  boolean             TRUE если доступна
        */
        // ===================================================================

        public function isWritableFolder ( $folder ) {
            return $folder != '' && is_dir($folder) && is_writable($folder);
        }



        // ===================================================================
        /**
        *  Признак доступного для чтения файла
        *
        *  @access  public
        *  @param   string  $filename   имя файла
        *  @return  boolean             TRUE если доступен
        */
        // ===================================================================

        public function isReadableFile ( $filename ) {
            return $filename != '' && is_file($filename) && is_readable($filename);
        }



        // ===================================================================
        /**
        *  Признак доступного для записи файла
        *
        *  @access  public
        *  @param   string  $filename   имя файла
        *  @return  boolean             TRUE если доступен
        */
        // ===================================================================

        public function isWritableFile ( $filename ) {
            return $filename != ''
                && (!file_exists($filename) || !is_file($filename) || is_writable($filename));
        }



        // ===================================================================
        /**
        *  Получение строки с правами доступа к файлу / папке
        *
        *  @access  public
        *  @param   string  $file       имя файла
        *  @param   string  $separator  текст разрядки (отступов) блоков прав
        *  @return  string              строка с правами доступа
        */
        // ===================================================================

        public function getFilePermissions ( $file, $separator = '' ) {

            // получаем права файла / папки
            $result = '';
            $rights = @ fileperms($file);
            if ($rights !== FALSE) {

                // получаем знак типа
                if (($rights & 0xC000) == 0xC000) $result = 's';        // сокет
                elseif (($rights & 0xA000) == 0xA000) $result = 'l';    // символическая ссылка
                elseif (($rights & 0x8000) == 0x8000) $result = '-';    // обычный
                elseif (($rights & 0x6000) == 0x6000) $result = 'b';    // специальный блок
                elseif (($rights & 0x4000) == 0x4000) $result = 'd';    // папка
                elseif (($rights & 0x2000) == 0x2000) $result = 'c';    // специальный символ
                elseif (($rights & 0x1000) == 0x1000) $result = 'p';    // поток FIFO
                else $result = 'u';                                     // неизвестный

                // получаем знаки прав владельца
                $result .= $separator;
                $result .= $rights & 0x0100 ? 'r' : '-';
                $result .= $rights & 0x0080 ? 'w' : '-';
                $result .= $rights & 0x0040 ? ($rights & 0x0800 ? 's' : 'x') : ($rights & 0x0800 ? 'S' : '-');

                // получаем знаки прав группы, как у владельца
                $result .= $separator;
                $result .= $rights & 0x0020 ? 'r' : '-';
                $result .= $rights & 0x0010 ? 'w' : '-';
                $result .= $rights & 0x0008 ? ($rights & 0x0400 ? 's' : 'x') : ($rights & 0x0400 ? 'S' : '-');

                // получаем знаки прав остальных пользователей
                $result .= $separator;
                $result .= $rights & 0x0004 ? 'r' : '-';
                $result .= $rights & 0x0002 ? 'w' : '-';
                $result .= $rights & 0x0001 ? ($rights & 0x0200 ? 't' : 'x') : ($rights & 0x0200 ? 'T' : '-');
            }
            return $result;
        }



        // ===================================================================
        /**
        *  Создание папки
        *
        *  @access  public
        *  @param   string  $folder             имя папки
        *  @param   boolean $guard_index        TRUE если защитить папку с помощью index.html
        *  @param   boolean $guard_htaccess     TRUE если защитить папку с помощью index.html
        *  @return  boolean                     TRUE если создана или уже существовала
        */
        // ===================================================================

        public function createFolder ( $folder, $guard_index = TRUE, $guard_htaccess = TRUE ) {
            $ok = TRUE;
            if ($folder != '') {
                $dir = rtrim($folder, " \t\r\n/\\");
                if ($dir != '') {
                    if (!file_exists($dir) || !is_dir($dir)) $ok = @ mkdir($dir, 0755, TRUE);
                    if (!$ok) return $ok;
                }

                // если защищаем папку файлом index.html
                $CRLF = "\r\n";
                if ($guard_index) {
                    $folder = $dir . '/index.html';
                    @ file_put_contents($folder, '<html>' . $CRLF . $CRLF
                                               . '    <head>' . $CRLF
                                               . '        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . $CRLF
                                               . '        <meta http-equiv="Content-Language" content="ru" />' . $CRLF
                                               . '        <title>' . $CRLF
                                               . '            This is not usable page of website' . $CRLF
                                               . '        </title>' . $CRLF
                                               . '    </head>' . $CRLF . $CRLF
                                               . '    <body>' . $CRLF
                                               . '        This is not usable page of website.<br />' . $CRLF
                                               . '        Please visit its main page.' . $CRLF
                                               . '    </body>' . $CRLF . $CRLF
                                               . '</html>' . $CRLF);
                }

                // если защищаем папку файлом .htaccess
                if ($guard_htaccess) {
                    $folder = $dir . '/.htaccess';
                    @ file_put_contents($folder, '<Files "*">' . $CRLF
                                               . '    Order Deny,Allow' . $CRLF
                                               . '    Deny from All' . $CRLF
                                               . '</Files>' . $CRLF);
                }
            }
            return $ok;
        }



        // ===================================================================
        /**
        *  Удаление файла
        *
        *  @access  public
        *  @param   string  $filename   имя файла
        *  @return  boolean             TRUE если удален или не существовал
        */
        // ===================================================================

        public function deleteFile ( $filename ) {
            if ($filename == '' || !file_exists($filename) || !is_file($filename)) return TRUE;
            if (!is_writeable($filename)) return FALSE;
            @ unlink($filename);
            return !file_exists($filename) || !is_file($filename);
        }



        // ===================================================================
        /**
        *  Переименование файла
        *
        *  @access  public
        *  @param   string  $old_file   старое имя файла
        *  @param   string  $new_file   новое имя файла
        *  @return  boolean             TRUE если переименован
        */
        // ===================================================================

        public function renameFile ( $old_file, $new_file ) {
            if ($old_file == '' || $old_file == $new_file
            || !file_exists($old_file) || !is_file($old_file)) return TRUE;
            if ($new_file == '' || !is_writeable($old_file)) return FALSE;
            if (file_exists($new_file) && is_file($new_file)) @ unlink($new_file);
            @ rename($old_file, $new_file);
            return !file_exists($old_file) || !is_file($old_file);
        }



        // ===================================================================
        /**
        *  Добавление RAW-данных из POST-секции запроса страницы в конец файла
        *
        *  @access  public
        *  @param   string  $filename   имя файла
        *  @return  boolean             TRUE если добавлено
        */
        // ===================================================================

        public function appendRawPostToFile ( $filename ) {
            if ($filename == '' || ($handle = @ fopen($filename, 'ab')) === FALSE) return FALSE;
            @ fwrite($handle, @ file_get_contents('php://input'));
            @ fclose($handle);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Выправление имени файла до безопасного
        *
        *  @access  public
        *  @param   string  $name       имя файла
        *  @param   boolean $strict     TRUE если только имя файла (по умолчанию TRUE)
        *                               FALSE если допустим и относительный путь
        *  @param   integer $maxsize    предельный размер имени (по умолчанию 2048 символов)
        *  @return  string              выправленное имя
        */
        // ===================================================================

        public function safeFilename ( $name, $strict = TRUE, $maxsize = 2048 ) {
            if (($pos = strpos($name, '#')) !== FALSE) $name = substr($name, 0, $pos);
            if (($pos = strpos($name, '?')) !== FALSE) $name = substr($name, 0, $pos);
            $name = str_replace('\\', '/', $name);
            if (($pos = strrpos($name, ':')) !== FALSE) {
                $name = substr($name, $pos + 1);
                if (substr($name, 0, 2) == '//') {
                    $name = explode('/', ltrim($name, '/'), 2);
                    $name = trim(isset($name[1]) ? $name[1] : $name[0]);
                }
            }
            if ($strict) {
                $name = explode('/', $name);
                $name = array_pop($name);
                $name = rtrim(ltrim($name), ". \r\n\t");
            } else {
                $name = preg_replace('![ \r\n\t\s\./]+/!u', '/', $name);
                $name = preg_replace('!/[ \r\n\t\s]+!u', '/', $name);
                $name = rtrim(ltrim($name, '/'), '/.');
            }
            $name = $this->cms->text->translitText($name, 'ru');
            $name = preg_replace('![^/a-z0-9_\.]+!i', '-', $name);
            $name = substr($name, 0, $maxsize);
            $name = preg_replace('![\./]+/!', '/', $name);
            return rtrim(ltrim($name, '/'), '/.');
        }
    }



    return;
?>