<?php /* Smarty version Smarty-3.1.8, created on 2016-11-03 15:48:51
         compiled from "design/lemanta/html\mod-google-tag-manager.htm" */ ?>
<?php /*%%SmartyHeaderCode:55855819dfcd3f4af6-81880144%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aec17535d6af16f7f82f5b525e2829b722bf4a0f' => 
    array (
      0 => 'design/lemanta/html\\mod-google-tag-manager.htm',
      1 => 1478177328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55855819dfcd3f4af6-81880144',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819dfcd6b2492_13983569',
  'variables' => 
  array (
    'baseOnly' => 0,
    'doExchange' => 0,
    'trackOrder' => 0,
    'order' => 0,
    'nowTimer1' => 0,
    'nowTimer2' => 0,
    'nowTimer3' => 0,
    'nowTimer4' => 0,
    'timer' => 0,
    'id' => 0,
    'googleTagManagerMODtrackOrders' => 0,
    'dummy' => 0,
    'total' => 0,
    'delivery' => 0,
    'helper' => 0,
    'googleTagManagerMODsign' => 0,
    'item' => 0,
    'categories_list' => 0,
    'category' => 0,
    'amount' => 0,
    'price' => 0,
    'trackCart' => 0,
    'cart_products' => 0,
    'variant' => 0,
    'properties' => 0,
    'hash' => 0,
    'googleTagManagerMODtrackCarts' => 0,
    'js' => 0,
    'cart_products_num' => 0,
    'cart_total_price' => 0,
    'trackDefer' => 0,
    'defer_products' => 0,
    'googleTagManagerMODtrackDefers' => 0,
    'defer_products_num' => 0,
    'defer_total_price' => 0,
    'startManager' => 0,
    'gtmID' => 0,
    'config' => 0,
    'googleTagManagerMODscripted' => 0,
    'final' => 0,
    'result' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dfcd6b2492_13983569')) {function content_5819dfcd6b2492_13983569($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\Projects\\lemanta\\lemanta.dev\\Smarty\\libs\\plugins\\modifier.date_format.php';
?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'js', null); ob_start(); ?><script>if (typeof googleTagManagerMODjsCreateCookie != 'function') {function googleTagManagerMODjsCreateCookie ( name, value, days ) {try {if (days) {var date = new Date();date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));var expires = '; expires=' + date.toGMTString();} else {var expires = '';}document.cookie = name + '=' + value + expires + '; path=/';} catch (e) { }}}</script><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'result', null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'googleTagManagerMODbuffer'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['doExchange'] = new Smarty_variable(empty($_smarty_tpl->tpl_vars['baseOnly']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['doExchange']->value){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'currency->code','assign'=>'googleTagManagerMODsign'),$_smarty_tpl);?>
<?php }else{ ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'main_currency->code','assign'=>'googleTagManagerMODsign'),$_smarty_tpl);?>
<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['trackOrder']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['order']->value->order_id)){?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable($_smarty_tpl->tpl_vars['order']->value->order_id, null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer1'] = new Smarty_variable(time(), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer2'] = new Smarty_variable($_smarty_tpl->tpl_vars['nowTimer1']->value-10, null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer3'] = new Smarty_variable($_smarty_tpl->tpl_vars['nowTimer2']->value-10, null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer4'] = new Smarty_variable($_smarty_tpl->tpl_vars['nowTimer3']->value-10, null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer1'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['nowTimer1']->value,'%Y-%m-%d %H:%M:%S'), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer2'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['nowTimer2']->value,'%Y-%m-%d %H:%M:%S'), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer3'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['nowTimer3']->value,'%Y-%m-%d %H:%M:%S'), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer4'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['nowTimer4']->value,'%Y-%m-%d %H:%M:%S'), null, 0);?><?php $_smarty_tpl->tpl_vars['timer'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['order']->value->date)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['nowTimer1']->value : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['timer'] = new Smarty_variable(substr($_smarty_tpl->tpl_vars['timer']->value,0,18), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer1'] = new Smarty_variable(substr($_smarty_tpl->tpl_vars['nowTimer1']->value,0,18), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer2'] = new Smarty_variable(substr($_smarty_tpl->tpl_vars['nowTimer2']->value,0,18), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer3'] = new Smarty_variable(substr($_smarty_tpl->tpl_vars['nowTimer3']->value,0,18), null, 0);?><?php $_smarty_tpl->tpl_vars['nowTimer4'] = new Smarty_variable(substr($_smarty_tpl->tpl_vars['nowTimer4']->value,0,18), null, 0);?><?php $_smarty_tpl->tpl_vars['timer'] = new Smarty_variable($_smarty_tpl->tpl_vars['timer']->value==$_smarty_tpl->tpl_vars['nowTimer1']->value||$_smarty_tpl->tpl_vars['timer']->value==$_smarty_tpl->tpl_vars['nowTimer2']->value||$_smarty_tpl->tpl_vars['timer']->value==$_smarty_tpl->tpl_vars['nowTimer3']->value||$_smarty_tpl->tpl_vars['timer']->value==$_smarty_tpl->tpl_vars['nowTimer4']->value, null, 0);?><?php if (!isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackOrders']->value[$_smarty_tpl->tpl_vars['id']->value])&&$_smarty_tpl->tpl_vars['timer']->value){?><?php $_smarty_tpl->tpl_vars['dummy'] = new Smarty_variable($_smarty_tpl->tpl_vars['googleTagManagerMODtrackOrders']->value, null, 0);?><?php $_smarty_tpl->createLocalArrayVariable('dummy', null, 0);
$_smarty_tpl->tpl_vars['dummy']->value[$_smarty_tpl->tpl_vars['id']->value] = $_smarty_tpl->tpl_vars['id']->value;?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODtrackOrders'] = new Smarty_variable($_smarty_tpl->tpl_vars['dummy']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['googleTagManagerMODtrackOrders'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODtrackOrders']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['googleTagManagerMODtrackOrders'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODtrackOrders'];?><script>if (typeof dataLayer == 'undefined') dataLayer = [];dataLayer.push({'transactionDate': '<?php echo smarty_modifier_date_format(time(),'%d-%m-%Y %H:%M:%S');?>
','transactionId': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'id'),$_smarty_tpl);?>
','transactionAffiliation': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'settings->site_name'),$_smarty_tpl);?>
',<?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['order']->value->total_amount)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['delivery'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['order']->value->delivery_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?>'transactionTotal': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['total']->value-$_smarty_tpl->tpl_vars['delivery']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'transactionTax': 0,'transactionShipping': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['delivery']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'transactionCurrency': '<?php echo $_smarty_tpl->tpl_vars['googleTagManagerMODsign']->value;?>
','transactionProducts': [<?php if (!empty($_smarty_tpl->tpl_vars['order']->value->products)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
?><?php $_smarty_tpl->tpl_vars['category'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->category_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?><?php $_smarty_tpl->tpl_vars['category'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['categories_list']->value[$_smarty_tpl->tpl_vars['id']->value]->name)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php if (empty($_smarty_tpl->tpl_vars['category']->value)){?><?php $_smarty_tpl->tpl_vars['category'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->category)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->quantity)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(intval($_smarty_tpl->tpl_vars['amount']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['amount']->value<0 ? $_smarty_tpl->tpl_vars['amount']->value*-1 : $_smarty_tpl->tpl_vars['amount']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->price)===null||$tmp==='' ? 0 : $tmp), null, 0);?>{'category': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'category'),$_smarty_tpl);?>
','sku': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->sku'),$_smarty_tpl);?>
','name': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->product_name'),$_smarty_tpl);?>
','variant': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->variant_name'),$_smarty_tpl);?>
','properties': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->name_properties'),$_smarty_tpl);?>
','quantity': <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
,'price': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'total': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value*$_smarty_tpl->tpl_vars['amount']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
}<?php if (!$_smarty_tpl->tpl_vars['item']->last){?>,<?php }?><?php } ?><?php }?>],'event': 'trackTrans'});</script><?php }?><?php }?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['trackCart']->value)){?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable('', null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['cart_products']->value)){?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable(array(), null, 0);?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
?><?php $_smarty_tpl->tpl_vars['variant'] = new Smarty_variable(reset($_smarty_tpl->tpl_vars['item']->value->variants), null, 0);?><?php $_smarty_tpl->tpl_vars['variant'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->variant_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(max(1,intval($_smarty_tpl->tpl_vars['amount']->value)), null, 0);?><?php $_smarty_tpl->tpl_vars['properties'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name_properties)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->createLocalArrayVariable('hash', null, 0);
$_smarty_tpl->tpl_vars['hash']->value[$_smarty_tpl->tpl_vars['variant']->value] = array($_smarty_tpl->tpl_vars['amount']->value,$_smarty_tpl->tpl_vars['properties']->value);?><?php } ?><?php $_smarty_tpl->tpl_vars['dummy'] = new Smarty_variable(ksort($_smarty_tpl->tpl_vars['hash']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable(serialize($_smarty_tpl->tpl_vars['hash']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable(md5($_smarty_tpl->tpl_vars['hash']->value), null, 0);?><?php }?><?php if (!isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts']->value)){?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts'] = new Smarty_variable((($tmp = @$_COOKIE['gtmTrackCarts'])===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts']->value)&&$_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts']->value!=$_smarty_tpl->tpl_vars['hash']->value||!isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts']->value)&&$_smarty_tpl->tpl_vars['hash']->value!=''){?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts'] = new Smarty_variable($_smarty_tpl->tpl_vars['hash']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['googleTagManagerMODtrackCarts'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['googleTagManagerMODtrackCarts'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODtrackCarts'];?><?php echo $_smarty_tpl->tpl_vars['js']->value;?>
<?php $_smarty_tpl->tpl_vars['js'] = new Smarty_variable('', null, 0);?><script>googleTagManagerMODjsCreateCookie('gtmTrackCarts', '<?php echo $_smarty_tpl->tpl_vars['hash']->value;?>
', 1)</script><script>if (typeof dataLayer == 'undefined') dataLayer = [];dataLayer.push({<?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['cart_products_num']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(intval($_smarty_tpl->tpl_vars['amount']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['cart_total_price']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?>'cartDate': '<?php echo smarty_modifier_date_format(time(),'%d-%m-%Y %H:%M:%S');?>
','cartShop': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'settings->site_name'),$_smarty_tpl);?>
','cartQuantity': <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
,'cartTotal': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['total']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'cartCurrency': '<?php echo $_smarty_tpl->tpl_vars['googleTagManagerMODsign']->value;?>
','cartProducts': [<?php if (!empty($_smarty_tpl->tpl_vars['cart_products']->value)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
?><?php $_smarty_tpl->tpl_vars['variant'] = new Smarty_variable(reset($_smarty_tpl->tpl_vars['item']->value->variants), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(max(1,intval($_smarty_tpl->tpl_vars['amount']->value)), null, 0);?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->discount_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?>{'category': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->category_plural'),$_smarty_tpl);?>
','sku': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'variant->sku'),$_smarty_tpl);?>
','name': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
','variant': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'variant->variant_name'),$_smarty_tpl);?>
','properties': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->name_properties'),$_smarty_tpl);?>
','quantity': <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
,'price': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'total': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value*$_smarty_tpl->tpl_vars['amount']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
}<?php if (!$_smarty_tpl->tpl_vars['item']->last){?>,<?php }?><?php } ?><?php }?>],'event': 'trackCart'});</script><?php }?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['trackDefer']->value)){?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable('', null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['defer_products']->value)){?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable(array(), null, 0);?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['defer_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
?><?php $_smarty_tpl->tpl_vars['variant'] = new Smarty_variable(reset($_smarty_tpl->tpl_vars['item']->value->variants), null, 0);?><?php $_smarty_tpl->tpl_vars['variant'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->variant_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(max(1,intval($_smarty_tpl->tpl_vars['amount']->value)), null, 0);?><?php $_smarty_tpl->tpl_vars['properties'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name_properties)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->createLocalArrayVariable('hash', null, 0);
$_smarty_tpl->tpl_vars['hash']->value[$_smarty_tpl->tpl_vars['variant']->value] = array($_smarty_tpl->tpl_vars['amount']->value,$_smarty_tpl->tpl_vars['properties']->value);?><?php } ?><?php $_smarty_tpl->tpl_vars['dummy'] = new Smarty_variable(ksort($_smarty_tpl->tpl_vars['hash']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable(serialize($_smarty_tpl->tpl_vars['hash']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['hash'] = new Smarty_variable(md5($_smarty_tpl->tpl_vars['hash']->value), null, 0);?><?php }?><?php if (!isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers']->value)){?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers'] = new Smarty_variable((($tmp = @$_COOKIE['gtmTrackDefers'])===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers']->value)&&$_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers']->value!=$_smarty_tpl->tpl_vars['hash']->value||!isset($_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers']->value)&&$_smarty_tpl->tpl_vars['hash']->value!=''){?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers'] = new Smarty_variable($_smarty_tpl->tpl_vars['hash']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['googleTagManagerMODtrackDefers'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['googleTagManagerMODtrackDefers'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODtrackDefers'];?><?php echo $_smarty_tpl->tpl_vars['js']->value;?>
<?php $_smarty_tpl->tpl_vars['js'] = new Smarty_variable('', null, 0);?><script>googleTagManagerMODjsCreateCookie('gtmTrackDefers', '<?php echo $_smarty_tpl->tpl_vars['hash']->value;?>
', 1)</script><script>if (typeof dataLayer == 'undefined') dataLayer = [];dataLayer.push({<?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['defer_products_num']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(intval($_smarty_tpl->tpl_vars['amount']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['defer_total_price']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?>'deferDate': '<?php echo smarty_modifier_date_format(time(),'%d-%m-%Y %H:%M:%S');?>
','deferShop': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'settings->site_name'),$_smarty_tpl);?>
','deferQuantity': <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
,'deferTotal': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['total']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'deferCurrency': '<?php echo $_smarty_tpl->tpl_vars['googleTagManagerMODsign']->value;?>
','deferProducts': [<?php if (!empty($_smarty_tpl->tpl_vars['defer_products']->value)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['defer_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['item']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->iteration++;
 $_smarty_tpl->tpl_vars['item']->last = $_smarty_tpl->tpl_vars['item']->iteration === $_smarty_tpl->tpl_vars['item']->total;
?><?php $_smarty_tpl->tpl_vars['variant'] = new Smarty_variable(reset($_smarty_tpl->tpl_vars['item']->value->variants), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable(max(1,intval($_smarty_tpl->tpl_vars['amount']->value)), null, 0);?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->discount_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?>{'category': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->category_plural'),$_smarty_tpl);?>
','sku': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'variant->sku'),$_smarty_tpl);?>
','name': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
','variant': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'variant->variant_name'),$_smarty_tpl);?>
','properties': '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->name_properties'),$_smarty_tpl);?>
','quantity': <?php echo $_smarty_tpl->tpl_vars['amount']->value;?>
,'price': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
,'total': <?php echo $_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value*$_smarty_tpl->tpl_vars['amount']->value,$_smarty_tpl->tpl_vars['doExchange']->value,false);?>
}<?php if (!$_smarty_tpl->tpl_vars['item']->last){?>,<?php }?><?php } ?><?php }?>],'event': 'trackDefer'});</script><?php }?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['startManager']->value)){?><?php $_smarty_tpl->tpl_vars['gtmID'] = new Smarty_variable(!empty($_smarty_tpl->tpl_vars['gtmID']->value)&&is_string($_smarty_tpl->tpl_vars['gtmID']->value) ? $_smarty_tpl->tpl_vars['gtmID']->value : ((($tmp = @$_smarty_tpl->tpl_vars['config']->value->googleTM)===null||$tmp==='' ? '' : $tmp)), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['gtmID']->value)){?><?php if (empty($_smarty_tpl->tpl_vars['googleTagManagerMODscripted']->value)){?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODscripted'] = new Smarty_variable(true, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['googleTagManagerMODscripted'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODscripted']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['googleTagManagerMODscripted'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODscripted'];?><?php $_smarty_tpl->tpl_vars['gtmID'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['gtmID']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $_smarty_tpl->tpl_vars['gtmID']->value;?>
" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript><script>(function (w, d, s, l, i) {w[l] = w[l] || [];w[l].push({'gtm.start': new Date().getTime(),event: 'gtm.js'});var f = d.getElementsByTagName(s)[0],j = d.createElement(s),dl = l != 'dataLayer' ? '&l=' + l : '';j.async = true;j.src = '//www.googletagmanager.com/gtm.js?id=' + i + dl;f.parentNode.insertBefore(j, f);}) (window, document, 'script', 'dataLayer', '<?php echo $_smarty_tpl->tpl_vars['gtmID']->value;?>
');</script><?php }?><?php }?><?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (!isset($_smarty_tpl->tpl_vars['final']->value)||!empty($_smarty_tpl->tpl_vars['final']->value)){?><?php echo $_smarty_tpl->tpl_vars['result']->value;?>
<?php $_smarty_tpl->tpl_vars['result'] = new Smarty_variable('', null, 0);?><?php }?><?php $_smarty_tpl->tpl_vars['googleTagManagerMODbuffer'] = new Smarty_variable($_smarty_tpl->tpl_vars['result']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['googleTagManagerMODbuffer'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODbuffer']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['googleTagManagerMODbuffer'] = clone $_smarty_tpl->tpl_vars['googleTagManagerMODbuffer'];?><?php }} ?>