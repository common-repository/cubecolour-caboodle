<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function cc_caboodle_integer_to_roman( $integer ) {
	
	// Convert the integer into an integer (just to make sure)
	$integer = absint( $integer );
	$result = '';
	
	// Create a lookup array that contains the Roman numerals.
	$lookup = array(
		'M'		=> 1000,
		'CM'	=> 900,
		'D'		=> 500,
		'CD'	=> 400,
		'C'		=> 100,
		'XC'	=> 90,
		'L'		=> 50,
		'XL'	=> 40,
		'X'		=> 10,
		'IX'	=> 9,
		'V'		=> 5,
		'IV'	=> 4,
		'I'		=> 1
	);
	
	foreach($lookup as $roman => $value){

		// Determine the number of matches
		$matches = intval($integer/$value);
		
		// Add the same number of characters to the string
		$result .= str_repeat($roman,$matches);
		
		// Set the integer to be the remainder of the integer and the value
		$integer = $integer % $value;
	}
	 
	 // The Roman numeral should now be built, so return it
	 return $result;
}


/**
 * Years shortcode - for years range in footer copyright
 * USAGE: [years start=2023]
 *
 */
function cc_caboodle_years_shortcode( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'start' => absint( cc_caboodle( 'years_from', gmdate('Y') ) ),
		'format' => '',
	), $atts, 'cc_caboodle' );
	
	$start = absint( $atts['start'] );
	$date = gmdate('Y');

	if ( strtolower( $atts['format'] ) == 'roman' ) {
		$start = cc_caboodle_integer_to_roman( $start );
		$date = cc_caboodle_integer_to_roman( $date );		
	}
	
	if ( $start < $date ) {
		$years = $start . '&ndash;' . $date;
	} else {
		$years = $start;
	}
	return esc_attr( $years );
}
add_shortcode( 'years', 'cc_caboodle_years_shortcode' );