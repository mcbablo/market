<?php
/**
 * The Sidebar Hide Menu
 *
 * @since   1.0.0
 * @package Kalles
 */
?>

<div class="the4-canvas-menu-sidebar nt_sleft the4-push-menu">
    <div id="kalles-section-menu-sidebar_js">
        <div class="fixcl-scroll">
            <div class="fixcl-scroll-content css_ntbar">
                <div class="sidebar-main-menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary-menu-sidebar',
                            'container_id'   => 'primary-menu-sidebar',
                            'menu_class'     => 'primary-menu-sidebar animation-fade-0',
                            'walker'         => new THE4_Kalles_Mobile_Menu_Walker(),
                            'fallback_cb'    => NULL
                        )
                    );
                    ?>
                </div>
                <ul class="the4-mobilenav-bottom">
                    <li class="menu-item menu-item-btns menu-item-sea animation-fade-1">
                        <div class="the4_mini_cart flex column h__100">
                            <div class="mini_cart_wrap cl_h_search atc_opended_rs">
                                <?php the4_get_search_form_full(); ?>
                            </div> <!-- .mini_cart_wrap -->

                        </div> <!-- .the4_mini_cart -->
                    </li>
                    <li class="menu-item menu-item-btns menu-item-has-children only_icon_false currencies animation-fade-2">
                        <?php
                        if ( class_exists( 'WooCommerce' ) && cs_get_option( 'header-currency' ) ) {
                            echo the4_kalles_wc_currency_mobile();
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div> <!-- #kalles-section-mb_nav_js -->
</div><!-- .the4-canvas-menu -->

