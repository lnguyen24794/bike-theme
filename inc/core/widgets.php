<?php
/**
 * Register widget areas and custom widgets
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register widget area.
 */
function bike_theme_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'bike-theme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'bike-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Footer 1', 'bike-theme'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Add footer widgets here.', 'bike-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Footer 2', 'bike-theme'),
            'id'            => 'footer-2',
            'description'   => esc_html__('Add footer widgets here.', 'bike-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Footer 3', 'bike-theme'),
            'id'            => 'footer-3',
            'description'   => esc_html__('Add footer widgets here.', 'bike-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'bike_theme_widgets_init');

/**
 * Register additional widget areas
 */
function bike_theme_additional_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Footer 4', 'bike-theme'),
            'id'            => 'footer-4',
            'description'   => esc_html__('Add footer newsletter widgets here.', 'bike-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Home Page Widgets', 'bike-theme'),
            'id'            => 'home-widgets',
            'description'   => esc_html__('Add widgets for home page.', 'bike-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'bike_theme_additional_widgets_init'); 