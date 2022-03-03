<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.6.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details row ">
	<div class="col-12 col-lg-6 col-md-12">
		<h3 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'kalles' ); ?></h3>

		<address>
			<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'kalles' ) ) ); ?>

			<?php if ( $order->get_billing_phone() ) : ?>
				<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
			<?php endif; ?>

			<?php if ( $order->get_billing_email() ) : ?>
				<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
			<?php endif; ?>
		</address>
	</div>
	<?php if ( $show_shipping ) : ?>
		<div class="col-12 col-lg-6 col-md-12">
			<h3 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'kalles' ); ?></h3>
			<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'kalles' ) ) ); ?>
			</address>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
