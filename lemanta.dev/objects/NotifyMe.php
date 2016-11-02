<?php
  // Impera CMS: модуль подключения к уведомлению на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT);

  // какой файл является шаблоном подключения к уведомлению на клиентской стороне (указываем без расширения)
  define("CLIENT_NOTIFYME_CLASS_TEMPLATE_FILE", "page.notifyme");

  // какой файл является шаблоном уведомления на подтверждение емейла
  define("EMAIL_NOTIFYME_CONFIRM_TEMPLATE_FILE", "email_notifyme_confirm.htm");

  // =========================================================================
  // Класс ClientNotifyMe (модуль подключения к уведомлению на клиентской стороне)
  //
  // Использование этого класса происходит в результате переназначения класса
  // NotifyMe на данный класс во время загрузки модуля подключения к уведомлению.
  // =========================================================================

  class ClientNotifyMe extends Basic {

    // предполагаем, контент модуля интегрируется во внешнее оформление страницы
    public $single = FALSE;

    // обработка редактирования подключения к уведомлению ====================

    private function posting () {

      // ошибки здесь еще не было
      $cancel = FALSE;

      // переключаем модуль в нужный режим вывода контента (с внешним оформлением страницы или без)
      $this->single = isset($_REQUEST[REQUEST_PARAM_NAME_NOTIFY_TYPE]);

      // читаем входные параметры html-формы
      $item = new stdClass;
      $item->type = strtolower(trim(strip_tags($this->param(REQUEST_PARAM_NAME_NOTIFY_TYPE))));
      $item->email = trim(strip_tags($this->param("post_email")));
      $item->phone = trim(strip_tags($this->param("post_phone")));
      $item->icq = trim(strip_tags($this->param("post_icq")));
      $item->skype = trim(strip_tags($this->param("post_skype")));

      // если получены данные об изменениях
      if (isset($_POST["post_submit"]) && ($_POST["post_submit"] != "")) {

        // берем IP-адрес пользователя ($client_host примет имя хоста, если оно доступно)
        $client_ip = $this->security->getVisitorIp();
        $client_host = $this->security->getVisitorHost();

        // проверяем наличие неотмененного запрета доступа к запросу связи для такого IP-адреса (включив проверку даты действия запрета)
        $params = new stdClass;
        $params->ip = $client_ip;
        $params->enabled = 1;
        $params->no_callme = 1;
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

          // проверяем емейл (обязателен), телефон, ICQ, скайп
          $item->user_id = empty($this->user) ? 0 : $this->user->user_id;
          if ($item->email == "") {
            $cancel = $this->push_error("Нужно указать емейл!");
          } else {
            if (!preg_match(EMAIL_CHECKING_PATTERN, $item->email)) $cancel = $this->push_error("Емейл должен быть указан в общепринятом формате!");
            if (($item->phone != "") && !preg_match(PHONE_CHECKING_PATTERN, $item->phone)) $cancel = $this->push_error("Телефон должен быть указан в общепринятом формате!");
            if (($item->icq != "") && !preg_match(ICQ_CHECKING_PATTERN, $item->icq)) $cancel = $this->push_error("Номер ICQ должен быть указан в общепринятом формате!");
            if (($item->skype != "") && !preg_match(SKYPE_CHECKING_PATTERN, $item->skype)) $cancel = $this->push_error("Skype имя должно быть указано в общепринятом формате!");
          }

          // проверяем тип уведомления
          $item->object_id = intval($this->param(REQUEST_PARAM_NAME_OBJECT_ID));
          $item->variant_id = intval($this->param(REQUEST_PARAM_NAME_VARIANT_ID));
          switch ($item->type) {
            case NOTIFY_TYPE_REQUEST_PARAM_VALUE_EXIST:
            case NOTIFY_TYPE_REQUEST_PARAM_VALUE_PRODUCT:
              if (empty($item->object_id)) {
                $cancel = $this->push_error("Не указан отслеживаемый товар!");
              } elseif (empty($item->variant_id)) $cancel = $this->push_error("Не указан вариант отслеживаемого товара!");
              break;
            case NOTIFY_TYPE_REQUEST_PARAM_VALUE_NEWSITEM:
              if (empty($item->object_id)) $cancel = $this->push_error("Не указана отслеживаемая новость!");
              $item->variant_id = 0;
              break;
            case NOTIFY_TYPE_REQUEST_PARAM_VALUE_ARTICLE:
              if (empty($item->object_id)) $cancel = $this->push_error("Не указана отслеживаемая статья!");
              $item->variant_id = 0;
              break;
            case NOTIFY_TYPE_REQUEST_PARAM_VALUE_USER:
              if (empty($item->object_id)) $cancel = $this->push_error("Не указан отслеживаемый пользователь!");
              $item->variant_id = 0;
              break;
            case NOTIFY_TYPE_REQUEST_PARAM_VALUE_ALL:
              $item->object_id = 0;
              $item->variant_id = 0;
              break;
            default:
              $cancel = $this->push_error("Неизвестный тип уведомления!");
          }
        }

        // если нет запрета доступа и ошибок в параметрах
        if (!$cancel) {

          // проверям лимит времени на подключения к уведомлениям
          $param_name = "notifies_next_time";
          $item->created = time();
          if (isset($_SESSION[$param_name]) && ($_SESSION[$param_name] > $item->created)) {
            $cancel = $this->push_error("У вас нет прав делать заявки на уведомления слишком часто! Попробуйте через " . @intval($_SESSION[$param_name] - $item->created) . " секунд.");
          } else {

            // если правильно введен защитный код
            if ($this->security->checkCaptcha()) {

              // проверяем, есть ли такая запись в базе данных
              $params = new stdClass;
              $params->type = $item->type;
              if (!empty($item->object_id)) $params->object_id = $item->object_id;
              if (!empty($item->variant_id)) $params->variant_id = $item->variant_id;
              $params->email = $item->email;
              $params->done = 0;
              $this->db->get_notify($row, $params);
              if (!empty($row)) {

                // информационное сообщение заявителю
                if (trim($row->remote_token) != "") {
                  $this->message = "Ваша заявка уже была принята. Проверьте свой почтовый ящик для ее подтверждения.";
                } else {
                  $this->message = "Ваша заявка уже была принята.";
                }

              // иначе такой записи еще нет в базе данных
              } else {

                // проверяем, подтверждался ли такой емейл когда-нибудь
                $params = new stdClass;
                $params->type = "*";
                $params->email = $item->email;
                $params->remote_token = "";
                $this->db->get_notify($row, $params);
                if (!empty($row)) {
                  $item->remote_token = "";

                // иначе такой емейл еще ни разу не подтверждался
                } else {

                  // генерируем аутентификатор удаленного действия (блокируя обновления на 10 минут)
                  $item->remote_token = "NMM" . substr(date("YmdHi", time()), 0, 11) . "-";
                  for ($i = 1; $i <= 64; $i++) {
                    $code = rand(0, 10 + 26 + 26 - 1);
                    if ($code < 10) $item->remote_token .= $code;
                    elseif ($code < 10 + 26) $item->remote_token .= chr(ord('A') - 10 + $code);
                    else $item->remote_token .= chr(ord('a') - 10 - 26 + $code);
                  }
                }

                // передаем подключение к уведомлению в базу данных
                $item->ip = $client_ip;
                $item->host = $client_host;
                $item->enabled = 1;
                $item->done = 0;
                $item->notify_id = $this->db->update_notify($item);

                // если нужно отправить письмо на подтверждение емейла
                if ($item->remote_token != "") {
                  $client_tpl_path = ROOT_FOLDER_REFERENCE . "design/" . $this->dynamic_theme . "/html/";
                  $filename = EMAIL_NOTIFYME_CONFIRM_TEMPLATE_FILE;
                  if (@file_exists($client_tpl_path . $filename)) {
                    $subject = "Подтвердите свою заявку подключения к уведомлению на сайте http://" . $this->root_url;
                    $this->smarty->assignByRef(SMARTY_VAR_ITEM, $item);
                    $message = $this->smarty->fetch($filename);
                    $this->email($item->email, $subject, $message);

                  // иначе шаблона письма нет, подключаем без подтверждения
                  } else {
                    $item->remote_token = "";
                    $this->db->update_notify($item);
                  }
                }

                // информационное сообщение заявителю
                if ($item->remote_token != "") {
                  $this->message = "Спасибо! Ваша заявка подключения к уведомлению принята. Проверьте свой почтовый ящик для ее подтверждения.";
                } else {
                  $this->message = "Спасибо! Ваша заявка подключения к уведомлению принята.";
                }

                // установить странице фоновый звук УСПЕХ
                $this->success_bgsound();

                // засекаем новый лимит времени на подключение к уведомлению
                $_SESSION[$param_name] = time() + abs(intval(POST_NEXT_NOTIFYME_LIFETIME));
              }

            } else {
              $cancel = $this->push_error("Введите правильный защитный код с картинки.");
            }
          }

          // если прошло удачно, очищаем параметры для html-формы
          if (!$cancel) {
            $item->phone = "";
            $item->email = "";
            $item->icq = "";
            $item->skype = "";
          }
        }

      // иначе данные об изменениях не получены
      } else {

        // если модуль выводит контент без внешнего оформления страницы
        $item = null;
        if ($this->single) {
          $cancel = $this->push_error("Не получены данные о подключении к уведомлению.");

        // иначе это прямой вызов страницы
        } else {

          // возможно это подтверждающий вызов из письма (то есть содержит аутентификатор удаленного действия)
          $token = isset($_GET[REQUEST_PARAM_NAME_TOKEN]) && isset($_GET["email"]) ? $this->text->stripTags($_GET[REQUEST_PARAM_NAME_TOKEN], TRUE) : "";
          if ($token != "") {

            // берем емейл из GET-запроса
            $this->get_POST_person_email($item, $_GET);
            if ($item->email != "") {

              // пытаемся прочитать запись с таким емейлом и аутентификатором удаленного действия
              $params = new stdClass;
              $params->type = "*";
              $params->email = $item->email;
              $params->remote_token = $token;
              $this->db->get_notify($row, $params);

              // если запись не найдена
              if (empty($row)) {
                 $cancel = $this->push_error("Недействительная или устаревшая подтверждающая ссылка.");

              // иначе запись найдена
              } else {

                // подтверждаем сразу все записи с таким емейлом
                $query = "UPDATE " . DATABASE_NOTIFIES_TABLENAME . " "
                       . "SET remote_token = '' "
                       . "WHERE email = '" . $this->db->query_value($item->email) . "';";
                $this->db->query($query);
              }

            } else {
              $cancel = $this->push_error("Недействительная подтверждающая ссылка.");
            }

          } else {
            $cancel = $this->push_error("Недействительная подтверждающая ссылка.");
          }
        }

        // передаем данные в шаблонизатор
        $this->smarty->assignByRef(SMARTY_VAR_ITEM, $item);
      }

      // возвращаем в html-форму принятые от нее параметры
      $block_id = $this->param("post_block_id");
      $this->smarty->assignByRef("post_block_id", $block_id);
      $this->smarty->assign("post_phone", !isset($item->phone) || ($item->phone == "") ? (empty($this->user) ? "" : ((trim($this->user->phone) != "") ? $this->user->phone : $this->user->phone2)) : $item->phone);
      $this->smarty->assign("post_email", !isset($item->email) || ($item->email == "") ? (empty($this->user) ? "" : ((trim($this->user->email) != "") ? $this->user->email : $this->user->email2)) : $item->email);
      $this->smarty->assign("post_icq", isset($item->icq) ? $item->icq : "");
      $this->smarty->assign("post_skype", isset($item->skype) ? $item->skype : "");

      // возвращаем была ли ошибка
      return $cancel;
    }

    // создание контента модуля ==============================================

    public function fetch (&$parent = null) {

      // обрабатываем редактирование подключения к уведомлению
      $this->posting();

      // устанавливаем мета информацию страницы
      $this->title = 'Уведомить меня';

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef('quick_content', $this->single);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->message);
      $this->smarty->fetchByTemplate($this, CLIENT_NOTIFYME_CLASS_TEMPLATE_FILE, 'notifyme');

      // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
      return TRUE;
    }
  }



  return;
?>