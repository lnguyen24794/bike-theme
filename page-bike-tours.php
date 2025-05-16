<?php
/**
 * The template for displaying bike tour archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('bike-theme-tour-archive', get_template_directory_uri() . '/assets/css/tour-archive.css', array(), BIKE_THEME_VERSION);
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main id="primary" class="site-main">
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php  echo esc_url($featured_image); ?>">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php esc_html_e('Our Bike Tours', 'bike-theme'); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php esc_html_e('Bike Tours', 'bike-theme'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="w-100">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Choose Your Adventure', 'bike-theme'); ?></h3>
                </div>
                <div class="bike-tour-content mb-3"><?php echo get_the_content(); ?></div>
            </div>
            <div class="container-fluid bg-primary pt-3 pb-3 text-center" style="margin-top: -10px;">
                    <h5>Hop on a bike, slow down, and experience the real Vietnam in the most meaningful way — by cycling!</h5>
                    <?php include(get_template_directory() . '/template-parts/home/destination-slider.php'); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?> 