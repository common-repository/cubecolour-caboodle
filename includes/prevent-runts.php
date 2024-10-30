<?php
/*
	props:
	https://opusdesign.us/wordcount/typographic-widows-orphans/
	https://www.fonts.com/content/learning/fontology/level-2/text-typography/rags-widows-orphans
	https://www.kevinleary.net/fix-hanging-words-wordpress/
	https://gist.github.com/josephbergdoll/6462519ef674dbc357a7
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Prevent runts (single hanging words on the last line of a paragraph) in the main content text
*
*/
function cc_caboodle_prevent_runts( $content ) {

	/**
	 *	Perform the replacement only on paras made of more than eight words
	 */
	$spaces = substr_count( $content, ' ');
	if ( $spaces > 8 ) {

		/**
		 *	Replace the last three spaces between words of each para with non-breaking spaces
		 */
		if (strpos( $content, '<p>' ) !== false ) {
			$paras = explode( '</p>', $content );
			foreach( $paras as &$para ) {
				$last_space = strrpos($para, ' ');
				$nbsp_para = substr_replace( $para, '&nbsp;', $last_space, 1 );
				$nbsp_para = $nbsp_para . '</p>';
				$para = $nbsp_para;
			}
			$nbsp_paras = implode( $paras );
			return $nbsp_paras;
		}
		else {
			$last_space = strrpos( $content, ' ' );
			$content = substr_replace( $content, '&nbsp;', $last_space, 1 );
		}
	}
	return $content;
}
add_filter( 'the_content', 'cc_caboodle_prevent_runts' );


/**
* Secret bonus!
* Enable non breaking spaces to be added within the content by adding a [nbsp] shortcode
*
*/
function cc_caboodle_nbsp_shortcode( $atts ){
	return '&nbsp;';
}
add_shortcode( 'nbsp', 'cc_caboodle_nbsp_shortcode' );