<?php
/**
 * Add widget product to elementor
 *
 * @since   1.0.0
 * @package Kalles
 */
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
class Kalles_Elementor_Product_Featured_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-product-featured';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Featured Product', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-single-product';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'products', 'product', 'woocommerce', 'featured' );
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'kalles-elements' );
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function _register_controls() {

       /////////////////////

	    $this->start_controls_section(
			'kalles_addons_product',
			array(
				'label' => esc_html__( 'Content', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'post_id',
			array(
				'label' => esc_html__( 'Products', 'kalles' ),
				'type'  => 'kalles_post_select',
				'post_type'  => 'product',
				'get_data'  => 'the4_kalles_get_data_post_by_id',
				'search'  => 'the4_kalles_search_post_by_query',
				'description' => esc_html__( 'Input product title to see suggestions', 'kalles' ),
				'multiple' => false,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'kalles_addons_product_setting',
			array(
				'label' => esc_html__( 'Setting', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
            'thumbnail',
            array(
                'label' => esc_html__( 'Enable thumbnail', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

		$this->add_control(
			'thumbnail_position',
			array(
				'label' => esc_html__( 'Thumbnail position', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
                    'left' => esc_html__( 'Left', 'kalles' ),
                    'right' => esc_html__( 'Right', 'kalles' ),
                    'bottom' => esc_html__( 'Bottom', 'kalles' ),
				),
				'default' => 'bottom',
				'condition' => [
					'thumbnail' => 'yes'
				]
			)
		);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => esc_html__( 'Product Title', 'kalles' ),
                'separator' => 'before',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .product-title',
            ]
        );
        $this->add_control(
            'product_title_color',
            [
                'label' => esc_html__( 'Product Title Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-title a:not(:hover)' => 'color: {{VALUE}}',
                ],
                'default' => '#222222'
            ]
        );
        $this->add_control(
            'product_price_color',
            [
                'label' => esc_html__( 'Product Price Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-summary .price ins' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .entry-summary .price' => 'color: {{VALUE}}',
                ],
                'default' => ''
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Add To Cart Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-summary .single_add_to_cart_button' => 'background: {{VALUE}}',
                ],
                'default' => ''
            ]
        );
		$this->add_control(
			'meta_heading',
			[
				'label' => esc_html__( 'Product meta', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'the4_kalles_woo_trust_badget',
            array(
                'label' => esc_html__( 'Trust badge', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'the4_kalles_woo_product_delivery_time',
            array(
                'label' => esc_html__( 'Delivery time', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'the4_kalles_woo_flash_coundown',
            array(
                'label' => esc_html__( 'Countdown time', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'the4_kalles_woo_product_live_view',
            array(
                'label' => esc_html__( 'Live view', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'the4_kalles_woo_product_flash_sale',
            array(
                'label' => esc_html__( 'Total sold flash', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'the4_kalles_woo_product_stock_left',
            array(
                'label' => esc_html__( 'Inventory quantity', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'product_meta_social_share',
            array(
                'label' => esc_html__( 'Social share', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'product_meta_meta',
            array(
                'label' => esc_html__( 'Product meta', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

        $this->add_control(
            'view_details',
            array(
                'label' => esc_html__( 'View details', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
            )
        );

		$this->end_controls_section();

	}

	public function get_script_depends() {

		if ( kalles_elementor_is_editor_mode() || kalles_elementor_is_preview_mode() ){
			return [ 'moment' ];
		} else {
			return [];
		}
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		global $kalles_featured_product;

		$settings = $this->get_settings_for_display();

		$kalles_featured_product['thumbnail_position'] = ( $settings['thumbnail_position'] != '' ) ? $settings['thumbnail_position'] : 'bottom';
		$kalles_featured_product['product_meta']['the4_kalles_woo_trust_badget'] = $settings['the4_kalles_woo_trust_badget'];
		$kalles_featured_product['product_meta']['the4_kalles_woo_product_delivery_time'] = $settings['the4_kalles_woo_product_delivery_time'];
		$kalles_featured_product['product_meta']['the4_kalles_woo_flash_coundown'] = $settings['the4_kalles_woo_flash_coundown'];
		$kalles_featured_product['product_meta']['the4_kalles_woo_product_live_view'] = $settings['the4_kalles_woo_product_live_view'];
		$kalles_featured_product['product_meta']['the4_kalles_woo_product_stock_left'] = $settings['the4_kalles_woo_product_stock_left'];
		$kalles_featured_product['product_meta']['the4_kalles_woo_product_flash_sale'] = $settings['the4_kalles_woo_product_flash_sale'];
		$kalles_featured_product['product_meta_social_share'] = $settings['product_meta_social_share'];
		$kalles_featured_product['product_meta_meta'] = $settings['product_meta_meta'];
		$kalles_featured_product['view_details'] = $settings['view_details'];
		$kalles_featured_product['thumbnail'] = $settings['thumbnail'];


		if ( $settings['post_id'] !== '' ) {

			$args = array(
				'post_type'              => 'product',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'post_status'            => 'publish',
				'cache_results'          => false,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'meta_query'             => WC()->query->get_meta_query()
			);

			$args['p'] = $settings['post_id'];

			$product = new WP_Query( $args );

			if ( $product->have_posts() ) : ?>

				<?php while ( $product->have_posts() ) : $product->the_post(); ?>

					<?php wc_get_template_part( 'content', 'featured-product' ); ?>

				<?php endwhile; // end of the loop.

			endif;

			wp_reset_postdata();
		}

		$kalles_featured_product = null;

		if ( is_admin() ){

          echo "
         <script>
          if ( jQuery( '.the4-carousel' ).length > 0 ){
            jQuery( '.the4-carousel' ).not('.slick-initialized').slick({focusOnSelect: true});
          }
          The4Kalles.The4KallesProductSection();
          The4Kalles.initCountdown();
         </script>";
        }

        return;

	}

    /**
	 * Render widget as plain content.
	 *
	 * Override the default behavior by printing the shortcode instead of rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 public function render_plain_content() {

	 }

}
/////////////////////
