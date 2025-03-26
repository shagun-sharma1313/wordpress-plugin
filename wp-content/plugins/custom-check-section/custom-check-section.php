<?php
/**
 * Plugin Name: Custom Shipping
 * Description: Adds a custom menu item in the WordPress admin panel.
 * Version: 1.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
function custom_shipping_enqueue_assets() {
    wp_enqueue_style('custom-shipping-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('custom-shipping-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'custom_shipping_enqueue_assets');


function load_custom_shipping_method() {
    require_once plugin_dir_path(__FILE__) . 'class-custom-shipping.php';
}
add_action('woocommerce_shipping_init', 'load_custom_shipping_method');

// Hook to add the menu item
function custom_check_section_menu() {
    add_menu_page(
        'Custom Shipping ',    // Page title
        'Custom Shipping',            // Menu title
        'manage_options',          // Capability
        'custom-shipping-section',    // Menu slug
        'custom_shipping_page', // Callback function
        'dashicons-visibility',    // Icon
        25                         // Position
    );
}
add_action('admin_menu', 'custom_check_section_menu');

function custom_shipping_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "custom_shipping";
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(255) NOT NULL,
        courier_type VARCHAR(255) DEFAULT NULL,
        shipping_price DECIMAL(10,2) DEFAULT NULL,
        free_delivery DECIMAL(10,2) DEFAULT NULL,
        show_price TINYINT(1) DEFAULT DEFAULT 0,
        position INT(11) DEFAULT DEFAULT 0
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Hook to run on plugin activation
register_activation_hook(__FILE__, 'custom_shipping_create_table');



// Callback function to display page content
function custom_shipping_page() {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_shipping_settings'])) {
        custom_shipping_save_settings();
    }
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_shipping'; // Adjust table name
    $shipping_data = $wpdb->get_results("SELECT * FROM $table_name  ", ARRAY_A);
    //  print_r($shipping_data);die;
    ?>
   <div class="wrap">
        <h1>Custom Shipping</h1>
       <form method="POST" action="">
        <div class="shipping-main-layout">
            <div class="shipping-main-card">
                <div class="shipping-main-heading">
                    <h4>Courier Setting</h4>
                </div>
                <div class="layout-cards">
                    <?php foreach($shipping_data as $shipping_fields) {
                    if($shipping_fields['type'] == 'Econt'){
                    ?>
                    <div class="econt-card">
                        <div class="toggle-heading">
                            <img src="<?php echo plugin_dir_url(__FILE__);?>/assets/images/econt.png" alt="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </div>
                        <div class="card-input">
                            <input type="hidden" name="type[]" value="Econt">
                            <label class="choose-label shipping-label">Choose Couriers</label>
                            <select class="form-select shipping-select-box" name="couriers_type[]" aria-label="Default select example">
                                <option selected>Econt</option>
                                <!-- <option value="1">Speedy</option> -->
                            </select>
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Shipping price</label><br>
                            <input type="text" placeholder="Shipping Price" name="shipping_price[]" value="<?php echo $shipping_fields['shipping_price'] ?>">
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Free Delivery over:</label><br>
                            <input type="text" placeholder="Shipping Price" name="free_delivery[]" value="<?php echo $shipping_fields['free_delivery'] ?>">
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Show Econt Price</label>
                            <select class="form-select shipping-select-box" aria-label="Default select econt example" name="show_price[]">
                                <option selected value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Position</label><br>
                            <select class="form-select shipping-select-box" aria-label="Default select example" name="position[]">
                                <option selected>3</option>
                                <option value="1">2</option>
                            </select>
                        </div>
                    </div>
                    <?php }  if($shipping_fields['type'] == 'Speedy'){?>
                    <div class="econt-card">
                        <div class="toggle-heading">
                            <img src="<?php echo plugin_dir_url(__FILE__);?>/assets/images/speedy.png" alt="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </div>
                        <div class="card-input">
                            <input type="hidden" name="type[]" value="Speedy">
                            <label class="choose-label shipping-label">Choose Couriers</label>
                            <select class="form-select shipping-select-box" name="couriers_type[]" aria-label="Default select example">
                                <option selected>Speedy</option>
                                <!-- <option value="1">Speedy</option> -->
                            </select>
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Shipping price</label><br>
                            <input type="text" placeholder="Shipping Price" name="shipping_price[]" value="<?php echo $shipping_fields['shipping_price'] ?>">
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Free Delivery over:</label><br>
                            <input type="text" placeholder="Shipping Price" name="free_delivery[]" value="<?php echo $shipping_fields['free_delivery'] ?>">
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Show Speedy Price</label>
                            <select class="form-select shipping-select-box" aria-label="Default select speedy example" name="show_price[]">
                                <option selected value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Position</label><br>
                            <select class="form-select shipping-select-box" aria-label="Default select example" name="position[]">
                                <option selected>3</option>
                                <option value="1">2</option>
                            </select>
                        </div>
                    </div>
                    <?php } if($shipping_fields['type'] == 'other'){?>
                    <div class="econt-card">
                        <div class="toggle-heading">
                            <img src="<?php echo plugin_dir_url(__FILE__);?>/assets/images/location.png" alt="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            </div>
                        </div>
                        <div class="card-input">
                            <input type="hidden" name="type[]" value="other">
                            <label class="choose-label shipping-label">Choose Couriers</label>
                            <select class="form-select shipping-select-box" name="couriers_type[]" aria-label="Default select example">
                                <option value="Econt">Econt</option>
                                <option value="Speedy">Speedy</option>
                            </select>
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Shipping price</label><br>
                            <input type="text" placeholder="Shipping Price" name="shipping_price[]"
                            value="<?php echo $shipping_fields['shipping_price'] ?>">
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Free Delivery over:</label><br>
                            <input type="text" placeholder="Shipping Price" name="free_delivery[]" value="<?php echo $shipping_fields['free_delivery'] ?>">
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Show Default Price</label>
                            <select class="form-select shipping-select-box" aria-label="Default select default example" name="show_price[]">
                                <option selected value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="card-input">
                            <label class="choose-label shipping-label">Position</label><br>
                            <select class="form-select shipping-select-box" aria-label="Default select example" name="position[]">
                                <option selected>3</option>
                                <option value="1">2</option>
                            </select>
                        </div>
                    </div>
                    <?php  } } ?>
                </div>
            </div>

            <div class="save-btn-group">
                <button type="submit" class="back-btn">Back</button>
                <button type="submit" name="save_shipping_settings" class="save-btn">Save</button>
            </div>
        </div>
      </form>
   </div>

<?php
}

function custom_shipping_save_settings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_shipping';

    $types = $_POST['type'] ?? [];
    $couriers_type = $_POST['couriers_type'] ?? [];
    $shipping_prices = $_POST['shipping_price'] ?? [];
    $free_deliveries = $_POST['free_delivery'] ?? [];
    $show_prices = $_POST['show_price'] ?? [];
    $positions = $_POST['position'] ?? [];

      for ($i = 0; $i < count($types); $i++) {
        $type = $types[$i];
        $courier = $couriers_type[$i];
        $shipping_price = $shipping_prices[$i];
        $free_delivery = $free_deliveries[$i];
        $show_price = $show_prices[$i];
        $position = $positions[$i];

        // Check if entry exists
        $existing_entry = $wpdb->get_row($wpdb->prepare("SELECT id FROM $table_name WHERE type = %s", $type));

        if ($existing_entry) {
            // Update existing entry
            $wpdb->update(
                $table_name,
                [
                    'type' => $type,
                    'courier_type' => $courier,
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

            $sata = $wpdb->insert(
                $table_name,
                [
                    'type' => $type,
                    'courier_type' => $courier,
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
