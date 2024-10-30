<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Stomp the footer down to the bottom of the page when the page content is shorter than the viewport
* Targets the #colophon element by default
*
*/
function cc_caboodle_stomp() {
	if ( cc_caboodle( 'stomp', '' ) == '1' ) {
		wp_add_inline_script( 'cc-caboodle', 'function stomp(){var o=document.querySelector("body").clientHeight,t=window.innerHeight,e=document.querySelector("' . esc_attr( cc_caboodle( 'stomp_element', '#colophon' ) ) . '");t>o?(e.style.position="fixed",e.style.bottom="0",e.style.width="100%"):e.style.position="static"}window.onresize=stomp;window.onload=window.dispatchEvent(new Event("resize"));' );
	}
}

add_action( 'wp_enqueue_scripts', 'cc_caboodle_stomp' );
