<?php /* Smarty version Smarty-3.1.8, created on 2016-09-27 09:42:19
         compiled from "design/lemanta/html/account.htm" */ ?>
<?php /*%%SmartyHeaderCode:203244142357ea14cbc42d76-42917758%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e74c4db95364fdbe3a791700ac30e6147c7a289e' => 
    array (
      0 => 'design/lemanta/html/account.htm',
      1 => 1473158162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203244142357ea14cbc42d76-42917758',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'error' => 0,
    'orders' => 0,
    'item' => 0,
    'status' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57ea14cbc90e97_23202583',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ea14cbc90e97_23202583')) {function content_57ea14cbc90e97_23202583($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable('Личный кабинет', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Личный кабинет','noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'user->compound_name'),$_smarty_tpl);?>
</h1><?php if (!empty($_smarty_tpl->tpl_vars['error']->value)){?><div class="message_error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><form class="form register_form login_form account_form" method="post"><div><label>Имя</label><input value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'name'),$_smarty_tpl);?>
" class="inputall" name="name" maxlength="80" type="text" required /></div><div><label>Email</label><input value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'email'),$_smarty_tpl);?>
" class="inputall" name="email" maxlength="64" type="text" required /></div><div><label><a onclick="$('#password').show()">Изменить пароль</a></label><input id="password" value="" class="inputall" name="password" type="password" style="display: none" /></div><div><input type="submit" class="registr" value="Сохранить" /></div></form><?php if (!empty($_smarty_tpl->tpl_vars['orders']->value)){?><br /><br /><h2>Ваши заказы</h2><ul id="orders_history"><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li><?php echo $_smarty_tpl->tpl_vars['item']->value->date;?>
 <a href="order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->code, ENT_QUOTES, 'UTF-8');?>
">Заказ №<?php echo $_smarty_tpl->tpl_vars['item']->value->order_id;?>
</a><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->payment_status)){?> оплачен,<?php }?><?php $_smarty_tpl->tpl_vars['status'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->status)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php if ($_smarty_tpl->tpl_vars['status']->value==0){?> ждет обработки<?php }elseif($_smarty_tpl->tpl_vars['status']->value==1){?> в обработке<?php }elseif($_smarty_tpl->tpl_vars['status']->value==2){?> выполнен<?php }elseif($_smarty_tpl->tpl_vars['status']->value==3){?> аннулирован<?php }else{ ?> неизвестный статус!<?php }?></li><?php } ?></ul><?php }?></div><?php }} ?>