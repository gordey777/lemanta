<?php
    // макет справочника клиентской стороны
    require_once(dirname(__FILE__) . '/../.ref-models/BasicModelConf.php');



    // =======================================================================
    /**
    *  Настройки модуля RSS
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2011, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class RssConf extends BasicREFModelConf {

        // категория личных настроек модуля,
        // модель настроек модуля (по умолчанию равна имени модели базы данных)
        public $category = 'RSS лента';
        public $model = 'rss';

        // массив настроек (формат элемента описан в BasicREFModelConf)
        public $settings = array('title_text'                        => array('Укажите здесь название вашей ленты новостей', 'Название ленты'),
                                 'description_text'                  => array('Укажите здесь описание ленты', 'Описание ленты'),
                                 'copyright_text'                    => array('Copyright 2015 Название сайта или компании', 'Копирайт ленты'),
                                 'language'                          => array('ru-ru', 'Метка языка ленты'),
                                 'lifetime'                          => array(1800, 'Рекомендованный срок синхронизации ленты (в секундах)'),
                                     'products_type'                 => array('Товары', 'Название типа постов "Товары"'),
                                         'products_count'            => array(9, 'Число товаров в ленте'),
                                         'products_enabled_tags'     => array('b, em, i, u, strong, span, br, p, div, ol, ul, li', 'Список тегов, допустимых в аннотации товара'),
                                         'products_modified_analize' => array(FALSE, 'Определять ли новизну товаров по дате изменения вместо даты создания'),
                                         'products_without_announce' => array(FALSE, 'Выводить ли товары только из названий, без аннотации'),
                                     'kits_type'                     => array('Комплекты', 'Название типа постов "Комплекты товаров"'),
                                         'kits_count'                => array(9, 'Число комплектов товаров в ленте'),
                                         'kits_enabled_tags'         => array('b, em, i, u, strong, span, br, p, div, ol, ul, li', 'Список тегов, допустимых в аннотации комплекта товаров'),
                                         'kits_modified_analize'     => array(FALSE, 'Определять ли новизну комплектов товаров по дате изменения вместо даты создания'),
                                         'kits_without_announce'     => array(FALSE, 'Выводить ли комплекты товаров только из названий, без аннотации'),
                                     'news_type'                     => array('Новости', 'Название типа постов "Новости"'),
                                         'news_count'                => array(3, 'Число новостей в ленте'),
                                         'news_enabled_tags'         => array('b, em, i, u, strong, span, br, p, div, ol, ul, li', 'Список тегов, допустимых в аннотации новости'),
                                         'news_modified_analize'     => array(FALSE, 'Определять ли новизну новостей по дате изменения вместо даты создания'),
                                         'news_without_announce'     => array(FALSE, 'Выводить ли новости только из названий, без аннотации'),
                                     'articles_type'                 => array('Публикации', 'Название типа постов "Статьи"'),
                                         'articles_count'            => array(3, 'Число статей в ленте'),
                                         'articles_enabled_tags'     => array('b, em, i, u, strong, span, br, p, div, ol, ul, li', 'Список тегов, допустимых в аннотации статьи'),
                                         'articles_modified_analize' => array(FALSE, 'Определять ли новизну статей по дате изменения вместо даты создания'),
                                         'articles_without_announce' => array(FALSE, 'Выводить ли статьи только из названий, без аннотации'),
                                     'comments_type'                 => array('Отзывы', 'Название типа постов "Отзывы о товарах"'),
                                         'comments_count'            => array(5, 'Число отзывов на товары в ленте'),
                                         'comments_maxsize'          => array(512, 'Максимальный размер отзыва, после чего выводить ...'),
                                     'ncomments_type'                => array('Комментарии', 'Название типа постов "Комментарии новостей"'),
                                         'ncomments_count'           => array(5, 'Число комментариев новостей в ленте'),
                                         'ncomments_maxsize'         => array(512, 'Максимальный размер комментария новости, после чего выводить ...'),
                                     'acomments_type'                => array('Обсуждение', 'Название типа постов "Комментарии статей"'),
                                         'acomments_count'           => array(5, 'Число комментариев статей в ленте'),
                                         'acomments_maxsize'         => array(512, 'Максимальный размер комментария статьи, после чего выводить ...'),
                                     'forum_type'                    => array('Форум', 'Название типа постов "Форум"'),
                                         'forum_count'               => array(5, 'Число постов форума в ленте'),
                                         'forum_maxsize'             => array(512, 'Максимальный размер поста форума, после чего выводить ...'),
                                 'statist_enabled'                   => array(TRUE, 'Включен ли механизм статистики чтения ленты'),
                                     'statist_smsing'                => array(FALSE, 'Разрешено ли отправлять статистику по СМС'),
                                         'statist_phones'            => array('', 'Список телефонов администратора через запятую (по умолчанию телефоны из настроек шлюзов)'),
                                         'statist_sms_template'      => array('', 'Шаблон СМС (по умолчанию sms/statist_rss.htm)'),
                                     'statist_emailing'              => array(TRUE, 'Разрешено ли отправлять статистику на емейл'),
                                         'statist_emails'            => array('', 'Список емейлов администратора через запятую (по умолчанию емейл из настроек сайта)'),
                                         'statist_email_template'    => array('', 'Шаблон письма (по умолчанию email/statist_rss.htm)'));
    }



    return;
?>