<?php
/**
 * Template part for displaying Why Choose Us section
 *
 * @package Bike_Theme
 */

// Lấy nội dung từ theme options
$why_choose_us_content = bike_theme_get_option('why_choose_us_content', '');

// Nếu không có nội dung thì thoát
if (empty($why_choose_us_content)) {
    return;
}
?>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Why Choose Us', 'bike-theme'); ?></h6>
            <h2 class="mb-3"><?php esc_html_e('Discover the Bike Tour Experience', 'bike-theme'); ?></h2>
        </div>
        
        <?php echo wp_kses_post($why_choose_us_content); ?>
    </div>
</div> 