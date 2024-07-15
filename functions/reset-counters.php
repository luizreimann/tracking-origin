<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function reset_counters() {
    $origins = get_option('visited_origins', array());

    foreach ($origins as $origin => $data) {
        $origins[$origin]['count'] = 0;
    }

    update_option('visited_origins', $origins);
    update_option('last_time_counters_reset', gmdate('Y-m-d H:i:s', time() - 3*60*60));

    echo '<div id="message" class="updated notice is-dismissible"><p>' . esc_html__('Origin counters reset successfully!', 'tracking-origin') . '</p></div>';
}
?>