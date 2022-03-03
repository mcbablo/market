<?php
/**
 * Register the required plugins for this theme.
 *
 * @since   1.0.0
 * @package Kalles
 */
// Include the TGM_Plugin_Activation class.
include THE4_KALLES_PLUGINS_PATH . '/tgmpa/class-tgm-plugin-activation.php';


/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function the4_kalles_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => esc_html__( 'Kalles Addons', 'kalles' ),
			'slug'     => 'kalles-addons',
			'source'   => 'https://wp.the4.co/plugin/kalles-addons.zip',
			'version' => '1.0.4',
			'required' => true,
		),
		array(
			'name'    => esc_html__( 'Elementor', 'kalles' ),
			'slug'    => 'elementor',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'The4 Elementor Pack', 'kalles' ),
			'slug'     => 'the4-elementor-pack',
			'source'   => 'https://wp.the4.co/plugin/the4-elementor-pack.zip',
			'version' => '1.0.1',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'WooCommerce', 'kalles' ),
			'slug'     => 'woocommerce',
			'required' => true,
		),
		array(
			'name'      => esc_html__( 'Slider Revolution', 'kalles' ),
			'slug'      => 'revslider',
			'source'	=> 'https://wp.the4.co/plugin/revslider.zip',
			'required'  => true,
			'version'  => '6.5.16',
		),
		array(
			'name'     => esc_html__( 'Pin Maker', 'kalles' ),
			'slug'     => 'pin-maker',
			'source'   => 'https://wp.the4.co/plugin/pin-maker.zip',
			'version'  => '1.0.9',
		),

		array(
			'name'     => esc_html__( 'WPA WooCommerce Product Bundle', 'kalles' ),
			'slug'     => 'wpa-woocommerce-product-bundle',
			'source'   => 'https://wp.the4.co/plugin/wpa-woocommerce-product-bundle.zip',
			'version'  => '1.2.5',
			'external_url' => false
		),
		array(
			'name'      => esc_html__( 'MailChimp', 'kalles' ),
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
			),
		array(
			'name'      => esc_html__( 'Smash Balloon Instagram Feed', 'kalles' ),
			'slug'      => 'instagram-feed',
			'required'  => false,
		),
		array(
			'name'      => esc_html__( 'MyShopKit Popup SmartBar SlideIn', 'kalles' ),
			'slug'      => 'myshopkit-popup-smartbar-slidein',
			'required'  => false,
		)

	);

	if ( ! defined( 'WPFORMS_VERSION' ) ) {
		$plugins[] = array(
			'name'      => esc_html__( 'Contact Form 7', 'kalles' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
		);
	}

	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'the4-install-plugins', 			// Menu slug.
		'parent_slug'  => 'admin.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'the4_kalles_register_required_plugins' );

function the4_plugins_menu_args($args) {

    $args['parent_slug'] = 'the4-dashboard';
    return $args;
}

add_filter( 'tgmpa_admin_menu_args', 'the4_plugins_menu_args' );


