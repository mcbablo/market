<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */

// Woocommerce Cart & Checkout page Config

CSF::createSection( $prefix, array(
    'id'    => 'woocommerce-cart-checkout',
    'title' => esc_html__( 'Cart & Checkout', 'kalles' ),
    'icon'  => 'fas fa-shopping-basket',
    ) );
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-cart-checkout',
    'id'          => 'wc_cart_setting',
    'title'       => esc_html__( 'Cart Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Cart Setting', 'kalles' ),
          ),
          array(
            'id'          => 'wc-cart-minimum_item',
            'type'        => 'select',
            'title'       => esc_html__( 'Min quantity cart', 'kalles' ),
            'desc'        => esc_html__( 'Minimum quantity value in cart page/cart sidebar. For example, if you set the value to 1, the user cannot reduce it to 0.', 'kalles' ),
            'options'     => array(
              '0'     => '0',
              '1'     => '1',
            ),
          ),
          array(
            'id'         => 'wc-atc-behavior',
            'type'       => 'select',
            'title'      => esc_html__( 'Action when an item is added to the cart', 'kalles' ),
            'options' => array(
              'slide' => esc_html__( 'Show hidden Dropdown/Sidebar', 'kalles' ),
              'popup' => esc_html__( 'Popup included upsell products', 'kalles' ),
              'do_nothing' => esc_html__( 'No action, stay on current page', 'kalles' ),
            ),
            'default' => 'slide'
          ),
          array(
            'id'      => 'wc_cart_popup_upsell',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable upsell product on popup', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'    => 'wc-cart-content',
            'title' => esc_html__( 'Cart Content', 'kalles' ),
            'type'  => 'textarea',
            'desc'  => esc_html__( 'This text will be displayed right below cart total, HTML allowed.', 'kalles' )
          ),
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Cart Page', 'kalles' ),
          ),
          array(
            'id'      => 'wc-cart_progress',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Cart Progress', 'kalles' ),
            'default' => true,
          ),
          array(
            'type'    => 'subheading',
            'content' => esc_html__( 'Trust Badge', 'kalles' ),
          ),
          array(
            'id'      => 'cart_checkout_trust_badget-enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Trust Badge', 'kalles' ),
            'default' => true,
          ),
          array(
          'id'            => 'cart_checkout_trust_badget-text',
          'type'          => 'wp_editor',
          'title'         => esc_html__('Message', 'kalles'),
          'height'        => '100px',
          'media_buttons' => false,
        ),
        array(
            'id'          => 'cart_checkout_trust_badget-source_img',
            'type'        => 'select',
            'title'       => esc_html__( 'Source IMG', 'kalles' ),
            'options'     => array(
              '1'     => 'Image',
              '2'     => 'SVG',
            ),
        ),
        array(
          'id'         => 'cart_checkout_trust_badget-image',
          'type'       => 'media',
          'title'      => esc_html__( 'Trust seal image', 'kalles' ),
          'url'        => false,
          'dependency' => array('cart_checkout_trust_badget-source_img', '==', '1'),
        ),
        array(
            'id'          => 'cart_checkout_trust_badget-image_align',
            'type'        => 'select',
            'title'       => esc_html__( 'IMG Alignment', 'kalles' ),
            'options'     => array(
              'tl'     => esc_html__( 'Left', 'kalles' ),
              'tc'     => esc_html__( 'Center', 'kalles' ),
              'tr'     => esc_html__( 'Right', 'kalles' ),
            ),
            'dependency' => array('cart_checkout_trust_badget-source_img', '==', '1'),
        ),
        array(
            'id'    => 'cart_checkout_trust_badget-image_width',
            'type'  => 'slider',
            'title' => esc_html__( 'Width image', 'kalles' ),
            'choices' => array(
              'min'  => 40,
              'max'  => 100,
              'step' => 1,
              'unit' => '%',
            ),
            'default' => 60,
            'dependency' => array('cart_checkout_trust_badget-source_img', '==', '1'),
        ),
        array(
          'id'            => 'cart_checkout_trust_badget-svg-list',
          'type'          => 'textarea',
          'title'         => esc_html__('SVG list', 'kalles'),
          'desc'        => 'amazon_payments,american_express,apple_pay,bitcoin,dankort,diners_club,discover,dogecoin,dwolla,forbrugsforeningen,in terac,google_pay,jcb,klarna,litecoin,maestro,master,paypal,shopify_pay,sofort,visa',
          'default' => 'amazon_payments,american_express,apple_pay,bitcoin,dankort',
          'dependency' => array('cart_checkout_trust_badget-source_img', '==', '2'),
        ),
        array(
            'id'    => 'cart_checkout_trust_badget-svg-width',
            'type'  => 'slider',
            'title' => esc_html__( 'SVG Width', 'kalles' ),
            'choices' => array(
              'min'  => 40,
              'max'  => 100,
              'step' => 1,
              'unit' => 'px',
            ),
            'default' => 68,
            'dependency' => array('cart_checkout_trust_badget-source_img', '==', '2'),
        ),
        array(
            'id'    => 'cart_checkout_trust_badget-svg-height',
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
// Product Cross-sell
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-cart-checkout',
    'id'          => 'wc_cart_cross_sell',
    'title'       => esc_html__( 'Cross-sell', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
      array(
        'type'    => 'heading',
        'content' => esc_html__( 'Cross-sell Product', 'kalles' ),
      ),
      array(
      'id'      => 'wc_cart_cross_sell-enable',
      'type'    => 'switcher',
      'default' => true,
      'title'   => esc_html__( 'Enable', 'kalles' ),
      ), 
      array(
      'id'      => 'wc_cart_cross_sell-title',
      'type'    => 'text',
      'default' => esc_html__( 'You may be interested in…', 'kalles' ),
      'title'   => esc_html__( 'Heading', 'kalles' ),
      ), 
      array(
      'id'         => 'wc_cart_cross_sell-subtext',
      'type'       => 'text',
      'title'      => esc_html__( 'Sub Text', 'kalles' ),
      'default'    => '',
    ),
    array(
      'id'         => 'wc_cart_cross_sell-title_design',
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
          'title_7'  => esc_html__( 'Design 7 (width line-awesome)', 'kalles' ),
          'title_8'  => esc_html__( 'Design 8', 'kalles' ),
          'title_9'  => esc_html__( 'Design 9', 'kalles' ),
          'title_11' => esc_html__( 'Design 10', 'kalles' ),
          'title_12' => esc_html__( 'Design 11', 'kalles' ),
          'title_13' => esc_html__( 'Design 12', 'kalles' ),
      ),
    ),
    array(
      'id'         => 'wc_cart_cross_sell-style7_icon',
      'type'       => 'text',
      'title'      => esc_html__( 'Style 7 icon line-awesome', 'kalles' ),
      'default'    => esc_html__( 'gem', 'kalles' ),
      'desc'    => '<a href="https://icons8.com/line-awesome" target="_blank">'. esc_html__( 'Get icon Line awesome ', 'kalles' ).'</a>',
      'dependency' => array( 'wc_cart_viewer-title_design', '==', 'title_7' )
    ),
    array(
      'id'      => 'wc_cart_cross_sell-product_no',
      'type'    => 'slider',
      'title'   => esc_html__( 'Number of products to view', 'kalles' ),
      'min'     => 1,
      'max'     => 20,
      'step'    => 1,
      'default' => 8,
    ),
    array(
      'id'      => 'wc_cart_cross_sell-product_no_slider',
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
    'parent'      => 'woocommerce-cart-checkout',
    'id'          => 'wc_cart_shipping_bar',
    'title'       => esc_html__( 'Shipping sections', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
    array(
        'type'    => 'heading',
        'content' => esc_html__( 'Shipping sections', 'kalles' ),
    ),
    array(
        'id'      => 'wc_cart_shipping-enable',
        'type'    => 'switcher',
        'default' => true,
        'title'   => esc_html__( 'Enable', 'kalles' ),
    ),
    array(
      'id'        => 'wc_cart_shipping_items',
      'type'      => 'group',
      'title'     => 'Blocks',
      'fields'    => array(
        array(
          'id'    => 'wc_cart_shipping_item_heading',
          'type'  => 'text',
          'title' => 'Heading',
        ),
        array(
          'id'    => 'wc_cart_shipping_item_icon',
          'type'  => 'text',
          'title' => 'Icons name',
            'desc'    => '<a href="https://themes-pixeden.com/font-demos/7-stroke/index.html" target="_blank">'. esc_html__( 'Get icons Pe icon ', 'kalles' ).'</a>',

        ),
        
        array(
          'id'    => 'wc_cart_shipping_item_text',
          'type'  => 'text',
          'title' => 'Text',
        ),
      ),
      'default'   => array(
        array(
          'wc_cart_shipping_item_icon'    => 'pe-7s-car',
          'wc_cart_shipping_item_heading' => 'FREE SHIPPING',
          'wc_cart_shipping_item_text'    => 'Free shipping on all US order or order above $100',
        ),
        array(
          'wc_cart_shipping_item_icon'    => 'pe-7s-help2',
          'wc_cart_shipping_item_heading' => 'SUPPORT 24/7',
          'wc_cart_shipping_item_text'    => 'Contact us 24 hours a day, 7 days a week',
        ),
        array(
          'wc_cart_shipping_item_icon'    => 'pe-7s-refresh',
          'wc_cart_shipping_item_heading' => '30 DAYS RETURN',
          'wc_cart_shipping_item_text'    => 'Simply return it within 30 days for an exchange.',
        ),
        array(
          'wc_cart_shipping_item_icon'    => 'pe-7s-lock',
          'wc_cart_shipping_item_heading' => '100% PAYMENT SECURE',
          'wc_cart_shipping_item_text'    => 'We ensure secure payment with PEV',
        ),
      ),
    ),
    array(
        'type'    => 'heading',
        'content' => esc_html__( 'Settings', 'kalles' ),
    ),
    array(
        'id'         => 'wc_cart_shipping_icon_design',
        'type'       => 'button_set',
        'title'      => 'Icon Design',
        'options'    => array(
            'deafult'  => 'Deafult',
            'circle' => 'Circle',
            ),
        'default'    => 'deafult'
    ),
    array(
        'id'         => 'wc_cart_shipping_icon_align',
        'type'       => 'button_set',
        'title'      => 'Icon Alignment',
        'options'    => array(
            'tl' => 'Left',
            'tc' => 'Center',
            'tr' => 'Right',
            )    ,
        'default'    => 'tl'
    ),
    array(
        'id'         => 'wc_cart_shipping_icon_size',
        'type'       => 'button_set',
        'title'      => 'Icon Size',
        'options'    => array(
            'small' => 'Small',
            'medium' => 'Medium',
            'large' => 'Large',
            )    ,
        'default'    => 'medium'
    ),
    array(
       'id'    => 'wc_cart_shipping_icon_color',
       'type'  => 'color',
       'title' => 'Icon Color',
    ),
    array(
        'id'         => 'wc_cart_shipping_col_pr',
        'type'       => 'select',
        'title'      => 'Shipping columns',
        'options'    => array(
            '6' => '2',
            '4' => '3',
            '3' => '4',
            '15' => '5',
            '2' => '6',
        ),
        'default'    => '3'
    ),
    array(
        'id'         => 'wc_cart_shipping_col_pr_tb',
        'type'       => 'select',
        'title'      => 'Shipping columns Table',
        'options'    => array(
            '6' => '2',
            '4' => '3',
            '3' => '4',
        ),
        'default'    => '6'
    ),
    array(
        'id'         => 'wc_cart_shipping_col_mb',
        'type'       => 'select',
        'title'      => 'Shipping columns Moble',
        'options'    => array(
            'fl_wrap' => 'Default',
            'fl_nowrap' => 'Modern',
        ),
        'default'    => 'fl_wrap'
    ),
    array(
        'id'      => 'wc_cart_shipping_border',
        'type'    => 'switcher',
        'title'   => 'Box border',
        //'label'   => 'Use border',
        'default' => false
    ),
  )
));

// Product Cross-sell
CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-cart-checkout',
    'id'          => 'wc_cart_testimonial',
    'title'       => esc_html__( 'Testimonial', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
    array(
        'type'    => 'heading',
        'content' => esc_html__( 'Testimonial', 'kalles' ),
    ),
    array(
        'id'      => 'wc_cart_testimonial-enable',
        'type'    => 'switcher',
        'default' => true,
        'title'   => esc_html__( 'Enable', 'kalles' ),
    ),
    array(
      'id'        => 'wc_cart_testimonial_items',
      'type'      => 'group',
      'title'     => 'Blocks',
      'fields'    => array(
        array(
          'id'    => 'wc_cart_testimonial_item_name',
          'type'  => 'text',
          'title' => 'Author name',
        ),
        array(
          'id'      => 'wc_cart_testimonial_item_point',
          'type'    => 'slider',
          'default' => 5,
          'min'     => 0,
          'max'     => 5,
          'step'    => 0.5,
          'title'   => 'Point star',
        ),
        array(
          'id'    => 'wc_cart_testimonial_item_content',
          'type'  => 'textarea',
          'title' => 'Content',
        ),
        array(
          'id'    => 'wc_cart_testimonial_item_image',
          'type'  => 'media',
          'title' => 'Author picture',
          'library' => 'image',
          'url' => false,
        ),
      ),
      'default'   => array(
        array(
          'wc_cart_testimonial_item_name'    => 'Author name',
          'wc_cart_testimonial_item_point'    => 5,
          'wc_cart_testimonial_item_content'    => 'Add customer reviews and testimonials to showcase your store’s happy customers.',
          'wc_cart_testimonial_item_image'    => '',
        ),
        array(
          'wc_cart_testimonial_item_name'    => 'Author name',
          'wc_cart_testimonial_item_point'    => 5,
          'wc_cart_testimonial_item_content'    => 'Add customer reviews and testimonials to showcase your store’s happy customers.',
          'wc_cart_testimonial_item_image'    => '',
        ),
        array(
          'wc_cart_testimonial_item_name'    => 'Author name',
          'wc_cart_testimonial_item_point'    => 5,
          'wc_cart_testimonial_item_content'    => 'Add customer reviews and testimonials to showcase your store’s happy customers.',
          'wc_cart_testimonial_item_image'    => '',
        ),
      ),
    ),
    array(
        'type'    => 'heading',
        'content' => esc_html__( 'Settings', 'kalles' ),
    ),
    array(
        'id'         => 'wc_cart_testimonial_design',
        'type'       => 'select',
        'title'      => 'testimonial design',
        'options'    => array(
            '1' => 'Design 1',
            '2' => 'Design 2',
            '3' => 'Design 3',
            '4' => 'Design 4',
            '5' => 'Design 5',
            '6' => 'Design 6',
            '7' => 'Design 7',
        ),
        'default'    => '1'
    ),
    array(
        'type'    => 'subheading',
        'content' => esc_html__( 'Slider settings', 'kalles' ),
    ),
    array(
        'id'         => 'wc_cart_testimonial_sider-autoplay',
        'type'       => 'switcher',
        'title'      => 'Auto play',
        'default'    => true
    ),
    array(
        'id'         => 'wc_cart_testimonial_sider-nav',
        'type'       => 'switcher',
        'title'      => 'Display Next/Prev button',
        'default'    => true
    ),
    array(
        'id'         => 'wc_cart_testimonial_sider-dot',
        'type'       => 'switcher',
        'title'      => 'Display dot',
        'default'    => true
    ),
   
  )
));

CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-cart-checkout',
  'id'          => 'wc_cart_countdown',
  'title'       => esc_html__( 'Cart Countdown', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields' => array(
        array(
          'type'    => 'heading',
          'content' => esc_html__( 'Cart Countdown Setting', 'kalles' ),
        ),
        array(
          'id'      => 'wc_cart_countdown-enable',
          'title'   => esc_html__( 'Enable cart countdown', 'kalles' ),
          'type'    => 'switcher',
          'default' => false,
        ),
        array(
          'id'      => 'wc_cart_countdown-text',
          'title'   => esc_html__( 'Text', 'kalles' ),
          'type'    => 'text',
          'default' => 'Due To HIGH Demand, Cart Expires In:',
        ),
        array(
          'id'         => 'wc_cart_countdown-unit_time',
          'type'       => 'button_set',
          'title'      => 'Cart time countdown unit',
          'options'    => array(
              'hrs'  => 'Hours',
              'min' => 'Minutes',
              ),
          'default'    => 'min'
        ),
        array(
          'id'      => 'wc_cart_countdown-time',
          'type'    => 'slider',
          'default' => 60,
          'min'     => 0,
          'max'     => 100,
          'step'    => 1,
          'title'   => 'Cart time countdown (Minutes or Hours)',
        ),
        array(
           'id'    => 'wc_cart_countdown-bg',
           'type'  => 'color',
           'title' => 'Background color',
           'default' => '#fcb800',
        ),
        array(
           'id'    => 'wc_cart_countdown-text_color',
           'type'  => 'color',
           'title' => 'Text color',
           'default' => '#000000',
        ),
      )
) );

CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-cart-checkout',
    'id'          => 'wc_mini_cart_setting',
    'title'       => esc_html__( 'Mini Cart Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Shopping Cart Widget', 'kalles' ),
          ),
          array(
            'id'          => 'wc-cart-cart_type',
            'type'        => 'select',
            'title'       => esc_html__( 'Shopping cart position', 'kalles' ),
            'desc'        => esc_html__( 'Shopping cart widget may be placed in the header or as a sidebar.', 'kalles' ),
            'options'     => array(
              'disable'           => esc_html__( 'Disable', 'kalles' ),
              'sidebar'           => esc_html__( 'Hidden Sidebar', 'kalles' ),
              'cart_pos_dropdown' => esc_html__( 'Dropdown widget in header', 'kalles' ),
            ),
          ),
          array(
            'id'      => 'wc_mini_cart_setting-shipping_bar',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Shipping bar', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'      => 'wc_mini_cart_setting-shipping_amount',
            'type'    => 'number',
            'title'   => esc_html__( 'Minimum order amount', 'kalles' ),
            'default' => 100,
          ),
          array(
            'id'      => 'wc_mini_cart_freeship_text',
            'type'    => 'text',
            'title'   => esc_html__( 'Free Shipping text', 'kalles' ),
            'default' => 'Congratulations! You\'ve got free shipping!',
          ),
          array(
            'id'      => 'wc-giftwrap',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Gift Wrap', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'         => 'wc-giftwrap-product',
            'type'       => 'select',
            'placeholder' => 'Select a product',
            'title'      => esc_html__( 'Product Gift wrap', 'kalles' ),
            'chosen'      => true,
            'ajax'        => true,
            'options'     => 'posts',
            'query_args'  => array(
              'post_type' => 'product'
            ),
            // 'desc'  => esc_html__( 'Gift wrap needs to be set up as a product. Input product ID', 'kalles' ),
            'dependency' => array( 'wc-giftwrap', '==', true ),
          ),
          array(
            'id'      => 'wc-order_note',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Order Note', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'      => 'wc-estimate-shipping',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Estimate Shipping', 'kalles' ),
            'default' => true,
          ),

          array(
            'id'      => 'wc-coupon',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Coupon', 'kalles' ),
            'default' => true,
          ),
          
          array(
            'id'    => 'wc-minicart-content',
            'title' => esc_html__( 'MiniCart Content', 'kalles' ),
            'type'  => 'textarea',
            'desc'  => esc_html__( 'This text will be displayed right below checkout button, HTML allowed.', 'kalles' )
          ),
          
          array(
            'id'         => 'checkout_btn_viewcart_color_subtile',
            'type'       => 'subheading',
            'title'      => esc_html__( 'View cart button', 'kalles' ),
          ),
          array(
            'id'        => 'wc-checkout_btn_viewcart_color',
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
              'id'    => 'wc-summary_btn_viewcart_opacity',
              'type'  => 'slider',
              'title' => esc_html__( 'Opacity on hover', 'kalles' ),
              'min'  => 0.1,
              'max'  => 1,
              'step' => 0.1,
              'default' => 1
          ),
          array(
            'id'         => 'checkout_btn_checkout_color_subtile',
            'type'       => 'subheading',
            'title'      => esc_html__( 'Checkout button', 'kalles' ),
          ),
          array(
            'id'        => 'wc-checkout_btn_checkout_color',
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
              'id'    => 'wc-summary_btn_checkout_opacity',
              'type'  => 'slider',
              'title' => esc_html__( 'Opacity on hover', 'kalles' ),
              'min'  => 0.1,
              'max'  => 1,
              'step' => 0.1,
              'default' => 1
          ),
        )
  ) );

CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-cart-checkout',
  'id'          => 'wc_checkout_setting',
  'title'       => esc_html__( 'Checkout Settings', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields' => array(
        array(
          'type'    => 'heading',
          'content' => esc_html__( 'Checkout Setting', 'kalles' ),
        ),
        array(
          'id'          => 'wc-checkout-layout',
          'type'        => 'select',
          'title'       => esc_html__( 'Checkout Layout', 'kalles' ),
          'options'     => array(
              'layout_1'           => esc_html__( 'Layout 1', 'kalles' ),
              'layout_2'           => esc_html__( 'Layout 2', 'kalles' )
          ),
          'default' => 'layout_1'
        ),
        array(
          'id'    => 'wc-checkout-content',
          'title' => esc_html__( 'Checkout Content', 'kalles' ),
          'type'  => 'textarea',
          'desc'  => esc_html__( 'This text will be displayed right below checkout button, HTML allowed.', 'kalles' )
        ),
        array(
        'id'         => 'wc_checkout_setting-coupon_position',
        'type'       => 'button_set',
        'title'      => 'Coupon position',
        'options'    => array(
            'top'  => 'Top',
            'bottom' => 'Bottom',
            ),
        'default'    => 'top'
        ),
      )
) );

//Thank you page

CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-cart-checkout',
  'id'          => 'wc_checkout_thankyou',
  'title'       => esc_html__( 'Thank You Page', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields' => array(
        array(
          'type'    => 'heading',
          'content' => esc_html__( 'Thank You Page', 'kalles' ),
        ),
        array(
          'id'         => 'wc_checkout_thankyou_message',
          'type'       => 'text',
          'title'      => esc_html__( 'Thankyou message', 'kalles' ),
          'desc'      => esc_html__( '{first_name} show First name, {last_name} show Last name', 'kalles' ),
          'default'    => 'Thank you {first_name}, Order has been received !',
        ),
        array(
          'type'    => 'subheading',
          'content' => esc_html__( 'Recommended product', 'kalles' ),
        ),
        array(
        'id'      => 'wc_checkout_thankyou-enable',
        'type'    => 'switcher',
        'default' => false,
        'title'   => esc_html__( 'Enable', 'kalles' ),
        ), 
        array(
          'id'          => 'wc_checkout_thankyou-products',
          'type'        => 'select',
          'title'       => 'Select product',
          'placeholder' => 'Enter product name',
          'chosen'      => true,
          'multiple'    => true,
          'ajax'        => true,
          'options'     => 'posts',
          'query_args'  => array(
            'post_type' => 'product'
          )
        ),
        array(
          'id'         => 'wc_checkout_thankyou-category',
          'type'       => 'select',
          'title'      => esc_html__( 'Select category', 'kalles' ),
          'options'    => 'categories',
          'query_args' => array(
            'post_type'      => 'product',
            'taxonomy'       => 'product_cat',
            'orderby'        => 'post_title',
            'order'          => 'ASC',
            'posts_per_page' => -1,
          ),
        ),
        array(
        'id'      => 'wc_checkout_thankyou-title',
        'type'    => 'text',
        'default' => esc_html__( 'You alse like', 'kalles' ),
        'title'   => esc_html__( 'Heading', 'kalles' ),
        ), 
        array(
        'id'         => 'wc_checkout_thankyou-subtext',
        'type'       => 'text',
        'title'      => esc_html__( 'Sub Text', 'kalles' ),
        'default'    => '',
      ),
      array(
        'id'         => 'wc_checkout_thankyou-title_design',
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
        'id'      => 'wc_checkout_thankyou-product_no',
        'type'    => 'slider',
        'title'   => esc_html__( 'Number of products to view', 'kalles' ),
        'min'     => 1,
        'max'     => 20,
        'step'    => 1,
        'default' => 8,
      ),
      array(
        'id'      => 'wc_checkout_thankyou-product_no_slider',
        'type'    => 'slider',
        'title'   => esc_html__( 'Number of products per slide', 'kalles' ),
        'min'     => 3,
        'max'     => 6,
        'step'    => 1,
        'default' => 4,
      ),

      array(
          'type'    => 'subheading',
          'content' => esc_html__( 'Coupon', 'kalles' ),
        ),
      array(
        'id'      => 'wc_checkout_thankyou_coupon-enable',
        'type'    => 'switcher',
        'default' => false,
        'title'   => esc_html__( 'Enable', 'kalles' ),
        ), 
      array(
          'id'          => 'wc_checkout_thankyou_coupon-code',
          'type'        => 'select',
          'title'       => 'Select coupon code',
          'desc'       => 'You can create coupon <a href="">here</a>',
          'chosen'      => false,
          'multiple'    => false,
          'ajax'        => false,
          'options'     => 'posts',
          'query_args'  => array(
            'post_type' => 'shop_coupon'
          )
        ),
      array(
        'id'         => 'wc_checkout_thankyou_coupon-message',
        'type'       => 'text',
        'title'      => esc_html__( 'Message', 'kalles' ),
        'default'    => 'Congratulation! You have unlocked this {coupon_value} coupon code.',
      ),
        array(
        'id'      => 'wc_checkout_thankyou_coupon-min_total',
        'type'    => 'slider',
        'title'   => esc_html__( 'Minimum order total to show coupon', 'kalles' ),
        'min'     => 0,
        'max'     => 2000,
        'step'    => 10,
        'default' => 0,
      ),
      

    )
) );
