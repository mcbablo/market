<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * White label
 *
 * @since   1.0.3
 * @package Kalles
 */


//
// Set a unique slug-like ID
//
$prefix = '_kalles_options_white_label';
// Create options
$theme_is_active = get_option( 'envate_purchase_code_kalleswp' ) ? true : false;


if ($theme_is_active) {
    CSF::createOptions($prefix, array(
    // framework title
    'framework_title' => 'The4 Kalles White Label Option',
    'framework_class' => '',
    'sticky_header'   => false,
    'menu_title'      => 'White Label',
    'menu_type'       => 'submenu',
    'menu_slug'       => 'the4-theme-white-label-options',
    'theme'           => 'dark',
    'menu_hidden'     => true,
    'show_bar_menu'   => false,
    // footer
    'show_footer'             => false,
    'show_search'             => false,
    'show_reset_all'          => false,
    'show_reset_section'      => false,
  ));

    // General config
    CSF::createSection( $prefix, array(
      'id'     => 'layout',
      'title'  => esc_html__( 'General', 'kalles' ),
      'icon'   => 'fa fa-building-o',
      'fields' => array(
        array(
          'type'    => 'heading',
          'content' => esc_html__( 'White Label Setting', 'kalles' ),
        ),
        array(
          'id'        => 'white_label-menu_icon',
          'type'      => 'media',
          'url'       => false,
          'title'     => esc_html__( 'Menu icon', 'kalles' ),
          'add_title' => esc_html__( 'Upload', 'kalles' ),
          'desc' => esc_html__( 'Image that will be displayed in Admin menu. Recommended size 20x20', 'kalles' ),
        ),
        array(
          'id'        => 'white_label-menu_title',
          'type'      => 'text',
          'title'     => esc_html__( 'Menu Title', 'kalles' ),
          'default' => esc_html__( 'The4 Dashboard', 'kalles' ),
        ),
        
        array(
          'id'      => 'white_label-option_text',
          'type'    => 'text',
          'title'   => esc_html__( 'Theme option header', 'kalles' ),
          'default' => 'The4 Kalles Option'
        ),
        array(
          'id'      => 'white_label-option_footer_text',
          'type'    => 'text',
          'title'   => esc_html__( 'Theme option footer text', 'kalles' ),
          'default' => 'Options panel created using <a href="https://codestarframework.com/">Codestar framework</a>'
        ),
        array(
          'id'         => 'white_label-dasboard',
          'type'       => 'switcher',
          'title'      => esc_html__( 'Disable Dashboard', 'kalles' ),
          'default'    => false,
        ),
        array(
          'id'         => 'white_label-import',
          'type'       => 'switcher',
          'title'      => esc_html__( 'Disable Demo Import', 'kalles' ),
          'default'    => false,
        ),
        array(
          'type'    => 'subheading',
          'content' => esc_html__( 'Theme Appearance', 'kalles' ),
        ),
        array(
          'id'      => 'white_label-theme_name',
          'type'    => 'text',
          'title'   => esc_html__( 'Theme name', 'kalles' ),
          'default' => 'Kalles'
        ),
        array(
          'id'        => 'white_label-appearance_screenshot',
          'type'      => 'media',
          'url'       => false,
          'title'     => esc_html__( 'Appearance screenshot', 'kalles' ),
          'desc'     => esc_html__( 'Image that will be displayed in Dashboard -> Appearance -> Themes. Recommended size: 1200×900 (px)', 'kalles' ),
          'add_title' => esc_html__( 'Upload', 'kalles' ),
        ),
        array(
          'type'    => 'subheading',
          'content' => esc_html__( 'Login Page', 'kalles' ),
        ),
        array(
          'id'        => 'white_label-login_logo',
          'type'      => 'media',
          'url'       => false,
          'title'     => esc_html__( 'Login logo', 'kalles' ),
          'add_title' => esc_html__( 'Upload', 'kalles' ),
        ),
        array(
          'id'      => 'white_label-login_url',
          'type'    => 'link',
          'title'   => esc_html__( 'Login Logo URL', 'kalles' )
        ),
      )
    ) );
}











