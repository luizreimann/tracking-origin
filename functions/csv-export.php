<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function export_csv_origins() {
    $origins = get_option('visited_origins', array());

    $csv_content = "Origin,Visits,Last Visit,Last User Agent\n";
    foreach ($origins as $origin => $data) {
        $count = isset($data['count']) ? $data['count'] : 0;
        $last_visit = isset($data['date']) ? get_date_from_gmt($data['date'], 'Y-m-d H:i:s') : esc_html__('N/A', 'tracking-origin');
        $user_agent = isset($data['user_agent']) ? $data['user_agent'] : 'N/A';
        $csv_content .= '"' . str_replace('"', '""', $origin) . '","' . $count . '","' . str_replace('"', '""', $last_visit) . '","' . str_replace('"', '""', $user_agent) . "\"\n";
    }

    // Send the CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="visited_origins_' . gmdate('d_m_Y') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Output the CSV content
    echo $csv_content;
    exit;
}

// Hook the function to handle the CSV export action
function handle_export_csv_action() {
    if (isset($_POST['action']) && $_POST['action'] === 'export_csv') {
        check_admin_referer('export_csv_action', 'export_csv_nonce');
        export_csv_origins();
    }
}
add_action('admin_init', 'handle_export_csv_action');
?>
