<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с поиском
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SearchANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Получение предельного размера истории поиска
        *
        *  @access  public
        *  @return  integer         размер
        */
        // ===================================================================

        public function historyMaxsize () {
            return 50;
        }



        // ===================================================================
        /**
        *  Получение имени файла базы данных истории поиска
        *
        *  @access  public
        *  @return  string      путь и имя файла
        */
        // ===================================================================

        public function historyDBFile () {
            return $this->cms->smarty->getCompileDir() . '/' . $this->cms->now_in_section . '_search_history.txt';
        }



        // ===================================================================
        /**
        *  Извлечение строки поиска из запроса
        *
        *  @access  public
        *  @return  string      строка
        */
        // ===================================================================

        public function queryKeyword () {
            $value = $this->request->getRequestAsSentence('keyword', FALSE);
            if (!is_string($value)) $value = $this->session->getAsSentence('search_keyword');
            $value = $this->text->asPlainSentence($value);
            return trim($this->text->substr($value, 0, 80));
        }



        // ===================================================================
        /**
        *  Извлечение типа поиска из запроса
        *
        *  @access  public
        *  @return  string      строка
        */
        // ===================================================================

        public function querySearchType () {
            $value = $this->request->getRequestAsSentence('search_type', FALSE);
            if (!is_string($value)) $value = $this->session->getAsSentence('search_type');
            return $this->text->asPlainSentence($value);
        }



        // ===================================================================
        /**
        *  Извлечение тега поиска из запроса
        *
        *  @access  public
        *  @return  string      тег
        */
        // ===================================================================

        public function queryTag () {
            $value = $this->request->getRequestAsSentence('tag', FALSE);
            if (!is_string($value)) $value = $this->session->getAsSentence('search_tag');
            $value = $this->text->asPlainSentence($value);
            return trim($this->text->substr($value, 0, 80));
        }



        // ===================================================================
        /**
        *  Извлечение левой границы цен из запроса
        *
        *  @access  public
        *  @return  float       граница
        */
        // ===================================================================

        public function queryCostFrom () {
            $value = $this->request->getRequestAsSentence('cost_from', FALSE);
            if (!is_string($value)) $value = $this->session->getAsSentence('search_cost_from');
            $value = $this->number->floatValue($value);
            return $value < 0 ? 0 : $value;
        }



        // ===================================================================
        /**
        *  Извлечение правой границы цен из запроса
        *
        *  @access  public
        *  @return  float       граница
        */
        // ===================================================================

        public function queryCostTo () {
            $value = $this->request->getRequestAsSentence('cost_to', FALSE);
            if (!is_string($value)) $value = $this->session->getAsSentence('search_cost_to');
            $value = $this->number->floatValue($value);
            return $value < 0 ? 0 : $value;
        }



        // ===================================================================
        /**
        *  Перестановка границ цен, если неправильные
        *
        *  @access  public
        *  @param   float   $cost_from  левая граница цен
        *  @param   float   $cost_to    правая граница цен
        *  @return  void
        */
        // ===================================================================

        public function checkCostValues ( & $cost_from, & $cost_to ) {
            if ($cost_to > 0 && $cost_to < $cost_from) {
                $s = $cost_to;
                $cost_to = $cost_from;
                $cost_from = $s;
            }
        }



        // ===================================================================
        /**
        *  Вычисление границ цен в базовой валюте
        *
        *  @access  public
        *  @param   float   $cost_from          левая граница цен
        *  @param   float   $cost_to            правая граница цен
        *  @param   float   $BASE_cost_from     левая граница цен (будет возвращена в эту переменную)
        *  @param   float   $BASE_cost_to       правая граница цен (будет возвращена в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function computeBaseCostValues ( $cost_from, $cost_to, & $BASE_cost_from, & $BASE_cost_to ) {
            $rate = $this->currency->rate();
            $BASE_cost_from = $cost_from * $rate;
            $BASE_cost_to = $cost_to * $rate;
        }



        // ===================================================================
        /**
        *  Регистрация поискового запроса в истории поиска
        *
        *  @access  protected
        *  @param   string  $filename   путь и имя файла базы данных истории
        *  @param   string  $text       строка поиска
        *  @param   string  $type       тип поиска (например a1, std или пустая строка)
        *  @param   string  $tag        тег поиска
        *  @param   float   $cost_from  левая граница цен
        *  @param   float   $cost_to    правая граница цен
        *  @return  void
        */
        // ===================================================================

        public function registerRequest ( $filename, $text, $type, $tag, $cost_from, $cost_to ) {
            $line = array('keyword'   => trim(preg_replace('/[ \r\n\t\s]+/u', ' ', $text)),
                          'type'      => trim(preg_replace('/[ \r\n\t\s]+/u', ' ', $type)),
                          'tag'       => trim(preg_replace('/[ \r\n\t\s]+/u', ' ', $tag)),
                          'cost_from' => sprintf('%1.2f', $cost_from),
                          'cost_to'   => sprintf('%1.2f', $cost_to));
            try {
                $line = @ serialize($line);
            } catch (Exception $e) {
                return;
            }

            $handle = @ fopen($filename, 'rb+');
            if ($handle === FALSE) $handle = @ fopen($filename, 'wb');
            if ($handle !== FALSE) {
                @ flock($handle, LOCK_EX);

                $lines = array();
                $count = 0;
                $check = $this->text->lowerCase($line);
                while (!feof($handle)) {
                    $string = @ fgets($handle);
                    if (!is_string($string)) break;
                    $string = trim($string);
                    if ($string != '') {
                        if ($this->text->lowerCase($string) != $check && !in_array($string, $lines)) {
                            $lines[] = $string;
                            $count++;
                            if ($count >= $this->historyMaxsize() - 1) break;
                        }
                    }
                }

                array_unshift($lines, $line);

                @ fseek($handle, 0);
                $string = trim(implode("\r\n", $lines)) . "\r\n";
                $count = strlen($string);
                @ fwrite($handle, $string, $count);
                @ ftruncate($handle, $count);
                @ fclose($handle);
            }
        }
    }



    return;
?>