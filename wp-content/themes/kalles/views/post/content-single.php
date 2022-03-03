<?php
/**
 * The template part for displaying single posts.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<?php do_action( 'the4_kalles_before_single_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php the4_kalles_schema_metadata( array( 'context' => 'entry' ) ); ?>>
	<div class="post-content">
		<?php
			the_content( sprintf(
				esc_html__( 'Continue Reading<span class="screen-reader-text"> "%s"</span>', 'kalles' ),
				get_the_title()
			) );
		?>
	</div>
</article><!-- #post-# -->
<?php do_action( 'the4_kalles_after_single_post' ); ?>