<?php
/**
 * Social login for woocommerce.
 *
 * @since   1.0.3
 * @package Kalles
 */

namespace Kalles;

defined( 'ABSPATH' ) || exit('No direct script access allowed');

class The4_Social_Auth  {

    private $socials = array( 'facebook', 'google', 'twitter');

    public function __construct()
    {   
        add_action( 'init', [ $this, 'auth_login']);
        add_action( 'init', [ $this, 'process_callback']);
    }

    public function auth_login()
    {

        if ( empty( $_GET['social_login'] ) ) {
            return;
        }

        $social_type = $this->get_social_type();
        

        if ( ! in_array( $social_type, $this->socials ) ) {
            return;
        }
        $config = $this->get_config( $social_type );

        switch ( $social_type ) {
            case 'twitter':

                try {
                    $twitter = new Hybridauth\Provider\Twitter($config);
                    
                    $twitter->authenticate();
                }

                catch (\Exception $e) {
                    echo 'Oops, we ran into an issue! ' . $e->getMessage();
                }
                break;

            case 'google':

                try {
                    $google = new Hybridauth\Provider\Google($config);

                    $google->authenticate();
                }

                catch (\Exception $e) {
                    echo 'Oops, we ran into an issue! ' . $e->getMessage();
                }
                break;
            
            default:

                try {
                    $facebook = new Hybridauth\Provider\Facebook($config);

                    $facebook->authenticate();
                }

                catch (\Exception $e) {
                    echo 'Oops, we ran into an issue! ' . $e->getMessage();
                }

                break;
        }
        
        return;
        
    }

    public function process_callback()
    {

        if ( is_user_logged_in() || empty( $_GET['t4_auth'] ) ) {
            return;
        }

        $opauth = $_GET['t4_auth'];

        switch ( $opauth) {
            case 'twitter':
                
                try {

                    $config = $this->get_config( $opauth );

                    $twitter = new Hybridauth\Provider\Twitter($config);

                    $twitter->authenticate();

                    $accessToken = $twitter->getAccessToken();
                    $userProfile = $twitter->getUserProfile();
                    
                    $email = isset( $userProfile->email ) ? $userProfile->email : '';

                    if ( empty( $email ) ) {
                        wc_add_notice( translate( 'Can\'t get email, Please try again ! ', 'kalles' ), 'error');
                        return;
                    }

                    $username = isset( $opauth->auth->info->name ) ? $opauth->auth->info->name : '';

                    $this->process_login( $email, $username );
                }
                catch (\Exception $e) {
                    wc_add_notice( translate( 'Can\'t login with Twitter, Please try again ! ', 'kalles' ), 'error');
                    return;
                }

                break;

            case 'google':
                
                try {

                    $config = $this->get_config( $opauth );

                    $google = new Hybridauth\Provider\Google($config);

                    $google->authenticate();

                    $accessToken = $google->getAccessToken();
                    $userProfile = $google->getUserProfile();
                    
                    $email = isset( $userProfile->email ) ? $userProfile->email : '';

                    if ( empty( $email ) ) {
                        wc_add_notice( translate( 'Can\'t get email, Please try again ! ', 'kalles' ), 'error');
                        return;
                    }

                    $username = isset( $opauth->auth->info->name ) ? $opauth->auth->info->name : '';

                    $this->process_login( $email, $username );
                }
                catch (\Exception $e) {
                    wc_add_notice( translate( 'Can\'t login with Twitter, Please try again ! ', 'kalles' ), 'error');
                    return;
                }

                break;
            
            default:
                
                try {

                    $config = $this->get_config( $opauth );

                    $twitter = new Hybridauth\Provider\Facebook($config);

                    $twitter->authenticate();

                    $accessToken = $twitter->getAccessToken();
                    $userProfile = $twitter->getUserProfile();
                    
                    $email = isset( $userProfile->email ) ? $userProfile->email : '';

                    if ( empty( $email ) ) {
                        wc_add_notice( translate( 'Can\'t get email, Please try again ! ', 'kalles' ), 'error');
                        return;
                    }

                    $username = isset( $opauth->auth->info->name ) ? $opauth->auth->info->name : '';

                    $this->process_login( $email, $username );
                }
                catch (\Exception $e) {
                    wc_add_notice( translate( 'Can\'t login with Twitter, Please try again ! ', 'kalles' ), 'error');
                    return;
                }
                break;
        }
    }

    public function process_login( $email, $username)
    {

        add_filter( 'dokan_register_nonce_check', '__return_false' );

        $pass = wp_generate_password();

        if (  'no' === get_option( 'woocommerce_registration_generate_password' ) ) {
            $customer = wc_create_new_customer($email, $username ,$pass);  
        } else {
            $customer = wc_create_new_customer($email, '',$pass);  
        }

        $user = get_user_by( 'email', $email );

        if ( is_wp_error( $customer ) ) {
            if ( isset( $customer->errors['registration-error-email-exists'] ) ) {
                wc_set_customer_auth_cookie( $user->ID );
            }
        } else {
            wc_set_customer_auth_cookie( $customer );
        }

    }

    public function get_account_url()
    {
        return untrailingslashit( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    }

    public function get_config( $social_type ) {

        $config = array();

        $callback_url = add_query_arg('t4_auth', $social_type, $this->get_account_url() );

        switch ( $social_type ) {
            case 'twitter':

                $tt = cs_get_option( 'woocommerce_account-social_twitter' );

                $config = [
                    'callback' => $callback_url,
                    'keys' => [
                        'key' => $tt['social_twitter-id'],
                        'secret' => $tt['social_twitter-key'],
                    ],
                ];
                break;

            case 'google':

                $tt = cs_get_option( 'woocommerce_account-social_google' );

                $config = [
                    'callback' => $callback_url,
                    'keys' => [
                        'key' => $tt['social_google-id'],
                        'secret' => $tt['social_google-key'],
                    ],
                ];
                break;
            
            default:
                
                $tt = cs_get_option( 'woocommerce_account-social_facebook' );

                $config = [
                    'callback' => $callback_url,
                    'keys' => [
                        'key' => $tt['social_facebook-id'],
                        'secret' => $tt['social_facebook-key'],
                    ]
                ];

                break;
        }

        return $config;
    }


    public function get_social_type()
    {
        $current_url = ( isset($_SERVER['HTTPS'] ) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $account_url = $this->get_account_url();

        foreach( $this->socials as $social ) {
            if ( strstr( $current_url, $social ) ) {
                return $social;
            }
        }

        return;
    }
}
