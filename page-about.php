<?php
/**
 * Template Name: About Page
 *
 * @package Bike_Theme
 */

get_header();
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main id="primary" class="site-main">
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php echo esc_url($featured_image); ?>);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php esc_html_e('About Us', 'bike-theme'); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php esc_html_e('About Us', 'bike-theme'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="section-title text-start text-primary text-uppercase"><?php esc_html_e('About Us', 'bike-theme'); ?></h6>
                    <h1 class="mb-4"><?php echo wp_kses_post(__('Welcome to <span class="text-primary">BeeBikeHub</span>', 'bike-theme')); ?></h1>
                    <div><?php the_content(); ?></div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="/contact"><?php esc_html_e('Contact Us', 'bike-theme'); ?></a>
                </div>
                <div class="col-lg-6">
                        <div class="row">
                            <?php
                            // Get all about slides from options
                            $options = get_option('bike_theme_options', array());
                            $about_slides = isset($options['about_slides']) ? $options['about_slides'] : array();

                            // If no slides found, create default ones
                            if (empty($about_slides)) {
                                $about_slides = array(
                                    array(
                                        'image_id' => 0,
                                        'image_url' => get_template_directory_uri() . '/assets/images/bikes/about-1.jpg',
                                        'active' => 1
                                    ),
                                    array(
                                        'image_id' => 0,
                                        'image_url' => get_template_directory_uri() . '/assets/images/bikes/about-2.jpg',
                                        'active' => 1
                                    ),
                                    array(
                                        'image_id' => 0,
                                        'image_url' => get_template_directory_uri() . '/assets/images/bikes/about-3.jpg',
                                        'active' => 1
                                    ),
                                    array(
                                        'image_id' => 0,
                                        'image_url' => get_template_directory_uri() . '/assets/images/bikes/about-4.jpg',
                                        'active' => 1
                                    )
                                );
                            }

                            $active_slides = 0;
                            $positions = array(
                                array('text-end', 'w-75', '25%', '0.1s'),
                                array('text-start', 'w-100', '0', '0.3s'),
                                array('text-end', 'w-50', '0', '0.5s'),
                                array('text-start', 'w-75', '0', '0.7s')
                            );

                            foreach ($about_slides as $index => $slide) :
                                // Skip inactive slides
                                if (empty($slide['active']) || $active_slides >= 4) {
                                    continue;
                                }

                                // Set image URL (use default if empty)
                                $image_url = !empty($slide['image_url']) ? $slide['image_url'] : get_template_directory_uri() . '/assets/images/bikes/about-' . ($index + 1) . '.jpg';

                                // Get position settings
                                $position = $positions[$active_slides];
                                ?>
                                                            <div class="col-6 <?php echo $position[0]; ?>">
                                                                <img class="img-fluid rounded <?php echo $position[1]; ?> wow zoomIn" 
                                                                    data-wow-delay="<?php echo $position[3]; ?>" 
                                                                    src="<?php echo esc_url($image_url); ?>" 
                                                                    <?php if ($position[2] !== '0') : ?>
                                                                    style="margin-top: <?php echo $position[2]; ?>"
                                                                    <?php endif; ?>>
                                                            </div>
                                                        <?php
                                    $active_slides++;
                            endforeach;

                            // If no active slides were found, display defaults
                            if ($active_slides == 0) :
                                foreach ($positions as $index => $position) :
                                    $default_image = get_template_directory_uri() . '/assets/images/bikes/about-' . ($index + 1) . '.jpg';
                                    ?>
                                                                <div class="col-6 <?php echo $position[0]; ?>">
                                                                    <img class="img-fluid rounded <?php echo $position[1]; ?> wow zoomIn" 
                                                                        data-wow-delay="<?php echo $position[3]; ?>" 
                                                                        src="<?php echo esc_url($default_image); ?>"
                                                                        <?php if ($position[2] !== '0') : ?>
                                                                        style="margin-top: <?php echo $position[2]; ?>"
                                                                        <?php endif; ?>>
                                                                </div>
                                                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
            </div>
    </div>
    <!-- About End -->

    <!-- Team Start -->
    <div class="container-xxl py-5 unlazy">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Our Reviews', 'bike-theme'); ?></h3>
            <h1 class="mb-5"><?php esc_html_e('What Our Customers Say', 'bike-theme'); ?></h1>
        </div>
        <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
    </div>
    <!-- Team End -->
</main><!-- #main -->

<?php
get_footer();
?> 