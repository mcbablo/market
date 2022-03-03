<?php
/**
 * The template part for displaying content.
 *
 * @since   1.0.0
 * @package Kalles
 */

$column = '';
if ( apply_filters( 'the4_kalles_blog_style', cs_get_option( 'blog-style' ) ) == 'standard' ) {
    $column = 'col-12 col-md-12';
}
?>
<?php do_action( 'the4_kalles_before_post' ); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb__40 col-12 entry' ); ?> <?php the4_kalles_schema_metadata( array( 'context' => 'entry' ) ); ?>>
        <header class="entry-header">
            <?php the4_kalles_post_thumbnail(); ?>
            <?php
            if ( is_sticky() && is_home() && ! is_paged() ) {
                printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured','kalles' ) );
            }
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( sprintf( '<h2 class="entry-title mb__5 fs__24 fwm mt__10"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            endif;
            ?>
            <div class="post-meta fs__14 flex mb__10">
                <span class="post-author mr__5"><?php echo esc_html__( 'By ', 'kalles' ); ?> <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a></span>
                <span class="post-time"><?php echo esc_html__( 'on ', 'kalles' );  ?><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></span>
            </div>
        </header><!-- .entry-header -->

        <div class="post-content entry-content">
            <?php
            $display_type = cs_get_option( 'blog-content-display' ) ? cs_get_option( 'blog-content-display' ) : 'content';

            if ( $display_type == 'content' ) {
                the_content(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Post title. Only visible to screen readers. */
                            translate( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'kalles' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    )
                );
            } else  {
                echo wp_trim_words( get_the_excerpt(), 40, '...' );
                ?>
                <div class="readmore-link-wrap"><a class="readmore-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Continue Reading', 'kalles' ); ?></a></div>
                <?php
            }
            ?>


        </div><!-- .post-content -->
    </article><!-- #post-# -->
<?php do_action( 'the4_kalles_after_post' ); ?>