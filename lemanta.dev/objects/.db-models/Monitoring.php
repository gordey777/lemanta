<?php
    // макет модели базы данных
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Мониторинг: модель базы данных
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class MonitoringDBModel extends BasicDBModel {

        // имя основной таблицы (массив если список таблиц: основная и зависимые),
        // поле идентификатора записи (массив если список полей: основной таблицы и зависимых)
        public $dbtable = 'monitoring';
        public $id_field = 'monitoringId';

        // список полей: основной таблицы и зависимых
        protected $fields = array(
            array(
                'scanable'   => array('type' => 'TINYINT(1)',
                                      'params' => 'DEFAULT 1 NOT NULL COMMENT "Признак Разрешен к мониторингу"'),

                'target'     => array('type' => 'VARCHAR(32)',
                                      'params' => 'DEFAULT "" NOT NULL COMMENT "Целевой сайт"'),

                'lifetime'   => array('type' => 'INT(11)',
                                      'params' => 'DEFAULT 0 NOT NULL COMMENT "Срок обновления"',
                                      'index' => FALSE),

                'lasttime'   => array('type' => 'INT(11)',
                                      'params' => 'DEFAULT 0 NOT NULL COMMENT "Штамп времени последнего мониторинга"',
                                      'index' => FALSE),

                'ourId'      => array('type' => 'BIGINT(20)',
                                      'params' => 'DEFAULT 0 NOT NULL COMMENT "Идентификатор нашего элемента"'),

                'ourType'    => array('type' => 'VARCHAR(24)',
                                      'params' => 'DEFAULT "" NOT NULL COMMENT "Тип нашего элемента"'),

                'theirUrl'   => array('type' => 'VARCHAR(511)',
                                      'params' => 'DEFAULT "" NOT NULL COMMENT "Адрес сканируемой страницы"'),

                'theirName'  => array('type' => 'VARCHAR(255)',
                                      'params' => 'DEFAULT "" NOT NULL COMMENT "Название сканируемого элемента"'),

                'theirImage' => array('type' => 'VARCHAR(511)',
                                      'params' => 'DEFAULT "" NOT NULL COMMENT "Фото сканируемого элемента"',
                                      'index' => FALSE),

                'theirPrice' => array('type' => 'FLOAT(17,4)',
                                      'params' => 'DEFAULT 0 NOT NULL COMMENT "Цена сканируемого элемента"',
                                      'index' => FALSE)
            )
        );
    }



    return;
?>