<?php
/**
 * Promotion shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_promotion' ) ) {
	function kalles_addons_shortcode_promotion( $atts, $content = null ) {
		$output = $image = '';

		extract( shortcode_atts( array(
			'image'                  => '',
            'image_id' => '',
			'link'                   => '',
            'link_url' => '',
            'link_target' => '',
            'link_rel' => '',
            'link_title' => '',
			'css_animation'          => '',
			'class'                  => '',
			'v_align'                => 'top',
			'h_align'                => 'left',
			'text_1'                 => '',
			'text_1_font_size'       => '',
			'text_1_line_height'     => '',
			'text_1_color'           => '',
			'text_1_margin'          => '',
			'text_2'                 => '',
			'text_2_font_size'       => '',
			'text_2_line_height'     => '',
			'text_2_color'           => '',
			'text_2_margin'          => '',
			'text_3'                 => '',
			'text_3_font_size'       => '',
			'text_3_line_height'     => '',
			'text_3_color'           => '',
			'text_3_button'          => '',
		), $atts ) );

		$classes = array( 'the4-promotion oh pr' );
		$text_1_style = $text_2_style = $text_3_style = array();

		if ( ! empty( $class ) ) {
			$classes[] = $class;
		}

		if ( $v_align ) {
			$classes[] = $v_align;
		}

		if ( $h_align ) {
			$classes[] = $h_align;
		}

		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
		}

		if ( ! empty( $text_1_font_size ) ) {
			$text_1_style[] = 'font-size:' . esc_attr( $text_1_font_size ) . 'px;';
		}
		if ( ! empty( $text_1_line_height ) ) {
			$text_1_style[] = 'line-height:' . esc_attr( $text_1_line_height ) . ';';
		}
		if ( ! empty( $text_1_color ) ) {
			$text_1_style[] = 'color:' . esc_attr( $text_1_color ) . ';';
		}
		if ( ! empty( $text_1_margin ) ) {
			$text_1_style[] = 'margin-bottom:' . esc_attr( $text_1_margin ) . 'px;';
		}

		if ( ! empty( $text_2_font_size ) ) {
			$text_2_style[] = 'font-size:' . esc_attr( $text_2_font_size ) . 'px;';
		}
		if ( ! empty( $text_2_line_height ) ) {
			$text_2_style[] = 'line-height:' . esc_attr( $text_2_line_height ) . ';';
		}
		if ( ! empty( $text_2_color ) ) {
			$text_2_style[] = 'color:' . esc_attr( $text_2_color ) . ';';
		}
		if ( ! empty( $text_2_margin ) ) {
			$text_2_style[] = 'margin-bottom:' . esc_attr( $text_2_margin ) . 'px;';
		}

		if ( ! empty( $text_3_font_size ) ) {
			$text_3_style[] = 'font-size:' . esc_attr( $text_3_font_size ) . 'px;';
		}
		if ( ! empty( $text_3_line_height ) ) {
			$text_3_style[] = 'line-height:' . esc_attr( $text_3_line_height ) . ';';
		}
		if ( ! empty( $text_3_color ) ) {
			$text_3_style[] = 'color:' . esc_attr( $text_3_color ) . ';';
		}

		$output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			if ( ! empty( $link ) ) {
				$links = kalles_vc_build_link( $link );
				$output .= '<a href="' . esc_attr( $links['url'] ) . '"' . ( $links['target'] ? ' target="' . esc_attr( $links['target'] ) . '"' : '' ) . ( $links['rel'] ? ' rel="' . esc_attr( $links['rel'] ) . '"' : '' ) . ( $links['title'] ? ' title="' . esc_attr( $links['title'] ) . '"' : '' ) . '>';
			} elseif ( ! empty( $link_url ) ) {

                $output .= '<a href="' . esc_attr( $link_url ) . '"' . ( $link_target ? ' target="' . esc_attr( $link_target ) . '"' : '' ) . ( $link_rel ? ' rel="' . esc_attr( $link_rel ) . '"' : '' ) . ( $link_title ? ' title="' . esc_attr( $link_title ) . '"' : '' ) . '>';

            }

				if ( ! empty( $image ) ) {
					$img_id = preg_replace( '/[^\d]/', '', $image );

					/*
					$image  = wpb_getImageBySize( array( 'attach_id' => $img_id ) );

					$output .= '<img class="w__100 ts__05" src="' . esc_url( $image['p_img_large'][0] ) . '" width="' . esc_attr( $image['p_img_large'][1] ) . '" height="' . esc_attr( $image['p_img_large'][2] ) . '" alt="' . esc_attr( $text_1 ) . '" />';
					*/
                    $output .= wp_get_attachment_image( $img_id, 'large', '', array( "class" => "w__100 ts__05", 'alt' => esc_attr( $text_1 ) ) );

				} elseif ( ! empty( $image_id ) ){

                    $output .= wp_get_attachment_image( $image_id, 'large', '', array( "class" => "w__100 ts__05", 'alt' => esc_attr( $text_1 ) ) );

                }

			if ( ! empty( $link ) || ! empty( $link_url ) ) {
				$output .= '</a>';
			}

			$output .= '<div class="pa">';
				if ( $text_1 ) {
					$output .= '<h3 class="fwm fs__24 mg__0 mb__10 ls__1 lh__1" style="' . esc_attr( implode( ' ', $text_1_style ) ) . '">' . esc_html( $text_1 ) . '</h3>';
				}
				if ( $text_2 ) {
					$output .= '<h4 class="mg__0 mb__10" style="' . esc_attr( implode( ' ', $text_2_style ) ) . '">' . esc_html( $text_2 ) . '</h4>';
				}
				if ( $text_3_button ) {

					$output .= '<h5 class="mg__0">';
						$output .= '<a href="#" class="button" style="' . esc_attr( implode( ' ', $text_3_style ) ) . '">';
							$output .= esc_html( $text_3 );
						$output .= '</a>';
					$output .= '</h5>';

				} else {
					if ( $text_3 ) {
						$output .= '<h5 class="mg__0" style="' . esc_attr( implode( ' ', $text_3_style ) ) . '">' . esc_html( $text_3 ) . '</h5>';
					}
				}
			$output .= '</div>';
		$output .= '</div>';

		// Return output
		return apply_filters( 'kalles_addons_shortcode_promotion', force_balance_tags( $output ) );
	}
}