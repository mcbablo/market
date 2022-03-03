<?php
/*
 * Plugin Name: CLICK Login
 * Plugin URI: https://click.uz
 * Description: Login using CLICK partner API
 * Version: 1.0.0
 * Author: OOO "Click"
 * Author URI: https://click.uz

 * Text Domain: clickuz
 * Domain Path: /i18n/languages/

 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

define('CLICK_LOGIN_VERSION', '1.0.0');
define('CLICK_LOGIN_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    class WC_ClickuzLogin
    {
        public $plugin;

        public function __construct()
        {

            $this->plugin = plugin_basename(__FILE__);

            load_plugin_textdomain('clickuz_login', false, dirname(plugin_basename(__FILE__)) . '/i18n/languages/');

            add_filter('woocommerce_locate_template', array($this, 'locate_template'), 10, 3);

            add_action('wp_ajax_check_phone', array($this, 'check_phone'));
            add_action('wp_ajax_nopriv_check_phone', array($this, 'check_phone'));

            add_action('wp_ajax_check_otp', array($this, 'check_otp'));
            add_action('wp_ajax_nopriv_check_otp', array($this, 'check_otp'));

            add_action('wp_ajax_nopriv_click_login_auth', array($this, 'authorize'));
            add_action('wp_ajax_nopriv_click_login_register', array($this, 'register'));

            // add_filter('woocommerce_billing_fields', array($this, 'custom_woocommerce_billing_fields'));
        }

        public function locate_template($template, $template_name, $template_path)
        {
            if ('myaccount/form-login.php' == $template_name) {
                return plugin_dir_path(__FILE__) . '/templates/form-login.php';
            }

            return $template;
        }


        public function check_phone()
        {
            global $wpdb;

            $phone = $_POST['params']['phone_number'];

            $user_id = $wpdb->get_var("Select ID From {$wpdb->users} Where user_login='{$phone}'");

            if (!$user_id) {

                $payload = array(
                    "jsonrpc" => "2.0",
                    "method" => "device.register.request",
                    "params" => $_POST['params'],
                    "id" => 1
                );

                $ch = curl_init('https://api.click.uz/evo');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/json', 'accept: */*'));
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
                curl_setopt($ch, CURLOPT_SSLVERSION, 6);
                $response = curl_exec($ch);

                $response = json_decode($response, true);

                $data = array(
                    'status' => 'not-registered',
                    'result' => $response['result'],
                );

            } else {
                $data['status'] = 'registered';
            }
            echo json_encode($data);
            wp_die();
        }

        public function check_otp()
        {

            $_POST['params']['confirm_token'] = hash('sha256', $_POST['params']['device_id'] . $_POST['sms_code'] . $_POST['params']['phone_number']);
            $payload = array(
                "jsonrpc" => "2.0",
                "method" => "device.register.confirm",
                "params" => $_POST['params'],
                "id" => 1
            );

            $ch = curl_init('https://api.click.uz/evo');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('content-type: application/json', 'accept: */*'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            $response = curl_exec($ch);

            echo $response;

            wp_die();
        }

        public function authorize() {
            $creds = array(
                'user_login'    => trim( wp_unslash( $_POST['params']['phone_number'] ) ), // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
                'user_password' => $_POST['params']['password'], // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
            );

            $user = wp_signon( $creds, is_ssl() );

            if ( is_wp_error( $user ) ) {
                $response = array('error' => array(
                    'code' => $user->get_error_code(),
                    'message' => $user->get_error_message()
                ));
            } else {
                $response = array('user_id' => $user->ID);
            }
            echo json_encode($response);
            wp_die();
        }

        public function register() {
            $user_data = array(
                'user_login' => $_POST['params']['phone_number'],
                'user_pass' => $_POST['params']['password'],
                'display_name' => $_POST['params']['display_name']
            );
            $ID = wp_insert_user( $user_data);

            if( is_wp_error($ID) ) {
                $response = array('error' => array(
                    'code' => $ID->get_error_code(),
                    'message' => $ID->get_error_message()
                ));
            } else {
                wc_set_customer_auth_cookie( $ID );
                $response = array('user_id' => $ID);
            }

            echo json_encode($response);

            wp_die();
        }

    }

    new WC_ClickuzLogin();
}