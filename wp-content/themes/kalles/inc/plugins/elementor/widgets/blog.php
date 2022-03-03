<?php
/**
 * Add widget blog to elementor
 *
 * @since   1.6.2
 * @package Kalles
 */
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class Kalles_Elementor_Blog_Widget extends \Elementor\Widget_Base {

    /**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-blog';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Blog', 'kalles' );
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
		return array( 'blog', 'post' );
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

       $categories = array();
       $terms = get_terms( 'category' );
       if ( $terms && ! isset( $terms->errors ) ) {
        foreach ( $terms as $key => $value ) {
            $categories[$value->term_id] = $value->name;
        }
       }

       /////////////////////

	    $this->start_controls_section(
			'kalles_addons_blog',
			array(
				'label' => esc_html__( 'Content', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
            'post_id',
            array(
                'label' => esc_html__( 'Include special posts', 'kalles' ),
                'type'  => 'kalles_post_select',
                'post_type'  => 'post',
                'get_data'  => 'the4_kalles_get_data_post_by_id',
                'search'  => 'the4_kalles_search_post_by_query',
                'description' => esc_html__( 'Enter posts title to display only those records', 'kalles' ),
                'multiple' => true,
            )
        );

        $this->add_control(
            'cat_id',
            array(
                'label' => esc_html__( 'Select category', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $categories,
            )
        );

		$this->add_control(
			'thumb_size',
			array(
				'label' => esc_html__( 'Thumbnail size', 'kalles' ),
                'description' => esc_html__( 'width x height, example: 570x320', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
			)
		);

        $this->add_control(
            'columns',
            array(
                'label' => esc_html__( 'Columns', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '6' => esc_html__( '2 Columns', 'kalles' ),
                    '4' => esc_html__( '3 Columns', 'kalles' ),
                    '3' => esc_html__( '4 Columns', 'kalles' ),
                ),
                'default' => '4',
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
                'default' => '3',
            )
        );

        ///////////////////

        $this->add_control(
            'slider',
            array(
                'label' => esc_html__( 'Enable Slider', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'No', 'kalles' ),
                'label_on' => esc_html__( 'Yes', 'kalles' ),
                'separator' => 'before',
                'default' => '',
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
        $this->start_controls_section(
            'section_style_Content',
            array(
                'label' => esc_html__( 'Style', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'style',
            array(
                'label' => esc_html__( 'Style', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'outside' => esc_html__( 'Content Outside Thumbnail', 'kalles' ),
                    'inside' => esc_html__( 'Content Inside Thumbnail', 'kalles' ),
                    'outside_2' => esc_html__( 'Content Outside Thumbnail 2', 'kalles' ),
                    'outside_3' => esc_html__( 'Content Outside Thumbnail 3', 'kalles' ),
                    'outside_4' => esc_html__( 'Content Outside Thumbnail 4', 'kalles' ),
                ),
                'default' => 'outside',
            )
        );

        $this->add_control(
            'layout_content',
            array(
                'label' => esc_html__( 'Layout Content', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'layout_dark' => esc_html__( 'Layout Content Dark', 'kalles' ),
                    'layout_light' => esc_html__( 'Layout Content Light', 'kalles' ),
                ),
                'default' => 'outside',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'label' => esc_html__( 'Title Style', 'kalles' ),
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .post-info h4',
            )
        );
        $this->add_control(
            'title_color', [
            'label'     => esc_html__( 'Title Color', 'kalles' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} article.post a:not(:hover)' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_control(
            'meta_color', [
            'label'     => esc_html__( 'Meta Color', 'kalles' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} span.cd' => 'color: {{VALUE}};',
            ],
        ] );
        $this->add_control(
            'content_color', [
            'label'     => esc_html__( 'Content Color', 'kalles' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .post-info' => 'color: {{VALUE}};',
                '{{WRAPPER}} .post-content' => 'color: {{VALUE}};',
            ],
        ] );
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

        $args_row .= $settings['slider'] == 'yes' ? ' slider="true"' : '';
        $args_row .= $settings['autoplay'] == 'yes' ? ' autoplay="true"' : '';
        $args_row .= $settings['arrows'] == 'yes' ? ' arrows="true"' : '';
        $args_row .= $settings['dots'] == 'yes' ? ' dots="true"' : '';

        $args_row .= $settings['style'] ? ' style="'.esc_attr($settings['style']).'"' : '';

        $args_row .= $settings['layout_content'] ? ' layout_content="'.esc_attr($settings['layout_content']).'"' : '';

        $args_row .= !empty($settings['post_id']) ? ' id="'.esc_attr( implode(',', $settings['post_id']) ).'"' : '';

        ///////////////////////

        $args_row .= $settings['cat_id'] ? ' cat="'.esc_attr($settings['cat_id']).'"' : '';

        $args_row .= $settings['columns'] ? ' columns="'.esc_attr($settings['columns']).'"' : '';

        $args_row .= $settings['thumb_size'] ? ' thumb_size="'.esc_attr($settings['thumb_size']).'"' : '';

        $args_row .= absint($settings['limit']) ? ' limit="'.intval($settings['limit']).'"' : '';

        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

        return '[kalles_addons_blog'.$args_row.']';

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		echo do_shortcode( $this->create_shortcode() );

        if ( is_admin() ){
            echo "
         <script>
          if ( jQuery( '.the4-carousel' ).length > 0 ){
            jQuery( '.the4-carousel' ).not('.slick-initialized').slick({focusOnSelect: true});
          }
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

		// In plain mode, render without shortcode
		echo wp_kses_post( $this->create_shortcode() );

	 }

}
/////////////////////
