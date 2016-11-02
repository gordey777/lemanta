<?php /* Smarty version Smarty-3.1.8, created on 2016-09-13 15:45:21
         compiled from "../admin/design/default/html/admin_category.htm" */ ?>
<?php /*%%SmartyHeaderCode:128130822057d7f4e14c9584-26396228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5573e5e3cbc0a43c27a89e61c5537b749e50e0dd' => 
    array (
      0 => '../admin/design/default/html/admin_category.htm',
      1 => 1462406585,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128130822057d7f4e14c9584-26396228',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
    'root_url' => 0,
    'admin_folder' => 0,
    'id' => 0,
    'error' => 0,
    'message' => 0,
    'categories' => 0,
    'c' => 0,
    'settings' => 0,
    'all_users' => 0,
    'menus' => 0,
    'site' => 0,
    'param' => 0,
    'mask' => 0,
    'value' => 0,
    'i' => 0,
    'Token' => 0,
    'image' => 0,
    'from_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d7f4e16b8a08_12876297',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d7f4e16b8a08_12876297')) {function content_57d7f4e16b8a08_12876297($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/var/www/lemanta/data/www/lemanta.com/Smarty/libs/plugins/function.math.php';
?><!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"card",'main'=>true,'products'=>true,'products_kits'=>true,'categories'=>true,'card_categories'=>true,'brands'=>true,'properties'=>true,'stocks'=>true), 0);?>


  <!--  -->
  <?php $_smarty_tpl->tpl_vars["id"] = new Smarty_variable((($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->category_id, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? 0 : $tmp), null, 0);?>

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
=Categories" title="Перейти на страницу категорий в админпанели">Категории</a>
        → <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>Редактирование<?php }else{ ?>Новая<?php }?>
      </div>
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>
        <?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->name, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? "&nbsp;" : $tmp);?>

      <?php }else{ ?>
        Новая категория
      <?php }?>
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)&&isset($_smarty_tpl->tpl_vars['item']->value->url)&&!empty($_smarty_tpl->tpl_vars['item']->value->url)&&empty($_smarty_tpl->tpl_vars['error']->value)){?><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url, ENT_QUOTES, 'UTF-8');?>
" title="Перейти на страницу категории в клиентской части сайта">http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url_path, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url, ENT_QUOTES, 'UTF-8');?>
</a><?php }else{ ?>&nbsp;<?php }?><?php if (isset($_smarty_tpl->tpl_vars['item']->value->subdomain)&&!empty($_smarty_tpl->tpl_vars['item']->value->subdomain)&&isset($_smarty_tpl->tpl_vars['item']->value->subdomain_enabled)&&($_smarty_tpl->tpl_vars['item']->value->subdomain_enabled==1)){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->subdomain, ENT_QUOTES, 'UTF-8');?>
.<?php echo $_SERVER['HTTP_HOST'];?>
/" title="Перейти на субдомен категории">http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->subdomain, ENT_QUOTES, 'UTF-8');?>
.<?php echo $_SERVER['HTTP_HOST'];?>
/</a><?php }?>
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

    <!-- Форма данных о категории -->
    <form action="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Category" enctype="multipart/form-data" id="item_form" method="post">

      <!-- Информация о названии -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">

        <!-- поле Название -->
        <tr>
          <td class="param">
            Название:
          </td>
          <td class="value" colspan="3" width="100%" title="Название категории">
            <input class="edit" id="item_form_name_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- кнопка Сохранить -->
          <td class="value_box" width="1%">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>

        <!-- поле Название в единственном числе -->
        <tr>
          <td class="param">
            В единст.числе:
          </td>
          <td class="value" width="50%" title="Название категории в единственном числе">
            <input class="edit" name="single_name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->single_name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- поле Название в конфигураторе -->
          <td class="param_short" width="1%">
            <a href="http://<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
/configurator" title="Перейти на страницу конфигуратора в клиентской части сайта">В конфигураторе</a>:
          </td>
          <td class="value" width="50%" title="Название (или несколько через запятую) категории в конфигураторе">
            <input class="edit" name="configurator_name[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['item']->value->configurator_name)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
">
          </td>

          <!-- флажок Свой блок в каталоге -->
          <td class="param_short" title="Видна ли категория своим блоком на основной странице каталога">
            <input class="checkbox" id="item_form_own_block" name="own_block[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->own_block)&&($_smarty_tpl->tpl_vars['item']->value->own_block==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_own_block');">
              Свой блок
            </span>
          </td>
        </tr>
      </table>

      <!-- Информация по прикреплениям -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param">
            Прикреплена к:
          </td>
          <td class="value" width="100%">
            <select name="parent[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0">Корень</option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/categories.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['categories']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->parent)===null||$tmp==='' ? 0 : $tmp),'counter'=>true,'selector'=>true), 0);?>

            </select>
          </td>

          <!-- флажок Прикреплена к нескольким -->
          <td class="param_short" title="Имеет ли категория дополнительные прикрепления к другим категориям">
            <input class="checkbox" id="item_form_use_parents" name="use_parents[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->use_parents)&&($_smarty_tpl->tpl_vars['item']->value->use_parents==1)){?> checked<?php }?> value="1" onchange="javascript: document.getElementById('use_parents_box').style.display = this.checked ? '' : 'none';">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_use_parents');">
              К нескольким
            </span>
          </td>
        </tr>

        <!-- поле К чему еше прикреплена категория -->
        <tr id="use_parents_box"<?php if (!isset($_smarty_tpl->tpl_vars['item']->value->use_parents)||($_smarty_tpl->tpl_vars['item']->value->use_parents!=1)){?> style="display: none;"<?php }?>>
          <td class="param_high">
            К чему еще прикреплена:
          </td>
          <td class="value" colspan="2" title="К каким еще категориям прикреплена данная категория (несколько выбираются с помощью клавиш Shift и Ctrl)">
            <select multiple name="parents[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][]" size="7">

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/categories.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['categories']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->parents)===null||$tmp==='' ? '' : $tmp),'counter'=>true,'selector'=>true), 0);?>

            </select>
          </td>
        </tr>
      </table>

      <!-- Meta информация -->
      <table align="center" cellpadding="0" cellspacing="10" class="gray">
        <tr>
          <td class="param">
            URL:
          </td>
          <td class="param_short" width="1%">
            http://сайт/<span id="item_form_url_path"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->url_special)&&($_smarty_tpl->tpl_vars['item']->value->url_special==1)){?> style="display: none;"<?php }?>>catalog/</span>
          </td>
          <td class="value" width="100%" title="Окончание адреса страницы категории">
            <input class="edit" id="item_form_url_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->url, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short" title="Будет ли URL без catalog/ в начале">
            <input class="checkbox" id="item_form_url_special" name="url_special[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->url_special)&&($_smarty_tpl->tpl_vars['item']->value->url_special==1)){?> checked<?php }?> value="1" onchange="javascript: var object = document.getElementById('item_form_url_path'); if ((typeof(object) == 'object') && (object != null)) object.style.display = this.checked ? 'none' : '';">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_url_special');">
              Особый
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_high" rowspan="2">
            Meta Keywords:
          </td>
          <td class="value" colspan="2" rowspan="2" title="Какой текст разместить в мета теге &lt;meta name=keywords ...&gt; заголовка страницы">
            <textarea id="item_form_meta_keywords_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_keywords[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 32px;"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->meta_keywords, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
          <td class="param_short" title="Запрещена ли демонстрация категории в RSS">
            <input class="checkbox" id="item_form_rss_disabled" name="rss_disabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->rss_disabled)&&($_smarty_tpl->tpl_vars['item']->value->rss_disabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_rss_disabled');">
              Не для RSS
            </span>
          </td>
        </tr>
        <tr>
          <td class="param_short" title="Запрещена ли демонстрация категории в информерах на внешних сайтах">
            <input class="checkbox" id="item_form_export_disabled" name="export_disabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->export_disabled)&&($_smarty_tpl->tpl_vars['item']->value->export_disabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_export_disabled');">
              Не экспорт
            </span>
          </td>
        </tr>
        <tr>
          <td class="param">
            Meta Description:
          </td>
          <td class="value" colspan="2" title="Какой текст разместить в мета теге &lt;meta name=description ...&gt; заголовка страницы">
            <textarea id="item_form_meta_description_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 48px;"><?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->meta_description, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
          <td class="value" rowspan="2" title="В каких прайсах используется категория (несколько выбираются с помощью клавиш Shift и Ctrl)">
            <select multiple name="in_prices[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][]" size="5" style="font-size: 8pt; height: 80px; width: 92px;">
              <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['name'] = "prices";
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['loop'] = is_array($_loop=8) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["prices"]['total']);
?>
                <?php $_smarty_tpl->tpl_vars["c"] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['prices']['index'], null, 0);?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['c']->value;?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->in_prices[$_smarty_tpl->tpl_vars['c']->value])&&($_smarty_tpl->tpl_vars['item']->value->in_prices[$_smarty_tpl->tpl_vars['c']->value]==1)){?> selected<?php }?>>прайс <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['prices']['iteration'];?>
</option>
              <?php endfor; endif; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td class="param">
            Meta Title:
          </td>
          <td class="value" colspan="2" width="100%" title="Какой текст разместить в теге &lt;title&gt; заголовка страницы">
            <input class="edit" id="item_form_meta_title_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="meta_title[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->meta_title, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <!-- td class="value_box" width="1%">
            <input class="submit" type="submit" value="Сохранить">
          </td -->
        </tr>
      </table>

      <!-- Описание -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high">
            Описание:
          </td>
          <td class="<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled==1){?>value<?php }else{ ?>value_box<?php }?>">
            <textarea class="editor_small" id="item_form_description_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value->description)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
      </table>

      <!-- Теги -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">

        <!-- поле Теги -->
        <tr>
          <td class="param">
            Теги:
          </td>
          <td class="value" width="100%" title="Ассоциируемые с этой записью теги (перечисляются через запятую)">
            <input class="edit" name="tags[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->tags, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>

          <!-- кнопка Сохранить -->
          <td class="value_box">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
      </table>

      <!-- SEO текст -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high">
            SEO текст:
          </td>
          <td class="<?php if ($_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled==1){?>value<?php }else{ ?>value_box<?php }?>">
            <textarea class="editor_small" name="seo_description[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 150px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value->seo_description)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
      </table>

      <!-- Информация по субдомену -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param">
            Субдомен:
          </td>
          <td class="value" width="100%" title="Левая часть субдомена категории (точка и домен сайта добавятся справа неявно)">
            <input class="edit" name="subdomain[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->subdomain, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>
          <td class="param_short" title="Разрешен ли собственный домен у категории">
            <input class="checkbox" id="item_form_subdomain_enabled" name="subdomain_enabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->subdomain_enabled)&&($_smarty_tpl->tpl_vars['item']->value->subdomain_enabled==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_subdomain_enabled');">
              Разрешен
            </span>
          </td>
          <td class="value_box">
            <input class="submit" type="submit" value="Сохранить">
          </td>
        </tr>
        <tr>
          <td class="param_high">
            Контент субдомена:
          </td>
          <td class="value" colspan="3" title="Полный html-код страницы субдомена категории (появится вместо стандартной страницы сайта)">
            <textarea name="subdomain_html[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" style="height: 96px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value->subdomain_html)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
          </td>
        </tr>
      </table>

      <!-- Информация о прикреплениях и разрешениях -->
      <table align="center" cellpadding="0" cellspacing="10" class="gray">
        <tr>
          <td class="param">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Users" title="Перейти на страницу зарегистрированных пользователей в админпанели">Администратор</a>:
          </td>
          <td class="value" colspan="3" width="100%" title="Кому разрешено администрировать эту категорию">

            <!-- Создаем селектор пользователей -->
            <select name="user_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0">Администратор</option>

              <!--  -->

              <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/users.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('items'=>$_smarty_tpl->tpl_vars['all_users']->value,'currents'=>(($tmp = @$_smarty_tpl->tpl_vars['item']->value->user_id)===null||$tmp==='' ? 0 : $tmp),'selector'=>true), 0);?>

            </select>
          </td>

          <!-- поле Вес в ветке -->
          <td class="param_short">
            Вес:
          </td>
          <td class="value" title="Число определяет положение категории выше других с меньшим весом в той же ветви">
            <input class="edit" name="order_num[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->order_num, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>

          <!-- флажок Скрыта от чужих -->
          <td class="param_short" title="Будет ли категория скрыта от незарегистрированных пользователей">
            <input class="checkbox" id="item_form_hidden" name="hidden[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->hidden)&&($_smarty_tpl->tpl_vars['item']->value->hidden==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_hidden');">
              Скрыта
            </span>
          </td>

          <!-- флажок Выделена визуально -->
          <td class="param_short" title="Будет ли категория выделена визуально в списке">
            <input class="checkbox" id="item_form_highlighted" name="highlighted[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->highlighted)&&($_smarty_tpl->tpl_vars['item']->value->highlighted==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_highlighted');">
              Выделена
            </span>
          </td>
        </tr>

        <tr>
          <td class="param">
            Раздел:
          </td>
          <td class="value" colspan="3" width="100%" title="К какому разделу сайта принадлежит категория">

            <!-- Создаем селектор разделов сайта -->
            <select name="section_field[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="1">Основной</option>
            </select>
          </td>

          <!-- поле Количество просмотров -->
          <td class="param_short">
            Просмотры:
          </td>
          <td class="value" title="Счетчик визитов на страницу категории">
            <input class="edit" name="browsed[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo (($tmp = @htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->browsed, ENT_QUOTES, 'UTF-8'))===null||$tmp==='' ? '' : $tmp);?>
">
          </td>

          <!-- флажок Информативная страница -->
          <td class="param_short" colspan="2" title="Будет ли страница категории являться информативной">
            <input class="checkbox" id="item_form_informative" name="informative[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->informative)&&($_smarty_tpl->tpl_vars['item']->value->informative==1)){?> checked<?php }?> value="1">
            <span onclick="javascript: Toggle_PageCheckbox('item_form_informative');">
              Информативная
            </span>
          </td>
        </tr>

        <!-- поле Меню -->
        <tr>
          <td class="param">
            <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Menus" title="Перейти на страницу меню сайта в админпанели">Меню</a>:
          </td>
          <td class="value" width="50%" title="В какое меню входит категория">

            <!-- Селектор выбора меню сайта -->
            <select name="menu_id[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]">
              <option value="0"></option>
              <?php if (isset($_smarty_tpl->tpl_vars['menus']->value)){?>
                <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                  <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->menu_id, ENT_QUOTES, 'UTF-8');?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->menu_id)&&($_smarty_tpl->tpl_vars['item']->value->menu_id==$_smarty_tpl->tpl_vars['c']->value->menu_id)){?> selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value->name, ENT_QUOTES, 'UTF-8');?>
</option>
                <?php } ?>
              <?php }?>
            </select>
          </td>



          
          <td class="param_short">
            <a href="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Templates" title="Перейти на страницу файлов шаблона в админпанели">Шаблоном</a>:
          </td>
          <td class="value" width="50%" title="Каким шаблоном отображать страницу категории (по умолчанию products.tpl)">
              <input class="edit" name="template[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['item']->value->template)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" />
          </td>



          
          <td class="param_short">
              Плагины:
          </td>
          <td class="value" title="Какие динамические плагины подключить на страницу категории (список классов модулей через запятую)">
              <input class="edit" name="objects[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" size="10" style="width: auto;" type="text" value="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['item']->value->objects)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" />
          </td>



          
          <td class="param_short" title="Разрешена ли категория к показу на сайте">
              <input class="checkbox" id="item_form_enabled" name="enabled[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->enabled)&&($_smarty_tpl->tpl_vars['item']->value->enabled==1)){?> checked<?php }?> value="1" />
              <span onclick="javascript: Toggle_PageCheckbox('item_form_enabled');">
                  Разрешена
              </span>
          </td>



          
          <td class="param_short" title="Разрешен ли экспорт категории в Яндекс.Маркет">
              <?php $_smarty_tpl->tpl_vars['mask'] = new Smarty_variable(1, null, 0);?>
              <?php $_smarty_tpl->tpl_vars['param'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['item']->value->ymarket)===null||$tmp==='' ? 0 : $tmp), null, 0);?>
              <?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['param']->value&$_smarty_tpl->tpl_vars['mask']->value, null, 0);?>
              <input class="checkbox" id="item_form_ymarket" name="ymarket[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][1]" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['value']->value){?> checked<?php }?> value="1" /> 

              <span onclick="javascript: Toggle_PageCheckbox('item_form_ymarket');">
                  Яндекс.Маркет
              </span>



              
              <div class="prices_edit_list" style="margin-left: -300px;">

                  
                  <div class="prices_edit_list_title">
                      и другие торговые площадки:

                      <a href="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
yandex.xml" target="_blank" title="Открыть канал в отдельном окне браузера">
                          канал 1
                      </a>
                  </div>

                  
                  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['items'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['items']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['name'] = 'items';
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = (int)2;
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] = is_array($_loop=33) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['items']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['items']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['items']['total']);
?>
                      <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['items']['index'], null, 0);?>
                      <?php $_smarty_tpl->tpl_vars['mask'] = new Smarty_variable($_smarty_tpl->tpl_vars['mask']->value*2, null, 0);?>

                      <div class="flaglist-item">
                          <?php $_smarty_tpl->tpl_vars['value'] = new Smarty_variable($_smarty_tpl->tpl_vars['param']->value&$_smarty_tpl->tpl_vars['mask']->value, null, 0);?>
                          <input class="checkbox" id="item_form_ymarket_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" name="ymarket[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['value']->value){?> checked<?php }?> value="1" /> 

                          
                          <span onclick="javascript: Toggle_PageCheckbox('item_form_ymarket_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
');">
                              канал <a href="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
yandex<?php echo $_smarty_tpl->tpl_vars['i']->value>1 ? (('_').($_smarty_tpl->tpl_vars['i']->value)) : '';?>
.xml" target="_blank" title="Открыть канал в отдельном окне браузера" onclick="event.cancelBubble = true; return true;">
                                        <?php echo $_smarty_tpl->tpl_vars['i']->value;?>

                                    </a>
                          </span>
                      </div>
                  <?php endfor; endif; ?>

                  <br style="clear: both;" />

                  
                  <a class="inline" href="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" onclick="jQuery(this).closest('.param_short').find('input.checkbox').each(function () { this.checked = false; }); return false;">
                      снять все
                  </a>

                  
                  <a class="inline" href="<?php echo htmlspecialchars(((($tmp = @$_smarty_tpl->tpl_vars['site']->value)===null||$tmp==='' ? '' : $tmp)), ENT_QUOTES, 'UTF-8');?>
" onclick="jQuery(this).closest('.param_short').find('input.checkbox').each(function () { this.checked = true; }); return false;">
                      установить все
                  </a>

              </div>
          </td>
        </tr>
      </table>

      <!-- Информация по изображениям -->
      <table align="center" cellpadding="0" cellspacing="10" class="white">
        <tr>
          <td class="param_high">
            Изображения:
            <?php if (isset($_smarty_tpl->tpl_vars['item']->value->images)&&!empty($_smarty_tpl->tpl_vars['item']->value->images)){?>
              <br><br><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Category&<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
=*&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE, ENT_QUOTES, 'UTF-8');?>
" onclick="javascript: if (confirm('Это действие удалит все изображения категории. Вы подтверждаете такую операцию?')) Delete_PageRecordImage('item_form', '*'); return false;" title="Удалить загруженные в категорию изображения">удалить все</a>
            <?php }?>
          </td>
          <td class="value_box">
            <?php if (!empty($_smarty_tpl->tpl_vars['id']->value)){?>
              <?php if (isset($_smarty_tpl->tpl_vars['item']->value->images)&&!empty($_smarty_tpl->tpl_vars['item']->value->images)){?>
                <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value->images; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["images"]['index']++;
?>
                  <div class="image">
                    <input class="checkbox" name="imageview[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="checkbox"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_view[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])&&($_smarty_tpl->tpl_vars['item']->value->images_view[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']]==1)){?> checked<?php }?> value="1" title="Будет ли это изображение использоваться в слайдере или вьювере изображений"><span><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
.</span><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/index.php?<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_SECTION, ENT_QUOTES, 'UTF-8');?>
=Category&<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ITEMID, ENT_QUOTES, 'UTF-8');?>
=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
=<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_VALUE_DELETEIMAGE, ENT_QUOTES, 'UTF-8');?>
" onclick="javascript: if (confirm('Это действие удалит указанное изображение категории. Вы подтверждаете такую операцию?')) Delete_PageRecordImage('item_form', <?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
); return false;">удалить</a><br><a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_CATEGORIES_CLASS_UPLOAD_FOLDER, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
" target="_blank"<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?> title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
"<?php }?>><img src="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_CATEGORIES_CLASS_UPLOAD_FOLDER, ENT_QUOTES, 'UTF-8');?>
<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_thumbs[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }else{ ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?>"></a>
                    <div>
                      <input name="image[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8');?>
">
                      заголовок (alt):<br>
                      <input name="imagealt[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" type="text" value="<?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_alts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }?>" title="Заголовок (всплывающая подсказка) этого изображения"><br>
                      описание:<br>
                      <textarea name="imagetext[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
][<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['images']['iteration'];?>
]" title="Описание этого изображения"><?php if (isset($_smarty_tpl->tpl_vars['item']->value->images_texts[$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['images']['index']])){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->images_texts[$_smarty_tpl->getVariable('smarty')->value['foreach']['images']['index']], ENT_QUOTES, 'UTF-8');?>
<?php }?></textarea>
                    </div>
                  </div>
                <?php } ?>
              <?php }?>
              <div style="clear: both;">
                <div class="newimage">
                  новое изображение (объемом не более <?php echo htmlspecialchars(sprintf("%d",(@IMAGE_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт):<br>
                  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo htmlspecialchars(sprintf("%d",@IMAGE_UPLOAD_MAXIMAL_FILESIZE), ENT_QUOTES, 'UTF-8');?>
">  <!-- Не позволяем загрузку файла объемом свыше заданного -->
                  <input class="edit" name="new_image[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="file" title="Какой файл изображения требуется взять с Вашего компьютера (объем файла не более <?php echo htmlspecialchars(sprintf("%d",(@IMAGE_UPLOAD_MAXIMAL_FILESIZE/1024)), ENT_QUOTES, 'UTF-8');?>
 Кбайт)"><br><br>
                  или из удаленного источника:<br>
                  <input class="edit" name="new_image_url[<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
]" type="text" value="http://" title="Какой файл изображения требуется взять с другого сайта в Интернете"><br><br>
                  дать файлу имя:<br>
                  <input class="edit" id="item_form_filename_<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGEFILENAME, ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой сделать начальную часть имени файла нового изображения на сайте (файл будет размещен в папке http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->categories_files_folder_prefix, ENT_QUOTES, 'UTF-8');?>
<?php echo htmlspecialchars(@ADMIN_CATEGORIES_CLASS_UPLOAD_FOLDER, ENT_QUOTES, 'UTF-8');?>
)"><br><br>
                  <input class="checkbox" id="item_form_imageview" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGEVIEW, ENT_QUOTES, 'UTF-8');?>
" type="checkbox" checked value="1" title="Будет ли это изображение использоваться в слайдере или вьювере изображений">
                  <span onclick="javascript: Toggle_PageCheckbox('item_form_imageview');" title="Будет ли это изображение использоваться в слайдере или вьювере изображений">
                    использовать в слайдере
                  </span>
                  <input class="submit" type="submit" value="Сохранить">
                </div>
                <div class="newimage_options">
                  заголовок (alt) изображения:<br>
                  <input class="edit" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGEALT, ENT_QUOTES, 'UTF-8');?>
" type="text" value="" title="Какой заголовок (всплывающую подсказку) дать новому изображению"><br>
                  описание:<br>
                  <textarea name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGETEXT, ENT_QUOTES, 'UTF-8');?>
" style="height: 105px;" title="Какое описание дать новому изображению"></textarea>
                </div>
              </div>
            <?php }else{ ?>
              <div class="hint">
                Управление изображениями станет доступным, когда эта категория будет создана.
              </div>
            <?php }?>
          </td>
        </tr>
      </table>

      <!--  -->
      <?php if (isset($_smarty_tpl->tpl_vars['from_page']->value)&&!empty($_smarty_tpl->tpl_vars['from_page']->value)){?>
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

      <!-- Добавляем пустой указатель номера изображения -->
      <input id="item_form_<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGENUMBER, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

      <!-- Добавляем случайный аутентификатор изображения -->
      <input name="<?php echo htmlspecialchars(@ACTION_REQUEST_PARAM_NAME_IMAGETOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo smarty_function_math(array('equation'=>'rand(1, 100000000)'),$_smarty_tpl);?>
">

      <!-- Добавляем пустой указатель требуемой команды -->
      <input id="item_form_<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_ACTION, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="">

      <!-- Добавляем аутентификатор операции -->
      <input name="<?php echo htmlspecialchars(@REQUEST_PARAM_NAME_TOKEN, ENT_QUOTES, 'UTF-8');?>
" type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['Token']->value, ENT_QUOTES, 'UTF-8');?>
">
    </form>



    
    <div class="help">
        <div class="title">
            Справка
        </div>

        <div>
            <b>Вложенность</b>. При необходимости категория может быть вложена подкатегорией в другие категории или их ветви.
        </div>



        <div>
            <b>Особый URL</b>. Любому виду URL разрешено включать в себя путевую структуру, то есть отделять части пути слешем /. Особый URL
            отличается отсутствием в начале адреса специального включения, идентифицирующего принадлежность адреса к разновидности контента - категории.
            Особым URL допустимо перекрываться с особыми URL других разновидностей контента сайта. В этом случае установлен следующий приоритет
            владения конфликтующим адресом: специальная страница, товар, категория, бренд, статья, новость.
        </div>



        <div>
            <b>Мета</b>. Эта информация используется в заголовке html-страницы категории. Подобно полю URL, мета информация при ее пустых полях
            автоматически заполняется из полей названия и описания категории, если это разрешено в соответствующих настройках сайта
            (изменить их можно на странице категорий в админпанели).
        </div>



        <div>
            <b>SEO текст</b>. Это произвольный фрагмент html-кода, который желают разместить обычно в нижней части страницы данной категории.
            Вполне может использоваться на странице категории как дополнительные сведения к ее основному описанию.
        </div>



        <div>
            <b>Информативная страница</b>. Разница между обычной категорией и имеющей такой признак заключается в способе вывода ее страницы.
            В первом случае выводится описание категории и следом список товаров в ней, во втором случае - только описание.
        </div>



        <div>
            <b>Плагины</b>. Если при просмотре пользователем страницы этой категории должно происходить подключение расширяющих функционал плагинов,
            необходимо выше в соответствующем поле перечислить через запятую классы их модулей (например: MyBanner, SubscribeForm). Тогда перед
            открытием страницы категории управление сначала будет передаваться плагинам в порядке их перечисления. Плагину разрешено выполнять
            любые действия, но результатом он возвращает либо замещающий категорию текст, либо каким фрагментом дополнить страницу этой категории.
        </div>



        <div>
            <b>Изображения</b>. В категорию допустимо загружать произвольное количество картинок. Они могут быть вставлены в текст описания, а могут
            просто располагаться на сайте для иных целей, например фотогалерея. Изображения могут быть загружены с локального компьютера или из
            удаленного источника (другого сайта). Каждому новому изображению возможно задать его заголовок (alt) - всплывающий текст при наведении
            курсора на картинку, описание - информирующий текст (может использоваться во вьюверах на клиентской стороне), имя файла - по умолчанию
            равно транслитерации названия категории. Имя файла нужно указывать без расширения, справа к имени автоматически добавится цифровой
            идентификатор и расширение. Если имя файла вообще не указано, оно генерируется системой.
        </div>



        <div>
            <b>Субдомен</b>. Если в адресных записях доменного имени сайта имеется запись, ссылающая субдомены на основной домен (то есть A-запись
            *.домен.сайта), тогда задав здесь левую часть имени субдомена и включив здесь же разрешение субдомена, можно получить виртуальный
            субдомен категории. Например левую часть субдомена задали как hello, в результате по адресу http://hello.сайт/ станет открываться
            страница отредактированной категории. При задании контента субдомена будет открываться страница именно с указанным контентом, иначе
            страница откроется в типичном оформлении сайта.
        </div>



        <div>
            <b>Шаблон</b>. По умолчанию для отрисовки страницы категории на клиентской 
            стороне сайта используется файл <i>products.tpl</i> из текущего шаблона. 
            Но движком поддерживается возможность для конкретной категории указать иной 
            htm- или tpl-файл, с помощью которого будет отрисована ее страница. При 
            отсутствии такого файла в шаблоне будет использован файл по умолчанию.
        </div>



        <div>
            <b>Яндекс.Маркет</b>. Эта связка из 32 флажков служит для указания, в каких из 
            файлов <i>http://сайт/yandex.xml</i>, <i>http://сайт/yandex_2.xml</i>, ..., 
            <i>http://сайт/yandex_32.xml</i> категория должна быть представлена. Каждый из таких 
            файлов считается отдельным каналом экспорта, причем все каналы отдают информацию 
            только в формате Яндекс.Маркета.
            <br><br>

            Кроме того, движком поддерживается слияние каналов. Например, нужно получить 
            экспорт того, что представлено в каналах 1, 5 и 8. Тогда обращаясь к файлу 
            <i>http://сайт/yandex_1_5_8.xml</i> получим желаемое.
        </div>
    </div>

  </div>

  <!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/tinymce.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('disabled_state'=>$_smarty_tpl->tpl_vars['settings']->value->categories_wysiwyg_disabled), 0);?>


  <!--  -->

  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/meta.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('form_id'=>"item_form",'item_id'=>$_smarty_tpl->tpl_vars['id']->value,'autofill'=>$_smarty_tpl->tpl_vars['settings']->value->categories_meta_autofill), 0);?>

<?php }} ?>