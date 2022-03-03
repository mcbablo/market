<?php
/**
 * Instagram shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_instagram' ) ) {
	function kalles_addons_shortcode_instagram( $atts, $content = null ) {
		$output = $gutter_style = '';

		extract( shortcode_atts( array(
			'user_id'      => '',
			'username'     => '',
			'link'         => '',
			'access_token' => '',
			'limit'        => 12,
			'columns'      => 2,
			'size'         => 'low',
			'gutter'       => '',
			'slider'       => '',
			'items'        => 4,
			'autoplay'     => '',
			'arrows'       => '',
			'dots'         => '',
			'class'        => '',
		), $atts ) );

		$classes = array( 'the4-sc-instagram clearfix ' . $class );
		$attr = array();

		if ( $slider ) {
			if ( ! empty( $items ) ) {
				$attr_slider[] = '"slidesToShow": "' . $items . '"';
			}
			if ( ! empty( $autoplay ) ) {
				$attr_slider[] = '"autoplay": true';
			}
			if ( ! empty( $arrows ) ) {
				$attr_slider[] = '"arrows": true';
			}
			if ( ! empty( $dots ) ) {
				$attr_slider[] = '"dots": true';
			}
			if ( is_rtl() ) {
				$attr_slider[] = '"rtl": true';
			}
			if ( ! empty( $attr_slider ) ) {
				$attr[] = 'data-slick=\'{' . esc_attr( implode( ', ', $attr_slider ) ) . ',"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]' .'}\'';
			}
			$classes[] = 'the4-carousel';
		}

		if ( ! empty( $gutter ) ) {
			$gutter_style  = 'style="padding: ' . ( int ) $gutter / 2 . 'px"';
			$attr[] = 'style="margin: 0 -' . ( int ) $gutter / 2 . 'px"';
		}

		if ( $columns ) {
			$classes[] = 'columns-' . $columns;
		}

		$output .= '<div class="' . implode( ' ', $classes ) . '" ' . implode( ' ', $attr ) . '>';
			 if ( ! empty( $user_id ) && ! empty( $access_token ) ) {
				$api      = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token . '&count=' . esc_attr( $limit );
				$getphoto = wp_remote_get( $api );

				if ( ! is_wp_error( $getphoto ) ) {
					$photos = json_decode( $getphoto['body'] );

					if ( $photos->meta->code !== 200 ) {
						echo '<p>Incorrect user ID specified.</p>';
					}

					$items_as_objects = $photos->data;
					$items = array();
					if (is_array($items_as_objects)) {
						foreach ( $items_as_objects as $item_object ) {
							if ( $size == 'thumbnail' ) {
								$src = $item_object->images->thumbnail->url;
								$w   = $item_object->images->thumbnail->width;
								$h   = $item_object->images->thumbnail->height;
							} elseif ( $size == 'low' ) {
								$src = $item_object->images->low_resolution->url;
								$w   = $item_object->images->low_resolution->width;
								$h   = $item_object->images->low_resolution->height;
							} else {
								$src = $item_object->images->standard_resolution->url;
								$w   = $item_object->images->standard_resolution->width;
								$h   = $item_object->images->standard_resolution->height;
							}

							$items[] = array(
								'link'     => $item_object->link,
								'src'      => $src,
								'comments' => $item_object->comments->count,
								'like'     => $item_object->likes->count
							 );
						}
					}

					if ( isset( $items ) ) {
						foreach ( $items as $item ) {
							$link     = $item['link'];
							$image    = $item['src'];
							$comments = $item['comments'];
							$like     = $item['like'];

							$output .= '<div ' . $gutter_style . ' class="item pr fl">';
								$output .= '<a href="' . esc_url( $link ) .'" target="_blank"><img class="w__100" width="' . esc_attr( $w ) . '" height="' . esc_attr( $h ) . '" src="' . esc_url( $image ) . '" alt="Instagram" /></a>';
								$output .= '<div class="info pa tc flex ts__03 center-xs middle-xs">';
									$output .= '<span class="pr cw mgr10"><i class="fa fa-heart-o mr__5"></i>' . $like . '</span>';
									$output .= '<span class="pr cw"><i class="fa fa-comments-o mr__5"></i>' . $comments . '</span>';
								$output .= '</div>';
							$output .= '</div>';
						}
					}
					if ( ! empty( $username ) && ! $slider ) {
						$output .= '<div class="is-username tc pa cd">';
							$output .= '<div class="f__libre fs__16">' . esc_html__( 'Find us on Instagram', 'kalles-addons' ) . '</div>';
							$output .= '<a class="fs__18 fwsb" href="' . esc_url( $link ) . '" target="_blank">' . esc_attr( $username ) . '</a>';
						$output .= '</div>';
					}
				}
			}
		$output .= '</div>';

		// Return output
		return apply_filters( 'kalles_addons_shortcode_instagram', force_balance_tags( $output ) );
	}
}