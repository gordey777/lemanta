<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Работа с XML
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class XmlANYModel extends BasicANYModel {

        // объект XML
        protected $writer = null;
        protected $reader = null;

        // версия, кодировка документа
        public $version = '1.0';
        public $encoding = 'UTF-8';

        // отступ, перевод строки
        public $indent = '    ';
        public $crlr = "\n";



        // ===================================================================
        /**
        *  Проверка доступности необходимых классов
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function checkRequiredClasses () {
            parent::checkRequiredClasses();
            $class = 'XMLWriter';
            if (!class_exists($class)) {
                echo 'В конфигурации PHP данного сайта отключена поддержка класса '
                   . $class . '! Работа функций движка, связанных с этим '
                   . 'классом, невозможна и потому прервана. Обратитесь к '
                   . 'технической службе хостинга с просьбой включить '
                   . 'поддержку указанного класса.';
                exit;
            }
            $class = 'XMLReader';
            if (!class_exists($class)) {
                echo 'В конфигурации PHP данного сайта отключена поддержка класса '
                   . $class . '! Работа функций движка, связанных с этим '
                   . 'классом, невозможна и потому прервана. Обратитесь к '
                   . 'технической службе хостинга с просьбой включить '
                   . 'поддержку указанного класса.';
                exit;
            }
            $class = 'SimpleXMLElement';
            if (!class_exists($class)) {
                echo 'В конфигурации PHP данного сайта отключена поддержка класса '
                   . $class . '! Работа функций движка, связанных с этим '
                   . 'классом, невозможна и потому прервана. Обратитесь к '
                   . 'технической службе хостинга с просьбой включить '
                   . 'поддержку указанного класса.';
                exit;
            }
        }



        // ===================================================================
        /**
        *  Подготовительные действия
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function prepare () {
            parent::prepare();
            $this->writer = new XMLWriter();
            $this->reader = new XMLReader();
        }



        // ===================================================================
        /**
        *  Экспорт данных в XML
        *
        *  @access  public
        *  @param   mixed   $data       данные
        *  @param   string  $root       имя открывающего тега контейнера
        *  @param   boolean $append     признак "для добавления к существующему"
        *  @return  string              текст XML
        */
        // ===================================================================

        public function export ( $data, $root = '', $append = FALSE ) {

            // назначаем отступы
            $this->writer->setIndent = FALSE;
            $this->writer->setIndentString = '';

            // открывающий тег документа
            if (!$this->writer->openMemory()) return '';
            if (!$append && !$this->writer->startDocument($this->version, $this->encoding)) return '';

            // выполняем экспорт
            $this->doExport($data, $root);

            // закрывающий тег документа
            if ($append) $this->writer->endDocument();

            // возвращаем текст документа
            return $this->writer->outputMemory();
        }



        // ===================================================================
        /**
        *  Экспорт данных XML в файл
        *
        *  @access  public
        *  @param   string  $file       имя файла
        *  @param   mixed   $data       данные
        *  @param   string  $root       имя открывающего тега контейнера
        *  @return  string
        */
        // ===================================================================

        public function exportFile ( $file, $data, $root = '' ) {
            $append = is_file($file) && is_readable($file);
            $handle = @ fopen($file, 'rb+');
            if (!$handle) {
                $append = FALSE;
                $handle = @ fopen($file, 'wb');
            }
            if ($handle) {
                @ flock($handle, LOCK_EX);
                fseek($handle, 0, SEEK_END);
                $xml = $this->export($data, $root, $append);
                fwrite($handle, $xml, strlen($xml));
                fclose($handle);
            }
        }



        // ===================================================================
        /**
        *  Исполнение экспорта данных в XML
        *
        *  @access  private
        *  @param   mixed   $data       данные
        *  @param   string  $root       имя открывающего тега контейнера
        *  @param   string  $indent     строка отступа
        *  @param   integer $index      индекс вложенного элемента
        *  @return  void
        */
        // ===================================================================

        private function doExport ( & $data, $root, $indent = '', $index = null ) {

            // открывающий тег
            $root = $this->safeTag($root);
            if ($root != '') {
                $this->writer->text($indent);
                $this->writer->startElement($root);

                // атрибуты тега
                if (!is_null($index)) $this->writer->writeAttribute('index', $index);
                if (is_array($data)) {
                    $this->writer->writeAttribute('type', 'array');
                    $this->writer->writeAttribute('size', count($data));
                } elseif (is_object($data)) {
                    $this->writer->writeAttribute('type', 'object');
                    $count = 0;
                    foreach ($data as $value) $count++;
                    $this->writer->writeAttribute('size', $count);
                } elseif (is_bool($data)) {
                    $this->writer->writeAttribute('type', 'boolean');
                } elseif (is_int($data)) {
                    $this->writer->writeAttribute('type', 'integer');
                } elseif (is_float($data)) {
                    $this->writer->writeAttribute('type', 'float');
                } elseif (is_string($data)) {
                    $this->writer->writeAttribute('type', 'string');
                    $data = $this->safeText($data);
                    if (function_exists('mb_strlen')) {
                        $this->writer->writeAttribute('size', mb_strlen($data, 'UTF-8'));
                    } else {
                        $this->writer->writeAttribute('size', strlen($data));
                    }
                } elseif (is_null($data)) {
                    $this->writer->writeAttribute('type', 'null');
                } else {
                    $this->writer->writeAttribute('type', 'undefined');
                }
            }

            // если это структура
            if (is_array($data) || is_object($data)) {
                if ($root != '') {
                    $this->writer->text($this->crlr);
                }
                foreach ($data as $index => $value) {
                    $this->doExport($value,
                                    is_numeric($index) ? $root : $index,
                                    $indent . $this->indent,
                                    is_numeric($index) ? $index : null);
                }
                if ($root != '') {
                    $this->writer->text($indent);
                }

            // иначе если стандартный тип
            } elseif (is_bool($data)) {
                $this->writer->text($data ? 1 : 0);
            } elseif (is_int($data)) {
                $this->writer->text($data);
            } elseif (is_float($data)) {
                $this->writer->text(str_replace(',', '.', $data));
            } elseif (is_string($data)) {
                $this->writer->text($data);
            } else {
                $this->writer->text('');
            }

            // закрывающий тег
            if ($root != '') {
                $this->writer->endElement();
                $this->writer->text($this->crlr);
            }
        }



        // ===================================================================
        /**
        *  Сканирование узлов XML-файла с вызовом callback-функции для каждого
        *
        *  @access  public
        *  @param   string  $file       имя файла
        *  @param   string  $path       путь к сканируемым узлам
        *                                   например Узел->ПодУзел->НеобходимыйУзел
        *  @param   boolean $for_all    TRUE если обслуживать все подходящие узлы
        *                               FALSE если только первый подходящий узел
        *  @param   method  $callback   функция обратного вызова
        *  @param   mixed   $data       некие данные для обратного вызова
        *  @return  integer             число найденных узлов
        */
        // ===================================================================

        public function scanFileNodes ( $file, $path, $for_all = TRUE, $callback = null, & $data = null ) {

            // высчитываем глубину пути
            $count = 0;
            $path = explode('->', $path);
            foreach ($path as $i => $v) {
                $v = trim($v);
                if ($v == '') {
                    unset($path[$i]);
                    continue;
                }
                $path[$i] = $this->text->lowerCase($v);
            }
            $path = array_values($path);
            if (!empty($path)) {
                $maxdepth = count($path) - 1;
                $path = implode('->', $path);

                // открываем файл
                try {
                    @ $this->reader->open($file);
                    try {

                        // ищем узлы
                        $i = @ $this->reader->read();
                        if ($i) {
                            $mypath = '';
                            $current = 0;
                            do {
                                if (@ $this->reader->nodeType == XMLReader::ELEMENT) {
                                    $v = $this->text->lowerCase($this->reader->name);
                                    $depth = @ $this->reader->depth;
                                    if ($depth >= $maxdepth) {

                                        // если узел найден
                                        if ($path == $mypath . $v) {
                                            $count++;

                                            // передаем XML узла в функцию обратного вызова
                                            if (!is_null($callback)) {
                                                try {
                                                    if (is_string($callback)) {
                                                        $xml = new SimpleXMLElement(@ $this->reader->readOuterXML());
                                                        $callback($xml, $data);
                                                    } elseif (is_array($callback)
                                                              && isset($callback[0]) && is_object($callback[0])
                                                              && isset($callback[1]) && is_string($callback[1])) {
                                                        $xml = new SimpleXMLElement(@ $this->reader->readOuterXML());
                                                        $callback[0]->$callback[1]($xml, $data);
                                                    }
                                                } catch (Exception $e) { }
                                            }

                                            // если просили не обслуживать остальные подходящие узлы
                                            if (!$for_all) break;
                                        }

                                        // идем к следующему узлу
                                        $i = @ $this->reader->next();

                                    } else {
                                        while ($current >= $depth) {
                                            if ($mypath != '') {
                                                $mypath = explode('->', $mypath);
                                                array_pop($mypath);
                                                array_pop($mypath);
                                                $mypath = implode('->', $mypath);
                                                if ($mypath != '') $mypath .= '->';
                                            }
                                            $current--;
                                        }
                                        $mypath .= $v . '->';
                                        $current = $depth;
                                        $i = @ $this->reader->read();
                                    }
                                } else {
                                    $i = @ $this->reader->read();
                                }
                            } while ($i);
                        }
                    } catch (Exception $e) { }

                    // закрываем файл
                    try {
                        @ $this->reader->close();
                    } catch (Exception $e) { }

                } catch (Exception $e) { }
            }

            return $count;
        }



        // ===================================================================
        /**
        *  Получение узла из объекта SimpleXMLElement
        *
        *  @access  public
        *  @param   object  $element    исходный объект
        *  @param   string  $path       путь искомого узла
        *                                   например Узел->ПодУзел->НеобходимыйУзел
        *  @param   mixed   $def        значение по умолчанию
        *  @param   boolean $as_string  TRUE если искомый узел преобразовать в строку
        *                               FALSE если возвратить искомый узел в оригинале
        *  @return  mixed               содержимое узла
        */
        // ===================================================================

        public function getSimpleXMLElementNode ( $element, $path, $def = '', $as_string = TRUE ) {
            $path = explode('->', $path);
            foreach ($path as $v) {
                $v = trim($v);
                if ($v == '') continue;
                if (!isset($element->$v) && !isset($element[$v])) {
                    if (!is_array($element)) return $def;
                    $element = reset($element);
                    if (!isset($element->$v) && !isset($element[$v])) return $def;
                }
                if (isset($element->$v)) $element = $element->$v;
                else $element = $element[$v];
            }
            return $as_string ? trim($element) : $element;
        }



        // ===================================================================
        /**
        *  Получение безопасного имени тега
        *
        *  @access  public
        *  @param   string  $tag        имя тега
        *  @return  string              безопасное имя
        */
        // ===================================================================

        public function safeTag ( $tag ) {
            $tag = preg_replace('/[^а-яёa-z0-9_\-]+/iu', ' ', $tag);
            return str_replace(' ', '_', trim($tag));
        }



        // ===================================================================
        /**
        *  Получение безопасного внутри тегового текста
        *
        *  @access  public
        *  @param   string  $text       текст
        *  @return  string              безопасный текст
        */
        // ===================================================================

        public function safeText ( $text ) {
            $text = str_replace('<', '&lt;', $text);
            $text = str_replace('>', '&gt;', $text);
            return trim($text);
        }



        // ===================================================================
        /**
        *  Получение текста, возможно содержащего теги, для вывода внутри XML-тега
        *
        *  @access  public
        *  @param   string  $text       текст
        *  @return  string              безопасный текст
        */
        // ===================================================================

        public function cdataText ( $text ) {
            return strpos($text, '<') !== FALSE || strpos($text, '>') !== FALSE ? '<![CDATA[' . $text . ']]>' : $text;
        }



        // ===================================================================
        /**
        *  Распечатка в отладочных целях
        *
        *  @access  public
        *  @param   string  $xml    текст XML
        *  @return  void
        */
        // ===================================================================

        public function dump ( $xml ) {
            echo '<pre>'
                    . str_replace('<', '&lt;',
                      str_replace('>', '&gt;', (!is_string($xml)
                                               && !is_int($xml)
                                               && !is_float($xml) ? print_r($xml, TRUE)
                                                                  : $xml)))
               . '</pre>';
        }
    }



    return;
?>