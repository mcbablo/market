<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */

// Blog config
CSF::createSection( $prefix, array(
  'id'     => 'blog',
  'title'  => esc_html__( 'Blog', 'kalles' ),
  'icon'   => 'fas fa-blog',
  'fields' => array(
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Blog listing layout', 'kalles' ),
    ),
    array(
      'id'      => 'blog-latest-slider',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable latest post slider', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'blog-latest-slider-cat',
      'type'    => 'select',
      'title'   => esc_html__( 'Lastest post slider categoy', 'kalles' ),
      'options' => 'categories',
      'query_args'  => array(
        'post_type' => 'post',
      ),
      'dependency' => array( 'blog-latest-slider', '==', 'true' ),
    ),
    array(
      'id'      => 'blog-content-display',
      'type'    => 'select',
      'title'   => esc_html__( 'Content display on blog list', 'kalles' ),
      'options' => array(
        'content' => esc_html__( 'Content', 'kalles' ),
        'excerpt' => esc_html__( 'Excerpt', 'kalles' ),
        'no_content' => esc_html__( 'No Content', 'kalles' ),
      ),
    ),
    array(
      'id'    => 'blog-style',
      'type'  => 'image_select',
      'title' => esc_html__( 'Style', 'kalles' ),
      'radio' => true,
      'label' => true,
      'options' => array(
        'grid'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
        'masonry' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/masonry.png',
		    'standard' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
      ),
      'default' => 'standard'
    ),
    array(
      'id'    => 'blog-masonry-column',
      'type'  =>'image_select',
      'title' => esc_html__( 'Columns', 'kalles' ),
      'desc'  => esc_html__( 'Display number of post per row', 'kalles' ),
      'radio' => true,
      'options' => array(
        '6' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/2cols.png',
        '4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/3cols.png',
      ),
      'default'    => '6',
      'dependency' => array( 'blog-style', '==', 'masonry' ),
    ),
    array(
      'id'    => 'blog-layout',
      'type'  => 'image_select',
      'title' => esc_html__( 'Layout', 'kalles' ),
      'radio' => true,
      'label' => true,
      'options' => array(
        'left-sidebar'  => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/left-sidebar.png',
        'no-sidebar'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
        'right-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
      ),
      'default'    => 'right-sidebar',
    ),
    array(
      'id'         => 'blog-sidebar',
      'type'       => 'select',
      'title'      => esc_html__( 'Select Sidebar', 'kalles' ),
      'options'    => 'sidebars',
      'dependency' => array( 'blog-layout', '!=', 'no-sidebar' ),
    ),

    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Blog detail layout', 'kalles' ),
    ),
    array(
      'id'    => 'blog-detail-layout',
      'type'  => 'image_select',
      'title' => esc_html__( 'Layout', 'kalles' ),
      'radio' => true,
      'label' => true,
      'options' => array(
        'left-sidebar'  => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/left-sidebar.png',
        'no-sidebar'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
        'right-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
      ),
      'default'    => 'right-sidebar',
    ),
    array(
      'id'         => 'blog-detail-sidebar',
      'type'       => 'select',
      'title'      => esc_html__( 'Select Sidebar', 'kalles' ),
      'options'    => 'sidebars',
      'dependency' => array( 'blog-detail-layout', '!=', 'no-sidebar' ),
    ),
    array(
      'id'      => 'blog-detail-navigation',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable post navigation', 'kalles' ),
      'default' => false,
    ),
	array(
		'id'      => 'blog-detail-related',
		'type'    => 'switcher',
		'title'   => esc_html__( 'Enable Related Articles', 'kalles' ),
		'default' => false,
	),
    array(
      'id'      => 'blog-author-bio',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable author bio', 'kalles' ),
      'default' => true,
    ),
    array(
      'id'    => 'blog-author-bio_style',
      'type'  =>'select',
      'title' => esc_html__( 'Author bio style', 'kalles' ),
      'options' => array(
        '1' => 'Style 1',
        '2' => 'Style 2',
      ),
      'default'    => '1',
      'dependency' => array( 'blog-author-bio', '==', true),
    ),
  ),
) );
