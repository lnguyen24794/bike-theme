<?php
/**
 * Booking helper functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get minimum price for a tour
 *
 * @param int $tour_id The tour ID.
 * @return float|bool The minimum price or false if not found.
 */
function bike_theme_get_tour_min_price($tour_id)
{
    if (empty($tour_id)) {
        return false;
    }
    
    $price = get_post_meta($tour_id, '_tour_price', true);
    
    if (!empty($price)) {
        return floatval($price);
    }
    
    return false;
}

/**
 * Calculate total price for a tour booking
 *
 * @param int $tour_id The tour ID.
 * @param int $participants Number of participants.
 * @return array Price information including per person and total price.
 */
function bike_theme_calculate_tour_price($tour_id, $participants = 1)
{
    // Use bike_theme_get_tour_price from pricing.php instead to prevent conflicts
    $price_per_person = bike_theme_get_tour_price($tour_id, $participants);
    
    return array(
        'price_per_person' => $price_per_person,
        'total_price' => $price_per_person * $participants
    );
}

/**
 * Generate booking reference number
 *
 * @param int $booking_id The booking post ID.
 * @return string Formatted booking reference.
 */
function bike_theme_generate_booking_reference($booking_id)
{
    $prefix = apply_filters('bike_theme_booking_reference_prefix', 'BK');
    $date = date('ymd');
    
    return sprintf('%s-%s-%05d', $prefix, $date, $booking_id);
}

/**
 * Get readable booking status
 *
 * @param string $status The booking status.
 * @return string The readable status text.
 */
function bike_theme_get_booking_status_text($status)
{
    $statuses = array(
        'pending' => __('Pending', 'bike-theme'),
        'confirmed' => __('Confirmed', 'bike-theme'),
        'completed' => __('Completed', 'bike-theme'),
        'cancelled' => __('Cancelled', 'bike-theme'),
    );
    
    return isset($statuses[$status]) ? $statuses[$status] : $status;
}

/**
 * Prepare and send booking notification email to admin
 *
 * @param int $booking_id The booking ID.
 * @return bool Whether the email was sent successfully.
 */
function bike_theme_send_admin_booking_notification($booking_id)
{
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('blogname');
    
    $booking = get_post($booking_id);
    
    if (!$booking || $booking->post_type !== 'bike_booking') {
        return false;
    }
    
    $customer_name = get_post_meta($booking_id, '_booking_customer_name', true);
    $customer_email = get_post_meta($booking_id, '_booking_customer_email', true);
    $customer_phone = get_post_meta($booking_id, '_booking_customer_phone', true);
    $booking_date = get_post_meta($booking_id, '_booking_date', true);
    $booking_type = get_post_meta($booking_id, '_booking_type', true);
    $tour_id = get_post_meta($booking_id, '_booking_tour_id', true);
    $bike_id = get_post_meta($booking_id, '_booking_bike_id', true);
    $participants = get_post_meta($booking_id, '_booking_participants', true);
    $total_price = get_post_meta($booking_id, '_booking_total_price', true);
    $payment_method = get_post_meta($booking_id, '_booking_payment_method', true);
    $message = get_post_meta($booking_id, '_booking_message', true);
    
    $subject = sprintf(__('New Booking - #%d', 'bike-theme'), $booking_id);
    
    $body = sprintf(__('A new booking has been submitted on %s', 'bike-theme'), $site_name) . "\n\n";
    $body .= sprintf(__('Booking ID: #%d', 'bike-theme'), $booking_id) . "\n";
    $body .= sprintf(__('Date: %s', 'bike-theme'), $booking_date) . "\n";
    
    if ($booking_type === 'tour' && $tour_id) {
        $body .= sprintf(__('Tour: %s', 'bike-theme'), get_the_title($tour_id)) . "\n";
        if ($participants) {
            $body .= sprintf(__('Participants: %d', 'bike-theme'), $participants) . "\n";
        }
        if ($total_price) {
            $body .= sprintf(__('Total Price: %s', 'bike-theme'), bike_theme_format_price($total_price)) . "\n";
        }
    } elseif ($booking_type === 'bike' && $bike_id) {
        $body .= sprintf(__('Bike: %s', 'bike-theme'), get_the_title($bike_id)) . "\n";
        $rental_price = bike_theme_get_bike_rental_price($bike_id);
        if ($rental_price) {
            $body .= sprintf(__('Rental Price: %s', 'bike-theme'), bike_theme_format_price($rental_price)) . "\n";
        }
    }
    
    $body .= "\n" . __('Customer Information:', 'bike-theme') . "\n";
    $body .= sprintf(__('Name: %s', 'bike-theme'), $customer_name) . "\n";
    $body .= sprintf(__('Email: %s', 'bike-theme'), $customer_email) . "\n";
    $body .= sprintf(__('Phone: %s', 'bike-theme'), $customer_phone) . "\n";
    
    if ($payment_method) {
        $body .= sprintf(__('Payment Method: %s', 'bike-theme'), $payment_method) . "\n";
    }
    
    if ($message) {
        $body .= "\n" . __('Special Requests:', 'bike-theme') . "\n";
        $body .= $message . "\n";
    }
    
    $body .= "\n\n";
    $body .= __('You can manage this booking from the admin dashboard.', 'bike-theme');
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    return wp_mail('info@beebikehub.com', $subject, $body, $headers);
}

/**
 * Prepare and send booking confirmation email to customer
 *
 * @param int $booking_id The booking ID.
 * @return bool Whether the email was sent successfully.
 */
function bike_theme_send_customer_booking_confirmation($booking_id)
{
    $site_name = get_bloginfo('blogname');
    $admin_email = get_option('admin_email');
    
    $booking = get_post($booking_id);
    
    if (!$booking || $booking->post_type !== 'bike_booking') {
        return false;
    }
    
    $customer_name = get_post_meta($booking_id, '_booking_customer_name', true);
    $customer_email = get_post_meta($booking_id, '_booking_customer_email', true);
    $booking_date = get_post_meta($booking_id, '_booking_date', true);
    $booking_type = get_post_meta($booking_id, '_booking_type', true);
    $tour_id = get_post_meta($booking_id, '_booking_tour_id', true);
    $bike_id = get_post_meta($booking_id, '_booking_bike_id', true);
    $participants = get_post_meta($booking_id, '_booking_participants', true);
    $total_price = get_post_meta($booking_id, '_booking_total_price', true);
    $payment_method = get_post_meta($booking_id, '_booking_payment_method', true);
    
    $subject = sprintf(__('Your Booking Confirmation - #%d', 'bike-theme'), $booking_id);
    
    $body = sprintf(__('Dear %s,', 'bike-theme'), $customer_name) . "\n\n";
    $body .= sprintf(__('Thank you for your booking with %s. Your booking has been received and is pending confirmation.', 'bike-theme'), $site_name) . "\n\n";
    $body .= __('Booking Details:', 'bike-theme') . "\n";
    $body .= sprintf(__('Booking ID: #%d', 'bike-theme'), $booking_id) . "\n";
    $body .= sprintf(__('Date: %s', 'bike-theme'), $booking_date) . "\n";
    
    if ($booking_type === 'tour' && $tour_id) {
        $body .= sprintf(__('Tour: %s', 'bike-theme'), get_the_title($tour_id)) . "\n";
        if ($participants) {
            $body .= sprintf(__('Participants: %d', 'bike-theme'), $participants) . "\n";
        }
        if ($total_price) {
            $body .= sprintf(__('Total Price: %s', 'bike-theme'), bike_theme_format_price($total_price)) . "\n";
        }
    } elseif ($booking_type === 'bike' && $bike_id) {
        $body .= sprintf(__('Bike: %s', 'bike-theme'), get_the_title($bike_id)) . "\n";
        $rental_price = bike_theme_get_bike_rental_price($bike_id);
        if ($rental_price) {
            $body .= sprintf(__('Rental Price: %s', 'bike-theme'), bike_theme_format_price($rental_price)) . "\n";
        }
    }
    
    $body .= sprintf(__('Payment Method: %s', 'bike-theme'), $payment_method) . "\n\n";
    
    if ($payment_method === 'bank_transfer') {
        $body .= __('Payment Instructions:', 'bike-theme') . "\n";
        $body .= __('Please transfer the total amount to the following bank account:', 'bike-theme') . "\n";
        $body .= sprintf(__('Bank Name: %s', 'bike-theme'), get_option('bike_theme_bank_name', 'Example Bank')) . "\n";
        $body .= sprintf(__('Account Name: %s', 'bike-theme'), get_option('bike_theme_account_name', 'Bike Tours Company')) . "\n";
        $body .= sprintf(__('Account Number: %s', 'bike-theme'), get_option('bike_theme_account_number', '1234567890')) . "\n";
        $body .= sprintf(__('Reference: %s #%d', 'bike-theme'), __('Booking', 'bike-theme'), $booking_id) . "\n\n";
    }
    
    $body .= __('What Happens Next?', 'bike-theme') . "\n";
    $body .= __('1. Our team will review your booking request.', 'bike-theme') . "\n";
    $body .= __('2. We will contact you to confirm availability and details.', 'bike-theme') . "\n";
    $body .= __('3. Once confirmed, you will receive a final confirmation email.', 'bike-theme') . "\n";
    if ($payment_method === 'bank_transfer') {
        $body .= __('4. Please complete the payment as per the instructions above.', 'bike-theme') . "\n";
    }
    $body .= __('5. Get ready for your amazing bike adventure!', 'bike-theme') . "\n\n";
    
    $body .= __('If you have any questions about your booking, please contact us at ', 'bike-theme') . $admin_email . "\n\n";
    $body .= sprintf(__('Thank you for choosing %s!', 'bike-theme'), $site_name) . "\n\n";
    $body .= sprintf(__('The %s Team', 'bike-theme'), $site_name);
    
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    return wp_mail($customer_email, $subject, $body, $headers);
}

/**
 * Send booking confirmation and notification emails
 *
 * @param int $booking_id The booking ID
 * @param array $booking_data The booking data
 * @return bool True if emails were sent successfully
 */
function bike_theme_send_booking_emails($booking_id, $booking_data) {
    if (!$booking_id || empty($booking_data)) {
        return false;
    }
    
    // Extract booking data
    $name = isset($booking_data['name']) ? $booking_data['name'] : '';
    $email = isset($booking_data['email']) ? $booking_data['email'] : '';
    $phone = isset($booking_data['phone']) ? $booking_data['phone'] : '';
    $date = isset($booking_data['date']) ? $booking_data['date'] : '';
    $participants = isset($booking_data['participants']) ? $booking_data['participants'] : 1;
    $message = isset($booking_data['message']) ? $booking_data['message'] : '';
    $tour_id = isset($booking_data['tour_id']) ? $booking_data['tour_id'] : 0;
    $bike_id = isset($booking_data['bike_id']) ? $booking_data['bike_id'] : 0;
    $price_per_person = isset($booking_data['price_per_person']) ? $booking_data['price_per_person'] : 0;
    $total_price = isset($booking_data['total_price']) ? $booking_data['total_price'] : 0;
    $payment_method = isset($booking_data['payment_method']) ? $booking_data['payment_method'] : '';
    $booking_type = $tour_id > 0 ? 'tour' : ($bike_id > 0 ? 'bike' : '');
    
    // Email setup
    $site_name = get_bloginfo('blogname');
    $headers = array(
        'From: BeeBikeHub <info@beebikehub.com>',
        'Content-Type: text/plain; charset=UTF-8'
    );
    
    // Send customer confirmation email
    $customer_subject = sprintf(__('Your Booking Confirmation #%d - %s', 'bike-theme'), $booking_id, $site_name);
    
    $customer_message = sprintf(__("Dear %s,\n\n", 'bike-theme'), $name);
    $customer_message .= sprintf(__("Thank you for your booking (ID: #%s). Below are your booking details:\n\n", 'bike-theme'), 'BBT-' . $booking_id);
    
    if ($tour_id > 0) {
        $customer_message .= sprintf(__("Tour: %s\n", 'bike-theme'), html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'));
        $customer_message .= sprintf(__("Date: %s\n", 'bike-theme'), $date);
        $customer_message .= sprintf(__("Number of Participants: %d\n", 'bike-theme'), $participants);
        $customer_message .= sprintf(__("Price per Person: %s\n", 'bike-theme'), bike_theme_format_price($price_per_person));
        $customer_message .= sprintf(__("Tour Subtotal: %s\n", 'bike-theme'), bike_theme_format_price($price_per_person * $participants));
        $customer_message .= sprintf(__("Total Price: %s\n", 'bike-theme'), bike_theme_format_price($total_price));
    }
    
    if ($bike_id > 0) {
        $customer_message .= sprintf(__("Bike: %s\n", 'bike-theme'), html_entity_decode(get_the_title($bike_id), ENT_QUOTES, 'UTF-8'));
        $customer_message .= sprintf(__("Date: %s\n", 'bike-theme'), $date);
    }
    
    if (!empty($payment_method)) {
        $customer_message .= sprintf(__("Payment Method: %s\n", 'bike-theme'), $payment_method);
    }
    
    if (!empty($message)) {
        $customer_message .= sprintf(__("\nYour Special Requests:\n%s\n", 'bike-theme'), $message);
    }
    
    $customer_message .= __("\nBooking Status: Received\n", 'bike-theme');
    $customer_message .= __("We will review your booking and contact you shortly for confirmation.\n\n", 'bike-theme');
    $customer_message .= sprintf(__("Thank you for choosing %s!\n\n", 'bike-theme'), $site_name);
    $customer_message .= sprintf(__("Best regards,\n%s", 'bike-theme'), $site_name);
    
    $customer_email_sent = wp_mail($email, $customer_subject, $customer_message, $headers);
    
    // Send admin notification email
    $admin_subject = sprintf(__('[%s] New Booking #%d Received', 'bike-theme'), $site_name, $booking_id);
    
    $admin_message = __("A new booking has been received:\n\n", 'bike-theme');
    $admin_message .= sprintf(__("Booking ID: #%d\n", 'bike-theme'), $booking_id);
    $admin_message .= sprintf(__("Booking Type: %s\n", 'bike-theme'), ucfirst($booking_type));
    $admin_message .= sprintf(__("Status: %s\n\n", 'bike-theme'), __('Pending', 'bike-theme'));
    
    $admin_message .= __("Customer Details:\n", 'bike-theme');
    $admin_message .= sprintf(__("Name: %s\n", 'bike-theme'), $name);
    $admin_message .= sprintf(__("Email: %s\n", 'bike-theme'), $email);
    $admin_message .= sprintf(__("Phone: %s\n\n", 'bike-theme'), $phone);
    
    $admin_message .= __("Booking Details:\n", 'bike-theme');
    $admin_message .= sprintf(__("Date: %s\n", 'bike-theme'), $date);
    
    if ($tour_id > 0) {
        $admin_message .= sprintf(__("Tour: %s\n", 'bike-theme'), html_entity_decode(get_the_title($tour_id), ENT_QUOTES, 'UTF-8'));
        $admin_message .= sprintf(__("Participants: %d\n", 'bike-theme'), $participants);
        $admin_message .= sprintf(__("Price per Person: %s\n", 'bike-theme'), bike_theme_format_price($price_per_person));
        $admin_message .= sprintf(__("Tour Subtotal: %s\n", 'bike-theme'), bike_theme_format_price($price_per_person * $participants));
        $admin_message .= sprintf(__("Total Price: %s\n", 'bike-theme'), bike_theme_format_price($total_price));
    }
    
    if ($bike_id > 0) {
        $admin_message .= sprintf(__("Bike: %s\n", 'bike-theme'), html_entity_decode(get_the_title($bike_id), ENT_QUOTES, 'UTF-8'));
    }
    
    if (!empty($payment_method)) {
        $admin_message .= sprintf(__("Payment Method: %s\n", 'bike-theme'), $payment_method);
    }
    
    if (!empty($message)) {
        $admin_message .= sprintf(__("\nSpecial Requests:\n%s\n", 'bike-theme'), $message);
    }
    
    $admin_message .= sprintf(__("\nManage this booking: %s", 'bike-theme'), admin_url('post.php?post=' . $booking_id . '&action=edit'));
    
    $admin_email_sent = wp_mail('info@beebikehub.com', $admin_subject, $admin_message, $headers);
    
    return ($customer_email_sent && $admin_email_sent);
} 