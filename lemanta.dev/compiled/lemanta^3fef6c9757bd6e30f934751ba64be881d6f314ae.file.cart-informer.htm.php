<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:20
         compiled from "design/lemanta/html/common/cart-informer.htm" */ ?>
<?php /*%%SmartyHeaderCode:84661088657d5b6a8993790-07430330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3fef6c9757bd6e30f934751ba64be881d6f314ae' => 
    array (
      0 => 'design/lemanta/html/common/cart-informer.htm',
      1 => 1473158176,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '84661088657d5b6a8993790-07430330',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cart_products_num' => 0,
    'cart_total_price' => 0,
    'helper' => 0,
    'price' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a89a6c00_03278851',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a89a6c00_03278851')) {function content_57d5b6a89a6c00_03278851($_smarty_tpl) {?><div class="cart-l"><?php if (!empty($_smarty_tpl->tpl_vars['cart_products_num']->value)){?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['cart_total_price']->value), null, 0);?><p>Товаров...........<span><?php echo $_smarty_tpl->tpl_vars['cart_products_num']->value;?>
</span></p><p>на сумму..........<span><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</span></p><?php }else{ ?><p><span>Корзина пуста</span></p><?php }?></div><a data-href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
cart" class="cart-r" onclick="return gotoHref(this)"><span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['cart_products_num']->value)===null||$tmp==='' ? 0 : $tmp);?>
</span></a><?php }} ?>