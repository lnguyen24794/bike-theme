<?php
/**
 * Template part for displaying tour add-ons
 *
 * @package Bike_Theme
 */

// Get tour add-ons content
$tour_add_ons = get_post_meta(get_the_ID(), '_tour_add_ons', true);
?>

<div class="w-100 py-3" id="add-ons">
    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Add-ons', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
        <div class="tour-add-ons wp-editor-content mt-4">
            <?php if (!empty($tour_add_ons)) : ?>
                <?php echo wp_kses_post($tour_add_ons); ?>
            <?php else : ?>
                <p class="text-muted"><?php esc_html_e('No add-ons information available for this tour.', 'bike-theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
