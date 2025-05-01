<?php
/**
 * Booking processing functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// Make sure we have access to the helper functions
require_once dirname(__FILE__) . '/helpers.php';

/**
 * Process booking Ajax request
 */
function bike_theme_process_booking() {
    // Verify CSRF token
    if (!check_ajax_referer('bike_theme_csrf', 'csrf_token', false)) {
        wp_send_json_error(array('message' => __('Invalid security token. Please refresh the page and try again.', 'bike-theme')));
    }

    // Verify nonce
    if (!isset($_POST['bike_tour_booking_nonce']) ||
        !wp_verify_nonce($_POST['bike_tour_booking_nonce'], 'bike_tour_booking')) {
        wp_send_json_error(array('message' => __('Invalid security token.', 'bike-theme')));
    }

    // Add rate limiting
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'booking_attempt_' . md5($ip_address);
    $attempt_count = get_transient($transient_key);
    
    // if ($attempt_count === false) {
    //     set_transient($transient_key, 1, HOUR_IN_SECONDS);
    // } else {
    //     if ($attempt_count >= 5) { // Limit to 5 attempts per hour
    //         wp_send_json_error(array('message' => __('Too many booking attempts. Please try again later.', 'bike-theme')));
    //     }
    //     set_transient($transient_key, $attempt_count + 1, HOUR_IN_SECONDS);
    // }

    // Sanitize and validate form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $participants = intval($_POST['participants']);
    $message = sanitize_textarea_field($_POST['message']);
    $tour_id = intval($_POST['tour_id']);
    
    // Sanitize and validate rider details
    $rider_names = isset($_POST['rider_name']) ? array_map('sanitize_text_field', $_POST['rider_name']) : array();
    $rider_genders = isset($_POST['rider_gender']) ? array_map('sanitize_text_field', $_POST['rider_gender']) : array();
    $rider_weights = isset($_POST['rider_weight']) ? array_map('sanitize_text_field', $_POST['rider_weight']) : array();
    $rider_is_children = isset($_POST['rider_is_child']) ? $_POST['rider_is_child'] : array();

    // Validate required fields
    $errors = array();
    if (empty($name)) {
        $errors[] = __('Name is required', 'bike-theme');
    }
    if (empty($email)) {
        $errors[] = __('Email is required', 'bike-theme');
    }
    if (empty($phone)) {
        $errors[] = __('Phone is required', 'bike-theme');
    }
    if (empty($date)) {
        $errors[] = __('Date is required', 'bike-theme');
    }
    if ($participants < 1) {
        $errors[] = __('Number of participants must be at least 1', 'bike-theme');
    }
    if (!$tour_id) {
        $errors[] = __('Invalid tour selected', 'bike-theme');
    }
    if (count($rider_names) < $participants) {
        $errors[] = __('Please provide details for all riders', 'bike-theme');
    }

    if (!empty($errors)) {
        wp_send_json_error(array('message' => implode('<br>', $errors)));
    }

    // Calculate total price
    $price_per_person = bike_theme_get_tour_price($tour_id, $participants);
    $total_price = $price_per_person * $participants;

    // Create booking post
    $booking_data = array(
        'post_title'    => sprintf(__('Booking for %s - %s - %s', 'bike-theme'), get_the_title($tour_id), $name, $date),
        'post_type'     => 'bike_booking',
        'post_status'   => 'publish'
    );

    $booking_id = wp_insert_post($booking_data);

    if ($booking_id) {
        // Add booking meta data
        add_post_meta($booking_id, '_booking_tour_id', $tour_id);
        add_post_meta($booking_id, '_booking_customer_name', $name);
        add_post_meta($booking_id, '_booking_customer_email', $email);
        add_post_meta($booking_id, '_booking_customer_phone', $phone);
        add_post_meta($booking_id, '_booking_date', $date);
        add_post_meta($booking_id, '_booking_participants', $participants);
        add_post_meta($booking_id, '_booking_message', $message);
        add_post_meta($booking_id, '_booking_price_per_person', $price_per_person);
        add_post_meta($booking_id, '_booking_total_price', $total_price);
        add_post_meta($booking_id, '_booking_status', 'pending');
        add_post_meta($booking_id, '_booking_payment_status', 'pending');
        add_post_meta($booking_id, '_booking_type', 'tour');
        
        // Save rider details
        add_post_meta($booking_id, '_booking_rider_names', $rider_names);
        add_post_meta($booking_id, '_booking_rider_genders', $rider_genders);
        add_post_meta($booking_id, '_booking_rider_weights', $rider_weights);
        add_post_meta($booking_id, '_booking_rider_is_children', $rider_is_children);

        // Set booking status taxonomy
        wp_set_object_terms($booking_id, 'pending', 'booking_status');

        // Get selected additions if any
        $selected_additions = isset($_POST['additions']) ? $_POST['additions'] : array();
        $additions_data = array();
        
        if (!empty($selected_additions) && is_array($selected_additions)) {
            $tour_additions = bike_theme_get_tour_additions($tour_id);
            foreach ($tour_additions as $addition) {
                if (in_array($addition['name'], $selected_additions)) {
                    $additions_data[] = $addition;
                }
            }
            
            // Save additions data to the booking
            add_post_meta($booking_id, '_booking_additions', $additions_data);
            
            // Calculate additions total price
            $additions_total = bike_theme_calculate_additions_price($tour_id, $selected_additions, $participants);
            
            // Update total price to include additions
            $total_price += $additions_total;
            update_post_meta($booking_id, '_booking_total_price', $total_price);
        }

        // Send confirmation email to customer and admin
        $booking_data = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'date' => $date,
            'participants' => $participants,
            'message' => $message,
            'tour_id' => $tour_id,
            'price_per_person' => $price_per_person,
            'total_price' => $total_price,
            'additions' => $additions_data,
            'rider_names' => $rider_names,
            'rider_genders' => $rider_genders,
            'rider_weights' => $rider_weights,
            'rider_is_children' => $rider_is_children
        );
        
        $emails_sent = bike_theme_send_booking_emails($booking_id, $booking_data);

        wp_send_json_success(array(
            'message' => __('Your booking has been submitted successfully. We will contact you shortly.', 'bike-theme'),
            'booking_id' => $booking_id
        ));
    } else {
        wp_send_json_error(array('message' => __('Failed to create booking. Please try again.', 'bike-theme')));
    }
}
add_action('wp_ajax_bike_theme_process_booking', 'bike_theme_process_booking');
add_action('wp_ajax_nopriv_bike_theme_process_booking', 'bike_theme_process_booking');

/**
 * Setup initial booking statuses
 */
function bike_theme_setup_booking_statuses()
{
    // Only run once
    if (get_option('bike_theme_booking_statuses_created')) {
        return;
    }

    $statuses = array(
        'pending' => __('Pending', 'bike-theme'),
        'confirmed' => __('Confirmed', 'bike-theme'),
        'completed' => __('Completed', 'bike-theme'),
        'cancelled' => __('Cancelled', 'bike-theme'),
    );

    foreach ($statuses as $slug => $name) {
        if (!term_exists($slug, 'booking_status')) {
            wp_insert_term($name, 'booking_status', array('slug' => $slug));
        }
    }

    update_option('bike_theme_booking_statuses_created', true);
}
add_action('init', 'bike_theme_setup_booking_statuses'); 