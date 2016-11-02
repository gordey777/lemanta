<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:00:40
         compiled from "../admin/design/default/html/admin_orders.htm" */ ?>
<?php /*%%SmartyHeaderCode:193982425557d5b7e8bb1a73-13522749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c9620e209945e38062950b993ee0b5d3eeece60' => 
    array (
      0 => '../admin/design/default/html/admin_orders.htm',
      1 => 1462406600,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193982425557d5b7e8bb1a73-13522749',
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
    'all_users' => 0,
    'deliveries' => 0,
    'c' => 0,
    'payments' => 0,
    'settings' => 0,
    'total_items' => 0,
    'items' => 0,
    'currency' => 0,
    'PagesNavigation' => 0,
    'Pages' => 0,
    'id' => 0,
    'CurrentPage' => 0,
    'CurrentPageMaxsize' => 0,
    'v' => 0,
    'image' => 0,
    'f' => 0,
    'description' => 0,
    'quantity' => 0,
    'temp' => 0,
    'key' => 0,
    'param' => 0,
    'value' => 0,
    'checked' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b7e9243462_45230158',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b7e9243462_45230158')) {function content_57d5b7e9243462_45230158($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"orders",'main'=>true,'orders'=>true,'orders_phases'=>true,'payments_history'=>true,'credit_programs'=>true), 0);?>


  <!-- Подключаем скрипт и файл стилей календаря -->
  <script language="JavaScript" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/js/calendar/calendar.js" type="text/javascript"></script>
  <script language="JavaScript" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/js/calendar/calendas.js" type="text/javascript"></script>
  <link href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/js/calendar/calendar.css" rel="stylesheet" type="text/css">

  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → Заказы
      </div>
      Заказы
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <a class="left" href="#help" onclick="Show_PageElements('help_box');" title="Показать справочную информацию">справка</a><a class="left" href="#settings" onclick="Show_PageElements('setup_form');" title="Показать настройки сайта, относящиеся к заказам">настройки</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Order&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" title="Добавить заказ">добавить</a>
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

    <!-- Форма со списком записей -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Orders" id="items_form" method="post" onkeypress="return Ignore_KeypressSubmit(event);">

      <!-- Фильтр -->
      <table align="center" cellpadding="0" cellspacing="8" class="white">
        <tr>

          <!-- поле Покупатель -->
          <td class="param_short">
            Покупатель
          </td>
          <td class="value" width="33%" title="Фильтр: только заказы такого зарегистрированного покупателя">

            <!-- Создаем селектор пользователей -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value=""></option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER])===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

            </select>
          </td>

          <!-- поле Способ доставки -->
          <td class="param_short">
            Доставка
          </td>
          <td class="value" width="33%" title="Фильтр: только заказы с таким способом доставки">

            <!-- Создаем селектор способов доставки -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DELIVERY, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DELIVERY, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value=""></option>
              <?php if (isset($_smarty_tpl->tpl_vars['deliveries']->value)&&!empty($_smarty_tpl->tpl_vars['deliveries']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deliveries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delivery_method_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_DELIVERY])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_DELIVERY]==$_smarty_tpl->tpl_vars['c']->value->delivery_method_id)){?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</option>
                <?php } ?>
              <?php }?>
            </select>
          </td>

          <!-- поле Искомая строка -->
          <td class="param_short">
            Найти:
          </td>
          <td class="value" colspan="3" width="33%" title="Фильтр: с таким словом в заказе (не более 4 слов, слова менее 3 символов игнорируются)">
            <input class="edit" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCH, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCH, ENT_QUOTES, 'UTF-8');?>
" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEARCH], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>

          <!-- кнопка Найти -->
          <td class="value_box" title="Начать поиск заказов по условиям фильтра">
            <input class="submit" style="width: auto;" type="submit" value="&nbsp;Найти&nbsp;">
          </td>
        </tr>

        <tr>

          <!-- поле Партнер -->
          <td class="param_short">
            Партнер
          </td>
          <td class="value" width="33%" title="Фильтр: только заказы с участием такого партнера">

            <!-- Создаем селектор пользователей -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_AFFILIATE, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_AFFILIATE, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value=""></option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_AFFILIATE])===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

            </select>
          </td>

          <!-- поле Способ оплаты -->
          <td class="param_short">
            Оплата
          </td>
          <td class="value" width="33%" title="Фильтр: только заказы с таким способом оплаты">

            <!-- Создаем селектор способов оплаты -->
            <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYMENT, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYMENT, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value=""></option>
              <?php if (isset($_smarty_tpl->tpl_vars['payments']->value)&&!empty($_smarty_tpl->tpl_vars['payments']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->payment_method_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_PAYMENT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_PAYMENT]==$_smarty_tpl->tpl_vars['c']->value->payment_method_id)){?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</option>
                <?php } ?>
              <?php }?>
            </select>
          </td>

          <!-- поле Искомая дата -->
          <script language="JavaScript" type="text/javascript">
            <!--
            var xcDateFormat = 'yyyy-mm-dd';
            // -->
          </script>
          <td class="param_short">
            Дата от:
          </td>
          <td class="value" width="16%" title="Фильтр: начиная с такой даты (формат даты ГГГГ-ММ-ДД)">
            <input class="edit" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM, ENT_QUOTES, 'UTF-8');?>
" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" onfocus="showCalendar('', this, this, '', 'holder', 5, 5, 1);">
          </td>
          <td class="param_short">
            до:
          </td>
          <td class="value" width="16%" title="Фильтр: до такой даты включительно (формат даты ГГГГ-ММ-ДД)">
            <input class="edit" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHDATETO, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHDATETO, ENT_QUOTES, 'UTF-8');?>
" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEARCHDATETO], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" onfocus="showCalendar('', this, this, '', 'holder', 5, 5, 1);">
          </td>

          <!-- флажок Фильтр запускать вручную -->
          <td class="param_short" title="Включить срабатывание фильтра только по нажатию клавиши 'Найти'">
            <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MANUALLY, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="0">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MANUALLY, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MANUALLY, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MANUALLY])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MANUALLY]==1)){?> checked<?php }?> value="1" onchange="Start_PageRecordsFilter('items_form');">
            <span onclick="Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MANUALLY, ENT_QUOTES, 'UTF-8');?>
');">
              <img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_manually_16x16.png" style="margin-right: 0px;">
            </span>
          </td>
        </tr>

      </table>

      <!-- Сортировщик -->
      <table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;">
        <tr>
          <td class="param_short">
            упорядочить&nbsp;
          </td>

          <!-- флажок Направление сортировки -->
          <td class="param_short" title="Включить обратный порядок сортировки">
            <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars(@SORT_DIRECTION_ASCENDING, ENT_QUOTES, 'UTF-8');?>
">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_DIRECTION])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_DIRECTION]==@SORT_DIRECTION_DESCENDING)){?> checked<?php }?> value="<?php echo htmlspecialchars(@SORT_DIRECTION_DESCENDING, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
            <span onclick="Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_DIRECTION, ENT_QUOTES, 'UTF-8');?>
');">
              <img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_descending_16x16.png">
            </span>
          </td>

          <!-- флажок Лаконичный режим -->
          <td class="param_short" title="Включить лаконичный режим сортировки (прятать нецелевые записи)">
            <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="0">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL]==1)){?> checked<?php }?> value="1" onchange="Start_PageRecordsFilter('items_form');">
            <span onclick="Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT_LACONICAL, ENT_QUOTES, 'UTF-8');?>
');">
              <img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_laconical_16x16.png">
            </span>
          </td>

          <!-- поле Способ сортировки -->
          <td class="value" width="40%" title="Способ сортировки заказов в нижеследующем списке">

            <!-- Создаем селектор способов сортировки и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_AS_IS, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_AS_IS)){?> selected<?php }?>>по дате поступления</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_PAYMENT_DATE, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_PAYMENT_DATE)){?> selected<?php }?>>по дате оплаты</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_SUM, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_SUM)){?> selected<?php }?>>по сумме заказа</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_QUANTITY, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_QUANTITY)){?> selected<?php }?>>по количеству товаров</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_ROWCOUNT, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_ROWCOUNT)){?> selected<?php }?>>по количеству товарных позиций</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_NAME, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_NAME)){?> selected<?php }?>>по имени покупателя</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_PHONE, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_PHONE)){?> selected<?php }?>>по телефону покупателя</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_EMAIL, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_EMAIL)){?> selected<?php }?>>по емейлу покупателя</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_ICQ, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_ICQ)){?> selected<?php }?>>по номеру ICQ покупателя</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_SKYPE, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_SKYPE)){?> selected<?php }?>>по Skype имени покупателя</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_PAYMENT_NAME, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_PAYMENT_NAME)){?> selected<?php }?>>по способу оплаты</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_DELIVERY_NAME, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_DELIVERY_NAME)){?> selected<?php }?>>по способу доставки</option>
              <option value="<?php echo htmlspecialchars(@SORT_ORDERS_MODE_BY_IP, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_IP)){?> selected<?php }?>>по IP-адресу покупателя</option>
            </select>
          </td>

          <!-- поле Состояние заказов -->
          <td class="value" width="35%" title="С заказами какого состояния производится работа">

            <!-- Создаем селектор состояния заказов и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TYPE, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value="<?php echo htmlspecialchars(@TYPE_ORDERS_ANY, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE]==@TYPE_ORDERS_ANY)){?> selected<?php }?>>любые заказы</option>
              <option value="<?php echo htmlspecialchars(@TYPE_ORDERS_COMING, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE]==@TYPE_ORDERS_COMING)){?> selected<?php }?>>новые заказы</option>
              <option value="<?php echo htmlspecialchars(@TYPE_ORDERS_PROCESSING, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE]==@TYPE_ORDERS_PROCESSING)){?> selected<?php }?>>заказы в обработке</option>
              <option value="<?php echo htmlspecialchars(@TYPE_ORDERS_DONE, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE]==@TYPE_ORDERS_DONE)){?> selected<?php }?>>выполненные заказы</option>
              <option value="<?php echo htmlspecialchars(@TYPE_ORDERS_CANCELED, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TYPE]==@TYPE_ORDERS_CANCELED)){?> selected<?php }?>>аннулированные заказы</option>
            </select>
          </td>

          <!-- поле Режим отображения -->
          <td class="value" width="25%" title="Насколько полно выводить информацию о заказах в списке">

            <!-- Создаем селектор режимов отображения и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_VIEW_MODE, ENT_QUOTES, 'UTF-8');?>
" onchange="Start_PageRecordsFilter('items_form');">
              <option value="<?php echo htmlspecialchars(@VIEW_MODE_COMPACT, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_COMPACT)){?> selected<?php }?>>компактно</option>
              <option value="<?php echo htmlspecialchars(@VIEW_MODE_STANDARD, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)){?> selected<?php }?>>стандартно</option>
              <option value="<?php echo htmlspecialchars(@VIEW_MODE_FULL, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL)){?> selected<?php }?>>подробно</option>
            </select>
          </td>

          <!-- флажок В кредит -->
          <td class="param_short" title="Фильтр: только заказы в кредит">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CREDITABLE, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CREDITABLE, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_CREDITABLE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_CREDITABLE]==1)){?> checked<?php }?> value="1" onchange="Start_PageRecordsFilter('items_form');">
            <span onclick="Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CREDITABLE, ENT_QUOTES, 'UTF-8');?>
');">
              в кредит
            </span>
          </td>

          <!-- флажок Оплаченный -->
          <td class="param_short" title="Фильтр: только оплаченные заказы">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYSTATUS, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYSTATUS, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_PAYSTATUS])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_PAYSTATUS]==1)){?> checked<?php }?> value="1" onchange="Start_PageRecordsFilter('items_form');">
            <span onclick="Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYSTATUS, ENT_QUOTES, 'UTF-8');?>
');">
              оплаченный
            </span>
          </td>
        </tr>
      </table>

      <!-- Кнопка сброса фильтра --> 
      <div class="toolkey">
        <span>найдено <span><?php echo sprintf("%d",(($tmp = @$_smarty_tpl->tpl_vars['total_items']->value)===null||$tmp==='' ? 0 : $tmp));?>
 шт.</span></span><?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)&&isset($_smarty_tpl->tpl_vars['items']->value[0]->totals_total_amount)){?><span title="Общая сумма найденных заказов">на сумму <span><?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['items']->value[0]->totals_total_amount*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span></span><?php }?><a href="#" onclick="return Reset_PageRecordsFilter('items_form');" title="Сбросить фильтр (кроме способа упорядочения, типа заказов и полноты вывода)">сбросить</a>
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&!empty($_smarty_tpl->tpl_vars['items']->value)){?>

        <!-- Выводим контент навигатора страниц над списком, только если есть несколько листаемых страниц -->
        <?php if (isset($_smarty_tpl->tpl_vars['PagesNavigation']->value)&&($_smarty_tpl->tpl_vars['PagesNavigation']->value!='')&&isset($_smarty_tpl->tpl_vars['Pages']->value)&&(count($_smarty_tpl->tpl_vars['Pages']->value)>1)){?>
          <?php echo $_smarty_tpl->tpl_vars['PagesNavigation']->value;?>

        <?php }?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['items']['iteration']++;
?>
          <!--  --><?php $_smarty_tpl->tpl_vars["id"] = new Smarty_variable($_smarty_tpl->tpl_vars['c']->value->order_id, null, 0);?><li class="flatlist"><div class="onerow"><!-- Микро кнопки справа от названия --><input class="checkbox" name="delete_items[]" title="Пометить на удаление" type="checkbox" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" onchange="Toggle_LiTransparency(this, !this.checked, 0.3); Check_DeleteSelected_Button();"><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delete_get, ENT_QUOTES, 'UTF-8');?>
" title="Удалить" onclick="return confirm('Данная запись будет удалена с сайта. Вы подтверждаете такую операцию?');"><img class="microkey_right" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_delete_16x16.png"></a><!--  --><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL))){?><!-- Добавляем скрытое постинговое идентифицирующее поле текущей записи --><input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST, ENT_QUOTES, 'UTF-8');?>
[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="hidden" value=""><?php }?><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->canceled_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать заказ аннулированным"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_order_canceled<?php if ($_smarty_tpl->tpl_vars['c']->value->status!=@ORDER_STATUS_CANCEL){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->done_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать заказ выполненным"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_order_done<?php if ($_smarty_tpl->tpl_vars['c']->value->status!=@ORDER_STATUS_DONE){?>_off<?php }?>_16x16.png"></a><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->processing_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать заказ находящимся в обработке"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_order_processing<?php if ($_smarty_tpl->tpl_vars['c']->value->status!=@ORDER_STATUS_PROCESS){?>_off<?php }?>_16x16.png"></a><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->coming_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать заказ новым"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_order_coming<?php if ($_smarty_tpl->tpl_vars['c']->value->status!=@ORDER_STATUS_NEW){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->payment_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать / не считать заказ оплаченным"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_payment<?php if ($_smarty_tpl->tpl_vars['c']->value->payment_status!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Нумерация --><span class="topic" style="display: inline;"><?php if (isset($_smarty_tpl->tpl_vars['CurrentPage']->value)){?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration']+$_smarty_tpl->tpl_vars['CurrentPage']->value*$_smarty_tpl->tpl_vars['CurrentPageMaxsize']->value;?>
.<?php }else{ ?><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['items']['iteration'];?>
.<?php }?></span><!-- Дата --><span class="date" title="Дата оформления: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->date, ENT_QUOTES, 'UTF-8');?>
"><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_DATE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
');" title="Показать все заказы такого числа"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
</span><!-- Количество товаров --><span class="count" id="orderitem_total_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_order_quantity" old_value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->total_quantity)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
" title="Количество товаров в заказе (товарных позиций <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->total_rows)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
)"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->total_quantity)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
</span><!-- Сумма --><span class="rating" id="orderitem_total_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_order_sum" old_value="<?php echo smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['c']->value->total_amount*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.');?>
" title="Полная сумма заказа"><?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['c']->value->total_amount*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><!-- значок Оформляется в кредит --><?php if (($_smarty_tpl->tpl_vars['c']->value->credit_id!=0)&&($_smarty_tpl->tpl_vars['c']->value->credit_details!='')){?><img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_credit_16x16.png" title="Этот заказ оформляется в кредит"><?php }?><!-- Имя покупателя --><?php if ($_smarty_tpl->tpl_vars['c']->value->compound_name!=''){?><!-- ссылка на поиск --><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_NAME, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->search_name, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким именем покупателя"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<!-- значок заказа зарегистрированного пользователя сайта --><?php if ($_smarty_tpl->tpl_vars['c']->value->user_id!=0){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_USER_ID, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->user_id, ENT_QUOTES, 'UTF-8');?>
');;"><img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_registered_16x16.png" title="Это заказ зарегистрированного пользователя сайта"></a><?php }?><!-- ссылка не редактирование --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->compound_name, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->compound_name, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?><!-- значок заказа зарегистрированного пользователя сайта --><?php if ($_smarty_tpl->tpl_vars['c']->value->user_id!=0){?><img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_registered_16x16.png" title="Это заказ зарегистрированного пользователя сайта"><?php }?><!-- ссылка не редактирование --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
">Имя не указано</a><?php }?></div><!-- Краткая информация --><!--  --><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_STANDARD)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL))){?><!-- Номер заказа --><span class="ordernum" title="Номер заказа"><i>№</i><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
</span><!-- товары заказа --><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['v']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['v']['iteration']++;
?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable('', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['v']->value->small_image)){?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['v']->value->small_image)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php if (($_smarty_tpl->tpl_vars['image']->value=='')&&isset($_smarty_tpl->tpl_vars['v']->value->large_image)){?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['v']->value->large_image)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php if (($_smarty_tpl->tpl_vars['image']->value=='')&&isset($_smarty_tpl->tpl_vars['v']->value->fotos)&&!empty($_smarty_tpl->tpl_vars['v']->value->fotos)){?><?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value->fotos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['image']->value==''){?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['f']->value->filename)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php }?><?php } ?><?php }?><?php if ($_smarty_tpl->tpl_vars['image']->value==''){?><?php $_smarty_tpl->tpl_vars["description"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['v']->value->description)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['description']->value,"'^.*?<img[^>]+?src=([^>\s]+).+"."$"."'is","\\1"), null, 0);?><?php if ($_smarty_tpl->tpl_vars['image']->value==$_smarty_tpl->tpl_vars['description']->value){?><?php $_smarty_tpl->tpl_vars["description"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['v']->value->body)===null||$tmp==='' ? '' : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['description']->value,"'^.*?<img[^>]+?src=([^>\s]+).+"."$"."'is","\\1"), null, 0);?><?php if ($_smarty_tpl->tpl_vars['image']->value==$_smarty_tpl->tpl_vars['description']->value){?><?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable('', null, 0);?><?php }?><?php }?><?php if ($_smarty_tpl->tpl_vars['image']->value==''){?><?php $_smarty_tpl->_capture_stack[0][] = array('default', "image", null); ob_start(); ?>"http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
/images/no_foto.jpg"<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php }?><?php }else{ ?><?php $_smarty_tpl->_capture_stack[0][] = array('default', "image", null); ob_start(); ?>"<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['image']->value,7,'',true), 'UTF-8')!='http://'){?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
"<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php }?><!-- изображение --><img class="thumb<?php if ($_smarty_tpl->tpl_vars['v']->value->model==''){?> thumb_no_product" title="Этого товара уже нет в каталоге сайта<?php }?>" src=<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
><div class="line" style="padding-top: 9px;"><span><!-- флаг использования товарной позиции --><input class="checkbox" checked id="orderitem_used_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_used[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="checkbox" value="1" style="color: #C0C0C0;" title="Действительна ли эта товарная позиция (позиции со снятым флажком будут удалены)" onchange="Toggle_DivTransparency(this, this.checked, 0.3); Show_AcceptChanges_Button();">&nbsp;</span><!-- цена --><div class="price_edit" title="Цена товара"><input id="orderitem_price_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_price[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="text" value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['v']->value->real_price*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.'), ENT_QUOTES, 'UTF-8');?>
" onkeyup="return Change_OrderItem_Price(event, this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
', '<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
', '', true);" onchange="Show_AcceptChanges_Button();"></div><span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><!-- количество --><div class="quantity_edit" title="Количество товара (отрицательное число обозначает продажу под заказ)"><input id="orderitem_quantity_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_quantity[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->quantity, ENT_QUOTES, 'UTF-8');?>
" old_value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->quantity, ENT_QUOTES, 'UTF-8');?>
" onkeyup="return Change_OrderItem_Quantity(event, this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
', '<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
', true);" onchange="Show_AcceptChanges_Button();"><input name="orderitem_quantity_previous[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->quantity, ENT_QUOTES, 'UTF-8');?>
"></div><span class="label">шт.</span><!-- скидка --><div class="discount_edit" title="Использовать скидку"><input id="orderitem_discount_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_discount[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="text" value="<?php if (smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['v']->value->discount),',','.')!='0.00'){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['v']->value->discount),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }?>" onkeyup="return Change_OrderItem_Discount(event, this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
', '<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
', true);" onchange="Show_AcceptChanges_Button();"></div><span class="label">%</span><!-- окончательная цена позиции --><?php $_smarty_tpl->tpl_vars["quantity"] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value->quantity, null, 0);?><?php if ($_smarty_tpl->tpl_vars['v']->value->quantity<0){?><?php $_smarty_tpl->tpl_vars["quantity"] = new Smarty_variable($_smarty_tpl->tpl_vars['v']->value->quantity*-1, null, 0);?><?php }?><span class="price" id="orderitem_total_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" old_value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['v']->value->price*$_smarty_tpl->tpl_vars['quantity']->value*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.'), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['v']->value->price*$_smarty_tpl->tpl_vars['quantity']->value*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",","."), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><!-- название товара --><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_PRODUCT_ID, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->product_id, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким товаром"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a>&nbsp;<a class="product" href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php if ($_smarty_tpl->tpl_vars['v']->value->url_special!=1){?>products/<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->url, ENT_QUOTES, 'UTF-8');?>
"><span class="text" title="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->product_name, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
<?php if (($_smarty_tpl->tpl_vars['v']->value->variant_name!='')&&($_smarty_tpl->tpl_vars['v']->value->variant_name!=$_smarty_tpl->tpl_vars['v']->value->product_name)){?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->variant_name, ENT_QUOTES, 'UTF-8');?>
<?php }?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->name_properties, ENT_QUOTES, 'UTF-8');?>
"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->product_name, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>
</span></a><?php if (($_smarty_tpl->tpl_vars['v']->value->variant_name!='')&&($_smarty_tpl->tpl_vars['v']->value->variant_name!=$_smarty_tpl->tpl_vars['v']->value->product_name)){?><span class="subtext"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->variant_name, ENT_QUOTES, 'UTF-8');?>
</span><?php }?><?php if ($_smarty_tpl->tpl_vars['v']->value->name_properties!=''){?><span class="subinfo"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->name_properties, ENT_QUOTES, 'UTF-8');?>
</span><?php }?><!-- скрытые справочные поля --><input name="orderitem_id[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php if (!isset($_smarty_tpl->tpl_vars['v']->value->virtual)){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->orderitem_id, ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0<?php }?>"><input name="orderitem_product_id[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->product_id, ENT_QUOTES, 'UTF-8');?>
"><input name="orderitem_variant_id[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->variant_id, ENT_QUOTES, 'UTF-8');?>
"><input name="orderitem_position[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
"></div><?php } ?><!-- доставка --><div class="line" style="padding-top: 9px;"><span>доставка:</span><div class="price_edit" title="Цена доставки"><input name="delivery_price[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['c']->value->delivery_price*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.'), ENT_QUOTES, 'UTF-8');?>
" onkeyup="return Change_OrderItem_Price(event, this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
', 'delivery', '', true);" onchange="Show_AcceptChanges_Button();"></div><span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><span class="label" style="width: 146px;">&nbsp;</span><span class="price" id="orderitem_total_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_delivery" old_value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['c']->value->delivery_price*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.'), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['c']->value->delivery_price*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",","."), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><?php if ($_smarty_tpl->tpl_vars['c']->value->delivery_method_id!=0){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_DELIVERY_ID, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delivery_method_id, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким способом доставки"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a>&nbsp;<span class="text"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->delivery_method, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "способ доставки не указан" : $tmp);?>
</span><?php }?></div><!-- дополнительная скидка --><div class="line" style="padding-top: 9px;"><span>доп.скидка:</span><div class="price_edit" title="Сумма дополнительной скидки"><input id="discount_sum_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" name="discount_sum[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="text" value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['c']->value->discount_sum*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.'), ENT_QUOTES, 'UTF-8');?>
" onkeyup="return Change_OrderItem_Price(event, this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
', 'discount', '-', true);" onchange="Show_AcceptChanges_Button();"></div><span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><span class="label" style="width: 71px;">&nbsp;</span><div class="discount_edit" title="Сумма дополнительной скидки, выраженная в процентах"><?php $_smarty_tpl->tpl_vars["temp"] = new Smarty_variable($_smarty_tpl->tpl_vars['c']->value->amount+$_smarty_tpl->tpl_vars['c']->value->discount_sum+$_smarty_tpl->tpl_vars['c']->value->delivery_price, null, 0);?><?php if ($_smarty_tpl->tpl_vars['temp']->value==0){?><?php $_smarty_tpl->tpl_vars["temp"] = new Smarty_variable(1, null, 0);?><?php }?><input id="discount_percent_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" type="text" value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['c']->value->discount_sum*100/$_smarty_tpl->tpl_vars['temp']->value)),',','.'), ENT_QUOTES, 'UTF-8');?>
" onkeyup="return Change_Order_DiscountPercent(event, this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
', '-', true);" onchange="Show_AcceptChanges_Button();"></div><span class="label">%</span><span class="price" id="orderitem_total_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
_discount" old_value="-<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['c']->value->discount_sum*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),',','.'), ENT_QUOTES, 'UTF-8');?>
">-<?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['c']->value->discount_sum*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",","."), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><!-- кнопка Применить (сохранить конкретно эту запись, игнорируя изменения других записей на странице) --><input class="submit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_THISONE, ENT_QUOTES, 'UTF-8');?>
[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="submit" value="применить" title="Принять исправления только в этом заказе" onclick="return Prepare_PageThisOnePost('items_form');">&nbsp;<!-- флаг уведомления администратора --><input class="checkbox" name="inform_admin_sms[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" style="float: none;" type="checkbox" value="1" title="Информировать ли администратора по SMS об изменениях в заказе" onchange="Show_AcceptChanges_Button();"><input class="checkbox" id="items_form_inform_admin_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" name="inform_admin[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" style="float: none;" type="checkbox" value="1" title="Информировать ли администратора по емейлу об изменениях в заказе" onchange="Show_AcceptChanges_Button();"> &nbsp;<span class="text" title="Информировать ли администратора по емейлу об изменениях в заказе" onclick="Toggle_PageCheckbox('items_form_inform_admin_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
');">уведомить админа</span><!-- флаг уведомления покупателя --><?php if ((($_smarty_tpl->tpl_vars['c']->value->email!='')||($_smarty_tpl->tpl_vars['c']->value->email2!=''))&&(($_smarty_tpl->tpl_vars['c']->value->phone!='')||($_smarty_tpl->tpl_vars['c']->value->phone2!=''))){?><input class="checkbox" name="inform_user_sms[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" style="float: none;" type="checkbox" value="1" title="Информировать ли покупателя по SMS об изменениях в заказе" onchange="Show_AcceptChanges_Button();"><input class="checkbox" id="items_form_inform_user_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" name="inform_user[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" style="float: none;" type="checkbox" value="1" title="Информировать ли покупателя по емейлу об изменениях в заказе" onchange="Show_AcceptChanges_Button();"> &nbsp;<span class="text" title="Информировать ли покупателя по емейлу об изменениях в заказе" onclick="Toggle_PageCheckbox('items_form_inform_user_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
');">клиента</span><?php }elseif(($_smarty_tpl->tpl_vars['c']->value->email!='')||($_smarty_tpl->tpl_vars['c']->value->email2!='')){?><input class="checkbox" id="items_form_inform_user_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" name="inform_user[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" style="float: none;" type="checkbox" value="1" title="Информировать ли покупателя по емейлу об изменениях в заказе" onchange="Show_AcceptChanges_Button();"> &nbsp;<span class="text" title="Информировать ли покупателя по емейлу об изменениях в заказе" onclick="Toggle_PageCheckbox('items_form_inform_user_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
');">клиента</span><?php }elseif(($_smarty_tpl->tpl_vars['c']->value->phone!='')||($_smarty_tpl->tpl_vars['c']->value->phone2!='')){?><input class="checkbox" id="items_form_inform_user_sms<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" name="inform_user_sms[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" style="float: none;" type="checkbox" value="1" title="Информировать ли покупателя по SMS об изменениях в заказе" onchange="Show_AcceptChanges_Button();"> &nbsp;<span class="text" title="Информировать ли покупателя по SMS об изменениях в заказе" onclick="Toggle_PageCheckbox('items_form_inform_user_sms<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
');">клиента</span><?php }?></div><?php }?><!--  --><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_VIEW_MODE]==@VIEW_MODE_FULL)){?><!-- телефон --><?php if ((preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone)!='')||(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2)!='')){?><div class="line"><span>телефон:</span><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone)!=''){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_PHONE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким телефоном <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone), ENT_QUOTES, 'UTF-8');?>
<?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2)!=''){?>, &nbsp;<a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_PHONE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким телефоном <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }else{ ?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_PHONE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким телефоном <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->phone2), ENT_QUOTES, 'UTF-8');?>
<?php }?></div><?php }?><!-- емейл --><?php if ((preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email)!='')||(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2)!='')){?><div class="line"><span>емейл:</span><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email)!=''){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_EMAIL, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким емейлом <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<a href="mailto:<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email), ENT_QUOTES, 'UTF-8');?>
" title="Написать письмо"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email), ENT_QUOTES, 'UTF-8');?>
</a><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2)!=''){?>, &nbsp;<a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_EMAIL, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким емейлом <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<a href="mailto:<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
" title="Написать письмо"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
</a><?php }?><?php }else{ ?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_EMAIL, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким емейлом <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<a href="mailto:<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
" title="Написать письмо"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->email2), ENT_QUOTES, 'UTF-8');?>
</a><?php }?></div><?php }?><!-- ICQ номер --><?php if ((preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq)!='')||(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2)!='')){?><div class="line"><span>номер ICQ:</span><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq)!=''){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_ICQ, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким номером ICQ <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq), ENT_QUOTES, 'UTF-8');?>
<?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2)!=''){?>, &nbsp;<a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_ICQ, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким номером ICQ <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }else{ ?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_ICQ, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким номером ICQ <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->icq2), ENT_QUOTES, 'UTF-8');?>
<?php }?></div><?php }?><!-- Skype имя --><?php if ((preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype)!='')||(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2)!='')){?><div class="line"><span>Skype имя:</span><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype)!=''){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_SKYPE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким Skype именем <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype), ENT_QUOTES, 'UTF-8');?>
<?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2)!=''){?>, &nbsp;<a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_SKYPE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким Skype именем <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }else{ ?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_SKYPE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким Skype именем <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2), ENT_QUOTES, 'UTF-8');?>
"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->skype2), ENT_QUOTES, 'UTF-8');?>
<?php }?></div><?php }?><!-- адрес --><?php if ((preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address)!='')||(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address2)!='')){?><div class="line" title="<?php if ($_smarty_tpl->tpl_vars['c']->value->compound_address!=''){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address2), ENT_QUOTES, 'UTF-8');?>
<?php }?>"><span>адрес:</span><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address)!=''){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_ADDRESS, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->search_address, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким адресом"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address), ENT_QUOTES, 'UTF-8');?>
<?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address2)!=''){?>, &nbsp;<a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_ADDRESS, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->search_address2, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким адресом"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address2), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }else{ ?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_ADDRESS, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->search_address2, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким адресом"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->compound_address2), ENT_QUOTES, 'UTF-8');?>
<?php }?></div><?php }?><!-- желаемое время доставки --><?php if ((preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_date)!='')||(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_time)!='')){?><div class="line"><span>желает:</span><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_date)!=''){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_TODATE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_date), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с такой желаемой датой доставки"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;дата доставки: <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_date), ENT_QUOTES, 'UTF-8');?>
<?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_time)!=''){?>, &nbsp;<a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_TOTIME, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_time), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким желаемым временем доставки"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;время: <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_time), ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }else{ ?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_TOTIME, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_time), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким желаемым временем доставки"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;время доставки: <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->to_time), ENT_QUOTES, 'UTF-8');?>
<?php }?></div><?php }?><!-- дата добавления --><?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&(($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_AS_IS)||($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_ORDERS_MODE_BY_DATE))){?><div class="line"><span>оформлен:</span><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_DATE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
');" title="Показать все заказы такого числа"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->date, ENT_QUOTES, 'UTF-8');?>
 &nbsp;&nbsp;&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['c']->value->affiliate_id!=0){?>&nbsp; <span class="text">с участием партнера: <?php echo (($tmp = @htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->affiliate_name), ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "Имя не указано" : $tmp);?>
</span><?php }?></div><?php }?><!-- дата оплаты --><?php if ((smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->payment_date,10,'',true)!="0000-00-00")||($_smarty_tpl->tpl_vars['c']->value->payment_method_id!=0)){?><div class="line"><span>оплачен:</span><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_PAYMENT_DATE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->payment_date,10,'',true), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы, оплаченные такого числа"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->payment_date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->payment_date, ENT_QUOTES, 'UTF-8');?>
 &nbsp;&nbsp;&nbsp;&nbsp;<?php }else{ ?>дата неизвестна &nbsp;&nbsp;&nbsp;&nbsp;<?php }?><?php if ($_smarty_tpl->tpl_vars['c']->value->payment_method_id!=0){?><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_PAYMENT_ID, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->payment_method_id, ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с таким способом оплаты"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a><?php }?><?php if ($_smarty_tpl->tpl_vars['c']->value->payment_status!=1){?><span class="warning">Заказ не помечен как оплаченный!</span><?php }?>&nbsp;<span class="text"><?php echo (($tmp = @htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->payment_method), ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "способ оплаты не указан" : $tmp);?>
</span></div><?php }?><!-- ip-адрес --><?php if (preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->ip)!=''){?><div class="line"><span>ip:</span><a href="#" onclick="return SearchThis_PageRecordsFilter('items_form', '<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_IP, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->ip), ENT_QUOTES, 'UTF-8');?>
');;" title="Показать все заказы с такого IP-адреса"><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png"></a> &nbsp;<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->ip), ENT_QUOTES, 'UTF-8');?>
 &nbsp; <a href="http://www.ip-adress.com/ip_tracer/<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->ip), ENT_QUOTES, 'UTF-8');?>
" target="_blank" style="font-size: 7pt;">[где это?]</a><?php if (isset($_smarty_tpl->tpl_vars['c']->value->host)&&(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->host)!='')){?> &nbsp; <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->host), ENT_QUOTES, 'UTF-8');?>
<?php }?></div><?php }?><!-- комментарий покупателя --><?php if ($_smarty_tpl->tpl_vars['c']->value->comment!=''){?><div class="line" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
"><span>заметки:</span><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
</div><?php }?><!-- желаемый способ оплаты --><?php if ($_smarty_tpl->tpl_vars['c']->value->desire_payment!=''){?><div class="line" title="Желаемый покупателем способ оплаты"><span>оплатит:</span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->desire_payment, ENT_QUOTES, 'UTF-8');?>
</div><?php }?><!-- комментарий администратора --><?php if ($_smarty_tpl->tpl_vars['c']->value->comment_status!=''){?><div class="line" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment_status), ENT_QUOTES, 'UTF-8');?>
"><span style="color: #606060;">пояснение:</span><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment_status), ENT_QUOTES, 'UTF-8');?>
</div><?php }?><!-- вид кредита --><?php if (($_smarty_tpl->tpl_vars['c']->value->credit_id!=0)&&($_smarty_tpl->tpl_vars['c']->value->credit_details!='')){?><div class="line" title="Вид кредита: <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', (($tmp = @$_smarty_tpl->tpl_vars['c']->value->credit_name)===null||$tmp==='' ? 'неизвестный' : $tmp)), ENT_QUOTES, 'UTF-8');?>
, срок кредитования <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['c']->value->credit_term);?>
 месяцев, процентная ставка <?php echo smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['c']->value->credit_percent),',','.');?>
%"><span>кредит:</span><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', (($tmp = @$_smarty_tpl->tpl_vars['c']->value->credit_name)===null||$tmp==='' ? 'неизвестный' : $tmp)), ENT_QUOTES, 'UTF-8');?>
, срок кредитования <?php echo sprintf('%d',$_smarty_tpl->tpl_vars['c']->value->credit_term);?>
 месяцев, процентная ставка <?php echo smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['c']->value->credit_percent),',','.');?>
%</div><?php }?><!-- стадия заказа --><?php if ($_smarty_tpl->tpl_vars['c']->value->orders_phase!=''){?><div class="line" title="Стадия состояния заказа: <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->orders_phase), ENT_QUOTES, 'UTF-8');?>
"><span>стадия:</span><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->orders_phase), ENT_QUOTES, 'UTF-8');?>
</div><?php }?><!-- url --><div class="line<?php if (($_smarty_tpl->tpl_vars['c']->value->payment_status==1)||($_smarty_tpl->tpl_vars['c']->value->hidden==1)){?> gray<?php }?>"><span><!-- флаг Скрыт от чужих --><input name="hidden[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="hidden" value="0"><input class="checkbox"<?php if ($_smarty_tpl->tpl_vars['c']->value->hidden==1){?> checked<?php }?> name="hidden[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
]" type="checkbox" value="1" title="Запрещен ли на клиентской стороне доступ к сведениям заказа незарегистрированному покупателю" onchange="Show_AcceptChanges_Button();">url:</span><?php if (($_smarty_tpl->tpl_vars['c']->value->payment_status!=1)&&($_smarty_tpl->tpl_vars['c']->value->hidden!=1)){?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->code, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу заказа в клиентской части сайта">http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->code, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->code, ENT_QUOTES, 'UTF-8');?>
<?php }?>&nbsp;<img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_hidden<?php if ($_smarty_tpl->tpl_vars['c']->value->hidden!=1){?>_off<?php }?>_16x16.png" title="Страница заказа <?php if ($_smarty_tpl->tpl_vars['c']->value->hidden==1){?>закрыта от чужих<?php }else{ ?>свободно доступна<?php }?>"></div><?php }?></li>
        <?php } ?>

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
          Не найдено заказов<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT_LACONICAL]==1)){?> (режим: лаконичный)<?php }?>.
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
        <b>Фильтр</b>. Расположен в верхней части страницы и обеспечивает возможность выделить из общего списка заказы по конкретным параметрам.
        Поля фильтра можно сочетать произвольно, они объединены функцией И. Кроме того, в фильтре имеется строка поиска, а также в элементах списка
        заказов размещены ссылки <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png">,
        моделирующие заполнение строки поиска соответствующим искомым текстом и нажатие кнопки "Найти" без сброса остальных настроек фильтра.
      </div>
      <div>
        <b>Покупатель</b>. Этот выпадающий список фильтра содержит перечень зарегистрированных пользователей сайта и дает выделить заказы
        кого-то из них. Нужно понимать, что если зарегистрированный покупатель сделал заказ, при этом не авторизовавшись на сайте, такой
        заказ в силу отсутствия привязки к аккаунту данного пользователя просто не войдет в список отфильтрованных по этому зарегистрированному
        покупателю.
      </div>
      <div>
        Поэтому заказы зарегистрированных покупателей помечаются в списке знаком <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_registered_16x16.png">
        перед именем покупателя. Как правило, заказы одного человека, даже когда оформлялись часть с авторизацией, часть без нее, все же
        имеют похожие сведения, например телефон, емейл, ip-адрес. Это открывает путь ссылками <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/microicon_showall_9x9.png">
        или через строку поиска попытаться найти максимально большее число заказов, действительно относящихся к выбранному покупателю.
      </div>
      <div>
        <b>Партнер</b>. Система поддерживает комиссионные отчисления партнерам с оплаченных заказов покупателей, приведенных на сайт по реферальной
        ссылке партнера. Тогда возникает необходимость фильтрации заказов по какому-то партнеру. Этот выпадающий список фильтра предоставляет такую
        возможность.
      </div>
      <div>
        <b>Доставка</b>, <b>Оплата</b>. Два выпадающих списка фильтра, фильтрующие список заказов по указанному способу доставки или оплаты.
      </div>
      <div>
        <b>Диапазон дат</b>. Под строкой поиска в фильтре расположены два поля для задания интересующего диапазона дат. То есть можно выделить заказы
        конкретного периода времени. Указание первой даты отфильтровывает заказы, оформленные начиная с такой даты. Указание второй даты - заказы,
        оформленные не позднее такой даты. Поля дат снабжены выпадающими календарями, и также возможно вводить даты вручную в формате ГГГГ-ММ-ДД.
      </div>
      <div>
        <b>Автоматизация</b>. Флаг <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_manually_16x16.png">
        фильтра управляет автоматизацией срабатывания. При снятом флаге фильтр реагирует на каждое изменение мышью состояния его элементов. При
        установленном флаге фильтр отзывается лишь на нажатие кнопки "Найти".
      </div>
      <div>
        <b>Направление</b>. Флаг <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_descending_16x16.png">
        фильтра управляет порядком сортировки элементов списка. При установленном флаге элементы располагаются по убыванию, то есть от большего к
        меньшему. При снятом флаге - по возрастанию. По умолчанию считается выбранным порядок по убыванию как наиболее оптимальный для важных
        сортировочных операций: по датам, сумме, количествам. Смена порядка запоминается как минимум на время сеанса. Если в браузере не отключена
        поддержка cookie, смена запоминается на большее время.
      </div>
      <div>
        <b>Лаконичность</b>. Флаг <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_laconical_16x16.png">
        фильтра управляет лаконичностью сортировки элементов списка. Установленный флаг означает лаконичный режим, когда после упорядочения скрываются
        нецелевые записи. Например, есть 10 записей, только в 3 из них указаны телефоны. Тогда сортировка по номеру телефона покупателя в лаконичном
        режиме выдаст 3 упорядоченные записи с телефонами, остальные 7 записей без телефонов будут скрыты как нецелевые для такого способа сортировки.
        По умолчанию считается выбранным лаконичный режим как самый оптимальный для результатов сортировки. Смена порядка запоминается как минимум
        на время сеанса.
      </div>
      <div>
        <b>Способы сортировки</b>. Выпадающий список фильтра, где указывается требуемый способ упорядочения элементов списка заказов. По умолчанию
        считается выбранной сортировка по дате поступления как наиболее употребляемая в списке заказов. Смена способа запоминается как минимум
        на время сеанса.
      </div>
      <div>
        <b>Состояния заказов</b>. Этот выпадающий список фильтра содержит варианты: любые заказы, новые заказы, заказы в обработке, выполненные заказы,
        аннулированные заказы. Выпадающий список предназначен для выделения того типа заказов, с которым нужно поработать. По умолчанию считается
        выбранным вариант новые заказы как чаще всего интересующий администратора. Смена варианта запоминается как минимум на время сеанса.
      </div>
      <div>
        <b>Подробность</b>. Данный выпадающий список фильтра содержит варианты: компактно, стандартно, подробно. Здесь выбирается степень подробности
        сведений о каждом заказе. В первом случае - это информация о имени покупателя, дате, сумме заказа и количеству товаров. Второй случай дополняет
        сведения перечислением товарных позиций, цены доставки и суммы дополнительной скидки. Третий случай - развернутая информация о заказе, включая
        номера телефонов, емейлы, адреса и прочее, что было указано покупателем. Второй и третий случаи дают возможность корректировать элементы заказа
        прямо в списке. По умолчанию считается выбранной степень подробно как наиболее востребованная при работе с заказами. Смена степени запоминается
        как минимум на время сеанса.
      </div>
      <div>
        <b>Удаление</b>. У каждой записи в списке есть кнопка <img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_delete_16x16.png">
        для удаления именно этой записи. Рядом с такой кнопкой расположен пометочный флажок, который совместно с размещенной под списком кнопкой "Удалить"
        дает возможность массового удаления записей с текущей страницы списка.
      </div>
      <div>
        Кроме того, в списке у каждого заказа слева от его товарных позиций находятся свои пометочные флажки, также относящиеся к удалению. Однако суть
        их состояний противоположна: что нельзя удалять. То есть при установленном флажке товарная позиция останется в заказе, при снятом - будет удалена.
        Чтобы администратор не путался в смыслах состояний пометочных флажков, они снабжены визуальным интуитивно понятным эффектом - удаляемые элементы
        становятся полупрозрачными.
      </div>
      <div>
        <b>Кнопка Применить</b>. Видна лишь при выборе стандартной или подробной степени сведений о заказе. На странице расположено несколько таких кнопок.
        Одна из них под списком заказов служит для массового принятия изменений во множестве заказов на странице. Остальные подобные кнопки размещены
        по одной в каждом заказе и служат для принятия изменений только в данном заказе.
      </div>
      <div>
        Важно знать, что кнопка Применить игнорирует пометочные флажки удаления заказов, ведь в целях безопасности их обслуживает только специальная кнопка
        под списком заказов. Иными словами, если что-то исправить в заказе, пометить его на удаление и нажать кнопку Применить, то произойдет принятие
        изменений в заказе без его удаления.
      </div>
      <div>
        <b>IP-адрес</b>. Виден лишь при выборе подробной степени сведений о заказе. В любом заказе сохраняется информация об интернет адресе компьютера
        покупателя в момент оформления заказа. Если системе удается определить связанное с этим адресом имя хоста (канал коммуникационного сервера, через
        который пользователь зашел на сайт), то следом за числовым представлением ip-адреса указывается имя хоста. В дополнение рядом с ip-адресом выводится
        ссылка "где это?", чтобы можно было получить информацию о его географической принадлежности.
      </div>
      <div>
        <b>URL</b>. Виден лишь при выборе подробной степени сведений о заказе. Когда пользователь оформил заказ, автоматически на клиентской стороне сайта
        становится доступной страница с информацией о заказе. Там покупатель в любой момент без регистрации на сайте может узнать о состоянии своего заказа.
        Хотя страница заказа имеет сложно подбираемый url (адрес), тем не менее может оказаться принципиальным, чтобы именно к сведениям этого заказа никто
        чужой не смог получить доступ, даже когда узнал адрес страницы. Для этой цели в заказе слева от поля URL размещен флажок, его установка скрывает
        страницу заказа от всех, кроме зарегистрированного покупателя.
      </div>
      <div>
        <b>Уведомления</b>. В заказах расположены специальные флажки: один для уведомления администратора, другой - покупателя, если тот сообщил свой
        контактный емейл. Так как покупатель, кроме емейла, может сообщить другие каналы связи - номер телефона и ICQ, и если в системе присутствуют
        модули ICQ- и SMS-сообщений, отправка уведомления покупателю будет сделана по всем возможным каналам, которые незапрещены в его профиле.
      </div>
      <div>
        <b>Подсветка изменений</b>. Внося правки в разные заказы на странице, удобно иметь зрительные ориентиры, какие поля подверглись исправлениям.
        Это реализовано окраской текста синим в тех полях ввода, которые пытались редактировать.
      </div>
    </div>



    
    <a name="settings"></a>

    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Orders" enctype="multipart/form-data" id="setup_form" method="post"<?php if (empty($_smarty_tpl->tpl_vars['error']->value)){?> style="display: none;"<?php }?>>



        <br>
        <h1>
          Настройки
        </h1>
        <br>



        <table align="center" cellpadding="0" cellspacing="10" class="white">
            <tr>
                <td class="param_short">
                    Редактировать товары:
                </td>
                <td class="value" colspan="2" width="100%" title="В каких заказах разрешено редактировать список товаров">
                    <select name="orders_edit_mode">
                        <option value="<?php echo htmlspecialchars(@EDIT_ORDER_MODE_NOTHING, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->orders_edit_mode==@EDIT_ORDER_MODE_NOTHING){?> selected<?php }?>>запрещено в любых заказах</option>
                        <option value="<?php echo htmlspecialchars(@EDIT_ORDER_MODE_NEW_ONLY, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->orders_edit_mode==@EDIT_ORDER_MODE_NEW_ONLY){?> selected<?php }?>>можно в новых заказах</option>
                        <option value="<?php echo htmlspecialchars(@EDIT_ORDER_MODE_NEW_PROCESS, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->orders_edit_mode==@EDIT_ORDER_MODE_NEW_PROCESS){?> selected<?php }?>>можно в заказах в обработке и новых</option>
                        <option value="<?php echo htmlspecialchars(@EDIT_ORDER_MODE_NEW_PROCESS_DONE, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->orders_edit_mode==@EDIT_ORDER_MODE_NEW_PROCESS_DONE){?> selected<?php }?>>можно в заказах в обработке, новых и выполненных</option>
                        <option value="<?php echo htmlspecialchars(@EDIT_ORDER_MODE_NEW_PROCESS_DONE_CANCEL, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->orders_edit_mode==@EDIT_ORDER_MODE_NEW_PROCESS_DONE_CANCEL){?> selected<?php }?>>можно в любых заказах</option>
                    </select>
                </td>



                <td class="param_short">
                    Минимальн. сумма заказа:
                </td>
                <td class="value" title="Начиная с какой суммы заказа разрешать его оформление покупателем">
                    <input class="edit" name="orders_minimal_sum" size="10" style="width: auto;" type="text" value="<?php echo smarty_modifier_replace(sprintf('%1.2f',(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->orders_minimal_sum)===null||$tmp==='' ? 0 : $tmp))*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.');?>
" />
                </td>
                <td class="param_short">
                    <?php echo smarty_modifier_truncate(((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp)),3,'',true);?>

                </td>



                <td class="value_box">
                    <input class="submit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SETUP, ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Сохранить" />
                </td>
            </tr>



            <tr>
                <td class="param_short">
                    В письмо покупателю о заказе:
                </td>



                <td class="param_short" colspan="2" title="Прикреплять ли квитанцию на оплату через банк в письмо покупателю о заказе">
                    <input class="checkbox" id="setup_form_orders_attach_receipt" name="orders_attach_receipt" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->orders_attach_receipt)&&($_smarty_tpl->tpl_vars['settings']->value->orders_attach_receipt==1)){?> checked<?php }?> value="1" />
                    <span onclick="Toggle_PageCheckbox('setup_form_orders_attach_receipt');">
                        Прикреплять квитанцию оплаты банком
                    </span>
                </td>



                <td class="param_short" title="При включенном флажке товары списываются со склада виртуально (без реального изменения количества товаров в базе данных)">
                    <input class="checkbox" id="setup_form_orders_non_touch_quantity" name="orders_non_touch_quantity" type="checkbox"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->orders_non_touch_quantity)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" />
                    <span onclick="Toggle_PageCheckbox('setup_form_orders_non_touch_quantity');">
                        Статичное число товаров
                    </span>
                </td>



                <td class="param_short" colspan="3" title="Разрешено ли оформлять заказ, когда выбранный товар есть только в частичном количестве на складе">
                    <input class="checkbox" id="setup_form_orders_deficit_enabled" name="orders_deficit_enabled" type="checkbox"<?php if ((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->orders_deficit_enabled)===null||$tmp==='' ? false : $tmp)){?> checked<?php }?> value="1" />
                    <span onclick="Toggle_PageCheckbox('setup_form_orders_deficit_enabled');">
                        Допустим неполный дефицит товара
                    </span>
                </td>
            </tr>



            <tr>
                <td class="param_short">
                    Авто экспорт новых заказов:
                </td>



                
                <td class="param_short" title="Включен ли авто экспорт заказов">

                    <?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable('orders_auto_export', null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable('', null, 0);?>
                    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['settings']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                        <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['param']->value){?>
                            <?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable($_smarty_tpl->tpl_vars['value']->value ? 'checked' : '', null, 0);?>
                            <?php break 1?>
                        <?php }?>
                    <?php } ?>
                    <input class="checkbox" id="setup_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" value="1" <?php echo $_smarty_tpl->tpl_vars['checked']->value;?>
 />
                     

                    <span onclick="Toggle_PageCheckbox('setup_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param']->value, ENT_QUOTES, 'UTF-8');?>
');">
                        Включен
                    </span>
                </td>



                
                <td class="value" width="100%" title="В каком формате экспортировать заказы в файл">
                    <select name="orders_auto_export_format">
                        <option value="xml">в формате XML</option>
                    </select>
                </td>



                
                <td class="param_short">
                    Через http://сайт/export/
                </td>
                <td class="value" colspan="3" title="В какой файл добавлять экспорт новых заказов (рекомендуется придумать трудно подбираемое имя файла)">
                    <input class="edit" name="orders_auto_export_file" type="text" value="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->orders_auto_export_file)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" />
                </td>
            </tr>
        </table>



        
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" />



    </form>

  </div>
<?php }} ?>