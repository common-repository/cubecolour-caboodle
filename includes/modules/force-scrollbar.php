<?php

/**
 * Force scrollbar to display
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function cc_caboodle_force_scrollbar() {
	wp_add_inline_style( 'cc-caboodle', 'html{ height: 100.1%; }' );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_force_scrollbar' );