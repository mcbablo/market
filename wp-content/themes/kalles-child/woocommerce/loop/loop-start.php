<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

global $kalles_sc;

// Get product list style
$class = $data = $sizer = $slider = $style = '';
$attr = array();


$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
if ( $term ) {
	$term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
}

if ( is_product_category() && isset( $term_options ) && $term_options && $term_options['product-cat-layout'] ) {
	$layout = $term_options['product-cat-layout'];
} else {
	$layout = cs_get_option( 'wc-layout' );
}

if ( isset( $term_options['wc-style'] ) ) {
	$style = $term_options['wc-style'];
}
$style = $kalles_sc ? $kalles_sc['style'] : apply_filters( 'the4_kalles_wc_style', cs_get_option( 'wc-style' ) );

// Get pagination style
$pagination = $kalles_sc ? '' : cs_get_option( 'wc-pagination' );

// Get product filter
$filter = isset($kalles_sc['filter']) ? $kalles_sc['filter'] : 0;

$isAjax = false;

if ( isset( $kalles_sc['isAjax'] ) && $kalles_sc['isAjax'] ) {
	$isAjax = true;
}

if ( $style == 'metro' || $style == 'masonry' ) {
	$class = ' the4-masonry';
	$data  = 'data-masonryjs=\'{"selector":".product","layoutMode":"masonry","columnWidth":".grid-sizer"' . ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) . '}\'';
	$columns = ( isset( $_COOKIE['t4_cat_col'] ) && $_COOKIE['t4_cat_col'] ) ? $_COOKIE['t4_cat_col']  : cs_get_option( 'wc-column' );

	$sizer = '<div class="grid-sizer size-' . $columns . '"></div>';
	if ( $style == 'metro' ) {
		$class = ' the4-masonry metro';
	}
} 
if ( $style == 'carousel' ) {

	if ( ! empty( $kalles_sc['items'] ) ) {
		$attr_slider[] = '"slidesToShow": ' . ( int ) $kalles_sc['items'] . ',"slidesToScroll": ' . ( int ) $kalles_sc['items'];
	}
	if ( ! empty( $kalles_sc['autoplay'] ) ) {
		$attr_slider[] = '"autoplay": true';
	}
	if ( ! empty( $kalles_sc['arrows'] ) ) {
		$attr_slider[] = '"arrows": true';
	} else {
		$attr_slider[] = '"arrows": false';
	}
	if ( ! empty( $kalles_sc['dots'] ) ) {
		$attr_slider[] = '"dots": true';
	}

	if ( is_rtl() ) {
		$attr_slider[] = '"rtl": true';
	}

	if ( ! empty( $attr_slider ) ) {
		$attr[] = 'data-slick=\'{' . esc_attr( implode( ', ', $attr_slider ) ) . ',"responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 3,"slidesToScroll": 3 }},{"breakpoint": 480,"settings":{"slidesToShow": 2,"slidesToScroll": 2}}]' . '}\'';
	}
	$slider = ' the4-carousel';
}

// Layout fitRows for pagination is loadmore
if ( $style == 'grid' && $pagination == 'loadmore' ) {
	$class = ' the4-masonry';
	$data  = 'data-masonryjs=\'{"selector":".product","layoutMode":"fitRows"' . ( is_rtl() ? ',"rtl": false' : ',"rtl": true' ) . '}\'';
}

?>

<?php if ( ! $isAjax ) : ?>

	<?php do_action( 'kalles_before_loop_start' ); ?>
	
	<div class="products row<?php echo esc_attr( $class ); ?><?php echo esc_html( $slider ); ?>" <?php echo wp_kses_post( $data ); ?> <?php echo  implode( ' ', $attr ); ?>>
<?php endif; ?>
		<?php echo wp_kses_post( $sizer ); ?>
