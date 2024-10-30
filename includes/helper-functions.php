<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Return a value from the array stored in the cc_caboodle option value
 *
 */
function cc_caboodle( $name, $default = false ) {

	$caboodle_options = ( get_option( 'cc_caboodle' ) ) ? get_option( 'cc_caboodle' ) : null;

	/**
	 * return the option value if it exists, else return the default value for the option
	 *
	 */
	if ( isset( $caboodle_options[ $name ] ) ) {
		return $caboodle_options[ $name ];
	} else {
		return $default;
	}
}
	

/**
 * Update a single value in the cc_caboodle options array
 *
 */
function cc_caboodle_update_option_value( $option, $value ) {

	if( isset( $option ) && isset( $value ) ) {

		//* Get the entire array
		$cc_caboodle_options = get_option( 'cc_caboodle' );

		//* Update the single option in the array with the require value
		$cc_caboodle_options[ $option ] = $value;

		//* save the updated array to the option
		update_option( 'cc_caboodle', $cc_caboodle_options) ;
	}
}



/**
 * Strip the protocol from domain URL
 *
 */
function cc_caboodle_strip_domain_protocol() {
	return str_replace( array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' ), '', site_url() );
}


/**
 * Generate a random hexadecimal number
 * outputs 32 characters if no $chars value is specified
 * Used to set a random hexadecimal salt when the plugin is first activated
 *
 */
function cc_caboodle_passvis_random_hex( $chars = 32 ) {

	$characters  = 'abcdef0123456789';
	$hex = '';

	for ( $i = 1; $i <= $chars; $i++ ) {
		$position = wp_rand( 0, strlen( $characters ) - 1 );
		$hex .= $characters[ $position ];
	}
	return $hex;
}


/**
 * Sanitize array values
 *
 */
function cc_caboodle_sanitize_array_values( $input_array) {

	// Initialize the new array that will hold the sanitized values
	$clean_array = array();

	// Loop through the input and sanitize each of the values
	foreach ( $input_array as $key => $val ) {

		$clean_array[ $key ] = ( isset( $input_array[ $key ] ) ) ? sanitize_text_field( $val ) : '';
	}
	return $clean_array;
}

/**
 * Escape array values
 *
 */
function cc_caboodle_esc_array_values( $input_array) {

	// Initialize the new array that will hold the escaped values
	$clean_array = array();

	// Loop through the input and escape each of the values
	foreach ( $input_array as $key => $val ) {

		$clean_array[ $key ] = ( isset( $input_array[ $key ] ) ) ? esc_attr( $val ) : '';
	}
	return $clean_array;
}


/**
 * Sanitize width: must be positive integer between 170 & 700
 *
 */
function cc_caboodle_sanitize_width( $width ) {

	// If width is a positive integer within the range 170 to 700, return it as is
	if (is_numeric($width) && (int)$width >= 170 && (int)$width <= 700) {
		return (int)$width;
	}

	// If width is not a positive integer within the range, return a default value of 700
	return 700;

}

/**
 * Sanitize boolean: can be true or false
 *
 */
function cc_caboodle_sanitize_boolean( $value ) {
	return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
}


/**
 * For troubleshooting - write to the error log
 *
 * write_log( 'CUSTOM DEBUG' );
 * write_log( $log_something );
 *
 */
if (!function_exists('write_log')) {

	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if (is_array($log) || is_object($log)) {
				error_log(print_r($log, true));
			} else {
				error_log($log);
			}
		}
	}
}