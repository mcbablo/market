<?php


/**
 * Enqueue style && script
 *
 * @since   1.0.0
 * @package Kalles
 */

namespace Kalles;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

class Enqueue {

    protected $styles = array();
    protected $scripts = array();
    protected $minfile = '';

    /**
     * Instance
     *
     * @var $instance
     */
    private static $instance = null;

    /**
     * Initiator
     *
     * @since 1.1.2
     * @return object
     */


    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     *
     * Constructor - Sets up the object properties.
     * @since 1.1.2
     * @return object
     *
    */

    public function __construct()
    {
        $this->minfile = '.min';

        $this->set_style();
        $this->set_script();

        add_action( 'wp_enqueue_scripts', array( $this, 'register_style') );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style') );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script'), 10000 );

        add_action( 'wp_print_styles'   , array( $this, 'dequeue_style') );

        if ( did_action( 'elementor/loaded' ) ) {
            add_action( 'elementor/frontend/after_register_scripts', [ $this, 'elementor_script' ] );
            add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'el_font_awesome' ), 99 );
        }
    }

    public function set_style()
    {
        $version = $this->get_theme_version();

        $this->styles = array (
            array(
                'handle' => 'the4-kalles-style-theme',
                'src'    => THE4_KALLES_URL . '/assets/css/style' . $this->minfile . '.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),
            array(
                'handle' => 'the4-kalles-thankyou',
                'src'    => THE4_KALLES_URL . '/assets/css/page/thankyou' . $this->minfile . '.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'thankyou'
            ),
            array(
                'handle' => 'the4-kalles-product-list',
                'src'    => THE4_KALLES_URL . '/assets/css/page/product-list' . $this->minfile . '.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),
            array(
                'handle' => 'the4-kalles-rtl',
                'src'    => THE4_KALLES_URL . '/assets/css/rtl' . $this->minfile . '.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'rtl'
            ),
            array(
                'handle' => 'font-stroke',
                'src'    => THE4_KALLES_URL . '/assets/vendors/font-stroke/css/font-stroke.min.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),
            array(
                'handle' => 'the4-kalles-style',
                'src'    => get_stylesheet_uri(),
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),
            array(
                'handle' => 'the4-kalles-animated',
                'src'    => THE4_KALLES_URL . '/assets/css/animate.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),
            array(
                'handle' => 'the4-kalles-flag-style',
                'src'    => THE4_KALLES_URL . '/assets/css/flag.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),

            array(
                'handle' => 'slick',
                'src'    => THE4_KALLES_URL . '/assets/vendors/slick/slick.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'global'
            ),
            array(
                'handle' => 'photoswipe-css',
                'src'    => THE4_KALLES_URL . '/assets/vendors/photoswipe/photoswipe.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all',
                'scope'  => 'product'
            ),
        );
    }

    public function set_script()
    {
        $version = $this->get_theme_version();

        $this->scripts = array (
            array(
                'handle' => 'slick',
                'src'    => THE4_KALLES_URL . '/assets/vendors/slick/slick.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'magnific-popup',
                'src'    => THE4_KALLES_URL . '/assets/vendors/magnific-popup/jquery.magnific-popup.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'lazysite',
                'src'    => THE4_KALLES_URL . '/assets/vendors/lazysite/lazysite.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'hover-intent',
                'src'    => THE4_KALLES_URL . '/assets/vendors/hover-intent/hover-intent.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'moment',
                'src'    => THE4_KALLES_URL . '/assets/vendors/moment/moment.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'isotope',
                'src'    => THE4_KALLES_URL . '/assets/vendors/isotope/isotope.pkgd.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'scrollreveal',
                'src'    => THE4_KALLES_URL . '/assets/vendors/scrollreveal/scrollreveal.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'pjax',
                'src'    => THE4_KALLES_URL . '/assets/vendors/pjax/jquery.pjax.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'pjax'
            ),
            array(
                'handle' => 'countdown',
                'src'    => THE4_KALLES_URL . '/assets/vendors/jquery-countdown/jquery.countdown.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'sticky-kit',
                'src'    => THE4_KALLES_URL . '/assets/vendors/jquery-sticky-kit/sticky-kit.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'product'
            ),
            array(
                'handle' => 'kalles-photoswipe',
                'src'    => THE4_KALLES_URL . '/assets/vendors/photoswipe/photoswipe.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'product'
            ),
            array(
                'handle' => 'kalles-threesixty',
                'src'    => THE4_KALLES_URL . '/assets/vendors/threesixty/threesixty.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'product'
            ),
            array(
                'handle' => 'elevatezoom',
                'src'    => THE4_KALLES_URL . '/assets/vendors/elevatezoom/jquery.ez-plus.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'elevatezoom'
            ),
            array(
                'handle' => 't4-fastdom',
                'src'    => THE4_KALLES_URL . '/assets/vendors/fastdom/fastdom.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 't4-fastdom'
            ),
            array(
                'handle' => 'the4-kalles-script',
                'src'    => THE4_KALLES_URL . '/assets/js/theme' . $this->minfile . '.js',
                'deps'   => array( 'jquery', 'imagesloaded' ),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'global'
            ),
            array(
                'handle' => 'the4-kalles-script-product',
                'src'    => THE4_KALLES_URL . '/assets/js/products/product' . $this->minfile . '.js',
                'deps'   => array( 'the4-kalles-script' ),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'product'
            ),
            array(
                'handle' => 'the4-kalles-script-categories',
                'src'    => THE4_KALLES_URL . '/assets/js/categories/categories' . $this->minfile . '.js',
                'deps'   => array( 'the4-kalles-script' ),
                'ver'    => $version,
                'bottom'  => true,
                'scope'  => 'categories'
            ),
        );
    }
    public function register_style() {

        foreach ( $this->styles as $style ) {
            wp_register_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
        }

        foreach ( $this->scripts as $script ) {
            wp_register_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['bottom'] );
        }

    }

    public function enqueue_style() {

        // Google font
        if ( cs_get_option( 'enable-google-font' ) ){
            wp_enqueue_style( 'kalles-font-google', kalles_google_font_url() );
        }

        //Global css
        foreach ( $this->styles as $style ) {
            if ( $style['scope'] === 'global' ) {
                wp_enqueue_style( $style['handle']);
            }
        }

        //RTL
        if ( is_rtl() ) {
            wp_enqueue_style('the4-kalles-rtl');
        }


        if ( kalles_is_woocommerce() ) {

            //Thankyou page css
            if ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ) {
                wp_enqueue_style('the4-kalles-thankyou');
            }

            //Product page
            if ( function_exists( 'is_product' ) && is_product() ) {
                wp_enqueue_style('photoswipe-css');
            }
        }


        // Inline stylesheet
        wp_add_inline_style( 'the4-kalles-style', the4_kalles_custom_css() );
    }


    public function enqueue_script() {

        //Global Script
        foreach ( $this->scripts as $script ) {
            if ( $script['scope'] === 'global' ) {
                wp_enqueue_script( $script['handle']);
            }
        }

        if ( kalles_is_woocommerce() ) {
            //Product page
            if ( function_exists( 'is_product' ) && is_product() ) {
                foreach ( $this->scripts as $script ) {
                    if ( $script['scope'] === 'product' ) {
                        wp_enqueue_script( $script['handle']);
                    }
                }

                if (  cs_get_option( 'wc-single-zoom' ) && !wp_is_mobile() ) {
                    wp_enqueue_script('elevatezoom');
                }
                wp_enqueue_script('the4-kalles-script-product');
                wp_enqueue_script( 'wc-add-to-cart-variation' );
                wp_enqueue_script( 'jquery-ui-autocomplete' );
            }

            //Categories page
            if ( ( is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop() )) {

                wp_enqueue_script('the4-kalles-script-categories');

                //pajax
                if ( cs_get_option('wc-filter_ajax') ) {
                    wp_enqueue_script('pjax');
                }

                if ( cs_get_option( 'wc_product_swatches-list_limit' ) && cs_get_option( 'wc_product_swatches-list' ) ) {
                    wp_enqueue_script( 't4-fastdom');
                }
            }
        }

        //Addthis script

        if ( 'addthis' == cs_get_option( 'wc-social-share-type' )  && is_single() ) {

            $addthis_id = cs_get_option( 'wc-social-share-addthis_id' ) ? cs_get_option( 'wc-social-share-addthis_id' ) : 'ra-56efaa05a768bd19';
            wp_enqueue_script( 'kalles-addthis', 'https://s7.addthis.com/js/300/addthis_widget.js#pubid=' . $addthis_id, '', '', true );
        }

        //Google capcha
        if ( cs_get_option('woocommerce_account-ajax')
             && cs_get_option('woocommerce_account-google_key')
             && cs_get_option('woocommerce_account-google_capcha') ) {
            wp_enqueue_script( 'google-reCaptcha', 'https://www.google.com/recaptcha/api.js' );
        }

        // Inline script
        wp_add_inline_script( 'the4-kalles-script', the4_kalles_custom_js() );

        // Custom localize script
        wp_localize_script( 'the4-kalles-script', 'THE4_Data_Js', the4_kalles_custom_data_js() );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        do_action( 'kalles_scripts');
    }

    public function elementor_script()
    {
        $version = $this->get_theme_version();

        $scripts = array(
            array(
                'handle' => 'mapbox',
                'src'    => THE4_KALLES_URL . '/assets/vendors/mapbox/mapbox.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
            ),
            array(
                'handle' => 'mapbox-gl',
                'src'    => THE4_KALLES_URL . '/assets/vendors/mapbox/mapbox-gl.min.js',
                'deps'   => array(),
                'ver'    => $version,
                'bottom'  => true,
            ),
            array(
                'handle' => 'kalles-elementor',
                'src'    =>  THE4_KALLES_URL . '/assets/js/elementor.js',
                'deps'   => array( 'jquery', 'elementor-frontend' ),
                'ver'    => $version,
                'bottom'  => true,
            ),
        );

        $styles = array (
            array(
                'handle' => 'mapbox',
                'src'    => THE4_KALLES_URL . '/assets/vendors/mapbox/mapbox.css',
                'deps'   => array(),
                'ver'    => $version,
                'media'  => 'all'
            ),
        );

        foreach ( $scripts as $script ) {
            wp_register_script( $script['handle'], $script['src'], $script['deps'], $script['ver'], $script['bottom'] );
        }
        foreach ( $styles as $style ) {
            wp_register_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
        }
    }

    public function dequeue_style() {
        wp_dequeue_style( 'yith-wcwl-font-awesome' );
        wp_deregister_style( 'yith-wcwl-font-awesome' );

       if ( class_exists( 'WeDevs_Dokan' ) )  {
           wp_deregister_style( 'dokan-fontawesome' );
           wp_dequeue_style( 'dokan-fontawesome' );

           wp_enqueue_style( 'vc_font_awesome_5' );
           wp_enqueue_style( 'vc_font_awesome_5_shims' );
       }

        wp_dequeue_script( 'flexslider' );
        wp_dequeue_script( 'photoswipe-ui-default' );
        wp_dequeue_script( 'prettyPhoto-init' );
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_style( 'photoswipe-default-skin' );
    }

    public function el_font_awesome() {
        global $wp_styles;

        if ( ! in_array( 'font-awesome-5-all', $wp_styles->queue ) ) {
            wp_enqueue_style( 'font-awesome-5-all', ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css' ,[],ELEMENTOR_VERSION );
        }
    }

    public function get_theme_version() {
        $theme_info = wp_get_theme();

        if ( is_object( $theme_info->parent() ) && is_child_theme() ) {
            $theme_info = wp_get_theme( $theme_info->parent()->template );
        }

        return $theme_info->get( 'Version' );
    }



}