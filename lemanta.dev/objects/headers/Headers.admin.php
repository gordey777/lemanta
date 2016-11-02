<?php
    // =======================================================================
    /**
    *  Админ модуль просмотра заголовков страницы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет справочника
    require_once(dirname(__FILE__) . '/../.ref-models/BasicModel.php');

    // текст заголовка страницы модуля
    define('HEADERS_PAGE_TITLE', 'Просмотр заголовков страницы');

    // имя файла шаблона модуля
    define('HEADERS_TEMPLATE_FILENAME', 'headers/headers.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('HEADERS_MODULELINK_POINTER', 'Headers');
    define('HEADERS_MODULETAB_TEXT', 'заголовки');
    define('HEADERS_MODULEMENU_PATH', 'Разное / SEO / Просмотр заголовков страницы');



    // =======================================================================
    /**
    *  Админ модуль просмотра заголовков страницы
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Headers extends BasicREFModel {

        // имя файла шаблона
        protected $template = HEADERS_TEMPLATE_FILENAME;



        // ===================================================================
        /**
        *  Обработка запуска просмотра
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function processStart () {

            // извлекаем настройки сеансовости
            $field = 'csid_enabled';
            $csid_enabled = isset($_POST[$field]) ? ($_POST[$field] ? 1 : 0) : 1;
            $field = 'csid_value';
            $csid_value = isset($_POST[$field]) ? trim($_POST[$field]) : rand(1, 100000000);

            // если получены данные об изменениях соответствующих настроек сайта
            if (isset($_POST['post'])) {

                // проверяем token-аутентичность вызова модуля
                // (неаутентичных перенаправит на главную)
                $this->checkToken();

                // извлекаем указанный URL
                $url = trim($this->cms->param('item_id'));
                $items = array();
                if (!preg_match('!^https?://[^/]+(/.*)?!i', $url)) {
                    $this->pushError('URL интересующей страницы должен быть указан '
                                   . 'полностью, например http://example.com/document-url !');
                } else {

                    // проверяем поддержку Client URL
                    if (!function_exists('curl_init')
                    || !function_exists('curl_setopt')
                    || !function_exists('curl_exec')
                    || !function_exists('curl_close')
                    || !function_exists('curl_errno')
                    || !function_exists('curl_error')) {
                        $this->pushError('В настройках PHP на вашем сайте отключена библиотека '
                                       . 'Client URL! Нужно включить для работоспособности '
                                       . 'данной страницы.');
                    } else {

                        // инициализируем сеанс Client URL
                        $handle = @ curl_init();
                        if ($handle === FALSE) {
                            $this->pushError('Не удается инициализировать новый сеанс Client URL!');
                        } else {

                            // загружаем страницу
                            try {
                                @ curl_setopt($handle, CURLOPT_URL, $url);
                                @ curl_setopt($handle, CURLOPT_HEADER, 1);
                                @ curl_setopt($handle, CURLOPT_RETURNTRANSFER , 1);
                                @ curl_setopt($handle, CURLOPT_TIMEOUT, 15);
                                if ($csid_enabled) {
                                    $param = trim(ini_get('session.name'));
                                    if ($param == '') $param = 'PHPSESSID';
                                    @ curl_setopt($handle, CURLOPT_COOKIE, urlencode($param) . '=' . urlencode(md5($csid_value)));
                                }
                                $data = @ curl_exec($handle);
                                if (curl_errno($handle)) {
                                    $this->pushError('Не удается загрузить страницу по указанному адресу!<br><br>'
                                                   . 'Причина: ' . htmlspecialchars(curl_error($handle), ENT_QUOTES));
                                } else {

                                    // переводы строк одним символом
                                    $data = str_replace("\n", strpos($data, "\r") !== FALSE ? '' : "\r", $data);

                                    // извлекаем серверные заголовки, если есть
                                    $items[0] = array();
                                    $line = FALSE;
                                    while (preg_match('/^.*?\r/', $data, $line)) {
                                        $line = isset($line[0]) ? $line[0] : '';
                                        $size = strlen($line);
                                        $line = trim($line);
                                        if (substr($line, 0, 1) == '<') break;
                                        $data = substr($data, $size);
                                        if ($line == '') break;
                                        $items[0][] = $line;
                                    }

                                    // извлекаем заголовки HTML, если есть
                                    $items[1] = array();
                                    if (preg_match('!<head>.*?</head>!is', $data, $line)) {
                                        $data = isset($line[0]) ? $line[0] : '';
                                        if (preg_match_all('!<meta\s+([^>]+)>!i', $data, $line)) {
                                            $list = isset($line[1]) ? $line[1] : FALSE;
                                            if (is_array($list) && !empty($list)) {
                                                foreach ($list as $line) {
                                                    $line = ' ' . $line;
                                                    if ((preg_match('! http-equiv=(["\'])(.+?)\1!i', $line, $param)
                                                    || preg_match('! name=(["\'])(.+?)\1!i', $line, $param))
                                                    && preg_match('! content=(["\'])(.*?)\1!i', $line, $value)) {
                                                        $param = isset($param[2]) ? trim($param[2]) : '';
                                                        if ($param != '') {
                                                            $value = isset($value[2]) ? trim($value[2]) : '';
                                                            $items[1][] = $param . ': ' . $value;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        // извлекаем данные канонизации, если есть
                                        $items[2] = array();
                                        if (preg_match_all('!<link\s+([^>]+)>!i', $data, $line)) {
                                            $list = isset($line[1]) ? $line[1] : FALSE;
                                            if (is_array($list) && !empty($list)) {
                                                foreach ($list as $line) {
                                                    $line = ' ' . $line;
                                                    if (preg_match('! rel=(["\'])canonical\1!i', $line)
                                                    && preg_match('! href=(["\'])(.*?)\1!i', $line, $value)) {
                                                        $value = isset($value[2]) ? trim($value[2]) : '';
                                                        $items[2][] = 'Canonical: ' . $value;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                @ curl_close($handle);
                            } catch (Exception $e) {
                                $this->pushError('Сбой сеанса Client URL!');
                            }
                        }
                    }
                }

                // передаем нужные сведения в шаблонизатор
                $this->cms->smarty->assignByRef('item_id', $url);
                $this->cms->smarty->assignByRef('items', $items);
            }

            // передаем нужные сведения в шаблонизатор
            $this->cms->smarty->assignByRef('csid_enabled', $csid_enabled);
            $this->cms->smarty->assignByRef('csid_value', $csid_value);
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(HEADERS_PAGE_TITLE)) return TRUE;

            // обрабатываем запуск просмотра
            $this->processStart();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef('message', $this->info_msg);
            $this->cms->smarty->assignByRef('error', $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);
            return TRUE;
        }
    }



    return;
?>