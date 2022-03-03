<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

$ajax_btn = get_option( 'woocommerce_enable_ajax_add_to_cart_single' );
$redirect = get_option( 'woocommerce_cart_redirect_after_add' );

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' <?php echo apply_filters('kalles-add-to-cart-attr', ''); ?>>
		<div class="in_flex column w__100">
			<div class="flex wrap">
				<?php
					/**
					 * @since 2.1.0.
					 */
					do_action( 'woocommerce_before_add_to_cart_button' );

					/**
					 * @since 3.0.0.
					 */
					do_action( 'woocommerce_before_add_to_cart_quantity' );

					woocommerce_quantity_input( array(
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
						'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
					) );

					/**
					 * @since 3.0.0.
					 */
					do_action( 'woocommerce_after_add_to_cart_quantity' );
				?>

				<?php if ( $ajax_btn == 'no' || $redirect == 'yes' ) { ?>
					<button type="submit" name="add-to-cart"  value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt order-4 w__100 mt__20"><span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span></button>
				<?php } else { ?>
					<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
					<button type="submit" data-quantity="" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button order-4 w__100 mt__20 alt pr"
						<?php if (!empty(cs_get_option('wc-summary_btn_effect'))) : ?> 
						data-ani="<?php echo esc_attr( cs_get_option('wc-summary_btn_effect') ); ?>"
						data-time="<?php echo esc_attr( cs_get_option('wc-summary_btn_effect_time') ); ?>
						<?php endif; ?>
						"><span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span></button>
				<?php } ?>

				<?php
					/**
					 * @since 2.1.0.
					 */
					do_action( 'woocommerce_after_add_to_cart_button' );
				?>
			</div>
		</div>
		<?php do_action( 't4_woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
