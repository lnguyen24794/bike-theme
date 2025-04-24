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
 * Format price with currency symbol
 *
 * @param float $price The price to format.
 * @return string The formatted price.
 */
function bike_theme_format_price($price)
{
    $currency_symbol = get_option('bike_theme_currency_symbol', '$');
    $price_format = get_option('bike_theme_price_format', '{symbol}{price}');
    
    $formatted_price = number_format((float) $price, 2, '.', ',');
    
    return str_replace(
        array('{symbol}', '{price}'),
        array($currency_symbol, $formatted_price),
        $price_format
    );
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
    $price_per_person = bike_theme_get_tour_min_price($tour_id);
    
    if (!$price_per_person) {
        return array(
            'price_per_person' => 0,
            'total_price' => 0,
        );
    }
    
    // Apply discount for groups if enabled
    $enable_group_discount = get_post_meta($tour_id, '_tour_enable_group_discount', true);
    
    if ($enable_group_discount === 'yes' && $participants > 1) {
        $discount_percentage = get_post_meta($tour_id, '_tour_group_discount', true);
        
        if (!empty($discount_percentage)) {
            $discount_percentage = min(floatval($discount_percentage), 100);
            $discount_factor = 1 - ($discount_percentage / 100);
            $total_price = $price_per_person * $participants * $discount_factor;
        } else {
            $total_price = $price_per_person * $participants;
        }
    } else {
        $total_price = $price_per_person * $participants;
    }
    
    return array(
        'price_per_person' => $price_per_person,
        'total_price' => $total_price,
    );
}

/**
 * Get bike rental price
 *
 * @param int $bike_id The bike ID.
 * @return float|bool The rental price or false if not found.
 */
function bike_theme_get_bike_rental_price($bike_id)
{
    if (empty($bike_id)) {
        return false;
    }
    
    $price = get_post_meta($bike_id, '_bike_rental_price', true);
    
    if (!empty($price)) {
        return floatval($price);
    }
    
    return false;
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
 * Register booking statuses
 */
function bike_theme_register_booking_statuses()
{
    register_post_status('pending', array(
        'label' => _x('Pending', 'Booking status', 'bike-theme'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>', 'bike-theme'),
    ));
    
    register_post_status('confirmed', array(
        'label' => _x('Confirmed', 'Booking status', 'bike-theme'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Confirmed <span class="count">(%s)</span>', 'Confirmed <span class="count">(%s)</span>', 'bike-theme'),
    ));
    
    register_post_status('completed', array(
        'label' => _x('Completed', 'Booking status', 'bike-theme'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>', 'bike-theme'),
    ));
    
    register_post_status('cancelled', array(
        'label' => _x('Cancelled', 'Booking status', 'bike-theme'),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Cancelled <span class="count">(%s)</span>', 'Cancelled <span class="count">(%s)</span>', 'bike-theme'),
    ));
}
add_action('init', 'bike_theme_register_booking_statuses'); 