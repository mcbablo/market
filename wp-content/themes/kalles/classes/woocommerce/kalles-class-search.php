<?php

/**
 * Search
 *
 * @since 1.0
 */

namespace Kalles\Woocommerce;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Search {


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
        // add_action( 'create_term', array($this,'the4_edit_product_term'), 99, 3 );
        // add_action( 'edit_term', array($this,'the4_edit_product_term'), 99, 3 );
        // add_action( 'delete_term', array($this,'the4_delete_product_term'), 99, 4 );
        // add_action( 'save_post', array($this,'the4_save_post_action'), 99, 3);

    }
    public function the4_get_taxonomy($taxonomy, $parent = 0, $exclude = 0)
    {
        $taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
        $terms = get_terms( $taxonomy, array( 'parent' => $parent, 'hide_empty' => false, 'exclude' => $exclude) );

        $children = array();
        foreach ( $terms as $term ){
            $term->children = self::the4_get_taxonomy( $taxonomy, $term->term_id, $exclude);
            $children[ $term->term_id ] = $term;
        }
        return $children;
    }
    public function the4_get_categories_option( $taxonomies, $seperate = '') {
        ?>

        <?php foreach ( $taxonomies as $taxonomy ) { ?>
            <?php $children = $taxonomy->children; ?>
            <option value="<?php echo esc_attr( $taxonomy->slug ); ?>" data-id="<?php echo esc_attr( $taxonomy->term_id ); ?>"><?php echo esc_html( $seperate . $taxonomy->name ); ?></option>
            <?php if (is_array($children) && !empty($children)): ?>
                <?php self::the4_get_categories_option( $children, '--' ); ?>
            <?php endif ?>
        <?php } ?>

        <?php
    }
    public function the4_get_product_category() {

        if ( false === ( $categories = get_transient( 'product-categories-hierarchy' ) ) ) {

            $categories = self::the4_get_taxonomy( 'product_cat', 0, 0);

            // do not set an empty transient - should help catch private or empty accounts.
            if ( ! empty( $categories ) ) {
                $categories = serialize( $categories ) ;
                set_transient( 'product-categories-hierarchy', $categories, 6 * 12 * 12 );
            }
        }

        if ( ! empty( $categories ) ) {
            $categories = @unserialize( $categories );
            return $categories;

        } else {

            return new WP_Error( 'no_categories', esc_html__( 'No categories.', 'kalles' ) );

        }
    }

    public function the4_edit_product_term($term_id, $tt_id, $taxonomy) {
        $term = get_term($term_id,$taxonomy);
        if (!is_wp_error($term) && is_object($term)) {
            $taxonomy = $term->taxonomy;
            if ($taxonomy == "product_cat") {
                delete_transient( 'product-categories-hierarchy' );
            }
        }
    }

    public function the4_delete_product_term($term_id, $tt_id, $taxonomy, $deleted_term) {
        if (!is_wp_error($deleted_term) && is_object($deleted_term)) {
            $taxonomy = $deleted_term->taxonomy;
            if ($taxonomy == "product_cat") {
                delete_transient( 'product-categories-hierarchy' );
            }
        }
    }
    public function the4_save_post_action( $post_id ){

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if (!current_user_can( 'edit_page', $post_id ) ) return;

        $post_info = get_post($post_id);

        if (!is_wp_error($post_info) && is_object($post_info)) {
            $content   = $post_info->post_content;
            $post_type = $post_info->post_type;

            if ($post_type == "product"){
                delete_transient( 'the4-kalles-product-categories' );
            }
        }

    }
    

    
}