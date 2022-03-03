<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.
/**
 * Theme Options.
 *
 * @since   1.0.0
 * @package Kalles
 */


// Social config
CSF::createSection( $prefix, array(
  'id'     => 'social',
  'title'  => esc_html__( 'Social Network', 'kalles' ),
  'icon'   => 'fas fa-globe',
  'fields' => array(
    array(
      'id'              => 'social-network',
      'type'            => 'group',
      'title'           => esc_html__( 'Social Account', 'kalles' ),
      'button_title'    => esc_html__( 'Add New', 'kalles' ),
      'accordion_title' => esc_html__( 'Add New Social Network', 'kalles' ),
      'fields'          => array(
        array(
          'id'    => 'link',
          'type'  => 'text',
          'title' => esc_html__( 'URL', 'kalles' ),
        ),
        array(
          'id'    => 'icon',
          'type'  => 'icon',
          'title' => esc_html__( 'Icon', 'kalles' ),
        ),
        array(
          'id'      => 'color',
          'type'    => 'color',
          'title'   => esc_html__( 'Icon color when hover', 'kalles' ),
        ),
      )
    ),
    array(
      'type'    => 'subheading',
      'content' => esc_html__('Social Share Setting', 'kalles'),
    ),
    array(
      'id'      => 'wc-social-share',
      'type'    => 'switcher',
      'title'   => esc_html__( 'Enable Social Share', 'kalles' ),
      'default' => true,
    ),
    array(
      'id'         => 'wc-social-share-type',
      'type'       => 'button_set',
      'title'      => esc_html__( 'Share source', 'kalles' ),
      'default'    => 'default',
      'options' => array(
        'default' => esc_html__( 'Kalles Theme', 'kalles' ),
        'addthis' => esc_html__( 'Addthis', 'kalles' ),
      ),
    ),
    array(
      'id'      => 'wc-social-share-addthis_id',
      'type'    => 'text',
      'title'   => esc_html__( 'Addthis ID', 'kalles' ),
      'default' => 'ra-56efaa05a768bd19',
      'desc'    => 'Visit <a href="https://www.addthis.com/">Addthis</a> to get ID',
      'dependency' => array('wc-social-share-type', '==', 'addthis'),
    ),
    array(
      'id'         => 'wc-social-share-option',
      'type'       => 'checkbox',
      'title'      => esc_html__( 'Enable Share', 'kalles' ),
      'default'    => array('facebook', 'tweet', 'pinterest', 'tumblr', 'email'),
      'options' => array(
        'facebook' => esc_html__( 'Share on Facebook', 'kalles' ),
        'tweet' => esc_html__( 'Tweet on Twitter', 'kalles' ),
        'pinterest' => esc_html__( 'Pin on Pinterest', 'kalles' ),
        'tumblr' => esc_html__( 'Pin on Tumblr', 'kalles' ),
        'email' => esc_html__( 'Share on Email', 'kalles' ),
        'telegram' => esc_html__( 'Share on Telegram', 'kalles' ),
        'whatsapp' => esc_html__( 'Share on WhatsApp', 'kalles' ),
      ),
      'dependency' => array('wc-social-share-type', '==', 'default'),
    ),
    array(
        'id'          => 'wc-social-share-align',
        'type'        => 'button_set',
        'title'       => esc_html__( 'Social Align', 'kalles' ),
        'options'     => array(
          'tl'     => esc_html__( 'Left', 'kalles' ),
          'tc'     => esc_html__( 'Center', 'kalles' ),
          'tr'     => esc_html__( 'Right', 'kalles' ),
        ),
        'default'        => 'tc',
    )
  ),
) );