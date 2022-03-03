<?php
/**
 * Add widget banner to elementor
 *
 * @since   1.6.2
 * @package Kalles
 */
if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
    return false;
}
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;

class Kalles_Elementor_Banner_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'banner';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Banner', 'kalles' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-image';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return array( 'banner' );
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
            'section_image',
            array(
                'label' => esc_html__( 'Image', 'kalles' ),
            )
        );

        $this->add_control(
            'image',
            array(
                'label'   => esc_html__( 'Choose Image', 'kalles' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => array(
                    'active' => true,
                ),
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_control(
            'overlay_color', [
            'label'     => esc_html__( 'Overlay Color', 'kalles' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .overlay-color' => 'background-color: {{VALUE}};',
            ],
        ] );
        $this->add_control(
            'effect_hover',
            array(
                'label' => esc_html__( 'Enable Effect Hover?', 'kalles' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'No', 'kalles' ),
                'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => 'yes',
            )
        );
        $this->add_control(
            'link_to',
            array(
                'label'   => esc_html__( 'Link', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'   => esc_html__( 'None', 'kalles' ),
                    'file'   => esc_html__( 'Media File', 'kalles' ),
                    'custom' => esc_html__( 'Custom URL', 'kalles' ),
                ),
            )
        );

        $this->add_control(
            'link',
            array(
                'label'       => esc_html__( 'Link', 'kalles' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => array(
                    'active' => true,
                ),
                'placeholder' => esc_html__( 'https://the4.co', 'kalles' ),
                'condition'   => array(
                    'link_to' => 'custom',
                ),
                'show_label'  => false,
            )
        );
        $this->add_control(
            'banner_layout',
            array(
                'label'   => esc_html__( 'Banner Layout', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'content_inside',
                'options' => array(
                    'content_inside'   => esc_html__( 'Content Inside', 'kalles' ),
                    'content_outside'   => esc_html__( 'Content Outside', 'kalles' ),
                ),
            )
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'content_section',
            array(
                'label' => esc_html__( 'Content', 'kalles' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
        $this->add_control(
            'label_text',
            array(
                'label'       => esc_html__( 'Label', 'kalles' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'placeholder' => esc_html__( 'Add label banner', 'kalles' ),
                'default'     => '',
                'condition'   => array(
                    'banner_layout' => 'content_outside',
                ),
            )
        );
        $this->add_control(
            'label_color',
            array(
                'label'     => esc_html__( 'Label Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .label-content' => 'border-top-color: {{VALUE}}; border-right-color: {{VALUE}}',

                ),
            )
        );
        $this->add_control(
            'sub_title',
            array(
                'label'       => esc_html__( 'Sub Title', 'kalles' ),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => array(
                    'active' => true,
                ),
                'placeholder' => esc_html__( 'Enter banner title', 'kalles' ),
                'default'     => esc_html__( 'Add The Banner Sub Title Here', 'kalles' ),
                'condition'   => array(
                    'banner_layout' => 'content_inside',
                ),
            )
        );
        $this->add_control(
            'title',
            array(
                'label'       => esc_html__( 'Title', 'kalles' ),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => array(
                    'active' => true,
                ),
                'placeholder' => esc_html__( 'Enter banner title', 'kalles' ),
                'default'     => esc_html__( 'Add The Banner Title Here', 'kalles' ),
            )
        );

        $this->add_control(
            'short_desc',
            array(
                'label'       => esc_html__( 'Short Description', 'kalles' ),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => array(
                    'active' => true,
                ),
                'default'     => esc_html__( 'Lorem ipsum dolor sit amet', 'kalles' ),
                'placeholder' => esc_html__( 'Enter short description', 'kalles' ),
                'separator'   => 'none',
                'rows'        => 10,
                'condition'   => array(
                    'banner_layout' => 'content_inside',
                ),
            )
        );

        $this->add_control(
            'btn_link_to',
            array(
                'label'   => esc_html__( 'Button Link', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'   => esc_html__( 'None', 'kalles' ),
                    'custom' => esc_html__( 'Custom URL', 'kalles' ),
                ),
                'condition'   => array(
                    'banner_layout' => 'content_inside',
                ),
            )
        );

        $this->add_control(
            'btn_link_text',
            array(
                'label'       => esc_html__( 'Button Link Text', 'kalles' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => false,
                ),
                'placeholder' => esc_html__( 'Enter button link text', 'kalles' ),
                'default'     => esc_html__( 'Go', 'kalles' ),
                'condition'   => array(
                    'btn_link_to' => 'custom',
                ),
            )
        );
        $this->add_control(
            'btn_link',
            array(
                'label'       => esc_html__( 'Link', 'kalles' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => array(
                    'active' => true,
                ),
                'placeholder' => esc_html__( 'https://the4.com', 'kalles' ),
                'condition'   => array(
                    'btn_link_to' => 'custom',
                ),
                'show_label'  => false,
            )
        );
        $this->add_control(
            'divider',
            array(
                'label' => esc_html__( 'Enable divider?', 'kalles' ),
                'description' => esc_html__( 'Add divider of Title.', 'kalles' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'No', 'kalles' ),
                'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => 'no',
                'condition'   => array(
                    'banner_layout' => 'content_inside',
                ),
            )
        );
        $this->add_control( 'divider_color',
            array(
                'label'     => esc_html__( 'Divider Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .tt_divider' => 'border-color: {{VALUE}}',
                ),
                'condition'   => array(
                    'divider' => 'yes',
                ),
            )
        );
        ///////////////////////

        $this->add_control(
            'css_animation',
            array(
                'label' => esc_html__( 'CSS Animation', 'kalles' ),
                'type' => Controls_Manager::SELECT,
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
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => '',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_Content',
            array(
                'label' => esc_html__( 'Content', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_responsive_control(
            'align',
            array(
                'label'     => esc_html__( 'Content Alignment', 'kalles' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => array(
                    'left'   => array(
                        'title' => esc_html__( 'Left', 'kalles' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'kalles' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => esc_html__( 'Right', 'kalles' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .the4-banner' => 'text-align: {{VALUE}};',
                ),
            )
        );
        $this->add_responsive_control(
            'content_padding',
            array(
                'label'      => esc_html__( 'Padding', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_control(
            'horizontal_position',
            array(
                'label'                => esc_html__( 'Horizontal Position', 'kalles' ),
                'type'                 => Controls_Manager::CHOOSE,
                'label_block'          => false,
                'options'              => array(
                    'left'   => array(
                        'title' => esc_html__( 'Left', 'kalles' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'kalles' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'right'  => array(
                        'title' => esc_html__( 'Right', 'kalles' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'selectors'            => array(
                    '{{WRAPPER}} .banner-content .content-inner' => '{{VALUE}}',
                ),
                'selectors_dictionary' => array(
                    'left'   => 'margin-right: auto',
                    'center' => 'margin: 0 auto',
                    'right'  => 'margin-left: auto',
                )
            )
        );

        $this->add_control(
            'vertical_position',
            array(
                'label'                => esc_html__( 'Vertical Position', 'kalles' ),
                'type'                 => Controls_Manager::CHOOSE,
                'label_block'          => false,
                'options'              => array(
                    'top'    => array(
                        'title' => esc_html__( 'Top', 'kalles' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'middle' => array(
                        'title' => esc_html__( 'Middle', 'kalles' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'bottom' => array(
                        'title' => esc_html__( 'Bottom', 'kalles' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .banner-content' => 'align-items: {{VALUE}}',
                ),
                'selectors_dictionary' => array(
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                )
            )
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_sub_title',
            array(
                'label' => esc_html__( 'Sub Title text', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'sub_title_spacing',
            array(
                'label'     => esc_html__( 'Spacing', 'kalles' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .banner-sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_control(
            'sub_title_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .banner-sub-title' => 'color: {{VALUE}}',

                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .banner-sub-title',
            )
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_title',
            array(
                'label' => esc_html__( 'Title', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'title_spacing',
            array(
                'label'     => esc_html__( 'Spacing', 'kalles' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .banner-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .banner-title' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',

                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'heading_typography',
                //'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .banner-title',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_short_desc',
            array(
                'label' => esc_html__( 'Description', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'short_desc_spacing',
            array(
                'label'     => esc_html__( 'Spacing', 'kalles' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .banner-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_control(
            'short_desc_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .banner-desc' => 'color: {{VALUE}}',

                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .banner-desc',
            )
        );

        $this->add_control(
            'short_desc_hide_desktop',
            array(
                'label'        => esc_html__( 'Hide On Desktop', 'kalles' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => 'Hide',
                'label_off'    => 'Show',
                'return_value' => 'hidden-desktop',
            )
        );

        $this->add_control(
            'short_desc_hide_tablet',
            array(
                'label'        => esc_html__( 'Hide On Tablet', 'kalles' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => 'Hide',
                'label_off'    => 'Show',
                'return_value' => 'hidden-tablet',
            )
        );

        $this->add_control(
            'short_desc_hide_mobile',
            array(
                'label'        => esc_html__( 'Hide On Mobile', 'kalles' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => 'Hide',
                'label_off'    => 'Show',
                'return_value' => 'hidden-phone',
            )
        );

        $this->end_controls_section();
        // Start button style
        $this->start_controls_section(
            'section_style_button',
            array(
                'label'     => esc_html__( 'Button', 'kalles' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'btn_link_to' => 'custom',
                ),
            )
        );

        $this->add_control(
            'button_type',
            array(
                'label'   => esc_html__( 'Button Type', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'default' => esc_html__( 'Default', 'kalles' ),
                    'round'    => esc_html__( 'Round ', 'kalles' ),
                    'basic'    => esc_html__( 'Basic ', 'kalles' ),
                    'basic2'    => esc_html__( 'Basic 2', 'kalles' )
                ),
                'default' => 'default',
            )
        );

        $this->add_control( 'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}} .btn-link:after' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $this->add_control( 'button_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link'       => 'border: 2px solid {{VALUE}}',
                ),
            )
        );

        $this->add_control( 'button_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link' => 'background-color: {{VALUE}};',
                )
            )
        );
        $this->add_responsive_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .btn-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .btn-link',
            )
        );

        $this->end_controls_section();
        // End button style --

    }

    /**
     * Create shortcode row
     *
     * @return string
     */
    public function create_shortcode() {

        $settings = $this->get_settings_for_display();

        $args_row = '';

        $args_row .= !empty($settings['image']['id']) ? ' image_id="'.esc_attr($settings['image']['id']).'"' : '';

        $args_row .= $settings['banner_layout'] ? ' banner_layout="'.esc_attr($settings['banner_layout']).'"' : '';

        $args_row .= $settings['label_text'] ? ' label_text="'.esc_html($settings['label_text']).'"' : '';

        $args_row .= $settings['sub_title'] ? ' sub_title="'.esc_html($settings['sub_title']).'"' : '';

        $args_row .= $settings['title'] ? ' title="' .$settings['title'].'"' : '';

        $args_row .= $settings['short_desc'] ? ' short_desc="'.$settings['short_desc'].'"' : '';

        $args_row .= isset ( $settings['link']['url'] ) ? ' link_url="'.esc_url($settings['link']['url']).'"' : '';

        $args_row .= isset ( $settings['link']['is_external'] ) ? ' link_target="_blank"' : '';

        $args_row .= isset ( $settings['link']['nofollow'] ) ? ' link_rel="nofollow"' : '';

        $args_row .= isset ( $settings['btn_link']['url'] ) ? ' btn_link_url="'.esc_url($settings['btn_link']['url']).'"' : '';

        $args_row .= isset ( $settings['btn_link']['is_external'] ) ? ' link_target="_blank"' : '';

        $args_row .= isset ( $settings['btn_link']['nofollow'] ) ? ' link_rel="nofollow"' : '';

        $args_row .= $settings['button_type'] ? ' button_type="button-'.esc_attr($settings['button_type']).'"' : '';

        $args_row .= $settings['btn_link_text'] ? ' btn_link_text="'.esc_attr($settings['btn_link_text']).'"' : '';

        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

        $args_row .= $settings['divider'] == 'yes' ? ' divider="true"' : '';

        $args_row .= $settings['effect_hover'] == 'yes' ? ' effect_hover="true"' : '';

        return '[kalles_addons_banner'.$args_row.']';

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        echo do_shortcode( $this->create_shortcode() );

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
