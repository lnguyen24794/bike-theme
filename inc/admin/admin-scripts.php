<?php
/**
 * Admin scripts and styles
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts for theme options page and wp-admin
 */
function bike_theme_admin_scripts($hook) {
    // Get current screen
    $screen = get_current_screen();
    
    // Enqueue media scripts
    wp_enqueue_media();

    // Enqueue admin script for all admin pages
    wp_enqueue_script(
        'bike-theme-admin-js',
        get_template_directory_uri() . '/assets/js/admin.js',
        array('jquery', 'jquery-ui-sortable'),
        BIKE_THEME_VERSION,
        true
    );

    // Enqueue admin styles for all admin pages
    wp_enqueue_style(
        'bike-theme-admin-css',
        get_template_directory_uri() . '/assets/css/admin.css',
        array(),
        BIKE_THEME_VERSION
    );

    // Localize script
    wp_localize_script('bike-theme-admin-js', 'bikeThemeAdmin', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bike_theme_admin_nonce'),
        'strings' => array(
            'confirmDelete' => __('Are you sure you want to delete this item?', 'bike-theme'),
            'uploadImage' => __('Choose Image', 'bike-theme'),
            'useImage' => __('Use this image', 'bike-theme')
        )
    ));
}
add_action('admin_enqueue_scripts', 'bike_theme_admin_scripts');

/**
 * Enqueue tour admin scripts
 */
function bike_theme_tour_admin_scripts($hook)
{
    global $post;

    // Only enqueue on tour edit screen
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if (isset($post) && $post->post_type === 'bike_tour') {
            // Enqueue tour admin CSS
            wp_enqueue_style('bike-theme-tour-admin', get_template_directory_uri() . '/assets/css/tour-admin.css', array(), '1.0.0');

            // Enqueue media library scripts
            wp_enqueue_media();
        }
    }
}
add_action('admin_enqueue_scripts', 'bike_theme_tour_admin_scripts'); 