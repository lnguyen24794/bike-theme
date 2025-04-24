<?php
/**
 * Booking processing functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

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
    
    if ($attempt_count === false) {
        set_transient($transient_key, 1, HOUR_IN_SECONDS);
    } else {
        if ($attempt_count >= 5) { // Limit to 5 attempts per hour
            wp_send_json_error(array('message' => __('Too many booking attempts. Please try again later.', 'bike-theme')));
        }
        set_transient($transient_key, $attempt_count + 1, HOUR_IN_SECONDS);
    }

    // Sanitize and validate form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $participants = intval($_POST['participants']);
    $message = sanitize_textarea_field($_POST['message']);
    $tour_id = intval($_POST['tour_id']);

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

        // Set booking status taxonomy
        wp_set_object_terms($booking_id, 'pending', 'booking_status');

        // Send confirmation email to customer
        $to = $email;
        $subject = sprintf(__('Booking Confirmation - %s', 'bike-theme'), html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'));
        $headers = array(
            'From: BeeBikeHub <info@beebikehub.com>',
            'Content-Type: text/plain; charset=UTF-8'
        );
        $message = sprintf(
            __('Thank you for booking %s. Your booking details:
            Booking ID: %s
            Name: %s
            Email: %s
            Phone: %s
            Date: %s
            Participants: %d
            Total Price: %s

            We will contact you shortly to confirm your booking.

            Best regards,
            %s', 'bike-theme'),
            html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'),
            'BBT-'. $booking_id,
            $name,
            $email,
            $phone,
            $date,
            $participants,
            bike_theme_format_price($total_price),
            get_bloginfo('name')
        );
        wp_mail($to, $subject, $message, $headers);

        // Send notification email to admin
        $admin_email = get_option('admin_email');
        $admin_subject = sprintf(__('New Booking - %s', 'bike-theme'), html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'));
        $message = sprintf(
            __('You have a new booking %s. Your booking details:

            Name: %s
            Email: %s
            Phone: %s
            Date: %s
            Participants: %d
            Total Price: %s

            %s', 'bike-theme'),
            html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'),
            $name,
            $email,
            $phone,
            $date,
            $participants,
            bike_theme_format_price($total_price),
            get_bloginfo('name')
        );
        wp_mail('info@beebikehub.com', $admin_subject, $message, $headers);

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