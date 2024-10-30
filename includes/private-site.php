<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Redirect to the login page if the user is not logged in
 *
 */
function cc_login_redirect() {
	global $pagenow;
	if( ( !is_user_logged_in() ) && ( $pagenow != 'wp-login.php' ) ) {
		auth_redirect();
	}
}
add_action( 'template_redirect', 'cc_login_redirect' );

/**
 * Prevent content being cached if the user is not logged in
 *
 */
function cc_caboodle_nocache() {
	if ( !is_user_logged_in() ) {
		header('Cache-Control: no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');
	}
}
add_action( "send_headers", "cc_caboodle_nocache" );