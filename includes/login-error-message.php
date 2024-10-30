<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Single error message on login
 *
 */
function cc_login_error(){

	return cc_caboodle( 'login_error_message', esc_html__( 'Incorrect credentials', 'cubecolour-caboodle' ) );
}
add_filter( 'login_errors', 'cc_login_error' );