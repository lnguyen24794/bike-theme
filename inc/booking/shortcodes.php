<?php
/**
 * Booking shortcodes
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register booking shortcodes
 */
function bike_theme_register_booking_shortcodes()
{
    add_shortcode('bike_booking_form', 'bike_theme_booking_form_shortcode');
    add_shortcode('bike_booking_confirmation', 'bike_theme_booking_confirmation_shortcode');
    add_shortcode('bike_booking_history', 'bike_theme_booking_history_shortcode');
}
add_action('init', 'bike_theme_register_booking_shortcodes');

/**
 * Booking form shortcode
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function bike_theme_booking_form_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'tour_id' => 0,
            'bike_id' => 0,
            'redirect' => '',
        ),
        $atts,
        'bike_booking_form'
    );

    // Convert the shortcode attributes to integers
    $tour_id = intval($atts['tour_id']);
    $bike_id = intval($atts['bike_id']);
    
    ob_start();

    // Show any error messages
    if (isset($_GET['booking']) && $_GET['booking'] === 'error' && isset($_GET['message'])) {
        echo '<div class="alert alert-danger">' . esc_html(urldecode($_GET['message'])) . '</div>';
    }

    ?>
    <form class="bike-booking-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="bike_theme_submit_booking">
        <?php wp_nonce_field('bike_theme_booking_nonce', 'booking_nonce'); ?>
        
        <?php if ($tour_id > 0) : ?>
            <input type="hidden" name="tour" value="<?php echo esc_attr($tour_id); ?>">
            <h3><?php echo esc_html(get_the_title($tour_id)); ?></h3>
            <div class="booking-tour-summary">
                <div class="booking-tour-image">
                    <?php echo get_the_post_thumbnail($tour_id, 'medium'); ?>
                </div>
                <div class="booking-tour-details">
                    <?php 
                    $tour_duration = get_post_meta($tour_id, '_tour_duration', true);
                    $tour_difficulty = get_post_meta($tour_id, '_tour_difficulty', true);
                    $min_price = bike_theme_get_tour_min_price($tour_id);
                    ?>
                    <?php if (!empty($tour_duration)) : ?>
                        <div class="tour-detail"><span><?php _e('Duration:', 'bike-theme'); ?></span> <?php echo esc_html($tour_duration); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($tour_difficulty)) : ?>
                        <div class="tour-detail"><span><?php _e('Difficulty:', 'bike-theme'); ?></span> <?php echo esc_html($tour_difficulty); ?></div>
                    <?php endif; ?>
                    <?php if ($min_price) : ?>
                        <div class="tour-detail"><span><?php _e('Starting from:', 'bike-theme'); ?></span> <?php echo bike_theme_format_price($min_price); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif ($bike_id > 0) : ?>
            <input type="hidden" name="bike" value="<?php echo esc_attr($bike_id); ?>">
            <h3><?php echo esc_html(get_the_title($bike_id)); ?></h3>
            <div class="booking-bike-summary">
                <div class="booking-bike-image">
                    <?php echo get_the_post_thumbnail($bike_id, 'medium'); ?>
                </div>
                <div class="booking-bike-details">
                    <?php 
                    $bike_type = get_post_meta($bike_id, '_bike_type', true);
                    $bike_features = get_post_meta($bike_id, '_bike_features', true);
                    ?>
                    <?php if (!empty($bike_type)) : ?>
                        <div class="bike-detail"><span><?php _e('Type:', 'bike-theme'); ?></span> <?php echo esc_html($bike_type); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($bike_features)) : ?>
                        <div class="bike-detail"><span><?php _e('Features:', 'bike-theme'); ?></span> <?php echo esc_html($bike_features); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="booking-type-selector">
                <div class="form-group">
                    <label for="booking-type"><?php _e('Booking Type', 'bike-theme'); ?></label>
                    <select name="booking_type" id="booking-type" class="form-control">
                        <option value=""><?php _e('Select booking type', 'bike-theme'); ?></option>
                        <option value="tour"><?php _e('Book a Tour', 'bike-theme'); ?></option>
                        <option value="bike"><?php _e('Rent a Bike', 'bike-theme'); ?></option>
                    </select>
                </div>
                
                <div class="form-group tour-select-group" style="display: none;">
                    <label for="tour"><?php _e('Select a Tour', 'bike-theme'); ?></label>
                    <select name="tour" id="tour" class="form-control">
                        <option value=""><?php _e('Select a tour', 'bike-theme'); ?></option>
                        <?php
                        $tours = get_posts(array(
                            'post_type' => 'bike_tour',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'title',
                            'order' => 'ASC',
                        ));
                        
                        foreach ($tours as $tour) {
                            printf(
                                '<option value="%s">%s</option>',
                                esc_attr($tour->ID),
                                esc_html($tour->post_title)
                            );
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group bike-select-group" style="display: none;">
                    <label for="bike"><?php _e('Select a Bike', 'bike-theme'); ?></label>
                    <select name="bike" id="bike" class="form-control">
                        <option value=""><?php _e('Select a bike', 'bike-theme'); ?></option>
                        <?php
                        $bikes = get_posts(array(
                            'post_type' => 'bike',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'orderby' => 'title',
                            'order' => 'ASC',
                        ));
                        
                        foreach ($bikes as $bike) {
                            printf(
                                '<option value="%s">%s</option>',
                                esc_attr($bike->ID),
                                esc_html($bike->post_title)
                            );
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name"><?php _e('Your Name', 'bike-theme'); ?> <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email"><?php _e('Email Address', 'bike-theme'); ?> <span class="required">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone"><?php _e('Phone Number', 'bike-theme'); ?> <span class="required">*</span></label>
                    <input type="tel" name="phone" id="phone" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date"><?php _e('Preferred Date', 'bike-theme'); ?> <span class="required">*</span></label>
                    <input type="date" name="date" id="date" class="form-control datepicker" required>
                </div>
            </div>
        </div>
        
        <?php if ($tour_id > 0 || empty($bike_id)) : ?>
        <div class="form-group participants-group">
            <label for="participants"><?php _e('Number of Participants', 'bike-theme'); ?> <span class="required">*</span></label>
            <select name="participants" id="participants" class="form-control">
                <?php for ($i = 1; $i <= 10; $i++) : ?>
                    <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="payment_method"><?php _e('Payment Method', 'bike-theme'); ?> <span class="required">*</span></label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="cash"><?php _e('Cash on Arrival', 'bike-theme'); ?></option>
                <option value="bank_transfer"><?php _e('Bank Transfer', 'bike-theme'); ?></option>
                <option value="credit_card"><?php _e('Credit Card', 'bike-theme'); ?></option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="message"><?php _e('Special Requests', 'bike-theme'); ?></label>
            <textarea name="message" id="message" class="form-control" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?php _e('Submit Booking', 'bike-theme'); ?></button>
        </div>
    </form>
    <script>
    jQuery(document).ready(function($) {
        // Initialize datepicker
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 1
        });
        
        // Show/hide tour/bike selection based on booking type
        $('#booking-type').on('change', function() {
            var selectedType = $(this).val();
            
            if (selectedType === 'tour') {
                $('.tour-select-group').show();
                $('.bike-select-group').hide();
                $('.participants-group').show();
            } else if (selectedType === 'bike') {
                $('.bike-select-group').show();
                $('.tour-select-group').hide();
                $('.participants-group').hide();
            } else {
                $('.tour-select-group').hide();
                $('.bike-select-group').hide();
                $('.participants-group').hide();
            }
        });
    });
    </script>
    <?php
    
    return ob_get_clean();
}

/**
 * Booking confirmation shortcode - displays booking confirmation details
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function bike_theme_booking_confirmation_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'title' => __('Booking Confirmation', 'bike-theme'),
        ),
        $atts,
        'bike_booking_confirmation'
    );
    
    ob_start();
    
    if (isset($_GET['booking']) && $_GET['booking'] === 'success' && isset($_GET['id'])) {
        $booking_id = intval($_GET['id']);
        $booking = get_post($booking_id);
        
        if ($booking && $booking->post_type === 'bike_booking') {
            // Get booking data
            $customer_name = get_post_meta($booking_id, '_booking_customer_name', true);
            $customer_email = get_post_meta($booking_id, '_booking_customer_email', true);
            $customer_phone = get_post_meta($booking_id, '_booking_customer_phone', true);
            $booking_date = get_post_meta($booking_id, '_booking_date', true);
            $number_of_participants = get_post_meta($booking_id, '_booking_participants', true);
            $price_per_person = get_post_meta($booking_id, '_booking_price_per_person', true);
            $total_price = get_post_meta($booking_id, '_booking_total_price', true);
            $tour_id = get_post_meta($booking_id, '_booking_tour_id', true);
            $bike_id = get_post_meta($booking_id, '_booking_bike_id', true);
            $booking_type = get_post_meta($booking_id, '_booking_type', true);
            $payment_method = get_post_meta($booking_id, '_booking_payment_method', true);
            
            ?>
            <div class="bike-booking-confirmation">
                <h2><?php echo esc_html($atts['title']); ?></h2>
                
                <div class="alert alert-success">
                    <?php _e('Your booking has been received successfully! Please check your email for confirmation details.', 'bike-theme'); ?>
                </div>
                
                <div class="booking-details">
                    <h3><?php _e('Booking Details', 'bike-theme'); ?></h3>
                    
                    <div class="booking-info">
                        <p><strong><?php _e('Booking Status:', 'bike-theme'); ?></strong> <?php _e('Pending', 'bike-theme'); ?></p>
                        <p><strong><?php _e('Date:', 'bike-theme'); ?></strong> <?php echo esc_html($booking_date); ?></p>
                        
                        <?php if ($booking_type === 'tour' && $tour_id) : ?>
                            <p><strong><?php _e('Tour:', 'bike-theme'); ?></strong> <?php echo esc_html(get_the_title($tour_id)); ?></p>
                            <p><strong><?php _e('Participants:', 'bike-theme'); ?></strong> <?php echo esc_html($number_of_participants); ?></p>
                            <?php if ($price_per_person) : ?>
                                <p><strong><?php _e('Price per Person:', 'bike-theme'); ?></strong> <?php echo bike_theme_format_price($price_per_person); ?></p>
                                <p><strong><?php _e('Total Price:', 'bike-theme'); ?></strong> <?php echo bike_theme_format_price($total_price); ?></p>
                            <?php endif; ?>
                        <?php elseif ($booking_type === 'bike' && $bike_id) : ?>
                            <p><strong><?php _e('Bike:', 'bike-theme'); ?></strong> <?php echo esc_html(get_the_title($bike_id)); ?></p>
                        <?php endif; ?>
                        
                        <p><strong><?php _e('Payment Method:', 'bike-theme'); ?></strong> 
                        <?php 
                        switch ($payment_method) {
                            case 'cash':
                                _e('Cash on Arrival', 'bike-theme');
                                break;
                            case 'bank_transfer':
                                _e('Bank Transfer', 'bike-theme');
                                break;
                            case 'credit_card':
                                _e('Credit Card', 'bike-theme');
                                break;
                            default:
                                echo esc_html($payment_method);
                        }
                        ?>
                        </p>
                    </div>
                    
                    <div class="customer-info">
                        <h3><?php _e('Customer Information', 'bike-theme'); ?></h3>
                        <p><strong><?php _e('Name:', 'bike-theme'); ?></strong> <?php echo esc_html($customer_name); ?></p>
                        <p><strong><?php _e('Email:', 'bike-theme'); ?></strong> <?php echo esc_html($customer_email); ?></p>
                        <p><strong><?php _e('Phone:', 'bike-theme'); ?></strong> <?php echo esc_html($customer_phone); ?></p>
                    </div>
                    
                    <?php if ($payment_method === 'bank_transfer') : ?>
                    <div class="payment-instructions">
                        <h3><?php _e('Payment Instructions', 'bike-theme'); ?></h3>
                        <div class="alert alert-info">
                            <p><?php _e('Please transfer the total amount to the following bank account:', 'bike-theme'); ?></p>
                            <p><strong><?php _e('Bank Name:', 'bike-theme'); ?></strong> <?php echo esc_html(get_option('bike_theme_bank_name', 'Example Bank')); ?></p>
                            <p><strong><?php _e('Account Name:', 'bike-theme'); ?></strong> <?php echo esc_html(get_option('bike_theme_account_name', 'Bike Tours Company')); ?></p>
                            <p><strong><?php _e('Account Number:', 'bike-theme'); ?></strong> <?php echo esc_html(get_option('bike_theme_account_number', '1234567890')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="next-steps">
                        <h3><?php _e('What Happens Next?', 'bike-theme'); ?></h3>
                        <ol>
                            <li><?php _e('Our team will review your booking request.', 'bike-theme'); ?></li>
                            <li><?php _e('We will contact you to confirm availability and details.', 'bike-theme'); ?></li>
                            <li><?php _e('Once confirmed, you will receive a final confirmation email.', 'bike-theme'); ?></li>
                            <?php if ($payment_method === 'bank_transfer') : ?>
                                <li><?php _e('Please complete the payment as per the instructions above.', 'bike-theme'); ?></li>
                            <?php endif; ?>
                            <li><?php _e('Get ready for your amazing bike adventure!', 'bike-theme'); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger">
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-warning">
            <?php _e('No booking information found. Please complete a booking first.', 'bike-theme'); ?>
        </div>
        <?php
    }
    
    return ob_get_clean();
}

/**
 * Booking history shortcode - for logged in users to view their booking history
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function bike_theme_booking_history_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'title' => __('My Bookings', 'bike-theme'),
        ),
        $atts,
        'bike_booking_history'
    );
    
    ob_start();
    
    if (!is_user_logged_in()) {
        ?>
        <div class="alert alert-info">
            <p><?php _e('Please log in to view your booking history.', 'bike-theme'); ?></p>
            <p><a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="btn btn-primary"><?php _e('Log In', 'bike-theme'); ?></a></p>
        </div>
        <?php
        return ob_get_clean();
    }
    
    $current_user = wp_get_current_user();
    
    // Get bookings for current user
    $args = array(
        'post_type' => 'bike_booking',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_booking_customer_email',
                'value' => $current_user->user_email,
                'compare' => '=',
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    $bookings = get_posts($args);
    
    ?>
    <div class="bike-booking-history">
        <h2><?php echo esc_html($atts['title']); ?></h2>
        
        <?php if (!empty($bookings)) : ?>
            <table class="booking-history-table">
                <thead>
                    <tr>
                        <th><?php _e('Booking ID', 'bike-theme'); ?></th>
                        <th><?php _e('Date', 'bike-theme'); ?></th>
                        <th><?php _e('Type', 'bike-theme'); ?></th>
                        <th><?php _e('Details', 'bike-theme'); ?></th>
                        <th><?php _e('Status', 'bike-theme'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) : 
                        $booking_id = $booking->ID;
                        $booking_date = get_post_meta($booking_id, '_booking_date', true);
                        $booking_type = get_post_meta($booking_id, '_booking_type', true);
                        $tour_id = get_post_meta($booking_id, '_booking_tour_id', true);
                        $bike_id = get_post_meta($booking_id, '_booking_bike_id', true);
                        $participants = get_post_meta($booking_id, '_booking_participants', true);
                        $booking_status = get_post_meta($booking_id, '_booking_status', true);
                    ?>
                        <tr>
                            <td>#<?php echo esc_html($booking_id); ?></td>
                            <td><?php echo esc_html($booking_date); ?></td>
                            <td>
                                <?php 
                                if ($booking_type === 'tour') {
                                    _e('Tour', 'bike-theme');
                                } elseif ($booking_type === 'bike') {
                                    _e('Bike Rental', 'bike-theme');
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($booking_type === 'tour' && $tour_id) : ?>
                                    <?php echo esc_html(get_the_title($tour_id)); ?>
                                    <?php if ($participants) : ?>
                                        (<?php printf(_n('%d participant', '%d participants', $participants, 'bike-theme'), $participants); ?>)
                                    <?php endif; ?>
                                <?php elseif ($booking_type === 'bike' && $bike_id) : ?>
                                    <?php echo esc_html(get_the_title($bike_id)); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="booking-status booking-status-<?php echo esc_attr($booking_status); ?>">
                                    <?php 
                                    switch ($booking_status) {
                                        case 'pending':
                                            _e('Pending', 'bike-theme');
                                            break;
                                        case 'confirmed':
                                            _e('Confirmed', 'bike-theme');
                                            break;
                                        case 'completed':
                                            _e('Completed', 'bike-theme');
                                            break;
                                        case 'cancelled':
                                            _e('Cancelled', 'bike-theme');
                                            break;
                                        default:
                                            echo esc_html($booking_status);
                                    }
                                    ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info">
                <?php _e('You have no bookings yet.', 'bike-theme'); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    
    return ob_get_clean();
} 