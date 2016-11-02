{* <!--
  Impera CMS: субшаблон Autocomplete search
  Версия: 1.3
  Автор: Разработчик Impera CMS
  Сайт автора: http://imperacms.ru
               http://aimatrix.itak.info

  Принимает во входных параметрах:
    $input_id = выражение DOM-поиска поля ввода, которое надо снабдить
                автозавершителем поиска
    $width = ширина блока выпадающих подсказок (по умолчанию равна
             ширине поля ввода)
    $height = предельная высота блока выпадающих подсказок (по умолчанию 350)

    $product_maxcount = предельное число отбираемых товаров (по умолчанию 8)
    $product_show_metatitle = булевой признак "показывать мета заголовок страницы товара, иначе название товара"
    $product_show_image = булевой признак "показывать ли картинку товара"
    $product_show_price = булевой признак "показывать ли цену товара"
    $product_show_id = булевой признак "показывать ли идентификатор товара"
    $product_show_pcode = булевой признак "показывать ли буквенный код товара"
    $product_show_sku = булевой признак "показывать ли артикул варианта товара"
    $product_by_model = булевой признак "искать по полю названия товара и уточняющего названия варианта товара"
    $product_by_metatitle = булевой признак "искать по полю мета заголовка страницы товара"
    $product_by_metakeywords = булевой признак "искать по полю мета ключевых слов страницы товара"
    $product_by_body = булевой признак "искать по полю описания товара"
    $product_by_tags = булевой признак "искать по полю тегов товара"
    $product_by_barcode = булевой признак "искать по полю штрихкода"
    $product_by_pcode = булевой признак "искать по полю буквенного кода (vendorCode) товара"
    $product_by_sku = булевой признак "искать по полю артикула варианта товара"

    $category_maxcount = предельное число отбираемых категорий (по умолчанию 0)
    $category_show_metatitle = булевой признак "показывать мета заголовок страницы категории, иначе название категории"
    $category_show_image = булевой признак "показывать ли картинку категории"
    $category_by_name = булевой признак "искать по полю названия категории"
    $category_by_metatitle = булевой признак "искать по полю мета заголовка страницы категории"
    $category_by_metakeywords = булевой признак "искать по полю мета ключевых слов страницы категории"
    $category_by_body = булевой признак "искать по полю описания категории"
    $category_by_tags = булевой признак "искать по полю тегов категории"

    $brand_maxcount = предельное число отбираемых брендов (по умолчанию 0)
    $brand_show_metatitle = булевой признак "показывать мета заголовок страницы бренда, иначе название бренда"
    $brand_show_image = булевой признак "показывать ли картинку категории"
    $brand_by_name = булевой признак "искать по полю названия бренда"
    $brand_by_metatitle = булевой признак "искать по полю мета заголовка бренда"
    $brand_by_metakeywords = булевой признак "искать по полю мета ключевых слов бренда"
    $brand_by_body = булевой признак "искать по полю описания бренда"
    $brand_by_tags = булевой признак "искать по полю тегов бренда"

    $onselect = имя вашей js-функции, которая будет обслуживает клик по найденной позиции

    $link_css = булевой признак "самостоятельно подключить свои стили"
                (по умолчанию true)
    $link_engine = булевой признак "самостоятельно подключить свой скрипт"
                   (по умолчанию true)

  Использует переменные движка:
    $site = полный url корневой папки сайта

  Подключение из своего шаблона:
    {include file = "../../common_parts/Autocomplete-search/main.tpl"
             input_id = строка DOM-поиска поля ввода
             width = число от 1 и выше
             height = число от 1 и выше

             product_maxcount = число от 0 и выше
             product_show_metatitle = true или false
             product_show_image = true или false
             product_show_price = true или false
             product_show_id = true или false
             product_show_pcode = true или false
             product_show_sku = true или false
             product_by_model = true или false
             product_by_metatitle = true или false
             product_by_metakeywords = true или false
             product_by_body = true или false
             product_by_tags = true или false
             product_by_barcode = true или false
             product_by_pcode = true или false
             product_by_sku = true или false

             category_maxcount = число от 0 и выше
             category_show_metatitle = true или false
             category_show_image = true или false
             category_by_name = true или false
             category_by_metatitle = true или false
             category_by_metakeywords = true или false
             category_by_body = true или false
             category_by_tags = true или false

             brand_maxcount = число от 0 и выше
             brand_show_metatitle = true или false
             brand_show_image = true или false
             brand_by_name = true или false
             brand_by_metatitle = true или false
             brand_by_metakeywords = true или false
             brand_by_body = true или false
             brand_by_tags = true или false

             link_css = true или false
             link_engine = true или false}

  ============================================================================ --> *}{strip}

    {* <!-- если получена строка DOM-поиска поля ввода --> *}
    {if isset($input_id) && is_string($input_id)}

        {* <!-- если строка DOM-поиска поля ввода непустая --> *}
        {$input_id = $input_id|regex_replace:'/\s/':''}
        {if $input_id != ''}



            {* <!-- готовим стилевой путь --> *}
            {$autocomplete_search_common = (($site|default:'')|cat:'design/common/Autocomplete-search/')|escape}



            {* <!-- если позволили подключить стили --> *}
            {if !isset($link_css) || $link_css}

                {* <!-- подключаем стили каталога --> *}
                <link href="{$autocomplete_search_common}style.css" rel="stylesheet" type="text/css" />

            {/if}



            {* <!-- если позволили подключить движковую часть (скрипты) --> *}
            {if !isset($link_engine) || $link_engine}

                {* <!-- подключаем скрипт автозавершителя --> *}
                <script src="{$autocomplete_search_common}jquery.autocomplete-min.js" language="JavaScript" type="text/javascript"></script>

            {/if}



            {* <!-- запускаем автозавершитель поиска --> *}
            <script language="JavaScript" type="text/javascript">

                {$onselect = $onselect|default:''}
                {$onselect = $onselect|regex_replace:'/[^a-z0-9_]/i':''}
                {$onselect = $onselect|regex_replace:'/^[^a-z]+/i':''}
                jQuery(window).load(function () {
                                        jQuery('{$input_id|escape}').autocomplete({ serviceUrl: '{$autocomplete_search_common}search.php',

                                                                                    minChars: 2,
                                                                                    delimiter: '',
                                                                                    deferRequestBy: 50,
                                                                                    highlight: true,
                                                                                    autoSubmit: false,
                                                                                    noCache: false,



                                                                                    {if $width|default:0 > 0}
                                                                                        width: {$width|string_format:'%d'},
                                                                                    {/if}



                                                                                    maxHeight: {if $height|default:0 > 0}
                                                                                                   {$height|string_format:'%d'}
                                                                                               {else}
                                                                                                   350
                                                                                               {/if},



                                                                                    params: { product_maxcount:        {if $product_maxcount|default:8 > 0} {$product_maxcount|default:8|string_format:'%d'} {else} 0 {/if},
                                                                                              product_show_metatitle:  {if $product_show_metatitle|default:false === true} true {else} false {/if},
                                                                                              product_by_model:        {if isset($product_by_model) && $product_by_model} true {else} false {/if},
                                                                                              product_by_metatitle:    {if $product_by_metatitle|default:false === true} true {else} false {/if},
                                                                                              product_by_metakeywords: {if $product_by_metakeywords|default:false === true} true {else} false {/if},
                                                                                              product_by_body:         {if $product_by_body|default:false === true} true {else} false {/if},
                                                                                              product_by_tags:         {if $product_by_tags|default:false === true} true {else} false {/if},
                                                                                              product_by_barcode:      {if $product_by_barcode|default:false === true} true {else} false {/if},
                                                                                              product_by_pcode:        {if $product_by_pcode|default:false === true} true {else} false {/if},
                                                                                              product_by_sku:          {if $product_by_sku|default:false === true} true {else} false {/if},

                                                                                              category_maxcount:        {if $category_maxcount|default:0 > 0} {$category_maxcount|string_format:'%d'} {else} 0 {/if},
                                                                                              category_show_metatitle:  {if $category_show_metatitle|default:false === true} true {else} false {/if},
                                                                                              category_by_name:         {if $category_by_name|default:false === true} true {else} false {/if},
                                                                                              category_by_metatitle:    {if $category_by_metatitle|default:false === true} true {else} false {/if},
                                                                                              category_by_metakeywords: {if $category_by_metakeywords|default:false === true} true {else} false {/if},
                                                                                              category_by_body:         {if $category_by_body|default:false === true} true {else} false {/if},
                                                                                              category_by_tags:         {if $category_by_tags|default:false === true} true {else} false {/if},

                                                                                              brand_maxcount:        {if $brand_maxcount|default:0 > 0} {$brand_maxcount|string_format:'%d'} {else} 0 {/if},
                                                                                              brand_show_metatitle:  {if $brand_show_metatitle|default:false === true} true {else} false {/if},
                                                                                              brand_by_name:         {if $brand_by_name|default:false === true} true {else} false {/if},
                                                                                              brand_by_metatitle:    {if $brand_by_metatitle|default:false === true} true {else} false {/if},
                                                                                              brand_by_metakeywords: {if $brand_by_metakeywords|default:false === true} true {else} false {/if},
                                                                                              brand_by_body:         {if $brand_by_body|default:false === true} true {else} false {/if},
                                                                                              brand_by_tags:         {if $brand_by_tags|default:false === true} true {else} false {/if}
                                                                                            },



                                                                                    onSelect: function (suggested, data) {
                                                                                                 if (data['url'] && (data['url'] != '')) {
                                                                                                      {if $onselect == ''}
                                                                                                          document.location = data['url'];
                                                                                                      {else}
                                                                                                          try {
                                                                                                              var object = jQuery('{$input_id|escape}');
                                                                                                              if ((typeof(object) == 'object') && (object != null)
                                                                                                              && ('length' in object) && (object.length > 0)) object = object[0];
                                                                                                              {$onselect|escape}(object, suggested, data);
                                                                                                          } catch (e) { }
                                                                                                      {/if}
                                                                                                  } else {
                                                                                                      {if $onselect == ''}
                                                                                                          jQuery('{$input_id|escape}').closest('form').submit();
                                                                                                      {/if}
                                                                                                  }
                                                                                              },



                                                                                    fnFormatResult: function (suggested, data, query) {
                                                                                                        var pattern = '';

                                                                                                        query = query.replace(new RegExp('[^a-z0-9а-яё]+', 'gi'), ' ');
                                                                                                        query = query.replace(new RegExp('^\\s*(.*?)\\s*$', 'gi'), '$1');
                                                                                                        query = query.split(' ');

                                                                                                        var reEscape = new RegExp('(\\' + ['/',
                                                                                                                                           '.',
                                                                                                                                           '*',
                                                                                                                                           '+',
                                                                                                                                           '?',
                                                                                                                                           '|',
                                                                                                                                           '(',
                                                                                                                                           ')',
                                                                                                                                           '[',
                                                                                                                                           ']',
                                                                                                                                 {literal} '{',
                                                                                                                                           '}', {/literal}
                                                                                                                                           '\\'].join('|\\') + ')', 'g');
                                                                                                        for (var i = 0; i < query.length; i++) {
                                                                                                            pattern = '(' + query[i].replace(reEscape, '\\$1') + ')';
                                                                                                            pattern = new RegExp(pattern, 'gi');
                                                                                                            suggested = suggested.replace(pattern, '<*>$1<\/*>');
                                                                                                            if (data['pcode'] && (data['pcode'] != '')) data['pcode'] = data['pcode'].replace(pattern, '<*>$1<\/*>');
                                                                                                            if (data['sku'] && (data['sku'] != '')) data['sku'] = data['sku'].replace(pattern, '<*>$1<\/*>');
                                                                                                        }

                                                                                                        pattern = new RegExp('<(/?)\\*>', 'g');
                                                                                                        suggested = suggested.replace(pattern, '<$1strong>');
                                                                                                        if (data['pcode'] && (data['pcode'] != '')) data['pcode'] = data['pcode'].replace(pattern, '<$1strong>');
                                                                                                        if (data['sku'] && (data['sku'] != '')) data['sku'] = data['sku'].replace(pattern, '<$1strong>');

                                                                                                        if (data['type'] && (data['type'] == 'category')) {
                                                                                                            suggested = '<span class="remark">' +
                                                                                                                            'категория: &nbsp;' +
                                                                                                                        '</span>' +
                                                                                                                        suggested;
                                                                                                        }

                                                                                                        if (data['type'] && (data['type'] == 'brand')) {
                                                                                                            suggested = '<span class="remark">' +
                                                                                                                            'бренд: &nbsp;' +
                                                                                                                        '</span>' +
                                                                                                                        suggested;
                                                                                                        }

                                                                                                        if (data['type'] && (data['type'] == 'category') && (1 == {if $category_show_image|default:false === true} 1 {else} 0 {/if})
                                                                                                        || data['type'] && (data['type'] == 'brand') && (1 == {if $brand_show_image|default:false === true} 1 {else} 0 {/if})
                                                                                                        || (!data['type'] || (data['type'] == 'product')) && (1 == {if $product_show_image|default:false === true} 1 {else} 0 {/if})) {
                                                                                                            if (data['image'] && (data['image'] != '')) {
                                                                                                                suggested = '<img src="' + data['image'] + '" />' +
                                                                                                                            suggested;
                                                                                                            }
                                                                                                        }

                                                                                                        {if $product_show_price|default:false === true}
                                                                                                            if (data['price'] && (data['price'] != '')) {
                                                                                                                suggested = '<span class="price">' +
                                                                                                                                data['price'] +
                                                                                                                            '</span>' +
                                                                                                                            suggested;
                                                                                                            }
                                                                                                        {/if}
                                                                                                        suggested += '<br>';

                                                                                                        {if $product_show_pcode|default:false === true}
                                                                                                            if (data['pcode'] && (data['pcode'] != '')) {
                                                                                                                suggested += '<span class="pcode">' +
                                                                                                                                 'код: ' + data['pcode'] +
                                                                                                                             '</span>';
                                                                                                            }
                                                                                                        {/if}

                                                                                                        {if $product_show_sku|default:false === true}
                                                                                                            if (data['sku'] && (data['sku'] != '')) {
                                                                                                                suggested += '<span class="sku">' +
                                                                                                                                 'артикул: ' + data['sku'] +
                                                                                                                             '</span>';
                                                                                                            }
                                                                                                        {/if}

                                                                                                        {if $product_show_id|default:false === true}
                                                                                                            if (data['product_id'] && (data['product_id'] != '')) {
                                                                                                                suggested += '<span class="product_id">' +
                                                                                                                                 'идентификатор: ' + data['product_id'] +
                                                                                                                             '</span>';
                                                                                                            }
                                                                                                        {/if}

                                                                                                        if (data['url'] && (data['url'] != '')) {
                                                                                                            suggested = '<a href="' + data['url'] + '" onclick="{if $onselect == ''}event.cancelBubble = true;{else}return false;{/if}">' +
                                                                                                                            suggested +
                                                                                                                        '</a>';
                                                                                                        }

                                                                                                        return suggested;
                                                                                                    }
                                                                                  });
                                    });
            </script>

        {/if}

    {/if}

{/strip}