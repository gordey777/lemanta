<?php /* Smarty version Smarty-3.1.8, created on 2016-09-29 10:06:31
         compiled from "../admin/design/default/html/common/functions.htm" */ ?>
<?php /*%%SmartyHeaderCode:139671663857ecbd77e8e035-97634454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f2261fc230ba99a6d812fae8999daff67092b3f' => 
    array (
      0 => '../admin/design/default/html/common/functions.htm',
      1 => 1462406638,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139671663857ecbd77e8e035-97634454',
  'function' => 
  array (
    'filter_editbox' => 
    array (
      'parameter' => 
      array (
        'param' => '',
      ),
      'compiled' => '',
    ),
    'filter_checkbox' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'shadow' => false,
        'image' => '',
        'text' => '',
        'style' => '',
        'invertable' => false,
      ),
      'compiled' => '',
    ),
    'get_setting' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'def' => '',
      ),
      'compiled' => '',
    ),
    'settings_checkbox' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'image' => '',
        'text' => '',
        'title' => '',
        'width' => '',
        'colspan' => 1,
      ),
      'compiled' => '',
    ),
    'settings_editbox' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'text' => '',
        'title' => '',
        'value' => false,
        'width' => '',
        'colspan' => 1,
        'rowspan' => 1,
        'size' => 0,
        'flat' => false,
        'short' => true,
        'text_width' => '',
        'text_colspan' => 1,
        'text_rowspan' => 1,
      ),
      'compiled' => '',
    ),
    'settings_textarea' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'text' => '',
        'title' => '',
        'value' => false,
        'width' => '',
        'colspan' => 1,
        'rowspan' => 1,
        'style' => '',
        'flat' => false,
        'text_width' => '',
        'text_colspan' => 1,
        'text_rowspan' => 1,
      ),
      'compiled' => '',
    ),
    'get_item_string' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'def' => '',
        'escaped' => true,
      ),
      'compiled' => '',
    ),
    'items_checkbox' => 
    array (
      'parameter' => 
      array (
        'id' => '*',
        'param' => '',
        'as_icon' => false,
        'image' => '',
        'text' => '',
        'class' => 'param_short',
        'title' => '',
        'width' => '',
        'colspan' => 1,
        'rowspan' => 1,
        'onchange' => '',
        'options' => '',
      ),
      'compiled' => '',
    ),
    'hidden_editbox' => 
    array (
      'parameter' => 
      array (
        'param' => '',
        'id' => false,
        'value' => '',
      ),
      'compiled' => '',
    ),
    'save_button' => 
    array (
      'parameter' => 
      array (
        'width' => '',
      ),
      'compiled' => '',
    ),
    'start_button' => 
    array (
      'parameter' => 
      array (
        'text' => 'Старт',
        'width' => '',
      ),
      'compiled' => '',
    ),
    'main_title' => 
    array (
      'parameter' => 
      array (
        'alt' => 'Без названия!',
        'path' => 'Без пути!',
      ),
      'compiled' => '',
    ),
    'info_message' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'error_message' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'common_functions_included' => 0,
    'site' => 0,
    'domain' => 0,
    'admin_folder' => 0,
    'admin_site' => 0,
    'param' => 0,
    'admin_script' => 0,
    'settings' => 0,
    'theme' => 0,
    'inputs' => 0,
    'Token' => 0,
    'token' => 0,
    'id' => 0,
    'value' => 0,
    'shadow' => 0,
    'checked' => 0,
    'style' => 0,
    'image' => 0,
    'admin_theme' => 0,
    'text' => 0,
    'invertable' => 0,
    'k' => 0,
    'v' => 0,
    'def' => 0,
    'p' => 0,
    'title' => 0,
    'colspan' => 0,
    'width' => 0,
    'rowspan' => 0,
    'size' => 0,
    'text_colspan' => 0,
    'text_rowspan' => 0,
    'text_width' => 0,
    'short' => 0,
    'flat' => 0,
    'item' => 0,
    'escaped' => 0,
    'class' => 0,
    'as_icon' => 0,
    'image_suffix' => 0,
    'onchange' => 0,
    'options' => 0,
    'hide1' => 0,
    'hide2' => 0,
    'image_prefix' => 0,
    'path' => 0,
    'alt' => 0,
    'message' => 0,
    'error' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57ecbd7818b297_95704430',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ecbd7818b297_95704430')) {function content_57ecbd7818b297_95704430($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (!(($tmp = @$_smarty_tpl->tpl_vars['common_functions_included']->value)===null||$tmp==='' ? false : $tmp)){?><?php $_smarty_tpl->tpl_vars['domain'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['domain'] = new Smarty_variable(preg_replace('!^([a-z]+://[^/]+/).*$!iu','$1',$_smarty_tpl->tpl_vars['domain']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['domain'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['domain']->value, ENT_QUOTES, 'UTF-8'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['domain'] = clone $_smarty_tpl->tpl_vars['domain']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['domain'] = clone $_smarty_tpl->tpl_vars['domain'];?><?php $_smarty_tpl->tpl_vars['site'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['site'] = clone $_smarty_tpl->tpl_vars['site']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['site'] = clone $_smarty_tpl->tpl_vars['site'];?><?php $_smarty_tpl->tpl_vars['admin_site'] = new Smarty_variable((($_smarty_tpl->tpl_vars['site']->value).((htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('/'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['admin_site'] = clone $_smarty_tpl->tpl_vars['admin_site']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['admin_site'] = clone $_smarty_tpl->tpl_vars['admin_site'];?><?php $_smarty_tpl->tpl_vars['admin_script'] = new Smarty_variable(($_smarty_tpl->tpl_vars['admin_site']->value).('index.php'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['admin_script'] = clone $_smarty_tpl->tpl_vars['admin_script']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['admin_script'] = clone $_smarty_tpl->tpl_vars['admin_script'];?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['param']->value,'/[=\?#]/u',''), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_goto'] = new Smarty_variable(((($_smarty_tpl->tpl_vars['admin_script']->value).('?')).((htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8')))).('='), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['admin_goto'] = clone $_smarty_tpl->tpl_vars['admin_goto']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['admin_goto'] = clone $_smarty_tpl->tpl_vars['admin_goto'];?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_theme'] = new Smarty_variable(((($_smarty_tpl->tpl_vars['admin_site']->value).('design/')).((htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8')))).('/'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['admin_theme'] = clone $_smarty_tpl->tpl_vars['admin_theme']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['admin_theme'] = clone $_smarty_tpl->tpl_vars['admin_theme'];?><?php $_smarty_tpl->tpl_vars['theme'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['theme']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['theme'] = clone $_smarty_tpl->tpl_vars['theme']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['theme'] = clone $_smarty_tpl->tpl_vars['theme'];?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['param']->value,'/[=\?#]/u',''), null, 0);?><?php $_smarty_tpl->tpl_vars['token'] = new Smarty_variable((($tmp = @((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['param']->value])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['Token']->value : $tmp)))===null||$tmp==='' ? '' : $tmp), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['token'] = clone $_smarty_tpl->tpl_vars['token']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['token'] = clone $_smarty_tpl->tpl_vars['token'];?><?php $_smarty_tpl->tpl_vars['token_request'] = new Smarty_variable(htmlspecialchars(((($_smarty_tpl->tpl_vars['param']->value).('=')).($_smarty_tpl->tpl_vars['token']->value)), ENT_QUOTES, 'UTF-8'), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['token_request'] = clone $_smarty_tpl->tpl_vars['token_request']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['token_request'] = clone $_smarty_tpl->tpl_vars['token_request'];?><?php if (!function_exists('smarty_template_function_filter_editbox')) {
    function smarty_template_function_filter_editbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['filter_editbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_template = new Smarty_Internal_Template('eval:'.(('{$smarty.const.').($_smarty_tpl->tpl_vars['param']->value)).('|default:\'\'}'), $_smarty_tpl->smarty, $_smarty_tpl);$_smarty_tpl->assign('param',$_template->fetch()); ?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['param']->value])===null||$tmp==='' ? '' : $tmp), null, 0);?><input class="edit" id="items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_filter_checkbox')) {
    function smarty_template_function_filter_checkbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['filter_checkbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_template = new Smarty_Internal_Template('eval:'.(('{$smarty.const.').($_smarty_tpl->tpl_vars['param']->value)).('|default:\'\'}'), $_smarty_tpl->smarty, $_smarty_tpl);$_smarty_tpl->assign('param',$_template->fetch()); ?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['shadow']->value){?><input name="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" type="hidden" value="0" /><?php }?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['param']->value])===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value!=0 ? 'checked' : '', null, 0);?><input class="checkbox" id="items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" type="checkbox" <?php echo $_smarty_tpl->tpl_vars['checked']->value;?>
 value="<?php echo $_smarty_tpl->tpl_vars['value']->value!=0 ? (htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8')) : 1;?>
" onchange="Start_PageRecordsFilter('items_form');" /> <?php $_smarty_tpl->tpl_vars['style'] = new Smarty_variable($_smarty_tpl->tpl_vars['style']->value!='' ? ((('style="').($_smarty_tpl->tpl_vars['style']->value)).('"')) : '', null, 0);?><span onclick="Toggle_PageCheckbox('items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');"><?php if ($_smarty_tpl->tpl_vars['image']->value!=''){?><img class="icon16x16" src="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['admin_theme']->value)===null||$tmp==='' ? '' : $tmp);?>
images/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
 /><?php }?><?php if ($_smarty_tpl->tpl_vars['text']->value!=''){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['text']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['invertable']->value){?><div class="inverted"><span onclick="var el = document.getElementById('items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'); if (el) if (!el.checked) el.value = -1; else if (el.value != -1) { el.value = -1; el.checked = false; }">противоположный</span><span onclick="var el = document.getElementById('items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'); if (el) if (!el.checked) el.value = 1; else if (el.value != 1) { el.value = 1; el.checked = false; }">обычный</span></div><?php }?></span><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_get_setting')) {
    function smarty_template_function_get_setting($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['get_setting']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['param']->value, 'UTF-8'), null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['settings']->value)&&(is_object($_smarty_tpl->tpl_vars['settings']->value)||is_array($_smarty_tpl->tpl_vars['settings']->value))){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['settings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (mb_strtolower($_smarty_tpl->tpl_vars['k']->value, 'UTF-8')==$_smarty_tpl->tpl_vars['param']->value){?><?php $_smarty_tpl->tpl_vars['def'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php }?><?php echo $_smarty_tpl->tpl_vars['def']->value;?>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (!function_exists('smarty_template_function_settings_checkbox')) {
    function smarty_template_function_settings_checkbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['settings_checkbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['p'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['param']->value, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars((smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['param']->value,'/^def_/iu','')), ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(false, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['settings']->value)&&(is_object($_smarty_tpl->tpl_vars['settings']->value)||is_array($_smarty_tpl->tpl_vars['settings']->value))){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['settings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (mb_strtolower($_smarty_tpl->tpl_vars['k']->value, 'UTF-8')==$_smarty_tpl->tpl_vars['p']->value){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value==true, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable($_smarty_tpl->tpl_vars['title']->value!='' ? ((('title="').((htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['colspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)>1 ? ((('colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['width'] = new Smarty_variable($_smarty_tpl->tpl_vars['width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><td class="param_short" <?php echo $_smarty_tpl->tpl_vars['colspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['width']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
><input class="checkbox" id="setup_form_<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" type="checkbox" value="1" <?php if ($_smarty_tpl->tpl_vars['value']->value){?> checked<?php }?> /> <?php if ($_smarty_tpl->tpl_vars['text']->value!=''||$_smarty_tpl->tpl_vars['image']->value!=''){?><span onclick="Toggle_PageCheckbox('setup_form_<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
');"><?php if ($_smarty_tpl->tpl_vars['image']->value!=''){?><img class="icon16x16" src="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['admin_theme']->value)===null||$tmp==='' ? '' : $tmp);?>
images/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php echo $_smarty_tpl->tpl_vars['text']->value!='' ? ' ' : '';?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</span><?php }?></td><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (!function_exists('smarty_template_function_settings_editbox')) {
    function smarty_template_function_settings_editbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['settings_editbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['p'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['param']->value, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars((smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['param']->value,'/^def_/iu','')), ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php if ($_smarty_tpl->tpl_vars['value']->value===false){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable('', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['settings']->value)&&(is_object($_smarty_tpl->tpl_vars['settings']->value)||is_array($_smarty_tpl->tpl_vars['settings']->value))){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['settings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (mb_strtolower($_smarty_tpl->tpl_vars['k']->value, 'UTF-8')==$_smarty_tpl->tpl_vars['p']->value){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php }?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable($_smarty_tpl->tpl_vars['title']->value!='' ? ((('title="').((htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['colspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)>1 ? ((('colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['rowspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['rowspan']->value)>1 ? ((('rowspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['rowspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['width'] = new Smarty_variable($_smarty_tpl->tpl_vars['width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['size'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['size']->value)>0 ? ((('size="').((sprintf('%d',$_smarty_tpl->tpl_vars['size']->value)))).('" style="width: auto;"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['text_colspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['text_colspan']->value)>1 ? ((('colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['text_colspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['text_rowspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['text_rowspan']->value)>1 ? ((('rowspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['text_rowspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['text_width'] = new Smarty_variable($_smarty_tpl->tpl_vars['text_width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['text_width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><td class="param<?php echo $_smarty_tpl->tpl_vars['short']->value ? '_short' : '';?>
" <?php echo $_smarty_tpl->tpl_vars['text_colspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['text_rowspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['text_width']->value;?>
><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</td><td class="value<?php echo $_smarty_tpl->tpl_vars['flat']->value ? ' value_sheet' : '';?>
" <?php echo $_smarty_tpl->tpl_vars['colspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['rowspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['width']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
><input class="edit" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['size']->value;?>
 type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" /></td><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (!function_exists('smarty_template_function_settings_textarea')) {
    function smarty_template_function_settings_textarea($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['settings_textarea']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['p'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['param']->value, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars((smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['param']->value,'/^def_/iu','')), ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php if ($_smarty_tpl->tpl_vars['value']->value===false){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable('', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['settings']->value)&&(is_object($_smarty_tpl->tpl_vars['settings']->value)||is_array($_smarty_tpl->tpl_vars['settings']->value))){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['settings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (mb_strtolower($_smarty_tpl->tpl_vars['k']->value, 'UTF-8')==$_smarty_tpl->tpl_vars['p']->value){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php }?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable($_smarty_tpl->tpl_vars['title']->value!='' ? ((('title="').((htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['colspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)>1 ? ((('colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['rowspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['rowspan']->value)>1 ? ((('rowspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['rowspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['width'] = new Smarty_variable($_smarty_tpl->tpl_vars['width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['style'] = new Smarty_variable($_smarty_tpl->tpl_vars['style']->value!='' ? ((('style="').((htmlspecialchars($_smarty_tpl->tpl_vars['style']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['text_colspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['text_colspan']->value)>1 ? ((('colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['text_colspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['text_rowspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['text_rowspan']->value)>1 ? ((('rowspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['text_rowspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['text_width'] = new Smarty_variable($_smarty_tpl->tpl_vars['text_width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['text_width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><td class="param_high" <?php echo $_smarty_tpl->tpl_vars['text_colspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['text_rowspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['text_width']->value;?>
><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</td><td class="value<?php echo $_smarty_tpl->tpl_vars['flat']->value ? ' value_sheet' : '';?>
" <?php echo $_smarty_tpl->tpl_vars['colspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['rowspan']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['width']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
><textarea name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['style']->value;?>
><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
</textarea></td><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_get_item_string')) {
    function smarty_template_function_get_item_string($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['get_item_string']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['param']->value, 'UTF-8'), null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&(is_object($_smarty_tpl->tpl_vars['item']->value)||is_array($_smarty_tpl->tpl_vars['item']->value))){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (mb_strtolower($_smarty_tpl->tpl_vars['k']->value, 'UTF-8')==$_smarty_tpl->tpl_vars['param']->value){?><?php $_smarty_tpl->tpl_vars['def'] = new Smarty_variable(trim(preg_replace('/[\s \t\r\n]+/u',' ',$_smarty_tpl->tpl_vars['v']->value)), null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php }?><?php if ($_smarty_tpl->tpl_vars['escaped']->value){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['def']->value, ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['def']->value;?>
<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><?php if (!function_exists('smarty_template_function_items_checkbox')) {
    function smarty_template_function_items_checkbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['items_checkbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['p'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['param']->value, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(false, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&(is_object($_smarty_tpl->tpl_vars['item']->value)||is_array($_smarty_tpl->tpl_vars['item']->value))){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php if (mb_strtolower($_smarty_tpl->tpl_vars['k']->value, 'UTF-8')==$_smarty_tpl->tpl_vars['p']->value){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value==true, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable($_smarty_tpl->tpl_vars['class']->value!='' ? (((' class="').((htmlspecialchars($_smarty_tpl->tpl_vars['class']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable($_smarty_tpl->tpl_vars['title']->value!='' ? (((' title="').((htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['colspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)>1 ? (((' colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['rowspan'] = new Smarty_variable(sprintf('%d',$_smarty_tpl->tpl_vars['rowspan']->value)>1 ? (((' rowspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['rowspan']->value)))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['width'] = new Smarty_variable($_smarty_tpl->tpl_vars['width']->value!='' ? (((' width="').((htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['image_prefix'] = new Smarty_variable($_smarty_tpl->tpl_vars['as_icon']->value ? 'icon_' : '', null, 0);?><?php $_smarty_tpl->tpl_vars['image_suffix'] = new Smarty_variable($_smarty_tpl->tpl_vars['as_icon']->value&&!$_smarty_tpl->tpl_vars['value']->value ? '_off' : '', null, 0);?><?php $_smarty_tpl->tpl_vars['image_suffix'] = new Smarty_variable($_smarty_tpl->tpl_vars['as_icon']->value ? (($_smarty_tpl->tpl_vars['image_suffix']->value).('_16x16.png')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['onchange'] = new Smarty_variable(smarty_modifier_replace($_smarty_tpl->tpl_vars['onchange']->value,'"','\\"'), null, 0);?><?php $_smarty_tpl->tpl_vars['hide1'] = new Smarty_variable($_smarty_tpl->tpl_vars['as_icon']->value ? ' hidden-checkbox' : '', null, 0);?><?php $_smarty_tpl->tpl_vars['hide2'] = new Smarty_variable($_smarty_tpl->tpl_vars['as_icon']->value ? (((((' onchange="toggleCheckboxIcon(this, this.checked, \'').($_smarty_tpl->tpl_vars['image']->value)).('\');')).($_smarty_tpl->tpl_vars['onchange']->value)).('"')) : ($_smarty_tpl->tpl_vars['onchange']->value!='' ? (((' onchange="').($_smarty_tpl->tpl_vars['onchange']->value)).('"')) : ''), null, 0);?><?php $_smarty_tpl->tpl_vars['options'] = new Smarty_variable($_smarty_tpl->tpl_vars['options']->value!='' ? ((' ').($_smarty_tpl->tpl_vars['options']->value)) : '', null, 0);?><td<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
<?php echo $_smarty_tpl->tpl_vars['colspan']->value;?>
<?php echo $_smarty_tpl->tpl_vars['rowspan']->value;?>
<?php echo $_smarty_tpl->tpl_vars['width']->value;?>
<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php echo $_smarty_tpl->tpl_vars['options']->value;?>
><input class="checkbox<?php echo $_smarty_tpl->tpl_vars['hide1']->value;?>
" id="items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" value="1" data-value="<?php echo $_smarty_tpl->tpl_vars['value']->value ? 1 : 0;?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value){?> checked<?php }?><?php echo $_smarty_tpl->tpl_vars['hide2']->value;?>
 /> <?php if ($_smarty_tpl->tpl_vars['text']->value!=''||$_smarty_tpl->tpl_vars['image']->value!=''){?><span onclick="Toggle_PageCheckbox('items_form_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
');"><?php if ($_smarty_tpl->tpl_vars['image']->value!=''){?><img class="icon16x16<?php if ($_smarty_tpl->tpl_vars['as_icon']->value){?> icon16x16-key<?php if (!$_smarty_tpl->tpl_vars['value']->value){?> icon16x16-key-off<?php }?><?php }?>" src="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['admin_theme']->value)===null||$tmp==='' ? '' : $tmp);?>
images/<?php echo $_smarty_tpl->tpl_vars['image_prefix']->value;?>
<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
<?php echo $_smarty_tpl->tpl_vars['image_suffix']->value;?>
" /><?php echo $_smarty_tpl->tpl_vars['text']->value!='' ? ' ' : '';?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</span><?php }?></td><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_hidden_editbox')) {
    function smarty_template_function_hidden_editbox($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['hidden_editbox']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_template = new Smarty_Internal_Template('eval:'.(('{$smarty.const.').($_smarty_tpl->tpl_vars['param']->value)).('|default:\'\'}'), $_smarty_tpl->smarty, $_smarty_tpl);$_smarty_tpl->assign('param',$_template->fetch()); ?><?php if ($_smarty_tpl->tpl_vars['param']->value!=''){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value===true ? ((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['param']->value])===null||$tmp==='' ? '' : $tmp)) : $_smarty_tpl->tpl_vars['value']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable($_smarty_tpl->tpl_vars['id']->value ? ((('id="items_form_').($_smarty_tpl->tpl_vars['param']->value)).('"')) : '', null, 0);?><input <?php echo $_smarty_tpl->tpl_vars['id']->value;?>
 name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_save_button')) {
    function smarty_template_function_save_button($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['save_button']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars['width'] = new Smarty_variable($_smarty_tpl->tpl_vars['width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><td class="value_box" <?php echo $_smarty_tpl->tpl_vars['width']->value;?>
><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_SETUP)===null||$tmp==='' ? '' : $tmp), null, 0);?><input class="submit" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Сохранить" /></td><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_start_button')) {
    function smarty_template_function_start_button($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['start_button']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars['width'] = new Smarty_variable($_smarty_tpl->tpl_vars['width']->value!='' ? ((('width="').((htmlspecialchars($_smarty_tpl->tpl_vars['width']->value, ENT_QUOTES, 'UTF-8')))).('"')) : '', null, 0);?><td class="value_box" <?php echo $_smarty_tpl->tpl_vars['width']->value;?>
><input class="submit" type="submit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['text']->value, ENT_QUOTES, 'UTF-8');?>
" /></td><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><?php if (!function_exists('smarty_template_function_main_title')) {
    function smarty_template_function_main_title($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['main_title']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><h1><div class="path"><a href="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['admin_site']->value)===null||$tmp==='' ? '' : $tmp);?>
" title="Перейти на главную страницу админпанели">Главная</a> → <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['path']->value, ENT_QUOTES, 'UTF-8');?>
</div><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['alt']->value : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(smarty_modifier_replace($_smarty_tpl->tpl_vars['title']->value,'[b]','<b style="font-size: 10pt; font-weight: normal;">'), null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(smarty_modifier_replace($_smarty_tpl->tpl_vars['title']->value,'[/b]','</b>'), null, 0);?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_info_message')) {
    function smarty_template_function_info_message($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['info_message']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="message"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_error_message')) {
    function smarty_template_function_error_message($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['error_message']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="error"><b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php $_smarty_tpl->tpl_vars['common_functions_included'] = new Smarty_variable(true, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['common_functions_included'] = clone $_smarty_tpl->tpl_vars['common_functions_included']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['common_functions_included'] = clone $_smarty_tpl->tpl_vars['common_functions_included'];?><?php }?><?php }} ?>