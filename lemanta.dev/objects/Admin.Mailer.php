<?php
  if (defined("ROOT_FOLDER_REFERENCE") == FALSE) return;
  if (defined("FOLDERNAME_FOR_ENGINE_OBJECTS") == FALSE) return;
  if (defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT") == FALSE) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);

  define("REMOTE_FILE_OPENING_TIMEOUT", 5);
  define("MALFUNCTION_TIMEOUT", 10);

  define("EMAIL_SEND_LIMIT_MINVALUE", 1);
  define("EMAIL_SEND_LIMIT_DEFAULTVALUE", 20);
  define("EMAIL_SEND_LIMIT_MAXVALUE", 1000);

  define("EMAIL_SEND_TIMER_MINVALUE", 0);
  define("EMAIL_SEND_TIMER_DEFAULTVALUE", 0);
  define("EMAIL_SEND_TIMER_MAXVALUE", 30);

  define("EMAIL_SEND_RESTARTER_STOPVALUE", 0);
  define("EMAIL_SEND_RESTARTER_MINVALUE", 10);
  define("EMAIL_SEND_RESTARTER_DEFAULTVALUE", 30);
  define("EMAIL_SEND_RESTARTER_MAXVALUE", 300);

  define("EMAIL_SEND_COPIESA_MINVALUE", 1);
  define("EMAIL_SEND_COPIESA_DEFAULTVALUE", 1);
  define("EMAIL_SEND_COPIESA_MAXVALUE", 20);

  define("EMAIL_SEND_COPIESH_MINVALUE", 0);
  define("EMAIL_SEND_COPIESH_DEFAULTVALUE", 0);
  define("EMAIL_SEND_COPIESH_MAXVALUE", 20);

  define("EMAIL_SEND_SMTP_DEFAULTVALUE", "smtp.rambler.ru");
  define("EMAIL_SEND_SMTPPORT_DEFAULTVALUE", 587);
  define("EMAIL_SEND_SMTPADJACENT_MINVALUE", 1);
  define("EMAIL_SEND_SMTPADJACENT_DEFAULTVALUE", 1);
  define("EMAIL_SEND_SMTPADJACENT_MAXVALUE", 50);

  define("WORKS_VIA_PROXY_SERVER", "");
  define("WORKS_VIA_PROXY_PORT", "");

  define("EMAILING_BASE_FILENAME", "temp/maillist.txt");
  define("EMAILING_REJECTS_FILENAME", "temp/mail_del.txt");
  define("EMAILING_ECHO_FILENAME", "temp/mail_echo.txt");
  define("EMAILING_LISTING_FILENAME", "temp/mail_listing.txt");
  define("EMAILING_STOPCOMMAND_FILENAME", "temp/mail_stop.txt");
  define("EMAILING_CONTENT_FILENAME", "temp/text*.txt");
  define("EMAILING_ABSTRACTTEXT_FILENAME", "temp/text_abstract.txt");
  define("EMAILING_NOWREJECTED_FILENAME", "temp/now_rejected.txt");
  define("EMAILING_NOWMAILED_FILENAME", "temp/now_mailed.txt");

  define("EMAILING_BASE_SELF_ERASING", TRUE);
  define("EMAILING_REJECTS_SCRIPTADDRESS", "");
  define("EMAILING_REJECTS_TEXT", "");

  define("EMAILING_SENDER_ADDRESS", "");
  define("EMAILING_SENDER_REPLY", "");
  define("EMAILING_SENDER_PSEUDONAME", "");

  define("EMAILING_VIA_SERVER", FALSE);
  define("EMAILING_VIA_SERVER_NAME", EMAIL_SEND_SMTP_DEFAULTVALUE);
  define("EMAILING_VIA_SERVER_PORT", EMAIL_SEND_SMTPPORT_DEFAULTVALUE);
  define("EMAILING_VIA_SERVER_LOGIN", "");
  define("EMAILING_VIA_SERVER_LOGIN_COUNT", 1);
  define("EMAILING_VIA_SERVER_PASSWORD", "");

  define("EMAILING_PAUSE_IN_SECONDS", 0);
  define("EMAILING_PAUSE_FLUCTUATION_PERCENT", 0);
  define("EMAILINNG_ADDRESSED_COPIES_IN_LETTER", 1);
  define("EMAILINNG_HIDDEN_COPIES_IN_LETTER", 0);
  define("EMAILING_CONTROL_STEP", 35000);
  define("EMAILING_CONTINUE_STEP", 1);
  define("EMAILING_CONTINUE_PAUSE", 30);

  define("EMAILING_ANTISPAM_ACTION", FALSE);
  define("EMAILING_ANTISPAM_SUBJECT", FALSE);
  define("EMAILING_ADDRESSES_RANDOM_SELECTION", TRUE);

  define("MAILER_OPEN_PASSWORD", "");

  define("EMAIL_INSERTION_MARKER", "{email}");
  define("EMAILLOGIN_INSERTION_MARKER", "{email_login}");
  define("EMAILUSERNAME_INSERTION_MARKER", "{email_username}");
  define("EMAILUSERBIRTHDAY_INSERTION_MARKER", "{email_userbirthday}");
  define("EMAILUSERCOUNTRY_INSERTION_MARKER", "{email_usercountry}");
  define("EMAILUSERTOWN_INSERTION_MARKER", "{email_usertown}");
  define("EMAILUSERNAME_INSERTION_MAXSIZE", 80);

  define("EMAILING_NOT_IDEAL_CHEAT_ANTISPAM_MARKER", "{not_ideal_cheat_antispam}");
  define("EMAILING_DONT_TAGING_ANTISPAM_MARKER", "{dont_taging_antispam}");
  define("EMAILING_DONT_ABSTRACTING_MARKER", "{dont_abstracting}");
  define("EMAILING_SEND_USER_IP_MARKER", "{send_user_ip}");

  define("MAIL_RECORD_FIELDS_DIVIDER", "|");
  define("field_MailAddress", 0);
  define("field_MailUserName", field_MailAddress + 1);
  define("field_MailUserSex", field_MailUserName + 1);
  define("field_MailUserBirthday", field_MailUserSex + 1);
  define("field_MailUserCountry", field_MailUserBirthday + 1);
  define("field_MailUserTown", field_MailUserCountry + 1);

  define("MAILER_INTEGRATED_IN_PAGE", TRUE);
  define("MAILER_INVISIBLE_MODE", TRUE);
  define("MAILER_VIA_FILES_MODE", FALSE);

  class Mailer extends Basic {
    var $error = "";
    var $message = "";

    var $finished_count;
    var $finished_error_count;
    var $continue_index;
    var $continue_step;
    var $continue_pause;
    var $control_step;
    var $control_step_index;
    var $self_erase_option;
    var $contra_antispam_action_option;
    var $contra_antispam_subject_option;
    var $fromemail;
    var $replyemail;
    var $mail_via_server_option;
    var $mail_via_server;
    var $mail_via_server_name;
    var $mail_via_server_port;
    var $mail_via_server_login;
    var $mail_via_server_login_count;
    var $mail_via_server_login_number;
    var $mail_via_server_password;
    var $mailing_pause;
    var $mailing_addressed_copies;
    var $mailing_hidden_copies;
    var $contra_antispam_action;
    var $contra_antispam_subject;
    var $text_jpegs;
    var $user_ip;
    var $send_client_ip_enable;
    var $subject;
    var $email_body;
    var $control_mail;
    var $script_addr;
    var $pass;
    var $emailing_random_selection;
    var $emailing_control_address;



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

            if (isset($_POST['mailer_operation']) && ($_POST['mailer_operation'] == 'send')) {
                $this->mailer_start();
            } else {
                $this->prepare();
            }
        }



    function prepare() {
      $email_sender = trim(strip_tags($this->param("email_sender")));
      $email_sender_pseudo = trim(strip_tags($this->param("email_sender_pseudo")));
      if ($email_sender == "") $email_sender = isset($this->settings->admin_email) ? trim($this->settings->admin_email) : '';
      if (($email_sender_pseudo == "") && (isset($_REQUEST["email_sender_pseudo"]) == FALSE)) $email_sender_pseudo = isset($this->settings->notify_from_email) ? trim($this->settings->notify_from_email) : '';
      $email_send_limit = trim(strip_tags($this->param("email_send_limit")));
      if ($email_send_limit == "") {
        $email_send_limit = EMAIL_SEND_LIMIT_DEFAULTVALUE;
      } else {
        $email_send_limit = @intval($email_send_limit);
      }
      if ($email_send_limit < EMAIL_SEND_LIMIT_MINVALUE) {
        $email_send_limit = EMAIL_SEND_LIMIT_MINVALUE;
      } else {
        if ($email_send_limit > EMAIL_SEND_LIMIT_MAXVALUE) $email_send_limit = EMAIL_SEND_LIMIT_MAXVALUE;
      }
      $email_send_timer = trim(strip_tags($this->param("email_send_timer")));
      if ($email_send_timer == "") {
        $email_send_timer = EMAIL_SEND_TIMER_DEFAULTVALUE;
      } else {
        $email_send_timer = @intval($email_send_timer);
      }
      if ($email_send_timer < EMAIL_SEND_TIMER_MINVALUE) {
        $email_send_timer = EMAIL_SEND_TIMER_MINVALUE;
      } else {
        if ($email_send_timer > EMAIL_SEND_TIMER_MAXVALUE) $email_send_timer = EMAIL_SEND_TIMER_MAXVALUE;
      }
      $email_send_restarter = trim(strip_tags($this->param("email_send_restarter")));
      if ($email_send_restarter == "") {
        $email_send_restarter = EMAIL_SEND_RESTARTER_DEFAULTVALUE;
      } else {
        $email_send_restarter = @intval($email_send_restarter);
      }
      if ($email_send_restarter < EMAIL_SEND_RESTARTER_MINVALUE) {
        $email_send_restarter = EMAIL_SEND_RESTARTER_STOPVALUE;
      } else {
        if ($email_send_restarter > EMAIL_SEND_RESTARTER_MAXVALUE) $email_send_restarter = EMAIL_SEND_RESTARTER_MAXVALUE;
      }
      $email_send_personalize = 0;
      if ((isset($_REQUEST["email_send_personalize"]) == TRUE) && ($_REQUEST["email_send_personalize"] == 1)) $email_send_personalize = 1;
      $email_send_pseudochars = 0;
      if ((isset($_REQUEST["email_send_pseudochars"]) == TRUE) && ($_REQUEST["email_send_pseudochars"] == 1)) $email_send_pseudochars = 1;
      $email_send_copies_a = trim(strip_tags($this->param("email_send_copies_a")));
      if ($email_send_copies_a == "") {
        $email_send_copies_a = EMAIL_SEND_COPIESA_DEFAULTVALUE;
      } else {
        $email_send_copies_a = @intval($email_send_copies_a);
      }
      if ($email_send_copies_a < EMAIL_SEND_COPIESA_MINVALUE) {
        $email_send_copies_a = EMAIL_SEND_COPIESA_MINVALUE;
      } else {
        if ($email_send_copies_a > EMAIL_SEND_COPIESA_MAXVALUE) $email_send_copies_a = EMAIL_SEND_COPIESA_MAXVALUE;
      }
      $email_send_copies_h = trim(strip_tags($this->param("email_send_copies_h")));
      if ($email_send_copies_h == "") {
        $email_send_copies_h = EMAIL_SEND_COPIESH_DEFAULTVALUE;
      } else {
        $email_send_copies_h = @intval($email_send_copies_h);
      }
      if ($email_send_copies_h < EMAIL_SEND_COPIESH_MINVALUE) {
        $email_send_copies_h = EMAIL_SEND_COPIESH_MINVALUE;
      } else {
        if ($email_send_copies_h > EMAIL_SEND_COPIESH_MAXVALUE) $email_send_copies_h = EMAIL_SEND_COPIESH_MAXVALUE;
      }
      $email_send_smtp_adjacent = trim(strip_tags($this->param("email_send_smtp_adjacent")));
      if ($email_send_smtp_adjacent == "") {
        $email_send_smtp_adjacent = EMAIL_SEND_SMTPADJACENT_DEFAULTVALUE;
      } else {
        $email_send_smtp_adjacent = @intval($email_send_smtp_adjacent);
      }
      if ($email_send_smtp_adjacent < EMAIL_SEND_SMTPADJACENT_MINVALUE) {
        $email_send_smtp_adjacent = EMAIL_SEND_SMTPADJACENT_MINVALUE;
      } else {
        if ($email_send_smtp_adjacent > EMAIL_SEND_SMTPADJACENT_MAXVALUE) $email_send_smtp_adjacent = EMAIL_SEND_SMTPADJACENT_MAXVALUE;
      }
      $email_send_random = 0;
      if ((isset($_REQUEST["email_send_random"]) == TRUE) && ($_REQUEST["email_send_random"] == 1)) $email_send_random = 1;
      $email_send_via_smtp = 0;
      if ((isset($_REQUEST["email_send_via_smtp"]) == TRUE) && ($_REQUEST["email_send_via_smtp"] == 1)) $email_send_via_smtp = 1;
      $email_send_smtp = trim(strip_tags($this->param("email_send_smtp")));
      if ($email_send_smtp == "") $email_send_smtp = EMAIL_SEND_SMTP_DEFAULTVALUE;
      $email_send_smtp_port = trim(strip_tags($this->param("email_send_smtp_port")));
      if ($email_send_smtp_port == "") {
        $email_send_smtp_port = EMAIL_SEND_SMTPPORT_DEFAULTVALUE;
      } else {
        $email_send_smtp_port = @intval($email_send_smtp_port);
      }
      if ($email_send_smtp_port < 0) $email_send_smtp_port = 0;
      if ($email_send_smtp_port > 65535) $email_send_smtp_port = 65535;
      $email_send_smtp_login = trim(strip_tags($this->param("email_send_smtp_login")));
      $email_send_smtp_pass = $this->param("email_send_smtp_pass");
      $email_tpl_subject = trim(strip_tags($this->param("email_tpl_subject")));
      $email_tpl_src = trim(strip_tags($this->param("email_tpl_src")));
      $email_tpl_body = trim($this->param("email_tpl_body"));
      $email_tpl_name = trim(strip_tags($this->param("email_tpl_name")));
      $email_list_src = trim(strip_tags($this->param("email_list_src")));
      $email_list_body = trim($this->param("email_list_body"));
      $email_list_name = trim(strip_tags($this->param("email_list_name")));
      if ((isset($_POST["email_tpl_delete"]) == TRUE) && ($_POST["email_tpl_delete"] == "1")) {
        if ($email_tpl_src != "") {
          if ($this->delete_mailer_template($email_tpl_src, $tpl_name) == TRUE) {
            $this->message = "Шаблон \"" . $tpl_name . "\" удалён.";
          } else {
            $this->error = "Не удалось удалить указанный шаблон письма.";
          }
        } else {
          $this->error = "Не выбран шаблон, который требуется удалить.";
        }
      } else {
        if (isset($_POST["email_tpl_load"]) == TRUE) {
          if ($email_tpl_src != "") {
            if ($this->get_mailer_template($email_tpl_src, $tpl_name, $tpl_subject, $tpl_body) == TRUE) {
              $email_tpl_name = $tpl_name;
              $email_tpl_subject = $tpl_subject;
              $email_tpl_body = $tpl_body;
              $this->message = "Шаблон \"" . $email_tpl_name . "\" загружен.";
            } else {
              $this->error = "Не удалось загрузить указанный шаблон письма.";
            }
          } else {
            $this->error = "Не выбран шаблон письма, который требуется загрузить в редактор.";
          }
        } else {
          if (isset($_POST["email_tpl_save"]) == TRUE) {
            if ($email_tpl_name != "") {
              if ($email_tpl_subject != "") {
                if ($email_tpl_body != "") {
                  if ($this->store_mailer_template($tpl_src, $email_tpl_name, $email_tpl_subject, $email_tpl_body) == TRUE) {
                    $email_tpl_src = $tpl_src;
                    $this->message = "Шаблон \"" . $email_tpl_name . "\" сохранён.";
                  } else {
                    if ($tpl_src == 0) {
                      $this->error = "Не удалось сохранить этот шаблон письма, так как вы исчерпали лимит на количество шаблонов.";
                    } else {
                      $this->error = "Не удалось сохранить этот шаблон письма по технической причине.";
                    }
                  }
                } else {
                  $this->error = "Не введён текст письма в сохраняемом шаблоне.";
                }
              } else {
                $this->error = "Не введена тема письма в сохраняемом шаблоне.";
              }
            } else {
              $this->error = "Не указано имя сохраняемого шаблона.";
            }
          } else {
            if ((isset($_POST["email_list_delete"]) == TRUE) && ($_POST["email_list_delete"] == "1")) {
              if ($email_list_src != "") {
                if ($this->delete_mailer_maillist($email_list_src, $list_name) == TRUE) {
                  $this->message = "Список емейлов \"" . $list_name . "\" удалён.";
                } else {
                  $this->error = "Не удалось удалить указанный список емейлов.";
                }
              } else {
                $this->error = "Не выбран список емейлов, который требуется удалить.";
              }
            } else {
              if (isset($_POST["email_list_load"]) == TRUE) {
                if ($email_list_src != "") {
                  if ($this->get_mailer_maillist($email_list_src, $list_name, $list_body) == TRUE) {
                    $email_list_name = $list_name;
                    $email_list_body = $list_body;
                    $this->message = "Список емейлов \"" . $email_list_name . "\" загружен.";
                  } else {
                    $this->error = "Не удалось загрузить указанный список емейлов.";
                  }
                } else {
                  $this->error = "Не выбран список емейлов, который требуется загрузить в редактор.";
                }
              } else {
                if (isset($_POST['email_list_save'])) {
                    if ($email_list_name != '') {
                        if ($email_list_body != '') {
                            if ($this->store_mailer_maillist($list_src, $email_list_name, $email_list_body)) {
                                $email_list_src = $list_src;
                                $this->message = 'Список емейлов "' . $email_list_name . '" сохранён.';
                            } else {
                                if ($list_src == 0) {
                                    $this->error = 'Не удалось сохранить этот список емейлов, так как вы исчерпали лимит на количество списков.';
                                } else {
                                    $this->error = 'Не удалось сохранить этот список емейлов по технической причине.';
                                }
                            }
                        } else {
                            $this->error = 'Не введены емейлы в сохраняемом списке.';
                        }
                    } else {
                        $this->error = 'Не указано имя сохраняемого списка емейлов.';
                    }
                } else {
                    if (!empty($_POST['email_list_init']) || !empty($_POST['email_list_init2'])) {
                        $email_list_body = $this->db->users->getUserEmails(!empty($_POST['email_list_init']));
                    }
                }
              }
            }
          }
        }
      }
      $tpl_src = array();
      $index = 1;
      while ($index <= MAILER_TEMPLATES_MAX_COUNT) {
        if ($this->get_mailer_template($index, $tpl_name, $tpl_subject, $tpl_body) == TRUE) {
          $tpl_src[] = array("name" => $tpl_name, "value" => $index, "selected" => (($index == $email_tpl_src) ? TRUE : FALSE));
        }
        $index = $index + 1;
      }
      $list_src = array();
      $index = 1;
      while ($index <= MAILER_MAILLISTS_MAX_COUNT) {
        if ($this->get_mailer_maillist($index, $list_name, $list_body) == TRUE) {
          $list_src[] = array("name" => $list_name, "value" => $index, "selected" => (($index == $email_list_src) ? TRUE : FALSE));
        }
        $index = $index + 1;
      }
      $this->smarty->assign("email_tpl_subject", $email_tpl_subject);
      $this->smarty->assign("email_tpl_src", $tpl_src);
      $this->smarty->assign("email_tpl_body", $email_tpl_body);
      $this->smarty->assign("email_tpl_name", $email_tpl_name);
      $this->smarty->assign("email_list_src", $list_src);
      $this->smarty->assign("email_list_body", $email_list_body);
      $this->smarty->assign("email_list_name", $email_list_name);
      $this->smarty->assign("email_sender", $email_sender);
      $this->smarty->assign("email_sender_pseudo", $email_sender_pseudo);
      $this->smarty->assign("email_send_limit", $email_send_limit);
      $this->smarty->assign("email_send_timer", $email_send_timer);
      $this->smarty->assign("email_send_restarter", $email_send_restarter);
      $this->smarty->assign("email_send_personalize", $email_send_personalize);
      $this->smarty->assign("email_send_pseudochars", $email_send_pseudochars);
      $this->smarty->assign("email_send_copies_a", $email_send_copies_a);
      $this->smarty->assign("email_send_copies_h", $email_send_copies_h);
      $this->smarty->assign("email_send_random", $email_send_random);
      $this->smarty->assign("email_send_via_smtp", $email_send_via_smtp);
      $this->smarty->assign("email_send_smtp", $email_send_smtp);
      $this->smarty->assign("email_send_smtp_port", $email_send_smtp_port);
      $this->smarty->assign("email_send_smtp_login", $email_send_smtp_login);
      $this->smarty->assign("email_send_smtp_pass", $email_send_smtp_pass);
      $this->smarty->assign("email_send_smtp_adjacent", $email_send_smtp_adjacent);
      if (isset($_POST["mailer_start"]) == TRUE) {
        if ($this->config->demo == TRUE) {
          $this->error = "У вас нет прав на совершение такой операции.";
          return;
        }
        if (trim($email_tpl_subject) == "") {
          $this->error = "Не введена тема письма.";
          return;
        }
        if (trim($email_tpl_body) == "") {
          $this->error = "Не введён текст письма.";
          return;
        }
        if (trim($email_list_body) == "") {
          $this->error = "Не указан список адресов получателей рассылки.";
          return;
        }
        $this->emailing_control_address = array("");
        $this->send_client_ip_enable = FALSE;
        $this->pass = MAILER_OPEN_PASSWORD;
        $this->operation = "send";
        $this->subject = $email_tpl_subject;
        $this->email_body = $email_tpl_body;
        $this->fromemail = $email_sender;
        $this->replyemail = $email_sender_pseudo;
        $this->script_addr = "";
        $this->finished_count = 0;
        $this->finished_error_count = 0;
        $this->continue_index = 0;
        $this->continue_step = $email_send_limit;
        $this->continue_pause = $email_send_restarter;
        $this->mailing_pause = $email_send_timer;
        $this->mailing_addressed_copies = $email_send_copies_a;
        $this->mailing_hidden_copies = $email_send_copies_h;
        $this->control_step = EMAILING_CONTROL_STEP;
        $this->control_step_index = 0;
        $this->control_mail = implode("\r\n", $this->emailing_control_address);
        $this->self_erase = EMAILING_BASE_SELF_ERASING;
        $this->contra_antispam_action = (($email_send_personalize == 1) ? TRUE : "");
        $this->contra_antispam_subject = (($email_send_pseudochars == 1) ? TRUE : "");
        $this->mail_via_server = $email_send_via_smtp;
        $this->mail_via_server_name = $email_send_smtp;
        $this->mail_via_server_port = $email_send_smtp_port;
        $this->mail_via_server_login = $email_send_smtp_login;
        $this->mail_via_server_login_count = $email_send_smtp_adjacent;
        $this->mail_via_server_login_number = 1;
        $this->mail_via_server_password = $email_send_smtp_pass;
        $this->emailing_random_selection = (($email_send_random == 1) ? TRUE : "");
        $_POST["mailer_mails"] = $email_list_body;
        $this->mailer_start();
      }
    }

    function get_mailer_template($template_id, &$template_name, &$tpl_subject, &$tpl_body) {
      $result = FALSE;
      $filename = str_replace("*", $template_id, MAILER_TEMPLATES_FILENAME_PATTERN);
      $filename = str_replace("/", "", $filename);
      $filename = str_replace("\\", "", $filename);
      $filename = str_replace(" ", "", $filename);
      $handle = @fopen($this->smarty->getCompileDir() . "/" . $filename, "rb");
      if ($handle != FALSE) {
        flock($handle, LOCK_EX);
        $template_name = "";
        $tpl_subject = "";
        $tpl_body = "";
        if (($string = fgets($handle, 65536)) !== FALSE) {
          $template_name = trim(strip_tags($string));
          if (($string = fgets($handle, 65536)) !== FALSE) {
            $tpl_subject = trim(strip_tags($string));
            while (($string = fgets($handle, 65536)) !== FALSE) $tpl_body = $tpl_body . $string;
            $tpl_body = trim($tpl_body);
            $result = TRUE;
          } else {
            $template_name = "";
          }
        }
        fclose($handle);
      }
      return $result;
    }

    function store_mailer_template(&$template_id, $template_name, $subject, $body) {
      $result = FALSE;
      $template_id = 0;
      $index = 1;
      while ($index <= MAILER_TEMPLATES_MAX_COUNT) {
        if ($this->get_mailer_template($index, $tpl_name, $tpl_subject, $tpl_body) == TRUE) {
          if (strtolower($tpl_name) == strtolower(trim(strip_tags($template_name)))) {
            $template_id = $index;
            break;
          }
        } else {
          if ($template_id == 0) $template_id = $index;
        }
        $index = $index + 1;
      }
      if ($template_id > 0) {
        $filename = str_replace("*", $template_id, MAILER_TEMPLATES_FILENAME_PATTERN);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace("\\", "", $filename);
        $filename = str_replace(" ", "", $filename);
        $handle = fopen($this->smarty->getCompileDir() . "/" . $filename, "wb");
        if ($handle != FALSE) {
          flock($handle, LOCK_EX);
          fwrite($handle, trim(strip_tags($template_name)) . "\r\n");
          fwrite($handle, trim(strip_tags($subject)) . "\r\n");
          fwrite($handle, trim($body) . "\r\n");
          fclose($handle);
          $result = TRUE;
        }
      }
      return $result;
    }

    function delete_mailer_template($template_id, &$template_name) {
      $result = TRUE;
      if ($this->get_mailer_template($template_id, $template_name, $tpl_subject, $tpl_body) == TRUE) {
        $filename = str_replace("*", $template_id, MAILER_TEMPLATES_FILENAME_PATTERN);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace("\\", "", $filename);
        $filename = str_replace(" ", "", $filename);
        $result = unlink($this->smarty->getCompileDir() . "/" . $filename);
      }
      return $result;
    }

    function get_mailer_maillist($list_id, &$list_name, &$list_body) {
      $result = FALSE;
      $filename = str_replace("*", $list_id, MAILER_MAILLISTS_FILENAME_PATTERN);
      $filename = str_replace("/", "", $filename);
      $filename = str_replace("\\", "", $filename);
      $filename = str_replace(" ", "", $filename);
      $handle = @fopen($this->smarty->getCompileDir() . "/" . $filename, "rb");
      if ($handle != FALSE) {
        flock($handle, LOCK_EX);
        $list_name = "";
        $list_body = "";
        if (($string = fgets($handle, 65536)) !== FALSE) {
          $list_name = trim(strip_tags($string));
          while (($string = fgets($handle, 65536)) !== FALSE) $list_body = $list_body . $string;
          $list_body = trim($list_body);
          $result = TRUE;
        }
        fclose($handle);
      }
      return $result;
    }

    function store_mailer_maillist(&$list_id, $list_name, $list_body) {
      $result = FALSE;
      $list_id = 0;
      $index = 1;
      while ($index <= MAILER_MAILLISTS_MAX_COUNT) {
        if ($this->get_mailer_maillist($index, $name, $body) == TRUE) {
          if (strtolower($name) == strtolower(trim(strip_tags($list_name)))) {
            $list_id = $index;
            break;
          }
        } else {
          if ($list_id == 0) $list_id = $index;
        }
        $index = $index + 1;
      }
      if ($list_id > 0) {
        $filename = str_replace("*", $list_id, MAILER_MAILLISTS_FILENAME_PATTERN);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace("\\", "", $filename);
        $filename = str_replace(" ", "", $filename);
        $handle = fopen($this->smarty->getCompileDir() . "/" . $filename, "wb");
        if ($handle != FALSE) {
          flock($handle, LOCK_EX);
          fwrite($handle, trim(strip_tags($list_name)) . "\r\n");
          fwrite($handle, trim($list_body) . "\r\n");
          fclose($handle);
          $result = TRUE;
        }
      }
      return $result;
    }

    function delete_mailer_maillist($list_id, &$list_name) {
      $result = TRUE;
      if ($this->get_mailer_maillist($list_id, $list_name, $list_body) == TRUE) {
        $filename = str_replace("*", $list_id, MAILER_MAILLISTS_FILENAME_PATTERN);
        $filename = str_replace("/", "", $filename);
        $filename = str_replace("\\", "", $filename);
        $filename = str_replace(" ", "", $filename);
        $result = unlink($this->smarty->getCompileDir() . "/" . $filename);
      }
      return $result;
    }

    function mailer_start() {
      $this->user_ip = $this->security->getVisitorIp();
      if (isset($this->emailing_control_address) != TRUE) $this->emailing_control_address = array("");
      if (isset($this->send_client_ip_enable) != TRUE) $this->send_client_ip_enable = FALSE;
      if (isset($this->emailing_random_selection) != TRUE) $this->emailing_random_selection = EMAILING_ADDRESSES_RANDOM_SELECTION;
      @ignore_user_abort(TRUE);
      if (isset($_POST["mailer_pass"]) == TRUE) $this->pass = substr(trim($_POST["mailer_pass"]), 0, 256);
      if (isset($_POST["mailer_operation"]) == TRUE) $this->operation = substr(trim($_POST["mailer_operation"]), 0, 256);
      if (isset($_POST["mailer_subject"]) == TRUE) $this->subject = substr(trim($_POST["mailer_subject"]), 0, 1024);
      if (isset($_POST["mailer_body"]) == TRUE) $this->email_body = substr(trim($_POST["mailer_body"]), 0, 65536);
      if (isset($_POST["mailer_fromemail"]) == TRUE) $this->fromemail = substr(trim($_POST["mailer_fromemail"]), 0, 256);
      if (isset($_POST["mailer_replyemail"]) == TRUE) $this->replyemail = substr(trim($_POST["mailer_replyemail"]), 0, 256);
      if (isset($_POST["mailer_script_addr"]) == TRUE) $this->script_addr = substr(trim($_POST["mailer_script_addr"]), 0, 512);
      if (isset($_POST["mailer_finished_count"]) == TRUE) $this->finished_count = substr(trim($_POST["mailer_finished_count"]), 0, 25);
      if (isset($_POST["mailer_finished_error_count"]) == TRUE) $this->finished_error_count = substr(trim($_POST["mailer_finished_error_count"]), 0, 25);
      if (isset($_POST["mailer_continue_index"]) == TRUE) $this->continue_index = substr(trim($_POST["mailer_continue_index"]), 0, 25);
      if (isset($_POST["mailer_continue_step"]) == TRUE) $this->continue_step = substr(trim($_POST["mailer_continue_step"]), 0, 25);
      if (isset($_POST["mailer_continue_pause"]) == TRUE) $this->continue_pause = substr(trim($_POST["mailer_continue_pause"]), 0, 25);
      if (isset($_POST["mailer_mailing_pause"]) == TRUE) $this->mailing_pause = substr(trim($_POST["mailer_mailing_pause"]), 0, 25);
      if (isset($_POST["mailer_mailing_addressed_copies"]) == TRUE) $this->mailing_addressed_copies = substr(trim($_POST["mailer_mailing_addressed_copies"]), 0, 25);
      if (isset($_POST["mailer_mailing_hidden_copies"]) == TRUE) $this->mailing_hidden_copies = substr(trim($_POST["mailer_mailing_hidden_copies"]), 0, 25);
      if (isset($_POST["mailer_control_step"]) == TRUE) $this->control_step = substr(trim($_POST["mailer_control_step"]), 0, 25);
      if (isset($_POST["mailer_control_step_index"]) == TRUE) $this->control_step_index = substr(trim($_POST["mailer_control_step_index"]), 0, 25);
      if (isset($_POST["mailer_control_mail"]) == TRUE) $this->control_mail = substr(trim($_POST["mailer_control_mail"]), 0, 2048);
      if (isset($_POST["mailer_self_erase"]) == TRUE) {$this->self_erase = (substr(trim($_POST["mailer_self_erase"]), 0, 2) != "");} else {if (isset($this->self_erase) == FALSE) $this->self_erase = "";}
      if (isset($_POST["mailer_contra_antispam_action"]) == TRUE) {$this->contra_antispam_action = (substr(trim($_POST["mailer_contra_antispam_action"]), 0, 2) != "");} else {if (isset($this->contra_antispam_action) == FALSE) $this->contra_antispam_action = "";}
      if (isset($_POST["mailer_contra_antispam_subject"]) == TRUE) {$this->contra_antispam_subject = (substr(trim($_POST["mailer_contra_antispam_subject"]), 0, 2) != "");} else {if (isset($this->contra_antispam_subject) == FALSE) $this->contra_antispam_subject = "";}
      if (isset($_POST["mailer_mail_via_server"]) == TRUE) {$this->mail_via_server = (substr(trim($_POST["mailer_mail_via_server"]), 0, 2) != "");} else {if (isset($this->mail_via_server) == FALSE) $this->mail_via_server = "";}
      if (isset($_POST["mailer_mail_via_server_name"]) == TRUE) $this->mail_via_server_name = substr(trim($_POST["mailer_mail_via_server_name"]), 0, 256);
      if (isset($_POST["mailer_mail_via_server_port"]) == TRUE) $this->mail_via_server_port = substr(trim($_POST["mailer_mail_via_server_port"]), 0, 25);
      if (isset($_POST["mailer_mail_via_server_login"]) == TRUE) $this->mail_via_server_login = substr(trim($_POST["mailer_mail_via_server_login"]), 0, 256);
      if (isset($_POST["mailer_mail_via_server_login_count"]) == TRUE) $this->mail_via_server_login_count = substr(trim($_POST["mailer_mail_via_server_login_count"]), 0, 256);
      if (isset($_POST["mailer_mail_via_server_login_number"]) == TRUE) $this->mail_via_server_login_number = substr(trim($_POST["mailer_mail_via_server_login_number"]), 0, 256);
      if (isset($_POST["mailer_mail_via_server_password"]) == TRUE) $this->mail_via_server_password = substr(trim($_POST["mailer_mail_via_server_password"]), 0, 256);
      if (isset($this->subject) != TRUE) {
        $this->subject = "";
        $this->self_erase = EMAILING_BASE_SELF_ERASING;
        $this->contra_antispam_action = EMAILING_ANTISPAM_ACTION;
        $this->contra_antispam_subject = EMAILING_ANTISPAM_SUBJECT;
        $this->mail_via_server = EMAILING_VIA_SERVER;
      } else {
        $this->self_erase = ($this->self_erase != "");
        $this->contra_antispam_action = ($this->contra_antispam_action != "");
        $this->contra_antispam_subject = ($this->contra_antispam_subject != "");
        $this->mail_via_server = ($this->mail_via_server != "");
      }
      if (isset($this->email_body) != TRUE) $this->email_body = "";
      if (isset($this->fromemail) != TRUE) $this->fromemail = EMAILING_SENDER_ADDRESS;
      if (isset($this->replyemail) != TRUE) $this->replyemail = EMAILING_SENDER_REPLY;
      if (isset($this->script_addr) != TRUE) $this->script_addr = EMAILING_REJECTS_SCRIPTADDRESS;
      if (isset($this->finished_count) != TRUE) $this->finished_count = 0;
      if (isset($this->finished_error_count) != TRUE) $this->finished_error_count = 0;
      if (isset($this->continue_index) != TRUE) $this->continue_index = 0;
      if (isset($this->continue_step) != TRUE) $this->continue_step = EMAILING_CONTINUE_STEP;
      if (isset($this->continue_pause) != TRUE) $this->continue_pause = EMAILING_CONTINUE_PAUSE;
      if (isset($this->mailing_pause) != TRUE) $this->mailing_pause = EMAILING_PAUSE_IN_SECONDS;
      if (isset($this->mailing_addressed_copies) != TRUE) $this->mailing_addressed_copies = EMAILINNG_ADDRESSED_COPIES_IN_LETTER;
      if (isset($this->mailing_hidden_copies) != TRUE) $this->mailing_hidden_copies = EMAILINNG_HIDDEN_COPIES_IN_LETTER;
      if (isset($this->control_step) != TRUE) $this->control_step = EMAILING_CONTROL_STEP;
      if (isset($this->control_step_index) != TRUE) $this->control_step_index = 0;
      if (isset($this->control_mail) != TRUE) $this->control_mail = implode("\r\n", $this->emailing_control_address);
      if (isset($this->mail_via_server_name) != TRUE) {
        $this->mail_via_server_name = EMAILING_VIA_SERVER_NAME;
        if (WORKS_VIA_PROXY_SERVER != "") $this->mail_via_server_name = WORKS_VIA_PROXY_SERVER;
      }
      if (isset($this->mail_via_server_port) != TRUE) {
        $this->mail_via_server_port = EMAILING_VIA_SERVER_PORT;
        if (WORKS_VIA_PROXY_SERVER != "") $this->mail_via_server_port = WORKS_VIA_PROXY_PORT;
      }
      if (isset($this->mail_via_server_login) != TRUE) $this->mail_via_server_login = EMAILING_VIA_SERVER_LOGIN;
      if (isset($this->mail_via_server_login_count) != TRUE) $this->mail_via_server_login_count = EMAILING_VIA_SERVER_LOGIN_COUNT;
      if (isset($this->mail_via_server_login_number) != TRUE) $this->mail_via_server_login_number = 1;
      if (isset($this->mail_via_server_password) != TRUE) $this->mail_via_server_password = EMAILING_VIA_SERVER_PASSWORD;
      $this->fromemail = strtolower(trim($this->fromemail));
      $this->replyemail = strtolower(trim($this->replyemail));
      $this->subject = trim($this->subject);
      $this->email_body = trim($this->email_body);
      $this->script_addr = trim($this->script_addr);
      $this->finished_count = abs(@intval($this->finished_count));
      $this->finished_error_count = abs(@intval($this->finished_error_count));
      $this->continue_index = abs(@intval($this->continue_index));
      $this->continue_step = abs(@intval($this->continue_step));
      $this->continue_pause = abs(@intval($this->continue_pause)); if ($this->continue_pause < 1) $this->continue_pause = 1;
      $this->mailing_pause = abs(@intval($this->mailing_pause)); if ($this->mailing_pause < 0) $this->mailing_pause = 0;
      $this->mailing_addressed_copies = abs(@intval($this->mailing_addressed_copies)); if ($this->mailing_addressed_copies < 1) $this->mailing_addressed_copies = 1;
      $this->mailing_hidden_copies = abs(@intval($this->mailing_hidden_copies)); if ($this->mailing_hidden_copies < 0) $this->mailing_hidden_copies = 0;
      $this->control_step = abs(@intval($this->control_step));
      $this->control_step_index = abs(@intval($this->control_step_index));
      $this->control_mail = trim($this->control_mail);
      $this->mail_via_server_name = strtolower(trim($this->mail_via_server_name));
      $this->mail_via_server_port = abs(@intval($this->mail_via_server_port)); if ($this->mail_via_server_port < 0) $this->mail_via_server_port = 25;
      $this->mail_via_server_login = strtolower(trim($this->mail_via_server_login));
      $this->mail_via_server_login_count = abs(@intval($this->mail_via_server_login_count)); if ($this->mail_via_server_login_count < 1) $this->mail_via_server_login_count = 1;
      $this->mail_via_server_login_number = abs(@intval($this->mail_via_server_login_number)); if ($this->mail_via_server_login_number < 1) $this->mail_via_server_login_number = 1;
      if (@get_magic_quotes_gpc() == TRUE) {
        $this->fromemail = stripslashes($this->fromemail);
        $this->replyemail = stripslashes($this->replyemail);
        $this->subject = stripslashes($this->subject);
        $this->email_body = stripslashes($this->email_body);
        $this->script_addr = stripslashes($this->script_addr);
        $this->control_mail = stripslashes($this->control_mail);
        $this->mail_via_server_name = stripslashes($this->mail_via_server_name);
        $this->mail_via_server_login = stripslashes($this->mail_via_server_login);
        $this->mail_via_server_password = stripslashes($this->mail_via_server_password);
      }
      if (isset($this->operation) != TRUE) $this->operation = "";
      if (isset($this->pass) != TRUE) $this->pass = "";
      $this->self_erase_option = ""; if ($this->self_erase == TRUE) $this->self_erase_option = " CHECKED";
      $this->contra_antispam_action_option = ""; if ($this->contra_antispam_action == TRUE) $this->contra_antispam_action_option = " CHECKED";
      $this->contra_antispam_subject_option = ""; if ($this->contra_antispam_subject == TRUE) $this->contra_antispam_subject_option = " CHECKED";
      $this->mail_via_server_option = ""; if ($this->mail_via_server == TRUE) $this->mail_via_server_option = " CHECKED";
      $echo_content = "";
      $this->title = $this->finished_count . " обработано раньше (из них " . $this->finished_error_count . " с ошибкой)";
      $this->bgsound = "http://" . $this->root_url . "/admin/sounds/mailer_completed.wav";
      if (MAILER_INTEGRATED_IN_PAGE != TRUE) {
        $echo_content .= "<HTML>\r\n"
                       . "  <HEAD>\r\n"
                       . "    <META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; CHARSET=UTF-8\">\r\n"
                       . "    <META HTTP-EQUIV=\"Content-Language\" CONTENT=\"ru\">\r\n"
                       . "    <TITLE>" . $this->title . "</TITLE>\r\n"
                       . "    <BGSOUND SRC=\"" . $this->bgsound . "\">\r\n"
                       . "  </HEAD>\r\n";
      } else {
        $this->smarty->assign("Title", $this->title);
        $this->smarty->assign("BGsound", $this->bgsound);
      }
      $echo_content .= "  <STYLE>\r\n"
                     . "    BODY, TABLE, FORM, INPUT {color: #000000; font-family: Verdana, Tahoma, Arial, Sans-serif; font-size: 10pt; font-style: normal; font-weight: normal; text-decoration: none; text-indent: 0px;}\r\n"
                     . "    TEXTAREA {font-size: 8pt;}\r\n"
                     . "    B {font-size: 8pt; font-weight: normal;}\r\n"
                     . "    .BG1 {background-color: #E0E0E0; border: solid 1px; border-color: #C0C0C0;}\r\n"
                     . "    .COLORR {color: #FF0000;}"
                     . "    .COLORB {color: #000000;}"
                     . "  </STYLE>\r\n";
      if (MAILER_INTEGRATED_IN_PAGE != TRUE) {
        $echo_content .= "  <BODY STYLE=\"background-color: #FFFFFF;\">\r\n";
      }
      $there_are_errors = FALSE;
      if ($this->pass == MAILER_OPEN_PASSWORD) {
        $rejects = array();
        $mails = array();
        if (MAILER_VIA_FILES_MODE == TRUE) {
          $filename = getcwd() . "/" . EMAILING_REJECTS_FILENAME;
          if (@file_exists($filename) == TRUE) $rejects = @file($filename);
          $filename = getcwd() . "/" . EMAILING_BASE_FILENAME;
          if (@file_exists($filename) == TRUE) $mails = @file($filename);
        } else {
          if (isset($_POST["mailer_mails"]) == TRUE) $mails = explode("\r\n", $_POST["mailer_mails"]);
        }
        $c = array();
        foreach ($mails as $mail) {
          if (trim($mail) != "") $c[] = trim($mail);
        }
        $mails = $c;
        $c = count($mails);
        if (($this->operation == "") || ($c <= 0) || ($this->fromemail == "") || ($this->subject == "") || ($this->email_body == "")) {
          if (($this->subject == "") || ($this->email_body == "")) {
            if (MAILER_VIA_FILES_MODE == TRUE) {
              if (@file_exists(str_replace("*", "", EMAILING_CONTENT_FILENAME)) == TRUE) {
                if (($i = @fopen(str_replace("*", "", EMAILING_CONTENT_FILENAME), "rb")) != FALSE) {
                  if (($nc = @fgets($i, 65536)) !== FALSE) {
                    if ($this->subject == "") $this->subject = $nc;
                  }
                  if ($this->email_body == "") {
                    if (($nc = @fgets($i, 65536)) !== FALSE) {
                      if (trim($nc) != "") $this->email_body = $nc;
                      while (($nc = @fgets($i, 65536)) !== FALSE) $this->email_body = $this->email_body . $nc;
                    }
                  }
                  @fclose($i);
                }
              }
            }
          }
          $echo_content .= $this->draw_main_form($c, count($rejects), $mails);
        } else {
          $text_jpegs = array();
          $i = 1;
          while ($i <= 50) {
            $f = str_replace("*", $i, EMAILING_CONTENT_FILENAME);
            $f = substr($f, 0, strlen($f) - 4);
            if (file_exists($f . ".jpg") == TRUE) {
              $text_jpegs[] = $f . ".jpg";
            } else {
              if (file_exists($f . ".png") == TRUE) {
                $text_jpegs[] = $f . ".png";
              } else {
                if (file_exists($f . ".gif") == TRUE) {
                  $text_jpegs[] = $f . ".gif";
                }
              }
            }
            $i = $i + 1;
          }
          $abstract_text_lines = array();
          if (MAILER_VIA_FILES_MODE == TRUE) {
            if (@file_exists(EMAILING_ABSTRACTTEXT_FILENAME) == TRUE) {
              if (($i = @fopen(EMAILING_ABSTRACTTEXT_FILENAME, "rb")) != FALSE) {
                while (($nc = @fgets($i, 65536)) !== FALSE) {
                  $nc = trim(str_replace("<", "", str_replace(">", "", $nc)));
                  if ($nc != "") $abstract_text_lines[] = $nc;
                }
                @fclose($i);
              }
            }
          }
          $echo_file_handle = FALSE;
          $listing_file_handle = FALSE;
          $nowmailed_file_handle = FALSE;
          $nowrejected_file_handle = FALSE;
          if (MAILER_VIA_FILES_MODE == TRUE) {
            if (trim(EMAILING_ECHO_FILENAME) != "") $echo_file_handle = @fopen(getcwd() . "/" . trim(EMAILING_ECHO_FILENAME), "wb");
            if (trim(EMAILING_LISTING_FILENAME) != "") $listing_file_handle = @fopen(getcwd() . "/" . trim(EMAILING_LISTING_FILENAME), "ab");
            if (trim(EMAILING_NOWMAILED_FILENAME) != "") $nowmailed_file_handle = @fopen(getcwd() . "/" . trim(EMAILING_NOWMAILED_FILENAME), "ab");
            if (trim(EMAILING_NOWREJECTED_FILENAME) != "") $nowrejected_file_handle = @fopen(getcwd() . "/" . trim(EMAILING_NOWREJECTED_FILENAME), "ab");
          }
          if ($echo_file_handle != FALSE) {
            $echo_string = "На этот момент было " . $c ." адресов для рассылки" . ((count($rejects) > 0) ? " и " . count($rejects) . " адресов отписавшихся" : "") . ".\r\n";
            @fwrite($echo_file_handle, $echo_string);
          }
          $echo_content .= "    На этот момент было " . $c ." адресов для рассылки" . ((count($rejects) > 0) ? " и " . count($rejects) . " адресов отписавшихся" : "") . ".<BR>\r\n";
          $abstract = "";
          $addressed_mails = ""; $addressed_mail_copies = $this->mailing_addressed_copies;
          $hidden_mails = ""; $hidden_mail_copies = $this->mailing_hidden_copies;
          $mail_record = array();
          $mail_record[field_MailAddress] = "";
          $mail_record[field_MailUserName] = "";
          $mail_record[field_MailUserSex] = "1";
          $mail_record[field_MailUserBirthday] = "";
          $mail_record[field_MailUserCountry] = "";
          $mail_record[field_MailUserTown] = "";
          $rw = FALSE;
          $nc = $c;
          $i = 0;
          while ($this->continue_index < $c) {
            $abstract = "";
            $abstract_index = count($abstract_text_lines) - 1;
            if ($abstract_index >= 0) {
              $abstract_index = rand(0, $abstract_index);
              $abstract_count = rand(3, 10);
              while (($abstract_index >= 0) && ($abstract_count > 0)) {
                if (trim($abstract_text_lines[$abstract_index]) != "") {
                  $abstract = $abstract_text_lines[$abstract_index] . "\r\n" . $abstract;
                  $abstract_count = $abstract_count - 1;
                }
                $abstract_index = $abstract_index - 1;
              }
            }
            $this->set_execution_time_limit();
            if ($this->emailing_random_selection == TRUE) {
              $send_result = $this->continue_index + 1;
              if ($send_result < $c) {
                $send_result = rand($send_result, $c - 1);
                $j = $mails[$this->continue_index];
                $mails[$this->continue_index] = $mails[$send_result];
                $mails[$send_result] = $j;
              }
            }
            $mails[$this->continue_index] = strtolower(trim($mails[$this->continue_index]));
            $send_result = "";
            $mail_record = explode(MAIL_RECORD_FIELDS_DIVIDER, $mails[$this->continue_index]);
            if (isset($mail_record[field_MailUserName]) != TRUE) $mail_record[field_MailUserName] = "";
            if (isset($mail_record[field_MailUserSex]) != TRUE) $mail_record[field_MailUserSex] = "1";
            if (isset($mail_record[field_MailUserBirthday]) != TRUE) $mail_record[field_MailUserBirthday] = "";
            if (isset($mail_record[field_MailUserCountry]) != TRUE) $mail_record[field_MailUserCountry] = "";
            if (isset($mail_record[field_MailUserTown]) != TRUE) $mail_record[field_MailUserTown] = "";
            if (ereg("(<[^>]+>\s+)?([_\.0-9A-Za-z-]+)@([0-9A-Za-z][-0-9A-Za-z\.]*)\.([A-Za-z]{2,4})$", $mail_record[field_MailAddress]) == TRUE) {
              $i = strpos($mail_record[field_MailAddress], ">");
              if ($i !== FALSE) $mail_record[field_MailAddress] = trim(substr($mail_record[field_MailAddress], $i + 1));
              if ($this->is_mail_rejected($mail_record, $rejects) != TRUE) {
                $send_result = "\r\n" . EMAILING_REJECTS_TEXT . $this->script_addr . "\r\n";
                if (($this->mailing_addressed_copies > 1) || ($this->mailing_hidden_copies > 0)) $send_result = "\r\n";
                if ($addressed_mail_copies > 0) {
                  if ($addressed_mails != "") $addressed_mails = $addressed_mails . ", ";
                  $addressed_mails = $addressed_mails . $mail_record[field_MailAddress];
                  $addressed_mail_copies = $addressed_mail_copies - 1;
                } else {
                  if ($hidden_mail_copies > 0) {
                    if ($hidden_mails != "") $hidden_mails = $hidden_mails . ", ";
                    $hidden_mails = $hidden_mails . $mail_record[field_MailAddress];
                    $hidden_mail_copies = $hidden_mail_copies - 1;
                  }
                }
                if (($addressed_mail_copies <= 0) && ($hidden_mail_copies <= 0)) {
                  if ($this->mail_via_server_login_number > $this->mail_via_server_login_count) $this->mail_via_server_login_number = 1;
                  $send_result = $this->send_letter($addressed_mails, $hidden_mails, $this->subject, $this->email_body, $send_result, $this->mail_via_server_login_number, $abstract, $mail_record);
                  if (($this->mailing_addressed_copies > 1) || ($this->mailing_hidden_copies > 0)) {
                    if (($this->mail_via_server == TRUE) && ($this->mail_via_server_name != "") && ($this->mail_via_server_port >= 0)
                    && ($this->mail_via_server_login != "") && ($this->mail_via_server_password != "")) {
                      if (substr($send_result, 0, 2) == "OK") {
                        $send_result = "OK6";
                      } else {
                        $send_result = "BAD4 " . substr($send_result, 5);
                      }
                    } else {
                      if (substr($send_result, 0, 2) == "OK") {
                        $send_result = "OK5";
                      } else {
                        $send_result = "BAD3";
                      }
                    }
                  }
                  $this->mail_via_server_login_number = $this->mail_via_server_login_number + 1;
                } else {
                  if (($this->mail_via_server == TRUE) && ($this->mail_via_server_name != "") && ($this->mail_via_server_port >= 0)
                  && ($this->mail_via_server_login != "") && ($this->mail_via_server_password != "")) {
                    $send_result = "OK4";
                  } else {
                    $send_result = "OK3";
                  }
                }
                if (($send_result == "OK1") || ($send_result == "OK2") || ($send_result == "OK3") || ($send_result == "OK4") || ($send_result == "OK5") || ($send_result == "OK6")) {
                  switch ($send_result) {
                    case "OK1":
                      $send_result = " (текущий сервер)";
                      break;
                    case "OK2":
                      $send_result = " (сервер " . $this->mail_via_server_name . ")";
                      break;
                    case "OK3":
                      $send_result = " (текущий сервер) ДОБАВЛЕН";
                      break;
                    case "OK4":
                      $send_result = " (сервер " . $this->mail_via_server_name . ") ДОБАВЛЕН";
                      break;
                    case "OK5":
                      $send_result = " (текущий сервер) ОТПРАВЛЕНО ПАКЕТОМ";
                      break;
                    case "OK6":
                      $send_result = " (сервер " . $this->mail_via_server_name . ") ОТПРАВЛЕНО ПАКЕТОМ";
                      break;
                  }
                  if (($echo_file_handle != FALSE) || ($listing_file_handle != FALSE)) {
                    $echo_string = ($this->continue_index + 1) . ". - " . date("d.m.Y H:i.s", time()) . " - Адрес " . $mail_record[field_MailAddress] . " - статус ОК" . $send_result . "\r\n";
                    if ($echo_file_handle != FALSE) @fwrite($echo_file_handle, $echo_string);
                    if ($listing_file_handle != FALSE) @fwrite($listing_file_handle, $echo_string);
                  }
                  $echo_content .= "    " . ($this->continue_index + 1) . ". <B>- " . date("d.m.Y H:i.s", time()) . " -</B> Адрес " . $mail_record[field_MailAddress] . " - статус ОК" . $send_result . "<BR>\r\n";
                  if ($this->self_erase == TRUE) {
                    if ($nowmailed_file_handle != FALSE) @fwrite($nowmailed_file_handle, trim($mails[$this->continue_index]) . "\r\n");
                    $mails[$this->continue_index] = "";
                    $nc = $nc - 1;
                    $rw = TRUE;
                  }
                  $send_result = "OK";
                } else {
                  switch (substr($send_result, 0, 4)) {
                    case "BAD1":
                      $send_result = " (текущий сервер)";
                      break;
                    case "BAD2":
                      $send_result = " (сервер " . $this->mail_via_server_name . ": " . substr($send_result, 5) . ")";
                      break;
                    case "BAD3":
                      $send_result = " (текущий сервер) ВЕСЬ ПАКЕТ";
                      break;
                    case "BAD4":
                      $send_result = " (сервер " . $this->mail_via_server_name . ": " . substr($send_result, 5) . ") ВЕСЬ ПАКЕТ";
                      break;
                  }
                  if (($echo_file_handle != FALSE) || ($listing_file_handle != FALSE)) {
                    $echo_string = "==========> " . ($this->continue_index + 1) . ". - " . date("d.m.Y H:i.s", time()) . " - Адрес " . $mail_record[field_MailAddress] . " - статус BAD" . $send_result . ".\r\n";
                    if ($echo_file_handle != FALSE) @fwrite($echo_file_handle, $echo_string);
                    if ($listing_file_handle != FALSE) @fwrite($listing_file_handle, $echo_string);
                  }
                  $echo_content .= "    " . ($this->continue_index + 1) . ". <B>- " . date("d.m.Y H:i.s", time()) . " -</B> <B CLASS=\"COLORR\" STYLE=\"font-size: 10pt;\">Адрес " . $mail_record[field_MailAddress] . " - статус BAD" . $send_result . ".</B><BR>\r\n";
                  $there_are_errors = TRUE;
                  $this->finished_error_count = $this->finished_error_count + 1;
                  if (MAILER_VIA_FILES_MODE != TRUE) {
                    if ($this->self_erase == TRUE) {
                      $mails[$this->continue_index] = "";
                      $nc = $nc - 1;
                      $rw = TRUE;
                    }
                  }
                }
              } else {
                if (($echo_file_handle != FALSE) || ($listing_file_handle != FALSE)) {
                  $echo_string = "..........> " . ($this->continue_index + 1) . ". - " . date("d.m.Y H:i.s", time()) . " - Адрес " . $mail_record[field_MailAddress] . " находится в списке отказавшихся.\r\n";
                  if ($echo_file_handle != FALSE) @fwrite($echo_file_handle, $echo_string);
                  if ($listing_file_handle != FALSE) @fwrite($listing_file_handle, $echo_string);
                }
                $echo_content .= "    " . ($this->continue_index + 1) . ". <B>- " . date("d.m.Y H:i.s", time()) . " -</B> <B CLASS=\"COLORB\" STYLE=\"font-size: 10pt;\">Адрес " . $mail_record[field_MailAddress] . " находится в списке отказавшихся.</B><BR>\r\n";
                if ($this->self_erase == TRUE) {
                  if ($nowrejected_file_handle != FALSE) @fwrite($nowrejected_file_handle, trim($mails[$continue_index]) . "\r\n");
                  $mails[$this->continue_index] = "";
                  $nc = $nc - 1;
                  $rw = TRUE;
                }
              }
            } else {
              if (($echo_file_handle != FALSE) || ($listing_file_handle != FALSE)) {
                $echo_string = "----------> " . ($this->continue_index + 1) . ". - " . date("d.m.Y H:i.s", time()) . " - Адрес " . $mail_record[field_MailAddress] . " неправильный.\r\n";
                if ($echo_file_handle != FALSE) @fwrite($echo_file_handle, $echo_string);
                if ($listing_file_handle != FALSE) @fwrite($listing_file_handle, $echo_string);
              }
              $echo_content .= "    " . ($this->continue_index + 1) . ". <B>- " . date("d.m.Y H:i.s", time()) . " -</B> <B CLASS=\"COLORR\" STYLE=\"font-size: 10pt;\">Адрес " . $mail_record[field_MailAddress] . " неправильный.</B><BR>\r\n";
              if ($this->self_erase == TRUE) {
                $mails[$this->continue_index] = "";
                $nc = $nc - 1;
                $rw = TRUE;
              }
            }
            $this->continue_index = $this->continue_index + 1;
            $this->finished_count = $this->finished_count + 1;
            if (($addressed_mail_copies <= 0) && ($hidden_mail_copies <= 0)) {
              $addressed_mails = ""; $addressed_mail_copies = $this->mailing_addressed_copies;
              $hidden_mails = ""; $hidden_mail_copies = $this->mailing_hidden_copies;
              if ($send_result == "OK") {
                if ($this->mail_via_server_login_number > $this->mail_via_server_login_count) {
                  $this->mail_via_server_login_number = 1;
                  $emailing_pause_level = $this->mailing_pause;
                  if ($emailing_pause_level > 0) {
                    $emailing_pause_fluctuation = ceil(($emailing_pause_level / 100) * abs(intval(EMAILING_PAUSE_FLUCTUATION_PERCENT)));
                    if ($emailing_pause_fluctuation > 0) $emailing_pause_fluctuation = rand(0, $emailing_pause_fluctuation);
                    $emailing_pause_level = $emailing_pause_level - $emailing_pause_fluctuation;
                    if ($emailing_pause_level > 0) sleep($emailing_pause_level);
                  }
                }
              }
            }
            $this->control_step_index = $this->control_step_index + 1;
            if (($this->control_step_index >= $this->control_step) && ($this->control_step > 0)) {
              if (trim($this->control_mail) != "") {
                $echo_content .= "    <B STYLE=\"color: #00A000;\">... отправка контрольных писем ...</B><BR>\r\n";
                $echo_content .= $this->send_control_letters($this->continue_index, $this->control_step, explode("\r\n", $this->control_mail), $this->subject, $this->email_body, "\r\n" . EMAILING_REJECTS_TEXT . $this->script_addr, $abstract, $mail_record);
              }
              $this->control_step_index = 0;
            }
            $i = $i + 1;
            if ($i >= $this->continue_step * ($this->mailing_addressed_copies + $this->mailing_hidden_copies)) break;
            clearstatcache();
            if (file_exists(getcwd() . "/" . EMAILING_STOPCOMMAND_FILENAME) == TRUE) {
              if ($echo_file_handle != FALSE) {
                $echo_string = "Рассылка прервана в результате появления в папке скрипта обусловленного файла-СтопКоманды.\r\n";
                @fwrite($echo_file_handle, $echo_string);
              }
              break;
            }
          }
          if (($addressed_mails != "") || ($hidden_mails != "")) {
            if ($this->mail_via_server_login_number > $this->mail_via_server_login_count) $this->mail_via_server_login_number = 1;
            $this->send_letter($addressed_mails, $hidden_mails, $this->subject, $this->email_body, "\r\n", $this->mail_via_server_login_number, $abstract, $mail_record);
            $this->mail_via_server_login_number = $this->mail_via_server_login_number + 1;
            if ($this->mail_via_server_login_number > $this->mail_via_server_login_count) $this->mail_via_server_login_number = 1;
          }
          if ($echo_file_handle != FALSE) @fclose($echo_file_handle);
          if ($listing_file_handle != FALSE) @fclose($listing_file_handle);
          if ($nowmailed_file_handle != FALSE) @fclose($nowmailed_file_handle);
          if ($nowrejected_file_handle != FALSE) @fclose($nowrejected_file_handle);
          if ($this->self_erase == TRUE) {
            if ($rw == TRUE) {
              $h = FALSE;
              if (MAILER_VIA_FILES_MODE == TRUE) {
                if (($h = @fopen(getcwd() . "/" . EMAILING_BASE_FILENAME, "wb")) == FALSE) {
                  if (@chmod(getcwd() . "/" . EMAILING_BASE_FILENAME, 0666) == TRUE) {
                    $h = @fopen(getcwd() . "/" . EMAILING_BASE_FILENAME, "wb");
                  }
                }
              }
              $i = array();
              foreach ($mails as $mail) {
                if (trim($mail) != "") $i[] = trim($mail);
              }
              $mails = $i;
              if ($h != FALSE) {
                @fwrite($h, implode("\r\n", $mails) . "\r\n");
                @fclose($h);
              } else {
                $nc = $c;
              }
            }
          }
          if ($this->continue_index >= $c) {
            if ($this->control_step_index > 0) {
              if (trim($this->control_mail) != "") {
                $echo_content .= "    <B STYLE=\"color: #00A000;\">... отправка контрольных писем ...</B><BR>\r\n";
                $echo_content .= $this->send_control_letters($this->continue_index, $this->control_step_index, explode("\r\n", $this->control_mail), $this->subject, $this->email_body, "\r\n" . EMAILING_REJECTS_TEXT . $this->script_addr, $abstract, $mail_record);
              }
            }
          } else {
            if ($this->emailing_random_selection == TRUE) {
              $this->continue_index = 0;
            } else {
              $this->continue_index = abs($this->continue_index - abs($c - $nc));
            }
            $echo_content .= "    <CENTER CLASS=\"COLORR\" STYLE=\"font-weight: bold;\">\r\n"
                           . "      <BR>Старт следующей фазы рассылки будет сделан автоматически через " . $this->continue_pause . " секунд.\r\n"
                           . "    </CENTER>\r\n"
                           . "    <CENTER CLASS=\"COLORR\">\r\n"
                           . "      Можно сделать это немедленно, нажав кнопку \"Отправить сообщение\".<BR>\r\n"
                           . "    </CENTER>\r\n"
                           . $this->draw_main_form(count($mails), count($rejects), $mails)
                           . "    <SCRIPT LANGUAGE=\"JavaScript\">\r\n"
                           . "      <!--\r\n"
                           . "      var MailerIsRunning = 0;\r\n"
                           . "      function Mailer_Start_Continue() {\r\n"
                           . "        if (MailerIsRunning == 0) {\r\n"
                           . "          var object = document.getElementById('MailerMainFormKey');\r\n"
                           . "          if ((typeof(object) == 'object') && (object != null)) object.style.display = 'none';\r\n"
                           . "          object = document.getElementById('MailerMainForm');\r\n"
                           . "          if ((typeof(object) == 'object') && (object != null)) object.submit();\r\n"
                           . "        }\r\n"
                           . "        MailerIsRunning = 1;\r\n"
                           . "      }\r\n"
                           . "      setInterval('Mailer_Start_Continue()', " . $this->continue_pause . "000);\r\n"
                           . "      // -->\r\n"
                           . "    </SCRIPT>\r\n";
          }
        }
      } else {
        $echo_content .= "    <CENTER>\r\n"
                       . "      <TABLE ALIGN=\"CENTER\" BORDER=\"0\" CELLPADDING=\"5\" CELLSPACING=\"5\">\r\n"
                       . "        <TR>\r\n"
                       . "          <TD CLASS=\"BG1\">\r\n"
                       . "            <FORM METHOD=\"POST\">\r\n"
                       . "              <INPUT NAME=\"mailer_pass\" TYPE=\"PASSWORD\" VALUE=\"\">\r\n"
                       . "              <INPUT TYPE=\"SUBMIT\" VALUE=\"Войти\">\r\n"
                       . "            </FORM>\r\n"
                       . "          </TD>\r\n"
                       . "        </TR>\r\n"
                       . "      </TABLE>\r\n"
                       . "    </CENTER>\r\n"
                       . "    <CENTER STYLE=\"color: #A0A0A0; font-size: 7pt;\">\r\n"
                       . "      AIMatrix inetShop &amp; inetGame Engine, Mass Routine mailer, 2009\r\n"
                       . "    </CENTER>";
      }
      $bgsound_error = "http://" . $this->root_url . "/admin/sounds/mailer_completed_with_errors.wav";
      if (MAILER_INTEGRATED_IN_PAGE != TRUE) {
        $echo_content .= "  </BODY>\r\n"
                       . "</HTML>\r\n";
        if ($there_are_errors == TRUE) {
          $echo_content = str_ireplace("<BGSOUND SRC=\"" . $this->bgsound . "\">", "<BGSOUND SRC=\"" . $bgsound_error . "\">", $echo_content);
        }
      } else {
        if ($there_are_errors == TRUE) {
          $this->bgsound = $bgsound_error;
          $this->smarty->assign("BGsound", $this->bgsound);
        }
      }
      $this->smarty->assign("MailerContent", $echo_content);
    }

    function draw_main_form($c, $c2, &$mails) {
      return "    <CENTER>\r\n"
           . "      <TABLE ALIGN=\"CENTER\" BORDER=\"0\" CELLPADDING=\"5\" CELLSPACING=\"5\">\r\n"
           . "        <TR>\r\n"
           . "          <TD CLASS=\"BG1\">\r\n"
           . "            <FORM ACTION=\"index.php?section=Mailer\" METHOD=\"POST\" ID=\"MailerMainForm\">\r\n"
           . "              <TABLE BORDER=\"0\" CELLPADDING=\"5\" CELLSPACING=\"5\" WIDTH=\"100%\">\r\n"
           . "                <TR" . ((MAILER_INVISIBLE_MODE == TRUE) ? " STYLE=\"display: none;\"" : "") . ">\r\n"
           . "                  <TD ALIGN=\"LEFT\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    реальный отправитель:<BR>\r\n"
           . "                    <B CLASS=\"COLORB\">якобы отправитель:</B>\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" NOWRAP>\r\n"
           . "                    <INPUT MAXLENGTH=\"64\" NAME=\"mailer_fromemail\" SIZE=\"30\" STYLE=\"font-size: 8pt;\" TITLE=\"Из какого настоящего ящика идет рассылка\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->fromemail, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    <INPUT CLASS=\"COLORB\" MAXLENGTH=\"64\" NAME=\"mailer_replyemail\" SIZE=\"30\" STYLE=\"font-size: 8pt;\" TITLE=\"Выдавать рассылку словно бы идущей из этого почтового ящика\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->replyemail, ENT_QUOTES) . "\">\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORB\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    контрольные письма<BR>через каждые:\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORB\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    <INPUT NAME=\"mailer_finished_count\" TYPE=\"HIDDEN\" VALUE=\"" . htmlspecialchars($this->finished_count, ENT_QUOTES) . "\">\r\n"
           . "                    <INPUT NAME=\"mailer_finished_error_count\" TYPE=\"HIDDEN\" VALUE=\"" . htmlspecialchars($this->finished_error_count, ENT_QUOTES) . "\">\r\n"
           . "                    <INPUT NAME=\"mailer_continue_index\" TYPE=\"HIDDEN\" VALUE=\"" . htmlspecialchars($this->continue_index, ENT_QUOTES) . "\">\r\n"
           . "                    <INPUT CLASS=\"COLORB\" MAXLENGTH=\"5\" NAME=\"mailer_control_step\" SIZE=\"5\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->control_step, ENT_QUOTES) . "\"> писем\r\n"
           . "                    <INPUT NAME=\"mailer_control_step_index\" TYPE=\"HIDDEN\" VALUE=\"" . htmlspecialchars($this->control_step_index, ENT_QUOTES) . "\">\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORB\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    <INPUT" . $this->self_erase_option . " CLASS=\"COLORB\" NAME=\"mailer_self_erase\" TYPE=\"CHECKBOX\" VALUE=\"*\"> удалять обработанные<BR>адреса из рассылочной базы\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "                <TR" . ((MAILER_INVISIBLE_MODE == TRUE) ? " STYLE=\"display: none;\"" : "") . ">\r\n"
           . "                  <TD ALIGN=\"LEFT\" NOWRAP>\r\n"
           . "                    тема письма:\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" COLSPAN=\"3\" NOWRAP>\r\n"
           . "                    <INPUT MAXLENGTH=\"128\" NAME=\"mailer_subject\" SIZE=\"57\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->subject, ENT_QUOTES) . "\">\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORB\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    контрольные адреса:\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "                <TR" . ((MAILER_INVISIBLE_MODE == TRUE) ? " STYLE=\"display: none;\"" : "") . ">\r\n"
           . "                  <TD ALIGN=\"LEFT\" NOWRAP VALIGN=\"TOP\">\r\n"
           . "                    текст письма:\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" COLSPAN=\"3\" NOWRAP ROWSPAN=\"2\">\r\n"
           . "                    <TEXTAREA NAME=\"mailer_body\" ROWS=\"22\" COLS=\"57\">" . htmlspecialchars($this->email_body, ENT_QUOTES) . "</TEXTAREA>\r\n"
           . ((MAILER_VIA_FILES_MODE == TRUE) ? "" : "<TEXTAREA NAME=\"mailer_mails\" STYLE=\"display: none;\">" . htmlspecialchars(implode("\r\n", $mails), ENT_QUOTES) . "</TEXTAREA>\r\n")
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" NOWRAP ROWSPAN=\"2\">\r\n"
           . "                    <TEXTAREA CLASS=\"COLORB\" NAME=\"mailer_control_mail\" ROWS=\"22\" COLS=\"25\">" . htmlspecialchars($this->control_mail, ENT_QUOTES) . "</TEXTAREA>\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "                <TR" . ((MAILER_INVISIBLE_MODE == TRUE) ? " STYLE=\"display: none;\"" : "") . ">\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORB\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    адресованных копий<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"3\" NAME=\"mailer_mailing_addressed_copies\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mailing_addressed_copies, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    скрытых копий<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"3\" NAME=\"mailer_mailing_hidden_copies\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mailing_hidden_copies, ENT_QUOTES) . "\"><BR><BR>\r\n"
           . "                    <INPUT" . $this->mail_via_server_option . " CLASS=\"COLORB\" NAME=\"mailer_mail_via_server\" TYPE=\"CHECKBOX\" VALUE=\"*\"> отправлять не<BR>функциями текущего<BR>сервера, а через<BR>SMTP-сервер:<BR>\r\n"
           . "                    <INPUT CLASS=\"COLORB\" MAXLENGTH=\"75\" NAME=\"mailer_mail_via_server_name\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mail_via_server_name, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    по порту<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"75\" NAME=\"mailer_mail_via_server_port\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mail_via_server_port, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    с логином<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"75\" NAME=\"mailer_mail_via_server_login\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mail_via_server_login, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    и паролем<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"75\" NAME=\"mailer_mail_via_server_password\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"PASSWORD\" VALUE=\"" . htmlspecialchars($this->mail_via_server_password, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    есть смежных логинов<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"2\" NAME=\"mailer_mail_via_server_login_count\" SIZE=\"18\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mail_via_server_login_count, ENT_QUOTES) . "\"><BR>\r\n"
           . "                    <INPUT NAME=\"mailer_mail_via_server_login_number\" TYPE=\"HIDDEN\" VALUE=\"" . htmlspecialchars($this->mail_via_server_login_number, ENT_QUOTES) . "\">\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "                <TR" . ((MAILER_INVISIBLE_MODE == TRUE) ? " STYLE=\"display: none;\"" : "") . ">\r\n"
           . "                  <TD ALIGN=\"LEFT\" NOWRAP>\r\n"
           . "                    скрипт отписки:\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" COLSPAN=\"3\" NOWRAP TITLE=\"Этот параметр опускается, если суммарно адресованных и скрытых копий выходит больше 1\">\r\n"
           . "                    <INPUT MAXLENGTH=\"100\" NAME=\"mailer_script_addr\" SIZE=\"57\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->script_addr, ENT_QUOTES) . "\">\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORR\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    В режиме рестарта скрипта:\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "                <TR>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORB\" NOWRAP STYLE=\"" . ((MAILER_INVISIBLE_MODE == TRUE) ? "display: none; " : "") . "font-size: 8pt;\">\r\n"
           . "                    пауза между<BR>отправкой писем:<BR><INPUT CLASS=\"COLORB\" MAXLENGTH=\"5\" NAME=\"mailer_mailing_pause\" SIZE=\"5\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->mailing_pause, ENT_QUOTES) . "\"> секунд\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"CENTER\" CLASS=\"COLORB\" COLSPAN=\"3\" NOWRAP STYLE=\"font-size: 8pt;\">\r\n"
           . "                    <DIV STYLE=\"border: 0px solid; " . ((MAILER_INVISIBLE_MODE == TRUE) ? "display: none; " : "") . "margin: 0px; padding: 0px; text-indent: 0px;\">\r\n"
           . "                      <INPUT NAME=\"mailer_operation\" TYPE=\"HIDDEN\" VALUE=\"send\">\r\n"
           . "                      <INPUT NAME=\"mailer_pass\" TYPE=\"HIDDEN\" VALUE=\"" . $this->pass . "\">\r\n"
           . "                      <B STYLE=\"font-weight: normal;\" TITLE=\"Эта настройка игнорируется, если суммарно адресованных и скрытых копий выходит больше 1\"><INPUT" . $this->contra_antispam_subject_option . " CLASS=\"COLORB\" NAME=\"mailer_contra_antispam_subject\" TYPE=\"CHECKBOX\" VALUE=\"*\"> персонализовать тему писем для антиспамовых роботов</B><BR>\r\n"
           . "                      <INPUT" . $this->contra_antispam_action_option . " CLASS=\"COLORB\" NAME=\"mailer_contra_antispam_action\" TYPE=\"CHECKBOX\" VALUE=\"*\"> разнообразить буквы текста письма для антиспамовых роботов<BR><BR STYLE=\"font-size: 5pt;\">\r\n"
           . "                    </DIV>\r\n"
           . "                    <INPUT ID=\"MailerMainFormKey\" TYPE=\"SUBMIT\" ONCLICK=\"javascript: if (typeof(Mailer_Start_Continue) != 'undefined') {Mailer_Start_Continue(); return false;} else {return true;}\" VALUE=\"Отправить сообщение\">\r\n"
           . "                  </TD>\r\n"
           . "                  <TD ALIGN=\"LEFT\" CLASS=\"COLORR\" NOWRAP STYLE=\"" . ((MAILER_INVISIBLE_MODE == TRUE) ? "display: none; " : "") . "font-size: 8pt;\" VALIGN=\"TOP\">\r\n"
           . "                    не более <INPUT CLASS=\"COLORR\" MAXLENGTH=\"5\" NAME=\"mailer_continue_step\" SIZE=\"5\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->continue_step, ENT_QUOTES) . "\"> писем за раз<BR>\r\n"
           . "                    и рестарт через <INPUT CLASS=\"COLORR\" MAXLENGTH=\"5\" NAME=\"mailer_continue_pause\" SIZE=\"3\" STYLE=\"font-size: 8pt;\" TYPE=\"TEXT\" VALUE=\"" . htmlspecialchars($this->continue_pause, ENT_QUOTES) . "\"> секунд\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "                <TR>\r\n"
           . "                  <TD COLSPAN=\"5\" STYLE=\"color: #A0A0A0; font-size: 7pt; margin: 0px; padding: 0px; text-align: center;\">\r\n"
           . "                    AIMatrix inetShop &amp; inetGame Engine, Mass Routine mailer, 2009\r\n"
           . "                  </TD>\r\n"
           . "                </TR>\r\n"
           . "              </TABLE>\r\n"
           . "            </FORM>\r\n"
           . "          </TD>\r\n"
           . "        </TR>\r\n"
           . "      </TABLE>\r\n"
           . "    </CENTER>\r\n"
           . "    <CENTER CLASS=\"COLORB\">\r\n"
           . "      Сейчас осталось " . $c . " адресов для рассылки" . (($c2 != 0) ? "<BR>и " . $c2 . " адресов отписавшихся от рассылки" : "") . ".<BR>\r\n"
           . "    </CENTER>\r\n";
    }

    function natural($value) {
      return floor(abs($this->number->floatValue($value)));
    }

    function is_mail_rejected(&$mail, &$rejects) {
      $count = count($rejects);
      $index = 0;
      $rejected_state = FALSE;
      while ($index < $count) {
        $rejected_state = FALSE;
        $mail_record = explode(MAIL_RECORD_FIELDS_DIVIDER, $rejects[$index]);
        $index2 = 0;
        $count2 = count($mail_record);
        while ($index2 < $count2) {
          if (isset($mail_record[$index2]) == TRUE) {
            $data = strtolower(trim($mail_record[$index2]));
            if ($data != "") {
              if (isset($mail[$index2]) == TRUE) {
                if ($mail[$index2] != "") {
                  if ((strpos($data, "**") !== FALSE) || (strpos($data, "*") !== FALSE) || (strpos($data, "#") !== FALSE) || (strpos($data, "$") !== FALSE)) {
                    $data = str_replace("\\", "\\\\", $data);
                    $data = str_replace("[", "\[", $data);
                    $data = str_replace("]", "\]", $data);
                    $data = str_replace("(", "\(", $data);
                    $data = str_replace(")", "\)", $data);
                    $data = str_replace("{", "\{", $data);
                    $data = str_replace("}", "\}", $data);
                    $data = str_replace("+", "\+", $data);
                    $data = str_replace("?", "\?", $data);
                    $data = str_replace("^", "\^", $data);
                    $data = str_replace("-", "\-", $data);
                    $data = str_replace(".", "\\.", $data);
                    $data = str_replace("#", "[0-9]+", $data);
                    $data = str_replace("$", "[a-z]+", $data);
                    $data = str_replace("**", ".+?", $data);
                    $data = str_replace("*", "[a-z0-9\-\._]*?", $data);
                    if (preg_match("'^" . $data . "$'si", $mail[$index2]) == 0) {
                      $rejected_state = FALSE;
                      break;
                    }
                  } else {
                    if ($mail[$index2] != $data) {
                      $rejected_state = FALSE;
                      break;
                    }
                  }
                } else {
                  $rejected_state = FALSE;
                  break;
                }
                $rejected_state = TRUE;
              } else {
                $rejected_state = FALSE;
                break;
              }
            }
          }
          $index2 = $index2 + 1;
        }
        if ($rejected_state == TRUE) break;
        $index = $index + 1;
      }
      return $rejected_state;
    }

    function cheat_antispam_robot($text, $ideal) {
      $result = "";
      $i = 0;
      $c = strlen($text);
      while ($i < $c) {
        $v = substr($text, $i, 1);
        switch ($v) {
          case " ": if (rand(0, 100) >= 70) $v = "  "; break;
          case "А": if (rand(0, 100) >= 50) $v = "A"; break;
          case "В": if (rand(0, 100) >= 50) $v = "B"; break;
          case "Е": if (rand(0, 100) >= 50) $v = "E"; break;
          case "Ё": if (rand(0, 100) >= 50) $v = "E"; break;
          case "З": if (rand(0, 100) >= 50) $v = "3"; break;
          case "К": if (rand(0, 100) >= 50) $v = "K"; break;
          case "М": if (rand(0, 100) >= 50) $v = "M"; break;
          case "Н": if (rand(0, 100) >= 50) $v = "H"; break;
          case "О": if (rand(0, 100) >= 50) $v = "O"; break;
          case "Р": if (rand(0, 100) >= 50) $v = "P"; break;
          case "С": if (rand(0, 100) >= 50) $v = "C"; break;
          case "Т": if (rand(0, 100) >= 50) $v = "T"; break;
          case "У": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "Y"; break;
          case "Х": if (rand(0, 100) >= 50) $v = "X"; break;
          case "Ь": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "b"; break;
          case "а": if (rand(0, 100) >= 50) $v = "a"; break;
          case "б": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "6"; break;
          case "д": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "g"; break;
          case "е": if (rand(0, 100) >= 50) $v = "e"; break;
          case "ё": if (rand(0, 100) >= 50) $v = "e"; break;
          case "и": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "u"; break;
          case "й": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "u"; break;
          case "к": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "k"; break;
          case "о": if (rand(0, 100) >= 50) $v = "o"; break;
          case "п": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "n"; break;
          case "р": if (rand(0, 100) >= 50) $v = "p"; break;
          case "с": if (rand(0, 100) >= 50) $v = "c"; break;
          case "т": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "m"; break;
          case "у": if (rand(0, 100) >= 50) $v = "y"; break;
          case "х": if (rand(0, 100) >= 50) $v = "x"; break;
          case "ь": if ($ideal != TRUE) if (rand(0, 100) >= 50) $v = "b"; break;
        }
        $i = $i + 1;
        $result = $result . $v;
      }
      return $result;
    }

    function spacing_antispam_robot($text, $new_SPACE_symbol, $new_CR_symbol) {
      $c = strlen($text);
      while ($c > 0) {
        $c = $c - 1;
        $s = substr($text, $c, 1);
        if ($s == " ") {
          if (rand(0, 100) >= 50) {
            $s = $new_SPACE_symbol;
            $text = substr($text, 0, $c) . $s . substr($text, $c + 1);
          }
        } else {
          if ($s == "\r") {
            $s = rand(0, 50);
            if ($s > 25) {
              $s = str_repeat(" ", $s - 25) . $new_CR_symbol;
              $text = substr($text, 0, $c) . $s . substr($text, $c + 1);
            }
          }
        }
      }
      return $text;
    }

    function taging_antispam_robot($text) {
      $tags_open = array();
      $tags_close = array();
      $tags_open[] = "";
      $tags_close[] = "";
      $tags_open[] = "<ACRONYM>";
      $tags_close[] = "</ACRONYM>";
      $tags_open[] = "<B>";
      $tags_close[] = "</B>";
      $tags_open[] = "<BIG>";
      $tags_close[] = "</BIG>";
      $tags_open[] = "<CITE>";
      $tags_close[] = "</CITE>";
      $tags_open[] = "<CODE>";
      $tags_close[] = "</CODE>";
      $tags_open[] = "<EM>";
      $tags_close[] = "</EM>";
      $tags_open[] = "<FONT>";
      $tags_close[] = "</FONT>";
      $tags_open[] = "<I>";
      $tags_close[] = "</I>";
      $tags_open[] = "<INS>";
      $tags_close[] = "</INS>";
      $tags_open[] = "<KBD>";
      $tags_close[] = "</KBD>";
      $tags_open[] = "<SAMP>";
      $tags_close[] = "</SAMP>";
      $tags_open[] = "<SMALL>";
      $tags_close[] = "</SMALL>";
      $tags_open[] = "<SPAN>";
      $tags_close[] = "</SPAN>";
      $tags_open[] = "<STRONG>";
      $tags_close[] = "</STRONG>";
      $tags_open[] = "<TT>";
      $tags_close[] = "</TT>";
      $tags_open[] = "<U>";
      $tags_close[] = "</U>";
      $tags_open[] = "<VAR>";
      $tags_close[] = "</VAR>";
      $tags_count = count($tags_open) - 1;
      $c = strlen($text);
      $i = rand(0, intval($c / 4));
      if ($i == 0) $i = 1;
      $cx = intval($c / $i) * 2;
      if ($cx == 0) $cx = 1;
      if ($cx > $c) $cx = $c;
      $j = rand(0, $tags_count);
      $r = "";
      while (($i > 1) && ($c > 0)) {
        $s = rand(1, $cx);
        $j = rand(0, $tags_count);
        $t = substr($text, 0, $s);
        if ((strpos($t, "<") === FALSE) && (strpos($t, ">") === FALSE) && (strpos($t, "\r") === FALSE)) {
          $r = $r . $tags_open[$j] . $t . $tags_close[$j];
        } else {
          $r = $r . $t;
        }
        $text = substr($text, $s);
        $c = $c - $s;
        $i = $i - 1;
      }
      if ((strpos($text, "<") === FALSE) && (strpos($text, ">") === FALSE) && (strpos($text, "\r") === FALSE)) {
        $text = $r . $tags_open[$j] . $text . $tags_close[$j];
      } else {
        $text = $r . $text;
      }
      return $text;
    }

    function send_letter($addressed_mails, $hidden_mails, $subject, $text, $text_ending, $login_number, $abstract_text, $user_data) {
      if ($addressed_mails == $hidden_mails) $hidden_mails = "";
      $headers = "Content-Type: text/html; charset=windows-1251\r\n"
               . "Content-Language: ru\r\n"
               . "Return-Path: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace("*", "", str_replace("$", "", $this->replyemail))) . ">\r\n"
               . "Reply-To: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace("*", "", str_replace("$", "", $this->replyemail))) . ">\r\n"
               . "From: " . @iconv("UTF-8", "Windows-1251//IGNORE", EMAILING_SENDER_PSEUDONAME . " <" . str_replace("*", "", str_replace("$", "", $this->fromemail))) . ">\r\n"
               . "To: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace(", ", ">, <", $addressed_mails)) . ">\r\n";
      if ($hidden_mails != "") $headers = $headers . "Cc: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace(", ", ">, <", $hidden_mails)) . ">\r\n";
      if (($this->mailing_addressed_copies == 1) && ($this->mailing_hidden_copies == 0)) {
        if ($this->contra_antispam_subject == TRUE) $subject = trim(trim($subject) . " " . trim($addressed_mails));
      }
      $htmled = ((strpos($text, "<") !== FALSE) && (strpos($text, ">") !== FALSE));
      if (trim($abstract_text) == "") {
        $abstract_text = "";
      } else {
        $abstract_text = "\r\n" . $abstract_text;
        $i = 40;
        while ($i > 0) {
          $i = $i - 1;
          switch (rand(0, 24)) {
            case 0:  $abstract_text = "- " . $abstract_text; break;
            case 1:  $abstract_text = "= " . $abstract_text; break;
            case 2:  $abstract_text = "* " . $abstract_text; break;
            case 3:  $abstract_text = "~ " . $abstract_text; break;
            case 4:  $abstract_text = "_ " . $abstract_text; break;
            case 5:  $abstract_text = "+ " . $abstract_text; break;
            case 6:  $abstract_text = "# " . $abstract_text; break;
            case 7:  $abstract_text = ". " . $abstract_text; break;
            case 8:  $abstract_text = ", " . $abstract_text; break;
            case 9:  $abstract_text = ": " . $abstract_text; break;
            case 10: $abstract_text = "; " . $abstract_text; break;
            case 11: $abstract_text = "' " . $abstract_text; break;
            case 12: $abstract_text = "\" " . $abstract_text; break;
            case 13: $abstract_text = "/ " . $abstract_text; break;
            case 14: $abstract_text = "\\ " . $abstract_text; break;
            case 15: $abstract_text = "[ " . $abstract_text; break;
            case 16: $abstract_text = "] " . $abstract_text; break;
            case 17: $abstract_text = "( " . $abstract_text; break;
            case 18: $abstract_text = ") " . $abstract_text; break;
            case 19: $abstract_text = "! " . $abstract_text; break;
            case 20: $abstract_text = "| " . $abstract_text; break;
            case 21: $abstract_text = "? " . $abstract_text; break;
            case 22: $abstract_text = "{ " . $abstract_text; break;
            case 23: $abstract_text = "} " . $abstract_text; break;
            case 24: $abstract_text = "% " . $abstract_text; break;
          }
        }
        $abstract_text = "\r\n" . str_replace("\r\n", "<BR>", "<BR><BR><BR><BR>" . $abstract_text);
      }
      if (trim(EMAILING_DONT_ABSTRACTING_MARKER) != "") {
        if (strpos(strtolower($text), strtolower(trim(EMAILING_DONT_ABSTRACTING_MARKER))) !== FALSE) {
          $abstract_text = "";
          $text = str_ireplace(trim(EMAILING_DONT_ABSTRACTING_MARKER), "", $text);
        }
      }
      $this->send_client_ip_enable = FALSE;
      if (trim(EMAILING_SEND_USER_IP_MARKER) != "") {
        if (strpos(strtolower($text), strtolower(trim(EMAILING_SEND_USER_IP_MARKER))) !== FALSE) {
          $this->send_client_ip_enable = TRUE;
          $text = str_ireplace(trim(EMAILING_SEND_USER_IP_MARKER), "", $text);
        }
      }
      $text = str_replace("\n", "\r", str_replace("\r\n", "\r", $text . $text_ending . $abstract_text));
      if (trim(EMAIL_INSERTION_MARKER) != "") {
        $subject = str_replace(strtolower(trim(EMAIL_INSERTION_MARKER)), trim($addressed_mails), $subject);
        $text = str_replace(strtolower(trim(EMAIL_INSERTION_MARKER)), trim($addressed_mails), $text);
      }
      if (trim(EMAILLOGIN_INSERTION_MARKER) != "") {
        $login = strpos($addressed_mails, "@");
        if ($login !== FALSE) {
          $login = trim(substr($addressed_mails, 0, $login));
        } else {
          $login = "";
        }
        $subject = str_replace(strtolower(trim(EMAILLOGIN_INSERTION_MARKER)), $login, $subject);
        $text = str_replace(strtolower(trim(EMAILLOGIN_INSERTION_MARKER)), $login, $text);
      }
      if (trim(EMAILUSERNAME_INSERTION_MARKER) != "") {
        $username = trim($user_data[field_MailUserName]);
        if ($username == "") {
          $username = strpos($addressed_mails, "@");
          if ($username !== FALSE) {
            $username = trim(substr($addressed_mails, 0, $username));
            $username = str_replace(".", " ", $username);
            $username = str_replace("_", " ", $username);
            $username = str_replace("-", " ", $username);
            $username = ucwords($username);
          } else {
            $username = "";
          }
        }
        if (strlen($username) > EMAILUSERNAME_INSERTION_MAXSIZE) $username = substr(trim($username), 0, EMAILUSERNAME_INSERTION_MAXSIZE) . "...";
        $subject = str_replace(strtolower(trim(EMAILUSERNAME_INSERTION_MARKER)), $username, $subject);
        $text = str_replace(strtolower(trim(EMAILUSERNAME_INSERTION_MARKER)), $username, $text);
      }
      if (trim(EMAILUSERBIRTHDAY_INSERTION_MARKER) != "") {
        $subject = str_replace(strtolower(trim(EMAILUSERBIRTHDAY_INSERTION_MARKER)), trim($user_data[field_MailUserBirthday]), $subject);
        $text = str_replace(strtolower(trim(EMAILUSERBIRTHDAY_INSERTION_MARKER)), trim($user_data[field_MailUserBirthday]), $text);
      }
      if (trim(EMAILUSERCOUNTRY_INSERTION_MARKER) != "") {
        $subject = str_replace(strtolower(trim(EMAILUSERCOUNTRY_INSERTION_MARKER)), trim($user_data[field_MailUserCountry]), $subject);
        $text = str_replace(strtolower(trim(EMAILUSERCOUNTRY_INSERTION_MARKER)), trim($user_data[field_MailUserCountry]), $text);
      }
      if (trim(EMAILUSERTOWN_INSERTION_MARKER) != "") {
        $subject = str_replace(strtolower(trim(EMAILUSERTOWN_INSERTION_MARKER)), trim($user_data[field_MailUserTown]), $subject);
        $text = str_replace(strtolower(trim(EMAILUSERTOWN_INSERTION_MARKER)), trim($user_data[field_MailUserTown]), $text);
      }
      if ($this->contra_antispam_action == TRUE) {
        $taging_antispam_enable = TRUE;
        if (trim(EMAILING_DONT_TAGING_ANTISPAM_MARKER) != "") {
          if (strpos(strtolower($text), strtolower(trim(EMAILING_DONT_TAGING_ANTISPAM_MARKER))) !== FALSE) {
            $taging_antispam_enable = FALSE;
            $text = str_ireplace(trim(EMAILING_DONT_TAGING_ANTISPAM_MARKER), "", $text);
          }
        }
        $ideal_cheat_antispam_enable = TRUE;
        if (trim(EMAILING_NOT_IDEAL_CHEAT_ANTISPAM_MARKER) != "") {
          if (strpos(strtolower($text), strtolower(trim(EMAILING_NOT_IDEAL_CHEAT_ANTISPAM_MARKER))) !== FALSE) {
            $ideal_cheat_antispam_enable = FALSE;
            $text = str_ireplace(trim(EMAILING_NOT_IDEAL_CHEAT_ANTISPAM_MARKER), "", $text);
          }
        }
        $subject = $this->cheat_antispam_robot($subject, $ideal_cheat_antispam_enable);
        if ($taging_antispam_enable == TRUE) $subject = $this->spacing_antispam_robot($subject, ". ", "");
        $text = $this->cheat_antispam_robot($text, $ideal_cheat_antispam_enable);
        $text = explode("\r", $text);
        if ($taging_antispam_enable == TRUE)  {
          $i = count($text);
          while ($i > 0) {
            $i = $i - 1;
            if (strpos($text[$i], "<") === FALSE) {
              $text[$i] = $this->taging_antispam_robot($text[$i]);
              $text[$i] = $this->spacing_antispam_robot($text[$i] . "\r", "&nbsp;", "");
            }
          }
        }
        $text = implode((($htmled == TRUE) ? "" : "<BR>") . "\r\n", $text);
      } else {
        $text = str_replace("\r", (($htmled == TRUE) ? "" : "<BR>") . "\r\n", $text);
      }
      if ($htmled == TRUE) {
        $text = "<STYLE>\r\n"
              . "  acronym, b, big, body, cite, code, em, font, i, ins, kbd, samp, small, span, strong, tt, u, var {border: 0px solid; color: #000000; font-family: Verdana, Tahoma, Arial, Courier New; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; margin: 0px; padding: 0px; text-decoration: none;}\r\n"
              . "  body {color: #000000; font-family: Verdana, Tahoma, Arial, Courier New; font-size: 10pt; margin: 10px; padding: 10px;}\r\n"
              . "  td {color: #000000; font-family: Verdana, Tahoma, Arial, Courier New; font-size: 10pt; margin: 0px; padding: 0px;}\r\n"
              . "</STYLE>\r\n" . $text;
      }
      $subject = @iconv("UTF-8", "Windows-1251//IGNORE", $subject);
      $text = @iconv("UTF-8", "Windows-1251//IGNORE", $text);
      if (($this->mail_via_server == TRUE) && ($this->mail_via_server_name != "") && ($this->mail_via_server_port >= 0)
      && ($this->mail_via_server_login != "") && ($this->mail_via_server_password != "")) {
        return $this->send_letter_by_SMTP($addressed_mails, $hidden_mails, $subject, $text, "", $login_number, $this->text_jpegs);
      } else {
        return ((@mail($addressed_mails, $subject, $text, $headers) == TRUE) ? "OK1" : "BAD1");
      }
    }

    function send_control_letters($n, $o, $l, $s, $t, $e, $abstract_text, $user_data) {
      $result = "";
      $v = "Это контроль рассылки: обработано писем " . $this->finished_count . " (пакет " . ($n - $o + 1) . "-" . $n . "), из них " . $this->finished_error_count . " с ошибкой";
      $c = count($l);
      $i = 0;
      while ($i < $c) {
        $l[$i] = trim($l[$i]);
        if (ereg("(<[^>]+>\s+)?([_\.0-9A-Za-z-]+)@([0-9A-Za-z][-0-9A-Za-z\.]*)\.([A-Za-z]{2,4})$", $l[$i]) == TRUE) {
          $j = strpos($l[$i], ">");
          if ($j !== FALSE) $l[$i] = trim(substr($l[$i], $j + 1));
          $result .= "    <B STYLE=\"color: #00A000;\">... " . $l[$i] . " ...</B><BR>\r\n";
          $this->set_execution_time_limit();
          $this->send_letter($l[$i], "", $v, $v, "\r\n", 1, "", $user_data);
          if ($this->mailing_pause > 0) sleep($this->mailing_pause);
          $this->set_execution_time_limit();
          $this->send_letter($l[$i], "", $s, $t, $e . $l[$i] . "\r\n", 1, $abstract_text, $user_data);
          if ($this->mailing_pause > 0) sleep($this->mailing_pause);
        }
        $i = $i + 1;
      }
      return $result;
    }

    function set_execution_time_limit() {
      $t = $this->continue_pause + 5;
      $t2 = $this->mailing_pause + 5;
      if ($t < $t2) $t = $t2;
      if ($t < MALFUNCTION_TIMEOUT) $t = MALFUNCTION_TIMEOUT;
      @set_time_limit($t);
    }

    function send_letter_by_SMTP($addressed_mails, $hidden_mails, $subject, $text, $headers, $login_number, &$text_jpegs) {
      if ($login_number > $this->mail_via_server_login_count) $login_number = $this->mail_via_server_login_count;
      if ($this->mail_via_server_login_count < 2) $login_number = "";
      if ((strpos($this->fromemail, "*") !== FALSE) || (strpos($this->fromemail, "$") !== FALSE)) {
        $current_fromemail = str_replace("*", $login_number, str_replace("$", chr(97 + $login_number - 1), $this->fromemail));
      } else {
        $current_fromemail = explode("@", $this->fromemail);
        if (count($current_fromemail) > 1) {
          if ($this->mail_via_server_login_count > 1) {
            $j = explode("@", $this->mail_via_server_login);
            if ((strpos($this->mail_via_server_login, "*") !== FALSE) || (strpos($this->mail_via_server_login, "$") !== FALSE)) {
              $current_fromemail = str_replace("*", $login_number, str_replace("$", chr(97 + $login_number - 1), $j[0])) . "@" . $current_fromemail[1];
            } else {
              $current_fromemail = $j[0] . $login_number . "@" . $current_fromemail[1];
            }
          } else {
            $current_fromemail = $this->fromemail;
          }
        } else {
          $current_fromemail = $this->fromemail;
        }
      }
      $r = "Date: " . date("D, d M Y H:i:s") . " UT\r\n"
         . "Subject: =?Windows-1251?B?" . base64_encode($subject) . "=?=\r\n";
      $bound = "";
      if ($headers != "") {
        $r = $r . $headers . "\r\n\r\n";
      } else {
        $r .= "Return-Path: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace("*", $login_number, str_replace("$", chr(97 + $login_number - 1), $this->replyemail))) . ">\r\n"
            . "Reply-To: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace("*", $login_number, str_replace("$", chr(97 + $login_number - 1), $this->replyemail))) . ">\r\n"
            . "MIME-Version: 1.0\r\n"
            . "From: " . @iconv("UTF-8", "Windows-1251//IGNORE", EMAILING_SENDER_PSEUDONAME . " <" . str_replace("*", $login_number, str_replace("$", chr(97 + $login_number - 1), $this->fromemail))) . ">\r\n"
            . "To: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace(", ", ">, <", $addressed_mails)) . ">\r\n";
        if ($hidden_mails != "") $r .= "Cc: <" . @iconv("UTF-8", "Windows-1251//IGNORE", str_replace(", ", ">, <", $hidden_mails)) . ">\r\n";
        $r .= "X-Priority: 3\r\n";
        if (isset($text_jpegs) == TRUE) {
          if (is_array($text_jpegs) == TRUE) {
            if (count($text_jpegs) > 0) {
              $bound = "_----------=_letterbody";
              $r .= "Content-Transfer-Encoding: 8bit\r\n"
                  . "Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"" . $bound . "\"\r\n\r\n";
              $bound = "--" . $bound;
            }
          }
        }
      }
      if ($bound != "") {
        $r .= $bound . "\r\n"
            . "Content-Type: multipart/alternative; boundary=\"" . $bound . "-text\"\r\n\r\n"
            . "--" . $bound . "-text\r\n";
      }
      $r .= "Content-Transfer-Encoding: 8bit\r\n"
          . "Content-Type: text/html; charset=\"Windows-1251\"\r\n\r\n";
      if (strpos($text, "\r") === FALSE) {
        $r .= str_ireplace("<BR>", "\r\n", $text) . "\r\n";
      } else {
        $r .= $text . "\r\n";
      }
      if ($bound != "") {
        $r .= "--" . $bound . "-text--\r\n\r\n"
            . $bound . "\r\n";
      }
      if (isset($text_jpegs) == TRUE) {
        if (is_array($text_jpegs) == TRUE) {
          $p = count($text_jpegs);
          while ($p > 0) {
            $r .= "Content-Transfer-Encoding: base64\r\n";
            $j = $text_jpegs[$p - 1];
            switch(strtolower(substr($j, strlen($j) - 4))) {
              case ".gif":
                $r .= "Content-Type: image/gif; name=\"" . $p . ".gif\"\r\n"; break;
              case ".png":
                $r .= "Content-Type: image/png; name=\"" . $p . ".png\"\r\n"; break;
              case ".jpg":
              default:
                $r .= "Content-Type: image/jpeg; name=\"" . $p . ".jpg\"\r\n";
            }
            $r .= "Content-ID: <object_" . $p . ">\r\n\r\n"
                . base64_encode(@file_get_contents($j)) . "\r\n\r\n"
                . $bound . (($p < 2) ? "--" : "") . "\r\n";
            $p = $p - 1;
          }
        }
      }
      if (!$p = @fsockopen($this->mail_via_server_name, $this->mail_via_server_port, $en, $es, REMOTE_FILE_OPENING_TIMEOUT)) return "BAD2 no connection";
      $answer_text = "";
      if ($this->get_smtp_answer($p, "220", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 no dialog: " . str_replace("\r\n", "|", $answer_text);
      }
      @fputs($p, "HELO " . (($this->send_client_ip_enable == TRUE) ? $this->user_ip : $this->mail_via_server_name) . "\r\n");
      if ($this->get_smtp_answer($p, "250", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 no answer for HELO command: " . str_replace("\r\n", "|", $answer_text);
      }
      @fputs($p, "AUTH LOGIN\r\n");
      if ($this->get_smtp_answer($p, "334", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 no answer for authorization: " . str_replace("\r\n", "|", $answer_text);
      }
      if ((strpos($this->mail_via_server_login, "*") !== FALSE) || (strpos($this->mail_via_server_login, "$") !== FALSE)) {
        $j = str_replace("*", $login_number, str_replace("$", chr(97 + $login_number - 1), $this->mail_via_server_login));
      } else {
        if (strpos($this->mail_via_server_login, "@") !== FALSE) {
          $j = str_replace("@", $login_number . "@", $this->mail_via_server_login);
        } else {
          $j = $this->mail_via_server_login . $login_number;
        }
      }
      @fputs($p, base64_encode($j) . "\r\n");
      if ($this->get_smtp_answer($p, "334", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 invalid user login: " . str_replace("\r\n", "|", $answer_text);
      }
      @fputs($p, base64_encode($this->mail_via_server_password) . "\r\n");
      if ($this->get_smtp_answer($p, "235", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 invalid password: " . str_replace("\r\n", "|", $answer_text);
      }
      @fputs($p, "MAIL FROM: <" . $current_fromemail . ">\r\n");
      if ($this->get_smtp_answer($p, "250", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 no answer for MAIL FROM command: " . str_replace("\r\n", "|", $answer_text);
      }
      $j = FALSE;
      $addressed_mails = explode(",", $addressed_mails);
      $i = 0;
      $c = count($addressed_mails);
      while ($i < $c) {
        $addressed_mails[$i] = trim($addressed_mails[$i]);
        if ($addressed_mails[$i] != "") {
          fputs($p, "RCPT TO: <" . $addressed_mails[$i] . ">\r\n");
          $j = $j || ($this->get_smtp_answer($p, "250", $answer_text) == TRUE);
        }
        $i = $i + 1;
      }
      $hidden_mails = explode(",", $hidden_mails);
      $i = 0;
      $c = count($hidden_mails);
      while ($i < $c) {
        $hidden_mails[$i] = trim($hidden_mails[$i]);
        if ($hidden_mails[$i] != "") {
          fputs($p, "RCPT TO: <" . $hidden_mails[$i] . ">\r\n");
          $j = $j || ($this->get_smtp_answer($p, "250", $answer_text) == TRUE);
        }
        $i = $i + 1;
      }
      if ($j != TRUE) {
        @fclose($p);
        return "BAD2 no answer for RCPT TO command";
      }
      @fputs($p, "DATA\r\n");
      if ($this->get_smtp_answer($p, "354", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 no answer for DATA command: " . str_replace("\r\n", "|", $answer_text);
      }
      @fputs($p, $r . "\r\n.\r\n");
      if ($this->get_smtp_answer($p, "250", $answer_text) != TRUE) {
        @fclose($p);
        return "BAD2 mailing error: " . str_replace("\r\n", "|", $answer_text);
      }
      @fputs($p, "QUIT\r\n");
      @fclose($p);
      return "OK2";
    }

    function get_smtp_answer($socket_handle, $answer_code, &$answer_text) {
      $answer_text = "";
      $empty_line_count = 0;
      while (($answer_line = fgets($socket_handle, 65536)) !== FALSE) {
        $answer_line = trim($answer_line);
        if ($answer_line == "") {
          $empty_line_count = $empty_line_count + 1;
          if ($empty_line_count > 5) break;
        }
        if (trim(substr($answer_line, 0, strlen($answer_code) + 1)) == $answer_code) {
          $answer_text = "";
          return TRUE;
        }
        $answer_text = $answer_text . "\r\n" . $answer_line;
      }
      return FALSE;
    }

    function purge_maillist($list_filename, $new_list_filename) {
      $v = array();
      $h = @fopen($list_filename, "rb");
      if ($h != FALSE) {
        while (@feof($h) == FALSE) {
          $s = trim(@fgets($h, 65536));
          if (ereg("^[_\.0-9A-Za-z-]+@[0-9A-Za-z][-0-9A-Za-z\.]*\.[A-Za-z]{2,4}$", $s) == TRUE) {
            $v[] = strtolower($s);
          }
        }
        @fclose($h);
        sort($v, SORT_STRING);
        $h = @fopen($new_list_filename, "wb");
        if ($h != FALSE) {
          $s = "";
          $i = 0;
          $c = count($v);
          while ($i < $c) {
            if ($s != $v[$i]) {
              $s = $v[$i];
              @fwrite($h, $s . "\r\n");
            }
            $i = $i + 1;
          }
          @fclose($h);
          $result = "Ok";
        } else {
          $result = "Bad writing";
        }
      } else {
        $result = "Bad opening";
      }
      return $result;
    }

    function filter_maillist($list_filename, $new_list_filename, $mail_server) {
      $v = array();
      $h = @fopen($list_filename, "rb");
      if ($h != FALSE) {
        $m = "@" . $mail_server;
        $ml = strlen($m);
        while (feof($h) == FALSE) {
          $s = trim(fgets($h, 65536));
          if (strtolower(substr($s, strlen($s) - $ml)) == $m) {
            $v[] = strtolower($s);
          }
        }
        @fclose($h);
        sort($v, SORT_STRING);
        $h = @fopen($new_list_filename, "wb");
        if ($h != FALSE) {
          $s = "";
          $i = 0;
          $c = count($v);
          while ($i < $c) {
            if ($s != $v[$i]) {
              $s = $v[$i];
              @fwrite($h, $s . "\r\n");
            }
            $i = $i + 1;
          }
          @fclose($h);
          $result = "Ok";
        } else {
          $result = "Bad writing";
        }
      } else {
        $result = "Bad opening";
      }
      return $result;
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
            $this->title = 'Рассылка';
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('Error', $this->error_msg);
            $this->smarty->assign('Message', $this->message);
            $this->body = $this->smarty->fetch('admin_mailer.htm');
            return TRUE;
        }
    }



  return;
?>