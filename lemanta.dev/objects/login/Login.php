<?php
    // макет обратной связи
    require_once(dirname(__FILE__) . '/../.ref-models/Feedback.php');



    // =======================================================================
    /**
    *  Клиентский модуль входа пользователя
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientLogin extends FeedbackREFModel {

        protected $default_title = 'Вход на сайт';
        protected $email_subject = 'Заход клиента: [user] на сайте [site]';
        protected $email_subject_user = 'Уведомление: вы успешно авторизовались на сайте [site]';
        protected $success_msg = 'Спасибо! Вы успешно авторизовались.';
            protected $technical_msg = 'Не удалось авторизовать по техническим причинам на сайте.';

        // список обрабатываемых полей опубликованной формы
        protected $fields = array('login' => '+',
                                  'password' => '+',
                                  'copystop');

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'login';

        // имя файла шаблона письма (относительно папки текущего шаблона)
        protected $template_email = 'email/login-to-admin.htm';
        protected $template_email_user = 'email/login-to-user.htm';
        protected $template_sms = 'sms/login-to-admin.htm';
        protected $template_sms_user = 'sms/login-to-user.htm';

        // категория личных настроек модуля
        public $settings_category = 'Авторизация';

        // имя модели базы данных
        protected $dbmodel = 'users';

        // префикс имен полей формы
        protected $post_prefix = 'login_';

        // через сколько секунд возможно постить следующую форму
        protected $post_next_lifetime = 10;



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

            // если пользователь уже авторизован
            if (!empty($this->cms->user)) {
                $msg = 'Вы уже авторизованы на сайте. Для повторного входа сначала завершите текущий сеанс.';
                return $this->pushError($msg);
            }
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
            $data = null;
            $login = $this->getProperty($item, 'login');
            $pass = $this->getProperty($item, 'password');
            if ($login == '' || $pass == '') return $this->pushError($this->technical_msg);
            $msg = 'Неверный логин или пароль.';

            // читаем ИД пользователей с таким емейлом или ником
            $dbmodel = $this->getDBModel();
            $idfield = $this->cms->db->$dbmodel->getIDField();
            $login = $this->cms->db->query_value($login);
            $query = 'SELECT `' . $idfield . '`, '
                          . '`password`, '
                          . '`enabled` '
                   . 'FROM `' . $dbmodel . '` '
                   . 'WHERE `email` = "' . $login . '" OR `nickname` = "' . $login . '";';
            $result = $this->cms->db->query($query);
            if ($result === FALSE) return $this->pushError($msg);

            // проверяем у кого подходит пароль
            $id = FALSE;
            $enabled = TRUE;
            $hash = md5($pass . $this->salt);
            $users = array();
            while ($row = $this->cms->db->fetch_object($result)) {
                if ($row->password == $hash) {
                    $id = $row->$idfield;
                    $enabled = !empty($row->enabled);
                    break;
                }
                $users[] = $row;
            }
            $this->cms->db->free_result($result);

            // если не найден, тогда может с симплы пересели на имперу?
            if (empty($id)) {
                $hash2 = md5($pass . 'simpla');
                foreach ($users as $row) {
                    if ($row->password == $hash2) {
                        $id = $row->$idfield;
                        $enabled = !empty($row->enabled);
                        $row->password = $hash;
                        $this->cms->db->$dbmodel->update($row);
                        break;
                    }
                }
            }

            // если не найден или отключен
            if (empty($id)) return $this->pushError($msg);
            if (empty($enabled)) return $this->pushError('Ваша учётная запись отключена по какой-то причине. За разъяснениями обратитесь к администратору.');

            // читаем запись о пользователе
            $filter = new stdClass;
            $filter->id = $id;
            $this->cms->db->$dbmodel->one($data, $filter);
            if (empty($data)) return $this->pushError($this->technical_msg);

            // авторизуем пользователя в сеансе
            $this->session->set('user_nickname', $this->getProperty($data, 'nickname'));
            $this->session->set('user_email', $this->getProperty($data, 'email'));
            $this->session->set('user_email2', $this->getProperty($data, 'email2'));
            $this->session->set('user_password', $hash);
            $this->cms->user = & $data;
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
            $prefix = $this->getPostPrefix();
            $field = 'login';
            if ($this->getProperty($item, $field) == '') {
                $extra[$prefix . $field] = $this->login_msg;
                return $this->pushError($this->login_msg);
            }
            $field = 'password';
            if ($this->getProperty($item, $field) == '') {
                $extra[$prefix . $field] = $this->password_msg;
                return $this->pushError($this->password_msg);
            }
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
            $item->ip = $ip;
            $item->host = $host;
            $item->created = & $created;

            $dbmodel = $this->getDBModel();
            $idfield = $this->cms->db->$dbmodel->getIDField();
            return !empty($data->$idfield) ? $data->$idfield : 0;
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
            $this->security->redirectToPage('http://' . $this->cms->root_url . '/');
        }
    }



    return;
?>