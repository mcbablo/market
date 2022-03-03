<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
if ( isset( $_GET['post'] ) && $_GET['post'] == get_option( 'page_for_posts' ) ) return;

// -----------------------------------------
// Page Metabox Options                    -
// -----------------------------------------

if( class_exists( 'CSF' ) ) {
	$page_prefix = '_custom_page_options';

	 CSF::createMetabox( $page_prefix, array(
	    'title'              => esc_html__( 'Page Layout Options','kalles'),
	    'post_type'          => 'page',
	    'context'            => 'normal',
	    'priority'           => 'high'
	  ) );
	 CSF::createSection( $page_prefix, array(
	 	'id'  => 's1',
	    'fields' => array(
				array(
					'id'      => 'page-layout',
					'type'    => 'image_select',
					'title'   => esc_html__( 'Page Layout', 'kalles' ),
					'radio'   => true,
					'options' => array(
						'left-sidebar'  => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/left-sidebar.png',
						'no-sidebar'    => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/no-sidebar.png',
						'right-sidebar' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/right-sidebar.png',
					),
					'default' => 'no-sidebar',
				),
				array(
					'id'         => 'page-sidebar',
					'type'       => 'select',
					'title'      => esc_html__( 'Select Sidebar', 'kalles' ),
					'options'    => 'sidebars',
					'dependency' => array( 'page-layout', '!=', 'no-sidebar' ),
					'default'    => 'primary-sidebar'
				),
				array(
					'id'      => 'pagehead',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable page title', 'kalles' ),
					'default' => true
				),
				array(
					'id'         => 'subtitle',
					'type'       => 'switcher',
					'title'      => esc_html__( 'Enable sub-title', 'kalles' ),
					'default'    => true,
					'dependency' => array( 'pagehead', '==', 'true' ),
				),
				array(
					'id'         => 'title',
					'type'       => 'text',
					'title'   		=> esc_html__( 'Sub Title', 'kalles' ),
					'attributes' => array(
						'placeholder' => esc_html__( 'Do Stuff', 'kalles' )
					),
					'dependency' => array( 'pagehead|subtitle', '==|==', 'true|true' ),
				),
				array(
					'id'      => 'breadcrumb',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable breadcrumb', 'kalles' ),
					'default' => false
				),
			),
	  ) );

	 $product_prefix = '_custom_wc_options';

	 CSF::createMetabox( $product_prefix, array(
	    'title'              => esc_html__( 'Product Layout Options','kalles'),
	    'post_type'          => 'product',
	    'context'            => 'normal',
	    'priority'           => 'high'
	  ) );
	 CSF::createSection( $product_prefix, array(
	 	'id'  => 's2',
	    'fields' => array(
				array(
					'id'    => 'wc-single-style',
					'type'  => 'image_select',
					'title' => esc_html__( 'Product Detail Style', 'kalles' ),
					'info'  => sprintf( __( 'Change layout for only this product. You can setup global for all product page layout at <a target="_blank" href="%1$s">here</a> (WooCommerce section).', 'kalles' ), esc_url( admin_url( 'admin.php?page=the4-theme-options' ) ) ),
					'options' => array(
						'1' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-1.png',
						'2' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-2.png',
						'3' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-3.png',
						'4' => THE4_KALLES_CS_FRAMEWORK_URL . '/assets/images/layout/product-4.png',
					),
				),
				array(
					'id'      => 'wc-thumbnail-position',
					'type'    => 'select',
					'title'   => esc_html__( 'Thumbnail Position', 'kalles' ),
					'options' => array(
						'left'    => esc_html__( 'Left', 'kalles' ),
						'bottom'  => esc_html__( 'Bottom', 'kalles' ),
						'right'   => esc_html__( 'Right', 'kalles' ),
						'outside' => esc_html__( 'Outside', 'kalles' )
					),
					'default'    => 'left',
					'dependency' => array( 'wc-single-style', '==', '1' ),
				),
				array(
					'title'	  => esc_html__( 'Video Thumbnail', 'kalles'),
					'info'    => esc_html__( 'Support Vimeo & Youtube', 'kalles'),
					'id'      => 'wc-single-video',
					'type'    => 'select',
					'options' => array(
						'url'    => esc_html__( 'Url', 'kalles' ),
						'upload' => esc_html__( 'Self Hosted', 'kalles' )					),
					'default' => 'url',
				),
				array(
					'id'         => 'wc-single-video-upload',
					'type'       => 'upload',
					'title'      => esc_html__( 'Upload Video Thumbnail', 'kalles' ),
					'dependency' => array( 'wc-single-video', '==', 'upload' ),
					'settings'   => array(
						'upload_type'  => 'video',
						'button_title' => esc_html__( 'Video', 'kalles' ),
						'frame_title'  => esc_html__( 'Select a video', 'kalles' ),
						'insert_title' => esc_html__( 'Use this video', 'kalles' ),
					),
				),
				array(
					'id'         => 'wc-single-video-url',
					'type'       => 'text',
					'title'      => esc_html__( 'Video Thumbnail Link', 'kalles' ),
					'dependency' => array( 'wc-single-video', '==', 'url' ),
				),
				array(
					'title'   => esc_html__( 'New Arrival Product', 'kalles'),
					'id'      => 'wc-single-new-arrival',
					'type'    => 'number',
					'default' => 5,
					'info'    => esc_html__( 'Set number of days display new arrivals badge for product.', 'kalles' ),
				),
				array(
					'title' => esc_html__( 'Size Guide Image','kalles'),
					'id'    => 'wc-single-size-guide',
					'type'  => 'upload',
					'info'  => sprintf( __( 'Upload size guide image for only this product. You can use image size guide for all product at <a target="_blank" href="%1$s">here</a> (WooCommerce section).', 'kalles' ), esc_url( admin_url( 'admin.php?page=the4-theme-options' ) ) ),
				),
			),
	  ) );
	 $product_thumb_prefix = '_custom_wc_thumb_options';

	 CSF::createMetabox( $product_thumb_prefix, array(
	    'title'              => esc_html__( 'Thumbnail Size','kalles'),
	    'post_type'          => 'product',
	    'context'            => 'side',
	    'priority'           => 'default'
	  ) );
	 CSF::createSection( $product_thumb_prefix, array(
	 	'id'  => 's3',
	    'fields' => array(
				array(
					'id'      => 'wc-thumbnail-size',
					'type'    => 'switcher',
					'title'   => esc_html__( 'Enable Large Thumbnail', 'kalles' ),
					'desc'    => esc_html__( 'Apply for Product Layout Metro only', 'kalles' ),
					'default' => false
				),
			),
	  ) );
}
