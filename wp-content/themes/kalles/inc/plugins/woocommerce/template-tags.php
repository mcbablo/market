<?php

/***********
 *
 *  Secord Image on Hover on Product loop
 *
 * *********/

if( ! function_exists( 'kalles_hover_image_secord' ) ) {
	function kalles_hover_image_secord() {
		global $product, $kalles_sc;
	
		$attachment_ids = $product->get_gallery_image_ids();
		$secord_img = '';

		if ( !empty( $attachment_ids[0]) ) {
			$secord_img = the4_woo_get_product_thumbnai( 'woocommerce_thumbnail', $attachment_ids[0] );
		}
		$flip_thumb = $kalles_sc ? $kalles_sc['flip'] : cs_get_option( 'wc-flip-thumb' );

		if ( $secord_img != '' && $flip_thumb ) : ?>
			<div class="flip-img-wrapper">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo the4_woo_get_product_thumbnai( 'woocommerce_thumbnail', $attachment_ids[0] ); ?>
				</a>
			</div>

		<?php endif;
	}
}

/**
 * 
 * Custom coupon code start markup.
 *
 */
if ( ! function_exists( 't4_woo_coupon_section_wrapper_star ') ) {
	function t4_woo_coupon_section_wrapper_star() {
		echo '<section class="coupon-wrapper">';
	}
}


/**
 * 
 * Custom coupon code end markup.
 * 
 */

if ( ! function_exists( 't4_woo_coupon_section_wrapper_close ') ) {
	function t4_woo_coupon_section_wrapper_close() {
		echo '</section>';
	}
}

/**
 * 
 * Free shipping bar
 * 
 */

if ( ! function_exists( 't4_woo_free_shipping_bar ') ) {
	function t4_woo_free_shipping_bar() {
		$html = '<div class="cart_bar_w bgt4_svg19 pr">
					<span class="pr db h__100 more_10"></span>
				</div>';

		return $html;
	}
}

/**
 * 
 * Free shipping bar
 * 
 */

if ( ! function_exists( 't4_woo_get_all_variants ') ) {
	function t4_woo_get_all_variants() {
		global $product, $wpdb;

		if ( $product->is_type( 'variable' ) ) {
			$attributes = $product->get_attributes();
			$variation_attributes = $product->get_variation_attributes();
			$swatches_size = cs_get_option( 'wc_product_swatches-width' );
        	$swatches_style = cs_get_option( 'wc_product_swatches-style' );

			$output = '';

			foreach ( $variation_attributes as $attribute_name => $options ) {
                $attribute_name = sanitize_title($attribute_name);
                $attr = current(
                    $wpdb->get_results(
                        "SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies " .
                        "WHERE attribute_name = '" . substr( $attribute_name, 3 ) . "' LIMIT 0, 1;"
                    )
                );


                 if ( ! empty( $attr ) && $attr->attribute_type != 'color' && $options ) {

                 	$output .= '<div class="swatch__list swatch is-flex ' . $swatches_style .'" data-attribute="' . esc_attr( $attribute_name) . '">';

                    foreach ($options as $option) {

                            $output .= '<span  data-variation="" 
                                        class="swatch__list--item is-relative">';
                            $output .= '<span class="swatch__value" style="width: ' . $swatches_size . 'px; height: ' . $swatches_size . 'px;">';

                            $output .= $option;

                            $output .= '</span></span>';
                    }

                    $output .= '</div>';

                    
                 }

            }

                 echo The4Helper::ksesHTML( $output );

		}
		
	}
}

/**
 * 
 * Display discount type on MiniCart
 * 
 */

if ( ! function_exists( 't4_woo_mini_cart_coupon_detail' ) ) {
	function t4_woo_mini_cart_coupon_detail() {
		$cp_code = WC()->cart->get_applied_coupons();
		if ( count( $cp_code ) == 0 ) {
			return;
		}
		$cp_obj = WC()->cart->get_coupons();
		$curency = get_woocommerce_currency_symbol();
		$html = '';
		$html .= '<ul class="cart_discounts ul_none cr fwm">';
		foreach( $cp_code as $coupon ) {
			$obj = $cp_obj[ $coupon ];
			$cp_type = $obj->get_discount_type() == 'percent' ? '%' : $curency;

			$html .= '<li class="order_cart_discounts">';

			$html .= '<i class="facl facl-tags"></i><i>' . esc_html( $coupon ) . '</i> : ' .  esc_html( $obj->get_amount() ) . esc_html( $cp_type ) . ' ' . translate( 'off', 'kalles' ) . '(- ' . WC()->cart->get_coupon_discount_amount( $coupon )  . $curency . ')';
			
			$html .= '</li>';
		}
		
		$html .= '</ul>';

		return $html;
	}
}

/**
 * 
 * Display total price on minicart
 * 
 */
if ( ! function_exists( 't4_woo_mini_cart_subtotal' ) ) {
	function t4_woo_mini_cart_subtotal() {
		$dn =  ! WC()->cart->get_total_discount() ? 'dn' : '';
		$html = '';
		$html .= '<div class="cart_ori_price total_discoun '. esc_attr( $dn ) .'">';
		$html .= '<span class="money">' . WC()->cart->get_cart_subtotal() . '</span> ';
		$html .= '- <span class="money">' . WC()->cart->get_total_discount() . '</span>';
		$html .= '</div>';
		$html .= '<div class="cart_tot_price">';
		$html .= '<span class="money">' . WC()->cart->get_cart_total() . '</span>';
		$html .= '</div>';

		return $html;
	}
}

/**
 * 
 * Search suggestion text
 * 
 */
if ( ! function_exists( 't4_woo_search_suggestion_text' ) ) {
	function t4_woo_search_suggestion_text() {
		$suggest_text = cs_get_option( 'wc-search_suggest_text' );

		if ( $suggest_text ) {
			$suggest_text = explode( ',', $suggest_text );
			$leng = count( $suggest_text );

			?>
			<div class="search-suggest-text mt__10">
				<p class="search-suggest-text__label"><?php echo esc_html__( 'Quick search', 'kalles' ) ?>: </p>
				<ul>
					<?php foreach ( $suggest_text as $i => $text ) : ?>
						<?php if ( $i == $leng - 1 ) : ?>
							<li class="search-suggest-text__item">
								<a href="<?php echo esc_url ( get_site_url() . '?s=' . trim( $text ) . '&post_type=product' ); ?>" ><?php echo esc_html( $text ); ?></a>
							</li>
						<?php else : ?>
							<li class="search-suggest-text__item">
								<a href="<?php echo esc_url ( get_site_url() . '?s=' . trim( $text ) . '&post_type=product' ); ?>" ><?php echo esc_html( $text ); ?>, </a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>

			<?php
		}
	}
}


/**
 * 
 * Login / Register form
 * 
 */
if ( ! function_exists( 't4_woo_login_register_form' ) ) {
	function t4_woo_login_register_form() {
        $account_layout = cs_get_option( 'woocommerce_account_layout' ) ? cs_get_option( 'woocommerce_account_layout' )  : 'layout_1';
        $title_login    = cs_get_option('wc_login_desc') ? cs_get_option('wc_login_desc') : '';
        $title_regis    = cs_get_option('wc_regis_desc') ? cs_get_option('wc_regis_desc') : '';
        $bg_form        = cs_get_option('woocommerce_account_layout_bg') ? cs_get_option('woocommerce_account_layout_bg') : '';
		ob_start();
		?>
        <?php if ( $account_layout == 'layout_1' ) : ?>
            <div id="the4-customer-login" class="the4_mini_account is_selected">
                <div class="the4-account-ajax__header flex fl_center al_center">
                    <h3 class="mg__0 tc cb tu ls__2"><?php esc_html_e( 'Login', 'kalles' );?> <i class="close-cart pe-7s-close pa cb ts__03"></i></h3>
                </div>
                <div class="the4-account-ajax-content">
                    <div class="the4-account-form">
                        <form method="post"
                              action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) );?>"
                              class="woocommerce-form woocommerce-form-login login">

                            <?php do_action( 'woocommerce_login_form_start' ); ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="username"><?php esc_html_e( 'Username or email address', 'kalles' ); ?> <span class="required">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required /><?php // @codingStandardsIgnoreLine ?>
                            </p>
                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <label for="password"><?php esc_html_e( 'Password', 'kalles' ); ?> <span class="required">*</span></label>
                                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required />
                            </p>

                            <?php do_action( 'woocommerce_login_form' ); ?>

                            <p class="form-row">
                            <span class="inline"><span class="style-checkbox">
                                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><label for="rememberme" class="checkbox"></label> <span><?php esc_html_e( 'Remember me', 'kalles' ); ?></span>
                                </span></span>
                            </p>
                            <p class="form-row">
                                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                <button type="submit" data-skey="<?php echo esc_attr( wp_create_nonce('kalles-login-ajax') ); ?>" id="the4-account-login" class="woocommerce-Button button fr tu pr" name="login" value="<?php esc_attr_e( 'Log in', 'kalles' ); ?>"><span><?php esc_html_e( 'Log in', 'kalles' ); ?></span></button>
                            </p>

                            <p class="form-row error"></p>
                            <p class="woocommerce-LostPassword lost_password form-row">
                                <?php esc_html_e( 'Lost password?', 'kalles' ); ?>
                                <a class="the4_link_acc" data-id="#the4-customer-repass" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Recover password', 'kalles' ); ?></a>
                            </p>
                            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                                <p class="woocommerce-Register register form-row">
                                    <?php esc_html_e( 'New customer?', 'kalles' ); ?>
                                    <?php $class_dokan = class_exists( 'WeDevs_Dokan' ) ? 'dokan_installed' : ''; ?>
                                    <a class="the4_link_acc <?php echo esc_attr( $class_dokan ); ?>" data-id="#the4-customer-register" href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Create your account', 'kalles' ); ?></a>
                                </p>
                            <?php endif; ?>
                            <?php do_action( 'woocommerce_login_form_end' ); ?>

                        </form>
                    </div>
                </div>
            </div> <!-- #the4-customer-login -->
            <div id="the4-customer-repass" class="the4_mini_account">
                <div class="the4-account-ajax__header flex fl_center al_center">
                    <h3 class="mg__0 tc cb tu ls__2"><?php esc_html_e( 'Recover Password', 'kalles' );?> <i class="close-cart pe-7s-close pa cb ts__03"></i></h3>
                </div>
                <div class="the4-account-ajax-content">
                    <div class="the4-account-form">
                        <form method="post" action="<?php echo esc_url( wc_lostpassword_url() ); ?>" class="woocommerce-ResetPassword lost_reset_password">
                            <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                <label for="user_login"><?php esc_html_e( 'Username or email', 'kalles' ); ?></label>
                                <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
                            </p>
                            <p class="woocommerce-form-row form-row">
                                <input type="hidden" name="wc_reset_password" value="true" />
                                <button type="submit" class="woocommerce-Button button fr tu pr" data-skey="<?php echo esc_attr( wp_create_nonce('kalles-forgot-ajax') ); ?>" value="<?php esc_attr_e( 'Reset password', 'kalles' ); ?>"><span><?php esc_html_e( 'Reset password', 'kalles' ); ?></span></button>
                            </p>
                            <p class="form-row error"></p>
                            <p class="mb__10 mt__20"><?php esc_html_e( 'Remembered your password?', 'kalles' ); ?>
                                <a href="#" data-id="#the4-customer-login" class="the4_link_acc"><?php esc_html_e( 'Back to login', 'kalles' ); ?></a>
                            </p>
                            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                        </form>
                    </div>
                </div>
            </div> <!-- #the4-customer-repass -->

            <div id="the4-customer-register" class="the4_mini_account">
                <div class="the4-account-ajax__header flex fl_center al_center">
                    <h3 class="mg__0 tc cb tu ls__2"><?php esc_html_e( 'Register', 'kalles' );?> <i class="close-cart pe-7s-close pa cb ts__03"></i></h3>
                </div>
                <div class="the4-account-ajax-content">
                    <div class="the4-account-form">
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
                            <p class="mb__10 mt__20"><?php esc_html_e( 'Already have an account?', 'kalles' ); ?>
                                <a href="#" data-id="#the4-customer-login" class="the4_link_acc"><?php esc_html_e( 'Login here', 'kalles' ); ?></a>
                            </p>
                            <?php do_action( 'woocommerce_register_form_end' ); ?>

                        </form>
                    </div>
                </div>
            </div> <!-- #the4-customer-register -->
        <?php else : ?>
            <div class="customer_form_<?php echo esc_attr($account_layout);?>" id="customer_login">
                <div class="form-login">
                    <div class="login-w-social lazyload pr_lazy_img pr_lazy_img_bg" <?php if (!empty($bg_form['url'])) echo 'data-bgset="' . $bg_form['url'] .'" data-parent-fit="width" data-sizes="auto"'; ?>>
                        <div class="login-w-social-inner">
                            <div class="login-s-head the4-form-show mb__30">
                                <h2 class="mt__0"><?php esc_html_e( 'Login', 'kalles' ); ?></h2>
                                <?php if ($title_login !='') echo esc_html( $title_login ); ?>
                            </div>
                            <div class="login-s-head mb__30">
                                <h2 class="mt__0"><?php esc_html_e( 'Register', 'kalles' ); ?></h2>
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
                    <div class="login-w-form the4-account-ajax-content">
                        <div class="login-w-form-inner the4-account-form">
                            <div class="form-login-reset-wrap form-acc-wrap the4-acc-show">
                                <form method="post" class="woocommerce-form woocommerce-form-login login the4-form-show" action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) );?>">

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
                                        <span class="inline">
                                            <span class="style-checkbox">
                                                <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><label for="rememberme" class="checkbox"></label> <span><?php esc_html_e( 'Remember me', 'kalles' ); ?></span>
                                            </span>
                                        </span>
                                        <button type="submit" data-skey="<?php echo esc_attr( wp_create_nonce('kalles-login-ajax') ); ?>" id="the4-account-login" class="woocommerce-Button button fr tu pr" name="login" value="<?php esc_attr_e( 'Log in', 'kalles' ); ?>"><span><?php esc_html_e( 'Log in', 'kalles' ); ?></span></button>
                                    </p>
                                    <p class="woocommerce-LostPassword lost_password form-row">
                                        <?php esc_html_e( 'Lost password?', 'kalles' ); ?>
                                        <a class="link-reset-pw" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Recover password', 'kalles' ); ?></a>
                                    </p>
                                </form>
                                <form method="post" action="<?php echo esc_url( wc_lostpassword_url() ); ?>" class="woocommerce-form woocommerce-ResetPassword lost_reset_password">
                                    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                        <label for="user_login"><?php esc_html_e( 'Username or email', 'kalles' ); ?></label>
                                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
                                    </p>
                                    <p class="woocommerce-form-row form-row">
                                        <input type="hidden" name="wc_reset_password" value="true" />
                                        <button type="submit" class="woocommerce-Button button fr tu pr" data-skey="<?php echo esc_attr( wp_create_nonce('kalles-forgot-ajax') ); ?>" value="<?php esc_attr_e( 'Reset password', 'kalles' ); ?>"><span><?php esc_html_e( 'Reset password', 'kalles' ); ?></span></button>
                                    </p>
                                    <p class="form-row error"></p>
                                    <p class="mb__10 mt__20"><?php esc_html_e( 'Remembered your password?', 'kalles' ); ?>
                                        <a href="#" class="link-reset-pw"><?php esc_html_e( 'Back to login', 'kalles' ); ?></a>
                                    </p>
                                    <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                                </form>
                            </div>
                            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
                            <div class="form-acc-wrap">
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
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif ; ?>
		<?php

		echo ob_get_clean();
	}
}

/**
 * 
 * Get User Avatar
 * 
 */
function t4_woo_get_user_avatar() {
    // Get current user id
    $user_id = get_current_user_id();
    $attachment_id = get_user_meta( $user_id, 'image', true );
    $image_size = cs_get_option( 'woocommerce_account-avatar_size' ) ? cs_get_option( 'woocommerce_account-avatar_size' ) : 100;

    if ( $attachment_id ) {
        $image_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
        // Display Image instead of URL
        $image_html = '<img src="' . $image_url[0] .'" width="' . $image_size .'" height="' . $image_size .'"/>';

        return $image_html;
    } else {
        return get_avatar( $user_id, $image_size );
    }
    
} 

if ( ! function_exists('kalles_woo_add_to_cart_loop') ) {
    function kalles_woo_add_to_cart_loop() {
        if ( cs_get_option( 'wc-atc-on-product-list' ) ) {
            woocommerce_template_loop_add_to_cart();
        }
    }
}

/**
 * 
 * Subcategories on page title
 * 
 */

if ( ! function_exists('t4_woo_subcategories_title') ) {
    function t4_woo_subcategories_title() {
        global $wp_query, $post;

        $current_cat = false;

        if ( is_tax( 'product_cat' ) ) {
            $current_cat = $wp_query->queried_object;
        }

        if ( cs_get_option('wc-subcustom-only_sub') ) {

            $args = array(
                'taxonomy'         => 'product_cat',
                'hide_empty'       => false,
                'depth'            => 1,
                'hierarchical'     => 1,
                'title_li'         => '',
                'child_of'         => 0,
                'show_option_none' => esc_html__( 'No product categories exist.', 'kalles' ),
                'current_category' => ( $current_cat ) ? $current_cat->term_id : '',
                'walker'           => \Kalles\Woocommerce\Category_Walker::instance()
            );

            if ( $current_cat ) {

                $children = get_terms(
                    'product_cat',
                    array(
                        'fields'       => 'ids',
                        'parent'       => $current_cat->term_id,
                        'hierarchical' => true,
                        'hide_empty'   => false,
                    )
                );

                $args['include'] = implode( ',', $children );

                if ( empty( $children ) ) {
                    return;
                }

            }

        } else {
            $args = array(
                'taxonomy'         => 'product_cat',
                'hide_empty'       => false,
                'depth'            => 1,
                'hierarchical'     => 1,
                'title_li'         => '',
                'child_of'         => 0,
                'show_option_none' => esc_html__( 'No product categories exist.', 'kalles' ),
                'walker'           => \Kalles\Woocommerce\Category_Walker::instance()
            );
        }


        if ( cs_get_option( 'wc-subcustom-product_count') ) {
            $args['show_count'] = true;
        }

        $style = cs_get_option('wc-subcustom_layout');

        ob_start();

        echo '<nav class="nav-product-cat mt__30 mb__30"><div class="container">';

        echo '<ul class="kalles-list-product-cat ' . $style . '">';


        wp_list_categories( $args );

        echo '</ul></div></nav>';

        $output = ob_get_clean();

        return $output;
    }
}
