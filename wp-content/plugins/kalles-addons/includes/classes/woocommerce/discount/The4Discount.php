<?php
/**
 * Discount rule for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */

namespace The4Addon;

require KALLES_ADDONS_CLASS_PATH . 'woocommerce/discount/PriceManager.php';

use  WC_Product ;
use The4Addon\The4_Woocommerce_Discount_PriceManager;

defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Woocommerce_Discount  {

    /**
     * Construct
     */

    public function __construct()
    {

        /*
        *
        * BACCKEND
        * 
        */
       
        // Simple Product
        add_action( 'woocommerce_product_options_pricing', array( $this, 'renderPriceRulesSimple' ) );
        add_action( 'woocommerce_process_product_meta', array( $this, 'updatePriceRules' ) );

        // Variation Product
        add_action( 'woocommerce_variation_options_pricing',[ $this, 'renderPriceRulesVariation' ],10,3);
        add_action( 'woocommerce_save_product_variation',[ $this, 'updatePriceRulesVariation' ],10,3);

        /*
        *
        * CART
        * 
        */
        add_action( 'woocommerce_before_calculate_totals', [ $this, 'calculateTotals' ], 99, 3 );
        add_filter( 'woocommerce_cart_item_price', [ $this, 'calculateItemPrice' ], 10, 2 );
        add_action( 'woocommerce_before_mini_cart_contents', [ $this, 'miniCartSubTotal' ], 10, 3 );

        /*
        *
        * FRONTEND
        * 
        */
        
        add_action( 't4_woocommerce_after_add_to_cart_button', [ $this, 'displayPricingTable' ], -999 );
        add_action( 'wc_ajax_get_t4_discount_price_variation', [ $this, 'getPriceDisplayVariation' ], 10, 1 );

    }

    /**
     * Render inputs for price rules on a simple product
     *
     * @global WC_Product $product_object
     */
    public static function renderPriceRulesSimple() {
        global  $product_object ;

        if ( $product_object instanceof WC_Product ) {

            self::getTemplate( 
                'add-price-rules-simple', 
                array(
                    'prefix' => 'simple',
                    'label' => The4_Woocommerce_Discount_PriceManager::getLabelPriceRules( $product_object->get_id() ),
                    'type' => The4_Woocommerce_Discount_PriceManager::getPricingType( $product_object->get_id() ),
                    'price_rules_fixed'      => The4_Woocommerce_Discount_PriceManager::getFixedPriceRules( $product_object->get_id() ),
                    'price_rules_percentage' => The4_Woocommerce_Discount_PriceManager::getPercentagePriceRules( $product_object->get_id() ),
                )
            );
        }
    }

    /**
     * Render inputs for price rules on variation
     *
     * @param int $loop
     * @param array $variation_data
     * @param WP_Post $variation
     */
    public function renderPriceRulesVariation( $loop, $variation_data, $variation )
    {

        self::getTemplate( 
            'add-price-rules-variation', 
            array(
                'price_rules_fixed'      => The4_Woocommerce_Discount_PriceManager::getFixedPriceRules( $variation->ID, 'edit' ),
                'price_rules_percentage' => The4_Woocommerce_Discount_PriceManager::getPercentagePriceRules( $variation->ID, 'edit' ),
                'i'                      => $loop,
                'label'                  => The4_Woocommerce_Discount_PriceManager::getLabelPriceRules( $variation->ID ),
                'variation_data'         => $variation_data,
                'type'                   => The4_Woocommerce_Discount_PriceManager::getPricingType( $variation->ID ),
            ) 
        );
    }

    /**
     * Update price quantity rules for simple product
     *
     * @param int $product_id
     */
    public function updatePriceRules( $product_id )
    {

        $data = $_POST;

        $prefix = ( isset( $data['product-type'] ) && in_array( $data['product-type'], array( 'simple', 'variable' ) ) ? sanitize_text_field( $data['product-type'] ) : 'simple' );
        
        $type = ( ! empty( $data['t4_price_rules_type_' . $prefix] ) ?  $data['t4_price_rules_type_' . $prefix] : 'fixed' );

        $label = ( ! empty($data['t4_price_fixed_label']) ? $data['t4_price_fixed_label'] : '' );

        if ( $type == 'fixed' ) {
            $fixedQty = ( isset( $data['t4_price_fixed_quantity_' . $prefix] ) ? (array) $data['t4_price_fixed_quantity_' . $prefix] : array() );
            $fixedVal = ( !empty($data['t4_price_fixed_price_' . $prefix]) ? (array) $data['t4_price_fixed_price_' . $prefix] : array() );
        } else {
            $fixedQty = ( isset( $data['t4_price_percent_quantity_' . $prefix] ) ? (array) $data['t4_price_percent_quantity_' . $prefix] : array() );
            $fixedVal = ( !empty($data['t4_price_percent_discount_' . $prefix]) ? (array) $data['t4_price_percent_discount_' . $prefix] : array() );
        }

        The4_Woocommerce_Discount_PriceManager::updatePriceRules( $type, $label, $fixedQty, $fixedVal, $product_id );

        
    }

    /**
     * Update price quantity rules for variation product
     *
     * @param int $variation_id
     * @param int $loop
     */
    public function updatePriceRulesVariation( $variation_id, $loop )
    {
        $data = $_POST;

        $type = isset( $data['t4_price_rules_type'][$loop] ) ? $data['t4_price_rules_type'][$loop] : 'fixed';
        $label = isset( $data['t4_price_fixed_label'][$loop] ) ? $data['t4_price_fixed_label'][$loop] : '';

        if ( $type == 'fixed' ) {
            $fixedQty = ( isset( $data['t4_price_fixed_quantity'][$loop] ) ? (array) $data['t4_price_fixed_quantity'][$loop] : array() );
            $fixedVal = ( !empty($data['t4_price_fixed_price'][$loop]) ? (array) $data['t4_price_fixed_price'][$loop] : array() );
        } else {
            $fixedQty = ( isset( $data['t4_price_percent_quantity'][$loop] ) ? (array) $data['t4_price_percent_quantity'][$loop] : array() );
            $fixedVal = ( !empty($data['t4_price_percent_discount'][$loop]) ? (array) $data['t4_price_percent_discount'][$loop] : array() );
        }

        The4_Woocommerce_Discount_PriceManager::updatePriceRules( $type, $label, $fixedQty, $fixedVal, $variation_id );
    
    }

    /**
     * GetTemplate
     *
     * @return  void
     */
    
    public static function getTemplate( $template, $args = [] )
    {
        if ( file_exists( KALLES_ADDONS_VIEW . '/woocommerce/discount' . '/' . $template .'.php' ) ) {
            extract($args);
            include KALLES_ADDONS_VIEW . '/woocommerce/discount' . '/' . $template .'.php';
        }
    }
    
    /**
     *  Display table at frontend
     */
    public function displayPricingTable()
    {
        global  $post ;
        if ( ! $post ) {
            return;
        }
        $product = wc_get_product( $post->ID );

        if ( $product ) {
            
            if ( $product->is_type( 'simple' ) ) {
                $this->renderPricingTable( $product->get_id() );
            } elseif ( $product->is_type( 'variable' ) ) {
                echo  '<div data-variation-price-rules-table></div>' ;
            }
        
        }
    }

    /**
     * Fired when user choose some variation. Render price rules table for it if it exists
     * @global WP_Post $post .
     */
    public function getPriceDisplayVariation()
    {
        $product_id = ( isset( $_POST['variation_id'] ) ? $_POST['variation_id'] : false );

        $product = wc_get_product( $product_id );

        if ( $product && $product->is_type( 'variation' ) ) {
            $this->renderPricingTable( $product->get_parent_id(), $product->get_id() );
        }
    }

    /**
     * Main function for rendering pricing table for product
     *
     * @param int $product_id
     * @param int $variation_id
     */
    public function renderPricingTable( $product_id, $variation_id = null )
    {

        $product = wc_get_product( $product_id );
        $product_id = ( ! is_null( $variation_id ) ? $variation_id : $product->get_id() );

        // Exit if product is not valid
        if ( !$product || !($product->is_type( 'simple' ) || $product->is_type( 'variable' )) ) {
            return;
        }

        $rules = The4_Woocommerce_Discount_PriceManager::getPriceRules( $product_id );
        $type = The4_Woocommerce_Discount_PriceManager::getPricingType( $product_id );

        $real_price = ( !is_null( $variation_id ) ? wc_get_product( $variation_id )->get_price() : $product->get_price() );

        $product_name = ( !is_null( $variation_id ) ? wc_get_product( $variation_id )->get_name() : $product->get_name() );
        
        if ( ! empty( $rules ) ) {

                $args = array(
                    'price_rules'  => $rules,
                    'real_price'   => $real_price,
                    'product_name' => $product_name,
                    'product_id'   => $product_id,
                    'type'         => $type,
                    'label'        => The4_Woocommerce_Discount_PriceManager::getLabelPriceRules( $product_id ),
                    'settings'     => '',
                );

            self::getTemplate( 'price-fixed-view', $args );
        }
    
    }

    /**
     * Calculate price in mini cart
     *
     * @param string $price
     * @param array $cart_item
     *
     * @return string
     */
    public function calculateItemPrice( $price, $cart_item ) {

        $needPriceRecalculation = apply_filters( 't4_price_discount/cart/need_price_recalculation/item', true, $cart_item );

        if ( $cart_item['data'] instanceof WC_Product && $needPriceRecalculation ) {

            $new_price = The4_Woocommerce_Discount_PriceManager::getPriceByRules( $this->getTotalProductCount( $cart_item ), $cart_item['data']->get_id(), 'view', 'cart' );

            // To get real product price
            $product = wc_get_product( $cart_item['data']->get_id() );

            $regular_price = wc_get_price_to_display( $product );

            if ( $new_price !== false ) {

                return '<del> ' . wc_price( $regular_price ) . ' </del> <ins> ' . wc_price( $new_price ) . ' </ins>';

            }
        }

        return $price;
    }

    /**
     * Calculate price by quantity rules
     *
     * @param WC_Cart $cart
     */
    public function calculateTotals( $cart ) {

        if ( ! empty( $cart->cart_contents ) ) {
            foreach ( $cart->cart_contents as $key => $cart_item ) {

                $needPriceRecalculation = apply_filters( 't4_price_discount/cart/need_price_recalculation', true,
                    $cart_item );

                if ( $cart_item['data'] instanceof WC_Product && $needPriceRecalculation ) {

                    $product_id = ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
                    $new_price  = The4_Woocommerce_Discount_PriceManager::getPriceByRules( $this->getTotalProductCount( $cart_item ), $product_id, 'calculation', 'cart' );

                    if ( $new_price !== false ) {
                        $cart_item['data']->set_price( $new_price );
                    }
                }
            }
        }
    }

    public function miniCartSubTotal() {
        $cart = wc()->cart;
        $cart->calculate_totals();
    }

    /**
     * Get total product count depend on user's settings
     *
     * @param array $cart_item
     *
     * @return int
     */
    public function getTotalProductCount( $cart_item ) {

        return $cart_item['quantity'];
    }

    /**
     * Add product data tab and panel.
     *
     * @return  void
     */
    public static function add_product_data() {
        add_filter( 'woocommerce_product_data_tabs', array( __CLASS__, 'tabs' ) );
        add_action( 'woocommerce_product_data_panels', array( __CLASS__, 'panels' ) );
    }

    /**
     * Add product data tab.
     *
     * @param $tabs
     *
     * @return  array
     */
    public static function tabs($tabs) {
        $tabs['t4_discount'] = array(
            'label'  => __( 'Product Discount', 'kalles' ),
            'target' => 't4_pr_tabs_discount',
            'class'  => array(),
        );

        return $tabs;
    }
    /**
     * Add product data panel.
     *
     * @param $tabs
     *
     * @return  string
     */
    public static function panels() {
        global $post;

        ?>

        <div id="t4_pr_tabs_discount" class="panel woocommerce_options_panel hidden">

        </div>
    <?php
    }
}

new The4_Woocommerce_Discount();