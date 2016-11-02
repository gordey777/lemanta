<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // индексы полей записи о пополнении внутреннего счета пользователя
    define('field_USERCASHCHARGE_TIMESTAMP', 0);
    define('field_USERCASHCHARGE_SUM', 1);
    define('field_USERCASHCHARGE_COMMENT', 2);
    define('field_USERCASHCHARGE_LASTFIELD', field_USERCASHCHARGE_COMMENT);

    // индексы полей записи о реферальном визите
    define('field_USERCASHREFERAL_TIMESTAMP', 0);
    define('field_USERCASHREFERAL_SUM', 1);
    define('field_USERCASHREFERAL_IP', 2);
    define('field_USERCASHREFERAL_URL', 3);
    define('field_USERCASHREFERAL_LASTFIELD', field_USERCASHREFERAL_URL);

    // индексы полей записи о регистрации пользователя
    define('field_USERCASHREG_TIMESTAMP', 0);
    define('field_USERCASHREG_SUM', 1);
    define('field_USERCASHREG_IP', 2);
    define('field_USERCASHREG_ID', 3);
    define('field_USERCASHREG_LASTFIELD', field_USERCASHREG_ID);

    define('field_USERCASHCOMMISSION_TIMESTAMP', 0);
    define('field_USERCASHCOMMISSION_SUM', 1);
    define('field_USERCASHCOMMISSION_ID', 2);
    define('field_USERCASHCOMMISSION_OSUM', 3);
    define('field_USERCASHCOMMISSION_COMMENT', 4);
    define('field_USERCASHCOMMISSION_LASTFIELD', field_USERCASHCOMMISSION_COMMENT);



    // =======================================================================
    /**
    *  Регистрационные действия
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class RegistrarANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Получение имени файла базы данных для фиксатора находящихся на сайте
        *
        *  @access  public
        *  @return  string          имя файла
        */
        // ===================================================================

        public function onSiteNowDbfile () {
            return 'now_on_site.txt';
        }



        // ===================================================================
        /**
        *  Фиксация находящегося на сайте
        *
        *  @access  public
        *  @param   integer $uid    ИД авторизованного пользователя
        *  @param   integer $users  всего авторизованных на сайте (будет возвращено в эту переменную)
        *  @return  integer         всего на сайте
        */
        // ===================================================================

        public function onSiteNow ( $uid, & $users ) {
            $marker = '!registered!';
            $prefix = $marker;

            // пока не знаем количества
            $total = 0;
            $users = 0;

            // неавторизованных отслеживаем по ИД сеанса
            if (empty($uid)) {
                $uid = $this->session->getSessionId();
                $prefix = '';
            }

            // слежение дополним по IP
            $ip = $this->request->getServerAsSentence('REMOTE_ADDR');

            // есть по чем отслеживать?
            if ($ip != '' || $uid != '') {

                // база данных
                $file = $this->cms->smarty->getCompileDir();
                $file = $this->hdd->closeSlash($file);
                $file .= $this->onSiteNowDbfile();

                $handle = @ fopen($file, 'rb+');
                if (!$handle) $handle = @ fopen($file, 'wb');
                if ($handle) {
                    @ flock($handle, LOCK_EX);

                    // храним в закрытом виде
                    $uid = $prefix . md5($ip . $uid);

                    // фиксируем активность в пределах 2 минут
                    $now = time();
                    $last = $now - 2 * 60;

                    // отслеживаем не более чужих активных (чтобы не перегружать)
                    $maximal = 150;

                    $size = strlen($marker);
                    $lines = array();
                    while ($maximal > 0 && !feof($handle)) {
                        $string = @ fgets($handle, 65536);
                        if (!is_string($string)) break;
                        $string = trim($string);
                        if ($string != '') {
                            if (($i = strpos($string, ' ')) !== FALSE) {
                                $time = @ intval(substr($string, $i + 1));
                                if ($time >= $last && $time <= $now) {

                                    // оставляем только активные чужие записи
                                    if (substr($string, 0, $i) != $uid) {
                                        $lines[] = $string;
                                        if (substr($string, 0, $size) == $marker) $users++;
                                        $total++;
                                        $maximal--;
                                    }
                                }
                            }
                        }
                    }

                    // сохраняем запись текущего + активные записи
                    array_unshift($lines, $uid . ' ' . $now);
                    if ($prefix == $marker) $users++;
                    $total++;
                    $string = trim(implode("\r\n", $lines)) . "\r\n";
                    $size = strlen($string);
                    @ fseek($handle, 0);
                    @ fwrite($handle, $string, $size);
                    @ ftruncate($handle, $size);
                    @ fclose($handle);
                }
            }
            return $total;
        }



        // ===================================================================
        /**
        *  Распаковка записи о пополнении внутреннего счета пользователя
        *
        *  @access  public
        *  @param   string  $rec    строковое представление записи
        *  @return  array           распакованная запись
        *                           FALSE если это не запись или она неактуальна
        */
        // ===================================================================

        public function unpackUserCashCharge ( $rec ) {

            // распаковываем
            $data = FALSE;
            if (is_string($rec)) {
                $rec = trim($rec);
                if ($rec != '') {
                    $rec = explode('|', $rec);
                    if (count($rec) > field_USERCASHCHARGE_LASTFIELD) {
                        $rec[field_USERCASHCHARGE_TIMESTAMP] = trim($rec[field_USERCASHCHARGE_TIMESTAMP]);
                    }
                }
            }

            // убеждаемся в актуальности записи (это точно запись, известна дата и ненулевое пополнение)
            if (is_array($rec) && count($rec) > field_USERCASHCHARGE_LASTFIELD) {
                if ($rec[field_USERCASHCHARGE_TIMESTAMP] !== '') {
                    $sum = $this->number->floatValue($rec[field_USERCASHCHARGE_SUM]);
                    if ($sum != 0) {
                        $data = array();
                        $data[field_USERCASHCHARGE_TIMESTAMP] = intval($rec[field_USERCASHCHARGE_TIMESTAMP]);
                        $data[field_USERCASHCHARGE_SUM] = $sum;
                        $data[field_USERCASHCHARGE_COMMENT] = trim($rec[field_USERCASHCHARGE_COMMENT]);
                    }
                }
            }
            return $data;
        }



        // ===================================================================
        /**
        *  Пополнение внутреннего счета пользователя
        *
        *  @access  public
        *  @param   object  $user       запись о пользователе
        *  @param   float   $sum        сумма пополнения (списания - если отрицательная)
        *  @param   string  $comment    комментарий к операции
        *  @return  boolean             TRUE если выполнено
        *                               FALSE если ничего не изменилось
        */
        // ===================================================================

        public function chargeUserCash ( & $user, $sum, $comment ) {
            if (!isset($user->charges) || !isset($user->cash)) return FALSE;
            $sum = round($this->number->floatValue($sum), 4);
            if ($sum == 0) return FALSE;
            $comment = $this->text->removeRecordsDelimiters($comment);
            $item = array();
            $item[field_USERCASHCHARGE_TIMESTAMP] = time();
            $item[field_USERCASHCHARGE_SUM] = $sum;
            $item[field_USERCASHCHARGE_COMMENT] = $comment;
            array_unshift($user->charges, $item);
            $user->cash += $sum;
            return TRUE;
        }



        // ===================================================================
        /**
        *  Регистрация пополнения внутреннего счета пользователя
        *
        *  @access  public
        *  @param   string  $uid        идентификатор пользователя
        *  @param   float   $sum        сумма пополнения (списания - если отрицательная)
        *  @param   string  $comment    комментарий к операции
        *  @return  void
        */
        // ===================================================================

        public function registerUserCashCharge ( $uid, $sum, $comment ) {
            if (is_string($uid) || is_integer($uid)) {
                $uid = rtrim(ltrim($uid, '! '));
                if (!empty($uid)) {
                    $sum = round($this->number->floatValue($sum), 4);
                    if ($sum != 0) {
                        $user = null;
                        $filter = new stdClass;
                        $filter->enabled = 1;
                        $filter->id = $uid;
                        $this->cms->db->users->one($user, $filter);
                        if (!empty($user)) {
                            if ($this->chargeUserCash($user, $sum, $comment)) {
                                $this->cms->db->users->update($user);
                            }
                        }
                    }
                }
            }
        }



        // ===================================================================
        /**
        *  Распаковка записи о реферальном визите
        *
        *  @access  public
        *  @param   string  $rec    строковое представление записи
        *  @return  array           распакованная запись
        *                           FALSE если это не запись или она неактуальна
        */
        // ===================================================================

        public function unpackUserCashReferal ( $rec ) {

            // распаковываем
            $data = FALSE;
            if (is_string($rec)) {
                $rec = trim($rec);
                if ($rec != '') {
                    $rec = explode('|', $rec);
                    if (count($rec) > field_USERCASHREFERAL_LASTFIELD) {
                        $rec[field_USERCASHREFERAL_TIMESTAMP] = trim($rec[field_USERCASHREFERAL_TIMESTAMP]);
                    }
                }
            }

            // убеждаемся в актуальности записи (это точно запись, известна дата, ip и положительное пополнение)
            if (is_array($rec) && count($rec) > field_USERCASHREFERAL_LASTFIELD) {
                if ($rec[field_USERCASHREFERAL_TIMESTAMP] !== '') {
                    $ip = trim($rec[field_USERCASHREFERAL_IP]);
                    if ($ip != '') {
                        $sum = $this->number->floatValue($rec[field_USERCASHREFERAL_SUM]);
                        if ($sum > 0) {
                            $data = array();
                            $data[field_USERCASHREFERAL_TIMESTAMP] = intval($rec[field_USERCASHREFERAL_TIMESTAMP]);
                            $data[field_USERCASHREFERAL_SUM] = $sum;
                            $data[field_USERCASHREFERAL_IP] = strtolower($ip);
                            $data[field_USERCASHREFERAL_URL] = trim($rec[field_USERCASHREFERAL_URL]);
                        }
                    }
                }
            }
            return $data;
        }



        // ===================================================================
        /**
        *  Пополнение внутреннего счета пользователя за реферальный визит
        *
        *  @access  public
        *  @param   object  $user   запись о пользователе
        *  @param   float   $sum    сумма пополнения
        *  @param   string  $ip     IP приглашенного посетителя
        *  @param   string  $url    адрес зазывающей страницы
        *  @return  boolean         TRUE если выполнено
        *                           FALSE если ничего не изменилось
        */
        // ===================================================================

        public function referalUserCash ( & $user, $sum, $ip, $url ) {
            if (!isset($user->referals) || !isset($user->cash)) return FALSE;
            $sum = round($this->number->floatValue($sum), 4);
            if ($sum <= 0) return FALSE;
            $ip = $this->text->removeRecordsDelimiters($ip);
            if ($ip == '') return FALSE;
            $url = $this->text->removeRecordsDelimiters($url);
            $item = array();
            $item[field_USERCASHREFERAL_TIMESTAMP] = time();
            $item[field_USERCASHREFERAL_SUM] = $sum;
            $item[field_USERCASHREFERAL_IP] = $ip;
            $item[field_USERCASHREFERAL_URL] = $url;
            array_unshift($user->referals, $item);
            $user->cash += $sum;
            return TRUE;
        }



        // ===================================================================
        /**
        *  Регистрация реферального визита
        *
        *  @access  public
        *  @param   string  $aid    идентификатор зазывающего пользователя
        *  @param   string  $url    адрес зазывающей страницы
        *  @return  void
        */
        // ===================================================================

        function registerReferal ( $aid, $url ) {
            if (is_string($aid) || is_integer($aid)) {
                $aid = rtrim(ltrim($aid, '! '));
                if (!empty($aid)) {
                    if ($this->settings->get('affiliates_enabled')) {
                        $sum = $this->settings->get('affiliates_referal_cost', 0);
                        $sum = round($this->number->floatValue($sum), 4);
                        if ($sum > 0) {
                            $ip = $this->reguest->getServer('REMOTE_ADDR');
                            if (is_string($ip)) {
                                $ip = $this->text->removeRecordsDelimiters($ip);
                                if ($ip != '') {
                                    $user = null;
                                    $filter = new stdClass;
                                    $filter->enabled = 1;
                                    $filter->id = $aid;
                                    $this->cms->db->users->one($user, $filter);
                                    if (!empty($user)) {
                                        $ip = strtolower($ip);
                                        $ok = TRUE;
                                        $lifetime = $this->settings->get('affiliates_referal_lifetime', 0);
                                        $lifetime = abs(@ intval($lifetime));
                                        $now = time();
                                        foreach ($user->referals as $item) {
                                            if ($ip == $item[field_USERCASHREFERAL_IP]) {
                                                if ($now >= $item[field_USERCASHREFERAL_TIMESTAMP]
                                                && $now <= $item[field_USERCASHREFERAL_TIMESTAMP] + $lifetime) {
                                                    $ok = FALSE;
                                                    break;
                                                }
                                            }
                                        }
                                        if ($ok) {
                                            if ($this->referalUserCash($user, $sum, $ip, $url)) {
                                                $this->cms->db->users->update($user);
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



        // ===================================================================
        /**
        *  Распаковка записи о регистрации пользователя
        *
        *  @access  public
        *  @param   string  $rec    строковое представление записи
        *  @return  array           распакованная запись
        *                           FALSE если это не запись или она неактуальна
        */
        // ===================================================================

        public function unpackUserCashReg ( $rec ) {

            // распаковываем
            $data = FALSE;
            if (is_string($rec)) {
                $rec = trim($rec);
                if ($rec != '') {
                    $rec = explode('|', $rec);
                    if (count($rec) > field_USERCASHREG_LASTFIELD) {
                        $rec[field_USERCASHREG_TIMESTAMP] = trim($rec[field_USERCASHREG_TIMESTAMP]);
                    }
                }
            }

            // убеждаемся в актуальности записи (это точно запись, известна дата, ip, ИД зарегистрировавшегося и положительное пополнение)
            if (is_array($rec) && count($rec) > field_USERCASHREG_LASTFIELD) {
                if ($rec[field_USERCASHREG_TIMESTAMP] !== '') {
                    $ip = trim($rec[field_USERCASHREG_IP]);
                    if ($ip != '') {
                        $id = trim($rec[field_USERCASHREG_ID]);
                        if (!empty($id)) {
                            $sum = $this->number->floatValue($rec[field_USERCASHREG_SUM]);
                            if ($sum > 0) {
                                $data = array();
                                $data[field_USERCASHREG_TIMESTAMP] = intval($rec[field_USERCASHREG_TIMESTAMP]);
                                $data[field_USERCASHREG_SUM] = $sum;
                                $data[field_USERCASHREG_IP] = strtolower($ip);
                                $data[field_USERCASHREG_ID] = $id;
                            }
                        }
                    }
                }
            }
            return $data;
        }



        // ===================================================================
        /**
        *  Пополнение внутреннего счета пользователя за регистрацию приведенного
        *
        *  @access  public
        *  @param   object  $user   запись о пользователе
        *  @param   float   $sum    сумма пополнения
        *  @param   string  $ip     IP приглашенного посетителя
        *  @param   string  $uid    идентификатор приглашенного
        *  @return  boolean         TRUE если выполнено
        *                           FALSE если ничего не изменилось
        */
        // ===================================================================

        public function regUserCash ( & $user, $sum, $ip, $uid ) {
            if (!isset($user->regs) || !isset($user->cash)) return FALSE;
            $sum = round($this->number->floatValue($sum), 4);
            if ($sum <= 0) return FALSE;
            $ip = $this->text->removeRecordsDelimiters($ip);
            if ($ip == '') return FALSE;
            $uid = $this->text->removeRecordsDelimiters($uid);
            $item = array();
            $item[field_USERCASHREG_TIMESTAMP] = time();
            $item[field_USERCASHREG_SUM] = $sum;
            $item[field_USERCASHREG_IP] = $ip;
            $item[field_USERCASHREG_ID] = $uid;
            array_unshift($user->regs, $item);
            $user->cash += $sum;
            return TRUE;
        }



        // ===================================================================
        /**
        *  Регистрация регистрации нового пользователя
        *
        *  @access  public
        *  @param   string  $aid    идентификатор зазывающего пользователя
        *  @param   string  $uid    идентификатор зарегистрировавшегося пользователя
        *  @return  void
        */
        // ===================================================================

        function registerRegistration ( $aid, $uid ) {
            if (is_string($aid) || is_integer($aid)) {
                $aid = rtrim(ltrim($aid, '! '));
                if (!empty($aid)) {
                    if (is_string($uid) || is_integer($uid)) {
                        $uid = $this->text->removeRecordsDelimiters($uid);
                        if (!empty($uid) && $aid != $uid) {
                            if ($this->settings->get('affiliates_enabled')) {
                                $sum = $this->settings->get('affiliates_registration_cost', 0);
                                $sum = round($this->number->floatValue($sum), 4);
                                if ($sum > 0) {
                                    $ip = $this->reguest->getServer('REMOTE_ADDR');
                                    if (is_string($ip)) {
                                        $ip = $this->text->removeRecordsDelimiters($ip);
                                        if ($ip != '') {
                                            $user = null;
                                            $filter = new stdClass;
                                            $filter->enabled = 1;
                                            $filter->id = $aid;
                                            $this->cms->db->users->one($user, $filter);
                                            if (!empty($user)) {
                                                $ip = strtolower($ip);
                                                if ($this->regUserCash($user, $sum, $ip, $uid)) {
                                                    $this->cms->db->users->update($user);
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



        // ===================================================================
        /**
        *  Распаковка записи о комиссионном отчислении
        *
        *  @access  public
        *  @param   string  $rec    строковое представление записи
        *  @return  array           распакованная запись
        *                           FALSE если это не запись или она неактуальна
        */
        // ===================================================================

        public function unpackUserCashCommission ( $rec ) {

            // распаковываем
            $data = FALSE;
            if (is_string($rec)) {
                $rec = trim($rec);
                if ($rec != '') {
                    $rec = explode('|', $rec);
                    if (count($rec) > field_USERCASHCOMMISSION_LASTFIELD) {
                        $rec[field_USERCASHCOMMISSION_TIMESTAMP] = trim($rec[field_USERCASHCOMMISSION_TIMESTAMP]);
                    }
                }
            }

            // убеждаемся в актуальности записи (это точно запись, известна дата, ИД заказа и положительное пополнение)
            if (is_array($rec) && count($rec) > field_USERCASHCOMMISSION_LASTFIELD) {
                if ($rec[field_USERCASHCOMMISSION_TIMESTAMP] !== '') {
                    $id = trim($rec[field_USERCASHCOMMISSION_ID]);
                    if (!empty($id)) {
                        $sum = $this->number->floatValue($rec[field_USERCASHCOMMISSION_SUM]);
                        if ($sum > 0) {
                            $osum = $this->number->floatValue($rec[field_USERCASHCOMMISSION_OSUM]);
                            if ($osum > 0) {
                                $data = array();
                                $data[field_USERCASHCOMMISSION_TIMESTAMP] = intval($rec[field_USERCASHCOMMISSION_TIMESTAMP]);
                                $data[field_USERCASHCOMMISSION_SUM] = $sum;
                                $data[field_USERCASHCOMMISSION_ID] = $id;
                                $data[field_USERCASHCOMMISSION_OSUM] = $osum;
                                $data[field_USERCASHCOMMISSION_COMMENT] = trim($rec[field_USERCASHCOMMISSION_COMMENT]);
                            }
                        }
                    }
                }
            }
            return $data;
        }



        // ===================================================================
        /**
        *  Пополнение внутреннего счета пользователя комиссией
        *
        *  @access  public
        *  @param   object  $user       запись о пользователе
        *  @param   float   $sum        сумма пополнения
        *  @param   string  $oid        идентификатор оформленного заказа
        *  @param   float   $osum       сумма заказа
        *  @param   string  $comment    комментарий к операции
        *  @return  boolean             TRUE если выполнено
        *                               FALSE если ничего не изменилось
        */
        // ===================================================================

        public function commissionUserCash ( & $user, $sum, $oid, $osum, $comment ) {
            if (!isset($user->commissions) || !isset($user->cash)) return FALSE;
            $sum = round($this->number->floatValue($sum), 4);
            if ($sum <= 0) return FALSE;
            $oid = $this->text->removeRecordsDelimiters($oid);
            if (empty($oid)) return FALSE;
            $osum = round($this->number->floatValue($osum), 4);
            if ($osum <= 0) return FALSE;
            $comment = $this->text->removeRecordsDelimiters($comment);
            $item = array();
            $item[field_USERCASHCOMMISSION_TIMESTAMP] = time();
            $item[field_USERCASHCOMMISSION_SUM] = $sum;
            $item[field_USERCASHCOMMISSION_ID] = $oid;
            $item[field_USERCASHCOMMISSION_OSUM] = $osum;
            $item[field_USERCASHCOMMISSION_COMMENT] = $comment;
            array_unshift($user->commissions, $item);
            $user->cash += $sum;
            return TRUE;
        }



        // ===================================================================
        /**
        *  Регистрация комиссионных отчислений
        *
        *  @access  public
        *  @param   string  $aid    идентификатор зазывающего пользователя
        *  @param   string  $oid    идентификатор оформленного заказа
        *  @param   float   $sum    сумма заказа
        *  @param   boolean $paid   TRUE если заказ оплачен
        *  @return  void
        */
        // ===================================================================

        function registerCommission ( $aid, $oid, $sum, $paid ) {
            if (is_string($aid) || is_integer($aid)) {
                $aid = rtrim(ltrim($aid, '! '));
                if (!empty($aid)) {
                    if (is_string($oid) || is_integer($oid)) {
                        $oid = $this->text->removeRecordsDelimiters($oid);
                        if (!empty($oid)) {
                            if ($this->settings->get('affiliates_enabled')) {
                                $sum = round($this->number->floatValue($sum), 4);
                                if ($sum > 0) {
                                    if ($paid) {
                                        $csum = $this->settings->get('affiliates_commission_percent', 0);
                                        $comment = 'комиссия';
                                    } else {
                                        $csum = $this->settings->get('affiliates_commission_percent_gift', 0);
                                        $comment = 'вознаграждение';
                                    }
                                    $csum = round($this->number->floatValue($csum), 4);
                                    $csum = round($sum / 100 * $csum, 4);
                                    $limit = $this->settings->get('affiliates_commission_limit', '');
                                    if (trim($limit) != '') {
                                        $limit = round($this->number->floatValue($limit), 4);
                                        if ($csum > $limit) $csum = $limit;
                                    }
                                    if ($csum > 0) {
                                        $user = null;
                                        $filter = new stdClass;
                                        $filter->enabled = 1;
                                        $filter->id = $aid;
                                        $this->cms->db->users->one($user, $filter);
                                        if (!empty($user)) {
                                            if ($this->commissionUserCash($user, $csum, $oid, $sum, $comment)) {
                                                $this->cms->db->users->update($user);
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



    return;
?>