<?php
/**
 * Header Action Common file
 *
 * @since   1.0.0
 * @package Kalles
 */

	$icons = the4_get_header_action_icon();

	if ( !empty( $icons ) ) {
		$icon_search_class = $icons[ 'search' ];
    	$icon_heart_class = $icons[ 'heart' ];
	}

?>
<div class="the4-action in_flex al_center middle-xs">
	<?php if ( cs_get_option( 'header-search-icon' ) && class_exists( 'WooCommerce' ) ) : ?>
		<a class="sf-open cb chp" data-open="the4-search-opened" href="javascript:void(0);"  title="<?php esc_attr_e( 'Search', 'kalles' ); ?>"><i class="<?php echo esc_attr($icon_search_class); ?>"></i></a>
	<?php endif; ?>
	<?php
		if ( class_exists( 'WooCommerce' ) ) {
			echo the4_kalles_wc_my_account();
			if ( cs_get_option('wc_general_wishlist-type')
				 && cs_get_option('wc_general_wishlist-page') ) {
					$w_count = isset( $_COOKIE['kalles_wishlist'] ) ? count(unserialize($_COOKIE['kalles_wishlist'])) : 0;
					$w_link = get_page_link(cs_get_option('wc_general_wishlist-page'));
					echo '<a class="cb chp hidden-xs pr" href="' . $w_link . '" title="' .  esc_attr( 'View your Wishlist', 'kalles' ) . '"><i class="'. $icon_heart_class .'"></i><span class="jswcount pa bgb br__50 cw tc">' . $w_count . '</span></a>';
			} else {
				if ( class_exists( 'YITH_WCWL' ) ) {
					global $yith_wcwl;
					echo '<a class="cb chp hidden-xs"
							 href="' . esc_url( $yith_wcwl->get_wishlist_url() ) . '"
							 title="' .  esc_attr( 'View your Wishlist', 'kalles' ) . '">
							 	<i class="'. $icon_heart_class .'"></i>
						</a>';
				}
			}

			echo the4_kalles_wc_shopping_cart();
		}
	?>
	<?php if (cs_get_option( 'header-layout' ) == 8) : ?>
	<a href="javascript:void(0);" class="the4-push-menu-btn dn db_lg ml__10">
	</a>
	<?php endif; ?>
</div><!-- .the4-action -->