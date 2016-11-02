<?php
    // макет обратной связи
    require_once(dirname(__FILE__) . '/../.ref-models/Feedback.php');



    // =======================================================================
    /**
    *  Клиентский модуль обратной связи
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientFeedback extends FeedbackREFModel {

        // список обрабатываемых полей опубликованной формы
        protected $fields = array('department',
                                  'subject',
                                  'name' => '+',
                                  'email' => '+',
                                  'phone',
                                  'message' => '+',
                                  'copystop');



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
            if ($ok === FALSE) return $this->pushError($this->contacts_msg);
            return FALSE;
        }
    }



    return;
?>