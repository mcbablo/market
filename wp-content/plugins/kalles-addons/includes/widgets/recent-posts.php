<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Widget API: Kalles_Widget_Recent_Posts  class
 *
 * @package    WordPress
 * @subpackage Widgets
 * @since      4.4.0
 */

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see   WP_Widget
 */
class Kalles_Widget_Recent_Posts extends WP_Widget {

    /**
     * Sets up a new Recent Posts widget instance.
     *
     * @since 2.8.0
     */
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'kalles_widget_recent_entries widget_recent_entries',
            'description'                 => esc_html__( 'Your site&#8217;s most recent Posts.', 'kalles' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'kalles-recent-posts', esc_html__( 'Kalles Recent Posts', 'kalles' ), $widget_ops );
        $this->alt_option_name = 'kalles_widget_recent_entries';
    }

    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    public function widget( $args, $instance ) {
        if ( !isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = ( !empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts', 'kalles' );

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $categories   = $instance['categories'];

        $number = ( !empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( !$number ) {
            $number = 5;
        }
        $show_date           = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $query        = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'cat' => $categories);
        /**
         * Filters the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         * @see   WP_Query::get_posts()
         *
         * @param array $args     An array of arguments used to retrieve the recent posts.
         * @param array $instance Array of settings for the current widget.
         */
        $r = new WP_Query($query);

        if ( !$r->have_posts() ) {
            return;
        }
        ?>
        <?php The4Helper::ksesHTML( $args['before_widget'] ); ?>
        <?php
        if ( $title ) {
            The4Helper::ksesHTML( $args['before_title'] . $title . $args['after_title'] );
        }
        ?>
        <div class="post_list_widget">
            <?php foreach ( $r->posts as $recent_post ) { ?>
                <?php
                $post_title   = get_the_title( $recent_post->ID );
                $title        = ( !empty( $post_title ) ) ? $post_title : esc_html( '(no title)' );
                $aria_current = '';

                if ( get_queried_object_id() === $recent_post->ID ) {
                    $aria_current = ' aria-current="page"';
                }

                ?>
                <div class="row mb__10 pb__10">

                    <?php if ( has_post_thumbnail( $recent_post->ID ) ) { ?>
                        <div class="col-auto widget_img_ar">
                            <?php echo get_the_post_thumbnail( $recent_post->ID, 'thumbnail' ); ?>
                        </div><!-- .post-thumbnail -->
                    <?php }; ?>
                    <div class="col widget_if_ar">
                        <a href="<?php the_permalink( $recent_post->ID ); ?>" class="article-title db" <?php echo esc_attr( $aria_current ); ?>>
                            <?php echo esc_html( $title ); ?>
                        </a>
                        <?php if ( $show_date ) { ?>
                            <span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span>
                        <?php }; ?>
                    </div>
                </div>
            <?php }; ?>
        </div>
        <?php
        The4Helper::ksesHTML( $args['after_widget'] );
    }

    /**
     * Handles updating the settings for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     *
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance                        = $old_instance;
        $instance['title']               = sanitize_text_field( $new_instance['title'] );
        $instance['categories']          = $new_instance['categories'];
        $instance['number']              = (int) $new_instance['number'];
        $instance['show_date']           = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;

        return $instance;
    }

    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title               = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $categories          = isset( $instance['categories'] ) ? esc_attr( $instance['categories'] ) : ''; 
        $number              = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date           = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title', 'kalles' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>">Filter by Category:</label>
            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" multiple="multiple" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
                <option value='all' <?php if ('all' == $categories) echo 'selected="selected"'; ?>><?php esc_html_e('All categories','kalles');?></option>
                <?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
                <?php foreach($categories as $category) { ?>
                    <option value='<?php echo esc_html($category->term_id); ?>' <?php if ($category->term_id == $categories) echo 'selected="selected"'; ?>><?php echo esc_html($category->cat_name); ?></option>
                <?php } ?>
            </select>
        </p>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php echo esc_html__( 'Number of posts to show:','kalles' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
        <p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php echo esc_html__( 'Display post date?','kalles' ); ?></label></p>

        <?php
    }
}

