<?php
    // макет обратной связи
    require_once(dirname(__FILE__) . '/../.ref-models/Feedback.php');



    // =======================================================================
    /**
    *  Клиентский модуль регистрации
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientRegistration extends FeedbackREFModel {

        protected $default_title = 'Регистрация нового пользователя';
        protected $email_subject = 'Новый зарегистрировавшийся: [user] на сайте [site]';
        protected $email_subject_user = 'Уведомление: вы успешно зарегистрировались на сайте [site]';
        protected $success_msg = 'Спасибо! Вы успешно зарегистрировались.';
            protected $technical_msg = 'Не удалось выполнить регистрацию по техническим причинам на сайте.';

        // список обрабатываемых полей опубликованной формы
        protected $fields = array('nickname',
                                  'name' => '+',
                                  'name2',
                                  'name3',
                                  'email' => '+',
                                  'phone',
                                  'skype',
                                  'icq',
                                  'coupon',
                                  'password' => '+',
                                  'password2' => '+',
                                  'copystop');

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'registration';

        // имя файла шаблона письма (относительно папки текущего шаблона)
        protected $template_email = 'email/registration-to-admin.htm';
        protected $template_email_user = 'email/registration-to-user.htm';
        protected $template_sms = 'sms/registration-to-admin.htm';
        protected $template_sms_user = 'sms/registration-to-user.htm';

        // категория личных настроек модуля
        public $settings_category = 'Регистрация';

        // имя модели базы данных
        protected $dbmodel = 'users';

        // префикс имен полей формы
        protected $post_prefix = 'registration_';

        // через сколько секунд возможно постить следующую форму
        protected $post_next_lifetime = 1800;



        // ===================================================================
        /**
        *  Подготовительные действия
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepare () {
            parent::prepare();

            // проверяем наличие бана, если есть, прекращаем работу
            $ip = $this->security->getVisitorIp();
            if ($this->checkBanned($ip)) {
                $msg = $this->settings->getAsSentence('banneds_noregister_text');
                if ($msg == '') $msg = $this->banned_msg;
                $this->security->stop($msg);
            }

            // если пользователь уже авторизован
            if (!empty($this->cms->user)) {
                $msg = 'Вы уже авторизованы на сайте. Регистрация нового пользователя в таком состоянии не будет принята. Сначала завершите текущий сеанс.';
                return $this->pushError($msg);
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

            // если купон не запрещен для регистрации
            if (!$this->settings->getAsBoolean('coupons_registration_disabled')) {

                // пробуем найти такой купон
                $value = $this->getProperty($item, 'coupon');
                if ($value != '') {
                    $filter = new stdClass;
                    $filter->code = $value;
                    $filter->enabled = 1;
                    $filter->deleted = 0;
                    $this->cms->db->coupons->one($data, $filter);

                    // если купона нет или срок действия истек
                    $prefix = $this->getPostPrefix();
                    if (empty($data)) {
                        $msg = 'Купон с таким кодом не существует.';
                        $bad_fields[$prefix . 'coupon'] = $msg;
                        return $this->pushError($msg);
                    } elseif ($data->count < 1) {
                        $msg = 'Купон с таким кодом уже был использован кем-то ранее.';
                        $bad_fields[$prefix . 'coupon'] = $msg;
                        return $this->pushError($msg);
                    } elseif (empty($data->valid)) {
                        $msg = 'Срок действия купона с таким кодом истек ' . $data->expired_date . ' в ' . $data->expired_time . '.';
                        $bad_fields[$prefix . 'coupon'] = $msg;
                        return $this->pushError($msg);
                    }
                }

            // иначе купоны запрещены для регистрации
            } else {
                $item->coupon = '';
            }
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
            $dbmodel = $this->getDBModel();
            $prefix = $this->getPostPrefix();
            $user = null;

            // может уже есть пользователь с таким ником?
            $value = $this->getProperty($item, 'nickname');
            if ($value != '') {
                $filter = new stdClass;
                $filter->nickname = $value;
                $this->cms->db->$dbmodel->one($user, $filter);
                if (!empty($user)) {
                    $msg = 'Ник "' . $value . '" уже используется другим пользователем сайта.';
                    $bad_fields[$prefix . 'nickname'] = $msg;
                    return $this->pushError($msg);
                }
            }

            // может уже есть пользователь с таким емейлом?
            $value = $this->getProperty($item, 'email');
            if ($value != '') {
                $filter = new stdClass;
                $filter->email = $value;
                $this->cms->db->$dbmodel->one($user, $filter);
                if (!empty($user)) {
                    $msg = 'Емейл ' . $value . ' уже используется другим пользователем сайта.';
                    $bad_fields[$prefix . 'email'] = $msg;
                    return $this->pushError($msg);
                }
            }

            // может уже есть пользователь с таким емейлом2?
            $value = $this->getProperty($item, 'email2');
            if ($value != '') {
                $filter = new stdClass;
                $filter->email = $value;
                $this->cms->db->$dbmodel->one($user, $filter);
                if (!empty($user)) {
                    $msg = 'Емейл ' . $value . ' уже используется другим пользователем сайта.';
                    $bad_fields[$prefix . 'email2'] = $msg;
                    return $this->pushError($msg);
                }
            }
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
            $required = TRUE;
            $ok = 0;
            $field = 'phone';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            $field = 'email';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            $field = 'skype';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            $field = 'icq';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            if ($ok === FALSE) return $this->pushError($this->contacts_msg);
            $ok = 0;
            $field = 'name';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            $field = 'name2';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            $field = 'name3';
                if (!$ok && $this->request->existsInFields($field, $this->fields, $required) & $required)
                    $ok = $this->getProperty($item, $field) != '';
            if ($ok === FALSE) return $this->pushError($this->name_msg);
            return FALSE;
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

            // определяем, кто будет назначаемым партнером (сначала из купона, потом из реферальной ссылки)
            $aid = $this->getProperty($data, 'affiliate_id', 0);
            if (empty($aid)) $aid = $this->cms->affiliate_id;
            if (!empty($aid)) $item->cms->affiliate_id = $aid;

            // есть ли назначаемая купоном ценовая группа?
            if (!empty($data->price_id)) $item->price_id = $data->price_id;

            // есть ли назначаемая купоном группа скидок?
            if (!empty($data->group_id)) {
                $item->group_id = $data->group_id;

            // есть ли группа скидок, автоматически назначаемая зарегистрировавшимся?
            } else {
                $row = null;
                $filter = new stdClass;
                $filter->authorized = 1;
                $filter->auto_assign = 1;
                $this->cms->db->groups->one($row, $filter);

                // если есть автоназначаемая группа
                if (!empty($row)) $item->group_id = $row->group_id;
            }

            // пароль хешируем, ниже восстановим
            $password = $this->getProperty($item, 'password');
            $item->password = md5($password . $this->salt);

            // сохраняем данные о зарегистрировавшемся
            $item->coupon_id = $this->getProperty($data, 'coupon_id', 0);
            $item->enabled = 1;
            $item->used_shop = 1;
            $item->ip = $ip;
            $item->host = $host;
            $item->created = & $created;

            $dbmodel = $this->getDBModel();
            $idfield = $this->cms->db->$dbmodel->getIDField();
            $item->$idfield = $this->cms->db->$dbmodel->update($item);

            // если пользователь зарегистрирован
            if (!empty($item->$idfield)) {

                // делаем реферальные отчисления за регистрацию нового пользователя
                if (!empty($aid)) {
                    $this->registrar->registerRegistration($aid, $item->$idfield);
                }

                // авторизуем пользователя в сеансе
                $this->session->set('user_nickname', $this->getProperty($item, 'nickname'));
                $this->session->set('user_email', $this->getProperty($item, 'email'));
                $this->session->set('user_email2', $this->getProperty($item, 'email2'));
                $this->session->set('user_password', $item->password);

                // регистрируем +1 использование купона
                if (!empty($data)) {
                    $data->count = $this->getProperty($data, 'count') - 1;
                    $data->modified = time();

                    // показываем, что последнее погашение сделано по регистрации, не по заказу
                    $data->user_id = $item->$idfield;
                    $data->order_id = 0;

                    // обновляем запись купона
                    $row = new stdClass;
                    $row->coupon_id = $item->coupon_id;
                    $row->user_id = $data->user_id;
                    $row->order_id = $data->order_id;
                    $row->count = $data->count;
                    $row->modified = $data->modified;
                    $this->cms->db->coupons->update($row);

                    // уведомляем распространителя купонов об активности по купону
                    $subject = $this->settings->getAsSentence('coupons_reg_notify_subject');
                    $subject = str_replace('&', $this->cms->root_url, $subject);
                    $subject = str_replace('*', $this->getProperty($data, 'code'), $subject);
                    $this->cms->inform_about_coupon($data,
                                                    $item,
                                                    $subject,
                                                    $this->settings->getAsBoolean('coupons_reg_notify_admin_by_email'),
                                                    $this->settings->getAsBoolean('coupons_reg_notify_admin_by_sms'),
                                                    $this->settings->getAsBoolean('coupons_reg_notify_affiliate_by_email'),
                                                    $this->settings->getAsBoolean('coupons_reg_notify_affiliate_by_sms'));
                }
            }
            $item->password = $password;
            return $item->$idfield;
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

            // ищем неотмененный запрет доступа к странице регистрации для такого IP-адреса
            // (включив проверку даты действия запрета)
            $row = null;
            $filter = new stdClass;
            $filter->ip = $ip;
            $filter->enabled = 1;
            $filter->no_register = 1;
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
        *  Выполнение перехода на связанную страницу
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function gotoRelatedPage () {

            // перенаправляем в личный кабинет
            $this->security->redirectToPage('http://' . $this->cms->root_url . '/account');
        }
    }



    return;
?>