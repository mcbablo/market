<?php
/**
 * The header layout 6.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<header id="the4-header" class="header-3 <?php echo ( cs_get_option( 'menu-arrow' ) ? ' menu-item-arrow' : '' ); ?> <?php echo esc_attr( ( cs_get_option( 'menu-uppercase' ) ? ' menu-item-uppercase' : '' ) ); ?>" <?php the4_kalles_schema_metadata( array( 'context' => 'header' ) ); ?>>
    <?php if ( cs_get_option( 'header-countdown' ) ) : ?>
    	<?php echo the4_kalles_countdown_banner(); ?>
    <?php endif; ?>
    <?php if ( cs_get_option( 'header-top' ) ) : ?>
	<div class="header__top bgbl fs__12 pl__15 pr__15">
        <div class="container">
			<?php if ( cs_get_option( 'header-top-left' ) || cs_get_option( 'header-top-center' ) || cs_get_option( 'header-currency' ) ) : ?>
			<div class="row middle-xs pt__10 pb__10">
				<div class="col-lg-3 col-12 tc tl_lg col-md-12 dn_false_1024">
					<?php echo the4_kalles_social(); ?>
				</div>
				<div class="col-lg-6 col-12 tc col-md-12 dn_false_1024">
					<?php if ( cs_get_option( 'header-top-center' ) ) : ?>
						<div class="header-text"><?php echo do_shortcode( cs_get_option( 'header-top-center' ) ); ?></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-3 col-12 tc col-md-12 tr_lg dn_false_1024">
					<?php
						if ( class_exists( 'WooCommerce' ) && cs_get_option( 'header-currency' ) ) {
							echo the4_kalles_wc_currency();
						}
					?>
				</div>
			</div><!-- .row -->
			<?php endif; ?>
        </div>
	</div><!-- .header__top -->
    <?php endif; ?>
	<?php
		$mobile_icon = cs_get_option( 'mobile-icon' );
	 ?>
	<div class="header__mid pl__15 pr__15<?php echo esc_attr( ( cs_get_option( 'header-transparent' ) ? ' header__transparent pa w__100' : '' ) ); ?>">
		 <div class="container">
			<div class="row middle-xs al_center css_h_se">
				<div class="col-md-4 col-3 dn_lg">
					<a href="javascript:void(0);" class="the4-push-menu-btn hide-md visible-sm visible-xs">
						<?php
							if ( !empty($mobile_icon['url']) ) :
								$icon = wp_get_attachment_image_src( $mobile_icon['id'], 'full', true );
								echo '<img src="' . esc_url( $icon[0] ) . '" width="30" height="30" alt="Menu" />';
							else :
								echo '<img src="' . THE4_KALLES_URL . '/assets/images/icons/hamburger-black.svg" width="30" height="16" alt="Menu" />';
							endif;
						?>
					</a>
				</div>
				<div class="col-lg-3 col-md-4 col-6 tc tl_lg">
					<?php the4_kalles_logo(); ?>
				</div>
				<div class="col-6 dn db_lg cl_h_search">
					<div class="cl_h_search atc_opended_rs">
					    <div class="the4_mini_cart flex column h__100">
					        <div class="mini_cart_wrap">

					            <?php the4_get_search_form_full(); ?>

					            <div class="pr">
					            <div class="ld_bar_search"></div>
					            <div class="the4-woocommere-search__content search_header__content mini_cart_content widget fixcl-scroll">
					                <div class="product_list_widget fixcl-scroll-content">
					                    <div class="skeleton_wrap skeleton_js dn">
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
					                    </div> <!-- .skeleton_wrap -->
					                    <div class="the4-search-results">
					                        <?php if (cs_get_option('wc-search_inspiration_enable') && !empty(cs_get_option('wc-search_inspiration_cat'))) : ?>
					                        <?php
					                            $categories = cs_get_option('wc-search_inspiration_cat');
					                            $search_special_cat = the4_kalles_get_products ( $categories, true, 5);

					                        ?>
					                        <?php $currency   = get_woocommerce_currency_symbol(); ?>
					                        <?php  if ($search_special_cat->have_posts()) : while ( $search_special_cat->have_posts() ) : $search_special_cat->the_post(); ?>
					                        <?php

					                            $product = wc_get_product( get_the_ID());
					                            $price = $product->get_price();
					                            $price_sale = $product->get_sale_price();
					                            $price_regular = ($price == $price_sale) ? $product->get_regular_price() : $price;
					                        ?>
					                            <div class="row mb__10 pb__10 ">
					                                <div class="col widget_img_pr">
					                                    <a class="db pr oh" href="<?php echo esc_url( get_the_permalink() ); ?>">
					                                        <img class="w__100"
					                                             src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'thumbnail')) ?>">
					                                    </a>
					                                </div>
					                                <div class="col widget_if_pr">
					                                    <a class="product-title db pr oh" href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo get_the_title(); ?></a>
					                                    <?php if ($price) : ?>
					                                    <p class="price">
					                                        <?php if ($price_sale) : ?>
					                                        <del>
					                                        <?php endif; ?>
					                                            <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ); ?></span>
					                                            <span class="woocommerce-Price-amount amount">
					                                                <bdi><?php The4Helper::ksesHTML( $price_regular ); ?></bdi>
					                                            </span>
					                                        <?php if ($price_sale) : ?>
					                                        </del>
					                                        <?php endif; ?>
					                                        <?php if ($price_sale) : ?>
					                                        <span class="woocommerce-Price-currencySymbol"><?php echo esc_html( $currency ) ?></span>
					                                        <ins>
					                                            <span class="woocommerce-Price-amount amount">
					                                                <bdi><?php The4Helper::ksesHTML( $price_sale ) ?></bdi>
					                                            </span>
					                                        </ins>
					                                        <?php endif; ?>
					                                    </p>
					                                    <?php endif; ?>
					                                </div>
					                            </div>  <!-- .row mb__10 pb__10 -->
					                        <?php endwhile; ?>
					                        <!-- .js_prs_search row fl_center -->
					                    <?php endif; ?>
					                        <?php wp_reset_postdata(); ?>
					                            <?php 
						                            $cat_id = (int) $categories;
						                            $cat_info = get_term( $cat_id, 'product_cat' );
						                        ?>
						                        <?php if ( is_object( $cat_info ) ) : ?>
						                            <a href="<?php echo esc_url( get_term_link( $cat_info->slug, 'product_cat') ); ?>" class="db fwsb detail_link"><?php esc_html_e('View All', 'kalles') ?><i class="t4_icon_arrow-right-solid fs__18"></i></a>
						                        <?php endif; ?>
					                        <?php endif; ?>
					                    </div><!-- .the4-search-results -->

					                </div> <!-- product_list_widget -->
					            </div> <!-- the4-woocommere-search__content -->
					        </div> <!-- .pr -->
					        </div> <!-- .mini_cart_wrap -->

					    </div> <!-- .the4_mini_cart -->


					</div> <!-- .the4-woocommere-search the4-push-menu -->
				</div>
				<div class="col-lg-3 col-md-4 col-3 tr">
					<?php get_template_part('views/common/header-action'); ?>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .header__mid -->
	<div class="header__bot border_false dn db_lg">
		<div class="container">
			<div class="row al_center">
				<div class="col-auto ha8_cat">
					<h5 class="mg__0 fs__14 flex al_center">
						<i class="t4_icon_bars-solid mr__5 fs__18"></i>
						<span class="dib truncate"><?php esc_html_e('Shop by category', 'kalles') ?></span>
					</h5>
					<div class="h_cat_nav pa op__0 mh_js_cat">
						<?php
				        wp_nav_menu(
				            array(
				                'theme_location' => 'categories-menu',
				                'container_id'   => 'header-bottom-menu',
				                'walker'         => new THE4_Kalles_Mobile_Menu_Walker(),
				                'fallback_cb'    => NULL
				            )
				        );
				        ?>
					</div>
				</div>
				<div class="col ha8_nav">
					<nav class="the4-navigation flex ml__20">
						<?php
							if ( has_nav_menu( 'primary-menu' ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'primary-menu',
										'menu_class'     => 'the4-menu clearfix',
										'menu_id'        => 'the4-menu',
										'container'      => false,
										'walker'         => new THE4_Kalles_Menu_Walker(),
										'fallback_cb'    => NULL
									)
								);
							} else {
								echo '<ul class="the4-menu clearfix"><li><a target="_blank" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add Menu', 'kalles' ) . '</a></li></ul>';
							}
						?>
					</nav><!-- .the4-navigation -->
				</div>
				<div class="col-3 fs__12 ha8_txt tr">
					<?php if ( cs_get_option( 'header-top-left' ) ) : ?>
						<div class="header-text"><?php echo do_shortcode( cs_get_option( 'header-top-left' ) ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>




</header><!-- #the4-header -->