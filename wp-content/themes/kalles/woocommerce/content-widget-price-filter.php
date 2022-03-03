<?php
/**
 * The template for displaying product price filter widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-price-filter.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.1
 */

defined( 'ABSPATH' ) || exit;

?>
<?php do_action( 'woocommerce_widget_price_filter_start', $args ); ?>
<?php if ( $filter_type == 'list' ) : ?>
	<div class="col-12 col-md-3 widget_price_filter">
		<h5 class="widget-title"><?php echo translate( 'By Price', 'kalles' ); ?></h5>

		<form method="get" action="<?php echo esc_url( $form_action ); ?>">
			<div class="price_slider_wrapper">
				<div class="price_slider" style="display:none;"></div>
				<div class="price_slider_amount" data-step="<?php echo esc_attr( $step ); ?>">
					<input type="text" id="min_price" name="min_price" value="<?php echo esc_attr( $current_min_price ); ?>" data-min="<?php echo esc_attr( $min_price ); ?>" placeholder="<?php echo esc_attr__( 'Min price', 'kalles' ); ?>" />
					<input type="text" id="max_price" name="max_price" value="<?php echo esc_attr( $current_max_price ); ?>" data-max="<?php echo esc_attr( $max_price ); ?>" placeholder="<?php echo esc_attr__( 'Max price', 'kalles' ); ?>" />
					<?php /* translators: Filter: verb "to filter" */ ?>
					<div class="price_label" style="display:none;">
						<?php echo esc_html__( 'Price:', 'kalles' ); ?> <span class="from"></span> &mdash; <span class="to"></span>
					</div>
					<button type="submit" class="button"><?php echo esc_html__( 'Filter', 'kalles' ); ?></button>

					<?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>

					<div class="clear"></div>
				</div>
			</div>
		</form>
	</div>
<?php else : ?>
	<div class="col-12 col-md-3 widget_price_filter filter-dropdown pr">
		<div class="filter-dropdown__title pr flex">
			<span class="filter-dropdown__text"><?php echo translate( 'Price', 'kalles' ); ?></span></ul>
		</div>
		<div class="filter-dropdown__dropdown dn">
			<div class="filter-dropdown__content dropdown">
				<form method="get" action="<?php echo esc_url( $form_action ); ?>">
					<div class="price_slider_wrapper">
						<div class="price_slider" style="display:none;"></div>
						<div class="price_slider_amount" data-step="<?php echo esc_attr( $step ); ?>">
							<input type="text" id="min_price" name="min_price" value="<?php echo esc_attr( $current_min_price ); ?>" data-min="<?php echo esc_attr( $min_price ); ?>" placeholder="<?php echo esc_attr__( 'Min price', 'kalles' ); ?>" />
							<input type="text" id="max_price" name="max_price" value="<?php echo esc_attr( $current_max_price ); ?>" data-max="<?php echo esc_attr( $max_price ); ?>" placeholder="<?php echo esc_attr__( 'Max price', 'kalles' ); ?>" />
							<?php /* translators: Filter: verb "to filter" */ ?>
							<div class="price_label" style="display:none;">
								<?php echo esc_html__( 'Price:', 'kalles' ); ?> <span class="from"></span> &mdash; <span class="to"></span>
							</div>
							<button type="submit" class="button"><?php echo esc_html__( 'Filter', 'kalles' ); ?></button>

							<?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>

							<div class="clear"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_widget_price_filter_end', $args ); ?>
