<?php /* Smarty version Smarty-3.1.8, created on 2016-09-13 15:44:36
         compiled from "/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/categories.htm" */ ?>
<?php /*%%SmartyHeaderCode:57442255457d7f4b4b948a3-09668214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b0468a49fd1e402c72b122aea4fbaee745db9ad' => 
    array (
      0 => '/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/categories.htm',
      1 => 1462406573,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57442255457d7f4b4b948a3-09668214',
  'function' => 
  array (
    'show_categories' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
        'depth' => 1000000000,
        'topic' => '',
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'items' => 0,
    'iteration' => 0,
    'topic' => 0,
    'selector' => 0,
    'c' => 0,
    'currents' => 0,
    'level' => 0,
    'topics' => 0,
    'this_topic' => 0,
    'counter' => 0,
    'depth' => 0,
    'flatlist' => 0,
    'object_id' => 0,
    'editable' => 0,
    'fulledit' => 0,
    'moveedit' => 0,
    'value' => 0,
    'fullinfo' => 0,
    'maxdepth' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d7f4b4ce9332_70351382',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d7f4b4ce9332_70351382')) {function content_57d7f4b4ce9332_70351382($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?>

  <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>
    <?php $_smarty_tpl->_capture_stack[0][] = array('default', "object_id", null); ob_start(); ?>CATEGORIES<?php echo smarty_function_math(array('equation'=>"rand(1, 100000000)"),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>



    
    <?php if (!function_exists('smarty_template_function_show_categories')) {
    function smarty_template_function_show_categories($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_categories']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>

      <?php $_smarty_tpl->tpl_vars['iteration'] = new Smarty_variable(0, null, 0);?>
      <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
        <?php $_smarty_tpl->tpl_vars['iteration'] = new Smarty_variable($_smarty_tpl->tpl_vars['iteration']->value+1, null, 0);?><?php $_smarty_tpl->_capture_stack[0][] = array('default', "this_topic", null); ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['topic']->value;?>
<?php echo $_smarty_tpl->tpl_vars['iteration']->value;?>
.<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (isset($_smarty_tpl->tpl_vars['selector']->value)&&($_smarty_tpl->tpl_vars['selector']->value===true)){?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['currents']->value)&&((is_array($_smarty_tpl->tpl_vars['currents']->value)&&in_array($_smarty_tpl->tpl_vars['c']->value->category_id,$_smarty_tpl->tpl_vars['currents']->value))||(!is_array($_smarty_tpl->tpl_vars['currents']->value)&&($_smarty_tpl->tpl_vars['c']->value->category_id==$_smarty_tpl->tpl_vars['currents']->value)))){?> selected<?php }?><?php if (!$_smarty_tpl->tpl_vars['c']->value->enabled||($_smarty_tpl->tpl_vars['c']->value->products_count<1)){?> class="<?php if ($_smarty_tpl->tpl_vars['c']->value->products_count<1){?>empty <?php }?><?php if (!$_smarty_tpl->tpl_vars['c']->value->enabled){?>disabled<?php }?>"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['name'] = "spaces";
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['level']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php if (isset($_smarty_tpl->tpl_vars['topics']->value)&&($_smarty_tpl->tpl_vars['topics']->value===true)){?><?php echo $_smarty_tpl->tpl_vars['this_topic']->value;?>
 <?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
<?php if (isset($_smarty_tpl->tpl_vars['counter']->value)&&($_smarty_tpl->tpl_vars['counter']->value===true)){?> [<?php echo $_smarty_tpl->tpl_vars['c']->value->products_count;?>
 шт.]<?php }?></option><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->subcategories)&&$_smarty_tpl->tpl_vars['depth']->value>$_smarty_tpl->tpl_vars['level']->value+1){?><?php smarty_template_function_show_categories($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1,'depth'=>$_smarty_tpl->tpl_vars['depth']->value,'topic'=>$_smarty_tpl->tpl_vars['this_topic']->value));?>
<?php }?><?php }else{ ?><li<?php if (isset($_smarty_tpl->tpl_vars['c']->value->subcategories)&&!empty($_smarty_tpl->tpl_vars['c']->value->subcategories)){?> class="root"<?php }?><?php if ((!isset($_smarty_tpl->tpl_vars['flatlist']->value)||($_smarty_tpl->tpl_vars['flatlist']->value!==true))&&isset($_smarty_tpl->tpl_vars['c']->value->subcategories)&&!empty($_smarty_tpl->tpl_vars['c']->value->subcategories)){?> onmouseover="javascript: Switch_<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
', true);" onmouseout="javascript: Switch_<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
', false);"<?php }?> onDblClick="javascript: jQuery(this).find('ul:first').toggle(); event.cancelBubble = true;"><?php if (isset($_smarty_tpl->tpl_vars['editable']->value)&&($_smarty_tpl->tpl_vars['editable']->value===true)){?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="javascript: return confirm('Данная категория будет удалена с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_delete_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><?php if (!empty($_smarty_tpl->tpl_vars['moveedit']->value)){?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_first_get, ENT_QUOTES, 'UTF-8');?>
" title="Поставить первой в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_first_16x16.png" /></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_up_get, ENT_QUOTES, 'UTF-8');?>
" title="Поднять выше в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_up_16x16.png" /></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_down_get, ENT_QUOTES, 'UTF-8');?>
" title="Опустить ниже в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_down_16x16.png" /></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_last_get, ENT_QUOTES, 'UTF-8');?>
" title="Поставить последней в ветке (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_last_16x16.png" /></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif" /><span class="browsed zero" title="Вес"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'c->order_num'),$_smarty_tpl);?>
</span><?php }?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->informative_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать / не считать информативной страницей"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_informative<?php if ($_smarty_tpl->tpl_vars['c']->value->informative!=1){?>_off<?php }?>_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->domained_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить собственный субдомен"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_domained<?php if ($_smarty_tpl->tpl_vars['c']->value->subdomain_enabled!=1){?>_off<?php }?>_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->hidden_get, ENT_QUOTES, 'UTF-8');?>
" title="Скрыть / открыть для незарегистрированных пользователей"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_hidden<?php if ($_smarty_tpl->tpl_vars['c']->value->hidden!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->ymarket_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить экспорт в Яндекс.Маркет"><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['c']->value->ymarket)===null||$tmp==='' ? 0 : $tmp)&1, null, 0);?><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_ymarket<?php if (!$_smarty_tpl->tpl_vars['value']->value){?>_off<?php }?>_16x16.png"></a><?php }?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['counter']->value)&&($_smarty_tpl->tpl_vars['counter']->value===true)&&isset($_smarty_tpl->tpl_vars['c']->value->products_count)){?><span<?php if ($_smarty_tpl->tpl_vars['c']->value->products_count<1){?> class="empty" title="Не содержит товаров"<?php }else{ ?> class="count" title="Содержит <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->products_count, ENT_QUOTES, 'UTF-8');?>
 товаров<?php if (isset($_smarty_tpl->tpl_vars['c']->value->my_products_count)&&($_smarty_tpl->tpl_vars['c']->value->my_products_count!=$_smarty_tpl->tpl_vars['c']->value->products_count)){?> (из них личных <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->my_products_count, ENT_QUOTES, 'UTF-8');?>
)<?php }?>"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->products_count, ENT_QUOTES, 'UTF-8');?>
</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['counter']->value)&&($_smarty_tpl->tpl_vars['counter']->value===true)){?><span class="count" title="Количество просмотров: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['flatlist']->value)&&($_smarty_tpl->tpl_vars['flatlist']->value===true)){?><?php if (isset($_smarty_tpl->tpl_vars['c']->value->subcategories)&&!empty($_smarty_tpl->tpl_vars['c']->value->subcategories)&&(count($_smarty_tpl->tpl_vars['c']->value->subcategories)>0)){?><span class="nesting" title="Содержит <?php echo count($_smarty_tpl->tpl_vars['c']->value->subcategories);?>
 вложенных"><?php echo count($_smarty_tpl->tpl_vars['c']->value->subcategories);?>
</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['c']->value->parents)&&(count($_smarty_tpl->tpl_vars['c']->value->parents)>1)){?><span class="attach" title="Имеет <?php echo count($_smarty_tpl->tpl_vars['c']->value->parents);?>
 прикрепления"><?php echo count($_smarty_tpl->tpl_vars['c']->value->parents);?>
</span><?php }?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['topics']->value)&&($_smarty_tpl->tpl_vars['topics']->value===true)){?><span class="topic"><?php echo $_smarty_tpl->tpl_vars['this_topic']->value;?>
</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['currents']->value)&&((is_array($_smarty_tpl->tpl_vars['currents']->value)&&in_array($_smarty_tpl->tpl_vars['c']->value->category_id,$_smarty_tpl->tpl_vars['currents']->value))||(!is_array($_smarty_tpl->tpl_vars['currents']->value)&&($_smarty_tpl->tpl_vars['c']->value->category_id==$_smarty_tpl->tpl_vars['currents']->value)))){?><?php if ($_smarty_tpl->tpl_vars['c']->value->highlighted){?><b><?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
<?php if ($_smarty_tpl->tpl_vars['c']->value->highlighted){?></b><?php }?><?php }else{ ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
"<?php if (!$_smarty_tpl->tpl_vars['c']->value->enabled){?> class="disabled" title="Не разрешен показ на сайте"<?php }?>><?php if ($_smarty_tpl->tpl_vars['c']->value->highlighted){?><b><?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
<?php if ($_smarty_tpl->tpl_vars['c']->value->highlighted){?></b><?php }?></a><?php }?><?php if (isset($_smarty_tpl->tpl_vars['fullinfo']->value)&&($_smarty_tpl->tpl_vars['fullinfo']->value===true)){?>&nbsp;<a class="maximize" href="#" onclick="javascript: this.text = Switch_<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
_info', '*') ? '[-]' : '[+]'; return false;" title="Показать / скрыть карточку">[+]</a><div class="info" id="<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
_info"><div class="param">название<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="name[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">ед.число<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="single_name[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->single_name), ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->single_name), ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">url<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="url[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->url, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">субдомен<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="subdomain[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->subdomain, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->subdomain, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">title<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="meta_title[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->meta_title, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->meta_title, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">keywords<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="meta_keywords[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->meta_keywords, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->meta_keywords, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">description<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="meta_description[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->meta_description, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->meta_description, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">вес<div class="value"><?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input name="order_num[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php }?></div></div><div class="param">id<div class="value"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php if (isset($_smarty_tpl->tpl_vars['fulledit']->value)&&($_smarty_tpl->tpl_vars['fulledit']->value===true)){?><input class="submit" name="post[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
]" type="submit" value="ok"><?php }?></div></div></div><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->subcategories)&&$_smarty_tpl->tpl_vars['depth']->value>$_smarty_tpl->tpl_vars['level']->value+1){?><ul<?php if (!isset($_smarty_tpl->tpl_vars['flatlist']->value)||($_smarty_tpl->tpl_vars['flatlist']->value!==true)){?> id="<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->category_id, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
" style="display: none; position: absolute; z-index: 1;"<?php }?>><?php smarty_template_function_show_categories($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1,'depth'=>$_smarty_tpl->tpl_vars['depth']->value,'topic'=>$_smarty_tpl->tpl_vars['this_topic']->value));?>
</ul><?php }?></li><?php }?>
      <?php } ?>
    <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


    
    <?php smarty_template_function_show_categories($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['items']->value,'level'=>0,'depth'=>(($tmp = @$_smarty_tpl->tpl_vars['maxdepth']->value)===null||$tmp==='' ? 1000000000 : $tmp),'topic'=>''));?>


    <?php if (!isset($_smarty_tpl->tpl_vars['selector']->value)||($_smarty_tpl->tpl_vars['selector']->value!==true)){?>
      
        <!-- Скрипт для раскрытия / сокрытия выпадающих элементов -->

        <script language="JavaScript" type="text/javascript">
          <!--
          function Switch_<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
(id, state) {
            var object = document.getElementById('<?php echo $_smarty_tpl->tpl_vars['object_id']->value;?>
_' + id);
            if ((typeof(object) == 'object') && (object != null)) {
              if (state == '*') state = !object.style.display || (object.style.display == 'none');
              object.style.display = (state == true) ? 'block' : 'none';
              return state;
            }
            return false;
          }
          // -->
        </script>
      
    <?php }?>

  <?php }?>
<?php }} ?>