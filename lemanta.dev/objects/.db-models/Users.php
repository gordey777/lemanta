<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Пользователи: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class UsersDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'users';
        public $id_field = 'user_id';

        // массив списков полей таблиц (основной и зависимых)
        protected $fields = array(
            array(
                // имя
                'name'              => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Фамилия, отчество, имя"',
                                             'handler' => 'packedUserName'),

                'nickname',         // ник
                'birthday',         // дата рождения
                'email',            // емейл
                'email2',           // емейл (дополнительный)
                'phone',            // телефон
                'phone2',           // телефон (дополнительный)
                'icq',              // icq
                'icq2',             // icq (дополнительный)
                'skype',            // скайп
                'skype2',           // скайп (дополнительный)
                'country_id',       // ИД страны
                'region_id',        // ИД области
                'town_id',          // ИД города
                'school_id',        // ИД учебного заведения
                'class_id',         // ИД класса учебного заведения

                // сведения об оценках
                'grades'            => array('type' => 'LONGTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Сведения об оценках"',
                                             'index' => FALSE),

                'address',          // адрес
                'address2',         // адрес (дополнительный)
                'enabled',          // разрешена

                // клиент ли магазина
                'used_shop'         => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT "1" NOT NULL COMMENT "Признак Является клиентом магазина"'),
                // пользователь ли СМС дневника
                'used_dnevnik'      => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT "0" NOT NULL COMMENT "Признак Является пользователем СМС дневника"'),
                // пользователь ли соцсети
                'used_social'       => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT "0" NOT NULL COMMENT "Признак Является пользователем соцсети магазина"'),

                'password',         // пароль
                'group_id',         // ИД группы скидок
                'price_id',         // ИД ценовой группы
                'coupon_id',        // ИД скидочного купона

                // юридическое лицо
                'juridical'         => array('type' => 'TINYINT(1)',
                                             'params' => 'DEFAULT 0 NOT NULL COMMENT "Признак Является юридическим лицом"'),
                // юридический адрес
                'juridicaladdress'  => array('type' => 'VARCHAR(512)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Юридический адрес"'),
                // налоговый номер
                'fiscalnum'         => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Налоговый номер"'),
                // банк
                'bank'              => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Банк"'),
                // расчетный счет
                'bankaccount'       => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Расчетный счет"'),
                // мфо банка
                'bankmfo'           => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "МФО банка"'),
                // окпо банка
                'bankokpo'          => array('type' => 'VARCHAR(256)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "ОКПО банка"'),
                // номер карточки
                'card_num'          => array('type' => 'VARCHAR(32)',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Номер карточки в картотеке магазина"'),
                // заметки администрации
                'remark'            => array('type' => 'TEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Заметки администрации"',
                                             'index' => FALSE),
                // сумма на внутреннем счете
                'cash'              => array('type' => 'FLOAT(12,4)',
                                             'params' => 'DEFAULT 0.0 NOT NULL COMMENT "Сумма на внутреннем счете"',
                                             'index' => FALSE),

                'affiliate_id',     // ИД реферала
                'subdomain',        // субдомен
                'subdomain_enabled',// разрешен ли субдомен
                'subdomain_html',   // контент субдомена
                'template',         // шаблон

                // сведениях о пополнениях счета
                'charges'           => array('type' => 'MEDIUMTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Сведения о пополнениях счета"',
                                             'handler' => 'packedUserCharges',
                                             'index' => FALSE),

                // сведениях о реферальной активности
                'referals'          => array('type' => 'MEDIUMTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Сведения о реферальной активности"',
                                             'handler' => 'packedUserReferals',
                                             'index' => FALSE),
                // сведениях о партнерских регистрациях
                'regs'              => array('type' => 'MEDIUMTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Сведения о партнерских регистрациях"',
                                             'handler' => 'packedUserRegs',
                                             'index' => FALSE),
                // сведениях о комиссионных отчислениях
                'commissions'       => array('type' => 'MEDIUMTEXT',
                                             'params' => 'DEFAULT "" NOT NULL COMMENT "Сведения о комиссионных отчислениях"',
                                             'handler' => 'packedUserCommissions',
                                             'index' => FALSE),

                'images',           // фото
                'images_alts',      // надписи фото
                'images_texts',     // описания фото
                'images_view',      // слайдинг-признаки
                'remote_token',     // аутентификатор действия
                'created',          // создано
                'modified',         // изменено
                'ip',               // ip-адрес
                'deleted'           // удалена
            )
        );

        // список оперативных ссылок админпанели
        protected $operables_list = 'Users';
        protected $operables_card = 'User';
        protected $operables = array('delete', 'edit',
                                     'enable');



        // =======================================================================
        // Выбрать из базы данных записи о пользователях согласно параметрам (опциональные взяты в квадратные скобки):
        //   $items = результат будет помещен в эту переменную
        //   [$items_list] = результат в виде плоского списка будет помещен в эту переменную
        //   [$params->sort] = способ сортировки записей
        //   [$params->sort_direction] = направление сортировки
        //   [$params->sort_laconical] = признак лаконичного режима сортировки
        //   [$params->search] = искомый текст
        //   [$params->search_date_from] = искомая дата от
        //   [$params->search_date_to] = искомая дата до
        //   [$params->ids] = идентификаторы пользователей (перечисленные через запятую)
        //   [$params->group_id] = идентификатор группы
        //   [$params->affiliate_id] = идентификатор привевшего партнера
        //   [$params->country_id] = идентификатор страны
        //   [$params->region_id] = идентификатор области
        //   [$params->town_id] = идентификатор города
        //   [$params->school_id] = идентификатор учебного заведения
        //   [$params->class_id] = идентификатор класса учебного заведения
        //   [$params->enabled] = признак "разрешена" запись
        //   [$params->used_shop] = признак "используется в интернет-магазине"
        //   [$params->used_dnevnik] = признак "используется в СМС дневнике"
        //   [$params->used_social] = признак "используется в социальной сети"
        //   [$params->domained] = признак "имеет субдомен"
        //   [$params->subdomain_enabled] = признак "субдомен разрешен"
        //   [$params->template] = имя шаблона отображения страницы
        //   [$params->imaged] = с загруженными изображениями
        //   [$params->start] = начиная с такой позиции
        //   [$params->maxcount] = не более такого количества
        // =======================================================================

        public function get ( & $items, $params = null, & $flatlist = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' get');

            $items = array();
            $where = '';
            $having = '';
            $order = '';
            $limit = '';

            // запоминаем направление сортировки и режим лаконичности
            $direction = !empty($params->sort_direction) ? 'DESC ' : 'ASC ';
            $laconical = !empty($params->sort_laconical);

            // фильтруем по искомому тексту
            $separator = '|';
            if (isset($params->search) && $params->search != '') {
                // анализируем искомый текст в 2 прохода (1 проход - префиксные команды, 2 проход - отдельные слова)
                for ($pass = 1; $pass <= 2; $pass++ ) {
                    if ($pass == 1) {
                        $keywords = array(trim($params->search));
                    } else {
                        // в искомом тексте обрабатываем лишь 4 первых слова
                        $keywords = preg_split('/\s+/', trim($params->search), 4);
                    }
                    $found = FALSE;
                    foreach ($keywords as $keyword) {
                        // если слово более 2 букв
                        if (strlen($keyword) > 2) {
                            // просто слова обрабатываем не на 1 проходе
                            if ($pass != 1) {
                                $keyword = $this->cms->db->query_value($keyword);
                                $where .= 'AND (`' . $dbtable . '`.`' . $idfield . '` = "' . $keyword . '" '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`name`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                           . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $keyword . '", "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`name`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                           . 'LIKE "%' . $keyword . '%" '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`address`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                           . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $keyword . '", "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`address`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                           . 'LIKE "%' . $keyword . '%" '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`address2`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                           . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $keyword . '", "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`address2`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                           . 'LIKE "%' . $keyword . '%" '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`phone`, "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                           . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $keyword . '", "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                        . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`phone2`, "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                           . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $keyword . '", "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                        . 'OR LCASE(`' . $dbtable . '`.`email`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(`' . $dbtable . '`.`email2`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(`' . $dbtable . '`.`icq`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(`' . $dbtable . '`.`icq2`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(`' . $dbtable . '`.`skype`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(`' . $dbtable . '`.`skype2`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(`' . $dbtable . '`.`nickname`) = LCASE("' . $keyword . '") '
                                        . 'OR LCASE(TRIM(LEFT(`' . $dbtable . '`.`ip`, ' . (strlen($keyword) + 1) . '))) = LCASE("' . $keyword . '")) ';
                                $found = TRUE;
                                continue;
                            }
                            // если есть префиксная команда поиска по имени
                            $command = strtolower(SEARCH_USERS_COMMAND_NAME);
                            $size = strlen($command);
                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                $keyword = trim(substr($keyword, $size));
                                if ($keyword != '') $where .= 'AND LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`name`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                                                . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $this->cms->db->query_value($keyword) . '", "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) ';
                                $found = TRUE;
                            } else {
                                // если есть префиксная команда поиска по адресу
                                $command = strtolower(SEARCH_USERS_COMMAND_ADDRESS);
                                $size = strlen($command);
                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                    $keyword = trim(substr($keyword, $size));
                                    if ($keyword != '') $where .= 'AND (LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`address`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                                                     . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $this->cms->db->query_value($keyword) . '", "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                                                  . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`address2`, "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", "")) '
                                                                     . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $this->cms->db->query_value($keyword) . '", "' . $separator . '", ""), " ", ""), ",", ""), ".", ""), "-", ""), "+", ""), "_", ""), "(", ""), ")", ""))) ';
                                    $found = TRUE;
                                } else {
                                    // если есть префиксная команда поиска по телефону
                                    $command = strtolower(SEARCH_USERS_COMMAND_PHONE);
                                    $size = strlen($command);
                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                        $keyword = trim(substr($keyword, $size));
                                        if ($keyword != '') $where .= 'AND (LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`phone`, "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                                                         . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $this->cms->db->query_value($keyword) . '", "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                                                      . 'OR LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`' . $dbtable . '`.`phone2`, "-" , ""), "+", ""), "(", ""), ")", ""), " ", "")) '
                                                                         . '= LCASE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE("' . $this->cms->db->query_value($keyword) . '", "-" , ""), "+", ""), "(", ""), ")", ""), " ", ""))) ';
                                        $found = TRUE;
                                    } else {
                                        // если есть префиксная команда поиска по емейлу
                                        $command = strtolower(SEARCH_USERS_COMMAND_EMAIL);
                                        $size = strlen($command);
                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                            $keyword = trim(substr($keyword, $size));
                                            if ($keyword != '') $where .= 'AND (LCASE(`' . $dbtable . '`.`email`) = LCASE("' . $this->cms->db->query_value($keyword) . '") OR LCASE(`' . $dbtable . '`.`email2`) = LCASE("' . $this->cms->db->query_value($keyword) . '")) ';
                                            $found = TRUE;
                                        } else {
                                            // если есть префиксная команда поиска по ICQ
                                            $command = strtolower(SEARCH_USERS_COMMAND_ICQ);
                                            $size = strlen($command);
                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                $keyword = trim(substr($keyword, $size));
                                                if ($keyword != '') $where .= 'AND (LCASE(`' . $dbtable . '`.`icq`) = LCASE("' . $this->cms->db->query_value($keyword) . '") OR LCASE(`' . $dbtable . '`.`icq2`) = LCASE("' . $this->cms->db->query_value($keyword) . '")) ';
                                                $found = TRUE;
                                            } else {
                                                // если есть префиксная команда поиска по скайпу
                                                $command = strtolower(SEARCH_USERS_COMMAND_SKYPE);
                                                $size = strlen($command);
                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                    $keyword = trim(substr($keyword, $size));
                                                    if ($keyword != '') $where .= 'AND (LCASE(`' . $dbtable . '`.`skype`) = LCASE("' . $this->cms->db->query_value($keyword) . '") OR LCASE(`' . $dbtable . '`.`skype2`) = LCASE("' . $this->cms->db->query_value($keyword) . '")) ';
                                                    $found = TRUE;
                                                } else {
                                                    // если есть префиксная команда поиска по IP-адресу
                                                    $command = strtolower(SEARCH_USERS_COMMAND_IP);
                                                    $size = strlen($command);
                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                        $keyword = trim(substr($keyword, $size));
                                                        if ($keyword != "") {
                                                            $keyword = $this->cms->db->query_value($keyword);
                                                            $where .= 'AND LCASE(TRIM(LEFT(`' . $dbtable . '`.`ip`, ' . (strlen($keyword) + 1) . '))) = LCASE("' . $keyword . '") ';
                                                        }
                                                        $found = TRUE;
                                                    } else {
                                                        // если есть префиксная команда поиска по дате регистрации
                                                        $command = strtolower(SEARCH_USERS_COMMAND_CREATED);
                                                        $size = strlen($command);
                                                        if ($command == strtolower(substr($keyword, 0, $size))) {
                                                            $keyword = trim(substr($keyword, $size));
                                                            if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $dbtable . '`.`created`, "%Y-%m-%d") = "' . $this->cms->db->query_value($keyword) . '" ';
                                                            $found = TRUE;
                                                        } else {
                                                            // если есть префиксная команда поиска по дате исправления
                                                            $command = strtolower(SEARCH_USERS_COMMAND_MODIFIED);
                                                            $size = strlen($command);
                                                            if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                $keyword = trim(substr($keyword, $size));
                                                                if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $dbtable . '`.`modified`, "%Y-%m-%d") = "' . $this->cms->db->query_value($keyword) . '" ';
                                                                $found = TRUE;
                                                            } else {
                                                                // если есть префиксная команда поиска по дате рождения
                                                                $command = strtolower(SEARCH_USERS_COMMAND_BIRTHDAY);
                                                                $size = strlen($command);
                                                                if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                    $keyword = trim(substr($keyword, $size));
                                                                    if ($keyword != '') $where .= 'AND DATE_FORMAT(`' . $dbtable . '`.`birthday`, "%Y-%m-%d") = "' . $this->cms->db->query_value($keyword) . '" ';
                                                                    $found = TRUE;
                                                                } else {
                                                                    // если есть префиксная команда поиска по идентификатору пользователя
                                                                    $command = strtolower(SEARCH_USERS_COMMAND_USER_ID);
                                                                    $size = strlen($command);
                                                                    if ($command == strtolower(substr($keyword, 0, $size))) {
                                                                        $keyword = trim(substr($keyword, $size));
                                                                        if ($keyword != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` = "' . $this->cms->db->query_value($keyword) . '" ';
                                                                        $found = TRUE;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // если на каком-то из проходов найдено поисковое условие, прекращаем обработку
                    if ($found) break;
                }
            }

            // фильтруем по искомой дате
            if (isset($params->search_date_from)) $where .= 'AND `' . $dbtable . '`.`created` >= "' . $this->cms->db->query_value($params->search_date_from) . ' 00:00:00" ';
            if (isset($params->search_date_to)) $where .= 'AND `' . $dbtable . '`.`created` <= "' . $this->cms->db->query_value($params->search_date_to) . ' 23:59:59" ';

            // сортируем указанным способом
            if (isset($params->sort)) {
                switch ($params->sort) {
                    case SORT_USERS_MODE_BY_NAME:
                        $order = 'SUBSTRING_INDEX(`' . $dbtable . '`.`name`, "' . $separator . '", 1) ASC, '
                               . 'SUBSTRING_INDEX(`' . $dbtable . '`.`name`, "' . $separator . '", -1) ASC, '
                               . 'SUBSTRING_INDEX(SUBSTRING_INDEX(`' . $dbtable . '`.`name`, "' . $separator . '", -2), "' . $separator . '", 1) ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`name`) != "" ';
                        break;
                    case SORT_USERS_MODE_BY_EMAIL:
                        $order = '`' . $dbtable . '`.`email` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`email`) != "" ';
                        break;
                    case SORT_USERS_MODE_BY_PHONE:
                        $order = '`' . $dbtable . '`.`phone` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`phone`) != "" ';
                        break;
                    case SORT_USERS_MODE_BY_ICQ:
                        $order = '`' . $dbtable . '`.`icq` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`icq`) != "" ';
                        break;
                    case SORT_USERS_MODE_BY_SKYPE:
                        $order = '`' . $dbtable . '`.`skype` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`' . $dbtable . '`.`skype`) != "" ';
                        break;
                    case SORT_USERS_MODE_BY_GROUP:
                        $order = '`group_name` ' . $direction . ', '
                               . '`' . $dbtable . '`.`group_id` ' . $direction . ', '
                               . 'SUBSTRING_INDEX(`' . $dbtable . '`.`name`, "' . $separator . '", 1) ASC, '
                               . 'SUBSTRING_INDEX(`' . $dbtable . '`.`name`, "' . $separator . '", -1) ASC, '
                               . 'SUBSTRING_INDEX(SUBSTRING_INDEX(`' . $dbtable . '`.`name`, "' . $separator . '", -2), "' . $separator . '", 1) ASC, '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND TRIM(`groups`.`name`) != "" ';
                        break;
                    case SORT_USERS_MODE_BY_CASH:
                        $order = '`' . $dbtable . '`.`cash` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`cash` > 0 ';
                        break;
                    case SORT_USERS_MODE_BY_ORDERS:
                        $order = '`orders_num` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $having .= 'AND COUNT(`orders`.`order_id`) > 0 ';
                        break;
                    case SORT_USERS_MODE_BY_MODIFIED:
                        $order = '`' . $dbtable . '`.`modified` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`modified` IS NOT NULL '
                                                . 'AND `' . $dbtable . '`.`modified` != "0000-00-00 00:00:00" '
                                                . 'AND `' . $dbtable . '`.`modified` != `' . $dbtable . '`.`created` ';
                        break;
                    case SORT_USERS_MODE_BY_BIRTHDAY:
                        $order = '`' . $dbtable . '`.`birthday` ' . $direction . ', '
                               . '`' . $dbtable . '`.`created` DESC ';
                        if ($laconical) $where .= 'AND `' . $dbtable . '`.`birthday` IS NOT NULL '
                                                . 'AND `' . $dbtable . '`.`birthday` != "0000-00-00 00:00:00" ';
                        break;
                    case SORT_USERS_MODE_BY_CREATED:
                    case SORT_USERS_MODE_AS_IS:
                    default:
                        $order = '`' . $dbtable . '`.`created` ' . $direction . ' ';
                }
                $order = 'ORDER BY ' . $order;
            }

            // фильтруем по запрошенным параметрам
            if (isset($params->ids) && $params->ids != '') $where .= 'AND `' . $dbtable . '`.`' . $idfield . '` IN ("' . str_replace(',', '","', $this->cms->db->query_value($params->ids)) . '") ';
            if (isset($params->group_id)) {
                if ($params->group_id != SELECT_RECORDS_PARAM_INVALID_ID) {
                    $where .= 'AND `' . $dbtable . '`.`group_id` = "' . $this->cms->db->query_value($params->group_id) . '" ';
                } else {
                    $where .= 'AND `' . $dbtable . '`.`group_id` != 0 ';
                    $having .= 'AND `groups`.`name` IS NULL ';
                }
            }
            if (isset($params->affiliate_id)) $where .= 'AND `' . $dbtable . '`.`affiliate_id` = "' . $this->cms->db->query_value($params->affiliate_id) . '" ';
            if (isset($params->country_id)) $where .= 'AND `' . $dbtable . '`.`country_id` = "' . $this->cms->db->query_value($params->country_id) . '" ';
            if (isset($params->region_id)) $where .= 'AND `' . $dbtable . '`.`region_id` = "' . $this->cms->db->query_value($params->region_id) . '" ';
            if (isset($params->town_id)) $where .= 'AND `' . $dbtable . '`.`town_id` = "' . $this->cms->db->query_value($params->town_id) . '" ';
            if (isset($params->school_id)) $where .= 'AND `' . $dbtable . '`.`school_id` = "' . $this->cms->db->query_value($params->school_id) . '" ';
            if (isset($params->class_id)) $where .= 'AND `' . $dbtable . '`.`class_id` = "' . $this->cms->db->query_value($params->class_id) . '" ';
            if (isset($params->enabled)) $where .= 'AND `' . $dbtable . '`.`enabled` = "' . $this->cms->db->query_value($params->enabled) . '" ';
            if (isset($params->used_shop)) $where .= 'AND `' . $dbtable . '`.`used_shop` = "' . $this->cms->db->query_value($params->used_shop) . '" ';
            if (isset($params->used_dnevnik)) $where .= 'AND `' . $dbtable . '`.`used_dnevnik` = "' . $this->cms->db->query_value($params->used_dnevnik) . '" ';
            if (isset($params->used_social)) $where .= 'AND `' . $dbtable . '`.`used_social` = "' . $this->cms->db->query_value($params->used_social) . '" ';
            if (isset($params->domained)) $where .= 'AND TRIM(`' . $dbtable . '`.`subdomain`) != "" AND `' . $dbtable . '`.`subdomain_enabled` = 1 ';
            if (isset($params->subdomain_enabled)) $where .= 'AND `' . $dbtable . '`.`subdomain_enabled` = "' . $this->cms->db->query_value($params->subdomain_enabled) . '" ';
            if (isset($params->template)) $where .= 'AND `' . $dbtable . '`.`template` = "' . $this->cms->db->query_value($params->template) . '" ';
            if (isset($params->imaged)) $where .= 'AND TRIM(REPLACE(`' . $dbtable . '`.`images`, "' . $separator . '", "")) != "" ';
            if ($where != '') $where = 'WHERE 1 ' . $where;
            if ($having != '') $having = 'HAVING 1 ' . $having;

            // формируем параметр LIMIT запроса
            $limit = $this->limit($params);

            // делаем запрос
            $query = 'SELECT SQL_CALC_FOUND_ROWS `' . $dbtable . '`.*, '
                                              . '`groups`.`discount` AS `discount`, '
                                              . '`groups`.`name` AS `group_name`, '
                                              . 'COUNT(`orders`.`order_id`) AS `orders_num`, '
                                              . '`countries`.`name` AS `country`, '
                                              . '`regions`.`name` AS `region`, '
                                              . '`towns`.`name` AS `town`, '
                                              . '`schools`.`name` AS `school` '
                   . 'FROM `' . $dbtable . '` '
                   . 'LEFT JOIN `groups` ON `groups`.`group_id` = `' . $dbtable . '`.`group_id` '
                   . 'LEFT JOIN `orders` ON `orders`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` '
                   . 'LEFT JOIN `countries` ON `countries`.`country_id` = `' . $dbtable . '`.`country_id` '
                   . 'LEFT JOIN `regions` ON `regions`.`region_id` = `' . $dbtable . '`.`region_id` '
                   . 'LEFT JOIN `towns` ON `towns`.`town_id` = `' . $dbtable . '`.`town_id` '
                   . 'LEFT JOIN `schools` ON `schools`.`school_id` = `' . $dbtable . '`.`school_id` '
                   . $where
                   . 'GROUP BY `' . $dbtable . '`.`' . $idfield . '` '
                   . $having
                   . $order
                   . $limit . ';';
            $result = $this->cms->db->query($query);

            // поправляем поля записей
            if (!empty($result)) {
                while ($item = $this->cms->db->fetch_object($result)) {
                    $this->unpack($item, $params);
                    $items[$item->$idfield] = $item;
                }
            }

            // берем полное количество подобных записей
            $result2 = $this->cms->db->query('SELECT FOUND_ROWS() AS `count`;');
            $count = $this->cms->db->result();
            $count = isset($count->count) ? $count->count : 0;

            // освобождаем память от запроса
            $this->cms->db->free_result($result);
            $this->cms->db->free_result($result2);

            // возвращаем количество записей
            $this->cms->db->close_tracing_method();
            return $count;
        }



        // ===================================================================
        /**
        *  Чтение записи из базы данных
        *
        *  @access  public
        *  @param   object  $item       объект записи (будет возвращен в эту переменную)
        *  @param   object  $filter     фильтр по каким полям отбирать
        *  @return  boolean             TRUE если прочитано
        *                               FALSE если ошибка или запись не найдена
        */
        // ===================================================================

        public function one ( & $item, $filter = null ) {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $filter->select = 'SELECT `' . $dbtable . '`.*, '
                                   . '`groups`.`discount` AS `discount`, '
                                   . '`groups`.`name` AS `group_name`, '
                                   . 'COUNT(`orders`.`order_id`) AS `orders_num`, '
                                   . '`countries`.`name` AS `country`, '
                                   . '`regions`.`name` AS `region`, '
                                   . '`towns`.`name` AS `town`, '
                                   . '`schools`.`name` AS `school`';
            $filter->join = 'LEFT JOIN `groups` ON `groups`.`group_id` = `' . $dbtable . '`.`group_id` '
                          . 'LEFT JOIN `orders` ON `orders`.`' . $idfield . '` = `' . $dbtable . '`.`' . $idfield . '` '
                          . 'LEFT JOIN `countries` ON `countries`.`country_id` = `' . $dbtable . '`.`country_id` '
                          . 'LEFT JOIN `regions` ON `regions`.`region_id` = `' . $dbtable . '`.`region_id` '
                          . 'LEFT JOIN `towns` ON `towns`.`town_id` = `' . $dbtable . '`.`town_id` '
                          . 'LEFT JOIN `schools` ON `schools`.`school_id` = `' . $dbtable . '`.`school_id`';
            $filter->group_by = 'GROUP BY `' . $dbtable . '`.`' . $idfield . '`';
            $filter->unpack_params = null;
            return parent::one($item, $filter);
        }



        // =======================================================================
        // Взять из базы данных емейлы пользователей:
        //   [$with_names] = признак брать емейлы с именами пользователей
        // =======================================================================

        public function getUserEmails ( $with_names = TRUE ) {
            $dbtable = $this->getDBTable();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' getUserEmails');

            // пока нет обработанных емейлов
            $crlf = "\r\n";
            $result = '';
            $passed = array();

            // на 1-ом проходе читаем из базы клиентов
            $passes = 1;
            $message = 'Registered user e-mails ----------------------------' . $crlf . $crlf;
            $query = 'SELECT `name`, '
                          . '`email`, '
                          . '`email2` '
                   . 'FROM `' . $dbtable . '` '
                   . 'WHERE `enabled` = 1 '
                         . 'AND (TRIM(`email`) != "" OR TRIM(`email2`) != "") '
                   . 'ORDER BY `' . ($with_names ? 'name' : 'email') . '` ASC;';

            // делаем проходы
            do {
                $resource = $this->cms->db->query($query);
                $users = $this->cms->db->results();

                // освобождаем память от запроса
                $this->cms->db->free_result($resource);

                // если есть прочитанные записи, перебираем их
                if (!empty($users)) {
                    foreach ($users as & $user) {

                        // выправляем поля записи о пользователе
                        $this->unpackUserName($user);

                        // если нужно брать с именами, обрабатываем составное имя, иначе очищаем его
                        if ($with_names) {
                            $user->compound_name = $this->text->asPlainSentence($user->compound_name);
                            if ($user->compound_name != '') $user->compound_name = '<' . $user->compound_name . '> ';
                        } else {
                            $user->compound_name = '';
                        }

                        // анализируем основной емейл, запоминая в обработанных
                        $user->email = $this->text->lowerCase(trim($user->email));
                        if ($user->email != '') {
                            if (!isset($passed[$user->email])) {
                                if (preg_match(EMAIL_CHECKING_PATTERN, $user->email)) {
                                    $result .= $message . $user->compound_name . $user->email . $crlf;
                                    $passed[$user->email] = TRUE;
                                    $message = '';
                                }
                            }
                        }

                        // анализируем дополнительный емейл, запоминая в обработанных
                        $user->email2 = $this->text->lowerCase(trim($user->email2));
                        if ($user->email2 != '' && $user->email2 != $user->email) {
                            if (!isset($passed[$user->email2])) {
                                if (preg_match(EMAIL_CHECKING_PATTERN, $user->email2)) {
                                    $result .= $message . $user->compound_name . $user->email2 . $crlf;
                                    $passed[$user->email2] = TRUE;
                                    $message = '';
                                }
                            }
                        }
                    }
                }

                // +1 проход сделан
                $passes++;
                if ($result != '' || $message != '') {
                    if ($passes == 2) {
                        $message = $crlf . $crlf . 'Other e-mails from orders ---------------------------' . $crlf . $crlf;
                    } else {
                        $message = $crlf . $crlf . 'Other e-mails from feedback --------------------------' . $crlf . $crlf;
                    }
                }

                // на 2-ом проходе читаем из заказов, на 3 проходе - из переписки
                if ($passes == 2) {
                    $query = 'SELECT `name`, '
                                  . '`email`, '
                                  . '`email2` '
                           . 'FROM `orders` '
                           . 'WHERE (TRIM(`email`) != "" OR TRIM(`email2`) != "") '
                           . 'ORDER BY `' . ($with_names ? 'name' : 'email') . '` ASC;';
                } else {
                    $query = 'SELECT `name`, '
                                  . '`email`, '
                                  . '`email` AS `email2` '
                                  . 'FROM `feedback` '
                                  . 'WHERE TRIM(`email`) != "" '
                                  . 'ORDER BY `' . ($with_names ? 'name' : 'email') . '` ASC;';
                }

            } while ($passes <= 3);

            // возвращаем результат
            $this->cms->db->close_tracing_method();
            return $result;
        }



        // ===================================================================
        /**
        *  Очистка кеш-таблицы и зависимых кешей
        *
        *  @access  public
        *  @param   object  $item       объект обрабатывавшейся записи (содержащей меняемые поля)
        *  @return  boolean             TRUE если наследнику надо выполнить команды очистки кеша
        */
        // ===================================================================

        public function resetCaches ( & $item = null ) {

            // может чистить не нужно?
            if (!parent::resetCaches($item)) return;
            $this->cms->db->open_tracing_method('DB ' . strtoupper($this->dbtable) . ' resetCaches');

            // очищаем нужные кеш-таблицы
            $tables = DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME . ', '
                    . DATABASE_CACHE_CATEGORIES_TABLENAME . ', '
                    . DATABASE_CACHE_BRANDS_TABLENAME;
            $this->cms->db->reset_dbtables($tables);

            $this->cms->db->close_tracing_method();
        }



        // ===================================================================
        /**
        *  Кеширование усеченной в размерах таблицы пользователей (Users ShortVersion)
        *
        *  @access  public
        *  @return  void
        */
        // ===================================================================

        public function cachingShortVersion () {
            $dbtable = $this->getDBTable();
            $idfield = $this->getIDField();
            $this->cms->db->open_tracing_method('DB ' . strtoupper($dbtable) . ' cachingShortVersion');

            // формируем SELECT (без вступительного слова SELECT и закрывающего ;)
            $select = '`' . $idfield . '`, '
                    . '`country_id`, '
                    . '`region_id`, '
                    . '`town_id`, '
                    . '`school_id`, '
                    . '`name` '
            . 'FROM `' . $dbtable . '`';

            // формируем список объявлений индексов
            $indexes = 'INDEX (`' . $idfield . '`), '
                     . 'INDEX (`country_id`), '
                     . 'INDEX (`region_id`), '
                     . 'INDEX (`town_id`), '
                     . 'INDEX (`school_id`)';

            // кешируем результаты запроса (разрешаем в памяти, так как таблица небольшая и не содержит BLOB/TEXT колонок)
            $this->cms->db->caching_SELECT($select,
                                           $dbtable,
                                           $indexes,
                                           DATABASE_CACHE_USERS_SHORTVERSION_TABLENAME,
                                           DATABASE_CACHE_USERS_SHORTVERSION_LIFETIME,
                                           TRUE);
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
            parent::unpack($item, $params);
            $this->unpackUserName($item);
            $this->unpackUserAddress($item);
            $this->unpackUserAddress($item, '2');
            $this->unpackImages($item);

            // преобразовываем поле пополнений счета в структурированный массив
            $separator = '[]';
            if (isset($item->charges) && !is_array($item->charges)) {
                if (!is_string($item->charges)) $item->charges = '';
                $values = explode($separator, $item->charges);
                $item->charges = array();
                foreach ($values as $value) {
                    $value = $this->registrar->unpackUserCashCharge($value);
                    if ($value !== FALSE) $item->charges[] = $value;
                }
                $item->charges = array_reverse($item->charges);
            }

            // преобразовываем поле партнерских приводов в структурированный массив
            if (isset($item->referals) && !is_array($item->referals)) {
                if (!is_string($item->referals)) $item->referals = '';
                $values = explode($separator, $item->referals);
                $item->referals = array();
                foreach ($values as $value) {
                    $value = $this->registrar->unpackUserCashReferal($value);
                    if ($value !== FALSE) $item->referals[] = $value;
                }
                $item->referals = array_reverse($item->referals);
            }

            // преобразовываем поле партнерских регистраций в структурированный массив
            if (isset($item->regs) && !is_array($item->regs)) {
                if (!is_string($item->regs)) $item->regs = '';
                $values = explode($separator, $item->regs);
                $item->regs = array();
                foreach ($values as $value) {
                    $value = $this->registrar->unpackUserCashReg($value);
                    if ($value !== FALSE) $item->regs[] = $value;
                }
                $item->regs = array_reverse($item->regs);
            }

            // преобразовываем поле партнерских комиссий в структурированный массив
            if (isset($item->commissions) && !is_array($item->commissions)) {
                if (!is_string($item->commissions)) $item->commissions = '';
                $values = explode($separator, $item->commissions);
                $item->commissions = array();
                foreach ($values as $value) {
                    $value = $this->registrar->unpackUserCashCommission($value);
                    if ($value !== FALSE) $item->commissions[] = $value;
                }
                $item->commissions = array_reverse($item->commissions);
            }

            // преобразовываем поле оценок
            if (isset($item->grades)) {
                if (is_string($item->grades)) {
                    try {
                        $item->grades = @ unserialize($item->grades);
                    } catch (Exception $e) {
                        $item->grades = array();
                    }
                }
                if (!is_array($item->grades)) $item->grades = array();
            }
        }
    }



    return;
?>