<?php
  // Impera CMS: админ модуль переписки,
  //             админ модуль отзывов о товарах,
  //             админ модуль комментариев к статьям,
  //             админ модуль комментариев к новостям,
  //             админ модуль запросов связи (функция "Позвоните мне").
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT);

  // какой файл является шаблоном модуля работы с отзывами о товарах,
  // какой файл является шаблоном модуля работы с комментариев к статьям,
  // какой файл является шаблоном модуля работы с комментариев к новостям,
  // какой файл является шаблоном модуля запросов связи
  define("ADMIN_COMMENTS_CLASS_TEMPLATE_FILE", "admin_comments.htm");
  define("ADMIN_ACOMMENTS_CLASS_TEMPLATE_FILE", "admin_acomments.htm");
  define("ADMIN_NCOMMENTS_CLASS_TEMPLATE_FILE", "admin_ncomments.htm");
  define("ADMIN_CALLME_CLASS_TEMPLATE_FILE", "admin_callme.htm");

  // названия динамических параметров
  define("CALLME_SESSION_PARAM_NAME", "admin_callme");



  // =========================================================================
  // Класс Feedback (админ модуль переписки)
  // =========================================================================

  class Feedback extends Basic {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    protected $dbtable = DATABASE_FEEDBACK_TABLENAME;
    protected $dbtable_field = 'feedback_id';

    // рекомендуемая страница возврата после операции,
    // сколько записей размещать на странице
    protected $result_page = '';
    protected $items_per_page = DEFAULT_VALUE_FOR_FEEDBACK_ON_PAGE_IN_ADMIN;



    // ===================================================================
    /**
    *  Конструктор класса
    *
    *  @access  public
    *  @param   object  $parent         объект владельца
    *  @param   integer $start_mode     режим запуска
    *  @return  void
    */
    // ===================================================================

    public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {

        // конструируем объект: вторым параметром сообщаем, что он для админпанели
        parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
    }



    // обработка входных параметров и команд =================================

    protected function process () {

      // пока никаких изменений в базе данных нет,
      // по умолчанию все команды позволяют на последнем запросе отследить изменения в базе данных,
      // пока нет отмены перенаправления на страницу возврата
      $this->changed = FALSE;
      $watching = TRUE;
      $cancel = FALSE;

      // читаем входной параметр ITEM_ID - идентификатор оперируемой записи,
      // параметр FROM - на какую страницу вернуться после операции,
      // параметр ACTION - какую команду требовали сделать
      $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));
      $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
      $act = trim($this->param(REQUEST_PARAM_NAME_ACTION));

      // если действительно передали идентификатор оперируемой записи или это команда "Удалить помеченные записи"
      if (!empty($id) || ($act == ACTION_REQUEST_PARAM_VALUE_MASSDELETE)) {

        // создаем пустой массив для запросов
        $query = array();

        // какую команду требовали сделать во входном параметре ACTION?
        switch ($act) {

          // если команду "Удалить помеченные записи"
          case ACTION_REQUEST_PARAM_VALUE_MASSDELETE:

            // если передан массив идентификаторов
            if (isset($_POST[REQUEST_PARAM_NAME_DELETEIDS]) && is_array($_POST[REQUEST_PARAM_NAME_DELETEIDS])) {

              // перебираем элементы массива
              foreach ($_POST[REQUEST_PARAM_NAME_DELETEIDS] as $item) {

                // указано ли блокировать IP-адрес?
                $ban_ip = "";
                $ban_reason = isset($this->ban_reason) ? trim($this->ban_reason) : "";
                if (isset($_POST[REQUEST_PARAM_NAME_BAN_SELECTED]) && ($_POST[REQUEST_PARAM_NAME_BAN_SELECTED] == 1)
                && method_exists($this, "get_by_id")) {

                  // есть ли IP-адрес в такой записи?
                  $this->get_by_id($record, $item);
                  if (!empty($record) && isset($record->ip)) $ban_ip = trim($record->ip);
                }

                // удаляем запись (если имеем сведения, помещаем IP-адрес в запреты доступа)
                $this->action_delete($item, $query, $ban_ip, $ban_reason);
              }
            }
            break;

          // если команду "Удалить запись"
          case ACTION_REQUEST_PARAM_VALUE_DELETE:
            $this->action_delete($id, $query);
            break;

          // если команду "Разрешить / запретить показ записи" (она не для таблиц feedback и callme)
          case ACTION_REQUEST_PARAM_VALUE_ENABLED:
            if (($this->dbtable != DATABASE_FEEDBACK_TABLENAME) && ($this->dbtable != "callme")) {
              $this->action_enabled($id, $query);
            }
            break;

          // если команду "Считать / не считать прочитанной записью" (она для таблицы feedback)
          case ACTION_REQUEST_PARAM_VALUE_NEW:
            if ($this->dbtable == DATABASE_FEEDBACK_TABLENAME) {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET new = 1 - new "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;

          // если команду "Считать / не считать выполненной записью" (она для таблицы callme)
          case ACTION_REQUEST_PARAM_VALUE_DONE:
            if ($this->dbtable == "callme") {
              $query[] = "UPDATE " . $this->dbtable . " "
                       . "SET done = 1 - done "
                       . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($id) . "';";
            }
            break;
        }

        // если получен набор запросов, то есть готовы выполнить операцию,
        //   проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную),
        //   делаем все запросы операции,
        //   если для команды не снято отслеживание изменений в базе данных, делаем его оценкой затронутых записей
        //   если страница возврата не указана, используем рекомендуемую страницу возврата
        if (!empty($query)) {
          $this->check_token();
          foreach ($query as &$command) $this->db->query($command);
          if ($watching) $this->changed = $this->changed || ($this->db->affected_rows() > 0);
          if (empty($result_page)) $result_page = trim($this->result_page);
        }
      }

      // обрабатываем редакторские изменения в записях (битовый OR использован для гарантии выполнения метода posting() независимо от настроек препроцессора)
      $cancel = $this->posting($result_page) | $cancel;

      // если не было отменено перенаправление и во входном параметре FROM была указана страница возврата, перенаправляем на нее
      if (!$cancel && !empty($result_page)) $this->security->redirectToPage($result_page);
    }

    // обработка редактирования записей ======================================

    protected function posting (&$result_page) {

      // ошибки здесь еще не было (пока не отменяем перенаправление на страницу возврата)
      $cancel = FALSE;

      // если получены данные об изменениях
      if (isset($_POST[REQUEST_PARAM_NAME_POST]) && is_array($_POST[REQUEST_PARAM_NAME_POST])) {

        // проверяем token-аутентичность вызова модуля (неаутентичных перенаправит на главную)
        $this->check_token();

        // цикл по измененным записям
        foreach ($_POST[REQUEST_PARAM_NAME_POST] as $id => $value) {
          if (!empty($id)) {
            $value = $this->dbtable_field;

            // начинаем исправление/добавление записи: берем содержимое полей записи, проверяя на ошибки
            $item = new stdClass;

            // для какой таблицы базы данных предназначена запись?
            switch ($this->dbtable) {
              case 'products_comments':
              case 'articles_comments':
              case 'news_comments':
              case DATABASE_FEEDBACK_TABLENAME:
                // поле идентификатора записи
                $item->$value = $id;
                // поле name (имя писавшего)
                $item->name = isset($_POST["name"][$id]) ? trim($_POST["name"][$id]) : ""; if ($item->name == "") $item->name = "Имя не указано";
                // поле message/comment (текст сообщения)
                $item->message = isset($_POST["message"][$id]) ? trim($_POST["message"][$id]) : ""; if ($item->message == "") $item->message = "...";
                $item->comment = & $item->message;
                // поле email (емейл писавшего)
                $item->email = isset($_POST["email"][$id]) ? strtolower(trim($_POST["email"][$id])) : "";
                // поле date (дата сообщения)
                if (isset($_POST['date'][$id])) {
                    $date = $this->date->fixDate($_POST['date'][$id]);
                    if ($date != '0000-00-00 00:00:00') $item->date = $date;
                }
                // обновляем запись в базе данных (битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора)
                $this->changed = ($this->update($item) != "") | $this->changed;

                // начинаем добавление ответа:
                // если поле ответа заполнено,
                //   устанавливаем содержимое полей новой записи,
                //   дополняем запись сведениями из дискуссии (одновременно получая емейлы дискутировавших),
                //   добавляем запись в базу данных (битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора),
                //   если запись добавилась (получила идентификатор), делаем рассылку уведомления дискутировавшим
                $item = new stdClass;
                // поле message/comment (текст сообщения)
                $item->message = isset($_POST["answer_message"][$id]) ? trim($_POST["answer_message"][$id]) : "";
                $item->comment = & $item->message;
                if ($item->message != '') {
                  // поле ip (ip-адрес писавшего)
                  $item->ip = $_SERVER["REMOTE_ADDR"];
                  // поле parent_id (идентификатор родительской ветки)
                  $item->parent_id = $id;
                  // поле date (дата и время сообщения)
                  if (isset($_POST['answer_date'][$id])) {
                      $date = $this->date->fixDate($_POST['answer_date'][$id]);
                      $item->date = $date != '0000-00-00 00:00:00' ? $date : time();
                  } else {
                      $item->date = time();
                  }
                  // поле name (имя писавшего)
                  $item->name = isset($_POST["answer_name"][$id]) ? trim($_POST["answer_name"][$id]) : ""; if ($item->name == "") $item->name = "Имя не указано";
                  // поле email (емейл писавшего)
                  $item->email = isset($_POST["answer_email"][$id]) ? strtolower(trim($_POST["answer_email"][$id])) : "";
                  // поле from_user (идентификатор писавшего пользователя)
                  $item->from_user = 0;
                  // поле enabled (разрешен ли к показу на сайте)
                  $item->enabled = 1;
                  // поле new (считать ли непрочитанным пользователем)
                  $item->new = 1;
                  $emails = $this->complement($item, $id);
                  // обновляем запись в базе данных (битовый OR использован для гарантии выполнения метода update() независимо от настроек препроцессора)
                  $this->changed = ($this->update($item) != "") | $this->changed;
                  if (isset($item->$value)) $this->mailing($item, $emails);
                }
                break;
            }
          }

          // если страница возврата не указана, используем рекомендуемую страницу
          if (empty($result_page)) $result_page = trim($this->result_page);
        }
      }

      // возвращаем была ли ошибка (нужно ли отменить перенаправление на страницу возврата)
      return $cancel;
    }

    // дополнение новой записи ===============================================

    private function complement (&$item, $parent_id) {

      // пошагово поднимаемся по записям ветви дискуссии к ее началу
      $emails = array();
      do {
        $query = "SELECT * "
               . "FROM " . $this->dbtable . " "
               . "WHERE " . $this->dbtable_field . " = '" . $this->db->query_value($parent_id) . "' "
               . "LIMIT 1;";
        $this->db->query($query);
        $record = $this->db->result();

        // если запись найдена (то есть у нее обнаружено специфичное поле)
        $parent_id = 0;
        if (isset($record->parent_id)) {
          $parent_id = @intval($record->parent_id);

          // если дискуссия привязана к товару, дополним новую запись
          if (isset($record->product_id)) {
            if (!isset($item->product_id)) $item->product_id = $record->product_id;
          }

          // если дискуссия привязана к статье, дополним новую запись
          if (isset($record->article_id)) {
            if (!isset($item->article_id)) $item->article_id = $record->article_id;
          }

          // если дискуссия привязана к новости, дополним новую запись
          if (isset($record->news_id)) {
            if (!isset($item->news_id)) $item->news_id = $record->news_id;
          }

          // берем емейл дискутирующего
          $email = isset($record->email) ? strtolower(trim($record->email)) : "";

          // если есть данные о зарегистрированном пользователе,
          //   дополняем новую запись,
          //   берем емейл пользователя, если не был указан в дискуссии
          if (isset($record->from_user)) {
            $user_id = @intval($record->from_user);
            if (empty($user_id)) {
              if (isset($record->to_user)) $user_id = @intval($record->to_user);
            }
            if (!isset($item->to_user)) $item->to_user = $user_id;
            if (empty($email) && !empty($user_id)) {
                $user = null;
                $params = new stdClass;
                $params->enabled = 1;
                $params->id = $user_id;
                $this->db->users->one($user, $params);
                if (!empty($user)) {
                    if (!empty($user->email)) $email = trim($user->email);
                    if (empty($email)) $email = trim($user->email2);
                }
            }
          }

          // если запись разрешена на сайте и емейл не принадлежит администратору
          // или публиканту и емейл еще еще не встречался,
          //   запомнить емейл в списке на рассылку уведомления
          if ((!isset($item->enabled) || $item->enabled)
          && !empty($email) && !in_array($email, $emails)
          && (!isset($item->email) || ($email != strtolower(trim($item->email))))
          && ($email != strtolower(trim($this->settings->admin_email)))
          && ($email != strtolower(trim($this->settings->notify_from_email)))) $emails[] = $email;
        }
      } while (!empty($parent_id));

      // возвращаем список емейлов на рассылку уведомления
      return $emails;
    }

    // рассылка уведомления дискутировавшим ==================================

    private function mailing (&$item, &$emails) {

      // преобразуем дату в читабельный вид,
      // передаем запись в шаблонизатор,
      // создаем текст письма,
      // делаем рассылку по перечисленным емейлам
      if (empty($emails)) return;
      $item->date = $this->date->readableDateTime($item->date);
      $this->smarty->assignByRef(SMARTY_VAR_EMAIL_POST, $item);
      $message = $this->smarty->fetch(EMAIL_POST_TO_USER_TEMPLATE_FILE);
      foreach ($emails as $email) $this->email($email, $item->date . " ответ в обсуждении на сайте " . $this->root_url, $message);
    }

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->feedback->update($item);
    }

    // сбор параметров html-формы ============================================

    protected function collect_inputs (&$inputs, &$params, &$defaults) {
      $inputs = array();
      $params = new stdClass;

      // собираем параметры сортировки (метод)
      $params->sort = $this->recognize_sort($defaults);
      $inputs[REQUEST_PARAM_NAME_SORT] = $params->sort;

      // собираем параметры сортировки (направление)
      $params->sort_direction = $this->recognize_sort_direction($defaults);
      $inputs[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;

      // собираем параметры сортировки (лаконичный режим)
      $params->sort_laconical = $this->recognize_sort_laconical($defaults);
      $inputs[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;

      // собираем параметры фильтра (ручной запуск)
      $params->filter_manually = $this->recognize_filter_manually($defaults);
      $inputs[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;

      // собираем параметры фильтра (завершена)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_DONE])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_DONE]);
        if ($value != "") $params->done = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_DONE] = $value;
      }

      // собираем параметры фильтра (искомая строка)
      if (isset($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCH])) {
        $value = trim($_REQUEST[REQUEST_PARAM_NAME_FILTER_SEARCH]);
        if ($value != "") $params->search = $value;
        $inputs[REQUEST_PARAM_NAME_FILTER_SEARCH] = $value;
      }

      // собираем параметры фильтра (аутентификатор операции)
      $inputs[REQUEST_PARAM_NAME_TOKEN] = $this->token;
    }

    // передача данных шаблонизатору Smarty ==================================

    protected function assign (&$items, $count) {
      $current_page = @intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $start_item = $current_page * $this->items_per_page;
      $items = array_slice($items, $start_item, $this->items_per_page);
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
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

        // обрабатываем входные команды,
        // устанавливаем заголовок страницы,
        $this->process();
        $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Обратная связь';

        // получаем записи обратной связи
        $filter = new stdClass;
        $filter->find = $this->param('keyword');
        $filter->operator = $this;
        $items = null;
        $count = $this->db->feedback->get($items, $filter);
        $this->db->feedback->unpackRecords($items);

        // передаем данные в шаблонизатор,
        // создаем контент модуля
        $this->assign($items, $count);
        $this->body = $this->smarty->fetch('admin_feedback.htm');
    }
  }

  // =========================================================================
  // Класс Comments (админ модуль отзывов о товарах)
  // =========================================================================

  class Comments extends Feedback {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    protected $dbtable = "products_comments";
    protected $dbtable_field = "comment_id";

    // сколько максимум элементов (строк) на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_COMMENTS_ON_PAGE_IN_ADMIN;

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_comment($item);
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

      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Отзывы о товарах";

      // получаем записи отзывов о товарах на текущей странице
      $params = new stdClass;
      $current_page = @intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $params->find = $this->param(REQUEST_PARAM_NAME_KEYWORD);
      $params->reverse = 1;
      $count = $this->db->get_comments($items, $params);

      // создаем контент листания страниц
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи отзывов оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_comments($items, $params);

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->body = $this->smarty->fetch(ADMIN_COMMENTS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс AComments (админ модуль комментариев к статьям)
  // =========================================================================

  class AComments extends Feedback {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    protected $dbtable = "articles_comments";
    protected $dbtable_field = "comment_id";

    // сколько максимум элементов (строк) на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_ARTICLESCOMMENTS_ON_PAGE_IN_ADMIN;

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_acomment($item);
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

      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Комментарии к статьям";

      // получаем записи комментариев к статьям на текущей странице
      $params = new stdClass;
      $current_page = @intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $params->find = $this->param(REQUEST_PARAM_NAME_KEYWORD);
      $params->reverse = 1;
      $count = $this->db->get_acomments($items, $params, $temp);

      // создаем контент листания страниц
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи комментариев оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_acomments($items, $params);

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->body = $this->smarty->fetch(ADMIN_ACOMMENTS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс NComments (админ модуль комментариев к новостям)
  // =========================================================================

  class NComments extends Feedback {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    protected $dbtable = "news_comments";
    protected $dbtable_field = "comment_id";

    // сколько максимум элементов (строк) на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_NEWSCOMMENTS_ON_PAGE_IN_ADMIN;

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->update_ncomment($item);
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

      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . "Комментарии к новостям";

      // получаем записи комментариев к новостям на текущей странице
      $params = new stdClass;
      $current_page = @intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $params->find = $this->param(REQUEST_PARAM_NAME_KEYWORD);
      $params->reverse = 1;
      $count = $this->db->get_ncomments($items, $params, $temp);

      // создаем контент листания страниц
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи комментариев оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->operable_ncomments($items, $params);

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ADMIN_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->body = $this->smarty->fetch(ADMIN_NCOMMENTS_CLASS_TEMPLATE_FILE);
    }
  }

  // =========================================================================
  // Класс CallMe (админ модуль запросов связи)
  // =========================================================================

  class CallMe extends Feedback {

    // с какой таблицей базы данных работаем,
    // какое поле таблицы является идентификатором записей
    protected $dbtable = "callme";
    protected $dbtable_field = "callme_id";

    // текст заметки о причине помещения в запреты доступа
    protected $ban_reason = "Заблокирован администратором в результате удаления со страницы запросов связи \"Позвоните мне\".";

    // сколько максимум элементов (строк) на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_CALLME_ON_PAGE_IN_ADMIN;

    // обновление записи в базе данных =======================================

    protected function update (&$item) {

      // приказываем объекту базы данных обновить/добавить указанную запись
      return $this->db->callme->update($item);
    }

    // чтение записи из базы данных по идентификатору ========================

    protected function get_by_id (&$item, $id) {

        // читаем нужную запись
        $item = null;
        $params = new stdClass;
        $params->ids = $id;
        $params->start = 0;
        $params->maxcount = 1;
        $this->db->callme->get($item, $params);
        if (!empty($item) && isset($item[$id])) {
            $item = $item[$id];
        } else {
            $item = null;
        }
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

      // задаем значения по умолчанию некоторых элементов html-формы
      $defaults = new stdClass;
      $defaults->param = CALLME_SESSION_PARAM_NAME;
      $defaults->sort = SORT_CALLME_MODE_AS_IS;
      $defaults->sort_direction = SORT_DIRECTION_DESCENDING;
      $defaults->sort_laconical = 1;
      $defaults->filter_manually = 0;

      // обрабатываем входные команды,
      // устанавливаем заголовок страницы
      $this->process();
      $this->title = ADMIN_PAGE_TITLE_PREFIX . 'Запросы связи "Позвоните мне"';

      // читаем в $params параметры сортировки и фильтра ($inputs примет значения некоторых элементов html-формы)
      $inputs = null;
      $params = null;
      $this->collect_inputs($inputs, $params, $defaults);

      // получаем записи запросов связи на текущей странице
      $items = null;
      $current_page = @intval($this->param(REQUEST_PARAM_NAME_PAGE));
      $params->start = $current_page * $this->items_per_page;
      $params->maxcount = $this->items_per_page;
      $count = $this->db->callme->get($items, $params);

      // создаем контент листания страниц
      if (isset($params->sort)) $this->params[REQUEST_PARAM_NAME_SORT] = $params->sort;
      if (isset($params->sort_direction)) $this->params[REQUEST_PARAM_NAME_SORT_DIRECTION] = $params->sort_direction;
      if (isset($params->sort_laconical)) $this->params[REQUEST_PARAM_NAME_SORT_LACONICAL] = $params->sort_laconical;
      if (isset($params->filter_manually)) $this->params[REQUEST_PARAM_NAME_FILTER_MANUALLY] = $params->filter_manually;
      if (isset($params->done)) $this->params[REQUEST_PARAM_NAME_FILTER_DONE] = $params->done;
      if (isset($params->search)) $this->params[REQUEST_PARAM_NAME_FILTER_SEARCH] = $params->search;
      $pages_num = $count / $this->items_per_page;
      $navigator = new PagesNavigation($this);
      $navigator->make($pages_num, $count);

      // добавляем в записи запросов оперативные ссылки админпанели
      $params->token = $this->token;
      $this->db->callme->operable($items, $params);

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $items);
      $this->smarty->assignByRef(SMARTY_VAR_FORM_INPUTS_VALUES, $inputs);
      $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_CONTENT, $navigator->body);
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->body = $this->smarty->fetch(ADMIN_CALLME_CLASS_TEMPLATE_FILE);
    }
  }



  return;
?>