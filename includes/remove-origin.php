<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function remove_origin() {
    if (isset($_POST['origin'])) {
        $origin = sanitize_text_field(wp_unslash($_POST['origin']));
        $origins = get_option('visited_origins', array());

        if (isset($origins[$origin])) {
            unset($origins[$origin]);
        }

        update_option('visited_origins', $origins);

        echo '<div id="message" class="updated notice is-dismissible"><p>' . esc_html__('Origin removed successfully!', 'tracking-origin') . '</p></div>';
    }
}
?>