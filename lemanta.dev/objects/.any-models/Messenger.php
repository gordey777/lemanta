<?php
    // макет произвольной модели
    require_once(dirname(__FILE__) . '/BasicModel.php');



    // =======================================================================
    /**
    *  Посыльный автомат
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class MessengerANYModel extends BasicANYModel {



        // ===================================================================
        /**
        *  Отправка шаблонного письма
        *
        *  @access  public
        *  @param   string  $type       тип отправки (email, sms)
        *  @param   string  $subject    тема письма
        *  @param   string  $template   имя файла шаблона письма
        *  @param   mixed   $item       информационный объект для шаблона
        *  @param   mixed   $subitem    информационный субъект для шаблона
        *  @param   string  $to         контакт получателя (по умолчанию администратор)
        *  @return  boolean             TRUE если отправлено
        */
        // ===================================================================

        public function sendByTemplate ( $type, $subject, $template, & $item, & $subitem = null, $to = null ) {

            // указан ли шаблон письма?
            $result = FALSE;
            $file = $this->hdd->safeFilename($template, FALSE);
            if ($file != '') {

                // указан ли контакт получателя?
                $type = trim($this->text->lowerCase($type));
                switch ($type) {
                    case 'email':
                        $to = !is_null($to) ? trim($to) : $this->settings->getAsSentence('admin_email');
                        break;
                    case 'sms':
                        $to = !is_null($to) ? trim($to) : ADMIN_PHONE_PSEUDONYM;
                        break;
                    default: $to = '';
                }
                if ($to != '') {

                    // проверяем тему
                    $subject = trim($subject);
                    if ($subject == '') $subject = 'Сообщение с сайта ' . $this->cms->root_url;
                    $message = '';

                    // ищем шаблон письма в текущем клиентском шаблоне
                    $router = '';
                    $root = dirname(__FILE__) . '/../../';
                    $path = 'design/'
                          . $this->hdd->safeFilename($this->cms->dynamic_theme)
                          . '/html/';
                    if (!$this->hdd->isReadableFile($root . $path . $file)) {

                        // иначе ищем шаблон письма в админском шаблоне
                        $path2 = $this->hdd->safeFilename($this->cms->admin_folder)
                               . '/design/'
                               . $this->hdd->safeFilename($this->settings->getAsSentence('admin_theme'))
                               . '/html/';
                        if (!$this->hdd->isReadableFile($root . $path2 . $file)) {

                            // иначе текст дублирует тему письма
                            switch ($type) {
                                case 'email':
                                    $message = $subject . '<br /><br />Замечен недостаток: ни в шаблоне клиентской стороны '
                                            . 'ни в шаблоне админпанели не обнаружен tpl-файл, которым должен формироваться текст '
                                            . 'данного письма, в результате текст сейчас просто дублирует тему письма.<br /><br />'
                                            . 'Такой tpl-файл должен располагаться по одному из следующих адресов:<br />'
                                            . $path . $file . '<br />'
                                            . $path2 . $file;
                                    break;
                                case 'sms':
                                default:
                                    $message = $subject;
                            }
                        } else {
                            $router = $path2;
                        }
                    }

                    // готовим текст, если нашли шаблон
                    if ($message == '') {
                        $this->cms->smarty->assignByRef('post', $item);
                        $this->cms->smarty->assignByRef('post_object', $subitem);
                        $message = $this->cms->smarty->fetch($router . $file);
                        $this->cms->smarty->clearAssign('post');
                        $this->cms->smarty->clearAssign('post_object');
                        $message = trim($message);
                        if ($message == '') $message = $subject;
                    }

                    // отправляем
                    switch ($type) {
                        case 'email':
                            $this->cms->email($to, $subject, $message);
                            $result = TRUE;
                            break;
                        case 'sms':
                            $this->cms->send_sms($to, $message);
                            $result = TRUE;
                            break;
                    }
                }
            }
            return $result;
        }
    }



    return;
?>