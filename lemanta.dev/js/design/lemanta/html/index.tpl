{* <!-- ===========================================================================
                                                                                  |
    Макет: Общий вид сайта.                                                       |
    ----------------------------------------------------------------------------  |
                                                                                  |
    Входные переменные:                                                           |
        $content = html-контент страницы, сгенерированный основным модулем        |
        $emulator = объект хелпера шаблона                                        |
                                                                                  |
============================================================================ --> *}{strip}

    {* <!-- =======================================================================
    |                                                                             |
    |  Проверяем неучтенные случаи "Ошибка 404".                                  |
    |                                                                             |
    ======================================================================== --> *}

    {include 'common/check404.htm'}

    {* <!-- =======================================================================
    |                                                                             |
    |  Проверка неучтенного случая "Страница неопределенного заказа".             |
    |                                                                             |
    ======================================================================== --> *}

    {requestUri except='*' nopages=TRUE assign=uri}
    {if $uri == '/order'}
        {include 'missing_template.htm' assign=content}
    {/if}

    {if !empty($ajax)}
        {content}
    {else}

        {* <!-- ===================================================================
        |                                                                         |
        |  Непосредственно разметка.                                              |
        |                                                                         |
        ==================================================================== --> *}



        <!DOCTYPE html>
        <html lang="ru">
            <head>
                <base href="{site}" />
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1" />

                <meta name="yandex-verification" content="75ad42e7ae6fdd59" />
                <meta name="wmail-verification" content="39837394554e84e8be3cef1d21f85532" />

                {* <!-- ===========================================================
                |                                                                 |
                |  Заголовочная информация.                                       |
                |                                                                 |
                ============================================================ --> *}

                {$seoPagenum1 = ''}
                {$seoPagenum2 = ''}
                {if !empty($CurrentPage)}
                    {$seoPagenum1 = $CurrentPage + 1}
                    {$seoPagenum1 = " | Страница $seoPagenum1"}
                    {$seoPagenum2 = $CurrentPage + 1}
                    {$seoPagenum2 = " Страница $seoPagenum2"}
                {/if}

                <title>
                    {title}
                    {$seoPagenum1}
                </title>
                <meta content="{metaDescription}{$seoPagenum2}" name="description" />
                <meta content="{metaKeywords}" name="keywords" />

                {* <!-- ===========================================================
                |                                                                 |
                |  Ярлыковая иконка.                                              |
                |                                                                 |
                ============================================================ --> *}

                <link href="{theme}images/favicon.ico" rel="shortcut icon" />

                {* <!-- ===========================================================
                |                                                                 |
                |  Метка генератора страницы.                                     |
                |                                                                 |
                ============================================================ --> *}

                <meta name="generator" content="Impera CMS {version} ({versionYMD})" />

                {* <!-- ===========================================================
                |                                                                 |
                |  Модуль Canonizator (если присутствует в шаблоне):              |
                |      noCanonical = TRUE если отключить канонизацию страниц      |
                |          noIndex = TRUE если убрать из SERPа неканонические стр.|
                |      noPagination = TRUE если отключить мета пагинацию          |
                |          noPrefetch = TRUE если отключить ускорение пагинации   |
                |      noSyndication = TRUE если отключить синдикацию RSS канала  |
                |                                                                 |
                ============================================================ --> *}

                {$mod = 'mod-canonizator.htm'}
                {if $emulator->existsModule($mod)}
                    {include "$mod"
                              noCanonical = FALSE
                                  unCivil = TRUE
                                      unCivilAny = TRUE
                                  noIndex = FALSE
                              noPagination = FALSE
                                  noPrefetch = FALSE
                              noSyndication = TRUE}
                {/if}

                {* <!-- ===========================================================
                |                                                                 |
                |  Стили.                                                         |
                |                                                                 |
                ============================================================ --> *}

                <link href="{theme}css/style.css" rel="stylesheet" />

                {* <!-- ===========================================================
                |                                                                 |
                |  Скрипты.                                                       |
                |                                                                 |
                ============================================================ --> *}

                <script>
                    var thisTemplateRootUrl = '{theme}';
                </script>
                <script src="{theme}js/script.js"></script>

                {* <!-- ===========================================================
                |                                                                 |
                |  Основной модуль мог попросить добавить некоторые мета-теги.    |
                |                                                                 |
                ============================================================ --> *}

                {echoVar from=meta}

                {* <!-- ===========================================================
                |                                                                 |
                |  Микроразметка организации.                                     |
                |                                                                 |
                ============================================================ --> *}

                <script type="application/ld+json">
                    { {**}
                        "@context" : "http://schema.org", {**}
                        "@type" : "Organization", {**}
                        "url" : "{site}", {**}
                        "contactPoint" : [ {  {**}
                                "@type" : "ContactPoint", {**}
                                "telephone" : "+38-098-053-22-23", {**}
                                "contactType" : "customer service" {**}
                            } ] } {**}
                </script>
            </head>

            <body>

                {* <!-- ===========================================================
                |                                                                 |
                |  Модуль Google Tag Manager (если присутствует в шаблоне):       |
                |      trackOrder = TRUE если отслеживать заказы                  |
                |      trackCart = TRUE если отслеживать изменения корзины        |
                |      trackDefer = TRUE если отслеживать изменения отложенных    |
                |      startManager = TRUE если подключить диспетчер тегов        |
                |          gtmID = идентификатор аккаунта в Google Tag Manager    |
                |      final = TRUE если разрешаем запустить слежение             |
                |                                                                 |
                ============================================================ --> *}

                {$mod = 'mod-google-tag-manager.htm'}
                {if $emulator->existsModule($mod)}
                    {include "$mod"
                              trackOrder = TRUE
                                  baseOnly = TRUE
                              trackCart = TRUE
                              trackDefer = TRUE
                              startManager = TRUE
                                 gtmID = 'GTM-K97JKH'
                              final = TRUE}
                {/if}

                {* <!-- ===========================================================
                |                                                                 |
                |  Большой слайдер (если это специальная страница, бренд или      |
                |  категория с подгруженными фотографиями).                       |
                |                                                                 |
                ============================================================ --> *}

                {if !empty($section)}
                    {$item = $section}
                    {$type = 'section'}
                {elseif !empty($brand)}
                    {$item = $brand|default:$category|default:FALSE}
                    {$type = 'brand'}
                {elseif !empty($category)}
                    {$item = $category}
                    {$type = 'category'}
                {else}
                    {$item = FALSE}
                {/if}
                {if !empty($item->images)}
                    <div class="skdslider slider" id="slider">
                        <div class="sh"></div>
                        <ul>
                            {$number = 0}
                            {section name=images loop=1000}
                                {$number = $number + 1}

                                {findImage type=$type num=$number assign=image}
                                {if empty($image.found)}
                                    {break}
                                {/if}

                                <li>
                                    <img src="{$image.url}" alt="" />

                                    {if !empty($image.alt) || !empty($image.desc)}
                                        <div class="slide-desc">
                                            {if !empty($image.alt)}<h2>{$image.alt}</h2>{/if}
                                            {if !empty($image.desc)}<p>{$image.desc}</p>{/if}
                                        </div>
                                    {/if}
                                </li>
                            {/section}
                        </ul>
                    </div>
                {/if}

                {* <!-- ===========================================================
                |                                                                 |
                |  Шапка.                                                         |
                |                                                                 |
                ============================================================ --> *}

                <div class="bg">
                    <div class="line"></div>
                    <div class="container">
                        <div class="header">

                            {* <!-- ===============================================
                            |                                                     |
                            |  Ссылка на Аккаунт (если это авторизованный клиент).|
                            |                                                     |
                            ================================================ --> *}

                            <div class="container">
                                <div class="login">
                                    {if !empty($user)}
                                        <span id="username">
                                            <a href="account" rel="nofollow">
                                                {echoVar from='user->compound_name'}
                                            </a>
                                            {if !empty($group->discount)}
                                                , ваша скидка &mdash; {$group->discount}%
                                            {/if}
                                        </span>

                                        &nbsp;&nbsp;|&nbsp;&nbsp;

                                        <a id="logout" href="logout" rel="nofollow">
                                            Выйти
                                        </a>

                                    {* <!-- =======================================
                                    |                                             |
                                    |  Иначе ссылка на Вход (если неавторизован). |
                                    |                                             |
                                    ======================================== --> *}

                                    {else}
                                        <a id="login" href="login" rel="nofollow">
                                            Вход
                                        </a>

                                        &nbsp;&nbsp;|&nbsp;&nbsp;

                                        <a id="register" href="registration" rel="nofollow">
                                            Регистрация
                                        </a>
                                    {/if}
                                </div>

                                {* <!-- ===========================================
                                |                                                 |
                                |  Социальные ссылки.                             |
                                |                                                 |
                                ============================================ --> *}

                                <div class="soc">
                                    <a href="skype:lemanta2014?call" rel="nofollow">
                                        <img src="{theme}images/soc1.png" alt="Lemanta Skype" />
                                    </a>

                                    <a href="http://vkontakte.ru/share.php?url=http://lemanta.com" target="_blank" rel="nofollow">
                                        <img src="{theme}images/soc2.png" alt="Lemanta ВКонтакте" />
                                    </a>
                                  <a href="https://www.instagram.com/lemanta8465/" target="_blank" rel="nofollow">
                                        <img src="{theme}images/instagram.png" alt="Lemanta в Instagram" />
                                    </a>
                                  <a href="https://www.facebook.com/Lemanta-280572415630549/" target="_blank" rel="nofollow">
                                        <img src="{theme}images/FB-f-Logo__blue_29.png" alt="Lemanta в Facebook" />
                                    </a>
                                </div>

                                {* <!-- ===========================================
                                |                                                 |
                                |  Выбор валюты (если их больше одной).           |
                                |                                                 |
                                ============================================ --> *}

                                {if !empty($currencies) && count($currencies) > 1}
                                    <div class="lang">
                                        {echoVar from='currency->currency_id' assign=sid}
                                        {foreach $currencies as $item}
                                            {echoVar from='item->currency_id' assign=id}
                                            {$class = ($sid === $id) ? 'class="selected"' : ''}

                                            <a onclick="changeCurrency('{$id|escape}')" {$class}>
                                                {name}
                                            </a>
                                        {/foreach}

                                        {* <!-- ===================================
                                        |                                         |
                                        |  Скрытая форма для смены валюты.        |
                                        |                                         |
                                        ==================================== --> *}

                                        <form id="currencyForm" method="post">
                                            <input id="currencyFormInput" name="currency_id" type="hidden" value="" />
                                        </form>
                                    </div>
                                {/if}
                            </div>

                            {* <!-- ===============================================
                            |                                                     |
                            |  Логотип.                                           |
                            |                                                     |
                            ================================================ --> *}

                            <div class="logo">
                                <a href="{site}">
                                    <img src="{theme}images/logo.png" alt="" />
                                </a>
                            </div>

                            {* <!-- ===============================================
                            |                                                     |
                            |  Корзина.                                           |
                            |                                                     |
                            ================================================ --> *}

                            <div id="cart_informer" class="cart">
                                {include 'common/cart-informer.htm'}
                            </div>
                            <div class="clr"></div>

                            {* <!-- ===============================================
                            |                                                     |
                            |  Верхнее меню.                                      |
                            |                                                     |
                            ================================================ --> *}

                            <div class="menu">


 <a class="super-button" href="#">
  <img src="{theme}images/menu.png" alt="Меню" class="menu-opened"/>
  <img src="{theme}images/close.png" alt="Закрыть меню" class="menu-closed"/>
 </a>

<script>
$('.super-button').on('click', function(event){
  event.preventDefault();
  var $navMenu = $('.super-nav-menu');

  if ( $(this).hasClass('super-button-opened') ) {
    $navMenu.fadeOut('fast');
    $('.super-button').removeClass('super-button-opened')
  } else {
    $navMenu.css('display', 'flex');
    $('.super-button').addClass('super-button-opened')
  }

})
</script>


                                <ul class="super-nav-menu">

                                    {* <!-- читаем меню --> *}

                                    {if empty($menuTop)}
                                        {menuByLangTechName name='Верхнее меню' attach='sections, categories' assign=menuTop scope=global}
                                    {/if}
                                    {if !empty($menuTop)}

                                        {* <!-- прикрепленные категории --> *}

                                        {if !empty($menuTop->categories)}
                                            {echoVar from='category->category_id' assign=sid}
                                            {foreach $menuTop->categories as $item}
                                                {if !empty($item->enabled) && (empty($item->hidden) || $helper->existsUser())}
                                                    {echoVar from='item->category_id' assign=id}
                                                    {$class = ($id == $sid) ? 'class="selected"' : ''}

                                                    {$name = $item->name|default:''}

                                                    <li {$class}>
                                                        <a href="{url}" title="{$name|escape}">
                                                            {$name}
                                                        </a>
                                                    </li>
                                                {/if}
                                            {/foreach}
                                        {/if}

                                        {* <!-- прикрепленные страницы --> *}

                                        {if !empty($menuTop->sections)}
                                            {echoVar from='section->section_id' assign=sid}
                                            {foreach $menuTop->sections as $item}
                                                {if !empty($item->enabled) && (empty($item->hidden) || $helper->existsUser())}
                                                    {echoVar from='item->section_id' assign=id}
                                                    {$class = ($id == $sid) ? 'class="selected"' : ''}

                                                    {url assign=url}
                                                    {$url = preg_replace('!/sections/mainpage$!i', '/', $url)}
                                                    {$url = preg_replace('!/dummy/!i', '/', $url)}

                                                    {$name = $item->name|default:''}

                                                    {if $name == 'Главная'}
                                                        <li {$class}>
                                                            <a href="{site}" title="Интернет-магазин одежды от производителя" alt="Интернет-магазин одежды в розницу">
                                                                <img src="{theme}images/home-icon.png" alt="" />
                                                            </a>
                                                        </li>
                                                    {else}
                                                        <li {$class}>
                                                            <a href="{$url}" title="{$name|escape}">
                                                                {$name}
                                                            </a>
                                                        </li>
                                                    {/if}
                                                {/if}
                                            {/foreach}
                                        {/if}
                                    {/if}
                                </ul>
                            </div>

                            {* <!-- ===============================================
                            |                                                     |
                            |  Поиск.                                             |
                            |                                                     |
                            ================================================ --> *}

                            <div id="search" class="search">
                                <form method="post" onsubmit="return false">
                                    <input class="input_search" name="keyword" maxlength="48" type="text" value="{inputValue from=keyword}" placeholder="Поиск товара" />
                                    <input name="search_type" type="hidden" value="a1" />
                                    <input name="reset_old" type="hidden" value="1" />
                                    <input class="button_search" type="submit" value="" />
                                </form>
                            </div>
                            <div class="clr"></div>

                            {* <!-- ===============================================
                            |                                                     |
                            |  Рекомендуемые товары.                              |
                            |                                                     |
                            ================================================ --> *}

                            {if !empty($enableHitProducts)}
                                {discountProducts count=20 assign=items}
                                {if !empty($items)}
                                    <div class="popular0">
                                        <div class="popular">
                                            <ul>
                                                {foreach $items as $item}
                                                    <li>
                                                        <div class="popular-bl">
                                                            <div class="popular-image">
                                                                <a href="{url}">
                                                                    <img src="{image folder='files/products'}" alt="{name}" />
                                                                </a>
                                                            </div>

                                                            {if !empty($item->variants)}
                                                                {$number = 1}
                                                                {foreach $item->variants as $v}
                                                                    <a href="{url}" class="popular-price">
                                                                        {discountPrice num=$number}
                                                                    </a>
                                                                    {$number = $number + 1}
                                                                {/foreach}
                                                            {/if}

                                                            <div class="lenta">
                                                                <p>Топ продаж</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        </div>
                                        <div class="clr"></div>

                                        <a href="#" class="prev prev-navigation"></a>
                                        <a href="#" class="next next-navigation"></a>
                                    </div>
                                {/if}
                            {/if}
                        </div>

                        {* <!-- ===================================================
                        |                                                         |
                        |  Контент основного модуля страницы.                     |
                        |                                                         |
                        ==================================================== --> *}

{if $onFirstPage}
    <div class="wrap home-page">
{elseif !empty($category)}
    <div class="wrap category-page">
{elseif !empty($section)}
    <div class="wrap section-page">
{else}
    <div class="wrap other-page">
{/if}

                            {content}
                            <div class="clr"></div>
                        </div>
                    </div>

                    {* <!-- =======================================================
                    |                                                             |
                    |  Парсим SEO текст, если был задан для такой страницы.       |
                    |  Результат имеем, только если SEO текст был в формате       |
                    |  (отступы не важны):                                        |
                    |      <h1>Название ссылки 1</h1>                             |
                    |          <p>Некое</p>                                       |
                    |          <p>описание</p>                                    |
                    |          <p>для ссылки 1</p>                                |
                    |      <h1>Название ссылки 2</h1>                             |
                    |          <p>Некое</p>                                       |
                    |          <p>описание</p>                                    |
                    |          <p>для ссылки 2</p>                                |
                    |  Тогда получим заполненную структуру:                       |
                    |      $seo[1] = [ 'h1' => 'Название ссылки 1',               |
                    |                  'body' => html описание ссылки 1 ]         |
                    |      $seo[2] = [ 'h1' => 'Название ссылки 2',               |
                    |                  'body' => html описание ссылки 2 ]         |
                    |                                                             |
                    ======================================================== --> *}

                    {$onFirstPage = empty($PrevPageUrl)}
                    {if $onFirstPage}

                        {$seo = []}
                        {if !empty($seo_description)}
                            {$number = 1}
                            {$pattern = '!^[ \t\r\n]*<h1[^>]*>([^<]+)</h1>(.*?)$!ius'}
                            {$pattern2 = '!^[ \t\r\n]*(.*?)(<h1.*)$!ius'}
                            {section name=seo loop=2}
                                {if preg_match($pattern, $seo_description)}
                                    {$seo[$number] = []}
                                    {$seo[$number]['h1'] = preg_replace($pattern, '$1', $seo_description)}
                                        {$seo_description = preg_replace($pattern, '$2', $seo_description)}
                                    {$seo[$number]['body'] = preg_replace($pattern2, '$1', $seo_description)}
                                        {$seo_description = preg_replace($pattern2, '$2', $seo_description)}
                                    {$number = $number + 1}
                                {/if}
                            {/section}
                        {/if}
                    {/if}

                    {* <!-- =======================================================
                    |                                                             |
                    |  Выводим SEO текст, если был задан. То есть либо те 2       |
                    |  части, что мы распарсили выше, иначе просто выводим SEO    |
                    |  текст как он был дан.                                      |
                    |                                                             |
                    ======================================================== --> *}

                    {if $onFirstPage}
                        {if !empty($seo_description)}
                            {if !empty($seo[1]['body']) && !empty($seo[2]['body'])}
                                <div class="seo" id="seo1">{$seo[1]['body']}</div>
                                <div class="seo" id="seo2">{$seo[2]['body']}</div>

                            {elseif !empty($seo_description)}
                                <div class="seo">
                                    {echoVar from=seo_description}
                                </div>
                            {/if}
                        {/if}
                    {/if}

                    {* <!-- =======================================================
                    |                                                             |
                    |  Подвал. SEO ссылки выводим согласно наличию 2 распарсенных |
                    |  частей SEO текста или наличию SEO ссылок в конфиге сайта.  |
                    |                                                             |
                    ======================================================== --> *}

                    <div class="footer">
                        {if $onFirstPage}
                            {if !empty($seo[1]['body']) && !empty($seo[2]['body'])}
                                <a class="seo-link" href="{requestUri}" onclick="return toggleSeoDetails('#seo1', 800)">{$seo[1]['h1']}</a>
                                <a class="seo-link" href="{requestUri}" onclick="return toggleSeoDetails('#seo2', 800)">{$seo[2]['h1']}</a>
                            {else}
                                {if !empty($config->seo_href1)}
                                    <a class="seo-link" href="{inputValue from='config->seo_href1'}">
                                        {echoVar from='config->seo_link1'}
                                    </a>
                                {/if}

                                {if !empty($config->seo_href2)}
                                    <a class="seo-link" href="{inputValue from='config->seo_href2'}">
                                        {echoVar from='config->seo_link2'}
                                    </a>
                                {/if}
                            {/if}
                        {/if}

                        <p>Copyright © <a href="{site}">Lemanta</a>. All rights reserved.</p>

                        {* <!-- ===================================================
                        |                                                         |
                        |  Счетчики. SEO ссылки выводим                           |
                        |                                                         |
                        ==================================================== --> *}

                        <div class="counters">
                            {counters}
                        </div>
                    </div>

                    {* <!-- =======================================================
                    |                                                             |
                    |  Кнопка "Наверх страницы".                                  |
                    |                                                             |
                    ======================================================== --> *}

                    <a id="back-top" title="К началу страницы">↑</a>
                </div>

                {* <!-- ===========================================================
                |                                                                 |
                |  Вспомогательные скрипты.                                       |
                |                                                                 |
                ============================================================ --> *}

                <script>
                    function gotoHref ( anchor ) {
                        try {
                            var href1 = anchor.getAttribute('data-href');
                            if (typeof href1 == 'string' && href1 != '') {
                                if (anchor.tagName == 'A') {
                                    var href2 = anchor.getAttribute('href');
                                    if (typeof href2 != 'string' || href2 != href1) {
                                        anchor.setAttribute('href', href1);
                                    }
                                    return true;
                                } else {
                                }
                            }
                        } catch (e) { }
                        return false;
                    };
                </script>
            </body>
        </html>

        {* <!-- ===================================================================
        |                                                                         |
        |  Отправляем заголовки Last-Modified и Expires.                          |
        |                                                                         |
        ==================================================================== --> *}

        {headerLastModified}
        {headerExpires}
    {/if}

{/strip}
