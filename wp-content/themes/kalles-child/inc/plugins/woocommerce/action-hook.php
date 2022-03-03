<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Action hook for Woocommer
 *
 * @since   1.0.0
 * @package Kalles
 */


/**
 * Register widget area for wc.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_wc_register_sidebars' ) ) {
    function the4_kalles_wc_register_sidebars() {
        register_sidebar(
            array(
                'name'          => esc_html__( 'WooCommerce Categories Menu Sidebar', 'kalles' ),
                'id'            => 'wc-categories',
                'description'   => esc_html__( 'The woocommerce categories menu sidebar, It will display in archive product page on top', 'kalles' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title tu fwsb">',
                'after_title'   => '</h3>',
            )
        );
        register_sidebar(
            array(
                'name'          => esc_html__( 'WooCommerce Filter Sidebar', 'kalles' ),
                'id'            => 'wc-filter',
                'description'   => esc_html__( 'The sidebar area for woocommerce, It will display on archive product page', 'kalles' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title tu fwsb">',
                'after_title'   => '</h3>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__( 'WooCommerce Sidebar', 'kalles' ),
                'id'            => 'wc-primary',
                'description'   => esc_html__( 'The woocommerce sidebar, It will display in archive product page on left or right', 'kalles' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>',
            )
        );

        register_sidebar(
            array(
                'name'          => esc_html__( 'Kalles Top Filter', 'kalles' ),
                'id'            => 'kalles-filter-top',
                'description'   => esc_html__( 'The Kalles Top Filter, Will display top of Categories page', 'kalles' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>',
            )
        );
    }
}
add_action( 'widgets_init', 'the4_kalles_wc_register_sidebars' );

/**
 * Custom add to wishlist button in single product.
 *
 * @since 1.0.0
 */
function the4_kalles_before_single_add_to_cart() {
    $ajax_btn        = get_option( 'woocommerce_enable_ajax_add_to_cart_single' );
    $redirect        = get_option( 'woocommerce_cart_redirect_after_add' );
    $stripe_settings = get_option( 'woocommerce_stripe_settings', '' );
    $atc_behavior    = cs_get_option( 'wc-atc-behavior' ) ? cs_get_option( 'wc-atc-behavior' ) : 'slide';

    $btn_style    = cs_get_option( 'wc-summary_btn_design' ) ? cs_get_option( 'wc-summary_btn_design' ) : '1';
    $btn_txt    = cs_get_option( 'wc-summary_btn_transform_txt' ) ? cs_get_option( 'wc-summary_btn_transform_txt' ) : '4';
    $classes = array();

    if ( $ajax_btn == 'no' || $redirect == 'yes' ) {
        $classes[] = 'no-ajax';
    }

    if ( isset( $stripe_settings['enabled'] ) && $stripe_settings['enabled'] == 'yes' ) {
        $classes[] = 'stripe-enabled';
    }

    if ( $atc_behavior ) {
        $classes[] = 'atc-' . $atc_behavior;
    }

    echo '<div class="btn-atc btn_des_' . $btn_style . ' btn_txt_' . $btn_txt . ' ' . esc_attr( implode( ' ', $classes ) ) . '">';
}
function the4_kalles_after_single_add_to_cart() {
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'the4_kalles_before_single_add_to_cart', 25 );
add_action( 'woocommerce_single_product_summary', 'the4_kalles_after_single_add_to_cart', 35 );

function the4_kalles_wc_wishlist_button_variable() {
    global $product, $yith_wcwl;

    if ( ! class_exists( 'YITH_WCWL' ) || ! $product->is_type( 'variable' ) ) return;

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

if ( ! cs_get_option( 'wc_general_wishlist-type' ) ) {
    add_action( 'woocommerce_after_add_to_cart_button', 'the4_kalles_wc_wishlist_button_simple', 33 );
    add_action( 'woocommerce_before_shop_loop_item', 'the4_kalles_wc_wishlist_button_simple', 11 );
    add_action( 'woocommerce_before_shop_loop_item', 'the4_kalles_wc_wishlist_button_variable', 11 );
    add_action( 'woocommerce_after_add_to_cart_button', 'the4_kalles_wc_wishlist_button_variable', 0 );
}



/**
 * WPML fix: multicurrency in quickshop Kalles theme feature
 */


if ( class_exists( 'woocommerce_wpml' ) ) {
    add_filter( 'wcml_multi_currency_ajax_actions', 'add_action_to_multi_currency_ajax', 10, 1 );
    function add_action_to_multi_currency_ajax( $ajax_actions ) {
        $ajax_actions[] = 'the4_quickview';
        return $ajax_actions;
    }
}

/**
 * Customize WooCommerce image dimensions.
 *
 * @since  2.0.4
 */
// Update WooCommerce image dimensions.
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 120,
        'height' => 150,
        'crop' => 0,
    );
});

/**
 * Add social sharing to single product.
 *
 * @since  1.0
 */
function the4_kalles_wc_single_social_share() {
    if ( cs_get_option( 'wc-social-share' ) ) {
        the4_kalles_social_share();
    }
}
add_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_single_social_share', 50 );

/**
 * Add page title to archive product.
 *
 * @since  1.0
 */
function the4_kalles_wc_page_head() {


    if ( ! cs_get_option( 'wc-enable-page-title' ) || ( class_exists( 'WCV_Vendors' ) && WCV_Vendors::is_vendor_page() ) ) return;

    $title = cs_get_option( 'wc-page-title' );

    $desc_cat = '';
    
    if( cs_get_option('wc-atc-on-product-short_description')){
        $desc_cat = do_shortcode( category_description() );
    }
    $output = '<div class="page-head pr tc"><div class="container pr">';
    
    if ( is_search() ) {
        $output .= '<h1 class="mb__5 cw">' . sprintf(esc_html__( 'Search Results for: %s', 'kalles' ), '<span>' . get_search_query() . '</span>' ) . '</h1>';
    } elseif ( is_shop() ) {

        $output .= '<h1 class="mb__5 cw">' . esc_html( cs_get_option( 'wc-page-title' ) ) . '</h1>';
        $output .= '<p class="mg__0">' . do_shortcode( cs_get_option( 'wc-page-desc' ) ) . '</p>';

    } else {

        // Remove old position of category description
        remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

        $output .= '<h1 class="cw">' . single_cat_title( '', false ) . '</h1>';
        $output .= $desc_cat ;
    }
    ob_start();
    $output .= ob_get_clean();
    $output .= '</div></div>';

    if ( cs_get_option( 'wc-subcustom-enable') ) {
        $output .= t4_woo_subcategories_title();
    }
    

    echo wp_kses_post( $output );
}
add_action( 'woocommerce_before_main_content', 'the4_kalles_wc_page_head', 15 );

/**
 * Change pagination position.
 *
 * @since  1.0
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
add_action( 'the4_pagination', 'woocommerce_pagination' );


/**
 * Extra HTML content below add to cart button.
 *
 * @since  1.2.0
 */
function the4_kalles_wc_extra_content() {
    // Get extra content
    $extra_content = cs_get_option( 'wc-extra-content' );

    if ( $extra_content ) {
        $output = '<div class="wc-extra-content dib w__100 mt__30">' . do_shortcode( $extra_content ) . '</div>';

        echo apply_filters( 'the4_kalles_wc_extra_content', $output );
    }
}
add_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_extra_content', 35 );

/**
 * Extra HTML content below cart total.
 *
 * @since  1.2.0
 */
function the4_kalles_cart_extra_content() {
    // Get extra cart content
    $cart_content = cs_get_option( 'wc-cart-content' );

    if ( $cart_content ) {
        $output = '<div class="wc-cart-extra-content dib w__100  mt__30">' . do_shortcode( $cart_content ) . '</div>';

        echo apply_filters( 'the4_kalles_cart_extra_content', $output );
    }
}
add_action( 'woocommerce_after_cart_totals', 'the4_kalles_cart_extra_content' );

/**
 * Extra HTML content below checkout button.
 *
 * @since  1.2.0
 */
function the4_kalles_checkout_extra_content() {
    // Get extra checkout content
    $checkout_content = cs_get_option( 'wc-checkout-content' );

    if ( $checkout_content ) {
        $output = '<div class="wc-extra-content dib w__100 mt__30">' . do_shortcode( $checkout_content ) . '</div>';

        echo apply_filters( 'the4_kalles_checkout_extra_content', $output );
    }
}
add_action( 'woocommerce_review_order_after_submit', 'the4_kalles_checkout_extra_content', 35 );

/**
 * Display shipping amount mini cart
 *
 * @since  1.0
 */

function the4_wc_add_notice_free_shipping($t_echo = false) {
    $free_shipping_settings = cs_get_option( 'wc_mini_cart_setting-shipping_amount' );
    $free_shipping_enable = cs_get_option( 'wc_mini_cart_setting-shipping_bar' );

    if ( $free_shipping_settings &&  $free_shipping_enable ) {
        $amount_for_free_shipping = (int) $free_shipping_settings;

        $cart = WC()->cart->subtotal;

        $remaining = $amount_for_free_shipping - $cart;
        $currency = get_woocommerce_currency_symbol();
        $output = '<div class="cart_threshold cart_thres_js">';

        if ($cart == 0 && !empty($free_shipping_settings)) {

            $output .= '<div class="cart_thres_1">
                            '. translate('Free Shipping for all orders over', 'kalles') .'
                             <span class="cr fwm mn_thres_js">'. $currency . $amount_for_free_shipping .'
                </span></div>';
        }
        if( $amount_for_free_shipping > $cart && $cart > 0 ){

            $output .= '<div class="cart_thres_2" style="display: block;">
                '. translate('Almost there, add', 'kalles') .'
                <span class="cr fwm mn_thres_js">
                '. $currency.$remaining .'
                </span> '. translate('more to get', 'kalles').' <span class="cr fwm">'. translate('FREE SHIPPING!', 'kalles').'</span></div>';

            $width_percent = ( $cart / $amount_for_free_shipping ) * 100;

            // Free Shipping bar
            if ( cs_get_option( 'wc_mini_cart_setting-shipping_bar' ) ) {
                $w_class = $width_percent > 79 ? 'blue' : '';
                $output .= '<div class="cart_bar_w bgt4_svg19 pr w_' . $w_class . '">
                        <span class="pr db h__100 more_10" style="width:' . $width_percent . '%;">' . $width_percent . '%</span>
                    </div>';
            }

        } else if ($amount_for_free_shipping <= $cart && $cart > 0) {
            $output .= '<div class="cart_thres_3 cart_bar_w  bgt4_svg19 pr w_blue">
                        <span class="pr db h__100 more_10" style="width:100%;">100%</span>
                    </div>';
            $output .= '<p class="content_threshold threshold_congrats"><i class="pe-7s-medal"></i>' . cs_get_option( 'wc_mini_cart_freeship_text' ) . '</p>';
        }

        $output .= '</div>';

        if ($t_echo == true) {
            return $output;
        }
        echo wp_kses_post( $output );
    }

}
add_action('woocommerce_before_mini_cart', 'the4_wc_add_notice_free_shipping');

/**
 * Exist product Popup
 *
 * @since  1.0
 */
function the4_kalles_exist_product_popup() {


    global $kalles_sc;

    $page_dispay    = cs_get_option('popup-exist_product_page');


    $categories      = cs_get_option('popup-exist_product_cat') ? cs_get_option('popup-exist_product_cat') : '';

    //Slider config.
    $infinite         = boolval(cs_get_option('popup-exist_product_slider_loop')) ? 'true' : 'false';
    $arrow            = boolval(cs_get_option('popup-exist_product_btn_enable')) ? 'true' : 'false';
    $dots             = boolval(cs_get_option('popup-exist_product_dots_enable')) ? 'true' : 'false';
    $pauseOnHover     = boolval(cs_get_option('popup-exist_product_slider_pause')) ? 'true' : 'false';
    $popup_version    = cs_get_option('popup-exist_product_version') ? cs_get_option('popup-exist_product_version') : '1';
    $date_show        = cs_get_option('popup-exist_product_day_next') ? cs_get_option('popup-exist_product_day_next') : '30';
    $btn_owl          = 'btn_owl_' . cs_get_option('popup-exist_btn_style');
    $btn_visible_type = cs_get_option('popup-exist_product_btn_hover_type') ? cs_get_option('popup-exist_product_btn_hover_type') : 'control-show';
    $title_type       = cs_get_option('popup-exist_product_title_design') ? cs_get_option('popup-exist_product_title_design') : 'title_2';
    $style7_icon      = cs_get_option('popup-exist_product_style7_icon') ? cs_get_option('popup-exist_product_style7_icon') : 'gem';
    $btn_color        = cs_get_option('popup-exist_btn_color') ? cs_get_option('popup-exist_btn_color') : 'transparent';
    $btn_color        = 'btn_color_' . $btn_color;
    $slider_class     = $btn_owl . ' ' . $btn_visible_type . ' ' . $btn_color;
    $auto_play_speed  = cs_get_option('popup-exist_product_slider_start_time');
    $auto_play        = ($auto_play_speed != 0) ? 'true' : 'false';
    $exist_products = array();
    if (!empty($categories)) {
        $exist_products_posts = the4_kalles_get_products ( $categories );
        foreach ($exist_products_posts as $exist_products_post) {
            $exist_products[] = wc_get_product($exist_products_post->ID);
        }

    }
    $output = '';
    if (!empty($exist_products)) {
        $output =  '<div id="the4-kalles-exist-product" class="slick-enable">
            <div class="js_lz_pppr popup_prpr_wrap container bgw mfp-with-anim">
                <div class="wrap_title  des_' . $title_type . '">
                        <h3 class="the4-section-title mg__0 tc pr flex fl_center al_center fs__24 ' . $title_type . '">
                            <span class="mr__10 ml__10">' . cs_get_option('popup-exist_product_heading') . '</span>
                        </h3>
                        <span class="dn tt_divider">
                            <span></span>
                            <i class="dn clprfalse' . $title_type . ' la la-' . $style7_icon . '"></i>
                            <span></span>
                        </span>
                        <span class="section-subtitle db tc sub-title">' . cs_get_option('popup-exist_product_subtext') . '</span>
                </div>';

        $output .= '<div class="products nt_products_holder row row_pr_1 cdt_des_1 round_cd_false exist_products_slider the4-carousel nt_cover ratio_nt     position_8 space_ prev_next_0 dot_owl_1 dot_color_1 btn_vi_1 ' . $slider_class . '"
                    data-slick=\'{
                            "slidesToShow": ' . cs_get_option('popup-exist_product_per_row') . ',
                            "slidesToScroll": ' . cs_get_option('popup-exist_product_per_row') . ',
                            "infinite": ' . $infinite  . ',
                            "arrows": ' . $arrow . ',
                            "dots": ' . $dots . ',
                            "autoplaySpeed": ' . (int)$auto_play_speed * 1000 . ',
                            "autoplay": ' . $auto_play . ',
                            "pauseOnHover": ' . $pauseOnHover . '

                        }\'>';
        ob_start();
        foreach ( $exist_products as $exist_product ) {
            $post_object = get_post( $exist_product->get_id() );
            $GLOBALS['post'] =& $post_object;
            setup_postdata( $post_object );

            wc_get_template( 'content-product.php' );
        }
        $output .= ob_get_clean();
        $output .=  '</div>
            </div>
        </div>';
    }
    wp_reset_postdata();
    $kalles_sc = NULL;

    $data = array (
        'output'      => $output,
        'day_next'    => $date_show,
        'page_display' => $page_dispay
    );
    wp_send_json($data);
}
add_action( 'wp_ajax_the4_kalles_exist_product_popup', 'the4_kalles_exist_product_popup' );
add_action( 'wp_ajax_nopriv_the4_kalles_exist_product_popup',  'the4_kalles_exist_product_popup');

/**
 * Display Clear filter btn
 * @return string
 * @since  1.0
 */
if ( !function_exists('the4_kalles_clear_filter_btn')) {
    function the4_kalles_clear_filter_btn() {
        global $wp;

        $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
        $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

        $home_url = home_url( add_query_arg( array( $_GET ), $wp->request ) );
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();


        if ( count($_chosen_attributes) > 0  || $max_price || $min_price ) {
            $reset_link = strtok( $home_url, '?' );

            if ( isset( $_GET['post_type'] ) ) {
                $reset_link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET[ 'post_type' ] ) ), $reset_link );
            }

            echo '<a href="' . $reset_link .'" class="clear_filter clear_filter_all dib is_pjax_item">' . translate('Clear filter', 'kalles') . '</a>';
        }

    }
    add_action('kalles_filter_btn', 'the4_kalles_clear_filter_btn');
}

/**
 * Display Product Garelly btn
 * @since  1.0
 */
if ( !function_exists('the4_kalles_product_img_gallery_btn')) {

    function the4_kalles_product_img_gallery_btn() {
        wp_enqueue_script( 'kalles-photoswipe' );

        $html = '<div class="kalles-product-gallery-btn p_group_btns flex">
                <button class="bghp br__40 tc flex al_center fl_center bghp_ show_btn_pr_gallery ttip_nt tooltip_top_left"><i class="t4_icon_expand-arrows-alt-solid"></i><span class="tt_txt">Click to enlarge</span></button>
                </div>';
        The4Helper::ksesHTML( $html );
    }
    if ( cs_get_option('wc-single-photoswipe') )
        add_action('kalles_product_image_action', 'the4_kalles_product_img_gallery_btn', 11);
}

/**
 * Display Product Video btn
 * @since  1.0
 */
if ( !function_exists('the4_kalles_product_video_btn')) {

    function the4_kalles_product_video_btn() {
        global $post, $product;

        $html = '';
        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_wc_options', true );
        if ( isset( $options ) && ! empty( $options['wc-single-video-upload'] ) || ! empty( $options['wc-single-video-url'] ) ) {
            $html = '<div class="p-video">';
            if ( $options['wc-single-video'] == 'url' ) {
                $html .= '<a href="' . esc_url( $options['wc-single-video-url'] ) . '" class="ttip_nt tooltip_top_left br__40 pl__30 pr__30 tc db bghp the4-popup-url"><i class="pe-7s-play pr"></i><span class="tt_txt">' . translate( 'View video', 'kalles' ) .'</span></a>';
            } else {
                $html .= '<a href="#the4-vsh" class="ttip_nt tooltip_top_left br__40 pl__20 pr__20 tc db bghp the4-popup-mp4"><i class="pe-7s-play pr"></i>span class="tt_txt">' . translate( 'View video', 'kalles' ) .'</span></a>';
                $html .= '<div id="the4-vsh" class="mfp-hide">' . do_shortcode( '[video src="' . esc_url( $options['wc-single-video-upload'] ) . '" width="640" height="320"]' ) . '</div>';
            }
            $html .= '</div>';
        }
        The4Helper::ksesHTML( $html );
    }
    add_action('kalles_product_image_action', 'the4_kalles_product_video_btn', 10);
}

/**
 * Display 360 image btn
 * @since  1.0
 */
if ( !function_exists('the4_kalles_product_360_image_btn')) {

    function the4_kalles_product_360_image_btn() {
        if ( ! class_exists( 'The4_Woocommerce_Product360' ) ) {
            return;
        }

       $html = '';
       $product_360_gallery = The4_Woocommerce_Product360::get_360_image_gallery();

       if ( ! empty( $product_360_gallery ) ) {
            $setting_image = wp_get_attachment_image_src( $product_360_gallery[0], 'full' );

            $args = array(
                'total_frame' => count( $product_360_gallery ),
                'images' => array(),
                'width' => $setting_image[ 1 ],
                'height' => $setting_image[ 2 ],
            );

            foreach ( $product_360_gallery as $key => $image ) {
                $args['images'][] = wp_get_attachment_image_url( $image, 'full' );
            }
            wp_enqueue_script( 'kalles-threesixty' );

            $html = '<div class="p-360-image p_group_btns">';
                $html .= '<button data-id="#pr_360_mfp" class="ttip_nt tooltip_top_left br__40 pl__30 pr__30 tc db bghp the4-popup-url nt_mfp_360">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 13.800781 4 12 5.800781 12 8 C 12 9.113281 12.476563 10.117188 13.21875 10.84375 C 11.886719 11.746094 11 13.28125 11 15 L 11 19.625 L 13 20.625 L 13 25 L 19 25 L 19 20.625 L 21 19.625 L 21 15 C 21 13.28125 20.113281 11.746094 18.78125 10.84375 C 19.523438 10.117188 20 9.113281 20 8 C 20 5.800781 18.199219 4 16 4 Z M 16 6 C 17.117188 6 18 6.882813 18 8 C 18 9.117188 17.117188 10 16 10 C 14.882813 10 14 9.117188 14 8 C 14 6.882813 14.882813 6 16 6 Z M 16 12 C 17.667969 12 19 13.332031 19 15 L 19 18.375 L 17 19.375 L 17 23 L 15 23 L 15 19.375 L 13 18.375 L 13 15 C 13 13.332031 14.332031 12 16 12 Z M 9 18.875 C 6.082031 19.691406 4 21.074219 4 23 C 4 26.28125 10.035156 28 16 28 C 21.964844 28 28 26.28125 28 23 C 28 21.074219 25.917969 19.691406 23 18.875 L 23 20.96875 C 24.902344 21.582031 26 22.375 26 23 C 26 24.195313 22.011719 26 16 26 C 9.988281 26 6 24.195313 6 23 C 6 22.375 7.097656 21.582031 9 20.96875 Z"/></svg>
                <span class="tt_txt">' . translate( 'View 360', 'kalles' ) .'</span></button>';
            $html .= '</div>';
            $html .= '<div id="pr_360_mfp" class="pr_360_wrapper pr mfp-hide"
                        data-args=\'' . wp_json_encode( $args ) . '\'><div class="threesixty pr"><div class="spinner"><span>0%</span></div><ul class="threesixty_imgs"></ul></div></div> ';
       }
        echo The4Helper::ksesHTML( $html );
    }
    add_action('kalles_product_image_action', 'the4_kalles_product_360_image_btn', 9);
}


/**
 * Display Photoswipe Template
 * @since  1.0
 */
if ( !function_exists('the4_kalles_photoswipe_template')) {

    function the4_kalles_photoswipe_template() {
        if ( function_exists( 'is_product' ) && is_product() )
            get_template_part( 'woocommerce/single-product/photo-swipe-template' );
    }

    add_action('wp_footer', 'the4_kalles_photoswipe_template', 500);
}

/**
 * Set categories view for each customer
 * @since  1.0
 */

if ( ! function_exists( 'the4_woo_set_categories_colunm' ) ) {
    function the4_woo_set_categories_colunm() {
        check_ajax_referer( 'the4_kalles_set_colunm_view', 'security_code' );

        $col = $_POST[ 'col' ];

        if ( $col ) {
            the4_set_cookie( 't4_cat_col', $col );

        }
    }
}
add_action( 'wp_ajax_the4_kalles_set_colunm_view', 'the4_woo_set_categories_colunm' );
add_action( 'wp_ajax_nopriv_the4_kalles_set_colunm_view',  'the4_woo_set_categories_colunm');

/**
 * Ajax Product tabs Widget for Elementor
 * @since  1.0
 */

if ( ! function_exists( 'the4_el_product_tab_widget' ) ) {
    function the4_el_product_tab_widget() {
        check_ajax_referer( 'the4_woo_change_tabs_el_datta', 'security_code' );

        $output = '';
        $paged = 1;
        $isAjax = false;
        $atts = $_POST['options'];

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
            $classes[] = 'wpb_animate_when_almost_visible ' . $atts['hover_style'] .'  wpb_' . $atts['css_animation'];
        }

        $args = array(
            'post_type'              => 'product',
            'posts_per_page'         => (int) $atts['limit'],
            'no_found_rows'          => true,
            'post_status'            => 'publish',
            'paged'                  => $paged,
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
                $args['order']    = 'desc';

                break;

            case 'top_rated':

                add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

                break;

        }

        $products = new WP_Query( $args );

        ob_start();

        if ( $products->have_posts() ) : ?>

            <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

        <?php endif;

            $output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" data-attrs=\'' . json_encode( $kalles_sc ) .'\'
            data-pages="' . $products->max_num_pages . '" data-paged="' . $paged . '">';
            $output .= ob_get_clean();


        if (  $atts['style'] != 'carousel' && $products->max_num_pages > $paged ) {
            if ( $kalles_sc['loadmore'] ) {
                $output .= '<div class="tc mt__40 mb__60" data-load-more="{}">
                                <a href="javascript:void(0)" class="pr nt_home_lm button"><span>'. translate('Load More', 'kalles') .'</span></a>
                            </div>';
            }
            $output .= '</div>';
        }
        $output = force_balance_tags( wp_kses_post( $output ) );

        wp_reset_postdata();

        // Reset kalles_sc global variable to null for render shortcode after
        $kalles_sc = NULL;
        wp_send_json( $output );
    }
}
add_action( 'wp_ajax_kalles_load_tab_data', 'the4_el_product_tab_widget' );
add_action( 'wp_ajax_nopriv_kalles_load_tab_data',  'the4_el_product_tab_widget');


/**************************
 *
 *
 * Add daily deal countdown to product loop - Elementor Widget
 *
 *
 ***************************/

 if ( ! function_exists( 't4_woo_countdown_el_widget' ) ) {
    function t4_woo_countdown_el_widget() {
    global $kalles_sc;

    if ( isset( $kalles_sc['type'] ) && $kalles_sc['type'] == 'product-deal' ) : ?>
        <div class="medizin_laypout">
            <div class="product-cd-header in_flex wrap al_center fl_center tc ">
                <h6 class="product-cd-heading section-title">
                <?php echo esc_html( $kalles_sc['title'] ) ?>
                </h6>
                <?php $date_now = date("Y-m-d H:i:s");  ?>
                <?php if ( ! empty( $kalles_sc['coundown_date'] ) && $kalles_sc['coundown_date'] > $date_now ) : ?>
                    <div class="countdown-wrap in_flex fl_center al_center wrap pr_deal_dt the4-countdown"><div class="countdown-label"><?php The4Helper::ksesHTML( $kalles_sc['coundown_text'] ); ?></div><div class="countdown pr_coun_dt" data-date="><?php echo esc_html( $kalles_sc['coundown_date'] ); ?>"></div></div>
                <?php endif; ?>
            </div>
    <?php endif;
    }
 }
 add_action( 'kalles_before_loop_start', 't4_woo_countdown_el_widget');


/**************************
 *
 *
 * CHECK OUT PROCESS - CART, CHECKOUT PAGE
 *
 *
 ***************************/

 if ( ! function_exists( 't4_woo_checkout_progress' ) ) {
    function t4_woo_checkout_progress() {
        ?>
        <div class="row">
            <div class="col-12">
                <div class="checkout-progress">
                    <ul class="checkout-step">
                        <li class="active step-1">
                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ); ?>"><?php esc_html_e( 'Shopping Cart', 'kalles' ); ?></a>
                        </li>
                        <li class="next-step">
                            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ); ?>"><?php esc_html_e( 'Checkout', 'kalles' ); ?></a>
                        </li>
                        <li>
                            <?php esc_html_e( 'Order Complete', 'kalles' ); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php
    }
}
if ( cs_get_option( 'wc-cart_progress' ) ) {
    add_action( 'woocommerce_before_cart', 't4_woo_checkout_progress' );
    add_action( 'woocommerce_before_checkout_form', 't4_woo_checkout_progress', 10 );
}

/**************************
 *
 *
 * TRUST BADGET CART & CHECKOUT PAGE
 *
 *
 ***************************/

if ( ! function_exists( 'the4_kalles_woo_trust_badget_cart_checkout' ) ) {
    function the4_kalles_woo_trust_badget_cart_checkout( $t_echo = false ) {
        $enable = cs_get_option( 'cart_checkout_trust_badget-enable' );

        if ($enable) {
            $al = cs_get_option( 'cart_checkout_trust_badget-image_align' ) ? cs_get_option( 'cart_checkout_trust_badget-image_align' ) : 'tc';
            $output = '';
            $output .= '<div class="pr_trust_seal col-md-12 col-lg-12 mt__20 ' . $al . '">';
            if (!empty(cs_get_option( 'cart_checkout_trust_badget-text' ))) {
                $output .= '<p class="mess_cd cb mb__10 fwm tu">' . cs_get_option( 'cart_checkout_trust_badget-text' ) . '</p>';
            }
            if (cs_get_option( 'cart_checkout_trust_badget-source_img' ) == '1') {
                $image = cs_get_option( 'cart_checkout_trust_badget-image' );
                if (!empty($image['url'])) {
                    $output .= '<img class="img_tr_s1 lazyload lz_op_ef" src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20' . $image['width'] .'%20' . $image['height'] .'%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" style="width:' . cs_get_option( 'cart_checkout_trust_badget-image_width' ) .'%;" data-src="' . $image['url'] .'" data-widths="[90, 120, 150, 180, 360, 480, 600, 750, 940, 1080, 1296]" data-sizes="auto"/>';
                }
            } else {
                $svg_width = cs_get_option( 'cart_checkout_trust_badget-svg-width' );
                $svg_height = cs_get_option( 'cart_checkout_trust_badget-svg-height' );
                $svg_vector = kalles_get_payment_icon_svg();
                $svg_list = cs_get_option( 'cart_checkout_trust_badget-svg-list' );
                if ( ! empty($svg_list) ) {
                    $svg_list = explode(',', $svg_list);
                    foreach ( $svg_list as $svg ) {
                        if ( isset( $svg_vector[$svg] ) ) {
                            $output .= $svg_vector[$svg];
                        }
                    }
                }

            }
            $output .= '</div>';

            if ( $t_echo == true ) {
                return $output;
            }
            The4Helper::ksesHTML( $output );
        }
    }
}
add_action( 'woocommerce_cart_collaterals', 'the4_kalles_woo_trust_badget_cart_checkout' );
add_action( 'woocommerce_review_order_after_submit', 'the4_kalles_woo_trust_badget_cart_checkout', 15 );
add_action( 'woocommerce_after_mini_cart', 'the4_kalles_woo_trust_badget_cart_checkout' );

/**************************
 *
 *
 * CROSS SELL WOO
 *
 *
 ***************************/

add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );


/**************************
 *
 *
 * SHIPPING BAR BLOCK - CART PAGE
 *
 *
 ***************************/
if ( ! function_exists( 'the4_kalles_woo_cart_shipping_bar' ) ) {
    function the4_kalles_woo_cart_shipping_bar() {

        $shipping_items = cs_get_option( 'wc_cart_shipping_items' );
        $cl_mb = cs_get_option( 'wc_cart_shipping_col_mb' ) == 'fl_wrap' ? 'col-12' : 'col-9';
        $is_border = cs_get_option( 'wc_cart_shipping_border' ) ? 'true' : 'false';

        ?>

        <div class="row mt__20 <?php echo esc_attr( cs_get_option( 'wc_cart_shipping_col_mb' ) ); ?> fl_wrap_md oah use_border_<?php echo esc_attr( $is_border ); ?>">
            <?php foreach( $shipping_items as $item ) : ?>
            <div class="<?php echo esc_attr( $cl_mb ); ?> col-12 col-md-<?php echo esc_attr( cs_get_option( 'wc_cart_shipping_col_pr_tb' ) ); ?> col-lg-<?php echo esc_attr( cs_get_option( 'wc_cart_shipping_col_pr' ) ); ?> mb__25">
                <div class="nt_shipping nt_icon_deafult <?php echo esc_attr( cs_get_option( 'wc_cart_shipping_icon_align' ) ); ?> row no-gutters al_center_">
                    <div class="col-auto icon <?php echo esc_attr( cs_get_option( 'wc_cart_shipping_icon_size' ) ); ?> csi">
                        <i class="pegk <?php echo esc_attr( $item[ 'wc_cart_shipping_item_icon' ] ); ?>"
                            style="color: <?php echo esc_attr( cs_get_option( 'wc_cart_shipping_icon_color' ) ); ?>"
                            ></i>
                    </div>
                    <div class="col content">
                        <h3 class="title cd fs__14 mg__0 mb__5"><?php The4Helper::ksesHTML( $item[ 'wc_cart_shipping_item_heading' ] ); ?></h3>
                        <p class="mg__0"><?php The4Helper::ksesHTML( $item[ 'wc_cart_shipping_item_text' ] ); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php
    }
}
if ( cs_get_option( 'wc_cart_shipping-enable' ) ) {
    add_action( 'woocommerce_after_cart', 'the4_kalles_woo_cart_shipping_bar' );
}


/**************************
 *
 *
 * TESTIMONIALS BLOCK - CART PAGE
 *
 *
 ***************************/
if ( ! function_exists( 'the4_kalles_woo_cart_testimonials' ) ) {
    function the4_kalles_woo_cart_testimonials() {
        $testimonials_items = cs_get_option( 'wc_cart_testimonial_items' );

        $auto_play = cs_get_option( 'wc_cart_testimonial_sider-autoplay' ) ? 'true' : 'false';
        $nav = cs_get_option( 'wc_cart_testimonial_sider-nav' ) ? 'true' : 'false';
        $dots = cs_get_option( 'wc_cart_testimonial_sider-dot' ) ? 'true' : 'false';

        if ( ! empty( $testimonials_items ) ) :

            $style = cs_get_option( 'wc_cart_testimonial_design' );
            $class = 'quotes_des_' . $style;
            if ( $style == 4 ) {
                $class .= ' no-gutters';
            }
        ?>
        <div class="mt__50 equal_nt position_8 row quotes_wrapper <?php echo esc_attr( $class ); ?>">
            <div class="col-md-12 col-lg-12 ">
                <div class="the4-carousel" data-slick='{"slidesToShow": 1,"slidesToScroll": 1, "autoplay": <?php echo esc_attr( $auto_play ); ?>, "arrows":<?php echo esc_attr( $nav ); ?>, "dots":<?php echo esc_attr( $dots ); ?>, "adaptiveHeight":true <?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}'>
                    <?php foreach( $testimonials_items as $item ) :
                        if ( isset( $item[ 'wc_cart_testimonial_item_image' ][ 'id' ] ) &&  $item[ 'wc_cart_testimonial_item_image' ][ 'id' ] != '' ) {
                            $image = wp_get_attachment_image( $item[ 'wc_cart_testimonial_item_image' ][ 'id' ], 'thumbnail' );
                        } else {
                            $image = '';
                        }

                        $point = '';

                        switch ( $item[ 'wc_cart_testimonial_item_point' ] ) {

                            case 1: $point = ', cra2, cra2, cra2, cra2,dn'; break;
                            case 1.5: $point = ',-half pr, cra2, cra2, cra2, cra2'; break;
                            case 2: $point = ',, cra2, cra2, cra2,dn'; break;
                            case 2.5: $point = ',,-half pr, cra2, cra2, cra2'; break;
                            case 3: $point = ',,, cra2, cra2,dn'; break;
                            case 3.5: $point = ',,,-half pr, cra2, cra2'; break;
                            case 4: $point = ',,,, cra2,dn'; break;
                            case 4.5: $point = ',,,,-half pr, cra2'; break;
                            case 5: $point = ',,,,,dn'; break;

                        }

                        $point_arr = explode( ',', $point);
                    ?>

                        <div class="quote_col mb__20">

                            <?php if ( $style == '3' || $style == '6' ) : ?>

                                <div class="quote_slide">
                                    <div class="quote_infors flex al_center">
                                        <?php if ( ! empty( $image ) ) : ?>
                                            <div class="quote_avatar dib mr__10 br__50 oh">
                                                <div class="nt_bg_lz <?php echo kalles_image_lazyload_class(); ?>">
                                                    <?php The4Helper::ksesHTML( $image ); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="quote_au_rev">
                                        <div class="quote_author cd fwsb"><?php echo esc_html( $item[ 'wc_cart_testimonial_item_name' ] ); ?></div>
                                            <div class="quote_rating fs__13 mb__10 fwb cra rating_2">
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[0] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[1] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[2] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[3] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[4] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[5] ); ?>"></i>
                                            </div>
                                        </div>
                                </div>
                                <div class="quote_texts mt__15">
                                    <p><?php The4Helper::ksesHTML( $item[ 'wc_cart_testimonial_item_content' ] ); ?></p>
                                </div>
                              </div>

                            <?php elseif ( $style == '4') : ?>
                                <div class="quote_slide">
                                    <div class="quote_texts mt__15">
                                        <p><?php The4Helper::ksesHTML( $item[ 'wc_cart_testimonial_item_content' ] ); ?></p>
                                    </div>
                                    <div class="quote_infors flex al_center">
                                        <?php if ( ! empty( $image ) ) : ?>
                                            <div class="quote_avatar dib mr__10 br__50 oh">
                                                <div class="nt_bg_lz <?php echo kalles_image_lazyload_class(); ?>">
                                                    <?php The4Helper::ksesHTML( $image ); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="quote_au_rev">
                                            <div class="quote_author cd fwsb">
                                                <?php echo esc_html( $item[ 'wc_cart_testimonial_item_name' ] ); ?>
                                            </div>
                                            <div class="quote_rating fs__13 fwb cra rating_2">
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[0] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[1] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[2] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[3] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[4] ); ?>"></i>
                                                <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[5] ); ?>"></i>
                                            </div>
                                        </div>
                                    </div>
                                  </div>

                            <?php else : ?>

                                <div class="quote_slide tc">
                                <?php if ( ! empty( $image ) ) : ?>
                                  <div class="quote_avatar dib mb__10 br__50 oh">
                                    <div class="nt_bg_lz <?php echo kalles_image_lazyload_class(); ?>">
                                        <?php The4Helper::ksesHTML( $image ); ?>
                                    </div>
                                  </div>
                                <?php endif; ?>
                                  <div class="quote_content">
                                    <div class="quote_rating fs__13 fwb mb__10 cra rating_<?php echo esc_attr( cs_get_option( 'wc_cart_testimonial_item_point' ) ); ?>">
                                        <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[0] ); ?>"></i>
                                        <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[1] ); ?>"></i>
                                        <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[2] ); ?>"></i>
                                        <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[3] ); ?>"></i>
                                        <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[4] ); ?>"></i>
                                        <i class="t4_icon_star-solid<?php echo esc_attr( $point_arr[5] ); ?>"></i>
                                    </div>
                                    <p><?php The4Helper::ksesHTML( $item[ 'wc_cart_testimonial_item_content' ] ); ?></p>
                                    <div class="quote_author cd fwsb"><?php The4Helper::ksesHTML( $item[ 'wc_cart_testimonial_item_name' ] ); ?></div>
                                  </div>
                                </div>

                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div> <!-- .quotes_wrapper -->
        </div>
        <?php
        endif;
    }
}

if ( cs_get_option( 'wc_cart_testimonial-enable' ) ) {
    add_action( 'woocommerce_cart_collaterals', 'the4_kalles_woo_cart_testimonials' );

}

/**************************
 *
 *
 * CART COUNTDOWN - CART PAGE
 *
 *
 ***************************/

if ( ! function_exists( 'the4_kalles_woo_cat_countdown' ) ) {
    function the4_kalles_woo_cat_countdown() {
        ?>

        <div class="tc mt__20 mb__20">
            <div class="cart_countdown js_cart_cd"
                 style="background-color: <?php echo esc_attr( cs_get_option( 'wc_cart_countdown-bg' ) ); ?>; color: <?php echo esc_attr (cs_get_option( 'wc_cart_countdown-text_color' ) ); ?>;">
                <?php The4Helper::ksesHTML( cs_get_option( 'wc_cart_countdown-text' ) ); ?>
                <span class="cart_time cr fwm" data-cart-countdown data-after-cartcd-1
                        data-mn='<?php echo esc_attr( cs_get_option( 'wc_cart_countdown-time' ) ); ?>'
                        data-unit='<?php echo esc_attr( cs_get_option( 'wc_cart_countdown-unit_time' ) ); ?>'></span>
            </div>
        </div>

        <?php
    }
}
if ( cs_get_option( 'wc_cart_countdown-enable' ) ) {
    add_action( 'woocommerce_before_cart', 'the4_kalles_woo_cat_countdown', 10 );
}


/**************************
 *
 *
 * MOVE COUPON TO BOTTOM POSITION
 *
 *
 ***************************/
if ( cs_get_option( 'wc_checkout_setting-coupon_position' ) == 'bottom' && cs_get_option( 'wc-checkout-layout' ) == 'layout_1' ) {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    add_action( 'woocommerce_after_checkout_form', 'woocommerce_checkout_coupon_form' );
    add_action( 'woocommerce_after_checkout_form', 't4_woo_coupon_section_wrapper_star', 5 );
    add_action( 'woocommerce_after_checkout_form', 't4_woo_coupon_section_wrapper_close', 99 );
}


/**************************
 *
 *
 * Full category description
 *
 *
 ***************************/
if ( ! function_exists( 'the4_kalles_woo_category_description' ) ) {
    function the4_kalles_woo_category_description() {
        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        if ( $term ) {
            $term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
            if ( isset( $term_options['cat-full-description'] ) ) :

            $description = $term_options['cat-full-description'];

            if ( ! empty( $description ) ) :
            ?>

            <div class="t4-cat-description mt__30">
                <p><?php The4Helper::ksesHTML( $description ); ?></p>
            </div>

            <?php endif;

            endif;
        }
    }

    add_action( 'woocommerce_after_shop_loop', 'the4_kalles_woo_category_description');
}

/**************************
 *
 *
 * Product description Tab layout
 *
 *
 ***************************/

if ( ! function_exists( 'the4_woo_product_description_layout' ) ) {
    function the4_woo_product_description_layout() {
        wc_get_template( 'single-product/tabs/full-layout.php' );
    }

}
if ( cs_get_option( 'wc-extra-layout' ) == 'full' ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    add_action( 'woocommerce_after_single_product_summary', 'the4_woo_product_description_layout', 10 );
}

/**************************
 *
 *
 * Product page buy now button
 *
 *
 ***************************/

if ( ! function_exists( 'the4_woo_buy_now_btn' ) ) {
    function the4_woo_buy_now_btn() {
        global $product;

        $product_type =  $product->get_type();

        if ( 'simple' == $product_type || 'variable' == $product_type ) :
            $btn_background = cs_get_option( 'wc-single-buynow_btn_color' ) ? cs_get_option( 'wc-single-buynow_btn_color' ) : '#000';

            if ( 'simple' == $product_type ) {
                $cart_url = add_query_arg('add-to-cart', $product->get_id(), wc_get_cart_url() );
            } elseif ( 'variable' == $product_type ) {
                $cart_url = add_query_arg('add-to-cart', '', wc_get_cart_url() );
            }
            ?>
            <div class="t4-buy-now-btn mt__20">
                <a class="btn btn-buy-now w__100 tc type_<?php echo esc_attr(  $product_type ); ?>"
                    style="background-color: <?php echo esc_attr( $btn_background ); ?>;"
                    href="<?php echo esc_url( $cart_url ); ?>">
                    <?php echo esc_html( cs_get_option( 'wc-single-buynow_text' ) ); ?>
                </a>
            </div>
            <?php
        endif;
    }

}
if ( cs_get_option( 'wc-single-buynow_btn' ) ) {
    add_action( 'woocommerce_after_add_to_cart_form', 'the4_woo_buy_now_btn' );
}

/**************************
 *
 *
 * Subtotal Minicart
 *
 *
 ***************************/

if ( ! function_exists( 't4_woo_widget_shopping_cart_subtotal' ) ) {
    /**
     * Output to view cart subtotal.
     *
     * @since 3.7.0
     */
    function t4_woo_widget_shopping_cart_subtotal() {
        ?>
        <div class="js_cat_dics <?php if ( ! WC()->cart->get_total_discount() ) : ?> dn <?php endif; ?>">
          <?php echo t4_woo_mini_cart_coupon_detail(); ?>
        </div>
        <div class="total row fl_between al_center">
            <div class="col-auto">
                <strong><?php esc_html_e( 'Subtotal:', 'kalles') ?></strong>
            </div>
            <div class="col-auto tr js_cat_ttprice">
                <?php echo t4_woo_mini_cart_subtotal() ?>
            </div>
        </div>
        <?php
    }
}
remove_action( 'woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10 );
add_action( 'woocommerce_widget_shopping_cart_total', 't4_woo_widget_shopping_cart_subtotal', 10 );

/**************************
 *
 *
 * Before Submit login form button
 *
 *
 ***************************/
if ( ! function_exists('t4_woo_google_capcha') ) {
    function t4_woo_google_capcha() {
        if ( cs_get_option('woocommerce_account-ajax') == false
            || ! cs_get_option('woocommerce_account-google_key')
            || ! cs_get_option('woocommerce_account-google_key_verify')
            || cs_get_option('woocommerce_account-google_capcha') == false ) {
            return;
        }

        $google_key = cs_get_option('woocommerce_account-google_key');

        if ( $google_key ) :
        ?>
            <p class="form-row google-capcha">
                <div class="g-recaptcha" data-sitekey="<?php echo esc_attr( $google_key ); ?>"></div>
            </p>
        <?php
        endif;
    }
}

add_action( 'woocommerce_login_form', 't4_woo_google_capcha' );
add_action( 'woocommerce_register_form', 't4_woo_google_capcha' );

/**************************
 *
 *
 * Google verify capcha
 *
 *
 ***************************/
if ( ! function_exists( 't4_google_verify_capcha' ) ) {
    function t4_google_verify_capcha( $capcha ) {
        if ( cs_get_option('woocommerce_account-ajax') == true
                && cs_get_option('woocommerce_account-google_key')
                && cs_get_option('woocommerce_account-google_key_verify')
                && cs_get_option('woocommerce_account-google_capcha') ) {

            $recaptcha = $capcha;

            if ( ! empty( $recaptcha ) )
            {
                $google_url = "https://www.google.com/recaptcha/api/siteverify";
                $secret = cs_get_option('woocommerce_account-google_key_verify');

                $ip = $_SERVER['REMOTE_ADDR'];
                $url = $google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;

                $results = wp_remote_get( $url );
                $res= json_decode($results['body'], true);

                if( !$res['success'] )
                {
                    echo json_encode(array('error'=>true, 'message'=>translate('reCAPTCHA invalid', 'kalles')));
                    die();
                }
            }
            else
            {
                echo json_encode(array('error'=>true, 'message'=>translate('Please enter reCAPTCHA', 'kalles')));
                die();
            }
        }
    }
}

/**************************
 *
 *
 * Ajax Login
 *
 *
 ***************************/
if ( ! function_exists( 't4_ajax_login' ) ) {
    function t4_ajax_login() {

        // Get variables
        parse_str($_POST['data'], $data);

        $user_login     = $data['username'];
        $user_pass      = $data['password'];

        // Check if reCaptcha is valid
        t4_google_verify_capcha( $data['g-recaptcha-response'] );

        // Check CSRF token
        if( ! check_ajax_referer( 'kalles-login-ajax', 'security_code', false) ){
            echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'.__('Session token has expired, please reload the page and try again', 'kalles').'</div>'));
        }

        // Check if input variables are empty
        elseif( empty($user_login) || empty($user_pass) ){
            echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'.__('Please fill all form fields', 'kalles').'</div>'));
        } else { // Now we can insert this account

            $user = wp_signon( array('user_login' => $user_login, 'user_password' => $user_pass), false );

            if( is_wp_error($user) ){
                echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'.$user->get_error_message().'</div>'));
            } else{
                echo json_encode(array('error' => false, 'message'=> '<div class="alert alert-success">'.__('Login successful, reloading page...', 'kalles').'</div>'));
            }
        }

        die();
    }
}

add_action( 'wp_ajax_the4_ajax_login', 't4_ajax_login' );
add_action( 'wp_ajax_nopriv_the4_ajax_login', 't4_ajax_login' );

/**************************
 *
 *
 * Ajax Register
 *
 *
 ***************************/
if ( ! function_exists( 't4_ajax_register' ) ) {
    function t4_ajax_register() {

        check_ajax_referer( 'kalles-register-ajax', 'security_code', false);

        // Get variables
        parse_str($_POST['data'], $data);

        $info = array();

        $user_email     = $data['email'];
        $user_pass      = $data['password'];

        // Check if reCaptcha is valid
        t4_google_verify_capcha( $data['g-recaptcha-response'] );


        if (  'no' === get_option( 'woocommerce_registration_generate_password' ) ) {
            $username  = $data['username'];

            $errors = wc_create_new_customer($user_email, $username ,$user_pass);
        } else {
            $errors = wc_create_new_customer($user_email, '',$user_pass);
        }

        if( is_wp_error($errors) ){

            $registration_error_messages = $errors->errors;

            $display_errors = '<div class="alert alert-danger">';

                foreach($registration_error_messages as $error){
                    $display_errors .= '<p>'.$error[0].'</p>';
                }

            $display_errors .= '</div>';

            echo json_encode(array('error' => true, 'message' => $display_errors));

        } else {
            wp_signon( array('user_login' => $user_email, 'user_password' => $user_pass), false );
            echo json_encode(array('error' => false, 'message' => '<div class="alert alert-success">'.__( 'Registration complete.', 'kalles') ));
        }

        die();
    }
}

add_action( 'wp_ajax_the4_ajax_register', 't4_ajax_register' );
add_action( 'wp_ajax_nopriv_the4_ajax_register', 't4_ajax_register' );

/**************************
 *
 *
 * Add social login to form
 *
 *
 ***************************/
if ( ! function_exists( 't4_woo_social_login' ) ) {
    function t4_woo_social_login() {
        if ( cs_get_option( 'woocommerce_account-social' ) ) {
            $fb = cs_get_option('woocommerce_account-social_facebook');
            $gg = cs_get_option('woocommerce_account-social_google');
            $tw = cs_get_option('woocommerce_account-social_twitter');

            ?>

                <div class="kalles-social-login">
                    <p class="kalles-social-login__title"><?php esc_html_e( 'Or login with', 'kalles' ) ?></p>
                    <div class="kalles-social-login__content flex">
                        <?php if ( isset( $fb['social_facebook-on'] ) &&  $fb['social_facebook-on'] && isset( $fb['social_facebook-id'] ) && isset( $fb['social_facebook-key']) ) : ?>
                            <div class="kalles-social__item">
                                <a href="<?php echo add_query_arg('social_login', 'facebook', wc_get_page_permalink('myaccount')); ?>" class="kalles-social__item-link link-facebook">
                                    <i class="t4_icon_facebook-f"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ( isset( $gg['social_google-on'] ) &&  $gg['social_google-on'] && isset( $gg['social_google-id'] ) && isset( $gg['social_google-key']) ) : ?>
                            <div class="kalles-social__item">
                                <a href="<?php echo add_query_arg('social_login', 'google', wc_get_page_permalink('myaccount')); ?>" class="kalles-social__item-link link-google">
                                    <i class="t4_icon_google-plus"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ( isset( $tw['social_twitter-on'] ) &&  $tw['social_twitter-on'] && isset( $tw['social_twitter-id'] ) && isset( $tw['social_twitter-key']) ) : ?>
                            <div class="kalles-social__item">
                                <a href="<?php echo add_query_arg('social_login', 'twitter', wc_get_page_permalink('myaccount')); ?>" class="kalles-social__item-link link-twitter">
                                    <i class="t4_icon_twitter"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
        }
    }
}
add_action('woocommerce_login_form_end', 't4_woo_social_login');
if ( ! function_exists( 't4_woo_social_login_2' ) ) {
    function t4_woo_social_login_2() {
        if ( cs_get_option( 'woocommerce_account-social' ) ) {
            $fb = cs_get_option('woocommerce_account-social_facebook');
            $gg = cs_get_option('woocommerce_account-social_google');
            $tw = cs_get_option('woocommerce_account-social_twitter');

            ?>

            <div class="kalles-social-login">
                <div class="kalles-social-login__content">
                    <?php if ( isset( $fb['social_facebook-on'] ) &&  $fb['social_facebook-on'] && isset( $fb['social_facebook-id'] ) && isset( $fb['social_facebook-key']) ) : ?>
                        <div class="kalles-social_item">
                            <a href="<?php echo add_query_arg('social_login', 'facebook', wc_get_page_permalink('myaccount')); ?>" class="kalles-social__item-link link-facebook">
                                <i class="t4_icon_facebook-f"></i><?php esc_html_e( 'Login width Facebook', 'kalles' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ( isset( $gg['social_google-on'] ) &&  $gg['social_google-on'] && isset( $gg['social_google-id'] ) && isset( $gg['social_google-key']) ) : ?>
                        <div class="kalles-social_item">
                            <a href="<?php echo add_query_arg('social_login', 'google', wc_get_page_permalink('myaccount')); ?>" class="kalles-social__item-link link-google">
                                <i class="t4_icon_google-plus"></i><?php esc_html_e( 'Login width Google', 'kalles' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ( isset( $tw['social_twitter-on'] ) &&  $tw['social_twitter-on'] && isset( $tw['social_twitter-id'] ) && isset( $tw['social_twitter-key']) ) : ?>
                        <div class="kalles-social_item">
                            <a href="<?php echo add_query_arg('social_login', 'twitter', wc_get_page_permalink('myaccount')); ?>" class="kalles-social__item-link link-twitter">
                                <i class="t4_icon_twitter"></i><?php esc_html_e( 'Login width Twitter', 'kalles' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
    }
}
add_action('t4_woo_social_login_2', 't4_woo_social_login_2');

/**************************
 *
 *
 * Add field upload avatar on Account details section
 *
 *
 ***************************/
if ( ! function_exists( 't4_woo_account_details_add_filed_avt' ) ) {
    function t4_woo_account_details_add_filed_avt() {

        ?>
        <div class="account-avatar">
            <?php echo t4_woo_get_user_avatar(); ?>
        </div>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="image"><?php esc_html_e( 'Avatar', 'kalles' ); ?></label>
            <input type="file" class="woocommerce-Input" name="image" accept="image/x-png,image/gif,image/jpeg">
        </p>
    <?php
    }
}


// Validate
function t4_woo_action_woocommerce_save_account_details_errors( $args ){
    if ( isset($_POST['image']) && empty($_POST['image']) ) {
        $args->add( 'image_error', __( 'Please provide a valid image', 'kalles' ) );
    }
}


// Save
function t4_woo_action_woocommerce_save_account_details( $user_id ) {
    if ( isset( $_FILES['image'] ) ) {

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        $attachment_id = media_handle_upload( 'image', 0 );

        if ( is_wp_error( $attachment_id ) ) {
            update_user_meta( $user_id, 'image', $_FILES['image'] . ": " . $attachment_id->get_error_message() );
        } else {
            update_user_meta( $user_id, 'image', $attachment_id );
        }
   }
}

// Add enctype to form to allow image upload
function t4_woo_action_woocommerce_edit_account_form_tag() {
    echo 'enctype="multipart/form-data"';
}

if ( cs_get_option('woocommerce_account-avatar') ) {
    add_action( 'woocommerce_edit_account_form_start', 't4_woo_account_details_add_filed_avt' );
    add_action( 'woocommerce_save_account_details_errors','t4_woo_action_woocommerce_save_account_details_errors', 10, 1 );
    add_action( 'woocommerce_save_account_details', 't4_woo_action_woocommerce_save_account_details', 10, 1 );
    add_action( 'woocommerce_edit_account_form_tag', 't4_woo_action_woocommerce_edit_account_form_tag' );
}


/**
 * Ordering and result count.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_result_count() {
    echo '<div class="result-count-order"><div class="cat_toolbar row fl_center al_center mt__30">';
}
function the4_kalles_wc_catalog_ordering() {
    echo '</div></div>';
}
add_action( 'woocommerce_before_shop_loop', 'the4_kalles_wc_result_count', 10 );
add_action( 'woocommerce_before_shop_loop', 'the4_kalles_wc_catalog_ordering', 30);

/**
 * Product title & description.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_product_title() {
    echo '<h3 class="product-title pr fs__14 mg__0 fwm"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
}

function the4_kalles_wc_product_short_description() {
    global $product;

    $shor_des = $product->get_short_description();

    if ( empty($shor_des) ) {
        $shor_des = wp_trim_words( $product->get_description(), $num_words = 55, '...' );
    }
    echo '<div class="rte product-list-des dn"><p class="mt__5">' . $shor_des . '</p></div>';
}

add_action( 'woocommerce_shop_loop_item_title', 'the4_kalles_wc_product_title', 15 );
add_action( 'woocommerce_after_shop_loop_item_title', 'the4_kalles_wc_product_short_description', 15 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/**
 * Display btn QuickShop & QuickView on list view mode
 *
 * @since 1.0.0
 */
function the4_kalles_listview_btn_quickview( ) {
    global $product;
    $html = '<a class="pr btn-quickview js_add_qv cd br__40 pl__25 pr__25 bgw tc dib"
                href="' . get_the_permalink() .'" data-prod="' . get_the_ID() .'" rel="nofollow">
                <span>' . translate('Quick view', 'kalles') .'</span>
            </a>';



     The4Helper::ksesHTML( $html );
}
if ( cs_get_option('wc-quick-view-btn') ) {
    add_action( 'kalles_product_loop_btn_info', 'the4_kalles_listview_btn_quickview' );
}

/**
 * Remove e-commerce function when enable catalog mode.
 *
 * @since 1.1
 */
$catalog_mode = cs_get_option( 'wc-catalog' );
if ( $catalog_mode ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}

/**
 * Change position of product tab.
 *
 * @since 1.0.0
 */

/**
 * Add extra link after single cart.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_add_extra_link_after_cart() {
    // Get page options
    $options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

    $size_guide_type = cs_get_option( 'wc-single-size-guide-type' );

    $size_guide_image = cs_get_option( 'wc-single-size-guide' );
    // Get image to display size guide

    if (isset($options['wc-single-size-guide']) && $options['wc-single-size-guide']) {
        $size_guide =  $options['wc-single-size-guide'];
    } else {
        $size_guide = ( isset( $size_guide_image['url'] ) ) ? $size_guide_image['url'] : '';
    }

    // Get help content
    $message = cs_get_option( 'wc-single-shipping-return' );

    if ( cs_get_option( 'wc-single-size-guide-enable' ) || cs_get_option( 'wc-single-shipping-return-enable' ) ) {

        echo '<div class="extra-link t4-size-guide mt__25 fwsb">';

        if ( cs_get_option( 'wc-single-size-guide-enable' ) ) {
            if ( $size_guide_type == 'image' || ( isset( $options['wc-single-size-guide'] ) && $options['wc-single-size-guide'] ) ) {
            echo '<a class="cd chp the4-magnific-image  mr__20" href="' . esc_url( $size_guide ) . '">' . esc_html__( 'Size Guide', 'kalles' ) . '</a>';
            } else {
                echo '<a data-type="size_guide" data-content="the4_size_guide" class="js_get_html_content  cd chp mr__20" href="#">' . esc_html__( 'Size Guide', 'kalles' ) . '</a>';
            }
        }

        if ( ! empty( $message ) && cs_get_option( 'wc-single-shipping-return-enable' ) ) {
            echo '<a data-type="shipping-return" data-content="the4_shipping_return" class="js_get_html_content cd chp" href="#">' . esc_html__( 'Delivery & Return', 'kalles' ) . '</a>';
        }
        echo '</div>';
    }
}
add_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_add_extra_link_after_cart', 35 );

/**
 * Custom layout review and price.
 *
 * @since 1.0.0
 */
function the4_kalles_wc_before_price() {
    // Get page options
    $options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

    $style = ( is_array( $options ) && $options['wc-single-style'] ) ? $options['wc-single-style'] : ( cs_get_option( 'wc-single-style' ) ? cs_get_option( 'wc-single-style' ) : '1' );
    if ( $style == 3 ) {
        echo '<div class="flex column price-review">';
    } else {
        echo '<div class="flex wrap fl_between al_center price-review">';
    }
}
function the4_kalles_wc_after_rating() {
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_before_price', 5 );
add_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_after_rating', 15 );

/**
 * Recommed product thankyou page
 *
 * @since 1.1.1
 *
 */
if ( ! function_exists('kalles_woo_action_thankyou_recommed_product') ) {
    function kalles_woo_action_thankyou_recommed_product() {

        $args = array(
            'post_type'              => 'product',
            'posts_per_page'         => cs_get_option('wc_checkout_thankyou-product_no'),
            'no_found_rows'          => true,
            'post_status'            => 'publish',
            'cache_results'          => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        );

        $product_ids = cs_get_option( 'wc_checkout_thankyou-products' );

        if ( ! empty( $product_ids ) && is_array( $product_ids ) ) {
            $args['post__in'] = $product_ids;
        }

        $categories = cs_get_option( 'wc_checkout_thankyou-category' );

        if ( $categories ) {
            $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'id',
                        'terms'    => $categories,
                    ),
                );
        }

        $products = new WP_Query( $args );

        $title = cs_get_option('wc_checkout_thankyou-title') ? cs_get_option('wc_checkout_thankyou-title') : 'You also like';
        $subtitle = cs_get_option('wc_checkout_thankyou-subtext');
        $title_type = cs_get_option('wc_checkout_thankyou-title_design');
        $title_icon = cs_get_option('wc_checkout_thankyou-style7_icon') ? cs_get_option('wc_checkout_thankyou-style7_icon') : 'gem';
        $slidesToShow = cs_get_option('wc_checkout_thankyou-product_no_slider') ? cs_get_option('wc_checkout_thankyou-product_no_slider') : 4;

        if( $products->have_posts() ) {
        ?>
            <div class="thankyou-page__recommed product-extra mt__30 mb__60">
                <div class="wrap_title  des_<?php echo esc_attr( $title_type ); ?>">
                    <h3 class="the4-section-title mg__0 tc pr flex fl_center al_center fs__24 <?php echo esc_attr( $title_type ); ?>">
                        <span class="mr__10 ml__10"><?php echo esc_html( $title ); ?></span>
                    </h3>
                    <span class="dn tt_divider">
                        <span></span>
                        <i class="dn clprfalse<?php echo esc_attr( $title_type ); ?> la la-<?php echo esc_attr( $title_icon ); ?>"></i>
                        <span></span>
                    </span>
                    <span class="section-subtitle db tc sub-title"><?php echo esc_html( $subtitle ); ?></span>
                </div>

            <div class="the4-carousel" data-slick='{"slidesToShow": <?php echo esc_attr( $slidesToShow ); ?>,"slidesToScroll": 1,"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 480,"settings":{"slidesToShow": 2}}]<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}'>
            <?php
            while ( $products->have_posts() ) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }
            ?>
                </div>
            </div>
        <?php
        }
        wp_reset_postdata();
    }
}
add_action( 'woocommerce_thankyou', 'kalles_woo_action_thankyou_recommed_product');

/**
 * Coupon code thankyou page
 *
 * @since 1.1.1
 *
 */
if ( ! function_exists('kalles_woo_action_thankyou_coupon') ) {
    function kalles_woo_action_thankyou_coupon( $order ) {
        $coupon_code = cs_get_option('wc_checkout_thankyou_coupon-code');
        $order_total = $order->get_total();
        $min_total   = cs_get_option('wc_checkout_thankyou_coupon-min_total');

        if ( $order_total < $min_total || ! cs_get_option('wc_checkout_thankyou_coupon-enable') ) {
            return;
        }

        if ($coupon_code) {
            $coupon = new WC_Coupon($coupon_code);



            if ($coupon) {

                $coupon_code = strtoupper( $coupon->get_code() );
                $message     = cs_get_option('wc_checkout_thankyou_coupon-message');

                if ($coupon->get_discount_type() == 'percent') {
                    $coupon_amount = $coupon->get_amount() . '%';
                } else {
                    $coupon_amount = wc_price($coupon->get_amount());
                }

                $message     = str_replace('{coupon_value}', $coupon_amount, $message);

                $date_expires = $coupon->get_date_expires();

                $coupon_date_expires = empty($date_expires) ? esc_html__('Never expires', 'kalles') : date_i18n('F d, Y', strtotime($date_expires));
                $last_valid_date = empty($date_expires) ? '' : date_i18n('F d, Y', strtotime($date_expires) - 86400);

                ?>
                    <div class="row kalles-thankyou-coupon mb__60">
                        <dic class="col-12 tc">
                            <p><?php The4Helper::ksesHTML( $message ); ?></p>
                            <h3><?php echo esc_html( $coupon_code ); ?></h3>
                            <p class="expires-date"><?php esc_html_e('Expires date', 'kalles') ?> : <b><?php echo esc_html( $coupon_date_expires ); ?></b></p>
                        </div>
                    </div>
                <?php
            }
        }

    }
}
add_action( 'kalles_thankyou_before_body', 'kalles_woo_action_thankyou_coupon');

