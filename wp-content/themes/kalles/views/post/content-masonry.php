<?php
/**
 * The template part for displaying content.
 *
 * @since   1.0.0
 * @package Kalles
 */
$column = '';
if ( apply_filters( 'the4_kalles_blog_style', cs_get_option( 'blog-style' ) ) == 'masonry' ) {
	$column = 'col-12 col-md-' . cs_get_option( 'blog-masonry-column' );
}
?>
<?php do_action( 'the4_kalles_before_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb__40 ' . $column ); ?> <?php the4_kalles_schema_metadata( array( 'context' => 'entry' ) ); ?>>
	<?php the4_kalles_post_thumbnail(); ?>

	<div class="post-content">
		<?php
			$display_type = cs_get_option( 'blog-content-display' );

			if ( $display_type == 'content' ) {
				the_content( sprintf(
					esc_html__( 'Continue Reading<span class="screen-reader-text"> "%s"</span>', 'kalles' ),
					get_the_title()
				) );
			} else if ( $display_type == 'excerpt' )  {
                echo wp_trim_words( get_the_excerpt(), 18, '...' );
            } else{

            }
		?>
        <a class="readmore-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Continue Reading', 'kalles' ); ?></a>

	</div><!-- .post-content -->
</article><!-- #post-# -->
<?php do_action( 'the4_kalles_after_post' ); ?>