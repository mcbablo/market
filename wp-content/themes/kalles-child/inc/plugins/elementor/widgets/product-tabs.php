<?php
/**
 * Product tab widget for Elementor
 *
 * @since   1.0.0
 * @package Kalles
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;


class Kalles_Elementor_Product_Tabs_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve tabs widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'the4_product_tabs';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve tabs widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product Tabs', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve tabs widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'tabs', 'accordion', 'toggle', 'product' ];
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
	 * Register tabs widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {

		// Get all terms of woocommerce
       $product_cat = array();
       $terms = get_terms( 'product_cat' );
       if ( $terms && ! isset( $terms->errors ) ) {
		foreach ( $terms as $key => $value ) {
			$product_cat[$value->term_id] = $value->name;
		}
       }
       $product_cat = [ 0 => 'All' ] + $product_cat;


		$this->start_controls_section(
			'kalles_product_tabs_content',
			[
				'label' => esc_html__( 'Tabs', 'kalles' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Title', 'kalles' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tab Title', 'kalles' ),
				'placeholder' => esc_html__( 'Tab Title', 'kalles' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'tabs_content',
			[
				'label' => esc_html__( 'Content', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$repeater->add_control(
			'display',
			array(
				'label' => esc_html__( 'Display', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'all' => esc_html__( 'All products', 'kalles' ),
					'recent' => esc_html__( 'Recent products', 'kalles' ),
                    'featured' => esc_html__( 'Featured products', 'kalles' ),
                    'sale' => esc_html__( 'Sale products', 'kalles' ),
                    'best_selling_products' => esc_html__( 'Best selling products', 'kalles' ),
                    'rated' => esc_html__( 'Top Rated Products', 'kalles' ),
				),
				'default' => 'all',
			)
		);

		$repeater->add_control(
			'cat_id',
			array(
				'label' => esc_html__( 'Category', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $product_cat,
                'default' => 'all',
			)
		);

		$repeater->add_control(
			'orderby',
			array(
				'label' => esc_html__( 'Order By', 'kalles' ),
                'description' => sprintf( wp_kses_post( 'Select how to sort retrieved products. More at %s. Default by Title', 'kalles' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'title' => esc_html__( 'Title', 'kalles' ),
					'date' => esc_html__( 'Date', 'kalles' ),
                    'ID' => esc_html__( 'ID', 'kalles' ),
                    'author' => esc_html__( 'Author', 'kalles' ),
                    'modified' => esc_html__( 'Modified', 'kalles' ),
                    'rand' => esc_html__( 'Random', 'kalles' ),
                    'comment_count' => esc_html__( 'Comment count', 'kalles' ),
                    'menu_order' => esc_html__( 'Menu order', 'kalles' ),
				),
				'default' => 'title',
			)
		);

        $repeater->add_control(
			'order',
			array(
				'label' => esc_html__( 'Order', 'kalles' ),
                'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s. Default by ASC', 'kalles' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'ASC' => esc_html__( 'Ascending', 'kalles' ),
					'DESC' => esc_html__( 'Descending', 'kalles' ),
				),
				'default' => 'ASC',
			)
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Tabs Items', 'kalles' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
					'tab_title' => 'Tab #1',
					],
					[
					'tab_title' => 'Tab #2',
					],
					[
					'tab_title' => 'Tab #3',
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'kalles_product_tabs_settings',
			array(
				'label' => esc_html__( 'Setting', 'kalles' ),
			)
		);
        $this->add_control(
            'tab_style',
            array(
                'label' => esc_html__( 'Tabs style', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'tab_style1' => esc_html__( 'Style 1', 'kalles' ),
                    'tab_style2' => esc_html__( 'Style 2', 'kalles' ),
                    'tab_style3' => esc_html__( 'Style 3', 'kalles' ),
                ),
                'default' => 'tab_style1',
            )
        );
        $this->add_control(
            'tabs_color',
            [
                'label' => esc_html__( 'Tabs Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'color: {{VALUE}}; border-color: {{VALUE}} !important',
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'color: {{VALUE}}; border-color: {{VALUE}} !important',
                ],
                'default' => '#222222'
            ]
        );
		 $this->add_control(
			'style',
			array(
				'label' => esc_html__( 'Product style', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'grid' => esc_html__( 'Grid', 'kalles' ),
					'masonry' => esc_html__( 'Masonry', 'kalles' ),
					'carousel' => esc_html__( 'Carousel', 'kalles' ),
				),
				'default' => 'grid',
			)
		);

		$this->add_control(
			'columns',
			array(
				'label' => esc_html__( 'Columns', 'kalles' ),
				'description' => esc_html__( 'Columns per row', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'6' => esc_html__( '2 Columns', 'kalles' ),
					'4' => esc_html__( '3 Columns', 'kalles' ),
					'3' => esc_html__( '4 Columns', 'kalles' ),
					'15' => esc_html__( '5 Columns', 'kalles' ),
                    '2' => esc_html__( '6 Columns', 'kalles' ),
				),
				'default' => '3',
				'condition'   => [
                    'style' => ['grid', 'masonry', 'metro'],
                ],
			)
		);

		$this->add_control(
			'limit',
			array(
				'label' => esc_html__( 'Items per page', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => '12',
			)
		);

        ///////////////////

        $this->add_control(
			'flip',
			array(
				'label' => esc_html__( 'Enable Flip Product Thumbnail', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
				//'separator' => 'after',
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
                'default' => '',
                'condition'   => [
                    'style' => ['grid', 'masonry', 'metro'],
                ],
			)
		);
        $this->add_control(
            'button_type',
            array(
                'label'   => esc_html__( 'Load more Type', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'style_1' => esc_html__( 'Style 1', 'kalles' ),
                    'style_2' => esc_html__( 'Style 2', 'kalles' ),
                    'style_3' => esc_html__( 'Style 3', 'kalles' ),
                    'style_4' => esc_html__( 'Style 4', 'kalles' ),
                ),
                'default' => 'style_1',
                'condition' => [
                    'loadmore' => 'yes',
                ],
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
                'condition'   => [
                    'style' => ['grid', 'masonry', 'metro'],
                ],
			)
		);

		$this->add_control(
			'slider_heading',
			[
				'label' => esc_html__( 'Carousel', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'   => [
                    'style' => 'carousel',
                ],
			]
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
				'condition'   => [
                    'style' => 'carousel',
                ],
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
                'condition'   => [
                    'style' => 'carousel',
                ],
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
                'condition'   => [
                    'style' => 'carousel',
                ],
			)
		);

		$this->add_control(
			'dots',
			array(
				'label' => esc_html__( 'Enable Pagination', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => '',
                'condition'   => [
                    'style' => ['carousel'],
                ],
			)
		);

        ///////////////////

        $this->add_control(
			'css_animation',
			array(
				'label' => esc_html__( 'CSS Animation', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'separator' => 'before',
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
                    'hover_style_10' => esc_html__( 'Hover Style 10', 'kalles' ),
                ),
                'default' => 'hover_style_1',
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
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => esc_html__( 'Product Price', 'kalles' ),
                'separator' => 'before',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .the4-sc-products .product .price',
            ]
        );
        $this->add_control(
            'product_price_color',
            [
                'label' => esc_html__( 'Product Price Color', 'kalles' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .the4-sc-products .product .price ins' => 'color: {{VALUE}}',
                ],
                'default' => ''
            ]
        );
        $this->add_control(
            'img_size',
            [
                'label'   => esc_html__( 'Image size', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'large',
                'options' => kalles_get_all_image_sizes_names(),
                'separator' => 'before',
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

        $this->end_controls_section();
	}

	/**
	 * Render tabs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$default_setting = $this->get_default_setting();

		$tabs = $this->get_settings_for_display( 'tabs' );

		$settings = $this->get_settings_for_display();

		$global_setting = $this->get_global_setting( $settings );

		$settings = wp_parse_args( $settings, $default_setting );

		$product_shortcode = array();

		foreach ($tabs as $tab_index => $tab) {
			$tab_setting = $this->get_tabs_setting( $tab );
			$product_shortcode[] = $this->create_shortcode_products( $global_setting, $tab_setting);

		}
		?>

		<div class="the4-el-product-tabs elementor-widget-tabs pr <?php echo esc_attr($settings['tab_style']); ?>">
			<div class="the4-tab-header flex fl_center mb__30">
					<?php foreach ( $tabs as $index => $tab ) : ?>
						<?php $tab_attr = array_intersect_key( array_merge( $settings, $tab ), $this->get_default_setting() ); ?>
						<?php $item_class = $index == 0 ? 'elementor-active' : ''; ?>
						<div class="the4-tab-header__item elementor-tab-title <?php echo esc_attr( $item_class ); ?>"
							data-shortcode='<?php echo wp_json_encode( $tab_attr ); ?>'
							data-skey="<?php echo wp_create_nonce( 'the4_woo_change_tabs_el_datta' ); ?>">
							<a href="#"><?php echo esc_html( $tab['tab_title'] ); ?></a>
						</div>
					<?php endforeach; ?>
			</div>
			<div class="the4-tab-loading"></div>
			<div class="the4-tab-content <?php echo esc_attr($settings['hover_style']); ?>">
				<?php if ( !empty( $product_shortcode ) ) : ?>
					<?php echo do_shortcode( '[kalles_addons_products'. $product_shortcode[0] .']' ) ?>
				<?php endif; ?>
			</div>
		</div>


		<?php

		if ( is_admin() ){
         	echo "<script>
	          if ( jQuery( '.the4-carousel' ).length > 0 ){
	            jQuery( '.the4-carousel' ).not('.slick-initialized').slick({focusOnSelect: true});
	          }
	          The4Kalles.KallesElProductTabs();
	         </script>";
	        }

	}

	protected function get_global_setting( $settings, $type = 'string' )
	{
		$args_row = '';

        $args_row .= $settings['autoplay'] == 'yes' ? ' autoplay="true"' : '';
        $args_row .= $settings['arrows'] == 'yes' ? ' arrows="true"' : '';
        $args_row .= $settings['dots'] == 'yes' ? ' dots="true"' : '';
        $args_row .= $settings['flip'] == 'yes' ? ' flip="true"' : '';

        $args_row .= $settings['style'] ? ' style="'.esc_attr($settings['style']).'"' : '';

        $args_row .= $settings['hover_style'] ? ' hover_style="'.esc_attr($settings['hover_style']).'"' : '';

        $args_row .= $settings['tab_style'] ? ' tab_style="'.esc_attr($settings['tab_style']).'"' : '';

        $args_row .= $settings['button_type'] ? ' button_type="'.esc_attr($settings['button_type']).'"' : '';

        ///////////////////////

        $args_row .= $settings['columns'] ? ' columns="'.esc_attr($settings['columns']).'"' : '';


        $args_row .= absint($settings['limit']) ? ' limit="'.intval($settings['limit']).'"' : '';

        $args_row .= $settings['filter'] == 'yes' ? ' filter="true"' : ' filter="false"';

        $args_row .= $settings['img_size']  ? ' img_size="' . $settings['img_size'] . '"' : '';

        $args_row .= isset( $settings['img_size_custom']['width'] ) ? ' img_size_custom_width="' . $settings['img_size_custom']['width'] . '"' : '';
        $args_row .= isset( $settings['img_size_custom']['height'] ) ? ' img_size_custom_height="' . $settings['img_size_custom']['height'] . '"' : '';

        $args_row .= $settings['loadmore'] == 'yes' ? ' loadmore="true"' : '';

       	return $args_row;
	}

	protected function get_tabs_setting( $settings )
	{
		$args_row = '';

        $args_row .=  isset ( $settings['display']  ) ? ' display="'.esc_attr($settings['display']).'"' : '';
        $args_row .=  isset ( $settings['orderby'] ) ? ' orderby="'.esc_attr($settings['orderby']).'"' : '';
        $args_row .=  isset ( $settings['order'] ) ? ' order="'.esc_attr($settings['order']).'"' : '';
        $args_row .= isset ( $settings['items'] ) ? ' items="'.absint($settings['items']).'"' : '';

        $args_row .=  isset ( $settings['cat_id'] ) ? ' cat_id="'.esc_attr($settings['cat_id']).'"' : '';

        $args_row .=  isset ( $settings['filter'] ) && $settings['filter'] == 'yes' ? ' filter="true"' : ' filter="false"';

        return $args_row;
	}

	protected function create_shortcode_products( $global_setting, $tab_setting ) {
		$args_row = '';
		$args_row = $global_setting . ' ' . $tab_setting;
		return $args_row;
	}

	protected function get_default_setting()
	{

		return array(
			'style'                  => 'grid',
			'id'                     => '',
			'sku'                    => '',
			'display'                => 'all',
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'cat_id'                 => '',
			'limit'                  => 12,
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
			'hover_style'            => '',
			'issc'                   => true,
			'img_size'               => 'woocommerce_thumbnail',
			'img_size_custom_width'  => '',
			'img_size_custom_height' => '',
		);
	}
}
