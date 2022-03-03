<?php

namespace The4;


use Elementor\TemplateLibrary\Source_Base;
use Elementor\Api;
use Elementor\Plugin;

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class The4LibraryApi extends Source_Base {

	private static $_instance = null;

	const THE4_LIBRAY_KEY = 'the4_library_key';

	const THE4_TIMESTAMP_CACHE_KEY = 'the4_update_timestamp';


	/**
	 * API info URL.
	 *
	 * Holds the URL of the info API.
	 *
	 * @access public
	 * @static
	 *
	 * @var string API info URL.
	 */

	public static $_api_info_url = 'https://wp.the4.co/api2/templates.json';
	public static $_api_block_url = 'https://wp.the4.co/api2/templates/%s.json';
	/**
	 * Plugin Instance
	 * @var The4ElementorPack
	 *
	 */
	public static function instance()
	{
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Get template ID.
	 *
	 * Retrieve the template ID.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 */

	public function get_id() {
		return 'the4-library';
	}

		/**
	 * Get template title.
	 *
	 * Retrieve the template title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 */

	public function get_title() {
		return __( 'The4 Elementor Library');
	}

		/**
	 * Register template data.
	 *
	 * Used to register custom template data like a post type, a taxonomy or any
	 * other data.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 public function register_data(){

	 }

	 /**
	 * Get templates.
	 *
	 * Retrieve templates from the template library.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args Optional. Filter templates list based on a set of
	 *                    arguments. Default is an empty array.
	 */

	public function get_items( $args = [], $force_update = false ) {
		$data_library = self::get_template_data( $force_update );

		$templates = [];

		if ( ! empty( $data_library['templates'] ) ) {
			foreach ( $data_library['templates'] as $template_data ) {
				$templates[] = [
					'block_id' 	  => $template_data['id'],
					'title'       => $template_data['title'],
					'type'        => $template_data['type'],
					'thumbnail'   => $template_data['thumbnail'],
					'full'   	  => $template_data['full'],
					'tags'        => $template_data['tags'],
				];
			}
		}

		return $templates;
	}

	/**
	 * Get Library template.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Array()
	 */

	public static function get_template_data( $force_update = false )
	{

		$data_library = get_option( self::THE4_LIBRAY_KEY );
		
		$timestamp_update = get_transient( self::THE4_TIMESTAMP_CACHE_KEY );

		if ( $data_library ) {
			$data_library = unserialize( base64_decode( $data_library ) );
		}

		if ( $force_update || $data_library == false || $timestamp_update != 1 ) {
			
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_get( self::$_api_info_url, [
				'timeout' => $timeout,
			] );
			

			if ( is_wp_error( $response ) || (int) wp_remote_retrieve_response_code( $response ) != 200 ) {
				update_option( self::THE4_LIBRAY_KEY, [] );
				return false;
			}

			$data_library = json_decode( wp_remote_retrieve_body( $response ), true );
			

			if ( empty( $data_library ) || ! is_array( $data_library ) ) {

				update_option( self::THE4_LIBRAY_KEY, [] );
				
				return false;
			}
			
			set_transient( self::THE4_TIMESTAMP_CACHE_KEY, 1, 24 * 7 * HOUR_IN_SECONDS );
			update_option( self::THE4_LIBRAY_KEY, base64_encode( serialize( $data_library ) ), 'no' );
			
		}

		return $data_library;
	}

	/**
	 * Get block template
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $block_id
	 */

	public static function request_block_template( $block_id ) {
		$args = array(
			'site_lang'        => get_bloginfo( 'language' ),
			'home_url'         => trailingslashit( home_url() ),
			'template_version' => THE4_ELEMENTOR_PACK_VER
		);

		$body_args = apply_filters( 'elementor/api/get_templates/body_args', $args );
		$api_url = sprintf( self::$_api_block_url, $block_id );
		$response = wp_remote_get(
			$api_url,
			array(
				'body'    => $body_args,
				'timeout' => 15
			)
		);

		$data = wp_remote_retrieve_body( $response );

		return $data;
	}


	/**
	 * Get template.
	 *
	 * Retrieve a single template from the template library.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 */
	public function get_item( $template_id ){

	}

	/**
	 * Get template data.
	 *
	 * Retrieve a single template data from the template library.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args Custom template arguments.
	 */
	public function get_data( array $args ){

		$data = self::request_block_template( $args['data']['block_id'] );

		$data = json_decode( $data, true );
		if ( empty( $data ) || empty( $data['content'] ) ) {
			throw new \Exception( __( 'Template does not have any content') );
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id = $args['editor_post_id'];

		$document = Plugin::$instance->documents->get( $post_id );

		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}

	/**
	 * Get categories blogs
	 *
	 * Retrieve categories blogs template data from the template library.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 */

	public function get_categories_blog()
	{
		$libarry_data = self::get_template_data();

		return ( !empty( $libarry_data ) ? $libarry_data['tags'] : [] );
	}

	/**
	 * Delete template.
	 *
	 * Delete template from the database.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 */
	public function delete_template( $template_id ){

	}

	/**
	 * Save template.
	 *
	 * Save new or update existing template on the database.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $template_data The template data.
	 */
	public function save_item( $template_data ){

	}

	/**
	 * Update template.
	 *
	 * Update template on the database.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_data New template data.
	 */
	public function update_item( $new_data ){

	}

	/**
	 * Export template.
	 *
	 * Export template to a file.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 */
	public function export_template( $template_id ){

	}
}
