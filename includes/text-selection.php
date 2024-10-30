<?php

/**
 * Selected text colours
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function cc_caboodle_text_selection() {

	wp_add_inline_style( 'cc-caboodle', '::selection {
		color: ' . esc_attr( cc_caboodle( "text_selection_color", '#fff' ) ) . ';
		background-color: ' . esc_attr( cc_caboodle( "text_selection_bgcolor", '#ff69b4' ) ) . ';
	}' );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_text_selection' );