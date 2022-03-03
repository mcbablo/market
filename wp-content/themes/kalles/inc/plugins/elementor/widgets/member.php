<?php
/**
 * Add widget member to elementor
 *
 * @since   1.6.2
 * @package Kalles
 */
use Elementor\Repeater;
use Elementor\Controls_Manager;

class Kalles_Elementor_Member_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'member';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Member', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-box';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'member' );
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
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
			'avatar',
			array(
				'label' => esc_html__( 'Avatar', 'kalles' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			)
		);

		///////////////////////

        $this->add_control(
			'name',
			array(
				'label' => esc_html__( 'Name', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text'
			)
		);

        ///////////////////////

		$this->add_control(
			'job',
			array(
				'label' => esc_html__( 'Job', 'kalles' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text'
			)
		);

        ///////////////////////
        $repeater = new Repeater();

        $repeater->add_control(
            'social_icon',
            array(
                'label' => esc_html__( 'Icon', 'kalles' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            )
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'kalles' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'is_external' => 'true',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'kalles' ),
            ]
        );
        $this->add_control(
            'social',
            [
                'type'        => Controls_Manager::REPEATER,
                'show_label'  => true,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'heading'          => esc_html__( 'Social 1 ', 'kalles' ),
                    ],
                    [
                        'heading'          => esc_html__( 'Social 2', 'kalles' ),
                    ],
                    [
                        'heading'          => esc_html__( 'Social 3', 'kalles' ),
                    ],
                    [
                        'heading'          => esc_html__( 'Social 4', 'kalles' ),
                    ],
                ],
                'title_field' => '{{{ heading }}}',
            ]
        );
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

        $args_row .= !empty($settings['avatar']['id']) ? ' image_id="'.esc_attr($settings['avatar']['id']).'"' : '';

        $args_row .= $settings['name'] ? ' name="'.esc_html($settings['name']).'"' : '';

        $args_row .= $settings['job'] ? ' job="'.esc_html($settings['job']).'"' : '';


        //////////////////
        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

        return '[kalles_addons_member'.$args_row.']';

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		echo do_shortcode( $this->create_shortcode() );
        $settings = $this->get_settings_for_display();

        $image_id     = $settings['avatar']['id'];
        $name         = $settings['name'];
        $job          = $settings['job'];
        $css_animation = $settings['css_animation'];
        $classes = array( 'the4-member tc pr' );
        if ( '' !== $css_animation ) {
            wp_enqueue_script( 'waypoints' );
            $classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
        }

        if ( ! empty( $class ) ) {
            $classes[] = $class;
        }?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <?php if ( ! empty( $avatar ) ) {
                $img_id = preg_replace( '/[^\d]/', '', $avatar );

                echo  wp_get_attachment_image( $img_id, 'large', '', array( "class" => "w__100", 'alt' => esc_attr( $name ) ) );

            } elseif ( ! empty( $image_id ) ){

                echo wp_get_attachment_image( $image_id, 'large', '', array( "class" => "w__100", 'alt' => esc_attr( $name ) ) );

            } ?>
			<div class="social-info pt__15">
				<h4 class="fwsb"><?php echo esc_html( $name ) ; ?></h4>
				<span><?php echo esc_html( $job )  ; ?></span>
				<div class="social pa w__100 ts__03">
					<?php
					$migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
					foreach ($settings['social'] as $index => $item) {
						$migrated = isset($item['__fa4_migrated']['social_icon']);
						$is_new = empty($item['social']) && $migration_allowed;
						$social = '';


						if (!empty($item['social'])) {
							$social = str_replace('fa fa-', '', $item['social']);
						}

						if (($is_new || $migrated) && 'svg' !== $item['social_icon']['library']) {
							$social = explode(' ', $item['social_icon']['value'], 2);
							if (empty($social[1])) {
								$social = '';
							} else {
								$social = str_replace('fa-', '', $social[1]);
							}
						}
						if ('svg' === $item['social_icon']['library']) {
							$social = get_post_meta($item['social_icon']['value']['id'], '_wp_attachment_image_alt', true);
						}

						$link_key = 'link_' . $index;

						$this->add_render_attribute($link_key, 'class', [
							'social-icon',
						]);

						$this->add_link_attributes($link_key, $item['link']);

						?>
						<a <?php $this->print_render_attribute_string($link_key); ?>>
							<span class="elementor-screen-only"><?php echo esc_html(ucwords($social)); ?></span>
							<?php
							if ($is_new || $migrated) {
								\Elementor\Icons_Manager::render_icon($item['social_icon']);
							} else { ?>
								<i class="<?php echo esc_attr($item['social']); ?>"></i>
							<?php } ?>
						</a>
					<?php }?>
				</div>
			</div>
        </div>
    <?php }

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
