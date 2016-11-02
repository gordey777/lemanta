<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:57
         compiled from "../admin/design/default/html/config_file/config_file.htm" */ ?>
<?php /*%%SmartyHeaderCode:180222446557d5b6cd1a56c1-66434817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f60fbc417fb7412f91478a38d6f06f6f271d5976' => 
    array (
      0 => '../admin/design/default/html/config_file/config_file.htm',
      1 => 1462406639,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '180222446557d5b6cd1a56c1-66434817',
  'function' => 
  array (
    'configfilepage_submit_content' => 
    array (
      'parameter' => 
      array (
        'colspan' => 1,
      ),
      'compiled' => '',
    ),
    'configfilepage_name_input_content' => 
    array (
      'parameter' => 
      array (
        'field' => '',
        'value' => '',
        'param' => '',
      ),
      'compiled' => '',
    ),
    'configfilepage_input_content' => 
    array (
      'parameter' => 
      array (
        'field' => '',
        'value' => '',
        'param' => '',
      ),
      'compiled' => '',
    ),
    'configfilepage_type_select_content' => 
    array (
      'parameter' => 
      array (
        'field' => '',
        'value' => '',
        'param' => '',
      ),
      'compiled' => '',
    ),
    'configfilepage_bool_select_content' => 
    array (
      'parameter' => 
      array (
        'field' => '',
        'value' => false,
        'param' => '',
      ),
      'compiled' => '',
    ),
    'configfilepage_tr_content' => 
    array (
      'parameter' => 
      array (
        'required' => false,
        'field_input_boxed' => false,
        'field_input' => '',
        'value_input' => '',
        'type_input' => '',
        'hint' => '',
        'index' => 0,
        'field' => '',
        'param' => '',
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
    'colspan' => 0,
    'temp_url_form' => 0,
    'files_host_suffix' => 0,
    'param' => 0,
    'field' => 0,
    'value' => 0,
    'temp' => 0,
    'required' => 0,
    'temp_url_images' => 0,
    'field_input_boxed' => 0,
    'field_input' => 0,
    'value_input' => 0,
    'type_input' => 0,
    'hint' => 0,
    'index' => 0,
    'item' => 0,
    'temp_value' => 0,
    'temp_field' => 0,
    'temp_type' => 0,
    'config' => 0,
    'temp_required' => 0,
    'temp_input' => 0,
    'temp_hint' => 0,
    'temp_index' => 0,
    'from_page' => 0,
    'Token' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6cd2f6250_32518640',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6cd2f6250_32518640')) {function content_57d5b6cd2f6250_32518640($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><?php $_smarty_tpl->tpl_vars['temp_module'] = new Smarty_variable((($tmp = @@CONFIGFILE_MODULELINK_POINTER)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php echo $_smarty_tpl->getSubTemplate ('../../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('main'=>true,'me'=>(($tmp = @@CONFIGFILE_MODULETAB_TEXT)===null||$tmp==='' ? '' : $tmp),'me_pointer'=>$_smarty_tpl->tpl_vars['temp_module']->value,'me_menupath'=>(($tmp = @@CONFIGFILE_MODULEMENU_PATH)===null||$tmp==='' ? '' : $tmp),'select'=>'me'), 0);?>
<?php $_smarty_tpl->tpl_vars['temp_url_main'] = new Smarty_variable((((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)))).('/')), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_script'] = new Smarty_variable(($_smarty_tpl->tpl_vars['temp_url_main']->value).('index.php'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_images'] = new Smarty_variable(((((htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8'))).('design/')).((htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8')))).('/images/'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_form'] = new Smarty_variable((((($_smarty_tpl->tpl_vars['temp_url_script']->value).('?')).($_smarty_tpl->tpl_vars['temp_param']->value)).('=')).($_smarty_tpl->tpl_vars['temp_module']->value), null, 0);?><div class="box"><h1><div class="path"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
">Главная</a> → Конфигурация</div><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? 'Конфигурационный файл' : $tmp);?>
</h1><div class="toolkey"><a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;</div><?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="message"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div><?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="error"><b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><?php if (!function_exists('smarty_template_function_configfilepage_submit_content')) {
    function smarty_template_function_configfilepage_submit_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['configfilepage_submit_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><td class="value_box" <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)>1 ? ((('colspan="').((sprintf('%d',$_smarty_tpl->tpl_vars['colspan']->value)))).('"')) : '';?>
><input class="submit" type="submit" value="Сохранить" onclick="javascript: return confirm('Подтвердите свое желание сохранить изменения в этом файле!');" /></td><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_form']->value, ENT_QUOTES, 'UTF-8');?>
" id="items_form" method="post"><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_short">Файл:</td><td class="value value_sheet" title="Имя используемого конфигурационного файла" width="100%"><input class="edit bright-checkbox" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
Config<?php echo (($tmp = @$_smarty_tpl->tpl_vars['files_host_suffix']->value)===null||$tmp==='' ? '' : $tmp)!='' ? (htmlspecialchars($_smarty_tpl->tpl_vars['files_host_suffix']->value, ENT_QUOTES, 'UTF-8')) : '.class';?>
.php" /></td><?php smarty_template_function_configfilepage_submit_content($_smarty_tpl,array('colspan'=>1));?>
</tr></table><?php if (!function_exists('smarty_template_function_configfilepage_name_input_content')) {
    function smarty_template_function_configfilepage_name_input_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['configfilepage_name_input_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><input class="edit" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
_name['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value, ENT_QUOTES, 'UTF-8');?>
']" maxlength="35" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_configfilepage_input_content')) {
    function smarty_template_function_configfilepage_input_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['configfilepage_input_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['is_xml_name'][0][0]->is_xml_name_plugin(array('item'=>$_smarty_tpl->tpl_vars['value']->value,'assign'=>'temp'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['temp']->value){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['get_xml_name'][0][0]->get_xml_name_plugin(array('item'=>$_smarty_tpl->tpl_vars['value']->value,'assign'=>'temp'),$_smarty_tpl);?>
<?php }else{ ?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value, null, 0);?><?php }?><input class="edit" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value, ENT_QUOTES, 'UTF-8');?>
']" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_configfilepage_type_select_content')) {
    function smarty_template_function_configfilepage_type_select_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['configfilepage_type_select_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><select name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
_type['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value, ENT_QUOTES, 'UTF-8');?>
']"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['is_xml_name'][0][0]->is_xml_name_plugin(array('item'=>$_smarty_tpl->tpl_vars['value']->value,'assign'=>'temp'),$_smarty_tpl);?>
<option value="1" <?php echo is_bool($_smarty_tpl->tpl_vars['value']->value) ? "selected" : '';?>
>Булевое</option><option value="2" <?php echo is_string($_smarty_tpl->tpl_vars['value']->value)&&!$_smarty_tpl->tpl_vars['temp']->value ? "selected" : '';?>
>Строка</option><option value="3" <?php echo is_int($_smarty_tpl->tpl_vars['value']->value) ? "selected" : '';?>
>Целое число</option><option value="4" <?php echo is_float($_smarty_tpl->tpl_vars['value']->value) ? "selected" : '';?>
>Вещественное число</option><option value="5" <?php echo $_smarty_tpl->tpl_vars['temp']->value ? "selected" : '';?>
>XML файл</option></select><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_configfilepage_bool_select_content')) {
    function smarty_template_function_configfilepage_bool_select_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['configfilepage_bool_select_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><select name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value, ENT_QUOTES, 'UTF-8');?>
']"><option value="1" <?php echo $_smarty_tpl->tpl_vars['value']->value ? "selected" : '';?>
>да</option><option value="0" <?php echo !$_smarty_tpl->tpl_vars['value']->value ? "selected" : '';?>
>нет</option></select><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_configfilepage_tr_content')) {
    function smarty_template_function_configfilepage_tr_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['configfilepage_tr_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><td class="param_short" title="Признак обязательной настройки (создается ли автоматически при отсутствии)"><img class="icon16x16 icon16x16-key<?php if (!$_smarty_tpl->tpl_vars['required']->value){?> icon16x16-key-off<?php }?>" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_required<?php if (!$_smarty_tpl->tpl_vars['required']->value){?>_off<?php }?>_16x16.png" /></td><td class="<?php echo $_smarty_tpl->tpl_vars['field_input_boxed']->value ? 'value value_sheet' : 'param_short';?>
" title="Системное имя настройки"><?php echo $_smarty_tpl->tpl_vars['field_input']->value;?>
</td><td class="value value_sheet" width="30%" title="Поле ввода значения настройки"><?php echo $_smarty_tpl->tpl_vars['value_input']->value;?>
</td><td class="value value_sheet" width="20%" title="Тип значения настройки"><?php echo $_smarty_tpl->tpl_vars['type_input']->value;?>
</td><td class="param_short" colspan="2" width="40%" title="Подсказка о назначении настройки"><?php echo $_smarty_tpl->tpl_vars['hint']->value;?>
</td><td class="param_short" title="Использовать ли эту настройку"><input class="checkbox hidden-checkbox" checked id="fields_<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
_used" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
_used['<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value, ENT_QUOTES, 'UTF-8');?>
']" type="checkbox" value="1" onchange="javascript: Toggle_TableRowTransparency(this, this.checked, 0.3);" /><span onclick="javascript: Toggle_PageCheckbox('fields_<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
_used');"><img class="icon16x16 icon16x16-key" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_done_16x16.png" /></span></td><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<table align="center" cellpadding="0" cellspacing="20" class="white"><?php $_smarty_tpl->tpl_vars['temp_param'] = new Smarty_variable(htmlspecialchars((($tmp = @@CONFIGFILE_SMARTYVAR_ITEM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_index'] = new Smarty_variable(0, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&is_object($_smarty_tpl->tpl_vars['item']->value)){?><?php  $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['temp_value']->_loop = false;
 $_smarty_tpl->tpl_vars['temp_field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['temp_value']->key => $_smarty_tpl->tpl_vars['temp_value']->value){
$_smarty_tpl->tpl_vars['temp_value']->_loop = true;
 $_smarty_tpl->tpl_vars['temp_field']->value = $_smarty_tpl->tpl_vars['temp_value']->key;
?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['is_xml_name'][0][0]->is_xml_name_plugin(array('item'=>$_smarty_tpl->tpl_vars['temp_value']->value,'assign'=>'temp'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['temp']->value||is_bool($_smarty_tpl->tpl_vars['temp_value']->value)||is_string($_smarty_tpl->tpl_vars['temp_value']->value)||is_int($_smarty_tpl->tpl_vars['temp_value']->value)||is_float($_smarty_tpl->tpl_vars['temp_value']->value)){?><?php $_smarty_tpl->tpl_vars['temp_field'] = new Smarty_variable(smarty_modifier_regex_replace(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_field']->value,'/^[\s\t\r\n]+/',''),'/[\s\t\r\n]+$/',''), null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp_field']->value!=''){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(false, null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp']->value){?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('структура параметров из XML файла', null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('&nbsp;', null, 0);?><?php }?><?php ob_start(); smarty_template_function_configfilepage_input_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php ob_start(); smarty_template_function_configfilepage_type_select_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_type', ob_get_clean());?>
<?php if ($_smarty_tpl->tpl_vars['temp_field']->value=='only_remote_images'){?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('не закачивать внешние фотофайлы', null, 0);?><?php ob_start(); smarty_template_function_configfilepage_bool_select_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='dbname'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('имя используемой базы данных', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['config']->value->demo)===null||$tmp==='' ? false : $tmp)){?><?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_value']->value,'/./u','*'), null, 0);?><?php ob_start(); smarty_template_function_configfilepage_input_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php }?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='dbhost'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('адрес хоста сервера баз данных', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='dbuser'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('имя пользователя базы данных', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['config']->value->demo)===null||$tmp==='' ? false : $tmp)){?><?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_value']->value,'/./u','*'), null, 0);?><?php ob_start(); smarty_template_function_configfilepage_input_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php }?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='dbpass'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('пароль к базе данных', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['config']->value->demo)===null||$tmp==='' ? false : $tmp)){?><?php ob_start(); smarty_template_function_configfilepage_input_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>'************','param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php }?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='lang'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('язык интерфейса админпанели', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='debug'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('включить отладочный трассировщик', null, 0);?><?php ob_start(); smarty_template_function_configfilepage_bool_select_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='debug_on_admin_exist'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('трассировщик не виден клиентам', null, 0);?><?php ob_start(); smarty_template_function_configfilepage_bool_select_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='demo'){?><?php $_smarty_tpl->tpl_vars['temp_required'] = new Smarty_variable(true, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('движок работает в демо режиме', null, 0);?><?php ob_start(); smarty_template_function_configfilepage_bool_select_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['temp_field']->value=='smsDnevnik_disabled'){?><?php $_smarty_tpl->tpl_vars['temp_hint'] = new Smarty_variable('отключить СМС дневник', null, 0);?><?php ob_start(); smarty_template_function_configfilepage_bool_select_content($_smarty_tpl,array('field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value'=>$_smarty_tpl->tpl_vars['temp_value']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php $_smarty_tpl->tpl_vars['temp_type'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_type']->value,"/^<select /",'<select disabled '), null, 0);?><?php }?><tr><?php smarty_template_function_configfilepage_tr_content($_smarty_tpl,array('required'=>$_smarty_tpl->tpl_vars['temp_required']->value,'field_input_boxed'=>false,'field_input'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value_input'=>$_smarty_tpl->tpl_vars['temp_input']->value,'type_input'=>$_smarty_tpl->tpl_vars['temp_type']->value,'hint'=>$_smarty_tpl->tpl_vars['temp_hint']->value,'index'=>$_smarty_tpl->tpl_vars['temp_index']->value,'field'=>$_smarty_tpl->tpl_vars['temp_field']->value,'param'=>$_smarty_tpl->tpl_vars['temp_param']->value));?>
</tr><?php $_smarty_tpl->tpl_vars['temp_index'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_index']->value+1, null, 0);?><?php }?><?php }?><?php } ?><?php }?><tr><td class="param_short" colspan="5" width="100%"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить настройку" onclick="javascript: return Append_ConfigTableRow(this);">добавить</a></td><?php smarty_template_function_configfilepage_submit_content($_smarty_tpl,array('colspan'=>2));?>
</tr></table><script language="JavaScript" type="text/javascript">function Append_ConfigTableRow ( object ) {var table = jQuery(object).parent().parent().parent();if ((typeof(table) == 'object') && (table != null) && (table.length == 1)) {var tr = jQuery(table).find('tr');var num = tr.length;if (num > 0) {if (num <= 500) {var last_html = tr[num - 1].innerHTML;<?php ob_start(); smarty_template_function_configfilepage_name_input_content($_smarty_tpl,array('field'=>'[__field__]','value'=>'','param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_field', ob_get_clean());?>
<?php ob_start(); smarty_template_function_configfilepage_input_content($_smarty_tpl,array('field'=>'[__field__]','value'=>'','param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_input', ob_get_clean());?>
<?php ob_start(); smarty_template_function_configfilepage_type_select_content($_smarty_tpl,array('field'=>'[__field__]','value'=>'','param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp_type', ob_get_clean());?>
<?php ob_start(); smarty_template_function_configfilepage_tr_content($_smarty_tpl,array('required'=>false,'field_input_boxed'=>true,'field_input'=>$_smarty_tpl->tpl_vars['temp_field']->value,'value_input'=>$_smarty_tpl->tpl_vars['temp_input']->value,'type_input'=>$_smarty_tpl->tpl_vars['temp_type']->value,'hint'=>'&nbsp;','index'=>'[__index__]','field'=>'[__field__]','param'=>$_smarty_tpl->tpl_vars['temp_param']->value)); $_smarty_tpl->assign('temp', ob_get_clean());?>
var html = '<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['temp']->value,'\\','\\\\'),'\'','\\\'');?>
';var prev = '';while (prev != html) {prev = html;html = html.replace(/\[__index__\]/, num);}prev = '';while (prev != html) {prev = html;html = html.replace(/\[__field__\]/, 'new____________________' + num);}tr[num - 1].innerHTML = html;jQuery(table).append('<tr>' + last_html + '</tr>');} else {alert('Добавление новой настройки отклонено, так как это превысит лимит их допустимого количества!');}}}return false;}</script><?php if ((($tmp = @$_smarty_tpl->tpl_vars['from_page']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FROM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['from_page']->value, ENT_QUOTES, 'UTF-8');?>
"><?php }?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1" /><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></form><br><a name="help"></a><div class="help" id="help_box"><div class="title">Справка</div><div>Данная страница предназначена для формирования списка конфигурационных настроек. Существует несколько предопределенных, используемых системой и контролируемых так, что при их удалении, эти настройки будут созданы автоматически с дефолтными значениями. Остальные настройки можете создать на свое усмотрение. Такие настройки общие для клиентской стороны и админпанели, и могут быть использованы в шаблонах обеих сторон магазина, обратившись к объекту <i>$config</i> изнутри шаблона. Например, чтобы получить значение воображаемой настройки <i>ExampleTitle</i>, надо обратиться к <i>$config-&gt;ExampleTitle</i>. Обратиться к той же настройке изнутри PHP-модуля можно через <i>$this-&gt;config-&gt;ExampleTitle</i>.</div><div><u>Важно</u>: Внимательно отнеситесь к изменению настроек <i>dbhost</i>, <i>dbname</i>, <i>dbuser</i> и <i>dbpass</i>. В случае недействительных значений в этих авторизационных параметрах дальнейшее перемещение по страницам админпанели будет невозможным. Придется в указанный выше конфигурационный файл через FTP вручную вносить действительные значения этих параметров.</div><div><u>Важно</u>: При создании новой настройки учтите, что ее имя может содержать только английские буквы, цифры и знаки подчеркивания. Любые другие символы будут просто изъяты из имени. Причем имя настройки не может начинаться с цифры или знака подчеркивания. Эти ведущие цифры и ведущие или замыкающие подчеркивания также будут изъяты.</div><div><u>Важно</u>: Сохраненные изменения конфигурационных настроек начинают действовать лишь со следующего действия на сайте. То есть в момент выдачи уведомления о сохранении настроек страница админпанели на самом деле отрисована еще на основе прежних настроек.</div><div><b>XML файл</b>. Настройка такого типа означает, что в нее будет загружена структура параметров из указанного XML-файла. Фактически настройка превратится в объект класса SimpleXMLElement, а при отсутствии файла, неверном указании его имени (путь и имя задаем относительно корневой папки магазина) или некорректном содержимом - в пустой объект того же класса.</div></div></div><?php }} ?>