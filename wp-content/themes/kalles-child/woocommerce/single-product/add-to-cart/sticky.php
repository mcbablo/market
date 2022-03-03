<?php global $product; ?>
<?php $mobile = boolval(cs_get_option('wc-sticky-atc_mobile')) ? 'true' : 'false'; ?>
<div class="sticky_atc_wrap pf b__0 l__0 r__0 pt__10 pb__10 bgw z_100 mobile_<?php echo esc_attr( $mobile ); ?>">
   <div class="container">
      <div class="row al_center fl_center">
         <div class="col sticky_atc_content">
           <div class="row no-gutters al_center">
             <div class="col-auto sticky_atc_thumb mr__10 flex al_center <?php echo kalles_image_lazyload_class(); ?>">
                <?php echo get_the_post_thumbnail( $product->get_id() ); ?>
             </div>
             <div class="col sticky_atc_info">
                <h4 class="fs__14 mg__0"><?php echo esc_html( $product->get_name() ); ?></h4>
                <?php if ($product->is_type( 'variable' )) : ?>
                    <input class="js_sticky_sl" name="id" value="" type="hidden">
                    <span class="txt_under sticky_atc_a cp fwm"></span>
                <?php endif; ?>
             </div>
           </div>
         </div>
         <div class="col-auto sticky_atc_btn variations_form flex wrap al_center fl_center">
          <div class="sticky_atc_price mr__20 price-review">
            <p class="price"></p>
          </div>
          <?php
            $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );
            $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
            $step      = apply_filters( 'woocommerce_quantity_input_step', 1, $product );

            $max_value = esc_attr( 0 < $max_value ? $max_value : '' );
            $min_value = esc_attr( $min_value );
            $step = esc_attr( $step );
           ?>
            <?php if ( ! $product->is_type( 'grouped' ) ) : ?>
              <div class="quantity pr mr__10 qty__true">
                 <input type="number"
                      class="input-text text tc sticky_input"
                      max="<?php echo esc_attr( $max_value ); ?>"
                      min="<?php echo esc_attr( $min_value ); ?>"
                      step="<?php echo esc_attr( $step ); ?>"
                      value="" inputmode="numeric">
                 <div class="qty tc fs__14">
                  <button type="button" class="sticky_qty_btn plus db cb pa pd__0 pr__15 tr r__0">
                    <i class="t4_icon_t4-plus"></i>
                  </button>
                  <button type="button"
                      class="sticky_qty_btn minus db cb pa pd__0 pl__15 tl l__0 ">
                      <i class="t4_icon_t4-minus"></i>
                  </button>
                </div>
              </div> <!-- .quantity -->
            <?php endif; ?>
          <button type="submit" class="sticky_add_to_cart_btn button alt pr <?php if ($product->is_type( 'variable' )) : ?>disabled <?php endif; ?>" data-ani="none" >
            <span><?php esc_html_e('Add to cart', 'kalles'); ?></span>
          </button>
         </div>
      </div>
   </div>
</div>
<?php
 ?>