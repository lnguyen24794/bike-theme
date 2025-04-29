<?php
/**
 * Template Name: Bike Rentals Page
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
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php esc_html_e('Our Bike Rentals', 'bike-theme'); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php esc_html_e('Bike Rentals', 'bike-theme'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Tours Start -->
    <div class="container-xxl py-5 pb-0">
        <div class="row">
            <div class="col-md-12">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
 <!-- Featured Bikes Start -->
 <div class="container-xxl py-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Bike Rentals', 'bike-theme'); ?></h3>
            <div class="mb-1"><?php echo wp_kses_post(bike_theme_get_option('our_bikes_content')); ?></div>
        </div>
        <?php include(get_template_directory() . '/template-parts/bikes.php'); ?>
    </div>
</main><!-- #main -->

<?php
get_footer();
?> 