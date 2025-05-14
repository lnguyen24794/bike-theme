<?php
/**
 * Destination Taxonomy for Bike Tours
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Destination Taxonomy for Bike Tours
 */
function bike_theme_register_destination_taxonomy()
{
    $labels = array(
        'name'              => _x('Destinations', 'taxonomy general name', 'bike-theme'),
        'singular_name'     => _x('Destination', 'taxonomy singular name', 'bike-theme'),
        'search_items'      => __('Search Destinations', 'bike-theme'),
        'all_items'         => __('All Destinations', 'bike-theme'),
        'parent_item'       => __('Parent Destination', 'bike-theme'),
        'parent_item_colon' => __('Parent Destination:', 'bike-theme'),
        'edit_item'         => __('Edit Destination', 'bike-theme'),
        'update_item'       => __('Update Destination', 'bike-theme'),
        'add_new_item'      => __('Add New Destination', 'bike-theme'),
        'new_item_name'     => __('New Destination Name', 'bike-theme'),
        'menu_name'         => __('Destinations', 'bike-theme'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'destination'),
        'show_in_rest'      => true,
    );

    register_taxonomy('destination', array('bike_tour'), $args);
}
add_action('init', 'bike_theme_register_destination_taxonomy');

/**
 * Add image field to destination taxonomy
 */
function bike_theme_destination_add_image_field()
{
    ?>
    <div class="form-field">
        <label for="destination_image"><?php _e('Destination Image', 'bike-theme'); ?></label>
        <input type="hidden" id="destination_image" name="destination_image" class="custom_media_url" value="">
        <div id="destination-image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary destination_tax_media_button" id="destination_tax_media_button" name="destination_tax_media_button" value="<?php _e('Add Image', 'bike-theme'); ?>" />
            <input type="button" class="button button-secondary destination_tax_media_remove" id="destination_tax_media_remove" name="destination_tax_media_remove" value="<?php _e('Remove Image', 'bike-theme'); ?>" />
        </p>
    </div>
    <?php
}
add_action('destination_add_form_fields', 'bike_theme_destination_add_image_field', 10, 2);

/**
 * Edit image field in destination taxonomy
 */
function bike_theme_destination_edit_image_field($term)
{
    $image_id = get_term_meta($term->term_id, 'destination_image', true);
    $image_url = wp_get_attachment_url($image_id);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="destination_image"><?php _e('Destination Image', 'bike-theme'); ?></label>
        </th>
        <td>
            <input type="hidden" id="destination_image" name="destination_image" class="custom_media_url" value="<?php echo esc_attr($image_id); ?>">
            <div id="destination-image-wrapper">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 50%; height: auto; margin: 10px 0;">
                <?php endif; ?>
            </div>
            <p>
                <input type="button" class="button button-secondary destination_tax_media_button" id="destination_tax_media_button" name="destination_tax_media_button" value="<?php _e('Add Image', 'bike-theme'); ?>" />
                <input type="button" class="button button-secondary destination_tax_media_remove" id="destination_tax_media_remove" name="destination_tax_media_remove" value="<?php _e('Remove Image', 'bike-theme'); ?>" />
            </p>
        </td>
    </tr>
    <?php
}
add_action('destination_edit_form_fields', 'bike_theme_destination_edit_image_field', 10, 2);

/**
 * Save destination image
 */
function bike_theme_save_destination_image($term_id)
{
    if (isset($_POST['destination_image'])) {
        update_term_meta($term_id, 'destination_image', absint($_POST['destination_image']));
    }
}
add_action('created_destination', 'bike_theme_save_destination_image', 10, 2);
add_action('edited_destination', 'bike_theme_save_destination_image', 10, 2);

/**
 * Enqueue media uploader scripts
 */
function bike_theme_destination_media_scripts()
{
    if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'destination') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('destination-media-uploader', get_template_directory_uri() . '/assets/js/destination-media.js', array('jquery'), BIKE_THEME_VERSION, true);
}
add_action('admin_enqueue_scripts', 'bike_theme_destination_media_scripts');

/**
 * Count tours by category within a destination
 *
 * @param int $destination_id The destination term ID
 * @return array Array of category counts with category term objects as keys
 */
function bike_theme_count_tours_by_category_in_destination($destination_id)
{
    $category_counts = array();

    // Get all categories
    $categories = get_terms(array(
        'taxonomy' => 'tour_category',
        'hide_empty' => false,
    ));

    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            // Query posts that belong to both the destination and this category
            $args = array(
                'post_type' => 'bike_tour',
                'post_status' => 'publish',
                'posts_per_page' => -1, // Get all posts
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'destination',
                        'field' => 'term_id',
                        'terms' => $destination_id,
                    ),
                    array(
                        'taxonomy' => 'tour_category',
                        'field' => 'term_id',
                        'terms' => $category->term_id,
                    ),
                ),
            );

            $query = new WP_Query($args);
            $count = $query->found_posts;

            if ($count > 0) {
                $category_counts[$category->term_id] = array(
                    'category' => $category,
                    'count' => $count
                );
            }
        }
    }

    return $category_counts;
}

/**
 * Display categories with counts for a destination
 *
 * @param int $destination_id The destination term ID
 * @param string $destination_slug The destination slug
 * @param bool $show_empty Whether to show categories with zero tours
 * @return string HTML output of categories with counts
 */
function bike_theme_display_destination_categories($destination_id, $destination_slug, $show_empty = false)
{
    $category_counts = bike_theme_count_tours_by_category_in_destination($destination_id);

    if (empty($category_counts)) {
        return '';
    }

    $output = '<div class="destination-categories">';
    $output .= '<ul class="list-unstyled">';

    foreach ($category_counts as $data) {
        $category = $data['category'];
        $count = $data['count'];

        $output .= '<li>';
        $output .= '<a href="/destination/'.$destination_slug.'?tour_category=' . $category->slug . '">';
        $output .= esc_html($category->name);
        $output .= ' <span class="badge bg-primary rounded-pill">' . $count . '</span>';
        $output .= '</a>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
} 

/**
 * Count tours by category within a destination
 *
 * @param int $destination_id The destination term ID
 * @return array Array of category counts with category term objects as keys
 */
function bike_theme_count_tours_by_tour_category($tour_category_id)
{
    $category_counts = array();

    // Get all categories
    $categories = get_terms(array(
        'taxonomy' => 'tour_category',
        'hide_empty' => false,
    ));

    if (!empty($categories) && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            // Query posts that belong to both the destination and this category
            $args = array(
                'post_type' => 'bike_tour',
                'post_status' => 'publish',
                'posts_per_page' => -1, // Get all posts
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'tour_category',
                        'field' => 'term_id',
                        'terms' => $tour_category_id,
                    ),
                ),
            );

            $query = new WP_Query($args);
            $count = $query->found_posts;

            if ($count > 0) {
                $category_counts[$category->term_id] = array(
                    'category' => $category,
                    'count' => $count
                );
            }
        }
    }

    return $category_counts;
}

/**
 * Display categories with counts for a destination
 *
 * @param int $destination_id The destination term ID
 * @param string $tour_category_slug The tour category slug
 * @param bool $show_empty Whether to show categories with zero tours
 * @return string HTML output of categories with counts
 */
function bike_theme_display_tour_categories($tour_category_id, $tour_category_slug, $show_empty = false)
{
    $category_counts = bike_theme_count_tours_by_tour_category($tour_category_id);

    if (empty($category_counts)) {
        return '';
    }

    $output = '<div class="destination-categories">';
    $output .= '<ul class="list-unstyled">';

    foreach ($category_counts as $data) {
        $category = $data['category'];
        $count = $data['count'];

        $output .= '<li>';
        $output .= '<a href="/tour-category/'.$tour_category_slug.'?tour_category=' . $category->slug . '">';
        $output .= esc_html($category->name);
        $output .= ' <span class="badge bg-primary rounded-pill">' . $count . '</span>';
        $output .= '</a>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
} 