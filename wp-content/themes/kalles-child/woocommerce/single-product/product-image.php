<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product, $kalles_featured_product;

$is_kalles_lazyload = kalles_image_lazyload_class(false);

$attachment_ids   = the4_woo_get_variable_gallery();
$all_variant_image = the4_woo_get_all_variant_image();
$attachment_count = count( $product->get_gallery_image_ids() );

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

// Get product single style
$style = ( is_array( $options ) && $options['wc-single-style'] ) ? $options['wc-single-style'] : ( cs_get_option( 'wc-single-style' ) ? cs_get_option( 'wc-single-style' ) : '1' );

$classes        = array( 'single-product-thumbnail pr' );
$p_thumb        = array( 'p-thumb images woocommerce-product-gallery' );
$thumb_position = ( is_array( $options ) && $options['wc-single-style'] == 1 && $options['wc-thumbnail-position'] ) ? $options['wc-thumbnail-position'] : ( cs_get_option( 'wc-thumbnail-position' ) ? cs_get_option( 'wc-thumbnail-position' ) : 'left' );

//Setting thumbnail position for Featured product elementor Widget
if ( isset( $kalles_featured_product ) && isset( $kalles_featured_product['thumbnail_position'] ) ) {
	$thumb_position = $kalles_featured_product['thumbnail_position'];
}

if ( $thumb_position && $style == 1 ) {
	$classes[] = $thumb_position;
}

if ( $attachment_count == 0 ) {
	$classes[] = 'no-nav';
}

if ( $style == 1 ) {
	$attr = 'data-slick=\'{"slidesToShow": 1, "slidesToScroll": 1, "adaptiveHeight":true, "asNavFor": ".p-nav", "fade":true'. ( is_rtl() ? ',"rtl":true' : '' ) .'}\'';
	$p_thumb[] = 'the4-carousel';
} elseif ( $style == 2 ) {
	$attr = 'data-masonryjs=\'{"selector":".p-item", "layoutMode":"masonry"' .( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) .'}\'';
	$p_thumb[] = 'the4-masonry';

	if ( $attachment_count < 1 ) {
		$p_thumb[] = 'columns-full';
	}
} else {
	if ( wp_is_mobile() ) {
		$attr = 'data-slick=\'{"responsive":[{"breakpoint": 736,"settings":{"slidesToShow": 1, "vertical": false, "arrows": true, "dots":true}}]'. ( is_rtl() ? ',"rtl":true' : '' ) .'}\'';
		$p_thumb[] = 'the4-carousel';
	} else {
		$attr = '';
	}
}
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="main-img-wrapper pr">
		<div class="<?php echo esc_attr( implode( ' ', $p_thumb ) ); ?>" <?php echo wp_kses_post( $attr ); ?>>
			<?php
				if ( has_post_thumbnail() ) {
					$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
					
					$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
					$thumbnail_post    = get_post( $post_thumbnail_id );
					$image_title       = $thumbnail_post->post_content;

					$attributes = array(
						'title'                   => $image_title,
						'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-zoom-image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
						'class' => 'the4-product-image',
					);

					$zoom = '';
					if ( cs_get_option( 'wc-single-zoom' ) ) {
						$zoom = ' the4-image-zoom';
					}

					$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="p-item woocommerce-product-gallery__image' . $zoom . '"><a class="single-product-img-link" href="' . esc_url( $full_size_image[0] ) . '">';
						if ( $is_kalles_lazyload )
							$html .= '<div class="single-product-img-wrapper the4-lazyload">';
						$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
						if ( $is_kalles_lazyload )
							$html .= '</div>';
					$html .= '</a></div>';

				} else {
					$html  = '<div class="woocommerce-product-gallery__image">';
						$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'kalles' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

				foreach ( $attachment_ids as $attachment_id ) {
	
					$html = the4_woo_variable_gallery_main( $attachment_id, $all_variant_image, $product->is_type( 'variable' ), $post_thumbnail_id, $zoom );
					
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
			?>
		</div>
		<div class="kalles_product_image_action pa">
			<?php do_action( 'kalles_product_image_action' ); ?>
		</div>
	</div> <!-- .main-img-wrapper -->
	<?php
		if ( $style == 1 && $thumb_position != 'outside' ) {
			echo '<div class="kales-thumb-outsite">';

			do_action( 'woocommerce_product_thumbnails' );
			if ( $thumb_position != 'bottom' && $attachment_count > 0 ) {
				echo '		<button type="button" aria-label="Previous" class="btn_pnav_prev"><i class="t4_icon_angle-up-solid"></i></button><button type="button" aria-label="Next" class="btn_pnav_next"><i class="t4_icon_angle-down-solid"></i></button>';
			}
			echo '</div>';
		}
	?>
	
</div>