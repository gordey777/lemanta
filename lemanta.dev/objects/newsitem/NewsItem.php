<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;

    // модуль статей
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ARTICLES_OBJECT);



    // =======================================================================
    /**
    *  Модуль новостей на клиентской стороне
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientNewsItem extends ClientArticles {

        // сколько записей размещать на странице,
        // сколько комментариев размещать на странице записи
        protected $items_per_page = DEFAULT_VALUE_FOR_NEWS_ON_PAGE_IN_CLIENT;
        protected $item_comments_per_page = DEFAULT_VALUE_FOR_NEWSCOMMENTS_ON_PAGE_IN_CLIENT;



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

            // читаем из входных параметров url новости
            $url = $this->request->getGetAsSentence('url');

            // если данные новости текущего раздела магазина не были прочитаны ранее, читаем из базы данных
            if (empty($this->news_item)) {
                $params = new stdClass;
                $params->url = $url;
                $params->enabled = 1;
                $params->section = $this->now_in_section;
                if (!isset($this->user->user_id)) $params->hidden = 0;
                $this->db->news->one($this->news_item, $params);
            }

            // если данные новости не прочитаны
            if (empty($this->news_item)) {
                $this->body = CONTENT_MESSAGE_NO_PAGE;
                $this->parent->headerError404();
                return;
            }

            // передаем данные в мета информацию страницы
            $this->title = & $this->news_item->meta_title;
            $this->keywords = & $this->news_item->meta_keywords;
            $this->description = & $this->news_item->meta_description;
            $this->seo_description = & $this->news_item->seo_description;

            // обрабатываем редактирование комментария
            $this->posting($this->news_item);

            // читаем список комментариев на текущей странице
            $params = new stdClass;
            $params->news_id = $this->news_item->news_id;
            $params->enabled = 1;
            // $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            // $params->start = $current_page * $this->item_comments_per_page;
            // $params->maxcount = $this->item_comments_per_page;
            $pages_num = $this->db->get_ncomments($this->news_item->comments, $params, $this->news_item->comments_count);

            // если только пришли на новость (не листали страницы комментариев), увеличить количество просмотров и передать в базу данных
            if (($this->param(REQUEST_PARAM_NAME_PAGE) == '') && !isset($_POST['post_submit'])) {
                $this->news_item->browsed++;
                $item = new stdClass;
                $item->news_id = $this->news_item->news_id;
                $item->browsed = $this->news_item->browsed;
                $this->db->news->update($item);

                // запоминаем текущую страницу в списке просмотренных в текущем сеансе
                if (!isset($_SESSION['recent_news']) || !is_array($_SESSION['recent_news'])) $_SESSION['recent_news'] = array();
                $key = array_search($this->news_item->news_id, $_SESSION['recent_news']);
                if ($key !== FALSE) {
                    unset($_SESSION['recent_news'][$key]);
                    $_SESSION['recent_news'] = array_values($_SESSION['recent_news']);
                }
                array_unshift($_SESSION['recent_news'], $this->news_item->news_id);
                if (count($_SESSION['recent_news']) > RECENT_PAGES_LIST_MAXSIZE) array_pop($_SESSION['recent_news']);

                // запоминаем список в браузере пользователя
                if (function_exists('setcookie')) {

                    // удаляем старые cookie
                    if (isset($_COOKIE['recent_news'])) {
                        if (is_array($_COOKIE['recent_news'])) {
                            foreach ($_COOKIE['recent_news'] as $key => $item) {
                                setcookie('recent_news[' . $key . ']', '', time() - 365 * 24 * SECONDS_IN_HOUR, '/');
                            }
                        } else {
                            setcookie('recent_news', '', time() - 365 * 24 * SECONDS_IN_HOUR, '/');
                        }
                    }

                    // добавляем новые cookie
                    if (is_array($_SESSION['recent_news'])) {
                        foreach ($_SESSION['recent_news'] as $key => $item) {
                            setcookie('recent_news[' . $key . ']', $item, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                        }
                    }
                }
            }

            // создаем контент листания страниц
            // if (!isset($pages_num)) $pages_num = 0;
            // $pages_num = $pages_num / $this->item_comments_per_page;
            // $navigator = new ClientPagesNavigation($this);
            // $navigator->make($pages_num);

            // передаем данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef('news_item', $this->news_item);
            // $this->smarty->assignByRef('PagesNavigation', $navigator->body);
            $this->smarty->assignByRef('CurrentPageMaxsize', $this->item_comments_per_page);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('message', $this->message);
            $this->smarty->fetchByTemplate($this, 'page.news_item', 'news_item');
            return TRUE;
        }
    }



    return;
?>