<?php
/**
 * The template display latest post.
 *
 * @since   1.0.0
 * @package Kalles
 */
	$lastest_cat = cs_get_option( 'blog-latest-slider-cat' );

	$args = array( 
		'posts_per_page' => 10, 
		'ignore_sticky_posts' => true
     ); 

	if ( $lastest_cat ) {
		$args[ 'cat' ] = (int) $lastest_cat;
	}
	$query = new WP_Query( $args );

?>
<div class="the4-blog-slider the4-carousel" data-slick='{"slidesToShow": 3,"slidesToScroll": 1, "responsive":[{"breakpoint": 960,"settings":{"slidesToShow": 2}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]<?php echo esc_attr( ( is_rtl() ? ',"rtl":true' : '' ) ); ?>}'>
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="post-thumbnail pr">
			<a href="<?php esc_url( the_permalink() ); ?>">
				<?php
					if ( has_post_thumbnail() ) :
						$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

						$image = the4_resizer( $img[0], 640, 475, true );
						echo '<img src="' . esc_url( $image ) . '" width="640" height="475" alt="' . get_the_title() . '" />';
						
					else :
						echo '<img src="' . THE4_KALLES_URL . '/assets/images/placeholder.png" width="640" height="310" alt="' . get_the_title() . '" />';
					endif;
				?>
			</a>
			<div class="pa tc cg w__100">
				<?php the4_kalles_post_meta(); ?>
				<?php the4_kalles_post_title(); ?>
				<?php the4_kalles_posted_on(); ?>
			</div>
		</div>
	<?php
		endwhile;
		wp_reset_postdata();
	?>
</div><!-- .the4-blog-slider -->