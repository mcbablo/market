<?php
/**
 * The template part for displaying content.
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<?php do_action( 'the4_kalles_before_post' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb__40 col-lg-6 col-md-6 col-12' ); ?> <?php the4_kalles_schema_metadata( array( 'context' => 'entry' ) ); ?>>
	<?php the4_kalles_post_thumbnail(); ?>

	<div class="post-content">
		<?php
            $display_style = cs_get_option( 'blog-style' );

            if ( $display_style == 'grid' ) { ?>
                <div class="post-info mb__10">               
                    <?php the4_kalles_post_title(); ?>
					 <?php the4_kalles_post_meta_layout_grid(); ?>
                </div>
            <?php }
			$display_type = cs_get_option( 'blog-content-display' );

			if ( $display_type == 'content' ) {
				the_content( sprintf(
					esc_html__( 'Continue Reading<span class="screen-reader-text"> "%s"</span>', 'kalles' ),
					get_the_title()
				) );
			} else if ( $display_type == 'excerpt' )  {
                echo wp_trim_words( get_the_excerpt(), 50, '...' );
				echo '<a class="readmore-link" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Continue Reading', 'kalles' ) . '</a>';
			} else{

            }
		?>
	</div><!-- .post-content -->
</article><!-- #post-# -->
<?php do_action( 'the4_kalles_after_post' ); ?>