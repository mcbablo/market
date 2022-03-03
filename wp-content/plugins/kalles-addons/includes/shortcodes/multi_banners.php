<?php
/**
 * Multi Banner shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_multi_banners' ) ) {
    function kalles_addons_shortcode_multi_banners( $atts, $content = null ) {
        $output = $title = $image = $image_id = $sub_title = $btn_link_text = $has_content = $css_animation = $link_target = $layout = $link_rel = '';

        extract( shortcode_atts( array(
            'layout'        => '',
            'image'         => '',
            'image_id'		=> '',
            'sub_title'		=> '',
            'title'		    => '',
            'btn_link_text'	=> '',
            'button_type'	=> '',
            'link'          => '',
            'link_url'		=> '',
            'link_target' 	=> '',
            'link_rel' 		=> '',
            'link_title' 	=> '',
            'css_animation' => '',
            'class'         => '',
        ), $atts ) );

        $classes = array( 'the4-multi-banners pr oh' );

        if ( ! empty( $class ) ) {
            $classes[] = $class;
        }

        if ( '' !== $css_animation ) {
            wp_enqueue_script( 'waypoints' );
            $classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
        }

        $output .= '';

        // Return output
        return apply_filters( 'kalles_addons_shortcode_multi_banners', force_balance_tags( $output ) );
    }
}