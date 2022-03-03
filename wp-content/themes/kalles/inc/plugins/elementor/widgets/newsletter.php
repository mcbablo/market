<?php
/**
 * Newsletter Widget Elementor
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Controls_Manager;

class Kalles_Elementor_Newsletter_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
       parent::__construct($data, $args);
    }

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-mailchimp';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Mailchimp', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-mailchimp';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'mail', 'newsletter', 'mailchimp', 'klaviyo' );
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
	 * Get MailChimp form
	 *
	 * @return array
	 */
	public function get_mailchimp_form_list()
	{
		$list_forms = get_posts(
			array(
				'post_type'   => 'mc4wp-form',
				'numberposts' => -1
			)
		);

		$lists = array();

		if ( !empty( $list_forms ) ) {
			foreach( $list_forms as $form ) {
				$lists[ $form->ID ] = $form->post_title;
			}
		}

		return $lists;
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 */
	protected function _register_controls() {


       $pages = get_posts( array(
            'post_type'              => 'page',
			'posts_per_page'         => -1,
			'post_status'            => 'publish',
			'cache_results'          => false,
			'orderby'                => 'title',
			'order'                  => 'ASC',
       ) );
       if ( !empty($pages) ){
        foreach($pages as $page){
            $pages_titles[$page->ID] = get_the_title($page->ID);
        }
       }

       $this->start_controls_section(
			'kalles_el_newsletter',
			array(
				'label' => esc_html__( 'Setting', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'form_id',
			[
				'label'       => esc_html__( 'Select MailChimp form', 'kalles' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => $this->get_mailchimp_form_list(),
			]
		);

		$this->add_control(
            'use_ajax',
            array(
                'label' => esc_html__( 'Use Ajax', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'yes',
                'separator' => 'before',
            )
        );

         $this->end_controls_section();

         $this->start_controls_section(
			'kalles_el_newsletter_style',
			array(
				'label' => esc_html__( 'Style', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_control(
			'style',
			[
				'label'       => esc_html__( 'Newsletter Design', 'kalles' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => [
					'1' => 'Design 1',
					'2' => 'Design 2',
					'3' => 'Design 3',
					'4' => 'Design 4',
					'5' => 'Design 5',
					'6' => 'Design 6'
				],
				'default'     => '1'
			]
		);

        $this->add_control(
			'form-align',
			[
				'label' => esc_html__( 'Content Alignment', 'kalles' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'kalles' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'kalles' ),
						'icon' => 'eicon-h-align-cener',
					],
					'right' => [
						'title' => esc_html__( 'End', 'kalles' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
			]
		);

		$this->add_responsive_control(
			'form-width',
			[
				'label'          => esc_html__( 'Content width', 'kalles' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
					'px' => [
						'min' => 550,
						'max' => 1000,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .mc4wp-form-fields' => 'width: {{SIZE}}{{UNIT}}; max-width: 90%;',
				],
			]
		);
        $this->add_responsive_control(
            'button-width',
            [
                'label'          => esc_html__( 'Button width', 'kalles' ),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => [ 'px', '%' ],
                'range'          => [
                    '%'  => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .newsletter_se .signup-newsletter-form .submit-btn' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%;',
                ],
            ]
        );
        $this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border color', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .signup-newsletter-form input.input-text' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .signup-newsletter-form' => 'border-color: {{VALUE}}',
				],
				'default'	=> '#222222'
			]
		);

        $this->add_control(
			'input_color',
			[
				'label'     => esc_html__( 'Input color', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .signup-newsletter-form input.input-text' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .signup-newsletter-form input.input-text::-webkit-input-placeholder' => 'color: {{VALUE}}',
				],
				'default'	=> '#222222'
			]
		);
        $this->add_control(
            'input_bg_color',
            [
                'label'     => esc_html__( 'Input Background color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .signup-newsletter-form input.input-text' => 'background: {{VALUE}}',
                ],
                'default'	=> 'rgba(255,255,255,0)'
            ]
        );

		$this->add_control(
			'btn_color',
			[
				'label'     => esc_html__( 'Button color', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .signup-newsletter-form .submit-btn' => 'color: {{VALUE}}',
				],
				'default'	=> '#FFFFFF'
			]
		);

		$this->add_control(
			'btn_background_color',
			[
				'label'     => esc_html__( 'Button background', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .signup-newsletter-form .submit-btn' => 'background-color: {{VALUE}}',
				],
				'default'	=> '#222222'
			]
		);
    }

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {


		$settings = $this->get_settings_for_display();

		if ( ! $settings['form_id'] || ! defined( 'MC4WP_VERSION' ) ) {
			return;
		}

		$class = 'flex t4-mailchimp-form fl_' . $settings[ 'form-align' ];

		?>
		<div class="newsletter_se newl_des_<?php echo esc_attr( $settings[ 'style' ] ); ?> <?php echo esc_attr( $settings[ 'form-align' ] ); ?>">
			<?php echo do_shortcode( '[mc4wp_form id="' . esc_attr( $settings['form_id'] ) . '" element_class="' . esc_attr( $class ) . '"]' ); ?>
		</div>
        <?php
        return;

	}
}
/////////////////////
