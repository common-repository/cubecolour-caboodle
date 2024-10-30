<?php


if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Add link to show site settings (option values) in the admin settings menu
 * Register the settings page
 *
 */
function cc_caboodle_show_site_options() {
add_options_page( 
		'',
		__( 'Site Settings', 'cubecolour-caboodle' ),
		'manage_options',
		'options.php',
		''
	);
}
add_action( 'admin_menu', 'cc_caboodle_show_site_options' );
