<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function handle_post_requests() {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'reset_counters':
                if (!isset($_POST['reset_counters_nonce']) || !wp_verify_nonce($_POST['reset_counters_nonce'], 'reset_counters_action')) {
                    wp_die('Security check failed');
                }
                reset_counters();
                break;
                
            case 'remove_origin':
                if (!isset($_POST['remove_origin_nonce']) || !wp_verify_nonce($_POST['remove_origin_nonce'], 'remove_origin_action')) {
                    wp_die('Security check failed');
                }
                remove_origin();
                break;

            case 'export_csv':
                if (!isset($_POST['export_csv_nonce']) || !wp_verify_nonce($_POST['export_csv_nonce'], 'export_csv_action')) {
                    wp_die('Security check failed');
                }
                export_csv_origins();
                break;
        }
    }
}
add_action('admin_init', 'handle_post_requests');
?>