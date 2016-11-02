<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с историей
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class HistoryANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Получение записей истории поиска
        *
        *  @access  public
        *  @param   string  $filename   имя файла
        *                               FALSE если дефолтное имя
        *  @return  array               записи истории
        */
        // ===================================================================

        public function getSearchHistory ( $filename = FALSE ) {
            if (!is_string($filename)) $filename = $this->search->historyDBFile();
            $result = array();
            $count = 0;
            $handle = @ fopen($filename, 'rb');
            if ($handle !== FALSE) {
                @ flock($handle, LOCK_EX);
                $maxsize = $this->search->historyMaxsize();
                while (!feof($handle)) {
                    $string = @ fgets($handle);
                    if (!is_string($string)) break;
                    $string = trim($string);
                    if ($string != '') {
                        try {
                            $string = @ unserialize($string);
                            if (is_array($string) && !empty($string)) $result[] = $string;
                            $count++;
                        } catch (Exception $e) { }
                        if ($count >= $maxsize) break;
                    }
                }
                @ fclose($handle);
            }
            return $result;
        }
    }



    return;
?>