<?php
    // =======================================================================
    /**
    *  Админ модуль купонов
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

    // TODO: позже заменить подгрузкой базового справочника для отказа от накладного "class N extends Products"
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_PRODUCTS_OBJECT);

    // текст заголовка страницы модуля
    define('COUPONS_PAGE_TITLE', 'Скидочные купоны');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('COUPONS_TEMPLATE_FILENAME', 'coupons/coupons.htm');
    define('COUPONS_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                    . COUPONS_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // типичное число записей на странице админпанели
    define('COUPONS_DEFAULT_ITEMS_PER_PAGE', 50);

    // какая папка содержит выкачиваемые на сервер изображения для купонов, если модулю нужна такая функция
    // (папку задаем относительно корневой папки магазина и со слешем на конце)
    define('COUPONS_UPLOAD_FOLDER', 'files/coupons/');

    // название сеансового параметра
    define('COUPONS_SESSION_PARAM_NAME', 'admin_coupons');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('COUPONS_MODULELINK_POINTER', 'Coupons');
    define('COUPONS_MODULETAB_TEXT', 'купоны');
    define('COUPONS_MODULEMENU_PATH', 'Клиенты / Скидочные купоны');



    // =======================================================================
    /**
    *  Админ модуль купонов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Coupons extends Products {

        // с какой таблицей базы данных работаем,
        // какое поле таблицы является идентификатором записей
        public $dbtable = DATABASE_COUPONS_TABLENAME;
        public $dbtable_field = 'coupon_id';

        // рекомендуемая страница возврата после операции
        public $result_page = '';

        // в какую папку на сервер выгружать изображения (относимые к записям БД)
        public $upload_folder = COUPONS_UPLOAD_FOLDER;

        // сколько записей размещать на странице
        protected $items_per_page = COUPONS_DEFAULT_ITEMS_PER_PAGE;

        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array('all_users');



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

            // если задан в настройках существует префикс папки изображений
            $field = DATABASE_COUPONS_TABLENAME . '_files_folder_prefix';
            if (isset($this->settings->$field)) {

                // сначала обезопасим префикс
                $prefix = $this->hdd->safeFilename($this->settings->$field);

                // добавляем префикс в имя папки для выгрузки изображений на сервер
                $this->upload_folder = $prefix . $this->upload_folder;
            }
        }



        // ===================================================================
        /**
        *  Обработка редактирования настроек модуля
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process_setup () {

            // если получены данные об изменениях настроек
            if (isset($_POST[REQUEST_PARAM_NAME_SETUP])) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->check_token();

                // настройка "Записей на странице админпанели"
                $name = 'coupons_num_admin';
                    $value = isset($_POST[$name]) ? intval($_POST[$name]) : COUPONS_DEFAULT_ITEMS_PER_PAGE;
                    if ($value < ITEMS_PER_PAGE_MINIMAL_VALUE) $value = ITEMS_PER_PAGE_MINIMAL_VALUE;
                    if ($value > ITEMS_PER_PAGE_MAXIMAL_VALUE) $value = ITEMS_PER_PAGE_MAXIMAL_VALUE;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - отображение - число записей на странице админпанели');

                // настройка "Запрещен для регистрации"
                $name = 'coupons_registration_disabled';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - обслуживание - убрать ли поле купона в форме регистрации');

                // настройка "Запрещен для корзины"
                $name = 'coupons_cart_disabled';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - обслуживание - убрать ли поле купона в корзине');

                // настройка "Максимальное число печати многоразовых"
                $name = 'coupons_max_print';
                    $value = isset($_POST[$name]) ? intval($_POST[$name]) : 20;
                    if ($value < 1) $value = 1;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - печать - максимальное число печати многоразовых');

                // настройка "Шаблон генерации кода"
                $name = 'coupons_code_pattern';
                    $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
                    if ($value == '') $value = '**** **** **** ****';

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - генерация - шаблон генерации контрольного кода купона');

                // настройка "Уведомлять админа по емейлу о регистрации"
                $name = 'coupons_reg_notify_admin_by_email';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли админу емейл о регистрации по купону');

                // настройка "Уведомлять админа по СМС о регистрации"
                $name = 'coupons_reg_notify_admin_by_sms';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли админу СМС о регистрации по купону');

                // настройка "Уведомлять партнера по емейлу о регистрации"
                $name = 'coupons_reg_notify_affiliate_by_email';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли партнеру емейл о регистрации по купону');

                // настройка "Уведомлять партнера по СМС о регистрации"
                $name = 'coupons_reg_notify_affiliate_by_sms';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли партнеру СМС о регистрации по купону');

                // настройка "Тема уведомления о регистрации"
                $name = 'coupons_reg_notify_subject';
                    $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
                    if ($value == '') $value = 'Активность по купону *: регистрация пользователя на сайте $';

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - тема уведомления о регистрации по купону');

                // настройка "Уведомлять админа по емейлу о заказе"
                $name = 'coupons_order_notify_admin_by_email';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли админу емейл о заказе по купону');

                // настройка "Уведомлять админа по СМС о заказе"
                $name = 'coupons_order_notify_admin_by_sms';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли админу СМС о заказе по купону');

                // настройка "Уведомлять партнера по емейлу о заказе"
                $name = 'coupons_order_notify_affiliate_by_email';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли партнеру емейл о заказе по купону');

                // настройка "Уведомлять партнера по СМС о заказе"
                $name = 'coupons_order_notify_affiliate_by_sms';
                    $value = isset($_POST[$name]) ? ($_POST[$name] ? 1 : 0) : 0;

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - отправлять ли партнеру СМС о заказе по купону');

                // настройка "Тема уведомления о заказе"
                $name = 'coupons_order_notify_subject';
                    $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
                    if ($value == '') $value = 'Активность по купону *: оформлен заказ # на сумму $ на сайте &';

                    // сохраняем
                    $this->db->settings->save($name, $value, 'Купоны - уведомления - тема уведомления о заказе по купону');

                // очищаем кеш-таблицы
                $this->resetCaches();
            }
        }



        // ===================================================================
        /**
        *  Обработка редактирования записей
        *
        *  @access  protected
        *  @param   string  $result_page    адрес страницы возврата из операции (будет возвращен в эту переменную)
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

                // цикл по измененным записям
                foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if (!isset($_POST[REQUEST_PARAM_NAME_POST_THISONE]) || isset($_POST[REQUEST_PARAM_NAME_POST_THISONE][$id])) {
                        $item_cancel = FALSE;
                        $value = $this->dbtable_field;

                        // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
                        $this->item = null;
                        $this->posting_check($this->item, $id, $item_cancel);

                        // поле идентификатора записи
                        if (!empty($this->item)) {
                            if (!empty($id)) {
                                // это не добавление новой записи, поэтому устанавливаем ее идентификатор
                                $this->item->$value = $id;
                            } else {
                                // если не передано значение даты создания для новой записи, ставим ее равной текущей дате
                                if (!isset($this->item->created)) $this->item->created = time();
                            }
                        }

                        // если ошибок нет (не включился признак отмены)
                        if (!$item_cancel && !empty($this->item)) {

                            // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
                            $this->item->indifferent_caches = TRUE;
                            $changed = $this->update($this->item) != '';
                            $this->changed = $changed || $this->changed;

                            // если запись обновлена и требовали уведомить участников
                            $inform_user = isset($_POST['inform_user'][$id]) && $_POST['inform_user'][$id];
                            $inform_user_sms = isset($_POST['inform_user_sms'][$id]) && $_POST['inform_user_sms'][$id];
                            $inform_admin = isset($_POST['inform_admin'][$id]) && $_POST['inform_admin'][$id];
                            $inform_admin_sms = isset($_POST['inform_admin_sms'][$id]) && $_POST['inform_admin_sms'][$id];
                            $inform_testing = isset($_POST['inform_testing'][$id]) && $_POST['inform_testing'][$id];
                            if ($changed && ($inform_user
                                         || $inform_user_sms
                                         || $inform_admin
                                         || $inform_admin_sms)) $this->inform($this->item,
                                                                              $inform_user,
                                                                              $inform_user_sms,
                                                                              $inform_admin,
                                                                              $inform_admin_sms,
                                                                              $inform_testing);

                            // если страница возврата не указана, используем рекомендуемую страницу
                            if (($result_page == '') && !isset($_POST[REQUEST_PARAM_NAME_POST_AS_ACCEPT])) $result_page = trim($this->result_page);
                        }

                        $cancel = $cancel || $item_cancel;
                    }
                }
            }

            // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
            return $cancel;
        }



        // ===================================================================
        /**
        *  Обработка содержимого полей отредактированной записи с проверкой на ошибки
        *
        *  @access  protected
        *  @param   object  $item       запись
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     признак отмены записи (будет возвращен в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function posting_check ( & $item, $id, & $cancel ) {

            // поле Название
            $field = 'name';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
            }

            // поле Контрольный код
            $field = 'code';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsSentence($field, $id);
                if ($value == '') {
                    $cancel = $this->push_error('Не указан контрольный код купона.');
                } else {

                    // проверяем наличие другого купона с таким кодом
                    $params = new stdClass;
                    if (!empty($id)) $params->exclude_id = $id;
                    $params->code = $value;
                    $params->deleted = 0;
                    $this->db->coupons->one($row, $params);
                    if (!empty($row)) $cancel = $this->push_error('Уже есть другая запись с аналогичным кодом.');
                }
                $item->$field = $value;
            }

            // поле Печатная форма
            $field = 'printer';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsInteger($field, $id, 1);
                $value = $this->number->mustbeIntegerRange($value, 1);
                $item->$field = $value;
            }

            // поле Остаток разов использования
            $field = 'count';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsInteger($field, $id, 1);
                $value = $this->number->mustbeIntegerRange($value, 1);
                $item->$field = $value;
            }

            // поле Разовая скидка
            $field = 'discount';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsFloat($field, $id);
                $value = $this->number->mustbeRange($value, 0, 100);
                $item->$field = $value;
            }

            // поле Группа скидок
            $field = 'group_id';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsInteger($field, $id);
            }

            // поле Ценовая группа
            $field = 'price_id';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsInteger($field, $id);
            }

            // поле Партнер
            $field = 'affiliate_id';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsInteger($field, $id);
            }

            // поле Пользователь
            $field = 'user_id';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsInteger($field, $id);
            }

            // поле Погасивший заказ
            $field = 'order_id';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsInteger($field, $id);
            }

            // поле Разрешено
            $field = 'enabled';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsBoolean($field, $id);
            }

            // поле Удалено
            $field = 'deleted';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsBoolean($field, $id);
            }

            // поле Срок действия
            $field = 'lifetime';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsInteger($field, $id);
                $value = $this->number->mustbeIntegerRange($value, 0);
                $item->$field = $value;
            }

            // поле Дата погашения
            $field = 'discharged';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsDate($field, $id, 0);
            }

            // поле Емейл
            $field = 'email';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsSentence($field, $id);
                if (($value != '') && !preg_match(EMAIL_CHECKING_PATTERN, $value)) {
                    $cancel = $this->push_error('Емейл должен быть указан в общепринятом формате!');
                }
                $item->$field = $value;
            }

            // поле Телефон
            $field = 'phone';
            if ($this->request->isPostedRecordField($field, $id)) {
                $value = $this->request->getPostRecordFieldAsSentence($field, $id);
                if (($value != '') && !preg_match(PHONE_CHECKING_PATTERN, $value)) {
                    $cancel = $this->push_error('Телефон должен быть указан в общепринятом формате!');
                }
                $item->$field = $value;
            }

            // поле Дата создания
            $field = 'created';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->date->fixDate($_POST[$field][$id]);
            }

            // поле Дата изменения
            $field = 'modified';
            if ($this->request->isPostedRecordField($field, $id)) {
                $item->$field = $this->request->getPostRecordFieldAsDate($field, $id);
            }
        }



        // ===================================================================
        /**
        *  Обновление записи в базе данных
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @return  integer             ПУСТАЯ СТРОКА или идентификатор обновленной / добавленной записи
        */
        // ===================================================================

        protected function update ( & $item ) {
            return $this->db->coupons->update($item);
        }



        // ===================================================================
        /**
        *  Очистка соответствующих кеш-таблиц
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function resetCaches () {
        }



        // ===================================================================
        /**
        *  Уведомление участников об изменениях в записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   boolean $user       TRUE если информировать пользователя по емейлу
        *  @param   boolean $user_sms   TRUE если информировать пользователя по SMS
        *  @param   boolean $admin      TRUE если информировать админа по емейлу
        *  @param   boolean $admin_sms  TRUE если информировать админа по SMS
        *  @param   boolean $testing    TRUE если тестовый режим
        *  @return  void
        */
        // ===================================================================

        protected function inform ( & $item, $user = FALSE, $user_sms = FALSE, $admin = FALSE, $admin_sms = FALSE, $testing = FALSE ) {
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
            $this->title = ADMIN_PAGE_TITLE_PREFIX . COUPONS_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = COUPONS_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . COUPONS_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->settings->admin_theme)
                  . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

            // задаем значения по умолчанию некоторых элементов html-формы
            $defaults = new stdClass;
            $defaults->param = COUPONS_SESSION_PARAM_NAME;
            $defaults->sort = SORT_COUPONS_MODE_BY_CODE;
            $defaults->sort_direction = SORT_DIRECTION_ASCENDING;
            $defaults->sort_laconical = 1;
            $defaults->view_mode = VIEW_MODE_STANDARD;
            $defaults->filter_manually = 0;

            // обрабатываем редактирование настроек модуля
            $this->process_setup();

            // если в настройках сайта задано свое количество "сколько записей размещать на странице"
            if (isset($this->settings->coupons_num_admin) && !empty($this->settings->coupons_num_admin)) {
                $this->items_per_page = intval($this->settings->coupons_num_admin);
            }
            if ($this->items_per_page < ITEMS_PER_PAGE_MINIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MINIMAL_VALUE;
            if ($this->items_per_page > ITEMS_PER_PAGE_MAXIMAL_VALUE) $this->items_per_page = ITEMS_PER_PAGE_MAXIMAL_VALUE;

            // обрабатываем входные параметры
            $this->process($defaults);

            // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $this->collect_inputs($inputs, $params, $defaults);

            // читаем список записей на текущей странице согласно параметрам фильтра и сортировки
            $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            $params->start = $current_page * $this->items_per_page;
            $params->maxcount = $this->items_per_page;
            $count = $this->db->coupons->get($items, $params);
            $this->db->coupons->unpackRecords($items);

            // создаем контент листания страниц
            if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
            if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
            if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
            if (isset($params->view_mode)) $this->params[REQUEST_PARAM_NAME_VIEW_MODE] = $params->view_mode;
            if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
            if (isset($params->group_id)) $this->params[REQUEST_PARAM_NAME_FILTER_GROUP] = $params->group_id;
            if (isset($params->price_id)) $this->params[REQUEST_PARAM_NAME_FILTER_PRICEGROUP] = $params->price_id;
            if (isset($params->user_id)) $this->params[REQUEST_PARAM_NAME_FILTER_USER] = $params->user_id;
            if (isset($params->affiliate_id)) $this->params[REQUEST_PARAM_NAME_FILTER_AFFILIATE] = $params->affiliate_id;
            if (isset($params->done)) $this->params[REQUEST_PARAM_NAME_FILTER_DONE] = $params->done;
            if (isset($params->enabled)) $this->params[REQUEST_PARAM_NAME_FILTER_ENABLED] = $params->enabled;
            if (isset($params->deleted)) $this->params[REQUEST_PARAM_NAME_FILTER_DELETED] = $params->deleted;
            if (isset($params->search)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCH] = $params->search;
            if (isset($params->search_date_from)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM];
            if (isset($params->search_date_to)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO] = $inputs[REQUEST_PARAM_NAME_FILTER_SEARCHDATETO];
            $pages_num = $count / $this->items_per_page;
            $navigator = new PagesNavigation($this);
            $navigator->make($pages_num, $count);

            // добавляем в записи оперативные ссылки админпанели
            $params->token = $this->token;
            $this->db->coupons->operable($items, $params);

            $where = '`' . $this->dbtable . '`.`deleted` = ' . (isset($params->deleted) && $params->deleted ? 1 : 0);

            // читаем список ИДов задействованных пользователей
            $user_ids = $this->db->coupons->getIds('user_id', $where);

            // читаем список ИДов задействованных партнеров
            $affiliate_ids = $this->db->coupons->getIds('affiliate_id', $where);

            // читаем список ИДов задействованных групп скидок
            $group_ids = $this->db->coupons->getIds('group_id', $where);

            // читаем список групп скидок
            $this->db->get_groups_array($groups, GET_GROUPS_MODE_FOR_AUTHORIZED);

            // читаем список ИДов задействованных ценовых групп
            $price_ids = $this->db->coupons->getIds('price_id', $where);

            // читаем список ИДов задействованных печатных форм
            $printer_ids = $this->db->coupons->getIds('printer', $where);

            // передаем нужные данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
            $this->smarty->assignByRef('user_ids', $user_ids);
            $this->smarty->assignByRef('affiliate_ids', $affiliate_ids);
            $this->smarty->assignByRef('groups', $groups);
            $this->smarty->assignByRef('group_ids', $group_ids);
            $this->smarty->assignByRef('price_ids', $price_ids);
            $this->smarty->assignByRef('printer_ids', $printer_ids);
            $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
            $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
            $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);

            return TRUE;
        }



        // ===================================================================
        /**
        *  Генерация контрольного кода купона
        *
        *  @access  public
        *  @return  string      код (на основе шаблона из настроек сайта)
        */
        // ===================================================================

        public function generate_code () {

            // берем шаблон кода из настроек сайта
            $pattern = isset($this->settings->coupons_code_pattern) ? trim($this->settings->coupons_code_pattern) : '';
            if (($pattern == '') || (strpos($pattern, '*') === FALSE)
                                 && (strpos($pattern, '#') === FALSE)
                                 && (strpos($pattern, '&') === FALSE)) $pattern = '**** **** **** ****';

            // генерируем код
            $result = '';
            while ($pattern != '') {

                // отрезаем из шаблона по символу
                $char = substr($pattern, 0, 1);
                $pattern = substr($pattern, 1);

                // в шаблоне символы *, #, & имеют особое значение (буква или число, число, буква)
                $digit = rand(0, 1) == 1;
                if (($char == '#') || ($char == '*') && $digit) $char = chr(ord('0') + rand(0, 9));
                elseif (($char == '&') || ($char == '*') && !$digit) $char = chr(ord('A') + rand(0, 25));

                // клеим в код преобразованный символ
                $result .= $char;
            }

            // возвращаем сгенерированный код
            return $result;
        }
    }



    return;
?>