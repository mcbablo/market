<?php


/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'clickmarket' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '3015130' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'C!D;iI?>wi[DMPKmC?W1U9:Uz]?UaP_N~J%RC:`75ww-;3=>TG4{JgpLW_sJ$vS=' );
define( 'SECURE_AUTH_KEY',  'AP+/D2cc3A5K$Dn8goI>);B*oL.v*Whc$$0|VPmg(h(Uk7}#6_2mh=dg[><.v|7M' );
define( 'LOGGED_IN_KEY',    'j18_6[Q,69B!(_[o_v@I9k>]`on)mMmO>%LUZ)m>d~NJL/W++a_1TAtvHFHp{4oG' );
define( 'NONCE_KEY',        '9@/9_-#3b!XR(X[52xF:2oR|/}w_u+Xy<$xU#F+NrL<R=!aV;dIle>0:xvc$iP*q' );
define( 'AUTH_SALT',        'pj  v{n,DY,1O?1o/qBl3lOTa,d-@^E`6fs8&;1S<}CN]OX4jwVO@Ma|KcvJ}c|i' );
define( 'SECURE_AUTH_SALT', ';+/5?Ci(W^:Kr|<AUo.a~Mb $u?RmyY&`goV`AYLwNY`J C-nFr8klQ2A%L{7?o$' );
define( 'LOGGED_IN_SALT',   'QV4}5%Yu$7$;Sk}S|fK,5<`4Ya+cW[$S#K6YU+JyuV/W5.9v?0.m_0 AZ5W~FSP!' );
define( 'NONCE_SALT',       'OfGR/Y`@sFe9Y T3`KrQiO)K]p094wgZ7=:H65OCzJHYgAds,t(Z9V. *q;y~2 m' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

define( 'WP_DEBUG_LOG', true );

define('WP_MEMORY_LIMIT', '256M');

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';

define('FS_METHOD', 'direct');
