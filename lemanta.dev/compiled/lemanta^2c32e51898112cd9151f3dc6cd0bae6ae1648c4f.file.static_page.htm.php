<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:58:01
         compiled from "design/lemanta/html/static_page.htm" */ ?>
<?php /*%%SmartyHeaderCode:98440993257d5b749751516-24157803%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c32e51898112cd9151f3dc6cd0bae6ae1648c4f' => 
    array (
      0 => 'design/lemanta/html/static_page.htm',
      1 => 1473158164,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98440993257d5b749751516-24157803',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
    'mod' => 0,
    'emulator' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b74977e683_46195177',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b74977e683_46195177')) {function content_57d5b74977e683_46195177($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['page']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'page','assign'=>'title'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><h2><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h2><div class="text"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['body'][0][0]->body(array('from'=>'page'),$_smarty_tpl);?>
</div></div><?php }else{ ?><?php echo $_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }?><?php }} ?>