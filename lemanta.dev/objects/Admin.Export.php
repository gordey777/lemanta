<?php
    // TODO: галиматья, переписать нормально с учетом возможностей дижка

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/placeholder.php');

    class Export extends Basic {
        var $subcategory_delimiter = '/';



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent         объект владельца
        *  @param   integer $start_mode     режим запуска
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null, $start_mode = BASIC_START_FOR_CLIENT_MODE ) {
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
            $this->prepare();
        }



        function prepare () {
        }



        // ===================================================================
        /**
        *  Визуализация данных (результирующего контента)
        *
        *  @access  public
        *  @param   object  $parent     объект владельца (когда модуль используют как плагин)
        *  @return  boolean             TRUE если просят продолжать открытие страницы
        */
        // ===================================================================

        public function fetch ( & $parent = null ) {
    
    $this->title = 'Экспорт товаров';

  	if (isset($_POST['format']) && ($_POST['format'] != '')) {
  	  if (empty($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
  	    header('Location: http://' . $this->root_url . '/admin/');
  	    exit;
  	  }

      $format = $_POST['format'];
      
      // Кодировки
      $charset = $_POST['charset'];
      setlocale ( LC_ALL, 'ru_RU.'.$charset);
      
      $this->db->query('SET NAMES '.$charset);
      $query = sql_placeholder('UPDATE settings SET value=? WHERE name="file_export_charset"', $charset);
      $this->db->query($query);
      
      if($format == 'csv') {
        $csv_columns = $_POST['csv_columns'];
        $csv_delimiter = $_POST['csv_delimiter'];
        $query = sql_placeholder('UPDATE settings SET value=? WHERE name="csv_export_columns"', $csv_columns);
        $this->db->query($query);
        $query = sql_placeholder('UPDATE settings SET value=? WHERE name="csv_export_delimiter"', $csv_delimiter);
        $this->db->query($query);
        $this->export_csv($csv_columns, $csv_delimiter);
      }
      
      
      $this->db->query('SET NAMES utf8');
      $query = 'UPDATE products SET order_num=product_id WHERE order_num=0';
      $this->db->query($query);
      $query = 'UPDATE products SET url=product_id WHERE url=""';
      $this->db->query($query);
      $query = "UPDATE " . DATABASE_CATEGORIES_TABLENAME . " SET url = category_id WHERE url = ''";
      $this->db->query($query);
      $query = "UPDATE " . DATABASE_BRANDS_TABLENAME . " SET url = brand_id WHERE url = ''";
      $this->db->query($query);

      if($this->error_msg) {
        $this->smarty->assign('error', $this->error_msg);
 	    $this->body = $this->smarty->fetch('admin_export.htm');
      }

 	} else {
    	$this->smarty->assign('error', $this->error_msg);
 		$this->body = $this->smarty->fetch('admin_export.htm');
  	}

  }
  
    protected function get_categories () {
        $query = 'SELECT * FROM categories ORDER BY parent ASC, order_num ASC';
        $this->db->query($query);
        $cats = $this->db->results();
        $categories = $this->categories_tree($cats);
        return $categories;
    }

	protected function categories_tree ( $categories ) {
		$tree = array();
		$used_items = array();
		$end = FALSE;
		while (!empty($categories) && !$end) {
			foreach ($categories as $k => $category) {
				$flag = FALSE;
				if ($category->parent == 0) {
                    $cat = new stdClass;
					$cat->name = $category->name;
					$cat->category_id = $category->category_id;
					$cat->url = $category->url;
					$category->path[0] = $cat;
					$tree[$category->category_id] = $category;
					$used_items[$category->category_id] = & $tree[$category->category_id];
					unset($categories[$k]);
					$flag = TRUE;
                } else {
                    if (isset($used_items[$category->parent])) {
                        $cat = new stdClass;
						$cat->name = $category->name;
						$cat->category_id = $category->category_id;
						$cat->url = $category->url;
						$category->path = $used_items[$category->parent]->path;
						$category->path[] = $cat;
						$used_items[$category->parent]->subcategories[$category->category_id] = $category;
						$used_items[$category->category_id] = & $used_items[$category->parent]->subcategories[$category->category_id];
						unset($categories[$k]);
						$flag = TRUE;
					}
				}
			}
			if (!$flag) $end = TRUE;
		}
		$used_items = array_reverse($used_items, true);
		foreach ($used_items as $k => $item) {
			$used_items[$item->category_id]->subcats_ids[] = $item->category_id;
			if (isset($used_items[$item->parent]->subcats_ids) && is_array($used_items[$item->parent]->subcats_ids))
				$used_items[$item->parent]->subcats_ids =  array_merge($used_items[$item->parent]->subcats_ids, $item->subcats_ids);
			else
				$used_items[$item->parent]->subcats_ids = $item->subcats_ids;
		}
		return $tree;
	}

    protected function category_by_id ( $categories, $id ) {
        foreach ($categories as $category) {
            if ($category->category_id == $id) return $category;
            elseif (isset($category->subcategories) && is_array($category->subcategories)) {
                if($result = $this->category_by_id($category->subcategories, $id)) return $result;
            }
        }
        return FALSE;
    }

  ///////////////////////////////////////////
  ///////////////////////////////////////////
  function export_csv($cols_order, $delimiter)
  {
    $cassoc = array(
      'ctg'=>'category',
      'brnd'=>'brand',
      'name'=>'model',
      'sku'=>'sku',
      'prc'=>'price',
      'opt'=>'opt',
      'oprc'=>'old_price',
      'qty'=>'quantity',
      'ann'=>'description',
      'dsc'=>'body',
      'url'=>'url',
      'mttl'=>'meta_title',
      'mkwd'=>'meta_keywords',
      'mdsc'=>'meta_description',
      'enbld'=>'enabled',
      'hit'=>'hit',
      'simg'=>'small_image',
      'limg'=>'large_image'  
    );
   
  
      // Максимальное время выполнения скрипта
      $max_time = @ini_get('max_execution_time');
      if(!$max_time) $max_time = 30;
    
      // Порядок колонок
      $temp = explode(",", $cols_order);
      $i = 0;
      foreach($temp as $tmp)
      {
        $columns[trim($tmp)] = $i;
        $i++;
      }
    
      $start_time = microtime(true);
      $time_elapsed = 0;
      
      # Выбераем товары
      $query = "SELECT SQL_CALC_FOUND_ROWS *,
                products.*, " . DATABASE_BRANDS_TABLENAME . ".name AS brand,
                products_variants.sku AS sku,
                products_variants.name AS opt,
                products_variants.price AS price,                
                products_variants.stock AS quantity, "
              . DATABASE_CATEGORIES_TABLENAME . ".category_id AS category_id
                FROM " . DATABASE_CATEGORIES_TABLENAME . ", products LEFT JOIN " . DATABASE_BRANDS_TABLENAME . " ON products.brand_id = " . DATABASE_BRANDS_TABLENAME . ".brand_id
                LEFT JOIN products_variants ON products.product_id = products_variants.product_id
                WHERE " . DATABASE_CATEGORIES_TABLENAME . ".category_id = products.category_id
                GROUP BY products_variants.variant_id
                ORDER BY " . DATABASE_CATEGORIES_TABLENAME . ".order_num, products.order_num, products_variants.position";

      $this->db->query($query);
      $products = $this->db->results();
      
      # Выбираем категории
      $categories = $this->get_categories();

      header("Content-Description: File Transfer");
      header("Content-Type: text/csv");
      header("Content-disposition: attachment; filename=impera_db_export.csv");      
      # Идем по всем товарам
      $i = 0;
      while (isset($products[$i]) && $exec_time_ok = $time_elapsed < $max_time-1)
      { 
         $values = array();
         foreach($columns as $name=>$index)
         {
           if(!empty($cassoc[$name]))
           {
             $fieldname = $cassoc[$name];
             
             // Если нам нужна категория
             if($fieldname == 'category')
             {
             	// выбираем категорию
             	$category = $this->category_by_id($categories, $products[$i]->category_id);
             	$path_cats = null;
             	$path_cats = array();
             	// и по хлебным крошкам восстанавливаем путь к ней
             	foreach($category->path as $c)
             	{
             		$path_cats[] = str_replace('/','\/',$c->name);
             	}
				$values[] = join($this->subcategory_delimiter, $path_cats);
             }
             elseif(isset($products[$i]->$fieldname))
             {
                if(is_numeric($products[$i]->$fieldname))
                $values[] =  $products[$i]->$fieldname*1;
				else                
                $values[] = str_replace('"', '""', $products[$i]->$fieldname);
             }
             else
               $values[] = '';
           }
         }
         $line = join($values, '"'.$delimiter.'"');
         print '"'.$line.'"'.PHP_EOL;

            
         $current_time = microtime(true);
         $time_elapsed = $current_time - $start_time;
         $i++;            
      }
      exit();
  
  }

}