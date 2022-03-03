<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp;
?>
<div class="cat_sortby cat_sortby_js tr dn db_lg col">
    <a class="in_flex fl_between al_center sortby_pick" rel="nofollow" data-no-instant="" href="#">
        <span class="sr_txt"><?php esc_html_e('Sort by', 'kalles'); ?></span>
        <i class="ml__5 mr__5 t4_icon_angle-down-solid dn db_lg"></i>
    </a>
    <div class="nt_sortby dn">
        <svg class="ic_triangle_svg" viewBox="0 0 20 9" role="presentation">
            <path d="M.47108938 9c.2694725-.26871321.57077721-.56867841.90388257-.89986354C3.12384116 6.36134886 5.74788116 3.76338565 9.2467995.30653888c.4145057-.4095171 1.0844277-.40860098 1.4977971.00205122L19.4935156 9H.47108938z" fill="#ffffff"></path>
        </svg>
        <div class="h3 mg__0 tc cd tu ls__2 dn_lg db"><?php esc_html_e( 'Sort by', 'kalles' ); ?>
            <i class="pegk pe-7s-close fs__50 ml__5"></i>
        </div>
        <div class="nt_ajaxsortby wrap_sortby">
            <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                <?php 
                    $filter_link = home_url( add_query_arg( array( $_GET ), $wp->request ) );
                    $filter_link = add_query_arg( 'orderby', esc_attr( $id ), $filter_link ); 
                ?>
                <?php $orderby_class = ( $orderby == $id ) ? 'selected' : ''; ?>
                <a href="<?php echo  esc_url( $filter_link ); ?>"  class="is_pjax_item truncate <?php echo esc_attr( $orderby_class ); ?>"><?php echo esc_html( $name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>