<?php
/**
 * Theme constants definition and functions.
 *
 * @since   1.0.0
 * @package Kalles
 */

if ( ! defined( 'DS' ) ) {
    define( 'DS' , DIRECTORY_SEPARATOR);
}
// Constants definition THE4_THEME_NAME
define( 'THE4_THEME_NAME'              , 'kalles');
define( 'THE4_KALLES_VERSION'          , '1.0.0' );
define( 'THE4_KALLES_PATH'             , get_template_directory()     );
define( 'THE4_KALLES_URL'              ,  get_template_directory_uri() );
define( 'THE4_KALLES_ADMIN_PATH'       , get_template_directory() . DS . 'admin' );
define( 'THE4_KALLES_ADMIN_URL'        , get_template_directory_uri() . '/admin' );
define( 'THE4_KALLES_INC_PATH'         , THE4_KALLES_PATH . DS . 'inc'     );
define( 'THE4_KALLES_WIDGET_PATH'      , THE4_KALLES_INC_PATH . DS . 'widgets'     );
define( 'THE4_KALLES_PLUGINS_PATH'     , THE4_KALLES_INC_PATH . DS . 'plugins'     );
define( 'THE4_KALLES_PLUGINS_URL'      , THE4_KALLES_URL . '/inc/plugins'     );
define( 'THE4_KALLES_CS_FRAMEWORK_PATH', THE4_KALLES_PLUGINS_PATH . DS . 'codestar-framework' );
define( 'THE4_KALLES_CS_FRAMEWORK_URL' , THE4_KALLES_PLUGINS_URL . '/codestar-framework');

// Initialize class
require_once THE4_KALLES_PATH . '/classes/The4Helper.php';

// Initialize core file
require_once THE4_KALLES_PATH . '/classes/kalles-class-theme-bootstrap.php';

//Let's start
\Kalles\Theme_Bootstrap::instance();


