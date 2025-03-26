<?php
// Load WordPress
require_once('../../../wp-load.php'); // Adjust path if necessary

// Check if form data is received via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_shipping';

    $types = $_POST['type'] ?? [];
    $couriers_type = $_POST['couriers_type'] ?? [];
    $shipping_prices = $_POST['shipping_price'] ?? [];
    $free_deliveries = $_POST['free_delivery'] ?? [];
    $show_prices = $_POST['show_price'] ?? [];
    $positions = $_POST['position'] ?? [];

      for ($i = 0; $i < count($types); $i++) {
        $type = sanitize_text_field($types[$i]);
        $courier = sanitize_text_field($couriers_type[$i]);
        $shipping_price = floatval($shipping_prices[$i]);
        $free_delivery = floatval($free_deliveries[$i]);
        $show_price = intval($show_prices[$i]);
        $position = intval($positions[$i]);

        // Check if entry exists
        $existing_entry = $wpdb->get_row($wpdb->prepare("SELECT id FROM $table_name WHERE type = %s", $type));

        if ($existing_entry) {
            // Update existing entry
            $wpdb->update(
                $table_name,
                [
                    'couriers_type' => $courier,
                    'shipping_price' => $shipping_price,
                    'free_delivery' => $free_delivery,
                    'show_price' => $show_price,
                    'position' => $position,
                    'updated_at' => current_time('mysql')
                ],
                ['id' => $existing_entry->id]
            );
        } else {
            // Insert new entry
            $wpdb->insert(
                $table_name,
                [
                    'type' => $type,
                    'couriers_type' => $courier,
                    'shipping_price' => $shipping_price,
                    'free_delivery' => $free_delivery,
                    'show_price' => $show_price,
                    'position' => $position,
                    'created_at' => current_time('mysql'),
                    'updated_at' => current_time('mysql')
                ]
            );
        }
    }
    echo '<div class="updated"><p>Shipping settings saved successfully!</p></div>';
}
?>
