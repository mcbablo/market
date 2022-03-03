<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */



// Typography config
CSF::createSection( $prefix, array(
  'id'     => 'portfolio',
  'title'  => esc_html__( 'Typography', 'kalles' ),
  'icon'   => 'fas fa-font',
     'fields' => array(
    array(
      'id'      => 'enable-google-font',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable Google font', 'kalles' ),
      'default' => true,
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Body Font Settings', 'kalles' ),
    ),
    array(
      'id'        => 'body-font',
      'type'      => 'typography',
      'title'     => esc_html__( 'Font Family', 'kalles' ),
      'default'   => array(
        'font-family'  => 'Poppins',
        'type'    => 'google',
        'font-weight' => 'regular',
      ),
    ),
    array(
      'id'      => 'head-top-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'Header Top Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '12'
    ),
    array(
      'id'      => 'menu-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'Menu Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '14'
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Heading Font Settings', 'kalles' ),
    ),
    array(
      'id'        => 'heading-font',
      'type'      => 'typography',
      'title'     => esc_html__( 'Font Family', 'kalles' ),
      'font_size'      => false,
      'default'   => array(
        'font-family'  => 'Poppins',
        'type'    => 'google',
        'font-weight' => '600',
      ),
    ),
    array(
      'id'      => 'h1-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'H1 Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '48'
    ),
    array(
      'id'      => 'h2-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'H2 Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '36'
    ),
    array(
      'id'      => 'h3-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'H3 Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '24'
    ),
    array(
      'id'      => 'h4-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'H4 Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '21'
    ),
    array(
      'id'      => 'h5-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'H5 Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '18'
    ),
    array(
      'id'      => 'h6-font-size',
      'type'    => 'number',
      'title'   => esc_html__( 'H6 Font Size', 'kalles' ),
      'unit'    => 'px',
      'default' => '16'
    ),
  ),
) );
