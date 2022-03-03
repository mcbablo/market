<?php
/**
 * Wishlist local for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */


defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Woocommerce_Product360 {

	private static $_metakey = 'the4_product_360';

	public function __construct()
	{
		add_action( 'add_meta_boxes', [ __CLASS__, 'add_product360_metabox'], 100 );
        add_action( 'woocommerce_process_product_meta', [ __CLASS__, 'save_gallery_product_metabox' ], 100, 2 );
	}

	public static function add_product360_metabox() {
		add_meta_box( self::$_metakey, esc_html__( '360 Images Product ', 'kalles' ), [ __CLASS__, 'display_metabox_form'], 'product', 'side', 'low' );
	}
	/**
     * Display meta box to select gallery images product.
     *
     * @param   WP_Post  $post    WordPress's post object.
     * @param   object   $params  Meta box parameters.
     *
     * @return  void
     */
    public static  function display_metabox_form( $post, $params ) {
        // Generate meta key to get product variation gallery.

        $product_360_gallery = array();
        ?>
        <div class="product_variation_images_container">
            <ul class="product_images">
                <?php
                // Get product 360 gallery.
                if ( metadata_exists( 'post', $post->ID, self::$_metakey ) ) {
                	$product_360_gallery = get_post_meta( $post->ID, self::$_metakey, true );
                	$attachments           = array_filter( explode( ',', $product_360_gallery ) );
	                $update_meta           = false;
	                $updated_gallery_ids   = array();
                }
                if ( ! empty( $attachments ) ) {
                    foreach ( $attachments as $attachment_id ) {
                        $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );

                        if ( empty( $attachment ) ) {
                            $update_meta = true;
                            continue;
                        }
                ?>
                <li class="image" data-attachment_id="<?php echo esc_attr( $attachment_id ); ?>">
                    <?php echo '' . $attachment; ?>
                    <ul class="actions">
                        <li>
                            <a href="#" class="delete tips" data-tip="<?php
                                esc_attr_e( 'Delete image', 'kalles' );
                            ?>">
                                <?php esc_html_e( 'Delete', 'kalles' ); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                        // Rebuild ids to be saved.
                        $updated_gallery_ids[] = $attachment_id;
                    }

                    // Need to update product meta to set new gallery ids.
                    if ( $update_meta ) {
                        update_post_meta( $post->ID, self::$_metakey, implode( ',', $updated_gallery_ids ) );
                    }
                }
                ?>
            </ul>

            <input type="hidden" class="product_variation_image_gallery" name="<?php echo esc_attr( self::$_metakey ); ?>" value="<?php
                echo esc_attr( $product_360_gallery );
            ?>" />
        </div>
        <p class="add_product_variation_images hide-if-no-js">
            <a href="#" data-choose="<?php
                echo esc_attr( esc_html__( 'Add Images to 360 Product Gallery', 'kalles' )
                ) ;
            ?>" data-update="<?php
                esc_attr_e( 'Add to gallery', 'kalles' );
            ?>" data-delete="<?php
                esc_attr_e( 'Delete image', 'kalles' );
            ?>" data-text="<?php
                esc_attr_e( 'Delete', 'kalles' );
            ?>">
                <?php esc_html_e( 'Add product gallery images', 'kalles' ); ?>
            </a>
        </p>
        <?php
    }

    /**
     * Save meta boxes.
     *
     * @param   int  $post_id  The ID of the post being saved.
     *
     * @return  void
     */
    public static function save_gallery_product_metabox( $post_id, $post ) {
        $attachment_ids = isset( $_POST['the4_product_360'] ) ? array_filter( explode( ',', wc_clean( $_POST['the4_product_360'] ) ) ) : array();

		update_post_meta( $post_id, 'the4_product_360', implode( ',', $attachment_ids ) );
    }

    /**
	 * Display 360 image btn
	 * @since  1.0
	 */

    public function the4_kalles_product_360_image_btn() {

	    $html = '';

	    $product_360_gallery = self::get_360_image_gallery();

	    if ( false ) {

	        wp_enqueue_script( 'kalles-threesixty' );
	        $image_360 = array();
	        $image_360[] = 'https://wp.the4.co/kalles/wp-content/uploads/2021/08/8_b5e5cb1e-7ac1-4879-84ec-50cf224c3c5c.jpg';
	        $html = '<div class="p-360-image p_group_btns">';
	            $html .= '<button data-id="#pr_360_mfp" class="ttip_nt tooltip_top_left br__40 pl__30 pr__30 tc db bghp the4-popup-url nt_mfp_360">
	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M 16 4 C 13.800781 4 12 5.800781 12 8 C 12 9.113281 12.476563 10.117188 13.21875 10.84375 C 11.886719 11.746094 11 13.28125 11 15 L 11 19.625 L 13 20.625 L 13 25 L 19 25 L 19 20.625 L 21 19.625 L 21 15 C 21 13.28125 20.113281 11.746094 18.78125 10.84375 C 19.523438 10.117188 20 9.113281 20 8 C 20 5.800781 18.199219 4 16 4 Z M 16 6 C 17.117188 6 18 6.882813 18 8 C 18 9.117188 17.117188 10 16 10 C 14.882813 10 14 9.117188 14 8 C 14 6.882813 14.882813 6 16 6 Z M 16 12 C 17.667969 12 19 13.332031 19 15 L 19 18.375 L 17 19.375 L 17 23 L 15 23 L 15 19.375 L 13 18.375 L 13 15 C 13 13.332031 14.332031 12 16 12 Z M 9 18.875 C 6.082031 19.691406 4 21.074219 4 23 C 4 26.28125 10.035156 28 16 28 C 21.964844 28 28 26.28125 28 23 C 28 21.074219 25.917969 19.691406 23 18.875 L 23 20.96875 C 24.902344 21.582031 26 22.375 26 23 C 26 24.195313 22.011719 26 16 26 C 9.988281 26 6 24.195313 6 23 C 6 22.375 7.097656 21.582031 9 20.96875 Z"/></svg>
	            <span class="tt_txt">' . translate( 'View 360', 'kalles' ) .'</span></button>';
	        $html .= '</div>';
	        $html .= '<div id="pr_360_mfp" class="pr_360_wrapper pr mfp-hide"
	                    data-args=\'{"images":' . wp_json_encode( $image_360 ) . '}\'><div class="threesixty pr"><div class="spinner"><span>0%</span></div><ul class="threesixty_imgs"></ul></div></div> ';
	    }
	    The4Helper::ksesHTML( $html );
    }

    /**
	 * Get 360 image product
	 * @since  1.0
	 * @return Array
	 */

	public static function get_360_image_gallery()
	{
		global $post;

		if ( ! $post ) return;

		$product_360_gallery = get_post_meta( $post->ID, self::$_metakey, true);

		return apply_filters( 'woocommerce_product_360_gallery_attachment_ids', array_filter( array_filter( (array) explode( ',', $product_360_gallery ) ), 'wp_attachment_is_image' ) );
	}
}

new The4_Woocommerce_Product360();
