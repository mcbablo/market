<?php
/**
 * Theme constants definition and functions.
 *
 * @since   1.0.0
 * @package Kalles
 */
// Popup config

CSF::createSection( $prefix, array(
    'id'    => 'popup',
    'title' => esc_html__( 'Popup', 'kalles' ),
    'icon'  => 'fas fa-external-link-alt',
    ) );
//Age verify
CSF::createSection( $prefix, array(
  'id'     => 'popup-age_verify',
  'parent' => 'popup',
  'title'  => esc_html__( 'Age verification popup', 'kalles' ),
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Age verification', 'kalles' ),
    ),
    array(
      'type'    => 'submessage',
      'style'   => 'warning',
      'content' => esc_html__( 'If you sell products such as wine, cigarettes, or dangerous goods, then you might want to discourage visitors under a certain age from browsing your website.
        You can do this by adding an age selection form to your storefront. Keep in mind that age verification is not the best way to prevent visitors from browsing your website, as there\'s nothing preventing them from lying about their age. It might even be a nuisance to regular visitors, who will have to make an additional click to access your store.', 'kalles' ),
    ),
    array(
      'id'         => 'popup-age_verify_enable',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Age verification', 'kalles' ),
      'default'    => true
    ),
    array(
      'id'      => 'popup-age_verify_age',
      'type'    => 'slider',
      'title'   => 'Age limit',
      'min'     => 0,
      'max'     => 100,
      'step'    => 1,
      'default' => 18,
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_use_age',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Use enter date of birth', 'kalles' ),
      'default'    => false,
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_heading',
      'type'       => 'text',
      'title'      => esc_html__( 'Heading', 'kalles' ),
      'default'    => esc_html__( 'Are you over 18?', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_content',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Content', 'kalles' ),
      'default'    => esc_html__( 'You must be 18 years of age or older to view page. Please verify your age to enter.', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_btn_allowed',
      'type'       => 'text',
      'title'      => esc_html__( 'Button text verify allowed', 'kalles' ),
      'default'    => esc_html__( 'I am 18 or Older', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_btn_forbidden',
      'type'       => 'text',
      'title'      => esc_html__( 'Button text verify forbidden', 'kalles' ),
      'default'    => esc_html__( 'I am Under 18', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_text_forbidden_1',
      'type'       => 'text',
      'title'      => esc_html__( 'Text forbidden 1', 'kalles' ),
      'default'    => esc_html__( 'Access forbidden', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_text_forbidden_2',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Text forbidden 2', 'kalles' ),
      'default'    => esc_html__( 'Your access is restricted because of your age.', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'      => 'popup-age_verify_day_next',
      'type'    => 'slider',
      'title'   => esc_html__( 'Day next show (n)', 'kalles' ),
      'desc'   => esc_html__ ('if user verify, next show will be after \'n\' days', 'kalles'),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 30,
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Design Option', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'        => 'popup-age_verify_bg_img',
      'title'     => esc_html__( 'Background Image', 'kalles' ),
      'type'      => 'media',
      'url'       => false,
      'add_title' => esc_html__( 'Upload', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_bg_color',
      'type'       => 'color',
      'title'      => esc_html__( 'Background Color', 'kalles' ),
      'default'    => '#56CFE1',
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_btn_color',
      'type'       => 'color',
      'title'      => esc_html__( 'Background color \'Button verify allowed\'', 'kalles' ),
      'default'    => '#007E91',
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-age_verify_btn_hover_color',
      'type'       => 'color',
      'title'      => esc_html__( 'Background color \'Button verify allowed\' hover', 'kalles' ),
      'default'    => '#035F6D',
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'      => 'popup-age_bg_opacity',
      'type'    => 'slider',
      'title'   => esc_html__( 'Background overlay', 'kalles' ),
      'min'     => 0,
      'max'     => 100,
      'step'    => 1,
      'default' => 0,
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
  )
) );

//Cookie Law info
CSF::createSection( $prefix, array(
  'id'     => 'popup-cookie-law',
  'parent' => 'popup',
  'title'  => esc_html__( 'Cookie Law Info', 'kalles' ),
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Cookie Law Info', 'kalles' ),
    ),
    array(
      'type'    => 'submessage',
      'style'   => 'warning',
      'content' => esc_html__( 'Under EU privacy regulations, websites must make it clear to visitors what information about them is being stored. This specifically includes cookies. Turn on this option and user will see info box at the bottom of the page that your web-site is using cookies.', 'kalles' ),
    ),
    array(
      'id'         => 'popup-cookie-law_enable',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Cookie Law Info', 'kalles' ),
      'default'    => true
    ),
    array(
      'id'         => 'popup-cookie_text',
      'type'       => 'wp_editor',
      'title'      => esc_html__( 'Text', 'kalles' ),
      'height'        => '100px',
      'media_buttons' => false,
      'quicktags'     => false,
      'default'    => esc_html__( 'We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.', 'kalles' ),
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-cookie_type',
      'type'       => 'button_set',
      'title'      => esc_html__( 'Cookie Law Type', 'kalles' ),
      'options'    => array(
        'banner' => 'Banner',
        'popup'   => 'Popup',
      ),
      'default'    => 'banner',
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-cookie_banner_position',
      'type'       => 'button_set',
      'title'      => esc_html__( 'Banner position', 'kalles' ),
      'options'    => array(
        'header' => 'Header',
        'footer' => 'Footer',
      ),
      'default'    => 'footer',
      'dependency' => array(
        array( 'popup-cookie-law_enable', '==', true ),
        array( 'popup-cookie_type', '==', 'banner' )
      ),
    ),
    array(
      'id'         => 'popup-cookie_banner_scroll',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Accept on scroll?', 'kalles' ),
      'desc'      => esc_html__( 'Auto hide cookie bar when when user scroll', 'kalles' ),
      'default'    => false,
      'dependency' => array(
        array( 'popup-cookie-law_enable', '==', true ),
        array( 'popup-cookie_type', '==', 'banner' )
      ),
    ),
    array(
      'id'         => 'popup-cookie_btn_allowed',
      'type'       => 'text',
      'title'      => esc_html__( 'Button \'Accept\'', 'kalles' ),
      'default'    => esc_html__( 'Accept', 'kalles' ),
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-cookie_btn_info',
      'type'       => 'text',
      'title'      => esc_html__( 'Button text \'More info\'', 'kalles' ),
      'default'    => esc_html__( 'More info', 'kalles' ),
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-cookie_info_link',
      'type'       => 'link',
      'title'      => esc_html__( 'Link \'More info\'', 'kalles' ),
      'desc'       => esc_html__( 'Choose page that will contain detailed information about your Privacy Policy', 'kalles' ),
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'id'      => 'popup-cookie_version',
      'type'    => 'slider',
      'title'   => esc_html__( 'Cookies version', 'kalles' ),
      'desc'   => esc_html__ ('If you change your cookie policy information you can increase their version to show the popup to all visitors again.', 'kalles'),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 1,
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'id'      => 'popup-cookie_verify_day_next',
      'type'    => 'slider',
      'title'   => esc_html__( 'Day next show (n)', 'kalles' ),
      'desc'   => esc_html__ ('if user verify, next show will be after \'n\' days', 'kalles'),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 30,
      'dependency' => array( 'popup-cookie-law_enable', '==', true ),
    ),
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Design Option', 'kalles' ),
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-cookie_verify_btn_bg',
      'type'       => 'color',
      'title'      => esc_html__( 'Background color \'Accept\'', 'kalles' ),
      'default'    => '#007E91',
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    ),
    array(
      'id'         => 'popup-cookie_verify_btn_hover_bg',
      'type'       => 'color',
      'title'      => esc_html__( 'Background color \'Accept\' hover', 'kalles' ),
      'default'    => '#035F6D',
      'dependency' => array( 'popup-age_verify_enable', '==', true ),
    )
  )
) );

//Sale Popup
CSF::createSection( $prefix, array(
  'id'     => 'popup-sale',
  'parent' => 'popup',
  'title'  => esc_html__( 'Sales popup', 'kalles' ),
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Sales popup', 'kalles' ),
    ),
    array(
      'id'         => 'popup-sale_enable',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Sale Popup', 'kalles' ),
      'default'    => true
    ),
    array(
      'id'         => 'popup-sale_type',
      'type'       => 'select',
      'title'      => esc_html__( 'Popup Sale Type', 'kalles' ),
      'options'    => array(
        'manual' => 'Manual Input',
        'auto'   => 'Recently Purchased',
      ),
      'default'    => 'manual',
    ),
    array(
      'id'         => 'popup-sale_category',
      'type'       => 'select',
      'title'      => esc_html__( 'Select category to display', 'kalles' ),
      'options'    => 'categories',
      'dependency' => array( array('popup-sale_enable', '==', true), array('popup-sale_type', '==', 'manual')),
      'query_args' => array(
        'post_type'      => 'product',
        'taxonomy'       => 'product_cat',
        'orderby'        => 'post_title',
        'order'          => 'ASC',
        'posts_per_page' => -1,
      ),
    ),
    array(
      'id'      => 'popup-sale_page',
      'type'    => 'select',
      'default' => 'all',
      'title'   => esc_html__( 'Select Page to display', 'kalles' ),
      'options' => array(
        'all'                         => esc_html__( 'All page', 'kalles' ),
        'home'                        => esc_html__( 'Home page', 'kalles' ),
        'single-product'              => esc_html__( 'Product page', 'kalles' ),
        'tax-product_cat'             => esc_html__( 'Category page', 'kalles' ),
        'blog'                        => esc_html__( 'Blog page', 'kalles' ),
        'post-type-archive-portfolio' => esc_html__( 'Portfolio', 'kalles' ),
      ),
      'chosen'      => true,
      'multiple'    => true,
    ),
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'General setting', 'kalles' ),
    ),
    array(
      'id'         => 'popup-sale_type_option',
      'type'       => 'select',
      'title'      => esc_html__( 'Sale Popup type', 'kalles' ),
      'options'     => array(
        '1'     => esc_html__( 'Random', 'kalles' ),
        '2' => esc_html__( 'Sequential', 'kalles' ),
      ),
    ),
    array(
      'id'      => 'popup-sale_start_time',
      'type'    => 'slider',
      'title'   => esc_html__( 'Popup Start Time', 'kalles' ),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 5,
    ),
    array(
      'id'         => 'popup-sale_start_unit',
      'type'       => 'select',
      'title'      => esc_html__( 'Popup Start Time Unit', 'kalles' ),
      'options'     => array(
        '1000'     => esc_html__( 'Second', 'kalles' ),
        '60000' => esc_html__( 'Minute', 'kalles' ),
      ),
    ),
    array(
      'id'      => 'popup-sale_stay_time',
      'type'    => 'slider',
      'title'   => esc_html__( 'Popup Stay Time', 'kalles' ),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 5,
    ),
    array(
      'id'         => 'popup-sale_stay_unit',
      'type'       => 'select',
      'title'      => esc_html__( 'Popup Stay Time Unit', 'kalles' ),
      'options'     => array(
        '1000'     => esc_html__( 'Second', 'kalles' ),
        '60000' => esc_html__( 'Minute', 'kalles' ),
      ),
    ),
    array(
      'id'         => 'popup-sale_btn_close',
      'type'       => 'switcher',
      'label'       => 'Enable',
      'title'      => esc_html__( 'Show close button?', 'kalles' ),
      'default'    => true,
    ),
    array(
      'id'         => 'popup-sale_btn_quickview',
      'type'       => 'switcher',
      'label'       => 'Enable',
      'title'      => esc_html__( 'Show quickview button?', 'kalles' ),
      'default'    => true,
    ),
    array(
      'id'         => 'popup-sale_btn_purchase_list',
      'type'       => 'textarea',
      'title'      => esc_html__( 'List user purchased', 'kalles' ),
      'default'    => 'Nathan (California) | Alex (Texas) | Henry (New York) | Kiti (Ohio) | Daniel (Washington) | Hau (California) | Van (Ohio) | Sara (Montana)  | Kate (Georgia)',
      'desc'       => esc_html__( 'separate with \'|\'. If you not want use list user you can write a text. eg:\'someone\'', 'kalles' ),
      'dependency' => array( array('popup-sale_enable', '==', true), array('popup-sale_type', '==', 'manual')),
    ),
    array(
      'id'         => 'popup-sale_show_time_ago',
      'type'       => 'switcher',
      'label'       => 'Enable',
      'title'      => esc_html__( 'Show time ago in suggest', 'kalles' ),
      'default'    => true,
    ),
    array(
      'id'         => 'popup-sale_btn_list_time',
      'type'       => 'textarea',
      'title'      => esc_html__( 'List time', 'kalles' ),
      'default'    => '4 hours ago | 2 hours ago | 45 minutes ago | 1 day ago | 8 hours ago | 10 hours ago | 25 minutes ago | 2 day ago | 5 hours ago | 40 minutes ago',
      'desc'       => esc_html__( 'separate with \'|\'.', 'kalles' ),
      'dependency' => array(
          array('popup-sale_enable', '==', true ),
          array('popup-sale_show_time_ago', '==', true ),
          array('popup-sale_type', '==', 'manual')
        )
    ),
    array(
      'id'         => 'popup-sale_show_vefify',
      'type'       => 'switcher',
      'label'       => 'Enable',
      'title'      => esc_html__( 'Show Verified?', 'kalles' ),
      'default'    => true,
    ),
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Design Option', 'kalles' ),
    ),
    array(
      'id'         => 'popup-sale_popup_design_option',
      'type'       => 'select',
      'title'      => esc_html__( 'Design Popup', 'kalles' ),
      'options'     => array(
        '1'     => esc_html__( 'Design 1', 'kalles' ),
        '2' => esc_html__( 'Design 2', 'kalles' ),
      ),
    ),
    array(
      'id'         => 'popup-sale_animaton',
      'type'       => 'select',
      'title'      => esc_html__( 'Animation Style', 'kalles' ),
      'options'    => array(
        'anislideInUp'        => esc_html__( 'slideInUp', 'kalles' ),
        'anislideInLeft'      => esc_html__( 'slideInLeft', 'kalles' ),
        'anifadeIn'           => esc_html__( 'fadeIn', 'kalles' ),
        'anifadeInLeft'       => esc_html__( 'fadeInLeft', 'kalles' ),
        'anibounceInUp'       => esc_html__( 'bounceInUp', 'kalles' ),
        'anibounceInLeft'     => esc_html__( 'bounceInLeft', 'kalles' ),
        'anirotateInDownLeft' => esc_html__( 'rotateInDownLeft', 'kalles' ),
        'anirotateInUpLeft'   => esc_html__( 'rotateInUpLeft', 'kalles' ),
        'aniflipInX'          => esc_html__( 'flipInX', 'kalles' ),
        'anizoomIn'           => esc_html__( 'zoomIn', 'kalles' ),
        'anirollIn'           => esc_html__( 'rollIn', 'kalles' ),
        'aniswing'            => esc_html__( 'swing', 'kalles' ),
        'anishake'            => esc_html__( 'shake', 'kalles' ),
        'aniwobble'           => esc_html__( 'wobble', 'kalles' ),
        'anijello'            => esc_html__( 'jello', 'kalles' ),

      ),
    ),
    array(
      'id'         => 'popup-sale_purchase_text',
      'type'       => 'text',
      'title'      => esc_html__( 'Text \'Purchased\' ', 'kalles' ),
      'default'       => 'purchased',
    ),
    array(
      'id'         => 'popup-sale_verify_text',
      'type'       => 'text',
      'title'      => esc_html__( 'Text \'Verified\' ', 'kalles' ),
      'default'       => 'Verified',
    ),
  )
) );

//Exist Product Popup
CSF::createSection( $prefix, array(
  'id'     => 'popup-exist_product',
  'parent' => 'popup',
  'title'  => esc_html__( 'Exist products popup', 'kalles' ),
  'icon'   => 'fa fa-minus',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Exist products popup', 'kalles' ),
    ),
    array(
      'type'    => 'submessage',
      'style'   => 'warning',
      'content' => esc_html__( 'Enable an exit popup if user attempts to navigate away from current page as a means of influencing user action on store.
        Only visible on desktop.', 'kalles' ),
    ),
    array(
      'id'         => 'popup-exist_product_enable',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Exist products popup', 'kalles' ),
      'default'    => true
    ),
    array(
      'id'         => 'popup-exist_product_heading',
      'type'       => 'text',
      'title'      => esc_html__( 'Heading', 'kalles' ),
      'default'    => esc_html__( 'Wait! Can\'t find what you\'re looking for?', 'kalles' ),
    ),
    array(
      'id'         => 'popup-exist_product_subtext',
      'type'       => 'text',
      'title'      => esc_html__( 'Sub Text', 'kalles' ),
      'default'    => esc_html__( 'Maybe this will help...', 'kalles' ),
    ),
    array(
      'id'         => 'popup-exist_product_title_design',
      'type'       => 'select',
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
      'id'         => 'popup-exist_product_style7_icon',
      'type'       => 'text',
      'title'      => esc_html__( 'Style 7 icon line-awesome', 'kalles' ),
      'default'    => esc_html__( 'gem', 'kalles' ),
      'desc'    => '<a href="https://icons8.com/line-awesome" target="_blank">'. esc_html__( 'Get icon Line awesome ', 'kalles' ).'</a>',
      'dependency' => array(
        array( 'popup-exist_product_enable', '==', true ),
        array( 'popup-exist_product_title_design', '==', 'title_7' )
      ),
    ),
    array(
      'id'         => 'popup-exist_product_cat',
      'type'       => 'select',
      'title'      => esc_html__( 'Select category', 'kalles' ),
      'options'    => 'categories',
      'chosen'      => true,
      'multiple'    => true,
      'query_args' => array(
        'post_type'      => 'product',
        'taxonomy'       => 'product_cat',
        'orderby'        => 'post_title',
        'order'          => 'ASC',
        'posts_per_page' => -1,
      ),
    ),
    array(
      'id'      => 'popup-exist_product_total_qty',
      'type'    => 'slider',
      'title'   => esc_html__( 'Products to show', 'kalles' ),
      'min'     => 1,
      'max'     => 20,
      'step'    => 1,
      'default' => 12,
    ),
    array(
      'id'         => 'popup-exist_product_per_row',
      'type'       => 'select',
      'title'      => esc_html__( 'Products per row', 'kalles' ),
      'options'    => array(
          '4'  => '4',
          '5' => '5',
          '6'  => '6',
      ),
    ),
    array(
      'id'         => 'popup-exist_product_design',
      'type'       => 'select',
      'title'      => esc_html__( 'Design product', 'kalles' ),
      'options'    => array(
          '1'  => esc_html__( 'Design 1', 'kalles' ),
          '1 tc'  => esc_html__( 'Design 1 (center)', 'kalles' ),
          '2'  => esc_html__( 'Design 2', 'kalles' ),
      ),
    ),

    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Slider setting', 'kalles' ),
    ),
    array(
      'id'         => 'popup-exist_product_slider_loop',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Use Loop?', 'kalles' ),
      'desc'      => esc_html__( 'At the end of cells, wrap-around to the other end for infinite scrolling.', 'kalles' ),
      'default'    => true,
    ),
    array(
      'id'      => 'popup-exist_product_slider_start_time',
      'type'    => 'slider',
      'title'   => esc_html__( 'Autoplay Speed in second.', 'kalles' ),
      'desc'      => esc_html__( 'Set is \'0\' to disable autoplay.', 'kalles' ),
      'min'     => 0,
      'max'     => 30,
      'step'    => 0.5,
      'default' => 1,
    ),
    array(
      'id'         => 'popup-exist_product_slider_pause',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Pause Autoplay On Hover?', 'kalles' ),
      'desc'      => esc_html__( 'Auto-playing will pause when the user hovers over the carousel.', 'kalles' ),
      'default'    => true,
      'dependency' => array(
        array( 'popup-exist_product_enable', '==', true ),
        array( 'popup-exist_product_slider_start_time', '!=', 0 ),
      ),
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Prev, next button, page dot setting', 'kalles' ),
    ),
    array(
      'id'         => 'popup-exist_product_btn_enable',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable Prev Next Button?', 'kalles' ),
      'desc'      => esc_html__( 'Creates and enables previous & next buttons.', 'kalles' ),
      'default'    => false,
    ),
    array(
      'id'         => 'popup-exist_product_btn_hover_type',
      'type'       => 'button_set',
      'title'      => esc_html__( 'Visible', 'kalles' ),
      'options'    => array(
        'hover' => 'Only hover',
        'control-show'   => 'Always',
      ),
      'default'    => 'control-show',
      'dependency' => array(
        array( 'popup-exist_product_enable', '==', true ),
        array( 'popup-exist_product_btn_enable', '==', true )
      ),
    ),
    array(
      'id'         => 'popup-exist_btn_style',
      'type'       => 'select',
      'title'      => esc_html__( 'Button Style', 'kalles' ),
      'options'    => array(
          '1'  => esc_html__( 'Circle', 'kalles' ),
          '2'  => esc_html__( 'Square', 'kalles' ),
      ),
      'dependency' => array(
        array( 'popup-exist_product_enable', '==', true ),
        array( 'popup-exist_product_btn_enable', '==', true )
       ),
    ),
    array(
      'id'         => 'popup-exist_btn_color',
      'type'       => 'select',
      'title'      => esc_html__( 'Button color', 'kalles' ),
      'default'    => 'primary',
      'options'    => array(
          'transparent' => esc_html__( 'Transparent', 'kalles' ),
          'gray'        => esc_html__( 'Gray', 'kalles' ),
          'white'       => esc_html__( 'White', 'kalles' ),
          'primary'     => esc_html__( 'Primary', 'kalles' ),
      ),
      'dependency' => array(
        array( 'popup-exist_product_enable', '==', true ),
        array( 'popup-exist_product_btn_enable', '==', true )
       ),
    ),
    array(
      'id'         => 'popup-exist_product_dots_enable',
      'type'       => 'switcher',
      'title'      => esc_html__( 'Enable dots?', 'kalles' ),
      'default'    => false,
    ),
    array(
      'id'      => 'popup-exist_product_page',
      'type'    => 'select',
      'default' => 'all',
      'title'   => esc_html__( 'Select Page to display', 'kalles' ),
      'options' => array(
        'all'                         => esc_html__( 'All page', 'kalles' ),
        'home'                        => esc_html__( 'Home page', 'kalles' ),
        'single-product'              => esc_html__( 'Product page', 'kalles' ),
        'tax-product_cat'             => esc_html__( 'Category page', 'kalles' ),
        'blog'                        => esc_html__( 'Blog page', 'kalles' ),
        'post-type-archive-portfolio' => esc_html__( 'Portfolio', 'kalles' ),
      ),
      'chosen'      => true,
      'multiple'    => true,
    ),
    array(
      'id'      => 'popup-exist_product_day_next',
      'type'    => 'slider',
      'title'   => esc_html__( 'Day next show (n)', 'kalles' ),
      'desc'   => esc_html__ ('if user verify, next show will be after \'n\' days', 'kalles'),
      'min'     => 1,
      'max'     => 60,
      'step'    => 1,
      'default' => 30,
    ),
  )
) );
/*Newsltter Popup*/
CSF::createSection( $prefix, array(
    'parent'      => 'popup',
    'id'          => 'wc_newsletter_popup',
    'title'       => esc_html__( 'Newsletter popup', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
        array(
            'type'    => 'heading',
            'content' => esc_html__( 'Newsletter popup', 'kalles' ),
        ),
        array(
            'id'      => 'wc_newsletter_popup-enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable newsletter popup', 'kalles' ),
            'default' => true,
        ),
        array(
            'id'      => 'wc_newsletter_popup-image',
            'type'    => 'media',
            'title'   => 'Image',
            'library' => 'image',
            'url'     => false,
        ),
        array(
            'type'    => 'subheading',
            'content' => esc_html__( 'Content', 'kalles' ),
        ),
        array(
            'id'      => 'wc_newsletter_popup-heading',
            'type'    => 'textarea',
            'title'   => esc_html__( 'Heading', 'kalles' ),
            'default' => 'Sign up our newsletter and save 25% off for the next purchase!',
        ),
        array(
            'id'      => 'wc_newsletter_popup-subheading',
            'type'    => 'textarea',
            'title'   => esc_html__( 'Sub heading', 'kalles' ),
            'default' => 'Subscribe to our newsletters and don’t miss new arrivals, the latest fashion updates and our promotions.',
        ),
        array(
            'id'         => 'wc_newsletter_popup-form',
            'type'       => 'select',
            'title'      => esc_html__( 'Mailchimp form', 'kalles' ),
            'options'    => codestar_get_mailchimp_form_list()
        ),
        array(
            'id'         => 'wc_newsletter_popup-form_style',
            'type'       => 'select',
            'title'      => esc_html__( 'Form design', 'kalles' ),
            'options'    => array(
                '1' => 'Design 1',
                '2' => 'Design 2',
                '3' => 'Design 3',
                '4' => 'Design 4',
                '5' => 'Design 5',
                '6' => 'Design 6'
            )
        ),
        array(
            'id'      => 'wc_newsletter_popup-text2',
            'type'    => 'textarea',
            'title'   => esc_html__( 'Text 2', 'kalles' ),
            'default' => 'Your Information will never be shared with any third party.',
        ),
        array(
            'id'      => 'wc_newsletter_popup-anymore',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Show \'Do not show it anymore.\'?', 'kalles' ),
            'default' => true,
        ),
        array(
            'id'      => 'wc_newsletter_popup-text3',
            'type'    => 'textarea',
            'title'   => esc_html__( 'Text 3', 'kalles' ),
            'default' => 'Do not show it anymore.',
        ),
        array(
            'type'    => 'subheading',
            'content' => esc_html__( 'Setting', 'kalles' ),
        ),
        array(
            'id'         => 'wc_newsletter_popup-layout',
            'type'       => 'select',
            'title'      => esc_html__( 'Layout design', 'kalles' ),
            'options'    => array(
                '1' => 'Design 1',
                '2' => 'Design 2',
            )
        ),
        array(
            'id'      => 'wc_newsletter_popup-mobile',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Show for mobile devices?', 'kalles' ),
            'default' => false,
        ),
        array(
            'id'      => 'wc_newsletter_popup-page',
            'type'    => 'select',
            'default' => 'all',
            'title'   => esc_html__( 'Select Page to display', 'kalles' ),
            'options' => array(
                'all'                         => esc_html__( 'All page', 'kalles' ),
                'home'                        => esc_html__( 'Home page', 'kalles' ),
                'single-product'              => esc_html__( 'Product page', 'kalles' ),
                'tax-product_cat'             => esc_html__( 'Category page', 'kalles' ),
                'blog'                        => esc_html__( 'Blog page', 'kalles' ),
                'post-type-archive-portfolio' => esc_html__( 'Portfolio', 'kalles' ),
            ),
            'chosen'      => true,
            'multiple'    => true,
        ),
        array(
            'id'      => 'wc_newsletter_popup-version',
            'type'    => 'slider',
            'title'   => esc_html__( 'Popup version', 'kalles' ),
            'desc'   => esc_html__ ('If you change your promo popup you can increase its version to show the popup to all visitors again.', 'kalles'),
            'min'     => 1,
            'max'     => 60,
            'step'    => 1,
            'default' => 1,
        ),
        array(
            'id'      => 'wc_newsletter_popup-day_next',
            'type'    => 'slider',
            'title'   => esc_html__( 'Day next show (n)', 'kalles' ),
            'desc'   => esc_html__ ('if user close the popup, next show will be after \'n\' days', 'kalles'),
            'min'     => 1,
            'max'     => 60,
            'step'    => 1,
            'default' => 30,
        ),
        array(
            'id'         => 'wc_newsletter_popup-show_type',
            'type'       => 'select',
            'title'      => esc_html__( 'Show popup after', 'kalles' ),
            'options'    => array(
                'time' => 'Some time',
                'scroll' => 'User scroll',
            )
        ),
        array(
            'id'      => 'wc_newsletter_popup-time_delay',
            'type'    => 'slider',
            'title'   => esc_html__( 'Time delay to show', 'kalles' ),
            'desc'   => esc_html__ ('Show popup after some time (in seconds).', 'kalles'),
            'min'     => 1,
            'max'     => 50,
            'step'    => 1,
            'default' => 2,
            'unit'    => 's',
            'dependency' => array( 'wc_newsletter_popup-show_type', '==', 'time' ),
        ),
        array(
            'id'      => 'wc_newsletter_popup-scroll_unit',
            'type'    => 'slider',
            'title'   => esc_html__( 'Show after user scroll down the page', 'kalles' ),
            'desc'   => esc_html__ ('Set the number of pixels users have to scroll down before popup opens.', 'kalles'),
            'min'     => 100,
            'max'     => 5000,
            'step'    => 100,
            'default' => 800,
            'dependency' => array( 'wc_newsletter_popup-show_type', '==', 'scroll' ),
        ),
    )
) );

function codestar_get_mailchimp_form_list()
{
    $list_forms = get_posts(
        array(
            'post_type'   => 'mc4wp-form',
            'numberposts' => -1
        )
    );

    $lists = array();

    if ( !empty( $list_forms ) ) {
        foreach( $list_forms as $form ) {
            $lists[ $form->ID ] = $form->post_title;
        }
    }

    return $lists;
}
