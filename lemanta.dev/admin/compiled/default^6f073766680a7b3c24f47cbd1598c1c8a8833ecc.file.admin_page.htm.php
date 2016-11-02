<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 22:55:12
         compiled from "../admin/design/default/html/admin_page.htm" */ ?>
<?php /*%%SmartyHeaderCode:140058599757d5b6a05b4dd9-27285546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f073766680a7b3c24f47cbd1598c1c8a8833ecc' => 
    array (
      0 => '../admin/design/default/html/admin_page.htm',
      1 => 1462406603,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140058599757d5b6a05b4dd9-27285546',
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
    'pagemenu_link' => 
    array (
      'parameter' => 
      array (
        'module' => '',
        'text' => '',
        'params' => '',
        'a_params' => '',
      ),
      'compiled' => '',
    ),
  ),
  'variables' => 
  array (
    'site' => 0,
    'admin_folder' => 0,
    'admin_site' => 0,
    'settings' => 0,
    'admin_script' => 0,
    'param' => 0,
    'value' => 0,
    'Title' => 0,
    'admin_theme' => 0,
    'BGsound' => 0,
    'error' => 0,
    'inputs' => 0,
    'currency' => 0,
    'admin_rights' => 0,
    'module' => 0,
    'admin_goto' => 0,
    'params' => 0,
    'a_params' => 0,
    'text' => 0,
    'relogin_url' => 0,
    'logout_url' => 0,
    'url' => 0,
    'config' => 0,
    'name' => 0,
    'currencies' => 0,
    'r' => 0,
    'Body' => 0,
    'IMPERA_CMS_version' => 0,
    'root_url' => 0,
  ),
  'has_nocache_code' => 0,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5b6a084b0d6_59572225',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5b6a084b0d6_59572225')) {function content_57d5b6a084b0d6_59572225($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.regex_replace.php';
if (!is_callable('smarty_modifier_date_format')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php $_smarty_tpl->tpl_vars['site'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_folder'] = new Smarty_variable(htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['admin_folder']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_site'] = new Smarty_variable((($_smarty_tpl->tpl_vars['site']->value).($_smarty_tpl->tpl_vars['admin_folder']->value)).('/'), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_script'] = new Smarty_variable(($_smarty_tpl->tpl_vars['admin_site']->value).('index.php'), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_theme'] = new Smarty_variable(((($_smarty_tpl->tpl_vars['admin_site']->value).('design/')).((htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['settings']->value->admin_theme)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('/'), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_SECTION)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['admin_goto'] = new Smarty_variable(((($_smarty_tpl->tpl_vars['admin_script']->value).('?')).($_smarty_tpl->tpl_vars['param']->value)).('='), null, 0);?><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_USER_ACTION)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@USERACTION_REQUEST_PARAM_VALUE_LOGOUT)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['logout_url'] = new Smarty_variable((((($_smarty_tpl->tpl_vars['admin_script']->value).('?')).($_smarty_tpl->tpl_vars['param']->value)).('=')).($_smarty_tpl->tpl_vars['value']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@USERACTION_REQUEST_PARAM_VALUE_RELOGIN)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['relogin_url'] = new Smarty_variable((((($_smarty_tpl->tpl_vars['admin_script']->value).('?')).($_smarty_tpl->tpl_vars['param']->value)).('=')).($_smarty_tpl->tpl_vars['value']->value), null, 0);?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="ru" />



        <meta name="description" content="Админпанель Impera CMS" />
        <meta name="keywords" content="" />
        <meta name="robots" content="noindex,nofollow" />



        
        <title>
            <?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['Title']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>

        </title>



        
        <link href="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
css/admin_page_style.css" media="screen" rel="stylesheet" type="text/css" />



        
        <link href="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/favicon.ico" rel="icon" type="image/x-icon" />
        <link href="<?php echo $_smarty_tpl->tpl_vars['admin_theme']->value;?>
images/favicon.ico" rel="shortcut icon" type="image/x-icon" />



        
        <?php if (((($tmp = @$_smarty_tpl->tpl_vars['BGsound']->value)===null||$tmp==='' ? '' : $tmp)!='')||((($tmp = @$_smarty_tpl->tpl_vars['error']->value)===null||$tmp==='' ? '' : $tmp)!='')){?>
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['BGsound']->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
                <bgsound src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['BGsound']->value, ENT_QUOTES, 'UTF-8');?>
" />
            <?php }else{ ?>
                <bgsound src="<?php echo $_smarty_tpl->tpl_vars['admin_site']->value;?>
sounds/error.wav" />
            <?php }?>
        <?php }?>

    </head>



    
    <script src="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
js/jquery/jquery.min.js" language="JavaScript" type="text/javascript"></script>

    <link href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
js/jquery-ui/css/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
js/jquery-ui/jquery-ui.min.js" language="JavaScript" type="text/javascript"></script>



    
    <script language="JavaScript" type="text/javascript">
 
        // отклонение постинга формы по нажатию клавиши Enter
        //   event = событие нажатой клавиши

        function Ignore_KeypressSubmit (event) {

            // если событие действительно относится к нажатию клавиши
            if ((typeof(event) == 'object') && (event != null)) {
                if (('shiftKey' in event) && ('ctrlKey' in event) && ('keyCode' in event)) {

                    // может быть нажали клавишу на строке поиска или в textarea?
                    var object = ('srcElement' in event) && ('name' in event.srcElement) ? event.srcElement : null;
                    if (object == null) object = ('target' in event) && ('name' in event.target) ? event.target : null;
                    onfield = (object != null)
                              && ((object.name == '<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FILTER_SEARCH)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
')
                              || (object.name == '<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
')
                              || (object.name == '<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
')
                              || (object.name == '<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
')
                              || (object.name == '<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_FILTER_SEARCHDATETO)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
')
                              || (('tagName' in object) && (object.tagName == 'TEXTAREA')));

                    // возвращаем FALSE (отклонить), если была нажата клавиша Enter без клавиши Ctrl или Shift и не на строке поиска и не в textarea
                    return onfield || event.ctrlKey || event.shiftKey || ((event.keyCode != 13) && (event.keyCode != 10));
                }
            }

            // возвращаем TRUE (пропустить это нажатие клавиши в обработку)
            return true;
        }



        // переключение видимости элементов на странице
        //   ids = строка с перечнем идентификаторов элементов в формате id1[,id2[,id3..[,idN]]]

        function Switch_PageElements (ids) {

            // добавляем в конец строки запятую на случай, если в строке всего один идентификатор
            ids += ',';

            // инициализируем локальные переменные
            var object = null;
            var id = '';
            var i = 0;

            // движемся по строке, пропуская пробелы и пока не найдем запятую (разделяет идентификаторы)
            while (i < ids.length) {
                char = ids.substr(i, 1);
                if (char != ' ') {
                    if (char == ',') {

                        // если получен непустой идентификатор, переключить видимость такого элемента на странице
                        if (id != '') {
                            object = document.getElementById(id);
                            if ((typeof(object) == 'object') && (object != null)) {
                                if ('style' in object) {
                                    object = object.style;
                                    if ('display' in object) object.display = (object.display == 'none') ? '' : 'none';
                                }
                            }
                            id = '';
                        }
                    } else {
                        id += char;
                    }
                }
                i++;
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // включение видимости элементов на странице
        //   ids = строка с перечнем идентификаторов элементов в формате id1[,id2[,id3..[,idN]]]

        function Show_PageElements (ids) {

            // добавляем в конец строки запятую на случай, если в строке всего один идентификатор
            ids += ',';

            // инициализируем локальные переменные
            var object = null;
            var id = '';
            var i = 0;

            // движемся по строке, пропуская пробелы и пока не найдем запятую (разделяет идентификаторы)
            while (i < ids.length) {
                char = ids.substr(i, 1);
                if (char != ' ') {
                    if (char == ',') {

                        // если получен непустой идентификатор, включить видимость такого элемента на странице
                        if (id != '') {
                            object = document.getElementById(id);
                            if ((typeof(object) == 'object') && (object != null)) {
                                if ('style' in object) {
                                    object = object.style;
                                    if ('display' in object) object.display = 'block';
                                }
                            }
                            id = '';
                        }
                    } else {
                        id += char;
                    }
                }
                i++;
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // выключение видимости элементов на странице
        //   ids = строка с перечнем идентификаторов элементов в формате id1[,id2[,id3..[,idN]]]

        function Hide_PageElements (ids) {

            // добавляем в конец строки запятую на случай, если в строке всего один идентификатор
            ids += ',';

            // инициализируем локальные переменные
            var object = null;
            var id = '';
            var i = 0;

            // движемся по строке, пропуская пробелы и пока не найдем запятую (разделяет идентификаторы)
            while (i < ids.length) {
                char = ids.substr(i, 1);
                if (char != ' ') {
                    if (char == ',') {

                        // если получен непустой идентификатор, выключить видимость такого элемента на странице
                        if (id != '') {
                            object = document.getElementById(id);
                            if ((typeof(object) == 'object') && (object != null)) {
                                if ('style' in object) {
                                    object = object.style;
                                    if ('display' in object) object.display = 'none';
                                }
                            }
                            id = '';
                        }
                    } else {
                        id += char;
                    }
                }
                i++;
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительное переключение флажка на странице
        //   id = идентификатор переключаемого флажка

        function Toggle_PageCheckbox (id) {

            // находим такой флажок на странице
            var object = document.getElementById(id);
            if ((typeof(object) == 'object') && (object != null)) {

                // переключаем состояние флажка
                if ('checked' in object) {
                    object.checked = !object.checked;

                    // если у флажка есть обработчик события OnChange, выполняем его
                    if (object.onchange) object.onchange();
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительный сброс флажка на странице
        //   id = идентификатор сбрасываемого флажка

        function Reset_PageCheckbox (id) {

            // находим такой флажок на странице
            var object = document.getElementById(id);
            if ((typeof(object) == 'object') && (object != null)) {

                // сбрасываем состояние флажка
                if ('checked' in object) object.checked = false;
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительный сброс поля ввода на странице
        //   id = идентификатор сбрасываемого поля ввода

        function Reset_PageInputbox (id) {

            // находим такое поле ввода на странице
            var object = document.getElementById(id);
            if ((typeof(object) == 'object') && (object != null)) {

                // сбрасываем содержимое поля
                if ('value' in object) object.value = '';
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительный сброс выпадающего списка на странице
        //   id = идентификатор сбрасываемого выпадающего списка

        function Reset_PageCombobox (id) {

            // находим такой выпадающий список на странице
            var object = document.getElementById(id);
            if ((typeof(object) == 'object') && (object != null)) {

                // сбрасываем курсор списка
                if ('selectedIndex' in object) object.selectedIndex = 0;
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительная установка поля ввода на странице
        //   id = идентификатор устанавливаемого поля ввода
        //   value = значение поля ввода

        function Set_PageInputbox (id, value) {

            // находим такое поле ввода на странице
            var object = document.getElementById(id);
            if ((typeof(object) == 'object') && (object != null)) {

                // устанавливаем содержимое поля
                if ('value' in object) object.value = value;
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительный запуск фильтра записей на странице
        //   form_id = идентификатор формы с записями

        function Start_PageRecordsFilter (form_id) {

            // если в параметрах найден признак только ручного запуска фильтра, сразу
            // ставим в начале этой функции return для блокировки принудительного запуска
            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MANUALLY])===null||$tmp==='' ? false : $tmp)){?>
                return false;
            <?php }?>

            // находим такую форму на странице
            var object = document.getElementById(form_id);

            // постим форму на сайт
            if ((typeof(object) == 'object') && (object != null)) object.submit();

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // сброс фильтра записей на странице
        //   form_id = идентификатор формы с записями

        function Reset_PageRecordsFilter (form_id) {

            // находим такую форму на странице
            var object = document.getElementById(form_id);
            if ((typeof(object) == 'object') && (object != null)) {

                // сбрасываем флажки фильтра
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NEWEST, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ACTIONAL, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_AWAITED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_YMARKET, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_VKONTAKTE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DELETED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DONE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_COMMENTED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_FILED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTRSS, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTEXPORT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DOMAINED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ARTICLED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NEWSED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INFORMATIVE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_AUTOMATIC, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INTERFACED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_VALUABLE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PLUGIN, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_LISTED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INPRODUCT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INFILTER, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INCOMPARE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_VISIBLE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLEDEBIT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLECREDIT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOACCESS, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOREGISTER, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOCOMMENT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOCALLME, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOADMIN, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ATTEMPTED, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYSTATUS, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCheckbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CREDITABLE, ENT_QUOTES, 'UTF-8');?>
');

                // сбрасываем поля ввода фильтра
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCH, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHDATEFROM, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHDATETO, ENT_QUOTES, 'UTF-8');?>
');

                // сбрасываем выпадающие списки фильтра
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CATEGORY, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_STOCK, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_BRAND, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PARTNER, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_GROUP, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PRICEGROUP, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SECTION, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MENU, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MODULE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DELIVERY, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_PAYMENT, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_AFFILIATE, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_COUNTRY, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_REGION, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_TOWN, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SCHOOL, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_CLASS, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageCombobox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_LESSON, ENT_QUOTES, 'UTF-8');?>
');

                // запускаем фильтр записей
                Start_PageRecordsFilter(form_id);
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительный запуск фильтра записей на странице с установкой искомого текста
        //   form_id = идентификатор формы с записями
        //   text = искомый текст

        function SearchThis_PageRecordsFilter (form_id, text) {

            // находим такую форму на странице
            var object = document.getElementById(form_id);
            if ((typeof(object) == 'object') && (object != null)) {

                // сбрасываем поля ввода фильтра
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHCOSTFROM, ENT_QUOTES, 'UTF-8');?>
');
                Reset_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCHCOSTTO, ENT_QUOTES, 'UTF-8');?>
');

                // устанавливаем поле ввода фильтра
                Set_PageInputbox(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEARCH, ENT_QUOTES, 'UTF-8');?>
', text);

                // постим форму на сайт
                object.submit();
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // удаление изображения из записи на странице
        //   form_id = идентификатор формы с записью
        //   image_number = номер удаляемого изображения (* = удалить все)

        function Delete_PageRecordImage (form_id, image_number) {

            // находим такую форму на странице
            var form = document.getElementById(form_id);
            if ((typeof(form) == 'object') && (form != null)) {

                // находим элемент номера изображения и передаем в него номер удаляемого изображения
                var object = document.getElementById(form_id + '_<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
');
                if ((typeof(object) == 'object') && (object != null)) {
                    if ('value' in object) {
                        object.value = image_number;

                        // находим элемент указателя выполняемой команды и передаем в него команду "Удалить изображение"
                        object = document.getElementById(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
');
                        if ((typeof(object) == 'object') && (object != null)) {
                            if ('value' in object) {
                                object.value = '<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE, ENT_QUOTES, 'UTF-8');?>
';

                                // постим форму на сайт
                                form.submit();
                            }
                        }
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // удаление файла из записи на странице
        //   form_id = идентификатор формы с записью
        //   file_number = номер удаляемого файла (* = удалить все)

        function Delete_PageRecordFile (form_id, file_number) {

            // находим такую форму на странице
            var form = document.getElementById(form_id);
            if ((typeof(form) == 'object') && (form != null)) {

                // находим элемент номера файла и передаем в него номер удаляемого файла
                var object = document.getElementById(form_id + '_<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_FILENUMBER, ENT_QUOTES, 'UTF-8');?>
');
                if ((typeof(object) == 'object') && (object != null)) {
                    if ('value' in object) {
                        object.value = file_number;

                        // находим элемент указателя выполняемой команды и передаем в него команду "Удалить файл"
                        object = document.getElementById(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
');
                        if ((typeof(object) == 'object') && (object != null)) {
                            if ('value' in object) {
                                object.value = '<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEFILE, ENT_QUOTES, 'UTF-8');?>
';

                                // постим форму на сайт
                                form.submit();
                            }
                        }
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительный запуск массового постинга записей на странице
        //   form_id = идентификатор формы с записями

        function Start_PageMassPost (form_id) {

            // находим такую форму на странице
            var form = document.getElementById(form_id);
            if ((typeof(form) == 'object') && (form != null)) {

                // находим элемент признака отмены постинга и передаем в него 0 (снимаем отмену)
                var object = document.getElementById(form_id + '_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_IGNORE_POST, ENT_QUOTES, 'UTF-8');?>
');
                if ((typeof(object) == 'object') && (object != null)) {
                    if ('value' in object) {
                        object.value = 0;

                        // если на странице есть флажки с именами "enabled[ИДЕНТИФИКАТОР_ЗАПИСИ]",
                        // делаем их однозначно постинговыми (по стандарту форма не передает значения для снятых флажков)
                        object = document.getElementsByTagName('input');
                        if ((object != null) && ('length' in object)) {
                            for (var i = 0; i < object.length; i++) {
                                if (('name' in object[i]) && ('checked' in object[i]) && ('value' in object[i]) && (object[i].name.substr(0, 8) == 'enabled[')) {

                                    // состояние флажка передаем в его значение
                                    object[i].value = object[i].checked ? 1 : 0;

                                    // а сам флажок считаем помеченным
                                    if (('style' in object[i]) && ('display' in object[i].style)) object[i].style.display = 'none';
                                    object[i].checked = true;
                                }
                            }
                        }

                        // постим форму на сайт
                        form.submit();
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        
        

        function Prepare_PageThisOnePost (form_id) {

            
            var form = document.getElementById(form_id);
            if ((typeof(form) == 'object') && (form != null)) {



                
                var object = document.getElementById(form_id + '_<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_IGNORE_POST)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
');
                if ((typeof(object) == 'object') && (object != null)) {
                    if ('value' in object) object.value = 0;
                }
            }



            
            return true;
        }



        
        

        function Start_PageMassDelete (form_id) {

            
            var form = document.getElementById(form_id);
            if ((typeof(form) == 'object') && (form != null)) {



                
                object = document.getElementById(form_id + '_<?php echo htmlspecialchars((($tmp = @@REQUEST_PARAM_NAME_ACTION)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
');
                if ((typeof(object) == 'object') && (object != null)) {
                    if ('value' in object) {
                        object.value = '<?php echo htmlspecialchars((($tmp = @@ACTION_REQUEST_PARAM_VALUE_MASSDELETE)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
';



                        
                        form.submit();
                    }
                }
            }



            
            return false;
        }



        // принудительное переключение прозрачности строки таблицы
        //   object = любой опорный объект, размещенный в любой ячейке переключаемой строки
        //   visible = булевой признак видна строка или полупрозрачная
        //   opacity = уровень видимости невидимой строки (число от 0 до 1)

        function Toggle_TableRowTransparency (object, visible, opacity) {

            
            var exist = true;
            while (exist) {



                
                object = object.parentNode;
                exist = (typeof(object) == 'object') && (object != null);



                
                if (exist && (object.tagName == 'TR')) {



                    
                    object = jQuery(object).find('td');
                    if ((typeof(object) == 'object') && (object != null) && (object.length > 0)) {



                        
                        jQuery(object).css({ 'opacity': visible ? 1.0 : opacity });
                    }
                    break;
                }
            }



            
            return false;
        }



        // принудительное переключение прозрачности DIV-элемента
        //   object = любой опорный объект, размещенный в переключаемом DIV-элементе
        //   visible = булевой признак видна строка или полупрозрачная
        //   opacity = уровень видимости невидимой строки (число от 0 до 1)

        function Toggle_DivTransparency (object, visible, opacity) {

            // по опорному объекту выходим на DIV-элемент (то есть [объект] -> [..] -> [родительский DIV])
            var exist = true;
            while (exist) {

                // ищем родительский элемент
                object = object.parentNode;
                exist = (typeof(object) == 'object') && (object != null);

                // если это DIV-элемент, переключаем его прозрачность
                if (exist && (object.tagName == 'DIV')) {
                    jQuery(object).css({ 'opacity': visible ? 1.0 : opacity });
                    break;
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // принудительное переключение прозрачности LI-элемента
        //   object = любой опорный объект, размещенный в переключаемом LI-элементе
        //   visible = булевой признак видна строка или полупрозрачная
        //   opacity = уровень видимости невидимой строки (число от 0 до 1)

        function Toggle_LiTransparency (object, visible, opacity) {

            // по опорному объекту выходим на LI-элемент (то есть [объект] -> [..] -> [родительский LI])
            var exist = true;
            while (exist) {

                // ищем родительский элемент
                object = object.parentNode;
                exist = (typeof(object) == 'object') && (object != null);

                // если это LI-элемент, переключаем его прозрачность
                if (exist && (object.tagName == 'LI')) {
                    jQuery(object).css({ 'opacity': visible ? 1.0 : opacity });
                    break;
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // передвижение строки таблицы выше
        //   object = любой опорный объект, размещенный в любой ячейке передвигаемой строки
        //   skip_rows = сколько строк в начале таблицы не относятся к области передвижения

        function MoveUp_TableRow (object, skip_rows) {

            // по опорному объекту выходим на объект строки таблицы (то есть [объект] -> [родительский TD] -> [родительский TR])
            var tr = jQuery(object).parent().parent();
            if ((typeof(tr) == 'object') && (tr != null) && (tr.length == 1)) {

                // выходим на объект таблицы
                var table = jQuery(tr).parent();
                if ((typeof(table) == 'object') && (table != null) && (table.length == 1)) {

                    // запоминаем контент передвигаемой строки
                    var my_html = tr[0].innerHTML;

                    // получаем все объекты строк в этой таблице
                    var tr = jQuery(table).find('tr');
                    var num = tr.length;
                    if (num > 0) {

                        // двигаемся вниз по строкам, как находим передвигаемую, обмениваем ее контент с вышестоящей
                        var his_html = '';
                        var i = (skip_rows < 0) ? 0 : skip_rows;
                        while (i < num) {
                            if (tr[i].innerHTML == my_html) {
                                if (his_html != '') {
                                    tr[i].innerHTML = his_html;
                                    tr[i - 1].innerHTML = my_html;
                                }
                                break;
                            }
                            his_html = tr[i].innerHTML;
                            i++;
                        }
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // передвижение строки таблицы ниже
        //   object = любой опорный объект, размещенный в любой ячейке передвигаемой строки
        //   skip_rows = сколько строк в конце таблицы не относятся к области передвижения

        function MoveDown_TableRow (object, skip_rows) {

            // по опорному объекту выходим на объект строки таблицы (то есть [объект] -> [родительский TD] -> [родительский TR])
            var tr = jQuery(object).parent().parent();
            if ((typeof(tr) == 'object') && (tr != null) && (tr.length == 1)) {

                // выходим на объект таблицы
                var table = jQuery(tr).parent();
                if ((typeof(table) == 'object') && (table != null) && (table.length == 1)) {

                    // запоминаем контент передвигаемой строки
                    var my_html = tr[0].innerHTML;

                    // получаем все объекты строк в этой таблице
                    var tr = jQuery(table).find('tr');
                    var num = tr.length;
                    if (num > 0) {

                        // двигаемся вверх по строкам, как находим передвигаемую, обмениваем ее контент с нижестоящей
                        var his_html = '';
                        var i = num - ((skip_rows < 0) ? 0 : skip_rows);
                        while (i > 0) {
                            i--;
                            if (tr[i].innerHTML == my_html) {
                                if (his_html != '') {
                                    tr[i].innerHTML = his_html;
                                    tr[i + 1].innerHTML = my_html;
                                }
                                break;
                            }
                            his_html = tr[i].innerHTML;
                        }
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // обработка изменения цены элемента заказа
        //   event = событие нажатой клавиши
        //   object = объект редактируемого поля ввода цены
        //   order_id = идентификатор заказа
        //   item_id = идентификатор элемента заказа
        //   sign = пустая строка или знак (минус), добавляемый в информационное поле перед итоговой суммой
        //   highlight = булевой признак необходимости подсветки поля

        function Change_OrderItem_Price (event, object, order_id, item_id, sign, highlight) {

          // если событие действительно относится к нажатию клавиши
          if ((typeof(event) == 'object') && (event != null)) {
            if ('keyCode' in event) {

              // если это не текстовая клавиша, возвращаем TRUE (пропустить это изменение поля)
              if ((event.keyCode < 32) && (event.keyCode != 8)) return true;
              if ((event.keyCode == 37) || (event.keyCode == 38) || (event.keyCode == 39) || (event.keyCode == 40)) return true;
            }
          }

          // находим информационное поле на странице
          var field = document.getElementById('orderitem_total_' + order_id + '_' + item_id);
          if ((typeof(field) == 'object') && (field != null) && ('innerHTML' in field)) {

            // регулярное выражение поиска запятой
            var comma = new RegExp(',', 'gi');

            // извлекаем введенную цену
            var price = 0;
            if (object == null) object = document.getElementById('orderitem_price_' + order_id + '_' + item_id);
            if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {
              price = '' + object.value;
              price = price.replace(comma, '.');
              price = parseFloat(price);
              if (isNaN(price)) price = 0;
              if (price < 0) price *= -1;
              if ((price >= 100000000) || (price.toFixed(2) == '100000000.00')) {
                price = 100000000;
                object.value = price.toFixed(2);
                highlight = true;
              }

              // если разрешено, подсвечиваем изменившееся поле
              if (highlight && ('style' in object)) {
                if ('color' in object.style) {
                  object.style.color = '#0000FF';
                }
              }
            }

            // находим поле ввода количества на странице
            highlight = false;
            var count = 1;
            object = document.getElementById('orderitem_quantity_' + order_id + '_' + item_id);
            if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {
              count = parseInt(object.value);
              if (isNaN(count)) count = 0;
              if (count == 0) {
                count = 1;
                object.value = count;
                highlight = true;
              } else if (count > 100000) {
                count = 100000;
                object.value = count;
                highlight = true;
              } else if (count < -100000) {
                count = -100000;
                object.value = count;
                highlight = true;
              }

              // берем прежнее значение количества из атрибута old_value поля ввода
              var old_count = object.getAttribute('old_value');
              if (!old_count || (old_count == '')) old_count = '1';
              old_count = parseInt(old_count);
              if (isNaN(old_count)) old_count = 1;

              // сохраняем количество в атрибуте old_value поля ввода
              object.setAttribute('old_value', count);

              if (count < 0) count *= -1;
              if (old_count < 0) old_count *= -1;

              // если разрешено, подсвечиваем изменившееся поле
              if (highlight && ('style' in object)) {
                if ('color' in object.style) {
                  object.style.color = '#0000FF';
                }
              }

              // находим информационное поле полного количества товаров заказа на странице
              object = document.getElementById('orderitem_total_' + order_id + '_order_quantity');
              if ((typeof(object) == 'object') && (object != null) && ('innerHTML' in object)) {

                // берем количество товаров заказа из атрибута old_value информационного поля
                var quantity = object.getAttribute('old_value');
                if (!quantity || (quantity == '')) quantity = '0';
                quantity = parseInt(quantity);
                if (isNaN(quantity)) quantity = 0;

                // сохраняем новое количество в атрибуте old_value информационного поля
                quantity -= old_count;
                quantity += count;
                object.setAttribute('old_value', quantity);
                object.innerHTML = quantity;
              }
            }
            price *= count;

            // находим поле ввода скидки на странице
            highlight = false;
            var discount = 0;
            object = document.getElementById('orderitem_discount_' + order_id + '_' + item_id);
            if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {
              discount = object.value;
              discount = discount.replace(comma, '.');
              discount = parseFloat(discount);
              if (isNaN(discount)) discount = 0;
              if (discount < 0) discount *= -1;
              if ((discount >= 100) || (discount.toFixed(2) == '100.00')) {
                discount = 100;
                object.value = discount.toFixed(2);
                highlight = true;
              }

              // если разрешено, подсвечиваем изменившееся поле
              if (highlight && ('style' in object)) {
                if ('color' in object.style) {
                  object.style.color = '#0000FF';
                }
              }
            }
            price -= price * discount / 100;
            if (price < 0) price = 0;

            // передаем цену в информационное поле
            field.innerHTML = sign + price.toFixed(2) + ' <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
';

            // берем прежнее значение цены из атрибута old_value информационного поля
            var old_price = field.getAttribute('old_value');
            if (!old_price || (old_price == '')) old_price = '0.00';
            old_price = old_price.replace(comma, '.');
            old_price = parseFloat(old_price);
            if (isNaN(old_price)) old_price = 0;

            // сохраняем цену в атрибуте old_value информационного поля
            field.setAttribute('old_value', sign + price.toFixed(2));

            // находим информационное поле полной суммы заказа на странице
            object = document.getElementById('orderitem_total_' + order_id + '_order_sum');
            if ((typeof(object) == 'object') && (object != null) && ('innerHTML' in object)) {

              // берем сумму заказа из атрибута old_value информационного поля
              var sum = object.getAttribute('old_value');
              if (!sum || (sum == '')) sum = '0.00';
              sum = sum.replace(comma, '.');
              sum = parseFloat(sum);
              if (isNaN(sum)) sum = 0;

              // сохраняем новую сумму в атрибуте old_value информационного поля
              sum -= old_price;
              sum += price * ((sign == '-') ? -1 : 1);
              object.setAttribute('old_value', sum.toFixed(2));
              object.innerHTML = sum.toFixed(2) + ' <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['currency']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
';

              // вычисляем полную сумму заказа минус цена доставки
              var delivery_sum = 0;
              object = document.getElementById('orderitem_total_' + order_id + '_delivery');
              if ((typeof(object) == 'object') && (object != null) && ('innerHTML' in object)) {
                delivery_sum = object.getAttribute('old_value');
                if (!delivery_sum || (delivery_sum == '')) delivery_sum = '0.00';
                delivery_sum = delivery_sum.replace(comma, '.');
                delivery_sum = parseFloat(delivery_sum);
                if (isNaN(delivery_sum)) delivery_sum = 0;
              }
              sum -= delivery_sum;

              // если есть глобальная переменная суммы заказа (без цены доставки), передаем в нее полную сумму заказа минус цена доставки
              if (typeof(order_amount) != 'undefined') {
                order_amount = sum.toFixed(2);
              }

              // отображаем сумму дополнительной скидки, выраженной в процентах
              object = document.getElementById('orderitem_total_' + order_id + '_discount');
              if ((typeof(object) == 'object') && (object != null) && ('innerHTML' in object)) {
                var discount_sum = object.getAttribute('old_value');
                object = document.getElementById('discount_percent_' + order_id);
                if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {
                  if (!discount_sum || (discount_sum == '')) discount_sum = '0.00';
                  discount_sum = discount_sum.replace(comma, '.');
                  discount_sum = parseFloat(discount_sum);
                  if (isNaN(discount_sum)) discount_sum = 0;
                  sum += delivery_sum;
                  sum += -discount_sum;
                  if (sum <= 0) sum = 1;
                  var percent = -discount_sum * 100 / sum;

                  // отображаем процент, только если он не такой, как введен в поле
                  var prev_percent = '' + object.value;
                  prev_percent = prev_percent.replace(comma, '.');
                  prev_percent = parseFloat(prev_percent);
                  if (isNaN(prev_percent)) prev_percent = 0;
                  if (prev_percent.toFixed(2) != percent.toFixed(2)) {
                    object.value = percent.toFixed(2);
                  }

                  // сохраняем в глобальной переменной сумму заказа (без доставки и дополнительной скидки)
                  if (typeof(order_amount) != 'undefined') {
                    sum -= delivery_sum;
                    order_undiscount_amount = sum.toFixed(2);
                  }
                }
              }
            }
          }

          // возвращаем TRUE (пропустить это изменение поля)
          return true;
        }



        // обработка изменения количества элемента заказа
        //   event = событие нажатой клавиши
        //   object = объект редактируемого поля ввода количества
        //   order_id = идентификатор заказа
        //   item_id = идентификатор элемента заказа
        //   highlight = булевой признак необходимости подсветки поля

        function Change_OrderItem_Quantity (event, object, order_id, item_id, highlight) {

            // если событие действительно относится к нажатию клавиши
            if ((typeof(event) == 'object') && (event != null)) {
                if ('keyCode' in event) {

                    // если это не текстовая клавиша, возвращаем TRUE (пропустить это изменение поля)
                    if ((event.keyCode < 32) && (event.keyCode != 8)) return true;
                    if ((event.keyCode == 37) || (event.keyCode == 38) || (event.keyCode == 39) || (event.keyCode == 40)) return true;
                }
            }

            // находим поле цены элемента заказа на странице
            var field = document.getElementById('orderitem_price_' + order_id + '_' + item_id);
            if ((typeof(field) == 'object') && (field != null)) {

                // делаем обработку, словно изменение произошло в поле цены
                if ((typeof(object) == 'object') && (object != null)) {
                    Change_OrderItem_Price (null, field, order_id, item_id, '', false);

                    // если разрешено, подсвечиваем изменившееся поле
                    if (highlight && ('style' in object)) {
                        if ('color' in object.style) {
                            object.style.color = '#0000FF';
                        }
                    }
                }
            }

            // возвращаем TRUE (пропустить это изменение поля)
            return true;
        }



        // обработка изменения скидки элемента заказа
        //   event = событие нажатой клавиши
        //   object = объект редактируемого поля ввода скидки
        //   order_id = идентификатор заказа
        //   item_id = идентификатор элемента заказа
        //   highlight = булевой признак необходимости подсветки поля

        function Change_OrderItem_Discount (event, object, order_id, item_id, highlight) {

            // если событие действительно относится к нажатию клавиши
            if ((typeof(event) == 'object') && (event != null)) {
                if ('keyCode' in event) {

                    // если это не текстовая клавиша, возвращаем TRUE (пропустить это изменение поля)
                    if ((event.keyCode < 32) && (event.keyCode != 8)) return true;
                    if ((event.keyCode == 37) || (event.keyCode == 38) || (event.keyCode == 39) || (event.keyCode == 40)) return true;
                }
            }

            // находим поле цены элемента заказа на странице
            var field = document.getElementById('orderitem_price_' + order_id + '_' + item_id);
            if ((typeof(field) == 'object') && (field != null)) {

                // делаем обработку, словно изменение произошло в поле цены
                if ((typeof(object) == 'object') && (object != null)) {
                    Change_OrderItem_Price (null, field, order_id, item_id, '', false);

                    // если разрешено, подсвечиваем изменившееся поле
                    if (highlight && ('style' in object)) {
                        if ('color' in object.style) {
                            object.style.color = '#0000FF';
                        }
                    }
                }
            }

            // возвращаем TRUE (пропустить это изменение поля)
            return true;
        }



        // обработка изменения дополнительной процент-скидки заказа
        //   event = событие нажатой клавиши
        //   object = объект редактируемого поля ввода скидки
        //   order_id = идентификатор заказа
        //   highlight = булевой признак необходимости подсветки поля

        function Change_Order_DiscountPercent (event, object, order_id, highlight) {

          // если событие действительно относится к нажатию клавиши
          if ((typeof(event) == 'object') && (event != null)) {
            if ('keyCode' in event) {

              // если это не текстовая клавиша, возвращаем TRUE (пропустить это изменение поля)
              if ((event.keyCode < 32) && (event.keyCode != 8)) return true;
              if ((event.keyCode == 37) || (event.keyCode == 38) || (event.keyCode == 39) || (event.keyCode == 40)) return true;
            }
          }

          // находим итог суммы дополнительной скидки заказа на странице
          var field = document.getElementById('orderitem_total_' + order_id + '_discount');
          if ((typeof(field) == 'object') && (field != null) && ('getAttribute' in field)) {

            // находим итог полной суммы заказа
            var field2 = document.getElementById('orderitem_total_' + order_id + '_order_sum');
            if ((typeof(field2) == 'object') && (field2 != null) && ('getAttribute' in field2)) {

              // если существует объект поля ввода скидки
              if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {

                // регулярное выражение поиска запятой
                var comma = new RegExp(',', 'gi');

                // берем текущую сумму дополнительной скидки (здесь она отрицательная)
                var discount = field.getAttribute('old_value');
                if (!discount || (discount == '')) discount = '0.00';
                discount = discount.replace(comma, '.');
                discount = parseFloat(discount);
                if (isNaN(discount)) discount = 0;
                if (discount > 0) discount = 0;

                // берем полную сумму заказа
                var sum = field2.getAttribute('old_value');
                if (!sum || (sum == '')) sum = '0.00';
                sum = sum.replace(comma, '.');
                sum = parseFloat(sum);
                if (isNaN(sum)) sum = 0;
                if (sum < 0) sum = 0;

                // вычисляем сумму заказа без скидки
                sum += -discount;

                // берем процент дополнительной скидки
                discount = '' + object.value;
                discount = discount.replace(comma, '.');
                discount = parseFloat(discount);
                if (isNaN(discount)) discount = 0;
                if (discount < 0) discount = 0;
                if (discount > 100) discount = 100;

                // переводим процент скидки в сумму
                discount = discount * sum / 100;

                // находим поле суммы дополнительной скидки заказа
                field = document.getElementById('discount_sum_' + order_id);
                if ((typeof(field) == 'object') && (field != null) && ('value' in field)) {

                  // передаем туда сумму дополнительной скидки заказа
                  field.value = discount.toFixed(2);

                  // делаем обработку, словно изменение произошло в поле суммы дополнительной скидки заказа
                  Change_OrderItem_Price (null, field, order_id, 'discount', '-', false);

                  // если разрешено, подсвечиваем изменившееся поле
                  if (highlight && ('style' in object)) {
                    if ('color' in object.style) {
                      object.style.color = '#0000FF';
                    }
                  }
                }
              }
            }
          }

          // возвращаем TRUE (пропустить это изменение поля)
          return true;
        }



        // обмен значений двух полей ввода
        //   field1_id = идентификатор первого поля ввода
        //   field2_id = идентификатор второго поля ввода

        function Swap_Inputbox_Values (field1_id, field2_id) {

            // находим первое поле на странице
            var object = document.getElementById(field1_id);
            if ((typeof(object) == 'object') && (object != null) && ('value' in object)) {

                // находим второе поле на странице
                var object2 = document.getElementById(field2_id);
                if ((typeof(object2) == 'object') && (object2 != null) && ('value' in object2)) {

                    // обмениваем значения полей
                    var value = object.value;
                    object.value = object2.value;
                    object2.value = value;
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // включение видимости кнопки массовых операций "Применить"

        function Show_AcceptChanges_Button () {

            // если не существует функция getElementByName, выходим
            if (!document.getElementsByName) return;

            // ищем такую кнопку(и) на странице
            var object = document.getElementsByName('accept_changes_button');
            if ((typeof(object) == 'object') && (object != null) && ('length' in object) && (object.length > 0)) {

                // перебираем найденные кнопки
                for (var i = 0; i < object.length; i++) {
                    if ((typeof(object[i]) == 'object') && (object[i] != null) && ('setAttribute' in object[i]) && ('disabled' in object[i])) {

                        // показываем кнопку
                        object[i].disabled = false;
                        object[i].setAttribute('class', 'mass_submit');
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // контроль видимости кнопки массовых операций "Удалить помеченные"

        function Check_DeleteSelected_Button () {

            // если не существует функция getElementByName, выходим
            if (!document.getElementsByName) return;

            // ищем связанные с такой кнопкой флажки
            var visible = false;
            var object = document.getElementsByName('delete_items[]');
            if ((typeof(object) == 'object') && (object != null) && ('length' in object) && (object.length > 0)) {

                // перебираем найденные флажки
                for (var i = 0; i < object.length; i++) {
                    if ((typeof(object[i]) == 'object') && (object[i] != null) && ('checked' in object[i])) {

                        // запоминаем состояние флажка
                        visible = visible || object[i].checked;
                        if (visible) break;
                    }
                }
            }

            // ищем такую кнопку(и) на странице
            var object = document.getElementsByName('delete_selected_button');
            if ((typeof(object) == 'object') && (object != null) && ('length' in object) && (object.length > 0)) {

                // перебираем найденные кнопки
                for (var i = 0; i < object.length; i++) {
                    if ((typeof(object[i]) == 'object') && (object[i] != null) && ('setAttribute' in object[i]) && ('disabled' in object[i])) {

                        // показываем / скрываем кнопку
                        object[i].disabled = !visible;
                        object[i].setAttribute('class', visible ? 'mass_submit' : 'mass_submit disabled_button');
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // контроль листания страниц списка с клавиатуры

        function Control_Keyboard_PageNavigation (event) {

            // если не существует функция getElementByName, выходим
            if (!document.getElementsByName) return;

            // если имеется события для окна, берем его
            if (window.event) event = window.event;

            // если нажата CTRL + клавиша
            if (event.ctrlKey) {
                var link = null;

                // какая клавиша нажата?
                switch (event.keyCode ? event.keyCode : (event.which ? event.which : null)) {

                    // если стрелка влево
                    case 0x25:
                        link = document.getElementsByName('GotoPreviousPageLink');
                        if ((typeof(link) == 'object') && (link != null) && ('length' in link) && (link.length > 0)) link = link[0];
                        break;

                    // если стрелка вправо
                    case 0x27:
                        link = document.getElementsByName('GotoNextPageLink');
                        if ((typeof(link) == 'object') && (link != null) && ('length' in link) && (link.length > 0)) link = link[0];
                        break;
                }

                // если получен url перехода, делаем переход
                if (link && link.href) document.location = link.href;
            }
        }



        // делание элементов в форме списка перетаскиваемыми

        function Make_FormItems_Sortable () {

            // находим нужную форму на странице
            var object = jQuery('form#items_form');
            if ((typeof(object) != 'object') || (object == null)) return;

            // находим контейнеры элементов в этой форме
            var object = jQuery(object).find('div#items_container');
            if ((typeof(object) != 'object') || (object == null) || !('length' in object) || (object.length < 1)) return;

            // делаем элементы внутри контейнеров перетаскиваемыми в пределах своего контейнера
            jQuery(object).sortable({ containment: 'parent',
                                      items: 'li[class="flatlist"]',
                                      opacity: 0.75,
                                      scrollSensitivity: 20,
                                      tolerance: 'pointer',
                                      beforeStop: function (event, ui) {

                                                      // берем все вложенные LI-элементы
                                                      var object = jQuery(this).find('li');
                                                      if ((typeof(object) == 'object') && (object != null) && ('length' in object) && (object.length > 0)) {

                                                          // создаем массив порядковых номеров
                                                          var order_nums = new Array();

                                                          // перебираем найденные LI-элементы, заменяя их вложенными полями ввода
                                                          for (var i = 0; i < object.length; i++) {
                                                              var input = object[i];
                                                              if ((typeof(input) == 'object') && (input != null)) {

                                                                  // берем вложенное в LI поле ввода
                                                                  input = jQuery(input).find('input#order_num');
                                                                  if ((typeof(input) == 'object') && (input != null) && ('length' in input) && (input.length > 0)) {
                                                                      input = input[0];
                                                                      if ((typeof(input) == 'object') && (input != null) && ('value' in input)) {
                                                                          order_nums.push(input.value);
                                                                      } else {
                                                                          input = null;
                                                                      }
                                                                  } else {
                                                                      input = null;
                                                                  }
                                                              } else {
                                                                  input = null;
                                                              }
                                                              object[i] = input;
                                                          }

                                                          // сортируем порядковые номера по убыванию, проверяя уникальность
                                                          order_nums.sort(function (a, b) {
                                                                              a = parseInt(a);
                                                                              b = parseInt(b);
                                                                              return (a < b) ? -1 : ((a == b) ? 0 : 1);
                                                                          });
                                                          var prev = 0;
                                                          for (i = 0; i < order_nums.length; i++) {
                                                              if (order_nums[i] <= prev) {
                                                                  prev++;
                                                                  order_nums[i] = prev;
                                                              }
                                                              prev = order_nums[i];
                                                          }
                                                          order_nums.reverse();

                                                          // повторно перебираем найденные теперь уже INPUT-элементы
                                                          idx = 0;
                                                          for (i = 0; i < object.length; i++) {
                                                              if ((typeof(object[i]) == 'object') && (object[i] != null)) {

                                                                  // назначаем соответствующий порядковый номер
                                                                  object[i].value = order_nums[idx];
                                                                  idx++;
                                                              }
                                                          }
                                                      }

                                                      // проявляем кнопку Применить
                                                      Show_AcceptChanges_Button();
                                                  }
                                    });
        }



        // делание строк таблицы перетаскиваемыми
        //   table_id = идентификатор таблицы

        function Make_TableRows_Sortable (table_id) {

            // находим нужную таблицу на странице
            var object = document.getElementById(table_id);
            if ((typeof(object) != 'object') || (object == null)) return;

            // делаем строки таблицы перетаскиваемыми в ее пределах
            jQuery(object).sortable({ containment: 'parent',
                                      items: 'tr',
                                      opacity: 0.75,
                                      scrollSensitivity: 20,
                                      tolerance: 'pointer' });
        }



        // разворот/сворачивание UL-веток элемента списка
        //   object = или опорный LI-объект, размещенный первым потомком в переключаемой ветке,
        //            или любой опорный объект, включающий в себя переключаемую ветку

        function Switch_List_UL_Branch (object) {

            // если это опорный LI-объект и вложен в UL-объект, считаем последний опорным объектом
            if ((typeof(object) == 'object') && (object != null) && ('tagName' in object) && (object.tagName == 'LI')) {
                var ul = object.parentNode;
                if ((typeof(ul) == 'object') && (ul != null) && ('tagName' in ul) && (ul.tagName == 'UL')) object = ul;
            }

            // перебираем всех первых потомков опорного объекта
            if ((typeof(object) == 'object') && (object != null) && ('childNodes' in object)) {
                var childs = object.childNodes;
                if (childs && childs.length > 0) {
                    for (var i = 0; i < childs.length; i++) {
                        var ul = childs[i];

                        // если потомок является UL-объектом, переключаем его видимость
                        if ((typeof(ul) == 'object') && (ul != null) && ('tagName' in ul) && (ul.tagName == 'UL')) {
                            if (('style' in ul) && ('display' in ul.style)) {
                                ul.style.display = (ul.style.display == 'none') ? 'block' : 'none';
                            }
                        }
                    }
                }
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // разблокировка полей выпадающей панели
        //   id = идентификатор объекта панели

        function Unlock_Popup_Fields (id) {

            // разрешаем поле Файл
            var object = document.getElementById(id + 'file');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;

            // разрешаем поле Название
            object = document.getElementById(id + 'title');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;

            object = document.getElementById(id + 'name');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;

            // разрешаем поле Цена
            object = document.getElementById(id + 'price');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;

            // разрешаем поле Описание
            object = document.getElementById(id + 'description');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;

            // разрешаем поле Содержимое
            object = document.getElementById(id + 'content');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;

            // разрешаем поле Ссылка
            object = document.getElementById(id + 'link');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = false;
        }



        // сокрытие выпадающей панели
        //   id = идентификатор объекта панели

        function Hide_Popup (id) {

            // запрещаем поле Файл
            var object = document.getElementById(id + 'file');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            // запрещаем поле Название
            object = document.getElementById(id + 'title');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            object = document.getElementById(id + 'name');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            // запрещаем поле Цена
            object = document.getElementById(id + 'price');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            // запрещаем поле Описание
            object = document.getElementById(id + 'description');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            // запрещаем поле Содержимое
            object = document.getElementById(id + 'content');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            // запрещаем поле Ссылка
            object = document.getElementById(id + 'link');
            if (typeof(object) == 'object' && object != null && 'disabled' in object) object.disabled = true;

            // скрываем панель
            object = document.getElementById(id);
            if (typeof(object) == 'object' && object != null) object.style.display = 'none';

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // запуск выпадающей панели
        //   id = идентификатор объекта панели
        //   link_object = кликабельный объект, инициировавший выпадение панели

        function Start_Popup (id, link_object) {

            // скрываем все выпадающие панели
            jQuery('div.popup').hide();

            // запрещаем все редактируемые поля в выпадающих панелях
            var objects = jQuery('div.popup input.input');
            var object = null;
            if ((typeof(objects) == 'object') && (objects != null) && ('length' in objects) && (objects.length > 0)) {
                for (var i = 0; i < objects.length; i++) {
                    object = objects[i];
                    if ((typeof(object) == 'object') && (object != null) && ('disabled' in object)) object.disabled = true;
                }
            }
            objects = jQuery('div.popup textarea.input');
            if ((typeof(objects) == 'object') && (objects != null) && ('length' in objects) && (objects.length > 0)) {
                for (var i = 0; i < objects.length; i++) {
                    object = objects[i];
                    if ((typeof(object) == 'object') && (object != null) && ('disabled' in object)) object.disabled = true;
                }
            }

            // проявляем панель
            object = document.getElementById(id);
            if ((typeof(object) == 'object') && (object != null) && ('style' in object) && ('display' in object.style)) {
                object.style.display = 'block';

                // известен объект, инициировавший выпадение панели, двигаем панель на этот объект
                if ((typeof(link_object) == 'object') && (link_object != null)) {
                    var body = jQuery('body');
                    var w = jQuery(body).width();
                    var h = jQuery(body).height();
                    var pos = jQuery(link_object).offset();
                    var x = pos.left + jQuery(link_object).width() / 2;
                    var y = pos.top + jQuery(link_object).height() / 2;
                    var ow = jQuery(object).width();
                    var oh = jQuery(object).height();
                    x -= ow / 2;
                    y -= oh / 2;
                    if (x < 0) x = 0;
                    if (y < 0) y = 0;
                    if (x + ow > w) x = w - ow;
                    if (y + oh > h) y = h - oh;
                    if (jQuery(object).hasClass('popup_wide')) {
                        jQuery(object).animate({ top: y }, 0);
                    } else {
                        jQuery(object).animate({ left: x, top: y }, 0);
                    }
                }

                // разблокируем поля панели
                Unlock_Popup_Fields(id);
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // отправка выпадающей панели
        //   url_params = динамические параметры URL админпанели
        //   part_id = начало идентификатора переключаемых частей страницы

        function Submit_Popup (url_params, part_id) {

            // ищем форму с записями на странице
            var object = document.getElementById('items_form');
            if ((typeof(object) == 'object') && (object != null)) {

                // переключаем части страницы (проявляем уведомление Выполняется действие)
                if (part_id != '') {
                    var part = document.getElementById(part_id + '_list_box');
                    if ((typeof(part) == 'object') && (part != null) && ('style' in part) && ('display' in part.style)) part.style.display = 'none';
                    part = document.getElementById(part_id + '_start_box');
                    if ((typeof(part) == 'object') && (part != null) && ('style' in part) && ('display' in part.style)) part.style.display = 'block';
                }

                // если заданы динамические параметры URL, ставим полный URL в свойство ACTION формы
                if (url_params != '') object.action = '<?php echo $_smarty_tpl->tpl_vars['admin_script']->value;?>
' + url_params;

                // отправляем форму
                object.submit();
            }

            // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
            return false;
        }



        // поиск товара по коду (артикулу или буквенному коду)
        //   initiator - поле ввода, инициировавшее поиск
        //   code - искомый код
        //   prefix - префикс класса искомых LI-элементов

        function Search_Products_By_Code (initiator, code, prefix) {

          // если есть что искать
          var message = 'Укажите значение для поиска!';
          code = jQuery.trim(code).toLowerCase();
          if (code != '') {

            // если обнаружены искомые LI-элементы
            message = 'Товар не найден!';
            var parent = jQuery(initiator).parent();
            if ((typeof(parent) == 'object') && (parent != null) && ('length' in parent) && (parent.length > 0)) parent = parent[0];
            var objects = jQuery(parent).find('li.' + prefix + code);
            if ((typeof(objects) == 'object') && (objects != null) && ('length' in objects) && (objects.length > 0)) {

              // подсвечиваем найденное, остальное скрываем
              var found = 0;
              for (var i = 0; i < objects.length; i++) {
                var object = objects[i];
                if ((typeof(object) == 'object') && (object != null)) {
                  if (found == 0) {
                    jQuery(parent).find('li.product-found').removeClass('product-found');
                    jQuery(parent).find('ul.nested-item').hide();
                  }
                  jQuery(object).addClass('product-found');
                  found++;
                }
              }

              // разворачиваем ветви найденного
              if (found > 0) {
                objects = jQuery(parent).find('li.product-found');
                if ((typeof(objects) == 'object') && (objects != null) && ('length' in objects) && (objects.length > 0)) {
                  for (i = 0; i < objects.length; i++) {
                    object = objects[i];
                    do {
                      object = object.parentNode;
                      if ((typeof(object) == 'object') && (object != null) && ('tagName' in object) && (object.tagName == 'UL')) {
                        object.style.display = 'block';
                      }
                    } while (object != parent);
                  }
                }
                message = '';
              }
            }
          }

          // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
          if (message != '') alert(message);
          return false;
        }



        // поиск товара по тексту
        //   initiator - поле ввода, инициировавшее поиск
        //   text - искомый текст

        function Search_Products_By_Text (initiator, text) {

          // если есть что искать
          var message = 'Укажите текст для поиска!';
          text = jQuery.trim(text).toLowerCase();
          if (text != '') {

            // если обнаружены искомые LI-элементы
            message = 'Товар не найден!';
            var parent = jQuery(initiator).parent();
            if ((typeof(parent) == 'object') && (parent != null) && ('length' in parent) && (parent.length > 0)) parent = parent[0];
            var objects = jQuery(parent).find('ul.products').find('li');
            if ((typeof(objects) == 'object') && (objects != null) && ('length' in objects) && (objects.length > 0)) {

              // подсвечиваем найденное, остальное скрываем
              var found = 0;
              for (var i = 0; i < objects.length; i++) {
                var object = objects[i];
                if ((typeof(object) == 'object') && (object != null)) {
                  var a = jQuery(object).find('a');
                  if ((typeof(a) == 'object') && (a != null) && ('length' in a) && (a.length > 0)) a = a[0];
                  a = ('innerHTML' in a) ? a.innerHTML : '';
                  var s = jQuery(object).find('span.variant');
                  if ((typeof(s) == 'object') && (s != null) && ('length' in s) && (s.length > 0)) s = s[0];
                  s = ('innerHTML' in s) ? s.innerHTML : '';
                  a = jQuery.trim(a).toLowerCase();
                  s = jQuery.trim(s).toLowerCase();
                  if ((a.indexOf(text) != -1) || (s.indexOf(text) != -1)) {
                    if (found == 0) {
                      jQuery(parent).find('li.product-found').removeClass('product-found');
                      jQuery(parent).find('ul.nested-item').hide();
                    }
                    jQuery(object).addClass('product-found');
                    found++;
                  }
                }
              }

              // разворачиваем ветви найденного
              if (found > 0) {
                objects = jQuery(parent).find('li.product-found');
                if ((typeof(objects) == 'object') && (objects != null) && ('length' in objects) && (objects.length > 0)) {
                  for (i = 0; i < objects.length; i++) {
                    object = objects[i];
                    do {
                      object = object.parentNode;
                      if ((typeof(object) == 'object') && (object != null) && ('tagName' in object) && (object.tagName == 'UL')) {
                        object.style.display = 'block';
                      }
                    } while (object != parent);
                  }
                }
                message = '';
              }
            }
          }

          // возвращаем FALSE (для вызывающих функцию из обработчика события OnClick элемента <a>)
          if (message != '') alert(message);
          return false;
        }



        
        
        

        function htmlspecialchars ( string, quote_style ) {

            
            var chars = Array('&', '<', '>', '"', '\'');
            var entities = Array('&amp;', '&lt;', '&gt;', '&quot;', '&#039;');



            
            var size = chars.length;
            if (quote_style.toLowerCase() == 'ent_compat') $size--;
            if (quote_style.toLowerCase() == 'ent_noquotes') $size-=2;



            
            var object = null;
            for (var i = 0; i < chars.length; i++) {
                object = new RegExp(chars[i], 'gi');
                if (object.test(string)) string = string.replace(object, entities[i]);
            }



            
            return string;
        }



        
        
        
        

        function createCookie ( name, value, days ) {
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                var expires = '; expires=' + date.toGMTString();
            } else {
                var expires = '';
            }
            document.cookie = name + '=' + value + expires + '; path=/';
        }



        
        

        function readCookie ( name ) {
            var nameEQ = name + '=';
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }



        
        

        function eraseCookie ( name ) {
            createCookie(name, '', -1);
        }



        
        document.onkeydown = Control_Keyboard_PageNavigation;
    </script>



    
    <?php if (!function_exists('smarty_template_function_check_admin_rights_link')) {
    function smarty_template_function_check_admin_rights_link($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['check_admin_rights_link']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><?php if (isset($_smarty_tpl->tpl_vars['admin_rights']->value)&&is_array($_smarty_tpl->tpl_vars['admin_rights']->value)&&!empty($_smarty_tpl->tpl_vars['admin_rights']->value)&&!in_array(mb_strtolower($_smarty_tpl->tpl_vars['module']->value, 'UTF-8'),$_smarty_tpl->tpl_vars['admin_rights']->value)){?>style="color: #bbb;"<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>




    
    <?php if (!function_exists('smarty_template_function_pagemenu_link')) {
    function smarty_template_function_pagemenu_link($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['pagemenu_link']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?><a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value, ENT_QUOTES, 'UTF-8');?>
<?php echo $_smarty_tpl->tpl_vars['params']->value;?>
" <?php smarty_template_function_check_admin_rights_link($_smarty_tpl,array('module'=>$_smarty_tpl->tpl_vars['module']->value));?>
 <?php echo $_smarty_tpl->tpl_vars['a_params']->value;?>
><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</a><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>




    <body>

        <center>
            <table align="center" class="admin_page" cellpadding="0" cellspacing="0">

                
                <tr>
                    <td class="header">
                        <div class="box">
                            <span class="right" onmouseover="var pos = jQuery(this).position();jQuery('.tabs').hide();var w = jQuery('#tab01').width();var w2 = jQuery(this).width();jQuery('#tab01').animate({ left: pos.left - w + w2 + 15, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab01"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'About','text'=>'О программе','params'=>''));?>
<a href="<?php echo $_smarty_tpl->tpl_vars['relogin_url']->value;?>
">Войти заново</a><a href="<?php echo $_smarty_tpl->tpl_vars['logout_url']->value;?>
" onclick="return forced_logout(this);">Выход</a><li class="separator"></li><a href="http://imperacms.ru/ready-made-templates.htm" target="_blank">Готовые шаблоны</a><a href="http://imperacms.ru/impera-cms-templates.htm" target="_blank">Выбрать шаблон для натяжки</a><a href="http://imperacms.ru/impera-cms-modules.htm" target="_blank">Готовые модули</a><li class="separator"></li><a href="http://imperacms.ru/impera-cms-suggest.htm" target="_blank">Предложить идею</a><a href="http://imperacms.ru/feedback.htm" target="_blank">Написать разработчику</a><a href="http://imperacms.ru/forum.htm" target="_blank">Форум пользователей</a><a href="http://imperacms.ru/impera-cms-docs.htm" target="_blank">Руководства</a><li class="separator"></li><a href="http://imperacms.ru/impera_cms.zip" target="_blank">Скачать последнюю версию движка</a><a href="http://imperacms.ru/impera-cms-chronology.htm" target="_blank">Хронология обновлений</a><a href="http://imperacms.ru/impera-cms-agreement.htm" target="_blank">Лицензионное соглашение</a><a href="http://imperacms.ru/impera-cms-buy.htm" target="_blank">Оплатить лицензию</a></div><a href="<?php echo $_smarty_tpl->tpl_vars['logout_url']->value;?>
" onclick="return forced_logout(this);">выход</a></span><span class="right" onmouseover="var pos = jQuery(this).position();jQuery('.tabs').hide();var w = jQuery('#tab02').width();var w2 = jQuery(this).width();jQuery('#tab02').animate({ left: pos.left - w + w2 + 20, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab02"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
">Перейти на сайт</a><li class="sub1"><b>маркетинговые страницы</b></li><?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable(htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_CATALOG_MODE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><?php $_smarty_tpl->tpl_vars['url'] = new Smarty_variable(((($_smarty_tpl->tpl_vars['site']->value).('catalog?')).($_smarty_tpl->tpl_vars['param']->value)).('='), null, 0);?><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_NEW)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Недавно добавленные</a></li><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_NEWEST)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Новинки</a></li><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_HIT)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Хиты продаж</a></li><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_ACTIONAL)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Акционные товары</a></li><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_AWAITED)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Скоро в продаже</a></li><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_ORDERED)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Недавно покупали</a></li><?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable(htmlspecialchars(((($tmp = @@CATALOG_MODE_REQUEST_PARAM_VALUE_COMMENTED)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" target="_blank">Недавно обсуждали</a></li><li class="item-sub1"><span class="inaccessible">Лучшие товары</span></li><li class="sub1"><b>страницы листинга</b></li><li class="item-sub1"><span class="inaccessible">Комплекты товаров</span></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
stocks" target="_blank">Склады</a></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
media" target="_blank">Медиа файлы</a></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
news" target="_blank">Новости</a></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
articles" target="_blank">Статьи</a></li><li class="sub1"><b>ускорители заказа</b></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
quickorder" target="_blank">Оптовый заказ</a></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
configurator" target="_blank">Собрать комплект</a></li><li class="sub1"><b>специальные случаи</b></li><li class="item-sub1"><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
некая-несуществующая-страница" target="_blank">Ошибка 404 (страница не найдена)</a></li></div><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
">на сайт</a></span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab1').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Sections','text'=>'Специальные страницы','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'News','text'=>'Новости','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Articles','text'=>'Статьи','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Banners','text'=>'Баннеры','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Files','text'=>'Медиа файлы','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Menus','text'=>'Меню сайта','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Modules','text'=>'Зарегистрированные модули','params'=>''));?>
<li class="separator"></li><li>что сообщает сайт</li><li class="item"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
rss" target="_blank">По каналу RSS</a></li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Rss','text'=>'Настройки RSS','params'=>''));?>
</li><li class="item"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
yandex.xml" target="_blank">Сервису Яндекс.Маркет</a></li><li class="item"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
sitemap.xml" target="_blank">Сервису Google Sitemap</a></li><li class="item"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
robots.txt" target="_blank">Поисковым роботам</a></li><li class="item"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
informer" target="_blank">В основном информере</a></li><li class="item"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['site'][0][0]->site(array(),$_smarty_tpl);?>
pricelist.xls" target="_blank">В первом прайс-листе</a></li></div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Sections','text'=>'страницы','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab2').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab2"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Products','text'=>'Товары','params'=>''));?>
<li class="item"><span class="inaccessible">Парсинг товаров</span></li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'PriceEditor','text'=>'Редактор цен','params'=>''));?>
</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'PriceMonitoring','text'=>'Мониторинг цен','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Corrector','text'=>'Корректор полей','params'=>''));?>
</li><li class="item"><span class="inaccessible">Таблица товаров</span></li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'CommerceML','text'=>'Настройки синхронизации 1С','params'=>''));?>
</li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'ProductsKits','text'=>'Комплекты товаров','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Properties','text'=>'Свойства товаров','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Categories','text'=>'Категории','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Brands','text'=>'Бренды','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Stocks','text'=>'Склады','params'=>''));?>
</div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Products','text'=>'товары','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab3').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab3"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Orders','text'=>'Любые заказы','params'=>((('&').((htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_TYPE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars(((($tmp = @@TYPE_ORDERS_ANY)===null||$tmp==='' ? 0 : $tmp)), ENT_QUOTES, 'UTF-8')))));?>
<li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Orders','text'=>'Новые заказы','params'=>((('&').((htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_TYPE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars(((($tmp = @@TYPE_ORDERS_COMING)===null||$tmp==='' ? 1 : $tmp)), ENT_QUOTES, 'UTF-8')))));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Orders','text'=>'Заказы в обработке','params'=>((('&').((htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_TYPE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars(((($tmp = @@TYPE_ORDERS_PROCESSING)===null||$tmp==='' ? 2 : $tmp)), ENT_QUOTES, 'UTF-8')))));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Orders','text'=>'Выполненные заказы','params'=>((('&').((htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_TYPE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars(((($tmp = @@TYPE_ORDERS_DONE)===null||$tmp==='' ? 3 : $tmp)), ENT_QUOTES, 'UTF-8')))));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Orders','text'=>'Аннулированные заказы','params'=>((('&').((htmlspecialchars(((($tmp = @@REQUEST_PARAM_NAME_TYPE)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8')))).('=')).((htmlspecialchars(((($tmp = @@TYPE_ORDERS_CANCELED)===null||$tmp==='' ? 4 : $tmp)), ENT_QUOTES, 'UTF-8')))));?>
</li><li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'OrdersPhases','text'=>'Стадии заказа','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'PaymentsHistory','text'=>'История платежей','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'CreditPrograms','text'=>'Кредитные программы','params'=>''));?>
<li class="separator"></li><span class="inaccessible">Настройки корзины</span></div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Orders','text'=>'заказы','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab4').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab4"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Users','text'=>'Зарегистрированные пользователи','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Affiliate','text'=>'Партнерская программа','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'PriceGroups','text'=>'Ценовые группы','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Groups','text'=>'Группы скидок','params'=>''));?>
<li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Groups','text'=>'Внегрупповые скидки','params'=>''));?>
</li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Coupons','text'=>'Скидочные купоны','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Banneds','text'=>'Запреты доступа','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Countries','text'=>'Страны','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Regions','text'=>'Области','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Towns','text'=>'Города','params'=>''));?>
<?php if (!isset($_smarty_tpl->tpl_vars['config']->value->smsDnevnik_disabled)||!$_smarty_tpl->tpl_vars['config']->value->smsDnevnik_disabled){?><li class="separator"></li><li>социальные приложения</li><li class="sub1">СМС дневник</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'SchoolsLearners','text'=>'Учащиеся','params'=>''));?>
</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Schools','text'=>'Учебные заведения','params'=>''));?>
</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'SchoolsTypes','text'=>'Типы заведений','params'=>''));?>
</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'SchoolsLessons','text'=>'Предметы','params'=>''));?>
</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'SchoolsClasses','text'=>'Классы','params'=>''));?>
</li><?php }?></div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Users','text'=>'клиенты','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab5').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab5"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Comments','text'=>'Отзывы о товарах','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'AComments','text'=>'Комментарии статей','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'NComments','text'=>'Комментарии новостей','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Feedback','text'=>'Переписка с клиентами','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'CallMe','text'=>'Запросы связи "Позвоните мне"','params'=>''));?>
</div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Comments','text'=>'отзывы','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab6').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab6"><span class="inaccessible">Сейчас нет доступных отчетов</span><li class="separator"></li><li>обработки</li><li class="item"><span class="inaccessible">Сейчас нет доступных обработок</span></li><li class="separator"></li><li>печатные формы</li><li class="item"><span class="inaccessible">Сейчас нет доступных форм</span></li></div><a href="<?php echo $_smarty_tpl->tpl_vars['admin_goto']->value;?>
Reports" style="color: #bbb;">отчеты</a></span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab7').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab7"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Imports','text'=>'Варианты импорта','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Export','text'=>'Экспорт','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Backup','text'=>'Резервные копии','params'=>''));?>
<li class="separator"></li><li>seo</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'SearchEscorts','text'=>'Поисковое сопровождение','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Redirects','text'=>'Редиректы страниц','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Headers','text'=>'Просмотр заголовков страницы','params'=>''));?>
</li><li class="item"><span class="inaccessible">Перестроение заголовков</span></li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'HTAccess','text'=>'Корневой .htaccess','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Robots','text'=>'Файл robots.txt','params'=>''));?>
</li><?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable(htmlspecialchars((smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['site']->value,'!^[a-z]+://([^/]+)/.*$!','$1')), ENT_QUOTES, 'UTF-8'), null, 0);?><li class="sub1"><b>выдача Google</b></li><li class="item-sub1"><a href="http://www.google.ru/search?hl=ru&safe=off&filter=0&q=site%3A<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" target="_blank">Ваши страницы в индексе</a></li><li class="item-sub1"><a href="http://www.google.ru/search?hl=ru&safe=off&filter=0&q=link%3A<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
+-site%3A<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" target="_blank">Кто на вас незакрыто ссылается</a></li><li class="item-sub1"><a href="http://www.google.ru/search?hl=ru&safe=off&filter=0&q=related%3A<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" target="_blank">Сайты, похожие на ваш</a></li><li class="sub1"><b>сервисы Google</b></li><li class="item-sub1"><a href="https://developers.google.com/speed/pagespeed/insights/?hl=ru&url=<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" target="_blank">PageSpeed - оценка недостатков сайта</a></li><li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Mailer','text'=>'Почтовая рассылка','params'=>''));?>
</div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Backup','text'=>'разное','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab10').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab10"><span class="inaccessible">Файловый менеджер</span><span class="inaccessible">Переезд на другой хостинг</span><li class="separator"></li><li>починка</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Fallen','text'=>'Выпавшие записи базы данных','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'ResetCaches','text'=>'Очистка кешей','params'=>''));?>
</li><li class="item-sub1"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'CacheSetup','text'=>'Настройки MemCache и HtmCache','params'=>''));?>
</li><li class="separator"></li><li>безопасность</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'ExecutablesMap','text'=>'Карта исполняемых файлов','params'=>''));?>
</li><li class="separator"></li><li>мониторинг</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Speedometer','text'=>'Сравнение скоростей сайтов','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'PHPinfo','text'=>'Информация о PHP','params'=>''));?>
</li><li class="item-sub1"><span class="inaccessible">Мои параметры PHP</span></li></div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Speedometer','text'=>'утилиты','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab8').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab8"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Themes','text'=>'Дизайны сайта','params'=>''));?>
<li class="item"><span class="inaccessible">Генератор разметки шаблона</span></li><li class="item"><span class="inaccessible">Рипер шаблонов</span></li><li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Templates','text'=>'Файлы шаблона','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Styles','text'=>'Файлы стилей','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Images','text'=>'Файлы картинок','params'=>''));?>
</div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Themes','text'=>'дизайн','params'=>''));?>
</span><span onmouseover="var pos = jQuery(this).position(); jQuery('.tabs').hide(); jQuery('#tab9').animate({ left: pos.left, top: pos.top, 'z-index': 1000000 }, 0).show();"><div class="tabs" id="tab9"><span class="inaccessible">Мои магазины</span><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Setup','text'=>'Настройки сайта','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Admins','text'=>'Администраторы','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'ConfigFile','text'=>'Конфигурационный файл','params'=>''));?>
</li><li class="item"><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'TinyMceSetup','text'=>'Визуальный редактор','params'=>''));?>
</li><li class="item"><span class="inaccessible">Файлы языков сайта</span></li><li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Currencies','text'=>'Валюты сайта','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Payments','text'=>'Способы оплаты','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Deliveries','text'=>'Способы доставки','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'DeliveriesTypes','text'=>'Типы доставки','params'=>''));?>
<?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'ShippingsTerms','text'=>'Сроки отправки','params'=>''));?>
<li class="separator"></li><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'SmsGates','text'=>'SMS уведомления','params'=>''));?>
</div><?php smarty_template_function_pagemenu_link($_smarty_tpl,array('module'=>'Setup','text'=>'настройки','params'=>''));?>
</span>
                        </div>
                    </td>
                </tr>



                
                <tr>
                    <td class="content" onmouseover="jQuery('.tabs').hide();">



                        
                        <?php if (isset($_smarty_tpl->tpl_vars['currencies']->value)&&is_array($_smarty_tpl->tpl_vars['currencies']->value)&&(count($_smarty_tpl->tpl_vars['currencies']->value)>1)){?>
                            <form class="currency_form" method="post" title="В какой валюте показывать цены в админпанели">
                                <select name="admin_currency_id" onchange="jQuery(this).closest('form').submit();">
                                    <?php  $_smarty_tpl->tpl_vars['r'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['r']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['r']->key => $_smarty_tpl->tpl_vars['r']->value){
$_smarty_tpl->tpl_vars['r']->_loop = true;
?>
                                        <option value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['r']->value->currency_id)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['r']->value->currency_id)===null||$tmp==='' ? false : $tmp)==(($tmp = @$_smarty_tpl->tpl_vars['currency']->value->currency_id)===null||$tmp==='' ? '' : $tmp)){?> selected <?php }?>>
                                            <?php echo (($tmp = @$_smarty_tpl->tpl_vars['r']->value->name)===null||$tmp==='' ? 'Без названия!' : $tmp);?>

                                        </option>
                                    <?php } ?>
                                </select>
                            </form>
                        <?php }?>



                        
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['Body']->value)===null||$tmp==='' ? '' : $tmp);?>

                    </td>
                </tr>



                
                <tr>
                    <td class="footer" onmouseover="jQuery('.tabs').hide();">
                        <div class="box">

                            <div class="name">Impera CMS<div class="version">версия: <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['IMPERA_CMS_version']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
</div></div><a class="right" href="http://imperacms.ru/impera-cms-agreement.htm?product=ImperaCMS&license=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['root_url']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
&version=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['IMPERA_CMS_version']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" target="_blank">условия использования</a><div class="time" style="color: #888; float: right; margin-left: 6px;" title="Время по часам сайта">время <?php echo smarty_modifier_date_format(time(),'%H:%M');?>
</div><div class="time" style="color: #888; float: right; margin-left: 6px;" title="Дата по часам сайта">сегодня <?php echo smarty_modifier_date_format(time(),'%Y-%m-%d');?>
 |</div><div class="time" style="color: #888; float: right;" title="Место на сервере ИСПОЛЬЗОВАНО + СВОБОДНО">место <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteUsedSpace'][0][0]->siteUsedSpace(array(),$_smarty_tpl);?>
 + <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['siteFreeSpace'][0][0]->siteFreeSpace(array(),$_smarty_tpl);?>
 мб |</div><a href="<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
" title="Перейти в клиентскую часть сайта">на сайт</a><a href="<?php echo $_smarty_tpl->tpl_vars['logout_url']->value;?>
" title="Завершить работу" onclick="return forced_logout(this);">выход</a><a href="<?php echo $_smarty_tpl->tpl_vars['relogin_url']->value;?>
" title="Войти в админпанель под другим логином">войти заново</a>



                            <div class="update" id="ImperaCMS_update_info_line">
                                Доступна для загрузки новая версия (ver.<span id="ImperaCMS_update_info_line_version">????</span>) Impera CMS.
                            </div>



                            
                            <script type="text/javascript">
                                function forced_logout ( link_object ) {
                                    var alternative = '<?php echo smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['relogin_url']->value,'\\','\\\\'),'\'','\\\'');?>
';
                                    var agt = navigator.userAgent.toLowerCase();

                                    
                                    if (agt.indexOf('opera') == 0) {

                                    
                                    } else if (window.crypto && typeof window.crypto.logout === 'function') {

                                        
                                        try {
                                            window.crypto.logout();

                                            
                                            jQuery(link_object).attr('href', alternative);

                                            
                                            alert('Сейчас появится форма авторизации, в ней просто нажмите кнопку Отмена.');
                                            return true;
                                        } catch (e) {
                                        }

                                    
                                    } else if (agt.indexOf('chrome/') !== -1) {

                                    
                                    } else if (agt.indexOf('safari/') !== -1) {

                                    
                                    } else if (agt.indexOf('msie') !== -1) {

                                        
                                        try {
                                            document.execCommand('ClearAuthenticationCache', 'false');
                                            window.location = '<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
';
                                            return false;
                                        } catch (e) {
                                        }

                                    
                                    } else {
                                    }

                                    
                                    jQuery(link_object).attr('href', alternative);

                                    
                                    alert('Ваш браузер не поддерживает отбой авторизации. Чтобы исключить возможность атаки откатом с оставленного без присмотра компьютера, меняем схему выхода: сейчас появится форма авторизации, в ней просто нажмите кнопку Отмена.');

                                    
                                    return true;
                                }
                            </script>

                            <script type="text/javascript">
                                var IMPERA_CMS_current_version = <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['IMPERA_CMS_version']->value)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
;
                            </script>

                            <script src="http://imperacms.ru/update_master.js?product=ImperaCMS&license=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['root_url']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
&version=<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['IMPERA_CMS_version']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
" type="text/javascript"></script>

                            <script type="text/javascript">
                                if (window.IMPERACMS && window.IMPERACMS.may_update && window.IMPERACMS.last_version) {
                                    if (IMPERACMS.may_update() && (IMPERACMS.last_version() > IMPERA_CMS_current_version)) {

                                        var object = document.getElementById('ImperaCMS_update_info_line');
                                        if ((typeof(object) == 'object') && (object != null)) object.style.display = 'block';

                                        object = document.getElementById('ImperaCMS_update_info_line_version');
                                        if ((typeof(object) == 'object') && (object != null)) object.innerHTML = IMPERACMS.last_version();
                                    }
                                }
                            </script>
                        </div>
                    </td>
                </tr>
            </table>
        </center>

        

        <div class="ajaxWindow">
            <div>
                <div></div>
            </div>
        </div>
        <script>
            jQuery('body a.ajax').click(function () {
                try {
                    var href = this.getAttribute('href');
                    if (typeof href == 'string' && href != '') {
                        var els = jQuery(this).children('param'),
                            params = { },
                            n, v;
                        for (var i = 0; i < els.length; i++) {
                            n = els[i].getAttribute('name');
                            if (typeof n == 'string' && n != '') {
                                v = els[i].getAttribute('value');
                                if (typeof v != 'string') v = '';
                                params[n] = v;
                            }
                        }
                        params['ajax'] = 1;
                        var wnd = jQuery('body > .ajaxWindow > div > div');
                        jQuery(wnd).html('<span class="hint">загружается...</span>').closest('.ajaxWindow').css({ display: 'table' });
                        try {
                            jQuery.ajax({
                                url: href,
                                type: 'POST',
                                data: params,
                                async: true,
                                cache: false,
                                dataType: 'html',
                                ifModified: false,
                                statusCode: {
                                    200: function () { },
                                    404: function () { }
                                },
                                success: function (data, status, xhr) {
                                    jQuery(wnd).html(jQuery.trim(data) != '' ? data : '<span class="ok">Выполнено</span>');
                                    jQuery(wnd).parent('div').append('<a class="button" onclick="jQuery(this).closest(\'.ajaxWindow\').hide()">Закрыть окно</a>');
                                },
                                error: function (xhr, status, thrown) {
                                    jQuery(wnd).html('<span class="bad">Не удалось получить ответ после отправки формы!</span>');
                                    jQuery(wnd).parent('div').append('<a class="button" onclick="jQuery(this).closest(\'.ajaxWindow\').hide()">Понял</a>');
                                },
                                complete: function (xhr, status) { }
                            });
                        } catch (e) {
                            jQuery(wnd).html('<span class="bad">Технический сбой отправки формы!</span>');
                            jQuery(wnd).parent('div').append('<a class="button" onclick="jQuery(this).closest(\'.ajaxWindow\').hide()">Понял</a>');
                        }
                    }
                } catch (e) { }
                return false;
            });
        </script>
    </body>
</html>
<?php }} ?>