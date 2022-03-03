<?php


/**
 * Autoload
 *
 * @since   1.1.2
 * @package Kalles
 */

namespace Kalles;

if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class Woocommerce {

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
        //Shipping caculate
        
        $this->loadObject( 'quickview' );

        //Shipping caculate
        
        $this->loadObject( 'shipping' );

        //Shop other look caculate
        
        $this->loadObject( 'shop_other_look' );

        //Search
        
        $this->loadObject( 'search' );

        //Sub categories
        
        $this->loadObject( 'category_walker' );

        //Recent review product
        
        if ( cs_get_option('wc_product_viewer-enable') ) {
            $this->loadObject( 'recent_viewer' );
        }
        
    }

    /**
     * Load Class Object
     *
     * @since 1.1.2
     *
     * @return object
     */
    
    public function loadObject( $className )
    {
        switch ( $className ) {
            case 'quickview':
                
                return \Kalles\Woocommerce\Quickview::instance();

                break;

            case 'recent_viewer':
                
                return \Kalles\Woocommerce\Recent_Viewer::instance();

                break;
            case 'shipping':
                
                return \Kalles\Woocommerce\Shipping::instance();

                break;

            case 'shop_other_look':
                
                return \Kalles\Woocommerce\Shop_Other_Look::instance();

                break;

            case 'search':
                
                return \Kalles\Woocommerce\Search::instance();

                break;

            case 'category_walker':
                
                return \Kalles\Woocommerce\Category_Walker::class;

                break;

            default:
                // code...
                break;
        }
    }

}