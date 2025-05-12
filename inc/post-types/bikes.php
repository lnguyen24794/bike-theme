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

    add_meta_box(
        'bike_available',
        __('Bike Availability', 'bike-theme'),
        'bike_theme_bike_availability_callback',
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
    $bike_accessories = get_post_meta($post->ID, '_bike_accessories', true);
    $bike_conditions = get_post_meta($post->ID, '_bike_conditions', true);
    $bike_how_to_book = get_post_meta($post->ID, '_bike_how_to_book', true);
    $bike_reviews = get_post_meta($post->ID, '_bike_reviews', true);
    $bike_contact = get_post_meta($post->ID, '_bike_contact', true);
    ?>
    <div class="bike-theme-meta-box">
        <h3><?php esc_html_e('Media Gallery', 'bike-theme'); ?></h3>
        <div class="bike-gallery-container">
            <input type="hidden" id="bike_gallery" name="bike_gallery" value="<?php echo esc_attr(implode(',', (array)get_post_meta($post->ID, '_bike_gallery', true))); ?>">
            <div id="bike_gallery_preview" class="bike-gallery-preview">
                <?php
                $gallery_ids = get_post_meta($post->ID, '_bike_gallery', true);
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
        <style>
            .bike-gallery-preview {
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
                    title: '<?php esc_html_e('Select or Upload Bike Gallery Images', 'bike-theme'); ?>',
                    button: {
                        text: '<?php esc_html_e('Add to Gallery', 'bike-theme'); ?>'
                    },
                    multiple: true
                });
                
                // When an image is selected, run a callback
                gallery_frame.on('select', function() {
                    var selection = gallery_frame.state().get('selection');
                    var ids = [];
                    var currentIds = $('#bike_gallery').val() ? $('#bike_gallery').val().split(',') : [];
                    
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
                            $('#bike_gallery_preview').append(
                                '<div class="gallery-image-item" data-id="' + attachmentId + '">' +
                                '<img src="' + image + '" alt="">' +
                                '<button type="button" class="remove-gallery-image dashicons dashicons-no-alt"></button>' +
                                '</div>'
                            );
                        }
                    });
                    
                    // Update the input value
                    $('#bike_gallery').val(ids.join(','));
                });
                
                // Open the frame
                gallery_frame.open();
            });
            
            // Remove gallery image
            $(document).on('click', '.remove-gallery-image', function() {
                var imageItem = $(this).closest('.gallery-image-item');
                var imageId = imageItem.data('id');
                var currentIds = $('#bike_gallery').val().split(',');
                var newIds = [];
                
                // Filter out the removed ID
                for (var i = 0; i < currentIds.length; i++) {
                    if (currentIds[i] != imageId) {
                        newIds.push(currentIds[i]);
                    }
                }
                
                // Update the input value
                $('#bike_gallery').val(newIds.join(','));
                
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
                    '<input type="checkbox" name="bike_additions[' + rowCount + '][per_person]" value="1">' +
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

        <h3><?php esc_html_e('Price Information', 'bike-theme'); ?></h3>
        <p>
            <?php
            wp_editor($bike_price, 'bike_price', array(
    'textarea_name' => 'bike_price',
    'media_buttons' => true,
    'textarea_rows' => 5,
    'editor_class' => 'widefat',
    'teeny' => true
            ));
    ?>
        </p>

        <h3><?php esc_html_e('Accessories', 'bike-theme'); ?></h3>
        <p>
            <?php
    wp_editor($bike_accessories, 'bike_accessories', array(
        'textarea_name' => 'bike_accessories',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true
    ));
    ?>
        </p>

        <h3><?php esc_html_e('Conditions and Policies', 'bike-theme'); ?></h3>
        <p>
            <?php
    wp_editor($bike_conditions, 'bike_conditions', array(
        'textarea_name' => 'bike_conditions',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true
    ));
    ?>
        </p>

        <h3><?php esc_html_e('How to Book', 'bike-theme'); ?></h3>
        <p>
            <?php
    wp_editor($bike_how_to_book, 'bike_how_to_book', array(
        'textarea_name' => 'bike_how_to_book',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true
    ));
    ?>
        </p>

        <h3><?php esc_html_e('Reviews', 'bike-theme'); ?></h3>
        <p>
            <?php
    wp_editor($bike_reviews, 'bike_reviews', array(
        'textarea_name' => 'bike_reviews',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true
    ));
    ?>
        </p>

        <h3><?php esc_html_e('Contact Information', 'bike-theme'); ?></h3>
        <p>
            <?php
    wp_editor($bike_contact, 'bike_contact', array(
        'textarea_name' => 'bike_contact',
        'media_buttons' => true,
        'textarea_rows' => 5,
        'editor_class' => 'widefat',
        'teeny' => true
    ));
    ?>
        </p>
    </div>
    
    <style>
        .bike-specs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .bike-theme-meta-box label {
            font-height: 600;
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
 * Bike availability meta box callback
 */
function bike_theme_bike_availability_callback($post)
{
    wp_nonce_field('bike_theme_bike_availability_nonce', 'bike_theme_bike_availability_nonce');

    // Get stored value
    $is_available = get_post_meta($post->ID, '_bike_available', true);
    // Default to 'yes' if not set
    if (empty($is_available)) {
        $is_available = 'yes';
    }

    ?>
    <p>
        <label>
            <input type="checkbox" name="bike_available" value="yes" <?php checked($is_available, 'yes'); ?>>
            <?php _e('This bike is available for rent/sale', 'bike-theme'); ?>
        </label>
    </p>
    <p class="description">
        <?php _e('Unavailable bikes will be marked as "Out of Stock" and cannot be booked.', 'bike-theme'); ?>
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
        !isset($_POST['bike_theme_bike_featured_nonce']) ||
        !isset($_POST['bike_theme_bike_availability_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['bike_theme_bike_details_nonce'], 'bike_theme_bike_details_nonce') ||
        !wp_verify_nonce($_POST['bike_theme_bike_featured_nonce'], 'bike_theme_bike_featured_nonce') ||
        !wp_verify_nonce($_POST['bike_theme_bike_availability_nonce'], 'bike_theme_bike_availability_nonce')) {
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
    if (isset($_POST['bike_gallery'])) {
        $gallery_ids = array_filter(explode(',', sanitize_text_field($_POST['bike_gallery'])));
        update_post_meta($post_id, '_bike_gallery', $gallery_ids);
    } else {
        delete_post_meta($post_id, '_bike_gallery');
    }
    if (isset($_POST['bike_price'])) {
        update_post_meta($post_id, '_bike_price', sanitize_text_field($_POST['bike_price']));
    }

    if (isset($_POST['bike_accessories'])) {
        update_post_meta($post_id, '_bike_accessories', wp_kses_post($_POST['bike_accessories']));
    }

    if (isset($_POST['bike_conditions'])) {
        update_post_meta($post_id, '_bike_conditions', wp_kses_post($_POST['bike_conditions']));
    }

    if (isset($_POST['bike_how_to_book'])) {
        update_post_meta($post_id, '_bike_how_to_book', wp_kses_post($_POST['bike_how_to_book']));
    }

    if (isset($_POST['bike_reviews'])) {
        update_post_meta($post_id, '_bike_reviews', wp_kses_post($_POST['bike_reviews']));
    }

    if (isset($_POST['bike_contact'])) {
        update_post_meta($post_id, '_bike_contact', wp_kses_post($_POST['bike_contact']));
    }

    // Save featured status
    $is_featured = isset($_POST['bike_featured']) ? 'yes' : 'no';
    update_post_meta($post_id, '_bike_featured', $is_featured);

    // Save availability status
    $is_available = isset($_POST['bike_available']) ? 'yes' : 'no';
    update_post_meta($post_id, '_bike_available', $is_available);
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

/**
 * Check if bike is available
 */
function bike_theme_is_bike_available($bike_id)
{
    $is_available = get_post_meta($bike_id, '_bike_available', true);
    // Default to 'yes' if not set
    return empty($is_available) || $is_available === 'yes';
}
