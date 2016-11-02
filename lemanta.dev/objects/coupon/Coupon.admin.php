<?php
    // =======================================================================
    /**
    *  Админ модуль редактирования купона
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

    // подключаем класс купонов
    impera_ClassRequire('Coupons', TRUE);

    // текст заголовка страницы модуля
    define('COUPON_PAGE_TITLE', 'Новый купон');
    define('COUPON_PAGE_TITLE2', 'Редактирование купона ');

    // имя файла шаблона модуля и сообщение о его недоступности
    define('COUPON_TEMPLATE_FILENAME', 'coupons/coupon.htm');
    define('COUPON_NOTEMPLATE_MSG', 'К сожалению, в папке текущего шаблона админпанели нет файла '
                                   . COUPON_TEMPLATE_FILENAME . ', который отвечает за внешний вид данной страницы.');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('COUPON_MODULELINK_POINTER', 'Coupon');
    define('COUPON_MODULETAB_TEXT', 'карточка');
    define('COUPON_MODULEMENU_PATH', '');



    // =======================================================================
    /**
    *  Админ модуль редактирования купона
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Coupon extends Coupons {

        // рекомендуемая страница возврата после операции
        public $result_page = ADMIN_PRODUCT_CLASS_RESULT_PAGE;



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

            // конструируем объект
            parent::__construct($parent);

            // рекомендуемой страницей возврата после операции считаем страницу списка записей
            // (то есть после редактирования записи предполагаем возвращаться в список)
            $this->result_page = $this->site_url
                               . $this->hdd->safeFilename($this->admin_folder)
                               . '/index.php?' . REQUEST_PARAM_NAME_SECTION . '=' . COUPONS_MODULELINK_POINTER;
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
            $this->title = ADMIN_PAGE_TITLE_PREFIX . COUPON_PAGE_TITLE;

            // готовимся рисовать контент модуля
            $template = COUPON_TEMPLATE_FILENAME;
            $this->body = '<div class="error">'
                             . COUPON_NOTEMPLATE_MSG
                        . '</div>';

            // если такого файла шаблона нет, прекращаем обработку
            $path = ROOT_FOLDER_REFERENCE
                  . $this->hdd->safeFilename($this->admin_folder)
                  . '/design/'
                  . $this->hdd->safeFilename($this->settings->admin_theme)
                  . '/html/';
            if (!is_readable($path . $template) || !is_file($path . $template)) return FALSE;

            // если в запросе есть параметр FROM (страница возврата из операции),
            // запоминаем его, передаем в шаблонизатор и убираем из запроса
            $result_page = trim($this->param(REQUEST_PARAM_NAME_FROM));
            if ($result_page != '') {
                $this->result_page = $result_page;
                $this->destroy_param(REQUEST_PARAM_NAME_FROM);
                $this->smarty->assignByRef(SMARTY_VAR_FROM_PAGE, $result_page);
            }

            // обрабатываем редактирование настроек модуля
            $this->process_setup();

            // обрабатываем входные команды
            $this->process();

            // читаем входной параметр ITEMID - идентификатор оперируемой записи
            $id = trim($this->param(REQUEST_PARAM_NAME_ITEMID));

            // если нет данных записи или они изменились, читаем их из базы данных
            if ((empty($this->item) || $this->changed) && !empty($id)) {
                $params = new stdClass;
                $params->id = $id;
                $this->db->coupons->one($this->item, $params);
            }

            // если данные записи получены
            if (!empty($this->item)) {

                //   меняем заголовок страницы
                $this->title = ADMIN_PAGE_TITLE_PREFIX . COUPON_PAGE_TITLE2 . '"' . (isset($this->item->code) ? trim($this->item->code) : '') . '"';

                // если данные получены не из базы данных, распаковываем поля записи
                if ((!$this->changed || empty($id)) && !isset($params->id)) $this->db->coupons->unpack($this->item);

                // если это команда "Создать копию", деидентифицируем запись
                if (trim($this->param(REQUEST_PARAM_NAME_ACTION)) == ACTION_REQUEST_PARAM_VALUE_COPY) {
                    $field = $this->dbtable_field;
                    $this->item->$field = 0;
                    $this->item->name = '[Копия] ' . $this->item->name;
                }

            // иначе данных записи нет (новая)
            } else {

                // инициируем важные поля новой записи:
                $this->item = new stdClass;
                // имя
                $this->item->name = $this->param(REQUEST_PARAM_NAME_NAME);
                // контрольный код
                $this->item->code = $this->generate_code();
                // номер печатной формы
                $this->item->printer = 1;
                // остаток разов использования
                $this->item->count = 1;
                // ИД назначаемой группы скидок
                $this->item->group_id = $this->param(REQUEST_PARAM_NAME_GROUP_ID);
                // ИД назначаемой ценовой группы
                $this->item->group_id = $this->param(REQUEST_PARAM_NAME_PRICE_ID);
                // ИД назначаемого партнера
                $this->item->affiliate_id = $this->param(REQUEST_PARAM_NAME_AFFILIATE_ID);
                // разрешен
                $this->item->enabled = 1;
                // не удален
                $this->item->deleted = 0;
                // срок действия (в секундах)
                $this->item->lifetime = 3600 * 24 * 90;
            }

            $where = '`' . $this->dbtable . '`.`deleted` = 0';

            // читаем список ИДов задействованных пользователей
            $user_ids = $this->db->coupons->getIds('user_id', $where);

            // читаем список ИДов задействованных партнеров
            $affiliate_ids = $this->db->coupons->getIds('affiliate_id', $where);

            // читаем список ИДов задействованных групп скидок
            $group_ids = $this->db->coupons->getIds('group_id', $where);

            // читаем список групп скидок
            $this->db->get_groups_array($groups, GET_GROUPS_MODE_FOR_AUTHORIZED);

            // читаем список ИДов задействованных ценовых групп
            $price_ids = $this->db->coupons->getIds('price_id', $where);

            // читаем список ИДов задействованных печатных форм
            $printer_ids = $this->db->coupons->getIds('printer', $where);

            // передаем нужные данные в шаблонизатор
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $this->item);
            $this->smarty->assignByRef('user_ids', $user_ids);
            $this->smarty->assignByRef('affiliate_ids', $affiliate_ids);
            $this->smarty->assignByRef('groups', $groups);
            $this->smarty->assignByRef('group_ids', $group_ids);
            $this->smarty->assignByRef('price_ids', $price_ids);
            $this->smarty->assignByRef('printer_ids', $printer_ids);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->info_msg);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);

            // отрисовываем контент модуля
            $this->body = $this->smarty->fetch($template);

            return TRUE;
        }
    }



    return;
?>