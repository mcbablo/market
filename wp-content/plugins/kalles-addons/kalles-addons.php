<?php
/**
 * Plugin Name: Kalles Addons
 * Plugin URI:  http://www.the4.co
 * Description: Extra addons for Kalles theme.
 * Version:     1.0.4
 * Author:      The4
 * Author URI:  http://www.the4.co
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kalles
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'DS' ) ) {
    define( 'DS' , DIRECTORY_SEPARATOR);
}

// Define url to this plugin file.
	define( 'KALLES_ADDONS_URL'        , plugin_dir_url( __FILE__ ) );
	define( 'KALLES_ADDONS_PATH'       , plugin_dir_path( __FILE__ ) );
	define( 'KALLES_ADDONS_VIEW'       , KALLES_ADDONS_PATH . 'views' );
	define( 'KALLES_ADDONS_CLASS_PATH' , KALLES_ADDONS_PATH . 'includes' . DS . 'classes' . DS );
	define( 'KALLES_ADDONS_WIDGET_PATH', KALLES_ADDONS_PATH . 'includes' . DS . 'widgets' . DS);

/**
 * Class KallesAddons
 *
 * @package  KallesAddons
 * @since    1.0.0
 */
class Kalles_Addons {
	/**
	 * Construct function.
	 *
	 * @return  void
	 */
	function __construct() {
		add_action( 'init',               array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ), 100 );

		add_action( 'widgets_init', array( $this, 'register_widget' )  );
		add_action( 'plugins_loaded', array( $this, 'load_translate' )  );
		
		
	}
	
 	// Load plugin text domain
	public function load_translate()
	{
		load_plugin_textdomain( 'kalles', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Indicates if a multi-currency plugin is active. In such case, the currency
	 * addon should not be loaded.
	 *
	 * @return bool
	 * @author Aelia
	 */
	protected static function is_multi_currency_plugin_active() {
		return
		// WPML
		class_exists( 'woocommerce_wpml' ) ||
		// WooCommerce Prices Based on Country
		class_exists( 'WC_Product_Price_Based_Country' ) ||
		// Aelia Currency Switcher
		isset( $GLOBALS['woocommerce-aelia-currencyswitcher'] ) ||
		// WooComerce Wallet
		isset( $GLOBALS['woo_wallet'] ) ||
		// WooComerce Wallet
		defined( 'WOOCOMMERCE_MULTICURRENCY_VERSION' ) ||
		// WooComerce Currency Switcher
		isset( $GLOBALS['WOOCS'] );
	}

	/**
	 * Get list addon name.
	 *
	 * @return  array
	 */
	public static function addons( $addons = NULL ) {
		if ( ! self::is_multi_currency_plugin_active() ) {
			$addons = 'currency';
		} else {
			$addons = '';
		}
		return apply_filters( 'the4_addons_filter', $addons );
	}

	/**
	 * Get list shortcode name.
	 *
	 * @return  array
	 */
	public static function shortcodes( $shortcodes = NULL ) {
		$shortcodes = 'service, portfolio, member, blog, products, product, google_maps, wc_categories, banner, multi_banners, promotion, heading, theme-helper, brands';
		return $shortcodes;
	}

	/**
	 * Include addon file.
	 *
	 * @since 1.0
	 */
	public static function init() {
		$addons     = array_map( 'trim', explode( ",", self::addons() ) );
		$shortcodes = array_map( 'trim', explode( ",", self::shortcodes() ) );

		// Include addon
		if ( ! self::is_multi_currency_plugin_active() ) {
			foreach ( $addons as $addon ) {
				include_once KALLES_ADDONS_PATH . 'includes/' . $addon . '/init.php';
			}
		}

		// Include shortcode
		foreach ( $shortcodes as $shortcode ) {
			include_once KALLES_ADDONS_PATH . 'includes/shortcodes/' . $shortcode . '.php';
			add_shortcode( 'kalles_addons_' . $shortcode, 'kalles_addons_shortcode_' . $shortcode );
		}

		//Include widget init
		include KALLES_ADDONS_PATH . 'includes/widgets/widget.init.php';

		if ( class_exists( 'WooCommerce' ) && defined( 'THE4_KALLES_VERSION' ) ) {

			include KALLES_ADDONS_CLASS_PATH . 'woocommerce/The4Product360.php';
			include KALLES_ADDONS_CLASS_PATH . 'woocommerce/swatches/The4Swatches.php';
			include KALLES_ADDONS_CLASS_PATH . 'woocommerce/The4Compare.php';

			if ( cs_get_option( 'wc-discount-by-qty' ) ) {
				include KALLES_ADDONS_CLASS_PATH . 'woocommerce/discount/The4Discount.php';				
			}

			if ( cs_get_option('wc_general_wishlist-type') ) {
				include KALLES_ADDONS_CLASS_PATH . 'woocommerce/The4Wishlist.php';
			}

		}
	}

	/**
	 * Enqueue stylesheet and scripts to backend.
	 */
	public static function backend_scripts() {

		wp_enqueue_script( 'kalles-addon-script', KALLES_ADDONS_URL . 'assets/js/admin.js', array(), false, true );
		wp_enqueue_style( 'kalles-addon-style', KALLES_ADDONS_URL . '/assets/css/admin.css' );

	}

	/**
	 * Enqueue stylesheet and scripts to frontend.
	 */
	public static function frontend_scripts() {

		wp_enqueue_script( 'kalles-addon-script-frontend', KALLES_ADDONS_URL . 'assets/js/frontend.js', array(), false, true );

		if ( class_exists( 'Kalles_Addons_Currency' ) ) {
			wp_enqueue_script( 'the4-vendor-jquery-cookies', KALLES_ADDONS_URL . 'assets/js/3rd.js', array(), false, true );
		}

		if ( class_exists( 'WooCommerce') ) {
			if ( is_product() ) {
				global $post;

				$product = wc_get_product( $post->ID );

	            wp_localize_script( 'kalles-addon-script-frontend', 't4DiscountPrice', 
	                array(
	                    'product_type'     => $product->get_type()
	                ) 
	            );
			}
		}
		

		if ( is_singular() ) {
			global $post;

			if ( has_shortcode( $post->post_content, 'kalles_addons_google_maps' ) ) {
				wp_enqueue_script( 'google-map-api', 'https://maps.google.com/maps/api/js?key=AIzaSyBiyBHqKfGcCN1Pw0rzysj-vMSnJ0_GNgU' );
			}

			if ( has_shortcode( $post->post_content, 'the4_vertical_slide' ) ) {
				wp_enqueue_style( 'multiscroll', KALLES_ADDONS_URL . '/assets/vendors/multiscroll/jquery.multiscroll.css' );
				wp_enqueue_script( 'easings', KALLES_ADDONS_URL . 'assets/vendors/multiscroll/jquery.easings.min.js', array(), false, true );
				wp_enqueue_script( 'multiscroll', KALLES_ADDONS_URL . 'assets/vendors/multiscroll/jquery.multiscroll.min.js', array(), false, true );
			}
		}
	}

	/**
	 * Enqueue stylesheet and scripts to frontend.
	 */
	public static function register_widget()
	{
		if ( file_exists( KALLES_ADDONS_WIDGET_PATH . 'recent-posts.php' ) ) {
			include KALLES_ADDONS_WIDGET_PATH . 'recent-posts.php';
			register_widget('Kalles_Widget_Recent_Posts');
		}
	}
}

$kallesaddons = new Kalles_Addons;

// Include CodeStar FW
if ( ! class_exists( 'CSF' ) ) {
	require_once KALLES_ADDONS_PATH . 'includes/plugin/codestar-framework/codestar-framework.php';
}

// Include custom post type
require_once KALLES_ADDONS_PATH . 'includes/portfolio/init.php';

// Include megamenu
require_once KALLES_ADDONS_PATH . 'includes/megamenu/init.php';

//Auth
require_once KALLES_ADDONS_CLASS_PATH . '/woocommerce/The4SocialAuth.php';

if ( ! class_exists( 'OCDI_Plugin' ) && is_admin() ) {
	require_once KALLES_ADDONS_PATH . '/includes/plugin/one-click-demo-import/one-click-demo-import.php';
}


/**
 * @param $value
 *
 * @return array
 */
function kalles_vc_build_link( $value ) {

    $result = array(
        'url' => '',
        'title' => '',
        'target' => '',
        'rel' => '',
    );
    $params_pairs = explode( '|', $value );
    if ( ! empty( $params_pairs ) ) {
        foreach ( $params_pairs as $pair ) {
            $param = preg_split( '/\:/', $pair );
            if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
                $result[ $param[0] ] = rawurldecode( $param[1] );
            }
        }
    }

    return $result;
}