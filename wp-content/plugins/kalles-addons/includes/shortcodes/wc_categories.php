<?php
/**
 * Blog shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_wc_categories' ) ) {
	function kalles_addons_shortcode_wc_categories( $atts, $content = null ) {
		global $post;

		$output = $data = $sizer = $image_size = '';

		extract( shortcode_atts( array(
			'layout'  => 'grid',
			'columns' => 4,
			'exclude' => '',
			'large'   => '',
			'class'   => '',
		), $atts ) );

		$classes = array( 'the4-sc-wc-categories sub-categories ' . $class );

		$inner = array( 'row' );
		if ( $layout != 'grid' ) {
			$inner[] = 'the4-masonry';
			$data    = 'data-masonryjs=\'{"selector":".product-category", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
			$sizer   = '<div class="grid-sizer size-' . esc_attr( $columns ) . '"></div>';
		}
		if ( $layout != 'masonry' ) {
			$image_size = 'shop_catalog';
		}

		// Get large item
		$large = array_map( 'trim', explode( ',', $large ) );
		$i = 0;

		// Get product category
		$terms = get_terms( 'product_cat', array( 'hide_empty' => 0, 'exclude' => explode( ',', $exclude ) ) );

		$output .= '<div class="' . implode( ' ', $classes ) . '">';
			$output .= '<div class="' . implode( ' ', $inner ) . '" ' . wp_kses_post( $data ) . '>';
				$output .= wp_kses_post( $sizer );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$i++;
						// Get category thumbnail ID
						$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );

						if ( $thumbnail_id ) {
							$image = wp_get_attachment_image_src( $thumbnail_id, $image_size );
						} else {
							$image[0] = wc_placeholder_img_src();
							$image[1] = $image[2] = '';
						}

						$link = get_term_link( $term->slug, 'product_cat' );

						$output .= '<div class="mt__30 pr col-md-' . ( in_array( $i , $large ) ? $columns * 2 : $columns ) . ' col-sm-6 col-xs-12 product-category">';
							$output .= '<a href="' . esc_url( $link ) . '">';
								if ( $image ) {
									$output .= '<img class="w__100" src="' . esc_url( $image[0] ) . '" alt="" width="' . esc_attr( $image[1] ) . '" height="' . esc_attr( $image[2] ) . '" />';
								}
							$output .= '</a>';
							$output .= '<h3>' . $term->name . '</h3>';
						$output .= '</div>';
					}
				}
			$output .= '</div>';
		$output .= '</div>';

		// Restore global product data in case this is shown inside a product post
		wp_reset_postdata();

		// Return output
		return apply_filters( 'kalles_addons_shortcode_wc_categories', force_balance_tags( $output ) );
	}
}