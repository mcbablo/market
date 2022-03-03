<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query, $kalles_sc;

if ( ! woocommerce_products_will_display() )
	return;

$columns = ( isset( $_COOKIE['t4_cat_col'] ) && $_COOKIE['t4_cat_col'] ) ? $_COOKIE['t4_cat_col']  : cs_get_option( 'wc-column' );
$enable  = cs_get_option( 'wc-sidebar-filter' );
$swicher = cs_get_option( 'wc-col-switch' );
$sfilter_position = ( cs_get_option( 'wc-sidebar-filter-position' ) == 'top' || cs_get_option( 'wc-sidebar-filter-position' ) == 'top_show'  ) ? 'top' : 'sidebar';
if ( wp_is_mobile() )
    $sfilter_position = 'sidebar';

$is_slidebar        = ( cs_get_option('wc-layout') != 'no-sidebar' ) ? true : false;
$is_slidebar_hidden = ( cs_get_option('wc-layout') == 'hidden-sidebar' ) ? 'true' : 'false';
$style              = isset( $kalles_sc['style'] ) ? $kalles_sc['style'] : apply_filters( 'the4_kalles_wc_style', cs_get_option( 'wc-style' ) );

if ( $enable ) : ?>
    <div class="cat_filter col">
	   <a class="filter-trigger mr__50 btn_filter js_filter mgr <?php echo esc_attr( $sfilter_position ); ?>"><i class="t4_icon_sliders fwb mr__5"></i><?php esc_html_e( 'Filter', 'kalles' ) ?></a>
    </div>
<?php endif; ?>

<?php if ( $swicher ) : ?>
	<div class="wc-col-switch cat_view col js_center<?php if ($style == 'metro') echo ' dn'; ?>">
        <div class="flex">
            <a href="#" class="pr list mr__10 dn_xs <?php if ($columns == 'listt4') echo ' active'; ?>" data-mode="list" data-skey="<?php echo  esc_attr( wp_create_nonce( 'the4_kalles_set_colunm_view' ) ); ?>" data-col="listt4"></a>
            <a href="#" data-mode="grid" data-skey="<?php echo esc_attr( wp_create_nonce( 'the4_kalles_set_colunm_view' ) ); ?>" class="pr one hide-md hidden-sm visible-xs mr__10 <?php if ($columns == '12') echo esc_attr( 'active'); ?>" data-col="12" ></a>
            <a href="#" data-mode="grid" data-skey="<?php echo  esc_attr( wp_create_nonce( 'the4_kalles_set_colunm_view' ) ); ?>" class="pr two mr__10 <?php if ($columns == '6') echo esc_attr( 'active' ); ?>" data-col="6"></a>
            <a href="#" data-mode="grid" data-skey="<?php echo  esc_attr( wp_create_nonce( 'the4_kalles_set_colunm_view' ) ); ?>" class="pr hidden-xs three mr__10 <?php if ($columns == '4') echo esc_attr( 'active'); ?>" data-col="4"></a>
            <a href="#" data-mode="grid" data-skey="<?php echo  esc_attr( wp_create_nonce( 'the4_kalles_set_colunm_view' ) ); ?>" class="pr hidden-sm four mr__10 <?php if ($columns == '3') echo esc_attr('active'); ?>" data-col="3"></a>
            <?php if ( !$is_slidebar ) : ?>
              <a href="#" data-mode="grid" data-skey="<?php echo  esc_attr( wp_create_nonce( 'the4_kalles_set_colunm_view' ) ); ?>" class="pr hidden-sm six <?php if ($columns == '2') echo esc_attr( 'active'); ?>" data-col="2"></a>
            <?php endif; ?>
        </div>
	</div>
<?php endif; ?>
<div class="cat_hidden_<?php echo esc_attr( $is_slidebar_hidden ); ?> tr dn_lg col">
    <div class="cat_sidebar">
        <a rel="nofollow" data-no-instant="" href="#" data-opennt=".product-list-slidebar " data-pos="right" data-remove="true" data-class="popup_filter" data-bg="hide_btn" class="has_icon btn_sidebar mgr op__0">
            <i class="t4_icon_trello fwb mr__5"></i><?php esc_html_e( 'sidebar', 'kalles' ) ?>
        </a>
    </div>
</div>
