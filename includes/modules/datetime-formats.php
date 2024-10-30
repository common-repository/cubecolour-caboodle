<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add a new date format which can be selected on the General Settings page.
 *
 *
 */
function cc_caboodle_add_custom_date_format( $formats ) {

	// Add the custom format 'l jS F Y' to the end of the array
	$formats[] = 'l jS F Y';

	return $formats;
}

add_filter( 'date_formats', 'cc_caboodle_add_custom_date_format' );


/**
 * Add a new time format which can be selected on the General Settings page.
 *
 *
 */
function add_custom_time_format( $formats ) {
	// Add the custom format 'g:ia' to the end of the array
	$formats[] = 'g:ia';

	return $formats;
}

add_filter( 'time_formats', 'add_custom_time_format' );