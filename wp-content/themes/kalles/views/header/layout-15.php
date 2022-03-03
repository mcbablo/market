<?php
/**
 * The header layout 15.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<header id="the4-header" 
        class="header-3 header-15 <?php echo esc_attr( cs_get_option( 'header-boxed' ) ? ' header-box' : '' ); ?> <?php echo esc_attr( ( cs_get_option( 'menu-arrow' ) ? ' menu-item-arrow' : '' ) ); ?> <?php echo esc_attr( ( cs_get_option( 'menu-uppercase' ) ? ' menu-item-uppercase' : '' ) ); ?>" <?php the4_kalles_schema_metadata( array( 'context' => 'header' ) ); ?>>
    <?php if ( cs_get_option( 'header-countdown' ) ) : ?>
        <?php echo the4_kalles_countdown_banner(); ?>
    <?php endif; ?>
    <?php if ( cs_get_option( 'header-top' ) ) : ?>
        <div class="header__top bgbl fs__12 pl__15 pr__15">
            <div class="container">
                <?php if ( cs_get_option( 'header-top-left' ) || cs_get_option( 'header-top-center' ) || cs_get_option( 'header-currency' ) ) : ?>
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
                    </div><!-- .row -->
                <?php endif; ?>
            </div>
        </div><!-- .header__top -->
    <?php endif; ?>
    <?php
    $mobile_icon = cs_get_option( 'mobile-icon' );
    ?>
    <div class="header__mid pl__15 pr__15<?php echo esc_attr( ( cs_get_option( 'header-transparent' ) ? ' header__transparent pa w__100' : '' ) ); ?>">
		<div class="main-menu-wrapper"></div>
        <div class="container ">
            <div class="row middle-xs al_center">
                <div class="col-md-5 col-4 dn_lg">
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
                <div class="col-lg-5 col-md-5 col-12 dn db_lg">
                    <nav class="the4-navigation flex main-menu-left">
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
                <div class="col-lg-2 col-md-2 col-4 tc">
                    <?php the4_kalles_logo(); ?>
                </div>
                <div class="col-lg-auto col-lg-5 col-md-5 col-4 tr col_group_btns">
                    <?php get_template_part('views/common/header-action'); ?>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .header__mid -->
</header><!-- #the4-header -->