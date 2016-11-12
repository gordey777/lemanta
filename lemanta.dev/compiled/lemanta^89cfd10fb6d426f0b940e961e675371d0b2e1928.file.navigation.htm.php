<?php /* Smarty version Smarty-3.1.8, created on 2016-11-12 13:16:09
         compiled from "design/lemanta/html\navigation.htm" */ ?>
<?php /*%%SmartyHeaderCode:283045826ebe9e99ba4-46449171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89cfd10fb6d426f0b940e961e675371d0b2e1928' => 
    array (
      0 => 'design/lemanta/html\\navigation.htm',
      1 => 1478701573,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '283045826ebe9e99ba4-46449171',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'Pages' => 0,
    'CurrentPage' => 0,
    'current' => 0,
    'PrevPageUrl' => 0,
    'i' => 0,
    'url' => 0,
    'class' => 0,
    'lastPageUrl' => 0,
    'NextPageUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5826ebe9f2d1e5_28056973',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5826ebe9f2d1e5_28056973')) {function content_5826ebe9f2d1e5_28056973($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['Pages']->value)){?><?php $_smarty_tpl->tpl_vars['current'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['CurrentPage']->value)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['CurrentPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['current']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['CurrentPage'] = clone $_smarty_tpl->tpl_vars['CurrentPage']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['CurrentPage'] = clone $_smarty_tpl->tpl_vars['CurrentPage'];?><div class="filter-r"><div class="pagination"><?php if (!empty($_smarty_tpl->tpl_vars['PrevPageUrl']->value)){?><?php $_smarty_tpl->tpl_vars['newPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['current']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['PrevPageUrl'] = new Smarty_variable(preg_replace('!/page[_\-][0-9]+!i',"/page-".($_smarty_tpl->tpl_vars['newPage']->value),$_smarty_tpl->tpl_vars['PrevPageUrl']->value), null, 0);?><a class="pag-prev" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PrevPageUrl']->value, ENT_QUOTES, 'UTF-8');?>
">&lt;</a><?php $_smarty_tpl->tpl_vars['PrevPageUrl'] = new Smarty_variable($_smarty_tpl->tpl_vars['PrevPageUrl']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['PrevPageUrl'] = clone $_smarty_tpl->tpl_vars['PrevPageUrl']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['PrevPageUrl'] = clone $_smarty_tpl->tpl_vars['PrevPageUrl'];?><?php }?><?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value){
$_smarty_tpl->tpl_vars['url']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['url']->key;
?><?php $_smarty_tpl->tpl_vars['newPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(preg_replace('!/page[_\-][0-9]+!i',"/page-".($_smarty_tpl->tpl_vars['newPage']->value),$_smarty_tpl->tpl_vars['url']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value==$_smarty_tpl->tpl_vars['current']->value ? 'class="pag active"' : '', null, 0);?><?php $_smarty_tpl->_capture_stack[0][] = array('default', 'lastPageUrl', null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8');?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><a <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 href="<?php echo $_smarty_tpl->tpl_vars['lastPageUrl']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value+1;?>
</a> <?php } ?><?php if (!empty($_smarty_tpl->tpl_vars['NextPageUrl']->value)){?><?php $_smarty_tpl->tpl_vars['newPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['current']->value+2, null, 0);?><?php $_smarty_tpl->tpl_vars['NextPageUrl'] = new Smarty_variable(preg_replace('!/page[_\-][0-9]+!i',"/page-".($_smarty_tpl->tpl_vars['newPage']->value),$_smarty_tpl->tpl_vars['NextPageUrl']->value), null, 0);?><a class="pag-next" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['NextPageUrl']->value, ENT_QUOTES, 'UTF-8');?>
">&gt;</a><?php $_smarty_tpl->tpl_vars['NextPageUrl'] = new Smarty_variable($_smarty_tpl->tpl_vars['NextPageUrl']->value, null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars['NextPageUrl'] = clone $_smarty_tpl->tpl_vars['NextPageUrl']; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars['NextPageUrl'] = clone $_smarty_tpl->tpl_vars['NextPageUrl'];?><?php }?></div></div><?php if (!empty($_GET['ajax'])){?><?php if (!empty($_GET['getlastpage'])){?><?php $_smarty_tpl->tpl_vars['lastPageUrl'] = new Smarty_variable(preg_replace('/^(.*?)[\?\#].*$/u','$1',$_smarty_tpl->tpl_vars['lastPageUrl']->value), null, 0);?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['stopPage'][0][0]->stopPage(array('msg'=>$_smarty_tpl->tpl_vars['lastPageUrl']->value),$_smarty_tpl);?>
<?php }?><?php }?><?php }?>
<?php }} ?>