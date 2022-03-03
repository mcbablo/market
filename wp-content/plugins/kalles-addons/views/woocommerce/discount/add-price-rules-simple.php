<?php defined( 'ABSPATH' ) || exit('No direct script access allowed'); ?>


<script>
    jQuery(document).ready(function ($) {
        $('[data-t4-price-type-select]').on('change', function () {
            $('[data-t4-price-type]').css('display', 'none');
            $('[data-t4-price-type-' + this.value + ']').css('display', 'block');
        });
    });
</script>

<p class="form-field">
    <label for="t4-price-discount-label"><?php _e( "Discount label", 'kalles' ); ?></label>
    <input type="text" placeholder="<?php _e( 'Label', 'kalles' ); ?>"
            value="<?php echo $label ?>"
            style="width: 50%"
            class="t4_discount_input label" name="t4_price_fixed_label">
</p>

<p class="form-field">
    <label for="t4-price-type-select"><?php _e( "Discount pricing type", 'kalles' ); ?></label>
    <select name="t4_price_rules_type_<?php echo $prefix?>" id="t4-price-type-select" style="width: 50%"
            data-t4-price-type-select>
        <option value="fixed" <?php selected( 'fixed', $type ); ?>><?php _e( 'Fixed','kalles' ); ?></option>
        <option value="percentage" <?php selected( 'percentage', $type ); ?>><?php _e( 'Percentage','kalles' ); ?></option>
    </select>
</p>

<p class="form-field <?php echo $type === 'percentage' ? 'hidden' : ''; ?>" data-t4-price-type-fixed
   data-t4-price-type>
    <label><?php _e( "Discount price rule", 'kalles' ); ?></label>
    <span data-price-rules-wrapper>
        <?php if ( ! empty( $price_rules_fixed ) ): ?>
            <?php foreach ( $price_rules_fixed as $amount => $price ): ?>
                <span data-price-rules-container>
                    <span data-price-rules-input-wrapper>
                        <input type="number" min="2" 
                                value="<?php echo $amount; ?>"
                                placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                                class="price-quantity-rule t4_discount_input quantity" name="t4_price_fixed_quantity_<?php echo $prefix?>[]">
                        <input type="text" placeholder="<?php _e( 'Price', 'kalles' ); ?>"
                                value="<?php echo wc_format_localized_price( $price ); ?>"
                               class="wc_input_price  t4_discount_input price" 
                               name="t4_price_fixed_price_<?php echo $prefix?>[]">
                    </span>
                    <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
                    <br>
                    <br>
                </span>
            <?php endforeach; ?>
        <?php endif; ?>
                 
        <span data-price-rules-container>
            <span data-price-rules-input-wrapper>
                <input type="number" min="2" placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                       class="price-quantity-rule t4_discount_input quantity" name="t4_price_fixed_quantity_<?php echo $prefix?>[]">
                <input type="text" placeholder="<?php _e( 'Price', 'kalles' ); ?>"
                       class="wc_input_price  t4_discount_input price" name="t4_price_fixed_price_<?php echo $prefix?>[]">
            </span>
            <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
            <br>
            <br>
        </span>
    <button class="button add_price_rule"><?php _e( 'New rule', 'kalles' ); ?></button>
    </span>
</p>

<p class="form-field <?php echo $type === 'fixed' ? 'hidden' : ''; ?>" data-t4-price-type-percentage
   data-t4-price-type>
    <label><?php _e( "Discount price rule", 'kalles' ); ?></label>
    <span data-price-rules-wrapper>
        <?php if ( ! empty( $price_rules_percentage ) ): ?>
            <?php foreach ( $price_rules_percentage as $amount => $discount ): ?>
                <span data-price-rules-container>
                    <span data-price-rules-input-wrapper>
                        <input type="number" min="2" placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                                value="<?php echo $amount; ?>"
                               class="price-quantity-rule t4_discount_input quantity" name="t4_price_percent_quantity_<?php echo $prefix?>[]">
                        <input type="number" value="<?php echo $discount; ?>" max="99" placeholder="<?php _e( 'Percent discount', 'kalles' ); ?>"
                               class="t4_discount_input price" name="t4_price_percent_discount_<?php echo $prefix?>[]" step="any">
                    </span>
                    <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
                    <br>
                    <br>
                </span>
            <?php endforeach; ?>
        <?php endif; ?>

        <span data-price-rules-container>
            <span data-price-rules-input-wrapper>
                <input type="number" min="2" placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                       class="price-quantity-rule t4_discount_input quantity" name="t4_price_percent_quantity_<?php echo $prefix?>[]">
                <input type="number" max="99" placeholder="<?php _e( 'Percent discount', 'kalles' ); ?>"
                       class="t4_discount_input price" name="t4_price_percent_discount_<?php echo $prefix?>[]" step="any">
            </span>
            <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
            <br>
            <br>
        </span>
    <button class="button add_price_rule"><?php _e( 'New rule', 'kalles' ); ?></button>

    </span>
</p>