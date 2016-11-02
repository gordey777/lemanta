<?php
    // =======================================================================
    /**
    *  Админ модуль управления администраторами
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
    define('ADMINS_PAGE_TITLE', 'Администраторы');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('ADMINS_TEMPLATE_FILENAME', 'admins/admins.htm');
    define('ADMINS_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                   . ADMINS_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // сообщение о блокировке в демо режиме
    define('ADMINS_DEMOMODE_MSG', 'В демо версии отклоняются попытки сохранить изменения в этом файле.');

    // сообщение о недоступности файла для записи
    define('ADMINS_NONWRITABLE_MSG', 'Файл * недоступен для записи.');

    // сообщение об ошибке при записи файла
    define('ADMINS_BADWRITING_MSG', 'Не удалось сохранить файл *.');

    // сообщение об успехе
    define('ADMINS_SUCCESS_MSG', 'Изменения успешно сохранены в файле.');

    // имена переменных в шаблонизаторе
    define('ADMINS_SMARTYVAR_ITEMS', 'items');

    // логин администратора по умолчанию
    define('ADMINS_DEFAULT_LOGIN', 'admin');

    // имена переменных в форме ввода
    define('ADMINS_POSTVAR_LOGIN', 'login');
    define('ADMINS_POSTVAR_PASS', 'password');
    define('ADMINS_POSTVAR_NAME', 'name');
    define('ADMINS_POSTVAR_RIGHTS', 'rights');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('ADMINS_MODULELINK_POINTER', 'Admins');
    define('ADMINS_MODULETAB_TEXT', 'админы');
    define('ADMINS_MODULEMENU_PATH', 'Настройки / Мои магазины / Администраторы');



    // =======================================================================
    /**
    *  Админ модуль управления администраторами
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Admins extends Basic {

        // рекомендуемая страница возврата после операции
        protected $result_page = '';

        // массив записей об элементах
        protected $items = array();



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
        }



        // ===================================================================
        /**
        *  Создание у записи оперативной ссылки "удалить"
        *
        *  @access  private
        *  @param   object  $item       запись
        *  @return  void
        */
        // ===================================================================

        private function operable_delete ( & $item ) {

            // создаем оперативную ссылку "удалить"
            $options = array(REQUEST_PARAM_NAME_SECTION => ADMINS_MODULELINK_POINTER,
                             REQUEST_PARAM_NAME_ITEMID => isset($item->login) ? $item->login : '',
                             REQUEST_PARAM_NAME_TOKEN => $this->token,
                             REQUEST_PARAM_NAME_ACTION => ACTION_REQUEST_PARAM_VALUE_DELETE);
            $item->delete_get = $this->form_get($options);
        }



        // ===================================================================
        /**
        *  Создание записи администратора по умолчанию
        *
        *  @access  private
        *  @return  object      запись
        */
        // ===================================================================

        private function default_admin () {

            // создаем запись
            $item = null;
            $item->login = ADMINS_DEFAULT_LOGIN;
            $item->hash = $this->security->apr1Hash($item->login);
            $item->name = 'Супер администратор (смените пароль!)';
            $item->rights = '';

            // создаем оперативную ссылку "удалить"
            $this->operable_delete($item);

            // возвращаем запись
            return $item;
        }



        // ===================================================================
        /**
        *  Сохранение массива записей об администраторах
        *
        *  @access  protected
        *  @return  array   $items      массив записей
        *  @return  boolean             TRUE если сохранено успешно
        */
        // ===================================================================

        protected function save ( & $items ) {

            $result = FALSE;
            $size = 0;

            // если файл "базы данных" открыт
            $file = $this->security->adminsFilename();
            if (!file_exists($file) || is_writable($file) && is_file($file)) {
                if (!$handle = @ fopen($file, 'rb+')) $handle = @ fopen($file, 'wb');
                if ($handle) {

                    // пишем файл построчно
                    @ flock($handle, LOCK_EX);
                    if (is_array($items) && !empty($items)) {
                        foreach ($items as & $item) {
                            $string = (isset($item->login) ? str_replace(':', '', $item->login) : '') . ':'
                                    . (isset($item->hash) ? str_replace(':', '', $item->hash) : '') . ':'
                                    . (isset($item->name) ? str_replace(':', '', $item->name) : '') . ':'
                                    . (isset($item->rights) ? str_replace(':', '', $item->rights) : '')
                                    . "\r\n";
                            $len = strlen($string);
                            @ fwrite($handle, $string, $len);
                            $size += $len;
                        }
                    }

                    // обрезаем устаревшее окончание файла
                    @ ftruncate($handle, $size);
                    @ fclose($handle);
                    $result = TRUE;
                }
            }

            // возвращаем ВЫПОЛНЕНО или НЕТ
            return $result;
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
            $this->title = ADMIN_PAGE_TITLE_PREFIX . ADMINS_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = ADMINS_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . ADMINS_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->settings->admin_theme)
                  . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

            // читаем записи об администраторах
            $file = $this->security->adminsFilename();
            $this->items = $this->security->getAdmins($file);

            // добавляем в записи оперативные ссылки "удалить"
            foreach ($this->items as & $item) $this->operable_delete($item);

            // обрабатываем входные параметры
            $this->process();

            // если не существует ни одного администратора, создаем админа по умолчанию
            if (empty($this->items)) {
                $item = & $this->default_admin();
                $this->items[$item->login] = $item;
                $this->changed = TRUE;
                $this->push_error('Так как не существует более ни одного администратора, а должен быть как минимум один, был создан такой с логином ' . $item->login . ' и паролем ' . $item->login . '.');
            }

            // если записи изменились, сохраняем
            if ($this->changed) $this->save($this->items);

            // если в запросе есть параметр FROM (страница возврата из операции), передаем в шаблонизатор
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if ($result_page != '') $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);

            // передаем нужные данные в шаблонизатор
            $this->smarty->assignByRef(ADMINS_SMARTYVAR_ITEMS, $this->items);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);

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

            // пока изменений нет
            $this->changed = FALSE;

            // пока нет отмены перенаправления на страницу возврата
            $cancel = FALSE;

            // читаем входной параметр ITEMID - идентификатор оперируемой записи,
            // параметр FROM - на какую страницу вернуться после операции,
            // параметр ACTION - какую команду требовали сделать
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

            // если действительно передали идентификатор оперируемой записи или это команда "Удалить помеченные записи"
            if (($id != '') || ($act == ACTION_REQUEST_PARAM_VALUE_MASSDELETE)) {

                // какую команду требовали сделать во входном параметре ACTION?
                switch ($act) {

                    // если команду "Удалить помеченные записи"
                    case ACTION_REQUEST_PARAM_VALUE_MASSDELETE:

                        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                        $this->check_token();

                        // если работаем в демо режиме
                        if ($this->config->demo) {
                            $this->push_error("В демо версии запрещено удалять администраторов.");
                            return;
                        } else {

                            // перебираем помеченные элементы
                            if (isset($_POST[REQUEST_PARAM_NAME_DELETEIDS]) && is_array($_POST[REQUEST_PARAM_NAME_DELETEIDS])) {
                                foreach ($_POST[REQUEST_PARAM_NAME_DELETEIDS] as $item) {
                                    $item = trim($item);

                                    // удаляем элемент
                                    if (($item != '') && isset($this->items[$item])) {
                                        unset($this->items[$item]);
                                        $this->changed = TRUE;
                                    }
                                }
                            }
                        }
                        break;

                    // если команду "Удалить запись"
                    case ACTION_REQUEST_PARAM_VALUE_DELETE:

                        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                        $this->check_token();

                        // если работаем в демо режиме
                        if ($this->config->demo) {
                            $this->push_error("В демо версии запрещено удалять администраторов.");
                            return;
                        } else {

                            // удаляем элемент
                            if (isset($this->items[$id])) {
                                unset($this->items[$id]);
                                $this->changed = TRUE;
                            }
                        }
                        break;
                }
            }

            // обрабатываем редакторские изменения в записях (битовый OR использован для гарантии выполнения метода posting() независимо от настроек препроцессора)
            $cancel = $this->posting($result_page) | $cancel;

            // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
            if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
        }



        // ===================================================================
        /**
        *  Обработка редактирования записей
        *
        *  @access  protected
        *  @param   string  $result_page    url страницы возврата (будет возвращен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function posting ( & $result_page ) {

            // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
            $cancel = FALSE;

            // если получены данные об изменениях и нет признака отмены постинга
            if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST])
            && (!isset($_POST[REQUEST_PARAM_NAME_IGNORE_POST]) || !$_POST[REQUEST_PARAM_NAME_IGNORE_POST])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // если работаем в демо режиме
                if ($this->config->demo) {
                    return $this->push_error("В демо версии запрещено редактировать администраторов.");
                }

                // цикл по измененным записям
                foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if (!isset($_POST[REQUEST_PARAM_NAME_POST_THISONE]) || isset($_POST[REQUEST_PARAM_NAME_POST_THISONE][$id])) {
                        $item_cancel = FALSE;

                        // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
                        $item = new stdClass;

                        // поле Прежний логин
                        $previous = isset($_POST['previous_' . ADMINS_POSTVAR_LOGIN][$id]) ? trim($_POST['previous_' . ADMINS_POSTVAR_LOGIN][$id]) : '';

                        // поле Логин
                        $item->login = isset($_POST[ADMINS_POSTVAR_LOGIN][$id]) ? trim(preg_replace('/[\s\t\r\n]+/', ' ', $_POST[ADMINS_POSTVAR_LOGIN][$id])) : '';

                            // нет логина, но раньше был?
                            if (($item->login == '') && ($previous != '')) {
                                $item_cancel = $this->push_error('Не указан логин, бывший ранее "' . $previous . '".');

                            // двоеточие в логине?
                            } elseif (strpos($item->login, ':') !== FALSE) {
                                $item_cancel = $this->push_error('Логин "' . $item->login . '" содержит недопустимый символ : (двоеточие).');
                            }

                        // поле Пароль
                        if (!$item_cancel) {
                            $pass = isset($_POST[ADMINS_POSTVAR_PASS][$id]) ? $_POST[ADMINS_POSTVAR_PASS][$id] : '';
                            $item->hash = $pass != '' ? $this->security->apr1Hash($pass) : '';

                                // нет пароля, но логин задан, и это логин нового админа?
                                if (($pass == '') && ($previous == '') && ($item->login != '')) {
                                    $item_cancel = $this->push_error('Не указан пароль для добавляемого администратора с логином "' . $item->login . '".');

                                // есть пароль нового админа, но логин не задан?
                                } elseif (($pass != '') && ($previous == '') && ($item->login == '')) {
                                    $item_cancel = $this->push_error('Не указан логин для добавляемого администратора.');

                                // двоеточие в хеше пароля?
                                } elseif (strpos($item->hash, ':') !== FALSE) {
                                    $item_cancel = $this->push_error('Пароль "' . $pass . '" не подходит, так как его хеш получается содержит недопустимый символ : (двоеточие).');
                                }

                            // поле Имя
                            if (!$item_cancel) {
                                $item->name = isset($_POST[ADMINS_POSTVAR_NAME][$id]) ? trim(preg_replace('/[\s\t\r\n]+/', ' ', $_POST[ADMINS_POSTVAR_NAME][$id])) : '';

                                    // есть имя нового админа, но логин не задан?
                                    if (($item->name != '') && ($previous == '') && ($item->login == '')) {
                                        $item_cancel = $this->push_error('Не указан логин для добавляемого администратора. Указывайте имя "' . $item->name . '" только вместе с логином.');

                                    // двоеточие в имени?
                                    } elseif (strpos($item->name, ':') !== FALSE) {
                                        $item_cancel = $this->push_error('Имя "' . $item->name . '" содержит недопустимый символ : (двоеточие).');
                                    }

                                // поле Права
                                if (!$item_cancel) {
                                    $item->rights = isset($_POST[ADMINS_POSTVAR_RIGHTS][$id]) ? trim(preg_replace('/[\s\t\r\n]+/', ' ', $_POST[ADMINS_POSTVAR_RIGHTS][$id])) : '';
                                    $item->rights = str_replace(' ,', ',', $item->rights);
                                    $item->rights = str_replace(', ', ',', $item->rights);
                                    $item->rights = trim($item->rights, ',');
                                    $item->rights = str_replace(',', ', ', $item->rights);

                                        // есть права нового админа, но логин не задан?
                                        if (($item->rights != '') && ($previous == '') && ($item->login == '')) {
                                            $item_cancel = $this->push_error('Не указан логин для добавляемого администратора. Указывайте права "' . $item->rights . '" только вместе с логином.');

                                        // двоеточие в правах?
                                        } elseif (strpos($item->rights, ':') !== FALSE) {
                                            $item_cancel = $this->push_error('Для логина "' . $item->login . '" права доступа "' . $item->rights . '" содержат недопустимый символ : (двоеточие).');
                                        }

                                    // добавляем нового или меняем логин, а такой логин уже был?
                                    if (!$item_cancel) {
                                        if (($item->login != $previous) && isset($this->items[$item->login])) {
                                            $item_cancel = $this->push_error('Логин "' . $item->login . '" уже существует.');
                                        }
                                    }
                                }
                            }
                        }

                        // если ошибок нет (не включился признак отмены)
                        if ($item->login != '') {
                            if (!$item_cancel) {

                                // создаем оперативную ссылку "удалить"
                                $this->operable_delete($item);

                                // если это обновляемая запись
                                if (($previous != '') && isset($this->items[$previous])) {

                                    // если не задали новый пароль, берем хеш старого
                                    if ($item->hash == '') $item->hash = $this->items[$previous]->hash;

                                    // обновляем запись
                                    if (($this->items[$previous]->login != $item->login)
                                    || ($this->items[$previous]->hash != $item->hash)
                                    || ($this->items[$previous]->name != $item->name)
                                    || ($this->items[$previous]->rights != $item->rights)) {
                                        $this->items[$previous] = $item;
                                        $this->changed = TRUE;
                                    }

                                // иначе запись утеряна (удалена) или это новая
                                } else {

                                    // если запись утеряна и не указали пароль, выдумываем другой
                                    if ($item->hash == '') {
                                        $pass = $this->security->generatePassword(8);
                                        $item->hash = $this->security->apr1Hash($pass);
                                        $item_cancel = $this->push_error('Видимо в сведениях об администраторах произошли сторонние изменения, пока вы редактировали страницу. Поэтому для логина "' . $item->login . '" нет возможности установить, какой пароль у него был ранее. Пароль заменен на <b>' . $pass . '</b>.');
                                    }

                                    // добавляем запись
                                    $this->items[$item->login] = $item;
                                    $this->changed = TRUE;
                                }

                                // если страница возврата не указана, используем рекомендуемую страницу
                                if (($result_page == '') && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
                            }

                            $cancel = $cancel || $item_cancel;
                        }
                    }
                }
            }

            // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
            return $cancel;
        }
    }



    return;
?>