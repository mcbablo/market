<?php


/**
 * Initialize framework and libraries.
 *
 * @since   1.0.3
 * @package Kalles
 */

namespace Kalles;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

final class Theme_Bootstrap {


	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.1.2
	 * @return object
	 */

	private $the4_class = array();

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	public function __construct()
	{
		require_once THE4_KALLES_PATH . '/classes/kalles-class-autoload.php';

		$this->bootstrap();

	}

	/**
	 * Bootstrap theme
	 *
	 * @since 1.1.2
	 *
	 * @return object
	 */

	public function bootstrap()
	{
		$this->include_file();
		if ( is_admin() ) {
			$this->include_admin_file();
		}
		$this->instanceObject('autoload');
		$this->instanceObject('enqueue');
		$this->instanceObject('lazyload');

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		    $this->instanceObject('woocommerce');
		}

		$this->get_class();
	}

	/**
	 * Load Class Object
	 *
	 * @since 1.1.2
	 *
	 * @return object
	 */

	public function loadObject( $className )
	{

		$className = ucwords( $className, '_' );
		$className = "\Kalles\\" . $className;

		if ( class_exists( $className ) ) {
			return $className;
		}
	}

	/**
	 * Load Class Object
	 *
	 * @since 1.1.2
	 *
	 * @return object
	 */

	public function instanceObject( $className )
	{

		$className = ucwords( $className, '_' );
		$className = "\Kalles\\" . $className;

		if ( class_exists( $className ) ) {
			return $className::instance();
		}
	}

	public function include_file()
	{
		// Vendor libraries
		$libs = 'codestar-framework, elementor, woocommerce, tgmpa, aq-resizer, wcfm';
		$libs = array_map( 'trim', explode( ',', $libs ) );

		foreach ( $libs as $lib ) {
			include THE4_KALLES_PATH . '/inc/plugins/' . $lib . '/init.php';
		}

		include THE4_KALLES_PATH . '/inc/hooks/action.php';
		include THE4_KALLES_PATH . '/inc/hooks/filter.php';
		include THE4_KALLES_PATH . '/inc/hooks/helper.php';
		include THE4_KALLES_PATH . '/inc/hooks/option.php';
		include THE4_KALLES_PATH . '/inc/hooks/template-tag.php';
		include THE4_KALLES_PATH . '/inc/support/menu.php';
		include THE4_KALLES_PATH . '/inc/widgets/widget.init.php';
	}


	public function include_admin_file()
	{
		require THE4_KALLES_ADMIN_PATH . '/admin_init.php';
	}

	public function get_class()
	{
		if ( class_exists('\Kalles\The4_Social_Auth') && cs_get_option('woocommerce_account-social') ) {

			require_once KALLES_ADDONS_PATH . 'includes/vendor/autoload.php';
			new \Kalles\The4_Social_Auth;
		}
	}
}