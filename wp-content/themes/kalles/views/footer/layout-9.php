<?php
/**
 * The footer layout 9.
 *
 * @since   1.4.6
 * @package Kalles
 */
?>
<footer id="the4-footer" class="bgbl footer-9 <?php if (cs_get_option('enable_footer-sticky') ) { ?> footer-sticky <?php }?>" <?php the4_kalles_schema_metadata( array( 'context' => 'footer' ) ); ?>>
    <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) ) : ?>
        <?php
        $count = 0;
        for ($i=1; $i < 6 ; $i++) {
            if ( is_active_sidebar( 'footer-'.$i ) ) {
                $count = $count + 1;
            }
        }
        ?>
        <div class="footer__top pb__70 pt__80 <?php if ( is_active_sidebar( 'footer-mobile' ) && cs_get_option('enable_footer-mobile') ) { ?> db_md <?php }?>">
            <div class="container pr">
                <div class="row row-grid footer-col-<?php echo esc_attr($count); ?>">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
                        <div class="col-12">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php }
                    if ( is_active_sidebar( 'footer-2' ) ) { ?>
                        <div class="col-12">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php }
                    if ( is_active_sidebar( 'footer-3' ) ) { ?>
                        <div class="col-12">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php }
                    if ( is_active_sidebar( 'footer-4' ) ) { ?>
                        <div class="col-12">
                            <?php dynamic_sidebar( 'footer-4' ); ?>
                        </div>
                    <?php }
                    if ( is_active_sidebar( 'footer-5' ) ) { ?>
                        <div class="col-12">
                            <?php dynamic_sidebar( 'footer-5' ); ?>
                        </div>
                    <?php } ?>
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .footer__top -->
        <?php if ( is_active_sidebar( 'footer-mobile' ) && cs_get_option('enable_footer-mobile') ) : ?>
            <div class="footer__top footer-mobile pb__20 pt__60 dn_lg">
                <div class="container pr">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            if ( is_active_sidebar( 'footer-mobile' ) ) {
                                dynamic_sidebar( 'footer-mobile' );
                            }
                            ?>
                        </div>
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .footer__top -->
        <?php endif; ?>
    <?php endif; ?>
    <?php if (cs_get_option('footer_copyright-enable')) : ?>
        <?php get_template_part('views/footer/footer-bottom'); ?>
    <?php endif; ?>
</footer><!-- #the4-footer -->