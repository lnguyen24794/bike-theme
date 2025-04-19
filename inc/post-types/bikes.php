<?php
/**
 * Bike Custom Post Type and related functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Bike post type
 */
function bike_theme_register_bike_post_type()
{
    $labels = array(
        'name'                  => _x('Bikes', 'Post Type General Name', 'bike-theme'),
        'singular_name'         => _x('Bike', 'Post Type Singular Name', 'bike-theme'),
        'menu_name'             => __('Bikes', 'bike-theme'),
        'name_admin_bar'        => __('Bike', 'bike-theme'),
        'archives'              => __('Bike Archives', 'bike-theme'),
        'attributes'            => __('Bike Attributes', 'bike-theme'),
        'all_items'             => __('All Bikes', 'bike-theme'),
        'add_new_item'          => __('Add New Bike', 'bike-theme'),
        'add_new'               => __('Add New', 'bike-theme'),
        'new_item'              => __('New Bike', 'bike-theme'),
        'edit_item'             => __('Edit Bike', 'bike-theme'),
        'update_item'           => __('Update Bike', 'bike-theme'),
        'view_item'             => __('View Bike', 'bike-theme'),
        'view_items'            => __('View Bikes', 'bike-theme'),
        'search_items'          => __('Search Bike', 'bike-theme'),
    );
    $args = array(
        'label'                 => __('Bike', 'bike-theme'),
        'description'           => __('Bike Products', 'bike-theme'),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-sos',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('bike', $args);

    // Register Bike Category Taxonomy
    $labels = array(
        'name'                       => _x('Bike Categories', 'Taxonomy General Name', 'bike-theme'),
        'singular_name'              => _x('Bike Category', 'Taxonomy Singular Name', 'bike-theme'),
        'menu_name'                  => __('Bike Categories', 'bike-theme'),
        'all_items'                  => __('All Bike Categories', 'bike-theme'),
        'parent_item'                => __('Parent Bike Category', 'bike-theme'),
        'parent_item_colon'          => __('Parent Bike Category:', 'bike-theme'),
        'new_item_name'              => __('New Bike Category Name', 'bike-theme'),
        'add_new_item'               => __('Add New Bike Category', 'bike-theme'),
        'edit_item'                  => __('Edit Bike Category', 'bike-theme'),
        'update_item'                => __('Update Bike Category', 'bike-theme'),
        'view_item'                  => __('View Bike Category', 'bike-theme'),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy('bike_category', array( 'bike' ), $args);

    // Register Bike Brand Taxonomy
    $labels = array(
        'name'                       => _x('Bike Brands', 'Taxonomy General Name', 'bike-theme'),
        'singular_name'              => _x('Bike Brand', 'Taxonomy Singular Name', 'bike-theme'),
        'menu_name'                  => __('Bike Brands', 'bike-theme'),
        'all_items'                  => __('All Bike Brands', 'bike-theme'),
        'parent_item'                => __('Parent Bike Brand', 'bike-theme'),
        'parent_item_colon'          => __('Parent Bike Brand:', 'bike-theme'),
        'new_item_name'              => __('New Bike Brand Name', 'bike-theme'),
        'add_new_item'               => __('Add New Bike Brand', 'bike-theme'),
        'edit_item'                  => __('Edit Bike Brand', 'bike-theme'),
        'update_item'                => __('Update Bike Brand', 'bike-theme'),
        'view_item'                  => __('View Bike Brand', 'bike-theme'),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy('bike_brand', array( 'bike' ), $args);
}
add_action('init', 'bike_theme_register_bike_post_type');

/**
 * Add meta boxes for Bike post type
 */
function bike_theme_add_bike_meta_boxes()
{
    add_meta_box(
        'bike_details',
        __('Bike Details', 'bike-theme'),
        'bike_theme_bike_details_meta_box_callback',
        'bike',
        'normal',
        'high'
    );
    
    add_meta_box(
        'bike_featured',
        __('Featured Bike', 'bike-theme'),
        'bike_theme_bike_featured_callback',
        'bike',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'bike_theme_add_bike_meta_boxes');

/**
 * Bike details meta box callback
 */
function bike_theme_bike_details_meta_box_callback($post)
{
    wp_nonce_field('bike_theme_bike_details_nonce', 'bike_theme_bike_details_nonce');

    // Get stored values
    $bike_price = get_post_meta($post->ID, '_bike_price', true);
    $bike_rental_price = get_post_meta($post->ID, '_bike_rental_price', true);
    $bike_specs = get_post_meta($post->ID, '_bike_specs', true);
    $bike_features = get_post_meta($post->ID, '_bike_features', true);
    $bike_weight = get_post_meta($post->ID, '_bike_weight', true);
    $bike_frame_size = get_post_meta($post->ID, '_bike_frame_size', true);
    $bike_wheel_size = get_post_meta($post->ID, '_bike_wheel_size', true);
    $bike_colors = get_post_meta($post->ID, '_bike_colors', true);
    
    ?>
    <div class="bike-theme-meta-box">
        <p>
            <label for="bike_price"><?php _e('Sale Price', 'bike-theme'); ?></label><br>
            <input type="number" id="bike_price" name="bike_price" value="<?php echo esc_attr($bike_price); ?>" class="widefat" step="0.01">
        </p>
        
        <p>
            <label for="bike_rental_price"><?php _e('Rental Price (per day)', 'bike-theme'); ?></label><br>
            <input type="number" id="bike_rental_price" name="bike_rental_price" value="<?php echo esc_attr($bike_rental_price); ?>" class="widefat" step="0.01">
        </p>
        
        <p>
            <label for="bike_specs"><?php _e('Specifications', 'bike-theme'); ?></label><br>
            <textarea id="bike_specs" name="bike_specs" rows="5" class="widefat"><?php echo esc_textarea($bike_specs); ?></textarea>
            <span class="description"><?php _e('Enter each specification on a new line.', 'bike-theme'); ?></span>
        </p>
        
        <p>
            <label for="bike_features"><?php _e('Features', 'bike-theme'); ?></label><br>
            <textarea id="bike_features" name="bike_features" rows="5" class="widefat"><?php echo esc_textarea($bike_features); ?></textarea>
            <span class="description"><?php _e('Enter each feature on a new line.', 'bike-theme'); ?></span>
        </p>
        
        <div class="bike-specs-grid">
            <p>
                <label for="bike_weight"><?php _e('Weight (kg)', 'bike-theme'); ?></label><br>
                <input type="text" id="bike_weight" name="bike_weight" value="<?php echo esc_attr($bike_weight); ?>" class="widefat">
            </p>
            
            <p>
                <label for="bike_frame_size"><?php _e('Frame Size', 'bike-theme'); ?></label><br>
                <input type="text" id="bike_frame_size" name="bike_frame_size" value="<?php echo esc_attr($bike_frame_size); ?>" class="widefat">
            </p>
            
            <p>
                <label for="bike_wheel_size"><?php _e('Wheel Size', 'bike-theme'); ?></label><br>
                <input type="text" id="bike_wheel_size" name="bike_wheel_size" value="<?php echo esc_attr($bike_wheel_size); ?>" class="widefat">
            </p>
        </div>
        
        <p>
            <label for="bike_colors"><?php _e('Available Colors', 'bike-theme'); ?></label><br>
            <input type="text" id="bike_colors" name="bike_colors" value="<?php echo esc_attr($bike_colors); ?>" class="widefat">
            <span class="description"><?php _e('Comma separated list of colors.', 'bike-theme'); ?></span>
        </p>
    </div>
    
    <style>
        .bike-specs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .bike-theme-meta-box label {
            font-weight: 600;
        }
    </style>
    <?php
}

/**
 * Bike featured meta box callback
 */
function bike_theme_bike_featured_callback($post)
{
    wp_nonce_field('bike_theme_bike_featured_nonce', 'bike_theme_bike_featured_nonce');

    // Get stored value
    $is_featured = get_post_meta($post->ID, '_bike_featured', true);
    
    ?>
    <p>
        <label>
            <input type="checkbox" name="bike_featured" value="yes" <?php checked($is_featured, 'yes'); ?>>
            <?php _e('Mark this bike as featured', 'bike-theme'); ?>
        </label>
    </p>
    <p class="description">
        <?php _e('Featured bikes are displayed prominently on the homepage and other key locations.', 'bike-theme'); ?>
    </p>
    <?php
}

/**
 * Save bike meta boxes data
 */
function bike_theme_save_bike_meta_boxes_data($post_id)
{
    // Check if our nonces are set and verify them
    if (!isset($_POST['bike_theme_bike_details_nonce']) || 
        !isset($_POST['bike_theme_bike_featured_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['bike_theme_bike_details_nonce'], 'bike_theme_bike_details_nonce') ||
        !wp_verify_nonce($_POST['bike_theme_bike_featured_nonce'], 'bike_theme_bike_featured_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save bike details
    if (isset($_POST['bike_price'])) {
        update_post_meta($post_id, '_bike_price', sanitize_text_field($_POST['bike_price']));
    }

    if (isset($_POST['bike_rental_price'])) {
        update_post_meta($post_id, '_bike_rental_price', sanitize_text_field($_POST['bike_rental_price']));
    }

    if (isset($_POST['bike_specs'])) {
        update_post_meta($post_id, '_bike_specs', sanitize_textarea_field($_POST['bike_specs']));
    }

    if (isset($_POST['bike_features'])) {
        update_post_meta($post_id, '_bike_features', sanitize_textarea_field($_POST['bike_features']));
    }

    if (isset($_POST['bike_weight'])) {
        update_post_meta($post_id, '_bike_weight', sanitize_text_field($_POST['bike_weight']));
    }

    if (isset($_POST['bike_frame_size'])) {
        update_post_meta($post_id, '_bike_frame_size', sanitize_text_field($_POST['bike_frame_size']));
    }

    if (isset($_POST['bike_wheel_size'])) {
        update_post_meta($post_id, '_bike_wheel_size', sanitize_text_field($_POST['bike_wheel_size']));
    }

    if (isset($_POST['bike_colors'])) {
        update_post_meta($post_id, '_bike_colors', sanitize_text_field($_POST['bike_colors']));
    }

    // Save featured status
    $is_featured = isset($_POST['bike_featured']) ? 'yes' : 'no';
    update_post_meta($post_id, '_bike_featured', $is_featured);
}
add_action('save_post_bike', 'bike_theme_save_bike_meta_boxes_data');

/**
 * Get bike rental price
 */
function bike_theme_get_bike_rental_price($bike_id)
{
    $price = get_post_meta($bike_id, '_bike_rental_price', true);
    return !empty($price) ? floatval($price) : 0;
} 