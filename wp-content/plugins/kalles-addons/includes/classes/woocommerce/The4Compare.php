<?php
/**
 * Wishlist local for woocommerce.
 *
 * @since   1.0.0
 * @package Kalles
 */

defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Woocommerce_Compare {


	public function __construct()
	{

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
			if ( cs_get_option( 'wc_general_compare' ) ) {
				add_action('woocommerce_after_add_to_cart_button' , array($this, 'add_compare_single'), 33);

				if ( cs_get_option( 'wc_general_compare-view_list' ) ) {
					add_action('kalles_product_loop_action' , array($this, 'add_compare_loop'));
				}
			}

			add_action( 'wp_ajax_addCompare'       , array($this, 'addCompare') );
			add_action( 'wp_ajax_nopriv_addCompare',  array($this, 'addCompare'));
			add_action( 'wp_ajax_removeCompare'       , array($this, 'removeCompare') );
			add_action( 'wp_ajax_nopriv_removeCompare',  array($this, 'removeCompare'));

			//Add shortcode Page Wislish View
			add_shortcode( 'kalles_compare', array( $this, 'displayComparePage') );
	}

	/**
	 * Display compare page via Shortcode
	 *
	 * @since 1.0.0
	 * @return HTML
	 */

	public function displayComparePage()
	{
		$products = $this->getAllCompareProductData();
		$fields_cp = cs_get_option( 'wc_general_compare-fields' );
		array_unshift( $fields_cp, 'basic' );

		?>

			<?php
				if ( ! empty( $products ) ) {
					echo '<div class="themet4_compare_table">';
					array_unshift( $products, array() );

					foreach ( $fields_cp as $field ) {
						if ( ! $this->productIsHaveField( $field, $products) ) {
							continue;
						}
					?>
					<div class="themet4_compare_row compare_<?php echo esc_attr( $field ); ?>">
						<?php foreach( $products as $product_id => $product) : ?>
							<?php if ( ! empty( $product ) ) : ?>
								<div class="themet4_compare_col compare_value compare_id_<?php echo esc_attr( $product['id'] ) ?>" data-title="<?php echo ucfirst( $field ); ?>">
									<?php $this->displayCompareField( $field, $product ); ?>
								</div>
							<?php else : ?>
								<div class="themet4_compare_col compare_field">
									<?php The4Helper::ksesHTML( $this->getAttrName( $field ) ); ?>
								</div>
							<?php endif; ?>

						<?php endforeach; ?>
					</div>

					<?php
					}
					echo '</div>';
				} else {
					?>
					<div class="empty_cart_page tc">
				      	<i class="t4_icon_sync-solid fwb pr mb__30 fs__90"></i>
				      	<h4 class="cart_page_heading mg__0 mb__20 tu fs__30"><?php echo esc_html__('Compare list is empty', 'kalles') ?>.</h4>
				      	<div class="cart_page_txt">
				      		<?php echo cs_get_option( 'wc_general_compare-empty_text' ); ?>
				  		</div>
				  		<a class="button button_primary tu js_add_ld mt__20" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e('Return To Shop', 'kalles') ?></a>
				  	</div>
					<?php
				}
			 ?>
		<?php

		return ob_get_clean();
	}

	/**
	 * Get name of field attributes
	 *
	 * @since 1.0.0
	 * @return string
	 */

	public function getAttrName( $attr)
	{
		if ( function_exists( 'kalles_get_compare_fields' ) ) {
			$fields = kalles_get_compare_fields();

			foreach ( $fields as $key => $name ) {
				if ( $attr == $key )
					return $name;
			}
		}
	}
	/**
	 * Display compare field
	 *
	 * @since 1.0.0
	 * @return HTML
	 */

	public function displayCompareField( $field, $product)
	{
		$type = $field;

		if ( substr( $field, 0, 3) === 'pa_' )
			$type = 'attr';

		switch ( $type ) {
			case 'basic':
				?>
					<div class="compare_basic_content">
						<a href="#" data-no-instant rel="nofollow" class="cpt4_remve compare_remove dib"
							data-id="<?php echo esc_attr( $product['id'] ); ?>"
							data-skey="<?php echo wp_create_nonce('kalles-compare'); ?>">
							<span><?php echo esc_html__( 'Remove', 'kalles' ); ?></span>
						</a>
						<div class="<?php echo kalles_image_lazyload_class() ?>">
							<a class="product-image db" href="<?php echo get_permalink( $product['id'] ); ?>">
								<?php The4Helper::ksesHTML( $product['basic']['image'] ); ?>
							</a>
						</div>
						<a class="product-title db" href="<?php echo get_permalink( $product['id'] ); ?>">
							<?php echo esc_html( $product['basic']['title'] ); ?>
						</a>
						<div class="price">
							<?php echo wp_kses_post( $product['basic']['price'] ); ?>
						</div>
						 <a class="pr btn-quickview button js_add_qv cd br__40 pl__25 pr__25 bgw tc dib"
							href="<?php echo get_permalink( $product['id'] ); ?>" data-prod="<?php echo esc_attr( $product['id'] ); ?>" rel="nofollow">
							<span><?php echo esc_html__('Quick view', 'kalles') ?></span>
						</a>
						<?php if ( ! cs_get_option( 'wc-catalog' ) ) {
							echo '<div class="hover_button">';
							echo apply_filters( 'kalles_compare_add_to_cart_btn', $product['basic']['add_to_cart'] );
							echo '</div>';
						} ?>
					</div>
				<?php
				break;

			case 'description':
				echo apply_filters( 'woocommerce_short_description', $product[ $field ] );
				break;

			case 'weight':
				if ( $product[ $field ] ) {
					$w_unit = ( $product[ $field ] != '-' ) ? get_option( 'woocommerce_weight_unit' ) : '';
					echo wc_format_localized_decimal( $product[ $field ] ) . ' ' . esc_attr( $w_unit );
				}
				break;

			case 'attr':
				echo  wp_kses_post( $product[ $field ] );
				break;

			default:
				echo wp_kses_post( $product[ $field ] );
				break;
		}
	}

	/**
	 * Check is product have compare field
	 *
	 * @since 1.0.0
	 * @return boolean
	 */

	public function productIsHaveField( $field, $products )
	{
		foreach ( $products as $product ) {
			if ( isset( $product[ $field ])
				&& ! empty( $product[ $field ])
				&& $product[ $field ] != '-'
				&& $product[ $field ] != 'N/A'
			) {
				return true;
			}
		}

		return false;
	}
	/**
	 * Get all data product in Compare
	 *
	 * @since 1.0.0
	 *
	 */
	public function getAllCompareProductData()
	{
		if ( ! empty($_COOKIE['kalles_compare']) ) {

			$cp_id_list = unserialize( wp_unslash( $_COOKIE['kalles_compare'] ) );

			if ( ! empty( $cp_id_list ) ) {
				$args = array(
					'include' => $cp_id_list,
					'limit' => 6
				);

				$products = wc_get_products( $args );

				$data_cp = array();

				$fields_cp = cs_get_option( 'wc_general_compare-fields' );
				$tax_fields = array_filter( $fields_cp, function( $field ) {
					return substr( $field, 0, 3 ) === 'pa_';
				} );

				$sperate = '-';

				foreach ( $products as $product ) {
					$data_cp[ $product->get_id() ] = array(
						'basic' => array(
							'title'        => $product->get_title() ? $product->get_title() : $sperate,
							'image'        => $product->get_image() ? $product->get_image() : $sperate,
							'price'        => $product->get_price_html() ? $product->get_price_html() : $sperate,
							'add_to_cart' => $this->getAddtoCartHTML( $product ) ? $this->getAddtoCartHTML( $product ) : $sperate,
						),
						'id'           => $product->get_id() ? $product->get_id() : $sperate,
						'description'  => $product->get_short_description() ? $product->get_short_description() : $sperate,
						'image_id'     => $product->get_image_id(),
						'permalink'    => $product->get_permalink(),
						'weight'       => $product->get_weight() ? $product->get_weight() : $sperate,
						'sku'          => $product->get_sku() ? $product->get_sku() : $sperate,
						'availability' => ( ! $product->managing_stock() && ! $product->is_in_stock() ) ? translate( 'Out stock', 'kalles' ) : translate( 'In stock', 'kalles' )
					);

					foreach ( $tax_fields as $field ) {
						if ( taxonomy_exists( $field ) ) {
							$data_cp[ $product->get_id() ][ $field ] = array();
							$orderby = wc_attribute_orderby( $field ) ? wc_attribute_orderby( $field ) : 'name';

							$terms = wp_get_post_terms(
								$product->get_id(),
								$field,
								array(
									'orderby' => $orderby
								)
							);


							if ( ! empty( $terms ) ) {
								foreach( $terms as $term ) {
									$term = sanitize_term( $term, $field );
									$data_cp[ $product->get_id() ][ $field ][] = $term->name;
								}
							} else {
								$data_cp[ $product->get_id() ][ $field ][] = $sperate;
							}

							$data_cp[ $product->get_id() ][ $field ] = implode(', ', $data_cp[ $product->get_id() ][ $field] );
						}
					}
				}

				return $data_cp;
			}

		}
	}

	/**
	 * Get add to cart HTML
	 *
	 * @since 1.0.0
	 * @return HTML
	 */

	public function getAddtoCartHTML( $product )
	{
		$class_array = array_filter( array(
			'button',
			'product_type_' . $product->get_type(),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
		) );

		$class = implode( ' ', $class_array);

		return apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s pr br-36 mb__10 pr_atc cd br__40 bgw tc dib  cb chp %s"><span>%s</span></a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_attr( $product->get_id() ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
			        esc_attr( ( cs_get_option('wc-quick-shop-enable') ) ? 'quick_shop_js' : '' ),
					esc_html( $product->add_to_cart_text() )
				),
			$product );
	}

	/**
	 * Add Compare Ajax
	 *
	 * @since 1.0.0
	 *
	 */
	public function addCompare()
	{
		check_ajax_referer('kalles-compare', 'security_code');

		$limit  = 6;
		$cookie_key = 'kalles_compare';
		$cookie_time = 30 * 84600;
		$product_id = (int)$_POST['product_id'];

		if( ! isset( $_COOKIE['kalles_compare'] ) ) {
			$compare_id = array($product_id);
			$compare_id = serialize($compare_id);
			setcookie('kalles_compare', $compare_id, time() + $cookie_time, '/', COOKIE_DOMAIN);
			$_COOKIE['kalles_compare'] = $compare_id;
		} else {
			$compare_id = $_COOKIE['kalles_compare'];
			$compare_id = stripcslashes($compare_id);
			$compare_id = unserialize($compare_id);

			if (!in_array($product_id, $compare_id)) {

				if ( count( $compare_id ) > 6 ) {
					array_shift( $compare_id );
					//array_values( $compare_id );
				}

				array_push($compare_id, $product_id);

				$compare_id = serialize($compare_id);

				setcookie('kalles_compare', $compare_id, time() + $cookie_time, '/', COOKIE_DOMAIN);
				$_COOKIE['kalles_compare'] = $compare_id;
			}
		}

		$txt_added = translate('Compare products', 'kalles');

		$response = array(
			'txt_added' => $txt_added
		);
		wp_send_json($response);
	}
	/**
	 * remove Wishlist Ajax
	 *
	 * @since 1.0.0
	 *
	 */
	public function removeCompare()
	{
		check_ajax_referer('kalles-compare', 'security_code');

		$cookie_key = 'kalles_compare';
		$cookie_time = 30 * 84600;
		$product_id = (int)$_POST['product_id'];

		if( $_COOKIE['kalles_compare']) {
			$compare_id = $_COOKIE['kalles_compare'];
			$compare_id = stripcslashes($compare_id);
			$compare_id = unserialize($compare_id);
			if (in_array($product_id, $compare_id)) {
				$key = (int)array_search($product_id, $compare_id);
    				unset($compare_id[$key]);

				$compare_id = array_values($compare_id);
				$compare_id = serialize($compare_id);
				setcookie('kalles_compare', $compare_id, time() + $cookie_time, '/', COOKIE_DOMAIN);
				$_COOKIE['kalles_compare'] = $compare_id;
			}

			$response = array(
				'cp_count' =>  count( unserialize($compare_id) )
			);
			wp_send_json($response);

		}


	}

	/**
	 * Add Wishlist product loop
	 *
	 * @since 1.0.0
	 *
	 */
	public function add_compare_loop()
	{
		$this->add_compare_btn('nt_add_cp ts__03 pa', 'tooltip_right');
	}

	/**
	 * Add Wishlist product Single
	 *
	 * @since 1.0.0
	 *
	 */
	public function add_compare_single()
	{
		$this->add_compare_btn('nt_add_cp ts__03 pa compare-single order-3');
	}

	/**
	 * Add Wishlist action btn
	 *
	 * @since 1.0.0
	 *
	 * @param string $class
	 */
	public function add_compare_btn( $class = '', $txt_position = 'tooltip_top_left')
	{
		global $product;

		$check_is_add = false;

		if ( isset( $_COOKIE['kalles_compare']) ) {
			$cp_id_list = unserialize( wp_unslash( $_COOKIE['kalles_compare'] ) );
			$check_is_add = in_array($product->get_id(), $cp_id_list);
		}

		$compare_class = $check_is_add ? 'cpt4_added cpt4_remove' : 'compare_add';

		//get product listing style setting
		$product_style = cs_get_option('wc_categories_product-style') ? cs_get_option('wc_categories_product-style') : 'default';
		//Check if Enable remove option
		$txt = translate( 'Compare', 'kalles' );
		if ($check_is_add) {
			$txt = translate('Compare products', 'kalles');
		}
		
		$compare_page_id = cs_get_option('wc_general_compare-page');
		
		if ( is_object( get_post( $compare_page_id  ) ) ) {
			// $compare_class .= ' compare-page';
			// $txt = translate('Remove Compare', 'kalles');
			$compare_page = get_page_link( $compare_page_id );
		} else {
			$compare_page = '#';
		}
		$output = '';

		$output .= '<div class="' . $class . ' kalles-compare-btn ' . $product_style . '">';
		
		$output .= '<a href="' . $compare_page .'"
						class="' . $compare_class .' cb chp ttip_nt ' . $txt_position .'" rel="nofollow"
						data-no-instant="" data-id="' . $product->get_id() .'"
						data-skey="' . esc_attr(wp_create_nonce('kalles-compare')) .'">
							<span class="tt_txt">' . $txt . '</span><i class="t4_icon_sync"></i>
					</a>';

		$output .= '</div>';

		echo wp_kses_post( $output );
	}

}
new The4_Woocommerce_Compare();

