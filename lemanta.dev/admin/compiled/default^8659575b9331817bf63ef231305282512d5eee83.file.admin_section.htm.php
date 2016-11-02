<?php /* Smarty version Smarty-3.1.8, created on 2016-09-21 13:53:05
         compiled from "../admin/design/default/html/admin_section.htm" */ ?>
<?php /*%%SmartyHeaderCode:32925843757e266917a67f7-76539852%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8659575b9331817bf63ef231305282512d5eee83' => 
    array (
      0 => '../admin/design/default/html/admin_section.htm',
      1 => 1462406617,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32925843757e266917a67f7-76539852',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
    'root_url' => 0,
    'admin_folder' => 0,
    'id' => 0,
    'error' => 0,
    'message' => 0,
    'settings' => 0,
    'modules' => 0,
    'sid' => 0,
    'c' => 0,
    'cid' => 0,
    'sclass' => 0,
    'cclass' => 0,
    'menus' => 0,
    'all_users' => 0,
    'Token' => 0,
    'image' => 0,
    'from_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57e26691914325_00814921',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57e26691914325_00814921')) {function content_57e26691914325_00814921($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?><!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"card",'main'=>true,'pages'=>true,'card_pages'=>true,'news'=>true,'articles'=>true,'banners'=>true,'files'=>true,'menus'=>true,'modules'=>true), 0);?>


  <!--  -->

  <?php $_smarty_tpl->tpl_vars["id"] = new Smarty_variable((($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->section_id, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp), null, 0);?>

  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Sections" title="Перейти на страницу специальных страниц в админпанели">Страницы</a>
        → <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>Редактирование<?php }else{ ?>Новая<?php }?>
      </div>
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>
        <?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->name, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>

      <?php }else{ ?>
        Новая специальная страница
      <?php }?>
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)&&isset($_smarty_tpl->tpl_vars['item']->value->url)&&!empty($_smarty_tpl->tpl_vars['item']->value->url)&&empty($_smarty_tpl->tpl_vars['error']->value)){?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на специальную страницу в клиентской части сайта">http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?>&nbsp;<?php }?>
    </div>

    <!--  -->

    <?php if (isset($_smarty_tpl->tpl_vars['message']->value)&&!empty($_smarty_tpl->tpl_vars['message']->value)){?>
      <div class="message">
        <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

      </div>
    <?php }?>

    <!--  -->

    <?php if (isset($_smarty_tpl->tpl_vars['error']->value)&&!empty($_smarty_tpl->tpl_vars['error']->value)){?>
      <div class="error">
        <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

      </div>
    <?php }?>

    <!-- Форма данных о специальной странице -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Section" enctype="multipart/form-data" id="item_form" method="post">

      <!-- Информация о названии в меню и заголовке -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param">
            Название в меню:
          </td>
          <td class="value" width="100%" title="Как называть специальную страницу в меню">
            <input class="edit" name="name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->name, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value_box">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
        <tr>
          <td class="param">
            Заголовок:
          </td>
          <td class="value" colspan="2" width="100%" title="Заголовок специальной страницы">
            <input class="edit" id="item_form_name_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="header[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->header, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
        </tr>
      </table>

      <!-- Meta информация -->
      <table align="center" cellpadding="0" cellspacing="10" class="gray">
        <tr>
          <td class="param">
            URL:
          </td>
          <td class="param_short" width="1%">
            http://сайт/<span id="item_form_url_path"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->url_special)&&($_smarty_tpl->tpl_vars['item']->value->url_special==1)){?> style="display: none;"<?php }?>>sections/</span>
          </td>
          <td class="value" width="100%" title="Окончание адреса специальной страницы">
            <input class="edit" id="item_form_url_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short" title="Будет ли URL без sections/ в начале">
            <input class="checkbox" id="item_form_url_special" name="url_special[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->url_special)&&($_smarty_tpl->tpl_vars['item']->value->url_special==1)){?> checked<?php }?> value="1" onchange="javascript: var object = document.getElementById('item_form_url_path'); if ((typeof(object) == 'object') && (object != null)) object.style.display = this.checked ? 'none' : '';">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_url_special');">
              Особый
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_high">
            Meta Keywords:
          </td>
          <td class="value" colspan="3" title="Какой текст разместить в мета теге &lt;meta name=keywords ...&gt; заголовка страницы">
            <textarea id="item_form_meta_keywords_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_keywords[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 32px;"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->meta_keywords, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
        <tr>
          <td class="param_high">
            Meta Description:
          </td>
          <td class="value" colspan="3" title="Какой текст разместить в мета теге &lt;meta name=description ...&gt; заголовка страницы">
            <textarea id="item_form_meta_description_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 48px;"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->meta_description, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
        <tr>
          <td class="param">
            Meta Title:
          </td>
          <td class="value" colspan="2" width="100%" title="Какой текст разместить в теге &lt;title&gt; заголовка страницы">
            <input class="edit" id="item_form_meta_title_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_title[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->meta_title, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value_box" width="1%">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
      </table>

      <!-- Полный текст -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high">
            Текст страницы:
          </td>
          <td class="<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled==1){?>value<?php }else{ ?>value_box<?php }?>">
            <textarea class="editor_big" id="item_form_description_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="body[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 400px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value->body)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
      </table>

      <!-- Теги -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">

        <!-- поле Теги -->
        <tr>
          <td class="param">
            Теги:
          </td>
          <td class="value" width="100%" title="Ассоциируемые с этой записью теги (перечисляются через запятую)">
            <input class="edit" name="tags[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->tags, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>

          <!-- кнопка Сохранить -->
          <td class="value_box">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
      </table>

      <!-- SEO текст -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high">
            SEO текст:
          </td>
          <td class="<?php if ($_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled==1){?>value<?php }else{ ?>value_box<?php }?>">
            <textarea class="editor_small" name="seo_description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 150px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value->seo_description)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
      </table>

        <!-- Информация о прикреплениях и разрешениях -->
        <table align="center" cellpadding="0" cellspacing="10" class="gray">
            <tr>
                <td class="param">
                    Тип контента:
                </td>
                <td class="value" width="50%" title="Какой тип контента выдает специальная страница пользователю">
                    <select name="module_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
                        <option value=""></option>
                        <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value)){?>
                            <?php $_smarty_tpl->tpl_vars['sid'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->module_id)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                            <?php $_smarty_tpl->tpl_vars['sclass'] = new Smarty_variable(empty($_smarty_tpl->tpl_vars['sid']->value) ? 'staticpage' : false, null, 0);?>
                            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                                <?php if (!empty($_smarty_tpl->tpl_vars['c']->value->valuable)){?>
                                    <?php $_smarty_tpl->tpl_vars['cid'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['c']->value->module_id)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
                                    <?php $_smarty_tpl->tpl_vars['cclass'] = new Smarty_variable(mb_strtolower((($tmp = @$_smarty_tpl->tpl_vars['c']->value->class)===null||$tmp==='' ? '' : $tmp), 'UTF-8'), null, 0);?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cid']->value, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['sid']->value===$_smarty_tpl->tpl_vars['cid']->value||$_smarty_tpl->tpl_vars['sclass']->value===$_smarty_tpl->tpl_vars['cclass']->value){?> selected<?php }?>><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'c->name'),$_smarty_tpl);?>
</option>
                                <?php }?>
                            <?php } ?>
                        <?php }?>
                    </select>
                </td>
                <td class="param_short">
                    <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?section=Templates" title="Перейти на страницу файлов шаблона в админпанели">Шаблоном</a>:
                </td>
                <td class="value" width="50%" title="Каким шаблоном отображать страницу (по умолчанию стандартным)">
                    <input class="edit" name="template[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['inputValue'][0][0]->inputValue(array('from'=>'item->template'),$_smarty_tpl);?>
" />
                </td>
                <td class="param_short">
                    Вес:
                </td>
                <td class="value" title="Число определяет положение специальной страницы выше других с меньшим весом в том же меню">
                    <input class="edit" name="order_num[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->order_num, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
                </td>
                <td class="param_short" title="Будет ли специальная страница скрыта от незарегистрированных пользователей">
                    <input class="checkbox" id="item_form_hidden" name="hidden[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->hidden)&&($_smarty_tpl->tpl_vars['item']->value->hidden==1)){?> checked<?php }?> value="1">
                    <span onclick="javascript: Toggle_PageCheckbox('item_form_hidden');">
                        Скрыта
                    </span>
                </td>
            </tr>
            <tr>
                <td class="param">
                    Меню:
                </td>
                <td class="value" colspan="3" width="100%" title="В какое меню входит специальная страница">

                    <!-- Селектор выбора меню сайта -->
                    <select name="menu_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
                        <option value="0"></option>
                        <?php if (isset($_smarty_tpl->tpl_vars['menus']->value)){?>
                            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->menu_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->menu_id)&&($_smarty_tpl->tpl_vars['item']->value->menu_id==$_smarty_tpl->tpl_vars['c']->value->menu_id)){?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</option>
                            <?php } ?>
                        <?php }?>
                    </select>
                </td>
                <td class="param_short">
                    Просмотры:
                </td>
                <td class="value" title="Счетчик визитов на специальную страницу">
                    <input class="edit" name="browsed[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->browsed, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
                </td>
                <td class="param_short" title="Разрешена ли специальная страница к показу на сайте">
                    <input class="checkbox" id="item_form_enabled" name="enabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->enabled)&&($_smarty_tpl->tpl_vars['item']->value->enabled==1)){?> checked<?php }?> value="1">
                    <span onclick="javascript: Toggle_PageCheckbox('item_form_enabled');">
                        Разрешена
                    </span>
                </td>
            </tr>
            <tr>
                <td class="param">
                    Администратор:
                </td>
                <td class="value" colspan="3" width="100%" title="Кому разрешено администрировать эту страницу">

                    <!-- Создаем селектор пользователей -->
                    <select name="user_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
                        <option value="0">Администратор</option>

                        <!--  -->

                        <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->user_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

                    </select>
                </td>
                <td class="param_short">
                    Плагины:
                </td>
                <td class="value" title="Какие динамические плагины подключить на специальную страницу (список классов модулей через запятую)">
                    <input class="edit" name="objects[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->objects, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
                </td>
                <td class="value_box">
                    <input class="submit" type="submit" value="Сохранить">
                </td>
            </tr>
        </table>

      <!-- Информация по изображениям -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high">
            Изображения:
            <?php if (isset($_smarty_tpl->tpl_vars['item']->value->images)&&!empty($_smarty_tpl->tpl_vars['item']->value->images)){?>
              <br><br><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Section&<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
=*&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE, ENT_QUOTES, 'UTF-8');?>
" onclick="javascript: if (confirm('Это действие удалит все изображения специальной страницы. Вы подтверждаете такую операцию?')) Delete_PageRecordImage('item_form', '*'); return false;" title="Удалить загруженные в специальную страницу изображения">удалить все</a>
            <?php }?>
          </td>
          <td class="value_box">
            <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>
              <?php if (isset($_smarty_tpl->tpl_vars['item']->value->images)&&!empty($_smarty_tpl->tpl_vars['item']->value->images)){?>
                <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->images; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['index']++;
?>
                  <div class="image">
                    <input class="checkbox" name="imageview[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_view[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])&&($_smarty_tpl->tpl_vars['item']->value->images_view[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']]==1)){?> checked<?php }?> value="1" title="Будет ли это изображение использоваться в слайдере или вьювере изображений"><span><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
.</span><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Section&<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE, ENT_QUOTES, 'UTF-8');?>
" onclick="javascript: if (confirm('Это действие удалит указанное изображение специальной страницы. Вы подтверждаете такую операцию?')) Delete_PageRecordImage('item_form', <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
); return false;">удалить</a><br><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_SECTIONS_CLASS_UPLOAD_FOLDER, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
" target="_blank"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
"<?php }?>><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_SECTIONS_CLASS_UPLOAD_FOLDER, ENT_QUOTES, 'UTF-8');?>
<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?>"></a>
                    <div>
                      <input name="image[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
">
                      заголовок (alt):<br>
                      <input name="imagealt[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }?>" title="Заголовок (всплывающая подсказка) этого изображения"><br>
                      описание:<br>
                      <textarea name="imagetext[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" title="Описание этого изображения"><?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_texts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_texts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }?></textarea>
                    </div>
                  </div>
                <?php } ?>
              <?php }?>
              <div style="clear: both;">
                <div class="newimage">
                  новое изображение (объемом не более <?php echo htmlspecialchars(sprintf("%d",(@IMAGE_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт):<br>
                  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf("%d",@IMAGE_UPLOAD_MAXIMAL_FILESIZE), ENT_QUOTES, 'UTF-8');?>
">  <!-- Не позволяем загрузку файла объемом свыше заданного -->
                  <input class="edit" name="new_image[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="file" title="Какой файл изображения требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf("%d",(@IMAGE_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт)"><br><br>
                  или из удаленного источника:<br>
                  <input class="edit" name="new_image_url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="http://" title="Какой файл изображения требуется взять с другого сайта в Интернете"><br><br>
                  дать файлу имя:<br>
                  <input class="edit" id="item_form_filename_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGEFILENAME, ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой сделать начальную часть имени файла нового изображения на сайте (файл будет размещен в папке http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->sections_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_SECTIONS_CLASS_UPLOAD_FOLDER, ENT_QUOTES, 'UTF-8');?>
)"><br><br>
                  <input class="checkbox" id="item_form_imageview" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGEVIEW, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" checked value="1" title="Будет ли это изображение использоваться в слайдере или вьювере изображений">
                  <span onclick="javascript: Toggle_PageCheckbox('item_form_imageview');" title="Будет ли это изображение использоваться в слайдере или вьювере изображений">
                    использовать в слайдере
                  </span>
                  <input class="submit" type="submit" value="Сохранить">
                </div>
                <div class="newimage_options">
                  заголовок (alt) изображения:<br>
                  <input class="edit" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGEALT, ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой заголовок (всплывающую подсказку) дать новому изображению"><br>
                  описание:<br>
                  <textarea name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGETEXT, ENT_QUOTES, 'UTF-8');?>
" style="height: 105px;" title="Какое описание дать новому изображению"></textarea>
                </div>
              </div>
            <?php }else{ ?>
              <div class="hint">
                Управление изображениями станет доступным, когда эта специальная страница будет создана.
              </div>
            <?php }?>
          </td>
        </tr>
      </table>

      <!--  -->
      <?php if (isset($_smarty_tpl->tpl_vars['from_page']->value)&&!empty($_smarty_tpl->tpl_vars['from_page']->value)){?>
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FROM, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['from_page']->value, ENT_QUOTES, 'UTF-8');?>
">
      <?php }?>

      <!-- Добавляем признак наличия данных об изменениях -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST, ENT_QUOTES, 'UTF-8');?>
[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="">

      <!-- Добавляем идентификатор оперируемой записи -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">

      <!-- Добавляем пустой указатель номера изображения -->
      <input id="item_form_<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

      <!-- Добавляем случайный аутентификатор изображения -->
      <input name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGETOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo smarty_function_math(array('equation'=>'rand(1, 100000000)'),$_smarty_tpl);?>
">

      <!-- Добавляем пустой указатель требуемой команды -->
      <input id="item_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

      <!-- Добавляем аутентификатор операции -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
">
    </form>

    <!-- Блок справочной информации -->
    <div class="help">
      <div class="title">
        Справка
      </div>
      <div>
        <b>Особый URL</b>. Любому виду URL разрешено включать в себя путевую структуру, то есть отделять части пути слешем /. Особый URL
        отличается отсутствием в начале адреса специального включения, идентифицирующего принадлежность адреса к разновидности контента - специальные страницы.
        Особым URL допустимо перекрываться с особыми URL других разновидностей контента сайта. В этом случае установлен следующий приоритет
        владения конфликтующим адресом: специальная страница, товар, категория, бренд, статья, новость.
      </div>
      <div>
        <b>Мета</b>. Эта информация используется в заголовке специальной html-страницы. Подобно полю URL, мета информация при ее пустых полях
        автоматически заполняется из полей заголовка и текста специальной страницы, если это разрешено в соответствующих настройках сайта
        (изменить их можно на странице специальных страниц в админпанели).
      </div>
      <div>
        <b>Плагины</b>. Если при просмотре пользователем этой специальной страницы должно происходить подключение расширяющих функционал плагинов,
        необходимо выше в соответствующем поле перечислить через запятую классы их модулей (например: MyBanner, SubscribeForm). Тогда перед
        открытием специальной страницы управление сначала будет передаваться плагинам в порядке их перечисления. Плагину разрешено выполнять
        любые действия, но результатом он возвращает либо замещающий страницу текст, либо каким фрагментом дополнить эту специальную страницу.
      </div>
      <div>
        <b>Изображения</b>. В специальную страницу допустимо загружать произвольное количество картинок. Они могут быть вставлены в текст специальной страницы, а могут
        просто располагаться на сайте для иных целей, например фотогалерея. Изображения могут быть загружены с локального компьютера или из
        удаленного источника (другого сайта). Каждому новому изображению возможно задать его заголовок (alt) - всплывающий текст при наведении
        курсора на картинку, описание - информирующий текст (может использоваться во вьюверах на клиентской стороне), имя файла - по умолчанию
        равно транслитерации заголовка специальной страницы. Имя файла нужно указывать без расширения, справа к имени автоматически добавится цифровой
        идентификатор и расширение. Если имя файла вообще не указано, оно генерируется системой.
      </div>
    </div>

  </div>

  <!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/tinymce.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('disabled_state'=>$_smarty_tpl->tpl_vars['settings']->value->sections_wysiwyg_disabled), 0);?>


  <!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/meta.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('form_id'=>"item_form",'item_id'=>$_smarty_tpl->tpl_vars['id']->value,'autofill'=>$_smarty_tpl->tpl_vars['settings']->value->sections_meta_autofill), 0);?>

<?php }} ?>