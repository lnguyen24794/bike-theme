<?php
/**
 * Frontend helper functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get formatted tour duration
 *
 * @param int $tour_id Tour post ID
 * @return string Formatted duration string
 */
function bike_theme_get_tour_duration($tour_id)
{
    // Get saved display string
    $duration = get_post_meta($tour_id, '_tour_duration_display', true);
    if (!empty($duration)) {
        return $duration;
    }

    // If no display string, format based on type
    $duration_type = get_post_meta($tour_id, '_tour_duration_type', true) ?: 'days_nights';

    if ($duration_type === 'days_nights') {
        $days = get_post_meta($tour_id, '_tour_duration_days', true);
        $nights = get_post_meta($tour_id, '_tour_duration_nights', true);

        if (empty($days) && empty($nights)) {
            return '';
        }

        $duration = '';
        if (!empty($days)) {
            $duration = sprintf(
                _n('%d day', '%d days', $days, 'bike-theme'),
                $days
            );
        }

        if (!empty($nights)) {
            if (!empty($duration)) {
                $duration .= ' ';
            }
            $duration .= sprintf(
                _n('%d night', '%d nights', $nights, 'bike-theme'),
                $nights
            );
        }

        return $duration;
    } else {
        $hours = get_post_meta($tour_id, '_tour_duration_hours', true);
        if (empty($hours)) {
            return '';
        }

        return sprintf(
            _n('%g hour', '%g hours', ceil($hours), 'bike-theme'),
            $hours
        );
    }
}

/**
 * Register booking page option
 */
function bike_theme_register_booking_page_option()
{
    register_setting('general', 'bike_theme_booking_page', 'intval');

    add_settings_field(
        'bike_theme_booking_page',
        __('Booking Page', 'bike-theme'),
        'bike_theme_booking_page_callback',
        'general',
        'default',
        array('label_for' => 'bike_theme_booking_page')
    );
}
add_action('admin_init', 'bike_theme_register_booking_page_option');

/**
 * Booking page option callback
 */
function bike_theme_booking_page_callback()
{
    $booking_page = get_option('bike_theme_booking_page');
    wp_dropdown_pages(array(
        'name' => 'bike_theme_booking_page',
        'show_option_none' => __('— Select —', 'bike-theme'),
        'option_none_value' => '0',
        'selected' => $booking_page,
    ));
    echo '<p class="description">' . __('Select the page that contains the booking form.', 'bike-theme') . '</p>';
}

/**
 * Enqueue booking scripts
 */
function bike_theme_enqueue_booking_scripts() {
    if (is_singular('bike_tour')) {
        wp_enqueue_script('bike-theme-booking', get_template_directory_uri() . '/assets/js/booking.js', array('jquery'), '', true);
        wp_localize_script('bike-theme-booking', 'bike_booking', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bike_theme_booking_nonce'),
            'csrf_token' => wp_create_nonce('bike_theme_csrf'),
            'submitting_text' => __('Submitting...', 'bike-theme'),
            'submit_text' => __('Book Now', 'bike-theme'),
            'error_message' => __('An error occurred. Please try again.', 'bike-theme')
        ));
    }
}
add_action('wp_enqueue_scripts', 'bike_theme_enqueue_booking_scripts'); 