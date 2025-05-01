<?php
/**
 * Booking Custom Post Type and related functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Booking post type
 */
function bike_theme_register_booking_post_type()
{
    $labels = array(
        'name'                  => _x('Bookings', 'Post type general name', 'bike-theme'),
        'singular_name'         => _x('Booking', 'Post type singular name', 'bike-theme'),
        'menu_name'             => _x('Bookings', 'Admin Menu text', 'bike-theme'),
        'name_admin_bar'        => _x('Booking', 'Add New on Toolbar', 'bike-theme'),
        'add_new'               => __('Add New', 'bike-theme'),
        'add_new_item'          => __('Add New Booking', 'bike-theme'),
        'new_item'              => __('New Booking', 'bike-theme'),
        'edit_item'             => __('Edit Booking', 'bike-theme'),
        'view_item'             => __('View Booking', 'bike-theme'),
        'all_items'             => __('All Bookings', 'bike-theme'),
        'search_items'          => __('Search Bookings', 'bike-theme'),
        'parent_item_colon'     => __('Parent Bookings:', 'bike-theme'),
        'not_found'             => __('No bookings found.', 'bike-theme'),
        'not_found_in_trash'    => __('No bookings found in Trash.', 'bike-theme'),
        'featured_image'        => _x('Booking Image', 'Overrides the "Featured Image" phrase', 'bike-theme'),
        'set_featured_image'    => _x('Set booking image', 'Overrides the "Set featured image" phrase', 'bike-theme'),
        'remove_featured_image' => _x('Remove booking image', 'Overrides the "Remove featured image" phrase', 'bike-theme'),
        'use_featured_image'    => _x('Use as booking image', 'Overrides the "Use as featured image" phrase', 'bike-theme'),
        'archives'              => _x('Booking archives', 'The post type archive label used in nav menus', 'bike-theme'),
        'insert_into_item'      => _x('Insert into booking', 'Overrides the "Insert into post" phrase', 'bike-theme'),
        'uploaded_to_this_item' => _x('Uploaded to this booking', 'Overrides the "Uploaded to this post" phrase', 'bike-theme'),
        'filter_items_list'     => _x('Filter bookings list', 'Screen reader text for the filter links', 'bike-theme'),
        'items_list_navigation' => _x('Bookings list navigation', 'Screen reader text for the pagination', 'bike-theme'),
        'items_list'            => _x('Bookings list', 'Screen reader text for the items list', 'bike-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'booking'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 26,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title'),
        'map_meta_cap'       => true,
        'show_in_rest'       => false,
        'capabilities'       => array(
            'create_posts' => 'do_not_allow', // Remove "Add New" button
        ),
    );

    register_post_type('bike_booking', $args);

    // Register Booking Status taxonomy
    $tax_labels = array(
        'name'              => _x('Booking Statuses', 'taxonomy general name', 'bike-theme'),
        'singular_name'     => _x('Booking Status', 'taxonomy singular name', 'bike-theme'),
        'search_items'      => __('Search Booking Statuses', 'bike-theme'),
        'all_items'         => __('All Booking Statuses', 'bike-theme'),
        'parent_item'       => __('Parent Booking Status', 'bike-theme'),
        'parent_item_colon' => __('Parent Booking Status:', 'bike-theme'),
        'edit_item'         => __('Edit Booking Status', 'bike-theme'),
        'update_item'       => __('Update Booking Status', 'bike-theme'),
        'add_new_item'      => __('Add New Booking Status', 'bike-theme'),
        'new_item_name'     => __('New Booking Status Name', 'bike-theme'),
        'menu_name'         => __('Booking Status', 'bike-theme'),
    );

    $tax_args = array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'booking-status'),
        'show_in_rest'      => false,
    );

    register_taxonomy('booking_status', array('bike_booking'), $tax_args);

    // Register default booking statuses
    bike_theme_register_booking_statuses();
}
add_action('init', 'bike_theme_register_booking_post_type');

/**
 * Register default booking statuses
 */
function bike_theme_register_booking_statuses() {
    $statuses = array(
        'pending' => __('Pending', 'bike-theme'),
        'confirmed' => __('Confirmed', 'bike-theme'),
        'completed' => __('Completed', 'bike-theme'),
        'cancelled' => __('Cancelled', 'bike-theme'),
        'refunded' => __('Refunded', 'bike-theme')
    );
    
    // Check if statuses already exist
    $existing_terms = get_terms(array(
        'taxonomy' => 'booking_status',
        'hide_empty' => false,
    ));
    
    // If there's an error or no terms exist, add default statuses
    if (is_wp_error($existing_terms) || empty($existing_terms)) {
        foreach ($statuses as $slug => $name) {
            if (!term_exists($slug, 'booking_status')) {
                wp_insert_term($name, 'booking_status', array(
                    'slug' => $slug,
                    'description' => sprintf(__('Booking with %s status', 'bike-theme'), strtolower($name))
                ));
            }
        }
    }
}

/**
 * Add meta boxes for Booking post type
 */
function bike_theme_add_booking_meta_boxes()
{
    add_meta_box(
        'booking_details',
        __('Booking Details', 'bike-theme'),
        'bike_theme_booking_details_meta_box_callback',
        'bike_booking',
        'normal',
        'high'
    );

    add_meta_box(
        'booking_customer',
        __('Customer Information', 'bike-theme'),
        'bike_theme_booking_customer_meta_box_callback',
        'bike_booking',
        'normal',
        'high'
    );

    add_meta_box(
        'booking_payment',
        __('Payment Details', 'bike-theme'),
        'bike_theme_booking_payment_meta_box_callback',
        'bike_booking',
        'normal',
        'high'
    );

    add_meta_box(
        'booking_rider_details',
        __('Rider Details', 'bike-theme'),
        'bike_theme_booking_rider_details_meta_box_callback',
        'bike_booking',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'bike_theme_add_booking_meta_boxes');

/**
 * Booking details meta box callback
 */
function bike_theme_booking_details_meta_box_callback($post)
{
    wp_nonce_field('bike_theme_booking_meta_box', 'bike_theme_booking_meta_box_nonce');

    // Get booking type (tour or bike rental)
    $booking_type = get_post_meta($post->ID, '_booking_type', true);
    $tour_id = get_post_meta($post->ID, '_booking_tour_id', true);
    $bike_id = get_post_meta($post->ID, '_booking_bike_id', true);
    $booking_date = get_post_meta($post->ID, '_booking_date', true);
    $participants = get_post_meta($post->ID, '_booking_participants', true);
    $additions = get_post_meta($post->ID, '_booking_additions', true);
    $booking_note = get_post_meta($post->ID, '_booking_message', true);
    
    ?>
    <div class="booking-details-meta-box">
        
        <p>
            <strong><?php _e('Booking Type:', 'bike-theme'); ?></strong>
            <?php 
            if ($booking_type === 'tour') {
                _e('Tour Booking', 'bike-theme');
            } else {
                _e('Bike Rental', 'bike-theme');
            }
            ?>
        </p>
        
        <?php if ($booking_type === 'tour' && $tour_id) : ?>
            <p>
                <strong><?php _e('Tour:', 'bike-theme'); ?></strong>
                <a href="<?php echo get_edit_post_link($tour_id); ?>"><?php echo get_the_title($tour_id); ?></a>
            </p>
            
            <p>
                <strong><?php _e('Number of Participants:', 'bike-theme'); ?></strong>
                <?php echo esc_html($participants); ?>
            </p>
        <?php endif; ?>
        
        <?php if ($booking_type === 'bike' && $bike_id) : ?>
            <p>
                <strong><?php _e('Bike:', 'bike-theme'); ?></strong>
                <a href="<?php echo get_edit_post_link($bike_id); ?>"><?php echo get_the_title($bike_id); ?></a>
            </p>
            
            <p>
                <strong><?php _e('Rental Duration:', 'bike-theme'); ?></strong>
                <?php echo esc_html(get_post_meta($post->ID, '_booking_rental_duration', true)); ?> days
            </p>
        <?php endif; ?>
        
        <p>
            <strong><?php _e('Booking Date:', 'bike-theme'); ?></strong>
            <?php echo esc_html(date_i18n(get_option('date_format'), strtotime($booking_date))); ?>
        </p>
        
        <?php if (!empty($additions) && is_array($additions)) : ?>
            <div class="booking-additions">
                <strong><?php _e('Additional Services:', 'bike-theme'); ?></strong>
                <ul>
                    <?php foreach ($additions as $addition) : ?>
                        <li>
                            <?php 
                            echo esc_html($addition['name']) . ' - ' . bike_theme_format_price($addition['price']);
                            if (isset($addition['per_person']) && $addition['per_person']) {
                                echo ' ' . __('per person', 'bike-theme');
                            }
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($booking_note)) : ?>
            <div class="booking-note">
                <strong><?php _e('Booking Note:', 'bike-theme'); ?></strong>
                <p><?php echo esc_html($booking_note); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Booking customer meta box callback
 */
function bike_theme_booking_customer_meta_box_callback($post)
{
    $customer_name = get_post_meta($post->ID, '_booking_customer_name', true);
    $customer_email = get_post_meta($post->ID, '_booking_customer_email', true);
    $customer_phone = get_post_meta($post->ID, '_booking_customer_phone', true);
    $customer_address = get_post_meta($post->ID, '_booking_customer_address', true);
    $customer_id = get_post_meta($post->ID, '_booking_customer_id', true);
    
    ?>
    <div class="booking-customer-meta-box">
        <p>
            <strong><?php _e('Name:', 'bike-theme'); ?></strong>
            <?php echo esc_html($customer_name); ?>
        </p>
        
        <p>
            <strong><?php _e('Email:', 'bike-theme'); ?></strong>
            <a href="mailto:<?php echo esc_attr($customer_email); ?>"><?php echo esc_html($customer_email); ?></a>
        </p>
        
        <p>
            <strong><?php _e('Phone:', 'bike-theme'); ?></strong>
            <?php echo esc_html($customer_phone); ?>
        </p>
        
        <?php if (!empty($customer_address)) : ?>
            <p>
                <strong><?php _e('Address:', 'bike-theme'); ?></strong>
                <?php echo nl2br(esc_html($customer_address)); ?>
            </p>
        <?php endif; ?>
        
        <?php if (!empty($customer_id)) : ?>
            <p>
                <strong><?php _e('WordPress User:', 'bike-theme'); ?></strong>
                <a href="<?php echo esc_url(get_edit_user_link($customer_id)); ?>">
                    <?php echo esc_html(get_user_by('id', $customer_id)->display_name); ?>
                </a>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Payment details meta box callback
 */
function bike_theme_booking_payment_meta_box_callback($post)
{
    $price_per_person = get_post_meta($post->ID, '_booking_price_per_person', true);
    $participants = get_post_meta($post->ID, '_booking_participants', true);
    $total_price = get_post_meta($post->ID, '_booking_total_price', true);
    $additions = get_post_meta($post->ID, '_booking_additions', true);
    $payment_method = get_post_meta($post->ID, '_booking_payment_method', true);
    $payment_status = get_post_meta($post->ID, '_booking_payment_status', true);
    $payment_date = get_post_meta($post->ID, '_booking_payment_date', true);
    $transaction_id = get_post_meta($post->ID, '_booking_transaction_id', true);
    $booking_type = get_post_meta($post->ID, '_booking_type', true);
    
    ?>
    <div class="booking-payment-meta-box">
        <!-- Price breakdown -->
        <div class="price-breakdown">
            <h4><?php _e('Price Breakdown', 'bike-theme'); ?></h4>
            
            <?php if ($booking_type === 'tour'): ?>
                <p>
                    <strong><?php _e('Price per Person:', 'bike-theme'); ?></strong>
                    <?php echo bike_theme_format_price($price_per_person); ?>
                </p>
                
                <p>
                    <strong><?php _e('Number of Participants:', 'bike-theme'); ?></strong>
                    <?php echo esc_html($participants); ?>
                </p>
                
                <p>
                    <strong><?php _e('Tour Subtotal:', 'bike-theme'); ?></strong>
                    <?php echo bike_theme_format_price($price_per_person * $participants); ?>
                </p>
                
                <?php if (!empty($additions) && is_array($additions)): ?>
                    <div class="additions-breakdown">
                        <h5><?php _e('Optional Extras:', 'bike-theme'); ?></h5>
                        <ul>
                            <?php 
                            $additions_total = 0;
                            foreach ($additions as $addition): 
                                $addition_price = isset($addition['price']) ? $addition['price'] : 0;
                                $is_per_person = isset($addition['per_person']) && $addition['per_person'];
                                
                                if ($is_per_person) {
                                    $addition_total = $addition_price * $participants;
                                } else {
                                    $addition_total = $addition_price;
                                }
                                
                                $additions_total += $addition_total;
                            ?>
                                <li>
                                    <?php 
                                    echo esc_html($addition['name']) . ' - ' . bike_theme_format_price($addition_price);
                                    if ($is_per_person) {
                                        echo ' ' . sprintf(__('× %d participants = %s', 'bike-theme'), 
                                            $participants, 
                                            bike_theme_format_price($addition_total)
                                        );
                                    }
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p>
                            <strong><?php _e('Extras Subtotal:', 'bike-theme'); ?></strong>
                            <?php echo bike_theme_format_price($additions_total); ?>
                        </p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <p class="total-price">
                <strong><?php _e('Total Price:', 'bike-theme'); ?></strong>
                <?php echo bike_theme_format_price($total_price); ?>
            </p>
        </div>
        
        <hr>
        
        <!-- Payment information -->
        <div class="payment-info">
            <h4><?php _e('Payment Information', 'bike-theme'); ?></h4>
            
            <p>
                <strong><?php _e('Payment Method:', 'bike-theme'); ?></strong>
                <?php 
                $payment_methods = array(
                    'bank_transfer' => __('Bank Transfer', 'bike-theme'),
                    'cash' => __('Cash', 'bike-theme'),
                    'paypal' => __('PayPal', 'bike-theme'),
                    'credit_card' => __('Credit Card', 'bike-theme'),
                );
                echo isset($payment_methods[$payment_method]) ? esc_html($payment_methods[$payment_method]) : esc_html($payment_method);
                ?>
            </p>
            
            <p>
                <label for="payment_status">
                    <strong><?php _e('Payment Status:', 'bike-theme'); ?></strong>
                </label>
                <select name="payment_status" id="payment_status">
                    <option value="pending" <?php selected($payment_status, 'pending'); ?>><?php _e('Pending', 'bike-theme'); ?></option>
                    <option value="completed" <?php selected($payment_status, 'completed'); ?>><?php _e('Completed', 'bike-theme'); ?></option>
                    <option value="refunded" <?php selected($payment_status, 'refunded'); ?>><?php _e('Refunded', 'bike-theme'); ?></option>
                    <option value="cancelled" <?php selected($payment_status, 'cancelled'); ?>><?php _e('Cancelled', 'bike-theme'); ?></option>
                </select>
            </p>
            
            <?php if (!empty($payment_date)) : ?>
                <p>
                    <strong><?php _e('Payment Date:', 'bike-theme'); ?></strong>
                    <?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($payment_date))); ?>
                </p>
            <?php endif; ?>
            
            <?php if (!empty($transaction_id)) : ?>
                <p>
                    <strong><?php _e('Transaction ID:', 'bike-theme'); ?></strong>
                    <?php echo esc_html($transaction_id); ?>
                </p>
            <?php endif; ?>
            
            <p>
                <label for="transaction_note">
                    <strong><?php _e('Payment Notes:', 'bike-theme'); ?></strong>
                </label>
                <textarea name="transaction_note" id="transaction_note" rows="3" class="widefat"><?php echo esc_textarea(get_post_meta($post->ID, '_booking_transaction_note', true)); ?></textarea>
            </p>
        </div>
    </div>
    
    <style>
        .booking-payment-meta-box h4 {
            margin-top: 0;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .booking-payment-meta-box .total-price {
            font-size: 1.1em;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #eee;
        }
        .booking-payment-meta-box .additions-breakdown {
            background-color: #f9f9f9;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .booking-payment-meta-box .additions-breakdown h5 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .booking-payment-meta-box .additions-breakdown ul {
            margin: 0 0 10px 20px;
        }
    </style>
    <?php
}

/**
 * Rider details meta box callback
 */
function bike_theme_booking_rider_details_meta_box_callback($post)
{
    $rider_names = get_post_meta($post->ID, '_booking_rider_names', true);
    $rider_genders = get_post_meta($post->ID, '_booking_rider_genders', true);
    $rider_heights = get_post_meta($post->ID, '_booking_rider_heights', true);
    $rider_is_children = get_post_meta($post->ID, '_booking_rider_is_children', true);
    
    // If no rider data exists, show a message
    if (empty($rider_names) || !is_array($rider_names)) {
        echo '<p>' . __('No rider details available for this booking.', 'bike-theme') . '</p>';
        return;
    }
    
    ?>
    <div class="booking-rider-details-meta-box">
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php _e('Rider', 'bike-theme'); ?></th>
                    <th><?php _e('Name', 'bike-theme'); ?></th>
                    <th><?php _e('Gender', 'bike-theme'); ?></th>
                    <th><?php _e('height ', 'bike-theme'); ?></th>
                    <th><?php _e('Type', 'bike-theme'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rider_names as $index => $name) : 
                    $gender = isset($rider_genders[$index]) ? $rider_genders[$index] : '';
                    $height = isset($rider_heights[$index]) ? $rider_heights[$index] : '';
                    $is_child = isset($rider_is_children[$index]) && $rider_is_children[$index];
                ?>
                    <tr>
                        <td><?php echo esc_html($index + 1); ?></td>
                        <td><?php echo esc_html($name); ?></td>
                        <td>
                            <?php 
                            if ($gender === 'male') {
                                _e('Male', 'bike-theme');
                            } elseif ($gender === 'female') {
                                _e('Female', 'bike-theme');
                            } elseif ($gender === 'other') {
                                _e('Other', 'bike-theme');
                            } else {
                                _e('Not specified', 'bike-theme');
                            }
                            ?>
                        </td>
                        <td><?php echo $height ? esc_html($height) . ' kg' : __('Not specified', 'bike-theme'); ?></td>
                        <td>
                            <?php if ($is_child) : ?>
                                <span class="child-status"><?php _e('Child (50% discount applied)', 'bike-theme'); ?></span>
                            <?php else : ?>
                                <span class="adult-status"><?php _e('Adult', 'bike-theme'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <style>
        .booking-rider-details-meta-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .booking-rider-details-meta-box th,
        .booking-rider-details-meta-box td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .booking-rider-details-meta-box th {
            background-color: #f8f8f8;
            font-height: bold;
        }
        .booking-rider-details-meta-box tr:hover {
            background-color: #f5f5f5;
        }
        .child-status {
            color: #0073aa;
            font-height: bold;
        }
        .adult-status {
            color: #444;
        }
    </style>
    <?php
}

/**
 * Save booking meta box data
 */
function bike_theme_save_booking_meta_box_data($post_id)
{
    // Check if our nonce is set.
    if (!isset($_POST['bike_theme_booking_meta_box_nonce'])) {
        return;
    }
    
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['bike_theme_booking_meta_box_nonce'], 'bike_theme_booking_meta_box')) {
        return;
    }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Update payment status if changed
    if (isset($_POST['payment_status'])) {
        $new_status = sanitize_text_field($_POST['payment_status']);
        $old_status = get_post_meta($post_id, '_booking_payment_status', true);
        
        if ($new_status !== $old_status) {
            update_post_meta($post_id, '_booking_payment_status', $new_status);
            
            // Log the status change
            $log_entry = sprintf(
                __('Payment status changed from %1$s to %2$s by %3$s', 'bike-theme'),
                $old_status,
                $new_status,
                wp_get_current_user()->display_name
            );
            
            $logs = get_post_meta($post_id, '_booking_payment_logs', true);
            if (!is_array($logs)) {
                $logs = array();
            }
            
            $logs[] = array(
                'date' => current_time('mysql'),
                'log' => $log_entry
            );
            
            update_post_meta($post_id, '_booking_payment_logs', $logs);
        }
    }
    
    // Update transaction note
    if (isset($_POST['transaction_note'])) {
        update_post_meta($post_id, '_booking_transaction_note', sanitize_textarea_field($_POST['transaction_note']));
    }
}
add_action('save_post_bike_booking', 'bike_theme_save_booking_meta_box_data');

/**
 * Add custom columns to the booking post type list
 */
function bike_theme_booking_columns($columns)
{
    unset($columns['date']);
    
    $columns['type'] = __('Type', 'bike-theme');
    $columns['customer'] = __('Customer', 'bike-theme');
    $columns['total'] = __('Total', 'bike-theme');
    $columns['booking_date'] = __('Booking Date', 'bike-theme');
    $columns['date'] = __('Created', 'bike-theme');
    
    return $columns;
}
add_filter('manage_bike_booking_posts_columns', 'bike_theme_booking_columns');

/**
 * Populate custom columns for the booking post type
 */
function bike_theme_booking_column_data($column, $post_id)
{
    switch ($column) { 
            
        case 'type':
            $booking_type = get_post_meta($post_id, '_booking_type', true);
            if ($booking_type === 'tour') {
                $tour_id = get_post_meta($post_id, '_booking_tour_id', true);
                echo '<a href="' . get_edit_post_link($tour_id) . '">' . __('Tour', 'bike-theme') . '</a>';
            } else {
                $bike_id = get_post_meta($post_id, '_booking_bike_id', true);
                echo '<a href="' . get_edit_post_link($bike_id) . '">' . __('Bike Rental', 'bike-theme') . '</a>';
            }
            break;
            
        case 'customer':
            $customer_name = get_post_meta($post_id, '_booking_customer_name', true);
            $customer_email = get_post_meta($post_id, '_booking_customer_email', true);
            echo esc_html($customer_name) . '<br><a href="mailto:' . esc_attr($customer_email) . '">' . esc_html($customer_email) . '</a>';
            break;
            
        case 'total':
            $total = get_post_meta($post_id, '_booking_total_price', true);
            echo bike_theme_format_price($total);
            break;
            
        case 'booking_date':
            $booking_date = get_post_meta($post_id, '_booking_date', true);
            echo esc_html(date_i18n(get_option('date_format'), strtotime($booking_date)));
            break;
            
        case 'payment':
            $payment_status = get_post_meta($post_id, '_booking_payment_status', true);
            $status_classes = array(
                'pending' => 'payment-pending',
                'completed' => 'payment-completed',
                'refunded' => 'payment-refunded',
                'cancelled' => 'payment-cancelled',
            );
            $class = isset($status_classes[$payment_status]) ? $status_classes[$payment_status] : '';
            
            echo '<span class="payment-status ' . esc_attr($class) . '">' . esc_html(ucfirst($payment_status)) . '</span>';
            break;
    }
}
add_action('manage_bike_booking_posts_custom_column', 'bike_theme_booking_column_data', 10, 2);

/**
 * Add custom CSS for admin columns
 */
function bike_theme_booking_admin_styles()
{
    $screen = get_current_screen();
    
    if ($screen && $screen->post_type === 'bike_booking') {
        ?>
        <style>
            .payment-status {
                display: inline-block;
                padding: 3px 8px;
                border-radius: 3px;
                font-height: bold;
            }
            .payment-pending {
                background-color: #f8dda7;
                color: #94660c;
            }
            .payment-completed {
                background-color: #c6e1c6;
                color: #5b841b;
            }
            .payment-refunded {
                background-color: #c8d7e1;
                color: #2e4453;
            }
            .payment-cancelled {
                background-color: #eba3a3;
                color: #761919;
            }
            
            .column-reference,
            .column-booking_date {
                width: 10%;
            }
            .column-type,
            .column-total {
                width: 10%;
            }
            .column-customer {
                width: 15%;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'bike_theme_booking_admin_styles');

/**
 * Make columns sortable
 */
function bike_theme_booking_sortable_columns($columns)
{
    $columns['booking_date'] = 'booking_date';
    $columns['total'] = 'total';
    return $columns;
}
add_filter('manage_edit-bike_booking_sortable_columns', 'bike_theme_booking_sortable_columns');

/**
 * Sort columns
 */
function bike_theme_booking_sort_columns($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ('booking_date' === $orderby) {
        $query->set('meta_key', '_booking_date');
        $query->set('orderby', 'meta_value');
    }
    
    if ('total' === $orderby) {
        $query->set('meta_key', '_booking_total_price');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'bike_theme_booking_sort_columns');

/**
 * Register admin filters for bookings
 */
function bike_theme_booking_filters()
{
    global $typenow;
    
    if ($typenow === 'bike_booking') {
        // Filter by booking type
        $booking_type = isset($_GET['booking_type']) ? $_GET['booking_type'] : '';
        ?>
        <select name="booking_type">
            <option value=""><?php _e('All booking types', 'bike-theme'); ?></option>
            <option value="tour" <?php selected($booking_type, 'tour'); ?>><?php _e('Tour Bookings', 'bike-theme'); ?></option>
            <option value="bike" <?php selected($booking_type, 'bike'); ?>><?php _e('Bike Rentals', 'bike-theme'); ?></option>
        </select>
        
        <?php
        // Filter by payment status
        $payment_status = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';
        ?>
        <select name="payment_status">
            <option value=""><?php _e('All payment statuses', 'bike-theme'); ?></option>
            <option value="pending" <?php selected($payment_status, 'pending'); ?>><?php _e('Pending', 'bike-theme'); ?></option>
            <option value="completed" <?php selected($payment_status, 'completed'); ?>><?php _e('Completed', 'bike-theme'); ?></option>
            <option value="refunded" <?php selected($payment_status, 'refunded'); ?>><?php _e('Refunded', 'bike-theme'); ?></option>
            <option value="cancelled" <?php selected($payment_status, 'cancelled'); ?>><?php _e('Cancelled', 'bike-theme'); ?></option>
        </select>
        <?php
    }
}
add_action('restrict_manage_posts', 'bike_theme_booking_filters');

/**
 * Apply booking filters
 */
function bike_theme_apply_booking_filters($query)
{
    global $pagenow, $typenow;
    
    if (is_admin() && $pagenow === 'edit.php' && $typenow === 'bike_booking' && $query->is_main_query()) {
        // Filter by booking type
        if (isset($_GET['booking_type']) && !empty($_GET['booking_type'])) {
            $query->set('meta_key', '_booking_type');
            $query->set('meta_value', sanitize_text_field($_GET['booking_type']));
        }
        
        // Filter by payment status
        if (isset($_GET['payment_status']) && !empty($_GET['payment_status'])) {
            $query->set('meta_query', array(
                array(
                    'key'   => '_booking_payment_status',
                    'value' => sanitize_text_field($_GET['payment_status']),
                )
            ));
        }
    }
}
add_action('pre_get_posts', 'bike_theme_apply_booking_filters'); 