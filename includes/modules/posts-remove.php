<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Remove the 'Posts' menu item from the admin menu
 */
function cc_caboodle_remove_default_post_type() {
	remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'cc_caboodle_remove_default_post_type' );


/**
 * Remove +New post in top Admin Menu Bar
 */
function cc_caboodle_remove_default_post_type_menu_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'new-post' );
}
add_action( 'admin_bar_menu', 'cc_caboodle_remove_default_post_type_menu_bar', 999 );


/**
 * Remove the Quick Draft Dashboard Widget
 */
function cc_caboodle_remove_draft_widget(){
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'cc_caboodle_remove_draft_widget', 999 );