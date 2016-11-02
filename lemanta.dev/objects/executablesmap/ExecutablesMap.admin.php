<?php
    // =======================================================================
    /**
    *  Админ модуль карты исполняемых файлов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/../.ref-models/AdminSetup.php');

    // текст заголовка страницы модуля
    define('EXECUTABLESMAP_PAGE_TITLE', 'Карта исполняемых файлов');

    // имя файла шаблона модуля
    define('EXECUTABLESMAP_TEMPLATE_FILENAME', 'executables_map/executables_map.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('EXECUTABLESMAP_MODULELINK_POINTER', 'ExecutablesMap');
    define('EXECUTABLESMAP_MODULETAB_TEXT', 'скрипты');
    define('EXECUTABLESMAP_MODULEMENU_PATH', 'Утилиты / Безопасность / Карта исполняемых файлов');



    // =======================================================================
    /**
    *  Админ модуль карты исполняемых файлов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ExecutablesMap extends AdminSetupREFModel {

        // искомые расширения файлов
        protected $files_extensions = array('phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'phps',
                                            'cgi', 'exe', 'com', 'dll',
                                            'pl', 'asp', 'aspx',
                                            'shtml', 'shtm',
                                            'fcgi', 'fpl', 'jsp',
                                            'wml');

        // имя модели базы данных
        protected $dbmodel = 'executables';

        // имя файла шаблона
        protected $template = EXECUTABLESMAP_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Контрольная функция для usort списка файлов в папке
        *
        *  @access  private
        *  @param   object  $a      объект записи о первом файле
        *  @param   object  $b      объект записи о втором файле
        *  @return  integer         -1, 0 или 1 (первый выше, равны, второй выше)
        */
        // ===================================================================

        private function sortFilesCompare ( $a, $b ) {

            // папки отправляем наверх списка
            if (isset($a->files) && !isset($b->files)) return -1;
            if (!isset($a->files) && isset($b->files)) return 1;

            // у кого позиция выше, отправляем наверх списка
            $av = isset($a->position) ? intval($a->position) : 0;
            $bv = isset($b->position) ? intval($b->position) : 0;
            if ($av > $bv) return -1;
            if ($av < $bv) return 1;

            // сортируем по алфавиту
            $av = isset($a->title) ? trim($a->title) : '';
                if ($av == '') $av = isset($a->filename) ? trim($a->filename) : '';
            $bv = isset($b->title) ? trim($b->title) : '';
                if ($bv == '') $bv = isset($b->filename) ? trim($b->filename) : '';
            return strnatcasecmp($av, $bv);
        }



        // ===================================================================
        /**
        *  Получение списка файлов в папке
        *
        *  @access  public
        *  @param   string  $path       имя пути
        *  @param   string  $url        относительный путь
        *  @param   array   $files      массив со списком файлов (будет возвращен в эту переменную)
        *  @param   integer $maxlevel   максимальный обслуживаемый уровень вложенности
        *  @param   integer $level      текущий уровень вложенности
        *  @return  boolean             TRUE если выполнено успешно и содержит файлы
        *                               1 если выполнено успешно, но не содержит файлы
        */
        // ===================================================================

        public function getFiles ( $path, $url, & $files = array(), $maxlevel = 256, $level = 1 ) {

            // если не достигли предельного уровня вложенности
            $result = FALSE;
            $maxlevel = min($maxlevel, 256);
            $maxlevel = max(1, $maxlevel);
            $level = max(1, $level);
            if ($level <= $maxlevel) {

                // поправляем путь и url (относительный путь)
                $url = str_replace('\\', '/', $url);
                $url = ltrim(rtrim($url, "/. \t\r\n"));
                if ($url != '') $url .= '/';

                $path = str_replace('\\', '/', $path);
                if ($path != '') $path .= '/';

                // если удалось открыть папку
                $result = $path != '' && ($handle = @ opendir($path)) !== FALSE;
                if ($result) {
                    $result = 1;

                    // перебираем имена вложенных элементов
                    while (($file = @ readdir($handle)) !== FALSE) {
                        $file = rtrim($file, ". \t\r\n");
                        if ($file != '') {
                            $fullpath = $path . $file;

                            // готовим запись
                            $item = null;

                            // если это папка
                            if (!is_link($fullpath)) {
                                if (is_dir($fullpath)) {

                                    // заполняем запись информацией
                                    $item = new stdClass;
                                    $item->path = $url;
                                    $item->filename = $file;
                                    $item->ctime = @ filectime($fullpath); $item->ctime = $item->ctime !== FALSE ? date('Y-m-d H:i:s', $item->ctime) : '0000-00-00 00:00:00';
                                    $item->mtime = @ filemtime($fullpath); $item->mtime = $item->mtime !== FALSE ? date('Y-m-d H:i:s', $item->mtime) : '0000-00-00 00:00:00';
                                    $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');
                                    $item->files = array();
                                    $ok = FALSE;
                                    if ($level <= $maxlevel) {
                                        $ok = $this->getFiles($fullpath, $url . $file, $item->files, $maxlevel, $level + 1);
                                    }

                                    // игнорируем папки без искомых файлов
                                    if ($ok !== TRUE) {
                                        $item = null;
                                    } else {
                                        $result = TRUE;
                                    }

                                // иначе это файл
                                } elseif (is_file($fullpath)) {

                                    // проверяем вхождение файла в список искомых по расширению
                                    if (is_array($this->files_extensions) && !empty($this->files_extensions)) {
                                        $ext = strtolower(pathinfo($fullpath, PATHINFO_EXTENSION));
                                        if ($ext != '' && in_array($ext, $this->files_extensions)) {

                                            // заполняем запись информацией
                                            $item = new stdClass;
                                            $item->path = $url;
                                            $item->filename = $file;
                                            $item->extension = $ext;
                                            $item->filesize = @ filesize($fullpath); if ($item->filesize === FALSE) $item->filesize = 0;
                                            $item->ctime = @ filectime($fullpath); $item->ctime = $item->ctime !== FALSE ? date('Y-m-d H:i:s', $item->ctime) : '0000-00-00 00:00:00';
                                            $item->mtime = @ filemtime($fullpath); $item->mtime = $item->mtime !== FALSE ? date('Y-m-d H:i:s', $item->mtime) : '0000-00-00 00:00:00';
                                            $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');

                                            $result = TRUE;
                                        }
                                    }
                                }
                            }

                            // если запись есть, добавляем в список
                            if (!empty($item)) {
                                $files[] = $item;
                            }
                        }
                    }

                    usort($files, array($this, 'sortFilesCompare'));

                    // закрываем папку
                    @ closedir($handle);
                }
            }

            // возвращаем СДЕЛАНО / ОШИБКА
            return $result;
        }



        // ===================================================================
        /**
        *  Обработка дерева файлов
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function processFiles () {

            // снимаем ограничение на время выполнения скрипта
            @ set_time_limit(0);

            // читаем список файлов
            $this->items = array();
            $path = getcwd();
            $path = rtrim($path, '/\\') . '/' . ROOT_FOLDER_REFERENCE;
            if (!$this->getFiles($path, '', $this->items)) {
                $this->pushError('Не удалось открыть корневую папку сайта!');
            }

            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEMS, $this->items);
        }



        // ===================================================================
        /**
        *  Обработка редактирования настроек сайта, принадлежащих данному модулю
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function processSetup () {
            parent::processSetup();
            $this->processFiles();
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(EXECUTABLESMAP_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>