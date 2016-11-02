<?php
    // макет справочника
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Макет редактируемых настроек админпанели
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class AdminSetupREFModel extends BasicREFModel {



        // ===================================================================
        /**
        *  Очистка соответствующих кеш-таблиц
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function resetCaches () {
        }



        // ===================================================================
        /**
        *  Обработка редактирования настроек сайта, принадлежащих данному модулю
        *
        *  @access  protected
        *  @return  void
        */
        // ===================================================================

        protected function processSetup () {

            // если получены данные об изменениях соответствующих настроек сайта
            if ($this->request->isPostedSetup()) {

                // проверяем token-аутентичность вызова модуля
                // (неаутентичных перенаправит на главную)
                $this->checkToken();

                // сохраняем настройки
                $upload_folder = '';
                $upload_watermark = '';
                $this->processSetupSave($upload_folder, $upload_watermark);

                // очищаем соответствующие кеш-таблицы
                $this->resetCaches();

                // может пытались загрузить изображение водяного знака?
                if ($upload_folder != '' && $upload_watermark != '') {
                    $this->processWatermark($upload_folder, $upload_watermark);
                }
            }
        }



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
            $upload_folder = '';
            $upload_watermark = '';
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

            // обрабатываем редактирование настроек модуля
            $this->processSetup();

            // передаем дополнительные сведения в шаблонизатор
            $this->cms->smarty->assignByRef('message', $this->info_msg);
            $this->cms->smarty->assignByRef('error', $this->error_msg);

            // создаем контент модуля
            $this->body = $this->cms->smarty->fetch($this->template);
            return TRUE;
        }



        // ===================================================================
        /**
        *  Обработка загрузки файла водяного знака
        *
        *  @access  protected
        *  @param   string  $folder     в какую папку (относительно корня админпанели)
        *  @param   string  $filename   имя файла
        *  @return  void
        */
        // ===================================================================

        protected function processWatermark ( $folder, $filename ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('MOD ' . strtoupper($this->getDBModel()) . ' processWatermark');

            // если файл точно запостили
            $param = 'watermark_filename';
            if ($this->request->isPostedFile($param)) {
                $file = & $_FILES[$param];

                // пробуем разобрать, что загрузили
                $url = trim($file['name']);
                if (preg_match('/^.+\.png$/i', $url)) {
                    $error = isset($file['error']) ? $file['error'] : UPLOAD_ERR_OK;
                    if ($file['tmp_name'] != '' && $error == UPLOAD_ERR_OK) {

                        // создаем папку для изображений, если ее нет (приказываем защитить папку файлом index.html)
                        $this->cms->smart_create_folder($folder, FOLDER_GUARD_MODE_VIA_INDEX);

                        // переносим в папку загруженное изображение
                        if (!move_uploaded_file($file['tmp_name'], $folder . $filename)) {
                            $this->pushError('Не удалось загрузить файл изображения '
                                           . 'водяного знака в "http://' . $this->cms->root_url
                                           . '/' . $this->hdd->safeFilename($this->cms->admin_folder)
                                           . '/' . $folder . $filename . '".');
                        }

                    } else {
                        switch ($error) {
                            case UPLOAD_ERR_INI_SIZE:
                                $this->pushError('Размер принятого файла "' . $url . '" превысил '
                                               . 'максимально допустимый размер, который задан '
                                               . 'директивой upload_max_filesize конфигурационного '
                                               . 'файла php.ini.');
                                break;
                            case UPLOAD_ERR_FORM_SIZE:
                                $size = $this->request->getPost('MAX_FILE_SIZE');
                                $this->pushError('Размер загружаемого файла "' . $url . '" превышает '
                                               . 'максимально допустимое значение'
                                               . (is_numeric($size) ? ' ' . trim($size) . ' байт' : '') . '.');
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $this->pushError('Загрузка файла "' . $url . '" прервалась и он был получен не весь.');
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $this->pushError('Не получен файл "' . $url . '".');
                                break;
                            default:
                                $this->pushError('Произошла неизвестная ошибка при попытке загрузить '
                                               . 'файл изображения водяного знака "' . $url . '".');
                        }
                    }

                } else {
                    $this->pushError('Файл изображения водяного знака "' . $url . '" должен быть png файлом.');
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }
    }



    return;
?>