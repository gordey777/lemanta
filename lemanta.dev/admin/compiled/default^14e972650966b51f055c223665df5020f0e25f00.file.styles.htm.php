<?php /* Smarty version Smarty-3.1.8, created on 2016-10-30 23:24:21
         compiled from "../admin/design/default/html/styles/styles.htm" */ ?>
<?php /*%%SmartyHeaderCode:1325647508581665057f6e49-43004106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14e972650966b51f055c223665df5020f0e25f00' => 
    array (
      0 => '../admin/design/default/html/styles/styles.htm',
      1 => 1462406674,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1325647508581665057f6e49-43004106',
  'function' => 
  array (
    'show_folders' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'show_files' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'settings' => 0,
    'admin_goto' => 0,
    'module_pointer' => 0,
    'action_param' => 0,
    'value' => 0,
    'token_request' => 0,
    'id_param' => 0,
    'admin_theme' => 0,
    'item' => 0,
    'items' => 0,
    'r' => 0,
    'count' => 0,
    'dir' => 0,
    'c' => 0,
    'admin_script' => 0,
    'level' => 0,
    'param' => 0,
    'section_param' => 0,
    'temp' => 0,
    'number' => 0,
    'CurrentPage' => 0,
    'CurrentPageMaxsize' => 0,
    'v' => 0,
    'token' => 0,
    'site' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_581665059949a1_13656765',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581665059949a1_13656765')) {function content_581665059949a1_13656765($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['module_pointer'] = new Smarty_variable((($tmp = @@STYLES_MODULELINK_POINTER)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php echo $_smarty_tpl->getSubTemplate ('../../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>'styles','main'=>true,'themes'=>true,'templates'=>true,'styles'=>true,'images'=>true), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ('common/functions.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php $_smarty_tpl->tpl_vars['id_param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_ITEMID)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['action_param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['section_param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><div class="box"><?php smarty_template_function_main_title($_smarty_tpl,array('alt'=>'Файлы стилей','path'=>'Стили','title'=>(('Файлы стилей: [b]шаблон ').(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->theme)===null||$tmp==='' ? '' : $tmp)))).('[/b]')));?>
<div class="box_part" id="styles_start_box" style="display: none;"><div class="toolkey">&nbsp;</div><div class="message">Выполняется указанное Вами действие.<br />Пожалуйста подождите.</div></div><div class="box_part" id="styles_list_box"><div class="toolkey"><a class="left" href="#help" onclick="Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://htmlbook.ru/css" target="_blank" title="Перейти в справочник CSS на сайте HtmlBook.ru">справочник CSS</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@ACTION_REQUEST_PARAM_VALUE_DOWNLOAD)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo $_smarty_tpl->tpl_vars['action_param']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
&<?php echo $_smarty_tpl->tpl_vars['token_request']->value;?>
" title="Загрузить файл в текущую папку" onclick="return Start_Popup('popupDOWNLOAD', null);">загрузить</a></div><?php smarty_template_function_info_message($_smarty_tpl,array());?>
<?php smarty_template_function_error_message($_smarty_tpl,array());?>
<form action="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
" enctype="multipart/form-data" id="items_form" method="post" onkeypress="return Ignore_KeypressSubmit(event);"><table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;"><tr><td class="param_short" title="Удалить текущую папку"><a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
" onclick="var object = document.getElementById('select_<?php echo $_smarty_tpl->tpl_vars['id_param']->value;?>
');if (typeof(object) != 'object' || object == null || !('options' in object) || !('length' in object.options) || !('selectedIndex' in object) || object.options.length <= object.selectedIndex) return false;object = object.options[object.selectedIndex];if (typeof(object) != 'object' || object == null || !('getAttribute' in object)) return false;object = object.getAttribute('link');if (!object || object == '') return false;if (!confirm('Данная папка будет удалена с сайта. Вы подтверждаете такую операцию?')) return false;this.href = object;return true;"><img class="microkey_right icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/icon_delete_16x16.png" /></a></td><?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><td class="param_short" title="Создать копию папки"><a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
" onclick="var object = document.getElementById('select_<?php echo $_smarty_tpl->tpl_vars['id_param']->value;?>
');if (typeof(object) != 'object' || object == null || !('options' in object) || !('length' in object.options) || !('selectedIndex' in object) || object.options.length <= object.selectedIndex) return false;object = object.options[object.selectedIndex];if (typeof(object) != 'object' || object == null || !('getAttribute' in object)) return false;object = object.getAttribute('link2');if (!object || object == '') return false;if (!confirm('Будет создана полная копия данной папки. Вы подтверждаете такую операцию?')) return false;this.href = object;return true;"><img class="microkey_right icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/icon_edit_16x16.png" /></a></td><?php }?><td class="param_short">текущая папка:</td><td class="value" width="60%" title="Выбор папки с файлами"><select class="thin" id="select_<?php echo $_smarty_tpl->tpl_vars['id_param']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['id_param']->value;?>
" onchange="Start_PageRecordsFilter('items_form');"><?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(0, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&is_array($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><?php if (!isset($_smarty_tpl->tpl_vars['r']->value->files)){?><?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@ACTION_REQUEST_PARAM_VALUE_DELETE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><option value="" link="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo $_smarty_tpl->tpl_vars['action_param']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
&<?php echo $_smarty_tpl->tpl_vars['id_param']->value;?>
=&<?php echo $_smarty_tpl->tpl_vars['token_request']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['count']->value==0){?> style="color: #808080;"<?php }?>>корень <?php if ($_smarty_tpl->tpl_vars['count']->value!=0){?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
 шт.)<?php }?></option><?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&is_array($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php if (!function_exists('smarty_template_function_show_folders')) {
    function smarty_template_function_show_folders($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_folders']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dir']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?><?php if (isset($_smarty_tpl->tpl_vars['c']->value->files)){?><?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(0, null, 0);?><?php if (is_array($_smarty_tpl->tpl_vars['c']->value->files)&&!empty($_smarty_tpl->tpl_vars['c']->value->files)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->files; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><?php if (!isset($_smarty_tpl->tpl_vars['r']->value->files)){?><?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((((($tmp = @$_smarty_tpl->tpl_vars['c']->value->path)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? '' : $tmp))), null, 0);?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['value']->value){?> selected<?php }?> link="<?php echo $_smarty_tpl->tpl_vars['admin_script']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->delete_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" link2="<?php echo $_smarty_tpl->tpl_vars['admin_script']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->copy_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['count']->value==0){?> style="color: #808080;"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['name'] = 'spaces';
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? 'Без названия!' : $tmp)), ENT_QUOTES, 'UTF-8');?>
 <?php if ($_smarty_tpl->tpl_vars['count']->value!=0){?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
 шт.)<?php }?></option><?php if (is_array($_smarty_tpl->tpl_vars['c']->value->files)&&!empty($_smarty_tpl->tpl_vars['c']->value->files)){?><?php smarty_template_function_show_folders($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['c']->value->files,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>
<?php }?><?php }?><?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_show_folders($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['items']->value,'level'=>1));?>
<?php }?></select></td><td class="param_short">&nbsp;&nbsp; в ней папку:</td><td class="value" width="40%" title="Имя новой папки, которая будет создана в текущей папке"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_NAME)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><input class="edit" name="<?php echo $_smarty_tpl->tpl_vars['param']->value;?>
" type="text" value="" /></td><td class="value_box"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@ACTION_REQUEST_PARAM_VALUE_CREATE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><input class="submit" type="submit" value="Создать" onclick="return Submit_Popup('?<?php echo $_smarty_tpl->tpl_vars['section_param']->value;?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo $_smarty_tpl->tpl_vars['action_param']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
', 'styles');" /></td></tr></table><div class="toolkey"><span>папка: <span>корень<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value)===null||$tmp==='' ? '' : $tmp)!=''){?>/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?></span></span></div><div class="popup" id="popupDOWNLOAD"><div class="popup_content"><div class="title"><div class="close"><a href="#" onclick="return Hide_Popup('popupDOWNLOAD');" title="Закрыть">x</a></div>Загрузка стилей</div><div class="cell">файл стилей или zip-архив стилей:<div class="input"><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo sprintf('%d',((($tmp = @@ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? '' : $tmp)));?>
" /><input class="input" disabled id="popupDOWNLOADfile" name="file" type="file" title="Какой файл требуется взять с Вашего компьютера (объем файла не более <?php echo sprintf('%d',(((($tmp = @@ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp))/1024));?>
 Кбайт)" /></div></div><div class="submit"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@ACTION_REQUEST_PARAM_VALUE_DOWNLOAD)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><input class="submit" type="submit" value="Начать" onclick="return Submit_Popup('?<?php echo $_smarty_tpl->tpl_vars['section_param']->value;?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo $_smarty_tpl->tpl_vars['action_param']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
', 'styles');" /></div></div></div><?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&is_array($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?><div class="navigator"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@ACTION_REQUEST_PARAM_VALUE_EDIT_ALL)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><input class="mass_submit disabled_button" disabled id="popupEDIT_SaveAllChangesKey1" type="submit" value="Сохранить все" title="Сохранить исправления во всех отредактированных файлах" onclick="return Submit_FileEdit_Popup('?<?php echo $_smarty_tpl->tpl_vars['section_param']->value;?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo $_smarty_tpl->tpl_vars['action_param']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
', 'styles');" /></div><?php $_smarty_tpl->_capture_stack[0][] = array('count', null, null); ob_start(); ?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp']->value!='' ? (($_smarty_tpl->tpl_vars['temp']->value).('/')) : '', null, 0);?><?php if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
?><?php if (!function_exists('smarty_template_function_show_files')) {
    function smarty_template_function_show_files($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_files']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dir']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?><?php if (isset($_smarty_tpl->tpl_vars['c']->value->files)){?><?php if (is_array($_smarty_tpl->tpl_vars['c']->value->files)&&!empty($_smarty_tpl->tpl_vars['c']->value->files)){?><?php smarty_template_function_show_files($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['c']->value->files));?>
<?php }?><?php }elseif((($tmp = @$_smarty_tpl->tpl_vars['c']->value->path)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['temp']->value){?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php $_smarty_tpl->_capture_stack[0][] = array('count', null, null); ob_start(); ?>1<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><li class="flatlist"><div class="onerow"><a href="<?php echo $_smarty_tpl->tpl_vars['admin_script']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->delete_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="return confirm('Данный файл будет удален с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/icon_delete_16x16.png" /></a><img class="microkey_left" src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/placeholder.gif" /><a href="<?php echo $_smarty_tpl->tpl_vars['admin_script']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->copy_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" title="Создать копию"><img class="microkey_right" src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/icon_edit_16x16.png" /></a><img class="microkey_left" src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/placeholder.gif" /><span class="topic" style="display: inline;"><?php if (isset($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php echo $_smarty_tpl->tpl_vars['number']->value+$_smarty_tpl->tpl_vars['CurrentPage']->value*((($tmp = @$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value)===null||$tmp==='' ? 0 : $tmp));?>
.<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['number']->value;?>
.<?php }?></span><?php if (isset($_smarty_tpl->tpl_vars['c']->value->ctime)&&(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->ctime,10,'',true)!='0000-00-00')){?><span class="date" title="Дата создания: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->ctime, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->ctime,10,'',true), ENT_QUOTES, 'UTF-8');?>
</span><?php }else{ ?><span class="date" title="Дата создания: неизвестно">неизвестно</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['c']->value->ctime)&&isset($_smarty_tpl->tpl_vars['c']->value->mtime)&&($_smarty_tpl->tpl_vars['c']->value->mtime!=$_smarty_tpl->tpl_vars['c']->value->ctime)&&(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->mtime,10,'',true)!='0000-00-00')){?><span class="date" title="Дата изменения: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->mtime, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->mtime,10,'',true), ENT_QUOTES, 'UTF-8');?>
</span><?php }else{ ?><span class="date" title="Дата изменения: не изменяли">не меняли</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['c']->value->permissions)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->permissions))!='')){?><span class="date" title="Права доступа к файлу (формат: Тип Владелец Группа Остальные; права: r = чтение, w = запись, x s t = исполнение, листинг папки; типы: l = символическая ссылка, s = сокет, b = специальный блок, c = специальный символ, d = папка, p = поток FIFO, u = неизвестный)"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->permissions), ENT_QUOTES, 'UTF-8');?>
</span><?php }else{ ?><span class="date" title="Права доступа: неизвестно">неизвестно</span><?php }?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filesize)===null||$tmp==='' ? 0 : $tmp), null, 0);?><span class="votes" title="Размер файла: <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['value']->value);?>
 байт"><?php if (sprintf('%d',$_smarty_tpl->tpl_vars['value']->value)>65536){?><?php echo sprintf('%d',($_smarty_tpl->tpl_vars['value']->value/1024));?>
 кбайт<?php }else{ ?><?php echo sprintf('%d',$_smarty_tpl->tpl_vars['value']->value);?>
 байт<?php }?></span><a href="<?php echo $_smarty_tpl->tpl_vars['admin_script']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->edit_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" title="<?php if (isset($_smarty_tpl->tpl_vars['c']->value->title)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? 'Без названия!' : $tmp)), ENT_QUOTES, 'UTF-8');?>
<?php }?>" onclick="return Start_FileEdit_Popup('popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
', this);"><?php if (isset($_smarty_tpl->tpl_vars['c']->value->title)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? 'Без названия!' : $tmp)), ENT_QUOTES, 'UTF-8');?>
<?php }?></a></div><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? 'Без названия!' : $tmp), null, 0);?><div class="line" title="Файл: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
"><span>файл:</span><input class="submit" disabled id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
_SaveChangesKey" type="submit" value="сохранить" style="display: none; margin-right: 20px;" title="Сохранить исправления только этого файла" onclick="return Submit_FileEdit_Popup('<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->edit_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
', 'styles');" /><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
</div><?php if (isset($_smarty_tpl->tpl_vars['c']->value->vars)&&is_array($_smarty_tpl->tpl_vars['c']->value->vars)&&!empty($_smarty_tpl->tpl_vars['c']->value->vars)){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->vars; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vars']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vars']['iteration']++;
?><div class="line template_var_line" title="Использует класс: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
" style="display: none;"><span><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vars']['iteration']==1){?>class:<?php }else{ ?>&nbsp;<?php }?></span><span class="subinfo"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
</span></div><?php } ?><?php }?></li><div class="popup popup_wide" id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
"><div class="popup_content"><div class="title"><div class="close"><a href="#" onclick="return Hide_Popup('popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
');" title="Закрыть">x</a></div><div class="close"><a href="#" onclick="jQuery(this).closest('.popup').toggleClass('popup_full'); return false;" title="Растянуть / восстановить">↔</a></div>Редактирование: <b style="font-size: 10pt; font-weight: normal;"><?php if (isset($_smarty_tpl->tpl_vars['c']->value->title)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? 'Без названия!' : $tmp)), ENT_QUOTES, 'UTF-8');?>
<?php }?></b></div><div class="cell">файл:<div class="input"><input class="input" disabled readonly id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
title" maxlength="64" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TITLE, ENT_QUOTES, 'UTF-8');?>
[<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? 'Без названия!' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" title="Имя файла" /></div></div><div class="cell">содержимое:<div class="input"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_CONTENT)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><textarea class="input" disabled id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
content" name="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
[<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->filename)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
]" style="height: 600px;" title="Содержимое файла"><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->content)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
</textarea></div></div><div class="submit"><input class="submit" type="submit" value="Сохранить" onclick="return Submit_FileEdit_Popup('<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['c']->value->edit_get)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
', 'styles');"></div></div></div><?php }?><?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_show_files($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['items']->value));?>
<?php if (Smarty::$_smarty_vars['capture']['count']==''){?><div class="noitems">Папка не содержит файлов.</div><?php }else{ ?><div class="navigator"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@ACTION_REQUEST_PARAM_VALUE_EDIT_ALL)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><input class="mass_submit disabled_button" disabled id="popupEDIT_SaveAllChangesKey2" type="submit" value="Сохранить все" title="Сохранить исправления во всех отредактированных файлах" onclick="return Submit_FileEdit_Popup('?<?php echo $_smarty_tpl->tpl_vars['section_param']->value;?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo $_smarty_tpl->tpl_vars['action_param']->value;?>
=<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
', 'styles');" /></div><?php }?><?php }else{ ?><div class="noitems">Папка не содержит файлов.</div><?php }?><?php smarty_template_function_hidden_editbox($_smarty_tpl,array('param'=>'REQUEST_PARAM_NAME_TOKEN','id'=>false,'value'=>$_smarty_tpl->tpl_vars['token']->value));?>
</form></div><a name="help"></a><div class="help" id="help_box" style="display: none;"><div class="title">Справка</div><div>&nbsp;</div></div></div><script src="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
js/codemirror/js/codemirror.js" type="text/javascript"></script><script language="JavaScript" type="text/javascript">var fileEdit_editors = new Array();var fileEdit_editors_changed = new Array();var fileEdit_editors_parserList = ['parsecss.js'];var fileEdit_editors_cssList = ['<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
js/codemirror/css/csscolors.css'];function Start_FileEdit_Popup (id, link_object) {Start_Popup(id, link_object);if (!fileEdit_editors[id]) {fileEdit_editors_changed[id] = false;fileEdit_editors[id] = CodeMirror.fromTextArea(id + 'content',{ height: '600px',parserfile: fileEdit_editors_parserList,stylesheet: fileEdit_editors_cssList,path: '<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
js/codemirror/js/',dumbTabs: true,saveFunction: null,onChange: function () {fileEdit_editors_changed[id] = true;var object = document.getElementById(id + '_SaveChangesKey');if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {object.style.display = 'inline';if ('disabled' in object) object.disabled = false;}object = document.getElementById('popupEDIT_SaveAllChangesKey1');if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {object.style.display = 'block';if ('disabled' in object) object.disabled = false;jQuery(object).removeClass('disabled_button');}object = document.getElementById('popupEDIT_SaveAllChangesKey2');if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {object.style.display = 'block';if ('disabled' in object) object.disabled = false;jQuery(object).removeClass('disabled_button');}},textWrapping: true });}return false;}function Submit_FileEdit_Popup (url_params, part_id) {for (id in fileEdit_editors) {var changed = !fileEdit_editors_changed[id] ? false : true;var object = !changed ? document.getElementById(id + '_SaveChangesKey') : null;if (changed || ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style))) {if (changed || (object.style.display == 'inline')) {object = document.getElementById(id + 'content');if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {object.value = fileEdit_editors[id].getCode();Unlock_Popup_Fields(id);}}}}return Submit_Popup(url_params, part_id);}</script><?php }} ?>