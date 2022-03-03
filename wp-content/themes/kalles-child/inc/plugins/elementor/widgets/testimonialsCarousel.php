<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

use Elementor\Utils;

class Kalles_Elementor_Testimonials_Carousel extends \Elementor\Widget_Base {

    public function get_name() {
        return 'testimonials-carousel';
    }

    public function get_title() {
        return esc_html__( 'Testimonial Carousel', 'kalles' );
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_keywords() {
        return [ 'testimonial', 'carousel', 'image'];
    }
    public function get_categories() {
        return [ 'kalles-elements' ];
    }
    protected function _register_controls() {

        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => esc_html__( 'Testimonial', 'kalles' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control( 'rating', [
            'label'   => esc_html__( 'Rating', 'kalles' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 5,
            'step'    => 1,
            'default' => 5
        ] );

        $repeater->add_control( 'content', [
            'label' => esc_html__( 'Content', 'kalles' ),
            'type'  => Controls_Manager::TEXTAREA,
        ] );

        $repeater->add_control( 'image', [
            'label' => esc_html__( 'Image', 'kalles' ),
            'type'  => Controls_Manager::MEDIA,
            'default' => array(
                'url' => Utils::get_placeholder_image_src(),
            ),
        ] );

        $repeater->add_control( 'name', [
            'label'   => esc_html__( 'Author Name', 'kalles' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'Liam Neeson', 'kalles' ),
        ] );

        $repeater->add_control( 'title', [
            'label'   => esc_html__( 'Author Position', 'kalles' ),
            'type'    => Controls_Manager::TEXT,
            'default' => esc_html__( 'CEO', 'kalles' ),
        ] );
        $this->add_control(
            'slides',
            [
                'type'        => Controls_Manager::REPEATER,
                'show_label'  => true,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'heading'     => esc_html__( 'Item 1 ', 'kalles' ),
                        'rating'     => 5,
                        'content'      => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                        'name'         => esc_html__( 'Liam Neeson', 'kalles' ),
                        'title'        => esc_html__( 'CEO', 'kalles' ),
                    ],
                    [
                        'heading'     => esc_html__( 'Item 2 ', 'kalles' ),
                        'rating'     => 5,
                        'content'      => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                        'name'         => esc_html__( 'Liam Neeson', 'kalles' ),
                        'title'        => esc_html__( 'CEO', 'kalles' ),
                    ],
                    [
                        'heading'     => esc_html__( 'Item 3 ', 'kalles' ),
                        'rating'     => 5,
                        'content'      => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'kalles' ),
                        'name'         => esc_html__( 'Liam Neeson', 'kalles' ),
                        'title'        => esc_html__( 'CEO', 'kalles' ),
                    ],
                ],
                'title_field' => '{{{ heading }}}'
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
                'default' => 1,
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
        $this->start_controls_section(
            'section_style',
            array(
                'label' => esc_html__( 'Content Style', 'kalles' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'heading_1',
            [
                'label'   => esc_html__( '== Content Style', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control( 'text_color',
            array(
                'label'     => esc_html__( 'Color Content', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-testimonial__text' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial__text',
                'label'     => esc_html__( 'Content Typography', 'kalles' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );
        $this->add_control(
            'heading_2',
            [
                'label'   => esc_html__( '== Name Style', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'name_color',
            array(
                'label'     => esc_html__( 'Name Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .testimonial__name' => 'color: {{VALUE}}',

                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .testimonial__name',
                'label'     => esc_html__( 'Name Typography', 'kalles' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );
        $this->add_control(
            'heading_3',
            [
                'label'   => esc_html__( '== Position Style', 'kalles' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'position_color',
            array(
                'label'     => esc_html__( 'Position Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .testimonial__title' => 'color: {{VALUE}}',

                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'position_typography',
                'selector' => '{{WRAPPER}} .testimonial__title',
                'label'     => esc_html__( 'Position Typography', 'kalles' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );

        $this->end_controls_section();
    }

    function print_cite( $slide ) {
        if ( empty( $slide['name'] ) && empty( $slide['title'] ) ) {
            return '';
        }
        $html = '';
        $html .= '<span class="testimonial__cite">';
        if ( ! empty( $slide['name'] ) ) {
            $html .= '<span class="testimonial__name">' . $slide['name'] . '</span>';
        }
        if ( ! empty( $slide['title'] ) ) {
            $html .= '<span class="testimonial__title">' . $slide['title'] . '</span>';
        }
        $html .= '</span>';

        return $html;
    }

    protected function print_slide( array $slide, array $settings, $element_key ) {

        $rating         = (float) $slide['rating'];
        $rating         = max( 0, min( 5, $rating ) );
        $textual_rating = $rating / 5;
        $floored_rating = floor( $rating );
        $stars_html     = '';
        $image_html     = '';
        for ( $stars = 1.0; $stars <= 5; $stars ++ ) {
            if ( $stars <= $floored_rating ) {
                $stars_html .= '<i class="t4_icon_star-solid"></i>';
            } elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
                $stars_html .= '<i class="kalles-star-' . ( $rating - $floored_rating ) * 10 . '"></i>';
            } else {
                $stars_html .= '<i class="t4_icon_t4-star1"></i>';
            }
        }

        if ( $slide['rating'] != 0 ) {
            $this->add_render_attribute( 'rating_wrapper', [
                'class'     => 'kalles-star-rating',
                'title'     => $textual_rating,
                'itemtype'  => 'http://schema.org/Rating',
                'itemscope' => '',
                'itemprop'  => 'reviewRating',
            ] );

            $schema_rating = '<span itemprop="ratingValue" class="elementor-screen-only">' . $textual_rating . '</span>';
            $stars_html    = '<div ' . $this->get_render_attribute_string( 'rating_wrapper' ) . '>' . $stars_html . ' ' . $schema_rating . '</div>';
        }

        $this->add_render_attribute( $element_key . '-testimonial', [
            'class' => 'elementor-testimonial',
        ] );
        //Place holder image
        if ( !empty( $slide['image']['id'] ) ) {
            $image_html .='<div class="image-item">'. wp_get_attachment_image( $slide['image']['id'], 'full', [ 'class' => 'w__100'] ) .'</div>';
        }
        ?>
        <div <?php The4Helper::ksesHTML( $this->get_render_attribute_string( $element_key . '-testimonial' ) ); ?>>
            <div class="content-testimonial" >
                <?php The4Helper::ksesHTML( $image_html . $stars_html );
                if ( $slide['content'] ) { ?>
                    <div class="elementor-testimonial__content" >
                        <div class="elementor-testimonial__text" >
                            <?php The4Helper::ksesHTML( $slide['content'] ); ?>
                        </div >
                        <?php The4Helper::ksesHTML( $this->print_cite( $slide) ); ?>
                    </div >
                <?php };
                ?>
            </div >

        </div >
        <?php
    }

    protected function print_slider( array $settings = null ) {

        if ( null === $settings ) {
            $settings = $this->get_active_settings();
        }

        $default_settings = [
            'container_class' => 'kalles-testimonial-wrap kalles-testimonial-carousel-wrapper kalles-swiper-container swiper-container elementor-main-swiper',
            'video_play_icon' => true,
        ];

        $settings = array_merge( $default_settings, $settings );

        $slides_count = count( $settings['slides'] );
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
            'space_between_mobile'    => isset ( $settings['space_between_mobile'] ) ? $settings['space_between_mobile'] : $settings['space_between'],
            'slides_to_scroll'        => $settings['slides_to_scroll'],
            'slides_to_scroll_tablet' => $settings['slides_to_scroll_tablet'],
            'slides_to_scroll_mobile' => $settings['slides_to_scroll_mobile'],
            'autoplay'                => $settings['autoplay'],
            'pause_on_hover'          => $settings['pause_on_hover'],
            'autoplay_speed'          => $settings['autoplay_speed'],
            'infinite'                => $settings['infinite'],
            'navigation'              => $settings['navigation'],
            'show_arrows'             =>  $settings['navigation'] ==  'none' ? false : true
        );

        $this->add_render_attribute( [
            'carousel-wrapper'   => [
                'class' => 'swiper-wrapper',
            ],
            'carousel-container' => [
                'class'                 => 'the4-swiper-container swiper-container kalles-testimonial-carousel ',
                'data-carousel_options' => htmlentities2( wp_json_encode( $carousel_options ) ),
                'dir'                   => $direction
            ],
        ] );

        ?>
        <div class="elementor-swiper" >
            <div <?php The4Helper::ksesHTML( $this->get_render_attribute_string( 'carousel-container' ) ); ?>>
                <div <?php The4Helper::ksesHTML( $this->get_render_attribute_string( 'carousel-wrapper' ) ); ?>>
                    <?php
                    foreach ( $settings['slides'] as $index => $slide ) :

                        ?>
                        <div class="swiper-slide" >
                            <?php $this->print_slide( $slide, $settings, 'slide-' . $index ); ?>
                        </div >
                    <?php endforeach; ?>
                </div >
                <?php if ( 1 < $slides_count ) : ?>
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
                <?php endif; ?>
            </div >
        </div >
        <?php
    }

    protected function render() {
        $this->print_slider();
        if ( is_admin() ){
            echo '
            <script>
                 jQuery(\'.the4-swiper-container:not(.slider-ready)\').each(function () {
                var $this = jQuery(this);
                var swiperOptions = {
                    slidesPerView: 1, spaceBetween: 30, pagination: {
                        el: \'.swiper-pagination\', clickable: true,
                    }, effect: \'slide\'
                };

                var this_slide_settings = $this.data(\'carousel_options\');

                var effect = this_slide_settings.hasOwnProperty(\'effect\') ? this_slide_settings.effect : \'slide\';
                swiperOptions.effect = effect;

                var slides_to_show = this_slide_settings.hasOwnProperty(\'slides_to_show\') ? parseInt(this_slide_settings.slides_to_show) : 1;
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

                swiperOptions.slidesPerView = slides_to_show;
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