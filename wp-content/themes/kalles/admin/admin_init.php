<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.


if ( file_exists( THE4_KALLES_ADMIN_PATH . '/classes/admin_activation.php' ) ) {
	require_once THE4_KALLES_ADMIN_PATH . '/classes/admin_activation.php';
}

if ( class_exists( 'OCDI_Plugin' ) && is_admin() && ! t4_white_label('white_label-import', false) ) {
	require_once THE4_KALLES_ADMIN_PATH . '/inc/ocdi-init.php';
}


/**
 * Setup theme when active
 *
**/
if ( file_exists( THE4_KALLES_ADMIN_PATH . '/classes/admin_install.php' ) ) {
	require_once THE4_KALLES_ADMIN_PATH . '/classes/admin_install.php';
}

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_enqueue_admin_scripts' ) ) {
	function the4_kalles_enqueue_admin_scripts() {
		wp_register_script( 'kalles-backend-js', THE4_KALLES_ADMIN_URL . '/assets/js/admin.js', array(), '', true );

		$kalles_admin_data_js = array(
			'T4_AjaxURL'     => admin_url('admin-ajax.php'),
			'T4_ActiveNonce' => wp_create_nonce('t4_active_theme'),
			'T4_ThemeItem'   => 'kalleswp',
			'T4_ShopURL'     => t4_get_site_url(),
			'T4_isActive'    => The4_Admin_Activation::isActive()
		);

		wp_localize_script( 'kalles-backend-js', 'T4_ADMIN_JS', $kalles_admin_data_js );

		wp_enqueue_script( 'kalles-backend-js' );

		wp_enqueue_style( 'the4-admin-style', THE4_KALLES_ADMIN_URL . '/assets/css/admin.css', [], rand(1,999), 'all');
		wp_enqueue_style( 'the4-admin-layout', THE4_KALLES_ADMIN_URL . '/assets/css/layout.css', [], '', 'all');

		if ( isset( $_GET['page'] ) && $_GET['page'] == 'the4-manage-currencies' ) {
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
		}

	}
}
add_action( 'admin_enqueue_scripts', 'the4_kalles_enqueue_admin_scripts' );

/**
 *
 * GET site URL without http
 * 
 */
 function t4_get_site_url() {
     $permalink = get_site_url();
     $find = array( 'http://', 'https://' );
     $replace = '';
     $output = str_replace( $find, $replace, $permalink );
     return $output;
 }
