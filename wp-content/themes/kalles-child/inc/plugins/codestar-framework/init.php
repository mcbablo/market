<?php
/**
 * Initialize Codestar FrameWork
 *
 * @since   1.0.0
 * @package Kalles
 */

if ( class_exists( 'CSF' ) && is_admin() ) {
  // include config file
  require THE4_KALLES_CS_FRAMEWORK_PATH . '/csf-function.php';
  require THE4_KALLES_CS_FRAMEWORK_PATH . '/config/white-label.php';
  require THE4_KALLES_CS_FRAMEWORK_PATH . '/config/admin-options.php';
  require THE4_KALLES_CS_FRAMEWORK_PATH . '/config/megamenu-options.php';
  require THE4_KALLES_CS_FRAMEWORK_PATH . '/config/metabox.config.php';
  require THE4_KALLES_CS_FRAMEWORK_PATH . '/config/taxonomy.config.php';
}


if ( ! function_exists( 't4_white_label' ) ) {
  function t4_white_label( $option, $default_value ) {
    $white_label = get_option( '_kalles_options_white_label' );
    return ( isset( $white_label[ $option] ) && ! empty( $white_label[ $option] ) ) ? $white_label[ $option] : $default_value;
  }
}
if ( ! function_exists( 'cs_get_option' ) ) {
  function cs_get_option( $option = '', $default = null ) {

      $options = get_option( '_kalles_options' ); // Attention: Set your unique id of the framework
      return ( isset( $options[$option] ) ) ? $options[$option] : $default;
  }
}
if ( ! function_exists( 'cs_set_option' ) ) {
  function cs_set_option( $option_name = '', $new_value = '' ) {

    $options = apply_filters( 'cs_set_option', get_option( '_kalles_options' ), $option_name, $new_value );

    if( ! empty( $option_name ) ) {
      $options[$option_name] = $new_value;
      update_option( '_kalles_options', $options );
    }
  }
}

