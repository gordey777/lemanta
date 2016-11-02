<?php
    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/AdminSetup.php');



    // =======================================================================
    /**
    *  Макет универсальный редактируемых настроек админпанели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AdminSetupUniversalREFModel extends AdminSetupREFModel {



        // ===================================================================
        /**
        *  Сохранение полученных во время редактирования настроек сайта
        *
        *  @access  protected
        *  @param   string  $upload_folder      относительное имя папки сохранения ожидаемых файлов (будет возвращено сюда)
        *                                       пустая строка = не ждем таких
        *  @param   string  $upload_watermark   имя ожидаемого файла водяного знака (будет возвращено сюда)
        *                                       пустая строка = не ждем такой файл
        *  @return  void
        */
        // ===================================================================

        protected function processSetupSave ( & $upload_folder = '', & $upload_watermark = '' ) {

            // какие настройки есть у модуля?
            $this->settings_category = $this->conf->category;
            $this->settings_model = $this->conf->model;
            $settings = $this->conf->settings;
            if (!empty($settings) && is_array($settings)) {

                // префикс имени настроек и категория настроек
                $prefix = $this->getSettingsPrefix();
                $category = $this->getSettingsCategory();

                // перебираем настройки
                foreach ($settings as $name => $def) {
                    if (is_string($name)) {
                        $name = trim($name);
                        if ($name != '') {
                            $name = $prefix . $name;

                            // если такая есть в посте
                            if ($this->request->existsPost($name)) {
                                if (!is_array($def)) $def = array($def);
                                $description = isset($def[1]) ? preg_replace('/[ \t\r\n\s]+/u', ' ', trim($def[1])) : null;
                                $left = isset($def[2]) && is_array($def[2]) ? $def[2] : null;
                                $right = isset($def[3]) && is_array($def[3]) ? $def[3] : null;
                                $def = isset($def[0]) ? $def[0] : '';

                                // извлекаем значение из поста
                                $value = $this->processSetupSaveGetPostValue($name, $def, $left, $right);

                                // сохраняем настройку
                                $this->cms->db->settings->save($name, $value, $description, $category);
                            }
                        }
                    }
                }
            }

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
        }



        // ===================================================================
        /**
        *  Извлечение значения из POST-запроса при сохранении редакции настроек
        *
        *  @access  protected
        *  @param   string  $name       имя значения
        *  @param   mixed   $def        значение по умолчанию
        *  @param   mixed   $left       NULL или массив проверки левой границы значения (см. BasicREFModelConf)
        *  @param   mixed   $right      NULL или массив проверки правой границы значения (см. BasicREFModelConf)
        *  @param   integer $decimals   число дробных знаков при округлении чисел с плавающей запятой
        *  @param   float   $rate       курс для пересчета чисел с плавающей запятой
        *  @return  mixed               значение
        */
        // ===================================================================

        protected function processSetupSaveGetPostValue ( $name, $def, $left = null, $right = null, $decimals = 4, $rate = 1 ) {

            // извлекаем из поста согласно типу дефолтного значения
            if (is_bool($def)) {
                return $this->request->getPostAsBoolean($name, $def ? 1 : 0);
            } elseif (is_int($def)) {
                return $this->request->getPostAsInteger($name, $def);
            } elseif (is_float($def)) {
                $value = $this->request->getPostAsFloat($name, $def);
                return number_format(round($value * $rate, $decimals), $decimals, '.', '');
            }
            return $this->request->getPostAsSentence($name, $def);
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
            if (!$this->checkTemplate()) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;
?>