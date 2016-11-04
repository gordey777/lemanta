<?php /* Smarty version Smarty-3.1.8, created on 2016-11-03 16:38:23
         compiled from "design/lemanta/html\cart.htm" */ ?>
<?php /*%%SmartyHeaderCode:48805819f200753858-54364135%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fa542b7339f1b83978734b754f6ee16b9710ca6' => 
    array (
      0 => 'design/lemanta/html\\cart.htm',
      1 => 1478180303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '48805819f200753858-54364135',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819f200871ad3_17419612',
  'variables' => 
  array (
    'ajax' => 0,
    'mod' => 0,
    'emulator' => 0,
    'cart_products' => 0,
    'delivery_methods' => 0,
    'delivery_method_id' => 0,
    'item' => 0,
    'id' => 0,
    'sid' => 0,
    'helper' => 0,
    'price' => 0,
    'amount' => 0,
    'total' => 0,
    'sum' => 0,
    'sku' => 0,
    'i' => 0,
    'config' => 0,
    'cart_total_price' => 0,
    'cart_price' => 0,
    'discount' => 0,
    'dlv_sum' => 0,
    'error' => 0,
    'comment' => 0,
    'recent_products' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819f200871ad3_17419612')) {function content_5819f200871ad3_17419612($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['ajax']->value)){?><?php echo $_smarty_tpl->getSubTemplate ('common/cart-informer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }else{ ?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Корзина','noCatalogLink'=>true), 0);?>
<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['cart_products']->value)){?><?php $_smarty_tpl->tpl_vars['dlv_sum'] = new Smarty_variable(0, null, 0);?><?php $_smarty_tpl->_capture_stack[0][] = array('deliveries', null, null); ob_start(); ?><?php if (!empty($_smarty_tpl->tpl_vars['delivery_methods']->value)){?><?php $_smarty_tpl->tpl_vars['sid'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['delivery_method_id']->value)===null||$tmp==='' ? false : $tmp), null, 0);?><div class="cart-val"><label>Вид доставки *</label><select class="niceSelect" name="delivery_method_id" onchange="document.cart.submit()"><option>--- Пожалуйста, выберите ---</option><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['delivery_methods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_method_id)===null||$tmp==='' ? '' : $tmp), null, 0);?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['id']->value===$_smarty_tpl->tpl_vars['sid']->value ? "selected" : '';?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->final_price)===null||$tmp==='' ? 0 : $tmp)>0){?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['item']->value->final_price), null, 0);?> (+<?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
)<?php if ($_smarty_tpl->tpl_vars['id']->value===$_smarty_tpl->tpl_vars['sid']->value){?><?php $_smarty_tpl->tpl_vars['dlv_sum'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value->final_price, null, 0);?><?php }?><?php }?></option><?php } ?></select><div class="clr"></div></div><?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><form action="cart" method="post" name="cart"><div class="center cart_pad"><div class="cart-page"><h1>CART</h1><div class="cart-title">ВАША корзина</div><table width="100%" cellpadding="0" cellspacing="0"><thead><tr><td>Информация о товаре</td><td>Количество</td><td>Цена за единицу</td><td>Итого</td></tr></thead><tbody><?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['sku'] = new Smarty_variable((($tmp = @(($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['item']->value->sku)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['item']->value->name : $tmp))===null||$tmp==='' ? $_smarty_tpl->tpl_vars['item']->value->pcode : $tmp))===null||$tmp==='' ? '---/---' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['amount'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['sum'] = new Smarty_variable($_smarty_tpl->tpl_vars['amount']->value*$_smarty_tpl->tpl_vars['price']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['sum']->value, null, 0);?><tr><td style="width: 320px;"><div class="cart-img"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['image'][0][0]->image(array('folder'=>'files/products'),$_smarty_tpl);?>
" alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
" /></a></div><div class="cart-desc"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a><p>Код: <?php echo $_smarty_tpl->tpl_vars['sku']->value;?>
</p><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->variant_name)){?><p>Размер: <?php echo $_smarty_tpl->tpl_vars['item']->value->variant_name;?>
</p><?php }?></div></td><td style="width: 320px;"><div class="count option"><span>Количество</span> <select name="amounts[<?php echo $_smarty_tpl->tpl_vars['item']->value->variant_id;?>
]" onchange="document.cart.submit()"><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['name'] = 'amounts';
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['item']->value->stock+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total']);
?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['amounts']['index'], null, 0);?><option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['amount']->value==$_smarty_tpl->tpl_vars['i']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option><?php endfor; endif; ?></select></div><div class="remove"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/delete.png" alt="" /><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['cartUrl'][0][0]->cartUrl(array('del'=>true),$_smarty_tpl);?>
" rel="nofollow">Удалить</a></div></td><td><div class="cart-price"><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['price']->value), null, 0);?><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div></td><td><div class="cart-price-all"><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['sum']->value), null, 0);?><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div></td></tr><?php } ?></tbody></table><div class="cart-l"><h1>CART</h1><div class="banner"><a href="catalog/boys"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/foto.png" alt="" /></a></div><div class="title">Мы вКонтакте</div><div class="vk"><?php if (!empty($_smarty_tpl->tpl_vars['config']->value->vk_group)){?><script src="//vk.com/js/api/openapi.js?105"></script><div id="vk_groups"></div><script>VK.Widgets.Group('vk_groups', { mode: 0,width: '220',height: '260',color1: '111122',color2: 'b8c0c5',color3: '07073a' }, <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->vk_group'),$_smarty_tpl);?>
);</script><?php }?></div></div><?php $_smarty_tpl->tpl_vars['cart_price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['cart_total_price']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['discount'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['cart_price']->value-$_smarty_tpl->tpl_vars['total']->value), null, 0);?><div class="cart-r"><div class="itog-r"><?php if ($_smarty_tpl->tpl_vars['discount']->value!=0){?><div class="itog">Скидка: <?php echo intval($_smarty_tpl->tpl_vars['discount']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div><?php }?><?php if ($_smarty_tpl->tpl_vars['dlv_sum']->value!=0){?><div class="itog"><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['dlv_sum']->value), null, 0);?>Доставка: <?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div><?php }?><div class="itog"><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['cart_price']->value+$_smarty_tpl->tpl_vars['dlv_sum']->value), null, 0);?>ИТОГО: <?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)" class="back">назад в каталог</a><input type="submit" name="checkout" class="button oform" value="Оформить заказ" onclick="return clickCartSubmitKey(this)" /></div><div class="clr"></div></div><div class="cart-form"><h3>Заполните, пожалуйста, все необходимые поля</h3><div class="form cart_form"><?php if (!empty($_smarty_tpl->tpl_vars['error']->value)){?><div class="message_error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><div class="cart-val"><label>ФИО *</label><input name="name" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'name'),$_smarty_tpl);?>
" required /><div class="clr"></div></div><div class="cart-val"><label>Email *</label><input name="email" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'email'),$_smarty_tpl);?>
" required /><div class="clr"></div></div><div class="cart-val"><label>Телефон *</label><input name="phone" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'phone'),$_smarty_tpl);?>
" required /><div class="clr"></div></div><div class="cart-val"><label>Адрес доставки</label><input name="address" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'address'),$_smarty_tpl);?>
" /><div class="clr"></div></div><?php echo Smarty::$_smarty_vars['capture']['deliveries'];?>
<div class="cart-val"><label>Комментарий к заказу</label><textarea name="comment" id="order_comment"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['comment']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea><div class="clr"></div></div></div><div class="clr"></div></div><?php if (!empty($_smarty_tpl->tpl_vars['recent_products']->value)){?><div class="right"><hr class="separator" /><div class="product-rel"><div class="product-rel-t">ВЫ НЕДАВНО СМОТРЕЛИ</div><div class="product-rel-arr"><a href="#" class="prev prevv"></a><a href="#" class="next nextt"></a></div><div class="clr"></div><div class="cat"><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recent_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noQuickOrder'=>true), 0);?>
</li><?php } ?></ul><div class="clr"></div></div></div></div><?php }?></div><div class="clr"></div></div><input name="captcha_code" type="hidden" value="" /><input name="submit_order" type="hidden" value="0" /></form><?php }else{ ?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><p>В корзине нет товаров.</p><?php if (!empty($_smarty_tpl->tpl_vars['recent_products']->value)){?><hr class="separator" /><div class="product-rel"><div class="product-rel-t">ВЫ НЕДАВНО СМОТРЕЛИ</div><div class="product-rel-arr"><a href="#" class="prev prevv"></a><a href="#" class="next nextt"></a></div><div class="clr"></div><div class="cat"><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recent_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noQuickOrder'=>true), 0);?>
</li><?php } ?></ul><div class="clr"></div></div></div><?php }?></div><?php }?><?php }?>
<?php }} ?>