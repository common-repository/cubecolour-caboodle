<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue stylesheet on login page
 * This is applied to all devices as iPad identifies itself as Mac on iPadOS 13+
 *
 */
function cc_password_mask() {
	wp_enqueue_style( 'password-mask', CC_CABOODLE_PLUGIN_URL . 'css/password-mask.css', false, CC_CABOODLE_PLUGIN_VERSION, 'screen' );
}
add_action( 'login_enqueue_scripts', 'cc_password_mask' );