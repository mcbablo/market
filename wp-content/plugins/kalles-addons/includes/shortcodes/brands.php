<?php
/**
 * Banner Brands.
 *
 * @package KallesAddons
 * @since   1.1.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_brands' ) ) {
	function kalles_addons_shortcode_brands() {
		
		$attribute_names = cs_get_option('wc-brands'); // Add attribute names here and remember to add the pa_ prefix to the attribute name

        if ( ! is_array( $attribute_names ) || empty( $attribute_names ) ) {
            return;
        }
        
        $brands = array();
        $lists = array();

        foreach ( $attribute_names as $index => $attribute_name ) {

            $attr_name = 'pa_' . $attribute_name;

            $terms = get_terms([
                'taxonomy' => $attr_name,
                'hide_empty' => false,
            ]);
            if ( ! empty( $terms ) ) {
                foreach( $terms as $index => $term ) {
                    $brands[$term->name]['name'] = $term->name;
                    $brands[$term->name]['link'] = get_term_link( $term );
                }
            } 
        }

        foreach( $brands as $name => $brand ) {
            $key =  strtolower( $name[0] );

            $lists[$key][] = $brand;
        }

        ?>
        <div class="nt_filteriso_js brands_filter blg_count_true fwm tc mb__35 flex">
            <div class="brands_filter_control flex">
                <button class="cg btn-t4s btn-t4s-haschild filter-t4s-active" data-filter=".filter_allt4s"><span><?php esc_html_e('Show All', 'kalles'); ?></span></button>
                <?php foreach( $lists as $key => $list ) : ?>
                    <button class="cg btn-t4s btn-t4s-haschild" data-filter=".filter_<?php echo esc_attr( $key ); ?>"><span><?php echo esc_html( strtoupper( $key ) ); ?></span></button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="brands_page_holder row js_isotope nt_isotope" data-isotope='{ "itemSelector": ".brands_page_item", "layoutMode": "masonry","columnWidth":".grid-sizer" }'>
            <div class="col-6 col-md-6 col-lg-3 grid-sizer"></div>
            <?php foreach( $lists as $key => $list ) : ?>
            <div class="brands_page_item col-6 col-md-6 col-lg-3 filter_allt4s filter_<?php echo esc_attr( $key ); ?>">
                <div class="brands_page_inner">
                    <h4><?php echo esc_html( strtoupper( $key ) ); ?></h4>
                    <ul>
                        <?php foreach( $list as $link ) : ?>
                            <li><a href="<?php echo esc_url( $link['link']); ?>"><?php echo esc_html( $link['name'] ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php

	}
}

add_shortcode( 'kalles_brands', 'kalles_addons_shortcode_brands' );


