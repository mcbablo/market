<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 *
 * Convert memory to byte
 * 
 */
function the4_admin_convert_to_byte ($memory)
{
    $label   = substr( $memory, -1 );
    $num = substr( $memory, 0, -1 );
    $num = the4_convert_string2int( $num );
    $num =  floatval($num);
    switch ( strtoupper( $label ) ) {
        case 'P':
            $num *= 1024;
        case 'T':
            $num *= 1024;
        case 'G':
            $num *= 1024;
        case 'M':
            $num *= 1024;
        case 'K':
            $num *= 1024;
    }

    return $num;
}

/**
 *
 * Convert String to Int
 * 
 */

function the4_convert_string2int($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);

    return str_replace($persian, $num, $string);
}

/**
 *
 * System status function
 * 
 */

function the4_admin_get_system_status() {
    $system_status = array();

    //Upload max size
    
    $upload_max_size = ini_get('upload_max_filesize');

    $upload_max_size_to_byte = the4_admin_convert_to_byte( $upload_max_size );

    array_push(
        $system_status,
        [
            'title' => esc_attr__( 'Upload max file size (64MB)', 'kalles' ),
            'status' => $upload_max_size_to_byte >= 67108864,
            'help_link' => 'https://the4.co/how-to-increase-php-max-upload-size/'
        ]
    );

    //Limit memory
    
    $memory_limit = ini_get( 'memory_limit' );
    $memory_limit_to_byte = the4_admin_convert_to_byte( $memory_limit );

    array_push(
        $system_status,
        [
            'title' => esc_attr__( 'Memory limit (256MB)', 'kalles' ),
            'status' => $memory_limit_to_byte >= 268435456,
            'help_link' => 'https://the4.co/increasing-the-wordpress-memory-limit/'
        ]
    );

    //Post maxsize
    
    $post_maxsite = ini_get( 'post_max_size' );
    $post_maxsite_to_byte = the4_admin_convert_to_byte( $post_maxsite );

    array_push(
        $system_status,
        [
            'title' => esc_attr__( 'Post max size (64MB)', 'kalles' ),
            'status' => $post_maxsite_to_byte >= 67108864,
            'help_link' => 'https://the4.co/how-to-increase-the-maximum-file-upload-size-in-wordpress/'
        ]
    );

    //Max execution time
    
    $max_exe_time = ini_get( 'max_input_vars' );

    array_push(
        $system_status,
        [
            'title' => esc_attr__( 'Max input vars (3000)', 'kalles' ),
            'status' => ini_get( 'max_input_vars' ) >= 3000,
            'help_link' => 'https://the4.co/how-to-increase-max-input-vars/'
        ]
    );

    //XML reader

    array_push(
        $system_status,
        [
            'title' => esc_attr__( 'XML Reader', 'kalles' ),
            'status' => ( ( class_exists( 'XMLReader' ) ) || ( function_exists( 'simplexml_load_file' ) ) ) ? true : false,
            'help_link' => 'http://the4.co'
        ]
    );

    return $system_status;
}

