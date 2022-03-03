<?php
/**
 * Discount rule for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */

namespace The4Addon;

use  WC_Product ;

defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Woocommerce_Discount_PriceManager  {


    /**
     * Return fixed price rules or empty array if not exist rules
     *
     * @param $product_id
     * @param string $context
     *
     * @return array
     */
    public static function getFixedPriceRules( $product_id, $context = 'view' ) {
        return self::getPriceRules( $product_id, 'fixed', $context );
    }

    /**
     * Return percentage price rules or empty array if not exist rules
     *
     * @param $product_id
     * @param string $context
     *
     * @return array
     */
    public static function getPercentagePriceRules( $product_id, $context = 'view' ) {
        return self::getPriceRules( $product_id, 'percentage', $context );
    }

    /**
     * Return label rule
     *
     * @param $product_id
     * @param string $context
     *
     * @return string
     */
    public static function getLabelPriceRules( $product_id, $context = 'view' ) {
        $label =  get_post_meta( $product_id, '_fixed_price_label', true ) ? get_post_meta( $product_id, '_fixed_price_label', true ) : '[qty] item get [off] OFF';
        return $label;
    }

    /**
     * Update price rules
     *
     * @param array $amounts
     * @param array $prices
     * @param int $product_id
     */
    public static function updatePriceRules( $type, $label, $qty, $val, $product_id ) {
        $rules = array();

        $count = count( $qty ) > count( $val ) ? count( $qty ) : count( $val );

        for( $i = 0; $i < $count; $i++ ) {
            //$rules[$i]['']
        }
        foreach ( $qty as $key => $amount ) {
            if ( ! empty( $amount ) && ! empty( $val[ $key ] ) && ! key_exists( $amount, $rules ) ) {
                $rules[ $amount ] = wc_format_decimal( $val[ $key ] );
            }
        }

        if ( $type == 'fixed' ) {
            update_post_meta( $product_id, '_fixed_price_rules', $rules );
        } else {
            update_post_meta( $product_id, '_percentage_price_rules', $rules );
        }
        
        update_post_meta( $product_id, '_fixed_price_type', $type );
        update_post_meta( $product_id, '_fixed_price_label', $label );
    }

    /**
     * Get pricing type of product. Available: fixed or percentage
     *
     * @param int $product_id
     * @param string $default
     * @param string $context
     *
     * @return string
     */
    public static function getPricingType( $product_id, $default = 'fixed', $context = 'view' ) {

        $type = get_post_meta( $product_id, '_fixed_price_type', true );

        if ( 'view' === $context && self::variationHasNoOwnRules( $product_id ) ) {
            $product = wc_get_product( $product_id );

            $type = get_post_meta( $product->get_parent_id(), '_fixed_price_type', true );
        }

        $type = in_array( $type, array( 'fixed', 'percentage' ) ) ? $type : $default;

        if ( $context != 'edit' ) {

        }

        return $type;
    }

    /**
     * Get product pricing rules
     *
     * @param int $product_id
     * @param bool $type
     * @param string $context
     *
     * @return array
     */
    public static function getPriceRules( $product_id, $type = false, $context = 'view' ) {
        $type = $type ? $type : self::getPricingType( $product_id, 'fixed', $context );

        if ( 'fixed' === $type ) {
            $rules = get_post_meta( $product_id, '_fixed_price_rules', true );
        } else {
            $rules = get_post_meta( $product_id, '_percentage_price_rules', true );
        }

        $parent_id = $product_id;

        // If no rules for variation check for product level rules.
        if ( 'edit' !== $context && self::variationHasNoOwnRules( $product_id, $rules ) ) {

            $product = wc_get_product( $product_id );

            $parent_id = $product->get_parent_id();

            $type = self::getPricingType( $parent_id );

            if ( 'fixed' === $type ) {
                $rules = get_post_meta( $parent_id, '_fixed_price_rules', true );
            } else {
                $rules = get_post_meta( $parent_id, '_percentage_price_rules', true );
            }
        }

        $rules = ! empty( $rules ) ? $rules : array();

        ksort( $rules );

        if ( $context != 'edit' ) {
            
        }

        return $rules;
    }

    /**
     * Get price by product quantity
     *
     * @param int $quantity
     * @param int $product_id
     * @param string $context
     * @param string $place
     *
     * @return bool|float|int
     */
    public static function getPriceByRules( $quantity, $product_id, $context = 'view', $place = 'shop' ) {

        $rules = self::getPriceRules( $product_id, false, $context );
        
        $type = self::getPricingType( $product_id );

        if ( 'fixed' === $type ) {
            foreach ( array_reverse( $rules, true ) as $_amount => $price ) {
                if ( $_amount <= $quantity ) {

                    $product_price = $price;

                    if ( 'view' === $context ) {
                        $product = wc_get_product( $product_id );

                        $product_price = self::getPriceWithTaxes( $product_price, $product, $place );
                    }

                    break;
                }
            }
        }

        if ( 'percentage' === $type ) {
            $product = wc_get_product( $product_id );

            foreach ( array_reverse( $rules, true ) as $_amount => $percentDiscount ) {
                if ( $_amount <= $quantity ) {

                    $product_price = self::getPriceByPercentDiscount( $product->get_price(), $percentDiscount );

                    if ( 'view' === $context ) {

                        $product = wc_get_product( $product_id );

                        $product_price = self::getPriceWithTaxes( $product_price, $product, $place );

                    }

                    break;
                }
            }
        }

        $product_price = isset( $product_price ) ? $product_price : false;

        return apply_filters( 't4_discount_qty/price/price_by_rules', $product_price, $quantity, $product_id );
    }

    /**
     * Calculate displayed price depend on taxes
     *
     * @param float $price
     * @param WC_Product $product
     * @param string $place
     *
     * @return float
     */
    public static function getPriceWithTaxes( $price, $product, $place = 'shop' ) {

        if ( wc_tax_enabled() ) {

            if ( 'cart' === $place ) {
                $price = 'incl' === get_option( 'woocommerce_tax_display_cart' ) ?

                    wc_get_price_including_tax( $product, array(
                            'qty'   => 1,
                            'price' => $price
                        )
                    ) :

                    wc_get_price_excluding_tax( $product, array(
                            'qty'   => 1,
                            'price' => $price
                        )
                    );
            } else {
                $price = wc_get_price_to_display( $product, array(
                    'price' => $price,
                    'qty'   => 1,
                ) );
            }
        }

        return $price;
    }

    /**
     * Calculate price using percentage discount
     *
     * @param float|int $price
     * @param float|int $discount
     *
     * @return bool|float|int
     */
    public static function getPriceByPercentDiscount( $price, $discount ) {
        if ( $price > 0 && $discount <= 100 ) {
            $discount_amount = ( $price / 100 ) * $discount;

            return $price - $discount_amount;
        }

        return false;
    }

    /**
     * Check if variation has no own rules
     *
     * @param int $product_id
     * @param bool $rules
     *
     * @return bool
     */
    protected static function variationHasNoOwnRules( $product_id, $rules = false ) {

        $rules = $rules ? $rules : self::getPriceRules( $product_id, false, 'edit' );

        if ( empty( $rules ) ) {

            $product = wc_get_product( $product_id );

            return $product->is_type( 'variation' );
        }

        return false;
    }
}