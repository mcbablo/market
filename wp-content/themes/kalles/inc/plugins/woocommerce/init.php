<?php
/**
 * Initialize woocommerce & classes
 *
 * @since   1.0.0
 * @package Kalles
 */
if ( ! class_exists( 'WooCommerce' ) ) return;

// Add this theme support woocommerce
add_theme_support( 'woocommerce' );


// Remove WooCommerce default styles.
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

remove_theme_support( 'wc-product-gallery-zoom' );


//include function
require_once THE4_KALLES_PLUGINS_PATH . DS . 'woocommerce' . DS . 'function.php';

//include function
require_once THE4_KALLES_PLUGINS_PATH . DS . 'woocommerce' . DS . 'action-hook.php';

//include ajax function
require_once THE4_KALLES_PLUGINS_PATH . DS . 'woocommerce' . DS . 'ajax-hook.php';

//include filter
require_once THE4_KALLES_PLUGINS_PATH . DS . 'woocommerce' . DS . 'filter-hook.php';

//include Template Tag
require_once THE4_KALLES_PLUGINS_PATH . DS . 'woocommerce' . DS . 'template-tags.php';

//Filter viewer

require_once THE4_KALLES_PLUGINS_PATH . DS . 'woocommerce' . DS . 'classes' . DS . 'widgets' . DS . 'The4LayeredNav.php';

/**
 * Preview Email Transaction.
 *
 * @since  1.0
 */
$preview = THE4_KALLES_PATH . DS . 'woocommerce' . DS . 'woo-preview-emails.php';
if ( file_exists( $preview ) ) {
    include $preview;
}

