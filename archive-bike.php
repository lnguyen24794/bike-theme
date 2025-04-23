<?php
/**
 * The template for displaying bike archive pages
 *
 * @package Bike_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
     <!-- Page Header Start -->
     <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bikes/tour-banner.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php esc_html_e('Bike Rentals', 'bike-theme'); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php esc_html_e('Bike Tours', 'bike-theme'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="container">
        <?php include(get_template_directory() . '/template-parts/bikes.php'); ?>
    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_footer();
