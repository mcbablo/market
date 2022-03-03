<?php
/**
 * Initialize Elementor
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

if ( ! defined( 'KALLES_THEME_EL_PATH' ) ) {
    define( 'KALLES_THEME_EL_PATH', THE4_KALLES_PLUGINS_PATH . '/elementor');
}
/// Used to prevent loading of Google Fonts by Elementor
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

//// Fix for Pin maker plugin shortcodes support
add_action( 'init', 'the4_kalles_pin_preview_enable');
if (! function_exists('the4_kalles_pin_preview_enable')) {
    function the4_kalles_pin_preview_enable()
    {
        if (is_admin() && function_exists('WPA_PM')) {
            $pin_lugin_path = WPA_PM()->plugin_path();

            include_once($pin_lugin_path . '/includes/pm-template-hooks.php');
            include_once($pin_lugin_path . '/includes/pm-template-functions.php');
            include_once($pin_lugin_path . '/includes/class-pm-shortcodes.php');
        }
    }
}
// Fix not include WC Frontend funtion
add_action( 'init', 'the4_kalles_woo_include_frontend');
if (! function_exists('the4_kalles_woo_include_frontend')) {
    function the4_kalles_woo_include_frontend()
    {
        if (! empty($_REQUEST['action']) && 'elementor' === $_REQUEST['action'] && is_admin()) {
            if (function_exists('wc')) {
                wc()->frontend_includes();
            }
        }
    }
}

//Add custom control
add_action( 'elementor/controls/controls_registered', 'the4_kalles_el_add_custom_control');
if (! function_exists('the4_kalles_el_add_custom_control')) {
    function the4_kalles_el_add_custom_control()
    {
        include_once KALLES_THEME_EL_PATH . '/controls/post_select_control.php';

        \Elementor\Plugin::instance()->controls_manager->register_control('kalles_post_select', new \The4Addon\Post_Select_Control);
    }
}

// Add a custom category for panel widgets
add_action( 'elementor/init', 'the4_kalles_el_init');
if (! function_exists('the4_kalles_el_init')) {
    function the4_kalles_el_init()
    {
        \Elementor\Plugin::$instance->elements_manager->add_category(
            'kalles-elements',
            array(
            'title' => esc_html__('Kalles Theme', 'kalles'),
            'icon' => 'fa fa-plug', //default icon
        ),
            1 // position
        );

        // Include custom functions of elementor widgets

        include_once KALLES_THEME_EL_PATH . '/widgets/banner.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/banners-carousel.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/portfolio.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/product.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/products.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/promotion.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/blog.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/service.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/heading.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/countdown.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/member.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/bannerCustom.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/testimonialsCarousel.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/products-deal.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/product-featured.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/categories-list.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/instagram-shop.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/newsletter.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/links-list.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/tabs-element.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/product-tabs.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/bannerPackery.php';
        include_once KALLES_THEME_EL_PATH . '/widgets/map.php';

        return;
    }
}

/**
 * Get megamenu post type HTML
 *
 * @param   array  $args  Arguments.
 *
 * @return  void
 */
if (! function_exists('kalles_get_megamenu_html')) {
    function kalles_get_megamenu_html($post_id) {
        if ( !did_action( 'elementor/loaded' ) ) return;
        $post = get_post($post_id);
        if ($post && $post->post_type == 'megamenu'){
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($post_id);
            return $content;
        } else {
            return;
        }
    }
}


if ( ! function_exists( 'kalles_get_all_image_sizes_names' ) ) {
    /**
     * Retrieve available image sizes names
     *
     * @since 1.0.0
     *
     * @param string $style Array output style.
     *
     * @return array
     */
    function kalles_get_all_image_sizes_names() {

        global $_wp_additional_image_sizes;

        $default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );
        $available_sizes        = array();

        foreach ( $default_image_sizes as $size ) {
            $available_sizes[ $size ] = array(
                'width'  => (int) get_option( $size . '_size_w' ),
                'height' => (int) get_option( $size . '_size_h' ),
                'crop'   => (bool) get_option( $size . '_crop' ),
            );
        }

        if ( $_wp_additional_image_sizes ) {
            $available_sizes = array_merge( $available_sizes, $_wp_additional_image_sizes );
        }

        $available_sizes['full'] = array();

        $image_sizes     = array();

        foreach ( $available_sizes as $size => $size_attributes ) {
            $name = ucwords( str_replace( '_', ' ', $size ) );
            if ( is_array( $size_attributes ) && ( isset( $size_attributes['width'] ) || isset( $size_attributes['height'] ) ) ) {
                $name .= ' - ' . $size_attributes['width'] . ' x ' . $size_attributes['height'];
            }

            $image_sizes[ $size ] = $name;
        }
            $image_sizes['custom'] = esc_html__( 'Custom', 'kalles' );


        return $image_sizes;
    }
}

// Register widgets
add_action( 'elementor/widgets/widgets_registered', 'the4_kalles_el_register_widgets' );
if (! function_exists('the4_kalles_el_register_widgets')) {
    function the4_kalles_el_register_widgets()
    {
        if (class_exists('Kalles_Elementor_Portfolio_Widget')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Portfolio_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Blog_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Products_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Product_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Banner_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Banners_Slides());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Promotion_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Service_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Heading_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Countdown_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Member_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Banner_Custom_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Banner_Packery_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Testimonials_Carousel());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Products_Deal_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Product_Featured_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Categories_List_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Instagram_Shop_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Newsletter_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Links_List_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Tabs_Elements());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Product_Tabs_Widget());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Kalles_Elementor_Map_Widget());
        }
    }
}

/**
 * Check is Elementor Installed
 *
 * @return  Boolean
 */
if ( ! function_exists( 'kalles_is_elementor' ))
{
    function kalles_is_elementor() {
        return did_action( 'elementor/loaded' );
    }
}

/**
 * Check is Editor mode
 *
 * @return  Boolean
 */
if ( ! function_exists( 'kalles_elementor_is_editor_mode' ) ) {
    function kalles_elementor_is_editor_mode() {
        if ( ! kalles_is_elementor() ) {
            return false;
        }

        return Plugin::$instance->editor->is_edit_mode();
    }
}

/**
 * Check is Preview mode
 *
 * @return  Boolean
 */
if ( ! function_exists( 'kalles_elementor_is_preview_mode' ) ) {
    function kalles_elementor_is_preview_mode() {
        return Plugin::$instance->preview->is_preview_mode();
    }
}


/**
 * Enqueue stylesheets
 *
 */

if ( ! function_exists( 'the4_kalles_el_enqueue_styles' ) ) {
    function the4_kalles_el_enqueue_styles() {

        wp_enqueue_style( 'font-stroke', THE4_KALLES_URL . '/assets/vendors/font-stroke/css/font-stroke.min.css' );

    }
}

add_action( 'elementor/frontend/after_enqueue_styles', 'the4_kalles_el_enqueue_styles' );

/**
 * Register Elementor editor script
 *
 */
if ( ! function_exists('the4_kalles_el_register_script') ){
    function the4_kalles_el_register_script() {

    }
}
add_action( 'elementor/frontend/after_register_scripts', 'the4_kalles_el_register_script', 11 );

/**
 * Enqueue script
 *
 */
if ( ! function_exists('the4_kalles_el_enqueue_script') ){
    function the4_kalles_el_enqueue_script() {
        wp_enqueue_script( 'lazysite', THE4_KALLES_URL . '/assets/vendors/lazysite/lazysite.min.js', ['elementor-editor'], false, true );
        wp_enqueue_script( 'isotope', THE4_KALLES_URL . '/assets/vendors/isotope/isotope.pkgd.min.js', ['elementor-editor'], false, true );
    }
}
add_action( 'elementor/editor/before_enqueue_scripts', 'the4_kalles_el_enqueue_script' );

/**
 * Get image HTML
 *
 * @since 1.0.0
 *
 * @return  HTML
 */

if ( ! function_exists('kalles_get_image_html') ){
    function kalles_get_image_html( $args, $custom_size ) {
        if ( kalles_is_elementor() ) {
            return Group_Control_Image_Size::get_attachment_image_html( $args, $custom_size );
        } else {
            return wp_get_attachment_image( $args[ $custom_size ]['id'], $args[ $custom_size . '_size' ] );
        }
    }
}


/**
 * Get Link attr
 *
 * @since 1.0.0
 *
 * @return  HTML
 */

if ( ! function_exists('kalles_get_link_el') ){
    function kalles_get_link_el( $link, $class ) {
        $link_attrs = '';

        if ( isset( $link['url'] ) && $link['url'] ) {
            $link_attrs .= ' href="' . esc_url( $link['url'] ) . '"';

            if ( isset( $link[ 'is_external' ] ) && $link[ 'is_external' ] == 'on' ) {
                $link_attrs .= 'target="_blank"';
            }
            if ( isset( $link[ 'nofollow' ] ) && $link[ 'nofollow' ] == 'on' ) {
                $link_attrs .= ' rel="nofollow"';
            }

        }

        if ( $class ) {
            $link_attrs .= ' class="' . $class . '"';
        }
        return $link_attrs;
    }


}


/**
 * Get products by search query
 *
 * @since 1.1.1
 *
 * @return  Array
 */

if ( ! function_exists('kalles_el_get_post_by_query') ){
    function kalles_el_get_post_by_query( ) {

        $response  = array();
        $key       = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
        $post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : 'product';

        $args =  array(
            'post_type'              => $post_type,
            'posts_per_page'         => -1,
            'post_status'            => 'publish',
            's'                      => $key
        );

        $query = new WP_Query( $args );

        if ( ! isset( $query->posts) ) {
            return;
        }

        foreach ($query->posts as $key => $post) {
            $response[] = array(
                'id' => $post->ID,
                'text' => $post->post_title
            );
        }

        wp_send_json($response);
    }
}
add_action( 'wp_ajax_the4_kalles_search_post_by_query', 'kalles_el_get_post_by_query' );
add_action( 'wp_ajax_nopriv_the4_kalles_search_post_by_query', 'kalles_el_get_post_by_query' );

/**
 * Get products by search query
 *
 * @since 1.1.1
 *
 * @return  Array
 */

if ( ! function_exists('kalles_el_get_post_by_id') ){
    function kalles_el_get_post_by_id( ) {

        $response  = array();

        $ids       = isset( $_POST['ids'] ) ? $_POST['ids'] : Array();
        $post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : 'product';

        $args =  array(
            'post_type'   => $post_type,
            'post__in'    => $ids,
            'post_status' => 'publish',
            'orderby'     => 'post__in'
        );

        $query = new WP_Query( $args );

        if ( ! isset( $query->posts) ) {
            return;
        }

        foreach ($query->posts as $post) {
            $response[$post->ID] = get_the_title( $post->ID );
        }

        wp_send_json($response);
    }
}
add_action( 'wp_ajax_the4_kalles_get_data_post_by_id', 'kalles_el_get_post_by_id' );
add_action( 'wp_ajax_nopriv_the4_kalles_get_data_post_by_id', 'kalles_el_get_post_by_id' );


/**
 * Init icon stroke tab
 *
 * @param array $tabs
 * @return array
 */
if (! function_exists('the4_kalles_el_icon_stroke_tab')) {
    function the4_kalles_el_icon_stroke_tab($tabs)
    {
        $stroke_icons = array(
        'pe-7s-album',
        'pe-7s-arc',
        'pe-7s-back-2',
        'pe-7s-bandaid',
        'pe-7s-car',
        'pe-7s-diamond',
        'pe-7s-door-lock',
        'pe-7s-eyedropper',
        'pe-7s-female',
        'pe-7s-gym',
        'pe-7s-hammer',
        'pe-7s-headphones',
        'pe-7s-helm',
        'pe-7s-hourglass',
        'pe-7s-leaf',
        'pe-7s-magic-wand',
        'pe-7s-male',
        'pe-7s-map-2',
        'pe-7s-next-2',
        'pe-7s-paint-bucket',
        'pe-7s-pendrive',
        'pe-7s-photo',
        'pe-7s-piggy',
        'pe-7s-plugin',
        'pe-7s-refresh-2',
        'pe-7s-rocket',
        'pe-7s-settings',
        'pe-7s-shield',
        'pe-7s-smile',
        'pe-7s-usb',
        'pe-7s-vector',
        'pe-7s-wine',
        'pe-7s-cloud-upload',
        'pe-7s-cash',
        'pe-7s-close',
        'pe-7s-bluetooth',
        'pe-7s-cloud-download',
        'pe-7s-way',
        'pe-7s-close-circle',
        'pe-7s-id',
        'pe-7s-angle-up',
        'pe-7s-wristwatch',
        'pe-7s-angle-up-circle',
        'pe-7s-world',
        'pe-7s-angle-right',
        'pe-7s-volume',
        'pe-7s-angle-right-circle',
        'pe-7s-users',
        'pe-7s-angle-left',
        'pe-7s-user-female',
        'pe-7s-angle-left-circle',
        'pe-7s-up-arrow',
        'pe-7s-angle-down',
        'pe-7s-switch',
        'pe-7s-angle-down-circle',
        'pe-7s-scissors',
        'pe-7s-wallet',
        'pe-7s-safe',
        'pe-7s-volume2',
        'pe-7s-volume1',
        'pe-7s-voicemail',
        'pe-7s-video',
        'pe-7s-user',
        'pe-7s-upload',
        'pe-7s-unlock',
        'pe-7s-umbrella',
        'pe-7s-trash',
        'pe-7s-tools',
        'pe-7s-timer',
        'pe-7s-ticket',
        'pe-7s-target',
        'pe-7s-sun',
        'pe-7s-study',
        'pe-7s-stopwatch',
        'pe-7s-star',
        'pe-7s-speaker',
        'pe-7s-signal',
        'pe-7s-shuffle',
        'pe-7s-shopbag',
        'pe-7s-share',
        'pe-7s-server',
        'pe-7s-search',
        'pe-7s-film',
        'pe-7s-science',
        'pe-7s-disk',
        'pe-7s-ribbon',
        'pe-7s-repeat',
        'pe-7s-refresh',
        'pe-7s-add-user',
        'pe-7s-refresh-cloud',
        'pe-7s-paperclip',
        'pe-7s-radio',
        'pe-7s-note2',
        'pe-7s-print',
        'pe-7s-network',
        'pe-7s-prev',
        'pe-7s-mute',
        'pe-7s-power',
        'pe-7s-medal',
        'pe-7s-portfolio',
        'pe-7s-like2',
        'pe-7s-plus',
        'pe-7s-left-arrow',
        'pe-7s-play',
        'pe-7s-key',
        'pe-7s-plane',
        'pe-7s-joy',
        'pe-7s-photo-gallery',
        'pe-7s-pin',
        'pe-7s-phone',
        'pe-7s-plug',
        'pe-7s-pen',
        'pe-7s-right-arrow',
        'pe-7s-paper-plane',
        'pe-7s-delete-user',
        'pe-7s-paint',
        'pe-7s-bottom-arrow',
        'pe-7s-notebook',
        'pe-7s-note',
        'pe-7s-next',
        'pe-7s-news-paper',
        'pe-7s-musiclist',
        'pe-7s-music',
        'pe-7s-mouse',
        'pe-7s-more',
        'pe-7s-moon',
        'pe-7s-monitor',
        'pe-7s-micro',
        'pe-7s-menu',
        'pe-7s-map',
        'pe-7s-map-marker',
        'pe-7s-mail',
        'pe-7s-mail-open',
        'pe-7s-mail-open-file',
        'pe-7s-magnet',
        'pe-7s-loop',
        'pe-7s-look',
        'pe-7s-lock',
        'pe-7s-lintern',
        'pe-7s-link',
        'pe-7s-like',
        'pe-7s-light',
        'pe-7s-less',
        'pe-7s-keypad',
        'pe-7s-junk',
        'pe-7s-info',
        'pe-7s-home',
        'pe-7s-help2',
        'pe-7s-help1',
        'pe-7s-graph3',
        'pe-7s-graph2',
        'pe-7s-graph1',
        'pe-7s-graph',
        'pe-7s-global',
        'pe-7s-gleam',
        'pe-7s-glasses',
        'pe-7s-gift',
        'pe-7s-folder',
        'pe-7s-flag',
        'pe-7s-filter',
        'pe-7s-file',
        'pe-7s-expand1',
        'pe-7s-exapnd2',
        'pe-7s-edit',
        'pe-7s-drop',
        'pe-7s-drawer',
        'pe-7s-download',
        'pe-7s-display2',
        'pe-7s-display1',
        'pe-7s-diskette',
        'pe-7s-date',
        'pe-7s-cup',
        'pe-7s-culture',
        'pe-7s-crop',
        'pe-7s-credit',
        'pe-7s-copy-file',
        'pe-7s-config',
        'pe-7s-compass',
        'pe-7s-comment',
        'pe-7s-coffee',
        'pe-7s-cloud',
        'pe-7s-clock',
        'pe-7s-check',
        'pe-7s-chat',
        'pe-7s-cart',
        'pe-7s-camera',
        'pe-7s-call',
        'pe-7s-calculator',
        'pe-7s-browser',
        'pe-7s-box2',
        'pe-7s-box1',
        'pe-7s-bookmarks',
        'pe-7s-bicycle',
        'pe-7s-bell',
        'pe-7s-battery',
        'pe-7s-ball',
        'pe-7s-back',
        'pe-7s-attention',
        'pe-7s-anchor',
        'pe-7s-albums',
        'pe-7s-alarm',
        'pe-7s-airplay',
    );

        $tabs['stroke'] = [
        'name' => 'stroke',
        'label' => esc_html__('Stroke icons', 'kalles'),
        'url' => get_template_directory_uri().'/assets/vendors/font-stroke/css/font-stroke.min.css',
        'prefix' => '',
        'displayPrefix' => 'stroke',
        'labelIcon' => 'fas fa-edit',
        'ver' => '5.3.2',
        'icons' => $stroke_icons,
    ];

        return $tabs;
    }
}
add_filter( 'elementor/icons_manager/native', 'the4_kalles_el_icon_stroke_tab', 3, 1);