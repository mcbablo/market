<?php
/**
 * Ajax function
 *
 * @since   1.1.1
 * @package Kalles
 */

function the4_kalles_wc_live_search() {
    $result = array();
    $args = array(
        's'              => urldecode( $_REQUEST['key'] ),
        'post_type'      => 'product',
        'posts_per_page' => 10
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( 60,60 ) );
            if ( ! empty( $thumb ) ) {
                $thumb = $thumb[0];
            } else {
                $thumb = '';
            }
            $result[] = array(
                'id'     => get_the_ID(),
                'label'  => get_the_title(),
                'value'  => get_the_title(),
                'thumb'  => $thumb,
                'url'    => get_the_permalink(),
                'except' => preg_replace( '/[\x00-\x1F\x7F-\xFF]/u', '' , mb_substr( strip_tags( get_the_excerpt() ), 0, 60 , 'UTF-8' ) ) . '...'
            );
        }
    }
    echo json_encode( $result );
    exit;
}
add_action( 'wp_ajax_the4_kalles_live_search', 'the4_kalles_wc_live_search' );
add_action( 'wp_ajax_nopriv_the4_kalles_live_search', 'the4_kalles_wc_live_search' );

/**
 * Update cart
 *
 * @since  1.0.0
 */
function the4_kalles_popup_update_cart() {
    $product_data = json_decode( stripslashes( $_POST['product_data'] ), true );
    $product_id   = intval( $product_data['product_id'] );
    $variation_id = intval( $product_data['variation_id'] );
    $quantity     = empty( $product_data['quantity'] ) ? 1 : wc_stock_amount( $product_data['quantity'] );
    $product      = wc_get_product( $product_id );
    $variations   = array();
    $product_image = false;

    if ( $variation_id ) {
        $attributes        = $product->get_attributes();
        $variation_data    = wc_get_product_variation_attributes( $variation_id );
        $chosen_attributes = json_decode( stripslashes( $product_data['attributes'] ), true );

        foreach ( $attributes as $attribute ) {

            if ( ! $attribute['is_variation'] ) {
                continue;
            }

            $taxonomy = 'attribute_' . sanitize_title( $attribute['name'] );

            if ( isset( $chosen_attributes[ $taxonomy ] ) ) {
                // Get value from post data
                if ( $attribute['is_taxonomy'] ) {
                    // Don't use wc_clean as it destroys sanitized characters
                    $value = sanitize_title( stripslashes( $chosen_attributes[ $taxonomy ] ) );

                } else {
                    $value = wc_clean( stripslashes( $chosen_attributes[ $taxonomy ] ) );
                }

                // Get valid value from variation
                $valid_value = isset( $variation_data[ $taxonomy ] ) ? $variation_data[ $taxonomy ] : '';

                // Allow if valid or show error.
                if ( '' === $valid_value || $valid_value === $value ) {
                    $variations[ $taxonomy ] = $value;
                }
            }

        }
        $cart_success  = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations );
        $variation     = new WC_product_variation( $variation_id );
        $product_image = $variation->get_image();

    } elseif ( $variation_id === 0 ) {
        $cart_success = WC()->cart->add_to_cart( $product_id, $quantity );
    }

    if ( ! $product_image ) {
        $product_image = $product->get_image( $product_id );
    }

    if ( $cart_success ) {
        $cart_data       = WC()->cart->get_cart();
        $added_cart_key  = $cart_success;
        $added_item_data = $cart_data[$added_cart_key];
        $added_cart_qty  = $added_item_data['quantity'];
        $added_title     = $added_item_data['data']->get_title();
        $output          = the4_kalles_get_popup_cart();
        $ajax_fragm      = the4_kalles_popup_ajax_fragments();
        $items_count     = WC()->cart->get_cart_contents_count();

        wp_send_json(
            array(
                'pname'       => $added_title,
                'output'      => $output,
                'pimg'        => $product_image ,
                'ajax_fragm'  => $ajax_fragm ,
                'items_count' => $items_count
            )
        );
    } else {
        if ( wc_notice_count( 'error' ) > 0 ) {
            echo wc_print_notices();
        }
    }
    die();
}
add_action( 'wp_ajax_the4_kalles_popup_update_cart', 'the4_kalles_popup_update_cart' );
add_action( 'wp_ajax_nopriv_the4_kalles_popup_update_cart', 'the4_kalles_popup_update_cart' );


/**
 * Add Gift cart
 * @since  1.0.0
 */
function the4_kalles_add_gift_cart() {

    check_ajax_referer('kalles-add-gift', 'security_code');

    $product_id   = intval( $_POST['product_id'] );
    $quantity     = wc_stock_amount(1);
    $product      = wc_get_product( $product_id );

    $product_image = false;


    $cart_success = WC()->cart->add_to_cart( $product_id, $quantity );

    if ( ! $product_image ) {
        $product_image = $product->get_image( $product_id );
    }

    if ( $cart_success ) {
        $cart_data       = WC()->cart->get_cart();
        $added_cart_key  = $cart_success;
        $added_item_data = $cart_data[$added_cart_key];
        $added_cart_qty  = $added_item_data['quantity'];
        $added_title     = $added_item_data['data']->get_title();
        $items_count     = WC()->cart->get_cart_contents_count();
        $product_name      = apply_filters( 'woocommerce_cart_item_name', $product->get_name(), $added_item_data, $added_cart_key );
        $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $added_item_data, $added_cart_key );
        $data_cart_item = json_encode( array( 'key' => $added_cart_key, 'pid' => $product_id , 'pname' => $product_name ) );
        wp_send_json(
            array(
                'pname'       => $added_title,
                'pid' => $product_id,
                'pprice' => $product_price,
                'pimg'        => $product_image ,
                'cart_key'  => $data_cart_item ,
                'items_count' => $items_count
            )
        );
    } else {

    }
    die();
}
add_action( 'wp_ajax_the4_kalles_add_gift_cart', 'the4_kalles_add_gift_cart' );
add_action( 'wp_ajax_nopriv_the4_kalles_add_gift_cart', 'the4_kalles_add_gift_cart' );

/**
 * Edit mini cart in ajax
 *
 * @since  1.0.0
 */
function the4_kalles_edit_mini_cart() {

    check_ajax_referer('kalles-single-add-to-cart', 'security_code');

    parse_str($_POST['product_data'], $product_data);

    $cart_item_key = sanitize_text_field( $_POST['cart_key'] );
    $product_id   = intval( $product_data['product_id'] );
    $variation_id = intval( $product_data['variation_id'] );
    $quantity     = empty( $product_data['quantity'] ) ? 1 : wc_stock_amount( $product_data['quantity'] );
    $product      = wc_get_product( $product_id );
    $variations   = array();
    $product_image = false;

    if ($cart_item_key) {
        $removed = WC()->cart->remove_cart_item( $cart_item_key );
    }


    if ( $variation_id ) {
        $attributes        = $product->get_attributes();
        $variation_data    = wc_get_product_variation_attributes( $variation_id );
        foreach ( $attributes as $attribute ) {

            if ( ! $attribute['is_variation'] ) {
                continue;
            }

            $taxonomy = 'attribute_' . sanitize_title( $attribute['name'] );

            if ( isset( $product_data[ $taxonomy ] ) ) {
                // Get value from post data
                if ( $attribute['is_taxonomy'] ) {
                    // Don't use wc_clean as it destroys sanitized characters
                    $value = sanitize_title( stripslashes( $product_data[ $taxonomy ] ) );

                } else {
                    $value = wc_clean( stripslashes( $product_data[ $taxonomy ] ) );
                }

                // Get valid value from variation
                $valid_value = isset( $variation_data[ $taxonomy ] ) ? $variation_data[ $taxonomy ] : '';

                // Allow if valid or show error.
                if ( '' === $valid_value || $valid_value === $value ) {
                    $variations[ $taxonomy ] = $value;
                }
            }

        }
        $cart_success  = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations );
        $variation     = new WC_product_variation( $variation_id );
        

    } 

    if ( $cart_success ) {
        $cart_data       = WC()->cart->get_cart();

        $added_cart_key  = $cart_success;
        $added_item_data = $cart_data[$added_cart_key];

        //$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

        $product_name = apply_filters( 'woocommerce_cart_item_name', $variation->get_name(), $data_cart_item, $added_cart_key );
        $product_image = apply_filters( 'woocommerce_cart_item_thumbnail', $variation->get_image('medium'), $added_item_data, $added_cart_key );
        $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $variation ), $added_item_data, $added_cart_key );
        $data_cart_item = json_encode( array( 'key' => $added_cart_key, 'pid' => $product_id , 'pname' => $product_name ) );
        $variation_data = $product->get_variation_attributes();
        $variation_detail = woocommerce_get_formatted_variation( $variation_data, true );


        $added_cart_qty  = $added_item_data['quantity'];
        $added_title     = $added_item_data['data']->get_title();
        $items_count     = WC()->cart->get_cart_contents_count();

        $item_variants = the4_wc_get_varriants($added_item_data);




        //Check free shipping
        $free_shipping = the4_wc_add_notice_free_shipping(true);

        wp_send_json(
            array(
                'pname'       => $product_name,
                'pid'   => $product_id,
                'pimg'        => $product_image ,
                'pprice'        => $product_price ,
                'pqty'  => $added_cart_qty,
                'pdata_key' => $data_cart_item,
                'items_count' => $items_count,
                'item_variants' => $item_variants,
                'variation_detail' => $variation_detail,
                'cart_key' => $added_cart_key,
                'free_shipping' => $free_shipping,
                'cart_total'  => WC()->cart->get_cart_subtotal(),
            )
        );
    } else {
        if ( wc_notice_count( 'error' ) > 0 ) {
            echo wc_print_notices();
        }
    }

    die();
}
add_action( 'wp_ajax_the4_kalles_edit_mini_cart', 'the4_kalles_edit_mini_cart' );
add_action( 'wp_ajax_nopriv_the4_kalles_edit_mini_cart', 'the4_kalles_edit_mini_cart' );


/**
 * Update cart in ajax
 *
 * @since  1.2.2
 */
function the4_kalles_popup_update_ajax() {
    $cart_item_key = sanitize_text_field( $_POST['cart_key'] );
    $new_qty       = (int) $_POST['new_qty'];
    $undo          = sanitize_text_field ($_POST['undo_item'] );
    $updated       = '';
    $removed       = 0;

    if ( $new_qty === 0 ) {
        $removed = WC()->cart->remove_cart_item( $cart_item_key );
    } elseif ( $undo == 'true' ) {
        $updated = WC()->cart->restore_cart_item( $cart_item_key );
    } else {
        $updated = WC()->cart->set_quantity( $cart_item_key, $new_qty, true );
    }

    $cart_data = WC()->cart->get_cart();

    if ( $removed ) {
        $ptotal = $quantity = 0;
    }

    if ( $updated ) {
        $cart_item = $cart_data[$cart_item_key];
        $_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $ptotal    = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
        $quantity  = $cart_item['quantity'];

        $cart_item_price = $_product->get_price();
        $regular_item_price = $_product->get_regular_price();

        if ( $cart_item_price != $regular_item_price && ! isset( $cart_item['bundle-products'] ) ) {
            $cart_item_price_html = '<del> ' . wc_price( $regular_item_price ) . ' </del> <ins> ' . wc_price( $cart_item_price ) . ' </ins>';
        } else {
            $cart_item_price_html =  wc_price( $regular_item_price );
        }

    }

    if ( $updated || $removed ) {
        $items_count = count( $cart_data );
        $ajax_fragm  = the4_kalles_popup_ajax_fragments();
        $cart_total_item     = WC()->cart->get_cart_contents_count();
        //Check free shipping_methods
        $free_shipping = the4_wc_add_notice_free_shipping(true);
        $data = array(
            'ptotal'      => $ptotal ,
            'quantity'    => $quantity,
            'cart_total'  => WC()->cart->get_cart_subtotal(),
            'ajax_fragm'  => $ajax_fragm ,
            'items_count' => $items_count,
            'free_shipping' => $free_shipping,
            'cart_total_item' => $cart_total_item,
            'cart_item_price' => $cart_item_price_html ? $cart_item_price_html : ''
        );
        wp_send_json( $data );
    } else {
        if ( wc_notice_count( 'error' ) > 0 ) {
            echo wc_print_notices();
        }
    }
    die();
}
add_action( 'wp_ajax_the4_kalles_popup_update_ajax', 'the4_kalles_popup_update_ajax' );
add_action( 'wp_ajax_nopriv_the4_kalles_popup_update_ajax', 'the4_kalles_popup_update_ajax' );

/**
 * detect add to cart behaviour by class on body tag.
 *
 * @since  1.0
 */
function the4_kalles_popup_content_ajax() {
    echo the4_kalles_get_popup_cart();
    die();
}
add_action( 'wp_ajax_the4_kalles_popup_content_ajax', 'the4_kalles_popup_content_ajax' );
add_action( 'wp_ajax_nopriv_the4_kalles_popup_content_ajax', 'the4_kalles_popup_content_ajax' );


/**
 * Mini cart add Coupon
 *
 * @since  1.0
 */
function the4_kalles_add_coupon() {
    check_ajax_referer('the4-kalles-ajax-sec', 'security_code');

    $result_text = '';
    if ( ! empty( $_POST['coupon_code'] ) ) {
        $add_coupon = WC()->cart->add_discount( wc_format_coupon_code( wp_unslash( $_POST['coupon_code'] ) ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    } else {
    }

    if ( ! empty( $add_coupon ) ) {
        $result_text = translate('Coupon add success.', 'kalles');
    } else {
        $result_text = translate('Coupon', 'kalles');
        $result_text .= ' "' . $_POST['coupon_code'] . '" ' . translate('does not exist!', 'kalles');
    }
    $data = array(
        'add_coupon'     => $add_coupon,
        'text'           => $result_text,
        'discount_total' => t4_woo_mini_cart_coupon_detail(),
        'sub_total'      =>  t4_woo_mini_cart_subtotal()
    );
    wp_send_json( $data );

    die();
}
add_action( 'wp_ajax_the4_kalles_add_coupon', 'the4_kalles_add_coupon' );
add_action( 'wp_ajax_nopriv_the4_kalles_add_coupon', 'the4_kalles_add_coupon' );


/**
 * Mini cart add Note
 *
 * @since  1.0
 */
function the4_kalles_caculate_shiping() {

    check_ajax_referer('the4-cal-shipping-cart', 'security_code');

    \Kalles\Woocommerce\Shipping::instance()->the4_calculate_shipping();
    WC()->cart->calculate_totals();

    $packages = WC()->shipping()->get_packages();
    $shipping_methods = getShippingMethods($packages);

    $return = '';
    if (empty($shipping_methods)) {
        $return = '<div class="shippingcalc_mess mt__20">' . translate('No shipping Method available for your area', 'kalles') . '</div>';
    } else {
        $return .= '<div class="shippingcalc_mess mt__20">' . translate('We found shipping rate available', 'kalles') . '</div>';
        $return .= '<ul>';
        foreach ( $shipping_methods as $method ) {
            $return .= '<li>' . $method . '</li>';
        }
        $return .= '</ul>';
    }
    The4Helper::ksesHTML( $return );
    die();
}
add_action( 'wp_ajax_the4_kalles_caculate_shiping', 'the4_kalles_caculate_shiping' );
add_action( 'wp_ajax_nopriv_the4_kalles_caculate_shiping', 'the4_kalles_caculate_shiping' );

/**
 * Get variants mini cart
 *
 * @since  1.0
 */
function the4_wc_get_varriants ($cart_item) {
    // Variation values are shown only if they are not found in the title as of 3.0.
    // This is because variation titles display the attributes.
    $item_data = array();
    if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
        foreach ( $cart_item['variation'] as $name => $value ) {
            $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

            if ( taxonomy_exists( $taxonomy ) ) {
                // If this is a term slug, get the term's nice name.
                $term = get_term_by( 'slug', $value, $taxonomy );
                if ( ! is_wp_error( $term ) && $term && $term->name ) {
                    $value = $term->name;
                }
                $label = wc_attribute_label( $taxonomy );
            } else {
                // If this is a custom option slug, get the options name.
                $value = apply_filters( 'woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data'] );
                $label = wc_attribute_label( str_replace( 'attribute_', '', $name ), $cart_item['data'] );
            }

            // Check the nicename against the title.
            if ( '' === $value || wc_is_attribute_in_product_name( $value, $cart_item['data']->get_name() ) ) {
                //continue;
            }

            $item_data[] = array(
                'key'   => $label,
                'value' => $value,
            );
        }
    }
    $result = '';
    $index = 0;

    if (!empty($item_data)) {
        foreach ($item_data as $value) {
            if ($index == 0) {
                $result .= $value['value'];
            } else {
                $result .= ' / ' . $value['value'];
            }
            $index++;
        }
    }
    return $result;

}
/**
 * Search Product
 *
 * @since  1.0
 */
function the4_search_product() {

    check_ajax_referer('the4-kalles-ajax-sec', 'security_code');
    global $wpdb, $woocommerce;

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {

        $keyword = $_POST['keyword'];

        $category_id = (isset($_POST['category']) && !empty($_POST['category'])) ? $_POST['category'] : '';
        if (!empty($category_id)) {

            $args = array(
                's'             => urldecode($keyword),
                'post_type'     => 'product',
                'post_per_page' => -1,
                'post_status'   => 'publish',
                'tax_query'     => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => array($category_id)
                    )
                )
            );
        } else {
            $args = array(
                's' => urldecode($keyword),
                'post_type' => 'product',
                'post_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'title',
                'order' => 'ASC',
            );
        }

        $query_results = new WP_Query($args);

        $result_count = $query_results->found_posts;

        if (!empty($query_results->posts)) {
            $check_full_width = false;
            if ( cs_get_option( 'header-layout' ) == 5 || cs_get_option( 'search-fullscreen' )) {
                $check_full_width = true;
            }

            $output = '';
            if ($check_full_width == true) {
                $output .= '<div class="js_prs_search hihi row fl_center">';
            }
            $count_post = 0;
            foreach ($query_results->posts as $result) {
                if ($count_post < 10) {
                    $product = wc_get_product( $result->ID );

                    $price = $product->get_price();
                    $price_sale = $product->get_sale_price();
                    $price_regular = ($price == $price_sale) ? $product->get_regular_price() : $price;

                    $currency   = get_woocommerce_currency_symbol();


                    if ($check_full_width == true) {
                        $output .= '<div class="col-auto tc">';
                        $output .= '<div class="row mb__10 pb__10 ">';
                        $output .='<div class="col-12">';
                        $output .='<div class="img_fix_search">';
                        $output .= '<a class="db pr oh" href="'.get_post_permalink($result->ID).'">';
                        $output .= '<img class="w__100" src="'.esc_url(get_the_post_thumbnail_url($result->ID,'shop_catalog')).'"></a>';
                        $output .= '</div>'; // .img_fix_search
                        $output .= '</div>'; // .col-12
                        $output .= '<div class="col-12 mt_10">';
                        $output .= '<a class="product-title db pr oh" href="'.get_post_permalink($result->ID).'">'.$result->post_title.'</a>';
                        if (!empty($price)) {
                            $output .= '<p class="price">';
                            if (!empty($price_sale)) {
                                $output .= '<del>';
                            }
                            $output .= '<span class="woocommerce-Price-amount amount"><bdi>'.$price_regular.'</bdi></span>';
                            $output .= '<span class="woocommerce-Price-currencySymbol">' .$currency .'</span>';
                            if (!empty($price_sale)) {
                                $output .= '</del>';
                            }
                            if (!empty($price_sale)) {
                                $output .= '<ins><span class="woocommerce-Price-amount amount"><bdi>'.$price_sale.'</bdi></span></ins>';
                                $output .= '<span class="woocommerce-Price-currencySymbol">' .$currency .'</span>';
                            }

                            $output .= '</p>';
                        }


                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                    } else {
                        $output .= '<div class="row mb__10 pb__10 ">';
                        $output .='<div class="col widget_img_pr">';
                        $output .= '<a class="db pr oh" href="'.get_post_permalink($result->ID).'">';
                        $output .= '<img class="w__100" src="'.esc_url(get_the_post_thumbnail_url($result->ID,'shop_catalog')).'"></a>';
                        $output .= '</div>';
                        $output .= '<div class="col widget_if_pr">';
                        $output .= '<a class="product-title db pr oh" href="'.get_post_permalink($result->ID).'">'.$result->post_title.'</a>';
                        if (!empty($price)) {
                            $output .= '<p class="price">';
                            if (!empty($price_sale)) {
                                $output .= '<del>';
                            }
                            $output .= '<span class="woocommerce-Price-amount amount"><bdi>'.$price_regular.'</bdi></span>';
                            $output .= '<span class="woocommerce-Price-currencySymbol">' .$currency .'</span>';
                            if (!empty($price_sale)) {
                                $output .= '</del>';
                            }
                            if (!empty($price_sale)) {
                                $output .= '<ins><span class="woocommerce-Price-amount amount"><bdi>'.$price_sale.'</bdi></span></ins>';
                                $output .= '<span class="woocommerce-Price-currencySymbol">' .$currency .'</span>';
                            }

                            $output .= '</p>';
                        }


                        $output .= '</div>';
                        $output .= '</div>';

                        $count_post++;
                    } // Endif

                } //End foreach

            }
            if ($check_full_width == true) {
                $output .= '</div>'; //.js_prs_search row fl_center
            } else {
                if ($result_count > 10) {
                    $category_string = '';
                    if ($category_id) {
                        $category_string = '&product_cat='. $category_id;
                    }
                    $search_string = $keyword . '&post_type=product' . $category_string;
                    $output .= '
                        <a href="'. get_site_url() . '/?s=' . $search_string .'" class="db fwsb detail_link">'. translate( 'View All', 'kalles' ) .'('. $result_count.') <i class="t4_icon_arrow-right-solid fs__18"></i></a>
                    ';
                }
            }

            if ( ! empty( $output ) ) {
                echo wp_kses_post( $output );
            }
        } else {
            die(esc_html__( 'No products were found matching your selection.', 'kalles' ));
        }
    }

    die();
}
add_action( 'wp_ajax_the4_search_product', 'the4_search_product' );
add_action( 'wp_ajax_nopriv_the4_search_product',  'the4_search_product');

/**
 * Load mini cart on header.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_render_mini_cart() {
    $output = '';

    ob_start();

    woocommerce_mini_cart();

    $output = ob_get_clean();
    //Check free shipping
    $free_shipping = the4_wc_add_notice_free_shipping( true );

    $result = array(
        'message'    => WC()->session->get( 'wc_notices' ),
        'cart_total' => WC()->cart->cart_contents_count,
        'cart_html'  => $output,
        'free_shipping' => $free_shipping
    );
    echo json_encode( $result );
    exit;
}
add_action( 'wp_ajax_load_mini_cart', 'the4_kalles_wc_render_mini_cart' );
add_action( 'wp_ajax_nopriv_load_mini_cart', 'the4_kalles_wc_render_mini_cart' );

/**
 * Count total product on cart.
 *
 * @since 1.0.0
 */

function the4_kalles_wc_count_mini_cart() {

    $result = array(
        'cart_total' => WC()->cart->cart_contents_count,
    );

    echo json_encode( $result );
    exit;
}
add_action( 'wp_ajax_count_mini_cart', 'the4_kalles_wc_count_mini_cart' );
add_action( 'wp_ajax_nopriv_count_mini_cart', 'the4_kalles_wc_count_mini_cart' );


/**
 * Customize product quick shop.
 *
 * @since  1.0
 */
function the4_kalles_wc_quickshop() {
    // Get product from request.
    if ( isset( $_POST['product'] ) && (int) $_POST['product'] ) {
        global $post, $product, $woocommerce;

        $id      = ( int ) $_POST['product'];
        $post    = get_post( $id );
        $product = wc_get_product( $id );
        $cart_key = isset( $_POST['cart_key'] ) ? $_POST['cart_key'] : '';

        if ( $product ) {

            add_action( 'woocommerce_quickshop_after_summary', 'woocommerce_template_single_add_to_cart', 40 );
            // Get quickview template.
            include THE4_KALLES_PATH . DS . 'woocommerce'. DS . 'content-quickshop-product.php';
        }
    }

    exit;
}
add_action( 'wp_ajax_the4_quickshop', 'the4_kalles_wc_quickshop' );
add_action( 'wp_ajax_nopriv_the4_quickshop', 'the4_kalles_wc_quickshop' );

/**
 * Customize shipping & return content.
 *
 * @since  1.0
 */
function the4_kalles_wc_get_help_content() {
    // Get help content

    $message = cs_get_option( 'wc-single-shipping-return' );
    if ( ! $message ) return;

    $output = '<div class="wc-content-help pr">' . do_shortcode( $message ) . '</div>';

    echo wp_kses_post($output);
    exit;
}
add_action( 'wp_ajax_the4_shipping_return', 'the4_kalles_wc_get_help_content' );
add_action( 'wp_ajax_nopriv_the4_shipping_return', 'the4_kalles_wc_get_help_content' );

/**
 * Customize size guide HTML
 *
 * @since  1.0
 */
function the4_kalles_wc_get_size_guide_content() {

    $message = cs_get_option( 'wc-single-size-guide_html' );
    if ( ! $message ) return;

    $output = '<div class="wc-content-help pr">' . do_shortcode( $message ) . '</div>';

    echo wp_kses_post($output);
    exit;
}
add_action( 'wp_ajax_the4_size_guide', 'the4_kalles_wc_get_size_guide_content' );
add_action( 'wp_ajax_nopriv_the4_size_guide', 'the4_kalles_wc_get_size_guide_content' );
