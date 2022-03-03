<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global  $scfw_fs ;
$plugin_mode = __( 'Free Version ', 'size-chart-for-woocommerce' );
$plugin_header_button_account_url = $scfw_fs->get_upgrade_url();
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-plugin-details">
                <div class="dots-header-left">
                    <div class="dots-logo-main">
                        <div class="logo-image">
                            <img src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/Advanced-Product-Size-Charts-for-WooCommerce.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Product Size Charts Plugin for WooCommerce', 'size-chart-for-woocommerce' );
?>">
                        </div>
                        <div class="plugin-version">
                            <span><?php 
echo  esc_html_e( $plugin_mode, 'size-chart-for-woocommerce' ) ;
echo  esc_html( $this->get_plugin_version() ) ;
?></span>
                        </div>
                    </div>
                    <div class="plugin-name">
                        <div class="title"><?php 
echo  esc_html_e( $this->get_plugin_name(), 'size-chart-for-woocommerce' ) ;
?></div>
                        <div class="desc"><?php 
esc_html_e( 'Allows you to assign ready-to-use default size chart templates to the product, category, and create custom size chart for your WooCommerce products.', 'size-chart-for-woocommerce' );
?></div>
                    </div>
                </div>
                <div class="dots-header-right">
                    <div class="button-group">
                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php 
echo  esc_url( 'http://www.thedotstore.com/support/' ) ;
?>">
                                    <span class="dashicons dashicons-sos"></span>
                                    <strong><?php 
esc_html_e( 'Quick Support', 'size-chart-for-woocommerce' );
?></strong>
                                </a>
                            </span>
                        </div>

                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php 
echo  esc_url( 'https://docs.thedotstore.com/category/239-premium-plugin-settings' ) ;
?>">
                                    <span class="dashicons dashicons-media-text"></span>
                                    <strong><?php 
esc_html_e( 'Documentation', 'size-chart-for-woocommerce' );
?></strong>
                                </a>
                            </span>
                        </div>

                        <div class="button-dots">
                            <span class="support_dotstore_image">
                                <a target="_blank" href="<?php 
echo  esc_url( $plugin_header_button_account_url ) ;
?>">
                                    <span class="dashicons dashicons-admin-users"></span>
                                    <strong><?php 
esc_html_e( 'My Account', 'size-chart-for-woocommerce' );
?></strong>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

			<?php 
$get_size_chart_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$get_size_chart_post_type = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );
$this->scfw_size_chart_menus( $get_size_chart_post_type, $get_size_chart_page );
?>
        </header>