<?php
/**
 * Theme Options Page
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the theme options page
 */
function bike_theme_add_options_page()
{
    add_menu_page(
        __('Bike Theme Options', 'bike-theme'),
        __('Bike Theme Options', 'bike-theme'),
        'manage_options',
        'bike-theme-options',
        'bike_theme_render_options_page',
        'dashicons-admin-generic',
        3 // Position after Dashboard (2)
    );
}
add_action('admin_menu', 'bike_theme_add_options_page');

/**
 * Register settings
 */
function bike_theme_register_settings()
{
    // Register settings
    register_setting(
        'bike_theme_options_group',
        'bike_theme_options',
        'bike_theme_validate_options'
    );

    // General Section
    add_settings_section(
        'bike_theme_general_section',
        __('General Settings', 'bike-theme'),
        'bike_theme_general_section_callback',
        'bike-theme-options'
    );

    // Contact Information Section
    add_settings_section(
        'bike_theme_contact_section',
        __('Contact Information', 'bike-theme'),
        'bike_theme_contact_section_callback',
        'bike-theme-options'
    );

    // Social Media Section
    add_settings_section(
        'bike_theme_social_section',
        __('Social Media Links', 'bike-theme'),
        'bike_theme_social_section_callback',
        'bike-theme-options'
    );

    // Hero Banner Slides Section
    add_settings_section(
        'bike_theme_hero_slides_section',
        __('Hero Banner Slides', 'bike-theme'),
        'bike_theme_hero_slides_section_callback',
        'bike-theme-options'
    );

    // Tour Gallery Section
    add_settings_section(
        'bike_theme_tour_gallery_section',
        __('Tour Gallery', 'bike-theme'),
        'bike_theme_tour_gallery_section_callback',
        'bike-theme-options'
    );

    // Tour Gallery Content Section
    add_settings_section(
        'bike_theme_tour_gallery_content_section',
        __('Tour Gallery Content', 'bike-theme'),
        'bike_theme_tour_gallery_content_section_callback',
        'bike-theme-options'
    );

    // Choose Your Adventure Section
    add_settings_section(
        'bike_theme_choose_your_adventure_section',
        __('Choose Your Adventure', 'bike-theme'),
        'bike_theme_choose_your_adventure_section_callback',
        'bike-theme-options'
    );

    // Why Choose Us Section
    add_settings_section(
        'bike_theme_why_choose_us_section',
        __('Why Choose Us', 'bike-theme'),
        'bike_theme_why_choose_us_section_callback',
        'bike-theme-options'
    );

    // Bike Rentals Section
    add_settings_section(
        'bike_theme_our_bikes_section',
        __('Bike Rentals', 'bike-theme'),
        'bike_theme_our_bikes_section_callback',
        'bike-theme-options'
    );

    // Add fields
    add_settings_field(
        'currency_symbol',
        __('Currency Symbol', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_general_section',
        array(
            'id' => 'currency_symbol',
            'default' => '$'
        )
    );

    add_settings_field(
        'currency_position',
        __('Currency Position', 'bike-theme'),
        'bike_theme_select_field_callback',
        'bike-theme-options',
        'bike_theme_general_section',
        array(
            'id' => 'currency_position',
            'default' => 'before',
            'options' => array(
                'before' => __('Before price ($99)', 'bike-theme'),
                'after' => __('After price (99$)', 'bike-theme')
            )
        )
    );

    add_settings_field(
        'primary_color',
        __('Primary Color', 'bike-theme'),
        'bike_theme_color_field_callback',
        'bike-theme-options',
        'bike_theme_general_section',
        array(
            'id' => 'primary_color',
            'default' => '#3498db'
        )
    );

    add_settings_field(
        'secondary_logo',
        __('Secondary Logo', 'bike-theme'),
        'bike_theme_image_field_callback',
        'bike-theme-options',
        'bike_theme_general_section',
        array(
            'id' => 'secondary_logo',
            'default' => ''
        )
    );

    add_settings_field(
        'contact_email',
        __('Contact Email', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_contact_section',
        array(
            'id' => 'contact_email',
            'default' => get_option('admin_email')
        )
    );

    add_settings_field(
        'contact_phone',
        __('Contact Phone', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_contact_section',
        array(
            'id' => 'contact_phone',
            'default' => ''
        )
    );

    add_settings_field(
        "whatsapp_phone",
        __('Whatsapp Phone', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_contact_section',
        array(
            'id' => 'whatsapp_phone',
            'default' => ''
        )
    );

    add_settings_field(
        'contact_address',
        __('Address', 'bike-theme'),
        'bike_theme_branches_callback',
        'bike-theme-options',
        'bike_theme_contact_section',
        array(
            'id' => 'contact_address',
            'default' => array()
        )
    );

    add_settings_field(
        'booking_page',
        __('Booking Page', 'bike-theme'),
        'bike_theme_page_select_callback',
        'bike-theme-options',
        'bike_theme_booking_section',
        array(
            'id' => 'booking_page',
            'default' => ''
        )
    );

    add_settings_field(
        'bank_account_info',
        __('Bank Account Information', 'bike-theme'),
        'bike_theme_textarea_field_callback',
        'bike-theme-options',
        'bike_theme_booking_section',
        array(
            'id' => 'bank_account_info',
            'default' => '',
            'description' => __('This information will be shown to customers who choose bank transfer as payment method.', 'bike-theme')
        )
    );

    add_settings_field(
        'email_footer',
        __('Email Footer Text', 'bike-theme'),
        'bike_theme_textarea_field_callback',
        'bike-theme-options',
        'bike_theme_booking_section',
        array(
            'id' => 'email_footer',
            'default' => '',
            'description' => __('This text will appear at the bottom of all emails sent to customers.', 'bike-theme')
        )
    );

    // Add Social Media fields
    add_settings_field(
        'facebook',
        __('Facebook', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_social_section',
        array(
            'id' => 'facebook',
            'default' => ''
        )
    );

    add_settings_field(
        'twitter',
        __('Twitter', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_social_section',
        array(
            'id' => 'twitter',
            'default' => ''
        )
    );

    add_settings_field(
        'instagram',
        __('Instagram', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_social_section',
        array(
            'id' => 'instagram',
            'default' => ''
        )
    );

    add_settings_field(
        'linkedin',
        __('LinkedIn', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_social_section',
        array(
            'id' => 'linkedin',
            'default' => ''
        )
    );

    add_settings_field(
        'youtube',
        __('YouTube', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_social_section',
        array(
            'id' => 'youtube',
            'default' => ''
        )
    );

    add_settings_field(
        'copyright',
        __('Copyright Text', 'bike-theme'),
        'bike_theme_text_field_callback',
        'bike-theme-options',
        'bike_theme_social_section',
        array(
            'id' => 'copyright',
            'default' => '© ' . date('Y') . ' Bike Theme. All Rights Reserved.'
        )
    );

    // Hero Banner Slides setting
    add_settings_field(
        'slides',
        __('Hero Banner Slides', 'bike-theme'),
        'bike_theme_hero_slides_callback',
        'bike-theme-options',
        'bike_theme_hero_slides_section',
        array(
            'id' => 'slides',
            'default' => array()
        )
    );

    // Tour Gallery setting
    add_settings_field(
        'tour_gallery',
        __('Tour Gallery Images', 'bike-theme'),
        'bike_theme_tour_gallery_callback',
        'bike-theme-options',
        'bike_theme_tour_gallery_section',
        array(
            'id' => 'tour_gallery',
            'default' => array()
        )
    );

    // Tour Gallery Content setting
    add_settings_field(
        'tour_gallery_content',
        __('Gallery Content', 'bike-theme'),
        'bike_theme_tour_gallery_content_callback',
        'bike-theme-options',
        'bike_theme_tour_gallery_content_section',
        array(
            'id' => 'tour_gallery_content',
            'default' => ''
        )
    );

    // Choose Your Adventure setting
    add_settings_field(
        'choose_your_adventure_content',
        __('Content', 'bike-theme'),
        'bike_theme_choose_your_adventure_callback',
        'bike-theme-options',
        'bike_theme_choose_your_adventure_section',
        array(
            'id' => 'choose_your_adventure_content',
            'default' => ''
        )
    );

    // Why Choose Us setting
    add_settings_field(
        'why_choose_us_content',
        __('Content', 'bike-theme'),
        'bike_theme_why_choose_us_callback',
        'bike-theme-options',
        'bike_theme_why_choose_us_section',
        array(
            'id' => 'why_choose_us_content',
            'default' => ''
        )
    );

    // Bike Rentals setting
    add_settings_field(
        'our_bikes_content',
        __('Content', 'bike-theme'),
        'bike_theme_our_bikes_callback',
        'bike-theme-options',
        'bike_theme_our_bikes_section',
        array(
            'id' => 'our_bikes_content',
            'default' => ''
        )
    );

    // About Slides Section
    add_settings_section(
        'bike_theme_about_slides_section',
        __('About Slides', 'bike-theme'),
        'bike_theme_about_slides_section_callback',
        'bike-theme-options'
    );
    // About Slides setting
    add_settings_field(
        'about_slides',
        __('About Slides', 'bike-theme'),
        'bike_theme_about_slides_callback',
        'bike-theme-options',
        'bike_theme_about_slides_section',
        array(
           'id' => 'about_slides',
           'default' => array()
        )
    );
}
add_action('admin_init', 'bike_theme_register_settings');

/**
 * Section callbacks
 */
function bike_theme_general_section_callback()
{
    echo '<p>' . __('Configure general settings for your theme.', 'bike-theme') . '</p>';
}

function bike_theme_contact_section_callback()
{
    echo '<p>' . __('Add your contact information that will be displayed on the website.', 'bike-theme') . '</p>';
}

function bike_theme_social_section_callback()
{
    echo '<p>' . __('Configure your social media links and footer information.', 'bike-theme') . '</p>';
}

function bike_theme_about_slides_section_callback()
{
    echo '<p>' . __('Manage images for the about section slider.', 'bike-theme') . '</p>';
}

function bike_theme_hero_slides_section_callback()
{
    echo '<p>' . __('Manage slides for the home page banner/carousel.', 'bike-theme') . '</p>';
}

function bike_theme_tour_gallery_section_callback()
{
    echo '<p>' . __('Manage images for the tour gallery display.', 'bike-theme') . '</p>';
}

function bike_theme_tour_gallery_content_section_callback()
{
    echo '<p>' . __('Configure content for the tour gallery.', 'bike-theme') . '</p>';
}

function bike_theme_why_choose_us_section_callback()
{
    echo '<p>' . __('Manage the Why Choose Us section content on the homepage.', 'bike-theme') . '</p>';
}

function bike_theme_our_bikes_section_callback()
{
    echo '<p>' . __('Manage the Bike Rentals section content on the homepage.', 'bike-theme') . '</p>';
}

function bike_theme_choose_your_adventure_section_callback()
{
    echo '<p>' . __('Manage the Choose Your Adventure section content on the homepage.', 'bike-theme') . '</p>';
}

function bike_theme_booking_section_callback()
{
    echo '<p>' . __('Configure settings for the booking system.', 'bike-theme') . '</p>';
}

/**
 * Field callbacks
 */
function bike_theme_text_field_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = isset($options[$id]) ? $options[$id] : $default;

    echo '<input type="text" id="' . esc_attr($id) . '" name="bike_theme_options[' . esc_attr($id) . ']" value="' . esc_attr($value) . '" class="regular-text" />';

    if (isset($args['description'])) {
        echo '<p class="description">' . esc_html($args['description']) . '</p>';
    }
}

function bike_theme_textarea_field_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = isset($options[$id]) ? $options[$id] : $default;

    echo '<textarea id="' . esc_attr($id) . '" name="bike_theme_options[' . esc_attr($id) . ']" rows="5" class="large-text">' . esc_textarea($value) . '</textarea>';

    if (isset($args['description'])) {
        echo '<p class="description">' . esc_html($args['description']) . '</p>';
    }
}

function bike_theme_select_field_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = isset($options[$id]) ? $options[$id] : $default;
    $select_options = $args['options'];

    echo '<select id="' . esc_attr($id) . '" name="bike_theme_options[' . esc_attr($id) . ']">';

    foreach ($select_options as $key => $label) {
        echo '<option value="' . esc_attr($key) . '" ' . selected($value, $key, false) . '>' . esc_html($label) . '</option>';
    }

    echo '</select>';

    if (isset($args['description'])) {
        echo '<p class="description">' . esc_html($args['description']) . '</p>';
    }
}

function bike_theme_color_field_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '#000000';
    $value = isset($options[$id]) ? $options[$id] : $default;

    echo '<input type="text" id="' . esc_attr($id) . '" name="bike_theme_options[' . esc_attr($id) . ']" value="' . esc_attr($value) . '" class="bike-theme-color-field" data-default-color="' . esc_attr($default) . '" />';

    if (isset($args['description'])) {
        echo '<p class="description">' . esc_html($args['description']) . '</p>';
    }
}

function bike_theme_image_field_callback($args) {
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = isset($options[$id]) ? $options[$id] : $default;
    $image_id = isset($options[$id . '_id']) ? $options[$id . '_id'] : 0;

    echo '<div class="bike-media-upload">';
    echo '<input type="hidden" id="' . esc_attr($id) . '_id" name="bike_theme_options[' . esc_attr($id) . '_id]" value="' . esc_attr($image_id) . '" class="bike-media-id" />';
    echo '<input type="hidden" id="' . esc_attr($id) . '" name="bike_theme_options[' . esc_attr($id) . ']" value="' . esc_attr($value) . '" class="bike-media-url" />';
    
    echo '<div class="bike-media-preview">';
    if ($value) {
        echo '<img src="' . esc_url($value) . '" style="max-width:150px;height:auto;" />';
    }
    echo '</div>';
    
    echo '<input type="button" class="button bike-media-upload-button" value="' . esc_attr__('Upload Image', 'bike-theme') . '" />';
    echo '<input type="button" class="button bike-media-remove-button' . ($value ? '' : ' hidden') . '" value="' . esc_attr__('Remove Image', 'bike-theme') . '" />';
    echo '</div>';

    if (isset($args['description'])) {
        echo '<p class="description">' . esc_html($args['description']) . '</p>';
    }

    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Media Upload
        $('.bike-media-upload-button').click(function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $wrapper = $button.closest('.bike-media-upload');
            var $preview = $wrapper.find('.bike-media-preview');
            var $urlInput = $wrapper.find('.bike-media-url');
            var $idInput = $wrapper.find('.bike-media-id');
            var $removeButton = $wrapper.find('.bike-media-remove-button');

            // Create a new media uploader instance for this button
            var fileMediaUploader = wp.media({
                title: '<?php echo esc_js(__('Choose Image', 'bike-theme')); ?>',
                button: {
                    text: '<?php echo esc_js(__('Select', 'bike-theme')); ?>'
                },
                multiple: false
            });

            // When an image is selected, run a callback
            fileMediaUploader.on('select', function() {
                var attachment = fileMediaUploader.state().get('selection').first().toJSON();
                
                $urlInput.val(attachment.url);
                $idInput.val(attachment.id);
                $preview.html('<img src="' + attachment.url + '" style="max-width:150px;height:auto;" />');
                $removeButton.removeClass('hidden');
            });

            // Open the uploader dialog
            fileMediaUploader.open();
        });

        // Remove Image
        $('.bike-media-remove-button').click(function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $wrapper = $button.closest('.bike-media-upload');
            var $preview = $wrapper.find('.bike-media-preview');
            var $urlInput = $wrapper.find('.bike-media-url');
            var $idInput = $wrapper.find('.bike-media-id');

            $urlInput.val('');
            $idInput.val('');
            $preview.empty();
            $button.addClass('hidden');
        });
    });
    </script>
    <?php
}

function bike_theme_page_select_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $value = isset($options[$id]) ? $options[$id] : $default;

    $pages = get_pages();

    echo '<select id="' . esc_attr($id) . '" name="bike_theme_options[' . esc_attr($id) . ']">';
    echo '<option value="">' . __('Select a page', 'bike-theme') . '</option>';

    foreach ($pages as $page) {
        echo '<option value="' . esc_attr($page->ID) . '" ' . selected($value, $page->ID, false) . '>' . esc_html($page->post_title) . '</option>';
    }

    echo '</select>';

    if (isset($args['description'])) {
        echo '<p class="description">' . esc_html($args['description']) . '</p>';
    }
}

/**
 * Validate options
 */
function bike_theme_validate_options($input)
{
    $output = array();

    foreach ($input as $key => $value) {
        if (isset($input[$key])) {
            if ($key === 'contact_email') {
                $output[$key] = sanitize_email($input[$key]);
            } elseif (in_array($key, array('bank_account_info', 'email_footer', 'why_choose_us_content', 'tour_gallery_content'))) {
                $output[$key] = wp_kses_post($input[$key]);
            } elseif ($key === 'contact_address' && is_array($value)) {
                // Xử lý mảng chi nhánh
                $output[$key] = array();
                foreach ($value as $index => $branch_data) {
                    if (!isset($branch_data['delete']) || $branch_data['delete'] != 'yes') {
                        $output[$key][] = array(
                            'name' => isset($branch_data['name']) ? sanitize_text_field($branch_data['name']) : '',
                            'address' => isset($branch_data['address']) ? wp_kses_post($branch_data['address']) : '',
                            'link' => isset($branch_data['link']) ? esc_url_raw($branch_data['link']) : '',
                            'opening_closed' => isset($branch_data['opening_closed']) ? sanitize_text_field($branch_data['opening_closed']) : '',
                        );
                    }
                }
            } elseif ($key === 'about_slides' && is_array($value)) {
                // Process about slides
                $output[$key] = array();
                foreach ($value as $index => $slide_data) {
                    if (!isset($slide_data['delete']) || $slide_data['delete'] != 'yes') {
                        $output[$key][] = array(
                            'image_id' => isset($slide_data['image_id']) ? absint($slide_data['image_id']) : 0,
                            'image_url' => isset($slide_data['image_url']) ? esc_url_raw($slide_data['image_url']) : '',
                            'image_alt' => isset($slide_data['image_alt']) ? sanitize_text_field($slide_data['image_alt']) : '',
                            'active' => isset($slide_data['active']) ? 1 : 0,
                        );
                    }
                }
            } elseif ($key === 'slides' && is_array($value)) {
                // Process hero slides
                $output[$key] = array();
                foreach ($value as $index => $slide_data) {
                    if (!isset($slide_data['delete']) || $slide_data['delete'] != 'yes') {
                        $output[$key][] = array(
                            'image_id' => isset($slide_data['image_id']) ? absint($slide_data['image_id']) : 0,
                            'image_url' => isset($slide_data['image_url']) ? esc_url_raw($slide_data['image_url']) : '',
                            'title' => isset($slide_data['title']) ? sanitize_text_field($slide_data['title']) : '',
                            'subtitle' => isset($slide_data['subtitle']) ? sanitize_text_field($slide_data['subtitle']) : '',
                            'slogan' => isset($slide_data['slogan']) ? sanitize_text_field($slide_data['slogan']) : '',
                            'btn1_text' => isset($slide_data['btn1_text']) ? sanitize_text_field($slide_data['btn1_text']) : '',
                            'btn1_url' => isset($slide_data['btn1_url']) ? esc_url_raw($slide_data['btn1_url']) : '',
                            'btn2_text' => isset($slide_data['btn2_text']) ? sanitize_text_field($slide_data['btn2_text']) : '',
                            'btn2_url' => isset($slide_data['btn2_url']) ? esc_url_raw($slide_data['btn2_url']) : '',
                            'active' => isset($slide_data['active']) ? 1 : 0,
                        );
                    }
                }
            } elseif ($key === 'tour_gallery' && is_array($value)) {
                // Process tour gallery
                $output[$key] = array();
                $gallery_index = 0;

                foreach ($value as $index => $gallery_data) {
                    if ((!isset($gallery_data['delete']) || $gallery_data['delete'] != 'yes') &&
                        !empty($gallery_data['image_url']) && !empty($gallery_data['image_id'])) {
                        // Save with sequential indexes to avoid gaps
                        $output[$key][$gallery_index] = array(
                            'image_id' => absint($gallery_data['image_id']),
                            'image_url' => esc_url_raw($gallery_data['image_url']),
                        );
                        $gallery_index++;
                    }
                }
            } elseif (in_array($key, array('facebook', 'twitter', 'instagram', 'linkedin', 'youtube'))) {
                // Validate URLs for social media
                $output[$key] = esc_url_raw($input[$key]);
            } else {
                $output[$key] = sanitize_text_field($input[$key]);
            }
        }
    }

    return $output;
}

/**
 * Render the options page
 */
function bike_theme_render_options_page()
{
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('bike_theme_options_group');
    do_settings_sections('bike-theme-options');
    submit_button();
    ?>
        </form>
    </div>
    <?php
}

/**
 * Enqueue admin scripts
 */
function bike_theme_options_scripts($hook)
{
    if ('toplevel_page_bike-theme-options' !== $hook) {
        return;
    }

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    // Add media scripts
    wp_enqueue_media();

    // Add custom admin styles
    wp_enqueue_style(
        'bike-theme-admin-css',
        get_template_directory_uri() . '/assets/css/admin.css',
        array(),
        '1.0.0'
    );

    // Add custom script to handle media uploads and slide management
    wp_enqueue_script(
        'bike-theme-admin-js',
        get_template_directory_uri() . '/assets/js/admin.js',
        array('jquery', 'jquery-ui-sortable', 'wp-color-picker'),
        '1.0.0',
        true
    );

    wp_localize_script('bike-theme-admin-js', 'bikeThemeAdmin', array(
        'i18n' => array(
            'confirmDelete' => __('Are you sure you want to delete this item?', 'bike-theme'),
            'chooseImage' => __('Select or Upload Image', 'bike-theme'),
            'useThisImage' => __('Use this image', 'bike-theme'),
            'selectGalleryImages' => __('Select Gallery Images', 'bike-theme'),
            'addToGallery' => __('Add to Gallery', 'bike-theme')
        )
    ));
}
add_action('admin_enqueue_scripts', 'bike_theme_options_scripts');

/**
 * Get option helper function
 */
function bike_theme_get_option($key, $default = '')
{
    $options = get_option('bike_theme_options');

    // First try looking in the options array
    if (isset($options[$key])) {
        return $options[$key];
    }

    // For backwards compatibility, also check individual options
    $legacy_value = get_option('bike_theme_' . $key, null);
    if ($legacy_value !== null) {
        return $legacy_value;
    }

    return $default;
}

/**
 * About slides field callback
 */
function bike_theme_about_slides_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : array();
    $about_slides = isset($options[$id]) ? $options[$id] : $default;

    // If no slides exist, create default ones
    if (empty($about_slides)) {
        $about_slides = array(
            array(
                'image_id' => 0,
                'image_url' => '',
                'image_alt' => __('About Us Image 1', 'bike-theme'),
                'active' => 1
            ),
            array(
                'image_id' => 0,
                'image_url' => '',
                'image_alt' => __('About Us Image 2', 'bike-theme'),
                'active' => 1
            )
        );
    }

    // Output field
    echo '<div id="bike-about-slides-container">';

    foreach ($about_slides as $index => $slide) {
        ?>
        <div class="bike-slide-item" data-index="<?php echo $index; ?>">
            <h3><?php esc_html_e('About Slide', 'bike-theme'); ?> <span class="slide-number"><?php echo $index + 1; ?></span> 
                <span class="slide-controls">
                    <a href="#" class="slide-toggle"><?php esc_html_e('Toggle', 'bike-theme'); ?></a> | 
                    <a href="#" class="slide-remove"><?php esc_html_e('Remove', 'bike-theme'); ?></a>
                </span>
            </h3>
            <div class="slide-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_about_slides_<?php echo $index; ?>_active">
                                <?php esc_html_e('Active', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[about_slides][<?php echo $index; ?>][active]" 
                                type="checkbox" 
                                id="bike_theme_options_about_slides_<?php echo $index; ?>_active" 
                                <?php checked(isset($slide['active']) ? $slide['active'] : 0, 1); ?>>
                            <input type="hidden" 
                                name="bike_theme_options[about_slides][<?php echo $index; ?>][delete]" 
                                class="slide-delete-field" value="no">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_about_slides_<?php echo $index; ?>_image">
                                <?php esc_html_e('Image', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <div class="bike-media-upload">
                                <input type="hidden" 
                                    name="bike_theme_options[about_slides][<?php echo $index; ?>][image_id]" 
                                    class="bike-media-id" 
                                    value="<?php echo esc_attr(isset($slide['image_id']) ? $slide['image_id'] : 0); ?>">
                                <input type="hidden" 
                                    name="bike_theme_options[about_slides][<?php echo $index; ?>][image_url]" 
                                    class="bike-media-url" 
                                    value="<?php echo esc_url(isset($slide['image_url']) ? $slide['image_url'] : ''); ?>">
                                <div class="bike-media-preview">
                                    <?php if (!empty($slide['image_url'])) : ?>
                                        <img src="<?php echo esc_url($slide['image_url']); ?>" alt="" style="max-width: 300px;">
                                    <?php endif; ?>
                                </div>
                                <input type="button" class="button bike-media-upload-btn" 
                                    value="<?php esc_attr_e('Upload Image', 'bike-theme'); ?>">
                                <input type="button" 
                                    class="button bike-media-remove-btn <?php echo empty($slide['image_url']) ? 'hidden' : ''; ?>" 
                                    value="<?php esc_attr_e('Remove Image', 'bike-theme'); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_about_slides_<?php echo $index; ?>_alt">
                                <?php esc_html_e('Image Alt Text', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[about_slides][<?php echo $index; ?>][image_alt]" 
                                type="text" 
                                id="bike_theme_options_about_slides_<?php echo $index; ?>_alt" 
                                value="<?php echo esc_attr(isset($slide['image_alt']) ? $slide['image_alt'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }

    echo '</div>';

    echo '<p><button type="button" id="add-about-slide-button" class="button button-secondary">' .
        __('Add New About Slide', 'bike-theme') . '</button></p>';

    // Template for new about slides
    ?>
    <script type="text/template" id="about-slide-template">
        <div class="bike-slide-item" data-index="{{index}}">
            <h3><?php esc_html_e('About Slide', 'bike-theme'); ?> <span class="slide-number">{{number}}</span> 
                <span class="slide-controls">
                    <a href="#" class="slide-toggle"><?php esc_html_e('Toggle', 'bike-theme'); ?></a> | 
                    <a href="#" class="slide-remove"><?php esc_html_e('Remove', 'bike-theme'); ?></a>
                </span>
            </h3>
            <div class="slide-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_about_slides_{{index}}_active">
                                <?php esc_html_e('Active', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[about_slides][{{index}}][active]" 
                                type="checkbox" 
                                id="bike_theme_options_about_slides_{{index}}_active" 
                                checked>
                            <input type="hidden" 
                                name="bike_theme_options[about_slides][{{index}}][delete]" 
                                class="slide-delete-field" 
                                value="no">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_about_slides_{{index}}_image">
                                <?php esc_html_e('Image', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <div class="bike-media-upload">
                                <input type="hidden" 
                                    name="bike_theme_options[about_slides][{{index}}][image_id]" 
                                    class="bike-media-id" 
                                    value="">
                                <input type="hidden" 
                                    name="bike_theme_options[about_slides][{{index}}][image_url]" 
                                    class="bike-media-url" 
                                    value="">
                                <div class="bike-media-preview"></div>
                                <input type="button" 
                                    class="button bike-media-upload-btn" 
                                    value="<?php esc_attr_e('Upload Image', 'bike-theme'); ?>">
                                <input type="button" 
                                    class="button bike-media-remove-btn hidden" 
                                    value="<?php esc_attr_e('Remove Image', 'bike-theme'); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_about_slides_{{index}}_alt">
                                <?php esc_html_e('Image Alt Text', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[about_slides][{{index}}][image_alt]" 
                                type="text" 
                                id="bike_theme_options_about_slides_{{index}}_alt" 
                                value="" 
                                class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </script>
    <?php
}

/**
 * Hero slides field callback
 */
function bike_theme_hero_slides_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : array();
    $slides = isset($options[$id]) ? $options[$id] : $default;

    // If no slides exist, create default ones
    if (empty($slides)) {
        // Thử lấy từ cài đặt cũ trước
        $old_slides = get_option('slides', array());
        if (!empty($old_slides)) {
            $slides = $old_slides;
        } else {
            // Nếu không có thì tạo mới
            $slides[] = array(
                'image_id' => 0,
                'image_url' => '',
                'subtitle' => __('Tour Xe Đạp Việt Nam', 'bike-theme'),
                'title' => __('Khám Phá Việt Nam Trên Hai Bánh', 'bike-theme'),
                'slogan' => __('Khám phá Việt Nam trên hai bánh xe', 'bike-theme'),
                'btn1_text' => __('Xem Tour', 'bike-theme'),
                'btn1_url' => '',
                'btn2_text' => __('Đặt Xe Ngay', 'bike-theme'),
                'btn2_url' => '',
                'active' => 1
            );
        }
    }

    // Output field
    echo '<div id="bike-hero-slides-container">';

    foreach ($slides as $index => $slide) {
        ?>
        <div class="bike-slide-item" data-index="<?php echo $index; ?>">
            <h3><?php esc_html_e('Hero Slide', 'bike-theme'); ?> <span class="slide-number"><?php echo $index + 1; ?></span> 
                <span class="slide-controls">
                    <a href="#" class="slide-toggle"><?php esc_html_e('Toggle', 'bike-theme'); ?></a> | 
                    <a href="#" class="slide-remove"><?php esc_html_e('Remove', 'bike-theme'); ?></a>
                </span>
            </h3>
            <div class="slide-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_active">
                                <?php esc_html_e('Active', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][active]" 
                                type="checkbox" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_active" 
                                <?php checked(isset($slide['active']) ? $slide['active'] : 0, 1); ?>>
                            <input type="hidden" 
                                name="bike_theme_options[slides][<?php echo $index; ?>][delete]" 
                                class="slide-delete-field" value="no">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_image">
                                <?php esc_html_e('Image', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <div class="bike-media-upload">
                                <input type="hidden" 
                                    name="bike_theme_options[slides][<?php echo $index; ?>][image_id]" 
                                    class="bike-media-id" 
                                    value="<?php echo esc_attr(isset($slide['image_id']) ? $slide['image_id'] : 0); ?>">
                                <input type="hidden" 
                                    name="bike_theme_options[slides][<?php echo $index; ?>][image_url]" 
                                    class="bike-media-url" 
                                    value="<?php echo esc_url(isset($slide['image_url']) ? $slide['image_url'] : ''); ?>">
                                <div class="bike-media-preview">
                                    <?php if (!empty($slide['image_url'])) : ?>
                                        <img src="<?php echo esc_url($slide['image_url']); ?>" alt="" style="max-width: 300px;">
                                    <?php endif; ?>
                                </div>
                                <input type="button" class="button bike-media-upload-btn" 
                                    value="<?php esc_attr_e('Upload Image', 'bike-theme'); ?>">
                                <input type="button" 
                                    class="button bike-media-remove-btn <?php echo empty($slide['image_url']) ? 'hidden' : ''; ?>" 
                                    value="<?php esc_attr_e('Remove Image', 'bike-theme'); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_title">
                                <?php esc_html_e('Title', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][title]" 
                                type="text" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_title" 
                                value="<?php echo esc_attr(isset($slide['title']) ? $slide['title'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_subtitle">
                                <?php esc_html_e('Subtitle', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <textarea name="bike_theme_options[slides][<?php echo $index; ?>][subtitle]" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_subtitle" 
                                class="regular-text" rows="5"><?php echo esc_attr(isset($slide['subtitle']) ? $slide['subtitle'] : ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_slogan">
                                <?php esc_html_e('Slogan', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][slogan]" 
                                type="text" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_slogan" 
                                value="<?php echo esc_attr(isset($slide['slogan']) ? $slide['slogan'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_btn1_text">
                                <?php esc_html_e('Button 1 Text', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][btn1_text]" 
                                type="text" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_btn1_text" 
                                value="<?php echo esc_attr(isset($slide['btn1_text']) ? $slide['btn1_text'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_btn1_url">
                                <?php esc_html_e('Button 1 URL', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][btn1_url]" 
                                type="url" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_btn1_url" 
                                value="<?php echo esc_url(isset($slide['btn1_url']) ? $slide['btn1_url'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_btn2_text">
                                <?php esc_html_e('Button 2 Text', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][btn2_text]" 
                                type="text" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_btn2_text" 
                                value="<?php echo esc_attr(isset($slide['btn2_text']) ? $slide['btn2_text'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_<?php echo $index; ?>_btn2_url">
                                <?php esc_html_e('Button 2 URL', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][<?php echo $index; ?>][btn2_url]" 
                                type="url" 
                                id="bike_theme_options_slides_<?php echo $index; ?>_btn2_url" 
                                value="<?php echo esc_url(isset($slide['btn2_url']) ? $slide['btn2_url'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }

    echo '</div>';

    echo '<p><button type="button" id="add-hero-slide-button" class="button button-secondary">' .
        __('Add New Hero Slide', 'bike-theme') . '</button></p>';

    // Template for new hero slides
    ?>
    <script type="text/template" id="hero-slide-template">
        <div class="bike-slide-item" data-index="{{index}}">
            <h3><?php esc_html_e('Hero Slide', 'bike-theme'); ?> <span class="slide-number">{{number}}</span> 
                <span class="slide-controls">
                    <a href="#" class="slide-toggle"><?php esc_html_e('Toggle', 'bike-theme'); ?></a> | 
                    <a href="#" class="slide-remove"><?php esc_html_e('Remove', 'bike-theme'); ?></a>
                </span>
            </h3>
            <div class="slide-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_active">
                                <?php esc_html_e('Active', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][active]" 
                                type="checkbox" 
                                id="bike_theme_options_slides_{{index}}_active" 
                                checked>
                            <input type="hidden" 
                                name="bike_theme_options[slides][{{index}}][delete]" 
                                class="slide-delete-field" 
                                value="no">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_image">
                                <?php esc_html_e('Image', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <div class="bike-media-upload">
                                <input type="hidden" 
                                    name="bike_theme_options[slides][{{index}}][image_id]" 
                                    class="bike-media-id" 
                                    value="">
                                <input type="hidden" 
                                    name="bike_theme_options[slides][{{index}}][image_url]" 
                                    class="bike-media-url" 
                                    value="">
                                <div class="bike-media-preview"></div>
                                <input type="button" 
                                    class="button bike-media-upload-btn" 
                                    value="<?php esc_attr_e('Upload Image', 'bike-theme'); ?>">
                                <input type="button" 
                                    class="button bike-media-remove-btn hidden" 
                                    value="<?php esc_attr_e('Remove Image', 'bike-theme'); ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_title">
                                <?php esc_html_e('Title', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][title]" 
                                type="text" 
                                id="bike_theme_options_slides_{{index}}_title" 
                                value="<?php echo esc_attr__('Khám Phá Việt Nam Trên Hai Bánh', 'bike-theme'); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_subtitle">
                                <?php esc_html_e('Subtitle', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <textarea name="bike_theme_options[slides][{{index}}][subtitle]" 
                                id="bike_theme_options_slides_{{index}}_subtitle" 
                                class="regular-text" rows="5"> <?php echo esc_attr__('Tour Xe Đạp Việt Nam', 'bike-theme'); ?> </textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_slogan">
                                <?php esc_html_e('Slogan', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][slogan]" 
                                type="text" 
                                id="bike_theme_options_slides_{{index}}_slogan" 
                                value="<?php echo esc_attr__('Khám phá Việt Nam trên hai bánh xe', 'bike-theme'); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_btn1_text">
                                <?php esc_html_e('Button 1 Text', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][btn1_text]" 
                                type="text" 
                                id="bike_theme_options_slides_{{index}}_btn1_text" 
                                value="<?php echo esc_attr__('Xem Tour', 'bike-theme'); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_btn1_url">
                                <?php esc_html_e('Button 1 URL', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][btn1_url]" 
                                type="url" 
                                id="bike_theme_options_slides_{{index}}_btn1_url" 
                                value="" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_btn2_text">
                                <?php esc_html_e('Button 2 Text', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][btn2_text]" 
                                type="text" 
                                id="bike_theme_options_slides_{{index}}_btn2_text" 
                                value="<?php echo esc_attr__('Đặt Xe Ngay', 'bike-theme'); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_slides_{{index}}_btn2_url">
                                <?php esc_html_e('Button 2 URL', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[slides][{{index}}][btn2_url]" 
                                type="url" 
                                id="bike_theme_options_slides_{{index}}_btn2_url" 
                                value="" 
                                class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </script>
    <?php
}

/**
 * Tour gallery field callback
 */
function bike_theme_tour_gallery_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : array();
    $tour_gallery = isset($options[$id]) ? $options[$id] : $default;

    // Output field
    ?>
    <div class="tour-gallery-wrapper">
        <div id="bike-tour-gallery-container" class="gallery-grid">
            <?php
            if (!empty($tour_gallery)) {
                foreach ($tour_gallery as $index => $gallery_data) {
                    if (empty($gallery_data['image_url'])) {
                        continue;
                    }
                    ?>
                    <div class="gallery-item" data-id="<?php echo esc_attr($gallery_data['image_id']); ?>">
                        <img src="<?php echo esc_url($gallery_data['image_url']); ?>" alt="">
                        <div class="gallery-item-actions">
                            <a href="#" class="gallery-item-remove" title="<?php esc_attr_e('Remove Image', 'bike-theme'); ?>">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </div>
                        <input type="hidden" name="bike_theme_options[tour_gallery][<?php echo $index; ?>][image_id]" value="<?php echo esc_attr($gallery_data['image_id']); ?>">
                        <input type="hidden" name="bike_theme_options[tour_gallery][<?php echo $index; ?>][image_url]" value="<?php echo esc_url($gallery_data['image_url']); ?>">
                        <input type="hidden" name="bike_theme_options[tour_gallery][<?php echo $index; ?>][delete]" class="gallery-delete-field" value="no">
                    </div>
                    <?php
                }
            }
    ?>
        </div>
        
        <div class="tour-gallery-actions">
            <input type="hidden" id="tour-gallery-images" name="tour_gallery_images">
            <button type="button" id="tour-gallery-upload-button" class="button button-primary">
                <span class="dashicons dashicons-upload"></span> <?php esc_html_e('Upload Images', 'bike-theme'); ?>
            </button>
        </div>
    </div>
    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Tour Gallery - Multiple Upload
            var tour_gallery_frame;
            var $gallery_container = $('#bike-tour-gallery-container');
            var $upload_button = $('#tour-gallery-upload-button');
            var gallery_item_count = $gallery_container.find('.gallery-item').length;
            
            // Open media library
            $upload_button.on('click', function(e) {
                e.preventDefault();
                
                // If frame exists, reopen it
                if (tour_gallery_frame) {
                    tour_gallery_frame.open();
                    return;
                }
                
                // Create the frame
                tour_gallery_frame = wp.media({
                    title: '<?php echo esc_js(__('Select Tour Gallery Images', 'bike-theme')); ?>',
                    button: {
                        text: '<?php echo esc_js(__('Add to Gallery', 'bike-theme')); ?>'
                    },
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });
                
                // When images are selected
                tour_gallery_frame.on('select', function() {
                    var selection = tour_gallery_frame.state().get('selection');
                    
                    // Loop through selected images
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        
                        // Check if image already exists in gallery
                        if ($gallery_container.find('.gallery-item[data-id="' + attachment.id + '"]').length === 0) {
                            var index = gallery_item_count++;
                            var template = 
                                '<div class="gallery-item" data-id="' + attachment.id + '">' +
                                    '<img src="' + attachment.url + '" alt="">' +
                                    '<div class="gallery-item-actions">' +
                                        '<a href="#" class="gallery-item-remove" title="<?php esc_attr_e('Remove Image', 'bike-theme'); ?>">' +
                                            '<span class="dashicons dashicons-trash"></span>' +
                                        '</a>' +
                                    '</div>' +
                                    '<input type="hidden" name="bike_theme_options[tour_gallery][' + index + '][image_id]" value="' + attachment.id + '">' +
                                    '<input type="hidden" name="bike_theme_options[tour_gallery][' + index + '][image_url]" value="' + attachment.url + '">' +
                                    '<input type="hidden" name="bike_theme_options[tour_gallery][' + index + '][delete]" class="gallery-delete-field" value="no">' +
                                '</div>';
                            
                            $gallery_container.append(template);
                        }
                    });
                    
                    // Update layout
                    updateGalleryLayout();
                });
                
                // Open media frame
                tour_gallery_frame.open();
            });
            
            // Remove gallery item
            $gallery_container.on('click', '.gallery-item-remove', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.gallery-item');
                $item.find('.gallery-delete-field').val('yes');
                $item.fadeOut(300, function() {
                    $(this).addClass('removed');
                    updateGalleryLayout();
                });
            });
            
            // Update gallery layout
            function updateGalleryLayout() {
                if ($gallery_container.find('.gallery-item:not(.removed)').length === 0) {
                    $gallery_container.addClass('empty');
                } else {
                    $gallery_container.removeClass('empty');
                }
            }
            
            // Initialize layout
            updateGalleryLayout();
            
            // Make gallery sortable
            if ($.fn.sortable) {
                $gallery_container.sortable({
                    items: '.gallery-item:not(.removed)',
                    cursor: 'move',
                    opacity: 0.7,
                    update: function() {
                        // Re-index items after sorting (not implementing this fully as it's complex to reindex inputs)
                        // This would need to update all hidden input names with new indexes
                    }
                });
            }
        });
    </script>
    
    <style type="text/css">
        .tour-gallery-wrapper {
            margin-bottom: 20px;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-gap: 15px;
            margin-bottom: 15px;
            min-height: 100px;
        }
        .gallery-grid.empty {
            border: 2px dashed #ddd;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .gallery-grid.empty:before {
            content: '<?php echo esc_js(__('No images selected. Click "Upload Images" to add.', 'bike-theme')); ?>';
            color: #999;
        }
        .gallery-item {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 3px;
            overflow: hidden;
            height: 150px;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-item-actions {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 0 0 0 3px;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .gallery-item:hover .gallery-item-actions {
            opacity: 1;
        }
        .gallery-item-remove {
            display: block;
            color: #fff;
            padding: 5px;
            line-height: 1;
        }
        .gallery-item-remove:hover {
            color: #f55;
        }
        .tour-gallery-actions {
            margin-top: 10px;
        }
        #tour-gallery-upload-button .dashicons {
            line-height: 1.4;
            margin-right: 5px;
        }
    </style>
    <?php
}

/**
 * Tour gallery content field callback
 */
function bike_theme_tour_gallery_content_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $content = isset($options[$id]) ? $options[$id] : $default;

    // If content is empty, provide a default template
    if (empty($content)) {
        $content = '';
    }

    // Output the WordPress editor
    wp_editor(
        $content,
        'bike_theme_options_tour_gallery_content',
        array(
            'textarea_name' => 'bike_theme_options[tour_gallery_content]',
            'media_buttons' => true,
            'textarea_rows' => 15,
            'editor_class'  => 'widefat',
            'teeny'         => false,
            'quicktags'     => true,
        )
    );

    echo '<p class="description">' . __('Use the editor above to create the content for the Tour Gallery.', 'bike-theme') . '</p>';
}

/**
 * Choose Your Adventure field callback
 */
function bike_theme_choose_your_adventure_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $content = isset($options[$id]) ? $options[$id] : $default;

    // If content is empty, provide a default template
    if (empty($content)) {
        $content = '';
    }

    // Output the WordPress editor
    wp_editor(
        $content,
        'bike_theme_options_choose_your_adventure',
        array(
            'textarea_name' => 'bike_theme_options[choose_your_adventure_content]',
            'media_buttons' => true,
            'textarea_rows' => 15,
            'editor_class'  => 'widefat',
            'teeny'         => false,
            'quicktags'     => true,
        )
    );
}

/**
 * Bike Rentals field callback
 */
function bike_theme_our_bikes_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $content = isset($options[$id]) ? $options[$id] : $default;

    // If content is empty, provide a default template
    if (empty($content)) {
        $content = '';
    }

    // Output the WordPress editor
    wp_editor(
        $content,
        'bike_theme_options_our_bikes',
        array(
            'textarea_name' => 'bike_theme_options[our_bikes_content]',
            'media_buttons' => true,
            'textarea_rows' => 15,
            'editor_class'  => 'widefat',
            'teeny'         => false,
            'quicktags'     => true,
        )
    );

    echo '<p class="description">' . __('Use the editor above to create the content for the Bike Rentals section.', 'bike-theme') . '</p>';
}

/**
 * Why Choose Us field callback
 */
function bike_theme_why_choose_us_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : '';
    $content = isset($options[$id]) ? $options[$id] : $default;

    // If content is empty, provide a default template
    if (empty($content)) {
        $content = '';
    }

    // Output the WordPress editor
    wp_editor(
        $content,
        'bike_theme_options_why_choose_us',
        array(
            'textarea_name' => 'bike_theme_options[why_choose_us_content]',
            'media_buttons' => true,
            'textarea_rows' => 15,
            'editor_class'  => 'widefat',
            'teeny'         => false,
            'quicktags'     => true,
        )
    );

    echo '<p class="description">' . __('Use the editor above to create the content for the Why Choose Us section.', 'bike-theme') . '</p>';
}

/**
 * Chi nhánh field callback
 */
function bike_theme_branches_callback($args)
{
    $options = get_option('bike_theme_options');
    $id = $args['id'];
    $default = isset($args['default']) ? $args['default'] : array();
    $branches = isset($options[$id]) ? $options[$id] : $default;

    // Nếu không có chi nhánh nào thì tạo một chi nhánh mặc định
    if (empty($branches)) {
        $old_address = isset($options['contact_address']) && !is_array($options['contact_address']) ? $options['contact_address'] : '';
        $old_link = isset($options['address_link']) ? $options['address_link'] : '';
        
        if (!empty($old_address)) {
            // Chuyển đổi từ dữ liệu cũ sang định dạng mới
            $branches[] = array(
                'name' => __('Main Office', 'bike-theme'),
                'address' => $old_address,
                'link' => $old_link,
                'opening_closed' => ''
            );
        } else {
            // Tạo chi nhánh mặc định nếu không có dữ liệu cũ
            $branches[] = array(
                'name' => __('Main Office', 'bike-theme'),
                'address' => '',
                'link' => '',
                'opening_closed' => ''
            );
        }
    }

    // Output field
    echo '<div id="bike-branches-container">';

    foreach ($branches as $index => $branch) {
        ?>
        <div class="bike-branch-item" data-index="<?php echo $index; ?>">
            <h3><?php esc_html_e('Branch', 'bike-theme'); ?> <span class="branch-number"><?php echo $index + 1; ?></span> 
                <span class="branch-controls">
                    <a href="#" class="branch-toggle"><?php esc_html_e('Toggle', 'bike-theme'); ?></a> | 
                    <a href="#" class="branch-remove"><?php esc_html_e('Remove', 'bike-theme'); ?></a>
                </span>
            </h3>
            <div class="branch-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_<?php echo $index; ?>_name">
                                <?php esc_html_e('Branch Name', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[contact_address][<?php echo $index; ?>][name]" 
                                type="text" 
                                id="bike_theme_options_contact_address_<?php echo $index; ?>_name" 
                                value="<?php echo esc_attr(isset($branch['name']) ? $branch['name'] : ''); ?>" 
                                class="regular-text">
                            <input type="hidden" 
                                name="bike_theme_options[contact_address][<?php echo $index; ?>][delete]" 
                                class="branch-delete-field" value="no">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_<?php echo $index; ?>_address">
                                <?php esc_html_e('Address', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <textarea name="bike_theme_options[contact_address][<?php echo $index; ?>][address]" 
                                id="bike_theme_options_contact_address_<?php echo $index; ?>_address" 
                                class="regular-text" rows="3"><?php echo esc_textarea(isset($branch['address']) ? $branch['address'] : ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_<?php echo $index; ?>_link">
                                <?php esc_html_e('Google Maps Link', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[contact_address][<?php echo $index; ?>][link]" 
                                type="url" 
                                id="bike_theme_options_contact_address_<?php echo $index; ?>_link" 
                                value="<?php echo esc_url(isset($branch['link']) ? $branch['link'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_<?php echo $index; ?>_link">
                                <?php esc_html_e('Opening/Closed', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[contact_address][<?php echo $index; ?>][opening_closed]" 
                                type="text" 
                                id="bike_theme_options_contact_address_<?php echo $index; ?>_opening_closed" 
                                value="<?php echo esc_url(isset($branch['opening_closed']) ? $branch['opening_closed'] : ''); ?>" 
                                class="regular-text">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }

    echo '</div>';

    echo '<p><button type="button" id="add-branch-button" class="button button-secondary">' .
        __('Add New Branch', 'bike-theme') . '</button></p>';

    // Template for new branches
    ?>
    <script type="text/template" id="branch-template">
        <div class="bike-branch-item" data-index="{{index}}">
            <h3><?php esc_html_e('Branch', 'bike-theme'); ?> <span class="branch-number">{{number}}</span> 
                <span class="branch-controls">
                    <a href="#" class="branch-toggle"><?php esc_html_e('Toggle', 'bike-theme'); ?></a> | 
                    <a href="#" class="branch-remove"><?php esc_html_e('Remove', 'bike-theme'); ?></a>
                </span>
            </h3>
            <div class="branch-content">
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_{{index}}_name">
                                <?php esc_html_e('Branch Name', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[contact_address][{{index}}][name]" 
                                type="text" 
                                id="bike_theme_options_contact_address_{{index}}_name" 
                                value="" 
                                class="regular-text">
                            <input type="hidden" 
                                name="bike_theme_options[contact_address][{{index}}][delete]" 
                                class="branch-delete-field" 
                                value="no">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_{{index}}_address">
                                <?php esc_html_e('Address', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <textarea name="bike_theme_options[contact_address][{{index}}][address]" 
                                id="bike_theme_options_contact_address_{{index}}_address" 
                                class="regular-text" rows="3"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_{{index}}_link">
                                <?php esc_html_e('Google Maps Link', 'bike-theme'); ?>
                            </label>
                        </th>
                        <td>
                            <input name="bike_theme_options[contact_address][{{index}}][link]" 
                                type="url" 
                                id="bike_theme_options_contact_address_{{index}}_link" 
                                value="" 
                                class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="bike_theme_options_contact_address_{{index}}_opening_closed">
                                <?php esc_html_e('Opening/Closed', 'bike-theme'); ?>
                            </label>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </script>
    <?php

    // Thêm JavaScript để xử lý thêm/xóa chi nhánh
    ?>
    <script>
        jQuery(document).ready(function($) {
            // Toggle branch content
            $(document).on('click', '.branch-toggle', function(e) {
                e.preventDefault();
                var $item = $(this).closest('.bike-branch-item');
                $item.find('.branch-content').slideToggle();
            });
            
            // Remove branch
            $(document).on('click', '.branch-remove', function(e) {
                e.preventDefault();
                if (confirm('<?php echo esc_js(__('Are you sure you want to remove this branch?', 'bike-theme')); ?>')) {
                    var $item = $(this).closest('.bike-branch-item');
                    $item.find('.branch-delete-field').val('yes');
                    $item.slideUp();
                }
            });
            
            // Add new branch
            var branchIndex = $('#bike-branches-container .bike-branch-item').length;
            $('#add-branch-button').on('click', function() {
                var template = $('#branch-template').html();
                var newBranch = template.replace(/\{\{index\}\}/g, branchIndex).replace(/\{\{number\}\}/g, branchIndex + 1);
                $('#bike-branches-container').append(newBranch);
                branchIndex++;
            });
            
            // Make branches sortable if jQuery UI is available
            if ($.fn.sortable) {
                $('#bike-branches-container').sortable({
                    handle: 'h3',
                    cursor: 'move',
                    update: function(event, ui) {
                        // Update branch numbers after sorting
                        $(this).find('.bike-branch-item').each(function(index) {
                            $(this).find('.branch-number').text(index + 1);
                        });
                    }
                });
            }
        });
    </script>
    <?php
}
