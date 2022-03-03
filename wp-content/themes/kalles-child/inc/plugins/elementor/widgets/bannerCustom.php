<?php
/**
 * Add widget banner custom to elementor
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

class Kalles_Elementor_Banner_Custom_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'the4_banner_custom';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Banner Custom', 'kalles' );
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
            'content_section',
            [
                'label' => esc_html__( 'Content', 'kalles' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        //Image
        $repeater->add_control(
            'heading_image',
            [
                'label'   => esc_html__( '== Image', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs(
            'banner_custom_image'
        );

        $repeater->start_controls_tab(
            'image_tab',
            [
                'label' => esc_html__( 'Image', 'kalles' )
            ]
        );

        $repeater->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'image_link_tab',
            [
                'label' => esc_html__( 'Link image', 'kalles' )
            ]
        );

        $repeater->add_control(
            'image_link',
            [
                'type' => Controls_Manager::URL,
                'default'     => [
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ]
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
                    '{{WRAPPER}} {{CURRENT_ITEM}} .bg-overlay' => 'background-color: {{VALUE}}',
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
            'image_layout_tab',
            [
                'label' => esc_html__( 'Layout', 'kalles' )
            ]
        );

        $repeater->add_responsive_control(
            'image_width',
            [
                'label'   => esc_html__( 'Banner width', 'kalles' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    '12' => '100%',
                    '8'  => '66.6%',
                    '7'  => '58.3%',
                    '6'  => '50%',
                    '5'  => '41.6%',
                    '4'  => '33.3%',
                    '3'  => '25%',
                    '15' => '20%',
                    '2'  => '16.6%',
                ],
                'default' => '6'
            ]
        );

        $repeater->add_responsive_control(
            'content_align',
            [
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
                'selectors'   => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .nt_promotion_html' => 'text-align: {{VALUE}}',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__( 'Padding', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(

                ),
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .nt_promotion_html' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'content_horizontal',
            [
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
                'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .nt_promotion_html .wrap_html_block' => '{{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'left'   => 'margin-right: auto',
                    'center' => 'margin: 0 auto',
                    'right'  => 'margin-left: auto',
                ]
            ]
        );

        $repeater->add_control(
            'content_vertical',
            [
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
                'selectors'            => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .nt_promotion_html' => 'align-items: {{VALUE}}',
                ],
                'selectors_dictionary' => [
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ]
            ]
        );
        $repeater->end_controls_tab();


        $repeater->end_controls_tabs();

        //Heading
        $repeater->add_control(
            'heading_title',
            [
                'label'   => esc_html__( '==  Heading', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs('banner_custom_heading');

        $repeater->start_controls_tab(
            'heading_tab',
            [
                'label' => esc_html__( 'Heading text', 'kalles' )
            ]
        );

        $repeater->add_control(
            'heading',
            [
                'type'    => Controls_Manager::TEXTAREA,
                'default' => 'Heading Banner.',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'heading_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );

        $repeater->add_control(
            'heading_space',
            [
                'label'   => esc_html__( 'Space', 'kalles' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .title-banner' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'   => esc_html__( 'Typography', 'kalles' ),
                'name'    => 'heading_size',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .title-banner',
            ]
        );

        $repeater->add_control(
            'heading_color',
            [
                'label'   => esc_html__( 'Text color', 'kalles' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .title-banner' => 'color: {{VALUE}}',

                ],
            ]
        );

        $repeater->end_controls_tab();


        $repeater->end_controls_tabs();

        //Sub Heading
        $repeater->add_control(
            'subheading_title',
            [
                'label'   => esc_html__( '==  Sub heading', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs('banner_custom_subheading');

        $repeater->start_controls_tab(
            'subheading_tab',
            [
                'label' => esc_html__( 'Sub heading text', 'kalles' )
            ]
        );

        $repeater->add_control(
            'subheading',
            [
                'type'    => Controls_Manager::TEXTAREA,
                'default' => 'Sub banner',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'subheading_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );

        $repeater->add_control(
            'subheading_space',
            [
                'label'   => esc_html__( 'Space', 'kalles' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .sub-title-banner' => 'margin-bottom: {{SIZE}}{{UNIT}}',

                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'   => esc_html__( 'Typography', 'kalles' ),
                'name'    => 'subheading_size',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .sub-title-banner ',

                ],
            ]
        );

        $repeater->add_control(
            'subheading_color',
            [
                'label'   => esc_html__( 'Text color', 'kalles' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .sub-title-banner' => 'color: {{VALUE}}',

                ],
            ]
        );

        $repeater->end_controls_tab();


        $repeater->end_controls_tabs();

        //End SubHeading
        //
        //Content text
        $repeater->add_control(
            'content_title',
            [
                'label'   => esc_html__( '== Content', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->start_controls_tabs('banner_custom_content');

        $repeater->start_controls_tab(
            'content_tab',
            [
                'label' => esc_html__( 'Content text', 'kalles' )
            ]
        );

        $repeater->add_control(
            'content',
            [
                'type'    => Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'content_style_tab',
            [
                'label' => esc_html__( 'Style', 'kalles' )
            ]
        );

        $repeater->add_control(
            'content_space',
            [
                'label'   => esc_html__( 'Space', 'kalles' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],

                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .content-banner' => 'margin-bottom: {{SIZE}}{{UNIT}}',

                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'   => esc_html__( 'Typography', 'kalles' ),
                'name'    => 'content_size',
                'scheme' => Typography::TYPOGRAPHY_1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .content-banner',

                ],
            ]
        );

        $repeater->add_control(
            'content_color',
            [
                'label'   => esc_html__( 'Content color', 'kalles' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .content-banner' => 'color: {{VALUE}}',

                ],
            ]
        );

        $repeater->end_controls_tab();


        $repeater->end_controls_tabs();

        //End Content text
        //
        //Button
        $repeater->add_control(
            'button_title',
            [
                'label'   => esc_html__( '== Button', 'kalles' ),
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
                'type'    => Controls_Manager::TEXT,
                'label'   => esc_html__( 'Text', 'kalles' ),
                'default' => 'Shop Now',
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'type'    => Controls_Manager::URL,
                'label'   => esc_html__( 'Link', 'kalles' ),
                'default'     => [
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            'style_button',
            [
                'label' => esc_html__( 'Sltyle', 'kalles' )
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
        //End Content text
        $repeater->add_control(
            'style_inner_content_heading',
            [
                'label'   => esc_html__( '== Enable Style Inner Content', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'style_inner_content',
            array(
                'label' => esc_html__( 'Enable Style Inner Content?', 'kalles' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'No', 'kalles' ),
                'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => 'no',
            )
        );
        $repeater->add_control( 'inner_content_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .wrap_html_block' => 'background-color: {{VALUE}}',
                ),
                'condition'   => array(
                    'style_inner_content' => 'yes',
                ),
            )
        );
        $repeater->add_control( 'inner_content_bd_color',
            array(
                'label'     => esc_html__( 'Border Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .wrap_html_block::before' => 'border-color: {{VALUE}}',
                ),
                'condition'   => array(
                    'style_inner_content' => 'yes',
                ),
            )
        );
        $repeater->add_responsive_control(
            'inner_content_padding',
            array(
                'label'      => esc_html__( 'Padding', 'kalles' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} {{CURRENT_ITEM}} .wrap_html_block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition'   => array(
                    'style_inner_content' => 'yes',
                ),
            )
        );
        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'image' => '',
                        'image_link' => [
                            'url'         => '#',
                            'is_external' => false,
                            'nofollow'    => false
                        ],
                        'heading' => 'Heading banner',
                        'subheading' => 'Sub banner',
                        'button_text' => 'Shop now',
                        'button_link' => [
                            'url'         => '#',
                            'is_external' => false,
                            'nofollow'    => false
                        ],
                    ],
                    [
                        'image' => '',
                        'image_link' => [
                            'url'         => '#',
                            'is_external' => false,
                            'nofollow'    => false
                        ],
                        'heading' => 'Heading banner',
                        'subheading' => 'Sub banner',
                        'button_text' => 'Shop now',
                        'button_link' => [
                            'url'         => '#',
                            'is_external' => false,
                            'nofollow'    => false
                        ],
                    ]
                ],
                'title_field' => 'Banner',
            ]
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

        $args_row .= !empty($settings['image']['id']) ? ' image_id="'.esc_attr($settings['image']['id']).'"' : '';

        $args_row .= $settings['text'] ? ' text="'.esc_html($settings['text']).'"' : '';

        $args_row .= $settings['link']['url'] ? ' link_url="'.esc_url($settings['link']['url']).'"' : '';

        $args_row .= $settings['link']['is_external'] ? ' link_target="_blank"' : '';

        $args_row .= $settings['link']['nofollow'] ? ' link_rel="nofollow"' : '';

        //////////////////
        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

        return '[kalles_addons_banner'.$args_row.']';

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        $this->kalles_shortcode_banner_custom();
        if ( is_admin() ){
            echo '
         <script>
          var el = jQuery( ".js_packery" );
			el.each( function( i, val ) {
				var option = jQuery( this ).attr("data-packery") || \'{}\';
	            jQuery( this ).packery(JSON.parse(option));
			});
         </script>';
        }
    }

    /**
     * Render widget as plain content.
     *
     * Override the default behavior by printing the shortcode instead of rendering it.
     *
     * @since 1.0.0
     * @access public
     */

    public function kalles_shortcode_banner_custom()
    {
        $settings = $this->get_settings_for_display();

        ?>
        <div class="kalles-elementor-section kalles-banner-custom-section mt__20 fl_center js_packery the4-row"
             data-packery='{ "itemSelector": ".cat_space_item","gutter": 0,"percentPosition": true,"originLeft": true}'>
        <div class="grid-sizer"></div>

        <?php foreach ($settings['items'] as $index => $item) : ?>
        <?php

        //Place holder image
        $placeholder = ( $index % 2 == 0 ) ? 'a8dacc' : 'f76b6a';

        if ( ! isset( $item['image_width_tablet'] ) ) {
            $item['image_width_tablet'] = $item['image_width'];
        }
        if ( ! isset( $item['image_width_mobile'] ) ) {
            $item['image_width_mobile'] = $item['image_width'];
        }
        
        echo '<div class="cat_space_item col-lg-'. $item['image_width'] .' col-md-'. $item['image_width_tablet'] .' col-'. $item['image_width_mobile'] .' pr_animated done elementor-repeater-item-'. $item['_id'] .'" id="bk_'. $item['_id'] .'">'
        ?>
        <div class="banner_hzoom nt_promotion oh pr <?php echo kalles_image_lazyload_class(); ?>">
            <?php if ( !empty( $item['image_link']['url'] ) ) : ?>
            <a href="<?php echo esc_url( $item['image_link']['url'] ); ?>" class="image_link">
                <?php endif; ?>

                <?php
                if ( ! empty( $item['image']['id'] ) ) {
                    echo wp_get_attachment_image( $item['image']['id'], 'full', [ 'class' => 'w__100'] );
                } else {
                    echo '<img width="530" height="600" class="w__100 nt_bg_lz pr_lazy_img lazyload item__position " src="https://placehold.jp/50/' . $placeholder . '/' . $placeholder . '/530x600.png?text=1"  data-srcset="https://placehold.jp/50/' . $placeholder . '/' . $placeholder . '/530x600.png?text=1" ></img>';

                }
                ?>

                <?php if ( !empty( $item['image_link']['url'] ) ) : ?>
            </a>
        <?php endif; ?>
            <?php if ( 'yes' === $item['background_overlay'] ) { ?>
                <div class="bg-overlay"></div>
            <?php  } ?>

            <div class="nt_promotion_html pa t__0 l__0 r__0 b__0 flex w__100 pa_txts pe_none z_100">
                <div class="wrap_html_block">
                    <?php
                    if ( ! empty( $item['subheading'] ) ) {

                        echo '<h3 class="sub-title-banner">' . $item['subheading'] . '</h3>';
                    }
                    if ( ! empty( $item['heading'] ) ) {

                        echo '<h3 class="title-banner slt4_h3">' . $item['heading'] . '</h3>';
                    }

                    if ( ! empty( $item['content'] ) ) {
                        echo '<p class="content-banner slt4_p mg__0" >' . $item['content'] . '</p>';
                    }

                    if ( ! empty( $item['button_link']['url'] ) ) {
                        $target = $item['button_link']['is_external'] == 'on' ? 'target="_blank"' : '';
                        echo '<a class="btn-link slt4_btn pe_auto button-' . $item['button_type'] . '" href="' . $item['button_link']['url'] .'"
												 '. $target .'><span>' . $item['button_text'] .'</span></a>';
                    }
                    ?>
                </div> <!-- wrap_html_block -->
            </div> <!-- nt_promotion_html -->
        </div> <!-- banner_hzoom -->
        </div> <!-- cat_space_item -->
    <?php endforeach; ?>
        </div> <!-- kalles-elementor-section kalles-banner-custom-section -->

        <?php
    }

}
