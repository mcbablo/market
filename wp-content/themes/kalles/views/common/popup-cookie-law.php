<?php
/**
 * The Popup cookie Law
 *
 * @since   1.0.0
 * @package Kalles
 */

 $info_link = cs_get_option('popup-cookie_info_link') ? cs_get_option('popup-cookie_info_link') : '';
 $cookie_type = cs_get_option('popup-cookie_type') ? cs_get_option('popup-cookie_type') : 'banner';
 $cookie_position = cs_get_option('popup-cookie_banner_position') ? cs_get_option('popup-cookie_banner_position') : 'footer';
 $hide_on_scroll = cs_get_option('popup-cookie_banner_scroll') ? cs_get_option('popup-cookie_banner_scroll') : 0;
 $mtp_class = cs_get_option('popup-cookie_type') == 'popup' ? 'mfp-with-anim tc mfp-hide' : '';
?>
<div id="kalles-section-cookies_law"
	data-scrollhide="<?php echo esc_attr( $hide_on_scroll ); ?>"
	data-url="<?php echo isset( $info_link['url'] ) ? esc_attr( $info_link['url'] ) : '#'; ?>"
	class="<?php if ( cs_get_option( 'header-boxed' ) ) : echo esc_attr( 'container' ); else: echo esc_attr( 'container-fluid' ); endif; ?> pf bgw pp_onhide <?php echo esc_attr( $cookie_type . ' ' . $cookie_position . ' ' . $mtp_class ); ?>">
	<div class="popup_cookies_wrap pl__0 pr__0"
		 data-stt='{ "day_next": <?php echo esc_attr( cs_get_option('popup-cookie_verify_day_next') ); ?>,"pp_version":  <?php echo esc_attr( cs_get_option('popup-cookie_version') ); ?>}'>
	   <div class="row al_center fl_center tc tl_md">
	     <div class="col-12 col-md popup_cookies_text"><?php The4Helper::ksesHTML( cs_get_option('popup-cookie_text') ); ?></div>
	     <div class="col-12 col-md-auto popup_cookies_btns">
	        <?php if (!empty($info_link['url'])) : ?>
		        <a href="<?php echo esc_url( $info_link['url'] ); ?>" class="pp_cookies_more_btn tu dib">
		        	<?php echo esc_html( cs_get_option('popup-cookie_btn_info') ); ?>
		        </a>
	        <?php endif; ?>
	        <a href="#" data-no-instant rel="nofollow" 
	        	class="pp_cookies_accept_btn tu dib">
	        	<?php echo esc_html( cs_get_option('popup-cookie_btn_allowed') ); ?>
	        </a>
	     </div>
	   </div>
	</div>
</div>