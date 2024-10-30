<?php

if ( ! defined( 'ABSPATH' ) ) exit;


/**
* Add the 'New' & 'beta' links to the Add Plugins Page
*
*/
function cc_caboodle_new_plugins( $tabs ) {

	$tabs = array('new' => _x( 'New', 'Plugin Installer' ) ) + $tabs;
	$tabs['beta'] = _x( 'Beta Testing', 'Plugin Installer' );

	return $tabs;
}

add_filter( 'install_plugins_tabs', 'cc_caboodle_new_plugins' );