<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
* @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$class = $data = $sizer = '';


global $kalles_sc;

// Get wc layout
$class = '';
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
if ( $term ) {
	$term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
}
if ( is_product_category() && isset( $term_options ) && $term_options && $term_options['product-cat-layout'] ) {
	$layout = $term_options['product-cat-layout'];
	$sidebar = $term_options['product-cat-sidebar'];
} else {
	$layout = cs_get_option( 'wc-layout' );
	$sidebar = cs_get_option( 'wc-sidebar' );
}

$is_sidebar = ( $layout == 'left-sidebar' || $layout == 'right-sidebar' ) ? true : false;

if ( cs_get_option( 'wc-sub-cat-layout' ) == 'masonry' ) {
	$class = 'the4-masonry';
	$data  = 'data-masonryjs=\'{"selector":".product", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
	$sizer = '<div class="grid-sizer size-' . cs_get_option( 'wc-sub-cat-column' ) . '"></div>';
}

$fullwidth = cs_get_option( 'wc-layout-full' );

// Sidebar filter
$sfilter = cs_get_option( 'wc-sidebar-filter' );

$sfilter_position = cs_get_option( 'wc-sidebar-filter-position' );

if ( wp_is_mobile() )
	$sfilter_position = 'left';

$shop_display = false;
$display_type = '';

if ( ! is_shop() ) {
	$term = get_queried_object();
	$display_type = get_term_meta( $term->term_id, 'display_type', true );
}

if ( is_tax( 'product_cat' ) && $display_type ) {
	$term = get_queried_object();
	$display_type = get_term_meta( $term->term_id, 'display_type', true );
} else {
	$display_type = get_option( 'woocommerce_category_archive_display' );
}

if ( get_option( 'woocommerce_shop_page_display' ) || 'subcategories' == $display_type || 'both' == $display_type ) {
	$shop_display = true;
}

?>
	<?php if ( is_active_sidebar( 'wc-categories' ) ) : ?>
		<div class="shop-top-sidebar">

			<?php
				$cat_menu = wp_nav_menu(
					array(
						'theme_location'  => 'categories-top-menu',
						'menu_class'      => 'menu-wrapper',
						'container_class' => 'categories-menu-container tc',
						'items_wrap'      => '<ul id="categories-menu-list" class="product-categories %2$s">%3$s</ul>',
						'fallback_cb'     => false,
						'echo' => FALSE,
					)
				);

				if ( ! empty( $cat_menu ) ) {
					echo wp_kses_post( $cat_menu );
				} else {
					if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'wc-categories' ) );
				}
			?>

		</div>
	<?php endif; ?>
	<?php
		/**
		 * Hook: woocommerce_before_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

		<h1 class="woocommerce-products-header__title  page-title"><?php woocommerce_page_title(); ?></h1>

	<?php endif; ?>

	<?php
		/**
		 * woocommerce_archive_description hook.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	?>

<?php
	$list_view = cs_get_option( 'wc-column' ) == 'listt4' ? 'on_list_view_true' : 'on_list_view_false';

	if ( isset( $_COOKIE['t4_cat_col'] ) ) {
		if ( $_COOKIE['t4_cat_col'] == 'listt4' ) {
			$list_view = 'on_list_view_true';
		} else {
			$list_view = 'on_list_view_false';
		}

	}
 ?>

<?php if ( $fullwidth ) echo '<div class="the4-full container_cat '. $layout .' pl__30 pr__30">'; elseif ( ! $fullwidth ) echo '<div class="container container_cat '. $list_view .' ' . $layout .'">'; ?>
	<?php if ( have_posts() ) : ?>
		<?php if ( $shop_display ) { ?>
			<div class="sub-categories mt__30">
				<div class="row <?php echo esc_attr( $class ); ?>" <?php echo wp_kses_post( $data ); ?>>
					<?php
						echo wp_kses_post( $sizer );
						woocommerce_product_subcategories();
					?>
				</div>
			</div>
		<?php } ?>
		<?php
			if ( $sfilter && ( ($sfilter_position != 'top' && $sfilter_position != 'top_show') || wp_is_mobile() ) ) :
				?>

				<div class="the4-filter-wrap pr">
					<div class="filter-sidebar bgbl pf <?php echo esc_attr( $sfilter_position ) ; ?>">
						<h3 class="mg__0 tc cw bgb tu ls__2 visible-sm"><?php echo esc_html__( 'Filter', 'kalles' ) ?>
							<i class="close-filter pe-7s-close pa ts__03"></i>
						</h3>
						<div class="cat_shop_wrap">
							<div class="cat_fixcl-scroll">
								<div class="cat_fixcl-scroll-content css_ntbar">
									<?php dynamic_sidebar( 'wc-filter' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
		endif;

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked wc_print_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
		?>
		<div class="nt_svg_loader dn"></div>
		<?php wc_print_notices(); ?>

		<!-- Shop filter top -->
		<?php if ( is_active_sidebar( 'kalles-filter-top' ) && ! wp_is_mobile() ) : ?>
		<?php $filter_open = cs_get_option('wc_cateogries_filter_on') ? 'filter_open' : '' ?>
		<div id="section-nt_filter" class="nt_ajaxFilter section_nt_filter section_filter_<?php echo esc_attr( $sfilter_position . ' ' . $filter_open ) ; ?>">
		    <div class="cat_shop_wrap">
		        <div class="cat_fixcl-scroll">
		            <div class="cat_fixcl-scroll-content css_ntbar">
		                    	<?php

								dynamic_sidebar( 'kalles-filter-top' );

								?>
		            </div>
		        </div>
		    </div>
		</div> <!-- #section-nt_filter -->
		<?php endif; ?>
		<div class="result_clear mt__30 mb__20 flex al_center">
			<?php the_widget('WC_Widget_Layered_Nav_Filters', array( 'title' => ''), array()); ?>
			<div class="kalles-filter-btn">
				<?php do_action('kalles_filter_btn'); ?>
			</div>
		</div>

			<?php
			if (  $is_sidebar && ! $kalles_sc && ! wp_is_mobile() ) {
				echo '<div class="row"><div class="categories-content col-md-9 col-sm-12 col-xs-12">';
			} elseif ( $layout == 'hidden-sidebar') {
				echo '<div class="row"><div class="categories-content col-md-12 col-sm-12 col-xs-12">';
			}

			?>
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/**
							 * woocommerce_shop_loop hook.
							 *
							 * @hooked WC_Structured_Data::generate_product_data() - 10
							 */
							do_action( 'woocommerce_shop_loop' );
						?>

						<?php wc_get_template( 'content-product.php' ); ?>

					<?php endwhile; ?>

				<?php woocommerce_product_loop_end(); ?>

			<?php
			$md_slidebar_class = wp_is_mobile() ? '12' : '3';

			?>
			<?php if ( $layout == 'right-sidebar' ) {
				$class = 'sidebar product-list-slidebar col-md-'. $md_slidebar_class .' col-sm-12 col-xs-12 mt__30 dn db_lg';
			} elseif ( $layout == 'left-sidebar' ) {
				$class = 'sidebar product-list-slidebar col-md-'. $md_slidebar_class .' col-sm-12 col-xs-12 mt__30 first-md first-sm dn db_lg';
			} elseif ( $layout == 'hidden-sidebar' ) {
				$class = 'sidebar product-list-slidebar hidden-sidebar-layout col-md-12 col-sm-12 col-xs-12 mt__30 dn';
			}



			if ( ( $is_sidebar || $layout == 'hidden-sidebar' ) && ! $kalles_sc ) {

				// Render pagination
				do_action( 'the4_pagination' );

				//woocommerce_after_shop_loop hook.
				do_action( 'woocommerce_after_shop_loop' );

				echo '</div><!-- .the4-columns-* -->';

				echo '<div class="' . esc_attr( $class ) . '">';

					if ( wp_is_mobile() || $layout == 'hidden-sidebar' )
					{
						echo '<div class="h3 mg__0 tu bgb cw visible-sm fs__16 pr">' . translate( 'Sidebar', 'kalles' ) .'<i class="close_pp pegk pe-7s-close fs__40 ml__5"></i></div>';
						echo  woocommerce_catalog_ordering();
					}


					if ( is_active_sidebar( $sidebar ) ) {
						dynamic_sidebar( $sidebar );
					}
				echo '</div><!-- .the4-sidebar -->';
				echo '</div><!-- .row -->';

			}?>

		<?php
			if ( $layout == 'no-sidebar' && ! $kalles_sc ) {
				do_action( 'the4_pagination' );

				//woocommerce_after_shop_loop hook.
				do_action( 'woocommerce_after_shop_loop' );
			}
		?>
		<?php  // Full width layout
			$fullwidth = cs_get_option( 'wc-layout-full' );
		?>

		<?php if ( $sfilter ) echo '</div>'; ?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

		<?php wc_get_template( 'loop/no-products-found.php' ); ?>
	</div>

	<?php else : ?>
		<?php
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		?>
	<?php endif; ?>

<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>
<?php get_footer( 'shop' ); ?>
