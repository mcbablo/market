<?php
/**
 * Portfolio custom post type.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class Kalles_Addons_Portfolio {
	/**
	 * Construct function.
	 *
	 * @return  void
	 */
	function __construct() {
		add_action( 'init', array( __CLASS__, 'portfolio_init' ) );
		add_filter( 'single_template', array( $this, 'portfolio_single' ), 30 );
		add_filter( 'archive_template', array( $this, 'portfolio_archive' ),30 );
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
	}

	/**
	 * Register a portfolio post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function portfolio_init() {
		register_post_type( 'portfolio',
			array(
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'portfolio' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 99,
				'menu_icon'          => 'dashicons-welcome-widgets-menus',
				'supports'           => array( 'title', 'editor', 'thumbnail' ),
				'labels'             => array(
					'name'               => _x( 'Portfolio', 'kalles-addons' ),
					'singular_name'      => _x( 'Portfolio', 'kalles-addons' ),
					'menu_name'          => _x( 'Portfolio', 'kalles-addons' ),
					'name_admin_bar'     => _x( 'Portfolio', 'kalles-addons' ),
					'add_new'            => _x( 'Add New', 'kalles-addons' ),
					'add_new_item'       => __( 'Add New Portfolio', 'kalles-addons' ),
					'new_item'           => __( 'New Portfolio', 'kalles-addons' ),
					'edit_item'          => __( 'Edit Portfolio', 'kalles-addons' ),
					'view_item'          => __( 'View Portfolio', 'kalles-addons' ),
					'all_items'          => __( 'All Portfolios', 'kalles-addons' ),
					'search_items'       => __( 'Search Portfolios', 'kalles-addons' ),
					'parent_item_colon'  => __( 'Parent Portfolios:', 'kalles-addons' ),
					'not_found'          => __( 'No portfolios found.', 'kalles-addons' ),
					'not_found_in_trash' => __( 'No portfolios found in Trash.', 'kalles-addons' )
				),
			)
		);

		// Register portfolio category
		register_taxonomy( 'portfolio_cat',
			array( 'portfolio' ),
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'portfolio_cat' ),
				'labels'            => array(
					'name'              => _x( 'Categories', 'kalles-addons' ),
					'singular_name'     => _x( 'Category', 'kalles-addons' ),
					'search_items'      => __( 'Search Categories', 'kalles-addons' ),
					'all_items'         => __( 'All Categories', 'kalles-addons' ),
					'parent_item'       => __( 'Parent Category', 'kalles-addons' ),
					'parent_item_colon' => __( 'Parent Category:', 'kalles-addons' ),
					'edit_item'         => __( 'Edit Category', 'kalles-addons' ),
					'update_item'       => __( 'Update Category', 'kalles-addons' ),
					'add_new_item'      => __( 'Add New Category', 'kalles-addons' ),
					'new_item_name'     => __( 'New Category Name', 'kalles-addons' ),
					'menu_name'         => __( 'Categories', 'kalles-addons' ),
				),
			)
		);

		// Register portfolio project client
		register_taxonomy( 'portfolio_client',
			'portfolio',
			array(
				'hierarchical'          => true,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'portfolio_client' ),
				'labels'                => array(
					'name'                       => _x( 'Clients', 'kalles-addons' ),
					'singular_name'              => _x( 'Client', 'kalles-addons' ),
					'search_items'               => __( 'Search Clients', 'kalles-addons' ),
					'all_items'                  => __( 'All Clients', 'kalles-addons' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => __( 'Edit Client', 'kalles-addons' ),
					'update_item'                => __( 'Update Client', 'kalles-addons' ),
					'add_new_item'               => __( 'Add New Client', 'kalles-addons' ),
					'new_item_name'              => __( 'New Client Name', 'kalles-addons' ),
					'separate_items_with_commas' => __( 'Separate client with commas', 'kalles-addons' ),
					'add_or_remove_items'        => __( 'Add or remove client', 'kalles-addons' ),
					'choose_from_most_used'      => __( 'Choose from the most used client', 'kalles-addons' ),
					'not_found'                  => __( 'No client found.', 'kalles-addons' ),
					'menu_name'                  => __( 'Clients', 'kalles-addons' ),
				),
			)
		);

		// Register portfolio tag
		register_taxonomy( 'portfolio_tag',
			'portfolio',
			array(
				'hierarchical'          => true,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'portfolio_tag' ),
				'labels'                => array(
					'name'                       => _x( 'Tags', 'kalles-addons' ),
					'singular_name'              => _x( 'Tag', 'kalles-addons' ),
					'search_items'               => __( 'Search Tags', 'kalles-addons' ),
					'popular_items'              => __( 'Popular Tags', 'kalles-addons' ),
					'all_items'                  => __( 'All Tags', 'kalles-addons' ),
					'parent_item'                => null,
					'parent_item_colon'          => null,
					'edit_item'                  => __( 'Edit Tag', 'kalles-addons' ),
					'update_item'                => __( 'Update Tag', 'kalles-addons' ),
					'add_new_item'               => __( 'Add New Tag', 'kalles-addons' ),
					'new_item_name'              => __( 'New Tag Name', 'kalles-addons' ),
					'separate_items_with_commas' => __( 'Separate tag with commas', 'kalles-addons' ),
					'add_or_remove_items'        => __( 'Add or remove tag', 'kalles-addons' ),
					'choose_from_most_used'      => __( 'Choose from the most used tag', 'kalles-addons' ),
					'not_found'                  => __( 'No tag found.', 'kalles-addons' ),
					'menu_name'                  => __( 'Tags', 'kalles-addons' ),
				),
			)
		);
	}

	/**
	 * Load single item template file for the portfolio custom post type.
	 *
	 * @param   string  $template  Current template file.
	 *
	 * @return  string
	 */
	function portfolio_single( $template ) {
		global $post;

		if ( $post->post_type == 'portfolio' ) {
			$template = KALLES_ADDONS_PATH . 'includes/portfolio/views/single.php';
		}

		return $template;
	}

	/**
	 * Load archive template file for the portfolio custom post type.
	 *
	 * @param   string  $template  Current template file.
	 *
	 * @return  string
	 */
	function portfolio_archive( $template ) {
		global $post;

		if ( isset( $post->post_type ) && $post->post_type == 'portfolio' ) {
			$template = KALLES_ADDONS_PATH . 'includes/portfolio/views/archive.php';
		}

		return $template;
	}

	/**
	 * Define helper function to print related portfolio.
	 *
	 * @return  array
	 */
	public static function related() {
		global $post;

		// Get the portfolio tags.
		$tags = get_the_terms( $post, 'portfolio_tag' );

		if ( $tags ) {
			$tag_ids = array();

			foreach ( $tags as $tag ) {
				$tag_ids[] = $tag->term_id;
			}

			$args = array(
				'post_type'      => 'portfolio',
				'post__not_in'   => array( $post->ID ),
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'portfolio_tag',
						'field'    => 'id',
						'terms'    => $tag_ids,
					),
				)
			);

			// Get portfolio category
			$categories = wp_get_post_terms( get_the_ID(), 'portfolio_cat' );

			$the_query = new WP_Query( $args );
			?>
			<div class="the4-container mb__60 related-portfolio">
				<div class="container">
				<h4 class="mg__0 mb__30 tu tc fwb"><?php echo esc_html__( 'Related Portfolio', 'kalles-addons' ); ?></h4>
				<div class="the4-carousel" data-slick='{"slidesToShow": 4,"slidesToScroll": 1,"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}},{"breakpoint": 480,"settings":{"slidesToShow": 1}}]<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}'>
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
										echo '<span>' . get_the_term_list( $post->ID, 'portfolio_cat', '', ', ' ) . '</span>';
									}
								?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
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
			if ($query->is_tax('portfolio_cat') || $query->is_tax('portfolio_client') || $query->is_tax('portfolio_tag')) {
				$query->set( 'posts_per_page', cs_get_option( 'portfolio-number-per-page' ) );
			}
		}
	}
}
$portfolio = new Kalles_Addons_Portfolio;