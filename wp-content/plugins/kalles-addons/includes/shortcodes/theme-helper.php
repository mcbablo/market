<?php
/**
 * Theme helper shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/**
 * Print HTML for social list.
 *
 * @return  void
 */
if ( ! function_exists( 'the4_kalles_social' ) ) {
    function the4_kalles_social() {
        $output = '';

        $socials = cs_get_option( 'social-network' );
        if ( empty( $socials ) ) return;

        $i = 1;
        $output .= '<div class="the4-social">';
        foreach ( $socials as $social) {
            $output .= '<a class="dib br__50 tc social-' . $i .'" href="' . esc_url( $social['link'] ) . '" target="_blank"><i class="' . esc_attr( $social['icon'] ) . '"></i></a>';
            $output .= '<style type="text/css">
                        .social-' . $i .':hover i{ color : ' . $social['color'] .';}
                    </style>';
            $i++;
        }

        $output .= '</div>';

        return apply_filters( 'the4_kalles_social', $output );
    }
    add_shortcode( 'kalles_social_buttons', 'the4_kalles_social' );
}