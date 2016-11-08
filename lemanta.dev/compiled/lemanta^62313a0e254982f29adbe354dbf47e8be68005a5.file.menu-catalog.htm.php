<?php /* Smarty version Smarty-3.1.8, created on 2016-11-07 13:44:12
         compiled from "design/lemanta/html\common\menu-catalog.htm" */ ?>
<?php /*%%SmartyHeaderCode:12541581f0bc5898931-11770938%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62313a0e254982f29adbe354dbf47e8be68005a5' => 
    array (
      0 => 'design/lemanta/html\\common\\menu-catalog.htm',
      1 => 1478515446,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12541581f0bc5898931-11770938',
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
    'showCategoriesTreeM' => 
    array (
      'parameter' => 
      array (
        'needRename' => 0,
      ),
      'compiled' => '',
    ),
    'showCategoriesTreeS' => 
    array (
      'parameter' => 
      array (
        'needRename' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_581f0bc5923382_46364381',
  'variables' => 
  array (
    'category' => 0,
    'categories' => 0,
    'selectedId' => 0,
    'doHidden' => 0,
    'item' => 0,
    'needRename' => 0,
    'name' => 0,
    'renames' => 0,
    'class' => 0,
  ),
  'has_nocache_code' => 0,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581f0bc5923382_46364381')) {function content_581f0bc5923382_46364381($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['selectedId'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['category']->value->category_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php if (true||!isset($_smarty_tpl->tpl_vars['categories']->value)){?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['categories'][0][0]->categories(array('active'=>$_smarty_tpl->tpl_vars['selectedId']->value,'sort'=>false,'counters'=>true,'assign'=>'categories','scope'=>'global'),$_smarty_tpl);?>
<?php }?><?php $_smarty_tpl->tpl_vars['class'] = new Smarty_variable(!empty($_smarty_tpl->tpl_vars['doHidden']->value) ? 'hidden' : '', null, 0);?><?php $_smarty_tpl->tpl_vars['renames'] = new Smarty_variable(array('Комбинезоны для девочек'=>'Комбинезоны','Брюки для девочек'=>'Брюки','Бриджи для девочек'=>'Бриджи','Джинсы для девочек'=>'Джинсы','Костюмы тройки для девочек'=>'Костюмы тройки','Свитера и толстовки для девочек'=>'Свитера','Куртки для девочек'=>'Куртки','Костюмы тройки'=>'Костюмы','Детские платья'=>'Платья','Детские юбки'=>'Юбки','Комбинезоны для мальчиков'=>'Комбинезоны','Брюки для мальчиков'=>'Брюки','Бриджи для мальчиков'=>'Бриджи','Джинсы для мальчиков'=>'Джинсы','Костюмы тройки для мальчиков'=>'Костюмы тройки','Свитера для мальчиков'=>'Свитера','Куртки для мальчиков'=>'Куртки'), null, 0);?><?php if (!function_exists('smarty_template_function_showCategoriesTreeS')) {
    function smarty_template_function_showCategoriesTreeS($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['showCategoriesTreeS']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (!empty($_smarty_tpl->tpl_vars['categories']->value)){?><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->enabled)&&!empty($_smarty_tpl->tpl_vars['item']->value->products_count)){?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->category_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['flagClasses'][0][0]->flagClasses(array('flags'=>array('active'=>'selected'),'assign'=>'class'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('assign'=>'name'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['needRename']->value)){?><?php if (isset($_smarty_tpl->tpl_vars['renames']->value[$_smarty_tpl->tpl_vars['name']->value])){?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable($_smarty_tpl->tpl_vars['renames']->value[$_smarty_tpl->tpl_vars['name']->value], null, 0);?><?php }?><?php }?><li><a <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->subcategories)){?><?php smarty_template_function_showCategoriesTreeS($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['item']->value->subcategories,'needRename'=>(mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')=='одежда для девочек'||mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')=='одежда для мальчиков')));?>
<?php }?></li><?php }?><?php } ?></ul><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_showCategoriesTreeM')) {
    function smarty_template_function_showCategoriesTreeM($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['showCategoriesTreeM']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (!empty($_smarty_tpl->tpl_vars['categories']->value)){?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->enabled)&&!empty($_smarty_tpl->tpl_vars['item']->value->products_count)){?><?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->category_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['flagClasses'][0][0]->flagClasses(array('flags'=>array('active'=>'selected'),'assign'=>'class'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['name'][0][0]->name(array('assign'=>'name'),$_smarty_tpl);?>
<?php if (!empty($_smarty_tpl->tpl_vars['needRename']->value)){?><?php if (isset($_smarty_tpl->tpl_vars['renames']->value[$_smarty_tpl->tpl_vars['name']->value])){?><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable($_smarty_tpl->tpl_vars['renames']->value[$_smarty_tpl->tpl_vars['name']->value], null, 0);?><?php }?><?php }?><li><a <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
 href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url(array(),$_smarty_tpl);?>
" title="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a><?php if (!empty($_smarty_tpl->tpl_vars['item']->value->subcategories)){?><?php smarty_template_function_showCategoriesTreeS($_smarty_tpl,array('categories'=>$_smarty_tpl->tpl_vars['item']->value->subcategories,'needRename'=>(mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')=='одежда для девочек'||mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')=='одежда для мальчиков')));?>
<?php }?></li><?php }?><?php } ?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_showCategoriesTreeM($_smarty_tpl,array());?>

<?php }} ?>