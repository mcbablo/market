<?php
/**
 * The template for display megamenu
 *
 * @since   1.0.0
 * @package Kalles
 */
if (!current_user_can('administrator')) {
	wp_die(
		'You do not have access !',
		'',
		array(
			'back_link' => true
		)
	);
}
?>
<?php get_template_part( 'views/header/megamenu/header-megamenu' ); ?>
	<div id="the4-content">
		<div class="container">
			<div class="row the4-blog">
				<div class="col-md-12 col-xs-12">
					<?php while (have_posts()) : ?>
						<?php the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
<?php get_template_part( 'views/footer/megamenu/footer-megamenu' ); ?>


