<?php


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Update the media_attachment_pages option value if it doesn't match the value in the caboodle option array
 *
 */
function cc_caboodle_media_attachment_pages() {
	$option_value = cc_caboodle('media_attachment_pages', '');
	
	if ($option_value != get_option('media_attachment_pages')) {
		update_option('media_attachment_pages', $option_value == '1' ? '1' : '');
	}
}
add_action('customize_save_after', 'cc_caboodle_media_attachment_pages');
