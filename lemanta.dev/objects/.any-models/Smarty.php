<?php
    // исходники шаблонизатора
    require_once(dirname(__FILE__) . '/../../Smarty/libs/Smarty.class.php');

    // дополнительные теги шаблонизатора
    require_once(dirname(__FILE__) . '/SmartyTags.php');



    // =======================================================================
    /**
    *  Шаблонизатор Smarty
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SmartyANYModel extends Smarty {

        // объект движка
        protected $cms = null;

        // объект владельца (может быть чужим, если модель не эксклюзивная)
        public $owner = null;
        public $owner_exclusive = FALSE;

        // дополнительные теги
        protected $smarty_tags = null;



        // ===================================================================
        /**
        *  Регистрация плагина для использования в шаблоне
        *
        *  @access  public
        *  @param   string      $type               тип плагина
        *  @param   string      $tag                имя тега
        *  @param   callback    $callback           указатель на callback-функцию
        *  @param   boolean     $cacheable          TRUE если функция кешируется
        *  @param   array       $cache_attr         атрибуты кеширования
        *  @return  Smarty_Internal_Templatebase    текущий экземпляр объекта
        */
        // ===================================================================

        public function registerPlugin ( $type, $tag, $callback, $cacheable = true, $cache_attr = null ) {

            // вдруг в хелпере шаблона захотели свою функцию с таким же именем
            if (isset($this->smarty->registered_plugins[$type][$tag])) {
                $this->unregisterPlugin($type, $tag);
            }

            return parent::registerPlugin($type, $tag, $callback, $cacheable, $cache_attr);
        }



        // ===================================================================
        /**
        *  Первичная настройка
        *
        *  @access  public
        *  @param   object  $cms        объект вышестоящего движка
        *  @return  void
        */
        // ===================================================================

        public function customizeSelf ( & $cms ) {

            // запоминаем выход на объект движка
            $this->cms = & $cms;

            // настраиваем
            $this->compile_check = TRUE;
            $this->caching = FALSE;
            $this->cache_lifetime = 0;
            $this->debugging = FALSE;

            // подавляем ошибки шаблонизации в демо режиме или на боевом сайте (не локалхосте)
            $host = $this->cms->request->getServerAsSentence('HTTP_HOST');
            if ($this->cms->config->demo || $host != 'localhost') $this->error_reporting = 0;

            // регистрируем обработчик неизвестных тегов в шаблоне
            $this->registerDefaultPluginHandler(array($this, 'handlerUndefinedTag'));

            // регистрируем дополнительные теги
            $this->smarty_tags = new SmartyTagsANYModel($cms);
        }



        // ===================================================================
        /**
        *  Создание объекта политики безопасности
        *
        *  @access  public
        *  @return  object          объект политики
        */
        // ===================================================================

        public function createPolicy () {

            // создаем политику безопасности шаблонизатора
            $policy = new Smarty_Security($this);
            $policy->trusted_dir = array();
            $policy->static_classes = array();

            // удалять теги PHP
            $policy->php_handling = Smarty::PHP_REMOVE;
            $policy->allow_php_tag = FALSE;

            // разрешены такие функции из PHP
            $policy->php_functions = array('isset', 'empty', 'count', 'sizeof', 'array_count_values',
                                           'in_array', 'is_array', 'is_string', 'is_unicode', 'is_binary', 'is_buffer',
                                           'is_numeric', 'is_int', 'is_float', 'is_resource',
                                           'is_scalar', 'is_object', 'is_null',
                                           'is_bool', 'time', 'date', 'nl2br',
                                           'strpos', 'strlen', 'floor', 'ceil', 'max', 'min', 'intval', 'floatval', 'strval',
                                           'explode', 'implode', 'trim', 'ltrim', 'rtrim', 'substr',
                                           'rand', 'shuffle', 'str_shuffle', 'range',
                                           'current', 'reset', 'next', 'prev', 'end', 'each', 'key',
                                           'sort', 'rsort', 'asort', 'arsort', 'ksort',
                                           'krsort', 'natsort', 'natcasesort', 'array_flip',
                                           'array_key_exists', 'array_shift', 'array_unshift',
                                           'array_push', 'array_pop', 'array_pad', 'array_rand',
                                           'array_slice', 'array_unique', 'array_reverse',
                                           'array_values', 'array_keys', 'array_merge', 'array_combine',
                                           'array_sum', 'array_diff', 'array_intersect', 'array_fill',
                                           'serialize', 'unserialize', 'number_format',
                                           'property_exists', 'method_exists',
                                           'preg_match', 'preg_replace', 'str_replace', 'strtolower',
                                           'strtoupper', 'file_exists', 'is_readable',
                                           'is_file', 'is_dir', 'is_link', 'dirname',
                                           'parse_url', 'md5', 'crypt',
                                           'urlencode', 'urldecode', 'rawurlencode', 'rawurldecode',
                                           'http_build_query', 'base64_encode', 'base64_decode',
                                           'var_dump', 'print_r');

            // разрешены такие модификаторы переменных
            $policy->allowed_modifiers = array();
            $policy->php_modifiers = array('escape', 'count', 'nl2br', 'strlen',
                                           'floor', 'ceil', 'trim', 'ltrim', 'rtrim',
                                           'var_dump', 'print_r');

            // доступны такие ресурсы
            $policy->streams = array('file');

            $policy->allow_constants = TRUE;
            $policy->allow_super_globals = TRUE;
            return $policy;
        }



        // ===================================================================
        /**
        *  Очистка папки скомпилированного шаблона
        *
        *  @access  public
        *  @param   boolean $for_admin  TRUE если для шаблона админпанели
        *                               FALSE если для клиентского шаблона
        *  @param   string  $subpath    внутренний путь к очищаемой папке
        *  @return  void
        */
        // ===================================================================

        public function clearCompiledFolder ( $for_admin = FALSE, $subpath = '' ) {

            // ссылаемся на глобальные переменные
            global $files_host_suffix;

            // корректируем внутренний путь
            $subpath = $this->cms->hdd->safeFilename($subpath, FALSE);
            $subpath = trim($subpath, '/\\');
            if ($subpath != '') $subpath .= '/';

            // вычисляем путь папки скомпилированного шаблона
            $path = ROOT_FOLDER_REFERENCE;
            if ($for_admin) $path .= $this->cms->hdd->safeFilename($this->cms->admin_folder) . '/';
            $path .= 'compiled' . $this->cms->hdd->safeFilename($files_host_suffix) . '/';

            // открываем папку
            $handle = @ opendir($path . $subpath);
            if ($handle !== FALSE) {

                $name1 = explode('*', MAILER_TEMPLATES_FILENAME_PATTERN);
                $name2 = explode('*', MAILER_MAILLISTS_FILENAME_PATTERN);

                // перебираем файлы в папке
                while (($file = @ readdir($handle)) !== FALSE) {
                    if (trim($file, '.') != '') {

                        // если это файл
                        if (is_file($path . $subpath . $file)) {

                            // если файл не системный
                            if ($file != '.htaccess' && $file != 'index.html'
                            && $file != $this->cms->registrar->onSiteNowDbfile()
                            && substr($file, -strlen('search_history.txt')) != 'search_history.txt'
                            && substr($file, 0, strlen($name1[0])) != $name1[0]
                            && substr($file, 0, strlen($name2[0])) != $name2[0]) {

                                // удаляем файл
                                @ unlink($path . $subpath . $file);
                            }

                        // иначе это папка
                        } else {

                            // очищаем папку
                            $this->clearCompiledFolder($for_admin, $subpath . $file);
                        }
                    }
                }
            }

            // защищаем папку через .htaccess и index.html
            $this->cms->smart_create_folder($path, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);
            if ($subpath != '') $this->cms->smart_create_folder($path . $subpath, FOLDER_GUARD_MODE_VIA_HTACCESSINDEX);
        }



        // ===================================================================
        /**
        *  Рендеринг шаблона
        *
        *  @access  public
        *  @param   string  $template           ресурсное имя файла шаблона или объекта
        *  @param   mixed   $cache_id           ИД кеша, используемого с этим шаблоном
        *  @param   mixed   $compile_id         ИД компиляции, используемой с этим шаблоном
        *  @param   object  $parent             родительский уровень переменных Smarty
        *  @param   bool    $display            TRUE если выводить на экран
        *                                       FALSE если в режиме fetch
        *  @param   bool    $merge_tpl_vars     TRUE если родительские переменные объединить с локальными
        *  @param   bool    $no_output_filter   TRUE если не запускать фильтр вывода
        *  @return  string                      результат рендеринга
        */
        // ===================================================================

        public function fetch ( $template = null,
                                $cache_id = null,
                                $compile_id = null,
                                $parent = null,
                                $display = FALSE,
                                $merge_tpl_vars = TRUE,
                                $no_output_filter = FALSE ) {

            // определяем путь к файлам шаблона
            $path = str_replace('\\', '/', getcwd());
            $path = rtrim($path, "\r\n\t /") . '/';

            $dir = str_replace('\\', '/', $this->getTemplateDir(0));
            $dir = rtrim($dir, "\r\n\t /") . '/';

            // проверяем наличие файла
            $file = $path . $dir . $template;
            $missing = 'missing_template.htm';
            if (!$this->cms->hdd->isReadableFile($file)) {
                $ok = FALSE;

                // может с клиентской стороны запрашивали файл админпанели?
                $to_admin = $this->cms->hdd->safeFilename($this->cms->admin_folder) . '/';
                $to_admin = substr(ltrim($template, './'), 0, strlen($to_admin)) == $to_admin;

                $relative = ltrim($dir, './');
                $from_client = substr($relative, 0, 7) == 'design/';

                if ($from_client && $to_admin) {
                    $backs = preg_replace('~[^/]+/~', '../', $relative);
                    if ($backs != $relative) {
                        $file = $path . $dir . $backs . $template;
                        $ok = $this->cms->hdd->isReadableFile($file);
                    }
                }

                // иначе это будет файл заглушка
                if (!$ok) {
                    $file = $path . $dir . $missing;
                    if (!$this->cms->hdd->isReadableFile($file)) {
                        return '<!-- Не найден файл шаблона с именем ' . $template . ' или заглушка ' . $missing . ' -->';
                    }
                    $template = $missing;
                }
            }

            // отрисовываем файл
            return parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }



        // ===================================================================
        /**
        *  Рендеринг контента по файлу шаблона
        *
        *  @access  public
        *  @param   object  $module     объект модуля, для кого рендерится
        *  @param   string  $filename1  имя 1 файла шаблона (без расширения файла)
        *  @param   string  $filename2  имя 2 файла шаблона (по умолчанию равен имени 1)
        *  @return  string              результат рендеринга
        */
        // ===================================================================

        public function fetchByTemplate ( & $module, $filename1, $filename2 = '' ) {

            // проверяем наличие tpl- или htm-файла с именем 1
            $path = dirname(__FILE__) . '/../../design/' . $this->cms->hdd->safeFilename($this->cms->dynamic_theme) . '/html/';
            $filename1 = $this->cms->hdd->safeFilename($filename1);
            $name = $filename1 . '.tpl';
            $exist = $this->cms->hdd->isReadableFile($path . $name);
            if (!$exist) {
                $name = $filename1 . '.htm';
                $exist = $this->cms->hdd->isReadableFile($path . $name);
            }

            // проверяем наличие tpl- или htm-файла с именем 2
            $filename2 = $filename2 == '' ? $filename1 : $this->cms->hdd->safeFilename($filename2);
            $name2 = $filename2 . '.tpl';
            $exist2 = $this->cms->hdd->isReadableFile($path . $name2);
            if (!$exist2) {
                $name2 = $filename2 . '.htm';
                $exist2 = $this->cms->hdd->isReadableFile($path . $name2);
            }

            // если не найден файл
            if (!$exist) {
                $name = $name2;
                if (!$exist2) $name = '';
            }

            // если существует хелпер шаблона и подготовительный метод
            if (!empty($this->cms->designer) && $this->cms->hdd->hasMethod($this->cms->designer, 'prepare')) {

                // даем хелперу подготовить отрисовку
                //   сообщаем пустой body: если сам отрисуешь, дай контент сюда
                //   сообщаем сведения о именах файлов: какой предполагаем рисовать,
                //                                      какой он (без расширения) по имени 1,
                //                                      какой он (без расширения) по имени 2
                //   принимаем name: какой файл просит отрисовать
                $body = null;
                $names = new stdClass;
                $names->name = $name;
                $names->impera_name = $filename1;
                $names->standard_name = $filename2;
                $name = $this->cms->designer->prepare($names, $this->cms, $body);

                // если хелпер сам отрисовал контент
                if (is_string($body)) return $module->body = & $body;

                // проверяем наличие tpl-htm-файла, подготовленного хелпером
                $name = $this->cms->hdd->safeFilename($name);
                $exist = $name != '' && $this->cms->hdd->isReadableFile($path . $name);

                // если файл не найден, возвращаем строку комментария
                if (!$exist) {
                    if ($name == '') {
                        return $module->body = '<!-- Хелпер шаблона указал не обслуживать файл шаблона с именем '
                                                   . $filename1
                                                   . ($filename1 != $filename2 ? ' или ' . $filename2 : '')
                                                   . ' -->';
                    }
                    return $module->body = '<!-- Хелпер шаблона указал на неподготовленный файл '
                                               . $name . ' для шаблона с именем '
                                               . $filename1
                                               . ($filename1 != $filename2 ? ' или ' . $filename2 : '')
                                               . ' -->';
                }

            // иначе хелпер шаблона или подготовительный метод не существует
            } else {

                // если файл не найден
                if (!$exist && !$exist2) {

                    // пробуем найти файл-заглушку
                    $name = 'missing_template.htm';
                    $exist = $this->cms->hdd->isReadableFile($path . $name);

                    // если файл не найден, возвращаем строку комментария
                    if (!$exist) {
                        return $module->body = '<!-- Не найден TPL- или HTM-файл шаблона с именем '
                                                   . $filename1
                                                   . ($filename1 != $filename2 ? ' или ' . $filename2 : '')
                                                   . ' или заглушка ' . $name
                                                   . ' -->';
                    }
                }
            }

            // отрисовываем контент
            return $module->body = $this->fetch($name);
        }



        // ===================================================================
        /**
        *  Возврат контента вместо неопознанного тега
        *
        *  @access  public
        *  @return  string      контент
        */
        // ===================================================================

        public function callbackUndifinedTag () {
            return 'Ошибка: Здесь был неопознанный тег в шаблоне. ';
        }



        // ===================================================================
        /**
        *  Обработчик неизвестных тегов в шаблоне
        *
        *  @access  public
        *  @param   string  $tag        тег
        *  @param   string  $type       тип
        *  @param   object  $template   объект шаблона
        *  @param   array   $callback   указатель на обработчик
        *  @param   string  $script     указатель на скрипт
        *  @param   boolean $cachable   TRUE если обработчик кешируется
        *  @return  boolean             TRUE если выполнено успешно
        */
        // ===================================================================

        public function handlerUndefinedTag ( $tag, $type, $template, & $callback, & $script, & $cacheable ) {

            // какой тип плагина рассматриваем?
            switch ($type) {

                // если функция
                case Smarty::PLUGIN_FUNCTION:

                    // какой тег неопознан?
                    switch ($tag) {

                        // если тег fun (из Smarty 2)
                        case 'fun':
                            $callback = array($this, 'callbackUndifinedTag');
                            $script = null;
                            return TRUE;

                        // иначе возвращаем РАССМАТРИВАЙ ДАЛЬШЕ
                        default:
                            return FALSE;
                    }

                // если блоковая функция
                case Smarty::PLUGIN_BLOCK:

                    // какой тег неопознан?
                    switch ($tag) {

                        // если тег defun (из Smarty 2)
                        case 'defun':
                            $callback = array($this, 'callbackUndifinedTag');
                            $script = null;
                            return TRUE;

                        // иначе возвращаем РАССМАТРИВАЙ ДАЛЬШЕ
                        default:
                            return FALSE;
                    }

                // если функция компилятора
                case Smarty::PLUGIN_COMPILER:
                    switch ($tag) {
                        default:
                            return FALSE;
                    }

                // если модификатор
                case Smarty::PLUGIN_MODIFIER:
                    switch ($tag) {
                        default:
                            return FALSE;
                    }

                // если модификатор компилятора
                case Smarty::PLUGIN_MODIFIERCOMPILER:
                    switch ($tag) {
                        default:
                            return FALSE;
                    }

                // иначе рассмотрели все варианты
                default:
                    $callback = array($this, 'callbackUndifinedTag');
                    $script = null;
                    return TRUE;
            }
        }
    }



    return;
?>