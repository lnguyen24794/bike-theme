<?php
/**
 * The template for displaying single tour
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('bike-theme-tour-single', get_template_directory_uri() . '/assets/css/tour-single.css', array(), BIKE_THEME_VERSION);

// Enqueue and localize booking script
wp_enqueue_script('bike-theme-booking', get_template_directory_uri() . '/assets/js/booking.js', array('jquery'), BIKE_THEME_VERSION, true);

// No localization needed, using inline PHP

// Pass tour pricing data using inline script
$flexible_pricing_enabled = get_post_meta(get_the_ID(), '_tour_flexible_pricing_enabled', true);
$pricing_data = array();

if ($flexible_pricing_enabled === '1') {
    $pricing_data = get_post_meta(get_the_ID(), '_tour_flexible_pricing', true);
    if (empty($pricing_data) || !is_array($pricing_data)) {
        $pricing_data = array(
            array('participants' => 1, 'price' => (int)get_post_meta(get_the_ID(), '_tour_price', true))
        );
    }

    // Ensure all prices are integers
    foreach ($pricing_data as $key => $price_level) {
        $pricing_data[$key]['participants'] = (int)$price_level['participants'];
        $pricing_data[$key]['price'] = (int)$price_level['price'];
    }
} else {
    $pricing_data = array(
        array('participants' => 1, 'price' => (int)get_post_meta(get_the_ID(), '_tour_price', true))
    );
}

// Add pricing data as inline script
$pricing_script = sprintf(
    'window.bike_booking_pricing_data = %s; window.bike_booking_default_price = %d;',
    wp_json_encode($pricing_data),
    (int)get_post_meta(get_the_ID(), '_tour_price', true)
);
wp_add_inline_script('bike-theme-booking', $pricing_script);

// Make sure we have access to the helper functions
require_once get_template_directory() . '/inc/booking/helpers.php';

// Enqueue the tour single CSS


// Get tour meta data
$duration = bike_theme_get_tour_duration(get_the_ID());
$distance = get_post_meta(get_the_ID(), '_tour_distance', true);
$price = get_post_meta(get_the_ID(), '_tour_price', true);
$max_participants = get_post_meta(get_the_ID(), '_tour_max_participants', true);
$difficulty = get_post_meta(get_the_ID(), '_tour_difficulty', true);
$start_location = get_post_meta(get_the_ID(), '_tour_start_location', true);
$end_location = get_post_meta(get_the_ID(), '_tour_end_location', true);
$schedule = get_post_meta(get_the_ID(), '_tour_schedule', true);
$tour_included = get_post_meta(get_the_ID(), '_tour_included', true);
$not_included = get_post_meta(get_the_ID(), '_tour_not_included', true);
$gallery_ids = get_post_meta(get_the_ID(), '_tour_gallery', true);
$contact_info = get_post_meta(get_the_ID(), '_tour_contact_info', true);
$price_info = get_post_meta(get_the_ID(), '_tour_price_info', true);
$bike_reviews = get_post_meta(get_the_ID(), '_tour_review', true);
$tour_booking_terms = get_post_meta(get_the_ID(), '_tour_booking_terms', true);
$tour_cancellation_policy = get_post_meta(get_the_ID(), '_tour_cancellation_policy', true);
$tour_review_info = get_post_meta(get_the_ID(), '_tour_review_info', true);
// Format difficulty text and class
$difficulty_text = '';
$difficulty_class = '';
switch ($difficulty) {
    case 'easy':
        $difficulty_text = __('Easy', 'bike-theme');
        $difficulty_class = 'text-success';
        break;
    case 'moderate':
        $difficulty_text = __('Moderate', 'bike-theme');
        $difficulty_class = 'text-warning';
        break;
    case 'difficult':
        $difficulty_text = __('Difficult', 'bike-theme');
        $difficulty_class = 'text-danger';
        break;
}

// Tab active state
$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'overview';

// Add this before the form HTML
$booking_nonce = wp_create_nonce('bike_tour_booking');
?>

<main id="primary" class="site-main">
    <!-- Page Header Start -->
    <div class="page-header-inner tour-wrapper py-0 d-flex justify-content-center align-items-center" style="background-image: url(<?php echo has_post_thumbnail() ? esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')) : esc_url(get_template_directory_uri() . '/assets/images/bikes/tour-banner.jpg'); ?>);">
        <div class="container-xxl text-center">
        <h1 class="display-4 text-white mb-3 animated slideInDown"><?php the_title(); ?></h1>
        <a class="btn btn-primary cursor-pointer shadow" data-bs-toggle="modal" data-bs-target="#bookingModal"><?php esc_html_e('Book This Tour', 'bike-theme'); ?></a>
        </div>
    </div>
    <div class="container-xxl">
        <div class="row p-4 align-items-center wrapper">
            <div class="col-lg-3 col-12">
                <div class="tour-basic-info-title">
                    <i class="fas fa-money-bill"></i>
                    <h5 class="mb-0 text-uppercase"><?php esc_html_e('Price from', 'bike-theme'); ?></h5>
                    <span><?php echo bike_theme_format_price(bike_theme_get_tour_price_for_display(get_the_ID())); ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="tour-basic-info-title">
                    <i class="fas fa-clock"></i>
                    <h5 class="mb-0 text-uppercase"><?php esc_html_e('Duration', 'bike-theme'); ?></h5>
                    <span><?php echo esc_html($duration); ?></span>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="tour-basic-info-title">
                    <i class="fas fa-road"></i>
                    <h5 class="mb-0 text-uppercase"><?php esc_html_e('Distance', 'bike-theme'); ?></h5>
                    <span><?php echo esc_html($distance); ?> km</span>
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="tour-basic-info-title">
                    <i class="fas fa-star"></i>
                    <h5 class="mb-0 text-uppercase"><?php esc_html_e('Difficulty', 'bike-theme'); ?></h5>
                    <span><?php echo esc_html($difficulty_text); ?></span>
                </div>
            </div>
        </div>

        <div class="w-50 mx-auto border-bottom mb-4"> </div>
    </div>
    <!-- Page Header End -->
    <!-- Tour Slider Start -->
    <?php include(get_template_directory() . '/template-parts/bike-tours/tour-slider.php'); ?>
    <!-- Tour Slider End -->
    <div class="tour-tabs animated" id="tourTabWrapper">
        <div class="container-xxl">
            <ul class="nav nav-tabs d-flex justify-content-start py-2" id="tourTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'overview' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="<?php echo $active_tab === 'overview' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Overview', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'itinerary' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#itinerary" type="button" role="tab" aria-controls="itinerary" aria-selected="<?php echo $active_tab === 'itinerary' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Itinerary', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'price-and-services' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#price-and-services" type="button" role="tab" aria-controls="price-and-services" aria-selected="<?php echo $active_tab === 'price-and-services' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Price & Services', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'booking' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#booking-cancellation" type="button" role="tab" aria-controls="booking-cancellation" aria-selected="<?php echo $active_tab === 'booking-cancellation' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Booking & Cancellation', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'gallery' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="<?php echo $active_tab === 'gallery' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Gallery', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'reviews' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="<?php echo $active_tab === 'reviews' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Reviews', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'add-ons' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#add-ons" type="button" role="tab" aria-controls="add-ons" aria-selected="<?php echo $active_tab === 'add-ons' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Add-ons', 'bike-theme'); ?>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-uppercase <?php echo $active_tab === 'contact' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="<?php echo $active_tab === 'contact' ? 'true' : 'false'; ?>">
                        <?php esc_html_e('Contact', 'bike-theme'); ?>
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <!-- Tour Detail Start -->
    <div class="container-xxl py-0" id="tour-detail">
       
        <div class="row">
            <!-- Tour Description -->
            <div class="col-lg-12 mt-0">
                <!-- Tour Tabs Start -->
                <div class="mb-2 border-bottom">
                    <div class="tab-content px-0 py-3" style="border: none; " id="tourTabContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade <?php echo $active_tab === 'overview' ? 'show active' : ''; ?>" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <!-- Overview Start -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/overview.php'); ?>
                            <!-- Overview End -->
                            <!-- Tour Itinerary Start -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/itinerary.php'); ?>
                            <!-- Tour Itinerary End -->
                            <!-- Price & Services Tab -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/price-and-services.php'); ?>
                            <!-- Price & Services Tab End -->
                            <!-- Booking & Cancellation Tab -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/booking-cancellation.php'); ?>
                            <!-- Booking & Cancellation Tab End -->
                            <!-- Gallery Tab -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/gallery.php'); ?>
                            <!-- Gallery Tab End -->    
                            <!-- Reviews Tab -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/review.php'); ?>
                            <!-- Reviews Tab End -->
                            <!-- Add-ons Tab -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/add-ons.php'); ?>
                            <!-- Add-ons Tab End -->
                            <!-- Contact Tab -->
                            <?php include(get_template_directory() . '/template-parts/bike-tours/contact.php'); ?>
                            <!-- Contact Tab End -->
                        </div>
                    </div>
                </div>
                <!-- Tour Tabs End -->
            </div>
            <!-- Tour Description End -->
             <!-- Bottom Section -->
            <section class="bike-bottom mb-4">
                <div class="container">
                    <div class="row align-items-start">
                        <div class="bottom-cta text-center">
                            <a class="btn btn-primary w-xs-100 mx-auto cursor-pointer" data-bs-toggle="modal" data-bs-target="#bookingModal"><?php esc_html_e('Book This Tour', 'bike-theme'); ?></a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Tour Detail End -->
 <!-- Booking Form Start -->
 <div  class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable tour-booking-form">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bookingModalLabel"><?php esc_html_e('Book This Tour', 'bike-theme'); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="booking-response"></div>
                <form method="post" class="ajax-form">
                    <input type="hidden" name="tour_id" value="<?php echo get_the_ID(); ?>">
                    <div class="row">
                        <div class="col-lg-7 bg-primary py-3 pl-2">
                            <h5 class=""><?php esc_html_e('Your Information', 'bike-theme'); ?></h5>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="<?php esc_attr_e('Your Name', 'bike-theme'); ?>" required>
                                        <label for="name"><?php esc_html_e('Your Name', 'bike-theme'); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="<?php esc_attr_e('Your Phone', 'bike-theme'); ?>" required>
                                        <label for="phone"><?php esc_html_e('Your Phone', 'bike-theme'); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="<?php esc_attr_e('Your Email', 'bike-theme'); ?>" required>
                                        <label for="email"><?php esc_html_e('Your Email', 'bike-theme'); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                                        <label for="date"><?php esc_html_e('Preferred Date', 'bike-theme'); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="participants" name="participants">
                                            <?php for ($i = 1; $i <= $max_participants; $i++) : ?>
                                                <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="participants"><?php esc_html_e('Number of People', 'bike-theme'); ?></label>
                                    </div>
                                </div>
                                <!-- Rider Details start -->
                                <div class="col-12">
                                    <h5 class=""><?php esc_html_e('Rider Details', 'bike-theme'); ?></h5>
                                    <div id="rider-details-container">
                                        <!-- Initial rider form -->
                                        <div class="rider-details mb-3 rounded" data-rider="1">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3 align-items-center">
                                                        <span class="bg-dark text-primary rider-start-number">#1</span>
                                                        <input type="text" class="form-control w-35" id="rider_name_1" name="rider_name[]" placeholder="<?php esc_attr_e('Rider Name', 'bike-theme'); ?>" required>
                                                        <select class="form-select" id="rider_gender_1" name="rider_gender[]">
                                                            <option value="male" ><?php esc_html_e('Male', 'bike-theme'); ?></option>
                                                            <option value="female"><?php esc_html_e('Female', 'bike-theme'); ?></option>
                                                            <option value="other"><?php esc_html_e('Other', 'bike-theme'); ?></option>
                                                        </select>
                                                        <input type="text" class="form-control" id="rider_height_1" name="rider_height[]" placeholder="<?php esc_attr_e('Height (cm or inch)', 'bike-theme'); ?>" min="1">
                                                        <div class="form-check kid-checkbox">
                                                            <input class="form-check-input rider-child-checkbox" type="checkbox" id="rider_is_child_1" name="rider_is_child[]" value="1" data-rider="1">
                                                            <label class="form-check-label" for="rider_is_child_1">
                                                                <?php esc_html_e('Kid', 'bike-theme'); ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-start mt-2 mb-2">
                                        <button type="button" id="add-rider-button" class="btn btn-sm btn-dark">
                                            <i class="fa fa-plus-circle"></i> <?php esc_html_e('Add New Rider', 'bike-theme'); ?>
                                        </button>
                                    </div>
                                </div>
                                <!-- Rider Details end -->
                                <?php
                                $additions = bike_theme_get_tour_additions(get_the_ID());
if (!empty($additions)) :
    ?>
                                <div class="col-12">
                                    <h5 class="mb-3"><?php esc_html_e('Optional Extras', 'bike-theme'); ?></h5>
                                    <div class="additions-options">
                                        <?php foreach ($additions as $addition) : ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input addition-checkbox" type="checkbox" 
                                                    name="additions[]" value="<?php echo esc_attr($addition['name']); ?>" 
                                                    id="addition_<?php echo esc_attr(sanitize_title($addition['name'])); ?>"
                                                    data-price="<?php echo esc_attr($addition['price']); ?>"
                                                    data-per-person="<?php echo esc_attr(isset($addition['per_person']) && $addition['per_person'] ? '1' : '0'); ?>">
                                            <label class="form-check-label" for="addition_<?php echo esc_attr(sanitize_title($addition['name'])); ?>">
                                                <?php echo esc_html($addition['name']); ?> 
                                                (<?php echo esc_html(number_format($addition['price'], 0, '.', ',')); ?> USD
                                                <?php if (isset($addition['per_person']) && $addition['per_person']) {
                                                    echo esc_html__('per person', 'bike-theme');
                                                } ?>)
                                                <?php if (!empty($addition['description'])) : ?>
                                                    <small class="text-muted d-block"><?php echo esc_html($addition['description']); ?></small>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea placeholder="<?php esc_attr_e('Special Request', 'bike-theme'); ?>" id="message" name="message" class="w-100 p-2" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 p-0 pr-2 text-center border">
                            <div class="price-summary p-3">
                                <h5 class="mb-3"><?php esc_html_e('Price Summary', 'bike-theme'); ?></h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><?php esc_html_e('Tour price per person:', 'bike-theme'); ?></span>
                                    <span id="tour-price-per-person"><?php echo esc_html(number_format(bike_theme_get_tour_price(get_the_ID()), 0, '.', ',')); ?> USD</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><?php esc_html_e('Number of participants:', 'bike-theme'); ?></span>
                                    <span id="participant-count">1</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                                    <span><?php esc_html_e('Tour subtotal:', 'bike-theme'); ?></span>
                                    <span id="tour-subtotal"><?php echo esc_html(number_format(bike_theme_get_tour_total_price(get_the_ID(), 1), 0, '.', ',')); ?> USD</span>
                                </div>
                                <?php if (!empty($additions)) : ?>
                                    <div id="additions-summary" class="border-bottom pb-2 mb-2" style="display: none;">
                                        <h6 class="mb-2"><?php esc_html_e('Selected Extras:', 'bike-theme'); ?></h6>
                                        <div class="additions-list my-2"></div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><?php esc_html_e('Additions subtotal:', 'bike-theme'); ?></span>
                                            <span id="additions-subtotal">0 USD</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex justify-content-between fw-bold pt-2">
                                    <span><?php esc_html_e('Total:', 'bike-theme'); ?></span>
                                    <span id="total-price"><?php echo esc_html(number_format(bike_theme_get_tour_total_price(get_the_ID(), 1), 0, '.', ',')); ?> USD</span>
                                </div>
                            </div>
                            <button class="btn btn-primary w-50 submit-button shadow mb-3" type="button" ><?php esc_html_e('Book Now', 'bike-theme'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Booking Form End -->
</main><!-- #main -->


<script>
jQuery(document).ready(function($) {
    // Format number with commas
    var formatNumber = function(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Get price per person based on participant count
    var getPricePerPerson = function(participants) {
        // Get tour pricing data
        var pricingData = window.bike_booking_pricing_data || [];
        
        // Sort pricing data by number of participants (descending)
        pricingData.sort(function(a, b) {
            return b.participants - a.participants;
        });
        
        var applicablePrice = null;
        
        // Find applicable price level by searching from highest to lowest
        for (var i = 0; i < pricingData.length; i++) {
            if (participants >= pricingData[i].participants) {
                applicablePrice = pricingData[i].price;
                break;
            }
        }
        
        // If no applicable price found, use the lowest price level
        if (applicablePrice === null && pricingData.length > 0) {
            pricingData.sort(function(a, b) {
                return a.participants - b.participants;
            });
            applicablePrice = pricingData[0].price;
        }
        
        return applicablePrice || window.bike_booking_default_price || 0;
    }

    // Update price summary based on selections
    var updatePriceSummary = function() {
        var participants = parseInt($('#participants').val());
        var pricePerPerson = getPricePerPerson(participants);
        var childCount = $('.rider-child-checkbox:checked').length;
        var adultCount = participants - childCount;
        
        // Calculate tour subtotal with child discounts
        var tourSubtotal = (adultCount * pricePerPerson) + (childCount * pricePerPerson * 0.5);
        
        // Ensure tourSubtotal is a valid number
        if (isNaN(tourSubtotal)) {
            tourSubtotal = 0;
        }
        
        var additionsTotal = 0;
        var additionsList = [];

        // Calculate additions total with child discounts
        $('.addition-checkbox:checked').each(function() {
            var price = parseFloat($(this).data('price'));
            var perPerson = $(this).data('per-person') === 1;
            var additionTotal = 0;
            
            if (perPerson) {
                // Apply the same child discount to per-person additions
                additionTotal = (adultCount * price) + (childCount * price * 0.5);
            } else {
                additionTotal = price;
            }
            
            additionsTotal += additionTotal;
            
            additionsList.push(
                '<div class="d-flex justify-content-between mb-1">' +
                '<small>' + $(this).next('label').text().split('(')[0].trim() + '</small>' +
                '<small>' + formatNumber(additionTotal) + ' USD</small>' +
                '</div>'
            );
        });

        // Update display
        $('#tour-price-per-person').text(formatNumber(pricePerPerson) + ' USD');
        
        // Show participant breakdown if there are children
        var participantText = participants;
        if (childCount > 0) {
            participantText = adultCount + ' adults, ' + childCount + ' children';
        }
        
        $('#participant-count').text(participantText);
        $('#tour-subtotal').text(formatNumber(tourSubtotal) + ' USD');
        
        if (additionsList.length > 0) {
            $('.additions-list').html(additionsList.join(''));
            $('#additions-subtotal').text(formatNumber(additionsTotal) + ' USD');
            $('#additions-summary').slideDown();
        } else {
            $('#additions-summary').slideUp();
        }

        $('#total-price').text(formatNumber(tourSubtotal + additionsTotal) + ' USD');
    }

    // Update price when participants change or additions are selected
    $('#participants').change(updatePriceSummary);
    $('.addition-checkbox').change(updatePriceSummary);

    // Initial price update
    updatePriceSummary();

    // Ensure we update the price when modal opens
    $('#bookingModal').on('shown.bs.modal', function() {
        updatePriceSummary();
    });

    // Handle rider details based on participant count
    var updateRiderDetails = function() {
        var participantCount = parseInt($('#participants').val());
        var $container = $('#rider-details-container');
        var currentRiders = $container.find('.rider-details').length;

        // Add more rider forms if needed
        if (participantCount > currentRiders) {
            for (var i = currentRiders + 1; i <= participantCount; i++) {
                var riderHtml = `
                     <div class="rider-details mb-3 rounded" data-rider="${i}">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3 align-items-center">
                                    <span class="bg-dark text-primary rider-start-number">#${i}</span>
                                    <input type="text" class="form-control w-35" id="rider_name_${i}" name="rider_name[]" placeholder="Rider Name" required>
                                    <select class="form-select" id="rider_gender_${i}" name="rider_gender[]">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <input type="text" class="form-control" id="rider_height_${i}" name="rider_height[]" placeholder="Height (cm or inch)" min="1">
                                    <div class="form-check kid-checkbox">
                                        <input class="form-check-input rider-child-checkbox" type="checkbox" id="rider_is_child_${i}" name="rider_is_child[]" value="1" data-rider="${i}">
                                        <label class="form-check-label" for="rider_is_child_${i}">
                                            Kid
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $container.append(riderHtml);
            }
        }
        // Remove excess rider forms
        else if (participantCount < currentRiders) {
            $container.find('.rider-details').slice(participantCount).remove();
        }

        // Update price calculation with child discounts
        updatePriceSummary();
    }

    // Initialize rider details
    updateRiderDetails();

    // Update rider details when participant count changes
    $('#participants').change(updateRiderDetails);
    
    // Handle Add New Rider button click
    $('#add-rider-button').on('click', function() {
        var participantCount = parseInt($('#participants').val());
        var maxParticipants = parseInt($('#participants option:last-child').val());
        var newCount = participantCount + 1;
        
        // Check if we reached maximum participants
        if (newCount > maxParticipants) {
            alert('Maximum number of participants reached.');
            return;
        }
        
        // Update participants select
        $('#participants').val(newCount);
        
        // Add new rider form
        updateRiderDetails();
        
        // Update price summary
        if (typeof updatePriceSummary === 'function') {
            updatePriceSummary();
        }
    });

    // Update price calculation when child status changes
    $(document).on('change', '.rider-child-checkbox', function() {
        if (typeof updatePriceSummary === 'function') {
            updatePriceSummary();
        }
    });

    // Handle form submission
    $('.submit-button').on('click', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var $form = $button.closest('form');
        var $responseDiv = $('.booking-response');

        // Check if already processing - prevent double submission
        if ($button.data('processing') === true) {
            console.log('Form submission already in progress');
            return;
        }
        
        // Set processing flag
        $button.data('processing', true);

        // Validate form
        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            $button.data('processing', false);
            return;
        }

        // Disable button and show loading state
        $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + 'Submitting...');

        // Get form data
        var formData = new FormData($form[0]);
        formData.append('action', 'bike_theme_process_booking');
        formData.append('security', '<?php echo wp_create_nonce('bike_booking_nonce'); ?>');

        // Send Ajax request
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $responseDiv.html('<div class="alert alert-success">' + response.data.message + '</div>');
                    
                    // Reset form
                    $form[0].reset();
                    
                    // Update price calculation if exists
                    if (typeof updatePriceSummary === 'function') {
                        updatePriceSummary();
                    }

                    // Reset rider details
                    if (typeof updateRiderDetails === 'function') { 
                        updateRiderDetails();
                    }

                    // Refresh security token is handled automatically

                    // Scroll to response message
                    $('html, body').animate({
                        scrollTop: $responseDiv.offset().top - 100
                    }, 500);

                    window.location.href = '<?php echo home_url(); ?>/thank-you?booking_id=' + response.data.booking_id;
                } else {
                    // Show error message
                    var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                    if (Array.isArray(response.data)) {
                        response.data.forEach(function(error) {
                            errorHtml += '<li>' + error + '</li>';
                        });
                    } else {
                        errorHtml += '<li>' + response.data.message + '</li>';
                    }
                    errorHtml += '</ul></div>';
                    $responseDiv.html(errorHtml);

                    // Scroll to error message
                    $('html, body').animate({
                        scrollTop: $responseDiv.offset().top - 100
                    }, 500);
                }
            },
            error: function() {
                // Show error message
                $responseDiv.html('<div class="alert alert-danger"><?php echo esc_js(__('An error occurred. Please try again.', 'bike-theme')); ?></div>');
                
                // Scroll to error message
                $('html, body').animate({
                    scrollTop: $responseDiv.offset().top - 100
                }, 500);
            },
            complete: function() {
                // Re-enable button
                $button.prop('disabled', false).text('<?php echo esc_js(__('Book Now', 'bike-theme')); ?>');
                // Reset processing flag
                $button.data('processing', false);
            }
        });
    });
    
    // Tab navigation smooth scroll
    $('#tourTab .nav-link').click(function() {
        var $this = $(this);
        var target = $this.attr('data-bs-target');
        window.scrollTo({
            top: $(target).offset().top - 100,
            behavior: 'smooth'
        });
    });
});
</script>

<?php
get_footer();
?> 