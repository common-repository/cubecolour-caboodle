<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Replace spaces around en-dash & em-dash with hairspaces
 *
 *	hairspace:	"&#8202";
 *
 */
function cc_caboodle_replace_dash_spaces( $content ) {
	if ( cc_caboodle( 'dash_spacing', '' ) == '1' ) {
		if ($content !== null) {
			// ndash
			$content = str_replace( ' – ', '&#8202;' . '&ndash;' . '&#8202;', $content );
			$content = str_replace( ' &#150; ', '&#8202;' . '&ndash;' . '&#8202;', $content );
			$content = str_replace( ' &ndash; ', '&#8202;' . '&ndash;' . '&#8202;', $content );
		
			// mdash
			$content = str_replace( ' — ', '&#8202;' . '&mdash;' . '&#8202;', $content );
			$content = str_replace( ' &#151; ', '&#8202;' . '&mdash;' . '&#8202;', $content );
			$content = str_replace( ' &mdash; ', '&#8202;' . '&mdash;' . '&#8202;', $content );
		}
	}
	return $content;
}
add_filter( 'the_content', 'cc_caboodle_replace_dash_spaces' );