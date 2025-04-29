<?php
/**
 * Template Name: Vietnam Multi-Day Tours Page
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
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php esc_html_e('Vietnam Multi-Day Tours', 'bike-theme'); ?></h1>
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
    <!-- Tours Start -->
    <div class="container-xxl py-5">
            <?php include(get_template_directory() . '/template-parts/home/destination-slider.php'); ?>
        </div>
        <!-- Tours End -->
</main><!-- #main -->

<?php
get_footer();
?> 