<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
<div class="template-cart row mt__30 mb__30">
    <form class="woocommerce-cart-form col-12 col-lg-7 col-xl-8" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <div class="cart_header">
            <div class="row al_center">
                <div class="col-5"><?php echo esc_html__( 'Product', 'kalles' ); ?></div>
                <div class="col-3 tc"><?php echo esc_html__( 'Price', 'kalles' ); ?></div>
                <div class="col-2 tc"><?php echo esc_html__( 'Quantity', 'kalles' ); ?></div>
                <div class="col-2 tr tr_md"><?php echo esc_html__( 'Total', 'kalles' ); ?></div>
            </div>
        </div> <!-- .cart_header -->

        <div class="cart_items cart woocommerce-cart-form__contents">

            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>

                    <?php
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                        if ( $_product && $_product->exists()
                             && $cart_item['quantity'] > 0
                             && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            ?>
                            <div class="cart_item js_cart_item">
                                <div class="row al_center">
                                    <div class="col-12 col-md-12 col-lg-5">
                                        <div class="page_cart_info flex al_center">
                                            <div class="cart-image <?php echo kalles_image_lazyload_class(); ?>">
                                            <?php
                                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                                if ( ! $product_permalink ) {
                                                    echo wp_kses_post( $thumbnail );
                                                } else {
                                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
                                                }
                                            ?>
                                            </div>
                                          <div class="mini_cart_body ml__15">
                                            <h5 class="mini_cart_title mg__0 mb__5">
                                                <?php
                                                    if ( ! $product_permalink ) {
                                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                                    } else {
                                                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                                    }
                                                ?>
                                            </h5>
                                            <?php

                                                // Backorder notification
                                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'kalles' ) . '</p>' ) );

                                                }

                                            ?>
                                            <div class="mini_cart_meta">
                                              <?php
                                                // Meta data
                                                if ( version_compare( WC_VERSION, '3.3.0', '<' ) ) {
                                                    echo WC()->cart->get_item_data( $cart_item );
                                                } else {
                                                    echo wc_get_formatted_cart_item_data( $cart_item );
                                                }
                                               ?>
                                            </div>
                                            <div class="mt__10 product-remove">
                                                <?php
                                                if ( version_compare( WC_VERSION, '3.3.0', '<' ) ) {
                                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                                        '<a href="%s" class="remove cart_ac_remove ttip_nt tooltip_top_right" title="%s" data-product_id="%s" data-product_sku="%s">
                                                            <span class="tt_txt">%s</span>
                                                            <svg viewBox="0 0 24 24">
                                                              <use xlink:href="#scl_remove"></use>
                                                            </svg>
                                                        </a>',
                                                        esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                                                        esc_html__( 'Remove this item', 'kalles' ),
                                                        esc_attr( $product_id ),
                                                        esc_attr( $_product->get_sku() ),
                                                        esc_html__( 'Remove this item', 'kalles' )
                                                    ), $cart_item_key );
                                                } else {
                                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                                        '<a href="%s" class="remove cart_ac_remove ttip_nt tooltip_top_right" title="%s" data-product_id="%s" data-product_sku="%s">
                                                            <span class="tt_txt">%s</span>
                                                            <svg viewBox="0 0 24 24">
                                                              <use xlink:href="#scl_remove"></use>
                                                            </svg>
                                                        </a>',
                                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                        esc_html__( 'Remove this item', 'kalles' ),
                                                        esc_attr( $product_id ),
                                                        esc_attr( $_product->get_sku() ),
                                                        esc_html__( 'Remove this item', 'kalles' )
                                                    ), $cart_item_key );
                                                }

                                                do_action( 'woocommerce_cart_contents' );

                                                ?>
                                            </div>
                                          </div>
                                        </div>

                                        <?php if( class_exists( 'WPA_WCPB' ) ) : ?>
                                            <?php if ( ! empty( $cart_item['bundle-products'] ) ) : ?>
                                                <div class="bundle-products bundle-off-<?php echo esc_attr($product_id);?>">
                                                    <?php
                                                    // Get Custom variable of bundle product
                                                    $custom_variable    = $cart_item['bundle-variable'];
                                                    $bundles            = get_post_meta( $product_id, 'wpa_wcpb', true );
                                                    $bundles_added      = explode( ',', $cart_item['bundle-products'] );
                                                    if ( $bundles ) {
                                                        echo '<h3 class="bundel-heading">'. translate( 'Products bundle', 'kalles' ) .'</h3>';
                                                        echo '<ul class="product-bundle">';
                                                        foreach( $bundles as $key => $val ){
                                                            if ( in_array( $val['product_id'], $bundles_added ) ) {
                                                                $product_item = wc_get_product( intval( $val['product_id'] ) );
                                                                echo '<li class="flex middle-xs">';
                                                                echo '<a href="'. $product_item->get_permalink() .'" title="'. $product_item->get_name() .'">'. $product_item->get_image() .'</a>';
                                                                echo '<div><a href="'. $product_item->get_permalink() .'" title="'. $product_item->get_name() .'">'. $product_item->get_name() .'</a>';

                                                                if ( isset( $custom_variable[$val['product_id']] ) && count( $custom_variable[$val['product_id']] ) > 0 ) {
                                                                    // Custom variable before add produt bundle to cart
                                                                    echo '<span class="db" style="text-transform: capitalize;">';
                                                                        echo wp_kses_post($custom_variable[$val['product_id']]['variable']);
                                                                    echo '</span>';
                                                                } else {
                                                                    // Get variable
                                                                    if ( ! empty( $val['variable'] ) ) {
                                                                        $i = 0;
                                                                        foreach ( $val['variable'] as $key => $value ) { $i++;
                                                                            echo '<span class="db" style="text-transform: capitalize;">';
                                                                                if( $i == count( $val['variable'] ) ) {
                                                                                    echo substr( $key, 13 ) . ': ' . $value;
                                                                                }else {
                                                                                    echo substr( $key, 13 ) . ': ' . $value .' + ';
                                                                                }
                                                                            echo '</span>';
                                                                        }
                                                                    }
                                                                }
                                                                echo '</div></li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    }
                                                ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif ?>
                                    </div> <!-- product name -->

                                    <div class="col-12 col-md-4 col-lg-3 tc__ tc_lg">
                                        <div class="cart_meta_prices product-price">
                                          <?php
                                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                            ?>
                                        </div>
                                    </div> <!-- price -->

                                    <div class="col-12 col-md-4 col-lg-2 tc mini_cart_actions ">
                                        <div class="product-quantity pr qty__true flex fl_center">
                                          <?php
                                                if ( $_product->is_sold_individually() ) {
                                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key ); // PHPCS: XSS ok.
                                                } else {
                                                    $product_quantity = woocommerce_quantity_input( array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                                        'min_value'    => '0',
                                                        'product_name' => $_product->get_name(),
                                                    ), $_product, false );
                                                }

                                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                            ?>
                                        </div>
                                    </div> <!-- quantity -->

                                    <div class="product-subtotal col-12 col-md-4 col-lg-2 tc__ tr_lg">
                                        <?php
                                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                                        ?>
                                    </div>
                                </div>
                            </div> <!-- .cart_item -->
                        <?php
                        }
                        ?>
            <?php endforeach ?>
      </div> <!-- .cart_items -->

      <div class="cart__footer mt__20 mb__20">
        <div class="row">
            <div class="col-12 col-md-9 actions tl_md tc order-md-2 order-4">
                <?php if ( wc_coupons_enabled() ) { ?>
                    <div class="coupon flex middle-xs wrap">

                        <label class="dn_xs" for="coupon_code"><?php esc_html_e( 'Coupon:', 'kalles' ); ?></label> <input type="text" name="coupon_code" class="input-text br__40" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'kalles' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'kalles' ); ?>"><?php esc_html_e( 'Apply coupon', 'kalles' ); ?></button>

                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-12 tr_md tc order-md-4 order-2 col-md-3">
                <div class="cart-actions flex fl_right">
                    <button type="submit" class="button update-cart" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'kalles' ); ?>"><?php esc_html_e( 'Update Cart', 'kalles' ); ?></button>

                    <?php do_action( 'woocommerce_cart_actions' ); ?>

                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>


            </div>
        </div>
      </div> <!-- .cart__footer -->

        <?php do_action( 'woocommerce_after_cart_table' ); ?>

    </form>

    <div class="cart-collaterals-wrap col-12 col-lg-5 col-xl-4 pt__20">
        <div class="cart-collaterals">

            <?php
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cart_totals - 10
                 */
                remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

                do_action( 'woocommerce_cart_collaterals' );
            ?>


        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php do_action( 'woocommerce_after_cart' ); ?>
    </div>
</div>