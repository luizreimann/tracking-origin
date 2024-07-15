<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Create the admin menu
function create_tracking_origin_menu() {
    add_menu_page(__('Tracking Origin', 'tracking-origin'), __('Tracking Origin', 'tracking-origin'), 'manage_options', 'origin-statistics', 'display_tracking_origin', 'dashicons-networking', 10);
}
add_action('admin_menu', 'create_tracking_origin_menu');