<?php /* Smarty version Smarty-3.1.8, created on 2016-11-12 15:03:18
         compiled from "design/lemanta/html\missing_template.htm" */ ?>
<?php /*%%SmartyHeaderCode:1613558270506a621e7-18869728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '128c76fdab6e15c761b6d6fea9756b4493687ece' => 
    array (
      0 => 'design/lemanta/html\\missing_template.htm',
      1 => 1478877828,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1613558270506a621e7-18869728',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58270507016255_36637846',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58270507016255_36637846')) {function content_58270507016255_36637846($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['title'] = new Smarty_variable('Страница не найдена!', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['title'] = clone $_smarty_tpl->tpl_vars['title'];?><?php $_smarty_tpl->tpl_vars['description'] = new Smarty_variable('', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['description'] = clone $_smarty_tpl->tpl_vars['description']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['description'] = clone $_smarty_tpl->tpl_vars['description'];?><?php $_smarty_tpl->tpl_vars['keywords'] = new Smarty_variable('', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['keywords'] = clone $_smarty_tpl->tpl_vars['keywords']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['keywords'] = clone $_smarty_tpl->tpl_vars['keywords'];?><?php $_smarty_tpl->tpl_vars['meta'] = new Smarty_variable('<meta name="Robots" content="noindex, follow" />', null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['meta'] = clone $_smarty_tpl->tpl_vars['meta'];?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['header404'][0][0]->header404(array(),$_smarty_tpl);?>
<article  id="main_page_bloks" class="content col-md-12"><div class="desc"><h3>Ошибка 404</h3><p>Нет такой страницы на нашем сайте или уже удалена как устаревшая.</p></div></article>
<?php }} ?>