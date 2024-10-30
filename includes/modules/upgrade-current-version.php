<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* show the current WP Version when the Upgrade Message is shown in admin footer
*
*/
function cc_caboodle_current_version_update_available( $text ) {

	$current_version_txt = esc_attr__( 'Current Version' , 'cubecolour-caboodle' );

	if ( preg_match('|update\-core\.php|', $text) ) {

		global $wp_version;
		$text .= ' &mdash; ' . $current_version_txt . ': ' . $wp_version;
	}
	return wp_kses($text, array(
	'a' => array(
		'href' => array(),
		'title' => array(),
		'target' => array()
	),
	'strong' => array()
));

}
add_filter('update_footer', 'cc_caboodle_current_version_update_available', 11);