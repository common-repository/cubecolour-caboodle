<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue stylesheet
 *
 */
function cc_caboodle_login_warning_style() {
	wp_enqueue_style( 'login-warning', CC_CABOODLE_PLUGIN_URL . 'css/login-warning.css', false, CC_CABOODLE_PLUGIN_VERSION, 'screen' );
}
add_action( 'login_enqueue_scripts', 'cc_caboodle_login_warning_style' );

/**
 * Login Warning
 *
 */
function cc_caboodle_login_warning_banner(){

	echo '<div class="login-warning"><h2 style="color:' . esc_attr( cc_caboodle( 'login_warning_color','#777777' ) ) . '">' .
	esc_html( cc_caboodle( 'login_warning_heading', esc_html__( 'Authorised access only', 'cubecolour-caboodle' ) ), 'cubecolour-caboodle' ) . '</h2><p style="color:' . esc_attr( cc_caboodle( 'login_warning_color','#777777' ) ) . '">' . esc_html( cc_caboodle( 'login_warning_text', esc_html__( 'Disconnect immediately and do not attempt to log in if you are not an authorised user', 'cubecolour-caboodle' ) ), 'cubecolour-caboodle' ) . '</p></div>';

}
add_action('login_form', 'cc_caboodle_login_warning_banner', 20);




