<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$allowed_html = array(
    'a' => array(
        'href' => array(),
    ),
);

?>
<div class="account-inner-content">
    <div class="row account-inner-content__heading">
        <div class="col-12 flex fl_between">
        <div class="account-header">
            <h4 class="title-name">

             <?php esc_html_e( 'Hello', 'kalles' ); ?>
             <strong><?php echo esc_html( $current_user->display_name ); ?> </strong>
                <span>
                 (<?php esc_html_e( 'not ', 'kalles' ); ?><span><?php echo esc_html($current_user->display_name ); ?> </span> ? <a href="<?php echo esc_url( wc_logout_url()); ?>" class="acc-logout"><?php esc_html_e( 'Log out', 'kalles' ); ?>)</a>
                </span>
            </h4>
            <p>
                <?php
                    esc_html_e( 'Here you will find relevant information', 'kalles' );
                ?>
            </p>
        </div>
        <div class="account-avatar <?php echo cs_get_option('woocommerce_account-avatar_style') ?>">
            <?php echo t4_woo_get_user_avatar(); ?>
        </div>
    </div>
    <ul class="account-list-action row w__100">
        <li class="col-lg-3 col-md-6 col-12 mt__15">
            <div>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="acc-order">
                <i class="pe-7s-box2"></i><br>
                <?php esc_html_e( 'Order', 'kalles' ); ?><br>
                <span><?php esc_html_e( 'Your oder', 'kalles' ); ?></span>
            </a>

            </div>
        </li>
        <li class="col-lg-3 col-md-6 col-12 mt__15">
            <div>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'downloads' ) ); ?>" class="acc-download">
                <i class="pe-7s-download"></i><br>
                <?php esc_html_e( 'Download', 'kalles' ); ?><br>
                <span><?php esc_html_e( 'Your Download', 'kalles' ); ?></span>
            </a>

            </div>
        </li>
        <li class="col-lg-3 col-md-6 col-12 mt__15">
            <div>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="acc-address">
                <i class="pe-7s-credit"></i><br>
                <?php esc_html_e( 'Address', 'kalles' ); ?><br>
                <span><?php esc_html_e( 'Edit Address', 'kalles' ); ?></span>
            </a>

            </div>
            </li>
        <li class="col-lg-3 col-md-6 col-12 mt__15">
            <div>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="acc-detail">
                <i class="pe-7s-user"></i><br>
                <?php esc_html_e( 'Account details', 'kalles' ); ?><br>
                <span><?php esc_html_e( 'Edit Account', 'kalles' ); ?></span>
            </a>

            </div>
        </li>
    </ul>
</div>


<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_before_my_account' );

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
