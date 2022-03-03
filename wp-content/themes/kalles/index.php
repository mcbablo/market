<?php
/**
 * The main template file.
 *
 * @since   1.0.0
 * @package Kalles
 */

// Get blog layout
$layout = cs_get_option( 'blog-layout' ) ? apply_filters( 'the4_kalles_blog_layout', cs_get_option( 'blog-layout' ) ) : 'left-sidebar';

if ( is_active_sidebar( 'primary-sidebar' ) ) {
	if ($layout == 'left-sidebar') {
			$content_class = 'col-md-9 col-xs-12';
			$sidebar_class = 'col-md-3 col-xs-12 first-md';
	} elseif ($layout == 'right-sidebar') {
			$content_class = 'col-md-9 col-xs-12';
			$sidebar_class = 'col-md-3 col-xs-12 mt__60 mb__60';
	} else {
			$content_class = 'col-md-12 col-xs-12 mt__60 mb__60';
			$sidebar_class = '';
	}
} else {
	$content_class = 'col-md-12 col-xs-12 mt__60 mb__60';
	$sidebar_class = '';
}
// Blog style
$class = $data = $sizer = '';
$style = cs_get_option( 'blog-style' ) ? apply_filters( 'the4_kalles_blog_style', cs_get_option( 'blog-style' ) ) : 'standard';
if ( $style == 'masonry' ) {
	$class = ' the4-masonry';
	$data  = 'data-masonryjs=\'{"selector":".post", "columnWidth":".grid-sizer", "layoutMode":"masonry"' . ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) . '}\'';
	$sizer = '<div class="grid-sizer size-' . cs_get_option( 'blog-masonry-column' ) . '"></div>';
}

	get_header(); ?>

<div id="the4-content">
	<?php
		if ( cs_get_option( 'blog-latest-slider' ) ) {
			get_template_part( 'views/post/latest' );
		}
    $sidebar_layout = cs_get_option( 'blog-layout' );
    $blog_style = cs_get_option( 'blog-style' );
	?>

	<div class="container">
		<div class="row the4-blog <?php echo esc_attr( $sidebar_layout ); ?> blog-<?php echo esc_attr($blog_style); ?>">
			<div class="<?php echo esc_attr( $content_class ); ?>">
				<div class="posts row <?php echo esc_attr( $class ); ?>" <?php echo wp_kses_post( $data ); ?>>
					<?php
						if ( $style == 'masonry' ) {
							echo wp_kses_post( $sizer );
						}
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								if ( $style == 'masonry' ) {
									get_template_part( 'views/post/content', 'masonry' );
								} else if ( $style == 'grid' ) {
                                    get_template_part( 'views/post/content', 'grid' );
                                } else {
									get_template_part( 'views/post/content', get_post_format() );
								}
							endwhile;
						else :
							get_template_part( 'content', 'none' );
						endif;
					?>
				</div><!-- .posts -->
				<?php the4_kalles_pagination(); ?>
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

