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
        __('Bike Theme', 'bike-theme'),
        'manage_options',
        'bike-theme-options',
        'bike_theme_render_options_page',
        'dashicons-admin-generic',
        59
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

    // Booking Section
    add_settings_section(
        'bike_theme_booking_section',
        __('Booking Settings', 'bike-theme'),
        'bike_theme_booking_section_callback',
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
        'contact_address',
        __('Address', 'bike-theme'),
        'bike_theme_textarea_field_callback',
        'bike-theme-options',
        'bike_theme_contact_section',
        array(
            'id' => 'contact_address',
            'default' => ''
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
            } elseif (in_array($key, array('contact_address', 'bank_account_info', 'email_footer'))) {
                $output[$key] = wp_kses_post($input[$key]);
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
    
    <script>
        jQuery(document).ready(function($) {
            $('.bike-theme-color-field').wpColorPicker();
        });
    </script>
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
}
add_action('admin_enqueue_scripts', 'bike_theme_options_scripts');

/**
 * Get option helper function
 */
function bike_theme_get_option($key, $default = '')
{
    $options = get_option('bike_theme_options');
    return isset($options[$key]) ? $options[$key] : $default;
} 