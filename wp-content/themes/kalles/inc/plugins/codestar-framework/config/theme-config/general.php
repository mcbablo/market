<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */

// General config
CSF::createSection( $prefix, array(
  'id'     => 'layout',
  'title'  => esc_html__( 'General', 'kalles' ),
  'icon'   => 'fa fa-building-o',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Layout Setting', 'kalles' ),
    ),
    array(
      'id'      => 'layout-type',
      'type'    => 'button_set',
      'title'   => esc_html__( 'Site Width', 'kalles' ),
      'default' => 'full_width',
      'options' => array(
        'full_width' => esc_html__( 'Full width', 'kalles' ),
        'content_full' => esc_html__( 'Content full width', 'kalles' ),
        'wide' => esc_html__( 'Wide (1600 px)', 'kalles' ),
        'boxed' => esc_html__( 'Boxed', 'kalles' )
      ),
    ),
    array(
      'id'      => 'content-width',
      'type'    => 'slider',
      'title'   => esc_html__( 'Content boxed Width', 'kalles' ),
      'desc'    => esc_html__( 'Ony active when enable Boxed', 'kalles' ),
      'min'     => 1100,
      'max'     => 1200,
      'step'    => 5,
      'unit'    => 'px',
      'default' => 1200,
      'dependency' => array( 'layout-type', '==', 'boxed' ),
    ),
    array(
      'id'         => 'boxed-bg',
      'type'       => 'background',
      'title'      => esc_html__( 'Background', 'kalles' ),
      'dependency' => array( 'layout-type', '==', 'boxed' ),
    ),
    array(
      'id'    => 'preloader',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable Preloader', 'kalles' ),
    ),
    array(
      'id'      => 'preloader-type',
      'type'    => 'select',
      'title'   => esc_html__( 'Animation type', 'kalles' ),
      'options' => array(
        'css' => esc_html__( 'CSS', 'kalles' ),
        'img' => esc_html__( 'Image', 'kalles' )
      ),
      'dependency' => array( 'preloader', '==', true ),
    ),
    array(
      'id'         => 'preloader-img',
      'type'       => 'media',
      'title'      => esc_html__( 'Preloader Image', 'kalles' ),
      'library'    => 'image',
      'url'        => false,
      'dependency' => array( 'preloader|preloader-type', '==', 'true|img' ),
    ),
    array(
        'id'      => 'btn_design',
        'type'    => 'button_set',
        'title'   => esc_html__( 'Button design', 'kalles' ),
        'options' => array(
            '1' => esc_html__( 'Circle', 'kalles' ),
            '2' => esc_html__( 'Rounded', 'kalles' ),
            '3' => esc_html__( 'Square', 'kalles' ),
        )
      ),

    array(
      'id'    => 'general_404-page',
      'type'  => 'select',
      'title' => esc_html__( 'Custom 404 Page', 'kalles' ),
      'desc' => esc_html__( 'Select page to view 404, Default is page 404 of theme.', 'kalles' ),
      'ajax'        => true,
      'options'     => 'pages',
      'placeholder' => 'Select page',
      'chosen'      => true,
    ),

    //Moblie Setting
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Moblie Setting', 'kalles' ),
    ),
    array(
      'id'    => 'general_mobile_toolbar-enable',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable Toolbar Mobile', 'kalles' ),
    ),
    array(
      'id'       => 'general_mobile_toolbar-label',
      'type'     => 'switcher',
      'text_on'  => 'Yes',
      'text_off' => 'No',
      'title'    => esc_html__( 'Show label under icons ?', 'kalles' ),
    ),
    array(
      'id'     => 'general_mobile_toolbar_items',
      'type'   => 'repeater',
      'title'  => esc_html__('Toolbar mobile items', 'kalles'),
      'dependency' => array('general_mobile_toolbar-enable', '==', true),
      'fields' => array(
        array(
          'id'    => 'title',
          'type'  => 'text',
          'title' => esc_html__('Title', 'kalles'),
        ),
        array(
          'id'    => 'link',
          'type'  => 'link',
          'title' => esc_html__('Link', 'kalles'),
        ),
        array(
          'id'    => 'icon',
          'type'  => 'text',
          'title' => esc_html__('Icon', 'kalles'),
          'desc'  => 'Enter icon class, find icon class <a href="https://kalles.the4.co/kallesicon/" target="_blank">here</a>',
        ),
        array(
          'id'    => 'event',
          'type'  => 'button_set',
          'title' => esc_html__('Click event', 'kalles'),
          'options' => array(
            'toolbar_icon_event_default' => esc_html__('Default', 'kalles'),
            'the4-icon-cart' => esc_html__('Open Mini Cart', 'kalles'),
            'the4-my-account' => esc_html__('Open Account', 'kalles'),
            'sf-open' => esc_html__('Open Search', 'kalles'),
          )
        ),
      ),
      'default' => array(
        array(
          'title' => 'Shop',
          'link'    => array(
            'url' => '#',
          ),
          'icon'     => 't4_icon_t4-grid',
        ),
        array(
          'title' => 'Wishlist',
          'link'    => array(
            'url' => '#',
          ),
          'icon'     => 't4_icon_t4-heart',
        ),
        array(
          'title' => 'Cart',
          'link'    => array(
            'url' => '#',
          ),
          'icon'     => 't4_icon_t4-shopping-cart',
          'event'     => array( 'the4-icon-cart' ),
        ),
        array(
          'title' => 'Account',
          'link'    => array(
            'url' => '#',
          ),
          'icon'     => 't4_icon_t4-user',
          'event'     => array( 'the4-my-account' ),
        ),
        array(
          'title' => 'Search',
          'link'    => array(
            'url' => '#',
          ),
          'icon'     => 't4_icon_t4-search',
          'event'     => array( 'sf-open' ),
        ),
      ),
    ),
    //Performance Setting
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Performance Setting', 'kalles' ),
    ),
    array(
      'id'    => 'general_lazyload-enable',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable Lazyload', 'kalles' ),
       'default' => true,
    ),
    array(
      'id'      => 'general_lazyload-type',
      'type'    => 'button_set',
      'title'   => esc_html__( 'Lazyload type', 'kalles' ),
      'default' => 'kalles',
      'options' => array(
        'wp' => esc_html__( 'Wordpress lazyload default', 'kalles' ),
        'kalles' => esc_html__( 'Kalles Lazyload', 'kalles' ),
      ),
      'dependency' => array( 'general_lazyload-enable', '==', true ),
    ),
    array(
      'id'      => 'general_lazyload-icon',
      'type'    => 'media',
      'title'   => esc_html__( 'Lazyload custom icon', 'kalles' ),
      'library' => 'image',
      'url' => false,
      'dependency' => array(
        array( 'general_lazyload-enable', '==', true ),
        array( 'general_lazyload-type', '==', 'kalles' )
      ),
    ),
    array(
      'id'      => 'general_lazyload-icon_size',
      'type'    => 'slider',
      'title'   => esc_html__( 'Size Icon Lazyload', 'kalles' ),
      'min'     => 10,
      'max'     => 100,
      'step'    => 1,
      'unit'    => 'px',
      'default' => 25,
      'dependency' => array(
        array( 'general_lazyload-enable', '==', true ),
        array( 'general_lazyload-type', '==', 'kalles' )
      ),
    ),
  )
) );