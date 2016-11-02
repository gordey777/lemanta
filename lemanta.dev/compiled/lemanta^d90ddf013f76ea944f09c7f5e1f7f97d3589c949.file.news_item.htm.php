<?php /* Smarty version Smarty-3.1.8, created on 2016-09-12 04:36:16
         compiled from "design/lemanta/html/news_item.htm" */ ?>
<?php /*%%SmartyHeaderCode:138886384257d60690c552d2-65213396%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd90ddf013f76ea944f09c7f5e1f7f97d3589c949' => 
    array (
      0 => 'design/lemanta/html/news_item.htm',
      1 => 1473158163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138886384257d60690c552d2-65213396',
  'function' => 
  array (
  ),
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
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d60690c8a137_86716654',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d60690c8a137_86716654')) {function content_57d60690c8a137_86716654($_smarty_tpl) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'news_item','assign'=>'title'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><?php if (!empty($_smarty_tpl->tpl_vars['news_item']->value)){?><h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1><p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'news_item->date_date'),$_smarty_tpl);?>
</p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['body'][0][0]->body(array('from'=>'news_item'),$_smarty_tpl);?>
<br /><br /><div id="back_forward"><?php if (!empty($_smarty_tpl->tpl_vars['prev_post']->value)){?>←&nbsp;<a class="prev_page_link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'prev_post'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'prev_post'),$_smarty_tpl);?>
</a><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['next_post']->value)){?><a class="next_page_link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array('from'=>'next_post'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'next_post'),$_smarty_tpl);?>
</a>&nbsp;→<?php }?></div><?php }else{ ?><h1>Страница не найдена!</h1><p>Нет такой страницы или её содержимое закрыто для неавторизованных пользователей!</p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['header404'][0][0]->header404(array(),$_smarty_tpl);?>
<?php }?></div><?php }} ?>