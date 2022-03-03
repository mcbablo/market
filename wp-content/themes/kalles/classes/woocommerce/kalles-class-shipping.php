<?php
/**
 * Calculate shipping for the mini cart.
 * @packet: Kalles
 * @since 1.0
 */

namespace Kalles\Woocommerce;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 


class Shipping extends \WC_Shortcode_Cart{

	/**
     * Instance
     *
     * @var $instance
     */
    private static $instance = null;

    /**
     * Initiator
     *
     * @since 1.1.2
     * @return object
     */
    

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

	public function the4_calculate_shipping() {
		try {
			WC()->shipping()->reset_shipping();

			$address = array();

			$address['country']  = isset( $_POST['calc_shipping_country'] ) ? wc_clean( wp_unslash( $_POST['calc_shipping_country'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
			$address['state']    = isset( $_POST['calc_shipping_state'] ) ? wc_clean( wp_unslash( $_POST['calc_shipping_state'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
			$address['postcode'] = isset( $_POST['calc_shipping_postcode'] ) ? wc_clean( wp_unslash( $_POST['calc_shipping_postcode'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
			$address['city']     = isset( $_POST['calc_shipping_city'] ) ? wc_clean( wp_unslash( $_POST['calc_shipping_city'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.

			$address = apply_filters( 'woocommerce_cart_calculate_shipping_address', $address );

			if ( $address['postcode'] && ! \WC_Validation::is_postcode( $address['postcode'], $address['country'] ) ) {

			} elseif ( $address['postcode'] ) {
				$address['postcode'] = wc_format_postcode( $address['postcode'], $address['country'] );
			}

			if ( $address['country'] ) {
				if ( ! WC()->customer->get_billing_first_name() ) {
					WC()->customer->set_billing_location( $address['country'], $address['state'], $address['postcode'], $address['city'] );
				}
				WC()->customer->set_shipping_location( $address['country'], $address['state'], $address['postcode'], $address['city'] );
			} else {
				WC()->customer->set_billing_address_to_base();
				WC()->customer->set_shipping_address_to_base();
			}

			WC()->customer->set_calculated_shipping( true );
			WC()->customer->save();


			do_action( 'woocommerce_calculated_shipping' );

		} catch ( Exception $e ) {
			if ( ! empty( $e ) ) {
				die( $e->getMessage());
			}
		}
	}
}