<?php
/**
 * Single product layout 1
 */

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_wc_options', true );

// Get tab position
$position = cs_get_option( 'wc-extra-position' );

// Full width layout
$fullwidth = cs_get_option( 'wc-detail-full' );

// Get product detail layout
$layout = apply_filters( 'the4_kalles_product_detail_layout', cs_get_option( 'product-detail-layout' ) );

// Get product detail  sidebars
$sidebar = cs_get_option( 'product-detail-sidebar' );


if ( $layout == 'left-sidebar' ) {
	$content_class = 'col-md-9 col-xs-12';
	$sidebar_class = 'col-md-3 col-xs-12 first-md';
} elseif ( $layout == 'right-sidebar'){
	$content_class = 'col-md-9 col-xs-12';
	$sidebar_class = 'col-md-3 col-xs-12';
} else {
	$content_class = 'col-md-12 col-xs-12';
	$sidebar_class = '';
}

// Get thumbnail position
$thumb_position = ( is_array( $options ) && $options['wc-single-style'] == 1 && $options['wc-thumbnail-position'] ) ? $options['wc-thumbnail-position'] : ( cs_get_option( 'wc-thumbnail-position' ) ? cs_get_option( 'wc-thumbnail-position' ) : 'left' );
?>

<div class="the4-wc-single wc-single-1 mb__60 <?php echo esc_attr( $thumb_position ); ?> <?php if ( cs_get_option( 'wc-single-buynow_btn' ) ) echo 'has-buy-now'; ?>">
	<?php
		if ( $fullwidth ) echo '<div class="the4-full-brc">';
		echo '<div class="woo-brc bgbl pt__20 pb__20 pl__15 pr__15 lh__1">';
			woocommerce_breadcrumb();
		echo '</div>';
        if ( $fullwidth ) echo '</div>';
		/**
		 * woocommerce_before_single_product hook.
		 *
		 * @hooked wc_print_notices - 10
		 */
		 do_action( 'woocommerce_before_single_product' );

		if ( post_password_required() ) {
			echo get_the_password_form();
			return;
		}
        
	?>
	<?php if ( $fullwidth ) echo '<div class="the4-full pl__30 pr__30">'; elseif ( ! $fullwidth ) echo '<div class="container">'; ?>
	<div id="product-<?php the_ID(); ?>" <?php post_class( 'mt__40 data-featured-product-se' ); ?>>
        <div class="row flex">
            <div class="<?php echo esc_attr($content_class) ?>">
                <div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12 pr mb__30">
						<?php
							/**
							 * woocommerce_before_single_product_summary hook.
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
							add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_sharing', 30 );
						?>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-12 mb__30">
						<div class="summary entry-summary">
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
								do_action( 'woocommerce_single_product_summary' );
								if ( $position == 2 ) {
									woocommerce_output_product_data_tabs();
								}

								if ( $thumb_position == 'outside' ) {
									echo '<div class="kales-thumb-outsite">';
									do_action( 'woocommerce_product_thumbnails' );
									echo '</div>';
								}
							?>
						</div><!-- .summary -->
					</div>
				</div>
			</div>
            <?php if ( 'no-sidebar' != $layout || NULL == $layout ) { ?>
                <div class="sidebar <?php echo esc_attr( $sidebar_class ); ?>">
                    <?php
                    if ( is_active_sidebar( $sidebar ) ) {
                        dynamic_sidebar( $sidebar );
                    }
                    ?>
                </div><!-- .col-md-3 -->
            <?php } ?>
		</div>
        <?php
        if ( $fullwidth ) echo '<div class="container">';
        if ( $position == 2 ) {
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        }
        /**
         * woocommerce_after_single_product_summary hook.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        if ( $fullwidth ) echo '</div>';
        ?>

        <meta itemprop="url" content="<?php the_permalink(); ?>" />
	</div>
</div>
	<?php the4_kalles_sticky_add_to_cart(); ?>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
