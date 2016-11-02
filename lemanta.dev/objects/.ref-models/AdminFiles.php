<?php
    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/AdminSetup.php');

    // библиотека PCLZip
    require_once(ROOT_FOLDER_REFERENCE
               . FOLDERNAME_FOR_ADMIN_PANEL
               . '/pclzip/pclzip.lib.php');



    // ====================== TODO: удалить этот блок позже (еще один дубль сейчас есть в objects/Admin.Images.php),
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



    // =======================================================================
    /**
    *  Контрольная функция пре/пост распаковки файла
    *
    *  @access  public
    *  @param   integer $event      событие
    *  @param   mixed   $header     сведения о файле
    *  @return  boolean             TRUE если продолжить
    */
    // =======================================================================

    if (!function_exists('impera_ExtractCallBack')) {

        function impera_ExtractCallBack ( $event, & $header ) {

            // какое событие произошло?
            switch ($event) {

                // если пре распаковка
                case PCLZIP_CB_PRE_EXTRACT:

                    // если путь файла в архиве содержит инъекцию, возвращаем ОТКЛОНИТЬ РАСПАКОВКУ
                    $file = isset($header['stored_filename']) ? trim($header['stored_filename']) : '';
                    $file = str_replace('\\', '/', $file);
                    if (strpos($file, './') !== FALSE) return 0;

                    // выправляем имя файла (транслитерируем русские символы, заменяем пробелы дефисами, удаляем избыточные слеши)
                    if (isset($header['filename'])) {
                        $header['filename'] = impera_TranslitFilename($header['filename'], 'ru');
                        $header['filename'] = str_replace(' ', '-', $header['filename']);
                        $header['filename'] = str_replace('\\', '/', $header['filename']);
                        $header['filename'] = preg_replace('!/+!', '/', $header['filename']);
                    }
                    break;

                // если пост распаковка
                case PCLZIP_CB_POST_EXTRACT:

                    // какой результат распаковки?
                    if (isset($header['status'])) {
                        $status = strtolower(trim($header['status']));
                        switch ($status) {

                            // если успешная распаковка
                            case 'ok':
                                $file = isset($header['filename']) ? trim($header['filename']) : '';
                                if ($file != '') {

                                    // устанавливаем типичные права доступа
                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    if (is_dir($file)) {
                                        @ chmod($file, 0755);
                                    } else {
                                        if ($ext == 'php') {
                                            @ chmod($file, 0644);
                                        } else {
                                            @ chmod($file, 0644);
                                        }
                                    }
                                }
                                break;

                            // если старая версия файла
                            case 'newer_exist':
                                break;

                            // если такой уже существует
                            case 'already_a_directory':
                                break;

                            // если отклоненный
                            case 'filtered':
                            case 'skipped':
                                break;

                            // если ошибка
                            case 'write_protected':
                            case 'write_protect':
                            case 'write_error':
                            case 'read_error':
                            case 'error':
                            case 'path_creation_fail':
                            case 'invalid_header':
                            case 'filename_to_long':
                                break;
                        }
                    }
                    break;
            }

            // возвращаем ПОЗВОЛИТЬ
            return 1;
        }
    }



    // =======================================================================
    /**
    *  Макет списка редактируемых файлов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AdminFilesREFModel extends AdminSetupREFModel {

        // признак "работает ли модуль как редактор файлов"
        protected $as_file_editor = FALSE;

        // путь к файлам (относительно корня сайта)
        public $files_path = '';

        // допустимые расширения файлов
        protected $files_extensions = array();

        // запрещенные расширения папок
        protected $disabled_extensions = array('phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'phps',
                                               'cgi', 'exe', 'com', 'dll',
                                               'pl', 'asp', 'aspx', 'shtml', 'shtm', 'fcgi', 'fpl', 'jsp',
                                               'htm', 'html', 'wml');



        // ===================================================================
        /**
        *  Обработка команд редактирования файлов
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function processFileCommands () {

            // пока никаких изменений в базе данных нет,
            // пока нет отмены перенаправления на страницу возврата
            $this->changed = FALSE;
            $cancel = FALSE;

            // читаем входной параметр ITEMID - имя оперируемого файла,
            // параметр FROM - на какую страницу вернуться после операции,
            // параметр ACTION - какую команду требовали сделать
            $filename = trim($this->cms->param(REQUEST_PARAM_NAME_ITEMID));
            $result_page = trim($this->cms->param(REQUEST_PARAM_NAME_FROM));
            $act = trim($this->cms->param(REQUEST_PARAM_NAME_ACTION));

            // какую команду требовали сделать во входном параметре ACTION?
            if (is_array($this->my_actions) && in_array($act, $this->my_actions)) {
                switch ($act) {

                    // если команду "Разрешить / запретить показ на сайте"
                    case ACTION_REQUEST_PARAM_VALUE_ENABLED:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionEnabled($filename, $this->changed);
                        break;

                    // если команду "Редактировать запись"
                    case ACTION_REQUEST_PARAM_VALUE_EDIT:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionEdit($filename, $this->changed);
                        break;

                    // если команду "Редактировать новую запись"
                    case ACTION_REQUEST_PARAM_VALUE_EDIT_NEW:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionEditNew($filename, $this->changed);
                        break;

                    // если команду "Редактировать все записи"
                    case ACTION_REQUEST_PARAM_VALUE_EDIT_ALL:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionEditAll($filename, $this->changed);
                        break;

                    // если команду "Создать копию"
                    case ACTION_REQUEST_PARAM_VALUE_COPY:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionCopy($filename, $this->changed);
                        break;

                    // если команду "Удалить файл"
                    case ACTION_REQUEST_PARAM_VALUE_DELETE:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionDelete($filename, $this->changed);
                        break;

                    // если команду "Создать папку"
                    case ACTION_REQUEST_PARAM_VALUE_CREATE:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);

                        // по завершению метода $filename поменяется на имя созданной папки, если папка создана
                        $cancel = $this->actionCreate($filename, $this->changed);
                        break;

                    // если команду "Загрузить файл"
                    case ACTION_REQUEST_PARAM_VALUE_DOWNLOAD:
                        $this->checkToken();
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                        $cancel = $this->actionDownload($filename, $this->changed);
                        break;

                    // иначе команда не известна
                    default:

                        // считаем, что была выбрана такая папка
                        $filename = $this->hdd->safeFilename($filename, FALSE);
                }

            // иначе если команда неизвестная или не в списке разрешенных
            } elseif ($act != '') {
                $cancel = $this->pushError('Команда ' . htmlspecialchars($act, ENT_QUOTES) . ' не известна или запрещена для этой страницы.');
            }

            // передаем в шаблонизатор выбранную папку
            while (($filename != '') && !is_dir($this->files_path . '/' . $filename)) $filename = $this->parentPath($filename);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEM, $filename);

            // если произошли изменения в базе данных, очищаем соответствующие кеш-таблицы
            if ($this->changed) $this->resetCaches();

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

            // обрабатываем редактирование настроек модуля
            $this->processSetup();

            // обрабатываем команды редактирования файлов
            $this->processFileCommands();

            // читаем список файлов
            $this->items = array();
            if (!$this->getFiles($this->files_path, '', $this->items)) {
                $this->pushError('Не удалось открыть папку ' . $this->files_path);
            }

            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_ITEMS, $this->items);

            // наполняем другие переменные и передаем в шаблонизатор
            $this->fillVariables();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->cms->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);

            // уничтожаем ненужные переменные в шаблонизаторе
            $this->destroyVariables();
            return TRUE;
        }



        // ===================================================================
        /**
        *  Получение имени родительского пути
        *
        *  @access  protected
        *  @param   string  $path   имя пути
        *  @return  string          имя родительского пути
        */
        // ===================================================================

        protected function parentPath ( $path ) {

            // удаляем из имени пути последнюю ветку
            $path = str_replace('\\', '/', $path);
            $path = explode('/', $path);
            array_pop($path);
            return rtrim(implode('/', $path), "/. \t\r\n");
        }



        // ===================================================================
        /**
        *  Защита всех папок в пути
        *
        *  @access  protected
        *  @param   string  $path   имя пути
        *  @return  string          имя родительского пути
        */
        // ===================================================================

        protected function guardPath ( $path ) {

            // поправляем путь
            $path = str_replace('\\', '/', $path);
            $path = ltrim(rtrim($path, "/. \t\r\n"));
            if ($path != '') $path .= '/';

            // если удалось открыть папку
            if ($path != '' && ($handle = @ opendir($path)) !== FALSE) {

                // создаем псевдозапись папки
                $this->createFolderRecord($path);

                // перебираем имена вложенных элементов
                while (($file = @ readdir($handle)) !== FALSE) {
                    $file = rtrim($file, ". \t\r\n");
                    if ($file != '') {
                        $fullpath = $path . $file;

                        // если это папка
                        if (!is_link($fullpath) && is_dir($fullpath)) {

                            // создаем псевдозапись папки
                            $this->createFolderRecord($fullpath);

                            // обрабатываем вложенные элементы
                            $this->guardPath($fullpath);
                        }
                    }
                }

                // закрываем папку
                @ closedir($handle);
            }
        }



        // ===================================================================
        /**
        *  Проверка по имени файла, является ли он картинкой миниатюры
        *
        *  @access  protected
        *  @param   string  $file   имя файла
        *  @return  boolean         TRUE если это картинка миниатюры
        */
        // ===================================================================

        protected function isImageThumbnail ( $file ) {
            return FALSE;
        }



        // ===================================================================
        /**
        *  Удаление файла
        *
        *  @access  protected
        *  @param   string  $file   имя файла
        *  @return  void
        */
        // ===================================================================

        protected function deleteFile ( $file ) {
            if (file_exists($file) && is_file($file)) @ unlink($file);

            // если у JPG/PNG/GIF-картинки есть миниатюра, удаляем ее
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $thumbnail = substr($file, 0, -strlen($ext)) . THUMBNAIL_FILENAME_MARKER . $ext;
            $ext = strtolower($ext);
            if (($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif')
            && file_exists($thumbnail) && is_file($thumbnail)) @ unlink($thumbnail);

            // удаляем файл псевдозаписи
            $file = trim(substr($file, 0, -strlen($ext))) . ($ext != '' ? '' : '.') . FILE_RECORD_FILE_EXTENSION;
            if (file_exists($file) && is_file($file)) @ unlink($file);
        }



        // ===================================================================
        /**
        *  Создание шаблона (регулярного выражения) фильтра файлов по расширению
        *
        *  @access  protected
        *  @param   boolean $with_record_files  TRUE если включить в фильтр файлы псевдозаписей
        *  @return  string                      строка шаблона, например \.(jpg|gif|png)$
        */
        // ===================================================================

        protected function getPattern ( $with_record_files = TRUE ) {

            // перебираем расширения файлов
            $pattern = '';
            if (is_array($this->files_extensions) && !empty($this->files_extensions)) {
                foreach ($this->files_extensions as $ext) {
                    $ext = strtolower(trim($ext));
                    if ($ext != '') {
                        $ext = preg_replace('/[^a-z0-9_\-]/i', '', $ext);
                        if ($ext != '') {
                            if ($pattern != '') $pattern .= '|';
                            $pattern .= $ext;
                        }
                    }
                }
            }

            // создаем шаблон
            if ($with_record_files && ($pattern != '')) $pattern .= '|';
            if ($with_record_files || ($pattern != '')) {
                $pattern = '\.(' . $pattern
                                 . ($with_record_files ? preg_replace('/[^a-z0-9_\-]/i', '', FILE_RECORD_FILE_EXTENSION) . '|' : '')
                                 . ($with_record_files ? preg_replace('/[^a-z0-9_\-]/i', '', FOLDER_RECORD_FILE_EXTENSION) : '')
                           . ')$';
            }

            // возвращаем шаблон
            return $pattern;
        }



        // ===================================================================
        /**
        *  Создание псевдозаписи папки
        *
        *  @access  protected
        *  @param   string  $path           имя папки
        *  @param   object  $data           контент записи
        *  @param   integer $guard_mode     режим защиты папки
        *  @return  void
        */
        // ===================================================================

        protected function createFolderRecord ( $path, $data = null, $guard_mode = FOLDER_GUARD_MODE_VIA_INDEX ) {

            // получаем шаблон фильтра файлов по расширению (кроме файлов псевдозаписей)
            $pattern = $this->getPattern(FALSE);

            // защищаем папку (с перезаписью защитных файлов)
            $this->cms->smart_create_folder($path, $guard_mode, 0755, TRUE, $pattern);
        }



        // ===================================================================
        /**
        *  Создание псевдозаписи файла
        *
        *  @access  protected
        *  @param   string  $file   имя файла
        *  @param   object  $data   контент записи
        *  @return  void
        */
        // ===================================================================

        protected function createFileRecord ( $file, $data = null ) {
        }



        // ===================================================================
        /**
        *  Получение псевдозаписи файла
        *
        *  @access  protected
        *  @param   string  $file   имя файла
        *  @param   object  $data   контент записи (будет помещен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function getFileRecord ( $file, & $data = null ) {
            $this->cms->get_file_record($file, $data);
        }



        // ===================================================================
        /**
        *  Получение псевдозаписи папки
        *
        *  @access  protected
        *  @param   string  $path   имя пути
        *  @param   object  $data   контент записи (будет помещен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function getFolderRecord ( $path, & $data = null ) {
            $this->cms->get_folder_record($path, $data);
        }



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
        *  @return  boolean             TRUE если выполнено успешно
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
                $path = ltrim(rtrim($path, "/. \t\r\n"));
                if ($path != '') $path .= '/';

                // если удалось открыть папку
                $result = $path != '' && ($handle = @ opendir($path)) !== FALSE;
                if ($result) {

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

                                    // берем псевдозапись папки
                                    $item = new stdClass;
                                    $this->getFolderRecord($fullpath, $item);

                                    // дополняем запись информацией
                                    $item->path = $url;
                                    $item->filename = $file;
                                    $item->ctime = @ filectime($fullpath); $item->ctime = ($item->ctime !== FALSE) ? date('Y-m-d H:i:s', $item->ctime) : '0000-00-00 00:00:00';
                                    $item->mtime = @ filemtime($fullpath); $item->mtime = ($item->mtime !== FALSE) ? date('Y-m-d H:i:s', $item->mtime) : '0000-00-00 00:00:00';
                                    $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');
                                    $item->files = array();
                                    if ($level <= $maxlevel) {
                                        $this->getFiles($fullpath, $url . $file, $item->files, $maxlevel, $level + 1);
                                    }

                                // иначе это файл
                                } elseif (is_file($fullpath)) {

                                    // проверяем вхождение файла в список разрешенных по расширению
                                    if (is_array($this->files_extensions) && !empty($this->files_extensions)) {
                                        $ext = strtolower(pathinfo($fullpath, PATHINFO_EXTENSION));
                                        if (($ext != '') && in_array($ext, $this->files_extensions)) {

                                            // если это JPG/PNG/GIF-картинка
                                            if (($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'png') || ($ext == 'gif')) {

                                                // если не миниатюра
                                                if (!$this->isImageThumbnail($fullpath)) {

                                                    // берем псевдозапись файла
                                                    $item = new stdClass;
                                                    $this->getFileRecord($fullpath, $item);

                                                    // дополняем запись информацией
                                                    $item->path = $url;
                                                    $item->filename = $file;
                                                    $item->extension = $ext;
                                                    $item->filesize = @ filesize($fullpath); if ($item->filesize === FALSE) $item->filesize = 0;
                                                    $item->ctime = @ filectime($fullpath); $item->ctime = ($item->ctime !== FALSE) ? date('Y-m-d H:i:s', $item->ctime) : '0000-00-00 00:00:00';
                                                    $item->mtime = @ filemtime($fullpath); $item->mtime = ($item->mtime !== FALSE) ? date('Y-m-d H:i:s', $item->mtime) : '0000-00-00 00:00:00';
                                                    $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');

                                                    // если картинка распознается
                                                    if (function_exists('getimagesize') && (list($width, $height) = @ getimagesize($fullpath))) {

                                                        // дополняем запись информацией
                                                        $item->width = $width;
                                                        $item->height  = $height;
                                                    }
                                                }

                                            // иначе это не JPG/PNG/GIF-картинка
                                            } else {

                                                // берем псевдозапись файла
                                                $item = new stdClass;
                                                $this->getFileRecord($fullpath, $item);

                                                // дополняем запись информацией
                                                $item->path = $url;
                                                $item->filename = $file;
                                                $item->extension = $ext;
                                                $item->filesize = @ filesize($fullpath); if ($item->filesize === FALSE) $item->filesize = 0;
                                                $item->ctime = @ filectime($fullpath); $item->ctime = ($item->ctime !== FALSE) ? date('Y-m-d H:i:s', $item->ctime) : '0000-00-00 00:00:00';
                                                $item->mtime = @ filemtime($fullpath); $item->mtime = ($item->mtime !== FALSE) ? date('Y-m-d H:i:s', $item->mtime) : '0000-00-00 00:00:00';
                                                $item->permissions = $this->hdd->getFilePermissions($fullpath, ' ');
                                            }
                                        }
                                    }
                                }
                            }

                            // если запись есть, добавляем оперативные ссылки админпанели
                            if (!empty($item)) {
                                $item->enable_get = $this->cms->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_ENABLED,
                                                                               REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                                               REQUEST_PARAM_NAME_TOKEN => $this->cms->token));
                                $item->delete_get = $this->cms->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_DELETE,
                                                                               REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                                               REQUEST_PARAM_NAME_TOKEN => $this->cms->token));
                                $item->copy_get = $this->cms->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_COPY,
                                                                             REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                                             REQUEST_PARAM_NAME_TOKEN => $this->cms->token));
                                $item->edit_get = $this->cms->form_get(array(REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_EDIT,
                                                                             REQUEST_PARAM_NAME_ITEMID => $url . $file,
                                                                             REQUEST_PARAM_NAME_TOKEN => $this->cms->token));

                                // добавляем запись в список
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
        *  Наполнение переменных и передача в шаблонизатор
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function fillVariables () {
        }



        // ===================================================================
        /**
        *  Уничтожение ненужных более переменных в шаблонизаторе
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function destroyVariables () {
            $this->cms->smarty->clearAssign(SMARTY_VAR_ITEMS);
            $this->items = null;
            $this->item = null;
        }



        // ===================================================================
        /**
        *  Проверка ссылки на символичность
        *
        *  @access  protected
        *  @param   string  $url        путь файла / папки
        *  @return  boolean             TRUE если это символическая ссылка
        */
        // ===================================================================

        protected function checkSymbolicLink ( $url ) {
            if (is_link($url)) {
                return $this->pushError('Путь ' . $url . ' является символической ссылкой. Работа с ней не поддерживается.');
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка невозможности действия над файлом / папкой
        *
        *  @access  protected
        *  @param   string  $filename   имя файла / папки
        *  @param   boolean $is_file    TRUE если это файл
        *                               FALSE если папка
        *                               null если не знаем, папка или файл
        *  @return  boolean             TRUE если действие невозможно
        */
        // ===================================================================

        protected function checkActionImpossibility ( $filename, $is_file = null ) {

            // если в демо режиме
            if ($this->cms->config->demo) {
                $type = is_null($is_file) ? 'файлов и папок' : ($is_file ? 'файлов' : 'папок');
                return $this->pushError('В демо версии запрещено редактировать файлы, менять свойства ' . $type . ' или удалять их.');
            }

            // проверяем возможность действия
            $url = $this->files_path . '/' . $filename;
            if ($filename != '' && !file_exists($url)) {
                $type = is_null($is_file) ? 'Папка или файл ' : ($is_file ? 'Файл ' : 'Папка ');
                $type2 = is_null($is_file) ? 'существующий файл или папку' : ($is_file ? 'существующий файл' : 'существующую папку');
                return $this->pushError($type . $url . ' не существует. Необходимо указать ' . $type2 . '.');
            }

            // действие возможно
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка невозможности записи в файл / папку
        *
        *  @access  protected
        *  @param   string  $url        путь файла / папки
        *  @param   string  $type       название записываемого контента
        *  @param   boolean $is_file    TRUE если это файл
        *                               FALSE если папка
        *  @param   array   $data       массив контента (для проверки)
        *                               null если не проверять контент
        *  @return  boolean             TRUE если действие невозможно
        */
        // ===================================================================

        protected function checkWriteImpossibility ( $url, $type, $is_file = TRUE, $data = null ) {

            // проверяем возможность записи
            if (!is_writable($url)) {
                $type2 = $is_file ? 'файла' : 'папки';
                $type3 = $is_file ? 'его' : 'ее';
                return $this->pushError('Текущие атрибуты ' . $type2 . ' ' . $url . ' не позволяют перезаписывать ' . $type3 . ' ' . $type . '.');
            }

            // проверяем наличие контента
            if (!is_null($data) && (!is_array($data) || empty($data))) {
                return $this->pushError('Не получены отредактированные данные.');
            }

            // действие возможно
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка отказа в обработке файла
        *
        *  @access  protected
        *  @param   string  $url        путь файла
        *  @return  boolean             TRUE если отказано
        */
        // ===================================================================

        protected function checkFileDisallow ( $url ) {

            // проверяем наличие списка разрешенных по расширению файлов
            if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
                return $this->pushError('К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.');
            }

            // проверяем вхождение файла в список разрешенных по расширению
            $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
            if ($ext == '' || !in_array($ext, $this->files_extensions)) {
                return $this->pushError('Необходимо указать файл следующего расширения: ' . implode(', ', $this->files_extensions) . '.');
            }

            // проверяем что JPG/PNG/GIF-файл не является миниатюрой
            if (($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') && $this->isImageThumbnail($url)) {
                return $this->pushError('Необходимо указать файл изображения, а не его миниатюру. Имя такого файла не содержит маркер ' . THUMBNAIL_FILENAME_MARKER . ' перед расширением файла.');
            }

            // действие возможно
            return FALSE;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_ENABLED
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionEnabled ( $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // проверяем возможность переключения
            $cancel = $this->checkActionImpossibility($filename);
            if (!$cancel) {

                // если это файл
                $url = $this->files_path . (($filename != '') ? '/' . $filename : '');
                $cancel = $this->checkSymbolicLink($url);
                if (!$cancel) {
                    if (is_file($url)) {

                        // проверяем вхождение файла в список разрешенных по расширению
                        $cancel = $this->checkFileDisallow($url);
                        if (!$cancel) {

                            // проверяем доступность файла для записи
                            $cancel = $this->checkWriteImpossibility($url, 'свойства');
                            if (!$cancel) {

                                // имитируем якобы был параметр enabled = !enabled
                                $request = array();
                                $request[REQUEST_PARAM_NAME_ENABLED] = '';

                                // записываем изменения в файл псевдозаписи файла
                                $this->createFileRecord($url, $request);
                            }
                        }

                    // иначе это папка
                    } elseif (is_dir($url)) {

                        // проверяем доступность папки для записи
                        $cancel = $this->checkWriteImpossibility($url, 'свойства', FALSE);
                        if (!$cancel) {

                            // имитируем якобы был параметр enabled = !enabled
                            $request = array();
                            $request[REQUEST_PARAM_NAME_ENABLED] = '';

                            // записываем изменения в файл псевдозаписи папки
                            $this->createFolderRecord($url, $request);
                        }

                    // иначе тип неизвестен
                    } else {
                        $cancel = $this->pushError('Не удалось определить тип объекта ' . $url . ' файловой системы.');
                    }
                }
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_EDIT
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionEdit ( $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // проверяем возможность действия над указанным объектом
            $is_file = $this->as_file_editor ? TRUE : null;
            $cancel = $this->checkActionImpossibility($filename, $is_file);
            if (!$cancel) {

                // получаем отредактированные данные
                $request = array();
                if (isset($_POST)) {

                    // заголовок
                    $field = REQUEST_PARAM_NAME_TITLE;
                    if (isset($_POST[$field]) && is_array($_POST[$field]) && isset($_POST[$field][$filename])) {
                        $request[$field] = is_string($_POST[$field][$filename]) ? trim($_POST[$field][$filename]) : '';
                    }

                    // цена
                    $field = REQUEST_PARAM_NAME_PRICE;
                    if (isset($_POST[$field]) && is_array($_POST[$field]) && isset($_POST[$field][$filename])) {
                        $request[$field] = is_string($_POST[$field][$filename]) ? trim($_POST[$field][$filename]) : '';
                    }

                    // описание
                    $field = REQUEST_PARAM_NAME_DESCRIPTION;
                    if (isset($_POST[$field]) && is_array($_POST[$field]) && isset($_POST[$field][$filename])) {
                        $request[$field] = is_string($_POST[$field][$filename]) ? trim($_POST[$field][$filename]) : '';
                    }

                    // ссылка
                    $field = REQUEST_PARAM_NAME_LINK;
                    if (isset($_POST[$field]) && is_array($_POST[$field]) && isset($_POST[$field][$filename])) {
                        $request[$field] = is_string($_POST[$field][$filename]) ? trim($_POST[$field][$filename]) : '';
                    }

                    // разрешен / запрещен
                    $field = REQUEST_PARAM_NAME_ENABLED;
                    if (isset($_POST[$field]) && is_array($_POST[$field]) && isset($_POST[$field][$filename])) {
                        $request[$field] = $_POST[$field][$filename] ? 1 : 0;
                    }

                    // контент файла (если модуль работает как редактор файлов)
                    if ($this->as_file_editor) {
                        $field = REQUEST_PARAM_NAME_CONTENT;
                        if (isset($_POST[$field]) && is_array($_POST[$field]) && isset($_POST[$field][$filename])) {
                            $request[$field] = is_string($_POST[$field][$filename]) ? rtrim($_POST[$field][$filename]) : '';
                        }
                    }
                }

                // если это файл
                $url = $this->files_path . (($filename != '') ? '/' . $filename : '');
                $cancel = $this->checkSymbolicLink($url);
                if (!$cancel) {
                    if (is_file($url)) {

                        // проверяем вхождение файла в список разрешенных по расширению
                        $cancel = $this->checkFileDisallow($url);
                        if (!$cancel) {

                            // проверяем доступность файла для записи и наличие данных
                            $cancel = $this->checkWriteImpossibility($url, $is_file ? 'содержимое' : 'параметры', TRUE, $request);
                            if (!$cancel) {

                                // проверяем, работает ли модуль как редактор файлов
                                if ($this->as_file_editor) {

                                    // записываем изменения в файл
                                    if (!$handle = @ fopen($url, 'rb+')) $handle = @ fopen($url, 'wb');
                                    if ($handle) {
                                        @ flock($handle, LOCK_EX);
                                        $size = 0;
                                        $field = REQUEST_PARAM_NAME_CONTENT;
                                        if (isset($request[$field])) {
                                            $request[$field] .= "\r\n";
                                            $size = strlen($request[$field]);
                                            @ fwrite($handle, $request[$field], $size);
                                        }
                                        @ ftruncate($handle, $size);
                                        @ fclose($handle);
                                    } else {
                                        $cancel = $this->pushError('Не удалось открыть файл ' . $url . ' для записи.');
                                    }
                                } else {

                                    // записываем изменения в файл псевдозаписи файла
                                    $this->createFileRecord($url, $request);
                                }
                            }
                        }

                    // иначе это папка
                    } elseif (is_dir($url)) {

                        // проверяем, работает ли модуль как редактор файлов
                        if ($this->as_file_editor) {
                            $cancel = $this->pushError('Это не файл ' . $url . '. Необходимо указать файл.');
                        } else {

                            // проверяем доступность папки для записи и наличие данных
                            $cancel = $this->checkWriteImpossibility($url, 'параметры', FALSE, $request);
                            if (!$cancel) {

                                // записываем изменения в файл псевдозаписи папки
                                $this->createFolderRecord($url, $request);
                            }
                        }

                    // иначе тип неизвестен
                    } else {
                        $cancel = $this->pushError('Не удалось определить тип объекта ' . $url . ' файловой системы.');
                    }
                }
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_EDIT_NEW
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionEditNew ( $filename, & $changed = FALSE ) {
            return FALSE;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_EDIT_ALL
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionEditAll ( $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // проверяем возможность действия над указанным объектом
            $cancel = $this->checkActionImpossibility($filename, FALSE);
            if (!$cancel) {

                // если это папка
                $url = $this->files_path . (($filename != '') ? '/' . $filename : '');
                $cancel = $this->checkSymbolicLink($url);
                if (!$cancel) {
                    if (is_dir($url)) {

                        // проверяем наличие списка разрешенных по расширению файлов
                        if (!is_array($this->files_extensions) || empty($this->files_extensions)) {
                            $cancel = $this->pushError('К сожалению, в программном модуле не заданы разрешенные расширения файлов. Поэтому выполнение такой функции невозможно до устранения указанной проблемы.');
                        } else {

                            // получаем отредактированные данные
                            $request = array();
                            $field = REQUEST_PARAM_NAME_CONTENT;
                            if (isset($_POST)) {
                                if (!isset($_POST[$field]) || !is_array($_POST[$field])) {
                                    $cancel = $this->pushError('Не получены отредактированные данные.');
                                } else {

                                    // перебираем блоки данных
                                    foreach ($_POST[$field] as $index => & $value) {
                                        $name = substr($index, strlen($filename));
                                        $name = $this->hdd->safeFilename($name);

                                        // только если файл из этой же папки (остальные игнорируем)
                                        if ($index == ($filename != '' ? $filename . '/' : '') . $name) {
                                            $name = '/' . $name;

                                            // проверяем вхождение файла в список разрешенных по расширению
                                            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                                            if ($ext == '' || !in_array($ext, $this->files_extensions)) {
                                                $cancel = $this->pushError('Файл ' . $url . $name . ' отклонен. Необходимо указать файл следующего расширения: ' . implode(', ', $this->files_extensions) . '.');
                                            } else {

                                                // проверяем доступность файла для записи
                                                if (!is_writable($url . $name)) {
                                                    $cancel = $this->pushError('Файл ' . $url . $name . ' отклонен. Его текущие атрибуты не позволяют перезапись файла.');
                                                } else {

                                                    // считаем этот блок верным
                                                    if (!isset($request[$name])) $request[$name] = array();
                                                    $request[$name][$field] = is_string($value) ? rtrim($value) : '';
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            // если имеются верные отредактированные данные
                            if (!empty($request)) {

                                // перебираем блоки данных
                                foreach ($request as $name => & $value) {
                                    if (isset($value[$field])) {

                                        // записываем изменения в файл
                                        if (!$handle = @ fopen($url . $name, 'rb+')) $handle = @ fopen($url . $name, 'wb');
                                        if ($handle) {
                                            @ flock($handle, LOCK_EX);
                                            $value[$field] .= "\r\n";
                                            $size = strlen($value[$field]);
                                            @ fwrite($handle, $value[$field], $size);
                                            @ ftruncate($handle, $size);
                                            @ fclose($handle);
                                        } else {
                                            $cancel = $this->pushError('Не удалось открыть файл ' . $url . $name . ' для записи.');
                                        }
                                    }
                                }
                            }
                        }

                    // иначе это файл
                    } else {
                        $cancel = $this->pushError('Это не папка ' . $url . '. Необходимо указать папку.');
                    }
                }
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_COPY
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionCopy ( $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // проверяем возможность действия над указанным объектом
            $cancel = $this->checkActionImpossibility($filename);
            if (!$cancel) {

                // если это файл
                $url = $this->files_path . (($filename != '') ? '/' . $filename : '');
                $cancel = $this->checkSymbolicLink($url);
                if (!$cancel) {
                    if (is_file($url)) {

                        // проверяем вхождение файла в список разрешенных по расширению
                        $cancel = $this->checkFileDisallow($url);
                        if (!$cancel) {

                            // проверяем доступность файла для чтения
                            if (!is_readable($url)) {
                                $cancel = $this->pushError('Текущие атрибуты файла ' . $url . ' не позволяют прочесть его содержимое.');
                            } else {

                                // предельно возможный номер в имени копии файла
                                $limit = 1000;

                                // находим первый несуществующий файл вида имя_файла.copyN.расширение
                                $num = 1;
                                $ext = pathinfo($url, PATHINFO_EXTENSION);
                                $ext = $ext != '' ? '.' . $ext : '';
                                $fname = substr($url, 0, -strlen($ext));
                                $new_url = $fname . '.copy';
                                if (preg_match('/^(.+)\.copy([0-9]*)$/i', $fname, $matches)) {
                                    $num = isset($matches[2]) ? intval($matches[2]) : 1;
                                    $num = ($num >= 1 ? $num : 1) + 1;
                                    $new_url = (isset($matches[1]) ? trim($matches[1]) : $fname) . '.copy';
                                }
                                while ($num <= $limit) {
                                    $path = $new_url . ($num > 1 ? $num : '') . $ext;
                                    if (!file_exists($path) || !is_link($path) && !is_file($path)) break;
                                    $num++;
                                }

                                // если исчерпан лимит нумерации копий
                                if ($num > $limit) {
                                    $cancel = $this->pushError('Исчерпан лимит нумерации копий файла. '
                                                             . 'Для исходного файла ' . $url . ' было определено следующее предполагаемо незанятое имя ' . $new_url . $num . $ext . '. '
                                                             . 'Однако номер копии в имени файла не может превышать ' . $limit . '.');
                                } else {

                                    // копируем файл
                                    @ copy($url, $path);
                                }
                            }
                        }

                    // иначе это папка
                    } elseif (is_dir($url)) {

                        // проверяем доступность папки для чтения
                        if ($filename == '') {
                            $cancel = $this->pushError('Вы находитесь в корневой папке. Можно делать копии только вложенных папок.');
                        } else {
                            if (!is_readable($url)) {
                                $cancel = $this->pushError('Текущие атрибуты папки ' . $url . ' не позволяют прочесть ее содержимое.');
                            } else {

                                // предельно возможный номер в имени копии папки
                                $limit = 1000;

                                // находим первую несуществующую папку вида имя_папки.copyN
                                $num = 1;
                                $new_url = $url . '.copy';
                                if (preg_match('/^(.+)\.copy([0-9]*)$/i', $url, $matches)) {
                                    $num = isset($matches[2]) ? intval($matches[2]) : 1;
                                    $num = ($num >= 1 ? $num : 1) + 1;
                                    $new_url = (isset($matches[1]) ? trim($matches[1]) : $url) . '.copy';
                                }
                                while ($num <= $limit) {
                                    $path = $new_url . ($num > 1 ? $num : '');
                                    if (!file_exists($path) || !is_link($path) && !is_dir($path)) break;
                                    $num++;
                                }

                                // если исчерпан лимит нумерации копий
                                if ($num > $limit) {
                                    $cancel = $this->pushError('Исчерпан лимит нумерации копий папки. '
                                                             . 'Для исходной папки ' . $url . ' было определено следующее предполагаемо незанятое имя ' . $new_url . $num . '. '
                                                             . 'Однако номер копии в имени папки не может превышать ' . $limit . '.');
                                } else {

                                    // копируем папку
                                    $this->cms->copy_dir($url, $path);
                                }
                            }
                        }

                    // иначе тип неизвестен
                    } else {
                        $cancel = $this->pushError('Не удалось определить тип объекта ' . $url . ' файловой системы.');
                    }
                }
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_DELETE
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionDelete ( $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // проверяем возможность действия над указанным объектом
            $cancel = $this->checkActionImpossibility($filename);
            if (!$cancel) {

                // если это файл
                $url = $this->files_path . (($filename != '') ? '/' . $filename : '');
                $cancel = $this->checkSymbolicLink($url);
                if (!$cancel) {
                    if (is_file($url)) {

                        // проверяем вхождение файла в список разрешенных по расширению
                        $cancel = $this->checkFileDisallow($url);
                        if (!$cancel) {

                            // проверяем доступность файла для записи
                            if (!is_writable($url)) {
                                $cancel = $this->pushError('Текущие атрибуты файла ' . $url . ' не позволяют удалить его.');
                            } else {

                                // удаляем файл
                                $this->deleteFile($url);
                            }
                        }

                    // иначе это папка
                    } elseif (is_dir($url)) {

                        // проверяем доступность папки для записи
                        if (!is_writable($url)) {
                            $cancel = $this->pushError('Текущие атрибуты папки ' . $url . ' не позволяют удалить ее.');
                        } else {

                            // удаляем папку
                            $this->cms->clean_dir($url);
                            if (file_exists($url)) {
                                if ($filename != '') {
                                    @ rmdir($url);

                                // иначе очищалась корневая папка, нужно создать ее файл псевдозаписи
                                } else {
                                    $this->createFolderRecord($url);
                                }
                            }
                        }

                    // иначе тип неизвестен
                    } else {
                        $cancel = $this->pushError('Не удалось определить тип объекта ' . $url . ' файловой системы.');
                    }
                }
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_CREATE
        *
        *  @access  protected
        *  @param   string  $filename   имя файла (имя созданной папки будет возвращено в эту переменную)
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionCreate ( & $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            if ($this->cms->config->demo) {
                $cancel = $this->pushError('В демо версии запрещено создавать папки.');
            } else {

                // проверяем возможность создания
                $name = trim($this->cms->param(REQUEST_PARAM_NAME_NAME));
                $name = $this->hdd->safeFilename($name);
                if ($name == '') {
                    $cancel = $this->pushError('Необходимо указать имя создаваемой папки.');
                } else {

                    // проверяем доступность папки для записи
                    $url = $this->files_path . (($filename != '') ? '/' . $filename : '');
                    $cancel = $this->checkWriteImpossibility($url, 'содержимое', FALSE);
                    if (!$cancel) {

                        $url .= '/' . $name;

                        // проверяем не вхождение папки в список запрещенных по расширению
                        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
                        if ($ext != '' && is_array($this->disabled_extensions) && in_array($ext, $this->disabled_extensions)) {
                            $cancel = $this->pushError('Запрещено создавать папки с расширением ' . $ext . '.');
                        } else {

                            // создаем файл псевдозаписи папки
                            $this->createFolderRecord($url);

                            // возвращаем на вход имя созданной папки
                            $filename = (($filename != '') ? $filename . '/' : '') . $name;
                        }
                    }
                }
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка команды ACTION_REQUEST_PARAM_VALUE_DOWNLOAD
        *
        *  @access  protected
        *  @param   string  $filename   имя файла
        *  @param   boolean $changed    TRUE если сделаны изменения (будет возвращен в эту переменную)
        *  @return  boolean             TRUE если нужно отменить перенаправление на страницу возврата
        */
        // ===================================================================

        protected function actionDownload ( $filename, & $changed = FALSE ) {

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            $data = null;
            if (isset($_FILES['image'])) {
                $data = & $_FILES['image'];
            } elseif (isset($_FILES['file'])) {
                $data = & $_FILES['file'];
            }

            // если загружают файл
            if (isset($data) && !empty($data)) {

                if ($this->cms->config->demo) {
                    $cancel = $this->pushError('В демо версии запрещено совершать загрузку своих файлов.');
                } else {

                    // пробуем принять файл
                    if (($filename != '') && !file_exists($this->files_path . '/' . $filename)) {
                        $cancel = $this->pushError('Папка ' . $filename . ' не существует. Необходимо указать существующую.');
                    } else {

                        $name = isset($data['name']) ? $data['name'] : '';
                        $name = $this->hdd->safeFilename($name);
                        if (isset($data['tmp_name']) && $data['tmp_name'] != '' && (!isset($data['error']) || $data['error'] == UPLOAD_ERR_OK)) {

                            // проверяем вхождение файла в список разрешенных по расширению
                            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                            if ($ext == '' || ($ext != 'zip' && (!is_array($this->files_extensions) || !in_array($ext, $this->files_extensions)))) {
                                $cancel = $this->pushError('Недопустимый тип ' . $ext . ' загружаемого файла. Принимаются только ' . (is_array($this->files_extensions) && !empty($this->files_extensions) ? 'файлы с расширением ' . implode(', ', $this->files_extensions) . ' или ' : '') . 'ZIP-архивы.');
                            } else {

                                // проверяем что JPG/PNG/GIF-файл не является миниатюрой
                                if (($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') && $this->isImageThumbnail($name)) {
                                    $cancel = $this->pushError('Имя файла не должно быть таким, что предназначено для миниатюры изображения. Не используйте маркер ' . THUMBNAIL_FILENAME_MARKER . ' перед расширением файла.');
                                } else {

                                    // если это не архивный файл
                                    if ($ext != 'zip') {
                                        $url = $this->files_path . (($filename != '') ? '/' . $filename : '') . '/' . $name;
                                        if (! @ move_uploaded_file($data['tmp_name'], $url)) {
                                            $cancel = $this->pushError('Не удалось загрузить файл.');
                                        } else {

                                            // создаем файл псевдозаписи файла
                                            $this->createFileRecord($url);
                                        }

                                    // иначе это архивный файл
                                    } else {
                                        $url = $this->files_path . (($filename != '') ? '/' . $filename : '') . '/';

                                        // получаем шаблон фильтра файлов по расширению
                                        $pattern = $this->getPattern();

                                        // начинаем распаковку архива
                                        $zip = new PclZip($data['tmp_name']);
                                        if (!$zip->extract(PCLZIP_OPT_PATH, $url,
                                                           PCLZIP_OPT_BY_PREG, '\'' . $pattern . '\'i',
                                                           PCLZIP_OPT_REPLACE_NEWER,
                                                           PCLZIP_CB_PRE_EXTRACT, 'impera_ExtractCallBack',
                                                           PCLZIP_CB_POST_EXTRACT, 'impera_ExtractCallBack')) {
                                            $cancel = $this->pushError('Не удалось распаковать ' . $zip->errorInfo(TRUE));
                                        }

                                        // обрабатываем (защищаем) созданные папки
                                        $this->guardPath($url);
                                    }
                                }
                            }

                        // иначе была ошибка при передаче файла
                        } else {
                            if (isset($data['error'])) {
                                switch ($data['error']) {
                                    case UPLOAD_ERR_INI_SIZE:
                                        $cancel = $this->pushError('Размер принятого файла "' . $name . '" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.');
                                        break;
                                    case UPLOAD_ERR_FORM_SIZE:
                                        $cancel = $this->pushError('Размер загружаемого файла "' . $name . '" превышает максимально допустимое значение' . (isset($_POST['MAX_FILE_SIZE']) ? ' ' . trim($_POST['MAX_FILE_SIZE']) . ' байт' : '') . '.');
                                        break;
                                    case UPLOAD_ERR_PARTIAL:
                                        $cancel = $this->pushError('Загрузка файла "' . $name . '" прервалась и он был получен не весь.');
                                        break;
                                    case UPLOAD_ERR_NO_FILE:
                                        $cancel = $this->pushError('Не получен файл "' . $name . '".');
                                        break;
                                    default:
                                        $cancel = $this->pushError('Произошла неизвестная ошибка при попытке загрузить файл "' . $name . '".');
                                }
                            } else {
                                $cancel = $this->pushError('Произошла неизвестная ошибка при попытке загрузить файл "' . $name . '".');
                            }
                        }
                    }
                }

            // иначе отсутствует загружаемый файл
            } else {
                $cancel = $this->pushError('Не указан загружаемый файл.');
            }

            // возвращаем ПЕРЕНАПРАВЛЕНИЕ ОТМЕНИТЬ / НЕ ОТМЕНЯТЬ
            return $cancel;
        }
    }



    return;
?>