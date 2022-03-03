<?php
/**
 * Fixed discount view
 **/

defined( 'ABSPATH' ) || exit('No direct script access allowed');

?>
<div class="t4-discount-by-qty mt__20">
    <h3 class="t4-discount-by-qty__label">
        <?php esc_html_e('Buy more save more !', 'kalles') ?>
    </h3>
    <div class="t4-discount-by-qty__items">
        <?php if ( ! empty( $price_rules ) ) : ?>

            <?php $iterator = new ArrayIterator( $price_rules ); ?>

            <?php while( $iterator->valid() ) : ?>

                <?php 
                    $product = wc_get_product( $product_id );

                    $current_price = $iterator->current();
                    $regular_price = wc_get_price_to_display( $product );

                    $current_qty = $iterator->key();
                    $iterator->next();

                    if ( $iterator->valid() ) {
                        $quantity = $current_qty;

                        if ( intval( $iterator->key() - 1 != $current_qty ) ) {
                            $quantity = number_format_i18n( $quantity ) . ' - ' . number_format_i18n( intval( $iterator->key() - 1 ) );
                        }
                    } else {
                        $quantity = number_format_i18n( $current_qty ) . '+';
                    }

                    if ( $type == 'fixed' ) {

                        $discount_price = $regular_price - $current_price;

                        $discount_price_html = wp_kses_post( wc_price( wc_get_price_to_display( $product,
                            array(
                                'price' => $discount_price,
                            ) ) ) );
                    } else {
                        $discount_price = $regular_price - ( $regular_price * $current_price / 100 );

                        $discount_price_html = $current_price . '%';
                    }
                    

                    $label_html = str_replace( '[qty]', $current_qty, $label );
                    $label_html = str_replace( '[off]', $discount_price_html, $label_html );

                 ?>
                <?php if ( $type == 'fixed' ) : ?>
                    <?php if ( $regular_price > $current_price ) : ?>
                        <div class="t4-discount-by-qty__item">
                            <div class="t4-discount-by-qty__item-left">
                                <span class="item__discount"> 
                                    <?php echo $discount_price_html; ?> <?php esc_html_e('OFF', 'kalles') ?>
                                </span>
                                <span class="item__text">
                                    <span><?php echo $label_html; ?></span>
                                    <span class="item__text--product"><?php esc_html_e('on each product', 'kalles'); ?></span>
                                </span>
                            </div>
                            <button type="button" data-quantity="<?php echo $current_qty; ?>" 
                                    data-product_id="<?php echo $product_id; ?>" 
                                    class="t4_discount_qty_btn_add button pr">
                                    <span><?php esc_html_e( 'Add', 'kalles' ); ?></span>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="t4-discount-by-qty__item">
                        <div class="t4-discount-by-qty__item-left">
                            <span class="item__discount">
                                <?php echo $discount_price_html; ?> <?php esc_html_e('OFF', 'kalles') ?>
                            </span>
                            <span class="item__text">
                                <span><?php echo $label_html; ?></span>
                                <span class="item__text--product"><?php esc_html_e('on each product', 'kalles'); ?></span>
                            </span>
                        </div>
                        <button type="button" data-quantity="<?php echo $current_qty; ?>" 
                                data-product_id="<?php echo $product_id; ?>" 
                                class="t4_discount_qty_btn_add button pr">
                                <span><?php esc_html_e( 'Add', 'kalles' ); ?></span>
                        </button>
                        </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>