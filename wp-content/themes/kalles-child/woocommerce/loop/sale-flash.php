<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $price;

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

// Sale badge type
$badge = cs_get_option( 'wc-badge-type' );

$postdate      = get_the_time( 'Y-m-d' );
$postdatestamp = strtotime( $postdate );

// Get time to set new product (day(s))
if ( isset( $options['wc-single-new-arrival'] ) ) {
	$new = $options['wc-single-new-arrival'];
} else {
	$new = cs_get_option('wc_label_setting-new_days') ? cs_get_option('wc_label_setting-new_days') : '5';
}

if ( $product->is_on_sale() || ! $product->is_in_stock() || ( ( time() - ( 60 * 60 * 24 * (int) $new ) ) < $postdatestamp ) ) :
?>
<span class="badge tc fs__12">

	<?php

		if ( $product->is_featured() && cs_get_option( 'wc_label_setting-hot' ) ) {
			echo '<span class="featured product-label">' . esc_html__( 'Hot', 'kalles' ) . '</span>';
		}
		if ( $product->is_on_sale() && cs_get_option( 'wc_label_setting-sale' ) ) {
			if ( $badge == 'text' ) {
				echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale product-label">' . esc_html__( 'Sale', 'kalles' ) . '</span>', $post, $product );
			} else {
				$regular_price = $product->get_regular_price();
				$sale_price    = $product->get_sale_price();
				$round_type = cs_get_option( 'wc-badge-round' );

				if ( $regular_price != '' && ! $product->is_type( 'variable' ) ) {
					$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );

					if ( $round_type == 'round-up' ) {
						$percentage = ceil( $percentage );
					} elseif ( $round_type == 'round-down' ) {
						$percentage = floor($percentage * 100) / 100;
					}
					echo '<span class="onsale product-label">' . $price . sprintf( esc_html__('-%s', 'kalles' ), $percentage . '%' ) . '</span>';
				} elseif ( $product->is_type( 'variable') && ! $product->is_type( 'grouped') ) {
					$available_variations = $product->get_available_variations();
					$maximumper = 0;
					for ($i = 0; $i < count($available_variations); ++$i) {
						$variation_id      = $available_variations[$i]['variation_id'];
						$variable_product1 = new WC_Product_Variation( $variation_id );
						$regular_price     = $variable_product1 ->get_regular_price();
						$sales_price       = $variable_product1 ->get_price() ? $variable_product1->get_price() : 0;
						$percentage        = round((( ( $regular_price - $sales_price ) / $regular_price ) * 100),1) ;
							if ($percentage > $maximumper) {
								$maximumper = $percentage;
							}
						}
					if ( $round_type == 'round-up' ) {
						$maximumper = ceil( $maximumper );
					} elseif ( $round_type == 'round-down' ) {
						$maximumper = floor( $maximumper );
					} elseif ( $round_type == 'round' ) {
						$maximumper = round ( $maximumper, 0 );
					}

					echo '<span class="onsale product-label">' . $price . sprintf( esc_html__('-%s', 'kalles' ), $maximumper . '%' ) . '</span>';
				}
			}
		}

		if ( ! $product->is_in_stock() && cs_get_option( 'wc_label_setting-sold_out' ) ) {
			echo '<span class="sold-out product-label">' . esc_html__( 'Sold Out', 'kalles' ) . '</span>';
		} else {
			if ( ( time() - ( 60 * 60 * 24 * (int) $new ) ) < $postdatestamp && cs_get_option( 'wc_label_setting-new' ) ) {
				echo '<span class="new product-label">' . esc_html__( 'New', 'kalles' ) . '</span>';
			}
		}
	?>
</span>
<?php endif;