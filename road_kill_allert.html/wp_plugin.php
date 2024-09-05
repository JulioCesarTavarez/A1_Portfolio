<?php
/**
 * Plugin Name: Animal Roadkill Tracker
 * Description: A plugin to track road killed animals by name, photo, and location, and display them with links to Google Maps.
 * Version: 1.0
 * Author: Your Name
 */

// Hook for creating the form and processing submissions
add_shortcode('animal_form', 'animal_form_function');

// Enqueue JavaScript for geolocation
function enqueue_geolocation_script() {
    wp_enqueue_script('geolocation-script', plugins_url('/js/geolocation.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('geolocation-script', 'geoData', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_geolocation_script');

// Create the form with name, photo, and geolocation
function animal_form_function() {
    ob_start();
    ?>
    <form id="animal-form" method="post" enctype="multipart/form-data">
        <div class="entry">
            <label for="animal-name">Animal Name:</label>
            <input type="text" id="animal-name" name="animal_name" required>
        </div>

        <div class="entry">
            <label for="animal-photo">Animal Photo:</label>
            <input type="file" id="animal-photo" name="animal_photo" accept="image/*" required>
        </div>

        <div class="entry">
            <label for="Location">Location:</label>
            <p id="geolocation"></p>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <button type="button" id="get-location" class="locationButton">Get Location</button>
        </div>

        <input type="submit" name="submit_animal" value="Submit">
    </form>

    <div id="location-message"></div>
    <?php
    if (isset($_POST['submit_animal'])) {
        handle_animal_submission();
    }
    return ob_get_clean();
}

// Handle form submission, save data to the database
function handle_animal_submission() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'animals';

    // Check for file upload
    if (!empty($_FILES['animal_photo']['name'])) {
        $uploaded = media_handle_upload('animal_photo', 0);
        if (is_wp_error($uploaded)) {
            echo 'Error uploading image.';
            return;
        }
    }

    // Insert into database
    $wpdb->insert(
        $table_name,
        array(
            'name' => sanitize_text_field($_POST['animal_name']),
            'photo' => $uploaded,
            'latitude' => sanitize_text_field($_POST['latitude']),
            'longitude' => sanitize_text_field($_POST['longitude']),
            'submission_time' => current_time('mysql')
        )
    );
    echo 'Animal submitted successfully!';
}

// Create a table on plugin activation
function create_animal_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'animals';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        photo text NOT NULL,
        latitude varchar(100) NOT NULL,
        longitude varchar(100) NOT NULL,
        submission_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_animal_table');

// Shortcode to display animals on the homepage
add_shortcode('display_animals', 'display_animals_function');

function display_animals_function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'animals';
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    if (!empty($results)) {
        echo '<main>';
        echo '<a href="#"><button class="Insert">Insert a road kill</button></a>';
        foreach ($results as $row) {
            // Convert the photo URL and location
            $photo_url = wp_get_attachment_url($row->photo);
            $google_maps_url = 'https://www.google.com/maps/search/?api=1&query=' . esc_html($row->latitude) . ',' . esc_html($row->longitude);

            echo '<button class="animal" onclick="window.location.href=\'' . $google_maps_url . '\'">';
            echo '<p class="animal-type">' . esc_html($row->name) . '</p>';
            echo '<p class="date">' . date('m/d/Y', strtotime($row->submission_time)) . '</p>';
            echo '<p class="location">' . esc_html($row->latitude) . ', ' . esc_html($row->longitude) . '</p>';
            echo '</button>';
        }
        echo '</main>';
    } else {
        echo 'No animals tracked yet.';
    }
}

// JavaScript for geolocation
function geolocation_script() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('#get-location').on('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                $('#location-message').text("Geolocation is not supported by this browser.");
            }
        });

        function showPosition(position) {
            $('#latitude').val(position.coords.latitude);
            $('#longitude').val(position.coords.longitude);
            $('#location-message').text("Location captured successfully.");
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'geolocation_script');

?>
