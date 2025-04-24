<?php
/**
 * Booking form handlers
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// Make sure we have access to the helper functions
require_once dirname(__FILE__) . '/helpers.php';

/**
 * Process booking form submission
 */
function bike_theme_submit_booking()
{
    if (!isset($_POST['booking_nonce']) || !wp_verify_nonce($_POST['booking_nonce'], 'bike_theme_booking_nonce')) {
        wp_die(__('Security check failed. Please try again.', 'bike-theme'));
    }

    // Get and sanitize form data
    $customer_name = sanitize_text_field($_POST['name']);
    $customer_email = sanitize_email($_POST['email']);
    $customer_phone = sanitize_text_field($_POST['phone']);
    $booking_date = sanitize_text_field($_POST['date']);
    $number_of_participants = intval($_POST['participants']);
    $tour_id = isset($_POST['tour']) ? intval($_POST['tour']) : 0;
    $bike_id = isset($_POST['bike']) ? intval($_POST['bike']) : 0;
    $message = sanitize_textarea_field($_POST['message']);
    $payment_method = sanitize_text_field($_POST['payment_method']);

    // Validate required fields
    $errors = array();
    if (empty($customer_name)) {
        $errors[] = __('Name is required', 'bike-theme');
    }
    if (empty($customer_email)) {
        $errors[] = __('Email is required', 'bike-theme');
    }
    if (empty($customer_phone)) {
        $errors[] = __('Phone is required', 'bike-theme');
    }
    if (empty($booking_date)) {
        $errors[] = __('Date is required', 'bike-theme');
    }
    if ($number_of_participants < 1) {
        $errors[] = __('Number of participants must be at least 1', 'bike-theme');
    }
    if (!$tour_id && !$bike_id) {
        $errors[] = __('Please select either a tour or a bike', 'bike-theme');
    }

    if (!empty($errors)) {
        $error_message = implode('<br>', $errors);
        wp_redirect(add_query_arg(array(
            'booking' => 'error',
            'message' => urlencode($error_message)
        ), wp_get_referer()));
        exit;
    }

    // Calculate prices if tour is selected
    $price_per_person = 0;
    $total_price = 0;
    if ($tour_id > 0) {
        $price_per_person = bike_theme_get_tour_price($tour_id, $number_of_participants);
        $total_price = $price_per_person * $number_of_participants;
    }

    // Create descriptive booking title
    $booking_title = '';
    if ($tour_id > 0) {
        $booking_title = sprintf(
            __('%s - %s (%d participants) - %s', 'bike-theme'),
            html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'),
            $customer_name,
            $number_of_participants,
            $booking_date
        );
    } elseif ($bike_id > 0) {
        $booking_title = sprintf(
            __('%s - %s - %s', 'bike-theme'),
            html_entity_decode(get_the_title($bike_id), ENT_QUOTES, 'UTF-8'),
            $customer_name,
            $booking_date
        );
    }

    // Create booking post
    $booking_data = array(
        'post_title' => $booking_title,
        'post_status' => 'publish',
        'post_type' => 'bike_booking',
    );

    $booking_id = wp_insert_post($booking_data);

    if ($booking_id) {
        // Save booking meta with proper field names
        update_post_meta($booking_id, '_booking_customer_name', $customer_name);
        update_post_meta($booking_id, '_booking_customer_email', $customer_email);
        update_post_meta($booking_id, '_booking_customer_phone', $customer_phone);
        update_post_meta($booking_id, '_booking_date', $booking_date);
        update_post_meta($booking_id, '_booking_participants', $number_of_participants);
        update_post_meta($booking_id, '_booking_message', $message);
        update_post_meta($booking_id, '_booking_payment_method', $payment_method);
        update_post_meta($booking_id, '_booking_price_per_person', $price_per_person);
        update_post_meta($booking_id, '_booking_total_price', $total_price);

        if ($tour_id > 0) {
            update_post_meta($booking_id, '_booking_tour_id', $tour_id);
            update_post_meta($booking_id, '_booking_type', 'tour');
        }
        if ($bike_id > 0) {
            update_post_meta($booking_id, '_booking_bike_id', $bike_id);
            update_post_meta($booking_id, '_booking_type', 'bike');
        }

        // Set initial booking status
        wp_set_object_terms($booking_id, 'pending', 'booking_status');
        update_post_meta($booking_id, '_booking_status', 'pending');

        // Send confirmation email to customer and admin
        $booking_data = array(
            'name' => $customer_name,
            'email' => $customer_email,
            'phone' => $customer_phone,
            'date' => $booking_date,
            'participants' => $number_of_participants,
            'message' => $message,
            'tour_id' => $tour_id,
            'bike_id' => $bike_id,
            'price_per_person' => $price_per_person,
            'total_price' => $total_price,
            'payment_method' => $payment_method
        );
        
        $emails_sent = bike_theme_send_booking_emails($booking_id, $booking_data);

        // Redirect to thank you page with success message
        wp_redirect(add_query_arg(array(
            'booking' => 'success',
            'id' => $booking_id
        ), get_permalink(get_page_by_path('thank-you'))));
        exit;
    } else {
        // Redirect back with error message
        wp_redirect(add_query_arg(array(
            'booking' => 'error',
            'message' => urlencode(__('Failed to create booking. Please try again.', 'bike-theme'))
        ), wp_get_referer()));
        exit;
    }
}
add_action('admin_post_bike_theme_submit_booking', 'bike_theme_submit_booking');
add_action('admin_post_nopriv_bike_theme_submit_booking', 'bike_theme_submit_booking');
