<?php
/**
 * Layered nav widget
 *
 * @package The4_Kalles_Widget_Layered_Nav
 * @since 1.0.0
 */



defined( 'ABSPATH' ) || exit;

use Automattic\Jetpack\Constants;
use WC_Query as WC_Query;

function log_me($message) {
	if (WP_DEBUG === true) {
		if (is_array($message) || is_object($message)) {
			error_log(print_r($message, true));
		} else {
			error_log($message);
		}
	}
}
/**
 * Widget layered nav class.
 */
if (class_exists('WooCommerce') && class_exists('CSF')) {
	class The4_Woocommerce_Layered_Nav_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {

		}


		/**
		 * Output HTML.
		 *
		 *
		 * @param array $args Arguments.
		 * @param array $instance Instance.
		 */
		public function displayHtml($args, $instance) {

			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
			$taxonomy           = $this->get_instance_taxonomy();
			$query_type         = $this->get_instance_query_type( $instance );
			$display_type       = $this->get_instance_display_type( $instance );

			$found = array();

			foreach ($taxonomy as $tax) {
				$terms = get_terms( $tax, array( 'hide_empty' => '1' ) );
				if ( $display_type == 'list' ) {
					$found[] = $this->layered_nav_list( $terms, $tax, $query_type, $instance );
				} else {
					$found[] = $this->layered_nav_dropdown( $terms, $tax, $query_type, $instance );
				}
			}

			$price_filter_type = isset( $instance['w_filter-price_type'] ) ? $instance['w_filter-price_type'] : 'slider';

			//Check if config filter by Price
			if (in_array('pa_price', $instance['w_filter-attrs']) ) {

				if ( $price_filter_type == 'slider' ) {
					$step =  isset( $instance['w_filter-price_slider_step'] ) && $instance['w_filter-price_slider_step'] != 0  ? $instance['w_filter-price_slider_step'] : 1;
					$this->filter_price_slider( $step, $display_type );

				} else {
					The4Helper::ksesHTML( $this->get_filter_price_link($instance) );
				}
			}

			ob_start();

			// Force found when option is selected - do not force found on taxonomy attributes.

			if ( ! is_array( $taxonomy  ) ) {
				if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
					$found = true;
				}
			}

			if ( ! $found ) {
				ob_end_clean();
			} else {
				echo ob_get_clean(); // @codingStandardsIgnoreLine
			}
		}

		public function woo_slider_script()
		{

			$suffix       = Constants::is_true( 'SCRIPT_DEBUG' ) ? '' : '.min';
			$version      = Constants::get_constant( 'WC_VERSION' );

			wp_register_script( 'accounting', WC()->plugin_url() . '/assets/js/accounting/accounting' . $suffix . '.js', array( 'jquery' ), '0.4.2', true );
			wp_register_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), $version, true );
			wp_register_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch', 'accounting' ), $version, true );
			wp_localize_script(
				'wc-price-slider',
				'woocommerce_price_slider_params',
				array(
					'currency_format_num_decimals' => 0,
					'currency_format_symbol'       => get_woocommerce_currency_symbol(),
					'currency_format_decimal_sep'  => esc_attr( wc_get_price_decimal_separator() ),
					'currency_format_thousand_sep' => esc_attr( wc_get_price_thousand_separator() ),
					'currency_format'              => esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) ),
				)
			);
		}

		/**
		 * Get this widgets taxonomy.
		 *
		 * @param array $instance Array of instance options.
		 * @return string
		 */
		protected function get_instance_taxonomy() {
			if ( isset( $instance['attribute'] ) ) {
				return wc_attribute_taxonomy_name( $instance['attribute'] );
			}

			$attribute_taxonomies = wc_get_attribute_taxonomies();

			$attributes = array();
			if ( ! empty( $attribute_taxonomies ) ) {
				foreach ( $attribute_taxonomies as $tax ) {
					$attributes[] = wc_attribute_taxonomy_name( $tax->attribute_name );
				}
			}
			return $attributes;
		}

		/**
		 * Get this widgets query type.
		 *
		 * @param array $instance Array of instance options.
		 * @return string
		 */
		protected function get_instance_query_type( $instance ) {
			return isset( $instance['w_filter-query'] ) ? $instance['w_filter-query'] : 'and';
		}

		/**
		 * Get this widgets display type.
		 *
		 * @param array $instance Array of instance options.
		 * @return string
		 */
		protected function get_instance_display_type( $instance ) {
			return isset( $instance['w_filter-type'] ) ? $instance['w_filter-type'] : 'list';
		}

		/**
		 * Return the currently viewed taxonomy name.
		 *
		 * @return string
		 */
		protected function get_current_taxonomy() {
			return is_tax() ? get_queried_object()->taxonomy : '';
		}

		/**
		 * Return the currently viewed term ID.
		 *
		 * @return int
		 */
		protected function get_current_term_id() {
			return absint( is_tax() ? get_queried_object()->term_id : 0 );
		}

		/**
		 * Return the currently viewed term slug.
		 *
		 * @return int
		 */
		protected function get_current_term_slug() {
			return absint( is_tax() ? get_queried_object()->slug : 0 );
		}

		/**
		 * Return the name of taxonomy.
		 *
		 * @return string
		 */
		protected function get_term_name($taxonomy)
		{
			$attributes = wc_get_attribute_taxonomies();

			if ( !empty($attributes) ) {
				foreach ($attributes as $attr) {
					$attr_id = 'pa_' . $attr->attribute_name;
					if ( $attr_id == $taxonomy)
						return $attr->attribute_label;
				}
			}
		}

		/**
		 * Show list based layered nav.
		 *
		 * @param  array  $terms Terms.
		 * @param  string $taxonomy Taxonomy.
		 * @param  string $query_type Query Type.
		 * @return bool   Will nav display?
		 */
		protected function layered_nav_list( $terms, $taxonomy, $query_type, $instance ) {

			$display_type = isset($instance['w_filter-type']) ? $instance['w_filter-type'] : 'list';
			$is_count = isset($instance['w_filter-count']) ? $instance['w_filter-count'] : false;
			$ul_classes = $display_type;
			$ul_classes .= ' filter-top';
			// List display.

			$term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
			$found              = false;
			$base_link          = $this->get_current_page_url();

			//Check if have filter
			if ( !empty($term_counts) && in_array($taxonomy, $instance['w_filter-attrs'])) {


				echo '<div class="col-12	 col-md-3">';
				echo '<h5 class="widget-title"><span>' . translate('By ', 'kalles').' </span> ' . $this->get_term_name($taxonomy) . '</h5>';
				echo '<ul class="nt_filter_block css_ntbar ' . $ul_classes . '">';

				foreach ( $terms as $term ) {

					$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
					$option_is_set  = in_array( $term->slug, $current_values, true );
					$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

					// Skip the term for the current archive.
					if ( $this->get_current_term_id() === $term->term_id ) {
						continue;
					}

					// Only show options with count > 0.
					if ( 0 < $count ) {
						$found = true;
					} elseif ( 0 === $count && ! $option_is_set ) {
						continue;
					}
					$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended
					$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
					$current_filter = array_map( 'sanitize_title', $current_filter );

					if ( ! in_array( $term->slug, $current_filter, true ) ) {
						$current_filter[] = $term->slug;
					}

					$link = remove_query_arg( $filter_name, $base_link );

					// Add current filters to URL.
					foreach ( $current_filter as $key => $value ) {
						// Exclude query arg for current term archive term.
						if ( $value === $this->get_current_term_slug() ) {
							unset( $current_filter[ $key ] );
						}

						// Exclude self so filter can be unset on click.
						if ( $option_is_set && $value === $term->slug ) {
							unset( $current_filter[ $key ] );
						}
					}

					if ( ! empty( $current_filter ) ) {
						asort( $current_filter );
						$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

						// Add Query type Arg to URL.
						if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
							$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
						}
						$link = str_replace( '%2C', ',', $link );
					}

					$classes = $swatch_attr_image = '';

					$meta_swatches = get_term_meta( $term->term_id, '_custom_product_attr_options', true );

                    $swatch_attr_color   = isset( $meta_swatches['color-color'] ) ? $meta_swatches['color-color'] : '';
                    $swatch_attr_image   = isset( $meta_swatches['color-image']['url'] ) ? $meta_swatches['color-image']['url'] : '' ;

                    //Brand logo
                    if ( isset( $meta_swatches['brand-image']['url'] ) ) {
                    	$swatch_attr_image   = $meta_swatches['brand-image']['url'];
                    	$classes .= ' type-brand';
                    }

					if ( !empty($swatch_attr_color ) || !empty( $swatch_attr_image ) ) {
						$classes .= ' nt_filter_color';
						if ($swatch_attr_color == '#ffffff')
							$classes .= ' has-border';
						if (empty($swatch_attr_image)) {
							$color_style = 'background-color: '  . $swatch_attr_color;
						} else {

							$color_style = 'background-image: url('  . $swatch_attr_image .')';
						}

					}
					$link_class = $option_is_set ? 'active' : '';
					if ( $count > 0 || $option_is_set ) {
						$link      = apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy );
						$term_html = '<a rel="nofollow" href="' . esc_url( $link ) . '" class="' .$link_class . '">';
						if (!empty($swatch_attr_color) || !empty($swatch_attr_image) ) {
							$term_html .= '<div class="filter-swatch">
											<span class="filter-swatch-color" style="' . $color_style .'"></span>
										   </div>';
						}
						$term_html .= esc_html( $term->name ) . '</a>';
					} else {
						$link      = false;
						$term_html = '<span>';

						if (!empty($swatch_attr_color) || !empty($swatch_attr_image) ) {
							$term_html .= '<div class="filter-swatch"><span class="filter-swatch-color" style="' . $color_style .'"></span> </div>';
						}

						$term_hmtl .= esc_html( $term->name ) . '</span>';
					}
					if ( $is_count )
						$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

					echo '<li class="wc-layered-nav-term' . $classes .'">';
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.EscapeOutput.OutputNotEscaped
					echo apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count );
					echo '</li>';
				}

				echo '</ul>';
				echo '</div>';
			}


			return $found;
		}


		/**
		 * Show Dropdown based layered nav.
		 *
		 * @param  array  $terms Terms.
		 * @param  string $taxonomy Taxonomy.
		 * @param  string $query_type Query Type.
		 * @return bool   Will nav display?
		 */
		protected function layered_nav_dropdown( $terms, $taxonomy, $query_type, $instance ) {

			$is_count = isset($instance['w_filter-count']) ? $instance['w_filter-count'] : false;
			$ul_classes = 'dropdown';
			$ul_classes .= ' filter-top';
			// List display.

			$term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
			$found              = false;
			$base_link          = $this->get_current_page_url();

			//Check if have filter
			if ( ! empty($term_counts) && in_array($taxonomy, $instance['w_filter-attrs'])) {


				echo '<div class="col-12 col-md-3 filter-dropdown pr">';
				echo '<div class="filter-dropdown__title pr flex"><span class="filter-dropdown__text">' . $this->get_term_name($taxonomy) . '</span>';
				echo '<ul class="filter-dropdown__result"></ul></div>';

				echo '<div class="filter-dropdown__dropdown dn"><ul class="nt_filter_block css_ntbar filter-dropdown__content ' . $ul_classes . '">';

				foreach ( $terms as $term ) {

					$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
					$option_is_set  = in_array( $term->slug, $current_values, true );
					$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

					// Skip the term for the current archive.
					if ( $this->get_current_term_id() === $term->term_id ) {
						continue;
					}

					// Only show options with count > 0.
					if ( 0 < $count ) {
						$found = true;
					} elseif ( 0 === $count && ! $option_is_set ) {
						continue;
					}
					$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended
					$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
					$current_filter = array_map( 'sanitize_title', $current_filter );

					if ( ! in_array( $term->slug, $current_filter, true ) ) {
						$current_filter[] = $term->slug;
					}

					$link = remove_query_arg( $filter_name, $base_link );

					// Add current filters to URL.
					foreach ( $current_filter as $key => $value ) {
						// Exclude query arg for current term archive term.
						if ( $value === $this->get_current_term_slug() ) {
							unset( $current_filter[ $key ] );
						}

						// Exclude self so filter can be unset on click.
						if ( $option_is_set && $value === $term->slug ) {
							unset( $current_filter[ $key ] );
						}
					}

					if ( ! empty( $current_filter ) ) {
						asort( $current_filter );
						$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

						// Add Query type Arg to URL.
						if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
							$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
						}
						$link = str_replace( '%2C', ',', $link );
					}

					$classes = $swatch_attr_image = '';

					$meta_swatches = get_term_meta( $term->term_id, '_custom_product_attr_options', true );

                    $swatch_attr_color   = isset( $meta_swatches['color-color'] ) ? $meta_swatches['color-color'] : '';
                    $swatch_attr_image   = isset( $meta_swatches['color-image']['url'] ) ? $meta_swatches['color-image']['url'] : '' ;

                    //Brand logo
                    if ( isset( $meta_swatches['brand-image']['url'] ) ) {
                    	$swatch_attr_image   = $meta_swatches['brand-image']['url'];
                    	$classes .= ' type-brand';
                    }

					if ( !empty($swatch_attr_color ) || !empty( $swatch_attr_image ) ) {
						$classes .= ' nt_filter_color';
						if ($swatch_attr_color == '#ffffff')
							$classes .= ' has-border';
						if (empty($swatch_attr_image)) {
							$color_style = 'background-color: '  . $swatch_attr_color;
						} else {

							$color_style = 'background-image: url('  . $swatch_attr_image .')';
						}

					}
					$link_class = $option_is_set ? 'active' : '';
					if ( $count > 0 || $option_is_set ) {
						$link      = apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy );
						$term_html = '<a rel="nofollow" href="' . esc_url( $link ) . '" class="' .$link_class . '">';
						if (!empty($swatch_attr_color) || !empty($swatch_attr_image) ) {
							$term_html .= '<div class="filter-swatch">
											<span class="filter-swatch-color" style="' . $color_style .'"></span>
										   </div>';
						}
						$term_html .= esc_html( $term->name ) . '</a>';
					} else {
						$link      = false;
						$term_html = '<span>';

						if (!empty($swatch_attr_color) || !empty($swatch_attr_image) ) {
							$term_html .= '<div class="filter-swatch"><span class="filter-swatch-color" style="' . $color_style .'"></span> </div>';
						}

						$term_hmtl .= esc_html( $term->name ) . '</span>';
					}
					if ( $is_count )
						$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

					echo '<li class="wc-layered-nav-term' . $classes .'">';
					// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.EscapeOutput.OutputNotEscaped
					echo apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count );
					echo '</li>';
				}

				echo '</ul>';
				echo '</div>'; //filter-dropdown__dropdown
				echo '</div>';
			}


			return $found;
		}



		/**
		 * Count products within certain terms, taking the main WP query into consideration.
		 *
		 * This query allows counts to be generated based on the viewed products, not all products.
		 *
		 * @param  array  $term_ids Term IDs.
		 * @param  string $taxonomy Taxonomy.
		 * @param  string $query_type Query Type.
		 * @return array
		 */
		protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
			global $wpdb;

			$tax_query  = $this->get_main_tax_query();
			$meta_query = $this->get_main_meta_query();

			if ( 'or' === $query_type ) {
				foreach ( $tax_query as $key => $query ) {
					if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
						unset( $tax_query[ $key ] );
					}
				}
			}

			$meta_query     = new WP_Meta_Query( $meta_query );
			$tax_query      = new WP_Tax_Query( $tax_query );
			$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
			$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );
			$term_ids_sql   = '(' . implode( ',', array_map( 'absint', $term_ids ) ) . ')';

			if ( $term_ids_sql == '()' ) {
				$term_ids_sql = '(0)';
			}

			// Generate query.
			$query           = array();
			$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) AS term_count, terms.term_id AS term_count_id";
			$query['from']   = "FROM {$wpdb->posts}";
			$query['join']   = "
				INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
				INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
				INNER JOIN {$wpdb->terms} AS terms USING( term_id )
				" . $tax_query_sql['join'] . $meta_query_sql['join'];

			$query['where'] = "
				WHERE {$wpdb->posts}.post_type IN ( 'product' )
				AND {$wpdb->posts}.post_status = 'publish'
				{$tax_query_sql['where']} {$meta_query_sql['where']}
				AND terms.term_id IN $term_ids_sql";

			$search = $this->get_main_search_query_sql();
			if ( $search ) {
				$query['where'] .= ' AND ' . $search;
			}

			$query['group_by'] = 'GROUP BY terms.term_id';
			$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
			$query_sql         = implode( ' ', $query );

			// We have a query - let's see if cached results of this query already exist.
			$query_hash = md5( $query_sql );

			// Maybe store a transient of the count values.
			$cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
			if ( true === $cache ) {
				$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
			} else {
				$cached_counts = array();
			}

			if ( ! isset( $cached_counts[ $query_hash ] ) ) {
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				$results                      = $wpdb->get_results( $query_sql, ARRAY_A );
				$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
				$cached_counts[ $query_hash ] = $counts;
				if ( true === $cache ) {
					set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
				}
			}

			return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
		}

		/**
		 * Wrapper for WC_Query::get_main_tax_query() to ease unit testing.
		 *
		 * @since 4.4.0
		 * @return array
		 */
		protected function get_main_tax_query() {
			return WC_Query::get_main_tax_query();
		}

		/**
		 * Wrapper for WC_Query::get_main_search_query_sql() to ease unit testing.
		 *
		 * @since 4.4.0
		 * @return string
		 */
		protected function get_main_search_query_sql() {
			return WC_Query::get_main_search_query_sql();
		}

		/**
		 * Wrapper for WC_Query::get_main_search_queryget_main_meta_query to ease unit testing.
		 *
		 * @since 4.4.0
		 * @return array
		 */
		protected function get_main_meta_query() {
			return WC_Query::get_main_meta_query();
		}




		/**
		 * Get current page URL for layered Nav
		 *
		 * @return string
		 * @since  1.0.0
		 * @base on WC widget_text
		 */
		protected function get_current_page_url() {
			if ( Constants::is_defined( 'SHOP_IS_ON_FRONT' ) ) {
				$link = home_url();
			} elseif ( is_shop() ) {
				$link = get_permalink( wc_get_page_id( 'shop' ) );
			} elseif ( is_product_category() ) {
				$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
			} elseif ( is_product_tag() ) {
				$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
			} else {
				$queried_object = get_queried_object();
				$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
			}

			// Min/Max.
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
			}

			// Order by.
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg.
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

				// Prevent post type and page id when pretty permalinks are disabled.
				if ( is_shop() ) {
					$link = remove_query_arg( 'page_id', $link );
				}
			}

			// Min Rating Arg.
			if ( isset( $_GET['rating_filter'] ) ) {
				$link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
			}

			// All current filters.
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
				foreach ( $_chosen_attributes as $name => $data ) {
					$filter_name = wc_attribute_taxonomy_slug( $name );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' === $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}

			return apply_filters( 'woocommerce_widget_get_current_page_url', $link, $this );
		}

		/**
		 * Get filter price link
		 *
		 *
		 * @return string
		 */
		public function get_filter_price_link($instance)
		{
			$links = [];

			$link = $this->get_current_page_url();

			$price = $this->get_filtered_price();
            $min = $price['min'];
            $max = $price['max'];

			$range = $instance['w_filter-price_range'];
            $step = ceil( $max / $range );

			$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
            $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

            $is_count = $instance['w_filter-count'];


            for ( $i = 0; $i < (int) $step; $i++) {

            	$step_title = $step_class = $href = '';

            	$step_min = $range * $i;

            	$step_max = $range * ( $i + 1);

            	$href = add_query_arg('min_price', $step_min, $link);
            	$href = add_query_arg('max_price', $step_max, $href);

            	$step_title = wc_price( $step_min ) . ' - ' . wc_price( $step_max );

            	$count = 0;
            	if ($is_count) {
	            	$count = $this->get_count_price_filter($step_min, $step_max);;
	            }

            	if ( !empty( $min_price ) && !empty( $max_price ) && ( $min_price >= $step_min && $max_price <= $step_max)
            		|| ($i == 0 && !empty( $max_price ) && $min_price == 0 )
            	)	$step_class = 'active';

            	$links[] = array(
            		'href' => $href,
            		'title' => $step_title,
            		'class' => $step_class,
            		'count' => $count
            	);
            }
            $html = '';

            if ( !empty( $links ) ) {
            	$html .= '<div class="col-12 col-md-3">';
	            $html .= '<h5 class="widget-title"><span>' . translate( 'By ', 'kalles' ) . '</span>' . translate( 'Price', 'kalles' ) . '</h5>';
	            $html .= '<ul class="nt_filter_block css_ntbar list filter-top">';
	            	foreach ($links as $link) {
						if(!$link['count'] == 0){
							$html .= '<li class="wc-layered-nav-term">';
							$html .= '<a href="' . $link['href'] . '" rel="nofollow" class="' . $link['class'] . '">' . $link['title'] . '</a>';
							if ( $is_count ) {
									$html .= '<span class="count">(' . $link['count'] . ')</span>';								
							}
							$html .= '</li>';
						}
	            	}

	            $html .= '</ul>';
	            $html .= '</div>';
            }

            return $html;

		}
		/**
		 * @param $min_price, $max_price
		 *
		 * Get count filtered min & max price for current products.
		 *
		 * @return int
		 */
		function get_count_price_filter($min_price = '', $max_price = ''){
            if(!$min_price && !$max_price) return;
            global $wp_the_query;
            $old_query       = $wp_the_query->query_vars;
            if(!$min_price && $max_price){
                $meta_price = array(
                    array(
                        'key' => '_price',
                        'value' => $max_price,
                        'compare' => '<=',
                        'type' => 'NUMERIC'
                    )
                );
            }
            if(!$max_price && $min_price){
                $meta_price = array(
                    array(
                        'key' => '_price',
                        'value' => $min_price,
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    )
                );
            }
            if($min_price && $max_price){
                $meta_price = array(
                    array(
                        'key' => '_price',
                        'value' => array($min_price, $max_price),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    )
                );
            }
            $args = array(
                'post_type' => array('product'),
                'post_status'   =>  'publish',
                'posts_per_page'    =>  -1,
                'meta_query' => $meta_price
            );

            $tax_query  = isset( $old_query['tax_query'] ) ? $old_query['tax_query'] : array();
            if ( version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
                $tax_query[] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'name',
                    'terms' => 'exclude-from-catalog',
                    'operator' => 'NOT IN',
                );
            } else {
                $args['meta_query'][] = array(
                    'key' => '_visibility',
                    'value' => array( 'catalog', 'visible' ),
                    'compare' => 'IN'
                );
            }
            if(is_tax()){
                if ( ! empty( $old_query['taxonomy'] ) && ! empty( $old_query['term'] ) ) {
                    $tax_query[] = array(
                        'taxonomy' => $old_query['taxonomy'],
                        'terms'    => array( $old_query['term'] ),
                        'field'    => 'slug',
                    );
                }
            }
            $args['tax_query']  = $tax_query;
            $myposts = get_posts($args);
            return count($myposts);
        }
		/**
		 * Get filtered min & max price for current products.
		 *
		 * @return array
		 */
		public function get_filtered_price()
		{
			global $wpdb;

			$args       = wc()->query->get_main_query();

			$tax_query  = isset( $args->tax_query->queries ) ? $args->tax_query->queries : array();
			$meta_query = isset( $args->query_vars['meta_query'] ) ? $args->query_vars['meta_query'] : array();

			foreach ( $meta_query + $tax_query as $key => $query ) {
				if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
					unset( $meta_query[ $key ] );
				}
			}

			$meta_query = new \WP_Meta_Query( $meta_query );
			$tax_query  = new \WP_Tax_Query( $tax_query );

			$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
			$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

			$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
			$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
			$sql .= " 	WHERE {$wpdb->posts}.post_type IN ('product')
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('_price')
					AND price_meta.meta_value > '' ";
			$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

			$search = \WC_Query::get_main_search_query_sql();
			if ( $search ) {
				$sql .= ' AND ' . $search;
			}

			$prices = $wpdb->get_row( $sql ); // WPCS: unprepared SQL ok.

			return [
				'min' => floor( $prices->min_price ),
				'max' => ceil( $prices->max_price )
			];
		}

		/**
		 * Price slider.
		 *
		 * @see WC_Widget_Price_Filter
		 *
		 */
		public function filter_price_slider( $step, $filter_type ) {
			global $wp;

			// Requires lookup table added in 3.6.
			if ( version_compare( get_option( 'woocommerce_db_version', null ), '3.6', '<' ) ) {
				return;
			}

			if ( ! is_shop() && ! is_product_taxonomy() ) {
				return;
			}

			// If there are not posts and we're not filtering, hide the widget.
			if ( ! WC()->query->get_main_query()->post_count && ! isset( $_GET['min_price'] ) && ! isset( $_GET['max_price'] ) ) { // WPCS: input var ok, CSRF ok.
				return;
			}

			wp_enqueue_script( 'wc-price-slider' );

			// Find min and max price in current result set.
			$prices    = $this->get_filtered_price();
			$min_price = $prices['min'];
			$max_price = $prices['max'];

			// Check to see if we should add taxes to the prices if store are excl tax but display incl.
			$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );

			if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === $tax_display_mode ) {
				$tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
				$tax_rates = WC_Tax::get_rates( $tax_class );

				if ( $tax_rates ) {
					$min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
					$max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
				}
			}

			$min_price = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price / $step ) * $step );
			$max_price = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price / $step ) * $step );

			// If both min and max are equal, we don't need a slider.
			if ( $min_price === $max_price ) {
				return;
			}

			$current_min_price = isset( $_GET['min_price'] ) ? floor( floatval( wp_unslash( $_GET['min_price'] ) ) / $step ) * $step : $min_price; // WPCS: input var ok, CSRF ok.
			$current_max_price = isset( $_GET['max_price'] ) ? ceil( floatval( wp_unslash( $_GET['max_price'] ) ) / $step ) * $step : $max_price; // WPCS: input var ok, CSRF ok.

			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
			}

			wc_get_template(
				'content-widget-price-filter.php',
				array(
					'form_action'       => $form_action,
					'step'              => $step,
					'min_price'         => $min_price,
					'max_price'         => $max_price,
					'current_min_price' => $current_min_price,
					'current_max_price' => $current_max_price,
					'filter_type'		=> $filter_type
				)
			);

		}

	} //End Class

	//Get all Attribute filllter
	if ( ! function_exists( 'kalles_w_filter_get_attributes' ) ) {
		function kalles_w_filter_get_attributes() {
			$attrs = [];
			$attrs_taxonomies = wc_get_attribute_taxonomies();

			if (!empty($attrs_taxonomies)) {
				foreach ($attrs_taxonomies as $tax) {
					$attrs['pa_' . $tax->attribute_name] = $tax->attribute_name;
				}
			}
			$attrs['pa_price'] = 'price';
			return $attrs;
		}
	}

	CSF::createWidget( 'kalles_w_filter', array(
	  'title'       => 'Kalles Shop Filter',
	  'classname'   => 'row wrap_filter',
	  'description' => 'Filter product by Price, color, tag... on product list',
	  'fields'      => array(
	    array(
		  'id'         => 'w_filter-attrs',
		  'type'       => 'checkbox',
		  'title'      => translate('Select Attributes' , 'kalles'),
		  'options'    => kalles_w_filter_get_attributes(),
		  'default'    => kalles_w_filter_get_attributes()
		),
		array(
		  'id'          => 'w_filter-type',
		  'type'        => 'button_set',
		  'title'       => translate('Filter layout' , 'kalles'),
		  'placeholder' => 'Select an option',
		  'options'     => array(
			'list'     	 => 'List',
			'dropdown'   => 'Dropdown',
		  ),
		  'default'     => 'list'
		),
		array(
		  'id'          => 'w_filter-price_type',
		  'type'        => 'button_set',
		  'title'       => translate('Price filter type' , 'kalles'),
		  'placeholder' => 'Select an option',
		  'options'     => array(
			'slider'     => 'Slider',
			'checkbox'   => 'Checkbox',
		  ),
		  'default'     => 'slider'
		),
		array(
		  'id'      => 'w_filter-price_slider_step',
		  'type'    => 'slider',
		  'title'   => 'Price slider step',
		  'min'     => 5,
		  'max'     => 200,
		  'step'    => 5,
		  'unit'    => get_option('woocommerce_currency'),
		  'default' => 10,
		  'dependency' => array( 'w_filter-price_type', '==', 'slider' ),
		),
		array(
		  'id'      => 'w_filter-price_range',
		  'type'    => 'slider',
		  'title'   => 'Price Range',
		  'min'     => 10,
		  'max'     => 500,
		  'step'    => 10,
		  'unit'    => get_option('woocommerce_currency'),
		  'default' => 100,
		  'dependency' => array( 'w_filter-price_type', '==', 'checkbox' ),
		),
		array(
		  'id'    => 'w_filter-count',
		  'type'  => 'switcher',
		  'title' => translate('Enable count?', 'kalles'),
		  'default'  => true,
		),
		array(
		  'id'          => 'w_filter-query',
		  'type'        => 'button_set',
		  'title'       => translate('Query type' , 'kalles'),
		  'placeholder' => 'Select an option',
		  'options'     => array(
			'and'     => 'AND',
			'or'   => 'OR',
		  ),
		  'default'     => 'and'
		),
	  )
	) );

	if ( ! function_exists( 'kalles_w_filter' ) ) {
	  function kalles_w_filter( $args, $instance ) {
	  	$kalles_w_filter = new The4_Woocommerce_Layered_Nav_Widget();

	  	$filter_type = isset( $instance['w_filter-price_type'] ) ? $instance['w_filter-price_type'] : 'slider';

	  	if ( $filter_type == 'slider' ) {
	  		$kalles_w_filter->woo_slider_script();
	  		wp_enqueue_script( 'wc-price-slider' );
	  	}
	    The4Helper::ksesHTML( $args['before_widget'] );

	    $kalles_w_filter->displayHtml($args, $instance);



	    The4Helper::ksesHTML( $args['after_widget'] );

	  }
	}


}

