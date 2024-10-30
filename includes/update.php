<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Update the stored options array in the database
 *
 */
function cc_caboodle_update() {

$this_version = 'CC_CABOODLE_PLUGIN_VERSION';
$existing_version = cc_caboodle( 'caboodle_db_version', $this_version );

if ( isset( $existing_version ) && ( $this_version > $existing_version ) ) {

		switch ( $existing_version ) {
			case '1.0.4':

				cc_caboodle_update_option_value( 'caboodle_db_version', CC_CABOODLE_PLUGIN_VERSION );
				break;
			case '1.0.4':
			
				cc_caboodle_update_option_value( 'caboodle_db_version', CC_CABOODLE_PLUGIN_VERSION );
				break;
			case '1.0.3':

				cc_caboodle_update_option_value( 'caboodle_db_version', CC_CABOODLE_PLUGIN_VERSION );
				break;
		}

		// Once the update step has completed, update the value of the 'caboodle_db_version' option in the options array to match the current (this) version of the plugin
		cc_caboodle_update_option_value( 'caboodle_db_version', CC_CABOODLE_PLUGIN_VERSION );
	}
}