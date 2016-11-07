<?php /* Smarty version Smarty-3.1.8, created on 2016-11-06 14:12:22
         compiled from "design/lemanta/html\common\main-nav.htm" */ ?>
<?php /*%%SmartyHeaderCode:1145581dee0a5d2ca7-24122141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4170c5054d98813bd171d38b75695faf1a9a9c3' => 
    array (
      0 => 'design/lemanta/html\\common\\main-nav.htm',
      1 => 1478430741,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1145581dee0a5d2ca7-24122141',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_581dee0a658ef6_69840112',
  'variables' => 
  array (
    'menuTop' => 0,
    'item' => 0,
    'helper' => 0,
    'id' => 0,
    'sid' => 0,
    'class' => 0,
    'name' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581dee0a658ef6_69840112')) {function content_581dee0a658ef6_69840112($_smarty_tpl) {?><?php if (empty($_smarty_tpl->tpl_vars['menuTop']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['menuByLangTechName'][0][0]->menuByLangTechName(array('name'=>'Верхнее меню','attach'=>'sections, categories','assign'=>'menuTop','scope'=>'global'),$_smarty_tpl);?>
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
" title="Интернет-магазин одежды от производителя" alt="Интернет-магазин одежды в розницу"><i class="fa fa-home"></i></a></li><?php }else{ ?><li <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li><?php }?><?php }?><?php } ?><?php }?><?php }?>
<?php }} ?>