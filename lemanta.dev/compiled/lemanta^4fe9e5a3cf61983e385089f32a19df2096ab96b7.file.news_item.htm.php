<?php /* Smarty version Smarty-3.1.8, created on 2016-11-08 18:18:47
         compiled from "design/lemanta/html\news_item.htm" */ ?>
<?php /*%%SmartyHeaderCode:261695821ebcc9b6234-43962437%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4fe9e5a3cf61983e385089f32a19df2096ab96b7' => 
    array (
      0 => 'design/lemanta/html\\news_item.htm',
      1 => 1478618326,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '261695821ebcc9b6234-43962437',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5821ebcca46014_42153819',
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'news_item' => 0,
    'title' => 0,
    'prev_post' => 0,
    'next_post' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821ebcca46014_42153819')) {function content_5821ebcca46014_42153819($_smarty_tpl) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'news_item','assign'=>'title'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><article class="content col-md-9 col-sm-9 col-md-push-3 col-sm-push-3"><div class="right"><?php if (!empty($_smarty_tpl->tpl_vars['news_item']->value)){?><h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1><p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'news_item->date_date'),$_smarty_tpl);?>
</p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['body'][0][0]->body(array('from'=>'news_item'),$_smarty_tpl);?>
<br /><br /><div id="back_forward"><?php if (!empty($_smarty_tpl->tpl_vars['prev_post']->value)){?>←&nbsp;<a class="prev_page_link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'prev_post'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'prev_post'),$_smarty_tpl);?>
</a><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['next_post']->value)){?><a class="next_page_link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'next_post'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'next_post'),$_smarty_tpl);?>
</a>&nbsp;→<?php }?></div><?php }else{ ?><h1>Страница не найдена!</h1><p>Нет такой страницы или её содержимое закрыто для неавторизованных пользователей!</p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['header404'][0][0]->header404(array(),$_smarty_tpl);?>
<?php }?></div></article><!-- .content --><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>