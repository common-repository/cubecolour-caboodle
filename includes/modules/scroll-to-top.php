<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
* Enqueue scrolltop script, stylesheet and inline styles
*
*/
function cc_caboodle_scrolltop_enqueue(){
	
	
	if ( cc_caboodle( 'scrolltop', '' ) == '1' ) {
		wp_enqueue_style( 'scrolltop', CC_CABOODLE_PLUGIN_URL . 'css/scrolltop.css' , false, CC_CABOODLE_PLUGIN_VERSION );
		wp_enqueue_script( 'scrolltop', CC_CABOODLE_PLUGIN_URL . 'js/scrolltop.js', false, CC_CABOODLE_PLUGIN_VERSION, true );
	
		$default = array(
			'scrolltop_icon'			=> '\\f106',
			'scrolltop_size'			=> '50',
			'scrolltop_padding'			=> '0',
			'scrolltop_border_width'	=> '2',
			'scrolltop_radius'			=> '100',
			'scrolltop_bottom'			=> '50',
			'scrolltop_right'			=> '50',
			'scrolltop_color'			=> '#3a3a3a',
			'scrolltop_bgcolor'			=> '#fff',
			'scrolltop_color_hover'		=> '#3a3a3a',
			'scrolltop_bgcolor_hover'	=> '#f7dc18',
		);
	
		wp_add_inline_style( 'scrolltop', '.scrolltop {
			--scrolltop-icon: "' . esc_attr( cc_caboodle( "scrolltop_icon", $default['scrolltop_icon'] ) ) . '";
			--scrolltop-size: ' . esc_attr( cc_caboodle( "scrolltop_size", $default['scrolltop_size'] ) ) . ';
			--scrolltop-padding: ' . esc_attr( cc_caboodle( "scrolltop_padding", $default['scrolltop_padding'] ) ) . ';
			--scrolltop-border-width: ' . esc_attr( cc_caboodle( "scrolltop_border_width", $default['scrolltop_border_width'] ) ) . ';
			--scrolltop-radius: ' . esc_attr( cc_caboodle( "scrolltop_radius", $default['scrolltop_radius'] ) ) . ';
			--scrolltop-bottom: ' . esc_attr( cc_caboodle( "scrolltop_bottom", $default['scrolltop_bottom'] ) ) . ';
			--scrolltop-right: ' . esc_attr( cc_caboodle( "scrolltop_right", $default['scrolltop_right'] ) ) . ';
			--scrolltop-color: ' . esc_attr( cc_caboodle( "scrolltop_color", $default['scrolltop_color'] ) ) . ';
			--scrolltop-bg-color: ' . esc_attr( cc_caboodle( "scrolltop_bgcolor", $default['scrolltop_bgcolor'] ) ) . ';
			--scrolltop-color-hover: ' . esc_attr( cc_caboodle( "scrolltop_color_hover", $default['scrolltop_color_hover'] ) ) . ';
			--scrolltop-bg-color-hover: ' . esc_attr( cc_caboodle( "scrolltop_bgcolor_hover", $default['scrolltop_bgcolor_hover'] ) ) . ';
		}' );
	}
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_scrolltop_enqueue', 20);


/**
* Add the button
*
*/
function cc_caboodle_scrolltop() {
	if ( cc_caboodle( 'scrolltop', '' ) == '1' ) {
		?>
		<a class="scrolltop"></a>
		<?php
	}
}
add_action( 'wp_footer', 'cc_caboodle_scrolltop', 1 );