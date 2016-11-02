<?php
    // макет справочника клиентской стороны
    require_once(dirname(__FILE__) . '/BasicClientModel.php');



    // =======================================================================
    /**
    *  Макет обратной связи
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class FeedbackREFModel extends BasicClientREFModel {

        // дефолтный заголовок модуля
        protected $default_title = 'Обратная связь';

        // сообщения
        protected $success_msg = 'Спасибо! Ваше сообщение принято.';
            protected $name_msg = 'Вы не ввели имя!';
            protected $nickname_msg = 'Ник не должен быть емейлом, телефоном, номером ICQ и тому подобным!';
            protected $contacts_msg = 'Вы не указали свои контактные данные!';
                protected $email_msg = 'Вы не ввели емейл!';
                    protected $email_msg2 = 'Емейл нужно указать в стандартной форме, например ivanov@example.com!';
                protected $phone_msg = 'Вы не ввели телефон!';
                    protected $phone_msg2 = 'Телефон нужно указать в международном формате, например +7 123 456-78-90!';
                protected $skype_msg = 'Вы не ввели skype имя!';
                    protected $skype_msg2 = 'Skype имя нужно указать в стандартной форме!';
                protected $icq_msg = 'Вы не ввели номер icq!';
                    protected $icq_msg2 = 'Номер icq должен состоять из одних цифр количеством не менее 5!';
            protected $message_msg = 'Вы не ввели текст сообщения!';
            protected $login_msg = 'Вы не ввели логин!';
            protected $password_msg = 'Вы не ввели пароль!';
                protected $password_msg2 = 'Пароль и его повторный ввод должны совпадать!';
            protected $other_msg = 'Не заполнено обязательное поле!';
            protected $captcha_msg = 'Введите правильное число с картинки.';
            protected $technical_msg = 'Не удалось сохранить ваше сообщение в базе данных по техническим причинам на сайте.';
            // текст о блокировке, когда этот текст в настройках не заполнен
            protected $banned_msg = 'Ваш компьютер занесён в чёрный список спамеров!';

        // категория личных настроек модуля
        public $settings_category = 'Обратная связь';

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'feedback';

        // шаблоны тем письма админу и клиенту, могут содержать теги:
        //    [date] = дата создания
        //    [site] = корень магазина
        //    [user] = имя пользователя
        //    [nick] = ник пользователя
        //    [email] = емейл пользователя
        //    [phone] = телефон пользователя
        //    [skype] = скайп пользователя
        //    [icq] = ICQ пользователя
        protected $email_subject = 'Новое сообщение: [date] на сайте [site] от [user]';
        protected $email_subject_user = 'Уведомление: принято ваше сообщение в обратную связь на сайте [site]';

        // имя файла шаблона письма (относительно папки текущего шаблона)
        protected $template_email = 'email/feedback-to-admin.htm';
        protected $template_email_user = 'email/feedback-to-user.htm';
        protected $template_sms = 'sms/feedback-to-admin.htm';
        protected $template_sms_user = 'sms/feedback-to-user.htm';

        // список обрабатываемых полей опубликованной формы
        protected $fields = array('department' => array('Служба доставки', 'Техническая поддержка', 'Финансовый отдел', 'Руководитель'),
                                  'subject',
                                  'name' => '+',
                                  array('phone' => '*', 'phone2' => '*'),
                                  array('email' => '*', 'email2' => '*'),
                                  array('skype', 'skype2'),
                                  array('icq', 'icq2'),
                                  'message' => '+',
                                  'copystop');

        // имя модели базы данных (или массив имен)
        protected $dbmodel = 'feedback';

        // префикс имен полей формы
        protected $post_prefix = 'feedback_';

        // через сколько секунд возможно постить следующую форму
        protected $post_next_lifetime = 180;

        // основа для парольных хешей
        protected $salt = 'imperacms';



        // ===================================================================
        /**
        *  Проверка / создание личных настроек модуля
        *
        *  @access  public
        *  @param   string  $settings   массив настроек (формат элемента описан в BasicREFModelConf)
        *  @return  void
        */
        // ===================================================================

        public function checkModuleSettings ( $settings = null ) {
            $settings = array('captcha_disabled'    => array(0, 'Отключена ли капча'),
                              'next_lifetime'       => array($this->post_next_lifetime, 'Антиспам пауза в секундах между постами'),
                              'email_disabled'      => array(0, 'Отключен ли емейл админу об успешном принятии формы'),
                              'sms_disabled'        => array(1, 'Отключена ли SMS админу об успешном принятии формы'),
                              'email_user_disabled' => array(1, 'Отключен ли емейл клиенту об успешном принятии формы'),
                              'sms_user_disabled'   => array(1, 'Отключена ли SMS клиенту об успешном принятии формы'));
            parent::checkModuleSettings($settings);
        }



        // ===================================================================
        /**
        *  Получение префикса имен полей формы
        *
        *  @access  protected
        *  @return  string          префикс
        */
        // ===================================================================

        protected function getPostPrefix () {
            $field = 'post_prefix';
            return isset($this->$field)
                && (is_string($this->$field)
                || is_numeric($this->$field)) ? trim($this->$field) : '';
        }



        // ===================================================================
        /**
        *  Генерация контрольного кода репостинга формы
        *
        *  @access  protected
        *  @return  integer         код
        */
        // ===================================================================

        protected function generateCopystop () {
            return rand(1, 2 * 1024 * 1024 * 1024 - 2);
        }



        // ===================================================================
        /**
        *  Добавление опубликованной записи в базу данных
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $created    штамп времени создания
        *  @param   string  $ip         IP публиковавшего
        *  @param   string  $host       хост публиковавшего
        *  @param   mixed   $data       некие инфо данные (полученные от проверки конфликтов)
        *  @return  integer             идентификатор записи
        */
        // ===================================================================

        protected function addPostedRecord ( & $item, & $created, $ip, $host, & $data = null ) {
            $item->ip = $ip;
            $item->host = $host;
            $item->date = & $created;
            $item->from_user = $this->existsUser() ? $this->cms->user->user_id : 0;
            $item->new = 1;

            $dbmodel = $this->getDBModel();
            $idfield = $this->cms->db->$dbmodel->getIDField();
            $item->$idfield = $this->cms->db->$dbmodel->update($item);
            return $item->$idfield;
        }



        // ===================================================================
        /**
        *  Формирование темы письма по шаблону
        *
        *  @access  protected
        *  @param   string  $pattern    строка-шаблон, может содержать теги:
        *                                   [date] = дата создания
        *                                   [site] = корень магазина
        *                                   [user] = имя пользователя
        *                                   [nick] = ник пользователя
        *                                   [email] = емейл пользователя
        *                                   [phone] = телефон пользователя
        *                                   [skype] = скайп пользователя
        *                                   [icq] = ICQ пользователя
        *  @param   object  $item       объект записи
        *  @param   integer $created    штамп времени создания
        *  @return  string              тема
        */
        // ===================================================================

        protected function subjectByTemplate ( $pattern, & $item, $created ) {
            $tags = array(
                '[date]' => $created,
                '[site]' => $this->cms->root_url,
                '[name]' => $this->poster->getName($item, $this->cms->user, 'Безымянный'),
                '[nick]' => $this->poster->getNickname($item, $this->cms->user, 'БезНика'),
                '[email]' => $this->poster->getEmail($item, $this->cms->user, 'БезЕмейла'),
                '[phone]' => $this->poster->getPhone($item, $this->cms->user, 'БезТелефона'),
                '[skype]' => $this->poster->getSkype($item, $this->cms->user, 'БезСкайпа'),
                '[icq]' => $this->poster->getIcq($item, $this->cms->user, 'БезICQ')
            );
            foreach ($tags as $tag => $value) $pattern = str_replace($tag, $value, $pattern);
            return $pattern;
        }



        // ===================================================================
        /**
        *  Уведомление администратора о принятом сообщении
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $created    штамп времени создания
        *  @return  void
        */
        // ===================================================================

        protected function informAdmin ( & $item, $created ) {
            $dbmodel = $this->getDBModel();
            $subject = $this->subjectByTemplate($this->email_subject, $item, $created);
            if (!$this->settings->get($dbmodel . '_email_disabled')) {
                $this->messenger->sendByTemplate('email',
                                                 $subject,
                                                 $this->template_email,
                                                 $item,
                                                 $this->cms->user);
            }
            if (!$this->settings->get($dbmodel . '_sms_disabled')) {
                $this->messenger->sendByTemplate('sms',
                                                 $subject,
                                                 $this->template_sms,
                                                 $item,
                                                 $this->cms->user);
            }
        }



        // ===================================================================
        /**
        *  Уведомление пользователя о принятом сообщении
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $created    штамп времени создания
        *  @return  void
        */
        // ===================================================================

        protected function informUser ( & $item, $created ) {
            $dbmodel = $this->getDBModel();
            $subject = $this->subjectByTemplate($this->email_subject_user, $item, $created);
            if (!$this->settings->get($dbmodel . '_email_user_disabled')) {
                $to = $this->poster->getEmail($item, $this->cms->user);
                $this->messenger->sendByTemplate('email',
                                                 $subject,
                                                 $this->template_email_user,
                                                 $item,
                                                 $this->cms->user,
                                                 $to);
            }
            if (!$this->settings->get($dbmodel . '_sms_user_disabled')) {
                $to = $this->poster->getPhone($item, $this->cms->user);
                $this->messenger->sendByTemplate('sms',
                                                 $subject,
                                                 $this->template_sms_user,
                                                 $item,
                                                 $this->cms->user,
                                                 $to);
            }
        }



        // ===================================================================
        /**
        *  Проверка внешних конфликтов с существующими данными
        *
        *  @access  protected
        *  @param   object  $item           объект записи
        *  @param   array   $bad_fields     массив полей с ошибками
        *  @param   mixed   $data           некие инфо данные (будут возвращены в эту переменную)
        *  @return  boolean                 TRUE если замечен конфликт
        */
        // ===================================================================

        protected function checkExternalConflicts ( & $item, & $bad_fields, & $data = null ) {
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка внутренних конфликтов с существующими данными
        *
        *  @access  protected
        *  @param   object  $item           объект записи
        *  @param   array   $bad_fields     массив полей с ошибками
        *  @param   mixed   $data           некие инфо данные (полученные от проверки внешних конфликтов)
        *  @return  boolean                 TRUE если замечен конфликт
        */
        // ===================================================================

        protected function checkInternalConflicts ( & $item, & $bad_fields, & $data = null ) {
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка отказа в публикации формы
        *
        *  @access  protected
        *  @param   string  $ip     проверяемый IP
        *  @return  boolean         TRUE если отказано
        */
        // ===================================================================

        protected function checkFormDisallow ( $ip = null ) {

            // если не указан, берем IP-адрес пользователя
            if (!is_string($ip)) $ip = $this->security->getVisitorIp();

            // проверяем наличие бана
            if ($this->checkBanned($ip)) {
                $msg = $this->settings->getAsSentence('banneds_nocomment_text');
                if ($msg == '') $msg = $this->banned_msg;
                return $this->pushError($msg);
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка блокировки для указанного IP-адреса
        *
        *  @access  protected
        *  @param   string  $ip     проверяемый IP
        *  @return  boolean         TRUE если блокировка есть
        */
        // ===================================================================

        protected function checkBanned ( $ip ) {

            // ищем неотмененный запрет доступа к комментариям для такого IP-адреса
            // (включив проверку даты действия запрета)
            $row = null;
            $filter = new stdClass;
            $filter->ip = $ip;
            $filter->enabled = 1;
            $filter->no_comment = 1;
            $filter->date = 1;
            $this->cms->db->get_banned($row, $filter);

            // если запрета доступа нет
            if (empty($row)) return FALSE;

            // регистрируем +1 попытку доступа
            $filter = new stdClass;
            $filter->ban_id = $row->ban_id;
            $filter->attempts = $row->attempts + 1;
            $filter->attempts_date = time();
            $this->cms->db->update_banned($filter);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Перебор полей объекта воображаемой записи с вызовом callback-метода
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   string  $callback   имя метода
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function enumItemFields ( & $item, $callback, & $extra = null ) {
            if (empty($this->fields) || !is_array($this->fields)) {
                return $this->pushError('В объекте класса ' . get_class($this) . ' '
                                      . 'не заполнен список обрабатываемых полей');
            }
            $cancel = FALSE;
            if (is_string($callback) && method_exists($this, $callback)) {
                foreach ($this->fields as $key => $values) {
                    if (is_string($key)) {
                        if (!is_array($values)) $values = array($values);
                        $names = array($key => $values);
                    } else if (is_string($values)) {
                        $names = array($values => array());
                    } else if (!is_array($values) || empty($values)) {
                        continue;
                    } else {
                        $names = $values;
                    }
                    foreach ($names as $key => $values) {
                        if (is_string($key)) {
                            $field = $key;
                            if (!is_array($values)) $values = array($values);
                        } else if (is_string($values)) {
                            $field = $values;
                            $values = array();
                        } else continue;
                        $cancel = $this->$callback($item, $field, $values, $extra) | $cancel;
                    }
                }
            }
            return $cancel;
        }



        // ===================================================================
        /**
        *  Callback-метод: Извлечение поля опубликованной формы в объект
        *  воображаемой записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи (поле будет помещено сюда)
        *  @param   string  $field      имя поля
        *  @param   mixed   $values     возможные значения поля
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function getFormField ( & $item, $field, $values, & $extra = null ) {
            $prefix = $this->getPostPrefix();
            switch ($field) {
                case 'captcha':
                case 'captcha_code':
                case '':
                    return FALSE;
                case 'message':
                    $value = $this->request->getRequest($prefix . $field, '');
                    $value = trim($this->text->stripTags($value));
                    break;
                case 'password':
                case 'password2':
                    $value = $this->request->getRequest($prefix . $field, '');
                    $value = $this->text->stripTags($value);
                    break;
                case 'department':
                case 'subject':
                case 'nickname':
                case 'name':
                case 'name2':
                case 'name3':
                case 'phone':
                case 'phone2':
                case 'email':
                case 'email2':
                case 'skype':
                case 'skype2':
                case 'icq':
                case 'icq2':
                case 'reason':
                case 'coupon':
                case 'login':
                    $value = $this->request->getRequestAsSentence($prefix . $field);
                    $value = $this->text->stripTags($value, TRUE);
                    break;
                case 'copystop':
                    $value = $this->request->getRequestAsSentence($prefix . $field);
                    $value = $this->text->stripTags($value, TRUE);
                    if ($value == '') $value = $this->generateCopystop();
                    break;
                default:
                    $value = $this->request->getRequestAsSentence($prefix . $field);
                    $value = $this->text->stripTags($value, TRUE);
            }
            $item->$field = $value;
            return FALSE;
        }



        // ===================================================================
        /**
        *  Callback-метод: Проверка наличия поля в опубликованной форме
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   mixed   $values     возможные значения поля
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если поле найдено
        */
        // ===================================================================

        protected function checkItemFieldPosted ( & $item, $field, $values, & $extra = array() ) {
            $prefix = $this->getPostPrefix();
            switch ($field) {
                case 'copystop':
                case 'captcha':
                case 'captcha_code':
                case '':
                    break;
                case 'nickname':
                case 'name':
                case 'name2':
                case 'name3':
                case 'email':
                case 'email2':
                case 'phone':
                case 'phone2':
                case 'skype':
                case 'skype2':
                case 'icq':
                case 'icq2':
                case 'reason':
                case 'message':
                case 'department':
                case 'subject':
                case 'coupon':
                case 'login':
                case 'password':
                case 'password2':
                default:
                    return isset($_POST[$prefix . $field]);
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Callback-метод: Проверка заполненности поля объекта воображаемой
        *  записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   mixed   $values     возможные значения поля
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function checkItemField ( & $item, $field, $values, & $extra = array() ) {
            $prefix = $this->getPostPrefix();
            if (is_array($values) && count($values) == 1
            && (in_array(0, $values, TRUE) || in_array(0.0, $values, TRUE))) {
                $required = FALSE;
            } else {
                $required = is_string($values) && ($values == '+' || $values != '*' && $values != '')
                         || is_int($values) && !empty($values)
                         || is_float($values) && $values != 0
                         || is_array($values) && in_array('+', $values)
                         || is_array($values) && !empty($values) && !in_array('*', $values) && !in_array('', $values, TRUE);
            }
            switch ($field) {
                case 'copystop':
                case 'captcha':
                case 'captcha_code':
                case '':
                    return FALSE;
                case 'name':
                case 'name2':
                case 'name3':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->name_msg;
                            return $this->pushError($this->name_msg);
                        }
                    }
                    break;
                case 'login':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->login_msg;
                            return $this->pushError($this->login_msg);
                        }
                    }
                    break;
                case 'email':
                case 'email2':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->email_msg;
                            return $this->pushError($this->email_msg);
                        }
                    }
                    if ($this->getProperty($item, $field) != '' && !preg_match(EMAIL_CHECKING_PATTERN, $item->$field)) {
                        $extra[$prefix . $field] = $this->email_msg2;
                        return $this->pushError($this->email_msg2);
                    }
                    break;
                case 'phone':
                case 'phone2':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->phone_msg;
                            return $this->pushError($this->phone_msg);
                        }
                    }
                    if ($this->getProperty($item, $field) != '' && !preg_match(PHONE_CHECKING_PATTERN, $item->$field)) {
                        $extra[$prefix . $field] = $this->phone_msg2;
                        return $this->pushError($this->phone_msg2);
                    }
                    break;
                case 'skype':
                case 'skype2':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->skype_msg;
                            return $this->pushError($this->skype_msg);
                        }
                    }
                    if ($this->getProperty($item, $field) != '' && !preg_match(SKYPE_CHECKING_PATTERN, $item->$field)) {
                        $extra[$prefix . $field] = $this->skype_msg2;
                        return $this->pushError($this->skype_msg2);
                    }
                    break;
                case 'icq':
                case 'icq2':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->icq_msg;
                            return $this->pushError($this->icq_msg);
                        }
                    }
                    if ($this->getProperty($item, $field) != '' && !preg_match(ICQ_CHECKING_PATTERN, $item->$field)) {
                        $extra[$prefix . $field] = $this->icq_msg2;
                        return $this->pushError($this->icq_msg2);
                    }
                    break;
                case 'reason':
                case 'message':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->message_msg;
                            return $this->pushError($this->message_msg);
                        }
                    }
                    break;
                case 'password':
                case 'password2':
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->password_msg;
                            return $this->pushError($this->password_msg);
                        }
                    }
                    if (isset($item->$field)) {
                        $field2 = $field == 'password' ? $field . '2' : rtrim($field, '2');
                        if (isset($item->$field2) && $item->$field != $item->$field2) {
                            $extra[$prefix . $field] = $this->password_msg2;
                            return $this->pushError($this->password_msg2);
                        }
                    }
                    break;
                case 'nickname':
                    if ($this->getProperty($item, $field) != '') {
                        if (preg_match(EMAIL_CHECKING_PATTERN, $item->$field)
                        || preg_match(PHONE_CHECKING_PATTERN, $item->$field)
                        || preg_match(ICQ_CHECKING_PATTERN, $item->$field)) {
                            $extra[$prefix . $field] = $this->nickname_msg;
                            return $this->pushError($this->nickname_msg);
                        }
                    }
                    break;
                case 'department':
                case 'subject':
                case 'coupon':
                default:
                    if ($required) {
                        if ($this->getProperty($item, $field) == '') {
                            $extra[$prefix . $field] = $this->other_msg;
                            return $this->pushError($this->other_msg);
                        }
                    }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Проверка заполненности полей объекта воображаемой записи, когда
        *  проверка полей по одному прошла успешно
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function checkItemFields ( & $item, & $extra = null ) {
            return FALSE;
        }



        // ===================================================================
        /**
        *  Callback-метод: Очистка поля объекта воображаемой записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   mixed   $values     возможные значения поля
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function clearItemField ( & $item, $field, $values, & $extra = null ) {
            switch ($field) {
                case 'captcha':
                case 'captcha_code':
                case '':
                    return FALSE;
                case 'department':
                case 'subject':
                case 'nickname':
                case 'name':
                case 'name2':
                case 'name3':
                case 'phone':
                case 'phone2':
                case 'email':
                case 'email2':
                case 'skype':
                case 'skype2':
                case 'icq':
                case 'icq2':
                case 'reason':
                case 'message':
                case 'coupon':
                case 'login':
                case 'password':
                case 'password2':
                    $item->$field = '';
                    break;
                case 'copystop':
                    $item->$field = $this->generateCopystop();
                    break;
                default: $item->$field = '';
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Callback-метод: Заполнение дефолтным значением пустого поля объекта
        *  воображаемой записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   mixed   $values     возможные значения поля
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function defaultItemField ( & $item, $field, $values, & $extra = null ) {
            if (isset($item->$field)) {
                switch ($field) {
                    case 'copystop':
                    case 'captcha':
                    case 'captcha_code':
                    case '':
                        return FALSE;
                    case 'department':
                    case 'subject':
                    case 'reason':
                    case 'message':
                    case 'coupon':
                    case 'password':
                    case 'password2':
                        break;
                    case 'nickname':
                        if ($item->$field == '' && isset($this->cms->user->$field)) $item->$field = trim($this->cms->user->$field);
                        break;
                    case 'name':
                        if ($item->$field == '') {
                            if (isset($item->name2) || isset($item->name3)) {
                                if (isset($this->cms->user->$field)) $item->$field = trim($this->cms->user->$field);
                            } else {
                                if (isset($this->cms->user->compound_name)) $item->$field = trim($this->cms->user->compound_name);
                            }
                        }
                        break;
                    case 'name2':
                    case 'name3':
                        if ($item->$field == '') {
                            if (isset($this->cms->user->$field)) $item->$field = trim($this->cms->user->$field);
                            $value = isset($this->cms->user->compound_name) ? trim($this->cms->user->compound_name) : '';
                            if ($value != '' && isset($item->name) && $item->name == $value) {
                                if (isset($this->cms->user->name)) $item->name = trim($this->cms->user->name);
                            }
                        }
                        break;
                    case 'login':
                        if ($item->$field == '') {
                            $value = '';
                            if (isset($this->cms->user->email)) $value = trim($this->cms->user->email);
                            if ($value == '' && isset($this->cms->user->email2)) $value = trim($this->cms->user->email2);
                            if ($value != '') $item->$field = $value;
                        }
                        break;
                    case 'phone':
                    case 'email':
                    case 'skype':
                    case 'icq':
                        if ($item->$field == '') {
                            $value = '';
                            if (isset($this->cms->user->$field)) $value = trim($this->cms->user->$field);
                            $field2 = $field . '2';
                            if ($value == '' && isset($this->cms->user->$field2)) $value = trim($this->cms->user->$field2);
                            if ($value != '') {
                                if (!isset($item->$field2) || $item->$field2 != $value) {
                                    $item->$field = $value;
                                }
                            }
                        }
                        break;
                    case 'phone2':
                    case 'email2':
                    case 'skype2':
                    case 'icq2':
                        if ($item->$field == '' && isset($this->cms->user->$field)) {
                            $value = trim($this->cms->user->$field);
                            if ($value != '') {
                                $field2 = rtrim($field, '2');
                                if (!isset($item->$field2) || $item->$field2 != $value) {
                                    $item->$field = $value;
                                }
                            }
                        }
                        break;
                    default:
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Callback-метод: Передача поля объекта воображаемой записи в
        *  шаблонизатор
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   mixed   $values     возможные значения поля
        *  @param   mixed   $extra      дополнительные данные
        *  @return  boolean             TRUE если найдена ошибка
        */
        // ===================================================================

        protected function assignItemField ( & $item, $field, $values, & $extra = null ) {
            $prefix = $this->getPostPrefix();
            switch ($field) {
                case 'captcha':
                case 'captcha_code':
                case '':
                    return FALSE;
                case 'copystop':
                    $value = $this->generateCopystop();
                    if (isset($item->$field)) $value = & $item->$field;
                    $this->smartyAssignByRef($prefix . $field, $value);
                    break;
                case 'department':
                case 'subject':
                case 'nickname':
                case 'name':
                case 'name2':
                case 'name3':
                case 'phone':
                case 'phone2':
                case 'email':
                case 'email2':
                case 'skype':
                case 'skype2':
                case 'icq':
                case 'icq2':
                case 'reason':
                case 'message':
                case 'coupon':
                case 'login':
                default:
                    $value = '';
                    if (isset($item->$field)) $value = & $item->$field;
                    $this->smartyAssignByRef($prefix . $field, $value);
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Выполнение перехода на связанную страницу
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function gotoRelatedPage () {

            // если это модуль обратной связи и зарегистрированный пользователь, перенаправляем в личный кабинет на страницу переписки
            $dbmodel = $this->getDBModel();
            if ($dbmodel == 'feedback' && $this->existsUser()) {
                $this->security->redirectToPage('http://' . $this->cms->root_url . '/account/feedback');
            }
        }



        // ===================================================================
        /**
        *  Обработка входных параметров
        *
        *  @access  protected
        *  @param   mixed   $params     некие параметры
        *  @return  void
        */
        // ===================================================================

        protected function process ( $params = null ) {

            // ошибки здесь еще не было
            $cancel = FALSE;
            $dummy = null;

            // читаем поля опубликованной формы
            $this->item = new stdClass;
            $this->enumItemFields($this->item, 'getFormField');

            // если ранее не было ошибок и получены данные об изменениях
            $accepted = FALSE;
            $bad_fields = array();
            $prefix = $this->getPostPrefix();
            if ($this->error_msg == '') {
                if (!empty($this->item) && $this->enumItemFields($dummy, 'checkItemFieldPosted')) {

                    // берем IP-адрес пользователя
                    $ip = $this->security->getVisitorIp();

                    // проверяем отказ в публикации формы
                    $cancel = $this->checkFormDisallow($ip);
                    if (!$cancel) {

                        // проверяем заполненность полей по одному и все вместе
                        $cancel = $this->enumItemFields($this->item, 'checkItemField', $bad_fields);
                        if (!$cancel) {
                            $cancel = $this->checkItemFields($this->item, $bad_fields);
                        }
                    }

                    // если форма правильная и это не ее репостинг
                    if (!$cancel) {
                        $accepted = isset($this->item->copystop) && !$this->session->checkCopystop($this->item->copystop, $prefix);
                        if (!$accepted) {

                            // проверяем лимит времени на постинг формы
                            $field = $prefix . 'post_next_time';
                            $created = time();
                            $next = @ intval($this->session->get($field, $created));
                            if ($next > $created) {
                                $cancel = $this->pushError('На странице установлен антиспамный интервал повторных постов! '
                                                         . 'Попробуйте через ' . $this->date->readableLeftTime($next - $created) . '.');
                            } else {

                                // проверяем внешние конфликты с существующими данными
                                $data = null;
                                $cancel = $this->checkExternalConflicts($this->item, $bad_fields, $data);
                                if (!$cancel) {

                                    // если защитный код отключен или правильный
                                    $dbmodel = $this->getDBModel();
                                    if ($this->settings->get($dbmodel . '_captcha_disabled') || $this->security->checkCaptcha()) {

                                        // проверяем внутренние конфликты с существующими данными
                                        $cancel = $this->checkInternalConflicts($this->item, $bad_fields, $data);
                                        if (!$cancel) {

                                            // добавляем в базу данных
                                            $host = $this->security->getVisitorHost();
                                            $id = $this->addPostedRecord($this->item, $created, $ip, $host, $data);
                                            if (!empty($id)) {

                                                // засекаем новый лимит времени на постинг формы
                                                $next = @ intval($this->post_next_lifetime);
                                                $next = $this->settings->getAsInteger($dbmodel . '_next_lifetime', $next);
                                                $this->session->set($field, $created + abs($next));

                                                // блокируем репостинг этой же формы
                                                if (isset($this->item->copystop)) $this->session->saveCopystop($this->item->copystop, $prefix);

                                                // уведомляем администратора / пользователя о принятом сообщении
                                                $created = $this->date->readableDateTime($created);
                                                $this->informAdmin($this->item, $created);
                                                $this->informUser($this->item, $created);

                                                // возможно у модуля есть связанная страница
                                                $this->gotoRelatedPage();
                                                $accepted = TRUE;

                                            } else {
                                                $cancel = $this->pushError($this->technical_msg);
                                            }
                                        }
                                    } else {
                                        $cancel = $this->pushError($this->captcha_msg);
                                        $bad_fields[$prefix . 'captcha'] = $this->captcha_msg;
                                    }
                                }
                            }
                        }

                        // если форма принята, передаем в шаблонизатор признак "сообщение принято"
                        if ($accepted) {
                            $this->smartyAssign($prefix . 'accepted', $accepted);

                            // информационное сообщение писавшему
                            $this->pushInfo($this->success_msg);
                            $this->cms->success_bgsound();
                        }

                        // если прошло удачно, очищаем параметры для html-формы
                        if (!$cancel) $this->enumItemFields($this->item, 'clearItemField');
                    }
                }
            }

            // заполняем пустые поля дефолтными значениями
            $this->enumItemFields($this->item, 'defaultItemField');

            // возвращаем в html-форму принятые от нее параметры и список обрабатываемых полей
            $this->enumItemFields($this->item, 'assignItemField');
            $this->smartyAssignByRef($prefix . 'fields', $this->fields);
            $this->smartyAssignByRef($prefix . 'bad_fields', $bad_fields);

            // устанавливаем дефолтный заголовок страницы
            $this->title = $this->default_title;

            // передаем данные в шаблонизатор
            $this->smartyAssignByRef($prefix . 'content_title', $this->title);
                if ($prefix != '') $this->smartyAssignByRef($prefix . 'title', $this->title);
                $this->cms->refillPageTitleVar($this->title);
            if ($prefix != '') $this->smartyAssignByRef($prefix . 'error', $this->error_msg);
            else $this->cms->smarty->assignByRef('error', $this->error_msg);
            if ($accepted) {
                if ($prefix != '') $this->smartyAssignByRef($prefix . 'message', $this->info_msg);
                else $this->cms->smarty->assignByRef('message', $this->info_msg);
            }
        }
    }



    return;
?>