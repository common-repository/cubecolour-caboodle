<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * No Shortlinks
 *
 */
function cc_cabooddle_remove_shortlink() {
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0);
}
add_action( 'wp_head', 'cc_cabooddle_remove_shortlink', 1 );