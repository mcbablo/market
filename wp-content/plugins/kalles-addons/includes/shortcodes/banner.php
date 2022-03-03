<?php
/**
 * Banner shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_banner' ) ) {
	function kalles_addons_shortcode_banner( $atts, $content = null ) {
		$output = $label_text_content = $title = $image = $sub_title =  $short_desc =  $btn_link_text =  $link_target = $link_rel = $button_type = $css_animation = $btn_link_url = $divider = $effect_hover = $banner_layout = $label_text = '';

		extract( shortcode_atts( array(
			'image'         => '',
            'image_id'		=> '',
            'label_text'	=> '',
            'sub_title'		=> '',
            'title'		    => '',
            'short_desc'	=> '',
            'btn_link_text'	=> '',
            'button_type'	=> '',
            'banner_layout'	=> '',
			'btn_link_url'  => '',
            'link_url'		=> '',
            'link_target' 	=> '',
            'link_rel' 		=> '',
            'link_title' 	=> '',
            'divider' 	    => '',
            'effect_hover' 	    => '',
			'css_animation' => '',
			'class'         => '',
		), $atts ) );

		$classes = array( 'the4-banner pr oh' );

		if ( ! empty( $class ) ) {
			$classes[] = $class;
		}

		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible ' . esc_attr( $banner_layout ) . '  wpb_' . $css_animation;
		}
        $classes[] = $divider ? 'divider' : '';

        $classes[] = $effect_hover ? 'effect_hover' : '';


        $has_content = $sub_title || $title || $short_desc || $btn_link_text;
        if($label_text){
            $label_text_content .= '<span class="label-content"><span>' . esc_attr( $label_text ) .'</span></span>';
        }

		$output .= '<div class="' . esc_attr( implode( ' ', $classes ) ).' " >';
			if ( ! empty( $link ) ) {
				$link = kalles_vc_build_link( $link );
				$output .= '<a href="' . esc_attr( $link['url'] ) . '" ' . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' ) . ( $link['rel'] ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '' ) . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' ) . '>';
			} elseif ( ! empty( $link_url ) ) {

			   $output .= '<a href="' . esc_attr( $link_url ) . '"' . ( $link_target ? ' target="' . esc_attr( $link_target ) . '"' : '' ) . ( $link_rel ? ' rel="' . esc_attr( $link_rel ) . '"' : '' ) . ( $link_title ? ' title="' . esc_attr( $link_title ) . '"' : '' ) . '>';

			}

				if ( ! empty( $image ) ) {

					$img_id = preg_replace( '/[^\d]/', '', $image );

                    $output .='<figure class="oh ' . kalles_image_lazyload_class() . '">'. wp_get_attachment_image( $img_id, 'large', '', array( "class" => "w__100", 'alt' => esc_attr( $title ) ) ) .' '. $label_text_content .'<span class="overlay-color"></span></figure>';

				} elseif ( ! empty( $image_id ) ){

                    $output .='<figure class="oh ' . kalles_image_lazyload_class() . '">'. wp_get_attachment_image( $image_id, 'large', '', array( "class" => "w__100", 'alt' => esc_attr( $title ) ) ) .' '. $label_text_content .'<span class="overlay-color"></span></figure>';

				}

			if ( ! empty( $link ) || ! empty( $link_url ) ) {
				$output .= '</a>';
			}
			if ( $has_content ) {
                $output .= '<div class="banner-content">
                                <div class="content-inner">';
                                if ( ! empty( $link_url ) ) {

                                    $output .= '<a class="link-overlay" href="' . esc_attr( $link_url ) . '"' . ( $link_target ? ' target="' . esc_attr( $link_target ) . '"' : '' ) . ( $link_rel ? ' rel="' . esc_attr( $link_rel ) . '"' : '' ) . ( $link_title ? ' title="' . esc_attr( $link_title ) . '"' : '' ) . '></a>';

                                }

                                if ( $sub_title ) {
                                    $output .='<div class="banner-sub-title ls__1 fwm fs__14">'.esc_html( $sub_title ) .'</div>';
                                }
                                if ( $title ) {
                                    $output .='<h4 class="banner-title fs__35" data-hover="'.esc_attr( $title ) .'">'. $title  .'</h4>';
                                }
                                if ( $divider ) {
                                    $output .= '<span class="dn tt_divider flex fl_center al_center"></span>';
                                }
                                if ( $short_desc ) {
                                    $output .='<p class="banner-desc fs__14">'. $short_desc .'</p>';
                                }
                                if ( ! empty( $btn_link_text ) ) {
                                    $output .= '<p class="banner-button-link db mt__10 ' . esc_attr( $button_type ) . '"><a class="btn-link" href="' . esc_attr( $btn_link_url ) . '"' . ( $link_target ? ' target="' . esc_attr( $link_target ) . '"' : '' ) . ( $link_rel ? ' rel="' . esc_attr( $link_rel ) . '"' : '' ) . ( $btn_link_text ? ' title="' . esc_attr( $btn_link_text ) . '"' : '' ) . '><span>'. sanitize_text_field( $btn_link_text ).'</span></a></p>';
                                }
                $output .=      '</div>';
                $output .=  '</div>';
			}
		$output .= '</div>';

		// Return output
		return apply_filters( 'kalles_addons_shortcode_banner', force_balance_tags( $output ) );
	}
}