<?php /* Smarty version Smarty-3.1.8, created on 2016-11-08 20:17:27
         compiled from "design/lemanta/html\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:326185819dfcc45fb91-21474403%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0073f1ed1720bc5a4b364b16d2673f4d0be42c8a' => 
    array (
      0 => 'design/lemanta/html\\index.tpl',
      1 => 1478625438,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '326185819dfcc45fb91-21474403',
  'function' => 
  array (
    'showCategoriesTree' => 
    array (
      'parameter' => 
      array (
        'needRename' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819dfcc8b8fd0_44270972',
  'variables' => 
  array (
    'uri' => 0,
    'ajax' => 0,
    'CurrentPage' => 0,
    'seoPagenum1' => 0,
    'seoPagenum2' => 0,
    'mod' => 0,
    'emulator' => 0,
    'onFirstPage' => 0,
    'category' => 0,
    'section' => 0,
    'user' => 0,
    'brand' => 0,
    'product' => 0,
    'item' => 0,
    'group' => 0,
    'number' => 0,
    'type' => 0,
    'image' => 0,
    'currencies' => 0,
    'sid' => 0,
    'id' => 0,
    'class' => 0,
    'enableHitProducts' => 0,
    'items' => 0,
    'PrevPageUrl' => 0,
    'seo_description' => 0,
    'pattern' => 0,
    'pattern2' => 0,
    'seo' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dfcc8b8fd0_44270972')) {function content_5819dfcc8b8fd0_44270972($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('common/check404.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array('except'=>'*','nopages'=>true,'assign'=>'uri'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['uri']->value=='/order'){?><?php $_smarty_tpl->tpl_vars['content'] = new Smarty_variable($_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>
<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['ajax']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['content'][0][0]->content(array(),$_smarty_tpl);?>
<?php }else{ ?><!DOCTYPE html><html lang="ru"><head><base href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
" /><meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1" /><?php $_smarty_tpl->tpl_vars['seoPagenum1'] = new Smarty_variable('', null, 0);?><?php $_smarty_tpl->tpl_vars['seoPagenum2'] = new Smarty_variable('', null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php $_smarty_tpl->tpl_vars['seoPagenum1'] = new Smarty_variable($_smarty_tpl->tpl_vars['CurrentPage']->value+1, null, 0);?><?php $_smarty_tpl->tpl_vars['seoPagenum1'] = new Smarty_variable(" | Страница ".($_smarty_tpl->tpl_vars['seoPagenum1']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['seoPagenum2'] = new Smarty_variable($_smarty_tpl->tpl_vars['CurrentPage']->value+1, null, 0);?><?php $_smarty_tpl->tpl_vars['seoPagenum2'] = new Smarty_variable(" Страница ".($_smarty_tpl->tpl_vars['seoPagenum2']->value), null, 0);?><?php }?><title><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['title'][0][0]->title(array(),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['seoPagenum1']->value;?>
</title><meta content="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['metaDescription'][0][0]->metaDescription(array(),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['seoPagenum2']->value;?>
" name="description" /><meta content="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['metaKeywords'][0][0]->metaKeywords(array(),$_smarty_tpl);?>
" name="keywords" /><link href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/favicon.ico" rel="shortcut icon" /><meta name="generator" content="Impera CMS <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['version'][0][0]->version(array(),$_smarty_tpl);?>
 (<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['versionYMD'][0][0]->versionYMD(array(),$_smarty_tpl);?>
)" /><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-canonizator.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCanonical'=>false,'unCivil'=>true,'unCivilAny'=>true,'noIndex'=>false,'noPagination'=>false,'noPrefetch'=>false,'noSyndication'=>true), 0);?>
<?php }?><link href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
css/style.css" rel="stylesheet" /></head><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'meta'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><body class="home-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['category']->value)){?><body class="category-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['section']->value)){?><body class="section-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['user']->value)){?><body class="user-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['brand']->value)){?><body class="brand-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['product']->value)){?><body class="product-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['item']->value)){?><body class="item-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['group']->value)){?><body class="group-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['emulator']->value)){?><body class="emulator-page"><?php }else{ ?><body class="other-page"><?php }?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-google-tag-manager.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('trackOrder'=>true,'baseOnly'=>true,'trackCart'=>true,'trackDefer'=>true,'startManager'=>true,'gtmID'=>'GTM-TQKHLJ','final'=>true), 0);?>
<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['section']->value)){?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable($_smarty_tpl->tpl_vars['section']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable('section', null, 0);?><?php }elseif(!empty($_smarty_tpl->tpl_vars['brand']->value)){?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['brand']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['category']->value : $tmp))===null||$tmp==='' ? false : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable('brand', null, 0);?><?php }elseif(!empty($_smarty_tpl->tpl_vars['category']->value)){?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable('category', null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable(false, null, 0);?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->images)){?><div class="skdslider slider" id="slider"><div class="sh"></div><ul><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(0, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['images'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['images']);
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
?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['findImage'][0][0]->findImage(array('type'=>$_smarty_tpl->tpl_vars['type']->value,'num'=>$_smarty_tpl->tpl_vars['number']->value,'assign'=>'image'),$_smarty_tpl);?>
<?php if (empty($_smarty_tpl->tpl_vars['image']->value['found'])){?><?php break 1?><?php }?><li><img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['url'];?>
" alt="" /><?php if (!empty($_smarty_tpl->tpl_vars['image']->value['alt'])||!empty($_smarty_tpl->tpl_vars['image']->value['desc'])){?><div class="slide-desc"><?php if (!empty($_smarty_tpl->tpl_vars['image']->value['alt'])){?><h2><?php echo $_smarty_tpl->tpl_vars['image']->value['alt'];?>
</h2><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['image']->value['desc'])){?><p><?php echo $_smarty_tpl->tpl_vars['image']->value['desc'];?>
</p><?php }?></div><?php }?></li><?php endfor; endif; ?></ul></div><?php }?><!-- wrapper --><div class="bg wrapper"><header role="banner"><a href="#menu" id="hamburger" class="humb-toggle-switch humb-toggle-switch__htx"><span>toggle menu</span></a><nav id="menu"><ul class="mob-menu"><li><a id="mob-search" class="search"><form method="post" onsubmit="return false"><input class="input_search" name="keyword" maxlength="48" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'keyword'),$_smarty_tpl);?>
" placeholder="Поиск товара" /><input name="search_type" type="hidden" value="a1" /><input name="reset_old" type="hidden" value="1" /><input class="button_search" type="submit" value="" /></form></a></li><?php echo $_smarty_tpl->getSubTemplate ('common/main-nav.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<!--         <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
" title="Интернет-магазин одежды от производителя" alt="Интернет-магазин одежды в розницу"><i class="fa fa-home"></i></a></li> --><?php echo $_smarty_tpl->getSubTemplate ('common/menu-catalog.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</ul></nav><div class="top-menu-wrap"><div class="container"><div class="row"><div class="top-menu col-md-12"><div class="login col-md-2 col-xs-4"><?php if (!empty($_smarty_tpl->tpl_vars['user']->value)){?><span id="username"><a href="account" rel="nofollow"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'user->compound_name'),$_smarty_tpl);?>
</a><?php if (!empty($_smarty_tpl->tpl_vars['group']->value->discount)){?>, ваша скидка &mdash; <?php echo $_smarty_tpl->tpl_vars['group']->value->discount;?>
%<?php }?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="logout" href="logout" rel="nofollow">Выйти</a><?php }else{ ?><a id="login" href="login" rel="nofollow">Вход</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="register" href="registration" rel="nofollow">Регистрация</a><?php }?></div><div class="socialnet col-md-2 col-xs-4"><a href="skype:lemanta2014?call" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/soc1.png" alt="Lemanta Skype" /></a><a href="http://vkontakte.ru/share.php?url=http://lemanta.com" target="_blank" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/soc2.png" alt="Lemanta ВКонтакте" /></a><a href="https://www.instagram.com/lemanta8465/" target="_blank" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/instagram.png" alt="Lemanta в Instagram" /></a><a href="https://www.facebook.com/Lemanta-280572415630549/" target="_blank" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/FB-f-Logo__blue_29.png" alt="Lemanta в Facebook" /></a></div><?php if (!empty($_smarty_tpl->tpl_vars['currencies']->value)&&count($_smarty_tpl->tpl_vars['currencies']->value)>1){?><div class="valuta col-md-2 col-xs-4"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'currency->currency_id','assign'=>'sid'),$_smarty_tpl);?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'item->currency_id','assign'=>'id'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable($_smarty_tpl->tpl_vars['sid']->value===$_smarty_tpl->tpl_vars['id']->value ? 'class="selected"' : '', null, 0);?><a onclick="changeCurrency('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
')" <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a><?php } ?><form id="currencyForm" method="post"><input id="currencyFormInput" name="currency_id" type="hidden" value="" /></form></div><!-- /.valuta --><?php }?></div></div><!-- /.row --></div><!-- /.container --></div><!-- /.top-menu-wrap --><div class="container"><div class="row"><div class="logo col-md-2 col-sm-2 col-xs-6"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/logo.png" alt="" /></a></div><div id="cart_informer" class="head-cart col-md-2 col-md-offset-8 col-sm-2 col-xs-5"><?php echo $_smarty_tpl->getSubTemplate ('common/cart-informer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="search-bg col-md-2 col-sm-3 col-xs-4 col-md-push-10"><div id="search" class="search"><form method="post" onsubmit="return false"><input class="input_search" name="keyword" maxlength="48" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'keyword'),$_smarty_tpl);?>
" placeholder="Поиск товара" /><input name="search_type" type="hidden" value="a1" /><input name="reset_old" type="hidden" value="1" /><input class="button_search" type="submit" value="" /></form></div></div><nav id="head-top-nav" class="nav__header col-md-10 col-sm-12 col-md-pull-2" role="navigation"><ul class="headnav"><?php echo $_smarty_tpl->getSubTemplate ('common/main-nav.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</ul></nav><!-- /nav --></div><!-- /.row --></div><!-- /.container --></header><!-- /header --><div class="clr"></div><?php if (!empty($_smarty_tpl->tpl_vars['enableHitProducts']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountProducts'][0][0]->discountProducts(array('count'=>20,'assign'=>'items'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><div class="popular0"><div class="popular"><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><li><div class="popular-bl"><div class="popular-image"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['image'][0][0]->image(array('folder'=>'files/products'),$_smarty_tpl);?>
" alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
" /></a></div><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->variants)){?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" class="popular-price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountPrice'][0][0]->discountPrice(array('num'=>$_smarty_tpl->tpl_vars['number']->value),$_smarty_tpl);?>
</a><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php } ?><?php }?><div class="lenta"><p>Топ продаж</p></div></div></li><?php } ?></ul></div><div class="clr"></div><a href="#" class="prev prev-navigation"></a><a href="#" class="next next-navigation"></a></div><?php }?><?php }?><section role="main"><div class="container"><div class="row"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['content'][0][0]->content(array(),$_smarty_tpl);?>
<div class="clr"></div><div class="seo-container col-md-12"><?php $_smarty_tpl->tpl_vars['onFirstPage'] = new Smarty_variable(empty($_smarty_tpl->tpl_vars['PrevPageUrl']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><?php $_smarty_tpl->tpl_vars['seo'] = new Smarty_variable(array(), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['seo_description']->value)){?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php $_smarty_tpl->tpl_vars['pattern'] = new Smarty_variable('!^[ \t\r\n]*<h1[^>]*>([^<]+)</h1>(.*?)$!ius', null, 0);?><?php $_smarty_tpl->tpl_vars['pattern2'] = new Smarty_variable('!^[ \t\r\n]*(.*?)(<h1.*)$!ius', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['seo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['name'] = 'seo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['loop'] = is_array($_loop=2) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['seo']['total']);
?><?php if (preg_match($_smarty_tpl->tpl_vars['pattern']->value,$_smarty_tpl->tpl_vars['seo_description']->value)){?><?php $_smarty_tpl->createLocalArrayVariable('seo', null, 0);
$_smarty_tpl->tpl_vars['seo']->value[$_smarty_tpl->tpl_vars['number']->value] = array();?><?php $_smarty_tpl->createLocalArrayVariable('seo', null, 0);
$_smarty_tpl->tpl_vars['seo']->value[$_smarty_tpl->tpl_vars['number']->value]['h1'] = preg_replace($_smarty_tpl->tpl_vars['pattern']->value,'$1',$_smarty_tpl->tpl_vars['seo_description']->value);?><?php $_smarty_tpl->tpl_vars['seo_description'] = new Smarty_variable(preg_replace($_smarty_tpl->tpl_vars['pattern']->value,'$2',$_smarty_tpl->tpl_vars['seo_description']->value), null, 0);?><?php $_smarty_tpl->createLocalArrayVariable('seo', null, 0);
$_smarty_tpl->tpl_vars['seo']->value[$_smarty_tpl->tpl_vars['number']->value]['body'] = preg_replace($_smarty_tpl->tpl_vars['pattern2']->value,'$1',$_smarty_tpl->tpl_vars['seo_description']->value);?><?php $_smarty_tpl->tpl_vars['seo_description'] = new Smarty_variable(preg_replace($_smarty_tpl->tpl_vars['pattern2']->value,'$2',$_smarty_tpl->tpl_vars['seo_description']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php }?><?php endfor; endif; ?><?php }?><?php }?><?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><?php if (!empty($_smarty_tpl->tpl_vars['seo_description']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['seo']->value[1]['body'])&&!empty($_smarty_tpl->tpl_vars['seo']->value[2]['body'])){?><div class="seo" id="seo1"><?php echo $_smarty_tpl->tpl_vars['seo']->value[1]['body'];?>
</div><div class="seo" id="seo2"><?php echo $_smarty_tpl->tpl_vars['seo']->value[2]['body'];?>
</div><?php }elseif(!empty($_smarty_tpl->tpl_vars['seo_description']->value)){?><div class="seo"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'seo_description'),$_smarty_tpl);?>
</div><?php }?><?php }?><?php }?></div><!-- /.seo-container col-md-12 --></div><!-- /.row --></div><!-- /.container --></section><!-- /section --></div><!-- /wrapper --><footer class="footer"><?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><?php if (!empty($_smarty_tpl->tpl_vars['seo']->value[1]['body'])&&!empty($_smarty_tpl->tpl_vars['seo']->value[2]['body'])){?><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array(),$_smarty_tpl);?>
" onclick="return toggleSeoDetails('#seo1', 800)"><?php echo $_smarty_tpl->tpl_vars['seo']->value[1]['h1'];?>
</a><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array(),$_smarty_tpl);?>
" onclick="return toggleSeoDetails('#seo2', 800)"><?php echo $_smarty_tpl->tpl_vars['seo']->value[2]['h1'];?>
</a><?php }else{ ?><?php if (!empty($_smarty_tpl->tpl_vars['config']->value->seo_href1)){?><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'config->seo_href1'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->seo_link1'),$_smarty_tpl);?>
</a><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['config']->value->seo_href2)){?><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'config->seo_href2'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->seo_link2'),$_smarty_tpl);?>
</a><?php }?><?php }?><?php }?><p>Copyright © <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
">Lemanta</a>. All rights reserved.</p><div class="counters"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['counters'][0][0]->counters(array(),$_smarty_tpl);?>
</div></footer><a id="back-top" title="К началу страницы"><i class="fa fa-arrow-up"></i></a><script>var thisTemplateRootUrl = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
';</script><script src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
js/script.js"></script><script type="application/ld+json">{  "@context" : "http://schema.org",  "@type" : "Organization",  "url" : "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
",  "contactPoint" : [ {  "@type" : "ContactPoint",  "telephone" : "+38-098-053-22-23",  "contactType" : "customer service"  } ] } </script><script>function gotoHref(anchor) {try {var href1 = anchor.getAttribute('data-href');if (typeof href1 == 'string' && href1 != '') {if (anchor.tagName == 'A') {var href2 = anchor.getAttribute('href');if (typeof href2 != 'string' || href2 != href1) {anchor.setAttribute('href', href1);}return true;} else {}}} catch (e) {}return false;};</script><script type="text/javascript" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
js/jquery.mmenu.all.min.js"></script><script type="text/javascript">jQuery(document).ready(function($) {$("#menu").mmenu({"extensions": ["pagedim-black"],"offCanvas": {"position": "right"},navbar: {title: 'LEMANTA'},"navbars": [{"position": "bottom","content": ["<a class='fa fa-skype' href='skype:lemanta2014?call'></a>","<a class='fa fa-vk' href='http://vkontakte.ru/share.php?url=http://lemanta.com'></a>","<a class='fa fa-instagram' href='https://www.instagram.com/lemanta8465/'></a>","<a class='fa fa-facebook' href='https://www.facebook.com/Lemanta-280572415630549//'></a>"]}]});});</script><script type="text/javascript" >$('#left_menu > li:has(ul)').addClass("has-sub");</script><script type="text/javascript" >$(document).ready(function(){$('#left_menu li.has-sub>a').on('click', function(){$(this).removeAttr('href');var element = $(this).parent('li');if (element.hasClass('open')) {element.removeClass('open');element.find('li').removeClass('open');element.find('ul').slideUp();}else {element.addClass('open');element.children('ul').slideDown();element.siblings('li').children('ul').slideUp();element.siblings('li').removeClass('open');element.siblings('li').find('li').removeClass('open');element.siblings('li').find('ul').slideUp();}});$('#left_menu>ul>li.has-sub>a').append('<span class="holder"></span>');(function getColor() {var r, g, b;var textColor = $('#left_menu').css('color');textColor = textColor.slice(4);r = textColor.slice(0, textColor.indexOf(','));textColor = textColor.slice(textColor.indexOf(' ') + 1);g = textColor.slice(0, textColor.indexOf(','));textColor = textColor.slice(textColor.indexOf(' ') + 1);b = textColor.slice(0, textColor.indexOf(')'));var l = rgbToHsl(r, g, b);if (l > 0.7) {$('#left_menu>ul>li>a').css('text-shadow', '0 1px 1px rgba(0, 0, 0, .35)');$('#left_menu>ul>li>a>span').css('border-color', 'rgba(0, 0, 0, .35)');}else{$('#left_menu>ul>li>a').css('text-shadow', '0 1px 0 rgba(255, 255, 255, .35)');$('#left_menu>ul>li>a>span').css('border-color', 'rgba(255, 255, 255, .35)');}})();function rgbToHsl(r, g, b) {r /= 255, g /= 255, b /= 255;var max = Math.max(r, g, b), min = Math.min(r, g, b);var h, s, l = (max + min) / 2;if(max == min){h = s = 0;}else {var d = max - min;s = l > 0.5 ? d / (2 - max - min) : d / (max + min);switch(max){case r: h = (g - b) / d + (g < b ? 6 : 0); break;case g: h = (b - r) / d + 2; break;case b: h = (r - g) / d + 4; break;}h /= 6;}return l;}});</script></body></html><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['headerLastModified'][0][0]->headerLastModified(array(),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['headerExpires'][0][0]->headerExpires(array(),$_smarty_tpl);?>
<?php }?>
<?php }} ?>