<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* show the current WP Version when the Upgrade Message is shown in admin footer
*
*/
function cc_current_version_update_available( $text ) {

	$current_version_txt = esc_html__( 'Current Version' , 'cubecolour-caboodle' );

	if ( preg_match('|update\-core\.php|', $text) ) {
		global $wp_version;
		$text .= ' (' . $current_version_txt . ': ' . $wp_version . ')';
	}
    return esc_html( $text );
}
add_filter('update_footer', 'cc_current_version_update_available', 11);