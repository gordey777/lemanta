<?php
    // Impera CMS: модуль автозавершения поиска товаров.
    // Версия: 1.4
    // Copyright AIMatrix, 2012.
    // http://imperacms.ru
    // http://aimatrix.itak.info



    // блокируем вывод сообщений об ошибках
    error_reporting(0);



    // если сайт не умеет работать с JSON (JavaScript Object Notation)
    if (!function_exists('json_encode')) return;



    // берем из запроса искомый текст
    $search_text = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';

    // готовим ответ
    $response = array('query'       => $search_text,
                      'suggestions' => array(),
                      'data'        => array());

    // оптимизируем искомый текст
    if (function_exists('preg_replace')) $search_text = preg_replace('/[^a-z0-9а-яё]+/iu', ' ', $search_text);
    while (strpos($search_text, '  ') !== FALSE) $search_text = str_replace('  ', ' ', $search_text);
    $search_text = trim($search_text);
    if ($search_text != '') {



        // определяем 3 начальные константы:
        //     ссылка на корень сайта из текущей папки,
        //     имя папки с файлами модулей,
        //     имя файла с константами
        define('ROOT_FOLDER_REFERENCE', '../../../');
        define('FOLDERNAME_FOR_ENGINE_OBJECTS', 'objects');
        define('FILENAME_FOR_ENGINE_DEFINITION_OBJECT', 'Definition.php');



        // =======================================================================
        //
        // Подключаем файл остальных констант. Его путевое имя клеим из заданных
        // первоначальных констант.
        //
        // Это подключение необходимо ради конфигурации магазина, то есть
        // настройки его на базу данных, привязанную конкретно к текущему домену
        // сайта. Дело в том, что в силу поддержки функции работы нескольких
        // магазинов на едином движке, в файл констант была добавлена
        // автовызываемая функция конфигурации, которая находит и подгружает из
        // корня сайта требуемый файл Config...php.
        //
        // Это предоставит нам класс Config (конфигурация сервера MySQL) текущего
        // магазина, в котором сработал автозавершитель поиска. Данный класс
        // используем позже, когда создадим объект базы данных.
        //
        // =======================================================================

        require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);



        // подключаем мини модуль базы данных
        require_once('Database.mini.php');

        // создаем объект базы данных
        $db = new MySQLDatabaseMini();
        $db->config = new Config();



        // получаем полный URL корня сайта
        $site_url = $db->get_site_url();
        $site_url = explode('/', $site_url);
        array_pop($site_url);   // выходим в Autocomplete-search
        array_pop($site_url);   // выходим в common
        array_pop($site_url);   // выходим в design
        array_pop($site_url);   // выходим в корень сайта
        $site_url = implode('/', $site_url) . '/';



        // пробуем подключиться к базе данных
        if ($db->connect()) {
            $db->set_charset('utf8');



            // формируем часть запроса, которая относится к извлечению url товара
            $product_url_field = 'CASE WHEN TRIM([^1]url) != \'\' AND TRIM([^1]url) != \'0\' '
                                    . 'THEN [^1]url '
                                    . 'ELSE [^1]product_id '
                                    . 'END AS url';



            // для категорий и брендов аналогичная часть запроса по извлечению url похожа
            $category_url_field = str_replace('[^1]', '', $product_url_field);
            $brand_url_field = str_replace('product_id', 'brand_id', $category_url_field);
            $category_url_field = str_replace('product_id', 'category_id', $category_url_field);



            // формируем часть запроса, которая относится к извлечению цены товара
            $price_field = 'ABS(CASE WHEN [^2]temp_price != 0 '
                                  . 'THEN [^2]temp_price '
                                  . 'ELSE [^2]price * (100 - CASE WHEN ([^2]priority_discount >= 0 AND [^2]priority_discount <= 100) '
                                                               . 'THEN [^2]priority_discount '
                                                               . 'ELSE 0 '
                                                               . 'END) / 100 '
                                  . 'END) AS discount_price';



            // формируем часть запроса, которая относится к фильтру
            $search_text = explode(' ', $search_text, 5);
            if (count($search_text) > 4) array_pop($search_text);

            // делаем слова безопасными для MySQL-запроса
            foreach ($search_text as & $keyword) $keyword = $db->query_value($keyword);

            // фильтры по товарам
            $product_model_filter = '';
            $product_meta_title_filter = '';
            $product_meta_keywords_filter = '';
            $product_body_filter = '';
            $product_tags_filter = '';
            $product_barcode_filter = '';
            $product_pcode_filter = '';
            $product_sku_filter = '';

            // фильтры по категориям
            $category_name_filter = '';
            $category_meta_title_filter = '';
            $category_meta_keywords_filter = '';
            $category_body_filter = '';
            $category_tags_filter = '';

            // фильтры по брендам
            $brand_name_filter = '';
            $brand_meta_title_filter = '';
            $brand_meta_keywords_filter = '';
            $brand_body_filter = '';
            $brand_tags_filter = '';

            // перебираем слова строки поиска (к этому моменту она уже массив)
            foreach ($search_text as $index => & $keyword) {
                if ($keyword != '') {

                    // фильтры по товарам
                    if ($product_model_filter != '') $product_model_filter .= ' AND ';
                    $product_model_filter .= '([^1]model LIKE \'%' . $keyword . '%\' '
                                            . 'OR [^2]name LIKE \'%' . $keyword . '%\')';

                    if ($product_meta_title_filter != '') $product_meta_title_filter .= ' AND ';
                    $product_meta_title_filter .= '[^1]meta_title LIKE \'%' . $keyword . '%\'';

                    if ($product_meta_keywords_filter != '') $product_meta_keywords_filter .= ' AND ';
                    $product_meta_keywords_filter .= '[^1]meta_keywords LIKE \'%' . $keyword . '%\'';

                    if ($product_body_filter != '') $product_body_filter .= ' AND ';
                    $product_body_filter .= '([^1]description LIKE \'%' . $keyword . '%\' '
                                           . 'OR [^1]body LIKE \'%' . $keyword . '%\')';

                    if ($product_tags_filter != '') $product_tags_filter .= ' AND ';
                    $product_tags_filter .= '[^1]tags LIKE \'%' . $keyword . '%\'';

                    // для фильтров по кодам соединение условий тоже смоделируем по AND
                    // (лучше подавим поиск по кодам, когда ищут товар с числом в названии)
                    if ($index == 0) {
                        $value = implode('%', $search_text);
                        $product_barcode_filter .= '[^1]barcode LIKE \'' . $value . '%\'';
                        $product_pcode_filter .= '[^1]pcode LIKE \'' . $value . '%\'';
                        $product_sku_filter .= '[^2]sku LIKE \'' . $value . '%\'';
                    }

                    // фильтры по категориям
                    if ($category_name_filter != '') $category_name_filter .= ' AND ';
                    $category_name_filter .= '(name LIKE \'%' . $keyword . '%\' '
                                            . 'OR single_name LIKE \'%' . $keyword . '%\' '
                                            . 'OR configurator_name LIKE \'%' . $keyword . '%\')';

                    if ($category_meta_title_filter != '') $category_meta_title_filter .= ' AND ';
                    $category_meta_title_filter .= 'meta_title LIKE \'%' . $keyword . '%\'';

                    if ($category_meta_keywords_filter != '') $category_meta_keywords_filter .= ' AND ';
                    $category_meta_keywords_filter .= 'meta_keywords LIKE \'%' . $keyword . '%\'';

                    if ($category_body_filter != '') $category_body_filter .= ' AND ';
                    $category_body_filter .= 'description LIKE \'%' . $keyword . '%\'';

                    if ($category_tags_filter != '') $category_tags_filter .= ' AND ';
                    $category_tags_filter .= 'tags LIKE \'%' . $keyword . '%\'';

                    // фильтры по брендам
                    if ($brand_name_filter != '') $brand_name_filter .= ' AND ';
                    $brand_name_filter .= 'name LIKE \'%' . $keyword . '%\'';

                    if ($brand_meta_title_filter != '') $brand_meta_title_filter .= ' AND ';
                    $brand_meta_title_filter .= 'meta_title LIKE \'%' . $keyword . '%\'';

                    if ($brand_meta_keywords_filter != '') $brand_meta_keywords_filter .= ' AND ';
                    $brand_meta_keywords_filter .= 'meta_keywords LIKE \'%' . $keyword . '%\'';

                    if ($brand_body_filter != '') $brand_body_filter .= ' AND ';
                    $brand_body_filter .= 'description LIKE \'%' . $keyword . '%\'';

                    if ($brand_tags_filter != '') $brand_tags_filter .= ' AND ';
                    $brand_tags_filter .= 'tags LIKE \'%' . $keyword . '%\'';
                }
            }



            // =====================================================================
            //
            // Берем из входных параметров запроса настройки клиентской части
            // автозавершителя поиска.
            //
            // Эти настройки содержат предельные количества отбираемых товаров,
            // категорий и брендов, а также булевые признаки, по каким полям
            // разрешен поиск записей.
            //
            // Предельные количества автоматически уменьшаются до 30, если
            // равны больше 30. По умолчанию для товаров предельным количеством
            // считается 8 штук, для категорий и брендов - 4 штуки.
            //
            // =====================================================================

            // настройки по товарам
            $product_maxcount = isset($_REQUEST['product_maxcount']) ? abs(intval($_REQUEST['product_maxcount'])) : 8;
              if ($product_maxcount > 30) $product_maxcount = 30;
            $product_show_metatitle = isset($_REQUEST['product_show_metatitle']) && ($_REQUEST['product_show_metatitle'] == 'true');
            $product_by_model = isset($_REQUEST['product_by_model']) && ($_REQUEST['product_by_model'] == 'true');
            $product_by_metatitle = isset($_REQUEST['product_by_metatitle']) && ($_REQUEST['product_by_metatitle'] == 'true');
            $product_by_metakeywords = isset($_REQUEST['product_by_metakeywords']) && ($_REQUEST['product_by_metakeywords'] == 'true');
            $product_by_body = isset($_REQUEST['product_by_body']) && ($_REQUEST['product_by_body'] == 'true');
            $product_by_tags = isset($_REQUEST['product_by_tags']) && ($_REQUEST['product_by_tags'] == 'true');
            $product_by_barcode = isset($_REQUEST['product_by_barcode']) && ($_REQUEST['product_by_barcode'] == 'true');
            $product_by_pcode = isset($_REQUEST['product_by_pcode']) && ($_REQUEST['product_by_pcode'] == 'true');
            $product_by_sku = isset($_REQUEST['product_by_sku']) && ($_REQUEST['product_by_sku'] == 'true');

            // настройки по категориям
            $category_maxcount = isset($_REQUEST['category_maxcount']) ? abs(intval($_REQUEST['category_maxcount'])) : 4;
              if ($category_maxcount > 30) $category_maxcount = 30;
            $category_show_metatitle = isset($_REQUEST['category_show_metatitle']) && ($_REQUEST['category_show_metatitle'] == 'true');
            $category_by_name = isset($_REQUEST['category_by_name']) && ($_REQUEST['category_by_name'] == 'true');
            $category_by_metatitle = isset($_REQUEST['category_by_metatitle']) && ($_REQUEST['category_by_metatitle'] == 'true');
            $category_by_metakeywords = isset($_REQUEST['category_by_metakeywords']) && ($_REQUEST['category_by_metakeywords'] == 'true');
            $category_by_body = isset($_REQUEST['category_by_body']) && ($_REQUEST['category_by_body'] == 'true');
            $category_by_tags = isset($_REQUEST['category_by_tags']) && ($_REQUEST['category_by_tags'] == 'true');

            // настройки по брендам
            $brand_maxcount = isset($_REQUEST['brand_maxcount']) ? abs(intval($_REQUEST['brand_maxcount'])) : 4;
              if ($brand_maxcount > 30) $brand_maxcount = 30;
            $brand_show_metatitle = isset($_REQUEST['brand_show_metatitle']) && ($_REQUEST['brand_show_metatitle'] == 'true');
            $brand_by_name = isset($_REQUEST['brand_by_name']) && ($_REQUEST['brand_by_name'] == 'true');
            $brand_by_metatitle = isset($_REQUEST['brand_by_metatitle']) && ($_REQUEST['brand_by_metatitle'] == 'true');
            $brand_by_metakeywords = isset($_REQUEST['brand_by_metakeywords']) && ($_REQUEST['brand_by_metakeywords'] == 'true');
            $brand_by_body = isset($_REQUEST['brand_by_body']) && ($_REQUEST['brand_by_body'] == 'true');
            $brand_by_tags = isset($_REQUEST['brand_by_tags']) && ($_REQUEST['brand_by_tags'] == 'true');



            // =====================================================================
            //
            // Если клиентская часть автозавершителя поиска содержит актуальные
            // настройки поиска товаров, тогда берем из базы данных массив записей
            // из не более чем предельно разрешенное количество первых товаров,
            // удовлетворяющих условиям поиска.
            //
            // =====================================================================

            if (($product_maxcount > 0)
            && ($product_by_model || $product_by_metatitle || $product_by_metakeywords
               || $product_by_body || $product_by_tags || $product_by_barcode
               || $product_by_pcode || $product_by_sku)) {

                $products = & $db->select(array('products',                         // from (список таблиц)
                                                'LEFT JOIN products_variants '
                                                        . 'ON [^2]product_id = [^1]product_id'),
                                          array('[^1]model',                        // select (список полей)
                                                '[^1]meta_title',
                                                '[^1]product_id',
                                                '[^1]pcode',
                                                '[^1]small_image',
                                                '[^1]url_special',
                                                $product_url_field,
                                                '[^1]actional',
                                                '[^1]newest',
                                                '[^2]sku',
                                                '[^2]name AS variant_name',
                                                $price_field),
                                          '[^1]enabled = 1 AND (0 = 1 '             // where
                                                             . ($product_by_model        ? 'OR (' . $product_model_filter . ') '         : '')
                                                             . ($product_by_metatitle    ? 'OR (' . $product_meta_title_filter . ') '    : '')
                                                             . ($product_by_metakeywords ? 'OR (' . $product_meta_keywords_filter . ') ' : '')
                                                             . ($product_by_body         ? 'OR (' . $product_body_filter . ') '          : '')
                                                             . ($product_by_tags         ? 'OR (' . $product_tags_filter . ') '          : '')
                                                             . ($product_by_barcode      ? 'OR (' . $product_barcode_filter . ') '       : '')
                                                             . ($product_by_pcode        ? 'OR (' . $product_pcode_filter . ') '         : '')
                                                             . ($product_by_sku          ? 'OR (' . $product_sku_filter . ')'            : '')
                                                             . ')',
                                          '[^1]product_id',                         // group by
                                          '',                                       // having
                                          'actional DESC, newest DESC, model ASC',  // order by
                                          0,                                        // limit (индекс начального)
                                          $product_maxcount);                       // limit (сколько взять)
                if (!empty($products)) {



                    // =================================================================
                    //
                    // Берем из базы данных первую запись валюты, которая разрешена к
                    // показу на сайте (поле enabled = 1), не является удаленной записью
                    // (поле deleted = 0), помечена как дефолтная для клиентской стороны
                    // (поле def = 1) или при отсутствии такой помечена как основная
                    // валюта сайта (поле main = 1) или при отсутствии такой любую
                    // доступную.
                    //
                    // =================================================================

                    $currency = & $db->select(array('currencies'),            // from (список таблиц)
                                              array('rate_from',              // select (список полей)
                                                    'rate_to',
                                                    'sign',
                                                    'def',
                                                    'main'),
                                              'enabled = 1 AND deleted = 0',  // where
                                              '',                             // group by
                                              '',                             // having
                                              'def DESC, main DESC',          // order by
                                              0,                              // limit (индекс начального)
                                              1);                             // limit (сколько взять)

                    // если нет валюты, делаем фиктивную
                    if (empty($currency)) {
                        $currency = null;
                        $currency->rate_from = 1;
                        $currency->rate_to = 1;
                        $currency->sign = '';
                    }



                    // =================================================================
                    //
                    // Добавляем найденные товары в ответ клиентской стороне
                    // автозавершителя поиска.
                    //
                    // По каждому товару берем его цену (discount_price), высчитываем по
                    // курсу полученной валюты, добавляем в ответ как suggestions -
                    // предлагаемое (строкой: название товара, возможно уточняющее
                    // название варианта) и data - данные (массивом: цена, картинка,
                    // буквенный код, артикул, ссылка на страницу товара).
                    //
                    // Демонстрируемое название берем из мета заголовка страницы
                    // товара или его названия, согласно соответствующей настройке
                    // клиенсткой части автозавершителя поиска.
                    //
                    // =================================================================

                    // перебираем отобранные товары
                    foreach ($products as & $product) {

                        // вычисляем цену
                        $price = floor($product->discount_price * $currency->rate_from / $currency->rate_to);

                        // готовим адрес малой картинки
                        $image = $product->small_image;
                        if (($image != '')
                        && (strtolower(substr($image, 0, 5)) != 'http:'))
                          $image = $site_url . 'files/products/' . $image;

                        // готовим название
                        $name = trim($product_show_metatitle ? $product->meta_title : '');
                        if ($name == '') $name = trim($product->model
                                                    . (($product->variant_name != $product->model)
                                                       && ($product->variant_name != '') ? ', ' . $product->variant_name : ''));

                        // +1 предлагаемый товар
                        if ($name != '') {
                            $response['suggestions'][] = $name;

                            // и все данные по этому предлагаемому товару
                            $response['data'][] = array('price' => $price . ' ' . $currency->sign,
                                                        'image' => $image,
                                                        'product_id' => $product->product_id,
                                                        'pcode' => $product->pcode,
                                                        'sku' => $product->sku,
                                                        'url' => $site_url
                                                               . (!$product->url_special ? 'products/' : '')
                                                               . $product->url);
                        }
                    }
                }
            }



            // =====================================================================
            //
            // Если клиентская часть автозавершителя поиска содержит актуальные
            // настройки поиска категорий, тогда берем из базы данных массив
            // записей из не более чем предельно разрешенное количество первых
            // категорий, удовлетворяющих условиям поиска.
            //
            // =====================================================================

            if (($category_maxcount > 0)
            && ($category_by_name || $category_by_metatitle || $category_by_metakeywords
               || $category_by_body || $category_by_tags)) {

                $categories = & $db->select(array('categories'),              // from (список таблиц)
                                            array('name',                     // select (список полей)
                                                  'meta_title',
                                                  'image',
                                                  'category_id',
                                                  'url_special',
                                                  $category_url_field),
                                            'enabled = 1 AND (0 = 1 '         // where
                                                           . ($category_by_name         ? 'OR (' . $category_name_filter . ') '          : '')
                                                           . ($category_by_metatitle    ? 'OR (' . $category_meta_title_filter . ') '    : '')
                                                           . ($category_by_metakeywords ? 'OR (' . $category_meta_keywords_filter . ') ' : '')
                                                           . ($category_by_body         ? 'OR (' . $category_body_filter . ') '          : '')
                                                           . ($category_by_tags         ? 'OR (' . $category_tags_filter . ')'           : '')
                                                           . ')',
                                            '',                               // group by
                                            '',                               // having
                                            'name ASC',                       // order by
                                            0,                                // limit (индекс начального)
                                            $category_maxcount);              // limit (сколько взять)
                if (!empty($categories)) {



                    // =================================================================
                    //
                    // Добавляем найденные категории в ответ клиентской стороне
                    // автозавершителя поиска.
                    //
                    // Демонстрируемое название берем из мета заголовка страницы
                    // категории или ее названия, согласно соответствующей настройке
                    // клиенсткой части автозавершителя поиска.
                    //
                    // =================================================================

                    // перебираем отобранные категории
                    foreach ($categories as & $category) {

                        // готовим адрес картинки
                        $image = $category->image;
                        if (($image != '')
                        && (strtolower(substr($image, 0, 5)) != 'http:'))
                          $image = $site_url . 'files/categories/' . $image;

                        // готовим название
                        $name = trim($category_show_metatitle ? $category->meta_title : '');
                        if ($name == '') $name = trim($category->name);

                        // +1 предлагаемая категория
                        if ($name != '') {
                            $response['suggestions'][] = $name;

                            // и все данные по этой предлагаемой категории
                            $response['data'][] = array('type' => 'category',
                                                        'image' => $image,
                                                        'category_id' => $category->category_id,
                                                        'url' => $site_url
                                                               . (!$category->url_special ? 'catalog/' : '')
                                                               . $category->url);
                        }
                    }
                }
            }



            // =====================================================================
            //
            // Если клиентская часть автозавершителя поиска содержит актуальные
            // настройки поиска брендов, тогда берем из базы данных массив
            // записей из не более чем предельно разрешенное количество первых
            // брендов, удовлетворяющих условиям поиска.
            //
            // =====================================================================

            if (($brand_maxcount > 0)
            && ($brand_by_name || $brand_by_metatitle || $brand_by_metakeywords
               || $brand_by_body || $brand_by_tags)) {

                $brands = & $db->select(array('brands'),                  // from (список таблиц)
                                        array('name',                     // select (список полей)
                                              'meta_title',
                                              'image',
                                              'brand_id',
                                              'url_special',
                                              $brand_url_field),
                                        'enabled = 1 AND (0 = 1 '         // where
                                                       . ($brand_by_name         ? 'OR (' . $brand_name_filter . ') '          : '')
                                                       . ($brand_by_metatitle    ? 'OR (' . $brand_meta_title_filter . ') '    : '')
                                                       . ($brand_by_metakeywords ? 'OR (' . $brand_meta_keywords_filter . ') ' : '')
                                                       . ($brand_by_body         ? 'OR (' . $brand_body_filter . ') '          : '')
                                                       . ($brand_by_tags         ? 'OR (' . $brand_tags_filter . ')'           : '')
                                                       . ')',
                                        '',                               // group by
                                        '',                               // having
                                        'name ASC',                       // order by
                                        0,                                // limit (индекс начального)
                                        $brand_maxcount);                 // limit (сколько взять)
                if (!empty($brands)) {



                    // =================================================================
                    //
                    // Добавляем найденные бренды в ответ клиентской стороне
                    // автозавершителя поиска.
                    //
                    // Демонстрируемое название берем из мета заголовка страницы
                    // бренда или его названия, согласно соответствующей настройке
                    // клиенсткой части автозавершителя поиска.
                    //
                    // =================================================================

                    // перебираем отобранные бренды
                    foreach ($brands as & $brand) {

                        // готовим адрес картинки
                        $image = $brand->image;
                        if (($image != '')
                        && (strtolower(substr($image, 0, 5)) != 'http:'))
                          $image = $site_url . 'files/brands/' . $image;

                        // готовим название
                        $name = trim($brand_show_metatitle ? $brand->meta_title : '');
                        if ($name == '') $name = trim($brand->name);

                        // +1 предлагаемый бренд
                        if ($name != '') {
                            $response['suggestions'][] = $name;

                            // и все данные по этому предлагаемому бренду
                            $response['data'][] = array('type' => 'brand',
                                                        'image' => $image,
                                                        'brand_id' => $brand->brand_id,
                                                        'url' => $site_url
                                                               . (!$brand->url_special ? 'brands/' : '')
                                                               . $brand->url);
                        }
                    }
                }
            }
        }
    }



    // отправляем ответ в формате JSON
    echo json_encode($response);
    return;
?>
