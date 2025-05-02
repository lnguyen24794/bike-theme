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
        <div class="container-fluid p-0">
            <?php include(get_template_directory() . '/template-parts/home/tour-gallery.php'); ?>
        </div>
        <!-- Gallery End -->

        <!-- Destinations Start -->
        <div class="container-fluid bg-primary p-0 py-5 my-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="section-title text-center text-dark text-uppercase"><?php esc_html_e('Choose Your Adventure', 'bike-theme'); ?></h3>
                    <div class="bike-tour-content mb-1"><?php echo esc_html(bike_theme_get_option('choose_your_adventure_content')); ?></div>
                </div>
                <?php include(get_template_directory() . '/template-parts/home/destination-slider.php'); ?>
                <div class="text-center mt-3">
                    <a href="/bike-tours" class="btn btn-dark py-3 px-5"><?php esc_html_e('View All Destinations', 'bike-theme'); ?></a>
                </div>
        </div>
        <!-- Destinations End -->

         <!-- Featured Bikes Start -->
         <div class="container-xxl">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Bike Rentals', 'bike-theme'); ?></h3>
                    <div class="bike-tour-content mb-1"><?php echo esc_html(bike_theme_get_option('our_bikes_content')); ?></div>
                </div>
                <?php include(get_template_directory() . '/template-parts/bikes.php'); ?>
        </div>
        <!-- Featured Bikes End -->

        <!-- Why Choose Us Start -->
        <?php include(get_template_directory() . '/template-parts/home/why-choose-us.php'); ?>
        <!-- Why Choose Us End -->

        <section class="bike-bottom">
            <div class="container">
                <div class="text-center">
                    <div class="bottom-cta">
                        <a href="/contact" >
                            <button class="btn btn-primary btn-chat"><i class="fas fa-phone"></i> <?php esc_html_e('Contact Us To Discuss Your Plans', 'bike-theme'); ?></button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php
    endif;
    ?>

</main><!-- #main -->

<?php
get_footer();
?>

