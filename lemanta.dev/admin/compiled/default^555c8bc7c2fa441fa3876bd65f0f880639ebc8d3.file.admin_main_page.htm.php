<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:00:37
         compiled from "../admin/design/default/html/admin_main_page.htm" */ ?>
<?php /*%%SmartyHeaderCode:126734790357d5b7e5dd1ba8-57689615%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '555c8bc7c2fa441fa3876bd65f0f880639ebc8d3' => 
    array (
      0 => '../admin/design/default/html/admin_main_page.htm',
      1 => 1462406595,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126734790357d5b7e5dd1ba8-57689615',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'root_url' => 0,
    'admin_folder' => 0,
    'Token' => 0,
    'message' => 0,
    'error' => 0,
    'last_orders' => 0,
    'c' => 0,
    'settings' => 0,
    'currency' => 0,
    'inputs' => 0,
    'last_feedback' => 0,
    'last_products' => 0,
    'last_comments' => 0,
    'last_articles' => 0,
    'last_acomments' => 0,
    'last_news' => 0,
    'last_ncomments' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b7e60d01a4_18553626',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b7e60d01a4_18553626')) {function content_57d5b7e60d01a4_18553626($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.truncate.php';
?><!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"main",'main'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        Главная
      </div>
      Главная страница
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Order&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить заказ">добавить заказ</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Product&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить товар">добавить товар</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Section&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить страницу">добавить страницу</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=NewsItem&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить новость">добавить новость</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Article&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
" title="Добавить статью">добавить статью</a>
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

    <!-- Форма со списком заказов -->
    <form class="half_left" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Orders" id="orders_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Новые заказы
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Orders&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TYPE, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@TYPE_ORDERS_COMING, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CREDITABLE, ENT_QUOTES, 'UTF-8');?>
=1" style="float: right; font-size: 8pt; font-weight: normal; margin-left: 20px;">
          Новые в кредит
        </a>
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_orders']->value)&&!empty($_smarty_tpl->tpl_vars['last_orders']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->processing_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать заказ находящимся в обработке"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_order_processing<?php if ($_smarty_tpl->tpl_vars['c']->value->status!=@ORDER_STATUS_PROCESS){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Номер заказа --><span class="topic" style="display: inline;" title="Дата оформления: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->date, ENT_QUOTES, 'UTF-8');?>
">№<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->order_id, ENT_QUOTES, 'UTF-8');?>
</span><!-- Сумма --><span class="rating" title="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->total_quantity)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
 товаров, товарных позиций <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['c']->value->total_rows)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
"><?php echo smarty_modifier_replace(sprintf("%1.2f",($_smarty_tpl->tpl_vars['c']->value->total_amount*$_smarty_tpl->tpl_vars['currency']->value->rate_from/$_smarty_tpl->tpl_vars['currency']->value->rate_to)),",",".");?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8');?>
</span><!-- значок Оформляется в кредит --><?php if (($_smarty_tpl->tpl_vars['c']->value->credit_id!=0)&&($_smarty_tpl->tpl_vars['c']->value->credit_details!='')){?><img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_credit_16x16.png" title="Этот заказ оформляется в кредит"><?php }?><!-- Имя покупателя --><?php if ($_smarty_tpl->tpl_vars['c']->value->compound_name!=''){?><!-- значок заказа зарегистрированного пользователя сайта --><?php if ($_smarty_tpl->tpl_vars['c']->value->user_id!=0){?><img class="icon16x16" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_registered_16x16.png" title="Это заказ зарегистрированного пользователя сайта"><?php }?><!-- ссылка не редактирование --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
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
">Имя не указано</a><?php }?></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="orders_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="orders_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено заказов.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком переписки -->
    <form class="half_right" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Feedback" id="feedback_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавние сообщения
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_feedback']->value)&&!empty($_smarty_tpl->tpl_vars['last_feedback']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_feedback']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->new_get, ENT_QUOTES, 'UTF-8');?>
" title="Считать / не считать прочитанным"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_new<?php if ($_smarty_tpl->tpl_vars['c']->value->new!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Дата --><span class="topic" style="display: inline;" title="Дата сообщения"><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>нет даты<?php }?></span><!-- Текст --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->message), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->message), ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="feedback_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="feedback_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено сообщений.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком товаров -->
    <form class="half_left" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Products" id="products_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавно измененные товары
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_products']->value)&&!empty($_smarty_tpl->tpl_vars['last_products']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Количество просмотров --><span class="browsed<?php if ($_smarty_tpl->tpl_vars['c']->value->browsed==0){?> zero<?php }?>" title="Количество просмотров: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
</span><!-- Название --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
"<?php if (!empty($_smarty_tpl->tpl_vars['c']->value->pcode)){?> title="Буквенный код: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->pcode, ENT_QUOTES, 'UTF-8');?>
"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->model, ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="products_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="products_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено товаров.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком отзывов о товарах -->
    <form class="half_right" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Comments" id="comments_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавние отзывы о товарах
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_comments']->value)&&!empty($_smarty_tpl->tpl_vars['last_comments']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_comments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Дата --><span class="topic" style="display: inline;" title="Дата отзыва"><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>нет даты<?php }?></span><!-- Текст --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="comments_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="comments_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено отзывов.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком статей -->
    <form class="half_left" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Articles" id="articles_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавние статьи
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_articles']->value)&&!empty($_smarty_tpl->tpl_vars['last_articles']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_articles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Дата --><span class="topic" style="display: inline;" title="Дата статьи"><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>нет даты<?php }?></span><!-- Количество просмотров --><span class="browsed<?php if ($_smarty_tpl->tpl_vars['c']->value->browsed==0){?> zero<?php }?>" title="Количество просмотров: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
</span><!-- Заголовок --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->header, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->header, ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="articles_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="articles_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено статей.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком комментариев к статьям -->
    <form class="half_right" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=AComments" id="acomments_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавние комментарии к статьям
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_acomments']->value)&&!empty($_smarty_tpl->tpl_vars['last_acomments']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_acomments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Дата --><span class="topic" style="display: inline;" title="Дата комментария"><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>нет даты<?php }?></span><!-- Текст --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="acomments_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="acomments_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено комментариев.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком новостей -->
    <form class="half_left" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=News" id="news_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавние новости
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_news']->value)&&!empty($_smarty_tpl->tpl_vars['last_news']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_news']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Дата --><span class="topic" style="display: inline;" title="Дата новости"><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>нет даты<?php }?></span><!-- Количество просмотров --><span class="browsed<?php if ($_smarty_tpl->tpl_vars['c']->value->browsed==0){?> zero<?php }?>" title="Количество просмотров: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->browsed, ENT_QUOTES, 'UTF-8');?>
</span><!-- Заголовок --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->header, ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->header, ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="news_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="news_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено новостей.
        </div>
      <?php }?>
    </form>

    <!-- Форма со списком комментариев к новостям -->
    <form class="half_right" action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=NComments" id="ncomments_items_form" method="post" onkeypress="javascript: return Ignore_KeypressSubmit(event);">

      <div class="title">
        Недавние комментарии к новостям
      </div>

      <?php if (isset($_smarty_tpl->tpl_vars['last_ncomments']->value)&&!empty($_smarty_tpl->tpl_vars['last_ncomments']->value)){?>

        <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['last_ncomments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
          <li class="flatlist"><div class="onerow"><!-- Микро кнопки --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->enable_get, ENT_QUOTES, 'UTF-8');?>
" title="Разрешить / запретить показ на сайте"><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/icon_enabled<?php if ($_smarty_tpl->tpl_vars['c']->value->enabled!=1){?>_off<?php }?>_16x16.png"></a><img class="microkey_left" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/design/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->admin_theme, ENT_QUOTES, 'UTF-8');?>
/images/placeholder.gif"><!-- Дата --><span class="topic" style="display: inline;" title="Дата комментария"><?php if (smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true)!="0000-00-00"){?><?php echo htmlspecialchars(smarty_modifier_truncate($_smarty_tpl->tpl_vars['c']->value->date,10,'',true), ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?>нет даты<?php }?></span><!-- Текст --><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->edit_get, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['c']->value->comment), ENT_QUOTES, 'UTF-8');?>
</a></div></li>
        <?php } ?>

        <!-- Добавляем пустой указатель требуемой команды -->
        <input id="ncomments_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

        <!-- Добавляем признак отмены постинга -->
        <input id="ncomments_items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем признак мини постинга (без некоторых полей записи) -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_POST_MINI, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="1">

        <!-- Добавляем аутентификатор операции -->
        <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">

      <?php }else{ ?>
        <div class="noitems">
          Не найдено комментариев.
        </div>
      <?php }?>
    </form>

  </div>
<?php }} ?>