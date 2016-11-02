<?php
    // =======================================================================
    /**
    *  Дополнительные теги шаблонизатора Smarty
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class SmartyTagsANYModel {

        // объект движка
        protected $cms = null;

        // число демо фотографий товаров (для работы в демо режиме)
        protected $demo_mode_images_count = 15;
        protected $demo_mode_images = array();



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   object  $cms        объект движка
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $cms ) {

            // запоминаем выход на объект движка
            $this->cms = & $cms;

            // подключаем наши функции и модификаторы Smarty
            $this->setSmartyPlugins($cms);
        }



        // ===================================================================
        /**
        *  Подключение наших функций и модификаторов в шаблонизатор Smarty
        *
        *  Также в шаблоне можно использовать методы через $helper->метод(параметры):
        *      inputInFields
        *      currencyRate
        *      priceForScreen
        *      hasDiscount
        *      maybeSale
        *      stringAsSentence
        *      existsUser
        *      getProperty
        *
        *  -------------------------------------------------------------------
        *
        *  @access  protected
        *  @param   object  $cms        объект движка
        *  @return  void
        */
        // ===================================================================

        protected function setSmartyPlugins ( & $cms ) {

            // список функций (блочные указываем в квадратных скобках)
            $tags = array('site', 'siteAdmin',
                          'theme', 'themeAdmin', 'token',
                          'messageBox', 'plainText', 'echoVar',
                          'inputName', 'inputValue', /* метод inputInFields */
                          'flagClasses',
                          'image', 'findImage',
                          'url', 'cartUrl', 'name', 'body', 'annotation',
                          'title', 'content',
                          'sign',
                          'discountPrice', /* метод currencyRate,
                                              метод priceForScreen,
                                              метод hasDiscount,
                                              метод maybeSale */
                          'discountProducts', 'highlightedProducts', 'lastProducts', 'landingProducts',
                          'products', 'productKits',
                          'articles', 'news', 'lastComments',
//                          'mainProducts', 'mixCatalog', 'shopTweets',
                          'searchHistory',
                          'categories', 'getBranch',
                          'menuByLangTechName',
                          'bannerImages',
                          'randomId',
                          'requestUri',
                          'header301', 'header403', 'header404', 'header410',
                          'lastTemplate', '[htmCache]', 'includeHtml',
                          'dumpStructure', /* метод stringAsSentence,
                                              метод existsUser,
                                              метод getProperty */
                          'siteTotalSpace', 'siteFreeSpace', 'siteUsedSpace');

            // подключаем
            foreach ($tags as $tag) {
                $name = trim($tag, '[]');
                $cms->smarty->registerPlugin($tag == $name ? 'function' : 'block', $name, array($this, $name));
            }

            // делаем доступным шаблонизационный объект
            $cms->smarty->assignByRef('helper', $this);
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как строки (анти трейлинг)
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию пустая строка)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParam ( $field, & $params, $def = '' ) {
            return isset($params[$field])
                   && (is_string($params[$field])
                   || is_numeric($params[$field])
                   || is_bool($params[$field])) ? trim($params[$field]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как печатного предложения (анти
        *  трейлинг, оптимизация пробелов)
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию пустая строка)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParamAsSentence ( $field, & $params, $def = '' ) {
            if (!isset($params[$field])
                || !is_string($params[$field])
                   && !is_numeric($params[$field])
                   && !is_bool($params[$field])) return $def;
            return $this->stringAsSentence($params[$field]);
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как целого числа
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию 0)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParamAsInteger ( $field, & $params, $def = 0 ) {
            return isset($params[$field])
                   && (is_string($params[$field])
                   || is_numeric($params[$field])
                   || is_bool($params[$field])) ? intval($params[$field]) : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как булевого флага
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию FALSE)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParamAsBoolean ( $field, & $params, $def = FALSE ) {
            return isset($params[$field]) ? $params[$field] == TRUE : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как массива
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию пустой массив)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParamAsArray ( $field, & $params, $def = array() ) {
            return isset($params[$field]) && is_array($params[$field]) ? $params[$field] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как массива или объекта
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию пустой массив)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParamAsArrayOrObject ( $field, & $params, $def = array() ) {
            return isset($params[$field])
                && (is_array($params[$field]) || is_object($params[$field])) ? $params[$field] : $def;
        }



        // ===================================================================
        /**
        *  Извлечение параметра вызова как объекта
        *
        *  @access  protected
        *  @param   string  $field      имя параметра
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   mixed   $def        значение по умолчанию (по умолчанию null)
        *  @return  mixed               значение параметра
        */
        // ===================================================================

        protected function getParamAsObject ( $field, & $params, $def = null ) {
            return isset($params[$field]) && is_object($params[$field]) ? $params[$field] : $def;
        }



        // ===================================================================
        /**
        *  Передача значения в переменную
        *
        *  @access  protected
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['scope'] = 'global' если возвращаемую переменную сделать глобальной
        *  @param   mixed   $value      значение
        *  @param   object  $smarty     локальный объект шаблонизатора Smarty
        *  @return  mixed               пустая строка если значение передано в переменную
        *                               значение если переменная не указана в параметрах
        */
        // ===================================================================

        protected function assignVar ( & $params, & $value, & $smarty ) {
            if (!is_object($smarty)) return $value;
            $field = 'var';
            if (empty($params[$field]) || !is_string($params[$field])) {
                $field = 'assign';
                if (empty($params[$field]) || !is_string($params[$field])) {
                    $field = 'result';
                    if (empty($params[$field]) || !is_string($params[$field])) return $value;
                }
            }
            $smarty->assignByRef($params[$field], $value);
            if ($this->getParamAsSentence('scope', $params) == 'global') {
                $this->cms->smarty->assignByRef($params[$field], $value);
            }
            return '';
        }



        // ===================================================================
        /**
        *  Извлечение значения переменной шаблонизатора
        *
        *  @access  protected
        *  @param   string  $name       имя переменной
        *  @param   object  $smarty     локальный объект шаблонизатора Smarty
        *  @return  mixed               значение переменной
        *                               NULL если такой переменной нет
        */
        // ===================================================================

        protected function getTemplateVar ( $name, & $smarty ) {
            $item = null;
            $found = FALSE;
            $names = explode('->', $name);
            foreach ($names as $name) {
                $name = trim($name);
                if ($name != '') {
                    if (!$found) {
                        if (is_object($smarty)) $item = $smarty->getTemplateVars($name);
                        if (is_null($item)) $item = $this->cms->smarty->getTemplateVars($name);
                        if (is_null($item)) break;
                        $found = TRUE;
                    } else {
                        if (is_object($item) && isset($item->$name)) {
                            $item = & $item->$name;
                        } elseif (is_array($item) && isset($item[$name])) {
                            $item = & $item[$name];
                        } elseif (is_array($item) && strval(intval($name)) === $name && isset($item[intval($name)])) {
                            $item = & $item[intval($name)];
                        } else {
                            $item = null;
                            break;
                        }
                    }
                }
            }
            return $item;
        }



        // ===================================================================
        /**
        *  Обнаружение переменной $item в параметрах вызова или в области видимости
        *
        *  @access  protected
        *  @param   array   $params         массив параметров, указанных в вызове:
        *                                       ['item'] = запись о чем-либо (по умолчанию
        *                                                  ищется такая же переменная)
        *  @param   object  $smarty         локальный объект шаблонизатора Smarty
        *  @param   boolean $maybe_array    TRUE если вместо объекта может быть массив (по умолчанию FALSE)
        *  @return  void
        */
        // ===================================================================

        protected function resolveItem ( & $params, & $smarty, $maybe_array = FALSE ) {
            $field = 'item';
            if (!isset($params[$field])) {
                $item = $this->getTemplateVar($field, $smarty);
                if (is_object($item) || $maybe_array && is_array($item)) {
                    if (!is_array($params)) $params = array();
                    $params[$field] = & $item;
                }
            }
        }



        // ===================================================================
        /**
        *  Обнаружение объекта в параметрах вызова from или item
        *
        *  @access  protected
        *  @param   array   $params         массив параметров, указанных в вызове:
        *                                       ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                       ['item'] = запись о чем-либо (по умолчанию
        *                                                  ищется такая же переменная)
        *  @param   object  $smarty         локальный объект шаблонизатора Smarty
        *  @param   boolean $maybe_array    TRUE если вместо объекта может быть массив (по умолчанию FALSE)
        *  @return  void
        */
        // ===================================================================

        protected function resolveFromOrItem ( & $params, & $smarty, $maybe_array = FALSE ) {
            $field = 'item';
            if (!isset($params[$field])) {
                $item = $this->getParamAsSentence('from', $params);
                if ($item != '') $item = $this->getTemplateVar($item, $smarty);
                if (is_object($item) || $maybe_array && is_array($item)) {
                    if (!is_array($params)) $params = array();
                    $params[$field] = & $item;
                } else $this->resolveItem($params, $smarty, $maybe_array);
            }
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции site
        *
        *  Типичное применение: {site}
        *  Полный формат вызова: {site [root=TRUE] [domain=TRUE] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url корневой папки магазина, например
        *  http://сайт.магазина/корневая_папка/. Выводимый url завершен
        *  слешем и экранирует спецсимволы, то есть безопасен для использования
        *  в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['root'] = TRUE если вывести url корня сайта (по умолчанию FALSE)
        *                                   ['domain'] = TRUE если вывести домен сайта (по умолчанию FALSE)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес корня клиентской стороны
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function site ( $params = null, & $smarty = null ) {
            $url = trim($this->cms->site_url);
            if (!empty($params['root'])) $url = preg_replace('!^([a-z]+:[/\\\\]{2}[^/\\\\]+[/\\\\]).*$!u', '$1', $url);
            if (!empty($params['domain'])) $url = preg_replace('!^[a-z]+:[/\\\\]{2}([^/\\\\]+)[/\\\\].*$!u', '$1', $url);
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции siteAdmin
        *
        *  Типичное применение: {siteAdmin}
        *  Полный формат вызова: {siteAdmin [root=TRUE] [domain=TRUE] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url корневой папки админпанели магазина, например
        *  http://сайт.магазина/корневая_папка/admin/. Выводимый url завершен
        *  слешем и экранирует спецсимволы, то есть безопасен для использования
        *  в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['root'] = TRUE если вывести url корня сайта (по умолчанию FALSE)
        *                                   ['domain'] = TRUE если вывести домен сайта (по умолчанию FALSE)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес корня клиентской стороны
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function siteAdmin ( $params = null, & $smarty = null ) {
            $url = trim($this->cms->site_url)
                 . $this->cms->hdd->safeFilename($this->cms->admin_folder) . '/';
            if (!empty($params['root'])) $url = preg_replace('!^([a-z]+:[/\\\\]{2}[^/\\\\]+[/\\\\]).*$!u', '$1', $url);
            if (!empty($params['domain'])) $url = preg_replace('!^[a-z]+:[/\\\\]{2}([^/\\\\]+)[/\\\\].*$!u', '$1', $url);
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции theme
        *
        *  Типичное применение: {theme}
        *  Полный формат вызова: {theme [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url корневой папки текущего шаблона клиентской
        *  стороны сайта, например http://сайт.магазина/design/ваш_шаблон/.
        *  Выводимый url завершен слешем и экранирует спецсимволы, то есть
        *  безопасен для использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес папки текущего шаблона клиентской стороны
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function theme ( $params = null, & $smarty = null ) {
            $url = trim($this->cms->theme_url);
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции themeAdmin
        *
        *  Типичное применение: {themeAdmin}
        *  Полный формат вызова: {themeAdmin [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url корневой папки текущего шаблона админской
        *  стороны сайта, например http://сайт.магазина/admin/design/ваш_шаблон/.
        *  Выводимый url завершен слешем и экранирует спецсимволы, то есть
        *  безопасен для использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес папки текущего шаблона админской стороны
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function themeAdmin ( $params = null, & $smarty = null ) {
            $url = trim($this->cms->site_url)
                 . $this->cms->hdd->safeFilename($this->cms->admin_folder)
                 . '/design/'
                 . $this->cms->request->settings->getAsSentence('admin_theme') . '/';
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции token
        *
        *  Типичное применение: {token}
        *  Полный формат вызова: {token [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит текущий токен (аутентификатор операции) админпанели.
        *  Выводимый токен экранирует спецсимволы, то есть безопасен для
        *  использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              токен
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function token ( $params = null, & $smarty = null ) {
            $value = $this->getTemplateVar('inputs', $smarty);
            $value = isset($value['token']) ? $value['token'] : null;
            if (is_null($value)) $value = $this->getTemplateVar('token', $smarty);
            if (is_null($value)) $value = $this->getTemplateVar('Token', $smarty);
            if (!is_string($value) && !is_numeric($value)) $value = '';
            $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $value, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции messageBox
        *
        *  Типичное применение: {messageBox from=DesiredVariable}
        *  Полный формат вызова: {messageBox [from=DesiredVariable [def=$message]] [opentag='html' [id='id'] [css='class']] [closetag='html'] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит html-фрагмент сообщения из соответствующей
        *  переменной или входного текста, если содержит непустую строку.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['from'] = имя переменной, из которой брать текст (по умолчанию нет)
        *                                       ['def'] = дефолтный текст сообщения (по умолчанию пустая строка)
        *                                   ['opentag'] = открывающий тег (по умолчанию контейнер <div [id="*"] [class="*"]>)
        *                                       ['id'] = идентификатор дефолтного контейнера (по умолчанию без ИД)
        *                                       ['css'] = имя класса дефолтного контейнера (пустая строка = без класса,
        *                                                 по умолчанию имя переменной, и если та не задана = information)
        *                                   ['closetag'] = закрывающий тег (по умолчанию </div>)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              html-фрагмент
        *                               пустая строка если сообщение не найдено
        */
        // ===================================================================

        public function messageBox ( $params = null, & $smarty = null ) {
            $varname = $this->getParamAsSentence('from', $params);
            $text = $varname == '' ? FALSE : $this->getTemplateVar($varname, $smarty);
            if (!is_string($text)) $text = $this->getParam('def', $params);
            if ($text != '') {
                $varname = preg_replace('/[^a-z0-9\-_]/', '', $varname);
                $id = $this->getParamAsSentence('id', $params);
                $class = $this->getParamAsSentence('css', $params, $varname == '' ? 'information' : $varname);
                $begin = '<div' . ($id != '' ? ' id="' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . '"' : '')
                                . ($class != '' ? ' class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"' : '') . '>';
                $begin = $this->getParam('opentag', $params, $begin);
                $end = $this->getParam('closetag', $params, '</div>');
                $text = $begin . $text . $end;
            }
            return $this->assignVar($params, $text, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции plainText
        *
        *  Типичное применение: {plainText from=DesiredVariable}
        *  Полный формат вызова: {plainText [from=DesiredVariable [def=$message]] [size=$maxSize] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит очищенный от html-тегов текст из соответствующей
        *  переменной или входного текста, если содержит непустую строку.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['from'] = имя переменной, из которой брать текст (по умолчанию нет)
        *                                       ['def'] = дефолтный текст (по умолчанию пустая строка)
        *                                   ['size'] = размер текста до троеточия (по умолчанию 8192)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              текст
        *                               пустая строка если текст не найден
        */
        // ===================================================================

        public function plainText ( $params = null, & $smarty = null ) {
            $varname = $this->getParamAsSentence('from', $params);
            $text = $varname == '' ? FALSE : $this->getTemplateVar($varname, $smarty);
            if (!is_string($text) && !is_numeric($text)) $text = $this->getParam('def', $params);
            if ($text != '') {
                $text = str_replace('&nbsp;', ' ', $text);
                $text = $this->cms->text->stripTags($text);
                $text = $this->stringAsSentence($text);

                $max = $this->getParamAsInteger('size', $params, 8192);
                $max = max($max, 1);
                if ($this->cms->text->length($text) > $max) $text = $this->cms->text->substr($text, 0, $max) . '...';
            }
            return $this->assignVar($params, $text, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции echoVar
        *
        *  Типичное применение: {echoVar from=DesiredVariable}
        *  Полный формат вызова: {echoVar [from=DesiredVariable [def=$message]] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит текст из соответствующей переменной или входного
        *  текста, если содержит непустую строку.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['from'] = имя переменной, из которой брать текст (по умолчанию нет)
        *                                       ['def'] = дефолтный текст (по умолчанию пустая строка)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              текст
        *                               пустая строка если текст не найден
        */
        // ===================================================================

        public function echoVar ( $params = null, & $smarty = null ) {
            $varname = $this->getParamAsSentence('from', $params);
            $text = $varname == '' ? FALSE : $this->getTemplateVar($varname, $smarty);
            if (!is_string($text) && !is_numeric($text)) $text = $this->getParam('def', $params);
            return $this->assignVar($params, $text, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции inputName
        *
        *  Типичное применение: {inputName from=DesiredVariable}
        *                       {inputName from=DesiredVariable bad=''}
        *  Полный формат вызова: {inputName [from=DesiredVariable] [bad=BadFieldsVariable] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит указанное имя для атрибута name тега input, а
        *  если указана переменная со списком ошибочных полей и такое имя
        *  находится в этом списке, тогда выводит ИМЯ" DATA-BAD="ОПИСАНИЕ.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['from'] = имя переменной, как будет назван input (по умолчанию нет)
        *                                   ['bad'] = имя переменной списка полей с ошибками (по умолчанию bad_fields)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              имя
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function inputName ( $params = null, & $smarty = null ) {
            $name = $this->getParamAsSentence('from', $params);
            if ($name != '') {
                $bad = $this->getParamAsSentence('bad', $params, 'bad_fields');
                if ($bad != '') {
                    $bad = $this->getTemplateVar($bad, $smarty);
                    $bad = is_array($bad) && isset($bad[$name])
                               ? (is_string($bad[$name]) || is_numeric($bad[$name])
                                     ? trim($bad[$name])
                                     : '')
                               : null;
                    $bad = is_string($bad) ? '" data-bad="' . htmlspecialchars($bad, ENT_QUOTES, 'UTF-8')
                                           : '';
                }
                $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . $bad;
            }
            return $this->assignVar($params, $name, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции inputValue
        *
        *  Типичное применение: {inputValue from=DesiredVariable}
        *  Полный формат вызова: {inputValue [from=DesiredVariable] [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит значение указанной переменной, безопасное для
        *  использования в атрибуте value тега input.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *                                   ['from'] = имя переменной, из которой брать значение (по умолчанию нет)
        *                                   ['def'] = дефолтное значение (по умолчанию пустая строка)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              значение
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function inputValue ( $params = null, & $smarty = null ) {
            $varname = $this->getParamAsSentence('from', $params);
            $value = $varname == '' ? null : $this->getTemplateVar($varname, $smarty);
            if (is_null($value)) {
                $value = $this->getParam('def', $params);
            } else if (empty($value)) {
                $def = $this->getParam('def', $params, null);
                if (!is_null($def)) $value = $def;
            }
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $value, $smarty);
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - inputInFields
        *
        *  Типичное применение: {if $helper->inputInFields($name, $fields)}
        *  Полный формат вызова: {if $helper->inputInFields($name, $fields, $prefix)}
        *
        *  Действие: возвращает на выход булевой признак, если указанное
        *  поле находится в списке обрабатываемых полей.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   string  $name       имя искомого поля
        *  @param   array   $fields     массив обрабатываемых полей, формат элемента:
        *                                   'поле' ИЛИ
        *                                   'поле' => значение ИЛИ
        *                                   'поле' => array(значение, значение2, ...) ИЛИ
        *                                   array('поле' => значение, 'поле2', ...)
        *  @param   string  $prefix     префикс имен полей (пометка целевого модуля)
        *  @return  boolean             TRUE если поле находится в списке
        */
        // ===================================================================

        public function inputInFields ( $name, $fields, $prefix = '' ) {

            // если в именах полей используют префикс, отсекаем его
            if (is_string($prefix) || is_numeric($prefix)) {
                $prefix = trim($prefix);
                if ($prefix != '') {
                    $size = strlen($prefix);
                    if (substr($name, 0, $size) == $prefix) $name = substr($name, $size);
                }
            }

            // ищем поле в списке обрабатываемых
            return $name != '' && $this->cms->request->existsInFields($name, $fields);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции flagClasses
        *
        *  Типичное применение: {flagClasses flags=$fieldList}
        *  Полный формат вызова: {flagClasses [item=$record | from=DesiredVariable] flags=$fieldList [always=$class] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит теговый атрибут class с именами классов,
        *  ассоциированных с включенными флагами указанной записи (например
        *  class="hit newest highlighted").
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['flags'] = массив флаги-классы, формат элемента:
        *                                                   'проверяемый_флаг' => 'назначаемый_класс' ИЛИ
        *                                                   'проверяемый_флаг' (в этом случае имя класса равно имени флага)
        *                                   ['always'] = строка обязательных классов (по умолчанию пустая строка)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              сформированный атрибут class
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function flagClasses ( $params = null, & $smarty = null ) {

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            // обязательные классы
            $class = $this->getParamAsSentence('always', $params);

            // ищем влюченные флаги и добавляем их классы
            if (isset($params[$field])) {
                $flags = $this->getParamAsArray('flags', $params);
                if (!empty($flags)) {
                    foreach ($flags as $flag => $subclass) {
                        if (!is_string($flag) && is_string($subclass)) $flag = $subclass;
                        if (is_string($flag) && is_string($subclass)) {
                            $flag = trim($flag);
                            if ($flag != '') {
                                $subclass = trim($subclass);
                                if ($subclass != '') {
                                    if (!empty($params[$field]->$flag)) {
                                        $class .= ($class != '' ? ' ' : '') . $subclass;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // возвращаем атрибут
            if ($class != '') $class = 'class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '"';
            return $this->assignVar($params, $class, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции image
        *
        *  Типичное применение: {image}
        *  Полный формат вызова: {image [item=$record | from=DesiredVariable] [num=$imgNumber] [folder='files/images/example/'] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url указанной картинки, присутствующей в записи
        *  о товаре (действует и для других типов записей, но основное
        *  назначение - для товаров). В демо режиме вместо реальной картинки
        *  выводит случайный url одной из 15 демо картинок, расположенных
        *  в текущем шаблоне под именами папка_шаблона/images/demo/product-N.jpg
        *  (где N - число от 1 до 15). В рабочем режиме для товара без картинок
        *  или содержащем меньше картинок, чем номер запрашиваемой к выводу,
        *  выведет url картинки "нет фото", расположенной в текущем шаблоне
        *  под именем папка_шаблона/images/no-photo.png.
        *
        *  ВАЖНО: В ЭТОМ ОБРАБОТЧИКЕ ОТСУТСТВУЕТ ПОДДЕРЖКА ФУНКЦИИ "НЕСКОЛЬКО
        *  МАГАЗИНОВ НА ОДНОМ ДВИЖКЕ". ТО ЕСТЬ НЕ КОНТРОЛИРУЕТСЯ МАГАЗИННЫЙ
        *  ПРЕФИКС ТИПОВОГО ПУТИ.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['num'] = номер картинки (по умолчанию 1)
        *                                   ['folder'] = типовой путь (относительно корня сайта)
        *                                                к папке картинок соответствующего
        *                                                типа записей (по умолчанию пустой)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес картинки
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function image ( $params = null, & $smarty = null ) {

            // адрес корня клиентской стороны
            $site = trim($this->cms->site_url);
            $theme = trim($this->cms->theme_url);

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            // это демо режим и в шаблоне есть папка с его картинками (.jpg или .png)?
            $demo = $this->cms->config->demo;
            $demo_ext = '.jpg';
            if ($demo) {
                $path = dirname(__FILE__) . '/../../design/' . $this->cms->dynamic_theme . '/images/demo';
                $demo = $this->cms->hdd->isReadableFolder($path);
                if ($demo) {
                    $demo = $this->cms->hdd->isReadableFile($path . '/product-1' . $demo_ext);
                    if (!$demo) {
                        $demo_ext = '.png';
                        $demo = $this->cms->hdd->isReadableFile($path . '/product-1' . $demo_ext);
                    }
                }
            }

            // формируем адрес картинки
            if (!$demo && isset($params[$field])) {
                $id = $this->getParamAsInteger('num', $params);
                $id = max($id, 1) - 1;
                $url = '';

                // первая картинка
                if ($id == 0) {
                    if (isset($params[$field]->large_image)) $url = trim($params[$field]->large_image);
                    if ($url == '' && isset($params[$field]->small_image)) $url = trim($params[$field]->small_image);
                    if ($url == '') {
                        if (isset($params[$field]->image)) $url = trim($params[$field]->image);
                        if ($url == '' && isset($params[$field]->images[$id])) $url = trim($params[$field]->images[$id]);
                    }

                    // может есть в описании?
                    $test = array('body', 'description', 'annotation');
                    while ($url == '' && !empty($test)) {
                        $text = array_pop($test);
                        if (isset($params[$field]->$text)) {
                            $text = str_replace('&nbsp;', ' ', str_replace('&amp;', '&', $params[$field]->$text));
                            $url = preg_replace('/^.*?<img[^<>]+?src=[\'"]([^<>\'"\s\t\r\n]+).+$/uis', '$1', $text);
                            if ($url == $text) $url = ''; else {

                                // в описаниях картинки уже с типовым путем
                                if (isset($params['folder'])) unset($params['folder']);
                            }
                        }
                    }

                // остальные картинки
                } else {
                    $id--;
                    if ($url == '' && isset($params[$field]->images[$id])) $url = trim($params[$field]->images[$id]);
                    if ($url == '' && isset($params[$field]->fotos[$id]->filename)) $url = trim($params[$field]->fotos[$id]->filename);
                }

                // если у записи нет картинок или их меньше, чем номер запрашиваемой
                if ($url == '') {
                    $url = $theme . 'images/no-photo.png';
                } else {

                    // если картинка хранится на нашем сайте
                    if (!preg_match('!^[a-z]+://!ui', $url)) {
                        $folder = $this->getParam('folder', $params);
                        $folder = str_replace('\\', '/', $folder);
                        $folder = ltrim(rtrim($folder, "./ \r\n\t") . '/', "/ \r\n\t");
                        $url = ltrim($url, "/\\ \r\n\t");
                        // TODO: сделать здесь контроль префикса типового пути
                        if (str_replace('\\', '/', substr($url, 0, strlen($folder))) != $folder) $url = $folder . $url;
                        $url = $site . $url;
                    }
                }

            // в демо режиме выбираем случайные демо картинки
            } else {
                if (!isset($this->demo_mode_images) || !is_array($this->demo_mode_images) || empty($this->demo_mode_images)) {
                    $this->demo_mode_images = array();
                    if (isset($this->cms->designer->demo_mode_images_count)) {
                        $this->demo_mode_images_count = $this->cms->designer->demo_mode_images_count;
                    }
                    if (!isset($this->demo_mode_images_count)) $this->demo_mode_images_count = 15;
                    for ($i = 1; $i <= $this->demo_mode_images_count; $i++) $this->demo_mode_images[] = $i;
                    shuffle($this->demo_mode_images);
                }
                $i = array_shift($this->demo_mode_images);
                $this->demo_mode_images[] = $i;
                $url = $theme . 'images/demo/product-' . $i . $demo_ext;
            }

            // возвращаем адрес страницы
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции findImage
        *
        *  Типичное применение: {findImage type=RecordType}
        *  Полный формат вызова: {findImage [item=$record | from=DesiredVariable] [folder='files/images/example/' | type=RecordType] [num=$imgNumber] [view=FALSE] [alt=AltText] [desc=DescriptionText] [link=ImageLink] [fname=FilenameLeftPart] [def=NoPhotoFilename] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: возвращает массив сведений об искомой картинке,
        *  присутствующей в записи о чем-либо.
        *
        *  Элементы url, thumb и link возвращаются с экранированием спецсимволов,
        *  то есть в форме, безопасной для использования в атрибутах тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['folder'] = типовой путь (относительно корня сайта)
        *                                                к папке картинок соответствующего
        *                                                типа записей (по умолчанию пустой)
        *                                   ['type'] = тип записи (по умолчанию product)
        *                                   ['num'] = номер картинки (по умолчанию 1)
        *                                   ['view'] = TRUE если искать среди включенных (по умолчанию TRUE)
        *                                              FALSE если искать среди выключенных
        *                                              * если искать среди любых
        *                                   ['alt'] = искать с таким Alt-ом (по умолчанию нет)
        *                                   ['desc'] = искать с таким описанием (по умолчанию нет)
        *                                   ['fname'] = искать с таким началом имени файла (по умолчанию нет)
        *                                   ['def'] = имя картинки "нет фото" (по умолчанию no-photo.png)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  mixed               массив сведений
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function findImage ( $params = null, & $smarty = null ) {

            // адрес корня клиентской стороны
            $site = trim($this->cms->site_url);

            // готовим адрес картинки "нет фото"
            $theme = trim($this->cms->theme_url);
            $def = $this->getParamAsSentence('def', $params);
            $no_photo = $theme . 'images/' . ($def == '' ? 'no-photo.png' : $def);

            // готовим массив сведений
            $data = array( 'url' => htmlspecialchars($no_photo, ENT_QUOTES, 'UTF-8'),
                           'thumb' => htmlspecialchars($no_photo, ENT_QUOTES, 'UTF-8'),
                           'alt' => '',
                           'desc' => '',
                           'link' => '',
                           'view' => TRUE,
                           'found' => FALSE );

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            // получаем параметры поиска
            if (!empty($params[$field]->images) && is_array($params[$field]->images)) {
                $num = $this->getParamAsInteger('num', $params);
                $num = max($num, 1);

                $view = $this->getParam('view', $params, TRUE);
                $view = is_string($view) && $view == '*' ? '*' : $view == TRUE;

                $alt = $this->getParam('alt', $params, FALSE);
                if ($alt !== FALSE) $alt = $this->cms->text->lowerCase($alt);

                $desc = $this->getParam('desc', $params, FALSE);
                if ($desc !== FALSE) $desc = $this->cms->text->lowerCase($desc);

                $link = $this->getParam('link', $params, FALSE);
                if ($link !== FALSE) $link = $this->cms->text->lowerCase($link);

                $fname = $this->getParam('fname', $params, FALSE);
                $fname_size = 0;
                if ($fname !== FALSE) {
                    $fname = $this->cms->text->lowerCase($fname);
                    $fname_size = $this->cms->text->length($fname);
                }

                // ищем картинку
                foreach ($params[$field]->images as $key => $image) {
                    $image = trim($image);
                    if ($image == '') $image = $no_photo;
                    if ($fname === FALSE || $this->cms->text->substr($this->cms->text->lowerCase($image), 0, $fname_size) == $fname) {
                        $img_view = !empty($params[$field]->images_view[$key]);
                        if ($view === '*' || $view == $img_view) {
                            $img_alt = isset($params[$field]->images_alts[$key]) ? trim($params[$field]->images_alts[$key]) : '';
                            if ($alt === FALSE || $alt == $this->cms->text->lowerCase($img_alt)) {
                                $img_link = '';
                                $img_desc = isset($params[$field]->images_texts[$key]) ? trim($params[$field]->images_texts[$key]) : '';
                                if (preg_replace('!^([a-z]+:)?//!ui', '', $img_desc) != $img_desc) {
                                    $img_link = preg_replace('!^(([a-z]+:)?//[^\s]+)(\s.*)?$!uis', '$1', $img_desc);
                                    $img_desc = trim(preg_replace('!^(([a-z]+:)?//[^\s]+)(\s(.*))?$!uis', '$4', $img_desc));
                                }
                                if ($desc === FALSE || $desc == $this->cms->text->lowerCase($img_desc)) {
                                    if ($link === FALSE || $link == $this->cms->text->lowerCase($img_link)) {
                                        $num--;
                                        if ($num < 1) {

                                            // миниатюра
                                            $img_thumb = isset($params[$field]->images_thumbs[$key]) ? trim($params[$field]->images_thumbs[$key]) : '';
                                            if ($img_thumb == '') $img_thumb = $image;

                                            // типовой путь к папке картинок
                                            $type = $this->getParamAsSentence('type', $params, 'product');
                                            switch ($this->cms->text->lowerCase($type)) {
                                                case 'product': $type = 'files/products'; break;
                                                case 'category': $type = 'files/categories'; break;
                                                case 'brand': $type = 'files/brands'; break;
                                                case 'section': $type = 'files/images/sections'; break;
                                                case 'article': $type = 'files/images/articles'; break;
                                                case 'news': $type = 'files/images/news'; break;
                                                case 'country': $type = 'files/countries'; break;
                                                case 'region': $type = 'files/regions'; break;
                                                case 'town': $type = 'files/towns'; break;
                                                case 'file': $type = 'files/media'; break;
                                                case 'stock': $type = 'files/stocks'; break;
                                                case 'order': $type = 'files/orders'; break;
                                                default: $type = 'files/images';
                                            }
                                            $folder = $this->getParam('folder', $params, $type);
                                            $folder = str_replace('\\', '/', $folder);
                                            $folder = ltrim(rtrim($folder, "./ \r\n\t") . '/', "/ \r\n\t");

                                            // TODO: сделать здесь контроль префикса типового пути
                                            $prefix = '';

                                            // если картинка хранится на нашем сайте
                                            if (!preg_match('!^([a-z]+:)?//!ui', $image)) {
                                                $image = ltrim($image, "/\\ \r\n\t");
                                                if (str_replace('\\', '/', substr($image, 0, strlen($prefix . $folder))) == $prefix . $folder) {
                                                } else if (str_replace('\\', '/', substr($image, 0, strlen($folder))) == $folder) {
                                                    $image = $prefix . $image;
                                                } else {
                                                    $image = $prefix . $folder . $image;
                                                }
                                                $image = $site . $image;
                                            }
                                            if (!preg_match('!^([a-z]+:)?//!ui', $img_thumb)) {
                                                $img_thumb = ltrim($img_thumb, "/\\ \r\n\t");
                                                if (str_replace('\\', '/', substr($img_thumb, 0, strlen($prefix . $folder))) == $prefix . $folder) {
                                                } else if (str_replace('\\', '/', substr($img_thumb, 0, strlen($folder))) == $folder) {
                                                    $img_thumb = $prefix . $img_thumb;
                                                } else {
                                                    $img_thumb = $prefix . $folder . $img_thumb;
                                                }
                                                $img_thumb = $site . $img_thumb;
                                            }

                                            // заполняем массив сведений
                                            $data['url'] = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
                                            $data['thumb'] = htmlspecialchars($img_thumb, ENT_QUOTES, 'UTF-8');
                                            $data['alt'] = $img_alt;
                                            $data['desc'] = $img_desc;
                                            $data['link'] = htmlspecialchars($img_link, ENT_QUOTES, 'UTF-8');
                                            $data['view'] = $img_view;
                                            $data['found'] = TRUE;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // возвращаем массив сведений
            return $this->assignVar($params, $data, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции url
        *
        *  Типичное применение: {url}
        *  Полный формат вызова: {url [item=$record | from=DesiredVariable] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url клиентской страницы сайта, соответствующей
        *  указанной записи (например о товаре, категории, бренде, статье и
        *  т.п.). Выводимый url экранирует спецсимволы, то есть безопасен
        *  для использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес страницы
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function url ( $params = null, & $smarty = null ) {

            // адрес корня клиентской стороны
            $url = trim($this->cms->site_url);

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            // добавляем префиксную часть адреса
            if (isset($params[$field])) {
                if (isset($params[$field]->url_full)) {
                    $url .= rtrim(ltrim($params[$field]->url_full, '/ \\'));
                } else {
                    if (isset($params[$field]->url_path)) {
                        $url .= rtrim(ltrim($params[$field]->url_path, '/ \\'));
                    } elseif (empty($params[$field]->url_special)) {
                        if (isset($params[$field]->section_id)) $url .= 'sections/';
                        elseif (isset($params[$field]->product_id)) $url .= 'products/';
                        elseif (isset($params[$field]->kit_id)) $url .= 'kits/';
                        elseif (isset($params[$field]->article_id)) $url .= 'articles/';
                        elseif (isset($params[$field]->news_id)) $url .= 'news/';
                        elseif (isset($params[$field]->file_id)) $url .= 'media/';
                        elseif (isset($params[$field]->stock_id)) $url .= 'stocks/';
                        elseif (isset($params[$field]->brand_id)) $url .= 'brands/';
                        elseif (isset($params[$field]->event_id)) $url .= 'events/';
                        elseif (isset($params[$field]->country_id)) $url .= 'countries/';
                        elseif (isset($params[$field]->region_id)) $url .= 'regions/';
                        elseif (isset($params[$field]->town_id)) $url .= 'towns/';
                        elseif (isset($params[$field]->category_id)) $url .= 'catalog/';
                    }

                    // добавляем адрес
                    $url .= isset($params[$field]->url) ? rtrim(ltrim($params[$field]->url, '/ \\')) : '';
                }
            }

            // возвращаем адрес страницы
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции cartUrl
        *
        *  Типичное применение: {cartUrl}
        *  Полный формат вызова: {cartUrl [item=$record | from=DesiredVariable] [num=$variantNumber] [del=TRUE] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит url добавления в корзину (или удаления из нее)
        *  того варианта товара, чей порядковый номер указан и существует
        *  в переданной записи о товаре. Например http://сайт.магазина/cart/add/ид_варианта.
        *  Выводимый url экранирует спецсимволы, то есть безопасен для
        *  использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о товаре
        *                                   ['num'] = номер варианта товара (по умолчанию 1)
        *                                   ['del'] = TRUE если адрес удаления (по умолчанию FALSE)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              адрес страницы
        *                               пустая строка если выведено в указанную переменную
        *                                             или варианта с таким номером не существует
        */
        // ===================================================================

        public function cartUrl ( $params = null, & $smarty = null ) {

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            // ищем вариант товара с таким порядковым номером
            $url = '';
            if (isset($params[$field])) {
                $id = $this->getParamAsInteger('num', $params);
                $id = max($id, 1) - 1;
                if (!empty($params[$field]->variants[$id]->variant_id)) {

                    // адрес операции с корзиной
                    $url = empty($params['del']) ? 'add/' : 'delete/';
                    $url = trim($this->cms->site_url) . 'cart/' . $url;

                    // плюс ИД варианта
                    $url .= intval($params[$field]->variants[$id]->variant_id);
                }
            }

            // возвращаем адрес страницы
            $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции name
        *
        *  Типичное применение: {name}
        *  Полный формат вызова: {name [item=$record | from=DesiredVariable] [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит содержимое поля НАИМЕНОВАНИЕ указанной записи.
        *  Выводимое содержимое экранирует спецсимволы, то есть безопасно
        *  для использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['def'] = значение по умолчанию (по умолчанию Без названия!)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              наименование
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function name ( $params = null, & $smarty = null ) {

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            $name = $this->getParamAsSentence('def', $params, 'Без названия!');

            // ищем наименование среди предопределенных полей
            if (isset($params[$field])) {
                $fields = array('model', 'header', 'name', 'meta_title');
                foreach ($fields as $property) {
                    if (isset($params[$field]->$property) && is_string($params[$field]->$property)) {
                        $property = trim($params[$field]->$property);
                        if ($property != '') {
                            $name = $property;
                            break;
                        }
                    }
                }
            }

            // возвращаем наименование
            $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $name, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции body
        *
        *  Типичное применение: {body}
        *  Полный формат вызова: {body [item=$record | from=DesiredVariable] [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит содержимое поля ПОЛНОЕ ОПИСАНИЕ указанной записи.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['def'] = значение по умолчанию (по умолчанию пустая строка)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              описание
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function body ( $params = null, & $smarty = null ) {

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            $body = $this->getParamAsSentence('def', $params);

            // ищем описание среди предопределенных полей
            if (isset($params[$field])) {
                $fields = array('body', 'description', 'annotation');
                foreach ($fields as $property) {
                    if (isset($params[$field]->$property) && is_string($params[$field]->$property)) {
                        $property = trim($params[$field]->$property);
                        if ($property != '') {
                            $body = $property;
                            break;
                        }
                    }
                }
            }

            // возвращаем описание
            return $this->assignVar($params, $body, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции annotation
        *
        *  Типичное применение: {annotation}
        *  Полный формат вызова: {annotation [item=$record | from=DesiredVariable] [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит содержимое поля КРАТКОЕ ОПИСАНИЕ указанной записи.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['def'] = значение по умолчанию (по умолчанию пустая строка)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              описание
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function annotation ( $params = null, & $smarty = null ) {

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            $body = $this->getParamAsSentence('def', $params);

            // ищем описание среди предопределенных полей
            if (isset($params[$field])) {
                $fields = array('annotation', 'description', 'body');
                foreach ($fields as $property) {
                    if (isset($params[$field]->$property) && is_string($params[$field]->$property)) {
                        $property = trim($params[$field]->$property);
                        if ($property != '') {
                            $body = $property;
                            break;
                        }
                    }
                }
            }

            // возвращаем описание
            return $this->assignVar($params, $body, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции title
        *
        *  Типичное применение: {title}
        *  Полный формат вызова: {title [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит заголовочный текст страницы для тега <title>.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['def'] = значение по умолчанию (по умолчанию 'Страница не найдена!')
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              текст заголовка
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function title ( $params = null, & $smarty = null ) {
            $value = $this->getTemplateVar('title', $smarty);
            if (is_null($value)) $value = $this->getTemplateVar('Title', $smarty);
            if (is_string($value)) $value = $this->cms->text->stripTags($value, TRUE);
            if (empty($value) || !is_string($value) && !is_numeric($value)) {
                $value = $this->getParam('def', $params, 'Страница не найдена!');
            }
            return $this->assignVar($params, $value, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции content
        *
        *  Типичное применение: {content}
        *  Полный формат вызова: {content [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит контент страницы.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['def'] = значение по умолчанию (по умолчанию пустая строка)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              контент
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function content ( $params = null, & $smarty = null ) {
            $value = $this->getTemplateVar('content', $smarty);
            if (is_null($value)) $value = $this->getTemplateVar('Body', $smarty);
            if (empty($value) || !is_string($value) && !is_numeric($value)) {
                $value = $this->getParam('def', $params);
            }
            return $this->assignVar($params, $value, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции sign
        *
        *  Типичное применение: {sign}
        *  Полный формат вызова: {sign [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит знак текущей валюты. Выводимый знак экранирует
        *  спецсимволы, то есть безопасен для использования в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              знак валюты
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function sign ( $params = null, & $smarty = null ) {
            $sign = isset($this->cms->currency->sign) ? trim($this->cms->currency->sign) : '';
            $sign = htmlspecialchars($sign, ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $sign, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции discountPrice
        *
        *  Типичное применение: {discountPrice}
        *  Полный формат вызова: {discountPrice [item=$record | from=DesiredVariable] [num=$variantNumber] [signed=FALSE] [def=$defaultValue] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит цену (с учетом текущей скидки пользователя)
        *  указанного варианта товара, присутствующего в записи о товаре.
        *  Цена выводится в текущей валюте клиентской стороны сайта. Если
        *  цена содержит 00 копеек, выводится без копеек.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о товаре
        *                                   ['num'] = номер варианта товара (по умолчанию 1)
        *                                   ['signed'] = TRUE если со знаком валюты (по умолчанию TRUE)
        *                                   ['def'] = значение по умолчанию (по умолчанию пустая строка)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              строка цены с учетом скидки
        *                               пустая строка если выведено в указанную переменную
        *                                             или варианта с таким номером не существует
        */
        // ===================================================================

        public function discountPrice ( $params = null, & $smarty = null ) {

            // если вдруг нет такого варианта или поля цены
            $price = isset($params['def']) ? $params['def'] : '';

            // если указателя на запись нет, может есть такая переменная?
            $this->resolveFromOrItem($params, $smarty);
            $field = 'item';

            // ищем вариант и поле цены
            if (isset($params[$field])) {
                $id = $this->getParamAsInteger('num', $params);
                $id = max($id, 1) - 1;
                if (isset($params[$field]->variants[$id]->discount_price)) {

                    // вычисляем множитель курса текущей валюты
                    $rate = $this->currencyRate();

                    // вычисляем цену
                    $price = $this->cms->number->floatValue($params[$field]->variants[$id]->discount_price);
                    $price = sprintf('%1.2f', $price * $rate);
                    $price = str_replace(',', '.', $price);
                    $price = preg_replace('/\.00$/', '', $price);

                    // если просили вывести со знаком валюты
                    $field = 'signed';
                    if (!isset($params[$field]) || !empty($params[$field])) {
                        $price .= ' ' . $this->sign();
                    }
                }
            }

            // возвращаем цену
            return $this->assignVar($params, $price, $smarty);
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - currencyRate
        *
        *  Типичное применение: {$myVar = $helper->currencyRate()}
        *
        *  Действие: возвращает множитель для перевода цен из базовой валюты
        *  в текущую валюту.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @return  float               множитель
        */
        // ===================================================================

        public function currencyRate () {
            $rate = $this->cms->any->currency->rate(null, TRUE);
            if (isset($this->cms->currency) && is_object($this->cms->currency)) {
                $this->cms->currency->rate = $rate;
            }
            return $rate;
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - priceForScreen
        *
        *  Типичное применение: {$myVar = $helper->priceForScreen($price)}
        *  Полный формат вызова: {$myVar = $helper->priceForScreen($price, TRUE_or_FALSE, TRUE_or_FALSE)}
        *
        *  Действие: возвращает на выход указанную цену в печатном виде #.##
        *  для показа на странице.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   float   $price      цена
        *  @param   boolean $exchange   TRUE если вычислить цену по текущему курсу
        *  @param   boolean $compact    TRUE если убрать нулевые копейки .00
        *  @return  string              печатный вид цены
        */
        // ===================================================================

        public function priceForScreen ( $price, $exchange = TRUE, $compact = TRUE ) {
            $price = $this->cms->number->floatValue($price);

            // если просили, вычисляем по текущему курсу
            if ($exchange) {
                $rate = $this->currencyRate();
                $price = $price * $rate;
            }

            $price = str_replace(',', '.', sprintf('%1.2f', $price));
            if ($compact) $price = preg_replace('/\.00$/', '', $price);
            return $price;
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - hasDiscount
        *
        *  Типичное применение: {if $helper->hasDiscount($product)}
        *  Полный формат вызова: {if $helper->hasDiscount($product, $variantNumber, $returnRealPrice, $returnFinalPrice, $returnDiscountPercent)}
        *
        *  Действие: возвращает на выход булевой признак, если указанный
        *  вариант товара имеет действующую различимую скидку.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   object  $product    запись о товаре
        *  @param   integer $number     номер варианта товара (по умолчанию 1)
        *  @param   string  $real       исходная цена (будет возвращена в эту переменную в печатном виде)
        *  @param   string  $final      цена со скидкой (будет возвращена в эту переменную в печатном виде)
        *  @param   string  $percent    процент скидки (будет возвращен в эту переменную в печатном виде)
        *  @return  boolean             TRUE если имеет скидку
        */
        // ===================================================================

        public function hasDiscount ( & $product, $number = 1, & $real = '0', & $final = '0', & $percent = '0' ) {
            $real = '0';
            $final = '0';
            $percent = '0';
            if (empty($product->variants) || !is_array($product->variants)) return FALSE;
            $number = max(1, @ intval($number));
            foreach ($product->variants as & $variant) {
                $number--;
                if ($number == 0) {

                    // по какой цене отдаем (то есть цена с учетом текущих скидок покупателя)
                    $final = isset($variant->discount_price) ? $this->priceForScreen($variant->discount_price) : 0;

                    // может указана старая цена?
                    $real = isset($variant->old_price) ? $this->priceForScreen($variant->old_price) : 0;
                    if ($real > $final) {
                        $percent = 100 * (1 - $final / $real);
                        $percent = $this->priceForScreen($percent, FALSE);
                        return TRUE;
                    }

                    // настоящая цена товара
                    $real = isset($variant->price) ? $this->priceForScreen($variant->price) : 0;

                    // может указана приоритетная (неперекрываемая ничем) скидка?
                    $priority_discount = isset($variant->priority_discount) ? $this->priceForScreen($variant->priority_discount, FALSE) : -1;
                    if ($priority_discount > 0 && $real > $final) {
                        $percent = 100 * (1 - $final / $real);
                        $percent = $this->priceForScreen($percent, FALSE);
                        return TRUE;
                    }

                    // может указана акционная цена?
                    $actional = isset($variant->temp_price) ? $this->priceForScreen($variant->temp_price) : 0;
                    if ($actional > 0 && $real > $actional) {

                        // акция действует?
                        $now = date('YmdHis', time());
                        $start = isset($variant->temp_price_start) ? preg_replace('/[^0-9]/', '', $variant->temp_price_start) : 0;
                        if ($start == 0 || $start <= $now) {
                            $end = isset($variant->temp_price_date) ? preg_replace('/[^0-9]/', '', $variant->temp_price_date) : 0;
                            if ($end == 0 || $end >= $now) {

                                // набрано ли необходимое число участников для акции?
                                $members = isset($variant->temp_price_members) ? intval($variant->temp_price_members) : 0;
                                if ($members > 0) {
                                    $invited = isset($variant->temp_price_members) ? intval($variant->temp_price_members) : 0;
                                    if ($members > $invited) return FALSE;
                                }

                                $percent = 100 * (1 - $final / $real);
                                $percent = $this->priceForScreen($percent, FALSE);
                                return TRUE;
                            }
                        }
                    }
                    break;
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - maybeSale
        *
        *  Типичное применение: {if $helper->maybeSale($product)}
        *  Полный формат вызова: {if $helper->maybeSale($product, $variantNumber)}
        *
        *  Действие: возвращает на выход булевой признак, если указанный
        *  вариант товара может быть продан (есть на складе или разрешена
        *  продажа под заказ).
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   object  $product    запись о товаре
        *  @param   integer $number     номер варианта товара (по умолчанию 1)
        *  @return  boolean             TRUE если может быть продан (1 если это будет продажа под заказ)
        *                               FALSE если не может (0 если это экспонат)
        */
        // ===================================================================

        public function maybeSale ( & $product, $number = 1 ) {
            if (empty($product->variants) || !is_array($product->variants)) return FALSE;
            if (!empty($product->non_usable)) return 0;
            $number = max(1, @ intval($number));
            foreach ($product->variants as & $variant) {
                $number--;
                if ($number == 0) {
                    if (isset($variant->stock) && $variant->stock > 0) return TRUE;
                    if ($this->cms->request->settings->getAsBoolean('cart_enable_reservation')) return 1;
                    break;
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции discountProducts
        *
        *  Типичное применение: {discountProducts var=MyVariable}
        *  Полный формат вызова: {discountProducts var=MyVariable [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count товаров со скидками и
        *  помещает их в указанную smarty-переменную var, чтобы эти записи
        *  стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей (по умолчанию 240)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->discountProducts()}
        */
        // ===================================================================

        public function discountProducts ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 240);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем фильтр записей
            $filter = new stdClass;
            $filter->enabled = 1;
            if (!isset($user->user_id)) $filter->hidden = 0;
            $filter->sort = SORT_PRODUCTS_MODE_BY_CREATED;
            $filter->sort_direction = 1;
            $filter->discount = isset($user->discount) ? $user->discount : 0;
            $filter->price_id = isset($user->price_id) ? $user->price_id : 0;
            $filter->type = TYPE_PRODUCTS_DISCOUNTED;
            $filter->search_cost_from = 0.01;
            $filter->non_usable = -1;
            $filter->maxcount = $count;

            // читаем список товаров
            $items = null;
            $this->cms->db->products->get($items, $filter);
            if (!empty($items)) {

                // уничтожаем товары, в вариантах которых нет реальных скидок
                foreach ($items as $i => & $item) {
                    $this->cms->db->products->unpack($item, $filter);
                    $ok = FALSE;
                    $count = count($item->variants);
                    while ($count > 0 && !($ok = $this->hasDiscount($item, $count))) $count--;
                    if (!$ok) unset($items[$i]);
                }
            }

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции highlightedProducts
        *
        *  Типичное применение: {highlightedProducts var=MyVariable}
        *  Полный формат вызова: {highlightedProducts var=MyVariable [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count товаров, помеченных
        *  флажком "выделено визуально", и помещает их в указанную
        *  smarty-переменную var, чтобы эти записи стали доступны внутри
        *  шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей (по умолчанию 240)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->highlightedProducts()}
        */
        // ===================================================================

        public function highlightedProducts ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 240);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем фильтр записей
            $filter = new stdClass;
            $filter->enabled = 1;
            if (!isset($user->user_id)) $filter->hidden = 0;
            $filter->sort = SORT_PRODUCTS_MODE_BY_CREATED;
            $filter->sort_direction = 1;
            $filter->discount = isset($user->discount) ? $user->discount : 0;
            $filter->price_id = isset($user->price_id) ? $user->price_id : 0;
            $filter->highlighted = 1;
            $filter->non_usable = -1;
            $filter->maxcount = $count;

            // читаем список товаров
            $items = null;
            $this->cms->db->products->get($items, $filter);
            $this->cms->db->products->unpackRecords($items, $filter);

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции lastProducts
        *
        *  Типичное применение: {lastProducts var=MyVariable}
        *  Полный формат вызова: {lastProducts var=MyVariable [modified=TRUE] [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count последних добавленных
        *  товаров и помещает их в указанную smarty-переменную var, чтобы эти
        *  записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей (по умолчанию 240)
        *                                   ['modified'] = TRUE если извлечь последние измененные (по умолчанию FALSE)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->lastProducts()}
        */
        // ===================================================================

        public function lastProducts ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 240);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем фильтр записей
            $filter = new stdClass;
            $filter->enabled = 1;
            if (!isset($user->user_id)) $filter->hidden = 0;
            $filter->sort = $this->getParamAsBoolean('modified', $params) ? SORT_PRODUCTS_MODE_BY_CREATED : SORT_PRODUCTS_MODE_BY_MODIFIED;
            $filter->sort_direction = 1;
            $filter->type = TYPE_PRODUCTS_ANY;
            $filter->discount = isset($user->discount) ? $user->discount : 0;
            $filter->price_id = isset($user->price_id) ? $user->price_id : 0;
            $filter->maxcount = $count;

            // читаем список товаров
            $items = null;
            $this->cms->db->products->get($items, $filter);
            $this->cms->db->products->unpackRecords($items, $filter);

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции landingProducts
        *
        *  Типичное применение: {landingProducts var=MyVariable}
        *  Полный формат вызова: {landingProducts var=MyVariable [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count товаров, отображаемых
        *  нестандартным шаблоном, и помещает их в указанную smarty-переменную
        *  var, чтобы эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей (по умолчанию 240)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->landingProducts()}
        */
        // ===================================================================

        public function landingProducts ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 240);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем фильтр записей
            $filter = new stdClass;
            $filter->enabled = 1;
            if (!isset($user->user_id)) $filter->hidden = 0;
            $filter->sort = SORT_PRODUCTS_MODE_BY_NAME;
            $filter->type = TYPE_PRODUCTS_TEMPLATED;
            $filter->discount = isset($user->discount) ? $user->discount : 0;
            $filter->price_id = isset($user->price_id) ? $user->price_id : 0;
            $filter->maxcount = $count;

            // читаем список товаров
            $items = null;
            $this->cms->db->products->get($items, $filter);
            $this->cms->db->products->unpackRecords($items, $filter);

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции products
        *
        *  Типичное применение: {products var=MyVariable filter=FilterParamsArray}
        *  Полный формат вызова: {products var=MyVariable [filter=FilterParamsArray] [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count товаров, удовлетворяющих
        *  параметрам фильтра filter, и помещает их в указанную smarty-переменную
        *  var, чтобы эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей, если отсутствует
        *                                               в параметрах фильтра (по умолчанию 120)
        *                                   ['filter'] = параметры фильтра (может быть массивом или объектом),
        *                                                эти параметры накладываются на дефолтный фильтр
        *                                                    ('enabled' => 1,
        *                                                    'hidden' => 0,           # если нет авторизованного пользователя
        *                                                    'discount' => 0,         # или скидка авторизованного пользователя
        *                                                    'price_id' => 0,         # или ИД ценовой группы авторизованного пользователя
        *                                                    'maxcount' => $count,    # или если не указан, то 120
        *                                                    'sort' => SORT_PRODUCTS_MODE_BY_NAME
        *                                                    'sort_direction' => 0,
        *                                                    'type' => TYPE_PRODUCTS_ANY)
        *                                                причем 'параметр' => null значит убрать такой из дефолтного
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->products()}
        */
        // ===================================================================

        public function products ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 120);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем дефолтный фильтр записей
            $filter = new stdClass;
                $filter->enabled = 1;
                if (!isset($user->user_id)) $filter->hidden = 0;
                $filter->sort = SORT_PRODUCTS_MODE_BY_NAME;
                $filter->sort_direction = 0;
                $filter->type = TYPE_PRODUCTS_ANY;
                $filter->discount = isset($user->discount) ? $user->discount : 0;
                $filter->price_id = isset($user->price_id) ? $user->price_id : 0;
                $filter->maxcount = $count;

            // накладываем на дефолтный фильтр наши параметры
            $more = $this->getParamAsArrayOrObject('filter', $params);
            if (!empty($more)) {
                foreach ($more as $key => $value) {
                    if (is_string($key)) {
                        $key = trim($key);
                        if ($key != '') {
                            if ($value === null) {
                                if (isset($filter->$key)) unset($filter->$key);
                            } else if (is_string($value) || is_bool($value) || is_numeric($value)) {
                                $filter->$key = $value;
                            }
                        }
                    }
                }
            }

            // читаем список товаров
            $items = null;
            $this->cms->db->products->get($items, $filter);
            $this->cms->db->products->unpackRecords($items, $filter);

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции productKits
        *
        *  Типичное применение: {productKits var=MyVariable id=ProductId}
        *  Полный формат вызова: {productKits var=MyVariable [id=ProductId | item=$record | from=DesiredVariable] [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count комплектов товаров,
        *  содержащих заданный товар, и помещает их в указанную
        *  smarty-переменную var, чтобы эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['id'] = для какого товара искать комплекты (по умолчанию нет)
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей (по умолчанию 120)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->productKits()}
        */
        // ===================================================================

        public function productKits ( $params = null, & $smarty = null ) {
            $items = null;

            // возможно указали идентификатор товара
            $id = $this->getParamAsInteger('id', $params);
            if (empty($id)) {

                // если указателя на запись нет, может есть такая переменная?
                $this->resolveFromOrItem($params, $smarty);
                $field = 'item';

                // извлекаем идентификатор товара
                $id = isset($params[$field]->product_id) ? $params[$field]->product_id : 0;
            }
            if (!empty($id)) {

                // количество
                $count = $this->getParamAsInteger('count', $params, 120);
                $count = max(1, $count);

                // текущий пользователь, если есть
                $user = null;
                if ($this->existsUser()) $user = & $this->cms->user;

                // настраиваем фильтр записей
                $filter = new stdClass;
                $filter->product_id = $id;
                $filter->enabled = 1;
                if (!isset($user->user_id)) $filter->hidden = 0;
                $filter->sort = SORT_PRODUCTSKITS_MODE_BY_CREATED;
                $filter->sort_direction = 1;
                $filter->maxcount = $count;

                // читаем список комплектов товаров
                $this->cms->db->products_kits->get($items, $filter);
                    $discount = isset($user->discount) ? $user->discount : 0;
                    $this->cms->db->products_kits->unpackRecords($items, $discount);
            }

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции articles
        *
        *  Типичное применение: {articles var=MyVariable filter=FilterParamsArray}
        *  Полный формат вызова: {articles var=MyVariable [filter=FilterParamsArray] [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count статей, удовлетворяющих
        *  параметрам фильтра filter, и помещает их в указанную smarty-переменную
        *  var, чтобы эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей, если отсутствует
        *                                               в параметрах фильтра (по умолчанию 120)
        *                                   ['filter'] = параметры фильтра (может быть массивом или объектом),
        *                                                эти параметры накладываются на дефолтный фильтр
        *                                                    ('enabled' => 1,
        *                                                    'hidden' => 0,           # если нет авторизованного пользователя
        *                                                    'maxcount' => $count,    # или если не указан, то 120
        *                                                    'sort' => SORT_ARTICLES_MODE_BY_DATE
        *                                                    'sort_direction' => 1)
        *                                                причем 'параметр' => null значит убрать такой из дефолтного
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->articles()}
        */
        // ===================================================================

        public function articles ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 120);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем дефолтный фильтр записей
            $filter = new stdClass;
                $filter->enabled = 1;
                if (!isset($user->user_id)) $filter->hidden = 0;
                $filter->sort = SORT_ARTICLES_MODE_BY_DATE;
                $filter->sort_direction = 1;
                $filter->maxcount = $count;

            // накладываем на дефолтный фильтр наши параметры
            $more = $this->getParamAsArrayOrObject('filter', $params);
            if (!empty($more)) {
                foreach ($more as $key => $value) {
                    if (is_string($key)) {
                        $key = trim($key);
                        if ($key != '') {
                            if ($value === null) {
                                if (isset($filter->$key)) unset($filter->$key);
                            } else if (is_string($value) || is_bool($value) || is_numeric($value)) {
                                $filter->$key = $value;
                            }
                        }
                    }
                }
            }

            // читаем список статей
            $items = null;
            $this->cms->db->get_articles($items, $filter);    // TODO: исправить, когда преобразуется в модель статей
            $this->cms->db->fix_articles_records($items);     // TODO: исправить, когда преобразуется в модель статей // , $filter);

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции news
        *
        *  Типичное применение: {news var=MyVariable filter=FilterParamsArray}
        *  Полный формат вызова: {news var=MyVariable [filter=FilterParamsArray] [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count новостей, удовлетворяющих
        *  параметрам фильтра filter, и помещает их в указанную smarty-переменную
        *  var, чтобы эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей, если отсутствует
        *                                               в параметрах фильтра (по умолчанию 120)
        *                                   ['filter'] = параметры фильтра (может быть массивом или объектом),
        *                                                эти параметры накладываются на дефолтный фильтр
        *                                                    ('enabled' => 1,
        *                                                    'hidden' => 0,           # если нет авторизованного пользователя
        *                                                    'maxcount' => $count,    # или если не указан, то 120
        *                                                    'sort' => SORT_NEWS_MODE_BY_DATE
        *                                                    'sort_direction' => 1)
        *                                                причем 'параметр' => null значит убрать такой из дефолтного
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->news()}
        */
        // ===================================================================

        public function news ( $params = null, & $smarty = null ) {

            // количество
            $count = $this->getParamAsInteger('count', $params, 120);
            $count = max(1, $count);

            // текущий пользователь, если есть
            $user = null;
            if ($this->existsUser()) $user = & $this->cms->user;

            // настраиваем дефолтный фильтр записей
            $filter = new stdClass;
                $filter->enabled = 1;
                if (!isset($user->user_id)) $filter->hidden = 0;
                $filter->sort = SORT_NEWS_MODE_BY_DATE;
                $filter->sort_direction = 1;
                $filter->maxcount = $count;

            // накладываем на дефолтный фильтр наши параметры
            $more = $this->getParamAsArrayOrObject('filter', $params);
            if (!empty($more)) {
                foreach ($more as $key => $value) {
                    if (is_string($key)) {
                        $key = trim($key);
                        if ($key != '') {
                            if ($value === null) {
                                if (isset($filter->$key)) unset($filter->$key);
                            } else if (is_string($value) || is_bool($value) || is_numeric($value)) {
                                $filter->$key = $value;
                            }
                        }
                    }
                }
            }

            // читаем список новостей
            $items = null;
            $this->cms->db->news->get($items, $filter);
            $this->cms->db->news->unpackRecords($items, $filter);

            // возвращаем список
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции lastComments
        *
        *  Типичное применение: {lastComments var=MyVariable}
        *  Полный формат вызова: {lastComments var=MyVariable [count=MaxCount]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает из базы данных count недавних комментариев
        *  и помещает их в указанную smarty-переменную var, чтобы эти записи
        *  стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *                                   ['count'] = число извлекаемых записей (по умолчанию 32)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->lastComments()}
        */
        // ===================================================================

        public function lastComments ( $params = null, & $smarty = null ) {
            $items = array();

            // количество
            $count = $this->getParamAsInteger('count', $params, 32);
            $count = max(1, $count);

            // настраиваем фильтр записей
            $filter = new stdClass;
                $filter->enabled = 1;
                $filter->flatlist = 1;
                $filter->reverse = 1;
                $filter->maxcount = $count;

            // читаем комментарии товаров
            $list = null;
            $this->cms->db->get_comments($list, $filter);
            if (!empty($list)) {
                foreach ($list as & $item) $items[$item->date] = $item;
            }

            // читаем комментарии статей
            $list = null;
            $this->cms->db->get_acomments($list, $filter);
            if (!empty($list)) {
                foreach ($list as & $item) $items[$item->date] = $item;
            }

            // читаем комментарии новостей
            $list = null;
            $this->cms->db->get_ncomments($list, $filter);
            if (!empty($list)) {
                foreach ($list as & $item) $items[$item->date] = $item;
            }

            // возвращаем список
            krsort($items, SORT_STRING);
            $items = array_slice($items, 0, $count);
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции searchHistory
        *
        *  Типичное применение: {searchHistory var=MyVariable}
        *  Полный формат вызова: {searchHistory var=MyVariable}
        *
        *  Действие: извлекает записи истории поиска и помещает их в указанную
        *  smarty-переменную var, чтобы эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->searchHistory()}
        */
        // ===================================================================

        public function searchHistory ( $params = null, & $smarty = null ) {
            $items = $this->cms->history->getSearchHistory();
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции categories
        *
        *  Типичное применение: {categories var=MyVariable}
        *  Полный формат вызова: {categories [active=$activeCategoryId] [table=TableName] [any=TRUE] [sort=FALSE] [counters=FALSE] [ids=TRUE] var=MyVariable}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает дерево непустых разрешенных категорий и помещает
        *  в указанную smarty-переменную var, чтобы эти записи стали доступны
        *  внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['active'] = идентификатор активной категории (по умолчанию из данных движка)
        *                                   ['table'] = имя таблицы (по умолчанию categories, допустимо brands)
        *                                   ['sort'] = TRUE если упорядочить по алфавиту (по умолчанию TRUE)
        *                                              FALSE если упорядочить как расставлены в админпанели
        *                                   ['any'] = TRUE если разрешено отбирать и пустые (по умолчанию FALSE)
        *                                   ['counters'] = TRUE если подсчитывать количества товаров (по умолчанию TRUE)
        *                                   ['ids'] = TRUE если предоставить ИДы личных товаров (по умолчанию FALSE)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->categories()}
        */
        // ===================================================================

        public function categories ( $params = null, & $smarty = null ) {

            $counters = $this->getParamAsBoolean('counters', $params, TRUE);
            $ids = $this->getParamAsBoolean('ids', $params);
            $sort = $this->getParamAsBoolean('sort', $params, TRUE);

            // для какой таблицы?
            $name = $this->getParamAsSentence('table', $params);
            switch ($this->cms->text->lowerCase($name)) {
                case 'brands':
                    $idfield = 'brand_id';
                    $dbtable = 'brands';
                    $subfield = 'subbrands';
                    $active = isset($this->cms->brand)
                           && isset($this->cms->brand->$idfield) ? $this->cms->brand->$idfield : 0;
                    break;
                case 'categories':
                default:
                    $idfield = 'category_id';
                    $dbtable = 'categories';
                    $subfield = 'subcategories';
                    $active = isset($this->cms->category)
                           && isset($this->cms->category->$idfield) ? $this->cms->category->$idfield : 0;
            }

            // ИД активной записи
            $active = $this->getParamAsInteger('active', $params, $active);

            // читаем записи
            $query = 'SELECT * '
                   . 'FROM `' . $dbtable . '` '
                   . 'ORDER BY ' . ($sort ? '' : '`order_num` DESC, ')
                                 . '`name` ASC;';
            $result = $this->cms->db->query($query);

            // перебираем результат
            $items = array();
            if (!empty($result)) {
                $hidden = !$this->existsUser();
                $categories = array();
                while ($row = $this->cms->db->fetch_object($result)) {
                    $me = intval($row->$idfield);
                    if (!empty($me)) {

                        // определяем ИД родителя
                        $parent = intval($row->parent);
                        if ($parent == $me) $parent = 0;

                        // распаковываем поля записи (если видима)
                        $row->name = trim($row->name);
                        if ($row->name == '') $row->name = 'Без названия, ИД = ' . $me;
                        if (!empty($row->enabled) && (!$hidden || empty($row->hidden))) {
                            $this->cms->db->fix_categories_record($row);
                        } else {
                            $i = new stdClass;
                            $i->$idfield = $row->$idfield;
                            $i->parent = $row->parent;
                            $i->name = $row->name;
                            $i->url = $row->url;
                            $i->url_special = $row->url_special;
                            $i->enabled = FALSE;
                            $row = $i;
                        }

                        // технические поля
                        $row->filled = FALSE;
                        if ($counters) {
                            $row->products_count = 0;
                            $row->my_products_count = 0;
                        }
                        $row->active = $me == $active;

                        // если такую еще не использовали
                        if (!isset($categories[$me])) {
                            $row->$subfield = array();
                            $categories[$me] = $row;

                        // может когда-то ссылались на такую, копируем в ссылку поля записи
                        } elseif (!isset($categories[$me]->$idfield)) {
                            foreach ($row as $i => & $v) $categories[$me]->$i = $v;
                        }

                        // если указан родитель
                        if (!empty($parent)) {

                            // если родитель еще не встречался
                            if (!isset($categories[$parent])) {
                                $categories[$parent] = new stdClass;
                                $categories[$parent]->enabled = TRUE;
                                if ($counters) {
                                    $categories[$parent]->products_count = 0;
                                    $categories[$parent]->my_products_count = 0;
                                }
                                $categories[$parent]->filled = FALSE;
                                $categories[$parent]->$subfield = array();
                            }

                            // крепим к родителю
                            $ptr = & $categories[$parent]->$subfield;
                            if (!isset($ptr[$me])) $ptr[$me] = & $categories[$me];
                        }
                    }
                }

                // освобождаем память от запроса
                $this->cms->db->free_result($result);

                // читаем записи товаров
                if ($ids) {
                    $query = 'SET group_concat_max_len = 131072;';
                    $this->cms->db->query($query);
                }
                $query = 'SELECT `' . $idfield . '` '
                              . ($counters ? ', COUNT(`' . $idfield . '`) AS `count` ' : '')
                              . ($ids ? ', GROUP_CONCAT(DISTINCT `product_id` ORDER BY `product_id` SEPARATOR ",") AS `ids` ' : '')
                       . 'FROM `products` '
                       . 'WHERE `enabled` = 1 AND `' . $idfield . '` != 0 ' . ($hidden ? 'AND `hidden` = 0 ' : '')
                       . 'GROUP BY `' . $idfield . '`;';
                $result = $this->cms->db->query($query);

                // перебираем результат
                if (!empty($result)) {
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $parent = intval($row->$idfield);
                        if (!empty($parent)) {

                            // если родитель еще не встречался
                            if (!isset($categories[$parent])) {
                                $categories[$parent] = new stdClass;
                                $categories[$parent]->enabled = TRUE;
                                $categories[$parent]->filled = TRUE;
                                $categories[$parent]->$subfield = array();
                            }

                            // сообщаем родителям о наличии товаров
                            if (!isset($categories[$parent]->products)) {
                                if ($counters) {
                                    $categories[$parent]->products_count = $row->count;
                                    $categories[$parent]->my_products_count = $row->count;
                                }
                                $categories[$parent]->products = $ids ? $row->ids : '';
                                if ($counters) {
                                    $categories[$parent]->filled = TRUE;
                                    $i = $parent;
                                    while (($i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0) != 0) {
                                        $categories[$i]->products_count += $row->count;
                                        $categories[$i]->filled = TRUE;
                                    }
                                } else {
                                    $i = $parent;
                                    while (!empty($i) && !$categories[$i]->filled) {
                                        $categories[$i]->filled = TRUE;
                                        $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                                    }
                                }
                            }
                        }
                    }

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);
                }

                // отбираем непустые (или пустые тоже, если разрешено) или информативные корневые категории, а также выпавшие (их признаем корневыми)
                $any = $this->getParamAsBoolean('any', $params);
                foreach ($categories as $i => & $v) {
                    if (!empty($v->enabled) && ($any || !empty($v->filled) || !empty($v->informative))) {
                        if (isset($v->$idfield) && empty($v->parent)) {
                            $items[$i] = & $categories[$i];
                        } elseif (!empty($i) && !isset($v->$idfield)) {
                            $categories[$i]->$idfield = $i;
                            $categories[$i]->parent = 0;
                            $categories[$i]->enabled = TRUE;
                            $categories[$i]->name = 'Несуществующая (выпавшая) запись, ИД = ' . $i;
                            $categories[$i]->url = $i;
                            $categories[$i]->url_special = FALSE;
                            $categories[$i]->active = $i == $active;
                            $categories[$i]->bad = TRUE;
                            $items[$i] = & $categories[$i];
                        }
                        if (!empty($v->active)) {
                            $i = $v->parent;
                            while (!empty($i) && !$categories[$i]->active) {
                                $categories[$i]->active = TRUE;
                                $i = isset($categories[$i]->parent) ? $categories[$i]->parent : 0;
                            }
                        }
                    }
                }
            }

            // возвращаем массив записей
            return $this->assignVar($params, $items, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции getBranch
        *
        *  Типичное применение: {getBranch from=DesiredVariable id=BranchId var=MyVariable}
        *  Полный формат вызова: {getBranch [item=$record | from=DesiredVariable] [path=BranchFullName | id=BranchId [type=RecordType] var=MyVariable}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает ветвь с указанным идентификатором или путем из
        *  дерева записей и помещает в указанную smarty-переменную var, чтобы
        *  записи ветви стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['id'] = идентификатор искомой ветви
        *                                   ['path'] = полный путь искомой ветви (например Компьютеры/Ноутбуки)
        *                                   ['from'] = имя переменной, из которой брать запись (по умолчанию нет)
        *                                   ['item'] = запись о чем-либо (по умолчанию
        *                                              ищется такая же переменная)
        *                                   ['type'] = тип записей (по умолчанию categories, может быть brands)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  mixed               массив записей ветви
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function getBranch ( $params = null, & $smarty = null ) {
            $branch = null;

            // возможно указали путь ветви, конвертируем его в массив
            $path = $this->getParamAsSentence('path', $params);
            $path = str_replace('\\', '/', $path);
            $items = explode('/', $path);
            $path = array();
            foreach ($items as $id) {
                $id = trim($id);
                if ($id != '') $path[] = $this->cms->text->lowerCase($id);
            }

            // если указали идентификатор или путь ветви
            $id = $this->getParamAsInteger('id', $params);
            if (!empty($id) || !empty($path)) {

                // если указателя на запись нет, может есть такая переменная?
                $this->resolveFromOrItem($params, $smarty, TRUE);
                $field = 'item';

                // какой тип записей?
                $type = $this->getParamAsSentence('type', $params);
                switch ($this->cms->text->lowerCase($type)) {
                    case 'brands':
                        $nodename = 'subbrands';
                        break;
                    case 'categories':
                    default:
                        $nodename = 'subcategories';
                }

                // ищем ветвь
                $this->getBranchScan($params[$field], $nodename, $id, $path, $branch);
            }

            // возвращаем ветвь
            return $this->assignVar($params, $branch, $smarty);
        }

        private function getBranchScan ( & $tree, & $nodename, $id, & $path, & $branch ) {
            if (!empty($tree) && is_array($tree)) {
                if (!empty($id)) {
                    if (isset($tree[$id])) {
                        $branch = $tree[$id];
                        return TRUE;
                    }
                } else {
                    $name = array_shift($path);
                }
                foreach ($tree as & $node) {
                    if (empty($id)) {
                        if (isset($node->name)) {
                            if ($name == $this->cms->text->lowerCase($node->name)) {
                                if (empty($path)) {
                                    $branch = $node;
                                    return TRUE;
                                }
                                if (!isset($node->$nodename)) return FALSE;
                                return $this->getBranchScan($node->$nodename, $nodename, $id, $path, $branch);
                            }
                        }
                    } else {
                        if (isset($node->$nodename)) {
                            if ($this->getBranchScan($node->$nodename, $nodename, $id, $path, $branch)) return TRUE;
                        }
                    }
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции menuByLangTechName
        *
        *  Типичное применение: {menuByLangTechName name=MenuName var=MyVariable}
        *  Полный формат вызова: {menuByLangTechName [lang=LanguageMarker tech=TechnicalName | name=MenuName] [separator1=MySeparator1 separator2=MySeparator2] [attach=AttachTypesCSList] var=MyVariable}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает запись меню, удовлетворяющего критериям поиска
        *  lang-tech-name, и помещает меню в указанную smarty-переменную var,
        *  чтобы оно стало доступно внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['lang'] = код текущего языка (по умолчанию пустая строка)
        *                                   ['tech'] = техническое имя меню (например About, по умолчанию пустая строка)
        *                                   ['name'] = локализованное имя меню (по умолчанию пустая строка)
        *                                   ['seapartor1'] = разделитель код языка и технического имени (по умолчанию ' - ')
        *                                   ['seapartor2'] = разделитель технического имени и локализованного имени меню (по умолчанию ' - ')
        *                                   ['attach'] = список через запятую прикрепляемых типов элементов (например 'articles, sections', по умолчанию все)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  mixed               запись меню
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function menuByLangTechName ( $params = null, & $smarty = null ) {
            $menu = null;

            // получаем начало имени искомого меню (по формату "LANG - TECHNICAL_NAME - LOCALIZED_NAME")
            $separator1 = $this->getParam('separator1', $params, ' - ');
            $separator2 = $this->getParam('separator2', $params, ' - ');
            $lang = $this->getParamAsSentence('lang', $params);
            $tech = $this->getParamAsSentence('tech', $params);
            $name = $this->getParamAsSentence('name', $params);

            $tech = ($lang != '' ? $lang . $separator1 : '') . ($tech != '' ? $tech . $separator2 : '');
            $search = $tech . $name;
            if ($search != '') {
                $size = $this->cms->text->length($tech);

                // это авторизованный пользователь?
                $authorized = $this->existsUser();

                // читаем запись о таком меню (с учетом видно ли текущему пользователю)
                $query = 'SELECT * '
                       . 'FROM `menu` '
                       . 'WHERE `enabled` = 1 '
                              . ($authorized ? '' : 'AND `hidden` = 0 ')
                              . ($name == '' || !empty($size) ? 'AND LEFT(`name`, ' . $size . ') = "' . $this->cms->db->query_value($search) . '" '
                                                              : 'AND `name` = "' . $this->cms->db->query_value($search) . '" ')
                       . 'LIMIT 1;';
                $result = $this->cms->db->query($query);
                $menu = $this->cms->db->result();
                $this->cms->db->free_result($result);

                if (!empty($menu)) {
                    $this->cms->db->fix_menus_record($menu);

                    // добавляем в меню его прикрепленные записи
                    $types = $this->getParamAsSentence('attach', $params);
                    $this->cms->db->menus->attachItems($menu, $types);

                    // убираем техническую информацию из начала имени меню
                    if (!empty($size)) $menu->name = $this->cms->text->substr($menu->name, $size);
                }
            }

            // возвращаем запись меню
            return $this->assignVar($params, $menu, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции bannerImages
        *
        *  Типичное применение: {bannerImages var=MyVariable}
        *  Полный формат вызова: {bannerImages [uri=DesiredPageUri] [start=FirstImageNumber] [count=MaxCount] var=MyVariable}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: извлекает записи изображений баннера для конкретной
        *  страницы и помещает их в указанную smarty-переменную var, чтобы
        *  эти записи стали доступны внутри шаблона.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['uri'] = URI желаемой страницы (по умолчанию корень сайта)
        *                                             может содержать * на конце (например
        *                                             /folder1/file* = брать картинки из папки folder1 с file в начале имени)
        *                                   ['start'] = номер первой извлекаемой записи (по умолчанию 1)
        *                                   ['count'] = число извлекаемых записей (по умолчанию 40)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = в какую переменную возвратить результат
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        *                               массив записей если обработчик вызывался как метод {$myVar = $helper->bannerImages()}
        */
        // ===================================================================

        public function bannerImages ( $params = null, & $smarty = null ) {

            // получаем url папки баннеров
            $url = trim($this->cms->site_url) . 'files/banners/';
            $url = preg_replace('![/\\\\]+!', '/', $url);
            $url = preg_replace('!^([a-z]+:/)!i', '\1/', $url);

            // путь к папке с картинками
            $path = $this->cms->request->getServerAsSentence('REQUEST_URI');
            $path = $this->getParamAsSentence('uri', $params, $path);
            $path = preg_replace('![/\\\\]+!', '/', $this->cms->text->lowerCase($path));
            if (rtrim($path, '*') == $path) $path = rtrim($path, "/. \t\r\n") . '/';
            if ($path == '/') $path = '';

            // искать по маске?
            $mask = rtrim($path, '*');
            $mask = $path != $mask ? ($path = $mask) == $mask : FALSE;

            // с какой начать, количество
            $start = $this->getParamAsInteger('start', $params, 1);
            $start = max(1, $start);
            $count = $this->getParamAsInteger('count', $params, 40);
            $count = max(1, $count);

            // ищем в переменных шаблонизатора массив записей о баннерах
            $name = 'banners';
            $dir = null;
            if (is_object($smarty)) $dir = $smarty->getTemplateVars($name);
            if (is_null($dir)) $dir = $this->cms->smarty->getTemplateVars($name);

            // возвращаем массив записей для указанного URI
            $items = array();
            $this->bannerImagesScan($dir, $url, $path, $mask, $items, $start, $count);
            return $this->assignVar($params, $items, $smarty);
        }

        private function bannerImagesScan ( & $dir, & $url, & $path, $mask, & $items, & $start, & $maxcount ) {
            if (!empty($dir) && is_array($dir)) {
                foreach ($dir as & $c) {
                    if (!empty($c->enabled)) {
                        if (isset($c->files)) {
                            if (!empty($c->files) && is_array($c->files)) {
                                if ($this->bannerImagesScan($c->files, $url, $path, $mask, $items, $start, $maxcount)) return TRUE;
                            }
                        } else {
                            if (isset($c->width) && isset($c->height) && isset($c->path) && isset($c->filename)) {
                                $folder = $c->path;
                                $file = $folder . $c->filename;
                                    $folder = $this->cms->text->lowerCase($folder);
                                    $ok = $this->cms->text->lowerCase($file);
                                    if ($mask) {
                                        $size = strlen($path);
                                        $ok = substr($folder, 0, $size) == $path || substr($ok, 0, $size) == $path;
                                    } else {
                                        $ok = $folder == $path || $ok == $path;
                                    }
                                if ($ok) {
                                    if ($start > 1) $start--;
                                    else {
                                        if (count($items) < $maxcount) {
                                            $c->url_full = $url . $file;
                                            $items[] = & $c;
                                        }
                                        if (count($items) >= $maxcount) return TRUE;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции randomId
        *
        *  Типичное применение: {randomId}
        *  Полный формат вызова: {randomId [size=$idSize] [digit=TRUE] [char=TRUE] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит случайный идентификатор, состоящий из указанного
        *  количества цифр.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['size'] = количество цифр (по умолчанию 32)
        *                                   ['digit'] = TRUE если использовать цифры (по умолчанию TRUE)
        *                                   ['char'] = TRUE если использовать английские буквы (по умолчанию FALSE)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              строка идентификатора
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function randomId ( $params = null, & $smarty = null ) {
            $digit = $this->getParamAsBoolean('digit', $params, TRUE);
            $char = $this->getParamAsBoolean('char', $params);
            if (!$digit && !$char) $digit = TRUE;
            $size = $this->getParamAsInteger('size', $params, 32);
            $size = max($size, 1);
            $id = '';
            while ($size > 0) {
                if ($digit && $char) {
                    if (rand(0, 1) == 0) $id .= rand(0, 9);
                    else $id .= chr(rand(0, 25) + (rand(0, 1) == 0 ? 65 : 97));
                } else if ($digit) $id .= rand(0, 9);
                else $id .= chr(rand(0, 25) + (rand(0, 1) == 0 ? 65 : 97));
                $size--;
            }
            return $this->assignVar($params, $id, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции requestUri
        *
        *  Типичное применение: {requestUri}
        *  Полный формат вызова: {requestUri [except='param1, param2*, param[*], *, paramN'] [nopages=TRUE] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит uri страницы, удаляя из него указанные GET-параметры.
        *  Выводимый uri экранирует спецсимволы, то есть безопасен для использования
        *  в опциях тегов.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   [except] = список (через запятую) удаляемых GET-параметров
        *                                   [nopages] = TRUE если убрать параметры пагинации (по умолчанию FALSE)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              строка uri
        *                               пустая строка если выведено в указанную переменную
        */
        // ===================================================================

        public function requestUri ( $params = null, & $smarty = null ) {
            $url = $this->cms->request->getServerAsSentence('REQUEST_URI');
            $url = @ parse_url($url);

            // адрес оставляем как есть
            $url['path'] = isset($url['path']) ? trim($url['path']) : '';

            $except = $this->getParamAsSentence('except', $params);
            if ($this->getParamAsBoolean('nopages', $params)) {
                $except .= ', page';
                $url['path'] = preg_replace('!/page[_\-][0-9]+$!iu', '', $url['path']);
            }

            // извлекаем GET-параметры
            $url['query'] = isset($url['query']) ? trim($url['query']) : '';
                if ($url['query'] != '') {
                    $prev = '&' . $url['query'] . '&';

                    // удаляем указанные параметры
                    $except = explode(',', $except);
                    if (!empty($except)) {
                        $optimized = array();
                        foreach ($except as $name) {
                            $name = trim($name);
                            if ($name != '') $optimized[$name] = $name;
                        }
                        if (!empty($optimized)) {
                            foreach ($optimized as $name) {
                                if ($name == '*') {
                                    $url['query'] = '';
                                    break;
                                } else {
                                    $name = preg_replace('/([#\?\+\(\)\[\]\{\}\.\\\\])/u', '\\\$1', $name);
                                    $name = preg_replace('/\*/u', '[^&=]*?', $name);
                                    while (($url['query'] = preg_replace('/&' . $name . '(\=[^&]*)?&/iu', '&', $prev)) != $prev) $prev = $url['query'];
                                }
                            }
                        }
                    }

                    // собираем параметры
                    $url['query'] = trim($url['query'], "& \t\r\n");
                    if ($url['query'] != '') $url['query'] = '?' . $url['query'];
                }

            // хеш ссылки оставляем как есть
            $url['fragment'] = isset($url['fragment']) ? trim($url['fragment']) : '';
                if ($url['fragment'] != '') $url['fragment'] = '#' . $url['fragment'];

            // возвращаем результат
            $url = htmlspecialchars($url['path'] . $url['query'] . $url['fragment'], ENT_QUOTES, 'UTF-8');
            return $this->assignVar($params, $url, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции header301
        *
        *  Типичное применение: {header301}
        *  Полный формат вызова: {header301 [url='my-new-page-URI-or-URL']}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: отправляет в браузер пользователя серверный заголовок
        *  редиректа 301 (страница перемещена на постоянный адрес) и завершает
        *  работу движка.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['url'] = новый адрес страницы (по умолчанию корень сайта)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function header301 ( $params = null, & $smarty = null ) {
            $site = trim($this->cms->site_url);
            $url = $this->getParamAsSentence('url', $params);
            if ($url == '') {
                $url = $site;
            } else if (!preg_match('/^https?:/i', $url)) {
                $url = $site . ltrim($url, '/\\ ');
            }
            @ header('HTTP/1.1 301 Moved Permanently');
            @ header('Location: ' . $url);
            $this->cms->security->stop();
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции header403
        *
        *  Типичное применение: {header403}
        *  Полный формат вызова: {header403}
        *
        *  Действие: отправляет в браузер пользователя серверный заголовок
        *  запрета 403 (доступ к странице запрещен) и завершает работу движка.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function header403 ( $params = null, & $smarty = null ) {
            @ header('HTTP/1.1 403 Forbidden');
            $this->cms->security->stop();
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции header404
        *
        *  Типичное применение: {header404}
        *  Полный формат вызова: {header404}
        *
        *  Действие: отправляет в браузер пользователя серверный заголовок
        *  ошибки 404 (страница не найдена).
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        */
        // ===================================================================

        public function header404 ( $params = null, & $smarty = null ) {
            @ header('HTTP/1.1 404 Not Found');
            return '';
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции header410
        *
        *  Типичное применение: {header410}
        *  Полный формат вызова: {header410}
        *
        *  Действие: отправляет в браузер пользователя серверный заголовок
        *  запрета 410 (страница удалена и более недоступна) и завершает
        *  работу движка.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function header410 ( $params = null, & $smarty = null ) {
            @ header('HTTP/1.1 410 Gone');
            $this->cms->security->stop();
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции lastTemplate
        *
        *  Типичное применение: {lastTemplate}
        *  Полный формат вызова: {lastTemplate}
        *
        *  Действие: сигнализирует движку, что данный шаблон является
        *  последним, то есть его контент не нужно интегрировать во внешнее
        *  оформление страницы (пропустить обработку файла index.tpl).
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              всегда пустая строка
        */
        // ===================================================================

        public function lastTemplate ( $params = null, & $smarty = null ) {
            $this->cms->quick_content = TRUE;
            return '';
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции htmCache
        *
        *  Типичное применение: {htmCache name='fragment-name'} ... {/htmCache}
        *  Полный формат вызова: {htmCache name='fragment-name' [lifetime=TimeInSeconds] [params=RelatedParameters] [var=MyVariable]} ... {/htmCache}
        *
        *  Действие: кеширует фрагмент страницы на некоторое время.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   [name] = идентификационное имя фрагмента (например top_menu)
        *                                   [lifetime] = срок хранения в кеше (по умолчанию 900 секунд)
        *                                   [params] = набор параметров, идентифицирующих вариант фрагмента (по умолчанию нет)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   mixed   $content    контент кешируемого блока
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @param   boolean $repeat     сигнал повтора
        *  @return  string              контент
        */
        // ===================================================================

        public function htmCache ( $params = null, $content = null, & $smarty = null, & $repeat ) {

            // берем имя фрагмента
            $file = $this->getParamAsSentence('name', $params);
            $file = $this->cms->hdd->safeFilename($file);
            if ($file != '') {

                // фрагмент будет относиться к текущему шаблону
                $tpl = $this->cms->hdd->safeFilename($this->cms->dynamic_theme);
                if ($tpl != '') $tpl = '-' . $tpl;

                // если есть идентифицирующие параметры, готовим суффикс файла
                $suffix = '';
                if (isset($params['params'])) {
                    try {
                        $suffix = $params['params'];
                        if (!is_string($suffix)) {
                            $suffix = @ serialize($suffix);
                            if (!is_string($suffix)) $suffix = '';
                        }
                        if ($suffix != '') $suffix = '-' . strtolower(md5($suffix));
                    } catch (Exception $e) {
                        $suffix = '';
                    }
                }

                $file = $this->cms->htmcache->getCachePath('template' . $tpl, TRUE) . '/' . $file . $suffix . '.htm';
            }

            // если это открывающий тег, смотрим в кеше
            if ($repeat) {
                if ($file != '') {
                    if ($this->cms->hdd->isReadableFile($file)) {
                        $life = $this->getParamAsInteger('lifetime', $params, 900);
                        if (!$this->cms->htmcache->isExpired($file, $life)) {
                            if (($handle = @ fopen($file, 'rb')) !== FALSE) {
                                @ flock($handle, LOCK_EX);
                                $html = '';
                                while (!feof($handle)) $html .= @ fread($handle, 65536);
                                @ flock($handle, LOCK_UN);
                                @ fclose($handle);

                                // считаем это закрывающим тегом, отдаем кешированный контент
                                $repeat = FALSE;
                                return $this->assignVar($params, $html, $smarty);
                            }
                        }
                    }
                }

            // иначе это закрывающий тег, кешируем
            } else {
                if (isset($content) && is_string($content)) {
                    if ($file != '') {
                        if ($this->cms->hdd->isWritableFile($file)) {
                            if (($handle = @ fopen($file, 'wb')) !== FALSE) {
                                @ flock($handle, LOCK_EX);
                                @ ftruncate($handle, 0);
                                @ fwrite($handle, $content);
                                @ flock($handle, LOCK_UN);
                                @ fclose($handle);
                            }
                        }
                    }

                    // и отдаем контент
                    return $this->assignVar($params, $content, $smarty);
                }
            }

            return $this->assignVar($params, '', $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции includeHtml
        *
        *  Типичное применение: {includeHtml url='html-file-relative-url'}
        *  Полный формат вызова: {includeHtml url='html-file-relative-url' [root=TRUE] [var=MyVariable]}
        *
        *  Действие: выводит содержимое указанного HTML-файла.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   [root] = TRUE если относительно корня сайта (по умолчанию FALSE)
        *                                            FALSE если относительно папки шаблона
        *                                   [url] = относительный URL файла
        *                                           (допустимые расширения tpl, htm, html, xml, css, js, txt)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  string              результат
        */
        // ===================================================================

        public function includeHtml ( $params = null, & $smarty = null ) {
            $data = '';
            $file = $this->getParam('url', $params);
            $file = $this->cms->hdd->safeFilename($file, FALSE);
            if ($file != '') {

                // только допустимые расширения файла
                $ext = explode('.', $file);
                $ext = array_pop($ext);
                $ext = $this->cms->text->lowerCase($ext);
                if (in_array($ext, array('tpl', 'htm', 'html', 'xml', 'css', 'js', 'txt'))) {

                    // относительно чего?
                    $path = dirname(__FILE__) . '/../../';
                    if ($this->getParamAsBoolean('root', $params)) {
                        $dir = ltrim($this->cms->root_dir, '/\\\\');
                        $dir = preg_replace('![^/\\\\]+[/\\\\]+!u', '../', $dir);
                        $path .= preg_replace('![^/\.]+!u', '', $dir);
                    } else {
                        $tpl = $this->cms->hdd->safeFilename($this->cms->dynamic_theme);
                        if ($tpl != '') $tpl .= '/';
                        $path .= 'design/' . $tpl;
                    }

                    // читаем файл
                    $file = $path . $file;
                    if ($this->cms->hdd->isReadableFile($file)) {
                        $data = @ file_get_contents($file);
                        if (!is_string($data)) $data = '';
                    }
                }
            }

            // возвращаем результат
            return $this->assignVar($params, $data, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции dumpStructure
        *
        *  Типичное применение: {dumpStructure from=DesiredVariable}
        *  Полный формат вызова: {dumpStructure from=DesiredVariable [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит распечатку структуры указанной переменной-объекта.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['from'] = имя анализируемой переменной
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function dumpStructure ( $params = null, & $smarty = null ) {
            $result = '';
            $varname = $this->getParamAsSentence('from', $params);
            if ($varname != '') {
                $item = $this->getTemplateVar($varname, $smarty);
                if (is_array($item) && !empty($item)) $item = reset($item);
                if (is_object($item) && !empty($item)) {
                    $crlf = "\r\n";
                    $result = array();
                    foreach ($item as $key => $value) {
                        $result2 = '';
                        $type = gettype($value);
                        if (is_array($value) && !empty($value)) $value = reset($value);
                        if (is_object($value) && !empty($value)) {
                            $result2 = array();
                            foreach ($value as $key2 => $value2) $result2[$key2] = '    ' . $key2 . ' = ' . gettype($value2);
                            ksort($result2, SORT_STRING);
                            $result2 = $crlf . implode($crlf, $result2);
                        }
                        $result[$key] = $key . ' = ' . $type . $result2;
                    }
                    ksort($result, SORT_STRING);
                    $result = '<pre>' . implode($crlf, $result) . '</pre>';
                }
            }
            return $this->assignVar($params, $result, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции siteTotalSpace
        *
        *  Типичное применение: {siteTotalSpace}
        *  Полный формат вызова: {siteTotalSpace [factor=SizeDivider] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит размер предоставленного места на сайте с учетом
        *  указанной кратности выводимого размера.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['factor'] = кратность результата (по умолчанию 1 мегабайт)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function siteTotalSpace ( $params = null, & $smarty = null ) {
            $result = 0;
            if (function_exists('disk_total_space')) {
                $factor = $this->getParamAsInteger('factor', $params, 1048576);
                $factor = max(1, $factor);
                $result = @ disk_total_space(dirname(__FILE__) . '/../../') / $factor;
                $result = $this->priceForScreen($result, FALSE);
            }
            return $this->assignVar($params, $result, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции siteFreeSpace
        *
        *  Типичное применение: {siteFreeSpace}
        *  Полный формат вызова: {siteFreeSpace [factor=SizeDivider] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит размер свободного места на сайте с учетом
        *  указанной кратности выводимого размера.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['factor'] = кратность результата (по умолчанию 1 мегабайт)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function siteFreeSpace ( $params = null, & $smarty = null ) {
            $result = 0;
            if (function_exists('disk_free_space')) {
                $factor = $this->getParamAsInteger('factor', $params, 1048576);
                $factor = max(1, $factor);
                $result = @ disk_free_space(dirname(__FILE__) . '/../../') / $factor;
                $result = $this->priceForScreen($result, FALSE);
            }
            return $this->assignVar($params, $result, $smarty);
        }



        // ===================================================================
        /**
        *  Обработчик шаблонизационной функции siteUsedSpace
        *
        *  Типичное применение: {siteUsedSpace}
        *  Полный формат вызова: {siteUsedSpace [factor=SizeDivider] [var=MyVariable]}
        *  Опциональные параметры: обозначены квадратными скобками
        *
        *  Действие: выводит размер занятого места на сайте с учетом
        *  указанной кратности выводимого размера.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   array   $params     массив параметров, указанных в вызове:
        *                                   ['factor'] = кратность результата (по умолчанию 1 мегабайт)
        *                                   ['assign'] или
        *                                   ['result'] или
        *                                   ['var'] = имя, если результат возвратить в переменную
        *                                             (иначе результат выводится в точку вызова)
        *  @param   object  $smarty     объект шаблонизатора Smarty
        *  @return  void
        */
        // ===================================================================

        public function siteUsedSpace ( $params = null, & $smarty = null ) {
            $result = 0;
            if (function_exists('disk_free_space') && function_exists('disk_total_space')) {
                $factor = $this->getParamAsInteger('factor', $params, 1048576);
                $factor = max(1, $factor);
                $root = dirname(__FILE__) . '/../../';
                $result = abs(@ disk_total_space($root) - @ disk_free_space($root)) / $factor;
                $result = $this->priceForScreen($result, FALSE);
            }
            return $this->assignVar($params, $result, $smarty);
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - stringAsSentence
        *
        *  Типичное применение: {if $helper->stringAsSentence($text)}
        *  Полный формат вызова: {if $helper->stringAsSentence($text)}
        *
        *  Действие: возвращает на выход указанные текст как печатное
        *  предложение (анти трейлинг, оптимизация пробелов).
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   string  $text   исходный текст
        *  @return  string          результирующий текст
        */
        // ===================================================================

        public function stringAsSentence ( $text ) {
            return trim(preg_replace('/[ \r\n\t\s]+/u', ' ', $text));
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - existsUser
        *
        *  Типичное применение: {if $helper->existsUser()}
        *  Полный формат вызова: {if $helper->existsUser()}
        *
        *  Действие: возвращает на выход признак наличия авторизованного пользователя
        *
        *  @access  public
        *  @return  boolean         TRUE если есть, FALSE если нет
        */
        // ===================================================================

        public function existsUser () {
            return isset($this->cms->user->user_id) && !empty($this->cms->user->user_id);
        }



        // ===================================================================
        /**
        *  Допустимый метод шаблонизационного объекта - getProperty
        *
        *  Типичное применение: {if $helper->getProperty($object, $propertyName)}
        *  Полный формат вызова: {if $helper->getProperty($object, $propertyName)}
        *
        *  Действие: возвращает на выход указанное свойство объекта.
        *
        *  -------------------------------------------------------------------
        *
        *  @access  public
        *  @param   object  $object     исследуемый объект
        *  @param   string  $name       имя свойства
        *  @return  mixed               значение свойства
        *                               NULL если свойство не найдено
        */
        // ===================================================================

        public function getProperty ( & $object, $name ) {

            // есть список запрещенных свойств
            $disabled = array('cms', 'owner', 'owner_exclusive');
            if (in_array(strtolower($name), $disabled)) return NULL;

            // извлекаем свойство
            if (!is_object($object) || !property_exists($object, $name)) return NULL;
            return $object->$name;
        }
    }



    return;
?>