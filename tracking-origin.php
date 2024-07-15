<?php
/*
Plugin Name: Tracking Origin
Description: Plugin to track and display origin statistics of visitors.
Version: 1.0.2
Author: Luiz Reimann
Author URI: https://github.com/luizreimann/tracking-origin
Text Domain: tracking-origin
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Load plugin text domain
function tracking_origin_load_textdomain() {
    load_plugin_textdomain('tracking-origin', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'tracking_origin_load_textdomain');

// Enqueue admin styles and scripts
function tracking_origin_enqueue_admin_styles_scripts() {
    $plugin_version = '1.0.2'; // Define the plugin version
    wp_enqueue_style('tracking-origin-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css', array(), $plugin_version);
    wp_enqueue_script('tracking-origin-admin-tabs', plugin_dir_url(__FILE__) . 'assets/js/admin-tabs.js', array('jquery'), $plugin_version, true);
}
add_action('admin_enqueue_scripts', 'tracking_origin_enqueue_admin_styles_scripts');

// Include required files
$plugin_includes = array(
    'views/admin-menu.php',
    'functions/create-menu.php',
    'functions/handle-post-requests.php',
    'functions/csv-export.php',
    'functions/reset-counters.php',
    'functions/remove-origin.php',
    'functions/reset-autocounters.php',
);

foreach ($plugin_includes as $file) {
    $filepath = plugin_dir_path(__FILE__) . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

// Function to register the origin
function register_origin() {
    if (isset($_GET['origin'])) {
        $origin = sanitize_text_field($_GET['origin']);
        $user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
        
        $origins = get_option('visited_origins', array());

        if (isset($origins[$origin]) && is_array($origins[$origin])) {
            $origins[$origin]['count'] += 1;
        } else {
            $origins[$origin] = array('count' => 1, 'date' => '', 'user_agent' => '');
        }
        
        $origins[$origin]['date'] = gmdate('Y-m-d H:i:s');
        $origins[$origin]['user_agent'] = $user_agent;

        update_option('visited_origins', $origins);
    }
}
add_action('init', 'register_origin');
?>