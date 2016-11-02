<?php
  // Impera CMS: модуль конфигуратора на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);
  require_once(dirname(__FILE__) . '/cart/Cart.php');

  // какой файл является шаблоном конфигуратора на клиентской стороне (указываем без расширения)
  define("CLIENT_CONFIGURATOR_CLASS_TEMPLATE_FILE", "page.configurator");

  // =========================================================================
  // Класс Configurator (модуль конфигуратора на клиентской стороне)
  // =========================================================================

  class ClientConfigurator extends Basic {

    // категории конфигуратора
    private $items = array();

    // признак "работает ли конфигуратор как быстрый заказ"
    private $as_quickorder = FALSE;

    // заполнение массива товаров элемента конфигуратора =====================

    private function fill_products (&$products, &$category) {

      // если в категории есть товары
      if (isset($category->products)) {
        foreach ($category->products as &$product) {
          if (!empty($product)) {
            if (is_null($products)) $products = array();
            $i = $product->product_id . $product->variants[0]->variant_id;
            if (!isset($products[$i])) $products[$i] = &$product;
          }
        }
      }

      // если в категории есть подкатегориии, обрабатываем их
      if (!empty($category->subcategories)) {
        foreach ($category->subcategories as &$item) {
          if (!empty($item)) $this->fill_products($products, $item);
        }
      }
    }

    // построение простого массива (не для быстрого заказа) ==================

    private function build (&$categories, $number) {

      // перебираем категории ветки
      if (!empty($categories)) {
        foreach ($categories as &$item) {
          if (!empty($item)) {

            // если в категории задано ее название в конфигураторе
            if ($item->configurator_name != "") {

              // добавляем категорию в массив конфигуратора, перебирая в какие элементы ее добавлять
              $names = explode(",", $item->configurator_name);
              foreach ($names as &$name) {
                $name = trim($name);
                if ($name != "") {

                  // если такой элемент конфигуратора еще не создан
                  $i = $this->text->lowerCase($name);
                  if (!isset($this->items[$i])) {
                    $number++;
                    $this->items[$i] = array("name" => $name, "countable" => FALSE, "id" => "config_branch_" . $number, "indent" => 0, "products" => null, "subcats" => FALSE);
                  }

                  // добавляем в элемент конфигуратора товары категории
                  $this->fill_products($this->items[$i]["products"], $item);
                }
              }
            }

            // если в категории есть подкатегориии, обрабатываем их
            if (!empty($item->subcategories)) $this->build($item->subcategories, $number);
          }
        }
      }
    }

    // построение массива для быстрого заказа ================================

    private function build_quickorder (&$categories, $id, $indent) {

      // пока число товаров в ветке неизвестно
      $result = 0;
      if (!empty($categories)) {

        // перебираем категории ветки
        $number = 1;
        foreach ($categories as &$item) {
          if (!empty($item)) {

            // если в категории есть товары или подкатегории
            $my_id = $id . "_" . $number;
            $count = 0;
            if (isset($item->products)) foreach ($item->products as &$product) if (!empty($product)) $count++;
            if (($count > 0) || !empty($item->subcategories)) {

              // добавляем категорию в массив конфигуратора (обязательно запоминаем индекс добавляемого элемента)
              $index = count($this->items);
              $result += $count;
              $this->items[] = array("name" => &$item->name, "countable" => $count > 0, "id" => $my_id, "indent" => $indent, "products" => &$item->products, "products_count" => $count, "subcats" => FALSE);

              // если в категории есть подкатегориии
              if (!empty($item->subcategories)) {

                // обрабатываем подкатегории
                $subcount = $this->build_quickorder($item->subcategories, $my_id, $indent + 1);

                // если в категории есть товары, приплюсовываем вложенные, помечаем ветку разворачиваемой
                if (($count > 0) || ($subcount > 0)) {
                  $result += $subcount;
                  $this->items[$index]["subcats"] = $subcount > 0;

                // иначе в категории нет товаров, удаляем ее из конфигуратора
                } else {
                  array_pop($this->items);
                }
              }

              // +1 категория пройдена
              $number++;
            }
          }
        }
      }

      // возвращаем число товаров в ветке
      return $result;
    }

    // создание контента модуля ==============================================

    public function fetch (&$parent = null) {

      // берем из входного параметра режим работы конфигуратора
      $this->as_quickorder = isset($_REQUEST[REQUEST_PARAM_NAME_CONFIGURATOR_AS_QUICKORDER]) && ($_REQUEST[REQUEST_PARAM_NAME_CONFIGURATOR_AS_QUICKORDER] == 1);

      // дополняем записи категорий списками незапрещенных и видимых пользователю товаров текущего раздела магазина
      $params = new stdClass;
      $params->completeness = GET_PRODUCTS_COMPLETENESS_FOR_CONFIGURATOR;
      $params->enabled = 1;
      if (!isset($this->user->user_id)) $params->hidden = 0;
      $params->section = $this->now_in_section;
      $params->discount = isset($this->user->discount) ? $this->user->discount : 0;
      if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
      $this->db->productize_categories($this->categories_tree, $this->categories, $params);

      // если конфигуратор не в режиме быстрого заказа
      $this->items = array();
      if (!$this->as_quickorder) {
        $this->build($this->categories_tree, 0);
        ksort($this->items, SORT_STRING);
        $this->title = 'Конфигурация';

      // иначе конфигуратор в режиме быстрого заказа
      } else {
        $this->build_quickorder($this->categories_tree, 'config_branch', 0);
        $this->title = 'Быстрый заказ';
      }

      ClientCart::pass_data_for_cart_template(DONT_CHECK_POST_PARAMETERS_FOR_CART, 0);

      // передаем данные в шаблонизатор,
      // создаем контент модуля
      $this->smarty->assignByRef(SMARTY_VAR_ITEMS, $this->items);
      $this->smarty->assign('as_cataloged', $this->as_quickorder);
      $this->smarty->fetchByTemplate($this, CLIENT_CONFIGURATOR_CLASS_TEMPLATE_FILE, 'configurator');

      // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
      return TRUE;
    }
  }

  return;
?>
