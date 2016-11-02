<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:58:05
         compiled from "design/lemanta/html/news.htm" */ ?>
<?php /*%%SmartyHeaderCode:1766402557d5b74d396819-62260357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c993bd1b0ac823b80c1cf7c61b3a7eb42a407744' => 
    array (
      0 => 'design/lemanta/html/news.htm',
      1 => 1473158163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1766402557d5b74d396819-62260357',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mod' => 0,
    'emulator' => 0,
    'all_news' => 0,
    'PagesNavigation' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b74d3e02d5_15457074',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b74d3e02d5_15457074')) {function content_57d5b74d3e02d5_15457074($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><?php if (!empty($_smarty_tpl->tpl_vars['all_news']->value)){?><div class="blog-page"><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['all_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><div class="blog"><h3><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['itemTitle'][0][0]->itemTitle(array(),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array(),$_smarty_tpl);?>
</a></h3><div class="text"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['annotation'][0][0]->annotation(array(),$_smarty_tpl);?>
</div><span class="date"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'item->date_date'),$_smarty_tpl);?>
</span><div class="clr"></div><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" class="read">Читать далее</a><div class="clr"></div></div><?php } ?></div><div><?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>
</div><?php }else{ ?><p>Новости не найдены.</p><?php }?></div><?php }} ?>