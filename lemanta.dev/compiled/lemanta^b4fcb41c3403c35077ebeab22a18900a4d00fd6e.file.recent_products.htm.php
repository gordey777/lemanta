<?php /* Smarty version Smarty-3.1.8, created on 2016-11-12 22:28:20
         compiled from "design/lemanta/html\common\recent_products.htm" */ ?>
<?php /*%%SmartyHeaderCode:284855826ebeb37de43-58697825%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4fcb41c3403c35077ebeab22a18900a4d00fd6e' => 
    array (
      0 => 'design/lemanta/html\\common\\recent_products.htm',
      1 => 1478978899,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '284855826ebeb37de43-58697825',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5826ebeb387db5_28241283',
  'variables' => 
  array (
    'recent_products' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5826ebeb387db5_28241283')) {function content_5826ebeb387db5_28241283($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['recent_products']->value)){?><div class="product-rel"><div class="product-rel-t">ВЫ НЕДАВНО СМОТРЕЛИ</div><div class="product-rec-arr"><a href="#" class="prev prevv"><i class="fa fa-chevron-left"></i></a><a href="#" class="next nextt"><i class="fa fa-chevron-right"></i></a></div><div class="clr"></div><div class="cat"><ul class=""><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recent_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li class="rel-list"><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</li><?php } ?></ul><div class="clr"></div></div></div><?php }?>
<?php }} ?>