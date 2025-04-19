<?php
/**
 * Setup theme defaults and registers support for various WordPress features.
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function bike_theme_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register menu locations
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary Menu', 'bike-theme'),
            'footer' => esc_html__('Footer Menu', 'bike-theme'),
        )
    );

    // Switch default core markup to output valid HTML5.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'bike_theme_setup');

/**
 * Set the content width in pixels.
 */
function bike_theme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('bike_theme_content_width', 1200);
}
add_action('after_setup_theme', 'bike_theme_content_width', 0);

/**
 * Add custom CSS class to body
 */
function bike_theme_body_classes($classes)
{
    // Add a class for the bike single page
    if (is_singular('bike')) {
        $classes[] = 'single-bike-page';
    }

    // Add a class for the bike archive page
    if (is_post_type_archive('bike') || is_tax('bike_category') || is_tax('bike_brand')) {
        $classes[] = 'bike-archive-page';
    }

    return $classes;
}
add_filter('body_class', 'bike_theme_body_classes'); 