<?php
    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/AdminSetup.php');



    // =======================================================================
    /**
    *  Макет редактируемой таблицы записей
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AdminTableREFModel extends AdminSetupREFModel {



        // ===================================================================
        /**
        *  Выправление значения поля с датой
        *
        *  @access  public
        *  @param   mixed   $date       дата в Integer или String
        *  @return  mixed               дата в Integer или строке NNNN-NN-NN NN:NN:NN
        */
        // ===================================================================

        public function fixDateValue ( $date ) {

            if (strval(intval($date)) == trim($date)) return intval($date);

            $date = trim(substr(trim($date), 0, 19));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/', $date)) return $date;

            $date = trim(substr($date, 0, 16));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}/', $date)) return $date . ':00';

            $date = trim(substr($date, 0, 13));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}/', $date)) return $date . ':00:00';

            $date = trim(substr($date, 0, 10));
            if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $date)) return $date . ' 00:00:00';

            return '0000-00-00 00:00:00';
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

            // безусловно очищаем нужные кеш-таблицы
            $model = $this->getDBModel();
            $this->cms->db->$model->resetCaches();
        }



        // ===================================================================
        /**
        *  Обновление записи в базе данных
        *
        *  @access  protected
        *  @param   object  $item       объект записи (обновляемые поля)
        *  @return  integer             ИД обновленной / добавленной записи
        */
        // ===================================================================

        protected function updateRecord ( & $item ) {

            // обновляем / добавляем указанную запись
            $model = $this->getDBModel();
            return $this->cms->db->$model->update($item);
        }



        // ===================================================================
        /**
        *  Уведомление участников об изменениях в записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   boolean $user       TRUE если уведомить пользователя по емейлу
        *  @param   boolean $user_sms   TRUE если уведомить пользователя по SMS
        *  @param   boolean $admin      TRUE если уведомить админа по емейлу
        *  @param   boolean $admin_sms  TRUE если уведомить админа по SMS
        *  @param   boolean $testing    TRUE если тестировать уведомление
        *  @return  void
        */
        // ===================================================================


        protected function informMembers ( & $item,
                                           $user = FALSE,
                                           $user_sms = FALSE,
                                           $admin = FALSE,
                                           $admin_sms = FALSE,
                                           $testing = FALSE ) {
        }



        // ===================================================================
        /**
        *  Обработка редактирования записи
        *
        *  @access  protected
        *  @param   string  $result_page    страница возврата из операции
        *  @return  boolean                 TRUE если замечена ошибка
        */
        // ===================================================================

        protected function processRecordEdit ( & $result_page = '' ) {

            // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
            $cancel = FALSE;

            // если получены данные об изменениях и нет признака отмены постинга
            if ($this->request->isPostedList()) {

                // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
                $this->checkToken();

                // цикл по измененным записям
                foreach ($_POST['post'] as $id => $value) {

                    // если сохраняются изменения всех записей на странице (не была нажата кнопка "Сохранить" конкретной записи)
                    // или добрались до сведений единственно изменяемой записи
                    if ($this->request->isPostedThisOne($id)) {
                        $item_cancel = FALSE;

                        // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
                        $this->item = new stdClass;
                        $this->processRecordEditFields($this->item, $id, $item_cancel);

                        // действительно обработали запись?
                        $filled = new stdClass;
                        $filled = !empty($this->item) && $this->item != $filled;
                        if ($filled) {

                            // это добавляемая запись?
                            $isVirtual = $this->request->getPostRecordFieldAsBoolean('post_this_noid', $id);
                            if (empty($id) || $isVirtual) {

                                // неуказанную дату создания приравниваем к текущей
                                if (!isset($this->item->created)) $this->item->created = time();

                            // тогда устанавливаем идентификатор записи
                            } else {
                                $value = $this->id_field;
                                $this->item->$value = $id;
                            }
                        }

                        // если ошибок нет (не включился признак отмены)
                        if (!$item_cancel && $filled) {

                            // обновляем запись в базе данных (при передаче в базу указываем пока не очищать кеш-таблицы)
                            $this->item->indifferent_caches = TRUE;
                            $changed = $this->updateRecord($this->item) != '';
                            $this->changed = $changed || $this->changed;

                            // если запись обновлена и требовали уведомить участников
                            $inform_user = !empty($_POST['inform_user'][$id]);
                            $inform_user_sms = !empty($_POST['inform_user_sms'][$id]);
                            $inform_admin = !empty($_POST['inform_admin'][$id]);
                            $inform_admin_sms = !empty($_POST['inform_admin_sms'][$id]);
                            $inform_testing = !empty($_POST['inform_testing'][$id]);
                            if ($changed && ($inform_user || $inform_user_sms || $inform_admin || $inform_admin_sms)) {
                                $this->informMembers($this->item,
                                                     $inform_user,
                                                     $inform_user_sms,
                                                     $inform_admin,
                                                     $inform_admin_sms,
                                                     $inform_testing);
                            }

                            // если страница возврата не указана, используем рекомендуемую страницу
                            if ($result_page == '' && !$this->request->existsPost('post_as_accept')) $result_page = trim($this->result_page);
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
        *  Обработка редактирования полей записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processRecordEditFields ( & $item, $id, & $cancel = FALSE ) {
        }



        // ===================================================================
        /**
        *  Сбор параметров html-формы
        *
        *  @access  protected
        *  @param   object  $inputs         настоящие значения некоторых элементов html-формы (будут возвращены в эту переменную)
        *  @param   object  $params         параметры фильтра (будут возвращены в эту переменную)
        *  @param   object  $defaults       значения по умолчанию некоторых элементов html-формы
        *  @return  void
        */
        // ===================================================================

        protected function collectInputs ( & $inputs, & $params, & $defaults ) {
            $inputs = array();
            $params = new stdClass;

            // собираем параметры фильтра (аутентификатор операции)
            $inputs['token'] = $this->cms->token;
        }



        // ===================================================================
        /**
        *  Чтение записей таблицы
        *
        *  @access  protected
        *  @param   mixed   $data       дополнительные сведения
        *  @return  array               массив записей
        */
        // ===================================================================

        protected function getRecords ( & $data = null ) {

            // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
            $inputs = null;
            $params = null;
            $this->collectInputs($inputs, $params, $data);

            // передаем значения элементов html-формы в шаблонизатор
            $this->cms->smarty->assignByRef('inputs', $inputs);

            return array();
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

            // читаем входной параметр FROM - на какую страницу вернуться после операции
            $result_page = trim($this->cms->param('from'));

            // обрабатываем редакторские изменения в записях
            $cancel = $this->processRecordEdit($result_page);

            // если произошли изменения в базе данных, очищаем соответствующие кеш-таблицы
            if ($this->changed) $this->resetCaches();

            // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
            if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);

            // читаем записи
            $this->items = & $this->getRecords();

            // передаем нужные данные в шаблонизатор
            $this->cms->smarty->assignByRef('items', $this->items);

            // наполняем другие переменные и передаем в шаблонизатор
            $this->fillVariables();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef('message', $this->info_msg);
            $this->cms->smarty->assignByRef('error', $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);

            // уничтожаем ненужные переменные в шаблонизаторе
            $this->destroyVariables();
            return TRUE;
        }



        // ===================================================================
        /**
        *  Наполнение других переменных и передача в шаблонизатор
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
            $this->cms->smarty->clearAssign('items');
            $this->items = null;
            $this->item = null;
        }



        // ===================================================================
        /**
        *  Обработка изменения поля NAME записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @param   string  $msg1       сообщение НЕ УКАЗАНО НАЗВАНИЕ
        *  @param   string  $msg2       сообщение УЖЕ ЕСТЬ АНАЛОГИЧНОЕ НАЗВАНИЕ
        *  @return  void
        */
        // ===================================================================

        protected function processFieldName ( & $item, $id, & $cancel = FALSE, $msg1, $msg2 ) {
            if ($this->request->existsPostRecordField('name', $id)) {
                $item->name = $this->request->getPostRecordField('name', $id);
                if ($item->name == '') {
                    $cancel = $this->pushError($msg1);
                } else {
                    $row = null;
                    $params = new stdClass;
                    if (!empty($id)) $params->exclude_id = $id;
                    $params->name = $item->name;

                    $model = $this->getDBModel();
                    $this->cms->db->$model->one($row, $params);

                    if (!empty($row)) $cancel = $this->pushError($msg2);
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля DESCRIPTION записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processFieldDescription ( & $item, $id, & $cancel = FALSE ) {
            if ($this->request->existsPostRecordField('description', $id)) {
                $item->description = $this->request->getPostRecordField('description', $id);

                $model = $this->getDBModel();
                $field = $model . '_wysiwyg_disabled';
                if (isset($this->cms->settings->$field) && $this->cms->settings->$field) {
                    $field = $model . '_wysiwyg_disabled_mode';
                    $field = isset($this->cms->settings->$field) ? $this->cms->settings->$field : FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION;
                    $item->description = $this->cm->db->fix_simple_TEXTAREA_text_for_HTML($item->description, $field);
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля DELIVERIES записи
        *
        *  @access  protected
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если найдена ошибка (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        protected function processFieldDeliveries ( & $item, $id, & $cancel = FALSE ) {
            if ($this->request->existsPostRecordField('deliveries', $id)) {
                $ids = array();
                if ($this->request->isPostArray('deliveries', TRUE, $id)) {
                    foreach ($_POST['deliveries'][$id] as $id => $value) {
                        $id = intval($id);
                        if (!empty($id) && (!isset($item->delivery_id) || ($id != $item->delivery_id))) $ids[$id] = $id;
                    }
                    sort($ids, SORT_NUMERIC);
                }
                $item->deliveries_ids = $ids;
            }
        }
    }



    return;
?>