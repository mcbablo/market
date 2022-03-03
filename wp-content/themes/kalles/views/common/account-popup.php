<?php
/**
 * The Account ajax - Login / Register with Ajax
 *
 * @since   1.0.0
 * @package Kalles
 */
$account_layout = cs_get_option( 'woocommerce_account_layout' ) ? cs_get_option( 'woocommerce_account_layout' )  : 'layout_1';
?>
    <div class="the4-account-ajax the4-account-popup popup-<?php echo esc_attr($account_layout);?>">
        <div class="the4-account-popup__wrapper">
            <?php t4_woo_login_register_form(); ?>
        </div> <!-- #wrapper -->
    </div>

