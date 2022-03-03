<?php if (cs_get_option('wc-giftwrap') && class_exists('woocommerce')) : ?>
<?php
    $gift_wrap_id = cs_get_option('wc-giftwrap-product');

    if ( !empty($gift_wrap_id) ) {
      $product_wrap = wc_get_product( $gift_wrap_id );
    }

    if (!empty($product_wrap)) :

 ?>
<div class="shipping_calculator tc">
  <p class="field">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="cd dib pr"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
    </svg>
    <span class="gift_wrap_text mt__10 db">
      <span class="cd"><?php esc_html_e('Do you want a gift wrap?', 'kalles'); ?></span><?php esc_html_e('Only', 'kalles'); ?><span class="money">
        <?php The4Helper::ksesHTML( $product_wrap->get_price_html() ); ?>
      </span>
    </span>
   </p>
   <p class="field">
     <a href="#" data-id="<?php echo esc_attr( $gift_wrap_id ); ?>"
        data-skey="<?php echo esc_attr( wp_create_nonce('kalles-add-gift') ); ?>"
        class="w__100 pr tu tc button button_primary truncate js_cart_add_gift"><span><?php esc_html_e('Add A Gift Wrap', 'kalles'); ?></span></a>
   </p>
   <p class="field">
     <a href="#" class="button btn_back btn_back2 js_cart_tls_back"><?php esc_html_e('Cancel', 'kalles'); ?></a>
   </p>
</div>
  <?php else : ?>
    <p class="field">
     <?php esc_html_e('Setup product Wrap first !', 'kalles'); ?>
   </p>
   <p class="field">
     <a href="#" class="button btn_back btn_back2 js_cart_tls_back"><?php esc_html_e('Cancel', 'kalles'); ?></a>
   </p>
  <?php endif; ?>
<?php endif; ?>