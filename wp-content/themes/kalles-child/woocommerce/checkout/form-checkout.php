<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( cs_get_option( 'wc-checkout-layout' ) == 'layout_2' ) {
    wc_get_template( 'checkout/layouts/layout_2.php', array( 'checkout' => $checkout ) );
} else {
    wc_get_template( 'checkout/layouts/layout_1.php', array( 'checkout' => $checkout ) );
}
?>

