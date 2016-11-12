<?php /* Smarty version Smarty-3.1.8, created on 2016-11-12 13:16:10
         compiled from "design/lemanta/html\mod-breadcrumbs.htm" */ ?>
<?php /*%%SmartyHeaderCode:39825826ebea527df8-13271249%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de58c234385288a2e9b0c319706d05740ee198a4' => 
    array (
      0 => 'design/lemanta/html\\mod-breadcrumbs.htm',
      1 => 1478618224,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39825826ebea527df8-13271249',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'noCatalogLink' => 0,
    'markupTypes' => 0,
    'items' => 0,
    'item' => 0,
    'defTypes' => 0,
    'list' => 0,
    'listItem' => 0,
    'propItem' => 0,
    'propName' => 0,
    'propPos' => 0,
    'pos' => 0,
    'path' => 0,
    'url' => 0,
    'name' => 0,
    'category' => 0,
    'tmpName' => 0,
    'brand' => 0,
    'product' => 0,
    'CurrentPage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5826ebea6907e1_04736195',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5826ebea6907e1_04736195')) {function content_5826ebea6907e1_04736195($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['noCatalogLink'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['config']->value->breadcrumbsNoCatalogLink) ? $_smarty_tpl->tpl_vars['config']->value->breadcrumbsNoCatalogLink : ((($tmp = @$_smarty_tpl->tpl_vars['noCatalogLink']->value)===null||$tmp==='' ? false : $tmp)), null, 0);?><?php $_smarty_tpl->tpl_vars['noCatalogLink'] = new Smarty_variable(!empty($_smarty_tpl->tpl_vars['noCatalogLink']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['defTypes'] = new Smarty_variable(array('rdf'=>'rdfa','rdfa'=>'rdfa','schema.org'=>'microdata','microdata'=>'microdata','*'=>'*'), null, 0);?><?php $_smarty_tpl->tpl_vars['items'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['config']->value->breadcrumbsMarkupTypes) ? $_smarty_tpl->tpl_vars['config']->value->breadcrumbsMarkupTypes : ((($tmp = @$_smarty_tpl->tpl_vars['markupTypes']->value)===null||$tmp==='' ? '' : $tmp)), null, 0);?><?php $_smarty_tpl->tpl_vars['markupTypes'] = new Smarty_variable(array(), null, 0);?><?php $_smarty_tpl->tpl_vars['items'] = new Smarty_variable(explode(',',$_smarty_tpl->tpl_vars['items']->value), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable(trim($_smarty_tpl->tpl_vars['item']->value), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value)){?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable(mb_strtolower($_smarty_tpl->tpl_vars['item']->value, 'UTF-8'), null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['defTypes']->value[$_smarty_tpl->tpl_vars['item']->value])){?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable($_smarty_tpl->tpl_vars['defTypes']->value[$_smarty_tpl->tpl_vars['item']->value], null, 0);?><?php if ($_smarty_tpl->tpl_vars['item']->value=='*'){?><?php $_smarty_tpl->tpl_vars['markupTypes'] = new Smarty_variable(array(), null, 0);?><?php break 1?><?php }?><?php $_smarty_tpl->createLocalArrayVariable('markupTypes', null, 0);
$_smarty_tpl->tpl_vars['markupTypes']->value[$_smarty_tpl->tpl_vars['item']->value] = true;?><?php }?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars['list'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['listItem'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['propItem'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['propName'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['propPos'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable(1, null, 0);?><?php if (empty($_smarty_tpl->tpl_vars['markupTypes']->value)||isset($_smarty_tpl->tpl_vars['markupTypes']->value['microdata'])){?><?php $_smarty_tpl->tpl_vars['list'] = new Smarty_variable(('itemscope itemtype="http://schema.org/BreadcrumbList" ').($_smarty_tpl->tpl_vars['list']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['listItem'] = new Smarty_variable(('itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement" ').($_smarty_tpl->tpl_vars['listItem']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['propItem'] = new Smarty_variable(('itemprop="item" ').($_smarty_tpl->tpl_vars['propItem']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['propName'] = new Smarty_variable(('itemprop="name" ').($_smarty_tpl->tpl_vars['propName']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['propPos'] = new Smarty_variable(('itemprop="position" ').($_smarty_tpl->tpl_vars['propPos']->value), null, 0);?><?php }?><?php if (empty($_smarty_tpl->tpl_vars['markupTypes']->value)||isset($_smarty_tpl->tpl_vars['markupTypes']->value['rdfa'])){?><?php $_smarty_tpl->tpl_vars['list'] = new Smarty_variable(('vocab="http://schema.org/" typeof="BreadcrumbList" ').($_smarty_tpl->tpl_vars['list']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['listItem'] = new Smarty_variable(('property="itemListElement" typeof="ListItem" ').($_smarty_tpl->tpl_vars['listItem']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['propItem'] = new Smarty_variable(('property="item" typeof="WebPage" ').($_smarty_tpl->tpl_vars['propItem']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['propName'] = new Smarty_variable(('property="name" ').($_smarty_tpl->tpl_vars['propName']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['propPos'] = new Smarty_variable(('property="position" ').($_smarty_tpl->tpl_vars['propPos']->value), null, 0);?><?php }?><div class="breadcrumbs col-md-12" <?php echo $_smarty_tpl->tpl_vars['list']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['config']->value->breadcrumbsTopAlt)===null||$tmp==='' ? 'Главная' : $tmp), ENT_QUOTES, 'UTF-8');?>
"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value->breadcrumbsTopName)===null||$tmp==='' ? 'Главная' : $tmp);?>
</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php if (!empty($_smarty_tpl->tpl_vars['path']->value)){?><?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['name']->_loop = false;
 $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['path']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value){
$_smarty_tpl->tpl_vars['name']->_loop = true;
 $_smarty_tpl->tpl_vars['url']->value = $_smarty_tpl->tpl_vars['name']->key;
?><?php if (is_string($_smarty_tpl->tpl_vars['url']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8');?>
" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }else{ ?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php } ?><?php }elseif(!empty($_smarty_tpl->tpl_vars['category']->value)){?><?php if (empty($_smarty_tpl->tpl_vars['noCatalogLink']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="products" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="Каталог"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
>Каталог</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['category']->value->path)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value->path; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array(),$_smarty_tpl);?>
"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('assign'=>'tmpName'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['tmpName']->value=='Костюмы тройки'){?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->url)){?><?php if ($_smarty_tpl->tpl_vars['item']->value->url=='detskaya-odezhda/dlya-malchikov/kostyumy'||$_smarty_tpl->tpl_vars['item']->value->url=='detskaya-odezhda/dlya-devochek/kostyumy'){?><?php $_smarty_tpl->tpl_vars['tmpName'] = new Smarty_variable('Костюмы', null, 0);?><?php }?><?php }?><?php }?><?php echo $_smarty_tpl->tpl_vars['tmpName']->value;?>
</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php } ?><?php }else{ ?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'category'),$_smarty_tpl);?>
" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array('from'=>'category'),$_smarty_tpl);?>
"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'category','assign'=>'tmpName'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['tmpName']->value=='Костюмы тройки'){?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->url)){?><?php if ($_smarty_tpl->tpl_vars['item']->value->url=='detskaya-odezhda/dlya-malchikov/kostyumy'||$_smarty_tpl->tpl_vars['item']->value->url=='detskaya-odezhda/dlya-devochek/kostyumy'){?><?php $_smarty_tpl->tpl_vars['tmpName'] = new Smarty_variable('Костюмы', null, 0);?><?php }?><?php }?><?php }?><?php echo $_smarty_tpl->tpl_vars['tmpName']->value;?>
</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['brand']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['product']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'category'),$_smarty_tpl);?>
/filter_<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'brand->url'),$_smarty_tpl);?>
" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array('from'=>'brand'),$_smarty_tpl);?>
"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'brand'),$_smarty_tpl);?>
</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }else{ ?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'brand'),$_smarty_tpl);?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php }elseif(!empty($_smarty_tpl->tpl_vars['product']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php }elseif(!empty($_smarty_tpl->tpl_vars['brand']->value)){?><?php if (empty($_smarty_tpl->tpl_vars['noCatalogLink']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="products" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="Каталог"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
>Каталог</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['product']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'brand'),$_smarty_tpl);?>
" <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
 title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array('from'=>'brand'),$_smarty_tpl);?>
"><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'brand'),$_smarty_tpl);?>
</span></a><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'product'),$_smarty_tpl);?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }else{ ?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'brand'),$_smarty_tpl);?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php }else{ ?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'title'),$_smarty_tpl);?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /><?php $_smarty_tpl->tpl_vars['pos'] = new Smarty_variable($_smarty_tpl->tpl_vars['pos']->value+1, null, 0);?></span><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><span <?php echo $_smarty_tpl->tpl_vars['listItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propItem']->value;?>
><span <?php echo $_smarty_tpl->tpl_vars['propName']->value;?>
>Страница <?php echo $_smarty_tpl->tpl_vars['CurrentPage']->value+1;?>
</span></span><meta <?php echo $_smarty_tpl->tpl_vars['propPos']->value;?>
 content="<?php echo $_smarty_tpl->tpl_vars['pos']->value;?>
" /></span><?php }?><div class="number"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['phone'][0][0]->phone(array(),$_smarty_tpl);?>
</div></div>
<?php }} ?>