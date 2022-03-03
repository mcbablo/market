<?php
/**
 * The Exist Product Popup
 *
 * @since   1.0.0
 * @package Kalles
 */
	global $kalles_sc;
	$categories = cs_get_option('popup-exist_product_cat') ? cs_get_option('popup-exist_product_cat') : '';
	$exist_products = array();
	if (!empty($categories)) {
		$exist_products_posts = the4_kalles_get_products ( $categories );
		foreach ($exist_products_posts as $exist_products_post) {
			$exist_products[] = wc_get_product($exist_products_post->ID);
		}

	}
?>

<?php if (!empty($exist_products)): ?>
<div id="the4-kalles-exist-product">
	<div class="js_lz_pppr popup_prpr_wrap container bgw mfp-with-anim tc mfp-hide" data-stt="{ pp_version: 1,day_next: 1 }">
		<div class="wrap_title  des_title_2">
				<h3 class="section-title tc pr flex fl_center al_center fs__24 title_2">
					<span class="mr__10 ml__10">Wait! Can't find what you're looking for?</span>
				</h3>
				<span class="dn tt_divider">
					<span></span>
					<i class="dn clprfalse title_2 la-gem"></i>
					<span></span>
				</span>
				<span class="section-subtitle db tc sub-title">Maybe this will help...</span>
		</div>

		<div class="fproducts nt_products_holder row row_pr_1 cdt_des_1 round_cd_false exist_products_slider the4-carousel nt_cover ratio_nt 	position_8 space_ prev_next_0 btn_owl_1 dot_owl_1 dot_color_1 btn_vi_1 "
			data-slick='{
					"slidesToShow": 4, "slidesToScroll": 4, "autoplaySpeed": 4000
				}'>
			<?php
				foreach ( $exist_products as $exist_product ) :
				 	$post_object = get_post( $exist_product->get_id() );
					$GLOBALS['post'] =& $post_object;
					setup_postdata( $post_object );

					wc_get_template( 'content-product.php' );

				endforeach;
			?>
		</div>
	</div>
</div>
<?php endif ?>

<?php
	wp_reset_postdata();
	$kalles_sc = NULL;
 ?>