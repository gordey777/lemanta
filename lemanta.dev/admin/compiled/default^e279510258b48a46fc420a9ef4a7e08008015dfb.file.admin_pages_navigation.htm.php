<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:30
         compiled from "../admin/design/default/html/admin_pages_navigation.htm" */ ?>
<?php /*%%SmartyHeaderCode:89623054757d5b6b277a932-10582737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e279510258b48a46fc420a9ef4a7e08008015dfb' => 
    array (
      0 => '../admin/design/default/html/admin_pages_navigation.htm',
      1 => 1462406603,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '89623054757d5b6b277a932-10582737',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CurrentPage' => 0,
    'Pages' => 0,
    'temp_count' => 0,
    'temp_size' => 0,
    'temp_left' => 0,
    'temp_right' => 0,
    'page' => 0,
    'CurrentPageMaxsize' => 0,
    'total_items' => 0,
    'PrevPageUrl' => 0,
    'NextPageUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6b2805152_36660261',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6b2805152_36660261')) {function content_57d5b6b2805152_36660261($_smarty_tpl) {?><!--  -->

  <div class="navigator">

    <!-- Выводим скрытые кнопки массовых операций -->
    <input class="mass_submit disabled_button" disabled name="delete_selected_button" type="button" value="Удалить" onclick="javascript: if (confirm('Это действие удалит записи, помеченные на текущей странице. Вы подтверждаете такую операцию?')) Start_PageMassDelete('items_form');" title="Удалить помеченные на этой странице записи">
    <input class="mass_submit disabled_button" disabled name="accept_changes_button" type="button" value="Применить" onclick="javascript: Start_PageMassPost('items_form');" title="Принять исправления в записях на этой странице">

    <!--  -->
    <?php if (!isset($_smarty_tpl->tpl_vars['CurrentPage']->value)||($_smarty_tpl->tpl_vars['CurrentPage']->value<0)){?><?php $_smarty_tpl->tpl_vars["CurrentPage"] = new Smarty_variable(0, null, 0);?><?php }?><!--  --><?php $_smarty_tpl->tpl_vars["temp_count"] = new Smarty_variable(count($_smarty_tpl->tpl_vars['Pages']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['CurrentPage']->value>=$_smarty_tpl->tpl_vars['temp_count']->value){?><?php $_smarty_tpl->tpl_vars["CurrentPage"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_count']->value-1, null, 0);?><?php if ($_smarty_tpl->tpl_vars['CurrentPage']->value<0){?><?php $_smarty_tpl->tpl_vars["CurrentPage"] = new Smarty_variable(0, null, 0);?><?php }?><?php }?><!--  --><?php $_smarty_tpl->tpl_vars["temp_size"] = new Smarty_variable(11, null, 0);?><?php $_smarty_tpl->tpl_vars["temp_left"] = new Smarty_variable(sprintf("%d",($_smarty_tpl->tpl_vars['CurrentPage']->value-$_smarty_tpl->tpl_vars['temp_size']->value/2)), null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp_left']->value<0){?><?php $_smarty_tpl->tpl_vars["temp_left"] = new Smarty_variable(0, null, 0);?><?php }?><!--  --><?php $_smarty_tpl->tpl_vars["temp_right"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_left']->value+$_smarty_tpl->tpl_vars['temp_size']->value-1, null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp_right']->value>=$_smarty_tpl->tpl_vars['temp_count']->value){?><?php $_smarty_tpl->tpl_vars["temp_right"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_count']->value-1, null, 0);?><?php $_smarty_tpl->tpl_vars["temp_left"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_right']->value-$_smarty_tpl->tpl_vars['temp_size']->value+1, null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp_left']->value<0){?><?php $_smarty_tpl->tpl_vars["temp_left"] = new Smarty_variable(0, null, 0);?><?php }?><?php }?>

    <!-- Выводим кнопки листаемых страниц -->
    <?php if (isset($_smarty_tpl->tpl_vars['Pages']->value)&&!empty($_smarty_tpl->tpl_vars['Pages']->value)){?>
      <?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['page']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['page']->iteration=0;
 $_smarty_tpl->tpl_vars['page']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pages']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pages']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value){
$_smarty_tpl->tpl_vars['page']->_loop = true;
 $_smarty_tpl->tpl_vars['page']->iteration++;
 $_smarty_tpl->tpl_vars['page']->index++;
 $_smarty_tpl->tpl_vars['page']->first = $_smarty_tpl->tpl_vars['page']->index === 0;
 $_smarty_tpl->tpl_vars['page']->last = $_smarty_tpl->tpl_vars['page']->iteration === $_smarty_tpl->tpl_vars['page']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pages']['first'] = $_smarty_tpl->tpl_vars['page']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pages']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pages']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['pages']['last'] = $_smarty_tpl->tpl_vars['page']->last;
?>
        <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['first']&&($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']==$_smarty_tpl->tpl_vars['temp_left']->value-1)){?>
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration'];?>
: записи от <?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value+1));?>
 до <?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value));?>
">...</a>
        <?php }?>

        <!-- Если это первая, последняя или кнопки около кнопки текущей страницы -->
        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['first']||$_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['last']||(($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']>=$_smarty_tpl->tpl_vars['temp_left']->value)&&($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']<=$_smarty_tpl->tpl_vars['temp_right']->value))){?>
          <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']!=$_smarty_tpl->tpl_vars['CurrentPage']->value){?>
            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration'];?>
: записи от <?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value+1));?>
 до <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['last']){?><?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value));?>
<?php }else{ ?><?php echo sprintf('%d',(($tmp = @$_smarty_tpl->tpl_vars['total_items']->value)===null||$tmp==='' ? 0 : $tmp));?>
<?php }?>"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration'];?>
</a>
          <?php }else{ ?>
            <a class="current" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration'];?>
: записи от <?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value+1));?>
 до <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['last']){?><?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value));?>
<?php }else{ ?><?php echo sprintf('%d',(($tmp = @$_smarty_tpl->tpl_vars['total_items']->value)===null||$tmp==='' ? 0 : $tmp));?>
<?php }?>"><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration'];?>
</a>
          <?php }?>
        <?php }?>

        <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['last']&&($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']==$_smarty_tpl->tpl_vars['temp_right']->value+1)){?>
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration'];?>
: записи от <?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['index']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value+1));?>
 до <?php echo sprintf('%d',($_smarty_tpl->getVariable('smarty')->value['foreach']['pages']['iteration']*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value));?>
">...</a>
        <?php }?>
      <?php } ?>
    <?php }?>

    <!-- ссылка Назад -->
    <?php if (isset($_smarty_tpl->tpl_vars['Pages']->value)&&!empty($_smarty_tpl->tpl_vars['Pages']->value)&&isset($_smarty_tpl->tpl_vars['PrevPageUrl']->value)&&($_smarty_tpl->tpl_vars['PrevPageUrl']->value!='')){?>
      <a class="next" name="GotoPreviousPageLink" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PrevPageUrl']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на предыдущую страницу (для управления с клавиатуры нажмите Ctrl+Влево)">&lt;</a>
    <?php }?>

    <!-- ссылка Вперед -->
    <?php if (isset($_smarty_tpl->tpl_vars['Pages']->value)&&!empty($_smarty_tpl->tpl_vars['Pages']->value)&&isset($_smarty_tpl->tpl_vars['NextPageUrl']->value)&&($_smarty_tpl->tpl_vars['NextPageUrl']->value!='')){?>
      <a class="next" name="GotoNextPageLink" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['NextPageUrl']->value, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на следующую страницу (для управления с клавиатуры нажмите Ctrl+Вправо)">&gt;</a>
    <?php }?>
  </div>
<?php }} ?>