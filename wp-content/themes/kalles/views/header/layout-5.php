<?php
/**
 * The header layout 5.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<header id="the4-header" class="header-5 pf <?php echo esc_attr( ( cs_get_option( 'menu-uppercase' ) ? ' menu-item-uppercase' : '' ) ); ?>" <?php the4_kalles_schema_metadata( array( 'context' => 'header' ) ); ?>>

	<!-- <i class="close-menu hide-md visible-1024 pe-7s-close pa"></i> -->
	<div class="header__mid pl__15 pr__15">
        <div class="row al_center ">
			<div class="col-lg-12 col-6 tc">
				<?php the4_kalles_logo(); ?>
			</div>
			<div class="the4-action col-lg-12 col-3 cl_h7_btns tc mt__30 js_center in_flex tc">
				<?php if ( cs_get_option( 'header-search-icon' ) ) : ?>
					<a class="sf-open cb chp" data-open="the4-search-opened" href="javascript:void(0);" title="<?php echo esc_attr( 'Search', 'kalles' ); ?>"><i class="pe-7s-search"></i></a>
				<?php endif; ?>
				
				<?php
					if ( class_exists( 'WooCommerce' ) ) {
						echo the4_kalles_wc_my_account();
						if ( class_exists( 'YITH_WCWL' ) ) {
							global $yith_wcwl;
							echo '<a class="cb chp" href="' . esc_url( $yith_wcwl->get_wishlist_url() ) . '" title="' .  esc_attr( 'View your Wishlist', 'kalles' ) . '"><i class="pe-7s-like"></i></a>';
						}
						echo the4_kalles_wc_shopping_cart();
					}
				?>
			</div>
			<div class="col-lg-12 tc cl_h7_group mt__20 dn db_lg">
				<?php
					if ( class_exists( 'WooCommerce' ) && cs_get_option( 'header-currency' ) ) {
						echo the4_kalles_wc_currency();
					}
				?>
			</div>
			<nav class="the4-navigation col-12 dn db_lg mt__10 mb__30 tc">
				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'primary-menu',
							'container_id'    => 'the4-mobile-menu',
							'walker'          => new THE4_Kalles_Mobile_Menu_Walker(),
							'fallback_cb'     => NULL
						)
					);
				?>
			</nav><!-- .the4-navigation -->
			<div class="col-12 dn db_lg tc">
				<?php echo the4_kalles_social(); ?>
			</div>
		</div>
	</div> <!-- row al_center -->
</header><!-- #the4-header -->
<?php
	$mobile_icon = cs_get_option( 'mobile-icon' );
?>


	<?php if ( cs_get_option( 'header-countdown' ) ) : ?>
		<div class="hidden-xs">
			<?php echo the4_kalles_countdown_banner(); ?>
		</div>
    <?php endif; ?>
    <?php if ( cs_get_option( 'header-top' ) ) : ?>
    <div class="header__top bgbl fs__12 pl__15 pr__15">

	<?php if ( cs_get_option( 'header-top-left' ) || cs_get_option( 'header-top-center' ) || cs_get_option( 'header-currency' ) ) : ?>
		<?php if ( cs_get_option( 'header-boxed' ) ) : echo '<div class="container">'; endif; ?>

			<div class="row middle-xs pt__10 pb__10 al_center">
				<div class="col-lg-4 col-12 tc tl_lg col-md-12 dn_false_1024">
					<?php if ( cs_get_option( 'header-top-left' ) ) : ?>
						<div class="header-text"><?php echo do_shortcode( cs_get_option( 'header-top-left' ) ); ?></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-12 tc col-md-12 dn_false_1024">
					<?php if ( cs_get_option( 'header-top-center' ) ) : ?>
						<div class="header-text"><?php echo do_shortcode( cs_get_option( 'header-top-center' ) ); ?></div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4 col-12 tc col-md-12 tr_lg dn_false_1024">
						<?php
							if ( class_exists( 'WooCommerce' ) && cs_get_option( 'header-currency' ) ) {
								echo the4_kalles_wc_currency();
							}
						?>

				</div>
			</div>
		<?php if ( cs_get_option( 'header-boxed' ) ) : echo '</div>'; endif; ?>
	<?php endif; ?>
	</div><!-- .header__top -->
    <?php endif; ?>
    <div class="pl__15 pr__15 pb__15 pt__15 hide-md visible-1024 top-menu w__100">
        <div class="row middle-xs al_center">
            <div class="col-lg-12 col-3 dn_lg">
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
            <div class="col-lg-12 col-6 tc">
                <?php the4_kalles_logo(); ?>
            </div>
            <div class="col-lg-12 col-3 cl_h7_btns tr">
                <?php get_template_part('views/common/header-action'); ?>

            </div>
        </div><!-- .row -->
    </div><!-- .header__mid -->