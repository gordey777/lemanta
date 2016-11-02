<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:12
         compiled from "/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/submenu.htm" */ ?>
<?php /*%%SmartyHeaderCode:200303060357d5b6a04b7761-08280752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28b07da93354f49019bb09cc18a78a7b17d98635' => 
    array (
      0 => '/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/submenu.htm',
      1 => 1462406574,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200303060357d5b6a04b7761-08280752',
  'function' => 
  array (
    'check_admin_rights_link' => 
    array (
      'parameter' => 
      array (
        'module' => '',
      ),
      'compiled' => '',
    ),
    'check_select_class' => 
    array (
      'parameter' => 
      array (
        'button' => '',
      ),
      'compiled' => '',
    ),
    'submenu_card_button' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
    'submenu_button' => 
    array (
      'parameter' => 
      array (
        'button' => '',
        'module' => '',
        'text' => '',
        'have_card' => false,
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'admin_rights' => 0,
    'module' => 0,
    'select' => 0,
    'button' => 0,
    '($_smarty_tpl->tpl_vars[\'button\']->value)' => 0,
    'temp_url_script' => 0,
    'text' => 0,
    'have_card' => 0,
    '((\'card_\').($_smarty_tpl->tpl_vars[\'button\']->value))' => 0,
    'site' => 0,
    'admin_folder' => 0,
    'temp_url_main' => 0,
    'main' => 0,
    'config' => 0,
    'payments' => 0,
    'payment' => 0,
    'card_payments' => 0,
    'card_payment' => 0,
    'me' => 0,
    'me_pointer' => 0,
    'k' => 0,
    'r' => 0,
    'card' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a05ad4d7_61105953',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a05ad4d7_61105953')) {function content_57d5b6a05ad4d7_61105953($_smarty_tpl) {?><?php if (!function_exists('smarty_template_function_check_admin_rights_link')) {
    function smarty_template_function_check_admin_rights_link($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['check_admin_rights_link']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (isset($_smarty_tpl->tpl_vars['admin_rights']->value)&&is_array($_smarty_tpl->tpl_vars['admin_rights']->value)&&!empty($_smarty_tpl->tpl_vars['admin_rights']->value)&&!in_array(mb_strtolower($_smarty_tpl->tpl_vars['module']->value, 'UTF-8'),$_smarty_tpl->tpl_vars['admin_rights']->value)){?>style="color: #bbb;"<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_check_select_class')) {
    function smarty_template_function_check_select_class($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['check_select_class']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (mb_strtolower(((($tmp = @$_smarty_tpl->tpl_vars['select']->value)===null||$tmp==='' ? '' : $tmp)), 'UTF-8')==mb_strtolower($_smarty_tpl->tpl_vars['button']->value, 'UTF-8')){?>class="select"<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_submenu_card_button')) {
    function smarty_template_function_submenu_card_button($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['submenu_card_button']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><li <?php smarty_template_function_check_select_class($_smarty_tpl,array('button'=>"card"));?>
>карточка</li><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php if (!function_exists('smarty_template_function_submenu_button')) {
    function smarty_template_function_submenu_button($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['submenu_button']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (($_smarty_tpl->tpl_vars['button']->value=='me')||((($tmp = @$_smarty_tpl->tpl_vars[($_smarty_tpl->tpl_vars['button']->value)]->value)===null||$tmp==='' ? false : $tmp)===true)){?><li <?php smarty_template_function_check_select_class($_smarty_tpl,array('button'=>$_smarty_tpl->tpl_vars['button']->value));?>
><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value, ENT_QUOTES, 'UTF-8');?>
" <?php smarty_template_function_check_admin_rights_link($_smarty_tpl,array('module'=>$_smarty_tpl->tpl_vars['module']->value));?>
><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</a></li><?php if ($_smarty_tpl->tpl_vars['have_card']->value){?><?php if ((($tmp = @$_smarty_tpl->tpl_vars[(('card_').($_smarty_tpl->tpl_vars['button']->value))]->value)===null||$tmp==='' ? false : $tmp)===true){?><?php smarty_template_function_submenu_card_button($_smarty_tpl,array());?>
<?php }?><?php }?><?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>
<?php $_smarty_tpl->tpl_vars['temp_url_main'] = new Smarty_variable(((((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp))).(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)))).('/'), null, 0);?><?php $_smarty_tpl->tpl_vars['temp_url_script'] = new Smarty_variable(htmlspecialchars((((($_smarty_tpl->tpl_vars['temp_url_main']->value).('index.php?')).(((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp)))).('=')), ENT_QUOTES, 'UTF-8'), null, 0);?><div class="submenu"><?php if ((($tmp = @$_smarty_tpl->tpl_vars['main']->value)===null||$tmp==='' ? false : $tmp)===true){?><li <?php smarty_template_function_check_select_class($_smarty_tpl,array('button'=>"main"));?>
><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['temp_url_main']->value, ENT_QUOTES, 'UTF-8');?>
" <?php smarty_template_function_check_admin_rights_link($_smarty_tpl,array('module'=>"MainPage"));?>
>главная</a></li><?php }?><?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'pages','module'=>'Sections','text'=>'страницы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'news','module'=>'News','text'=>'новости','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'articles','module'=>'Articles','text'=>'статьи','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'banners','module'=>'Banners','text'=>'баннеры','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'files','module'=>'Files','text'=>'файлы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'menus','module'=>'Menus','text'=>'меню','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'modules','module'=>'Modules','text'=>'модули','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'products','module'=>'Products','text'=>'товары','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'products_kits','module'=>'ProductsKits','text'=>'комплекты','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'categories','module'=>'Categories','text'=>'категории','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'brands','module'=>'Brands','text'=>'бренды','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'properties','module'=>'Properties','text'=>'свойства','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'stocks','module'=>'Stocks','text'=>'склады','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'orders','module'=>'Orders','text'=>'заказы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'orders_phases','module'=>'OrdersPhases','text'=>'стадии','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'payments_history','module'=>'PaymentsHistory','text'=>'платежи','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'credit_programs','module'=>'CreditPrograms','text'=>'кредиты','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'users','module'=>'Users','text'=>'клиенты','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'groups','module'=>'Groups','text'=>'группы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'banneds','module'=>'Banneds','text'=>'запреты','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'comments','module'=>'Comments','text'=>'отзывы','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'acomments','module'=>'AComments','text'=>'комментарии','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'ncomments','module'=>'NComments','text'=>'комментарии новостей','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'feedback','module'=>'Feedback','text'=>'переписка','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'callme','module'=>'CallMe','text'=>'позвоните','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'countries','module'=>'Countries','text'=>'страны','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'regions','module'=>'Regions','text'=>'области','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'towns','module'=>'Towns','text'=>'города','have_card'=>true));?>
<?php if (!isset($_smarty_tpl->tpl_vars['config']->value->smsDnevnik_disabled)||!$_smarty_tpl->tpl_vars['config']->value->smsDnevnik_disabled){?><?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'schools','module'=>'Schools','text'=>'школы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'schools_types','module'=>'SchoolsTypes','text'=>'типы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'schools_lessons','module'=>'SchoolsLessons','text'=>'предметы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'schools_classes','module'=>'SchoolsClasses','text'=>'классы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'schools_learners','module'=>'SchoolsLearners','text'=>'учащиеся','have_card'=>true));?>
<?php }?><?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'imports','module'=>'Imports','text'=>'импорт','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'export','module'=>'Export','text'=>'экспорт','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'backup','module'=>'Backup','text'=>'бекап','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'redirects','module'=>'Redirects','text'=>'редиректы','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'mailer','module'=>'Mailer','text'=>'рассылка','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'setup','module'=>'Setup','text'=>'настройки','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'currencies','module'=>'Currencies','text'=>'валюты','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'deliveries','module'=>'Deliveries','text'=>'доставка','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'deliveries_types','module'=>'DeliveriesTypes','text'=>'типы','have_card'=>true));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'shippings_terms','module'=>'ShippingsTerms','text'=>'сроки','have_card'=>true));?>
<?php if (((($tmp = @$_smarty_tpl->tpl_vars['payments']->value)===null||$tmp==='' ? false : $tmp)===true)||((($tmp = @$_smarty_tpl->tpl_vars['payment']->value)===null||$tmp==='' ? false : $tmp)===true)){?><li <?php if (((($tmp = @$_smarty_tpl->tpl_vars['select']->value)===null||$tmp==='' ? '' : $tmp)=="payments")||((($tmp = @$_smarty_tpl->tpl_vars['select']->value)===null||$tmp==='' ? '' : $tmp)=="payment")){?>class="select"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['temp_url_script']->value;?>
Payments" <?php smarty_template_function_check_admin_rights_link($_smarty_tpl,array('module'=>"Payments"));?>
>оплата</a></li><?php if (((($tmp = @$_smarty_tpl->tpl_vars['card_payments']->value)===null||$tmp==='' ? false : $tmp)===true)||((($tmp = @$_smarty_tpl->tpl_vars['card_payment']->value)===null||$tmp==='' ? false : $tmp)===true)){?><?php smarty_template_function_submenu_card_button($_smarty_tpl,array());?>
<?php }?><?php }?><?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'sms','module'=>'SmsGates','text'=>'sms','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'themes','module'=>'Themes','text'=>'дизайн','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'templates','module'=>'Templates','text'=>'шаблоны','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'styles','module'=>'Styles','text'=>'стили','have_card'=>false));?>
<?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'images','module'=>'Images','text'=>'картинки','have_card'=>false));?>
<?php if (isset($_smarty_tpl->tpl_vars['me']->value)){?><?php if (is_array($_smarty_tpl->tpl_vars['me']->value)&&!empty($_smarty_tpl->tpl_vars['me']->value)||is_string($_smarty_tpl->tpl_vars['me']->value)&&($_smarty_tpl->tpl_vars['me']->value!='')){?><?php if (is_string($_smarty_tpl->tpl_vars['me']->value)){?><?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'me','module'=>(($tmp = @$_smarty_tpl->tpl_vars['me_pointer']->value)===null||$tmp==='' ? '' : $tmp),'text'=>$_smarty_tpl->tpl_vars['me']->value,'have_card'=>false));?>
<?php }else{ ?><?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['me']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['r']->key;
?><?php smarty_template_function_submenu_button($_smarty_tpl,array('button'=>'me','module'=>(($tmp = @$_smarty_tpl->tpl_vars['me_pointer']->value[$_smarty_tpl->tpl_vars['k']->value])===null||$tmp==='' ? '' : $tmp),'text'=>$_smarty_tpl->tpl_vars['r']->value,'have_card'=>false));?>
<?php break 1?><?php } ?><?php }?><?php }?><?php }?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['card']->value)===null||$tmp==='' ? false : $tmp)===true){?><?php smarty_template_function_submenu_card_button($_smarty_tpl,array());?>
<?php }?></div><?php }} ?>