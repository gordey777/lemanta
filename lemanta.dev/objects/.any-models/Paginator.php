<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Пагинатор страниц
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class PaginatorANYModel extends BasicANYModel {

        // имя файла шаблона или массив имен файлов
        protected $template = 'navigation.htm';



        // ===================================================================
        /**
        *  Создание контента
        *
        *  @access  public
        *  @param   integer $total      всего страниц
        *  @param   integer $current    индекс текущей страницы
        *  @param   object  $module     для какого модуля
        *  @return  string              контент
        */
        // ===================================================================

        public function make ( $total, $current, & $module ) {
            $this->cms->db->open_tracing_method('PAGINATOR make');
            $body = '';

            if ($current >= $total) $current = $total - 1;
            $current = max(0, $current);
            $module->smartyAssignByRef('CurrentPage', $current);

            // части адреса без нумератора
            $url = $this->request->getServerAsSentence('REQUEST_URI');
            $url = @ parse_url($url);
            $url['path'] = preg_replace('!(.*)[/\\\\]page[_\-][0-9]+[/\\\\]?$!iu', '$1', isset($url['path']) ? trim($url['path']) : '');
            $url['path'] = trim($url['path'], "/\\ \t\r\n");
            $url['query'] = isset($url['query']) ? trim($url['query']) : '';
                if ($url['query'] != '') {
                    $prev = '&' . $url['query'] . '&';
                    while (($url['query'] = preg_replace('/&show_all(\=[^&]*)?&/iu', '&', $prev)) != $prev) $prev = $url['query'];
                    while (($url['query'] = preg_replace('/&page_size(\=[^&]*)?&/iu', '&', $prev)) != $prev) $prev = $url['query'];
                    while (($url['query'] = preg_replace('/&page(\=[^&]*)?&/iu', '&', $prev)) != $prev) $prev = $url['query'];
                    $url['query'] = trim($url['query'], "& \t\r\n");
                    if ($url['query'] != '') $url['query'] = '?' . $url['query'];
                }
            $url['fragment'] = isset($url['fragment']) ? trim($url['fragment']) : '';
                if ($url['fragment'] != '') $url['fragment'] = '#' . $url['fragment'];

            // создаем список url-ов страниц
            $pages = array();
            for ($i = 0; $i < $total; $i++) {
                $pages[$i] = $url['path'] . ($i == 0 ? '' : '/page_' . $i) . $url['query'] . $url['fragment'];
            }

            // передаем в шаблонизатор url предыдущей и следующей
            $prev = '';
            $next = '';
            $all = '';
            if ($current > 0) $prev = & $pages[$current - 1];
            if ($current < $total - 1) $next = & $pages[$current + 1];
            if (!$module->settings->getAsBoolean($module->getSettingsPrefix() . 'show_all_disabled', TRUE)) {
                if ($total > 1) $all = $url['path'] . ($url['query'] != '' ? $url['query'] . '&' : '?') . 'show_all' . $url['fragment'];
            }
            $module->smartyAssignByRef('PrevPageUrl', $prev);
            $module->smartyAssignByRef('NextPageUrl', $next);
            $module->smartyAssignByRef('AllOnPageUrl', $all);

            // передаем в шаблонизатор список url-ов
            $module->smartyAssignByRef('Pages', $pages);

            // создаем контент по шаблону
            if ($total > 1) {
                $theme = $this->hdd->safeFilename($this->cms->dynamic_theme);
                if ($theme != '') {
                    $items = is_array($this->template) ? $this->template : array($this->template);
                    if (!empty($items)) {
                        $path = dirname(__FILE__) . '/../../design/' . $theme . '/html/';
                        foreach ($items as $template) {
                            if (is_string($template)) {
                                $file = $this->hdd->safeFilename($template, FALSE);
                                if ($file != '') {
                                    if ($this->hdd->isReadableFile($path . $file)) {
                                        $body = $this->cms->smarty->fetch($file);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->cms->db->close_tracing_method();
            return $body;
        }
    }



    return;
?>