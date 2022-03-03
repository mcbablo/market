<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
* @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$account_layout = cs_get_option( 'woocommerce_account_layout' ) ? cs_get_option( 'woocommerce_account_layout' )  : 'layout_1';
$title_login    = cs_get_option('wc_login_desc') ? cs_get_option('wc_login_desc') : '';
$title_regis    = cs_get_option('wc_regis_desc') ? cs_get_option('wc_regis_desc') : '';
$bg_form        = cs_get_option('woocommerce_account_layout_bg') ? cs_get_option('woocommerce_account_layout_bg') : '';
?>
<div class="container login-form">

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( $account_layout == 'layout_1' ) : ?>

    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

    <div class="row u-columns col2-set" id="customer_login">

        <div class="col-md-6 col-sm-6 col-xs-12 u-column1">

    <?php endif; ?>
        <div class="form-login">
            <h2><?php esc_html_e( 'Login', 'kalles' ); ?></h2>

            <form method="post" class="woocommerce-form woocommerce-form-login login">

                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="username"><?php esc_html_e( 'Username or email address', 'kalles' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password"><?php esc_html_e( 'Password', 'kalles' ); ?> <span class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                </p>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <p class="form-row">
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="woocommerce-Button button fr" name="login" value="<?php esc_attr_e( 'Log in', 'kalles' ); ?>"><?php esc_html_e( 'Log in', 'kalles' ); ?></button>

                    <span class="inline"><span class="style-checkbox">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><label for="rememberme" class="checkbox"></label> <span><?php esc_html_e( 'Remember me', 'kalles' ); ?></span>
                    </span></span>
                </p>
                <p class="woocommerce-LostPassword lost_password">
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'kalles' ); ?></a>
                </p>

                <?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>
        </div>

    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 u-column2">

            <h2><?php esc_html_e( 'Register', 'kalles' ); ?></h2>

            <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                <?php do_action( 'woocommerce_register_form_start' ); ?>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_username"><?php esc_html_e( 'Username', 'kalles' ); ?> <span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>

                <?php endif; ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'kalles' ); ?> <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_password"><?php esc_html_e( 'Password', 'kalles' ); ?> <span class="required">*</span></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
                    </p>

                <?php else : ?>

                    <p><?php esc_html_e( 'A password will be sent to your email address.', 'kalles' ); ?></p>

                <?php endif; ?>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <p class="woocommerce-FormRow form-row">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" class="woocommerce-Button button fr" name="register" value="<?php esc_attr_e( 'Register', 'kalles' ); ?>"><?php esc_html_e( 'Register', 'kalles' ); ?></button>
                </p>

                <?php do_action( 'woocommerce_register_form_end' ); ?>

            </form>

        </div>

    </div>
    <?php endif; ?>
<?php else : ?>
    <div class="customer_form_<?php echo esc_attr($account_layout);?>" id="customer_login">
        <div class="form-login">
            <div class="login-w-social lazyload pr_lazy_img pr_lazy_img_bg" <?php if (!empty($bg_form['url'])) echo 'data-bgset="' . $bg_form['url'] .'" data-parent-fit="width" data-sizes="auto"'; ?>>
                <div class="login-w-social-inner">
                    <div class="login-s-head the4-form-show mb__10">
                        <h2><?php esc_html_e( 'Login', 'kalles' ); ?></h2>
                        <?php if ($title_login !='') echo esc_html( $title_login ); ?>
                    </div>
                    <div class="login-s-head mb__10">
                        <h2><?php esc_html_e( 'Register', 'kalles' ); ?></h2>
                        <?php if ($title_regis !='') echo esc_html( $title_regis ); ?>
                    </div>
                    <?php do_action( 't4_woo_social_login_2' ); ?>
                    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                        <div class="the4-acc-form-bottom">
                            <p class="the4-woocommerce-acction register form-row mb__0 link_acc_active">
                                <?php esc_html_e( 'New customer?', 'kalles' ); ?>
                                <?php $class_dokan = class_exists( 'WeDevs_Dokan' ) ? 'dokan_installed' : ''; ?>
                                <a class="the4_link_acc_custom <?php echo esc_attr( $class_dokan ); ?>" href="#"><?php esc_html_e( 'Create your account', 'kalles' ); ?></a>
                            </p>
                            <p class="the4-woocommerce-acction login form-row mb__0"><?php esc_html_e( 'Already have an account?', 'kalles' ); ?>
                                <a href="#" class="the4_link_acc_custom"><?php esc_html_e( 'Login here', 'kalles' ); ?></a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="login-w-form">
                <div class="login-w-form-inner">
                    <form method="post" class="woocommerce-form woocommerce-form-login login the4-form-show">

                        <?php do_action( 'woocommerce_login_form_start' ); ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="username"><?php esc_html_e( 'Username or email address', 'kalles' ); ?> <span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                        </p>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="password"><?php esc_html_e( 'Password', 'kalles' ); ?> <span class="required">*</span></label>
                            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                        </p>

                        <?php do_action( 'woocommerce_login_form' ); ?>

                        <p class="form-row">
                            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                            <button type="submit" class="woocommerce-Button button fr" name="login" value="<?php esc_attr_e( 'Log in', 'kalles' ); ?>"><?php esc_html_e( 'Log in', 'kalles' ); ?></button>

                            <span class="inline"><span class="style-checkbox">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><label for="rememberme" class="checkbox"></label> <span><?php esc_html_e( 'Remember me', 'kalles' ); ?></span>
                    </span></span>
                        </p>
                        <p class="woocommerce-LostPassword lost_password">
                            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'kalles' ); ?></a>
                        </p>

                    </form>
                    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                        <form method="post"
                              action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) );?>"
                              class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                            <?php do_action( 'woocommerce_register_form_start' ); ?>

                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_username"><?php esc_html_e( 'Username', 'kalles' ); ?> <span class="required">*</span></label>
                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                                </p>

                            <?php endif; ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="reg_email"><?php esc_html_e( 'Email address', 'kalles' ); ?> <span class="required">*</span></label>
                                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required/><?php // @codingStandardsIgnoreLine ?>
                            </p>

                            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <label for="reg_password"><?php esc_html_e( 'Password', 'kalles' ); ?> <span class="required">*</span></label>
                                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" required/>
                                </p>

                            <?php else : ?>

                                <p><?php esc_html_e( 'A password will be sent to your email address.', 'kalles' ); ?></p>

                            <?php endif; ?>

                            <?php do_action( 'woocommerce_register_form' ); ?>

                            <p class="woocommerce-FormRow form-row">
                                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                <button type="submit" data-skey="<?php echo esc_attr( wp_create_nonce('kalles-forgot-ajax') ); ?>" class="woocommerce-Button button fr tu pr" name="register" value="<?php esc_attr_e( 'Register', 'kalles' ); ?>"><span><?php esc_html_e( 'Register', 'kalles' ); ?></span></button>
                            </p>
                            <p class="form-row error"></p>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
</div>