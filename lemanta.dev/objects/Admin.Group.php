<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;



    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);



    class Group extends Basic {



        public $group = null;
        public $groups = null;



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
            $this->prepare();
        }



    function prepare () {
      $this->error_msg = '';
      $params = new stdClass;
      $params->id = $this->param('group_id');
//      if ($params->id == '') {
//        $params->id = $this->param('item_id');
//        $this->db->groups->one($this->group, $params);
//        if (empty($this->group)) {
//          $this->group = new stdClass;
//          $this->group->group_id = $group_id;
//          $this->group->authorized = 1;
//        }
//      } else {
        $this->db->groups->one($this->group, $params);
//      }
      $this->db->get_groups_array($this->groups, GET_GROUPS_MODE_FOR_AUTHORIZED);
      if (isset($_POST['name'])) {
        $this->check_token();
        $rate = $this->any->currency->rate();
        if (!isset($this->group->group_id)) $this->group->group_id = 0;
        $this->group->name = ""; if (isset($_POST["name"])) $this->group->name = trim($_POST["name"]);
        $this->group->discount = 0; if (isset($_POST["discount"])) $this->group->discount = trim($_POST["discount"]);
        $this->group->from_sum = 0; if (isset($_POST["from_sum"])) $this->group->from_sum = $this->number->floatValue($_POST["from_sum"]) * $rate;
        $this->group->authorized = isset($_POST["authorized"]) && ($_POST["authorized"] == 1) ? 1 : 0;
        $this->group->auto_assign = isset($_POST["auto_assign"]) && ($_POST["auto_assign"] == 1) ? 1 : 0;
        $this->group->next_group_id = 0; if (isset($_POST["next_group_id"])) $this->group->next_group_id = trim($_POST["next_group_id"]);
        $this->group->next_group_sum = 0; if (isset($_POST["next_group_sum"])) $this->group->next_group_sum = $this->number->floatValue($_POST["next_group_sum"]) * $rate;
        $this->group->next_group_orders = 0; if (isset($_POST["next_group_orders"])) $this->group->next_group_orders = trim($_POST["next_group_orders"]);
        $this->group->next_group_products = 0; if (isset($_POST["next_group_products"])) $this->group->next_group_products = trim($_POST["next_group_products"]);
        $this->group->next_group_condition = 0; if (isset($_POST["next_group_condition"])) $this->group->next_group_condition = (($_POST["next_group_condition"] != 1) ? 0 : 1);
        $this->group->next_group_condition2 = 0; if (isset($_POST["next_group_condition2"])) $this->group->next_group_condition2 = (($_POST["next_group_condition2"] != 1) ? 0 : 1);
        if (empty($this->group->name)) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= 'Введите название!';
        }
        if ($this->number->floatValue($this->group->discount) < 0) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= "Скидка не может быть отрицательным числом!";
        }
        if ($this->number->floatValue($this->group->discount) > 100) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= "Скидка не может быть более 100 процентов!";
        }
        if ($this->number->floatValue($this->group->from_sum) < 0) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= "Сумма начала действия скидки не может быть отрицательным числом!";
        }
        if ($this->number->floatValue($this->group->next_group_sum) < 0) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= "Сумма платежей для перехода в другую группу не может быть отрицательным числом!";
        }
        if (@intval($this->group->next_group_orders) < 0) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= "Количество сделанных заказов для перехода в другую группу не может быть отрицательным числом!";
        }
        if (@intval($this->group->next_group_products) < 0) {
          if ($this->error_msg != "") $this->error_msg .= "<br><br>";
          $this->error_msg .= "Количество приобретённых товаров для перехода в другую группу не может быть отрицательным числом!";
        }
        if ($this->group->next_group_id != 0) {
          if ($this->group->group_id == $this->group->next_group_id) {
            if ($this->error_msg != "") $this->error_msg .= "<br><br>";
            $this->error_msg .= "Следующей группой не может быть эта же группа!";
          } else {
            $group_id = $this->group->next_group_id;
            while (isset($this->groups[$group_id]) && !empty($this->groups[$group_id]->next_group_id)) {
              $group_id = $this->groups[$group_id]->next_group_id;
              if ($this->group->group_id == $group_id) {
                if ($this->error_msg != "") $this->error_msg .= "<br><br>";
                $this->error_msg .= "При выборе такой следующей группы получается замкнутое кольцо групп!";
                break;
              }
            }
          }
          if (($this->number->floatValue($this->group->next_group_sum) == 0) && (@intval($this->group->next_group_orders) == 0) && (@intval($this->group->next_group_products) == 0)) {
            if ($this->error_msg != "") $this->error_msg .= "<br><br>";
            $this->error_msg .= "При указании следующей группы нельзя не задать условия перехода!";
          }
        }
        if ($this->error_msg == "") {
          $this->db->groups->update($this->group);
          $get = $this->form_get(array("section" => "Groups",
                                       "page" => $this->param("page")));
          header("Location: index.php" . $get);
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

            if (!isset($this->group->group_id) || empty($this->group->group_id)) {
                if (!is_object($this->group)) $this->group = new stdClass;
                $this->group->authorized = isset($_REQUEST['mode']) && ($_REQUEST['mode'] == 'discount') ? '0' : '1';
                if ($this->group->authorized) {
                    $this->title = 'Новая группа скидок';
                } else {
                    $this->title = 'Новая внегрупповая скидка';
                }



            } else {
                if ($this->group->authorized) {
                    $this->title = 'Редактирование группы скидок';
                } else {
                    $this->title = 'Редактирование внегрупповой скидки';
                }
            }



            $this->smarty->assignByRef('Group', $this->group);
            $this->smarty->assignByRef('Groups', $this->groups);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('Error', $this->error_msg);



            $this->body = $this->smarty->fetch('admin_group.htm');

            return TRUE;
        }
    }



    return;
?>