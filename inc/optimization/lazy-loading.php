<?php
/**
 * Lazy loading optimization
 *
 * @package Bike_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add lazyload classes and data attributes to images and iframes
 */
function bike_theme_add_lazy_loading_attribute($content)
{
    if (!$content || is_admin()) {
        return $content;
    }

    // Replace img tags
    $content = preg_replace_callback('/<img([^>]+)>/i', function ($matches) {
        $img_tag = $matches[0];
        $attributes = $matches[1];

        // Don't lazy load images in certain situations
        if (strpos($attributes, 'data-no-lazy') !== false ||
            strpos($attributes, 'skip-lazy') !== false ||
            strpos($attributes, 'class="unlazy"') !== false ||
            strpos($attributes, 'class="') !== false && strpos($attributes, 'unlazy') !== false) {
            return $img_tag;
        }

        // Add lazyload class
        if (strpos($attributes, 'class="') !== false) {
            $attributes = preg_replace('/class="([^"]*)"/', 'class="$1 lazyload"', $attributes);
        } else {
            $attributes .= ' class="lazyload"';
        }

        // Convert src to data-src
        $attributes = str_replace(' src=', ' data-src=', $attributes);

        // Add blur-up effect with low quality placeholder
        if (strpos($attributes, 'data-src="') !== false) {
            preg_match('/data-src="([^"]*)"/', $attributes, $src_matches);
            if (!empty($src_matches[1])) {
                $low_quality = bike_theme_get_low_quality_placeholder($src_matches[1]);
                $attributes .= ' src="' . $low_quality . '"';
            }
        }

        return '<img' . $attributes . '>';
    }, $content);

    // Replace iframe tags
    $content = preg_replace_callback('/<iframe([^>]+)>/i', function ($matches) {
        $iframe_tag = $matches[0];
        $attributes = $matches[1];

        // Don't lazy load iframes in certain situations
        if (strpos($attributes, 'data-no-lazy') !== false ||
            strpos($attributes, 'skip-lazy') !== false ||
            strpos($attributes, 'class="unlazy"') !== false ||
            strpos($attributes, 'class="') !== false && strpos($attributes, 'unlazy') !== false) {
            return $iframe_tag;
        }

        // Add lazyload class
        if (strpos($attributes, 'class="') !== false) {
            $attributes = preg_replace('/class="([^"]*)"/', 'class="$1 lazyload"', $attributes);
        } else {
            $attributes .= ' class="lazyload"';
        }

        // Convert src to data-src
        $attributes = str_replace(' src=', ' data-src=', $attributes);

        return '<iframe' . $attributes . '>';
    }, $content);

    return $content;
}
add_filter('the_content', 'bike_theme_add_lazy_loading_attribute');
add_filter('post_thumbnail_html', 'bike_theme_add_lazy_loading_attribute');
add_filter('get_avatar', 'bike_theme_add_lazy_loading_attribute');

/**
 * Add lazy-image-container class to post thumbnails
 */
function bike_theme_lazy_loading_thumbnail_class($attr)
{
    if (!isset($attr['class'])) {
        $attr['class'] = 'lazy-image-container';
    } else {
        $attr['class'] .= ' lazy-image-container';
    }

    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'bike_theme_lazy_loading_thumbnail_class');

/**
 * Generate low quality placeholder image
 */
function bike_theme_get_low_quality_placeholder($image_url)
{
    if (empty($image_url)) {
        return '';
    }

    $image_id = attachment_url_to_postid($image_url);
    if (!$image_id) {
        return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E";
    }

    $thumb = wp_get_attachment_image_src($image_id, array(60, 60));
    return !empty($thumb[0]) ? $thumb[0] : '';
} 