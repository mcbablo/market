<?php
/**
 * The Sale Popup
 *
 * @since   1.0.0
 * @package Kalles
 */

$sale_popup_type = cs_get_option('popup-sale_type') ?cs_get_option('popup-sale_type') : 'manual';
$sale_popup_product                   = array();
$sale_popup_product['id']             = array();
$sale_popup_product['link']           = array();
$sale_popup_product['title']          = array();
$sale_popup_product['image']          = array();
$sale_popup_product['user_purchased'] = array();
$sale_popup_product['time_sale']      = array();
$user_purchased = '';
$time_sale = '';
if ($sale_popup_type == 'manual') {
  $categories = cs_get_option('popup-sale_category') ? cs_get_option('popup-sale_category') : '';
  if (!empty($categories)) {

      $products = the4_kalles_get_products ( $categories );

      if ( !empty($products) ) {
        foreach ($products as $item) {
          $product = wc_get_product( $item->ID );
          $product_id = $product->get_id();
          $sale_popup_product['id'][] = $product_id;
          $sale_popup_product['link'][] = get_the_permalink($product_id);
          $sale_popup_product['title'][] = get_the_title($product_id);
          $pr_thumbnail_id = get_post_thumbnail_id( $product_id );
          $image = wp_get_attachment_image_src( $pr_thumbnail_id, 'thumbnail' );
          if ( ! $image ) {
            $image = wc_placeholder_img_src( 'thumbnail' );

          }
          
          $sale_popup_product['image'][] = $image[0];
        }
      }
    wp_reset_postdata();
    $user_purchased =  cs_get_option('popup-sale_btn_purchase_list') ? cs_get_option('popup-sale_btn_purchase_list') : '';
    $user_purchased = str_replace('|', ',', $user_purchased);
    $user_purchased = explode(',', $user_purchased );

    $time_sale =  cs_get_option('popup-sale_btn_list_time') ? cs_get_option('popup-sale_btn_list_time') : '';
    $time_sale = str_replace('|', ',', $time_sale);
    $time_sale = explode(',', $time_sale);
  }

} else {
   $products = the4_kalles_get_purchased_order ();

   if ( !empty($products) ) {
      foreach ($products as $product) {
        $sale_popup_product['id'][]            = $product['product_id'];
        $sale_popup_product['link'][]          = get_the_permalink($product['product_id']);
        $sale_popup_product['title'][]         = get_the_title($product['product_id']);
        $sale_popup_product['image'][]         = $product['product_image'];
        $sale_popup_product['customer_info'][] = $product['customer_info'];
        $sale_popup_product['time'][]          = $product['order_time'];
      }
      $user_purchased = $sale_popup_product['customer_info'];
      $time_sale      = $sale_popup_product['time'];
    }
}

$products_id    = json_encode($sale_popup_product['id']);
$products_link  = json_encode($sale_popup_product['link']);
$products_title = json_encode($sale_popup_product['title']);
$products_image = json_encode($sale_popup_product['image']);
$page_dispay    = cs_get_option('popup-sale_page');

$sale_data_js = array(
  'sale_title' => $sale_popup_product['title'],
  'sale_time' => $time_sale,
  'sale_location' => $user_purchased,
);

// Inline script
wp_localize_script( 'the4-kalles-script', 'kalles_sale_popup', $sale_data_js );

$body_class = get_body_class();
$check_page = is_array( $page_dispay ) ? array_intersect($page_dispay, $body_class) : '';
$display = 0;

if ( is_array( $page_dispay ) ) {
  if ( in_array('all', $page_dispay ) || ! empty( $check_page ) ) $display = 1;
} else {
  $display = 1;
}

$start_time = cs_get_option('popup-sale_start_time') ? cs_get_option('popup-sale_start_time') : 3;
$stay_time  = cs_get_option('popup-sale_stay_time') ? cs_get_option('popup-sale_stay_time') : 5;

//check btn close + quickview
$check_btn = false;
if (cs_get_option('popup-sale_btn_close') == true || cs_get_option('popup-sale_btn_quickview') == true)
  $check_btn = true;

?>
<?php if ($products_id != '[]' && ! wp_is_mobile()) : ?>
<div id="kalles-section-sales_popup">
  <div class="popup_slpr_wrap sales_animated oh des_1 slpr_mb_ dn
        <?php if ($check_btn) echo 'slpr_has_btns'; ?>
         des_<?php echo esc_attr( cs_get_option('popup-sale_popup_design_option') ); ?>"
    data-display="<?php echo esc_attr( $display ); ?>"
    data-stt='{
     "classDown":{
      "aniswing":"anibounceOutDown","anishake":"anibounceOutDown","aniwobble":"anibounceOutDown","anijello":"anibounceOutDown","anislideInUp":"anislideOutDown","anislideInLeft":"anislideOutLeft","anifadeIn":"anifadeOut","anifadeInLeft":"anifadeOutLeft","anibounceInUp":"anibounceOutDown","anibounceInLeft":"anibounceOutLeft","anirotateInDownLeft":"anirotateOutDownLeft","anirotateInUpLeft":"anirotateOutDownLeft","aniflipInX":"aniflipOutX","anizoomIn":"anizoomOut","anirollIn":"anirollOut"
    },
    "limit": 50,
    "pp_type": <?php echo esc_attr( cs_get_option('popup-sale_type_option') ); ?>,
    "id": <?php echo esc_attr( $products_id ); ?>,
    "url": <?php echo esc_attr( $products_link ); ?>,
    "image": <?php echo esc_attr( $products_image ); ?>,
    "StarTime": <?php echo esc_attr( $start_time ); ?>,
    "StarTime_unit": <?php echo esc_attr( cs_get_option('popup-sale_start_unit') ); ?>,
    "StayTime": <?php echo esc_attr( $stay_time ); ?>,
    "StayTime_unit": <?php echo esc_attr( cs_get_option('popup-sale_stay_unit') ); ?>,
    "ClassUp": "<?php echo esc_attr( cs_get_option('popup-sale_animaton') ); ?>"
    }'>
   <div class="row al_center no-gutters fl_nowrap pr">
      <div class="col-auto popup_slpr_thumb">
         <a href="" class="db pr oh js_slpr_a the4-lazyload"><img class="js_slpr_img lazyload" src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2050%2050%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" srcset="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2050%2050%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E" alt="sales popup"></a>
      </div>
      <div class="col popup_slpr_info">
           <span class="db mb__5 fs__12">
            <span class="cb fs__13 js_slpr_location"></span> <?php echo esc_html( cs_get_option('popup-sale_purchase_text') ); ?>
           </span>
           <a href="/products/asos-ridley-high-waist" class="js_slpr_a pp_slpr_title db mb__5 fs__13 tu truncate js_slpr_tt">

           </a>
           <div class="pp_slpr_ago fs__12">
            <?php if(cs_get_option('popup-sale_show_time_ago') == true) :  ?>
              <span class="pp_slpr_time js_slpr_ago"></span>
            <?php endif; ?>
            <?php if(cs_get_option('popup-sale_show_vefify') == true) :  ?>
              <span class="pp_slpr_verify cb fs__13"><i class="las la-check-circle"></i>
                <?php echo esc_html( cs_get_option('popup-sale_verify_text') ); ?>
              </span>
            <?php endif; ?>
           </div>
      </div>
      <?php if (cs_get_option('popup-sale_btn_close') == true) : ?>
        <a class="pp_slpr_close pa op__0" href="#" rel="nofollow">
          <i class="t4_icon_times-solid"></i>
        </a>
      <?php endif; ?>
      <?php if (cs_get_option('popup-sale_btn_quickview') == true) : ?>
        <a href="javascript:void(0);" data-prod="" rel="nofollow" class="js_slpr_a btn-quickview pp_slpr_qv pa op__0">
          <span class="ttip_nt tooltip_left"><i class="t4_icon_t4-eye"></i>
            <span class="tt_txt"><?php esc_html_e( 'Quick view', 'kalles' ) ?></span>
          </span>
        </a>
    <?php endif; ?>
  </div>
</div>
</div>
<?php endif; ?>