<?php /* Smarty version Smarty-3.1.8, created on 2016-11-11 19:12:07
         compiled from "design/lemanta/html\products.htm" */ ?>
<?php /*%%SmartyHeaderCode:42605819dfd45e7bc8-97183043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cb598216ccb17db3da78cced6bf0b58d846dfa5' => 
    array (
      0 => 'design/lemanta/html\\products.htm',
      1 => 1478880727,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42605819dfd45e7bc8-97183043',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819dfd472af40_65094191',
  'variables' => 
  array (
    'seoH1' => 0,
    'name' => 0,
    'category' => 0,
    'mod' => 0,
    'emulator' => 0,
    'items' => 0,
    'item' => 0,
    'number' => 0,
    'price' => 0,
    'CurrentPage' => 0,
    'seoPagenum' => 0,
    'products' => 0,
    'sort_modes' => 0,
    'sort_method' => 0,
    'mode' => 0,
    'my_modes' => 0,
    'value' => 0,
    'selected' => 0,
    'sort_descending' => 0,
    'dir' => 0,
    'PagesNavigation' => 0,
    'sorter' => 0,
    'Pages' => 0,
    'uri' => 0,
    'categories' => 0,
    'branch' => 0,
    'brand' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dfd472af40_65094191')) {function content_5819dfd472af40_65094191($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'name', null); ob_start(); ?><?php if (!empty($_smarty_tpl->tpl_vars['seoH1']->value)){?><?php echo $_smarty_tpl->tpl_vars['seoH1']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'category','def'=>''),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'brand','def'=>''),$_smarty_tpl);?>
<?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable(trim($_smarty_tpl->tpl_vars['name']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['name']->value=='Костюмы тройки'){?><?php if (!empty($_smarty_tpl->tpl_vars['category']->value->url)){?><?php if ($_smarty_tpl->tpl_vars['category']->value->url=='detskaya-odezhda/dlya-malchikov/kostyumy'||$_smarty_tpl->tpl_vars['category']->value->url=='detskaya-odezhda/dlya-devochek/kostyumy'){?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable('Костюмы', null, 0);?><?php }?><?php }?><?php }?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><article class="content right col-md-9 col-md-push-3"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountProducts'][0][0]->discountProducts(array('count'=>20,'assign'=>'items'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><div class="title2">Горящие предложения</div><div class="popular0"><div class="popular"><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li><div class="popular-bl"><div class="popular-image"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['image'][0][0]->image(array('folder'=>'files/products'),$_smarty_tpl);?>
" alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
"/></a></div><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->variants)){?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('num'=>$_smarty_tpl->tpl_vars['number']->value,'signed'=>false,'assign'=>'price'),$_smarty_tpl);?>
<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" class="popular-price"><?php echo intval($_smarty_tpl->tpl_vars['price']->value);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['sign'][0][0]->sign(array(),$_smarty_tpl);?>
</a><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php } ?><?php }?><div class="lenta"><p>Топ продаж</p></div></div></li><?php } ?></ul></div><div class="clr"></div><a href="#" class="prev prev-navigation"></a><a href="#" class="next next-navigation"></a></div><div class="clr"></div><?php }?><?php $_smarty_tpl->tpl_vars['seoPagenum'] = new Smarty_variable('', null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php $_smarty_tpl->tpl_vars['seoPagenum'] = new Smarty_variable($_smarty_tpl->tpl_vars['CurrentPage']->value+1, null, 0);?><?php $_smarty_tpl->tpl_vars['seoPagenum'] = new Smarty_variable(" - Страница ".($_smarty_tpl->tpl_vars['seoPagenum']->value), null, 0);?><?php }?><h1 ><?php echo (($tmp = @trim($_smarty_tpl->tpl_vars['name']->value))===null||$tmp==='' ? 'Каталог' : $tmp);?>
<?php echo $_smarty_tpl->tpl_vars['seoPagenum']->value;?>
</h1><?php if (!empty($_smarty_tpl->tpl_vars['products']->value)){?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'sorter', null); ob_start(); ?><?php if (count($_smarty_tpl->tpl_vars['products']->value)>1){?><div class="filters"><?php if (!empty($_smarty_tpl->tpl_vars['sort_modes']->value)){?><div class="col-md-12"><?php $_smarty_tpl->tpl_vars['my_modes'] = new Smarty_variable(array(0,1,6), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['sort_method']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?><form class="filter-l" method="post"><span>Сортировать по:</span> <select class="niceSelect" name="sort_method" onchange="this.parentNode.submit(); return true;"><?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['name']->_loop = false;
 $_smarty_tpl->tpl_vars['mode'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sort_modes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
$_smarty_tpl->tpl_vars['name']->_loop = true;
 $_smarty_tpl->tpl_vars['mode']->value = $_smarty_tpl->tpl_vars['name']->key;
?><?php if (in_array($_smarty_tpl->tpl_vars['mode']->value,$_smarty_tpl->tpl_vars['my_modes']->value)){?><?php $_smarty_tpl->tpl_vars['selected'] = new Smarty_variable($_smarty_tpl->tpl_vars['mode']->value==$_smarty_tpl->tpl_vars['value']->value ? 'selected' : '', null, 0);?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mode']->value, ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</option><?php }?><?php } ?></select> <?php if ($_smarty_tpl->tpl_vars['value']->value!=0){?><?php $_smarty_tpl->tpl_vars['dir'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['sort_descending']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?><a <?php echo $_smarty_tpl->tpl_vars['dir']->value ? '' : "class=\"active\"";?>
 onclick="this.nextSibling.value = 0; this.parentNode.submit();" title="По убыванию">↓</a><input name="sort_descending" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['dir']->value, ENT_QUOTES, 'UTF-8');?>
" /><a <?php echo $_smarty_tpl->tpl_vars['dir']->value ? "class=\"active\"" : '';?>
 onclick="this.previousSibling.value = 1; this.parentNode.submit();" title="По возрастанию">↑</a><?php }?></form></div><?php }?><div class="col-md-12"><?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>
</div><div class="clr"></div></div><?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php echo $_smarty_tpl->tpl_vars['sorter']->value;?>
<div class="product-list col-md-12"><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><div class="col-md-3 col-sm-3 col-xs-6"><?php echo $_smarty_tpl->getSubTemplate ('common/product-card.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php } ?><div class="clr"></div><div class="clr"></div></div><!-- .product-list --><?php echo $_smarty_tpl->tpl_vars['sorter']->value;?>
<?php }else{ ?><?php if (!empty($_smarty_tpl->tpl_vars['Pages']->value)){?><?php $_smarty_tpl->tpl_vars['newPage'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['Pages']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(array_pop($_smarty_tpl->tpl_vars['Pages']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!/page[_\-][0-9]+!i',"/page-".($_smarty_tpl->tpl_vars['newPage']->value),$_smarty_tpl->tpl_vars['uri']->value), null, 0);?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'uri', null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['uri']->value, ENT_QUOTES, 'UTF-8');?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php }?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['header302'][0][0]->header302(array('url'=>$_smarty_tpl->tpl_vars['uri']->value),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['category']->value->category_id)){?><?php if (!isset($_smarty_tpl->tpl_vars['categories']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['categories'][0][0]->categories(array('sort'=>false,'counters'=>false,'assign'=>'categories','scope'=>'global'),$_smarty_tpl);?>
<?php }?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getBranch'][0][0]->getBranch(array('from'=>'categories','id'=>$_smarty_tpl->tpl_vars['category']->value->category_id,'assign'=>'branch'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['branch']->value->subcategories)){?><br /><div class="title2">Выберите категорию</div><div class="category-buttons"><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['branch']->value->subcategories; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><a class="category-button" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</span></a><?php } ?></div><?php }else{ ?><p>Товары не найдены.</p><?php }?><?php }else{ ?><p>Товары не найдены.</p><?php }?><?php }?></article><!-- .content --><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="col-md-12"><?php echo $_smarty_tpl->getSubTemplate ('common/recent_products.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php if (!empty($_smarty_tpl->tpl_vars['brand']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'brand->meta_title','assign'=>'title','scope'=>'global'),$_smarty_tpl);?>
<?php }elseif(!empty($_smarty_tpl->tpl_vars['category']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'category->meta_title','assign'=>'title','scope'=>'global'),$_smarty_tpl);?>
<?php }?>
<?php }} ?>