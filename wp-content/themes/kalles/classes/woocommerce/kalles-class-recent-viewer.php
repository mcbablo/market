<?php

/**
 * Recent Viewer Product
 *
 * @since 1.0
 */

namespace Kalles\Woocommerce;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Recent_Viewer {


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

    public function __construct()
    {


        if ( ! is_admin() ) {
            add_action( 'wp', [ $this, 'createViewerList'] );
        }


        //Recent viewer
        if ( cs_get_option('wc_product_viewer-enable') ) {

            add_action('woocommerce_after_single_product_summary', array( $this, 'viewProductViewer' ), 30 );
        }
   
    }


    /**
     * Create Viewer List
     *
     * @return void
     */

    public function createViewerList()
    {

        if ( cs_get_option('wc_product_viewer-customer') && is_user_logged_in()) {
            if (is_product()) {
                $product_id = get_the_ID();
                $currentUser = get_current_user_id();

                $viewer_user_option_id = 'kalles_product_viewer_u_' . $currentUser;
                $viewer_user_option = get_option($viewer_user_option_id);
                if ($viewer_user_option) {
                    if (in_array($product_id, $viewer_user_option)) {
                        //Check current id position.
                        if ($product_id != $viewer_user_option[0]) {
                            $key = array_search($product_id, $viewer_user_option);
                            if ($key != false) {
                                unset($viewer_user_option[$key]);
                            }
                            $viewer_user_option = array_values($viewer_user_option);
                            array_unshift($viewer_user_option, $product_id);
                            update_option($viewer_user_option_id, $viewer_user_option, false);
                        }
                    } else {
                        array_unshift($viewer_user_option, $product_id);
                        update_option($viewer_user_option_id, $viewer_user_option, false);
                    }
                } else {
                    $data = array();
                    $data[] = $product_id;
                    add_option($viewer_user_option_id, $data, '', false);
                }
            }
        } else {
            if ( is_product() ) {
                $product_id = get_the_ID();
                $cookie_key = 'kalles_product_viewer';
                $cookie_time = cs_get_option('wc_product_viewer-cookie_time') ? cs_get_option('wc_product_viewer-cookie_time') : 30;
                $cookie_day = $cookie_time * 84600;

                if (! isset( $_COOKIE['kalles_product_viewer'] ) ) {

                    $viewer_list = array($product_id);
                    $viewer_list = serialize($viewer_list);
                    setcookie('kalles_product_viewer', $viewer_list, time() + $cookie_day, '/', COOKIE_DOMAIN);
                    $_COOKIE['kalles_product_viewer'] = $viewer_list;
                } else {

                    $viewer_list = $_COOKIE['kalles_product_viewer'];
                    $viewer_list = stripcslashes($viewer_list);
                    $viewer_list = unserialize($viewer_list);

                    if (in_array($product_id, $viewer_list)) {
                        if ($product_id != $viewer_list[0]) {
                            $key = array_search($product_id, $viewer_list);
                            if ($key != false) {
                                unset($viewer_list[$key]);
                            }
                            $viewer_list = array_values($viewer_list);
                            array_unshift($viewer_list, $product_id);
                            $viewer_list = serialize($viewer_list);
                            setcookie('kalles_product_viewer', $viewer_list, time() + $cookie_day, '/', COOKIE_DOMAIN);
                            $_COOKIE['kalles_product_viewer'] = $viewer_list;
                        }
                    } else {
                        array_unshift($viewer_list, $product_id);
                        $viewer_list = serialize($viewer_list);
                        setcookie('kalles_product_viewer', $viewer_list, time() + $cookie_day, '/', COOKIE_DOMAIN);
                        $_COOKIE['kalles_product_viewer'] = $viewer_list;
                    }
                }
            }
        }

    }

    /**
     * Get list Viewer product
     *
     * @return product list
     */
    public function getListProductViewer($no_of_products = 0, $product_id = null)
    {
        $count = 0;

        if (is_product()) {

            if ($no_of_products == 0) {
                $product_id = array_shift($product_id);
            } else {
                $product_id = array_slice($product_id, 1, $no_of_products);
            }

            $max_products = count($product_id);

            if ($max_products < 1) return;


            $query = new \WP_Query(
                array(
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'posts_per_page' => '-1',
                    'post__in'       => $product_id,
                    'orderby'        => 'post__in'
                )
            );
            $total = $query->found_posts();

            $title = cs_get_option('wc_product_viewer-title') ? cs_get_option('wc_product_viewer-title') : 'Recent Viewer';
            $subtitle = cs_get_option('wc_product_viewer-subtext');
            $title_type = cs_get_option('wc_product_viewer-title_design');
            $title_icon = cs_get_option('wc_product_viewer-style7_icon') ? cs_get_option('wc_product_viewer-style7_icon') : 'gem';
            $slidesToShow = cs_get_option('wc_product_viewer-product_no_slider') ? cs_get_option('wc_product_viewer-product_no_slider') : 4;

            if($query->have_posts()) {
            ?>
                <div class="recent-viewer product-extra mt__30">
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
                while ($query->have_posts() && $count < $max_products) {
                    $query->the_post();
                    wc_get_template_part('content', 'product');

                    $count++;
                }
                ?>
                    </div>
                </div>
            <?php
            }
            wp_reset_postdata();
        }
    }

    /**
     * Get list Viewer product by Cookie
     *
     * @return product list
     */
    public function getListProductViewerByCookie($no_of_products = 0)
    {

        if ( ! isset($_COOKIE['kalles_product_viewer']) ) return;

        $product_id = unserialize($_COOKIE['kalles_product_viewer']);


        $this->getListProductViewer($no_of_products, $product_id);
    }

    /**
     * Get list Viewer product by Cookie
     *
     * @return product list
     */
    public function getListProductViewerByCustomer($no_of_products = 0)
    {
        $currentUser = get_current_user_id();

         $viewer_user_option_id = 'kalles_product_viewer_u_' . $currentUser;
         $product_id = get_option($viewer_user_option_id);

         if (!empty($product_id)) {
            $this->getListProductViewer($no_of_products, $product_id);
         }
    }

    /**
     * View Product Viewer
     *
     * @return voide
     */
    public function viewProductViewer()
    {

        $no_of_products = cs_get_option('wc_product_viewer-product_no') ? cs_get_option('wc_product_viewer-product_no') : 8;
        if (is_user_logged_in() && cs_get_option('wc_product_viewer-customer') ) {

            $this->getListProductViewerByCustomer($no_of_products);
        } else {
            $this->getListProductViewerByCookie($no_of_products);
        }
    }
}