<?php /* Smarty version Smarty-3.1.8, created on 2016-11-06 12:13:55
         compiled from "design/lemanta/html\common\left-column.htm" */ ?>
<?php /*%%SmartyHeaderCode:45465819dfd5473f12-39870815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b390718d5763435710b12a0eee7be19e0b6da2aa' => 
    array (
      0 => 'design/lemanta/html\\common\\left-column.htm',
      1 => 1478423635,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45465819dfd5473f12-39870815',
  'function' => 
  array (
    'showCategoriesTree' => 
    array (
      'parameter' => 
      array (
        'needRename' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5819dfd55d5a58_84842899',
  'variables' => 
  array (
    'class' => 0,
    'category' => 0,
    'categories' => 0,
    'selectedId' => 0,
    'doHidden' => 0,
    'item' => 0,
    'needRename' => 0,
    'name' => 0,
    'renames' => 0,
    'id' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => 0,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dfd55d5a58_84842899')) {function content_5819dfd55d5a58_84842899($_smarty_tpl) {?><aside class="sidebar <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 col-md-3 col-sm-3 col-md-pull-9 col-sm-pull-9" role="complementary"><div class="title">Категории</div><?php $_smarty_tpl->tpl_vars['selectedId'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['category']->value->category_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php if (true||!isset($_smarty_tpl->tpl_vars['categories']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['categories'][0][0]->categories(array('active'=>$_smarty_tpl->tpl_vars['selectedId']->value,'sort'=>false,'counters'=>true,'assign'=>'categories','scope'=>'global'),$_smarty_tpl);?>
<?php }?><?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable(!empty($_smarty_tpl->tpl_vars['doHidden']->value) ? 'hidden' : '', null, 0);?><?php $_smarty_tpl->tpl_vars['renames'] = new Smarty_variable(array('Комбинезоны для девочек'=>'Комбинезоны','Брюки для девочек'=>'Брюки','Бриджи для девочек'=>'Бриджи','Джинсы для девочек'=>'Джинсы','Костюмы тройки для девочек'=>'Костюмы тройки','Свитера и толстовки для девочек'=>'Свитера','Куртки для девочек'=>'Куртки','Костюмы тройки'=>'Костюмы','Детские платья'=>'Платья','Детские юбки'=>'Юбки','Комбинезоны для мальчиков'=>'Комбинезоны','Брюки для мальчиков'=>'Брюки','Бриджи для мальчиков'=>'Бриджи','Джинсы для мальчиков'=>'Джинсы','Костюмы тройки для мальчиков'=>'Костюмы тройки','Свитера для мальчиков'=>'Свитера','Куртки для мальчиков'=>'Куртки'), null, 0);?><div id="catalog_menu" class="left-menu"><?php if (!function_exists('smarty_template_function_showCategoriesTree')) {
    function smarty_template_function_showCategoriesTree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['showCategoriesTree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (!empty($_smarty_tpl->tpl_vars['categories']->value)){?><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->enabled)&&!empty($_smarty_tpl->tpl_vars['item']->value->products_count)){?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->category_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['flagClasses'][0][0]->flagClasses(array('flags'=>array('active'=>'selected'),'assign'=>'class'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('assign'=>'name'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['needRename']->value)){?><?php if (isset($_smarty_tpl->tpl_vars['renames']->value[$_smarty_tpl->tpl_vars['name']->value])){?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable($_smarty_tpl->tpl_vars['renames']->value[$_smarty_tpl->tpl_vars['name']->value], null, 0);?><?php }?><?php }?><li><?php if ($_smarty_tpl->tpl_vars['id']->value==$_smarty_tpl->tpl_vars['selectedId']->value){?><a <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 title="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a><?php }else{ ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->subcategories)&&(!empty($_smarty_tpl->tpl_vars['item']->value->active)||$_smarty_tpl->tpl_vars['id']->value==$_smarty_tpl->tpl_vars['selectedId']->value)){?><?php smarty_template_function_showCategoriesTree($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['item']->value->subcategories,'needRename'=>(mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')=='одежда для девочек'||mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')=='одежда для мальчиков')));?>
<?php }?></li><?php }?><?php } ?></ul><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_showCategoriesTree($_smarty_tpl,array());?>
</div><div class="rasp"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/rasp.png" alt="" /><span href="catalog/rasprodazha">Распродажа</span></div><div class="banner"><span href="catalog/odezhda_dlja_malchikov"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['theme'][0][0]->theme(array(),$_smarty_tpl);?>
images/foto.png" alt="" /></span></div><div class="title">Мы вКонтакте</div><div class="vk"><?php if (!empty($_smarty_tpl->tpl_vars['config']->value->vk_group)){?><script src="//vk.com/js/api/openapi.js?105"></script><div id="vk_groups"></div><script>VK.Widgets.Group('vk_groups', { mode: 0,width: '220',height: '260',color1: 'FFFFFF',color2: 'BBBBBB',color3: '88BBEE' }, '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'config->vk_group'),$_smarty_tpl);?>
');</script><?php }?></div></aside><!-- /sidebar -->
<?php }} ?>