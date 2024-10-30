<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Redirect requests for author archives to the homepage
 *
 */
function cc_caboodle_redirect_author_archive_to_homepage() {
	if ( is_author() ) {
		wp_redirect(home_url());
	}
}
add_action( 'template_redirect', 'cc_caboodle_redirect_author_archive_to_homepage' );