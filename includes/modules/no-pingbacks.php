<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * No Pingbacks
 *
 */
function cc_caboodle_no_pingbacks( &$links ) {

	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, get_option( 'home' ) ) )
			unset( $links[$l] );
}
add_action( 'pre_ping', 'cc_caboodle_no_pingbacks' );