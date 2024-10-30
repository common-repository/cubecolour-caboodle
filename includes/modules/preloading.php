<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
* Enqueue instant-page script as a module for preloading
* https://instant.page/
*
*/
function cc_caboodle_enqueue_module_instload() {
	
	$version = '5.2.0';
	
	wp_enqueue_script_module( '@cubecolour-caboodle/instant-page', CC_CABOODLE_PLUGIN_URL . 'js/instant-page.js', array(''), $version );
}
add_action( 'wp_enqueue_scripts', 'cc_caboodle_enqueue_module_instload' );