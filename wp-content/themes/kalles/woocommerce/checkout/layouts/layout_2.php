<?php
/**
 * Checkout Form Layout 2 - Kalles theme
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="checkout-form-head">
            <?php
            echo the4_kalles_logo();
            $options = get_post_meta( get_the_ID(), '_custom_page_options', true );
            if ( isset( $options['breadcrumb'] ) && $options['breadcrumb'] ) {
                echo the4_kalles_breadcrumb();
            } ?>
        </div>
    <?php 

    // If checkout registration is disabled and not logged in, the user cannot checkout
    if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
        echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'kalles' ) );
        return;
    } ?>
    </div>
</div>


<form name="checkout" method="post" class="checkout woocommerce-checkout row mt__60 mb__60" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <?php if ( $checkout->get_checkout_fields() ) : ?>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <div id="customer_details">
                <?php do_action( 'woocommerce_checkout_billing' ); ?>

                <?php do_action( 'woocommerce_checkout_shipping' ); ?>
            </div>

            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

        </div>

    <?php endif; ?>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="checkout-order-wrap">
            <div class="checkout-order-wrap-inner">
                <div class="fixcl-scroll">
                    <div class="fixcl-scroll-content css_ntbar">
                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'kalles' ); ?></h3>

                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>