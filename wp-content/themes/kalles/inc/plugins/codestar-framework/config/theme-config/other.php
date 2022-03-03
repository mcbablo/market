<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */

// Custom CSS, JS
CSF::createSection( $prefix, array(
  'id'     => 'custom_css_js',
  'title'  => esc_html__( 'Custom CSS, JS', 'kalles' ),
  'icon'   => 'fas fa-code',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Custom CSS, JS', 'kalles' ),
    ),
    array(
      'id'       => 'custom-css',
      'type'     => 'code_editor',
      'title'    => esc_html__( 'Custom CSS Style', 'kalles' ),
      'desc'     => esc_html__( 'Paste your CSS code here. Do not place any &lt;style&gt; tags in these areas as they are already added for your convenience', 'kalles' ),
      'sanitize' => 'html',
      'settings' => array(
        'theme'  => 'mbo',
        'mode'   => 'css',
      ),
    ),
    array(
      'id'       => 'custom-js',
      'type'     => 'code_editor',
      'title'    => esc_html__( 'Custom JS Code', 'kalles' ),
      'desc'     => esc_html__( 'Paste your Javscript code here. You can add your Google Analytics Code here. Do not place any &lt;script&gt; tags in these areas as they are already added for your convenience.', 'kalles' ),
      'sanitize' => 'html',
      'settings' => array(
        'theme'  => 'dracula',
        'mode'   => 'javascript',
      ),
    ),
  )
) );


// Other config
CSF::createSection( $prefix, array(
  'id'     => 'other',
  'title'  => esc_html__( 'Maintenance Mode', 'kalles' ),
  'icon'   => 'fas fa-power-off',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Maintenance Mode', 'kalles' ),
    ),
    array(
      'id'    => 'maintenance',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable Maintenance Mode', 'kalles' ),
      'desc'  => esc_html__( 'Put your site is undergoing maintenance, only admin can see the front end', 'kalles' ),
    ),
    array(
      'id'      => 'maintenance-type',
      'type'    => 'button_set',
      'title'   => esc_html__( 'Maintenance type', 'kalles' ),
      'desc'   => esc_html__( 'if you select Page, you need create new page and choose \'offline\' template attribute ', 'kalles' ),
      'options' => array(
          'page' => esc_html__( 'Page', 'kalles' ),
          'custom' => esc_html__( 'Custom', 'kalles' ),
      )
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__( 'Maintenance Mode Custom', 'kalles' ),
    ),
    array(
      'id'         => 'maintenance-bg',
      'type'       => 'background',
      'title'      => esc_html__( 'Background', 'kalles' ),
    ),
    array(
      'id'         => 'maintenance-title',
      'type'       => 'text',
      'title'      => esc_html__( 'Title', 'kalles' ),
      'default'    => esc_html__( 'Sorry, we down for maintenance.', 'kalles' ),
    ),
    array(
      'id'         => 'maintenance-message',
      'type'       => 'wp_editor',
      'title'      => esc_html__( 'Message', 'kalles' ),
      'default'    => esc_html__( 'Fortunately only for a short while.', 'kalles' ),
    ),
    array(
      'id'         => 'maintenance-content',
      'type'       => 'textarea',
      'title'      => esc_html__( 'Extra Content', 'kalles' ),
      'desc'       => esc_html__( 'This content will be put at right bottom, HTML is allowed', 'kalles' ),
    ),
    array(
      'id'    => 'maintenance-countdown',
      'type'  => 'switcher',
      'title' => esc_html__( 'Enable Countdown', 'kalles' ),
    ),
    array(
      'id'       => 'maintenance-date',
      'type'     => 'date',
      'title'    => 'Maintenance date',
      'settings' => array(
        'dateFormat'      => 'yy/mm/dd',
        'changeMonth'     => true,
        'changeYear'      => true,
        'showWeek'        => true,
        'showButtonPanel' => true,
        'weekHeader'      => 'Week',
        'monthNamesShort' => array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ),
        'dayNamesMin'     => array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
      )
    ),
   
  ),
) );

// Backup section
CSF::createSection( $prefix, array(
  'id'     => 'backup_section',
  'title'  => esc_html__( 'Backup', 'kalles' ),
  'icon'   => 'fas fa-shield-alt',
  'fields' => array(
    array(
      'type'    => 'heading',
      'content' => esc_html__( 'Backup', 'kalles' ),
    ),
    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => esc_html__( 'You can save your current options. Download a Backup and Import.', 'kalles' ),
    ),
    array(
        'type' => 'backup',
    ),
  )
) );