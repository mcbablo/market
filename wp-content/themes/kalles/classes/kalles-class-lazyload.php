<?php


/**
 * Lazyload
 *
 * @since   1.0.0
 * @package Kalles
 */

namespace Kalles;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Lazyload {

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
        if ( $this->lazy_is_active() ) {
            add_filter( 'wp_get_attachment_image_attributes', array( $this, 'the4_lazyload_filter_attributes' ), 100, 3 );
        }
    }

    public function the4_lazyload_filter_attributes( $attr, $attachment, $size  ) {

        if ( isset( $attr['srcset'] ) ) {
            $attr['data-srcset'] = $attr['srcset'];
        } else {
            $attr['data-srcset'] = $attr['src'];
        }
        
        $attr['data-sizes'] = 'auto';
        
        unset( $attr['srcset'] );
        unset( $attr['sizes'] );
        unset( $attr['loading'] );

        $attr['class'] .= ' ' . 'lazyload';

        if ( is_object($attachment) ) {

        }
        if ( !is_single() ) {
            //Fix Safari product slide height error when enable lazyload
            $img_src = wp_get_attachment_image_src($attachment->ID, apply_filters( 'single_product_large_thumbnail_size', 'single-post-thumbnail' ));

            $place_img = 'data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20' . $img_src[1] . '%20' . $img_src[2] . '%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E';
            $attr['src'] = $place_img;
        } else {
            //Fix Safari product slide height error when enable lazyload
            $img_src = wp_get_attachment_image_src($attachment->ID, 'shop_single');
            $place_img = 'data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20' . $img_src[1] . '%20' . $img_src[2] . '%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E';
            $attr['src'] = $place_img;
        }

        return $attr;
    }

    public function lazy_is_active()
    {
        return ( cs_get_option('general_lazyload-enable') && cs_get_option('general_lazyload-type') == 'kalles' ) && ! is_admin() ? true : false;
    }

}