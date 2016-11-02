<?php
    if (!defined('ROOT_FOLDER_REFERENCE')) exit;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) exit;

    // подложка модуля клиентской стороны
    require_once(ROOT_FOLDER_REFERENCE
               . FOLDERNAME_FOR_ENGINE_OBJECTS
               . '/ClientSubstrate.php');

    // какой файл является шаблоном прайс-листа на клиентской стороне (указываем без расширения)
    define('CLIENT_PRICELIST_CLASS_TEMPLATE_FILE', 'price');



    // =======================================================================
    /**
    *  Модуль прайс-листа на клиентской стороне
    *
    *  Использование этого класса происходит в результате переназначения класса
    *  Pricelist на данный класс во время загрузки модуля прайс-листа.
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class ClientPricelist extends ClientSubstrate {



        // ===================================================================
        /**
        *  Получение безопасного текста для вывода в XML-теге
        *
        *  @access  public
        *  @param   string  $text   исходный текст
        *  @param   boolean $uncaps TRUE если слова в верхнем регистре писать строчными
        *  @return  string          безопасный текст
        */
        // ===================================================================

        public function safeTagText ( $text, $uncaps = TRUE ) {
            $text = $this->text->stripTags($text, TRUE, FALSE);
            if ($uncaps) $text = $this->unCAPStext($text);
            return $this->text->escape($text, 'cp1251');
        }

        public function unCAPStext ( $text ) {
            $matches = null;
            $test = ' ' . $text;
            if (preg_match_all('~[0-9 \t\r\n\s\#\*\+\-_:;\.,"\'\?!\[\]\{\}\(\)/\\\\][A-ZА-ЯЁ][A-Z0-9А-ЯЁ]+~', $test, $matches, PREG_OFFSET_CAPTURE)) {
                if (is_array($matches) && !empty($matches[0])) {
                    $charset = 'cp1251';
                    $match = end($matches[0]);
                    while (is_array($match) && isset($match[0]) && isset($match[1])) {
                        $size = $this->text->length($match[0], $charset);
                        $text = $this->text->substr($match[0], 1, null, $charset);
                        $text = ucfirst($this->text->lowerCase($text, $charset));
                        $test = $this->text->substr($test, 0, $match[1] + 1, $charset)
                              . $text
                              . $this->text->substr($test, $match[1] + $size, null, $charset);
                        $match = prev($matches[0]);
                    }
                    $text = trim($test);
                }
            }
            return $text;
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

            // какой формат прайс-листа был указан во входном параметре?
            $format = strtolower($this->param(REQUEST_PARAM_NAME_PRICELIST_FORMAT));
            switch ($format) {

                // если для Яндекс.Маркет (файл yandex.xml)
                case PRICELIST_REQUEST_PARAM_VALUE_YANDEX:

                    // выводим контент виртуального файла yandex.xml
                    $this->fetch_yandex_pricelist();
                    exit;

                // иначе традиционный прайс-лист
                default:
                    $this->fetch_pricelist();
                    echo $this->body;
                    exit;
            }

            // возвращаем TRUE (продолжать открытие страницы) на случай, если модуль используют как плагин
            return TRUE;
        }



        // ===================================================================
        /**
        *  Вывод категорий файла yandex.xml
        *
        *  @access  private
        *  @param   array   $cats       массив категорий
        *  @param   array   $ids        массив ИДов категорий (будет возвращен сюда)
        *  @return  void
        */
        // ===================================================================

        private function outputYandexCategories ( & $cats, & $ids = array() ) {
            $CRLF = "\r\n";
            foreach ($cats as $item) {
                $id = intval($item->category_id);
                $ids[] = $id;
                echo '            <category id="' . $id . '"' . (!empty($item->parent) ? ' parentId="' . $item->parent . '"' : '') . '>' . $CRLF
                   . '                ' . $this->safeTagText($item->name) . $CRLF
                   . '            </category>' . $CRLF . $CRLF;
                if (!empty($item->subitems)) $this->outputYandexCategories($item->subitems, $ids);
            }
        }



        // ===================================================================
        /**
        *  Вывод контента виртуального файла yandex.xml
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function fetch_yandex_pricelist () {

            // извлекаем запрошенные номера файлов
            $nums = $this->param('nums');
            $nums = preg_replace('/[^0-9a-z-\.]/i', '_', $nums);
            $nums = trim($nums, '_');
            $nums = explode('_', $nums);



            // вычисляем маску сравнения для поля ymarket при таких номерах
            $mask = 1;
            if (! empty($nums)) {
                $mask = 0;
                foreach ($nums as $num) {
                    $num = intval($num) - 1;
                    $num = max($num, 0);
                    $num = min($num, 31);
                    $mask = $mask | 1 << $num;
                }
            }



            // будем возвращать страницу как XML-файл
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Type: text/xml');
            header('Content-disposition: attachment; filename="yandex.xml"');
            header('Content-Transfer-Encoding: binary');



            // переключаем базу данных на кодировку Windows-1251
            $charset = 'cp1251';
            $utf8 = FALSE;
            $this->db->set_charset($charset);
            $dbtable_cats = '`' . DATABASE_CATEGORIES_TABLENAME . '`';
            $dbtable_brands = '`' . DATABASE_BRANDS_TABLENAME . '`';
            $dbtable_prods = '`' . DATABASE_PRODUCTS_TABLENAME . '`';
            $dbtable_variants = '`' . DATABASE_PRODUCTS_VARIANTS_TABLENAME . '`';



            // читаем настройки сайта
            $items = null;
            $filter = new stdClass;
            $filter->mode = GET_SETTINGS_MODE_AS_SETTINGS;
            $this->db->settings->get($items, $filter);



            // выводим начальную часть контента
            $crlf = "\r\n";
            echo '<?xml version="1.0" encoding="Windows-1251" ?>' . $crlf
               . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . $crlf
               . '<yml_catalog date="' . date('Y-m-d H:i') . '">' . $crlf
               . '    <shop>' . $crlf;



            // выводим описание магазина:
            //   <name>     = Короткое название магазина - название, которое выводится в списке найденных на Яндекс.Маркете товаров.
            //                Оно не должно содержать более 20 символов. В названии нельзя использовать слова, не имеющие отношения
            //                к наименованию магазина (например: лучший, дешевый), указывать номер телефона и т.п. Название магазина
            //                должно совпадать с фактическим названием магазина, которое публикуется на сайте. При несоблюдении данного
            //                требования наименование может быть изменено Яндексом самостоятельно без уведомления магазина.
            //   <company>  = Полное наименование компании, владеющей магазином. Не публикуется, используется для внутренней идентификации.
            //   <url>      = URL главной страницы магазина
            //   <platform> = Система управления контентом (CMS), на основе которой работает магазин.
            //   <version>  = Версия CMS.
            //   <agency>   = Наименование агентства, которое оказывает техническую поддержку магазину и отвечает за работоспособность сайта.
            //   <email>    = Контактный адрес разработчиков CMS или агентства, осуществляющего техподдержку.
            echo '        <name>' . $crlf
               . '            ' . $this->text->escape(substr($this->text->stripTags($items->site_name, TRUE, $utf8), 0, 20), $charset) . $crlf
               . '        </name>' . $crlf . $crlf . $crlf . $crlf



               . '        <company>' . $crlf
               . '            ' . $this->safeTagText($items->company_name) . $crlf
               . '        </company>' . $crlf . $crlf

               . '        <url>' . $crlf
               . '            http://' . $this->text->escape($this->root_url, $charset) . $crlf
               . '        </url>' . $crlf . $crlf . $crlf . $crlf



               . '        <platform>' . $crlf
               . '            Impera CMS' . $crlf
               . '        </platform>' . $crlf . $crlf

               . '        <version>' . $crlf
               . '            ' . IMPERA_CMS_CURRENT_VERSION . $crlf
               . '        </version>' . $crlf . $crlf . $crlf . $crlf;



            // пока предполагаем, что цены в USD и курс будет по Центробанку РФ
            $rate = 1;
            $code = 'USD';
            $slave = '            <currency id="USD" rate="CBRF" />' . $crlf;



            // читаем валюту, выбранную для Яндекс.Маркет (может быть только RUR, RUB, BYR, UAH, KZT),
            // если не найдена, на втором проходе читаем валюту RUR
            $params = new stdClass;
            $params->enabled = 1;
            $params->ymarket = 1;
            $codes = explode(',', strtoupper(str_replace(' ', '', WORLD_CURRENCY_CODES)));
            $codes = array_flip($codes);
            do {
                $ymarket = null;
                $this->db->get_currency($ymarket, $params);
                if (!empty($ymarket->code)) {
                    $ymarket->code = strtoupper($this->text->stripTags($ymarket->code, TRUE, $utf8));
                    if ($ymarket->code == 'WMZ') $ymarket->code = 'USD';
                    if ($ymarket->code == 'WMU') $ymarket->code = 'UAH';
                    if ($ymarket->code == 'WMR') $ymarket->code = 'RUR';
                    if ($ymarket->code == 'WME') $ymarket->code = 'EUR';
                    if ($ymarket->code == 'WMY') $ymarket->code = 'UZS';
                    if ($ymarket->code == 'WMB') $ymarket->code = 'BYR';
                    if (!isset($codes[$ymarket->code])) $ymarket = null;
                    if (!empty($ymarket) && ($ymarket->code != 'RUR')
                    && ($ymarket->code != 'RUB') && ($ymarket->code != 'UAH')
                    && ($ymarket->code != 'BYR') && ($ymarket->code != 'KZT')) $ymarket = null;
                }
                if (!isset($params->ymarket)) break;
                $params->code = 'RUR';
                unset($params->ymarket);
            } while (empty($ymarket));

            // если выбранная валюта прошла проверку, берем ее курс
            if (!empty($ymarket)) {
                $rate = $ymarket->rate_from / $ymarket->rate_to;
                $code = $ymarket->code;
                $slave = '';
            }



            // выводим список валют:
            //   <currencies>             = Контейнер списка валют магазина.
            //   <currency id="" rate=""> = Информация о конкретной валюте. Параметр id указывает код одной или нескольких валют,
            //                              которые могут быть использованы в YML-файле. Параметр rate указывает курс валюты к курсу
            //                              основной валюты, взятой за единицу (валюта, для которой rate=1). Параметр rate может
            //                              иметь следующие значения: постоянное число - внутренний курс, который вы используете;
            //                              CBRF - курс по Центральному банку РФ; NBU - курс по Национальному банку Украины;
            //                              NBK - курс по Национальному банку Казахстана; СВ - курс по банку той страны, к которой
            //                              относится магазин по своему региону, указанному в партнерском интерфейсе. В качестве
            //                              основной валюты (для которой установлено rate=1) могут быть использованы только
            //                              рубль (RUR, RUB), белорусский рубль (BYR), гривна (UAH) или тенге (KZT).
            echo '        <currencies>' . $crlf
               . '            <currency id="' . (($slave == '') ? $this->text->escape($code, $charset) : 'RUR') . '" rate="1" />' . $crlf
               . $slave
               . '        </currencies>' . $crlf . $crlf . $crlf . $crlf;



            // читаем список незапрещенных и для экспорта в Яндекс.Маркет и незакрытых от чужих категорий
            $query = 'SELECT `category_id`, '
                          . '`parent`, '
                          . '`name`, '
                          . '`single_name`, '
                          . '`order_num` '
                   . 'FROM ' . $dbtable_cats . ' '
                   . 'WHERE `enabled` = 1 '
                         . 'AND `hidden` = 0 '
                         . 'AND (`ymarket` & ' . $mask . ') != 0 '
                   . 'ORDER BY `parent` ASC, '
                            . '`order_num` DESC;';
            $result = $this->db->query($query);



            // строим дерево категорий
            $used = array();
            if ($result !== FALSE) {
                while ($item = $this->db->fetch_object($result)) {
                    $id = intval($item->category_id);
                    $cid = intval($item->parent);
                    if ($cid != $id) {
                        if (isset($used[$id])) $item->subitems = & $used[$id]->subitems;
                        $used[$id] = $item;
                        if (!isset($used[$cid])) {
                            $used[$cid] = new stdClass;
                            $used[$cid]->subitems = array();
                        }
                        $used[$cid]->subitems[] = & $used[$id];
                    }
                }
            }

            // освобождаем память от запроса
            $this->db->free_result($result);



            // выводим список категорий:
            //   <categories>                 = Контейнер списка категорий.
            //   <category id="" parentId=""> = Информация о конкретной категории. Должна включать ее идентификатор (параметр id)
            //                                  для всех категорий и идентификатор категории более высокого уровня для подкатегорий.
            //                                  Идентификатор категории должен быть уникальным положительным целым числом. Ни у одной
            //                                  категории параметр id не может быть равен 0. Если элемент parentId не указан, то
            //                                  категория считается корневой.
            $ids = array();
            if (!empty($used[0]->subitems)) {
                echo '        <categories>' . $crlf . $crlf;
                $this->outputYandexCategories($used[0]->subitems, $ids);
                echo '        </categories>' . $crlf . $crlf . $crlf . $crlf;
            }



            // читаем список незапрещенных на сайте и для экспорта в Яндекс.Маркет и незакрытых от чужих товаров
            $query = 'SELECT ' . $dbtable_prods . '.`category_id`, '
                               . $dbtable_prods . '.`model`, '
                               . $dbtable_prods . '.`pcode`, '
                               . $dbtable_prods . '.`url`, '
                               . $dbtable_prods . '.`url_special`, '
                               . $dbtable_prods . '.`large_image`, '
                               . $dbtable_prods . '.`small_image`, '
                               . $dbtable_prods . '.`images`, '
                               . $dbtable_prods . '.`description`, '
                               . $dbtable_prods . '.`order_num`, '
                               . $dbtable_brands . '.`name` AS `brand`, '
                               . $dbtable_variants . '.`name` AS `variant_name`, '
                               . 'CASE WHEN ' . $dbtable_variants . '.`temp_price` != 0 '
                                    . 'THEN ABS(' . $dbtable_variants . '.`temp_price`) '
                                    . 'ELSE ABS(' . $dbtable_variants . '.`price`) * CASE WHEN (' . $dbtable_variants . '.`priority_discount` >= 0 AND ' . $dbtable_variants . '.`priority_discount` <= 100) '
                                                                                       . 'THEN (100 - ' . $dbtable_variants . '.`priority_discount`) / 100 '
                                                                                       . 'ELSE 1 '
                                                                                       . 'END '
                                    . 'END AS `price`, '
                               . $dbtable_variants . '.`variant_id`, '
                               . $dbtable_variants . '.`position` '
                   . 'FROM ' . $dbtable_variants . ', '
                             . $dbtable_prods . ' '
                   . 'LEFT JOIN ' . $dbtable_brands . ' '
                             . 'ON ' . $dbtable_brands . '.`brand_id` = ' . $dbtable_prods . '.`brand_id` '
                   . 'WHERE ' . $dbtable_prods . '.`enabled` = 1 '
                         . 'AND ' . $dbtable_prods . '.`non_usable` = 0 '
                         . 'AND ' . $dbtable_prods . '.`hidden` = 0 '
                         . 'AND (' . $dbtable_prods . '.`ymarket` & ' . $mask . ') != 0 '
                         . 'AND ' . $dbtable_variants . '.`stock` > 0 '
                         . 'AND (' . $dbtable_variants . '.`price` > 0 OR ' . $dbtable_variants . '.`temp_price` > 0) '
                         . 'AND ' . $dbtable_variants . '.`product_id` = ' . $dbtable_prods . '.`product_id` '
                         . 'AND ' . $dbtable_prods . '.`category_id` IN (' . implode(',', $ids) . ') '
                   . 'ORDER BY ' . $dbtable_prods . '.`order_num` DESC, '
                                 . $dbtable_variants . '.`position` ASC;';
            $result = $this->db->query($query);



            // выводим список товаров:
            //   <offers>                                           = Контейнер списка товаров.
            //   <offer id="" type="vendor.model" available="true"> = Информация о конкретном товаре.
            //     url                 = URL страницы товара. Максимальная длина URL - 255 символов. Необязательный элемент.
            //     price               = Цена, по которой данный товар можно приобрести. Цена товарного предложения округляется,
            //                           формат, в котором она отображается, зависит от настроек пользователя. Обязательный элемент.
            //     currencyId          = Идентификатор валюты товара (RUR, USD, UAH, KZT). Для корректного отображения цены
            //                           в национальной валюте необходимо использовать идентификатор (например, UAH) с соответствующим значением цены.
            //                           Обязательный элемент.
            //     categoryId          = Идентификатор категории товара (целое число не более 18 знаков). Товарное предложение может принадлежать
            //                           только одной категории. Обязательный элемент. Элемент offer может содержать только один элемент categoryId.
            //     picture             = Ссылка на картинку соответствующего товарного предложения. По указанному URL-адресу должна находиться картинка
            //                           формата jpeg, gif или png размером не меньше 100х100 пикселов. Картинки большего размера будут уменьшены автоматически.
            //                           Ссылка на HTML-страницу, содержащую картинку, не допустима. Недопустимо давать ссылку на "заглушку", то есть
            //                           на страницу, где написано "картинка отсутствует", или на логотип магазина. Необязательный элемент.
            //     typePrefix          = Группа товаров/категория. Необязательный элемент.
            //     vendor              = Производитель. Обязательный элемент.
            //     name                = Указывается заголовок товарного предложения (длина не более 255 символов). В качестве заголовка товарного предложения
            //                           рекомендуется указывать полное уникальное название товара. Если длина заголовка выходит за пределы допустимого значения,
            //                           то при публикации текст обрезается и в конце ставится многоточие. Элемент name применим в следующих типах описания
            //                           товарных предложений: упрощенном, book, audiobook, tour, event-ticket.
            //     model               = Модель. Обязательный элемент.
            //     store               = Элемент позволяет указать возможность купить соответствующий товар в розничном магазине. "false" - возможность
            //                           покупки в розничном магазине отсутствует. "true" - товар можно купить в розничном магазине. Необязательный элемент.
            //     pickup              = Элемент позволяет указать возможность зарезервировать выбранный товар и забрать его самостоятельно.
            //                           "false" - возможность самовывоза отсутствует. "true" - товар можно забрать самостоятельно. Необязательный элемент.
            //     delivery            = Элемент позволяет указать возможность доставки соответствующего товара. "false" - товар не может быть доставлен.
            //                           "true" - товар доставляется на условиях, которые описываются в партнерском интерфейсе в разделе "Параметры размещения".
            //                           Необязательный элемент.
            //     description         = Описание товарного предложения (длина не более 512 символов). Если длина описания выходит за пределы допустимого значения,
            //                           то при публикации текст обрезается и в конце ставится многоточие. Необязательный элемент.
            //     vendorCode          = Код товара (указывается код производителя). Необязательный элемент.
            //     local_delivery_cost = Стоимость доставки данного товара в своем регионе. Необязательный элемент.
            //     available           = Статус доступности товара - в наличии/на заказ. "false" - товарное предложение на заказ. Магазин готов осуществить
            //                           поставку товара на указанных условиях в течение месяца (срок может быть больше для товаров, которые всеми участниками
            //                           рынка поставляются только на заказ). Те товарные предложения, на которые заказы не принимаются, не должны выгружаться
            //                           на Яндекс.Маркет. "true" - товарное предложение в наличии. Магазин готов сразу договариваться с покупателем о доставке
            //                           товара. Дополнительная информация доступна в документе "Требованиях к рекламным материалам".
            //     sales_notes         = Элемент используется для отражения информации о минимальной сумме заказа, минимальной партии товара или необходимости
            //                           предоплаты, а так же для описания акций магазина (кроме скидок). Допустимая длина текста в элементе - 50 символов.
            //                           Необязательный элемент.
            //     manufacturer_warranty = Элемент предназначен для отметки товаров, имеющих официальную гарантию производителя. Необязательный элемент.
            //     country_of_origin   = Элемент предназначен для указания страны производства товара. Список стран, которые могут быть указаны в этом элементе,
            //                           доступен по адресу: http://partner.market.yandex.ru/pages/help/Countries.pdf. Необязательный элемент.
            //     downloadable        = Элемент предназначен для обозначения товара, который можно скачать. Необязательный элемент.
            //     adult               = Элемент обязателен для обозначения товара, имеющего отношение к удовлетворению сексуальных потребностей, либо иным
            //                           образом эксплуатирующего интерес к сексу. Необязательный элемент.
            //     barcode             = Штрихкод товара, указанный производителем. Могут быть указаны только цифры. Пробелы, символы и буквы при проверке
            //                           YML-файла будут восприниматься как ошибка. Штрихкод может содержать 8, 12 или 13 цифр. Штрихкоды, содержащие более 13 цифр,
            //                           используются для маркировки траспортной упаковки товара и для обмена данными между предприятиями. Такие штрихкоды передавать
            //                           не нужно. Если ваш магазин использует свою внутреннюю систему штрихкодов, отличных от штрихкодов производителей, передавать
            //                           такие внутренние штрихкоды не нужно. Необязательный элемент. Элемент offer может содержать несколько элементов barcode.
            //     param               = Элемент <param name='' unit=''>value</param> предназначен для указания характеристик товара. Для описания каждого параметра
            //                           используется отдельный элемент param. Необязательный элемент. Элемент offer может содержать несколько элементов param.
            echo '        <local_delivery_cost>0</local_delivery_cost>' . $crlf . $crlf
               . '        <offers>' . $crlf . $crlf;
            if ($result !== FALSE) {
                while ($item = $this->db->fetch_object($result)) {
                    if (!empty($item) && $item->price > 0) {
                        $model = $this->db->get_compound_product_model_text($item);

                        // добавляем к названию товара категорию в единственном числе
                        if (isset($used[$item->category_id])) $model = ltrim($used[$item->category_id]->single_name . ' ') . $model;

                        if ($model != '' && strlen($model) > 3) {
                            echo '            <offer id="' . $item->variant_id . (($item->brand != '') ? '" type="vendor.model' : '') . '" available="true">' . $crlf
                               . '                <url>http://' . $this->text->escape($this->root_url, $charset) . '/' . (!$item->url_special ? 'products/' : '') . $this->text->escape($item->url, $charset) . '</url>' . $crlf
                               . '                <price>' . str_replace(',', '.', $item->price * $rate) . '</price>' . $crlf
                               . '                <currencyId>' . $this->text->escape($code, $charset) . '</currencyId>' . $crlf
                               . '                <categoryId>' . $item->category_id . '</categoryId>' . $crlf;
                            // поправляем поля изображений
                            if (isset($item->large_image) && $item->large_image == '' && isset($item->small_image)) $item->large_image = $item->small_image;
                            $this->db->products->unpack_images($item);
                            $path = 'http://' . $this->root_url . '/' . $this->settings->products_files_folder_prefix . 'files/products/';
                            if (isset($item->large_image) && $item->large_image != '' && !preg_match('!^[a-z]+://!i', $item->large_image)) $item->large_image = $path . $item->large_image;
                            if ($item->large_image != '') {
                                if (strtolower(substr($item->large_image, 0, 5)) != 'http:' && strtolower(substr($item->large_image, 0, 6)) != 'https:') {
                                    echo '                <picture>http://' . $this->text->escape($this->root_url, $charset) . '/' . $this->text->escape($item->large_image, $charset) . '</picture>' . $crlf;
                                } else {
                                    echo '                <picture>' . $this->text->escape($item->large_image, $charset) . '</picture>' . $crlf;
                                }
                            }
                            if ($item->brand != '') {
                                echo '                <vendor>' . $this->safeTagText($item->brand) . '</vendor>' . $crlf;
                                if (isset($item->pcode) && trim($item->pcode) != '') echo '                <vendorCode>' . $this->safeTagText($item->pcode, FALSE) . '</vendorCode>' . $crlf;
                                echo '                <model>'
                                                        . $this->safeTagText($model)
                                                        . ($item->model != $item->variant_name && $item->variant_name != '' ? ' ' . $this->safeTagText($item->variant_name) : '')
                                                        . (isset($item->pcode) && trim($item->pcode) != '' ? '(' . $this->safeTagText($item->pcode, FALSE) . ')' : '')
                                                    . '</model>' . $crlf;
                            } else {
                                echo '                <name>'
                                                        . $this->safeTagText($model)
                                                        . ($item->model != $item->variant_name && $item->variant_name != '' ? ' ' . $this->safeTagText($item->variant_name) : '')
                                                        . (isset($item->pcode) && trim($item->pcode) != '' ? '(' . $this->safeTagText($item->pcode, FALSE) . ')' : '')
                                                    . '</name>' . $crlf;
                            }
                            if (isset($item->pcode) && trim($item->pcode) != '') {
                                echo '                <description>'
                                                       . '[' . $this->safeTagText($item->pcode, FALSE) . '] '
                                                       . $this->safeTagText($item->description)
                                                   . '</description>' . $crlf;
                            } else {
                                echo '                <description>'
                                                       . $this->safeTagText($item->description)
                                                   . '</description>' . $crlf;
                            }
                            echo '            </offer>' . $crlf . $crlf;
                        }
                    }
                }
            }

            // освобождаем память от запроса
            $this->db->free_result($result);
            unset($used);



            // выводим конечную часть контента
            echo '        </offers>' . $crlf
               . '    </shop>' . $crlf
               . '</yml_catalog>' . $crlf;
        }



        // ===================================================================
        /**
        *  Создание контента традиционного прайс-листа
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function fetch_pricelist () {

            // будем возвращать страницу как XLS-файл
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-disposition: attachment; filename="price_' . date('d-m-Y', time()) . '.xls"');
            header('Content-Transfer-Encoding: binary');

            // определяем выбранный номер прайс-листа
            $params = new stdClass;
            $number = isset($_REQUEST['num']) ? intval($_REQUEST['num']) : 1;
            if ($number < 1) $number = 1;
            if ($number > 8) $number = 8;
            $field = 'in_price' . $number;
            $params->$field = 1;

            // дополняем записи категорий списками незапрещенных и видимых пользователю товаров текущего раздела магазина
            $params->completeness = GET_PRODUCTS_COMPLETENESS_FOR_PRICES;
            $params->enabled = 1;
            if (!isset($this->user->user_id)) $params->hidden = 0;
            $params->section = $this->now_in_section;
            $params->discount = 0;
            if (isset($this->user->price_id)) $params->price_id = $this->user->price_id;
            $this->db->productize_categories($this->categories_tree, $this->categories, $params);

            // передаем данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef(SMARTY_VAR_CATALOG, $this->categories_tree);
            $this->smarty->assign(SMARTY_VAR_PRICELIST_NUMBER, $number);
            $this->smarty->fetchByTemplate($this, CLIENT_PRICELIST_CLASS_TEMPLATE_FILE . ($number > 1 ? $number : ''), 'price');

            // удаляем из записей категорий списки товаров (освобождаем место в памяти)
            $this->db->unproductize_categories($this->categories);
        }
    }



    return;
?>