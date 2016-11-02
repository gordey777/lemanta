<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с валютой
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class CurrencyANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Проверка идентичности кода валюты
        *
        *  @access  public
        *  @param   object  $currency   объект анализируемой валюты
        *  @param   string  $code       код валюты (например USD, UAH, RUR)
        *  @return  boolean             TRUE если идентичен
        *                               FALSE если нет или это не запись валюты
        */
        // ===================================================================

        public function checkCode ( $currency, $code ) {
            return is_string($code)
                && isset($currency->code) && is_string($currency->code)
                && $this->text->lowerCase($currency->code) == $this->text->lowerCase($code);
        }



        // ===================================================================
        /**
        *  Получение записи валюты по коду
        *
        *  @access  public
        *  @param   string  $code       код валюты (например USD, UAH, RUR)
        *  @return  object              запись валюты
        *                               NULL если нет такой валюты
        */
        // ===================================================================

        public function getByCode ( $code ) {
            if (!is_string($code)) return null;
            if (!isset($this->cms->currencies) || empty($this->cms->currencies)) return null;
            $code = $this->text->lowerCase($code);
            foreach ($this->cms->currencies as & $item) {
                if (isset($item->code) && $this->text->lowerCase($item->code) == $code) return $item;
            }
            return null;
        }



        // ===================================================================
        /**
        *  Получение признака "существует ли валюта с таким кодом"
        *
        *  @access  public
        *  @param   string  $code       код валюты (например USD, UAH, RUR)
        *  @return  boolean             TRUE если существует
        *                               FALSE если нет такой валюты
        */
        // ===================================================================

        public function exists ( $code ) {
            if (!is_string($code)) return FALSE;
            if (!isset($this->cms->currencies) || empty($this->cms->currencies)) return FALSE;
            $code = $this->text->lowerCase($code);
            foreach ($this->cms->currencies as & $item) {
                if (isset($item->code) && $this->text->lowerCase($item->code) == $code) return TRUE;
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Получение курсового коэффициента валюты
        *
        *  @access  public
        *  @param   object  $currency   объект желаемой валюты
        *                               NULL если взять текущую валюту
        *  @param   boolean $direct     TRUE если прямой (для вычисления суммы в этой валюте)
        *                               FALSE если обратный (для вычисления суммы в базовой валюте)
        *  @return  float               значение коэффициента
        */
        // ===================================================================

        public function rate ( $currency = null, $direct = FALSE ) {
            if (is_null($currency)) $currency = $this->cms->currency;
            $to = isset($currency->rate_to) && $currency->rate_to != 0 ? abs($currency->rate_to) : 1;
            $from = isset($currency->rate_from) && $currency->rate_from != 0 ? abs($currency->rate_from) : 1;
            return $direct ? $from / $to : $to / $from;
        }
    }



    return;
?>