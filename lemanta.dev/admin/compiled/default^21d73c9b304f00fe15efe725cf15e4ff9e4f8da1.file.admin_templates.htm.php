<?php /* Smarty version Smarty-3.1.8, created on 2016-10-30 23:17:19
         compiled from "../admin/design/default/html/admin_templates.htm" */ ?>
<?php /*%%SmartyHeaderCode:16837804785816635f2e9e67-78030609%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21d73c9b304f00fe15efe725cf15e4ff9e4f8da1' => 
    array (
      0 => '../admin/design/default/html/admin_templates.htm',
      1 => 1462406621,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16837804785816635f2e9e67-78030609',
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
    'CurrentPage' => 0,
    'CurrentPageMaxsize' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5816635f4b6cd9_24361076',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5816635f4b6cd9_24361076')) {function content_5816635f4b6cd9_24361076($_smarty_tpl) {?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"templates",'main'=>true,'themes'=>true,'templates'=>true,'styles'=>true,'images'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → Шаблоны
      </div>
      Файлы шаблона: <b style="font-size: 10pt; font-weight: normal;">шаблон <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
</b>
    </h1>

    <!-- Часть страницы, показываемая после старта загрузки файла -->
    <div class="box_part" id="templates_start_box" style="display: none;">
      <div class="toolkey">
        &nbsp;
      </div>
      <div class="message">
        Выполняется указанное Вами действие.<br>
        Пожалуйста подождите.
      </div>
    </div>

    <!-- Изначально видимая часть страницы, скрываемая после старта загрузки файла -->
    <div class="box_part" id="templates_list_box">

        <!-- Выводим инструментальные ссылки -->
        <div class="toolkey">
            <a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://htmlbook.ru/html" target="_blank" title="Перейти в справочник HTML на сайте HtmlBook.ru">справочник HTML</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Templates&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DOWNLOAD, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" title="Загрузить файл в текущую папку" onclick="javascript: return Start_Popup('popupDOWNLOAD', null);">загрузить</a>
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
=Templates" enctype="multipart/form-data" id="items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

        <!-- Селектор -->
        <table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;">
          <tr>

            <!-- кнопка Удалить -->
            <td class="param_short" title="Удалить текущую папку">
              <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Templates" onclick="javascript: var object = document.getElementById('select_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
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
            <td class="value" width="60%" title="Выбор папки с файлами">

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
=Templates&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
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
=Templates&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_CREATE, ENT_QUOTES, 'UTF-8');?>
', 'templates');">
            </td>

          </tr>
        </table>

        <!-- Кнопка сброса фильтра --> 
        <div class="toolkey">
          <span>папка: <span>корень<?php if (isset($_smarty_tpl->tpl_vars['item']->value)&&($_smarty_tpl->tpl_vars['item']->value!='')){?>/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?></span></span><a href="#" onclick="javascript: jQuery(this).text((jQuery(this).text() == 'подробности') ? 'без подробностей' : 'подробности'); jQuery('div.template_var_line').toggle(); return false;" title="Показать / скрыть используемые шаблонами переменные">подробности</a>
        </div>

        <!--  -->
        <div class="popup" id="popupDOWNLOAD"><div class="popup_content"><div class="title"><div class="close"><a href="#" onclick="javascript: return Hide_Popup('popupDOWNLOAD');" title="Закрыть">x</a></div>Загрузка шаблона</div><div class="cell">файл шаблона или zip-архив шаблонов:<div class="input"><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf("%d",@ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE), ENT_QUOTES, 'UTF-8');?>
">  <!-- Не позволяем загрузку файла объемом свыше заданного --><input class="input" disabled id="popupDOWNLOADfile" name="file" type="file" title="Какой файл требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf("%d",(@ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт)"></div></div><div class="submit"><input class="submit" type="submit" value="Начать" onclick="javascript: return Submit_Popup('?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Templates&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DOWNLOAD, ENT_QUOTES, 'UTF-8');?>
', 'templates');"></div></div></div>

        <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>

         <!-- Навигатор страниц -->
          <div class="navigator">

            <!-- Выводим скрытые кнопки массовых операций -->
            <input class="mass_submit disabled_button" disabled id="popupEDIT_SaveAllChangesKey1" type="submit" value="Сохранить все" title="Сохранить исправления во всех отредактированных шаблонах" onclick="javascript: return Submit_Template_Popup('?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Templates&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_EDIT_ALL, ENT_QUOTES, 'UTF-8');?>
', 'templates');">
          </div>

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
          <?php if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
?><?php if (!function_exists('smarty_template_function_show_files')) {
    function smarty_template_function_show_files($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['show_files']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dir']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["items"]['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["items"]['iteration']++;
?>
              <?php if (isset($_smarty_tpl->tpl_vars['c']->value->files)){?><?php if (!empty($_smarty_tpl->tpl_vars['c']->value->files)){?><?php smarty_template_function_show_files($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['c']->value->files));?>
<?php }?><?php }elseif($_smarty_tpl->tpl_vars['c']->value->path==$_smarty_tpl->tpl_vars['temp']->value){?><?php $_smarty_tpl->_capture_stack[0][] = array("temp_count", null, null); ob_start(); ?>1<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><li class="flatlist"><div class="onerow"><!-- Микро кнопки справа от названия --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="javascript: return confirm('Данный файл будет удален с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_delete_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Нумерация --><span class="topic" style="display: inline;"><?php if (isset($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration']+$_smarty_tpl->tpl_vars['CurrentPage']->value*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value;?>
.<?php }else{ ?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.<?php }?></span><!-- Дата создания --><?php if (isset($_smarty_tpl->tpl_vars['c']->value->ctime)&&(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->ctime,10,'',true)!="0000-00-00")){?><span class="date" title="Дата создания: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->ctime, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->ctime,10,'',true), ENT_QUOTES, 'UTF-8');?>
</span><?php }else{ ?><span class="date" title="Дата создания: неизвестно">неизвестно</span><?php }?><!-- Дата модификации --><?php if (isset($_smarty_tpl->tpl_vars['c']->value->ctime)&&isset($_smarty_tpl->tpl_vars['c']->value->mtime)&&($_smarty_tpl->tpl_vars['c']->value->mtime!=$_smarty_tpl->tpl_vars['c']->value->ctime)&&(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->mtime,10,'',true)!="0000-00-00")){?><span class="date" title="Дата изменения: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->mtime, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->mtime,10,'',true), ENT_QUOTES, 'UTF-8');?>
</span><?php }else{ ?><span class="date" title="Дата изменения: не изменяли">не меняли</span><?php }?><!-- Права доступа --><?php if (isset($_smarty_tpl->tpl_vars['c']->value->permissions)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->permissions))!='')){?><span class="date" title="Права доступа к файлу (формат: Тип Владелец Группа Остальные; права: r = чтение, w = запись, x s t = исполнение, листинг папки; типы: l = символическая ссылка, s = сокет, b = специальный блок, c = специальный символ, d = папка, p = поток FIFO, u = неизвестный)"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->permissions), ENT_QUOTES, 'UTF-8');?>
</span><?php }else{ ?><span class="date" title="Права доступа: неизвестно">неизвестно</span><?php }?><!-- Размер --><span class="votes" title="Размер файла: <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['c']->value->filesize);?>
 байт"><?php if (sprintf("%d",$_smarty_tpl->tpl_vars['c']->value->filesize)>65536){?><?php echo sprintf("%d",($_smarty_tpl->tpl_vars['c']->value->filesize/1024));?>
 кбайт<?php }else{ ?><?php echo sprintf("%d",$_smarty_tpl->tpl_vars['c']->value->filesize);?>
 байт<?php }?></span><!-- Имя файла --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php if (isset($_smarty_tpl->tpl_vars['c']->value->title)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
<?php }?>" onclick="javascript: return Start_Template_Popup('popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
', this);"><?php if (isset($_smarty_tpl->tpl_vars['c']->value->title)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
<?php }?></a></div><!-- Краткая информация --><!-- Имя файла --><div class="line" title="Файл: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
"><span>файл:</span><!-- изначально скрытая кнопка Сохранить (сохранить конкретно эту запись, игнорируя изменения других записей на странице) --><input class="submit" disabled id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
_SaveChangesKey" type="submit" value="сохранить" style="display: none; margin-right: 20px;" title="Сохранить исправления только этого шаблона" onclick="javascript: return Submit_Template_Popup('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
', 'templates');"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
</div><!-- Переменные --><?php if (isset($_smarty_tpl->tpl_vars['c']->value->vars)&&!empty($_smarty_tpl->tpl_vars['c']->value->vars)){?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->vars; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["vars"]['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["vars"]['iteration']++;
?><div class="line template_var_line" title="Использует переменную: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
" style="display: none;"><span><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vars']['iteration']==1){?>vars:<?php }else{ ?>&nbsp;<?php }?></span><span class="subinfo"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value, ENT_QUOTES, 'UTF-8');?>
</span></div><?php } ?><?php }?></li><!--  --><div class="popup popup_wide" id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
"><div class="popup_content"><div class="title"><div class="close"><a href="#" onclick="javascript: return Hide_Popup('popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
');" title="Закрыть">x</a></div><div class="close"><a href="#" onclick="jQuery(this).closest('.popup').toggleClass('popup_full'); return false;" title="Растянуть / восстановить">↔</a></div>Редактирование: <b style="font-size: 10pt; font-weight: normal;"><?php if (isset($_smarty_tpl->tpl_vars['c']->value->title)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->title), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->filename, ENT_QUOTES, 'UTF-8');?>
<?php }?></b></div><div class="cell">файл:<div class="input"><input class="input" disabled readonly id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
title" maxlength="64" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TITLE, ENT_QUOTES, 'UTF-8');?>
[<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->filename), ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->filename), ENT_QUOTES, 'UTF-8');?>
" title="Имя файла"></div></div><div class="cell">содержимое:<div class="input"><textarea class="input" disabled id="popupEDIT<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
content" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_CONTENT, ENT_QUOTES, 'UTF-8');?>
[<?php if (isset($_smarty_tpl->tpl_vars['c']->value->path)&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path))!='')){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->path), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->filename), ENT_QUOTES, 'UTF-8');?>
]" style="height: 600px;" title="Содержимое шаблона"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->content)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea></div></div><div class="submit"><input class="submit" type="submit" value="Сохранить" onclick="javascript: return Submit_Template_Popup('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
', 'templates');"></div></div></div><?php }?>
            <?php } ?>
          <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


          
          <?php smarty_template_function_show_files($_smarty_tpl,array('dir'=>$_smarty_tpl->tpl_vars['items']->value));?>


          <?php if (Smarty::$_smarty_vars['capture']['temp_count']==''){?>
            <div class="noitems">
              Папка не содержит шаблонов.
            </div>
          <?php }else{ ?>

           <!-- Навигатор страниц -->
            <div class="navigator">

              <!-- Выводим скрытые кнопки массовых операций -->
              <input class="mass_submit disabled_button" disabled id="popupEDIT_SaveAllChangesKey2" type="submit" value="Сохранить все" title="Сохранить исправления во всех отредактированных шаблонах" onclick="javascript: return Submit_Template_Popup('?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Templates&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_EDIT_ALL, ENT_QUOTES, 'UTF-8');?>
', 'templates');">
            </div>
          <?php }?>

        <?php }else{ ?>
          <div class="noitems">
            Папка не содержит шаблонов.
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

  <!-- Скрипт редактора html-кода с подсветкой синтаксиса -->
  <script src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/js/codemirror/js/codemirror.js" type="text/javascript"></script>
  
    <script language="JavaScript" type="text/javascript">
      <!--

      // объекты редакторов содержимого шаблонов
      var template_editors = new Array();
      var template_editors_changed = new Array();

      // проявление выпадающей панели редактирования шаблона
      //   id = идентификатор объекта панели
      //   link_object = кликабельный объект, инициировавший выпадение панели

      function Start_Template_Popup (id, link_object) {

        // проявляем выпадающую панель редактирования
        Start_Popup(id, link_object);

        // если для панели еще не была сделана подсветка синтаксиса, делаем
        if (!template_editors[id]) {
          template_editors_changed[id] = false;
          template_editors[id] = CodeMirror.fromTextArea(id + 'content',
                                                        {height: '600px',
                                                         parserfile: ['parsexml.js', 'parsecss.js', 'tokenizejavascript.js', 'parsejavascript.js', 'parsehtmlmixed.js'],
                                                         stylesheet: ['http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/js/codemirror/css/xmlcolors.css', 'http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/js/codemirror/css/jscolors.css', 'http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/js/codemirror/css/csscolors.css'],
                                                         path: 'http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/js/codemirror/js/',
                                                         dumbTabs: true,
                                                         saveFunction: null,
                                                         onChange: function () {
                                                                     template_editors_changed[id] = true;
                                                                     var object = document.getElementById(id + '_SaveChangesKey');
                                                                     if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {
                                                                       object.style.display = 'inline';
                                                                       if ('disabled' in object) object.disabled = false;
                                                                     }
                                                                     object = document.getElementById('popupEDIT_SaveAllChangesKey1');
                                                                     if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {
                                                                       object.style.display = 'block';
                                                                       if ('disabled' in object) object.disabled = false;
                                                                       jQuery(object).removeClass('disabled_button');
                                                                     }
                                                                     object = document.getElementById('popupEDIT_SaveAllChangesKey2');
                                                                     if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {
                                                                       object.style.display = 'block';
                                                                       if ('disabled' in object) object.disabled = false;
                                                                       jQuery(object).removeClass('disabled_button');
                                                                     }
                                                                   },
                                                         textWrapping: true});
        }
        return false;
      }

      // отправка выпадающей панели редактирования шаблона
      //   url_params = динамические параметры URL админпанели
      //   part_id = начало идентификатора переключаемых частей страницы

      function Submit_Template_Popup (url_params, part_id) {

        // перебираем объекты редакторов содержимого шаблонов
        for (id in template_editors) {

          // если редактором включена кнопка "сохранить изменения"
          var changed = !template_editors_changed[id] ? false : true;
          var object = !changed ? document.getElementById(id + '_SaveChangesKey') : null;
          if (changed || ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style))) {
            if (changed || (object.style.display == 'inline')) {

              // передаем содержимое из редактора в соответствующий textarea
              object = document.getElementById(id + 'content');
              if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {
                object.value = template_editors[id].getCode();

                // разблокируем поля панели, где находится этот textarea
                Unlock_Popup_Fields(id);
              }
            }
          }
        }

        // отправляем выпадающую панель редактирования
        return Submit_Popup(url_params, part_id);
      }
      // -->
    </script>
  
<?php }} ?>