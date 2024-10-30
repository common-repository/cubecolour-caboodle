<?php

/**
 * Anti clickjack Header
 *
 */
function cc_anti_clickjack_header() {
	if ( !is_customize_preview() ) {
		header( "X-Frame-Options: SAMEORIGIN" );
		header( "Content-Security-Policy: frame-ancestors 'none'" );
	}
}
add_action( "send_headers", "cc_anti_clickjack_header" );
