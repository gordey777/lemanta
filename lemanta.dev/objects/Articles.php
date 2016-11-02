<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;

    // подложка модуля клиентской стороны
    require_once(ROOT_FOLDER_REFERENCE
               . FOLDERNAME_FOR_ENGINE_OBJECTS
               . '/ClientSubstrate.php');

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT);



    // =======================================================================
    /**
    *  Модуль статей на клиентской стороне
    *
    *  Использование этого класса происходит в результате переназначения класса
    *  Articles на данный класс во время загрузки модуля статей.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientArticles extends ClientSubstrate {

        // сколько записей размещать на странице,
        // сколько комментариев размещать на странице записи
        protected $items_per_page = DEFAULT_VALUE_FOR_ARTICLES_ON_PAGE_IN_CLIENT;
        protected $item_comments_per_page = DEFAULT_VALUE_FOR_ARTICLESCOMMENTS_ON_PAGE_IN_CLIENT;



        // ===================================================================
        /**
        *  Обработка редактирования комментария
        *
        *  @access  protected
        *  @param   object  $record     объект записи
        *  @return  boolean             TRUE если допущена ошибка
        */
        // ===================================================================

        protected function posting ( & $record ) {

            // ошибки здесь еще не было
            $cancel = FALSE;

            // читаем входные параметры контроля репостинга html-формы
            $copystop = $this->text->stripTags($this->param('post_copystop'), TRUE);
            if (empty($copystop)) $copystop = rand(1, 1000000000);

            // читаем входные параметры html-формы
            $item = new stdClass;
            $item->name = $this->text->stripTags($this->param('post_name'), TRUE);
            $item->comment = trim($this->text->stripTags($this->param('post_message')));
            $item->email = $this->text->stripTags($this->param('post_email'), TRUE);
            $item->parent_id = @intval($this->param('post_parent_id'));

            // если получены данные об изменениях
            if (isset($_POST['post_submit'])) {

                // берем IP-адрес пользователя
                $client_ip = $this->security->getVisitorIp();

                // проверяем наличие неотмененного запрета доступа к комментариям для такого IP-адреса (включив проверку даты действия запрета)
                $params = new stdClass;
                $params->ip = $client_ip;
                $params->enabled = 1;
                $params->no_comment = 1;
                $params->date = 1;
                $this->db->get_banned($row, $params);

                // если запрет доступа существует, регистрируем +1 попытку доступа, формируем сообщение об ошибке
                if (!empty($row)) {
                    $temp = new stdClass;
                    $temp->ban_id = $row->ban_id;
                    $temp->attempts = $row->attempts + 1;
                    $temp->attempts_date = time();
                    $this->db->update_banned($temp);
                    $cancel = $this->push_error($this->settings->banneds_nocomment_text);
                } else {

                    // проверяем имя, текст и емейл
                    if ($item->name == '') $cancel = $this->push_error('Вы не ввели имя!');
                    if ($item->comment == '') $cancel = $this->push_error('Вы не ввели текст комментария!');
                    if (($item->email != '') && !preg_match(EMAIL_CHECKING_PATTERN, $item->email)) $cancel = $this->push_error('Емейл должен быть в формате aaa@bbb.ccc!');

                    // если доступен инспектор атак и неправильно введен защитный код
                    if (!$this->security->checkCaptcha()) $cancel = $this->push_error('Введите правильный защитный код с картинки.');
                }

                // если это действительно html-форма (не ее репостинг)
                if (!$cancel) {
                    if (!isset($_SESSION['comment_copystop']) || !in_array($copystop, $_SESSION['comment_copystop'])) {

                        $param_name = 'articles_comment_next_time';
                        if (isset($record->news_id)) $param_name = 'news_comment_next_time';

                        // проверям лимит времени на комментарии
                        $item->date = time();
                        if (isset($_SESSION[$param_name]) && ($_SESSION[$param_name] > $item->date)) {
                            $cancel = $this->push_error('У вас нет прав оставлять комментарии слишком часто! Попробуйте через ' . @intval($_SESSION[$param_name] - $item->date) . ' секунд.');
                        } else {

                            // передаем комментарий в базу данных
                            $item->ip = $client_ip;
                            $item->from_user = isset($this->user->user_id) ? $this->user->user_id : 0;
                            if (isset($record->article_id)) {
                                $item->article_id = $record->article_id;
                                $item->enabled = ($this->settings->articles_comment_moderation == 1) ? 0 : 1;
                                $item->comment_id = $this->db->update_acomment($item);
                                $next_time = abs(@intval($this->settings->articles_comment_next_time));
                            } elseif (isset($record->news_id)) {
                                $item->news_id = $record->news_id;
                                $item->enabled = ($this->settings->news_comment_moderation == 1) ? 0 : 1;
                                $item->comment_id = $this->db->update_ncomment($item);
                                $next_time = abs(@intval($this->settings->news_comment_next_time));
                            } else {
                                $cancel = $this->push_error('Не существует или не распознан целевой объект комментария.');
                            }

                            // отправляем письмо администратору о принятом комментарии
                            if (!$cancel) {
                                $item->date = $this->date->readableDateTime($item->date);
                                $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $item);
                                $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST_OBJECT, $record);
                                $message = $this->smarty->fetch($this->admin_folder . '/design/' . $this->settings->admin_theme . '/html/' . EMAIL_POST_TO_ADMIN_TEMPLATE_FILE);
                                $this->email($this->settings->admin_email, $item->date . ' новый комментарий на сайте ' . $this->root_url . ' от ' . $item->name, $message);

                                // информационное сообщение комментатору
                                $this->message = 'Спасибо! Ваш комментарий принят' . (($item->enabled != 1) ? ' и отправлен на модерацию' : '') . '.';

                                // установить странице фоновый звук УСПЕХ
                                $this->success_bgsound();

                                // засекаем новый лимит времени на комментарии
                                $_SESSION[$param_name] = time() + $next_time;

                                // блокируем репостинг этой html-формы
                                $_SESSION['comment_copystop'][] = $copystop;
                            }
                        }
                    }

                    // если прошло удачно, очищаем параметры для html-формы
                    if (!$cancel) {
                        $copystop = rand(1, 1000000000);
                        $item->name = '';
                        $item->comment = '';
                        $item->email = '';
                        $item->parent_id = '';
                    }
                }
            }

            // возвращаем в html-форму принятые от нее параметры
            $this->smarty->assign('post_copystop', $copystop);
            $this->smarty->assign('post_name', ($item->name == '') ? (empty($this->user) ? '' : $this->user->compound_name) : $item->name);
            $this->smarty->assignByRef('post_message', $item->comment);
            $this->smarty->assign('post_email', ($item->email == '') ? (empty($this->user) ? '' : ((trim($this->user->email) != '') ? $this->user->email : $this->user->email2)) : $item->email);
            $this->smarty->assign('post_parent_id', empty($item->parent_id) ? '' : $item->parent_id);

            // возвращаем была ли ошибка
            return $cancel;
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

            // читаем из входных параметров url статьи, если нет, значит это список статей
            $url = $this->request->getGetAsSentence('url');
            if ($url != '') {
                $this->fetch_item($url);
            } else {
                $this->fetch_list();
            }

            // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
            return TRUE;
        }



        // ===================================================================
        /**
        *  Визуализация контента списка публикаций
        *
        *  @access  private
        *  @return  void
        */
        // ===================================================================

        private function fetch_list () {

            // читаем список статей текущего раздела магазина на текущей странице
            $params = new stdClass;
            $params->sort = $this->settings->articles_sort_method;
            $params->enabled = 1;
            $params->section = $this->now_in_section;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            $params->start = $current_page * $this->items_per_page;
            $params->maxcount = $this->items_per_page;
            $count = $this->db->get_articles($items, $params);
            $this->db->fix_articles_records($items);

            // читаем количество комментариев у статей
            foreach ($items as & $item) {
                $params = new stdClass;
                $params->article_id = $item->article_id;
                $params->enabled = 1;
                $params->start = 0;
                $params->maxcount = 0;
                $this->db->get_acomments($temp, $params, $item->comments_count);
            }

            // создаем контент листания страниц
            $pages_num = $count / $this->items_per_page;
            $navigator = new ClientPagesNavigation($this);
            $navigator->make($pages_num);

            // устанавливаем заголовок страницы
            $this->title = 'Статьи';

            // передаем данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef('all_articles', $items);
            $this->smarty->assignByRef('items_count', $count);
            $this->smarty->assignByRef('PagesNavigation', $navigator->body);
            $this->smarty->assignByRef('CurrentPageMaxsize', $this->items_per_page);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('message', $this->message);
            $this->smarty->fetchByTemplate($this, 'page.articles', 'articles');
        }



        // ===================================================================
        /**
        *  Визуализация контента публикации
        *
        *  @access  private
        *  @param   string  $url    адрес страницы публикации
        *  @return  void
        */
        // ===================================================================

        private function fetch_item ( $url ) {

            // если данные статьи текущего раздела магазина не были прочитаны ранее, читаем из базы данных
            if (empty($this->article)) {
                $params = new stdClass;
                $params->url = $url;
                $params->enabled = 1;
                $params->section = $this->now_in_section;
                if (!isset($this->user->user_id)) $params->hidden = 0;
                $this->db->get_article($this->article, $params);
            }

            // если данные статьи не прочитаны
            if (empty($this->article)) {
                $this->body = CONTENT_MESSAGE_NO_PAGE;

                // код ответа сервера
                $this->parent->headerError404();
                return;
            }

            // передаем данные в мета информацию страницы
            $this->title = & $this->article->meta_title;
            $this->keywords = & $this->article->meta_keywords;
            $this->description = & $this->article->meta_description;
            $this->seo_description = & $this->article->seo_description;

            // обрабатываем редактирование комментария
            $this->posting($this->article);

            // читаем список комментариев на текущей странице
            $params = new stdClass;
            $params->article_id = $this->article->article_id;
            $params->enabled = 1;
            // $current_page = intval($this->param(REQUEST_PARAM_NAME_PAGE));
            // $params->start = $current_page * $this->item_comments_per_page;
            // $params->maxcount = $this->item_comments_per_page;
            $pages_num = $this->db->get_acomments($this->article->comments, $params, $this->article->comments_count);

            // если только пришли на статью (не листали страницы комментариев), увеличить количество просмотров и передать в базу данных
            if (($this->param(REQUEST_PARAM_NAME_PAGE) == '') && !isset($_POST['post_submit'])) {
                $this->article->browsed++;
                $item = new stdClass;
                $item->article_id = $this->article->article_id;
                $item->browsed = $this->article->browsed;
                $this->db->update_article($item);

                // запоминаем текущую страницу в списке просмотренных в текущем сеансе
                if (!isset($_SESSION['recent_articles']) || !is_array($_SESSION['recent_articles'])) $_SESSION['recent_articles'] = array();
                $key = array_search($this->article->article_id, $_SESSION['recent_articles']);
                if ($key !== FALSE) {
                    unset($_SESSION['recent_articles'][$key]);
                    $_SESSION['recent_articles'] = array_values($_SESSION['recent_articles']);
                }
                array_unshift($_SESSION['recent_articles'], $this->article->article_id);
                if (count($_SESSION['recent_articles']) > RECENT_PAGES_LIST_MAXSIZE) array_pop($_SESSION['recent_articles']);

                // запоминаем список в браузере пользователя
                if (function_exists('setcookie')) {

                    // удаляем старые cookie
                    if (isset($_COOKIE['recent_articles'])) {
                        if (is_array($_COOKIE['recent_articles'])) {
                            foreach ($_COOKIE['recent_articles'] as $key => $item) {
                                setcookie('recent_articles[' . $key . ']', '', time() - 365 * 24 * SECONDS_IN_HOUR, '/');
                            }
                        } else {
                            setcookie('recent_articles', '', time() - 365 * 24 * SECONDS_IN_HOUR, '/');
                        }
                    }

                    // добавляем новые cookie
                    if (is_array($_SESSION['recent_articles'])) {
                        foreach ($_SESSION['recent_articles'] as $key => $item) {
                            setcookie('recent_articles[' . $key . ']', $item, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
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
            $this->smarty->assignByRef('article', $this->article);
            // $this->smarty->assignByRef('PagesNavigation', $navigator->body);
            $this->smarty->assignByRef('CurrentPageMaxsize', $this->item_comments_per_page);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('message', $this->message);
            $this->smarty->fetchByTemplate($this, 'page.article', 'article');
        }
    }



    return;
?>