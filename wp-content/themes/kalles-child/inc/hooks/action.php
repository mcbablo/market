<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Action hooks.
 *
 * @since   1.0.0
 * @package Kalles
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_setup' ) ) {
	function the4_kalles_setup() {
		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * @since 1.0.0
		 */
		$GLOBALS['content_width'] = apply_filters( 'kalles_content_width', 1200 );

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /language/ directory.
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'kalles', THE4_KALLES_PATH . '/language' );

		/**
		 * Add theme support.
		 *
		 * @since 1.0.0
		 */
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'woocommerce' );
		/**
		 * Register theme location.
		 *
		 * @since 1.0.0
		 */
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'kalles' ),
                'primary-menu-sidebar' => esc_html__( 'Primary Menu Sidebar', 'kalles' ),
				'left-menu'    => esc_html__( 'Left Menu', 'kalles' ),
				'right-menu'   => esc_html__( 'Right Menu', 'kalles' ),
				'categories-menu'  => esc_html__( 'Categories Menu', 'kalles' ),
				'categories-top-menu'  => esc_html__( 'Top Categories Menu In Shop', 'kalles' ),
				'footer-menu'  => esc_html__( 'Footer Menu', 'kalles' ),
                'categories-mobile-menu'  => esc_html__( 'Categories Mobile Menu', 'kalles' ),
                'mobile-menu'  => esc_html__( 'Mobile Menu', 'kalles' ),
			)
		);

		// Tell TinyMCE editor to use a custom stylesheet.
		add_editor_style( THE4_KALLES_URL . '/assets/css/editor-style.css' );
	}
}
add_action( 'after_setup_theme', 'the4_kalles_setup' );

/**
 * Register widget area.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_register_sidebars' ) ) {
	function the4_kalles_register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'kalles' ),
				'id'            => 'primary-sidebar',
				'description'   => esc_html__( 'The Primary Sidebar', 'kalles' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title fwm">',
				'after_title'   => '</h4>',
			)
		);
		for ( $i = 1, $n = 5; $i <= $n; $i++ ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Area #', 'kalles' ) . $i,
					'id'            => 'footer-' . $i,
					'description'   => sprintf( esc_html__( 'The #%s column in footer area', 'kalles' ), $i ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title fwsb fs__16 mg__0 mb__30">',
					'after_title'   => '</h3>',
				)
			);
		}
        register_sidebar(
            array(
                'name'          => esc_html__( 'Footer Mobile Area', 'kalles' ),
                'id'            => 'footer-mobile',
                'description'   => esc_html__( 'Footer Mobile Area', 'kalles' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title fwsb fs__16 mg__0 mb__30">',
                'after_title'   => '</h3>',
            )
        );
	}
}
add_action( 'widgets_init', 'the4_kalles_register_sidebars' );

// deactivate new block editor
function the4_disable_new_widget() {
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'the4_disable_new_widget' );

/**
 * Add Menu Page Link.
 *
 * @return void
 * @since  1.0.0
 */
if ( ! function_exists( 'the4_kalles_add_framework_menu' ) ) {
	function the4_kalles_add_framework_menu() {

		$title  = apply_filters( 't4_admin_menu_title', 'The4 Dashboard');
		$icon 	= apply_filters( 't4_admin_menu_icon', THE4_KALLES_URL . '/assets/images/icons/fw-icon.png');

		add_menu_page(
			$title,
			$title,
			'edit_theme_options',
			'the4-dashboard',
			'the4_dashboard_manager',
			$icon,
			'3' );
		add_submenu_page( 'the4-dashboard', 'The 4', 'Dashboard', 'edit_theme_options', 'the4-dashboard', 'the4_dashboard_manager' );

	}
}
add_action( 'admin_menu', 'the4_kalles_add_framework_menu', 1 );


/**
 * Admin Dashboard view
 *
 * @return void
 * @since  1.0.0
 */
if ( !function_exists('the4_dashboard_manager') ) {
	function the4_dashboard_manager() {
		if ( file_exists( THE4_KALLES_ADMIN_PATH . '/classes/admin_dashboard.php') ) {
			require_once THE4_KALLES_ADMIN_PATH . '/classes/admin_dashboard.php';
		}
	}
}




/**
 * Redirect to under construction page
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'the4_kalles_offline' ) ) {
	function the4_kalles_offline() {
		// Check if under construction page is enabled
		if ( cs_get_option( 'maintenance' ) ) {


			if ( ! is_feed() ) {
				// Check if user is not logged in
				if ( ! is_user_logged_in() ) {
					
					kalles_maintenance_mode();
				}
			}

			// Check if user is logged in
			if ( is_user_logged_in() ) {
				global $current_user;

				// Get user role
				wp_get_current_user();

				$loggedInUserID = $current_user->ID;
				$userData = get_userdata( $loggedInUserID );

				// If user role is not 'administrator' then redirect to under construction page
				if ( 'administrator' != $userData->roles[0] ) {
					if ( ! is_feed() ) {
						include THE4_KALLES_PATH . '/views/pages/offline.php';
						exit;
					}
				}
			}
		}
	}
}
add_action( 'template_redirect', 'the4_kalles_offline' );

if ( ! function_exists('kalles_maintenance_mode') ) {
	function kalles_maintenance_mode() {
		$type = cs_get_option('maintenance-type') ? cs_get_option('maintenance-type') : 'custom';
		$page = get_pages( array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'offline.php'
		));

		if ( $type == 'page' && ! empty( $page ) ) {

			$page_id = $page[0]->ID;

	        if ( ! $page_id ) {
				return;
			}

			if ( ! is_page( $page_id ) ) {
	            wp_redirect( get_permalink( $page_id ) );
	            exit();
	        }


		} else {
			include THE4_KALLES_PATH . '/views/pages/offline.php';
			exit;
		}
	}
}
/**
 * Custom social share iamge
 *
 * @since 1.1.3
 */
if ( ! function_exists( 'the4_kalles_social_meta' ) && ! function_exists( 'wpseo_activate' ) && ! class_exists('RankMath') )  {
	function the4_kalles_social_meta() {
		global $post;
        global $allowedtags;

        $alltags = (array)$allowedtags + array(
            'meta' => array(
                'itemprop' => array(),
                'content' => array(),
                'name' => array(),
                'property' => array(),
            ),
        );

		if ($post) {
			$output = '';
			$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );

			$output .= '<meta itemprop="name" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
			$output .= '<meta itemprop="description" content="' . esc_attr( strip_tags( $post->the_excerpt ) ) . '">';
			$output .= '<meta itemprop="image" content="' . esc_url( $image_src_array[0] ) . '">';

			$output .= '<meta name="twitter:card" content="summary_large_image">';
			$output .= '<meta name="twitter:site" content="@' . str_replace( ' ', '', get_bloginfo( 'name' ) ) . '">';
			$output .= '<meta name="twitter:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
			$output .= '<meta name="twitter:description" content="' . esc_attr( strip_tags( $post->the_excerpt ) ) . '">';
			$output .= '<meta name="twitter:creator" content="@' . str_replace( ' ', '', get_bloginfo( 'name' ) ) . '">';
			$output .= '<meta name="twitter:image:src" content="' . esc_url( $image_src_array[0] ) . '">';

			$output .= '<meta property="og:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '" />';
			$output .= '<meta property="og:url" content="' . esc_url( get_permalink() ) . '" />';
			$output .= '<meta property="og:image" content="' . esc_url( $image_src_array[0] ) . '" />';
			$output .= '<meta property="og:image:url" content="' . $image_src_array[ 0 ] . '"/>'. "\n";
			$output .= '<meta property="og:description" content="' . esc_attr( strip_tags( $post->the_excerpt ) ) . '" />';
			$output .= '<meta property="og:site_name" content="' . get_bloginfo( 'name') . '" />';

			if ( function_exists( 'is_product' ) && is_product() ) {
				$output .= '<meta property="og:type" content="product"/>'. "\n";
			} else {
				$output .= '<meta property="og:type" content="article"/>'. "\n";
			}

			echo force_balance_tags( wp_kses($output, $alltags) );
		}
	}
	add_action( 'wp_head', 'the4_kalles_social_meta', 0 );
}
/**
 * Custom redirect page after Woocommere login
 *
 * @since 1.0
 */
if (!function_exists('the4_woocommere_login_page') && class_exists( 'WooCommerce' )) {
    function the4_woocommere_login_page() {
        return wc_get_page_permalink( 'myaccount' );
    }
    add_filter('woocommerce_login_redirect', 'the4_woocommere_login_page');
}

/**
 * Custom redirect page after Woocommere Register
 *
 * @since 1.0
 */
if (!function_exists('the4_woocommere_register_page') && class_exists( 'WooCommerce' )) {
    function the4_woocommere_register_page() {
        return wc_get_page_permalink( 'myaccount' );
    }
    add_filter( 'woocommerce_registration_redirect', 'the4_woocommere_register_page' );
}

/**
 * Newsletter popup function
 *
 * @since 1.0
 */
if ( ! function_exists('the4_newslettter_popup') && defined( 'MC4WP_VERSION' ) ) {
	function the4_newslettter_popup() {

		$page_dispay           = cs_get_option( 'wc_newsletter_popup-page' );
		$body_class = get_body_class();
		$check_page = is_array( $page_dispay ) ? array_intersect($page_dispay, $body_class) : true;
		$display = 0;
		if ( is_array( $page_dispay ) ) {
		    if (in_array('all', $page_dispay) || !empty($check_page)) $display = 1;
		} else {
		    $display = 1;
		}

		if ( $display == 1 ) {
		$image          = cs_get_option( 'wc_newsletter_popup-image' );
		$image_src 		= isset(  $image[ 'id' ] ) ? wp_get_attachment_image_src( $image[ 'id' ], 'full' ) : '';
        $bg_image       = cs_get_option('wc_newsletter_popup-image') ? cs_get_option('wc_newsletter_popup-image') : '';
		$heading        = cs_get_option( 'wc_newsletter_popup-heading' );
		$subheading     = cs_get_option( 'wc_newsletter_popup-subheading' );
		$mailchimp_form = cs_get_option( 'wc_newsletter_popup-form' );
		$text2          = cs_get_option( 'wc_newsletter_popup-text2' );
		$anymore        = cs_get_option( 'wc_newsletter_popup-anymore' );
		$text3          = cs_get_option( 'wc_newsletter_popup-text3' );
		$layout         = cs_get_option( 'wc_newsletter_popup-layout' );

		$version        = cs_get_option( 'wc_newsletter_popup-version' );
		$day_next       = cs_get_option( 'wc_newsletter_popup-day_next' );
		$show_type      = cs_get_option( 'wc_newsletter_popup-show_type' );
		$time_delay     = cs_get_option( 'wc_newsletter_popup-time_delay' );
		$scroll_unit    = cs_get_option( 'wc_newsletter_popup-scroll_unit' );
		$form_style 	= cs_get_option( 'wc_newsletter_popup-form_style' );
		$mobile 		= cs_get_option( 'wc_newsletter_popup-mobile' ) ? 'true' : 'false';

		$class_cl = $layout == '1' ? '12' : '6';

		$bg_style = '';
		if ( isset( $image_src[0] ) ) {
			$ratio = $image_src[1] / $image_src[2] * 100;

			if ( $layout == '1' ) $ratio = 0;

			$bg_style = kalles_image_lazyload_class( true ) ? 'data-bgset="' . $image_src[0] .'" style="padding-top: '. $ratio .'%;"' : 'style="background-image: url('. $image_src[0] .');padding-top: '. $ratio .'%; "';
		}

		$form_class = 'flex t4-mailchimp-form fl_';

		?>
		<div class="popup_new_wrap container new_pp_des_<?php echo esc_attr( $layout ); ?> bgw mfp-with-anim mfp-hide mobile_new_<?php echo esc_attr( $mobile ); ?>"
			data-stt='{
				"pp_version": <?php echo esc_attr( $version ); ?>,
				"after": "<?php echo esc_attr( $show_type ); ?>",
				"time_delay": <?php echo esc_attr( $time_delay ); ?>000,
				"scroll_delay": <?php echo esc_attr( $scroll_unit ); ?>,
				"day_next": <?php echo esc_attr( $day_next ); ?>
			}'>
			<div class="row no-gutters al_center fl_center">
				<?php if ( $layout == 2 ) : ?>
			  	<div class="col-12 col-md-<?php echo esc_attr( $class_cl ); ?>">
			    	<div class="popup_new_img lazyload pr_lazy_img pr_lazy_img_bg" <?php if (!empty($bg_image['url'])) echo 'data-bgset="' . $bg_image['url'] .'" data-parent-fit="width" data-sizes="auto" style="padding-top: ' . ( 1 / ( $bg_image['width'] / $bg_image['height']) ) * 100 . '%"'; ?>>
			    	</div>
			  	</div>
			  	<?php endif; ?>

			  	<?php if ( $layout == 1 ) : ?>
			  		<div class="col-12 col-md-<?php echo esc_attr( $class_cl ); ?> tc lazyload pr_lazy_img pr_lazy_img_bg" <?php if (!empty($bg_image['url'])) echo 'data-bgset="' . $bg_image['url'] .'" data-parent-fit="width" data-sizes="auto" style="padding-top: ' . ( 1 / ( $bg_image['width'] / $bg_image['height']) ) * 100 . '%"'; ?> >
			  	<?php else : ?>
			  		<div class="col-12 col-md-<?php echo esc_attr( $class_cl ); ?> tc">
			  	<?php endif; ?>
			    	<div class="popup_new_content newl_des_1">
			      		<h3><?php echo esc_html( $heading ); ?></h3>
			      		<?php echo esc_html( $subheading ); ?>

			      		<?php if ( $mailchimp_form ) : ?>
				      		<div class="newsletter_se newl_des_<?php echo esc_attr( $form_style ); ?>">
								<?php echo do_shortcode( '[mc4wp_form id="' . esc_attr( $mailchimp_form ) . '" element_class="' . esc_attr( $form_class ) . '"]' ); ?>
							</div>
						<?php endif; ?>

			      		<div class="popup_new_footer"><?php echo esc_html( $text2 ); ?></div>

			      		<?php if ( $anymore ) : ?>

			      		<div class="popup_new_checkzone pr dib">
				        	<input type="checkbox" id="new_check_show" class="css_agree_ck mr__5">
				        	<label for="new_check_show"><?php echo esc_html( $text3 ); ?></label>
				        	<svg class="dn scl_selected">
				          		<use xlink:href="#scl_selected"></use>
				        	</svg>
				      	</div>

				      	<?php endif; ?>

			    	</div>
			  	</div>
			</div>
		</div>
		<?php
		} //Endif $display == 1
	}
if ( ! cs_get_option( 'maintenance' ) && cs_get_option( 'wc_newsletter_popup-enable' )) {
	add_action( 'wp_footer', 'the4_newslettter_popup' );
}


}


