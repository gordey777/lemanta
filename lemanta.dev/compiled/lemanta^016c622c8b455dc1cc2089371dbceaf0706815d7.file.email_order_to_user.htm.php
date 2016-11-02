<?php /* Smarty version Smarty-3.1.8, created on 2016-09-19 11:11:35
         compiled from "admin/design/default/html/email_order_to_user.htm" */ ?>
<?php /*%%SmartyHeaderCode:78534184257df9db7602511-55830823%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '016c622c8b455dc1cc2089371dbceaf0706815d7' => 
    array (
      0 => 'admin/design/default/html/email_order_to_user.htm',
      1 => 1462406626,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78534184257df9db7602511-55830823',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'this_tpl_path' => 0,
    'file' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57df9db76319a4_07025435',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57df9db76319a4_07025435')) {function content_57df9db76319a4_07025435($_smarty_tpl) {?><!--  -->

  <?php $_smarty_tpl->_capture_stack[0][] = array('default', "file", null); ob_start(); ?><?php echo (($tmp = @$_smarty_tpl->tpl_vars['this_tpl_path']->value)===null||$tmp==='' ? '' : $tmp);?>
<?php echo @EMAIL_ORDER_TO_ADMIN_TEMPLATE_FILE;?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
  <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['file']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('for_user'=>true), 0);?>

<?php }} ?>