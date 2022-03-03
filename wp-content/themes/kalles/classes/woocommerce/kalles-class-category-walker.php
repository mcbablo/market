<?php

/**
 * Custom Sub categories list
 *
 * @since   1.1.2
 * @package Kalles
 * 
 */

namespace Kalles\Woocommerce;

use Walker_Category;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Category_Walker extends Walker_Category {


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
     * Starts the list before the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children kalles-subcategories'>\n";
    }
    
    /**
     * Ends the list of after the elements are added.
     *
     * @since 2.1.0
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Used to append additional content. Passed by reference.
     * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
     * @param array  $args   Optional. An array of arguments. Will only append content if style argument
     *                       value is 'list'. See wp_list_categories(). Default empty array.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }

        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     * @since 5.9.0 Renamed `$category` to `$data_object` and `$id` to `$current_object_id`
     *              to match parent class for PHP 8 named parameter support.
     *
     * @see Walker::start_el()
     *
     * @param string  $output            Used to append additional content (passed by reference).
     * @param WP_Term $data_object       Category data object.
     * @param int     $depth             Optional. Depth of category in reference to parents. Default 0.
     * @param array   $args              Optional. An array of arguments. See wp_list_categories().
     *                                   Default empty array.
     * @param int     $current_object_id Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        // Restores the more descriptive, specific name for use within this method.
        $category = $data_object;

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );

        // Don't generate an element if the category name is empty.
        if ( '' === $cat_name ) {
            return;
        }

        
        $link = '<a class="category-nav-link" href="' . esc_url( get_term_link( $category ) ) . '" ';

        $link .= '>';

        $image = '';

        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true ); 

        // get the image URL
        if ( $thumbnail_id ) {

            $image_url = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' ); 
            
            $max_width = cs_get_option('wc-subcustom_image_size') ? cs_get_option('wc-subcustom_image_size') : 180;

            if ( ! empty( $image_url[0]) ) {
                $image = '<img src="' . esc_url( $image_url[0] ) . '" alt="' . esc_attr( $category->cat_name ) . '" class="kalles-nav-img" style="max-width: ' . $max_width .'px" />';
            }
            
        }


        $link .= $image;

        $link .= '<span class="nav-link-summary category-summary">';
        $link .= '<span class="nav-link-text category-name">' . $cat_name . '</span>';

        if ( ! empty( $args['show_count'] ) ) {
            $link .= '<span class="nav-link-count">' . number_format_i18n( $category->count ) . ' ' . _n( 'product', 'products', $category->count, 'kalles' ) . '</span>';
        }

        $link .= '</span>';
        $link .= '</a>';

        if ( 'list' === $args['style'] ) {
            $output     .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );

            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms(
                    array(
                        'taxonomy'   => $category->taxonomy,
                        'include'    => $args['current_category'],
                        'hide_empty' => false,
                    )
                );

                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                        $link          = str_replace( '<a', '<a aria-current="page"', $link );
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] = 'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }

            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param string[] $css_classes An array of CSS classes to be applied to each list item.
             * @param WP_Term  $category    Category data object.
             * @param int      $depth       Depth of page, used for padding.
             * @param array    $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
            $css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';

            $output .= $css_classes;
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
    
}