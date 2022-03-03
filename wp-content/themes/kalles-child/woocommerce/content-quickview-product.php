<?php
/**
 * The template for displaying product content in the content-quickview-product.php template
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $quickview, $product;

$quickview = true;
//Kalles lazysite
$is_kalles_lazyload = kalles_image_lazyload_class(false);

?>
<div class="mfp-with-anim popup-quick-view" id="content_quickview">
	<div id="product-<?php the_ID(); ?>" <?php post_class( 'product-quickview pr' ); ?> >
		<div class="row">
			<div class="col-md-7 col-sm-6 col-xs-12 pr">
				<?php do_action( 'woocommerce_quickview_before_thumbnail' ); ?>
				<?php echo woocommerce_show_product_loop_sale_flash();?>
				<div class="single-product-thumbnail pr">
					<div class="p-thumb images the4-carousel" data-slick='{"slidesToShow": 1,"slidesToScroll": 1,"dots": true,"fade":true<?php echo esc_attr( ( is_rtl() ? ',"rtl":true' : '' ) ); ?>}'>
						<?php
							if ( has_post_thumbnail() ) {
								$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
								$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
								$thumbnail_post    = get_post( $post_thumbnail_id );
								$image_title       = $thumbnail_post->post_content;

								$attributes = array(
									'title'                   => $image_title,
									'data-src'                => $full_size_image[0],
									'data-large_image'        => $full_size_image[0],
									'data-large_image_width'  => $full_size_image[1],
									'data-large_image_height' => $full_size_image[2],
								);

								$html  = '<div class="p-item woocommerce-product-gallery__image">';
								if ( $is_kalles_lazyload )
									$html .= '<div class="single-product-img-wrapper the4-lazyload">';
									$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
								if ( $is_kalles_lazyload )
									$html .= '</div>';
								$html .= '</div>';

							} else {
								$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'kalles' ) );
								$html .= '</div>';
							}

							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );


							$attachment_ids   = the4_woo_get_variable_gallery();
							$all_variant_image = the4_woo_get_all_variant_image();

							if ( $attachment_ids ) {
								foreach ( $attachment_ids as $attachment_id ) {

									$html = the4_woo_variable_quickview_gallery( $attachment_id, $all_variant_image, $product->is_type( 'variable' ) );

									echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
								}
							}
						?>
					</div>
				</div>
				<?php do_action( 'woocommerce_quickview_after_thumbnail' ); ?>
			</div><!-- .col-md-6 -->

			<div class="col-md-5 col-sm-6 col-xs-12 pr">
				<?php do_action( 'woocommerce_quickview_before_summary' ); ?>
				<div class="summary-inner gecko-scroll-quick">
					<div class="gecko-scroll-content-quick">
						<div class="content-quickview entry-summary">
							<?php
								/**
								 * woocommerce_single_product_summary hook
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 */
								do_action( 'woocommerce_single_product_summary' );

							?>
							<a class="fwsb detail_link" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html__( 'View details', 'kalles' ); ?> <i class="t4_icon_arrow-right-solid" aria-hidden="true"></i></a>
						</div><!-- .summary -->
					</div> <!-- gecko-scroll-content-quick -->
				</div>
				<?php do_action( 'woocommerce_quickview_after_summary' ); ?>
			</div><!-- .col-md-6 -->
		</div><!-- .row -->
	</div><!-- .product-quickview -->
</div>
