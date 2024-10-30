<?php

/**
 * Anti clickjack Header
 *
 */
function cc_caboodle_anti_clickjack_header() {
	if ( !is_customize_preview() ) {
		header( "X-Frame-Options: SAMEORIGIN" );
		header( "Content-Security-Policy: frame-ancestors 'none'" );
	}
}
add_action( "send_headers", "cc_caboodle_anti_clickjack_header" );
