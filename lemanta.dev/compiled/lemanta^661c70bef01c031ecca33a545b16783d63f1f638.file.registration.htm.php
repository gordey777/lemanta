<?php /* Smarty version Smarty-3.1.8, created on 2016-09-12 20:37:43
         compiled from "design/lemanta/html/registration.htm" */ ?>
<?php /*%%SmartyHeaderCode:195244326357d6e7e7378575-71821918%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '661c70bef01c031ecca33a545b16783d63f1f638' => 
    array (
      0 => 'design/lemanta/html/registration.htm',
      1 => 1473158164,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195244326357d6e7e7378575-71821918',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'registration_accepted' => 0,
    'registration_error' => 0,
    'settings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d6e7e73a80b1_73722795',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d6e7e73a80b1_73722795')) {function content_57d6e7e73a80b1_73722795($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Регистрация','noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><?php if (!empty($_smarty_tpl->tpl_vars['registration_accepted']->value)){?><p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'registration_message'),$_smarty_tpl);?>
</p><?php }else{ ?><?php if (!empty($_smarty_tpl->tpl_vars['registration_error']->value)){?><div class="message_error"><?php echo $_smarty_tpl->tpl_vars['registration_error']->value;?>
</div><?php }?><form class="form register_form login_form" method="post"><div><label>Имя</label><input type="text" name="registration_name" class="inputall" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'registration_name'),$_smarty_tpl);?>
" maxlength="255" reguired /></div><div><label>Email</label><input type="text" name="registration_email" class="inputall" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'registration_email'),$_smarty_tpl);?>
" maxlength="255" required /></div><div><label>Пароль</label><input type="password" name="registration_password" class="inputall" value="" required /></div><div><label>Повтор пароля</label><input type="password" name="registration_password2" class="inputall" value="" required /></div><?php if (empty($_smarty_tpl->tpl_vars['settings']->value->registration_captcha_disabled)){?><div class="captcha"><img src="captcha.jpg?unique=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['randomId'][0][0]->randomId(array(),$_smarty_tpl);?>
" alt="" /><input class="input_captcha" id="comment_captcha" type="text" name="captcha" value="" required /></div><?php }?><div><input type="submit" class="registr" name="register" value="Регистрация" /></div><input name="registration_copystop" type="hidden" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'registration_copystop'),$_smarty_tpl);?>
" /></form><?php }?></div><?php }} ?>