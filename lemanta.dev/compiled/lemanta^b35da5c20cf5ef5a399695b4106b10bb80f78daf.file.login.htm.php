<?php /* Smarty version Smarty-3.1.8, created on 2016-11-03 16:32:02
         compiled from "design/lemanta/html\login.htm" */ ?>
<?php /*%%SmartyHeaderCode:27673581b3c528ee929-63567639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b35da5c20cf5ef5a399695b4106b10bb80f78daf' => 
    array (
      0 => 'design/lemanta/html\\login.htm',
      1 => 1478179078,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27673581b3c528ee929-63567639',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'login_accepted' => 0,
    'login_error' => 0,
    'settings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_581b3c52944b66_49945204',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581b3c52944b66_49945204')) {function content_581b3c52944b66_49945204($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Вход','noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><h1>Login</h1><?php if (!empty($_smarty_tpl->tpl_vars['login_accepted']->value)){?><p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'login_message'),$_smarty_tpl);?>
</p><?php }else{ ?><?php if (!empty($_smarty_tpl->tpl_vars['login_error']->value)){?><div class="message_error"><?php echo $_smarty_tpl->tpl_vars['login_error']->value;?>
</div><?php }?><form class="form login_form" method="post"><div><label>Логин</label><input type="text" name="login_login" class="inputall" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'login_login'),$_smarty_tpl);?>
" maxlength="255" required /></div><div><label>Пароль</label><input type="password" name="login_password" class="inputall" value="" required /> (<a href="login/remind">напомнить</a>)</div><?php if (empty($_smarty_tpl->tpl_vars['settings']->value->login_captcha_disabled)){?><div class="captcha"><img src="captcha.jpg?unique=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['randomId'][0][0]->randomId(array(),$_smarty_tpl);?>
" alt="" /><input name="captcha" type="text" class="inputall" value="" maxlength="12" required /></div><?php }?><input type="submit" class="registr" value="Войти" /><input name="login_copystop" type="hidden" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'login_copystop'),$_smarty_tpl);?>
" /></form><?php }?></div>
<?php }} ?>