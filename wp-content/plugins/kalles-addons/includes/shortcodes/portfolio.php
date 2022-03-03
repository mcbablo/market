<?php
/**
 * portfolio shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_portfolio' ) ) {
	function kalles_addons_shortcode_portfolio( $atts, $content = null ) {
		$output = '';

		extract( shortcode_atts( array(
			'columns'       => 6,
			'limit'         => 10,
			'filter'        => '',
			'cat'           => 'all',
			'css_animation' => '',
			'class'         => '',
		), $atts ) );

		$classes = array( 'row the4-masonry' );

		if ( ! empty( $class ) ) {
			$classes[] = $class;
		}

		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
		}

		// Filter portfolio post type
		$args = array(
			'post_type'      => 'portfolio',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $limit
		);

		if ( $cat != 'all' ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_cat',
					'field'    => 'id',
					'terms'    => explode( ',', $cat ),
				),
			);
		}

		$query = new WP_Query( $args );

		// Retrieve all the categories
		$filters = get_terms( 'portfolio_cat' );

		if ( $filter ) {
			$output .= '<div class="portfolio-filter the4-filter fwm tc mb__25">';
				$output .= '<a data-filter="*" class="selected dib cg chp br__40" href="javascript:void(0);">' . __( 'All', 'kalles-addons' ) . '</a>';
				foreach ( $filters as $cat ) :
					$output .= '<a data-filter=".' . esc_attr( $cat->slug ) . '" class="dib cg chp br__40" href="javascript:void(0);">' . esc_html( $cat->name ) . '</a>';
				endforeach;
			$output .= '</div>';
		}

		$output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" data-masonryjs=\'{"selector":".portfolio-item", "layoutMode":"masonry" ,"columnWidth":".grid-sizer"' . ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) . '}\'>';
			$output .= '<div class="col-md-' . esc_attr( $columns ) . ' col-sm-6 grid-sizer"></div>';
			while ( $query->have_posts() ) : $query->the_post();
					// Get portfolio category
				$categories = wp_get_post_terms( get_the_ID(), 'portfolio_cat' );

				$item_class = array( 'col-md-' . esc_attr( $columns ) . ' col-sm-6 col-xs-12 portfolio-item pr mb__30' );
				if ( $categories ) {
					foreach ( $categories as $category ) {
						$item_class[] = "{$category->slug}";
					}
				}
				$output .= '<div id="portfolio-' . get_the_ID() . '" class="' . esc_attr( implode( ' ', $item_class ) ) . '">';
					$output .= '<div class="the4-animated">';
						$output .= '<a href="' . esc_url( get_permalink() ) . '" class="mask db pr chp">';
							if ( has_post_thumbnail() ) {
								// Thumbnail link
								$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
								if ( ! empty( $image ) ) {
									$data = getimagesize( $image );

									$output .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title() ) . '" width="' . esc_attr( $data[0] ) . '" height="' . esc_attr( $data[1] ) . '" />';
								}
							}
						$output .= '</a>';
						$output .= '<div class="pa tc ts__03 portfolio-title">';
							$output .= '<h4 class="fs__16 fwsb tu mg__0"><a class="cd chp" href=" ' . get_permalink() . '">' . get_the_title() . '</a></h4>';
								if ( $categories ) {
									$output .= '<span>' . get_the_term_list( get_the_ID(), 'portfolio_cat', '', ', ' ) . '</span>';
								}
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			endwhile;

			wp_reset_postdata();
		$output .= '</div>';

		// Return output
		return apply_filters( 'kalles_addons_shortcode_portfolio', force_balance_tags( $output ) );
	}
}