<?php
/**
 * The template to display woocommerce content.
 *
 * @since   1.0.0
 * @package Kalles
 */

$is_pjax = kalles_is_pjax_request();

if ( ! defined( 'HFE_VER' ) || is_singular( 'product' ) ) {
	if ( ! $is_pjax )
		get_header();
}

get_template_part( 'views/common/page', 'head' );

if ( is_singular( 'product' ) ) {
	
	echo '<div id="the4-content">';
		woocommerce_content();
	echo '</div>';
} else {
	wc_get_template( 'archive-product.php' );
}

if ( ! defined( 'HFE_VER' ) || is_singular( 'product' ) ) {
	if ( ! $is_pjax )
	 get_footer();
}

