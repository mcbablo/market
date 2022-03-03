<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */


CSF::createSection( $prefix, array(
    'id'    => 'footer',
    'title' => esc_html__( 'Footer', 'kalles' ),
    'icon'  => 'fas fa-copyright',
    ) );

// Footer config
CSF::createSection( $prefix, array(
  'id'     => 'footer_top',
  'title'  => esc_html__( 'Footer Top', 'kalles' ),
  'parent' => 'footer',
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Footer Top Setting', 'kalles' ),
    ),

    array(
      'id'      => 'footer-widget-title-transform',
      'title'   => esc_html__( 'Footer Widget Title Transform', 'kalles' ),
      'type'       => 'switcher',
      'default' => false,
    ),
    array(
      'id'      => 'footer-newsletter-radius',
      'title'   => esc_html__( 'Footer Widget Newsletter Radius', 'kalles' ),
      'type'       => 'switcher',
      'default' => true,
    ),
    array(
      'id'         => 'footer-bg',
      'type'       => 'background',
      'title'      => esc_html__( 'Background Footer', 'kalles' ),
    ),
    array(
      'id'         => 'enable_footer-mobile',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Footer Mobile', 'kalles' ),
      'default' => false,
    ),
     array(
      'id'         => 'enable_footer-sticky',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Footer Sticky', 'kalles' ),
      'default' => false,
    )
  ),
) );

// Footer config
CSF::createSection( $prefix, array(
  'id'     => 'footer_bottom',
  'title'  => esc_html__( 'Footer Bottom', 'kalles' ),
  'parent' => 'footer',
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Footer Bottom', 'kalles' ),
    ),
    array(
      'id'      => 'footer_copyright-enable',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable Copyright', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'footer-copyright',
      'type'    => 'textarea',
      'title'   => esc_html__( 'Copyright Text', 'kalles' ),
      'desc'    => esc_html__( 'HTML is allowed', 'kalles' ),
      'default' => sprintf( wp_kses_post( 'Copyright 2017 <span class="cp">Kalles</span> all rights reserved. Powered by <a href="%s">The4</a>', 'kalles' ), esc_url( home_url() ) )
    ),
    array(
      'id'    => 'footer-copyright_right-content-type',
      'type'  => 'select',
      'title' => esc_html__( 'Right Content Type', 'kalles' ),
      'desc' => esc_html__( 'If you select Menu, go to Menu manager location and choice Footer menu', 'kalles' ),
      'options' => array(
        'disable' => esc_html__( 'Disable', 'kalles' ),
        'text' => esc_html__( 'Custom HTML, Text', 'kalles' ),
        'trust' => esc_html__( 'Trust Badget', 'kalles' ),
        'shortcode' => esc_html__( 'Shortcode', 'kalles' ),
        'menu' => esc_html__( 'Menu', 'kalles' ),

      ),
      'default' => 'trust'
    ),
    array(
      'id'      => 'footer-copyright_right-text',
      'type'    => 'textarea',
      'title'   => esc_html__( 'Right Content', 'kalles' ),
      'desc'    => esc_html__( 'HTML is allowed', 'kalles' ),
      'default' => '',
      'dependency' => array( 'footer-copyright_right-content-type', '==', 'text' ),
    ),
    array(
        'id'          => 'footer-copyright_right-source_img',
        'type'        => 'select',
        'title'       => esc_html__( 'Source IMG', 'kalles' ),
        'options'     => array(
          '1'     => 'Image',
          '2'     => 'SVG',
        ),
        'dependency' => array( 'footer-copyright_right-content-type', '==', 'trust' ),
    ),
    array(
      'id'         => 'footer-copyright_right-image',
      'type'       => 'media',
      'title'      => esc_html__( 'Trust seal image', 'kalles' ),
      'url'        => false,
      'dependency' => array(
        array('footer-copyright_right-source_img', '==', '1'),
        array( 'footer-copyright_right-content-type', '==', 'trust' )
      ),
    ),
    array(
        'id'    => 'footer-copyright_right-image_width',
        'type'  => 'slider',
        'title' => esc_html__( 'Width image', 'kalles' ),
        'choices' => array(
          'min'  => 40,
          'max'  => 100,
          'step' => 1,
          'unit' => '%',
        ),
        'default' => 60,
        'dependency' => array(
          array('footer-copyright_right-source_img', '==', '1'),
          array( 'footer-copyright_right-content-type', '==', 'trust' )
        ),
    ),
    array(
      'id'            => 'footer-copyright_right-svg-list',
      'type'          => 'textarea',
      'title'         => esc_html__('SVG list', 'kalles'),
      'desc'        => 'amazon_payments,american_express,apple_pay,bitcoin,dankort,diners_club,discover,dogecoin,dwolla,forbrugsforeningen,in terac,google_pay,jcb,klarna,litecoin,maestro,master,paypal,shopify_pay,sofort,visa',
      'default' => 'amazon_payments,american_express,apple_pay,bitcoin,dankort',
      'dependency' => array(
        array('footer-copyright_right-source_img', '==', '2'),
        array( 'footer-copyright_right-content-type', '==', 'trust' )
      ),
    ),
    array(
        'id'    => 'footer-copyright_right-svg-width',
        'type'  => 'slider',
        'title' => esc_html__( 'SVG Width', 'kalles' ),
        'choices' => array(
          'min'  => 40,
          'max'  => 100,
          'step' => 1,
          'unit' => 'px',
        ),
        'default' => 68,
        'dependency' => array(
          array('footer-copyright_right-source_img', '==', '2'),
          array( 'footer-copyright_right-content-type', '==', 'trust' )
        ),
    ),
    array(
        'id'    => 'footer-copyright_right-svg-height',
        'type'  => 'slider',
        'title' => esc_html__( 'SVG Height', 'kalles' ),
        'choices' => array(
          'min'  => 40,
          'max'  => 100,
          'step' => 1,
          'unit' => 'px',
        ),
        'default' => 50,
        'dependency' => array(
          array('footer-copyright_right-source_img', '==', '2'),
          array( 'footer-copyright_right-content-type', '==', 'trust' )
        ),
    ),
    array(
      'id'      => 'footer-copyright_right-shortcode',
      'type'    => 'textarea',
      'title'   => esc_html__( 'Right Content', 'kalles' ),
      'desc'    => esc_html__( 'You can you shortcode. Ex: [kalles_social_buttons]', 'kalles'),
      'default' => '[kalles_social_buttons]',
      'dependency' => array( 'footer-copyright_right-content-type', '==', 'shortcode' ),
    ),
  ),
) );