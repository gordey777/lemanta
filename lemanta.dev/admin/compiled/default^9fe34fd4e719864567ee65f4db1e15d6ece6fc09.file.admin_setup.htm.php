<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:19
         compiled from "../admin/design/default/html/admin_setup.htm" */ ?>
<?php /*%%SmartyHeaderCode:143485619457d5b6a79ff638-54652363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fe34fd4e719864567ee65f4db1e15d6ece6fc09' => 
    array (
      0 => '../admin/design/default/html/admin_setup.htm',
      1 => 1462406619,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143485619457d5b6a79ff638-54652363',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'root_url' => 0,
    'admin_folder' => 0,
    'error' => 0,
    'Settings' => 0,
    'technical_works_filename' => 0,
    'dates' => 0,
    'date' => 0,
    'Sections' => 0,
    'section' => 0,
    'product_adimage_effect' => 0,
    'seconds' => 0,
    'value_previous' => 0,
    'sort_form_default_method' => 0,
    'deliveries_wysiwyg_disabled_mode' => 0,
    'delivery_conflict_method' => 0,
    'quickorder_sort_method' => 0,
    'cart_open_method' => 0,
    'delete_goods_ancientQ0_lifetime' => 0,
    'delete_goods_ancientS0_lifetime' => 0,
    'Token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a7d25a51_89907921',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a7d25a51_89907921')) {function content_57d5b6a7d25a51_89907921($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"setup",'main'=>true,'setup'=>true,'currencies'=>true,'deliveries'=>true,'deliveries_types'=>true,'shippings_terms'=>true,'payment'=>true,'sms'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/">Главная</a>
        → Настройки
      </div>
      Настройки
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      &nbsp;
    </div>

    <!--  -->

    <?php if (!empty($_smarty_tpl->tpl_vars['error']->value)){?>
      <div class="error">
        <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

      </div>
    <?php }?>

  
    <style>
      select, .input3, .input4, .input5, .editor_counters {color: #000000; font-family: Verdana, Tahoma, Arail; font-size: 10pt;}
    </style>
  

  <script type="text/javascript" src="../js/enlargeit/enlargeit.js"></script>

          <form enctype="multipart/form-data" method="post">
            <div id="over">
              <table>
                <tr>
                  <td class="td_padding">
                    <a name="Site"></a>
                    Название сайта:
                  </td>
                  <td class="td_padding">
                    <p>
                      <input type="text" class="input3" name="site_name" style="width: 97%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->site_name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    Организация:
                  </td>
                  <td class="td_padding">
                    <p>
                      <input type="text" class="input3" name="company_name" style="width: 97%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->company_name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    Емейл админа:
                  </td>
                  <td class="td_padding">
                    <p>
                      <input type="text" class="input3" name="admin_email" style="width: 97%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->admin_email)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    Обратный email уведомлений
                  </td>
                  <td class="td_padding">
                    <p>
                      <input type="text" class="input3" name="notify_from_email" style="width: 97%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->notify_from_email)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    Главная страница:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <input name="technical_works_enabled" style="width: 20px;" type="checkbox" value="1"<?php if (isset($_smarty_tpl->tpl_vars['Settings']->value->technical_works_enabled)&&$_smarty_tpl->tpl_vars['Settings']->value->technical_works_enabled){?> checked<?php }?>>
                      Вывесить сообщение о технических работах на сайте
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 0px;">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 0px;">
                      Размещение шаблона вывески:
                    </div>
                    <div style="color: #C0C0C0; font-size: 7pt;">
                      &nbsp;&nbsp;&nbsp;design/тема/html/technical.works.tpl
                    </div>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      При отсутствии шаблона будет использован замещающий текст.
                      Работоспособность установленной вывески о технических работах
                      не зависит от дальнейших манипуляций с базой данных и изменений
                      файлов сайта (лишь бы существовали два корневых .htaccess, index.php,
                      сам временно сгенерированный файл вывески о работах "<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['technical_works_filename']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
"
                      и "objects/Definition.php"). Необходимо также понимать,
                      что вывеска будет видна на всех страницах сайта, и при длительном
                      вывешивании должна быть составлена так, чтобы нанести наименьший
                      ущерб уже проиндексированным страницам в поисковых системах.
                    </div>
                  </td>
                  <td class="td_padding" width="100%">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 0px;">
                      вывеску увидят посетители магазина, для администратора сайт будет работать в прежнем режиме
                    </div>
                    <p style="padding-top: 0px;">
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td colspan="2">
                            Замещающий текст, если нет шаблона вывески:
                          </td>
                          <td>
                            &nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="25%">
                            Время окончания:
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="75%">
                            <textarea class="editor" style="width: 100%; height: 150px;" name="technical_works_html"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->technical_works_html)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea>
                          </td>
                          <td>
                            &nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="25%">
                            <p>
                              <select name="technical_works_date" style="width: 100%;">
                                <option value="">
                                </option>
                                <?php  $_smarty_tpl->tpl_vars['date'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['date']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['dates']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['date']->key => $_smarty_tpl->tpl_vars['date']->value){
$_smarty_tpl->tpl_vars['date']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['dates']['index']++;
?>
                                  <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['dates']['index']<32){?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['date']->value, ENT_QUOTES, 'UTF-8');?>
"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->technical_works_date)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['date']->value){?> selected<?php }?>>
                                      <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['date']->value, ENT_QUOTES, 'UTF-8');?>

                                    </option>
                                  <?php }?>
                                <?php } ?>
                              </select>
                            </p>
                            <p>
                              <select name="technical_works_time" style="width: 100%;">
                                <option value="">
                                </option>
                                <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["times"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['name'] = "times";
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['loop'] = is_array($_loop=24) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["times"]['total']);
?>
                                  <?php $_smarty_tpl->_capture_stack[0][] = array("times_value", null, null); ob_start(); ?>в <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['times']['index'];?>
:00<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                                  <option value="<?php echo Smarty::$_smarty_vars['capture']['times_value'];?>
"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->technical_works_time)===null||$tmp==='' ? '' : $tmp)==Smarty::$_smarty_vars['capture']['times_value']){?> selected<?php }?>>
                                    <?php echo Smarty::$_smarty_vars['capture']['times_value'];?>

                                  </option>
                                <?php endfor; endif; ?>
                              </select>
                            </p>
                            <div style="color: #C0C0C0; font-size: 8pt; padding: 5px;">
                              вывеска не исчезает сама, отключается только админом, а установка времени носит чисто информативный характер
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td colspan="3">
                            <div style="color: #C0C0C0; font-size: 8pt; padding: 0px;">
                              в теле замещающего текста допустимо использовать теги: {$date} - дата окончания работ, {$time} - время окончания
                            </div>
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 0px;">
                      Сайт открывать на странице:&nbsp;
                      <select name="main_section">
                        <?php  $_smarty_tpl->tpl_vars['section'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['section']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['Sections']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['section']->key => $_smarty_tpl->tpl_vars['section']->value){
$_smarty_tpl->tpl_vars['section']->_loop = true;
?>
                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['section']->value->url, ENT_QUOTES, 'UTF-8');?>
"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->main_section)===null||$tmp==='' ? '' : $tmp)==$_smarty_tpl->tpl_vars['section']->value->url){?> selected<?php }?>>
                              <?php echo $_smarty_tpl->tpl_vars['section']->value->name;?>
 [меню <?php echo $_smarty_tpl->tpl_vars['section']->value->menu_id;?>
]
                            </option>
                        <?php } ?>
                      </select>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      если список пуст, создайте <a href="index.php?section=Sections">специальную страницу</a> с типом контента например "Товары" и прикрепленную в <a href="index.php?section=Menus">меню</a> "Верхнее меню"
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="mainpage_no_articles" style="width: 20px;" type="checkbox" value="1"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->mainpage_no_articles)===null||$tmp==='' ? '' : $tmp)==1){?> checked<?php }?>>
                      Не выводить блок "Статьи" на главную
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне сайта, появится на главной странице
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="mainpage_sortform_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->mainpage_sortform_enabled==1){?> checked<?php }?>>
                      Показать форму сортировки товаров на главной
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      показ этой формы <span style="color: #C00000;">перекрывает</span> способы расстановки товаров в перечисленных выше блоках на главной
                    </div>
                    <p style="padding-top: 10px;">
                      Меню каталога вывести:&nbsp;
                      <select name="catalog_menu_mode">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->catalog_menu_mode==0){?> selected<?php }?>>вертикально развёрнутым списком</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->catalog_menu_mode==1){?> selected<?php }?>>вертикально с выпадающими ветвями</option>
                      </select>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="catalog_menu_noempty" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->catalog_menu_noempty==1){?> checked<?php }?>>
                      Спрятать пустые категории
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе категории без товаров также будут выведены в меню каталога
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="catalog_menu_nocount" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->catalog_menu_nocount==1){?> checked<?php }?>>
                      Не показывать количество товаров в категориях
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе рядом с каждой категорией будет указано количество товаров в ней
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="catalog_menu_adminedit" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->catalog_menu_adminedit==1){?> checked<?php }?>>
                      Разрешить админ функции на элементах меню каталога
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе на категориях каталога не будет выпадать меню с админскими функциями
                    </div>
                    <p style="padding-top: 10px;">
                      Коды счетчиков на страницах:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <textarea class="editor_counters" style="width: 100%; height: 150px;" name="counters"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->counters)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea>
                          </td>
                        </tr>
                      </table>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="ProductPage"></a>
                    Страница товара:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      В дополнительных блоках выводить товары в&nbsp;
                      <input type="text" class="input4" name="productpage_block_columns" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_block_columns, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;колонок
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 0px;">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 0px;">
                      В дополнительные блоки из перечня соответствующих им товаров, находящихся
                      в той же категории, что и товар на открытой странице, отбирается случайным
                      образом обозначенное число товаров. Причём если товар с открытой страницы
                      по своим признакам также принадлежит перечню соответствующих блоку товаров,
                      этот товар исключается из отбираемых. Таким образом дополнительные блоки
                      содержат товары, кроме текущего.
                    </div>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Если отобранного в блок товара оказывается меньше обозначенного количества
                      и для блока разрешено дополнение недостающих из родительской категории,
                      недостающее число товаров аналогично добирается из верхней категории (при
                      отсутствии там - из более верхней, и так далее до вершины дерева категорий).
                    </div>
                  </td>
                  <td class="td_padding" width="100%">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 0px;">
                      игнорируется, если используется page.box.product_lined.tpl - субшаблон вывода карточки товара в строку
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_mores" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_mores==1){?> checked<?php }?>>
                      Не выводить блок "Похожие продукты"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_mores_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_mores_caption)===null||$tmp==='' ? 'Похожие продукты' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_mores_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_mores_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_mores_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_mores_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_mores_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_mores_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_hits" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_hits==1){?> checked<?php }?>>
                      Не выводить блок "Хиты продаж"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_hits_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_hits_caption)===null||$tmp==='' ? 'Хиты продаж' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_hits_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_hits_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_hits_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_hits_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_hits_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_hits_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_newests" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_newests==1){?> checked<?php }?>>
                      Не выводить блок "Новые поступления"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_newests_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_newests_caption)===null||$tmp==='' ? 'Новые поступления' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_newests_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_newests_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_newests_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_newests_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_newests_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_newests_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_actionals" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_actionals==1){?> checked<?php }?>>
                      Не выводить блок "Специальное предложение (Акция)"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_actionals_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_actionals_caption)===null||$tmp==='' ? 'Специальное предложение' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_actionals_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_actionals_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_actionals_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_actionals_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_actionals_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_actionals_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_awaiteds" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_awaiteds==1){?> checked<?php }?>>
                      Не выводить блок "Скоро в продаже"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_awaiteds_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_awaiteds_caption)===null||$tmp==='' ? 'Скоро в продаже' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_awaiteds_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_awaiteds_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_awaiteds_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_awaiteds_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_awaiteds_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_awaiteds_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_ordereds" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_ordereds==1){?> checked<?php }?>>
                      Не выводить блок "Что покупают другие"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_ordereds_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_ordereds_caption)===null||$tmp==='' ? 'Что покупают другие' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_ordereds_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_ordereds_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_ordereds_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_ordereds_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_ordereds_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_ordereds_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="productpage_no_commenteds" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_no_commenteds==1){?> checked<?php }?>>
                      Не выводить блок "О чём отзываются"
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе этот блок, если он прописан в шаблоне page.product.tpl (или product.tpl), появится на странице товара
                    </div>
                    <p style="padding-top: 5px;">
                      <table align="0" border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 28px; vertical-align: middle;">
                            Текст заголовка:&nbsp;&nbsp;
                          </td>
                          <td width="100%">
                            <input type="text" class="input4" name="productpage_commenteds_caption" style="width: 100%;" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->productpage_commenteds_caption)===null||$tmp==='' ? 'О чём отзываются' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_commenteds_excludeme" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_commenteds_excludeme==1){?> checked<?php }?>>
                      Исключить текущий товар, если принадлежит блоку
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="productpage_commenteds_spacefill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->productpage_commenteds_spacefill==1){?> checked<?php }?>>
                      Дополнять недостающие из родительских категорий&nbsp;
                      <b style="font-weight: normal;">
                        &nbsp;|&nbsp
                        выводить не более&nbsp; <input type="text" class="input4" name="productpage_commenteds_count" style="width: 50px;" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->productpage_commenteds_count, ENT_QUOTES, 'UTF-8');?>
"> &nbsp;штук
                      </b>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе будет выбрано максимально доступное (но не более указанного) число товаров только из его категории
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="Images"></a>
                    Картинки:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 0px;">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 0px;">
                      &nbsp;
                    </div>
                  </td>
                  <td class="td_padding" width="100%">
                    <table border="0" cellpadding="0" cellspacing="0" width="97%">
                      <tr>
                        <td colspan="2">
                          <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 5px;">
                            использовать эффект:&nbsp;
                            <?php $_smarty_tpl->tpl_vars["product_adimage_effect"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->product_adimage_effect)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                            <select name="product_adimage_effect">
                              <option value="enlarge"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="enlarge"){?> selected<?php }?>>Разложить змейкой, увеличивать по щелчку</option>
                              <option value="shuffle"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="shuffle"){?> selected<?php }?>>Стопкой, прежнюю перекладывать под низ</option>
                              <option value="fadeout"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="fadeout"){?> selected<?php }?>>Проявлять, прежнюю затенять</option>
                              <option value="scrollUp"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="scrollUp"){?> selected<?php }?>>Прокручивать вверх</option>
                              <option value="scrollDown"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="scrollDown"){?> selected<?php }?>>Прокручивать вниз</option>
                              <option value="scrollLeft"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="scrollLeft"){?> selected<?php }?>>Прокручивать влево</option>
                              <option value="scrollRight"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="scrollRight"){?> selected<?php }?>>Прокручивать вправо</option>
                              <option value="slideX"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="slideX"){?> selected<?php }?>>Разжимать слева, прежнюю сжимать влево</option>
                              <option value="slideY"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="slideY"){?> selected<?php }?>>Разжимать сверху, прежнюю сжимать вверх</option>
                              <option value="turnUp"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="turnUp"){?> selected<?php }?>>Выжимать вверх</option>
                              <option value="turnDown"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="turnDown"){?> selected<?php }?>>Выжимать вниз</option>
                              <option value="turnLeft"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="turnLeft"){?> selected<?php }?>>Выжимать влево</option>
                              <option value="turnRight"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="turnRight"){?> selected<?php }?>>Выжимать вправо</option>
                              <option value="zoom"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="zoom"){?> selected<?php }?>>Приближать, прежнюю отдалять</option>
                              <option value="fadeZoom"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="fadeZoom"){?> selected<?php }?>>Приближать, прежнюю затенять</option>
                              <option value="blindX"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="blindX"){?> selected<?php }?>>Выдвигать справа, прежнюю вдвигать обратно</option>
                              <option value="blindY"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="blindY"){?> selected<?php }?>>Выдвигать снизу, прежнюю вдвигать обратно</option>
                              <option value="blindZ"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="blindZ"){?> selected<?php }?>>Выдвигать с правого нижнего угла, прежнюю вдвигать обратно</option>
                              <option value="growX"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="growX"){?> selected<?php }?>>Разжимать от центра в стороны</option>
                              <option value="growY"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="growY"){?> selected<?php }?>>Разжимать от центра в верх и низ</option>
                              <option value="curtainX"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="curtainX"){?> selected<?php }?>>Разжимать от центра в стороны и сжимать обратно</option>
                              <option value="curtainY"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="curtainY"){?> selected<?php }?>>Разжимать от центра в верх и низ и сжимать обратно</option>
                              <option value="cover"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="cover"){?> selected<?php }?>>Накрывать прежнюю справа</option>
                              <option value="uncover"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="uncover"){?> selected<?php }?>>Выдвигать прежнюю влево</option>
                              <option value="toss"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="toss"){?> selected<?php }?>>Отбрасывать прежнюю в сторону с затенением</option>
                              <option value="wipe"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="wipe"){?> selected<?php }?>>Прорисовывать новую с левого верхнего угла</option>
<!--                              <option value="scrollable"<?php if ($_smarty_tpl->tpl_vars['product_adimage_effect']->value=="scrollable"){?> selected<?php }?>>Разложить в линию с прокруткой</option> -->
                            </select>
                          </p>
                          <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px; padding-bottom: 5px;">
                            как листать дополнительные картинки товара на его странице (при одной картинке эффект не используется)
                          </div>
                        </td>
                      </tr>
                    </table>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="prepath_images_template_used" style="width: 20px;" type="checkbox" value="1"<?php if (isset($_smarty_tpl->tpl_vars['Settings']->value->prepath_images_template_used)&&$_smarty_tpl->tpl_vars['Settings']->value->prepath_images_template_used){?> checked<?php }?>>
                      Сейчас используется шаблон (дизайн) с предопределёнными в нём путями картинок
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе восхождением к корню сайта отыскивается размещение картинок и в шаблон передаются их путь + имя файла
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="images_caching_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->images_caching_enabled==1){?> checked<?php }?>>
                      Разрешить кеширование картинок из внешних источников
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе будут использоваться оригинальные картинки, если к этому моменту они не были закешированы
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      Повторно кешировать картинки через:&nbsp;
                      <select name="images_caching_lifetime">
                        <?php $_smarty_tpl->tpl_vars["value_previous"] = new Smarty_variable(0, null, 0);?>
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=24) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                          <?php $_smarty_tpl->tpl_vars["seconds"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']*3600, null, 0);?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['seconds']->value;?>
"<?php if (($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime>$_smarty_tpl->tpl_vars['value_previous']->value)&&($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime<=$_smarty_tpl->tpl_vars['seconds']->value)){?> selected<?php }?>>
                            <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
 час<?php if (($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10<1)||($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>4)||(($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']>=10)&&($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']<=19))){?>ов<?php }elseif($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>1){?>а<?php }?>
                          </option>
                          <?php $_smarty_tpl->tpl_vars["value_previous"] = new Smarty_variable($_smarty_tpl->tpl_vars['seconds']->value, null, 0);?>
                        <?php endfor; endif; ?>
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=7) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                          <?php $_smarty_tpl->tpl_vars["seconds"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']*24*3600, null, 0);?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['seconds']->value;?>
"<?php if (($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime>$_smarty_tpl->tpl_vars['value_previous']->value)&&($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime<=$_smarty_tpl->tpl_vars['seconds']->value)){?> selected<?php }?>>
                            <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
 сут<?php if (($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10<1)||($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>4)||(($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']>=10)&&($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']<=19))){?>ок<?php }elseif($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>1){?>ок<?php }else{ ?>ки<?php }?>
                          </option>
                          <?php $_smarty_tpl->tpl_vars["value_previous"] = new Smarty_variable($_smarty_tpl->tpl_vars['seconds']->value, null, 0);?>
                        <?php endfor; endif; ?>
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=16) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                          <?php $_smarty_tpl->tpl_vars["seconds"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']*7*24*3600, null, 0);?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['seconds']->value;?>
"<?php if (($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime>$_smarty_tpl->tpl_vars['value_previous']->value)&&($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime<=$_smarty_tpl->tpl_vars['seconds']->value)){?> selected<?php }?>>
                            <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
 недел<?php if (($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10<1)||($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>4)||(($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']>=10)&&($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']<=19))){?>ь<?php }elseif($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>1){?>и<?php }else{ ?>ю<?php }?>
                          </option>
                          <?php $_smarty_tpl->tpl_vars["value_previous"] = new Smarty_variable($_smarty_tpl->tpl_vars['seconds']->value, null, 0);?>
                        <?php endfor; endif; ?>
                        <?php $_smarty_tpl->tpl_vars["seconds"] = new Smarty_variable(15552000, null, 0);?>
                        <option value="$seconds"<?php if (($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime>$_smarty_tpl->tpl_vars['value_previous']->value)&&($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime<=$_smarty_tpl->tpl_vars['seconds']->value)){?> selected<?php }?>>
                          полгода
                        </option>
                        <?php $_smarty_tpl->tpl_vars["value_previous"] = new Smarty_variable($_smarty_tpl->tpl_vars['seconds']->value, null, 0);?>
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                          <?php $_smarty_tpl->tpl_vars["seconds"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']*365*24*3600, null, 0);?>
                          <option value="<?php echo $_smarty_tpl->tpl_vars['seconds']->value;?>
"<?php if (($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime>$_smarty_tpl->tpl_vars['value_previous']->value)&&($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime<=$_smarty_tpl->tpl_vars['seconds']->value)){?> selected<?php }?>>
                            <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
 <?php if (($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10<1)||($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>4)||(($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']>=10)&&($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']<=19))){?>лет<?php }elseif($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>1){?>года<?php }else{ ?>год<?php }?>
                          </option>
                          <?php $_smarty_tpl->tpl_vars["value_previous"] = new Smarty_variable($_smarty_tpl->tpl_vars['seconds']->value, null, 0);?>
                        <?php endfor; endif; ?>
                        <option value="2147483647"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->images_caching_lifetime>$_smarty_tpl->tpl_vars['value_previous']->value){?> selected<?php }?>>
                          никогда
                        </option>
                      </select>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      За один раз кешировать не более:&nbsp;
                      <select name="images_caching_filelimit">
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=101) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                          <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->images_caching_filelimit==$_smarty_tpl->getVariable('smarty')->value['section']['value']['index']){?> selected<?php }?>>
                            <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
 файл<?php if (($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10<1)||($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>4)||(($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']>=10)&&($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']<=19))){?>ов<?php }elseif($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>1){?>ов<?php }else{ ?>а<?php }?>
                          </option>
                        <?php endfor; endif; ?>
                      </select>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      Прерывать кеширование, если на картинку тратится более:&nbsp;
                      <select name="images_caching_timelimit">
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=121) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['total']);
?>
                          <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->images_caching_timelimit==$_smarty_tpl->getVariable('smarty')->value['section']['value']['index']){?> selected<?php }?>>
                            <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
 секун<?php if (($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10<1)||($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>4)||(($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']>=10)&&($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']<=19))){?>д<?php }elseif($_smarty_tpl->getVariable('smarty')->value['section']['value']['index']%10>1){?>д<?php }else{ ?>ды<?php }?>
                          </option>
                        <?php endfor; endif; ?>
                      </select>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      IP-адресатор внешних источников:<br>
                      <textarea class="editor_counters" name="images_caching_ip_resolves" style="width: 97%; height: 100px;"><?php echo $_smarty_tpl->tpl_vars['Settings']->value->images_caching_ip_resolves;?>
</textarea>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      содержит построчное перечисление пар "домен" и через пробел его "ip-адрес" для важных источников
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="images_caching_for_localhost_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->images_caching_for_localhost_enabled==1){?> checked<?php }?>>
                      Также позволять кеширование, вызываемое с локального хоста
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="Misc"></a>
                    Разное:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p style="padding-top: 10px;">
                      ID онлайн консультации (чата):&nbsp;
                      <input type="text" class="input5" name="livehelp_siteheart_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->livehelp_siteheart_id, ENT_QUOTES, 'UTF-8');?>
">
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      этот идентификатор получают после регистрации на сайте Siteheart.com
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="sort_form_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->sort_form_enabled==1){?> checked<?php }?>>
                      Показывать форму сортировки товаров в списках
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе товары в списках будут упорядочены как расставлены на странице "Товары → Товары → <a href="index.php?section=Products&type=1&sort=1">любого типа</a>" 
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      Форма сортировки открывается на варианте:&nbsp;
                      <?php $_smarty_tpl->tpl_vars["sort_form_default_method"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->sort_form_default_method)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
                      <select name="sort_form_default_method">
                        <option value="<?php echo htmlspecialchars(@SORT_PRODUCTS_MODE_DEFAULT, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['sort_form_default_method']->value==@SORT_PRODUCTS_MODE_DEFAULT){?> selected<?php }?>>стандартно (как задано в настройках страницы товаров админпанели)</option>
                        <option value="<?php echo htmlspecialchars(@SORT_PRODUCTS_MODE_BY_PRICE, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['sort_form_default_method']->value==@SORT_PRODUCTS_MODE_BY_PRICE){?> selected<?php }?>>по цене</option>
                        <option value="<?php echo htmlspecialchars(@SORT_PRODUCTS_MODE_BY_NAME, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['sort_form_default_method']->value==@SORT_PRODUCTS_MODE_BY_NAME){?> selected<?php }?>>по названию</option>
                      </select>
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      по умолчанию в форме сортировки будет выбран такой вариант сортировки
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <input name="sort_form_default_descending" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->sort_form_default_descending==1){?> checked<?php }?>>
                      в обратном порядке
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 56px; padding-top: 5px;">
                      иначе по умолчанию в форме сортировки будет выбран вариант сортировки в прямом порядке
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="product_category_show" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->product_category_show==1){?> checked<?php }?>>
                      Добавлять название категории спереди к названию товара
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе подразумевается, что название категории уже вписано в название товара
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="product_brand_show" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->product_brand_show==1){?> checked<?php }?>>
                      Добавлять название бренда спереди к названию товара
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе подразумевается, что название бренда уже вписано в название товара
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="meta_autofill" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->meta_autofill&&($_smarty_tpl->tpl_vars['Settings']->value->meta_autofill==1)){?> checked<?php }?>>
                      Заполнять поля метатегов автоматически
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе при редактировании товаров, категорий, брендов, статей, новостей, страниц эти поля нужно заполнять вручную
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="EditorsUsing"></a>
                    Использование редактора:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <input name="deliveries_wysiwyg_disabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->deliveries_wysiwyg_disabled==1){?> checked<?php }?>>
                      Отключить WYSIWYG-редактор в способах доставки
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 10px;">
                    При отключении визуального редактора в зависимости от сопутствующей настройки отредактированный
                    текст или останется неизменным, или из него будут удаляться все теги, убираться пустые строки, сокращаться до одного
                    множественные пробелы, а каждая непустая строка в местах переноса будет
                    заключена в пару тегов &lt;p&nbsp;style="text-align:&nbsp;justify;"&gt;&lt;/p&gt;
                  </td>
                  <td class="td_padding" width="100%">
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <?php $_smarty_tpl->tpl_vars["deliveries_wysiwyg_disabled_mode"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->deliveries_wysiwyg_disabled_mode)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
                      как обрабатывать текст:&nbsp;
                      <select name="deliveries_wysiwyg_disabled_mode">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['deliveries_wysiwyg_disabled_mode']->value==0){?> selected<?php }?>>ничего не менять, не трогать разметочные теги</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['deliveries_wysiwyg_disabled_mode']->value==1){?> selected<?php }?>>удалять все теги, пустые строки и лишние пробелы</option>
                      </select>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    Доставка:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <?php $_smarty_tpl->tpl_vars["delivery_conflict_method"] = new Smarty_variable($_smarty_tpl->tpl_vars['Settings']->value->delivery_conflict_method, null, 0);?>
                      Неиспользуемые способы доставки:&nbsp;
                      <select name="delivery_conflict_method">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['delivery_conflict_method']->value==0){?> selected<?php }?>>всё равно добавлять в форму заказа</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['delivery_conflict_method']->value==1){?> selected<?php }?>>отбрасывать, если запрещена у всех заказанных</option>
                        <option value="2"<?php if ($_smarty_tpl->tpl_vars['delivery_conflict_method']->value==2){?> selected<?php }?>>отбрасывать, если запрещена хотя бы у одного</option>
                      </select>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    Быстрый заказ:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <?php $_smarty_tpl->tpl_vars["quickorder_sort_method"] = new Smarty_variable($_smarty_tpl->tpl_vars['Settings']->value->quickorder_sort_method, null, 0);?>
                      Способ сортировки категорий:&nbsp;
                      <select name="quickorder_sort_method">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['quickorder_sort_method']->value==0){?> selected<?php }?>>как расставлены на странице "Товары → Категории"</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['quickorder_sort_method']->value==1){?> selected<?php }?>>по алфавиту</option>
                      </select>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt;">
                    Эти настройки предназначены для страницы быстрого заказа в клиентской
                    части магазина.
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Размещение шаблона быстрого заказа:
                    </div>
                    <div style="color: #C0C0C0; font-size: 7pt;">
                      &nbsp;&nbsp;&nbsp;design/тема/html/page.configurator.tpl
                    </div>
                    <div style="color: #C0C0C0; font-size: 8pt;">
                      Его субшаблон:
                    </div>
                    <div style="color: #C0C0C0; font-size: 7pt;">
                      &nbsp;&nbsp;&nbsp;design/common_parts/configurator_htm.tpl<br>
                      &nbsp;&nbsp;&nbsp;design/common_parts/configurator_css.tpl
                    </div>
                    <p style="color: #C0C0C0; font-size: 8pt; padding-top: 10px;">
                      Для подключения функционала быстрого заказа необходимо в магазине
                      разместить ссылку на страницу http://сайт/quickorder/ и в шаблоне быстрого
                      заказа в самом простом случае, когда нет нужды в переделке стандартного вида заказа, сделать
                      следующий вызов его субшаблона:
                    </p>
                    <p style="color: #C0C0C0; font-size: 7pt; padding-top: 10px; white-space: nowrap;">
                      
                        {include file="../../common_parts/configurator_css.tpl"}<br>
                        {include file="../../common_parts/configurator_htm.tpl"}
                      
                    </p>
                    <p style="color: #C0C0C0; font-size: 8pt; padding-top: 10px;">
                      Здесь первая строка вызывает таблицу стилей субшаблона и вторая - сам субшаблон непосредственно.
                      Если требуется изменить стили, можно переопределить их сразу после строки вызова таблицы стилей
                      субшаблона, например
                    </p>
                    <p style="color: #C0C0C0; font-size: 7pt; padding-top: 10px; white-space: nowrap;">
                      
                        {include file="../../common_parts/configurator_css.tpl"}<br>
                        &lt;style&gt;<br>
                        &nbsp;&nbsp;.configurator_link {color: red;}<br>
                        &lt;/style&gt;<br>
                        {include file="../../common_parts/configurator_htm.tpl"}
                      
                    </p>
                    <p style="color: #C0C0C0; font-size: 8pt; padding-top: 10px;">
                      или вместо таблицы стилей субшаблона сделать вызов собственного CSS-файла (во избежание затирания
                      ваших правок при обновлениях пакета доработок не рекомендуется делать изменения в файлах папки
                      design/common_parts/).
                    </p>
                  </td>
                  <td class="td_padding" width="100%">
                    <p style="padding-top: 0px;">
                      <input name="quickorder_captcha_protecting" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_captcha_protecting==1){?> checked<?php }?>>
                      Применять защиту от роботов вводом кода с картинки
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе отправка заказов будет доступна и автоматическим системам
                    </div>
                    <p style="padding-top: 10px;">
                      Текст заголовка страницы:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="quickorder_title_text" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_title_text;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Инструкция:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <input name="quickorder_show_info" style="width: 20px;" title="Выводить ли эту инструкцию в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_info==1){?> checked<?php }?>>
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <textarea class="editor_counters" name="quickorder_info_text" style="width: 100%; height: 150px;"><?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_info_text;?>
</textarea>
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Надписи к полям заказа и какие из них выводить:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_name" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_name==1){?> checked<?php }?>>
                          </td>
                          <td colspan="3" style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td width="33%">
                                  фамилия:<br>
                                  <input class="input4" name="quickorder_label_name" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_name;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_name3" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_name3==1){?> checked<?php }?>>
                                </td>
                                <td width="33%">
                                  имя:<br>
                                  <input class="input4" name="quickorder_label_name3" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_name3;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_name2" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_name2==1){?> checked<?php }?>>
                                </td>
                                <td width="33%">
                                  отчество:<br>
                                  <input class="input4" name="quickorder_label_name2" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_name2;?>
">
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_email" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_email==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            е-мейл:<br>
                            <input class="input4" name="quickorder_label_email" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_email;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_email2" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_email2==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            дополнительный е-мейл:<br>
                            <input class="input4" name="quickorder_label_email2" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_email2;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_phone" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_phone==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            телефон:<br>
                            <input class="input4" name="quickorder_label_phone" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_phone;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_phone2" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_phone2==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            дополнительный телефон:<br>
                            <input class="input4" name="quickorder_label_phone2" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_phone2;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_address_10" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_10==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            почтовый индекс:<br>
                            <input class="input4" name="quickorder_label_address_10" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_10;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_address2_10" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_10==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            почтовый индекс (дополнительный адрес):<br>
                            <input class="input4" name="quickorder_label_address2_10" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_10;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_address" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            страна:<br>
                            <input class="input4" name="quickorder_label_address" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_address2" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            страна (дополнительный адрес):<br>
                            <input class="input4" name="quickorder_label_address2" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_address_2" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_2==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            область:<br>
                            <input class="input4" name="quickorder_label_address_2" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_2;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_address2_2" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_2==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            область (дополнительный адрес):<br>
                            <input class="input4" name="quickorder_label_address2_2" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_2;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_address_3" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_3==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            город:<br>
                            <input class="input4" name="quickorder_label_address_3" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_3;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_address2_3" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_3==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            город (дополнительный адрес):<br>
                            <input class="input4" name="quickorder_label_address2_3" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_3;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_address_4" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_4==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            улица:<br>
                            <input class="input4" name="quickorder_label_address_4" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_4;?>
">
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_address2_4" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_4==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            улица (дополнительный адрес):<br>
                            <input class="input4" name="quickorder_label_address2_4" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_4;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_address_5" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_5==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td width="20%">
                                  дом:<br>
                                  <input class="input4" name="quickorder_label_address_5" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_5;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address_6" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_6==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  корп:<br>
                                  <input class="input4" name="quickorder_label_address_6" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_6;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address_7" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_7==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  под:<br>
                                  <input class="input4" name="quickorder_label_address_7" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_7;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address_8" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_8==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  код:<br>
                                  <input class="input4" name="quickorder_label_address_8" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_8;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address_9" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address_9==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  кв:<br>
                                  <input class="input4" name="quickorder_label_address_9" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address_9;?>
">
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_address2_5" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_5==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr>
                                <td width="20%">
                                  дом:<br>
                                  <input class="input4" name="quickorder_label_address2_5" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_5;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address2_6" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_6==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  кор:<br>
                                  <input class="input4" name="quickorder_label_address2_6" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_6;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address2_7" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_7==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  под:<br>
                                  <input class="input4" name="quickorder_label_address2_7" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_7;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address2_8" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_8==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  код:<br>
                                  <input class="input4" name="quickorder_label_address2_8" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_8;?>
">
                                </td>
                                <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px; padding-right: 5px;">
                                  <br>
                                  <input name="quickorder_show_address2_9" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_address2_9==1){?> checked<?php }?>>
                                </td>
                                <td width="20%">
                                  кв:<br>
                                  <input class="input4" name="quickorder_label_address2_9" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_address2_9;?>
">
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_to_date" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_to_date==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            желаемая дата доставки:<br>
                            <input class="input4" name="quickorder_label_to_date" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_to_date;?>
"><br>
                            <span style="color: #000000; padding-left: 20px;">
                              <input name="quickorder_to_date_editable" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_to_date_editable==1){?> checked<?php }?>>
                              не предлагать выбор из списка в этом поле
                            </span>
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px; padding-left: 5px;">
                            <br>
                            <input name="quickorder_show_to_time" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_to_time==1){?> checked<?php }?>>
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="50%">
                            желаемое время доставки:<br>
                            <input class="input4" name="quickorder_label_to_time" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_to_time;?>
"><br>
                            <span style="color: #000000; padding-left: 20px;">
                              <input name="quickorder_to_time_editable" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_to_time_editable==1){?> checked<?php }?>>
                              не предлагать выбор из списка в этом поле
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_comment" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_comment==1){?> checked<?php }?>>
                          </td>
                          <td colspan="3" style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="100%">
                            комментарий к заказу:<br>
                            <input class="input4" name="quickorder_label_comment" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_comment;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <br>
                            <input name="quickorder_show_delivery" style="width: 20px;" title="Выводить ли это поле в заказе" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->quickorder_show_delivery==1){?> checked<?php }?>>
                          </td>
                          <td colspan="3" style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="100%">
                            доставка:<br>
                            <input class="input4" name="quickorder_label_delivery" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_label_delivery;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Заголовки колонок таблицы:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="25%">
                            категория:<br>
                            <input class="input4" name="quickorder_header_category" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_header_category;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="25%">
                            наименование:<br>
                            <input class="input4" name="quickorder_header_name" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_header_name;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="25%">
                            количество:<br>
                            <input class="input4" name="quickorder_header_quantity" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_header_quantity;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="25%">
                            сумма:<br>
                            <input class="input4" name="quickorder_header_sum" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_header_sum;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Текст кнопки отправки заказа:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="quickorder_submit_text" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->quickorder_submit_text;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    Корзина:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <?php $_smarty_tpl->tpl_vars["cart_open_method"] = new Smarty_variable($_smarty_tpl->tpl_vars['Settings']->value->cart_open_method, null, 0);?>
                      Способ открытия корзины:&nbsp;
                      <select name="cart_open_method">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['cart_open_method']->value==0){?> selected<?php }?>>переходом на её страницу</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['cart_open_method']->value==1){?> selected<?php }?>>появлением поверх текущей страницы</option>
                        <option value="2"<?php if ($_smarty_tpl->tpl_vars['cart_open_method']->value==2){?> selected<?php }?>>появлением плашки "Товар добавлен в корзину"</option>
                      </select>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt;">
                    Эти настройки предназначены для страницы корзины.
                  </td>
                  <td class="td_padding" width="100%">
                    <p style="padding-top: 0px;">
                      <input name="cart_enable_reservation" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->cart_enable_reservation==1){?> checked<?php }?>>
                      Разрешить продажу товаров под заказ
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе у отсутствующих на складе товаров не появится кнопка "Под заказ" и их невозможно будет купить
                    </div>
                    <p>
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td nowrap style="font-size: 10pt; font-weight: bold; padding-left: 18px; padding-right: 5px; vertical-align: middle;">
                            Маркер покупаемого под заказ:
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="cart_reservation_text" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_reservation_text;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>

                    <p style="padding-top: 10px;">
                      <input name="cart_captcha_protecting" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->cart_captcha_protecting==1){?> checked<?php }?>>
                      Применять защиту от роботов вводом кода с картинки
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе отправка заказов будет доступна и автоматическим системам
                    </div>

                    <p style="padding-top: 10px;">
                      <input name="cart_auto_registration" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->cart_auto_registration){?> checked<?php }?>>
                      Авто регистрация неавторизованных пользователей при оформлении заказа
                    </p>

                    <p style="padding-top: 10px;">
                      Подсказка в корзине при включенной авто регистрации:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <textarea class="editor_counters" name="cart_auto_registration_msg" style="width: 100%; height: 150px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Settings']->value->cart_auto_registration_msg, ENT_QUOTES, 'UTF-8');?>
</textarea>
                          </td>
                        </tr>
                      </table>
                    </p>

                    <p style="padding-top: 10px;">
                      Текст заголовка страницы:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="cart_title_text" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_title_text;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Инструкция:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="font-size: 8pt; margin: 0px; padding: 0px;">
                            <input name="cart_show_info" style="width: 20px;" title="Выводить ли эту инструкцию в корзине" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->cart_show_info==1){?> checked<?php }?>>
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <textarea class="editor_counters" name="cart_info_text" style="width: 100%; height: 150px;"><?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_info_text;?>
</textarea>
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Надписи к полям заказа и какие из них выводить:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td colspan="3" style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="100%">
                            Аналогично одноимённым установкам для быстрого заказа
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      Заголовки колонок таблицы:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px;" width="20%">
                            порядковый номер:<br>
                            <input class="input4" name="cart_header_number" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_header_number;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="20%">
                            товар:<br>
                            <input class="input4" name="cart_header_name" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_header_name;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="20%">
                            количество:<br>
                            <input class="input4" name="cart_header_quantity" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_header_quantity;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="20%">
                            цена:<br>
                            <input class="input4" name="cart_header_price" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_header_price;?>
">
                          </td>
                          <td style="color: #C0C0C0; font-size: 8pt; margin: 0px; padding: 0px; padding-left: 10px;" width="20%">
                            сумма:<br>
                            <input class="input4" name="cart_header_sum" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_header_sum;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 10px;">
                      <input name="cart_contacts_maximize" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->cart_contacts_maximize==1){?> checked<?php }?>>
                      Секцию "Кому доставить" сразу раскрывать
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе при открытии корзины эта секция будет свёрнута
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="cart_deliveries_maximize" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->cart_deliveries_maximize==1){?> checked<?php }?>>
                      Секцию "Способы доставки" сразу раскрывать
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе при открытии корзины эта секция будет свёрнута
                    </div>
                    <p style="padding-top: 10px;">
                      Текст кнопки отправки заказа:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="cart_submit_text" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->cart_submit_text;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    Импорт товаров:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <input name="delete_goods_ancient" style="width: 20px;" type="checkbox" value="1"<?php if (isset($_smarty_tpl->tpl_vars['Settings']->value->delete_goods_ancient)&&$_smarty_tpl->tpl_vars['Settings']->value->delete_goods_ancient){?> checked<?php }?>>
                      Разрешить самоочистку каталога удалением устаревших товаров
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt;">
                    Заметки для следующих обновлений: ПЕРЕНЕСТИ ЭТИ НАСТРОЙКИ НА СТРАНИЦУ "Импорт -&gt; Варианты импорта"
                  </td>
                  <td class="td_padding" style="padding: 0px;" width="100%">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе в каталоге будут оставаться длительное время отсутствующие на складе товары или обесцененные
                    </div>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 5px;">
                      <?php $_smarty_tpl->tpl_vars["delete_goods_ancientQ0_lifetime"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->delete_goods_ancientQ0_lifetime)===null||$tmp==='' ? 30 : $tmp), null, 0);?>
                      через какое время удалять отсутствующие на складе товары:&nbsp;
                      <select name="delete_goods_ancientQ0_lifetime">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==0){?> selected<?php }?>>сразу же</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==1){?> selected<?php }?>>1 сутки</option>
                        <option value="2"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==2){?> selected<?php }?>>2 суток</option>
                        <option value="3"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==3){?> selected<?php }?>>3 суток</option>
                        <option value="4"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==4){?> selected<?php }?>>4 суток</option>
                        <option value="5"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==5){?> selected<?php }?>>5 суток</option>
                        <option value="6"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==6){?> selected<?php }?>>6 суток</option>
                        <option value="7"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value==7){?> selected<?php }?>>1 неделя</option>
                        <option value="14"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>7)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=14)){?> selected<?php }?>>2 недели</option>
                        <option value="21"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>14)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=21)){?> selected<?php }?>>3 недели</option>
                        <option value="28"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>21)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=28)){?> selected<?php }?>>4 недели</option>
                        <option value="30"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>28)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=30)){?> selected<?php }?>>30 суток</option>
                        <option value="60"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>30)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=60)){?> selected<?php }?>>60 суток</option>
                        <option value="90"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>60)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=90)){?> selected<?php }?>>90 суток</option>
                        <option value="180"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>90)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=180)){?> selected<?php }?>>180 суток</option>
                        <option value="365"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>180)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=365)){?> selected<?php }?>>1 год</option>
                        <option value="730"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>365)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=730)){?> selected<?php }?>>2 года</option>
                        <option value="1461"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>730)&&($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value<=1461)){?> selected<?php }?>>4 года</option>
                        <option value="1000000"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientQ0_lifetime']->value>1461){?> selected<?php }?>>никогда</option>
                      </select>
                    </p>
                    <p style="font-size: 10pt; font-weight: bold; padding-left: 28px; padding-top: 10px;">
                      <?php $_smarty_tpl->tpl_vars["delete_goods_ancientS0_lifetime"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->delete_goods_ancientS0_lifetime)===null||$tmp==='' ? 1000000 : $tmp), null, 0);?>
                      через какое время удалять обесцененные товары:&nbsp;
                      <select name="delete_goods_ancientS0_lifetime">
                        <option value="0"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==0){?> selected<?php }?>>сразу же</option>
                        <option value="1"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==1){?> selected<?php }?>>1 сутки</option>
                        <option value="2"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==2){?> selected<?php }?>>2 суток</option>
                        <option value="3"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==3){?> selected<?php }?>>3 суток</option>
                        <option value="4"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==4){?> selected<?php }?>>4 суток</option>
                        <option value="5"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==5){?> selected<?php }?>>5 суток</option>
                        <option value="6"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==6){?> selected<?php }?>>6 суток</option>
                        <option value="7"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value==7){?> selected<?php }?>>1 неделя</option>
                        <option value="14"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>7)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=14)){?> selected<?php }?>>2 недели</option>
                        <option value="21"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>14)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=21)){?> selected<?php }?>>3 недели</option>
                        <option value="28"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>21)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=28)){?> selected<?php }?>>4 недели</option>
                        <option value="30"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>28)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=30)){?> selected<?php }?>>30 суток</option>
                        <option value="60"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>30)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=60)){?> selected<?php }?>>60 суток</option>
                        <option value="90"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>60)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=90)){?> selected<?php }?>>90 суток</option>
                        <option value="180"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>90)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=180)){?> selected<?php }?>>180 суток</option>
                        <option value="365"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>180)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=365)){?> selected<?php }?>>1 год</option>
                        <option value="730"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>365)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=730)){?> selected<?php }?>>2 года</option>
                        <option value="1461"<?php if (($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>730)&&($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value<=1461)){?> selected<?php }?>>4 года</option>
                        <option value="1000000"<?php if ($_smarty_tpl->tpl_vars['delete_goods_ancientS0_lifetime']->value>1461){?> selected<?php }?>>никогда</option>
                      </select>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="VKontakteShare"></a>
                    Публикация ВКонтакте:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <input name="vkontakte_publish_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_publish_enabled==1){?> checked<?php }?>>
                      Разрешить покупателям размещать товары у себя ВКонтакте
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 5px;">
                    Здесь определяется, давать ли покупателям возможность делиться ссылкой
                    на страницу товара у себя ВКонтакте.
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Размещение субшаблона публикации:
                    </div>
                    <div style="color: #C0C0C0; font-size: 7pt;">
                      &nbsp;&nbsp;&nbsp;design/common_parts/vkontakte.ru.publish_htm.tpl<br>
                      &nbsp;&nbsp;&nbsp;design/common_parts/vkontakte.ru.publish_css.tpl
                    </div>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Кнопка появляется в месте шаблона страницы товара, где произведён
                      вызов субшаблона публикации ВКонтакте.
                    </div>
                  </td>
                  <td class="td_padding" width="100%">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе на странице товара не появится соответствующая этому действию кнопка
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="vkontakte_publish_selected_only" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_publish_selected_only==1){?> checked<?php }?>>
                      Использовать только для товаров с разрешённым экспортом в ВКонтакте
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе кнопка появится и у товаров с невыставленным флагом "Разрешён экспорт в Вконтакте"
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="vkontakte_publish_javascript" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_publish_javascript==1){?> checked<?php }?>>
                      Использовать javascript-кнопку с сервера ВКонтакте.ру
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе используется переход по стандартной ссылке и менее гарантированная передача сведений о товаре
                    </div>
                    <p style="padding-top: 10px;">
                      Текст javascript-кнопки или ссылки:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="vkontakte_publish_label" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_publish_label;?>
">
                          </td>
                        </tr>
                      </table>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="VKontakteWishlist"></a>
                    Хочу в подарок ВКонтакте:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <input name="vkontakte_wishlist_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_enabled==1){?> checked<?php }?>>
                      Разрешить посетителям добавлять товары в список желаний ВКонтакте
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 5px;">
                    Настройки возможности добавлять товары в список желаний на сайт
                    ВКонтакте. Для работы этой функции на странице валют магазина
                    <b style="color: #C00000; font-weight: normal;">обязательно</b> должна существовать валюта RUR - российские рубли.
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Размещение субшаблона желания:
                    </div>
                    <div style="color: #C0C0C0; font-size: 7pt;">
                      &nbsp;&nbsp;&nbsp;design/common_parts/vkontakte.ru.wishlist_htm.tpl
                    </div>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Кнопка появляется в месте шаблона страницы товара, где произведён
                      вызов субшаблона желаний ВКонтакте.
                    </div>
                  </td>
                  <td class="td_padding" width="100%">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе на странице товара не появится соответствующая этому действию кнопка
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="vkontakte_wishlist_selected_only" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_selected_only==1){?> checked<?php }?>>
                      Использовать только для товаров с разрешённым экспортом в ВКонтакте
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе кнопка появится и у товаров с невыставленным флагом "Разрешён экспорт в Вконтакте"
                    </div>
                    <p style="padding-top: 10px;">
                      Предполагаемая стоимость доставки:&nbsp;
                      <input class="input4" name="vkontakte_wishlist_delivery_cost" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_delivery_cost;?>
">
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      стоимость доставки нужно указывать в валюте сайта VKontakte.ru (в рублях)
                    </div>
                    <p style="padding-top: 10px;">
                      Процент надбавки к цене продукта:&nbsp;
                      <input class="input4" name="vkontakte_wishlist_cost_increase" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_cost_increase;?>
">&nbsp;%
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      если необходимо компенсировать накладные расходы движения денег через платежную систему ВКонтакте
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="vkontakte_wishlist_testmode" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_testmode==1){?> checked<?php }?>>
                      Включить тестовый режим
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      в тестовом режиме, в отличие от рабочего режима, не проводятся фактические денежные транзакции
                    </div>
                    <p style="padding-top: 10px;">
                      ID интернет-магазина ВКонтакте:&nbsp;
                      <input class="input4" name="vkontakte_wishlist_merchantid" style="width: 150px;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_merchantid;?>
">
                    </p>
                    <p style="padding-top: 10px;">
                      Секретный ключ магазина:&nbsp;
                      <input class="input4" name="vkontakte_wishlist_secret" style="width: 400px;" type="text" value="<?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_secret,'/./','*');?>
">
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      индентификатор и секретный ключ нужно взять с сайта VKontakte.ru при регистрации интернет-магазина
                    </div>
                    <p style="padding-top: 10px;">
                      Текст кнопки:
                      <table border="0" cellpadding="0" cellspacing="5" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="40%">
                            <input class="input4" name="vkontakte_wishlist_label" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_label;?>
">
                          </td>
                          <td>
                            &nbsp;<b>B</b>&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="60%">
                            <input class="input4" name="vkontakte_wishlist_label_right" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_wishlist_label_right;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td colspan="3">
                            <div style="color: #C0C0C0; font-size: 8pt; padding: 0px;">
                              задайте левую и правую части текста (по краям от изображения фирменной буквы В)
                            </div>
                          </td>
                        </tr>
                      </table>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
                <!-- ============================ -->
                <tr>
                  <td class="td_padding" nowrap style="border-top: #C0C0C0 1px solid; color: #2060C0; padding-bottom: 0px; padding-top: 10px;">
                    <a name="VKontaktePayment"></a>
                    Оплатить ВКонтакте:
                  </td>
                  <td class="td_padding" style="border-top: #C0C0C0 1px solid; padding-bottom: 0px; padding-top: 10px;">
                    <p>
                      <input name="vkontakte_payment_enabled" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_enabled==1){?> checked<?php }?>>
                      Разрешить такой способ оплаты заказов
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding" style="color: #C0C0C0; font-size: 8pt; padding-top: 5px;">
                    Настройки возможности оплаты ВКонтакте. Для работы этой функции на странице валют
                    магазина <b style="color: #C00000; font-weight: normal;">обязательно</b> должна
                    существовать валюта RUR - российские рубли.
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Размещение субшаблона оплаты:
                    </div>
                    <div style="color: #C0C0C0; font-size: 7pt;">
                      &nbsp;&nbsp;&nbsp;design/common_parts/vkontakte.ru.payment_htm.tpl
                    </div>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-top: 15px;">
                      Данная кнопка появляется в месте шаблона страницы оплаты заказа, где произведён
                      вызов субшаблона оплаты ВКонтакте.
                    </div>
                  </td>
                  <td class="td_padding" width="100%">
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      иначе на странице оплаты заказа не появится соответствующая этому действию кнопка
                    </div>
                    <p style="padding-top: 10px;">
                      Процент надбавки к сумме заказа:&nbsp;
                      <input class="input4" name="vkontakte_payment_cost_increase" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_cost_increase;?>
">&nbsp;%
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      если необходимо компенсировать накладные расходы движения денег через платежную систему ВКонтакте
                    </div>
                    <p style="padding-top: 10px;">
                      <input name="vkontakte_payment_testmode" style="width: 20px;" type="checkbox" value="1"<?php if ($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_testmode==1){?> checked<?php }?>>
                      Включить тестовый режим
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      в тестовом режиме, в отличие от рабочего режима, не проводятся фактические денежные транзакции
                    </div>
                    <p style="padding-top: 10px;">
                      URL страницы успешного завершения оплаты:
                      <table border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="vkontakte_payment_result_url" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_result_url;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td>
                            <div style="color: #C0C0C0; font-size: 8pt; padding: 0px;">
                              заполняйте это поле, только если будете использовать свой обработчик результатов оплаты
                            </div>
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 0px;">
                      URL страницы неудачного завершения оплаты:
                      <table border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="100%">
                            <input class="input4" name="vkontakte_payment_fail_url" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_fail_url;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td>
                            <div style="color: #C0C0C0; font-size: 8pt; padding: 0px;">
                              заполняйте только для своего обработчика результатов оплаты (например http://ваш_сайт/my_handler.php)
                            </div>
                          </td>
                        </tr>
                      </table>
                    </p>
                    <p style="padding-top: 0px;">
                      ID интернет-магазина ВКонтакте:&nbsp;
                      <input class="input4" name="vkontakte_payment_merchantid" style="width: 150px;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_merchantid;?>
">
                    </p>
                    <p style="padding-top: 10px;">
                      Секретный ключ магазина:&nbsp;
                      <input class="input4" name="vkontakte_payment_secret" style="width: 400px;" type="text" value="<?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_secret,'/./','*');?>
">
                    </p>
                    <div style="color: #C0C0C0; font-size: 8pt; padding-left: 28px; padding-top: 5px;">
                      индентификатор и секретный ключ нужно взять с сайта VKontakte.ru при регистрации интернет-магазина
                    </div>
                    <p style="padding-top: 10px;">
                      Текст кнопки:
                      <table border="0" cellpadding="0" cellspacing="0" width="97%">
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="40%">
                            <input class="input4" name="vkontakte_payment_label" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_label;?>
">
                          </td>
                          <td>
                            &nbsp;&nbsp;<b>B</b>&nbsp;
                          </td>
                          <td style="margin: 0px; padding: 0px;" width="60%">
                            <input class="input4" name="vkontakte_payment_label_right" style="width: 100%;" type="text" value="<?php echo $_smarty_tpl->tpl_vars['Settings']->value->vkontakte_payment_label_right;?>
">
                          </td>
                        </tr>
                        <tr>
                          <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          </td>
                          <td colspan="3">
                            <div style="color: #C0C0C0; font-size: 8pt; padding: 0px;">
                              задайте левую и правую части текста (по краям от изображения фирменной буквы В)
                            </div>
                          </td>
                        </tr>
                      </table>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="td_padding">
                    &nbsp;
                  </td>
                  <td class="td_padding">
                    <p>
                      <input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['Token']->value;?>
">
                      <input class="submit" type="submit" value="&nbsp;Сохранить&nbsp;">
                    </p>
                  </td>
                </tr>
              </table>
            </div>
          </form>
  </div>
<?php }} ?>