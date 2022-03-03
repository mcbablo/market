<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $kalles_featured_product;

$is_kalles_lazyload = kalles_image_lazyload_class(false);

$attachment_ids   = the4_woo_get_variable_gallery();
$all_variant_image = the4_woo_get_all_variant_image();

$attachment_count = count( $attachment_ids );
$is_variable = $product->is_type( 'variable' );

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

$thumb_position = ( is_array( $options ) && $options['wc-single-style'] == 1 && $options['wc-thumbnail-position'] ) ? $options['wc-thumbnail-position'] : ( cs_get_option( 'wc-thumbnail-position' ) ? cs_get_option( 'wc-thumbnail-position' ) : 'left' );

//Setting thumbnail position for Featured product elementor Widget
if ( isset( $kalles_featured_product ) && isset( $kalles_featured_product['thumbnail_position'] ) ) {
	$thumb_position = $kalles_featured_product['thumbnail_position'];
}

if ( $thumb_position == 'outside' ) {
	$limit = $attachment_count + 1;
} else {
	$limit = 4;
}

$carousel_class = ( $thumb_position == 'left' || $thumb_position == 'right' ) ? 'the4-carousel-custom-control' : 'the4-carousel';

if ( $attachment_ids && has_post_thumbnail() ) {
	?>
	<div class="p-nav dn oh <?php echo esc_attr( $carousel_class ); ?> <?php if ( $thumb_position == 'outside' ) echo ' p-nav-outside'; ?>" data-slick='{"slidesToShow": 6, "arrows": true,  "verticalSwiping": true, "infinite": false, "slidesToScroll": 1,"asNavFor": ".p-thumb", "focusOnSelect": true, <?php if ( $thumb_position == 'left' || $thumb_position == 'right' ) echo '"vertical": true,'; ?> <?php if ( $thumb_position == 'outside' ) echo ( is_rtl() ? '"rtl":true,' : '' ); ?> "responsive":[{"breakpoint": 736,"settings":{"slidesToShow": 4, "vertical":false, "arrows": true<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}}]}'>
		<?php
		    $post_thumb_id = get_post_thumbnail_id();
		    $full_size_image  = wp_get_attachment_image_src( $post_thumb_id, 'full' );
		    $attributes = array(
				'title'	=> get_the_title( $post_thumb_id ),
				'data-src'                => $full_size_image[0],
				'data-large_image'        => $full_size_image[0],
				'data-large_image_width'  => $full_size_image[1],
				'data-large_image_height' => $full_size_image[2],
			);
			$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'thumbnail' ), $attributes );
			
			
			if ( $is_variable ) {
				$variable_img_id = the4_woo_check_image_variant_id( $post_thumb_id, $all_variant_image['variable'] );

				if ( $variable_img_id ) {
					$data_variant = 'data-variation="' . $variable_img_id . '"';
				} else {
					$data_variant= '';
				}
				
				$main_img_html = '<div class=" the4-lazyload attachment-img-wrapper" ' . $data_variant . '> ' . $image . '</div>';
			} else {
				$main_img_html = '<div class=" the4-lazyload attachment-img-wrapper"> ' . $image . '</div>';
			}	
			if ( $is_kalles_lazyload ) {
				echo apply_filters( 'woocommerce_single_product_image_html', $main_img_html, $post->ID );
			} else {
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div>%s</div>', $image ), $post->ID );
			}

			foreach ( $attachment_ids as $attachment_id ) {

			    $html = the4_woo_variable_gallery_thumb( $attachment_id, $all_variant_image, $is_variable, $post_thumb_id );
			    
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
			}
		?>
	</div>
	<?php
}
