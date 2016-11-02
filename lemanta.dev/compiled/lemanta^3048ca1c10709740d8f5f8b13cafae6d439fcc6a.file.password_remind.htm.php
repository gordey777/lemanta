<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:58:14
         compiled from "design/lemanta/html/password_remind.htm" */ ?>
<?php /*%%SmartyHeaderCode:175445615557d5b756c35205-33275424%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3048ca1c10709740d8f5f8b13cafae6d439fcc6a' => 
    array (
      0 => 'design/lemanta/html/password_remind.htm',
      1 => 1473158163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '175445615557d5b756c35205-33275424',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'title' => 0,
    'message' => 0,
    'new_password' => 0,
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b756c68ae1_72095789',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b756c68ae1_72095789')) {function content_57d5b756c68ae1_72095789($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable('Восстановление пароля', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Забыли пароль?','noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1><?php if (!empty($_smarty_tpl->tpl_vars['message']->value)||isset($_smarty_tpl->tpl_vars['new_password']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['message']->value)){?><p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p><?php }elseif(!empty($_smarty_tpl->tpl_vars['new_password']->value)){?><p>На Ваш емейл отправлено электронное письмо с новым паролем.</p><?php }else{ ?><p>На указанный Вами емейл отправлено электронное письмо с подтверждающей ссылкой.</p><?php }?><?php }else{ ?><?php if (!empty($_smarty_tpl->tpl_vars['error']->value)){?><div class="message_error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><div><form class="form login_form" method="post"><div><label>Email</label><input type="text" class="inputall" name="email" required value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->email'),$_smarty_tpl);?>
" maxlength="255" /></div><div class="captcha"><img src="captcha.jpg?unique=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['randomId'][0][0]->randomId(array(),$_smarty_tpl);?>
" alt="" /><input name="captcha" type="text" class="inputall" value="" maxlength="12" required /></div><input type="submit" class="registr" value="Напомнить" /></form></div><?php }?></div><?php }} ?>