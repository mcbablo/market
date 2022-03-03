<?php
/**
 * Add widget banner packery to elementor
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

class Kalles_Elementor_Banner_Packery_Widget extends Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'the4_banner_packery';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Banner Packery', 'kalles' );
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
                ]
            ]
        );


        $repeater->add_control(
            'heading_color',
            [
                'label'   => esc_html__( 'Text color', 'kalles' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '',
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
                ]
            ]
        );

        $repeater->add_control(
            'subheading_color',
            [
                'label'   => esc_html__( 'Text color', 'kalles' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '',
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

        $repeater->add_control(
            'content',
            [
                'type'    => Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

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
            )
        );
        $repeater->add_control( 'button_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
            )
        );

        $repeater->add_control( 'button_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
            )
        );

        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        //End Content text
        
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
                        'button_text' => 'Banner #1',
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
                        'button_text' => 'Banner #2',
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
                        'button_text' => 'Banner #3',
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
                        'button_text' => 'Banner #4',
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

        $this->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__( 'Layout', 'kalles' ),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $this->add_control(
            'hoverz',
            [
                'label'   => esc_html__( 'Enable zoom image on hover?', 'kalles' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'banner_space',
            [
                'label'       => esc_html__( 'Space between Collections', 'kalles' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '30',
                'options'     => array(
                    '0'            => esc_html__( 'Space 0', 'kalles' ),
                    '2'           => esc_html__( 'Space 2', 'kalles' ),
                    '6'           => esc_html__( 'Space 6', 'kalles' ),
                    '10'           => esc_html__( 'Space 10', 'kalles' ),
                    '20'           => esc_html__( 'Space 20', 'kalles' ),
                    '30'           => esc_html__( 'Space 30', 'kalles' ),
                ),
            ]
        );

        $this->add_control(
            'banner_layout_4',
            [
                'label'       => esc_html__( '4 blocks banner layout', 'kalles' ),
                'description' => esc_html__( 'Select layout of 4 banners.', 'kalles' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '1',
                'options'     => array(
                    '1'            => esc_html__( 'Layout 1', 'kalles' ),
                    '2'           => esc_html__( 'Layout 2', 'kalles' ),
                    '3'           => esc_html__( 'Layout 3', 'kalles' ),
                    '4'           => esc_html__( 'Layout 4', 'kalles' ),
                ),
            ]
        );

        $this->add_control(
            'banner_layout_5',
            [
                'label'       => esc_html__( '5 blocks banner layout', 'kalles' ),
                'description' => esc_html__( 'Select layout of 5 banners.', 'kalles' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '3',
                'options'     => array(
                    '1'            => esc_html__( 'Layout 1', 'kalles' ),
                    '2'           => esc_html__( 'Layout 2', 'kalles' ),
                    '3'           => esc_html__( 'Layout 3', 'kalles' ),
                    '4'           => esc_html__( 'Layout 4', 'kalles' ),
                    '5'           => esc_html__( 'Layout 5', 'kalles' ),
                ),
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

        $this->display_content();
        if ( is_admin() ){
            
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
    public function display_content()
    {
        $settings = $this->get_settings_for_display();

        if ( isset( $settings['items'] ) ) :

            $size = count( $settings[ 'items' ] );
            $items = $settings['items'];
            $hoverz = $settings['hoverz'] == 'yes' ? 'true' : 'false';

            if ( $size > 0 ) :

            $for_i = $ccol = '';
        ?>
            <div class="mt__30 nt_cats_holder banner_packery_section row equal_nt hoverz_<?php echo esc_attr( $hoverz ); ?> cat_size_<?php echo esc_attr( $size ); ?> cat_grid_<?php echo esc_attr( $size  . '_' . $settings['banner_layout_4'] ); ?> cat_space_<?php echo esc_attr( $settings['banner_space'] ); ?>">
                <?php 
                    switch ( $size ) {
                        case 1:

                             $this->set_display_args( 
                                $items[0], 
                                1, 
                                'col-12', 
                                'https://placehold.jp/100/f76b6a/fff/1170x600.png?text=1170x600',
                                '',
                                '',
                                1170,
                                600
                            );
                            break;
                        
                        case 2:

                            $this->set_display_args( 
                                $items[0], 
                                1, 
                                'col-md-6 col-12', 
                                'https://placehold.jp/50/56cfe1/fff/570x300.png?text=570x300',
                                '',
                                '',
                                570,
                                300
                            );
                           

                            $this->set_display_args( 
                                $items[1], 
                                2, 
                                'col-md-6 col-12',
                                'https://placehold.jp/50/a8dacc/fff/570x300.png?text=570x300',
                                '',
                                '',
                                570,
                                300
                            );

                            break;

                        case 3:

                            $this->set_display_args( 
                                $items[0], 
                                1, 
                                'col-md-6 col-12', 
                                'https://placehold.jp/50/56cfe1/fff/570x630.png?text=570x630',
                                '',
                                '',
                                570,
                                630
                            );
                           

                            $this->set_display_args( 
                                $items[1], 
                                2, 
                                'col-12',
                                'https://placehold.jp/50/a8dacc/fff/570x300.png?text=570x300',
                                '<div class="col-lg-6 col-md-6 col-12"><div class="row">',
                                '',
                                570,
                                300
                            );

                            $this->set_display_args( 
                                $items[2], 
                                3, 
                                'col-12',
                                'https://placehold.jp/50/a8dacc/fff/570x300.png?text=570x300',
                                null,
                                '</div></div>',
                                570,
                                300
                            );

                            break;

                        case 4:

                            $this->display_4_banners( $settings['banner_layout_4'], $items );

                            break;

                        case 5 : 

                            $this->display_5_banners( $settings['banner_layout_5'], $items );

                            break;

                        case 6 : 

                            $this->display_6_banners( $items );

                            break;

                        case 7 : 

                            $this->display_7_banners( $items );

                            break;
                    }
                ?>
            </div>
        <?php
            endif;
        endif;
    }

    /**
     * Set attributes display for each banner
     *
     *
     * @since 1.0.0
     * @access public
     */
    public function set_display_args( $item, $for_i, $ccol, $cimg, $html_before = null, $html_after = null, $width = 0, $height = 0 )
    {
        $padding_cal = 0;

        if ( $width != 0 && $height != 0 ) {
            $padding_cal = ( 1 / ( $width / $height ) ) * 100;

        }

        //Custom style
        $content_horizontal = $content_vertical = $heading_space = $heading_style = $heading_space = $heading_color =  '';
        $subheading_space = $subheading_style  = $subheading_color = '';
        $padding = isset ( $padding_cal ) ? 'style="padding-top: ' . $padding_cal . '%;"' : '';

        if ( isset( $item['content_horizontal'] ) && ! empty( $item['content_horizontal'] ) ) {
            if ( $item['content_horizontal'] == 'left' ) {
                $content_horizontal = 'style="margin-right: auto;"';
            } elseif ( $item['content_horizontal'] == 'center' ) {
                $content_horizontal = 'style="margin: 0 auto"';
            }
            elseif ( $item['content_horizontal'] == 'right' ) {
                $content_horizontal = 'style="margin-left: auto"';
            }
        }

        if ( isset( $item['content_vertical'] )  && ! empty( $item['content_vertical'] ) ) {
            if ( $item['content_vertical'] == 'top' ) {
                $content_vertical = 'style="align-items: flex-start;"';
            } elseif ( $item['content_vertical'] == 'middle' ) {
                $content_vertical = 'style="align-items: center;"';
            }
            elseif ( $item['content_vertical'] == 'bottom' ) {
                $content_vertical = 'style="align-items: flex-end;"';
            }
        }

        //Heading style
        
        if ( isset( $item['heading_space'] )  && ! empty( $item['heading_space']['size'] ) ) {
            $heading_space = 'margin-bottom:'. $item['heading_space']['size'] . $item['heading_space']['unit'] .';';
        }
        if ( isset( $item['heading_color'] ) && ! empty( $item['heading_color'] ) ) {
            $heading_color = 'color: ' . $item['heading_color'] . ';';
        }
        if ( ! empty( $heading_color ) || ! empty( $heading_space ) ) {
            $heading_style = 'style=" ' . $heading_space . $heading_color .'"';
        }

        //Subheading style
        
        if ( isset( $item['subheading_space'] ) && ! empty( $item['subheading_space']['size'] ) ) {
            $subheading_space = 'margin-bottom:'. $item['subheading_space']['size'] . $item['subheading_space']['unit'] .';';
        }
        if ( isset( $item['subheading_color'] ) && ! empty( $item['subheading_color'] ) ) {
            $subheading_color = 'color: ' . $item['subheading_color'] . ';';
        }
        if ( ! empty( $subheading_color ) || ! empty( $subheading_space ) ) {
            $subheading_style = 'style=" ' . $subheading_space . $subheading_color .'"';
        }

        //button style
        $button_color = $button_border_color = $button_bg_color = $button_style = '';

        if ( isset( $item['button_color'] ) && ! empty( $item['button_color'] ) ) {
            $button_color = 'style="color: '. $item['button_color'] . ';"';
        }
        if ( isset( $item['button_border_color'] ) && ! empty( $item['button_border_color'] ) ) {
            $button_border_color = 'border-color: '. $item['button_border_color'] . ';';
        }
        if ( isset( $item['button_bg_color'] ) && ! empty( $item['button_bg_color'] ) ) {
            $button_bg_color = 'background-color: '. $item['button_bg_color'] . ';';
        }

        if ( ! empty( $button_border_color ) || ! empty( $button_bg_color ) ) {
            $button_style = 'style=" ' . $button_border_color . $button_bg_color .'"';
        }

        //End Style

        if ( $html_before ) {
            echo $html_before;
        } 
        ?>

        <div class="banner_hzoom nt_promotion oh pr cat_grid_item cat_space_item cat_grid_item_<?php echo esc_attr( $for_i . ' ' . $ccol ); ?>">
            <?php if ( !empty( $item['image_link']['url'] ) ) : ?>
            <a href="<?php echo esc_url( $item['image_link']['url'] ); ?>" class="image_link">
                <?php endif; ?>

                <?php
                echo '<div class="banner-packery-img-wrapper pr ' . kalles_image_lazyload_class() . ' " ' . $padding . '>';
                    if ( ! empty( $item['image']['id'] ) ) {
                        echo wp_get_attachment_image( $item['image']['id'], 'full', [ 'class' => 'w__100'] );
                    } else {
                        echo '<img alt="Banner" class="w__100 nt_bg_lz pr_lazy_img lazyload item__position " src="' . $cimg . '" />';

                    }
                ?>
                </div>
                <?php if ( !empty( $item['image_link']['url'] ) ) : ?>
            </a>
        <?php endif; ?>
            <?php if ( 'yes' === $item['background_overlay'] ) { ?>
                <div class="bg-overlay"></div>
            <?php  } ?>

            <div class="nt_promotion_html pa t__0 l__0 r__0 b__0 flex w__100 pa_txts pe_none z_100" <?php echo $content_vertical; ?>>
                <div class="wrap_html_block" <?php echo $content_horizontal ?>>
                    <?php
                    if ( ! empty( $item['subheading'] ) ) {

                        echo '<h3 class="sub-title-banner" '. $subheading_style . '>' . $item['subheading'] . '</h3>';
                    }
                    if ( ! empty( $item['heading'] ) ) {

                        echo '<h3 class="title-banner slt4_h3" ' . $heading_style . '>' . $item['heading'] . '</h3>';
                    }

                    if ( ! empty( $item['content'] ) ) {
                        echo '<p class="content-banner slt4_p mg__0" >' . $item['content'] . '</p>';
                    }

                    if ( ! empty( $item['button_link']['url'] ) ) {
                        $target = $item['button_link']['is_external'] == 'on' ? 'target="_blank"' : '';
                        echo '<a class="btn-link slt4_btn pe_auto button-' . $item['button_type'] . '" href="' . $item['button_link']['url'] .'"'. $target . $button_style . '><span ' . $button_color . '>' . $item['button_text'] .'</span></a>';
                    }
                    ?>
                </div> <!-- wrap_html_block -->
            </div> <!-- nt_promotion_html -->
        </div> <!-- banner_hzoom -->
        <?php if ( $html_after ) {
            echo $html_after;
        } 
    }

    /**
     * Custom layout 4 banners
     *
     *
     * @since 1.0.0
     * @access public
     */
    
    public function display_4_banners( $cat_layout_4, $items )
    {
        switch ( $cat_layout_4 ) {
            case 1:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-md-6 col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x630.png?text=570x630',
                    '',
                    '',
                    570,
                    630
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-12', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-6"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-12', 
                    'https://placehold.jp/30/f4a896/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-md-3 col-6', 
                    'https://placehold.jp/30/c8b09b/fff/270x630.png?text=270x630',
                    '',
                    '',
                    270,
                    630
                );

                break;

            case 2:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x505.png?text=570x505',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    505
                );

                $this->set_display_args( 
                    $items[1], 
                    3, 
                    'col-12', 
                    'https://placehold.jp/30/a6d7cb/fff/570x315.png?text=570x315',
                    '',
                    '</div></div>',
                    570,
                    315
                );

                $this->set_display_args( 
                    $items[2], 
                    2, 
                    'col-12', 
                    'https://placehold.jp/30/f4a896/fff/570x410.png?text=570x410',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    410
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-12', 
                    'https://placehold.jp/30/c8b09b/fff/570x410.png?text=570x410',
                    '',
                    '</div></div>',
                    570,
                    410
                );

                break;

            case 3:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x570.png?text=570x570',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    570
                );

                $this->set_display_args( 
                    $items[1], 
                    3, 
                    'col-12', 
                    'https://placehold.jp/30/a6d7cb/fff/570x530.png?text=570x530',
                    '',
                    '</div></div>',
                    570,
                    530
                );

                $this->set_display_args( 
                    $items[2], 
                    2, 
                    'col-12', 
                    'https://placehold.jp/30/f4a896/fff/570x530.png?text=570x530',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    530
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-12', 
                    'https://placehold.jp/30/c8b09b/fff/570x570.png?text=570x570',
                    '',
                    '</div></div>',
                    570,
                    570
                );

                break;

            case 4:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-md-6 col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x630.png?text=570x630',
                    '',
                    '',
                    570,
                    630
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '<div class="col-lg-6 col-md-6 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-6', 
                    'https://placehold.jp/30/f4a896/fff/270x300.png?text=270x300',
                    '',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-12', 
                    'https://placehold.jp/30/c8b09b/fff/570x300.png?text=570x300',
                    '',
                    '</div></div>',
                    570,
                    300
                );

                break;
        }
    }

    /**
     * Custom layout 5 banners
     *
     *
     * @since 1.0.0
     * @access public
     */
    
    public function display_5_banners( $cat_layout_5, $items )
    {
        switch ( $cat_layout_5 ) {
            case 1:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/50/56cfe1/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-md-6 col-12', 
                    'https://placehold.jp/30/f4a896/fff/570x630.png?text=570x630',
                    '',
                    '',
                    570,
                    630
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/c8b09b/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[4], 
                    5, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );
                break;

            case 2:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x570.png?text=570x570',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    570
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '<div class="col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[4], 
                    5, 
                    'col-6', 
                    'https://placehold.jp/30/f4a896/fff/270x300.png?text=270x300',
                    '',
                    '</div></div></div></div>',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-12', 
                    'https://placehold.jp/30/c8b09b/fff/570x300.png?text=570x300',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    300
                );

                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-12', 
                    'https://placehold.jp/30/a6d7cb/fff/570x570.png?text=570x570',
                    '',
                    '</div></div>',
                    570,
                    570
                );

                break;

            case 3:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x570.png?text=570x570',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    570
                );

                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-12', 
                    'https://placehold.jp/30/a6d7cb/fff/570x300.png?text=570x300',
                    '',
                    '</div></div>',
                    570,
                    300
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-12', 
                    'https://placehold.jp/30/f4a896/fff/570x270.png?text=570x270',
                    '<div class="col-md-6 col-12"><div class="row">',
                    '',
                    570,
                    270
                );

                 $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-12', 
                    'https://placehold.jp/30/f4a896/fff/570x300.png?text=570x300',
                    '',
                    '',
                    570,
                    300
                );

                $this->set_display_args( 
                    $items[4], 
                    5, 
                    'col-12', 
                    'https://placehold.jp/30/a6d7cb/fff/570x270.png?text=570x270',
                    '',
                    '</div></div>',
                    570,
                    270
                );

                break;

            case 4:
                
                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-md-6 col-12', 
                    'https://placehold.jp/50/56cfe1/fff/570x630.png?text=570x630',
                    '',
                    '',
                    570,
                    630
                );

                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/f4a896/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );

                  $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[4], 
                    5, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/f4a896/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );

                break;

            case 5:
                
                $this->set_display_args( 
                    $items[0], 
                    1, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/50/56cfe1/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[1], 
                    2, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[3], 
                    4, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/50/56cfe1/fff/270x300.png?text=270x300',
                    '<div class="col-lg-3 col-md-3 col-12"><div class="row">',
                    '',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[4], 
                    5, 
                    'col-md-12 col-6', 
                    'https://placehold.jp/30/a6d7cb/fff/270x300.png?text=270x300',
                    '',
                    '</div></div>',
                    270,
                    300
                );

                $this->set_display_args( 
                    $items[2], 
                    3, 
                    'col-md-6 col-12', 
                    'https://placehold.jp/30/f4a896/fff/570x630.png?text=570x630',
                    '',
                    '',
                    570,
                    630
                );

                break;
        }
    }

    /**
     * Custom layout 6 banners
     *
     *
     * @since 1.0.0
     * @access public
     */

    public function display_6_banners( $items )
    {
        $this->set_display_args( 
            $items[0], 
            1, 
            'col-md-3 col-6', 
            'https://placehold.jp/50/56cfe1/fff/270x300.png?text=270x300',
            '<div class="col-12"><div class="row">',
            '',
            270,
            300
        );

        $this->set_display_args( 
            $items[1], 
            2, 
            'col-md-3 col-6', 
            'https://placehold.jp/50/a6d7cb/fff/270x300.png?text=270x300',
            '',
            '',
            270,
            300
        );

        $this->set_display_args( 
            $items[2], 
            3, 
            'col-md-6 col-12', 
            'https://placehold.jp/50/f4a896/fff/570x300.png?text=570x300',
            '',
            '</div></div>',
            570,
            300
        );

        $this->set_display_args( 
            $items[3], 
            4, 
            'col-md-6 col-12', 
            'https://placehold.jp/50/c8b09b/fff/570x300.png?text=570x300',
            '<div class="col-12"><div class="row">',
            '',
            570,
            300
        );

        $this->set_display_args( 
            $items[4], 
            5, 
            'col-md-3 col-6', 
            'https://placehold.jp/50/efe1ba/fff/270x300.png?text=270x300',
            '',
            '',
            270,
            300
        );

        $this->set_display_args( 
            $items[5], 
            6, 
            'col-md-3 col-6', 
            'https://placehold.jp/50/a5d0d9/fff/270x300.png?text=270x300',
            '',
            '</div></div>',
            270,
            300
        );
    }

    /**
     * Custom layout 7 banners
     *
     *
     * @since 1.0.0
     * @access public
     */

    public function display_7_banners( $items )
    {
        $this->set_display_args( 
            $items[0], 
            1, 
            'col-12', 
            'https://placehold.jp/50/56cfe1/fff/540x540.png?text=540x540',
            '<div class="col-md-3 col-6"><div class="row">',
            '',
            540,
            540
        );

        $this->set_display_args( 
            $items[1], 
            2, 
            'col-12', 
            'https://placehold.jp/50/a6d7cb/fff/540x540.png?text=540x540',
            '',
            '</div></div>',
            540,
            540
        );

        $this->set_display_args( 
            $items[2], 
            5, 
            'col-12', 
            'https://placehold.jp/50/f4a896/fff/540x540.png?text=540x540',
            '<div class="col-md-3 col-6"><div class="row">',
            '',
            '',
            540,
            540
        );

        $this->set_display_args( 
            $items[3], 
            4, 
            'col-12', 
            'https://placehold.jp/50/efe1ba/fff/540x540.png?text=540x540',
            '',
            '</div></div>',
            540,
            540
        );

        $this->set_display_args( 
            $items[4], 
            3, 
            'col-md-3 col-6', 
            'https://placehold.jp/50/c8b09b/fff/379x800.png?text=379x800',
            '',
            '',
            379,
            800
        );

        $this->set_display_args( 
            $items[5], 
            6, 
            'col-12', 
            'https://placehold.jp/50/56cfe1/fff/540x540.png?text=540x540',
            '<div class="col-md-3 col-6"><div class="row">',
            '',
            540,
            540
        );

        $this->set_display_args( 
            $items[6], 
            7, 
            'col-12', 
            'https://placehold.jp/50/a6d7cb/fff/540x540.png?text=540x540',
            '',
            '</div></div>',
            540,
            540
        );
    }
}
