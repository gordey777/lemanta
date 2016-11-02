<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:05:36
         compiled from "../admin/design/default/html/admin_order.htm" */ ?>
<?php /*%%SmartyHeaderCode:183616829257d5b91079faa7-01375344%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a197249308e9d531c005e59336d1963bcd1ed452' => 
    array (
      0 => '../admin/design/default/html/admin_order.htm',
      1 => 1462406599,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183616829257d5b91079faa7-01375344',
  'function' => 
  array (
    'products_tree' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'item' => 0,
    'root_url' => 0,
    'admin_folder' => 0,
    'id' => 0,
    'error' => 0,
    'message' => 0,
    'all_users' => 0,
    'orders_phases' => 0,
    'r' => 0,
    'deliveries_types' => 0,
    'payments' => 0,
    'image' => 0,
    'f' => 0,
    'description' => 0,
    'settings' => 0,
    'currency' => 0,
    'quantity' => 0,
    'deliveries' => 0,
    'temp' => 0,
    'from_page' => 0,
    'Token' => 0,
    'catalog' => 0,
    'cats' => 0,
    'c' => 0,
    'level' => 0,
    'number' => 0,
    'v' => 0,
    'subnumber' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b910bdb418_16788593',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b910bdb418_16788593')) {function content_57d5b910bdb418_16788593($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"card",'main'=>true,'orders'=>true,'card_orders'=>true,'orders_phases'=>true,'payments_history'=>true,'credit_programs'=>true), 0);?>


  
  <?php $_smarty_tpl->tpl_vars["id"] = new Smarty_variable(htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->order_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?>

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
        → <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Orders" title="Перейти на страницу заказов в админпанели">Заказы</a>
        → <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>Редактирование<?php }else{ ?>Новый<?php }?>
      </div>
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>
        Заказ №<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->order_id, ENT_QUOTES, 'UTF-8');?>

      <?php }else{ ?>
        Новый заказ
      <?php }?>
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)&&isset($_smarty_tpl->tpl_vars['item']->value->code)&&($_smarty_tpl->tpl_vars['item']->value->code!='')&&empty($_smarty_tpl->tpl_vars['error']->value)){?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->code, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу заказа в клиентской части сайта">http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->code, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?>&nbsp;<?php }?>
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

    <!-- Форма данных записи -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Order" enctype="multipart/form-data" id="item_form" method="post">

      <!-- Информация о покупателе -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">

        <!-- поле Фамилия -->
        <tr>
          <td class="param">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Feedback" title="Перейти на страницу переписки в админпанели">Ф.И.О.</a>:
          </td>
          <td class="value" width="40%" title="Фамилия покупателя">
            <input class="edit" id="item_form_name" name="name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <!-- кнопка обмена -->
          <td class="param_short">
            <a href="#" onclick="javascript: return Swap_Inputbox_Values('item_form_name', 'item_form_name3');" title="Обменять значения этих соседних полей">→</a>
          </td>

          <!-- поле Имя -->
          <td class="value" width="40%" title="Имя покупателя">
            <input class="edit" id="item_form_name3" name="name3[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name3)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <!-- кнопка обмена -->
          <td class="param_short">
            <a href="#" onclick="javascript: return Swap_Inputbox_Values('item_form_name3', 'item_form_name2');" title="Обменять значения этих соседних полей">→</a>
          </td>

          <!-- поле Отчество -->
          <td class="value" width="20%" title="Отчество покупателя">
            <input class="edit" id="item_form_name2" name="name2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- кнопка Применить -->
          <td class="value_box" width="1%" title="Сохранить изменения и остаться на этой же странице">
            <input class="submit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_AS_ACCEPT, ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить">
          </td>

          <!-- кнопка Сохранить -->
          <td class="value_box" title="Сохранить изменения и перейти в список">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>

        <!-- флаг Протестировать уведомление -->
        <tr>
          <td class="param" colspan="3">
            &nbsp;
          </td>
          <td class="param_short" title="Показать уведомление на экране вместо его отправки">
            <input class="checkbox" id="item_form_inform_testing" name="inform_testing[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_inform_testing');">
              тестировать уведомление
            </span>
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- флаг Уведомить администратора -->
          <td class="param_short" colspan="2" title="Информировать ли администратора по емейлу об изменениях в заказе">
            <input class="checkbox" name="inform_admin_sms[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" value="1" title="Информировать ли администратора по SMS об изменениях в заказе">
            <input class="checkbox" id="item_form_inform_admin" name="inform_admin[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_inform_admin');">
              уведомить админа о правках
            </span>
          </td>

          <!-- флаг Уведомить покупателя -->
          <td class="param_short" colspan="2" title="Информировать ли покупателя по емейлу об изменениях в заказе">
            <input class="checkbox" name="inform_user_sms[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" value="1" title="Информировать ли покупателя по SMS об изменениях в заказе">
            <input class="checkbox" id="item_form_inform_user" name="inform_user[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox" value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_inform_user');">
              и клиента
            </span>
          </td>
        </tr>

        <!-- поле Телефоны -->
        <tr>
          <td class="param">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=CallMe" title="Перейти на страницу запросов связи в админпанели">Телефон</a>:
          </td>
          <td class="value" width="33%" title="Телефон 1 покупателя">
            <input class="edit" id="item_form_phone" name="phone[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->phone)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <!-- кнопка обмена -->
          <td class="param_short">
            <a href="#" onclick="javascript: return Swap_Inputbox_Values('item_form_phone', 'item_form_phone2');" title="Обменять значения этих соседних полей">→</a>
          </td>

          <td class="value" width="33%" title="Телефон 2 покупателя">
            <input class="edit" id="item_form_phone2" name="phone2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->phone2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Пользователь -->
          <td class="param_short">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Users" title="Перейти на страницу клиентов в админпанели">Пользователь</a>:
          </td>
          <td class="value" colspan="2" width="100%" title="Кто это из зарегистрированных пользователей">
            <select name="user_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0"></option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->user_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

            </select>
          </td>
        </tr>

        <!-- поле Емейлы -->
        <tr>
          <td class="param">
            Емейл:
          </td>
          <td class="value" width="33%" title="Емейл 1 покупателя">
            <input class="edit" id="item_form_email" name="email[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->email)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <!-- кнопка обмена -->
          <td class="param_short">
            <a href="#" onclick="javascript: return Swap_Inputbox_Values('item_form_email', 'item_form_email2');" title="Обменять значения этих соседних полей">→</a>
          </td>

          <td class="value" width="33%" title="Емейл 2 покупателя">
            <input class="edit" id="item_form_email2" name="email2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->email2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Дата заказа -->
          <td class="param_short">
            Дата заказа:
          </td>
          <td class="value" title="Дата оформления заказа (формат ГГГГ-ММ-ДД)">
            <script language="JavaScript" type="text/javascript">
              <!--
              var xcDateFormat = 'yyyy-mm-dd';
              // -->
            </script>
            <input class="edit" maxlength="10" name="date_date[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->date_date)&&($_smarty_tpl->tpl_vars['item']->value->date_date!='0000-00-00')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->date_date, ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
<?php }?>" onfocus="javascript: showCalendar('', this, this, '', 'holder', 5, 5, 1);">
          </td>
          <td class="value" title="Время оформления заказа (формат ЧЧ:ММ:СС)">
            <input class="edit" maxlength="8" name="date_time[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->date_time)&&($_smarty_tpl->tpl_vars['item']->value->date_time!='00:00:00')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->date_time, ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo smarty_modifier_date_format(time(),'%H:%M:%S');?>
<?php }?>">
          </td>
        </tr>

        <!-- поле Номера ICQ -->
        <tr>
          <td class="param">
            Номер ICQ:
          </td>
          <td class="value" width="33%" title="Номер 1 ICQ покупателя">
            <input class="edit" id="item_form_icq" name="icq[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->icq)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <!-- кнопка обмена -->
          <td class="param_short">
            <a href="#" onclick="javascript: return Swap_Inputbox_Values('item_form_icq', 'item_form_icq2');" title="Обменять значения этих соседних полей">→</a>
          </td>

          <td class="value" width="33%" title="Номер 2 ICQ покупателя">
            <input class="edit" id="item_form_icq2" name="icq2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->icq2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Состояние -->
          <td class="param_short">
            Состояние:
          </td>
          <td class="value" colspan="2" width="100%" title="Состояние заказа">
            <select name="status[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="<?php echo htmlspecialchars(@ORDER_STATUS_NEW, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->status)&&($_smarty_tpl->tpl_vars['item']->value->status==@ORDER_STATUS_NEW)){?> selected<?php }?>>Новый</option>
              <option value="<?php echo htmlspecialchars(@ORDER_STATUS_PROCESS, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->status)&&($_smarty_tpl->tpl_vars['item']->value->status==@ORDER_STATUS_PROCESS)){?> selected<?php }?>>В обработке</option>
              <option value="<?php echo htmlspecialchars(@ORDER_STATUS_DONE, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->status)&&($_smarty_tpl->tpl_vars['item']->value->status==@ORDER_STATUS_DONE)){?> selected<?php }?>>Выполнен</option>
              <option value="<?php echo htmlspecialchars(@ORDER_STATUS_CANCEL, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->status)&&($_smarty_tpl->tpl_vars['item']->value->status==@ORDER_STATUS_CANCEL)){?> selected<?php }?>>Аннулирован</option>
            </select>
          </td>
        </tr>

        <!-- поле Skype имена -->
        <tr>
          <td class="param">
            Skype имя:
          </td>
          <td class="value" width="33%" title="Skype имя 1 покупателя">
            <input class="edit" id="item_form_skype" name="skype[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->skype)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <!-- кнопка обмена -->
          <td class="param_short">
            <a href="#" onclick="javascript: return Swap_Inputbox_Values('item_form_skype', 'item_form_skype2');" title="Обменять значения этих соседних полей">→</a>
          </td>

          <td class="value" width="33%" title="Skype имя 2 покупателя">
            <input class="edit" id="item_form_skype2" name="skype2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->skype2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Стадия состояния -->
          <td class="param_short">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=OrdersPhases" title="Перейти на страницу стадий заказа в админпанели">стадия</a>:
          </td>
          <td class="value" colspan="2" width="100%" title="Стадия состояния">

            <!-- Создаем селектор стадий заказа -->
            <select name="state[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0"></option>
              <?php if (isset($_smarty_tpl->tpl_vars['orders_phases']->value)&&!empty($_smarty_tpl->tpl_vars['orders_phases']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders_phases']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->phase_id, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['r']->value->phase_id==(($tmp = @$_smarty_tpl->tpl_vars['item']->value->state)===null||$tmp==='' ? 0 : $tmp)){?> selected<?php }?>>
                    <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->name), ENT_QUOTES, 'UTF-8');?>

                  </option>
                <?php } ?>
              <?php }?>
            </select>
          </td>
        </tr>

        <!-- поле Адрес 1 -->
        <tr>
          <td class="param">
            Адрес доставки:
          </td>
          <td class="value" colspan="3" title="Адрес 1 доставки">

            <!-- выпадающая панель с полями адреса 1 -->
            <div class="popup_in_cell">
              <table align="center" cellpadding="0" cellspacing="10" class="white">
                <tr>
                  <td class="param_short">
                    Страна:
                  </td>
                  <td class="value" colspan="7" width="100%" title="Страна">
                    <input class="edit panel_address_field_1" name="address[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Область:
                  </td>
                  <td class="value" colspan="7" width="100%" title="Область">
                    <input class="edit panel_address_field_2" name="address_2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Город:
                  </td>
                  <td class="value" colspan="5" width="100%" title="Город">
                    <input class="edit panel_address_field_3" name="address_3[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_3)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Индекс:
                  </td>
                  <td class="value" title="Почтовый индекс">
                    <input class="edit panel_address_field_10" name="address_10[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_10)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Улица:
                  </td>
                  <td class="value" colspan="7" width="100%" title="Улица">
                    <input class="edit panel_address_field_4" name="address_4[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_4)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Дом:
                  </td>
                  <td class="value" title="Дом">
                    <input class="edit panel_address_field_5" name="address_5[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_5)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Корпус:
                  </td>
                  <td class="value" title="Корпус">
                    <input class="edit panel_address_field_6" name="address_6[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="2" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_6)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Подъезд:
                  </td>
                  <td class="value" title="Подъезд">
                    <input class="edit panel_address_field_7" name="address_7[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="2" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_7)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Код:
                  </td>
                  <td class="value" title="Код на двери подъезда">
                    <input class="edit panel_address_field_8" name="address_8[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_8)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Квартира:
                  </td>
                  <td class="value" title="Квартира">
                    <input class="edit panel_address_field_9" name="address_9[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="5" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address_9)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short" colspan="4" width="100%">
                    &nbsp;
                  </td>
                  <td class="value_box" colspan="2" title="Закрыть это окно">
                    <input class="submit panel_ok_button" type="button" value="Ok" onclick="javascript: return Hide_Popup_Address(this);">
                  </td>
                </tr>
              </table>
            </div>

            <!-- Скрипт обработки выпадающей панели адреса -->
            
              <script language="JavaScript" type="text/javascript">
                <!--

                // открытие выпадающей панели
                //   link_object = кликабельный объект в ячейке таблицы, инициировавший открытие панели

                function Show_Popup_Address (link_object) {
                  jQuery('div.popup_in_cell').find('input.panel_ok_button').click();
                  var panel = jQuery(link_object).parent().find('div.popup_in_cell');
                  if ((typeof(panel) == 'object') && (panel != null) && ('length' in panel) && (panel.length > 0)) {
                    panel = panel[0];
                    if ((typeof(panel) == 'object') && (panel != null)) {
                      jQuery(panel).show();
                      jQuery(panel).find(':input:first').focus();
                    }
                  }
                  return false;
                }

                // закрытие выпадающей панели
                //   link_object = кликабельный объект в панели, инициировавший ее закрытие

                function Hide_Popup_Address (link_object) {
                  var panel = jQuery(link_object).closest('div.popup_in_cell').hide();
                  if ((typeof(panel) == 'object') && (panel != null) && ('length' in panel) && (panel.length > 0)) {
                    panel = panel[0];
                    if ((typeof(panel) == 'object') && (panel != null)) {
                      var result = jQuery.trim(jQuery(panel).find('input.panel_address_field_10').val());
                      var value = jQuery.trim(jQuery(panel).find('input.panel_address_field_1').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_2').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_3').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_4').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_5').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += 'дом ' + value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_6').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += 'корпус ' + value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_7').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += 'подъезд ' + value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_8').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += 'код ' + value;
                      }
                      value = jQuery.trim(jQuery(panel).find('input.panel_address_field_9').val());
                      if (value != '') {
                        if (result != '') result += ', ';
                        result += 'квартира ' + value;
                      }
                      jQuery(panel).parent().find(':input:last').val(result);
                    }
                  }
                  return false;
                }
                // -->
              </script>
            

            <!-- нередактируемое поле составного адреса -->
            <input class="edit" name="compound_address[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->compound_address)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" onfocus="javascript: return Show_Popup_Address(this);">
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Комментарий администратора -->
          <td class="value" colspan="3" rowspan="2" title="Комментарий администратора к заказу">
            <textarea name="comment_status[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 48px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->comment_status)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea>
          </td>
        </tr>

        <!-- поле Адрес 2 -->
        <tr>
          <td class="param">
            Адрес 2:
          </td>
          <td class="value" colspan="3" title="Адрес 2 доставки">

            <!-- выпадающая панель с полями адреса 2 -->
            <div class="popup_in_cell">
              <table align="center" cellpadding="0" cellspacing="10" class="white">
                <tr>
                  <td class="param_short">
                    Страна:
                  </td>
                  <td class="value" colspan="7" width="100%" title="Страна">
                    <input class="edit panel_address_field_1" name="address2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Область:
                  </td>
                  <td class="value" colspan="7" width="100%" title="Область">
                    <input class="edit panel_address_field_2" name="address2_2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Город:
                  </td>
                  <td class="value" colspan="5" width="100%" title="Город">
                    <input class="edit panel_address_field_3" name="address2_3[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_3)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Индекс:
                  </td>
                  <td class="value" title="Почтовый индекс">
                    <input class="edit panel_address_field_10" name="address2_10[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_10)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Улица:
                  </td>
                  <td class="value" colspan="7" width="100%" title="Улица">
                    <input class="edit panel_address_field_4" name="address2_4[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_4)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Дом:
                  </td>
                  <td class="value" title="Дом">
                    <input class="edit panel_address_field_5" name="address2_5[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_5)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Корпус:
                  </td>
                  <td class="value" title="Корпус">
                    <input class="edit panel_address_field_6" name="address2_6[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="2" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_6)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Подъезд:
                  </td>
                  <td class="value" title="Подъезд">
                    <input class="edit panel_address_field_7" name="address2_7[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="2" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_7)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short">
                    Код:
                  </td>
                  <td class="value" title="Код на двери подъезда">
                    <input class="edit panel_address_field_8" name="address2_8[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_8)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                </tr>
                <tr>
                  <td class="param_short">
                    Квартира:
                  </td>
                  <td class="value" title="Квартира">
                    <input class="edit panel_address_field_9" name="address2_9[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="5" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->address2_9)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                  </td>
                  <td class="param_short" colspan="4" width="100%">
                    &nbsp;
                  </td>
                  <td class="value_box" colspan="2" title="Закрыть это окно">
                    <input class="submit panel_ok_button" type="button" value="Ok" onclick="javascript: return Hide_Popup_Address(this);">
                  </td>
                </tr>
              </table>
            </div>

            <!-- нередактируемое поле составного адреса -->
            <input class="edit" name="compound_address2[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->compound_address2)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" onfocus="javascript: return Show_Popup_Address(this);">
          </td>
          <td class="param_short">
            &nbsp;
          </td>
        </tr>

        <!-- поле Тип доставки -->
        <tr>
          <td class="param">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=DeliveriesTypes" title="Перейти на страницу типов доставки в админпанели">Тип доставки</a>:
          </td>
          <td class="value" colspan="3" title="Тип доставки">

            <!-- Создаем селектор типов доставки -->
            <select name="delivery_type[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0"></option>
              <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deliveries_types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->type_id, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['r']->value->type_id==$_smarty_tpl->tpl_vars['item']->value->delivery_type){?> selected<?php }?>>
                  <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->name), ENT_QUOTES, 'UTF-8');?>

                </option>
              <?php } ?>
            </select>
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Дата оплаты (с флажком Оплачен) -->
          <td class="param_short" title="Оплачен ли заказ">
            <input class="checkbox" id="item_form_payment_status" name="payment_status[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->payment_status)&&($_smarty_tpl->tpl_vars['item']->value->payment_status==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_payment_status');">
              Оплачен:
            </span>
          </td>
          <td class="value" title="Дата оплаты заказа (формат ГГГГ-ММ-ДД)">
            <script language="JavaScript" type="text/javascript">
              <!--
              var xcDateFormat = 'yyyy-mm-dd';
              // -->
            </script>
            <input class="edit" maxlength="10" name="payment_date_date[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->payment_date_date)&&($_smarty_tpl->tpl_vars['item']->value->payment_date_date!='0000-00-00')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->payment_date_date, ENT_QUOTES, 'UTF-8');?>
<?php }?>" onfocus="javascript: showCalendar('', this, this, '', 'holder', 5, 5, 1);">
          </td>
          <td class="value" title="Время оплаты заказа (формат ЧЧ:ММ:СС)">
            <input class="edit" maxlength="8" name="payment_date_time[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->payment_date_time)&&($_smarty_tpl->tpl_vars['item']->value->payment_date_time!='00:00:00')){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->payment_date_time, ENT_QUOTES, 'UTF-8');?>
<?php }?>">
          </td>
        </tr>

        <!-- поле Комментарий покупателя -->
        <tr>
          <td class="param_high" rowspan="4">
            Комментарий:
          </td>
          <td class="value" colspan="3" rowspan="4" title="Комментарий покупателя к заказу">
            <textarea name="comment[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 112px;"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->comment)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</textarea>
          </td>
          <td class="param_short" rowspan="4">
            &nbsp;
          </td>

          <!-- поле Способ оплаты -->
          <td class="param_short">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Payments" title="Перейти на страницу способов оплаты в админпанели">Способ оплаты</a>:
          </td>
          <td class="value" colspan="2" width="100%" title="Каким способом был оплачен заказ (если был желавшийся покупателем способ, он выделяется красным цветом)">
            <select name="payment_method_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0"></option>
              <?php if (isset($_smarty_tpl->tpl_vars['payments']->value)&&!empty($_smarty_tpl->tpl_vars['payments']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->payment_method_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (($_smarty_tpl->tpl_vars['r']->value->payment_method_id==(($tmp = @$_smarty_tpl->tpl_vars['item']->value->payment_method_id)===null||$tmp==='' ? 0 : $tmp))||((!isset($_smarty_tpl->tpl_vars['item']->value->payment_method_id)||empty($_smarty_tpl->tpl_vars['item']->value->payment_method_id))&&($_smarty_tpl->tpl_vars['r']->value->payment_method_id==(($tmp = @$_smarty_tpl->tpl_vars['item']->value->desire_payment_id)===null||$tmp==='' ? 0 : $tmp)))){?> selected<?php }?><?php if ($_smarty_tpl->tpl_vars['r']->value->payment_method_id==(($tmp = @$_smarty_tpl->tpl_vars['item']->value->desire_payment_id)===null||$tmp==='' ? 0 : $tmp)){?> style="color: #C00000;"<?php }?>>
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->name, ENT_QUOTES, 'UTF-8');?>

                  </option>
                <?php } ?>
              <?php }?>
            </select>
          </td>
        </tr>

        <!-- поле Партнер -->
        <tr>
          <td class="param_short">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Users" title="Перейти на страницу клиентов в админпанели">Партнер</a>:
          </td>
          <td class="value" colspan="2" width="100%" title="С участием какого партнера был сделан этот заказ">
            <select name="affiliate_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0"></option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->affiliate_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

            </select>
          </td>
        </tr>

        <!-- поле Желаемая дата доставки -->
        <tr>
          <td class="param_short">
            Желает к дате:
          </td>
          <td class="value" colspan="2" width="100%" title="Желаемая дата доставки">
            <input class="edit" name="to_date[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->to_date)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
        </tr>
        <tr>
          <td class="param_short">
            ко времени:
          </td>
          <td class="value" colspan="2" width="100%" title="Желаемое время доставки">
            <input class="edit" name="to_time[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->to_time)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
        </tr>
      </table>

      <h2>
        Товары
      </h2>
 
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <?php if (isset($_smarty_tpl->tpl_vars['item']->value->products)&&!empty($_smarty_tpl->tpl_vars['item']->value->products)){?>
          <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['v']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['v']['iteration']++;
?>
            <tr>

              <!-- нумерация -->
              <td class="param_short" style="height: 10px; vertical-align: bottom;">
                <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
.
              </td>

              <!-- поле Название товара -->
              <td class="param_text" colspan="2" rowspan="2" width="75%" title="Название товара">

                <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable('', null, 0);?>
                <?php if (isset($_smarty_tpl->tpl_vars['r']->value->small_image)){?>
                  <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['r']->value->small_image)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                <?php }?>
                <?php if (($_smarty_tpl->tpl_vars['image']->value=='')&&isset($_smarty_tpl->tpl_vars['r']->value->large_image)){?>
                  <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['r']->value->large_image)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                <?php }?>
                <?php if (($_smarty_tpl->tpl_vars['image']->value=='')&&isset($_smarty_tpl->tpl_vars['r']->value->fotos)&&!empty($_smarty_tpl->tpl_vars['r']->value->fotos)){?>
                  <?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['f']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value->fotos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
$_smarty_tpl->tpl_vars['f']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['image']->value==''){?>
                      <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['f']->value->filename)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php }?>
                  <?php } ?>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['image']->value==''){?>
                  <?php $_smarty_tpl->tpl_vars["description"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['r']->value->description)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                  <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['description']->value,"'^.*?<img[^>]+?src=([^>\s]+).+"."$"."'is","\\1"), null, 0);?>
                  <?php if ($_smarty_tpl->tpl_vars['image']->value==$_smarty_tpl->tpl_vars['description']->value){?>
                    <?php $_smarty_tpl->tpl_vars["description"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['r']->value->body)===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['description']->value,"'^.*?<img[^>]+?src=([^>\s]+).+"."$"."'is","\\1"), null, 0);?>
                    <?php if ($_smarty_tpl->tpl_vars['image']->value==$_smarty_tpl->tpl_vars['description']->value){?>
                      <?php $_smarty_tpl->tpl_vars["image"] = new Smarty_variable('', null, 0);?>
                    <?php }?>
                  <?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['image']->value==''){?>
                    <?php $_smarty_tpl->_capture_stack[0][] = array('default', "image", null); ob_start(); ?>"http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8');?>
/images/no_foto.jpg"<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                  <?php }?>
                <?php }else{ ?>
                  <?php $_smarty_tpl->_capture_stack[0][] = array('default', "image", null); ob_start(); ?>"<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['image']->value,7,'',true), 'UTF-8')!='http://'){?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
"<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                <?php }?>

                <!-- изображение -->
                <a class="image<?php if ($_smarty_tpl->tpl_vars['r']->value->model==''){?> image_no_product<?php }?>" href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php if ($_smarty_tpl->tpl_vars['r']->value->url_special!=1){?>products/<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->url, ENT_QUOTES, 'UTF-8');?>
" title="<?php if (!isset($_smarty_tpl->tpl_vars['settings']->value->product_category_show)||($_smarty_tpl->tpl_vars['settings']->value->product_category_show==1)){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->category), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php if (!isset($_smarty_tpl->tpl_vars['settings']->value->product_brand_show)||($_smarty_tpl->tpl_vars['settings']->value->product_brand_show==1)){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->brand), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->model), ENT_QUOTES, 'UTF-8');?>
"><div class="image<?php if ($_smarty_tpl->tpl_vars['r']->value->model==''){?> image_no_product" title="Этого товара уже нет в каталоге сайта<?php }?>"><img src=<?php echo $_smarty_tpl->tpl_vars['image']->value;?>
></div></a>

                <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php if ($_smarty_tpl->tpl_vars['r']->value->url_special!=1){?>products/<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->url, ENT_QUOTES, 'UTF-8');?>
">
                  <span class="text"><?php echo htmlspecialchars((($tmp = @preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->product_name))===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</span>
                </a>
                <?php if ((preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->variant_name))!='')&&(preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->variant_name))!=preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->product_name)))){?>
                  <span class="subtext"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->variant_name), ENT_QUOTES, 'UTF-8');?>
</span>
                <?php }?>
                <?php if (preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->name_properties))!=''){?>
                  <span class="subinfo"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->name_properties), ENT_QUOTES, 'UTF-8');?>
</span>
                <?php }?>
                <input name="orderitem_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php if (!isset($_smarty_tpl->tpl_vars['r']->value->virtual)){?><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->orderitem_id, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp);?>
<?php }else{ ?>0<?php }?>">
                <input name="orderitem_product_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->product_id, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp);?>
">
                <input name="orderitem_variant_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->variant_id, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp);?>
">
                <input name="orderitem_product_name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->product_name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                <input name="orderitem_variant_name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->variant_name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
                <input name="orderitem_name_properties[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->name_properties)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
              </td>

              <!-- поле Цена -->
              <td class="value" title="Цена товара">
                <input class="edit" id="orderitem_price_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_price[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" size="10" style="width: auto;" type="text" value="<?php echo smarty_modifier_replace(sprintf('%1.2f',(((($tmp = @$_smarty_tpl->tpl_vars['r']->value->real_price)===null||$tmp==='' ? 0 : $tmp))*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.');?>
" onkeyup="javascript: return Change_OrderItem_Price(event, this, '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', '<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
', '', true);">
              </td>
              <td class="param_short">
                <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currencies" title="Перейти на страницу валют в админпанели"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</a>
              </td>

              <!-- поле Количество -->
              <td class="value" title="Количество товара (отрицательное число обозначает продажу под заказ)">
                <input class="edit" id="orderitem_quantity_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_quantity[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" size="5" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->quantity, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp);?>
" onkeyup="javascript: return Change_OrderItem_Quantity(event, this, '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', '<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
', true);">
                <input name="orderitem_quantity_previous[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->quantity, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp);?>
">
              </td>
              <td class="param_short">
                шт.
              </td>

              <!-- поле Скидка -->
              <td class="value" title="Использовать скидку">
                <input class="edit" id="orderitem_discount_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_discount[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" size="5" style="width: auto;" type="text" value="<?php if (smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['r']->value->discount),',','.')!='0.00'){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['r']->value->discount),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }?>" onkeyup="javascript: return Change_OrderItem_Discount(event, this, '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', '<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
', true);">
              </td>
              <td class="param_short">
                <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Groups" title="Перейти на страницу групповых скидок в админпанели">%</a>
              </td>

              <!-- окончательная цена позиции -->
              <?php $_smarty_tpl->tpl_vars["quantity"] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value->quantity, null, 0);?>
              <?php if ($_smarty_tpl->tpl_vars['r']->value->quantity<0){?>
                <?php $_smarty_tpl->tpl_vars["quantity"] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value->quantity*-1, null, 0);?>
              <?php }?>
              <td class="param_short" id="orderitem_total_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" old_value="<?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',(((($tmp = @$_smarty_tpl->tpl_vars['r']->value->price)===null||$tmp==='' ? 0 : $tmp))*$_smarty_tpl->tpl_vars['quantity']->value*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.'), ENT_QUOTES, 'UTF-8');?>
" style="text-align: right;">
                <?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",(((($tmp = @$_smarty_tpl->tpl_vars['r']->value->price)===null||$tmp==='' ? 0 : $tmp))*$_smarty_tpl->tpl_vars['quantity']->value*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",","."), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>

              </td>

              <!-- флажок Используется -->
              <td class="param_short" title="Действительна ли эта товарная позиция (позиции со снятым флажком будут удалены)">
                <input class="checkbox" id="orderitem_used_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
" name="orderitem_used[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['v']['iteration'];?>
]" type="checkbox" checked value="1" onchange="javascript: Toggle_TableRowTransparency(this, this.checked, 0.3);">
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="4">&nbsp;</td>
            </tr>
          <?php } ?>
        <?php }?>

        <!-- Доставка -->
        <tr>
          <td class="param_short">
            &nbsp;
          </td>

          <!-- поле Способ доставки -->
          <td class="param_text">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Deliveries" title="Перейти на страницу способов доставки в админпанели">Способ&nbsp;доставки</a>:
          </td>
          <td class="value" width="75%" title="Способ доставки">
            <select name="delivery_method_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" onchange="javascript: Change_Delivery_Method(this.value);">
              <option value="0"></option>
              <?php if (isset($_smarty_tpl->tpl_vars['deliveries']->value)&&!empty($_smarty_tpl->tpl_vars['deliveries']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deliveries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->delivery_method_id, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['r']->value->delivery_method_id==(($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_method_id)===null||$tmp==='' ? 0 : $tmp)){?> selected<?php }?>>
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->name, ENT_QUOTES, 'UTF-8');?>
 [<?php if (smarty_modifier_replace(sprintf("%1.2f",$_smarty_tpl->tpl_vars['r']->value->discount),",",".")>=0){?>скидка <?php echo smarty_modifier_replace(sprintf("%1.2f",$_smarty_tpl->tpl_vars['r']->value->discount),",",".");?>
%, <?php }?>цена <?php echo smarty_modifier_replace(sprintf("%1.2f",(((($tmp = @$_smarty_tpl->tpl_vars['r']->value->price)===null||$tmp==='' ? 0 : $tmp))*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",",".");?>
 <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php if (smarty_modifier_replace(sprintf("%1.2f",$_smarty_tpl->tpl_vars['r']->value->free_from),",",".")>0){?>, бесплатно от <?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['r']->value->free_from*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",",".");?>
 <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php }?>]
                  </option>
                <?php } ?>
              <?php }?>
            </select>
          </td>

          <!-- поле Цена доставки -->
          <td class="value" title="Цена доставки">
            <input class="edit" id="delivery_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="delivery_price[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_price)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->delivery_price*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?>" onkeyup="javascript: return Change_OrderItem_Price(event, this, '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', 'delivery', '', true);">
          </td>
          <td class="param_short">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currencies" title="Перейти на страницу валют в админпанели"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</a>
          </td>

          <!-- поле Трекинг посылки -->
          <td class="value" colspan="3" title="Код отслеживания груза (выдается службой доставки)">
            <input class="edit" name="delivery_tracking[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_tracking)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <td class="param_short">
            &nbsp;
          </td>

          <td class="param_short" id="orderitem_total_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_delivery" old_value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_price)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->delivery_price*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?>" style="text-align: right;">
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_price)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['item']->value->delivery_price*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",","."), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?> <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>

          </td>

          <td class="param_short">
            &nbsp;
          </td>
        </tr>

        <!-- Дополнительная скидка -->
        <tr>
          <td class="param_short">
            &nbsp;
          </td>

          <td class="param_text" colspan="2" width="75%">
            Дополнительная скидка
          </td>

          <!-- поле Сумма дополнительной скидки -->
          <td class="value" title="Сумма дополнительной скидки">
            <input class="edit" id="discount_sum_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="discount_sum[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_sum)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->discount_sum*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?>" onkeyup="javascript: return Change_OrderItem_Price(event, this, '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', 'discount', '-', true);">
          </td>
          <td class="param_short" colspan="3">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currencies" title="Перейти на страницу валют в админпанели"><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</a>
          </td>

          <!-- поле Процент дополнительной скидки -->
          <td class="value" title="Сумма дополнительной скидки, выраженная в процентах">
            <?php $_smarty_tpl->tpl_vars["temp"] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
            <?php $_smarty_tpl->tpl_vars["temp"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp']->value+(($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_sum)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
            <?php $_smarty_tpl->tpl_vars["temp"] = new Smarty_variable($_smarty_tpl->tpl_vars['temp']->value+(($tmp = @$_smarty_tpl->tpl_vars['item']->value->delivery_price)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
            <?php if ($_smarty_tpl->tpl_vars['temp']->value==0){?><?php $_smarty_tpl->tpl_vars["temp"] = new Smarty_variable(1, null, 0);?><?php }?>
            <input class="edit" id="discount_percent_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" size="5" style="width: auto;" type="text" value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_sum)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->discount_sum*100/$_smarty_tpl->tpl_vars['temp']->value)),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?>" onkeyup="javascript: return Change_Order_DiscountPercent(event, this, '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
', '-', true);">
          </td>
          <td class="param_short">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Groups" title="Перейти на страницу групповых скидок в админпанели">%</a>
          </td>

          <td class="param_short" id="orderitem_total_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_discount" old_value="-<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_sum)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->discount_sum*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?>" style="text-align: right;">
            -<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_sum)===null||$tmp==='' ? 0 : $tmp)>0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['item']->value->discount_sum*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",","."), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?> <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>

          </td>

          <td class="param_short">
            &nbsp;
          </td>
        </tr>

        <!-- кнопка Добавить товарную позицию -->
        <tr>
          <td class="param_short" colspan="5">
            <a href="#" id="item_form_add_key" title="Добавить товарную позицию" onclick="javascript: return Show_PageElements('catalog');">
              добавить
            </a>
          </td>

          <!-- итого товаров -->
          <td class="param_short" id="orderitem_total_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_order_quantity" old_value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->total_quantity)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
" style="color: #000000; text-align: right;" title="Количество товаров в заказе">
            <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->total_quantity)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>

          </td>
          <td class="param_short" colspan="3">
            шт.
          </td>

          <!-- итого сумма -->
          <td class="param_short" id="orderitem_total_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
_order_sum" old_value="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->total_amount)===null||$tmp==='' ? 0 : $tmp)!=0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->total_amount*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.'), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?>" style="color: #000000; text-align: right; min-width: 120px;" title="Полная сумма заказа">
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->total_amount)===null||$tmp==='' ? 0 : $tmp)!=0){?><?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['item']->value->total_amount*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",","."), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>0.00<?php }?> <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>

          </td>
          <td class="param_short">
            &nbsp;
          </td>
        </tr>
      </table>

      
        <script language="JavaScript" type="text/javascript">
          <!--

          // перечень цен на доставку

          
            var order_amount = <?php if ((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 0 : $tmp)!=0){?><?php echo smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['item']->value->amount*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.');?>
<?php }else{ ?>0.00<?php }?>;
            var order_undiscount_amount = <?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->amount)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php $_smarty_tpl->tpl_vars['temp'] = new Smarty_variable($_smarty_tpl->tpl_vars['temp']->value+(($tmp = @$_smarty_tpl->tpl_vars['item']->value->discount_sum)===null||$tmp==='' ? 0 : $tmp), null, 0);?><?php echo smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['temp']->value*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.');?>
;
            var delivery_prices = new Array();
            var delivery_free_from = new Array();
            var delivery_discounts = new Array();
            delivery_prices[0] = 0.00;
            delivery_free_from[0] = 0.00;
            delivery_discounts[0] = 0.00;
            <?php if (isset($_smarty_tpl->tpl_vars['deliveries']->value)&&!empty($_smarty_tpl->tpl_vars['deliveries']->value)){?>
              <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['deliveries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                delivery_prices[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->delivery_method_id, ENT_QUOTES, 'UTF-8');?>
] = <?php echo smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['r']->value->price*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.');?>
;
                delivery_free_from[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->delivery_method_id, ENT_QUOTES, 'UTF-8');?>
] = <?php echo smarty_modifier_replace(sprintf('%1.2f',($_smarty_tpl->tpl_vars['r']->value->free_from*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),',','.');?>
;
                delivery_discounts[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->delivery_method_id, ENT_QUOTES, 'UTF-8');?>
] = <?php echo smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['r']->value->discount),',','.');?>
;
              <?php } ?>
            <?php }?>
          

          // обработка смены способа доставки

          function Change_Delivery_Method (id) {

            // находим объект поля ввода цены доставки на странице
            var object = document.getElementById('delivery_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');
            if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {

              // передаем цену способа доставки
              var price = (order_amount < delivery_free_from[id]) || (delivery_free_from[id] <= 0) ? delivery_prices[id] : 0;
              object.value = price.toFixed(2);

              // если у объекта есть обработчик события OnKeyUp, вызываем обработчик
              if (object.onkeyup) object.onkeyup();

              // если у способа доставки есть своя скидка на заказ
              if (delivery_discounts[id] >= 0) {
                var object = document.getElementById('discount_sum_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
');
                if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {

                  // вычисляем скидку в виде суммы и передаем ее в поле ввода
                  price = delivery_discounts[id] * order_undiscount_amount / 100;
                  object.value = price.toFixed(2);

                  // если у поля ввода есть обработчик события OnKeyUp, вызываем обработчик
                  if (object.onkeyup) object.onkeyup();
                }
              }
            }
          }

          // добавление строки товарной позиции в таблицу товаров заказа
          //   object_id = идентификатор любого опорного объекта, размещенного в любой ячейке таблицы
          //   product_link_object = объект ссылки добавляемого товара
          //   product_id = идентификатор добавляемого товара
          //   variant_id = идентификатор варианта товара

          function Append_ProductTableRow (object_id, product_link_object, product_id, variant_id) {

            // находим опорный объект на странице
            var object = document.getElementById(object_id);
            if ((typeof(object) == 'object') && (object != null)) {

              // если существует опорный объект ссылки добавляемого товара
              if ((typeof(product_link_object) == 'object') && (product_link_object != null) && ('innerHTML' in product_link_object)) {

                // берем данные о товаре
                product_id = htmlspecialchars(product_id, 'ENT_QUOTES');
                variant_id = htmlspecialchars(variant_id, 'ENT_QUOTES');
                var product_name = htmlspecialchars(product_link_object.innerHTML, 'ENT_QUOTES');
                var childs = product_link_object.parentNode.childNodes;
                if (childs && childs.length > 3) {
                  var variant_name = '';
                  var variant_price = '';
                  if (childs[1] && ('innerHTML' in childs[1])) variant_price = htmlspecialchars(childs[1].innerHTML, 'ENT_QUOTES');
                  if (childs[4] && ('innerHTML' in childs[4])) variant_name = htmlspecialchars(childs[4].innerHTML, 'ENT_QUOTES');
                }

                // по опорному объекту выходим на объект таблицы (то есть [объект] -> [родительский TD] -> [родительский TR] -> [родительский TABLE])
                var table = jQuery(object).parent().parent().parent();
                if ((typeof(table) == 'object') && (table != null) && (table.length == 1)) {

                  // получаем все объекты строк в этой таблице
                  var tr = jQuery(table).find('tr');
                  var num = tr.length;
                  if (num > 0) {
                    if (num <= 1000) {

                      // запоминаем контент последней строки таблицы (это кнопка "Добавить")
                      var last_html = tr[num - 1].innerHTML;

                      // формируем контент новой строки таблицы
                      var id = <?php echo $_smarty_tpl->tpl_vars['id']->value;?>
;
                      num = (num - 3) / 2 + 1;
                      var html = '<td class="param_short" style="height: 10px; vertical-align: bottom;">' +
                                   num + '.' +
                                 '</td>' +
                                 '<td class="param_text" colspan="2" rowspan="2" width="75%" title="Название товара">' +
                                   '<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/products/' + product_id + '">' +
                                     '<span class="text">' + product_name + '</span>' +
                                   '</a>' +
                                   ((variant_name != '') ? '<span class="subtext">' + variant_name + '</span>' : '') +
                                   '<input name="orderitem_id[' + id + '][' + num + ']" type="hidden" value="0">' +
                                   '<input name="orderitem_product_id[' + id + '][' + num + ']" type="hidden" value="' + product_id + '">' +
                                   '<input name="orderitem_variant_id[' + id + '][' + num + ']" type="hidden" value="' + variant_id + '">' +
                                   '<input name="orderitem_product_name[' + id + '][' + num + ']" type="hidden" value="' + product_name + '">' +
                                   '<input name="orderitem_variant_name[' + id + '][' + num + ']" type="hidden" value="' + variant_name + '">' +
                                   '<input name="orderitem_name_properties[' + id + '][' + num + ']" type="hidden" value="">' +
                                 '</td>' +
                                 '<td class="value" title="Цена товара">' +
                                   '<input class="edit" id="orderitem_price_' + id + '_' + num + '" name="orderitem_price[' + id + '][' + num + ']" size="10" style="width: auto;" type="text" value="' + variant_price + '" onkeyup="javascript: return Change_OrderItem_Price(event, this, \'' + id + '\', \'' + num + '\', \'\', true);">' +
                                 '</td>' +
                                 '<td class="param_short">' +
                                   '<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currencies" title="Перейти на страницу валют в админпанели">' +
                                     '<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
' +
                                   '</a>' +
                                 '</td>' +
                                 '<td class="value" title="Количество товара (отрицательное число обозначает продажу под заказ)">' +
                                   '<input class="edit" id="orderitem_quantity_' + id + '_' + num + '" name="orderitem_quantity[' + id + '][' + num + ']" size="5" style="width: auto;" type="text" value="1" old_value="0" onkeyup="javascript: return Change_OrderItem_Quantity(event, this, \'' + id + '\', \'' + num + '\', true);">' +
                                   '<input name="orderitem_quantity_previous[' + id + '][' + num + ']" type="hidden" value="0">' +
                                 '</td>' +
                                 '<td class="param_short">' +
                                    'шт.' +
                                 '</td>' +
                                 '<td class="value" title="Использовать скидку">' +
                                   '<input class="edit" id="orderitem_discount_' + id + '_' + num + '" name="orderitem_discount[' + id + '][' + num + ']" size="5" style="width: auto;" type="text" value="" onkeyup="javascript: return Change_OrderItem_Discount(event, this, \'' + id + '\', \'' + num + '\', true);">' +
                                 '</td>' +
                                 '<td class="param_short">' +
                                   '<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Groups" title="Перейти на страницу групповых скидок в админпанели">' +
                                     '%' +
                                   '</a>'+
                                 '</td>' +
                                 '<td class="param_short" id="orderitem_total_' + id + '_' + num + '" old_value="0.00" style="text-align: right;">' +
                                   variant_price + ' <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
' +
                                 '</td>' +
                                 '<td class="param_short" title="Действительна ли эта товарная позиция (позиции со снятым флажком будут удалены)">' +
                                   '<input class="checkbox" id="orderitem_used_' + id + '_' + num + '" name="orderitem_used[' + id + '][' + num + ']" type="checkbox" checked value="1" onchange="javascript: Toggle_TableRowTransparency(this, this.checked, 0.3);">' +
                                 '</td>';

                      // вставляем контент новой строки в таблицу перед строкой кнопки "Добавить"
                      tr[(num - 1) * 2 + 3 - 1].innerHTML = html;
                      html = '<tr>' +
                               '<td>&nbsp;</td>' +
                               '<td colspan="4">&nbsp;</td>' +
                             '</tr>';
                      jQuery(table).append(html);
                      jQuery(table).append('<tr>' + last_html + '</tr>');

                      // имитируем попытку изменения цены (для просчета итоговой суммы заказа)
                      Change_OrderItem_Price (null, null, id, num, '', false);

                    } else {
                      alert('Добавление новой товарной позиции отклонено, так как это превысит лимит их допустимого количества в заказе!');
                    }
                  }
                }
              }
            }

            // скрываем каталог товаров
            Switch_PageElements('catalog');

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
          }
          // -->
        </script>
      

      <!-- Адрес страницы -->
      <table align="center" cellpadding="0" cellspacing="10" class="gray">

        <!-- поле URL -->
        <tr>
          <td class="param">
            URL:
          </td>
          <td class="param_short" width="1%">
            http://сайт/orders/
          </td>
          <td class="value" width="100%" title="Окончание адреса страницы заказа">
            <input class="edit" name="code[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->code)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- флажок Скрыт -->
          <td class="param_short" title="Будет ли заказ скрыт от чужих">
            <input class="checkbox" id="item_form_hidden" name="hidden[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->hidden)&&($_smarty_tpl->tpl_vars['item']->value->hidden==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_hidden');">
              Скрыт
            </span>
          </td>

          <!-- кнопка Применить -->
          <td class="value_box" width="1%" title="Сохранить изменения и остаться на этой же странице">
            <input class="submit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_AS_ACCEPT, ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Применить">
          </td>
        </tr>

        <!-- поле IP-адрес -->
        <tr>
          <td class="param">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Banneds" title="Перейти на страницу запретов доступа в админпанели">IP-адрес</a>:
          </td>
          <td class="value" title="IP-адрес оформившего заказ">
            <input class="edit" name="ip[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->ip)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>
          <td class="value" width="100%" title="Имя хоста оформившего заказ">
            <input class="edit" name="host[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" readonly type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->host)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- ссылка Где это -->
          <td class="param_short" title="Узнать географическое местоположение компьютера с таким IP-адресом">
            <a href="http://www.ip-adress.com/ip_tracer/<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->ip)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" target="_blank">где это?</a>
          </td>

          <!-- кнопка Сохранить -->
          <td class="value_box" title="Сохранить изменения и перейти в список">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
      </table>

      
      <?php if (isset($_smarty_tpl->tpl_vars['item']->value->credit_id)&&!empty($_smarty_tpl->tpl_vars['item']->value->credit_id)&&isset($_smarty_tpl->tpl_vars['item']->value->credit_details)&&!empty($_smarty_tpl->tpl_vars['item']->value->credit_details)){?>

        <h2>
          Данные о кредите:
          <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->credit_name)===null||$tmp==='' ? "неизвестный" : $tmp), ENT_QUOTES, 'UTF-8');?>

          <span class="path">
            срок кредитования <?php echo sprintf("%d",(($tmp = @$_smarty_tpl->tpl_vars['item']->value->credit_term)===null||$tmp==='' ? 0 : $tmp));?>
 месяцев,
            процентная ставка <?php echo smarty_modifier_replace(sprintf("%1.2f",(($tmp = @$_smarty_tpl->tpl_vars['item']->value->credit_percent)===null||$tmp==='' ? 0 : $tmp)),",",".");?>
%
          </span>
        </h2>
 
        <table align="center" cellpadding="0" cellspacing="10" class="white">

          
          <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->credit_details; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
            <?php if (isset($_smarty_tpl->tpl_vars['r']->value['value'])){?>

              
              <tr>
                <td class="param" style="max-width: 33%; min-width: 33%; width: 33%;">
                  <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['label']), ENT_QUOTES, 'UTF-8');?>

                </td>

                
                <td class="value">
                  <?php if (isset($_smarty_tpl->tpl_vars['r']->value['type'])&&($_smarty_tpl->tpl_vars['r']->value['type']==@FIELDTYPE_CREDITPROGRAMS_FILE)){?>
                    <a href="<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['value'],7,'',true), 'UTF-8')!='http://'){?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']), ENT_QUOTES, 'UTF-8');?>
" target="_blank">
                      <img src="<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['value'],7,'',true), 'UTF-8')!='http://'){?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']), ENT_QUOTES, 'UTF-8');?>
" style="max-height: 200px; max-width: 200px;">
                    </a>
                  <?php }else{ ?>
                    <?php echo (($tmp = @htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']), ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '&nbsp;' : $tmp);?>

                  <?php }?>
                </td>
              </tr>

            <?php }else{ ?>

              
              <tr>
                <td class="value value_prioritydiscount" colspan="2">
                  <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['label']), ENT_QUOTES, 'UTF-8');?>

                </td>
              </tr>
            <?php }?>
          <?php } ?>

        </table>
      <?php }?>

      <!--  -->
      <?php if (isset($_smarty_tpl->tpl_vars['from_page']->value)&&($_smarty_tpl->tpl_vars['from_page']->value!='')){?>
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

      <!-- Добавляем аутентификатор операции -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
">
    </form>

    <!-- Окно выпадающего каталога товаров -->
    <div class="catalog" id="catalog">
      <div class="catalog_content">

        <span><a href="#" onclick="javascript: return Switch_PageElements('catalog');">закрыть</a></span>
        Выберите нужный товар:
        &nbsp;
        <b style="font-weight: normal;">найти по артикулу</b> <input class="search-code" type="text" value="" onkeypress="javascript: if ((event.keyCode == 13) || (event.keyCode == 10)) Search_Products_By_Code(this, this.value, 'sku-marker-');">
        <b style="font-weight: normal;">&nbsp;по коду</b> <input class="search-code" type="text" value="" onkeypress="javascript: if ((event.keyCode == 13) || (event.keyCode == 10)) Search_Products_By_Code(this, this.value, 'pcode-marker-');">
        <b style="font-weight: normal;">&nbsp;по модели</b> <input class="search-text" type="text" value="" onkeypress="javascript: if ((event.keyCode == 13) || (event.keyCode == 10)) Search_Products_By_Text(this, this.value);">

        <div class="catalog_body">
          <?php if (isset($_smarty_tpl->tpl_vars['catalog']->value)&&!empty($_smarty_tpl->tpl_vars['catalog']->value)){?>
            <?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><?php if (!function_exists('smarty_template_function_products_tree')) {
    function smarty_template_function_products_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['products_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>

              <!-- Ветка категории -->
              <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                <?php if (!isset($_smarty_tpl->tpl_vars['c']->value->products_count)||($_smarty_tpl->tpl_vars['c']->value->products_count>0)){?>
                  <ul class="categories<?php if ($_smarty_tpl->tpl_vars['level']->value>1){?> nested-item" style="display: none;<?php }?>">
                    <li title="Свернуть / развернуть категорию <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
" onclick="javascript: Switch_List_UL_Branch(this); event.cancelBubble = true; return false;"><span><?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->products_count)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
 позиций</span><span class="topic"><?php echo $_smarty_tpl->tpl_vars['number']->value;?>
.</span><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->name), ENT_QUOTES, 'UTF-8');?>
<?php $_smarty_tpl->tpl_vars["number"] = new Smarty_variable($_smarty_tpl->tpl_vars['number']->value+1, null, 0);?></li>
                    <?php if (isset($_smarty_tpl->tpl_vars['c']->value->subcategories)&&!empty($_smarty_tpl->tpl_vars['c']->value->subcategories)){?>
                      <?php smarty_template_function_products_tree($_smarty_tpl,array('cats'=>$_smarty_tpl->tpl_vars['c']->value->subcategories,'level'=>$_smarty_tpl->tpl_vars['level']->value+1,'number'=>1));?>

                    <?php }?>

                    <!-- Товары категории -->
                    <?php if (isset($_smarty_tpl->tpl_vars['c']->value->products)&&!empty($_smarty_tpl->tpl_vars['c']->value->products)){?>
                      <?php $_smarty_tpl->tpl_vars["subnumber"] = new Smarty_variable(1, null, 0);?>
                      <ul class="products nested-item" style="display: none;">
                        <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['c']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                          <?php if (isset($_smarty_tpl->tpl_vars['r']->value->variants)&&!empty($_smarty_tpl->tpl_vars['r']->value->variants)){?>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['r']->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>

                              <li <?php if (((($tmp = @$_smarty_tpl->tpl_vars['v']->value->sku)===null||$tmp==='' ? '' : $tmp)!='')||((($tmp = @$_smarty_tpl->tpl_vars['r']->value->pcode)===null||$tmp==='' ? '' : $tmp)!='')){?>class="<?php if ((($tmp = @$_smarty_tpl->tpl_vars['v']->value->sku)===null||$tmp==='' ? '' : $tmp)!=''){?>sku-marker-<?php echo htmlspecialchars(mb_strtolower($_smarty_tpl->tpl_vars['v']->value->sku, 'UTF-8'), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['r']->value->pcode)===null||$tmp==='' ? '' : $tmp)!=''){?>pcode-marker-<?php echo htmlspecialchars(mb_strtolower($_smarty_tpl->tpl_vars['r']->value->pcode, 'UTF-8'), ENT_QUOTES, 'UTF-8');?>
<?php }?>"<?php }?>><span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->stock, ENT_QUOTES, 'UTF-8');?>
 шт.</span><span class="price"><?php echo htmlspecialchars(smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['v']->value->discount_price*((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_from)===null||$tmp==='' ? 1 : $tmp))/((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->rate_to)===null||$tmp==='' ? 1 : $tmp)))),",","."), ENT_QUOTES, 'UTF-8');?>
</span><span class="topic"><?php echo $_smarty_tpl->tpl_vars['subnumber']->value;?>
.</span><a href="#" title="Выбрать товар <?php if (!isset($_smarty_tpl->tpl_vars['settings']->value->product_category_show)||($_smarty_tpl->tpl_vars['settings']->value->product_category_show==1)){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->category), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php if (!isset($_smarty_tpl->tpl_vars['settings']->value->product_brand_show)||($_smarty_tpl->tpl_vars['settings']->value->product_brand_show==1)){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->brand), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->model), ENT_QUOTES, 'UTF-8');?>
<?php if (($_smarty_tpl->tpl_vars['v']->value->name!='')&&($_smarty_tpl->tpl_vars['v']->value->name!=$_smarty_tpl->tpl_vars['r']->value->model)){?> <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['v']->value->name), ENT_QUOTES, 'UTF-8');?>
<?php }?>" onclick="javascript: return Append_ProductTableRow('item_form_add_key', this, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->product_id, ENT_QUOTES, 'UTF-8');?>
', '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['v']->value->variant_id, ENT_QUOTES, 'UTF-8');?>
');"><?php if (!isset($_smarty_tpl->tpl_vars['settings']->value->product_category_show)||($_smarty_tpl->tpl_vars['settings']->value->product_category_show==1)){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->category), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php if (!isset($_smarty_tpl->tpl_vars['settings']->value->product_brand_show)||($_smarty_tpl->tpl_vars['settings']->value->product_brand_show==1)){?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->brand), ENT_QUOTES, 'UTF-8');?>
 <?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value->model), ENT_QUOTES, 'UTF-8');?>
</a><?php if (($_smarty_tpl->tpl_vars['v']->value->name!='')&&($_smarty_tpl->tpl_vars['v']->value->name!=$_smarty_tpl->tpl_vars['r']->value->model)){?><span class="variant"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['v']->value->name), ENT_QUOTES, 'UTF-8');?>
</span><?php }?></li>

                            <?php } ?>
                            <?php $_smarty_tpl->tpl_vars["subnumber"] = new Smarty_variable($_smarty_tpl->tpl_vars['subnumber']->value+1, null, 0);?>
                          <?php }?>
                        <?php } ?>
                      </ul>
                    <?php }?>

                  </ul>
                <?php }?>
              <?php } ?>

            <?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>


            <?php smarty_template_function_products_tree($_smarty_tpl,array('cats'=>$_smarty_tpl->tpl_vars['catalog']->value,'level'=>1,'number'=>1));?>

          <?php }?>
        </div>
      </div>
    </div>

    <!-- Блок справочной информации -->
    <!-- div class="help">
      <div class="title">
        Справка
      </div>
    </div -->

  </div>
<?php }} ?>