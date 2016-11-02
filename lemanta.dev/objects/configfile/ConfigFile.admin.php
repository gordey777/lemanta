<?php
    // =======================================================================
    /**
    *  Админ модуль конфигурационного файла
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // текст заголовка страницы модуля
    define('CONFIGFILE_PAGE_TITLE', 'Конфигурационный файл');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('CONFIGFILE_TEMPLATE_FILENAME', 'config_file/config_file.htm');
    define('CONFIGFILE_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                       . CONFIGFILE_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // сообщение о блокировке в демо режиме
    define('CONFIGFILE_DEMOMODE_MSG', 'В демо версии отклоняются попытки сохранить изменения в этом файле.');

    // сообщение о недоступности файла для записи
    define('CONFIGFILE_NONWRITABLE_MSG', 'Файл * недоступен для записи.');

    // сообщение об ошибке при записи файла
    define('CONFIGFILE_BADWRITING_MSG', 'Не удалось сохранить файл *.');

    // сообщение об ошибках в отдельных настройках
    define('CONFIGFILE_BADDBHOST_MSG', 'Не указан dbhost - адрес хоста сервера баз данных.');
    define('CONFIGFILE_BADDBNAME_MSG', 'Не указан dbname - имя используемой базы данных.');
    define('CONFIGFILE_BADDBUSER_MSG', 'Не указан dbuser - имя пользователя базы данных.');
    define('CONFIGFILE_BADDBPASS_MSG', 'Не указан dbpass - пароль к базе данных.');

    // сообщение об успехе
    define('CONFIGFILE_SUCCESS_MSG', 'Изменения успешно сохранены в файле.');

    // префикс XML имени
    define('CONFIGFILE_XML_FILENAME_PREFIX', 'xml:');

    // расширение XML имени
    define('CONFIGFILE_XML_FILENAME_EXTENSION', '.xml');

    // имена переменных в шаблонизаторе
    define('CONFIGFILE_SMARTYVAR_ITEM', 'item');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('CONFIGFILE_MODULELINK_POINTER', 'ConfigFile');
    define('CONFIGFILE_MODULETAB_TEXT', 'конфиг');
    define('CONFIGFILE_MODULEMENU_PATH', 'Настройки / Мои магазины / Конфигурационный файл');



    // =======================================================================
    /**
    *  Админ модуль конфигурационного файла
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ConfigFile extends Basic {



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

            // регистрируем функции для шаблона
            $this->smarty->registerPlugin('function', 'is_xml_name', array($this, 'is_xml_name_plugin'));
            $this->smarty->registerPlugin('function', 'get_xml_name', array($this, 'get_xml_name_plugin'));
        }



        // ===================================================================
        /**
        *  Легализация имени настройки
        *
        *  @access  protected
        *  @param   string  $name       имя настройки
        *  @return  string              легализованное имя (безопасное как классовое свойство)
        */
        // ===================================================================

        protected function validate_name ( $name ) {
            $name = preg_replace('/[^a-z0-9_]/i', '', $name);
            $name = preg_replace('/^[0-9_]+/', '', $name);
            $name = preg_replace('/_+$/', '', $name);
            return $name;
        }



        // ===================================================================
        /**
        *  Получение признака "это XML имя"
        *
        *  @access  protected
        *  @param   mixed   $name       имя файла или объект XML
        *  @return  boolean             TRUE если распознано как XML имя
        */
        // ===================================================================

        protected function is_xml_name ( $name ) {
            return impera_IsResourceName($name, CONFIGFILE_XML_FILENAME_PREFIX);
        }



        // ===================================================================
        /**
        *  Плагин шаблонизатора Smarty для функции "Получение признака "это XML имя"
        *
        *  @access  public
        *  @param   mixed   $params     массив параметров функции:
        *                                   $params['item'] - имя файла или объект XML
        *                                   $params['assign'] - опционально - в какую переменную Smarty назначить результат
        *  @param   object  $smarty     объект шаблонизатора
        *  @return  boolean             TRUE если распознано как XML имя
        */
        // ===================================================================

        public function is_xml_name_plugin ( $params, & $smarty ) {
            $name = isset($params['item']) ? $params['item'] : FALSE;
            if (isset($params['assign'])) {
                $smarty->assign($params['assign'], $this->is_xml_name($name));
                return;
            }
            return $this->is_xml_name($name);
        }



        // ===================================================================
        /**
        *  Получение XML имени
        *
        *  @access  protected
        *  @param   mixed   $name       имя файла или объект XML
        *  @param   boolean $no_prefix  TRUE если нужно удалить префикс xml: из имени
        *  @return  string              XML имя
        */
        // ===================================================================

        protected function get_xml_name ( $name, $no_prefix = TRUE ) {
            return impera_GetResourceName($name,
                                          CONFIGFILE_XML_FILENAME_PREFIX,
                                          $no_prefix,
                                          CONFIGFILE_XML_FILENAME_EXTENSION);
        }



        // ===================================================================
        /**
        *  Плагин шаблонизатора Smarty для функции "Получение XML имени"
        *
        *  @access  public
        *  @param   mixed   $params     массив параметров функции:
        *                                   $params['item'] - имя файла или объект XML
        *                                   $params['assign'] - опционально - в какую переменную Smarty назначить результат
        *  @param   object  $smarty     объект шаблонизатора
        *  @return  string              XML имя
        */
        // ===================================================================

        public function get_xml_name_plugin ( $params, & $smarty ) {
            $name = isset($params['item']) ? $params['item'] : FALSE;
            if (isset($params['assign'])) {
                $smarty->assign($params['assign'], $this->get_xml_name($name));
                return;
            }
            return $this->get_xml_name($name);
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

            // устанавливаем заголовок страницы
            $this->title = ADMIN_PAGE_TITLE_PREFIX . CONFIGFILE_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = CONFIGFILE_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . CONFIGFILE_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->settings->admin_theme)
                  . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

            // обрабатываем входные параметры
            $this->process();

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Обработка входных параметров и команд
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process () {

            // с каким файлом работаем
            $path = ROOT_FOLDER_REFERENCE;
            $file = 'Config' . ($this->settings->files_host_suffix != '' ? $this->settings->files_host_suffix : '.class') . '.php';

            // берем копию конфигурационных настроек
            $item = new stdClass;
            foreach ($this->config as $field => $value) $item->$field = $value;
            if (!isset($item->smsDnevnik_disabled)) $item->smsDnevnik_disabled = FALSE;

            // если точно получен POST-запрос
            if ($this->request->isPosted()) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // берем из запроса отредактированные настройки
                $data = $this->param(CONFIGFILE_SMARTYVAR_ITEM);
                $type = $this->param(CONFIGFILE_SMARTYVAR_ITEM . '_type');
                $name = $this->param(CONFIGFILE_SMARTYVAR_ITEM . '_name');
                $used = $this->param(CONFIGFILE_SMARTYVAR_ITEM . '_used');
                if (is_array($data) && !empty($data)) {

                    // перебираем поля
                    foreach ($data as $field => $value) {

                        // если имя поля задано
                        $id = $field;
                        $field = $this->validate_name($id);
                        if ($field != '') {

                            // если поле не просили удалить
                            if (isset($used[$id]) && $used[$id]) {

                                // какое это поле?
                                switch ($field) {

                                    // если какое-то из предопределенных полей
                                    case 'lang':
                                    case 'dbhost':
                                        $item->$field = trim($value);
                                        break;
                                    case 'dbname':
                                    case 'dbuser':
                                        $value = trim($value);
                                        if ($this->config->demo && (str_replace('*', '', $value) == '')) $value = '';
                                        if (!$this->config->demo || ($value != '') || !isset($item->$field)) $item->$field = $value;
                                        break;
                                    case 'dbpass':
                                        if ($this->config->demo && (str_replace('*', '', $value) == '')) $value = '';
                                        if (!$this->config->demo || ($value != '') || !isset($item->$field)) $item->$field = $value;
                                        break;
                                    case 'only_remote_images':
                                    case 'debug':
                                    case 'debug_on_admin_exist':
                                    case 'demo':
                                    case 'smsDnevnik_disabled':
                                        $item->$field = $value == 1;
                                        break;

                                    // иначе неизвестное поле
                                    default:

                                        // обрабатываем значение согласно указанному типу
                                        if (isset($type[$id])) {
                                            switch ($type[$id]) {

                                                // если булевое
                                                case 1:
                                                    $value = $value == 1;
                                                    break;

                                                // если строка
                                                case 2:
                                                    $value = trim($value);
                                                    break;

                                                // если целое число
                                                case 3:
                                                    $value = intval($value);
                                                    break;

                                                // если вещественное число
                                                case 4:
                                                    $value = $this->number->floatValue($value);
                                                    break;

                                                // если XML файл (имя файла)
                                                case 5:
                                                    $value = trim($value);
                                                    if (!$this->is_xml_name($value)) $value = CONFIGFILE_XML_FILENAME_PREFIX . $value;
                                                    break;

                                                // если неопределенное
                                                default:
                                                    $value = null;
                                            }

                                            // возможно это поле новое (указано его имя)
                                            if (!is_null($value)) {
                                                if (isset($name[$id])) $field = $this->validate_name($name[$id]);
                                                switch ($field) {
                                                    case 'lang':
                                                    case 'dbname':
                                                    case 'dbhost':
                                                    case 'dbuser':
                                                        $value = trim($value);
                                                        break;
                                                    case 'dbpass':
                                                        $value = '' . $value;
                                                        break;
                                                    case 'only_remote_images':
                                                    case 'debug':
                                                    case 'debug_on_admin_exist':
                                                    case 'demo':
                                                    case 'smsDnevnik_disabled':
                                                        $value = $value == 1;
                                                        break;
                                                }

                                                // устанавливаем значение поля
                                                if ($field != '') $item->$field = $value;
                                            }
                                        }
                                }

                            // иначе поле просили удалить
                            } else {
                                if (isset($item->$field)) unset($item->$field);
                            }
                        }
                    }
                }

                // блокируем главное действие модуля, если находимся в демо режиме
                if ($this->config->demo) {
                    $this->push_error(CONFIGFILE_DEMOMODE_MSG);
                } else {

                    // проверяем ошибки в отдельных настройках
                    $cancel = FALSE;
                    if (!isset($item->dbhost) || ($item->dbhost == '')) $cancel = $this->push_error(CONFIGFILE_BADDBHOST_MSG);
                    if (!isset($item->dbname) || ($item->dbname == '')) $cancel = $this->push_error(CONFIGFILE_BADDBNAME_MSG);
                    if (!isset($item->dbuser) || ($item->dbuser == '')) $cancel = $this->push_error(CONFIGFILE_BADDBUSER_MSG);
                    if (!isset($item->dbpass) || ($item->dbpass == '')) $cancel = $this->push_error(CONFIGFILE_BADDBPASS_MSG);

                    // готовим контент файла
                    if (!$cancel) {
                        $data  = "<?php\r\n"
                               . "    class Config {\r\n";
                        foreach ($item as $field => $value) {
                            if (is_bool($value) || is_string($value) || is_int($value) || is_float($value) || $this->is_xml_name($value)) {
                                $field = preg_replace('/[^a-z0-9_]/i', '', $field);
                                if ($field != '') {
                                    $data .= "\r\n"
                                           . '        public $' . $field . ' = ';
                                    if (is_bool($value)) $data .= ($value ? 'TRUE' : 'FALSE') . ";\r\n";
                                    elseif (is_string($value) && $this->is_xml_name($value)) $data .= '\'' . str_replace('\'', '\\\'', str_replace('\\', '\\\\', $this->get_xml_name($value, FALSE))) . "';\r\n";
                                    elseif (is_string($value)) $data .= '\'' . str_replace('\'', '\\\'', str_replace('\\', '\\\\', $value)) . "';\r\n";
                                    elseif (is_int($value)) $data .= $value . ";\r\n";
                                    elseif (is_float($value)) $data .= $value . ";\r\n";
                                }
                            }
                        }
                        $data .= "    }\r\n"
                               . "\r\n"
                               . "    return;\r\n"
                               . "?>\r\n";

                        // пробуем сохранить в файл
                        $ok = !file_exists($path . $file) || !is_file($path . $file) || is_writable($path . $file);
                        if ($ok) {

                            $ok = @ file_put_contents($path . $file, $data);
                            if ($ok === strlen($data)) {
                                $this->push_info(CONFIGFILE_SUCCESS_MSG);

                                // устанавливаем странице фоновый звук УСПЕХ
                                $this->success_bgsound();

                            // иначе не удалось записать файл, сообщаем об этом
                            } else {
                                $msg = str_replace('*', $file, CONFIGFILE_BADWRITING_MSG);
                                $this->push_error($msg);
                            }

                        // иначе файл недоступен для записи, сообщаем об этом
                        } else {
                            $msg = str_replace('*', $file, CONFIGFILE_NONWRITABLE_MSG);
                            $this->push_error($msg);
                        }
                    }
                }
            }

            // передаем в шаблонизатор конфигурационные настройки
            $this->smarty->assignByRef(CONFIGFILE_SMARTYVAR_ITEM, $item);

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // передаем в шаблонизатор информационное сообщение
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        }
    }



    return;
?>