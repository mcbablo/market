<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Megamenu Options.
 *
 * @since   1.0.0
 * @package Kalles
 */

//
// Set a unique slug-like ID
//
$prefix = '_kalles_megamenu_options';

//
// Create menu options
//
CSF::createNavMenuOptions( $prefix, array(
  'data_type' => 'serialize'
) );

//
// Create a section
//
CSF::createSection( $prefix, array(
  'fields' => array(

    //
    // A text field
    //
    array(
      'id'    => 'label-title',
      'type'  => 'text',
      'title' => __('Label Title', 'kalles'),
    ),
    array(
      'id'      => 'label-color',
      'type'    => 'color',
      'title'   => __('Label Color', 'kalles'),
      'default' => '#FFF',
    ),
    array(
      'id'    => 'menu-icon',
      'type'  => 'icon',
      'title' => __('Menu Icon', 'kalles'),
    ),

    array(
      'id'    => 'megamenu',
      'type'  => 'switcher',
      'title' => __('Enable Megamenu', 'kalles'),
    ),

    array(
      'id'          => 'megamenu-type',
      'type'        => 'select',
      'title'       => __('Megamenu Type', 'kalles'),
      'options'     => array(
        'full-width'     => __('Full Width', 'kalles'),
        'custom_size'     => __('Custom size', 'kalles')
      ),
      'dependency' => array( 'megamenu', '==', true ),
    ),
    array(
      'id'          => 'megamenu-pos',
      'type'        => 'select',
      'title'       => __('Megamenu position', 'kalles'),
      'options'     => array(
        'default'     => __('Default', 'kalles'),
        'center'     => __('Center', 'kalles')
      ),
      'dependency' => array( 'megamenu-type', '==', 'custom_size' ),
    ),
    array(
      'id'      => 'megamenu-width',
      'type'    => 'number',
      'unit'    => 'px',
      'title'   => __( 'Dropdown Width', 'kalles' ),
      'default' => 800, 
      'dependency' => array( 'megamenu-type', '==', 'custom_size' ),
    ),
    array(
      'id'      => 'megamenu-height',
      'type'    => 'number',
      'unit'    => 'px',
      'title'   => __( 'Dropdown Height', 'kalles' ),
      'default' => 350, 
      'dependency' => array( 'megamenu-type', '==', 'custom_size' ),
    ),

    array(
      'id'          => 'block-megamenu',
      'type'        => 'select',
      'title'       => __('HTML Block for the dropdown', 'kalles'),
      'placeholder' => __('Selec HTML block', 'kalles'),
      'options'     => 'posts',
      'query_args'  => array(
        'post_type'      => 'megamenu',
        'posts_per_page' =>-1, 
      ),
      'dependency' => array( 'megamenu', '==', true ),
    ),
  )
) );