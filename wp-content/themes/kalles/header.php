<?php
/**
 * The header for our theme.
 *
 * @since   1.0.0
 * @package Kalles
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="dns-prefetch" href="https://fonts.googleapis.com" crossorigin>
	    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
	    <link rel="dns-prefetch" href="https://fonts.gstatic.com" crossorigin>
		<?php wp_head(); ?>
	</head>
		<body <?php body_class(); ?> <?php the4_kalles_schema_metadata( array( 'context' => 'body' ) ); ?>>
			<?php
				if ( function_exists( 'wp_body_open' ) ) {
				    wp_body_open();
				} else {
				    do_action( 'wp_body_open' );
				}
			?>
        <!-- Top loading bar -->
        <div id="ld_cl_bar" class="op__0 pe_none"></div>
		<div id="the4-wrapper">
			<?php the4_kalles_header(); ?>