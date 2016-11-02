<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;



    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_ADMIN_PAGE_OBJECT);



    class Groups extends Basic {



        public $pages_navigation = null;
        public $items_per_page = DEFAULT_VALUE_FOR_GROUPS_ON_PAGE_IN_ADMIN;



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
            $this->pages_navigation = new PagesNavigation($this);
            $this->prepare();
        }



        function prepare () {
            $this->error_msg = '';
            if (isset($_GET['delete_id'])) {
                $this->check_token();
                $id = @ intval($_GET['delete_id']);
                $query = 'SELECT COUNT(`user_id`) AS count '
                       . 'FROM `' . DATABASE_USERS_TABLENAME . '` '
                       . 'WHERE `group_id` = \'' . $this->db->query_value($id) . '\';';
                $this->db->query($query);
                $users_num = $this->db->result();
                $users_num = $users_num->count;
                if ($users_num > 0) {
                    $this->error_msg = 'Нельзя удалить группу, в которой находится ' . $users_num . ' пользователей!';
                } else {
                    $query = 'DELETE FROM `groups` '
                           . 'WHERE `group_id` = \'' . $this->db->query_value($id) . '\' '
                           . 'LIMIT 1;';
                    $this->db->query($query);
                    $get = $this->form_get(array('page' => $this->param('page')));
                    header('Location: index.php' . $get);
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

            $this->title = 'Группы скидок';

            $groups = null;
            $current_page = $this->param('page');
            $start_item = $current_page * $this->items_per_page;
            $pages_num = $this->db->get_groups_array($groups, GET_GROUPS_MODE_FOR_AUTHORIZED, $start_item, $this->items_per_page);
            $pages_num = $pages_num / $this->items_per_page;
            $this->pages_navigation->make($pages_num);

            foreach ($groups as $key => $group) {
                $groups[$key]->edit_get = $this->form_get(array('section'  => 'Group',
                                                                'group_id' => $group->group_id,
                                                                'token'    => $this->token));
            }

            $discounts = null;
            $this->db->get_groups_array($discounts, GET_GROUPS_MODE_FOR_UNAUTHORIZED);
            foreach ($discounts as $key => $group) {
                $discounts[$key]->edit_get = $this->form_get(array('section'  => 'Group',
                                                                   'group_id' => $group->group_id,
                                                                   'token'    => $this->token));
            }

            $this->smarty->assignByRef('Groups', $groups);
            $this->smarty->assignByRef('Discounts', $discounts);
            $this->smarty->assignByRef('PagesNavigation', $this->pages_navigation->body);
            $this->smarty->assignByRef('error', $this->error_msg);
            $this->smarty->assignByRef('Error', $this->error_msg);

            $this->body = $this->smarty->fetch('admin_groups.htm');
            return TRUE;
        }
    }



    return;
?>