<?php
/**
 * Enqueue scripts and styles
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles.
 */
function bike_theme_scripts()
{
    // Enqueue custom fonts
    wp_enqueue_style('bike-theme-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), BIKE_THEME_VERSION);

    // Google Fonts
    wp_enqueue_style('bike-theme-google-fonts', 'https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap', array(), null);

    // Font Awesome
    wp_enqueue_style('bike-theme-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css', array(), '5.10.0');

    // Bootstrap Icons
    wp_enqueue_style('bike-theme-bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css', array(), '1.4.1');

    // Libraries CSS
    wp_enqueue_style('bike-theme-animate', get_template_directory_uri() . '/lib/animate/animate.min.css', array(), BIKE_THEME_VERSION);
    wp_enqueue_style('bike-theme-owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/assets/owl.carousel.min.css', array(), BIKE_THEME_VERSION);
    wp_enqueue_style('bike-theme-tempusdominus', get_template_directory_uri() . '/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css', array(), BIKE_THEME_VERSION);

    // Bootstrap
    wp_enqueue_style('bike-theme-bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.css', array(), BIKE_THEME_VERSION);

    // Theme Stylesheet
    wp_enqueue_style('bike-theme-style', get_stylesheet_uri(), array(), BIKE_THEME_VERSION);

    // Main Template Stylesheet
    wp_enqueue_style('bike-theme-main-style', get_template_directory_uri() . '/assets/css/style.css', array(), BIKE_THEME_VERSION);

    // Custom CSS
    wp_enqueue_style('bike-theme-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), BIKE_THEME_VERSION);

    // Deregister core jQuery and register newer version from CDN
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);
    wp_enqueue_script('jquery');

    // Bootstrap JS
    wp_enqueue_script('bike-theme-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.0.0', true);

    // Libraries JS
    wp_enqueue_script('bike-theme-wow', get_template_directory_uri() . '/lib/wow/wow.min.js', array('jquery'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-easing', get_template_directory_uri() . '/lib/easing/easing.min.js', array('jquery'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-waypoints', get_template_directory_uri() . '/lib/waypoints/waypoints.min.js', array('jquery'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-counterup', get_template_directory_uri() . '/lib/counterup/counterup.min.js', array('jquery'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js', array('jquery'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-moment', get_template_directory_uri() . '/lib/tempusdominus/js/moment.min.js', array('jquery'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-moment-timezone', get_template_directory_uri() . '/lib/tempusdominus/js/moment-timezone.min.js', array('jquery', 'bike-theme-moment'), BIKE_THEME_VERSION, true);
    wp_enqueue_script('bike-theme-tempusdominus', get_template_directory_uri() . '/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js', array('jquery', 'bike-theme-moment', 'bike-theme-moment-timezone'), BIKE_THEME_VERSION, true);

    // Navigation JS
    wp_enqueue_script('bike-theme-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), BIKE_THEME_VERSION, true);

    // Main JS
    wp_enqueue_script('bike-theme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), BIKE_THEME_VERSION, true);

    // Add lazysizes
    wp_enqueue_script('lazysizes', get_template_directory_uri() . '/assets/js/lazysizes.min.js', array(), '5.3.2', true);
    wp_enqueue_script('lazysizes-plugins', get_template_directory_uri() . '/assets/js/ls.unveilhooks.min.js', array('lazysizes'), '5.3.2', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bike_theme_scripts'); 