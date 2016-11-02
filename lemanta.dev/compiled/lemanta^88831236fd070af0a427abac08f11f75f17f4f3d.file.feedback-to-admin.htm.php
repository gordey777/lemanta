<?php /* Smarty version Smarty-3.1.8, created on 2016-10-09 09:12:31
         compiled from "design/lemanta/html/email/feedback-to-admin.htm" */ ?>
<?php /*%%SmartyHeaderCode:139413737657f9dfcf405e86-61201790%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88831236fd070af0a427abac08f11f75f17f4f3d' => 
    array (
      0 => 'design/lemanta/html/email/feedback-to-admin.htm',
      1 => 1473158177,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139413737657f9dfcf405e86-61201790',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'post' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57f9dfcf452211_52122904',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57f9dfcf452211_52122904')) {function content_57f9dfcf452211_52122904($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value)){?><p><b><?php echo (($tmp = @$_smarty_tpl->tpl_vars['post']->value->name)===null||$tmp==='' ? 'Пользователь' : $tmp);?>
 написал:</b></p><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->department)){?>- в отдел: <?php echo $_smarty_tpl->tpl_vars['post']->value->department;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->subject)){?>- по теме: <?php echo $_smarty_tpl->tpl_vars['post']->value->subject;?>
<br /><?php }?>- дата сообщения: <?php echo $_smarty_tpl->tpl_vars['post']->value->created;?>
<br /><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->message)){?><p><b>Сообщение:</b></p><?php echo nl2br($_smarty_tpl->tpl_vars['post']->value->message);?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->ip)){?><p><b>Адрес в сети:</b></p>- ip: <?php echo $_smarty_tpl->tpl_vars['post']->value->ip;?>
<br /><?php if (!empty($_smarty_tpl->tpl_vars['post']->value->host)){?>- хост: <?php echo $_smarty_tpl->tpl_vars['post']->value->host;?>
<br /><?php }?><?php }?><p><b>Административные ссылки:</b></p><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?section=Feedback">Страница переписки</a><?php }?><?php }} ?>