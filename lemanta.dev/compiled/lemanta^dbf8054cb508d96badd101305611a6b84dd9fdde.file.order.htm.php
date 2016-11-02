<?php /* Smarty version Smarty-3.1.8, created on 2016-09-19 11:11:35
         compiled from "design/lemanta/html/order.htm" */ ?>
<?php /*%%SmartyHeaderCode:89411581557df9db7c55e38-53961490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbf8054cb508d96badd101305611a6b84dd9fdde' => 
    array (
      0 => 'design/lemanta/html/order.htm',
      1 => 1473158163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '89411581557df9db7c55e38-53961490',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'user' => 0,
    'status' => 0,
    'item' => 0,
    'helper' => 0,
    'amount' => 0,
    'PaymentMethods' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57df9db7cd84a9_63129404',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57df9db7cd84a9_63129404')) {function content_57df9db7cd84a9_63129404($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value)&&(empty($_smarty_tpl->tpl_vars['order']->value->hidden)||(($tmp = @$_smarty_tpl->tpl_vars['order']->value->user_id)===null||$tmp==='' ? false : $tmp)===(($tmp = @$_smarty_tpl->tpl_vars['user']->value->user_id)===null||$tmp==='' ? 0 : $tmp)||(($tmp = @$_SESSION['admin'])===null||$tmp==='' ? '' : $tmp)=='admin')){?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable('Ваш заказ', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['header404'][0][0]->header404(array(),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['status'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['order']->value->status)===null||$tmp==='' ? 0 : $tmp), null, 0);?><div id="main_page_bloks"><h1>Ваш заказ №<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
<?php if ($_smarty_tpl->tpl_vars['status']->value==0){?> принят<?php }elseif($_smarty_tpl->tpl_vars['status']->value==1){?> в обработке<?php }elseif($_smarty_tpl->tpl_vars['status']->value==2){?> выполнен<?php }elseif($_smarty_tpl->tpl_vars['status']->value==3){?> аннулирован<?php }else{ ?> статус неизвестный<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->payment_status)){?>, оплачен<?php }?></h1><table id="purchases"><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><tr><td class="image"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['image'][0][0]->image(array('folder'=>'files/products'),$_smarty_tpl);?>
" alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
" width="50" /></a></td><td class="name" width="100%"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a> <?php echo $_smarty_tpl->tpl_vars['item']->value->variant_name;?>
</td><td class="price" nowrap><?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['item']->value->price);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</td><td class="amount" nowrap><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value->quantity<0 ? $_smarty_tpl->tpl_vars['item']->value->quantity*-1 : $_smarty_tpl->tpl_vars['item']->value->quantity, null, 0);?>&times; <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
 =</td><td class="price" nowrap><?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['item']->value->price*$_smarty_tpl->tpl_vars['amount']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</td></tr><?php } ?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->discount_sum)){?><tr><td class="image"></td><td class="name">Скидка</td><td class="price"></td><td class="amount"></td><th class="price" nowrap><?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['order']->value->discount_sum);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</th></tr><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->delivery_price)){?><tr><td class="image>"</td><td class="name"><?php echo $_smarty_tpl->tpl_vars['order']->value->delivery_method;?>
</td><td class="price"></td><td class="amount"></td><td class="price" nowrap><?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['order']->value->delivery_price);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</td></tr><?php }?><tr><td class="image"></td><td class="name">Итого</td><td class="price"></td><td class="amount"></td><th class="price" nowrap><?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['order']->value->total_amount);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</th></tr></table><h2>Детали заказа</h2><table class="order_info"><tr><td nowrap>Дата заказа</td><td width="100%"><?php echo $_smarty_tpl->tpl_vars['order']->value->date_date;?>
 в <?php echo $_smarty_tpl->tpl_vars['order']->value->date_time;?>
</td></tr><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->compound_name)){?><tr nowrap><td>Имя</td><td><?php echo $_smarty_tpl->tpl_vars['order']->value->compound_name;?>
</td></tr><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->email)){?><tr nowrap><td>Email</td><td><?php echo $_smarty_tpl->tpl_vars['order']->value->email;?>
</td></tr><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->phone)){?><tr><td nowrap>Телефон</td><td><?php echo $_smarty_tpl->tpl_vars['order']->value->phone;?>
</td></tr><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->compound_address)){?><tr><td nowrap>Адрес доставки</td><td><?php echo $_smarty_tpl->tpl_vars['order']->value->compound_address;?>
</td></tr><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->comment)){?><tr><td nowrap>Комментарий</td><td><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->comment, ENT_QUOTES, 'UTF-8'));?>
</td></tr><?php }?></table><?php if (empty($_smarty_tpl->tpl_vars['order']->value->payment_status)){?><?php if (!empty($_smarty_tpl->tpl_vars['PaymentMethods']->value)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PaymentMethods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><div class="payment"><h2>Оплата → <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['item']->value->amount,false);?>
 → <?php echo $_smarty_tpl->tpl_vars['item']->value->currency_sign;?>
</h2><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->description)){?><div class="description"><?php echo $_smarty_tpl->tpl_vars['item']->value->description;?>
</div><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->payment_button)){?><span class="payment-box"><?php echo $_smarty_tpl->tpl_vars['item']->value->payment_button;?>
</span><?php }?></div><?php } ?><?php }?><?php }?></div><?php }else{ ?><?php echo $_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php }} ?>