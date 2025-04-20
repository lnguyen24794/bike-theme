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
        <div class="container-fluid p-0 mb-5">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" >
                    <?php
                    // Get all slides from options
                    $slides = get_option('bike_theme_slides', array());

                    $active_slides = 0;
                    $found_active = false;

                    foreach ($slides as $index => $slide) :
                        // Skip inactive slides
                        if (empty($slide['active'])) {
                            continue;
                        }

                        $active_slides++;

                        // Set image URL (use default if empty)
                        $image_url = !empty($slide['image_url']) ? $slide['image_url'] : get_template_directory_uri() . '/assets/images/bikes/hero-' . ($index % 3 + 1) . '.jpg';

                        // Get text values with defaults
                        $subtitle = !empty($slide['subtitle']) ? $slide['subtitle'] : '';
                        $title = !empty($slide['title']) ? $slide['title'] : '';
                        $btn1_text = !empty($slide['btn1_text']) ? $slide['btn1_text'] : '';
                        $btn1_url = !empty($slide['btn1_url']) ? $slide['btn1_url'] : '';
                        $btn2_text = !empty($slide['btn2_text']) ? $slide['btn2_text'] : '';
                        $btn2_url = !empty($slide['btn2_url']) ? $slide['btn2_url'] : '';
                        $slogan = !empty($slide['slogan']) ? $slide['slogan'] : '';

                        // Set first active slide as active
                        $is_active = false;
                        if (!$found_active) {
                            $is_active = true;
                            $found_active = true;
                        }
                        ?>
                        <div class="carousel-item <?php echo $is_active ? 'active' : ''; ?>" style="height: 100vh !important;">
                            <img class="w-100" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center" style="height: 100vh !important;">
                                <div class="p-3" style="max-width: 700px; padding-top: 200px !important;">
                                    <?php if (!empty($title)) : ?>
                                        <h1 class="section-title text-white mb-4 animated slideInDown"><?php echo esc_html($title); ?></h1>
                                    <?php endif; ?>
                                    <?php if (!empty($subtitle)) : ?>
                                        <p class=" text-white text-size-medium mb-3 animated slideInDown"><?php echo esc_html($subtitle); ?></p>
                                    <?php endif; ?>
                                   
                                    <?php if (!empty($btn1_text)) : ?>
                                    <a href="<?php echo esc_url($btn1_url); ?>" class="btn btn-primary py-md-2 px-md-4 me-3 animated slideInLeft"><?php echo esc_html($btn1_text); ?></a>
                                    <?php endif; ?>
                                    <?php if (!empty($btn2_text)) : ?>
                                    <a href="<?php echo esc_url($btn2_url); ?>" class="btn btn-light py-md-2 px-md-4 animated slideInRight"><?php echo esc_html($btn2_text); ?></a>
                                    <?php endif; ?>
                                    <?php if (!empty($slogan)) : ?>
                                        <p class="text-primary p-4 text-size-large"><i class="fa fa-quote-left pr-2"></i> <i><?php echo esc_html($slogan); ?></i> <i class="fa fa-quote-right pl-2"></i>   </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
                
            </div>
        </div>
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
                    <h2 class="mb-1"><?php echo wp_kses_post(__('Explore Our <span class="text-primary text-uppercase">Bikes</span>', 'bike-theme')); ?></h2>
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

