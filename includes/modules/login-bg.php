<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue stylesheet
 *
 */
function cc_caboodle_login_bg() {
	wp_register_style( 'caboodle-login-bg', false, array(), CC_CABOODLE_PLUGIN_VERSION );

	$color_1 = cc_caboodle( 'login_bg_color_1', '#fff' );
	$color_2 = cc_caboodle( 'login_bg_color_2', '#fff' );

	$login_bg = 'html, body {
height: 101%; background: linear-gradient( to right, ' . $color_1 . ' calc( 50% - 190px ), ' . $color_2 . ' 0, ' . $color_2 . ' calc( 50% + 190px ), ' . $color_1 . ' 0 ); }
#login h1 { margin-top: 3em; }';

	if ( cc_caboodle( 'login_bg_borderless', false ) ) {	
		$login_bg .= '#loginform { border: 0; background-color: transparent; box-shadow: none; } #nav, #backtoblog { text-align: center; }';
	}

	wp_add_inline_style( 'caboodle-login-bg', esc_attr( $login_bg ) );
	wp_enqueue_style( 'caboodle-login-bg' );
}
add_action( 'login_enqueue_scripts', 'cc_caboodle_login_bg' );