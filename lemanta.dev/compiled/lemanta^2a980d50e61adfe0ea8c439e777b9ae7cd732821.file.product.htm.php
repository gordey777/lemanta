<?php /* Smarty version Smarty-3.1.8, created on 2016-11-10 20:11:00
         compiled from "design/lemanta/html\product.htm" */ ?>
<?php /*%%SmartyHeaderCode:250995819f8f4c690a6-54178177%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a980d50e61adfe0ea8c439e777b9ae7cd732821' => 
    array (
      0 => 'design/lemanta/html\\product.htm',
      1 => 1478797859,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '250995819f8f4c690a6-54178177',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819f8f4dc7616_85541927',
  'variables' => 
  array (
    'product' => 0,
    'image' => 0,
    'main_currency' => 0,
    'helper' => 0,
    'mod' => 0,
    'emulator' => 0,
    'video' => 0,
    'file' => 0,
    'number' => 0,
    'price' => 0,
    'v' => 0,
    'vid' => 0,
    'products' => 0,
    'mores' => 0,
    'items' => 0,
    'recent_products' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819f8f4dc7616_85541927')) {function content_5819f8f4dc7616_85541927($_smarty_tpl) {?><?php if (!empty($_REQUEST['dynamic'])){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['lastTemplate'][0][0]->lastTemplate(array(),$_smarty_tpl);?>
<?php echo $_smarty_tpl->getSubTemplate ('common/quick-order.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }else{ ?><div  class="product-display" itemscope itemtype="http://schema.org/Product" style="display: none !important"><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->brand)){?><span itemprop="brand"><?php echo $_smarty_tpl->tpl_vars['product']->value->brand;?>
</span><?php }?><span itemprop="name"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
</span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('from'=>'product','type'=>'product','assign'=>'image'),$_smarty_tpl);?>
<img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" alt="" itemprop="image" /><span itemprop="description"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['annotation'][0][0]->annotation(array('from'=>'product','assign'=>'value'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['plainText'][0][0]->plainText(array('from'=>'value'),$_smarty_tpl);?>
</span><span itemprop="mpn"><?php echo (($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['product']->value->pcode)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['product']->value->variants[0]->sku : $tmp))===null||$tmp==='' ? '' : $tmp);?>
</span><span itemprop="offers" itemscope itemtype="http://schema.org/Offer"><meta itemprop="priceCurrency" content="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['main_currency']->value->code)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /><span itemprop="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('from'=>'product','signed'=>false),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['helper']->value->maybeSale($_smarty_tpl->tpl_vars['product']->value)){?><link itemprop="availability" href="http://schema.org/InStock" /><?php }?></span></div><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['product']->value->meta_title)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['product']->value->model : $tmp))===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><div class="right col-md-12"><div class="product-page row"><div class="product-left col-md-5"><div class="row"><?php if (!empty($_smarty_tpl->tpl_vars['video']->value)||count($_smarty_tpl->tpl_vars['product']->value->images)>1){?><div class="thumb col-xs-3"><div class="thumb-title">Все фотографии</div><div class="thumb-img col-md-12"><?php $_smarty_tpl->tpl_vars['video'] = new Smarty_variable('', null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->files)){?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'video', null); ob_start(); ?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value->files; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value){
$_smarty_tpl->tpl_vars['file']->_loop = true;
?><?php if (preg_match('/\.mp4$/iu',$_smarty_tpl->tpl_vars['file']->value)){?><a href="files/products/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['file']->value, ENT_QUOTES, 'UTF-8');?>
" onclick="return showMP4video(this)" onmouseenter="showMP4video(this)" data-id="<?php echo $_smarty_tpl->tpl_vars['number']->value;?>
"><span><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/video-icon.png" alt="" /></span></a><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php }?><?php } ?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['video']->value)){?><?php echo $_smarty_tpl->tpl_vars['video']->value;?>
<?php }?><?php if (count($_smarty_tpl->tpl_vars['product']->value->images)>1){?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['images'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['images']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['name'] = 'images';
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['loop'] = is_array($_loop=1000) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['images']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['images']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['images']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['images']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['images']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['images']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['images']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['images']['total']);
?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('from'=>'product','type'=>'product','num'=>$_smarty_tpl->tpl_vars['number']->value,'assign'=>'image'),$_smarty_tpl);?>
<?php if (empty($_smarty_tpl->tpl_vars['image']->value['found'])){?><?php break 1?><?php }?><a href="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" class="cloud-zoom-gallery" onmouseenter="showZOOMimage(this)" rel="useZoom: 'zoom1', smallImage: '<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
'"><span><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['alt'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['desc'], ENT_QUOTES, 'UTF-8');?>
"/></span></a><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php endfor; endif; ?><?php }?></div><?php }?></div><div class="product-image2 col-xs-9"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('from'=>'product','type'=>'product','num'=>2,'assign'=>'image'),$_smarty_tpl);?>
<?php if (empty($_smarty_tpl->tpl_vars['image']->value['found'])){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('from'=>'product','type'=>'product','assign'=>'image'),$_smarty_tpl);?>
<?php }?><div class="image" id="image-video"><a href="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" class="zoom cloud-zoom" id="zoom1" rel=""><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['alt'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['desc'], ENT_QUOTES, 'UTF-8');?>
" /></a><div class="video-box" style="display: none;"></div></div></div><!-- .product-image2 --></div><!-- /.row --></div><!-- .product-left --><div class="product-info col-md-7"><div class="row"><div class="wrapp-desc col-md-6 col-sm-6"><div class="product-desc"><div class="desc-menu"><a class="active" onclick="switchDescriptionTab(this, 'desc-info')">Описание</a><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->video)){?><a onclick="switchDescriptionTab(this, 'desc-video')">Видео</a><?php }?></div><div class="desc-data1"><div class="desc-info"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['body'][0][0]->body(array('from'=>'product'),$_smarty_tpl);?>
</div><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->video)){?><div class="desc-video"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'product->video'),$_smarty_tpl);?>
</div><?php }?></div></div><!-- .product-desc --></div><!-- .wrapp-desc --><div class="product-right-wrapp col-md-6 col-sm-6"><div class="product-right"><h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
</h1><div class="char"><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->brand)){?>Производитель: <?php echo $_smarty_tpl->tpl_vars['product']->value->brand;?>
<br /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->variants[0]->sku)){?>КОД ТОВАРА: <?php echo $_smarty_tpl->tpl_vars['product']->value->variants[0]->sku;?>
<br /><?php }?>Наличие:  <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product']->value->variants[0]->stock)===null||$tmp==='' ? 0 : $tmp)>0){?>На складе<?php }else{ ?>Нет в наличии<?php }?><br /></div><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('from'=>'product','signed'=>false,'assign'=>'price'),$_smarty_tpl);?>
<div class="price"><b><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
</b> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div><div class="clr"></div><?php if ($_smarty_tpl->tpl_vars['helper']->value->maybeSale($_smarty_tpl->tpl_vars['product']->value)){?><div class="options"><?php if (count($_smarty_tpl->tpl_vars['product']->value->variants)>0){?><form name="variants"><ul><li class="first"><span>Размеры:</span><span>Количество:</span></li><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['vid'] = new Smarty_variable(htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['v']->value->variant_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['v']->value->discount_price), null, 0);?><li><a title="Нажмите, чтобы купить" data-id="<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value->name;?>
</a><div class="product-price"><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div><div class="amount"><input type="text" name="amounts[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" value="1" data-max="<?php echo $_smarty_tpl->tpl_vars['v']->value->stock;?>
" /><div class="spinner"><i title="Увеличить количество" class="spinner-up">&and;</i><i title="Уменьшить количество" class="spinner-down">&or;</i></div></div></li><?php } ?></ul><input type="button" value="в корзину" class="buy fr" id="addtocard" data-result-text="Добавлено" /><div class="error" style="display: none;">Выберите размер<br />и количество!</div></form><?php }else{ ?><p>Нет в наличии.</p><?php }?></div><?php }?><div class="info"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['annotation'][0][0]->annotation(array('from'=>'product'),$_smarty_tpl);?>
</div><div class="icons"><div class="i-win1" style="display: none;"><div class="cor"></div><p>Сбор и доставку товаров осуществляем в максимально короткие сроки, вы даже не заметите:<br>- 1-3 дня по Украине;<br>- 1-6 дней по России и СНГ;<br>Доставку осуществляем компаниямии:<br>Новая Почта, ЕМС, Почта России а также поездом.</p></div><div class="i-win2" style="display: none;"><div class="cor2"></div><p>Оплату принимаем практически любым видом перевода: Приват24, W1, Unistream, Qiwi-Кошелек, Контакт.</p></div><div class="i-win3" style="display: none;"><div class="cor3"></div><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->subdomain_html)){?><pre><?php echo $_smarty_tpl->tpl_vars['product']->value->subdomain_html;?>
</pre><?php }else{ ?><table style="color: black;"><tbody><tr><td>Между-<br>народный</td> <td>|EU</td> <td> |RU</td> <td>Объем груди</td> <td>Объем бедер</td> <td>Объем талии</td></tr><tr><td>S</td> <td>36</td> <td>42</td> <td>80-90</td> <td>80-90</td><td>до 66</td></tr><tr><td>M</td> <td>38</td> <td>44</td> <td>91-95</td> <td>91-96</td><td>до 70</td></tr><tr><td>L</td> <td>40</td> <td>46</td> <td>96-100</td> <td>97-104</td><td>до 76</td></tr><tr><td>XL</td> <td>-</td> <td>48</td> <td>102</td> <td>106</td><td>78</td></tr><tr><td>XXL</td> <td>-</td> <td>50</td> <td>104</td> <td>106-108</td><td>82</td></tr><tr><td>XXXL</td> <td>-</td> <td>52</td> <td>106</td> <td>109-112</td><td>86</td></tr></tbody></table><?php }?></div><div class="i-win4" style="display: none;"><div class="cor4"></div><p>По вопросам, касающимся доставки либо оплаты пишите на почту: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->email1'),$_smarty_tpl);?>
<br>Контактный номер телефона:<br><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->phone1'),$_smarty_tpl);?>
</p></div><a id="i1"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/icon1.png" alt="" /></a> <a id="i2"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/icon2.png" alt="" /></a> <a id="i3"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/icon3.png" alt="" /></a> <a id="i4"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/icon4.png" alt="" /></a></div><!-- .icons --><div class="clr"></div><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->tags)){?><br /><p class="tags"><?php echo $_smarty_tpl->tpl_vars['product']->value->tags;?>
</p><?php }?></div><!-- .product-right --></div><!-- .product-right-wrapp --><div class="col-md-12 col-xs-12"><?php $_smarty_tpl->tpl_vars['items'] = new Smarty_variable((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['products']->value->related_products)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['mores']->value : $tmp))===null||$tmp==='' ? false : $tmp), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><hr class="separator" /><div class="product-rel"><div class="product-rel-t">ПРЕДЛАГАЕМ ПОСМОТРЕТЬ</div><div class="product-rel-arr"><a href="#" class="prev prevv"></a><a href="#" class="next nextt"></a></div><div class="clr"></div><div class="cat"><ul class=""><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li class=""><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</li><?php } ?></ul><div class="clr"></div></div></div><?php }?></div></div><!-- /.row --></div><!-- .product-info --></div><!-- .product-page --><?php if (!empty($_smarty_tpl->tpl_vars['recent_products']->value)){?><div class="col-md-12"><hr class="separator" /><div class="product-rel"><div class="product-rel-t">ВЫ НЕДАВНО СМОТРЕЛИ</div><div class="product-rel-arr"><a href="#" class="prev prevv"></a><a href="#" class="next nextt"></a></div><div class="clr"></div><div class="cat"><ul class=""><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['recent_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li class=""><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</li><?php } ?></ul><div class="clr"></div></div></div></div><?php }?></div><!-- .right --><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('from'=>'product','signed'=>false,'assign'=>'price'),$_smarty_tpl);?>
<?php $_smarty_tpl->_capture_stack[0][] = array('default', 'price', null); ob_start(); ?> за <?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(preg_replace('/\s*\|\s*lemanta\s*$/iu','',$_smarty_tpl->tpl_vars['title']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(preg_replace('/за\s+[0-9]+\s+грн\.*$/iu','',$_smarty_tpl->tpl_vars['title']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(preg_replace('/\.*$/iu','',$_smarty_tpl->tpl_vars['title']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable(((($_smarty_tpl->tpl_vars['title']->value).(' ')).($_smarty_tpl->tpl_vars['price']->value)).('. | Lemanta'), null, 0);?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable($_smarty_tpl->tpl_vars['title']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php }?>
<?php }} ?>