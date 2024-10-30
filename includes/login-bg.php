<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue stylesheet
 *
 */
function cc_login_bg() {
	wp_register_style( 'caboodle-login-bg', NULL );

	$color_1 = cc_caboodle( 'login_bg_color_1', '#fff' );
	$color_2 = cc_caboodle( 'login_bg_color_2', '#fff' );

	$login_bg = 'html, body {
height: 101%; background: linear-gradient( to right, ' . $color_1 . ' calc( 50% - 190px ), ' . $color_2 . ' 0, ' . $color_2 . ' calc( 50% + 190px ), ' . $color_1 . ' 0 ); }
#login h1 { margin-top: 3em; }';
	wp_add_inline_style( 'caboodle-login-bg', esc_attr( $login_bg ) );
	wp_enqueue_style( 'caboodle-login-bg' );
}
add_action( 'login_enqueue_scripts', 'cc_login_bg' );