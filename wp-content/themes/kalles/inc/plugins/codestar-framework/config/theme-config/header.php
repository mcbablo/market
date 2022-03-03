<?php
/**
 * Theme constants definition and functions.
 *
 * @since   1.0.0
 * @package Kalles
 */
// Header config

CSF::createSection( $prefix, array(
    'id'    => 'header',
    'title' => esc_html__( 'Header', 'kalles' ),
    'icon'  => 'fas fa-home',
    ) );

CSF::createSection( $prefix, array(
  'id'     => 'header_general',
  'parent' => 'header',
  'title'  => esc_html__( 'General Setting', 'kalles' ),
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'id'    => 'header-layout',
      'type'  => 'image_select',
      'title' => esc_html__( 'Layout', 'kalles' ),
      'radio' => true,
      'options' => array(
        '1' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-6.png',
        '2' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-2.png',
        '3' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-3.png',
        '4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-4.png',
        '5' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-5.png',
        '6' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-6.png',
        '7' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-7.png',
        '9' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-3.png',
        '11' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-11.png',
        '13' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-13.png',
        '14' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-14.png',
        '15' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-7.png',
        '17' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-7.png',
        '19' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-3.png',
        '20' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/header-9.png',
      ),
      'default'    => '3',
      'attributes' => array(
        'data-depend-id' => 'header-layout',
      ),
    ),

    array(
      'id'    => 'header-icon_type',
      'type'  => 'select',
      'title' => esc_html__( 'Icon style', 'kalles' ),
      'options' => array(
        'la' => 'Lineawesome Icon',
        'pe' => 'Pe 7 Stroke Icon',
        'iccl' => 'Kalles Icon',
      ),
      'default'    => 'iccl',
    ),

    array(
      'id'         => 'header-bg',
      'type'       => 'background',
      'title'      => esc_html__( 'Background', 'kalles' ),
      'dependency' => array( 'header-layout', 'any', 5 ),
    ),
    array(
      'id'         => 'header-sticky',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Header Sticky', 'kalles' ),
      'default'    => false,
      'dependency' => array( 'header-layout', '!=', 5 ),
    ),
    array(
      'id'         => 'header-transparent',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Header Transparent', 'kalles' ),
      'default'    => false,
      'dependency' => array( 'header-layout', '!=', 5 ),
    ),
    array(
      'id'         => 'header-boxed',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Header Boxed', 'kalles' ),
      'default'    => false,
      'dependency' => array( 'header-layout', '!=', 5 ),
    ),
    array(
      'id'         => 'menu-uppercase',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Menu Item Uppercase', 'kalles' ),
      'default'    => false,
    ),
     array(
      'id'         => 'menu-arrow',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Menu Item Arrow', 'kalles' ),
      'default'    => false,
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Logo Settings', 'kalles' ),
    ),
    array(
      'id'        => 'logo',
      'type'      => 'media',
      'url'       => false,
      'title'     => esc_html__( 'Logo', 'kalles' ),
      'add_title' => esc_html__( 'Upload', 'kalles' ),
      'dependency' => array( 'header-transparent', '==', 'false' ),
    ),
    array(
      'id'        => 'logo-retina',
      'type'      => 'media',
      'url'       => false,
      'title'     => esc_html__( 'Logo Retina', 'kalles' ),
      'desc'      => esc_html__( 'Upload logo for retina devices, mobile devices', 'kalles' ),
      'add_title' => esc_html__( 'Upload', 'kalles' ),
      'dependency' => array( 'header-transparent', '==', 'false' ),
    ),
    array(
      'id'         => 'logo-transparent',
      'type'       => 'media',
      'url'       => false,
      'title'      => esc_html__( 'Transparent Header Logo', 'kalles' ),
      'desc'       => esc_html__( 'Add logo for transparent header layout', 'kalles' ),
      'add_title'  => esc_html__( 'Upload', 'kalles' ),
      'dependency' => array( 'header-transparent', '==', 'true' ),
    ),
    array(
      'id'         => 'logo-transparent-retina',
      'type'       => 'media',
      'url'       => false,
      'title'      => esc_html__( 'Transparent Header Logo Retina', 'kalles' ),
      'desc'       => esc_html__( 'Add logo for transparent header layout for retina devices, mobile devices', 'kalles' ),
      'add_title'  => esc_html__( 'Upload', 'kalles' ),
      'dependency' => array( 'header-transparent', '==', 'true' ),
    ),
    array(
      'id'         => 'logo-sticky',
      'type'       => 'media',
      'url'       => false,
      'title'      => esc_html__( 'Sticky Header Logo', 'kalles' ),
      'desc'       => esc_html__( 'Add logo for sticky header. It work when you upload regular logo.', 'kalles' ),
      'add_title'  => esc_html__( 'Upload', 'kalles' ),
      'dependency' => array( 'header-sticky', '==', 'true' ),
    ),
    array(
      'id'      => 'logo-max-width',
      'type'    => 'number',
      'unit'    => 'px',
      'title'   => esc_html__( 'Logo Max Width', 'kalles' ),
      'default' => 200
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Header Top Settings', 'kalles' ),
    ),
    array(
      'id'    => 'header-top',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable Header Top', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'         => 'header-top-left',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Left header content', 'kalles' ),
      'desc'       => esc_html__( 'HTML, shortcode is allowed', 'kalles' ),
      'dependency' => array( 'header-layout', 'any', '2,3,4,5,6,11,13,14,15,17,19,20' ),
    ),
    array(
      'id'         => 'header-top-center',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Center promo text', 'kalles' ),
      'desc'       => esc_html__( 'HTML, shortcode is allowed', 'kalles' ),
      'dependency' => array( 'header-layout', 'any', '1,2,3,4,5,6,11,13,14,15,17,19,20' ),
    ),
    array(
      'id'         => 'header-top-right',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Right header content', 'kalles' ),
      'desc'       => esc_html__( 'HTML, shortcode is allowed', 'kalles' ),
      'dependency' => array( 'header-layout', 'any', '1' ),
    ),
    array(
      'id'    => 'header-currency',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable currency', 'kalles' ),
      'default' => false,
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( ' Main header settings', 'kalles' ),
    ),
    array(
      'id'      => 'header-search-icon',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable search icon', 'kalles' ),
      'default' => true,
    ),
    array(
      'id'      => 'search-fullscreen',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable search fullscreen', 'kalles' ),
      'default' => false,
    ),
    array(
      'id'      => 'header-my-account-icon',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable my account icon', 'kalles' ),
      'default' => true,
    ),
    array(
      'id'         => 'header-main-left',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Header main left content', 'kalles' ),
      'desc'       => esc_html__( 'HTML, shortcode is allowed', 'kalles' ),
      'dependency' => array( 'header-layout', 'any', '2,4,14' ),
    ),
    array(
        'id'         => 'header-top-left-mobile',
        'type'       => 'textarea',
        'title'      => esc_html__( 'Moblie Menu help content', 'kalles' ),
        'desc'       => esc_html__( 'HTML, shortcode is allowed', 'kalles' ),
    ),
  )
) );
CSF::createSection( $prefix, array(
  'id'     => 'header_banner',
  'parent' => 'header',
  'title'  => esc_html__( 'Promo Banner', 'kalles' ),
  'icon'   => 'fa fa-minus',
  'fields' => array(
        array(
            'id'         => 'header-countdown',
            'type'       => 'switcher',
            'title'      => esc_html__( 'Enable Promo Bar', 'kalles' ),
            'default'    => true
        ),
        array(
          'id'         => 'header-promobar-text',
          'type'       => 'textarea',
          'title'      => esc_html__( 'Banner content', 'kalles' ),
          'desc'       => esc_html__( 'Place here text you want to see in the header banner. You can use shortocdes: [countdown]', 'kalles' ),
          'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'       => 'header-countdown-link',
            'type'     => 'link',
            'title'    => 'Banner link',
            'default'  => array(
                'url'    => 'http://the4.co/',
                'text'   => 'The4',
                'target' => '_blank'
            ),
            'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'      => 'header-countdown-date',
            'type'    => 'date',
            'title'   => esc_html__( 'Data countdown', 'kalles' ),
            'default' => '2021/12/31',
            'desc'    => 'Countdown to the end sale date will be shown.( 2021/12/31 )',
            'settings' => array(
                          'dateFormat'      => 'yy/mm/dd'
                        ),
            'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'       => 'header-countdown-minheight',
            'type'     => 'slider',
            'title'    => 'Min Height',
            'min'      => 20,
            'max'      => 120,
            'step'     => 1,
            'default'  => 42,
            'unit'     => 'px',
            'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'       => 'header-countdown-fontsize',
            'type'     => 'slider',
            'title'    => 'Font Size',
            'min'      => 12,
            'max'      => 18,
            'step'     => 1,
            'default'  => 14,
            'unit'     => 'px',
            'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
          'id'         => 'header-promobar-textcolor',
          'type'       => 'color',
          'title'      => esc_html__( 'Text Color', 'kalles' ),
          'default'    => '#fff',
          'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
          'id'         => 'header-promobar-background',
          'type'       => 'color',
          'title'      => esc_html__( 'Background Color', 'kalles' ),
          'default'    => '#e91e63',
          'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'       => 'header-promobar-bg_opacity',
            'type'     => 'slider',
            'title'    => 'Background opacity',
            'min'      => 0,
            'max'      => 100,
            'step'     => 1,
            'default'  => 100,
            'unit'     => '%',
            'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'    => 'header-promobar-show_close',
            'type'  => 'switcher',
            'title' => esc_html__( 'Show close button?', 'kalles' ),
            'label' => esc_html__( 'Enable', 'kalles' ),
            'default'=> true, 
            'dependency' => array( 'header-countdown', '==', true )
          ),
        array(
            'id'    => 'header-promobar-show_close_icon',
            'type'  => 'switcher',
            'title' => esc_html__( 'Show only icon close?', 'kalles' ),
            'label' => esc_html__( 'Enable', 'kalles' ),
            'default'=> true,
            'dependency' => array( 'header-countdown', '==', true )
          ),
        array(
          'id'         => 'header-promobar-btn_close_text',
          'type'       => 'text',
          'title'      => esc_html__( 'Button close Text', 'kalles' ),
          'default'=> 'close',
          'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
          'id'         => 'header-promobar-btn_close_color',
          'type'       => 'color',
          'title'      => esc_html__( 'Button close Color', 'kalles' ),
          'default'    => '#fff',
          'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'       => 'header-countdown-ver',
            'type'     => 'slider',
            'title'    => 'Header banner version',
            'desc'     => esc_html__( 'If you change your header banner you can increase its version to show the header banner to all visitors again.', 'kalles'),
            'min'      => 1,
            'max'      => 100,
            'step'     => 1,
            'default'  => 1,
            'dependency' => array( 'header-countdown', '==', true )
        ),
        array(
            'id'       => 'header-countdown-expires',
            'type'     => 'slider',
            'title'    => 'Header banner expires',
            'desc'     => esc_html__( 'You will be able to specify when to expire the cookie. Once you click the "CLOSE" button', 'kalles' ),
            'min'      => 1,
            'max'      => 100,
            'step'     => 1,
            'default'  => 30,
            'unit'     => 'day',
            'dependency' => array( 'header-countdown', '==', true )
        ),
   
  )
) );