<?php

/**
 * Quickview Product
 *
 * @since 1.0
 */

namespace Kalles\Woocommerce;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Quickview {


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
        add_action( 'wc_ajax_product_quick_view', array( $this, 'the4_kalles_wc_quickview' ) );
        
    }

    /**
     * Customize product quick view.
     *
     * @since  1.0
     */
    function the4_kalles_wc_quickview() {
        // Get product from request.

        if ( isset( $_POST['product'] ) && (int) $_POST['product'] ) {
            global $post;

            $id      = ( int ) $_POST['product'];
            $post    = get_post( $id );

            if ( $post ) {
                wc_setup_product_data( $post );

                ob_start();
                wc_get_template( 'content-quickview-product.php', array(
                    'post' => $post,
                ) );
                wp_reset_postdata();

                wc_setup_product_data( $GLOBALS['post'] );

                $output = ob_get_clean();

                wp_send_json_success( $output );

            }
        } else {
            wp_send_json_error( esc_html__( 'No product.', 'kalles' ) );
            exit;
        }

        exit;
    }
    

    
}