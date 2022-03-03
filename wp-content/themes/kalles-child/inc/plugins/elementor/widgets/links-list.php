<?php
/**
 * LINK LIST ELEMENTOR WIDGET
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class Kalles_Elementor_Links_List_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
       parent::__construct($data, $args);
    }

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-links-list';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Links list', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-nav-menu';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'menu', 'link', 'list' );
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
			'links-list-content',
			array(
				'label' => esc_html__( 'Content', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

       	$this->add_control(
			'heading_heading',
			[
				'label' => esc_html__( '== Heading', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				//'separator' => 'after',
			]
		);

       	$this->add_control(
			'heading_text',
			array(
				'label' => esc_html__( 'Text', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => 'Menu Heading',
			)
		);

       	$this->add_control(
			'heading_url',
			[
				'label'   => esc_html__( 'Link', 'kalles' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

       	$this->add_control(
			'heading_label_text',
			array(
				'label' => esc_html__( 'Label text', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => 'Hot',
			)
		);

       	$this->add_control(
			'heading_label_color',
			[
				'label'   => esc_html__( 'Label color', 'kalles' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'primary'   => esc_html__( 'Primary Color', 'kalles' ),
					'secondary' => esc_html__( 'Secondary', 'kalles' ),
					'white'     => esc_html__( 'White', 'kalles' ),
					'black'     => esc_html__( 'Black', 'kalles' ),
					'blue'      => esc_html__( 'Blue', 'kalles' ),
					'green'     => esc_html__( 'Green', 'kalles' ),
					'red'       => esc_html__( 'Red', 'kalles' ),
					'orange'    => esc_html__( 'Orange', 'kalles' ),
					'grey'      => esc_html__( 'Grey', 'kalles' ),
				],
				'default' => 'primary',
			]
		);

       	$this->add_control(
			'list_heading',
			[
				'label' => esc_html__( '== Links list', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'link_text',
			array(
				'label' => esc_html__( 'Text', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => 'Menu Heading',
			)
		);

       	$repeater->add_control(
			'link_url',
			[
				'label'   => esc_html__( 'Link', 'kalles' ),
				'type'    => Controls_Manager::URL,
				'default' => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

       	$repeater->add_control(
			'label_text',
			array(
				'label' => esc_html__( 'Label text', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => '',
                'default' => 'Hot',
			)
		);

       	$repeater->add_control(
			'label_color',
			[
				'label'   => esc_html__( 'Label color', 'kalles' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'primary'   => esc_html__( 'Primary Color', 'kalles' ),
					'secondary' => esc_html__( 'Secondary', 'kalles' ),
					'white'     => esc_html__( 'White', 'kalles' ),
					'black'     => esc_html__( 'Black', 'kalles' ),
					'blue'      => esc_html__( 'Blue', 'kalles' ),
					'green'     => esc_html__( 'Green', 'kalles' ),
					'red'       => esc_html__( 'Red', 'kalles' ),
					'orange'    => esc_html__( 'Orange', 'kalles' ),
					'grey'      => esc_html__( 'Grey', 'kalles' ),
				],
				'default' => 'primary',
			]
		);

       	$repeater->add_control(
            'heading_style',
            array(
                'label' => esc_html__( 'Heading style', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Disable', 'kalles' ),
				'label_on' => esc_html__( 'Enable', 'kalles' ),
                'default' => 'no',
            )
        );

		$this->add_control(
			'links_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ link_text }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'link_text'     => 'Link list 1',
						'label'         => 'Sale',
						'label_color'   => 'red',
						'heading_style' => 'no',
						'link_url' => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
					[
						'link_text'     => 'Link list 2',
						'label'         => '',
						'label_color'   => 'primary',
						'heading_style' => 'no',
						'link_url' => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
					[
						'link_text'     => 'Link list 3',
						'label'         => 'Fetured',
						'label_color'   => 'primary',
						'heading_style' => 'no',
						'link_url' => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
					[
						'link_text'     => 'Link list 4',
						'label'         => '',
						'label_color'   => 'primary',
						'heading_style' => 'no',
						'link_url' => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
					[
						'link_text'     => 'Link list 5',
						'label'         => '',
						'label_color'   => 'primary',
						'heading_style' => 'no',
						'link_url' => [
							'url'         => '#',
							'is_external' => false,
							'nofollow'    => false,
						],
					],
				],
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

		$settings = $this->get_settings_for_display();

		$default_list = [
			'heading_text'        => '',
			'heading_url'         => '#',
			'heading_label_color' => 'primary',
			'heading_label_text'  => '',
			'links_list'          => []
		];

		$settings = wp_parse_args( $settings, $default_list );

		$heading_link = kalles_get_link_el( $settings['heading_url'] , 'kalles-nav-link megamenu_heading');

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						't4-links-list',
						'sub-menu',
						'menu-default-dropdown',
					]
				],
				'heading_label' => [
					'class' => [
						'label-' . $settings[ 'heading_label_color' ],
						'menu-item-label'
					]
				]
			]
		);

		$this->add_inline_editing_attributes( 'heading_text' );
		$this->add_inline_editing_attributes( 'heading_label' );

		?>
		<div <?php The4Helper::ksesHTML( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
			<?php if ( $settings[ 'heading_text' ] ) : ?>
				<div class="heading_text_wrapper">
					<a <?php The4Helper::ksesHTML( $heading_link ); ?>>
						<?php echo esc_html( $settings[ 'heading_text' ] ); ?>

						<?php if ( $settings[ 'heading_label_text' ] ) : ?>
							<span <?php The4Helper::ksesHTML( $this->get_render_attribute_string( 'heading_label' ) ); ?>>
								<?php echo esc_html( $settings[ 'heading_label_text' ] ); ?>
							</span>
						<?php endif; ?>
					</a>
				</div>
			<?php endif; ?>
			<ul class="sub-column">
				<?php foreach( $settings[ 'links_list' ] as $index => $link ) : ?>
					<?php
					$li_key = $this->get_repeater_setting_key( 'li', 'links_list', $index );
					$title_key = $this->get_repeater_setting_key( 'link_text', 'links_list', $index );
					$label_key = $this->get_repeater_setting_key( 'label_text', 'links_list', $index );

					$link_attrs = $link[ 'heading_style' ] == 'no' ? kalles_get_link_el( $link['link_url'], 'kalles-nav-link' ) : kalles_get_link_el( $link['link_url'], 'kalles-nav-link megamenu_heading' );
					$heading_style = $link[ 'heading_style' ] == 'yes' ? 'heading_text_wrapper' : '';

					$this->add_render_attribute(
								[
									$li_key     => [
										'class' => ['menu-item', 'item-level-2', 'menu-default-dropdown', $heading_style],
									],

									$label_key    => [
										'class' => [
											'menu-item-label',
											'label-' . $link['label_color']
										],
									],
								]
							);

					$this->add_inline_editing_attributes( $label_key );

					 ?>
					 <li <?php The4Helper::ksesHTML( $this->get_render_attribute_string( $li_key ) ); ?>>
					 	<a <?php The4Helper::ksesHTML( $link_attrs ); ?>>
					 		<?php echo esc_html( $link[ 'link_text' ] ); ?>
					 		<?php if ( $link[ 'label_text' ] ) : ?>
								<span <?php The4Helper::ksesHTML( $this->get_render_attribute_string( $label_key ) ); ?>>
									<?php echo esc_html( $link[ 'label_text' ] ); ?>
								</span>
							<?php endif; ?>
						</a>
					 </li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
        return;

	}
}
/////////////////////
