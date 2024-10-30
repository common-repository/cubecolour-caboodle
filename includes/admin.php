<?php
/* props:
https://pippinsplugins.com/building-settings-import-export-feature/
https://gist.github.com/slushman/6f08885853d4a7ef31ebceafd9e0c180
*/

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Register the settings page
 *
 */
function cc_caboodle_menu() {
	add_options_page( 'Caboodle', 'Caboodle', 'manage_options', 'caboodle', 'cc_caboodle_page' );
}
add_action( 'admin_menu', 'cc_caboodle_menu' );

/**
 * Register admin page css & js
 *
 */
function cc_caboodle_admin_cssjs() {
	wp_register_style( 'caboodle-admin', CC_CABOODLE_PLUGIN_URL . 'css/admin.css', false, CC_CABOODLE_PLUGIN_VERSION, 'screen' );
	wp_register_script( 'caboodle-admin', CC_CABOODLE_PLUGIN_URL . 'js/admin.js', array( 'jquery' ), CC_CABOODLE_PLUGIN_VERSION, true);
}
add_action( 'admin_enqueue_scripts', 'cc_caboodle_admin_cssjs' );


/**
* Add Content security policy to this admin page's header to enable embedded youtube videos
*
*/
function cc_caboodle_add_csp() {
	// Check if we're on the plugin's settings page
	$screen = get_current_screen();
	if ($screen->id != "options-general.php?page=caboodle") {
		return;
	}

	// Output the CSP meta tag
	echo '<meta http-equiv="Content-Security-Policy" content="default-src \'self\'; frame-src \'self\' https://www.youtube.com https://www.gstatic.com;">';
}
add_action('admin_head', 'cc_caboodle_add_csp');


/**
 * Render the settings page
 */
function cc_caboodle_page() {

	wp_enqueue_style( 'caboodle-admin' );
	wp_enqueue_script( 'caboodle-admin' );

	/**
	 * caboodle customizer panel link
	 */
	$customizer_link = add_query_arg(
		array(
			'autofocus[panel]'	=> 'cc_caboodle_panel',
			'return'			=> admin_url( 'options-general.php?page=caboodle' ),
		),
		admin_url( 'customize.php' )
	);

	/**
	 * function to output module classes
	 */
	function cc_caboodle_module_classes( $module ) {
		if ( cc_caboodle( $module ) == false ) {
			$classes = "module";
		} else {
			$classes = "module active"; 
		}
		echo esc_attr( $classes );
	}

	/**
	 * function to output customizer url
	 */
	function cc_caboodle_module_url( $section ) {
		echo esc_url( admin_url( '/customize.php?autofocus[section]=cc_caboodle_' . $section . '_section' ) );
	}

	
	?>
	<div class="wrap">
		<h2>Caboodle</h2>

		<div class="devlink"><a href="https://cubecolour.co.uk/wp" class="cubecolour-minilogo">cubecolour</a></div>
			
		<div class="admintabs">
			
			<input class="input" name="tabs" type="radio" id="tab-1" checked="checked"/>
			<label  class="label tabtitle" for="tab-1"><?php esc_html_e( 'Modules', 'cubecolour-caboodle' ); ?></label>
			<div class="panel">

				<ul class="modules" id="modules">
					
					<li class="<?php cc_caboodle_module_classes( 'datetime_formats' ) ?>">		
						<a class="module-content" href="<?php cc_caboodle_module_url( 'datetime_formats' ) ?>">
							<h2><?php esc_html_e( 'Additional date & time formats', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Adds new options for date and time formats in the general settings admin page', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					
					<li class="<?php cc_caboodle_module_classes( 'private_site' ) ?>">		
						<a class="module-content" href="<?php cc_caboodle_module_url( 'private_site' ) ?>">
							<h2><?php esc_html_e( 'Private site', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Redirect unauthenticated visitors to the login page', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'login_bg' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'login_bg' ) ?>">
							<h2><?php esc_html_e( 'Login background', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Apply a colored background to the login page', 'cubecolour-caboodle' ); ?></p>
						</a>
					<li class="<?php cc_caboodle_module_classes( 'no_login_email' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_login_email' ) ?>">
							<h2><?php esc_html_e( 'No login by email address', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Must log in by username, not by email address', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'password_mask' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'password_mask' ) ?>">
							<h2><?php esc_html_e( 'Mask password', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Do not expose password characters when entered on iPad, iPhone or android', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'login_error' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'login_error' ) ?>">
							<h2><?php esc_html_e( 'Single login error message', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'The same message for wrong username or wrong password', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'login_warning' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'login_warning' ) ?>">
							<h2><?php esc_html_e( 'Login warning message', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Extra text added to login form', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'passvis' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'passvis' ) ?>">
							<h2><?php esc_html_e( 'Password visualisation', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Display colored bars for visual confirmation of password input', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'new_tab' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'new_tab' ) ?>">
							<h2><?php esc_html_e( 'Open site in new tab', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Modify the view site link in admin to open in a new browser tab', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'replace_wplogo' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'replace_wplogo' ) ?>">
							<h2><?php esc_html_e( 'Replace WordPress logo', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Replace the WP logo in the admin toolbar with the site icon if one is configured', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'dashboard_notes' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'dashboard_notes' ) ?>">
							<h2><?php esc_html_e( 'Dashboard notes', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Adds a simple notepad widget to the dashboard', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'admin_menu_order' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'admin_menu_order' ) ?>">
							<h2><?php esc_html_e( 'Admin menu order', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Rearranges admin menu items: dashboard, pages, posts, media', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_avatars' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_avatars' ) ?>">
							<h2><?php esc_html_e( 'No avatars', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Remove support for gravatars or user avatars', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'show_ids' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'show_ids' ) ?>">
							<h2><?php esc_html_e( 'Show IDs', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Show the ID for posts, pages, custom post types, taxonomies, media and users', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'current_version' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'current_version' ) ?>">
							<h2><?php esc_html_e( 'Current WP version', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Show the current WordPress version in the admin footer when an upgrade is available', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_howdy' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_howdy' ) ?>">
							<h2><?php esc_html_e( 'No howdy', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Replace the howdy greeting with a salutation appropriate to the time of day', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'limit_revisions' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'limit_revisions' ) ?>">
							<h2><?php esc_html_e( 'Limit revisions', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Limit the number of saved revisions', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'devlink' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'devlink' ) ?>">
							<h2><?php esc_html_e( 'Developer link', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Developer link in admin footer and [developer] shortcode for front end', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'show_site_settings' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'show_site_settings' ) ?>">
							<h2><?php esc_html_e( 'Show settings', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'List the WordPress options with their values from the admin settings menu', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'new_plugins' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'new_plugins' ) ?>">
							<h2><?php esc_html_e( 'New plugins', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add "New" & "Beta" links to the add plugins page', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'preloading' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'preloading' ) ?>">
							<h2><?php esc_html_e( 'Preloading', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Speed up browsing between pages', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'force_scrollbar' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'force_scrollbar' ) ?>">
							<h2><?php esc_html_e( 'Force vertical scrollbar', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Prevent layout shift between long and short pages', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'scroll_to_anchor' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'scroll_to_anchor' ) ?>">
							<h2><?php esc_html_e( 'Scroll to anchor', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Smoothly animate when clicking a link targeting an anchored position', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'text_selection' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'text_selection' ) ?>">
							<h2><?php esc_html_e( 'Text selection', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Color and background color of selected text', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'page_slug_body_class' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'page_slug_body_class' ) ?>">
							<h2><?php esc_html_e( 'Page slug body class', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add a page slug class to the body tag', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'dash_spacing' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'dash_spacing' ) ?>">
							<h2><?php esc_html_e( 'Dash spacing', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Replace the spaces around en-dashes & em-dashes with hairspaces', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'posts' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'posts' ) ?>">
							<h2><?php esc_html_e( 'Posts', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Remove or rename the posts post type', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'page_excerpts' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'page_excerpts' ) ?>">
							<h2><?php esc_html_e( 'Page excerpts', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add support for manual excerpts to pages', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'unlink_parent' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'unlink_parent' ) ?>">
							<h2><?php esc_html_e( 'Unlink parent menu items', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Enable drop down menus to work more intuitively', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'extlink' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'extlink' ) ?>">
							<h2><?php esc_html_e( 'Indicate external links', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add an arrow icon to identify external links within the site content', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					
					<li class="<?php cc_caboodle_module_classes( 'wavylinks' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'wavylinks' ) ?>">
							<h2><?php esc_html_e( 'Wavy links', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add a wavy underline to links within the content', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					
					<li class="<?php cc_caboodle_module_classes( 'lightbox' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'lightbox' ) ?>">
							<h2><?php esc_html_e( 'Lightbox', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add a lightbox to images and galleries', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'media_file_size' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'media_file_size' ) ?>">
							<h2><?php esc_html_e( 'Show file size in media library', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add a file size column in the media library', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'media_attachment_pages' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'media_attachment_pages' ) ?>">
							<h2><?php esc_html_e( 'Enable media attachment pages', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Enable media attachment pages', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'add_dashicons' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'add_dashicons' ) ?>">
							<h2><?php esc_html_e( 'Add dashicons', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Extend dashicons with new icons', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_lazy_loading' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_lazy_loading' ) ?>">
							<h2><?php esc_html_e( 'No lazy loading', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'No WordPress lazy loading', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'scrolltop' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'scrolltop' ) ?>">
							<h2><?php esc_html_e( 'Scroll to top', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add a dynamic scroll to top button in the website footer', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'stomp' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'stomp' ) ?>">
							<h2><?php esc_html_e( 'Fix footer', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Fix the footer element to the bottom of the viewport on short pages', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'years' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'years' ) ?>">
							<h2><?php esc_html_e( 'Footer years range', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Copyright years shortcode to use in footer', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'anti_spambot' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'anti_spambot' ) ?>">
							<h2><?php esc_html_e( 'Anti spambot', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'email shortcode to help protect email addresses from spambots', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'anti_clickjack' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'anti_clickjack' ) ?>">
							<h2><?php esc_html_e( 'Anti clickjack', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Prevent the site from loading inside an external frame or iframe', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_admin_bar' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_admin_bar' ) ?>">
							<h2><?php esc_html_e( 'No admin bar', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'No front end admin bar for logged in users', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_file_editors' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_file_editors' ) ?>">
							<h2><?php esc_html_e( 'No file editors', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Removes the theme and plugin editors from admin', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_author_archives' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_author_archives' ) ?>">
							<h2><?php esc_html_e( 'No author archives', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Redirect requests for author archives to the homepage', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_generator' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_generator' ) ?>">
							<h2><?php esc_html_e( 'No generator', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Remove the WordPress generator meta tag', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_rsd' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_rsd' ) ?>">
							<h2><?php esc_html_e( 'No RSD', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Remove the Really Simple Discovery endpoint', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_feeds' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_feeds' ) ?>">
							<h2><?php esc_html_e( 'No feeds', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Remove the RSS, RDF and atom feeds', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_shortlinks' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_shortlinks' ) ?>">
							<h2><?php esc_html_e( 'No shortlink tags', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Remove the shortlink header tags', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'no_pingbacks' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'no_pingbacks' ) ?>">
							<h2><?php esc_html_e( 'No pingbacks', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Prevent self pingbacks', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'embed_bandcamp' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'embed_bandcamp' ) ?>">
							<h2><?php esc_html_e( 'Embed bandcamp', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Enable support for the [bandcamp] shortcode  generated on bandcamp', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					
					<?php
					if ( 'astra' === get_template() ) { ?>					
					<li class="<?php cc_caboodle_module_classes( 'search_placeholder' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'search_placeholder' ) ?>">
							<h2><?php esc_html_e( 'Search placeholder', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Use translatable default text in Astra theme header cover search', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<li class="<?php cc_caboodle_module_classes( 'breakpoint' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'breakpoint' ) ?>">
							<h2><?php esc_html_e( 'Responsive breakpoints', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Set custom mobile and tablet breakpoints for the Astra theme', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<?php
					} ?>

					<?php
					if ( is_plugin_active( 'polylang/polylang.php' ) ) { ?>
										
					<li class="<?php cc_caboodle_module_classes( 'polylang' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'polylang' ) ?>">
							<h2><?php esc_html_e( 'Polylang SVG flags', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Replace the default bitmap flags in polylang', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<?php
					} ?>
					
					<?php
					if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) { ?>
					
					<li class="<?php cc_caboodle_module_classes( 'gform' ) ?>">
						<a class="module-content" href="<?php cc_caboodle_module_url( 'gform' ) ?>">
							<h2><?php esc_html_e( 'Gravity forms style', 'cubecolour-caboodle' ); ?></h2>
							<p><?php esc_html_e( 'Add some simple styles to forms created with the gravity forms plugin', 'cubecolour-caboodle' ); ?></p>
						</a>
					</li>
					<?php
					} ?>
					
				</ul>
						
			</div>

			<input class="input" name="tabs" type="radio" id="tab-2"/>
			<label class="label" for="tab-2"><?php esc_html_e( 'Import/export', 'cubecolour-caboodle' ); ?></label>
			<div class="panel">

				<div class="box-container">
		
					<div class="content-box">
						<h3><span><?php esc_html_e( 'Export caboodle settings', 'cubecolour-caboodle' ); ?></span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'Export the current plugin settings as a .json file.', 'cubecolour-caboodle' ); ?></p>
							<form method="post" id="export-form">
								<p><input type="hidden" name="cc_caboodle_action" value="export_settings" /></p>
								<div>
									<?php wp_nonce_field( 'cc_caboodle_export_nonce', 'cc_caboodle_export_nonce' ); ?>
									<?php submit_button( esc_html__( 'Export', 'cubecolour-caboodle' ), 'primary', 'submit', false ); ?>
								</div>
							</form>
						</div>
					</div>
		
					<div class="content-box">
						<h3><span><?php esc_html_e( 'Import caboodle settings', 'cubecolour-caboodle' ); ?></span></h3>
						<div class="inside">
							<p><?php esc_html_e( 'Import the plugin settings from a .json file.', 'cubecolour-caboodle' ); ?></p>
							<form method="post" enctype="multipart/form-data" id="import-form">
								<p>
									<input type="file" name="import_file"/>
								</p>
								<div>
									<input type="hidden" name="cc_caboodle_action" value="import_settings" />
									<?php wp_nonce_field( 'cc_caboodle_import_nonce', 'cc_caboodle_import_nonce' ); ?>
									<?php submit_button( esc_html__( 'Import', 'cubecolour-caboodle' ), 'primary', 'submit', false ); ?>
								</div>
							</form>
						</div>
					</div>
		
					<div id="show-settings-wrap">
		
						<span class="dashicons dashicons-text-page" id="show-caboodle-settings"></span>
		
						<div class="postbox" id="caboodle-settings">
		
							<span class="dashicons dashicons-no-alt" id="hide-caboodle-settings"></span>
							<?php
		
							/**
							 * Display the current values in the cc_caboodle option array
							 *
							 */
		
							?><pre><h2><?php esc_html_e( 'Current settings:', 'cubecolour-caboodle' ); ?></h2><?php
		
							if ( ( get_option( 'cc_caboodle' ) ) && ( is_array( get_option( 'cc_caboodle' ) ) ) ) {
								$option_values = ( get_option( 'cc_caboodle' ) );
		
								// reorder the array by keys in ascending alphbetical order
								ksort( $option_values );
		
								// Find the maximum length of the key
								$max_key_length = 0;
								
								foreach ( $option_values as $key => $value ) {
		
										$key_length = strlen( $key );
		
										if ( $key_length > $max_key_length ) {
		
												$max_key_length = $key_length;
										}
								}
		
								foreach ( $option_values as $key => $value ) {
									
									$spaces = $max_key_length + 5 - strlen($key);
		
									$key = "'" . $key . "'";
		
									if ( !is_int( $value ) ) {
										$value = "'" . $value . "'";
									}
										//echo esc_attr( "$key => $val" ) . ",\n";
										echo esc_attr( $key ) . esc_attr( str_repeat(' ', $spaces ) ) . ' => ' . esc_attr( $value ) . ",\n";
								}
		
							} else {
								esc_html_e( 'Yikes! The cc_caboodle option containing the array of setting values does not exist', 'cubecolour-caboodle' );
							}
							?></pre>
		
						</div>
					</div>
		
				</div>

			</div>
			
			<input class="input" name="tabs" type="radio" id="tab-3"/>
			<label class="label" for="tab-3"><?php esc_html_e( 'Documentation', 'cubecolour-caboodle' ); ?></label>
			<div class="panel">
			
			<p>Caboodle is a project by Cubecolour</p>
			
			<div class="youtubewrap"><iframe class="youtube" src="https://www.youtube.com/embed/FeEithfYb9w?si=YbofAcXY8U181ANx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
			
			<p>Documentation and Videos giving an overview of the features within Cubecolour Caboodle are currently in production and will be available on this page in a future update.</p>
			
			</div>

		</div>

	</div>
	<?php
}





/**
* Ensure wp_verify_nonce is available 
*
*/
include_once( ABSPATH . 'wp-includes/pluggable.php' );


/**
 * Process an export of the settings to a .json file
 *
 */
function cc_caboodle_process_settings_export() {

	if( empty( $_POST['cc_caboodle_action'] ) || 'export_settings' != $_POST['cc_caboodle_action'] )
		return;

	if( ! wp_verify_nonce( $_POST['cc_caboodle_export_nonce'], 'cc_caboodle_export_nonce' ) )
		return;

	if( ! current_user_can( 'manage_options' ) )
		return;

	ignore_user_abort( true );

	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=caboodle-settings-v' . esc_html( strtolower( CC_CABOODLE_PLUGIN_VERSION ) ) . '-' . esc_html( sanitize_title_with_dashes( get_bloginfo( 'name' ) ) ) . '-' . strtolower( wp_date( 'd-F-Y-His' ) ) . '.json' );
	header( "Expires: 0" );

	$export_values = get_option( 'cc_caboodle' );

	// reorder the array by keys in ascending alphbetical order
	ksort( $export_values);

	// Pass the array values throught the escape function and output as a file
	echo wp_json_encode( cc_caboodle_esc_array_values( $export_values ) );
	exit;
}
add_action( 'admin_init', 'cc_caboodle_process_settings_export' );


/**
 * Process an import of the settings from a .json file
 *
 */
function cc_caboodle_process_settings_import() {

	if( empty( $_POST['cc_caboodle_action'] ) || 'import_settings' != $_POST['cc_caboodle_action'] )
		return;

	if( ! isset( $_POST['cc_caboodle_import_nonce'] ) || ! wp_verify_nonce( $_POST['cc_caboodle_import_nonce'], 'cc_caboodle_import_nonce' ) )
		wp_die( esc_html__( 'Error: Nonce verification has failed', 'cubecolour-caboodle' ) );

	if( ! current_user_can( 'manage_options' ) )
		return;

	$extension = end( explode( '.', $_FILES['import_file']['name'] ) );

	if( $extension != 'json' ) {
		wp_die( esc_html__( 'Please upload a valid .json file', 'cubecolour-caboodle' ) );
	}

	$import_file = $_FILES['import_file']['tmp_name'];

	if( empty( $import_file ) ) {
		wp_die( esc_html__( 'Please upload a file to import', 'cubecolour-caboodle' ) );
	}

	// Use WordPress Filesystem API
	WP_Filesystem();
	global $wp_filesystem;

	$import = json_decode( $wp_filesystem->get_contents( $import_file ), true );

	// Pass the array values through the sanitize function (in helper-functions.php)
	$import = cc_caboodle_sanitize_array_values( $import );

	// Get list of expected keys
	$keys_list = cc_caboodle_initial_values();

	// Step over all items in the import array and delete any elements where the corresponding key does not exist in the keys list from the initial values
	foreach ( $import as $key => $val ) {

		if ( !array_key_exists( $key, $keys_list ) ) {
			unset( $import[$key] );
		}
	}

	// Reorder the array by keys in ascending alphabetical order
	ksort( $import );

	update_option( 'cc_caboodle', cc_caboodle_sanitize_array_values( $import ) );

	wp_safe_redirect( admin_url( 'options-general.php?page=caboodle&import=true&_wpnonce=' . wp_create_nonce('cc_caboodle_import_nonce') ) );
	
	exit;

}
add_action( 'admin_init', 'cc_caboodle_process_settings_import' );

/**
* Function to display success message: import
*
*/
function cc_caboodle_import_success_notice() {
		?>
		<div class="updated notice is-dismissible caboodle-success">
				<p><?php esc_html_e( 'The caboodle settings have been imported', 'cubecolour-caboodle' ); ?></p>
		</div>
		<?php
}


/**
 * Display success message on the caboodle settings page if an import has completed
 *
 */
if ( isset( $_GET['import'] ) && ( 'true' === $_GET['import'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'cc_caboodle_import_nonce' ) ) {
	add_action( 'admin_notices', 'cc_caboodle_import_success_notice' );
}
