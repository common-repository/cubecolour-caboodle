<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Get the domain name without protocols
 *
 */
function cc_get_domain() {
	return str_replace( array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' ), '', site_url() );
}

/**
 * Indicate External Links
 *
 */
function cc_external_links() {

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
		--extlink-size:' . esc_attr( cc_caboodle( "extlink_size", "1" ) ) . 'em;
		--extlink-vpos:' . esc_attr( cc_caboodle( "extlink_vpos", "0" ) ) . 'px;
		--extlink-color:' . esc_attr( cc_caboodle( "extlink_color", "currentColor" ) ) . ';
		--extlink-color-hover:' . esc_attr( cc_caboodle( "extlink_color_hover", "currentColor" ) ) . ';
	}
	a[href]:not([href*="' . esc_html( cc_get_domain() ) . '"]):not([href^="#"]):not([href^="/"]) {
		white-space: nowrap;
	}
	a[href*="//"]:not([href*="' . esc_html( cc_get_domain() ) . '"])::after {
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
	a[href]:not([href*="' . esc_html( cc_get_domain() ) . '"]):not([href^="#"]):not([href^="/"]):hover::after {
		color: var(--extlink-color-hover);
	}' );
}
add_action( 'wp_enqueue_scripts', 'cc_external_links', 20 );