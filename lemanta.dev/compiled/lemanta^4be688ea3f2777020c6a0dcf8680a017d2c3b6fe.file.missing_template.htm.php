<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:20
         compiled from "design/lemanta/html/missing_template.htm" */ ?>
<?php /*%%SmartyHeaderCode:42672866957d5b6a88000e8-92403014%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4be688ea3f2777020c6a0dcf8680a017d2c3b6fe' => 
    array (
      0 => 'design/lemanta/html/missing_template.htm',
      1 => 1473158163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42672866957d5b6a88000e8-92403014',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a8808455_47280763',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a8808455_47280763')) {function content_57d5b6a8808455_47280763($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable('Страница не найдена!', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php $_smarty_tpl->tpl_vars['description'] = new Smarty_variable('', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['description'] = clone $_smarty_tpl->tpl_vars['description']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['description'] = clone $_smarty_tpl->tpl_vars['description'];?><?php $_smarty_tpl->tpl_vars['keywords'] = new Smarty_variable('', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['keywords'] = clone $_smarty_tpl->tpl_vars['keywords']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['keywords'] = clone $_smarty_tpl->tpl_vars['keywords'];?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['header404'][0][0]->header404(array(),$_smarty_tpl);?>
<div id="main_page_bloks"><div class="desc"><h3>Ошибка 404</h3><p>Нет такой страницы на нашем сайте или уже удалена как устаревшая.</p></div></div><?php }} ?>