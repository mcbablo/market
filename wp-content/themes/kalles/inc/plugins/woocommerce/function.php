<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Initialize function for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */


/**
 * Locate a template and return the path for inclusion.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_locate_template( $template, $template_name, $template_path ) {
    global $woocommerce;

    $_template = $template;

    if ( ! $template_path ) $template_path = $woocommerce->template_url;

    $theme_path = THE4_KALLES_PATH . DS . 'woocommerce' . DS;
    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name
        )
    );

    // Modification: Get the template from this folder, if it exists
    if ( ! $template && file_exists( $theme_path . $template_name ) )
        $template = $theme_path . $template_name;

    // Use default template
    if ( ! $template )
        $template = $_template;

    // Return what we found
    return $template;
}



/**
 * Custom add to wishlist button on product listing.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_wishlist_button_simple() {
    global $product, $yith_wcwl;

    if ( ! class_exists( 'YITH_WCWL' ) || $product->is_type( 'variable' ) ) return;

    $url          = YITH_WCWL()->get_wishlist_url();
    $product_type = $product->get_type();
    $exists       = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
    $classes      = 'class="add_to_wishlist cw"';
    $add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
    $browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
    $added        = get_option( 'yith_wcwl_product_added_text' );

    echo '<div class="yith-wcwl-add-to-wishlist ts__03 mg__0 ml__10 pr add-to-wishlist-' . esc_attr( $product->get_id() ) . '">
           <div class="yith-wcwl-add-button';

    if ($exists){
        echo ' hide" style="display:none;"';
    } else {
        echo ' show"';
    }

    echo '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' ><i class="t4_icon_heart"></i></a>
               <i class="fa fa-spinner fa-pulse ajax-loading pa" style="visibility:hidden"></i>
           </div>
           <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="chp" href="' . esc_url( $url ) . '"><i class="fa fa-heart"></i></a></div>
              <div class="yith-wcwl-wishlistexistsbrowse ';

    if ($exists){
        echo 'show';
    } else {
        echo 'hide';
    }

    echo '" style="display:';

    if ($exists){
        echo 'block';
    } else {
        echo 'none';
    }

    echo '"><a href="' . esc_url( $url ) . '" class="chp"><i class="fa fa-heart"></i></a></div>
       </div>';

}

/**
 * Shopping cart.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_wc_my_account' ) ) {
    function the4_kalles_wc_my_account() {
        $output = '';

        $icons = the4_get_header_action_icon();

        if ( !empty( $icons ) ) {
            $icon_acc_class = $icons[ 'user' ];
            $icon_heart_class = $icons[ 'heart' ];
        }

        if ( cs_get_option( 'header-my-account-icon' ) ) {
            $the4_check_login = (is_user_logged_in()) ? '' : 'the4-login-register';

            $account_type = cs_get_option( 'woocommerce_account-type' ) ? cs_get_option( 'woocommerce_account-type' )  : 'sidebar';

            $the4_check_login .= ' ' . $account_type;

            $output .= '<div class="the4-my-account hidden-xs ts__05 pr '. $the4_check_login .'">';
            $output .= '<a class="cb chp db" href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '"><i class="'. esc_attr($icon_acc_class) .'"></i></a>';
            $output .= '<ul class="pa tc">';
            if ( is_user_logged_in() ) {
                $output .= '<li><a class="db cg chp" href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_html__( 'Dashboard', 'kalles' ) . '</a></li>';
                $output .= '<li><a class="db cg chp" href="' . esc_url( wc_get_account_endpoint_url( 'orders' ) ) . '">' . esc_html__( 'My Orders', 'kalles' ) . '</a></li>';
                $output .= '<li><a class="db cg chp" href="' . esc_url( wp_logout_url() ) . '">' . esc_html__( 'Logout', 'kalles' ) . '</a></li>';
            }

            $output .= '</ul>';
            $output .= '</div>';
        }

        return apply_filters( 'the4_kalles_wc_my_account', $output );
    }
}

/**
 * Get Ajax refreshed fragments
 *
 * @since  1.2.2
 */
function the4_kalles_popup_ajax_fragments() {
    ob_start();

    woocommerce_mini_cart();

    $mini_cart = ob_get_clean();

    // Fragments and mini cart are returned
    $data = array(
        'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
            )
        ),
        'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
    );
    return $data;
}

/**
 * Shopping cart in header.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_wc_shopping_cart' ) ) {
    function the4_kalles_wc_shopping_cart() {
        global $woocommerce;

        // Catalog mode
        $catalog_mode = cs_get_option( 'wc-catalog' );
        $cart_mode = cs_get_option('wc-cart-cart_type');

        $cart_url = wc_get_cart_url();
        if ( $catalog_mode ) return;

        $icons = the4_get_header_action_icon();

        if ( !empty( $icons ) ) {
            $icon_cart_class = $icons[ 'cart' ];
        }

        $output = '';
        $output .= '<div class="the4-icon-cart pr ' . $cart_mode . '">';
        $output .= '<a class="cart-contents pr cb chp db" href="' . $cart_url .'" title="' . esc_html( 'View your shopping cart', 'kalles' ) . '">';
        $output .= '<i class="'. esc_attr($icon_cart_class) .'"></i>';
        $output .= '<span class="pa count bgb br__50 cw tc">' . esc_html( $woocommerce->cart->get_cart_contents_count() ) . '</span>';
        $output .= '</a>';
        $output .= '</div>';
        return apply_filters( 'the4_kalles_wc_shopping_cart', $output );
    }
}

/**
 * Woocommerce currency switch.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_currency() {
    if ( ! class_exists( 'Kalles_Addons_Currency' ) || ! cs_get_option( 'header-currency' ) ) return;

    // Auto update currency
    $update_every_hours = get_option( 'the4_currency_auto_update_hours' );

    if ( isset( $update_every_hours ) && $update_every_hours > 0 ) {
        $last_time_update_cr = strtotime(get_option( 'the4_currency_auto_update_last_time' ) );
        if ( ( time() - $last_time_update_cr ) / 60 / 60 > $update_every_hours ) {
            // Update currency rate
            Kalles_Addons_Currency::autoUpdateCurrencyRate();
            $time_format = get_option( 'time_format' );
            update_option( 'the4_currency_auto_update_last_time', date( $time_format, time() ) );
        }
    }

    $currencies = Kalles_Addons_Currency::getCurrencies();
    $default    = Kalles_Addons_Currency::woo_currency();

    $update_by_location = get_option( 'the4_currency_update_by_location', 0 );

    if ($update_by_location) {
        $result  = array( 'currency' => '' );
        $client  = WC_Geolocation::get_external_ip_address();
        $ip_data = @json_decode(wp_remote_get( 'http://www.geoplugin.net/json.gp?ip=' . $client ) );
        if ( $ip_data && $ip_data->geoplugin_currencyCode != null ) {
            $result['currency'] = $ip_data->geoplugin_currencyCode;
            if ( isset( $currencies[$result['currency']] ) ) {
                $default = $result;
            }
        }
    }

    $current = isset($_COOKIE['the4_currency']) ? $_COOKIE['the4_currency'] : $default['currency'];
    $_COOKIE['the4_currency']  = $current;
    $output = '';
    if ( is_array( $currencies ) && count( $currencies ) > 0 ) :
        $woocurrency = Kalles_Addons_Currency::woo_currency();
        $woocode = $woocurrency['currency'];
        if ( ! isset( $currencies[$woocode] ) ) {
            $currencies[$woocode] = $woocurrency;
        }
        $output .= '<div class="the4-currency dib pr cg">';
        $output .= '<span class="flagst4 flagst4-sm flagst4-' . strtoupper(esc_html( $current) ) . ' current dib">' . esc_html( $current ) . '<i class="fa fa-angle-down ml__5"></i></span>';
        $output .= '<ul class="pa ts__03 bgbl pt__15 pb__15 pr__15 pl__15 tl op__0 z_100 r__0">';
        foreach( $currencies as $code => $val ) :
            $curr_active = ($code == $current) ? 'selected' : '';
            $output .= '<li>';
            $output .= '<a class="flagst4 flagst4-sm flagst4-' . strtoupper(esc_html( $code) ) . ' '
                . $curr_active .
                ' currency-item cg db" href="javascript:void(0);" data-currency="' . esc_attr( $code ) . '">' . esc_html( $code ) . '</a>';
            $output .= '</li>';
        endforeach;
        $output .= '</ul>';
        $output .= '</div>';
    endif;

    return apply_filters( 'the4_kalles_wc_currency', $output );
}

/**
 * Woocommerce currency switch Mobile.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_currency_mobile() {
    if ( ! class_exists( 'Kalles_Addons_Currency' ) || ! cs_get_option( 'header-currency' ) ) return;

    // Auto update currency
    $update_every_hours = get_option( 'the4_currency_auto_update_hours' );

    if ( isset( $update_every_hours ) && $update_every_hours > 0 ) {
        $last_time_update_cr = strtotime(get_option( 'the4_currency_auto_update_last_time' ) );
        if ( ( time() - $last_time_update_cr ) / 60 / 60 > $update_every_hours ) {
            // Update currency rate
            Kalles_Addons_Currency::autoUpdateCurrencyRate();
            $time_format = get_option( 'time_format' );
            update_option( 'the4_currency_auto_update_last_time', date( $time_format, time() ) );
        }
    }

    $currencies = Kalles_Addons_Currency::getCurrencies();
    $default    = Kalles_Addons_Currency::woo_currency();

    $update_by_location = get_option( 'the4_currency_update_by_location', 0 );

    if ($update_by_location) {
        $result  = array( 'currency' => '' );
        $client  = WC_Geolocation::get_external_ip_address();
        $ip_data = @json_decode(wp_remote_get( 'http://www.geoplugin.net/json.gp?ip=' . $client ) );
        if ( $ip_data && $ip_data->geoplugin_currencyCode != null ) {
            $result['currency'] = $ip_data->geoplugin_currencyCode;
            if ( isset( $currencies[$result['currency']] ) ) {
                $default = $result;
            }
        }
    }

    $current = isset($_COOKIE['the4_currency']) ? $_COOKIE['the4_currency'] : $default['currency'];
    $_COOKIE['the4_currency']  = $current;
    $output = '';
    if ( is_array( $currencies ) && count( $currencies ) > 0 ) :
        $woocurrency = Kalles_Addons_Currency::woo_currency();
        $woocode = $woocurrency['currency'];
        if ( ! isset( $currencies[$woocode] ) ) {
            $currencies[$woocode] = $woocurrency;
        }

        $output .= '<a href="#">
                        <span class="current dib flagst4 flagst4-sm flagst4-' . esc_html( $current) . '">
                            ' . esc_html( $current ) . '
                        </span>
                     </a>';
        $output .= '<ul class="the4-subcurrency-moblie the4-currency">';
        foreach( $currencies as $code => $val ) :
            $curr_active = ($code == $current) ? 'selected' : '';
            $output .= '<li class="menu-item menu-item-type-post_type menu-item-object-page">';
            $output .= '<a class="the4_currency-flag--' . strtolower(esc_html( $code) ) . ' '
                . $curr_active .
                ' currency-item cg db" href="javascript:void(0);" data-currency="' . esc_attr( $code ) . '">' . esc_html( $code ) . '</a>';
            $output .= '</li>';
        endforeach;
        $output .= '</ul>';
        $output .= '<span class="holder"></span>';
    endif;

    return apply_filters( 'the4_kalles_wc_currency', $output );
}


/**
 * Change number of related products output
 *
 * @since  1.1.3
 */
if ( ! function_exists( 'the4_kalles_related_products_limit' ) ) {
    function the4_kalles_related_products_limit( $args ) {
        $limit = cs_get_option( 'wc-other-product-limit' ) ? cs_get_option( 'wc-other-product-limit' ) : 4;

        $args['posts_per_page'] = $limit;
        return $args;
    }
    add_filter( 'woocommerce_output_related_products_args', 'the4_kalles_related_products_limit' );
}

/**
 * Extra HTML content below checkout button minicart.
 *
 * @since  1.2.0
 */
function the4_kalles_minicart_extra_content() {
    // Get extra checkout content
    $minicart_content = cs_get_option( 'wc-minicart-content' );

    if ( $minicart_content ) {
        $output = '<div class="wc-extra-content dib w__100 mb__10">' . do_shortcode( $minicart_content ) . '</div>';

        echo apply_filters( 'the4_kalles_minicart_extra_content', $output );
    }
}

/**
 * Sticky add to cart
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'the4_kalles_sticky_add_to_cart' ) ) {
    function the4_kalles_sticky_add_to_cart() {
        global $product;
        if ( $product ) {
            if ( cs_get_option( 'wc-sticky-atc' ) && ! cs_get_option( 'wc-catalog' ) && ! $product->is_type( 'appointment' ) ) {
                wc_get_template( 'single-product/add-to-cart/sticky.php' );
            }
        }

    }
}

/**
 * Allow multicurrency on ajax
 */
add_filter( 'wcml_load_multi_currency_in_ajax', 'kalles_load_multi_currency_in_ajax', 10, 1 );
if (!function_exists('kalles_load_multi_currency_in_ajax')){
    function kalles_load_multi_currency_in_ajax( $load ) {
        if (!is_admin()){
            $load = true;
        }
        return $load;
    }
}

/**
 * Get popup cart content
 *
 * @since  1.2.2
 */
function the4_kalles_get_popup_cart() {
    $cart_data = WC()->cart->get_cart();

    $output = '';

    if ( $cart_data ) {
        $output .= '<h3 class="cart__popup-title tc">' . esc_html__( 'Your order', 'kalles' ) . '</h3>';

        $output .= '<div class="cart__popup-content_wrap flex">';
        $output .= '<div class="fixcl-scroll">';
        $output .= '<div class="fixcl-scroll-content css_ntbar">';

        foreach ( $cart_data as $cart_item_key => $cart_item ) {
            $_product          = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id        = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
            $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
            $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

            $product_subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

            if ( ! $product_permalink ) {
                $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
            } else {
                $product_name = apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
            }

            $output .= '<div class="cart__popup-item flex middle-xs" data-cart-item="' . htmlentities( json_encode( array( 'key' => $cart_item_key, 'pid' => $product_id , 'pname' => $product_name ) ) ) . '">';
            $output .= '<div class="cart__popup-heading">';
            $output .= '<div class="cart__popup-thumb">' . $thumbnail . ' </div>';

            $output .= '<div class="cart__popup-info">';

            $output .= '<div class="cart__popup-title grow">';

            if ( ! $product_permalink ) {
                $output .= apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
            } else {
                $output .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
            }

            // Meta data
            if ( version_compare( WC_VERSION, '3.3.0', '<' ) ) {
                $output .= WC()->cart->get_item_data( $cart_item );
            } else {
                $output .= wc_get_formatted_cart_item_data( $cart_item );
            }

            // Backorder notification
            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                $output .= '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'kalles' ) . '</p>';
            }

            $bundles       = get_post_meta( $product_id, 'wpa_wcpb', true );
            $bundles_added = explode( ',', ( isset( $cart_item['bundle-products'] ) ? $cart_item['bundle-products'] : '' ) );

            if ( ! empty( $cart_item['bundle-products'] ) ){
                if ( $bundles ) {
                    $custom_variable = $cart_item['bundle-variable'];

                    $output .= '<ul class="product-bundle pd__0">';
                    foreach( $bundles as $key => $val ) {
                        if ( in_array( $val['product_id'], $bundles_added ) ) {
                            $product_item = wc_get_product( intval( $val['product_id'] ) );
                            $output .= '<li class="pr">';
                            $output .= '<a href="'. $product_item->get_permalink() .'" title="'. $product_item->get_name() .'">'. $product_item->get_name() .'</a>';
                            // Get variable
                            if ( ! empty( $val['variable'] ) ) {
                                $variable = wp_unslash( $val['variable'] );

                                if ( isset( $custom_variable[$val['product_id']] ) && count( $custom_variable[$val['product_id']] ) > 0 ) {
                                    // Custom variable before add produt bundle to cart
                                    $output .= '<span class="db" style="text-transform: capitalize;">';
                                    $output .= $custom_variable[$val['product_id']]['variable'];
                                    $output .= '</span>';
                                } else {
                                    if ( ! empty( $val['variable'] ) ) {
                                        foreach ( $val['variable'] as $key => $value ) {
                                            $output .= '<span class="db" style="text-transform: capitalize;">';
                                            $output .= substr( $key, 13 ) . ': ' . $value;
                                            $output .= '</span>';
                                        }
                                    }
                                }
                            }
                            $output .= '</li>';
                        }
                    }
                    $output .= '</ul>';
                }
            }

            $output .= '</div>';

            if ( isset( $cart_item['bundle-products'] ) && $cart_item['bundle-products'] ) {
                $output .= '<div class="cart__popup-price">' . get_woocommerce_currency_symbol().round( $cart_item['custom-price-with-filter'], 5 ) . '</div>';
            } else {
                $output .= '<div class="cart__popup-price">' . $product_price . '</div>';
            }
            $output .= '</div>'; //End info

            $output .= '</div>';  //End heading

            $output .= '<div class="cart__popup-content">';
            $output .= '<div class="cart__popup-quantity">';

            if ( $_product->is_sold_individually() ) {
                $output .= sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
            } else {
                $max_value = apply_filters( 'woocommerce_quantity_input_max', $_product->get_max_purchase_quantity(), $_product );
                $min_value = apply_filters( 'woocommerce_quantity_input_min', $_product->get_min_purchase_quantity(), $_product );
                $step      = apply_filters( 'woocommerce_quantity_input_step', 1, $_product );

                $output .= '<div class="quantity pr flex">';
                $output .= '<a class="cart__popup-qty cart__popup-qty--minus tc" href="javascript:void(0);">-</a>';
                $output .= '<input type="number" class="cart__popup-qty--input tc" max="'. esc_attr( 0 < $max_value ? $max_value : '' ).'" min="' . esc_attr( $min_value ) .'" step="' . esc_attr( $step ) . '" value="' . $cart_item['quantity'] . '">';
                $output .= '<a class="xcp-plus cart__popup-qty cart__popup-qty--plus tc" href="javascript:void(0);">+</a>';
                $output .= '</div>';
            }
            $output .= '<div class="cart__popup-remove"><i class="fa fa-trash"></i></div>';
            $output .= '</div>';
            if ( isset( $cart_item['bundle-products'] ) && $cart_item['bundle-products'] ) {
                $output .= '<div class="cart__popup-total fwsb cb">' . get_woocommerce_currency_symbol().round( $cart_item['custom-price-with-filter'], 5 ) * $cart_item['quantity'] . '</div>';
            } else {
                $output .= '<div class="cart__popup-total fwsb cb">' . $product_subtotal . '</div>';
            }

            $output .= '</div>';

            $output .= '</div>';
        }

        $output .= '</div>'; //End .fixcl-scroll-content css_ntbar
        $output .= '</div>'; //End .fixcl-scroll
        $output .= '</div>'; //End .cart__popup-content_wrap

        $output .= '<div class="flex end-md end-sm center-xs middle-xs cb fs__20 mt__10 pb__10"><span class="mr__10">' . esc_html__( 'Subtotal', 'kalles' ) . ': </span><span class="cart__popup-stotal fwb ml__10">' . WC()->cart->get_cart_subtotal() . '</span></div>';

        $output .= '<div class="flex cart__popup-free-shipping fl_center w__100">';
        $output .= the4_wc_add_notice_free_shipping( true );
        $output .= '</div>';

        $output .= '<div class="flex between-xs tc cart__popup-action mt__20">';
        $output .= '<a href="javascript:void(0)" class="cart-popup_continue btn mt__20 mfp-close">';
        $output .= esc_html__( 'Continue shopping', 'kalles' );
        $output .= '</a>';
        $output .= '<a href="' . esc_url( wc_get_page_permalink( 'checkout' ) ) . '" class="checkout-button btn mt__20">';
        $output .= esc_html__( 'Proceed to checkout', 'kalles' );
        $output .= '</a>';
        $output .= '</div>';

        $output .= '<div class="flex cart__popup-trustbage w__100 mt__30 fl_center">';
        $output .= the4_kalles_woo_trust_badget_cart_checkout( true );
        $output .= '</div>';

        $output .= '<button title="Close (Esc)" type="button" class="mfp-close">×</button>';

        //Upsell product
        if ( cs_get_option( 'wc_cart_popup_upsell' ) ) {
            $upsells = $cart_product_ids = $args2 = array();

            foreach ( $cart_data as $item ) {
                $cart_product_ids[] = $item['product_id'];
            }

            foreach ( $cart_product_ids as $product_id ) {
                $product = new WC_product( $product_id );
                $upsells = array_merge( $upsells, $product->get_upsell_ids() );
            }

            if ( $upsells ) {
                $upsells = array_diff( $upsells, $cart_product_ids );
                $args2 = array(
                    'ignore_sticky_posts' => 1,
                    'no_found_rows'       => 1,
                    'post__in'            => $upsells,
                    'meta_query'          => WC()->query->get_meta_query()
                );
            }
            $args = array(
                'orderby'        => 'post__in',
                'posts_per_page' => 6,
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'post__not_in'   => $cart_product_ids,
            );

            $args = array_merge( $args, $args2 );

            $p_upsell = new WP_Query( $args );

            if ( $p_upsell->have_posts() ) :
                $output .= '<h3 class="cart__popup-related-title tc">' . esc_html__( 'You might also like', 'kalles' ) . '</h3>';
                $output .= '<div class="row the4-carousel" data-slick=\'{"slidesToShow": 4, "autoplay": true, "arrows": true ,"slidesToScroll": 1,"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 480,"settings":{"slidesToShow": 2}}]}\'>';
                while ( $p_upsell->have_posts() ) : $p_upsell->the_post();
                    global $product;
                    $output .= '<div class="col-xs-6 col-md-3">';
                    $output .= '<div class="popup__cart-product center-xs">';
                    $output .= '<a class="product-image equal-height" href="'. get_the_permalink() .'">';
                    if ( has_post_thumbnail() ) {
                        $props = wc_get_product_attachment_props( get_post_thumbnail_id(), get_the_ID() );
                        $output .= get_the_post_thumbnail( get_the_ID(), array( 500, 500 ), array(
                            'title'  => $props['title'],
                            'alt'    => $props['alt'],
                        ) );
                    } elseif ( wc_placeholder_img_src() ) {
                        $output .= wc_placeholder_img( array( 500, 500 ) );
                    }
                    $output .= '</a>';
                    $output .= '<h4 class="tc ls__0"><a href="' . get_the_permalink() . '">';
                    $output .= get_the_title();
                    $output .= '</a></h4>';

                    ob_start();
                    wc_get_template( 'loop/price.php' );
                    $output .= ob_get_clean();
                    $output .= '</div>';
                    $output .= '</div>';
                endwhile;
                $output .= '</div>';
            endif;
            wp_reset_postdata();
        }

        return apply_filters( 'the4_kalles_get_popup_cart', $output );
    }
}



function getShippingMethods($packages){
    $shipping_methods = array();
    foreach($packages as $package){
        if(empty($package['rates']) || !is_array($package['rates'])) break;

        foreach($package['rates'] as $id => $rate){
            $shipping_methods[] = wc_cart_totals_shipping_method_label($rate);

        }
    }
    return $shipping_methods;
}

/**
 * Get Products by Categories
 *
 * @since  1.0
 */

function the4_kalles_get_products($categories, $post = false, $limit = -1, $term = 'term_id') {

    $args = array(
        'posts_per_page' => $limit,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => $term,
                'terms' => is_array($categories) ? $categories : array($categories)
            )
        ),
        'post_type' => 'product',
        'orderby' => 'title,'
    );
    $products = new WP_Query( $args );
    if ($post == false) {
        return $products->posts;
    } else {
        return $products;
    }

}
/**
 * Get Recently order
 *
 * @since  1.0
 */
function the4_kalles_get_purchased_order($limit = 10) {
    $query = new WC_Order_Query( array(
        'limit' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'ids',
    ) );
    $orders = $query->get_orders();
    
    if (empty($orders))  { return; }
    
    $sale_puchased = array();
    $i = 0;
    foreach ($orders as $index => $order_id) {
        
        // Get the user ID from an Order ID
        $user_id = get_post_meta( $order_id, '_customer_user', true );
        if ( $user_id ) {
            // Get an instance of the WC_Customer Object from the user ID
            $customer = new WC_Customer( $user_id );
            $order = new WC_Order($order_id);
            // Get and Loop Over Order Items
            foreach ( $order->get_items() as $item_id => $item ) {
                $persion_address                    = $customer->get_billing_state() ? $customer->get_billing_state() : $customer->get_billing_city();
                $sale_puchased[$i]['customer_info'] = $customer->get_billing_first_name() . ' ' . $customer->get_billing_last_name() . ' (' . $persion_address . ')';
                $sale_puchased[$i]['product_id']    = $item->get_product_id();
                $sale_puchased[$i]['variant_id']    = $item->get_variation_id();
                $product                            = $item->get_product();
                //Get image
                if ( $product ) {
                    $image = wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' );
                }
    
                $sale_puchased[$i]['product_image'] = $image[0] ? $image[0] : esc_url( wc_placeholder_img_src() ) ;
    
                $date_create                        = $order->get_date_created();
                $sale_puchased[$i]['order_time']    = the4_kalles_get_time_ago($date_create->format('Y-m-d H:i:s'));
    
                $i++;
            }
        }
    }
    return $sale_puchased;

}

/**
 * Prev - Next Product
 * @return Void
 * @since  1.0
 */
function The4KallesPrevNextProduct($defaults) {

    //Check if Product post type
    if (is_singular('product')) {
        global $post;

        //get Categories
        $terms = wp_get_post_terms($post->ID, 'product_cat');
        foreach ($terms as $term) $cats_array[] = $term->term_id;

        //Get all post in current categories
        $query_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'id',
                    'terms'    => $cats_array
                )
            )
        );
        $products = new WP_Query($query_args);

        // show next and prev only if we have 3 or more
        if ($products->post_count > 2) {
            $prev_product_id = -1;
            $next_product_id = -1;

            $found_product = false;
            $i = 0;

            $first_product_index = $i;

            $curr_product_index = $i;
            $curr_product_id = get_the_ID();

            if ($products->have_posts()) {
                while ($products->have_posts()) {

                    $products->the_post();
                    $curr_id = get_the_ID();

                    if ($curr_id == $curr_product_id) {
                        $found_product = true;
                        $curr_product_index = $i;
                    }

                    $is_first = ( $curr_product_index == $first_product_index );
                    if ($is_first) {
                        $prev_product_id = get_the_ID(); // if product is first then 'prev' = last product
                    } else {
                        if (!$found_product && $curr_id != $curr_product_id) {
                            $prev_product_id = get_the_ID();
                        }
                    }

                    if ($i == 0) {
                        $next_product_id = get_the_ID();
                    }

                    if ($found_product && $i == $curr_product_index + 1) {
                        $next_product_id = get_the_ID();
                    }
                    $i++;
                }

                $defaults['wrap_before'] = '<div class="row al_center fl_center"><div class="container flex"><div class="col"><nav class="woocommerce-breadcrumb">';

                $wrap_after = '</nav></div><div class="col-auto flex al_center">';

                if ($prev_product_id != -1) {
                    $prev_product = wc_get_product($prev_product_id);
                    $wrap_after .= '<a href="' . $prev_product->get_permalink() .'" class="pl__5 pr__5 fs__18 cd chp ttip_nt tooltip_bottom_left"><i class="t4_icon_angle-left-solid"></i><span class="tt_txt">' . $prev_product->get_name() .'</span></a>';
                }

                $wrap_after .= '<a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) .'" class="pl__5 pr__5 fs__20 cd chp ttip_nt tooltip_bottom_left"><i class="fwb t4_icon_t4-grid  fs__18"></i><span class="tt_txt">' . translate('Back to products', 'kalles') .'</span></a>';

                if ($next_product_id != -1) {
                    $next_product = wc_get_product($next_product_id);
                    $wrap_after .= '<a href="' . $next_product->get_permalink() .'" class="pl__5 pr__5 fs__18 cd chp ttip_nt tooltip_bottom_left"><i class="t4_icon_angle-right-solid"></i><span class="tt_txt">' . $next_product->get_name() .'</span></a>';
                }

                $wrap_after .= '</div></div></div>';

                $defaults['wrap_after'] = $wrap_after;

            }
            wp_reset_query();
        } else {
            $defaults['wrap_before'] = '<div class="row al_center fl_center"><div class="container flex"><div class="col"><nav class="woocommerce-breadcrumb">';
            $wrap_after = '</nav></div><div class="col-auto flex al_center">';
            $wrap_after .= '<a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) .'" class="pl__5 pr__5 fs__20 cd chp ttip_nt tooltip_bottom_left"><i class="fwb iccl iccl-grid fs__15"></i><span class="tt_txt">' . translate('Back to products', 'kalles') .'</span></a>';
            $wrap_after .= '</div></div></div>';
            $defaults['wrap_after'] = $wrap_after;

        }
    }
    return $defaults;
}
if (cs_get_option('wc_product-brc_btn')) {
    add_filter('woocommerce_breadcrumb_defaults', 'The4KallesPrevNextProduct');
}

/**
 * Display quickview btn on product loop
 * @return string
 * @since  1.0
 */
function the4_kalles_quickview_btn($post) {
    // Enable quick shop button
    if ( cs_get_option( 'wc-quick-view-btn' ) && ! cs_get_option( 'wc-catalog' ) ) {
        echo '<a class="btn-quickview nt_add_qv cd br__40 pl__25 pr__25 bgw tc dib pr tooltip_right ttip_nt" href="javascript:void(0);" data-prod="' . esc_attr( $post->ID ) . '"><span class="tt_txt">' . esc_html__( 'Quick View', 'kalles' ) . '</span>
            <i class="t4_icon_t4-eye"></i>
            <span>' . esc_html__( 'Quick View', 'kalles' ) . '</span>
            </a>';
    }
}

/**
 * Display attributes on product loop
 * @return string
 * @since  1.0
 */
function the4_kalles_attributes_product_loop($product) {
    $attrs = cs_get_option( 'wc-attr' );

    if ( ! empty ( $attrs ) && is_array( $attrs ) ) {
        $attributes = $product->get_attributes();

        echo '<div class="product-attr pa ts__03 cw">';
        foreach ( $attrs as $attr ) {
            $attr_op = 'pa_' . $attr;
            foreach ( $attributes as $attribute ) {

                if ( $attribute && isset( $attribute['name'] ) ) {
                    $values = wc_get_product_terms( absint( $product->get_id() ), $attribute['name'], array( 'fields' => 'names' ) );
                    if ( $attr_op == $attribute['name'] ) {
                        echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                    }
                }
            }
        }
        echo '</div>';
    }
}



/**
 * Get default variant
 * @since  1.0
 */
if ( !function_exists('the4_woo_get_default_variant_id')) {
    function the4_woo_get_default_variant_id ( $term, $available_variations) {
        $default_var_id = '';

        if ( ! empty( $available_variations) ) {
            foreach ($available_variations as $variation) {
                foreach ($variation['attributes'] as $key => $value) {

                    if ( strpos($key, $term->taxonomy) && strtolower($term->slug) == $value ) {
                        $default_var_id = $variation['variation_id'];
                    }
                }
            }
        }
        return $default_var_id;

    }
}

/**
 * Custom thumbnail Image
 * @since  1.0
 */
if ( !function_exists('the4_woo_get_product_thumbnai')) {
    function the4_woo_get_product_thumbnai ( $img_size = 'woocommerce_thumbnail', $attach_id = false ) {
        global $post, $kalles_sc;

        $custom_img_size = $img_size;

        if ( has_post_thumbnail() ) {
            if ( ! $attach_id ) {
                $attach_id = get_post_thumbnail_id();
            }
            $attachment_props = wc_get_product_attachment_props( $attach_id, $post );

            if ( isset( $kalles_sc[ 'img_size' ] ) ) {
                $custom_img_size = $kalles_sc[ 'img_size' ];
            }

            $custom_img_size = apply_filters( 'kalles_custom_img_size', $custom_img_size );

            if ( kalles_is_elementor() ) {
                $args = array(
                    'image_size' => $custom_img_size,
                    'image_custom_dimension' => isset( $kalles_sc['img_size_custom'] ) ? $kalles_sc['img_size_custom'] : 0,
                    'image' => array(
                        'id' => $attach_id,
                    )
                );

                $img = kalles_get_image_html($args, 'image');
            } else {
                $img = wp_get_attachment_image( $attach_id, $img_size, array(
                    'title'  => $attachment_props['title'],
                    'alt'    => $attachment_props['alt'],
                ) );
            }

            return $img;

        } elseif ( wc_placeholder_img_src() ) {
            return wc_placeholder_img( $img_size );
        }

    }
}

/**
 * Calculate Cart final Price if have Discount
 * @since  1.0
 */

if ( ! function_exists( 'the4_woo_caculate_cart_total_price' ) ) {
    function the4_woo_caculate_cart_total_price() {
        echo WC()->cart->get_cart_subtotal() . ' ' .  WC()->cart->get_cart_total();
    }
}

/**
 * Get all variant image of product
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_get_all_variant_image' ) ) {
    function the4_woo_get_all_variant_image() {
        global $product;
        if ( $product->is_type( 'variable' ) ) {
            $variations = $product->get_available_variations();
            $images = array();
            foreach( $variations as $key => $var ) {
                $images['image_id'][] = $var['image_id'];
                $images['variable'][$var['image_id']]['variation_id'] = $var['variation_id'];
            }

            return $images;
        }
    }
}

/**
 * Check ID variation of Image
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_check_image_variant_id' ) ) {
    function the4_woo_check_image_variant_id( $id_image, $variant ) {

        foreach ($variant as $id => $value) {

            if ( (int) $id_image ==  (int) $id ) {
                return (int) $value[ 'variation_id' ];
            }
        }
    }
}

/**
 * Get all variant image of product
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_get_variable_gallery' ) ) {
    function the4_woo_get_variable_gallery() {
        global $product;

        if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
            $attachment_ids = $product->get_gallery_attachment_ids();
        } else {
            $attachment_ids = $product->get_gallery_image_ids();
        }

        if ( $product->is_type( 'variable' ) ) {
            $variable_images = array();

            $variable_all_images = the4_woo_get_all_variant_image();

            if ( is_array( $variable_all_images) ) {
                if($variable_all_images){
                    $variable_images = array_unique( array_merge( $attachment_ids, $variable_all_images['image_id'] ), SORT_REGULAR );
                }
            }

            return $variable_images;

        } else {
            return $attachment_ids;
        }
    }
}

/**
 * Display product image main
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_variable_gallery_main' ) ) {
    function the4_woo_variable_gallery_main( $attachment_id, $variable_all_images, $is_variable, $post_thump_id = null, $zoom = '' ) {
        if ( $post_thump_id == $attachment_id ) {
            return;
        }
        
        $is_kalles_lazyload = kalles_image_lazyload_class(false);
        
        $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
        $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
        $thumbnail_post   = get_post( $attachment_id );
        $image_title      = $thumbnail_post->post_content;
        $dn               = '';

        $attributes = array(
            'title'                   => $image_title,
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'data-src'                => $full_size_image[0],
            'data-large_image'        => $full_size_image[0],
            'data-large_image_width'  => $full_size_image[1],
            'data-large_image_height' => $full_size_image[2],
            'class'                   => 'the4-image-thumbnail'
        );
        if ( $is_variable ) {
            $variant_id = the4_woo_check_image_variant_id( $attachment_id, $variable_all_images['variable'] );
            $data_variant = $variant_id ? 'data-variation="' . $variant_id . '"' : '';
        } else {
            $data_variant = '';
        }

        if ( $post_thump_id == $attachment_id ) {
            $dn = 'style="display: none;"';
        }
        
        $html = '<div class="p-item woocommerce-product-gallery__image' . $zoom . '" ' . $data_variant . $dn . '>';
            $html .= '<a class="attachment-product-img-link" href="' . esc_url( $full_size_image[0] ) . '">';
            if ( $is_kalles_lazyload )
                $html .= '<div class="attachment-product-img-wrapper the4-lazyload">';
                $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
            if ( $is_kalles_lazyload )
                $html .= '</div>';
            $html .= '</a>';
        $html .= '</div>';

        return $html;
    }
}

/**
 * Display product image thumb
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_variable_gallery_thumb' ) ) {
    function the4_woo_variable_gallery_thumb( $attachment_id, $variable_all_images, $is_variable, $post_thump_id = null ) {
        
        if ( $post_thump_id == $attachment_id ) {
            return;
        }
        
        $is_kalles_lazyload = kalles_image_lazyload_class(false);

        $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
        $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
        $thumbnail_post   = get_post( $attachment_id );
        $image_title      = $thumbnail_post->post_content;
        $dn               = '';

        $attributes = array(
            'title'                   => $image_title,
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'data-src'                => $full_size_image[0],
            'data-large_image'        => $full_size_image[0],
            'data-large_image_width'  => $full_size_image[1],
            'data-large_image_height' => $full_size_image[2],
            'class'                   => 'the4-image-thumbnail'
        );
        if ( $is_variable ) {
            $variant_id = the4_woo_check_image_variant_id( $attachment_id, $variable_all_images['variable'] );
            $data_variant = $variant_id ? 'data-variation="' . $variant_id . '"' : '';
        } else {
            $data_variant = '';
        }

        if ( $post_thump_id == $attachment_id ) {
            $dn = 'style="display: none;"';
        }

        $html = '<div class="p-thum-wrapper" ' . $data_variant . ' ' . $dn . '>';
        if ( $is_kalles_lazyload )
            $html .= '<div class="the4-lazyload attachment-img-wrapper">';

        $html .= wp_get_attachment_image( $attachment_id, 'thumbnail', false, $attributes );
        if ( $is_kalles_lazyload )
            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}

/**
 * Display product image on Quickview
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_variable_quickview_gallery' ) ) {
    function the4_woo_variable_quickview_gallery( $attachment_id, $variable_all_images, $is_variable ) {
        $is_kalles_lazyload = kalles_image_lazyload_class(false);

        $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
        $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
        $thumbnail_post   = get_post( $attachment_id );
        $image_title      = $thumbnail_post->post_content;

        $attributes = array(
            'title'                   => $image_title,
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'data-src'                => $full_size_image[0],
            'data-large_image'        => $full_size_image[0],
            'data-large_image_width'  => $full_size_image[1],
            'data-large_image_height' => $full_size_image[2],
            'class'                   => 'the4-image-thumbnail'
        );
        if ( $is_variable ) {
            $variant_id = the4_woo_check_image_variant_id( $attachment_id, $variable_all_images['variable'] );
            $data_variant = $variant_id ? 'data-variation="' . $variant_id . '"' : '';
        } else {
            $data_variant = '';
        }


        $html = '<div class="p-thum-wrapper" ' . $data_variant . '>';
        $html .= '<a href="' . esc_url( $full_size_image[0] ) . '">';
        if ( $is_kalles_lazyload )
        $html .= '<div class="attachment-product-img-wrapper the4-lazyload">';
            $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
        if ( $is_kalles_lazyload )
            $html .= '</div>';
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }
}

/**
 * Display product image on QuickShop
 * @since  1.0.0
 */

if ( ! function_exists( 'the4_woo_variable_quickshop_gallery' ) ) {
    function the4_woo_variable_quickshop_gallery( $attachment_id, $variable_all_images, $is_variable ) {
        $is_kalles_lazyload = kalles_image_lazyload_class(false);

        if ( $is_variable ) {

            $variant_id = the4_woo_check_image_variant_id( $attachment_id, $variable_all_images['variable'] );

            if ( $variant_id ) {
                $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
                $thumbnail_post   = get_post( $attachment_id );
                $image_title      = $thumbnail_post->post_content;

                $attributes = array(
                    'title'                   => $image_title,
                    'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
                    'data-src'                => $full_size_image[0],
                    'data-large_image'        => $full_size_image[0],
                    'data-large_image_width'  => $full_size_image[1],
                    'data-large_image_height' => $full_size_image[2],
                    'class'                   => 'the4-image-thumbnail'
                );

                $data_variant = 'data-variation="' . $variant_id . '"';

                $html = '<div class="p-thum-wrapper" ' . $data_variant . '>';
                $html .= '<a href="' . esc_url( $full_size_image[0] ) . '">';
                if ( $is_kalles_lazyload ) {
                    $html .= '<div class="attachment-product-img-wrapper the4-lazyload">';
                }

                $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );

                if ( $is_kalles_lazyload ) {
                    $html .= '</div>';
                }
                $html .= '</a>';
                $html .= '</div>';

                return $html;
            }

        } else {
            return;
        }

    }
}


/**
 * Get order details
 * @since  1.1.1
 */

if ( ! function_exists( 'the4_woo_get_order_details' ) ) {
    function the4_woo_get_order_details( $order ) {
        $order_id = $order->get_id();
        $all_order_status = wc_get_order_statuses();
        $order_status_check = $order->get_status();
        $details = array(
            'order_number' => $order->get_order_number(),
            'order_status' => isset($all_order_status['wc-' . $order_status_check]) ? $all_order_status['wc-' . $order_status_check] : $order_status_check,
            'order_date' => $order->get_date_created() ? $order->get_date_created()->date_i18n('F d, Y') : '',
            'order_total' => $order->get_formatted_order_total(),
            'order_subtotal' => $order->get_subtotal_to_display(),
            'items_count' => $order->get_item_count(),
            'payment_method' => $order->get_payment_method_title(),

            'shipping_method' => $order->get_shipping_method(),
            'shipping_address' => $order->get_shipping_address_1(),
            'formatted_shipping_address' => $order->get_formatted_shipping_address(),

            'billing_address' => $order->get_billing_address_1(),
            'formatted_billing_address' => $order->get_formatted_billing_address(),
            'billing_country' => $order->get_billing_country(),
            'billing_city' => $order->get_billing_city(),

            'billing_first_name' => ucwords($order->get_billing_first_name()),
            'billing_last_name' => ucwords($order->get_billing_last_name()),
            'formatted_billing_full_name' => ucwords($order->get_formatted_billing_full_name()),
            'billing_email' => $order->get_billing_email(),

            'shop_title' => get_bloginfo(),
            'home_url' => home_url(),
            'shop_url' => get_option('woocommerce_shop_page_id', '') ? get_page_link(get_option('woocommerce_shop_page_id')) : '',

        );

        return $details;
    }
}


/**
 * Product list get Lazyload class
 * @since  1.1.1
 */

if ( ! function_exists( 'the4_woo_get_lazyload_class' ) ) {
    function the4_woo_get_lazyload_class() {
        $lazyload_class = ( kalles_image_lazyload_class(false) && isset( $kalles_sc['img_size'] ) && $kalles_sc['img_size'] != 'custom' ) ? 'the4-lazyload' : '';

        return $lazyload_class;
    }
}
