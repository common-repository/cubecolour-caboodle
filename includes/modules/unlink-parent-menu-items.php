<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * unlink parent menu items
 *
 */
function cc_caboodle_unlink_parent_menu_items( $items ) {

	$parents_with_children = array();
	
	foreach ( $items as $item ) {
			if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
				$parents_with_children[] = $item->menu_item_parent;
			}
		}

		foreach ( $items as $item) {
			if ( in_array( $item->ID, $parents_with_children ) ) {
				$item->url = false;
		}
	}
	return $items;
}

add_filter( 'wp_nav_menu_objects', 'cc_caboodle_unlink_parent_menu_items' );