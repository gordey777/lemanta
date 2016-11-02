<?php
    // подложка макета справочника
    require_once(dirname(__FILE__) . '/BasicSubstrate.php');



    // =======================================================================
    /**
    *  Макет справочника админпанели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class BasicREFModel extends SubstrateREFModel {

        // имя основной таблицы,
        // поле идентификатора записи
        protected $dbtable = 'undefined';
        protected $id_field = 'undefined_id';

        // рекомендуемая страница возврата после операции
        protected $result_page = '';

        // в какую папку выгружать изображения
        protected $upload_folder = '';

        // сколько записей размещать на странице
        protected $items_per_page = 25;

        // признак "Запись изменена (отредактирована)"
        public $changed = FALSE;

        // список упреждающего наполнения шаблонизируемых переменных
        public $preassignable = array();

        // перечень имен разрешенных команд редактирования записей
        protected $my_actions = array();



        // ===================================================================
        /**
        *  Получение имени папки для выгрузки временных файлов
        *
        *  @access  protected
        *  @return  string      имя папки
        */
        // ===================================================================

        protected function getUploadFolder () {
            if (!isset($this->upload_folder) || !is_string($this->upload_folder)) return '';
            return $this->upload_folder;
        }



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
            return isset($this->text) && is_object($this->text) ? $this->text->lowerCase($text, $charset)
                                                                : strtolower($text);
        }



        // ===================================================================
        /**
        *  Получение имени класса из произвольного текста (имени)
        *
        *  @access  public
        *  @param   string  $text   имя
        *  @return  string          имя класса
        */
        // ===================================================================

        public function asClassName ( $text ) {
            if (isset($this->text) && is_object($this->text)) return $this->text->asClassName($text);
            $text = preg_replace('/[^а-яёa-z0-9]+/iu', ' ', $text);
            $text = ucwords($this->lowerCase($text));
            return preg_replace('/^[0-9]+/', '', str_replace(' ', '', $text));
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
            if (isset($this->text) && is_object($this->text)) return $this->text->asMethodName($text);
            return $this->asClassName($text);
        }



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
        *  Проверка token-аутентичности
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function checkToken () {

            // если токен запроса не совпадает с токеном сеанса
            $param = 'token';
            $token = $this->request->getRequest($param, FALSE);
            if ($token === FALSE || $token !== $this->request->getSession($param, FALSE)) {

                // перенаправить на главную
                $this->security->redirectToPage('http://' . $this->cms->root_url . '/' . $this->hdd->safeFilename($this->cms->admin_folder));
            }
        }



        // ===================================================================
        /**
        *  Проверка доступности файла шаблона
        *
        *  @access  public
        *  @param   string  $title      титульный текст страницы
        *  @return  boolean             TRUE если доступен
        */
        // ===================================================================

        public function checkTemplate ( $title = '' ) {

            // устанавливаем заголовок страницы
            if ($title != '') $this->title = $title;

            // сообщение на случай отсутствия шаблона
            $this->body = '<div class="error">'
                             . 'К сожалению, в папке текущего шаблона админпанели '
                             . 'нет файла ' . $this->template . ', который отвечает '
                             . 'за внешний вид данной страницы.'
                        . '</div>';

            // определяем наличие файла шаблона
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->cms->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->cms->settings->admin_theme)
                  . '/html/';
            return is_readable($path . $this->template) && is_file($path . $this->template);
        }
    }



    return;
?>