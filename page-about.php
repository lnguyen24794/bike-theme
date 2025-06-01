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
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('About Us', 'bike-theme'); ?></h3>
            <h1 class="mb-4"><?php echo wp_kses_post(__('Welcome to <span class="text-primary">BeeBikeHub</span>', 'bike-theme')); ?></h1>
            <div clas="wp-editor-content"><?php the_content(); ?></div>
            <a class="btn btn-primary py-3 px-5 mt-2" href="/contact"><?php esc_html_e('Contact Us', 'bike-theme'); ?></a>
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