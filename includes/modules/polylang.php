<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Use SVG flags on the front end width:height ratio is 4:3
 *
 */
function cc_caboodle_pll_custom_flag( $flag, $code ) {
	$flag_width = absint( cc_caboodle( 'polylang_flag_width', 36 ) );
	$flag['url']	= CC_CABOODLE_PLUGIN_URL . "images/flags/{$code}.svg";
	$flag['width']  = absint( $flag_width );
	$flag['height'] = absint( 0.75 * $flag_width );
	return $flag;
}
add_filter( 'pll_custom_flag', 'cc_caboodle_pll_custom_flag', 10, 2 );


/**
* Add inline styles for the polylang language switcher widget/menu item
*
*/
function cc_caboodle_polylang_flags_style(){

	$flagcss = '	.widget_polylang ul {
		padding: 0.5em 0;
		white-space: nowrap;
	}
	.lang-item {
		--flag-grayscale: grayscale(' . absint( cc_caboodle( 'polylang_flag_grayscale', 80 ) ) . '%);
		--flag-opacity: ' . absint( cc_caboodle( 'polylang_flag_opacity', 50 ) ) . '%;
		display: inline-block;
		filter: var(--flag-grayscale);
		opacity: var(--flag-opacity);
		transition: 0.667s;
	}
	.lang-item:not(first-of-type) {
		margin-left: ' . ( absint( cc_caboodle( 'polylang_flag_spacing', 0 ) ) -4 ) . 'px;
	}
	.current-lang {
		filter: grayscale(0%);
		opacity: 100%;
	}
	ul:hover .current-lang:not(:hover) {
		filter: var(--flag-grayscale);
		opacity: var(--flag-opacity);
	}
	.lang-item:hover {
		filter: grayscale(0%);
		opacity: 100%;
	}

	.lang-item img {
		width: ' . absint( cc_caboodle( 'polylang_flag_width', 36 ) ) . 'px!important;
		height: auto!important;
	}';


	wp_add_inline_style( 'cc-caboodle', esc_attr( $flagcss ) );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_polylang_flags_style', 20);