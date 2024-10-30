<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * No lazy loading
 *
 */
add_filter( 'wp_lazy_loading_enabled', '__return_false' );


function cc_caboodle_no_lazy_load_featured_images( $attr, $attachment = null ) {
	$attr['loading'] = 'eager';
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'cc_caboodle_no_lazy_load_featured_images' );