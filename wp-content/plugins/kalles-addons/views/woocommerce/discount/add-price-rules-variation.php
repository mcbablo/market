<?php defined( 'ABSPATH' ) || exit('No direct script access allowed'); ?>


<script>
    jQuery(document).on('woocommerce_variations_loaded', function ($) {
        jQuery('[data-t4-price-type-select]').on('change', function () {
            var $wrapper = jQuery(this).closest('.woocommerce_variation');
            $wrapper.find('[data-t4-price-type]').css('display', 'none');
            $wrapper.find('[data-t4-price-type-' + this.value + ']').css('display', 'block');
        });
    });
</script>

<p class="form-field form-row">
    <label for="t4-price-discount-label"><?php _e( "Discount label", 'kalles' ); ?></label>
    <br />
    <input type="text" placeholder="<?php _e( 'Label', 'kalles' ); ?>"
            value="<?php echo $label ?>"
            class="t4_discount_input label" name="t4_price_fixed_label[<?php echo $i; ?>]">
</p>

<p class="form-field form-row">
    <label for="t4-price-type-select"><?php _e( "Discount pricing type", 'kalles' ); ?></label>
    <br />
    <select name="t4_price_rules_type[<?php echo $i; ?>]" id="t4-price-type-select" style="width: 48%"
            data-t4-price-type-select>
        <option value="fixed" <?php selected( 'fixed', $type ); ?>><?php _e( 'Fixed','kalles' ); ?></option>
        <option value="percentage" <?php selected( 'percentage', $type ); ?>><?php _e( 'Percentage','kalles' ); ?></option>
    </select>
</p>



<p class="form-field form-row <?php echo $type === 'percentage' ? 'hidden' : ''; ?>" data-t4-price-type-fixed
   data-t4-price-type>
    <label><?php _e( "Discount price rule", 'kalles' ); ?></label>
    <br />
    <span data-price-rules-wrapper>

        <?php $j = 0; ?>

        <?php if ( ! empty( $price_rules_fixed ) ): ?>
            <?php foreach ( $price_rules_fixed as $amount => $price ): ?>
                <span data-price-rules-container>
                    <span data-price-rules-input-wrapper>
                        <input type="number" min="2" 
                                value="<?php echo $amount; ?>"
                                placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                                class="price-quantity-rule-variation t4_discount_input quantity" 
                                name="t4_price_fixed_quantity[<?php echo $i; ?>][<?php echo $j; ?>]">
                        <input type="text" placeholder="<?php _e( 'Price', 'kalles' ); ?>"
                                value="<?php echo wc_format_localized_price( $price ); ?>"
                               class="wc_input_price price-quantity-rule--variation  t4_discount_input price" 
                               name="t4_price_fixed_price[<?php echo $i; ?>][<?php echo $j; ?>]">
                    </span>
                    <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
                    <br>
                    <br>
                </span>

                <?php $j++; ?>

            <?php endforeach; ?>
        <?php endif; ?>
                 
        <span data-price-rules-container>
            <span data-price-rules-input-wrapper>
                <input type="number" min="2" placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                       class="price-quantity-rule-variation t4_discount_input quantity" name="t4_price_fixed_quantity[<?php echo $i; ?>][<?php echo $j; ?>]">
                <input type="text" placeholder="<?php _e( 'Price', 'kalles' ); ?>"
                       class="wc_input_price  t4_discount_input price" name="t4_price_fixed_price[<?php echo $i; ?>][<?php echo $j; ?>]">
            </span>
            <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
            <br>
            <br>
        </span>
    <button class="button add_price_rule"><?php _e( 'New rule', 'kalles' ); ?></button>
    </span>
</p>

<p class="form-field form-row <?php echo $type === 'fixed' ? 'hidden' : ''; ?>" data-t4-price-type-percentage
   data-t4-price-type>
    <label><?php _e( "Discount price rule", 'kalles' ); ?></label>
    <br />
    <span data-price-rules-wrapper>

        <?php $k = 0; ?>

        <?php if ( ! empty( $price_rules_percentage ) ): ?>
            <?php foreach ( $price_rules_percentage as $amount => $discount ): ?>
                <span data-price-rules-container>
                    <span data-price-rules-input-wrapper>
                        <input type="number" min="2" placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                                value="<?php echo $amount; ?>"
                               class="price-quantity-rule-variation t4_discount_input quantity" name="t4_price_percent_quantity[<?php echo $i; ?>][<?php echo $k; ?>]">
                        <input type="number" value="<?php echo $discount; ?>" max="99" placeholder="<?php _e( 'Percent discount', 'kalles' ); ?>"
                               class="t4_discount_input price" name="t4_price_percent_discount[<?php echo $i; ?>][<?php echo $k; ?>]" step="any">
                    </span>
                    <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
                    <br>
                    <br>
                </span>

                <?php $k++; ?>

            <?php endforeach; ?>
        <?php endif; ?>

        <span data-price-rules-container>
            <span data-price-rules-input-wrapper>
                <input type="number" min="2" placeholder="<?php _e( 'Quantity', 'kalles' ); ?>"
                       class="price-quantity-rule-variation t4_discount_input quantity" name="t4_price_percent_quantity[<?php echo $i; ?>][<?php echo $j; ?>]">
                <input type="number" max="99" placeholder="<?php _e( 'Percent discount', 'kalles' ); ?>"
                       class="t4_discount_input price" name="t4_price_percent_discount[<?php echo $i; ?>][<?php echo $j; ?>]" step="any">
            </span>
            <span class="notice-dismiss remove-price-rule" data-remove-price-rule></span>
            <br>
            <br>
        </span>
    <button class="button add_price_rule"><?php _e( 'New rule', 'kalles' ); ?></button>

    </span>
</p>