<?php
    // =======================================================================
    /**
    *  Админ модуль сравнения прогрузок страниц сайтов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    if (!defined('ROOT_FOLDER_REFERENCE')) return;
    if (!defined('FOLDERNAME_FOR_ENGINE_OBJECTS')) return;
    if (!defined('FILENAME_FOR_ENGINE_DEFINITION_OBJECT')) return;

    // подключаем константы движка
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);

    // подключаем базовый класс
    require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . '/' . FILENAME_FOR_ENGINE_BASIC_OBJECT);

    // текст заголовка страницы модуля
    define('SPEEDOMETER_PAGE_TITLE', 'Измерение скорости прогрузки страниц');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('SPEEDOMETER_TEMPLATE_FILENAME', 'speedometer/speedometer.htm');
    define('SPEEDOMETER_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                        . SPEEDOMETER_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // сообщение о незаполненной форме
    define('SPEEDOMETER_NOURL_MSG', 'Вы не указали ни одного адреса страницы сайта!');

    // сообщение о блокировке в демо режиме
    define('SPEEDOMETER_DEMOMODE_MSG', 'В демо версии запрещено запускать этот модуль.');

    // имена переменных в шаблонизаторе
    define('SPEEDOMETER_SMARTYVAR_SITECOUNT', 'site_count');
    define('SPEEDOMETER_SMARTYVAR_TESTCOUNT', 'test_count');
    define('SPEEDOMETER_SMARTYVAR_TESTTIMER', 'test_timer');
    define('SPEEDOMETER_SMARTYVAR_ITEMS', 'items');
    define('SPEEDOMETER_SMARTYVAR_COUNT', 'count');
    define('SPEEDOMETER_SMARTYVAR_TIMER', 'timer');
    define('SPEEDOMETER_SMARTYVAR_SAMPLES', 'samples');

    // состояния прогрузки страниц
    define('SPEEDOMETER_PAGESTATE_NONAME', 0);
    define('SPEEDOMETER_PAGESTATE_OPENING', SPEEDOMETER_PAGESTATE_NONAME + 1);
    define('SPEEDOMETER_PAGESTATE_READING', SPEEDOMETER_PAGESTATE_OPENING + 1);
    define('SPEEDOMETER_PAGESTATE_ERROR', SPEEDOMETER_PAGESTATE_READING + 1);

    // размер поблочной прогрузки
    define('SPEEDOMETER_READING_BLOCKSIZE', 32768);

    // предельный размер графа колебаний чтения
    define('SPEEDOMETER_TIMETRACE_MAXSIZE', 65);

    // умалчиваемое число обрабатываемых сайтов
    define('SPEEDOMETER_SITECOUNT_DEFAULT', 4);

    // информация для автоподхвата модуля движком (в значениях констант строго
    // должна быть элементарная строка, НЕ ИСПОЛЬЗОВАТЬ конкатенацию частями!):
    //   ..._MODULELINK_POINTER - указатель на модуль в ссылке, то есть
    //                            что добавить в ссылку после ?section=
    //   ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //   ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    //                            на страницу модуля
    define('SPEEDOMETER_MODULELINK_POINTER', 'Speedometer');
    define('SPEEDOMETER_MODULETAB_TEXT', 'скорости');
    define('SPEEDOMETER_MODULEMENU_PATH', 'Утилиты / Мониторинг / Сравнение скоростей сайтов');



    // =======================================================================
    /**
    *  Админ модуль сравнения прогрузок страниц сайтов
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Speedometer extends Basic {

        // предельное число обрабатываемых сайтов
        private $site_maxcount = SPEEDOMETER_SITECOUNT_DEFAULT;

        // предельное число тестовых прогрузок
        private $test_maxcount = 25;

        // предельное число секунд между тестами
        private $test_maxtimer = 60;



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $parent     объект владельца
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $parent = null ) {

            // конструируем объект: вторым параметром сообщаем, что он для админпанели
            parent::__construct($parent, BASIC_START_FOR_ADMIN_MODE);
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

            // устанавливаем заголовок страницы
            $this->title = ADMIN_PAGE_TITLE_PREFIX . SPEEDOMETER_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = SPEEDOMETER_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . SPEEDOMETER_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->settings->admin_theme)
                  . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

            // обрабатываем запрос от пользователя
            $this->process();

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Обработка запроса от пользователя
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function process () {

            // если точно получен POST-запрос, проверяем token-аутентичность
            // вызова модуля (неаутентичных перенаправит на главную)
            if (isset($_POST) && !empty($_POST)) $this->check_token();

            // передаем в шаблонизатор:
            //   возможное количество сайтов
            //   возможное число тестовых прогрузок
            //   возможное значение таймера между тестами
            $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_SITECOUNT, $this->site_maxcount);
            $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_TESTCOUNT, $this->test_maxcount);
            $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_TESTTIMER, $this->test_maxtimer);

            // берем из входящего POST-запроса указанные
            // пользователем адреса страниц сайтов
            $urls = array();
            for ($i = 0; $i < $this->site_maxcount; $i++) {
                $url = isset($_POST[SPEEDOMETER_SMARTYVAR_ITEMS][$i]) ? $_POST[SPEEDOMETER_SMARTYVAR_ITEMS][$i] : '';
                $url = str_replace("\r", '', $url);
                $url = str_replace("\n", '', $url);
                $url = str_replace("\t", ' ', $url);
                $url = trim($url);
                $urls[] = $url;

                // проверяем, что адрес указан верно, иначе
                // запоминаем сообщение об ошибке
                if ($url != '') {
                    $url = str_replace('\\', '/', $url);
                    $url = explode('://', $url, 2);
                    $url = strtolower($url[0]);
                    if (($url != 'http') && ($url != 'https')) {
                      $this->push_error('В колонке ' . ($i + 1) . ' ссылка на страницу '
                                      . 'должна начинаться с протокола: http, https!');
                    }
                }
            }

            // передаем массив адресов страниц в шаблонизатор
            $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_ITEMS, $urls);

            // берем из запроса указанное значение
            // таймера повторов и передаем в шаблонизатор
            $timer = isset($_POST[SPEEDOMETER_SMARTYVAR_TIMER]) ? intval($_POST[SPEEDOMETER_SMARTYVAR_TIMER]) : 0;
            $timer = min($timer, $this->test_maxtimer);
            $timer = max(0, $timer);
            $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_TIMER, $timer);

            // берем количество тестов и передаем в шаблонизатор
            $count = isset($_POST[SPEEDOMETER_SMARTYVAR_COUNT]) ? intval($_POST[SPEEDOMETER_SMARTYVAR_COUNT]) : 1;
            $count = min($count, $this->test_maxcount);
            $count = max(1, $count);
            $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_COUNT, $count);

            // если точно получен POST-запрос и не обнаружено ошибок в нем
            if (isset($_POST) && !empty($_POST)
            && ($this->error_msg == '')) {

                // блокируем запуск основной функции модуля,
                // если находимся в демо режиме
                if ($this->config->demo) {
                    $this->push_error(SPEEDOMETER_DEMOMODE_MSG);
                } else {

                    // делаем тестовые прогрузки страниц, принимая
                    // на выходе массив замеров и передаем в шаблонизатор
                    $samples = & $this->make_test($urls, $timer, $count);
                    $this->smarty->assignByRef(SPEEDOMETER_SMARTYVAR_SAMPLES, $samples);
                }
            }

            // передаем в шаблонизатор сообщение о найденных ошибках
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
        }



        // ===================================================================
        /**
        *  Выполнение тестовых прогрузок
        *
        *  @access  protected
        *  @param   array   $urls       массив адресов страниц
        *  @param   integer $timer      число секунд между соседними тестами
        *  @param   integer $count      число тестов
        *  @return  array               массив замеров
        */
        // ===================================================================

        protected function make_test ( & $urls, $timer, $count ) {

            // пока замеров нет
            $samples = array();

            // пробуем убрать лимит времени на работу скрипта
            @ set_time_limit(0);

            // предполагаем, что выполнение тестов может не иметь смысла
            $gaga = TRUE;

            // делаем заявленное число тестов
            while ($count > 0) {
                $count--;

                // формируем массив-строку замеров
                $sites = array();
                if (is_array($urls) && !empty($urls)) {
                    foreach ($urls as $index => & $url) {

                        // сначала метки времени совпадают
                        $time1 = microtime(TRUE);
                        $time2 = $time1;

                        // готовим замер:
                        //   ->state     - конечное состояние
                        //   ->filesize  - размер прочитанного контента
                        //   ->opentime  - время отклика
                        //   ->readtime  - время чтения контента
                        //   ->closetime - время отключения
                        //   ->timetrace - граф колебаний чтения
                        $sample = null;
                        $sample->state = SPEEDOMETER_PAGESTATE_NONAME;
                        $sample->filesize = 0;
                        $sample->opentime = $time1;
                        $sample->readtime = $time2;
                        $sample->closetime = 0;
                        $sample->timetrace = array();

                        // пробуем открыть страницу
                        if ($url != '') {
                            $sample->state = SPEEDOMETER_PAGESTATE_OPENING;
                            $handle = @ fopen($url, 'rb');

                            // размечаем окончившийся отклик и ожидаемое чтение
                            $time1 = microtime(TRUE);
                            $time2 = $time1;
                            $sample->readtime = $time2;

                            // подтверждаем, что выполнение тестов оправдано
                            // (то есть хоть один адрес был указан)
                            $gaga = FALSE;

                            // если отклик удачен
                            if ($handle) {

                                // начинаем грузить поблочно
                                $sample->state = SPEEDOMETER_PAGESTATE_READING;
                                while (!feof($handle)) {

                                    // читаем блок и добавляем сведения в граф колебаний
                                    $time = microtime(TRUE);
                                    $data = @ fread($handle, SPEEDOMETER_READING_BLOCKSIZE);
                                    $time = abs(microtime(TRUE) - $time);
                                    if (count($sample->timetrace) >= SPEEDOMETER_TIMETRACE_MAXSIZE) {
                                        array_shift($sample->timetrace);
                                    }
                                    $sample->timetrace[] = $time;

                                    // если ошибка
                                    if ($data === FALSE) {
                                      $sample->state = SPEEDOMETER_PAGESTATE_ERROR;
                                      break;
                                    }

                                    // пересчитаем размер файла
                                    $sample->filesize += strlen($data);
                                }
                                @ fclose($handle);

                                // размечаем окончившееся чтение
                                $time2 = microtime(TRUE);

                                // последний замер в графе колебаний - это отключение
                                if (!empty($sample->timetrace)) {
                                    $sample->closetime = array_pop($sample->timetrace);
                                }

                                // конвертируем значения графа колебаний в проценты
                                // (чем больше процент, тем медленее читалось)
                                if (!empty($sample->timetrace)) {
                                    $min = min($sample->timetrace);
                                    $percent = max($sample->timetrace) / 100;
                                    if ($percent == 0) $percent = 1;
                                    foreach ($sample->timetrace as & $value) {
                                        $value = ($value - $min) / $percent;
                                    }
                                }
                            }
                        }

                        // вычисляем времена и добавляем замер в массив
                        $sample->opentime = abs($time1 - $sample->opentime);
                        $sample->readtime = abs(abs($time2 - $sample->readtime)
                                                - $sample->closetime);
                        $sites[$index] = $sample;
                    }
                }

                // если выполнение тестов бессмысленно (не указано
                // ни одного адреса), запоминаем сообщение об ошибке
                // и прерываемся
                if ($gaga) {
                    $this->push_error(SPEEDOMETER_NOURL_MSG);
                    break;
                }

                // запоминаем строку замеров
                $samples[] = $sites;

                // если не последний тест, замираем на время таймера
                if ($count > 0) sleep($timer);
            }

            // возвращаем массив замеров
            return $samples;
        }
    }



    return;
?>