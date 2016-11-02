<?php

    // серверным заголовком уведомляем браузер о кодировке документа
    header('Content-Type: text/html; charset=UTF-8');



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="ru" />

        <title>
            Недействительная лицензия или ее срок истек
        </title>
    </head>



    <style>
        *             {border:           0px solid;
                       border-radius:    0px; -moz-border-radius: 0px; -webkit-border-radius: 0px;
                       box-shadow:       0px 0px 0px; -moz-box-shadow: 0px 0px 0px; -webkit-box-shadow: 0px 0px 0px;
                       font-family:      Verdana, Tahoma, Arial;
                       margin:           0px;
                       padding:          0px;
                       text-align:       left;
                       text-indent:      0px;}



        /*  контейнер страницы */
        div           {background-color: #FFFFFF;
                       border:           #C0C0C0 1px solid;
                       box-shadow:       #E0E0E0 1px 2px 10px; -moz-box-shadow: #E0E0E0 1px 2px 10px; -webkit-box-shadow: #E0E0E0 1px 2px 10px;
                       color:            #000000;
                       font-size:        10pt;
                       margin:           75px auto;
                       padding:          0px;
                       width:            350px;}
        div div       {background-color: #F0F0F0;
                       border:           0px solid;
                       box-shadow:       0px 0px 0px; -moz-box-shadow: 0px 0px 0px; -webkit-box-shadow: 0px 0px 0px;
                       line-height:      20px;
                       margin:           4px;
                       padding:          15px;
                       width:            auto;}



        /*  ссылки */
        a             {color:            #0080FF;
                       font-weight:      bold;
                       text-decoration:  none;
                       white-space:      nowrap;}
        a:hover       {color:            #C00000;
                       text-decoration:  underline;}



        /*  блоки уведомлений */
        span          {color:            #C04040;
                       display:          none;
                       font-size:        8pt;
                       line-height:      16px;
                       margin:           20px 0px 0px 0px;}
        span span     {display:          inline;
                       margin:           0px;}
        span.key      {color:            #00A000;}
        span.key span {background-color: #C0E0C0;
                       border:           #608060 1px solid;
                       color:            #004000;
                       display:          block;
                       margin:           5px 0px;
                       padding:          10px;}
    </style>



<?php

    // блокируем вывод сообщений об ошибках
    error_reporting(0);



    // подгружаем константы движка
    @include('objects/Definition.php');

?>



    <body>
        <div>
            <div>
                <b>Сайт <?php $host = isset($_SERVER['HTTP_HOST']) ? trim($_SERVER['HTTP_HOST']) : ''; echo $host; ?></b>
                <br><br>



                К сожалению, лицензия для этого сайта недействительна (возможно на сайте нет файла
                лицензионного ключа или его содержимое неверное) или срок лицензии истек.
                <br><br>

                Для получения или продления лицензии в ручном режиме обратитесь на официальный
                сайт <a href="http://imperacms.ru/" target="_blank">Impera CMS</a>.
                <br>



                <!-- блок уведомления о лицензионном ключе -->
                <span class="key" id="ImperaCMS_license_info_line">
                    <b>Текущий лицензионный ключ этого сайта:</b>
                    <br>

                    <span id="ImperaCMS_license_info_line_key"></span>

                    Ключ должен быть размещен целиком в файле http://<?php echo $host; ?>/license
                    (никакие другие данные, символы или строки в этом файле недопустимы).
                </span>



                <!-- блок уведомления, если доступна более новая версия движка -->
                <span id="ImperaCMS_update_info_line">
                    <b>Обратите внимание!</b>
                    <br>

                    Уже доступна Impera CMS новой версии <span id="ImperaCMS_update_info_line_version"></span>,
                    а&nbsp;этот&nbsp;сайт работает на версии <?php echo IMPERA_CMS_CURRENT_VERSION; ?>.
                </span>
            </div>
        </div>



        <script language="JavaScript" src="http://aimatrix.itak.info/update_master.js?product=ImperaCMS&license=<?php echo htmlspecialchars($host, ENT_QUOTES); ?>&version=<?php echo IMPERA_CMS_CURRENT_VERSION; ?>" type="text/javascript"></script>
        <script language="JavaScript" type="text/javascript">
            <!--
            if (window.IMPERACMS) {

                // показываем номер последней доступной версии движка
                if (window.IMPERACMS.may_update && window.IMPERACMS.last_version) {

                    if (IMPERACMS.may_update() && (IMPERACMS.last_version() > <?php echo IMPERA_CMS_CURRENT_VERSION; ?>)) {

                        var object = document.getElementById('ImperaCMS_update_info_line');
                        if ((typeof(object) == 'object') && (object != null) && ('style' in object)) object.style.display = 'block';

                        object = document.getElementById('ImperaCMS_update_info_line_version');
                        if ((typeof(object) == 'object') && (object != null) && ('innerHTML' in object)) object.innerHTML = IMPERACMS.last_version();

                    }
                }



                // показываем лицензионный ключ для этого домена
                if (window.IMPERACMS.license_key) {

                    if (IMPERACMS.license_key() != '') {

                        var object = document.getElementById('ImperaCMS_license_info_line');
                        if ((typeof(object) == 'object') && (object != null) && ('style' in object)) object.style.display = 'block';

                        object = document.getElementById('ImperaCMS_license_info_line_key');
                        if ((typeof(object) == 'object') && (object != null) && ('innerHTML' in object)) object.innerHTML = IMPERACMS.license_key();

                    }
                }
            }
            // -->
        </script>

    </body>
</html>
