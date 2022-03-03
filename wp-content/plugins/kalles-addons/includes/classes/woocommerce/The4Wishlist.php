<?php
/**
 * Wishlist local for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */

defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Woocommerce_Wishlist {

	private $_wishlist_list = array();

	public function __construct()
	{

		if (isset($_COOKIE['kalles_wishlist']) && ! empty( $_COOKIE['kalles_wishlist'] ) )
			$this->_wishlist_list = @unserialize($_COOKIE['kalles_wishlist']);
		$this->init();
	}

	/**
	 * Initialize Wishlist
	 *
	 * @since 1.0.0
	 *
	 */
	public function init()
	{
		if ( ! class_exists( 'YITH_WCWL' ) || cs_get_option( 'wc_general_wishlist-type' ) ) {
			add_action('woocommerce_after_add_to_cart_button' , array($this, 'add_wishlist_single'), 33);

			add_action('kalles_product_loop_action' , array($this, 'add_wishlist_loop'));

			add_action( 'wp_ajax_addWishlist'       , array($this, 'addWishlist') );
			add_action( 'wp_ajax_nopriv_addWishlist',  array($this, 'addWishlist'));
			add_action( 'wp_ajax_removeWishlist'       , array($this, 'removeWishlist') );
			add_action( 'wp_ajax_nopriv_removeWishlist',  array($this, 'removeWishlist'));

			//Add shortcode Page Wislish View
			add_shortcode( 'kalles_wishlist', array( $this, 'viewWishlistPage') );
		}
	}


	/**
	 * Wishlist page Shortcode display
	 *
	 * @since 1.0.0
	 *
	 */
	public function viewWishlistPage()
	{
		if ( !empty($_COOKIE['kalles_wishlist']) ) {
			$w_id_list = unserialize( wp_unslash( $_COOKIE['kalles_wishlist'] ) );
			ob_start();
		}
		?>
		<div class="kalles-wishlist-content">
			<?php if ( !empty($w_id_list) ) : ?>
			<?php echo wp_kses_post( $this->getAllWishlistProduct() ); ?>
			<?php else : ?>
				<div class="empty_cart_page tc">
			      <i class="iccl iccl-heart fwb pr mb__30 fs__90"></i>
			      <h4 class="cart_page_heading mg__0 mb__20 tu fs__30"><?php esc_html_e( 'Wishlist is empty.', 'kalles' ) ?></h4>
			      <div class="cart_page_txt">
			      	<?php echo cs_get_option('wc_general_wishlist-empty_text'); ?>
			      	<a class="button button_primary tu js_add_ld mt__20" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e('Return To Shop', 'kalles') ?></a>
			      </div>
			<?php endif; ?>
		</div>
		<?php

		return ob_get_clean();

	}

	/**
	 * Get all product in Wishlist
	 *
	 * @since 1.0.0
	 *
	 */
	public function getAllWishlistProduct()
	{
		if ( !empty($_COOKIE['kalles_wishlist']) ) {

			$w_id_list = unserialize( wp_unslash( $_COOKIE['kalles_wishlist'] ) );
			$args = array(
				'id' => implode(',', $w_id_list),
				'columns' => 3,
				'class' => 'wishlish-page'
			);
			echo kalles_shortcode_products($args);
		}
	}

	/**
	 * Add Wishlist Ajax
	 *
	 * @since 1.0.0
	 *
	 */
	public function addWishlist()
	{
		check_ajax_referer('kalles-wishlist', 'security_code');

		$cookie_key = 'kalles_wishlist';
		$cookie_time = 30 * 84600;
		$product_id = (int)$_POST['product_id'];
		if( ! isset( $_COOKIE['kalles_wishlist'] ) ) {
			$wishlist_id = array($product_id);
			$wishlist_id = serialize($wishlist_id);
			setcookie('kalles_wishlist', $wishlist_id, time() + $cookie_time, '/', COOKIE_DOMAIN);
			$_COOKIE['kalles_wishlist'] = $wishlist_id;
		} else {
			$wishlist_id = $_COOKIE['kalles_wishlist'];
			$wishlist_id = stripcslashes($wishlist_id);
			$wishlist_id = unserialize($wishlist_id);
			if (!in_array($product_id, $wishlist_id)) {
				array_unshift($wishlist_id, $product_id);
				$wishlist_id = serialize($wishlist_id);
				setcookie('kalles_wishlist', $wishlist_id, time() + $cookie_time, '/', COOKIE_DOMAIN);
				$_COOKIE['kalles_wishlist'] = $wishlist_id;
			}

		}
		$txt_added = translate('Browse Wishlist', 'kalles');
		if (cs_get_option('wc_general_wishlist-action') == 2) {
			$txt_added = translate('Remove Wishlist', 'kalles');
		}
		$response = array(
			'txt_added' => $txt_added,
			'w_count' =>  count( unserialize($wishlist_id) )
		);
		wp_send_json($response);
	}
	/**
	 * Add Wishlist Ajax
	 *
	 * @since 1.0.0
	 *
	 */
	public function removeWishlist()
	{
		check_ajax_referer('kalles-wishlist', 'security_code');

		$cookie_key = 'kalles_wishlist';
		$cookie_time = 30 * 84600;
		$product_id = (int)$_POST['product_id'];

		if( $_COOKIE['kalles_wishlist']) {
			$wishlist_id = $_COOKIE['kalles_wishlist'];
			$wishlist_id = stripcslashes($wishlist_id);
			$wishlist_id = unserialize($wishlist_id);
			if (in_array($product_id, $wishlist_id)) {
				$key = (int)array_search($product_id, $wishlist_id);
    				unset($wishlist_id[$key]);

				$wishlist_id = array_values($wishlist_id);
				$wishlist_id = serialize($wishlist_id);
				setcookie('kalles_wishlist', $wishlist_id, time() + $cookie_time, '/', COOKIE_DOMAIN);
				$_COOKIE['kalles_wishlist'] = $wishlist_id;
			}

		}
		$response = array(
			'txt_added' => translate('Add to Wishlist', 'kalles'),
			'w_count' =>  count( unserialize($wishlist_id) )
		);
		wp_send_json($response);
	}

	/**
	 * Add Wishlist product loop
	 *
	 * @since 1.0.0
	 *
	 */
	public function add_wishlist_loop()
	{
		$this->add_wishlist_btn('nt_add_w ts__03 pa', 'tooltip_right');
	}

	/**
	 * Add Wishlist product Single
	 *
	 * @since 1.0.0
	 *
	 */
	public function add_wishlist_single()
	{
		$this->add_wishlist_btn('nt_add_w ts__03 pa wishlish-single order-3');
	}

	/**
	 * Add Wishlist action btn
	 *
	 * @since 1.0.0
	 *
	 * @param string $class
	 */
	public function add_wishlist_btn( $class = '', $txt_position = 'tooltip_top_left')
	{
		global $product;
		$check_is_add = in_array($product->get_id(), $this->_wishlist_list);
		$wishlist_class = $check_is_add ? 'wis_added wis_remove' : 'wishlistadd';
		$w_action = cs_get_option('wc_general_wishlist-action') ? cs_get_option('wc_general_wishlist-action') : '1';
		//get product listing style setting
		$product_style = cs_get_option('wc_categories_product-style') ? cs_get_option('wc_categories_product-style') : 'default';
		//Check if Enable remove option
		$txt = translate( 'Add to Wishlist', 'kalles' );
		if ($check_is_add) {
			$txt = ($w_action == 1) ? translate('Browse Wishlist', 'kalles') : translate('Remove Wishlist', 'kalles');
			$class .= ' nt_added_w';
		}
		if ($w_action == 2) {
			$wishlist_class .= ' enable_remove';
		}
		
		$output = '';
		$output .= '<div class="' . $class . ' kalles-wishlist-btn ' . $product_style . '">';
		
		$wishlist_page_id = cs_get_option('wc_general_wishlist-page');
		
		if ( is_object( get_post( $wishlist_page_id  ) ) ) {
			$wishlist_page = get_page_link( $wishlist_page_id );
			if ( is_page( $wishlist_page_id ) ) {
				$wishlist_class .= ' wishlist-page';
				$txt = translate('Remove Wishlist', 'kalles');
			}
		} else {
			$wishlist_page = '#';
		}
		
		$output .= '<a href="' . $wishlist_page .'"
						class="' . $wishlist_class .' cb chp ttip_nt ' . $txt_position .'" rel="nofollow"
						data-no-instant="" data-id="' . $product->get_id() .'"
						data-skey="' . esc_attr(wp_create_nonce('kalles-wishlist')) .'">
							<span class="tt_txt">' . $txt . '</span><i class="t4_icon_t4-heart"></i>
					</a>';

		$output .= '</div>';

		echo wp_kses_post( $output );
	}

}
new The4_Woocommerce_Wishlist();