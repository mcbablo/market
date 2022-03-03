<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.


/**
 * Include product thumbnails in Checkout Summary table.
 */
if ( ! function_exists( 't4_woo_add_thumbnail_checkout')) {
	function t4_woo_add_thumbnail_checkout( $product_name, $cart_item, $cart_item_key ) {
		if ( is_checkout() ) {
			$thumbnail_img  = $cart_item['data']->get_image('thumbnail');
			$image_html = '<div class="product-item-thumbnail ' . kalles_image_lazyload_class() .'">' . $thumbnail_img . '</div> ';
			$name = '<div class="t4-checkout-table-product-name">';
			$product_name = $image_html . $name . $product_name;
		}
		return $product_name;
	}
}
if ( ! class_exists( 'WPA_WCPB' ) ) {
	add_filter( 'woocommerce_cart_item_name', 't4_woo_add_thumbnail_checkout', 20, 3 );
}

/**
 * Filter Loop add to cart button
 */
if ( ! function_exists( 't4_woo_add_to_cart_loop')) {
	function t4_woo_add_to_cart_loop( $html ) {
		global $product;
		$all_variant_out_stock = false;

		if ( $product ) {
			if ( 'variable' === $product->get_type() ) {
				$variables = $product->get_available_variations();
				$count = 0;
				foreach ( $variables as $variable ) {
					$variant_id = $variable[ 'variation_id' ];
					$variant_obj = new WC_Product_variation( $variant_id );

					$variant_stock = $variant_obj->get_stock_quantity();

					if ( ( $variant_stock == 0 && $variant_obj->get_manage_stock() == 1) || $variant_obj->get_stock_status() == 'outstock' ) {
						$count++;
					}
				}

				if ( $count == count( $variables ) ) {
					$all_variant_out_stock = true;
				}
			}

			if ( $all_variant_out_stock == true ) {
				return '';
			} else {
				return $html;
			}
		}


	}
}

add_filter( 'woocommerce_loop_add_to_cart_link', 't4_woo_add_to_cart_loop' );

/**
 * Filter Select Options Text
 */
if ( ! function_exists( 't4_woo_filter_select_options_text')) {
	function t4_woo_filter_select_options_text( $text ) {
		global $product;

		if ( $product ) {
			if ( $product->is_type( 'variable' ) ) {
				$text = $product->is_purchasable() ? esc_html__( 'Quick Shop', 'kalles' ) : esc_html__( 'Read more', 'kalles' );
			}
		}
		
		return $text;
	}
}
if ( cs_get_option( 'wc-quick-shop-enable' ) ) {
	add_filter( 'woocommerce_product_add_to_cart_text', 't4_woo_filter_select_options_text', 10);
}


/**
 * Filter price display
 */

if ( ! function_exists( 't4_woo_display_price')) {
	function t4_woo_display_price( $price ) {
		return is_admin() ? $price : '';
	}
}
if (  cs_get_option( 'wc-product-list_price' ) == 'hide'  && is_category() ) {
	add_filter( 'woocommerce_get_price_html', 't4_woo_display_price');
}

/**
 * Remove woocommrce swatch image variant.
 */
function t4_woo_remove_swatch_image($options) {
  global $post;
  // Get page options
  $options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

  if ( is_array( $options ) ) {
  	// Get product single style
		$style = ( is_array( $options ) && $options['wc-single-style'] ) ? $options['wc-single-style'] : ( cs_get_option( 'wc-single-style' ) ? cs_get_option( 'wc-single-style' ) : '1' );
		if ( $style != '1') {
			$options['controlNav'] = false;
		}
	  
	  return $options;
  } else {
  	return $options;
  }
	
}
add_filter("woocommerce_single_product_carousel_options", "t4_woo_remove_swatch_image", 10);

/**
 * Remove product data tabs
 */

function woo_remove_product_tabs( $tabs ) {

	if ( cs_get_option('wc-single-tabs_desc') ) {
		unset( $tabs['description'] );      	// Remove the description tab
	}
	if ( cs_get_option('wc-single-tabs_add') ) {
		unset( $tabs['additional_information'] );      	// Remove the description tab
	}
	if ( cs_get_option('wc-single-tabs_review') ) {
		unset( $tabs['reviews'] );      	// Remove the description tab
	}

    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

/**
 * Move out stock product to last of page
 * since 1.1.1
 */
if ( ! function_exists( 'kalles_woo_move_out_of_stock ' ) ) {
	function kalles_woo_move_out_of_stock( $posts_clauses ) {
	  global $wpdb;
      
	  // only change query on WooCommerce loops
      $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
      $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
      $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];

	  return $posts_clauses;
	}
}
if ( cs_get_option( 'wc_categories-general_move_out_stock' ) ) {

    if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
        add_filter('posts_clauses', 'kalles_woo_move_out_of_stock', 999);
    }
}

function the4_kalles_wc_template_parts( $template, $slug, $name ) {
    $theme_path  = THE4_KALLES_PATH . DS . 'woocommerce' . DS;
    if ( $name ) {
        $newpath = $theme_path . "{$slug}-{$name}.php";
    } else {
        $newpath = $theme_path . "{$slug}.php";
    }
    return file_exists( $newpath ) ? $newpath : $template;
}
add_filter( 'woocommerce_locate_template', 'the4_kalles_wc_locate_template', 10, 3 );
add_filter( 'wc_get_template_part', 'the4_kalles_wc_template_parts', 10, 3 );

/**
 * Change the breadcrumb separator.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_change_breadcrumb_delimiter( $defaults ) {
    $defaults['delimiter'] = '<i class="t4_icon_angle-right-solid"></i>';
    return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'the4_kalles_wc_change_breadcrumb_delimiter' );

/**
 * Change product image thumbnail size.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_change_image_thumbnail_size( $size ) {
    global $kalles_sc;

    // Get product list style
    $style = $kalles_sc ? $kalles_sc['style'] : apply_filters( 'the4_kalles_wc_style', cs_get_option( 'wc-style' ) );

    // Get image size
    $shop_catalog = wc_get_image_size( 'shop_catalog' );

    // Get product options
    $options = get_post_meta( get_the_ID(), '_custom_wc_thumb_options', true );

    if ( $style == 'metro' && ( isset( $options['wc-thumbnail-size'] ) && $options['wc-thumbnail-size'] && is_numeric($shop_catalog['width']) && is_numeric($shop_catalog['height'] ) ) ) {
        add_image_size( 'the4_kalles_shop_metro', $shop_catalog['width'] * 2, $shop_catalog['height'] * 2, true );
        $size = 'the4_kalles_shop_metro';
    } else {
        $size = 'shop_catalog';
    }
    return $size;
}
add_filter( 'single_product_archive_thumbnail_size', 'the4_kalles_wc_change_image_thumbnail_size' );


/**
 * Disable page title on archive product.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_disable_page_title() {
    return false;
}
add_filter( 'woocommerce_show_page_title', 'the4_kalles_wc_disable_page_title' );

function the4_kalles_return() {
    return;
}
add_filter( 'yith_wcwl_positions', 'the4_kalles_return' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_add_to_cart_fragment( $fragments ) {
    $cart_count = WC()->cart->get_cart_contents_count();

    ob_start();

    $icons = the4_get_header_action_icon();

    if ( !empty( $icons ) ) {
        $icon_cart_class = $icons[ 'cart' ];
    }
    ?>

    <a class="cart-contents pr cb chp db" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'kalles' ); ?>">
        <i class="<?php echo esc_attr($icon_cart_class); ?>"></i>
        <span class="pa count bgb br__50 cw tc"><?php echo sprintf ( wp_kses_post( '%d', '%d', $cart_count ), $cart_count ); ?></span>
    </a>
    <?php

    $fragments['a.cart-contents'] = ob_get_clean();
    $fragments['cart_count'] = $cart_count;
    $fragments['free_shipping'] = the4_wc_add_notice_free_shipping( true );

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'the4_kalles_wc_add_to_cart_fragment' );

/**
 * Change number of products displayed per page.
 *
 * @since  1.0
 *
 * @return  number
 *
 */
function the4_kalles_wc_change_product_per_page() {
    $number = cs_get_option( 'wc-number-per-page' );

    return $number;
}
add_filter( 'loop_shop_per_page', 'the4_kalles_wc_change_product_per_page' );

/**
 * Add setting enable AJAX add to cart buttons on product detail
 *
 * @since  1.3.4
 */
function the4_kalles_setting_ajax_btn( $settings ) {
    $data = array();

    if ( $settings ) {
        foreach( $settings as $val ) {
            if ( isset( $val['id'] ) && $val['id'] == 'woocommerce_enable_ajax_add_to_cart' ) {

                $val['checkboxgroup'] = '';

                $data[] = $val;

                $data[] = array(
                    'desc'          => esc_html__( 'Enable AJAX add to cart buttons on product detail', 'kalles' ),
                    'id'            => 'woocommerce_enable_ajax_add_to_cart_single',
                    'default'       => 'yes',
                    'type'          => 'checkbox',
                    'checkboxgroup' => 'end'
                );
            } else {
                $data[] = $val;
            }
        }

    }

    return $data;
}
add_filter( 'woocommerce_product_settings' , 'the4_kalles_setting_ajax_btn' );



