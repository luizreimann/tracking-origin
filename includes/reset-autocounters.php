<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function tracking_origin_register_settings() {
    register_setting('tracking_origin_options_group', 'reset_frequency');
}
add_action('admin_init', 'tracking_origin_register_settings');

function tracking_origin_schedule_reset() {
    $reset_frequency = get_option('reset_frequency', '');
    if ($reset_frequency) {
        if (!wp_next_scheduled('tracking_origin_reset_event')) {
            wp_schedule_event(time(), 'daily', 'tracking_origin_reset_event');
        }
    } else {
        wp_clear_scheduled_hook('tracking_origin_reset_event');
    }
}
add_action('admin_init', 'tracking_origin_schedule_reset');
add_action('tracking_origin_reset_event', 'tracking_origin_check_and_reset_counters');

function tracking_origin_check_and_reset_counters() {
    $reset_frequency = get_option('reset_frequency', '');
    if ($reset_frequency) {
        $last_reset = get_option('last_time_counters_reset', '');
        $current_date = gmdate('Y-m-d');
        $days_since_last_reset = (strtotime($current_date) - strtotime($last_reset)) / (60 * 60 * 24);
        if ($days_since_last_reset >= $reset_frequency) {
            reset_counters();
        }
    }
}
?>