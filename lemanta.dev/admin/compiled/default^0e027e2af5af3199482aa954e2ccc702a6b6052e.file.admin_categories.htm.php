<?php /* Smarty version Smarty-3.1.8, created on 2016-09-13 15:44:40
         compiled from "../admin/design/default/html/admin_categories.htm" */ ?>
<?php /*%%SmartyHeaderCode:125632415357d7f4b838e8c1-76741097%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e027e2af5af3199482aa954e2ccc702a6b6052e' => 
    array (
      0 => '../admin/design/default/html/admin_categories.htm',
      1 => 1462406584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125632415357d7f4b838e8c1-76741097',
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
    'menus' => 0,
    'c' => 0,
    'all_users' => 0,
    'field' => 0,
    'depth' => 0,
    'count' => 0,
    'value' => 0,
    'total_items' => 0,
    'items' => 0,
    'PagesNavigation' => 0,
    'moveedit' => 0,
    'settings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d7f4b85726e2_64322325',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d7f4b85726e2_64322325')) {function content_57d7f4b85726e2_64322325($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?><!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"categories",'main'=>true,'products'=>true,'products_kits'=>true,'categories'=>true,'brands'=>true,'properties'=>true,'stocks'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/" title="Перейти на главную страницу админпанели">Главная</a>
        → Категории
      </div>
      Категории товаров
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <a class="left" href="#help" onclick="javascript: Show_PageElements('help_box');" title="Показать справочную информацию">справка</a><a class="left" href="#settings" onclick="javascript: Show_PageElements('setup_form');" title="Показать настройки сайта, относящиеся к категориям">настройки</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Categories&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEEMPTIES, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" onclick="javascript: return confirm('Это действие удалит все категории и подкатегории, в которых нет товаров, статей и новостей. Вы действительно подтверждаете такую операцию?');" title="Удалить пустые категории">почистить</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Category&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
" title="Добавить категорию">добавить</a>
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

    <!-- Форма со списком категорий -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Categories" id="items_form" method="post">



        
        <table align="center" cellpadding="0" cellspacing="8" class="white">
            <tr>
                <td class="param_short">
                    Меню
                </td>
                <td class="value" width="70%" title="Фильтр: только принадлежащие такому меню сайта">

                    
                    <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MENU, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_MENU, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
                        <option value=""></option>
                        <?php if (isset($_smarty_tpl->tpl_vars['menus']->value)){?>
                            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->menu_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MENU])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_MENU]==$_smarty_tpl->tpl_vars['c']->value->menu_id)){?> selected<?php }?>>
                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>

                                </option>
                            <?php } ?>
                        <?php }?>
                    </select>
                </td>
                <td class="param_short">
                    Раздел
                </td>
                <td class="value" width="30%" title="Фильтр: только принадлежащие такому разделу сайта">

                    
                    <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SECTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SECTION, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
                        <option value=""></option>
                        <option value="1"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SECTION])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SECTION]=="1")){?> selected<?php }?>>
                            Основной
                        </option>
                    </select>
                </td>
                <td class="param_short" title="Фильтр: только информативные страницы">
                    <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INFORMATIVE, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INFORMATIVE, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_INFORMATIVE])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_INFORMATIVE]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
                    <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_INFORMATIVE, ENT_QUOTES, 'UTF-8');?>
');">
                        информативная
                    </span>
                </td>
                <td class="param_short" title="Фильтр: только запрещенные в RSS">
                    <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTRSS, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTRSS, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_NOTRSS])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_NOTRSS]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
                    <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTRSS, ENT_QUOTES, 'UTF-8');?>
');">
                        не для RSS
                    </span>
                </td>
            </tr>



            <tr>
                <td class="param_short">
                    Администратор
                </td>
                <td class="value" width="70%" title="Фильтр: только администрируемые таким человеком">

                    
                    <select class="thin" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_USER, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
                        <option value=""></option>
                        <option value="0"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER]=="0")){?> selected<?php }?>>
                            Администратор
                        </option>

                        

                        <?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/users.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_USER])===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

                    </select>
                </td>
                <td class="param_short">
                    Глубина
                </td>
                <td class="value" width="30%" title="Фильтр: выводить дерево категорий не глубже такого уровня">
                    <?php $_smarty_tpl->tpl_vars['field'] = new Smarty_variable('view_depth', null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['depth'] = new Smarty_variable(sprintf('%d',(($tmp = @$_smarty_tpl->tpl_vars['inputs']->value[$_smarty_tpl->tpl_vars['field']->value])===null||$tmp==='' ? 0 : $tmp)), null, 0);?>
                    <?php $_smarty_tpl->tpl_vars['depth'] = new Smarty_variable($_smarty_tpl->tpl_vars['depth']->value<1 ? 1 : $_smarty_tpl->tpl_vars['depth']->value, null, 0);?>
                    <select class="thin" name="<?php echo $_smarty_tpl->tpl_vars['field']->value;?>
" onchange="Start_PageRecordsFilter('items_form');">
                        <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(15, null, 0);?>
                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['counter'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['name'] = 'counter';
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['count']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['counter']['total']);
?>
                            <?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['counter']['iteration'], null, 0);?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['depth']->value==$_smarty_tpl->tpl_vars['value']->value){?>selected<?php }?>>
                                до <?php echo $_smarty_tpl->tpl_vars['value']->value;?>
 уровня
                            </option>
                        <?php endfor; endif; ?>
                        <option value="1000000000" <?php if ($_smarty_tpl->tpl_vars['depth']->value>$_smarty_tpl->tpl_vars['count']->value){?>selected<?php }?>>
                            неограниченно
                        </option>
                    </select>
                </td>
                <td class="param_short" title="Фильтр: только имеющие субдомен">
                    <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DOMAINED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DOMAINED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_DOMAINED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_DOMAINED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
                    <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_DOMAINED, ENT_QUOTES, 'UTF-8');?>
');">
                        с субдоменом
                    </span>
                </td>
                <td class="param_short" title="Фильтр: только запрещенные в информерах">
                    <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTEXPORT, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTEXPORT, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_NOTEXPORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_NOTEXPORT]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
                    <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_NOTEXPORT, ENT_QUOTES, 'UTF-8');?>
');">
                        не экспорт
                    </span>
                </td>
            </tr>
        </table>



      <!-- Сортировщик -->
      <table align="center" cellpadding="0" cellspacing="8" class="gray" style="margin-top: 0px; margin-bottom: 0px;">
        <tr>
          <td class="param_short">
            упорядочить
          </td>
          <td class="value" width="100%" title="Способ сортировки категорий в нижеследующем списке">

            <!-- Создаем селектор способов сортировки и перечисляем в нем нужные варианты -->
            <select class="thin" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SORT, ENT_QUOTES, 'UTF-8');?>
" onchange="javascript: Start_PageRecordsFilter('items_form');">
              <option value="<?php echo @SORT_CATEGORIES_MODE_AS_IS;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_AS_IS)){?> selected<?php }?>>как расставлены</option>
              <option value="<?php echo @SORT_CATEGORIES_MODE_BY_NAME;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_BY_NAME)){?> selected<?php }?>>по алфавиту</option>
              <option value="<?php echo @SORT_CATEGORIES_MODE_BY_BROWSED;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_BY_BROWSED)){?> selected<?php }?>>по количеству просмотров</option>
              <option value="<?php echo @SORT_CATEGORIES_MODE_BY_URL;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_BY_URL)){?> selected<?php }?>>по url (адресу страницы категории)</option>
              <option value="<?php echo @SORT_CATEGORIES_MODE_BY_MENU;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_BY_MENU)){?> selected<?php }?>>по меню</option>
              <option value="<?php echo @SORT_CATEGORIES_MODE_BY_OBJECTS;?>
"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_BY_OBJECTS)){?> selected<?php }?>>по подключаемым плагинам</option>
            </select>
          </td>

          <!-- Флажки фильтра -->
          <td class="param_short" title="Фильтр: только скрытые от незарегистрированных пользователей">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_HIDDEN])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_HIDDEN]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_HIDDEN, ENT_QUOTES, 'UTF-8');?>
');">
              скрыта
            </span>
          </td>
          <td class="param_short" title="Фильтр: только разрешенные к показу на сайте">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_ENABLED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_ENABLED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_ENABLED, ENT_QUOTES, 'UTF-8');?>
');">
              разрешена
            </span>
          </td>
          <td class="param_short" title="Фильтр: только загружавшиеся изображениями">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_IMAGED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_IMAGED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_IMAGED, ENT_QUOTES, 'UTF-8');?>
');">
              с картинками
            </span>
          </td>
          <td class="param_short" title="Фильтр: только с SEO текстом">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEOED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_SEOED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_SEOED, ENT_QUOTES, 'UTF-8');?>
');">
              с SEO текстом
            </span>
          </td>
          <td class="param_short" title="Фильтр: только с особым URL">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_URLSPECIAL])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_URLSPECIAL]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_URLSPECIAL, ENT_QUOTES, 'UTF-8');?>
');">
              с особым URL
            </span>
          </td>
          <td class="param_short" title="Фильтр: только с подключаемыми плагинами">
            <input class="checkbox" id="items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_OBJECTED])&&($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_FILTER_OBJECTED]==1)){?> checked<?php }?> value="1" onchange="javascript: Start_PageRecordsFilter('items_form');">
            <span onclick="javascript: Toggle_PageCheckbox('items_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_FILTER_OBJECTED, ENT_QUOTES, 'UTF-8');?>
');">
              с плагинами
            </span>
          </td>
<!--//   [$params->in_price1] = используемая в прайсе 1
    //   [$params->in_price2] = используемая в прайсе 2
    //   [$params->in_price3] = используемая в прайсе 3
    //   [$params->in_price4] = используемая в прайсе 4
    //   [$params->in_price5] = используемая в прайсе 5
    //   [$params->in_price6] = используемая в прайсе 6
    //   [$params->in_price7] = используемая в прайсе 7
    //   [$params->in_price8] = используемая в прайсе 8 -->
        </tr>
      </table>

      <!-- Кнопка сброса фильтра --> 
      <div class="toolkey">
        <span>найдено <span><?php echo sprintf("%d",(($tmp = @$_smarty_tpl->tpl_vars['total_items']->value)===null||$tmp==='' ? 0 : $tmp));?>
 шт.</span></span><a href="#" onclick="javascript: return Reset_PageRecordsFilter('items_form');" title="Сбросить фильтр (кроме способа упорядочения)">сбросить</a>
      </div>



      <?php if (!empty($_smarty_tpl->tpl_vars['items']->value)){?>

          
          <?php echo (($tmp = @$_smarty_tpl->tpl_vars['PagesNavigation']->value)===null||$tmp==='' ? '' : $tmp);?>


          
          <?php $_smarty_tpl->tpl_vars['moveedit'] = new Smarty_variable(!isset($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT])||$_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_SORT]==@SORT_CATEGORIES_MODE_AS_IS, null, 0);?>

          

          <?php echo $_smarty_tpl->getSubTemplate ('../../common_parts/categories.htm', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['items']->value,'counter'=>true,'topics'=>true,'flatlist'=>true,'fullinfo'=>false,'editable'=>true,'fulledit'=>true,'moveedit'=>$_smarty_tpl->tpl_vars['moveedit']->value,'maxdepth'=>$_smarty_tpl->tpl_vars['depth']->value), 0);?>


          
          <?php echo (($tmp = @$_smarty_tpl->tpl_vars['PagesNavigation']->value)===null||$tmp==='' ? '' : $tmp);?>




      <?php }else{ ?>
          <div class="noitems">
              Не найдено категорий.
          </div>
      <?php }?>
    </form>



    
    <a name="help"></a>
    <div class="help" id="help_box" style="display: none;">
      <div class="title">
        Справка
      </div>
      <div>
        <b>Фильтр</b>. Расположен в верхней части страницы и обеспечивает возможность выделить из общего списка категории по конкретным параметрам.
        Поля фильтра можно сочетать произвольно, они объединены функцией И.
      </div>
      <div>
        В принципе часть изображений или вообще все они могут быть загружены в категорию не обязательно для использования в тексте описания, а например
        как элементы ее фотогалереи. Поэтому поле фильтра "<u>с&nbsp;картинками</u>" дает возможность выделить категории, в которые производилась
        именно загрузка изображений, не уточняя притом факт, реально ли используются картинки или просто хранятся на сайте для прочих целей.
      </div>
      <div>
        Поле фильтра "<u>с&nbsp;особым&nbsp;URL</u>" выделяет категории с произвольно заданным адресом страницы, то есть не содержащим в начале
        адреса специальных включений (например catalog/), идентифицирующих разновидность запрошенного контента. Всякий URL категории не может
        быть похожим на URL другой категории, однако особым URL допустимо перекрываться с особыми URL других разновидностей контента сайта. В этом
        случае установлен следующий приоритет владения конфликтующим адресом: специальная страница, товар, категория, бренд, статья, новость.
      </div>
      <div>
        Поле фильтра "<u>с&nbsp;плагинами</u>" выделяет категории, на страницу которых во время создания или редактирования категории было предписано
        динамически подключать программные модули (плагины, расширяющие функционал) при просмотре страницы категории посетителем сайта. Здесь
        фильтрацией также не уточняется, действительно ли существуют файлы плагинов на сайте. Визуально категории с подключаемыми плагинами отмечаются
        в списке соответствующим значком перед названием категории. Наведение курсора на значок демонстрирует перечень плагинов, подключаемых
        конкретно к этой категории. Так как возможно подключать любые сторонние плагины, указываются не их названия, а классы модулей.
      </div>
      <div>
        <b>Упорядочение</b>. По умолчанию способ сортировки категорий в списке на данной странице равен "<u>как&nbsp;расставлены</u>". В случае
        смены способа сортировки он запоминается на время текущего сеанса.
      </div>
      <div>
        В отличие от других способов упорядочения, способ упорядочения "<u>как&nbsp;расставлены</u>" отключает сортировку и предоставляет функции
        перемещения категорий по ветви, в которой они находятся. Эта расстановка основана на так называемых весах элементов - символических числах
        первостепенности одной записи перед другой. Чем больше число, тем выше в своей ветви размещается категория в списке, упорядоченном таким образом.
      </div>
      <div>
        <b>Количества</b>. Напротив каждой категории указывается количество содержащихся в ней разрешенных к показу товаров. То есть это количество
        вычислено без учета товаров, которые находятся в базе данных, но имеют флажок запрета к показу на сайте. Так как категории могут быть вложены
        одна в другую, образуя ветвь, указываемое количество является суммарным для всей ветви, начиная от этой категории. Наведение курсора мыши на
        количество покажет, сколько всего товаров в такой ветви и сколько из них личных товаров данной категории, то есть содержащихся непосредственно
        в ней. Важно понимать, что под количеством товаров здесь понимается число товаров (карточек товаров) без учета числа их возможных вариантов.
      </div>
    </div>

    <!-- Форма соответствующих модулю настроек сайта -->
    <a name="settings"></a>
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Categories" enctype="multipart/form-data" id="setup_form" method="post"<?php if (empty($_smarty_tpl->tpl_vars['error']->value)){?> style="display: none;"<?php }?>>
      <br>
      <h1>
        Настройки
      </h1>
      <br>
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high" rowspan="5">
            Водяной знак:
            <center>
              <img class="watermark" src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_IMAGES_FOLDER_REFERENCE, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@CATEGORIES_CLASS_WATERMARK_FILENAME, ENT_QUOTES, 'UTF-8');?>
?<?php echo smarty_function_math(array('equation'=>'rand(1, 1000000000)'),$_smarty_tpl);?>
" title="Используемое изображение водяного знака для загружаемых в категорию картинок">
            </center>
          </td>
          <td class="value" colspan="4" width="100%" title="Какой файл изображения водяного знака требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf("%d",(@WATERMARK_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт)">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf("%d",@WATERMARK_UPLOAD_MAXIMAL_FILESIZE), ENT_QUOTES, 'UTF-8');?>
">  <!-- Не позволяем загрузку файла объемом свыше заданного -->
            <input class="edit" name="watermark_filename" type="file">
          </td>
          <td class="param_short">
            Наложить:
          </td>
          <td class="value" title="Как накладывать водяной знак (производится без масштабирования водяного знака)">
            <select name="categories_watermark_location">
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_LEFTTOP, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_LEFTTOP){?> selected<?php }?>>слева вверху</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_CENTERTOP, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_CENTERTOP){?> selected<?php }?>>в центре вверху</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_RIGHTTOP, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_RIGHTTOP){?> selected<?php }?>>справа вверху</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_LEFTCENTER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_LEFTCENTER){?> selected<?php }?>>слева в центре</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_CENTER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_CENTER){?> selected<?php }?>>по центру</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_RIGHTCENTER, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_RIGHTCENTER){?> selected<?php }?>>справа в центре</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_LEFTBOTTOM, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_LEFTBOTTOM){?> selected<?php }?>>слева внизу</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_CENTERBOTTOM, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_CENTERBOTTOM){?> selected<?php }?>>в центре внизу</option>
              <option value="<?php echo htmlspecialchars(@IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_location==@IMAGES_WATERMARK_LOCATION_RIGHTBOTTOM){?> selected<?php }?>>справа внизу</option>
            </select>
          </td>
          <td class="param_short">
            Видимость:
          </td>
          <td class="value" title="Видимость знака на картинке (чем меньше число, тем прозрачнее)">
            <select name="categories_watermark_transparency">
              <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["value"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['name'] = "value";
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['start'] = (int)@SETTINGS_MINIMAL_WATERMARK_TRANSPARENCY;
$_smarty_tpl->tpl_vars['smarty']->value['section']["value"]['loop'] = is_array($_loop=@SETTINGS_MAXIMAL_WATERMARK_TRANSPARENCY+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_transparency==$_smarty_tpl->getVariable('smarty')->value['section']['value']['index']){?> selected<?php }?>>
                  <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['value']['index'];?>
%
                </option>
              <?php endfor; endif; ?>
            </select>
          </td>
          <td class="param_short" title="Добавлять ли водяной знак на загружаемые изображения">
            <input class="checkbox" id="setup_form_watermark_enabled" name="categories_watermark_enabled" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_enabled)&&($_smarty_tpl->tpl_vars['settings']->value->categories_watermark_enabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_watermark_enabled');">
              Разрешен
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short">
            Качество:
          </td>
          <td class="value" width="100%" title="Качество картинок и миниатюр в процентах (чем меньше число, тем хуже качество и меньше размер файла)">
            <input class="edit" name="categories_images_quality" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_images_quality, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short">
            Размеры картинок:
          </td>
          <td class="value" title="Предельная ширина картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_IMAGES_WIDTH, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_IMAGES_WIDTH, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="categories_images_width" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_images_width, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value" title="Предельная высота картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_IMAGES_HEIGHT, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_IMAGES_HEIGHT, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="categories_images_height" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_images_height, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short">
            Размеры миниатюр:
          </td>
          <td class="value" title="Предельная ширина уменьшенных картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_THUMBNAIL_WIDTH, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_THUMBNAIL_WIDTH, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="categories_thumbnail_width" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_thumbnail_width, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value" title="Предельная высота уменьшенных картинок в точках (в пределах от <?php echo htmlspecialchars(@SETTINGS_MINIMAL_THUMBNAIL_HEIGHT, ENT_QUOTES, 'UTF-8');?>
 до <?php echo htmlspecialchars(@SETTINGS_MAXIMAL_THUMBNAIL_HEIGHT, ENT_QUOTES, 'UTF-8');?>
)">
            <input class="edit" name="categories_thumbnail_height" size="6" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_thumbnail_height, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short" title="Подгонять ли размеры меньших изображений до указанных размеров">
            <input class="checkbox" id="setup_form_images_exactly" name="categories_images_exactly" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->categories_images_exactly)&&($_smarty_tpl->tpl_vars['settings']->value->categories_images_exactly==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_images_exactly');">
              Точно
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short" colspan="3" title="Использовать ли визуальный редактор при редактировании категорий">
            <input class="checkbox" id="setup_form_wysiwyg_disabled" name="categories_wysiwyg_disabled" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled)&&($_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_wysiwyg_disabled');">
              Отключить wysiwyg-редактор:
            </span>
          </td>
          <td class="value" colspan="3" title="Как обрабатывать текст при отключенном визуальном редакторе">
            <select name="categories_wysiwyg_disabled_mode">
              <option value="<?php echo htmlspecialchars(@FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled_mode==@FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION){?> selected<?php }?>>в тексте ничего не менять, не трогать разметочные теги</option>
              <option value="<?php echo htmlspecialchars(@FIX_SIMPLE_TEXTAREA_TEXT_MODE_ALL_TAGS_CLEAR, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled_mode==@FIX_SIMPLE_TEXTAREA_TEXT_MODE_ALL_TAGS_CLEAR){?> selected<?php }?>>из текста удалять все теги, пустые строки и лишние пробелы</option>
            </select>
          </td>
          <td class="param_short" colspan="3" title="Разрешить ли системе заполнять пустые поля мета информации">
            <input class="checkbox" id="setup_form_meta_autofill" name="categories_meta_autofill" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['settings']->value->categories_meta_autofill)&&($_smarty_tpl->tpl_vars['settings']->value->categories_meta_autofill==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('setup_form_meta_autofill');">
              Автозаполнение полей мета тегов
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short" colspan="3">
            Сортировать в списках стороны клиента:
          </td>
          <td class="value" colspan="3" title="Как упорядочить список категорий, сформированный для клиентской стороны">
            <select name="categories_sort_method">
              <option value="<?php echo htmlspecialchars(@SORT_CATEGORIES_MODE_AS_IS, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_sort_method==@SORT_CATEGORIES_MODE_AS_IS){?> selected<?php }?>>как расставлены в админпанели</option>
              <option value="<?php echo htmlspecialchars(@SORT_CATEGORIES_MODE_BY_NAME, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_sort_method==@SORT_CATEGORIES_MODE_BY_NAME){?> selected<?php }?>>по алфавиту</option>
              <option value="<?php echo htmlspecialchars(@SORT_CATEGORIES_MODE_BY_BROWSED, ENT_QUOTES, 'UTF-8');?>
"<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_sort_method==@SORT_CATEGORIES_MODE_BY_BROWSED){?> selected<?php }?>>по количеству просмотров</option>
            </select>
          </td>
          <td class="param_short">
            Префикс:
          </td>
          <td class="value" title="Префикс папки с картинками категорий">
            <input class="edit" name="categories_files_folder_prefix" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_files_folder_prefix, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="value_box">
            <input class="submit" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SETUP, ENT_QUOTES, 'UTF-8');?>
" type="submit" value="Сохранить">
          </td>
        </tr>
        <tr>
          <td colspan="9"><!-- // --></td>
        </tr>
      </table>

      <!-- Добавляем аутентификатор операции -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['inputs']->value[@REQUEST_PARAM_NAME_TOKEN], ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
    </form>

  </div>
<?php }} ?>