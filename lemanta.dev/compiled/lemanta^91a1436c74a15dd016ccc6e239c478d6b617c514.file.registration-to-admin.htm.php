<?php /* Smarty version Smarty-3.1.8, created on 2016-09-27 09:42:18
         compiled from "design/lemanta/html/email/registration-to-admin.htm" */ ?>
<?php /*%%SmartyHeaderCode:72860705257ea14ca6fe9e8-37202002%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91a1436c74a15dd016ccc6e239c478d6b617c514' => 
    array (
      0 => 'design/lemanta/html/email/registration-to-admin.htm',
      1 => 1473158178,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72860705257ea14ca6fe9e8-37202002',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'post' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57ea14ca7546c7_51656095',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ea14ca7546c7_51656095')) {function content_57ea14ca7546c7_51656095($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value)){?><p>На сайте <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
 зарегистрировался новый пользователь.</p>- дата регистрации: <?php echo $_smarty_tpl->tpl_vars['post']->value->created;?>
<br />- назначен ИД: <?php echo $_smarty_tpl->tpl_vars['post']->value->user_id;?>
<br /><p><b>Пользователь указал реквизиты:</b></p><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->name)||!empty($_smarty_tpl->tpl_vars['post']->value->name2)||!empty($_smarty_tpl->tpl_vars['post']->value->name3)){?>- ф.и.о: <?php echo $_smarty_tpl->tpl_vars['post']->value->name;?>
 <?php echo $_smarty_tpl->tpl_vars['post']->value->name3;?>
 <?php echo $_smarty_tpl->tpl_vars['post']->value->name2;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->nickname)){?>- ник: <?php echo $_smarty_tpl->tpl_vars['post']->value->nickname;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->email)){?>- емейл: <?php echo $_smarty_tpl->tpl_vars['post']->value->email;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->phone)){?>- телефон: <?php echo $_smarty_tpl->tpl_vars['post']->value->phone;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->skype)){?>- скайп: <?php echo $_smarty_tpl->tpl_vars['post']->value->skype;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->icq)){?>- icq: <?php echo $_smarty_tpl->tpl_vars['post']->value->icq;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->coupon)){?>- использовал скидочный купон: <?php echo $_smarty_tpl->tpl_vars['post']->value->coupon;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->ip)){?><p><b>Адрес в сети:</b></p>- ip: <?php echo $_smarty_tpl->tpl_vars['post']->value->ip;?>
<br /><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->host)){?>- хост: <?php echo $_smarty_tpl->tpl_vars['post']->value->host;?>
<br /><?php }?><?php }?><p><b>Административные ссылки:</b></p><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?section=Users">Список зарегистрированных пользователей</a><?php }?><?php }} ?>