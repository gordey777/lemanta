<?php /* Smarty version Smarty-3.1.8, created on 2016-11-01 06:15:04
         compiled from "design/lemanta/html/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55549573657d5b6a869d6f3-61941195%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d7c1f43f8baf34b649bd6f69d8baab4dfefec2e' => 
    array (
      0 => 'design/lemanta/html/index.tpl',
      1 => 1477973576,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55549573657d5b6a869d6f3-61941195',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a87ea091_98573530',
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
    'menuTop' => 0,
    'helper' => 0,
    'name' => 0,
    'url' => 0,
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
<?php if ($_valid && !is_callable('content_57d5b6a87ea091_98573530')) {function content_57d5b6a87ea091_98573530($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('common/check404.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
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
css/style.css" rel="stylesheet" /><script>var thisTemplateRootUrl = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
';</script><script src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
js/script.js"></script><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'meta'),$_smarty_tpl);?>
<script type="application/ld+json">{ "@context" : "http://schema.org", "@type" : "Organization", "url" : "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
", "contactPoint" : [ {  "@type" : "ContactPoint", "telephone" : "+38-098-053-22-23", "contactType" : "customer service" } ] } </script></head><?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><body class="home-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['category']->value)){?><body class="category-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['section']->value)){?><body class="section-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['user']->value)){?><body class="user-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['brand']->value)){?><body class="brand-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['product']->value)){?><body class="product-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['item']->value)){?><body class="item-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['group']->value)){?><body class="group-page"><?php }elseif(!empty($_smarty_tpl->tpl_vars['emulator']->value)){?><body class="emulator-page"><?php }else{ ?><body class="other-page"><?php }?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-google-tag-manager.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('trackOrder'=>true,'baseOnly'=>true,'trackCart'=>true,'trackDefer'=>true,'startManager'=>true,'gtmID'=>'GTM-TQKHLJ','final'=>true), 0);?>
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
</p><?php }?></div><?php }?></li><?php endfor; endif; ?></ul></div><?php }?><div class="bg"><div class="line"></div><div class="container"><div class="header"><div class="container"><div class="login"><?php if (!empty($_smarty_tpl->tpl_vars['user']->value)){?><span id="username"><a href="account" rel="nofollow"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'user->compound_name'),$_smarty_tpl);?>
</a><?php if (!empty($_smarty_tpl->tpl_vars['group']->value->discount)){?>, ваша скидка &mdash; <?php echo $_smarty_tpl->tpl_vars['group']->value->discount;?>
%<?php }?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="logout" href="logout" rel="nofollow">Выйти</a><?php }else{ ?><a id="login" href="login" rel="nofollow">Вход</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a id="register" href="registration" rel="nofollow">Регистрация</a><?php }?></div><div class="soc"><a href="skype:lemanta2014?call" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/soc1.png" alt="Lemanta Skype" /></a><a href="http://vkontakte.ru/share.php?url=http://lemanta.com" target="_blank" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/soc2.png" alt="Lemanta ВКонтакте" /></a><a href="https://www.instagram.com/lemanta8465/" target="_blank" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/instagram.png" alt="Lemanta в Instagram" /></a><a href="https://www.facebook.com/Lemanta-280572415630549/" target="_blank" rel="nofollow"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/FB-f-Logo__blue_29.png" alt="Lemanta в Facebook" /></a></div><?php if (!empty($_smarty_tpl->tpl_vars['currencies']->value)&&count($_smarty_tpl->tpl_vars['currencies']->value)>1){?><div class="lang"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'currency->currency_id','assign'=>'sid'),$_smarty_tpl);?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'item->currency_id','assign'=>'id'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable($_smarty_tpl->tpl_vars['sid']->value===$_smarty_tpl->tpl_vars['id']->value ? 'class="selected"' : '', null, 0);?><a onclick="changeCurrency('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
')" <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a><?php } ?><form id="currencyForm" method="post"><input id="currencyFormInput" name="currency_id" type="hidden" value="" /></form></div><?php }?></div><div class="logo"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/logo.png" alt="" /></a></div><div id="cart_informer" class="cart"><?php echo $_smarty_tpl->getSubTemplate ('common/cart-informer.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="clr"></div><div class="menu"><a class="super-button" href="#"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/menu.png" alt="Меню" class="menu-opened"/><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/close.png" alt="Закрыть меню" class="menu-closed"/></a><script>$('.super-button').on('click', function(event){event.preventDefault();var $navMenu = $('.super-nav-menu');if ( $(this).hasClass('super-button-opened') ) {$navMenu.fadeOut('fast');$('.super-button').removeClass('super-button-opened')} else {$navMenu.css('display', 'flex');$('.super-button').addClass('super-button-opened')}})</script><ul class="super-nav-menu"><?php if (empty($_smarty_tpl->tpl_vars['menuTop']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['menuByLangTechName'][0][0]->menuByLangTechName(array('name'=>'Верхнее меню','attach'=>'sections, categories','assign'=>'menuTop','scope'=>'global'),$_smarty_tpl);?>
<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['menuTop']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['menuTop']->value->categories)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'category->category_id','assign'=>'sid'),$_smarty_tpl);?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuTop']->value->categories; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->enabled)&&(empty($_smarty_tpl->tpl_vars['item']->value->hidden)||$_smarty_tpl->tpl_vars['helper']->value->existsUser())){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'item->category_id','assign'=>'id'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable($_smarty_tpl->tpl_vars['id']->value==$_smarty_tpl->tpl_vars['sid']->value ? 'class="selected"' : '', null, 0);?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name)===null||$tmp==='' ? '' : $tmp), null, 0);?><li <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li><?php }?><?php } ?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['menuTop']->value->sections)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'section->section_id','assign'=>'sid'),$_smarty_tpl);?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuTop']->value->sections; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->enabled)&&(empty($_smarty_tpl->tpl_vars['item']->value->hidden)||$_smarty_tpl->tpl_vars['helper']->value->existsUser())){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'item->section_id','assign'=>'id'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable($_smarty_tpl->tpl_vars['id']->value==$_smarty_tpl->tpl_vars['sid']->value ? 'class="selected"' : '', null, 0);?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('assign'=>'url'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(preg_replace('!/sections/mainpage$!i','/',$_smarty_tpl->tpl_vars['url']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(preg_replace('!/dummy/!i','/',$_smarty_tpl->tpl_vars['url']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php if ($_smarty_tpl->tpl_vars['name']->value=='Главная'){?><li <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
" title="Интернет-магазин одежды от производителя" alt="Интернет-магазин одежды в розницу"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/home-icon.png" alt="" /></a></li><?php }else{ ?><li <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li><?php }?><?php }?><?php } ?><?php }?><?php }?></ul></div><div id="search" class="search"><form method="post" onsubmit="return false"><input class="input_search" name="keyword" maxlength="48" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'keyword'),$_smarty_tpl);?>
" placeholder="Поиск товара" /><input name="search_type" type="hidden" value="a1" /><input name="reset_old" type="hidden" value="1" /><input class="button_search" type="submit" value="" /></form></div><div class="clr"></div><?php if (!empty($_smarty_tpl->tpl_vars['enableHitProducts']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['discountProducts'][0][0]->discountProducts(array('count'=>20,'assign'=>'items'),$_smarty_tpl);?>
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
</a><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?><?php } ?><?php }?><div class="lenta"><p>Топ продаж</p></div></div></li><?php } ?></ul></div><div class="clr"></div><a href="#" class="prev prev-navigation"></a><a href="#" class="next next-navigation"></a></div><?php }?><?php }?></div><div class="wrap other"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['content'][0][0]->content(array(),$_smarty_tpl);?>
<div class="clr"></div></div></div><?php $_smarty_tpl->tpl_vars['onFirstPage'] = new Smarty_variable(empty($_smarty_tpl->tpl_vars['PrevPageUrl']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><?php $_smarty_tpl->tpl_vars['seo'] = new Smarty_variable(array(), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['seo_description']->value)){?><?php $_smarty_tpl->tpl_vars['number'] = new Smarty_variable(1, null, 0);?><?php $_smarty_tpl->tpl_vars['pattern'] = new Smarty_variable('!^[ \t\r\n]*<h1[^>]*>([^<]+)</h1>(.*?)$!ius', null, 0);?><?php $_smarty_tpl->tpl_vars['pattern2'] = new Smarty_variable('!^[ \t\r\n]*(.*?)(<h1.*)$!ius', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['seo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['seo']);
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
</div><?php }?><?php }?><?php }?><div class="footer"><?php if ($_smarty_tpl->tpl_vars['onFirstPage']->value){?><?php if (!empty($_smarty_tpl->tpl_vars['seo']->value[1]['body'])&&!empty($_smarty_tpl->tpl_vars['seo']->value[2]['body'])){?><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array(),$_smarty_tpl);?>
" onclick="return toggleSeoDetails('#seo1', 800)"><?php echo $_smarty_tpl->tpl_vars['seo']->value[1]['h1'];?>
</a><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array(),$_smarty_tpl);?>
" onclick="return toggleSeoDetails('#seo2', 800)"><?php echo $_smarty_tpl->tpl_vars['seo']->value[2]['h1'];?>
</a><?php }else{ ?><?php if (!empty($_smarty_tpl->tpl_vars['config']->value->seo_href1)){?><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'config->seo_href1'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->seo_link1'),$_smarty_tpl);?>
</a><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['config']->value->seo_href2)){?><a class="seo-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'config->seo_href2'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->seo_link2'),$_smarty_tpl);?>
</a><?php }?><?php }?><?php }?><p>Copyright © <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
">Lemanta</a>. All rights reserved.</p><div class="counters"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['counters'][0][0]->counters(array(),$_smarty_tpl);?>
</div></div><a id="back-top" title="К началу страницы">↑</a></div><script>function gotoHref ( anchor ) {try {var href1 = anchor.getAttribute('data-href');if (typeof href1 == 'string' && href1 != '') {if (anchor.tagName == 'A') {var href2 = anchor.getAttribute('href');if (typeof href2 != 'string' || href2 != href1) {anchor.setAttribute('href', href1);}return true;} else {}}} catch (e) { }return false;};</script></body></html><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['headerLastModified'][0][0]->headerLastModified(array(),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['headerExpires'][0][0]->headerExpires(array(),$_smarty_tpl);?>
<?php }?>
<?php }} ?>