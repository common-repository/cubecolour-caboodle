<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * No lazy loading
 *
 */
add_filter( 'wp_lazy_loading_enabled', '__return_false' );