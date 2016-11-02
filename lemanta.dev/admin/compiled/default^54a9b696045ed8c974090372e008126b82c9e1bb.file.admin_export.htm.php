<?php /* Smarty version Smarty-3.1.8, created on 2016-09-11 23:50:28
         compiled from "../admin/design/default/html/admin_export.htm" */ ?>
<?php /*%%SmartyHeaderCode:78055441857d5c3949b8796-38585468%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54a9b696045ed8c974090372e008126b82c9e1bb' => 
    array (
      0 => '../admin/design/default/html/admin_export.htm',
      1 => 1462406590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78055441857d5c3949b8796-38585468',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'root_url' => 0,
    'admin_folder' => 0,
    'error' => 0,
    'Settings' => 0,
    'Token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d5c3949f6c52_87812598',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d5c3949f6c52_87812598')) {function content_57d5c3949f6c52_87812598($_smarty_tpl) {?>  <?php echo $_smarty_tpl->getSubTemplate ("../../common_parts/submenu.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('select'=>"export",'main'=>true,'imports'=>true,'export'=>true,'backup'=>true,'redirects'=>true,'mailer'=>true), 0);?>


  <div class="box">

    <!-- Выводим заголовок содержимого -->
    <h1>
      <div class="path">
        <a href="http://<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['admin_folder']->value, ENT_QUOTES, 'UTF-8');?>
/">Главная</a>
        → Экспорт
      </div>
      Экспорт
    </h1>

    <!-- Выводим инструментальные ссылки -->
    <div class="toolkey">
      &nbsp;
    </div>

    <!--  -->

    <?php if (!empty($_smarty_tpl->tpl_vars['error']->value)){?>
      <div class="error">
        <b>Ошибка:</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

      </div>
    <?php }?>

           <FORM name=import METHOD=POST enctype='multipart/form-data'>

					
					
					<div id="over">		
					<div id="over_left">	
							<table>
								<tr>
									<td class="model5">Формат</td>
									<td class="model"><p>
                                    <nobr><input onclick='show_params();' name='format' type="radio" class="checkbox" checked value='csv'/>CSV</nobr><br>									
                                   </td>
								</tr>
								<tr>
									<td class="model5">Кодировка</td>
									<td class="m_t"><p>
									<select name=charset  class="select2">
									  <option value='CP1251' <?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->file_export_charset)===null||$tmp==='' ? '' : $tmp)=='CP1251'){?>selected<?php }?>>Windows cp1251</option>
									  <option value='UTF8' <?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->file_export_charset)===null||$tmp==='' ? '' : $tmp)=='UTF8'){?>selected<?php }?>>UTF8</option>
									</select>
									</p></td>
								</tr>
							</table>							

					<input type=hidden name=token value='<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Token']->value)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
'>
			        <input type="submit" value="Скачать файл" class="submitx2"/>
					</div>					
					
					
			
					<div id="over_right">
						<div class="gray_block1" id='csv_params' name='params_div' style='display:none; font-size:12px;'>
						  
							<table>
								<tr>
									<td class="model5">Разделитель</td>
									<td class="m_t"><p>
									<select name=csv_delimiter class=select2>
									  <option value="	" <?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->csv_export_delimiter)===null||$tmp==='' ? '' : $tmp)=="\t"){?>selected<?php }?>>табуляция</option>
									  <option value=';' <?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->csv_export_delimiter)===null||$tmp==='' ? '' : $tmp)==";"){?>selected<?php }?>>точка с запятой (;)</option>
									  <option value=',' <?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->csv_export_delimiter)===null||$tmp==='' ? '' : $tmp)==","){?>selected<?php }?>>запятая (,)</option>
									  <option value='#' <?php if ((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->csv_export_delimiter)===null||$tmp==='' ? '' : $tmp)=="#"){?>selected<?php }?>>решетка (#)</option>
									</select>
								</tr>
								<tr>
									<td class="model5">Колонки</td>
									<td class="m_t"><p>									
									<a href="#" onclick='window.document.getElementById("csv_columns").value=""; window.document.getElementById("csv_columns").focus(); return false;' class='fr' style='color:black;'><img align=absmiddle alt='очистить все колонки' title='очистить все колонки' border=0 src="./images/clean.jpg" alt=""/>Очистить</a>
		                            </td>
								</tr>
								<tr>
									<td class="model5" colspan=2>
									<input name="csv_columns" id="csv_columns" value='<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['Settings']->value->csv_export_columns)===null||$tmp==='' ? '' : $tmp), ENT_QUOTES, 'UTF-8');?>
' type="text" class="inputimpcol" />
                                    </td>
								</tr>
							</table>
							<br>
							<p class='akt'>Колонки могут иметь следующие значения:</p>

							<table width=100
							  <tr>
							    <td width=120><a href='#'  onclick='return append_column("ctg");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> ctg</td>
							    <td>категория товара</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("brnd");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> brnd</td>
							    <td>бренд</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("name");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> name</td>
							    <td>название товара</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("opt");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> opt</td>
							    <td>вариант товара</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("sku");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> sku</td>
							    <td>артикул</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("prc");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> prc</td>
							    <td>цена</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("oprc");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> oprc</td>
							    <td>старая цена</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("qty");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> qty</td>
							    <td>количество на складе</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("ann");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> ann</td>
							    <td>краткое описание</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("dsc");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> dsc</td>
							    <td>полное описание</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("url");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> url</td>
							    <td>URL товара</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("mttl");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> mttl</td>
							    <td>meta title</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("mkwd");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> mkwd</td>
							    <td>meta keywords</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("mdsc");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> mdsc</td>
							    <td>meta description</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("enbld");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> enbld</td>
							    <td>Товар виден на сайта (0 или 1)</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("hit");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> hit</td>
							    <td>Популярный товар  (0 или 1)</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("simg");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> simg</td>
							    <td>Маленькое изображение (имя файла)</td>
							  </tr>
							  <tr>
							    <td><a href='#'  onclick='return append_column("limg");'><img alt='добавить колонку' title='добавить колонку' src='images/add_mini.gif' border=0 align=absmiddle></a> limg</td>
							    <td>Большое изображение (имя файла)</td>
							  </tr>
							</table>

						</div>
						<div class="gray_block1" id='shopscript_params' name='params_div' style='display:none;'>

						</div>
					</div>
				</div>
			</form>
  </div>

          
          <script>
           
            function show_params()
            {
              all_divs = document.getElementsByName('params_div');
		      for(i = 0; i < all_divs.length; i++) {
			    all_divs[i].style.display='none';
		      }
            
              var rbuttons = document.getElementsByName('format');
              for (i=0; i < rbuttons.length; i++)
              {
                if (rbuttons[i].checked)
                {
                  var format = rbuttons[i].value;
                }
              }

              div = window.document.getElementById(format+'_params');
              div.style.display='block';
            }
            
            function append_column(str)
            {
              input = window.document.getElementById("csv_columns");
              if(input.value == '')
                input.value = str;
              else
                input.value += ', '+str;
                
              input.scrollLeft=10000;
              return false;
            }
            show_params();
          
          </script>
          	<?php }} ?>