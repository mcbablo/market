<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();
$layout       = get_theme_mod( 'store_layout', 'left' );

global $wp_query, $kalles_sc;

$columns = ( isset( $_COOKIE['t4_cat_col'] ) && $_COOKIE['t4_cat_col'] ) ? $_COOKIE['t4_cat_col']  : cs_get_option( 'wc-column' );
$enable  = cs_get_option( 'wc-sidebar-filter' );
$swicher = cs_get_option( 'wc-col-switch' );

$style              = isset( $kalles_sc['style'] ) ? $kalles_sc['style'] : apply_filters( 'the4_kalles_wc_style', cs_get_option( 'wc-style' ) );

get_header( 'shop' );

if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php dokan_get_template_part( 'store-header' ); ?>

        </div>
    </div>
    <div class="row dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

        <?php if ( 'left' === $layout ) { ?>
            <div class="col-lg-3 col-12">
                <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
            </div>
        <?php } ?>
        <div class="col-lg-9 col-12">
            <div id="dokan-primary" class="dokan-single-store">
                <div id="dokan-content" class="store-page-wrap woocommerce" role="main">
                    <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>
                    <?php if ( have_posts() ) { ?>

                        <div class="seller-items">

                            <?php woocommerce_product_loop_start(); ?>

                                <?php while ( have_posts() ) : the_post(); ?>

                                    <?php wc_get_template_part( 'content', 'product' ); ?>

                                <?php endwhile; // end of the loop. ?>

                            <?php woocommerce_product_loop_end(); ?>

                        </div>

                        <?php dokan_content_nav( 'nav-below' ); ?>

                    <?php } else { ?>

                        <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'kalles' ); ?></p>

                    <?php } ?>
                </div>

            </div><!-- .dokan-single-store -->
        </div>

        <?php if ( 'right' === $layout ) { ?>
            <div class="col-lg-3 col-12">
                <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
            </div>
        <?php } ?>

    </div><!-- .dokan-store-wrap -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>
</div>

<?php get_footer( 'shop' ); ?>
