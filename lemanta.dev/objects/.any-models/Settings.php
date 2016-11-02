<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с настройками сайта
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SettingsANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Извлечение настройки
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение настройки
        */
        // ===================================================================

        public function get ( $name, $def = FALSE ) {
            return isset($this->cms->settings->$name) ? $this->cms->settings->$name : $def;
        }



        // ===================================================================
        /**
        *  Установка настройки на время сеанса (без сохранения в базе)
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $value      значение
        *  @return  void
        */
        // ===================================================================

        public function set ( $name, $value ) {
            $this->cms->settings->$name = $value;
        }



        // ===================================================================
        /**
        *  Извлечение настройки как простого текста (удаление тегов, анти
        *  трейлинг, оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение настройки
        */
        // ===================================================================

        public function getAsPlainText ( $name, $def = '' ) {
            if (!isset($this->cms->settings->$name)) return $def;
            $def = str_replace('&nbsp;', ' ', $this->cms->settings->$name);
            $def = $this->text->stripTags($def);
            $def = preg_replace('/[ \r\n\t\s]+/u', ' ', $def);
            return trim($def);
        }



        // ===================================================================
        /**
        *  Извлечение настройки как печатного предложения (анти трейлинг,
        *  оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение настройки
        */
        // ===================================================================

        public function getAsSentence ( $name, $def = '' ) {
            if (!isset($this->cms->settings->$name)) return $def;
            $def = preg_replace('/[ \r\n\t\s]+/u', ' ', $this->cms->settings->$name);
            return trim($def);
        }



        // ===================================================================
        /**
        *  Извлечение настройки как целого числа
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение настройки
        */
        // ===================================================================

        public function getAsInteger ( $name, $def = 0 ) {
            if (!isset($this->cms->settings->$name)) return $def;
            return @ intval($this->cms->settings->$name);
        }



        // ===================================================================
        /**
        *  Извлечение настройки как натурального числа
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               значение настройки
        */
        // ===================================================================

        public function getAsNatural ( $name, $def = 1 ) {
            if (!isset($this->cms->settings->$name)) return $def;
            return max(1, @ intval($this->cms->settings->$name));
        }



        // ===================================================================
        /**
        *  Извлечение настройки как булевого флага (0 или 1)
        *
        *  @access  public
        *  @param   string  $name       имя настройки
        *  @param   mixed   $def        значение по умолчанию
        *  @return  mixed               1 или 0 или значение по умолчанию
        */
        // ===================================================================

        public function getAsBoolean ( $name, $def = 0 ) {
            if (!isset($this->cms->settings->$name)) return $def;
            return $this->cms->settings->$name ? 1 : 0;
        }
    }



    return;
?>