<?php /* Smarty version Smarty-3.1.8, created on 2016-11-02 15:45:01
         compiled from "design/lemanta/html\common\check404.htm" */ ?>
<?php /*%%SmartyHeaderCode:154515819dfcd0836b3-72945541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2cb15aa2cc4cb47ed40cc3368154caf0d8179558' => 
    array (
      0 => 'design/lemanta/html\\common\\check404.htm',
      1 => 1478016493,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '154515819dfcd0836b3-72945541',
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
  'unifunc' => 'content_5819dfcd0a66d5_77399440',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dfcd0a66d5_77399440')) {function content_5819dfcd0a66d5_77399440($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->checkNoPage()){?><?php $_smarty_tpl->tpl_vars['v'] = new Smarty_variable($_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>
<?php $_smarty_tpl->tpl_vars['content'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content'];?><?php }elseif($_smarty_tpl->tpl_vars['emulator']->value->checkNoModule()){?><?php $_smarty_tpl->tpl_vars['v'] = new Smarty_variable($_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>
<?php $_smarty_tpl->tpl_vars['content'] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['content'] = clone $_smarty_tpl->tpl_vars['content'];?><?php }?><?php }} ?>