<?php

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
    return false;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Kalles_Elementor_Banners_Slides extends \Elementor\Widget_Base {

    public function get_name() {
        return 'banners-carousel';
    }

    public function get_title() {
        return esc_html__( 'Banners Carousel', 'kalles' );
    }

    public function get_icon() {
        return 'eicon-slideshow';
    }

    public function get_categories() {
        return [ 'kalles-elements' ];
    }

    public function get_keywords() {
        return [ 'slides', 'carousel', 'image', 'title', 'slider', 'the4' ];
    }

    public function get_script_depends() {
        return [ 'imagesloaded', 'swiper' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__( 'Slides', 'kalles' ),
            ]
        );

        $repeater = new Repeater();

        //Image
        $repeater->add_control(
            'item_slide',
            [
                'label'   => esc_html__( 'Slide Wrapper', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $repeater->start_controls_tabs('slide-item');
        $repeater->start_controls_tab(
            'image_tab',
            [
                'label' => esc_html__( 'Image', 'kalles' )
            ]
        );
        $repeater->add_control(
            'background_image',
            [
                'type'      => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-bg' => 'background-image: url({{URL}})',
                ],
            ]
        );
        $repeater->add_control(
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

        $repeater->add_control(
            'link_img',
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

        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'style_background',
            [
                'label' => esc_html__( 'Sltyle', 'kalles' )
            ]
        );

        $repeater->add_control(
            'background_overlay',
            [
                'label'      => esc_html__( 'Background Overlay', 'kalles' ),
                'type'       => Controls_Manager::SWITCHER,
                'default'    => '',
                'separator'  => 'before',
            ]
        );

        $repeater->add_control(
            'background_overlay_color',
            [
                'label'      => esc_html__( 'Color', 'kalles' ),
                'type'       => Controls_Manager::COLOR,
                'default'    => 'rgba(0,0,0,0.5)',
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .bg-overlay' => 'background-color: {{VALUE}}',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'background_overlay',
                            'value' => 'yes',
                        ]
                    ],
                ],
            ]

        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'layout_tab',
            [
                'label' => esc_html__( 'Layout', 'kalles' )
            ]
        );

        $repeater->add_control(
            'horizontal_position',
            [
                'label'                => esc_html__( 'Horizontal Position', 'kalles' ),
                'type'                 => Controls_Manager::CHOOSE,
                'label_block'          => false,
                'options'              => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'kalles' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'kalles' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'kalles' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .slide-content .content-inner' => '{{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'left'   => 'margin-right: auto',
                    'center' => 'margin: 0 auto',
                    'right'  => 'margin-left: auto',
                ]
            ]
        );

        $repeater->add_control(
            'vertical_position',
            [
                'label'                => esc_html__( 'Vertical Position', 'kalles' ),
                'type'                 => Controls_Manager::CHOOSE,
                'label_block'          => false,
                'options'              => [
                    'top'    => [
                        'title' => esc_html__( 'Top', 'kalles' ),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__( 'Middle', 'kalles' ),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'kalles' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .slide-content' => 'align-items: {{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ]
            ]
        );

        $repeater->add_control(
            'text_align',
            [
                'label'       => esc_html__( 'Text Align', 'kalles' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'kalles' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'kalles' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'kalles' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'slides_padding',
            [
                'label'      => esc_html__( 'Padding', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $repeater->add_control(
            'title_text',
            [
                'label'   => esc_html__( 'Slide Title', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $repeater->start_controls_tabs('banner_title');
        /////
        $repeater->start_controls_tab(
            'title_tab',
            [
                'label' => esc_html__( 'Title text', 'kalles' )
            ]
        );
        $repeater->add_control(
            'heading',
            [
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Slide Heading', 'kalles' ),
                'label_block' => true,
            ]
        );
        $repeater->end_controls_tab();
        /////
        $repeater->start_controls_tab(
            'title_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );
        $repeater->add_control(
            'heading_spacing',
            [
                'label'     => esc_html__( 'Title Spacing', 'kalles' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .slide-heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $repeater->add_control(
            'heading_color',
            [
                'label'     => esc_html__( 'Title Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-heading' => 'color: {{VALUE}}',

                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'     => esc_html__( 'Title Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .slide-heading',
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $repeater->add_control(
            'sub_title_text',
            [
                'label'   => esc_html__( 'Slide Sub Title', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $repeater->start_controls_tabs('banner_sub_title');
        /////
        $repeater->start_controls_tab(
            'sub_title_tab',
            [
                'label' => esc_html__( 'Sub Title text', 'kalles' )
            ]
        );
        $repeater->add_control(
            'sub_heading',
            [
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Slide Sub Heading', 'kalles' ),
                'label_block' => true,
            ]
        );
        $repeater->end_controls_tab();
        /////
        $repeater->start_controls_tab(
            'sub_title_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );
        $repeater->add_control(
            'sub_heading_spacing',
            [
                'label'     => esc_html__( 'Sub Title Spacing', 'kalles' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .slide-sub-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $repeater->add_control(
            'sub_heading_color',
            [
                'label'     => esc_html__( 'Sub Title Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-sub-heading' => 'color: {{VALUE}}',

                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_heading_typography',
                'label'     => esc_html__( 'Sub Title Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .slide-sub-heading',
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $repeater->add_control(
            'desc_text',
            [
                'label'   => esc_html__( 'Slider Description', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $repeater->start_controls_tabs('banner_desc');
/////
        $repeater->start_controls_tab(
            'desc_tab',
            [
                'label' => esc_html__( 'Description text', 'kalles' )
            ]
        );
        $repeater->add_control(
            'description',
            [
                'label'      => esc_html__( 'Description', 'kalles' ),
                'type'       => Controls_Manager::TEXTAREA,
                'default'    => esc_html__( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'kalles' ),
                'show_label' => false,
            ]
        );
        $repeater->end_controls_tab();
/////
        $repeater->start_controls_tab(
            'desc_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );
        $repeater->add_control(
            'description_spacing',
            [
                'label'     => esc_html__( 'Description Spacing', 'kalles' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .the4-swiper-slide-inner .slide-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Description Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-description' => 'color: {{VALUE}}',

                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'     => esc_html__( 'Description Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .slide-description',
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $repeater->add_control(
            'heading_button',
            [
                'label'   => esc_html__( 'Slide Button', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $repeater->start_controls_tabs('button_item');
        $repeater->start_controls_tab(
            'button',
            [
                'label' => esc_html__( 'Button', 'kalles' )
            ]
        );
        $repeater->add_control(
            'button_text',
            [
                'label'   => esc_html__( 'Button Text', 'kalles' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Click Here', 'kalles' ),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => esc_html__( 'Link', 'kalles' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'kalles' ),
            ]
        );


        $repeater->add_control(
            'link_click',
            [
                'label'      => esc_html__( 'Apply Link On', 'kalles' ),
                'type'       => Controls_Manager::SELECT,
                'options'    => [
                    'slide'  => esc_html__( 'Whole Slide', 'kalles' ),
                    'button' => esc_html__( 'Button Only', 'kalles' ),
                ],
                'default'    => 'slide',
                'conditions' => [
                    'terms' => [
                        [
                            'name'     => 'link[url]',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'style_button',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );


        $repeater->add_control(
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

        $repeater->add_control( 'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn-link' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn-link:after' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $repeater->add_control( 'button_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn-link'       => 'border: 2px solid {{VALUE}}',
                ),
            )
        );

        $repeater->add_control( 'button_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn-link' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'button_type' => array(
                        'basic_light',
                        'basic',
                    ),
                ),
            )
        );

        $repeater->add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .btn-link',
            )
        );


        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'slides',
            [
                'type'        => Controls_Manager::REPEATER,
                'show_label'  => true,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'heading'          => esc_html__( 'Slide 1 ', 'kalles' ),
                        'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                        'button_text'      => esc_html__( 'Click Here', 'kalles' ),
                        'background_color' => '#833ca3',
                    ],
                    [
                        'heading'          => esc_html__( 'Slide 2', 'kalles' ),
                        'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                        'button_text'      => esc_html__( 'Click Here', 'kalles' ),
                        'background_color' => '#4054b2',
                    ],
                    [
                        'heading'          => esc_html__( 'Slide 3', 'kalles' ),
                        'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                        'button_text'      => esc_html__( 'Click Here', 'kalles' ),
                        'background_color' => '#1abc9c',
                    ],
                ],
                'title_field' => '{{{ heading }}}',
            ]
        );
        $this->add_control(
            'custom_height',
            [
                'label'      => esc_html__( 'Custom Height Slide', 'kalles' ),
                'type'       => Controls_Manager::SWITCHER,
                'default'    => '',
                'separator'  => 'before',
            ]
        );
        $this->add_responsive_control(
            'slides_height',
            [
                'label'      => esc_html__( 'Slide Height', 'kalles' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 400,
                ],
                'size_units' => [ 'px', 'vh', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .the4-swiper-slide-bg' => 'min-height: {{SIZE}}{{UNIT}} !important;',
                ],
                'separator'  => 'before',
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'custom_height',
                            'value' => 'yes',
                        ]
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_options',
            [
                'label' => esc_html__( 'Slider Options', 'kalles' ),
                'type'  => Controls_Manager::SECTION,
            ]
        );
        $slides_to_show = range( 1, 6 );
        $slides_to_show = array_combine( $slides_to_show, $slides_to_show );

        $this->add_responsive_control(
            'slides_to_show',
            [
                'label' => esc_html__( 'Slides to Show', 'kalles' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                        '' => esc_html__( '4', 'kalles' ),
                    ] + $slides_to_show,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'kalles' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'kalles' ),
                'options' => [
                        '' => esc_html__( '1', 'kalles' ),
                    ] + $slides_to_show,
                'frontend_available' => true,
                'default' => 1,
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between', 'kalles' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
            ]
        );
        $this->add_control(
            'navigation',
            [
                'label'   => esc_html__( 'Navigation', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'both',
                'options' => [
                    'both'   => esc_html__( 'Arrows and Dots', 'kalles' ),
                    'arrows' => esc_html__( 'Arrows', 'kalles' ),
                    'dots'   => esc_html__( 'Dots', 'kalles' ),
                    'none'   => esc_html__( 'None', 'kalles' ),
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'   => esc_html__( 'Pause on Hover', 'kalles' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => esc_html__( 'Autoplay', 'kalles' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Speed', 'kalles' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .the4-swiper-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'   => esc_html__( 'Infinite Loop', 'kalles' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'transition',
            [
                'label'   => esc_html__( 'Transition', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => esc_html__( 'Slide', 'kalles' ),
                    'fade'  => esc_html__( 'Fade', 'kalles' ),
                ],
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label'   => esc_html__( 'Transition Speed', 'kalles' ) . ' (ms)',
                'type'    => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $this->end_controls_section();
    }
    public function kalles_shortcode_banners_carousel(){
        $settings = $this->get_settings();
        if ( empty( $settings['slides'] ) ) {
            return;
        }

        $slides      = [];
        $slide_count = 0;
    
        
        foreach ( $settings['slides'] as $slide ) {

            $slide_html       = '';
            $image_html       = '';
            $btn_attributes   = '';
            $slide_attributes = '';
            $slide_element    = 'div';
            $btn_element      = 'div';
            $slide_url = $slide['link']['url'];

            if ( ! empty( $slide_url ) ) {
                $this->add_render_attribute( 'slide_link' . $slide_count, 'href', $slide_url );

                if ( $slide['link']['is_external'] ) {
                    $this->add_render_attribute( 'slide_link' . $slide_count, 'target', '_blank' );
                }

                if ( 'button' === $slide['link_click'] ) {
                    $btn_element    = 'a';
                    $btn_attributes = $this->get_render_attribute_string( 'slide_link'. $slide_count );
                } else {
                    $slide_element    = 'a';
                    $slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
                }
            }

            if ( 'yes' === $slide['background_overlay'] ) {
                $slide_html .= '<div class="bg-overlay"></div>';
            }
            //Place holder image
            $placeholder = ( $slide % 2 == 0 ) ? 'a8dacc' : 'f76b6a';


            if( $settings['custom_height'] == 'yes' ){
                $image_html .='<div class="the4-swiper-slide-bg"></div>';
            }else{
                if ( ! empty( $slide['link_img']['url'] ) ) {
                    $image_html .= '<a href="' . esc_attr( $slide['link_img']['url'] ) . '" ' . ( $slide['link_img']['is_external'] == 'on' ? ' target="_blank"' : '' ) . '>';
                }
                if ( !empty( $slide['background_image']['id'] ) ) {
                    $image_html .='<figure class="image-item">'. wp_get_attachment_image( $slide['background_image']['id'], 'full', [ 'class' => 'w__100'] ) .'</figure>';
                } else {
                    $image_html .='<figure  class="image-item"><img class="nt_bg_lz pr_lazy_img lazyload item__position "
                                        src="https://placehold.jp/50/' . $placeholder . '/' . $placeholder . '/530x600.png?text=1"  data-srcset="https://placehold.jp/50/' . $placeholder . '/' . $placeholder . '/530x600.png?text=1" /></figure>';
                }
                if ( ! empty( $slide['link_img']['url'] ) ) {
                    $image_html .= '</a>';
                }
            }
            if ( $slide['sub_heading'] || $slide['heading'] || $slide['description'] || $slide['button_text'] ) {
                $slide_html .= '<div class="slide-content"><div class="content-inner">';

                if ($slide['sub_heading']) {
                    $slide_html .= '<div class="slide-sub-heading">' . $slide['sub_heading'] . '</div>';
                }

                if ($slide['heading']) {
                    $slide_html .= '<div class="slide-heading">' . $slide['heading'] . '</div>';
                }

                if ($slide['description']) {
                    $slide_html .= '<div class="slide-description">' . $slide['description'] . '</div>';
                }

                if ($slide['button_text']) {
                    $slide_html .= '<' . $btn_element . ' ' . $btn_attributes . ' class="slide-button btn-link button-' . $slide['button_type'] . '"><span>' . $slide['button_text'] . '</span></' . $btn_element . '>';
                }

                $slide_html .= '</div></div>';
            }

            $content_layout = isset( $slide['content_layout'] ) ? $slide['content_layout'] : 'in_container';

            $slide_html = '<' . $slide_element . ' ' . $slide_attributes . ' class="the4-swiper-slide-inner slide-content-layout-' . esc_attr( $content_layout ) . '">' . $image_html . $slide_html . '</' . $slide_element . '>';
            $slides[]   = '<div class="elementor-repeater-item-' . $slide['_id'] . ' the4-swiper-slide swiper-slide">' . $slide_html . '</div>';
            $slide_count ++;

        }

        $is_rtl      = is_rtl();
        $direction   = $is_rtl ? 'rtl' : 'ltr';
        $show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
        $show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

        $carousel_options = array(
            'slides_to_show'          => $settings['slides_to_show'],
            'slides_to_show_tablet'   => $settings['slides_to_show_tablet'],
            'slides_to_show_mobile'   => $settings['slides_to_show_mobile'],
            'space_between'           => $settings['space_between'],
            'space_between_tablet'    => isset ( $settings['space_between_tablet'] ) ? $settings['space_between_tablet'] : $settings['space_between'],
            'space_between_mobile'    => isset( $settings['space_between_mobile'] ) ? $settings['space_between_mobile'] : $settings['space_between'],
            'slides_to_scroll'        => $settings['slides_to_scroll'],
            'slides_to_scroll_tablet' => $settings['slides_to_scroll_tablet'],
            'slides_to_scroll_mobile' => $settings['slides_to_scroll_mobile'],
            'autoplay'                => $settings['autoplay'],
            'pause_on_hover'          => $settings['pause_on_hover'],
            'autoplay_speed'          => absint( $settings['autoplay_speed'] ),
            'infinite'                => $settings['infinite'],
            'effect'                  => $settings['transition'],
            'speed'                   => absint( $settings['transition_speed'] ),
            'navigation'              => $settings['navigation'],
        );

        $this->add_render_attribute( [
            'carousel-container' => [
                'class'                 => 'the4-swiper-container elementor-image-carousel-wrapper swiper-container',
                'data-carousel_options' => htmlentities2( wp_json_encode( $carousel_options ) ),
                'dir'                   => $direction
            ],
            'carousel-wrapper'   => [
                'class' => 'the4-swiper-wrapper elementor-image-carousel swiper-wrapper',
            ],
        ] );

        ?>
        <div class="the4-slides-wrap content-<?php echo esc_attr( $settings['layout'] ); ?>">
            <div <?php The4Helper::ksesHTML( $this->get_render_attribute_string( 'carousel-container' ) ); ?>>
                <div <?php The4Helper::ksesHTML( $this->get_render_attribute_string( 'carousel-wrapper' ) ); ?>>
                    <?php echo implode( '', $slides ); ?>
                </div>
                <?php if ( $show_dots) : ?>
                    <div class="swiper-pagination"></div>
                <?php endif; ?>
                <?php if ( $show_arrows ) : ?>
                    <div class="elementor-swiper-button elementor-swiper-button-prev the4-swiper-button-prev">
                        <i class="eicon-chevron-left" aria-hidden="true"></i>

                    </div>
                    <div class="elementor-swiper-button elementor-swiper-button-next the4-swiper-button-next">
                        <i class="eicon-chevron-right" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function render() {
        $this->kalles_shortcode_banners_carousel();
        if ( is_admin() ){
            echo '
            <script>
                 jQuery(\'.the4-swiper-container:not(.slider-ready)\').each(function () {
                var $this = jQuery(this);
                var swiperOptions = {
                    slidesPerView: 3, spaceBetween: 30, pagination: {
                        el: \'.swiper-pagination\', clickable: true,
                    }, effect: \'slide\'
                };

                var this_slide_settings = $this.data(\'carousel_options\');

                var effect = this_slide_settings.hasOwnProperty(\'effect\') ? this_slide_settings.effect : \'slide\';
                swiperOptions.effect = effect;

                var slides_to_show = this_slide_settings.hasOwnProperty(\'slides_to_show\') ? parseInt(this_slide_settings.slides_to_show) : 3;
                var slides_to_show_tablet = this_slide_settings.hasOwnProperty(\'slides_to_show_tablet\') ? parseInt(this_slide_settings.slides_to_show_tablet) : 2;
                var slides_to_show_mobile = this_slide_settings.hasOwnProperty(\'slides_to_show_mobile\') ? parseInt(this_slide_settings.slides_to_show_mobile) : 1;
                var slides_to_scroll = this_slide_settings.hasOwnProperty(\'slides_to_scroll\') ? parseInt(this_slide_settings.slides_to_scroll) : 1;
                var slides_to_scroll_tablet = this_slide_settings.hasOwnProperty(\'slides_to_scroll_tablet\') ? parseInt(this_slide_settings.slides_to_scroll_tablet) : 1;
                var slides_to_scroll_mobile = this_slide_settings.hasOwnProperty(\'slides_to_scroll_mobile\') ? parseInt(this_slide_settings.slides_to_scroll_mobile) : 1;
                var space_between = this_slide_settings.hasOwnProperty(\'space_between\') ? parseInt(this_slide_settings.space_between) : 30;
                var space_between_tablet = this_slide_settings.hasOwnProperty(\'space_between_tablet\') ? parseInt(this_slide_settings.space_between_tablet) : 20;
                var space_between_mobile = this_slide_settings.hasOwnProperty(\'space_between_mobile\') ? parseInt(this_slide_settings.space_between_mobile) : 15;
                if (isNaN(slides_to_show)) {
                    slides_to_show = 3;
                }

                if (isNaN(slides_to_show_tablet)) {
                    slides_to_show_tablet = 2;
                }

                if (isNaN(slides_to_show_mobile)) {
                    slides_to_show_mobile = 1;
                }

                if (isNaN(slides_to_scroll)) {
                    slides_to_scroll = 1;
                }

                if (isNaN(slides_to_scroll_tablet)) {
                    slides_to_scroll_tablet = 1;
                }

                if (isNaN(slides_to_scroll_mobile)) {
                    slides_to_scroll_mobile = 1;
                }
                if (isNaN(space_between)) {
                    space_between = 30;
                }

                if (isNaN(space_between_tablet)) {
                    space_between_tablet = 20;
                }

                if (isNaN(space_between_mobile)) {
                    space_between_mobile = 15;
                }
                if (slides_to_show_tablet > slides_to_show) {
                    slides_to_show_tablet = slides_to_show;
                }
                var elementorBreakpoints = elementorFrontend.config.breakpoints;
                swiperOptions.spaceBetween = parseInt(this_slide_settings.space_between_mobile);

                swiperOptions.slidesPerView = slides_to_show_mobile;
                swiperOptions.breakpoints = {};
                swiperOptions.breakpoints[elementorBreakpoints.xs] = {
                    slidesPerView: slides_to_show_mobile,
                    slidesPerGroup: slides_to_scroll_mobile,
                    spaceBetween: space_between_mobile
                };
                swiperOptions.breakpoints[elementorBreakpoints.md] = {
                    slidesPerView: slides_to_show_tablet,
                    slidesPerGroup: slides_to_scroll_tablet,
                    spaceBetween: space_between_tablet
                };
                swiperOptions.breakpoints[elementorBreakpoints.lg] = {
                    slidesPerView: slides_to_show, slidesPerGroup: slides_to_scroll, spaceBetween: space_between
                };
                swiperOptions.speed = parseInt(this_slide_settings.speed) || 300;

                // swiperOptions.direction = this_slide_settings.hasOwnProperty(\'direction\') ? this_slide_settings.direction : \'ltr\';
                if (this_slide_settings.autoplay == \'yes\') {
                    swiperOptions.autoplay = {
                        delay: parseInt(this_slide_settings.autoplay_speed),
                        disableOnInteraction: !!this_slide_settings.pause_on_hover
                    };
                }

                swiperOptions.loop = \'yes\' === this_slide_settings.infinite;
                var showArrows = \'arrows\' === this_slide_settings.navigation || \'both\' === this_slide_settings.navigation,
                    showDots = \'dots\' === this_slide_settings.navigation || \'both\' === this_slide_settings.navigation;

                if (showArrows) {
                    swiperOptions.navigation = {
                        prevEl: \'.the4-swiper-button-prev\', nextEl: \'.the4-swiper-button-next\'
                    };
                }

                if (showDots) {
                    swiperOptions.pagination = {
                        el: \'.swiper-pagination\', type: \'bullets\', clickable: true
                    };
                }

                var thisSwiper = new Swiper($this, swiperOptions);
                $this.addClass(\'slider-ready\');

            });
            </script>';
        }

    }
}
