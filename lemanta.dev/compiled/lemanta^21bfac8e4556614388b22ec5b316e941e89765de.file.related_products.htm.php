<?php /* Smarty version Smarty-3.1.8, created on 2016-11-11 18:50:58
         compiled from "design/lemanta/html\common\related_products.htm" */ ?>
<?php /*%%SmartyHeaderCode:74085825dce052f2a2-20775517%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21bfac8e4556614388b22ec5b316e941e89765de' => 
    array (
      0 => 'design/lemanta/html\\common\\related_products.htm',
      1 => 1478879458,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74085825dce052f2a2-20775517',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5825dce053c196_47140928',
  'variables' => 
  array (
    'products' => 0,
    'mores' => 0,
    'items' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5825dce053c196_47140928')) {function content_5825dce053c196_47140928($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['items'] = new Smarty_variable((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['products']->value->related_products)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['mores']->value : $tmp))===null||$tmp==='' ? false : $tmp), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><hr class="separator" /><div class="product-rel"><div class="product-rel-t">ПРЕДЛАГАЕМ ПОСМОТРЕТЬ</div><div class="product-rel-arr"><a href="#" class="prev prevv"><i class="fa fa-chevron-left"></i></a><a href="#" class="next nextt"><i class="fa fa-chevron-right"></i></a></div><div class="clr"></div><div class="cat"><ul class=""><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li class=""><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</li><?php } ?></ul><div class="clr"></div></div></div><?php }?>
<?php }} ?>