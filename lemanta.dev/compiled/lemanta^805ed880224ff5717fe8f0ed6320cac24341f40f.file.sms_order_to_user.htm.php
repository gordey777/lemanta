<?php /* Smarty version Smarty-3.1.8, created on 2016-09-19 11:11:35
         compiled from "admin/design/default/html/sms_order_to_user.htm" */ ?>
<?php /*%%SmartyHeaderCode:99673430557df9db78b6d60-67783359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '805ed880224ff5717fe8f0ed6320cac24341f40f' => 
    array (
      0 => 'admin/design/default/html/sms_order_to_user.htm',
      1 => 1462406628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99673430557df9db78b6d60-67783359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'post' => 0,
    'currency' => 0,
    'root_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57df9db78c81b9_57704532',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57df9db78c81b9_57704532')) {function content_57df9db78c81b9_57704532($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?>

<?php if (isset($_smarty_tpl->tpl_vars['post']->value)&&!empty($_smarty_tpl->tpl_vars['post']->value)){?>Ваш заказ №<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['post']->value->order_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
 на сумму <?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['post']->value->total_amount*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
 получен на сайте <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
.<?php }?>
<?php }} ?>