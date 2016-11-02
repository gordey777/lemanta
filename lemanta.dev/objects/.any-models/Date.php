<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с датой
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class DateANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Выправление значения поля с датой
        *
        *  @access  public
        *  @param   mixed   $date   дата в Integer или String
        *  @return  mixed           дата в Integer или строке YYYY-MM-DD HH:MM:SS
        */
        // ===================================================================

        public function fixDate ( $date ) {
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
        *  Преобразование строки даты-времени в штамп времени
        *
        *  @access  public
        *  @param   string  $date   строковое представление даты (YYYY-MM-DD HH:MM:SS)
        *  @return  integer         штамп времени
        */
        // ===================================================================

        public function asTimestamp ( $date ) {
            if (is_string($date)) {
                $date = trim($date);
                $date = @ mktime(substr($date, 11, 2),
                                 substr($date, 14, 2),
                                 substr($date, 17, 2),
                                 substr($date, 5, 2),
                                 substr($date, 8, 2),
                                 substr($date, 0, 4));
            }
            return $date;
        }



        // ===================================================================
        /**
        *  Получение даты в удобо читаемом формате
        *
        *  @access  public
        *  @param   mixed   $date   строковое представление даты (YYYY-MM-DD HH:MM:SS) или штамп времени
        *                           FALSE = текущее время (по умолчанию равно этому)
        *  @return  string          дата в читаемом формате
        */
        // ===================================================================

        public function readableDateTime ( $date = FALSE ) {

            // если дата не указана, берем текущее время
            if ($date === FALSE) $date = time();

            // преобразуем в штамп времени
            $time = $this->asTimestamp($date);

            // формируем строку даты
            $date = array(1 => ' января ',
                          2 => ' февраля ',
                          3 => ' марта ',
                          4 => ' апреля ',
                          5 => ' мая ',
                          6 => ' июня ',
                          7 => ' июля ',
                          8 => ' августа ',
                          9 => ' сентября ',
                          10 => ' октября ',
                          11 => ' ноября ',
                          12 => ' декабря ');
            $date = date('j', $time) . $date[date('n', $time)] . date('Y', $time);
            $date .= ' в ' . date('H:i', $time);
            return $date;
        }



        // ===================================================================
        /**
        *  Получение штампа времени в удобочитаемом формате оставшегося времени
        *
        *  @access  public
        *  @param   integer $time       штамп времени
        *  @param   boolean $asclock    TRUE если в форме часов H:MM:SS ИМЯ_СТАРШЕГО_НЕПУСТОГО_РАЗРЯДА
        *                                    например 5:35 минут, например 1:23:09 час
        *                               FALSE если в обычной форме, например 5 минут 35 секунд
        *  @return  string              время в читаемом формате
        */
        // ===================================================================

        public function readableLeftTime ( $time, $asclock = FALSE ) {
            if ($asclock) {
                $name = $time >= 3600 ? ' час' : ($time >= 60 ? ' минут' : ' секунд');
                $pattern = '%02d';
                $hdiv = ':';
                $mdiv = ':';
                $sdiv = '';
            } else {
                $name = '';
                $pattern = '%d';
                $hdiv = ' час ';
                $mdiv = ' минут ';
                $sdiv = ' секунд';
            }

            $h = intval($time / 3600);
            $time = $time - $h * 3600;
            $h = $h > 0 ? $h . $hdiv : '';

            $m = intval($time / 60);
            $time = $time - $m * 60;
            $m = $m > 0 || $h != '' && $time > 0 ? sprintf($pattern, $m) . $mdiv : '';

            $s = $h != '' && $m != '' || $m != '' && $time > 0 || $h == '' && $m == '' ? sprintf($pattern, $time) . $sdiv : '';

            $time = rtrim(ltrim($h . $m . $s, '0 '), ': ');
            if ($time == 'секунд') $time = '0 ' . $time;
            return ($time == '' ? '0' : $time) . $name;
        }
    }



    return;
?>