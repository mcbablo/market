<?php
/**
 * Google Map shortcode.
 *
 * @package KallesAddons
 * @since   1.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kalles_addons_shortcode_google_maps' ) ) {
	function kalles_addons_shortcode_google_maps( $atts, $content = null ) {
		$output = '';

		extract( shortcode_atts( array(
			'lat'               => '0',
			'lon'               => '0',
			'z'                 => '1',
			'w'                 => '600',
			'h'                 => '400',
			'maptype'           => 'ROADMAP',
			'mapstyle'          => '',
			'address'           => '',
			'marker'            => '',
			'markerimage'       => '',
			'traffic'           => '',
			'draggable'         => '',
			'infowindow'        => '',
			'infowindowdefault' => '',
			'hidecontrols'      => '',
			'scrollwheel'       => '',
			'class'             => ''
		), $atts ) );

		$classes = array( 'the4-gmap' );

		// Generate an unique ID.
		$id = uniqid( 'map_' );

		// Generate HTML code.
		$w     = is_numeric( $w ) ? 'width:'. esc_attr( $w ) .'px;' : 'width:'. esc_attr( $w ) .';';
		$h     = is_numeric( $h ) ? 'height:'. esc_attr( $h ) .'px;' : 'height:'. esc_attr( $h ) .';';
		$output .= '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" id="the4_' . esc_attr( $id ) . '" style="' . esc_attr( $w ) . esc_attr( $h ) . '"></div>';

		$output .= '
<scr' . 'ipt>
	(function($) {
		$(document).ready(function() {
			var latlng = new google.maps.LatLng(' . esc_js( $lat ) . ', ' . esc_js( $lon ) . ');
			var options = {
				zoom: ' . $z . ',
				center: latlng,
				mapTypeId: google.maps.MapTypeId.' . esc_js( $maptype ) . ',';

		if ( $scrollwheel == 'true' ) {
			$output .= '
				scrollwheel: true,';
		} else {
			$output .= '
				scrollwheel: false,';
		}

		if ( ! empty( $hidecontrols ) ) {
			$output .= '
				disableDefaultUI: "' . esc_js( $hidecontrols ) . '",';
		}

		switch ( $mapstyle ) {
			case 'grayscale' :
				$output .= '
				styles: [
					{"featureType": "landscape","stylers": [{"saturation": -100},{"lightness": 65},{"visibility": "on"}]},
					{"featureType": "poi","stylers": [{"saturation": -100},{"lightness": 51},{"visibility": "simplified"}]},
					{"featureType": "road.highway","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					{"featureType": "road.arterial","stylers": [{"saturation": -100},{"lightness": 30},{"visibility": "on"}]},
					{"featureType": "road.local","stylers": [{"saturation": -100},{"lightness": 40},{"visibility": "on"}]},
					{"featureType": "transit","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					{"featureType": "administrative.province","stylers": [{"visibility": "off"}]},
					{"featureType": "water","elementType": "labels","stylers": [{"visibility": "on"},{"lightness": -25},{"saturation": -100}]},
					{"featureType": "water","elementType": "geometry","stylers": [{"hue": "#ffff00"},{"lightness": -25},{"saturation": -97}]}
				]';
			break;

			case 'blue_water' :
				$output .= '
				styles: [
					{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},
					{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},
					{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},
					{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},
					{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},
					{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
					{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},
					{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}
				]';
			break;

			case 'pale_dawn' :
				$output .= '
				styles: [
					{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},
					{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},
					{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},
					{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},
					{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},
					{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},
					{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},
					{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},
					{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}
				]';
			break;

			case 'shades_of_grey' :
				$output .= '
				styles: [
					{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},
					{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},
					{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
					{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},
					{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},
					{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},
					{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},
					{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},
					{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},
					{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},
					{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},
					{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},
					{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}
				]';
			break;
		}

		$output .= '
			};

			var ' . esc_js( $id ) . ' = new google.maps.Map(document.getElementById("the4_' . esc_js( $id ) . '"), options);';

		// Traffic
		if ( $traffic == 'true' ) {
			$output .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . esc_js( $id ) . ');';
		}

		// Address
		if ( ! empty( $address ) ) {
			$output .= '
			var geocoder_' . esc_js( $id ) . ' = new google.maps.Geocoder();
			var address = \'' . esc_js( $address ) . '\';
			geocoder_' . esc_js( $id ) . '.geocode({\'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . esc_js( $id ) . '.setCenter(results[0].geometry.location);';

			if ( $marker == 'true' ) {
				// Add custom image
				if ( ! empty( $markerimage ) && is_numeric( $markerimage ) ){
					$output .= '
					var image = "' . wp_get_attachment_url( $markerimage ) . '";';
				} elseif ( ! empty( $markerimage ) ) {
					$output .= '
					var image = "' . esc_js( $markerimage ) . '";';
				}

				$output .= '
					var marker = new google.maps.Marker({
						map: ' . esc_js( $id ) . ',';
				if ( $draggable == 'true' ) {
					$output .= '
						draggable: true,';
				}

				if ( ! empty( $markerimage ) ) {
					$output .= '
						icon: image,';
				}

				$output .= '
						position: ' . esc_js( $id ) . '.getCenter()
					});';

				// Info window
				if ( ! empty( $infowindow ) ) {
					// First convert and decode html chars
					$thiscontent = htmlspecialchars_decode( $infowindow );
					$output .= '
					var contentString = \'' . $thiscontent . '\';
					var infowindow = new google.maps.InfoWindow({
						content: contentString
					});
					google.maps.event.addListener(marker, \'click\', function() {
						infowindow.open(' . esc_js( $id ) . ',marker);
					});';

					// Show info window by default
					if ( $infowindowdefault == 'true' ) {
						$output .= '
					infowindow.open(' . esc_js( $id ) . ',marker);';
					}
				}
			}

			$output .= '
					} else {
					alert("Rendering address failed with following reason: " + status);
				}
			});';
		}

		// Marker: show if address is not specified
		if ( $marker == 'true' && empty( $address ) ) {
			// Add custom image
			if ( ! empty( $markerimage ) && is_numeric( $markerimage ) ){
				$output .= '
			var image = "'. wp_get_attachment_url( $markerimage ) .'";';
			} elseif ( ! empty( $markerimage ) ){
				$output .= '
			var image = "'. esc_js( $markerimage ) .'";';
			}

			$output .= '
			var marker = new google.maps.Marker({
				map: ' . esc_js( $id ) . ',';

			if ( $draggable == 'true' ) {
				$output .= '
				draggable: true,';
			}

			if ( ! empty ( $markerimage ) ) {
				$output .= '
				icon: image,';
			}

			$output .= '
				position: ' . esc_js( $id ) . '.getCenter()
			});';

			// Info window
			if ( ! empty( $infowindow ) ) {
				$output .= '
			var contentString = \'' . esc_js( $infowindow ) . '\';
			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});
			google.maps.event.addListener(marker, \'click\', function() {
			  infowindow.open(' . esc_js( $id ) . ',marker);
			});';

				// Show info window by default
				if ( $infowindowdefault == 'true' ) {
					$output .= '
			infowindow.open(' . esc_js( $id ) . ',marker);';
				}
			}
		}

		$output .= '
		});
	})(jQuery);
</scr' . 'ipt>';

		// Return output
		return apply_filters( 'kalles_addons_shortcode_google_maps', force_balance_tags( $output ) );
	}
}