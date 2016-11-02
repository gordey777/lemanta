<?php
    // =======================================================================
    /**
    *  Админ модуль настроек корзины
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2012, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    // макет редактируемых настроек
    require_once(dirname(__FILE__) . '/../.ref-models/AdminSetup.php');

    // текст заголовка страницы модуля
    define('CART_PAGE_TITLE', 'Корзина');

    // имя файла шаблона модуля
    define('CART_TEMPLATE_FILENAME', 'cart/cart.htm');

    // информация для автоподхвата модуля движком:
    //     ..._MODULELINK_POINTER - указатель на модуль в ссылке (что добавить в ссылку после ?section=)
    //     ..._MODULETAB_TEXT     - какой текст дать в закладку модуля
    //     ..._MODULEMENU_PATH    - в какое меню админпанели поместить ссылку
    define('CART_MODULELINK_POINTER', 'Cart');
    define('CART_MODULETAB_TEXT', 'корзина');
    define('CART_MODULEMENU_PATH', 'Заказы / Настройки корзины');



    // =======================================================================
    /**
    *  Админ модуль настроек корзины
    *
    *  @package     Impera CMS
    *  @author      AIMatrix
    *  @copyright   Copyright 2013, AIMatrix
    *  @link        http://imperacms.ru
    */
    // =======================================================================

    class Cart extends AdminSetupREFModel {

        // имя модели базы данных
        protected $dbmodel = 'cart';

        // имя файла шаблона
        protected $template = CART_TEMPLATE_FILENAME;



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

/* TODO: сохранение настроек

    quickorder_sort_method - Быстрый заказ - способ сортировки категорий

    quickorder_captcha_protecting - Быстрый заказ - применять защиту от роботов вводом кода с картинки

    quickorder_title_text - Быстрый заказ - текст заголовка страницы

    quickorder_show_info - Быстрый заказ - выводить ли эту инструкцию в заказе
    quickorder_info_text - Быстрый заказ - инструкция

    quickorder_show_name - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_name - Быстрый заказ - надписи к полям заказа - фамилия

    quickorder_show_name3 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_name3 - Быстрый заказ - надписи к полям заказа - имя

    quickorder_show_name2 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_name2 - Быстрый заказ - надписи к полям заказа - отчество

    quickorder_show_email - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_email - Быстрый заказ - надписи к полям заказа - емейл
        
    quickorder_show_email2 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_email2 - Быстрый заказ - надписи к полям заказа - емейл 2

    quickorder_show_phone - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_phone - Быстрый заказ - надписи к полям заказа - телефон

    quickorder_show_phone2 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_phone2 - Быстрый заказ - надписи к полям заказа - дополнительный телефон

    quickorder_show_address_10 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_10 - Быстрый заказ - надписи к полям заказа - почтовый индекс

    quickorder_show_address2_10 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_10 - Быстрый заказ - надписи к полям заказа - почтовый индекс (дополнительный адрес)

    quickorder_show_address - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address - Быстрый заказ - надписи к полям заказа - страна

    quickorder_show_address2 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2 - Быстрый заказ - надписи к полям заказа - страна (дополнительный адрес)

    quickorder_show_address_2 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_2 - Быстрый заказ - надписи к полям заказа - область

    quickorder_show_address2_2 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_2 - Быстрый заказ - надписи к полям заказа - область (дополнительный адрес)

    quickorder_show_address_3 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_3 - Быстрый заказ - надписи к полям заказа - город

    quickorder_show_address2_3 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_3 - Быстрый заказ - надписи к полям заказа - город (дополнительный адрес)

    quickorder_show_address_4 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_4 - Быстрый заказ - надписи к полям заказа - улица

    quickorder_show_address2_4 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_4 - Быстрый заказ - надписи к полям заказа - улица (дополнительный адрес)

    quickorder_show_address_5 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_5 - Быстрый заказ - надписи к полям заказа - дом

    quickorder_show_address_6 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_6 - Быстрый заказ - надписи к полям заказа - корпус

    quickorder_show_address_7 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_7 - Быстрый заказ - надписи к полям заказа - подъезд

    quickorder_show_address_8 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_8 - Быстрый заказ - надписи к полям заказа - код двери

    quickorder_show_address_9 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address_9 - Быстрый заказ - надписи к полям заказа - квартира

    quickorder_show_address2_5 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_5 - Быстрый заказ - надписи к полям заказа - дом

    quickorder_show_address2_6 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_6 - Быстрый заказ - надписи к полям заказа - корпус

    quickorder_show_address2_7 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_7 - Быстрый заказ - надписи к полям заказа - подъезд

    quickorder_show_address2_8 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_8 - Быстрый заказ - надписи к полям заказа - код двери

    quickorder_show_address2_9 - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_address2_9 - Быстрый заказ - надписи к полям заказа - квартира

    quickorder_show_to_date - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_to_date - Быстрый заказ - надписи к полям заказа - желаемая дата доставки
    quickorder_to_date_editable - Быстрый заказ - надписи к полям заказа - не предлагать выбор из списка в этом поле

    quickorder_show_to_time - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_to_time - Быстрый заказ - надписи к полям заказа - желаемое время доставки
    quickorder_to_time_editable - Быстрый заказ - надписи к полям заказа - не предлагать выбор из списка в этом поле

    quickorder_show_comment - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_comment - Быстрый заказ - надписи к полям заказа - комментарий к заказу

    quickorder_show_delivery - Быстрый заказ - надписи к полям заказа - выводить ли это поле в заказе
    quickorder_label_delivery - Быстрый заказ - надписи к полям заказа - доставка

    quickorder_header_category - Быстрый заказ - заголовки колонок таблицы - категория
    quickorder_header_name - Быстрый заказ - заголовки колонок таблицы - наименование
    quickorder_header_quantity - Быстрый заказ - заголовки колонок таблицы - количество
    quickorder_header_sum - Быстрый заказ - заголовки колонок таблицы - сумма

    quickorder_submit_text - Быстрый заказ - текст кнопки отправки заказа



    cart_open_method - Корзина - способ открытия корзины

    cart_enable_reservation - Корзина - разрешить продажу товаров под заказ
    cart_reservation_text - Корзина - маркер покупаемого под заказ

    cart_auto_registration - Корзина - разрешить автоматическую регистрацию пользователей
    cart_auto_registration_msg - Корзина - подсказка пользователю о включенной авто регистрации

    cart_captcha_protecting - Корзина - применять защиту от роботов вводом кода с картинки

    cart_title_text - Корзина - текст заголовка страницы

    cart_show_info - Корзина - выводить ли эту инструкцию в корзине
    cart_info_text - Корзина - инструкция

    cart_header_number - Корзина - заголовки колонок таблицы - порядковый номер
    cart_header_name - Корзина - заголовки колонок таблицы - товар
    cart_header_quantity - Корзина - заголовки колонок таблицы - количество
    cart_header_price - Корзина - заголовки колонок таблицы - цена
    cart_header_sum - Корзина - заголовки колонок таблицы - сумма

    cart_contacts_maximize - Корзина - секцию "Кому доставить" сразу раскрывать
    cart_deliveries_maximize - Корзина - секцию "Способы доставки" сразу раскрывать

    cart_submit_text - Корзина - текст кнопки отправки заказа
*/

            // не ожидаем каких-либо файлов
            parent::processSetupSave($upload_folder, $upload_watermark);
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

            // проверяем доступность шаблона
            if (!$this->checkTemplate(CART_PAGE_TITLE)) return TRUE;

            // визуализируем данные
            return parent::fetch($parent);
        }
    }



    return;

/* TODO: переверстать следующее в файл admin/design/defaul/html/cart/cart.htm


    Быстрый заказ:
    {$quickorder_sort_method = $Settings->quickorder_sort_method}
    Способ сортировки категорий:
    <select name="quickorder_sort_method">
        <option value="0"{if $quickorder_sort_method == 0} selected{/if}>как расставлены на странице "Товары → Категории"</option>
        <option value="1"{if $quickorder_sort_method == 1} selected{/if}>по алфавиту</option>
    </select>

    <input name="quickorder_captcha_protecting" type="checkbox" value="1"{if $Settings->quickorder_captcha_protecting == 1} checked{/if}>
    Применять защиту от роботов вводом кода с картинки
    иначе отправка заказов будет доступна и автоматическим системам

    Текст заголовка страницы:
    <input name="quickorder_title_text" type="text" value="{$Settings->quickorder_title_text}">

    Инструкция:
    <input name="quickorder_show_info" title="Выводить ли эту инструкцию в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_info == 1} checked{/if}>
    <textarea name="quickorder_info_text">{$Settings->quickorder_info_text}</textarea>

    Надписи к полям заказа и какие из них выводить:
    <table>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_name" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_name == 1} checked{/if}>
          </td>
          <td colspan="3">
            <table>
              <tr>
                <td>
                  фамилия:<br>
                  <input name="quickorder_label_name" type="text" value="{$Settings->quickorder_label_name}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_name3" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_name3 == 1} checked{/if}>
                </td>
                <td>
                  имя:<br>
                  <input name="quickorder_label_name3" type="text" value="{$Settings->quickorder_label_name3}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_name2" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_name2 == 1} checked{/if}>
                </td>
                <td>
                  отчество:<br>
                  <input name="quickorder_label_name2" type="text" value="{$Settings->quickorder_label_name2}">
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_email" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_email == 1} checked{/if}>
          </td>
          <td>
            е-мейл:<br>
            <input name="quickorder_label_email" type="text" value="{$Settings->quickorder_label_email}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_email2" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_email2 == 1} checked{/if}>
          </td>
          <td>
            дополнительный е-мейл:<br>
            <input name="quickorder_label_email2" type="text" value="{$Settings->quickorder_label_email2}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_phone" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_phone == 1} checked{/if}>
          </td>
          <td>
            телефон:<br>
            <input name="quickorder_label_phone" type="text" value="{$Settings->quickorder_label_phone}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_phone2" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_phone2 == 1} checked{/if}>
          </td>
          <td>
            дополнительный телефон:<br>
            <input name="quickorder_label_phone2" type="text" value="{$Settings->quickorder_label_phone2}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_address_10" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_10 == 1} checked{/if}>
          </td>
          <td>
            почтовый индекс:<br>
            <input name="quickorder_label_address_10" type="text" value="{$Settings->quickorder_label_address_10}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_address2_10" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_10 == 1} checked{/if}>
          </td>
          <td>
            почтовый индекс (дополнительный адрес):<br>
            <input name="quickorder_label_address2_10" type="text" value="{$Settings->quickorder_label_address2_10}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_address" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address == 1} checked{/if}>
          </td>
          <td>
            страна:<br>
            <input name="quickorder_label_address" type="text" value="{$Settings->quickorder_label_address}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_address2" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2 == 1} checked{/if}>
          </td>
          <td>
            страна (дополнительный адрес):<br>
            <input name="quickorder_label_address2" type="text" value="{$Settings->quickorder_label_address2}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_address_2" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_2 == 1} checked{/if}>
          </td>
          <td>
            область:<br>
            <input name="quickorder_label_address_2" type="text" value="{$Settings->quickorder_label_address_2}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_address2_2" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_2 == 1} checked{/if}>
          </td>
          <td>
            область (дополнительный адрес):<br>
            <input name="quickorder_label_address2_2" type="text" value="{$Settings->quickorder_label_address2_2}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_address_3" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_3 == 1} checked{/if}>
          </td>
          <td>
            город:<br>
            <input name="quickorder_label_address_3" type="text" value="{$Settings->quickorder_label_address_3}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_address2_3" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_3 == 1} checked{/if}>
          </td>
          <td>
            город (дополнительный адрес):<br>
            <input name="quickorder_label_address2_3" type="text" value="{$Settings->quickorder_label_address2_3}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_address_4" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_4 == 1} checked{/if}>
          </td>
          <td>
            улица:<br>
            <input name="quickorder_label_address_4" type="text" value="{$Settings->quickorder_label_address_4}">
          </td>
          <td>
            <br>
            <input name="quickorder_show_address2_4" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_4 == 1} checked{/if}>
          </td>
          <td>
            улица (дополнительный адрес):<br>
            <input name="quickorder_label_address2_4" type="text" value="{$Settings->quickorder_label_address2_4}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_address_5" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_5 == 1} checked{/if}>
          </td>
          <td>
            <table>
              <tr>
                <td>
                  дом:<br>
                  <input name="quickorder_label_address_5" type="text" value="{$Settings->quickorder_label_address_5}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address_6" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_6 == 1} checked{/if}>
                </td>
                <td>
                  корп:<br>
                  <input name="quickorder_label_address_6" type="text" value="{$Settings->quickorder_label_address_6}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address_7" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_7 == 1} checked{/if}>
                </td>
                <td>
                  под:<br>
                  <input name="quickorder_label_address_7" type="text" value="{$Settings->quickorder_label_address_7}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address_8" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_8 == 1} checked{/if}>
                </td>
                <td>
                  код:<br>
                  <input name="quickorder_label_address_8" type="text" value="{$Settings->quickorder_label_address_8}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address_9" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address_9 == 1} checked{/if}>
                </td>
                <td>
                  кв:<br>
                  <input name="quickorder_label_address_9" type="text" value="{$Settings->quickorder_label_address_9}">
                </td>
              </tr>
            </table>
          </td>
          <td>
            <br>
            <input name="quickorder_show_address2_5" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_5 == 1} checked{/if}>
          </td>
          <td>
            <table>
              <tr>
                <td>
                  дом:<br>
                  <input name="quickorder_label_address2_5" type="text" value="{$Settings->quickorder_label_address2_5}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address2_6" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_6 == 1} checked{/if}>
                </td>
                <td>
                  кор:<br>
                  <input name="quickorder_label_address2_6" type="text" value="{$Settings->quickorder_label_address2_6}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address2_7" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_7 == 1} checked{/if}>
                </td>
                <td>
                  под:<br>
                  <input name="quickorder_label_address2_7" type="text" value="{$Settings->quickorder_label_address2_7}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address2_8" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_8 == 1} checked{/if}>
                </td>
                <td>
                  код:<br>
                  <input name="quickorder_label_address2_8" type="text" value="{$Settings->quickorder_label_address2_8}">
                </td>
                <td>
                  <br>
                  <input name="quickorder_show_address2_9" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_address2_9 == 1} checked{/if}>
                </td>
                <td>
                  кв:<br>
                  <input name="quickorder_label_address2_9" type="text" value="{$Settings->quickorder_label_address2_9}">
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_to_date" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_to_date == 1} checked{/if}>
          </td>
          <td>
            желаемая дата доставки:<br>
            <input name="quickorder_label_to_date" type="text" value="{$Settings->quickorder_label_to_date}"><br>
            <span>
              <input name="quickorder_to_date_editable" type="checkbox" value="1"{if $Settings->quickorder_to_date_editable == 1} checked{/if}>
              не предлагать выбор из списка в этом поле
            </span>
          </td>
          <td>
            <br>
            <input name="quickorder_show_to_time" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_to_time == 1} checked{/if}>
          </td>
          <td>
            желаемое время доставки:<br>
            <input name="quickorder_label_to_time" type="text" value="{$Settings->quickorder_label_to_time}"><br>
            <span>
              <input name="quickorder_to_time_editable" type="checkbox" value="1"{if $Settings->quickorder_to_time_editable == 1} checked{/if}>
              не предлагать выбор из списка в этом поле
            </span>
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_comment" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_comment == 1} checked{/if}>
          </td>
          <td colspan="3">
            комментарий к заказу:<br>
            <input name="quickorder_label_comment" type="text" value="{$Settings->quickorder_label_comment}">
          </td>
        </tr>
        <tr>
          <td>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </td>
          <td>
            <br>
            <input name="quickorder_show_delivery" title="Выводить ли это поле в заказе" type="checkbox" value="1"{if $Settings->quickorder_show_delivery == 1} checked{/if}>
          </td>
          <td colspan="3">
            доставка:<br>
            <input name="quickorder_label_delivery" type="text" value="{$Settings->quickorder_label_delivery}">
          </td>
        </tr>
    </table>

    Заголовки колонок таблицы:
    <table>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            категория:<br>
            <input name="quickorder_header_category" type="text" value="{$Settings->quickorder_header_category}">
          </td>
          <td>
            наименование:<br>
            <input name="quickorder_header_name" type="text" value="{$Settings->quickorder_header_name}">
          </td>
          <td>
            количество:<br>
            <input name="quickorder_header_quantity" type="text" value="{$Settings->quickorder_header_quantity}">
          </td>
          <td>
            сумма:<br>
            <input name="quickorder_header_sum" type="text" value="{$Settings->quickorder_header_sum}">
          </td>
        </tr>
    </table>

    Текст кнопки отправки заказа:
    <input name="quickorder_submit_text" type="text" value="{$Settings->quickorder_submit_text}">



    Корзина:
    {$cart_open_method = $Settings->cart_open_method}
    Способ открытия корзины:&nbsp;
    <select name="cart_open_method">
        <option value="0"{if $cart_open_method == 0} selected{/if}>переходом на её страницу</option>
        <option value="1"{if $cart_open_method == 1} selected{/if}>появлением поверх текущей страницы</option>
        <option value="2"{if $cart_open_method == 2} selected{/if}>появлением плашки "Товар добавлен в корзину"</option>
    </select>

    <input name="cart_enable_reservation" type="checkbox" value="1"{if $Settings->cart_enable_reservation == 1} checked{/if}>
    Разрешить продажу товаров под заказ
    иначе у отсутствующих на складе товаров не появится кнопка "Под заказ" и их невозможно будет купить

    Маркер покупаемого под заказ:
    <input name="cart_reservation_text" type="text" value="{$Settings->cart_reservation_text}">

    <input name="cart_captcha_protecting" type="checkbox" value="1"{if $Settings->cart_captcha_protecting == 1} checked{/if}>
    Применять защиту от роботов вводом кода с картинки
    иначе отправка заказов будет доступна и автоматическим системам

    <input name="cart_auto_registration" type="checkbox" value="1"{if $Settings->cart_auto_registration} checked{/if}>
    Авто регистрация неавторизованных пользователей при оформлении заказа

    Подсказка в корзине при включенной авто регистрации:
    <textarea name="cart_auto_registration_msg">{$Settings->cart_auto_registration_msg|escape}</textarea>

    Текст заголовка страницы:
    <input name="cart_title_text" type="text" value="{$Settings->cart_title_text}">

    Инструкция:
    <input name="cart_show_info" title="Выводить ли эту инструкцию в корзине" type="checkbox" value="1"{if $Settings->cart_show_info == 1} checked{/if}>
    <textarea name="cart_info_text">{$Settings->cart_info_text}</textarea>

    Надписи к полям заказа и какие из них выводить:
    Аналогично одноимённым установкам для быстрого заказа

    Заголовки колонок таблицы:
    <table>
        <tr>
          <td>
            &nbsp;
          </td>
          <td>
            порядковый номер:<br>
            <input name="cart_header_number" type="text" value="{$Settings->cart_header_number}">
          </td>
          <td>
            товар:<br>
            <input name="cart_header_name" type="text" value="{$Settings->cart_header_name}">
          </td>
          <td>
            количество:<br>
            <input name="cart_header_quantity" type="text" value="{$Settings->cart_header_quantity}">
          </td>
          <td>
            цена:<br>
            <input name="cart_header_price" type="text" value="{$Settings->cart_header_price}">
          </td>
          <td>
            сумма:<br>
            <input name="cart_header_sum" type="text" value="{$Settings->cart_header_sum}">
          </td>
        </tr>
    </table>

    <input name="cart_contacts_maximize" type="checkbox" value="1"{if $Settings->cart_contacts_maximize == 1} checked{/if}>
    иначе при открытии корзины эта секция будет свёрнута

    <input name="cart_deliveries_maximize" type="checkbox" value="1"{if $Settings->cart_deliveries_maximize == 1} checked{/if}>
    Секцию "Способы доставки" сразу раскрывать
    иначе при открытии корзины эта секция будет свёрнута

    Текст кнопки отправки заказа:
    <input name="cart_submit_text" type="text" value="{$Settings->cart_submit_text}">
*/
?>