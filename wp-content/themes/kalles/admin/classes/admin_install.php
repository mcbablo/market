<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

class The4_Admin_Install {

	public function __construct()
	{
		if ( The4_Admin_Activation::isActive() ) return;
		add_action( 'after_switch_theme', [ __CLASS__, 'after_active_theme'] );
		add_action( 'admin_notices', [ __CLASS__, 'theme_active_notice'] );

	}

	/**
	 * Setup theme when active
	 *
	**/
	public static function after_active_theme()
	{


		wp_redirect( admin_url( '/admin.php?page=the4-dashboard' ) );
	}

	/**
	 * Notice theme active
	 *
	**/
	public static function theme_active_notice()
	{
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<b>The Kalles theme is almost ready.</b> <a href="<?php echo esc_url( admin_url( '/admin.php?page=the4-dashboard' ) ); ?>">Active theme</a> to complete your theme options and import demo from online library. 
			</p>
		</div>
		<?php
	}

}

new The4_Admin_Install();