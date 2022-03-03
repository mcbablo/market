<?php
/**
 * The Mobile menu
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<?php
    $has_nav_categories_mobile = has_nav_menu('categories-mobile-menu');
?>
<div class="the4-canvas-menu nt_sleft the4-push-menu">
    <!-- <i class="close-menu pegk pe-7s-close ts__03 cd"></i> -->
    <div class="mb_nav_tabs flex al_center mb_cat_true">
        <div class="mb_nav_title pr mb_nav_ul flex al_center fl_center active <?php if ( ! $has_nav_categories_mobile ) : ?> mb_nav_title_full <?php endif; ?>" data-id="#kalles-section-mb_nav_js">
            <span class="d-block truncate"><?php esc_html_e( 'Menu', 'kalles' ); ?> </span>
        </div>
        <?php if ( $has_nav_categories_mobile ) : ?>
            <div class="mb_nav_title pr flex al_center fl_center" data-id="#kalles-section-mb_cat_js">
                <span class="d-block truncate"><?php esc_html_e( 'Categories', 'kalles' ); ?> </span>
            </div>
        <?php endif; ?>
    </div>
    <div id="kalles-section-mb_nav_js" class="mb_nav_tab active">
        <?php
            if ( has_nav_menu('mobile-menu') ) {
                wp_nav_menu(
                    array(
                        'theme_location' => 'mobile-menu',
                        'container_id'   => 'the4-mobile-menu',
                        'walker'         => new THE4_Kalles_Mobile_Menu_Walker(),
                        'fallback_cb'    => NULL
                    )
                );
            } else {
                if ( has_nav_menu( 'primary-menu' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary-menu',
                            'container_id'   => 'the4-mobile-menu',
                            'walker'         => new THE4_Kalles_Mobile_Menu_Walker(),
                            'fallback_cb'    => NULL
                        )
                    );
                } else {
                    echo '<ul class="the4-mobilenav-bottom"><li class="menu-item menu-item-btns"><a target="_blank" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add Menu', 'kalles' ) . '</a></li></ul>';
                }
            }
        ?>
        <ul class="the4-mobilenav-bottom">

            <li class="menu-item menu-item-btns menu-item-wishlist">
                <?php
                if ( class_exists( 'WooCommerce' ) ) {
                    if ( class_exists( 'YITH_WCWL' ) ) {
                        global $yith_wcwl;
                        echo '<a class="cb chp wishlist-icon" href="' . esc_url( $yith_wcwl->get_wishlist_url() ) . '">
                                <i class="iccl iccl-heart pr"></i>
                                '. esc_html__( 'Wishlist', 'kalles' ) .'
                               </a>';
                    }
                }
                ?>
            </li>
            <li class="menu-item menu-item-btns menu-item-sea push_side">
                <?php if ( cs_get_option( 'header-search-icon' ) && class_exists( 'WooCommerce' ) ) : ?>
                    <a class="sf-open cb chp" data-open="the4-search-opened" href="javascript:void(0);"><i class="t4_icon_search-solid"></i><?php echo esc_html__( ' Search', 'kalles' ); ?></a>
                <?php endif; ?>
            </li>
            <li class="menu-item menu-item-btns menu-item-acount">
                <?php
                if ( class_exists( 'WooCommerce' ) ) {
                    if ( cs_get_option( 'header-my-account-icon' ) ) {
                        if ( is_user_logged_in() ) {
                            echo '<a class="cb chp db the4-my-account" 
                                    href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">
                                    <i class="t4_icon_user"></i>'. esc_html__( 'My Account', 'kalles' ) .'
                                </a>';
                        } else {
                            echo '<a class="cb chp db the4-my-account" 
                                    href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">
                                    <i class="t4_icon_user"></i>'. esc_html__( 'Login / Register', 'kalles' ) .'
                                </a>';
                        }
                        
                    }
                }
                ?>
            </li>
            <?php if ( cs_get_option( 'header-top-left-mobile' ) && ! empty( cs_get_option( 'header-top-left-mobile' ) ) ) : ?>
                <li class="menu-item menu-item-infos">
                    <p class="menu_infos_title">
                        <?php echo esc_html__( 'Need help?', 'kalles' ); ?>
                    </p>
                    <div class="menu_infos_text">
                        <?php echo do_shortcode( cs_get_option( 'header-top-left-mobile' ) ); ?>
                    </div>
                </li>
            <?php endif; ?>
            <li class="menu-item menu-item-btns menu-item-has-children only_icon_false currencies">
                <?php
                if ( class_exists( 'WooCommerce' ) && cs_get_option( 'header-currency' ) ) {
                    echo the4_kalles_wc_currency_mobile();
                }
                ?>
            </li>
        </ul>
        <div class="hide-md visible-sm visible-xs center-xs mt__30 flex tc">
            <?php if ( cs_get_option( 'header-top-right' ) ) : ?>
                <div class="header-text mr__15"><?php echo do_shortcode( cs_get_option( 'header-top-right' ) ); ?></div>
            <?php endif; ?>
        </div>
    </div> <!-- #kalles-section-mb_nav_js -->
    <?php if ( $has_nav_categories_mobile ) : ?>
        <div id="kalles-section-mb_cat_js" class="mb_nav_tab">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'categories-mobile-menu',
                    'container_id'   => 'the4-mobile-menu__cat',
                    'walker'         => new THE4_Kalles_Mobile_Menu_Walker(),
                    'fallback_cb'    => NULL
                )
            );
            ?>
        </div> <!-- #kalles-section-mb_cat_js -->
    <?php endif; ?>
</div><!-- .the4-canvas-menu -->

