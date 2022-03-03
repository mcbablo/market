<?php
/**
 * Service shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_heading' ) ) {
    function kalles_addons_shortcode_heading( $atts, $content = null ) {
        $output = $icon_color_attr = $title_color_attr = $content_color_attr = $css_animation = $title = $sub_title = $short_desc = $title = $divider = $link_url = $link_target = $link_rel = $style ='';

        extract( shortcode_atts( array(
            'style'            => '',
            'title'             => '',
            'sub_title'         => '',
            'short_desc'        => '',
            'link_url'          => '',
            'link_target'       => '',
            'link_rel'          => '',
            'btn_link'          => '',
            'btn_link_text'     => '',
            'divider'           => '',
            'css_animation'     => '',
            'class'             => '',
        ), $atts ) );

        $classes = array();

        if ( '' !== $css_animation ) {
            wp_enqueue_script( 'waypoints' );
            $classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
        }

        if ( ! empty( $class ) ) {
            $classes[] = $class;
        }

        $classes[] = $divider ? 'divider' : '';

//		$output .= '<div class="wrap_title ' . esc_attr( implode( ' ', $classes ) ) . '">';
//
//        if ( $title ) {
//            $output .= '<h3 class="section-title"><span class="pr flex fl_center al_center "><span>' . esc_html($title) . '</span></span></h3>';
//        }
//        if ( $divider && ($style == 'title_5' || $style == 'title_6' || $style == 'title_7')) {
//            $output .= '<span class="dn tt_divider flex fl_center al_center"><span></span><i class="la icon-la"></i><span></span></span>';
//        }
//        if ( $sub_title ) {
//            $output .= '<span class="section-subtitle db sub-title ">' . esc_html($sub_title) . '</span>';
//        }
//        if ( $short_desc ) {
//            $output .= '<p class="section-desc db short-desc ">' . esc_html($short_desc) . '</p>';
//        }
//
//        if ( ! empty( $btn_link_text ) ) {
//
//            $output .= '<p class="section-link db"><a class="btn-link" href="' . esc_attr( $link_url ) . '"' . ( $link_target ? ' target="' . esc_attr( $link_target ) . '"' : '' ) . ( $link_rel ? ' rel="' . esc_attr( $link_rel ) . '"' : '' ) . ( $btn_link_text ? ' title="' . esc_attr( $btn_link_text ) . '"' : '' ) . '><span>'. sanitize_text_field( $btn_link_text ).'</span></a></p>';
//
//        }
//		$output .= '</div>';
        $output .= '';

        // Return output
        return apply_filters( 'kalles_addons_shortcode_heading', force_balance_tags( $output ) );
    }
}