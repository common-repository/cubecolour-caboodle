<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add the page slug to the body classes
 *
 */
function cc_add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'cc_add_slug_body_class' );