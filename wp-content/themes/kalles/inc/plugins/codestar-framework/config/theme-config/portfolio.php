<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */
// Portfolio config
CSF::createSection( $prefix, array(
  'id'     => 'portfolio',
  'title'  => esc_html__( 'Portfolio', 'kalles' ),
  'icon'   => 'fas fa-flask',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Portfolio Listing', 'kalles' ),
    ),
    array(
      'id'      => 'portfolio-page-title',
      'type'    => 'text',
      'title'   => esc_html__( 'Page Title', 'kalles' ),
      'default' => esc_html__( 'Portfolio', 'kalles' ),
    ),
    array(
      'id'      => 'portfolio-sub-title',
      'type'    => 'text',
      'title'   => esc_html__( 'Sub Title', 'kalles' ),
      'default' => esc_html__( 'See our recent projects', 'kalles' ),
    ),
    array(
      'id'    => 'portfolio-pagehead-bg',
      'type'  => 'background',
      'title' => esc_html__( 'Page Title Background', 'kalles' ),
    ),
    array(
      'id'    => 'portfolio-column',
      'type'  =>'image_select',
      'title' => esc_html__( 'Columns', 'kalles' ),
      'desc'  => esc_html__( 'Display number of post per row', 'kalles' ),
      'radio' => true,
      'options' => array(
        '6' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/2cols.png',
        '4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/3cols.png',
        '3' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/4cols.png',
      ),
      'default' => 4,
    ),
    array(
      'id'      => 'portfolio-number-per-page',
      'type'    => 'number',
      'title'   => esc_html__( 'Per Page', 'kalles' ),
      'desc'    => esc_html__( 'How much items per page to show (-1 to show all portfolio)', 'kalles' ),
      'default' => 10,
    ),
  ),
) );
