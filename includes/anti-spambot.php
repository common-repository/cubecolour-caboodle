<?php

/**
 * Anti spambot: [email] shortcode
 *
 */
function cc_caboodle_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}
	return '<a href="' . esc_url('mailto:' . antispambot( $content )) . '">' . antispambot( esc_html( $content ) ) . '</a>';
}
add_shortcode( 'email', 'cc_caboodle_hide_email_shortcode' );