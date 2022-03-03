<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

class The4_Admin_Dashboard {

	private $page = '';

	private static $api_url = 'https://wp.the4.co/api/';

	public function __construct()
	{
		$this->page = isset( $_GET['page'] ) ? $_GET['page'] : '';

		$this->register_admin_script();

		$this->load_inc();

		$this->get_view();

		$this->get_feed_news();


	}

	public function get_view()
	{
		get_template_part( 'admin/views/dashboard' );
	}

	public function load_inc()
	{
		require_once THE4_KALLES_ADMIN_PATH . '/inc/helper.php';

	}
	public function register_admin_script()
	{

		if ( $this->page == 'the4-dashboard' ) {

			wp_enqueue_style( 'kalles-admin-layout', THE4_KALLES_ADMIN_URL . '/assets/css/layout.css');
			wp_enqueue_style( 'the4-admin-style', THE4_KALLES_ADMIN_URL . '/assets/css/admin.css', [], '', 'all');
			//Google Popin font
			wp_enqueue_style( 'google-font-popin', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;800&display=swap', false);
		}

	}

	public static function get_feed_news()
	{
		$cache_key = 'the4_get_api_data_' . THE4_KALLES_VERSION;

		$data = get_transient( $cache_key );

		$time_out = 8;

		if ( ! $data ) {
			$response = wp_remote_get( self::$api_url, [
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
}

new The4_Admin_Dashboard();
 ?>