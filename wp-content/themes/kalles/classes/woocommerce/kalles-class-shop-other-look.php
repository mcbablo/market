<?php

/**
 * Shop other look
 *
 * @since 1.0
 */

namespace Kalles\Woocommerce;

use The4Helper;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Shop_Other_Look {


    static private $_shop_other_look_ids;

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

        add_action( 'woocommerce_product_options_related', [ __CLASS__, 'display_linked_product_panel'] );

        add_action( 'woocommerce_process_product_meta', [ __CLASS__, 'save_other_look_meta_box' ], 101, 2 );

        add_action( 'woocommerce_single_product_summary', [ __CLASS__, 'display_linked_product_page'], 26 );
    }

    public static function display_linked_product_panel()
    {
        global $post, $thepostid, $product_object;

        $other_look_ids = get_post_meta( $post->ID, 'the4_shop_other_look', true );
        self::$_shop_other_look_ids = explode( ',', $other_look_ids);

        ?>

            <div class="options_group">
                <p class="form-field">
                    <label for="t4_other_shop"><?php esc_html_e( 'Other Shop', 'kalles' ); ?></label>
                    <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="t4_other_shop" name="t4_other_shop[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'kalles' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo esc_attr( intval( $post->ID ) ); ?>">
                        <?php

                        foreach ( self::$_shop_other_look_ids as $product_id ) {
                            $product = wc_get_product( $product_id );
                            if ( is_object( $product ) && $product_id != $post->ID ) {
                                echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . esc_html( wp_strip_all_tags( $product->get_formatted_name() ) ) . '</option>';
                            }
                        }
                        ?>
                    </select> <?php echo wc_help_tip( esc_html__( 'Other shop Inspired by dropship T-shirt stores, it makes it easy to increase conversion rates by including related products', 'kalles' ) ); // WPCS: XSS ok. ?>
                </p>

            </div>

        <?php
    }

    public static function save_other_look_meta_box( $post_id, $post )
    {
        if ( ! isset( $_POST['t4_other_shop']) )
            return;
        $other_look_ids = $_POST[ 't4_other_shop' ];

        $other_look_ids_old = get_post_meta( $post_id, 'the4_shop_other_look', true );
        $other_look_ids_old = explode( ',', $other_look_ids_old);

        if ( is_array( $other_look_ids ) ) {

             //Delete meta data in other shop look before update
            foreach( $other_look_ids_old as $product_id ) {
                if ( $product_id != $post_id && metadata_exists( 'post', $product_id, 'the4_shop_other_look' ) ) {
                    delete_post_meta( $product_id, 'the4_shop_other_look' );
                }
            }
            //Check if current product not in array -> push to array
            if ( ! in_array( $post_id, $other_look_ids ) ) {
                array_push( $other_look_ids, $post_id );
            }

            foreach( $other_look_ids as $product_id ) {

                update_post_meta( $product_id, 'the4_shop_other_look', implode( ',', $other_look_ids ) );
            }
        }
    }

    public static function display_linked_product_page()
    {
        global $post;

        $other_look_ids = get_post_meta( $post->ID, 'the4_shop_other_look', true );

        if ( ! empty( $other_look_ids ) ) :

        $other_look_ids = explode( ',', $other_look_ids);
        ?>
        <div class="pr_choose_style">
            <h4 class="pr_choose_title"><?php esc_html_e( 'Choose Style', 'kalles' ); ?></h4>
            <div class="row fl_nowrap pr_choose_wrap">
            <?php foreach( $other_look_ids as $product_id ) : ?>
                <?php $product = wc_get_product( $product_id ); ?>
                    <?php if ( is_object( $product ) ) : ?>
                        <div class="col-4 col-md-3 pr_choose_item tc <?php if ( $post->ID == $product_id ) echo esc_attr( 't4_chosen' ); ?>">
                            <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="db">
                                <div class="pr_choose_img pr oh <?php echo kalles_image_lazyload_class(); ?>">
                                    <?php The4Helper::ksesHTML( $product->get_image() ); ?>
                                    <?php 
                                        $image_gallery = $product->get_gallery_image_ids();
                                        $hover_image_id = '';
                                        if ( is_array( $image_gallery ) && ! empty( $image_gallery ) ) {
                                            $hover_image_id = $image_gallery[ 1 ];
                                        }
                                     ?>

                                     <?php if ( $hover_image_id ) : ?>
                                        <div class="flip-img-wrapper">
                                            <?php echo the4_woo_get_product_thumbnai( 'woocommerce_thumbnail', $hover_image_id ); ?>
                                        </div>
                                     <?php endif; ?>
                                </div>
                                
                                <div class="pr_choose_info truncate"><?php The4Helper::ksesHTML( $product->get_name() ); ?></div>
                            </a>
                        </div>
                    <?php endif; ?>
            <?php endforeach; ?>
            </div>
        </div>
        <?php

        endif;
    }
    
}