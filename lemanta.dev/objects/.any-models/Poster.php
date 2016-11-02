<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с постером формы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PosterANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Получение имени постера формы
        *
        *  @access  public
        *  @param   object  $item   объект опубликованной записи
        *  @param   object  $user   запись об авторизованном пользователе, если есть
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           имя
        *                           значение по умолчанию если не найден
        */
        // ===================================================================

        public function getName ( & $item, & $user, $def = '' ) {

            // ищем в опубликованной записи
            $field = 'compound_name';
            $value = isset($item->$field) && is_string($item->$field) ? trim($item->$field) : '';
            if ($value == '') {
                $field2 = 'name';
                $value = isset($item->$field2) && is_string($item->$field2) ? trim($item->$field2) : '';

                // тогда может взять из записи о пользователе?
                if ($value == '') {
                    $value = isset($user->$field) && is_string($user->$field) ? trim($user->$field) : '';
                    if ($value == '') {
                        $value = isset($user->$field2) && is_string($user->$field2) ? trim($user->$field2) : '';
                        if ($value == '') $value = $def;
                    }
                }
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Получение ника постера формы
        *
        *  @access  public
        *  @param   object  $item   объект опубликованной записи
        *  @param   object  $user   запись об авторизованном пользователе, если есть
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           имя
        *                           значение по умолчанию если не найден
        */
        // ===================================================================

        public function getNickname ( & $item, & $user, $def = '' ) {

            // ищем в опубликованной записи
            $field = 'nickname';
            $value = isset($item->$field) && is_string($item->$field) ? trim($item->$field) : '';
            if ($value == '') {

                // тогда может взять из записи о пользователе?
                $value = isset($user->$field) && is_string($user->$field) ? trim($user->$field) : '';
                if ($value == '') $value = $def;
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Получение емейла постера формы
        *
        *  @access  public
        *  @param   object  $item   объект опубликованной записи
        *  @param   object  $user   запись об авторизованном пользователе, если есть
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           еймел
        *                           значение по умолчанию если не найден или невалиден
        */
        // ===================================================================

        public function getEmail ( & $item, & $user, $def = '' ) {

            // ищем в опубликованной записи
            $field = 'email';
            $value = isset($item->$field) && is_string($item->$field) ? trim($item->$field) : '';
            if ($value != '' && !preg_match(EMAIL_CHECKING_PATTERN, $value)) $value = '';
            if ($value == '') {
                $field2 = 'email2';
                $value = isset($item->$field2) && is_string($item->$field2) ? trim($item->$field2) : '';
                if ($value != '' && !preg_match(EMAIL_CHECKING_PATTERN, $value)) $value = '';

                // тогда может взять из записи о пользователе?
                if ($value == '') {
                    $value = isset($user->$field) && is_string($user->$field) ? trim($user->$field) : '';
                    if ($value != '' && !preg_match(EMAIL_CHECKING_PATTERN, $value)) $value = '';
                    if ($value == '') {
                        $value = isset($user->$field2) && is_string($user->$field2) ? trim($user->$field2) : '';
                        if ($value != '' && !preg_match(EMAIL_CHECKING_PATTERN, $value)) $value = '';
                        if ($value == '') $value = $def;
                    }
                }
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Получение телефона постера формы
        *
        *  @access  public
        *  @param   object  $item   объект опубликованной записи
        *  @param   object  $user   запись об авторизованном пользователе, если есть
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           телефон
        *                           значение по умолчанию если не найден или невалиден
        */
        // ===================================================================

        public function getPhone ( & $item, & $user, $def = '' ) {

            // ищем в опубликованной записи
            $field = 'phone';
            $value = isset($item->$field)
                  && (is_string($item->$field) || is_numeric($item->$field)) ? trim($item->$field) : '';
            if ($value != '' && !preg_match(PHONE_CHECKING_PATTERN, $value)) $value = '';
            if ($value == '') {
                $field2 = 'phone2';
                $value = isset($item->$field2)
                      && (is_string($item->$field2) || is_numeric($item->$field2)) ? trim($item->$field2) : '';
                if ($value != '' && !preg_match(PHONE_CHECKING_PATTERN, $value)) $value = '';

                // тогда может взять из записи о пользователе?
                if ($value == '') {
                    $value = isset($user->$field)
                          && (is_string($user->$field) || is_numeric($user->$field)) ? trim($user->$field) : '';
                    if ($value != '' && !preg_match(PHONE_CHECKING_PATTERN, $value)) $value = '';
                    if ($value == '') {
                        $value = isset($user->$field2)
                              && (is_string($user->$field2) || is_numeric($user->$field2)) ? trim($user->$field2) : '';
                        if ($value != '' && !preg_match(PHONE_CHECKING_PATTERN, $value)) $value = '';
                        if ($value == '') $value = $def;
                    }
                }
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Получение Skype имени постера формы
        *
        *  @access  public
        *  @param   object  $item   объект опубликованной записи
        *  @param   object  $user   запись об авторизованном пользователе, если есть
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           имя
        *                           значение по умолчанию если не найдено или невалидно
        */
        // ===================================================================

        public function getSkype ( & $item, & $user, $def = '' ) {

            // ищем в опубликованной записи
            $field = 'skype';
            $value = isset($item->$field) && is_string($item->$field) ? trim($item->$field) : '';
            if ($value != '' && !preg_match(SKYPE_CHECKING_PATTERN, $value)) $value = '';
            if ($value == '') {
                $field2 = 'skype2';
                $value = isset($item->$field2) && is_string($item->$field2) ? trim($item->$field2) : '';
                if ($value != '' && !preg_match(SKYPE_CHECKING_PATTERN, $value)) $value = '';

                // тогда может взять из записи о пользователе?
                if ($value == '') {
                    $value = isset($user->$field) && is_string($user->$field) ? trim($user->$field) : '';
                    if ($value != '' && !preg_match(SKYPE_CHECKING_PATTERN, $value)) $value = '';
                    if ($value == '') {
                        $value = isset($user->$field2) && is_string($user->$field2) ? trim($user->$field2) : '';
                        if ($value != '' && !preg_match(SKYPE_CHECKING_PATTERN, $value)) $value = '';
                        if ($value == '') $value = $def;
                    }
                }
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Получение ICQ номера постера формы
        *
        *  @access  public
        *  @param   object  $item   объект опубликованной записи
        *  @param   object  $user   запись об авторизованном пользователе, если есть
        *  @param   mixed   $def    значение по умолчанию
        *  @return  mixed           номер
        *                           значение по умолчанию если не найден или невалиден
        */
        // ===================================================================

        public function getIcq ( & $item, & $user, $def = '' ) {

            // ищем в опубликованной записи
            $field = 'icq';
            $value = isset($item->$field)
                  && (is_string($item->$field) || is_numeric($item->$field)) ? trim($item->$field) : '';
            if ($value != '' && !preg_match(ICQ_CHECKING_PATTERN, $value)) $value = '';
            if ($value == '') {
                $field2 = 'icq2';
                $value = isset($item->$field2)
                      && (is_string($item->$field2) || is_numeric($item->$field2)) ? trim($item->$field2) : '';
                if ($value != '' && !preg_match(ICQ_CHECKING_PATTERN, $value)) $value = '';

                // тогда может взять из записи о пользователе?
                if ($value == '') {
                    $value = isset($user->$field)
                          && (is_string($user->$field) || is_numeric($user->$field)) ? trim($user->$field) : '';
                    if ($value != '' && !preg_match(ICQ_CHECKING_PATTERN, $value)) $value = '';
                    if ($value == '') {
                        $value = isset($user->$field2)
                              && (is_string($user->$field2) || is_numeric($user->$field2)) ? trim($user->$field2) : '';
                        if ($value != '' && !preg_match(ICQ_CHECKING_PATTERN, $value)) $value = '';
                        if ($value == '') $value = $def;
                    }
                }
            }
            return $value;
        }
    }



    return;
?>