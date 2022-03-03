<?php
/**
 *  Codestar FrameWork Function
 *
 * @since   1.1.1
 * @package Kalles
 */


/**
 *  Get all woo product attributes
 *
 * @since   1.1.1
 * @return Array
 */

if ( ! function_exists('kalles_csf_get_attr') ) {
    function kalles_csf_get_attr() {
        $attributes = array();
        if ( class_exists( 'WooCommerce' ) ) {
          $attributes = array();
          $attributes_tax = wc_get_attribute_taxonomies();

          foreach ( $attributes_tax as $attribute ) {
            $attributes[ $attribute->attribute_name ] = $attribute->attribute_label;
          }
        }

        return $attributes;
    }
}
