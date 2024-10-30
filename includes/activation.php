<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add the default option values on initial activation
 *
 */
function cc_caboodle_activation() {
	add_option( 'cc_caboodle', cc_caboodle_initial_values() );
}

add_action( 'init', 'cc_caboodle_update' );