<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post, $kalles_sc;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
// Get product options
$options = get_post_meta( get_the_ID(), '_custom_wc_thumb_options', true );
if ( $term ) {
    $term_style = get_term_meta(get_the_ID(), '_custom_product_cat_options', true);
}
// Get wc style
$style = $kalles_sc ? $kalles_sc['style'] : apply_filters( 'the4_kalles_wc_style', cs_get_option( 'wc-style' ) );

$metro = '';

if (( isset( $options['wc-thumbnail-size'] ) && $options['wc-thumbnail-size'] && $style == 'metro') || ( isset( $term_style['wc-style'] )  && $term_style['wc-style'] && $term_style == 'metro')  ) {
	$large = 2;
	$metro = ' metro-item';
} else {
	$large = 1;
}

// Extra post classes
$classes = array();

$col = 0;

if ( cs_get_option( 'wc-column' ) == 'listt4' ) {
   $col = 'listt4'; 
} else {
    $col = (int) cs_get_option( 'wc-column' ) * $large . $metro;
}

if ( isset( $_COOKIE['t4_cat_col'] ) && $_COOKIE['t4_cat_col'] ) {
    $col = $_COOKIE['t4_cat_col'] == 'listt4' ?  'listt4' : (int) $_COOKIE['t4_cat_col'] * $large . $metro;
}
if ( isset( $kalles_sc['columns'] ) && $kalles_sc['columns'] ) {
    $col = (int) $kalles_sc['columns'] * $large . $metro;
}

$classes[] = 'col-lg-' . $col . ' col-md-' . $col . ' col-sm-4 mt__30 col-6';

//get product listing style setting
$product_style = cs_get_option('wc_categories_product-style') ? cs_get_option('wc_categories_product-style') : 'default';

if ( $product_style == 'layout-4' || $product_style == 'layout-6' ) {
    $classes[] = 'icon_on_hover';
    $classes[] = 'action-bg-transparent'; 
}

if ( $product_style == 'layout-5' ) {
    $classes[] = 'full_info';
    $classes[] = 'action-bg-transparent'; 
}

// Product style class
$classes[] = $product_style;

//Check is Widget Deal of the day

if ( isset( $kalles_sc['type'] ) && $kalles_sc['type'] == 'product-deal' ) {
    $product_style = 'deal';
}

?>
<div <?php wc_product_class( $classes, $product ); ?>>
	<div class="product-inner pr">

		<?php wc_get_template_part( 'content', 'product-' . $product_style); ?>

	</div><!-- .product-inner -->
</div>
