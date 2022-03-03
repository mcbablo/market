<?php
/**
 * Add widget banner to elementor
 *
 * @since   1.6.2
 * @package Kalles
 */
use Elementor\Controls_Manager;

class Kalles_Elementor_Countdown_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'kalles-countdown';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Countdown', 'kalles' );
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-countdown';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return array( 'countdown' );
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
            'kalles_addons_countdown',
            array(
                'label' => esc_html__( 'Content', 'kalles' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'date',
            array(
                'label'   => esc_html__( 'Data countdown', 'kalles' ),
                'type'    => Controls_Manager::DATE_TIME,
                'default' => date( 'Y-m-d'),
            )
        );
        $this->add_control(
            'count_color',
            array(
                'label'     => esc_html__( 'Time Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .wrap_countdown_sc .the4-countdown-page .flip-top' => 'color: {{VALUE}};',

                ),
            )
        );
        $this->add_control(
            'text_color',
            array(
                'label'     => esc_html__( 'Text Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .wrap_countdown_sc .the4-countdown-page .label' => 'color: {{VALUE}};',

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

    }

    /**
     * Create shortcode row
     *
     * @return string
     */
    public function create_shortcode() {

        $settings = $this->get_settings_for_display();

        $args_row = '';

        //////////////////
        ///
        $args_row .= $settings['css_animation'] ? ' css_animation="'.esc_attr($settings['css_animation']).'"' : '';

        $args_row .= $settings['class'] ? ' class="'.esc_attr($settings['class']).'"' : '';

        /////////////////////

        $args_row .= $settings['date'] ? ' date="'. $settings['date'] .'"' : '';

        return '[kalles_addons_countdown'.$args_row.']';

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $classes = array();
        $date         = $settings['date'];
        $css_animation = $settings['css_animation'];

        if ( '' !== $css_animation ) {
            wp_enqueue_script( 'waypoints' );
            $classes[] = 'wpb_animate_when_almost_visible wpb_' . $css_animation;
        }

        if ( ! empty( $class ) ) {
            $classes[] = $class;
        }
        ?>

        <div class="wrap_countdown_sc <?php echo esc_attr( implode( ' ', $classes ) ); ?> ">
        <?php if ( $date ) : ?>
            <?php $date_now = date("Y-m-d");  ?>
            <?php if ( ! empty( $date ) && $date > $date_now ) : ?>
                <div class="the4-countdown-page in_flex fl_between lh__1" data-time="<?php echo $date; ?>"></div>
            <?php endif;
        endif;

        if ( is_admin() ){
            echo "<script>
              if( jQuery('.the4-countdown-page').length > 0) {
                var _end = jQuery('.the4-countdown-page').data( 'time' );
                if (_end) {
                    jQuery('.the4-countdown-page').countdown(
                        _end,
                        function(event) {
                            jQuery( this ).html(event.strftime(' '
                                + '<div class=\"block tc\"><span class=\"flip-top\">%-D</span><br><span class=\"label tu\">' + THE4_Data_Js['days'] + '</span></div>'
                                + '<div class=\"block tc\"><span class=\"flip-top\">%H</span><br><span class=\"label tu\">' + THE4_Data_Js['hrs'] + '</span></div>'
                                + '<div class=\"block tc\"><span class=\"flip-top\">%M</span><br><span class=\"label tu\">' + THE4_Data_Js['mins'] + '</span></div>'
                                + '<div class=\"block tc\"><span class=\"flip-top\">%S</span><br><span class=\"label tu\">' + THE4_Data_Js['secs'] + '</span></div>'
                            ));
                        }
                    );
                }
            }
             </script>";
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
    public function render_plain_content() {

    }


}
