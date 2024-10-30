<?php


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Replace spaces around ndash & mdash with hairspaces
 *
 *	hairspace:	"&#8202";
 *
 */
function cc_caboodle_replace_dash_spaces( $text ) {

	// ndash
	$text = str_replace( ' – ', '&#8202;' . '&ndash;' . '&#8202;', $text );
	$text = str_replace( ' &#150; ', '&#8202;' . '&ndash;' . '&#8202;', $text );
	$text = str_replace( ' &ndash; ', '&#8202;' . '&ndash;' . '&#8202;', $text );

	// mdash
	$text = str_replace( ' — ', '&#8202;' . '&mdash;' . '&#8202;', $text );
	$text = str_replace( ' &#151; ', '&#8202;' . '&mdash;' . '&#8202;', $text );
	$text = str_replace( ' &mdash; ', '&#8202;' . '&mdash;' . '&#8202;', $text );

	return $text;
}
add_filter( 'the_content', 'cc_caboodle_replace_dash_spaces' );