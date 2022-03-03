<?php
/**
 * Products shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_products' ) ) {
	function kalles_addons_shortcode_products( $atts, $content = null ) {
		$output = '';
		$isAjax = false; $paged = 1;

		if ( isset( $atts['isAjax'] ) ) $isAjax = true;
		if ( isset( $atts['paged'] ) ) $paged = $atts['paged'];

		global $kalles_sc;

		$atts = shortcode_atts( array(
			'style'                  => 'grid',
			'id'                     => '',
			'sku'                    => '',
			'display'                => 'all',
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'cat_id'                 => '',
			'limit'                  => 12,
			//'slider'                 => '',
			'loadmore'               => '',
			'items'                  => 4,
			'autoplay'               => '',
			'arrows'                 => '',
			'dots'                   => '',
			'columns'                => 4,
			'filter'                 => false,
			'flip'                   => false,
			'css_animation'          => '',
			'class'                  => '',
			'hover_style'            => '',
			'button_type'            => '',
			'arrows_style'           => '',
			'issc'                   => true,
			'img_size'               => 'woocommerce_thumbnail',
			'img_size_custom_width'  => '',
			'img_size_custom_height' => '',
		), $atts );

		$kalles_sc = $atts;

		$kalles_sc['img_size_custom'] = array(
			'width' => $kalles_sc['img_size_custom_width'],
			'height' => $kalles_sc['img_size_custom_height']
		);
		$kalles_sc['isAjax'] = $isAjax;

		$options = array();

		$classes = array( 'the4-sc-products ' . $atts['class'] );

		if ( '' !== $atts['css_animation'] ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible ' . $atts['hover_style'] .'  wpb_' . $atts['css_animation'].' '. $atts['arrows_style'];
		}

		$args = array(
			'post_type'              => 'product',
			'posts_per_page'         => (int) $atts['limit'],
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'paged'            		 => $paged,
			'taxonomies'             => '',
			'no_found_rows'          => false,
			'cache_results'          => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'orderby'                => $atts['orderby'],
			'order'                  => $atts['order'],
			'meta_query'             => WC()->query->get_meta_query(),
			'tax_query'              => WC()->query->get_tax_query()
		);

		if ( $atts['cat_id'] ) {
			$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => $atts['cat_id'],
					),
				);
			$args['tax_query']['categories'] = [ 'relation' => 'AND' ];
		}

		switch ( $atts['display'] ) {
			case 'all':

				if ( $atts['sku'] !== '' )
					$args['meta_query'][] = array(
						'key'     => '_sku',
						'value'   => array_map( 'trim', explode( ',', $atts['sku'] ) ),
						'compare' => 'IN'
					);

				if ( $atts['id'] !== '' )
					$args['post__in'] = array_map( 'trim', explode( ',', $atts['id'] ) );

				break;

			case 'recent':

				$args['orderby'] = 'date';
				$args['order']   = 'desc';

				break;

			case 'featured':

				$args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);

				break;

			case 'sale':

				$args['no_found_rows'] = 1;
				$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );

				break;

			case 'best_selling_products':

				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				$args['order'] 	  = 'desc';

				break;

			case 'top_rated':

				add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

				break;

			// case 'cat':
			// 	$args['tax_query'] = array(
			// 		array(
			// 			'taxonomy' => 'product_cat',
			// 			'field'    => 'id',
			// 			'terms'    => $atts['cat_id'],
			// 		),
			// 	);
		}
		
		ob_start();

		$products = new WP_Query( $args );

		if ( $products->have_posts() ) : ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		<?php endif;

		if ( 'top_rated' == $atts['display'] )
			remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );

		if ( ! $isAjax ) {
			$output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" data-attrs=\'' . json_encode( $kalles_sc ) .'\' 
			data-pages="' . $products->max_num_pages . '" data-paged="' . $paged . '">';
		}
			$output .= ob_get_clean();


		if ( ! $isAjax && $atts['style'] != 'carousel' && $products->max_num_pages > $paged ) {
			if ( $kalles_sc['loadmore'] ) {
				$output .= '<div class="tc mt__10" data-load-more="{}">
								<a href="javascript:void(0)" class="pr nt_home_lm button ' . $atts['button_type'] .'"><span>'. translate('Load More', 'kalles') .'</span></a>
							</div>';
			}
			$output .= '</div>';
		}

		wp_reset_postdata();

		// Reset kalles_sc global variable to null for render shortcode after
		$kalles_sc = NULL;

		if ( $isAjax ) {
			die( force_balance_tags( $output ) );
		}
		// Return output
		return apply_filters( 'kalles_addons_shortcode_products', force_balance_tags( $output ) );
	}
}

if ( ! function_exists( 'kalles_addons_shortcode_products_ajax' ) ) {
	function kalles_addons_shortcode_products_ajax() {
		if ( !empty( $_POST['attrs'] ) ) {
			$attrs = $_POST['attrs'];
			$paged = ( empty( $_POST['paged'] ) ) ? 2 : sanitize_text_field( (int) $_POST['paged'] );

			$attrs['paged'] = $paged;
			$attrs['isAjax'] = true;

			kalles_addons_shortcode_products($attrs);
		}

	}

	add_action( 'wp_ajax_kalles_addons_shortcode_products_ajax', 'kalles_addons_shortcode_products_ajax' );
	add_action( 'wp_ajax_nopriv_kalles_addons_shortcode_products_ajax', 'kalles_addons_shortcode_products_ajax' );
}

/**
 * Shortcode function to Display product
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'kalles_shortcode_products' ) ) {
    function kalles_shortcode_products( $atts, $content = null ) {
        $output = '';

        global $kalles_sc;

        $atts = shortcode_atts( array(
            'style'         => 'grid',
            'id'            => '',
            'sku'           => '',
            'display'       => 'all',
            'orderby'       => 'title',
            'order'         => 'ASC',
            'cat_id'        => '',
            'limit'         => 12,
            'slider'        => '',
            'items'         => 4,
            'autoplay'      => '',
            'arrows'        => '',
            'dots'          => '',
            'columns'       => 4,
            'filter'        => false,
            'flip'          => false,
            'css_animation' => '',
            'class'         => '',
            'issc'          => true,
        ), $atts );

        $kalles_sc = $atts;

        $options = array();

        $classes = array( 'the4-sc-products ' . $atts['class'] );

        if ( '' !== $atts['css_animation'] ) {
            wp_enqueue_script( 'waypoints' );
            $classes[] = 'wpb_animate_when_almost_visible wpb_' . $atts['css_animation'];
        }

        $args = array(
            'post_type'              => 'product',
            'posts_per_page'         => (int) $atts['limit'],
            'no_found_rows'          => true,
            'post_status'            => 'publish',
            'cache_results'          => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'orderby'                => $atts['orderby'],
            'order'                  => $atts['order'],
            'meta_query'             => WC()->query->get_meta_query(),
            'tax_query'              => WC()->query->get_tax_query()
        );

        switch ( $atts['display'] ) {
            case 'all':

                if ( $atts['sku'] !== '' )
                    $args['meta_query'][] = array(
                        'key'     => '_sku',
                        'value'   => array_map( 'trim', explode( ',', $atts['sku'] ) ),
                        'compare' => 'IN'
                    );

                if ( $atts['id'] !== '' )
                    $args['post__in'] = array_map( 'trim', explode( ',', $atts['id'] ) );

                break;

            case 'recent':

                $args['orderby'] = 'date';
                $args['order']   = 'desc';

                break;

            case 'featured':

                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );

                break;

            case 'sale':

                $args['no_found_rows'] = 1;
                $args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );

                break;

            case 'best_selling_products':

                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order'] 	  = 'desc';

                break;

            case 'top_rated':

                add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

                break;

            case 'cat':
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'id',
                        'terms'    => $atts['cat_id'],
                    ),
                );
        }

        $products = new WP_Query( $args );

        if ( $products->have_posts() ) : ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                <?php wc_get_template( 'content-product.php' ); ?>

            <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

        <?php endif;

        if ( 'top_rated' == $atts['display'] )

            remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );

        $output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        $output .= ob_get_clean();
        $output .= '</div>';

        wp_reset_postdata();

        // Reset kalles_sc global variable to null for render shortcode after
        $kalles_sc = NULL;

        // Return output
        return $output;
    }
}
