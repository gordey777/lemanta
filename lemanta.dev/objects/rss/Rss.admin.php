<?php
    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/../.ref-models/AdminSetupUniversal.php');



    // =======================================================================
    /**
    *  Админ модуль RSS ленты
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Rss extends AdminSetupUniversalREFModel {

        // заголовок страницы
        public $title = 'Настройки RSS';

        // имя модели базы данных
        protected $dbmodel = 'rss';

        // имя файла шаблона
        protected $template = 'rss/rss.htm';
    }



    return;
?>