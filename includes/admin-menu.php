<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to display statistics in the WordPress admin panel
function display_origin_statistics() {
    $origins = get_option('visited_origins', array());
    $last_time_counters_reset = get_option('last_time_counters_reset', 'N/A');
    $reset_frequency = get_option('reset_frequency', '');
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'origins';

    ob_start();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Tracking Origin', 'tracking-origin'); ?></h1>
        <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
            <div id="message" class="updated notice is-dismissible">
                <p><?php esc_html_e('Options saved successfully!', 'tracking-origin'); ?></p>
            </div>
        <?php endif; ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=origin-statistics&tab=origins" class="nav-tab <?php echo $tab === 'origins' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Origins', 'tracking-origin'); ?></a>
            <a href="?page=origin-statistics&tab=options" class="nav-tab <?php echo $tab === 'options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Options', 'tracking-origin'); ?></a>
        </h2>
        <div id="origins" class="tab-content" style="display: <?php echo $tab === 'origins' ? 'block' : 'none'; ?>;">
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th scope="col"><?php esc_html_e('Origin', 'tracking-origin'); ?></th>
                        <th scope="col"><?php esc_html_e('Visits', 'tracking-origin'); ?></th>
                        <th scope="col"><?php esc_html_e('Last Visit', 'tracking-origin'); ?></th>
                        <th scope="col"><?php esc_html_e('Last User Agent', 'tracking-origin'); ?></th>
                        <th scope="col"><?php esc_html_e('Actions', 'tracking-origin'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($origins as $origin => $data) :
                        $count = isset($data['count']) ? $data['count'] : 0;
                        $last_visit = isset($data['date']) ? $data['date'] : esc_html__('N/A', 'tracking-origin');
                        $user_agent = isset($data['user_agent']) ? $data['user_agent'] : esc_html__('N/A', 'tracking-origin');
                        ?>
                        <tr>
                            <td><?php echo esc_html($origin); ?></td>
                            <td><?php echo esc_html($count); ?></td>
                            <td><?php echo esc_html($last_visit); ?></td>
                            <td><?php echo esc_html($user_agent); ?></td>
                            <td>
                                <form method="post" class="inline-block">
                                    <?php wp_nonce_field('remove_origin_action', 'remove_origin_nonce'); ?>
                                    <input type="hidden" name="action" value="remove_origin">
                                    <input type="hidden" name="origin" value="<?php echo esc_attr($origin); ?>">
                                    <button type="submit" class="button button-danger" title="<?php esc_attr_e('Remove', 'tracking-origin'); ?>">
                                        <span class="dashicons dashicons-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br><br>
            <form method="post" class="inline-block margin-right-10">
                <?php wp_nonce_field('reset_counters_action', 'reset_counters_nonce'); ?>
                <input type="hidden" name="action" value="reset_counters">
                <button type="submit" class="button button-primary"><?php esc_html_e('Reset Counters', 'tracking-origin'); ?></button>
            </form>
            <form method="post" class="inline-block">
                <?php wp_nonce_field('export_csv_action', 'export_csv_nonce'); ?>
                <input type="hidden" name="action" value="export_csv">
                <button type="submit" class="button button-secondary"><?php esc_html_e('Export CSV', 'tracking-origin'); ?></button>
            </form>
            <p><?php esc_html_e('Last time counters were reset:', 'tracking-origin'); ?> <?php echo esc_html($last_time_counters_reset); ?></p>
        </div>
        <div id="options" class="tab-content" style="display: <?php echo $tab === 'options' ? 'block' : 'none'; ?>;">
            <form method="post" action="options.php">
                <?php settings_fields('tracking_origin_options_group'); ?>
                <?php do_settings_sections('tracking_origin_options_group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Reset Counters Automatically Every', 'tracking-origin'); ?></th>
                        <td>
                            <input type="number" name="reset_frequency" min="1" max="30" placeholder="<?php esc_attr_e('Day', 'tracking-origin'); ?>" value="<?php echo esc_attr($reset_frequency); ?>" />
                            <p class="description"><?php esc_html_e('Enter a number between 1 and 30 to reset counters automatically every N days. Leave empty to disable.', 'tracking-origin'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
    <?php
    echo wp_kses_post(ob_get_clean());
}

// Function to create the statistics menu in the WordPress admin panel
function create_origin_statistics_menu() {
    add_menu_page(__('Tracking Origin', 'tracking-origin'), __('Tracking Origin', 'tracking-origin'), 'manage_options', 'origin-statistics', 'display_origin_statistics', 'dashicons-networking', 10);
}
add_action('admin_menu', 'create_origin_statistics_menu');
?>