<?php
/**
 * Portfolio single.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

get_header(); ?>
	<div id="the4-content">
		<?php get_template_part( 'views/common/page', 'head' ); ?>

		<div class="container mt__60 mb__60">
			<div class="the4-portfolio-single">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
					<div class="container tc">
						<div class="portfolio-meta row mb__60">
							<?php echo '<div class="col-md-4 col-sm-4 col-xs-12"><span class="mb__5 tu ls__2 db f__mont">' . esc_html__( 'Categories: ', 'kalles-addons' ) . '</span>' . get_the_term_list( $post->ID, 'portfolio_cat', '', ', ' ) . '</div>'; ?>
							<?php echo '<div class="col-md-4 col-sm-4 col-xs-12"><span class="mb__5 tu ls__2 db f__mont">' . esc_html__( 'Clients: ', 'kalles-addons' ) . '</span>' . get_the_term_list( $post->ID, 'portfolio_client', '', ', ' ) . '</div>'; ?>
							<?php echo '<div class="col-md-4 col-sm-4 col-xs-12"><span class="mb__5 tu ls__2 db f__mont">' . esc_html__( 'Tags: ', 'kalles-addons' ) . '</span>' . get_the_term_list( $post->ID, 'portfolio_tag', '', ', ' ) . '</div>'; ?>
						</div>
						<?php the4_kalles_social_share(); ?>
						<div class="portfolio-navigation mt__60 fs__40">
							<?php
								$next     = get_adjacent_post();
								$previous = get_adjacent_post( false, '', false );

								if ( $next ) {
									echo '<a href="' . esc_url( get_permalink( $next->ID ) ) . '" class="pl__30 pr__30 cd chp tooltip_top ttip_nt"><i class="pe-7s-angle-left"></i><span class="tt_txt"> ' . $next->post_title . ' </span></a>';
								}

								echo '<a href="' . esc_url( get_post_type_archive_link( 'portfolio' ) ) . '" class="pl__30 pr__30 cd chp"><i class="pe-7s-keypad"></i></a>';

								if ( $previous ) {
									echo '<a href="' . esc_url( get_permalink( $previous->ID ) ) . '" class="pl__30 pr__30 cd chp tooltip_top ttip_nt"><i class="pe-7s-angle-right"></i><span class="tt_txt"> ' . $previous->post_title . ' </span></a>';
								}
							?>
						</div><!-- .portfolio-navigation -->

					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div><!-- .row -->
		</div><!-- .container -->

		<?php Kalles_Addons_Portfolio::related(); ?>
	</div><!-- #the4-content -->
<?php get_footer(); ?>