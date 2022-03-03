<?php
/**
 * The header layout 7.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<header id="the4-header" class="header-3 <?php echo ( cs_get_option( 'menu-arrow' ) ? ' menu-item-arrow' : '' ); ?> <?php echo esc_attr( ( cs_get_option( 'menu-uppercase' ) ? ' menu-item-uppercase' : '' ) ); ?>" <?php the4_kalles_schema_metadata( array( 'context' => 'header' ) ); ?>>

	<?php
		$mobile_icon = cs_get_option( 'mobile-icon' );
	 ?>
	<div class="header__mid pl__15 pr__15<?php echo esc_attr( ( cs_get_option( 'header-transparent' ) ? ' header__transparent pa w__100' : '' ) ); ?>">
		<div class="main-menu-wrapper"></div>
        <div class="container">
			<div class="row al_center css_h_se">
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
				<div class="col-5 dn db_lg">
					<nav class="the4-navigation tl hover_side_up nav_arrow_false main-menu-left">
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
				<div class="col-lg-2 col-md-4 col-6 tc">
					<?php the4_kalles_logo(); ?>
				</div>
				<div class="col-lg-5 col-md-4 col-3 tr">
					<?php get_template_part('views/common/header-action'); ?>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .header__mid -->
</header><!-- #the4-header -->