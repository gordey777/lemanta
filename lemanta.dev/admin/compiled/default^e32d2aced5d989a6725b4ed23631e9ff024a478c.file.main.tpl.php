<?php /* Smarty version Smarty-3.1.8, created on 2016-09-14 14:18:14
         compiled from "/var/www/lemanta/data/www/lemanta.com/design/common_parts/Autocomplete-search/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:161692158357d931f6dfe4a9-22385476%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e32d2aced5d989a6725b4ed23631e9ff024a478c' => 
    array (
      0 => '/var/www/lemanta/data/www/lemanta.com/design/common_parts/Autocomplete-search/main.tpl',
      1 => 1473158158,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161692158357d931f6dfe4a9-22385476',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'input_id' => 0,
    'site' => 0,
    'link_css' => 0,
    'autocomplete_search_common' => 0,
    'link_engine' => 0,
    'onselect' => 0,
    'width' => 0,
    'height' => 0,
    'product_maxcount' => 0,
    'product_show_metatitle' => 0,
    'product_by_model' => 0,
    'product_by_metatitle' => 0,
    'product_by_metakeywords' => 0,
    'product_by_body' => 0,
    'product_by_tags' => 0,
    'product_by_barcode' => 0,
    'product_by_pcode' => 0,
    'product_by_sku' => 0,
    'category_maxcount' => 0,
    'category_show_metatitle' => 0,
    'category_by_name' => 0,
    'category_by_metatitle' => 0,
    'category_by_metakeywords' => 0,
    'category_by_body' => 0,
    'category_by_tags' => 0,
    'brand_maxcount' => 0,
    'brand_show_metatitle' => 0,
    'brand_by_name' => 0,
    'brand_by_metatitle' => 0,
    'brand_by_metakeywords' => 0,
    'brand_by_body' => 0,
    'brand_by_tags' => 0,
    'category_show_image' => 0,
    'brand_show_image' => 0,
    'product_show_image' => 0,
    'product_show_price' => 0,
    'product_show_pcode' => 0,
    'product_show_sku' => 0,
    'product_show_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d931f6f261b6_07302183',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d931f6f261b6_07302183')) {function content_57d931f6f261b6_07302183($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?><?php if (isset($_smarty_tpl->tpl_vars['input_id']->value)&&is_string($_smarty_tpl->tpl_vars['input_id']->value)){?><?php $_smarty_tpl->tpl_vars['input_id'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['input_id']->value,'/\s/',''), null, 0);?><?php if ($_smarty_tpl->tpl_vars['input_id']->value!=''){?><?php $_smarty_tpl->tpl_vars['autocomplete_search_common'] = new Smarty_variable(htmlspecialchars(((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).('design/common/Autocomplete-search/')), ENT_QUOTES, 'UTF-8'), null, 0);?><?php if (!isset($_smarty_tpl->tpl_vars['link_css']->value)||$_smarty_tpl->tpl_vars['link_css']->value){?><link href="<?php echo $_smarty_tpl->tpl_vars['autocomplete_search_common']->value;?>
style.css" rel="stylesheet" type="text/css" /><?php }?><?php if (!isset($_smarty_tpl->tpl_vars['link_engine']->value)||$_smarty_tpl->tpl_vars['link_engine']->value){?><script src="<?php echo $_smarty_tpl->tpl_vars['autocomplete_search_common']->value;?>
jquery.autocomplete-min.js" language="JavaScript" type="text/javascript"></script><?php }?><script language="JavaScript" type="text/javascript"><?php $_smarty_tpl->tpl_vars['onselect'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['onselect']->value)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['onselect'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['onselect']->value,'/[^a-z0-9_]/i',''), null, 0);?><?php $_smarty_tpl->tpl_vars['onselect'] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['onselect']->value,'/^[^a-z]+/i',''), null, 0);?>jQuery(window).load(function () {jQuery('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_id']->value, ENT_QUOTES, 'UTF-8');?>
').autocomplete({ serviceUrl: '<?php echo $_smarty_tpl->tpl_vars['autocomplete_search_common']->value;?>
search.php',minChars: 2,delimiter: '',deferRequestBy: 50,highlight: true,autoSubmit: false,noCache: false,<?php if ((($tmp = @$_smarty_tpl->tpl_vars['width']->value)===null||$tmp==='' ? 0 : $tmp)>0){?>width: <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['width']->value);?>
,<?php }?>maxHeight: <?php if ((($tmp = @$_smarty_tpl->tpl_vars['height']->value)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo sprintf('%d',$_smarty_tpl->tpl_vars['height']->value);?>
<?php }else{ ?>350<?php }?>,params: { product_maxcount:        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_maxcount']->value)===null||$tmp==='' ? 8 : $tmp)>0){?> <?php echo sprintf('%d',(($tmp = @$_smarty_tpl->tpl_vars['product_maxcount']->value)===null||$tmp==='' ? 8 : $tmp));?>
 <?php }else{ ?> 0 <?php }?>,product_show_metatitle:  <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_show_metatitle']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_model:        <?php if (isset($_smarty_tpl->tpl_vars['product_by_model']->value)&&$_smarty_tpl->tpl_vars['product_by_model']->value){?> true <?php }else{ ?> false <?php }?>,product_by_metatitle:    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_metatitle']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_metakeywords: <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_metakeywords']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_body:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_body']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_tags:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_tags']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_barcode:      <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_barcode']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_pcode:        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_pcode']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,product_by_sku:          <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_by_sku']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,category_maxcount:        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_maxcount']->value)===null||$tmp==='' ? 0 : $tmp)>0){?> <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['category_maxcount']->value);?>
 <?php }else{ ?> 0 <?php }?>,category_show_metatitle:  <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_show_metatitle']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,category_by_name:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_by_name']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,category_by_metatitle:    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_by_metatitle']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,category_by_metakeywords: <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_by_metakeywords']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,category_by_body:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_by_body']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,category_by_tags:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_by_tags']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,brand_maxcount:        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_maxcount']->value)===null||$tmp==='' ? 0 : $tmp)>0){?> <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['brand_maxcount']->value);?>
 <?php }else{ ?> 0 <?php }?>,brand_show_metatitle:  <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_show_metatitle']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,brand_by_name:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_by_name']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,brand_by_metatitle:    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_by_metatitle']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,brand_by_metakeywords: <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_by_metakeywords']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,brand_by_body:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_by_body']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>,brand_by_tags:         <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_by_tags']->value)===null||$tmp==='' ? false : $tmp)===true){?> true <?php }else{ ?> false <?php }?>},onSelect: function (suggested, data) {if (data['url'] && (data['url'] != '')) {<?php if ($_smarty_tpl->tpl_vars['onselect']->value==''){?>document.location = data['url'];<?php }else{ ?>try {var object = jQuery('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_id']->value, ENT_QUOTES, 'UTF-8');?>
');if ((typeof(object) == 'object') && (object != null)&& ('length' in object) && (object.length > 0)) object = object[0];<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['onselect']->value, ENT_QUOTES, 'UTF-8');?>
(object, suggested, data);} catch (e) { }<?php }?>} else {<?php if ($_smarty_tpl->tpl_vars['onselect']->value==''){?>jQuery('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_id']->value, ENT_QUOTES, 'UTF-8');?>
').closest('form').submit();<?php }?>}},fnFormatResult: function (suggested, data, query) {var pattern = '';query = query.replace(new RegExp('[^a-z0-9а-яё]+', 'gi'), ' ');query = query.replace(new RegExp('^\\s*(.*?)\\s*$', 'gi'), '$1');query = query.split(' ');var reEscape = new RegExp('(\\' + ['/','.','*','+','?','|','(',')','[',']', '{',
                                                                                                                                           '}', '\\'].join('|\\') + ')', 'g');for (var i = 0; i < query.length; i++) {pattern = '(' + query[i].replace(reEscape, '\\$1') + ')';pattern = new RegExp(pattern, 'gi');suggested = suggested.replace(pattern, '<*>$1<\/*>');if (data['pcode'] && (data['pcode'] != '')) data['pcode'] = data['pcode'].replace(pattern, '<*>$1<\/*>');if (data['sku'] && (data['sku'] != '')) data['sku'] = data['sku'].replace(pattern, '<*>$1<\/*>');}pattern = new RegExp('<(/?)\\*>', 'g');suggested = suggested.replace(pattern, '<$1strong>');if (data['pcode'] && (data['pcode'] != '')) data['pcode'] = data['pcode'].replace(pattern, '<$1strong>');if (data['sku'] && (data['sku'] != '')) data['sku'] = data['sku'].replace(pattern, '<$1strong>');if (data['type'] && (data['type'] == 'category')) {suggested = '<span class="remark">' +'категория: &nbsp;' +'</span>' +suggested;}if (data['type'] && (data['type'] == 'brand')) {suggested = '<span class="remark">' +'бренд: &nbsp;' +'</span>' +suggested;}if (data['type'] && (data['type'] == 'category') && (1 == <?php if ((($tmp = @$_smarty_tpl->tpl_vars['category_show_image']->value)===null||$tmp==='' ? false : $tmp)===true){?> 1 <?php }else{ ?> 0 <?php }?>)|| data['type'] && (data['type'] == 'brand') && (1 == <?php if ((($tmp = @$_smarty_tpl->tpl_vars['brand_show_image']->value)===null||$tmp==='' ? false : $tmp)===true){?> 1 <?php }else{ ?> 0 <?php }?>)|| (!data['type'] || (data['type'] == 'product')) && (1 == <?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_show_image']->value)===null||$tmp==='' ? false : $tmp)===true){?> 1 <?php }else{ ?> 0 <?php }?>)) {if (data['image'] && (data['image'] != '')) {suggested = '<img src="' + data['image'] + '" />' +suggested;}}<?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_show_price']->value)===null||$tmp==='' ? false : $tmp)===true){?>if (data['price'] && (data['price'] != '')) {suggested = '<span class="price">' +data['price'] +'</span>' +suggested;}<?php }?>suggested += '<br>';<?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_show_pcode']->value)===null||$tmp==='' ? false : $tmp)===true){?>if (data['pcode'] && (data['pcode'] != '')) {suggested += '<span class="pcode">' +'код: ' + data['pcode'] +'</span>';}<?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_show_sku']->value)===null||$tmp==='' ? false : $tmp)===true){?>if (data['sku'] && (data['sku'] != '')) {suggested += '<span class="sku">' +'артикул: ' + data['sku'] +'</span>';}<?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['product_show_id']->value)===null||$tmp==='' ? false : $tmp)===true){?>if (data['product_id'] && (data['product_id'] != '')) {suggested += '<span class="product_id">' +'идентификатор: ' + data['product_id'] +'</span>';}<?php }?>if (data['url'] && (data['url'] != '')) {suggested = '<a href="' + data['url'] + '" onclick="<?php if ($_smarty_tpl->tpl_vars['onselect']->value==''){?>event.cancelBubble = true;<?php }else{ ?>return false;<?php }?>">' +suggested +'</a>';}return suggested;}});});</script><?php }?><?php }?><?php }} ?>