<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Обработки элементов записей с учетом агрегации записей в опубликованных формах
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class EditorANYModel extends BasicANYModel {

        // модель эксклюзивная (информирует в свойства владельца)
        public $owner_exclusive = TRUE;



        // ===================================================================
        /**
        *  Обработка изменения полей NAME, PHONE, EMAIL, ADDRESS, ICQ, SKYPE записи
        *  (фио, телефоны, емейлы, адреса доставки, аськи, скайпы)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processPersonInfo ( & $item, $id, & $cancel ) {

            // обрабатываем поля NAME
            $field = 'name';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                $item->name2 = $this->request->getPostRecordFieldAsSentence('name2', $id);
                $item->name3 = $this->request->getPostRecordFieldAsSentence('name3', $id);
            }

            // обрабатываем поля PHONE
            $informed = FALSE;
            $field = 'phone';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if ($item->$field != '' && !preg_match(PHONE_CHECKING_PATTERN, $item->$field)) $cancel = $informed = $this->pushError('Телефон должен быть указан в международном формате +X XXX XXX-XX-XX!');
            }
            $field = 'phone2';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if (!$informed && $item->$field != '' && !preg_match(PHONE_CHECKING_PATTERN, $item->$field)) $cancel = $this->pushError('Телефон должен быть указан в международном формате +X XXX XXX-XX-XX!');
            }

            // обрабатываем поля EMAIL
            $informed = FALSE;
            $field = 'email';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if ($item->$field != '' && !preg_match(EMAIL_CHECKING_PATTERN, $item->$field)) $cancel = $informed = $this->pushError('Емейл должен быть указан в формате user@domain.zone!');
            }
            $field = 'email2';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if (!$informed && $item->$field != '' && !preg_match(EMAIL_CHECKING_PATTERN, $item->$field)) $cancel = $this->pushError('Емейл должен быть указан в формате user@domain.zone!');
            }

            // обрабатываем поля ICQ
            $informed = FALSE;
            $field = 'icq';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if ($item->$field != '' && !preg_match(ICQ_CHECKING_PATTERN, $item->$field)) $cancel = $informed = $this->pushError('Номер ICQ должен быть указан в общепринятом формате!');
            }
            $field = 'icq2';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if (!$informed && $item->$field != '' && !preg_match(ICQ_CHECKING_PATTERN, $item->$field)) $cancel = $this->pushError('Номер ICQ должен быть указан в общепринятом формате!');
            }

            // обрабатываем поля SKYPE
            $informed = FALSE;
            $field = 'skype';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if ($item->$field != '' && !preg_match(SKYPE_CHECKING_PATTERN, $item->$field)) $cancel = $informed = $this->pushError('Skype имя должно быть указано в общепринятом формате!');
            }
            $field = 'skype2';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                if (!$informed && $item->$field != '' && !preg_match(SKYPE_CHECKING_PATTERN, $item->$field)) $cancel = $this->pushError('Skype имя должно быть указано в общепринятом формате!');
            }

            // обрабатываем поля ADDRESS
            $field = 'address';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                $item->address_2 = $this->request->getPostRecordFieldAsSentence('address_2', $id);
                $item->address_3 = $this->request->getPostRecordFieldAsSentence('address_3', $id);
                $item->address_4 = $this->request->getPostRecordFieldAsSentence('address_4', $id);
                $item->address_5 = $this->request->getPostRecordFieldAsSentence('address_5', $id);
                $item->address_6 = $this->request->getPostRecordFieldAsSentence('address_6', $id);
                $item->address_7 = $this->request->getPostRecordFieldAsSentence('address_7', $id);
                $item->address_8 = $this->request->getPostRecordFieldAsSentence('address_8', $id);
                $item->address_9 = $this->request->getPostRecordFieldAsSentence('address_9', $id);
                $item->address_10 = $this->request->getPostRecordFieldAsSentence('address_10', $id);
            }
            $field = 'address2';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                $item->address2_2 = $this->request->getPostRecordFieldAsSentence('address2_2', $id);
                $item->address2_3 = $this->request->getPostRecordFieldAsSentence('address2_3', $id);
                $item->address2_4 = $this->request->getPostRecordFieldAsSentence('address2_4', $id);
                $item->address2_5 = $this->request->getPostRecordFieldAsSentence('address2_5', $id);
                $item->address2_6 = $this->request->getPostRecordFieldAsSentence('address2_6', $id);
                $item->address2_7 = $this->request->getPostRecordFieldAsSentence('address2_7', $id);
                $item->address2_8 = $this->request->getPostRecordFieldAsSentence('address2_8', $id);
                $item->address2_9 = $this->request->getPostRecordFieldAsSentence('address2_9', $id);
                $item->address2_10 = $this->request->getPostRecordFieldAsSentence('address2_10', $id);
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля IP записи (ip адрес визитера)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processIp ( & $item, $id, & $cancel ) {
            $field = 'name';
            if (isset($_POST[$field][$id])) {
                switch ($this->getOwnerProperty('dbtable')) {

                    // блокировки
                    case 'banneds':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if (empty($item->$field)) {
                            $cancel = $this->pushError('Не указан IP-адрес.');
                        } else {
                            if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(\s[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})*$/s', $item->$field)) {
                                $row = null;
                                $filter = new stdClass;
                                $filter->ip = $item->$field;
                                if (!empty($id)) $filter->exclude_id = $id;
                                $this->cms->db->get_banned($row, $filter);
                                if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным IP-адресом.');
                            } else {
                                $cancel = $this->pushError('IP-адрес "' . $item->$field . '" должен быть в формате X.X.X.X, где X - число от 0 до 255. '
                                                         . 'Возможен формат разделенных пробелом цепочки адресов, например Z.z.z.z Y.y.y.y X.x.x.x, '
                                                         . 'если требуется указать прокси-путь до компьютера с адресом X.x.x.x.');
                            }
                        }
                        break;

                    // заказы
                    case DATABASE_ORDERS_TABLENAME:
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        $item->host = $this->request->getPostRecordFieldAsSentence('host', $id);
                        break;
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля OBJECTS записи (список подключаемых плагинов)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processObjects ( & $item, $id, & $cancel ) {
            $field = 'objects';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsCommaList($field, $id);
                $item->$field = implode(', ', $item->$field);
                if ($this->cms->config->demo && !empty($item->$field)) $cancel = $this->pushError('В демо версии запрещено указывать подключаемые плагины.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля ARTICLE_IDS записи (список ИДов связанных статей)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processArticleIds ( & $item, $id, & $cancel ) {
            $field = 'article_ids';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsIdsArray($field, $id);
                $item->$field = implode(', ', $item->$field);
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля NEWS_IDS записи (список ИДов связанных новостей)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processNewsIds ( & $item, $id, & $cancel ) {
            $field = 'news_ids';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordFieldAsIdsArray($field, $id);
                $item->$field = implode(', ', $item->$field);
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля CATEGORY_ID записи (идентификатор категории)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processCategoryId ( & $item, $id, & $cancel ) {
            $field = 'category_id';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordField($field, $id);
                if (empty($item->$field)) $cancel = $this->pushError('Не указана категория товара.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля COUNTRY_ID записи (идентификатор страны)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processCountryId ( & $item, $id, & $cancel ) {
            $field = 'country_id';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordField($field, $id);
                if (empty($item->$field)) $cancel = $this->pushError('Не указана страна.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля REGION_ID записи (идентификатор области)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processRegionId ( & $item, $id, & $cancel ) {
            $field = 'region_id';
            if (isset($_POST[$field][$id])) {
                if (is_array($_POST[$field][$id])) {
                    $item->$field = 0;
                    if (isset($item->country_id)) {
                        if (isset($_POST[$field][$id][$item->country_id])) {
                            $item->$field = trim($_POST[$field][$id][$item->country_id]);
                        }
                    }
                } else {
                    $item->$field = $this->request->getPostRecordField($field, $id);
                }
                if (empty($item->$field)) $cancel = $this->pushError('Не указана область.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля TOWN_ID записи (идентификатор города)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processTownId ( & $item, $id, & $cancel ) {
            $field = 'town_id';
            if (isset($_POST[$field][$id])) {
                if (is_array($_POST[$field][$id])) {
                    $item->$field = 0;
                    if (isset($item->country_id)) {
                        if (isset($_POST[$field][$id][$item->country_id])) {
                            if (is_array($_POST[$field][$id][$item->country_id])) {
                                if (isset($item->region_id)) {
                                    if (isset($_POST[$field][$id][$item->country_id][$item->region_id])) {
                                        $item->$field = trim($_POST[$field][$id][$item->country_id][$item->region_id]);
                                    }
                                }
                            } else {
                                $item->$field = trim($_POST[$field][$id][$item->country_id]);
                            }
                        }
                    }
                } else {
                    $item->$field = $this->request->getPostRecordField($field, $id);
                }
                if (empty($item->$field)) $cancel = $this->pushError('Не указан город.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля SCHOOL_ID записи (идентификатор учебного заведения)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processSchoolId ( & $item, $id, & $cancel ) {
            $field = 'school_id';
            if (isset($_POST[$field][$id])) {
                if (is_array($_POST[$field][$id])) {
                    $item->$field = 0;
                    if (isset($item->country_id)) {
                        if (isset($_POST[$field][$id][$item->country_id])) {
                            if (is_array($_POST[$field][$id][$item->country_id])) {
                                if (isset($item->region_id)) {
                                    if (isset($_POST[$field][$id][$item->country_id][$item->region_id])) {
                                        if (is_array($_POST[$field][$id][$item->country_id][$item->region_id])) {
                                            if (isset($item->town_id)) {
                                                if (isset($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id])) {
                                                    $item->$field = trim($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id]);
                                                }
                                            }
                                        } else {
                                            $item->$field = trim($_POST[$field][$id][$item->country_id][$item->region_id]);
                                        }
                                    }
                                }
                            } else {
                                $item->$field = trim($_POST[$field][$id][$item->country_id]);
                            }
                        }
                    }
                } else {
                    $item->$field = $this->request->getPostRecordField($field, $id);
                }
                if (empty($item->$field)) $cancel = $this->pushError('Не указано учебное заведение.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля CLASS_ID записи (идентификатор класса учебного заведения)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processClassId ( & $item, $id, & $cancel ) {
            $field = 'class_id';
            if (isset($_POST[$field][$id])) {
                if (is_array($_POST[$field][$id])) {
                    $item->$field = 0;
                    if (isset($item->country_id)) {
                        if (isset($_POST[$field][$id][$item->country_id])) {
                            if (is_array($_POST[$field][$id][$item->country_id])) {
                                if (isset($item->region_id)) {
                                    if (isset($_POST[$field][$id][$item->country_id][$item->region_id])) {
                                        if (is_array($_POST[$field][$id][$item->country_id][$item->region_id])) {
                                            if (isset($item->town_id)) {
                                                if (isset($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id])) {
                                                    if (is_array($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id])) {
                                                        if (isset($item->school_id)) {
                                                            if (isset($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id][$item->school_id])) {
                                                                $item->$field = trim($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id][$item->school_id]);
                                                            }
                                                        }
                                                    } else {
                                                        $item->$field = trim($_POST[$field][$id][$item->country_id][$item->region_id][$item->town_id]);
                                                    }
                                                }
                                            }
                                        } else {
                                            $item->$field = trim($_POST[$field][$id][$item->country_id][$item->region_id]);
                                        }
                                    }
                                }
                            } else {
                                $item->$field = trim($_POST[$field][$id][$item->country_id]);
                            }
                        }
                    }
                } else {
                    $item->$field = $this->request->getPostRecordField($field, $id);
                }
                if (empty($item->$field)) $cancel = $this->pushError('Не указан класс учебного заведения.');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля COLLECTIVE1, 2, 3, 4 записи (коллектив учебного заведения)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processCollective ( & $item, $id, & $cancel ) {
            $table = $this->getOwnerProperty('dbtable');
            $number = 1;
            while ($number <= 4) {
                $field = 'collective' . $number;
                if (isset($_POST[$field][$id])) {
                    $item->$field = $this->request->getPostRecordField($field, $id);
                    switch ($table) {

                        // учебные заведения
                        case 'schools':

                            // если для этого модуля запрещен wysiwyg-редактор, обслуживаем настройку "как обрабатывать текст"
                            if ($this->settings->get($table . '_wysiwyg_disabled')) {
                                $mode = $table . '_wysiwyg_disabled_mode';
                                $mode = $this->settings->get($mode, FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION);
                                $item->$field = $this->cms->db->fix_simple_TEXTAREA_text_for_HTML($item->$field, $mode);
                            }
                            break;
                    }
                }
                $number++;
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля MODEL записи (название товара)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processModel ( & $item, $id, & $cancel ) {
            $field = 'model';
            if (isset($_POST[$field][$id])) {
                switch ($this->getOwnerProperty('dbtable')) {

                    // товары
                    case DATABASE_PRODUCTS_TABLENAME:
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название товара.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->model = $item->$field;
                            $filter->category_id = isset($item->category_id) ? $item->category_id : 0;
                            $filter->brand_id = isset($item->brand_id) ? $item->brand_id : 0;
                            $filter->section = isset($item->section) ? $item->section : 1;
                            $this->cms->db->products->one($row, $filter);
                            if (!empty($row)) {
                                $cancel = $this->pushError('Уже есть другой товар'
                                                         . (!empty($filter->brand_id) ? ' этого бренда ' : '')
                                                         . ' с аналогичным названием'
                                                         . (!empty($filter->category_id) ? ' в такой категории' : '')
                                                         . (!empty($filter->section) ? ' в указанном разделе магазина' : '') . '.');
                            }
                        }
                        break;
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля NAME записи (название)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processName ( & $item, $id, & $cancel ) {
            $field = 'name';
            if (isset($_POST[$field][$id])) {
                switch ($this->getOwnerProperty('dbtable')) {

                    // блокировки
                    case 'banneds':
                        break;

                    // статьи, медиа файлы, новости, специальные страницы
                    case 'articles':
                    case 'files':
                    case 'news':
                    case 'sections':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название в меню.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->menu_id = isset($item->menu_id) ? $item->menu_id : 0;
                            $filter->section = isset($item->section) ? $item->section : 1;
                            switch ($this->getOwnerProperty('dbtable')) {
                                case 'articles':
                                    $this->cms->db->get_article($row, $filter);
                                    break;
                                case 'news':
                                    $this->cms->db->news->one($row, $filter);
                                    break;
                                case 'sections':
                                    $this->cms->db->sections->one($row, $filter);
                                    break;
                                case 'files':
                                    $this->cms->db->get_file($row, $filter);
                                    break;
                            }
                            if (!empty($row)) {
                                $cancel = $this->pushError('Уже есть другая запись с аналогичным названием ' . (isset($item->menu_id) ? 'в таком' : 'вне') . ' меню' . (isset($item->section) ? ' указанного раздела магазина' : '') . '.');
                            }
                        }
                        break;

                    // варианты импорта
                    case 'imports':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if (empty($item->$field)) {
                            $cancel = $this->pushError('Не указано название варианта импорта.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->imports->one($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием варианта импорта.');
                        }
                        break;

                    // бренды, категории
                    case DATABASE_BRANDS_TABLENAME:
                    case DATABASE_CATEGORIES_TABLENAME:
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') $cancel = $this->pushError('Не указано название.');
                        break;

                    // способы доставки
                    case 'delivery_methods':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название способа доставки.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_delivery($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием способа доставки.');
                        }
                        break;

                    // типы доставки
                    case 'deliveries_types':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название типа доставки.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_deliveries_type($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием типа доставки.');
                        }
                        break;

                    // сроки доставки
                    case 'shippings_terms':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название срока отправки.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_shippings_term($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием срока отправки.');
                        }
                        break;

                    // стадии заказа
                    case DATABASE_ORDERS_PHASES_TABLENAME:
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название стадии заказа.');
                        } else {

                            // проверяем наличие другой НЕУДАЛЕННОЙ записи с таким же названием
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->deleted = 0;
                            $this->cms->db->get_orders_phase($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием стадии заказа.');
                        }
                        break;

                    // валюты
                    case 'currencies':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название валюты.');
                        } else {

                            // проверяем наличие другой НЕУДАЛЕННОЙ записи с таким же названием
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->deleted = 0;
                            $this->cms->db->get_currency($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием валюты.');
                        }
                        break;

                    // кредитные программы
                    case DATABASE_CREDIT_PROGRAMS_TABLENAME:
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название кредитной программы.');
                        } else {

                            // проверяем наличие другой НЕУДАЛЕННОЙ записи с таким же названием
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->deleted = 0;
                            $this->cms->db->credit_programs->one($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием кредитной программы.');
                        }
                        break;

                    // способы доставки
                    case 'payment_methods':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название способа оплаты.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->payments->one($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием способа оплаты.');
                        }
                        break;

                    // комплекты товаров
                    case 'products_kits':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название комплекта товаров.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->products_kits->one($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием комплекта товаров.');
                        }
                        break;

                    // страны
                    case 'countries':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название страны.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->countries->one($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием страны.');
                        }
                        break;

                    // области
                    case 'regions':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название области.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->country_id = isset($item->country_id) ? $item->country_id : 0;
                            $this->cms->db->get_region($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием области в такой стране.');
                        }
                        break;

                    // города
                    case 'towns':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название города.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->country_id = isset($item->country_id) ? $item->country_id : 0;
                            $filter->region_id = isset($item->region_id) ? $item->region_id : 0;
                            $this->cms->db->get_town($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием города в такой области страны.');
                        }
                        break;

                    // учебные заведения
                    case 'schools':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название учебного заведения.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $filter->country_id = isset($item->country_id) ? $item->country_id : 0;
                            $filter->region_id = isset($item->region_id) ? $item->region_id : 0;
                            $filter->town_id = isset($item->town_id) ? $item->town_id : 0;
                            $this->cms->db->get_school($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием учебного заведения в таком городе страны.');
                        }
                        break;

                    // типы учебных заведений
                    case 'schools_types':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название типа учебного заведения.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_schools_type($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием типа учебного заведения.');
                        }
                        break;

                    // уроки учебных заведений
                    case 'schools_lessons':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название предмета учебного заведения.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_schools_lesson($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием предмета учебного заведения.');
                        }
                        break;

                    // классы учебных заведений
                    case 'schools_classes':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название класса учебного заведения.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_schools_class($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием класса учебного заведения.');
                        }
                        break;

                    // свойства
                    case 'properties':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название свойства товара.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_property($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием свойства товара.');
                        }
                        break;

                    // склады
                    case 'stocks':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название склада.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->stocks->one($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием склада.');
                        }
                        break;

                    // менюшки
                    case DATABASE_MENUS_TABLENAME:
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') $cancel = $this->pushError('Не указано название меню.');
                        break;

                    // зарегистрированные модули
                    case 'modules':
                        $item->$field = $this->request->getPostRecordFieldAsSentence($field, $id);
                        if ($item->$field == '') {
                            $cancel = $this->pushError('Не указано название модуля.');
                        } else {
                            $row = null;
                            $filter = new stdClass;
                            if (!empty($id)) $filter->exclude_id = $id;
                            $filter->name = $item->$field;
                            $this->cms->db->get_module($row, $filter);
                            if (!empty($row)) $cancel = $this->pushError('Уже есть другая запись с аналогичным названием модуля.');
                        }
                        break;
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля ANNOTATION записи (краткое описание)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processAnnotation ( & $item, $id, & $cancel ) {
            $field = 'annotation';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordField($field, $id);
                $table = $this->getOwnerProperty('dbtable');
                switch ($table) {

                    // статьи, новости, склады
                    case 'articles':
                    case 'news':
                    case 'stocks':

                        // если для этого модуля запрещен wysiwyg-редактор, обслуживаем настройку "как обрабатывать текст"
                        if ($this->settings->get($table . '_wysiwyg_disabled')) {
                            $mode = $table . '_wysiwyg_disabled_mode';
                            $mode = $this->settings->get($mode, FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION);
                            $item->$field = $this->cms->db->fix_simple_TEXTAREA_text_for_HTML($item->$field, $mode);
                        }
                        break;
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля DESCRIPTION записи (описание)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processDescription ( & $item, $id, & $cancel ) {
            $field = 'description';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordField($field, $id);
                $table = $this->getOwnerProperty('dbtable');
                $name = '';
                switch ($table) {

                    // способы доставки, способы оплаты, кредитные программы, комплекты товаров
                    // (имеют нестандартное имя настроек)
                    case 'delivery_methods':
                        if ($name == '') $name = 'deliveries';
                    case 'payment_methods':
                        if ($name == '') $name = 'payments';
                    case DATABASE_CREDIT_PROGRAMS_TABLENAME:
                        if ($name == '') $name = 'creditprograms';
                    case 'products_kits':
                        if ($name == '') $name = 'productskits';

                    // бренды, категории, товары, медиа файлы, склады, страны, области, города, учебные заведения
                    case DATABASE_BRANDS_TABLENAME:
                    case DATABASE_CATEGORIES_TABLENAME:
                    case DATABASE_PRODUCTS_TABLENAME:
                    case 'files':
                    case 'stocks':
                    case 'countries':
                    case 'regions':
                    case 'towns':
                    case 'schools':
                        if ($name == '') $name = $table;

                        // если для этого модуля запрещен wysiwyg-редактор, обслуживаем настройку "как обрабатывать текст"
                        if ($this->settings->get($name . '_wysiwyg_disabled')) {
                            $mode = $name . '_wysiwyg_disabled_mode';
                            $mode = $this->settings->get($mode, FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION);
                            $item->$field = $this->cms->db->fix_simple_TEXTAREA_text_for_HTML($item->$field, $mode);
                        }
                        break;
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля BODY записи (полное описание)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processBody ( & $item, $id, & $cancel ) {
            $field = 'body';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordField($field, $id);
                $table = $this->getOwnerProperty('dbtable');
                $name = '';
                switch ($table) {

                    // комплекты товаров (имеют нестандартное имя настроек)
                    case 'products_kits':
                        if ($name == '') $name = 'productskits';

                    // статьи, новости, товары, специальные страницы
                    case 'articles':
                    case 'news':
                    case DATABASE_PRODUCTS_TABLENAME:
                    case 'sections':
                        if ($name == '') $name = $table;

                        // если для этого модуля запрещен wysiwyg-редактор, обслуживаем настройку "как обрабатывать текст"
                        if ($this->settings->get($name . '_wysiwyg_disabled')) {
                            $mode = $name . '_wysiwyg_disabled_mode';
                            $mode = $this->settings->get($mode, FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION);
                            $item->$field = $this->cms->db->fix_simple_TEXTAREA_text_for_HTML($item->$field, $mode);
                        }
                        break;
                }
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля SEO_DESCRIPTION записи (seo текст)
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   integer $id         идентификатор записи
        *  @param   boolean $cancel     TRUE если отменить редакцию (будет возвращено в эту переменную)
        *  @return  void
        */
        // ===================================================================

        public function processSeoDescription ( & $item, $id, & $cancel ) {
            $field = 'seo_description';
            if (isset($_POST[$field][$id])) {
                $item->$field = $this->request->getPostRecordField($field, $id);
                $table = $this->getOwnerProperty('dbtable');
                $name = '';
                switch ($table) {

                    // комплекты товаров (имеют нестандартное имя настроек)
                    case 'products_kits':
                        if ($name == '') $name = 'productskits';

                    // бренды, категории, товары, статьи, новости, специальные страницы, медиа файлы, склады, страны, области, города, учебные заведения
                    case DATABASE_BRANDS_TABLENAME:
                    case DATABASE_CATEGORIES_TABLENAME:
                    case DATABASE_PRODUCTS_TABLENAME:
                    case 'articles':
                    case 'news':
                    case 'sections':
                    case 'files':
                    case 'stocks':
                    case 'countries':
                    case 'regions':
                    case 'towns':
                    case 'schools':
                        if ($name == '') $name = $table;

                        // если для этого модуля запрещен wysiwyg-редактор, обслуживаем настройку "как обрабатывать текст"
                        if ($this->settings->get($name . '_wysiwyg_disabled')) {
                            $mode = $name . '_wysiwyg_disabled_mode';
                            $mode = $this->settings->get($mode, FIX_SIMPLE_TEXTAREA_TEXT_MODE_NO_ACTION);
                            $item->$field = $this->cms->db->fix_simple_TEXTAREA_text_for_HTML($item->$field, $mode);
                        }
                        break;
                }
            }
        }















        // обработка изменения поля CATEGORIES записи ============================

        public function processCategories ( & $item, $id, & $cancel ) {
            if (isset($_POST['categories'][$id])) {
                $ids = array();
                if (is_array($_POST['categories'][$id])) {
                    foreach ($_POST['categories'][$id] as $cid) {
                        $cid = intval($cid);
                        if (!empty($cid) && (!isset($item->category_id) || ($cid != $item->category_id))) $ids[$cid] = $cid;
                    }
                    sort($ids, SORT_NUMERIC);
                }
                switch ($this->getOwnerProperty('dbtable')) {
                    case 'delivery_methods':
                        $item->undelivery_category_ids = implode(',', $ids);
                        break;
                    case DATABASE_PRODUCTS_TABLENAME:
                        // если не указано, что имеет еще прикрепления кроме основного
                        if (!isset($_POST['use_categories'][$id]) || ($_POST['use_categories'][$id] != 1)) $ids = array();
                        // для html-формы запоминаем, были ли найдены вторичные прикрепления
                        if (!empty($ids)) $item->use_categories = 1;
                        $item->categories = $ids;
                        break;
                }
            }
        }

        // обработка изменения поля DELIVERIES записи ============================

        public function processDeliveries ( & $item, $id, & $cancel ) {
            if (isset($_POST['deliveries'][$id])) {
                $ids = array();
                if (is_array($_POST['deliveries'][$id])) {
                    foreach ($_POST['deliveries'][$id] as $id) {
                        $id = intval($id);
                        if (!empty($id) && (!isset($item->delivery_id) || ($id != $item->delivery_id))) $ids[$id] = $id;
                    }
                    sort($ids, SORT_NUMERIC);
                }
                switch ($this->getOwnerProperty('dbtable')) {
                    case 'payment_methods':
                        $item->deliveries_ids = $ids;
                        break;
                }
            }
        }

        // обработка изменения поля PAYMENTS записи ==============================

        public function processPayments ( & $item, $id, & $cancel ) {
            if (isset($_POST['payments'][$id])) {
                $ids = array();
                if (is_array($_POST['payments'][$id])) {
                    foreach ($_POST['payments'][$id] as $id) {
                        $id = intval($id);
                        if (!empty($id) && (!isset($item->payment_id) || ($id != $item->payment_id))) $ids[$id] = $id;
                    }
                    sort($ids, SORT_NUMERIC);
                }
                switch ($this->getOwnerProperty('dbtable')) {
                    case 'delivery_methods':
                        $item->payments_ids = $ids;
                        break;
                }
            }
        }

        // обработка изменения поля TYPES записи =================================

        public function processTypes ( & $item, $id, & $cancel ) {
            if (isset($_POST['types'][$id])) {
                $ids = array();
                if (is_array($_POST['types'][$id])) {
                    foreach ($_POST['types'][$id] as $id) {
                        $id = intval($id);
                        if (!empty($id) && (!isset($item->type_id) || ($id != $item->type_id))) $ids[$id] = $id;
                    }
                    sort($ids, SORT_NUMERIC);
                }
                switch ($this->getOwnerProperty('dbtable')) {
                    case 'delivery_methods':
                        $item->types_ids = implode(',', $ids);
                        break;
                }
            }
        }

        // обработка изменения поля LESSONS_IDS записи ===========================

        public function processLessons ( & $item, $id, & $cancel ) {
            if (isset($_POST['lessons'][$id])) {
                $item->lessons_ids = array();
                if (is_array($_POST['lessons'][$id])) {
                    foreach ($_POST['lessons'][$id] as $lesson_id) {
                        $lesson_id = intval($lesson_id);
                        if (!empty($lesson_id)) $item->lessons_ids[$lesson_id] = $lesson_id;
                    }
                    sort($item->lessons_ids, SORT_NUMERIC);
                }
                if (empty($item->lessons_ids)) $cancel = $this->pushError('Не указаны изучаемые предметы.');
                $item->lessons_ids = implode(',', $item->lessons_ids);
            }
        }

        // обработка изменения поля CLASSES_IDS записи ===========================

        public function processClasses ( & $item, $id, & $cancel ) {
            if (isset($_POST['classes'][$id])) {
                $item->classes_ids = array();
                if (is_array($_POST['classes'][$id])) {
                    foreach ($_POST['classes'][$id] as $class_id) {
                        $class_id = intval($class_id);
                        if (!empty($class_id)) $item->classes_ids[$class_id] = $class_id;
                    }
                    sort($item->classes_ids, SORT_NUMERIC);
                }
                if (empty($item->classes_ids)) $cancel = $this->pushError('Не указаны классы учебного заведения.');
                $item->classes_ids = implode(',', $item->classes_ids);
            }
        }

        // обработка изменения поля TYPE_ID записи ===============================

        public function processType ( & $item, $id, & $cancel ) {
            if (isset($_POST['type_id'][$id])) {
                $item->type_id = trim($_POST['type_id'][$id]);
                if (empty($item->type_id)) $cancel = $this->pushError('Не указан тип учебного заведения.');
            }
        }

        // обработка изменения полей RINGB, RINGE записи =========================

        public function processRings ( & $item, $id, & $cancel ) {
            if (isset($_POST['ringb']) && isset($_POST['ringe'])) {
                $item->ringb = '';
                $item->ringe = '';
                if (is_array($_POST['ringb']) && is_array($_POST['ringe'])) {
                    foreach ($_POST['ringb'] as $index => $value) {
                        $item->ringb .= trim(str_replace(',', '', $value)) . ',';
                        if (isset($_POST['ringe'][$index])) $item->ringe .= trim(str_replace(',', '', $_POST['ringe'][$index]));
                        $item->ringe .= ',';
                    }
                }
            }
        }

        // обработка изменения поля RATING, VOTES записи =========================

        public function processRating ( & $item, $id, & $cancel ) {
            if (isset($_POST['votes'][$id])) $item->votes = abs(intval($_POST['votes'][$id]));
            if (isset($_POST['rating'][$id])) {
                $item->rating = abs($this->number->floatValue($_POST['rating'][$id]));
                if (isset($item->votes) && ($item->votes != 0)) $item->rating = $item->rating * $item->votes;
            }
        }

        // обработка изменения поля SUBDOMAIN записи =============================

        public function processSubdomain ( & $item, $id, & $cancel ) {
            if (isset($_POST['subdomain'][$id])) {
                $item->subdomain = trim($_POST['subdomain'][$id]);
                // удаляем из субдомена однозначно ошибочные детали
                while (substr($item->subdomain, 0, 1) == '.') $item->subdomain = trim(substr($item->subdomain, 1));
                while (substr($item->subdomain, -1) == '.') $item->subdomain = trim(substr($item->subdomain, 0, -1));
                while (strpos($item->subdomain, '..') !== FALSE) $item->subdomain = str_replace('..', '.', $item->subdomain);
                if (($item->subdomain != '') && preg_match('/[^a-z0-9\-\.]/i', $item->subdomain)) {
                    $cancel = $this->pushError('Имя субдомена "' . $item->subdomain . '" может состоять только из символов: точка, дефис (тире), цифры, буквы английского алфавита!');
                } elseif ($item->subdomain != '') {
                    // в согласии с текущей таблицей базы данных задаем, по какому идентификатору нужно будет проверить использование субдомена
                    switch ($this->getOwnerProperty('dbtable')) {
                        case DATABASE_BRANDS_TABLENAME:
                            $mode = CHECK_SUBDOMAIN_USING_MODE_BY_BRANDID;
                            break;
                        case DATABASE_CATEGORIES_TABLENAME:
                            $mode = CHECK_SUBDOMAIN_USING_MODE_BY_CATEGORYID;
                            break;
                        case DATABASE_PRODUCTS_TABLENAME:
                            $mode = CHECK_SUBDOMAIN_USING_MODE_BY_PRODUCTID;
                            break;
                    }
                    // проверяем, вернет ли объект базы данных любую существующую запись с таким субдоменом
                    $this->cms->db->get_subdomain_using($record, $item->subdomain, $id, $mode);
                    if (!empty($record)) {
                        if (!is_null($record->brand_id)) {
                            $cancel = $this->pushError('Такое имя субдомена "' . $item->subdomain . '" уже используется для <a href="index.php?' . REQUEST_PARAM_NAME_SECTION . '=Brand&' . REQUEST_PARAM_NAME_ITEMID . '=' . $record->brand_id . '&' . REQUEST_PARAM_NAME_TOKEN . '=' . $this->cms->token . '">этого бренда</a>!');
                        } elseif (!is_null($record->category_id)) {
                            $cancel = $this->pushError('Такое имя субдомена "' . $item->subdomain . '" уже используется для <a href="index.php?' . REQUEST_PARAM_NAME_SECTION . '=Category&' . REQUEST_PARAM_NAME_ITEMID . '=' . $record->category_id . '&' . REQUEST_PARAM_NAME_TOKEN . '=' . $this->cms->token . '">этой категории</a>!');
                        } elseif (!is_null($record->product_id)) {
                            $cancel = $this->pushError('Такое имя субдомена "' . $item->subdomain . '" уже используется для <a href="index.php?' . REQUEST_PARAM_NAME_SECTION . '=Product&' . REQUEST_PARAM_NAME_ITEMID . '=' . $record->product_id . '&' . REQUEST_PARAM_NAME_TOKEN . '=' . $this->cms->token . '">этого товара</a>!');
                        } elseif (!is_null($record->user_id)) {
                            $cancel = $this->pushError('Такое имя субдомена "' . $item->subdomain . '" уже используется для <a href="index.php?' . REQUEST_PARAM_NAME_SECTION . '=User&' . REQUEST_PARAM_NAME_USERID . '=' . $record->user_id . '&' . REQUEST_PARAM_NAME_TOKEN . '=' . $this->cms->token . '">этого пользователя</a>!');
                        } else {
                            $cancel = $this->pushError('Такое имя субдомена "' . $item->subdomain . '" уже используется для другой страницы сайта!');
                        }
                    }
                }
            }
        }

        // обработка изменения поля SUBDOMAIN_HTML записи ========================

        public function processSubdomainHtml ( & $item, $id, & $cancel ) {
            if (isset($_POST['subdomain_html'][$id])) {
                $item->subdomain_html = trim($_POST['subdomain_html'][$id]);
                if (strlen($item->subdomain_html) > 65535) $cancel = $this->pushError('Текст html-страницы собственного субдомена слишком большой. Он не может содержать более 65535 символов!');
            }
        }



        // ===================================================================
        /**
        *  Обработка изменения поля TEMPLATE записи
        *
        *  @access  protected
        *  @param   object  $item     объект изменяемой записи
        *  @param   integer $id       идентификатор записи
        *  @param   boolean $cancel   TRUE если изменение требуем признать ошибкой
        *  @return  void
        */
        // ===================================================================

        public function processTemplate ( & $item, $id, & $cancel ) {
            if (isset($_POST['template'][$id])) {
                $value = $this->hdd->safeFilename($_POST['template'][$id], FALSE);
                if ($value != '') {
                    $ext = strtolower(substr($value, -4));
                    if (($ext != '.tpl') && ($ext != '.htm')) {
                        $cancel = $this->pushError('Файл шаблона должен иметь расширение .htm или .tpl.');
                    }
                }
                $item->template = $value;
            }
        }



        // обработка изменения полей PRICE, FREE_FROM, DISCOUNT записи ===========

        public function processPrice ( & $item, $id, & $cancel ) {
            $rate = $this->currency->rate();

            // если задана цена
            if (isset($_POST['price'][$id])) {
                $value = round($this->number->floatValue($_POST['price'][$id]), 2);
                if ($value < 0) $value = 0;
                if ($value > 100000000) $value = 100000000;
                $value = round($value * $rate, 2);
                $item->price = $value;
            }

            // если задана сумма "бесплатно от"
            if (isset($_POST['free_from'][$id])) {
                $value = round($this->number->floatValue($_POST['free_from'][$id]), 2);
                if ($value < 0) $value = 0;
                if ($value > 100000000) $value = 100000000;
                $value = round($value * $rate, 2);
                $item->free_from = $value;
            }

            // если задана скидка
            if (isset($_POST['discount'][$id])) {
                $value = -1;
                if (trim($_POST['discount'][$id]) != '') {
                    $value = str_replace(',', '.', $_POST['discount'][$id]);
                    $value = str_replace('%', '', $value);
                    $value = round($this->number->floatValue($value), 2);
                    if ($value < 0) $value = -1;
                    if ($value > 100) $value = 100;
                }
                $item->discount = $value;
            }
        }


        // обработка изменения полей элементов заказа записи =====================

        public function processOrderItems ( & $item, $id, & $cancel ) {
            $rate = $this->currency->rate();
            $total = 0;

            // если задана цена доставки
            if (isset($_POST['delivery_price'][$id])) {
                $value = round($this->number->floatValue($_POST['delivery_price'][$id]), 2);
                if ($value < 0) $value = 0;
                if ($value > 100000000) $value = 100000000;
                $value = round($value * $rate, 2);
                $item->delivery_price = $value;
                $total += $value;
            }

            // если задана дополнительная скидка
            if (isset($_POST['discount_sum'][$id])) {
                $value = round($this->number->floatValue($_POST['discount_sum'][$id]), 2);
                if ($value < 0) $value = 0;
                if ($value > 100000000) $value = 100000000;
                $value = round($value * $rate, 2);
                $item->discount_sum = $value;
                $total -= $value;
            }

            // если есть данные о элементах заказа
            if (isset($_POST['orderitem_id'][$id]) && is_array($_POST['orderitem_id'][$id])) {
                if (!isset($item->products)) $item->products = array();
                $position = 0;
                foreach ($_POST['orderitem_id'][$id] as $index => $value) {
                    if (isset($_POST['orderitem_used'][$id][$index]) && ($_POST['orderitem_used'][$id][$index] == 1)) {
                        if (!isset($item->products[$index])) $item->products[$index] = null;

                        // идентификатор элемента
                        $value = intval($value);
                        if (!empty($value)) $item->products[$index]->orderitem_id = $value;

                        // идентификатор заказа
                        $item->products[$index]->order_id = $id;

                        // идентификаторы товара и варианта
                        if (isset($_POST['orderitem_product_id'][$id][$index])) $item->products[$index]->product_id = trim($_POST['orderitem_product_id'][$id][$index]);
                        if (isset($_POST['orderitem_variant_id'][$id][$index])) $item->products[$index]->variant_id = trim($_POST['orderitem_variant_id'][$id][$index]);

                        // названия товара, варианта, свойств товара
                        if (isset($_POST['orderitem_product_name'][$id][$index])) $item->products[$index]->product_name = trim($_POST['orderitem_product_name'][$id][$index]);
                        if (isset($_POST['orderitem_variant_name'][$id][$index])) $item->products[$index]->variant_name = trim($_POST['orderitem_variant_name'][$id][$index]);
                        if (isset($_POST['orderitem_name_properties'][$id][$index])) $item->products[$index]->name_properties = trim($_POST['orderitem_name_properties'][$id][$index]);

                        // количество
                        $quantity = 1;
                        if (isset($_POST['orderitem_quantity'][$id][$index])) {
                            $quantity = intval($_POST['orderitem_quantity'][$id][$index]);
                            if ($quantity < -10000) $quantity = -10000;
                            if ($quantity > 10000) $quantity = 10000;
                            if ($quantity == 0) $quantity = 1;
                            $item->products[$index]->quantity = $quantity;
                        }

                        // скидка
                        $discount = 0;
                        if (isset($_POST['orderitem_discount'][$id][$index])) {
                            $discount = str_replace(',', '.', $_POST['orderitem_discount'][$id][$index]);
                            $discount = str_replace('%', '', $discount);
                            $discount = round($this->number->floatValue($discount), 2);
                            if ($discount < 0) $discount = 0;
                            if ($discount > 100) $discount = 100;
                        }

                        // цена
                        if (isset($_POST['orderitem_price'][$id][$index])) {
                            $value = round($this->number->floatValue($_POST['orderitem_price'][$id][$index]), 2);
                            if ($value < 0) $value = 0;
                            if ($value > 100000000) $value = 100000000;
                            $value = round($value * $rate, 2);
                            $item->products[$index]->real_price = $value;
                            $discount = round($value * $discount / 100, 2);
                            $value -= $discount;
                            $item->products[$index]->price = $value;
                            if (!isset($item->discount_sum)) $item->discount_sum = 0;
                            $item->discount_sum += $discount * abs($quantity);
                            $total += $value * abs($quantity);
                        }

                        // позиция
                        if (isset($_POST['orderitem_position'][$id][$index])) {
                            $item->products[$index]->position = trim($_POST['orderitem_position'][$id][$index]);
                        } else {
                            $item->products[$index]->position = $position;
                        }
                        $position++;
                    }
                }
            }

            // если дополнительная скидка превышает полную сумму заказа
            if ($total < 0) {
                if (!isset($item->discount_sum)) $item->discount_sum = 0;
                $item->discount_sum += $total;
                if ($item->discount_sum < 0) $item->discount_sum = 0;
            }
        }

        // обработка изменения полей элементов комплекта товаров записи ==========

        public function processKitItems ( & $item, $id, & $cancel ) {

            // если есть данные о элементах комплекта
            if (isset($_POST['kititem_id'][$id]) && is_array($_POST['kititem_id'][$id])) {
                if (!isset($item->products)) $item->products = array();
                $position = 0;
                foreach ($_POST['kititem_id'][$id] as $index => $value) {
                    if (isset($_POST['kititem_used'][$id][$index]) && ($_POST['kititem_used'][$id][$index] == 1)) {
                        if (!isset($item->products[$index])) $item->products[$index] = null;

                        // идентификатор элемента
                        $value = intval($value);
                        if (!empty($value)) $item->products[$index]->kititem_id = $value;

                        // идентификатор комплекта
                        $item->products[$index]->kit_id = $id;

                        // идентификаторы товара и варианта
                        if (isset($_POST['kititem_product_id'][$id][$index])) $item->products[$index]->product_id = trim($_POST['kititem_product_id'][$id][$index]);
                        if (isset($_POST['kititem_variant_id'][$id][$index])) $item->products[$index]->variant_id = trim($_POST['kititem_variant_id'][$id][$index]);

                        // количество
                        if (isset($_POST['kititem_quantity'][$id][$index])) {
                            $quantity = abs(intval($_POST['kititem_quantity'][$id][$index]));
                            if ($quantity > 10000) $quantity = 10000;
                            if ($quantity == 0) $quantity = 1;
                            $item->products[$index]->quantity = $quantity;
                        }

                        // скидка
                        if (isset($_POST['kititem_discount'][$id][$index])) {
                            $discount = -1;
                            if (trim($_POST['kititem_discount'][$id][$index]) != '') {
                                $discount = str_replace(',', '.', $_POST['kititem_discount'][$id][$index]);
                                $discount = str_replace('%', '', $discount);
                                $discount = round($this->number->floatValue($discount), 2);
                                if ($discount < 0) $discount = -1;
                                if ($discount > 100) $discount = 100;
                            }
                            $item->products[$index]->discount = $discount;
                        }

                        // позиция
                        if (isset($_POST['kititem_position'][$id][$index])) {
                            $item->products[$index]->position = trim($_POST['kititem_position'][$id][$index]);
                        } else {
                            $item->products[$index]->position = $position;
                        }
                        $position++;
                    }
                }
            }
        }



        // обработка изменения полей вариантов товара записи =====================

        public function processVariants ( & $item, $id, & $cancel ) {
            $rate = $this->currency->rate();
            $currency_id = 0;

            // если есть данные о вариантах товара
            if (isset($_POST['variant_id'][$id]) && is_array($_POST['variant_id'][$id])) {
                if (!isset($item->variants)) $item->variants = array();
                $position = 0;
                foreach ($_POST['variant_id'][$id] as $index => $value) {
                    if (isset($_POST['variant_used'][$id][$index]) && $_POST['variant_used'][$id][$index]) {

                        if (!isset($item->variants[$index])) $item->variants[$index] = new stdClass;

                        // валюта товара (предположительно базовая)
                        $item->variants[$index]->currency_id = $currency_id;

                            // может указана другая?
                            $exists = isset($_POST['variant_currency_id'][$id][$index]);
                            if ($exists || !empty($currency_id)) {
                                $i = $exists ? $_POST['variant_currency_id'][$id][$index] : $currency_id;
                                if (!empty($i) && !empty($this->cms->currencies)) {
                                    foreach ($this->cms->currencies as & $c) {
                                        if ($c->currency_id == $i) {
                                            $item->variants[$index]->currency_id = $i;
                                            if (empty($currency_id)) $currency_id = $i;
                                            break;
                                        }
                                    }
                                }
                            }

                        // идентификатор варианта
                        $value = @ intval($value);
                        if (!empty($value)) $item->variants[$index]->variant_id = $value;

                        // идентификатор товара
                        $item->variants[$index]->product_id = $id;

                        // артикул
                        if (isset($_POST['variant_sku'][$id][$index])) $item->variants[$index]->sku = trim($_POST['variant_sku'][$id][$index]);

                        // название
                        if (isset($_POST['variant_name'][$id][$index])) $item->variants[$index]->name = trim($_POST['variant_name'][$id][$index]);

                        // цена
                        for ($i = 1; $i <= PRICE_TYPES_MAXCOUNT; $i++) {
                            $field = 'price' . (($i > 1) ? $i : '');
                            $field2 = 'previous_' . $field;
                            if (isset($_POST['variant_' . $field][$id][$index])) {
                                $value = $this->number->floatValue($_POST['variant_' . $field][$id][$index]) * $rate;
                                if ($value < 0) $value = 0;
                                $item->variants[$index]->$field = $value;
                            }
                            if (isset($_POST['previous_variant_' . $field][$id][$index])) {
                                $value = $this->number->floatValue($_POST['previous_variant_' . $field][$id][$index]) * $rate;
                                if ($value < 0) $value = 0;
                                $item->variants[$index]->$field2 = $value;
                            }
                        }

                        // акционная цена
                        $field = 'temp_price';
                        $field2 = 'previous_' . $field;
                        if (isset($_POST['variant_' . $field][$id][$index])) {
                            $value = $this->number->floatValue($_POST['variant_' . $field][$id][$index]) * $rate;
                            if ($value < 0) $value = 0;
                            $item->variants[$index]->$field = $value;
                        }
                        if (isset($_POST['previous_variant_' . $field][$id][$index])) {
                            $value = $this->number->floatValue($_POST['previous_variant_' . $field][$id][$index]) * $rate;
                            if ($value < 0) $value = 0;
                            $item->variants[$index]->$field2 = $value;
                        }
                        $field2 = $field . '_start';
                        if (isset($_POST['variant_' . $field2][$id][$index])) {
                            $value = $this->date->fixDate($_POST['variant_' . $field2][$id][$index]);
                            $item->variants[$index]->$field2 = $value;
                        }
                        $field2 = $field . '_date';
                        if (isset($_POST['variant_' . $field2][$id][$index])) {
                            $value = $this->date->fixDate($_POST['variant_' . $field2][$id][$index]);
                            $item->variants[$index]->$field2 = $value;
                        }
                        $field2 = $field . '_members';
                        if (isset($_POST['variant_' . $field2][$id][$index])) {
                            $value = @ intval($_POST['variant_' . $field2][$id][$index]);
                            if ($value < 0) $value = 0;
                            $item->variants[$index]->$field2 = $value;
                        }
                        $field2 = $field . '_invited';
                        if (isset($_POST['variant_' . $field2][$id][$index])) {
                            $value = @ intval($_POST['variant_' . $field2][$id][$index]);
                            if ($value < 0) $value = 0;
                            $item->variants[$index]->$field2 = $value;
                        }

                        // старая цена
                        if (isset($_POST['variant_old_price'][$id][$index])) {
                            $value = $this->number->floatValue($_POST['variant_old_price'][$id][$index]) * $rate;
                            if ($value < 0) $value = 0;
                            $item->variants[$index]->old_price = $value;
                        }

                        // приоритетная скидка
                        if (isset($_POST['variant_priority_discount'][$id][$index])) {
                            $value = str_replace('%', '', $_POST['variant_priority_discount'][$id][$index]);
                            $value = (trim($value) != '') ? $this->number->floatValue($value) : -1;
                            if ($value < 0) $value = -1;
                            if ($value > 100) $value = 100;
                            $item->variants[$index]->priority_discount = $value;
                        }

                        // количество на складе
                        if (isset($_POST['variant_stock'][$id][$index])) {
                            $value = @ intval($_POST['variant_stock'][$id][$index]);
                            if ($value >= 0) $item->variants[$index]->stock = $value;
                        }
                        if (isset($_POST['previous_variant_stock'][$id][$index])) {
                            $value = @ intval($_POST['previous_variant_stock'][$id][$index]);
                            if ($value >= 0) $item->variants[$index]->previous_stock = $value;
                        }

                        // позиция
                        if (isset($_POST['variant_position'][$id][$index])) {
                            $item->variants[$index]->position = trim($_POST['variant_position'][$id][$index]);
                        } else {
                            $item->variants[$index]->position = $position;
                        }
                        $position++;
                    }
                }

            // иначе нет данных о вариантах
            } else {

                // цена (устаревшее поле)
                if (isset($_POST['price'][$id]) && !is_array($_POST['price'][$id])) {
                    $value = $this->number->floatValue($_POST['price'][$id]) * $rate;
                    if ($value < 0) $value = 0;
                    $item->price = $value;
                }

                // временная цена (устаревшее поле)
                if (isset($_POST['temp_price'][$id]) && !is_array($_POST['temp_price'][$id])) {
                    $value = $this->number->floatValue($_POST['temp_price'][$id]) * $rate;
                    if ($value < 0) $value = 0;
                    $item->temp_price = $value;
                }

                // старая цена (устаревшее поле)
                if (isset($_POST['old_price'][$id]) && !is_array($_POST['old_price'][$id])) {
                    $value = $this->number->floatValue($_POST['old_price'][$id]) * $rate;
                    if ($value < 0) $value = 0;
                    $item->old_price = $value;
                }

                // приоритетная скидка (устаревшее поле)
                if (isset($_POST['priority_discount'][$id]) && !is_array($_POST['priority_discount'][$id])) {
                    $value = str_replace('%', '', $_POST['priority_discount'][$id]);
                    $value = (trim($value) != '') ? $this->number->floatValue($value) : -1;
                    if ($value < 0) $value = -1;
                    if ($value > 100) $value = 100;
                    $item->priority_discount = $value;
                }

                // количество на складе (устаревшее поле)
                if (isset($_POST['quantity'][$id])) {
                    $value = @ intval($_POST['quantity'][$id]);
                    if ($value >= 0) $item->quantity = $value;
                }
            }
        }



        // обработка изменения поля IN_PRICES записи =============================

        public function processInPrices ( & $item, $id, & $cancel ) {
            if (isset($_POST['in_prices'][$id])) {
                $item->in_prices = 0;
                // устанавливаем в 1 те же биты (младший бит справа), что и номера выбранных в html-форме прайс-листов
                foreach ($_POST['in_prices'][$id] as $bit) $item->in_prices = $item->in_prices | (1 << $bit);
            }
        }

        // обработка изменения поля URL, URL_SPECIAL записи ======================

        public function processUrl ( & $item, $id, & $cancel, $may_empty = FALSE ) {

            // если в посте пришли данные о url
            if (isset($_POST['url'][$id])) {
                $item->url = trim($_POST['url'][$id]);

                // выправляем url до вида относительной безоткатной адресации
                $item->url = str_replace('\\', '/', $item->url);
                while (strpos($item->url, '  ') !== FALSE) $item->url = str_replace('  ', ' ', $item->url);
                $item->url = str_replace(' /', '/', $item->url);
                $item->url = str_replace('/ ', '/', $item->url);
                $item->url = str_replace(' .', '.', $item->url);
                $item->url = str_replace('. ', '.', $item->url);
                while (strpos($item->url, './') !== FALSE) $item->url = str_replace('./', '/', $item->url);
                while (strpos($item->url, '/.') !== FALSE) $item->url = str_replace('/.', '/', $item->url);
                while (strpos($item->url, '//') !== FALSE) $item->url = str_replace('//', '/', $item->url);
                while (substr($item->url, 0, 1) == '/') $item->url = trim(substr($item->url, 1));
                while (substr($item->url, -1) == '/') $item->url = trim(substr($item->url, 0, -1));
                while (substr($item->url, 0, 1) == '.') $item->url = trim(substr($item->url, 1));
                while (substr($item->url, -1) == '.') $item->url = trim(substr($item->url, 0, -1));

                // пробелы меняем на подчеркивания
                $item->url = str_replace(' ', '_', $item->url);
                while (strpos($item->url, '__') !== FALSE) $item->url = str_replace('__', '_', $item->url);

                // если url пустой, но запрещен быть таким, и известен идентификатор записи, делаем url равным идентификатору
                if (($item->url == '') && !$may_empty && ($id != 0)) $item->url = $id;

                // проверяем валидность url
                if (($item->url != '')) {
                    if (!preg_match('![^0-9a-zа-я_\-\./]+!iu', $item->url)) {

                        // проверяем уникальность url
                        $query = 'SELECT `' . $this->getOwnerProperty('dbtable_field') . '` '
                               . 'FROM `' . $this->getOwnerProperty('dbtable') . '` '
                               . 'WHERE `url` = \'' . $this->cms->db->query_value($item->url) . '\' '
                                     . 'AND `' . $this->getOwnerProperty('dbtable_field') . '` != \'' . $this->cms->db->query_value($id) . '\';';
                        $this->cms->db->query($query);
                        $record = $this->cms->db->result();

                        // если не уникален, сообщаем об ошибке
                        if (!empty($record)) $cancel = $this->pushError('Запись с таким URL "' . $item->url . '" уже существует. Выберите другой URL.');

                    } else {
                        $cancel = $this->pushError('URL "' . $item->url . '" не может содержать иные символы, кроме английских и русских букв, цифр, точки, дефиса, подчеркивания и слеша. Исправьте URL.');
                    }
                }
            }

            // анализируем признак особости url
            $item->url_special = (isset($_POST['url_special'][$id]) && ($_POST['url_special'][$id] == 1)) ? 1 : 0;
        }

        // обработка изменения полей IMAGES, IMAGES_ALTS, IMAGES_TEXTS, IMAGES_VIEW записи ====

        public function processImages ( & $item, $id, & $cancel ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('BASIC processImages');

            // если есть, сначала считываем в массив существующие изображения в html-форме
            if (isset($_POST['image'][$id])) {
                $item->image = '';
                $item->images = array();
                $item->images_alts = array();
                $item->images_texts = array();
                $item->images_view = array();
                foreach ($_POST['image'][$id] as $index => & $image) {
                    $image = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $image));
                    if (!empty($image)) {
                        $item->images[] = $image;
                        $item->images_alts[] = isset($_POST['imagealt'][$id][$index]) ? trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $_POST['imagealt'][$id][$index])) : '';
                        $item->images_texts[] = isset($_POST['imagetext'][$id][$index]) ? trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $_POST['imagetext'][$id][$index])) : '';
                        $item->images_view[] = (isset($_POST['imageview'][$id][$index]) && ($_POST['imageview'][$id][$index] == 1)) ? 1 : 0;
                    }
                }
            }

            // теперь может быть пытались загрузить изображение с локального компьютера?
            $loaded = FALSE;
            $filename = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGEFILENAME)));
            $filename = str_replace('\\', '_', $filename);
            $filename = str_replace('/', '_', $filename);
            $filename = str_replace(':', '_', $filename);
            $filename = str_replace('.', '_', $filename);
            $token = trim($this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGETOKEN));

            if (isset($_FILES['new_image']['name'][$id]) && !empty($_FILES['new_image']['name'][$id]) && (!empty($_FILES['new_image']['tmp_name'][$id]) || isset($_FILES['new_image']['error'][$id]))) {

                // если существующих изображений в html-форме не было найдено, нужно создать пустой массив
                $item->image = '';
                if (!isset($item->images)) $item->images = array();
                if (!isset($item->images_alts)) $item->images_alts = array();
                if (!isset($item->images_texts)) $item->images_texts = array();
                if (!isset($item->images_view)) $item->images_view = array();

                // пробуем разобрать, что загрузили
                $url = trim($_FILES['new_image']['name'][$id]);
                if (preg_match('/^.+\.(jpg|jpeg|gif|png)$/i', $url)) {
                    if (!empty($_FILES['new_image']['tmp_name'][$id]) && (!isset($_FILES['new_image']['error'][$id]) || ($_FILES['new_image']['error'][$id] == UPLOAD_ERR_OK))) {

                        // даем файлу нового изображения специфичное имя
                        $info = pathinfo($url);
                        if (empty($token)) $token = date('YmdHi');
                        $url = !empty($id) ? $id : 'new' . rand(1, 100000000);
                        $url .= '_' . (count($item->images) + 1) . '_' . $token . '.' . $info['extension'];
                        switch ($this->getOwnerProperty('dbtable')) {
                            case 'articles':
                                $url = (!empty($filename) ? $filename . '_' : 'article_') . $url;
                                break;
                            case DATABASE_BRANDS_TABLENAME:
                                $url = (!empty($filename) ? $filename . '_' : 'brand_') . $url;
                                break;
                            case DATABASE_CATEGORIES_TABLENAME:
                                $url = (!empty($filename) ? $filename . '_' : 'category_') . $url;
                                break;
                            case 'countries':
                                $url = (!empty($filename) ? $filename . '_' : 'country_') . $url;
                                break;
                            case 'news':
                                $url = (!empty($filename) ? $filename . '_' : 'news_') . $url;
                                break;
                            case DATABASE_PRODUCTS_TABLENAME:
                                $url = (!empty($filename) ? $filename . '_' : 'product_') . $url;
                                break;
                            case 'regions':
                                $url = (!empty($filename) ? $filename . '_' : 'region_') . $url;
                                break;
                            case 'schools':
                                $url = (!empty($filename) ? $filename . '_' : 'school_') . $url;
                                break;
                            case 'sections':
                                $url = (!empty($filename) ? $filename . '_' : 'static_') . $url;
                                break;
                            case 'stocks':
                                $url = (!empty($filename) ? $filename . '_' : 'stock_') . $url;
                                break;
                            case 'towns':
                                $url = (!empty($filename) ? $filename . '_' : 'town_') . $url;
                                break;
                        }

                        // создаем папку для изображений, если ее нет (приказываем защитить папку файлом index.html)
                        $this->cms->smart_create_folder(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', ''), FOLDER_GUARD_MODE_VIA_INDEX);
                        // переносим в папку загруженное изображение
                        if (move_uploaded_file($_FILES['new_image']['tmp_name'][$id], ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url)) {
                            $loaded = TRUE;
                            // добавляем это изображение в массив к существующим
                            $item->images[] = $url;
                            $item->images_alts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGEALT)));
                            $item->images_texts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGETEXT)));
                            $item->images_view[] = ($this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGEVIEW) == 1) ? 1 : 0;
                            // отменяем рекомендуемую страницу возврата (чтобы остаться на странице редактирования)
                            $this->setOwnerProperty('result_page', '');

                        } else {
                            $cancel = $this->pushError('Не удалось загрузить файл изображения в "http://' . $this->cms->root_url . '/' . $this->getOwnerProperty('upload_folder', '') . $url . '".');
                        }

                    } else {
                        switch ($_FILES['new_image']['error'][$id]) {
                            case UPLOAD_ERR_INI_SIZE:
                                $cancel = $this->pushError('Размер принятого файла "' . $url . '" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.');
                                break;
                            case UPLOAD_ERR_FORM_SIZE:
                                $cancel = $this->pushError('Размер загружаемого файла "' . $url . '" превышает максимально допустимое значение' . (isset($_POST['MAX_FILE_SIZE']) ? ' ' . trim($_POST['MAX_FILE_SIZE']) . ' байт' : '') . '.');
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $cancel = $this->pushError('Загрузка файла "' . $url . '" прервалась и он был получен не весь.');
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $cancel = $this->pushError('Не получен файл "' . $url . '".');
                                break;
                            default:
                                $cancel = $this->pushError('Произошла неизвестная ошибка при попытке загрузить файл изображения "' . $url . '".');
                        }
                    }

                } else {
                    $cancel = $this->pushError('Файл изображения "' . $url . '" должен быть jpg, jpeg, gif или png файлом.');
                }

            } else {
                // может быть пытались загрузить изображение из удаленного источника?
                if (isset($_POST['new_image_url'][$id])) {

                    // если существующих изображений в html-форме не было найдено, нужно создать пустой массив
                    $item->image = '';
                    if (!isset($item->images)) $item->images = array();
                    if (!isset($item->images_alts)) $item->images_alts = array();
                    if (!isset($item->images_texts)) $item->images_texts = array();
                    if (!isset($item->images_view)) $item->images_view = array();

                    // пробуем разобрать, что хотели загрузить
                    $url = trim($_POST['new_image_url'][$id]);
                    if (preg_match('!^http://([^/]+/)+[^/]+\.(jpg|jpeg|gif|png)$!i', $url)) {
                        // пытаемся загрузить из удаленного источника
                        $content = file_get_contents($url);
                        if (!empty($content)) {

                            // даем файлу нового изображения специфичное имя
                            $info = pathinfo($url);
                            if (empty($token)) $token = date('YmdHi');
                            $url = !empty($id) ? $id : 'new' . rand(1, 100000000);
                            $url .= '_' . (count($item->images) + 1) . '_' . $token . '.' . $info['extension'];
                            switch ($this->getOwnerProperty('dbtable')) {
                                case 'articles':
                                    $url = (!empty($filename) ? $filename . '_' : 'article_') . $url;
                                    break;
                                case DATABASE_BRANDS_TABLENAME:
                                    $url = (!empty($filename) ? $filename . '_' : 'brand_') . $url;
                                    break;
                                case DATABASE_CATEGORIES_TABLENAME:
                                    $url = (!empty($filename) ? $filename . '_' : 'category_') . $url;
                                    break;
                                case 'countries':
                                    $url = (!empty($filename) ? $filename . '_' : 'country_') . $url;
                                    break;
                                case 'news':
                                    $url = (!empty($filename) ? $filename . '_' : 'news_') . $url;
                                    break;
                                case DATABASE_PRODUCTS_TABLENAME:
                                    $url = (!empty($filename) ? $filename . '_' : 'product_') . $url;
                                    break;
                                case 'regions':
                                    $url = (!empty($filename) ? $filename . '_' : 'region_') . $url;
                                    break;
                                case 'schools':
                                    $url = (!empty($filename) ? $filename . '_' : 'school_') . $url;
                                    break;
                                case 'sections':
                                    $url = (!empty($filename) ? $filename . '_' : 'static_') . $url;
                                    break;
                                case 'stocks':
                                    $url = (!empty($filename) ? $filename . '_' : 'stock_') . $url;
                                    break;
                                case 'towns':
                                    $url = (!empty($filename) ? $filename . '_' : 'town_') . $url;
                                    break;
                            }

                            // создаем папку для изображений, если ее нет (приказываем защитить папку файлом index.html)
                            $this->cms->smart_create_folder(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', ''), FOLDER_GUARD_MODE_VIA_INDEX);
                            // сохраняем в папку загруженное изображение
                            if (($file = fopen(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url, 'wb')) !== FALSE) {
                                fwrite($file, $content);
                                fclose($file);
                                $loaded = TRUE;
                                // добавляем это изображение в массив к существующим
                                $item->images[] = $url;
                                $item->images_alts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGEALT)));
                                $item->images_texts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGETEXT)));
                                $item->images_view[] = ($this->cms->param(ACTION_REQUEST_PARAM_NAME_IMAGEVIEW) == 1) ? 1 : 0;
                                // отменяем рекомендуемую страницу возврата (чтобы остаться на странице редактирования)
                                $this->setOwnerProperty('result_page', '');

                            } else {
                                $cancel = $this->pushError('Не удалось записать файл изображения в "http://' . $this->cms->root_url . '/' . $this->getOwnerProperty('upload_folder', '') . $url . '".');
                            }

                        } else {
                            $cancel = $this->pushError('Не удалось загрузить изображение из удаленного источника "' . $url . '".');
                        }

                    } else {
                        if (!empty($url) && (strtolower($url) != 'http://')) {
                            $cancel = $this->pushError('Адрес изображения из удаленного источника "' . $url . '" не соответствует формату "http://домен/[путь/]файл.{jpg|jpeg|gif|png}" (необязательные части взяты в квадратные скобки, варианты - в фигурные).');
                        }
                    }
                }
            }

            // теперь массив существующих изображений есть, его нужно вернуть в текстовый вид (для записи в базу данных)
            if (isset($item->images)) {
                switch ($this->getOwnerProperty('dbtable')) {
                    case 'articles':
                        $this->cms->db->unfix_articles_record_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('articles_images_width'),
                                                          $this->settings->get('articles_images_height'),
                                                          $this->settings->get('articles_thumbnail_width'),
                                                          $this->settings->get('articles_thumbnail_height'),
                                                          $this->settings->get('articles_images_exactly'),
                                                          $this->settings->get('articles_images_quality'),
                                                          ($this->settings->get('articles_watermark_enabled') ? $this->settings->get('articles_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . ARTICLES_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('articles_watermark_location'),
                                                          $this->settings->get('articles_watermark_transparency'));
                        }
                        break;
                    case 'brands':
                        $this->cms->db->unfix_brands_record_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('brands_images_width'),
                                                          $this->settings->get('brands_images_height'),
                                                          $this->settings->get('brands_thumbnail_width'),
                                                          $this->settings->get('brands_thumbnail_height'),
                                                          $this->settings->get('brands_images_exactly'),
                                                          $this->settings->get('brands_images_quality'),
                                                          ($this->settings->get('brands_watermark_enabled') ? $this->settings->get('brands_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . BRANDS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('brands_watermark_location'),
                                                          $this->settings->get('brands_watermark_transparency'));
                        }
                        break;
                    case 'categories':
                        $this->cms->db->unfix_categories_record_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('categories_images_width'),
                                                          $this->settings->get('categories_images_height'),
                                                          $this->settings->get('categories_thumbnail_width'),
                                                          $this->settings->get('categories_thumbnail_height'),
                                                          $this->settings->get('categories_images_exactly'),
                                                          $this->settings->get('categories_images_quality'),
                                                          ($this->settings->get('categories_watermark_enabled') ? $this->settings->get('categories_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . CATEGORIES_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('categories_watermark_location'),
                                                          $this->settings->get('categories_watermark_transparency'));
                        }
                        break;
                    case 'countries':
                        $this->cms->db->countries->packImages($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('countries_images_width'),
                                                          $this->settings->get('countries_images_height'),
                                                          $this->settings->get('countries_thumbnail_width'),
                                                          $this->settings->get('countries_thumbnail_height'),
                                                          $this->settings->get('countries_images_exactly'),
                                                          $this->settings->get('countries_images_quality'),
                                                          ($this->settings->get('countries_watermark_enabled') ? $this->settings->get('countries_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . COUNTRIES_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('countries_watermark_location'),
                                                          $this->settings->get('countries_watermark_transparency'));
                        }
                        break;
                    case 'news':
                        $this->cms->db->news->packImages($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('news_images_width'),
                                                          $this->settings->get('news_images_height'),
                                                          $this->settings->get('news_thumbnail_width'),
                                                          $this->settings->get('news_thumbnail_height'),
                                                          $this->settings->get('news_images_exactly'),
                                                          $this->settings->get('news_images_quality'),
                                                          ($this->settings->get('news_watermark_enabled') ? $this->settings->get('news_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . NEWS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('news_watermark_location'),
                                                          $this->settings->get('news_watermark_transparency'));
                        }
                        break;
                    case 'products':
                        $this->cms->db->products->pack_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('products_images_width'),
                                                          $this->settings->get('products_images_height'),
                                                          $this->settings->get('products_thumbnail_width'),
                                                          $this->settings->get('products_thumbnail_height'),
                                                          $this->settings->get('products_images_exactly'),
                                                          $this->settings->get('products_images_quality'),
                                                          ($this->settings->get('products_watermark_enabled') ? $this->settings->get('products_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . PRODUCTS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('products_watermark_location'),
                                                          $this->settings->get('products_watermark_transparency'));
                        }
                        break;
                    case 'regions':
                        $this->cms->db->unfix_regions_record_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('regions_images_width'),
                                                          $this->settings->get('regions_images_height'),
                                                          $this->settings->get('regions_thumbnail_width'),
                                                          $this->settings->get('regions_thumbnail_height'),
                                                          $this->settings->get('regions_images_exactly'),
                                                          $this->settings->get('regions_images_quality'),
                                                          ($this->settings->get('regions_watermark_enabled') ? $this->settings->get('regions_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . REGIONS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('regions_watermark_location'),
                                                          $this->settings->get('regions_watermark_transparency'));
                        }
                        break;
                    case 'schools':
                        $this->cms->db->unfix_schools_record_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('schools_images_width'),
                                                          $this->settings->get('schools_images_height'),
                                                          $this->settings->get('schools_thumbnail_width'),
                                                          $this->settings->get('schools_thumbnail_height'),
                                                          $this->settings->get('schools_images_exactly'),
                                                          $this->settings->get('schools_images_quality'),
                                                          ($this->settings->get('schools_watermark_enabled') ? $this->settings->get('schools_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . SCHOOLS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('schools_watermark_location'),
                                                          $this->settings->get('schools_watermark_transparency'));
                        }
                        break;
                    case 'sections':
                        $this->cms->db->sections->packImages($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('sections_images_width'),
                                                          $this->settings->get('sections_images_height'),
                                                          $this->settings->get('sections_thumbnail_width'),
                                                          $this->settings->get('sections_thumbnail_height'),
                                                          $this->settings->get('sections_images_exactly'),
                                                          $this->settings->get('sections_images_quality'),
                                                          ($this->settings->get('sections_watermark_enabled') ? $this->settings->get('sections_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . SECTIONS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('sections_watermark_location'),
                                                          $this->settings->get('sections_watermark_transparency'));
                        }
                        break;
                    case 'stocks':
                        $this->cms->db->stocks->packImages($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('stocks_images_width'),
                                                          $this->settings->get('stocks_images_height'),
                                                          $this->settings->get('stocks_thumbnail_width'),
                                                          $this->settings->get('stocks_thumbnail_height'),
                                                          $this->settings->get('stocks_images_exactly'),
                                                          $this->settings->get('stocks_images_quality'),
                                                          ($this->settings->get('stocks_watermark_enabled') ? $this->settings->get('stocks_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . STOCKS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('stocks_watermark_location'),
                                                          $this->settings->get('stocks_watermark_transparency'));
                        }
                        break;
                    case 'towns':
                        $this->cms->db->unfix_towns_record_images($item);
                        if ($loaded) {
                            // накладываем на изображение водяной знак и делаем миниатюру
                            $this->cms->db->process_image(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url,
                                                          $this->settings->get('towns_images_width'),
                                                          $this->settings->get('towns_images_height'),
                                                          $this->settings->get('towns_thumbnail_width'),
                                                          $this->settings->get('towns_thumbnail_height'),
                                                          $this->settings->get('towns_images_exactly'),
                                                          $this->settings->get('towns_images_quality'),
                                                          ($this->settings->get('towns_watermark_enabled') ? $this->settings->get('towns_files_folder_prefix') . ADMIN_IMAGES_FOLDER_REFERENCE . TOWNS_CLASS_WATERMARK_FILENAME : ''),
                                                          $this->settings->get('towns_watermark_location'),
                                                          $this->settings->get('towns_watermark_transparency'));
                        }
                        break;
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }

        // обработка изменения полей FILES, FILES_ALTS, FILES_TEXTS записи =======

        public function processFiles ( & $item, $id, & $cancel ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('BASIC processFiles');

            // если есть, сначала считываем в массив существующие файлы в html-форме
            if (isset($_POST['file'][$id])) {
                $item->files = array();
                $item->files_alts = array();
                $item->files_texts = array();
                foreach ($_POST['file'][$id] as $index => & $file) {
                    $file = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $file));
                    if (!empty($file)) {
                        $item->files[] = $file;
                        $item->files_alts[] = isset($_POST['filealt'][$id][$index]) ? trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $_POST['filealt'][$id][$index])) : '';
                        $item->files_texts[] = isset($_POST['filetext'][$id][$index]) ? trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $_POST['filetext'][$id][$index])) : '';
                    }
                }
            }

            // теперь может быть пытались загрузить файл с локального компьютера?
            $loaded = FALSE;
            $filename = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_FILEFILENAME)));
            $filename = str_replace('\\', '_', $filename);
            $filename = str_replace('/', '_', $filename);
            $filename = str_replace(':', '_', $filename);
            $filename = str_replace('.', '_', $filename);
            $token = trim($this->cms->param(ACTION_REQUEST_PARAM_NAME_FILETOKEN));

            if (isset($_FILES['new_file']['name'][$id]) && !empty($_FILES['new_file']['name'][$id]) && (!empty($_FILES['new_file']['tmp_name'][$id]) || isset($_FILES['new_file']['error'][$id]))) {

                // если существующих файлов в html-форме не было найдено, нужно создать пустой массив
                if (!isset($item->files)) $item->files = array();
                if (!isset($item->files_alts)) $item->files_alts = array();
                if (!isset($item->files_texts)) $item->files_texts = array();

                // пробуем разобрать, что загрузили
                $url = trim($_FILES['new_file']['name'][$id]);
                if (preg_match("'^.+\.(" . ADMIN_FILES_CLASS_EXTENSION_LIST . ")$'i", $url)) {
                    if (!empty($_FILES['new_file']['tmp_name'][$id]) && (!isset($_FILES['new_file']['error'][$id]) || ($_FILES['new_file']['error'][$id] == UPLOAD_ERR_OK))) {

                        // даем новому файлу специфичное имя
                        $info = pathinfo($url);
                        if (empty($token)) $token = date('YmdHi');
                        $url = $id . '_' . (count($item->files) + 1) . '_' . $token . '.' . $info['extension'];
                        switch ($this->getOwnerProperty('dbtable')) {
                            case 'files':
                                $url = (!empty($filename) ? $filename . '_' : 'media_') . $url;
                                break;
                            case DATABASE_PRODUCTS_TABLENAME:
                                $url = (!empty($filename) ? $filename . '_' : 'product_') . $url;
                                break;
                        }

                        // создаем папку для файлов, если ее нет (приказываем защитить папку файлом index.html)
                        $this->cms->smart_create_folder(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', ''), FOLDER_GUARD_MODE_VIA_INDEX);
                        // переносим в папку загруженный файл
                        if (move_uploaded_file($_FILES['new_file']['tmp_name'][$id], ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url . ADMIN_FILES_CLASS_SAFE_EXTENSION)) {
                            $loaded = TRUE;
                            // добавляем этот файл в массив к существующим
                            $item->files[] = $url;
                            $item->files_alts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_FILEALT)));
                            $item->files_texts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_FILETEXT)));
                            // отменяем рекомендуемую страницу возврата (чтобы остаться на странице редактирования)
                            $this->setOwnerProperty('result_page', '');

                        } else {
                            $cancel = $this->pushError('Не удалось загрузить файл в "http://' . $this->cms->root_url . '/' . $this->getOwnerProperty('upload_folder', '') . $url . '".');
                        }

                    } else {
                        switch ($_FILES['new_file']['error'][$id]) {
                            case UPLOAD_ERR_INI_SIZE:
                                $cancel = $this->pushError('Размер принятого файла "' . $url . '" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.');
                                break;
                            case UPLOAD_ERR_FORM_SIZE:
                                $cancel = $this->pushError('Размер загружаемого файла "' . $url . '" превышает максимально допустимое значение' . (isset($_POST['MAX_FILE_SIZE']) ? ' ' . trim($_POST['MAX_FILE_SIZE']) . ' байт' : '') . '.');
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $cancel = $this->pushError('Загрузка файла "' . $url . '" прервалась и он был получен не весь.');
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $cancel = $this->pushError('Не получен файл "' . $url . '".');
                                break;
                            default:
                                $cancel = $this->pushError('Произошла неизвестная ошибка при попытке загрузить файл "' . $url . '".');
                        }
                    }

                } else {
                    $cancel = $this->pushError('Файл "' . $url . '" должен быть файлом с типичным расширением из перечисленных: ' . str_replace('|', ', ', ADMIN_FILES_CLASS_EXTENSION_LIST) . '.');
                }

            } else {
                // может быть пытались загрузить файл из удаленного источника?
                if (isset($_POST['new_file_url'][$id])) {

                    // если существующих файлов в html-форме не было найдено, нужно создать пустой массив
                    if (!isset($item->files)) $item->files = array();
                    if (!isset($item->files_alts)) $item->files_alts = array();
                    if (!isset($item->files_texts)) $item->files_texts = array();

                    // пробуем разобрать, что хотели загрузить
                    $url = trim($_POST['new_file_url'][$id]);
                    if (preg_match("'^http://([^/]+/)+[^/]+\.(" . ADMIN_FILES_CLASS_EXTENSION_LIST . ")$'i", $url)) {
                        // пытаемся загрузить из удаленного источника
                        $content = file_get_contents($url);
                        if (!empty($content)) {

                            // даем новому файлу специфичное имя
                            $info = pathinfo($url);
                            if (empty($token)) $token = date('YmdHi');
                            $url = $id . '_' . (count($item->files) + 1) . '_' . $token . '.' . $info['extension'];
                            switch ($this->getOwnerProperty('dbtable')) {
                                case 'files':
                                    $url = (!empty($filename) ? $filename . '_' : 'media_') . $url;
                                    break;
                                case DATABASE_PRODUCTS_TABLENAME:
                                    $url = (!empty($filename) ? $filename . '_' : 'product_') . $url;
                                    break;
                            }

                            // создаем папку для файлов, если ее нет (приказываем защитить папку файлом index.html)
                            $this->cms->smart_create_folder(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', ''), FOLDER_GUARD_MODE_VIA_INDEX);
                            // сохраняем в папку загруженный файл
                            if (($file = fopen(ROOT_FOLDER_REFERENCE . $this->getOwnerProperty('upload_folder', '') . $url . ADMIN_FILES_CLASS_SAFE_EXTENSION, 'wb')) !== FALSE) {
                                fwrite($file, $content);
                                fclose($file);
                                $loaded = TRUE;
                                // добавляем этот файл в массив к существующим
                                $item->files[] = $url;
                                $item->files_alts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_FILEALT)));
                                $item->files_texts[] = trim(str_replace(IN_ONE_TEXT_LINE_RECORDS_FIELDS_DELIMITER, '', $this->cms->param(ACTION_REQUEST_PARAM_NAME_FILETEXT)));
                                // отменяем рекомендуемую страницу возврата (чтобы остаться на странице редактирования)
                                $this->setOwnerProperty('result_page', '');

                            } else {
                                $cancel = $this->pushError('Не удалось записать файл в "http://' . $this->cms->root_url . '/' . $this->getOwnerProperty('upload_folder', '') . $url . '".');
                            }

                        } else {
                            $cancel = $this->pushError('Не удалось загрузить файл из удаленного источника "' . $url . '".');
                        }

                    } else {
                        if (!empty($url) && (strtolower($url) != 'http://')) {
                            $cancel = $this->pushError('Адрес файла из удаленного источника "' . $url . '" не соответствует формату "http://домен/[путь/]файл.расширение" (необязательные части взяты в квадратные скобки) с типичным расширением из перечисленных: ' . str_replace('|', ', ', ADMIN_FILES_CLASS_EXTENSION_LIST) . '.');
                        }
                    }
                }
            }

            // теперь массив существующих файлов есть, его нужно вернуть в текстовый вид (для записи в базу данных)
            if (isset($item->files)) {
                switch ($this->getOwnerProperty('dbtable')) {
                    case 'files':
                        $this->cms->db->unfix_files_record_files($item);
                        break;
                    case DATABASE_PRODUCTS_TABLENAME:
                        $this->cms->db->products->pack_files($item);
                        break;
                }
            }

            // закрываем трассировку этого метода
            $this->cms->db->close_tracing_method();
        }

        // обработка загрузки файла водяного знака ===============================

        public function processWatermark ( $folder, $filename ) {

            // открываем трассировку этого метода
            $this->cms->db->open_tracing_method('BASIC processWatermark');

            if (isset($_FILES['watermark_filename']['name']) && !empty($_FILES['watermark_filename']['name']) && (!empty($_FILES['watermark_filename']['tmp_name']) || isset($_FILES['watermark_filename']['error']))) {
                // пробуем разобрать, что загрузили
                $url = trim($_FILES['watermark_filename']['name']);
                if (preg_match('/^.+\.png$/i', $url)) {
                    if (!empty($_FILES['watermark_filename']['tmp_name']) && (!isset($_FILES['watermark_filename']['error']) || ($_FILES['watermark_filename']['error'] == UPLOAD_ERR_OK))) {
                        // создаем папку для изображений, если ее нет (приказываем защитить папку файлом index.html)
                        $this->cms->smart_create_folder($folder, FOLDER_GUARD_MODE_VIA_INDEX);
                        // переносим в папку загруженное изображение
                        if (!move_uploaded_file($_FILES['watermark_filename']['tmp_name'], $folder . $filename)) {
                            $this->pushError('Не удалось загрузить файл изображения водяного знака в "http://' . $this->cms->root_url . '/' . $this->hdd->safeFilename($this->cms->admin_folder) . '/' . $folder . $filename . '".');
                        }
                    } else {
                        switch ($_FILES['watermark_filename']['error']) {
                            case UPLOAD_ERR_INI_SIZE:
                                $this->pushError('Размер принятого файла "' . $url . '" превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini.');
                                break;
                            case UPLOAD_ERR_FORM_SIZE:
                                $this->pushError('Размер загружаемого файла "' . $url . '" превышает максимально допустимое значение' . (isset($_POST['MAX_FILE_SIZE']) ? ' ' . trim($_POST['MAX_FILE_SIZE']) . ' байт' : '') . '.');
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $this->pushError('Загрузка файла "' . $url . '" прервалась и он был получен не весь.');
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $this->pushError('Не получен файл "' . $url . '".');
                                break;
                            default:
                                $this->pushError('Произошла неизвестная ошибка при попытке загрузить файл изображения водяного знака "' . $url . '".');
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