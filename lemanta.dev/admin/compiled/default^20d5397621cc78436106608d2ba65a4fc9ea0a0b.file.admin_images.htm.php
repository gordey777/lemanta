<?php /* Smarty version Smarty-3.1.8, created on 2016-10-30 23:24:23
         compiled from "../admin/design/default/html/admin_images.htm" */ ?>
<?php /*%%SmartyHeaderCode:59726623158166507a91367-95154817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '20d5397621cc78436106608d2ba65a4fc9ea0a0b' => 
    array (
      0 => '../admin/design/default/html/admin_images.htm',
      1 => 1462406593,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59726623158166507a91367-95154817',
  'function' => 
  array (
    'show_folders' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'show_files' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'root_url' => 0,
    'admin_folder' => 0,
    'settings' => 0,
    'Token' => 0,
    'message' => 0,
    'error' => 0,
    'items' => 0,
    'r' => 0,
    'temp_count' => 0,
    'dir' => 0,
    'c' => 0,
    'temp' => 0,
    'item' => 0,
    'level' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58166507ba20b5_33175910',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58166507ba20b5_33175910')) {function content_58166507ba20b5_33175910($_smarty_tpl) {?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"images",'main'=>true,'themes'=>true,'templates'=>true,'styles'=>true,'images'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → Картинки
      </div>
      Файлы картинок: <b style="font-size: 10pt; font-weight: normal;">шаблон <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
</b>
    </h1>

    <!-- Часть страницы, показываемая после старта загрузки фото -->
    <div class="box_part" id="images_start_box" style="display: none;">
      <div class="toolkey">
        &nbsp;
      </div>
      <div class="message">
        Выполняется указанное Вами действие.<br>
        Пожалуйста подождите.
      </div>
    </div>

    <!-- Изначально видимая часть страницы, скрываемая после старта загрузки фото -->
    <div class="box_part" id="images_list_box">

      <!-- Выводим инструментальные ссылки -->
      <div class="toolkey">
        <a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Images&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DOWNLOAD, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" title="Загрузить картинку в текущую папку" onclick="javascript: return Start_Popup('popupDOWNLOAD', null);">загрузить</a>
      </div>

      <!--  -->
      <?php if (isset($_smarty_tpl->tpl_vars['message']->value)&&($_smarty_tpl->tpl_vars['message']->value!='')){?>
        <div class="message">
          <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

        </div>
      <?php }?>

      <!--  -->
      <?php if (isset($_smarty_tpl->tpl_vars['error']->value)&&($_smarty_tpl->tpl_vars['error']->value!='')){?>
        <div class="error">
          <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

        </div>
      <?php }?>

      <!-- Форма со списком записей -->
      <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Images" enctype="multipart/form-data" id="items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

        <!-- Селектор -->
        <table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;">
          <tr>

            <!-- кнопка Удалить -->
            <td class="param_short" title="Удалить текущую папку">
              <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Images" onclick="javascript: var object = document.getElementById('select_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
'); if ((typeof(object) != 'object') || (object == null) || !('options' in object) || !('length' in object.options) || !('selectedIndex' in object) || (object.options.length <= object.selectedIndex)) return false; object = object.options[object.selectedIndex]; if ((typeof(object) != 'object') || (object == null) || !('getAttribute' in object)) return false; object = object.getAttribute('link'); if (!object || (object == '')) return false; if (!confirm('Данная папка будет удалена с сайта. Вы подтверждаете такую операцию?')) return false; this.href = object; return true;">
                <img class="microkey_right icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_delete_16x16.png">
              </a>
            </td>

            <!-- текущая папка -->
            <td class="param_short">
              текущая папка:
            </td>
            <td class="value" width="60%" title="Выбор папки с картинками">

              <!-- Создаем селектор папок -->
              <select class="thin" id="select_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">

                <!-- элемент корневой папки -->
                <?php $_smarty_tpl->tpl_vars["temp_count"] = new Smarty_variable(0, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><?php if (!isset($_smarty_tpl->tpl_vars['r']->value->files)){?><?php $_smarty_tpl->tpl_vars["temp_count"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_count']->value+1, null, 0);?><?php }?><?php } ?><?php }?><option value="" link="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Images&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETE, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
"<?php if ($_smarty_tpl->tpl_vars['temp_count']->value==0){?> style="color: #808080;"<?php }?>>корень<?php if ($_smarty_tpl->tpl_vars['temp_count']->value!=0){?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $_smarty_tpl->tpl_vars['temp_count']->value;?>
 шт.)<?php }?></option>

                <!--  -->
                <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>
                  <?php if (!function_exists('smarty_template_function_show_folders')) {
    function smarty_template_function_show_folders($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_folders']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
                    <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dir']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                      <?php if (isset($_smarty_tpl->tpl_vars['c']->value->files)){?>

                        <?php $_smarty_tpl->tpl_vars["temp_count"] = new Smarty_variable(0, null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->files)){?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->files; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?><?php if (!isset($_smarty_tpl->tpl_vars['r']->value->files)){?><?php $_smarty_tpl->tpl_vars["temp_count"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp_count']->value+1, null, 0);?><?php }?><?php } ?><?php }?><?php $_smarty_tpl->_capture_stack[0][] = array('default', "temp", null); ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['c']->value->path;?>
<?php echo $_smarty_tpl->tpl_vars['c']->value->filename;?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp']->value, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&($_smarty_tpl->tpl_vars['item']->value==$_smarty_tpl->tpl_vars['temp']->value)){?> selected<?php }?> link="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['temp_count']->value==0){?> style="color: #808080;"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["spaces"]);
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
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
<?php if ($_smarty_tpl->tpl_vars['temp_count']->value!=0){?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $_smarty_tpl->tpl_vars['temp_count']->value;?>
 шт.)<?php }?></option>

                        <?php if (isset($_smarty_tpl->tpl_vars['c']->value->files)&&!empty($_smarty_tpl->tpl_vars['c']->value->files)){?>
                          <?php smarty_template_function_show_folders($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['c']->value->files,'level'=>$_smarty_tpl->tpl_vars['level']->value+1));?>

                        <?php }?>
                      <?php }?>
                    <?php } ?>
                  <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


                  
                  <?php smarty_template_function_show_folders($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['items']->value,'level'=>1));?>

                <?php }?>
              </select>
            </td>

            <!-- добавить папку -->
            <td class="param_short">
              &nbsp;&nbsp; в ней папку:
            </td>
            <td class="value" width="40%" title="Имя новой папки, которая будет создана в текущей папке">
              <input class="edit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_NAME, ENT_QUOTES, 'UTF-8');?>
" type="text" value="">
            </td>
            <td class="value_box">
              <input class="submit" type="submit" value="Создать" onclick="javascript: return Submit_Popup('?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Images&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_CREATE, ENT_QUOTES, 'UTF-8');?>
', 'images');">
            </td>

          </tr>
        </table>

        <!-- Кнопка сброса фильтра --> 
        <div class="toolkey">
          <span>папка: <span>корень<?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&($_smarty_tpl->tpl_vars['item']->value!='')){?>/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?></span></span>
        </div>

        <!--  -->
        <div class="popup" id="popupDOWNLOAD"><div class="popup_content"><div class="title"><div class="close"><a href="#" onclick="javascript: return Hide_Popup('popupDOWNLOAD');" title="Закрыть">x</a></div>Загрузка картинки</div><div class="cell">файл картинки или zip-архив картинок:<div class="input"><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf("%d",@ZIP_IMAGES_UPLOAD_MAXIMAL_FILESIZE), ENT_QUOTES, 'UTF-8');?>
">  <!-- Не позволяем загрузку файла объемом свыше заданного --><input class="input" disabled id="popupDOWNLOADfile" name="image" type="file" title="Какой файл требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf("%d",(@ZIP_IMAGES_UPLOAD_MAXIMAL_FILESIZE/1024/1024)), ENT_QUOTES, 'UTF-8');?>
 Мбайт)"></div></div><div class="submit"><input class="submit" type="submit" value="Начать" onclick="javascript: return Submit_Popup('?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Images&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DOWNLOAD, ENT_QUOTES, 'UTF-8');?>
', 'images');"></div></div></div>

        <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>

          <!--  -->
          <?php $_smarty_tpl->_capture_stack[0][] = array("temp_count", null, null); ob_start(); ?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
          <?php $_smarty_tpl->_capture_stack[0][] = array('default', "temp", null); ob_start(); ?><?php if (isset($_smarty_tpl->tpl_vars['item']->value)){?><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
<?php if ($_smarty_tpl->tpl_vars['item']->value!=''){?>/<?php }?><?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
          <?php if (!function_exists('smarty_template_function_show_files')) {
    function smarty_template_function_show_files($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_files']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dir']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
              <?php if (isset($_smarty_tpl->tpl_vars['c']->value->files)){?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->files)){?><?php smarty_template_function_show_files($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['c']->value->files));?>
<?php }?><?php }elseif($_smarty_tpl->tpl_vars['c']->value->path==$_smarty_tpl->tpl_vars['temp']->value){?><?php $_smarty_tpl->_capture_stack[0][] = array("temp_count", null, null); ob_start(); ?>1<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><li class="imagelist"><!-- Изображение --><a class="image" href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
/images/<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&($_smarty_tpl->tpl_vars['c']->value->path!='')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->path, ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
" target="_blank" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
"><?php if ((isset($_smarty_tpl->tpl_vars['c']->value->width)&&isset($_smarty_tpl->tpl_vars['c']->value->height))||(isset($_smarty_tpl->tpl_vars['c']->value->extension)&&($_smarty_tpl->tpl_vars['c']->value->extension=="ico"))){?><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
/images/<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&($_smarty_tpl->tpl_vars['c']->value->path!='')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->path, ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
"><?php }else{ ?>невозможно отобразить<?php }?></a><div class="onerow"><!-- Микро кнопки справа от названия --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="javascript: return confirm('Данный файл будет удален с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_delete_16x16.png"></a><!-- Название --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
/images/<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&($_smarty_tpl->tpl_vars['c']->value->path!='')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->path, ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
" target="_blank" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
" style="display: block; overflow: hidden; width: 135px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
</a></div><!-- Размеры --><div class="size"><?php if (isset($_smarty_tpl->tpl_vars['c']->value->width)&&isset($_smarty_tpl->tpl_vars['c']->value->height)){?><?php echo sprintf("%d",$_smarty_tpl->tpl_vars['c']->value->width);?>
&times;<?php echo sprintf("%d",$_smarty_tpl->tpl_vars['c']->value->height);?>
 точек<?php }else{ ?>&nbsp;<?php }?></div></li><?php }?>
            <?php } ?>
          <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


          
          <?php smarty_template_function_show_files($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['items']->value));?>


          <?php if (Smarty::$_smarty_vars['capture']['temp_count']==''){?>
            <div class="noitems">
              Папка не содержит картинок.
            </div>
          <?php }?>

        <?php }else{ ?>
          <div class="noitems">
            Папка не содержит картинок.
          </div>
        <?php }?>

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      </form>

    </div>

    <!-- Блок справочной информации -->
    <a name="help"></a>
    <div class="help" id="help_box" style="display: none;">
      <div class="title">
        Справка
      </div>
      <div>
        &nbsp;
      </div>
    </div>

  </div>
<?php }} ?>