<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Change the order of items in the Admin Menu
*
*/
function cc_caboodle_admin_menu_order($menu_order) {
	// Define the desired order of menu items
	$menu_order = array(
		'index.php', // Dashboard
		'edit.php?post_type=page', // Pages
		'edit.php', // Posts
		'upload.php', // Media
		// Add other items here as needed
	);
	return $menu_order;
}
add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'cc_caboodle_admin_menu_order');