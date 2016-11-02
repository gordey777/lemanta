<?php /* Smarty version Smarty-3.1.8, created on 2016-10-30 23:24:26
         compiled from "../admin/design/default/html/admin_themes.htm" */ ?>
<?php /*%%SmartyHeaderCode:20212264585816650a55ef05-49513399%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90e8e87a4e31bbf72341b522cbfa5d50e4a62f38' => 
    array (
      0 => '../admin/design/default/html/admin_themes.htm',
      1 => 1462406622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20212264585816650a55ef05-49513399',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'error' => 0,
    'items' => 0,
    'settings' => 0,
    'c' => 0,
    'temp_selected' => 0,
    'site' => 0,
    'admin_folder' => 0,
    'themes' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5816650a618601_35281620',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5816650a618601_35281620')) {function content_5816650a618601_35281620($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?>

    <?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/submenu.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>'themes','main'=>true,'themes'=>true,'templates'=>true,'styles'=>true,'images'=>true), 0);?>


    <div class="box">

        
        <h1 id="client_themes"><div class="path"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
">Главная</a> → Дизайн</div>Дизайны клиентской стороны: <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
" style="font-size: 10pt; font-weight: normal; margin: 0px 0px 0px 40px;" title="Переместиться к блоку дизайнов админпанели" onclick="jQuery(document).scrollTop(jQuery('#adminpanel_themes').offset().top); return false;">админпанели</a></h1>

        
        <div class="box_part" id="themes_start_box" style="display: none;">
            <div class="toolkey">
                &nbsp;
            </div>
            <div class="message">
                Выполняется указанное Вами действие.<br>
                Пожалуйста подождите.
            </div>
        </div>

        
        <div class="box_part" id="themes_list_box">

            
            <div class="toolkey">
                &nbsp;<a href="http://imperacms.ru/impera-cms-modules.htm" target="_blank" title="Скачать еще внешние модули с официального сайта">скачать еще модули</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://imperacms.ru/impera-cms-templates.htm" target="_blank" title="Скачать еще шаблоны с официального сайта">скачать еще шаблоны</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?section=Themes&act=upload&token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['token'][0][0]->token(array(),$_smarty_tpl);?>
" title="Загрузить файл в дизайны клиентской стороны" onclick="var object = jQuery('#client_themes');if (typeof(object) == 'object' && object != null && 'length' in object && object.length > 0) {object = object[0];} else {object = null;}jQuery('#popupUPLOAD').find('input[name=adminpanel]').val('0');return Start_Popup('popupUPLOAD', object);">загрузить</a>
            </div>

            
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
                <div class="message">
                    <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

                </div>
            <?php }?>

            
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
                <div class="error">
                    <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

                </div>
            <?php }?>

            
            <div class="popup" id="popupUPLOAD"><div class="popup_content"><div class="title"><div class="close"><a href="#" onclick="return Hide_Popup('popupUPLOAD');" title="Закрыть">x</a></div>Загрузка шаблона</div><form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?section=Themes" enctype="multipart/form-data" id="items_form" method="post"><div class="cell">zip-архив шаблона:<div class="input"><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf('%d',(($tmp = @@ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp)), ENT_QUOTES, 'UTF-8');?>
" />  <!-- Не позволяем загрузку файла объемом свыше заданного --><input class="input" disabled id="popupUPLOADfile" name="theme" type="file" title="Какой файл требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf('%d',(((($tmp = @@ZIP_TEMPLATES_UPLOAD_MAXIMAL_FILESIZE)===null||$tmp==='' ? 0 : $tmp))/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт)" /></div></div><div class="cell">или из веб адреса:<div class="input"><input class="input" disabled id="popupUPLOADlink" name="theme_url" type="text" title="Адрес файла в интернете" value="<?php echo htmlspecialchars((($tmp = @$_POST['theme_url'])===null||$tmp==='' ? 'http://' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></div></div><div class="cell" title="Загрузка нового шаблона, но отказать если такой уже есть"><br /><input class="checkbox" id="items_form_popupUPLOAD_update_mode1" name="update_mode" type="radio" value="if_not_exist" /> <span onclick="Toggle_PageCheckbox('items_form_popupUPLOAD_update_mode1');">только если такого ещё нет</span></div><div class="cell" title="Перезагрузка существующего шаблона или загрузка нового"><input class="checkbox" id="items_form_popupUPLOAD_update_mode2" name="update_mode" type="radio" value="clear_before" checked /> <span onclick="Toggle_PageCheckbox('items_form_popupUPLOAD_update_mode2');">с удалением старого, если был</span></div><div class="cell" title="Модификация шаблона - дозагрузка новых или изменившихся файлов"><input class="checkbox" id="items_form_popupUPLOAD_update_mode3" name="update_mode" type="radio" value="merge" /> <span onclick="Toggle_PageCheckbox('items_form_popupUPLOAD_update_mode3');">поверх существующего</span><br /><br /></div><div class="cell">назначить имя:<div class="input"><input class="input" disabled id="popupUPLOADname" name="other_name" type="text" title="Дать шаблону другое имя, если нужно чтобы отличалось от имени загружаемого файла" value="<?php echo htmlspecialchars((($tmp = @$_POST['other_name'])===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" /></div></div><div class="submit"><input name="adminpanel" type="hidden" value="0" /><input name="token" type="hidden" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['token'][0][0]->token(array(),$_smarty_tpl);?>
" /><input class="submit" type="submit" value="Начать" onclick="return Submit_Popup('?section=Themes&act=upload', 'themes');" /></div></form></div></div>

            
            <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&is_array($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?>
                    <?php $_smarty_tpl->tpl_vars['temp_selected'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->theme)===null||$tmp==='' ? '' : $tmp)==(($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['c']->value->dir)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['c']->value->name : $tmp))===null||$tmp==='' ? '' : $tmp), null, 0);?>

                    <li class="flatlist">
                        <div class="onerow">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->delete_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="return confirm('Данный шаблон будет удален с сайта. Вы подтверждаете такую операцию?');">
                                <img class="microkey_right" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_delete_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->copy_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Создать копию">
                                <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_edit_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->download_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Скачать шаблон в виде архива">
                                <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_filed_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->activate_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Выбрать этот шаблон">
                                <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_done<?php if (!$_smarty_tpl->tpl_vars['temp_selected']->value){?>_off<?php }?>_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <span class="topic" style="display: inline;">
                                <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.
                            </span>

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->activate_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Выбрать этот шаблон"<?php if (isset($_smarty_tpl->tpl_vars['c']->value->enabled)&&!$_smarty_tpl->tpl_vars['c']->value->enabled){?> class="disabled_item"<?php }?>>
                                <?php if ($_smarty_tpl->tpl_vars['temp_selected']->value){?><b><?php }?>
                                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['c']->value->name)===null||$tmp==='' ? 'Нет названия!' : $tmp);?>

                                <?php if ($_smarty_tpl->tpl_vars['temp_selected']->value){?></b><?php }?>
                            </a>
                        </div>

                        
                        <img class="thumb thumb_leftshift" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
design/<?php echo htmlspecialchars((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['c']->value->dir)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['c']->value->name : $tmp))===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
/images/thumbnail.jpg" />

                        
                        <div class="line" style="padding-top: 9px;" title="<?php echo htmlspecialchars(smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', ((($tmp = @$_smarty_tpl->tpl_vars['c']->value->description)===null||$tmp==='' ? '' : $tmp))),'&nbsp;',' '), ENT_QUOTES, 'UTF-8');?>
">
                            <span>
                                описание:
                            </span>
                            <?php echo htmlspecialchars(smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', ((($tmp = @$_smarty_tpl->tpl_vars['c']->value->description)===null||$tmp==='' ? '' : $tmp))),'&nbsp;',' '), ENT_QUOTES, 'UTF-8');?>

                        </div>
                    </li>
                <?php } ?>
            <?php }else{ ?>
                <div class="noitems">
                    Не найдено дизайнов для клиентской стороны сайта.
                </div>
            <?php }?>

            <br /><br /><br /><br />

            
            <h1 id="adminpanel_themes"><div class="path"><a href="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
/">Главная</a> → Дизайн</div>Дизайны админпанели: <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
" style="font-size: 10pt; font-weight: normal; margin: 0px 0px 0px 40px;" title="Переместиться к блоку дизайнов клиентской стороны" onclick="jQuery(document).scrollTop(0); return false;">клиентской стороны</a></h1>

            
            <div class="toolkey">
                &nbsp;<a href="http://imperacms.ru/impera-cms-modules.htm" target="_blank" title="Скачать еще внешние модули с официального сайта">скачать еще модули</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://imperacms.ru/impera-cms-templates.htm" target="_blank" title="Скачать еще шаблоны с официального сайта">скачать еще шаблоны</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?section=Themes&act=upload&token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['token'][0][0]->token(array(),$_smarty_tpl);?>
&adminpanel=1" title="Загрузить файл в дизайны админпанели" onclick="var object = jQuery('#adminpanel_themes');if (typeof(object) == 'object' && object != null && 'length' in object && object.length > 0) {object = object[0];} else {object = null;}jQuery('#popupUPLOAD').find('input[name=adminpanel]').val('1');return Start_Popup('popupUPLOAD', object);">загрузить</a>
            </div>

            
            <?php if (isset($_smarty_tpl->tpl_vars['themes']->value)&&is_array($_smarty_tpl->tpl_vars['themes']->value)&&!empty($_smarty_tpl->tpl_vars['themes']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['themes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?>
                    <?php $_smarty_tpl->tpl_vars['temp_selected'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp)==(($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['c']->value->dir)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['c']->value->name : $tmp))===null||$tmp==='' ? '' : $tmp), null, 0);?>

                    <li class="flatlist">
                        <div class="onerow">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->delete_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="return confirm('Данный шаблон будет удален с сайта. Вы подтверждаете такую операцию?');">
                                <img class="microkey_right" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_delete_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->copy_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Создать копию">
                                <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_edit_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->download_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Скачать шаблон в виде архива">
                                <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_filed_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->activate_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Выбрать этот шаблон">
                                <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_done<?php if (!$_smarty_tpl->tpl_vars['temp_selected']->value){?>_off<?php }?>_16x16.png">
                            </a>
                            <img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif">

                            
                            <span class="topic" style="display: inline;">
                                <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.
                            </span>

                            
                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->activate_get)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Выбрать этот шаблон"<?php if (isset($_smarty_tpl->tpl_vars['c']->value->enabled)&&!$_smarty_tpl->tpl_vars['c']->value->enabled){?> class="disabled_item"<?php }?>>
                                <?php if ($_smarty_tpl->tpl_vars['temp_selected']->value){?><b><?php }?>
                                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['c']->value->name)===null||$tmp==='' ? 'Нет названия!' : $tmp);?>

                                <?php if ($_smarty_tpl->tpl_vars['temp_selected']->value){?></b><?php }?>
                            </a>
                        </div>

                        
                        <img class="thumb thumb_leftshift" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
design/<?php echo htmlspecialchars((($tmp = @(($tmp = @$_smarty_tpl->tpl_vars['c']->value->dir)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['c']->value->name : $tmp))===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
/images/thumbnail.jpg" />

                        
                        <div class="line" style="padding-top: 9px;" title="<?php echo htmlspecialchars(smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', ((($tmp = @$_smarty_tpl->tpl_vars['c']->value->description)===null||$tmp==='' ? '' : $tmp))),'&nbsp;',' '), ENT_QUOTES, 'UTF-8');?>
">
                            <span>
                                описание:
                            </span>
                            <?php echo htmlspecialchars(smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', ((($tmp = @$_smarty_tpl->tpl_vars['c']->value->description)===null||$tmp==='' ? '' : $tmp))),'&nbsp;',' '), ENT_QUOTES, 'UTF-8');?>

                        </div>
                    </li>
                <?php } ?>
            <?php }else{ ?>
                <div class="noitems">
                    Не найдено дизайнов для админпанели.
                </div>
            <?php }?>

            <br /><br />
        </div>
    </div>
<?php }} ?>