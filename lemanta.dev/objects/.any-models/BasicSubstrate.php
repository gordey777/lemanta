<?php
    // =======================================================================
    /**
    *  Подложка произвольной модели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SubstrateANYModel {

        // объект движка
        public $cms = null;

        // объект владельца (может быть чужим, если модель не эксклюзивная)
        public $owner = null;
        public $owner_exclusive = FALSE;



        // ===================================================================
        /**
        *  Признак наличия определенного метода у некоторого модуля (объекта)
        *
        *  @access  public
        *  @param   object  $who        проверяемый объект
        *  @param   string  $method     имя метода
        *  @return  boolean             TRUE если имеет такой метод
        */
        // ===================================================================

        final public function hasMethod ( & $who, $method ) {
            return is_object($who) && method_exists($who, $method);
        }



        // ===================================================================
        /**
        *  Получение строкового, числового или булевого свойства объекта владельца
        *
        *  @access  public
        *  @param   string  $name   имя свойства
        *  @param   mixed   $def    значение по умолчанию, если свойства нет
        *                           или имеет необслуживаемый тип
        *  @return  mixed           значение свойства
        *
        */
        // ===================================================================

        public function getOwnerProperty ( $name, $def = null ) {
            if (!isset($this->owner) || !is_object($this->owner)
            || !property_exists($this->owner, $name)
            || !is_string($this->owner->$name) && !is_bool($this->owner->$name)
            && !is_numeric($this->owner->$name)) return $def;
            return $this->owner->$name;
        }



        // ===================================================================
        /**
        *  Установка строкового, числового или булевого свойства объекта владельца
        *
        *  @access  public
        *  @param   string  $name   имя свойства
        *  @param   mixed   $value  новое значение (установка отклоняется, если
        *                           значение или свойство имеет необслуживаемый тип)
        *  @return  void
        *
        */
        // ===================================================================

        public function setOwnerProperty ( $name, $value ) {
            if (!isset($this->owner) || !is_object($this->owner)
            || property_exists($this->owner, $name)
            && !is_string($this->owner->$name) && !is_bool($this->owner->$name)
            && !is_numeric($this->owner->$name)
            || !is_string($value) && !is_bool($value) && !is_numeric($value)) return;
            $this->owner->$name = $value;
        }



        // ===================================================================
        /**
        *  Добавление текста ошибки в общее сообщение об ошибке
        *
        *  @access  public
        *  @param   string  $text     текст ошибки
        *  @param   string  $divider  разделитель сообщений
        *  @return  boolean           всегда TRUE (псевдо сигнализатор ошибки)
        */
        // ===================================================================

        public function pushError ( $text, $divider = '<br><br>' ) {

            // только для экслюзивных моделей
            if (!empty($this->owner_exclusive) && isset($this->owner) && is_object($this->owner)) {
                if (empty($this->owner->error_msg)) $this->owner->error_msg = '';
                if ($this->owner->error_msg != '') $this->owner->error_msg .= $divider;
                $this->owner->error_msg .= trim($text);
            }

            return TRUE;
        }



        // ===================================================================
        /**
        *  Добавление текста в общее информационное сообщение
        *
        *  @access  public
        *  @param   string  $text     текст
        *  @param   string  $divider  разделитель сообщений
        *  @return  boolean           всегда TRUE (псевдо сигнализатор сообщения)
        */
        // ===================================================================

        public function pushInfo ( $text, $divider = '<br><br>' ) {

            // только для экслюзивных моделей
            if (!empty($this->owner_exclusive) && isset($this->owner) && is_object($this->owner)) {
                if (empty($this->owner->info_msg)) $this->owner->info_msg = '';
                if ($this->owner->info_msg != '') $this->owner->info_msg .= $divider;
                $this->owner->info_msg .= trim($text);
            }

            return TRUE;
        }



        // ===================================================================
        /**
        *  Проверка token-аутентичности
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function checkToken () {

            // если токен запроса не совпадает с токеном сеанса
            $param = 'token';
            $token = $this->cms->request->getRequest($param, FALSE);
            if ($token === FALSE || $token !== $this->cms->request->getSession($param, FALSE)) {

                // перенаправить на страницу ошибки
                $url = 'http://' . $this->cms->root_url . '/bad-token';
                $this->cms->security->redirectToPage($url);
            }
        }
    }



    return;
?>