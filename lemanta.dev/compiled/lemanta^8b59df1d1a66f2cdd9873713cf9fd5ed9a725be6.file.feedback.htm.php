<?php /* Smarty version Smarty-3.1.8, created on 2016-11-03 16:28:50
         compiled from "design/lemanta/html\feedback.htm" */ ?>
<?php /*%%SmartyHeaderCode:4038581b2cddeb1176-07207344%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b59df1d1a66f2cdd9873713cf9fd5ed9a725be6' => 
    array (
      0 => 'design/lemanta/html\\feedback.htm',
      1 => 1478179097,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4038581b2cddeb1176-07207344',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_581b2cddf202f2_41342906',
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'feedback_accepted' => 0,
    'feedback_error' => 0,
    'settings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581b2cddf202f2_41342906')) {function content_581b2cddf202f2_41342906($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Обратная связь','noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><h1>feedback</h1><?php if (!empty($_smarty_tpl->tpl_vars['feedback_accepted']->value)){?><p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'feedback_message'),$_smarty_tpl);?>
</p><?php }else{ ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['body'][0][0]->body(array('from'=>'section'),$_smarty_tpl);?>
<form class="form feedback_form register_form login_form" method="post"><?php if (!empty($_smarty_tpl->tpl_vars['feedback_error']->value)){?><div class="message_error"><?php echo $_smarty_tpl->tpl_vars['feedback_error']->value;?>
</div><?php }?><div><label>Имя</label><input class="inputall" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'feedback_name'),$_smarty_tpl);?>
" name="feedback_name" maxlength="255" type="text" required /></div><div><label>Email</label><input class="inputall" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'feedback_email'),$_smarty_tpl);?>
" name="feedback_email" maxlength="255" type="text" required /></div><div><label>Сообщение</label><textarea class="inputall" name="feedback_message" required><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'feedback_message'),$_smarty_tpl);?>
</textarea></div><?php if (empty($_smarty_tpl->tpl_vars['settings']->value->feedback_captcha_disabled)){?><div class="captcha"><img src="captcha.jpg?unique=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['randomId'][0][0]->randomId(array(),$_smarty_tpl);?>
" alt="" /><input class="input_captcha" id="comment_captcha" type="text" name="captcha" value="" maxlength="12" required /></div><?php }?><div><input class="registr" type="submit" value="Отправить" /></div><input name="feedback_copystop" type="hidden" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'feedback_copystop'),$_smarty_tpl);?>
" /></form><?php }?></div>
<?php }} ?>