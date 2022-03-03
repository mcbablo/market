<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    size-chart-for-woocommerce
 * @subpackage size-chart-for-woocommerce/public/includes
 * @author     Multidots
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$chart_label = scfw_size_chart_get_label_by_chart_id( $chart_id );
$chart_table = scfw_size_chart_get_chart_table_by_chart_id( $chart_id );
if ( isset( $chart_label ) && ! empty( $chart_label ) ) {
	printf( '<p class="md-size-chart-label">%s</p>', esc_html( $chart_label ) );
}

$post_data = get_post( $chart_id );
$size_chart_get_sub_title_text = scfw_size_chart_get_sub_title_by_chart_id( $chart_id );
if ( isset($size_chart_get_sub_title_text) && !empty($size_chart_get_sub_title_text) ) {
	$size_chart_sub_title = $size_chart_get_sub_title_text;
} else {
	$size_chart_get_sub_title_text = scfw_size_chart_get_sub_title_text();
	$size_chart_sub_title = trim($size_chart_get_sub_title_text);
}
if ( $post_data->post_content ) {
	$content = wpautop($post_data->post_content);
	if (isset($size_chart_sub_title) && !empty($size_chart_sub_title)) {
		printf( '<div class="chart-content"><span><b>%s</b></span>%s</div>',
			esc_html( $size_chart_sub_title ),
			wp_kses_post( $content )
		);
	} else {
		printf( '<div class="chart-content">%s</div>',
			wp_kses_post( $content )
		);
	}
} else {
	if ( isset($size_chart_sub_title) && !empty($size_chart_sub_title) ) {
		printf( '<div class="chart-content"><span><b>%s</b></span></div>',
			esc_html( $size_chart_sub_title )
		);
	}
}
$chart_image_id = scfw_size_chart_get_primary_chart_image_id( $chart_id );
if ( $chart_image_id ) {
	$chart_image_url = wp_get_attachment_url( $chart_image_id );
	printf(
		'<div class="chart-image"><img src="%s" alt="%s" title="%s"/></div>',
		esc_url( $chart_image_url ),
		esc_attr( $post_data->post_title ),
		esc_attr( $chart_label )
	);
}

if ( isset( $chart_table ) && array_filter( $chart_table ) ) {
    if( false !== scfw_is_size_chart_table_empty($chart_table) ) {
	    ?>
        <div class="chart-table">
		    <?php
		    echo wp_kses_post( scfw_size_chart_get_chart_table( $chart_table, $chart_id ) );
            ?>
        </div>
	    <?php
    }
}
?>
