<?php
/**
 * Option hooks.
 *
 * @since   1.0.0
 * @package Kalles
 */

/**
 * Woocommerce Trust badget function
 *
 * @return void
 */
if ( ! function_exists( 'the4_kalles_woo_trust_badget' ) ) {
    function the4_kalles_woo_trust_badget() {



        $enable = cs_get_option( 'wc_cart_trust_badget-enable' );

        if ($enable) {
        	$al = cs_get_option( 'wc_cart_trust_badget-image_align' ) ? cs_get_option( 'wc_cart_trust_badget-image_align' ) : 'tc';
        	$output = '';
        	$output .= '<div class="pr_trust_seal mt__20 ' . $al . '">';
        	if (!empty(cs_get_option( 'wc_cart_trust_badget-text' ))) {
        		$output .= '<p class="mess_cd cb mb__10 fwm tu">' . cs_get_option( 'wc_cart_trust_badget-text' ) . '</p>';
        	}
        	if (cs_get_option( 'wc_cart_trust_badget-source_img' ) == '1') {
        		$image = cs_get_option( 'wc_cart_trust_badget-image' );
        		if (!empty($image['url'])) {
        			$output .= '<img class="img_tr_s1 lazyload lz_op_ef" alt="'. esc_attr__( 'Trust badget image', 'kalles' ) . '" src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20' . $image['width'] .'%20' . $image['height'] .'%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" style="width:' . cs_get_option( 'wc_cart_trust_badget-image_width' ) .'%;" data-src="' . $image['url'] .'" data-widths="[90, 120, 150, 180, 360, 480, 600, 750, 940, 1080, 1296]" data-sizes="auto"/>';
        		}
        	} else {
        		$svg_width = cs_get_option( 'wc_cart_trust_badget-svg-width' );
        		$svg_height = cs_get_option( 'wc_cart_trust_badget-svg-height' );
        		$svg_vector = kalles_get_payment_icon_svg($svg_width, $svg_height);
        		$svg_list = cs_get_option( 'wc_cart_trust_badget-svg-list' );
        		if (!empty($svg_list)) {
        			$svg_list = explode(',', $svg_list);
	        		foreach ($svg_list as $svg) {
	        			if (isset($svg_vector[$svg])) {
	        				$output .= $svg_vector[$svg];
	        			}
	        		}
        		}
        	}
        	$output .= '</div>';
        	The4Helper::ksesHTML( $output );
        }
    }
}

/**
 * Woocommerce Flash sale coundown function
 *
 * @return void
 */

if ( ! function_exists( 'the4_kalles_woo_flash_coundown' ) ) {
    function the4_kalles_woo_flash_coundown() {



    	$enable = cs_get_option( 'wc_product_coundown-enable' );

    	if ($enable) {
    		$start = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
			$end   = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
			$now   = date( 'd-m-y' );
			$date_now = new DateTime();
			$date_start = new DateTime(date( 'Y-m-d', intval($start) ));
			$date_end = new DateTime(date( 'Y-m-d', intval($end) ));

			if (! empty( $end ) && ! empty ( $now ) && $date_end >= $date_now) {

				$al = cs_get_option( 'wc_product_coundown-itext_align' ) ? cs_get_option( 'wc_product_coundown-itext_align' ) : 'tc';
				$icon_style = cs_get_option( 'wc_product_coundown-type' );
				$fade = boolval(cs_get_option( 'wc_product_coundown-fade' ))  ? 'true' : 'false';;

        		$output = '';
        		$output .= '<div id="the4-kalles-product-coundow-page" class="'. $al .' cd_style_' . cs_get_option( 'wc_product_coundown-design' ) . '">';
        		if (!empty(cs_get_option( 'wc_product_coundown-text' ))) {
	        		$output .= '<p style="font-size:' . cs_get_option( 'wc_product_coundown-text_font_size' ) . 'px;" class="mess_cd cb mb__10 lh__1 fwm tu dn">';
	        		if ($icon_style != 1) {
		        		if ($icon_style == 2) {
		        			$output .= '<i class="cd mr__5 fading_' . $fade . ' fs__20 ' . cs_get_option( 'wc_product_coundown-icon' ) . '"></i>';
		        		} else {
		        			$image = cs_get_option( 'wc_product_coundown-image' );
			        		if (!empty($image['url'])) {
			        			$output .= '<img class="lazyload img_w25 w__100 mr__5 fading_'. $fade .'" style="max-width:30px;" data-src="' . $image['url'] .'" data-sizes="auto"/>';
			        		}
		        		}
		        	}
		        	$output .= cs_get_option( 'wc_product_coundown-text' ) . '</p>';
	        	}

	        	$output .= '<div class="the4-countdown-page in_flex fl_between lh__1" data-time="' . date( 'Y/m/d', $end ) . '"></div>';
	        	$output .= '<span class="day dn"></span><span class="hr dn"></span><span class="min dn"></span><span class="sec dn"></span>';
	        	$output .= '</div>';

	        	echo wp_kses_post( $output );
			}
    	}
    }

    add_action( 'woocommerce_single_product_summary', 'the4_kalles_woo_flash_coundown', 25);
}

/**
 * Woocommerce Product live view
 *
 * @return void
 */

if ( ! function_exists( 'the4_kalles_woo_product_live_view' ) ) {
    function the4_kalles_woo_product_live_view() {



    	$enable = cs_get_option( 'wc_product_liveview-enable' );
    	$liveview_text = cs_get_option( 'wc_product_liveview-text' );

    	if ($enable && $liveview_text) {
    		$icon_style = cs_get_option( 'wc_product_liveview-type' );
	    	$min = cs_get_option( 'wc_product_liveview-min' );
	    	$max = cs_get_option( 'wc_product_liveview-max' );
	    	$interval = cs_get_option( 'wc_product_liveview-interval' );
	    	$fade = boolval(cs_get_option( 'wc_product_liveview-fade' ))  ? 'true' : 'false';;
	    	$liveview_text = str_replace('[count]', '<span class="count clc fwm cd"></span>', $liveview_text);

    		$output = '';
    		$output .= '<div id="the4-kalles-product-liveview" class="pr_counter dn cd mb__20"
    		data-min="' . $min . '"
    		data-max="' . $max . '"
    		data-interval="' . $interval . '000">';
    		if ($icon_style != 1) {
        		if ($icon_style == 2) {
        			$output .= '<i class="cd mr__5 fading_' . $fade . ' fs__20 ' . cs_get_option( 'wc_product_liveview-icon' ) . '"></i>';
        		} else {
        			$image = cs_get_option( 'wc_product_liveview-image' );
	        		if (!empty($image['url'])) {
	        			$output .= '<img class="lazyload img_w25 w__100 mr__5 fading_'. $fade .'" style="max-width:30px;" data-src="' . $image['url'] .'" data-sizes="auto"/>';
	        		}
        		}
        	}
        	$output .= $liveview_text;
        	$output .= '</div>';
        	echo wp_kses_post( $output );
    	}
    }
}

/**
 * Woocommerce Product flash sale
 *
 * @return void
 */

if ( ! function_exists( 'the4_kalles_woo_product_flash_sale' ) ) {
    function the4_kalles_woo_product_flash_sale() {



    	$enable = cs_get_option( 'wc_product_flash_sale-enable' );
    	$flash_sale_text = cs_get_option( 'wc_product_flash_sale-text' );

    	if ($enable && $flash_sale_text) {
    		$icon_style = cs_get_option( 'wc_product_flash_sale-type' );
	    	$min_qty = cs_get_option( 'wc_product_flash_sale-min_qty' );
	    	$max_qty = cs_get_option( 'wc_product_flash_sale-max_qty' );
	    	$min_time = cs_get_option( 'wc_product_flash_sale-min_time' );
	    	$max_time = cs_get_option( 'wc_product_flash_sale-max_time' );
	    	$fade = boolval(cs_get_option( 'wc_product_flash_sale-fade' ))  ? 'true' : 'false';;
	    	$flash_sale_text = str_replace('[sold]', '<span class="nt_pr_sold clc fwm"></span>', $flash_sale_text);
	    	$flash_sale_text = str_replace('[hour]', '<span class="nt_pr_hrs clc fwm"></span>', $flash_sale_text);

    		$output = '';
    		$output .= '<div id="the4-kalles-product-flash-sale" class="pr_counter dn cd mb__20"
    		data-mins="' . $min_qty . '"
    		data-maxs="' . $max_qty . '"
    		data-mint="' . $min_time . '"
    		data-maxt="' . $max_time . '" >';
    		if ($icon_style != 1) {
        		if ($icon_style == 2) {
        			$output .= '<i class="cd mr__5 fading_' . $fade . ' fs__20 ' . cs_get_option( 'wc_product_flash_sale-icon' ) . '"></i>';
        		} else {
        			$image = cs_get_option( 'wc_product_flash_sale-image' );
	        		if (!empty($image['url'])) {
	        			$output .= '<img class="lazyload img_w25 w__100 mr__5 fading_'. $fade .'" style="max-width:30px;" data-src="' . $image['url'] .'" data-sizes="auto"/>';
	        		}
        		}
        	}
        	$output .= $flash_sale_text;
        	$output .= '</div>';
        	echo wp_kses_post( $output );
    	}
    }
}

/**
 * Woocommerce Product Delivery Time
 *
 * @return void
 */

if ( ! function_exists( 'the4_kalles_woo_product_delivery_time' ) ) {
    function the4_kalles_woo_product_delivery_time() {;



    	$enable = cs_get_option( 'wc_product_delivery_time-enable' );
    	$dtime_text = cs_get_option( 'wc_product_delivery_time-text' );

    	if ($enable && $dtime_text) {
    		$icon_style = cs_get_option( 'wc_product_delivery_time-type' );
    		$fade = boolval(cs_get_option( 'wc_product_delivery_time-fade' ))  ? 'true' : 'false';
    		$dtime_text = str_replace('[hour]', '<span class="h_delivery clc"></span>', $dtime_text);
	    	$dtime_text = str_replace('[date_start]', '<span class="start_delivery fwm txt_under"></span>', $dtime_text);
	    	$dtime_text = str_replace('[date_end]', '<span class="end_delivery fwm txt_under"></span>', $dtime_text);
    		$output = '';
    		$output .= '<div id="the4-kalles-product-delivery_time" class="prt_delivery dn cd mb__20"
    						data-timezone="false"
				    		data-frm="' . cs_get_option( 'wc_product_delivery_time-date_format' ) . '"
				    		data-mode="' . cs_get_option( 'wc_product_delivery_time-mode' ) . '"
				    		data-cut="' . cs_get_option( 'wc_product_delivery_time-exc_days' ) . '"
				    		data-ds="' . cs_get_option( 'wc_product_delivery_time-start_date' ) . '"
				    		data-de="' . cs_get_option( 'wc_product_delivery_time-end_date' ) . '"
				    		data-time="' . cs_get_option( 'wc_product_delivery_time-cut_off' ) . '"  >';
			if ($icon_style != 1) {
        		if ($icon_style == 2) {
        			$output .= '<i class="cd mr__5 fading_' . $fade . ' fs__20 ' . cs_get_option( 'wc_product_delivery_time-icon' ) . '"></i>';
        		} else {
        			$image = cs_get_option( 'wc_product_delivery_time-image' );
	        		if (!empty($image['url'])) {
	        			$output .= '<img class="lazyload img_w25 w__100 mr__5 fading_'. $fade .'" style="max-width:30px;" data-src="' . $image['url'] .'" data-sizes="auto"/>';
	        		}
        		}
        	}
        	$output .= $dtime_text;
        	$output .= '</div>';
        	echo wp_kses_post( $output );
    	}
    }
}

/**
 * Woocommerce Product Stock Left
 *
 * @return void
 */

if ( ! function_exists( 'the4_kalles_woo_product_stock_left' ) ) {
    function the4_kalles_woo_product_stock_left() {
    	


    	$enable = cs_get_option( 'wc_product_inventory_qty-enable' );

    	if ( $enable ) {

    		global $product;

			$pr_stock        = $product->get_stock_quantity();
			$noStock = $pr_stock == 0 && $product->get_manage_stock();
			$mode 			 = cs_get_option( 'wc_product_inventory_qty-mode' );
			$qty 			 = cs_get_option( 'wc_product_inventory_qty-qty' );

			if ( ( $pr_stock > $qty && $mode == '1' ) 
				|| ( $noStock && $product->is_type( 'simple') )
				 || ( empty( $pr_stock ) && $product->is_type( 'variable') && $mode != '2' ) ) {
				return;
			}

			$icon_style      = cs_get_option( 'wc_product_inventory_qty-type' );
			$al              = cs_get_option( 'wc_product_inventory_qty-text_align' );
			$qty_text        = cs_get_option( 'wc_product_inventory_qty-text' );
			$qty_text        = str_replace('[stock_number]', '<span class="count"></span>', $qty_text);
			$fade 			 = boolval(cs_get_option( 'wc_product_delivery_time-fade' ))  ? 'true' : 'false';
			$bg_color        = cs_get_option( 'wc_product_inventory_qty-bg_color' );
			$bgprocess_color = cs_get_option( 'wc_product_inventory_qty-process_color' );
			$bgten_color     = cs_get_option( 'wc_product_inventory_qty-lessthan_color' );
			$wbar            = cs_get_option( 'wc_product_inventory_qty-wbar' );
			$qty_checkbox    = cs_get_option( 'wc_product_inventory_qty-check' );
    			$data_type = 'ATC';
    			if (in_array('reduce', $qty_checkbox)) {
    				$data_type = 'ATC_NONE';
    			}


    		$output = '';
    		$output .= '<div id="the4-kalles-product-left-stock" class="nt_stock_page mb__20 ' . $al . '"
				    		data-type="' . $data_type . '"
				    		data-cur="' . $pr_stock . '"
				    		data-prid="' . get_the_ID() . '"
				    		data-st="' . $mode . '"
				    		data-qty="' . $qty . '"
				    		data-total="' . cs_get_option( 'wc_product_inventory_qty-total_items' ) . '"
				    		data-min="' . cs_get_option( 'wc_product_inventory_qty-stock_from' ) . '"
				    		data-max="' . cs_get_option( 'wc_product_inventory_qty-stock_to' ) . '"
				    		data-bgprocess="' . cs_get_option( 'wc_product_inventory_qty-process_color' ) . '"
				    		data-bgten="' . cs_get_option( 'wc_product_inventory_qty-lessthan_color' ) . '" >';
			

			if (!empty(cs_get_option( 'wc_product_inventory_qty-text' ))) {

        		$output .= '<p style="font-size:' . cs_get_option( 'wc_product_inventory_qty-text_font_size' ) . 'px;" class="mess_cd cb mb__10 lh__1 fwm tu dn">';
        		if ($icon_style != 1) {
	        		if ($icon_style == 2) {
	        			$output .= '<i class="cd mr__5 fading_' . $fade . ' fs__20 ' . cs_get_option( 'wc_product_inventory_qty-icon' ) . '"></i>';
	        		} else {
	        			$image = cs_get_option( 'wc_product_inventory_qty-image' );
		        		if (!empty($image['url'])) {
		        			$output .= '<img class="lazyload img_w25 w__100 mr__5 fading_'. $fade .'" style="max-width:30px;" data-src="' . $image['url'] .'" data-sizes="auto"/>';
		        		}
	        		}
	        	}
	        	$output .= $qty_text . '</p>';
        	}
        	if (in_array('progress', $qty_checkbox)) {
        		$output .= '<div class="progressbar progress_bar pr oh dn" style="display:none;background-color:' . $bg_color . ';width:' . $wbar .'%">
        				<div style="background-color:' . $bgprocess_color .';width: 100%;"></div>
        			</div>';
        	}
        	$output .= '</div>';

        	echo wp_kses_post( $output );
    	}
    }
}

/**
 * Add to Product Meta Woo hook
 *
 * @return void
 */

if ( ! function_exists( 'the4_kalles_woo_product_meta' ) ) {
    function the4_kalles_woo_product_meta() {
    	$summary_position = cs_get_option('wc-summary_position_sort');

		if ( ! empty( $summary_position ) ) {
			
		    foreach ( $summary_position as $order => $value ) {
		        add_action('woocommerce_product_meta_start', $order);
		    }
		}

		return;
    }
}
//Add to Product Meta Woo hook
if ( kalles_is_woocommerce() ) {
	add_action( 'init', 'the4_kalles_woo_product_meta');
}

/**
 * WHITE LABEL OPTION
 *
 */

/**
 * Change Menu icon
 *
 * @return Image URL
 */

if ( ! function_exists( 'the4_white_label_change_menu_icon' ) ) {
    function the4_white_label_change_menu_icon( ) {
    	$white_label = get_option( '_kalles_options_white_label' );

    	if ( isset( $white_label['white_label-menu_icon']['url']) && !empty( $white_label['white_label-menu_icon']['url']) ) {
    		$icon = $white_label['white_label-menu_icon']['url'];
    	} else {
    		$icon = THE4_KALLES_URL . '/assets/images/icons/fw-icon.png';
    	}

    	return $icon;
    }
}

add_filter( 't4_admin_menu_icon', 'the4_white_label_change_menu_icon' );

/**
 * Change Menu Title
 *
 * @return Image URL
 */

if ( ! function_exists( 'the4_white_label_change_menu_title' ) ) {
    function the4_white_label_change_menu_title( ) {
    	return t4_white_label('white_label-menu_title', 'The4 Dashboard');
    }
}
add_filter( 't4_admin_menu_title', 'the4_white_label_change_menu_title');

/**
 * Change Login logo
 *
 * @return Image URL
 */

if ( ! function_exists( 'the4_white_label_change_login_logo' ) ) {
    function the4_white_label_change_login_logo( ) {
    	$white_label = get_option( '_kalles_options_white_label' );

    	if ( isset( $white_label['white_label-login_logo']['url']) && !empty( $white_label['white_label-login_logo']['url']) ) {
    		$logo = $white_label['white_label-login_logo']['url'];
    		echo '<style>.login h1 a {background-image: url( ' . $logo . ') !important; }</style>';
    	}
    }
}

add_action( 'login_head', 'the4_white_label_change_login_logo' );

/**
 * Change Login logo URL
 *
 * @return URL
 */

if ( ! function_exists( 'the4_white_label_change_login_url' ) ) {
    function the4_white_label_change_login_url( ) {
    	$white_label = get_option( '_kalles_options_white_label' );

    	if ( isset( $white_label['white_label-login_url']['url']) && !empty( $white_label['white_label-login_url']['url']) ) {
    		$url = $white_label['white_label-login_url']['url'];
    	} else {
    		$url = 'https://wordpress.org/';
    	}

    	return $url;
    }
}

add_filter( 'login_headerurl', 'the4_white_label_change_login_url' );

/**
 * Remove Menu Dashboard
 *
 */

if ( ! function_exists( 'the4_remove_admin_dashboard' ) ) {
    function the4_remove_admin_dashboard( ) {

    	$disable_dasboard = t4_white_label('white_label-dasboard', false);

    	if ( $disable_dasboard ) {
    		remove_submenu_page( 'the4-dashboard', 'the4-dashboard' );
    	}
	}
}

add_action( 'admin_menu', 'the4_remove_admin_dashboard', 10);

/**
 * Chang theme Appearance screenshot
 *
 */

if ( ! function_exists( 'the4_white_label_change_appearance_screenshot' ) ) {
    function the4_white_label_change_appearance_screenshot( ) {
    	$white_label = get_option( '_kalles_options_white_label' );
    	$theme_name = t4_white_label('white_label-theme_name', 'Kalles');

    	if ( isset( $white_label['white_label-appearance_screenshot']['url']) && !empty( $white_label['white_label-appearance_screenshot']['url']) ) {
    		$logo = $white_label['white_label-appearance_screenshot']['url'];
    		?>
    		<style>
    			.themes .theme[data-slug="kalles"] .theme-screenshot img,
    			.themes .theme[data-slug="kalles-child"] .theme-screenshot img,
    			.theme[aria-describedby="kalles-action kalles-name"] .theme-screenshot img,
				.theme[aria-describedby="kalles-child-action kalles-child-name"] .theme-screenshot img,
				.theme-overlay.kalles .screenshot img,
				.theme-overlay.kalles .theme-info{
					display: none;
				}

    			.themes .theme[data-slug="kalles"] .theme-screenshot,
    			.themes .theme[data-slug="kalles-child"] .theme-screenshot,
    			.theme[aria-describedby="kalles-action kalles-name"] .theme-screenshot,
				.theme[aria-describedby="kalles-child-action kalles-child-name"] .theme-screenshot,
				.theme-overlay.kalles .screenshot  {
					background-image: url(<?php echo esc_url($logo); ?>) !important;
					background-repeat: no-repeat !important;
					background-position: center center !important;
					background-size: contain !important;
					background-color: transparent !important;
				}

				<?php if ( $theme_name != 'Kalles') : ?>
					.theme-name#kalles-name::after, .theme-name#kalles-child-name::after {
						content: "<?php echo esc_html( $theme_name ); ?>";
						margin-left: 5px;
						font-size: 15px;
					}
					.theme-name#kalles-name, .theme-name#kalles-child-name {
						font-size: 0;
					}
					.theme-name#kalles-name span, .theme-name#kalles-child-name span {
						font-size: 15px;
					}

				<?php endif; ?>
    		</style>
    		<?php
    	}
    }
}

add_action( 'admin_print_styles', 'the4_white_label_change_appearance_screenshot' );
