<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:48
         compiled from "design/lemanta/html/catalog.htm" */ ?>
<?php /*%%SmartyHeaderCode:112332079957d5b6c43fece6-70791030%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3de1642087db1def2d1867cb6caad8a721883e36' => 
    array (
      0 => 'design/lemanta/html/catalog.htm',
      1 => 1473158162,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112332079957d5b6c43fece6-70791030',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6c442a245_00151477',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6c442a245_00151477')) {function content_57d5b6c442a245_00151477($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['enableHitProducts'] = new Smarty_variable(true, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['enableHitProducts'] = clone $_smarty_tpl->tpl_vars['enableHitProducts']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['enableHitProducts'] = clone $_smarty_tpl->tpl_vars['enableHitProducts'];?><div id="main_page_bloks"><div class="block-main"><div class="tel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->phone1'),$_smarty_tpl);?>
</div><div class="main-img"><a href="dostavka"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/main1.png" alt="" /></a><div class="main-img-txt"><p>Доставка <span>условия и цены</span></p></div></div><div class="line2"></div><div class="desc"><h3>О нас</h3><p><span>Lemanta</span> - это интернет-магазин, в котором можно купить стильную, актуальную одежду по очень выгодным ценам!</p></div></div><div class="block-main"><div class="tel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->phone2'),$_smarty_tpl);?>
</div><div class="main-img"><a href="oplata"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/main2.png" alt="" /></a><div class="main-img-txt item2"><p>ОПЛАТА <span>условия и цены</span></p></div></div><div class="line2"></div><div class="desc"><h3>Оплата</h3><p>Вы будете приятно удивлены вариантами оплаты. Мы принимает к оплате наличные, безналичные и электронные деньги.</p></div></div><div class="block-main"><div class="tel"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'config->phone3'),$_smarty_tpl);?>
</div><div class="main-img"><a href="blog"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/main3.png" alt="" /></a><div class="main-img-txt item3"><p>Новости</p></div></div><div class="line2"></div><div class="desc"><h3>Доставка</h3><p>Доставка осуществляется курьерской службой <span>"Новая Почта"</span>. Сроки доставки 1-3 дня. По прибытию товара Вы будете уведомлены СМС сообщением.</p></div></div></div><?php }} ?>