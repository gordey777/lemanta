<?php /* Smarty version Smarty-3.1.8, created on 2016-09-14 14:18:14
         compiled from "../admin/design/default/html/admin_product.htm" */ ?>
<?php /*%%SmartyHeaderCode:23023608557d931f63fd166-68001666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1cc5419ae6d9d29cf467285d1e8a59b386e6a3c' => 
    array (
      0 => '../admin/design/default/html/admin_product.htm',
      1 => 1462406606,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23023608557d931f63fd166-68001666',
  'function' => 
  array (
    'productpage_price_field_content' => 
    array (
      'parameter' => 
      array (
        'id' => 0,
        'num' => 1,
      ),
      'compiled' => '',
    ),
    'productpage_actional_field_content' => 
    array (
      'parameter' => 
      array (
        'id' => 0,
        'num' => 1,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'site' => 0,
    'admin_folder' => 0,
    'temp_url_main' => 0,
    'settings' => 0,
    'item' => 0,
    'currency' => 0,
    'temp_url_script' => 0,
    'id' => 0,
    'error' => 0,
    'message' => 0,
    'categories' => 0,
    'all_brands' => 0,
    'terms' => 0,
    'r' => 0,
    'properties' => 0,
    'Token' => 0,
    'option' => 0,
    'value' => 0,
    'tag_selected_option' => 0,
    'p' => 0,
    'pc' => 0,
    'temp_exchange' => 0,
    'temp_price' => 0,
    'temp_index' => 0,
    'temp_field' => 0,
    'temp_param' => 0,
    'temp_ok' => 0,
    'temp_group' => 0,
    'temp_more_link' => 0,
    'num' => 0,
    'temp_url_images' => 0,
    'temp_value' => 0,
    'currencyId' => 0,
    'currencies' => 0,
    'itemId' => 0,
    'temp' => 0,
    'image' => 0,
    'c' => 0,
    'all_articles' => 0,
    'all_news' => 0,
    'all_users' => 0,
    'menus' => 0,
    'param' => 0,
    'mask' => 0,
    'i' => 0,
    'file' => 0,
    'from_page' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d931f6d5ee68_67526495',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d931f6d5ee68_67526495')) {function content_57d931f6d5ee68_67526495($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?><?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>'card','main'=>true,'products'=>true,'card_products'=>true,'products_kits'=>true,'categories'=>true,'brands'=>true,'properties'=>true,'stocks'=>true), 0);?>
<?php $_smarty_tpl->tpl_vars['temp_url_main'] = new Smarty_variable((((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)))).('/')), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_script'] = new Smarty_variable(((((htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8'))).('index.php?')).((htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8')))).('='), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_images'] = new Smarty_variable(((((htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8'))).('design/')).((htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8')))).('/images/'), null, 0);?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable(htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->product_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_exchange'] = new Smarty_variable(((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)), null, 0);?><script language="JavaScript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
js/calendar/calendar.js" type="text/javascript"></script><script language="JavaScript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
js/calendar/calendas.js" type="text/javascript"></script><link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
js/calendar/calendar.css" rel="stylesheet" type="text/css" /><div class="box"><h1><div class="path"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на главную страницу админпанели">Главная</a> → <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Products" title="Перейти на страницу товаров в админпанели">Товары</a> → <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>Редактирование<?php }else{ ?>Новый<?php }?></div><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)||((($tmp = @$_smarty_tpl->tpl_vars['item']->value->model)===null||$tmp==='' ? '' : $tmp)!='')){?><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value->model)===null||$tmp==='' ? '&nbsp;' : $tmp);?>
<?php }else{ ?>Новый товар<?php }?></h1><div class="toolkey"><a class="left information-part-nonactive" id="information-part-product-name-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о названии товара" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-name', 1);">название</a><a class="left information-part-nonactive" id="information-part-product-properties-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о свойствах" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-properties', 2);">свойства</a><a class="left information-part-nonactive" id="information-part-product-variants-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о вариантах товара" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-variants', 3);">варианты</a><a class="left information-part-nonactive" id="information-part-product-photos-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о фотографиях" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-photos', 4);">фото</a><a class="left information-part-nonactive" id="information-part-product-meta-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о мета данных" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-meta', 5);">мета</a><a class="left information-part-nonactive" id="information-part-product-materials-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о связанных публикациях" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-materials', 6);">материалы</a><a class="left information-part-nonactive" id="information-part-product-description-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения об описании" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-description', 7);">описание</a><a class="left information-part-nonactive" id="information-part-product-seo-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о поисковом продвижении" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-seo', 8);">seo</a><a class="left information-part-nonactive" id="information-part-product-marketing-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о маркетинговых настройках" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-marketing', 9);">маркетинг</a><a class="left information-part-nonactive" id="information-part-product-subdomain-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о субдомене" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-subdomain', 10);">субдомен</a><a class="left information-part-nonactive" id="information-part-product-files-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать / спрятать сведения о медиа файлах" onclick="return Information_Part_Product_Switcher(this, '#information-part-product-files', 11);">файлы</a><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)&&((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url)===null||$tmp==='' ? '' : $tmp)!='')&&((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)=='')){?><a href="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url_path)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу товара в клиентской части сайта">у клиента</a><?php }?>&nbsp;<script language="JavaScript" type="text/javascript">function Information_Part_Product_Switcher ( link_object, id, cookie_index ) {if ((typeof(link_object) == 'object') && (link_object != null)) {if (id != '') {var max_index = 19;if ((cookie_index > 0) && (cookie_index < max_index)) {cookie_index--;var param = 'ImperaCMSInformationPartProductStates';var value = readCookie(param);if (value == null) value = '';var states = new Array();for (var i = 0; i <= max_index; i++) {states[i] = (value.substr(i, 1) == 1) ? '1' : '0';}var name = 'information-part-nonactive';if (jQuery(link_object).hasClass(name)) {jQuery(link_object).removeClass(name);jQuery(id).show();states[cookie_index] = '1';} else {jQuery(id).hide();jQuery(link_object).addClass(name);states[cookie_index] = '0';}value = '';for (var i = 0; i <= max_index; i++) {value += states[i];}eraseCookie(param);createCookie(param, value, 365);}}}return false;}function Information_Part_Product_Init () {var max_index = 19;var param = 'ImperaCMSInformationPartProductStates';var value = readCookie(param);if (value == null) value = '';var name = 'information-part-nonactive';var id = '';var states = new Array();for (var i = 0; i <= max_index; i++) {var c = value.substr(i, 1);if (c == '') {switch (i) {case 0: c = 1; break;case 2: c = 1; break;default: c = 0;}}states[i] = (c == 1) ? '1' : '0';switch (i) {case 0: id = '#information-part-product-name'; break;case 1: id = '#information-part-product-properties'; break;case 2: id = '#information-part-product-variants'; break;case 3: id = '#information-part-product-photos'; break;case 4: id = '#information-part-product-meta'; break;case 5: id = '#information-part-product-materials'; break;case 6: id = '#information-part-product-description'; break;case 7: id = '#information-part-product-seo'; break;case 8: id = '#information-part-product-marketing'; break;case 9: id = '#information-part-product-subdomain'; break;case 10: id = '#information-part-product-files'; break;default: id = '';}if (id != '') {if (c == 1) {jQuery(id + '-link').removeClass(name);jQuery(id).show();} else {jQuery(id).hide();jQuery(id + '-link').addClass(name);}}}value = '';for (var i = 0; i <= max_index; i++) {value += states[i];}eraseCookie(param);createCookie(param, value, 365);}jQuery(document).ready(function () {Information_Part_Product_Init();});</script></div><?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="message"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div><?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="error"><b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><form action="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Product" enctype="multipart/form-data" id="item_form" method="post"><div id="information-part-product-name"><h2>Название</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param">Название:</td><td class="value value_sheet" width="100%" title="Название товара (будет выводиться у клиентов в составном формате: Категория Бренд Название товара)"><input class="edit" id="item_form_name_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="model[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->model)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short">Код:</td><td class="value value_sheet" title="Буквенный код товара"><input class="edit" name="pcode[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="12" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->pcode)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Categories" title="Перейти на страницу категорий в админпанели">Категория</a>:</td><td class="value value_sheet" colspan="4" width="100%" title="К какой категории принадлежит товар"><select id="item_form_category_id" name="category_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" onchange="Moderate_Articul(this); Display_Properties(this.value);"><?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/categories.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>(($tmp = @$_smarty_tpl->tpl_vars['categories']->value)===null||$tmp==='' ? false : $tmp),'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->category_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>
</select></td><td class="param_short" width="1%" title="Имеет ли товар дополнительные прикрепления к другим категориям"><input class="checkbox" id="item_form_use_categories" name="use_categories[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->use_categories)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" onchange="document.getElementById('use_categories_box').style.display = this.checked ? '' : 'none';" /><span onclick="Toggle_PageCheckbox('item_form_use_categories');">&nbsp; К нескольким</span></td></tr><tr id="use_categories_box"<?php if (!(($tmp = @$_smarty_tpl->tpl_vars['item']->value->use_categories)===null||$tmp==='' ? false : $tmp)){?> style="display: none;"<?php }?>><td class="param_high">К чему еще прикреплен:</td><td class="value value_sheet" colspan="5" title="К каким еще категориям прикреплен данный товар (несколько выбираются с помощью клавиш Shift и Ctrl)"><input name="categories[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="" /><select multiple name="categories[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][]" size="7"><?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/categories.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>(($tmp = @$_smarty_tpl->tpl_vars['categories']->value)===null||$tmp==='' ? false : $tmp),'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->categories)===null||$tmp==='' ? '' : $tmp),'selector'=>true), 0);?>
</select></td></tr><tr><td class="param"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Brands" title="Перейти на страницу брендов в админпанели">Бренд</a>:</td><td class="value value_sheet" width="50%" title="К какому бренду принадлежит товар"><select name="brand_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]"><option value="0">Нет</option><?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/brands.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>(($tmp = @$_smarty_tpl->tpl_vars['all_brands']->value)===null||$tmp==='' ? false : $tmp),'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->brand_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>
</select></td><td class="param_short" width="1%"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
ShippingsTerms" title="Перейти на страницу сроков отправки в админпанели">Срок отправки</a>:</td><td class="value value_sheet" width="50%" title="Срок отправки этого товара"><select name="shippings_term_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]"><option value="0"></option><?php if (isset($_smarty_tpl->tpl_vars['terms']->value)&&is_array($_smarty_tpl->tpl_vars['terms']->value)&&!empty($_smarty_tpl->tpl_vars['terms']->value)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['terms']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><option value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->term_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['r']->value->term_id)===null||$tmp==='' ? '' : $tmp)==(($tmp = @$_smarty_tpl->tpl_vars['item']->value->shippings_term_id)===null||$tmp==='' ? 0 : $tmp)){?> selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->name)===null||$tmp==='' ? 'Без названия!' : $tmp);?>
</option><?php } ?><?php }?></select></td><td class="param_short">Штрих код:</td><td class="value value_sheet" title="Штрих код товара"><input class="edit" name="barcode[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="15" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->barcode)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td></tr></table></div><div id="information-part-product-properties"><script language="JavaScript" type="text/javascript">var suggested_articul_prefix = '';var suggested_articul_number = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['randomId'][0][0]->randomId(array('size'=>4),$_smarty_tpl);?>
';</script><?php if (isset($_smarty_tpl->tpl_vars['properties']->value)&&is_array($_smarty_tpl->tpl_vars['properties']->value)&&!empty($_smarty_tpl->tpl_vars['properties']->value)){?><h2><span class="path">перечень зависит от выбранной категории</span>Характеристики, не зависящие от варианта товара</h2><input name="properties[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="" /><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['properties']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><table align="center" cellpadding="0" cellspacing="10" class="white" id="properties[<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->property_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
]" style="display: none;"><tr><td class="param_high"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Property&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ITEMID)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->property_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу редактирования этого свойства в админпанели"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->name)===null||$tmp==='' ? 'Без названия!' : $tmp);?>
</a>:</td><td class="value value_sheet" width="100%" title="Возможные значения такого свойства товара (несколько выбираются с помощью клавиш Shift и Ctrl)"><?php if (isset($_smarty_tpl->tpl_vars['r']->value->options)&&is_array($_smarty_tpl->tpl_vars['r']->value->options)&&!empty($_smarty_tpl->tpl_vars['r']->value->options)){?><select multiple name="properties[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->property_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
][]" size="5"><?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value->options; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
$_smarty_tpl->tpl_vars['option']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['tag_selected_option'] = new Smarty_variable('', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['r']->value->value)&&is_array($_smarty_tpl->tpl_vars['r']->value->value)&&!empty($_smarty_tpl->tpl_vars['r']->value->value)){?><?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['option']->value==$_smarty_tpl->tpl_vars['value']->value){?><?php $_smarty_tpl->tpl_vars['tag_selected_option'] = new Smarty_variable(' selected', null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><option value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['option']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['tag_selected_option']->value;?>
><?php echo (($tmp = @$_smarty_tpl->tpl_vars['option']->value)===null||$tmp==='' ? 'Без значения!' : $tmp);?>
</option><?php } ?></select><?php }else{ ?><input class="edit" name="properties[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->property_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
][]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->value[0])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /><?php }?></td></tr></table><?php } ?><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_short" width="100%">&nbsp;</td><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table><script language="JavaScript" type="text/javascript">var properties = new Array();<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['properties']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>properties[<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['p']->value->property_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
] = Array(<?php if (isset($_smarty_tpl->tpl_vars['p']->value->categories)&&is_array($_smarty_tpl->tpl_vars['p']->value->categories)&&!empty($_smarty_tpl->tpl_vars['p']->value->categories)){?><?php  $_smarty_tpl->tpl_vars['pc'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pc']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['p']->value->categories; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['pc']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['pc']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['pc']->key => $_smarty_tpl->tpl_vars['pc']->value){
$_smarty_tpl->tpl_vars['pc']->_loop = true;
 $_smarty_tpl->tpl_vars['pc']->iteration++;
 $_smarty_tpl->tpl_vars['pc']->last = $_smarty_tpl->tpl_vars['pc']->iteration === $_smarty_tpl->tpl_vars['pc']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pc']['last'] = $_smarty_tpl->tpl_vars['pc']->last;
?>'<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['pc']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
'<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['pc']['last']){?>,<?php }?><?php } ?><?php }?>);<?php } ?>function Display_Properties (category_id) {for (var i in properties) {if (in_array(category_id, properties[i])) {document.getElementById('properties[' + i + ']').style.display = '';} else {document.getElementById('properties[' + i + ']').style.display = 'none';}}}function in_array(what, where) {for (var i = 0; i < where.length; i++) {if (what == where[i]) return true;}return false;}var suggested_articul_automated = false;var suggested_articul_previous = '';function Moderate_Articul ( selector ) {if ((typeof(selector) == 'object') && (selector != null)&& ('selectedIndex' in selector)&& ('options' in selector)&& ('length' in selector.options)&& (selector.options.length > selector.selectedIndex)) {var option = selector.options[selector.selectedIndex];if ((typeof(option) == 'object') && (option != null)&& ('innerText' in option)) {option = option.innerText + ' ';option = option.replace(/^[\s\t\r\n]+/, '');option = option.replace(/[\s\t\r\n]+$/, ' ');var prev = '';while (prev != option) {prev = option;option = option.replace(/[^a-zа-яё]+/ig, ' ');}prev = '';while (prev != option) {prev = option;option = option.replace(/([^\s])[^\s]+\s/ig, '$1 ');}prev = '';while (prev != option) {prev = option;option = option.replace(/[\s\t\r\n]+/, '');}suggested_articul_prefix = option.toLowerCase();suggested_articul_prefix = suggested_articul_prefix.substr(0, 2);var suggest = suggested_articul_prefix + suggested_articul_number;var value = '';var item = null;var items = jQuery('input.variant_sku_edit');if ((typeof(items) == 'object') && (items != null)&& ('length' in items)&& (items.length > 0)) {for (var i = 0; i < items.length; i++) {item = items[i];if ((typeof(item) == 'object') && (item != null)&& ('value' in item)) {value = item.value;prev = '';while (prev != value) {prev = value;value = value.replace(/[\s\t\r\n]+/, '');}if (value == '') {item.value = suggest + ((i > 0) ? '-' + (i + 1) : '');suggested_articul_automated = true;} else if (value == suggested_articul_previous) {item.value = suggest + ((i > 0) ? '-' + (i + 1) : '');} else if ((suggested_articul_previous != '') && (value.substr(0, suggested_articul_previous.length + 1) == suggested_articul_previous + '-')) {item.value = suggest + value.substr(suggested_articul_previous.length);}}}}suggested_articul_previous = suggest;}}}jQuery(document).ready(function () {var object = document.getElementById('item_form_category_id');Moderate_Articul(object);Display_Properties(object.value);});</script><?php }?></div><div id="information-part-product-variants"><h2>Варианты товара</h2><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (!function_exists('smarty_template_function_productpage_price_field_content')) {
    function smarty_template_function_productpage_price_field_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['productpage_price_field_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><td class="value value_sheet"><?php $_smarty_tpl->tpl_vars['temp_price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->price)===null||$tmp==='' ? 0 : $tmp)>0 ? (smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->price*(($tmp = @$_smarty_tpl->tpl_vars['temp_exchange']->value)===null||$tmp==='' ? 1 : $tmp))),',','.')) : '0.00', null, 0);?><input class="edit edit_price" readonly size="10" style="width: auto;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['temp_price']->value;?>
" /><div class="prices_edit_list"><div class="prices_edit_list_title">цены по группам:<a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
PriceGroups" title="Редактировать список ценовых групп">редактировать группы</a></div><?php $_smarty_tpl->tpl_vars['temp_more_link'] = new Smarty_variable(false, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['items'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['items']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['name'] = 'items';
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] = is_array($_loop=(($tmp = @@PRICE_TYPES_MAXCOUNT)===null||$tmp==='' ? 10 : $tmp)+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total']);
?><?php $_smarty_tpl->tpl_vars['temp_index'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['items']['index'], null, 0);?><?php $_smarty_tpl->tpl_vars['temp_param'] = new Smarty_variable(('price_type').($_smarty_tpl->tpl_vars['temp_index']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_ok'] = new Smarty_variable(false, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_group'] = new Smarty_variable('', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['settings']->value)&&is_object($_smarty_tpl->tpl_vars['settings']->value)){?><?php  $_smarty_tpl->tpl_vars['temp_group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['temp_group']->_loop = false;
 $_smarty_tpl->tpl_vars['temp_field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['settings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['temp_group']->key => $_smarty_tpl->tpl_vars['temp_group']->value){
$_smarty_tpl->tpl_vars['temp_group']->_loop = true;
 $_smarty_tpl->tpl_vars['temp_field']->value = $_smarty_tpl->tpl_vars['temp_group']->key;
?><?php if ($_smarty_tpl->tpl_vars['temp_field']->value==$_smarty_tpl->tpl_vars['temp_param']->value){?><?php $_smarty_tpl->tpl_vars['temp_ok'] = new Smarty_variable(true, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['temp_group'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_ok']->value ? (smarty_modifier_regex_replace(smarty_modifier_regex_replace(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['temp_group']->value,'/[\s\t\r\n]+/u',' '),'/^[\s\t\r\n]+/u',''),'/[\s\t\r\n]+$/u','')) : '', null, 0);?><?php $_smarty_tpl->tpl_vars['temp_more_link'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_more_link']->value||($_smarty_tpl->tpl_vars['temp_group']->value==''), null, 0);?><div <?php echo ($_smarty_tpl->tpl_vars['temp_group']->value=='')&&($_smarty_tpl->tpl_vars['temp_index']->value>1) ? "style='display: none;'" : '';?>
><?php $_smarty_tpl->tpl_vars['temp_param'] = new Smarty_variable(('price').(($_smarty_tpl->tpl_vars['temp_index']->value>1 ? $_smarty_tpl->tpl_vars['temp_index']->value : '')), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_ok'] = new Smarty_variable(false, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_price'] = new Smarty_variable(0, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&is_object($_smarty_tpl->tpl_vars['item']->value)){?><?php  $_smarty_tpl->tpl_vars['temp_price'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['temp_price']->_loop = false;
 $_smarty_tpl->tpl_vars['temp_field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['temp_price']->key => $_smarty_tpl->tpl_vars['temp_price']->value){
$_smarty_tpl->tpl_vars['temp_price']->_loop = true;
 $_smarty_tpl->tpl_vars['temp_field']->value = $_smarty_tpl->tpl_vars['temp_price']->key;
?><?php if ($_smarty_tpl->tpl_vars['temp_field']->value==$_smarty_tpl->tpl_vars['temp_param']->value){?><?php $_smarty_tpl->tpl_vars['temp_ok'] = new Smarty_variable(true, null, 0);?><?php break 1?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['temp_price'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_ok']->value ? $_smarty_tpl->tpl_vars['temp_price']->value : 0, null, 0);?><?php $_smarty_tpl->tpl_vars['temp_price'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_price']->value>0 ? (smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['temp_price']->value*(($tmp = @$_smarty_tpl->tpl_vars['temp_exchange']->value)===null||$tmp==='' ? 1 : $tmp))),',','.')) : '0.00', null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?><input name="previous_variant_price<?php echo $_smarty_tpl->tpl_vars['temp_index']->value>1 ? $_smarty_tpl->tpl_vars['temp_index']->value : '';?>
[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['temp_price']->value;?>
" /><?php }?><input class="edit edit_price" name="variant_price<?php echo $_smarty_tpl->tpl_vars['temp_index']->value>1 ? $_smarty_tpl->tpl_vars['temp_index']->value : '';?>
[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" maxlength="13" size="13" style="width: auto;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['temp_price']->value;?>
" title="Основная цена<?php if ($_smarty_tpl->tpl_vars['temp_index']->value>1){?> (равная 0 означает использовать цену первой группы)<?php }else{ ?>" onchange="jQuery(this).closest('td').children('input').val(this.value);" onkeyup="jQuery(this).closest('td').children('input').val(this.value);<?php }?>" /><span title="Порядковый номер ценовой группы"><?php echo $_smarty_tpl->tpl_vars['temp_index']->value;?>
.</span><?php echo $_smarty_tpl->tpl_vars['temp_group']->value=='' ? ((('Без названия (тип ').($_smarty_tpl->tpl_vars['temp_index']->value)).(')')) : $_smarty_tpl->tpl_vars['temp_group']->value;?>
</div><?php if ($_smarty_tpl->getVariable('smarty')->value['section']['items']['last']&&$_smarty_tpl->tpl_vars['temp_more_link']->value){?><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Показать также группы без названия" onclick="jQuery(this).hide().parent().children('div').show(); return false;">показать все группы</a><?php }?><?php endfor; endif; ?></div></td><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.date_format.php';
?><?php if (!function_exists('smarty_template_function_productpage_actional_field_content')) {
    function smarty_template_function_productpage_actional_field_content($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['productpage_actional_field_content']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><td class="value value_actional" title="Акционная цена"><?php $_smarty_tpl->tpl_vars['temp_price'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->temp_price)===null||$tmp==='' ? 0 : $tmp)>0 ? (smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->temp_price*(($tmp = @$_smarty_tpl->tpl_vars['temp_exchange']->value)===null||$tmp==='' ? 1 : $tmp))),',','.')) : '', null, 0);?><input class="edit edit_price" readonly size="10" style="width: auto;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['temp_price']->value;?>
" /><div class="prices_edit_list"><div class="prices_edit_list_title">параметры акции:</div><div><span style="display: block; float: left; width: 55px;">цена:</span><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?><input name="previous_variant_temp_price[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['temp_price']->value;?>
" /><?php }?><input class="edit edit_price" name="variant_temp_price[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" maxlength="13" size="16" style="width: auto;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['temp_price']->value;?>
" title="Акционная цена" onchange="jQuery(this).closest('td').children('input').val(this.value);" onkeyup="jQuery(this).closest('td').children('input').val(this.value);" /><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_order_canceled_16x16.png" title="Очистить поле" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[0]).val('').change(); return false;" /></div><div><span style="display: block; float: left; width: 55px;">срок:</span><input class="edit" name="variant_temp_price_start[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" maxlength="16" size="10" style="width: auto;" type="text" value="<?php if (smarty_modifier_truncate((($tmp = @$_smarty_tpl->tpl_vars['item']->value->temp_price_start)===null||$tmp==='' ? '0000-00-00' : $tmp),10,'',true)!='0000-00-00'){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value->temp_price_start,16,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }?>" title="Дата ГГГГ-ММ-ДД ЧЧ:мм начала действия акционной цены" /><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_order_canceled_16x16.png" title="Очистить поле" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[0]).val(''); return false;" /><span><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_automatic_16x16.png" title="Установить начало действия от сегодняшнего дня" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[0]).val('<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
 00:00'); return false;" /></span><input class="edit" name="variant_temp_price_date[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" maxlength="16" size="10" style="width: auto;" type="text" value="<?php if (smarty_modifier_truncate((($tmp = @$_smarty_tpl->tpl_vars['item']->value->temp_price_date)===null||$tmp==='' ? '0000-00-00' : $tmp),10,'',true)!='0000-00-00'){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value->temp_price_date,16,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }?>" title="Дата ГГГГ-ММ-ДД ЧЧ:мм конца действия акционной цены или пустая строка, если действует неограниченно долго" /><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_order_canceled_16x16.png" title="Очистить поле" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[1]).val(''); return false;" /><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_automatic_16x16.png" title="Установить действие до окончания сегодняшнего дня" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[1]).val('<?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
 23:59'); return false;" /></div><div><span style="display: block; float: left; width: 55px;">требует:</span><?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable(sprintf('%d',(($tmp = @$_smarty_tpl->tpl_vars['item']->value->temp_price_members)===null||$tmp==='' ? 0 : $tmp))>0 ? (sprintf('%d',$_smarty_tpl->tpl_vars['item']->value->temp_price_members)) : '', null, 0);?><input class="edit" name="variant_temp_price_members[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" maxlength="3" size="2" style="width: auto;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['temp_value']->value;?>
" title="Число участников, по достижению которого происходит возврат акционной разницы цены на внутренний счет покупателя" /><span><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_order_canceled_16x16.png" title="Очистить поле" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[0]).val(''); return false;" /></span><span>уже есть</span><?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable(sprintf('%d',(($tmp = @$_smarty_tpl->tpl_vars['item']->value->temp_price_invited)===null||$tmp==='' ? 0 : $tmp))>0 ? (sprintf('%d',$_smarty_tpl->tpl_vars['item']->value->temp_price_invited)) : '', null, 0);?><input class="edit" name="variant_temp_price_invited[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['num']->value;?>
]" maxlength="3" size="2" style="width: auto;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['temp_value']->value;?>
" title="Число уже привлеченных участников" /><span>участников</span><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_order_canceled_16x16.png" title="Очистить поле" onclick="var o = jQuery(this).closest('div').find('input[type=text]'); jQuery(o[1]).val(''); return false;" /></div></div></td><td class="param_short"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp);?>
</td><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<table align="center" cellpadding="0" cellspacing="10" class="white" id="product_variants"><?php $_smarty_tpl->tpl_vars['currencyId'] = new Smarty_variable(0, null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->variants)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['variants']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['variants']['iteration']++;
?><?php if (empty($_smarty_tpl->tpl_vars['currencyId']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'r->currency_id','assign'=>'currencyId'),$_smarty_tpl);?>
<?php }?><tr><td class="param_short"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
.</td><td class="value value_sheet" width="100%" title="Название варианта"><input class="edit" name="variant_name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /><input name="variant_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" type="hidden" value="<?php if (!isset($_smarty_tpl->tpl_vars['r']->value->virtual)){?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->variant_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0<?php }?>" /></td><td class="value value_sheet" title="Артикул"><input class="edit variant_sku_edit" name="variant_sku[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" size="8" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->sku)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><?php smarty_template_function_productpage_price_field_content($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['r']->value,'id'=>$_smarty_tpl->tpl_vars['id']->value,'num'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration']));?>
<td class="value value_oldprice" title="Старая цена"><input class="edit edit_price" name="variant_old_price[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" size="10" style="width: auto;" type="text" value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['r']->value->old_price)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['r']->value->old_price*$_smarty_tpl->tpl_vars['temp_exchange']->value)),',','.');?>
<?php }?>" /></td><?php smarty_template_function_productpage_actional_field_content($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['r']->value,'id'=>$_smarty_tpl->tpl_vars['id']->value,'num'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration']));?>
<td class="value value_prioritydiscount" title="Приоритетная скидка (при указании перекрывает собой любой вид скидок, имеющийся у покупателя)"><input class="edit edit_discount" name="variant_priority_discount[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" maxlength="5" size="4" style="width: auto;" type="text" value="<?php if (((($tmp = @$_smarty_tpl->tpl_vars['r']->value->priority_discount)===null||$tmp==='' ? -1 : $tmp)>=0)&&($_smarty_tpl->tpl_vars['r']->value->priority_discount<=100)){?><?php echo smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['r']->value->priority_discount),',','.');?>
<?php }?>" /></td><td class="param_short">%</td><td class="value value_sheet" title="Количество на складе"><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?><input name="previous_variant_stock[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->stock)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
" /><?php }?><input class="edit edit_quantity" name="variant_stock[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" maxlength="10" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->stock)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short">шт.</td><td class="params_short" nowrap><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Опустить ниже" onclick="return MoveDown_TableRow(this, 1);"><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_move_down_16x16.png" /></a><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Поднять выше" onclick="return MoveUp_TableRow(this, 0);"><img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_move_up_16x16.png" /></a></td><td class="param_short" title="Использовать ли этот вариант (варианты со снятым флажком будут удалены)"><input class="checkbox" name="variant_used[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['variants']['iteration'];?>
]" type="checkbox" checked value="1" onchange="Toggle_TableRowTransparency(this, this.checked, 0.3);" /></td></tr><?php } ?><?php }?><tr><td class="param_short" colspan="3"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить вариант" onclick="return Append_VariantTableRow(this);">добавить</a></td><td class="param_short">Валюта:</td><td class="value value_sheet" colspan="3" title="Базовая валюта товара (по умолчанию базовая валюта сайта)"><select name="variant_currency_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][1]"><option value=""></option><?php if (!empty($_smarty_tpl->tpl_vars['currencies']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'c->currency_id'),$_smarty_tpl);?>
<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'c->currency_id','assign'=>'itemId'),$_smarty_tpl);?>
<option value="<?php echo $_smarty_tpl->tpl_vars['itemId']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['itemId']->value==$_smarty_tpl->tpl_vars['currencyId']->value){?> selected<?php }?>><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'c'),$_smarty_tpl);?>
</option><?php } ?><?php }?></select></td><td class="value_box" colspan="3" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="post_as_accept" type="submit" value="Применить" /></td><td class="value_box" colspan="3" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table><script language="JavaScript" type="text/javascript">function Append_VariantTableRow ( object ) {var table = jQuery(object).parent().parent().parent();if ((typeof(table) == 'object') && (table != null) && (table.length == 1)) {var tr = jQuery(table).find('tr');var num = tr.length;if (num > 0) {if (num <= 100) {var last_html = tr[num - 1].innerHTML;var id = <?php echo $_smarty_tpl->tpl_vars['id']->value;?>
;<?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable('', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['item']->value->variants)&&is_array($_smarty_tpl->tpl_vars['item']->value->variants)&&!empty($_smarty_tpl->tpl_vars['item']->value->variants)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable(smarty_modifier_regex_replace(((($tmp = @$_smarty_tpl->tpl_vars['r']->value->sku)===null||$tmp==='' ? '' : $tmp)),'/[\s\t\r\n]/',''), null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp']->value!=''){?><?php if (($_smarty_tpl->tpl_vars['temp_value']->value=='')||(strlen($_smarty_tpl->tpl_vars['temp']->value)<strlen($_smarty_tpl->tpl_vars['temp_value']->value))){?><?php $_smarty_tpl->tpl_vars['temp_value'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp']->value, null, 0);?><?php }?><?php }?><?php } ?><?php }?>var sku = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_value']->value, ENT_QUOTES, 'UTF-8');?>
';if (sku == '') sku = suggested_articul_prefix + suggested_articul_number;<?php ob_start(); smarty_template_function_productpage_price_field_content($_smarty_tpl,array('item'=>false,'id'=>0,'num'=>'new_variant_number')); $_smarty_tpl->assign('temp', ob_get_clean());?>
var price_field = '<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['temp']->value,'\\','\\\\'),'\'','\\\'');?>
';var prev = '';while (prev != price_field) {prev = price_field;price_field = price_field.replace(/\[0\]\[new_variant_number\]/, '[' + id + '][' +  num + ']');}<?php ob_start(); smarty_template_function_productpage_actional_field_content($_smarty_tpl,array('item'=>false,'id'=>0,'num'=>'new_variant_number')); $_smarty_tpl->assign('temp', ob_get_clean());?>
var actional_field = '<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['temp']->value,'\\','\\\\'),'\'','\\\'');?>
';prev = '';while (prev != actional_field) {prev = actional_field;actional_field = actional_field.replace(/\[0\]\[new_variant_number\]/, '[' + id + '][' +  num + ']');}var html = '<td class="param_short">' +num + '.' +'</td>' +'<td class="value value_sheet" width="100%" title="Название варианта">' +'<input class="edit" name="variant_name[' + id + '][' + num + ']" type="text" value="" />' +'<input name="variant_id[' + id + '][' + num + ']" type="hidden" value="0" />' +'</td>' +'<td class="value value_sheet" title="Артикул">' +'<input class="edit variant_sku_edit" name="variant_sku[' + id + '][' + num + ']" size="8" style="width: auto;" type="text" value="' + sku + ((num > 1) ? '-' + num : '') + '" />' +'</td>' +price_field +'<td class="value value_oldprice" title="Старая цена">' +'<input class="edit edit_price" name="variant_old_price[' + id + '][' + num + ']" size="10" style="width: auto;" type="text" value="" />' +'</td>' +actional_field +'<td class="value value_prioritydiscount" title="Приоритетная скидка (при указании перекрывает собой любой вид скидок, имеющийся у покупателя)">' +'<input class="edit edit_discount" name="variant_priority_discount[' + id + '][' + num + ']" maxlength="5" size="4" style="width: auto;" type="text" value="" />' +'</td>' +'<td class="param_short">' +'%' +'</td>' +'<td class="value value_sheet" title="Количество на складе">' +'<input class="edit edit_quantity" name="variant_stock[' + id + '][' + num + ']" maxlength="10" size="4" style="width: auto;" type="text" value="0" />' +'</td>' +'<td class="param_short">' +'шт.' +'</td>' +'<td class="params_short" nowrap>' +'<a href="#" title="Опустить ниже" onclick="return MoveDown_TableRow(this, 1);">' +'<img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_move_down_16x16.png" />' +'</a>' +'<a href="#" title="Поднять выше" onclick="return MoveUp_TableRow(this, 0);">' +'<img class="icon16x16" src="<?php echo $_smarty_tpl->tpl_vars['temp_url_images']->value;?>
icon_move_up_16x16.png" />' +'</a>' +'</td>' +'<td class="param_short" title="Использовать ли этот вариант (варианты со снятым флажком будут удалены)">' +'<input class="checkbox" name="variant_used[' + id + '][' + num + ']" type="checkbox" checked value="1" onchange="Toggle_TableRowTransparency (this, this.checked, 0.3);" />' +'</td>';tr[num - 1].innerHTML = html;jQuery(table).append('<tr>' + last_html + '</tr>');} else {alert('Добавление нового варианта отклонено, так как это превысит лимит их допустимого количества в товаре!');}}}return false;}</script></div><div id="information-part-product-photos"><h2>Фотографии</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_high">Изображения:<br><br><span style="color: #D0D0D0;">первое в списке считается основным фото</span></td><td class="value_box" id="images_section"><?php if (isset($_smarty_tpl->tpl_vars['item']->value->images)&&is_array($_smarty_tpl->tpl_vars['item']->value->images)&&!empty($_smarty_tpl->tpl_vars['item']->value->images)){?><?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->images; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['images']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['images']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['images']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['images']['index']++;
?><div class="image"><input class="checkbox_left" id="item_form_image_delete_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
" name="imagedelete[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="checkbox" value="1" onchange="Toggle_DivTransparency(this, !this.checked, 0.3);" title="Удалить ли это изображение (картинки с установленным флажком будут удалены)" /><span class="checkbox_left" onclick="Toggle_PageCheckbox('item_form_image_delete_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
');" title="Удалить ли это изображение (картинки с установленным флажком будут удалены)">убрать</span><input class="checkbox_right" name="imageview[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->images_view[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']])===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" title="Будет ли это изображение использоваться в слайдере или вьювере изображений" /><span class="checkbox_right">фото <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
</span><br><a href="<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['image']->value,7,'',true), 'UTF-8')!='http://'){?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
" target="_blank" <?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
"<?php }?>><img src="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']],7,'',true), 'UTF-8')!='http://'){?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['image']->value,7,'',true), 'UTF-8')!='http://'){?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?>" /></a><div><input name="image[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
" />заголовок (alt):<br><input name="imagealt[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Заголовок (всплывающая подсказка) этого изображения" /><br>описание:<br><textarea name="imagetext[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" title="Описание этого изображения"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->images_texts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></div></div><?php } ?><script language="JavaScript" type="text/javascript">jQuery('td#images_section').sortable({ containment: 'parent',items: 'div[class="image"]',opacity: 0.75,scrollSensitivity: 20,tolerance: 'pointer'});</script><?php }?><div style="clear: both;"><div class="newimage">новое изображение (объемом не более <?php echo sprintf('%d',(((($tmp = @@IMAGE_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp))/1024));?>
 Кбайт):<br><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo sprintf('%d',((($tmp = @@IMAGE_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp)));?>
" />  <input class="edit" name="new_image[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="file" title="Какой файл изображения требуется взять с Вашего компьютера (объем файла не более <?php echo sprintf('%d',(((($tmp = @@IMAGE_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp))/1024));?>
 Кбайт)" /><br><br>или из удаленного источника:<br><input class="edit" name="new_image_url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="http://" title="Какой файл изображения требуется взять с другого сайта в Интернете" /><br><br>дать файлу имя:<br><input class="edit" id="item_form_filename_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGEFILENAME)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой сделать начальную часть имени файла нового изображения на сайте (файл будет размещен в папке <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
)" /><br><br><input class="checkbox" id="item_form_imageview" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGEVIEW)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="checkbox" checked value="1" title="Будет ли это изображение использоваться в слайдере или вьювере изображений" /><span onclick="Toggle_PageCheckbox('item_form_imageview');" title="Будет ли это изображение использоваться в слайдере или вьювере изображений">&nbsp;использовать в слайдере</span><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></div><div class="newimage_options">заголовок (alt) изображения:<br><input class="edit" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGEALT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой заголовок (всплывающую подсказку) дать новому изображению" /><br>описание:<br><textarea name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGETEXT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" style="height: 105px;" title="Какое описание дать новому изображению"></textarea></div></div></td></tr></table></div><div id="information-part-product-meta"><h2 style="margin-bottom: 20px;">Мета информация</h2><table align="center" cellpadding="0" cellspacing="10" class="gray"><tr><td class="param">URL:</td><td class="param_short" width="1%">http://сайт/<span id="item_form_url_path"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url_special)===null||$tmp==='' ? false : $tmp)){?> style="display: none;"<?php }?>>products/</span></td><td class="value" colspan="2" width="100%" title="Окончание адреса страницы товара"><input class="edit" id="item_form_url_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short" title="Будет ли URL без products/ в начале"><input class="checkbox" id="item_form_url_special" name="url_special[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url_special)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" onchange="var object = document.getElementById('item_form_url_path'); if ((typeof(object) == 'object') && (object != null)) object.style.display = this.checked ? 'none' : '';" /><span onclick="Toggle_PageCheckbox('item_form_url_special');">&nbsp;Особый</span></td></tr><tr><td class="param_short">Канонический:</td><td class="value" colspan="3" width="100%" title="Канонический товар"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->canonical_model)===null||$tmp==='' ? '' : $tmp), null, 0);?><input class="edit" id="search-canonical-product" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" onkeypress="return ignoreCanonicalProductKeypress(event);" /><?php echo $_smarty_tpl->getSubTemplate ('../../../../design/common_parts/Autocomplete-search/main.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('input_id'=>'#search-canonical-product','width'=>700,'height'=>800,'product_maxcount'=>15,'product_show_metatitle'=>false,'product_show_image'=>true,'product_show_price'=>true,'product_show_id'=>true,'product_show_pcode'=>true,'product_show_sku'=>true,'product_by_model'=>true,'product_by_metatitle'=>false,'product_by_metakeywords'=>false,'product_by_body'=>false,'product_by_tags'=>true,'product_by_barcode'=>true,'product_by_pcode'=>true,'product_by_sku'=>true,'category_maxcount'=>0,'category_show_metatitle'=>false,'category_show_image'=>false,'category_by_name'=>true,'category_by_metatitle'=>false,'category_by_metakeywords'=>false,'category_by_body'=>false,'category_by_tags'=>false,'brand_maxcount'=>0,'brand_show_metatitle'=>false,'brand_show_image'=>false,'brand_by_name'=>true,'brand_by_metatitle'=>false,'brand_by_metakeywords'=>false,'brand_by_body'=>false,'brand_by_tags'=>false,'onselect'=>'onSelectCanonicalProduct','link_css'=>true,'link_engine'=>true), 0);?>
<script language="JavaScript" type="text/javascript">function onSelectCanonicalProduct ( input_object, suggested, data ) {jQuery(input_object).val(suggested);if (!data['type'] || data['type'] == 'product') {if (data['product_id'] && data['product_id'] != '') {jQuery('#item_form_canonical_id_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
').val(data['product_id']);}}}function ignoreCanonicalProductKeypress (event) {if ((typeof(event) == 'object') && (event != null)) {if (('shiftKey' in event) && ('ctrlKey' in event) && ('keyCode' in event)) {return event.keyCode != 13 && event.keyCode != 10;}}return true;}</script></td><td class="value" title="Идентификатор канонического товара"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->canonical_id)===null||$tmp==='' ? '' : $tmp), null, 0);?><input class="edit" id="item_form_canonical_id_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="canonical_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" /></td></tr><tr><td class="param_high" rowspan="3">Meta Keywords:</td><td class="value" colspan="3" rowspan="3" title="Какой текст разместить в мета теге &lt;meta name=keywords ...&gt; заголовка страницы"><textarea id="item_form_meta_keywords_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_keywords[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 64px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->meta_keywords)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td><td class="param_short" title="Запрещена ли демонстрация товара в RSS"><input class="checkbox" id="item_form_rss_disabled" name="rss_disabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->rss_disabled)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_rss_disabled');">&nbsp;Не для RSS</span></td></tr><tr><td class="param_short" title="Запрещена ли демонстрация товара в информерах на внешних сайтах"><input class="checkbox" id="item_form_export_disabled" name="export_disabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->export_disabled)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_export_disabled');">&nbsp;Не экспорт</span></td></tr><tr><td class="value" rowspan="2" title="В каких прайсах используется товар (несколько выбираются с помощью клавиш Shift и Ctrl)"><select multiple name="in_prices[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][]" size="5" style="font-size: 8pt; height: 128px; width: 92px;"><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['prices'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['name'] = 'prices';
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['loop'] = is_array($_loop=8) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['prices']['total']);
?><?php $_smarty_tpl->tpl_vars['c'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['prices']['index'], null, 0);?><option value="<?php echo $_smarty_tpl->tpl_vars['c']->value;?>
" <?php if ((($tmp = @($_smarty_tpl->tpl_vars['item']->value->in_prices[$_smarty_tpl->tpl_vars['c']->value]))===null||$tmp==='' ? false : $tmp)){?> selected<?php }?>>прайс <?php echo $_smarty_tpl->tpl_vars['c']->value+1;?>
</option><?php endfor; endif; ?></select></td></tr><tr><td class="param_high">Meta Description:</td><td class="value" colspan="3" title="Какой текст разместить в мета теге &lt;meta name=description ...&gt; заголовка страницы"><textarea id="item_form_meta_description_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 96px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->meta_description)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td></tr><tr><td class="param">Meta Title:</td><td class="value" colspan="2" width="100%" title="Какой текст разместить в теге &lt;title&gt; заголовка страницы"><input class="edit" id="item_form_meta_title_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_title[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->meta_title)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="value_box" width="1%" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table></div><div id="information-part-product-materials"><h2>Связанные публикации</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_high" rowspan="2">Связанные <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Articles" title="Перейти на страницу статей в админпанели">статьи</a> и <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
News" title="Перейти на страницу новостей в админпанели">новости</a>:</td><td class="value value_sheet" rowspan="2" width="33%" title="Какие статьи связаны с этим товаром (несколько выбираются с помощью клавиш Shift и Ctrl)"><input name="article_ids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="" /><select multiple name="article_ids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][]" size="9"><?php if (isset($_smarty_tpl->tpl_vars['all_articles']->value)&&is_array($_smarty_tpl->tpl_vars['all_articles']->value)&&!empty($_smarty_tpl->tpl_vars['all_articles']->value)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['all_articles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><option value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->article_id)===null||$tmp==='' ? 0 : $tmp);?>
" <?php if (isset($_smarty_tpl->tpl_vars['item']->value->article_ids)&&!empty($_smarty_tpl->tpl_vars['item']->value->article_ids)&&((!is_array($_smarty_tpl->tpl_vars['item']->value->article_ids)&&((($tmp = @$_smarty_tpl->tpl_vars['r']->value->article_id)===null||$tmp==='' ? 0 : $tmp)==$_smarty_tpl->tpl_vars['item']->value->article_ids))||(is_array($_smarty_tpl->tpl_vars['item']->value->article_ids)&&in_array((($tmp = @$_smarty_tpl->tpl_vars['r']->value->article_id)===null||$tmp==='' ? 0 : $tmp),$_smarty_tpl->tpl_vars['item']->value->article_ids)))){?> selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->header)===null||$tmp==='' ? 'Без названия!' : $tmp);?>
</option><?php } ?><?php }?></select></td><td class="value value_sheet" rowspan="2" width="33%" title="Какие новости связаны с этим товаром (несколько выбираются с помощью клавиш Shift и Ctrl)"><input name="news_ids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value=""><select multiple name="news_ids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][]" size="9"><?php if (isset($_smarty_tpl->tpl_vars['all_news']->value)&&is_array($_smarty_tpl->tpl_vars['all_news']->value)&&!empty($_smarty_tpl->tpl_vars['all_news']->value)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['all_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><option value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->news_id)===null||$tmp==='' ? 0 : $tmp);?>
" <?php if (isset($_smarty_tpl->tpl_vars['item']->value->news_ids)&&!empty($_smarty_tpl->tpl_vars['item']->value->news_ids)&&((!is_array($_smarty_tpl->tpl_vars['item']->value->news_ids)&&((($tmp = @$_smarty_tpl->tpl_vars['r']->value->news_id)===null||$tmp==='' ? 0 : $tmp)==$_smarty_tpl->tpl_vars['item']->value->news_ids))||(is_array($_smarty_tpl->tpl_vars['item']->value->news_ids)&&in_array((($tmp = @$_smarty_tpl->tpl_vars['r']->value->news_id)===null||$tmp==='' ? 0 : $tmp),$_smarty_tpl->tpl_vars['item']->value->news_ids)))){?> selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->header)===null||$tmp==='' ? 'Без названия!' : $tmp);?>
</option><?php } ?><?php }?></select></td><td class="param_short" rowspan="2" style="vertical-align: top;">Видео:</td><td class="value value_sheet" colspan="2" title="Список файлов через запятую или HTM-фрагмент"><textarea name="video[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 128px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->video)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td></tr><tr><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table></div><div id="information-part-product-description"><h2>Описание</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_high">Аннотация:</td><td class="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_wysiwyg_disabled)===null||$tmp==='' ? false : $tmp)){?>value value_sheet<?php }else{ ?>value_box<?php }?>"><textarea class="editor_small" id="item_form_description_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="width: 778px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->description)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td></tr></table><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_short" width="100%">&nbsp;</td><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table><table align="center" cellpadding="0" cellspacing="10" class="white"><!-- поле Полный текст --><tr><td class="param_high">Полный текст:</td><td class="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_wysiwyg_disabled)===null||$tmp==='' ? false : $tmp)){?>value value_sheet<?php }else{ ?>value_box<?php }?>"><textarea class="editor_big" name="body[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 400px; width: 778px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->body)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td></tr></table></div><div id="information-part-product-seo"><h2>Поисковое продвижение</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_high">SEO текст:</td><td class="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_wysiwyg_disabled)===null||$tmp==='' ? false : $tmp)){?>value value_sheet<?php }else{ ?>value_box<?php }?>"><textarea class="editor_small" name="seo_description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 150px; width: 778px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->seo_description)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td></tr></table><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param">Теги:</td><td class="value value_sheet" width="100%" title="Ассоциируемые с этой записью теги (перечисляются через запятую)"><input class="edit" name="tags[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->tags)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table></div><div id="information-part-product-marketing"><h2 style="margin-bottom: 20px;">Маркетинговые настройки</h2><table align="center" cellpadding="0" cellspacing="10" class="gray"><tr><td class="param"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Users" title="Перейти на страницу клиентов в админпанели">Поставщик</a>:</td><td class="value" width="100%" title="Кого считать поставщиком товара"><select name="user_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]"><option value="0"></option><?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/users.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>(($tmp = @$_smarty_tpl->tpl_vars['all_users']->value)===null||$tmp==='' ? false : $tmp),'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->user_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>
</select></td><td class="param_short">Рейтинг:</td><td class="value" title="Рейтинг товара"><input class="edit" name="rating[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="5" style="width: auto;" type="text" value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->votes)===null||$tmp==='' ? 0 : $tmp)!=0){?><?php echo smarty_modifier_replace(sprintf('%1.2f',(((($tmp = @$_smarty_tpl->tpl_vars['item']->value->rating)===null||$tmp==='' ? 0 : $tmp))/$_smarty_tpl->tpl_vars['item']->value->votes)),',','.');?>
<?php }else{ ?><?php echo smarty_modifier_replace(sprintf('%1.2f',((($tmp = @$_smarty_tpl->tpl_vars['item']->value->rating)===null||$tmp==='' ? 0 : $tmp))),',','.');?>
<?php }?>" /></td><td class="param_short" colspan="2" title="Признак товара 'Скоро в продаже'"><input class="checkbox" id="item_form_awaited" name="awaited[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->awaited)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_awaited');">&nbsp;Ожидаемый</span></td><td class="param_short">Когда:</td><td class="value" title="Ожидаемая дата поступления товара (формат ГГГГ-ММ-ДД)"><input class="edit" name="coming[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php if (smarty_modifier_truncate((($tmp = @$_smarty_tpl->tpl_vars['item']->value->coming)===null||$tmp==='' ? '0000-00-00' : $tmp),10,'',true)!='0000-00-00'){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value->coming,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }?>" onfocus="xcDateFormat = 'yyyy-mm-dd'; var set_to = this; var get_from = this; var default_date = ''; var anchor_object_id = ''; var x_offset = 5; var y_offset = 5; var auto_hide = 1; showCalendar('', set_to, get_from, default_date, anchor_object_id, x_offset, y_offset, auto_hide);" /></td><td class="param_short" title="Будет ли товар скрыт от незарегистрированных пользователей"><input class="checkbox" id="item_form_hidden" name="hidden[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->hidden)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_hidden');">&nbsp;Скрыт</span></td><td class="param_short" title="Будет ли товар выделен визуально в списках"><input class="checkbox" id="item_form_highlighted" name="highlighted[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->highlighted)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_highlighted');">&nbsp;Выделен</span></td></tr><tr><td class="param"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Menus" title="Перейти на страницу меню в админпанели">Меню</a>:</td><td class="value" width="100%" title="В какое меню входит товар"><select name="menu_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]"><option value="0"></option><?php if (isset($_smarty_tpl->tpl_vars['menus']->value)&&is_array($_smarty_tpl->tpl_vars['menus']->value)&&!empty($_smarty_tpl->tpl_vars['menus']->value)){?><?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?><option value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->menu_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->menu_id)===null||$tmp==='' ? '' : $tmp)==(($tmp = @$_smarty_tpl->tpl_vars['c']->value->menu_id)===null||$tmp==='' ? 0 : $tmp)){?> selected<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['c']->value->name)===null||$tmp==='' ? 'Без названия!' : $tmp);?>
</option><?php } ?><?php }?></select></td><td class="param_short">Голосов:</td><td class="value" title="Количество голосов, участвовавших в рейтинге товара"><input class="edit" name="votes[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="5" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->votes)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short" colspan="2" title="Признак товара 'Акционный'"><input class="checkbox" id="item_form_actional" name="actional[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->actional)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_actional');">&nbsp;Акционный</span></td><td class="param_short">Вес:</td><td class="value" title="Число определяет положение товара выше других с меньшим весом в той же категории"><input class="edit" name="order_num[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->order_num)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short" title="Разрешено ли пользователям сайта оставлять отзывы о товаре"><input class="checkbox" id="item_form_commented" name="commented[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->commented)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_commented');">&nbsp;Обсуждают</span></td><td class="param_short" title="Признак товара не для продажи"><input class="checkbox" id="item_form_nonusable" name="non_usable[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->non_usable)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_nonusable');">&nbsp;Не продаем</span></td></tr><tr><td class="param">Раздел:</td><td class="value" width="100%" title="К какому разделу сайта принадлежит товар"><select name="section_field[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]"><option value="1">Основной</option></select></td><td class="param_short" colspan="2" title="Разрешен ли экспорт товара в Яндекс.Маркет"><?php $_smarty_tpl->tpl_vars['mask'] = new Smarty_variable(1, null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->ymarket)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['param']->value&$_smarty_tpl->tpl_vars['mask']->value, null, 0);?><input class="checkbox" id="item_form_ymarket" name="ymarket[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][1]" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['value']->value){?> checked<?php }?> value="1" /> <span onclick="Toggle_PageCheckbox('item_form_ymarket');">Яндекс.Маркет</span><div class="prices_edit_list"><div class="prices_edit_list_title">и другие торговые площадки:<a href="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
yandex.xml" target="_blank" title="Открыть канал в отдельном окне браузера">канал 1</a></div><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['items'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['items']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['name'] = 'items';
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = (int)2;
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] = is_array($_loop=33) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total']);
?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['items']['index'], null, 0);?><?php $_smarty_tpl->tpl_vars['mask'] = new Smarty_variable($_smarty_tpl->tpl_vars['mask']->value*2, null, 0);?><div class="flaglist-item"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['param']->value&$_smarty_tpl->tpl_vars['mask']->value, null, 0);?><input class="checkbox" id="item_form_ymarket_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" name="ymarket[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['value']->value){?> checked<?php }?> value="1" /> <span onclick="Toggle_PageCheckbox('item_form_ymarket_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
');">канал <a href="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
yandex<?php echo $_smarty_tpl->tpl_vars['i']->value>1 ? (('_').($_smarty_tpl->tpl_vars['i']->value)) : '';?>
.xml" target="_blank" title="Открыть канал в отдельном окне браузера" onclick="event.cancelBubble = true; return true;"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a></span></div><?php endfor; endif; ?><br style="clear: both;" /><a class="inline" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" onclick="jQuery(this).closest('.param_short').find('input.checkbox').each(function () { this.checked = false; }); return false;">снять все</a><a class="inline" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" onclick="jQuery(this).closest('.param_short').find('input.checkbox').each(function () { this.checked = true; }); return false;">установить все</a></div></td><td class="param_short" colspan="2" title="Признак товара 'Новинка'"><input class="checkbox" id="item_form_newest" name="newest[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->newest)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_newest');">&nbsp;Новинка</span></td><td class="param_short">Просмотры:</td><td class="value" title="Счетчик визитов на страницу товара"><input class="edit" name="browsed[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->browsed)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short" title="Разрешен ли товар к показу на сайте"><input class="checkbox" id="item_form_enabled" name="enabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->enabled)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_enabled');">&nbsp;Разрешен</span></td><td class="param_short" title="Запрещена ли продажа в кредит"><input class="checkbox" id="item_form_noncreditable" name="non_creditable[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->non_creditable)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_noncreditable');">&nbsp;Не в <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
CreditPrograms" title="Перейти на страницу кредитных программ в админпанели" onclick="event.cancelBubble = true;">кредит</a></span></td></tr><tr><td class="param">Связан. <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Products" title="Перейти на страницу товаров в админпанели">товары</a>:</td><td class="value" width="100%" title="Список артикулов рекомендуемых товаров через запятую"><input class="edit" name="related[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->related_products)&&is_array($_smarty_tpl->tpl_vars['item']->value->related_products)&&!empty($_smarty_tpl->tpl_vars['item']->value->related_products)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->related_products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
 $_smarty_tpl->tpl_vars['r']->last = $_smarty_tpl->tpl_vars['r']->iteration === $_smarty_tpl->tpl_vars['r']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['related']['last'] = $_smarty_tpl->tpl_vars['r']->last;
?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->related_sku)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['related']['last']){?>, <?php }?><?php } ?><?php }?>" /></td><td class="param_short" colspan="2" title="Разрешен ли экспорт товара в ВКонтакте"><input class="checkbox" id="item_form_vkontakte" name="vkontakte[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->vkontakte)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_vkontakte');">&nbsp;ВКонтакте</span></td><td class="param_short" colspan="2" title="Признак товара 'Хит продаж'"><input class="checkbox" id="item_form_hit" name="hit[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->hit)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_hit');">&nbsp;Хит продаж</span></td><td class="param_short"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Modules" title="Перейти на страницу модулей в админпанели">Плагины</a>:</td><td class="value" title="Какие динамические плагины подключить на страницу товара (список классов модулей через запятую)"><input class="edit" name="objects[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->objects)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short">Гарантия:</td><td class="value" title="Срок гарантии на товар"><input class="edit" name="guarantee[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->guarantee)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td></tr><tr><td class="param">Похожие <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Brands" title="Перейти на страницу брендов в админпанели">бренды</a>:</td><td class="value" colspan="4" width="50%" title="Список идентификаторов похожих брендов через запятую"><input class="edit" name="related_bids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->related_bids)){?><?php if (is_array($_smarty_tpl->tpl_vars['item']->value->related_bids)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->related_bids; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
 $_smarty_tpl->tpl_vars['r']->last = $_smarty_tpl->tpl_vars['r']->iteration === $_smarty_tpl->tpl_vars['r']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['last'] = $_smarty_tpl->tpl_vars['r']->last;
?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['items']['last']){?>, <?php }?><?php } ?><?php }else{ ?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->related_bids)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }?>" /></td><td class="param_short" colspan="2">Похожие <a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Categories" title="Перейти на страницу категорий в админпанели">категории</a>:</td><td class="value" colspan="3" width="50%" title="Список идентификаторов похожих категорий через запятую"><input class="edit" name="related_cids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->related_cids)){?><?php if (is_array($_smarty_tpl->tpl_vars['item']->value->related_cids)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->related_cids; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
 $_smarty_tpl->tpl_vars['r']->last = $_smarty_tpl->tpl_vars['r']->iteration === $_smarty_tpl->tpl_vars['r']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['last'] = $_smarty_tpl->tpl_vars['r']->last;
?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['items']['last']){?>, <?php }?><?php } ?><?php }else{ ?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->related_cids)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }?>" /></td></tr><tr><td class="param">Аксессуары:</td><td class="value" colspan="4" width="100%" title="Список идентификаторов товаров (аксессуаров) через запятую"><input class="edit" name="accessory_pids[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->accessory_products)&&is_array($_smarty_tpl->tpl_vars['item']->value->accessory_products)&&!empty($_smarty_tpl->tpl_vars['item']->value->accessory_products)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->accessory_products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['r']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['r']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['r']->iteration++;
 $_smarty_tpl->tpl_vars['r']->last = $_smarty_tpl->tpl_vars['r']->iteration === $_smarty_tpl->tpl_vars['r']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['accessory']['last'] = $_smarty_tpl->tpl_vars['r']->last;
?><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->product_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['accessory']['last']){?>, <?php }?><?php } ?><?php }?>" /></td><td class="param_short"><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Templates" title="Перейти на страницу файлов шаблона в админпанели">Шаблоном</a>:</td><td class="value" colspan="2" width="50%" title="Каким шаблоном отображать страницу товара (по умолчанию product.tpl)"><input class="edit" name="template[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['item']->value->template)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr></table></div><div id="information-part-product-subdomain"><h2>Собственный домен</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param">Субдомен:</td><td class="value value_sheet" width="100%" title="Левая часть субдомена товара (точка и домен сайта добавятся справа неявно)"><input class="edit" name="subdomain[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->subdomain)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></td><td class="param_short" title="Разрешен ли собственный домен у товара"><input class="checkbox" id="item_form_subdomain_enabled" name="subdomain_enabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->subdomain_enabled)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" /><span onclick="Toggle_PageCheckbox('item_form_subdomain_enabled');">&nbsp; Разрешен</span></td><td class="value_box" title="Сохранить изменения и остаться на этой же странице"><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></td><td class="value_box" title="Сохранить изменения и перейти в список"><input class="submit" type="submit" value="Сохранить" /></td></tr><tr><td class="param_high">Контент субдомена:</td><td class="value value_sheet" colspan="4" title="Полный html-код страницы субдомена товара (появится вместо стандартной страницы сайта)"><textarea name="subdomain_html[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 96px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->subdomain_html)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></td></tr></table></div><div id="information-part-product-files"><h2>Сопутствующие файлы</h2><table align="center" cellpadding="0" cellspacing="10" class="white"><tr><td class="param_high">Файлы:<?php if (!empty($_smarty_tpl->tpl_vars['id']->value)&&isset($_smarty_tpl->tpl_vars['item']->value->files)&&is_array($_smarty_tpl->tpl_vars['item']->value->files)&&!empty($_smarty_tpl->tpl_vars['item']->value->files)){?><br><br><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Product&<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILENUMBER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=*&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ITEMID)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_VALUE_DELETEFILE)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" onclick="if (confirm('Это действие удалит все файлы товара. Вы подтверждаете такую операцию?')) Delete_PageRecordFile('item_form', '*'); return false;" title="Удалить загруженные в товар файлы">удалить все</a><?php }?></td><td class="value_box"><?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?><?php if (isset($_smarty_tpl->tpl_vars['item']->value->files)&&is_array($_smarty_tpl->tpl_vars['item']->value->files)&&!empty($_smarty_tpl->tpl_vars['item']->value->files)){?><?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->files; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['files']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['files']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value){
$_smarty_tpl->tpl_vars['file']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['files']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['files']['index']++;
?><div class="file"><span><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['files']['iteration'];?>
.</span><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Product&<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILENUMBER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['files']['iteration'];?>
&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_TOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ITEMID)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_VALUE_DELETEFILE)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" onclick="if (confirm('Это действие удалит указанный файл товара. Вы подтверждаете такую операцию?')) Delete_PageRecordFile('item_form', <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['files']['iteration'];?>
); return false;">удалить</a><br><br><a class="file" href="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['file']->value, ENT_QUOTES, 'UTF-8');?>
" target="_blank" <?php if (isset($_smarty_tpl->tpl_vars['item']->value->files_alts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['files']['index']])){?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->files_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['files']['index']], ENT_QUOTES, 'UTF-8');?>
"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp);?>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp);?>
<?php echo (($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp);?>
<?php echo $_smarty_tpl->tpl_vars['file']->value;?>
</a><div><input name="file[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['files']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['file']->value, ENT_QUOTES, 'UTF-8');?>
" />заголовок (alt):<br><input name="filealt[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['files']['iteration'];?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->files_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['files']['index']])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Заголовок (всплывающая подсказка) этого файла" /><br>описание:<br><textarea name="filetext[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['files']['iteration'];?>
]" title="Описание этого файла"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->files_texts[$_smarty_tpl->getVariable('smarty')->value['foreach']['files']['index']])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></div></div><?php } ?><?php }?><div style="clear: both;"><div class="newfile">новый файл (объемом не более <?php echo sprintf('%d',(((($tmp = @@FILE_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp))/1024/1024));?>
 Мбайт):<br><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo sprintf('%d',(($tmp = @@FILE_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp));?>
" />  <input class="edit" name="new_file[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="file" title="Какой файл требуется взять с Вашего компьютера (объем файла не более <?php echo sprintf('%d',(((($tmp = @@FILE_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp))/1024/1024));?>
 Мбайт)" /><br><br>или из удаленного источника:<br><input class="edit" name="new_file_url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="http://" title="Какой файл требуется взять с другого сайта в Интернете" /><br><br>дать файлу имя:<br><input class="edit" id="item_form_filename_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILEFILENAME)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой сделать начальную часть имени нового файла на сайте (файл будет размещен в папке <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_files_folder_prefix)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @@ADMIN_PRODUCTS_CLASS_UPLOAD_FOLDER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
)" /><br><br><input class="submit" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST_AS_ACCEPT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить" /></div><div class="newfile_options">заголовок (alt) файла:<br><input class="edit" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILEALT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой заголовок (всплывающую подсказку) дать новому файлу" /><br>описание:<br><textarea name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILETEXT)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" style="height: 105px;" title="Какое описание дать новому файлу"></textarea></div></div><?php }else{ ?><div class="hint">Управление файлами станет доступным, когда этот товар будет создан.</div><?php }?></td></tr></table></div><?php if ((($tmp = @$_smarty_tpl->tpl_vars['from_page']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FROM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['from_page']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_POST)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="" /><input name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ITEMID)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" /><input id="item_form_<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="" /><input name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_IMAGETOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo smarty_function_math(array('equation'=>'rand(1, 100000000)'),$_smarty_tpl);?>
" /><input id="item_form_<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILENUMBER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILENUMBER)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="" /><input name="<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_NAME_FILETOKEN)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo smarty_function_math(array('equation'=>'rand(1, 100000000)'),$_smarty_tpl);?>
" /><input id="item_form_<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="" /><input name="token" type="hidden" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['token'][0][0]->token(array(),$_smarty_tpl);?>
" /></form><div class="help"><div class="title">Справка</div><div><b>Не продаем</b>. Этот флажок служит для указания товара, который присутствует на сайте лишь в ознакомительных целях (например, снят с производства). Такие товары, независимо от способа сортировки, применяемого в текущий момент на любой стороне сайта, всегда сдвигаются в конец списка, а в админпанели на странице списка товаров еще и помечаются серым цветом. Кроме того, добавление таких товаров в корзину игнорируется, даже если в клиентском шаблоне по какой-то причине верстальщик не заблокировал кнопку "В корзину" для таких товаров.</div><div><b>Валюта</b>. По умолчанию цена товара обрабатывается в связи с базовой валютой сайта. Можно указать, что именно в этом товаре цена будет связана с какой-то другой валютой.</div><div><b>Шаблон</b>. По умолчанию для отрисовки страницы товара на клиентской стороне сайта используется файл <i>product.tpl</i> из текущего шаблона. Но движком поддерживается возможность для конкретного товара указать иной htm- или tpl-файл, с помощью которого будет отрисована его страница. При отсутствии такого файла в шаблоне будет использован файл по умолчанию.</div><div><b>Яндекс.Маркет</b>. Эта связка из 32 флажков служит для указания, в каких из файлов <i>http://сайт/yandex.xml</i>, <i>http://сайт/yandex_2.xml</i>, ..., <i>http://сайт/yandex_32.xml</i> товар должен быть представлен. Каждый из таких файлов считается отдельным каналом экспорта, причем все каналы отдают информацию только в формате Яндекс.Маркета.<br><br>Кроме того, движком поддерживается слияние каналов. Например, нужно получить экспорт того, что представлено в каналах 1, 5 и 8. Тогда обращаясь к файлу <i>http://сайт/yandex_1_5_8.xml</i> получим желаемое.</div></div></div><?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/tinymce.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('disabled_state'=>(($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_wysiwyg_disabled)===null||$tmp==='' ? false : $tmp)), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/meta.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('form_id'=>'item_form','item_id'=>$_smarty_tpl->tpl_vars['id']->value,'autofill'=>(($tmp = @$_smarty_tpl->tpl_vars['settings']->value->products_meta_autofill)===null||$tmp==='' ? false : $tmp)), 0);?>
<?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?><script language="JavaScript" type="text/javascript">jQuery(document).ready(function () {if (typeof(suggested_articul_automated) != 'undefined' && suggested_articul_automated) {alert('Обратите внимание, что в вариантах данного товара существовали варианты с неуказанным артикулом. Они были заполнены автоматически артикульной меткой ' + suggested_articul_prefix + suggested_articul_number + ', но данные изменения еще не сохранены.');}});</script><?php }?><?php }} ?>