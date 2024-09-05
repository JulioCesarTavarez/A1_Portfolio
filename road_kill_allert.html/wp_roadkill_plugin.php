<?php
/**
 * Plugin Name: Animal Roadkill Tracker
 * Description: A plugin to track road killed animals by name, photo, and location, and display them with links to Google Maps.
 * Version: 1.1
 * Author: Julio Tavarez
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

    <div id="animal-list"></div> <!-- Placeholder for the animal information -->
    
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
            echo 'Error uploading image: ' . $uploaded->get_error_message();
            return;
        }
    } else {
        $uploaded = ''; // Handle the case where no image is uploaded
    }

    // Insert into database
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'name' => sanitize_text_field($_POST['animal_name']),
            'photo' => $uploaded,
            'latitude' => sanitize_text_field($_POST['latitude']),
            'longitude' => sanitize_text_field($_POST['longitude']),
            'submission_time' => current_time('mysql')
        )
    );

    if ($inserted) {
        echo 'Animal submitted successfully!';
        // Display the animal info right below the form
        display_animal($wpdb->insert_id);
    } else {
        echo 'Error submitting the animal to the database.';
    }
}

// Display the specific animal's information and buttons (after form submission)
function display_animal($animal_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'animals';
    $animal = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $animal_id));

    if ($animal) {
        $photo_url = wp_get_attachment_url($animal->photo);
        $google_maps_url = 'https://www.google.com/maps/search/?api=1&query=' . esc_html($animal->latitude) . ',' . esc_html($animal->longitude);

        // Display the animal info and buttons
        echo '<div id="animal-' . esc_attr($animal_id) . '">';
        echo '<p><strong>' . esc_html($animal->name) . '</strong> (' . esc_html(date('m/d/Y', strtotime($animal->submission_time))) . ')</p>';
        echo '<img src="' . esc_url($photo_url) . '" alt="' . esc_html($animal->name) . '" style="max-width: 300px;"/>';
        echo '<br><button class="delete-animal" data-id="' . esc_attr($animal_id) . '">Delete Animal</button>';
        echo '<button class="goto-map" data-lat="' . esc_attr($animal->latitude) . '" data-lng="' . esc_attr($animal->longitude) . '">Go To</button>';
        echo '</div>';
    }
}

// Delete the specific animal using AJAX
function delete_animal() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'animals';
    $animal_id = intval($_POST['animal_id']);

    $deleted = $wpdb->delete($table_name, array('id' => $animal_id));
    if ($deleted) {
        echo 'Animal deleted successfully.';
    } else {
        echo 'Error deleting the animal.';
    }
    wp_die();
}
add_action('wp_ajax_delete_animal', 'delete_animal');

// JavaScript for geolocation and animal handling
function geolocation_script() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Geolocation functionality
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

        // Delete animal functionality
        $(document).on('click', '.delete-animal', function() {
            var animalId = $(this).data('id');
            $.post(geoData.ajax_url, {
                action: 'delete_animal',
                animal_id: animalId
            }, function(response) {
                alert(response);
                $('#animal-' + animalId).remove(); // Remove the animal from the page
            });
        });

        // Go to Google Maps functionality
        $(document).on('click', '.goto-map', function() {
            var lat = $(this).data('lat');
            var lng = $(this).data('lng');
            var googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' + lat + ',' + lng;
            window.open(googleMapsUrl, '_blank');
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'geolocation_script');
?>
