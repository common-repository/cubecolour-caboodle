<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Prepend the new column to the columns array
 */
function cc_show_ids_column( $columns ) {
	$column_id = array( 'cc_show_ids' => esc_attr__( 'ID', 'cubecolour-caboodle' ) );
	$columns['cc_show_ids'] = 'ID';
	return $columns;
}

/**
 * Echo the ID for the new column
 */
function cc_caboodle_show_ids_value( $column_name, $id ) {
	if ( 0 === strpos( $column_name, 'cc_show_ids' ) ) {
		echo esc_attr( $id );
	}
}

function cc_show_ids_return_value( $value, $column_name, $id ) {
	if ( 0 === strpos( $column_name, 'cc_show_ids' ) ) {
		$value .= $id;
	}
	return $value;
}

/**
 * Output CSS for width of new column
 */
function cc_caboodle_show_ids_css() {
	?>
	<style type="text/css">
	#cc_show_ids {
		width: 4em;
	}
	@media screen and (max-width: 782px) {
		.wp-list-table #cc_show_ids,
		.wp-list-table #the-list .cc_show_ids {
			display: none;
		}
		.wp-list-table #the-list .is-expanded .cc_show_ids {
			padding-left: 30px;
		}
	}
	</style>
	<?php
}
add_action( 'admin_head', 'cc_caboodle_show_ids_css' );

/**
 * Actions/Filters for various tables and the css output
 */
function cc_caboodle_show_ids_add() {

	// Media
	if ( cc_caboodle( 'show_ids_media', '0' ) == '1' ) {
		add_action( 'manage_media_columns', 'cc_show_ids_column' );
		add_filter( 'manage_media_custom_column', 'cc_caboodle_show_ids_value', 10, 3 );
	}

	// Links & link categories
	if ( cc_caboodle( 'show_ids_links', '0' ) == '1' ) {
		add_action( 'manage_link_custom_column', 'cc_caboodle_show_ids_value', 10, 2 );
		add_filter( 'manage_link-manager_columns', 'cc_show_ids_column' );
		add_action( 'manage_edit-link-categories_columns', 'cc_show_ids_column' );
		add_filter( 'manage_link_categories_custom_column', 'cc_show_ids_return_value', 10, 3 );
	}

	// Categories, tags & taxonomies
	if ( cc_caboodle( 'show_ids_taxonomies', '0' ) == '1' ) {
		$taxonomies = get_taxonomies();
		if ($taxonomies !== null) {
			foreach ( $taxonomies as $taxonomy ) {
				add_action( "manage_edit-{$taxonomy}_columns", 'cc_show_ids_column' );
				add_filter( "manage_{$taxonomy}_custom_column", 'cc_show_ids_return_value', 10, 3 );
				add_filter( "manage_edit-{$taxonomy}_sortable_columns", 'cc_show_ids_column' );
			}
		}
	}

	// Posts, pages & custom post types
	if ( cc_caboodle( 'show_ids_posts', '0' ) == '1' ) {
		$posttypes = get_post_types();
		if ($posttypes !== null) {
			foreach ( $posttypes as $posttype ) {
				add_action( "manage_edit-{$posttype}_columns", 'cc_show_ids_column' );
				add_filter( "manage_{$posttype}_posts_custom_column", 'cc_caboodle_show_ids_value', 10, 3 );
				add_filter( "manage_edit-{$posttype}_sortable_columns", 'cc_show_ids_column' );
			}
		}
	}

	// Users
	if ( cc_caboodle( 'show_ids_users', '0' ) == '1' ) {
		add_action( 'manage_users_columns', 'cc_show_ids_column' );
		add_filter( 'manage_users_custom_column', 'cc_show_ids_return_value', 10, 3 );
		add_filter( 'manage_users_sortable_columns', 'cc_show_ids_column' );
	}

	// Comments
	if ( cc_caboodle( 'show_ids_comments', '0' ) == '1' ) {
		add_action( 'manage_edit-comments_columns', 'cc_show_ids_column' );
		add_action( 'manage_comments_custom_column', 'cc_caboodle_show_ids_value', 10, 2 );
		add_filter( 'manage_edit-comments_sortable_columns', 'cc_show_ids_column' );
	}
}
add_action( 'admin_init', 'cc_caboodle_show_ids_add' );
