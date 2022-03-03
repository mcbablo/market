<?php
/**
 * Plugin Name: The4 Elementor Parck
 * Plugin URI:  http://www.the4.co
 * Description: Extras layout libaray for Elementor
 * Version:     1.0.1
 * Author:      The4
 * Author URI:  http://www.the4.co
 * License:     GNU/GPL v or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kalles-addons
 *
 * @package The4-elementor-pack
 * 
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Define url to this plugin file.
if ( ! defined( 'THE4_ADDONS_URL' ) )
	define( 'THE4_ADDONS_URL', plugin_dir_url( __FILE__ ) );

// Define path to this plugin file.
if ( ! defined( 'THE4_ADDONS_PATH' ) )
	define( 'THE4_ADDONS_PATH', plugin_dir_path( __FILE__ ) );


define( 'THE4_ELEMENTOR_PACK_VER', '1.0.0' );
define( 'THE4_ELEMENTOR_PACK_TEMPLATE_PATH', THE4_ADDONS_PATH . 'templates' );
define( 'THE4_ELEMENTOR_PACK_EDITOR_TEMPLATE_PATH', THE4_ADDONS_PATH . 'templates/editor-templates' );

//Autoload

require THE4_ADDONS_PATH . 'vendor/autoload.php';

/**
 *
 * Instance The4ElementorParck
 *
 * @return The4ElementorParck
 * 
 */
function init_the4_elementor_pack() {
    if ( ! did_action( 'elementor/loaded' ) ) { 
        return;
    }
    The4\The4LibraryApi::instance()->get_items();
    
    new The4\The4ImportTemplate();

    if ( class_exists( 'The4\The4ElementorPack' )) {
        return The4\The4ElementorPack::instance()->init();
    }

}

init_the4_elementor_pack();
if ( is_admin() ) {
    init_the4_elementor_pack();
}