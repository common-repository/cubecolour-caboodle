<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Remove RSD (Really Simple Discovery) Links
 *
 */
remove_action( 'wp_head', 'rsd_link' );