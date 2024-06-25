<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function export_csv_origins() {
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
    }

    $origins = get_option('visited_origins', array());

    $upload_dir = wp_upload_dir();
    $csv_file_path = trailingslashit($upload_dir['path']) . 'visited_origins_' . gmdate('d_m_Y') . '.csv';
    
    $csv_content = "Origin,Visits,Last Visit,Last User Agent\n";
    foreach ($origins as $origin => $data) {
        $count = isset($data['count']) ? $data['count'] : 0;
        $last_visit = isset($data['date']) ? $data['date'] : esc_html__('N/A', 'tracking-origin');
        $user_agent = isset($data['user_agent']) ? $data['user_agent'] : esc_html__('N/A', 'tracking-origin');
        $csv_content .= '"' . esc_html($origin) . '","' . esc_html($count) . '","' . esc_html($last_visit) . '","' . esc_html($user_agent) . "\"\n";
    }

    if (!$wp_filesystem->put_contents($csv_file_path, $csv_content, FS_CHMOD_FILE)) {
        wp_die(esc_html__('Error saving file!', 'tracking-origin'));
    }

    $csv_content = $wp_filesystem->get_contents($csv_file_path);
    if ($csv_content === false) {
        wp_die(esc_html__('Error reading file!', 'tracking-origin'));
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="visited_origins_' . esc_html(gmdate('d_m_Y')) . '.csv"');
    header('Content-Length: ' . esc_html(strlen($csv_content)));
    echo esc_html($csv_content);

    $wp_filesystem->delete($csv_file_path);
}
?>
