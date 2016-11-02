<?php
    // =======================================================================
    /**
    *  Макет модели базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class BasicDBModel {

        // объект движка
        public $cms = null;

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'undefined';
        public $id_field = 'undefined_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                // пример поля
                'undefined' => array('type' => 'VARCHAR(16)',
                                     'params' => 'DEFAULT "" NOT NULL COMMENT "Комментарий"',
                                     'index' => TRUE,
                                     'fix' => FALSE,
                                     'handler' => 'packedUndefined')
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'Undefineds';
        protected $operables_card = 'Undefined';
        protected $operables = array();



        // ===================================================================
        /**
        *  Конструктор класса
        *
        *  @access  public
        *  @param   object  $cms        объект вышестоящего движка
        *  @param   object  $owner      объект владельца модуля
        *  @param   string  $gender     родовое имя (класс главенствующего модуля)
        *  @return  void
        */
        // ===================================================================

        public function __construct ( & $cms, & $owner = null, $gender = '' ) {

            // запоминаем выход на объект движка
            $this->cms = & $cms;
        }



        // ===================================================================
        /**
        *  Получение значения string/array свойства (основное и зависимые)
        *
        *  @access  protected
        *  @param   string  $name   имя свойства
        *  @param   mixed   $slave  FALSE если основное значение (по умолчанию FALSE)
        *                           TRUE если первое зависимое значение
        *                           ЧИСЛО если такое по счету значение
        *  @param   mixed   $def    значение по умолчанию
        *  @return  string          значение
        */
        // ===================================================================

        protected function getSAProperty ( $name, $slave = FALSE, $def = '' ) {
            if (isset($this->$name)) {
                if ($slave === FALSE) $slave = 1;
                if (is_string($this->$name)) {
                    if ($slave === 1) return $this->$name;
                } elseif (is_array($this->$name) && !empty($this->$name)) {
                    if ($slave === TRUE) $slave = 2;
                    $slave = intval($slave) - 1;
                    $name = & $this->$name;
                    if (isset($name[$slave])) return $name[$slave];
                }
            }
            return $def;
        }



        // ===================================================================
        /**
        *  Получение имени таблицы базы данных
        *
        *  @access  public
        *  @param   mixed   $slave  FALSE если имя основной таблицы (по умолчанию FALSE)
        *                           TRUE если имя первой зависимой таблицы
        *                           ЧИСЛО если имя такой по счету таблицы
        *  @return  string          имя таблицы
        */
        // ===================================================================

        public function getDBTable ( $slave = FALSE ) {
            $name = $this->getSAProperty('dbtable', $slave);
            $name = trim($name);
            return $name == '' ? 'undefined' : $name;
        }



        // ===================================================================
        /**
        *  Получение имени колонки ИДЕНТИФИКАТОР ЗАПИСИ основной таблицы
        *
        *  @access  public
        *  @param   mixed   $slave  FALSE если имя колонки основной таблицы (по умолчанию FALSE)
        *                           TRUE если имя колонки первой зависимой таблицы
        *                           ЧИСЛО если имя колонки такой по счету таблицы
        *  @return  string          имя колонки
        */
        // ===================================================================

        public function getIDField ( $slave = FALSE ) {
            $name = $this->getSAProperty('id_field', $slave);
            $name = trim($name);
            return $name == '' ? 'undefined_id' : $name;
        }



        // ===================================================================
        /**
        *  Признак что в объекте существует непустой список полей
        *
        *  @access  public
        *  @param   mixed   $slave  FALSE если для основной таблицы (по умолчанию FALSE)
        *                           TRUE если для первой зависимой таблицы
        *                           ЧИСЛО если для такой по счету таблицы
        *  @param   object  $who    проверяемый объект (по умолчанию текущая модель)
        *  @return  boolean         TRUE если список существует
        */
        // ===================================================================

        public function hasFields ( $slave = FALSE, & $who = null ) {
            if (is_null($who)) $who = $this;
            if ($slave === FALSE) $slave = 1;
            if ($slave === TRUE) $slave = 2;
            $slave = intval($slave) - 1;
            return isset($who->fields) && is_array($who->fields)
                && isset($who->fields[$slave]) && is_array($who->fields[$slave])
                && !empty($who->fields[$slave]);
        }



        // ===================================================================
        /**
        *  Опознание краткой записи поля и конвертация в стандартную запись
        *
        *  @access  protected
        *  @param   string  $field  имя поля (будет обновлено в этой переменной)
        *  @param   array   $info   массив сведений (будет обновлен в этой переменной)
        *  @return  void
        */
        // ===================================================================

        protected function recognizeFieldJotting ( & $field, & $info ) {
            if (!is_int($field) || !is_string($info)) return;
            $name = trim($info);
            if ($name == '') return;
            $def = array(
                // название
                'name'              => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Название"'),
                // название
                'header'            => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Название (заголовок)"'),
                // url
                'url'               => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Адрес страницы"',
                                             'fix' => TRUE),
                // особый url
                'url_special'       => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Особый адрес"',
                                             'index' => FALSE),
                // теги
                'tags'              => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Теги записи"'),
                // мета заголовок
                'meta_title'        => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Мета заголовок"',
                                             'index' => FALSE),
                // мета ключевые слова
                'meta_keywords'     => array('type' => 'VARCHAR(512)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Мета ключевые слова"',
                                             'index' => FALSE),
                // мета описание
                'meta_description'  => array('type' => 'VARCHAR(512)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Мета описание"',
                                             'index' => FALSE),
                // аннотация
                'annotation'        => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Краткое описание"',
                                             'index' => FALSE),
                // краткое описание
                'description'       => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Краткое описание"',
                                             'index' => FALSE),
                // описание
                'body'              => array('type' => 'LONGTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Полное описание"',
                                             'index' => FALSE),
                // seo текст
                'seo_description'   => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "SEO текст"',
                                             'index' => FALSE),
                // департамент
                'department'        => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Департамент"'),
                // тема
                'subject'           => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Тема"'),
                // сообщение
                'message'           => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Сообщение"',
                                             'index' => FALSE),
                // новое
                'new'               => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Непрочитано"'),
                // выполнено
                'done'              => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Выполнено"'),
                // от пользователя
                'from_user'         => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор отправляющего пользователя"'),
                // для пользователя
                'to_user'           => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор получающего пользователя"'),
                // просмотры
                'browsed'           => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Число просмотров"'),
                // рейтинг
                'rating'            => array('type' => 'FLOAT(12,2)',
                                             'params' => 'DEFAULT 0.0 NOT NULL COMMENT "Рейтинг"'),
                // количество голосов
                'votes'             => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Количество голосов в рейтинге"'),
                // вес
                'order_num'         => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Позиция (вес) в списке"',
                                             'fix' => TRUE),
                // позиция
                'position'          => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Позиция (номер) в списке"',
                                             'fix' => TRUE),
                // плагины
                'objects'           => array('type' => 'VARCHAR(512)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Список подключенных плагинов"',
                                             'index' => FALSE),
                // количество
                'quantity'          => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Количество товара"'),
                // скидка
                'discount'          => array('type' => 'FLOAT(5,2)',
                                             'params' => 'DEFAULT -1.00 NOT NULL COMMENT "Процент скидки"',
                                             'index' => FALSE),
                // ник
                'nickname'          => array('type' => 'VARCHAR(64)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Ник"'),
                // дата рождения
                'birthday'          => array('type' => 'DATETIME',
                                             'params' => 'DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата рождения"'),
                // емейл
                'email'             => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Емейл"'),
                // емейл 2
                'email2'            => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Емейл 2"'),
                // телефон
                'phone'             => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Телефон"'),
                // телефон 2
                'phone2'            => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Телефон 2"'),
                // icq
                'icq'               => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "ICQ номер"'),
                // icq 2
                'icq2'              => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "ICQ номер 2"'),
                // skype
                'skype'             => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Skype имя"'),
                // skype 2
                'skype2'            => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Skype имя 2"'),
                // адрес
                'address'           => array('type' => 'VARCHAR(512)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Адрес"',
                                             'handler' => 'packedUserAddress'),
                // адрес 2
                'address2'          => array('type' => 'VARCHAR(512)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Адрес 2"',
                                             'handler' => 'packedUserAddress2'),
                // пароль
                'password'          => array('type' => 'VARCHAR(50)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Хеш пароля"',
                                             'index' => FALSE),
                // ИД модуля
                'module_id'         => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор модуля"'),
                // ИД пользователя
                'user_id'           => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор пользователя"'),
                // ИД меню
                'menu_id'           => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор меню"'),
                // ИД группы скидок
                'group_id'          => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор группы скидок"'),
                // ИД ценовой группы
                'price_id'          => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор ценовой группы"'),
                // ИД скидочного купона
                'coupon_id'         => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор скидочного купона"'),
                // ИД реферала
                'affiliate_id'      => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор завлекающего пользователя"'),
                // ИД страны
                'country_id'        => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор страны"'),
                // ИД области
                'region_id'         => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор области"'),
                // ИД города
                'town_id'           => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор города"'),
                // ИД учебного заведения
                'school_id'         => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор учебного заведения"'),
                // ИД класса учебного заведения
                'class_id'          => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор класса учебного заведения"'),
                // ИД комплекта
                'kit_id'            => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор комплекта"'),
                // ИД категории
                'category_id'       => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор категории"'),
                // ИД бренда
                'brand_id'          => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор бренда"'),
                // ИД товара
                'product_id'        => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор товара"'),
                // ИД варианта товара
                'variant_id'        => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор варианта товара"'),
                // ИД родителя
                'parent_id'         => array('type' => 'BIGINT(20)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор родителя"'),
                // ИД отдела магазина
                'section'           => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Идентификатор отдела магазина"'),
                // разрешена
                'enabled'           => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Запись разрешена"'),
                // видна
                'visible'           => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Видно пользователям"'),
                // скрыта
                'hidden'            => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Скрыто от неавторизованных"'),
                // есть в анонсах
                'listed'            => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Видно в анонсах"'),
                // удалена
                'deleted'           => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Запись удалена"'),
                // выделена
                'highlighted'       => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Выделено визуально"'),
                // обсуждаема
                'commented'         => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Разрешено к обсуждению"'),
                // Яндекс.Маркет
                'ymarket'           => array('type' => 'INT(11)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Экспорт в Яндекс.Маркет"'),
                // ВКонтакте
                'vkontakte'         => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Экспорт в ВКонтакте"'),
                // не для rss
                'rss_disabled'      => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Не для RSS"'),
                // не для информеров
                'export_disabled'   => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Не для информеров"'),
                // не в кредит
                'non_creditable'    => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Не продается в кредит"'),
                // не для продажи
                'non_usable'        => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Не для продажи (экспонат)"'),
                // в каких прайсах
                'in_prices'         => array('type' => 'TINYINT(1) UNSIGNED',
                                             'params' => 'DEFAULT 255 NOT NULL COMMENT "В каких из 8 прайсов выводится"'),
                // субдомен
                'subdomain'         => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Левая часть имени субдомена"'),
                // разрешен ли субдомен
                'subdomain_enabled' => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Субдомен разрешен"'),
                // контент субдомена
                'subdomain_html'    => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Контент субдомена"',
                                             'index' => FAlSE),
                // шаблон
                'template'          => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Нестандартный шаблон для отображения"'),
                // главное фото
                'image'             => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "URL главного фото"'),
                // фото
                'images'            => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "URL-ы всех фото"',
                                             'handler' => 'packedImages',
                                             'index' => FALSE),
                // надписи фото
                'images_alts'       => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Alt-надписи всех фото"',
                                             'handler' => 'packedImagesAlts',
                                             'index' => FALSE),
                // описания фото
                'images_texts'      => array('type' => 'LONGTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Описания всех фото"',
                                             'handler' => 'packedImagesTexts',
                                             'index' => FALSE),
                // слайдинг-признаки
                'images_view'       => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "ВклВыкл-признаки всех фото"',
                                             'handler' => 'packedImagesView',
                                             'index' => FALSE),
                // опубликовано
                'date'              => array('type' => 'DATETIME',
                                             'params' => 'DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата публикации"'),
                // создано
                'created'           => array('type' => 'DATETIME',
                                             'params' => 'DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата создания записи"'),
                // изменено
                'modified'          => array('type' => 'DATETIME',
                                             'params' => 'DEFAULT "0000-00-00 00:00:00" NOT NULL COMMENT "Дата изменения записи"'),
                // IP адрес
                'ip'                => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "IP-адрес пользователя"',
                                             'handler' => 'packedIp'),
                // аутентификатор действия
                'remote_token'      => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Аутентификатор внешнего действия"')
            );
            if (isset($def[$name])) {
                $field = $name;
                $info = $def[$name];
            }
        }



        // ===================================================================
        /**
        *  Обеспечение объема сведений о поле для конкретного элемента списка полей
        *
        *  @access  protected
        *  @param   string  $field  имя поля (будет обновлено в этой переменной)
        *  @param   array   $info   массив сведений (будет обновлен в этой переменной)
        *  @return  boolean         TRUE если сведения обеспечены
        *                           FALSE если это неправильный элемент списка полей
        */
        // ===================================================================

        protected function provideFieldInfo ( & $field, & $info = array() ) {

            // может поле было записано краткой записью?
            $this->recognizeFieldJotting($field, $info);

            if (!is_string($field)) return FALSE;
            $field = trim($field);
            if ($field == '') return FALSE;
            if (!is_array($info)) $info = array();

            // какой тип поля в MySQL
            $name = 'type';
            $info[$name] = isset($info[$name]) && is_string($info[$name]) ? trim($info[$name]) : '';
            if ($info[$name] == '') return FALSE;

            // какой это тип для PHP
            $type = preg_replace('/(\s*\(\s*|\s*\)|[,\.][0-9]+)/', '', $this->text->lowerCase($info[$name]));
            switch ($type) {
                case 'int11':
                case 'bigint20':
                case 'tinyint1 unsigned':
                    switch ($field) {
                        case 'browsed':
                        case 'votes':
                            $info['type_std'] = 'natural';
                            break;
                        default:
                            $info['type_std'] = 'integer';
                    }
                    break;
                case 'datetime':
                    $info['type_std'] = 'date';
                    break;
                case 'tinyint1':
                    $info['type_std'] = 'boolean';
                    break;
                case 'float5':
                case 'float12':
                case 'float17':
                    switch ($field) {
                        case 'rating':
                            $info['type_std'] = 'positive';
                            break;
                        default:
                            $info['type_std'] = 'float';
                    }
                    break;
                case 'text':
                case 'mediumtext':
                case 'longtext':
                case 'varchar16':
                case 'varchar32':
                case 'varchar64':
                case 'varchar128':
                case 'varchar256':
                case 'varchar512':
                case 'varchar1024':
                case 'varchar2048':
                case 'varchar4096':
                case 'varchar8192':
                case 'varchar16384':
                case 'varchar32768':
                default:
                    $info['type_std'] = 'string';
            }

            // имеет ли дефолтные параметры при создании поля
            $name = 'params';
            $info[$name] = isset($info[$name]) && is_string($info[$name]) ? trim($info[$name]) : '';

            // является ли индексируемым
            $name = 'index';
            $info[$name] = !isset($info[$name]) || $info[$name] == TRUE;

            // заполнять ли пустые при проверке таблицы
            $name = 'fix';
            $info[$name] = !isset($info[$name]) || $info[$name] == TRUE;

            // имеет ли поле свой обработчик при update записи
            $name = 'handler';
            $info[$name] = isset($info[$name]) && is_string($info[$name]) ? trim($info[$name]) : '';
            return TRUE;
        }



        // ===================================================================
        /**
        *  Догрузчик вспомогательных моделей
        *
        *  @access  public
        *  @param   string  $name   объектно-полевое имя модели
        *  @return  object          догруженный объект
        */
        // ===================================================================

        public function __get ( $name ) {
            $this->$name = null;

            // получаем из имя_модели класс ИмяМодели
            $class = preg_replace('/[^a-z0-9]+/i', ' ', $name);
            $class = ucwords(strtolower($class));
            $class = str_replace(' ', '', $class);
            if ($class != '') {

                // подгружаем файл модели
                $file = dirname(__FILE__) . '/../.any-models/' . $class . '.php';
                if (is_file($file) && is_readable($file)) {
                    require_once($file);
                    $class .= 'ANYModel';

                    // создаем и возвращаем объект модели
                    if (class_exists($class)) {
                        $object = new $class($this->cms);
                        $object->owner = $this;
                        if (!isset($object->owner_exclusive)) $object->owner_exclusive = FALSE;
                        $this->$name = & $object;
                        return $this->$name;
                    }
                }
            }

            // иначе возвращаем НЕТ МОДЕЛИ
            return null;
        }



        // ===================================================================
        /**
        *  Получение списка неких идентификаторов
        *
        *  @access  public
        *  @param   string  $field      имя поля таблицы
        *  @param   string  $where      условие WHERE (без этого ключевого слова)
        *  @param   string  $select     список дополнительно отбираемых полей (без ключевого слова SELECT, ВСЕ ПОЛЯ завершать запятой)
        *  @param   string  $join       список дополнительно подключаемых таблиц (с необходимыми ключевыми словами)
        *  @param   string  $group      список дополнительных полей группировки (без ключевого слова GROUP BY, ВСЕ ПОЛЯ завершать запятой)
        *  @param   string  $having     условие HAVING (без этого ключевого слова)
        *  @param   string  $order      список дополнительных полей сортировки (без ключевого слова ORDER BY, ВСЕ ПОЛЯ завершать запятой)
        *  @param   boolean $as_string  TRUE если возвратить как строку (через запятую)
        *  @return  mixed               строка или массив (индексирован ИДами) уникальных идентификаторов
        *                               строка имеет вид:
        *                                   ид1,ид2,...,идN
        *                               элемент массива это объект:
        *                                   ->дополнительные_поля_если_были_заданы
        *                                   ->id
        *                                   ->count
        */
        // ===================================================================

        public function getIds ( $field, $where = '', $select = '', $join = '', $group = '', $having = '', $order = '', $as_string = FALSE ) {

            // если указано имя поля
            $ids = $as_string ? '' : array();
            $field = preg_replace('/[`"\'\s\t\r\n]/', '', $field);
            if ($field != '') {
                $dbtable = $this->getDBTable();

                // если задано условие WHERE
                if ($where != '') $where = 'AND (' . $where . ') ';

                // если задано условие HAVING
                if ($having != '') $having = 'HAVING ' . $having . ' ';

                // делаем запрос
                $query = 'SELECT ' . $select
                             . '`' . $field . '` AS `id`, '
                             . 'COUNT(`' . $field . '`) AS `count` '
                       . 'FROM `' . $dbtable . '` '
                       . $join
                       . 'WHERE `' . $field . '` != 0 ' . $where
                       . 'GROUP BY ' . $group . ' `' . $field . '` '
                       . $having
                       . 'ORDER BY ' . $order . ' `' . $field . '` ASC;';
                $result = $this->cms->db->query($query);

                // формируем список идентификаторов
                if ($result !== FALSE) {
                    while ($row = $this->cms->db->fetch_object($result)) {
                        $id = isset($row->id) ? intval($row->id) : 0;
                        if (!empty($id)) {
                            if ($as_string) $ids .= $id . ',';
                            else $ids[$id] = $row;
                        }
                    }
                    if ($as_string) $ids = rtrim($ids, ',');
                }

                // освобождаем память от запроса
                $this->cms->db->free_result($result);
            }

            // возвращаем список
            return $ids;
        }



        // ===================================================================
        /**
        *  Формировка параметра LIMIT для MySQL-запроса
        *
        *  @access  public
        *  @param   object  $params     объект параметров
        *  @return  string              строка с параметром или пустая строка
        */
        // ===================================================================

        public function limit ( $params = null ) {

            // если есть какое-то поле для LIMIT
            $result = '';
            if (isset($params->start) || isset($params->maxcount)) {
                $result = 'LIMIT ';

                // если задан индекс начальной записи
                if (isset($params->start)) {
                    $params->start = intval($params->start);
                    if ($params->start >= 0) $result .= $params->start . ', ';
                }

                // если задано число отбираемых записей
                if (isset($params->maxcount)) {
                    $params->maxcount = intval($params->maxcount);
                    if ($params->maxcount >= 0) $result .= $params->maxcount;
                }
            }

            // возвращаем строку с параметром
            return $result;
        }



        // ===================================================================
        /**
        *  Подготовка поля обновляемой записи к операции обновления в базе данных
        *
        *  @access  public
        *  @param   object  $record     объект обновляемой записи
        *  @param   string  $name       имя поля
        *  @param   string  $type       тип поля
        *  @param   array   $fields     массив имен обновляемых полей (примет новый элемент)
        *  @param   array   $values     массив значений обновляемых полей (примет новый элемент)
        *  @param   mixed   $value      null или БЕЗУСЛОВНО новое значение поля
        *  @return  boolean             выполнено или нет (было такое поле или нет)
        */
        // ===================================================================

        public function prepareField ( & $record, $name, $type, & $fields, & $values, $value = null ) {

            // если такое поле есть в записи
            $result = isset($record->$name);
            if ($result) {

                // добавляем имя в массив имен обновляемых полей
                $fields[] = $name;

                // извлекаем значение поля, если не указано БЕЗУСЛОВНО новое значение
                if (is_null($value)) $value = $record->$name;

                // согласно типу добавляем значение в массив значений обновляемых полей
                switch ($this->text->lowerCase($type)) {
                    case 'string':
                        $value = $this->cms->db->value_as_string($value);
                        $values[] = '\'' . $this->cms->db->query_value($value) . '\'';
                        break;
                    case 'natural':
                        $values[] = $this->cms->db->value_as_natural($value);
                        break;
                    case 'positive':
                        $value = $this->number->floatValue($value);
                        $value = abs($value);
                        $values[] = $this->number->safeFloatValueString($value);
                        break;
                    case 'float':
                        $value = $this->number->floatValue($value);
                        $values[] = $this->number->safeFloatValueString($value);
                        break;
                    case 'integer':
                        $values[] = $this->cms->db->value_as_integer($value);
                        break;
                    case 'boolean':
                        $values[] = $this->cms->db->value_as_boolean($value);
                        break;
                    case 'date':
                        $value = $this->cms->db->value_as_date($value);
                        $values[] = '\'' . $this->cms->db->query_value($value) . '\'';
                        break;
                    case 'chars':
                    default:
                        $values[] = '\'' . $this->cms->db->query_value($value) . '\'';
                }
            }

            // возвращаем СДЕЛАНО / НЕТ
            return $result;
        }



        // ===================================================================
        /**
        *  Получение составного имени пользователя
        *
        *  @access  public
        *  @param   object  $item   объект записи
        *  @return  string          имя
        */
        // ===================================================================

        public function compoundUserName ( & $item ) {
            $name = '';
            // фамилия
            if (isset($item->name)) $name = $this->text->removeRecordsDelimiters($item->name, ' ');
            // имя
            if (isset($item->name3)) $name .= ' ' . $item->name3;
            // отчество
            if (isset($item->name2)) $name .= ' ' . $item->name2;
            return $this->text->asSentence($name);
        }



        // ===================================================================
        /**
        *  Получение составного адреса пользователя
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $suffix     суффикс поля
        *  @return  string              адрес
        */
        // ===================================================================

        public function compoundUserAddress ( & $item, $suffix = '' ) {
            $addr = '';
            $field = 'address' . trim($suffix);
            $field2 = $field . '_2';
            $field3 = $field . '_3';
            $field4 = $field . '_4';
            $field5 = $field . '_5';
            $field6 = $field . '_6';
            $field7 = $field . '_7';
            $field8 = $field . '_8';
            $field9 = $field . '_9';
            $field10 = $field . '_10';
            // почтовый код
            if (isset($item->$field10) && $item->$field10 != '') $addr .= $item->$field10 . ', ';
            // страна
            if (isset($item->$field)) $addr .= $this->text->removeRecordsDelimiters($item->$field, ', ') . ', ';
            // область
            if (isset($item->$field2) && $item->$field2 != '') {
                $value = $this->text->lowerCase(trim($item->$field2));
                $addr .= $item->$field2;
                if (substr($value, -5) != ' обл.' && substr($value, -4) != ' обл' && substr($value, -8) != ' область'
                && substr($value, -4) != ' р-н' && substr($value, -6) != ' район' && substr($value, -5) != ' край') {
                    $addr .= ' область';
                }
                $addr .= ', ';
            }
            // город
            if (isset($item->$field3) && $item->$field3 != '') {
                $value = $this->text->lowerCase(trim($item->$field3));
                if (substr($value, 0, 2) != 'г.' && substr($value, 0, 2) != 'г ' && substr($value, 0, 3) != 'г. ' && substr($value, 0, 6) != 'город '
                && substr($value, 0, 4) != 'пос.' && substr($value, 0, 4) != 'пос ' && substr($value, 0, 8) != 'поселок '
                && substr($value, 0, 4) != 'пгт.' && substr($value, 0, 4) != 'пгт ' && substr($value, 0, 5) != 'п.г.т'
                && substr($value, 0, 2) != 'с.' && substr($value, 0, 2) != 'с ' && substr($value, 0, 5) != 'село '
                && substr($value, 0, 2) != 'х.' && substr($value, 0, 2) != 'х ' && substr($value, 0, 6) != 'хутор ') {
                    $addr .= 'г. ';
                }
                $addr .= $item->$field3 . ', ';
            }
            // улица
            if (isset($item->$field4) && $item->$field4 != '') {
                $value = $this->text->lowerCase(trim($item->$field4));
                if (substr($value, 0, 3) != 'ул.' && substr($value, 0, 3) != 'ул ' && substr($value, 0, 4) != 'ул. ' && substr($value, 0, 5) != 'улица'
                && substr($value, 0, 4) != 'вул.' && substr($value, 0, 4) != 'вул ' && substr($value, 0, 6) != 'вулиця'
                && substr($value, 0, 3) != 'кв.' && substr($value, 0, 3) != 'кв ' && substr($value, 0, 7) != 'квартал'
                && substr($value, 0, 3) != 'пр.' && substr($value, 0, 3) != 'пр ' && substr($value, 0, 4) != 'п-т '
                && substr($value, 0, 5) != 'пр-т ' && substr($value, 0, 5) != 'пр-кт ' && substr($value, 0, 6) != 'просп.'
                && substr($value, 0, 6) != 'просп ' && substr($value, 0, 8) != 'проспект' && substr($value, 0, 4) != 'пер.'
                && substr($value, 0, 4) != 'пер ' && substr($value, 0, 8) != 'переулок') {
                    $addr .= 'ул. ';
                }
                $addr .= $item->$field4 . ', ';
            }
            // дом
            if (isset($item->$field5) && $item->$field5 != '') $addr .= 'дом ' . $item->$field5 . ', ';
            // корпус
            if (isset($item->$field6) && $item->$field6 != '') $addr .= 'корпус ' . $item->$field6 . ', ';
            // подъезд
            if (isset($item->$field7) && $item->$field7 != '') $addr .= 'подъезд ' . $item->$field7 . ', ';
            // код на двери
            if (isset($item->$field8) && $item->$field8 != '') $addr .= 'код ' . $item->$field8 . ', ';
            // квартира
            if (isset($item->$field9) && $item->$field9 != '') $addr .= 'квартира ' . $item->$field9;
            $addr = preg_replace('/[ \r\n\t\s]+/', ' ', $addr);
            $addr = preg_replace('/(\s*,)+/', ',', $addr);
            return trim($addr, ', ');
        }



        // ===================================================================
        /**
        *  Распаковка полей записей
        *
        *  @access  public
        *  @param   array   $items      массив записей
        *  @param   object  $params     объект параметров
        *  @return  void
        */
        // ===================================================================

        public function unpackRecords ( & $items, $params = null ) {
            $dbtable = $this->getDBTable();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' unpackRecords');
            if (!empty($items)) {
                foreach ($items as & $item) $this->unpack($item, $params);
            }
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Распаковка полей записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   object  $params     объект параметров
        *  @return  void
        */
        // ===================================================================

        public function unpack ( & $item, $params = null ) {

            // поправляем адресующие поля
            $id = $this->getIDField();
            if (isset($item->$id)) $item->$id = intval($item->$id);
        }



        // ===================================================================
        /**
        *  Распаковка поля NAME + HEADER записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @return  void
        */
        // ===================================================================

        public function unpackName ( & $item ) {
            if (isset($item->name)) $this->cms->db->fix_textfield_as_product_name($item->name);
            if (isset($item->header)) $this->cms->db->fix_textfield_as_product_name($item->header);
        }



        // ===================================================================
        /**
        *  Распаковка поля NAME записи, содержащей поля пользователя
        *
        *  При упаковке дополняет запись полями:
        *      ->name = фамилия
        *      ->name2 = отчество
        *      ->name3 = имя
        *      ->search_name = ФИО для поисковых целей
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   boolean $searching  TRUE если создать поле для поисковых целей
        *  @return  void
        */
        // ===================================================================

        public function unpackUserName ( & $item, $searching = FALSE ) {
            if (!isset($item->name)) $item->name = '';
            if (!isset($item->name2) || !isset($item->name3)) {
                if ($searching) $item->search_name = $this->text->removeRecordsDelimiters($item->name, ' ');
                $value = explode('|', $item->name);
                // фамилия
                $item->name = trim($value[0]);
                // отчество
                $item->name2 = isset($value[1]) ? trim($value[1]) : '';
                // имя
                $item->name3 = isset($value[2]) ? trim($value[2]) : '';
                $item->compound_name = $this->compoundUserName($item);
            }
        }



        // ===================================================================
        /**
        *  Распаковка поля ADDRESS записи, содержащей поля пользователя
        *
        *  При упаковке дополняет запись полями:
        *      ->address = страна
        *      ->address_2 = область
        *      ->address_3 = город
        *      ->address_4 = улица
        *      ->address_5 = дом
        *      ->address_6 = корпус
        *      ->address_7 = подъезд
        *      ->address_8 = код на двери
        *      ->address_9 = квартира
        *      ->address_10 = почтовый код
        *      ->search_address = АДРЕС для поисковых целей
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $suffix     суффикс поля
        *  @param   boolean $searching  TRUE если создать поле для поисковых целей
        *  @return  void
        */
        // ===================================================================

        public function unpackUserAddress ( & $item, $suffix = '', $searching = FALSE ) {
            $suffix = trim($suffix);
            $field = 'address' . $suffix;
            $field2 = $field . '_2';
            $field3 = $field . '_3';
            $field4 = $field . '_4';
            $field5 = $field . '_5';
            $field6 = $field . '_6';
            $field7 = $field . '_7';
            $field8 = $field . '_8';
            $field9 = $field . '_9';
            $field10 = $field . '_10';
            if (!isset($item->$field)) $item->$field = '';
            if (!isset($item->$field2) || !isset($item->$field3) || !isset($item->$field4)
            || !isset($item->$field5) || !isset($item->$field6) || !isset($item->$field7)
            || !isset($item->$field8) || !isset($item->$field9) || !isset($item->$field10)) {
                if ($searching) {
                    $value = 'search_' . $field;
                    $item->$value = $this->text->removeRecordsDelimiters($item->$field, ' ');
                }
                $value = explode('|', $item->$field);
                $item->$field = trim($value[0]);
                $item->$field2 = isset($value[1]) ? trim($value[1]) : '';
                $item->$field3 = isset($value[2]) ? trim($value[2]) : '';
                $item->$field4 = isset($value[3]) ? trim($value[3]) : '';
                $item->$field5 = isset($value[4]) ? trim($value[4]) : '';
                $item->$field6 = isset($value[5]) ? trim($value[5]) : '';
                $item->$field7 = isset($value[6]) ? trim($value[6]) : '';
                $item->$field8 = isset($value[7]) ? trim($value[7]) : '';
                $item->$field9 = isset($value[8]) ? trim($value[8]) : '';
                $item->$field10 = isset($value[9]) ? trim($value[9]) : '';
                $field = 'compound_address' . $suffix;
                $item->$field = $this->compoundUserAddress($item, $suffix);
            }
        }



        // ===================================================================
        /**
        *  Распаковка поля ANNOTATION + DESCRIPTION + BODY + SEO_DESCRIPTION записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @return  void
        */
        // ===================================================================

        public function unpackBody ( & $item ) {
            if (isset($item->annotation)) $this->cms->db->fix_textfield_as_product_description($item->annotation);
            if (isset($item->description)) $this->cms->db->fix_textfield_as_product_description($item->description);
            if (isset($item->body)) $this->cms->db->fix_textfield_as_product_description($item->body);
            if (isset($item->seo_description)) $this->cms->db->fix_textfield_as_product_description($item->seo_description);
        }



        // ===================================================================
        /**
        *  Распаковка поля IP записи
        *
        *  При распаковке дополняет запись полями:
        *      ->host = имя хоста
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @return  void
        */
        // ===================================================================

        public function unpackIp ( & $item ) {
            if (isset($item->ip) && !isset($item->host)) {
                $item->ip = is_string($item->ip) ? preg_replace('/[ \s\t\r\n]+/', ' ', $item->ip) : '';
                $item->ip = explode(' ', trim($item->ip), 2);
                $item->host = isset($item->ip[1]) ? $item->ip[1] : '';
                $item->ip = $item->ip[0];
            }
        }



        // ===================================================================
        /**
        *  Распаковка поля URL записи
        *
        *  При распаковке дополняет запись полями:
        *      ->url_path = начальная часть пути
        *      ->url_full = полный url
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $begin      дефолтное начало пути
        *  @return  void
        */
        // ===================================================================

        public function unpackUrl ( & $item, $begin = '' ) {
            if (isset($item->url)) {
                if (empty($item->url)) {
                    $id = $this->getIDField();
                    $id = isset($item->$id) ? $item->$id : '';
                    $item->url = $id;
                }
                $item->url_path = !empty($item->url_special) ? '' : ltrim($begin . '/', ' /\\');
                $item->url_full = $item->url_path . $item->url;
            }
        }



        // ===================================================================
        /**
        *  Распаковка полей URL категории и бренда
        *
        *  При распаковке дополняет запись полями:
        *      ->category_url_path = начальная часть пути категории
        *      ->category_url_path = полный url категории
        *      ->brand_url_path = начальная часть пути бренда
        *      ->brand_url_path = полный url бренда
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @return  void
        */
        // ===================================================================

        public function unpackTreeUrl ( & $item ) {
            if (isset($item->category_url)) {
                if (empty($item->category_url)) {
                    $id = isset($item->category_id) ? $item->category_id : '';
                    $item->category_url = $id;
                }
                $item->category_url_path = !empty($item->category_url_special) ? '' : 'catalog/';
                $item->category_url_full = $item->category_url_path . $item->category_url;
            }
            if (isset($item->brand_url)) {
                if (empty($item->brand_url)) {
                    $id = isset($item->brand_id) ? $item->brand_id : '';
                    $item->brand_url = $id;
                }
                $item->brand_url_path = !empty($item->brand_url_special) ? '' : 'brands/';
                $item->brand_url_full = $item->brand_url_path . $item->brand_url;
            }
        }



        // ===================================================================
        /**
        *  Распаковка поля IMAGES + IMAGES_ALTS + IMAGES_TEXTS + IMAGES_VIEW записи
        *
        *  При распаковке дополняет запись полями:
        *      ->images_thumbs = миниатюры картинок
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @return  void
        */
        // ===================================================================

        public function unpackImages ( & $item ) {
            $images = array();
            $alts = array();
            $texts = array();
            $view = array();

            // превращаем строки в массивы
            $separator = '|';
            if (!empty($item->images)) {
                if (is_string($item->images)) $images = explode($separator, $item->images);
                else if (is_array($item->images)) $images = $item->images;
            }
            if (!empty($item->images_alts)) {
                if (is_string($item->images_alts)) $alts = explode($separator, $item->images_alts);
                else if (is_array($item->images_alts)) $alts = $item->images_alts;
            }
            if (!empty($item->images_texts)) {
                if (is_string($item->images_texts)) $texts = explode($separator, $item->images_texts);
                else if (is_array($item->images_texts)) $texts = $item->images_texts;
            }
            if (!empty($item->images_view)) {
                if (is_string($item->images_view)) $view = explode($separator, $item->images_view);
                else if (is_array($item->images_view)) $view = $item->images_view;
            }

            // если запись усовершенствована из однокартиночной
            if (isset($item->image)) {
                if (!empty($item->image) && !in_array($item->image, $images)) {
                    array_unshift($images, $item->image);
                    array_unshift($alts, '');
                    array_unshift($texts, '');
                    array_unshift($view, 1);
                }
            }

            // если в записи есть поле "главное изображение"
            if (isset($item->large_image)) {
                if (!empty($item->large_image) && !in_array($item->large_image, $images)) {
                    array_unshift($images, $item->large_image);
                    array_unshift($alts, '');
                    array_unshift($texts, '');
                    array_unshift($view, 0);
                }
            }

            // перебираем массив имен файлов изображений
            $count = 0;
            $item->images = array();
            $item->images_thumbs = array();
            foreach ($images as & $image) {
                $image = trim($image);
                if (!empty($image)) {
                    $item->images[] = $image;
                    $item->images_thumbs[] = $this->cms->db->get_record_images_thumbnail($image);
                    $count++;
                }
            }

            // перебираем массив alt-ов изображений
            $count2 = 0;
            $item->images_alts = array();
            foreach ($alts as & $alt) {
                if ($count2 >= $count) break;
                $alt = trim($alt);
                $item->images_alts[] = $alt;
                $count2++;
            }
            // если не хватает элементов, заполняем недостающие пустыми
            while ($count2 < $count) {
                $item->images_alts[] = '';
                $count2++;
            }

            // перебираем массив описаний изображений
            $count2 = 0;
            $item->images_texts = array();
            foreach ($texts as & $text) {
                if ($count2 >= $count) break;
                $text = trim($text);
                $item->images_texts[] = $text;
                $count2++;
            }
            // если не хватает элементов, заполняем недостающие пустыми
            while ($count2 < $count) {
                $item->images_texts[] = '';
                $count2++;
            }

            // перебираем массив признаков изображений
            $count2 = 0;
            $item->images_view = array();
            foreach ($view as & $v) {
                if ($count2 >= $count) break;
                $v = $v == 1 ? 1 : 0;
                $item->images_view[] = $v;
                $count2++;
            }
            // если не хватает элементов, заполняем недостающие пустыми
            while ($count2 < $count) {
                $item->images_view[] = 1;
                $count2++;
            }
        }



        // ===================================================================
        /**
        *  Упаковка поля IMAGES + IMAGES_ALTS + IMAGES_TEXTS + IMAGES_VIEW записи
        *
        *  При упаковке дополняет запись полями:
        *      ->image = первая картинка
        *      ->large_image = первая картинка
        *      ->small_image = миниатюра первой картинки
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @return  void
        */
        // ===================================================================

        public function packImages ( & $item ) {

            // если не существуют поля изображений, создаем их
            $separator = '|';
            if (!isset($item->images)) $item->images = array();
                else if (is_string($item->images)) $item->images = explode($separator, $item->images);
                else if (!is_array($item->images)) $item->images = array();
            if (!isset($item->images_alts)) $item->images_alts = array();
                else if (is_string($item->images_alts)) $item->images_alts = explode($separator, $item->images_alts);
                else if (!is_array($item->images_alts)) $item->images_alts = array();
            if (!isset($item->images_texts)) $item->images_texts = array();
                else if (is_string($item->images_texts)) $item->images_texts = explode($separator, $item->images_texts);
                else if (!is_array($item->images_texts)) $item->images_texts = array();
            if (!isset($item->images_view)) $item->images_view = array();
                else if (is_string($item->images_view)) $item->images_view = explode($separator, $item->images_view);
                else if (!is_array($item->images_view)) $item->images_view = array();

            // подсчитываем количество изображений
            $item->images = array_values($item->images);
            $count = count($item->images);

            // возможно эта запись усовершенствована из однокартиночной
            if (!isset($item->image)) {
                $item->image = $count > 0 ? $item->images[0] : '';
            } elseif (!empty($item->image) && !in_array($item->image, $item->images)) {
                $item->image = '';
            }

            // возможно эта запись имеет поле "главное изображение"
            if (!isset($item->large_image)) {
                $item->large_image = $count > 0 ? $item->images[0] : '';
            } elseif (!empty($item->large_image) && !in_array($item->large_image, $item->images)) {
                $item->large_image = '';
            }
            $item->small_image = $this->cms->db->get_record_images_thumbnail($item->large_image);

            // уравниваем размер массива alt-ов изображений по размеру массива имен файлов изображений
            $item->images_alts = array_values($item->images_alts);
            $count2 = count($item->images_alts);
            if ($count2 > $count) $item->images_alts = array_slice($item->images_alts, 0, $count);
            // если не хватает элементов, заполняем недостающие пустыми
            while ($count2 < $count) {
                $item->images_alts[] = '';
                $count2++;
            }

            // уравниваем размер массива описаний изображений по размеру массива имен файлов изображений
            $item->images_texts = array_values($item->images_texts);
            $count2 = count($item->images_texts);
            if ($count2 > $count) $item->images_texts = array_slice($item->images_texts, 0, $count);
            // если не хватает элементов, заполняем недостающие пустыми
            while ($count2 < $count) {
                $item->images_texts[] = '';
                $count2++;
            }

            // уравниваем размер массива признаков изображений по размеру массива имен файлов изображений
            $item->images_view = array_values($item->images_view);
            $count2 = count($item->images_view);
            if ($count2 > $count) $item->images_view = array_slice($item->images_view, 0, $count);
            // если не хватает элементов, заполняем недостающие пустыми
            while ($count2 < $count) {
                $item->images_view[] = 1;
                $count2++;
            }

            // превращаем массивы в строки
            if (is_array($item->images)) $item->images = implode($separator, $item->images);
            if (is_array($item->images_alts)) $item->images_alts = implode($separator, $item->images_alts);
            if (is_array($item->images_texts)) $item->images_texts = implode($separator, $item->images_texts);
            if (is_array($item->images_view)) $item->images_view = implode($separator, $item->images_view);
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля IMAGES записи
        *
        *  @access  public
        *  @param   object  $item   объект записи
        *  @return  string          упакованный вид
        */
        // ===================================================================

        public function packedImages ( & $item ) {
            if (!isset($item->images)) return '';
            if (is_string($item->images)) return $item->images;
            if (!is_array($item->images)) return '';
            return implode('|', array_values($item->images));
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля IMAGES_ALTS записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   string  $def        дефолтное значение пустых элементов
        *  @return  string              упакованный вид
        */
        // ===================================================================

        public function packedImagesAlts ( & $item, $field = 'images_alts', $def = '' ) {
            if (!isset($item->images) || !isset($item->$field)) return '';
            if (is_string($item->images)) return is_string($item->$field) ? $item->$field : '';
            if (!is_array($item->images)) return '';

            // уравниваем массив по размеру массива изображений
            $count = count($item->images);
            $values = is_array($item->$field) ? array_values($item->$field) : array();
            if (count($values) > $count) $values = array_slice($values, 0, $count);
            else $values = array_pad($values, $count, $def);
            return implode('|', $values);
        }

        public function packedImagesTexts ( & $item ) {
            return $this->packedImagesAlts($item, 'images_texts');
        }

        public function packedImagesView ( & $item ) {
            return $this->packedImagesAlts($item, 'images_view', 1);
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля FILES записи
        *
        *  @access  public
        *  @param   object  $item   объект записи
        *  @return  string          упакованный вид
        */
        // ===================================================================

        public function packedFiles ( & $item ) {
            if (!isset($item->files)) return '';
            if (is_string($item->files)) return $item->files;
            if (!is_array($item->files)) return '';
            return implode('|', array_values($item->files));
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля FILES_ALTS записи
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @param   string  $def        дефолтное значение пустых элементов
        *  @return  string              упакованный вид
        */
        // ===================================================================

        public function packedFilesAlts ( & $item, $field = 'files_alts', $def = '' ) {
            if (!isset($item->files) || !isset($item->$field)) return '';
            if (is_string($item->files)) return is_string($item->$field) ? $item->$field : '';
            if (!is_array($item->files)) return '';

            // уравниваем массив по размеру массива файлов
            $count = count($item->files);
            $values = is_array($item->$field) ? array_values($item->$field) : array();
            if (count($values) > $count) $values = array_slice($values, 0, $count);
            else $values = array_pad($values, $count, $def);
            return implode('|', $values);
        }

        public function packedFilesTexts ( & $item ) {
            return $this->packedFilesAlts($item, 'files_texts');
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля IP записи
        *
        *  @access  public
        *  @param   object  $item   объект записи
        *  @return  string          упакованный вид
        */
        // ===================================================================

        public function packedIp ( & $item ) {
            $result = (isset($item->ip) ? $item->ip : '') . ' '
                    . (isset($item->host) ? $item->host : '');
            return $this->text->asSentence($result);
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля NAME записи, содержащей поля пользователя
        *
        *  @access  public
        *  @param   object  $item   объект записи
        *  @return  string          упакованный вид
        */
        // ===================================================================

        public function packedUserName ( & $item ) {
            $separator = '|';
            $result = $this->text->removeRecordsDelimiters(isset($item->name) ? $item->name : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->name2) ? $item->name2 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->name3) ? $item->name3 : '', ' ');
            return $this->text->asSentence($result);
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля ADDRESS записи, содержащей поля пользователя
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $suffix     суффикс поля
        *  @return  string              упакованный вид
        */
        // ===================================================================

        public function packedUserAddress ( & $item, $suffix = '' ) {
            $result = '';
            $field = 'address' . trim($suffix);
            $field2 = $field . '_2';
            $field3 = $field . '_3';
            $field4 = $field . '_4';
            $field5 = $field . '_5';
            $field6 = $field . '_6';
            $field7 = $field . '_7';
            $field8 = $field . '_8';
            $field9 = $field . '_9';
            $field10 = $field . '_10';
            $separator = '|';
            $result = $this->text->removeRecordsDelimiters(isset($item->$field) ? $item->$field : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field2) ? $item->$field2 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field3) ? $item->$field3 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field4) ? $item->$field4 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field5) ? $item->$field5 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field6) ? $item->$field6 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field7) ? $item->$field7 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field8) ? $item->$field8 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field9) ? $item->$field9 : '', ' ') . $separator
                    . $this->text->removeRecordsDelimiters(isset($item->$field10) ? $item->$field10 : '', ' ');
            return $this->text->asSentence($result);
        }

        public function packedUserAddress2 ( & $item ) {
            return $this->packedUserAddress($item, '2');
        }



        // ===================================================================
        /**
        *  Получение упакованного вида поля CHARGES записи, содержащей поля пользователя
        *
        *  @access  public
        *  @param   object  $item       объект записи
        *  @param   string  $field      имя поля
        *  @return  string              упакованный вид
        */
        // ===================================================================

        public function packedUserCharges ( & $item, $field = 'charges' ) {
            $result = '';
            if (isset($item->$field)) {
                if (is_string($item->$field)) return $item->$field;
                if (!is_array($item->$field) && !is_object($item->$field)) return '';
                foreach ($item->$field as $value) {
                    if (is_array($value)) {
                        $value = trim(implode('|', $value));
                        if ($value != '') {
                            if ($result != '') $result = '[]' . $result;
                            $result = $value . $result;
                            // храним не более 8 мб
                            if (strlen($result) > 8388608) break;
                        }
                    }
                }
            }
            return $result;
        }

        public function packedUserReferals ( & $item ) {
            return $this->packedUserCharges($item, 'referals');
        }

        public function packedUserRegs ( & $item ) {
            return $this->packedUserCharges($item, 'regs');
        }

        public function packedUserCommissions ( & $item ) {
            return $this->packedUserCharges($item, 'commissions');
        }



        // ===================================================================
        /**
        *  Получение упакованного вида array-поля записи
        *
        *  @access  public
        *  @param   object  $item   объект записи
        *  @param   string  $field  имя поля
        *  @param   boolean $assoc  TRUE если как ассоциативный массив (помнить и индексы)
        *                           FALSE если как простой массив значений (индексы не важны)
        *  @return  string          упакованный вид
        */
        // ===================================================================

        public function packedArray ( & $item, $field, $assoc = TRUE ) {
            $result = '';
            if ($field != '' && isset($item->$field)) {
                if (is_string($item->$field)) return $item->$field;
                if (is_array($item->$field) && !empty($item->$field)) {
                    $result = $assoc ? $item->$field : array_values($item->$field);
                    try {
                        $result = @ serialize($result);
                        if (!is_string($result)) $result = '';
                    } catch (Exception $e) {
                        $result = '';
                    }
                }
            }
            return $result;
        }



        // ===================================================================
        /**
        *  Очистка кеш-таблицы и зависимых кешей
        *
        *  @access  public
        *  @param   object  $item       объект обрабатывавшейся записи (содержащей меняемые поля):
        *                                   ->indifferent_caches = TRUE если не очищать кеши
        *  @return  boolean             TRUE если наследнику надо выполнить команды очистки кеша
        */
        // ===================================================================

        public function resetCaches ( & $item = null ) {

            // возвращаем TRUE, если просят очистить безусловно или изменения в самом деле критичны
            return is_null($item) || !isset($item->indifferent_caches)
                                  || !$item->indifferent_caches;
        }



        // ===================================================================
        /**
        *  Добавление оперативных ссылок админпанели в записи
        *
        *  @access  public
        *  @param   array   $items      массив записей
        *  @param   object  $params     параметры навигаторов страницы списка записей:
        *                                   ->token = аутентификатор операции
        *                                   [->sort] = способ сортировки записей
        *                                   [->list_module] = имя модуля работы со списком
        *                                   [->edit_module] = имя модуля работы с записью
        *  @return  void
        */
        // ===================================================================

        public function operable ( & $items, $params ) {
            $dbtable = $this->getDBTable();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' operable');

            if (!empty($this->operables_list) && is_string($this->operables_list)) {
                $list = isset($params->list_module) ? trim($params->list_module) : '';
                if (empty($list)) $list = trim($this->operables_list);
                if (!empty($list) && !empty($this->operables_card) && is_string($this->operables_card)) {

                    $card = isset($params->edit_module) ? trim($params->edit_module) : '';
                    if (empty($card)) $card = trim($this->operables_card);
                    if (!empty($card) && !empty($this->operables) && is_array($this->operables)) {

                        if (!empty($items) && is_array($items) && isset($params->token)) {
                            $id = $this->getIDField();
                            foreach ($items as & $item) {
                                if (isset($item->$id)) {

                                    // собираем параметры
                                    $options = array('section' => $list,
                                                     'item_id' => $item->$id,
                                                     'token'   => $params->token);
                                    if (isset($params->sort)) $options['sort'] = $params->sort;

                                    // создаем ссылки
                                    foreach ($this->operables as $field) {
                                        $field = $this->text->lowerCase(trim($field));
                                        switch ($field) {
                                            case 'move_up':       // поднять выше
                                            case 'move_down':     // опустить ниже
                                            case 'move_first':    // поставить первым
                                            case 'move_last':     // поставить последним
                                            case 'delete':        // удалить
                                            case 'hidden':        // скрыто от чужих / открыто всем
                                            case 'listed':        // есть в анонсах / нет
                                            case 'commented':     // обсуждаем / нет
                                            case 'visible':       // видимо пользователям / нет
                                            case 'enable_debit':  // считать расходным / нет
                                            case 'enable_credit': // считать приходным / нет
                                            case 'ymarket':       // экспорт в Яндекс.Маркет / нет
                                            case 'vkontakte':     // экспорт ВКонтакте / нет
                                            case 'done':          // пометить как сделано / не сделано
                                            case 'new':           // пометить как новое / не новое
                                                $options['section'] = $list;
                                                $options['act'] = $field;
                                                $field .= '_get';
                                                $item->$field = $this->cms->form_get($options);
                                                break;
                                            // разрешено к показу / нет
                                            case 'enabled': $field = 'enable';
                                            case 'enable':
                                                $options['section'] = $list;
                                                $options['act'] = 'enabled';
                                                $field .= '_get';
                                                $item->$field = $this->cms->form_get($options);
                                                break;
                                            // выделен визуально / нет
                                            case 'highlighted': $field = 'highlight';
                                            case 'highlight':
                                                $options['section'] = $list;
                                                $options['act'] = 'highlighted';
                                                $field .= '_get';
                                                $item->$field = $this->cms->form_get($options);
                                                break;
                                            // редактировать
                                            case 'edit':
                                                $options['section'] = $card;
                                                if (isset($options['act'])) unset($options['act']);
                                                $item->edit_get = $this->cms->form_get($options);
                                                break;
                                        }
                                    }

                                    // если есть вложенные элементы, добавляем ссылки в них
                                    $field = 'discussion';
                                    if (!empty($item->$field) && is_array($item->$field)) $this->operable($item->$field, $params);
                                }
                            }
                        }
                    }
                }
            }
            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Проверка наличия поисковой команды в искомом тексте
        *
        *  Форматы команд:
        *      команда:текст = все равные такому "текст"
        *      команда:*     = все непустые
        *      команда:      = все пустые
        *      команда!текст = все не равные такому "текст"
        *      команда^текст = все начинающиеся с такого "текст"
        *      команда~текст = все содержащие такой "текст" в любой позиции
        *      команда$текст = все оканчивающиеся таким "текст"
        *
        *  @access  protected
        *  @param   string  $command    имя команды
        *  @param   string  $keyword    искомый текст
        *  @return  mixed               правая часть фильтрующего MySQL-выражения
        *                               FALSE если не содержит такой команды
        */
        // ===================================================================

        protected function checkSearchCommand ( $command, $keyword ) {
            $command = $this->text->lowerCase($command);
            $size = $this->text->length($command);
            if (!empty($size)) {
                $prefix = $this->text->substr($keyword, 0, $size);
                $prefix = $this->text->lowerCase($prefix);

                if ($prefix == $command) {
                    $prefix = $this->text->substr($keyword, $size, 1);
                    if (in_array($prefix, array(':', '!', '^', '~', '$'))) {
                        $size++;

                        $keyword = trim($this->text->substr($keyword, $size));
                        $keyword = $this->cms->db->query_value($keyword);

                        if ($prefix == ':') return $keyword != '*' ? '= "' . $keyword . '"'
                                                                   : '!= ""';
                        elseif ($prefix == '!') return '!= "' . $keyword . '"';

                        if ($keyword == '') $keyword = ' ';

                        if ($prefix == '^') return 'LIKE "' . $keyword . '%"';
                        elseif ($prefix == '~') return 'LIKE "%' . $keyword . '%"';
                        elseif ($prefix == '$') return 'LIKE "%' . $keyword . '"';
                    }
                }
            }
            return FALSE;
        }



        // ===================================================================
        /**
        *  Частное дополнение WHERE-части запроса
        *
        *  @access  protected
        *  @param   string  $where      строка уже набранных условий
        *  @param   object  $filter     исходный фильтр
        *  @return  void
        */
        // ===================================================================

        protected function complementWhere ( & $where, & $filter ) {
        }



        // ===================================================================
        /**
        *  Чтение записей из базы данных
        *
        *  @access  public
        *  @param   array   $items      массив записей (будет возвращен в эту переменную)
        *  @param   object  $filter     фильтр по каким полям отбирать
        *  @param   array   $flatlist   некий дополнительный список (может возвращен в эту переменную)
        *  @return  integer             число записей, удовлетворяющих фильтру
        */
        // ===================================================================

        public function get ( & $items, $filter = null, & $flatlist = null ) {

            // TODO: сменить заглушку на универсальный ридер записей
            $items = array();
            return 0;
        }



        // ===================================================================
        /**
        *  Чтение записи из базы данных
        *
        *  @access  public
        *  @param   object  $item       объект записи (будет возвращен в эту переменную)
        *  @param   object  $filter     фильтр по каким полям отбирать, формат:
        *                                   ->поле = искомое значение
        *                               может также содержать виртуальные поля:
        *                                   [id] = идентификатор записи
        *                                   [exclude_id] = кроме такого идентификатора
        *                                   [domained] = имеющий субдомен с непустым контентом
        *                               может также содержать системные поля:
        *                                   [select] = требуемая SELECT-часть запроса
        *                                   [join] = требуемая JOIN-часть запроса
        *                                   [group_by] = требуемая GROUP_BY-часть запроса
        *                               может также содержать посторонние поля:
        *                                   [with_related]
        *                                   [unpack_params]
        *  @return  boolean             TRUE если прочитано
        *                               FALSE если ошибка или запись не найдена
        */
        // ===================================================================

        public function one ( & $item, $filter = null ) {
            $dbtable = $this->getDBTable();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' one');

            $item = null;
            if ($this->hasFields()) {
                $idfield = $this->getIDField();
                $where = '';
                $index = 0;

                // собираем виртуальные поля, перечисленные в фильтре
                foreach ($filter as $field => $value) {
                    switch ($field) {
                        case 'id':
                            if (!empty($value)) $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = "' . $this->cms->db->query_value($value) . '" ';
                            break;
                        case 'exclude_id':
                            $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` != "' . $this->cms->db->query_value($value) . '" ';
                            break;
                        case 'domained':
                            $field = 'subdomain_enabled';
                            $field2 = 'subdomain';
                            if (isset($this->fields[$index][$field]) && isset($this->fields[$index][$field2])) {
                                $where .= 'AND `' . $dbtable . '`.`' . $field . '` = 1 '
                                        . 'AND TRIM(`' . $dbtable . '`.`' . $field2 . '`) != "" ';
                            }
                            break;
                    }
                }

                // собираем реальные поля, перечисленные в фильтре
                foreach ($this->fields[$index] as $field => $info) {
                    if ($this->provideFieldInfo($field, $info)) {
                        switch ($field) {
                            case 'id':
                            case 'exclude_id':
                            case 'domained':
                            case 'with_related':
                            case 'select':
                            case 'join':
                            case 'group_by':
                                break;
                            case 'email':
                            case 'email2':
                            case 'phone':
                            case 'phone2':
                            case 'skype':
                            case 'skype2':
                            case 'icq':
                            case 'icq2':
                                if (isset($filter->$field) && $filter->$field != '') {
                                    $value = $this->cms->db->query_value($filter->$field);
                                    $field2 = rtrim($field, '2');
                                    if ($field2 == $field) $field2 = $field . '2';
                                    if (isset($this->fields[$index][$field2])) {
                                        $where .= 'AND (`' . $dbtable . '`.`' . $field . '` = "' . $value . '" '
                                                . 'OR `' . $dbtable . '`.`' . $field2 . '` = "' . $value . '") ';
                                    } else {
                                        $where .= 'AND `' . $dbtable . '`.`' . $field . '` = "' . $value . '" ';
                                    }
                                }
                                break;
                            case 'deleted':
                                $where .= 'AND `' . $dbtable . '`.`' . $field . '` = ' . (isset($filter->$field) ? $this->cms->db->query_value($filter->$field) : 0) . ' ';
                                break;
                            default:
                                if (isset($filter->$field)) {
                                    $where .= 'AND `' . $dbtable . '`.`' . $field . '` = "' . $this->cms->db->query_value($filter->$field) . '" ';
                                }
                        }
                    }
                }

                $this->complementWhere($where, $filter);
                if ($where != '') {
                    $where = 'WHERE ' . preg_replace('/^(AND|OR) /', '', $where);

                    // делаем запрос
                    $query = (!empty($filter->select) ? $filter->select . ' '
                                                      : 'SELECT `' . $dbtable . '`.* ')
                           . 'FROM `' . $dbtable . '` '
                           . (!empty($filter->join) ? $filter->join . ' ' : '')
                           . $where
                           . (!empty($filter->group_by) ? $filter->group_by . ' ' : '')
                           . 'LIMIT 1;';
                    $result = $this->cms->db->query($query);
                    $item = $this->cms->db->result();

                    // освобождаем память от запроса
                    $this->cms->db->free_result($result);

                    // поправляем поля записи
                    if (!empty($item)) {
                        if (isset($filter->unpack_params)) $filter = $filter->unpack_params;
                        else if (isset($filter->with_related)) {
                            $value = $filter->with_related;
                            $filter = new stdClass;
                            $filter->with_related = $value;
                        }
                        $this->unpack($item, $filter);
                    }
                }
            }
            return !empty($item);
        }



        // ===================================================================
        /**
        *  Обновление / добавление записи в базе данных
        *
        *  @access  public
        *  @param   object  $item   объект записи (содержит изменившиеся поля):
        *                               ->indifferent_caches = TRUE если не очищать кеши
        *  @param   mixed   $slave  FALSE если запись основной таблицы (по умолчанию FALSE)
        *                           TRUE если запись первой зависимой таблицы
        *                           ЧИСЛО если запись такой по счету таблицы
        *  @return  integer         идентификатор обработанной записи
        *                           пустая строка если ошибка
        */
        // ===================================================================

        public function update ( & $item, $slave = FALSE ) {
            $dbtable = $this->getDBTable($slave);
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' update');
            $id = '';
            if (!empty($item)) {
                if ($this->hasFields($slave)) {
                    $index = $slave === FALSE ? 1 : ($slave === TRUE ? 2 : intval($slave));
                    $index--;

                    // готовим изменившиеся поля
                    $fields = array();
                    $values = array();
                    foreach ($this->fields[$index] as $field => $info) {
                        if ($this->provideFieldInfo($field, $info)) {
                            if ($info['handler'] != '') {
                                $handler = $info['handler'];
                                $this->prepareField($item, $field, $info['type_std'], $fields, $values, $this->$handler($item));
                            } else {
                                $this->prepareField($item, $field, $info['type_std'], $fields, $values);
                            }
                        }
                    }

                    // обновляем / добавляем запись
                    if (!empty($fields)) {
                        $idfield = $this->getIDField($slave);
                        $this->prepareField($item, $idfield, 'integer', $fields, $values);
                        $id = $this->cms->db->update_record($item, $dbtable, $idfield, $fields, $values);

                        // если выполнено и это запись основной таблицы
                        if (!empty($id) && $index == 0) {

                            // обновляем данные, связанные с этой записью
                            $this->updateRest($id, $item);

                            // очищаем зависимые кеш-таблицы
                            $this->resetCaches($item);
                        }
                    }
                }
            }

            // возвращаем идентификатор обновленной / добавленной записи
            $this->cms->db->close_tracing_method();
            return $id;
        }



        // ===================================================================
        /**
        *  Обновление данных, связанных с записью
        *
        *  @access  protected
        *  @param   integer $id     идентификатор изменившейся записи
        *  @param   object  $item   объект записи (содержит изменившиеся поля)
        *  @return  void
        */
        // ===================================================================

        protected function updateRest ( $id, & $item ) {
        }



        // ===================================================================
        /**
        *  Заполнение таблицы минимально необходимыми записями
        *
        *  @access  public
        *  @param   string  $dbtable    имя таблицы
        *  @param   string  $idfield    имя колонки идентификатора
        *  @param   integer $number     номер таблицы в списке таблиц модели
        *  @return  void
        */
        // ===================================================================

        public function setup ( $dbtable, $idfield, $number ) {
        }



        // ===================================================================
        /**
        *  Проверка / создание / поправка таблиц
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function check () {
            $first = FALSE;
            for ($number = 1; $number <= 10; $number++) {
                $dbtable = $this->getDBTable($number);
                if ($dbtable == '' || $dbtable == 'undefined') break;
                $idfield = $this->getIDField($number);
                if ($idfield == '' || $idfield == 'undefined_id') break;

                if (!$first) {
                    $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' check');
                    $first = TRUE;
                }

                // проверяем наличие таблицы, при отсутствии создаем
                $columns = $this->cms->db->get_dbtable_fields($dbtable);
                if (empty($columns)) {
                    $this->cms->db->query('CREATE TABLE IF NOT EXISTS `' . $dbtable . '` '
                                                                  . '(`' . $idfield . '` BIGINT(20) NOT NULL) '
                                        . 'ENGINE = MyISAM '
                                        . 'DEFAULT CHARSET = utf8 '
                                        . 'AUTO_INCREMENT = 1;');
                }

                // проверяем наличие нужных колонок, при отсутствии формируем соответствующие запросы
                $query = array();
                $subquery = array();
                if (!isset($columns[$idfield])) {
                    $query[] = 'ADD `' . $idfield . '` BIGINT(20) NOT NULL';
                    $query[] = 'DROP PRIMARY KEY';
                    $query[] = '>SET @a := 0';
                    $query[] = '>UPDATE `' . $dbtable . '` SET `' . $idfield . '` = @a := @a + 1';
                    $query[] = 'ADD PRIMARY KEY (`' . $idfield . '`)';
                    $query[] = 'CHANGE `' . $idfield . '` `' . $idfield . '` BIGINT(20) '
                                                                          . 'NOT NULL '
                                                                          . 'AUTO_INCREMENT '
                                                                          . 'COMMENT "Идентификатор записи"';
                // ИД записи
                } else {
                    $name = $idfield;
                    $type = 'BIGINT(20)';
                    $command = $this->cms->db->check_field($columns, $name, $type);
                    if ($command != '') $query[] = $command . ' `' . $name . '` ' . $type . ' '
                                                                                  . 'NOT NULL '
                                                                                  . 'AUTO_INCREMENT '
                                                                                  . 'COMMENT "Идентификатор записи"';
                }

                // остальные поля
                if ($this->hasFields($number)) {
                    foreach ($this->fields[$number - 1] as $name => $info) {
                        if ($this->provideFieldInfo($name, $info)) {
                            $type = $info['type'];
                            $command = $this->cms->db->check_field($columns, $name, $type);
                            if ($command != '') $query[] = $command . ' `' . $name . '` ' . $type . rtrim(' ' . $info['params']);
                            if ($info['index'] && !$this->cms->db->check_key($columns, $name)) $this->cms->db->add_key($query, $name);
                            if (!empty($info['fix'])) {
                                switch ($name) {
                                    case 'url':
                                        $subquery[] = 'UPDATE `' . $dbtable . '` '
                                                    . 'SET `' . $name . '` = `' . $idfield . '` '
                                                    . 'WHERE TRIM(`' . $name . '`) = \'\' '
                                                          . 'OR TRIM(`' . $name . '`) = \'0\' '
                                                          . 'OR `' . $name . '` IS NULL;';
                                        break;
                                    case 'position':
                                    case 'order_num':
                                        $subquery[] = 'UPDATE `' . $dbtable . '` '
                                                    . 'SET `' . $name . '` = `' . $idfield . '` '
                                                    . 'WHERE `' . $name . '` = 0 '
                                                           . 'OR `' . $name . '` IS NULL;';
                                        break;
                                }
                            }
                        }
                    }
                }

                // выполняем сформированные запросы
                foreach ($query as & $command) {
                    if (trim($command) != '') {
                        if (substr($command, 0, 1) == '>') {
                            $command = trim(substr($command, 1));
                            if ($command != '') $command .= ';';
                        } else {
                            $command = 'ALTER TABLE `' . $dbtable . '` ' . $command . ';';
                        }
                        if ($command != '') $this->cms->db->query($command);
                    }
                }
                foreach ($subquery as & $command) {
                    if (trim($command) != '') $this->cms->db->query($command);
                }

                // если таблица не существовала, проверяем наличие минимально необходимых записей
                if (empty($columns)) $this->setup($dbtable, $idfield, $number);
            }
            if ($first) $this->cms->db->close_tracing_method();
        }
    }



    return;
?>