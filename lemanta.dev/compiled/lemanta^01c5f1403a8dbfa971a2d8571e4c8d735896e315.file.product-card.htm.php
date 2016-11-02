<?php /* Smarty version Smarty-3.1.8, created on 2016-11-02 15:45:09
         compiled from "design/lemanta/html\common\product-card.htm" */ ?>
<?php /*%%SmartyHeaderCode:235075819dfd588b244-01642289%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01c5f1403a8dbfa971a2d8571e4c8d735896e315' => 
    array (
      0 => 'design/lemanta/html\\common\\product-card.htm',
      1 => 1478016493,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '235075819dfd588b244-01642289',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
    'image' => 0,
    'schemaOrg' => 0,
    'main_currency' => 0,
    'helper' => 0,
    'price' => 0,
    'v' => 0,
    'noQuickOrder' => 0,
    'vid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819dfd58fa701_34283616',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dfd58fa701_34283616')) {function content_5819dfd58fa701_34283616($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value)){?><div class="cat-bl product"><div class="cat-img"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('type'=>'product','assign'=>'image'),$_smarty_tpl);?>
<div class="image"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['alt'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['desc'], ENT_QUOTES, 'UTF-8');?>
" /></a></div><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->newest)){?><div class="lenta-new"></div><?php }elseif(mb_strtolower($_smarty_tpl->tpl_vars['item']->value->category_plural, 'UTF-8')=='распродажа'){?><div class="lenta-r"></div><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['schemaOrg']->value)){?><div itemscope itemtype="http://schema.org/Product" style="display: none !important"><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->brand)){?><span itemprop="brand"><?php echo $_smarty_tpl->tpl_vars['item']->value->brand;?>
</span><?php }?><span itemprop="name"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</span><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" alt="" itemprop="image" /><span itemprop="description"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['annotation'][0][0]->annotation(array('assign'=>'value'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['plainText'][0][0]->plainText(array('from'=>'value'),$_smarty_tpl);?>
</span><span itemprop="mpn"><?php echo (($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['item']->value->pcode)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['item']->value->variants[0]->sku : $tmp))===null||$tmp==='' ? '' : $tmp);?>
</span><span itemprop="offers" itemscope itemtype="http://schema.org/Offer"><meta itemprop="priceCurrency" content="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['main_currency']->value->code)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /><span itemprop="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('signed'=>false),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['helper']->value->maybeSale($_smarty_tpl->tpl_vars['item']->value)){?><link itemprop="availability" href="http://schema.org/InStock" /><?php }?></span></div><?php }?></div><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->variants)){?><div class="cat-desc"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('signed'=>false,'assign'=>'price'),$_smarty_tpl);?>
<div class="cat-desc-l"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" class="cat-name" itemprop="name" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array(),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a><span class="cat-price"><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
<span></div><?php if ($_smarty_tpl->tpl_vars['helper']->value->maybeSale($_smarty_tpl->tpl_vars['item']->value)){?><?php $_smarty_tpl->tpl_vars['v'] = new Smarty_variable(reset($_smarty_tpl->tpl_vars['item']->value->variants), null, 0);?><?php $_smarty_tpl->tpl_vars['vid'] = new Smarty_variable(htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['v']->value->variant_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?><div class="zakaz" style="display: none"><?php if (empty($_smarty_tpl->tpl_vars['noQuickOrder']->value)){?><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/buy2.png" alt="" /><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
">Быстрый заказ</a><?php }else{ ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
<?php }?></div><div class="buy"><a data-href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['cartUrl'][0][0]->cartUrl(array(),$_smarty_tpl);?>
" onclick="return gotoHref(this)"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/buy.png" alt="" /></a></div><?php }else{ ?><div class="zakaz" style="display: none">Нет в наличии</div><?php }?></div><?php }?></div><?php }?><?php }} ?>