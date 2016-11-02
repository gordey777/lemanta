<?php /* Smarty version Smarty-3.1.8, created on 2016-09-29 10:08:48
         compiled from "../admin/design/default/html/admin_currency.htm" */ ?>
<?php /*%%SmartyHeaderCode:90219233057ecbe00f32348-51666503%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c9bf8e2347f943cc38ffee47535ae075a20c679' => 
    array (
      0 => '../admin/design/default/html/admin_currency.htm',
      1 => 1462406588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90219233057ecbe00f32348-51666503',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
    'root_url' => 0,
    'admin_folder' => 0,
    'id' => 0,
    'message' => 0,
    'error' => 0,
    'MainCurrency' => 0,
    'from_page' => 0,
    'Token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57ecbe01079b13_85175399',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ecbe01079b13_85175399')) {function content_57ecbe01079b13_85175399($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/modifier.replace.php';
?>

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"card",'main'=>true,'setup'=>true,'currencies'=>true,'card_currencies'=>true,'deliveries'=>true,'deliveries_types'=>true,'shippings_terms'=>true,'payment'=>true,'sms'=>true), 0);?>


  
  <?php $_smarty_tpl->tpl_vars["id"] = new Smarty_variable(htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->currency_id)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8'), null, 0);?>

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
=Currencies" title="Перейти на страницу валют в админпанели">Валюты</a>
        → <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>Редактирование<?php }else{ ?>Новая<?php }?>
      </div>
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)||(isset($_smarty_tpl->tpl_vars['item']->value->name)&&($_smarty_tpl->tpl_vars['item']->value->name!=''))){?>
        <?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->name, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>

      <?php }else{ ?>
        Новая валюта
      <?php }?>
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      &nbsp;
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

    <!-- Форма данных о записи -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Currency" enctype="multipart/form-data" id="item_form" method="post">

      <!-- Информация о названии -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">

        <!-- поле Название -->
        <tr>
          <td class="param_short">
            Название:
          </td>
          <td class="value" width="100%" title="Название валюты">
            <input class="edit" name="name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- поле Код ISO -->
          <td class="param_short">
            код:
          </td>
          <td class="value" title="Код ISO">
            <input class="edit" name="code[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="3" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->code)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- поле Курс -->
          <td class="param_short">
            Курс:
          </td>
          <td class="value" title="Курс (за единицу базовой валюты)">
            <input class="edit" name="rate_from[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="6" style="width: auto;" type="text" value="<?php if (smarty_modifier_replace(sprintf('%1.4f',(($tmp = @$_smarty_tpl->tpl_vars['item']->value->rate_from)===null||$tmp==='' ? 0 : $tmp)),',','.')>0){?><?php echo smarty_modifier_replace(sprintf('%1.4f',$_smarty_tpl->tpl_vars['item']->value->rate_from),',','.');?>
<?php }?>">
          </td>
          <td class="value" title="Знак (надпись)">
            <input class="edit" name="sign[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="4" style="width: auto;" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->sign)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- поле Курс -->
          <td class="param_short">
            =
          </td>
          <td class="value" title="Обратный курс (сколько единиц базовой валюты)">
            <input class="edit" name="rate_to[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="6" style="width: auto;" type="text" value="<?php if (smarty_modifier_replace(sprintf('%1.4f',(($tmp = @$_smarty_tpl->tpl_vars['item']->value->rate_to)===null||$tmp==='' ? 0 : $tmp)),',','.')>0){?><?php echo smarty_modifier_replace(sprintf('%1.4f',$_smarty_tpl->tpl_vars['item']->value->rate_to),',','.');?>
<?php }?>">
          </td>
          <td class="param_short">
            <?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['MainCurrency']->value->sign)===null||$tmp==='' ? '?' : $tmp), ENT_QUOTES, 'UTF-8');?>

          </td>

          <!-- флажок Разрешена -->
          <td class="param_short" title="Разрешена ли валюта к показу на сайте">
            <input class="checkbox" id="item_form_enabled" name="enabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->enabled)&&($_smarty_tpl->tpl_vars['item']->value->enabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_enabled');">
              Разрешена
            </span>
          </td>

          <!-- кнопка Сохранить -->
          <td class="value_box">
            <input name="main[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->main)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
">
            <input name="def[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->def)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
">
            <input name="defa[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->defa)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
">
            <input name="ymarket[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="hidden" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->ymarket)===null||$tmp==='' ? 0 : $tmp), ENT_QUOTES, 'UTF-8');?>
">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
      </table>

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

    <!-- Блок справочной информации -->
    <!-- div class="help">
      <div class="title">
        Справка
      </div>
    </div -->

  </div>
<?php }} ?>