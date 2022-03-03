<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
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
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

// Catalog mode
$catalog_mode = cs_get_option( 'wc-catalog' );

if ( $catalog_mode ) return;

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s pr br-36 mb__10 pr_atc cd br__40 bgw tc dib  cb chp tooltip_right ttip_nt %s"><span class="tt_txt">%s</span><i class="t4_icon_t4-shopping-cart"></i><span>%s</span></a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
        esc_attr( ( cs_get_option('wc-quick-shop-enable') ) ? 'quick_shop_js' : '' ),
		esc_html( $product->add_to_cart_text() ),
		esc_html( $product->add_to_cart_text() )
	),
$product );