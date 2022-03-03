<?php
/**
 * The footer bottom common.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>

<?php $f_copyright_right = cs_get_option('footer-copyright_right-content-type') ? cs_get_option('footer-copyright_right-content-type') : 'menu'; ?>
<div class="footer__bot pt__20 pb__20 lh__1">
	<div class="container pr tc">
		<?php
			if ( $f_copyright_right != 'disable' ) {
				echo '<div class="row"><div class="col-md-6 col-sm-12 col-xs-12 start-md center-sm center-xs">';
			}
			echo do_shortcode( cs_get_option( 'footer-copyright' ) );

			if ( $f_copyright_right != 'disable' ) {
				echo '</div><div class="col-md-6 col-sm-12 col-xs-12 end-md center-sm center-xs flex">';
			}
			switch ($f_copyright_right) {
				case 'trust':
					if (cs_get_option( 'footer-copyright_right-source_img' ) == '1') {
	        		$image = cs_get_option( 'footer-copyright_right-image' );
	        		if (!empty($image['url'])) {
	        			$output .= '<img class="img_tr_s1 lazyload lz_op_ef" alt="'. esc_attr__( 'coppy right', 'kalles' ) . '" src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20' . $image['width'] .'%20' . $image['height'] .'%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" style="width:' . cs_get_option( 'footer-copyright_right-image_width' ) .'%;" data-src="' . $image['url'] .'" data-widths="[90, 120, 150, 180, 360, 480, 600, 750, 940, 1080, 1296]" data-sizes="auto"/>';
	        		}
		        	} else {
		        		$svg_width = cs_get_option( 'footer-copyright_right-svg-width' );
		        		$svg_height = cs_get_option( 'footer-copyright_right-svg-height' );
		        		$svg_vector = kalles_get_payment_icon_svg( $svg_width, $svg_height );
		        		$svg_list = cs_get_option( 'footer-copyright_right-svg-list' );
		        		if ( ! empty($svg_list) ) {
		        			$svg_list = explode(',', $svg_list);
			        		foreach ($svg_list as $svg) {
			        			if (isset($svg_vector[$svg])) {
			        				$output .= $svg_vector[$svg];
			        			}
			        		}
		        		}
		        	}
		        	echo wp_kses_post( $output );
					break;
				case 'text':
					The4Helper::ksesHTML( cs_get_option( 'footer-copyright_right-text' ) );
					break;
				case 'shortcode':
					echo do_shortcode( cs_get_option( 'footer-copyright_right-shortcode' ) );
					break;
				case 'menu':
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'menu_class'     => 'clearfix',
							'menu_id'        => 'the4-footer-menu',
							'container'      => false,
							'fallback_cb'    => NULL,
							'depth'          => 1
						)
					);
					break;
			}
			if ( $f_copyright_right != 'disable' ) {
				echo '</div></div>';
			}
		?>
	</div>
</div><!-- .footer__bot -->