<?php /* Smarty version Smarty-3.1.8, created on 2016-09-22 00:14:19
         compiled from "design/lemanta/html/sitemap.htm" */ ?>
<?php /*%%SmartyHeaderCode:194904382157e2f82b6d2913-93928725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93987909210960b429848ed41da8dc30a307e26d' => 
    array (
      0 => 'design/lemanta/html/sitemap.htm',
      1 => 1473158164,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '194904382157e2f82b6d2913-93928725',
  'function' => 
  array (
    'sitemapBlock' => 
    array (
      'parameter' => 
      array (
        'title' => '',
      ),
      'compiled' => '',
    ),
    'sitemapListing' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'user' => 0,
    'mod' => 0,
    'emulator' => 0,
    'categories' => 0,
    'articles' => 0,
    'all_brands' => 0,
    'news' => 0,
    'section' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57e2f82b7329a9_84153770',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57e2f82b7329a9_84153770')) {function content_57e2f82b7329a9_84153770($_smarty_tpl) {?><?php if (!function_exists('smarty_template_function_sitemapBlock')) {
    function smarty_template_function_sitemapBlock($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['sitemapBlock']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php if (!function_exists('smarty_template_function_sitemapListing')) {
    function smarty_template_function_sitemapListing($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['sitemapListing']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->enabled)&&(empty($_smarty_tpl->tpl_vars['item']->value->hidden)||!empty($_smarty_tpl->tpl_vars['user']->value->user_id))){?><li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->subcategories)){?><?php smarty_template_function_sitemapListing($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['item']->value->subcategories));?>
<?php }elseif(!empty($_smarty_tpl->tpl_vars['item']->value->subbrands)){?><?php smarty_template_function_sitemapListing($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['item']->value->subbrands));?>
<?php }?></li><?php }?><?php } ?></ul><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_sitemapListing($_smarty_tpl,array());?>
<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'Карта сайта','noCatalogLink'=>true), 0);?>
<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['categories']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['categories'][0][0]->categories(array('assign'=>'categories','scope'=>'global'),$_smarty_tpl);?>
<?php }?><div class="right"><div class="left-column"><div class="sitemap"><h2>Разделы сайта</h2><?php smarty_template_function_sitemapBlock($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['categories']->value));?>
</div><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['articles'][0][0]->articles(array('count'=>250,'assign'=>'articles'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['articles']->value)){?><div class="sitemap"><h2>Статьи</h2><?php smarty_template_function_sitemapBlock($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['articles']->value));?>
</div><?php }?></div><?php if (!isset($_smarty_tpl->tpl_vars['all_brands']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['categories'][0][0]->categories(array('table'=>'brands','assign'=>'all_brands','scope'=>'global'),$_smarty_tpl);?>
<?php }?><div class="right-column"><?php if (!empty($_smarty_tpl->tpl_vars['all_brands']->value)){?><div class="sitemap"><h2>Производители</h2><?php smarty_template_function_sitemapBlock($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['all_brands']->value));?>
</div><?php }?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['news'][0][0]->news(array('count'=>250,'assign'=>'news'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['news']->value)){?><div class="sitemap"><h2>Новости</h2><?php smarty_template_function_sitemapBlock($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['news']->value));?>
</div><?php }?></div></div><?php if (!empty($_smarty_tpl->tpl_vars['section']->value)){?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable('Карта сайта', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php $_smarty_tpl->tpl_vars['description'] = new Smarty_variable('', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['description'] = clone $_smarty_tpl->tpl_vars['description']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['description'] = clone $_smarty_tpl->tpl_vars['description'];?><?php $_smarty_tpl->tpl_vars['keywords'] = new Smarty_variable('', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['keywords'] = clone $_smarty_tpl->tpl_vars['keywords']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['keywords'] = clone $_smarty_tpl->tpl_vars['keywords'];?><?php }?><?php }} ?>