<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to generate and send the CSV
function export_csv_origins() {
    if (isset($_POST['action']) && $_POST['action'] === 'export_csv') {
        $origins = get_option('visited_origins', array());
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="visited_origins.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, array(__('Origin', 'tracking-origin'), __('Visits', 'tracking-origin'), __('Last Visit (UTC-3)', 'tracking-origin'), __('Last User Agent', 'tracking-origin')));

        foreach ($origins as $origin => $data) {
            fputcsv($output, array(
                $origin,
                $data['count'],
                $data['date'],
                $data['user_agent']
            ));
        }

        fclose($output);
        exit;
    }
}
add_action('admin_init', 'export_csv_origins');
?>
