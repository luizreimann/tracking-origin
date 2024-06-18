<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to process the reset counters form submission
function process_reset_counters() {
    if (isset($_POST['action']) && $_POST['action'] === 'reset_counters') {
        reset_origin_counters();
    }
}
add_action('admin_init', 'process_reset_counters');
?>
