<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Limit saved revisions
 *
 */
function cc_caboodle_limit_revisions(){
	if ( !defined( 'WP_POST_REVISIONS' ) ){
		define('WP_POST_REVISIONS', intval( cc_caboodle( "limit_revisions_qty", -1 ) ) );
	}
}
add_action( 'plugins_loaded', 'cc_caboodle_limit_revisions', 0 );