<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add Support for manual excerpts in pages
 *
 */
function cc_add_page_excerpt_support() {
	add_post_type_support( 'page', array( 'excerpt' ) );
}
add_action( 'init', 'cc_add_page_excerpt_support' );
