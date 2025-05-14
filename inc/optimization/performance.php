<?php
/**
 * Performance optimization functions
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove WordPress emoji script
 */
function bike_theme_disable_wp_emojicons() {
    // Remove emoji-related actions
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove emoji from TinyMCE
    add_filter('tiny_mce_plugins', 'bike_theme_disable_emojicons_tinymce');
}
add_action('init', 'bike_theme_disable_wp_emojicons');

/**
 * Remove emoji plugin from TinyMCE
 */
function bike_theme_disable_emojicons_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}

/**
 * Remove jQuery Migrate script in frontend
 */
function bike_theme_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'bike_theme_remove_jquery_migrate');

/**
 * Add defer attribute to non-critical scripts
 */
function bike_theme_defer_scripts($tag, $handle, $src) {
    // List of scripts to defer
    $defer_scripts = array(
        'bike-theme-wow',
        'bike-theme-easing',
        'bike-theme-waypoints',
        'bike-theme-counterup',
        'bike-theme-owl-carousel',
        'lazysizes',
        'lazysizes-plugins'
    );

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'bike_theme_defer_scripts', 10, 3);

/**
 * Remove query strings from static resources
 */
function bike_theme_remove_script_version($src) {
    // Exclude external resources
    if (strpos($src, home_url()) === false) {
        return $src;
    }
    
    $parts = explode('?', $src);
    return $parts[0];
}
// Uncomment these lines to enable removing query strings
// add_filter('script_loader_src', 'bike_theme_remove_script_version', 15, 1);
// add_filter('style_loader_src', 'bike_theme_remove_script_version', 15, 1);

/**
 * Add preload for critical assets
 */
function bike_theme_preload_assets() {
}
add_action('wp_head', 'bike_theme_preload_assets', 1);

/**
 * Add DNS prefetch for external domains
 */
function bike_theme_dns_prefetch() {
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">';
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
    echo '<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">';
    echo '<link rel="dns-prefetch" href="//cdn.jsdelivr.net">';
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">';
}
add_action('wp_head', 'bike_theme_dns_prefetch', 0); 