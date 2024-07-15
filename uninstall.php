<?php
// If uninstall is not called from WordPress, exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// Delete options from the database.
delete_option('visited_origins');
delete_option('last_time_counters_reset');
delete_option('reset_frequency');
?>
