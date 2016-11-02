<?php /* Smarty version Smarty-3.1.8, created on 2016-09-13 15:45:21
         compiled from "/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/meta.htm" */ ?>
<?php /*%%SmartyHeaderCode:80431822457d7f4e17a6334-92110042%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ded593dd68e34a43c2ae9087d24f2ffc44e3dd36' => 
    array (
      0 => '/var/www/lemanta/data/www/lemanta.com/admin/design/common_parts/meta.htm',
      1 => 1462406573,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80431822457d7f4e17a6334-92110042',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'autofill' => 0,
    'form_id' => 0,
    'item_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57d7f4e17bd4f6_50793637',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d7f4e17bd4f6_50793637')) {function content_57d7f4e17bd4f6_50793637($_smarty_tpl) {?>

    <?php if ((($tmp = @$_smarty_tpl->tpl_vars['autofill']->value)===null||$tmp==='' ? false : $tmp)&&isset($_smarty_tpl->tpl_vars['form_id']->value)&&!empty($_smarty_tpl->tpl_vars['form_id']->value)&&isset($_smarty_tpl->tpl_vars['item_id']->value)){?>
        <script language="JavaScript" type="text/javascript">
            var form_id = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form_id']->value, ENT_QUOTES, 'UTF-8');?>
';
            var item_id = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item_id']->value, ENT_QUOTES, 'UTF-8');?>
';
            var meta_title_touched = true;
            var meta_keywords_touched = true;
            var meta_description_touched = true;
            var url_touched = true;
            var filename_touched = true;



            // генерация Meta Title
            //   заменяем на пробел все цепочки символов, кроме цифр, английских и русских букв
            //   удаляем лидирующий пробел
            //   удаляем замыкающий пробел
            //   возвращаем результат
            function Generate_MetaTitle(text) {
                var title = text.replace(/[^0-9a-zа-я]+/ig, ' ');
                title = title.replace(/^[\s]+/ig, '');
                title = title.replace(/[\s]+$/ig, '');
                return title;
            }



            // генерация Meta Keywords
            //   заменяем на пробел все цепочки символов, кроме цифр, английских и русских букв
            //   удаляем лидирующий пробел
            //   удаляем замыкающий пробел
            //   добавляем к пробелам запятую
            //   возвращаем результат
            function Generate_MetaKeywords(text) {
                var keywords = text.replace(/[^0-9a-zа-я]+/ig, ' ');
                keywords = keywords.replace(/^[\s]+/ig, '');
                keywords = keywords.replace(/[\s]+$/ig, '');
                keywords = keywords.replace(/[\s]+/ig, ', ');
                return keywords;
            }



            // генерация Meta Description
            //   заменяем на пробел все цепочки символов, кроме знаков препинания, цифр, английских и русских букв
            //   удаляем лидирующий пробел
            //   удаляем замыкающий пробел
            //   возвращаем результат
            function Generate_MetaDescription(text) {
                var description = text.replace(/[^,\.\-:;\?!\(\)0-9a-zа-я]+/ig, ' ');
                description = description.replace(/^[\s]+/ig, '');
                description = description.replace(/[\s]+$/ig, '');
                return description;
            }



            // генерация URL
            //   удаляем лидирующие пробелы
            //   удаляем замыкающие пробелы
            //   заменяем все пробелы, слеши, подчеркивания или их цепочки на символ подчеркивания
            //   удаляем из строки все символы, кроме подчеркивания, дефиса, точки, цифр, английских и русских букв
            //   заменяем все подчеркивания или их цепочки на дефис
            //   убираем дефисы в конце строки
            //   возвращаем результат
            function Generate_PageURL(name) {
                var url = name.replace(/^[\s]+/ig, '');
                url = url.replace(/[\s]+$/ig, '');
                url = url.replace(/[\s_\/\\]+/ig, '_');
                url = url.replace(/[^_0-9a-zа-я\.\-]+/ig, '');
                url = url.replace(/[_]+/ig, '-');
                url = url.replace(/-+$/ig, '');
                url = Translit_PageURL(url);
                return url;
            }



            // транслитерация URL
            //   меняем русские буквы на английские аналоги
            //   возвращаем результат
            function Translit_PageURL(name) {
                var rus = new Array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё',  'Ж',  'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч',  'Ш',  'Щ',    'Ъ', 'Ы', 'Ь', 'Э', 'Ю',  'Я',  'а', 'б', 'в', 'г', 'д', 'е', 'ё',  'ж',  'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч',  'ш',  'щ',    'ъ', 'ы', 'ь', 'э', 'ю',  'я');
                var eng = new Array('A', 'B', 'V', 'G', 'D', 'E', 'YO', 'ZH', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'CH', 'SH', 'SHCH', '',  'Y', '',  'E', 'YU', 'YA', 'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '',  'y', '',  'e', 'yu', 'ya');
                var alen = rus.length;
                var nlen = name.length;
                var url = '';
                var c = '';
                for (var i = 0; i < nlen; i++) {
                    c = name.charAt(i, 1);
                    for (j = 0; j < alen; j++) {
                        if (c == rus[j]) {
                            url += eng[j];
                            c = '';
                            break;
                        }
                    }
                    url += c;
                }
                return url;
            }



            // генерация Meta информации
            //   если нашли форму,
            //     берем текст названия элемента
            //     генерируем по нему url, meta title, meta keywords, если этих полей не касались
            //     берем текст описания элемента
            //     удаляем из текста html-теги, &nbsp; заменяем на пробел
            //     генерируем по тексту meta description
            function Set_MetaTags () {
                var object = document.getElementById(form_id);
                if (typeof(object) == 'object' && object != null) {

                    var name = '';
                    object = document.getElementById(form_id + '_name_' + item_id);
                    if (typeof(object) == 'object' && object != null) {

                        name = object.value;

                        if (!url_touched) {
                            object = document.getElementById(form_id + '_url_' + item_id);
                            if (typeof(object) == 'object' && object != null) object.value = Generate_PageURL(name);
                        }

                        if (!filename_touched) {
                            object = document.getElementById(form_id + '_filename_' + item_id);
                            if (typeof(object) == 'object' && object != null) object.value = Generate_PageURL(name);
                        }

                        if (!meta_title_touched) {
                            object = document.getElementById(form_id + '_meta_title_' + item_id);
                            if (typeof(object) == 'object' && object != null) object.value = Generate_MetaTitle(name);
                        }

                        if (!meta_keywords_touched) {
                            object = document.getElementById(form_id + '_meta_keywords_' + item_id);
                            if (typeof(object) == 'object' && object != null) object.value = Generate_MetaKeywords(name);
                        }
                    }

                    if (!meta_description_touched) {
                        object = document.getElementById(form_id + '_description_' + item_id);
                        if (typeof(object) == 'object' && object != null) {
                            if (typeof(tinyMCE) == 'object') {
                                var text = tinyMCE.get(form_id + '_description_' + item_id).getContent();
                            } else {
                                var text = object.value;
                            }

                            object = document.getElementById(form_id + '_meta_description_' + item_id);
                            if (typeof(object) == 'object' && object != null) {
                                text = text.replace(/(<([^>]+)>)/ig, ' ');
                                text = text.replace(/(\&nbsp;)/ig, ' ');
                                object.value = Generate_MetaDescription((name != '' ? name + ' - ' : '') + text);
                            }
                        }
                    }
                }
            }



            // запуск генерации Meta информации
            function Start_MetaGeneration () {
                var object = document.getElementById(form_id);
                if (typeof(object) == 'object' && object != null) {

                    var name = '';
                    object = document.getElementById(form_id + '_name_' + item_id);
                    if (typeof(object) == 'object' && object != null) {

                        Set_EventFunction(object, 'keyup',  Set_MetaTags);
                        Set_EventFunction(object, 'change', Set_MetaTags);
                        name = object.value;

                        object = document.getElementById(form_id + '_url_' + item_id);
                        if (typeof(object) == 'object' && object != null) {
                            Set_EventFunction(object, 'change', function () {
                                url_touched = this.value.replace(/^[\s]+/ig, '') != '';
                            });
                            url_touched = object.value.replace(/^[\s]+/ig, '') != ''
                                       && object.value != Generate_PageURL(name);
                        }

                        object = document.getElementById(form_id + '_filename_' + item_id);
                        if (typeof(object) == 'object' && object != null) {
                            Set_EventFunction(object, 'change', function () {
                                filename_touched = this.value.replace(/^[\s]+/ig, '') != '';
                            });
                            filename_touched = object.value.replace(/^[\s]+/ig, '') != ''
                                            && object.value != Generate_PageURL(name);
                            if (!filename_touched) object.value = Generate_PageURL(name);
                        }

                        object = document.getElementById(form_id + '_meta_title_' + item_id);
                        if (typeof(object) == 'object' && object != null) {
                            Set_EventFunction(object, 'change', function () {
                                meta_title_touched = this.value.replace(/^[\s]+/ig, '') != '';
                            });
                            meta_title_touched = object.value.replace(/^[\s]+/ig, '') != ''
                                              && object.value != Generate_MetaTitle(name);
                        }

                        object = document.getElementById(form_id + '_meta_keywords_' + item_id);
                        if (typeof(object) == 'object' && object != null) {
                            Set_EventFunction(object, 'change', function () {
                                meta_keywords_touched = this.value.replace(/^[\s]+/ig, '') != '';
                            });
                            meta_keywords_touched = object.value.replace(/^[\s]+/ig, '') != ''
                                                 && object.value != Generate_MetaKeywords(name);
                        }
                    }

                    object = document.getElementById(form_id + '_description_' + item_id);
                    if (typeof(object) == 'object' && object != null) {
                        var text = '';
                        if (typeof(tinyMCE) == 'object') {
                            object = tinyMCE.get(form_id + '_description_' + item_id);
                            if (typeof(object) == 'object') {
                                object.onChange.add(Set_MetaTags);
                                object.onKeyUp.add(Set_MetaTags);
                                text = object.getContent();
                            }
                        } else {
                            Set_EventFunction(object, 'keyup',  Set_MetaTags);
                            Set_EventFunction(object, 'change', Set_MetaTags);
                            text = object.value;
                        }

                        object = document.getElementById(form_id + '_meta_description_' + item_id);
                        if (typeof(object) == 'object' && object != null) {
                            text = text.replace(/(<([^>]+)>)/ig, ' ');
                            text = text.replace(/(\&nbsp;)/ig, ' ');
                            Set_EventFunction(object, 'change', function () {
                                meta_description_touched = this.value.replace(/^[\s]+/ig, '') != '';
                            });
                            meta_description_touched = object.value.replace(/^[\s]+/ig, '') != ''
                                                    && object.value != Generate_MetaDescription((name != '' ? name + ' - ' : '') + text);
                        }
                    }
                }
            }



            // назначение обрабатываюшей функции
            //   входные параметры:
            //     target = какому объекту
            //     eventName = для какого события
            //     func = какую функцию назначить
            function Set_EventFunction ( target, eventName, func ) {
                if (target.addEventListener) target.addEventListener(eventName, func, false);
                else if (target.attachEvent) target.attachEvent('on' + eventName, func);
                else target['on' + eventName] = func;
            }



            // запускаем генерацию Meta информации
            if (window.attachEvent) {
                window.attachEvent('onload', function () {
                    setTimeout('Start_MetaGeneration();', 1000);
                });
            } else if (window.addEventListener) {
                window.addEventListener('DOMContentLoaded', Start_MetaGeneration, false);
            } else {
                document.addEventListener('DOMContentLoaded', Start_MetaGeneration, false);
            }
        </script>
    <?php }?>
<?php }} ?>