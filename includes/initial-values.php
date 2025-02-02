<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Return a value from the array stored in the cc_caboodle option value
 *
 */
function cc_caboodle_initial_values() {

	$initial_values = array(
		'add_dashicons'					=> '',
		'admin_menu_order'				=> '',
		'anti_clickjack'				=> '',
		'anti_spambot'					=> '',
		'breakpoint'					=> '',
		'breakpoint_mobile'				=> 544,
		'breakpoint_tablet'				=> 921,
		'caboodle_db_version'			=> CC_CABOODLE_PLUGIN_VERSION,
		'current_version'				=> '',
		'dashboard_notes'				=> '',
		'dashboard_notes_content'		=> '',
		'dash_spacing'					=> '',
		'datetime_formats'				=> '',
		'devlink'						=> '',
		'devlink_name'					=> '',
		'devlink_url'					=> '',
		'embed_bandcamp'				=> '',
		'extlink'						=> '',
		'extlink_attributes'			=> '',
		'extlink_color'					=> '',
		'extlink_color_hover'			=> '',
		'extlink_icon'					=> '\\e806',
		'extlink_size'					=> 14,
		'extlink_vpos'					=> 1,
		'force_scrollbar'				=> '',
		'gform'							=> '',
		'gform_border_color'			=> '#c6c6c6',
		'gform_border_color_focus'		=> '#969696',
		'gform_border_color_hover'		=> '#e91e63',
		'lightbox'						=> '',
		'limit_revisions'				=> '',
		'limit_revisions_qty'			=> -1,
		'login_bg'						=> '',
		'login_bg_borderless'			=> '',
		'login_bg_color_1'				=> 'fff',
		'login_bg_color_2'				=> 'fff',
		'login_error'					=> '',
		'login_error_message'			=> esc_html__( 'Incorrect details input', 'cubecolour-caboodle' ),
		'login_warning'					=> '',
		'login_warning_colour'			=> '#777777',
		'login_warning_heading'			=> esc_html__( 'Authorised access only', 'cubecolour-caboodle' ),
		'login_warning_text'			=> esc_html__( 'Disconnect immediately and do not attempt to log in if you are not an authorised user', 'cubecolour-caboodle' ),
		'media_attachment_pages'		=> '',
		'media_file_size'				=> '',
		'new_tab'						=> '',
		'new_plugins'					=> '',
		'no_admin_bar'					=> '',
		'no_admin_bar_except_admins'	=> '',
		'no_author_archives'			=> '',
		'no_avatars'					=> '',
		'no_feeds'						=> '',
		'no_file_editor'				=> '',
		'no_generator'					=> '',
		'no_howdy'						=> '',
		'no_howdy_afternoon'			=> esc_html__( 'Good afternoon', 'cubecolour-caboodle' ),
		'no_howdy_evening'				=> esc_html__( 'Good evening', 'cubecolour-caboodle' ),
		'no_howdy_morning'				=> esc_html__( 'Good morning', 'cubecolour-caboodle' ),
		'no_howdy_night'				=> esc_html__( 'Go to bed', 'cubecolour-caboodle' ),
		'no_lazy_loading'				=> '',
		'no_login_email'				=> '',
		'no_pingbacks'					=> '',
		'no_rsd'						=> '',
		'no_shortlinks'					=> '',
		'page_excerpts'					=> '',
		'page_slug_body_class'			=> '',
		'passvis'						=> '',
		'passvis_bars'					=> '4',
		'passvis_onfront'				=> '',
		'passvis_salt'					=> cc_caboodle_passvis_random_hex(),
		'password_mask'					=> '',
		'polylang'						=> '',
		'polylang_flag_grayscale'		=> 80,
		'polylang_flag_opacity'			=> 60,
		'polylang_flag_spacing'			=> 0,
		'polylang_flag_width'			=> 36,
		'posts'							=> '',
		'preloading'					=> '',
		'private_site'					=> '',
		'replace-wplogo'				=> '',
		'scroll_to_anchor'				=> '',
		'scrolltop'						=> '',
		'scrolltop_bgcolor'				=> '#ffffff',
		'scrolltop_bgcolor_hover'		=> '#3a3a3a',
		'scrolltop_border_width'		=> 2,
		'scrolltop_bottom'				=> 50,
		'scrolltop_color'				=> '#3a3a3a',
		'scrolltop_color_hover'			=> '#ffffff',
		'scrolltop_icon'				=> '\\f106',
		'scrolltop_padding'				=> 0,
		'scrolltop_radius'				=> 50,
		'scrolltop_right'				=> 50,
		'scrolltop_size'				=> 50,
		'search_placeholder'			=> '',
		'show_ids'						=> '',
		'show_ids_comments'				=> '',
		'show_ids_links'				=> '',
		'show_ids_media'				=> '',
		'show_ids_posts'				=> '',
		'show_ids_taxonomies'			=> '',
		'show_ids_users'				=> '',
		'show_site_settings'			=> '',
		'stomp'							=> '',
		'stomp_element'					=> '#colophon',
		'text_selection'				=> '',
		'text_selection_bgcolor'		=> '',
		'text_selection_color'			=> '',
		'unlink_parent'					=> '',
		'wavylinks'						=> '',
		'wavylinks_show'				=> '',
		'wavylinks_color'				=> '#0000ee',
		'wavylinks_color_hover'			=> '#ee0000',
		'wavylinks_gap'					=> '3',
		'wavylinks_selector'			=> 'html body .entry-content a:not(.wp-block-button__link), footer a, widget a',
		'years'							=> '',
		'years_from'					=> absint( gmdate('Y') ),
	);
	return $initial_values;
}