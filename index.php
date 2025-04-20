<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * Template Name: Home Page
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), '2.3.4');
wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '2.3.4', true);

?>

<main id="primary" class="site-main">

    <?php
    if (is_front_page()) :
        // Display homepage content
        ?>

        <!-- Hero Banner Start -->
        <?php include(get_template_directory() . '/template-parts/home/hero-banner.php'); ?>
        <!-- Hero Banner End -->

        <!-- Gallery Start -->
        <div class="container-fluid p-0 py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Our Gallery', 'bike-theme'); ?></h6>
                <h2 class="mb-1"><?php esc_html_e('Vietnam Cycling Tours', 'bike-theme'); ?></h2>
            </div>
            <?php include(get_template_directory() . '/template-parts/home/tour-gallery.php'); ?>
        </div>
        <!-- Gallery End -->

        <!-- Tour Categories Start -->
         <div class="container-fluid bg-light p-0 py-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Tour Collection', 'bike-theme'); ?></h6>
                    <h2 class="mb-1"><?php esc_html_e('Choose Your Adventure', 'bike-theme'); ?></h2>
                </div>
                <?php include(get_template_directory() . '/template-parts/home/tour-collection.php'); ?>
        </div>
        <!-- Tour Categories End -->

        <!-- Destinations Start -->
        <div class="container-fluid p-0 py-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Explore Destinations', 'bike-theme'); ?></h6>
                    <h2 class="mb-1"><?php esc_html_e('Where Do You Want to Ride?', 'bike-theme'); ?></h2>
                </div>
                <?php include(get_template_directory() . '/template-parts/home/destination-slider.php'); ?>
                <div class="text-center mt-5">
                    <a href="<?php echo esc_url(get_post_type_archive_link('bike_tour')); ?>" class="btn btn-primary py-3 px-5"><?php esc_html_e('View All Destinations', 'bike-theme'); ?></a>
                </div>
        </div>
        <!-- Destinations End -->

         <!-- Featured Bikes Start -->
         <div class="container-xxl py-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Our Bikes', 'bike-theme'); ?></h6>
                    <h2 class="mb-3"><?php echo wp_kses_post(__('Explore Our <span class="text-primary text-uppercase">Bikes</span>', 'bike-theme')); ?></h2>
                </div>
                <?php include(get_template_directory() . '/template-parts/bikes.php'); ?>
        </div>
        <!-- Featured Bikes End -->

        <!-- Why Choose Us Start -->
        <?php include(get_template_directory() . '/template-parts/home/why-choose-us.php'); ?>
        <!-- Why Choose Us End -->
    <?php
    endif;
    ?>

</main><!-- #main -->

<?php
get_footer();
?>

