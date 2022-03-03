<?php
/**
 * The template for displaying search results pages.
 *
 * @since   1.0.0
 * @package Kalles
 */
get_header();
$sidebar = cs_get_option( 'page-sidebar' );
if (  is_active_sidebar( $sidebar ) || is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class = 'col-md-9';
	$sidebar_class = 'col-md-3 col-xs-12';
} else {
	$content_class = 'col-md-12';
	$sidebar_class = '';
}
?>
<div id="the4-content">
	<?php get_template_part( 'views/common/page', 'head' ); ?>

	<div class="container">
		<div class="row the4-page">
			<div class="<?php echo esc_attr( $content_class ); ?> col-xs-12 mt__60 mb__60" role="main">
                <div class="row">
                    <?php
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post();
                                get_template_part( 'views/post/content' );
                            endwhile;

                            the4_kalles_pagination();

                            // If no content, include the "No posts found" template.
                        else :
                            get_template_part( 'views/post/content', 'none' );
                        endif;
                    ?>
                </div>
			</div><!-- $classes -->
			<div class="<?php echo esc_attr( $sidebar_class ); ?>" role="main">
				<?php
					echo '<div class="sidebar mt__60 mb__60" role="complementary" ' . the4_kalles_schema_metadata( array( 'context' => 'sidebar', 'echo' => false ) ) . '>';

						if ( is_active_sidebar( $sidebar ) ) {
							dynamic_sidebar( $sidebar );
						} elseif ( is_active_sidebar( 'primary-sidebar' ) ) {
							dynamic_sidebar( 'primary-sidebar' );
						}
					echo '</div>';
				?>
			</div>

		</div><!-- .row -->
	</div>
</div><!-- #the4-content -->
<?php get_footer();