<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Sanitize function for checkbox
 *
 */
function cc_caboodle_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

/**
 * Sanitize function for limit revisions
 *
 */
function cc_caboodle_sanitize_limit_revisions_qty( $input ) {

	$allowedvalues = array( -1, 0, 1, 2, 3, 4, 5, 10, 25, 50 );

	if ( in_array( $input, $allowedvalues ) ) {
		return $input;
	} else {
		// return default. -1 means unlimited in this context
		return -1;
	}
}


/**
 * Sanitize function for external link icon (radio img select)
 *
 */
function cc_caboodle_sanitize_extlink_icon( $input ) {

	$allowedvalues = array( '\\f08e', '\\e80f', '\\f14c', '\\e80e', '\\e80d', '\\e80b', '\\e80c', '\\e80a', '\\e809', '\\e807', '\\e808', '\\e806' );

	if ( in_array( $input, $allowedvalues ) ) {
		return $input;
	} else {
		// return default
		return '\\f08e';
	}
}


/**
 * Sanitize function for scrolltop icon (radio img select)
 *
 */
function cc_caboodle_sanitize_scrolltop_icon( $input ) {

	$allowedvalues = array( '\\f106', '\\e803', '\\e80a', '\\f077', '\\e801', '\\e808', '\\f0d8', '\\e802', '\\e809', '\\f062', '\\e800', '\\e807', '\\f357', '\\e806', '\\e80d', '\\f176', '\\e804', '\\e80b', '\\f30c', '\\e805', '\\e80c' );

	if ( in_array( $input, $allowedvalues ) ) {
		return $input;
	} else {
		// return default
		return '\\f08e';
	}
}


/**
 * Sanitize function for Posts (select)
 *
 */
function cc_caboodle_sanitize_posts( $input ) {

	$allowedvalues = array( '', 'remove', 'rename_news' );

	if ( in_array( $input, $allowedvalues ) ) {
		return $input;
	} else {
		return '';
	}
}


/**
 * Sanitize function for external link icon height: range 0.5 to 1.5 (Default step 0.05) (range with value)
 *
 */
function cc_caboodle_sanitize_extlink_size( $input ) {
	if  ( ( $input >= 10 ) && (  $input <= 36 ) ) {
		return absint( $input );
	} else {
		return 16;
	}
}

/**
 * Sanitize function for vertical position: range -1 to 1 (Default step 0.1) (range with value)
 *
 */
function cc_caboodle_sanitize_extlink_vpos( $input ) {
	if ( ( intval($input ) == $input ) && ( $input >= -8 ) && (  $input <= 24 ) ) {
		return intval( $input );
	} else {
		return 0;
	}
}

/**
 * Sanitize function for passvis salt
 * check whether $input is a valid number in hex notation, and the string length matches the value of $length if $length is specified
 */
function cc_caboodle_passvis_sanitize_salt( $input ) {
	if ( ctype_xdigit( $input ) && ( strlen( $input ) >= 24 ) ) {
		return strtolower( $input );
	} else {
		return cc_caboodle_passvis_random_hex();
	}
}

/**
 * Sanitize hex color, but output 'currentColor' if value is empty or not a valid hex color
 *
 */
function cc_caboodle_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return 'currentColor';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	} else {
		return 'currentColor';
	}
}


/**
 * After updating the customizer, delete the pll_languages_list transient
 *
 */
function cc_caboodle_delete_transient_pll_languages_list() {

	$caboodle_setting_value = get_option( 'cc_caboodle' );

	// delete the pll_languages_list transient
	if ( $caboodle_setting_value ) {
		delete_transient( 'pll_languages_list' );
	}
}
add_action( 'customize_save_after', 'cc_caboodle_delete_transient_pll_languages_list' );


/**
 * Enable kses to be used to sanitize svg
 *
 */
if ( ! function_exists( 'cc_kses_ruleset_svg' ) ) {
 
	function cc_kses_ruleset_svg() {
		$kses_defaults = wp_kses_allowed_html( 'post' );
	
		$svg_args = array(
			'svg'   => array(
				'class'		   => true,
				'aria-hidden'	 => true,
				'aria-labelledby' => true,
				'role'			=> true,
				'xmlns'		   => true,
				'width'		   => true,
				'height'		  => true,
				'viewbox'		 => true, // <= Must be lower case!
			),
			'g'	 => array( 'fill' => true ),
			'title' => array( 'title' => true ),
			'path'  => array(
				'd'	=> true,
				'fill' => true,
			),
		);
		return array_merge( $kses_defaults, $svg_args );
	}
}