<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

$flag_check_gift = false;


do_action( 'woocommerce_before_mini_cart' ); ?>
	<div class="fixcl-scroll">
		<div class="fixcl-scroll-content css_ntbar">
		<?php if ( ! WC()->cart->is_empty() ) : ?>
			<ul class="woocommerce-mini-cart cart_list product_list_widget">
					<?php
						do_action( 'woocommerce_before_mini_cart_contents' );



						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_name      =  $_product->get_name();
								$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('medium'), $cart_item, $cart_item_key );
								$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								 $gift_wrap_id = cs_get_option('wc-giftwrap-product');
								  $is_product_gift_wrap= false;
								 if ($product_id == $gift_wrap_id) {
								 	 $is_product_gift_wrap = true;
								 	 $flag_check_gift = true;
								 }

								?>
								<li class="
										woocommerce-mini-cart-item flex cart__mini-item
										cart-item-<?php echo esc_attr( $product_id ); ?>
										<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>"
									data-cart-item="<?php echo esc_attr( htmlentities( json_encode( array( 'key' => $cart_item_key, 'pid' => $product_id , 'pname' => $product_name ) ) ) ); ?>"
									>
									<div class="ld_cart_bar"></div>
										<a class="mini-cart-pimg" href="<?php echo esc_url( $product_permalink ); ?>">
											<div class="minicart-img-wrapper <?php kalles_image_lazyload_class(); ?>">
												<?php The4Helper::ksesHTML ( $thumbnail ); ?>
											</div>
										</a>
									<div class="mini_cart_info">
										<a href="<?php echo esc_url( $product_permalink ); ?>"
											class="mini_cart_title truncate">
											<?php echo esc_html( $product_name ); ?>
										</a>
										<?php $item_variants = the4_wc_get_varriants($cart_item); ?>

											<div class="mini_cart_meta">
												<?php if (!empty($item_variants)) : ?>
												<p class="cart_meta_variant">
													<?php echo esc_html( $item_variants ); ?>
												</p>
												<?php endif; ?>
												<div class="cart_meta_price">
												<?php
													$bundles       = get_post_meta( $product_id, 'wpa_wcpb', true );
													$bundles_added = explode( ',', ( isset( $cart_item['bundle-products'] ) ? $cart_item['bundle-products'] : '' ) );

													if ( isset( $cart_item['bundle-products'] ) && $cart_item['bundle-products'] ) {

														echo apply_filters( 'woocommerce_widget_cart_item_quantity', wc_price( round( $cart_item['custom-price'], 2 ) ), $cart_item, $cart_item_key );
														} else {
														echo apply_filters( 'woocommerce_widget_cart_item_quantity',  $product_price, $cart_item, $cart_item_key );
													}
												?>
												</div>
											</div>

											<?php
												$max_value = apply_filters( 'woocommerce_quantity_input_max', $_product->get_max_purchase_quantity(), $_product );
												$min_value = apply_filters( 'woocommerce_quantity_input_min', $_product->get_min_purchase_quantity(), $_product );
												$step      = apply_filters( 'woocommerce_quantity_input_step', 1, $_product );

												$max_value = esc_attr( 0 < $max_value ? $max_value : '' );
												$min_value = esc_attr( $min_value );
												$step = esc_attr( $step );
											 ?>
											<div class="add_to_cart_button mini_cart_actions mt__15">
												<?php if (!$is_product_gift_wrap) : ?>
									            <div class="quantity pr mr__10 qty__true">
									               <input type="number"
									               		  id=""
									               		  class="input-text qty text tc qty_cart_js cart__mini-qty--input"
									               		  max="<?php echo esc_attr( $max_value ); ?>"
									               		  min="0"
									               		  step="<?php echo esc_attr( $step ); ?>"
									               		  value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" inputmode="numeric">
									               <div class="qty tc fs__14">
									                <button type="button" class="mini_cart_actions_btn plus db cb pa pd__0 pr__15 tr r__0">
									                	<i class="t4_icon_t4-plus"></i>
									                </button>
									                <button type="button"
									                		class="mini_cart_actions_btn minus allown-input-remove db cb pa pd__0 pl__15 tl l__0
									                			   qty_<?php echo esc_attr( $cart_item['quantity'] ); ?>">
									                	<svg class="dn" viewBox="0 0 24 24">
									                		<use xlink:href="#scl_remove"></use>
									                	</svg><i class="t4_icon_t4-minus"></i>
									                </button>
									              </div>
									            </div> <!-- .quantity -->
									       	 <?php endif; ?>
									            <?php if (!empty($item_variants)) : ?>
										            <a href="javascript:void(0);" rel="nofollow"
										            	data-product_id="<?php echo esc_attr( $product_id ); ?>"
										            	data-cart-item="<?php echo esc_attr( htmlentities($cart_item_key) ); ?>"
										            	class="cart_ac_edit js__qs ttip_nt tooltip_top_right" >
										            	<span class="tt_txt"><?php esc_html_e( 'Edit this item', 'kalles' ) ?></span>
										            	<svg viewBox="0 0 24 24"><use xlink:href="#scl_edit"></use></svg>
										            </a>
									        	<?php endif; ?>
									            <a href="javascript:void(0);" rel="nofollow"
									            	data-prod="<?php echo esc_attr( $product_id ); ?>"
									            	class="cart_ac_remove
									            		<?php if($is_product_gift_wrap) echo 'is_product_gift_wrap'; ?>
									            		js_cart_rem ttip_nt tooltip_top_right">
									            	<span class="tt_txt"><?php esc_html_e( 'Remove this item', 'kalles' ) ?></span>
									            	<svg viewBox="0 0 24 24"><use xlink:href="#scl_remove"></use></svg>
									            </a>
									        </div>


											<?php if ( ! empty( $cart_item['bundle-products'] ) ) : ?>
												<?php
													if ( $bundles ) {
														$custom_variable = $cart_item['bundle-variable'];

														echo '<ul class="product-bundle fr pd__0">';
														foreach( $bundles as $key => $val ) {
															if ( isset($val['product_id']) && in_array( $val['product_id'], $bundles_added ) ) {
																$product_item = wc_get_product( intval( $val['product_id'] ) );
																echo '<li class="pr">';
																	echo '<a href="'. $product_item->get_permalink() .'" title="'. $product_item->get_name() .'">'. $product_item->get_name() .'</a>';
																	// Get variable
																	if ( ! empty( $val['variable'] ) ) {
																		$variable = wp_unslash( $val['variable'] );

																		if ( isset( $custom_variable[$val['product_id']] ) && count( $custom_variable[$val['product_id']] ) > 0 ) {
																			// Custom variable before add produt bundle to cart
																			echo '<span class="db" style="text-transform: capitalize;">';
																				The4Helper::ksesHTML($custom_variable[$val['product_id']]['variable']);
																			echo '</span>';
																		} else {
																			if ( ! empty( $val['variable'] ) ) {
																				foreach ( $val['variable'] as $key => $value ) {
																					echo '<span class="db" style="text-transform: capitalize;">';
																						echo substr( $key, 13 ) . ': ' . $value;
																					echo '</span>';
																				}
																			}
																		}
																	}
																echo '</li>';
															}
														}
														echo '</ul>';
													}
											?>
										<?php endif; ?>
									</div> <!-- mini-cart-info -->

								</li>
								<?php
							}
						}
						do_action( 'woocommerce_mini_cart_contents' );
					?>
			</ul><!-- end product list -->
			<div class="mini_cart_tool js_cart_tool tc ">
				<?php if ( cs_get_option( 'wc-order_note' ) ) : ?>
				<div data-id="note" class="mini_cart_tool_note js_cart_tls ttip_nt tooltip_top">
                    <span class="txt_add_note "><i class="t4_icon_t4-clipboard"></i><span class="tt_txt"><?php esc_html_e( 'Add Order Note.', 'kalles' ) ?></span></span>
                    <span class="txt_edit_note dn"><i class="t4_icon_t4-clipboard"></i><span class="tt_txt"><?php esc_html_e( 'Edit Order Note.', 'kalles' ) ?></span></span>
                </div>
                <?php endif; ?>
                <?php if ( cs_get_option( 'wc-giftwrap' ) ) : ?>
	                <div data-id="gift" class="mini_cart_tool_gift js_cart_tls js_gift_wrap ttip_nt tooltip_top"
	                	<?php if ($flag_check_gift == true) echo 'style="display: none;"'; ?>>
	                	<i class="t4_icon_t4-gift"></i><span class="tt_txt"><?php esc_html_e( 'Add A Gift Wrap.', 'kalles' ) ?></span>
	                </div>
            	<?php endif; ?>
            	<?php if ( cs_get_option( 'wc-estimate-shipping' ) ) : ?>
                <div data-id="ship" class="mini_cart_tool_ship js_cart_tls ttip_nt tooltip_top">
                	<i class="t4_icon_t4-truck"></i><span class="tt_txt"><?php esc_html_e( 'Estimate Shipping.', 'kalles' ) ?></span>
                </div>
                <?php endif; ?>
                <?php if ( cs_get_option( 'wc-coupon' ) ) : ?>
                <div data-id="dis" class="mini_cart_tool_dis js_cart_tls ttip_nt tooltip_top">
                	<i class="t4_icon_t4-tag"></i><span class="tt_txt"><?php esc_html_e( 'Add A Coupon.', 'kalles' ) ?></span>
                </div>
                <?php endif; ?>
            </div>
	<?php endif; ?>
		<div class="empty mini-cart-empty tc <?php if ( !WC()->cart->is_empty() ) : ?> dn <?php endif; ?>">
			<i class="t4_icon_shopping-bag pr mb__10"></i>
			<p> <?php esc_html_e( 'Your cart is empty.', 'kalles' ) ?> </p>
			<p class="return-to-shop mb__15">
				<a class="button button_primary tu js_add_ld" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
					<span class="truncate"><?php esc_html_e( 'Return to Shop.', 'kalles' ) ?></span>
				</a>
			</p>
		</div>

		</div><!-- .fixcl-scroll-content -->
	</div><!-- .fixcl-scroll -->

	<div class="mini_cart_footer <?php if ( WC()->cart->is_empty() ) : ?> dn <?php endif; ?>">

			<?php
			/**
			 * Woocommerce_widget_shopping_cart_total hook.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action( 'woocommerce_widget_shopping_cart_total' );
			?>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
		<?php the4_kalles_minicart_extra_content();?>
		<p class="woocommerce-mini-cart__buttons buttons">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn viewcart wc-forward"><?php esc_html_e( 'View cart', 'kalles' ); ?></a>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn checkout wc-forward"><?php esc_html_e( 'Checkout', 'kalles' ); ?></a>
		</p>
		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

		<?php do_action( 'woocommerce_after_mini_cart' ); ?>

	</div><!-- mini_cart_footer js_cart_footer -->



