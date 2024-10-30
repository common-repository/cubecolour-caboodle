<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Replace the WP logo in the admin bar with the site icon
*
*/
function cc_caboodle_add_inline_admin_css() {
	
	$site_icon_url = get_site_icon_url(20);
	
	if ( $site_icon_url ) {
		$siteicon_css = '#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
				background-image: url("' . $site_icon_url . '") !important;
				background-position: 0 0;
				background-size: 20px 20px;
				color: rgba(0, 0, 0, 0);
			}
			#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
				background-position: 0 0;
			}';
		
		wp_enqueue_style('cc-caboodle-admin');
		wp_add_inline_style('cc-caboodle-admin', $siteicon_css);
	}
}
add_action('admin_enqueue_scripts', 'cc_caboodle_add_inline_admin_css');