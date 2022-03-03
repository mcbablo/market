<?php
/**
 * The Toolbar Mobile
 *
 * @since   1.0.0
 * @package Kalles
 */


?>
<?php if ( class_exists( 'WooCommerce' ) ) :  ?>
  <?php
    $show_label = cs_get_option('general_mobile_toolbar-label');
    $items = cs_get_option( 'general_mobile_toolbar_items' );
    $the4_check_login = (is_user_logged_in()) ? '' : 'the4-login-register';
    $account_type = cs_get_option( 'woocommerce_account-type' ) ? cs_get_option( 'woocommerce_account-type' )  : 'sidebar';
    $the4_check_login .= ' ' . $account_type;
  ?>
  <?php if (! empty( $items ) ) : ?>
    <div id="kalles-section-toolbar_mobile">
       <div class="kalles_toolbar kalles_toolbar_label_<?php echo esc_attr( $show_label ); ?> ntpf r__0 l__0 b__0 flex fl_between al_center">
          <?php foreach( $items as $item ) : ?>
            <?php $event = isset( $item['event'] ) ? $item['event'] : ''; ?>
            <?php $event = kalles_get_toolbar_mobile_icon_class( $event ); ?>
            <div class="kalles_toolbar_item <?php echo $event; ?>" <?php if ( $event == 'sf-open' ) : ?> data-open="the4-search-opened" <?php endif ?>>
              <a href="<?php echo esc_url( $item['link']['url']); ?>" 
                target="<?php echo esc_url( $item['link']['target']); ?>"
                class="kalles_toolbar_item_link">
                <i class="toolbar_icon <?php echo $item['icon']; ?>"></i>
                <?php if ($show_label) : ?>
                  <span class="kalles_toolbar_label"><?php echo esc_html( $item['title'] ); ?></span>
                <?php endif; ?>
              </a>
            </div>
          <!-- Wishlish local -->
          <?php endforeach; ?>
       </div>
    </div>
  <?php endif; ?>
<?php endif; ?>