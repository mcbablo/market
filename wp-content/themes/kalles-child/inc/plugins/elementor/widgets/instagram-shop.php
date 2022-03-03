<?php
/**
 * Instagram shop Widget Elementor
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Kalles_Elementor_Instagram_Shop_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
       parent::__construct($data, $args);
    }

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-instagram-shop';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Instagram shop', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-instagram-gallery';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'instagram', 'image', 'images' );
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
			'kalles_el_instagram_shop',
			array(
				'label' => esc_html__( 'Content', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_type',
			[
				'label'   => esc_html__( 'Item type', 'kalles' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'image'       => esc_html__( 'Image Parent', 'kalles' ),
					'pin' => esc_html__( 'Pin', 'kalles' ),
				],
				'default' => 'image',
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose image', 'kalles' ),
				'type'  => Controls_Manager::MEDIA,
				'condition' => [
					'item_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'image_url',
			[
				'label' => esc_html__( 'Link (optional)', 'kalles' ),
				'type'  => Controls_Manager::URL,
				'url' => '',
				'is_external' => true,
				'nofollow' => true,
				'condition' => [
					'item_type' => 'image',
				],
			]
		);
		

		$repeater->add_control(
			'position_top',
			array(
				'label' => esc_html__( 'Position Top', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'ea' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'item_type' => 'pin',
				],
			)
		);

		$repeater->add_control(
			'position_left',
			array(
				'label' => esc_html__( 'Position Left', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'ea' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'item_type' => 'pin',
				],
			)
		);

		$repeater->add_control(
			'product_id',
			[
				'label' => esc_html__( 'Product', 'kalles' ),
				'type'  => 'kalles_post_select',
				'post_type'  => 'product',
				'get_data'  => 'the4_kalles_get_data_post_by_id',
				'search'  => 'the4_kalles_search_post_by_query',
				'description' => esc_html__( 'Input product title to see suggestions', 'kalles' ),
				'multiple' => false,
				'condition' => [
					'item_type' => 'pin',
				],
			]
		);


		$this->add_control(
			'items',
			[
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ item_type }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'pin',
					],
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'pin',
					],
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'image',
					],
					[
						'item_type' => 'image',
					],
				],
			]
		);

		$this->end_controls_section();

	    $this->start_controls_section(
			'instagram-shop-setting',
			array(
				'label' => esc_html__( 'Setting', 'kalles' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_control(
			'style',
			array(
				'label' => esc_html__( 'List style', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'grid' => esc_html__( 'Grid', 'kalles' ),
					'carousel' => esc_html__( 'Carousel', 'kalles' ),
				),
				'default' => 'carousel',
			)
		);

        ///////////////////
		$this->add_control(
			'slider_heading',
			[
				'label' => esc_html__( 'Slider', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'   => [
                    'style' => 'carousel',
                ],
			]
		);

        $this->add_control(
			'slider_items',
			array(
				'label' => esc_html__( 'Items (Number only)', 'kalles' ),
                'description' => esc_html__( 'Set the maximum amount of items displayed at a time with the widest browser width', 'kalles' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 6,
				'condition'   => [
                    'style' => 'carousel',
                ],
			)
		);

        $this->add_control(
			'autoplay',
			array(
				'label' => esc_html__( 'Enable Auto play', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => '',
                'condition'   => [
                    'style' => 'carousel',
                ],
			)
		);

        $this->add_control(
			'arrows',
			array(
				'label' => esc_html__( 'Enable Navigation', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
                'default' => '',
                'condition'   => [
                    'style' => 'carousel',
                ],
			)
		);
        ///////////////////

		$this->add_control(
			'qty_heading',
			[
				'label' => esc_html__( 'Photos per row', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'   => [
                    'style' => 'grid',
                ],
			]
		);

        $this->add_control(
			'columns',
			array(
				'label' => esc_html__( 'Desktop', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'6' => esc_html__( '2 photos', 'kalles' ),
					'4' => esc_html__( '3 photos', 'kalles' ),
					'3' => esc_html__( '4 photos', 'kalles' ),
					'15' => esc_html__( '5 photos', 'kalles' ),
                    '2' => esc_html__( '6 photos', 'kalles' ),
				),
				'default' => '2',
				'condition'   => [
                    'style' => 'grid',
                ],
			)
		);

        $this->add_control(
			'columns_tablet',
			array(
				'label' => esc_html__( 'Tablet', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'6' => esc_html__( '2 photos', 'kalles' ),
					'4' => esc_html__( '3 photos', 'kalles' ),
					'3' => esc_html__( '4 photos', 'kalles' ),
				),
				'default' => '3',
				'condition'   => [
                    'style' => 'grid',
                ],
			)
		);

		$this->add_control(
			'columns_mobile',
			array(
				'label' => esc_html__( 'Mobile', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'12' => esc_html__( '1 photo', 'kalles' ),
					'6' => esc_html__( '2 photos', 'kalles' ),

				),
				'default' => '6',
				'condition'   => [
                    'style' => 'grid',
                ],
			)
		);

		///////////////////
		$this->add_control(
			'style_heading',
			[
				'label' => esc_html__( 'Style', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'space',
			array(
				'label' => esc_html__( 'Spaces between photos', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'0' => esc_html__( '0px', 'kalles' ),
					'2' => esc_html__( '2px', 'kalles' ),
					'3' => esc_html__( '3px', 'kalles' ),
					'6' => esc_html__( '6px', 'kalles' ),
                    '10' => esc_html__( '10px', 'kalles' ),
                    '15' => esc_html__( '15px', 'kalles' ),
				),
				'default' => '0',
			)
		);

		$this->add_control(
			'rounded',
			array(
				'label' => esc_html__( 'Rounded corners for images', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'0' => esc_html__( 'Disable', 'kalles' ),
					'1' => esc_html__( 'Style 1', 'kalles' ),
					'2' => esc_html__( 'Style 2', 'kalles' ),
				),
				'default' => '0',
			)
		);

        ///////////////////
		$this->add_control(
			'extra_heading',
			[
				'label' => esc_html__( 'Extra', 'kalles' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
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


    }

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {


		$settings = $this->get_settings_for_display();

		$slider = '';
		$attr = array();

		if ( $settings['style'] == 'carousel' ) {
			$attr_slider[] = '"slidesToShow": ' . ( int ) $settings['slider_items'];
			if ( ! empty( $settings['autoplay'] ) ) {
				$attr_slider[] = '"autoplay": true';
			}
			if ( ! empty( $settings['arrows'] ) ) {
				$attr_slider[] = '"arrows": true';
			} else {
				$attr_slider[] = '"arrows": false';
			}
			if ( ! empty( $settings['dots'] ) ) {
				$attr_slider[] = '"dots": true';
			}

			if ( is_rtl() ) {
				$attr_slider[] = '"rtl": true';
			}

			if ( ! empty( $attr_slider ) ) {
				$attr[] = 'data-slick=\'{' . implode( ', ', $attr_slider ) . ',"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 480,"settings":{"slidesToShow": 2}}]' . '}\'';
			}
			$slider = ' the4-carousel-ins';
		}

		$items = $this->assyn_data( $settings['items'] );

		if ( ! empty( $items ) ) {
			?>
			<div class="ins_shop_wrap row ins_rounded_<?php echo esc_attr( $settings[ 'rounded' ] ); ?> ins_spaces_<?php echo esc_attr( $settings[ 'space' ] ); ?> nt_cover <?php echo esc_attr( $slider ); ?>" <?php echo implode( ' ', $attr ); ?>>
				<?php foreach( $items as $item ) : ?>
					<div class="pin__wr_js col_ins col-lg-<?php echo esc_attr( $settings['columns'] ); ?> col-md-<?php echo esc_attr( $settings['columns_tablet'] ); ?> col-<?php echo esc_attr( $settings['columns_mobile'] ); ?> item pr oh" >
						<!-- IMAGE -->
						<div class="wrap_ins_img db pr oh">
							<?php if( ! empty( $item[ 'url' ] ) ) : ?>
								<a href="<?php echo esc_url( $item[ 'url' ] ); ?>" <?php echo esc_attr( $item[ 'target' ] ); ?>>
									<?php The4Helper::ksesHTML( $item[ 'image' ] ); ?>
								</a>
							<?php else : ?>
								<?php The4Helper::ksesHTML( $item[ 'image' ] ); ?>
							<?php endif; ?>
						</div>
						<!-- PIN -->
						<?php if ( !empty( $item[ 'pin' ] ) ) : ?>
							<?php foreach( $item[ 'pin' ] as $index => $pin ) : ?>
								<a href="" rel="nofollow"
									class="btn-quickview hotspot_ins dark pa op__0"
									data-prod="<?php echo esc_attr( $pin[ 'product_id' ] ); ?>"
									style="transform: translate(-<?php echo esc_attr( $pin['position_left'] ); ?>%, -<?php echo esc_attr( $pin['position_top'] ); ?>%);top:<?php echo esc_attr( $pin['position_top'] ); ?>%;left:<?php echo esc_attr( $pin['position_left'] ); ?>%" >
									<span><?php echo esc_html( $index ); ?></span>
								</a>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php
		} //Endif



        if ( is_admin() ){
          echo "
         <script>

         The4Kalles.KallesCountdown();

          if ( jQuery( '.the4-carousel-ins' ).length > 0 ){
            jQuery( '.the4-carousel-ins' ).not('.slick-initialized').slick({focusOnSelect: true});

            setTimeout(function(){
	            jQuery( '.the4-carousel-ins.slick-initialized' ).slick('refresh');
	        }, 200);
          }
         </script>";
        }

        return;

	}


	 public function assyn_data( $items )
	 {
	 	$data = array();
	 	$index = 0;

	 	for( $i = 0; $i < count( $items ); $i++) {
	 		if ( $items[ $i ]['item_type'] == 'image' ) {
	 			$pin_index = 1;
	 			if ( $items[ $i ][ 'image' ][ 'id' ] != '' ){
	 				$data[ $index ][ 'image' ] = '<div class="instagram-shop-img ' . kalles_image_lazyload_class() .'">' .
	 					wp_get_attachment_image( $items[ $i ][ 'image' ][ 'id' ], 'full' ) . '</div>';
	 			} else {
	 				$data[ $index ][ 'image' ] = '<img src="https://placehold.jp/80/f5f5f5/999/1080x1080.png">';
	 			}

	 			$data[ $index ][ 'url' ] = $items[ $i ][ 'image_url' ][ 'url' ];
	 			$data[ $index ][ 'target' ] = $items[ $i ][ 'image_url' ][ 'is_external' ] == 'on' ? 'target="_blank"' : '';

	 		} else {
	 			$data_pin = array();
	 			$data_pin[ 'position_top' ] = $items[ $i ][ 'position_top' ][ 'size' ];
	 			$data_pin[ 'position_left' ] = $items[ $i ][ 'position_left' ][ 'size' ];
	 			$data_pin[ 'product_id' ] = $items[ $i ][ 'product_id' ];
	 			$data[ $index ][ 'pin' ][ $pin_index ] = $data_pin;
	 			$pin_index++;
	 		}
	 		if ( isset( $items[ $i + 1 ][ 'item_type' ] ) && $items[ $i + 1 ][ 'item_type' ] == 'image' ) {
	 			$index++;
	 		}
	 	}

	 	return $data;
	 }


}
/////////////////////
