<?php
/**
 * Tour Custom Post Type and related functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Tour post type
 */
function bike_theme_register_tour_post_type()
{
    $labels = array(
        'name'               => __('Bike Tours', 'bike-theme'),
        'singular_name'      => __('Bike Tour', 'bike-theme'),
        'menu_name'          => __('Bike Tours', 'bike-theme'),
        'add_new'            => __('Add New', 'bike-theme'),
        'add_new_item'       => __('Add New Bike Tour', 'bike-theme'),
        'edit_item'          => __('Edit Bike Tour', 'bike-theme'),
        'new_item'           => __('New Bike Tour', 'bike-theme'),
        'view_item'          => __('View Bike Tour', 'bike-theme'),
        'search_items'       => __('Search Bike Tours', 'bike-theme'),
        'not_found'          => __('No bike tours found', 'bike-theme'),
        'not_found_in_trash' => __('No bike tours found in Trash', 'bike-theme'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'bike-tour'),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-location-alt',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
    );

    register_post_type('bike_tour', $args);

    // Register Tour Category taxonomy
    $tax_labels = array(
        'name'              => __('Bike Tour Categories', 'bike-theme'),
        'singular_name'     => __('Bike Tour Category', 'bike-theme'),
        'search_items'      => __('Search Bike Tour Categories', 'bike-theme'),
        'all_items'         => __('All Bike Tour Categories', 'bike-theme'),
        'parent_item'       => __('Parent Bike Tour Category', 'bike-theme'),
        'parent_item_colon' => __('Parent Bike Tour Category:', 'bike-theme'),
        'edit_item'         => __('Edit Bike Tour Category', 'bike-theme'),
        'update_item'       => __('Update Bike Tour Category', 'bike-theme'),
        'add_new_item'      => __('Add New Bike Tour Category', 'bike-theme'),
        'new_item_name'     => __('New Bike Tour Category Name', 'bike-theme'),
        'menu_name'         => __('Categories', 'bike-theme'),
    );

    $tax_args = array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tour-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('tour_category', array('bike_tour'), $tax_args);
}
add_action('init', 'bike_theme_register_tour_post_type');

/**
 * Add image field to destination taxonomy
 */
function bike_theme_tour_category_add_image_field()
{
    ?>
    <div class="form-field">
        <label for="tour_category_image"><?php _e('Tour Category Image', 'bike-theme'); ?></label>
        <input type="hidden" id="tour_category_image" name="tour_category_image" class="custom_media_url" value="">
        <div id="tour_category_image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary tour_category_tax_media_button" id="tour_category_tax_media_button" name="tour_category_tax_media_button" value="<?php _e('Add Image', 'bike-theme'); ?>" />
            <input type="button" class="button button-secondary tour_category_tax_media_remove" id="tour_category_tax_media_remove" name="tour_category_tax_media_remove" value="<?php _e('Remove Image', 'bike-theme'); ?>" />
        </p>
    </div>
    <?php
}
add_action('tour_category_add_form_fields', 'bike_theme_tour_category_add_image_field', 10, 2);

/**
 * Edit image field in destination taxonomy
 */
function bike_theme_tour_category_edit_image_field($term)
{
    $image_id = get_term_meta($term->term_id, 'tour_category_image', true);
    $image_url = wp_get_attachment_url($image_id);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="tour_category_image"><?php _e('Tour Category Image', 'bike-theme'); ?></label>
        </th>
        <td>
            <input type="hidden" id="tour_category_image" name="tour_category_image" class="custom_media_url" value="<?php echo esc_attr($image_id); ?>">
            <div id="tour_category_image-wrapper">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 50%; height: auto; margin: 10px 0;">
                <?php endif; ?>
            </div>
            <p>
                <input type="button" class="button button-secondary tour_category_tax_media_button" id="tour_category_tax_media_button" name="tour_category_tax_media_button" value="<?php _e('Add Image', 'bike-theme'); ?>" />
                <input type="button" class="button button-secondary tour_category_tax_media_remove" id="tour_category_tax_media_remove" name="tour_category_tax_media_remove" value="<?php _e('Remove Image', 'bike-theme'); ?>" />
            </p>
        </td>
    </tr>
    <?php
}
add_action('tour_category_edit_form_fields', 'bike_theme_tour_category_edit_image_field', 10, 2);

/**
 * Save destination image
 */
function bike_theme_save_tour_category_image($term_id)
{
    if (isset($_POST['tour_category_image'])) {
        update_term_meta($term_id, 'tour_category_image', absint($_POST['tour_category_image']));
    }
}
add_action('created_tour_category', 'bike_theme_save_tour_category_image', 10, 2);
add_action('edited_tour_category', 'bike_theme_save_tour_category_image', 10, 2);

/**
 * Enqueue media uploader scripts
 */
function bike_theme_tour_category_media_scripts()
{
    if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'tour_category') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('tour_category-media-uploader', get_template_directory_uri() . '/assets/js/tour_category-media.js', array('jquery'), BIKE_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'bike_theme_tour_category_media_scripts');

/**
 * Add meta boxes for Tour post type
 */
function bike_theme_add_tour_meta_boxes()
{
    add_meta_box(
        'tour_details',
        __('Tour Details', 'bike-theme'),
        'bike_theme_tour_details_meta_box_callback',
        'bike_tour',
        'normal',
        'high'
    );

    add_meta_box(
        'tour_pricing',
        __('Tour Pricing', 'bike-theme'),
        'bike_theme_tour_pricing_meta_box_callback',
        'bike_tour',
        'normal',
        'high'
    );

    add_meta_box(
        'tour_ebike_available',
        __('E-bike Availability', 'bike-theme'),
        'bike_theme_tour_ebike_callback',
        'bike_tour',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'bike_theme_add_tour_meta_boxes');

/**
 * Tour details meta box callback
 */
function bike_theme_tour_details_meta_box_callback($post)
{
    wp_nonce_field('bike_theme_tour_details_nonce', 'bike_theme_tour_details_nonce');

    // Get stored values
    $tour_duration_type = get_post_meta($post->ID, '_tour_duration_type', true) ?: 'days_nights';
    $tour_duration_days = get_post_meta($post->ID, '_tour_duration_days', true);
    $tour_duration_nights = get_post_meta($post->ID, '_tour_duration_nights', true);
    $tour_duration_hours = get_post_meta($post->ID, '_tour_duration_hours', true);
    $tour_distance = get_post_meta($post->ID, '_tour_distance', true);
    $tour_difficulty = get_post_meta($post->ID, '_tour_difficulty', true);
    $tour_max_participants = get_post_meta($post->ID, '_tour_max_participants', true);
    $tour_start_location = get_post_meta($post->ID, '_tour_start_location', true);
    $tour_end_location = get_post_meta($post->ID, '_tour_end_location', true);
    $tour_included = get_post_meta($post->ID, '_tour_included', true);
    $tour_not_included = get_post_meta($post->ID, '_tour_not_included', true);
    $tour_itinerary_data = get_post_meta($post->ID, '_tour_itinerary_data', true);
    $tour_booking_terms = get_post_meta($post->ID, '_tour_booking_terms', true);
    $tour_cancellation_policy = get_post_meta($post->ID, '_tour_cancellation_policy', true);
    $tour_contact_info = get_post_meta($post->ID, '_tour_contact_info', true);
    $tour_price_info = get_post_meta($post->ID, '_tour_price_info', true);
    $tour_add_ons = get_post_meta($post->ID, '_tour_add_ons', true);
    $tour_review_info = get_post_meta($post->ID, '_tour_review_info', true);
    if (!is_array($tour_itinerary_data)) {
        $tour_itinerary_data = array();
    }

    ?>
    <div class="tour-meta-box">
        <h3><?php esc_html_e('Basic Information', 'bike-theme'); ?></h3>
        
        <!-- Duration Section -->
        <div class="duration-section">
            <p>
                <label><?php esc_html_e('Duration Type', 'bike-theme'); ?></label>
                <select id="tour_duration_type" name="tour_duration_type" class="widefat">
                    <option value="days_nights" <?php selected($tour_duration_type, 'days_nights'); ?>><?php esc_html_e('Days & Nights', 'bike-theme'); ?></option>
                    <option value="hours" <?php selected($tour_duration_type, 'hours'); ?>><?php esc_html_e('Hours', 'bike-theme'); ?></option>
                </select>
            </p>
            
            <div id="days_nights_fields" class="duration-fields" <?php echo $tour_duration_type === 'hours' ? 'style="display:none;"' : ''; ?>>
                <div class="duration-flex">
                    <p class="duration-field">
                        <label for="tour_duration_days"><?php esc_html_e('Days', 'bike-theme'); ?></label>
                        <input type="number" id="tour_duration_days" name="tour_duration_days" 
                               value="<?php echo esc_attr($tour_duration_days); ?>" class="widefat" min="0">
                    </p>
                    <p class="duration-field">
                        <label for="tour_duration_nights"><?php esc_html_e('Nights', 'bike-theme'); ?></label>
                        <input type="number" id="tour_duration_nights" name="tour_duration_nights" 
                               value="<?php echo esc_attr($tour_duration_nights); ?>" class="widefat" min="0">
                    </p>
                </div>
            </div>
            
            <div id="hours_fields" class="duration-fields" <?php echo $tour_duration_type === 'days_nights' ? 'style="display:none;"' : ''; ?>>
                <p>
                    <label for="tour_duration_hours"><?php esc_html_e('Hours', 'bike-theme'); ?></label>
                    <input type="number" id="tour_duration_hours" name="tour_duration_hours" 
                           value="<?php echo esc_attr($tour_duration_hours); ?>" class="widefat" min="0" step="0.5">
                </p>
            </div>
        </div>

        <style>
            .duration-flex {
                display: flex;
                gap: 20px;
            }
            .duration-field {
                flex: 1;
            }
            .duration-section {
                margin-bottom: 20px;
                padding: 15px;
                background: #f9f9f9;
                border: 1px solid #e5e5e5;
                border-radius: 4px;
            }
            .tour-meta-box h3 {
                margin: 1.5em 0 0.5em;
                padding-bottom: 0.5em;
                border-bottom: 1px solid #ddd;
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            $('#tour_duration_type').on('change', function() {
                var type = $(this).val();
                if (type === 'days_nights') {
                    $('#days_nights_fields').show();
                    $('#hours_fields').hide();
                } else {
                    $('#days_nights_fields').hide();
                    $('#hours_fields').show();
                }
            });
        });
        </script>

        <p>
            <label for="tour_distance"><?php esc_html_e('Distance (km)', 'bike-theme'); ?></label>
            <input type="number" id="tour_distance" name="tour_distance" value="<?php echo esc_attr($tour_distance); ?>" class="widefat">
        </p>

        <p>
            <label for="tour_difficulty"><?php esc_html_e('Difficulty Level', 'bike-theme'); ?></label>
            <select id="tour_difficulty" name="tour_difficulty" class="widefat">
                <option value="easy" <?php selected($tour_difficulty, 'easy'); ?>><?php esc_html_e('Easy', 'bike-theme'); ?></option>
                <option value="moderate" <?php selected($tour_difficulty, 'moderate'); ?>><?php esc_html_e('Moderate', 'bike-theme'); ?></option>
                <option value="difficult" <?php selected($tour_difficulty, 'difficult'); ?>><?php esc_html_e('Difficult', 'bike-theme'); ?></option>
            </select>
        </p>
        <p>
            <label for="tour_max_participants"><?php esc_html_e('Maximum Participants', 'bike-theme'); ?></label>
            <input type="number" id="tour_max_participants" name="tour_max_participants" value="<?php echo esc_attr($tour_max_participants); ?>" class="widefat">
        </p>
        <p>
            <label for="tour_start_location"><?php esc_html_e('Start Location', 'bike-theme'); ?></label>
            <input type="text" id="tour_start_location" name="tour_start_location" value="<?php echo esc_attr($tour_start_location); ?>" class="widefat">
        </p>
        <p>
            <label for="tour_end_location"><?php esc_html_e('End Location', 'bike-theme'); ?></label>
            <input type="text" id="tour_end_location" name="tour_end_location" value="<?php echo esc_attr($tour_end_location); ?>" class="widefat">
        </p>
        
        <!-- Itinerary Section -->
        <div class="tour-itinerary-section">
            <h3><?php esc_html_e('Tour Itinerary', 'bike-theme'); ?></h3>
            
            <div id="itinerary-days-container">
                <?php
                if (!empty($tour_itinerary_data)) {
                    foreach ($tour_itinerary_data as $day_index => $day) {
                        ?>
                        <div class="itinerary-day" data-day="<?php echo esc_attr($day_index); ?>">
                            <div class="day-header">
                                <h4 class="day-title-header"><?php echo !empty($day['title']) ? esc_html($day['title']) : sprintf(esc_html__('Day %d', 'bike-theme'), $day_index + 1); ?></h4>
                                <button type="button" class="button remove-day"><?php esc_html_e('Remove Day', 'bike-theme'); ?></button>
                            </div>
                            
                            <div class="day-content">
                                <p>
                                    <label><?php esc_html_e('Day Title', 'bike-theme'); ?></label>
                                    <input type="text" name="tour_itinerary[<?php echo $day_index; ?>][title]" 
                                           value="<?php echo esc_attr($day['title']); ?>" class="widefat day-title-input" 
                                           placeholder="<?php printf(esc_attr__('Day %d', 'bike-theme'), $day_index + 1); ?>">
                                </p>
                                
                                <p>
                                    <label><?php esc_html_e('Description', 'bike-theme'); ?></label>
                                    <?php
                                    wp_editor(
                                        wpautop($day['description']),
                                        'tour_itinerary_' . $day_index . '_description',
                                        array(
                                                                                                                                                                                                        'textarea_name' => 'tour_itinerary[' . $day_index . '][description]',
                                                                                                                                                                                                        'media_buttons' => true,
                                                                                                                                                                                                        'textarea_rows' => 5,
                                                                                                                                                                                                        'editor_class' => 'widefat',
                                                                                                                                                                                                        'teeny' => true,
                                                                                                                                                                                                        'wpautop' => false
                                                                                                                                                                                                    )
                                    );
                        ?>
                                </p>

                                <!-- Timeline Items -->
                                <div class="timeline-items-section">
                                    <h4><?php esc_html_e('Timeline Items', 'bike-theme'); ?></h4>
                                    <div class="timeline-items-container" data-day="<?php echo esc_attr($day_index); ?>">
                                        <?php
                            if (!empty($day['timeline_items']) && is_array($day['timeline_items'])) {
                                foreach ($day['timeline_items'] as $item_index => $item) {
                                    ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-item-header">
                                                        <h5><?php esc_html_e('Timeline Item', 'bike-theme'); ?> #<?php echo($item_index + 1); ?></h5>
                                                        <button type="button" class="button remove-timeline-item"><?php esc_html_e('Remove Item', 'bike-theme'); ?></button>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        <p>
                                                            <label><?php esc_html_e('Time/Title', 'bike-theme'); ?></label>
                                                            <input type="text" name="tour_itinerary[<?php echo $day_index; ?>][timeline_items][<?php echo $item_index; ?>][title]" 
                                                                   value="<?php echo esc_attr($item['title']); ?>" class="widefat">
                                                        </p>
                                                        <p>
                                                            <label><?php esc_html_e('Content', 'bike-theme'); ?></label>
                                                            <?php
                                                wp_editor(
                                                    wpautop($item['content']),
                                                    'tour_itinerary_' . $day_index . '_timeline_' . $item_index,
                                                    array(
                                                                                                                                                                                                                    'textarea_name' => "tour_itinerary[{$day_index}][timeline_items][{$item_index}][content]",
                                                                                                                                                                                                                    'media_buttons' => true,
                                                                                                                                                                                                                    'textarea_rows' => 4,
                                                                                                                                                                                                                    'teeny' => true,
                                                                                                                                                                                                                    'wpautop' => false
                                                                                                                                                                                                                )
                                                );
                                    ?>
                                                        </p>
                                                        <p>
                                                            <label><?php esc_html_e('Icon', 'bike-theme'); ?></label>
                                                            <select name="tour_itinerary[<?php echo $day_index; ?>][timeline_items][<?php echo $item_index; ?>][icon]" class="widefat">
                                                                <option value="bicycle" <?php selected($item['icon'], 'bicycle'); ?>><?php esc_html_e('Bicycle', 'bike-theme'); ?></option>
                                                                <option value="car" <?php selected($item['icon'], 'car'); ?>><?php esc_html_e('Car', 'bike-theme'); ?></option>
                                                                <option value="hotel" <?php selected($item['icon'], 'hotel'); ?>><?php esc_html_e('Hotel', 'bike-theme'); ?></option>
                                                                <option value="utensils" <?php selected($item['icon'], 'utensils'); ?>><?php esc_html_e('Restaurant', 'bike-theme'); ?></option>
                                                                <option value="camera" <?php selected($item['icon'], 'camera'); ?>><?php esc_html_e('Sightseeing', 'bike-theme'); ?></option>
                                                            </select>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php
                                }
                            }
                        ?>
                                    </div>
                                    <button type="button" class="button add-timeline-item" data-day="<?php echo esc_attr($day_index); ?>">
                                        <?php esc_html_e('Add Timeline Item', 'bike-theme'); ?>
                                    </button>
                                </div>
                                
                                <div class="day-details">
                                    <div class="detail-column">
                                        <h5><?php esc_html_e('Accommodation', 'bike-theme'); ?></h5>
                                        <input type="text" name="tour_itinerary[<?php echo $day_index; ?>][accommodation]" 
                                               value="<?php echo esc_attr($day['accommodation']); ?>" class="widefat">
                                    </div>
                                    
                                    <div class="detail-column">
                                        <h5><?php esc_html_e('Meals', 'bike-theme'); ?></h5>
                                        <div class="meals-checkboxes">
                                            <?php
                            $meals = array('breakfast', 'lunch', 'dinner');
                        foreach ($meals as $meal) {
                            $checked = isset($day['meals'][$meal]) ? $day['meals'][$meal] : false;
                            ?>
                                                <label>
                                                    <input type="checkbox" 
                                                           name="tour_itinerary[<?php echo $day_index; ?>][meals][<?php echo $meal; ?>]" 
                                                           value="1" 
                                                           <?php checked($checked, true); ?>>
                                                    <?php echo esc_html(ucfirst($meal)); ?>
                                                </label>
                                                <?php
                        }
                        ?>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-column">
                                        <h5><?php esc_html_e('Distance', 'bike-theme'); ?></h5>
                                        <input type="number" name="tour_itinerary[<?php echo $day_index; ?>][distance]" 
                                               value="<?php echo esc_attr($day['distance']); ?>" class="widefat" step="0.1">
                                        <span class="unit">km</span>
                                    </div>
                                </div>
                                
                                <!-- Additional Details -->
                                <div class="additional-details">
                                    <h5><?php esc_html_e('Additional Details', 'bike-theme'); ?></h5>
                                    <div class="details-container" data-day="<?php echo esc_attr($day_index); ?>">
                                        <?php
                                        if (!empty($day['additional_details'])) {
                                            foreach ($day['additional_details'] as $detail_index => $detail) {
                                                ?>
                                                <div class="detail-item">
                                                    <input type="text" 
                                                           name="tour_itinerary[<?php echo $day_index; ?>][additional_details][<?php echo $detail_index; ?>]" 
                                                           value="<?php echo esc_attr($detail); ?>" 
                                                           class="widefat">
                                                    <button type="button" class="button remove-detail"><?php esc_html_e('Remove', 'bike-theme'); ?></button>
                                                </div>
                                                <?php
                                            }
                                        }
                        ?>
                                    </div>
                                    <button type="button" class="button add-detail" data-day="<?php echo esc_attr($day_index); ?>">
                                        <?php esc_html_e('Add Detail', 'bike-theme'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
    ?>
            </div>
            
            <p>
                <button type="button" class="button button-primary" id="add-itinerary-day">
                    <?php esc_html_e('Add New Day', 'bike-theme'); ?>
                </button>
            </p>
        </div>

        <style>
            .tour-itinerary-section {
                margin: 20px 0;
            }
            .itinerary-day {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 20px;
                padding: 15px;
            }
            .day-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }
            .day-header h4 {
                margin: 0;
            }
            .day-content {
                padding: 10px;
            }
            .day-details {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
                margin: 15px 0;
            }
            .detail-column {
                background: #f9f9f9;
                padding: 10px;
                border-radius: 4px;
            }
            .detail-column h5 {
                margin: 0 0 10px 0;
            }
            .meals-checkboxes {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
            .additional-details {
                margin-top: 20px;
            }
            .detail-item {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
            }
            .detail-item input {
                flex: 1;
            }
            .unit {
                margin-left: 5px;
                color: #666;
            }
            .timeline-items-section {
                margin: 20px 0;
                padding: 15px;
                background: #f8f8f8;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .timeline-item {
                background: #fff;
                border: 1px solid #e5e5e5;
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 4px;
            }
            .timeline-item-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }
            .timeline-item-header h5 {
                margin: 0;
            }
            .timeline-item-content {
                padding: 10px;
            }
            .timeline-items-container {
                margin-bottom: 15px;
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            // Add new day
            $('#add-itinerary-day').on('click', function() {
                var dayCount = $('.itinerary-day').length;
                var template = `
                    <div class="itinerary-day" data-day="${dayCount}">
                        <div class="day-header">
                            <h4 class="day-title-header"><?php esc_html_e('Day', 'bike-theme'); ?> ${dayCount + 1}</h4>
                            <button type="button" class="button remove-day"><?php esc_html_e('Remove Day', 'bike-theme'); ?></button>
                        </div>
                        
                        <div class="day-content">
                            <p>
                                <label><?php esc_html_e('Day Title', 'bike-theme'); ?></label>
                                <input type="text" name="tour_itinerary[${dayCount}][title]" class="widefat day-title-input" placeholder="<?php esc_html_e('Day', 'bike-theme'); ?> ${dayCount + 1}">
                            </p>
                            
                            <p>
                                <label><?php esc_html_e('Description', 'bike-theme'); ?></label>
                                <textarea name="tour_itinerary[${dayCount}][description]" class="widefat" rows="4"></textarea>
                            </p>
                            
                            <div class="day-details">
                                <div class="detail-column">
                                    <h5><?php esc_html_e('Accommodation', 'bike-theme'); ?></h5>
                                    <input type="text" name="tour_itinerary[${dayCount}][accommodation]" class="widefat">
                                </div>
                                
                                <div class="detail-column">
                                    <h5><?php esc_html_e('Meals', 'bike-theme'); ?></h5>
                                    <div class="meals-checkboxes">
                                        <?php
                            $meals = array('breakfast', 'lunch', 'dinner');
    foreach ($meals as $meal) {
        ?>
                                            <label>
                                                <input type="checkbox" name="tour_itinerary[${dayCount}][meals][<?php echo $meal; ?>]" value="1">
                                                <?php echo esc_html(ucfirst($meal)); ?>
                                            </label>
                                            <?php
    }
    ?>
                                    </div>
                                </div>
                                
                                <div class="detail-column">
                                    <h5><?php esc_html_e('Distance', 'bike-theme'); ?></h5>
                                    <input type="number" name="tour_itinerary[${dayCount}][distance]" class="widefat" step="0.1">
                                    <span class="unit">km</span>
                                </div>
                            </div>
                            
                            <div class="additional-details">
                                <h5><?php esc_html_e('Additional Details', 'bike-theme'); ?></h5>
                                <div class="details-container" data-day="${dayCount}"></div>
                                <button type="button" class="button add-detail" data-day="${dayCount}">
                                    <?php esc_html_e('Add Detail', 'bike-theme'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#itinerary-days-container').append(template);
                
                // Focus on the title input for the new day
                $('#itinerary-days-container .itinerary-day:last .day-title-input').focus();
            });

            // Remove day
            $(document).on('click', '.remove-day', function() {
                if (confirm('<?php esc_html_e('Are you sure you want to remove this day?', 'bike-theme'); ?>')) {
                    $(this).closest('.itinerary-day').remove();
                    reindexDays();
                }
            });

            // Add detail
            $(document).on('click', '.add-detail', function() {
                var day = $(this).data('day');
                var detailsContainer = $(this).siblings('.details-container');
                var detailCount = detailsContainer.children().length;
                
                var template = `
                    <div class="detail-item">
                        <input type="text" name="tour_itinerary[${day}][additional_details][${detailCount}]" class="widefat">
                        <button type="button" class="button remove-detail"><?php esc_html_e('Remove', 'bike-theme'); ?></button>
                    </div>
                `;
                
                detailsContainer.append(template);
            });

            // Remove detail
            $(document).on('click', '.remove-detail', function() {
                $(this).closest('.detail-item').remove();
            });

            // Update day title header when input changes
            $(document).on('input', '.day-title-input', function() {
                var title = $(this).val();
                var dayContainer = $(this).closest('.itinerary-day');
                var dayIndex = dayContainer.attr('data-day');
                var header = dayContainer.find('.day-title-header');
                
                if (title.trim() !== '') {
                    header.text(title);
                } else {
                    header.text('<?php esc_html_e('Day', 'bike-theme'); ?> ' + (parseInt(dayIndex) + 1));
                }
            });

            // Reindex days after removal
            function reindexDays() {
                $('.itinerary-day').each(function(index) {
                    var day = $(this);
                    day.attr('data-day', index);
                    
                    // Update header if no custom title
                    var titleInput = day.find('.day-title-input');
                    var header = day.find('.day-title-header');
                    if (titleInput.val().trim() === '') {
                        header.text('<?php esc_html_e('Day', 'bike-theme'); ?> ' + (index + 1));
                        titleInput.attr('placeholder', '<?php esc_html_e('Day', 'bike-theme'); ?> ' + (index + 1));
                    }
                    
                    // Update all input names
                    day.find('input, textarea').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            name = name.replace(/tour_itinerary\[\d+\]/, 'tour_itinerary[' + index + ']');
                            $(this).attr('name', name);
                        }
                    });
                });
            }

            // Add new timeline item
            $(document).on('click', '.add-timeline-item', function() {
                var dayIndex = $(this).data('day');
                var container = $(this).siblings('.timeline-items-container');
                var itemCount = container.children('.timeline-item').length;
                
                var template = `
                    <div class="timeline-item">
                        <div class="timeline-item-header">
                            <h5><?php esc_html_e('Timeline Item', 'bike-theme'); ?> #${itemCount + 1}</h5>
                            <button type="button" class="button remove-timeline-item"><?php esc_html_e('Remove Item', 'bike-theme'); ?></button>
                        </div>
                        <div class="timeline-item-content">
                            <p>
                                <label><?php esc_html_e('Time/Title', 'bike-theme'); ?></label>
                                <input type="text" name="tour_itinerary[${dayIndex}][timeline_items][${itemCount}][title]" class="widefat">
                            </p>
                            <p>
                                <label><?php esc_html_e('Content', 'bike-theme'); ?></label>
                                <textarea name="tour_itinerary[${dayIndex}][timeline_items][${itemCount}][content]" class="widefat" rows="4"></textarea>
                            </p>
                            <p>
                                <label><?php esc_html_e('Icon', 'bike-theme'); ?></label>
                                <select name="tour_itinerary[${dayIndex}][timeline_items][${itemCount}][icon]" class="widefat">
                                    <option value="bicycle"><?php esc_html_e('Bicycle', 'bike-theme'); ?></option>
                                    <option value="car"><?php esc_html_e('Car', 'bike-theme'); ?></option>
                                    <option value="hotel"><?php esc_html_e('Hotel', 'bike-theme'); ?></option>
                                    <option value="utensils"><?php esc_html_e('Restaurant', 'bike-theme'); ?></option>
                                    <option value="camera"><?php esc_html_e('Sightseeing', 'bike-theme'); ?></option>
                                </select>
                            </p>
                        </div>
                    </div>
                `;
                
                container.append(template);
            });

            // Remove timeline item
            $(document).on('click', '.remove-timeline-item', function() {
                if (confirm('<?php esc_html_e('Are you sure you want to remove this timeline item?', 'bike-theme'); ?>')) {
                    $(this).closest('.timeline-item').remove();
                    reindexTimelineItems();
                }
            });

            // Reindex timeline items
            function reindexTimelineItems() {
                $('.timeline-items-container').each(function() {
                    var dayIndex = $(this).data('day');
                    $(this).find('.timeline-item').each(function(itemIndex) {
                        $(this).find('input, textarea, select').each(function() {
                            var name = $(this).attr('name');
                            if (name) {
                                name = name.replace(/\[\d+\]\[timeline_items\]\[\d+\]/, '[' + dayIndex + '][timeline_items][' + itemIndex + ']');
                                $(this).attr('name', name);
                            }
                        });
                        $(this).find('h5').text('<?php esc_html_e('Timeline Item', 'bike-theme'); ?> #' + (itemIndex + 1));
                    });
                });
            }
        });
        </script>

        <h3><?php esc_html_e('Services', 'bike-theme'); ?></h3>
        <p>
            <label for="tour_included"><?php esc_html_e('What\'s Included', 'bike-theme'); ?></label>
            <?php
            wp_editor(wpautop($tour_included), 'tour_included', array(
                'textarea_name' => 'tour_included',
                'media_buttons' => true,
                'textarea_rows' => 5,
                'editor_class' => 'widefat',
                'teeny' => true,
                'wpautop' => false
            ));
    ?>
        </p>
        <p>
            <label for="tour_not_included"><?php esc_html_e('What\'s Not Included', 'bike-theme'); ?></label>
            <?php
    wp_editor(wpautop($tour_not_included), 'tour_not_included', array(
        'textarea_name' => 'tour_not_included',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true,
        'wpautop' => false
    ));
    ?>
        </p>
        
        <h3><?php esc_html_e('Booking & Cancellation', 'bike-theme'); ?></h3>
        <p>
            <label for="tour_booking_terms"><?php esc_html_e('Booking Terms', 'bike-theme'); ?></label>
            <?php
    wp_editor($tour_booking_terms, 'tour_booking_terms', array(
        'textarea_name' => 'tour_booking_terms',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true
    ));
    ?>
        </p>
        <p>
            <label for="tour_cancellation_policy"><?php esc_html_e('Cancellation Policy', 'bike-theme'); ?></label>
            <?php
    wp_editor(wpautop($tour_cancellation_policy), 'tour_cancellation_policy', array(
        'textarea_name' => 'tour_cancellation_policy',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true,
        'wpautop' => false
    ));
    ?>
        </p>
        
        <h3><?php esc_html_e('Contact Information', 'bike-theme'); ?></h3>
        <p>
            <label for="tour_contact_info"><?php esc_html_e('Contact Information for Booking', 'bike-theme'); ?></label>
            <?php
    wp_editor(wpautop($tour_contact_info), 'tour_contact_info', array(
        'textarea_name' => 'tour_contact_info',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true,
        'wpautop' => false
    ));
    ?>
        </p>

        <h3><?php esc_html_e('Price Information', 'bike-theme'); ?></h3>
        <p>
            <label for="tour_price_info"><?php esc_html_e('Price Information', 'bike-theme'); ?></label>
            <?php
    wp_editor(wpautop($tour_price_info), 'tour_price_info', array(
        'textarea_name' => 'tour_price_info',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true,
        'wpautop' => false
    ));
    ?>
        </p>

        <h3><?php esc_html_e('Add-ons', 'bike-theme'); ?></h3>
        <p>
            <label for="tour_add_ons"><?php esc_html_e('Tour Add-ons Information', 'bike-theme'); ?></label>
            <?php
    wp_editor(wpautop($tour_add_ons), 'tour_add_ons', array(
        'textarea_name' => 'tour_add_ons',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true,
        'wpautop' => false
    ));
    ?>
        </p>

        <h3><?php esc_html_e('Reviews', 'bike-theme'); ?></h3>
        <div class="tour-review-container">
            <input type="hidden" id="tour_review" name="tour_review" value="<?php echo esc_attr(implode(',', (array)get_post_meta($post->ID, '_tour_review', true))); ?>">
            <div id="tour_review_preview" class="tour-review-preview">
                <?php
        $review_ids = get_post_meta($post->ID, '_tour_review', true);
    if (!empty($review_ids) && is_array($review_ids)) {
        foreach ($review_ids as $image_id) {
            if ($image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                if ($image_url) {
                    echo '<div class="review-image-item" data-id="' . esc_attr($image_id) . '">';
                    echo '<img src="' . esc_url($image_url) . '" alt="">';
                    echo '<button type="button" class="remove-review-image dashicons dashicons-no-alt"></button>';
                    echo '</div>';
                }
            }
        }
    }
    ?>
            </div>
            <p>
                <button type="button" class="button add-review-images"><?php esc_html_e('Add Reviews', 'bike-theme'); ?></button>
            </p>
        </div>
        <style>
            .tour-review-preview {
                display: flex;
                flex-wrap: wrap;
                margin: 10px 0;
                gap: 10px;
            }
            .review-image-item {
                position: relative;
                width: 100px;
                height: 100px;
                border: 1px solid #ddd;
                border-radius: 4px;
                overflow: hidden;
            }
            .review-image-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .remove-review-image {
                position: absolute;
                top: 0;
                right: 0;
                background: rgba(0,0,0,0.5);
                color: #fff;
                border: none;
                cursor: pointer;
                padding: 2px;
                line-height: 1;
            }
            .remove-review-image:hover {
                background: rgba(0,0,0,0.8);
            }
        </style>
        
        <script>
            jQuery(document).ready(function($) {
                // Review image management
                var review_frame;
                
                $('.add-review-images').on('click', function(e) {
                    e.preventDefault();
                    
                    // If the frame already exists, open it
                    if (review_frame) {
                        review_frame.open();
                        return;
                    }
                    
                    // Create the media frame
                    review_frame = wp.media({
                        title: '<?php esc_html_e('Select or Upload Bike Reviews', 'bike-theme'); ?>',
                        button: {
                            text: '<?php esc_html_e('Add to Reviews', 'bike-theme'); ?>'
                        },
                        multiple: true
                    });
                    
                    // When an image is selected, run a callback
                    review_frame.on('select', function() {
                        var selection = review_frame.state().get('selection');
                        var ids = [];
                        var currentIds = $('#tour_review').val() ? $('#tour_review').val().split(',') : [];
                        
                        // Add existing IDs to the array
                        if (currentIds.length > 0) {
                            for (var i = 0; i < currentIds.length; i++) {
                                if (currentIds[i]) {
                                    ids.push(currentIds[i]);
                                }
                            }
                        }
                        
                        // Add new IDs to the array
                        selection.forEach(function(attachment) {
                            var attachmentId = attachment.id;
                            if (ids.indexOf(attachmentId.toString()) === -1) {
                                ids.push(attachmentId);
                                
                                // Add image preview
                                var image = attachment.attributes.sizes.thumbnail ? attachment.attributes.sizes.thumbnail.url : attachment.attributes.url;
                                $('#tour_review_preview').append(
                                    '<div class="review-image-item" data-id="' + attachmentId + '">' +
                                    '<img src="' + image + '" alt="">' +
                                    '<button type="button" class="remove-review-image dashicons dashicons-no-alt"></button>' +
                                    '</div>'
                                );
                            }
                        });
                        
                        // Update the input value
                        $('#tour_review').val(ids.join(','));
                    });
                    
                    // Open the frame
                    review_frame.open();
                });
                
                // Remove review image
                $(document).on('click', '.remove-review-image', function() {
                    var imageItem = $(this).closest('.review-image-item');
                    var imageId = imageItem.data('id');
                    var currentIds = $('#tour_review').val().split(',');
                    var newIds = [];
                    
                    // Filter out the removed ID
                    for (var i = 0; i < currentIds.length; i++) {
                        if (currentIds[i] != imageId) {
                            newIds.push(currentIds[i]);
                        }
                    }
                    
                    // Update the input value
                    $('#tour_review').val(newIds.join(','));
                    
                    // Remove the image preview
                    imageItem.remove();
                });
            });
        </script>

        <h3><?php esc_html_e('Review Information', 'bike-theme'); ?></h3>
        <p>
            <label for="tour_review_info"><?php esc_html_e('Review Information', 'bike-theme'); ?></label>
            <?php
            wp_editor(wpautop($tour_review_info), 'tour_review_info', array(
    'textarea_name' => 'tour_review_info',
    'media_buttons' => true,
    'textarea_rows' => 5,
    'editor_class' => 'widefat',
    'teeny' => true,
    'wpautop' => false
            ));
    ?>
        </p>

        <h3><?php esc_html_e('Media Gallery', 'bike-theme'); ?></h3>
        <div class="tour-gallery-container">
            <input type="hidden" id="tour_gallery" name="tour_gallery" value="<?php echo esc_attr(implode(',', (array)get_post_meta($post->ID, '_tour_gallery', true))); ?>">
            <div id="tour_gallery_preview" class="tour-gallery-preview">
                <?php
        $gallery_ids = get_post_meta($post->ID, '_tour_gallery', true);
    if (!empty($gallery_ids) && is_array($gallery_ids)) {
        foreach ($gallery_ids as $image_id) {
            if ($image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                if ($image_url) {
                    echo '<div class="gallery-image-item" data-id="' . esc_attr($image_id) . '">';
                    echo '<img src="' . esc_url($image_url) . '" alt="">';
                    echo '<button type="button" class="remove-gallery-image dashicons dashicons-no-alt"></button>';
                    echo '</div>';
                }
            }
        }
    }
    ?>
            </div>
            <p>
                <button type="button" class="button add-gallery-images"><?php esc_html_e('Add Gallery Images', 'bike-theme'); ?></button>
            </p>
        </div>
        
        <p>
            <label for="tour_video_url"><?php esc_html_e('Video URL (YouTube or Vimeo)', 'bike-theme'); ?></label>
            <input type="url" id="tour_video_url" name="tour_video_url" value="<?php echo esc_attr(get_post_meta($post->ID, '_tour_video_url', true)); ?>" class="widefat" placeholder="https://www.youtube.com/watch?v=...">
        </p>

        <h3><?php esc_html_e('Tour Additions', 'bike-theme'); ?></h3>
        <div class="tour-additions-section">
            <?php
            $additions = get_post_meta($post->ID, '_tour_additions', true);
    if (!is_array($additions)) {
        $additions = array();
    }
    ?>
            <div class="additions-container">
                <div class="additions-header">
                    <div class="addition-cell"><?php esc_html_e('Name', 'bike-theme'); ?></div>
                    <div class="addition-cell"><?php esc_html_e('Description', 'bike-theme'); ?></div>
                    <div class="addition-cell"><?php esc_html_e('Price', 'bike-theme'); ?></div>
                    <div class="addition-cell"><?php esc_html_e('Per Person', 'bike-theme'); ?></div>
                    <div class="addition-cell"></div>
                </div>
                <div id="additions-rows">
                    <?php
            if (!empty($additions)) {
                foreach ($additions as $key => $addition) {
                    ?>
                            <div class="addition-row">
                                <div class="addition-cell">
                                    <input type="text" name="tour_additions[<?php echo $key; ?>][name]" 
                                           value="<?php echo esc_attr($addition['name']); ?>" 
                                           class="widefat" placeholder="<?php esc_attr_e('e.g. Bike Rental', 'bike-theme'); ?>">
                                </div>
                                <div class="addition-cell">
                                    <input type="text" name="tour_additions[<?php echo $key; ?>][description]" 
                                           value="<?php echo esc_attr($addition['description']); ?>" 
                                           class="widefat" placeholder="<?php esc_attr_e('e.g. High-quality mountain bike', 'bike-theme'); ?>">
                                </div>
                                <div class="addition-cell">
                                    <input type="number" name="tour_additions[<?php echo $key; ?>][price]" 
                                           value="<?php echo esc_attr($addition['price']); ?>" 
                                           class="widefat" min="0" step="0.01" placeholder="0.00">
                                </div>
                                <div class="addition-cell">
                                    <input type="checkbox" name="tour_additions[<?php echo $key; ?>][per_person]" 
                                           value="1" <?php checked(isset($addition['per_person']) && $addition['per_person'], true); ?>>
                                </div>
                                <div class="addition-cell">
                                    <button type="button" class="button remove-addition"><?php esc_html_e('Remove', 'bike-theme'); ?></button>
                                </div>
                            </div>
                            <?php
                }
            }
    ?>
                </div>
                <div class="addition-row">
                    <div class="addition-cell">
                        <button type="button" class="button button-secondary add-addition"><?php esc_html_e('Add Extra Service', 'bike-theme'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .flexible-pricing-container {
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 20px;
                background: #f9f9f9;
                border-radius: 4px;
            }
            .flexible-pricing-row {
                display: flex;
                margin-bottom: 10px;
                align-items: center;
            }
            .flexible-pricing-header {
                display: flex;
                width: 100%;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .flexible-pricing-cell {
                flex: 1;
                padding: 0 10px;
            }
            .flexible-pricing-cell:last-child {
                flex: 0.5;
            }
            .flexible-pricing-cell input {
                width: 100%;
            }
            .tour-gallery-preview {
                display: flex;
                flex-wrap: wrap;
                margin: 10px 0;
                gap: 10px;
            }
            .gallery-image-item {
                position: relative;
                width: 100px;
                height: 100px;
                border: 1px solid #ddd;
                border-radius: 4px;
                overflow: hidden;
            }
            .gallery-image-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .remove-gallery-image {
                position: absolute;
                top: 0;
                right: 0;
                background: rgba(0,0,0,0.5);
                color: #fff;
                border: none;
                cursor: pointer;
                padding: 2px;
                line-height: 1;
            }
            .remove-gallery-image:hover {
                background: rgba(0,0,0,0.8);
            }
            .tour-additions-section {
                border: 1px solid #ddd;
                padding: 15px;
                margin: 15px 0;
                background: #f9f9f9;
                border-radius: 4px;
            }
            .additions-container {
                margin-top: 10px;
            }
            .additions-header {
                display: flex;
                background: #f1f1f1;
                padding: 8px;
                font-weight: bold;
                border-radius: 4px 4px 0 0;
            }
            .addition-row {
                display: flex;
                align-items: center;
                padding: 8px;
                border-bottom: 1px solid #eee;
            }
            .addition-row:last-child {
                border-bottom: none;
            }
            .addition-cell {
                padding: 0 8px;
            }
            .addition-cell:nth-child(1) { /* Name */
                flex: 2;
            }
            .addition-cell:nth-child(2) { /* Description */
                flex: 3;
            }
            .addition-cell:nth-child(3) { /* Price */
                flex: 1;
            }
            .addition-cell:nth-child(4) { /* Per Person */
                flex: 0.5;
            }
            .addition-cell:nth-child(5) { /* Actions */
                flex: 0.5;
            }
            .addition-cell input[type="checkbox"] {
                margin: 0;
            }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            // Gallery image management
            var gallery_frame;
            
            $('.add-gallery-images').on('click', function(e) {
                e.preventDefault();
                
                // If the frame already exists, open it
                if (gallery_frame) {
                    gallery_frame.open();
                    return;
                }
                
                // Create the media frame
                gallery_frame = wp.media({
                    title: '<?php esc_html_e('Select or Upload Tour Gallery Images', 'bike-theme'); ?>',
                    button: {
                        text: '<?php esc_html_e('Add to Gallery', 'bike-theme'); ?>'
                    },
                    multiple: true
                });
                
                // When an image is selected, run a callback
                gallery_frame.on('select', function() {
                    var selection = gallery_frame.state().get('selection');
                    var ids = [];
                    var currentIds = $('#tour_gallery').val() ? $('#tour_gallery').val().split(',') : [];
                    
                    // Add existing IDs to the array
                    if (currentIds.length > 0) {
                        for (var i = 0; i < currentIds.length; i++) {
                            if (currentIds[i]) {
                                ids.push(currentIds[i]);
                            }
                        }
                    }
                    
                    // Add new IDs to the array
                    selection.forEach(function(attachment) {
                        var attachmentId = attachment.id;
                        if (ids.indexOf(attachmentId.toString()) === -1) {
                            ids.push(attachmentId);
                            
                            // Add image preview
                            var image = attachment.attributes.sizes.thumbnail ? attachment.attributes.sizes.thumbnail.url : attachment.attributes.url;
                            $('#tour_gallery_preview').append(
                                '<div class="gallery-image-item" data-id="' + attachmentId + '">' +
                                '<img src="' + image + '" alt="">' +
                                '<button type="button" class="remove-gallery-image dashicons dashicons-no-alt"></button>' +
                                '</div>'
                            );
                        }
                    });
                    
                    // Update the input value
                    $('#tour_gallery').val(ids.join(','));
                });
                
                // Open the frame
                gallery_frame.open();
            });
            
            // Remove gallery image
            $(document).on('click', '.remove-gallery-image', function() {
                var imageItem = $(this).closest('.gallery-image-item');
                var imageId = imageItem.data('id');
                var currentIds = $('#tour_gallery').val().split(',');
                var newIds = [];
                
                // Filter out the removed ID
                for (var i = 0; i < currentIds.length; i++) {
                    if (currentIds[i] != imageId) {
                        newIds.push(currentIds[i]);
                    }
                }
                
                // Update the input value
                $('#tour_gallery').val(newIds.join(','));
                
                // Remove the image preview
                imageItem.remove();
            });

            // Add new addition row
            $('.add-addition').click(function() {
                var rowCount = $('#additions-rows .addition-row').length;
                var newRow = '<div class="addition-row">' +
                    '<div class="addition-cell">' +
                    '<input type="text" name="tour_additions[' + rowCount + '][name]" class="widefat" placeholder="<?php esc_attr_e('e.g. Bike Rental', 'bike-theme'); ?>">' +
                    '</div>' +
                    '<div class="addition-cell">' +
                    '<input type="text" name="tour_additions[' + rowCount + '][description]" class="widefat" placeholder="<?php esc_attr_e('e.g. High-quality mountain bike', 'bike-theme'); ?>">' +
                    '</div>' +
                    '<div class="addition-cell">' +
                    '<input type="number" name="tour_additions[' + rowCount + '][price]" class="widefat" min="0" step="0.01" placeholder="0.00">' +
                    '</div>' +
                    '<div class="addition-cell">' +
                    '<input type="checkbox" name="tour_additions[' + rowCount + '][per_person]" value="1">' +
                    '</div>' +
                    '<div class="addition-cell">' +
                    '<button type="button" class="button remove-addition"><?php esc_html_e('Remove', 'bike-theme'); ?></button>' +
                    '</div>' +
                    '</div>';
                $('#additions-rows').append(newRow);
            });
            
            // Remove addition row
            $(document).on('click', '.remove-addition', function() {
                $(this).closest('.addition-row').remove();
                reindexAdditions();
            });
            
            function reindexAdditions() {
                $('#additions-rows .addition-row').each(function(index) {
                    $(this).find('input').each(function() {
                        var name = $(this).attr('name');
                        name = name.replace(/\[\d+\]/, '[' + index + ']');
                        $(this).attr('name', name);
                    });
                });
            }
        });
        </script>
    </div>
    <?php
}

/**
 * Tour pricing meta box callback
 */
function bike_theme_tour_pricing_meta_box_callback($post)
{
    wp_nonce_field('bike_theme_tour_pricing_nonce', 'bike_theme_tour_pricing_nonce');

    // Get stored values
    $tour_price = get_post_meta($post->ID, '_tour_price', true);
    $tour_enable_group_discount = get_post_meta($post->ID, '_tour_enable_group_discount', true);
    $tour_group_discount = get_post_meta($post->ID, '_tour_group_discount', true);
    $tour_flexible_pricing_enabled = get_post_meta($post->ID, '_tour_flexible_pricing_enabled', true);
    $tour_flexible_pricing = get_post_meta($post->ID, '_tour_flexible_pricing', true) ?: array();

    ?>
    <div class="bike-theme-meta-box">
        <p>
            <label for="tour_price"><?php _e('Base Price per Person', 'bike-theme'); ?></label><br>
            <input type="number" id="tour_price" name="tour_price" value="<?php echo esc_attr($tour_price); ?>" class="widefat" step="0.01">
            <span class="description"><?php _e('Enter the base price per person for this tour.', 'bike-theme'); ?></span>
        </p>

        <p>
            <label>
                <input type="checkbox" id="tour_enable_group_discount" name="tour_enable_group_discount" value="yes" <?php checked($tour_enable_group_discount, 'yes'); ?>>
                <?php _e('Enable Group Discount', 'bike-theme'); ?>
            </label>
        </p>

        <div id="group_discount_field" style="<?php echo $tour_enable_group_discount !== 'yes' ? 'display:none;' : ''; ?>">
            <p>
                <label for="tour_group_discount"><?php _e('Group Discount (%)', 'bike-theme'); ?></label><br>
                <input type="number" id="tour_group_discount" name="tour_group_discount" value="<?php echo esc_attr($tour_group_discount); ?>" class="widefat" step="0.1" min="0" max="100">
                <span class="description"><?php _e('Enter the discount percentage for groups (applied when there are 2 or more participants).', 'bike-theme'); ?></span>
            </p>
        </div>

        <p>
            <label>
                <input type="checkbox" id="tour_flexible_pricing_enabled" name="tour_flexible_pricing_enabled" value="1" <?php checked($tour_flexible_pricing_enabled, '1'); ?>>
                <?php _e('Enable Flexible Pricing Based on Group Size', 'bike-theme'); ?>
            </label>
        </p>

        <div id="flexible_pricing_container" style="<?php echo $tour_flexible_pricing_enabled !== '1' ? 'display:none;' : ''; ?>">
            <p><?php _e('Set different prices based on the number of participants:', 'bike-theme'); ?></p>
            
            <div id="flexible_pricing_fields">
                <?php
                if (!empty($tour_flexible_pricing) && is_array($tour_flexible_pricing)) {
                    foreach ($tour_flexible_pricing as $index => $pricing) {
                        ?>
                        <div class="flexible-pricing-row">
                            <p>
                                <label><?php _e('Participants:', 'bike-theme'); ?></label>
                                <input type="number" name="tour_flexible_pricing[<?php echo $index; ?>][participants]" value="<?php echo esc_attr($pricing['participants']); ?>" min="1" class="small-text">
                                <label><?php _e('Price per Person:', 'bike-theme'); ?></label>
                                <input type="number" name="tour_flexible_pricing[<?php echo $index; ?>][price]" value="<?php echo esc_attr($pricing['price']); ?>" step="0.01" class="small-text">
                                <button type="button" class="button remove-pricing-row"><?php _e('Remove', 'bike-theme'); ?></button>
                            </p>
                        </div>
                        <?php
                    }
                } else {
                    // Display an empty row if no pricing tiers exist
                    ?>
                    <div class="flexible-pricing-row">
                        <p>
                            <label><?php _e('Participants:', 'bike-theme'); ?></label>
                            <input type="number" name="tour_flexible_pricing[0][participants]" value="1" min="1" class="small-text">
                            <label><?php _e('Price per Person:', 'bike-theme'); ?></label>
                            <input type="number" name="tour_flexible_pricing[0][price]" value="" step="0.01" class="small-text">
                            <button type="button" class="button remove-pricing-row"><?php _e('Remove', 'bike-theme'); ?></button>
                        </p>
                    </div>
                    <?php
                }
    ?>
            </div>
            <p>
                <button type="button" class="button" id="add_pricing_tier"><?php _e('Add Pricing Tier', 'bike-theme'); ?></button>
            </p>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Toggle group discount field
            $('#tour_enable_group_discount').on('change', function() {
                if($(this).is(':checked')) {
                    $('#group_discount_field').show();
                } else {
                    $('#group_discount_field').hide();
                }
            });

            // Toggle flexible pricing fields
            $('#tour_flexible_pricing_enabled').on('change', function() {
                if($(this).is(':checked')) {
                    $('#flexible_pricing_container').show();
                } else {
                    $('#flexible_pricing_container').hide();
                }
            });

            // Add new pricing tier
            $('#add_pricing_tier').on('click', function() {
                var nextIndex = $('.flexible-pricing-row').length;
                var newRow = $('<div class="flexible-pricing-row"><p>' +
                    '<label><?php _e('Participants:', 'bike-theme'); ?></label> ' +
                    '<input type="number" name="tour_flexible_pricing[' + nextIndex + '][participants]" value="1" min="1" class="small-text"> ' +
                    '<label><?php _e('Price per Person:', 'bike-theme'); ?></label> ' +
                    '<input type="number" name="tour_flexible_pricing[' + nextIndex + '][price]" value="" step="0.01" class="small-text"> ' +
                    '<button type="button" class="button remove-pricing-row"><?php _e('Remove', 'bike-theme'); ?></button>' +
                    '</p></div>');
                $('#flexible_pricing_fields').append(newRow);
            });

            // Remove pricing tier
            $(document).on('click', '.remove-pricing-row', function() {
                if ($('.flexible-pricing-row').length > 1) {
                    $(this).closest('.flexible-pricing-row').remove();
                    // Reindex rows
                    $('.flexible-pricing-row').each(function(index) {
                        $(this).find('input').each(function() {
                            var name = $(this).attr('name');
                            var newName = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', newName);
                        });
                    });
                } else {
                    alert('<?php _e('You must have at least one pricing tier', 'bike-theme'); ?>');
                }
            });
        });
    </script>
    <?php
}

/**
 * Tour E-bike availability meta box callback
 */
function bike_theme_tour_ebike_callback($post)
{
    wp_nonce_field('bike_theme_tour_ebike_nonce', 'bike_theme_tour_ebike_nonce');

    // Get stored value
    $ebike_available = get_post_meta($post->ID, '_tour_ebike_available', true);

    ?>
    <p>
        <label>
            <input type="checkbox" name="tour_ebike_available" value="yes" <?php checked($ebike_available, 'yes'); ?>>
            <?php _e('E-bike available for this tour', 'bike-theme'); ?>
        </label>
    </p>
    <p class="description">
        <?php _e('Check this if E-bikes are available as an option for this tour. A badge will be displayed on the tour listing.', 'bike-theme'); ?>
    </p>
    <?php
}

/**
 * Save tour meta box data.
 *
 * @param int $post_id The post ID.
 * @return void
 */
function bike_theme_save_tour_meta_boxes_data($post_id)
{
    // Check if our nonce is set.
    if (!isset($_POST['bike_theme_tour_details_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['bike_theme_tour_details_nonce'], 'bike_theme_tour_details_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'bike_tour' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Update tour details
    if (isset($_POST['tour_duration_type'])) {
        update_post_meta($post_id, '_tour_duration_type', sanitize_text_field($_POST['tour_duration_type']));
    }

    if (isset($_POST['tour_duration_days'])) {
        update_post_meta($post_id, '_tour_duration_days', absint($_POST['tour_duration_days']));
    }

    if (isset($_POST['tour_duration_nights'])) {
        update_post_meta($post_id, '_tour_duration_nights', absint($_POST['tour_duration_nights']));
    }

    if (isset($_POST['tour_duration_hours'])) {
        update_post_meta($post_id, '_tour_duration_hours', floatval($_POST['tour_duration_hours']));
    }

    if (isset($_POST['tour_distance'])) {
        update_post_meta($post_id, '_tour_distance', sanitize_text_field($_POST['tour_distance']));
    }

    if (isset($_POST['tour_difficulty'])) {
        update_post_meta($post_id, '_tour_difficulty', sanitize_text_field($_POST['tour_difficulty']));
    }

    if (isset($_POST['tour_max_participants'])) {
        update_post_meta($post_id, '_tour_max_participants', absint($_POST['tour_max_participants']));
    }

    if (isset($_POST['tour_start_location'])) {
        update_post_meta($post_id, '_tour_start_location', sanitize_text_field($_POST['tour_start_location']));
    }

    if (isset($_POST['tour_end_location'])) {
        update_post_meta($post_id, '_tour_end_location', sanitize_text_field($_POST['tour_end_location']));
    }

    // Save itinerary data
    if (isset($_POST['tour_itinerary']) && is_array($_POST['tour_itinerary'])) {
        $itinerary_data = array();
        foreach ($_POST['tour_itinerary'] as $day_index => $day_data) {
            if (!empty($day_data['title'])) {
                $itinerary_data[$day_index] = array(
                    'title' => sanitize_text_field($day_data['title']),
                    'description' => isset($day_data['description']) ? wp_kses_post($day_data['description']) : '',
                    'accommodation' => isset($day_data['accommodation']) ? sanitize_text_field($day_data['accommodation']) : '',
                    'distance' => isset($day_data['distance']) ? sanitize_text_field($day_data['distance']) : '',
                    'meals' => isset($day_data['meals']) ? $day_data['meals'] : array(),
                );

                // Handle timeline items
                if (isset($day_data['timeline_items']) && is_array($day_data['timeline_items'])) {
                    $timeline_items = array();
                    foreach ($day_data['timeline_items'] as $item) {
                        if (!empty($item['title'])) {
                            $timeline_items[] = array(
                                'title' => sanitize_text_field($item['title']),
                                'content' => wp_kses_post($item['content']),
                                'icon' => sanitize_text_field($item['icon'])
                            );
                        }
                    }
                    $itinerary_data[$day_index]['timeline_items'] = $timeline_items;
                }

                // Handle additional details if present
                if (isset($day_data['additional_details']) && is_array($day_data['additional_details'])) {
                    $itinerary_data[$day_index]['additional_details'] = array_map('sanitize_text_field', $day_data['additional_details']);
                }
            }
        }
        update_post_meta($post_id, '_tour_itinerary_data', $itinerary_data);
    }

    // Save service details
    if (isset($_POST['tour_included'])) {
        update_post_meta($post_id, '_tour_included', wp_kses_post($_POST['tour_included']));
    }

    if (isset($_POST['tour_not_included'])) {
        update_post_meta($post_id, '_tour_not_included', wp_kses_post($_POST['tour_not_included']));
    }

    // Save booking and cancellation details
    if (isset($_POST['tour_booking_terms'])) {
        update_post_meta($post_id, '_tour_booking_terms', wp_kses_post($_POST['tour_booking_terms']));
    }

    if (isset($_POST['tour_cancellation_policy'])) {
        update_post_meta($post_id, '_tour_cancellation_policy', wp_kses_post($_POST['tour_cancellation_policy']));
    }

    if (isset($_POST['tour_contact_info'])) {
        update_post_meta($post_id, '_tour_contact_info', wp_kses_post($_POST['tour_contact_info']));
    }

    if (isset($_POST['tour_price_info'])) {
        update_post_meta($post_id, '_tour_price_info', wp_kses_post($_POST['tour_price_info']));
    }

    if (isset($_POST['tour_add_ons'])) {
        update_post_meta($post_id, '_tour_add_ons', wp_kses_post($_POST['tour_add_ons']));
    }

    if (isset($_POST['tour_review'])) {
        $review_ids = array_filter(explode(',', sanitize_text_field($_POST['tour_review'])));
        update_post_meta($post_id, '_tour_review', $review_ids);
    } else {
        delete_post_meta($post_id, '_tour_review');
    }

    if (isset($_POST['tour_review_info'])) {
        update_post_meta($post_id, '_tour_review_info', wp_kses_post($_POST['tour_review_info']));
    }


    // Save pricing data - check for nonce separately as it's from a different metabox
    if (isset($_POST['bike_theme_tour_pricing_nonce']) && wp_verify_nonce($_POST['bike_theme_tour_pricing_nonce'], 'bike_theme_tour_pricing_nonce')) {

        if (isset($_POST['tour_price'])) {
            update_post_meta($post_id, '_tour_price', (float) $_POST['tour_price']);
        }

        if (isset($_POST['tour_enable_group_discount'])) {
            update_post_meta($post_id, '_tour_enable_group_discount', $_POST['tour_enable_group_discount']);
        } else {
            update_post_meta($post_id, '_tour_enable_group_discount', 'no');
        }

        if (isset($_POST['tour_group_discount'])) {
            update_post_meta($post_id, '_tour_group_discount', (float) $_POST['tour_group_discount']);
        }

        if (isset($_POST['tour_flexible_pricing_enabled'])) {
            update_post_meta($post_id, '_tour_flexible_pricing_enabled', '1');
        } else {
            update_post_meta($post_id, '_tour_flexible_pricing_enabled', '');
        }

        if (isset($_POST['tour_flexible_pricing']) && is_array($_POST['tour_flexible_pricing'])) {
            $pricing = array();
            foreach ($_POST['tour_flexible_pricing'] as $key => $data) {
                if (!empty($data['participants']) && isset($data['price'])) {
                    $pricing[$key] = array(
                        'participants' => absint($data['participants']),
                        'price' => (float) $data['price'],
                    );
                }
            }
            update_post_meta($post_id, '_tour_flexible_pricing', $pricing);
        }
    }

    // Save gallery images
    if (isset($_POST['tour_gallery'])) {
        $gallery_ids = array_filter(explode(',', sanitize_text_field($_POST['tour_gallery'])));
        update_post_meta($post_id, '_tour_gallery', $gallery_ids);
    } else {
        delete_post_meta($post_id, '_tour_gallery');
    }

    // Save video URL
    if (isset($_POST['tour_video_url'])) {
        update_post_meta($post_id, '_tour_video_url', esc_url_raw($_POST['tour_video_url']));
    }

    // Save tour additions
    if (isset($_POST['tour_additions']) && is_array($_POST['tour_additions'])) {
        $additions = array();
        foreach ($_POST['tour_additions'] as $key => $addition) {
            if (!empty($addition['name'])) {
                $additions[] = array(
                    'name' => sanitize_text_field($addition['name']),
                    'description' => sanitize_text_field($addition['description']),
                    'price' => (float) $addition['price'],
                    'per_person' => isset($addition['per_person']) ? 1 : 0,
                );
            }
        }
        update_post_meta($post_id, '_tour_additions', $additions);
    } else {
        update_post_meta($post_id, '_tour_additions', array());
    }

    // Save E-bike availability
    if (isset($_POST['bike_theme_tour_ebike_nonce']) && wp_verify_nonce($_POST['bike_theme_tour_ebike_nonce'], 'bike_theme_tour_ebike_nonce')) {
        $ebike_available = isset($_POST['tour_ebike_available']) ? 'yes' : 'no';
        update_post_meta($post_id, '_tour_ebike_available', $ebike_available);
    }
}
add_action('save_post_bike_tour', 'bike_theme_save_tour_meta_boxes_data');
