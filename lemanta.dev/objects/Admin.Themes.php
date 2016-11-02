<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // подключаем компонент PCLZip
    require_once('pclzip/pclzip.lib.php');



    // =======================================================================
    /**
    *  Контрольная функция пре/пост распаковки файла шаблона
    *
    *  @access  public
    *  @return  boolean         TRUE если продолжить
    */
    // =======================================================================

    function ThemesExtractCallBack ( $event, & $header ) {
        return 1;
    }



    // =======================================================================
    /**
    *  Админ модуль списка шаблонов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Themes extends Basic {

        // имя файла шаблона или массив имен файлов
        protected $template = array('themes/themes.htm',
                                    'admin_themes.htm');

        // список доступных шаблонов клиентской стороны сайта
        public $themes = array();

        // список доступных шаблонов админпанели
        public $admin_themes = array();

        // потенциально опасные расширения
        protected $warning_ext = array('passwd', 'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'exe', 'com', 'dll', 'so', 'pl', 'asp', 'aspx', 'shtml', 'shtm', 'fcgi', 'fpl', 'jsp', 'wml');



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
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);

            // берем список доступных шаблонов клиентской стороны сайта
            $this->themes = $this->get_themes_list(FALSE);

            // берем список доступных шаблонов админпанели
            $this->admin_themes = $this->get_themes_list(TRUE);
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

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // читаем входной параметр ITEMID - идентификатор оперируемой записи,
            // параметр FROM - на какую страницу вернуться после операции,
            // параметр ACTION - какую команду требовали сделать
            $id = trim($this->param('item_id'));
            $result_page = trim($this->param('from'));
            $act = trim($this->param('act'));

            // здесь ИД записи - это имя папки шаблона (убеждаемся в безопасности имени)
            $id = $this->hdd->safeFilename($id);

            // если передан идентификатор оперируемой записи или это команда "Закачать на сайт"
            if ($id != '' || $act == ACTION_REQUEST_PARAM_VALUE_UPLOAD) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // определяем, над шаблонами чьей стороны будет производиться операция
                $adminpanel = $this->param('adminpanel') == TRUE;
                if ($adminpanel) {
                    $items = & $this->admin_themes;
                    $path = 'design/';
                    $field = 'admin_theme';
                } else {
                    $items = & $this->themes;
                    $path = ROOT_FOLDER_REFERENCE . 'design/';
                    $field = 'theme';
                }

                // если такой шаблон не существует
                if ($act != ACTION_REQUEST_PARAM_VALUE_UPLOAD) {
                    if (!isset($items[$id]) || !is_readable($path . $id) || !is_dir($path . $id)) {
                        $cancel = $this->push_error('Не найден шаблон ' . $id . ' среди шаблонов '
                                                  . ($adminpanel ? 'админпанели' : 'клиентской стороны сайта') . '.');
                    }
                }
                if (!$cancel) {

                    // по умолчанию финальная страница операций
                    $final_page = $this->site_url . '/' . $this->hdd->safeFilename($this->admin_folder) . '/index.php' . $this->form_get(array());

                    // какую команду требовали сделать во входном параметре ACTION?
                    switch ($act) {

                        // если команду "Активировать"
                        case 'activate':

                            // очищаем папку скомпилированного шаблона
                            $this->smarty->clearCompiledFolder($adminpanel);

                            // если до этого был выбран другой шаблон
                            if (!isset($this->settings->$field) || ($this->settings->$field != $id)) {

                                // сохраняем новое значение настройки
                                $this->db->settings->save($field, $id);
                            }

                            // предполагаем перенаправить на финальную страницу
                            if ($result_page == '') $result_page = $final_page;
                            break;

                        // если команду "Закачать на сайт"
                        case ACTION_REQUEST_PARAM_VALUE_UPLOAD:

                            // если работаем в демо режиме
                            if ($this->config->demo) {
                                $cancel = $this->push_error('В демонстрационной версии загрузка шаблонов невозможна.');
                            } else {

                                // принимаем файл (с компьютера)
                                $ok = FALSE;
                                $temp = 'temp/';
                                $file = '';
                                if (isset($_FILES['theme']) && $_FILES['theme']['tmp_name'] != '') {
                                    $file = $this->hdd->safeFilename($_FILES['theme']['name']);
                                    if (!preg_match('/.+\.zip$/i', $file)) {
                                        $cancel = $this->push_error('Загружаемый файл должен быть ZIP-архивом.');
                                    } else {
                                        if (file_exists($temp . $file)) @ unlink($temp . $file);
                                        $ok = @ move_uploaded_file($_FILES['theme']['tmp_name'], $temp . $file);
                                        if (!$ok) $cancel = $this->push_error('Не удалось скопировать загруженный файл во временную папку для распаковки.');
                                    }

                                // или принимаем файл (с веб страницы)
                                } elseif (isset($_POST['theme_url'])) {
                                    $url = trim($_POST['theme_url']);
                                    if ($url == '' || strtolower($url) == 'http://') {
                                        $cancel = $this->push_error('Не указано, какой файл загружать.');
                                    } else {
                                        $file = $this->hdd->safeFilename(basename($url));
                                        if (!preg_match('/.+\.zip$/i', $file)) {
                                            $cancel = $this->push_error('Загружаемый файл должен быть ZIP-архивом.');
                                        } else {
                                            if (file_exists($temp . $file)) @ unlink($temp . $file);
                                            $ok = @ copy($url, $temp . $file);
                                            if (!$ok) $cancel = $this->push_error('Не удалось загрузить файл со страницы ' . htmlspecialchars($url, ENT_QUOTES) . '.');
                                        }
                                    }
                                } else {
                                    $cancel = $this->push_error('Не указано, какой файл загружать.');
                                }

                                // возможно для шаблона указали другое имя
                                if ($ok) {
                                    $name = $this->request->getRequestAsSentence('other_name');
                                    $name = $this->hdd->safeFilename($name);
                                    if ($name != '') {
                                        $id = explode('.', $name);
                                    } else {
                                        $id = explode('.', $file);
                                        array_pop($id);
                                    }

                                    // проверяем расширение папки
                                    $ext = strtolower(end($id));
                                    if (in_array($ext, $this->warning_ext) || in_array($ext, array('htaccess', 'htm', 'html', 'xml'))) {
                                        $cancel = $this->push_error('Имя шаблона не может быть таким, чтобы заканчивалось подобно расширению .' . $ext . ', как в именах файлов.');
                                    } else {
                                        $id = implode('.', $id);

                                        // какой режим загрузки?
                                        $mode = $this->request->getRequestAsSentence('update_mode');
                                        $mode = strtolower($mode);
                                        switch ($mode) {

                                            // если удалить старый шаблон
                                            case 'clear_before':
                                                if ($id == 'common' || $id == 'common_parts') {
                                                    $cancel = $this->push_error('В таком режиме загрузки шаблон с именем ' . $id . ' не может быть использован, так как имеется такая техническая папка, она допустима лишь в режиме загрузки поверх.');
                                                } else {
                                                    $this->delete_dir($path . $id);
                                                }
                                                break;

                                            // если поверх существующего, тогда есть ли такой шаблон?
                                            case 'merge':
                                                if (!file_exists($path . $id) || !is_dir($path . $id)) {
                                                    $cancel = $this->push_error('Согласно указанным вами параметрам загрузки, не найден шаблон ' . $id . '.');
                                                }
                                                break;

                                            // если только на пустое место, тогда может такой шаблон уже есть?
                                            case 'if_not_exist':
                                            default:
                                                if ($id == 'common' || $id == 'common_parts') {
                                                    $cancel = $this->push_error('В таком режиме загрузки шаблон с именем ' . $id . ' не может быть использован, так как имеется такая техническая папка, она допустима лишь в режиме загрузки поверх.');
                                                } elseif (file_exists($path . $id) && is_dir($path . $id)) {
                                                    $cancel = $this->push_error('Согласно указанным вами параметрам загрузки, нельзя загрузить шаблон ' . $id . ' поверх уже существующего.');
                                                }
                                        }

                                        // распаковываем файл
                                        if (!$cancel) {
                                            @ mkdir($path . $id, 0755, TRUE);
                                            $zip = new PclZip($temp . $file);
                                            if ($zip->extract(PCLZIP_OPT_PATH, $path . $id, PCLZIP_OPT_REMOVE_PATH, $id, PCLZIP_CB_POST_EXTRACT, 'ThemesExtractCallBack') == 0) {
                                                $cancel = $this->push_error('Не удалось распаковать архив шаблона ' . $id . ' (причина: ' . $zip->errorInfo(TRUE) . ').');

                                                // удаляем папку шаблона
                                                $this->delete_dir($path . $id);
                                            } else {

                                                // в полнозагрузочных режимах убеждаемся, что это действительно шаблон (хотя бы содержит папку html)
                                                if ($mode != 'merge' && (!file_exists($path . $id . '/html') || !is_dir($path . $id . '/html'))) {
                                                    $cancel = $this->push_error('Архив шаблона ' . $id . ' не содержит TPL-файлы шаблона (как минимум папку html).');

                                                    // удаляем папку шаблона
                                                    $this->delete_dir($path . $id);
                                                } else {

                                                    // очищаем папку скомпилированного шаблона
                                                    $this->smarty->clearCompiledFolder($adminpanel);

                                                    // TODO: проанализировать и отправить сообщение на страницу, если в шаблоне встречены файлы с потенциально опасными расширениями,
                                                    //       идеально было бы показать финальный список файлов шаблона, как сделано в скрипте установки движка

                                                    // предполагаем перенаправить на финальную страницу
                                                    if ($result_page == '') $result_page = $final_page;
                                                }
                                            }
                                        }
                                    }
                                }

                                // удаляем архив (использованный или оставшийся после ошибки)
                                if ($file != '' && file_exists($temp . $file)) @ unlink($temp . $file);
                            }
                            break;

                        // если команду "Скачать"
                        case ACTION_REQUEST_PARAM_VALUE_DOWNLOAD:

                            // если работаем в демо режиме
                            if ($this->config->demo && ($adminpanel || $id != 'default')) {
                                $cancel = $this->push_error('В демонстрационной версии невозможно скачивание шаблонов, кроме шаблона default клиентской стороны сайта.');
                            } else {

                                // удаляем прежний архив, если не удалили
                                $file = 'temp/' . $id . '.zip';
                                if (file_exists($file)) @unlink($file);

                                // создаем архив
                                $zip = new PclZip($file);
                                if ($zip->create($path . $id, PCLZIP_OPT_REMOVE_PATH, $path . $id) == 0) {
                                    $cancel = $this->push_error('Не удалось создать архив шаблона ' . $id . ' (причина: ' . $zip->errorInfo(TRUE) . ').');
                                } else {

                                    // выгружаем архив в браузер
                                    header('Content-type: application/zip');
                                    header('Content-Disposition: attachment; filename="' . $id . '.zip"');
                                    echo file_get_contents($file);
                                    @unlink($file);
                                    exit;
                                }

                                // удаляем незавершенный архив, если остался после ошибки
                                if (file_exists($file)) @unlink($file);
                            }
                            break;

                        // если команду "Создать копию"
                        case ACTION_REQUEST_PARAM_VALUE_COPY:

                            // если работаем в демо режиме
                            if ($this->config->demo) {
                                $cancel = $this->push_error('В демонстрационной версии создание копии шаблона невозможно.');
                            } else {

                                // предельно возможный номер в имени копии шаблона
                                $limit = 1000;

                                // находим первую несуществующую папку вида имя_шаблона.copyN
                                $num = 1;
                                $new_id = $id . '.copy';
                                if (preg_match('/^(.+)\.copy([0-9]*)$/', $id, $matches)) {
                                    $num = isset($matches[2]) ? intval($matches[2]) : 1;
                                    $num = (($num >= 1) ? $num : 1) + 1;
                                    $new_id = (isset($matches[1]) ? trim($matches[1]) : $id) . '.copy';
                                }
                                while ($num <= $limit) {
                                    $file = $path . $new_id . (($num > 1) ? $num : '');
                                    if (!file_exists($file) || !is_dir($file)) break;
                                    $num++;
                                }

                                // если исчерпан лимит нумерации копий
                                if ($num > $limit) {
                                    $cancel = $this->push_error('Исчерпан лимит нумерации копий шаблона. '
                                                              . 'Для исходного шаблона ' . $id . ' было определено следующее предполагаемо незанятое имя ' . $new_id . $num . '. '
                                                              . 'Однако номер копии в имени шаблона не может превышать ' . $limit . '.');
                                } else {

                                    // очищаем папку скомпилированного шаблона
                                    $this->smarty->clearCompiledFolder($adminpanel);

                                    // копируем папку шаблона
                                    $this->copy_dir($path . $id, $file);

                                    // предполагаем перенаправить на финальную страницу
                                    if ($result_page == '') $result_page = $final_page;
                                }
                            }
                            break;

                        // если команду "Удалить"
                        case ACTION_REQUEST_PARAM_VALUE_DELETE:

                            // если работаем в демо режиме
                            if ($this->config->demo) {
                                $cancel = $this->push_error('В демонстрационной версии удаление шаблонов невозможно.');
                            } else {

                                // если это текущий (используемый сейчас) шаблон
                                if (isset($this->settings->$field) && ($this->settings->$field == $id)) {
                                    $cancel = $this->push_error('Нельзя удалить шаблон '  . $id . ', так как он сейчас используется для '
                                                              . ($adminpanel ? 'админпанели' : 'клиентской стороны сайта') . '.');
                                } else {

                                    // очищаем папку скомпилированного шаблона
                                    $this->smarty->clearCompiledFolder($adminpanel);

                                    // удаляем папку шаблона
                                    $this->delete_dir($path . $id);

                                    // предполагаем перенаправить на финальную страницу
                                    if ($result_page == '') $result_page = $final_page;
                                }
                            }
                            break;
                    }
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
            $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Дизайн';

            // добавляем в список шаблонов клментской стороны оперативные ссылки админпанели
            if (!empty($this->themes)) {
                foreach ($this->themes as & $item) {

                    // собираем параметры
                    $options = array(REQUEST_PARAM_NAME_SECTION => 'Themes',
                                     REQUEST_PARAM_NAME_ITEMID => $item->name,
                                     REQUEST_PARAM_NAME_TOKEN => $this->token,
                                     'adminpanel' => FALSE);

                    // создаем ссылку "активировать"
                    $options[REQUEST_PARAM_NAME_ACTION] = 'activate';
                    $item->activate_get = $this->form_get($options);

                    // создаем ссылку "скачать"
                    $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DOWNLOAD;
                    $item->download_get = $this->form_get($options);

                    // создаем ссылку "создать копию"
                    $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COPY;
                    $item->copy_get = $this->form_get($options);

                    // создаем ссылку "удалить"
                    $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                    $item->delete_get = $this->form_get($options);
                }
            }

            // добавляем в список шаблонов админпанели оперативные ссылки админпанели
            if (!empty($this->admin_themes)) {
                foreach ($this->admin_themes as & $item) {

                    // собираем параметры
                    $options = array(REQUEST_PARAM_NAME_SECTION => 'Themes',
                                     REQUEST_PARAM_NAME_ITEMID => $item->name,
                                     REQUEST_PARAM_NAME_TOKEN => $this->token,
                                     'adminpanel' => TRUE);

                    // создаем ссылку "активировать"
                    $options[REQUEST_PARAM_NAME_ACTION] = 'activate';
                    $item->activate_get = $this->form_get($options);

                    // создаем ссылку "скачать"
                    $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DOWNLOAD;
                    $item->download_get = $this->form_get($options);

                    // создаем ссылку "создать копию"
                    $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_COPY;
                    $item->copy_get = $this->form_get($options);

                    // создаем ссылку "удалить"
                    $options[REQUEST_PARAM_NAME_ACTION] = ACTION_REQUEST_PARAM_VALUE_DELETE;
                    $item->delete_get = $this->form_get($options);
                }
            }

            // передаем нужные данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $this->themes);
            $this->smarty->assignByRef(SMARTY_VAR_THEMES, $this->admin_themes);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->fetchAdminTemplate();
            return TRUE;
        }
    }



    return;
?>