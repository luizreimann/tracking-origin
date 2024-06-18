<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to display statistics in the WordPress admin panel
function display_origin_statistics() {
    $origins = get_option('visited_origins', array());
    $last_time_counters_reset = get_option('last_time_counters_reset', 'N/A');

    echo '<div class="wrap">';
    echo '<h1>' . __('Origin Statistics', 'tracking-origin') . '</h1>';
    echo '<table class="widefat striped">';
    echo '<thead>';
    echo '<tr><th scope="col">' . __('Origin', 'tracking-origin') . '</th><th scope="col">' . __('Visits', 'tracking-origin') . '</th><th scope="col">' . __('Last Visit (UTC-3)', 'tracking-origin') . '</th><th scope="col">' . __('Last User Agent', 'tracking-origin') . '</th><th scope="col">' . __('Actions', 'tracking-origin') . '</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($origins as $origin => $data) {
        $count = isset($data['count']) ? $data['count'] : 0;
        $last_visit = isset($data['date']) ? $data['date'] : 'N/A';
        $user_agent = isset($data['user_agent']) ? $data['user_agent'] : 'N/A';
        echo '<tr>';
        echo '<td>' . esc_html($origin) . '</td>';
        echo '<td>' . esc_html($count) . '</td>';
        echo '<td>' . esc_html($last_visit) . '</td>';
        echo '<td>' . esc_html($user_agent) . '</td>';
        echo '<td>';
        echo '<form method="post" class="inline-block">';
        echo '<input type="hidden" name="action" value="remove_origin">';
        echo '<input type="hidden" name="origin" value="' . esc_attr($origin) . '">';
        echo '<button type="submit" class="button button-danger" title="' . __('Remove', 'tracking-origin') . '">';
        echo '<span class="dashicons dashicons-trash"></span>';
        echo '</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '<br><br><form method="post" class="inline-block margin-right-10">';
    echo '<input type="hidden" name="action" value="reset_counters">';
    echo '<button type="submit" class="button button-primary">' . __('Reset Counters', 'tracking-origin') . '</button>';
    echo '</form>';
    echo '<form method="post" class="inline-block">';
    echo '<input type="hidden" name="action" value="export_csv">';
    echo '<button type="submit" class="button button-secondary">' . __('Export CSV', 'tracking-origin') . '</button>';
    echo '</form>';
    echo '<p>' . __('Last time counters were reset:', 'tracking-origin') . ' ' . $last_time_counters_reset . '</p>';
    echo '</div>';
}

// Function to create the statistics menu in the WordPress admin panel
function create_origin_statistics_menu() {
    add_menu_page(__('Origin Statistics', 'tracking-origin'), __('Origin Statistics', 'tracking-origin'), 'manage_options', 'origin-statistics', 'display_origin_statistics', 'dashicons-networking', 10);
}
add_action('admin_menu', 'create_origin_statistics_menu');
?>
