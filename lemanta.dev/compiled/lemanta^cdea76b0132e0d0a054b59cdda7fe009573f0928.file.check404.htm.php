<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:20
         compiled from "design/lemanta/html/common/check404.htm" */ ?>
<?php /*%%SmartyHeaderCode:4265941657d5b6a87ee9b1-15357768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdea76b0132e0d0a054b59cdda7fe009573f0928' => 
    array (
      0 => 'design/lemanta/html/common/check404.htm',
      1 => 1473158176,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4265941657d5b6a87ee9b1-15357768',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'emulator' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a87ff141_80458718',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a87ff141_80458718')) {function content_57d5b6a87ff141_80458718($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->checkNoPage()){?><?php $_smarty_tpl->tpl_vars['v'] = new Smarty_variable($_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>
<?php $_smarty_tpl->tpl_vars['content'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content'];?><?php }elseif($_smarty_tpl->tpl_vars['emulator']->value->checkNoModule()){?><?php $_smarty_tpl->tpl_vars['v'] = new Smarty_variable($_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>
<?php $_smarty_tpl->tpl_vars['content'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content'];?><?php }?><?php }} ?>