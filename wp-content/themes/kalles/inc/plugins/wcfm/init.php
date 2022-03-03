<?php
/**
 * Integrations WCFM Plugin
 *
 * @since   1.0.2
 * @package Kalles
 */

function kalles_wcfm_script() {
	if ( ! wp_script_is( 'wcfm_core_js' ) ) {
		return;
	}

	global $WCFM, $wp, $WCFM_Query;
	if ( isset( $WCFM ) && isset( $WCFM_Query ) ) {
		
		if ( is_wcfm_page() ) {
			return;
		}
		
		wp_dequeue_script( 'wcfm_core_js' );

		wp_enqueue_script( 'wcfm_core_js_kalles', THE4_KALLES_URL . '/assets/vendors/wcfm/wcfm-script-core.min.js', array(), false, true );

			if( isset( $_REQUEST['fl_builder'] ) ) return;
			
			// Libs
	  //$WCFM->library->load_qtip_lib();
	  
	  // Block UI
	  if( apply_filters( 'wcfm_is_allow_blockui', true ) ) {
	  	$WCFM->library->load_blockui_lib();
	  }
	  
	  // Colorbox
	  //$WCFM->library->load_colorbox_lib();
	  
	  // Date Picker
	  $WCFM->library->load_datepicker_lib();
			
	  
	  // Localized Script
	  if( apply_filters( 'wcfm_is_allow_sound', true ) ) {
			if( apply_filters( 'wcfm_is_allow_notification_sound', true ) ) {
				wp_localize_script( 'wcfm_core_js', 'wcfm_notification_sound', array( 'file' => apply_filters( 'wcfm_notification_sound', $WCFM->library->lib_url . 'sounds/notification.mp3' ) ) );
			} else {
				//wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_notification_sound', $WCFM->library->lib_url . 'sounds/empty_audio.mp3' );
			}
			if( apply_filters( 'wcfm_is_allow_new_message_check', false ) && apply_filters( 'wcfm_is_allow_desktop_notification', true ) && apply_filters( 'wcfm_is_allow_desktop_notification_sound', true ) ) {
				wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_desktop_notification_sound', array( 'file' => apply_filters( 'wcfm_desktop_notification_sound', $WCFM->library->lib_url . 'sounds/desktop_notification.mp3' ) ) );
			} else {
				//wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_desktop_notification_sound', $WCFM->library->lib_url . 'sounds/empty_audio.mp3' );
			}
		} else {
			//wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_notification_sound', $WCFM->library->lib_url . 'sounds/empty_audio.mp3' );
		}
		
		$wcfm_dashboard_messages = get_wcfm_dashboard_messages();
		wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_core_dashboard_messages', $wcfm_dashboard_messages );
	  
		$unread_message = 0;
		$unread_enquiry = 0;
		if( apply_filters( 'wcfm_is_allow_new_message_check', false ) ) {
			$unread_message = $WCFM->wcfm_notification->wcfm_direct_message_count( 'message' );
			$unread_enquiry = $WCFM->wcfm_notification->wcfm_direct_message_count( 'enquiry' );
		}
		
		$ajax_url = WC()->ajax_url();
		if ( defined( 'ICL_SITEPRESS_VERSION' ) && ! ICL_PLUGIN_INACTIVE && class_exists( 'SitePress' ) ) {
			global $sitepress;
			$language_code = $sitepress->get_current_language();
			$ajax_url = add_query_arg( array( 'lang' => $sitepress->get_current_language() ), $ajax_url );
			
		}
	  
	  // Localize Script
	  $tinyMCE_toolbar_options = 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify |  bullist numlist outdent indent | link image | ltr rtl';
	  wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_params', array( 'ajax_url'                                 => $ajax_url, 
	  																													'wc_ajax_url'                              => WC()->ajax_url(), 
	  	                                                        'shop_url'                                 => get_permalink( wc_get_page_id( 'shop' ) ), 
	  	                                                        'wcfm_is_allow_wcfm'                       => wcfm_is_allow_wcfm(), 
	  	                                                        'wcfm_is_vendor'                           => wcfm_is_vendor(), 
	  	                                                        'is_user_logged_in'                        => is_user_logged_in(), 
	  	                                                        'wcfm_allow_tinymce_options'               => apply_filters( 'wcfm_allow_tinymce_options', $tinyMCE_toolbar_options ),
	  	                                                        'unread_message'                           => $unread_message, 
	  	                                                        'unread_enquiry'                           => $unread_enquiry, 
	  	                                                        'wcfm_is_allow_new_message_check'          => apply_filters( 'wcfm_is_allow_new_message_check', false ),
	  	                                                        'wcfm_new_message_check_duration'          => apply_filters( 'wcfm_new_message_check_duration', 60000 ),
	  	                                                        'wcfm_is_desktop_notification'             => apply_filters( 'wcfm_is_allow_desktop_notification', true ), 
	  	                                                        'is_mobile_desktop_notification'           => apply_filters( 'wcfm_is_allow_mobile_desktop_notification', false ),
	  	                                                        'wcfm_is_allow_external_product_analytics' => apply_filters( 'wcfm_is_allow_external_product_analytics', false ),
	  	                                                        'is_mobile'                                => wcfm_is_mobile(),
	  	                                                        'is_tablet'                                => wcfm_is_tablet(),
	  	                                                        'wcfm_ajax_nonce'                          => wp_create_nonce( 'wcfm_ajax_nonce' )
	  	                                                       ) );
	  
	  // Inquery Localized Script
		$wcfm_inquiry_messages = get_wcfm_enquiry_manage_messages();
		wp_localize_script( 'wcfm_core_js_kalles', 'wcfm_enquiry_manage_messages', $wcfm_inquiry_messages );
		
		// WCFM Ultimate Localize Script
	  $wcfm_core_messages = get_wcfm_products_manager_messages();
		wp_localize_script( 'wcfm_core_js_kalles', 'wcfmu_products_manage_messages', $wcfm_core_messages );
	  
	  
	  // Load End Point Scripts
	  if( is_wcfm_page() ) {
			if ( isset( $wp->query_vars['page'] ) ) {
				$WCFM->library->load_scripts( 'wcfm-dashboard' );
			} else {
				$wcfm_endpoints = $WCFM_Query->get_query_vars();
				$is_endpoint = false;
				foreach ( $wcfm_endpoints as $key => $value ) {
					if ( isset( $wp->query_vars[ $key ] ) ) {
						$WCFM->library->load_scripts( $key );
						$is_endpoint = true;
					}
				}
				if( !$is_endpoint ) {
					// Load dashboard Scripts
					$WCFM->library->load_scripts( 'wcfm-dashboard' );
				}
			}
		}
	}
}

add_action( 'wp_enqueue_scripts', 'kalles_wcfm_script', 281991 );