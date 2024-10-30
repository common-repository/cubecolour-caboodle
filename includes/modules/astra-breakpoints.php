<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Change the Astra mobile breakpoint
 * - https://wpastra.com/docs/set-update-breakpoints-tablet-mobile-in-astra/
 */
function cc_caboodle_breakpoint_mobile() {
	return absint( cc_caboodle( "breakpoint_mobile", 544 ) );
}
add_filter( 'astra_tablet_breakpoint', 'cc_caboodle_breakpoint_mobile' );


/**
 * Change the Astra tablet breakpoint
 *
 */
function cc_caboodle_breakpoint_tablet() {
	return absint( cc_caboodle( "breakpoint_tablet", 921 ) );
}
add_filter( 'astra_tablet_breakpoint', 'cc_caboodle_breakpoint_tablet' );