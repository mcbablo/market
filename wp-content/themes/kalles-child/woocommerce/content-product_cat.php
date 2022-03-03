<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Extra post classes
$classes = array( 'mt__30 pr' );

// Get sub-category columns
$classes[] = 'col-md-' . cs_get_option( 'wc-sub-cat-column' ) . ' col-sm-6 col-xs-12';

// Get sub-category layout
$layout = cs_get_option( 'wc-sub-cat-layout' );
?>
<div <?php wc_product_cat_class( $classes, $category ); ?>>
	<?php
	/**
	 * woocommerce_before_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_open - 10
	 */
	do_action( 'woocommerce_before_subcategory', $category );

	$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true  );

	if ( $layout == 'grid' ) {
		$size = 'shop_catalog';
	} else {
		$size = '';
	}

	if ( $thumbnail_id ) {
		$image = wp_get_attachment_image_src( $thumbnail_id, $size );
		$w     = $image[1];
		$h     = $image[2];
		$image = $image[0];
	} else {
		$image = wc_placeholder_img_src();
		$w = $h = 450;
	}

	if ( $image ) {
		// Prevent esc_url from breaking spaces in urls for image embeds
		// Ref: http://core.trac.wordpress.org/ticket/23605
		$image = str_replace( ' ', '%20', $image );

		echo '<img class="w__100" src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $w ) . '" height="' . esc_attr( $h ) . '" />';
	}

	/**
	 * woocommerce_shop_loop_subcategory_title hook.
	 *
	 * @hooked woocommerce_template_loop_category_title - 10
	 */
	do_action( 'woocommerce_shop_loop_subcategory_title', $category );

	/**
	 * woocommerce_after_subcategory_title hook.
	 */
	do_action( 'woocommerce_after_subcategory_title', $category );

	/**
	 * woocommerce_after_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_close - 10
	 */
	do_action( 'woocommerce_after_subcategory', $category ); ?>
</div>
