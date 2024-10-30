<?php

/**
 * Scroll to anchor
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function cc_caboodle_scroll_behaviour() {

	wp_add_inline_style( 'cc-caboodle', 'html{ scroll-behavior:smooth; }' );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_scroll_behaviour' );