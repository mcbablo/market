<?php
/**
 * Add widget product to elementor
 *
 * @since   1.6.2
 * @package Kalles
 */

class Kalles_Elementor_Product_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-product';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product', 'kalles' );
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
		return array( 'products', 'product', 'woocommerce' );
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

       $product_titles = array();

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

        $this->add_control(
			'countdown',
			array(
				'label' => esc_html__( 'Enable countdown for sale product', 'kalles' ),
                'description' => esc_html__( 'Setup sale schedule in product page first. Only work with product type simple', 'kalles' ),
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
                'default' => '',
            )
        );

        $this->add_control(
            'img_size',
            [
                'label'   => esc_html__( 'Image size', 'kalles' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'large',
                'options' => kalles_get_all_image_sizes_names(),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'img_size_custom',
            [
                'label'       => esc_html__( 'Image dimension', 'kalles' ),
                'type'        => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                'description' => esc_html__( 'Enter custom size to crop Image.', 'kalles' ),
                'condition'   => [
                    'img_size' => 'custom',
                ],
            ]
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

	}

    /**
     * Create shortcode row
	 *
	 * @return string
	 */
	public function create_shortcode() {

		$settings = $this->get_settings_for_display();

        $args_row = '';

        $args_row .= $settings['countdown'] == 'yes' ? ' countdown="true"' : '';
        $args_row .= $settings['flip'] == 'yes' ? ' flip="true"' : '';

        $args_row .= !empty($settings['post_id']) ? ' id="'.esc_attr( $settings['post_id'] ).'"' : '';

        $args_row .= $settings['img_size']  ? ' img_size="' . $settings['img_size'] . '"' : '';
        $args_row .= isset( $settings['img_size_custom']['width'] ) ? ' img_size_custom_width="' . $settings['img_size_custom']['width'] . '"' : '';
        $args_row .= isset( $settings['img_size_custom']['height'] ) ? ' img_size_custom_height="' . $settings['img_size_custom']['height'] . '"' : '';

        ///////////////////////

        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

       // error_log('$settings: '.print_r($settings, 1));

        return '[kalles_addons_product'.$args_row.']';

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		echo do_shortcode( $this->create_shortcode() );

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

		// In plain mode, render without shortcode
		echo wp_kses_post( $this->create_shortcode() );

	 }

}
/////////////////////
