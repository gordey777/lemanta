<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:00:41
         compiled from "/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/users.htm" */ ?>
<?php /*%%SmartyHeaderCode:93519244657d5b7e92517f8-34806290%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5eb59f4c32cc9870d7cb070570a31a94fe2f18a1' => 
    array (
      0 => '/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/users.htm',
      1 => 1462406575,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93519244657d5b7e92517f8-34806290',
  'function' => 
  array (
    'show_users' => 
    array (
      'parameter' => 
      array (
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
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b7e928fe23_37143051',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b7e928fe23_37143051')) {function content_57d5b7e928fe23_37143051($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?>

  <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>
    <?php $_smarty_tpl->_capture_stack[0][] = array('default', "object_id", null); ob_start(); ?>USERS<?php echo smarty_function_math(array('equation'=>"rand(1, 100000000)"),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (!function_exists('smarty_template_function_show_users')) {
    function smarty_template_function_show_users($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_users']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php $_smarty_tpl->tpl_vars["iteration"] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?><?php $_smarty_tpl->tpl_vars["iteration"] = new Smarty_variable($_smarty_tpl->tpl_vars['iteration']->value+1, null, 0);?><?php $_smarty_tpl->_capture_stack[0][] = array('default', "this_topic", null); ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['topic']->value;?>
<?php echo $_smarty_tpl->tpl_vars['iteration']->value;?>
.<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (isset($_smarty_tpl->tpl_vars['selector']->value)&&($_smarty_tpl->tpl_vars['selector']->value===true)){?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->user_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['currents']->value)&&((is_array($_smarty_tpl->tpl_vars['currents']->value)&&in_array($_smarty_tpl->tpl_vars['c']->value->user_id,$_smarty_tpl->tpl_vars['currents']->value))||(!is_array($_smarty_tpl->tpl_vars['currents']->value)&&($_smarty_tpl->tpl_vars['c']->value->user_id==$_smarty_tpl->tpl_vars['currents']->value)))){?> selected<?php }?><?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?> class="disabled"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]);
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
 <?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->compound_name, ENT_QUOTES, 'UTF-8');?>
</option><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->subusers)){?><?php smarty_template_function_show_users($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['c']->value->subusers,'level'=>$_smarty_tpl->tpl_vars['level']->value+1,'topic'=>$_smarty_tpl->tpl_vars['this_topic']->value));?>
<?php }?><?php }?><?php } ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php smarty_template_function_show_users($_smarty_tpl,array('items'=>$_smarty_tpl->tpl_vars['items']->value,'level'=>0,'topic'=>''));?>

  <?php }?>
<?php }} ?>