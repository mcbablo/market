<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

class The4_Admin_Activation {

	public static $option_key = 'envate_purchase_code_kalleswp';

	public function __construct()
	{
		//Active theme
		
		add_action( 'wp_ajax_the4_admin_register_key', [__CLASS__, 'active_key'] );
		add_action( 'wp_ajax_nopriv_the4_admin_register_key', [__CLASS__, 'active_key'] );

		//Deactive theme
		
		add_action( 'wp_ajax_the4_admin_deactive_theme', [__CLASS__, 'deactive_key'] );
		add_action( 'wp_ajax_nopriv_the4_admin_deactive_theme', [__CLASS__, 'deactive_key'] );
	}

	public static function isActive()
	{
		$code = get_option( self::$option_key );

		if ( $code ) {
			return true;
		} else {
			return false;
		}
	}

	public static function get_activation_info()
	{
		$info = array(
			'email' => get_option( 'admin_email' ),
			'evanto_key' => get_option( self::$option_key ),
		);

		return $info;
	}

	public static function active_key()
	{
		check_ajax_referer('t4_active_theme', 'security_code');

		$evanto_key = $_POST['evanto_key'];

		if ( ! empty( $evanto_key ) && strlen( $evanto_key ) > 2 ) {
			update_option( self::$option_key, $evanto_key );
		}
	}

	public static function deactive_key()
	{
		check_ajax_referer('t4_deactive_theme', 'security_code');

		if ( self::isActive() ) {
			delete_option( self::$option_key );
		}
	}
}
new The4_Admin_Activation();
