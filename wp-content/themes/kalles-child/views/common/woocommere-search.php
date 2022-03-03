<?php
/**
 * The Woocommere Search
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<?php
$search_layout = cs_get_option( 'wc-search_layout' );
$full_width_search =  ( cs_get_option( 'header-layout' ) == 5 || $search_layout == 'fullwidth' ) ? 'nt_fk_full' : '';
$full_top_search =  ( $search_layout == 'on_top' ) ? 'nt_fk_full search_on_top' : '';
$check_full_width = false;
$search_inspiration = cs_get_option('wc-search_inspiration_enable');
$cat_inspiration = cs_get_option('wc-search_inspiration_cat');

if ( cs_get_option( 'header-layout' ) == 5 || $search_layout == 'fullwidth' || $search_layout == 'on_top' ) {
    $check_full_width = true;
}

?>
<div class="the4-woocommere-search  the4-push-menu <?php echo esc_attr( $full_width_search ); ?><?php echo esc_attr( $full_top_search ); ?>">
    <div class="the4_mini_cart flex column h__100">
        <div class="the4-account-ajax__header flex fl_between al_center">
            <h3 class="mg__0 tc cb tu"><?php esc_html_e( 'Search our site', 'kalles' );?> <i class="close-cart pe-7s-close pa cb ts__03"></i></h3>
        </div>
        <div class="mini_cart_wrap">
            <?php if ( cs_get_option( 'wc-search_layout' ) == 'on_top' ) : ?>
                <div class="the4-search-top-header">
                    <div class="row middle-xs al_center">
                        <div class="col-lg-2 col-md-2 col-4 tc tl_lg dn db_lg">
                            <?php the4_kalles_logo(); ?>
                        </div>
                        <div class="col-lg-8 col-md-12 col-12">
                            <div class="mini_cart_wrap">
                                <?php the4_get_search_form( $check_full_width ); ?>

                            </div> <!-- .mini_cart_wrap -->
                        </div>
                        <div class="col-lg-auto col-lg-2 col-md-5 col-4 tr col_group_btns dn db_lg">
                            <?php get_template_part('views/common/header-action'); ?>
                        </div>
                    </div><!-- .row -->

                </div>
            <?php else :
                the4_get_search_form( $check_full_width ); 
            endif; ?>

            <div class="search_header__prs fwsb cd <?php if ( ! $search_inspiration ) :  ?>dn<?php endif; ?>">
                <div class="ld_bar_search"></div>
                <?php if ( $search_inspiration && !empty( $cat_inspiration ) ) : ?>
                    <span class="h_suggest"><?php echo cs_get_option('wc-search_inspiration_text') ?></span>
                <?php endif; ?>
                <span class="h_results dn"><?php esc_html_e('Search Results:', 'kalles') ?></span>
            </div> <!-- .search_header__prs -->
            <div class="the4-woocommere-search__content search_header__content mini_cart_content widget fixcl-scroll">
                <div class="product_list_widget fixcl-scroll-content">
                    <div class="skeleton_wrap skeleton_js dn">
                        <?php if ($check_full_width == true) : ?>
                            <div class="js_prs_search row fl_center">
                                <div class="col-auto tc mr__10">
                                    <div class="row mb__10 pb__10">
                                        <div class="col-12 "><div class="skeleton_img"></div></div>
                                        <div class="col-12"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                                    </div>
                                </div>
                                <div class="col-auto tc mr__10">
                                    <div class="row mb__10 pb__10">
                                        <div class="col-12 "><div class="skeleton_img"></div></div>
                                        <div class="col-12"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                                    </div>
                                </div>
                                <div class="col-auto tc mr__10">
                                    <div class="row mb__10 pb__10">
                                        <div class="col-12 "><div class="skeleton_img"></div></div>
                                        <div class="col-12"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                                    </div>
                                </div>
                                <div class="col-auto tc">
                                    <div class="row mb__10 pb__10">
                                        <div class="col-12 "><div class="skeleton_img"></div></div>
                                        <div class="col-12"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="row mb__10 pb__10">
                                <div class="col-auto widget_img_pr"><div class="skeleton_img"></div></div>
                                <div class="col widget_if_pr"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                            </div>
                            <div class="row mb__10 pb__10">
                                <div class="col-auto widget_img_pr"><div class="skeleton_img"></div></div>
                                <div class="col widget_if_pr"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                            </div>
                            <div class="row mb__10 pb__10">
                                <div class="col-auto widget_img_pr"><div class="skeleton_img"></div></div>
                                <div class="col widget_if_pr"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                            </div>
                            <div class="row mb__10 pb__10">
                                <div class="col-auto widget_img_pr"><div class="skeleton_img"></div></div>
                                <div class="col widget_if_pr"><div class="skeleton_txt1"></div><div class="skeleton_txt2"></div></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="the4-search-results">
                        <?php if ( $search_inspiration && !empty( $cat_inspiration ) ) : ?>
                            <?php
                            $categories = cs_get_option('wc-search_inspiration_cat');
                            $search_special_cat = the4_kalles_get_products ( $categories, true, 5);
                            ?>
                            <?php $currency   = get_woocommerce_currency_symbol(); ?>
                            <?php if ($check_full_width == true) : ?>
                                <div class="js_prs_search row fl_center">
                            <?php endif; ?>
                            <?php  if ($search_special_cat->have_posts()) : while ( $search_special_cat->have_posts() ) : $search_special_cat->the_post(); ?>
                                <?php

                                $product = wc_get_product( get_the_ID());
                                $price = $product->get_price();
                                $price_sale = $product->get_sale_price();
                                $price_regular = ($price == $price_sale) ? $product->get_regular_price() : $price;
                                ?>
                                <?php if ($check_full_width == true) : ?>
                                    <div class="col-auto tc">
                                        <div class="row mb__10 pb__10 ">
                                            <div class="col-12">
                                                <div class="img_fix_search">
                                                    <a class="db pr oh" href="<?php echo get_the_permalink(); ?>">
                                                        <?php if ( kalles_image_lazyload_class() ) : ?>
                                                            <div class="the4-lazyload img_fix_search_img_wrapper">
                                                                <img class="w__100 lazyload" alt="<?php echo get_the_title(); ?>"
                                                                     src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20170%20225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E"
                                                                     data-src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'shop_catalog')) ?>">
                                                            </div>
                                                        <?php else : ?>
                                                            <img class="w__100" alt="<?php echo get_the_title(); ?>" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'shop_catalog')) ?>">
                                                        <?php endif; ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-12 mt__10">
                                                <a class="product-title db pr oh" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                                <?php if ($price) : ?>
                                                    <p class="price">
                                                        <?php if ($price_sale) : ?>
                                                        <del>
                                                            <?php endif; ?>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <bdi><?php The4Helper::ksesHTML( $price_regular ); ?></bdi>
                                                                </span>
                                                                <span class="woocommerce-Price-currencySymbol"> <?php echo esc_html( $currency ); ?></span>
                                                            <?php if ($price_sale) : ?>
                                                        </del>
                                                    <?php endif; ?>
                                                        <?php if ($price_sale) : ?>
                                                            <ins>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <bdi><?php The4Helper::ksesHTML( $price_sale ); ?></bdi>
                                                                </span>
                                                            </ins>
                                                            <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ); ?></span>
                                                        <?php endif; ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>  <!-- .row mb__10 pb__10 -->
                                    </div> <!-- .col-auto tc -->
                                <?php else : ?>
                                    <div class="row mb__10 pb__10 ">
                                        <div class="col widget_img_pr">
                                            <a class="db pr oh" href="<?php echo get_the_permalink(); ?>">
                                                <?php if ( kalles_image_lazyload_class() ) : ?>
                                                    <div class="the4-lazyload img_fix_search_img_wrapper">
                                                        <img class="w__100 lazyload" alt="<?php echo get_the_title(); ?>"
                                                             src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2080%20102%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E"
                                                             data-src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'shop_catalog')) ?>">
                                                    </div>
                                                <?php else : ?>
                                                    <img class="w__100" alt="<?php echo get_the_title(); ?>" src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'shop_catalog')) ?>">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="col widget_if_pr">
                                            <a class="product-title db pr oh" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                            <?php if ($price) : ?>
                                                <p class="price">
                                                    <?php if ($price_sale) : ?>
                                                    <del>
                                                        <?php endif; ?>
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi><?php The4Helper::ksesHTML( $price_regular ); ?></bdi>
                                                            </span>
                                                            <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ); ?></span>
                                                        <?php if ($price_sale) : ?>
                                                    </del>
                                                <?php endif; ?>
                                                    <?php if ($price_sale) : ?>
                                                        <ins>
                                                            <span class="woocommerce-Price-amount amount">
                                                                <bdi><?php The4Helper::ksesHTML( $price_sale ); ?></bdi>
                                                            </span>
                                                        </ins>
                                                        <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ); ?></span>
                                                    <?php endif; ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>  <!-- .row mb__10 pb__10 -->
                                <?php endif; ?> <!-- End if check_full_width -->
                            <?php endwhile; ?>

                            <?php endif; ?>
                            <!-- .js_prs_search row fl_center -->
                            <?php if ($check_full_width == true) : ?>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>


                        <?php endif; ?>
                    </div><!-- .the4-search-results -->

                </div> <!-- product_list_widget -->
            </div> <!-- the4-woocommere-search__content -->
        </div> <!-- .mini_cart_wrap -->

    </div> <!-- .the4_mini_cart -->

</div> <!-- .the4-woocommere-search the4-push-menu -->

