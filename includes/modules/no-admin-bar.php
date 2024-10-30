<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Remove the admin bar for all users with option to enable for admins only
*
*/
function cc_caboodle_remove_admin_bar() {

	$no_admin_bar = cc_caboodle('no_admin_bar');
	$no_admin_bar_except_admins = cc_caboodle('no_admin_bar_except_admins');

	if ( $no_admin_bar && !$no_admin_bar_except_admins ) {
		show_admin_bar(false);
	} elseif ( $no_admin_bar && $no_admin_bar_except_admins ) {
		if (!current_user_can('administrator')) {
			show_admin_bar(false);
		}
	}
}
add_action('after_setup_theme', 'cc_caboodle_remove_admin_bar');