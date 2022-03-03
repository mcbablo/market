<div class="shipping_calculator">
    <h3><?php esc_html_e('Estimate Shipping', 'kalles'); ?></h3>
        <form class="kalles-woocommerce-shipping-calculator" action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>" method="post">
            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_country', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_country_field">
                    <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
                        <option value="default"><?php esc_html_e( 'Select a country / region&hellip;', 'kalles' ); ?></option>
                        <?php
                        foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
                            echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
                        }
                        ?>
                    </select>
                </p>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_state', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_state_field">
                    <?php
                    $current_cc = WC()->customer->get_shipping_country();
                    $current_r  = WC()->customer->get_shipping_state();
                    $states     = WC()->countries->get_states( $current_cc );

                    if ( is_array( $states ) && empty( $states ) ) {
                        ?>
                        <input type="hidden" name="calc_shipping_state" id="calc_shipping_state"/>
                        <?php
                    } elseif ( is_array( $states ) ) {
                        ?>
                        <span>
                            <select name="calc_shipping_state" class="state_select" id="calc_shipping_state" data-placeholder="<?php esc_attr_e( 'State / County', 'kalles' ); ?>">
                                <option value=""><?php esc_html_e( 'Select an option&hellip;', 'kalles' ); ?></option>
                                <?php
                                foreach ( $states as $ckey => $cvalue ) {
                                    echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
                                }
                                ?>
                            </select>
                        </span>
                        <?php
                    } else {
                        ?>
                        <input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / County', 'kalles' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />
                        <?php
                    }
                    ?>
                </p>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_city_field">
                    <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'City', 'kalles' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                </p>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                    <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'kalles' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                </p>
            <?php endif; ?>

    <p class="field">
        <a href="#" class="btn btn_back js_cart_caculate_shiping pr" 
            data-skey="<?php echo esc_attr( wp_create_nonce('the4-cal-shipping-cart') ); ?>">
            <span><?php esc_html_e('Caculate Shiping', 'kalles'); ?></span>
        </a>
    </p>
    <a href="#" class="btn btn_back btn_back2 js_cart_tls_back"><?php esc_html_e('Cancel', 'kalles'); ?></a>
    </form>
    <div id="response_calcship"></div>
</div>