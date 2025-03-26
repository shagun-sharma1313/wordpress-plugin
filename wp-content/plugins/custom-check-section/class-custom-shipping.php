<?php
if (!class_exists('WC_Custom_Shipping_Method')) {
    class WC_Custom_Shipping_Method extends WC_Shipping_Method {
        
        public function __construct() {
            $this->id = 'custom_shipping';
            $this->method_title = __('Custom Shipping', 'woocommerce');
            $this->method_description = __('Custom shipping method with dynamic price.', 'woocommerce');

            $this->enabled = "yes";
            $this->title = "Custom Shipping";

            $this->init();
        }

        public function init() {
            $this->init_settings();
            $this->enabled = $this->get_option('enabled');
            $this->title = $this->get_option('title');
        }

        public function calculate_shipping($package = array()) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'your_shipping_table';

            // Fetch the latest shipping price from your table
            $shipping_data = $wpdb->get_row("SELECT * FROM $table_name ORDER BY id DESC LIMIT 1", ARRAY_A);
            $cost = !empty($shipping_data['shipping_price']) ? floatval($shipping_data['shipping_price']) : 0;

            // Add the rate
            $rate = array(
                'id'    => $this->id,
                'label' => $this->title,
                'cost'  => $cost,
            );

            $this->add_rate($rate);
        }
    }
}
