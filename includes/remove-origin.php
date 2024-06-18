<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to remove an origin
function remove_origin() {
    if (isset($_POST['action']) && $_POST['action'] === 'remove_origin' && isset($_POST['origin'])) {
        $origin = sanitize_text_field($_POST['origin']);
        $origins = get_option('visited_origins', array());

        if (isset($origins[$origin])) {
            unset($origins[$origin]);
        }

        update_option('visited_origins', $origins);

        echo '<div id="message" class="updated notice is-dismissible"><p>' . __('Origin removed successfully!', 'tracking-origin') . '</p></div>';
    }
}
add_action('admin_init', 'remove_origin');
?>
