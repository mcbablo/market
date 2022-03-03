<?php

namespace The4;


use The4;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Plugin;

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class The4ImportTemplate {

	/**
     * Constructor
     * @since 1.0.0
	 *
     */
    
    public function __construct()
    {

    	add_action( 'elementor/ajax/register_actions', [ __CLASS__, 'import_template_ajax_actions' ]  );
    }

    /**
     * Ajax import template
     * @since 1.0.0
	 *
     */
    
    public static function import_template_ajax_actions( Ajax $ajax )
    {

    	$ajax->register_ajax_action( 'the4_elementor_import_template', function( $data ) {


            if ( ! current_user_can( 'edit_posts' ) ) {
                throw new \Exception( 'Access Denied' );
            }

            if ( !empty( $data['editor_post_id']) ) {
                $editor_post_id = absint( $data['editor_post_id'] );

                if ( ! get_post( $editor_post_id )) {
                    throw new \Exception( 'Post not exist' );
                }

                Plugin::$instance->db->switch_to_post( $editor_post_id );
            }

            if ( empty( $data['data']['block_id'] ) ) {
                throw new \Exception( __( 'Block template id missing' ) );
            }

            $block = self::get_block_data( $data );

            return $block;
    	});
    }

    public static function get_block_data( array $args)
    {
        $data = The4LibraryApi::instance()->get_data( $args );

        return $data;
    }
}
