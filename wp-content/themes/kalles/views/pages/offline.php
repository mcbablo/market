<?php

/* Template name: offline */

// Get the time
$date  = cs_get_option( 'maintenance-date' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html"/>
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="the4-wrapper">
			<div class="the4-offline-content flex middle-xs center-xs">
				<div class="inner cw">
					<h1><?php echo wp_kses_post( cs_get_option( 'maintenance-title' ) ); ?></h1>
					<h3><?php echo wp_kses_post( cs_get_option( 'maintenance-message' ) ); ?></h3>
					<p><?php echo wp_kses_post( cs_get_option( 'maintenance-content' ) ); ?></p>

					<?php if ( cs_get_option( 'maintenance-countdown' ) ) : ?>
						<div class="the4-countdown" data-time='<?php echo esc_attr( $date ); ?>'></div>
					<?php endif; ?>
				</div>
			</div><!-- .the4-offline -->
		</div><!-- #the4-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>