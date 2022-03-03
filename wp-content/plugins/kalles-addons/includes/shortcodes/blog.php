<?php
/**
 * Blog shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_blog' ) ) {
	function kalles_addons_shortcode_blog( $atts, $content = null ) {
		$output = '';

		extract( shortcode_atts( array(
			'id'            => '',
			'cat'            => '',
			'style'         => 'outside',
			'layout_content' => 'layout_dark',
			'thumb_size'    => '',
			'columns'       => 4,
			'limit'         => 3,
			'slider'        => '',
			'autoplay'      => '',
			'arrows'        => '',
			'dots'          => '',
			'css_animation' => '',
			'class'         => '',
		), $atts ) );

		$classes = array( 'the4-sc-blog ' . $class );

		$row = 'row';

		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation .' '. $layout_content .' '. $style;
		}

		$args = array(
			'post_type'              => 'post',
			'posts_per_page'         => $limit,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'cache_results'          => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => true,
		);

		if ( $id !== '' )
			$args['post__in'] = explode( ',', $id );

		if ( $cat != '' ) {
			$tax_query = array(
				array (
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $cat
				)
			);

			$args['tax_query'] = $tax_query;
		}
		$query = new WP_Query( $args );

		$attr = array();

		if ( $slider ) {
			if ( $columns == '6' ) {
				$attr_slider[] = '"slidesToShow": 2';
			} elseif ( $columns == '4' ) {
				$attr_slider[] = '"slidesToShow": 3';
			} else {
				$attr_slider[] = '"slidesToShow": 4';
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
			if ( ! empty( $attr_slider ) ) {
				$attr[] = 'data-slick=\'{' . esc_attr( implode( ', ', $attr_slider ) ) . ',"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 991,"settings":{"slidesToShow": 2}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]'. ( is_rtl() ? ',"rtl":true' : '' ) .'}\'';
			}
			$row = 'the4-carousel';
			$columns = 12;
		}

		if ( ! empty( $thumb_size ) ) {
			if ( preg_match_all( '/(\d+)x(\d+)/', $thumb_size, $sizes ) ) {
				$exact_size = array(
					'width'  => isset( $sizes[1][0] ) ? $sizes[1][0] : '0',
					'height' => isset( $sizes[2][0] ) ? $sizes[2][0] : '0',
				);
			}
		} else {
			$exact_size = array(
				'width'  => 369,
				'height' => 270
			);
		}

		$output .= '<div class="' . implode( ' ', $classes ) . '">';
			if ( $style == 'outside' ) {

				// Get posted on


				$output .= '<div class="' . esc_attr( $row ) . '" ' . implode( ' ', $attr ) . '>';
					while ( $query->have_posts() ) {
						$query->the_post();

						$output .= '<div class="col-md-' . esc_attr( $columns ) . ' col-sm-4 col-xs-12 mb__40">';
							$output .= '<article class="' . implode( ' ', get_post_class() ) . '">';
								if ( has_post_thumbnail() ) {
									$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
									if ( $img[1] >= $exact_size['width'] && $img[2] >= $exact_size['height'] ) {
										$image = the4_resizer( $img[0], $exact_size['width'], $exact_size['height'], true );
										$output .= '<a class="mb__15 db" href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( $image ) . '" width="' . esc_attr( $exact_size['width'] ) . '" height="' . esc_attr( $exact_size['height'] ) . '" alt="' . get_the_title() . '" /></a>';
									} else {
										$output .= '<div class="pr placeholder mb__15">';
											$output .= '<img src="' . THE4_KALLES_URL . '/assets/images/placeholder.png" width="570" height="320" alt="' . get_the_title() . '" />';
											$output .= '<div class="pa tc fs__10">' . sprintf( esc_html__( 'The photos should be at least %spx x %spx', 'kalles-addons' ), $exact_size['width'], $exact_size['height'] ) . '</div>';
										$output .= '</div>';
									}
								}
								$output .= '<div class="post-info mb__10">';
									$output .= '<h4 class="mg__0 fs__16 mb__5 ls__0"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
									$output .= '<span class="post-author mr__5">' . __( 'By ', 'kalles-addons' ) . '<span class="cd">' . get_the_author() . '</span></span>';
									$output .= '<span class="post-time">' . __( 'on ', 'kalles-addons' ) . '<span class="cd">';
										$time = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
										$output .= sprintf( $time,
											esc_attr( get_the_date( 'c' ) ),
								            esc_html( get_the_date() ),
								            esc_url( get_permalink() )
										);
									$output .= '</span></span>';
								$output .= '</div>';

								$output .= '<div class="post-content">' . do_shortcode( wp_trim_words( get_the_content(), 10, '...' ) ) . '</div>';
							$output .= '</article>';
						$output .= '</div>';
					}
				$output .= '</div>';
			} else if ( $style == 'outside_2'){
                $output .= '<div class="' . esc_attr( $row ) . '" ' . implode( ' ', $attr ) . '>';
                while ( $query->have_posts() ) {
                    $query->the_post();

                    $output .= '<div class="col-md-' . esc_attr( $columns ) . ' col-sm-4 col-xs-12 mb__40">';
                    $output .= '<article class="' . implode( ' ', get_post_class() ) . '">';
                    if ( has_post_thumbnail() ) {
                        $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        if ( $img[1] >= $exact_size['width'] && $img[2] >= $exact_size['height'] ) {
                            $image = the4_resizer( $img[0], $exact_size['width'], $exact_size['height'], true );
                            $output .= '<a class="mb__15 db" href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( $image ) . '" width="' . esc_attr( $exact_size['width'] ) . '" height="' . esc_attr( $exact_size['height'] ) . '" alt="' . get_the_title() . '" /></a>';
                        } else {
                            $output .= '<div class="pr placeholder mb__15">';
                            $output .= '<img src="' . THE4_KALLES_URL . '/assets/images/placeholder.png" width="570" height="320" alt="' . get_the_title() . '" />';
                            $output .= '<div class="pa tc fs__10">' . sprintf( esc_html__( 'The photos should be at least %spx x %spx', 'kalles-addons' ), $exact_size['width'], $exact_size['height'] ) . '</div>';
                            $output .= '</div>';
                        }
                    }
                    $output .= '<div class="post-info mb__10">';
                    $output .= '<span class="post-time">' . __( 'on ', 'kalles-addons' ) . '<span class="cd">';
                    $time = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                    $output .= sprintf( $time,
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                    $output .= '</span></span>';
                    $output .= '<h4 class="mg__0 fs__18 mb__5 ls__0"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
                    $output .= '</div>';
                    $output .= '</article>';
                    $output .= '</div>';
                }
                $output .= '</div>';
            } else if ( $style == 'outside_3'){
                $output .= '<div class="' . esc_attr( $row ) . '" ' . implode( ' ', $attr ) . '>';
                while ( $query->have_posts() ) {
                    $query->the_post();

                    $output .= '<div class="col-md-' . esc_attr( $columns ) . ' col-sm-4 col-xs-12 mb__40">';
                    $output .= '<article class="' . implode( ' ', get_post_class() ) . '">';
                    if ( has_post_thumbnail() ) {
                        $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        if ( $img[1] >= $exact_size['width'] && $img[2] >= $exact_size['height'] ) {
                            $image = the4_resizer( $img[0], $exact_size['width'], $exact_size['height'], true );
                            $output .= '<a class="mb__15 db" href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( $image ) . '" width="' . esc_attr( $exact_size['width'] ) . '" height="' . esc_attr( $exact_size['height'] ) . '" alt="' . get_the_title() . '" /></a>';
                        } else {
                            $output .= '<div class="pr placeholder mb__15">';
                            $output .= '<img src="' . THE4_KALLES_URL . '/assets/images/placeholder.png" width="570" height="320" alt="' . get_the_title() . '" />';
                            $output .= '<div class="pa tc fs__10">' . sprintf( esc_html__( 'The photos should be at least %spx x %spx', 'kalles-addons' ), $exact_size['width'], $exact_size['height'] ) . '</div>';
                            $output .= '</div>';
                        }
                    }
                    $output .= '<div class="post-info">';
                    $output .= '<span class="post-time">' . __( 'on ', 'kalles-addons' ) . '<span class="cd">';
                    $time = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                    $output .= sprintf( $time,
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                    $output .= '</span></span>';
                    $output .= '<h4 class="mg__0 fs__16 mb__5 ls__0"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
                    $output .= '</div>';
                    $output .= '<div class="post-content">' . do_shortcode( wp_trim_words( get_the_content(), 12, '...' ) ) . '</div>';
                    $output .= '</article>';
                    $output .= '</div>';
                }
                $output .= '</div>';
            }else if ( $style == 'outside_4'){
                $output .= '<div class="' . esc_attr( $row ) . '" ' . implode( ' ', $attr ) . '>';
                while ( $query->have_posts() ) {
                    $query->the_post();

                    $output .= '<div class="col-md-' . esc_attr( $columns ) . ' col-sm-4 col-xs-12 mb__40">';
                    $output .= '<article class="' . implode( ' ', get_post_class() ) . '">';
                    if ( has_post_thumbnail() ) {
                        $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        if ( $img[1] >= $exact_size['width'] && $img[2] >= $exact_size['height'] ) {
                            $image = the4_resizer( $img[0], $exact_size['width'], $exact_size['height'], true );
                            $output .= '<a class="mb__15 db" href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( $image ) . '" width="' . esc_attr( $exact_size['width'] ) . '" height="' . esc_attr( $exact_size['height'] ) . '" alt="' . get_the_title() . '" /></a>';
                        } else {
                            $output .= '<div class="pr placeholder mb__15">';
                            $output .= '<img src="' . THE4_KALLES_URL . '/assets/images/placeholder.png" width="570" height="320" alt="' . get_the_title() . '" />';
                            $output .= '<div class="pa tc fs__10">' . sprintf( esc_html__( 'The photos should be at least %spx x %spx', 'kalles-addons' ), $exact_size['width'], $exact_size['height'] ) . '</div>';
                            $output .= '</div>';
                        }
                    }
                    $output .= '<div class="post-info">';
                    $output .= '<span class="post-author mr__5">' . __( 'By ', 'kalles-addons' ) . '<span class="cd">' . get_the_author() . '</span></span>';
                    $output .= '<span class="post-time">' . __( 'on ', 'kalles-addons' ) . '<span class="cd">';
                    $time = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                    $output .= sprintf( $time,
                        esc_attr( get_the_date( 'c' ) ),
                        esc_html( get_the_date() )
                    );
                    $output .= '</span></span>';
                    $output .= '<h4 class="mg__0 fs__16 mt__10 ls__0"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
                    $output .= '</div>';
                    $output .= '<div class="post-content">' . do_shortcode( wp_trim_words( get_the_content(), 15, '...' ) ) . '</div>';
                    $output .= '</article>';
                    $output .= '</div>';
                }
                $output .= '</div>';
            } else {
				$output .= '<div class="the4-blog-slider ' . esc_attr( $row ) . '" ' . implode( ' ', $attr ) . '>';
					while ( $query->have_posts() ) {
						$query->the_post();

						$output .= '<div class="col-md-' . esc_attr( $columns ) . ' col-sm-4 col-xs-12 mb__40">';
							$output .= '<div class="post-thumbnail pr">';
								$output .= '<a href="' . esc_url( get_permalink() ) . '">';
									if ( has_post_thumbnail() ) :
										$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

										if ( $img[1] >= $exact_size['width'] && $img[2] >= $exact_size['height'] ) {
											$image = the4_resizer( $img[0], $exact_size['width'], $exact_size['height'], true );
											$output .= '<img src="' . esc_url( $image ) . '" width="' . esc_attr( $exact_size['width'] ) . '" height="' . esc_attr( $exact_size['height'] ) . '" alt="' . get_the_title() . '" />';
										} else {
											$output .= '<div class="pr placeholder mb__15">';
												$output .= '<img src="' . THE4__KALLES_URL . '/assets/images/placeholder.png" width="570" height="320" alt="' . get_the_title() . '" />';
												$output .= '<div class="pa tc fs__10">' . sprintf( esc_html__( 'The photos should be at least %spx x %spx', 'kalles-addons' ), $exact_size['width'], $exact_size['height'] ) . '</div>';
											$output .= '</div>';
										}
									else :
										$output .= '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.png" width="480" height="310" alt="' . get_the_title() . '" />';
									endif;
								$output .= '</a>';
								$output .= '<div class="pa tc cg w__100">';
									$output .= sprintf(
										esc_html__( '%1$s', 'kalles-addons' ),
										'<span class="author vcard pr">' . esc_html__( 'By ', 'kalles-addons' ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
									);
									$output .= sprintf( '<h2 class="post-title fs__14 ls__0 mt__10 mb__5 tu"><a class="chp" href="%2$s" rel="bookmark">%1$s</a></h2>', get_the_title(), esc_url( get_permalink() ) );
									$time = '<a class="cg" href="%3$s"><time class="entry-date published updated" datetime="%1$s">%2$s</time></a>';

									$output .= sprintf( $time,
										esc_attr( get_the_date( 'c' ) ),
										esc_html( get_the_date() ),
										esc_url( get_permalink() )
									);
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					}
				$output .= '</div>';
			}
		$output .= '</div>';

		wp_reset_postdata();

		// Return output
		return apply_filters( 'kalles_addons_shortcode_blog', force_balance_tags( $output ) );
	}
}