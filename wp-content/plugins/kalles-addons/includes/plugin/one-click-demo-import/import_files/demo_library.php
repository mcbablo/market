<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

function the4_get_demo_library()
{
	$cache_key = 'the4_get_demo_library' . THE4_KALLES_VERSION;

	$data = get_transient( $cache_key );

	$time_out = 8;

	$api_url = 'https://wp.the4.co/api_demo/';

	if ( ! $data ) {
		$response = wp_remote_get( $api_url, [
			'timeout' => $time_out,
			'body' => [
				'api_version' => THE4_KALLES_VERSION
			]
		] );
		
		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

			return false;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $data ) || ! is_array( $data ) ) {
			
			set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

			return false;
		}

		set_transient( $cache_key, $data, 12 * HOUR_IN_SECONDS );

	}
	
	return $data;
}