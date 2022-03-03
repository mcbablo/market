<?php
/**
 * The template for displaying all single posts.
 *
 * @since   1.0.0
 * @package Kalles
 */

// Get blog layout
$layout = cs_get_option( 'blog-detail-layout' ) ? apply_filters( 'the4_kalles_blog_detail_layout', cs_get_option( 'blog-detail-layout' ) ) : 'right-sidebar';

if ( is_active_sidebar('primary-sidebar') ) {
    if ($layout == 'left-sidebar') {
        $content_class = 'col-md-9 col-xs-12 mt__60 mb__60';
        $sidebar_class = 'col-md-3 col-xs-12 first-md mt__60 mb__60';
    } elseif ($layout == 'right-sidebar') {
        $content_class = 'col-md-9 col-xs-12 mt__60 mb__60';
        $sidebar_class = 'col-md-3 col-xs-12 mt__60 mb__60';
    } else {
        $content_class = 'col-md-12 col-xs-12 mt__60 mb__60';
        $sidebar_class = '';
    }
} else {
	$content_class = 'col-md-12 col-xs-12 mt__60 mb__60';
	$sidebar_class = '';
}

// View custom post megamenu
if ('megamenu' == get_post_type()) {
	get_template_part( 'views/post/content', 'megamenu' );
} else {
	get_header(); ?>

<div id="the4-content">
	<?php get_template_part( 'views/common/page', 'head' ); ?>
	<div class="container">
		<div class="row the4-single-blog">
			<div class="<?php echo esc_attr( $content_class ); ?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'views/post/content', 'single' ); ?>

					<?php if ( cs_get_option( 'blog-author-bio' ) ) : ?>
					<?php t4_author_bio_tag(); ?>
					<?php endif; ?>

					<div class="flex between-xs tag-comment mt__40">
						<?php
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kalles' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kalles' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
						?>

						<?php echo the4_kalles_get_tags(); ?>

						<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
							<div class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'kalles' ), esc_html__( '1 Comment', 'kalles' ), esc_html__( '% Comments', 'kalles' ) ); ?></div>
						<?php endif; ?>
					</div>

					<?php
						if ( cs_get_option( 'wc-social-share' ) && class_exists( 'Kalles_Addons' ) ) {
							the4_kalles_social_share();
						}
					?>

                    <?php
                    if ( cs_get_option( 'blog-detail-navigation' ) ) { ?>
                        <div class="blog-navigation mt__20 fs__40 tc">
                            <?php
                            $next     = get_adjacent_post();
                            $previous = get_adjacent_post( false, '', false );

                            if ( $next ) {
                                echo '<a href="' . esc_url( get_permalink( $next->ID ) ) . '" class="pl__30 pr__30 cd chp tooltip_top ttip_nt"><i class="pe-7s-angle-left"></i><span class="tt_txt"> ' . $next->post_title . ' </span></a>';
                            }

                            echo '<a href="' . esc_url( get_post_type_archive_link( 'post' ) ) . '" class="pl__30 pr__30 cd chp"><i class="pe-7s-keypad"></i></a>';

                            if ( $previous ) {
                                echo '<a href="' . esc_url( get_permalink( $previous->ID ) ) . '" class="pl__30 pr__30 cd chp tooltip_top ttip_nt"><i class="pe-7s-angle-right"></i><span class="tt_txt"> ' . $previous->post_title . ' </span></a>';
                            }
                            ?>
                        </div><!-- .portfolio-navigation -->
                    <?php } ?>
					<?php the4_kalles_related_post(); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					?>
				<?php endwhile; ?>
			</div><!-- .col-md-9 -->
			<?php if ( 'no-sidebar' != $layout ) { ?>
			<div class="<?php echo esc_attr( $sidebar_class ); ?>">
				<?php get_sidebar(); ?>
			</div><!-- .col-md-3 -->
			<?php } ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #the4-content -->

<?php get_footer();
	}
 ?>