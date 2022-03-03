<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */


//Woocommerce general config

if ( class_exists( 'WooCommerce' ) ) {
  $attributes = array();
  $attributes_tax = wc_get_attribute_taxonomies();
  foreach ( $attributes_tax as $attribute ) {
    $attributes[ $attribute->attribute_name ] = $attribute->attribute_label;
  }

if ( ! function_exists('kalles_get_compare_fields') ) {
  function kalles_get_compare_fields() {
    $product_atts = array();
    //Default fields
    $atts = array(
      'description'  => 'Description',
      'availability' => 'Availability',
      'sku'          => 'Sku'
    );

    if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
      $product_atts = wc_get_attribute_taxonomies();

      if ( count($product_atts) > 0 ) {
        foreach ($product_atts as $att ) {
          $atts['pa_' . $att->attribute_name] = wc_attribute_label( $att->attribute_label );
        }
      }
    }

    return $atts;
  }
}
  CSF::createSection( $prefix, array(
    'id'    => 'woocommerce-general',
    'title' => esc_html__( 'WooCommerce General', 'kalles' ),
    'icon'  => 'fas fa-shopping-basket',
    ) );
  CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-general',
    'id'          => 'wc_general_setting',
    'title'       => esc_html__( 'General Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'General Setting', 'kalles' ),
          ),
          array(
            'id'      => 'wc-enable-page-title',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Page Title', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'         => 'wc-page-title',
            'type'       => 'text',
            'title'      => esc_html__( 'Page Title', 'kalles' ),
            'default'    => esc_html__( 'kalles' , 'kalles' ),
            'dependency' => array( 'wc-enable-page-title', '==', true ),
          ),
          array(
            'id'         => 'wc-page-desc',
            'type'       => 'textarea',
            'title'      => esc_html__( 'Description', 'kalles' ),
            'default'    => esc_html__( 'Online fashion, furniture, handmade... store', 'kalles' ),
            'dependency' => array( 'wc-enable-page-title', '==', true ),
          ),
          array(
            'id'         => 'wc-pagehead-bg',
            'type'       => 'background',
            'title'      => esc_html__( 'Page Title Background', 'kalles' ),
            'dependency' => array( 'wc-enable-page-title', '==', true ),
          ),
          array(
            'id'      => 'wc-catalog',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Catalog Mode', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc-discount-by-qty',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable quantity discount featured', 'kalles' ),
            'default' => false,
          ),
          array(
            'type'    => 'subheading',
            'content'   => esc_html__( 'Shop filter setting', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc-filter_ajax',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Ajax Filter', 'kalles' ),
            'default' => true,
          ),
          array(
            'type'    => 'subheading',
            'content'   => esc_html__( 'Brands page', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc-brands',
            'type'    => 'checkbox',
            'title'   => esc_html__( 'Brands attribute', 'kalles' ),
            'desc'   => esc_html__( 'Select product attributes to show on brands page. You must put Shortcode [kalles_brands] in content of page to show brands.', 'kalles' ),
            'options' => kalles_csf_get_attr(),
          ),
        )
  ) );

  CSF::createSection( $prefix, array(
  'parent'      => 'woocommerce-general',
  'id'          => 'wc_product_swatches',
  'title'       => esc_html__( 'Swatches', 'kalles' ),
  'icon'        => 'fa fa-minus',
  'fields' => array(
        array(
          'type'    => 'heading',
          'content' => esc_html__( 'Swatches Setting', 'kalles' ),
        ),
        array(
            'id'      => 'wc_product_swatches-enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Swatches', 'kalles' ),
            'default' => true,
          ),
        array(
            'id'      => 'wc_product_swatches-list',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable on product list', 'kalles' ),
            'default' => true,
          ),
        array(
            'id'      => 'wc_product_swatches-list_position',
            'type'    => 'select',
            'title'   => esc_html__( 'Product list swach position', 'kalles' ),
            'options'     => array(
                'before'     => 'Before title',
                'after'     => 'After title',
              ),
            'default' => 'before',
            'dependency' => array('wc_product_swatches-list', '==', true),
          ),
        array(
            'id'      => 'wc_product_swatches-att_img',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Use variant image?', 'kalles' ),
            'default' => false,
          ),
        array(
            'id'      => 'wc_product_swatches-tooltip',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Tooltip?', 'kalles' ),
            'default' => true,
          ),
        array(
          'type'    => 'subheading',
          'content' => esc_html__( 'Swatches design', 'kalles' ),
        ),
        array(
            'id'    => 'wc_product_swatches-style',
            'type'  => 'select',
            'title' => esc_html__( 'Swatches shape', 'kalles' ),
            'options' => array(
              'rounded'    => esc_html__( 'Rounded', 'kalles' ),
              'rectangular' => esc_html__( 'Square', 'kalles' ),
            ),
            'default' => 'rectangular'
          ),
        array(
            'id'         => 'wc_product_swatches-width',
            'type'       => 'slider',
            'title'      => esc_html__( 'Swatches width in loop', 'kalles' ),
            'unit'       => 'px',
            'default'    => 24,
            'min'        => 15,
            'max'        => 40,
            'step'       => 1,
        ),
      array(
          'id'         => 'wc_product_single_swatches-width',
          'type'       => 'slider',
          'title'      => esc_html__( 'Swatches width in single', 'kalles' ),
          'unit'       => 'px',
          'default'    => 24,
          'min'        => 15,
          'max'        => 40,
          'step'       => 1,
      ),
      )
  ) );

  CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-general',
    'id'          => 'wc_wishlist_setting',
    'title'       => esc_html__( 'Wishlist setting', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content'   => esc_html__( 'Wishlist setting', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc_general_wishlist-type',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Wishlist Type', 'kalles' ),
            'desc'   => esc_html__( 'If you select Plugin option, You need install Wishlist plugin, eg: Yith woocommerce wishlist,..', 'kalles' ),
            'default' => true,
            'text_on'  => 'Local',
            'text_off' => 'Plugin',
            'text_width' => 100,
          ),
          array(
            'id'    => 'wc_general_wishlist-page',
            'type'  => 'select',
            'title' => esc_html__( 'Wishlist Page', 'kalles' ),
            'desc' => esc_html__( 'Select page to view Wishlist, you must put Shortcode [kalles_wishlist] in content.', 'kalles' ),
            'ajax'        => true,
            'options'     => 'pages',
            'placeholder' => 'Select posts',
            'chosen'      => true,
            'dependency' => array( 'wc_general_wishlist-type', '==', true ),
          ),
          array(
            'id'         => 'wc_general_wishlist-action',
            'type'       => 'button_set',
            'title'      => esc_html__( 'Action after click added wishlist', 'kalles' ),
            'options' => array(
              '1'   => esc_html__( 'Go to page Wishlist', 'kalles' ),
              '2' => esc_html__( 'Remove from Wishlist', 'kalles' ),
            ),
            'default' => '1',
            'dependency' => array( 'wc_general_wishlist-type', '==', true )
          ),
          array(
            'id'      => 'wc_general_wishlist-empty_text',
            'type'    => 'wp_editor',
            'title'   => esc_html__( 'Wishlist empty text', 'kalles' ),
            'dependency' => array( 'wc_general_wishlist-type', '==', true ),
          ),

        )
  ) );
  CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-general',
    'id'          => 'wc_compare_setting',
    'title'       => esc_html__( 'Compare setting', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content'   => esc_html__( 'Compare setting', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc_general_compare',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Compare', 'kalles' ),
            'desc'   => esc_html__( 'Enable compare function include on theme.', 'kalles' ),
            'default' => false,
          ),
          array(
            'id'      => 'wc_general_compare-view_list',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Show compare button on Product list', 'kalles' ),
            'desc'   => '',
            'default' => true,
          ),
          array(
            'id'    => 'wc_general_compare-page',
            'type'  => 'select',
            'title' => esc_html__( 'Compare Page', 'kalles' ),
            'desc' => esc_html__( 'Select page to view compare, you must put Shortcode [kalles_compare] in content.', 'kalles' ),
            'ajax'        => true,
            'chosen'      => true,
            'options'     => 'pages',
            'placeholder' => 'Select posts',
          ),
          array(
            'id'    => 'wc_general_compare-fields',
            'type'  => 'select',
            'title' => esc_html__( 'Compare fields', 'kalles' ),
            'desc' => esc_html__( 'Choose fileds display to compare', 'kalles' ),
            //'ajax'        => true,
            'chosen'      => true,
            'multiple'    => true,
            'placeholder' => 'Select fields',
            'options'     => kalles_get_compare_fields(),
            'default'     => array( 'description', 'availability', 'sku')
          ),
          array(
            'id'      => 'wc_general_compare-empty_text',
            'type'    => 'wp_editor',
            'title'   => esc_html__( 'compare empty text', 'kalles' ),
          ),

        )
  ) );
  CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-general',
    'id'          => 'wc_label_setting',
    'title'       => esc_html__( 'Label Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Label Setting', 'kalles' ),
          ),
          array(
            'id'    => 'wc-badge-style',
            'type'  => 'select',
            'title' => esc_html__( 'Label shape', 'kalles' ),
            'options' => array(
              'rounded'    => esc_html__( 'Rounded', 'kalles' ),
              'rectangular' => esc_html__( 'Rectangular', 'kalles' ),
            ),
            'default' => 'rectangular'
          ),
          array(
            'id'      => 'wc_label_setting-sale',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable "Sale" label', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'    => 'wc-badge-type',
            'type'  => 'select',
            'title' => esc_html__( 'Sale Badge Type', 'kalles' ),
            'desc'  => esc_html__( 'Apply for product simple only', 'kalles' ),
            'options' => array(
              'text'    => esc_html__( 'Text', 'kalles' ),
              'percent' => esc_html__( 'Discount percent', 'kalles' ),
            ),
            'default' => 'text'
          ),
          array(
            'id'    => 'wc-badge-round',
            'type'  => 'select',
            'title' => esc_html__( 'Sale Rounded', 'kalles' ),
            'options' => array(
              'off'    => esc_html__( 'Off', 'kalles' ),
              'round' => esc_html__( 'Round', 'kalles' ),
              'round-up' => esc_html__( 'Round-up', 'kalles' ),
              'round-down' => esc_html__( 'Round-down', 'kalles' ),
            ),
            'default' => 'off',
            'dependency' => array( 'wc-badge-type', '==', 'percent' )
          ),
          array(
            'id'      => 'wc_label_setting-new',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable "New" label', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'      => 'wc_label_setting-new_days',
            'type'    => 'slider',
            'title'   => esc_html__( 'Show products added in the past x days', 'kalles' ),
            'min'     => 1,
            'max'     => 60,
            'step'    => 1,
            'default' => 5,
          ),
          array(
            'id'      => 'wc_label_setting-hot',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable "Hot" label', 'kalles' ),
            'desc'    => 'Display in Featured product',
            'default' => true,
          ),
          array(
            'id'      => 'wc_label_setting-sold_out',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable "Sold out" label', 'kalles' ),
            'desc'    => 'switcher',
            'default' => true,
          ),

        )
  ) );

  CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-general',
    'id'          => 'wc_search_setting',
    'title'       => esc_html__( 'Search Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Search Setting', 'kalles' ),
          ),
          array(
            'id'      => 'wc-search_ajax',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Ajax search', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'      => 'wc-search_inspiration_enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable suggest Products', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'      => 'wc-search_inspiration_text',
            'type'    => 'text',
            'title'   => esc_html__( 'Product suggest text', 'kalles' ),
            'default' => esc_html__( 'Need some inspiration?', 'kalles' ),
            'dependency' => array( 'wc-search_inspiration_enable', '==', true ),
          ),
          array(
            'id'         => 'wc-search_inspiration_cat',
            'type'       => 'select',
            'title'      => esc_html__( 'Select category to display', 'kalles' ),
            'options'    => 'categories',
            'dependency' => array( 'wc-search_inspiration_enable', '==', true ),
            'query_args' => array(
              'post_type'      => 'product',
              'taxonomy'       => 'product_cat',
              'orderby'        => 'post_title',
              'order'          => 'ASC',
              'posts_per_page' => -1,
            ),
          ),
          array(
            'id'      => 'wc-search_suggest_enable',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable suggest text', 'kalles' ),
            'default' => true,
          ),
          array(
            'id'      => 'wc-search_suggest_text',
            'type'    => 'textarea',
            'title'   => esc_html__( 'Search suggest text', 'kalles' ),
            'desc'   => esc_html__( 'Separation by ","', 'kalles' ),
            'default' => esc_html__( 'Men, Womens, Kid, Clothing', 'kalles' ),
            'dependency' => array( 'wc-search_inspiration_enable', '==', true ),
          ),
          array(
            'id'         => 'wc-search_layout',
            'type'       => 'select',
            'title'      => esc_html__( 'Seach layout', 'kalles' ),
            'options'    => array(
              'sidebar' => esc_html__( 'Hidden sidebar', 'kalles' ),
              'on_top'   => esc_html__( 'Hidden On Top', 'kalles' ),
              'fullwidth' => esc_html__( 'Full Width', 'kalles' ),
            ),
            'dependency' => array( 'wc-search_inspiration_enable', '==', true ),
          ),
        )
  ) );

  CSF::createSection( $prefix, array(
    'parent'      => 'woocommerce-general',
    'id'          => 'wc_account_setting',
    'title'       => esc_html__( 'Account Settings', 'kalles' ),
    'icon'        => 'fa fa-minus',
    'fields' => array(
          array(
            'type'    => 'heading',
            'content' => esc_html__( 'Account Setting', 'kalles' ),
          ),
          array(
            'id'      => 'woocommerce_account-type',
            'type'    => 'button_set',
            'title'   => esc_html__( 'Login/Register type', 'kalles' ),
            'options' => array(
              'default' => 'Default',
              'sidebar' => 'Sidebar',
              'popup' => 'Popup',
            ),
            'default' => 'sidebar',
          ),
          array(
            'id'      => 'woocommerce_account_layout',
            'type'    => 'select',
            'title'   => esc_html__( 'Woocommerce Account Layout', 'kalles' ),
            'options' => array(
                'layout_1' => 'Layout 1',
                'layout_2' => 'Layout 2',
            ),
            'default' => 'layout_1',
            'dependency' => array( 'woocommerce_account-type', '!=', 'sidebar' ),
          ),
          array(
            'id'      => 'woocommerce_account_layout_bg',
            'type'    => 'media',
            'title'   => 'Background Account Form',
            'library' => 'image',
            'url'     => false,
            'dependency' => array( 'woocommerce_account_layout', '==', 'layout_2' ),
            'desc'    => 'Background account form for layout 2',
          ),
          array(
            'id'      => 'wc_login_desc',
            'type'    => 'textarea',
            'default' => esc_html__( 'Sign in to purchase and use the latest gadgets', 'kalles' ),
            'title'   => esc_html__( 'Woocommerce Account Login Description', 'kalles' ),
            'dependency' => array( 'woocommerce_account_layout', '==', 'layout_2' ),
          ),
          array(
            'id'      => 'wc_regis_desc',
            'type'    => 'textarea',
            'default' => esc_html__( 'Register to purchase and use the latest gadgets', 'kalles' ),
            'title'   => esc_html__( 'Woocommerce Account Register Description', 'kalles' ),
            'dependency' => array( 'woocommerce_account_layout', '==', 'layout_2' ),
          ),
          array(
            'id'      => 'woocommerce_account-ajax',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Ajax', 'kalles' ),
            'default' => false,
            'dependency' => array( 'woocommerce_account-type', '!=', 'default' ),
          ),
          array(
            'id'      => 'woocommerce_account-google_capcha',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable Google capcha', 'kalles' ),
            'default' => false,
            'dependency' => array(
                array( 'woocommerce_account-ajax', '==', true ),
                array( 'woocommerce_account-type', '!=', 'default' )
             ),
          ),
          array(
            'id'      => 'woocommerce_account-google_key',
            'type'    => 'text',
            'title'   => esc_html__( 'Google site key', 'kalles' ),
            'desc'    => 'To add reCaptcha validation, you must have Google site key and secret key. You can get it from <a href="https://www.google.com/recaptcha/about/" target="_blank">Here</a>',
            'dependency' => array(
                array( 'woocommerce_account-ajax', '==', true ),
                array( 'woocommerce_account-google_capcha', '==', true ),
                array( 'woocommerce_account-type', '!=', 'default' )
             ),
          ),
          array(
            'id'      => 'woocommerce_account-google_key_verify',
            'type'    => 'text',
            'title'   => esc_html__( 'Google site key verify', 'kalles' ),
            'desc'    => esc_html__( 'Use this secret key for communication between your site and reCAPTCHA.', 'kalles' ),
            'dependency' => array(
                array( 'woocommerce_account-ajax', '==', true ),
                array( 'woocommerce_account-google_capcha', '==', true ),
                array( 'woocommerce_account-type', '!=', 'default' )
             ),
          ),
          array(
            'id'      => 'woocommerce_account-avatar',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable customer upload avatar?', 'kalles' ),
            'desc'    => esc_html__( 'Customer can upload avatar image from account details page.', 'kalles' ),
            'default' => false
          ),
          array(
            'id'      => 'woocommerce_account-avatar_size',
            'type'    => 'slider',
            'title'   => 'Avatar image size',
            'min'     => 30,
            'max'     => 200,
            'step'    => 5,
            'default' => 100,
          ),
          array(
            'id'      => 'woocommerce_account-avatar_style',
            'type'    => 'button_set',
            'title'   => esc_html__( 'Avatar image style', 'kalles' ),
            'options' => array(
              'circle' => 'Circle',
              'square' => 'Square',
            ),
            'default' => 'circle',
          ),
          array(
            'type'    => 'subheading',
            'content' => esc_html__( 'Social login', 'kalles' ),
          ),
          array(
            'id'      => 'woocommerce_account-social',
            'type'    => 'switcher',
            'title'   => esc_html__( 'Enable social login', 'kalles' ),
            'default' => false
          ),
          array(
            'id'     => 'woocommerce_account-social_facebook',
            'type'   => 'fieldset',
            'title'  => 'Facebook',
            'fields' => array(
              array(
                'id'    => 'social_facebook-on',
                'type'    => 'switcher',
                'title'   => esc_html__( 'Enable', 'kalles' ),
                'default' => false
              ),
              array(
                'id'    => 'social_facebook-id',
                'type'  => 'text',
                'title' => 'Application ID',
              ),
              array(
                'id'    => 'social_facebook-key',
                'type'  => 'text',
                'title' => 'Application Secret',
              ),
              array(
                'type'  => 'notice',
                'style'  => 'info',
                'content'  => '<a href="https://the4.co/how-to-create-facebook-app/" target="_blank">How to get Facebook application ID, Secret key?</a>'
              ),
              array(
                'type'  => 'notice',
                'style'  => 'warning',
                'content'  => 'Provide this URL as the Authorized redirect URI for your application: ' . untrailingslashit( get_permalink( get_option('woocommerce_myaccount_page_id') ) ). '?t4_auth=facebook'
              ),
            ),
            'dependency' => array('woocommerce_account-social', '==', true),
          ),
          array(
            'id'     => 'woocommerce_account-social_google',
            'type'   => 'fieldset',
            'title'  => 'Google',
            'fields' => array(
              array(
                'id'    => 'social_google-on',
                'type'    => 'switcher',
                'title'   => esc_html__( 'Enable', 'kalles' ),
                'default' => false
              ),
              array(
                'id'    => 'social_google-id',
                'type'  => 'text',
                'title' => 'Application ID',
              ),
              array(
                'id'    => 'social_google-key',
                'type'  => 'text',
                'title' => 'Application Secret',
              ),
              array(
                'type'  => 'notice',
                'style'  => 'info',
                'content'  => '<a href="https://developers.google.com/adwords/api/docs/guides/authentication#webapp" target="_blank">How to get Google application ID, Secret key?</a>'
              ),
              array(
                'type'  => 'notice',
                'style'  => 'warning',
                'content'  => 'Provide this URL as the Authorized redirect URI for your application: ' . untrailingslashit( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) . '?t4_auth=google'
              ),
            ),
            'dependency' => array('woocommerce_account-social', '==', true),
          ),
          array(
            'id'     => 'woocommerce_account-social_twitter',
            'type'   => 'fieldset',
            'title'  => 'Twitter',
            'fields' => array(
              array(
                'id'    => 'social_twitter-on',
                'type'    => 'switcher',
                'title'   => esc_html__( 'Enable', 'kalles' ),
                'default' => false
              ),
              array(
                'id'    => 'social_twitter-id',
                'type'  => 'text',
                'title' => 'Application ID',
              ),
              array(
                'id'    => 'social_twitter-key',
                'type'  => 'text',
                'title' => 'Application Secret',
              ),
              array(
                'type'  => 'notice',
                'style'  => 'info',
                'content'  => '<a href="https://the4.co/how-to-create-a-twitter-app/" target="_blank">How to get Twitter application ID, Secret key?</a>'
              ),
              array(
                'type'  => 'notice',
                'style'  => 'warning',
                'content'  => 'Provide this URL as the Authorized redirect URI for your application: ' . untrailingslashit( get_permalink( get_option('woocommerce_myaccount_page_id') ) )
              ),
            ),
            'dependency' => array('woocommerce_account-social', '==', true),
          ),
        )
  ) );


}

