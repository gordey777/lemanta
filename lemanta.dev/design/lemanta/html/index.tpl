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
            </head>

                     {*<!-- ===========================================================
                    |                                                                 |
                    |  Основной модуль мог попросить добавить некоторые мета-теги.    |
                    |                                                                 |
                    ============================================================ -->*}

                    {echoVar from=meta}

            {if $onFirstPage}
                <body class="home-page">
            {elseif !empty($category)}
                <body class="category-page">
            {elseif !empty($section)}
                <body class="section-page">
            {elseif !empty($user)}
                <body class="user-page">
            {elseif !empty($brand)}
                <body class="brand-page">
            {elseif !empty($product)}
                <body class="product-page">
            {elseif !empty($item)}
                <body class="item-page">
            {elseif !empty($group)}
                <body class="group-page">
            {elseif !empty($emulator)}
                <body class="emulator-page">
            {else}
                <body class="other-page">
            {/if}



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
                                 gtmID = 'GTM-TQKHLJ'
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
                <!-- wrapper -->
                <div class="bg wrapper">

    <header role="banner">
    <a href="#menu" id="hamburger" class="humb-toggle-switch humb-toggle-switch__htx">
      <span>toggle menu</span>
    </a>

    <nav id="menu">
      <ul class="mob-menu">


        <li>
            <a id="mob-search" class="search">
                            {* <!-- ===============================================
                            |                                                     |
                            |  Поиск.                                             |
                            |                                                     |
                            ================================================ --> *}
                                <form method="post" onsubmit="return false">
                                    <input class="input_search" name="keyword" maxlength="48" type="text" value="{inputValue from=keyword}" placeholder="Поиск товара" />
                                    <input name="search_type" type="hidden" value="a1" />
                                    <input name="reset_old" type="hidden" value="1" />
                                    <input class="button_search" type="submit" value="" />
                                </form>
            </a>
        </li>
        {include 'common/main-nav.htm'}
<!--         <li>
    <a href="{site}" title="Интернет-магазин одежды от производителя" alt="Интернет-магазин одежды в розницу">
        <i class="fa fa-home"></i>
    </a>
</li> -->
        {include 'common/menu-catalog.htm'}


      </ul>

    </nav>

      <div class="top-menu-wrap">
        <div class="container">
          <div class="row">
            <div class="top-menu col-md-12">
              <div class="login col-md-2 col-xs-4">
                            {* <!-- ===============================================
                            |                                                     |
                            |  Ссылка на Аккаунт (если это авторизованный клиент).|
                            |                                                     |
                            ================================================ --> *}
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
              <div class="socialnet col-md-2 col-xs-4">
                                {* <!-- ===========================================
                                |                                                 |
                                |  Социальные ссылки.                             |
                                |                                                 |
                                ============================================ --> *}
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

                                {if !empty($currencies) && count($currencies) > 1}
              <div class="valuta col-md-2 col-xs-4">

                                {* <!-- ===========================================
                                |                                                 |
                                |  Выбор валюты (если их больше одной).           |
                                |                                                 |
                                ============================================ --> *}
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

              </div><!-- /.valuta -->
                                {/if}
            </div>
          </div><!-- /.row -->
        </div><!-- /.container -->
      </div><!-- /.top-menu-wrap -->

      <div class="container">
        <div class="row">

          <div class="logo col-md-2 col-sm-2 col-xs-6">
                            {* <!-- ===============================================
                            |                                                     |
                            |  Логотип.                                           |
                            |                                                     |
                            ================================================ --> *}
                                <a href="{site}">
                                    <img src="{theme}images/logo.png" alt="" />
                                </a>
          </div>

          <div id="cart_informer" class="head-cart col-md-2 col-md-offset-8 col-sm-2 col-xs-5">
                            {* <!-- ===============================================
                            |                                                     |
                            |  Корзина.                                           |
                            |                                                     |
                            ================================================ --> *}
                                {include 'common/cart-informer.htm'}
          </div>

          <div class="search-bg col-md-2 col-sm-3 col-xs-4 col-md-push-10">
            <div id="search" class="search">
                            {* <!-- ===============================================
                            |                                                     |
                            |  Поиск.                                             |
                            |                                                     |
                            ================================================ --> *}
                                <form method="post" onsubmit="return false">
                                    <input class="input_search" name="keyword" maxlength="48" type="text" value="{inputValue from=keyword}" placeholder="Поиск товара" />
                                    <input name="search_type" type="hidden" value="a1" />
                                    <input name="reset_old" type="hidden" value="1" />
                                    <input class="button_search" type="submit" value="" />
                                </form>
            </div>
          </div>

          <nav id="head-top-nav" class="nav__header col-md-10 col-sm-12 col-md-pull-2" role="navigation">
            <ul class="headnav">
                            {* <!-- ===============================================
                            |                                                     |
                            |  Верхнее меню.                                      |
                            |                                                     |
                            ================================================ --> *}

                                    {include 'common/main-nav.htm'}
            </ul>
          </nav><!-- /nav -->



        </div><!-- /.row -->
      </div><!-- /.container -->
    </header><!-- /header -->


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




    <section role="main">
      <div class="container">
        <div class="row">
                        {* <!-- ===================================================
                        |                                                         |
                        |  Контент основного модуля страницы.                     |
                        |                                                         |
                        ==================================================== --> *}
                            {content}

          <div class="clr"></div>

          <div class="seo-container col-md-12">

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
            </div><!-- /.seo-container col-md-12 -->
          </div><!-- /.row -->
        </div><!-- /.container -->
      </section><!-- /section -->
    </div><!-- /wrapper -->

    <footer class="footer">



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

    </footer>

                    {*<!-- =======================================================
                    |                                                             |
                    |  Кнопка "Наверх страницы".                                  |
                    |                                                             |
                    ======================================================== --> *}

                    <a id="back-top" title="К началу страницы"><i class="fa fa-arrow-up"></i></a>

                    {*<!-- ===========================================================
                    |                                                                 |
                    |  Скрипты.                                                       |
                    |                                                                 |
                    ============================================================ -->*}


    <script>
    var thisTemplateRootUrl = '{theme}';
    </script>


    <script src="{theme}js/script.js"></script>

                    {*<!-- ===========================================================
                    |                                                                 |
                    |  Микроразметка организации.                                     |
                    |                                                                 |
                    ============================================================ -->*}
    <script type="application/ld+json">
      { {**} "@context" : "http://schema.org", {**} "@type" : "Organization", {**} "url" : "{site}", {**} "contactPoint" : [ { {**} "@type" : "ContactPoint", {**} "telephone" : "+38-098-053-22-23", {**} "contactType" : "customer service" {**} } ] } {**}
    </script>
    {*
    <!-- ===========================================================
                    |                                                                 |
                    |  Вспомогательные скрипты.                                       |
                    |                                                                 |
                    ============================================================ -->*}
    <script>
    function gotoHref(anchor) {
      try {
        var href1 = anchor.getAttribute('data-href');
        if (typeof href1 == 'string' && href1 != '') {
          if (anchor.tagName == 'A') {
            var href2 = anchor.getAttribute('href');
            if (typeof href2 != 'string' || href2 != href1) {
              anchor.setAttribute('href', href1);
            }
            return true;
          } else {}
        }
      } catch (e) {}
      return false;
    };
    </script>
    <script type="text/javascript" src="{theme}js/jquery.mmenu.all.min.js"></script>

    <script type="text/javascript">
      jQuery(document).ready(function($) {
        $("#menu").mmenu({
          "extensions": [
            "pagedim-black"
          ],
          "offCanvas": {
            "position": "right"
          },
          navbar: {
            title: 'LEMANTA'
          },
          "navbars": [

            {
              "position": "bottom",
              "content": [

                "<a class='fa fa-skype' href='skype:lemanta2014?call'></a>",
                "<a class='fa fa-vk' href='http://vkontakte.ru/share.php?url=http://lemanta.com'></a>",
                "<a class='fa fa-instagram' href='https://www.instagram.com/lemanta8465/'></a>",
                "<a class='fa fa-facebook' href='https://www.facebook.com/Lemanta-280572415630549//'></a>"
              ]
            }
          ]
        });
      });
    </script>

      <!-- $(this).removeAttr('href'); -->

<script type="text/javascript" >
  $(document).ready(function(){

    $("#left_menu li a.selected").parents("li").addClass('open').children('ul').slideDown();
    $("#left_menu li a.selected").parent("li").addClass('bg-selected');

    if ($("#left_menu li").hasClass('open')) {
      $("#left_menu li.open").children('.holder').addClass('holder-open');
    }

    var holderelement = $('#left_menu li.has-sub>.holder');

    holderelement.on('click', function(){

      var element = $(this).parent('li');

      if (element.hasClass('open')) {
        element.removeClass('open');
        $(this).removeClass('holder-open');
        element.find('li').removeClass('open');
        element.find('ul').slideUp();
      }
      else {
        element.addClass('open');
        element.children('ul').slideDown();
        element.siblings('li').children('ul').slideUp();
        element.siblings('li').removeClass('open');
        element.siblings('li').find('li').removeClass('open');
        element.siblings('li').find('ul').slideUp();
        $(this).addClass('holder-open');
        element.siblings('li').find('.holder').removeClass('holder-open');
      }
    });

    });
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
