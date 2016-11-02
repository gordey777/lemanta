<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с числами
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class NumberANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Коррекция значения до указанного действительного диапазона
        *
        *  @access  public
        *  @param   float   $value  исходное значение
        *  @param   float   $left   левая граница диапазона
        *  @param   float   $right  правая граница
        *  @return  float           скорректированное значение
        */
        // ===================================================================

        public function mustbeRange ( $value, $left = null, $right = null ) {
            if (!is_null($left)) $value = max($left, $value);
            if (!is_null($right)) $value = min($value, $right);
            return $value;
        }



        // ===================================================================
        /**
        *  Коррекция значения до указанного целочисленного диапазона
        *
        *  @access  public
        *  @param   integer $value  исходное значение
        *  @param   integer $left   левая граница диапазона
        *  @param   integer $right  правая граница
        *  @return  integer         скорректированное значение
        */
        // ===================================================================

        public function mustbeIntegerRange ( $value, $left = null, $right = null ) {
            $value = @ intval($value);
            if (!is_null($left)) {
                $left = @ intval($left);
                $value = max($left, $value);
            }
            if (!is_null($right)) {
                $right = @ intval($right);
                $value = min($value, $right);
            }
            return $value;
        }



        // ===================================================================
        /**
        *  Получение безопасного представления действительного числа
        *
        *  @access  public
        *  @param   mixed   $value  значение числа
        *  @return  string          безопасное значение
        */
        // ===================================================================

        public function safeFloatValueString ( $value ) {
            return str_replace(',', '.', $value);
        }



        // ===================================================================
        /**
        *  Конфигурационно независимая функция floatval
        *
        *  @access  public
        *  @param   mixed   $value  исходное значение
        *  @return  float           значение
        */
        // ===================================================================

        public function floatValue ( $value ) {
            if (is_float($value)) return $value;
            if (is_string($value)) $value = $this->safeFloatValueString($value);
            if (is_numeric($value)) return floatval($value);
            return 0.0;
        }
    }



    return;
?>