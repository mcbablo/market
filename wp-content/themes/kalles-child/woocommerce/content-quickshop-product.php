<?php
/**
 * The template for displaying product content in the content-quickview-product.php template
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $quickshop;

$quickshop = true;
?>
<div id="product-<?php the_ID(); ?>" <?php post_class( 'product-quickshop pr' ); ?> data-cart="<?php echo esc_attr( $cart_key ); ?>">
	<div class="row no-gutters">
		<div class="col-md-5 col-sm-6 col-xs-12 pr">

			<?php do_action( 'woocommerce_quickshop_before_thumbnail' ); ?>
			
			<div class="single-product-thumbnail pr">
				<div class="p-thumb images the4-carousel"
					data-slick='{"slidesToShow": 1,"slidesToScroll": 1,"dots": false,"prevArrow": false,"nextArrow": false,"fade":true<?php echo esc_attr( ( is_rtl() ? ',"rtl":true' : '' ) ); ?>}'>
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
								$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
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

									$html = the4_woo_variable_quickshop_gallery( $attachment_id, $all_variant_image, $product->is_type( 'variable' ) );
									
									echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
								}
						}
					?>
				</div>
			</div>
			<?php do_action( 'woocommerce_quickshop_after_thumbnail' ); ?>
		</div><!-- .col-md-6 -->
		<div class="col-md-7 col-sm-6 col-xs-12">
			<div class="content-quickshop entry-summary__top">
				<h1 class="product_title entry-title"><?php echo esc_html( $product->get_title() ); ?></h1>
				<?php
					$currency   = get_woocommerce_currency_symbol();
					$price = $product->get_price();
                    $price_sale = $product->get_sale_price();
                    $price_regular = ($price == $price_sale) ? $product->get_regular_price() : $price;
				?>
				<div class="flex between-xs middle-xs price-review">
					<p class="price">
	                    <?php if ($price_sale) : ?>
	                    <del>
	                    <?php endif; ?>
	                        <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ); ?></span>
	                        <span class="woocommerce-Price-amount amount">
	                            <bdi><?php echo wp_kses_post( $price_regular ); ?></bdi>
	                        </span>
	                    <?php if ($price_sale) : ?>
	                    </del>
	                    <?php endif; ?>
	                    <?php if ($price_sale) : ?>
	                    <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ); ?></span>
	                    <ins>
	                        <span class="woocommerce-Price-amount amount">
	                            <bdi><?php echo wp_kses_post( $price_sale ); ?></bdi>
	                        </span>
	                    </ins>
	                    <?php endif; ?>
                        <?php echo woocommerce_show_product_loop_sale_flash();?>
	                </p>
				</div>

			</div><!-- .summary -->
		</div><!-- .col-md-6 -->
	</div><!-- .row -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 mt__20">
			<?php do_action( 'woocommerce_quickshop_after_summary' ); ?>
			<div class="detail_link_block mt__20">
				<a class="fwsb detail_link" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html__( 'View full details', 'kalles' ); ?> <i class="t4_icon_arrow-right-solid" aria-hidden="true"></i></a>
			</div>

		</div>
	</div><!-- .row -->
</div><!-- .product-quickshop -->