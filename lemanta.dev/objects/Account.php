<?php
  if (defined("ROOT_FOLDER_REFERENCE") == FALSE) return;
  if (defined("FOLDERNAME_FOR_ENGINE_OBJECTS") == FALSE) return;
  if (defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT") == FALSE) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/product/Product.php');

    class ClientAccount extends Basic {

        private $salt = 'imperacms';

        public $pattern_email = '';
        public $card_num = '';
        public $name = '';
        public $name2 = '';
        public $name3 = '';
        public $email = '';
        public $email2 = '';
        public $address = '';
        public $address_2 = '';
        public $address_3 = '';
        public $address_4 = '';
        public $address_5 = '';
        public $address_6 = '';
        public $address_7 = '';
        public $address_8 = '';
        public $address_9 = '';
        public $address_10 = '';
        public $address2 = '';
        public $address2_2 = '';
        public $address2_3 = '';
        public $address2_4 = '';
        public $address2_5 = '';
        public $address2_6 = '';
        public $address2_7 = '';
        public $address2_8 = '';
        public $address2_9 = '';
        public $address2_10 = '';
        public $remark = '';
        public $password = '';
        public $module_name = 'AIMatrix Account Advanced module';



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
        parent::__construct($parent);
        $this->prepare();
    }



    function prepare() {
      $this->pattern_email = EMAIL_CHECKING_PATTERN;
      if (empty($this->user)) $this->security->redirectToPage('http://' . $this->root_url . '/login');

      $user = null;
      $params = new stdClass;
      $params->enabled = 1;
      $params->email = $this->user->email;
      $params->email2 = $this->user->email2;
      $params->password = $this->user->password;
      $this->db->users->one($user, $params);
      if (empty($user)) $this->security->redirectToPage('http://' . $this->root_url . '/login');

      $this->db->users->unpackUserName($this->user);
      $this->db->users->unpackUserAddress($this->user);
      $this->db->users->unpackUserAddress($this->user, '2');
      $this->card_num = $this->user->card_num;
      $this->name = $this->user->name;
      $this->name2 = $this->user->name2;
      $this->name3 = $this->user->name3;
      $this->email = $this->user->email;
      $this->email2 = $this->user->email2;
      $this->phone = $this->user->phone;
      $this->phone2 = $this->user->phone2;
      $this->address = $this->user->address;
      $this->address_2 = $this->user->address_2;
      $this->address_3 = $this->user->address_3;
      $this->address_4 = $this->user->address_4;
      $this->address_5 = $this->user->address_5;
      $this->address_6 = $this->user->address_6;
      $this->address_7 = $this->user->address_7;
      $this->address_8 = $this->user->address_8;
      $this->address_9 = $this->user->address_9;
      $this->address_10 = $this->user->address_10;
      $this->address2 = $this->user->address2;
      $this->address2_2 = $this->user->address2_2;
      $this->address2_3 = $this->user->address2_3;
      $this->address2_4 = $this->user->address2_4;
      $this->address2_5 = $this->user->address2_5;
      $this->address2_6 = $this->user->address2_6;
      $this->address2_7 = $this->user->address2_7;
      $this->address2_8 = $this->user->address2_8;
      $this->address2_9 = $this->user->address2_9;
      $this->address2_10 = $this->user->address2_10;
      $this->remark = $this->user->remark;
      $this->encpassword = $this->user->password;
      $this->password = '';
      if (isset($_POST['email']) || isset($_POST['email2'])) {
        $this->card_num = ((isset($_POST["card_num"]) == TRUE) ? trim($_POST["card_num"]) : "");
        $this->name = ((isset($_POST["name"]) == TRUE) ? trim($_POST["name"]) : "");
        $this->name2 = ((isset($_POST["name2"]) == TRUE) ? trim($_POST["name2"]) : "");
        $this->name3 = ((isset($_POST["name3"]) == TRUE) ? trim($_POST["name3"]) : "");
        $this->email = ((isset($_POST["email"]) == TRUE) ? trim($_POST["email"]) : "");
        $this->email2 = ((isset($_POST["email2"]) == TRUE) ? trim($_POST["email2"]) : "");
        $this->phone = ((isset($_POST["phone"]) == TRUE) ? trim($_POST["phone"]) : "");
        $this->phone2 = ((isset($_POST["phone2"]) == TRUE) ? trim($_POST["phone2"]) : "");
        $this->address = ((isset($_POST["address"]) == TRUE) ? trim($_POST["address"]) : "");
        $this->address_2 = ((isset($_POST["address_2"]) == TRUE) ? trim($_POST["address_2"]) : "");
        $this->address_3 = ((isset($_POST["address_3"]) == TRUE) ? trim($_POST["address_3"]) : "");
        $this->address_4 = ((isset($_POST["address_4"]) == TRUE) ? trim($_POST["address_4"]) : "");
        $this->address_5 = ((isset($_POST["address_5"]) == TRUE) ? trim($_POST["address_5"]) : "");
        $this->address_6 = ((isset($_POST["address_6"]) == TRUE) ? trim($_POST["address_6"]) : "");
        $this->address_7 = ((isset($_POST["address_7"]) == TRUE) ? trim($_POST["address_7"]) : "");
        $this->address_8 = ((isset($_POST["address_8"]) == TRUE) ? trim($_POST["address_8"]) : "");
        $this->address_9 = ((isset($_POST["address_9"]) == TRUE) ? trim($_POST["address_9"]) : "");
        $this->address_10 = ((isset($_POST["address_10"]) == TRUE) ? trim($_POST["address_10"]) : "");
        $this->address2 = ((isset($_POST["address2"]) == TRUE) ? trim($_POST["address2"]) : "");
        $this->address2_2 = ((isset($_POST["address2_2"]) == TRUE) ? trim($_POST["address2_2"]) : "");
        $this->address2_3 = ((isset($_POST["address2_3"]) == TRUE) ? trim($_POST["address2_3"]) : "");
        $this->address2_4 = ((isset($_POST["address2_4"]) == TRUE) ? trim($_POST["address2_4"]) : "");
        $this->address2_5 = ((isset($_POST["address2_5"]) == TRUE) ? trim($_POST["address2_5"]) : "");
        $this->address2_6 = ((isset($_POST["address2_6"]) == TRUE) ? trim($_POST["address2_6"]) : "");
        $this->address2_7 = ((isset($_POST["address2_7"]) == TRUE) ? trim($_POST["address2_7"]) : "");
        $this->address2_8 = ((isset($_POST["address2_8"]) == TRUE) ? trim($_POST["address2_8"]) : "");
        $this->address2_9 = ((isset($_POST["address2_9"]) == TRUE) ? trim($_POST["address2_9"]) : "");
        $this->address2_10 = ((isset($_POST["address2_10"]) == TRUE) ? trim($_POST["address2_10"]) : "");
        $this->remark = ((isset($_POST["remark"]) == TRUE) ? trim($_POST["remark"]) : "");
        $this->password = $_POST["password"];
        $error = "";
        if (($this->name == "") && ($this->name2 == "") && ($this->name3 == "")) $error .= "Нужно обязательно ввести своё имя.<br>";
        if ($this->email != "") {
          $params = new stdClass;
          $params->exclude_id = $this->user->user_id;
          $params->email = $this->user->email;
          $this->db->users->one($user, $params);
          if (!empty($user)) $error .= "Е-мейл " . $this->email . " уже используется другим пользователем сайта.<br>";
        }
        if ($this->email2 != "") {
          $params = new stdClass;
          $params->exclude_id = $this->user->user_id;
          $params->email = $this->user->email2;
          $this->db->users->one($user, $params);
          if (!empty($user)) $error .= "Е-мейл " . $this->email2 . " уже используется другим пользователем сайта.<br>";
        }
        if ((($this->email != "") && (!preg_match($this->pattern_email, $this->email)))
        || (($this->email2 != "") && (!preg_match($this->pattern_email, $this->email2)))) {
          $error .= "Необходимо указать е-мейл в правильном формате.<br>";
        }
        if ($error != "") {
          $this->smarty->assign("error", $error);
        } else {
          if (empty($this->password) == FALSE) $this->encpassword = md5($this->password . $this->salt);
          $query = "UPDATE " . DATABASE_USERS_TABLENAME . " "
                 . "SET email = '" . $this->db->query_value($this->email) . "', "
                     . "email2 = '" . $this->db->query_value($this->email2) . "', "
                     . "name = '" . $this->db->query_value($this->db->users->packedUserName($this)) . "', "
                     . "phone = '" . $this->db->query_value($this->phone) . "', "
                     . "phone2 = '" . $this->db->query_value($this->phone2) . "', "
                     . "address = '" . $this->db->query_value($this->db->users->packedUserAddress($this)) . "', "
                     . "address2 = '" . $this->db->query_value($this->db->users->packedUserAddress2($this)) . "', "
                     . "password = '" . $this->db->query_value($this->encpassword) . "' "
                 . "WHERE user_id = '" . $this->db->query_value($this->user->user_id) . "' "
                 . "LIMIT 1;";
          $this->db->query($query);
          if (isset($_SESSION["admin"]) && ($_SESSION["admin"] == "admin")) {
            $query = "UPDATE " . DATABASE_USERS_TABLENAME . " "
                   . "SET card_num = '" . $this->db->query_value($this->card_num) . "', "
                       . "remark = '" . $this->db->query_value($this->remark) . "' "
                   . "WHERE user_id = '" . $this->db->query_value($this->user->user_id) . "' "
                   . "LIMIT 1;";
            $this->db->query($query);
          }
          $_SESSION["user_email"] = $this->email;
          $_SESSION["user_email2"] = $this->email2;
          $_SESSION["user_password"] = $this->encpassword;
          header("Location: http://" . $this->root_url . "/account");
          exit;
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
      $query = "SELECT " . DATABASE_ORDERS_TABLENAME . ".*, "
                    . "SUM(orders_products.price*ABS(orders_products.quantity))+" . DATABASE_ORDERS_TABLENAME . ".delivery_price AS total_amount, "
                    . "DATE_FORMAT(" . DATABASE_ORDERS_TABLENAME . ".date, '%d.%m.%Y %H:%i') AS date, "
                    . "delivery_methods.name AS delivery_method "
             . "FROM " . DATABASE_ORDERS_TABLENAME . " "
             . "LEFT JOIN orders_products "
                       . "ON " . DATABASE_ORDERS_TABLENAME . ".order_id = orders_products.order_id "
             . "LEFT JOIN delivery_methods "
                       . "ON " . DATABASE_ORDERS_TABLENAME . ".delivery_method_id = delivery_methods.delivery_method_id "
             . "WHERE " . DATABASE_ORDERS_TABLENAME . ".user_id = '" . $this->db->query_value($this->user->user_id) . "' "
             . "GROUP BY " . DATABASE_ORDERS_TABLENAME . ".order_id "
             . "ORDER BY " . DATABASE_ORDERS_TABLENAME . ".order_id DESC;";
      $this->db->query($query);
      $orders = $this->db->results();
      foreach ($orders as $k => & $order) {
        $this->db->users->unpackUserName($order);
        $this->db->users->unpackUserAddress($order);
        $this->db->users->unpackUserAddress($order, '2');
        $query = "SELECT orders_products.*, "
                      . "products.url AS url "
               . "FROM orders_products "
               . "LEFT JOIN products "
                         . "ON products.product_id = orders_products.product_id "
               . "WHERE orders_products.order_id = '" . $this->db->query_value($order->order_id) . "';";
        $this->db->query($query);
        $products = $this->db->results();
        $orders[$k]->products = $products;
      }
      $favorites = ClientProduct::get_favorites();
      $this->db->feedback->getUserFeedback($this->user, $feedback);
      $this->smarty->assign("orders", $orders);
      $this->smarty->assign("favorites", $favorites);
      $this->smarty->assign("feedback", $feedback);
      $this->smarty->assign("card_num", $this->card_num);
      $this->smarty->assign("name", $this->name);
      $this->smarty->assign("name2", $this->name2);
      $this->smarty->assign("name3", $this->name3);
      $this->smarty->assign("email", $this->email);
      $this->smarty->assign("email2", $this->email2);
      $this->smarty->assign("phone", $this->phone);
      $this->smarty->assign("phone2", $this->phone2);
      $this->smarty->assign("address", $this->address);
      $this->smarty->assign("address_2", $this->address_2);
      $this->smarty->assign("address_3", $this->address_3);
      $this->smarty->assign("address_4", $this->address_4);
      $this->smarty->assign("address_5", $this->address_5);
      $this->smarty->assign("address_6", $this->address_6);
      $this->smarty->assign("address_7", $this->address_7);
      $this->smarty->assign("address_8", $this->address_8);
      $this->smarty->assign("address_9", $this->address_9);
      $this->smarty->assign("address_10", $this->address_10);
      $this->smarty->assign("address2", $this->address2);
      $this->smarty->assign("address2_2", $this->address2_2);
      $this->smarty->assign("address2_3", $this->address2_3);
      $this->smarty->assign("address2_4", $this->address2_4);
      $this->smarty->assign("address2_5", $this->address2_5);
      $this->smarty->assign("address2_6", $this->address2_6);
      $this->smarty->assign("address2_7", $this->address2_7);
      $this->smarty->assign("address2_8", $this->address2_8);
      $this->smarty->assign("address2_9", $this->address2_9);
      $this->smarty->assign("address2_10", $this->address2_10);
      $this->smarty->assign("remark", $this->remark);
      $this->smarty->assign("password", $this->password);
      $this->smarty->assign("account_module_name", $this->module_name);
      return $this->smarty->fetchByTemplate($this, 'page.account', 'account');
    }
  }



  return;
?>