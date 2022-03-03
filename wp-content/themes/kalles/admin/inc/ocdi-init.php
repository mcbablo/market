<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

function ocdi_change_time_of_single_ajax_call() {
    return 10;
}
add_filter( 'ocdi/time_for_one_ajax_call', 'ocdi_change_time_of_single_ajax_call' );

add_filter( 'ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

/**
 *
 * Change Plugin menu
 *
 */
function the4_ocdi_plugin_page_setup( $settings ) {
  $settings['parent_slug'] = 'the4-dashboard';
  $settings['page_title'] = 'The4 Import Demo Data';
  $settings['menu_title'] = 'Demo Import';
  $settings['menu_slug'] = 'the4-demo-import';

  return $settings;
}
add_filter( 'ocdi/plugin_page_setup', 'the4_ocdi_plugin_page_setup', 99 );


/**
 *
 * Change plugin header
 *
 */
function the4_ocdi_page_header() {
  $name = t4_white_label('white_label-theme_name', 'The4');
  ob_start(); ?>
  <div class="ocdi__title-container">
    <h1 class="ocdi__title-container-title"><?php echo sprintf(translate( '%s One Click Demo Import','kalles' ), $name); ?></h1>
  </div>
  <?php
  $plugin_title = ob_get_clean();

  return $plugin_title;
}
add_filter( 'ocdi/plugin_page_title', 'the4_ocdi_page_header' );

/**
 *
 * Change plugin intro text
 *
 */
function the4_ocdi_page_intro_text() {
    // Start output buffer for displaying the plugin intro text.
    ob_start();
    ?>

    <div class="ocdi__intro-text the4__intro_notice notice  notice-warning  is-dismissible">
      <p class="about-description">
        <?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:', 'kalles' ); ?>
        <ul>
          <li>
            <?php esc_html_e( 'Before you begin, make sure all the required plugins are activated', 'kalles' ); ?>
          </li>
          <li>
            <?php esc_html_e( 'Please click import only once and wait, it can take a couple of minutes', 'kalles' ); ?>
          </li>
        </ul>
      </p>
    </div>

    <?php
    $plugin_intro_text = ob_get_clean();

    return $plugin_intro_text;
}

add_filter( 'ocdi/plugin_intro_text', 'the4_ocdi_page_intro_text' );

/**
 *
 * Adding local_import_json and import_json param supports.
 *
 */
if ( ! function_exists( 'prefix_after_content_import_execution' ) ) {
  function prefix_after_content_import_execution( $selected_import_files, $import_files, $selected_index ) {

    $downloader = new OCDI\Downloader();

    if( ! empty( $import_files[$selected_index]['import_json'] ) ) {

      foreach( $import_files[$selected_index]['import_json'] as $index => $import ) {
        $file_path = $downloader->download_file( $import['file_url'], 'demo-import-file-'. $index .'-'. date( 'Y-m-d__H-i-s' ) .'.json' );
        $file_raw  = OCDI\Helpers::data_from_file( $file_path );
        update_option( $import['option_name'], json_decode( $file_raw, true ) );
      }

    } else if( ! empty( $import_files[$selected_index]['local_import_json'] ) ) {

      foreach( $import_files[$selected_index]['local_import_json'] as $index => $import ) {
        $file_path = $import['file_path'];
        $file_raw  = OCDI\Helpers::data_from_file( $file_path );
        update_option( $import['option_name'], json_decode( $file_raw, true ) );
      }

    }

  }
  add_action('ocdi/after_content_import_execution', 'prefix_after_content_import_execution', 3, 99 );
}

/**
 *
 * Get import data from library
 *
 */
function the4_get_demo_library()
{
  $cache_key = 'the4_get_demo_library' . THE4_KALLES_VERSION;


  $data = get_transient( $cache_key );

  $time_out = 8;

  $evanto_key = get_option( 'envate_purchase_code_kalleswp' );
  $domain = t4_get_site_url();

  $api_url = 'https://wp.the4.co/data-import/?evanto_key=' . $evanto_key . '&domain=' . $domain;

  if ( empty ( $data ) ) {
    $response = wp_remote_get( $api_url, [
      'timeout' => $time_out,
      'body' => [
        'api_version' => THE4_KALLES_VERSION
      ]
    ] );

    if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
      set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

      return false;
    }

    $data = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( empty( $data ) || ! is_array( $data ) ) {

      set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

      return false;
    }

    set_transient( $cache_key, $data, 12 * HOUR_IN_SECONDS );

  }

  return $data;
}

/**
 *
 * Get import data
 *
 */
function the4_ocdi_import_files() {
  if ( class_exists( 'The4_Admin_Activation') ) {

    $isActive = The4_Admin_Activation::isActive();

    if ( $isActive ) {
      $demo_library = the4_get_demo_library();
      return $demo_library;
    }
  }
  return [];
}


add_filter( 'pt-ocdi/import_files', 'the4_ocdi_import_files' );

/**
 *
 * Action after import content
 *
 */

function the4_ocdi_after_content_import( $selected_import ) {

  $selected_import_files = $selected_import['import_file_name'];

  $home_option = t4_ocdi_get_home_option( $selected_import_files );

  //Select home page
  //
  if ( $home_option['home'] ) {
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $home_option['home']->ID );
  }

  //Import RevSlider
  $home_none_slider = array (
    'Home Video Banner',
    'Home Categories Link',
    'Home Ken Burns Slider',
    'Home LookBook',
    'Home Parallax',
    'Home Instagram Shop',
    'Home Decor 2',
    'Home Fashion Trend',
    'One Product Store',

  );
  if ( ! in_array( $selected_import_files, $home_none_slider ) && $home_option['slider'] ) {
    the4_ocdi_setup_revslider( $home_option['slider'] );
  }

  //Assign menu location
  the4_ocdi_setup_menu_location();

}

add_action( 'ocdi/after_import', 'the4_ocdi_after_content_import' );

/**
 *
 * Import Rev Slider after import content
 *
 */

function the4_ocdi_setup_revslider( $home = 'home-default' ) {

    $rev_import_file = t4_ocdi_download_revslider_file( $home );

    if ( ! $rev_import_file ) {
      return;
    }

    if ( class_exists( 'RevSliderSliderImport' ) ) {

      $rev_slider = new RevSliderSliderImport();
      $rev_slider->import_slider( true, $rev_import_file );

    } else {

      $rev_slider = new RevSlider();
      $rev_slider->importSliderFromPost( true, true, $rev_import_file );

    }
}

/**
 *
 * Setup default menu location
 *
 */
function the4_ocdi_setup_menu_location( ) {
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $left_menu = get_term_by( 'name', 'Left', 'nav_menu' );
    $right_menu = get_term_by( 'name', 'Right Menu', 'nav_menu' );
    $categories_menu = get_term_by( 'name', 'Categories Home menu', 'nav_menu' );
    $top_categories_menu = get_term_by( 'name', 'Top Categories Menu', 'nav_menu' );
    $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

    if ( $main_menu ) {
        set_theme_mod( 'nav_menu_locations', array (
            'primary-menu' => $main_menu->term_id,
            'left-menu' => $left_menu->term_id,
            'right-menu' => $right_menu->term_id,
            'categories-menu' => $categories_menu->term_id,
            'categories-top-menu' => $top_categories_menu->term_id,
            'footer-menu' => $footer_menu->term_id,
            'categories-mobile-menu' => $categories_menu->term_id
          )
        );
    }
}




/**
 *
 * Register plugin
 *
 */

function the4_ocdi_register_plugins( $plugins ) {
  $theme_plugins = [
    [ // A WordPress.org plugin repository example.
      'name'     => 'Elementor', // Name of the plugin.
      'slug'     => 'elementor', // Plugin slug - the same as on WordPress.org plugin repository.
      'required' => true,                     // If the plugin is required or not.
    ],
    [
      'name'        => 'Kalles Addon',
      'description' => 'Kalles core by The4',
      'slug'        => 'kalles-addons',  // The slug has to match the extracted folder from the zip.
      'source'      => 'https://wp.the4.co/plugin/kalles-addons.zip',
      'preselected' => true,
      'required' => true,
    ],
    [
      'name'        => 'The4 Elementor Pack',
      'description' => 'Elementor online library section, template',
      'slug'        => 'the4-elementor-pack',  // The slug has to match the extracted folder from the zip.
      'source'      => 'https://wp.the4.co/plugin/the4-elementor-pack.zip',
      'preselected' => true,
      'required' => false,
    ],
    [ // A WordPress.org plugin repository example.
      'name'     => 'WooCommerce', // Name of the plugin.
      'slug'     => 'woocommerce', // Plugin slug - the same as on WordPress.org plugin repository.
      'required' => true,                     // If the plugin is required or not.
      'preselected' => true
    ],
    [
      'name'        => 'Slider Revolution',
      'description' => 'Create slider with Revolution',
      'slug'        => 'revslider',  // The slug has to match the extracted folder from the zip.
      'source'      => 'https://wp.the4.co/plugin/revslider.zip',
      'preselected' => true,
      'required' => false,
    ],
    [
      'name'        => 'MailChimp',
      'slug'        => 'mailchimp-for-wp',  // The slug has to match the extracted folder from the zip.
      'description' => 'Mailchimp for WordPress, the #1 unofficial Mailchimp plugin',
      'preselected' => true,
    ],
    [
      'name'        => 'Pin maker',
      'description' => 'Create product Pin',
      'slug'        => 'pin-maker',  // The slug has to match the extracted folder from the zip.
      'source'      => 'https://wp.the4.co/plugin/pin-maker.zip',
      'preselected' => false,
    ],
    [
      'name'        => 'WPA WooCommerce Product Bundle',
      'description' => 'Create bundle product',
      'slug'        => 'wpa-woocommerce-product-bundle',  // The slug has to match the extracted folder from the zip.
      'source'      => 'https://wp.the4.co/plugin/wpa-woocommerce-product-bundle.zip',
      'preselected' => false,
    ],

    [
      'name'        => 'Smash Balloon Instagram Feed',
      'description' => 'Display Instagram posts from your Instagram accounts, either in the same single feed or in multiple different ones.',
      'slug'        => 'instagram-feed',  // The slug has to match the extracted folder from the zip.
      'preselected' => false,
    ],
    [
      'name'        => 'Ryviu',
      'slug'        => 'ryviu',  // The slug has to match the extracted folder from the zip.
      'description' => 'Product Reviews for WooCommerce',
      'preselected' => false,
    ],
    [
      'name'        => 'MyShopKit Popup SmartBar SlideI',
      'slug'        => 'myshopkit-popup-smartbar-slidein',  // The slug has to match the extracted folder from the zip.
      'description' => 'MyShopKit Popup SmartBar SlideIn has every features for Popups, Smartbars and Slide In to grow up your email list, create promo banners or make
announcement',
      'preselected' => false,
    ],
  ];

  return array_merge( $plugins, $theme_plugins );
}
add_filter( 'ocdi/register_plugins', 'the4_ocdi_register_plugins' );

function t4_ocdi_download_revslider_file( $home ) {

  $revslider_url = 'https://wp.the4.co/plugin/revslider/slider/' . $home .'.zip';

  try {
    $download_file_zip = download_url( $revslider_url );

    if ( is_wp_error( $download_file_zip ) ) return false;
  } catch ( Exeption $e ) {
    return false;
  }

  return $download_file_zip;
}


function t4_ocdi_get_home_option( $import_file_name ) {

  return array(
    'home'   => get_page_by_title( $import_file_name ),
    'slider' => t4_ocdi_get_slider( $import_file_name ),
    'menu' => ''
  );
}

function t4_ocdi_get_slider( $import_file_name ) {
  return strtolower( str_replace( ' ', '-' , $import_file_name) );
}


