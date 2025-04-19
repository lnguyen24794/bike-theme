<?php
/**
 * Customizer settings for theme
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add additional theme options to the Theme Customizer
 */
function bike_theme_additional_options($wp_customize)
{
    // Add Home Page Options Section
    $wp_customize->add_section('bike_theme_home_options', array(
        'title'    => __('Home Page Options', 'bike-theme'),
        'priority' => 130,
    ));

    // Carousel Settings
    $wp_customize->add_setting('bike_theme_carousel_show', array(
        'default'           => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_carousel_show', array(
        'label'    => __('Show Carousel', 'bike-theme'),
        'section'  => 'bike_theme_home_options',
        'type'     => 'checkbox',
    ));

    // About Section Settings
    $wp_customize->add_setting('bike_theme_about_show', array(
        'default'           => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_about_show', array(
        'label'    => __('Show About Section', 'bike-theme'),
        'section'  => 'bike_theme_home_options',
        'type'     => 'checkbox',
    ));

    // Featured Bikes Section Settings
    $wp_customize->add_setting('bike_theme_featured_bikes_show', array(
        'default'           => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_featured_bikes_show', array(
        'label'    => __('Show Featured Bikes Section', 'bike-theme'),
        'section'  => 'bike_theme_home_options',
        'type'     => 'checkbox',
    ));

    // Contact Page
    $wp_customize->add_setting('bike_theme_contact_page', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('bike_theme_contact_page', array(
        'label'    => __('Contact Page', 'bike-theme'),
        'section'  => 'bike_theme_home_options',
        'type'     => 'dropdown-pages',
    ));

    // Address Setting
    $wp_customize->add_setting('bike_theme_address', array(
        'default'           => '123 Street, New York, USA',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_address', array(
        'label'    => __('Address', 'bike-theme'),
        'section'  => 'title_tagline',
        'type'     => 'text',
    ));

    // Opening Hours Setting
    $wp_customize->add_setting('bike_theme_hours', array(
        'default'           => 'Mon - Fri : 09.00 AM - 06.00 PM',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_hours', array(
        'label'    => __('Opening Hours', 'bike-theme'),
        'section'  => 'title_tagline',
        'type'     => 'text',
    ));

    // Currency Settings
    $wp_customize->add_setting('bike_theme_currency', array(
        'default'           => '$',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_currency', array(
        'label'    => __('Currency', 'bike-theme'),
        'section'  => 'title_tagline',
        'type'     => 'select',
        'choices'  => array(
            'VNĐ' => 'VNĐ',
            '$'   => '$',
        ),
    ));

    $wp_customize->add_setting('bike_theme_currency_position', array(
        'default'           => 'after',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('bike_theme_currency_position', array(
        'label'    => __('Currency Position', 'bike-theme'),
        'section'  => 'title_tagline',
        'type'     => 'radio',
        'choices'  => array(
            'before' => __('Before price ($100)', 'bike-theme'),
            'after'  => __('After price (100 VNĐ)', 'bike-theme'),
        ),
    ));
}
add_action('customize_register', 'bike_theme_additional_options'); 