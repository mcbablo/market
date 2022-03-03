<?php
/**
 * MAP ELEMENTOR WIDGET
 *
 * @since   1.1.2
 * @package Kalles
 */

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class Kalles_Elementor_Map_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
       parent::__construct($data, $args);
    }

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-map';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Kalles Map', 'kalles' );
	}

	public function get_script_depends() {
		return [
			'kalles-elementor',
			'mapbox',
			'mapbox-gl'
		];
	}

	public function get_style_depends() {
		return [
			'mapbox'
		];
	}
	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'map', 'location' );
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

       $this->start_controls_section(
			'map-content',
			array(
				'label' => esc_html__( 'Content', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'location_name',
			array(
				'label' => esc_html__( 'Name', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
                'default' => '',
			)
		);

		$repeater->add_control(
			'location_local',
			array(
				'label' => esc_html__( 'Localtion', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => '',
                'default' => '',
			)
		);

       	$repeater -> add_control(
			'location_details',
			[
				'label'       => esc_html__( 'Details', 'kalles' ),
				'type'        => Controls_Manager::WYSIWYG ,
				'label_block' => true,
			]
		);



		$this->add_control(
			'location_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ location_name }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'location_name'     => 'Sydney',
						'location_local'    => 'Sydney',
						'location_details'  => 'Beautiful city',
					],
					[
						'location_name'     => 'Philadelphia',
						'location_local'    => 'Pennsylvania',
						'location_details'  => 'Beautiful city',
					],
					[
						'location_name'     => 'Castle Hill',
						'location_local'    => 'New South Wales 2154',
						'location_details'  => 'Beautiful city',
					],

				],
			]
		);

		$this->add_control(
		'map_token',
			array(
				'label' => esc_html__( 'Mapbox access token', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => 'Access token',
                'description' => sprintf(__('Go to <a href="%s" target="_blank">Maps Box</a> to get a key', 'kalles'), esc_url('https://www.mapbox.com')),
			)
		);

		$this->add_control(
		'map_style',
			[
				'label'       => esc_html__( 'Style', 'kalles' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'streets-v11' 	=> esc_html__( 'Streets', 'kalles' ),
					'satellite-streets-v11' 	=> esc_html__( 'Satellite Streets', 'kalles' ),
					'light-v10' 	=> esc_html__( 'Light', 'kalles' ),
					'dark-v10'  	=> esc_html__( 'Dark', 'kalles' ),
					'outdoors-v11'  => esc_html__( 'Outdoors', 'kalles' ),
					'navigation-day-v1'  => esc_html__( 'Navigation Day', 'kalles' ),
					'navigation-night-v1'  => esc_html__( 'Navigation Night', 'kalles' ),
				],
				'default'     => 'light-v10',
			]
		);

		$this->add_control(
			'map_zoom',
			[
				'label'       => esc_html__( 'Zoom', 'kalles' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '13',
			]
		);

		$this->add_control(
			'map_show_search',
			[
				'label'        => esc_html__( 'Show Search', 'kalles' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'map-setting',
			array(
				'label' => esc_html__( 'General style', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'map-bg-color',
			[
				'label'        => esc_html__( 'Background Color', 'kalles' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'map-content-padding',
			[
				'label'      => __( 'Padding', 'kalles' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .kalles-map' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'localtion-style',
			[
				'label' => __( 'Location style', 'kalles' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'localtion-bg',
			[
				'label'        => esc_html__( 'Background Color', 'kalles' ),
				'type'         => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .kalles-map .kalles-map__list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs(
			'localtion-item-style'
		);

		$this->start_controls_tab(
			'item-name',
			[
				'label' => __( 'Name', 'kalles' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .kalles-map__list .kalles-map__name',
			]
		);

		$this->add_control(
			'item-name-color',
			[
				'label'     => __( 'Color', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .kalles-map__list .kalles-map__name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'item-location',
			[
				'label' => __( 'Location', 'kalles' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'map__local_typography',
				'selector' => '{{WRAPPER}} .kalles-map__list .kalles-map__local',
			]
		);

		$this->add_control(
			'item-location-color',
			[
				'label'     => __( 'Color', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .kalles-map__list .kalles-map__local' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'item-details',
			[
				'label' => __( 'Details', 'kalles' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'map__details_typography',
				'selector' => '{{WRAPPER}} .kalles-map__list .kalles-map__details',
			]
		);

		$this->add_control(
			'item-details-color',
			[
				'label'     => __( 'Color', 'kalles' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .kalles-map__list .kalles-map__details' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();



		$this->end_controls_section();

    }

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$location_html = $locations = array();

		if ( $settings['location_list'] ) {
			$location_html = '<div class="kalles-map__list css_ntbar">';

			foreach ($settings['location_list'] as $key => $location) {
				$name = isset( $location['location_name'] ) ? '<h3 class="kalles-map__name">' . $location['location_name'] . '</h3>' : '';
				$local = isset( $location['location_local'] ) ? '<div class="kalles-map__local">' . $location['location_local'] . '</div>' : '';
				$details = isset( $location['location_details'] ) ? '<div class="kalles-map__details">' . $location['location_details'] . '</div>' : '';
				$locations[] = isset( $location['location_local'] ) ? $location['location_local'] : '';

				if ( $name && $details ) {
					$location_html .= sprintf( '<div class="kalles-map__list--item" data-latitude data-longitude> %s %s %s </div>', $name, $local, $details );
				} else {
					$location_html .= '';
				}
			}

			$location_html .= '</div>';
		}

		$map_config = array(
			'token'      => $settings['map_token'],
			'localtions' => $locations,
			'zom'        => $settings['map_zoom'],
			'style'      => $settings['map_style'],

		);

		$this->add_render_attribute('locations', 'data-locations', wp_json_encode( $map_config ) );

		$this->add_render_attribute(
			'wrapper', 'class', [
				'kalles-map',
				'flex',
				'kalles-map__location',
				$settings['map_show_search']   ? 'kalles-map__search' : ''
			]
		);
		?>
			<div <?php echo $this->get_render_attribute_string('wrapper') . ' ' . $this->get_render_attribute_string('locations'); ?>>
				<div class="kalles-map-body w__100 row no-gutters">
					<div class="col-12 col-lg-4 col-md-6">
						<?php echo $location_html; ?>
					</div>
					<div class="col-12 col-lg-8 col-md-6">
						<div class="kalles-map__content" id="<?php echo esc_attr( uniqid( 'kalles-map-' ) );  ?>"></div>
					</div>
				</div>
			</div>
		<?php

	}
}
