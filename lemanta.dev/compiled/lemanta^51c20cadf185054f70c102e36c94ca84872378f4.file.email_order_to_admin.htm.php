<?php /* Smarty version Smarty-3.1.8, created on 2016-09-19 11:11:34
         compiled from "admin/design/default/html/email_order_to_admin.htm" */ ?>
<?php /*%%SmartyHeaderCode:36660864057df9db6be39c2-73728794%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '51c20cadf185054f70c102e36c94ca84872378f4' => 
    array (
      0 => 'admin/design/default/html/email_order_to_admin.htm',
      1 => 1462406626,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '36660864057df9db6be39c2-73728794',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'for_user' => 0,
    'root_url' => 0,
    'admin_folder' => 0,
    'post' => 0,
    'currency' => 0,
    'r' => 0,
    'quantity' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57df9db6d986e9_06107517',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57df9db6d986e9_06107517')) {function content_57df9db6d986e9_06107517($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
?>

  
    <style>

      /* Вид заголовка письма */
      h1       {border:           0px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        13pt;
                font-weight:      bold;
                margin:           10px;
                padding:          0px;
                text-align:       left;
                text-indent:      0px;}

      /* Вид строки текста в письме */
      p        {border:           0px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        10pt;
                font-weight:      normal;
                margin:           10px;
                padding:          0px;
                text-align:       left;
                text-indent:      0px;}

      /* Вид справочной части текста в письме */
      span     {border:           0px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        8pt;
                font-weight:      normal;
                margin:           0px;
                padding:          0px;}

      /* Вид ссылок в письме */
      a        {color:           #0080FF;
                text-decoration: none;}

      /* Вид ссылок при наведении мышки */
      a:hover  {color:           #C00000;
                text-decoration: underline;}

      /* Вид таблицы в письме */
      table    {border:        #E0E0E0 3px solid;
                border-right:  #E0E0E0 2px solid;
                border-bottom: #E0E0E0 2px solid;
                color:         #000000;
                font-family:   Verdana, Tahoma, Arial;
                font-size:     10pt;
                font-weight:   normal;
                margin:        10px;
                max-width:     750px;
                padding:       0px;
                width:         750px;}

      /* Вид заголовочных ячеек таблицы (это ячейки слева) */
      td       {background-color: #F0F0F0;
                border:           #E0E0E0 0px solid;
                border-right:     #E0E0E0 1px solid;
                border-bottom:    #E0E0E0 1px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        10pt;
                font-weight:      normal;
                margin:           0px;
                padding:          10px;
                text-align:       left;
                vertical-align:   top;
                width:            100px;}

      /* Вид титульных ячеек таблицы (это ячейки сверху) */
      td.title {background-color: #E8E8E8;
                border:           #E0E0E0 0px solid;
                border-right:     #E0E0E0 1px solid;
                border-bottom:    #E0E0E0 1px solid;
                color:            #808080;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        8pt;
                font-weight:      normal;
                margin:           0px;
                padding:          5px 10px;
                text-align:       center;
                vertical-align:   middle;
                white-space:      nowrap;
                width:            100px;}

      /* Вид информационных ячеек таблицы (это ячейки справа) */
      td.info  {background-color: #FFFFFF;
                border:           #E0E0E0 0px solid;
                border-right:     #E0E0E0 1px solid;
                border-bottom:    #E0E0E0 1px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        10pt;
                font-weight:      normal;
                margin:           0px;
                padding:          10px;
                text-align:       left;
                vertical-align:   top;
                width:            100%;}

      /* Вид списочных ячеек таблицы (это ячейки слева) */
      td.item  {background-color: #F0F0F0;
                border:           #E0E0E0 0px solid;
                border-right:     #E0E0E0 1px solid;
                border-bottom:    #E0E0E0 1px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        10pt;
                font-weight:      normal;
                margin:           0px;
                padding:          10px;
                text-align:       left;
                vertical-align:   top;
                width:            100%;}

      /* Вид количественных ячеек таблицы (это ячейки справа) */
      td.sum   {background-color: #FFFFFF;
                border:           #E0E0E0 0px solid;
                border-right:     #E0E0E0 1px solid;
                border-bottom:    #E0E0E0 1px solid;
                color:            #000000;
                font-family:      Verdana, Tahoma, Arial;
                font-size:        10pt;
                font-weight:      normal;
                margin:           0px;
                padding:          10px;
                text-align:       right;
                vertical-align:   top;
                white-space:      nowrap;
                width:            auto;}

      /* цветовые классы */
      .red     {color: #FF0000;}
      .green   {color: #00A000;}
      .orange  {color: #FF8000;}
      .silver  {color: #C0C0C0;}

      /* размерные классы */
      .stdtext   {font-size: 10pt;}
      .one-third {width:     33%;}
      .two-third {width:     66%;}
    </style>
  

  <!-- Выводим заголовок -->
  <h1>

    
    <?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?>
      <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Order&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->order_id, ENT_QUOTES, 'UTF-8');?>
" target="_blank" title="Перейти на страницу заказа в админпанели">Заказ №<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->order_id, ENT_QUOTES, 'UTF-8');?>
</a>

    <?php }else{ ?>
      Заказ №<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->order_id, ENT_QUOTES, 'UTF-8');?>

    <?php }?>
    на сумму <?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['post']->value->total_amount*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>

  </h1>

  <!-- Выводим информационную таблицу -->
  <table border="0" cellpadding="0" cellspacing="0">

    <!-- поле Имя покупателя -->
    <?php if (isset($_smarty_tpl->tpl_vars['post']->value->compound_name)&&($_smarty_tpl->tpl_vars['post']->value->compound_name!='')){?>
      <tr>
        <td>
          Имя:
        </td>
        <td class="info">

          
          <?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?>
            <?php if (isset($_smarty_tpl->tpl_vars['post']->value->user_id)&&!empty($_smarty_tpl->tpl_vars['post']->value->user_id)){?>
              <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Orders&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCH, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@SEARCH_ORDERS_COMMAND_USER_ID, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->user_id, ENT_QUOTES, 'UTF-8');?>
" target="_blank" title="Перейти на страницу всех заказов этого зарегистрированного пользователя в админпанели"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->compound_name, ENT_QUOTES, 'UTF-8');?>
</a>

            <?php }else{ ?>
              <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->compound_name, ENT_QUOTES, 'UTF-8');?>

            <?php }?>

          <?php }else{ ?>
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->compound_name, ENT_QUOTES, 'UTF-8');?>

          <?php }?>
        </td>
      </tr>
    <?php }?>

    <!-- поле Емейл покупателя -->
    <?php if ((isset($_smarty_tpl->tpl_vars['post']->value->email)&&($_smarty_tpl->tpl_vars['post']->value->email!=''))||(isset($_smarty_tpl->tpl_vars['post']->value->email2)&&($_smarty_tpl->tpl_vars['post']->value->email2!=''))){?>
      <tr>
        <td>
          Емейл:
        </td>
        <td class="info">
          <?php if (isset($_smarty_tpl->tpl_vars['post']->value->email)&&($_smarty_tpl->tpl_vars['post']->value->email!='')){?><?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?><a href="mailto:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->email, ENT_QUOTES, 'UTF-8');?>
" title="Написать письмо этому пользователю"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->email, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->email, ENT_QUOTES, 'UTF-8');?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['post']->value->email2)&&($_smarty_tpl->tpl_vars['post']->value->email2!='')){?><br><?php }?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['post']->value->email2)&&($_smarty_tpl->tpl_vars['post']->value->email2!='')){?><?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?><a href="mailto:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->email2, ENT_QUOTES, 'UTF-8');?>
" title="Написать письмо этому пользователю"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->email2, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->email2, ENT_QUOTES, 'UTF-8');?>
<?php }?><?php }?>
        </td>
      </tr>
    <?php }?>

    <!-- поле Телефон покупателя -->
    <?php if ((isset($_smarty_tpl->tpl_vars['post']->value->phone)&&($_smarty_tpl->tpl_vars['post']->value->phone!=''))||(isset($_smarty_tpl->tpl_vars['post']->value->phone2)&&($_smarty_tpl->tpl_vars['post']->value->phone2!=''))){?>
      <tr>
        <td>
          Телефон:
        </td>
        <td class="info">
          <?php if (isset($_smarty_tpl->tpl_vars['post']->value->phone)&&($_smarty_tpl->tpl_vars['post']->value->phone!='')){?>
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->phone, ENT_QUOTES, 'UTF-8');?>

            <?php if (isset($_smarty_tpl->tpl_vars['post']->value->phone2)&&($_smarty_tpl->tpl_vars['post']->value->phone2!='')){?><br><?php }?>
          <?php }?>
          <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->phone2, ENT_QUOTES, 'UTF-8');?>

        </td>
      </tr>
    <?php }?>

    <!-- поле ICQ покупателя -->
    <?php if ((isset($_smarty_tpl->tpl_vars['post']->value->icq)&&($_smarty_tpl->tpl_vars['post']->value->icq!=''))||(isset($_smarty_tpl->tpl_vars['post']->value->icq2)&&($_smarty_tpl->tpl_vars['post']->value->icq2!=''))){?>
      <tr>
        <td>
          Номер ICQ:
        </td>
        <td class="info">
          <?php if (isset($_smarty_tpl->tpl_vars['post']->value->icq)&&($_smarty_tpl->tpl_vars['post']->value->icq!='')){?>
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->icq, ENT_QUOTES, 'UTF-8');?>

            <?php if (isset($_smarty_tpl->tpl_vars['post']->value->icq2)&&($_smarty_tpl->tpl_vars['post']->value->icq2!='')){?><br><?php }?>
          <?php }?>
          <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->icq2, ENT_QUOTES, 'UTF-8');?>

        </td>
      </tr>
    <?php }?>

    <!-- поле Skype покупателя -->
    <?php if ((isset($_smarty_tpl->tpl_vars['post']->value->skype)&&($_smarty_tpl->tpl_vars['post']->value->skype!=''))||(isset($_smarty_tpl->tpl_vars['post']->value->skype2)&&($_smarty_tpl->tpl_vars['post']->value->skype2!=''))){?>
      <tr>
        <td>
          Skype имя:
        </td>
        <td class="info">
          <?php if (isset($_smarty_tpl->tpl_vars['post']->value->skype)&&($_smarty_tpl->tpl_vars['post']->value->skype!='')){?>
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->skype, ENT_QUOTES, 'UTF-8');?>

            <?php if (isset($_smarty_tpl->tpl_vars['post']->value->skype2)&&($_smarty_tpl->tpl_vars['post']->value->skype2!='')){?><br><?php }?>
          <?php }?>
          <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->skype2, ENT_QUOTES, 'UTF-8');?>

        </td>
      </tr>
    <?php }?>



    <!-- поле Адрес доставки -->
    <?php if ((isset($_smarty_tpl->tpl_vars['post']->value->compound_address)&&($_smarty_tpl->tpl_vars['post']->value->compound_address!=''))||(isset($_smarty_tpl->tpl_vars['post']->value->compound_address2)&&($_smarty_tpl->tpl_vars['post']->value->compound_address2!=''))){?>
      <tr>
        <td>
          Адрес доставки:
        </td>
        <td class="info">
          <?php if (isset($_smarty_tpl->tpl_vars['post']->value->compound_address)&&($_smarty_tpl->tpl_vars['post']->value->compound_address!='')){?>
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->compound_address, ENT_QUOTES, 'UTF-8');?>

            <?php if (isset($_smarty_tpl->tpl_vars['post']->value->compound_address2)&&($_smarty_tpl->tpl_vars['post']->value->compound_address2!='')){?><br><br><?php }?>
          <?php }?>
          <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->compound_address2, ENT_QUOTES, 'UTF-8');?>

        </td>
      </tr>
    <?php }?>



    <!-- поле Комментарий -->
    <?php if (isset($_smarty_tpl->tpl_vars['post']->value->comment)&&($_smarty_tpl->tpl_vars['post']->value->comment!='')){?>
      <tr>
        <td>
          Комментарий:
        </td>
        <td class="info">
          <?php echo nl2br(htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['post']->value->comment), ENT_QUOTES, 'UTF-8'));?>

        </td>
      </tr>
    <?php }?>



    <!-- поле Дата -->
    <?php if (isset($_smarty_tpl->tpl_vars['post']->value->date)){?>
      <tr>
        <td>
          Дата заказа:
        </td>
        <td class="info">
          <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->date, ENT_QUOTES, 'UTF-8');?>

        </td>
      </tr>
    <?php }?>



    <!-- поле Состояние -->
    <tr>
      <td>
        Состояние:
      </td>
      <td class="info">

        
        <span class="silver" style="float: right;">
          Состояние заказа можно 
          <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/order/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->code, ENT_QUOTES, 'UTF-8');?>
" target="_blank" title="Перети на страницу заказа в клиентской части сайта">проверить здесь</a>.
        </span>

        
        <?php if ($_smarty_tpl->tpl_vars['post']->value->status==@ORDER_STATUS_NEW){?>
          ждет обработки
        <?php }elseif($_smarty_tpl->tpl_vars['post']->value->status==@ORDER_STATUS_PROCESS){?>
          в обработке
        <?php }elseif($_smarty_tpl->tpl_vars['post']->value->status==@ORDER_STATUS_DONE){?>
          <span class="green stdtext">выполнен</span>
        <?php }elseif($_smarty_tpl->tpl_vars['post']->value->status==@ORDER_STATUS_CANCEL){?>
          <span class="red stdtext">аннулирован</span>
        <?php }?>

        <?php if (isset($_smarty_tpl->tpl_vars['post']->value->orders_phase)&&($_smarty_tpl->tpl_vars['post']->value->orders_phase!='')){?> → <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->orders_phase, ENT_QUOTES, 'UTF-8');?>
<?php }?>
      </td>
    </tr>



    <!-- поле Состояние оплаты -->
    <tr>
      <td>
        Оплата:
      </td>
      <td class="info">
        <?php if ($_smarty_tpl->tpl_vars['post']->value->payment_status==1){?>
          <span class="green stdtext">оплачен&nbsp; <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->payment_date, ENT_QUOTES, 'UTF-8');?>
</span>
        <?php }else{ ?>
          <span class="red stdtext">не оплачен</span>
        <?php }?>
      </td>
    </tr>



    
    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['post']->value->payment_method)===null||$tmp==='' ? '' : $tmp)!=''){?>
        <tr>
            <td>
                Способ оплаты:
            </td>
            <td class="info">
                <?php echo $_smarty_tpl->tpl_vars['post']->value->payment_method;?>

            </td>
        </tr>
    <?php }?>

  </table>



  <!-- Выводим информационную таблицу -->
  <table border="0" cellpadding="0" cellspacing="0">

    <!-- Шапка таблицы -->
    <tr>
      <td class="title">
        товар
      </td>
      <td class="title">
        кол-во
      </td>
      <td class="title">
        цена
      </td>
      <td class="title">
        скидка
      </td>
      <td class="title">
        сумма
      </td>
    </tr>

    
    <?php if (isset($_smarty_tpl->tpl_vars['post']->value->products)&&!empty($_smarty_tpl->tpl_vars['post']->value->products)){?>
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['post']->value->products; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>

        
        <tr>
          <td class="item">
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->product_name, ENT_QUOTES, 'UTF-8');?>

            <?php if (($_smarty_tpl->tpl_vars['r']->value->variant_name!='')&&($_smarty_tpl->tpl_vars['r']->value->variant_name!=$_smarty_tpl->tpl_vars['r']->value->product_name)){?>
              <span class="green"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->variant_name, ENT_QUOTES, 'UTF-8');?>
</span>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['r']->value->name_properties!=''){?>
              <span class="orange"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->name_properties, ENT_QUOTES, 'UTF-8');?>
</span>
            <?php }?>
            <br>

            
            <?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?>
              <?php if ($_smarty_tpl->tpl_vars['r']->value->url!=''){?>
                <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php if ($_smarty_tpl->tpl_vars['r']->value->url_special!=1){?>products/<?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->url, ENT_QUOTES, 'UTF-8');?>
" target="_blank" style="font-size: 8pt;" title="Перейти на страницу товара в клиентской части сайта">смотреть</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Product&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value->product_id, ENT_QUOTES, 'UTF-8');?>
" target="_blank" style="font-size: 8pt;" title="Перейти на страницу товара в админпанели">редактировать</a>
              <?php }else{ ?>
                <span class="red">такого товара уже нет в базе сайта</span>
              <?php }?>
            <?php }?>
          </td>

          
          <?php $_smarty_tpl->tpl_vars["quantity"] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value->quantity, null, 0);?>
          <?php if ($_smarty_tpl->tpl_vars['r']->value->quantity<0){?>
            <?php $_smarty_tpl->tpl_vars["quantity"] = new Smarty_variable($_smarty_tpl->tpl_vars['r']->value->quantity*-1, null, 0);?>
          <?php }?>
          <td class="sum">
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['quantity']->value, ENT_QUOTES, 'UTF-8');?>
 шт.
          </td>

          
          <td class="sum">
            <?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['r']->value->real_price*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>


            
            <?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?>
              <br><span class="silver"><?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['r']->value->real_price*$_smarty_tpl->tpl_vars['quantity']->value*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span>
            <?php }?>
          </td>

          
          <td class="sum" title="Величина скидки">
            <?php if (smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['r']->value->discount),',','.')!='0.00'){?>
              -<?php echo smarty_modifier_replace(sprintf("%1.2f",$_smarty_tpl->tpl_vars['r']->value->discount),",",".");?>
%
              <!-- административные сведения -->
              <?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?>
                <br><span class="silver">-<?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['r']->value->real_price*$_smarty_tpl->tpl_vars['quantity']->value*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to-$_smarty_tpl->tpl_vars['r']->value->price*$_smarty_tpl->tpl_vars['quantity']->value*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span>
              <?php }?>
            <?php }else{ ?>
              &nbsp;
            <?php }?>
          </td>

          
          <td class="sum">
            <?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['r']->value->price*$_smarty_tpl->tpl_vars['quantity']->value*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>

          </td>
        </tr>
      <?php } ?>
    <?php }?>

    <!-- Способ доставки -->
    <tr>
      <td class="item">
        <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['post']->value->delivery_method)===null||$tmp==='' ? "способ доставки не указан" : $tmp), ENT_QUOTES, 'UTF-8');?>

      </td>
      <td class="sum" colspan="3">
        &nbsp;
      </td>
      <td class="sum">
        <?php if ($_smarty_tpl->tpl_vars['post']->value->delivery_price>0){?>
          <?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['post']->value->delivery_price*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>

        <?php }else{ ?>
          бесплатно
        <?php }?>
      </td>
    </tr>

    <!-- Дополнительная скидка -->
    <tr>
      <td class="item">
        Дополнительная скидка:
      </td>
      <td class="sum" colspan="3">
        &nbsp;
      </td>
      <td class="sum">
        <?php if (smarty_modifier_replace(sprintf('%1.2f',$_smarty_tpl->tpl_vars['post']->value->discount_sum),',','.')!='0.00'){?>
          -<?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['post']->value->discount_sum*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>

        <?php }else{ ?>
          нет
        <?php }?>
      </td>
    </tr>

    
    <?php if (!isset($_smarty_tpl->tpl_vars['for_user']->value)||($_smarty_tpl->tpl_vars['for_user']->value!==true)){?>
      <!-- Фактическая скидка -->
      <tr>
        <td class="title" colspan="3" style="text-align: right;">
          Фактическая скидка по заказу:
        </td>
        <td class="sum">
          -<?php echo smarty_modifier_replace(sprintf("%1.2f",$_smarty_tpl->tpl_vars['post']->value->discount),",",".");?>
%
        </td>
        <td class="sum">
          &nbsp;
        </td>
      </tr>
    <?php }?>

  </table>

  
  <?php if (isset($_smarty_tpl->tpl_vars['post']->value->credit_id)&&!empty($_smarty_tpl->tpl_vars['post']->value->credit_id)&&isset($_smarty_tpl->tpl_vars['post']->value->credit_details)&&!empty($_smarty_tpl->tpl_vars['post']->value->credit_details)){?>

    <h1>
      Данные о кредите:
      <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['post']->value->credit_name)===null||$tmp==='' ? "неизвестный" : $tmp), ENT_QUOTES, 'UTF-8');?>
 &nbsp;
      <span>
        срок кредитования <?php echo sprintf("%d",(($tmp = @$_smarty_tpl->tpl_vars['post']->value->credit_term)===null||$tmp==='' ? 0 : $tmp));?>
 месяцев,
        процентная ставка <?php echo smarty_modifier_replace(sprintf("%1.2f",(($tmp = @$_smarty_tpl->tpl_vars['post']->value->credit_percent)===null||$tmp==='' ? 0 : $tmp)),",",".");?>
%
      </span>
    </h1>

    <table border="0" cellpadding="0" cellspacing="0">

      
      <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['post']->value->credit_details; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
        <?php if (isset($_smarty_tpl->tpl_vars['r']->value['value'])){?>
          <?php if (preg_replace('!\s+!u', ' ',preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']))!=''){?>

            
            <tr>
              <td class="one-third">
                <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['label']), ENT_QUOTES, 'UTF-8');?>

              </td>

              
              <td class="info two-third">
                <?php if (isset($_smarty_tpl->tpl_vars['r']->value['type'])&&($_smarty_tpl->tpl_vars['r']->value['type']==@FIELDTYPE_CREDITPROGRAMS_FILE)){?>
                  <a href="<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['value'],7,'',true), 'UTF-8')!='http://'){?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']), ENT_QUOTES, 'UTF-8');?>
" target="_blank">
                    <img src="<?php if (mb_strtolower(smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['value'],7,'',true), 'UTF-8')!='http://'){?>http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php }?><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']), ENT_QUOTES, 'UTF-8');?>
" style="max-width: 400px;">
                  </a>
                <?php }elseif(isset($_smarty_tpl->tpl_vars['r']->value['type'])&&($_smarty_tpl->tpl_vars['r']->value['type']==@FIELDTYPE_CREDITPROGRAMS_URL)){?>
                  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['value'], ENT_QUOTES, 'UTF-8');?>
" target="_blank">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['value'], ENT_QUOTES, 'UTF-8');?>

                  </a>
                <?php }elseif(isset($_smarty_tpl->tpl_vars['r']->value['type'])&&($_smarty_tpl->tpl_vars['r']->value['type']==@FIELDTYPE_CREDITPROGRAMS_EMAIL)){?>
                  <a href="mailto:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['value'], ENT_QUOTES, 'UTF-8');?>
">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['r']->value['value'], ENT_QUOTES, 'UTF-8');?>

                  </a>
                <?php }else{ ?>
                  <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['value']), ENT_QUOTES, 'UTF-8');?>

                <?php }?>
              </td>
            </tr>

          <?php }?>
        <?php }else{ ?>

          
          <tr>
            <td class="title" colspan="2">
              <?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['r']->value['label']), ENT_QUOTES, 'UTF-8');?>

            </td>
          </tr>
        <?php }?>
      <?php } ?>

    </table>
  <?php }?>

  
  <br>
  <p>
    Это письмо поступило с сайта
    <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/" target="_blank" title="Перейти на главную страницу сайта"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
</a>
    <?php if (isset($_smarty_tpl->tpl_vars['post']->value->now)){?>
      &nbsp;<span class="stdtext"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value->now, ENT_QUOTES, 'UTF-8');?>
</span>
    <?php }?>
  </p>
<?php }} ?>