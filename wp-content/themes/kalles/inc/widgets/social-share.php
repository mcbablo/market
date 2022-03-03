<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

if ( class_exists( 'CSF' ) ) {
	CSF::createWidget( 'kalles_w_social', array(
	  'title'       => 'Kalles Social',
	  'classname'   => 'wrap_social',
	  'description' => 'Display social networks',
	  'fields'      => array(

	    array(
		  'id'         => 'w_social-title',
		  'type'       => 'text',
		  'title'      => translate('Title' , 'kalles'),
		  'default'    => ''
		),
		array(
		  'id'          => 'w_social-type',
		  'type'        => 'select',
		  'title'       => translate('Social type' , 'kalles'),
		  'options'     => array(
			'follow'     => 'Follow',
			'share'   => 'Share',
		  ),
		  'default'     => 'follow'
		),
	  )
	) );

	if ( ! function_exists( 'kalles_w_social' ) ) {
	  function kalles_w_social( $args, $instance ) {

	    The4Helper::ksesHTML( $args['before_widget'] );

		if ( ! empty( $instance[ 'w_social-title' ] ) ) {
	  		echo '<h4 class="widget-title fwm">' . $instance['w_social-title'] . '</h4>';
	  	}
	    if ( $instance['w_social-type'] == 'share' ) {
	    	the4_kalles_social_share();
	    } else {
	    	echo the4_kalles_social();
	    }
	   
	    The4Helper::ksesHTML( $args['after_widget'] );

	  }
	}
}
