<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:30
         compiled from "../admin/design/default/html/admins/admins.htm" */ ?>
<?php /*%%SmartyHeaderCode:90228743357d5b6b267d171-48318949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b94c4563a9d28dcafe582a48594443358ea7e9c' => 
    array (
      0 => '../admin/design/default/html/admins/admins.htm',
      1 => 1462406631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90228743357d5b6b267d171-48318949',
  'function' => 
  array (
    'AdminsModule_card_inputs' => 
    array (
      'parameter' => 
      array (
        'id' => '',
        'scripted' => true,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'temp_module' => 0,
    'site' => 0,
    'admin_folder' => 0,
    'temp_url_main' => 0,
    'settings' => 0,
    'temp_url_script' => 0,
    'temp_param' => 0,
    'title' => 0,
    'message' => 0,
    'error' => 0,
    'temp_url_form' => 0,
    'scripted' => 0,
    'id' => 0,
    'item' => 0,
    'temp_script' => 0,
    'temp_value' => 0,
    'temp_var' => 0,
    '($_smarty_tpl->tpl_vars[\'temp_var\']->value)' => 0,
    'c' => 0,
    'temp_id' => 0,
    'temp_url_images' => 0,
    'temp_name' => 0,
    'temp' => 0,
    'from_page' => 0,
    'Token' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6b2773446_86337512',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6b2773446_86337512')) {function content_57d5b6b2773446_86337512($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['temp_module'] = new Smarty_variable((($tmp = @@ADMINS_MODULELINK_POINTER)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php echo $_smarty_tpl->getSubTemplate ('../../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('main'=>true,'me'=>(($tmp = @@ADMINS_MODULETAB_TEXT)===null||$tmp==='' ? '' : $tmp),'me_pointer'=>$_smarty_tpl->tpl_vars['temp_module']->value,'me_menupath'=>(($tmp = @@ADMINS_MODULEMENU_PATH)===null||$tmp==='' ? '' : $tmp),'select'=>'me'), 0);?>
<?php $_smarty_tpl->tpl_vars['temp_url_main'] = new Smarty_variable((((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)))).('/')), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_script'] = new Smarty_variable(($_smarty_tpl->tpl_vars['temp_url_main']->value).('index.php'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_images'] = new Smarty_variable(((((htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8'))).('design/')).((htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8')))).('/images/'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_form'] = new Smarty_variable((((($_smarty_tpl->tpl_vars['temp_url_script']->value).('?')).($_smarty_tpl->tpl_vars['temp_param']->value)).('=')).($_smarty_tpl->tpl_vars['temp_module']->value), null, 0);?><div class="box"><h1><div class="path"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
">Главная</a> → Администраторы</div><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? 'Администраторы' : $tmp);?>
</h1><div class="toolkey"><a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_script']->value, ENT_QUOTES, 'UTF-8');?>
?<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_USER_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @@USERACTION_REQUEST_PARAM_VALUE_RELOGIN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Войти в админпанель под другим логином">войти заново</a></div><?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="message"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div><?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="error"><b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_form']->value, ENT_QUOTES, 'UTF-8');?>
" id="items_form" method="post"><?php if (!function_exists('smarty_template_function_AdminsModule_card_inputs')) {
    function smarty_template_function_AdminsModule_card_inputs($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['AdminsModule_card_inputs']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable($_smarty_tpl->tpl_vars['scripted']->value ? 'value="применить" title="Принять исправления только в этой записи"' : 'value="добавить"', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_script'] = new Smarty_variable($_smarty_tpl->tpl_vars['scripted']->value ? 'onchange="javascript: Show_AcceptChanges_Button();"' : '', null, 0);?><div class="line" style="padding-top: 9px;"><span>логин:</span><div class="price_edit admin_login_edit" title="Логин администратора"><input name="previous_<?php echo htmlspecialchars((($tmp = @@ADMINS_POSTVAR_LOGIN)===null||$tmp==='' ? 'login' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->login)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /><input name="<?php echo htmlspecialchars((($tmp = @@ADMINS_POSTVAR_LOGIN)===null||$tmp==='' ? 'login' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" maxlength="20" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->login)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['temp_script']->value;?>
 /></div><span class="label">пароль:</span><div class="price_edit admin_password_edit" title="Пароль<?php echo $_smarty_tpl->tpl_vars['scripted']->value ? ' (заполняйте только если надо сменить пароль, иначе оставьте пустым)' : '';?>
"><input name="<?php echo htmlspecialchars((($tmp = @@ADMINS_POSTVAR_PASS)===null||$tmp==='' ? 'password' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" maxlength="20" type="text" value="" <?php echo $_smarty_tpl->tpl_vars['temp_script']->value;?>
 /></div><span class="label">имя:</span><div class="price_edit admin_name_edit" title="Имя администратора"><input name="<?php echo htmlspecialchars((($tmp = @@ADMINS_POSTVAR_NAME)===null||$tmp==='' ? 'name' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" maxlength="60" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['temp_script']->value;?>
 /></div></div><div class="line" style="padding-top: 9px;"><span>права:</span><div class="price_edit admin_rights_edit" title="Права доступа (список разрешённых модулей через запятую или пустая строка, если разрешено всё)"><input name="<?php echo htmlspecialchars((($tmp = @@ADMINS_POSTVAR_RIGHTS)===null||$tmp==='' ? 'rights' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->rights)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['temp_script']->value;?>
 /></div><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_THISONE)===null||$tmp==='' ? 'post_this_one' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" type="submit" <?php echo $_smarty_tpl->tpl_vars['temp_value']->value;?>
 onclick="javascript: return Prepare_PageThisOnePost('items_form');" /></div><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST)===null||$tmp==='' ? 'post' : $tmp), ENT_QUOTES, 'UTF-8');?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
']" type="hidden" value="" /><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php $_smarty_tpl->tpl_vars['temp_var'] = new Smarty_variable((($tmp = @@ADMINS_SMARTYVAR_ITEMS)===null||$tmp==='' ? 'items' : $tmp), null, 0);?><?php if (isset($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['temp_var']->value)]->value)&&is_array($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['temp_var']->value)]->value)&&!empty($_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['temp_var']->value)]->value)){?><?php echo $_smarty_tpl->getSubTemplate ('admin_pages_navigation.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('Pages'=>false), 0);?>
<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['temp_var']->value)]->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?><?php $_smarty_tpl->tpl_vars['temp_id'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['c']->value->login)===null||$tmp==='' ? 'undefined' : $tmp), null, 0);?><li class="flatlist"><div class="onerow"><input class="checkbox" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_DELETEIDS)===null||$tmp==='' ? 'delete_items' : $tmp), ENT_QUOTES, 'UTF-8');?>
[]" title="Пометить на удаление" type="checkbox" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_id']->value, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Toggle_LiTransparency(this, !this.checked, 0.3); Check_DeleteSelected_Button();"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_script']->value, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->delete_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="javascript: return confirm('Данная запись будет удалена с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_delete_16x16.png" /></a><span class="topic" style="display: inline;"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.</span><?php $_smarty_tpl->tpl_vars['temp_name'] = new Smarty_variable(htmlspecialchars((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['c']->value->name)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['c']->value->login : $tmp))===null||$tmp==='' ? 'Без названия!' : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo $_smarty_tpl->tpl_vars['temp_name']->value;?>
" onclick="javascript: return false;"><?php echo $_smarty_tpl->tpl_vars['temp_name']->value;?>
</a></div><?php smarty_template_function_AdminsModule_card_inputs($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['c']->value,'id'=>$_smarty_tpl->tpl_vars['temp_id']->value,'scripted'=>true));?>
<?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->login)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp']->value!=''){?><div class="line" title="Был логин: <?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
"><span>был логин:</span><?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
</div><?php }?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->name)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp']->value!=''){?><div class="line" title="Было имя: <?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
"><span>было имя:</span><?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
</div><?php }?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->rights)===null||$tmp==='' ? 'все' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><div class="line" title="Были права: <?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
"><span>права:</span><?php echo $_smarty_tpl->tpl_vars['temp']->value;?>
</div></li><?php } ?><?php echo $_smarty_tpl->getSubTemplate ('admin_pages_navigation.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('Pages'=>false), 0);?>
<?php }else{ ?><div class="noitems">Нет администраторов.</div><?php }?><li class="head_divider"><div>Добавить нового администратора</div></li><li class="flatlist"><?php smarty_template_function_AdminsModule_card_inputs($_smarty_tpl,array('item'=>false,'id'=>'','scripted'=>false));?>
</li><?php if ((($tmp = @$_smarty_tpl->tpl_vars['from_page']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FROM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['from_page']->value, ENT_QUOTES, 'UTF-8');?>
"><?php }?><input id="items_form_<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="" /><input id="items_form_<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_IGNORE_POST)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_IGNORE_POST)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1" /><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></form><br><a name="help"></a><div class="help" id="help_box" style="display: none;"><div class="title">Справка</div><div><b>Логин</b>. Наравне с англо-цифро-буквенными допустимо использовать логины в национальном написании, например на русском языке. Допустимы также логины из нескольких слов.<br><br><u>Важно:</u> Смена логина любого администратора, который в этот момент работал с админпанелью, вынудит его пройти повторную авторизацию под новым логином.<br><br><br></div><div><b>Пароль</b>. Всегда заполняется для нового администратора. Для уже существующих администраторов заполняется только в том случае, если требуется сменить его пароль. Если пароль менять не нужно, то при редактировании администратора это поле оставьте пустым.<br><br><u>Важно:</u> Смена пароля любого администратора, который в этот момент работал с админпанелью, вынудит его пройти повторную авторизацию с новым паролем.<br><br><br></div><div><b>Имя</b>. Данное поле не несет какой-либо оперативной нагрузки, заполняется произвольно и служит лишь справочным целям. Например здесь можно указать условное название данного администратора.<br><br><br></div><div><b>Права доступа</b>. В этом поле перечисляются через запятую названия тех модулей (страниц) админпанели, к которым разрешен доступ данного администратора. Если кому-либо надо разрешить абсолютный доступ (супер администратор), оставьте это поле пустым. Такая схема автоматически блокирует доступ к любому новому модулю всех не супер администраторов, пока им явно не будет прописано право доступа в том числе и к этому новому модулю.<br><br><u>Важно:</u> Соблюдать регистр букв в названии модулей необязательно.<br><br><u>Важно:</u> Под названием модуля понимается то имя, которое существует в url (адресе) конкретной страницы админпанели, а именно в параметре <i><?php echo $_smarty_tpl->tpl_vars['temp_param']->value;?>
</i> этого url. Например согласно адресу страницы редактирования администраторов <i><?php echo $_smarty_tpl->tpl_vars['temp_url_form']->value;?>
</i>, название ее модуля равно <i><?php echo $_smarty_tpl->tpl_vars['temp_module']->value;?>
</i>.<br><br><u>Важно:</u> Если по какой-то причине Вы не хотите использовать на сайте супер администраторов, то хотя бы одному из администраторов оставьте право доступа к модулю <i><?php echo $_smarty_tpl->tpl_vars['temp_module']->value;?>
</i>. Иначе ни один администратор потом не сможет изменить права, эта страница окажется закрытой для всех. Поможет только физическое редактирование по FTP файла <i>.passwd</i>, находящегося в папке админпанели.<br><br><u>Важно:</u> Большинство страниц, которые выводят списки элементов, имеют отдельную страницу редактирования элемента. Однако обе страницы обрабатываются двумя разными модулями. То есть, разрешив администратору доступ к модулю например <i>Menus</i> (список менюшек сайта), это вовсе не значит, что мы разрешили тем самым и доступ к модулю <i>Menu</i> (страница редактирования меню). Не забывайте об этом нюансе - раздельное назначение прав доступа для пар модулей, где один выступает редакционным дополнением другого. Как правило, дополняющий модуль назван как первый, но в единственном числе.<br><br><br></div><div><b>Удаление</b>. Данное действие в отношении любого администратора, который в этот момент работал с админпанелью, вынудит его пройти повторную авторизацию под другим действующим логином.<br><br><u>Важно:</u> Так как система подразумевает наличие хотя бы одного администратора, то даже если Вы удалите всех, система автоматически создаст нового супер администратора с одинаковым логином и паролем <i><?php echo (($tmp = @@ADMINS_DEFAULT_LOGIN)===null||$tmp==='' ? '' : $tmp);?>
</i>.</div></div></div><?php }} ?>