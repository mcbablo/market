<?php
/**
 * Filter hooks.
 *
 * @since   1.0.0
 * @package Kalles
 */


//Remove add to cart Message
if ( get_option( 'woocommerce_enable_ajax_add_to_cart_single' ) == 'yes') {

    add_filter( 'wc_add_to_cart_message_html', '__return_false' );
}

//disable image scaling in WordPress (a version 5.3 update)

add_filter( 'big_image_size_threshold', '__return_false' );

//SRC tag img Allower 'data'

add_filter('kses_allowed_protocols', function ($protocols) {
    $protocols[] = 'data';

    return $protocols;
});


//Allow SVG upload during Import process

if ( ! function_exists( 'the4_cc_mime_types' ) ) {
    function the4_cc_mime_types($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }
}
add_filter('upload_mimes', 'the4_cc_mime_types');


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function the4_kalles_body_class( $classes ) {
    // Add class for header left
    if ( cs_get_option( 'header-layout' ) == 5 ) {
        $classes[] = 'header-lateral';
    }
    if ( cs_get_option( 'page-class' ) ) {
        $classes[] = 'home';
    }

    // Add class for boxed layout
    if ( cs_get_option( 'boxed' ) || cs_get_option( 'header-boxed' ) || cs_get_option( 'layout-type' ) == 'boxed' ) {
        $classes[] = 'boxed';
    }
	if( cs_get_option( 'header-boxed' )  ){
        $classes[] = 'boxed-header-boxed';
    }
    // Add body class when enable sticky add to cart
    if ( cs_get_option( 'wc-sticky-atc' ) ) {
        $classes[] = 'has-btn-sticky';
    }

    if ( cs_get_option( 'maintenance' ) ) {
        $class[] = 'offline';
    }

    // Add class to handle mobile layout
    if ( wp_is_mobile() ) {
        $classes[] = 'the4-mobile';
    }

    $atc_behavior = cs_get_option( 'wc-atc-behavior' ) ? cs_get_option( 'wc-atc-behavior' ) : 'slide';


    $classes[] = 'kalles-atc-behavior-'. $atc_behavior;

    $the4_kalles_cart_mode = cs_get_option('wc-cart-cart_type') ? cs_get_option('wc-cart-cart_type') : 'sidebar';

    $classes[] = 'kalles-cart-'. $the4_kalles_cart_mode;

    //Label style
    $the4_kalles_label_style = cs_get_option('wc-badge-style') ? cs_get_option('wc-badge-style') : 'rectangular';
    $classes[] = 'label_style_'. $the4_kalles_label_style;

    //Swatch litmit on product page
    if ( cs_get_option( 'wc_product_swatches-list_limit' ) ) {
        $classes[] = 'prs_sw_limit_true';
    }
    //header layout
    $header_layout = cs_get_option( 'header-layout' ) ? cs_get_option( 'header-layout' ) : '3';
    $classes[] = 'header-layout-' . $header_layout;

    //Check container full Width
    if ($header_layout == 3 || $header_layout == 2 || $header_layout == 4 || $header_layout == 1 || $header_layout == 7 || $header_layout == 8 || $header_layout == 9 || $header_layout == 11|| $header_layout == 12 || $header_layout == 14 || $header_layout == 15 || $header_layout == 17 || $header_layout == 18) {
        $classes[] = 'header_full_true';
    }
    //General layout
    $general_layout = cs_get_option( 'layout-type' ) ? cs_get_option( 'layout-type' ) : 'full_width';
    $classes[] = 'wrapper_' . $general_layout;

    //Compare

    if ( cs_get_option( 'wc_general_compare' ) ) {
        $classes[] = 't4_compare_true';
    }

    //Checkout layout

    $checkout_layout = cs_get_option( 'wc-checkout-layout' ) ? cs_get_option( 'wc-checkout-layout' ) : 'layout_1';
    $classes[] = 'checkout_' .$checkout_layout ;

    //Account layout
    $account_layout = cs_get_option( 'woocommerce_account-type' ) ? cs_get_option( 'woocommerce_account-type' ) : 'sidebar';
    $classes[] = 'account_' .$account_layout ;

    $classes[] = cs_get_option('woocommerce_account-ajax') == true ? 'account_ajax' : '';

    //btn style
    $btn_style = cs_get_option( 'btn_design' ) ? cs_get_option( 'btn_design' ) : '1';

    $classes[] = 'btn_des_g_' . $btn_style;

    //Add more class
    $classes[] = 'css_scrollbar';

    $classes[] = 'rtl_false';

    //Toolbar mobile
    if ( cs_get_option('general_mobile_toolbar-enable') ) {
        $classes[] = 'is-toolbar-mobile';
    }

    return $classes;
}
add_filter( 'body_class', 'the4_kalles_body_class' );

/**
 * Filter portfolio limit per page.
 *
 * @since 1.0.0
 */
function the4_kalles_portfolio_per_page( $query ) {
    if ( ! is_post_type_archive( 'portfolio' ) ) return;

    // Get portfolio number per page
    $limit = cs_get_option( 'portfolio-number-per-page' );
    if ( $query->query_vars['post_type'] == 'portfolio' && !is_admin() ) $query->query_vars['posts_per_page'] = $limit;

    return $query;
}
add_filter( 'pre_get_posts', 'the4_kalles_portfolio_per_page' );



//disable Lazyload default by WP
if ( ! cs_get_option('general_lazyload-enable') && cs_get_option('general_lazyload-type') != 'wp' ) {
    add_filter( 'wp_lazy_loading_enabled', '__return_false' );
}

/**
 * Filter Add to cart form attrs
 *
 * @since 1.0.0
 */
function the4_kalles_add_to_cart_attr( ) {
    global $product;
    // Get page options
    $options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

    // Get product single style
    $style = ( is_array( $options ) && $options['wc-single-style'] ) ? $options['wc-single-style'] : ( cs_get_option( 'wc-single-style' ) ? cs_get_option( 'wc-single-style' ) : '1' );
    $thumb_position = ( is_array( $options ) && $options['wc-single-style'] == 1 && $options['wc-thumbnail-position'] ) ? $options['wc-thumbnail-position'] : ( cs_get_option( 'wc-thumbnail-position' ) ? cs_get_option( 'wc-thumbnail-position' ) : 'left' );
    $attrs = 'data-thumb_style="' . $style .'" data-thumb_position="' . $thumb_position . '"';
    return $attrs;
}
add_filter( 'kalles-add-to-cart-attr' , 'the4_kalles_add_to_cart_attr' );


/**
 * Filter Search form full
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'the4_get_search_form_full' ) ) {
    function the4_get_search_form_full() {
        if ( ! class_exists( '\Kalles\Woocommerce\Search' ) ) {
            return;
        }
        
        ob_start();

        ?>

        <form name="the4-product-search"
              method="get"
              class="h_search_frm"
              action="<?php echo esc_url( home_url( '/' ) ); ?>">

            <div class="search_header mini_search_frm pr js_frm_search" role="search">
                <?php $categories = \Kalles\Woocommerce\Search::instance()->the4_get_product_category(); ?>
                    <div class="row al_center">
                        <?php if ($categories): ?>
                        <div class="frm_search_cat col-auto">
                            <select name="product_cat" class="the4-search-category">
                                <option class="default" value=""><?php esc_html_e( 'Select a category', 'kalles' ); ?></option>
                                <?php \Kalles\Woocommerce\Search::instance()->the4_get_categories_option( $categories); ?>
                            </select>
                        </div>
                        <div class="col-auto h_space_search"></div>
                        <?php endif ?>
                    <div class="frm_search_input pr oh the4-search-wrapper col">
                        <input type="text"
                               name="s"
                               autocomplete="off"
                               class="the4-search search_header__input js_iput_search placeholder-black  <?php if (cs_get_option('wc-search_ajax')) echo esc_attr( 'search_ajax_enable' ) ?>"
                               placeholder="<?php esc_attr_e( 'Search for product...', 'kalles' ); ?>" value="">
                        <input type="hidden" name="post_type" value="product">

                    </div>
                    <div class="frm_search_cat col-auto">
                        <button class="h_search_btn js_btn_search" type="submit">
                            <?php esc_html_e('Search', 'kalles'); ?>
                        </button>
                    </div>
                <!-- end row -->
            </div>

            </div>

        </form>

        <?php

        echo apply_filters( 'get_search_form', ob_get_clean() );
    }

}

/**
 * Filter Search form
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'the4_get_search_form' ) ) {

    function the4_get_search_form(  $check_full_width  = false) {
        if ( ! class_exists( '\Kalles\Woocommerce\Search' ) ) {
            return;
        }

        ob_start();

        ?>

        <form name="the4-product-search"
              role="search" method="get"
              action="<?php echo esc_url( home_url( '/' ) ); ?>">

            <div class="search_header mini_search_frm pr js_frm_search" role="search">
                <?php $categories = \Kalles\Woocommerce\Search::instance()->the4_get_product_category(); ?>

                <?php if ($check_full_width == true) : ?>
                    <div class="row seach-full-width">
                <?php endif; ?>
                    <div class="frm_search_cat mb__15 <?php if ($check_full_width == true) echo 'col-lg-auto col-md-12'; ?>">
                        <?php if ($categories): ?>
                            <select name="product_cat" class="the4-search-category">
                                <option class="default" value=""><?php esc_html_e( 'All categories', 'kalles' ); ?></option>
                                <?php \Kalles\Woocommerce\Search::instance()->the4_get_categories_option( $categories); ?>
                            </select>
                        <?php endif ?>
                    </div>
                    <div class="frm_search_input pr oh the4-search-wrapper <?php if ($check_full_width == true) echo 'col-lg col-md-12'; ?>">
                        <input type="text"
                               name="s"
                               class="the4-search search_header__input js_iput_search placeholder-black  <?php if (cs_get_option('wc-search_ajax')) echo  esc_attr( 'search_ajax_enable' ) ?>"
                               placeholder="<?php esc_attr_e( 'Search for product...', 'kalles' ); ?>" value="">
                        <input type="hidden" name="post_type" value="product">
                        <button class="search_header__submit js_btn_search" type="submit"><i class="t4_icon_t4-search"></i>
                        </button>
                        <?php if ( cs_get_option( 'wc-search_suggest_enable') ) : ?>
                            <div class="search_header_suggest">
                                <?php t4_woo_search_suggestion_text(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <!-- end row -->
                <?php if ($check_full_width == true) : ?>
                    </div>
                <?php endif; ?>

                <div class="ld_bar_search"></div>  
            </div>

        </form>

        <?php

        echo apply_filters( 'get_search_form', ob_get_clean() );
    }

}

/**
 * Custom 404 page *
 * @since 1.1.2
 *
 */
if ( ! function_exists( 'kalles_custom_404_page' ) ) {
    function kalles_custom_404_page( $template ) {
        global $wp_query;

        $page_404 = cs_get_option('general_404-page');

        if ( ! $page_404 ) {
            return $template;
        }

        $wp_query->query( 'page_id=' . $page_404 );
        $wp_query->the_post();

        $template = get_page_template();
        
        rewind_posts();

        return $template;
    }

    add_filter( '404_template', 'kalles_custom_404_page', 100 );
}


/**
 * Add custom attr to HTML img Elementor.
 *
 * @since 1.0
 *
 * @return String
 */

function the4_kalles_el_custom_img_attr( $html, $settings, $image_size_key, $image_key ) {

    if ( $settings['image_size'] == 'custom' ) {
        $doc = new DOMDocument();
        $doc->loadHTML( $html );
        $tags = $doc->getElementsByTagName('img');

        $img_width = $settings['image_custom_dimension']['width'] ?  $settings['image_custom_dimension']['width'] : '300';
        $img_height = $settings['image_custom_dimension']['height'] ?  $settings['image_custom_dimension']['height'] : '400';
        $new_src_url = 'data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20' . $img_width . '%20' . $img_height . '%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E';

        foreach ($tags as $tag) {
            $old_src = $tag->getAttribute('src');
            $tag->setAttribute('data-src', $old_src);

            if ( cs_get_option( 'general_lazyload-type' ) == 'wp'  ){

                $tag->setAttribute('loading', 'lazy');
            } else {
                $tag->setAttribute('src', $new_src_url);
                $tag->setAttribute('class', 'lazyload');
            }
        }
        
        # remove <!DOCTYPE
        $doc->removeChild($doc->doctype);
        # remove <html><body></body></html>
        $doc->replaceChild($doc->firstChild->firstChild->firstChild, $doc->firstChild);

        $html = '<div class="t4-el-image '. kalles_image_lazyload_class() .'">' . $doc->saveHTML() . '</div>';
        return $html;
    } else {
        return $html;
    }

}
if ( cs_get_option( 'general_lazyload-enable' ) ) {
    add_filter( 'elementor/image_size/get_attachment_image_html', 'the4_kalles_el_custom_img_attr', 10, 4 );
}