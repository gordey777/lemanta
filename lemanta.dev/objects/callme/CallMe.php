<?php
    // макет обратной связи
    require_once(dirname(__FILE__) . '/../.ref-models/Feedback.php');



    // =======================================================================
    /**
    *  Клиентский модуль обратного звонка
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientCallMe extends FeedbackREFModel {

        protected $default_title = 'Перезвоните мне';
        protected $email_subject = 'Новый запрос "Позвоните мне": [date] на сайте [site] от [user]';
        protected $email_subject_user = 'Уведомление: ваша просьба выйти на связь отправлена на рассмотрение сайту [site]';
        protected $success_msg = 'Спасибо! Ваша просьба выйти на связь отправлена на рассмотрение.';
            protected $message_msg = 'Вы не ввели причину, по которой просите обратный звонок!';
            protected $technical_msg = 'Не удалось сохранить ваш запрос в базе данных по техническим причинам на сайте.';

        // список обрабатываемых полей опубликованной формы
        protected $fields = array('phone' => '+',
                                  'email',
                                  'skype',
                                  'icq',
                                  'name',
                                  'reason',
                                  'copystop');

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'callme';

        // имя файла шаблона письма (относительно папки текущего шаблона)
        protected $template_email = 'email/callme-to-admin.htm';
        protected $template_email_user = 'email/callme-to-user.htm';
        protected $template_sms = 'sms/callme-to-admin.htm';
        protected $template_sms_user = 'sms/callme-to-user.htm';

        // категория личных настроек модуля
        public $settings_category = 'Перезвоните мне';

        // имя модели базы данных
        protected $dbmodel = 'callme';

        // префикс имен полей формы
        protected $post_prefix = 'callme_';

        // через сколько секунд возможно постить следующую форму
        protected $post_next_lifetime = 1800;



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
            $item->done = 0;

            $dbmodel = $this->getDBModel();
            $idfield = $this->cms->db->$dbmodel->getIDField();
            $item->$idfield = $this->cms->db->$dbmodel->update($item);
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

            // ищем неотмененный запрет доступа к запросам связи для такого IP-адреса
            // (включив проверку даты действия запрета)
            $row = null;
            $filter = new stdClass;
            $filter->ip = $ip;
            $filter->enabled = 1;
            $filter->no_callme = 1;
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
    }



    return;
?>