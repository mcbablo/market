<?php
/**
 * Content product loop - full variant
 *
 * @since   1.0.0
 * @package Kalles
 */


global $product, $post, $kalles_sc;

// Flip thumbnail
$flip_thumb = $kalles_sc ? $kalles_sc['flip'] : cs_get_option( 'wc-flip-thumb' );

//Kalles lazysite
$is_kalles_lazyload = kalles_image_lazyload_class(false);

// Countdown for sale product
if ( ! empty( $kalles_sc['countdown']) ) {
	$start = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
	$end   = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
	$now   = date( 'd-m-y' );
	$date_now = new DateTime();
	$date_start = new DateTime(date( 'Y-m-d', intval($start) ));
	$date_end = new DateTime(date( 'Y-m-d', intval($end) ));
}
$is_coundown = ( ! empty( $kalles_sc['countdown'] ) && ! empty( $end ) && ! empty ( $now ) && $date_end >= $date_now ) ? ' product-countdown' : '';

 ?>

<div class="product-image pr oh <?php echo esc_attr( $is_coundown ); ?>">
	<div class="kalles-btn-tools">
		<?php do_action('kalles_product_loop_action'); ?>
	</div>
	<div class="hover_button op__0 tc pa flex column ts__03">
			<?php the4_kalles_quickview_btn($post); ?>
	</div>
	<?php
		/**
		 * woocommerce_before_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' );
	?>
	<?php
		$lazyload_class = ( kalles_image_lazyload_class(false) && isset( $kalles_sc['img_size'] ) && $kalles_sc['img_size'] != 'custom' ) ? 'the4-lazyload' : '';

		echo '<div class="product-image-loop pr ' . $lazyload_class . '">';
		echo '<a class="db" href="' . esc_url( get_permalink() ) . '">';
				/**
				 * woocommerce_before_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
                remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
				do_action( 'woocommerce_before_shop_loop_item_title' );

                echo the4_woo_get_product_thumbnai();

		echo '</a>';

			kalles_hover_image_secord();

		echo '</div>';
	?>

	<?php if ( ! empty( $kalles_sc['countdown'] ) && ( $end && $date_start <= $date_now ) ) : ?>
		<div class="countdown-time pa">
			<div class="the4-countdown flex tc" data-time="<?php echo esc_attr( date( 'Y/m/d', $end ) ); ?>"></div>
		</div>
	<?php endif; ?>
	<?php the4_kalles_attributes_product_loop($product); ?>
</div><!-- .product-image -->
<div class="product-info mt__15">
	<div class="product-info__inner">
	<?php
		/**
		 * woocommerce_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * woocommerce_after_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_rating - 5 #removed
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
	</div> <!-- product-info__inner -->
	<div class="product-info__btns flex column mt__20">
		<?php
			do_action( 'kalles_product_loop_btn_info' );

			//Display all product variants
			t4_woo_get_all_variants();

			if ( cs_get_option( 'wc-atc-on-product-list' ) ) {
				woocommerce_template_loop_add_to_cart();
			}
		?>
	</div>
</div><!-- .product-info -->
