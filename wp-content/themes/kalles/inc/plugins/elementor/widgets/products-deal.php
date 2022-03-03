<?php
/**
 * Add widget products to elementor
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

class Kalles_Elementor_Products_Deal_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
       parent::__construct($data, $args);
    }

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-products-deal';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Deal of the day', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-archive-posts';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'products', 'product', 'woocommerce', 'deal' );
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


       $products = get_posts( array(
            'post_type'              => 'product',
			'posts_per_page'         => -1,
			'post_status'            => 'publish',
			'cache_results'          => false,
			'orderby'                => 'title',
			'order'                  => 'ASC',
       ) );
       if ( !empty($products) ){
        foreach($products as $product){
            $product_titles[$product->ID] = get_the_title($product->ID);
        }
       }

       $this->start_controls_section(
			'kalles_addons_products_deal_products',
			array(
				'label' => esc_html__( 'Products', 'kalles' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'product_id',
			array(
				'label' => esc_html__( 'Products', 'kalles' ),
                'description' => esc_html__( 'Input product title to see suggestions', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
				'options' => $product_titles,
			)
		);

		$repeater->add_control(
			'product_stock',
			array(
				'label' => esc_html__( 'Total stock', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' => [
					'ea' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
			)
		);

		$repeater->add_control(
			'available_stock',
			array(
				'label' => esc_html__( 'Available Stock', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 75,
				],
				'range' => [
					'ea' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
			)
		);

		$this->add_control(
			'product_items',
			[
				'type'        => Controls_Manager::REPEATER,
				'title_field' => 'Product',
				'fields'      => $repeater->get_controls(),
				'default'     => [
				],
			]
		);

		$this->end_controls_section();

	    $this->start_controls_section(
			'kalles_addons_products_deal_setting',
			array(
				'label' => esc_html__( 'Setting', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

	    $this->add_control(
			'title',
			array(
				'label' => esc_html__( 'Heading', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => 'Daily Deal Of The Day',
			)
		);

        $this->add_control(
			'style',
			array(
				'label' => esc_html__( 'List product style', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'grid' => esc_html__( 'Grid', 'kalles' ),
					'masonry' => esc_html__( 'Masonry', 'kalles' ),
					'metro' => esc_html__( 'Metro', 'kalles' ),
                    'carousel' => esc_html__( 'Carousel', 'kalles' ),
				),
				'default' => 'grid',
			)
		);

		$this->add_control(
			'limit',
			array(
				'label' => esc_html__( 'Per Page', 'kalles' ),
                'description' => esc_html__( 'How much items per page to show (-1 to show all products)', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => '12',
			)
		);

		$this->add_control(
			'countdown_heading',
			[
				'label' => esc_html__( 'Countdown', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'coundown_text',
			array(
				'label' => esc_html__( 'Text', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => 'End in:',
			)
		);

		$this->add_control(
			'coundown_date',
			[
				'label'   => esc_html__( 'Data countdown', 'kalles' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => date( 'Y-m-d', strtotime( ' +2 months' ) ),
			]
		);

		$this->add_control(
			'coundown_bg_color',
			[
				'label' => esc_html__( 'Coundown Background Color', 'kalles' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.medizin_laypout .countdown-wrap' => 'background-color: {{VALUE}}',
				],
				'default' => '#E4573D'
			]
		);

		$this->add_control(
            'coundown_text_color',
            [
                'label' => esc_html__( 'Coundown Text Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.medizin_laypout .countdown-wrap' => 'color: {{VALUE}}',
                ],
                'default' => '#FFFFFF'
            ]
        );
        $this->add_control(
            'heading_text_bacground_color',
            [
                'label' => esc_html__( 'Heading Text Background Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.medizin_laypout .product-cd-header' => 'background-color: {{VALUE}}',
                ],
                'default' => '#FFFFFF'
            ]
        );
        $this->add_control(
            'heading_text_color',
            [
                'label' => esc_html__( 'Heading Text Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} div.medizin_laypout .product-cd-header .product-cd-heading' => 'color: {{VALUE}}',
                ],
                'default' => '#111'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label'   => esc_html__( 'Heading Text Typography', 'kalles' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} div.medizin_laypout .product-cd-header .product-cd-heading',
            ]
        );
		//////////////////////////
		///
		$this->add_control(
			'stock_view',
			array(
				'label' => esc_html__( 'Show stock bar', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Enable', 'kalles' ),
				'label_on' => esc_html__( 'Disable', 'kalles' ),
				'separator' => 'before',
                'default' => 'yes',
			)
		);

		$this->add_control(
			'loadmore',
			array(
				'label' => esc_html__( 'Load more button', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Enable', 'kalles' ),
				'label_on' => esc_html__( 'Disable', 'kalles' ),
				'separator' => 'before',
                'default' => '',
			)
		);
        ///////////////////
		$this->add_control(
			'slider_heading',
			[
				'label' => esc_html__( 'Slider', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'slider',
			array(
				'label' => esc_html__( 'Enable Slider', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
				//'separator' => 'before',
                'default' => '',
			)
		);

        $this->add_control(
			'items',
			array(
				'label' => esc_html__( 'Items (Number only)', 'kalles' ),
                'description' => esc_html__( 'Set the maximum amount of items displayed at a time with the widest browser width', 'kalles' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 4,
			)
		);

        $this->add_control(
			'autoplay',
			array(
				'label' => esc_html__( 'Enable Auto play', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => '',
			)
		);

        $this->add_control(
			'arrows',
			array(
				'label' => esc_html__( 'Enable Navigation', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => '',
			)
		);

		$this->add_control(
			'dots',
			array(
				'label' => esc_html__( 'Enable Pagination', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
				'separator' => 'after',
                'default' => '',
			)
		);

        ///////////////////

        $this->add_control(
			'columns',
			array(
				'label' => esc_html__( 'Columns', 'kalles' ),
				'description' => esc_html__( 'This parameter will not working if slider has enabled', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'6' => esc_html__( '2 Columns', 'kalles' ),
					'4' => esc_html__( '3 Columns', 'kalles' ),
					'3' => esc_html__( '4 Columns', 'kalles' ),
					'15' => esc_html__( '5 Columns', 'kalles' ),
                    '2' => esc_html__( '6 Columns', 'kalles' ),
				),
				'default' => '3',
			)
		);

        $this->add_control(
			'filter',
			array(
				'label' => esc_html__( 'Enable Isotope Category Filter', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => '',
			)
		);

        $this->add_control(
			'flip',
			array(
				'label' => esc_html__( 'Enable Flip Product Thumbnail', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
				'separator' => 'after',
                'default' => '',
			)
		);

        ///////////////////

        $this->add_control(
			'css_animation',
			array(
				'label' => esc_html__( 'CSS Animation', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
                    'top-to-bottom' => esc_html__( 'Top to bottom', 'kalles' ),
					'bottom-to-top' => esc_html__( 'Bottom to top', 'kalles' ),
					'left-to-right' => esc_html__( 'Left to right', 'kalles' ),
					'right-to-left' => esc_html__( 'Right to left', 'kalles' ),
					'appear' => esc_html__( 'Appear from center', 'kalles' ),
				),
				'default' => 'top-to-bottom',
			)
		);

        $this->add_control(
			'class',
			array(
				'label' => esc_html__( 'Extra class name', 'kalles' ),
                'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
			)
		);


		$this->end_controls_section();


        /**
         * Products design settings.
         */
        $this->start_controls_section(
            'products_design_style_section',
            [
                'label' => esc_html__( 'Products design', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'hover_style',
            array(
                'label' => esc_html__( 'Hover product style', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'hover_style_1' => esc_html__( 'Hover Style 1', 'kalles' ),
                    'hover_style_2' => esc_html__( 'Hover Style 2', 'kalles' ),
                    'hover_style_3' => esc_html__( 'Hover Style 3', 'kalles' ),
                    'hover_style_4' => esc_html__( 'Hover Style 4', 'kalles' ),
                    'hover_style_5' => esc_html__( 'Hover Style 5', 'kalles' ),
                    'hover_style_6' => esc_html__( 'Hover Style 6', 'kalles' ),
                    'hover_style_7' => esc_html__( 'Hover Style 7', 'kalles' ),
                    'hover_style_8' => esc_html__( 'Hover Style 8', 'kalles' ),
                    'hover_style_9' => esc_html__( 'Hover Style 9', 'kalles' ),
                ),
                'default' => 'hover_style_1',
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label'   => esc_html__( 'Product Title Typography', 'kalles' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .product-title',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'product_title_color',
            [
                'label' => esc_html__( 'Product Title Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .product-title a' => 'color: {{VALUE}}',
                ],
                'default' => '#222222'
            ]
        );
        $this->add_control(
            'product_price_color',
            [
                'label' => esc_html__( 'Product Price Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .product .price' => 'color: {{VALUE}}',
                ],
                'default' => '#878787'
            ]
        );
        $this->add_control(
            'product_stock_color',
            [
                'label' => esc_html__( 'Product Stock Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} div.medizin_laypout .product-stock-status .available, div.medizin_laypout .product-stock-status .sold' => 'color: {{VALUE}}',
                ],
                'default' => '#696969'
            ]
        );
        $this->add_control(
            'border-color',
            [
                'label' => esc_html__( 'Border Wrap Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .medizin_laypout' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .the4-sc-products .medizin_laypout .slick-arrow' => 'border-color: {{VALUE}}; background-color: {{VALUE}}',

                ],
                'default' => '#FF7298'
            ]
        );
        $this->add_control(
            'img_size',
            [
                'label'   => esc_html__( 'Image size', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'large',
                'options' => kalles_get_all_image_sizes_names(),
            ]
        );

        $this->add_control(
            'img_size_custom',
            [
                'label'       => esc_html__( 'Image dimension', 'kalles' ),
                'type'        => Controls_Manager::IMAGE_DIMENSIONS,
                'description' => esc_html__( 'Enter custom size to crop Image.', 'kalles' ),
                'condition'   => [
                    'img_size' => 'custom',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'label'    => esc_html__( 'Stock bar background', 'kalles' ),
				'name'     => 'sold-bar-background',
				'types'    => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .loop-product-stock .sold-bar',

			]
		);

        $this->end_controls_section();
    }

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$default_setting = array(
			'type'					 => 'product-deal',
			'style'                  => 'grid',
			'hover_style'            => 'hover_style_1',
			'id'                     => '',
			'sku'                    => '',
			'display'                => 'all',
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'cat_id'                 => '',
			'limit'                  => 12,
			'slider'                 => '',
			'loadmore'               => '',
			'items'                  => 4,
			'autoplay'               => '',
			'arrows'                 => '',
			'dots'                   => '',
			'columns'                => 4,
			'filter'                 => false,
			'flip'                   => false,
			'css_animation'          => '',
			'class'                  => '',
			'issc'                   => true,
			'img_size'               => 'woocommerce_thumbnail',
			'cowntdown_text' 		 => translate( 'End in', 'kalles' ),


		);
		$settings = $this->get_settings_for_display();

		$settings = wp_parse_args( $settings, $default_setting );



		if ( '' !== $settings['css_animation'] ) {
			wp_enqueue_script( 'waypoints' );
			$classes[] = 'wpb_animate_when_almost_visible wpb_' . $settings['css_animation'];
		}


		$args = array(
			'post_type'              => 'product',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'cache_results'          => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => WC()->query->get_meta_query()
		);

		$products_id = $this->get_product_id( $settings['product_items'] );

		$product_sale = $this->get_product_stock( $settings['product_items'] );

		$GLOBALS['products_sale'] = $product_sale;

		if ( ! empty( $products_id ) ) {
			global $kalles_sc;
			$kalles_sc = $settings;

			$options = array();

			$classes = array( 'the4-sc-products ' . $settings['class'] . $settings['hover_style'] );

			$args['post__in'] = $products_id;
			$products = new WP_Query( $args );

			echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" >';

			if ( $products->have_posts() ) : ?>

				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

			<?php endif;

			echo '</div>';

			wp_reset_postdata();

			// Reset kalles_sc global variable to null for render shortcode after
			$kalles_sc = NULL;
		}

        if ( is_admin() ){
          echo "
         <script>

         The4Kalles.KallesCountdown();

          if ( jQuery( '.the4-carousel' ).length > 0 ){
            jQuery( '.the4-carousel' ).not('.slick-initialized').slick({focusOnSelect: true});
          }
         </script>";
        }

        return;

	}


	 public function get_product_id( $products )
	 {
	 	$products_id = array();
	 	if ( ! empty( $products ) ) {
	 		foreach ($products as $product ) {
	 			$products_id[] = $product['product_id'];
	 		}
	 	}

	 	return $products_id;
	 }

	 public function get_product_stock( $products )
	 {
	 	$products_stock = array();
	 	if ( ! empty( $products ) ) {
	 		foreach ($products as $product ) {
	 			$products_stock[ $product['product_id'] ]['product_sold'] = $product['product_stock']['size'] -  $product['available_stock']['size'] ;
	 			$products_stock[ $product['product_id'] ]['product_sold_pecent'] = ( ( $product['product_stock']['size'] - $product['available_stock']['size'] ) / $product['product_stock']['size']  ) * 100;
	 			$products_stock[ $product['product_id'] ]['available_stock'] = $product['available_stock']['size'];
	 		}
	 	}

	 	return $products_stock;
	 }
}
/////////////////////
