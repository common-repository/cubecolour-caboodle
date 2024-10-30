<?php


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Ensure the file size meta gets added to new uploads
 *
 */
function cc_caboodle_add_filesize_metadata_to_images( $meta_id, $post_id, $meta_key, $meta_value ) {
	if( '_wp_attachment_metadata' == $meta_key ) {
		$file = get_attached_file( $post_id );
		update_post_meta( $post_id, 'filesize', filesize( $file ) );
	}
}
add_action( 'added_post_meta', 'cc_caboodle_add_filesize_metadata_to_images', 10, 4 );


/**
 * Add the files size column to the media library list view
 *
 */
function cc_caboodle_add_column_file_size( $posts_columns ) {
	$posts_columns[ 'filesize' ] = esc_html__( 'File Size', 'cubecolour-caboodle' );
	return $posts_columns;
}
add_filter('manage_media_columns', 'cc_caboodle_add_column_file_size');


/**
 * Populate the files size column
 *
 */
function cc_caboodle_add_column_value_file_size( $column_name, $post_id ) {
	if('filesize' == $column_name ) {
		if( !get_post_meta( $post_id, 'filesize', true ) ) {
			$file = get_attached_file( $post_id );
			$file_size = filesize( $file );
			update_post_meta( $post_id, 'filesize', $file_size );
		} else {
			$file_size = get_post_meta( $post_id, 'filesize', true );
		}
		echo esc_attr( size_format( $file_size ), 2 );
	}
	return false;
}
add_action( 'manage_media_custom_column', 'cc_caboodle_add_column_value_file_size', 10, 2 );


/**
 * Make the files size column sortable
 *
 */
function cc_caboodle_add_column_sortable_file_size($columns) {
	$columns[ 'filesize' ] = 'filesize';
	return $columns;
}
add_filter( 'manage_upload_sortable_columns', 'cc_caboodle_add_column_sortable_file_size' );


/**
 * query modification for files size column sorting logic
 *
 */
function cc_caboodle_sortable_file_size_sorting_logic( $query ) {
	global $pagenow;

	if ( is_admin() && 'upload.php' == $pagenow && $query->is_main_query() && ! empty( $_REQUEST['orderby'] ) && 'filesize' == $_REQUEST['orderby'] ) {
		// Verify the nonce.
		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'cc_caboodle_filesize_sort_nonce' ) ) {
			// Add your logic here for when the nonce is valid.
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'meta_key', 'filesize' );
			if ( 'desc' == $_REQUEST['order'] ) {
				$query->set( 'order', 'DESC' );
			}
		} else {
			// Handle invalid nonce (e.g., display an error message).
			echo esc_html__( 'Invalid nonce. Please refresh the page and try again.', 'cubecolour-caboodle' );
		}
	}
}
add_action( 'pre_get_posts', 'cc_caboodle_sortable_file_size_sorting_logic' );

/**
 * Adjust the width & alignment of the file size column
 *
 */
function cc_caboodle_media_file_size_column_css() {
	echo '<style>.fixed .column-filesize { width: 12.75%; text-align: right; } thead tr .column-filesize a { display: inline-block; text-align: right; vertical-align: top; }</style>';
}
add_action( 'admin_print_styles-upload.php', 'cc_caboodle_media_file_size_column_css' );