<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */


//Woocommerce Product config

CSF::createSection( $prefix, array(
    'id'    => 'woocommerce-product',
    'title' => esc_html__( 'Product Page', 'kalles' ),
    'icon'  => 'fas fa-shopping-basket',
    ) );
CSF::createSection( $prefix, array(
'parent'      => 'woocommerce-product',
'id'          => 'wc_detail_setting',
'title'       => esc_html__( 'General', 'kalles' ),
'icon'        => 'fa fa-minus',
'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Product layout', 'kalles' ),
      ),
      array(
        'id'      => 'wc-detail-full',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Enable full width', 'kalles' ),
        'default' => false,
      ),
      array(
        'id'      => 'wc-single-style',
        'type'    => 'image_select',
        'title'   => esc_html__( 'Product detail style', 'kalles' ),
        'radio'   => true,
        'options' => array(
          '1' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-1.png',
          '2' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-2.png',
          '3' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-3.png',
          '4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-4.png',
        ),
        'default' => '1'
      ),
      array(
        'id'         => 'wc-thumbnail-position',
        'type'       => 'select',
        'title'      => esc_html__( 'Thumbnail position', 'kalles' ),
        'options' => array(
          'left'    => esc_html__( 'Left', 'kalles' ),
          'bottom'  => esc_html__( 'Bottom', 'kalles' ),
          'right'   => esc_html__( 'Right', 'kalles' ),
          'outside' => esc_html__( 'Outside', 'kalles' )
        ),
        'default'    => 'left',
        'dependency' => array( 'wc-single-style_1', '==', true ),
      ),
      array(
        'id'      => 'wc-extra-layout',
        'type'    => 'select',
        'title'   => esc_html__( 'Extra infomation Layout', 'kalles' ),
        'options' => array(
          'tab'       => esc_html__( 'Tab', 'kalles' ),
          'accordion' => esc_html__( 'Accordion', 'kalles' ),
          'full' => esc_html__( 'Full', 'kalles' ),
        ),
      ),
      array(
        'id'      => 'wc-extra-position',
        'type'    => 'select',
        'title'   => esc_html__( 'Position', 'kalles' ),
        'options' => array(
          '1' => esc_html__( 'Above extra products', 'kalles' ),
          '2' => esc_html__( 'Below product description', 'kalles' ),
        ),
        'dependency' => array( 'wc-single-style_3', '==', false ),
      ),
      array(
        'id'    => 'product-detail-layout',
        'type'    => 'image_select',
        'title'   =>  esc_html__('Product Detail Sidebar Layout','kalles'),
        'desc'    =>  esc_html__('Apply for product detail layout 1-2-4','kalles'),
        'radio'   => true,
        'label' => true,
        'options' => array(
          'left-sidebar'  => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/left-sidebar.png',
          'no-sidebar'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
          'right-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
        ),
        'default'    => 'no-sidebar',

      ),
      array(
        'id'         => 'product-detail-sidebar',
        'type'       => 'select',
        'title'      => esc_html__( 'Select Sidebar', 'kalles' ),
        'options'    => 'sidebars',
        'dependency' => array( 'product-detail-layout', '!=', 'no-sidebar' ),
      ),

      array(
        'type'    => 'subheading',
        'content' => esc_html__( 'Miscellaneous', 'kalles' ),
      ),
      array(
        'id'      => 'wc_product-brc_btn',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Display Prev/Next navigation in breadcrumb', 'kalles' ),
        'default' => true
      ),
      array(
        'id'      => 'wc-sticky-atc',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Enable sticky add to cart', 'kalles' ),
        'desc'   => esc_html__( 'This option not yet compatible with Appointment booking plugin', 'kalles' ),
        'default' => false
      ),
      array(
        'id'      => 'wc-sticky-atc_mobile',
        'type'    => 'switcher',
        'desc'   => esc_html__( 'This option not yet compatible with Appointment booking plugin', 'kalles' ),
        'title'   => esc_html__( 'Enable Mobile sticky add to cart', 'kalles' ),
        'default' => false
      ),
      array(
        'id'        => 'wc-summary_btn_sticky_atc_color',
        'type'      => 'color_group',
        'title'     => 'Button color',
        'options'   => array(
          'bg' => esc_html__( 'Background', 'kalles' ),
          'bg_hover' => esc_html__( 'Background hover', 'kalles' ),
          'color' => esc_html__( 'Text color', 'kalles' ),
          'color_hover' => esc_html__( 'Text color hover', 'kalles' ),
          'border' => esc_html__( 'Border color', 'kalles' ),
          'border_hover' => esc_html__( 'Border color hover', 'kalles' ),
        ),
        'default'   => array(
          'bg'           => '#56CFE1',
          'bg_hover'     => '#56CFE1',
          'color'        => '#fff',
          'color_hover'  => '#fff',
          'border'       => '#56CFE1',
          'border_hover' => '#56CFE1',
        )
      ),
      array(
          'id'    => 'wc-summary_btn_sticky_atc_opacity',
          'type'  => 'slider',
          'title' => esc_html__( 'Opacity on hover', 'kalles' ),
          'min'  => 0.1,
          'max'  => 1,
          'step' => 0.1,
          'default' => 1
      ),
      array(
        'id'      => 'wc-single-photoswipe',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Enable Abum Gallery', 'kalles' ),
        'default' => true,
      ),
      
    )
) );
CSF::createSection( $prefix, array(
'parent'      => 'woocommerce-product',
'id'          => 'wc_product_summary',
'title'       => esc_html__( 'Product summary', 'kalles' ),
'icon'        => 'fa fa-minus',
'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Add to cart button', 'kalles' ),
      ),
      array(
        'id'      => 'wc-summary_btn_effect',
        'type'    => 'select',
        'title'   => esc_html__( 'Add to cart animation', 'kalles' ),
        'options' => array(
          'none'      => esc_html__( 'None', 'kalles' ),
          'bounce'    => esc_html__( 'Bounce', 'kalles' ),
          'tada'      => esc_html__( 'Tada', 'kalles' ),
          'swing'     => esc_html__( 'Swing', 'kalles' ),
          'flash'     => esc_html__( 'Flash', 'kalles' ),
          'fadeIn'    => esc_html__( 'FadeIn', 'kalles' ),
          'heartBeat' => esc_html__( 'HeartBeat', 'kalles' ),
          'shake'     => esc_html__( 'Shake', 'kalles' )
        ),
        'default'    => 'shake',

      ),
      array(
        'id'    => 'wc-summary_btn_effect_time',
        'type'  => 'slider',
        'title' => esc_html__( 'Loop time (seconnds)', 'kalles' ),
        'desc'  => esc_html__( 'Loop time add to cart animation', 'kalles' ),
          'min'  => 2,
          'max'  => 40,
          'step' => 1,
          'unit' => 'sec',
        'default' => 6
      ),
      array(
        'id'      => 'wc-summary_btn_design',
        'type'    => 'button_set',
        'title'   => esc_html__( 'Button design', 'kalles' ),
        'options' => array(
            '1' => esc_html__( 'Circle', 'kalles' ),
            '2' => esc_html__( 'Rounded', 'kalles' ),
            '3' => esc_html__( 'Square', 'kalles' ),
        )
      ),
      array(
        'id'      => 'wc-summary_btn_transform_txt',
        'type'    => 'select',
        'title'   => esc_html__( 'Button transform text', 'kalles' ),
        'default'    => '3',
        'options' => array(
                  '0' => esc_html__( 'None', 'kalles' ),
                  '1' => esc_html__( 'Lowercase', 'kalles' ),
                  '2' => esc_html__( 'Capitalize', 'kalles' ),
                  '3' => esc_html__( 'Uppercase', 'kalles' ),
        )
      ),
      array(
        'id'        => 'wc-summary_btn_color',
        'type'      => 'color_group',
        'title'     => 'Button color',
        'options'   => array(
          'bg' => esc_html__( 'Background', 'kalles' ),
          'bg_hover' => esc_html__( 'Background hover', 'kalles' ),
          'color' => esc_html__( 'Text color', 'kalles' ),
          'color_hover' => esc_html__( 'Text color hover', 'kalles' ),
          'border' => esc_html__( 'Border color', 'kalles' ),
          'border_hover' => esc_html__( 'Border color hover', 'kalles' ),
        ),
        'default'   => array(
          'bg'           => '#56CFE1',
          'bg_hover'     => '#56CFE1',
          'color'        => '#fff',
          'color_hover'  => '#fff',
          'border'       => '#56CFE1',
          'border_hover' => '#56CFE1',
        )
      ),
      array(
          'id'    => 'wc-summary_btn_opacity',
          'type'  => 'slider',
          'title' => esc_html__( 'Opacity on hover', 'kalles' ),
          'min'  => 0.1,
          'max'  => 1,
          'step' => 0.1,
          'default' => 1
      ),
      array(
        'type'    => 'subheading',
        'content' => esc_html__( 'By now button', 'kalles' ),
      ),
      array(
        'id'      => 'wc-single-buynow_btn',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Enable buy now button', 'kalles' ),
        'desc'   => esc_html__( 'This option available for simple and variantion products', 'kalles' ),
        'default' => false,
      ),
      array(
        'id'      => 'wc-single-buynow_text',
        'type'    => 'text',
        'title'   => esc_html__( 'Buy now button text', 'kalles' ),
        'default' => 'Buy it now',
        'dependency' => array( 'wc-single-buynow_btn', '==', true ),
      ),
      array(
        'id'        => 'wc-summary_btn_buynow_color',
        'type'      => 'color_group',
        'title'     => 'Button color',
        'options'   => array(
          'bg' => esc_html__( 'Background', 'kalles' ),
          'bg_hover' => esc_html__( 'Background hover', 'kalles' ),
          'color' => esc_html__( 'Text color', 'kalles' ),
          'color_hover' => esc_html__( 'Text color hover', 'kalles' ),
          'border' => esc_html__( 'Border color', 'kalles' ),
          'border_hover' => esc_html__( 'Border color hover', 'kalles' ),
        ),
        'default'   => array(
          'bg'           => '#56CFE1',
          'bg_hover'     => '#56CFE1',
          'color'        => '#fff',
          'color_hover'  => '#fff',
          'border'       => '#56CFE1',
          'border_hover' => '#56CFE1',
        )
      ),
      array(
          'id'    => 'wc-summary_btn_buynow_opacity',
          'type'  => 'slider',
          'title' => esc_html__( 'Opacity on hover', 'kalles' ),
          'min'  => 0.1,
          'max'  => 1,
          'step' => 0.1,
          'default' => 1
      ),
      array(
        'type'    => 'subheading',
        'content' => esc_html__( 'Product Tabs', 'kalles' ),
      ),
      array(
        'id'      => 'wc-single-tabs_desc',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Diable description tab', 'kalles' ),
        'default' => false,
      ),
      array(
        'id'      => 'wc-single-tabs_add',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Diable additional information tab', 'kalles' ),
        'default' => false,
      ),
      array(
        'id'      => 'wc-single-tabs_review',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Diable review tab', 'kalles' ),
        'default' => false,
      ),
      array(
        'type'    => 'subheading',
        'content' => esc_html__( 'Summary extra elements position', 'kalles' ),
      ),
      array(
        'id'           => 'wc-summary_position_sort',
        'type'         => 'sortable',
        'class'        => 'sortable-disable-field',
        'title'        => esc_html__( 'Change Position', 'kalles' ),
        'fields'       => array(
          array(
            'id'       => 'the4_kalles_woo_trust_badget',
            'type'     => 'text',
            'title'    => esc_html__( 'Trust Badge', 'kalles' )
          ),
          array(
            'id'       => 'the4_kalles_woo_product_live_view',
            'type'     => 'text',
            'title'    => esc_html__( 'Live View', 'kalles' )
          ),
          array(
            'id'       => 'the4_kalles_woo_product_flash_sale',
            'type'     => 'text',
            'title'    => esc_html__( 'Total Sold Flash', 'kalles' )
          ),
          array(
            'id'       => 'the4_kalles_woo_product_delivery_time',
            'type'     => 'text',
            'title'    => esc_html__( 'Delivery Time', 'kalles' )
          ),
          array(
            'id'       => 'the4_kalles_woo_product_stock_left',
            'type'     => 'text',
            'title'    => esc_html__( 'Inventory Quantity', 'kalles' )
          ),
        ),
      ),
    )
) );

// Product Cross-sell
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product-help',
    'title'       => esc_html__( 'Size guide', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Size guide & Return', 'kalles' ),
      ),
      array(
        'id'      => 'wc-single-size-guide-enable',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Enable size guide', 'kalles' ),
        'default' => true,
      ),
      array(
        'id'      => 'wc-single-size-guide-type',
        'type'    => 'select',
        'title'   => esc_html__( 'Size guide type', 'kalles' ),
        'options' => array(
          'text'      => esc_html__( 'Text, HTML', 'kalles' ),
          'image'    => esc_html__( 'Image', 'kalles' ),
        ),
        'default'    => 'text',

      ),
      array(
        'id'    => 'wc-single-size-guide',
        'title' => esc_html__( 'Size guide image', 'kalles' ),
        'type'  => 'media',
        'url'  => false,
        'dependency' => array( 'wc-single-size-guide-type', '==', 'image' ),
      ),
      array(
        'id'    => 'wc-single-size-guide_html',
        'title' => esc_html__( 'Size guide HTML', 'kalles' ),
        'type'  => 'wp_editor',
        'desc'  => esc_html__( 'HTML is allowed', 'kalles' ),
        'dependency' => array( 'wc-single-size-guide-type', '==', 'text' ),
      ),
      array(
        'id'      => 'wc-single-shipping-return-enable',
        'type'    => 'switcher',
        'title'   => esc_html__( 'Enable Shipping & Return content', 'kalles' ),
        'default' => true,
      ),
      array(
        'id'    => 'wc-single-shipping-return',
        'title' => esc_html__( 'Shipping & Return content', 'kalles' ),
        'type'  => 'wp_editor',
        'desc'  => esc_html__( 'HTML is allowed', 'kalles' ),
      ),
  )
));




CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_cart_zoom',
    'title'       => esc_html__( 'Product Image Zoom', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Product Image Zoom', 'kalles' ),
          ),
          array(
            'id'      => 'wc-single-zoom',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Product Image Zoom', 'kalles' ),
            'default' => true,
          ),
        array(
            'id'          => 'wc_cart_zoom-type',
            'type'        => 'button_set',
            'title'       => esc_html__( 'Zoom Type', 'kalles' ),
            'options'     => array(
              'inner'     => 'Inner',
              'window'     => 'Window',
              'lens'     => 'Lens',
            ),
            'default' => 'inner',
        ),
        array(
            'id'          => 'wc_cart_zoom-cursor_type',
            'type'        => 'image_select',
            'title'       => esc_html__( 'Zoom Cursor', 'kalles' ),
            'options'     => array(
              'default'     => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/icon/mouse-default.png',
              'pointer'     => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/icon/mouse-pointer.png',
              'crosshair'   => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/icon/mouse-cross.png',
              'zoom-in'     => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/icon/mouse-zoom.png',
            ),
            'default' => 'crosshair',
        ),
        array(
            'id'         => 'wc_cart_zoom-fade_time',
            'type'       => 'slider',
            'title'      => esc_html__( 'Fade Time', 'kalles' ),
            'desc'      => esc_html__( 'speed of Lens fadeIn', 'kalles' ),
            'unit'       => 's',
            'default'    => 0,
            'min'        => 0,
            'max'        => 10,
            'step'       => 1,
            'dependency' => array('wc_cart_zoom-type', '!=', 'inner'),
        ),
        array(
            'id'          => 'wc_cart_zoom-lens_shape',
            'type'        => 'button_set',
            'title'       => esc_html__( 'Lens Shape', 'kalles' ),
            'default'     => 'round',
            'options'     => array(
              'round'     => 'Round',
              'square'     => 'Square',
            ),
            'dependency' => array('wc_cart_zoom-type', '==', 'lens'),
        ),
        
        array(
            'id'         => 'wc_cart_zoom-border_width',
            'type'       => 'slider',
            'title'      => esc_html__( 'Border Thickness', 'kalles' ),
            'desc'      => esc_html__( 'Set 0 to disable border', 'kalles' ),
            'unit'       => 'px',
            'default'    => 1,
            'min'        => 0,
            'max'        => 10,
            'step'       => 1,
            'dependency' => array('wc_cart_zoom-type', '!=', 'inner'),
        ),
        array(
            'id'          => 'wc_cart_zoom-border_color',
            'type'        => 'color',
            'title'       => esc_html__( 'Border Color', 'kalles' ),
            'default'     => '#FFF',
            'dependency'  => array('wc_cart_zoom-type', '!=', 'inner'),
        ),
        array(
            'id'          => 'wc_cart_zoom-tint',
            'type'        => 'switcher',
            'title'       => esc_html__( 'Tint', 'kalles' ),
            'desc'      => esc_html__( 'Enable a tint overlay', 'kalles' ),
            'default'     => false,
            'dependency'  => array('wc_cart_zoom-type', '==', 'window'),
        ),
        array(
            'id'          => 'wc_cart_zoom-tint_color',
            'type'        => 'color',
            'title'       => esc_html__( 'Tint Color', 'kalles' ),
            'desc'      => esc_html__( 'Color of the tint', 'kalles' ),
            'default'     => '#FFF',
            'dependency'  => array(
              array('wc_cart_zoom-tint', '==', true),
              array('wc_cart_zoom-type', '==', 'window')
            ),
        ),
        array(
            'id'         => 'wc_cart_zoom-tint_opacity',
            'type'       => 'slider',
            'title'      => esc_html__( 'Tint Opacity', 'kalles' ),
            'desc'      => esc_html__( 'opacity of the tint', 'kalles' ),
            'unit'       => 'px',
            'default'    => 0.4,
            'min'        => 0,
            'max'        => 1,
            'step'       => 0.1,
            'dependency'  => array(
              array('wc_cart_zoom-tint', '==', true),
              array('wc_cart_zoom-type', '==', 'window')
            ),
        ),
        array(
            'id'          => 'wc_cart_zoom-easing',
            'type'        => 'switcher',
            'title'       => esc_html__( 'Easing effect', 'kalles' ),
            'default'     => true,
            'dependency'  => array('wc_cart_zoom-type', '==', 'window'),
        ),
        array(
            'id'          => 'wc_cart_zoom-scroll_zoom',
            'type'        => 'switcher',
            'title'       => esc_html__( 'Scroll Zoom', 'kalles' ),
            'desc'      => esc_html__( 'Enable to activate zoom on mouse scroll.', 'kalles' ),
            'default'     => false,
            'dependency'  => array('wc_cart_zoom-type', '==', 'window'),
        ),
        array(
            'id'          => 'wc_cart_zoom-window_width',
            'type'        => 'number',
            'title'       => esc_html__( 'Window Width', 'kalles' ),
            'unit'        => 'px',
            'default'     => 500,
            'dependency'  => array('wc_cart_zoom-type', '==', 'window'),
        ),
        array(
            'id'          => 'wc_cart_zoom-window_height',
            'type'        => 'number',
            'title'       => esc_html__( 'Window Height', 'kalles' ),
            'unit'        => 'px',
            'default'     => 500,
            'dependency'  => array('wc_cart_zoom-type', '==', 'window'),
        ),
        array(
            'id'          => 'wc_cart_zoom-lens_size',
            'type'        => 'number',
            'title'       => esc_html__( 'Lens Size', 'kalles' ),
            'unit'        => 'px',
            'default'     => 200,
            'dependency' => array('wc_cart_zoom-type', '==', 'lens'),
        ),
        
    )
  ) );


CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_cart_trust_badget',
    'title'       => esc_html__( 'Trust Badge', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Trust Badge Product page', 'kalles' ),
          ),
          array(
            'id'      => 'wc_cart_trust_badget-enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Trust Badge Product page', 'kalles' ),
            'default' => true,
          ),
          array(
          'id'            => 'wc_cart_trust_badget-text',
          'type'          => 'wp_editor',
          'title'         => esc_html__('Message', 'kalles'),
          'height'        => '100px',
          'media_buttons' => false,
        ),
        array(
            'id'          => 'wc_cart_trust_badget-source_img',
            'type'        => 'select',
            'title'       => esc_html__( 'Source IMG', 'kalles' ),
            'options'     => array(
              '1'     => 'Image',
              '2'     => 'SVG',
            ),
        ),
        array(
          'id'         => 'wc_cart_trust_badget-image',
          'type'       => 'media',
          'title'      => esc_html__( 'Trust seal image', 'kalles' ),
          'url'        => false,
          'dependency' => array('wc_cart_trust_badget-source_img', '==', '1'),
        ),
        array(
            'id'          => 'wc_cart_trust_badget-image_align',
            'type'        => 'select',
            'title'       => esc_html__( 'IMG Alignment', 'kalles' ),
            'options'     => array(
              'tl'     => esc_html__( 'Left', 'kalles' ),
              'tc'     => esc_html__( 'Center', 'kalles' ),
              'tr'     => esc_html__( 'Right', 'kalles' ),
            ),
            'dependency' => array('wc_cart_trust_badget-source_img', '==', '1'),
        ),
        array(
            'id'    => 'wc_cart_trust_badget-image_width',
            'type'  => 'slider',
            'title' => esc_html__( 'Width image', 'kalles' ),
            'choices' => array(
              'min'  => 40,
              'max'  => 100,
              'step' => 1,
              'unit' => '%',
            ),
            'default' => 60,
            'dependency' => array('wc_cart_trust_badget-source_img', '==', '1'),
        ),
        array(
          'id'            => 'wc_cart_trust_badget-svg-list',
          'type'          => 'textarea',
          'title'         => esc_html__('SVG list', 'kalles'),
          'desc'        => 'amazon_payments,american_express,apple_pay,bitcoin,dankort,diners_club,discover,dogecoin,dwolla,forbrugsforeningen,in terac,google_pay,jcb,klarna,litecoin,maestro,master,paypal,shopify_pay,sofort,visa',
          'default' => 'amazon_payments,american_express,apple_pay,bitcoin,dankort',
          'dependency' => array('wc_cart_trust_badget-source_img', '==', '2'),
        ),
        array(
            'id'    => 'wc_cart_trust_badget-svg-width',
            'type'  => 'slider',
            'title' => esc_html__( 'SVG Width', 'kalles' ),
            'choices' => array(
              'min'  => 40,
              'max'  => 100,
              'step' => 1,
              'unit' => 'px',
            ),
            'default' => 68,
            'dependency' => array('wc_cart_trust_badget-source_img', '==', '2'),
        ),
        array(
            'id'    => 'wc_cart_trust_badget-svg-height',
            'type'  => 'slider',
            'title' => esc_html__( 'SVG Height', 'kalles' ),
            'choices' => array(
              'min'  => 40,
              'max'  => 100,
              'step' => 1,
              'unit' => 'px',
            ),
            'default' => 50,
            'dependency' => array('wc_cart_trust_badget-source_img', '==', '2'),
        ),
    )
  ) );
// Product coundown
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_coundown',
    'title'       => esc_html__( 'Countdown Timer', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Countdown Timer Product page', 'kalles' ),
          ),
          array(
            'type'    => 'submessage',
            'style'    => 'info',
            'content' => esc_html__( 'Setup sale schedule in product page first. Only work with product type simple', 'kalles' ),
          ),
          array(
            'id'      => 'wc_product_coundown-enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Countdown Timer Product page', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'          => 'wc_product_coundown-type',
            'type'        => 'select',
            'title'       => esc_html__( 'ICON / IMG', 'kalles' ),
            'options'     => array(
              '1'     => esc_html__( 'None', 'kalles' ),
              '2'     => esc_html__( 'ICON', 'kalles' ),
              '3'     => esc_html__( 'Image', 'kalles' ),
            ),
            'default'        => '2'
        ),
        array(
          'id'         => 'wc_product_coundown-image',
          'type'       => 'media',
          'desc'       => '25x25 recommend',
          'title'      => esc_html__( 'Images', 'kalles' ),
          'url'        => false,
          'dependency' => array('wc_product_coundown-type', '==', '3'),
        ),
        array(
	      'id'            => 'wc_product_coundown-icon',
	      'type'          => 'icon',
	      'default'       => 'fas fa-stopwatch',
	      'title'         => esc_html__('Icon name', 'kalles'),
	      'dependency' => array('wc_product_coundown-type', '==', '2'),
        ),
	     array(
	      'id'            => 'wc_product_coundown-text',
	      'type'          => 'text',
	      'default'         => esc_html__('Hurry up! sale end in', 'kalles'),
	      'title'         => esc_html__('Message', 'kalles'),
        ),
        array(
            'id'          => 'wc_product_coundown-itext_align',
            'type'        => 'select',
            'title'       => esc_html__( 'Text align', 'kalles' ),
            'options'     => array(
              'tl'     => esc_html__( 'Text Left', 'kalles' ),
              'tc'     => esc_html__( 'Text Center', 'kalles' ),
              'tr'     => esc_html__( 'Text Right', 'kalles' ),
            ),
            'default'        => 'tc'
        ),
        array(
            'id'    => 'wc_product_coundown-text_font_size',
            'type'  => 'slider',
            'title' => esc_html__( 'Font size', 'kalles' ),
            'choices' => array(
              'min'  => 14,
              'max'  => 50,
              'step' => 1,
              'unit' => 'px',
            ),
            'default' => 16,
        ),
        array(
	      'id'            => 'wc_product_coundown-fade',
	      'type'          => 'switcher',
	      'default'       => true,
	      'label'       => esc_html__('Use fade animation?', 'kalles'),
	      'title'         => esc_html__('Animation', 'kalles'),
        ),
        array(
            'id'          => 'wc_product_coundown-design',
            'type'        => 'select',
            'title'       => esc_html__( 'Countdown Design', 'kalles' ),
            'options'     => array(
              'light'     => esc_html__( 'Light', 'kalles' ),
              'dark'     => esc_html__( 'Dark', 'kalles' ),
              'dark_2'     => esc_html__( 'Dark 2', 'kalles' ),
              'dark_3'     => esc_html__( 'Dark 3', 'kalles' ),
            ),
            'default'        => 'dark'
        ),

    )
  ) );

// Product Meta
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_meta',
    'title'       => esc_html__( 'Product Meta', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Product meta', 'kalles' ),
          ),
          array(
            'id'      => 'wc_product_meta-check',
            'type'    => 'checkbox',
            'title'   => esc_html__( 'Setting', 'kalles' ),
            'options' => array(
            	'sku' => esc_html__( 'Show SKU?', 'kalles' ),
            	'category' => esc_html__( 'Show Category product?', 'kalles' ),
            	'tags' => esc_html__( 'Show product\'s tags?', 'kalles' ),
            )
          ),
          array(
	        'title' => esc_html__( 'Extra Content','kalles'),
	        'id'    => 'wc-extra-content',
	        'type'  => 'wp_editor',
	        'desc'  => esc_html__( 'This text will be displayed right below add to cart button, HTML allowed.', 'kalles' )
	      ),
     )
  ));

// Live view
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_liveview',
    'title'       => esc_html__( 'Live View', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Product live View', 'kalles' ),
          ),
          array(
            'type'    => 'submessage',
            'style'    => 'warning',
            'content' => esc_html__( 'Display fake the number of people viewing your product page.', 'kalles' ),
          ),
          array(
			'id'      => 'wc_product_liveview-enable',
			'type'    => 'switcher',
			'default' => true,
			'title'   => esc_html__( 'Enable', 'kalles' ),

          ), 
          array(
            'id'          => 'wc_product_liveview-type',
            'type'        => 'select',
            'title'       => esc_html__( 'ICON / IMG', 'kalles' ),
            'options'     => array(
              '1'     => esc_html__( 'None', 'kalles' ),
              '2'     => esc_html__( 'ICON', 'kalles' ),
              '3'     => esc_html__( 'Image', 'kalles' ),
            ),
            'default'        => '2'
        ),
        array(
          'id'         => 'wc_product_liveview-image',
          'type'       => 'media',
          'desc'       => '25x25 recommend',
          'title'      => esc_html__( 'Images', 'kalles' ),
          'url'        => false,
          'dependency' => array('wc_product_liveview-type', '==', '3'),
        ),
        array(
	      'id'            => 'wc_product_liveview-icon',
	      'type'          => 'icon',
	      'default'       => 'fas fa-bullseye',
        'title'         => esc_html__('Icon name', 'kalles'),
	      'dependency' => array('wc_product_liveview-type', '==', '2'),
        ),
        array(
	      'id'            => 'wc_product_liveview-fade',
	      'type'          => 'switcher',
	      'default'       => true,
	      'label'       => esc_html__('Use fade animation?', 'kalles'),
	      'title'         => esc_html__('Animation', 'kalles'),
        ),
        array(
            'id'    => 'wc_product_liveview-min',
            'type'  => 'slider',
            'title' => esc_html__( 'Min fake real time Visitor', 'kalles' ),
              'min'  => 1,
              'max'  => 100,
              'step' => 1,
            'default' => 16,
        ),
        array(
            'id'    => 'wc_product_liveview-max',
            'type'  => 'slider',
            'title' => esc_html__( 'Max fake real time Visitor', 'kalles' ),
            'min'  => 20,
            'max'  => 1000,
            'step' => 1,
            'default' => 200,
        ),
        array(
            'id'    => 'wc_product_liveview-interval',
            'type'  => 'slider',
            'title' => esc_html__( 'Interval time', 'kalles' ),
              'min'  => 1,
              'max'  => 20,
              'step' => 1,
            'default' => 3,
        ),
        array(
	      'id'            => 'wc_product_liveview-text',
	      'type'          => 'textarea',
	      'default'       => '[count] <span class="cd fwm">People</span> are viewing this right now',
	      'title'         => esc_html__('Text', 'kalles'),
        ),
     )
  ));

// Flash sale
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_flash_sale',
    'title'       => esc_html__( 'Total sold flash', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Total sold flash', 'kalles' ),
          ),
          array(
			'id'      => 'wc_product_flash_sale-enable',
			'type'    => 'switcher',
			'default' => true,
			'title'   => esc_html__( 'Enable', 'kalles' ),

          ), 
          array(
            'id'          => 'wc_product_flash_sale-type',
            'type'        => 'select',
            'title'       => esc_html__( 'ICON / IMG', 'kalles' ),
            'options'     => array(
              '1'     => esc_html__( 'None', 'kalles' ),
              '2'     => esc_html__( 'ICON', 'kalles' ),
              '3'     => esc_html__( 'Image', 'kalles' ),
            ),
            'default'        => '2'
        ),
        array(
          'id'         => 'wc_product_flash_sale-image',
          'type'       => 'media',
          'desc'       => '25x25 recommend',
          'title'      => esc_html__( 'Images', 'kalles' ),
          'url'        => false,
          'dependency' => array('wc_product_flash_sale-type', '==', '3'),
        ),
        array(
	      'id'            => 'wc_product_flash_sale-icon',
	      'type'          => 'icon',
	      'default'       => 'fab fa-gripfire',
	      'title'         => esc_html__('Icon name', 'kalles'),
	      'dependency' => array('wc_product_flash_sale-type', '==', '2'),
        ),
        array(
	      'id'            => 'wc_product_flash_sale-fade',
	      'type'          => 'switcher',
	      'default'       => true,
	      'label'       => esc_html__('Use fade animation?', 'kalles'),
	      'title'         => esc_html__('Animation', 'kalles'),
        ),
        array(
            'id'    => 'wc_product_flash_sale-min_qty',
            'type'  => 'slider',
            'title' => esc_html__( 'Min Quantity', 'kalles' ),
             'min'  => 1,
             'max'  => 100,
             'step' => 1,
             'unit' => 'qty',
            'default' => 16,
        ),
        array(
            'id'    => 'wc_product_flash_sale-max_qty',
            'type'  => 'slider',
            'title' => esc_html__( 'Max Quantity', 'kalles' ),
            'min'  => 20,
            'max'  => 120,
            'step' => 1,
            'unit' => 'qty',
            'default' => 50,
        ),
        array(
            'id'    => 'wc_product_flash_sale-min_time',
            'type'  => 'slider',
            'title' => esc_html__( 'Min Time', 'kalles' ),
             'min'  => 1,
             'max'  => 24,
             'step' => 1,
             'unit' => 'h',
            'default' => 5,
        ),
        array(
            'id'    => 'wc_product_flash_sale-max_time',
            'type'  => 'slider',
            'title' => esc_html__( 'Max Time', 'kalles' ),
            'min'  => 1,
            'max'  => 24,
            'step' => 1,
            'unit' => 'h',
            'default' => 10,
        ),
        array(
	      'id'            => 'wc_product_flash_sale-text',
	      'type'          => 'textarea',
	      'default'       => '[sold] sold in last [hour] hours',
	      'title'         => esc_html__('Text', 'kalles'),
        ),
     )
  ));

// Delivery time
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_delivery_time',
    'title'       => esc_html__( 'Delivery Time', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Delivery Time', 'kalles' ),
          ),
          array(
            'type'    => 'submessage',
            'style'    => 'info',
            'content' => esc_html__( 'Display an approximate date of delivery.', 'kalles' ),
          ),
          array(
			'id'      => 'wc_product_delivery_time-enable',
			'type'    => 'switcher',
			'default' => true,
			'title'   => esc_html__( 'Enable', 'kalles' ),

          ), 
          array(
            'id'          => 'wc_product_delivery_time-type',
            'type'        => 'select',
            'title'       => esc_html__( 'ICON / IMG', 'kalles' ),
            'options'     => array(
              '1'     => esc_html__( 'None', 'kalles' ),
              '2'     => esc_html__( 'ICON', 'kalles' ),
              '3'     => esc_html__( 'Image', 'kalles' ),
            ),
            'default'        => '2'
        ),
        array(
          'id'         => 'wc_product_delivery_time-image',
          'type'       => 'media',
          'desc'       => '25x25 recommend',
          'title'      => esc_html__( 'Images', 'kalles' ),
          'url'        => false,
          'dependency' => array('wc_product_delivery_time-type', '==', '3'),
        ),
        array(
	      'id'            => 'wc_product_delivery_time-icon',
	      'type'          => 'icon',
	      'default'       => 'fas fa-shipping-fast',
	      'title'         => esc_html__('Icon name', 'kalles'),
	      'dependency' => array('wc_product_delivery_time-type', '==', '2'),
        ),
        array(
	      'id'            => 'wc_product_delivery_time-fade',
	      'type'          => 'switcher',
	      'default'       => true,
	      'label'       => esc_html__('Use fade animation?', 'kalles'),
	      'title'         => esc_html__('Animation', 'kalles'),
        ),
        array(
	      'id'            => 'wc_product_delivery_time-text',
	      'type'          => 'textarea',
	      'default'       => 'Order in the next [hour] to get it between [date_start] and [date_end]',
	      'title'         => esc_html__('Text', 'kalles'),
	      'desc'         => esc_html__('Order in the next [hour] to get this to you between [date_start] and [date_end], Order in the next [hour] to get it by [date_end], Order in the next [hour] to get it soon', 'kalles'),
        ),
        array(
            'id'    => 'wc_product_delivery_time-start_date',
            'type'  => 'slider',
            'title' => esc_html__( 'Delivery Start Date', 'kalles' ),
            'desc' => esc_html__( 'From Current date', 'kalles' ),
             'min'  => 0,
             'max'  => 99,
             'step' => 1,
             'unit' => 'day',
            'default' => 3,
        ),
        array(
            'id'    => 'wc_product_delivery_time-end_date',
            'type'  => 'slider',
            'title' => esc_html__( 'Delivery End Date', 'kalles' ),
            'desc' => esc_html__( 'From Current date', 'kalles' ),
            'min'  => 0,
            'max'  => 99,
            'step' => 1,
            'unit' => 'day',
            'default' => 15,
        ),
        array(
			'id'       => 'wc_product_delivery_time-mode',
			'type'     => 'button_set',
			'title'    => 'Exclude Days From',
			'multiple' => false,
			'options'  => array(
			'1'   => 'Only Delivery',
		    '2'   => 'Shipping + Delivery',
			),
			'default'  =>array( '1' ) 
		),
		array(
	      'id'            => 'wc_product_delivery_time-exc_days',
	      'type'          => 'text',
	      'default'       => 'SAT,SUN',
	      'title'         => esc_html__('Exclude Days', 'kalles'),
	      'desc'         => esc_html__('Use the \'MON\',\'TUE\',\'WED\',\'THU\',\'FRI\',\'SAT\' and \'SUN\'. Separate exclude days with a comma (,).', 'kalles'),
        ),
        array(
			'id'       => 'wc_product_delivery_time-date_format',
			'type'     => 'select',
			'title'    => 'Exclude Days From',
			'options'  => array(
				'1'  => 'Wednesday, 19th April',
				'2'  => 'Wednesday, 19th April 2019',
				'3'  => 'Wednesday, 19th April, 2019',
				'4'  => 'Wednesday, April 19th, 2019',
				'5'  => 'Wednesday, April 19th',
				'6'  => 'Wednesday, April 19th 2019',
				'7'  => 'Wednesday, April 19',
				'8'  => 'Wednesday, April 19 2019',
				'9'  => 'Wednesday, 04/19/2019',
				'10' => 'Wednesday, 19/04/2019',
				'20' => 'Wednesday, 2019/04/19',
			),
			'default'  =>''
		),
		array(
	      'id'            => 'wc_product_delivery_time-cut_off',
	      'type'          => 'text',
	      'default'       => '16:00:00',
	      'title'         => esc_html__('Delivery Cut Off', 'kalles'),
	      'desc'         => esc_html__('Number Only(24 Hours Format - 16:00:00 Means 4PM)', 'kalles'),
        ),
     )
  ));

// Inventory Quantity
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_inventory_qty',
    'title'       => esc_html__( 'Inventory Quantity', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Inventory Quantity', 'kalles' ),
      ),
      array(
        'id'      => 'wc_product_inventory_availability',
        'type'    => 'switcher',
        'default' => false,
        'title'   => esc_html__( 'Disable availability ?', 'kalles' ),
      ),
      array(
        'type'    => 'subheading',
        'content' => esc_html__( 'Quantity left progress bar', 'kalles' ),
      ),
      array(
        'type'    => 'submessage',
        'style'    => 'info',
        'content' => esc_html__( 'Display the stock level of your product variant.', 'kalles' ),
      ),
      array(
			'id'      => 'wc_product_inventory_qty-enable',
			'type'    => 'switcher',
			'default' => true,
			'title'   => esc_html__( 'Enable', 'kalles' ),

          ), 
          array(
            'id'          => 'wc_product_inventory_qty-type',
            'type'        => 'select',
            'title'       => esc_html__( 'ICON / IMG', 'kalles' ),
            'options'     => array(
              '1'     => esc_html__( 'None', 'kalles' ),
              '2'     => esc_html__( 'ICON', 'kalles' ),
              '3'     => esc_html__( 'Image', 'kalles' ),
            ),
            'default'        => '2'
        ),
        array(
          'id'         => 'wc_product_inventory_qty-image',
          'type'       => 'media',
          'desc'       => '25x25 recommend',
          'title'      => esc_html__( 'Images', 'kalles' ),
          'url'        => false,
          'dependency' => array('wc_product_inventory_qty-type', '==', '3'),
        ),
        array(
	      'id'            => 'wc_product_inventory_qty-icon',
	      'type'          => 'icon',
	      'default'       => 'far fa-hourglass',
	      'title'         => esc_html__('Icon name', 'kalles'),
	      'dependency' => array('wc_product_inventory_qty-type', '==', '2'),
        ),
        array(
	      'id'            => 'wc_product_inventory_qty-fade',
	      'type'          => 'checkbox',
	      'default'       => true,
	      'label'       => esc_html__('Use fade animation?', 'kalles'),
	      'title'         => esc_html__('Animation', 'kalles'),
        ),
        array(
			'id'       => 'wc_product_inventory_qty-mode',
			'type'     => 'button_set',
			'title'    => '== Stock',
      'desc'     => 'Only defaut & Default + Random apply for Simple product only',
			'multiple' => false,
			'options'  => array(
			  '1'   => 'Only default',
		    '2'   => 'Only random',
		    '3'   => 'Default + Random',
			),
			'default'  =>array( '3' ) 
		),
        array(
            'id'    => 'wc_product_inventory_qty-qty',
            'type'  => 'slider',
            'title' => esc_html__( '(X) items', 'kalles' ),
            'desc' => esc_html__( 'Show when less than (X) items are in stock', 'kalles' ),
            'min'  => 1,
            'max'  => 100,
            'step' => 1,
            'unit' => 'Qty',
            'default' => 10,
            'dependency' => array('wc_product_inventory_qty-mode', '!=', '2'),
        ),
        array(
            'id'    => 'wc_product_inventory_qty-total_items',
            'type'  => 'slider',
            'title' => esc_html__( 'Total items', 'kalles' ),
            'min'  => 10,
            'max'  => 100,
            'step' => 10,
            'default' => 100,
            'dependency' => array('wc_product_inventory_qty-mode', '!=', '1'),
        ),
        array(
            'id'    => 'wc_product_inventory_qty-stock_from',
            'type'  => 'slider',
            'title' => esc_html__( 'Stock From', 'kalles' ),
            'min'  => 1,
            'max'  => 19,
            'step' => 1,
            'default' => 12,
            'dependency' => array('wc_product_inventory_qty-mode', '!=', '1'),
        ),
        array(
            'id'    => 'wc_product_inventory_qty-stock_to',
            'type'  => 'slider',
            'title' => esc_html__( 'Stock To', 'kalles' ),
            'min'  => 20,
            'max'  => 70,
            'step' => 1,
            'default' => 20,
            'dependency' => array('wc_product_inventory_qty-mode', '!=', '1'),
        ),
        array(
            'id'          => 'wc_product_inventory_qty-text_align',
            'type'        => 'button_set',
            'title'       => esc_html__( 'Text Align', 'kalles' ),
            'options'     => array(
              'tl'     => esc_html__( 'Left', 'kalles' ),
              'tc'     => esc_html__( 'Center', 'kalles' ),
              'tr'     => esc_html__( 'Right', 'kalles' ),
            ),
            'default'        => 'tc',
        ),
        array(
	      'id'            => 'wc_product_inventory_qty-text',
	      'type'          => 'textarea',
	      'default'       => 'HURRY! ONLY [stock_number] LEFT IN STOCK.',
	      'title'         => esc_html__('Message', 'kalles'),
	      'desc'         => esc_html__('Hurry! Only [stock_number] left in stock.', 'kalles'),
        ),
        array(
            'id'    => 'wc_product_inventory_qty-text_font_size',
            'type'  => 'slider',
            'title' => esc_html__( 'Font size', 'kalles' ),
            'choices' => array(
              'min'  => 14,
              'max'  => 50,
              'step' => 1,
              'unit' => 'px',
            ),
            'default' => 16,
        ),
        array(
            'id'      => 'wc_product_inventory_qty-check',
            'type'    => 'checkbox',
            'title'   => esc_html__( 'Progress bar', 'kalles' ),
            'options' => array(
            	'progress' => esc_html__( 'Show Progress bar?', 'kalles' ),
            	'reduce' => esc_html__( 'Enable gradually reduce the amount of inventory?', 'kalles' ),
            ),
            'default'    => array( 'progress', 'reduce' )
         ),
        array(
            'id'    => 'wc_product_inventory_qty-wbar',
            'type'  => 'slider',
            'title' => esc_html__( 'Width progress bar', 'kalles' ),
            'choices' => array(
              'min'  => 40,
              'max'  => 100,
              'step' => 1,
              'unit' => '%',
            ),
            'default' => 100,
        ),
        
		array(
	      'id'            => 'wc_product_inventory_qty-process_color',
	      'type'          => 'color',
	      'default'       => '#F76B6A',
	      'title'         => esc_html__('Process color', 'kalles'),
        ),
        array(
	      'id'            => 'wc_product_inventory_qty-lessthan_color',
	      'type'          => 'color',
	      'default'       => '#EC0101',
	      'title'         => esc_html__('Process color', 'kalles'),
        ), 
        array(
	      'id'            => 'wc_product_inventory_qty-bg_color',
	      'type'          => 'color',
	      'default'       => '#FFE8E8',
	      'title'         => esc_html__('Process color', 'kalles'),
        ),
        
     )
  ));

// Inventory Quantity
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_viewer',
    'title'       => esc_html__( 'Recent Viewer', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Recent Viewer', 'kalles' ),
      ),
      array(
        'type'    => 'submessage',
        'style'    => 'info',
        'content' => esc_html__( 'Display recent viewer product by Customer or Guest.', 'kalles' ),
      ),
      array(
      'id'      => 'wc_product_viewer-enable',
      'type'    => 'switcher',
      'default' => false,
      'title'   => esc_html__( 'Enable', 'kalles' ),
      ), 
      array(
      'id'      => 'wc_product_viewer-title',
      'type'    => 'text',
      'default' => esc_html__( 'Recent Viewer', 'kalles' ),
      'title'   => esc_html__( 'Heading', 'kalles' ),
      ), 
      array(
      'id'         => 'wc_product_viewer-subtext',
      'type'       => 'text',
      'title'      => esc_html__( 'Sub Text', 'kalles' ),
      'default'    => '',
    ),
    array(
      'id'         => 'wc_product_viewer-title_design',
      'type'       => 'select',
      'default'    => 'title_3',
      'title'      => esc_html__( 'Design Title', 'kalles' ),
      'options'    => array(
          'title_1'  => esc_html__( 'Design 1', 'kalles' ),
          'title_2'  => esc_html__( 'Design 2', 'kalles' ),
          'title_3'  => esc_html__( 'Design 3', 'kalles' ),
          'title_4'  => esc_html__( 'Design 4', 'kalles' ),
          'title_5'  => esc_html__( 'Design 5', 'kalles' ),
          'title_6'  => esc_html__( 'Design 6', 'kalles' ),
          'title_8'  => esc_html__( 'Design 7', 'kalles' ),
          'title_9'  => esc_html__( 'Design 8', 'kalles' ),
          'title_11' => esc_html__( 'Design 9', 'kalles' ),
          'title_12' => esc_html__( 'Design 10', 'kalles' ),
          'title_13' => esc_html__( 'Design 11', 'kalles' ),
      ),
    ),
    array(
      'id'      => 'wc_product_viewer-cookie_time',
      'type'    => 'slider',
      'title'   => esc_html__( 'No of Days Cookie to be stored', 'kalles' ),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 30,
    ),
    array(
      'id'      => 'wc_product_viewer-product_no',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products to view', 'kalles' ),
      'min'     => 1,
      'max'     => 20,
      'step'    => 1,
      'default' => 8,
    ),
    array(
      'id'      => 'wc_product_viewer-product_no_slider',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products per slide', 'kalles' ),
      'min'     => 3,
      'max'     => 6,
      'step'    => 1,
      'default' => 4,
    ),
    array(
    'id'      => 'wc_product_viewer-customer',
    'type'    => 'switcher',
    'default' => false,
    'title'   => esc_html__( 'Enable recent viewer by Customer', 'kalles' ),
    'desc'    => esc_html__( 'Enable for recent viewer by Customer, default recent viewer by Cookie websie', 'kalles' ),
    ), 
  )
));

// Product Upsell
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_upsell',
    'title'       => esc_html__( 'Upsell', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Upcell Product', 'kalles' ),
      ),
      array(
      'id'      => 'wc_product_upsell-enable',
      'type'    => 'switcher',
      'default' => false,
      'title'   => esc_html__( 'Enable', 'kalles' ),
      ), 
      array(
      'id'      => 'wc_product_upsell-title',
      'type'    => 'text',
      'default' => esc_html__( 'YOU MAY ALSO LIKE', 'kalles' ),
      'title'   => esc_html__( 'Heading', 'kalles' ),
      ), 
      array(
      'id'         => 'wc_product_upsell-subtext',
      'type'       => 'text',
      'title'      => esc_html__( 'Sub Text', 'kalles' ),
      'default'    => '',
    ),
    array(
      'id'         => 'wc_product_upsell-title_design',
      'type'       => 'select',
      'default'    => 'title_3',
      'title'      => esc_html__( 'Design Title', 'kalles' ),
      'options'    => array(
          'title_1'  => esc_html__( 'Design 1', 'kalles' ),
          'title_2'  => esc_html__( 'Design 2', 'kalles' ),
          'title_3'  => esc_html__( 'Design 3', 'kalles' ),
          'title_4'  => esc_html__( 'Design 4', 'kalles' ),
          'title_5'  => esc_html__( 'Design 5', 'kalles' ),
          'title_6'  => esc_html__( 'Design 6', 'kalles' ),
          'title_8'  => esc_html__( 'Design 7', 'kalles' ),
          'title_9'  => esc_html__( 'Design 8', 'kalles' ),
          'title_11' => esc_html__( 'Design 9', 'kalles' ),
          'title_12' => esc_html__( 'Design 10', 'kalles' ),
          'title_13' => esc_html__( 'Design 11', 'kalles' ),
      ),
    ),
    array(
      'id'      => 'wc_product_upsell-product_no',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products to view', 'kalles' ),
      'min'     => 1,
      'max'     => 20,
      'step'    => 1,
      'default' => 8,
    ),
    array(
      'id'      => 'wc_product_upsell-product_no_slider',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products per slide', 'kalles' ),
      'min'     => 3,
      'max'     => 6,
      'step'    => 1,
      'default' => 4,
    ),
  )
));

// Product Cross-sell
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-product',
    'id'          => 'wc_product_cross_sell',
    'title'       => esc_html__( 'Related product', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Related Product', 'kalles' ),
      ),
      array(
      'id'      => 'wc_product_cross_sell-enable',
      'type'    => 'switcher',
      'default' => false,
      'title'   => esc_html__( 'Enable', 'kalles' ),
      ), 
      array(
      'id'      => 'wc_product_cross_sell-title',
      'type'    => 'text',
      'default' => esc_html__( 'RELATED PRODUCTS', 'kalles' ),
      'title'   => esc_html__( 'Heading', 'kalles' ),
      ), 
      array(
      'id'         => 'wc_product_cross_sell-subtext',
      'type'       => 'text',
      'title'      => esc_html__( 'Sub Text', 'kalles' ),
      'default'    => '',
    ),
    array(
      'id'         => 'wc_product_cross_sell-title_design',
      'type'       => 'select',
      'default'    => 'title_3',
      'title'      => esc_html__( 'Design Title', 'kalles' ),
      'options'    => array(
          'title_1'  => esc_html__( 'Design 1', 'kalles' ),
          'title_2'  => esc_html__( 'Design 2', 'kalles' ),
          'title_3'  => esc_html__( 'Design 3', 'kalles' ),
          'title_4'  => esc_html__( 'Design 4', 'kalles' ),
          'title_5'  => esc_html__( 'Design 5', 'kalles' ),
          'title_6'  => esc_html__( 'Design 6', 'kalles' ),
          'title_8'  => esc_html__( 'Design 7', 'kalles' ),
          'title_9'  => esc_html__( 'Design 8', 'kalles' ),
          'title_11' => esc_html__( 'Design 9', 'kalles' ),
          'title_12' => esc_html__( 'Design 10', 'kalles' ),
          'title_13' => esc_html__( 'Design 11', 'kalles' ),
      ),
    ),
    array(
      'id'      => 'wc_product_cross_sell-product_no',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products to view', 'kalles' ),
      'min'     => 1,
      'max'     => 20,
      'step'    => 1,
      'default' => 8,
    ),
    array(
      'id'      => 'wc_product_cross_sell-product_no_slider',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products per slide', 'kalles' ),
      'min'     => 3,
      'max'     => 6,
      'step'    => 1,
      'default' => 4,
    ),
  )
));
