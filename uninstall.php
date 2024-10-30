<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Exit if this plugin is not being uninstalled
 *
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

/**
 * Delete options for single site installation
 *
 */
delete_option( 'cc_caboodle' );

/**
 * Delete site options for multisite installation
 *
 */
delete_site_option( 'cc_caboodle' );