<?php
/**
 * Categories list Elementor Widget
 *
 * @since   1.0.0
 * @package Kalles
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Kalles_Elementor_Categories_List_Widget extends \Elementor\Widget_Base {

    public function __construct($data = [], $args = null) {
       parent::__construct($data, $args);
    }
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kalles-categories-list';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Categories List', 'kalles' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'categories', 'product', 'woocommerce' );
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

       // Get all terms of woocommerce
       $product_cat = array();
       $terms = get_terms( 'product_cat' );
       if ( $terms && ! isset( $terms->errors ) ) {
		foreach ( $terms as $key => $value ) {
			$product_cat[$value->term_id] = $value->name;
		}
       }


        $this->start_controls_section(
            'categories_content_section',
            [
                'label' => esc_html__( 'Content', 'kalles' ),
            ]
        );

        $this->add_control(
			'categories_id',
			array(
				'label' => esc_html__( 'Category', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
				'options' => $product_cat,
				'description' => esc_html__( 'Input category title to see suggestions', 'kalles' ),
			)
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'categories_style_section',
            [
                'label' => esc_html__( 'Style', 'kalles' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_cat_typography',
                'label' => esc_html__( 'Category Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} .cat_grid_item__title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );
        $this->add_control(
            'title_cat_color',
            array(
                'label'     => esc_html__( 'Category Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .cat_grid_item__title' => 'color: {{VALUE}}',

                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'cat_count_typography',
                'label' => esc_html__( 'Count Typography', 'kalles' ),
                'selector' => '{{WRAPPER}} .cat_grid_item__count',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            )
        );
        $this->add_control(
            'count_color',
            array(
                'label'     => esc_html__( 'Count Color', 'kalles' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .cat_grid_item__count' => 'color: {{VALUE}}',

                ),
            )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'categories_design_section',
            [
                'label' => esc_html__( 'Setting', 'kalles' ),
            ]
        );

        $this->add_control(
            'cat_design',
            array(
                'label' => esc_html__( 'Layout style', 'kalles' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '1' => esc_html__( 'Default', 'kalles' ),
                    '2' => esc_html__( 'Design 2', 'kalles' ),
                    '3' => esc_html__( 'Design 3', 'kalles' ),
                    '4' => esc_html__( 'Design 4', 'kalles' ),
                    '5' => esc_html__( 'Design 5', 'kalles' ),
                    '6' => esc_html__( 'Design 6', 'kalles' ),
                    '7' => esc_html__( 'Design 7', 'kalles' )
                ),
                'default' => '1',
            )
        );

        $this->add_control(
			'style',
			array(
				'label' => esc_html__( 'List categories style', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'grid' => esc_html__( 'Grid', 'kalles' ),
					'masonry' => esc_html__( 'Masonry', 'kalles' ),
					'carousel' => esc_html__( 'Carousel', 'kalles' ),
				),
				'default' => 'grid',
			)
		);


        $this->add_control(
			'items',
			array(
				'label' => esc_html__( 'Items (Number only)', 'kalles' ),
                'description' => esc_html__( 'Set the maximum amount of items displayed at a time with the widest browser width', 'kalles' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 4,
				'condition' => [
					'style' => [ 'carousel' ],
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
                'condition' => [
					'style' => [ 'carousel' ],
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
                'condition' => [
					'style' => [ 'carousel' ],
				],
			)
		);

		$this->add_control(
			'dots',
			array(
				'label' => esc_html__( 'Enable Pagination', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'No', 'kalles' ),
				'label_on' => esc_html__( 'Yes', 'kalles' ),
				'separator' => 'after',
                'default' => '',
                'condition' => [
					'style' => [ 'carousel' ],
				],
			)
		);

        ///////////////////

        $this->add_control(
			'columns',
			array(
				'label' => esc_html__( 'Columns', 'kalles' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'6' => esc_html__( '2 Columns', 'kalles' ),
					'4' => esc_html__( '3 Columns', 'kalles' ),
					'3' => esc_html__( '4 Columns', 'kalles' ),
					'15' => esc_html__( '5 Columns', 'kalles' ),
                    '2' => esc_html__( '6 Columns', 'kalles' ),
				),
				'default' => '3',
				'condition' => [
					'style' => [ 'grid', 'masonry' ],
				],
			)
		);

        ///////////////////

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
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->display_categories( $settings );

        if ( is_admin() ){
          echo "
         <script>
          if ( jQuery( '.the4-carousel' ).length > 0 ){
            jQuery( '.the4-carousel' ).not('.slick-initialized').slick({focusOnSelect: true});
          }
         </script>";
        }

        return;

	}

	public function display_categories( $settings )
	{
		$default_setting = array(
			'style'                  => 'grid',
			'sku'                    => '',
			'cat_id'                 => '',
			'items'                  => 4,
			'autoplay'               => '',
			'arrows'                 => '',
			'dots'                   => '',
			'columns'                => 4,
			'css_animation'          => '',
			'class'                  => '',
			'issc'                   => true,
		);

		$settings = wp_parse_args( $settings, $default_setting );

		if ( !empty( $settings['categories_id'] ) ) {
			$query_args = array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'include'    => $settings['categories_id'],
				'pad_counts' => true,
			);

			$categories = get_terms( $query_args );

			$attr = array();
			$class = $data = $sizer = $slider = '';

			if ( $settings['style'] == 'masonry' ) {
				$class = ' the4-masonry';
				$data  = 'data-masonryjs=\'{"selector":".categories-list__item","layoutMode":"masonry","columnWidth":".grid-sizer"' . ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) . '}\'';
				$sizer = '<div class="grid-sizer size-' . $settings[ 'columns'] . '"></div>';
				if ( $$settings['style'] == 'metro' ) {
					$class = ' the4-masonry metro';
				}
			} elseif ( $settings['style'] == 'carousel' ) {
				// Slider setting for shortcode products

				$attr_slider[] = '"slidesToShow": "' . ( int ) $settings['items'] . '"';
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
					$attr[] = 'data-slick=\'{' . esc_attr( implode( ', ', $attr_slider ) ) . ',"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3}},{"breakpoint": 480,"settings":{"slidesToShow": 2}}]' . '}\'';
				}
				$slider = ' the4-carousel';
			}

			// Layout fitRows for pagination is loadmore
			if ( $settings['style'] == 'grid') {
				$class = ' the4-masonry';
				$data  = 'data-masonryjs=\'{"selector":".categories-list__item","layoutMode":"fitRows"' . ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) . '}\'';
			}

			$classes = '';
			$classes = 'col-md-' . (int) $settings['columns'] . ' col-sm-4 col-xs-6 mt__30';
			?>
			<div class="categories-list row<?php echo esc_attr( $class ); ?><?php echo esc_html( $slider ); ?>
				cat_design_<?php echo esc_attr( $settings['cat_design'] ); ?>"
				<?php echo wp_kses_post( $data ); ?> <?php echo implode( ' ', $attr ); ?>>

				<?php echo wp_kses_post( $sizer ); ?>

				<?php foreach( $categories as $category ) : ?>
					<div class="cat_grid_item categories-list__item <?php echo esc_attr( $classes ); ?>">
						<div class="cat_grid_item__content pr oh">
							<a href="<?php echo get_term_link( $category->term_id, 'product_cat' ); ?>" class="db cat_grid_item__link ">
								<?php $this->get_category_img( $category->term_id ); ?>
								<div class="cat_grid_item__wrapper pe_none">
									<div class="cat_grid_item__title h3">
										<?php echo esc_html( $category->name ); ?>
									</div>
									<div class="cat_grid_item__count dn">
										<?php echo esc_html( $category->count ); ?>
										<?php if ( $category->count > 1 ) :  ?>
											<?php echo esc_html__( 'products', 'kalles' ) ?>
										<?php else : ?>
											<?php echo esc_html__( 'product', 'kalles' ) ?>
										<?php endif; ?>
									</div>
								</div>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php
		}

	}

	public function get_category_img( $cat_id )
	{
		 // get the thumbnail id using the queried category term_id
	    $thumbnail_id = get_term_meta( $cat_id, 'thumbnail_id', true );
	    if ( $thumbnail_id ) {
	    	echo '<div class="categories-list__item-img ' . kalles_image_lazyload_class() . '">';
	   			echo wp_get_attachment_image( $thumbnail_id, 'thumbnail_id' );
	   		echo '</div>';
	    } else {
	    	echo '<img src="https://placehold.jp/50/f76b6a/fff/530x600.png?text=Collection+Image" >';
	    }

	}

}



?>
