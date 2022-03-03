<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// TAXONOMY OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================

$prefix = '_custom_product_cat_options';

CSF::createTaxonomyOptions( $prefix, array(
  'taxonomy' => 'product_cat',
) );

CSF::createSection( $prefix, array(
	'fields'   => array(
		array(
		  'id'    => 'cat-full-description',
		  'type'  => 'wp_editor',
		  'title' => 'Full Description',
		),
		array(
			'id'      => 'product-cat-layout',
			'type'    => 'image_select',
			'title'   => esc_html__( 'Product Category Layout', 'kalles' ),
			'options' => array(
				'left-sidebar'  => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/left-sidebar.png',
				'no-sidebar'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
				'right-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
			),
		),
		array(
      'id'    => 'wc-style',
      'type'  => 'image_select',
      'title' => esc_html__( 'Layout style', 'kalles' ),
      'desc'  => esc_html__( 'Display product listing as grid or masonry or metro', 'kalles' ),
      'radio' => true,
      'options' => array(
        'grid'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/grid.png',
        'masonry' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/masonry.png',
        'metro'   => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/metro.png'
      ),
      'default' => 'grid',
    ),
		array(
			'id'         => 'product-cat-sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Select Sidebar', 'kalles' ),
			'options'    => 'sidebars',
			'dependency' => array( 'product-cat-layout', '!=', 'no-sidebar' ),
		),
	),
 
) );
