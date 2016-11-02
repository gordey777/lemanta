<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    class User extends Basic {

        public $user = null;



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
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
            $this->add_param('page');
            $this->add_param('group_id');
            $this->prepare();
        }



    function prepare() {
      $this->error_msg = '';
      $user_id = $this->param('item_id');
      $query = "SELECT * "
             . "FROM " . DATABASE_USERS_TABLENAME . " "
             . "WHERE user_id = '" . $this->db->query_value($user_id) . "' "
             . "LIMIT 1;";
      $this->db->query($query);
      $this->user = $this->db->result();
      $this->db->users->unpack($this->user);
      if (empty($this->user) == FALSE) {
        if (isset($_POST["name"]) == TRUE) {
          $this->check_token();
          $this->user->name = ""; if (isset($_POST["name"]) == TRUE) $this->user->name = trim($_POST["name"]);
          $this->user->name2 = ""; if (isset($_POST["name2"]) == TRUE) $this->user->name2 = trim($_POST["name2"]);
          $this->user->name3 = ""; if (isset($_POST["name3"]) == TRUE) $this->user->name3 = trim($_POST["name3"]);
          $this->user->email = ""; if (isset($_POST["email"]) == TRUE) $this->user->email = trim($_POST["email"]);
          $this->user->email2 = ""; if (isset($_POST["email2"]) == TRUE) $this->user->email2 = trim($_POST["email2"]);
          $this->user->phone = ""; if (isset($_POST["phone"]) == TRUE) $this->user->phone = trim($_POST["phone"]);
          $this->user->phone2 = ""; if (isset($_POST["phone2"]) == TRUE) $this->user->phone2 = trim($_POST["phone2"]);
          $this->user->address = ""; if (isset($_POST["address"]) == TRUE) $this->user->address = trim($_POST["address"]);
          $this->user->address_2 = ""; if (isset($_POST["address_2"]) == TRUE) $this->user->address_2 = trim($_POST["address_2"]);
          $this->user->address_3 = ""; if (isset($_POST["address_3"]) == TRUE) $this->user->address_3 = trim($_POST["address_3"]);
          $this->user->address_4 = ""; if (isset($_POST["address_4"]) == TRUE) $this->user->address_4 = trim($_POST["address_4"]);
          $this->user->address_5 = ""; if (isset($_POST["address_5"]) == TRUE) $this->user->address_5 = trim($_POST["address_5"]);
          $this->user->address_6 = ""; if (isset($_POST["address_6"]) == TRUE) $this->user->address_6 = trim($_POST["address_6"]);
          $this->user->address_7 = ""; if (isset($_POST["address_7"]) == TRUE) $this->user->address_7 = trim($_POST["address_7"]);
          $this->user->address_8 = ""; if (isset($_POST["address_8"]) == TRUE) $this->user->address_8 = trim($_POST["address_8"]);
          $this->user->address_9 = ""; if (isset($_POST["address_9"]) == TRUE) $this->user->address_9 = trim($_POST["address_9"]);
          $this->user->address_10 = ""; if (isset($_POST["address_10"]) == TRUE) $this->user->address_10 = trim($_POST["address_10"]);
          $this->user->address2 = ""; if (isset($_POST["address2"]) == TRUE) $this->user->address2 = trim($_POST["address2"]);
          $this->user->address2_2 = ""; if (isset($_POST["address2_2"]) == TRUE) $this->user->address2_2 = trim($_POST["address2_2"]);
          $this->user->address2_3 = ""; if (isset($_POST["address2_3"]) == TRUE) $this->user->address2_3 = trim($_POST["address2_3"]);
          $this->user->address2_4 = ""; if (isset($_POST["address2_4"]) == TRUE) $this->user->address2_4 = trim($_POST["address2_4"]);
          $this->user->address2_5 = ""; if (isset($_POST["address2_5"]) == TRUE) $this->user->address2_5 = trim($_POST["address2_5"]);
          $this->user->address2_6 = ""; if (isset($_POST["address2_6"]) == TRUE) $this->user->address2_6 = trim($_POST["address2_6"]);
          $this->user->address2_7 = ""; if (isset($_POST["address2_7"]) == TRUE) $this->user->address2_7 = trim($_POST["address2_7"]);
          $this->user->address2_8 = ""; if (isset($_POST["address2_8"]) == TRUE) $this->user->address2_8 = trim($_POST["address2_8"]);
          $this->user->address2_9 = ""; if (isset($_POST["address2_9"]) == TRUE) $this->user->address2_9 = trim($_POST["address2_9"]);
          $this->user->address2_10 = ""; if (isset($_POST["address2_10"]) == TRUE) $this->user->address2_10 = trim($_POST["address2_10"]);
          $this->user->card_num = ""; if (isset($_POST["card_num"]) == TRUE) $this->user->card_num = trim($_POST["card_num"]);
          $this->user->remark = ""; if (isset($_POST["remark"]) == TRUE) $this->user->remark = trim($_POST["remark"]);
          $this->user->group_id = 0; if (isset($_POST["group_id"]) == TRUE) $this->user->group_id = trim($_POST["group_id"]);
          $this->user->price_id = isset($_POST['price_id']) ? intval($_POST['price_id']) : 0;
          $this->user->enabled = 0; if ((isset($_POST["enabled"]) == TRUE) && ($_POST["enabled"] == "1")) $this->user->enabled = 1;
          $this->user->subdomain_enabled = 0; if ((isset($_POST["subdomain_enabled"]) == TRUE) && ($_POST["subdomain_enabled"] == "1")) $this->user->subdomain_enabled = 1;
          $this->user->subdomain = ""; if (isset($_POST["subdomain"]) == TRUE) $this->user->subdomain = trim($_POST["subdomain"]);
          $this->user->subdomain_html = ""; if (isset($_POST["subdomain_html"]) == TRUE) $this->user->subdomain_html = trim($_POST["subdomain_html"]);
          $this->user->juridical = 0; if ((isset($_POST["juridical"]) == TRUE) && ($_POST["juridical"] == "1")) $this->user->juridical = 1;
          $this->user->juridicaladdress = ""; if (isset($_POST["juridicaladdress"]) == TRUE) $this->user->juridicaladdress = trim($_POST["juridicaladdress"]);
          $this->user->fiscalnum = ""; if (isset($_POST["fiscalnum"]) == TRUE) $this->user->fiscalnum = trim($_POST["fiscalnum"]);
          $this->user->bank = ""; if (isset($_POST["bank"]) == TRUE) $this->user->bank = trim($_POST["bank"]);
          $this->user->bankaccount = ""; if (isset($_POST["bankaccount"]) == TRUE) $this->user->bankaccount = trim($_POST["bankaccount"]);
          $this->user->bankmfo = ""; if (isset($_POST["bankmfo"]) == TRUE) $this->user->bankmfo = trim($_POST["bankmfo"]);
          $this->user->bankokpo = ""; if (isset($_POST["bankokpo"]) == TRUE) $this->user->bankokpo = trim($_POST["bankokpo"]);
          $this->user->affiliate_id = 0; if (isset($_POST["affiliate_id"]) == TRUE) $this->user->affiliate_id = trim($_POST["affiliate_id"]);
          if (isset($_POST["cash_charge_sum"]) == TRUE) {
            $rate = $this->any->currency->rate();
            $charge_sum = round($this->number->floatValue($_POST["cash_charge_sum"]) * $rate, 2);
            $charge_comment = ""; if (isset($_POST["cash_charge_comment"]) == TRUE) $charge_comment = trim($_POST["cash_charge_comment"]);
            $this->registrar->chargeUserCash($this->user, $charge_sum, $charge_comment);
          }
          if (($this->user->name == "") && ($this->user->name2 == "") && ($this->user->name3 == "")) {
            if ($this->error_msg != "") $this->error_msg .= "<br><br>";
            $this->error_msg .= "Нужно обязательно указать имя пользователя!";
          }
          if ((($this->user->email != "") && (preg_match(EMAIL_CHECKING_PATTERN, $this->user->email) == FALSE))
          || (($this->user->email2 != "") && (preg_match(EMAIL_CHECKING_PATTERN, $this->user->email2) == FALSE))) {
            if ($this->error_msg != "") $this->error_msg .= "<br><br>";
            $this->error_msg .= "Е-мейл должен быть указан в формате aaa@bbb.ccc!";
          } else {
            if ($this->user->email != "") {
              $query = "SELECT * "
                     . "FROM " . DATABASE_USERS_TABLENAME . " "
                     . "WHERE user_id != '" . $this->db->query_value($this->user->user_id) . "' "
                           . "AND (email = '" . $this->db->query_value($this->user->email) . "' OR email2 = '" . $this->db->query_value($this->user->email) . "') "
                     . "LIMIT 1;";
              $this->db->query($query);
              $item = $this->db->result();
              if (empty($item) == FALSE) {
                if ($this->error_msg != "") $this->error_msg .= "<br><br>";
                $this->error_msg .= "Е-мейл " . $this->user->email . " уже используется другим пользователем сайта!";
              }
            }
            if ($this->user->email2 != "") {
              $query = "SELECT * "
                     . "FROM " . DATABASE_USERS_TABLENAME . " "
                     . "WHERE user_id != '" . $this->db->query_value($this->user->user_id) . "' "
                           . "AND (email = '" . $this->db->query_value($this->user->email2) . "' OR email2 = '" . $this->db->query_value($this->user->email2) . "') "
                     . "LIMIT 1;";
              $this->db->query($query);
              $item = $this->db->result();
              if (empty($item) == FALSE) {
                if ($this->error_msg != "") $this->error_msg .= "<br><br>";
                $this->error_msg .= "Е-мейл " . $this->user->email2 . " уже используется другим пользователем сайта!";
              }
            }
          }
          while (substr($this->user->subdomain, 0, 1) == ".") $this->user->subdomain = trim(substr($this->user->subdomain, 1));
          while (substr($this->user->subdomain, -1) == ".") $this->user->subdomain = trim(substr($this->user->subdomain, 0, -1));
          while (strpos($this->user->subdomain, "..") !== FALSE) $this->user->subdomain = str_replace("..", ".", $this->user->subdomain);
          if (($this->user->subdomain != "") && (preg_match("/[^a-z0-9\-\.]/i", $this->user->subdomain) != FALSE)) {
            if ($this->error_msg != "") $this->error_msg .= "<br><br>";
            $this->error_msg .= "Имя субдомена может состоять только из символов: точка, дефис (тире), цифры, буквы английского алфавита!";
          } else {
            if ($this->user->subdomain != "") {
              $this->db->get_subdomain_using($item, $this->user->subdomain, $this->user->user_id, CHECK_SUBDOMAIN_USING_MODE_BY_USERID);
              if (empty($item) == FALSE) {
                if ($this->error_msg != "") $this->error_msg .= "<br><br>";
                if (is_null($item->brand_id) == FALSE) {
                  $this->error_msg .= "Такое имя субдомена уже используется для <a href=\"index.php?section=Brand&item_id=" . $item->brand_id . "&token=" . $this->token . "\">этого бренда</a>!";
                } else {
                  if (!is_null($item->category_id)) {
                    $this->error_msg .= "Такое имя субдомена уже используется для <a href=\"index.php?section=Category&item_id=" . $item->category_id . "&token=" . $this->token . "\">этой категории</a>!";
                  } else {
                    if (!is_null($item->product_id)) {
                      $this->error_msg .= "Такое имя субдомена уже используется для <a href=\"index.php?section=Product&item_id=" . $item->product_id . "&token=" . $this->token . "\">этого товара</a>!";
                    } else {
                        if (!is_null($item->user_id)) {
                            $this->error_msg .= 'Такое имя субдомена уже используется для <a href="index.php?section=User&user_id=' . $item->user_id . '&token=' . $this->token . '">другого пользователя</a>!';
                        } else {
                            $this->error_msg .= 'Такое имя субдомена уже используется для другой страницы сайта!';
                        }
                    }
                  }
                }
              }
            }
          }
          if (strlen($this->user->subdomain_html) > 65535) {
              if ($this->error_msg != '') $this->error_msg .= '<br><br>';
              $this->error_msg .= 'Текст html-страницы слишком большой. Он не может содержать более 65535 символов!';
          }
          if (($this->user->affiliate_id != 0) && ($this->user->affiliate_id == $this->user->user_id)) {
              if ($this->error_msg != '') $this->error_msg .= '<br><br>';
              $this->error_msg .= 'Нельзя указывать вариант, когда пользователь привёл сам себя!';
          }
          if ($this->error_msg == '') {
unset($this->user->grades);
unset($this->user->images);
unset($this->user->images_alts);
unset($this->user->images_texts);
unset($this->user->images_view);
            $this->db->users->update($this->user);
            if ($this->user->group_id == $this->param('group_id')) {
              $get = $this->form_get(array('section' => 'Users',
                                           'group' => $this->user->group_id,
                                           'page' => $this->param('page'),
                                           'keyword' => $this->param('keyword')));
            } else {
              $get = $this->form_get(array('section' => 'Users',
                                           'group' => $this->user->group_id,
                                           'keyword' => $this->param('keyword')));
            }
            header('Location: index.php' . $get);
          }
        }
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

            $this->title = 'Редактирование пользователя';

            $this->user->compound_name = $this->db->users->compoundUserName($this->user);
            $this->user->compound_address = $this->db->users->compoundUserAddress($this->user);
            $this->user->compound_address2 = $this->db->users->compoundUserAddress($this->user, '2');

            $groups = null;
            $this->db->get_groups_array($groups, GET_GROUPS_MODE_FOR_AUTHORIZED);

            $query = 'SELECT * '
                   . 'FROM `' . DATABASE_USERS_TABLENAME . '` '
                   . 'ORDER BY `name` ASC, '
                            . '`user_id` DESC;';
            $this->db->query($query);
            $users = $this->db->results();
            foreach ($users as & $user) {
                $this->db->users->unpackUserName($user);
                $this->db->users->unpackUserAddress($user);
                $this->db->users->unpackUserAddress($user, '2');
            }

            $this->smarty->assignByRef('Groups', $groups);
            $this->smarty->assignByRef('User', $this->user);
            $this->smarty->assignByRef('all_users', $users);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('Error', $this->error_msg);

            $this->body = $this->smarty->fetch('admin_user.htm');
            return TRUE;
        }
    }



    return;
?>