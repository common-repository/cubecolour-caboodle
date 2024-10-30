<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * View site in new tab
 * Modifies the admin toolbar link 'View Site' (& 'View Store' for WooCommerce) to open in a new tab
 *
 */
function cc_caboodle_view_site( $wp_admin_bar ) {

	$all_toolbar_nodes = $wp_admin_bar->get_nodes();

	foreach ( $all_toolbar_nodes as $node ) {

		if( $node->id == 'site-name' || $node->id == 'view-site' || $node->id == 'view-store' ) {

			$args = $node;
			$args->meta = array('target' => '_blank');
			$wp_admin_bar->add_node( $args );
		}
	}
}
add_action( 'admin_bar_menu', 'cc_caboodle_view_site', 999 );