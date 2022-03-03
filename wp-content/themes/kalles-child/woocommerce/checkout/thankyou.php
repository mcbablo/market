<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$order_details = the4_woo_get_order_details( $order );
$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));

?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'kalles' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'kalles' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'kalles' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
			<div class="kalles-thankyou-page containner">
				<div class="row mb__30">
					<div class="kalles-thankyou-page__header col-12 flex fl_left">
						<div class="kalles-thankyou__icon">
							<i class="t4_icon_t4-check-circle"></i>
						</div>
						<div class="kalles-thankyou__message">
							<h3 class="message-number">
								<?php esc_html_e('Order', 'kalles'); ?> №<?php echo esc_html( $order_details['order_number'] ); ?>
							</h3>
							<p class="message-thankyou">
								<?php
									$thankyou_messager = cs_get_option('wc_checkout_thankyou_message');
									$thankyou_messager = str_replace('{first_name}', $order_details['billing_first_name'], $thankyou_messager);
									$thankyou_messager = str_replace('{last_name}', $order_details['billing_last_name'], $thankyou_messager);
								  ?>
								<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $thankyou_messager ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</p>
						</div>
					</div>
				</div>

				<?php do_action('kalles_thankyou_before_body', $order ); ?>

				<div class="row kalles-thankyou-page__body">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="row">
							<div class="col-12">
								<h3 class="body__confirmation--title"><?php esc_html_e('Order confirmation', 'kalles'); ?></h3>
								<div class="body__confirmation--body">
									<div class="body__item">
										<div class="body__item--title">
											<div><?php esc_html_e('Order number', 'kalles'); ?></div>
										</div>
										<div class="body__item--content">
											<div><?php echo esc_html( $order_details['order_number']); ?></div>
										</div>
									</div>
									<div class="body__item">
										<div class="body__item--title">
											<div><?php esc_html_e('Date', 'kalles'); ?></div>
										</div>
										<div class="body__item--content">
											<div><?php echo esc_html( $order_details['order_date']); ?></div>
										</div>
									</div>
									<div class="body__item">
										<div class="body__item--title">
											<div><?php esc_html_e('Total', 'kalles'); ?></div>
										</div>
										<div class="body__item--content">
											<div><?php The4Helper::ksesHTML( $order_details['order_total']); ?></div>
										</div>
									</div>
									<div class="body__item">
										<div class="body__item--title">
											<div><?php esc_html_e('Payment method', 'kalles'); ?></div>
										</div>
										<div class="body__item--content">
											<div><?php echo esc_html( $order_details['payment_method']); ?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt__30">
							<div class="col-12">
								<h3 class="body__confirmation--title"><?php esc_html_e('Custommer info', 'kalles'); ?></h3>
								<div class="body__body__confirmation--body">
									<?php $show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address(); ?>

									<h3 class="body__custommer-title body__confirmation--title"><?php esc_html_e( 'Billing address', 'kalles' ); ?></h3>

									<address>
										<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'kalles' ) ) ); ?>

										<?php if ( $order->get_billing_phone() ) : ?>
											<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
										<?php endif; ?>

										<?php if ( $order->get_billing_email() ) : ?>
											<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
										<?php endif; ?>
									</address>

									<?php if ( $show_shipping ) : ?>
										<h3 class="body__custommer-title body__confirmation--title"><?php esc_html_e( 'Shipping address', 'kalles' ); ?></h3>
										<address>
											<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'kalles' ) ) ); ?>
										</address>
									<?php endif; ?>

									<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-7 col-12 thankyou-body__details">
						<h3 class="body__confirmation--title"><?php esc_html_e('Order details', 'kalles'); ?></h3>
						<div class="body__confirmation--body">
							<div class="body__details--item title">
								<div class="body__details--left">
									<?php esc_html_e('Product', 'kalles'); ?>
								</div>
								<div class="body__details--right">
									<?php esc_html_e('Total', 'kalles'); ?>
								</div>
							</div>
							<?php
                                foreach ($order_items as $item_id => $item) {
                                    $product = $item->get_product();
                                    if (! $product ) {
                                        continue;
                                    }
                                    $product_name = $item->get_name();
                                    $purchase_note = $product->get_purchase_note();
                                    $is_visible = $product && $product->is_visible();
                                    $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                                    $product_image_src = wc_placeholder_img_src('thumbnail');

                                    $alt = '';
                                    $product_quantity_html = ' <strong class="product-quantity">' . sprintf('&times; %s', $item->get_quantity()) . '</strong>';

                                    if ( $product->get_image_id() ) {
                                        $product_image_src = wp_get_attachment_thumb_url($product->get_image_id());
                                        $alt = get_post_meta($product->get_id(), '_wp_attachment_image_alt', true);
                                    }


                             ?>
								<div class="body__details--item">
									<div class="body__details--left">
										<div class="body__details--product_image">
											<a href="<?php echo esc_url($product_permalink); ?>" alt="<?php echo esc_attr( $product_name ); ?>">
												<img src="<?php echo $product_image_src; ?>" alt="<?php echo esc_attr( $alt ); ?>">
											</a>
										</div>
										<div class="body__details--product_name">
											<div>
												<?php echo esc_html( $product_name ); ?>
												<?php  echo apply_filters('woocommerce_order_item_quantity_html', $product_quantity_html, $item); ?>
											</div>
											<?php
		                                        do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);

		                                        wc_display_item_meta($item);

		                                        do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
		                                    ?>
										</div>
									</div>
									<div class="body__details--right">
										<?php echo $order->get_formatted_line_subtotal($item); ?>
									</div>
								</div>

							<?php } ?>
							<div class="body__details--item subtotal">
								<div class="body__details--left">
									<?php esc_html_e('Subtotal', 'kalles'); ?>
								</div>
								<div class="body__details--right">
									<?php The4Helper::ksesHTML( $order_details['order_subtotal']); ?>
								</div>
							</div>
							<div class="body__details--item payment-method">
								<div class="body__details--left">
									<?php esc_html_e('Payment method', 'kalles'); ?>
								</div>
								<div class="body__details--right">
									<?php echo esc_html( $order_details['payment_method']); ?>
								</div>
							</div>
							<div class="body__details--item total">
								<div class="body__details--left">
									<?php esc_html_e('Total', 'kalles'); ?>
								</div>
								<div class="body__details--right">
									<div><?php echo get_woocommerce_currency(); ?></div>
									<?php The4Helper::ksesHTML( $order_details['order_total']); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php remove_action('woocommerce_thankyou', 'woocommerce_order_details_table'); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'kalles' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
