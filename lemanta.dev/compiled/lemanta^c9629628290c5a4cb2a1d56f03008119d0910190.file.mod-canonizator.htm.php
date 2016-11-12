<?php /* Smarty version Smarty-3.1.8, created on 2016-11-12 13:16:12
         compiled from "design/lemanta/html\mod-canonizator.htm" */ ?>
<?php /*%%SmartyHeaderCode:326805826ebec397729-72145539%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9629628290c5a4cb2a1d56f03008119d0910190' => 
    array (
      0 => 'design/lemanta/html\\mod-canonizator.htm',
      1 => 1478177328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '326805826ebec397729-72145539',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'noCanonical' => 0,
    'uri' => 0,
    'test' => 0,
    'differ' => 0,
    'unCivil' => 0,
    'unCivilAny' => 0,
    'uri2' => 0,
    'noIndex' => 0,
    'noPagination' => 0,
    'PrevPageUrl' => 0,
    'NextPageUrl' => 0,
    'noPrefetch' => 0,
    'noSyndication' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5826ebec3f1c22_42243996',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5826ebec3f1c22_42243996')) {function content_5826ebec3f1c22_42243996($_smarty_tpl) {?><?php if (empty($_smarty_tpl->tpl_vars['noCanonical']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array('except'=>'*','nopages'=>true,'assign'=>'uri'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['requestUri'][0][0]->requestUri(array('except'=>'*','nopages'=>false,'assign'=>'uri2'),$_smarty_tpl);?>
<?php $_smarty_tpl->tpl_vars['test'] = new Smarty_variable((($tmp = @$_SERVER['REQUEST_URI'])===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['differ'] = new Smarty_variable($_smarty_tpl->tpl_vars['uri']->value!=$_smarty_tpl->tpl_vars['test']->value&&!empty($_smarty_tpl->tpl_vars['test']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['differ']->value||!empty($_smarty_tpl->tpl_vars['unCivil']->value)){?><?php if (empty($_smarty_tpl->tpl_vars['unCivil']->value)){?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^[/\\\\]+!','',$_smarty_tpl->tpl_vars['uri']->value), null, 0);?><link rel="canonical" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['uri']->value;?>
" /><?php }elseif(!empty($_smarty_tpl->tpl_vars['unCivilAny']->value)||$_smarty_tpl->tpl_vars['differ']->value||$_smarty_tpl->tpl_vars['uri']->value!=$_smarty_tpl->tpl_vars['uri2']->value){?><?php $_smarty_tpl->tpl_vars['uri2'] = new Smarty_variable(preg_replace('!^[/\\\\]+!','',$_smarty_tpl->tpl_vars['uri2']->value), null, 0);?><link rel="canonical" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['uri2']->value;?>
" /><?php }?><?php if ($_smarty_tpl->tpl_vars['differ']->value&&!empty($_smarty_tpl->tpl_vars['noIndex']->value)){?><meta name="Robots" content="noindex, follow" /><?php }?><?php }?><?php }?><?php if (empty($_smarty_tpl->tpl_vars['noPagination']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['PrevPageUrl']->value)){?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^([^?#]*).*?$!','$1',$_smarty_tpl->tpl_vars['PrevPageUrl']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^[/\\\\]+!','',$_smarty_tpl->tpl_vars['uri']->value), null, 0);?><link rel="prev" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['uri']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['NextPageUrl']->value)){?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^([^?#]*).*?$!','$1',$_smarty_tpl->tpl_vars['NextPageUrl']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^[/\\\\]+!','',$_smarty_tpl->tpl_vars['uri']->value), null, 0);?><link rel="next" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['uri']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><?php }?><?php if (empty($_smarty_tpl->tpl_vars['noPrefetch']->value)){?><?php if (!empty($_smarty_tpl->tpl_vars['NextPageUrl']->value)){?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^([^?#]*).*?$!','$1',$_smarty_tpl->tpl_vars['NextPageUrl']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['uri'] = new Smarty_variable(preg_replace('!^[/\\\\]+!','',$_smarty_tpl->tpl_vars['uri']->value), null, 0);?><link rel="prefetch" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array('root'=>true),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['uri']->value, ENT_QUOTES, 'UTF-8');?>
" /><?php }?><?php }?><?php if (empty($_smarty_tpl->tpl_vars['noSyndication']->value)){?><link rel="alternate" type="application/rss+xml" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
rss" /><?php }?><?php }} ?>