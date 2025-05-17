<?php
/**
 * Tour pricing functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get tour price based on number of participants
 *
 * @param int $tour_id         Tour ID
 * @param int $participants    Number of participants (default: 1)
 * @return int                 Price per person
 */
function bike_theme_get_tour_price($tour_id, $participants = 1)
{
    // Get flexible pricing status
    $flexible_pricing_enabled = get_post_meta($tour_id, '_tour_flexible_pricing_enabled', true);

    // If flexible pricing is not enabled, return standard price
    if (empty($flexible_pricing_enabled) || $flexible_pricing_enabled !== '1') {
        return (int) get_post_meta($tour_id, '_tour_price', true);
    }

    // Get flexible pricing data
    $pricing_data = get_post_meta($tour_id, '_tour_flexible_pricing', true);

    // If no pricing data, return standard price
    if (empty($pricing_data) || !is_array($pricing_data)) {
        return (int) get_post_meta($tour_id, '_tour_price', true);
    }

    // Sort pricing data by number of participants (ascending)
    usort($pricing_data, function ($a, $b) {
        return $b['participants'] - $a['participants'];
    });

    // Find applicable price
    $applicable_price = null;

    foreach ($pricing_data as $price_item) {
        if ($participants >= $price_item['participants']) {
            $applicable_price = $price_item['price'];
        } else {
            break; // Stop once we exceed the participant level
        }
    }

    // If no applicable price found, use the first price level
    if ($applicable_price === null && !empty($pricing_data)) {
        $applicable_price = $pricing_data[0]['price'];
    }

    // Fallback to standard price if still no price found
    if ($applicable_price === null) {
        $applicable_price = (int) get_post_meta($tour_id, '_tour_price', true);
    }

    return $applicable_price;
}

/**
 * Format price with currency symbol based on theme settings
 *
 * @param int|float $price   The price to format
 * @param bool $include_html Whether to include HTML formatting
 * @return string            Formatted price with currency
 */
function bike_theme_format_price($price, $include_html = false)
{
    // Ensure price is a valid number
    if ($price === '' || $price === null || !is_numeric($price)) {
        $price = 0;
    }
    
    // Convert to float to ensure compatibility with number_format
    $price = floatval($price);
    
    // Format number with thousand separator
    $formatted_price = number_format($price, 0, ',', '.');

    // Get currency symbol and position from theme options
    $currency = get_theme_mod('bike_theme_currency', '$');
    $position = get_theme_mod('bike_theme_currency_position', 'after');

    // Format the price with the currency symbol in the correct position
    if ($position === 'before') {
        if ($include_html) {
            return '<span class="currency-symbol">' . $currency . '</span>' . $formatted_price;
        } else {
            return $currency . $formatted_price;
        }
    } else {
        if ($include_html) {
            return $formatted_price . ' <span class="currency-symbol">' . $currency . '</span>';
        } else {
            return $formatted_price . ' ' . $currency;
        }
    }
}

/**
 * Calculate total tour price based on number of participants
 *
 * @param int $tour_id         Tour ID
 * @param int $participants    Number of participants
 * @return int                 Total price for all participants
 */
function bike_theme_get_tour_total_price($tour_id, $participants = 1)
{
    $price_per_person = bike_theme_get_tour_price($tour_id, $participants);
    return $price_per_person * $participants;
}

/**
 * Get tour additions
 */
function bike_theme_get_tour_additions($tour_id)
{
    $additions = get_post_meta($tour_id, '_tour_additions', true);
    return is_array($additions) ? $additions : array();
}

/**
 * Calculate additions total price
 */
function bike_theme_calculate_additions_price($tour_id, $selected_additions, $participants = 1)
{
    $total = 0;
    $additions = bike_theme_get_tour_additions($tour_id);

    foreach ($additions as $addition) {
        if (in_array($addition['name'], $selected_additions)) {
            if (isset($addition['per_person']) && $addition['per_person']) {
                $total += floatval($addition['price']) * $participants;
            } else {
                $total += floatval($addition['price']);
            }
        }
    }

    return $total;
}

/**
 * Get total booking price including additions
 */
function bike_theme_get_booking_total_price($tour_id, $participants = 1, $selected_additions = array())
{
    $tour_price = bike_theme_get_tour_total_price($tour_id, $participants);
    $additions_price = bike_theme_calculate_additions_price($tour_id, $selected_additions, $participants);

    return $tour_price + $additions_price;
}

/**
 * Get tour price via Ajax
 */
function bike_theme_get_tour_price_ajax()
{
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'bike_theme_booking_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'bike-theme')));
    }

    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
    $participants = isset($_POST['participants']) ? intval($_POST['participants']) : 1;
    $selected_additions = isset($_POST['additions']) ? (array) $_POST['additions'] : array();

    if (!$tour_id) {
        wp_send_json_error(array('message' => __('Invalid tour ID', 'bike-theme')));
    }

    $price_per_person = bike_theme_get_tour_price($tour_id, $participants);
    $total_price = $price_per_person * $participants;
    $additions_price = bike_theme_calculate_additions_price($tour_id, $selected_additions, $participants);
    $grand_total = $total_price + $additions_price;

    // Get additions details for the response
    $additions_data = array();
    $all_additions = bike_theme_get_tour_additions($tour_id);
    
    foreach ($selected_additions as $addition_name) {
        foreach ($all_additions as $addition) {
            if ($addition['name'] === $addition_name) {
                $price = $addition['price'];
                if (isset($addition['per_person']) && $addition['per_person']) {
                    $price *= $participants;
                }
                
                $additions_data[] = array(
                    'name' => $addition['name'],
                    'price' => bike_theme_format_price($price),
                    'is_per_person' => isset($addition['per_person']) && $addition['per_person']
                );
                break;
            }
        }
    }

    wp_send_json_success(array(
        'price_per_person' => bike_theme_format_price($price_per_person),
        'price_per_person_raw' => $price_per_person,
        'total_price' => bike_theme_format_price($total_price),
        'total_price_raw' => $total_price,
        'additions_price' => bike_theme_format_price($additions_price),
        'additions_price_raw' => $additions_price,
        'grand_total' => bike_theme_format_price($grand_total),
        'grand_total_raw' => $grand_total,
        'additions' => $additions_data
    ));
}
add_action('wp_ajax_bike_theme_get_tour_price', 'bike_theme_get_tour_price_ajax');
add_action('wp_ajax_nopriv_bike_theme_get_tour_price', 'bike_theme_get_tour_price_ajax'); 