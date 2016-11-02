<?php
  // Impera CMS: модуль карты сайта на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);

  // какой файл является шаблоном карты сайта на клиентской стороне (указываем без расширения)
  define("CLIENT_SITEMAP_CLASS_TEMPLATE_FILE", "page.sitemap");

  // =========================================================================
  // Класс ClientSitemap (модуль карты сайта на клиентской стороне)
  //
  // Использование этого класса происходит в результате переназначения класса
  // Sitemap на данный класс во время загрузки модуля карты сайта.
  // =========================================================================

  class ClientSitemapNetpeak extends Basic {

    // создание контента модуля ==============================================

    public function fetch (&$parent = null) {

      // какой формат карты сайта был указан во входном параметре?
      $format = strtolower($this->param(REQUEST_PARAM_NAME_SITEMAP_FORMAT));
      switch ($format) {

        // если карта для Google (файл sitemap.xml)
        case SITEMAP_REQUEST_PARAM_VALUE_GOOGLE:

          // выводим контент виртуального файла sitemap.xml
          $this->fetch_google_sitemap();

          // останавливаемся (в таком формате модуль считается самостоятельным)
          exit;

        // иначе традиционная карта сайта
        default:
          $this->fetch_sitemap("Карта сайта", GET_PRODUCTS_COMPLETENESS_FOR_SITEMAP);
      }

      // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
      return TRUE;
    }

    // вывод контента виртуального файла sitemap.xml =========================

    private function fetch_google_sitemap () {

      // будем возвращать страницу как XML-текст
      header("Content-Type: text/xml");

      // выводим начальную часть контента
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?" . ">\r\n"
         . "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n"
         . "  <url>\r\n"
         . "    <loc>http://" . $this->root_url . "</loc>\r\n"
      /* . "    <lastmod>" . date("Y-m-d") . "</lastmod>\r\n" */
         . " </url>\r\n";

        // читаем и выводим список незапрещенных и незакрытых от чужих товаров
        $result = $this->db->query('SELECT `products`.`url`, '
                                        . '`products`.`url_special`, '
                                        . 'DATE_FORMAT(`products`.`modified`, "%Y-%m-%d") AS `modified`, '
                                        . '`products`.`created` '
                                 . 'FROM `products` '
                                 . 'LEFT JOIN `categories` ON `products`.`category_id` = `categories`.`category_id` '
                                 . 'WHERE `categories`.`enabled` = 1 '
                                       . 'AND `categories`.`hidden` = 0 '
                                       . 'AND `products`.`enabled` = 1 '
                                       . 'AND `products`.`hidden` = 0 '
                                 . 'ORDER BY `products`.`created` DESC;');
        if ($result !== FALSE) {
            $ignores = array( 'Sviter-4s-085tm' );
            while ($item = $this->db->fetch_object($result)) {
                if (!empty($item)) {
                    if (!in_array($item->url, $ignores)) {
                        echo " <url>\r\n"
                           . "  <loc>http://" . $this->text->escape($this->root_url) . '/' . (!$item->url_special ? 'products/' : '') . $this->text->escape($item->url) . "</loc>\r\n"
                        /* . "  <lastmod>" . $item->modified . "</lastmod>\r\n" */
                           . " </url>\r\n";
                    }
                }
            }
        }

        // освобождаем память от запроса
        $this->db->free_result($result);

        // читаем и выводим список незапрещенных и незакрытых от чужих категорий
        $result = $this->db->query('SELECT `url`, '
                                        . '`url_special`, '
                                        . '`order_num` '
                                 . 'FROM `categories` '
                                 . 'WHERE `enabled` = 1 '
                                       . 'AND `hidden` = 0 '
                                 . 'ORDER BY `order_num` DESC;');
        if ($result !== FALSE) {
            $ignores = array( 'zhenskaya-odezhda/platya/delovye',
                              'zhenskaya-odezhda/nakidki',
                              'zhenskaya-odezhda/yubki',
                              'detskaya-odezhda/koftochki',
                              'detskaya-odezhda/koftochki/dlya-malchikov',
                              'detskaya-odezhda/koftochki/dlya-devochek',
                              'detskaya-odezhda/dlya-malchikov/losiny',
                              'detskaya-odezhda/dlya-malchikov/koftochki',
                              'detskaya-odezhda/dlya-devochek/losiny',
                              'detskaya-odezhda/dlya-devochek/koftochki',
                              'detskaya-odezhda/tuniki',
                              'detskaya-odezhda/losiny/dlya-devochek',
                              'detskaya-odezhda/losiny/dlya-malchikov',
                              'detskaya-odezhda/losiny' );
            while ($item = $this->db->fetch_object($result)) {
                if (!empty($item)) {
                    if (!in_array($item->url, $ignores)) {
                        echo " <url>\r\n"
                           . "  <loc>http://" . $this->text->escape($this->root_url) . '/' . (!$item->url_special ? 'catalog/' : '') . $this->text->escape($item->url) . "</loc>\r\n"
                        /* . "  <lastmod>" . date("Y-m-d") . "</lastmod>\r\n" */
                           . " </url>\r\n";
                    }
                }
            }
        }

        // освобождаем память от запроса
        $this->db->free_result($result);

        // читаем и выводим список незапрещенных и незакрытых от чужих брендов
        $result = $this->db->query('SELECT `url`, '
                                        . '`url_special`, '
                                        . '`order_num` '
                                 . 'FROM `brands` '
                                 . 'WHERE `enabled` = 1 '
                                       . 'AND `hidden` = 0 '
                                 . 'ORDER BY `order_num` DESC;');
        if ($result !== FALSE) {
            while ($item = $this->db->fetch_object($result)) {
                if (!empty($item)) {
                    echo " <url>\r\n"
                       . "  <loc>http://" . $this->text->escape($this->root_url) . '/' . (!$item->url_special ? 'brands/' : '') . $this->text->escape($item->url) . "</loc>\r\n"
                    /* . "  <lastmod>" . date("Y-m-d") . "</lastmod>\r\n" */
                       . " </url>\r\n";
                }
            }
        }

        // освобождаем память от запроса
        $this->db->free_result($result);

        // читаем и выводим список незапрещенных и незакрытых от чужих специальных страниц
        $result = $this->db->query('SELECT `url`, '
                                        . '`url_special`, '
                                        . 'DATE_FORMAT(`modified`, "%Y-%m-%d") AS `modified`, '
                                        . '`created` '
                                 . 'FROM `sections` '
                                 . 'WHERE `enabled` = 1 '
                                       . 'AND `hidden` = 0 '
                                       . 'AND `url` != "404" '
                                 . 'ORDER BY `created` DESC;');
        if ($result !== FALSE) {
            $ignores = array( 'contact',
                              'oplata',
                              'dostavka',
                              'mainpage',
                              'sitemap',
                              'rasprodazha',
                              'dummy/zhenskaya-odezhda',
                              'dummy/muzhskaya-odezhda',
                              'dummy/detskaya-odezhda' );
            while ($item = $this->db->fetch_object($result)) {
                if (!empty($item)) {
                    if (!in_array($item->url, $ignores)) {
                        echo " <url>\r\n"
                           . "  <loc>http://" . $this->text->escape($this->root_url) . '/' . (!$item->url_special ? 'sections/' : '') . $this->text->escape($item->url) . "</loc>\r\n"
                        /* . "  <lastmod>" . $item->modified . "</lastmod>\r\n" */
                           . " </url>\r\n";
                    }
                }
            }
        }

        // освобождаем память от запроса
        $this->db->free_result($result);

      // читаем и выводим список незапрещенных, незакрытых от чужих и разрешенных анонсировать новостей
      $result = $this->db->query("SELECT url, "
                                      . "url_special, "
                                      . "DATE_FORMAT(modified, '%Y-%m-%d') AS modified, "
                                      . "created "
                               . "FROM news "
                               . "WHERE enabled = 1 "
                                     . "AND hidden = 0 "
                                     . "AND listed = 1 "
                               . "ORDER BY created DESC;");
      if ($result !== FALSE) {
        while ($item = $this->db->fetch_object($result)) {
          if (!empty($item)) {
            echo " <url>\r\n"
               . "  <loc>http://" . $this->text->escape($this->root_url) . '/' . (!$item->url_special ? 'news/' : '') . $this->text->escape($item->url) . "</loc>\r\n"
            /* . "  <lastmod>" . $item->modified . "</lastmod>\r\n" */
               . " </url>\r\n";
          }
        }
      }

      // освобождаем память от запроса
      $this->db->free_result($result);

      // читаем и выводим список незапрещенных, незакрытых от чужих и разрешенных анонсировать статей
      $result = $this->db->query("SELECT url, "
                                      . "url_special, "
                                      . "DATE_FORMAT(modified, '%Y-%m-%d') AS modified, "
                                      . "created "
                               . "FROM articles "
                               . "WHERE enabled = 1 "
                                     . "AND hidden = 0 "
                                     . "AND listed = 1 "
                               . "ORDER BY created DESC;");
      if ($result !== FALSE) {
        while ($item = $this->db->fetch_object($result)) {
          if (!empty($item)) {
            echo " <url>\r\n"
               . "  <loc>http://" . $this->text->escape($this->root_url) . '/' . (!$item->url_special ? 'articles/' : '') . $this->text->escape($item->url) . "</loc>\r\n"
            /* . "  <lastmod>" . $item->modified . "</lastmod>\r\n" */
               . " </url>\r\n";
          }
        }
      }

      // освобождаем память от запроса
      $this->db->free_result($result);

      // читаем и выводим список незапрещенных и незакрытых от чужих медиафайлов
      $result = $this->db->query("SELECT url, "
                                      . "DATE_FORMAT(modified, '%Y-%m-%d') AS modified, "
                                      . "created "
                               . "FROM files "
                               . "WHERE enabled = 1 "
                                     . "AND hidden = 0 "
                               . "ORDER BY created DESC;");
      if ($result !== FALSE) {
        while ($item = $this->db->fetch_object($result)) {
          if (!empty($item)) {
            echo " <url>\r\n"
               . "  <loc>http://" . $this->text->escape($this->root_url) . '/media/' . $this->text->escape($item->url) . "</loc>\r\n"
            /* . "  <lastmod>" . $item->modified . "</lastmod>\r\n" */
               . " </url>\r\n";
          }
        }
      }

      // освобождаем память от запроса
      $this->db->free_result($result);

      // читаем и выводим список незапрещенных, незакрытых от чужих и разрешенных на клиентской стороне страниц складов
      $result = $this->db->query("SELECT url, "
                                      . "DATE_FORMAT(modified, '%Y-%m-%d') AS modified, "
                                      . "created "
                               . "FROM stocks "
                               . "WHERE enabled = 1 "
                                     . "AND hidden = 0 "
                                     . "AND visible = 1 "
                               . "ORDER BY created DESC;");
      if ($result !== FALSE) {
        while ($item = $this->db->fetch_object($result)) {
          if (!empty($item)) {
            echo " <url>\r\n"
               . "  <loc>http://" . $this->text->escape($this->root_url) . '/stocks/' . $this->text->escape($item->url) . "</loc>\r\n"
            /* . "  <lastmod>" . $item->modified . "</lastmod>\r\n" */
               . " </url>\r\n";
          }
        }
      }

      // освобождаем память от запроса
      $this->db->free_result($result);

      // выводим конечную часть контента
      echo "</urlset>\r\n";
    }

    // создание контента традиционной карты сайта ============================

    public function fetch_sitemap ($title, $mode) {

      // дополняем записи категорий списками незапрещенных и видимых пользователю товаров текущего раздела магазина
      $params = new stdClass;
      $params->completeness = GET_PRODUCTS_COMPLETENESS_FOR_SITEMAP;
      $params->enabled = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $params->section = $this->now_in_section;
      $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
      if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
      $this->db->productize_categories($this->categories_tree, $this->categories, $params);

      // устанавливаем заголовок страницы
      $this->title = $title;

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_CATALOG, $this->categories_tree);
      $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
      $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->message);
      $this->smarty->fetchByTemplate($this, CLIENT_SITEMAP_CLASS_TEMPLATE_FILE, 'sitemap');

      // удаляем из записей категорий списки товаров (освобождаем место в памяти)
      $this->db->unproductize_categories($this->categories);
    }
  }

  return;
?>