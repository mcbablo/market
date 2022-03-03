<?php

namespace The4;

use The4;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class The4ElementorPack {

	/**
	 * Plugin Instance
	 * @var The4\The4ElementorPack
	 * 
	 */
	private static $_instance = null;

	/**
	 * Plugin Instance
	 * @return The4ElementorPack
	 * 
	 */
	public static function instance()
	{
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct()
	{
		
	}

	public function init()
	{
		add_action( 'elementor/editor/footer', [ __CLASS__, 'register_script' ], 99 );
		add_action( 'elementor/editor/before_enqueue_scripts', [ __CLASS__, 'register_script' ] );
		add_action( 'elementor/preview/enqueue_styles', [ __CLASS__, 'register_style' ] );
		add_action( 'elementor/editor/footer', [ __CLASS__, 'register_template' ] );

		add_action( 'elementor/editor/footer', [ __CLASS__, 'register_localize_script' ], 100 );
		//Ajax
		add_action( 'wp_ajax_the4-load-template', [ __CLASS__, 'load_template' ] );

		add_action( 'elementor/ajax/register_actions', [ __CLASS__, 'sync_library_ajax_actions' ]  );
	}

	public static function register_script()
	{
		wp_enqueue_script( 'elementor-page', THE4_ADDONS_URL . 'assets/js/elementor-page.js', [ 'jquery', 'wp-util', 'elementor-editor', 'masonry', 'imagesloaded' ], THE4_ELEMENTOR_PACK_VER, true );
		wp_enqueue_script( 'the4-lazyload', THE4_ADDONS_URL . 'assets/js/lazysite.min.js', THE4_ELEMENTOR_PACK_VER, true );
		wp_enqueue_style( 'the4-elementor-pack', THE4_ADDONS_URL . 'assets/css/the4-elementor-pack.css' );

		wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'imagesloaded' );
	}

    public static function register_style()
    {
        wp_enqueue_style( 'the4-elementor-pack', THE4_ADDONS_URL . 'assets/css/the4-elementor-pack.css' );
    }

	public static function register_template()
	{	
		ob_start();

		require_once THE4_ELEMENTOR_PACK_EDITOR_TEMPLATE_PATH . '/template.php';
		require_once THE4_ELEMENTOR_PACK_EDITOR_TEMPLATE_PATH . '/header.php';
		require_once THE4_ELEMENTOR_PACK_EDITOR_TEMPLATE_PATH . '/items-list.php';
		require_once THE4_ELEMENTOR_PACK_EDITOR_TEMPLATE_PATH . '/single-view.php';

		ob_end_flush();
	}

	public static function register_localize_script()
	{
		$libary = The4LibraryApi::instance();
		$script_data = apply_filters(
			'the4_localize_script',
			array(
				'layouts' => $libary->get_items(),
				'categories' => $libary->get_categories_blog(),

			)
		);

		wp_localize_script( 'elementor-page', 'the4ElementorData', $script_data );
	}

	public static function sync_library_ajax_actions( Ajax $ajax)
	{
		$ajax->register_ajax_action( 'the4_elementor_sync_library', function( $data ) {
			$libary = The4LibraryApi::instance();
			return $libary->get_items( true );
		});
	}
}