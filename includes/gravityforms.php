<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register gform stylesheet for gravity forms
 *
 */
function cc_caboodle_gform_style_register(){
	wp_register_style( 'caboodle-gform', CC_CABOODLE_PLUGIN_URL . 'css/gform.css' , false, CC_CABOODLE_PLUGIN_VERSION );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_gform_style_register', 20);


/**
 * Enqueue gravity form stylesheet & inline style
 *
 */
function cc_caboodle_gform_style() {

	wp_add_inline_style( 'caboodle-gform', '.gform_wrapper {
		--gform-border-color: ' . esc_attr( cc_caboodle( "gform_border_color", '#c0c0c0' ) ) . ';
		--gform-border-color-hover: ' . esc_attr( cc_caboodle( "gform_border_color_hover", '#bada55' ) ) . ';
		--gform-border-color-focus: ' . esc_attr( cc_caboodle( "gform_border_color_focus", '#ff69b4' ) ) . ';
	}' );
	wp_enqueue_style( 'caboodle-gform' );
}

/**
 * Enqueue gravity form stylesheet & inline style only for pages with a form
 *
 */
function cc_caboodle_enqueue_gform_style(){
	add_action( 'wp_enqueue_scripts', 'cc_caboodle_gform_style', 20);
}
add_action( 'gform_enqueue_scripts', 'cc_caboodle_enqueue_gform_style', 10 );


/**
 * Change 'required' legend
 *
 */
function cc_caboodle_gform_req_legend() {

    return '<span class="gfield_required gfield_required_asterisk">*</span> ' . esc_html__( 'Required', 'cubecolour-caboodle' );
}
add_filter( 'gform_required_legend', 'cc_caboodle_gform_req_legend', 10, 2 );