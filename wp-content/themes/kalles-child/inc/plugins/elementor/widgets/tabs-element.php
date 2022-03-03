<?php

if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
    return false;
}

use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Controls_Stack;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class Kalles_Elementor_Tabs_Elements extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'tabs-element';
    }

    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Tabs Element', 'kalles' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-slideshow';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'kalles-elements' ];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since  2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'image', 'slide', 'slideshow', 'carousel', 'categories', 'product', 'products', 'tab' ];
    }

    /**
     * Register image box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $max_tabs           = 7;
        $max_imgs_per_slide = 4;

        $tab_options = array();
        for ( $i = 1; $i <= $max_tabs; $i ++ ) {
            $tab_options[ 'total_tab_' . $i ] = $i == 1 ? esc_html__( '1 Tab', 'kalles' ) : sprintf( esc_html__( '%d Tabs', 'kalles' ), $i );
        }

        $this->start_controls_section( 'section_general', [
            'label' => esc_html__( 'General', 'kalles' ),
        ] );

        $this->add_control( 'number_of_tabs', [
            'label'   => esc_html__( 'Number Of Tabs', 'kalles' ),
            'type'    => Controls_Manager::SELECT,
            'options' => $tab_options,
            'default' => 'total_tab_3',
        ] );

        $this->end_controls_section();

        for ( $i = 1; $i <= $max_tabs; $i ++ ) {
            $section_id    = "section_tab_{$i}";
            $section_label = sprintf( esc_html__( 'Tab %d', 'kalles' ), $i );

            $controls_args = [
                'label' => $section_label
            ];
            $condition     = array( 'number_of_tabs' => array() );
            for ( $k = $i; $k <= $max_tabs; $k ++ ) {
                array_push( $condition['number_of_tabs'], 'total_tab_' . $k );
            }

            $controls_args['condition'] = $condition;

            // Tab section $i -----------
            $this->start_controls_section( $section_id, $controls_args );

            $banner_id = "banner_{$i}";
            $control_title_id = "tab_title_{$i}";
            $banner_colunms_id = "banner_colunms_{$i}";
            $this->add_control( $control_title_id, [
                'label'       => esc_html__( 'Tab Title', 'kalles' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => sprintf( esc_html__( 'This is the tab title %s', 'kalles' ), $i ),
                'placeholder' => esc_html__( 'Enter the tab title', 'kalles' ),
                'label_block' => true,
            ] );

            $this->add_responsive_control(
                $banner_colunms_id,
                [
                    'label'   => esc_html__( 'Banner Colunms', 'kalles' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
                        '12' => '1 Colunm',
                        '6'  => '2 Colunm',
                        '4'  => '3 Colunm',
                        '3'  => '4 Colunm',
                        '15'  => '5 Colunm',
                        '2'  => '6 Colunm',
                    ],
                    'default' => '4',
                ]
            );

            $repeater = new Repeater();

            //Image
            $repeater->add_control(
                'item_slide',
                [
                    'label'   => esc_html__( 'Banner Wrapper', 'kalles' ),
                    'type'    => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $repeater->start_controls_tabs('banner-item');
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
                        '{{WRAPPER}} {{CURRENT_ITEM}} .image-item' => 'background-image: url({{URL}})',
                    ],
                ]
            );

            $repeater->add_control(
                'link_img',
                array(
                    'label'       => esc_html__( 'Link', 'kalles' ),
                    'type'        => Controls_Manager::URL,

                    'dynamic'     => array(
                        'active' => true,
                    ),
                    'placeholder' => esc_html__( 'https://th4.co', 'kalles' ),
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
            $repeater->end_controls_tabs();
            $repeater->add_control(
                'title_text',
                [
                    'label'   => esc_html__( 'Title', 'kalles' ),
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

            $this->add_control(
                'banner_'. $i .'',
                [
                    'type'        => Controls_Manager::REPEATER,
                    'show_label'  => true,
                    'fields'      => $repeater->get_controls(),
                    'default'     => [
                        [
                            'heading'          => esc_html__( 'Tab 1 ', 'kalles' ),
                            'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                            'button_text'      => esc_html__( 'Click Here', 'kalles' ),
                            'background_color' => '#833ca3',
                        ],
                        [
                            'heading'          => esc_html__( 'Tab 2', 'kalles' ),
                            'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                            'button_text'      => esc_html__( 'Click Here', 'kalles' ),
                            'background_color' => '#4054b2',
                        ],
                        [
                            'heading'          => esc_html__( 'Tab 3', 'kalles' ),
                            'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                            'button_text'      => esc_html__( 'Click Here', 'kalles' ),
                            'background_color' => '#1abc9c',
                        ],
                    ],
                    'title_field' => '{{{ heading }}}',
                ]
            );

            $this->end_controls_section();
            // End tab section $i -----------

        }

    }

    public function the4_shortcode_tabs_element(){
        $settings      = $this->get_settings_for_display();
        $heading       = isset( $settings['heading'] ) ? trim( $settings['heading'] ) : '';

        $number_of_tabs = isset( $settings['number_of_tabs'] ) ? trim( $settings['number_of_tabs'] ) : 'total_tab_3';
        $number_of_tabs = intval( str_replace( 'total_tab_', '', $number_of_tabs ) );
        if ( $number_of_tabs <= 0 ) {
            $number_of_tabs = 1;
        }

        $max_tabs = 5;
        $html              = '';
        $tab_contents_html = '';
        $tab_head_html     = '';
        $heading_button    = '';

        // Tab contents
        if ( $number_of_tabs > $max_tabs ) {
            $number_of_tabs = $max_tabs;
        }

        $active_tab = 1;
        for ( $t = 1; $t <= $number_of_tabs; $t ++ ) {
            $tab_id = uniqid( 'the4-tab-id-' );
            $this_tab_title        = $settings["tab_title_{$t}"];
            $colum_number          = $settings["banner_colunms_{$t}"];
            $colum_number_tablet   = $settings["banner_colunms_{$t}_tablet"];
            $colum_number_mobile   = $settings["banner_colunms_{$t}_mobile"];
            $tab_title_class       = $t == $active_tab ? 'active' : '';
            $tab_content_class     = $t == $active_tab ? 'active' : '';
            $this_tab_heading_html = '<li data-tab-id="' . esc_attr( $tab_id ) . '" class="tab-title-li ' . esc_attr( $tab_title_class ) . '">' . sanitize_text_field( $this_tab_title ) . '</li>';

            $this_tab_content_html = '';

            if (empty($settings["banner_{$t}"])) {
                return;
            }
            $banners = [];
            $banner_count = 0;
            foreach ($settings["banner_{$t}"] as $banner) {
                $banner_html = '';
                $image_html = '';
                $link = $banner['link_img'];
                $link_target = $banner['link_img']['is_external'];
                $link_rel = $banner['link_img']['nofollow'];
                //Place holder image
                $placeholder = ($banner % 2 == 0) ? 'a8dacc' : 'f76b6a';
                if (!empty($banner['background_image']['id']) && $link ) {
                    $image_html .= '<div class="image-item"><a href="' . esc_attr( $link['url'] ) . '" target="_blank">' . wp_get_attachment_image($banner['background_image']['id'], 'full', ['class' => 'w__100']) . '</a></div>';
                } else {
                    $image_html .= '<div  class="image-item"><img class="nt_bg_lz pr_lazy_img lazyload item__position "
                                    src="https://placehold.jp/50/' . $placeholder . '/' . $placeholder . '/530x600.png?text=1"  data-srcset="https://placehold.jp/50/' . $placeholder . '/' . $placeholder . '/530x600.png?text=1" /></div>';
                }

                if ($banner['heading'] && $link) {
                    $banner_html .= '<div class="banner-heading"><a href="' . esc_attr( $link['url'] ) . '" target="_blank">' . $banner['heading'] . '</a></div>';
                }else if ($banner['heading']) {
                    $banner_html .= '<div class="banner-heading">' . $banner['heading'] . '</div>';
                }
                $banners[] = '<div class="elementor-repeater-item-' . $banner['_id'] . ' col-lg-' . $colum_number .' col-md-' . $colum_number_tablet .' col-' .$colum_number_mobile .' banner-item">
                                <div class="top-content">
                                    <div class="top-bar">
                                        <div class="circles">
                                            <div class="circle circle-1"></div>
                                            <div class="circle circle-2"></div>
                                            <div class="circle circle-3"></div>
                                        </div>
                                    </div>
                                    ' . $image_html . '
                                </div>
                                ' . $banner_html .'
                              </div>';
                $banner_count++;
            }
            $this_tab_content_html .='<div data-tab-id="' . esc_attr( $tab_id ) . '" class="the4-banner-wrap ' . esc_attr( $tab_content_class ) . '"><div class="banner-inner row">'. implode('', $banners) .'</div></div>';

            $tab_head_html     .= $this_tab_heading_html;
            $tab_contents_html .= $this_tab_content_html;
        }



        if ( $tab_head_html != '' ) {
            $tab_head_html = '<ul class="tab-heading-list">' . $tab_head_html . '</ul>';
        }

        $tab_head_html     = '<div class="the4-tab-head tab-head">' .  $tab_head_html . '</div>';
        $tab_contents_html = '<div class="the4-tab-contents tab-contents">' . $tab_contents_html . '</div>';

        $html = '<div class="the4-tabs-element">' .$tab_head_html . $tab_contents_html .'</div>';

        echo wp_kses_post( $html );
    }

    protected function render() {
        $this->the4_shortcode_tabs_element(); 
    }


}
