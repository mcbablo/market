<?php

/**
 *  Preview Your WooCommerce Emails Live
 *  Heavily borrowed from drrobotnik:
 *  http://stackoverflow.com/a/27072101/2203639
 **/

function wordimpress_preview_woo_emails() {

    if ( is_admin() ) {
        $default_path = WC()->plugin_path() . '/templates/';

        $files   = scandir( $default_path . 'emails' );
        $exclude = array(
            '.',
            '..',
            'email-header.php',
            'email-footer.php',
            'email-styles.php',
            'email-order-items.php',
            'email-addresses.php',
            'plain'
        );
        $list    = array_diff( $files, $exclude );
        ?>
        <div id="template-selector">
            <form method="get" action="<?php echo esc_url( site_url() ); ?>/wp-admin/admin-ajax.php">
                <div class="template-row">
                    <input id="setorder" type="hidden" name="order" value="">
                    <input type="hidden" name="action" value="previewemail">
                    <span class="choose-email">Choose your email template: </span>
                    <select name="file" id="email-select">
                        <?php
                        foreach ( $list as $item ) { ?>
                            <option value="<?php echo esc_attr($item); ?>"><?php echo esc_html( str_replace( '.php', '', $item ) ); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="order-row">
                    <span class="choose-order">Choose an order number: </span>
                    <input id="order" type="number" value="<?php echo esc_attr( $order_number ); ?>" placeholder="<?php esc_attr_e( 'order #', 'kalles' ) ?>" onChange="process1(this)">
                </div>
                <input type="submit" value="Go">
            </form>
        </div>
        <?php

        global $order;
        if(isset($_GET['order']))
        {
            $order = new WC_Order( $_GET['order'] );
        }

        wc_get_template( 'emails/email-header.php', array( 'order' => $order, 'email_heading' => isset($email_heading)? $email_heading : '' ) );

        do_action( 'woocommerce_email_before_order_table', $order, isset($sent_to_admin)?$sent_to_admin:'', isset($plain_text)?$plain_text : ''  );

        wc_get_template( 'emails/' . $_GET['file'], array( 'order' => $order ) );

        wc_get_template( 'emails/email-footer.php', array( 'order' => $order ) );

    }
}

add_action( 'wp_ajax_previewemail', 'wordimpress_preview_woo_emails' );

/*
 *    Extend WC_Email_Setting
 *    in order to add our own
 *    links to the preview
 */
add_filter( 'woocommerce_email_settings', 'add_preview_email_links' );

function add_preview_email_links( $settings ) {
    $updated_settings = array();
    foreach ( $settings as $section ) {
        // at the bottom of the General Options section

        if ( isset( $section['id'] ) && 'email_recipient_options' == $section['id'] &&

             isset( $section['type'] ) && 'sectionend' == $section['type']
        ) {
            $updated_settings[] = array(
                'title' => esc_html__( 'Preview Email Templates', 'kalles' ),
                'type'  => 'title',
                'desc'  => '<a href="' . esc_url( site_url() ) . '/wp-admin/admin-ajax.php?action=previewemail&file=customer-new-account.php" target="_blank">' . esc_html__('Click Here to preview all of your Email Templates with Orders', 'kalles' ) . '</a>.',
                'id'    => 'email_preview_links'
            );
        }
        $updated_settings[] = $section;

    }

    return $updated_settings;

}
