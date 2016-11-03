<?php /* Smarty version Smarty-3.1.8, created on 2016-11-03 15:25:59
         compiled from "design/lemanta/html\static_page.htm" */ ?>
<?php /*%%SmartyHeaderCode:18191581b08da5bbcf8-14334110%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7304a85c05273b58d9e6e65d4b6a4dca877528e' => 
    array (
      0 => 'design/lemanta/html\\static_page.htm',
      1 => 1478175826,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18191581b08da5bbcf8-14334110',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_581b08da9feaa0_06630475',
  'variables' => 
  array (
    'page' => 0,
    'mod' => 0,
    'emulator' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581b08da9feaa0_06630475')) {function content_581b08da9feaa0_06630475($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['page']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('from'=>'page','assign'=>'title'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['mod'] = new Smarty_variable('mod-breadcrumbs.htm', null, 0);?><?php if ($_smarty_tpl->tpl_vars['emulator']->value->existsModule($_smarty_tpl->tpl_vars['mod']->value)){?><?php echo $_smarty_tpl->getSubTemplate (($_smarty_tpl->tpl_vars['mod']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('noCatalogLink'=>true), 0);?>
<?php }?><?php echo $_smarty_tpl->getSubTemplate ('common/left-column.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="right"><h2><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h2><h2>STATIC</h2><div class="text"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['body'][0][0]->body(array('from'=>'page'),$_smarty_tpl);?>
</div></div><?php }else{ ?><?php echo $_smarty_tpl->getSubTemplate ('missing_template.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }?>
<?php }} ?>