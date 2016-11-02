<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:05:39
         compiled from "../admin/design/default/html/admin_sections.htm" */ ?>
<?php /*%%SmartyHeaderCode:68417470957d5b913e26a83-36005538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7174562c7cde29f178fa1ea88f809094c2c07cce' => 
    array (
      0 => '../admin/design/default/html/admin_sections.htm',
      1 => 1462406618,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68417470957d5b913e26a83-36005538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'root_url' => 0,
    'admin_folder' => 0,
    'inputs' => 0,
    'message' => 0,
    'error' => 0,
    'menus' => 0,
    'c' => 0,
    'modules' => 0,
    'all_users' => 0,
    'total_items' => 0,
    'items' => 0,
    'PagesNavigation' => 0,
    'Pages' => 0,
    'now_menu' => 0,
    'settings' => 0,
    'CurrentPage' => 0,
    'CurrentPageMaxsize' => 0,
    'users_list' => 0,
    'now_user_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b91415e130_40468148',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b91415e130_40468148')) {function content_57d5b91415e130_40468148($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?><!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"pages",'main'=>true,'pages'=>true,'news'=>true,'articles'=>true,'banners'=>true,'files'=>true,'menus'=>true,'modules'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → Страницы
      </div>
      Специальные страницы
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a><a class="left" href="#settings" onclick="javascript: Show_PageElements('setup_form');" title="Показать настройки сайта, относящиеся к специальным страницам">настройки</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Section&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" title="Добавить специальную страницу">добавить</a>
    </div>

    <!--  -->
    <?php if (isset($_smarty_tpl->tpl_vars['message']->value)&&($_smarty_tpl->tpl_vars['message']->value!='')){?>
      <div class="message">
        <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

      </div>
    <?php }?>

    <!--  -->
    <?php if (isset($_smarty_tpl->tpl_vars['error']->value)&&($_smarty_tpl->tpl_vars['error']->value!='')){?>
      <div class="error">
        <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

      </div>
    <?php }?>

    <!-- Форма со списком записей -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Sections" id="items_form" method="post">

      <!-- Фильтр -->
      <table align="center" cellpadding="0" cellspacing="8" class="white">
        <tr>
          <td class="param_short">
            Меню
          </td>
          <td class="value" width="50%" title="Фильтр: только принадлежащие такому меню сайта">

            <!-- Создаем селектор меню сайта -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MENU, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MENU, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value=""></option>
              <?php if (isset($_smarty_tpl->tpl_vars['menus']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->menu_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MENU])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MENU]==$_smarty_tpl->tpl_vars['c']->value->menu_id)){?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</option>
                <?php } ?>
              <?php }?>
            </select>
          </td>
          <td class="param_short">
            Тип
          </td>
          <td class="value" width="50%" title="Фильтр: только такого типа">

            <!-- Создаем селектор типов (модулей) -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MODULE, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MODULE, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value=""></option>
              <?php if (isset($_smarty_tpl->tpl_vars['modules']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                  <?php if ($_smarty_tpl->tpl_vars['c']->value->valuable==1){?>
                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->module_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MODULE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MODULE]==$_smarty_tpl->tpl_vars['c']->value->module_id)){?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</option>
                  <?php }?>
                <?php } ?>
              <?php }?>
            </select>
          </td>
        </tr>
        <tr>
          <td class="param_short">
            Администратор
          </td>
          <td class="value" colspan="3" width="100%" title="Фильтр: только администрируемые таким человеком">

            <!-- Создаем селектор пользователей -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value=""></option>
              <option value="0"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER]=="0")){?> selected<?php }?>>Администратор</option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER])===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

            </select>
          </td>
        </tr>
      </table>

      <!-- Сортировщик -->
      <table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;">
        <tr>
          <td class="param_short">
            упорядочить
          </td>
          <td class="value" width="100%" title="Способ сортировки специальных страниц в нижеследующем списке">

            <!-- Создаем селектор способов сортировки и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value="<?php echo @SORT_SECTIONS_MODE_AS_IS;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_AS_IS)){?> selected<?php }?>>как расставлены</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_HEADER;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_HEADER)){?> selected<?php }?>>по алфавиту</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_CREATED;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_CREATED)){?> selected<?php }?>>по дате добавления</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_MODIFIED;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_MODIFIED)){?> selected<?php }?>>по дате исправления</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_BROWSED;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_BROWSED)){?> selected<?php }?>>по количеству просмотров</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_URL;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_URL)){?> selected<?php }?>>по url (адресу специальной страницы)</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_OBJECTS;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_OBJECTS)){?> selected<?php }?>>по подключаемым плагинам</option>
              <option value="<?php echo @SORT_SECTIONS_MODE_BY_MODULE;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_MODULE)){?> selected<?php }?>>по типу контента</option>
            </select>
          </td>

          <!-- Флажки фильтра -->
          <td class="param_short" title="Фильтр: только скрытые от незарегистрированных пользователей">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_HIDDEN])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_HIDDEN]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
');">
              скрыта
            </span>
          </td>
          <td class="param_short" title="Фильтр: только разрешенные к показу на сайте">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_ENABLED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_ENABLED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
');">
              разрешена
            </span>
          </td>
          <td class="param_short" title="Фильтр: только загружавшиеся изображениями">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_IMAGED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_IMAGED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
');">
              с картинками
            </span>
          </td>
          <td class="param_short" title="Фильтр: только с SEO текстом">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEOED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEOED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
');">
              с SEO текстом
            </span>
          </td>
          <td class="param_short" title="Фильтр: только с особым URL">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_URLSPECIAL])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_URLSPECIAL]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
');">
              с особым URL
            </span>
          </td>
          <td class="param_short" title="Фильтр: только с подключаемыми плагинами">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_OBJECTED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_OBJECTED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
');">
              с плагинами
            </span>
          </td>
        </tr>
      </table>

      <!-- Кнопка сброса фильтра --> 
      <div class="toolkey">
        <span>найдено <span><?php echo sprintf("%d",(($tmp = @$_smarty_tpl->tpl_vars['total_items']->value)===null||$tmp==='' ? 0 : $tmp));?>
 шт.</span></span><a href="#" onclick="javascript: return Reset_PageRecordsFilter('items_form');" title="Сбросить фильтр (кроме способа упорядочения)">сбросить</a>
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>

        <!-- Выводим контент навигатора страниц над списком, только если есть несколько листаемых страниц -->
        <?php if (isset($_smarty_tpl->tpl_vars['PagesNavigation']->value)&&($_smarty_tpl->tpl_vars['PagesNavigation']->value!='')&&isset($_smarty_tpl->tpl_vars['Pages']->value)&&(count($_smarty_tpl->tpl_vars['Pages']->value)>1)){?>
          <?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>

        <?php }?>

        <?php $_smarty_tpl->tpl_vars["now_menu"] = new Smarty_variable(false, null, 0);?>
        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?>
          <!-- Визуальное выделение принадлежности к меню --><?php if ($_smarty_tpl->tpl_vars['now_menu']->value!==$_smarty_tpl->tpl_vars['c']->value->menu){?><?php $_smarty_tpl->tpl_vars["now_menu"] = new Smarty_variable($_smarty_tpl->tpl_vars['c']->value->menu, null, 0);?><li class="head_divider"><div><?php if ($_smarty_tpl->tpl_vars['c']->value->menu!=''){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->menu, ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>Вне любого меню<?php }?></div></li><?php }?><li class="flatlist"><!-- Микро кнопки справа от названия в меню --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="javascript: return confirm('Данная специальная страница будет удалена с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_delete_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><?php if (!isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_AS_IS)){?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_first_get, ENT_QUOTES, 'UTF-8');?>
" title="Поставить первым в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_move_first_16x16.png"></a><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_up_get, ENT_QUOTES, 'UTF-8');?>
" title="Поднять выше в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_move_up_16x16.png"></a><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_down_get, ENT_QUOTES, 'UTF-8');?>
" title="Опустить ниже в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_move_down_16x16.png"></a><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_last_get, ENT_QUOTES, 'UTF-8');?>
" title="Поставить последним в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_move_last_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><?php }?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->hidden_get, ENT_QUOTES, 'UTF-8');?>
" title="Скрыть / открыть для незарегистрированных пользователей"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_hidden<?php if ($_smarty_tpl->tpl_vars['c']->value->hidden!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Нумерация --><span class="topic" style="display: inline;"><?php if (isset($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration']+$_smarty_tpl->tpl_vars['CurrentPage']->value*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value;?>
.<?php }else{ ?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.<?php }?></span><!-- Количество просмотров --><span class="browsed" title="Количество просмотров: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
</span><!-- Значок использования динамически подключаемых плагинов --><?php if ($_smarty_tpl->tpl_vars['c']->value->objects!=''){?><img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_objected_16x16.png" title="Содержит подключаемые плагины: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->objects, ENT_QUOTES, 'UTF-8');?>
"><?php }?><!-- Название в меню --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="Заголовок: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->header, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</a><!-- Краткая информация --><?php if ($_smarty_tpl->tpl_vars['c']->value->module!=''){?><div class="line"><span>тип:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->module, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><?php if (isset($_smarty_tpl->tpl_vars['users_list']->value)&&!empty($_smarty_tpl->tpl_vars['c']->value->user_id)&&(!isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER])||empty($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER]))){?><?php $_smarty_tpl->tpl_vars["now_user_id"] = new Smarty_variable($_smarty_tpl->tpl_vars['c']->value->user_id, null, 0);?><div class="line"><span>админ:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['users_list']->value[$_smarty_tpl->tpl_vars['now_user_id']->value]->compound_name, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_SECTIONS_MODE_BY_OBJECTS)){?><?php if ($_smarty_tpl->tpl_vars['c']->value->objects!=''){?><div class="line"><span>плагины:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->objects, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><?php }?><!-- теги --><?php if (isset($_smarty_tpl->tpl_vars['c']->value->tags)&&($_smarty_tpl->tpl_vars['c']->value->tags!='')){?><div class="line" title="Теги: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->tags, ENT_QUOTES, 'UTF-8');?>
"><span>теги:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->tags, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><!-- описание --><?php if (isset($_smarty_tpl->tpl_vars['c']->value->body)&&(preg_replace('!\s+!u', ' ',smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->body),"&nbsp;"," "))!='')){?><div class="line" title="<?php echo htmlspecialchars(smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->body),"&nbsp;"," "), ENT_QUOTES, 'UTF-8');?>
"><span>описание:</span><?php echo htmlspecialchars(smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->body),"&nbsp;"," "), ENT_QUOTES, 'UTF-8');?>
</div><?php }?><div class="line<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?> gray<?php }?>"><span>адрес:</span><?php if ($_smarty_tpl->tpl_vars['c']->value->enabled==1){?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на специальную страницу в клиентской части сайта">http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url, ENT_QUOTES, 'UTF-8');?>
<?php }?></div></li>
        <?php } ?>

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

        <!-- Выводим контент навигатора страниц под списком -->
        <?php if (isset($_smarty_tpl->tpl_vars['PagesNavigation']->value)&&($_smarty_tpl->tpl_vars['PagesNavigation']->value!='')){?>
          <?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>

        <?php }?>

      <?php }else{ ?>
        <div class="noitems">
          Не найдено специальных страниц.
        </div>
      <?php }?>
    </form>

    <!-- Блок справочной информации -->
    <a name="help"></a>
    <div class="help" id="help_box" style="display: none;">
      <div class="title">
        Справка
      </div>
      <div>
        <b>Фильтр</b>. Расположен в верхней части страницы и обеспечивает возможность выделить из общего списка специальные страницы по конкретным параметрам.
        Поля фильтра можно сочетать произвольно, они объединены функцией И.
      </div>
      <div>
        В принципе часть изображений или вообще все они могут быть загружены в специальную страницу не обязательно для использования в ее тексте, а например
        как элементы ее фотогалереи. Поэтому поле фильтра "<u>с&nbsp;картинками</u>" дает возможность выделить специальные страницы, в которые производилась
        именно загрузка изображений, не уточняя притом факт, реально ли используются картинки или просто хранятся на сайте для прочих целей.
      </div>
      <div>
        Поле фильтра "<u>с&nbsp;особым&nbsp;URL</u>" выделяет статьи с произвольно заданным адресом страницы, то есть не содержащим в начале
        адреса специальных включений (например sections/), идентифицирующих разновидность запрошенного контента. Всякий URL статьи не может
        быть похожим на URL другой статьи, однако особым URL допустимо перекрываться с особыми URL других разновидностей контента сайта. В этом
        случае установлен следующий приоритет владения конфликтующим адресом: специальная страница, товар, категория, бренд, статья, новость.
      </div>
      <div>
        Поле фильтра "<u>с&nbsp;плагинами</u>" выделяет специальные страницы, в которые во время создания или редактирования специальной страницы было предписано
        динамически подключать программные модули (плагины, расширяющие функционал) при просмотре специальной страницы посетителем сайта. Здесь
        фильтрацией также не уточняется, действительно ли существуют файлы плагинов на сайте. Визуально специальные страницы с подключаемыми плагинами отмечаются
        в списке соответствующим значком перед названием специальной страницы. Наведение курсора на значок демонстрирует перечень плагинов, подключаемых
        конкретно к этой специальной странице. Так как возможно подключать любые сторонние плагины, указываются не их названия, а классы модулей.
      </div>
      <div>
        <b>Упорядочение</b>. По умолчанию способ сортировки специальных страниц в списке на данной странице равен "<u>как&nbsp;расставлены</u>".
        В случае смены способа сортировки он запоминается на время текущего сеанса.
      </div>
      <div>
        В отличие от других способов упорядочения, способ "<u>как&nbsp;расставлены</u>" отключает сортировку и предоставляет функции перемещения
        специальных страниц по ветви меню, в котором они находятся. Эта расстановка основана на так называемых весах элементов - символических
        числах первостепенности одной записи перед другой. Чем больше число, тем выше в ветви своего меню размещается специальная страница в списке,
        упорядоченном таким образом.
      </div>
      <div>
        <b>Принадлежность</b>. При любом способе сортировки список специальных страниц, строго сохраняя выбранную упорядоченность, визуально
        отмечается принадлежностью участков списка к конкретным меню сайта. Кроме того, в списке указаны не заголовки специальных страниц, а их
        названия в меню (иными словами, названия пунктов меню). Наведением курсора на это название можно просмотреть, как будет озаглавлена
        специальная страница при ее посещении пользователем.
      </div>
    </div>

    <!-- Форма соответствующих модулю настроек сайта -->
    <a name="settings"></a>
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Sections" enctype="multipart/form-data" id="setup_form" method="post"<?php if (empty($_smarty_tpl->tpl_vars['error']->value)){?> style="display: none;"<?php }?>>
      <br>
      <h1>
        Настройки
      </h1>
      <br>
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high" rowspan="5">
            Водяной знак:
            <center>
              <img class="watermark" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_IMAGES_FOLDER_REFERENCE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@SECTIONS_CLASS_WATERMARK_FILENAME, ENT_QUOTES, 'UTF-8');?>
?<?php echo smarty_function_math(array('equation'=>'rand(1, 1000000000)'),$_smarty_tpl);?>
" title="Используемое изображение водяного знака для загружаемых в специальную страницу картинок">
            </center>
          </td>
          <td class="value" colspan="4" width="100%" title="Какой файл изображения водяного знака требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf("%d",(@WATERMARK_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт)">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf("%d",@WATERMARK_UPLOAD_MAXIMAL_FILESIZE), ENT_QUOTES, 'UTF-8');?>
">  <!-- Не позволяем загрузку файла объемом свыше заданного -->
            <input class="edit" name="watermark_filename" type="file">
          </td>
          <td class="param_short">
            Наложить:
          </td>
          <td class="value" title="Как накладывать водяной знак (производится без масштабирования водяного знака)">
            <select name="sections_watermark_location">
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_LEFTTOP, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_LEFTTOP){?> selected<?php }?>>слева вверху</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_CENTERTOP, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_CENTERTOP){?> selected<?php }?>>в центре вверху</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_RIGHTTOP, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_RIGHTTOP){?> selected<?php }?>>справа вверху</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_LEFTCENTER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_LEFTCENTER){?> selected<?php }?>>слева в центре</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_CENTER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_CENTER){?> selected<?php }?>>по центру</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_RIGHTCENTER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_RIGHTCENTER){?> selected<?php }?>>справа в центре</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_LEFTBOTTOM, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_LEFTBOTTOM){?> selected<?php }?>>слева внизу</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_CENTERBOTTOM, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_CENTERBOTTOM){?> selected<?php }?>>в центре внизу</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_location==@IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM){?> selected<?php }?>>справа внизу</option>
            </select>
          </td>
          <td class="param_short">
            Видимость:
          </td>
          <td class="value" title="Видимость знака на картинке (чем меньше число, тем прозрачнее)">
            <select name="sections_watermark_transparency">
              <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)@SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=@SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_transparency==$_smarty_tpl->getVariable('smarty')->value['section']['value']['index']){?> selected<?php }?>>
                  <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
%
                </option>
              <?php endfor; endif; ?>
            </select>
          </td>
          <td class="param_short" title="Добавлять ли водяной знак на загружаемые изображения">
            <input class="checkbox" id="setup_form_watermark_enabled" name="sections_watermark_enabled" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_enabled)&&($_smarty_tpl->tpl_vars['settings']->value->sections_watermark_enabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_watermark_enabled');">
              Разрешен
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short">
            Качество:
          </td>
          <td class="value" width="100%" title="Качество картинок и миниатюр в процентах (чем меньше число, тем хуже качество и меньше размер файла)">
            <input class="edit" name="sections_images_quality" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_images_quality, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short">
            Размеры картинок:
          </td>
          <td class="value" title="Предельная ширина картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_IMAGES_WIDTH, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_IMAGES_WIDTH, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="sections_images_width" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_images_width, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value" title="Предельная высота картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_IMAGES_HEIGHT, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_IMAGES_HEIGHT, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="sections_images_height" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_images_height, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short">
            Размеры миниатюр:
          </td>
          <td class="value" title="Предельная ширина уменьшенных картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_THUMBNAIL_WIDTH, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_THUMBNAIL_WIDTH, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="sections_thumbnail_width" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_thumbnail_width, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value" title="Предельная высота уменьшенных картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_THUMBNAIL_HEIGHT, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="sections_thumbnail_height" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_thumbnail_height, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short" title="Подгонять ли размеры меньших изображений до указанных размеров">
            <input class="checkbox" id="setup_form_images_exactly" name="sections_images_exactly" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->sections_images_exactly)&&($_smarty_tpl->tpl_vars['settings']->value->sections_images_exactly==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_images_exactly');">
              Точно
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short" colspan="3" title="Использовать ли визуальный редактор при редактировании специальных страниц">
            <input class="checkbox" id="setup_form_wysiwyg_disabled" name="sections_wysiwyg_disabled" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled)&&($_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_wysiwyg_disabled');">
              Отключить wysiwyg-редактор:
            </span>
          </td>
          <td class="value" colspan="3" title="Как обрабатывать текст при отключенном визуальном редакторе">
            <select name="sections_wysiwyg_disabled_mode">
              <option value="<?php echo htmlspecialchars(@FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled_mode==@FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION){?> selected<?php }?>>в тексте ничего не менять, не трогать разметочные теги</option>
              <option value="<?php echo htmlspecialchars(@FIX_SIMPLE_TEXTAREA_TEXT_MODE_ALL_TAGS_CLEAR, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled_mode==@FIX_SIMPLE_TEXTAREA_TEXT_MODE_ALL_TAGS_CLEAR){?> selected<?php }?>>из текста удалять все теги, пустые строки и лишние пробелы</option>
            </select>
          </td>
          <td class="param_short" colspan="3" title="Разрешить ли системе заполнять пустые поля мета информации">
            <input class="checkbox" id="setup_form_meta_autofill" name="sections_meta_autofill" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->sections_meta_autofill)&&($_smarty_tpl->tpl_vars['settings']->value->sections_meta_autofill==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_meta_autofill');">
              Автозаполнение полей мета тегов
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short" colspan="3">
            Сортировать в меню стороны клиента:
          </td>
          <td class="value" colspan="3" title="Как упорядочить список специальных страниц, сформированный для клиентской стороны">
            <select name="sections_sort_method">
              <option value="<?php echo htmlspecialchars(@SORT_SECTIONS_MODE_AS_IS, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_sort_method==@SORT_SECTIONS_MODE_AS_IS){?> selected<?php }?>>как расставлены в админпанели</option>
              <option value="<?php echo htmlspecialchars(@SORT_SECTIONS_MODE_BY_HEADER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_sort_method==@SORT_SECTIONS_MODE_BY_HEADER){?> selected<?php }?>>по алфавиту</option>
              <option value="<?php echo htmlspecialchars(@SORT_SECTIONS_MODE_BY_CREATED, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_sort_method==@SORT_SECTIONS_MODE_BY_CREATED){?> selected<?php }?>>по дате добавления</option>
              <option value="<?php echo htmlspecialchars(@SORT_SECTIONS_MODE_BY_BROWSED, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_sort_method==@SORT_SECTIONS_MODE_BY_BROWSED){?> selected<?php }?>>по количеству просмотров</option>
            </select>
          </td>
          <td class="param_short">
            Префикс:
          </td>
          <td class="value" title="Префикс папки с картинками специальных страниц">
            <input class="edit" name="sections_files_folder_prefix" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_files_folder_prefix, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value_box">
            <input class="submit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SETUP, ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Сохранить">
          </td>
        </tr>
        <tr>
          <td colspan="9"><!-- // --></td>
        </tr>
      </table>

      <!-- Добавляем аутентификатор операции -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
    </form>

  </div>
<?php }} ?>