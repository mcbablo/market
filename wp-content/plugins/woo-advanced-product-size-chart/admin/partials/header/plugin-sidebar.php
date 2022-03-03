<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="dotstore_plugin_sidebar">

    <?php 
$review_url = '';
$plugin_at = '';
$review_url = esc_url( 'https://wordpress.org/plugins/woo-advanced-product-size-chart/#reviews' );
$plugin_at = 'WP.org';
?>
        <div class="dotstore-sidebar-section dotstore-upgrade-to-pro">
            <div class="dotstore-important-link-heading">
                <span class="heading-text"><?php 
esc_html_e( 'Upgrade to Product Size Charts Pro', 'size-chart-for-woocommerce' );
?></span>
            </div>
            <div class="dotstore-important-link-content">
                <ul class="dotstore-pro-list">
                    <li><?php 
esc_html_e( 'Save time by using default size chart templates for products', 'size-chart-for-woocommerce' );
?></li>
                    <li><?php 
esc_html_e( 'Customize size chart as per category and product', 'size-chart-for-woocommerce' );
?></li>
                    <li><?php 
esc_html_e( 'Optimize the use of size charts to engage customers', 'size-chart-for-woocommerce' );
?></li>
                    <li><?php 
esc_html_e( 'Multiple displays of size chart to capture customer attention', 'size-chart-for-woocommerce' );
?></li>
                    <li><?php 
esc_html_e( 'Quickly assign size chart across multiple categories', 'size-chart-for-woocommerce' );
?></li>
                    <li><?php 
esc_html_e( 'Make size chart more visually appealing to engage shoppers', 'size-chart-for-woocommerce' );
?></li>
                </ul>
                <div class="dotstore-pro-button">
                    <a class="button" target="_blank" href="<?php 
echo  esc_url( 'https://bit.ly/3oguAFf' ) ;
?>"><?php 
esc_html_e( 'Get Premium Now »', 'size-chart-for-woocommerce' );
?></a>
                </div>
            </div>
        </div>
        <?php 
?>
    <div class="dotstore-important-link">
        <div class="image_box">
            <img src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/rate-us.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Rate us', 'size-chart-for-woocommerce' );
?> ">
        </div>
        <div class="content_box">
            <h3><?php 
esc_html_e( 'Like This Plugin?', 'size-chart-for-woocommerce' );
?></h3>
            <p class="star-container">
                <a href="<?php 
echo  esc_url( $review_url ) ;
?>" target="_blank">
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                </a>
            </p>
            <p><?php 
esc_html_e( 'Your Review is very important to us as it helps us to grow more.', 'size-chart-for-woocommerce' );
?></p>
            <a class="btn_style" href="<?php 
echo  esc_url( $review_url ) ;
?>" target="_blank"><?php 
esc_html_e( 'Review Us on ', 'size-chart-for-woocommerce' );
?> <?php 
esc_html_e( $plugin_at, 'size-chart-for-woocommerce' );
?></a>
        </div>
    </div>
    <div class="dotstore-sidebar-section">
        <div class="dotstore-important-link-heading">
            <span class="dashicons dashicons-image-rotate-right"></span>
            <span class="heading-text"><?php 
esc_html_e( 'Free vs Pro Feature', 'size-chart-for-woocommerce' );
?></span>
        </div>
        <div class="dotstore-important-link-content">
            <p><?php 
esc_html_e( 'Here’s an at a glance view of the main differences between Premium and free plugin features.', 'size-chart-for-woocommerce' );
?></p>
            <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-advanced-product-size-charts' ) ;
?>"><?php 
esc_html_e( 'Click here »', 'size-chart-for-woocommerce' );
?></a>
        </div>
    </div>
    <div class="dotstore-sidebar-section">
        <div class="dotstore-important-link-heading">
            <span class="dashicons dashicons-star-filled"></span>
            <span class="heading-text"><?php 
esc_html_e( 'Suggest A Feature', 'size-chart-for-woocommerce' );
?></span>
        </div>
        <div class="dotstore-important-link-content">
            <p><?php 
esc_html_e( 'Let us know how we can improve the plugin experience.', 'size-chart-for-woocommerce' );
?></p>
            <p><?php 
esc_html_e( 'Do you have any feedback &amp; feature requests?', 'size-chart-for-woocommerce' );
?></p>
            <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/feature-requests/' ) ;
?>"><?php 
esc_html_e( 'Submit Request »', 'size-chart-for-woocommerce' );
?></a>
        </div>
    </div>
    <div class="dotstore-sidebar-section">
        <div class="dotstore-important-link-heading">
            <span class="dashicons dashicons-editor-kitchensink"></span>
            <span class="heading-text"><?php 
esc_html_e( 'Changelog', 'size-chart-for-woocommerce' );
?></span>
        </div>
        <div class="dotstore-important-link-content">
            <p><?php 
esc_html_e( 'We improvise our products on a regular basis to deliver the best results to customer satisfaction.', 'size-chart-for-woocommerce' );
?></p>
            <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-advanced-product-size-charts/#tab-update-log' ) ;
?>"><?php 
esc_html_e( 'Visit Here »', 'size-chart-for-woocommerce' );
?></a>
        </div>
    </div>

    <!-- html for popular plugin !-->
    <div class="dotstore-important-link dotstore-sidebar-section">
        <div class="dotstore-important-link-heading">
            <span class="dashicons dashicons-plugins-checked"></span>
            <span class="heading-text"><?php 
esc_html_e( 'Our Popular Plugins', 'size-chart-for-woocommerce' );
?></span>
        </div>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/Advanced-Flat-Rate-Shipping-Method.png' ;
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/flat-rate-shipping-plugin-for-woocommerce/' ) ;
?> "><?php 
esc_html_e( 'Flat Rate Shipping Plugin for WooCommerce', 'size-chart-for-woocommerce' );
?></a>
                </li> 
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/Conditional-Product-Fees-For-WooCommerce-Checkout.png' ;
?>">
                    <a  target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/product/woocommerce-extra-fees-plugin/' ) ;
?>"><?php 
esc_html_e( 'Extra Fees Plugin for WooCommerce', 'size-chart-for-woocommerce' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/woo-product-att-logo.png' ;
?>">
                    <a  target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-product-attachment/' ) ;
?>"><?php 
esc_html_e( 'Product Attachment For WooCommerce', 'size-chart-for-woocommerce' );
?></a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/WooCommerce-Conditional-Discount-Rules-For-Checkout.png' ;
?>">
                    <a  target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-conditional-discount-rules-for-checkout/' ) ;
?>"><?php 
esc_html_e( 'Conditional Discount Rules For WooCommerce Checkout', 'size-chart-for-woocommerce' );
?></a>
                </li>
                <li>
                    <img  class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/WooCommerce-Blocker-Prevent-Fake-Orders.png' ;
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/woocommerce-anti-fraud' ) ;
?>"><?php 
esc_html_e( 'WooCommerce Anti-Fraud', 'size-chart-for-woocommerce' );
?></a>
                </li>
                <li>
                    <img  class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/hide-shipping.png' ;
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/hide-shipping-method-for-woocommerce' ) ;
?>"><?php 
esc_html_e( 'Hide Shipping Method For WooCommerce', 'size-chart-for-woocommerce' );
?></a>
                </li>
                <li>
                    <img  class="sidebar_plugin_icone" src="<?php 
echo  esc_url( SCFW_PLUGIN_URL ) . 'admin/images/thedotstore-images/popular-plugins/wcbm-logo.png' ;
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/product/woocommerce-category-banner-management/' ) ;
?>"><?php 
esc_html_e( 'WooCommerce Category Banner Management', 'size-chart-for-woocommerce' );
?></a>
                </li>
            </ul>
        </div>
        <div class="view-button">
            <a class="button button-primary button-large" target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/plugins' ) ;
?>"><?php 
esc_html_e( 'VIEW ALL', 'size-chart-for-woocommerce' );
?></a>
        </div>
    </div>
    <!-- html end for popular plugin !-->
    <div class="dotstore-sidebar-section">
        <div class="dotstore-important-link-heading">
            <span class="dashicons dashicons-sos"></span>
            <span class="heading-text"><?php 
esc_html_e( 'Five Star Support', 'size-chart-for-woocommerce' );
?></span>
        </div>
        <div class="dotstore-important-link-content">
            <p><?php 
esc_html_e( 'Got a question? Get in touch with theDotstore developers. We are happy to help!', 'size-chart-for-woocommerce' );
?> </p>
            <a target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/support/' ) ;
?>"><?php 
esc_html_e( 'Submit a Ticket »', 'size-chart-for-woocommerce' );
?></a>
        </div>
    </div>
</div>
</div>
</body>
</html>
