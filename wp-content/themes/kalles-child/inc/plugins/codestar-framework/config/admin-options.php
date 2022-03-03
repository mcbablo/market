<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */


//
// Set a unique slug-like ID
//
$prefix = '_kalles_options';

// Create options
$theme_is_active = get_option( 'envate_purchase_code_kalleswp' ) ? true : false;
$white_label = get_option( '_kalles_options_white_label' );

if ($theme_is_active) {
    CSF::createOptions($prefix, array(
    // framework title
    'framework_title' => isset( $white_label['white_label-option_text'] ) ? $white_label['white_label-option_text'] : 'The4 Kalles Option' ,
    'framework_class' => '',
    'sticky_header'   => $theme_is_active,
    'menu_title'      => 'Theme Options',
    'menu_type'       => 'submenu',
    'menu_parent'     => 'the4-dashboard',
    'menu_slug'       => 'the4-theme-options',
    'theme'           => 'dark',
    'menu_hidden'     => false,
    'show_bar_menu'   => $theme_is_active,
    // footer
    'footer_text'     => isset( $white_label['white_label-option_footer_text'] ) ? $white_label['white_label-option_footer_text']  : 'Options panel created using <a href="https://codestarframework.com/">Codestar framework</a>',
    'footer_after'    => '',
    'footer_credit'   => ' ',
  ));

    $theme_configs = array(
      'general',
      'header',
      'footer',
      'popup',
      'woocommerce-general',
      'woocommerce-categories',
      'woocommerce-product',
      'woocommerce-cart-checkout',
      'blog',
      'portfolio',
      'social',
      'color-scheme',
      'typography',
      'other' );

    foreach ($theme_configs as $config) {
        $file = THE4_KALLES_CS_FRAMEWORK_PATH . DS . 'config' . DS . 'theme-config' . DS . $config . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}





