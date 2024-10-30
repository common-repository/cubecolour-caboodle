<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Change post type labels in the admin menu
 *
 */
function cc_caboodle_posts_change_menu_labels() {

	// Access global variables.
	global $menu, $submenu;

	// The "Posts" position in the admin menu.
	$menu[5][0] = esc_html__( 'News', 'cubecolour-caboodle' );

	// Submenus of the "Posts" position in the admin menu.
	$submenu['edit.php'][5][0]  = esc_html__( 'News', 'cubecolour-caboodle' );
	$submenu['edit.php'][10][0] = esc_html__( 'Add news article', 'cubecolour-caboodle' );
	$submenu['edit.php'][16][0] = esc_html__( 'News tags', 'cubecolour-caboodle' );
}
add_action( 'admin_menu', 'cc_caboodle_posts_change_menu_labels' );



/**
 * Change post type labels on admin pages
 *
 */
function cc_caboodle_posts_change_page_labels() {

	// Access global variables.
	global $wp_post_types;

	// The labels of the array.
	$labels = $wp_post_types['post']->labels;
	$labels->name               = esc_html__( 'News', 'cubecolour-caboodle' );
	$labels->singular_name      = esc_html__( 'News article', 'cubecolour-caboodle' );
	$labels->add_new            = esc_html__( 'Add news article', 'cubecolour-caboodle' );
	$labels->add_new_item       = esc_html__( 'Add news article', 'cubecolour-caboodle' );
	$labels->edit_item          = esc_html__( 'Edit news', 'cubecolour-caboodle' );
	$labels->new_item           = esc_html__( 'News', 'cubecolour-caboodle' );
	$labels->view_item          = esc_html__( 'View news', 'cubecolour-caboodle');
	$labels->search_items       = esc_html__( 'Search news', 'cubecolour-caboodle' );
	$labels->not_found          = esc_html__( 'No news found', 'cubecolour-caboodle' );
	$labels->not_found_in_trash = esc_html__( 'No news found in trash', 'cubecolour-caboodle' );
	$labels->all_items          = esc_html__( 'All news articles', 'cubecolour-caboodle'  );
	$labels->menu_name          = esc_html__( 'News', 'cubecolour-caboodle' );
	$labels->name_admin_bar     = esc_html__( 'News', 'cubecolour-caboodle' );
}
add_action( 'init', 'cc_caboodle_posts_change_page_labels' );


/**
 * Change the default pin icon to a newspaper
 *
 */
function cc_caboodle_posts_change_menu_icon() {

	// Access global variables.
	global $menu;

	foreach ( $menu as $key => $val ) {

		if ( esc_html__( 'News', 'cubecolour-caboodle' ) == $val[0] ) {
		$menu[$key][6] = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 576 512"><path fill="white" d="M552 64H88c-13.255 0-24 10.745-24 24v8H24c-13.255 0-24 10.745-24 24v272c0 30.928 25.072 56 56 56h472c26.51 0 48-21.49 48-48V88c0-13.255-10.745-24-24-24zM56 400a8 8 0 0 1-8-8V144h16v248a8 8 0 0 1-8 8zm236-16H140c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm208 0H348c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm-208-96H140c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm208 0H348c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm0-96H140c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h360c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12z"/></svg>');
		}
	}
}
add_action( 'admin_menu', 'cc_caboodle_posts_change_menu_icon' );


/**
 * Change post messages
 *
 */
function cc_caboodle_posts_change_page_messages( $messages ) {

	// Access global variables.
	global $post, $post_ID;

	// Conditional message for revisions.
	if ( isset( $_GET['revision'] ) ) {
		$revision = sprintf(
			__( '%1s %2s' ),
			esc_html__( 'News article restored to revision from', 'cubecolour-caboodle' ),
			wp_post_revision_title( (int) $_GET['revision'], false )
		);
	} else {
		$revision = false;
	}

	// Updated message.
	$updated = sprintf(
		__( '%1s <a href="%2s">%3s</a>' ),
		esc_html__( 'News updated.', 'cubecolour-caboodle' ),
		esc_url( get_permalink( $post_ID ) ),
		esc_html__( 'View news article', 'cubecolour-caboodle' )
	);

	// Published message.
	$published = sprintf(
		__( '%1s <a href="%2s">%3s</a>' ),
		esc_html__( 'News article published.', 'cubecolour-caboodle' ),
		esc_url( get_permalink( $post_ID ) ),
		esc_html__( 'View news article', 'cubecolour-caboodle' )
	);

	// Submitted message.
	$submitted = sprintf(
		__( '%1s <a target="_blank" href="%2s">%3s</a>' ),
		esc_html__( 'News article submitted.', 'cubecolour-caboodle' ),
		esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ),
		esc_html__( 'Preview news article', 'cubecolour-caboodle' )
	);

	// Scheduled message.
	$scheduled = sprintf(
		__( '%1s <strong>%2s</strong>. <a target="_blank" href="%3s">%4s</a>' ),
		esc_html__( 'News article scheduled for:', 'cubecolour-caboodle' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ),
		esc_url( get_permalink( $post_ID ) ),
		esc_html__( 'Preview news article', 'cubecolour-caboodle' )
	);

	// Draft updated message.
	$draft = sprintf(
		__( '%1s <a target="_blank" href="%2s">%3s</a>' ),
		esc_html__( 'News draft updated.', 'cubecolour-caboodle' ),
		esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ),
		esc_html__( 'Preview news article', 'cubecolour-caboodle' )
	);

	// The array of messages for the Posts post type.
	$messages['post'] = [

		// First is unused. Messages start at index 1.
		0  => null,
		1  => $updated,
		2  => esc_html__( 'Custom field updated.', 'cubecolour-caboodle' ),
		3  => esc_html__( 'Custom field deleted.', 'cubecolour-caboodle' ),
		4  => esc_html__( 'News article updated.', 'cubecolour-caboodle' ),
		5  => $revision,
		6  => $published,
		7  => esc_html__( 'News article saved.', 'cubecolour-caboodle' ),
		8  => $submitted,
		9  => $scheduled,
		10 => $draft
	];

	// Return the array of messages.
	return $messages;

}
add_filter( 'post_updated_messages', 'cc_caboodle_posts_change_page_messages' );