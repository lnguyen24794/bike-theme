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
                
                <?php
                // Only show controls if we have more than one active slide
                if ($active_slides > 1) :
                    ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"><?php esc_html_e('Previous', 'bike-theme'); ?></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"><?php esc_html_e('Next', 'bike-theme'); ?></span>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <!-- Hero Banner End -->

        <!-- Gallery Start -->
        <div class="container-fluid p-0 py-5">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Our Gallery', 'bike-theme'); ?></h6>
                <h2 class="mb-5"><?php esc_html_e('Vietnam Cycling Tours', 'bike-theme'); ?></h2>
            </div>
            <?php include(get_template_directory() . '/template-parts/home/about-slider.php'); ?>
        </div>
        <!-- Gallery End -->

        <!-- Destinations Start -->
        <div class="container-fluid p-0 py-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Explore Destinations', 'bike-theme'); ?></h6>
                    <h2 class="mb-5"><?php esc_html_e('Where Do You Want to Ride?', 'bike-theme'); ?></h2>
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
                    <h2 class="mb-5"><?php echo wp_kses_post(__('Explore Our <span class="text-primary text-uppercase">Bikes</span>', 'bike-theme')); ?></h2>
                </div>
                <?php include(get_template_directory() . '/template-parts/bikes.php'); ?>
        </div>
        <!-- Featured Bikes End -->

        <!-- Service Start -->
        <div class="container-xxl py-5">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Our Services', 'bike-theme'); ?></h6>
                    <h2 class="mb-5"><?php echo wp_kses_post(__('Explore Our <span class="text-primary text-uppercase">Services</span>', 'bike-theme')); ?></h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a class="service-item rounded" href="<?php echo esc_url(home_url('/services/city-tours')); ?>">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-city fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php esc_html_e('City Tours', 'bike-theme'); ?></h5>
                            <p class="text-body mb-0"><?php esc_html_e('Explore the city by bike with specially designed tours that allow you to fully enjoy local scenery and culture.', 'bike-theme'); ?></p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <a class="service-item rounded" href="<?php echo esc_url(home_url('/services/mountain-biking')); ?>">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-mountain fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php esc_html_e('Mountain Biking', 'bike-theme'); ?></h5>
                            <p class="text-body mb-0"><?php esc_html_e('Experience challenging trails with high-quality mountain bikes, suitable for all rider skill levels.', 'bike-theme'); ?></p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a class="service-item rounded" href="<?php echo esc_url(home_url('/services/countryside-tours')); ?>">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-tree fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php esc_html_e('Countryside Tours', 'bike-theme'); ?></h5>
                            <p class="text-body mb-0"><?php esc_html_e('Discover the beauty of Vietnam\'s countryside through peaceful village roads and meet local residents.', 'bike-theme'); ?></p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <a class="service-item rounded" href="<?php echo esc_url(home_url('/services/bike-rental')); ?>">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-bicycle fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php esc_html_e('Bike Rentals', 'bike-theme'); ?></h5>
                            <p class="text-body mb-0"><?php esc_html_e('High-quality bicycles for rent, from road bikes to mountain bikes, racing bikes, and electric bikes.', 'bike-theme'); ?></p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <a class="service-item rounded" href="<?php echo esc_url(home_url('/services/multi-day-tours')); ?>">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-route fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php esc_html_e('Multi-Day Tours', 'bike-theme'); ?></h5>
                            <p class="text-body mb-0"><?php esc_html_e('Long-day expeditions across beautiful landscapes with comfortable accommodations at each stop.', 'bike-theme'); ?></p>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <a class="service-item rounded" href="<?php echo esc_url(home_url('/services/customized-tours')); ?>">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-map-marked-alt fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3"><?php esc_html_e('Customized Tours', 'bike-theme'); ?></h5>
                            <p class="text-body mb-0"><?php esc_html_e('Create your own journey with support from our experts, tailored to your preferences and skill level.', 'bike-theme'); ?></p>
                        </a>
                    </div>
                </div>
        </div>
        <!-- Service End -->

        <!-- Video Modal Start -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php esc_html_e('Sapa - Mai Chau Cycling Tour', 'bike-theme'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'bike-theme'); ?>"></button>
                    </div>
                    <div class="modal-body">
                        <!-- 16:9 aspect ratio -->
                        <div class="ratio ratio-16x9">
                            <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                                allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Video Modal End -->

    <?php
    else :
        // Display standard content for blog pages
        if (have_posts()) :
            /* Start the Loop */
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', get_post_type());
            endwhile;

            the_posts_navigation();
        else :
            get_template_part('template-parts/content', 'none');
        endif;
    endif;
?>

</main><!-- #main -->

<?php
get_footer();
?>

