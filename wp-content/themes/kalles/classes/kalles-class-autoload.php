<?php


/**
 * Autoload
 *
 * @since   1.1.2
 * @package Kalles
 */

namespace Kalles;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Autoload {

    /**
     * Instance
     *
     * @var $instance
     */
    private static $instance = null;

    /**
     * Initiator
     *
     * @since 1.1.2
     * @return object
     */
    

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    

    /**
     * 
     * Constructor - Sets up the object properties.
     * @since 1.1.2
     * @return object
     *
     */
    public function __construct()
    {
        spl_autoload_register( [ $this, 'load_file' ] );
    }

    /**
     * 
     * Autoload file
     * @since 1.1.2
     * @return void
     *
     */
    
    public function load_file( $className )
    {


        if ( strpos( $className, 'Kalles' ) === false ) {
            return;
        }
        

        $class = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $className );

        $class = strtolower( $class );
        
        $class = str_replace( '_', '-', $class );

        $file_path = explode('\\', $class );

        $file_name = $class;

        $dir = THE4_KALLES_PATH . '/classes';

        
        if ( count( $file_path ) > 1 ) {
            
            if ( $file_path['0'] === 'woocommerce' ) {
                $dir .= '/woocommerce';
            } 

            $file_name = $file_path[1];
        }


        $file_name = $dir . '/kalles-class-' . $file_name . '.php';

        if ( is_readable( $file_name ) ) {
            include( $file_name );
        }
    }

}