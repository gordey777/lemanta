<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:12
         compiled from "../admin/design/default/html/reset_caches/reset_caches.htm" */ ?>
<?php /*%%SmartyHeaderCode:203410254657d5b6a03de6b8-79848130%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '660d3e33d2b3f0444a91bda04b24fbde0cfd940a' => 
    array (
      0 => '../admin/design/default/html/reset_caches/reset_caches.htm',
      1 => 1462406661,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203410254657d5b6a03de6b8-79848130',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_pointer' => 0,
    'site' => 0,
    'admin_folder' => 0,
    'url_main' => 0,
    'url_script' => 0,
    'section_paramname' => 0,
    'settings' => 0,
    'token_paramname' => 0,
    'Token' => 0,
    'title' => 0,
    'message' => 0,
    'error' => 0,
    'url_form' => 0,
    'param' => 0,
    'files_host_suffix' => 0,
    'value' => 0,
    'from_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a04ac192_83310298',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a04ac192_83310298')) {function content_57d5b6a04ac192_83310298($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['module_pointer'] = new Smarty_variable((($tmp = @@RESETCACHES_MODULELINK_POINTER)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['section_paramname'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['token_paramname'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php echo $_smarty_tpl->getSubTemplate ('../../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('main'=>true,'me'=>(($tmp = @@RESETCACHES_MODULETAB_TEXT)===null||$tmp==='' ? '' : $tmp),'me_pointer'=>$_smarty_tpl->tpl_vars['module_pointer']->value,'me_menupath'=>(($tmp = @@RESETCACHES_MODULEMENU_PATH)===null||$tmp==='' ? '' : $tmp),'select'=>'me'), 0);?>
<?php $_smarty_tpl->tpl_vars['url_main'] = new Smarty_variable(((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)))).('/'), null, 0);?><?php $_smarty_tpl->tpl_vars['url_script'] = new Smarty_variable(($_smarty_tpl->tpl_vars['url_main']->value).('index.php'), null, 0);?><?php $_smarty_tpl->tpl_vars['url_form'] = new Smarty_variable((((((htmlspecialchars($_smarty_tpl->tpl_vars['url_script']->value, ENT_QUOTES, 'UTF-8'))).('?')).((htmlspecialchars($_smarty_tpl->tpl_vars['section_paramname']->value, ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8'))), null, 0);?><?php $_smarty_tpl->tpl_vars['url_images'] = new Smarty_variable(((((htmlspecialchars($_smarty_tpl->tpl_vars['url_main']->value, ENT_QUOTES, 'UTF-8'))).('design/')).((htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('/images/'), null, 0);?><?php $_smarty_tpl->tpl_vars['url_goto'] = new Smarty_variable(((((htmlspecialchars($_smarty_tpl->tpl_vars['url_script']->value, ENT_QUOTES, 'UTF-8'))).('?')).((htmlspecialchars($_smarty_tpl->tpl_vars['section_paramname']->value, ENT_QUOTES, 'UTF-8')))).('='), null, 0);?><?php $_smarty_tpl->tpl_vars['url_request'] = new Smarty_variable(((((((((htmlspecialchars($_smarty_tpl->tpl_vars['url_script']->value, ENT_QUOTES, 'UTF-8'))).('?')).((htmlspecialchars($_smarty_tpl->tpl_vars['token_paramname']->value, ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('&')).((htmlspecialchars($_smarty_tpl->tpl_vars['section_paramname']->value, ENT_QUOTES, 'UTF-8')))).('='), null, 0);?><div class="box"><h1><div class="path"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url_main']->value, ENT_QUOTES, 'UTF-8');?>
">Главная</a> → Кеши</div><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? 'Очистка кешей' : $tmp);?>
</h1><div class="toolkey">&nbsp;</div><?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="message"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div><?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="error"><b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><form action="<?php echo $_smarty_tpl->tpl_vars['url_form']->value;?>
" id="item_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);"><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_high" rowspan="4">Что сделать:</td><td class="param_short" title="Очистить ли кеш шаблонов клиентской стороны"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@RESETCACHES_SMARTYVAR_CLEAR_CLIENT_TPL)===null||$tmp==='' ? 'clear_client_tpl' : $tmp), null, 0);?><input class="checkbox" id="item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" value="1" /><span onclick="javascript: Toggle_PageCheckbox('item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
');">&nbsp;Очистить кеш шаблонов клиентской стороны сайта</span></td><td class="value value_sheet" width="100%" title="Расположение папки кеша"><input class="edit bright-checkbox" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
compiled<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['files_host_suffix']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="value_box" title="Выполнить помеченные действия"><input class="submit" type="submit" value="Выполнить" /></td></tr><tr><td class="param_short" title="Очистить ли кеш шаблонов админпанели"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@RESETCACHES_SMARTYVAR_CLEAR_ADMIN_TPL)===null||$tmp==='' ? 'clear_admin_tpl' : $tmp), null, 0);?><input class="checkbox" id="item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" value="1" /><span onclick="javascript: Toggle_PageCheckbox('item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
');">&nbsp;Очистить кеш шаблонов админпанели</span></td><td class="value value_sheet" colspan="2" width="100%" title="Расположение папки кеша"><input class="edit bright-checkbox" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
/compiled<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['files_host_suffix']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td></tr><tr><td class="param_short" title="Очистить ли кеши таблиц базы данных"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@RESETCACHES_SMARTYVAR_CLEAR_DB)===null||$tmp==='' ? 'clear_db' : $tmp), null, 0);?><input class="checkbox" id="item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" value="1" checked /><span onclick="javascript: Toggle_PageCheckbox('item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
');">&nbsp;Очистить кеши таблиц базы данных</span></td><td class="value value_sheet" colspan="2" width="100%" title="Список кешей таблиц"><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'value', null); ob_start(); ?><?php echo (($tmp = @@DATABASE_CACHE_CBPRODUCTS_SHORTVERSION_TABLENAME)===null||$tmp==='' ? '' : $tmp);?>
, <?php echo (($tmp = @@DATABASE_CACHE_CATEGORIES_TABLENAME)===null||$tmp==='' ? '' : $tmp);?>
, <?php echo (($tmp = @@DATABASE_CACHE_BRANDS_TABLENAME)===null||$tmp==='' ? '' : $tmp);?>
, <?php echo (($tmp = @@DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME)===null||$tmp==='' ? '' : $tmp);?>
, <?php echo (($tmp = @@DATABASE_CACHE_MENUS_SHORTVERSION_TABLENAME)===null||$tmp==='' ? '' : $tmp);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><input class="edit bright-checkbox" readonly type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" /></td></tr><tr><td class="param_short" colspan="3" title="Инициировать ли проверку таблиц базу данных"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@RESETCACHES_SMARTYVAR_RECHECK_DB)===null||$tmp==='' ? 'recheck_db' : $tmp), null, 0);?><input class="checkbox" id="item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" value="1" checked /><span onclick="javascript: Toggle_PageCheckbox('item_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
');">&nbsp;Инициировать проверку структурного соответствия таблиц базы данных</span></td></tr></table><?php if ((($tmp = @$_smarty_tpl->tpl_vars['from_page']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FROM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['from_page']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1" /><input name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token_paramname']->value, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></form><a name="help"></a><div class="help" id="help_box"><div class="title">Справка</div><div><b>Кеши шаблонов</b>. Существуют отдельно для клиентской стороны сайта и его админпанели. Как правило, очистка не требуется, поскольку движок сам следит за этим. Однако при смене хостинга возможны накладки из-за различия компиляционных условий. Выражаются они в визуальном искажении дизайна сайта. Для устранения таких проблем и созданы два этих флажка.</div><div><u>Тонкости</u>: После очистки кеша шаблонов можно заметить, как шаблонизатор Smarty подтормаживает разные страницы сайта, пока не закеширует их компилированные версии. Скорость кеширования (компиляции) зависит от производительности сервера, и на некоторых хостингах замечено было много секундное подтормаживание. Далее скомпилированные страницы открываются с обычной скоростью.</div><div><b>Кеши таблиц</b>. Их очисткой через определенные промежутки времени движок занимается самостоятельно. Но не исключены и даже были ситуации, когда переносят базу данных с сервера на сервер вручную по частям. Тогда может получиться, что какие-то сведения в кешах уже устарели, но пока не пройден некий период времени и движок при том не знает, что в сборку кеша кто-то вмешивался, то на сайте информация словно замерзает, показывая не те (не "свежие") данные.</div><div><b>Проверка структуры</b>. Движок периодически выполняет такую проверку, например при смене версий. Однако может понадобиться принудительное вмешательство, поэтому создан данный флажок. Суть проверки - убедиться, что структура таблиц не нарушена, то есть все необходимые поля существуют, а сами поля имеют требуемые типы. Инициированная проверка прозрачно стартует в момент следующего открытия любой страницы, и при обнаружении изъянов производится автоматическая коррекция таблиц до желаемой структуры.</div></div></div><?php }} ?>