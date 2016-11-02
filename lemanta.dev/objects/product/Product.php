<?php
  // Impera CMS: модуль товаров на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_ARTICLES_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_CATEGORIES_OBJECT);

    // подключаем константы модуля товаров (TODO: исправить на актуальное, когда константы будут разбросаны из свалочного Products по своим модулям)
    impera_ConstantsRequire('Products');

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_ADMIN_POSTS_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_SITEMAP_OBJECT);

  // какой файл является шаблоном специфичного списка товаров на клиентской стороне (указываем без расширения),
  // какой файл является шаблоном списка товаров на клиентской стороне (указываем без расширения),
  // какой файл является шаблоном страницы товара на клиентской стороне (указываем без расширения)
  define("SELECTOR_CATALOG_CLASS_TEMPLATE_FILE", "page.catalog");
  define("SELECTOR_PRODUCTS_CLASS_TEMPLATE_FILE", "page.products");
  define("SELECTOR_PRODUCT_CLASS_TEMPLATE_FILE", "page.product");

  // значения цели чтения списка товаров (для внутреннего использования или внешних информеров)
  define("GET_PRODUCTS_DESTINATION_FOR_EXPORT", TRUE);
  define("GET_PRODUCTS_DESTINATION_FOR_INTERNAL", FALSE);
  define("GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT", 8);



  // =========================================================================
  // Класс ClientProduct (модуль товаров на клиентской стороне)
  // =========================================================================

  class ClientProduct extends Basic {

    // сколько записей размещать на странице
    protected $items_per_page = DEFAULT_VALUE_FOR_PRODUCTS_ON_PAGE_IN_CLIENT;



    // создание контента модуля ==============================================

    public function fetch ( & $parent = null ) {

        // читаем из входных параметров url товара
        $url = $this->request->getGetAsSentence('url');
        if (!empty($url)) {
            $this->fetch_product($url);
        } else {
            $this->fetch_catalog();
        }

        // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
        return TRUE;
    }



    // создание контента специфичного списка товаров =========================

    private function fetch_catalog () {

      // если в настройках сайта задано свое количество "сколько записей размещать на странице"
      if (!empty($this->settings->products_num)) $this->items_per_page = $this->settings->products_num;

      // читаем входной параметр MODE - какой вариант списка товаров нужен
      $mode = strtolower($this->param(REQUEST_PARAM_NAME_CATALOG_MODE));

      // если вариант "Древовидный текстовый каталог", обращаемся к карте сайта
      if ($mode == CATALOG_MODE_REQUEST_PARAM_VALUE_CATALOG) {
        $this->smarty->assign("sitemap_mode", $mode);
        $sitemap = new ClientSitemap($this);
        $sitemap->fetch_sitemap("Каталог товаров", GET_PRODUCTS_COMPLETENESS_FOR_CATALOGMAP);
        return;
      }

      $this->smarty->assignByRef(SMARTY_VAR_CATALOG_MODE, $mode);

      // задаем общие параметры чтения списка товаров
      $params = new stdClass;
      $params->destination = GET_PRODUCTS_DESTINATION_FOR_INTERNAL;
      $params->maxcount = $this->items_per_page;

      // какой вариант списка товаров нужен?
      switch ($mode) {

        // если список хитов продаж или лучшие
        case CATALOG_MODE_REQUEST_PARAM_VALUE_BEST:
        case CATALOG_MODE_REQUEST_PARAM_VALUE_HIT:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_hit_title;
          $keywords = $this->settings->products_hit_keywords;
          $description = $this->settings->products_hit_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_hit_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_hit_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // если список новинок
        case CATALOG_MODE_REQUEST_PARAM_VALUE_NEWEST:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_newest_title;
          $keywords = $this->settings->products_newest_keywords;
          $description = $this->settings->products_newest_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_newest_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_newest_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // если список акционных товаров (специальных предложений)
        case CATALOG_MODE_REQUEST_PARAM_VALUE_ACTIONAL:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_actional_title;
          $keywords = $this->settings->products_actional_keywords;
          $description = $this->settings->products_actional_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_actional_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_actional_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // если список ожидаемых товаров (скоро в продаже)
        case CATALOG_MODE_REQUEST_PARAM_VALUE_AWAITED:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_awaited_title;
          $keywords = $this->settings->products_awaited_keywords;
          $description = $this->settings->products_awaited_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_awaited_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_awaited_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // если список новых поступлений
        case CATALOG_MODE_REQUEST_PARAM_VALUE_NEW:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_newest_title;
          $keywords = $this->settings->products_newest_keywords;
          $description = $this->settings->products_newest_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_new_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_newest_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // если список недавно покупавшихся товаров
        case CATALOG_MODE_REQUEST_PARAM_VALUE_ORDERED:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_ordered_title;
          $keywords = $this->settings->products_ordered_keywords;
          $description = $this->settings->products_ordered_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_ordered_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_ordered_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // если список комментируемых товаров
        case CATALOG_MODE_REQUEST_PARAM_VALUE_COMMENTED:

          // запоминаем для навигатора страниц выбранный вариант списка товаров
          $this->params[REQUEST_PARAM_NAME_CATALOG_MODE] = $mode;

          // берем мета информацию
          $title = $this->settings->products_commented_title;
          $keywords = $this->settings->products_commented_keywords;
          $description = $this->settings->products_commented_description;

          // читаем список товаров на текущей странице ($items примет список товаров страницы, $count - общее количество товаров)
          $page = intval($this->param(REQUEST_PARAM_NAME_PAGE)) - 1;
          if ($page < 0) $page = 0;
          $params->start = $page * $params->maxcount;
          $this->get_commented_products($items, $params, $count);
          $pages = ceil($count / $params->maxcount);

          // передаем данные в шаблонизатор
          $this->smarty->assignByRef('products', $items);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_TITLE, $title);
          $this->smarty->assignByRef(SMARTY_VAR_CONTENT_PATH, $this->settings->products_commented_path);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_ON_PAGE, $page);
          $this->smarty->assignByRef(SMARTY_VAR_NAVIGATOR_TOTAL_PAGES, $pages);
          $this->smarty->assign(SMARTY_VAR_ITEMS_PER_PAGE, $this->items_per_page);
          break;

        // иначе это все списки товаров сразу
        default:

          // берем мета информацию
          $title = $this->settings->products_hit_title;
          $keywords = $this->settings->products_hit_keywords;
          $description = $this->settings->products_hit_description;

          // читаем список хитов продаж
          $params = new stdClass;
          if (($this->settings->products_hit_random == 1) && ($this->settings->mainpage_sortform_enabled != 1)) $params->randomize = TRUE;
          $this->get_hit_products($items, $params);
          $this->smarty->assignByRef(SMARTY_VAR_HIT_PRODUCTS, $items);

          // читаем список новинок
          $params = new stdClass;
          if (($this->settings->products_newest_random == 1) && ($this->settings->mainpage_sortform_enabled != 1)) $params->randomize = TRUE;
          $this->get_newest_products($newests, $params);
          $this->smarty->assignByRef(SMARTY_VAR_NEWEST_PRODUCTS, $newests);

          // читаем список акционных товаров
          $params = new stdClass;
          if (($this->settings->products_actional_random == 1) && ($this->settings->mainpage_sortform_enabled != 1)) $params->randomize = TRUE;
          $this->get_actional_products($actionals, $params);
          $this->smarty->assignByRef(SMARTY_VAR_ACTIONAL_PRODUCTS, $actionals);

          // читаем список ожидаемых товаров
          $params = new stdClass;
          if (($this->settings->products_awaited_random == 1) && ($this->settings->mainpage_sortform_enabled != 1)) $params->randomize = TRUE;
          $this->get_awaited_products($awaiteds, $params);
          $this->smarty->assignByRef(SMARTY_VAR_AWAITED_PRODUCTS, $awaiteds);

          // читаем список покупавшихся товаров
          $params = new stdClass;
          if (($this->settings->products_ordered_random == 1) && ($this->settings->mainpage_sortform_enabled != 1)) $params->randomize = TRUE;
          $this->get_ordered_products($ordereds, $params);
          $this->smarty->assignByRef(SMARTY_VAR_ORDERED_PRODUCTS, $ordereds);

          // читаем список обсуждаемых товаров
          $params = new stdClass;
          if (($this->settings->products_commented_random == 1) && ($this->settings->mainpage_sortform_enabled != 1)) $params->randomize = TRUE;
          $this->get_commented_products($commenteds, $params);
          $this->smarty->assignByRef(SMARTY_VAR_COMMENTED_PRODUCTS, $commenteds);
      }


      // передаем данные в мета информацию страницы
      $this->title = (isset($this->section->meta_title) && !empty($this->section->meta_title)) ? $this->section->meta_title : $title;
      $this->keywords = (isset($this->section->meta_keywords) && !empty($this->section->meta_keywords)) ? $this->section->meta_keywords : $keywords;
      $this->description = (isset($this->section->meta_description) && !empty($this->section->meta_description)) ? $this->section->meta_description : $title;
      if (empty($this->seo_description) && isset($this->section->seo_description)) $this->seo_description = &$this->section->seo_description;

      // создаем контент модуля
      $this->smarty->assign('filter_params', $this->form_get(array()));
      $this->smarty->fetchByTemplate($this, SELECTOR_CATALOG_CLASS_TEMPLATE_FILE, 'catalog');
    }



    // чтение списка хитов продаж ============================================

    public function get_hit_products (&$items, $parameters = null, &$count = null) {

        // вычисляем один раз частые значения
        $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_hit_maxcount;
        $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);



        // готовим параметры чтения списка товаров
        $params = new stdClass;
        $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_AS_IS;
        $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
        $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;
        $params->type = TYPE_PRODUCTS_HIT;
        $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
        $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
        $params->section = $this->now_in_section;
        $params->enabled = 1;
        if (!isset($this->user->user_id)) $params->hidden = 0;
        $params->start = isset($parameters->start) ? $parameters->start : 0;
        $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;
        if (isset($parameters->randomize) && $parameters->randomize) {
            $params->randomcount = $params->maxcount;
            $params->maxcount = intval($params->maxcount * 10);
            if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
        }



        // отклоняем товары без цены
        $params->search_cost_from = 0.01;



        // отклоняем отсутствующие товары, если в настройках запрещена продажа под заказ
        if (!isset($this->settings->cart_enable_reservation)
        || !$this->settings->cart_enable_reservation) $params->search_amount_from = 1;



        // читаем список товаров
        $count = $this->db->products->get($items, $params);
        $this->db->products->unpackRecords($items, $params);



        // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
        return $items;
    }



    // чтение списка новинок =================================================

    public function get_newest_products ( & $items, $parameters = null, & $count = null ) {

        // вычисляем один раз частые значения
        $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_newest_maxcount;
        $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);



        // готовим параметры чтения списка товаров
        $params = new stdClass;



        // как сортировать результат
        $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_AS_IS;
        $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
        $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;



        // какой тип товаров и нужно ли подмешивать недавно добавленные
        if ($this->settings->products_newest_days > 0) {
            $params->type = TYPE_PRODUCTS_NEWEST_MIXED;
            $params->search_date_from = date('Y-m-d', time() - $this->settings->products_newest_days * 24 * 60 * 60);
        } else {
            $params->type = TYPE_PRODUCTS_NEWEST;
        }



        // учитываем скидку и ценовую группу текущего покупателя
        $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
        $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
        $params->section = $this->now_in_section;



        // только разрешенный товар и учитываем возможность скрытия от неавторизованных
        $params->enabled = 1;
        if (!isset($this->user->user_id)) $params->hidden = 0;



        // сколько штук отобрать и с какой позиции (согласно листаемой странице)
        $params->start = isset($parameters->start) ? $parameters->start : 0;
        $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;



        // если требуется случайно перемешать
        if (isset($parameters->randomize) && $parameters->randomize) {
            $params->randomcount = $params->maxcount;
            $params->maxcount = intval($params->maxcount * 10);
            if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
        }



        // отклоняем товары без цены
        $params->search_cost_from = 0.01;



        // отклоняем отсутствующие товары, если в настройках запрещена продажа под заказ
        if (!isset($this->settings->cart_enable_reservation)
        || !$this->settings->cart_enable_reservation) $params->search_amount_from = 1;



        // читаем список товаров
        $count = $this->db->products->get($items, $params);
        $this->db->products->unpackRecords($items, $params);



        // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
        return $items;
    }



    // чтение списка акционных товаров =======================================

    public function get_actional_products (&$items, $parameters = null, &$count = null) {

      // вычисляем один раз частые значения
      $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_actional_maxcount;
      $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);

      // готовим параметры чтения списка товаров
      $params = new stdClass;
      $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_AS_IS;
      $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
      $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;
      $params->type = TYPE_PRODUCTS_ACTIONAL;
      $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
      $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
      $params->section = $this->now_in_section;
      $params->enabled = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $params->start = isset($parameters->start) ? $parameters->start : 0;
      $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;
      if (isset($parameters->randomize) && $parameters->randomize) {
        $params->randomcount = $params->maxcount;
        $params->maxcount = intval($params->maxcount * 10);
        if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
      }

      // читаем список товаров
      $count = $this->db->products->get($items, $params);
      $this->db->products->unpackRecords($items, $params);

      // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
      return $items;
    }



    // чтение списка ожидаемых товаров =======================================

    public function get_awaited_products (&$items, $parameters = null, &$count = null) {

      // вычисляем один раз частые значения
      $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_awaited_maxcount;
      $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);

      // готовим параметры чтения списка товаров
      $params = new stdClass;
      $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_AS_IS;
      $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
      $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;
      $params->type = TYPE_PRODUCTS_AWAITED;
      $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
      $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
      $params->section = $this->now_in_section;
      $params->enabled = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $params->start = isset($parameters->start) ? $parameters->start : 0;
      $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;
      if (isset($parameters->randomize) && $parameters->randomize) {
        $params->randomcount = $params->maxcount;
        $params->maxcount = intval($params->maxcount * 10);
        if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
      }

      // читаем список товаров
      $count = $this->db->products->get($items, $params);
      $this->db->products->unpackRecords($items, $params);

      // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
      return $items;
    }



    // чтение списка новых поступлений =======================================

    public function get_new_products (&$items, $parameters = null, &$count = null) {

        // вычисляем один раз частые значения
        $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_newest_maxcount;
        $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);



        // готовим параметры чтения списка товаров
        $params = new stdClass;



        // как сортировать результат
        $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_BY_CREATED;
        $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
        $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;



        // какой тип товаров и нужно ли подмешивать недавно добавленные
        $params->type = TYPE_PRODUCTS_ANY;
        if ($this->settings->products_newest_days > 0) {
            $params->search_date_from = date('Y-m-d', time() - $this->settings->products_newest_days * 24 * 60 * 60);
        }



        // учитываем скидку и ценовую группу текущего покупателя
        $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
        $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
        $params->section = $this->now_in_section;



        // только разрешенный товар и учитываем возможность скрытия от неавторизованных
        $params->enabled = 1;
        if (!isset($this->user->user_id)) $params->hidden = 0;



        // сколько штук отобрать и с какой позиции (согласно листаемой странице)
        $params->start = isset($parameters->start) ? $parameters->start : 0;
        $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;



        // если требуется случайно перемешать
        if (isset($parameters->randomize) && $parameters->randomize) {
            $params->randomcount = $params->maxcount;
            $params->maxcount = intval($params->maxcount * 10);
            if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
        }



        // отклоняем товары без цены
        $params->search_cost_from = 0.01;



        // отклоняем отсутствующие товары, если в настройках запрещена продажа под заказ
        if (!isset($this->settings->cart_enable_reservation)
        || !$this->settings->cart_enable_reservation) $params->search_amount_from = 1;



        // читаем список товаров
        $count = $this->db->products->get($items, $params);
        $this->db->products->unpackRecords($items, $params);



        // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
        return $items;
    }



    // чтение списка недавно покупавшихся товаров ============================

    public function get_ordered_products (&$items, $parameters = null, &$count = null) {

      // вычисляем один раз частые значения
      $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_ordered_maxcount;
      $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);

      // готовим параметры чтения списка товаров
      $params = new stdClass;
      $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_BY_ORDERED;
      $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
      $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;
      $params->type = TYPE_PRODUCTS_ORDERED;
      $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
      $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
      $params->section = $this->now_in_section;
      $params->enabled = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $params->start = isset($parameters->start) ? $parameters->start : 0;
      $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;
      if (isset($parameters->randomize) && $parameters->randomize) {
        $params->randomcount = $params->maxcount;
        $params->maxcount = intval($params->maxcount * 10);
        if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
      }

      // читаем список товаров
      $count = $this->db->products->get($items, $params);
      $this->db->products->unpackRecords($items, $params);

      // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
      return $items;
    }



    // чтение списка обсуждавшихся товаров ===================================

    public function get_commented_products (&$items, $parameters = null, &$count = null) {

      // вычисляем один раз частые значения
      $maxcount = isset($parameters->destination) && ($parameters->destination === GET_PRODUCTS_DESTINATION_FOR_EXPORT) ? GET_PRODUCTS_DESTINATION_FOR_EXPORT_MAX_COUNT : $this->settings->products_commented_maxcount;
      $usersort = isset($parameters->destination) && ($parameters->destination !== GET_PRODUCTS_DESTINATION_FOR_EXPORT) && ($this->settings->mainpage_sortform_enabled == 1);

      // готовим параметры чтения списка товаров
      $params = new stdClass;
      $params->sort = $usersort ? $this->sort_products_mode : SORT_PRODUCTS_MODE_BY_COMMENTED;
      $params->sort_direction = $usersort ? $this->sort_products_direction : SORT_DIRECTION_DESCENDING;
      $params->sort_laconical = $usersort ? $this->sort_products_laconical : 1;
      $params->type = TYPE_PRODUCTS_COMMENTED;
      $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
      $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
      $params->section = $this->now_in_section;
      $params->enabled = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $params->start = isset($parameters->start) ? $parameters->start : 0;
      $params->maxcount = isset($parameters->maxcount) ? $parameters->maxcount : $maxcount;
      if (isset($parameters->randomize) && $parameters->randomize) {
        $params->randomcount = $params->maxcount;
        $params->maxcount = intval($params->maxcount * 10);
        if ($params->maxcount > ITEMS_PER_PAGE_MAXIMAL_VALUE) $params->maxcount = ITEMS_PER_PAGE_MAXIMAL_VALUE;
      }

      // читаем список товаров
      $count = $this->db->products->get($items, $params);
      $this->db->products->unpackRecords($items, $params);

      // возвращаем результат также и на выход (поддержка работоспособности в случае внеобъектного вызова)
      return $items;
    }



    // получение данных бренда по его url ====================================

    private function get_brand_by_url (&$items, $url) {
      $url = trim($url);
      if (!empty($url)) {
        if (isset($items) && !empty($items)) {
          // пробуем найти по url
          foreach ($items as &$item) {
            if ($item->url == $url) return $item;
          }
          // пробуем найти по id = url в записях с незаданным url
          foreach ($items as &$item) {
            if (empty($item->url) && ($item->brand_id == $url)) return $item;
          }
        }
      }
      return null;
    }



    function category_by_url($categories, $url) {
      foreach ($categories as $category) {
        if ($category->url == $url) {
          $category->active = 1;
          return $category;
        } elseif (isset($category->subcategories) && is_array($category->subcategories)) {
          if ($result = ClientProduct::category_by_url($category->subcategories, $url)) {
            $category->active = 1;
            return $result;
          }
        }
      }
      return false;
	  }



    function fetch_product ($product_url) {
        $this->error_msg = '';
        $this->info_msg = '';



        // если данные товара не были прочитаны ранее, читаем данные о незапрещенном
        // и видимом товаре с таким url в текущем разделе магазина (разрешив чтение связанных товаров)
        if (empty($this->product)) {
            $params = new stdClass;
            $params->url = $product_url;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
            $params->enabled = 1;
            $params->category_enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->section = $this->now_in_section;
            $params->with_related = 1;
            $this->db->products->one($this->product, $params);



            // если на страницу зашел администратор и товар не найден по его URL, а сам URL похож на идентификатор
            if (isset($_SESSION[SESSION_PARAM_NAME_ADMIN]) && ($_SESSION[SESSION_PARAM_NAME_ADMIN] == 'admin')
            && empty($this->product) && ($product_url == strval(intval($product_url)))) {

                // пробуем прочитать данные о товаре с таким идентификатором
                $params = new stdClass;
                $params->id = $product_url;
                $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
                if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
                $params->enabled = 1;
                $params->category_enabled = 1;
                if (!isset($this->user->user_id)) $params->hidden = 0;
                $params->section = $this->now_in_section;
                $params->with_related = 1;
                $this->db->products->one($this->product, $params);
            }



            // если товар так и не найден, выходим с передачей сообщения "Нет такой страницы на сайте"
            if (empty($this->product)) {
                $this->body = CONTENT_MESSAGE_NO_PAGE;

                // код ответа сервера
                $this->parent->headerError404();
                return;
            }
        }



        // если только пришли на товар (не листали страницы)
        if (($this->param(REQUEST_PARAM_NAME_PAGE) == '')) {

            // увеличить количество просмотров и передать в базу данных
            $this->product->browsed++;

            // при передаче в базу указываем не очищать кеш-таблицы товаров
            $item = new stdClass;
            $item->product_id = $this->product->product_id;
            $item->browsed = $this->product->browsed;
            $item->indifferent_caches = TRUE;
            $this->db->products->update($item);



            // запоминаем текущую страницу в списке просмотренных в текущем сеансе
            if (!isset($_SESSION['recent_products']) || !is_array($_SESSION['recent_products'])) $_SESSION['recent_products'] = array();
            $key = array_search($this->product->product_id, $_SESSION['recent_products']);
            if ($key !== FALSE) {
                unset($_SESSION['recent_products'][$key]);
                $_SESSION['recent_products'] = array_values($_SESSION['recent_products']);
            }
            array_unshift($_SESSION['recent_products'], $this->product->product_id);
            if (count($_SESSION['recent_products']) > RECENT_PAGES_LIST_MAXSIZE) array_pop($_SESSION['recent_products']);



            // запоминаем список в браузере пользователя
            if (function_exists('setcookie')) {

                // удаляем старые cookie
                if (isset($_COOKIE['recent_products'])) {
                    if (is_array($_COOKIE['recent_products'])) {
                        foreach ($_COOKIE['recent_products'] as $key => $item) {
                            setcookie('recent_products[' . $key . ']', '', time() - 365 * 24 * SECONDS_IN_HOUR, '/');
                        }
                    } else {
                        setcookie('recent_products', '', time() - 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }

                // добавляем новые cookie
                if (is_array($_SESSION['recent_products'])) {
                    foreach ($_SESSION['recent_products'] as $key => $item) {
                        setcookie('recent_products[' . $key . ']', $item, time() + 365 * 24 * SECONDS_IN_HOUR, '/');
                    }
                }
            }
        }



        // читаем список связанных статей
        if (!empty($this->product->article_ids)) {
            $id_filter = 'AND `article_id` IN (' . implode(',', $this->product->article_ids) . ') ';
            $sort_method = '`order_num` DESC ';
            if (isset($this->settings->articles_sort_method)) {
                switch ($this->settings->articles_sort_method) {
                    case SORT_ARTICLES_MODE_BY_HEADER: $sort_method = '`header` ASC '; break;
                    case SORT_ARTICLES_MODE_BY_CREATED: $sort_method = '`created` DESC '; break;
                    case SORT_ARTICLES_MODE_BY_MODIFIED: $sort_method = '`modified` DESC '; break;
                }
            }
            $query = 'SELECT * '
                   . 'FROM `articles` '
                   . 'WHERE `enabled` = 1 '
                         . 'AND `section` = \'' . $this->db->query_value($this->now_in_section) . '\' '
                         . $id_filter
                   . 'ORDER BY ' . $sort_method . ';';
            $this->db->query($query);
            $articles = $this->db->results();
            $this->smarty->assignByRef(SMARTY_VAR_PRODUCT_ARTICLES, $articles);
        }



        // читаем список связанных статей
        if (!empty($this->product->news_ids)) {
            $id_filter = 'AND `news_id` IN (' . implode(',', $this->product->news_ids) . ') ';
            $sort_method = '`order_num` DESC ';
            if (isset($this->settings->news_sort_method)) {
                switch ($this->settings->news_sort_method) {
                    case SORT_NEWS_MODE_BY_HEADER: $sort_method = '`header` ASC '; break;
                    case SORT_NEWS_MODE_BY_CREATED: $sort_method = '`created` DESC '; break;
                    case SORT_NEWS_MODE_BY_MODIFIED: $sort_method = '`modified` DESC '; break;
                }
            }
            $query = 'SELECT * '
                   . 'FROM `news` '
                   . 'WHERE `enabled` = 1 '
                         . 'AND `section` = \'' . $this->db->query_value($this->now_in_section) . '\' '
                         . $id_filter
                   . 'ORDER BY ' . $sort_method . ';';
            $this->db->query($query);
            $news = $this->db->results();
            $this->smarty->assignByRef(SMARTY_VAR_PRODUCT_NEWS, $news);
        }



        // передаем в шаблонизатор запись о бренде
        if (isset($this->brands[$this->product->brand_id])) {
            $brand = $this->brands[$this->product->brand_id];
            $this->smarty->assignByRef('brand', $brand);
        }



        // передаем в шаблонизатор запись о категории
        $category = isset($this->categories[$this->product->category_id])
                    ? $this->categories[$this->product->category_id]
                    : null;
        $this->smarty->assignByRef('category', $category);
        if (!empty($category)) $this->category_by_url($this->categories, $category->url);



        $this->pass_magnetize_products_for_category($category, $this->product->product_id);



        // передаем в шаблонизатор имя пользователя
        if (isset($this->user->name)) $this->smarty->assignByRef('name', $this->user->name);



        // обрабатываем постинг отзыва о товаре
        $this->post_comment($this->product);
        $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
        $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);



        // устанавливаем мета информацию
        $this->title = $this->product->meta_title;
        $this->keywords = $this->product->meta_keywords;
        $this->description = $this->product->meta_description;
        $this->seo_description = $this->product->seo_description;



        // читаем список комментариев и передаем в шаблонизатор
        $params = new stdClass;
        $params->product_id = $this->product->product_id;
        $params->enabled = 1;
        $this->db->get_comments($comments, $params);
        $this->smarty->assignByRef(SMARTY_VAR_PRODUCT_COMMENTS, $comments);



        // читаем следующий продукт и передаем в шаблонизатор
        $query = 'SELECT `' . DATABASE_PRODUCTS_TABLENAME . '`.`product_id` '
               . 'FROM `' . DATABASE_CATEGORIES_TABLENAME . '`, '
                     . '`' . DATABASE_PRODUCTS_TABLENAME . '` '
               . 'LEFT JOIN `' . DATABASE_BRANDS_TABLENAME . '` ON `' . DATABASE_BRANDS_TABLENAME . '`.`brand_id` = `' . DATABASE_PRODUCTS_TABLENAME . '`.`brand_id` '
               . 'WHERE `' . DATABASE_CATEGORIES_TABLENAME . '`.`category_id` = `' . DATABASE_PRODUCTS_TABLENAME . '`.`category_id` '
                     . 'AND `' . DATABASE_CATEGORIES_TABLENAME . '`.`enabled` = 1 '
                     . 'AND (`' . DATABASE_BRANDS_TABLENAME . '`.`enabled` IS NULL OR `' . DATABASE_BRANDS_TABLENAME . '`.`enabled` = 1) '
                     . 'AND `' . DATABASE_PRODUCTS_TABLENAME . '`.`category_id` = \'' . $this->db->query_value($this->product->category_id) . '\' '
                     . 'AND `' . DATABASE_PRODUCTS_TABLENAME . '`.`product_id` != \'' . $this->db->query_value($this->product->product_id) . '\' '
                     . 'AND `' . DATABASE_PRODUCTS_TABLENAME . '`.`enabled` = 1 '
                     . (!isset($this->user->user_id) ? 'AND `' . DATABASE_PRODUCTS_TABLENAME . '`.`hidden` = 0 ' : '')
                     . 'AND `' . DATABASE_PRODUCTS_TABLENAME . '`.`section` = \'' . $this->db->query_value($this->now_in_section) . '\' '
                     . 'AND `' . DATABASE_PRODUCTS_TABLENAME . '`.`order_num` <= ' . $this->product->order_num . ' '
               . 'ORDER BY `' . DATABASE_PRODUCTS_TABLENAME . '`.`order_num` DESC, '
                        . '`' . DATABASE_PRODUCTS_TABLENAME . '`.`product_id` ASC '
               . 'LIMIT 1;';
        $this->db->query($query);
        $item = $this->db->result();
        if (!empty($item)) {
            $params = new stdClass;
            $params->id = $item->product_id;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
            $this->db->products->one($next, $params);
            $this->smarty->assignByRef(SMARTY_VAR_NEXT_PRODUCT, $next);
        }



        // читаем предшествующий продукт и передаем в шаблонизатор
        $query = 'SELECT ' . DATABASE_PRODUCTS_TABLENAME . '.product_id '
               . 'FROM ' . DATABASE_CATEGORIES_TABLENAME . ', '
                     . DATABASE_PRODUCTS_TABLENAME . ' '
               . 'LEFT JOIN ' . DATABASE_BRANDS_TABLENAME . ' ON ' . DATABASE_BRANDS_TABLENAME . '.brand_id = ' . DATABASE_PRODUCTS_TABLENAME . '.brand_id '
               . 'WHERE ' . DATABASE_CATEGORIES_TABLENAME . '.category_id = ' . DATABASE_PRODUCTS_TABLENAME . '.category_id '
                     . 'AND ' . DATABASE_CATEGORIES_TABLENAME . '.enabled = 1 '
                     . 'AND (' . DATABASE_BRANDS_TABLENAME . '.enabled IS NULL OR ' . DATABASE_BRANDS_TABLENAME . '.enabled = 1) '
                     . "AND " . DATABASE_PRODUCTS_TABLENAME . ".category_id = '" . $this->db->query_value($this->product->category_id) . "' "
                     . "AND " . DATABASE_PRODUCTS_TABLENAME . ".product_id != '" . $this->db->query_value($this->product->product_id) . "' "
                     . "AND " . DATABASE_PRODUCTS_TABLENAME . ".enabled = 1 "
                     . (!isset($this->user->user_id) ? "AND " . DATABASE_PRODUCTS_TABLENAME . ".hidden = 0 " : "")
                     . "AND " . DATABASE_PRODUCTS_TABLENAME . ".section = '" . $this->db->query_value($this->now_in_section) . "' "
                     . "AND " . DATABASE_PRODUCTS_TABLENAME . ".order_num >= " . $this->product->order_num . " "
               . "ORDER BY " . DATABASE_PRODUCTS_TABLENAME . ".order_num ASC, "
                        . DATABASE_PRODUCTS_TABLENAME . ".product_id DESC "
               . 'LIMIT 1;';
        $this->db->query($query);
        $item = $this->db->result();
        if (!empty($item)) {
            $params = new stdClass;
            $params->id = $item->product_id;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
            $this->db->products->one($previous, $params);
            $this->smarty->assignByRef(SMARTY_VAR_PREVIOUS_PRODUCT, $previous);
        }

        // передаем данные в шаблонизатор
        $this->smarty->assignByRef(SMARTY_VAR_PRODUCT, $this->product);

        // определяем необходимость нестандартного шаблона
        $tpl = $this->hdd->safeFilename($this->product->template, FALSE);
        $ext = strtolower(substr($tpl, -4));
        if (($ext == '.tpl') || ($ext == '.htm')) {
            $path = ROOT_FOLDER_REFERENCE . 'design/' . $this->dynamic_theme . '/html/';
            $ext = $path . $tpl;
            if (file_exists($ext) && is_file($ext) && is_readable($ext)) {
                $this->body = $this->smarty->fetch($tpl);
                return;
            }
        }

        // иначе создаем контент модуля стандартным шаблоном
        $this->smarty->fetchByTemplate($this, SELECTOR_PRODUCT_CLASS_TEMPLATE_FILE, 'product');
    }



    // получение списка покупавшихся товаров =================================

    public function get_favorites () {
      $result = array();
      if (isset($this->user)) {
        $query = "SELECT orders_products.product_id, "
                      . "SUM(ABS(orders_products.quantity)) AS quantity "
               . "FROM " . DATABASE_ORDERS_TABLENAME . " "
               . "LEFT JOIN orders_products "
                         . "ON orders_products.order_id = " . DATABASE_ORDERS_TABLENAME . ".order_id "
               . "WHERE " . DATABASE_ORDERS_TABLENAME . ".user_id = '" . $this->db->query_value($this->user->user_id) . "' "
                     . "AND " . DATABASE_ORDERS_TABLENAME . ".status != " . ORDER_STATUS_CANCEL . " "
               . "GROUP BY orders_products.variant_id "
               . "ORDER BY quantity DESC;";
        $this->db->query($query);
        $orders = $this->db->results();
        foreach ($orders as &$order) {

          // читаем данные о таком незапрещенном товаре в текущем разделе магазина
          $params = new stdClass;
          $params->id = $order->product_id;
          $params->discount = $this->user->discount;
          if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
          $params->enabled = 1;
          $params->section = $this->now_in_section;
          $this->db->products->one($item, $params);

          if (!empty($item)) {
            $result[] = $item;
            if (count($result) >= 30) break;
          }
        }
      }
      return $result;
    }



    public function pass_magnetize_products_for_category ( & $category, $without_product_id = null ) {

        // новинки
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_newests_count) > 0 ? @ intval($this->settings->productpage_newests_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_AS_IS;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;



            // какой тип товаров и нужно ли подмешивать недавно добавленные
            if ($this->settings->products_newest_days > 0) {
                $params->type = TYPE_PRODUCTS_NEWEST_MIXED;
                $params->search_date_from = date('Y-m-d', time() - $this->settings->products_newest_days * 24 * 60 * 60);
            } else {
                $params->type = TYPE_PRODUCTS_NEWEST;
            }



            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_newests_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_newests_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('newests', $selected_products);
        $this->smarty->assign('newests_category', !empty($scan_category->name) ? $scan_category->name : null);



        // акционные
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_actionals_count) > 0 ? @ intval($this->settings->productpage_actionals_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_AS_IS;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->type = TYPE_PRODUCTS_ACTIONAL;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_actionals_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_actionals_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('actionals', $selected_products);
        $this->smarty->assign('actionals_category', !empty($scan_category->name) ? $scan_category->name : null);



        // ожидаемые
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_awaiteds_count) > 0 ? @ intval($this->settings->productpage_awaiteds_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_AS_IS;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->type = TYPE_PRODUCTS_AWAITED;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_awaiteds_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_awaiteds_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('awaiteds', $selected_products);
        $this->smarty->assign('awaiteds_category', !empty($scan_category->name) ? $scan_category->name : null);



        // покупаемые
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_ordereds_count) > 0 ? @ intval($this->settings->productpage_ordereds_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_BY_ORDERED;
            $params->sort_direction = SORT_DIRECTION_DESCENDING;
            $params->type = TYPE_PRODUCTS_ORDERED;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_ordereds_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_ordereds_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('ordereds', $selected_products);
        $this->smarty->assign('ordereds_category', !empty($scan_category->name) ? $scan_category->name : null);



        // обсуждаемые
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_commenteds_count) > 0 ? @ intval($this->settings->productpage_commenteds_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_BY_COMMENTED;
            $params->sort_direction = SORT_DIRECTION_DESCENDING;
            $params->type = TYPE_PRODUCTS_COMMENTED;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_commenteds_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_commenteds_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('commenteds', $selected_products);
        $this->smarty->assign('commenteds_category', !empty($scan_category->name) ? $scan_category->name : null);



        // хиты
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_hits_count) > 0 ? @ intval($this->settings->productpage_hits_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_AS_IS;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->type = TYPE_PRODUCTS_HIT;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_hits_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_hits_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('hits', $selected_products);
        $this->smarty->assign('hits_category', !empty($scan_category->name) ? $scan_category->name : null);



        // похожие
        $scan_category = $category;
        $selected_products = array();
        $selected_count = 0;
        $product_count = @ intval($this->settings->productpage_mores_count) > 0 ? @ intval($this->settings->productpage_mores_count) : 8;
        do {
            $params = new stdClass;
            $params->sort = SORT_PRODUCTS_MODE_AS_IS;
            $params->sort_direction = SORT_DIRECTION_ASCENDING;
            $params->type = TYPE_PRODUCTS_ANY;
            $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
            $params->price_id = isset($this->user->price_id) ? $this->user->price_id : 0;
            $params->section = $this->now_in_section;
            $params->category = & $scan_category;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->start = 0;
            $params->maxcount = $product_count * 10;
            $params->randomcount = $product_count;
            $this->db->products->get($products, $params);
            $this->db->products->unpackRecords($products, $params);

            if (!empty($products)) {
                foreach ($products as & $product) {
                    if (!empty($product) && isset($product->product_id)
                    && (empty($without_product_id) || ($this->settings->productpage_mores_excludeme != 1) || ($product->product_id != $without_product_id))) {
                        if (!isset($selected_products[$product->product_id])) {
                            $selected_products[$product->product_id] = $product;
                            $selected_count = $selected_count + 1;
                            if ($selected_count >= $product_count) break;
                        }
                    }
                }
            }
            if ($this->settings->productpage_mores_spacefill != 1) break;
            if (!isset($scan_category->parent) || ($scan_category->parent == 0)) break;
            if (!isset($this->categories[$scan_category->parent])) break;
            $scan_category = $this->categories[$scan_category->parent];
        } while ($selected_count < $product_count);
        $this->smarty->assign('mores', $selected_products);
        $this->smarty->assign('mores_category', !empty($scan_category->name) ? $scan_category->name : null);
    }



    function get_variant($variant_id, $as_product = GET_PRODUCT_VARIANT_AS_VARIANT, $mode = GET_PRODUCT_VARIANT_MODE_VARIANT_ONLY) {
      $discount = ((isset($this->user->discount) == TRUE) ? $this->user->discount : 0);
      if ($discount < 0) $discount = 0;
      if ($discount > 100) $discount = 100;
      if ($as_product === GET_PRODUCT_VARIANT_AS_FULL_PRODUCT) {
        $query = "SELECT " . DATABASE_PRODUCTS_TABLENAME . ".*, "
                      . "products_variants.*, "
                      . "CASE WHEN (products_variants.priority_discount >= 0 AND products_variants.priority_discount <= 100) "
                           . "THEN products_variants.price * (100 - products_variants.priority_discount) / 100 "
                           . "ELSE products_variants.price * (100 - " . $this->db->query_value($discount) . ") / 100 "
                           . "END AS discount_price, "
                      . DATABASE_BRANDS_TABLENAME . ".name AS brand, "
                      . DATABASE_CATEGORIES_TABLENAME . ".single_name AS category "
               . "FROM products_variants, "
                     . DATABASE_PRODUCTS_TABLENAME . " "
               . "LEFT JOIN " . DATABASE_CATEGORIES_TABLENAME . " "
                         . "ON " . DATABASE_CATEGORIES_TABLENAME . ".category_id = " . DATABASE_PRODUCTS_TABLENAME . ".category_id "
               . "LEFT JOIN " . DATABASE_BRANDS_TABLENAME . " "
                         . "ON " . DATABASE_BRANDS_TABLENAME . ".brand_id = " . DATABASE_PRODUCTS_TABLENAME . ".brand_id "
               . "WHERE " . DATABASE_PRODUCTS_TABLENAME . ".product_id = products_variants.product_id "
                     . "AND products_variants.variant_id = '" . $this->db->query_value($variant_id) . "' "
               . "LIMIT 1;";
      } else {
        if ($as_product === GET_PRODUCT_VARIANT_AS_PRODUCT) {
          $query = "SELECT " . DATABASE_PRODUCTS_TABLENAME . ".*, "
                        . "products_variants.*, "
                        . "CASE WHEN (products_variants.priority_discount >= 0 AND products_variants.priority_discount <= 100) "
                             . "THEN products_variants.price * (100 - products_variants.priority_discount) / 100 "
                             . "ELSE products_variants.price * (100 - " . $this->db->query_value($discount) . ") / 100 "
                             . "END AS discount_price "
                 . "FROM products_variants, "
                       . DATABASE_PRODUCTS_TABLENAME . " "
                 . "WHERE " . DATABASE_PRODUCTS_TABLENAME . ".product_id = products_variants.product_id "
                       . "AND products_variants.variant_id = '" . $this->db->query_value($variant_id) . "' "
                 . "LIMIT 1;";
        } else {
          $query = "SELECT products_variants.*, "
                        . "CASE WHEN (products_variants.priority_discount >= 0 AND products_variants.priority_discount <= 100) "
                             . "THEN products_variants.price * (100 - products_variants.priority_discount) / 100 "
                             . "ELSE products_variants.price * (100 - " . $this->db->query_value($discount) . ") / 100 "
                             . "END AS discount_price, "
                 . "FROM products_variants "
                 . "WHERE products_variants.variant_id = '" . $this->db->query_value($variant_id) . "' "
                 . "LIMIT 1;";
        }
      }
      $this->db->query($query);
      $result = $this->db->result();
      if (empty($result)) {
        $result = FALSE;
        if ($mode === GET_PRODUCT_VARIANT_MODE_VARIANT_OR_PRODUCT) {

          // читаем товар с идентификатором как идентификатор варианта товара
          $params = new stdClass;
          $params->id = $variant_id;
          $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
          if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
          $params->enabled = 1;
          if (!isset($this->user->user_id)) $params->hidden = 0;
          $params->section = $this->now_in_section;
          $this->db->products->one($result, $params);

          if (empty($result)) {
            $result = FALSE;
          } else {
            if (($as_product === GET_PRODUCT_VARIANT_AS_PRODUCT)
            || ($as_product === GET_PRODUCT_VARIANT_AS_FULL_PRODUCT)) {
              $result->variant_id = $variant_id;
              $result->name = $result->model;
            }
          }
        }
      }
      return $result;
    }
  }



    return;
?>