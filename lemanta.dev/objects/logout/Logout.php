<?php
    // макет справочника клиентской стороны
    require_once(dirname(__FILE__) . '/../.ref-models/BasicClientModel.php');



    // =======================================================================
    /**
    *  Клиентский модуль выхода из авторизации
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientLogout extends BasicClientREFModel {

        // имя файла шаблона (без расширения) или массив имен файлов
        protected $template = 'logout';



        // ===================================================================
        /**
        *  Обработка входных параметров
        *
        *  @access  protected
        *  @param   mixed   $params     некие параметры
        *  @return  void
        */
        // ===================================================================

        protected function process ( $params = null ) {
            if (!empty($this->section)) {
                $title = & $this->section->header;
                $this->title = & $this->section->meta_title;
                $this->keywords = & $this->section->meta_keywords;
                $this->description = & $this->section->meta_description;
                $this->seo_description = & $this->section->seo_description;
            } else {
                $title = 'Выход пользователя';
                $this->title = & $title;
            }
            $this->cms->refillPageTitleVar($title);
        }



        // ===================================================================
        /**
        *  Визуализация данных (результирующего контента)
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetch ( & $parent = null ) {

            // забываем об авторизации пользователя
            $this->session->delete('user_nickname');
            $this->session->delete('user_email');
            $this->session->delete('user_email2');
            $this->session->delete('user_password');
            $this->cms->user = null;

            // если страница не имеет шаблона, перенаправляем на главную
            parent::fetch($parent);
            if (empty($this->template_exists)) {
                $this->security->redirectToPage('http://' . $this->cms->root_url . '/');
            }
            return TRUE;
        }
    }



    return;
?>