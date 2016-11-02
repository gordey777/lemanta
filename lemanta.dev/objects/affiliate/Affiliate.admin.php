<?php
    // =======================================================================
    /**
    *  Админ модуль партнерской программы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/../.ref-models/AdminSetup.php');

    // текст заголовка страницы модуля
    define('AFFILIATE_PAGE_TITLE', 'Партнерская программа');

    // имя файла шаблона модуля
    define('AFFILIATE_TEMPLATE_FILENAME', 'affiliate/affiliate.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('AFFILIATE_MODULELINK_POINTER', 'Affiliate');
    define('AFFILIATE_MODULETAB_TEXT', 'партнерка');
    define('AFFILIATE_MODULEMENU_PATH', 'Клиенты / Партнерская программа');



    // =======================================================================
    /**
    *  Админ модуль партнерской программы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Affiliate extends AdminSetupREFModel {

        // имя модели базы данных
        protected $dbmodel = 'affiliate';

        // имя файла шаблона
        protected $template = AFFILIATE_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Сохранение полученных во время редактирования настроек сайта
        *
        *  @access  protected
        *  @param   string  $upload_folder      относительное имя папки сохранения ожидаемых файлов (будет возвращено сюда)
        *                                       пустая строка = не ждем таких
        *  @param   string  $upload_watermark   имя ожидаемого файла водяного знака (будет возвращено сюда)
        *                                       пустая строка = не ждем такой файл
        *  @return  void
        */
        // ===================================================================

        protected function processSetupSave ( & $upload_folder = '', & $upload_watermark = '' ) {

            // текущий курс (для перевода в базовую валюту сайта)
            $rate = $this->currency->rate();

            // разрешена или нет
            $field = 'affiliates_enabled';
            $this->cms->db->settings->saveFromPost($field, 'Партнерская программа - разрешена или нет');

            // вознаграждение за привод на сайт
            $field = 'affiliates_referal_cost';
                $value = isset($_POST[$field]) && round($this->number->floatValue($_POST[$field]), 4) > 0 ? round($this->number->floatValue($_POST[$field]) * $rate, 4) : 0;
                $this->cms->db->settings->save($field, $value, 'Партнерская программа - вознаграждение за привод на сайт');

            // таймер слежения за повторными приводами
            $field = 'affiliates_referal_lifetime';
            $this->cms->db->settings->saveFromPost($field, 'Партнерская программа - таймер слежения за повторными приводами');

            // отклонять приводы с неопознанных страниц
            $field = 'affiliates_referal_urlchecking';
            $this->cms->db->settings->saveFromPost($field, 'Партнерская программа - отклонять ли приводы с неопознанных страниц');

            // вознаграждение за регистрацию
            $field = 'affiliates_registration_cost';
                $value = isset($_POST[$field]) && round($this->number->floatValue($_POST[$field]), 4) > 0 ? round($this->number->floatValue($_POST[$field]) * $rate, 4) : 0;
                $this->cms->db->settings->save($field, $value, 'Партнерская программа - вознаграждение за регистрацию реферала');

            // комиссия за оплаченный заказ
            $field = 'affiliates_commission_percent';
            $this->cms->db->settings->saveFromPost($field, 'Партнерская программа - комиссия за оплаченный рефералом заказ');

            // вознаграждение за сделанный заказ
            $field = 'affiliates_commission_percent_gift';
            $this->cms->db->settings->saveFromPost($field, 'Партнерская программа - вознаграждение за сделанный рефералом заказ');

            // брать комиссию с полной суммы заказа
            $field = 'affiliates_commission_full';
            $this->cms->db->settings->saveFromPost($field, 'Партнерская программа - брать ли комиссию с полной суммы заказа, включая стоимость доставки');

            // ограничить комиссию суммой
            $field = 'affiliates_commission_limit';
                $value = isset($_POST[$field]) && round($this->number->floatValue($_POST[$field]), 2) > 0 ? round($this->number->floatValue($_POST[$field]) * $rate, 2) : '';
                $this->cms->db->settings->save($field, $value, 'Партнерская программа - какой суммой ограничить комиссию');

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(AFFILIATE_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>