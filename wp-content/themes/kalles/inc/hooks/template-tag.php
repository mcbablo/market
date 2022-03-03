<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Kalles theme template tag
 *
 * @since   1.0.0
 * @package Kalles
 */

/***********
 *
 *  Thirdty language switcher
 *
 * *********/

if ( ! function_exists( 't4_author_bio_tag' ) ) {
    function t4_author_bio_tag() {
        get_template_part( 'views/post/author-bio' );
        if ( is_author() && get_the_author_meta( 'description' ) ) {

        }
    }
}
