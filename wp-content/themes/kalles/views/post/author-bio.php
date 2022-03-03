<?php
/**
 * The template part for displaying author-bio.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>

<div class="t4-author-bio pr mt__30 bio-style-<?php echo esc_attr( cs_get_option( 'blog-author-bio_style' ) ); ?>">
	<div class="t4-author-bio__avatar">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 90, '', 'author-avatar' ); ?>
	</div>
	<div class="t4-author-bio__content tc">
		<h3 class="t4-author-bio__name">
			<?php echo get_the_author(); ?>
		</h3>
		<div class="t4-author-bio__description">
			<?php the_author_meta( 'description' ); ?>
		</div>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="t4-author-bio__link-all">
			<?php printf( wp_kses( esc_html__( 'View all posts by %s', 'kalles' ), array( 'span' => array('class') ) ), get_the_author() ); ?>
		</a>
	</div>
</div>