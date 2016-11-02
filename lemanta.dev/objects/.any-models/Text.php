<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с текстом
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class TextANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Преобразование (универсальное) текста в нижний регистр
        *
        *  @access  public
        *  @param   string  $text       исходный текст
        *  @param   string  $charset    кодировка (например cp1251, по умолчанию UTF-8)
        *  @return  string              преобразованный текст
        */
        // ===================================================================

        public function lowerCase ( $text, $charset = 'UTF-8' ) {
            $func = 'mb_strtolower';
            return function_exists($func) ? $func($text, $charset) : strtolower($text);
        }



        // ===================================================================
        /**
        *  Преобразование (универсальное) текста в верхний регистр
        *
        *  @access  public
        *  @param   string  $text       исходный текст
        *  @param   string  $charset    кодировка (например cp1251, по умолчанию UTF-8)
        *  @return  string              преобразованный текст
        */
        // ===================================================================

        public function upperCase ( $text, $charset = 'UTF-8' ) {
            $func = 'mb_strtoupper';
            return function_exists($func) ? $func($text, $charset) : strtoupper($text);
        }



        // ===================================================================
        /**
        *  Получение (универсальное) символьного размера текста
        *
        *  @access  public
        *  @param   string  $text       исходный текст
        *  @param   string  $charset    кодировка (например cp1251, по умолчанию UTF-8)
        *  @return  integer             размер
        */
        // ===================================================================

        public function length ( $text, $charset = 'UTF-8' ) {
            $func = 'mb_strlen';
            return function_exists($func) ? $func($text, $charset) : strlen($text);
        }



        // ===================================================================
        /**
        *  Вырезание части текста
        *
        *  @access  public
        *  @param   string  $text       исходный текст
        *  @param   integer $offset     смещение от начала текста
        *  @param   integer $size       размер вырезаемого
        *  @param   string  $charset    кодировка (например cp1251, по умолчанию UTF-8)
        *  @return  string              вырезанный текст
        */
        // ===================================================================

        public function substr ( $text, $offset, $size = null, $charset = 'UTF-8' ) {
            $func = 'mb_substr';
            if (is_null($size)) $size = $this->length($text);
            return function_exists($func) ? $func($text, $offset, $size, $charset) : substr($text, $offset, $size);
        }



        // ===================================================================
        /**
        *  Преобразование кодировки текста
        *
        *  @access  public
        *  @param   string  $text   исходный текст
        *  @param   string  $from   исходная кодировка (например cp1251)
        *  @param   string  $to     конечная кодировка (по умолчанию UTF-8)
        *  @return  string          преобразованный текст
        */
        // ===================================================================

        public function convertCharset ( $text, $from, $to = 'UTF-8' ) {
            if (function_exists('iconv')) {
                switch ($from) {
                    case 'cp1251':
                        switch ($to) {
                            case 'UTF-8': return iconv('Windows-1251', 'UTF-8//IGNORE', $text);
                        }
                        break;
                    case 'UTF-8':
                        switch ($to) {
                            case 'cp1251': return iconv('UTF-8', 'Windows-1251//IGNORE', $text);
                        }
                        break;
                }
            }
            return $text;
        }



        // ===================================================================
        /**
        *  Преобразование спецсимволов текста в HTML-сущности
        *
        *  @access  public
        *  @param   string  $text       исходный текст
        *  @param   string  $charset    кодировка (например cp1251, по умолчанию UTF-8)
        *  @return  string              преобразованный текст
        */
        // ===================================================================

        public function escape ( $text, $charset = 'UTF-8' ) {
            return htmlspecialchars($text, ENT_QUOTES, $charset);
        }



        // ===================================================================
        /**
        *  Получение имени класса из произвольного текста (имени)
        *
        *  Схема получения: не алфавитно-цифровые символы преобразуются в
        *  пробелы, все символы в нижний регистр, а первые буквы слов в
        *  верхний, слова смыкаются и удаляются возможные цифры спереди.
        *
        *  Например: 1and-2 and_ANYthing = And2AndAnything
        *
        *  @access  public
        *  @param   string  $text   имя
        *  @return  string          имя класса
        */
        // ===================================================================

        public function asClassName ( $text ) {
            $text = preg_replace('/[^а-яёa-z0-9]+/iu', ' ', $text);
            $text = ucwords($this->lowerCase($text));
            return preg_replace('/^[0-9]+/u', '', str_replace(' ', '', $text));
        }



        // ===================================================================
        /**
        *  Получение имени метода из произвольного текста (имени)
        *
        *  @access  public
        *  @param   string  $text   имя
        *  @return  string          имя метода
        */
        // ===================================================================

        public function asMethodName ( $text ) {
            return $this->asClassName($text);
        }



        // ===================================================================
        /**
        *  Получение текста, безопасного к размещению внутри XML тега
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @return  string          безопасный текст
        */
        // ===================================================================

        public function asXmlText ( $text ) {
            $text = str_replace('<', '&lt;', $text);
            $text = str_replace('>', '&gt;', $text);
            return trim($text);
        }



        // ===================================================================
        /**
        *  Получение текста как простого комментария с BR-переводами строк
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @param   integer $size   максимальный размер, после чего добавить ...
        *  @return  string          результат
        */
        // ===================================================================

        public function asHtmlComment ( $text, $size = 8192 ) {
            $text = preg_replace('!<(/p|/div|/h[1-6]|/li|/tr|/dt|/dd|/pre|br[^>]*|hr[^>]*)>!i', "\r\n", $text);
            $text = trim(preg_replace('![ \t]+!iu', ' ', strip_tags($text)));
            if ($this->length($text) > $size) {
                $text = $this->substr($text, 0, $size) . '...';
            }
            $text = $this->escape($text);
            $text = preg_replace('!<br[^>]*>[ \t\r\n\s]+!iu', '<br />', nl2br($text));
            $text = preg_replace('![ \t\r\n\s]+<br[^>]*>!iu', '<br />', $text);
            return preg_replace('!(<br[^>]*>){2,}!i', '<br /><br />', $text);
        }



        // ===================================================================
        /**
        *  Получение текста как печатного предложения (анти трейлинг,
        *  оптимизация пробелов)
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @return  string          обработанный текст
        */
        // ===================================================================

        public function asSentence ( $text ) {
            $text = preg_replace('/[ \r\n\t\s]+/u', ' ', $text);
            return trim($text);
        }



        // ===================================================================
        /**
        *  Получение текста как простого печатного предложения (анти трейлинг,
        *  оптимизация пробелов, анти html)
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @return  string          обработанный текст
        */
        // ===================================================================

        public function asPlainSentence ( $text ) {
            $text = preg_replace('/[<>]/', ' ', $text);
            $text = preg_replace('/[ \r\n\t\s]+/u', ' ', $text);
            return trim($text);
        }



        // ===================================================================
        /**
        *  Удаление HTML/PHP/XML-тегов из текста
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @param   boolean $reduce TRUE если сократить избыточные пробелы
        *  @param   boolean $utf8   TRUE если текст в кодировке UTF-8
        *  @return  string          безопасный текст
        */
        // ===================================================================

        public function stripTags ( $text, $reduce = FALSE, $utf8 = TRUE ) {
            $modifier = $utf8 ? 'u' : '';
            while (($new = preg_replace('/<[^ \t\r\n=][^>]*>/' . $modifier, ' ', $text)) != $text) $text = $new;
            while (($new = preg_replace('/<[^ \t\r\n=][\S]*/' . $modifier, ' ', $text)) != $text) $text = $new;
            while (($new = preg_replace('/[\'"\?\-\/]+>/' . $modifier, ' ', $text)) != $text) $text = $new;
            if ($reduce) $text = trim(preg_replace('/[ \t\r\n]+/' . $modifier, ' ', $text));
            return $text;
        }



        // ===================================================================
        /**
        *  Удаление разделителей записей и полей записи для однострочной нотации записей
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @param   string  $def    замена удаляемым разделителям (по умолчанию пустая строка)
        *  @return  string          безопасный текст
        */
        // ===================================================================

        public function removeRecordsDelimiters ( $text, $def = '' ) {
            $text = str_replace('[]', $def, $text);
            $text = str_replace('|', $def, $text);
            return trim($text);
        }



        // ===================================================================
        /**
        *  Транслитерация текста
        *
        *  @access  public
        *  @param   string  $text   текст
        *  @param   string  $from   метка исходного языка
        *  @return  string          транслитерированный текст
        */
        // ===================================================================

        function translitText ( $text, $from = '' ) {

            // с какого языка?
            $from = $this->lowerCase($from);
            switch (trim($from)) {

                // если с русского или украинского
                case 'ru':
                case 'ua':

                    // транслитерируем по типичной таблице символов
                    $charmap = array('а' => 'a',  'б' => 'b',  'в' => 'v',  'г' => 'g',  'д' => 'd',  'е' => 'e',
                                     'є' => 'ye', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',  'і' => 'i',  'и' => 'i',
                                     'й' => 'j',  'к' => 'k',  'ї' => 'yi', 'л' => 'l',  'м' => 'm',  'н' => 'n',
                                     'о' => 'o',  'п' => 'p',  'р' => 'r',  'с' => 's',  'т' => 't',  'у' => 'u',
                                     'ф' => 'f',  'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
                                     'ь' => '',   'ы' => 'y',  'ъ' => '',   'э' => 'e',  'ю' => 'yu', 'я' => 'ya',
                                     'А' => 'A',  'Б' => 'B',  'В' => 'V',  'Г' => 'G',  'Д' => 'D',  'Е' => 'E',
                                     'Є' => 'Ye', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',  'І' => 'I',  'И' => 'I',
                                     'Й' => 'J',  'К' => 'K',  'Ї' => 'Yi', 'Л' => 'L',  'М' => 'M',  'Н' => 'N',
                                     'О' => 'O',  'П' => 'P',  'Р' => 'R',  'С' => 'S',  'Т' => 'T',  'У' => 'U',
                                     'Ф' => 'F',  'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
                                     'Ь' => '',   'Ы' => 'Y',  'Ъ' => '',   'Э' => 'E',  'Ю' => 'Yu', 'Я' => 'Ya');
                    // дополняем таблицу кодировкой Windows-1251
                    if (function_exists('iconv')) {
                        $count = count($charmap);
                        foreach ($charmap as $char => & $change) {
                            $char = @ iconv('UTF-8', 'Windows-1251//IGNORE', $char);
                            if ($char !== FALSE && $char != '' && !isset($charmap[$char])) $charmap[$char] = & $change;
                            $count--;
                            if ($count == 0) break;
                        }
                    }
                    $text = strtr($text, $charmap);

                    // транслитерируем другие возможно неучтенные символы
                    if (function_exists('iconv')) $text = @ iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
                    break;
            }

            // возвращаем результат
            return $text;
        }
    }



    return;
?>