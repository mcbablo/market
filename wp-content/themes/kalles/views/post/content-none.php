<?php
/**
 * The template part for displaying content none.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<?php do_action( 'the4_kalles_before_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb__80' ); ?> <?php the4_kalles_schema_metadata( array( 'context' => 'entry' ) ); ?>>
	<div class="post-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( ___( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kalles' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<div class="tc">
				<h4 class="mb__30"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kalles' ); ?></h4>
				<?php get_search_form(); ?>
			</div>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kalles' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .post-content -->
</article><!-- #post-# -->
<?php do_action( 'the4_kalles_after_post' ); ?>