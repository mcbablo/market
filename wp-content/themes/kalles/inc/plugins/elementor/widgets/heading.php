<?php
/**
 * Add widget banner to elementor
 *
 * @since   1.6.2
 * @package Kalles
 */
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Kalles_Elementor_Heading_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'kalles-heading';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Heading', 'kalles' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-t-letter';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return array( 'heading', 'h3' );
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
            'kalles_addons_heading',
            array(
                'label' => esc_html__( 'Content', 'kalles' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
        $this->add_control(
            'style',
            array(
                'label' => esc_html__('Style', 'kalles'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'title_1'  => esc_html__('Style 1', 'kalles'),
                    'title_2'  => esc_html__('Style 2', 'kalles'),
                    'title_3'  => esc_html__('Style 3', 'kalles'),
                    'title_4'  => esc_html__('Style 4', 'kalles'),
                    'title_5'  => esc_html__('Style 5', 'kalles'),
                    'title_6'  => esc_html__('Style 6', 'kalles'),
                    'title_7'  => esc_html__('Style 7', 'kalles'),
                    'title_8'  => esc_html__('Style 8', 'kalles'),
                    'title_9'  => esc_html__('Style 9', 'kalles'),
                    'title_10' => esc_html__('Style 10', 'kalles'),
                    'title_11' => esc_html__('Style 11', 'kalles'),
                ),
                'default' => 'title_1',
            )
        );
        $this->add_control(
            'title',
            array(
                'label' => esc_html__( 'Title', 'kalles' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'input_type' => 'text',
                'placeholder' => '',
            )
        );

        $this->add_control(
            'sub_title',
            array(
                'label' => esc_html__( 'Small Text', 'kalles' ),
                'description' => esc_html__( 'It shows below the Text', 'kalles' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
            )
        );
        $this->add_control(
            'short_desc',
            array(
                'label'       => esc_html__( 'Short Description', 'kalles' ),
                'type'        => Controls_Manager::WYSIWYG,
                'dynamic'     => array(
                    'active' => true,
                ),
                'default'     => '',
                'placeholder' => esc_html__( 'Enter short description', 'kalles' ),
                'separator'   => 'none',
                'rows'        => 10,
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
                'description' => esc_html__( 'Add divider of heading.', 'kalles' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'No', 'kalles' ),
                'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => 'yes',
            )
        );
        $this->add_control(
            'icon',
            array(
                'label' => esc_html__( 'Divider Icon', 'kalles' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition'   => array(
                    'style' => array(
                        'title_5',
                        'title_6',
                    ),
                ),
            )
        );
        $this->add_control( 'divider_color',
            array(
                'label'     => esc_html__( 'Divider Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .section-title span span::after' => 'color: {{VALUE}}; background-color: {{VALUE}}',
                    '{{WRAPPER}} .section-title span::before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .section-title span::after' => 'color: {{VALUE}}',
                ),
                'condition'   => array(
                    'divider' => 'yes',
                ),
            )
        );
        $this->add_responsive_control(
            'align',
            array(
                'label'     => esc_html__( 'Alignment', 'kalles' ),
                'type'      => Controls_Manager::CHOOSE,
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'kalles' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center'  => array(
                        'title' => esc_html__( 'Center', 'kalles' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'   => array(
                        'title' => esc_html__( 'Right', 'kalles' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                    'justify' => array(
                        'title' => esc_html__( 'Justified', 'kalles' ),
                        'icon'  => 'eicon-text-align-justify',
                    ),
                ),
                'default'   => 'center',
                'selectors' => array(
                    '{{WRAPPER}} .wrap_title' => 'text-align: {{VALUE}};',
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
        /*TAB STYLE*/
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
                    '{{WRAPPER}} .section-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );
        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .section-title' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',

                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} .section-title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_small_title',
            array(
                'label' => esc_html__( 'Small Title', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'small_title_spacing',
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
                    '{{WRAPPER}} .section-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );
        $this->add_control(
            'small_title_color',
            array(
                'label'     => esc_html__( 'Small Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .section-subtitle' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}}',

                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'small_title_typography',
                'label' => esc_html__( 'Small Text Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} .section-subtitle',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
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
                    '{{WRAPPER}} .short-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_control(
            'short_desc_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .short-desc' => 'color: {{VALUE}}',

                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'label' => esc_html__( 'Description Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} .short-desc',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
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
                    'classic' => esc_html__( 'Classic', 'kalles' ),
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
                ),

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
                'label'    => esc_html__( 'Button Typography1', 'kalles' ),
                'selector' => '{{WRAPPER}} .btn-link',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );
        $repeater = new Repeater();

        $repeater->start_controls_tabs('button_style_tabs');
        $repeater->start_controls_tab(
            'button_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );

        $repeater->add_control( 'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}} .btn-link:after' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $repeater->add_control( 'button_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link'       => 'border: 2px solid {{VALUE}}',
                ),
            )
        );

        $repeater->add_control( 'button_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'button_type' => array(
                        'basic_light',
                        'basic',
                    ),
                ),
            )
        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'button_hover_style_tab',
            [
                'label' => esc_html__( 'Hover Style', 'kalles' )
            ]
        );
        $repeater->add_control( 'button_color_hover',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-link:hover:after' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $repeater->add_control( 'button_border_color_hover',
            array(
                'label'     => esc_html__( 'Border Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link:hover'       => 'border: 2px solid {{VALUE}}',
                ),
            )
        );

        $repeater->add_control( 'button_bg_color_hover',
            array(
                'label'     => esc_html__( 'Background Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .btn-link:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->end_controls_section();
        // End button style --

    }
    private function get_btn_link_url( $settings ) {
        if ( 'none' === $settings['btn_link_to'] ) {
            return false;
        }

        if ( empty( $settings['btn_link']['url'] ) ) {
            return false;
        }

        return $settings['btn_link'];

    }
    /**
     * Create shortcode row
     *
     * @return string
     */
    public function create_shortcode() {

        $settings = $this->get_settings_for_display();

        $btn_link      = $this->get_btn_link_url( $settings );

        if ( $btn_link ) {

            $btn_class = 'btn-link btn-type-' . $settings['button_type'];
            $this->add_render_attribute( 'btn_link', [
                'href'  => $btn_link['url'],
                'class' => $btn_class
            ] );

            if ( ! empty( $btn_link['is_external'] ) ) {
                $this->add_render_attribute( 'btn_link', 'target', '_blank' );
            }

            if ( ! empty( $btn_link['nofollow'] ) ) {
                $this->add_render_attribute( 'btn_link', 'rel', 'nofollow' );
            }
        }



        $args_row = '';

        //////////////////
        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

        /////////////////////

        $args_row .= $settings['style'] ? ' class="des_'.esc_attr($settings['style']).'"' : '';

        $args_row .= $settings['style'] ? ' style="'.esc_attr($settings['style']).'"' : '';

        $args_row .= $settings['title'] ? ' title="'. $settings['title'] .'"' : '';

        $args_row .= $settings['sub_title'] ? ' sub_title="'. $settings['sub_title'] .'"' : '';

        $args_row .= $settings['short_desc'] ? ' short_desc="'. $settings['short_desc'] .'"' : '';

        $args_row .= $settings['btn_link']['url'] ? ' link_url="'.esc_url($settings['btn_link']['url']).'"' : '';

        $args_row .= $settings['btn_link']['is_external'] ? ' link_target="_blank"' : '';

        $args_row .= $settings['btn_link']['nofollow'] ? ' link_rel="nofollow"' : '';

        $args_row .= $settings['btn_link_text'] ? ' btn_link_text="'.esc_attr($settings['btn_link_text']).'"' : '';

        $args_row .= $settings['divider'] == 'yes' ? ' divider="true"' : '';

        $args_row .= $settings['icon'] ? ' icon="'.esc_attr($settings['icon']['value']).'"' : '';


        return '[kalles_addons_heading'.$args_row.']';

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $btn_link      = $this->get_btn_link_url( $settings );

        if ( $btn_link ) {

            $btn_class = 'btn-link btn-type-' . $settings['button_type'];
            $this->add_render_attribute( 'btn_link', [
                'href'  => $btn_link['url'],
                'class' => $btn_class
            ] );

            if ( ! empty( $btn_link['is_external'] ) ) {
                $this->add_render_attribute( 'btn_link', 'target', '_blank' );
            }

            if ( ! empty( $btn_link['nofollow'] ) ) {
                $this->add_render_attribute( 'btn_link', 'rel', 'nofollow' );
            }
        }
        $classes = array();
        $title_html    = '';
        $style         = $settings['style'];
        $title         = $settings['title'];
        $sub_title     = $settings['sub_title'];
        $button_type     = $settings['button_type'];
        $short_desc    = $settings['short_desc'];
        $btn_link_text = $settings['btn_link_text'];
        $link_target   = isset ( $settings['btn_link']['is_external'] ) ? $settings['btn_link']['is_external'] : '';
        $link_rel      = isset ( $settings['btn_link']['nofollow'] ) ? $settings['btn_link']['nofollow'] : '' ;
        $css_animation = $settings['css_animation'];
        $link_url      = isset( $settings['btn_link']['url'] ) ? $settings['btn_link']['url'] : '';
        $divider       = $settings['divider'];
        $icon          = isset ( $settings['icon']['value'] ) ? $settings['icon']['value'] : '';
        $classes[] = $divider ? 'divider' : '';

        if ( '' !== $css_animation ) {
            wp_enqueue_script( 'waypoints' );
            $classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
        }

        if ( ! empty( $class ) ) {
            $classes[] = $class;
        }


        $title_html .= '<div class="wrap_title des_' .esc_attr($style) . ' ' . esc_attr( implode( ' ', $classes ) ) . '">';

        if ( $title ) {
            $title_html .= '<h3 class="section-title"><span class="pr flex fl_center al_center "><span>' . $title . '</span></span></h3>';
        }
        if ( $divider && ($style == 'title_5' || $style == 'title_6' )) {
            $title_html .= '<span class="tt_divider flex fl_center al_center"><span></span><i class="' . esc_attr( $icon ) . '"></i><span></span></span>';
        }
        if ( $divider && ( $style == 'title_7')) {
            $title_html .= '<span class="tt_divider flex fl_center al_center"><span></span><i class="la icon-la"></i><span></span></span>';
        }
        if ( $sub_title ) {
            $title_html .= '<span class="section-subtitle db sub-title">' . $sub_title . '</span>';
        }
        if ( $divider && ($style == 'title_11' )) {
            $title_html .= '<span class="tt_divider flex"></span>';
        }
        if ( $short_desc ) {
            $title_html .= '<div class="section-desc db short-desc ">' . $short_desc . '</div>';
        }

        if ( ! empty( $btn_link_text ) ) {

            $title_html .= '<p class="section-link db"><a class="btn-link button-' . esc_attr( $button_type ) . '" href="' . esc_attr( $link_url ) . '"' . ( $link_target ? ' target="' . esc_attr( $link_target ) . '"' : '' ) . ( $link_rel ? ' rel="' . esc_attr( $link_rel ) . '"' : '' ) . ( $btn_link_text ? ' title="' . esc_attr( $btn_link_text ) . '"' : '' ) . '><span>'. sanitize_text_field( $btn_link_text ).'</span></a></p>';

        }
        $title_html .= '</div>';
        echo '' . $title_html . '';

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
