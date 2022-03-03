<?php
/**
 * The template for displaying product content in the content-quickview-product.php template
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $kalles_featured_product;

//Kalles lazysite
$is_kalles_lazyload = kalles_image_lazyload_class(false);

$product = wc_get_product( get_the_ID() );

?>
	<div class="container-fluid width-product-featured" >
		<div class="row">
				<div class="col-md-12 col-xs-12">
						<div class="row mb__50">
							<div class="col-md-6 col-sm-6 col-xs-12 pr">
								<?php
									/**
									 * woocommerce_before_single_product_summary hook.
									 *
									 * @hooked woocommerce_show_product_sale_flash - 10
									 * @hooked woocommerce_show_product_images - 20
									 */
									remove_action( 'kalles_product_image_action', 'the4_kalles_product_img_gallery_btn');
									remove_action( 'kalles_product_image_action', 'the4_kalles_product_video_btn');

									if ( $kalles_featured_product[ 'thumbnail' ] != 'yes') {
										remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
									}

									do_action( 'woocommerce_before_single_product_summary' );
									add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_sharing', 30 );
								?>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="summary entry-summary hi <?php if ( $kalles_featured_product['product_meta_meta'] != 'yes' ) : ?> meta-disable<?php endif; ?>">
									<?php
										remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

										/**
										 * woocommerce_single_product_summary hook.
										 *
										 * @hooked woocommerce_template_single_title - 5
										 * @hooked woocommerce_template_single_rating - 10
										 * @hooked woocommerce_template_single_price - 10
										 * @hooked woocommerce_template_single_excerpt - 20
										 * @hooked woocommerce_template_single_add_to_cart - 30
										 * @hooked woocommerce_template_single_meta - 40
										 * @hooked woocommerce_template_single_sharing - 50
										 */
										
										//Remove hooked product meta.
										if ( ! empty( $kalles_featured_product['product_meta'] ) ) {
											foreach ( $kalles_featured_product['product_meta'] as $meta => $value ) {
												if ( $value != 'yes' )
													remove_action( 'woocommerce_product_meta_start', $meta );
											}
										} 

										if ( $kalles_featured_product['product_meta_social_share'] != 'yes' ) {
											remove_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_single_social_share', 50 );	
										}

										remove_action( 'woocommerce_single_product_summary', 'the4_kalles_wc_add_extra_link_after_cart', 35 );									
										do_action( 'woocommerce_single_product_summary' );

										do_action( 'kalles_single_product_featured_summary' );
									?>
									<?php if ( $kalles_featured_product[ 'view_details' ] == 'yes' ) : ?>
										<a class="fwsb detail_link" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html__( 'View details', 'kalles' ); ?> <i class="t4_icon_arrow-right-solid" aria-hidden="true"></i></a>
									<?php endif; ?>
								</div><!-- .summary -->
							</div>
					</div>
				</div>
		</div><!-- .row -->
	</div><!-- .product-featured -->
