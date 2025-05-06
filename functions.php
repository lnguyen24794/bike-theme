<?php

/**
 * Bike Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bike_Theme
 */

if (! defined('BIKE_THEME_VERSION')) {
    define('BIKE_THEME_VERSION', '1.0.19');
}

/**
 * Define theme constants
 */
define('BIKE_THEME_DIR', get_template_directory());
define('BIKE_THEME_URI', get_template_directory_uri());
define('BIKE_THEME_INC_DIR', BIKE_THEME_DIR . '/inc');

/**
 * Load core functionality
 */
require_once BIKE_THEME_INC_DIR . '/core/setup.php';
require_once BIKE_THEME_INC_DIR . '/core/widgets.php';
require_once BIKE_THEME_INC_DIR . '/core/scripts.php';

/**
 * Load Custom Post Types and Taxonomies
 */
require_once BIKE_THEME_INC_DIR . '/post-types/bikes.php';
require_once BIKE_THEME_INC_DIR . '/post-types/tours.php';
require_once BIKE_THEME_INC_DIR . '/post-types/bookings.php';
require_once BIKE_THEME_INC_DIR . '/taxonomies/destinations.php';

/**7
 * Load admin components
 */
require_once BIKE_THEME_INC_DIR . '/admin/options-page.php';
require_once BIKE_THEME_INC_DIR . '/admin/meta-boxes.php';
require_once BIKE_THEME_INC_DIR . '/admin/admin-scripts.php';
require_once BIKE_THEME_INC_DIR . '/admin/customizer.php';

/**
 * Load frontend components
 */
require_once BIKE_THEME_INC_DIR . '/frontend/template-tags.php';
require_once BIKE_THEME_INC_DIR . '/frontend/helpers.php';

/**
 * Load contact components
 */
require_once BIKE_THEME_INC_DIR . '/contact/request.php';

/**
 * Load booking system
 */
require_once BIKE_THEME_INC_DIR . '/booking/pricing.php';
require_once BIKE_THEME_INC_DIR . '/booking/process.php';
require_once BIKE_THEME_INC_DIR . '/booking/form-handlers.php';

/**
 * Load optimization components
 */
require_once BIKE_THEME_INC_DIR . '/optimization/lazy-loading.php';
require_once BIKE_THEME_INC_DIR . '/optimization/performance.php';

/**
 * Include NavWalker
 */
require_once BIKE_THEME_DIR . '/includes/class-wp-bootstrap-navwalker.php';
