<?php
/**
 * Megamenu custom post type.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Kalles_Addons_Megamenu {
	/**
	 * Construct function.
	 *
	 * @return  void
	 */
	function __construct() {
		add_action( 'init', array( __CLASS__, 'the4_megamenu_init' ) );
		add_filter( 'single_template', array( $this, 'the4_megamenu_single' ) );
		add_filter( 'archive_template', array( $this, 'the4_megamenu_archive' ) );
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

		add_filter( 'manage_edit-megamenu_columns', array($this, 'edit_html_blocks_columns') ) ;
		add_action( 'manage_megamenu_posts_custom_column', array($this, 'megamenu_block'), 10, 2 );

	}

	/**
	 * Register a portfolio post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function the4_megamenu_init() {
		register_post_type( 'megamenu',
			array(
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'query_var'          => true,
				'capability_type'    => 'page',
				'has_archive'        => false,
				'hierarchical'       => false,
				'menu_position'      => 99,
				'menu_icon'          => 'dashicons-menu-alt3',
				'supports'           => array( 'title', 'editor'),
				'labels'             => array(
					'name'               => _x( 'Megamenu', 'kalles-addons' ),
					'singular_name'      => _x( 'Megamenu', 'kalles-addons' ),
					'menu_name'          => _x( 'Megamenu', 'kalles-addons' ),
					'name_admin_bar'     => _x( 'Megamenu', 'kalles-addons' ),
					'add_new'            => _x( 'Add New', 'kalles-addons' ),
					'add_new_item'       => __( 'Add menu block', 'kalles-addons' ),
					'new_item'           => __( 'New Megamenu', 'kalles-addons' ),
					'edit_item'          => __( 'Edit Megamenu', 'kalles-addons' ),
					'view_item'          => __( 'View Megamenu', 'kalles-addons' ),
					'all_items'          => __( 'All Megamenus', 'kalles-addons' ),
					'search_items'       => __( 'Search Megamenus', 'kalles-addons' ),
					'parent_item_colon'  => __( 'Parent Megamenus:', 'kalles-addons' ),
					'not_found'          => __( 'No portfolios found.', 'kalles-addons' ),
					'not_found_in_trash' => __( 'No portfolios found in Trash.', 'kalles-addons' )
				),
			)
		);
		add_shortcode('the4_megamenu_block', 'the4_megamenu_block_shortcode');


	}
	public function megamenu_block($column, $post_id) {
		switch( $column ) {
			case 'shortcode' :
				echo '<strong>[html_block id="'.$post_id.'"]</strong>';
				break;
		}
	}
	public function edit_html_blocks_columns( $columns ) {

		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => esc_html__( 'Title', 'kalles' ),
			'shortcode' => esc_html__( 'Shortcode', 'kalles' ),
			'date' => esc_html__( 'Date', 'kalles' ),
		);
		return $columns;
	}


	/**
	 * Load single item template file for the portfolio custom post type.
	 *
	 * @param   string  $template  Current template file.
	 *
	 * @return  string
	 */
	function the4_megamenu_single( $template ) {
		return $template;
	}

	/**
	 * Load archive template file for the portfolio custom post type.
	 *
	 * @param   string  $template  Current template file.
	 *
	 * @return  string
	 */
	function the4_megamenu_archive( $template ) {
		 return $template;
	}

	/**
	 * Define helper function to print related megamenu.
	 *
	 * @return  array
	 */
	public static function related() {
		global $post;

		// Get the megamenu tags.
		$tags = get_the_terms( $post, 'the4_megamenu_tag' );

		if ( $tags ) {
			$tag_ids = array();

			foreach ( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}

			$args = array(
				'post_type'      => 'megamenu',
				'post__not_in'   => array( $post->ID ),
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'the4_megamenu_tag',
						'field'    => 'id',
						'terms'    => $tag_ids,
					),
				)
			);

			// Get megamenu category
			$categories = wp_get_post_terms( get_the_ID(), 'the4_megamenu_cat' );

			$the_query = new WP_Query( $args );
			?>
			<div class="container mb__60 related-megamenu">
				<h4 class="mg__0 mb__30 tu tc fwb"><?php echo esc_html__( 'Related Portfolio', 'kalles-addons' ); ?></h4>
				<div class="the4-carousel" data-slick='{"slidesToShow": 3,"slidesToScroll": 1,"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}'>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div id="portfolio-<?php the_ID(); ?>" class="portfolio-item pl__10 pr__10 pr">
							<a href="<?php the_permalink(); ?>" class="mask db pr chp">
								<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail();
									endif;
								?>
							</a>
							<div class="pa tc ts__03 portfolio-title">
								<h4 class="fs__16 fwsb tu mg__0"><a class="cd chp" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<?php
									if ( $categories ) {
										echo '<span>' . get_the_term_list( $post->ID, 'the4_megamenu_cat', '', ', ' ) . '</span>';
									}
								?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		<?php
		}

		wp_reset_postdata();
	}

	/**
	 * fix paginate not work from page 3
	 *
	 */
	public static function pre_get_posts($query) {
		if ( !is_admin() && $query->is_main_query() ) {
			if ($query->is_tax('the4_megamenu_cat') || $query->is_tax('the4_megamenu_client') || $query->is_tax('the4_megamenu_tag')) {
				$query->set( 'posts_per_page', cs_get_option( 'portfolio-number-per-page' ) );
			}
		}
	}
}
$megamenu = new Kalles_Addons_Megamenu;