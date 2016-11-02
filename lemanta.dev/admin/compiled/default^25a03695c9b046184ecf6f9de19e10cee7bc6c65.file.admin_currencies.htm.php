<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:59:04
         compiled from "../admin/design/default/html/admin_currencies.htm" */ ?>
<?php /*%%SmartyHeaderCode:152621448457d5c5982d17b9-30686745%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25a03695c9b046184ecf6f9de19e10cee7bc6c65' => 
    array (
      0 => '../admin/design/default/html/admin_currencies.htm',
      1 => 1462406588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152621448457d5c5982d17b9-30686745',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'root_url' => 0,
    'admin_folder' => 0,
    'inputs' => 0,
    'message' => 0,
    'error' => 0,
    'total_items' => 0,
    'items' => 0,
    'PagesNavigation' => 0,
    'Pages' => 0,
    'sort_as_is' => 0,
    'c' => 0,
    'id' => 0,
    'CurrentPage' => 0,
    'CurrentPageMaxsize' => 0,
    'MainCurrency' => 0,
    'items_container_close_tag' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5c5984bfcd7_16249518',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5c5984bfcd7_16249518')) {function content_57d5c5984bfcd7_16249518($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"currencies",'main'=>true,'setup'=>true,'currencies'=>true,'deliveries'=>true,'deliveries_types'=>true,'shippings_terms'=>true,'payments'=>true,'sms'=>true), 0);?>


  
  <?php $_smarty_tpl->tpl_vars["sort_as_is"] = new Smarty_variable(@SORT_CURRENCIES_MODE_AS_IS, null, 0);?>

  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → Валюты
      </div>
      Валюты сайта
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currency&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" title="Добавить валюту">добавить</a>
    </div>

    
    <?php if (isset($_smarty_tpl->tpl_vars['message']->value)&&($_smarty_tpl->tpl_vars['message']->value!='')){?>
      <div class="message">
        <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

      </div>
    <?php }?>

    
    <?php if (isset($_smarty_tpl->tpl_vars['error']->value)&&($_smarty_tpl->tpl_vars['error']->value!='')){?>
      <div class="error">
        <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

      </div>
    <?php }?>

    <!-- Форма со списком записей -->
    <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currencies" id="items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <!-- Фильтр -->

      <!-- Сортировщик -->
      <table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;">
        <tr>
          <td class="param_short">
            упорядочить&nbsp;
          </td>

          <!-- флажок Направление сортировки -->
          <td class="param_short" title="Включить обратный порядок сортировки (игнорируется при упорядочении 'Как расставлены')">
            <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars(@SORT_DIRECTION_ASCENDING, ENT_QUOTES, 'UTF-8');?>
">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_DIRECTION])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_DIRECTION]==@SORT_DIRECTION_DESCENDING)){?> checked<?php }?> value="<?php echo htmlspecialchars(@SORT_DIRECTION_DESCENDING, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
');">
              <img class="icon16x16" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_descending_16x16.png">
            </span>
          </td>

          <!-- флажок Лаконичный режим -->
          <td class="param_short" title="Включить лаконичный режим сортировки (прятать нецелевые записи)">
            <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="0">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
');">
              <img class="icon16x16" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_laconical_16x16.png">
            </span>
          </td>

          <!-- поле Способ сортировки -->
          <td class="value" width="60%" title="Способ сортировки валют в нижеследующем списке">

            <!-- Создаем селектор способов сортировки и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value="<?php echo htmlspecialchars(@SORT_CURRENCIES_MODE_AS_IS, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CURRENCIES_MODE_AS_IS)){?> selected<?php }?>>как расставлены</option>
              <option value="<?php echo htmlspecialchars(@SORT_CURRENCIES_MODE_BY_NAME, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CURRENCIES_MODE_BY_NAME)){?> selected<?php }?>>по алфавиту</option>
              <option value="<?php echo htmlspecialchars(@SORT_CURRENCIES_MODE_BY_ISOCODE, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CURRENCIES_MODE_BY_ISOCODE)){?> selected<?php }?>>по коду ISO</option>
              <option value="<?php echo htmlspecialchars(@SORT_CURRENCIES_MODE_BY_CREATED, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CURRENCIES_MODE_BY_CREATED)){?> selected<?php }?>>по дате добавления</option>
              <option value="<?php echo htmlspecialchars(@SORT_CURRENCIES_MODE_BY_MODIFIED, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CURRENCIES_MODE_BY_MODIFIED)){?> selected<?php }?>>по дате исправления</option>
            </select>
          </td>

          <!-- поле Режим отображения -->
          <td class="value" width="40%" title="Насколько полно выводить информацию о валютах в списке">

            <!-- Создаем селектор режимов отображения и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_VIEW_MODE, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value="<?php echo htmlspecialchars(@VIEW_MODE_COMPACT, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_COMPACT)){?> selected<?php }?>>компактно</option>
              <option value="<?php echo htmlspecialchars(@VIEW_MODE_FULL, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL)){?> selected<?php }?>>подробно</option>
            </select>
          </td>

          <!-- флажок Разрешена -->
          <td class="param_short" title="Фильтр: только разрешенные к показу на сайте">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_ENABLED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_ENABLED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
');">
              разрешена
            </span>
          </td>
        </tr>
      </table>

      <!-- Кнопка сброса фильтра --> 
      <div class="toolkey">
        <span>найдено <span><?php echo sprintf("%d",(($tmp = @$_smarty_tpl->tpl_vars['total_items']->value)===null||$tmp==='' ? 0 : $tmp));?>
 шт.</span></span><a href="#" onclick="javascript: return Reset_PageRecordsFilter('items_form');" title="Сбросить фильтр (кроме способа упорядочения и полноты вывода)">сбросить</a>
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>

        <!-- Выводим контент навигатора страниц над списком, только если есть несколько листаемых страниц -->
        <?php if (isset($_smarty_tpl->tpl_vars['PagesNavigation']->value)&&($_smarty_tpl->tpl_vars['PagesNavigation']->value!='')&&isset($_smarty_tpl->tpl_vars['Pages']->value)&&(count($_smarty_tpl->tpl_vars['Pages']->value)>1)){?>
          <?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>

        <?php }?>

        
        <?php $_smarty_tpl->tpl_vars["items_container_close_tag"] = new Smarty_variable('', null, 0);?>

        
        <?php if (!isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==$_smarty_tpl->tpl_vars['sort_as_is']->value)){?>

          <!-- Заключаем перетаскиваемые элементы списка в контейнер -->
          <div id="items_container">

          
          <?php $_smarty_tpl->tpl_vars["items_container_close_tag"] = new Smarty_variable("</div>", null, 0);?>
        <?php }?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?>
          <?php $_smarty_tpl->tpl_vars["id"] = new Smarty_variable($_smarty_tpl->tpl_vars['c']->value->currency_id, null, 0);?><li class="flatlist"><div class="onerow"><!-- Микро кнопки справа от названия --><input class="checkbox" name="delete_items[]" title="Пометить на удаление" type="checkbox" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Toggle_LiTransparency(this, !this.checked, 0.3); Check_DeleteSelected_Button();"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="javascript: return confirm('Данная запись будет удалена с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_delete_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><?php if (!isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==$_smarty_tpl->tpl_vars['sort_as_is']->value)){?><!--  --><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL))){?><div class="order_edit" title="Текущий вес"><input id="order_num" name="order_num[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Show_AcceptChanges_Button();"></div><?php }else{ ?><!-- Добавляем скрытое поле порядкового номера текущей записи --><input id="order_num" name="order_num[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
"><!-- Добавляем скрытое постинговое идентифицирующее поле текущей записи --><input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST, ENT_QUOTES, 'UTF-8');?>
[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="hidden" value=""><?php }?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_first_get, ENT_QUOTES, 'UTF-8');?>
" title="Поставить первой (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_first_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_up_get, ENT_QUOTES, 'UTF-8');?>
" title="Поднять выше (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_up_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_down_get, ENT_QUOTES, 'UTF-8');?>
" title="Опустить ниже (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_down_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->move_last_get, ENT_QUOTES, 'UTF-8');?>
" title="Поставить последней (текущий вес <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_num, ENT_QUOTES, 'UTF-8');?>
)"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_move_last_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><span class="browsed zero" title="Вес валюты"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['echoVar'][0][0]->echoVar(array('from'=>'c->order_num'),$_smarty_tpl);?>
</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL))){?><input class="checkbox gray" name="enabled[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]"<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled==1){?> checked<?php }?> title="Пометить как разрешенную к показу на сайте" type="checkbox" value="1" onchange="javascript: Show_AcceptChanges_Button();"><?php }?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->ymarket_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать выбранной для Яндекс.Маркет"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_ymarket<?php if ($_smarty_tpl->tpl_vars['c']->value->ymarket!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->defaulta_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать выбранной по умолчанию для админпанели"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_magnet<?php if ($_smarty_tpl->tpl_vars['c']->value->defa!=1){?>_off<?php }?>_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->main_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать базовой"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_main<?php if ($_smarty_tpl->tpl_vars['c']->value->main!=1){?>_off<?php }?>_16x16.png"></a><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->default_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать выбранной по умолчанию для клиентской стороны"><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/icon_magnet<?php if ($_smarty_tpl->tpl_vars['c']->value->def!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['themeAdmin'][0][0]->themeAdmin(array(),$_smarty_tpl);?>
images/placeholder.gif"><!-- Нумерация --><span class="topic" style="display: inline;"><?php if (isset($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration']+$_smarty_tpl->tpl_vars['CurrentPage']->value*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value;?>
.<?php }else{ ?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.<?php }?></span><!-- Код ISO --><span class="date" title="Код ISO"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->code, ENT_QUOTES, 'UTF-8');?>
</span><!-- Знак --><span class="date" title="Знак"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><!-- Курс --><span class="votes" title="Курс"><?php echo $_smarty_tpl->tpl_vars['c']->value->rate_from*1;?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->sign, ENT_QUOTES, 'UTF-8');?>
 = <?php echo $_smarty_tpl->tpl_vars['c']->value->rate_to*1;?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['MainCurrency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL))){?><!-- Добавляем скрытое постинговое идентифицирующее поле текущей записи --><input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST, ENT_QUOTES, 'UTF-8');?>
[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="hidden" value=""><?php }?><!-- Название --><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteAdmin'][0][0]->siteAdmin(array(),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?> class="disabled_item"<?php }?>><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
</a></div><!-- Краткая информация --><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL))){?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL)){?><!-- дата добавления --><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->created,10,'',true)!="0000-00-00"){?><div class="line"><span>добавлена:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->created, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><!-- дата исправления --><?php if ((smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->modified,10,'',true)!="0000-00-00")&&($_smarty_tpl->tpl_vars['c']->value->modified!=$_smarty_tpl->tpl_vars['c']->value->created)){?><div class="line"><span>исправлена:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->modified, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><?php }?></li>
        <?php } ?>

        
        <?php if (!isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==$_smarty_tpl->tpl_vars['sort_as_is']->value)){?>
          <?php echo $_smarty_tpl->tpl_vars['items_container_close_tag']->value;?>


          <!-- Запускаем скрипт передвигания элементов -->
          
            <script language="JavaScript" type="text/javascript">
              <!--
              Make_FormItems_Sortable();
              // -->
            </script>
          
        <?php }?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

        <!-- Выводим контент навигатора страниц под списком -->
        <?php if (isset($_smarty_tpl->tpl_vars['PagesNavigation']->value)&&($_smarty_tpl->tpl_vars['PagesNavigation']->value!='')){?>
          <?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>

        <?php }?>

      <?php }else{ ?>
        <div class="noitems">
          Не найдено валют<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL]==1)){?> (режим: лаконичный)<?php }?>.
        </div>
      <?php }?>
    </form>

    <!-- Блок справочной информации -->
    <a name="help"></a>
    <div class="help" id="help_box" style="display: none;">
      <div class="title">
        Справка
      </div>
      <div>
        Маркером <b>базовая валюта</b> помечается валюта, в которой производятся все внутренние вычисления
        на сайте. Цены товаров, суммы заказов, размеры скидок, комиссионных отчислений, состояния внутренних
        счетов покупателей и другие подобные сведения хранятся в базе данных именно в формате этой валюты.
      </div>
      <div>
        Существуют два вспомогательных маркера для <b>валюты по умолчанию</b> - один для клиентской стороны
        сайта, другой для админпанели. Эти маркеры позволяют задать, в какой валюте будут выводиться цены
        покупателю при посещении сайта и в какой администратору при входе в админпанель. В дополнение на
        обеих сторонах сайта имеется выпадающий список валют, где человек на время сеанса может в случае
        необходимости мгновенно сменить валюту.
      </div>
      <div>
        Если на стороне покупателя смена валюты во время сеанса приводит только к изменению выводимых на экран
        цен и сумм, то в админпанели под такую смену валюты подстраиваются и функции приёма вводимых данных.
        Таким образом, администратор в принципе может вводить цены в любой из доступных валют.
      </div>
      <div>
        Но поскольку ценовые сведения всё же хранятся в базе данных сайта в базовой валюте, причём с точностью
        в 2 знака после запятой, во время редактирования цен в валюте, отличной от базовой, будет проявляться
        эффект дискретности (некоторого шага между возможными значениями цен), то есть округления введённой
        цены до ближайшей копейки базовой валюты согласно межвалютному курсу. Иными словами, редактируя цены
        в не базовой валюте, не удастся ввести цену, которая оказалась бы "посреди" копейки базовой валюты.
      </div>
    </div>
<?php }} ?>