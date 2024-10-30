<?php
/*
Plugin Name: Plugin Readme Popup
Description: Adds a link to each plugin listed in the 'plugins' admin page that opens the plugin's parsed readme.txt file in a popup using JavaScript.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Include Parsedown library
require_once(plugin_dir_path(__FILE__) . 'parsedown.php');

// Add link to open parsed readme in popup
add_filter('plugin_action_links', 'add_readme_popup_link', 10, 2);

function add_readme_popup_link($actions, $plugin_file) {
    // Check if plugin file exists
    if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
        // Check if readme.txt file exists
        if (file_exists(WP_PLUGIN_DIR . '/' . dirname($plugin_file) . '/readme.txt')) {
            // Add link to open parsed readme in popup
            $actions['readme_popup'] = '<a href="#" class="readme-popup-link" data-plugin-file="' . esc_attr($plugin_file) . '">readme.txt</a>';
        }
    }
    return $actions;
}

// Enqueue JavaScript for popup
add_action('admin_enqueue_scripts', 'enqueue_readme_popup_script');

function enqueue_readme_popup_script($hook) {
    // Enqueue script only on the plugins page
    if ($hook === 'plugins.php') {
        // Enqueue JavaScript file
        wp_enqueue_script('readme-popup-script', CC_CABOODLE_PLUGIN_URL . 'js/plugin-readme-links-popup.js', array('jquery'), CC_CABOODLE_PLUGIN_VERSION, true);
        
        // Pass admin-ajax.php URL to the JavaScript
        wp_localize_script('readme-popup-script', 'readmePopupAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    }
}

// AJAX handler to get parsed readme content
add_action('wp_ajax_get_readme_content', 'get_readme_content_callback');
add_action('wp_ajax_nopriv_get_readme_content', 'get_readme_content_callback'); // Allow non-logged-in users to access AJAX

function get_readme_content_callback() {
    if (isset($_POST['plugin_file'])) {
        $plugin_file = sanitize_text_field($_POST['plugin_file']);
        // Check if plugin file exists
        if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
            // Get the content of readme.txt file
            $readme_content = file_get_contents(WP_PLUGIN_DIR . '/' . dirname($plugin_file) . '/readme.txt');
            // Parse the readme content using Parsedown
            $parsedown = new Parsedown();
            $parsed_content = $parsedown->text($readme_content);
            // Return the parsed content
            echo $parsed_content;
        }
    }
    // exit to avoid further execution
    wp_die();
}