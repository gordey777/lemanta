<?php /* Smarty version Smarty-3.1.8, created on 2016-09-29 10:06:31
         compiled from "../admin/design/default/html/price_editor/price_editor.htm" */ ?>
<?php /*%%SmartyHeaderCode:111612030857ecbd77ccdc67-08701403%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fc58b52f10a5a40f27d36478d88976464a651e1' => 
    array (
      0 => '../admin/design/default/html/price_editor/price_editor.htm',
      1 => 1462406656,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '111612030857ecbd77ccdc67-08701403',
  'function' => 
  array (
    'row_category' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
        'enabled' => true,
      ),
      'compiled' => '',
    ),
    'row_product' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
        'enabled' => true,
      ),
      'compiled' => '',
    ),
    'row_variant' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
        'enabled' => true,
        'last' => false,
      ),
      'compiled' => '',
    ),
    'cats_filter_tree' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
    'cats_tree' => 
    array (
      'parameter' => 
      array (
        'level' => 1,
        'enabled' => true,
        'selected' => false,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'module_pointer' => 0,
    'currency' => 0,
    'admin_site' => 0,
    'title' => 0,
    'message' => 0,
    'error' => 0,
    'item' => 0,
    'url' => 0,
    'enabled' => 0,
    'level' => 0,
    'site' => 0,
    'admin_theme' => 0,
    'variant' => 0,
    'param' => 0,
    'vid' => 0,
    'value' => 0,
    'rate' => 0,
    'last' => 0,
    'admin_goto' => 0,
    'inputs' => 0,
    'items' => 0,
    'cats' => 0,
    'c' => 0,
    'selected' => 0,
    'enabled_category' => 0,
    'real_selected' => 0,
    'r' => 0,
    'enabled_product' => 0,
    'i' => 0,
    'v' => 0,
    'token' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57ecbd77e80740_12288809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ecbd77e80740_12288809')) {function content_57ecbd77e80740_12288809($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['module_pointer'] = new Smarty_variable((($tmp = @@PRICEEDITOR_MODULELINK_POINTER)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php echo $_smarty_tpl->getSubTemplate ('../../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('main'=>true,'me'=>(($tmp = @@PRICEEDITOR_MODULETAB_TEXT)===null||$tmp==='' ? '' : $tmp),'me_pointer'=>$_smarty_tpl->tpl_vars['module_pointer']->value,'me_menupath'=>(($tmp = @@PRICEEDITOR_MODULEMENU_PATH)===null||$tmp==='' ? '' : $tmp),'select'=>'me'), 0);?>
<?php echo $_smarty_tpl->getSubTemplate ('common/functions.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php $_smarty_tpl->tpl_vars['rate'] = new Smarty_variable(((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)), null, 0);?><?php $_smarty_tpl->tpl_vars['sign'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '?' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><style>#items_form .table-pricelist {border: 0 solid;border-top: #ccc 1px solid;border-right: #ccc 1px solid;margin: 0;padding: 0;width: 100%;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;}#items_form .table-pricelist td {border: 0 solid;border-left: #ccc 1px solid;border-bottom: #ccc 1px solid;color: #222;font-family: Verdana, Tahoma, Arial;font-size: 8pt;line-height: 20px;margin: 0;padding: 0;text-align: left;vertical-align: top;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;}/* строки таблицы */#items_form .table-pricelist .row-product:hover,#items_form .table-pricelist .row-variant:hover {background: #f4f4f4;}#items_form .table-pricelist .row-category td {background: #eee;}#items_form .table-pricelist .row-product td {}#items_form .table-pricelist .row-variant td {}#items_form .table-pricelist tr.disabled * {color: #ccc !important;}/* заголовки колонок */#items_form .table-pricelist .cell-th {background: #ddd !important;color: #aaa;font-size: 8pt;padding: 4px 10px;width: 1px;text-align: center;vertical-align: middle;}/* поле ввода */#items_form .table-pricelist td span {display: block;margin: 0;padding: 0;width: 100%;position: relative;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;}#items_form .table-pricelist input[type="text"] {background: transparent;border: 0 solid;outline: 0 solid;color: #222;display: block;font-family: Verdana, Tahoma, Arial;font-size: 8pt;font-weight: normal;line-height: 16px;height: 24px;margin: 0;padding: 5px 10px;width: 100%;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;}#items_form .table-pricelist span:hover > input[type="text"] {background: #d0d0d0;}/* поле Название */#items_form .table-pricelist .cell-name {padding: 2px 10px;width: 100%;}#items_form .table-pricelist .cell-name a {opacity: 0.4;}#items_form .table-pricelist .cell-name a:hover {opacity: 1.0;}/* поле Буквенный код товара */#items_form .table-pricelist .cell-pcode {color: #888;display: none;font-size: 8pt;padding: 2px 10px;width: 1px;}/* поле Артикул варианта товара */#items_form .table-pricelist .cell-sku {color: #888;font-size: 8pt;padding: 2px 10px;width: 1px;}/* поле Название варианта товара */#items_form .table-pricelist .cell-variant {color: #888;font-size: 8pt;padding: 2px 10px;width: 1px;}/* поле Цены варианта товара */#items_form .table-pricelist .cell-price,#items_form .table-pricelist .cell-oldprice,#items_form .table-pricelist .cell-tempprice,#items_form .table-pricelist .cell-discount,#items_form .table-pricelist .cell-stock {background: #fff;width: 1px;}#items_form .table-pricelist .cell-price {border-left: #ccc 3px solid;}#items_form .table-pricelist .cell-oldprice {background: #fff4f4;}#items_form .table-pricelist .cell-tempprice {background: #efe;}#items_form .table-pricelist .cell-discount {background: #f8f8f8;}#items_form .table-pricelist .cell-price input[type="text"],#items_form .table-pricelist .cell-oldprice input[type="text"],#items_form .table-pricelist .cell-tempprice input[type="text"] {width: 95px;max-width: 95px;min-width: 95px;text-align: right;}#items_form .table-pricelist .cell-discount input[type="text"] {width: 65px;max-width: 65px;min-width: 65px;text-align: right;}#items_form .table-pricelist .cell-stock input[type="text"] {width: 60px;max-width: 60px;min-width: 60px;text-align: right;}/* фиктивная ячейка */#items_form .table-pricelist .cell-dummy + .cell-dummy {border-left: transparent 1px solid;}#items_form .table-pricelist .row-variant:not(.last-variant) .cell-dummy {border-bottom: transparent 1px solid;}/* отредактированное поле */#items_form .table-pricelist input.changed {color: #44f !important;}/* кнопка Сохранить */#items_form input[type="submit"] {background: #ddd;border: #bbb 1px solid;outline: 0px solid;color: #47b;display: block;float: none;font-size: 8pt;margin: 20px 0;padding: 0 10px;text-decoration: none;cursor: pointer;height: 25px;width: 120px;}#items_form input[type="submit"]:hover {background: #bbb;border: #999 1px solid;color: #000;}</style><div class="box"><h1><div class="path"><a href="<?php echo $_smarty_tpl->tpl_vars['admin_site']->value;?>
" title="Перейти на главную страницу админпанели">Главная</a> → Цены</div><?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? 'Редактор цен' : $tmp)), ENT_QUOTES, 'UTF-8');?>
</h1><div class="toolkey"><a class="left" href="#help" onclick="Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;</div><?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="message"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div><?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?><div class="error"><b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div><?php }?><?php if (!function_exists('smarty_template_function_row_category')) {
    function smarty_template_function_row_category($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['row_category']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(trim((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url)===null||$tmp==='' ? '' : $tmp)), null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_smarty_tpl->tpl_vars['url']->value!='' ? $_smarty_tpl->tpl_vars['url']->value : (!empty($_smarty_tpl->tpl_vars['item']->value->category_id) ? $_smarty_tpl->tpl_vars['item']->value->category_id : ''), null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><tr class="row-category<?php echo $_smarty_tpl->tpl_vars['enabled']->value ? '' : ' disabled';?>
"><td class="cell-name" colspan="9" style="padding-left: <?php echo ($_smarty_tpl->tpl_vars['level']->value-1)*20+10;?>
px;"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url_path)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" target="_blank" title="Открыть страницу этой категории на сайте"><img src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/microicon_showall_9x9.png" /></a> &nbsp; <?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['item']->value,'param'=>'name','def'=>'Без названия!','escaped'=>true));?>
</td></tr><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><?php if (!function_exists('smarty_template_function_row_product')) {
    function smarty_template_function_row_product($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['row_product']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(trim((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url)===null||$tmp==='' ? '' : $tmp)), null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable($_smarty_tpl->tpl_vars['url']->value!='' ? $_smarty_tpl->tpl_vars['url']->value : (!empty($_smarty_tpl->tpl_vars['item']->value->product_id) ? $_smarty_tpl->tpl_vars['item']->value->product_id : ''), null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8'), null, 0);?><?php  $_smarty_tpl->tpl_vars['variant'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['variant']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['variant']->key => $_smarty_tpl->tpl_vars['variant']->value){
$_smarty_tpl->tpl_vars['variant']->_loop = true;
?><?php break 1?><?php } ?><?php $_smarty_tpl->tpl_vars['vid'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->variant_id)===null||$tmp==='' ? 0 : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><tr class="row-product<?php echo $_smarty_tpl->tpl_vars['enabled']->value ? '' : ' disabled';?>
"><td class="cell-name" style="padding-left: <?php echo $_smarty_tpl->tpl_vars['level']->value*20+10;?>
px;"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['item']->value->url_path)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" target="_blank" title="Открыть страницу этого товара на сайте"><img src="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/microicon_showall_9x9.png" /></a> &nbsp; <?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['item']->value,'param'=>'model','def'=>'Без названия!','escaped'=>true));?>
<?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_POST)===null||$tmp==='' ? '' : $tmp), null, 0);?><input name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" type="hidden" value="" /></td><td class="cell-pcode"><span><?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['item']->value,'param'=>'pcode','def'=>'','escaped'=>true));?>
</span></td><td class="cell-sku"><span><?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['variant']->value,'param'=>'sku','def'=>'','escaped'=>true));?>
</span></td><td class="cell-variant"><span><?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['variant']->value,'param'=>'name','def'=>'','escaped'=>true));?>
</span></td><td class="cell-price"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['value']->value*$_smarty_tpl->tpl_vars['rate']->value)),',','.'), null, 0);?><input name="price[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-oldprice"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->old_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['value']->value*$_smarty_tpl->tpl_vars['rate']->value)),',','.'), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value==0 ? '' : $_smarty_tpl->tpl_vars['value']->value, null, 0);?><input name="old_price[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-tempprice"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->temp_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['value']->value*$_smarty_tpl->tpl_vars['rate']->value)),',','.'), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value==0 ? '' : $_smarty_tpl->tpl_vars['value']->value, null, 0);?><input name="temp_price[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-stock"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(sprintf('%d',((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->stock)===null||$tmp==='' ? 0 : $tmp))), null, 0);?><input name="stock[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="12" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-discount"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['variant']->value->priority_discount)===null||$tmp==='' ? -1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value<0 ? '' : (smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['value']->value),',','.')), null, 0);?><input name="priority_discount[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="6" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td></tr><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><?php if (!function_exists('smarty_template_function_row_variant')) {
    function smarty_template_function_row_variant($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['row_variant']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php ob_start(); smarty_template_function_get_item_string($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['item']->value,'param'=>'variant_id','def'=>'0','escaped'=>true)); $_smarty_tpl->assign('vid', ob_get_clean());?>
<tr class="row-variant<?php echo $_smarty_tpl->tpl_vars['enabled']->value ? '' : ' disabled';?>
<?php echo $_smarty_tpl->tpl_vars['last']->value ? ' last-variant' : '';?>
"><td class="cell-dummy">&nbsp;<?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_POST)===null||$tmp==='' ? '' : $tmp), null, 0);?><input name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" type="hidden" value="" /></td><td class="cell-pcode cell-dummy">&nbsp;</td><td class="cell-codes cell-sku"><span><?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value)===null||$tmp==='' ? false : $tmp),'param'=>'sku','def'=>'','escaped'=>true));?>
</span></td><td class="cell-variant"><span><?php smarty_template_function_get_item_string($_smarty_tpl,array('item'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value)===null||$tmp==='' ? false : $tmp),'param'=>'name','def'=>'','escaped'=>true));?>
</span></td><td class="cell-price"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['value']->value*$_smarty_tpl->tpl_vars['rate']->value)),',','.'), null, 0);?><input name="price[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-oldprice"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->old_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['value']->value*$_smarty_tpl->tpl_vars['rate']->value)),',','.'), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value==0 ? '' : $_smarty_tpl->tpl_vars['value']->value, null, 0);?><input name="old_price[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-tempprice"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->temp_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['value']->value*$_smarty_tpl->tpl_vars['rate']->value)),',','.'), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value==0 ? '' : $_smarty_tpl->tpl_vars['value']->value, null, 0);?><input name="temp_price[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-prices cell-stock"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(sprintf('%d',((($tmp = @$_smarty_tpl->tpl_vars['item']->value->stock)===null||$tmp==='' ? 0 : $tmp))), null, 0);?><input name="stock[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="12" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td><td class="cell-discount"><span><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->priority_discount)===null||$tmp==='' ? -1 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value<0 ? '' : (smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['value']->value),',','.')), null, 0);?><input name="priority_discount[<?php echo $_smarty_tpl->tpl_vars['vid']->value;?>
]" maxlength="6" type="text" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" onchange="checkInputboxChanges(this);" onkeyup="checkInputboxChanges(this);" /></span></td></tr><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<form action="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_pointer']->value, ENT_QUOTES, 'UTF-8');?>
" id="items_form" method="post" onkeypress="return Ignore_KeypressSubmit(event);"><table align="center" cellpadding="0" cellspacing="8" class="white"><tr><td class="param_short"><a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
Categories" title="Перейти на страницу категорий в админпанели">Категория</a>:</td><td class="value" width="100%" title="Фильтр: только принадлежащие такой категории"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_FILTER_CATEGORY)===null||$tmp==='' ? '' : $tmp), null, 0);?><select class="thin" id="items_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');"><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['param']->value])===null||$tmp==='' ? '' : $tmp), null, 0);?><?php if ($_smarty_tpl->tpl_vars['param']->value==''){?><option value=""></option><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php if (!function_exists('smarty_template_function_cats_filter_tree')) {
    function smarty_template_function_cats_filter_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['cats_filter_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->filled)){?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['c']->value->category_id)===null||$tmp==='' ? '' : $tmp), null, 0);?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['param']->value==$_smarty_tpl->tpl_vars['value']->value){?> selected<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['name'] = 'spaces';
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['spaces']['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo (($tmp = @$_smarty_tpl->tpl_vars['c']->value->name)===null||$tmp==='' ? 'Без названия!' : $tmp);?>
</option><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->subitems)){?><?php smarty_template_function_cats_filter_tree($_smarty_tpl,array('cats'=>$_smarty_tpl->tpl_vars['c']->value->subitems,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>
<?php }?><?php }?><?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_cats_filter_tree($_smarty_tpl,array('cats'=>$_smarty_tpl->tpl_vars['items']->value));?>
<?php }?><option value="0" style="color: #888" <?php if ($_smarty_tpl->tpl_vars['param']->value!=''&&$_smarty_tpl->tpl_vars['param']->value==0){?> selected<?php }?>>[весь каталог]</option></select></td></tr></table><div class="toolkey">&nbsp;</div><?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @@REQUEST_PARAM_NAME_FILTER_CATEGORY)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['param']->value])===null||$tmp==='' ? '' : $tmp)!=''){?><table class="table-pricelist" border="0" cellpadding="0" cellspacing="0"><tr><td class="cell-th" nowrap>название</td><td class="cell-pcode cell-th" nowrap>код</td><td class="cell-th" nowrap>артикул</td><td class="cell-th" nowrap>вариант</td><td class="cell-price cell-th" nowrap>цена</td><td class="cell-th" nowrap>старая</td><td class="cell-th" nowrap>акция</td><td class="cell-th" nowrap>склад</td><td class="cell-th" nowrap>скидка</td></tr><?php if (!function_exists('smarty_template_function_cats_tree')) {
    function smarty_template_function_cats_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['cats_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->filled)){?><?php if ($_smarty_tpl->tpl_vars['selected']->value||!empty($_smarty_tpl->tpl_vars['c']->value->selected)){?><?php $_smarty_tpl->tpl_vars['real_selected'] = new Smarty_variable($_smarty_tpl->tpl_vars['selected']->value||!empty($_smarty_tpl->tpl_vars['c']->value->selected)&&$_smarty_tpl->tpl_vars['c']->value->selected===true, null, 0);?><?php $_smarty_tpl->tpl_vars['enabled_category'] = new Smarty_variable($_smarty_tpl->tpl_vars['enabled']->value&&!empty($_smarty_tpl->tpl_vars['c']->value->enabled), null, 0);?><?php smarty_template_function_row_category($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['c']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value,'enabled'=>$_smarty_tpl->tpl_vars['enabled_category']->value));?>
<?php if ($_smarty_tpl->tpl_vars['real_selected']->value){?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->products)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['enabled_product'] = new Smarty_variable($_smarty_tpl->tpl_vars['enabled_category']->value&&!empty($_smarty_tpl->tpl_vars['r']->value->enabled), null, 0);?><?php smarty_template_function_row_product($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['r']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value,'enabled'=>$_smarty_tpl->tpl_vars['enabled_product']->value));?>
<?php if (!empty($_smarty_tpl->tpl_vars['r']->value->variants)&&count($_smarty_tpl->tpl_vars['r']->value->variants)>1){?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['v']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->iteration++;
 $_smarty_tpl->tpl_vars['v']->last = $_smarty_tpl->tpl_vars['v']->iteration === $_smarty_tpl->tpl_vars['v']->total;
?><?php if ($_smarty_tpl->tpl_vars['i']->value!=0){?><?php smarty_template_function_row_variant($_smarty_tpl,array('item'=>$_smarty_tpl->tpl_vars['v']->value,'level'=>$_smarty_tpl->tpl_vars['level']->value,'enabled'=>$_smarty_tpl->tpl_vars['enabled_product']->value,'last'=>$_smarty_tpl->tpl_vars['v']->last));?>
<?php }?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?><?php } ?><?php }?><?php } ?><?php }?><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->subitems)){?><?php smarty_template_function_cats_tree($_smarty_tpl,array('cats'=>$_smarty_tpl->tpl_vars['c']->value->subitems,'level'=>$_smarty_tpl->tpl_vars['level']->value+1,'enabled'=>$_smarty_tpl->tpl_vars['enabled_category']->value,'selected'=>$_smarty_tpl->tpl_vars['real_selected']->value));?>
<?php }?><?php }?><?php }?><?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_cats_tree($_smarty_tpl,array('cats'=>$_smarty_tpl->tpl_vars['items']->value));?>
</table><input class="submit" type="submit" value="Сохранить" onclick="return Start_PageMassPost('items_form');" /><?php smarty_template_function_hidden_editbox($_smarty_tpl,array('param'=>'REQUEST_PARAM_NAME_ACTION','id'=>true,'value'=>''));?>
<?php smarty_template_function_hidden_editbox($_smarty_tpl,array('param'=>'REQUEST_PARAM_NAME_IGNORE_POST','id'=>true,'value'=>'1'));?>
<?php smarty_template_function_hidden_editbox($_smarty_tpl,array('param'=>'REQUEST_PARAM_NAME_POST_MINI','id'=>false,'value'=>'1'));?>
<?php smarty_template_function_hidden_editbox($_smarty_tpl,array('param'=>'REQUEST_PARAM_NAME_TOKEN','id'=>false,'value'=>$_smarty_tpl->tpl_vars['token']->value));?>
<?php }else{ ?><div class="noitems">Выберите необходимую категорию в фильтре.</div><?php }?><?php }else{ ?><div class="noitems">Каталог пустой.</div><?php }?></form><script language="JavaScript" type="text/javascript">if (typeof(checkInputboxChanges) != 'function') {function checkInputboxChanges ( ptr ) {try {var prev = ptr.defaultValue;var value = ptr.value;var changed = value != prev;jQuery(ptr).removeClass('changed');if (changed) jQuery(ptr).removeClass('incorrect').addClass('changed');return changed;} catch (e) { }return false;}}</script><a name="help"></a><div class="help" id="help_box"><div class="title">Справка</div><div>Для работы этой страницы необходимо, чтобы в настройках PHP значение параметра <i>max_input_vars</i> было не менее чем число редактируемых строк таблицы, умноженное на количество редактируемых столбцов. Иначе PHP будет отсекать обработку тех "избыточных" input-элементов формы ввода, что содержатся в форме сверх заданного ограничения. В результате это может привести к порче информации, поэтому рекомендуется <a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
PHPinfo">убедиться</a>, что упомянутый параметр содержит достаточное значение, а еще лучше с запасом.</div><div><b>Фильтр</b> : <b>Категория</b>. Дает возможность работать только со списком товаров конкретной категории и ее подкатегорий. Из этого фильтра исключены пустые категории, чтобы не загромождать фильтр.</div><div>В конце фильтра находится пункт <i>[весь каталог]</i>, чтобы можно было работать с полным списком товаров. Однако следует учесть, что на больших каталогах будет ощущаться замедленная работа браузера, что связано с естественным падением скорости при обработке браузером многострочных таблиц.</div><div><b>Скидка</b>. Эта колонка содержит сведения о приоритетных скидках на конкретные товары. Если в этом поле установлен какой-то процент, значит данный товар будет продан именно с такой скидкой, независимо от того, какая величина скидки есть у покупателя. То есть приоритетная скидка всегда имеет приоритет перед пользовательскими скидками и перекрывает их (кстати, на заметку: акционная цена имеет наивысший приоритет и не перекрывается ни одной скидкой).</div><div>Например товар стоит 100 рублей. Предположим, у покупателя сейчас есть скидка 10%. Соответственно он может приобрести товар за 90 рублей. Если теперь в товаре установить приоритетную скидку 1%, тогда товар можно купить только по цене 99 рублей. Если теперь установить акционную цену 95 рублей, товар продастся только по этой цене.</div><div><b>Акция</b>. Эта колонка содержит сведения об акционных ценах на конкретные товары. В паре с колонкой "цена" образуют связку, где поле "цена" по смыслу становится подобным полю "старая цена", причем на акционную цену более не распространяются скидки.</div><div><b>Старая</b>. Эта колонка содержит сведения о старых ценах на конкретные товары. В паре с колонкой "цена" образуют связку, где поле "цена" по смыслу становится подобным полю "акционная цена", однако на эту цену еще дополнительно могут распространяться пользовательские скидки.</div><div>Если заполнены сразу три поля - цена, старая, акция, - тогда поле "старая" игнорируется и ситуация приравнивается к связке двух полей - цена, акция.</div></div></div><?php }} ?>