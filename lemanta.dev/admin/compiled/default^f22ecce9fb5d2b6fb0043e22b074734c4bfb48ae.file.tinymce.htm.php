<?php /* Smarty version Smarty-3.1.8, created on 2016-09-13 15:45:21
         compiled from "/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/tinymce.htm" */ ?>
<?php /*%%SmartyHeaderCode:159787291757d7f4e16dc739-43150462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f22ecce9fb5d2b6fb0043e22b074734c4bfb48ae' => 
    array (
      0 => '/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/tinymce.htm',
      1 => 1462406574,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159787291757d7f4e16dc739-43150462',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'disabled_state' => 0,
    'admin_site' => 0,
    'site' => 0,
    'admin_folder' => 0,
    'settings' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d7f4e17a33b0_50232884',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d7f4e17a33b0_50232884')) {function content_57d7f4e17a33b0_50232884($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (!(($tmp = @$_smarty_tpl->tpl_vars['disabled_state']->value)===null||$tmp==='' ? false : $tmp)){?><?php $_smarty_tpl->tpl_vars['admin_site'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['admin_site']->value)===null||$tmp==='' ? (htmlspecialchars((((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)))).('/')), ENT_QUOTES, 'UTF-8')) : $tmp), null, 0);?><script language="JavaScript" src="<?php echo $_smarty_tpl->tpl_vars['admin_site']->value;?>
js/tiny_mce/tiny_mce.js" type="text/javascript"></script><script language="JavaScript" type="text/javascript">tinyMCE.init({mode:                    'specific_textareas',editor_selector:         'editor_small',theme:                   'advanced',skin:                    'default',theme_advanced_path:     false,<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_plugins)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>plugins:                 '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',apply_source_formatting: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_source_formatting)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,convert_urls:            <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_convert_urls)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,relative_urls:           <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_relative_urls)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,remove_script_host:      <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_remove_script_host)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,verify_css_classes:      <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_verify_css_classes)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,verify_html:             <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_verify_html)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,remove_linebreaks:       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_remove_linebreaks)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,remove_redundant_brs:    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_remove_redundant_brs)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,convert_newlines_to_brs: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_convert_newlines_to_brs)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,force_br_newlines:       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_force_br_newlines)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,force_p_newlines:        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_force_p_newlines)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,fix_list_elements:       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_fix_list_elements)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,entity_encoding:         'named',content_css:             '<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_native_css)===null||$tmp==='' ? false : $tmp)){?>js/tiny_mce/themes/advanced/skins/default/content.css<?php }else{ ?>../design/<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->theme)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
/css/style.css<?php }?>',spellchecker_languages:  '+Russian=ru,+English=en',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_valid_tags)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>valid_elements:          '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_extended_valid_tags)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>extended_valid_elements: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_buttons1)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons1:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_buttons2)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons2:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_buttons3)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons3:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_buttons4)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons4:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',theme_advanced_toolbar_location:   '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_buttons_bottom)===null||$tmp==='' ? false : $tmp) ? 'bottom' : 'top';?>
',theme_advanced_toolbar_align:      '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_buttons_rightalign)===null||$tmp==='' ? false : $tmp) ? 'right' : 'left';?>
',theme_advanced_statusbar_location: '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_statusbar)===null||$tmp==='' ? false : $tmp) ? 'bottom' : '';?>
',theme_advanced_resizing:           false,plugin_insertdate_dateFormat: '%d %B %Y года (%A) ',plugin_insertdate_timeFormat: 'в %H:%M ',pagebreak_separator: '<!-- my page break -->',paste_auto_cleanup_on_paste: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce1_cleanup_paste)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
});</script><script language="JavaScript" type="text/javascript">tinyMCE.init({mode:                    'specific_textareas',editor_selector:         'editor_big',theme:                   'advanced',skin:                    'default',theme_advanced_path:     false,<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_plugins)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>plugins:                 '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',apply_source_formatting: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_source_formatting)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,convert_urls:            <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_convert_urls)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,relative_urls:           <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_relative_urls)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,remove_script_host:      <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_remove_script_host)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,verify_css_classes:      <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_verify_css_classes)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,verify_html:             <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_verify_html)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,remove_linebreaks:       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_remove_linebreaks)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,remove_redundant_brs:    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_remove_redundant_brs)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,convert_newlines_to_brs: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_convert_newlines_to_brs)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,force_br_newlines:       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_force_br_newlines)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,force_p_newlines:        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_force_p_newlines)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,fix_list_elements:       <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_fix_list_elements)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
,entity_encoding:         'named',content_css:             '<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_native_css)===null||$tmp==='' ? false : $tmp)){?>js/tiny_mce/themes/advanced/skins/default/content.css<?php }else{ ?>../design/<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->theme)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
/css/style.css<?php }?>',spellchecker_languages:  '+Russian=ru,+English=en',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_valid_tags)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>valid_elements:          '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_extended_valid_tags)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>extended_valid_elements: '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_buttons1)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons1:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_buttons2)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons2:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_buttons3)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons3:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',<?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_buttons4)===null||$tmp==='' ? '' : $tmp)),'/[ \s\t\r\n\']/',''), null, 0);?>theme_advanced_buttons4:           '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
',theme_advanced_toolbar_location:   '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_buttons_bottom)===null||$tmp==='' ? false : $tmp) ? 'bottom' : 'top';?>
',theme_advanced_toolbar_align:      '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_buttons_rightalign)===null||$tmp==='' ? false : $tmp) ? 'right' : 'left';?>
',theme_advanced_statusbar_location: '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_statusbar)===null||$tmp==='' ? false : $tmp) ? 'bottom' : '';?>
',theme_advanced_resizing:           false,plugin_insertdate_dateFormat: '%d %B %Y года (%A) ',plugin_insertdate_timeFormat: 'в %H:%M ',pagebreak_separator: '<!-- my page break -->',paste_auto_cleanup_on_paste: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->tinymce2_cleanup_paste)===null||$tmp==='' ? false : $tmp) ? 'true' : 'false';?>
});</script><?php }?><?php }} ?>