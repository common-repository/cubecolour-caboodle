<?php

if ( ! defined( 'ABSPATH' ) ) exit;
	
/**
 * Indicate External Links
 *
 */
function cc_caboodle_external_links() {

	if ( cc_caboodle( 'extlink', '' ) == '1' ) {
		wp_add_inline_style( 'cc-caboodle', '
			@font-face {
			font-family: "external-links";
			src: url( "' . CC_CABOODLE_PLUGIN_URL . 'fonts/external-links.woff" ) format( "woff" ),
				 url( "' . CC_CABOODLE_PLUGIN_URL . 'fonts/external-links.woff2" ) format( "woff2" );
			font-weight: normal;
			font-style: normal;
		}
			.entry-content a {
			--extlink-icon:"' . esc_html( cc_caboodle( "extlink_icon", "\\e806" ) ) . '";
			--extlink-size:' . esc_attr( cc_caboodle( "extlink_size", "16" ) ) . 'px;
			--extlink-vpos:' . esc_attr( cc_caboodle( "extlink_vpos", "0" ) ) . 'px;
			--extlink-color:' . esc_attr( cc_caboodle( "extlink_color", "currentColor" ) ) . ';
			--extlink-color-hover:' . esc_attr( cc_caboodle( "extlink_color_hover", "currentColor" ) ) . ';
		}
		a[href]:not([href*="' . esc_html( cc_caboodle_strip_domain_protocol() ) . '"]):not([href^="#"]):not([href^="/"]) {
			white-space: nowrap;
		}
		a[href*="//"]:not([href*="' . esc_html( cc_caboodle_strip_domain_protocol() ) . '"])::after {
			display: inline-block;
			content: var(--extlink-icon);
			font-family: "external-links";
			font-size: var(--extlink-size);
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
			border: 0;
			color: var(--extlink-color);
				margin-left: 0.16em;
			line-height: 0;
			position: relative;
			bottom: var(--extlink-vpos);
		}
		a[href]:not([href*="' . esc_html( cc_caboodle_strip_domain_protocol() ) . '"]):not([href^="#"]):not([href^="/"]):hover::after {
			color: var(--extlink-color-hover);
		}' );
	}
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_external_links', 20 );


/**
 * Add the target='_blank' & rel='noopener noreferrer nofollow' to external links
 *
 */
function cc_caboodle_external_links_target() {
	
	if ( cc_caboodle( 'extlink_attributes', '' ) == '1' ) {
		wp_enqueue_script( 'external-links', CC_CABOODLE_PLUGIN_URL . 'js/external-links.js', false, CC_CABOODLE_PLUGIN_VERSION, true );
	}

}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_external_links_target', 20);
