<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */


// Color scheme config
CSF::createSection( $prefix, array(
  'id'     => 'color_scheme',
  'title'  => esc_html__( 'Color Scheme', 'kalles' ),
  'icon'   => 'fas fa-brush',
  'fields' => array(
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'General Color', 'kalles' ),
    ),
    array(
      'id'      => 'primary-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Primary Color', 'kalles' ),
      'desc'    => esc_html__( 'Main Color Scheme', 'kalles' ),
      'default' => '#56cfe1',
    ),
    array(
      'id'      => 'secondary-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Secondary Color', 'kalles' ),
      'desc'    => esc_html__( 'Secondary Color Scheme', 'kalles' ),
      'default' => '#222',
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Section Color', 'kalles' ),
    ),
    array(
      'id'      => 'body-background-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Body Background Color', 'kalles' ),
      'default' => '#fff',
    ),
    array(
      'id'      => 'body-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Body Color', 'kalles' ),
      'default' => '#878787',
    ),
    array(
      'id'      => 'heading-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Heading Color', 'kalles' ),
      'default' => '#222',
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Header Color', 'kalles' ),
    ),
    array(
      'id'    => 'header-background',
      'type'  => 'color',
      'title' => esc_html__( 'Header Background Color', 'kalles' ),
    ),
    array(
      'id'    => 'header-top-background',
      'type'  => 'color',
      'title' => esc_html__( 'Header Top Background Color', 'kalles' ),
    ),
    array(
      'id'    => 'header-top-color',
      'type'  => 'color',
      'title' => esc_html__( 'Header Top Color', 'kalles' ),
      'default' => '#878787',
    ),
    array(
      'id'    => 'header-mid-background',
      'type'  => 'color',
      'title' => esc_html__( 'Header Main Background Color', 'kalles' ),
    ),
    array(
      'id'      => 'main-menu-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Main Menu Color', 'kalles' ),
      'default' => '#222'
    ),
	  array(
		  'id'      => 'main-menu-action-count-color',
		  'type'    => 'color',
		  'title'   => esc_html__( 'Main Menu Action Count Color', 'kalles' ),
		  'default' => '#fff'
	  ),
    array(
      'id'      => 'main-menu-hover-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Main Menu Hover Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'id'      => 'main-menu-active-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Main Menu Active Color', 'kalles' ),
      'default' => '#56cfe1'
     ),
    array(
      'id'      => 'sub-menu-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Sub Menu Color', 'kalles' ),
      'default' => '#878787'
    ),
    array(
      'id'      => 'sub-menu-hover-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Sub Menu Hover Color', 'kalles' ),
      'default' => '#222'
    ),
    array(
      'id'      => 'sub-menu-background-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Sub Menu Background Color', 'kalles' ),
      'default' => 'rgba(255, 255, 255, 0.95)'
    ),
    array(
      'id'      => 'button-search-background-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Button Search Background Color', 'kalles' ),
      'default' => 'rgba(255, 255, 255, 0.95)'
    ),
    array(
      'id'      => 'header-cat-background-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Category Background Color', 'kalles' ),
      'default' => 'rgba(255, 255, 255, 0.95)'
    ),
    array(
      'id'      => 'header-bottom-background-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Bottom Background Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Header Transparent Color', 'kalles' ),
    ),
    array(
      'id'      => 'transparent-main-menu-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Main Menu Color', 'kalles' ),
      'default' => '#222'
    ),
    array(
      'id'      => 'transparent-main-menu-hover-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Main Menu Hover Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Header Sticky Color', 'kalles' ),
    ),
    array(
      'id'      => 'header-sticky-background',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Background', 'kalles' ),
      'default' => '#fff'
    ),
    array(
      'id'      => 'sticky-main-menu-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Main Menu Color', 'kalles' ),
      'default' => '#222'
    ),
	array(
      'id'      => 'sticky-main-menu-action-count-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Main Menu Action Count Color', 'kalles' ),
      'default' => '#fff'
    ),
	  
    array(
      'id'      => 'sticky-main-menu-hover-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Main Menu Hover Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'id'      => 'sticky-sub-menu-background-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Sub Menu Background Color', 'kalles' ),
      'default' => 'rgba(255, 255, 255, 0.95)'
    ),
    array(
      'id'      => 'sticky-sub-menu-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Sub Menu Color', 'kalles' ),
      'default' => '#222'
    ),
    array(
      'id'      => 'sticky-sub-menu-color-hover',
      'type'    => 'color',
      'title'   => esc_html__( 'Header Sticky Sub Menu Hover Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Footer Color', 'kalles' ),
    ),
    array(
      'id'      => 'footer-background',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Background Color', 'kalles' ),
      'default' => '#f6f6f8'
    ),
    array(
      'id'      => 'footer-bottom-background',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Bottom Background Color', 'kalles' ),
      'default' => '#fff'
    ),
    array(
      'id'      => 'footer-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Primary Color', 'kalles' ),
      'default' => '#878787'
    ),
    array(
      'id'      => 'footer-widget-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Widget Title Color', 'kalles' ),
      'default' => '#222'
    ),
    array(
      'id'      => 'footer-link-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Link Color', 'kalles' ),
      'default' => '#878787'
    ),
    array(
      'id'      => 'footer-link-hover-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Link Hover Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'id'      => 'footer-bottom-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Bottom Color', 'kalles' ),
      'default' => '#878787'
    ),
    array(
      'id'      => 'footer-bottom-link-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Bottom Link Color', 'kalles' ),
      'default' => '#878787'
    ),
    array(
      'id'      => 'footer-bottom-link-hover-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Bottom Link Hover Color', 'kalles' ),
      'default' => '#bb9230'
    ),
    array(
      'id'      => 'footer-bottom-cp-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Bottom Copyright Color', 'kalles' ),
      'default' => '#56cfe1'
    ),
    array(
      'id'      => 'footer-bottom-newsletter-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Footer Bottom Newsletter Color', 'kalles' ),
      'default' => ''
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__('Product Badge Color', 'kalles'),
    ),
    array(
      'id'    => 'product-sale-color',
      'type'    => 'color',
      'title'   => esc_html__( 'Product Sale Badge Background Color', 'kalles'),
      'default' => '#fe9931'
    ),
    array(
      'id'      => 'product-new-color',
      'type'    => 'color',
      'title'   => esc_html__('Product New Badge Background Color' ,'kalles'),
      'default' => '#56cfe1'
    ),
    array(
      'id'      => 'product-text-color',
      'type'    => 'color',
      'title'   => esc_html__('Product Badge Text Color' ,'kalles'),
      'default' => '#fff'
    ),

  ),
) );
