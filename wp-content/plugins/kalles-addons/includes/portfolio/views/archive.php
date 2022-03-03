<?php
/**
 * Portfolio archive pages.
 *
 * @package KallesAddons
 * @since   1.0.0
 */
get_header(); ?>
	<div id="the4-content">
		<div class="the4-portfolio">
			<?php get_template_part( 'views/common/page', 'head' ); ?>

			<div class="container mt__60 mb__60">
				<?php
					if ( cs_get_option( 'portfolio-number-per-page' ) ) {
						$limit = cs_get_option( 'portfolio-number-per-page' );
					} else {
						$limit = -1;
					}

					$columns = cs_get_option( 'portfolio-column' );

					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

					// Filter portfolio post type
					$args = array(
						'post_type'      => 'portfolio',
						'post_status'    => 'publish',
						'posts_per_page' => $limit,
						'paged'          => $paged
					);

					$cat = get_queried_object_id();
					$taxName = 'portfolio_cat';
					$taxName = is_tax('portfolio_client') ? 'portfolio_client' : $taxName;
					$taxName = is_tax('portfolio_tag') ? 'portfolio_tag' : $taxName;

					if ( ! empty( $cat ) ) {
						$args['tax_query'] = array(
							'relation' => 'AND',
							array(
								'taxonomy' => $taxName,
								'field'    => 'id',
								'terms'    => explode( ',', $cat )
							),
						);
					}
					$query = new WP_Query( $args );

					$i = 0;
				?>
				<?php if ( !is_tax($taxName) ) { ?>
					<?php
						// Retrieve all the categories
						$filters = get_terms( $taxName, array( 'include' => $cat ) );
					?>
					<div class="portfolio-filter the4-filter fwm tc mb__25">
						<a data-filter="*" class="selected dib cg chp br__40" href="javascript:void(0);"><?php _e( 'All', 'kalles-addons' ); ?></a>
						<?php foreach ( $filters as $cat ) : ?>
							<a data-filter=".<?php esc_attr_e( $cat->slug ); ?>" class="dib cg chp br__40" href="javascript:void(0);"><?php esc_html_e( $cat->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php } ?>

				<div class="row the4-masonry portfolios" data-masonryjs='{"selector":".portfolio-item","layoutMode":"masonry"<?php echo ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) ?>}'>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php
							$classes = array( 'col-md-' . $columns . ' portfolio-item pr mb__30' );

							// Get portfolio category
							$categories = wp_get_post_terms( get_the_ID(), 'portfolio_cat' );
							if ( $categories ) {
								foreach ( $categories as $category ) {
									$classes[] = "{$category->slug}";
								}
							}

							$delay = 0.00;
							$wait  = 0.15;

							$delay = $i % ( $columns * 2 ) * $wait;
						?>
						<div id="portfolio-<?php the_ID(); ?>"  class="col-sm-6 col-xs-12 <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
							<div class="fadeInUp animated">
								<a href="<?php the_permalink(); ?>" class="mask db pr chp">
									<?php
										if ( has_post_thumbnail() ) :
											the_post_thumbnail();
										endif;
									?>
								</a>
								<div class="pa tc ts__03 portfolio-title">
									<h4 class="fs__16 fwsb tu mg__0"><a class="cd chp" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
									<?php
										if ( count($categories) > 0 ) {
											echo '<span>' . get_the_term_list( $post->ID, 'portfolio_cat', '', ', ' ) . '</span>';
										}
									?>
								</div>
							</div>
						</div>
						<?php $i++; ?>
					<?php endwhile; ?>
				</div><!-- .row -->
				<?php
					echo '<div class="the4-ajax-load tc" data-load-more=\'{"page":"' . esc_attr( $query->max_num_pages ) . '","container":"portfolios","layout":"loadmore"}\'>';
						next_posts_link( __( 'Load More', 'kalles-addons' ), $query->max_num_pages );
					echo '</div>';

					wp_reset_postdata();
				?>
			</div><!-- .container -->
		</div><!-- .the4-portfolio -->
	</div><!-- #the4-content -->
<?php get_footer(); ?>