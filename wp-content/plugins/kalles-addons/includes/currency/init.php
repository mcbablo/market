<?php
/**
 * Class JAS Currency
 *
 * @package  KallesAddons
 * @since    1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Kalles_Addons_Currency {
	/**
	 * Construct function.
	 *
	 * @return  void
	 */
	function __construct() {
		// Admin menu

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 11 );
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		add_action( 'wp_ajax_list-currency', array( $this, 'list_currency' ) );
		add_action( 'wp_ajax_nopriv_list-currency', array( $this, 'list_currency' ) );

		add_action( 'wp_ajax_save-currency', array( $this, 'save_currency' ) );
		add_action( 'wp_ajax_save-currency', array( $this, 'save_currency' ) );

		add_action( 'wp_ajax_remove-currency', array( $this, 'remove_currency' ) );
		add_action( 'wp_ajax_remove-currency', array( $this, 'remove_currency' ) );

		add_action( 'wp_ajax_update-currency-rate', array( $this, 'update_currency_rate' ) );
		add_action( 'wp_ajax_update-currency-rate', array( $this, 'update_currency_rate' ) );

		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'save_current_rate_to_order' ), 10, 2 );

		add_filter( 'woocommerce_currency',     array( $this, 'the4_currency_woocommerce_currency'     ), 10, 1 );
		add_filter( 'woocommerce_price_format', array( $this, 'the4_currency_woocommerce_price_format' ), 10, 2 );

		//add_filter( 'wc_price_args',            array( $this, 'the4_currency_price_args'               ), 10, 1 );
		add_filter( 'wc_get_price_thousand_separator', array( $this, 'the4_currency_thousand_sep'               ), 10, 1 );
		add_filter( 'wc_get_price_decimal_separator',  array( $this, 'the4_currency_decimal_sep'               ), 10, 1 );
		add_filter( 'wc_get_price_decimals',           array( $this, 'the4_currency_num_decimals'               ), 10, 1 );

		add_filter( 'raw_woocommerce_price'                  , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_amount_item_subtotal' , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_item_get_subtotal_tax', array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_get_total'            , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_get_total_tax'        , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_get_shipping_tax'     , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_get_shipping_total'   , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_order_get_total_discount'   , array( $this, 'the4_currency_raw_woocommerce_price' ), 10, 1 );
		add_filter( 'woocommerce_get_formatted_order_total', array( $this, 'the4_get_formatted_order_total' ), 10, 4 );
		add_filter( 'woocommerce_currency_symbol', array($this, 'jsa_keep_currency_in_order_page'), 10, 2 );
		// Revert currency when viewing order in backend.
		// if ( is_admin() ) {
		// 	add_filter( 'get_post_metadata', array( $this, 'revert_order_curreny' ), 999999, 4 );
		// }
	}

	/**
	 * Add sub-menu to JAS menu.
	 *
	 * @return  void
	 */
	public static function admin_menu() {
		add_submenu_page(
			'the4-dashboard',
			__( 'All Currencies', 'kalles-addons' ),
			__( 'Currencies', 'kalles-addons' ),
			'manage_options',
			'the4-manage-currencies',
			array( __CLASS__, 'render_html' )
		);
	}

	/**
	 * Register auto update settings.
	 *
	 * @return  void
	 */
	public static function register_settings() {
		register_setting( 'the4-manage-currencies', 'the4_currency_auto_update_hours', 'intval' );
		register_setting( 'the4-manage-currencies', 'the4_currency_auto_update_last_time', 'string' );
		register_setting( 'the4-manage-currencies', 'the4_currency_api_key', 'string' );
		register_setting( 'the4-manage-currencies', 'the4_currency_update_by_location', 'intval' );
	}

	/**
	 * Render admin html.
	 *
	 * @return  void
	 */
	public static function render_html() {
		if ( current_user_can( 'manage_options' ) )  {
			include KALLES_ADDONS_PATH . '/includes/currency/views/backend.php';
		}
	}

	/**
	 * Get default currency.
	 *
	 * @return  void
	 */
	public static function get_default() {
		return array(
			'currency'                       => 'USD',
			'woocommerce_currency_pos'       => 'left',
			'woocommerce_price_thousand_sep' => ',',
			'woocommerce_price_decimal_sep'  => '.',
			'woocommerce_price_num_decimals' => '2',
			'woocommerce_price_rate'         => '1'
		);
	}

	/**
	 * Get woocommerce currency.
	 *
	 * @return  void
	 */
	public static function woo_currency() {
		$currency = get_option( 'woocommerce_currency' );
		return array(
			'currency'                       => $currency,
			'woocommerce_currency_pos'       => get_option( 'woocommerce_currency_pos', 'left'    ),
			'woocommerce_price_thousand_sep' => get_option( 'wc_get_price_thousand_separator', ','),
			'woocommerce_price_decimal_sep'  => get_option( 'wc_get_price_decimal_separator', '.'),
			'woocommerce_price_num_decimals' => get_option( 'wc_get_price_decimals', '2'),
			'woocommerce_price_rate'         => '1'
		);

	}

	/**
	 * Get all currencies.
	 *
	 * @return  void
	 */
	public static function getCurrencies() {
		return get_option( 'the4_currencies' );
	}

	/**
	 * Get custom currency.
	 *
	 * @return  void
	 */
	public static function getCurrency( $code ) {
		$currencies = self::getCurrencies();
		if ( isset( $currencies[$code] ) ) {
			return array_merge( self::get_default(), $currencies[$code] );
		}
		return false;
	}

	/**
	 * Save currency.
	 */
	public static function saveCurrency( $code, $data ) {
		if ( $code == get_option( 'woocommerce_currency' ) ) {
			$data = self::woo_currency();
		}
		if ( $code != '' ) {
			$data['currency']  = $code;
			$currencies        = self::getCurrencies();
			$currencies[$code] = array_merge( self::get_default(), $data );
			$curs = array();

			foreach( $currencies as $code => $c ) {
				if ( $code != '' && $c['currency'] != '' ) {
					$curs[$code] = $c;
				}

			}
			update_option( 'the4_currencies', $curs );
		}
	}

	/**
	 * Delete currency.
	 */
	public static function delCurrency( $code ) {
		$currencies = self::getCurrencies();
		if ( isset( $currencies[$code] ) ) {
			unset( $currencies[$code] );
			update_option( 'the4_currencies', $currencies );
		}
	}

	/**
	 * Update currency rate.
	 */
	public static function autoUpdateCurrencyRate() {
		$currencies = self::getCurrencies();
		$woo        = self::woo_currency();
		$woo_code   = $woo['currency'];
		$apiKey     = get_option('the4_currency_api_key');

		if ($apiKey == '') {
			echo 'Please insert api key';
			exit();
		}

		//start get rate from yahoo
		$codes = array();
		$code_rate = array();
		foreach( $currencies as $code => $val ) {
			if ( $code != $woo_code && $code != '' ) {
				$key = $woo_code.$code;
				$codes[$code] = $key;
				$code_rate[$key] = $code;
			}
		}

		// Get all rates from Yahoo data
		$all_rates = array();
		$all_rates["USD"] = 1;
		try {
			$all_currencies_data_text = file_get_contents( 'http://data.fixer.io/api/latest?access_key=' . $apiKey );
			$all_currencies_data      = json_decode( $all_currencies_data_text );
			$all_rates = (array) $all_currencies_data->rates;
			// var_dump($all_rates);
			// foreach ( $all_currencies_data->rates AS $currency_resource ) {
			// 	$all_rates[substr( $currency_resource->resource->fields->name, 4 )] = $currency_resource->resource->fields->price;
			// }
		} catch ( Exception $e ) {
			echo 'Can not get currency data from Yahoo';
			exit();
		}
		// var_dump($code_rate, $woo_code); die();
		// Calculator rate
		$rates = array();
		foreach ( $code_rate AS $code ) {
			if ( ! isset( $all_rates[$woo_code] ) ) {
				echo 'Can not get rate of base currency. ( ' . $woo_code . ' )';
				exit();
			}

			if ( isset( $all_rates[$code] ) ) {
				// If default currency is USD
				if ( $woo_code == "EUR" ) {
					$rates['EUR'.$code] = $all_rates[$code];
				} else {
					// Calculator rate of 2 currencies based on USD
					// For example: USDVND = 20000, USDCND = 10000
					// Result: VNDCND = 0.5

					if ( ! isset( $all_rates[$code] ) ) {
						echo 'Can not get rate of second currency. (' . $code . ')';
						exit();
					}  else {
						$rates[$woo_code.$code] = floatval( $all_rates[$code]/$all_rates[$woo_code] );
					}
				}
			}
		}

		// Save
		foreach( $rates as $key => $rate ) {
			$code = $code_rate[$key];
			$current = $currencies[$code];
			$current['woocommerce_price_rate'] = $rate;
			self::saveCurrency( $code, $current );
		}
	}

	/**
	 * List custom currency.
	 */
	public static function list_currency() {
		$currencies  = self::getCurrencies();
		$woocurrency = self::woo_currency();
		$woocode     = $woocurrency['currency'];
		if ( ! isset($currencies[$woocode] ) ) {
			$currencies[$woocode] = $woocurrency;
		}
		$html = '';
		if ( ! empty( $currencies ) ) {
			foreach( $currencies as $c ) {

				if ( $c['currency'] != $woocode ) {
					$html .= '<tr>';
				} else {
					$html .= '<tr style="background-color: #db9925;">';
				}

				$html .= '<td>';
				$html .=  $c['currency'];
				$html .= '</td>';

				$html .= '<td>';
				$html .=  $c['woocommerce_currency_pos'];
				$html .= '</td>';

				$html .= '<td>';
				$html .=  $c['woocommerce_price_thousand_sep'];
				$html .= '</td>';

				$html .= '<td>';
				$html .=  $c['woocommerce_price_decimal_sep'];
				$html .= '</td>';

				$html .= '<td>';
				$html .=  $c['woocommerce_price_num_decimals'];
				$html .= '</td>';

				$html .= '<td>';
				$html .=  number_format_i18n($c['woocommerce_price_rate'], 4);
				$html .= '</td>';

				$html .= '<td>';
				if ( $c['currency'] != $woocode ) {
					$html .=  '<a href="javascript:void(0);" data-currency="' . esc_attr( $c['currency'] ) . '" class="remove-currency">Delete</a>';
				}
				$html .= '</td>';

				$html .= '</tr>';
			}
		}
		echo $html;
		exit;
	}

	/**
	 * Save currency.
	 */
	public static function save_currency() {
		$return = array( 'result' => 0 );
		if ( $_POST['currency'] != '' ) {
			$currency = array();
			$default  = self::get_default();
			foreach( $default as $key => $val ) {
				if ( isset($_POST[$key] ) ) {
					$currency[$key] = $_POST[$key];
				} else {
					$currency[$key] = $val;
				}
			}
			self::saveCurrency( $currency['currency'], $currency );
			$return['result'] = 1;
		}
		echo json_encode( $return );
		exit;
	}

	/**
	 * Remove currency.
	 */
	function remove_currency() {
		if ( $_POST['code'] != '' ) {
			$code = esc_attr($_POST['code'] );
			self::delCurrency( $code );
		}
	}

	/**
	 * Update currency rate.
	 */
	function update_currency_rate() {
		self::autoUpdateCurrencyRate();
		exit;
	}

	/**
	 * Get current currency.
	 */
	public static function getCurrentCurrency() {
		$default    = self::woo_currency();
		$currencies = self::getCurrencies();
		$current    = $default;
		$code       = isset( $_COOKIE['the4_currency'] ) ? $_COOKIE['the4_currency'] : '';

		if ( $code != '' && isset( $currencies[$code] ) ) {
			$current = $currencies[$code];
		}
		return $current;
	}

	/**
	 * Default currency.
	 */
	public static function the4_currency_woocommerce_currency( $default_currency ) {
		$current          = self::getCurrentCurrency();
		$default_currency = self::woo_currency();

		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			return $current['currency'];
		}
		return $default_currency['currency'];
	}

	/**
	 * Currency price format.
	 */
	public static function the4_currency_woocommerce_price_format( $format, $currency_pos ) {
		global $post;
		$currency = false;
		if ( isset( $post->ID ) ) {
			$currency = get_post_meta( $post->ID, '_the4_currency', true );
		}
		$current = self::getCurrentCurrency();
		if ( $currency && is_array( $currency ) && !empty( $currency ) ) {
			$current = $currency;
		}

		$default_currency = self::woo_currency();
		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			$currency_pos = $current['woocommerce_currency_pos'];
			$format = '%1$s%2$s';

			switch ( $currency_pos ) {
				case 'left' :
					$format = '%1$s%2$s';
					break;
				case 'right' :
					$format = '%2$s%1$s';
					break;
				case 'left_space' :
					$format = '%1$s&nbsp;%2$s';
					break;
				case 'right_space' :
					$format = '%2$s&nbsp;%1$s';
					break;
			}

		}
		return apply_filters( 'the4_currency_woocommerce_price_format', $format, $currency_pos );
	}
	/**
	* keep currency instead symbol in order page
	**/
	public static function jsa_keep_currency_in_order_page($currency_symbol, $currency ) {
		global $post;
		if ((isset($_REQUEST['post']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $post->post_type == 'shop_order') || (isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == 'shop_order') ) {
			return $currency . ' ';
		}
		return $currency_symbol;
	}
	/**
	* custom wc_price
	**/
	public static function the4_wc_price( $price, $args = array() ) {
		$args = apply_filters(
			'wc_price_args', wp_parse_args(
				$args, array(
					'ex_tax_label'       => false,
					'currency'           => '',
					'decimal_separator'  => wc_get_price_decimal_separator(),
					'thousand_separator' => wc_get_price_thousand_separator(),
					'decimals'           => wc_get_price_decimals(),
					'price_format'       => get_woocommerce_price_format(),
				)
			)
		);

		$unformatted_price = $price;
		$negative          = $price < 0;
		$price             = floatval( $negative ? $price * -1 : $price );
		$price             = apply_filters( 'formatted_woocommerce_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );

		if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
			$price = wc_trim_zeros( $price );
		}

		$formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol($args['currency']) . '</span> ', $price );
		$return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';
		if ( $args['ex_tax_label'] && wc_tax_enabled() ) {
			$return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
		}
		return $return;
	}
	/**
	* Order price with currency when create order
	**/
	public static function the4_get_formatted_order_total($formatted_total, $order, $tax_display, $display_refunded) {
		$formatted_total = self::the4_currency_raw_woocommerce_price_no_filter($order->get_total(), $order->get_currency());
		$formatted_total = self::the4_wc_price( $formatted_total, array( 'currency' => $order->get_currency() ) );
		$order_total     = $order->get_total();
		$total_refunded  = $order->get_total_refunded();
		$tax_string      = '';

		// Tax for inclusive prices.
		if ( wc_tax_enabled() && 'incl' === $tax_display ) {
			$tax_string_array = array();
			$tax_totals       = $order->get_tax_totals();

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( $tax_totals as $code => $tax ) {
					$tax_amount         = ( $total_refunded && $display_refunded ) ? wc_price( WC_Tax::round( $tax->amount - $order->get_total_tax_refunded_by_rate_id( $tax->rate_id ) ), array( 'currency' => $order->get_currency() ) ) : $tax->formatted_amount;
					$tax_string_array[] = sprintf( '%s %s', $tax_amount, $tax->label );
				}
			} elseif ( ! empty( $tax_totals ) ) {
				$tax_amount         = ( $total_refunded && $display_refunded ) ? $order->get_total_tax() - $order->get_total_tax_refunded() : $order->get_total_tax();
				$tax_string_array[] = sprintf( '%s %s', wc_price( $tax_amount, array( 'currency' => $order->get_currency() ) ), WC()->countries->tax_or_vat() );
			}

			if ( ! empty( $tax_string_array ) ) {
				/* translators: %s: taxes */
				$tax_string = ' <small class="includes_tax">' . sprintf( __( '(includes %s)', 'woocommerce' ), implode( ', ', $tax_string_array ) ) . '</small>';
			}
		}

		if ( $total_refunded && $display_refunded ) {
			$formatted_total = '<del>' . strip_tags( $formatted_total ) . '</del> <ins>' . wc_price( $order_total - $total_refunded, array( 'currency' => $order->get_currency() ) ) . $tax_string . '</ins>';
		} else {
			$formatted_total .= $tax_string;
		}
		return $formatted_total;
	}

	/**
	 * Currency raw price. with filter
	 */
	public static function the4_currency_raw_woocommerce_price( $price ) {
		global $post, $theorder;
		$currency = false;

		if ( ! doing_filter( 'raw_woocommerce_price' ) && ( ! isset( $_REQUEST['wc-ajax'] ) || $_REQUEST['wc-ajax'] != 'checkout' || ! isset( $_REQUEST['payment_method'] ) ) ) {
			return ( $price );
		}

		if (isset($_REQUEST['post']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $post->post_type == 'shop_order') {
			return self::the4_currency_raw_woocommerce_price_no_filter( $price, $theorder->get_currency() );
		}
		return self::the4_currency_raw_woocommerce_price_no_filter( $price );
	}

	/**
	 * Currency raw price no filter
	 */
	public static function the4_currency_raw_woocommerce_price_no_filter( $price, $setCurrency = false ) {
		global $post;
		$currency = false;

		if ( isset( $post->ID ) ) {
			$currency = get_post_meta( $post->ID,' _the4_currency', true );
		}

		$default_currency = self::woo_currency();
		$currencies = self::getCurrencies();
		$current = self::getCurrentCurrency();

		if ( $currency && is_array( $currency ) && ! empty( $currency ) ) {
			$current = $currency;
		}

		if ($setCurrency && isset($currencies[$setCurrency])) {
			$current = $currencies[$setCurrency];
		}

		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			if ( isset( $current['woocommerce_price_rate'] ) && $current['woocommerce_price_rate'] != 1 ) {
				$price = $price * floatval( $current['woocommerce_price_rate'] );
			}
		}

		return ( $price );
	}

	/**
	 * Revert order currency.
	 *
	 * @param   mixed   $value      Current meta value.
	 * @param   int     $object_id  Object ID.
	 * @param   string  $meta_key   Meta key.
	 * @param   bool    $single     Whether to return only the first value of the specified $meta_key.
	 */
	public static function revert_order_curreny( $value, $object_id, $meta_key, $single ) {
		if ( $meta_key == '_order_currency' ) {
			return get_option( 'woocommerce_currency' );
		}
	}

	/**
	 * List custom currency.
	 */
	public static function the4_currency_price_args( $args ) {
		global $post;
		$currency = false;
		if ( isset( $post->ID ) ) {
			$currency = get_post_meta( $post->ID, '_the4_currency', true );
		}
		$current = self::getCurrentCurrency();
		if ( $currency && is_array( $currency ) && !empty( $currency ) ) {
			$current = $currency;
		}

		$default_currency = self::woo_currency();

		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			if ( isset( $current['woocommerce_price_decimal_sep'] ) ) {
				$args['decimal_separator'] = $current['woocommerce_price_decimal_sep'];
			}
			if ( isset( $current['woocommerce_price_thousand_sep'] ) ) {
				$args['thousand_separator'] = $current['woocommerce_price_thousand_sep'];
			}
			if ( isset( $current['woocommerce_price_num_decimals'] ) ) {
				$args['decimals'] = $current['woocommerce_price_num_decimals'];
			}
		}

		return $args;
	}

	public static function the4_currency_decimal_sep( $args ) {
		global $post;
		$currency = false;
		if ( isset( $post->ID ) ) {
			$currency = get_post_meta( $post->ID, '_the4_currency', true );
		}
		$current = self::getCurrentCurrency();
		if ( $currency && is_array( $currency ) && !empty( $currency ) ) {
			$current = $currency;
		}

		$default_currency = self::woo_currency();

		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			if ( isset( $current['woocommerce_price_decimal_sep'] ) ) {
				return $current['woocommerce_price_decimal_sep'];
			}
		}

		return $args;
	}

	public static function the4_currency_thousand_sep( $args ) {
		global $post;
		$currency = false;
		if ( isset( $post->ID ) ) {
			$currency = get_post_meta( $post->ID, '_the4_currency', true );
		}
		$current = self::getCurrentCurrency();
		if ( $currency && is_array( $currency ) && !empty( $currency ) ) {
			$current = $currency;
		}

		$default_currency = self::woo_currency();

		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			if ( isset( $current['woocommerce_price_thousand_sep'] ) ) {
				return $current['woocommerce_price_thousand_sep'];
			}
		}

		return $args;
	}

	public static function the4_currency_num_decimals( $args ) {
		global $post;
		$currency = false;
		if ( isset( $post->ID ) ) {
			$currency = get_post_meta( $post->ID, '_the4_currency', true );
		}
		$current = self::getCurrentCurrency();
		if ( $currency && is_array( $currency ) && !empty( $currency ) ) {
			$current = $currency;
		}

		$default_currency = self::woo_currency();

		if ( isset( $current['currency'] ) && $current['currency'] != $default_currency['currency'] ) {
			if ( isset( $current['woocommerce_price_num_decimals'] ) ) {
				return $current['woocommerce_price_num_decimals'];
			}
		}

		return $args;
	}
	/**
	 * Call when an order is created and save current rate to order
	 *
	 * @param   int   $orderId      order id
	 */
	public static function save_current_rate_to_order($orderId, $data) {
		$current = self::getCurrentCurrency();
		if ( ! add_post_meta( $orderId, '_the4_currency', $current, true ) ) {
		   update_post_meta( $orderId, '_the4_currency', $current );
		}
	}

}
$currency = new Kalles_Addons_Currency;
