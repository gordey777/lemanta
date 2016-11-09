<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', 'D:\Dropbox\projects\your-revolution1905.dev\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'p284179_demo5');

/** Имя пользователя MySQL */
define('DB_USER', 'p284179_demo5');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'YEar2Eg5gs');

/** Имя сервера MySQL */
define('DB_HOST', 'p284179.mysql.ihc.ru');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');
define('DISALLOW_FILE_EDIT', true);
/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'J,+wH},||ztV,<?g(RD|6nD,Qe)ZFZgJ:k}APqDCLwUq}V8k^@c%! F<0!]r87FU');
define('SECURE_AUTH_KEY',  '@cF,jRbr-f4-d2;Y]02[3^w=2.r-#D0rMrrrEWwxJpT7ujIxKrR$g|@-EG~b*=e2');
define('LOGGED_IN_KEY',    'JVVK5bW]eWxs$w+{?Upg;]T[Rr0O(K=MxeD)/~//waiInef&lUYBm6J-yw|/Fp)}');
define('NONCE_KEY',        '+QYqa~BKRyp+jd,tW*@!*L,0f+ax=)wy+oKFaS#+5`?s8OAsl<}_+ k~/3AlI7p[');
define('AUTH_SALT',        '0&!e|APk:dMhB x*!ZG!BLo2-/9rD!|ex}^qZ@Dw}@uRG&vN/JSX*v?-C1H)Ac}.');
define('SECURE_AUTH_SALT', 'BP<Ol9?tn(-T6u@yY!F+fO|i>*-ozd~JnV9rj0Z|/+hg [`/r2+#F@KGOHBGi&(e');
define('LOGGED_IN_SALT',   'Hy@[O@M^n4)4qX7. |;urlIY~$!arlwxs7a+.{((.~-6=E*h}W#VY+]:1K=)JN*z');
define('NONCE_SALT',       'wjQt+?<.S|9qxo^/k8!7`X,4%X%%sR]r[Q{4F;:fW5$FQ_m:}b2f}Pp;M*2I[/Z@');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
