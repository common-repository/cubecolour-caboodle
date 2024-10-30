<?php
/**
Plugin Name: Cubecolour Caboodle
Description: An agglomeration of useful functions
Author: cubecolour
Version: 1.1.0
License: GPLv2 or later
Text Domain: cubecolour-caboodle
Domain Path: /languages/
Author URI: https://cubecolour.co.uk/

Copyright 2023-2024 cubecolour (https://cubecolour.co.uk)

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License (Version 2 - GPLv2) as published
by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc., 51 Franklin
St, Fifth Floor, Boston, MA 02110-1301 USA

 */


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Text domain
 *
 */
function cc_caboodle_load_textdomain() {
	load_plugin_textdomain( 'cubecolour-caboodle', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'cc_caboodle_load_textdomain' );


/**
 * Define Constants
 *
 */
define( 'CC_CABOODLE_PLUGIN_VERSION', '1.1.0' );
define( 'CC_CABOODLE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CC_CABOODLE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );


/**
 * For testing or troubeshooting, uncomment the delete option line below — this will delete the cc_caboodle option on page load
 * After deleting the option, deactivate and activate the plugin to add back the option with default settings
 *
 */
/** / delete_option('cc_caboodle');


/**
 * Add plugin settings and import/export links
 *
 */
function cc_caboodle_settings_links( $links ) {

	/**
	 * caboodle customizer panel link
	 */
	$customizer_url = add_query_arg(
		array(
			'autofocus[panel]'	=> 'cc_caboodle_panel',
			'return'			=> admin_url( 'plugins.php' ),
		),
		admin_url( 'customize.php' )
	);

	array_push( $links, '<a href=' . esc_url( menu_page_url( 'caboodle', false ) ) . '>' . esc_html__( 'Settings', 'cubecolour-caboodle' ) . '</a>' );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cc_caboodle_settings_links' );


/**
 * Helper functions:
 *
 * Return a parameter value from the array stored in the cc_caboodle option value
 * Return a random hexadecimal number for the initial passvis salt
 *  Update an option value in the cc_caboodle options array
 *
 */
require_once( CC_CABOODLE_PLUGIN_PATH . 'includes/helper-functions.php' );


/**
 * Initial values
 *
 */
require_once( CC_CABOODLE_PLUGIN_PATH . 'includes/initial-values.php' );


/**
 * Activation
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/activation.php' );

register_activation_hook( __FILE__, 'cc_caboodle_activation'  );


/**
 * Register NULL style for cc-logo inline CSS (frontend & admin) - for hooking in inline scripts
 *
 */
function cc_caboodle_enqueue_cubecolour_logo() {
	wp_register_style( 'cc-dev-logo', false, array(), CC_CABOODLE_PLUGIN_VERSION );
}
add_action( 'admin_enqueue_scripts', 'cc_caboodle_enqueue_cubecolour_logo' );
add_action( 'wp_enqueue_scripts', 'cc_caboodle_enqueue_cubecolour_logo' );


/**
 * Register NULL style & script for cc-caboodle inline CSS & JS - for hooking in inline scripts
 *
 */
function cc_caboodle_enqueue_inline_css_js() {
	wp_register_style( 'cc-caboodle', false, array(), CC_CABOODLE_PLUGIN_VERSION );
	wp_enqueue_style( 'cc-caboodle' );

	wp_register_script( 'cc-caboodle', false, array(), CC_CABOODLE_PLUGIN_VERSION, true );
	wp_enqueue_script( 'cc-caboodle' );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_enqueue_inline_css_js' );


/**
 * Register NULL style & script for cc-caboodle-admin inline CSS & JS - for hooking in inline scripts in the WordPress admin.
 *
 */
function cc_caboodle_enqueue_admin_style() {
	wp_register_style('cc-caboodle-admin', false, array(), CC_CABOODLE_PLUGIN_VERSION);
}
add_action('admin_enqueue_scripts', 'cc_caboodle_enqueue_admin_style');


/**
* Plugin update
*
*/
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/update.php' );


/**
* Admin - import/export settings
*
*/
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/admin.php' );


/**
 * Customizer sections and controls
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/customizer.php' );



	/**********************\
	*					  *
	*   CABOODLE MODULES   *
	*					  *
	\**********************/


/**
 * Additional date & time format options
 *
 */
if ( cc_caboodle( 'datetime_formats', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/datetime-formats.php' );
}

/**
 * Caboodle additional dashicons
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/dashicons-caboodle.php' );

/**
 * Media attachment pages
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/media-attachment-pages.php' );

/**
 * Admin menu order
 *
 */
if ( cc_caboodle( 'admin_menu_order', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/admin-menu-order.php' );
}

/**
 * Private Site: Redirect to login (for when site is in development or undergoing maintenance)
 *
 */
if ( cc_caboodle( 'private_site', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/private-site.php' );
}

/**
 * Just-in-time preloading. preloads a page right before a user clicks on it by adding the Instant page script as a module
 *
 */
if ( cc_caboodle( 'preloading', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/preloading.php' );
}

/**
 * Login background
 *
 */
if ( cc_caboodle( 'login_bg', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/login-bg.php' );
}

/**
 * No login by email address
 *
 */
if ( cc_caboodle( 'no_login_email', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-login-by-email-address.php' );
}

/**
 * Password mask
 *
 */
if ( cc_caboodle( 'password_mask', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/password-mask.php' );
}

/**
 * Single login error message - does not identify whether the username is correct or not
 *
 */
if ( cc_caboodle( 'login_error', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/login-error-message.php' );
}

/**
 * Login warning
 *
 */
if ( cc_caboodle( 'login_warning', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/login-warning.php' );
}

/**
 * Password visualisation
 *
 */
if ( cc_caboodle( 'passvis', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/password-visualisation.php' );
}

/**
 * Replace the WP logo with the site icon in the admin toolbar
 *
 */
if ( cc_caboodle( 'replace_wplogo', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/replace-wp-logo-with-site-icon.php' );
}

/**
 * Replace the WP logo with the site icon in the admin toolbar
 *
 */
if ( cc_caboodle( 'dashboard_notes', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/dashnotes.php' );
}

/**
 * View site in new tab - modifies the link in the admin toolbar
 *
 */
if ( cc_caboodle( 'new_tab', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/view-site-in-new-tab.php' );
}

/**
 * No avatars
 * need to always include this module so that the show_avatars option can be updated to '' or '1'
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-avatars.php' );

/**
 * Show 'post', 'page', 'media', 'taxonomy', & 'user' IDs
 *
 */
if ( cc_caboodle( 'show_ids', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/show-ids.php' );
}

/**
 * Show the current WordPress version in admin footer when an upgrade is available
 *
 */
if ( cc_caboodle( 'current_version', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/upgrade-current-version.php' );
}

/**
 * No howdy!
 *
 */
if ( cc_caboodle( 'no_howdy', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-howdy.php' );
}

/**
 * Limit revisions
 *
 */
if ( cc_caboodle( 'limit_revisions', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/limit-revisions.php' );
}

/**
 * Developer link
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/devlink.php' );

/**
 * Show site settings
 *
 */
if ( cc_caboodle( 'show_site_settings', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/show-site-settings.php' );
}

/**
 * New plugins
 *
 */
if ( cc_caboodle( 'new_plugins', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/new-plugins.php' );
}

/**
 * Force vertical scrollbar to prevent layout shift when going page to page
 *
 */
if ( cc_caboodle( 'force_scrollbar', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/force-scrollbar.php' );
}

/**
 * Scroll to anchor
 *
 */
if ( cc_caboodle( 'scroll_to_anchor', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/scroll-to-anchor.php' );
}

/**
 * Text selection colors
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/text-selection.php' );

/**
 * Add the page slug to the body classes
 *
 */
if ( cc_caboodle( 'page_slug_body_class', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/page-slug-body-class.php' );
}

/**
 * 'posts' post type
 *
 */
if ( cc_caboodle( 'posts', '' ) == 'remove' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/posts-remove.php' );
} elseif ( cc_caboodle( 'posts', '' ) == 'rename_news' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/posts-rename-news.php' );
}

/**
 * Excerpts for pages
 *
 */
if ( cc_caboodle( 'page_excerpts', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/page-excerpts.php' );
}

/**
 * Unlink parent menu items
 *
 */
if ( cc_caboodle( 'unlink_parent', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/unlink-parent-menu-items.php' );
}

/**
 * Dash spacing
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/dash-spacing.php' );

/**
 * Indicate external links
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/external-links.php' );

/**
 * Wavy links
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/wavy-links.php' );

/**
 * Lightbox
 *
 */
if ( cc_caboodle( 'lightbox', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/lightbox.php' );
}

/**
 * Media file size column
 *
 */
if ( cc_caboodle( 'media_file_size', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/media-file-size.php' );
}

/**
 * No Lazy Loading
 *
 */
if ( cc_caboodle( 'no_lazy_loading', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-lazy-loading.php' );
}

/**
 * Scroll to top
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/scroll-to-top.php' );

/**
 * Stomp: on pages with short content this forces the footer to the bottom of the browser viewport
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/stomp-footer.php' );

/**
 * Years shortcode
 *
 */
if ( cc_caboodle( 'years', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/years-shortcode.php' );
}

/**
 * Anti spambot (shortcode)
 *
 */
if ( cc_caboodle( 'anti_spambot', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/anti-spambot.php' );
}

/**
 * Anti clickjack - header
 *
 */
if ( cc_caboodle( 'anti_clickjack', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/anti-clickjack.php' );
}

/**
 * No admin bar
 *
 */
if ( cc_caboodle( 'no_admin_bar', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-admin-bar.php' );
}

/**
 * No theme and plugin file editors
 *
 */
if ( cc_caboodle( 'no_file_editors', '' ) == '1' ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * No author archives
 *
 */
if ( cc_caboodle( 'no_author_archives', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-author-archives.php' );
}

/**
 * No generator tag
 *
 */
if ( cc_caboodle( 'no_generator', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-generator-tag.php' );
}

/**
 * No RSD
 *
 */
if ( cc_caboodle( 'no_rsd', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-rsd.php' );
}

/**
 * No feeds
 *
 */
if ( cc_caboodle( 'no_feeds', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-feeds.php' );
}

/**
 * No shortlinks
 *
 */
if ( cc_caboodle( 'no_shortlinks', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-shortlinks.php' );
}

/**
 * No pingbacks
 *
 */
if ( cc_caboodle( 'no_pingbacks', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/no-pingbacks.php' );
}

/**
 * Change responsive breakpoint value (Astra theme only)
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/astra-breakpoints.php' );

/**
 * Translatable search placeholder text (Astra theme only)
 *
 */
if ( cc_caboodle( 'search_placeholder', '1' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/astra-search-placeholder.php' );
}

/**
 * Polylang tweaks
 *
 */
if ( cc_caboodle( 'polylang', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/polylang.php' );
}

/**
 * Gravity forms tweaks
 *
 */
include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/gform-style.php' );

/**
 * Embed bandcamp
 *
 */
if ( cc_caboodle( 'embed_bandcamp', '' ) == '1' ) {
	include_once( CC_CABOODLE_PLUGIN_PATH . 'includes/modules/embed-bandcamp.php' );
}