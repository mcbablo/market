<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @since   1.0.0
 * @package Kalles
 */
get_header(); ?>

<div id="the4-content">
	<div class="container">
		<section class="error-404 not-found">
			<div id="content-wrapper">
				<h1><?php echo esc_html__( '404', 'kalles' ); ?></h1>
				<h3 class="page-title"><?php esc_html_e( 'Sorry! Page you are looking can&rsquo;t be found.', 'kalles' ); ?></h3>
				<p><?php esc_html_e('Go back to the ','kalles'); ?><a href="<?php echo esc_url( home_url( '/' ) ) ;?>" rel="home"><?php esc_html_e('homepage' ,'kalles' ); ?></a></p>
			</div>
		</section><!-- .error-404 -->
	</div><!-- #container -->
</div><!-- #the4-content -->

<?php get_footer(); ?>