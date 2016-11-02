<?php
  // Impera CMS: модуль авторизации на клиентской стороне.
  // Copyright AIMatrix, 2011.
  // http://aimatrix.itak.info

  if (!defined("ROOT_FOLDER_REFERENCE")) return;
  if (!defined("FOLDERNAME_FOR_ENGINE_OBJECTS")) return;
  if (!defined("FILENAME_FOR_ENGINE_DEFINITION_OBJECT")) return;

  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_DEFINITION_OBJECT);
  require_once(ROOT_FOLDER_REFERENCE . FOLDERNAME_FOR_ENGINE_OBJECTS . "/" . FILENAME_FOR_ENGINE_BASIC_OBJECT);

  // какой файл является шаблоном страницы авторизации на клиентской стороне (указываем без расширения),
  // какой файл является шаблоном страницы регенерации пароля на клиентской стороне (указываем без расширения)
  define("CLIENT_LOGIN_CLASS_TEMPLATE_FILE", "page.login");
  define("CLIENT_LOGIN_REMIND_CLASS_TEMPLATE_FILE", "page.password_remind");

  // =========================================================================
  // Модуль восстановления пароля
  // =========================================================================

  class ClientLoginRemind extends Basic {

        // основа шифровки пароля
        private $salt = 'imperacms';

        // создание контента модуля ==============================================

        public function fetch ( & $parent = null ) {
            // возможно это подтверждающий вызов из письма (то есть содержит аутентификатор удаленного действия)
            $token = isset($_GET[REQUEST_PARAM_NAME_TOKEN]) && isset($_GET["email"]) ? $this->text->stripTags($_GET[REQUEST_PARAM_NAME_TOKEN], TRUE) : "";

            // если получена форма регенерации или это подтверждающий вызов из письма
            $this->error_msg = "";
            $item = null;
            if (isset($_POST["email"]) || ($token != "")) {

                // если это подтверждающий вызов из письма, берем емейлы из GET-запроса, иначе из POST-запроса
                if ($token != "") {
                    $this->get_POST_person_email($item, $_GET);
                } else {
                    $this->get_POST_person_email($item);
                }

                // если введен емейл
                if ($item->email != '' || $item->email2 != '') {

                    // если это подтверждающий вызов из письма или правильно введен защитный код
                    if ($token != '' || $this->security->checkCaptcha()) {

                        // пытаемся прочитать запись о пользователе с таким емейлом и аутентификатором удаленного действия
                        $user = null;
                        $params = new stdClass;
                        if ($token != '') $params->remote_token = $token;
                        if ($item->email != '') {
                            $params->email = $item->email;
                            $this->db->users->one($user, $params);
                        }

                        // пытаемся прочитать запись о пользователе с таким емейлом2 и аутентификатором удаленного действия
                        if (empty($user)) {
                            if ($item->email2 != '') {
                                $params->email = $item->email2;
                                $this->db->users->one($user, $params);
                            }
                        }

                        // если такой пользователь не найден
                        if (empty($user)) {
                            if ($token != "") {
                                $this->error_msg = "Недействительная подтверждающая ссылка.";
                            } else {
                                $this->error_msg = "Пользователь с таким логином (емейлом) не известен.";
                            }

                            // иначе пользователь найден
                        } else {

                            // если это подтверждающий вызов из письма, генерируем новый пароль
                            $password = '';
                            $subject = '';
                            if ($token != '') {
                                for ($i = 1; $i <= 10; $i++) {
                                    $code = rand(0, 10 + 26 + 26 - 1);
                                    if ($code < 10) $password .= $code;
                                    elseif ($code < 10 + 26) $password .= chr(ord('A') - 10 + $code);
                                    else $password .= chr(ord('a') - 10 - 26 + $code);
                                }
                                $user->password = md5($password . $this->salt);

                                // сохраняем новый пароль в базе данных (и делаем подтверждающую ссылку недействительной)
                                $user->remote_token = '';
                                $record = new stdClass;
                                $record->user_id = $user->user_id;
                                $record->password = $user->password;
                                $record->remote_token = $user->remote_token;
                                $this->db->users->update($record);
                                $subject = 'На сайте http://' . $this->root_url . ' вам сгенерирован новый пароль';

                                // иначе это лишь проба сменить пароль
                            } else {

                                // генерируем аутентификатор удаленного действия (блокируя обновления на 10 минут) и сохраняем в базе данных
                                $code = 'NPG' . substr(date('YmdHi', time()), 0, 11) . '-';
                                if (substr($user->remote_token, 0, strlen($code)) != $code) {
                                    $user->remote_token = $code;
                                    for ($i = 1; $i <= 64; $i++) {
                                        $code = rand(0, 10 + 26 + 26);
                                        if ($code < 10) $user->remote_token .= $code;
                                        elseif ($code < 10 + 26) $user->remote_token .= chr(ord('A') - 10 + $code);
                                        else $user->remote_token .= chr(ord('a') - 10 - 26 + $code);
                                    }

                                    // сохраняем в базе данных
                                    $record = new stdClass;
                                    $record->user_id = $user->user_id;
                                    $record->remote_token = $user->remote_token;
                                    $this->db->users->update($record);
                                    $subject = 'Подтвердите свое желание сгенерировать новый пароль на сайте http://' . $this->root_url;
                                }
                            }

                            // уведомляем пользователя по емейлу (избегая при обновлении страницы)
                            $this->smarty->assignByRef('new_password', $password);
                            if ($subject != '') {
                                $this->smarty->assignByRef(SMARTY_VAR_ITEM, $user);
                                $message = $this->smarty->fetch('email_password_remind.tpl');
                                if (trim($user->email) != '') $this->email($user->email, $subject, $message);
                                elseif (trim($user->email2) != '') $this->email($user->email2, $subject, $message);
                            }
                        }

                    } else {
                        $this->error_msg = 'Введите правильный защитный код с картинки.';
                    }
                } else {
                    $this->error_msg = 'Вы не ввели логин (емейл).';
                }
            }

            // устанавливаем заголовок страницы
            $this->title = 'Генерация нового пароля';

            // передаем данные в шаблонизатор,
            // создаем контент модуля
            $this->smarty->assignByRef('title', $this->title);
            $this->smarty->assignByRef(SMARTY_VAR_ITEM, $item);
            $this->smarty->assignByRef(SMARTY_VAR_ERROR, $this->error_msg);
            $this->smarty->assignByRef(SMARTY_VAR_MESSAGE, $this->message);
            $this->smarty->fetchByTemplate($this, CLIENT_LOGIN_REMIND_CLASS_TEMPLATE_FILE, 'password_remind');
            return TRUE;
        }
    }



  return;
?>