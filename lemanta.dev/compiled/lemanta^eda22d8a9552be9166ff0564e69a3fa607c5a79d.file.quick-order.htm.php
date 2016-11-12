<?php /* Smarty version Smarty-3.1.8, created on 2016-11-12 13:16:22
         compiled from "design/lemanta/html\common\quick-order.htm" */ ?>
<?php /*%%SmartyHeaderCode:99085826ebf60cbef5-76527167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eda22d8a9552be9166ff0564e69a3fa607c5a79d' => 
    array (
      0 => 'design/lemanta/html\\common\\quick-order.htm',
      1 => 1478894983,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99085826ebf60cbef5-76527167',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'image' => 0,
    'product' => 0,
    'number' => 0,
    'helper' => 0,
    'v' => 0,
    'vid' => 0,
    'price' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5826ebf6149e18_61128256',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5826ebf6149e18_61128256')) {function content_5826ebf6149e18_61128256($_smarty_tpl) {?><div class="for_vs" id="cl_form" style="top: -1000px"><div style="opacity: 1" id="cl_form_inner"><div id="cl_form_title"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
<div title="Закрыть окно" id="cl_form_close"></div></div><div id="cl_form_body"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('from'=>'product','type'=>'product','assign'=>'image'),$_smarty_tpl);?>
<div id="cl_form_img_wrap"><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
" width="262" /></div><?php if (count($_smarty_tpl->tpl_vars['product']->value->images)>1){?><div id="cl_form_photos"><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['images'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['images']);
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
<?php if (empty($_smarty_tpl->tpl_vars['image']->value['found'])){?><?php break 1?><?php }?><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['thumb'];?>
" onmouseover="$('#cl_form_img_wrap img').attr('src', '<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
')" alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
" width="95" /><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php endfor; endif; ?></div><?php }?><div id="cl_form_desc"><div id="cl_form_desc_text"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['annotation'][0][0]->annotation(array('from'=>'product'),$_smarty_tpl);?>
</div><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->brand)){?><span><b>Производитель:</b> <?php echo $_smarty_tpl->tpl_vars['product']->value->brand;?>
</span><?php }?><div class="pp_icons" id="cl_pp_icons"><div class="pp_dostavka"><span></span><div><i></i><div>Сбор и доставку товаров осуществляем в максимально короткие сроки, вы даже не заметите:<br>- 1-3 дня по Украине;<br>- 1-6 дней по России и СНГ;<br>Доставку осуществляем компаниямии:<br>НоваяПочта, ЕМС, Dimex, ПЭК, ЖэлДорЭкспедиция, БайкалСервис, ДеловыеЛинии, Почта России а также поездом.</div></div></div><div class="pp_money"><span></span><div><i></i><div>Оплату принимаем практически любым видом перевода:<br>Приват24, W1, Unistream, Qiwi-Кошелек, Контакт.</div></div></div><div class="pp_sizes"><span></span><div><i></i><div><?php if (!empty($_smarty_tpl->tpl_vars['product']->value->subdomain_html)){?><pre><?php echo $_smarty_tpl->tpl_vars['product']->value->subdomain_html;?>
</pre><?php }else{ ?><table style="color: black;"><tbody><tr><td>Между-<br>народный</td> <td>Евро размер</td> <td>Российский</td> <td>Объем груди</td> <td>Объем бедер</td> <td>Объем талии</td></tr><tr><td>S</td> <td>36</td> <td>42</td> <td>80-90</td> <td>80-90</td><td>до 66</td></tr><tr><td>M</td> <td>38</td> <td>44</td> <td>91-95</td> <td>91-96</td><td>до 70</td></tr><tr><td>L</td> <td>40</td> <td>46</td> <td>96-100</td> <td>97-104</td><td>до 76</td></tr><tr><td>XL</td> <td>-</td> <td>48</td> <td>102</td> <td>106</td><td>78</td></tr><tr><td>XXL</td> <td>-</td> <td>50</td> <td>104</td> <td>106-108</td><td>82</td></tr><tr><td>XXXL</td> <td>-</td> <td>52</td> <td>106</td> <td>109-112</td><td>86</td></tr></tbody></table><?php }?></div></div></div><div class="pp_question"><span></span><div><i></i><div>Вопросы пишите на почту: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['email'][0][0]->email(array(),$_smarty_tpl);?>
<br>Контактные номера телефонов:<br><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['phone'][0][0]->phone(array(),$_smarty_tpl);?>
<br><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['phone'][0][0]->phone(array('num'=>2),$_smarty_tpl);?>
<br><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['phone'][0][0]->phone(array('num'=>3),$_smarty_tpl);?>
</div></div></div></div></div><div id="cl_form_sizes"><?php if ($_smarty_tpl->tpl_vars['helper']->value->maybeSale($_smarty_tpl->tpl_vars['product']->value)){?><div class="options quick-order-variants"><?php if (count($_smarty_tpl->tpl_vars['product']->value->variants)>0){?><form name="variants"><ul><li class="first"><span>Размеры:</span><span>Количество:</span></li><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['vid'] = new Smarty_variable(htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['v']->value->variant_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['price'] = new Smarty_variable($_smarty_tpl->tpl_vars['helper']->value->priceForScreen($_smarty_tpl->tpl_vars['v']->value->discount_price), null, 0);?><li><a title="Нажмите, чтобы купить" data-id="<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value->name;?>
</a><div class="product-price"><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</div><div class="amount"><input type="text" name="amounts[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" value="1" data-max="<?php echo $_smarty_tpl->tpl_vars['v']->value->stock;?>
" /><div class="spinner"><i title="Увеличить количество" class="spinner-up">&and;</i><i title="Уменьшить количество" class="spinner-down">&or;</i></div></div></li><?php } ?></ul><input type="button" value="в корзину" class="buy fr addtocard" data-result-text="Добавлено" /><div class="error" style="display: none">Выберите размер<br />и количество!</div></form><?php }else{ ?><p>Нет в наличии.</p><?php }?></div><?php }?><div id="cl_form_tb"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'product'),$_smarty_tpl);?>
" id="cl_form_link">Посмотреть товар</a></div></div></div></div></div><script>startQuickOrderScripts();</script>
<?php }} ?>