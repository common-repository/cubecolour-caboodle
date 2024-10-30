<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Make the search placeholder translatable
*
*/
function cc_caboodle_header_cover_search_placeholder( $strings ) {

	$strings[ 'string-header-cover-search-placeholder' ] = esc_html__( 'Search', 'astra' ) . ' &hellip;';
	$strings[ 'string-full-width-search-placeholder' ] = esc_html__( 'Search', 'astra' ) . ' &hellip;';

	return $strings;
}
add_filter( 'astra_default_strings', 'cc_caboodle_header_cover_search_placeholder', 99 );
