<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Send a 404 status code for all feeds and loads the 404.php template
 *
 */
function cc_caboodle_feed_404() {
	
	if ( is_feed() ) {
		status_header( '404' );
		locate_template( array ( '404.php', 'index.php ' ), TRUE, TRUE );
		exit;
	}
}
add_action( 'template_redirect', 'cc_caboodle_feed_404', 1 );

/**
 * Remove links to feed from the header.
 *
 */
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );