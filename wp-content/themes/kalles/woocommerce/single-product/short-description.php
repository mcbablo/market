<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
    if ( $post->post_content ) {
        $short_description = wp_strip_all_tags ( $post->post_content );
        $short_description = substr( $short_description, 0, 200 ) . '...';

        if ( is_single() ) {
            $short_description .= '< a href="#" id="short_description-readmore">' . translate( ' read more', 'kalles' ) . '</a>';
        }  
    } else {
        return;
    }
}

?>
<div class="woocommerce-product-details__short-description">
	<?php echo The4Helper::ksesHTML( $short_description ); // WPCS: XSS ok. ?>
</div>
