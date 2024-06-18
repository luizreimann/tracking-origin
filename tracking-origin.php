<?php
/*
Plugin Name: Tracking Origin
Description: Plugin to track and display origin statistics of visitors.
Version: 1.0
Author: Luiz Reimann
Author URI: https://github.com/luizreimann/wp-tracking-origin
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

// Enqueue admin styles
function tracking_origin_enqueue_admin_styles() {
    wp_enqueue_style('tracking-origin-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css');
}
add_action('admin_enqueue_scripts', 'tracking_origin_enqueue_admin_styles');

// Include required files
require_once plugin_dir_path(__FILE__) . 'includes/admin-menu.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';
require_once plugin_dir_path(__FILE__) . 'includes/csv-export.php';
require_once plugin_dir_path(__FILE__) . 'includes/reset-counters.php';
require_once plugin_dir_path(__FILE__) . 'includes/remove-origin.php';

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
        
        $origins[$origin]['date'] = date('Y-m-d H:i:s', time() - 3*60*60);
        $origins[$origin]['user_agent'] = $user_agent;

        update_option('visited_origins', $origins);
    }
}
add_action('init', 'register_origin');
?>
